<?php



class discountCodes extends clientAuth
{
    #region __construct
    public function __construct() {
        parent::__construct();

    }
    #endregion

    #region ListAll: list of all discount codes and count of used
    public function ListAll() {
        $Model = Load::library('Model');

        $sqlCodes = "SELECT *, 
                    (SELECT COUNT(id) FROM discount_codes_used_tb WHERE discountCode = discount_codes_tb.code AND status = 'success') AS used,
                    COUNT(id) AS groupStock  
                    FROM discount_codes_tb GROUP BY groupCode ORDER BY id DESC";
        $resultSelect = $Model->select($sqlCodes);

        return $resultSelect;
    }
    #endregion

    #region ShowInfoForEdit: one specified record of discount codes to edit
    public function ShowInfoForEdit($param) {
        $Model = Load::library('Model');
        $param = filter_var($param, FILTER_VALIDATE_INT);

        $sqlCode = "SELECT *, " .
            " COUNT(id) AS groupStock " .
            " FROM discount_codes_tb WHERE groupCode = '{$param}' GROUP BY groupCode";
        return $Model->load($sqlCode);
    }
    #endregion

    #region generateGroupCode
    public function generateGroupCode() {
        $Model = Load::library('Model');

        $query = "SELECT COALESCE(MAX(groupCode), 0) + 1 AS groupCode FROM discount_codes_tb";
        $result = $Model->load($query);

        return $result['groupCode'];
    }
    #endregion

    #region DiscountCodesAdd: add a discount code
    public function DiscountCodesAdd($param) {

        $isGroup = false;
        $insertTimes = 1;
        if (!empty($param['RandomCheck']) && $param['RandomCheck'] == '1') {
            $isGroup = true;
            $insertTimes = filter_var($param['Stock'], FILTER_VALIDATE_INT);
        }

        $selectedServices = $this->setDiscountService($param);


        $explodeStartDate = explode('-', filter_var($param['StartDate'], FILTER_SANITIZE_STRING));
        $jmkStartDate = dateTimeSetting::jmktime(0, 0, 0, $explodeStartDate[1], $explodeStartDate[2], $explodeStartDate[0]);

        $explodeEndDate = explode('-', filter_var($param['EndDate'], FILTER_SANITIZE_STRING));
        $jmkEndDate = dateTimeSetting::jmktime(0, 0, 0, $explodeEndDate[1], $explodeEndDate[2], $explodeEndDate[0]);

        $data['title'] = filter_var($param['Title'], FILTER_SANITIZE_STRING);
        $data['amount'] = filter_var($param['Amount'], FILTER_VALIDATE_INT);
        $data['stock'] = (!$isGroup ? filter_var($param['Stock'], FILTER_VALIDATE_INT) : '1');
        $data['startDateInt'] = $jmkStartDate;
        $data['endDateInt'] = $jmkEndDate;
        $data['preCode'] = filter_var($param['PreCode'], FILTER_SANITIZE_STRING);
        $data['is_allow_counter'] = isset($param['is_allow_counter']) ? $param['is_allow_counter'] : 0;
        $data['is_consume'] = isset($param['is_consume']) ? $param['is_consume'] : 0;
        $data['limit_point_club'] = isset($param['limit_point_club']) ? $param['limit_point_club'] : 0;
        $data['isGroup'] = (!$isGroup ? 'no' : 'yes');
        $data['groupCode'] = $this->generateGroupCode();
        $data['isActive'] = 'yes';
        $data['creationDateInt'] = time();


        for ($i = 0; $i < $insertTimes; $i++) {
            $data['code'] = $data['preCode'] . functions::generateRandomCode(7);
            $resultInsert = $this->getModel('discountCodesModel')->insertLocal($data);
        }


        if ($resultInsert) {
            $resultParent = $this->getModel('discountCodesModel')->get(['groupCode'], true)->where('title', $data['title'])->where('creationDateInt', $data['creationDateInt'])->find();

            foreach ($selectedServices as $service) {

                $dataServices['discountGroupCode'] = $resultParent['groupCode'];
                $dataServices['serviceTitle'] = $service;
                $dataServices['service_group'] = $this->getServiceDiscountGroupTitle($service);

                $this->getModel('discountCodesServicesModel')->insertLocal($dataServices);//discount_codes_services_tb

            }
        }

        if ($resultInsert) {
            return 'success: افزودن کد تخفیف با موفقیت انجام شد';

        } else {
            return 'error:خطا در فرایند افزودن کد تخفیف';
        }
    }
    #endregion

    #region DiscountCodesEdit: edit a discount code
    public function DiscountCodesEdit($param) {

        $groupCode = filter_var($param['groupCode'], FILTER_VALIDATE_INT);

        $sqlExist = "SELECT DC.id, DC.preCode, DC.code, DC.isGroup, COUNT(DCU.id) AS used,
                    (SELECT COUNT(id) FROM discount_codes_tb WHERE groupCode = '{$groupCode}') AS groupStock
                    FROM discount_codes_tb AS DC LEFT JOIN discount_codes_used_tb AS DCU ON (DC.code = DCU.discountCode AND DCU.status = 'success')
                    WHERE DC.groupCode = '{$groupCode}'";
        $resultExist = $this->getModel('discountCodesModel')->load($sqlExist);

        if (!empty($resultExist)):

            if ($resultExist['used'] == '0') {

                $isGroup = false;
                if ($resultExist['isGroup'] == 'yes') {
                    $isGroup = true;
                }

                $explodeStartDate = explode('-', filter_var($param['StartDate'], FILTER_SANITIZE_STRING));
                $jmkStartDate = dateTimeSetting::jmktime(0, 0, 0, $explodeStartDate[1], $explodeStartDate[2], $explodeStartDate[0]);

                $explodeEndDate = explode('-', filter_var($param['EndDate'], FILTER_SANITIZE_STRING));
                $jmkEndDate = dateTimeSetting::jmktime(0, 0, 0, $explodeEndDate[1], $explodeEndDate[2], $explodeEndDate[0]);

                $data['title'] = filter_var($param['Title'], FILTER_SANITIZE_STRING);
                $data['amount'] = filter_var($param['Amount'], FILTER_VALIDATE_INT);
                $data['stock'] = (!$isGroup ? filter_var($param['Stock'], FILTER_VALIDATE_INT) : '1');
                $data['startDateInt'] = $jmkStartDate;
                $data['endDateInt'] = $jmkEndDate;
                $data['organizationID'] = (isset($_POST['organizationLevel']) ? filter_var($param['organizationLevel'], FILTER_VALIDATE_INT) : '');
                $data['lastEditInt'] = time();
                $data['is_allow_counter'] =  isset($param['is_allow_counter']) ? $param['is_allow_counter'] : 0;
                $data['is_consume'] = isset($param['is_consume']) ? $param['is_consume'] : 0;

                $Condition = "groupCode = '{$groupCode}'";
                $resultInsert = $this->getModel('discountCodesModel')->update($data, $Condition);


                $selectedServices = $this->setDiscountService($param);
                $get_discount_by_group = $this->getDiscountServicesByDiscountGroup($groupCode);


                foreach ($selectedServices as $service) {
                    $check_exist_service = $this->hasThisServiceWithTitle($groupCode, $service);
                    if (!$check_exist_service) {
                            $dataServices['discountGroupCode'] = $groupCode;
                            $dataServices['serviceTitle'] = $service;
                            $dataServices['service_group'] = $this->getServiceDiscountGroupTitle($service);
                            $this->getModel('discountCodesServicesModel')->insertLocal($dataServices);//discount_codes_services_tb
                    }

                }


                foreach ($get_discount_by_group as $service_unselect) {
                    $check_exist_service = $this->hasThisServiceWithTitle($groupCode, $service_unselect);

                    if (!in_array($service_unselect, $selectedServices) && $check_exist_service) {
                            $this->getModel('discountCodesServicesModel')->delete("discountGroupCode='{$groupCode}' AND serviceTitle='{$service_unselect}'");
                    }
                }

                if ($resultInsert) {
                    return 'success: ویرایش کد تخفیف با موفقیت انجام شد';

                } else {
                    return 'error:خطا در فرایند ویرایش کد تخفیف';
                }

            } else {
                return 'error:متاسفانه شما به این دلیل که این کد تخفیف به کاربران تخصیص یافته نمی توانید آن را ویرایش کنید';
            }

        else:
            return 'error:خطا در ویرایش کد تخفیف، کد تخفیف مورد نظر یافت نشد';
        endif;
    }
    #endregion

    #region DiscountCodesDelete: delete a specified discount code
    public function DiscountCodesDelete($id) {
        $Model = Load::library('Model');
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $query = "SELECT COUNT(DCU.id) AS usedCount FROM discount_codes_used_tb DCU INNER JOIN discount_codes_tb DC " .
            "ON (DCU.discountCode = DC.code AND DCU.status = 'success') " .
            "WHERE DC.id = '{$id}'";
        $result = $Model->load($query);

        if ($result['usedCount'] == 0) {

            $Model->setTable('discount_codes_tb');
            $Model->delete("id = '{$id}'");

            return 'success: حذف کد تخفیف با موفقیت انجام شد';
        } else {
            return 'error: خطا در حذف کد تخفیف، کد تخفیف مورد نظر استفاده شده است';
        }

    }
    #endregion

    #region HasThisService: check if a discount code has a specified service
    public function HasThisService($discountGroupCode, $serviceTitle) {
        $check_exist = $this->getDiscountServices($serviceTitle, $discountGroupCode);
        return (!empty($check_exist)) ? true : false;

    }
    #endregion

    #region ActivateDiscountCode: active or deactive a discount code
    public function ActivateDiscountCode($param) {
        $Model = Load::library('Model');
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);

        $sqlCode = "SELECT * FROM discount_codes_tb WHERE id = '{$param['id']}'";
        $rec = $Model->load($sqlCode);

        if ($rec['isActive'] == 'yes') {
            $data['isActive'] = "no";
        } else {
            $data['isActive'] = "yes";
        }

        $Model->setTable('discount_codes_tb');
        $res = $Model->update($data, "groupCode = '{$rec['groupCode']}'");

        if ($res) {
            return 'success : وضعیت کد تخفیف با موفقیت تغییر یافت';
        } else {
            return 'error : خطا در تغییر وضعیت کد تخفیف';
        }
    }
    #endregion

    #region UsedList: list of users who used a specified discount code
    public function UsedList($groupCode) {
        $Model = Load::library('Model');
        $groupCode = filter_var($groupCode, FILTER_SANITIZE_STRING);

        $query = "SELECT DCU.*, M.name, M.family FROM discount_codes_used_tb AS DCU 
                      INNER JOIN discount_codes_tb AS DC ON DCU.discountCode = DC.code
                      INNER JOIN members_tb AS M ON DCU.memberId = M.id
                      WHERE DC.groupCode = '{$groupCode}' AND DCU.status = 'success'";
        return $Model->select($query);
    }
    #endregion

    #region groupCodesList: list of discount codes of a groupCode
    public function groupCodesList($groupCode) {
        $Model = Load::library('Model');
        $groupCode = filter_var($groupCode, FILTER_SANITIZE_STRING);

        $query = "SELECT *, (SELECT COUNT(id) FROM discount_codes_used_tb WHERE discountCode = discount_codes_tb.code AND status = 'success') AS used " .
            "FROM discount_codes_tb WHERE groupCode = '{$groupCode}'";
        return $Model->select($query);
    }
    #endregion

    #region DiscountCodesUseAdd: insert a discount code for a specified user
    public function DiscountCodesUseAdd($discountCode, $memberId, $serviceTitle, $factorNumber) {
        $Model = Load::library('Model');

        $data['discountCode'] = $discountCode;
        $data['memberId'] = $memberId;
        $data['serviceTitle'] = $serviceTitle;
        $data['factorNumber'] = $factorNumber;
        $data['status'] = 'pending';
        $data['creationDateInt'] = time();

        $Model->setTable('discount_codes_used_tb');
        $resultInsert = $Model->insertLocal($data);

        if (isset($resultInsert) && $resultInsert) {
            return 'success';
        } else {
            return 'error';
        }
    }
    #endregion

    #region DiscountCodesUseConfirm: set discount code use from pending to success by factor number couse it's unique
    public function DiscountCodesUseConfirm($factorNumber) {
        $Model = Load::library('Model');

        $data['status'] = 'success';

        $Condition = " factorNumber = '{$factorNumber}'";
        functions::insertLog('request==>' . $Condition .'==> checkExists','log_train_fateme');

        $Model->setTable('discount_codes_used_tb');
        return $Model->update($data, $Condition);
    }
    #endregion

    #region CheckDiscountCode: check if specified discount code not used by this person
    public function CheckDiscountCode($discountCode, $memberId, $serviceTitle, $currencyCode = null) {
        $Model = Load::library('Model');
        $jmkTodayDate = dateTimeSetting::jmktime();

        $info_member = $this->getController('members')->getMember();
        $serviceTitleCondition = '';
        if (is_array($serviceTitle)) {
            $serviceStr = implode("','", $serviceTitle);
            $serviceTitleCondition = " DCS.serviceTitle in ('{$serviceStr}') ";
        } else {
            $serviceTitleCondition = " DCS.serviceTitle = '{$serviceTitle}' ";
        }

        $sqlCode = "SELECT DC.id, DC.title, DC.code, DC.amount, DC.isActive, DC.stock, DC.startDateInt, DC.endDateInt, DC.organizationID, DCS.serviceTitle,
                    (SELECT COUNT(id) FROM discount_codes_used_tb WHERE discountCode = '{$discountCode}' AND status = 'success' AND serviceTitle = '{$serviceTitle}') AS used,
                    (SELECT COUNT(id) FROM discount_codes_used_tb WHERE discountCode = '{$discountCode}' AND status = 'success' AND serviceTitle = '{$serviceTitle}' AND memberId = '{$memberId}') AS usedByMember
                    FROM discount_codes_tb AS DC INNER JOIN discount_codes_services_tb AS DCS ON DC.groupCode = DCS.discountGroupCode 
                    WHERE DC.code = '{$discountCode}' AND {$serviceTitleCondition} ";
        $resultCode = $Model->load($sqlCode);


        $output = array();
        if (!empty($resultCode) && ($info_member['fk_counter_type_id'] == '5' || ($info_member['fk_counter_type_id'] != '5' && $resultCode['is_allow_counter']))) {

            if ($resultCode['isActive'] == 'yes' && $jmkTodayDate >= $resultCode['startDateInt'] && $jmkTodayDate <= $resultCode['endDateInt']) {

                if ($resultCode['usedByMember'] == 0) {

                    if ($resultCode['stock'] - $resultCode['used'] > 0) {

                        //change currency of discount code amount if needed
                        $amount = functions::CurrencyCalculate($resultCode['amount'], $currencyCode);

                        $output['result_status'] = 'success';
                        $output['result_message'] = 'کد تخفیف ' . $resultCode['title'] . ' به مبلغ ' . functions::numberFormat($amount['AmountCurrency']) . ' ' . $amount['TypeCurrency'];
                        $output['discountCode'] = $resultCode['code'];
                        $output['discountAmount'] = $amount['AmountCurrency'];
                        $output['discountService'] = $resultCode['serviceTitle'];

                    } else {
                        $output['result_status'] = 'error';
                        $output['result_message'] = 'متاسفانه کد تخفیف مورد نظر تمام شده است';
                    }

                } else {
                    $output['result_status'] = 'error';
                    $output['result_message'] = 'شما قبلا کد تخفیف مورد نظر را استفاده نموده اید';
                }

            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'اعتبار کد تخفیف مورد نظر به پایان رسیده است';
            }

        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'کد تخفیف مورد نظر نامعتبر است';
        }

        return $output;
    }
    #endregion

    #region calcDiscountCodeByFactor: get discount code info by factor number and if it exists
    public function getDiscountCodeByFactor($factorNumber) {
        $Model = Load::library('Model');

        $query = "SELECT DC.amount, DCU.discountCode, DCU.memberId, DCU.serviceTitle, DCU.creationDateInt
                  FROM discount_codes_used_tb AS DCU INNER JOIN discount_codes_tb AS DC ON DCU.discountCode = DC.code 
                  WHERE DCU.factorNumber = '{$factorNumber}' AND DCU.status = 'success'";
        $result = $Model->load($query);

        return $result;
    }
    #endregion

    #region calcDiscountCodeByFactor: get discount code info by factor number and if it exists
    public function getDiscountCodeByFactorAndClientId($factorNumber, $clientId) {
        $admin = Load::controller('admin');
        $query = "SELECT DC.amount, DCU.discountCode, DCU.memberId, DCU.serviceTitle, DCU.creationDateInt
                  FROM discount_codes_used_tb AS DCU INNER JOIN discount_codes_tb AS DC ON DCU.discountCode = DC.code 
                  WHERE DCU.factorNumber = '{$factorNumber}' AND DCU.status = 'success'";
        $result = $admin->ConectDbClient($query, $clientId, "Select", "", "", "");

        return $result;
    }
    #endregion

    #region reduceAmountViaDiscountCode: reduce given amount via a specified discount code
    public function reduceAmountViaDiscountCode($amount, $factorNumber, $memberId, $discountCode, $serviceType, $currencyCode = null) {
        $discountResult = $this->CheckDiscountCode($discountCode, $memberId, $serviceType, $currencyCode);
        if ($discountResult['result_status'] == 'success') {
            $addResult = $this->DiscountCodesUseAdd($discountCode, $memberId, $discountResult['discountService'], $factorNumber);
            if ($addResult == 'success') {
                $amount -= $discountResult['discountAmount'];
            }
        }

        return $amount;
    }
    #endregion

    /**
     * @param $param
     * @return array
     */
    private function setDiscountService($param) {

        $selectedServices = [];

        if (isset($param['flight_internal'])) {
            foreach (["PublicLocalCharter", "PrivateLocalCharter", "PublicLocalSystem", "PrivateLocalSystem"] as $item) {
                array_push($selectedServices, $item);
            }
        }
        if (isset($param['flight_external'])) {
            foreach (["PublicPortalCharter", "PublicPortalSystem", "PrivatePortalSystem", "PrivatePortalCharter"] as $item) {
                array_push($selectedServices, $item);
            }

        }
        if (isset($param['hotel_internal'])) {
            foreach (["PublicLocalHotel", "PrivateLocalHotel"] as $item) {
                array_push($selectedServices, $item);
            }

        }
        if (isset($param['hotel_external'])) {
            foreach (["PublicPortalHotel", "PrivatePortalHotel"] as $item) {
                array_push($selectedServices, $item);
            }

        }
        if (isset($param['insurance'])) {

            foreach (["PublicPortalInsurance", "PrivateLocalInsurance"] as $item) {
                array_push($selectedServices, $item);
            }

        }

        if (isset($param['bus'])) {
            foreach (["PublicBus", "PrivateBus"] as $item) {
                array_push($selectedServices, $item);
            }
        }

        if (isset($param['visa'])) {
            foreach (["PrivateVisa", "PublicVisa"] as $item) {
                array_push($selectedServices, $item);
            }
        }

        if (isset($param['tour_internal'])) {
            array_push($selectedServices, "PrivateLocalTour");
        }

        if (isset($param['tour_external'])) {
            array_push($selectedServices, "PrivatePortalTour");
        }
        if (isset($param['train'])) {
            array_push($selectedServices, "Train");
        }

        if (isset($param['train_special'])) {
            array_push($selectedServices, "privateTrain");
        }

        if (isset($param['gasht'])) {
            array_push($selectedServices, "LocalGasht");
        }

        if (isset($param['transfer'])) {
            array_push($selectedServices, "LocalTransfer");
        }

        if (isset($param['entertainment'])) {
            array_push($selectedServices, "privateEntertainment");
        }


        if (isset($param['package'])) {
            array_push($selectedServices, "package");
        }
        return $selectedServices;
    }


    public function getServiceDiscount($service) {

        switch ($service) {
            case 'flight_internal' :
                return ["PublicLocalCharter", "PrivateLocalCharter", "PublicLocalSystem", "PrivateLocalSystem"];
                break;
            case 'flight_external':
                return ["PublicPortalCharter", "PublicPortalSystem", "PrivatePortalSystem", "PrivatePortalCharter"];
                break;
            case 'hotel_internal':
                return ["PublicLocalHotel", "PrivateLocalHotel"];
                break;
            case 'hotel_external':
                return ["PublicPortalHotel", "PrivatePortalHotel"];
                break;
            case 'insurance':
                return ["PublicPortalInsurance", "PrivateLocalInsurance"];
                break;
            case 'bus':
                return ["PublicBus", "PrivateBus"];
                break;
            case 'visa' :
                return ["PrivateVisa", "PublicVisa"];
                break;
            case 'tour_internal':
                return ["PrivateLocalTour"];
                break;
            case 'tour_external':
                return ["PrivatePortalTour"];
                break;
            case 'train':
                return ["Train"];
                break;
            case 'train_special':
                return ["privateTrain"];
                break;
            case 'gasht':
                return ["LocalGasht"];
                break;
            case 'transfer':
                return ["LocalTransfer"];
                break;
            case  'entertainment':
                return ["privateEntertainment"];
                break;
            case 'package':
                return ['package'];
                break;
            default:
                return null;

        }
    }

    /**
     * @param $serviceTitle
     * @param $discountGroupCode
     * @return mixed
     */
    private function getDiscountServices($serviceTitle, $discountGroupCode) {
        $get_services = $this->getServiceDiscount($serviceTitle);
        functions::insertLog($serviceTitle.'===>'.json_encode($get_services),'check_service_discount');
        $detail_service = implode("','", $get_services);
        return $this->getModel('discountCodesServicesModel')->get(['id'], true)->where('discountGroupCode', $discountGroupCode)->whereIn('serviceTitle', $detail_service)->find();

    }
    private function hasThisServiceWithTitle( $discountGroupCode,$serviceTitle) {
        $result_check_service_exist = $this->getModel('discountCodesServicesModel')->get()->where('discountGroupCode', $discountGroupCode)->where('serviceTitle', $serviceTitle)->find();
        return !empty($result_check_service_exist);

    }


    private function getDiscountServicesByDiscountGroup($discountGroupCode) {

        $final_array = [];
        $services = $this->getModel('discountCodesServicesModel')->get(['serviceTitle'], true)->where('discountGroupCode', $discountGroupCode)->all();
        foreach ($services as $service) {
            $final_array[] = $service['serviceTitle'];
        }
        return $final_array;

    }


    public function getServiceDiscountGroupTitle($service) {

        switch ($service) {
            case "PublicLocalCharter":
            case "PrivateLocalCharter":
            case "PublicLocalSystem":
            case "PrivateLocalSystem":
                return 'flight_internal';

            case "PublicPortalCharter":
            case "PublicPortalSystem":
            case "PrivatePortalSystem":
            case "PrivatePortalCharter":
                return 'flight_external';

            case  "PublicLocalHotel":
            case  "PrivateLocalHotel":
                return 'hotel_internal';

            case "PublicPortalHotel":
            case "PrivatePortalHotel":
                return 'hotel_external';

            case "PublicPortalInsurance":
            case "PrivateLocalInsurance":
                return 'insurance';

            case "PublicBus":
            case "PrivateBus":
                return 'bus';

            case "PrivateVisa":
            case "PublicVisa" :
                return 'visa';

            case 'PrivateLocalTour':
                return 'tour_internal';

            case 'PrivatePortalTour':
                return 'tour_external';

            case 'Train':
                return "train";

            case 'privateTrain':
                return 'train_special';

            case 'LocalGasht':
                return "gasht";

            case 'LocalTransfer':
                return 'transfer';

            case  'privateEntertainment':
                return 'entertainment';

            case 'package':
                return 'package';

            default:
                return null;

        }
    }


    public function getPopularDiscountCode() {

        $discount_table = $this->getModel('discountCodesModel');
        $service_discount_table = $this->getModel('discountCodesServicesModel');

        $table_service_discount_name = $service_discount_table->getTable() ;
        $table_discount_table_name = $discount_table->getTable() ;
        return $discount_table->get([$table_discount_table_name.'.*',$table_service_discount_name.'.serviceTitle'],true)
            ->join($table_service_discount_name,'discountGroupCode','groupCode','INNER')
            ->where('endDateInt',time(), '>')->where('isActive','yes')->openParentheses()->where('is_consume',0)
            ->orWhere('is_consume',NULL , 'IS')->closeParentheses()->groupBy($table_service_discount_name.'.service_group')->all();
    }


    public function getAllCodeDiscountUsed() {
       return  $this->getModel('discountCodesUsedModel')->get()->where('status','success')->all();

    }




    public function getPointDiscountCode() {

        $discount_table = $this->getModel('discountCodesModel');
        $service_discount_table = $this->getModel('discountCodesServicesModel');

        $table_service_discount_name = $service_discount_table->getTable() ;
        $table_discount_table_name = $discount_table->getTable() ;
        return $discount_table->get([$table_discount_table_name.'.*',$table_service_discount_name.'.serviceTitle'],true)->join($table_service_discount_name,'discountGroupCode','groupCode','INNER')
            ->where('stock',0,'>')->where('endDateInt',time(), '>')->where('isActive','yes')->where('is_consume',1)->groupBy($table_service_discount_name.'.service_group')->all();
    }

    public function getDiscountCodeWithPoint($param) {
            $get_discount_code = $this->getDiscountCodeById($param['id_discount']);

            if(!empty($get_discount_code)){
                $check_exist_point = $this->getController('historyPointClub')->getPointClubMember(Session::getUserId());
                if($check_exist_point > $get_discount_code['limit_point_club']) {
                    $data_to_discount_Codes['point'] = $get_discount_code['limit_point_club'];
                    $data_to_discount_Codes['discount_code'] = $get_discount_code['code'];
                    $data_to_discount_Codes['factor_number'] = 'CHD'.rand(000,999);
                    $insert_decrease_point = $this->getController('historyPointClub')->decreasePointForConvertToDiscountCode($data_to_discount_Codes);
                    if($insert_decrease_point){
                        $data_update_discount_code['stock'] = $get_discount_code['stock']-1 ;
                        $this->getModel('DiscountCodesModel')->update($data_update_discount_code,"id='{$param['id_discount']}'");
                        return functions::withSuccess($data_to_discount_Codes,200,'دریافت کد تخفیف با موفقیت انجام شد');
                    }
                    return functions::withError(null,401,'امتیاز شما به حد کافی نمی باشد');
                }
            }
            return functions::withError(null,401,'خطا در دریافت کد تخفیف،لطفا با پشتیبانی تماس حاصل نمایید');
    }


    public function getDiscountCodeById($id) {
        return $this->getModel('discountCodesModel')->get()->where('id',$id)->find();
    }



}