<?php

/**
 * Class Emerald
 * @property Entertainment $Entertainment
 */
class entertainment extends clientAuth
{

    public $okBook = '';
    public $CountPeople = '';
    public $payment_date = '';
    public $factorNumber = '';
    public $totalOurCommission = '';
    public $totalPricer = '';
    public $bookCount = 0;
    public $EntertainmentInfo;
    public $book_entertainment_local_model;
    public $report_entertainment_local_model;

    public $transactions;

    public function __construct() {
        parent::__construct();
        //        functions::displayErrorLog('local.chartertech.ir');
        $this->report_entertainment_local_model = $this->getModel('reportEntertainmentModel');
        $this->book_entertainment_local_model = $this->getModel('bookEntertainmentModel');

        $this->transactions = $this->getModel('transactionsModel');
    }

    public function entertainmentOptionByKey($param) {


        $admin = Load::controller('admin');
        $clientID = filter_var($param['clientID'], FILTER_VALIDATE_INT);

        $queryStatus = "SELECT * FROM market_place_tb AS visa WHERE visa.key = '{$param['key']}'";
        $resultStatus = $admin->ConectDbClient($queryStatus, $clientID, 'Select', '', '', '');

        return $resultStatus;
    }

    public function GetEntertainmentGdsData($category_id = null, $id = null, $dataTable = false, $admin = false) {
        $Model = Load::library('Model');
        $Condition = '';
        if ($category_id != '' && $category_id != 0) {
            $Condition .= "AND Entertainment.category_id='{$category_id}'";
        }
        if ($id != '') {
            $Condition .= "AND Entertainment.id='{$id}'";
        }

        if (!$admin) {

            $member_id = Session::getUserId();

            $agency_id = functions::infoMember($member_id);
            $agency_id = $agency_id['fk_agency_id'];

            $Condition .= "AND Entertainment.member_id='{$member_id}' AND Entertainment.agency_id='{$agency_id}' ";
        }


        $sql = "SELECT 
                (SELECT
                    MAX( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE 1=1 " . $Condition . "
                ) AS MaxEntertainmentPrice,
                (
                SELECT
                    MIN( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE 1=1 " . $Condition . "
                ) AS MinEntertainmentPrice,
                Entertainment.*,
                ECategory.id AS CategoryId,
                ECategory.parent_id AS CategoryParentId,
                ECategory.title AS CategoryTitle,
                ECategory.validate AS CategoryValidate,
                EBaseCategory.id AS BaseCategoryId,
                EBaseCategory.parent_id AS BaseCategoryParentId,
                EBaseCategory.title AS BaseCategoryTitle,
                EBaseCategory.validate AS BaseCategoryValidate
   
                FROM entertainment_tb AS Entertainment
                INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id=Entertainment.category_id
                INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id=EBaseCategory.id
                  
                WHERE 1=1 AND Entertainment.deleted_at is null " . $Condition;
        if ($id != null) {
            $result = $Model->load($sql);
            $getDiscountAmount = $this->getDiscount();
            if ($getDiscountAmount != '0') {
                $getDiscount['discountPrice'] = $result['price'] - ($result['price'] * $getDiscountAmount) / 100;
                $result['discountAmount'] = $getDiscountAmount;
                $result['discountPrice'] = ($getDiscount['discountPrice']);
            }
        } else {
           
            $result = $Model->select($sql);
            $counter = 0;
            $getDiscountAmount = $this->getDiscount();
//            foreach ($result as $item) {
//                $item['type_currency'] = $result['price'] ;
//                $result[$counter] = $item;
//                $counter++;
//            }
            if ($getDiscountAmount != '0') {
                foreach ($result as $item) {
                    $getDiscount['discountPrice'] = $item['price'] - ($item['price'] * $getDiscountAmount) / 100;
                    $item['discountPrice'] = ($getDiscount['discountPrice']);

                    $result[$counter] = $item;
                    $counter++;
                }
            }
        }
        if ($dataTable === "true") {
            if ($result) {
                foreach ($result as $key => $item) {


                    if ($item['currency_type'] > 0) {
                        $currency_amount = functions::CalculateCurrencyPrice( [
                            'price' => $item['currency_price'] ,
                            'currency_type' => $item['currency_type']
                        ] );

                        if ($item['price'] > 0) {
                            $item['price'] =  floatval($item['price']+ $currency_amount['AmountCurrency']);
                        }else {
                            $item['price'] =   $currency_amount['AmountCurrency'] + $item['price'];
                        }

                    }

                    $CategoryTitle = '
                        <div class="d-flex">
                          <button type="button" 
                            onClick="getCategoryData($(\'#entertainment_category_list\'),\'' . $item['CategoryParentId'] . '\',true);" 
                            class="btn btn-outline-info w-100 d-flex justify-content-center">
                                ' . $item['CategoryTitle'] . '
                          </button>
                        </div>';
                    $entertainmentAcceptedAt = '
                        <div class="d-flex">
                          <button disabled type="button" 
                            class="btn btn-outline-' . (empty($item['accepted_at']) || $item['accepted_at'] == 0 ? 'danger' : 'success') . ' w-100 d-flex row-gap flex-wrap justify-content-center">
                                <span class="d-block w-100">
                                ' . (empty($item['accepted_at']) || $item['accepted_at'] == 0 ? functions::Xmlinformation('WaitingForAccepted') : functions::Xmlinformation('Accepted')) . '
                                </span>
                                <span class="d-block text-muted small w-100">
                                ' . (empty($item['accepted_at']) || $item['accepted_at'] == 0 ? '' : functions::ConvertDateByLanguage(SOFTWARE_LANG, $item['accepted_at'], '-', 'Miladi', true)) . '
                                </span>
                          </button>
                        </div>';


                    $entertainmentGallery = '<div class="d-flex">
                          <button type="button" 
                            onClick="entertainmentGalleryModal($(this),\'' . $item['CategoryParentId'] . '\',\'' . $item['id'] . '\')" 
                            data-target="#exampleModal"
                            data-entertainment-id="' . $item['id'] . '"
                            class="btn btn-outline-warning w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('Gallery') . '
                          </button>
                        </div>';


                    $entertainmentEdit = '<div class="d-flex">
                          <button type="button" 
                            onClick="editEntertainmentModal($(this),\'' . $item['CategoryParentId'] . '\',\'' . $item['id'] . '\')" 
                            data-target="#exampleModal"
                            data-entertainment-id="' . $item['id'] . '"
                            class="btn btn-outline-info w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('EditEntertainment') . '
                          </button>
                        </div>';

                    $entertainmentValidate = '<div class="d-flex">
                          <button type="button" 
                            onClick="validateEntertainment($(this)' . ($item['validate'] == 1 ? '' : ',\'1\'') . ')" 
                            data-entertainment-id="' . $item['id'] . '"
                            class="btn btn-sm btn-outline-' . ($item['validate'] == 1 ? 'danger' : 'secondary') . ' w-100 d-flex justify-content-center">
                                ' . ($item['validate'] == 1 ? functions::Xmlinformation('DeleteEntertainment') : functions::Xmlinformation('RestoreEntertainment')) . '
                          </button>
                        </div>';


                    $array_table[$key] = $item;
                    $array_table[$key]['CategoryTitle'] = $CategoryTitle;
                    $array_table[$key]['EntertainmentAcceptedAt'] = $entertainmentAcceptedAt;
                    $array_table[$key]['EntertainmentGallery'] = $entertainmentGallery;
                    $array_table[$key]['EntertainmentEdit'] = $entertainmentEdit;
                    $array_table[$key]['EntertainmentDelete'] = $entertainmentValidate;
                }

                $result = $array_table;
                $result = ["data" => $result];
            } else {
                $result = '';
            }
        }
        return ($result);
    }

    public function getDiscount() {
        $serviceType = 'privateEntertainment';

        $UserId = Session::getUserId();
        $UserInfo = functions::infoMember($UserId);
        if (!empty($UserInfo)) {
            $counterID = $UserInfo['fk_counter_type_id'];
        } else {
            $counterID = '5';
        }
        Load::autoload('Model');
        $Model = new Model();

        $query = "SELECT off_percent FROM services_discount_tb WHERE counter_id = '{$counterID}' AND service_title = '{$serviceType}'";
        $discount = $Model->load($query);

        if (!empty($discount['off_percent'])) {

            return $discount['off_percent'];
        } else {

            return '0';
        }
    }

    public function GetData($parent_id = null, $id = null, $dataTable = false) {


        $Model = Load::library('Model');
        $Condition = '';
        $inner_join = '';
        $left_join = '';
        if ($parent_id == 'deleted') {
            $Condition .= " AND (E.validate='0' OR ECategory.validate='0') ";


            $member_id = Session::getUserId();

            $agency_id = functions::infoMember($member_id);
            $agency_id = $agency_id['fk_agency_id'];

            $left_join = ' LEFT JOIN entertainment_tb AS E ON E.category_id=ECategory.id ' . " AND E.member_id='{$member_id}' AND E.agency_id='{$agency_id}' ";


            if (!$this->is_admin()) {
                $inner_join = ' INNER JOIN entertainment_category_member_tb AS CM ON CM.category_id=ECategory.id ';

                $Condition .= " AND ((CM.member_id='{$member_id}'  AND CM.agency_id='{$agency_id}') OR ECategory.approval ='granted' )";
            }

        } else {
            if (!$this->is_admin()) {
                $Condition .= " AND ECategory.validate='1' ";
            }
            if ($parent_id != '') {


                if ($parent_id != 'sub') {
                    $member_id = Session::getUserId();

                    $agency_id = functions::infoMember($member_id);
                    $agency_id = $agency_id['fk_agency_id'];


                    $Condition .= " AND ECategory.parent_id='{$parent_id}'";


                    if (!$this->is_admin()) {
                        $inner_join = ' INNER JOIN entertainment_category_member_tb AS CM ON CM.category_id=ECategory.id ';

                        $Condition .= " AND ((CM.member_id='{$member_id}'  AND CM.agency_id='{$agency_id}') OR ECategory.approval ='granted' )";
                    }


                } else {
                    $Condition .= " AND ECategory.parent_id !='0' ";
                }
            }
        }
        if ($id != '') {
            $Condition .= " AND ECategory.id='{$id}' ";
        }

        $sql = "SELECT 
                ECategory.id AS CategoryId,
                ECategory.parent_id AS CategoryParentId,
                ECategory.title AS CategoryTitle,
                ECategory.validate AS CategoryValidate,
                ECategory.approval AS CategoryApproval
            FROM entertainment_category_tb AS ECategory
            $left_join
            $inner_join
            WHERE 1='1' 
            " . $Condition . "
            GROUP BY ECategory.id
            Order By CategoryId desc
            ";


        if ($id != null) {
            $result = $Model->load($sql);
        } else {
            $result = $Model->select($sql);
        }

        if ($dataTable) {
            $array_table = [];
            if ($id != null) {
                $result = $Model->load($sql);
            } else {

                $result = $Model->select($sql);
                $check_offline= functions::checkClientConfigurationAccess('offline_entertainment');
                $check_online=  functions::checkClientConfigurationAccess('online_entertainment');
                $i = 1;
                foreach ($result as $key => $item) {

                    if ($parent_id === '0') {
                        $subCategoryLink = '
                        <div class="d-flex">
                          <button type="button" 
                            onClick="showEntertainmentTab(\'' . $item['CategoryId'] . '\');getCategoryData($(\'#entertainment_category_list\'),\'' . $item['CategoryId'] . '\',true)" 
                            class="btn btn-secondary w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('EntertainmentSubCategoy') . '
                          </button>
                        </div>';
                    } else {

                        $subCategoryLink = '
                        <div class="d-flex" style="gap: 7px;">
                        
                          <button type="button" 
                            onClick="getEntertainmentDataV2($(\'#entertainment_category_list\'),\'' . $item['CategoryId'] . '\',\'' . $item['CategoryParentId'] . '\',\'' . $check_offline. '\',\'' . $check_online. '\')" 
                            class="btn btn-outline-primary w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('EntertainmentList') . '
                          </button>
                       
                        </div>';

                    }
                    $subCategoryEdit = '
                        <div class="d-flex">
                          <button type="button" 
                            onClick="editEntertainmentCategoryModal($(this))" 
                            data-target="#exampleModal"
                            data-category-id="' . $item['CategoryId'] . '"
                            class="btn btn-outline-info w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('EditCategory') . '
                          </button>
                        </div>';

                    if ($item['CategoryValidate'] == 1) {
                        $subCategoryValidate = '
                        <div class="d-flex">
                          <button type="button" 
                            onClick="validateEntertainmentCategory($(this))" 
                            data-target="#exampleModal"
                            data-category-id="' . $item['CategoryId'] . '"
                            class="btn btn-sm btn-outline-danger w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('DeleteCategory') . '
                          </button>
                        </div>';
                    } else {
                        $subCategoryValidate = '
                        <div class="d-flex">
                          <button type="button" 
                            onClick="validateEntertainmentCategory($(this),1)" 
                            data-target="#exampleModal"
                            data-category-id="' . $item['CategoryId'] . '"
                            class="btn btn-sm btn-outline-secondary w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('RestoreCategory') . '
                          </button>
                        </div>';
                    }


                    $array_table[$key]['CatId'] = $i;
                    $array_table[$key]['CategoryId'] = $item['CategoryId'];
                    $array_table[$key]['CategoryTitle'] = $item['CategoryTitle'];
                    $array_table[$key]['SubCategoryLink'] = $subCategoryLink;
                    $array_table[$key]['CategoryEdit'] = $subCategoryEdit;
                    $array_table[$key]['CategoryValidate'] = $subCategoryValidate;
                    $i += 1;
                }
            }
            $result = $array_table;
            $result = ["data" => $result];
        }

        return ($result);
    }

    public function is_admin() {
        if (GDS_SWITCH !== 'itadmin' && GDS_SWITCH !== 'library') {
            return false;
        }
        return true;
    }

    public function GetParentData($parent_id = null, $id = null) {
        $Model = Load::library('Model');
        $Condition = '';
        if ($parent_id != '') {
            $Condition .= "AND ECategory.parent_id='{$parent_id}'";
        }
        if ($id != '') {
            $Condition .= "AND ECategory.id='{$id}'";
        }
        $sql = "SELECT 
                ECategory.id AS CategoryId,
                ECategory.parent_id AS CategoryParentId,
                ECategory.title AS CategoryTitle,
                ECategory.validate AS CategoryValidate
            
                FROM entertainment_category_tb AS ECategory
            
                WHERE ECategory.validate='1' " . $Condition;

        $result = $Model->load($sql);

        if ($result['CategoryParentId'] != 0) {
            return $this->GetParentData('', $result['CategoryParentId']);
        } else {
            return ($result);
        }

        //        return ($result);
    }

    public function EditEntertainment($param) {


        if (isset($param['title'][0])) {
            $param['title'] = $param['title'][0];
            $param['title_en'] = $param['title_en'][0];
            $param['pageType'] = $param['pageType'][0];
            $param['price'] = $param['price'][0];
            $param['discount_price'] = $param['discount_price'][0];
            $param['description'] = $param['description'][0];




            $param['video'] = $param['video'][0];
            $param['id'] = $param['id'][0];
            $param['city_id'] = $param['EntertainmentCityTitle'][0];
            $param['country_id'] = $param['EntertainmentCountryTitle'][0];
            $param['currency_price'] = $param['currency_price'][0];
            $param['tour_discount_price'] = $param['tour_discount_price'][0];
            $param['tour_price'] = $param['tour_price'][0];
            $param['tour_currency_price'] = $param['tour_currency_price'][0];
        }

//        var_dump($param);
//        die;
        $param['id'] = filter_var($param['id'], FILTER_VALIDATE_INT);

        //        return print_r();
        $Model = Load::library('Model');
        $sqlExist = "SELECT id AS existID FROM entertainment_tb WHERE id = '{$param['id']}'";
        $resultSelect = $Model->load($sqlExist);


        if (!empty($resultSelect['existID'])) {


            $config = Load::Config('application');
            $config->pathFile('entertainment/');
            @$pic_success = $config->UploadFile("pic", "picEntertainment", 99900000);
            @$explod_name_pic = explode(':', $pic_success);
            @$package_success = $config->UploadFile("pic", "package", 99900000);
            @$explod_name_package = explode(':', $package_success);
            ($explod_name_package[0] == "done" ? $data['package'] = $explod_name_package[1] : "");
            ($explod_name_pic[0] == "done" ? $data['pic'] = $explod_name_pic[1] : "");
            $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
            $data['title_en'] = filter_var($param['title_en'], FILTER_SANITIZE_STRING);
            $data['price'] = filter_var($param['price'], FILTER_SANITIZE_NUMBER_INT);
            $data['discount_price'] = filter_var($param['discount_price'], FILTER_SANITIZE_NUMBER_INT);
            $data['tour_discount_price'] = filter_var($param['tour_discount_price'], FILTER_SANITIZE_NUMBER_INT);
            $data['tour_price'] = filter_var($param['tour_price'], FILTER_SANITIZE_NUMBER_INT);
            $data['tour_currency_price'] = $param['tour_currency_price'];
            $data['tour_currency_type'] = $param['tour_currency_type'];
            $data['category_id'] = $param['category_id'];
            $data['currency_type'] = $param['currency_type'];
            $data['currency_price'] = $param['currency_price'];
            $data['city_id'] = $param['city_id'];
            $data['country_id'] = $param['country_id'];
            $data['datatable'] = json_encode($param['DataTable'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $data['description'] = $param['description'];



            $data['video'] = $param['video'];
            $data['accepted_at'] = null;
            $Condition = "id='{$param['id']}'";
            $Model->setTable('entertainment_tb');
            $resultInsert = $Model->update($data, $Condition);

            $Model = Load::library('Model');
            $condition = "entertainment_id = '{$param['id']}'";
            $Model->setTable('entertainment_type_many_tb');
            $result = $Model->delete($condition);


            $EntertainmentTypesCount = count($param['EntertainmentTypes']);
            $counter = 1;
            $ValQuery = '';

            if (isset($param['EntertainmentTypes']) && !empty($param['EntertainmentTypes'])) {

                foreach ($param['EntertainmentTypes'] as $type) {
                    $ValQuery .= '(' . $param['id'] . ',' . $type . ')' . ($counter == $EntertainmentTypesCount ? "" : ",");
                    $counter++;
                }
                $sqlInsert = " INSERT INTO entertainment_type_many_tb (entertainment_id,type_id) VALUES " . $ValQuery;

                $Model->execQuery($sqlInsert);
            }


            if ($resultInsert) {
                $output['result_status'] = 'success';
                $output['result_message'] = 'ویرایش تفریح با موفقیت انجام شد';
            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'خطا در فرایند ویرایش تفریح';
            }

        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در ویرایش تفریح، تفریح مورد نظر یافت نشد';


        }
        return $output;
    }

    public function reservationEntertainmentAuth() {

        Load::autoload('ModelBase');
        $model = new ModelBase();
        $query = "SELECT AUTH.id, AUTH.Username, SOURCE.id as SourceId
                  FROM client_auth_tb AS AUTH 
                  INNER JOIN client_source_tb AS SOURCE ON AUTH.SourceId = SOURCE.id
                  INNER JOIN client_services_tb AS SERVICE ON SOURCE.ServiceId = SERVICE.id
                  WHERE AUTH.ClientId = '" . CLIENT_ID . "' AND SERVICE.Service = 'ReservationEntertainment' AND AUTH.IsActive='Active' ";
        $result = $model->load($query);
        if (!empty($result)) {
            $this->sourceId = $result['SourceId'];
            return true;
        } else {
            return false;
        }

    }

    public function AddEntertainment($param) {
        if (isset($param['is_request']) && $param['is_request'] == 'true') {
            $isRequest = 1;
        } else {
            $isRequest = 0;
        }

//        var_dump($param);
//        die;

        if (isset($param['title'][0])) {
            $param['title'] = $param['title'][0];
            $param['title_en'] = $param['title_en'][0];
            $param['pageType'] = $param['pageType'][0];
            $param['price'] = $param['price'][0];
            $param['tour_price'] = $param['tour_price'][0];
            $param['discount_price'] = $param['discount_price'][0];
            $param['tour_discount_price'] = $param['tour_discount_price'][0];
            if (isset($param['category_id'][0]) && $param['category_id'][0] != '') {
                $param['category_id'] = $param['category_id'][0];
            }

            $param['description'] = $param['description'][0];
            $param['video'] = $param['video'][0];
            $param['city_id'] = $param['EntertainmentCityTitle'][0];
            $param['country_id'] = $param['EntertainmentCountryTitle'][0];
            $param['currency_price'] = $param['currency_price'][0];
            $param['tour_currency_price'] = $param['tour_currency_price'][0];
        }

        $member_id = Session::getUserId();

        $agency_id = functions::infoMember($member_id);

//        if ($param['pageType'] == 'client') {
//            $agency_id = '0';
//        } else {
            if ($agency_id['fk_counter_type_id'] == '5') {
                $agency_id = '0';
            } else {
                $agency_id = $agency_id['fk_agency_id'];
            }
//        }


        $Model = Load::library('Model');
        $config = Load::Config('application');
        $config->pathFile('entertainment/');
        @$pic_success = $config->UploadFile("pic", "picEntertainment", 99900000);

        @$explod_name_pic = explode(':', $pic_success);
        @$package_success = $config->UploadFile("pic", "package", 99900000);
        @$explod_name_package = explode(':', $package_success);
        ($explod_name_package[0] == "done" ? $data['package'] = $explod_name_package[1] : "");
        ($explod_name_pic[0] == "done" ? $data['pic'] = $explod_name_pic[1] : "");
        $data['title'] = filter_var($param['title'], FILTER_SANITIZE_STRING);
        $data['title_en'] = filter_var($param['title_en'], FILTER_SANITIZE_STRING);
        $data['factorNumber'] = functions::generateFactorNumber();
        $data['price'] = filter_var($param['price'], FILTER_SANITIZE_NUMBER_INT);
        $data['tour_price'] = filter_var($param['tour_price'], FILTER_SANITIZE_NUMBER_INT);
        $data['discount_price'] = filter_var($param['discount_price'], FILTER_SANITIZE_NUMBER_INT);
        $data['tour_discount_price'] = filter_var($param['tour_discount_price'], FILTER_SANITIZE_NUMBER_INT);
        $data['category_id'] = $param['category_id'];
        $data['city_id'] = $param['city_id'];
        $data['country_id'] = $param['country_id'];
        $data['currency_price'] = $param['currency_price'];
        $data['tour_currency_price'] = $param['tour_currency_price'];
        $data['currency_type'] = $param['currency_type'];
        $data['tour_currency_type'] = $param['tour_currency_type'];
        $data['datatable'] = json_encode($param['DataTable'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $data['description'] = $param['description'];
        $data['video'] = filter_var($param['video'], FILTER_SANITIZE_STRING);
        $data['agency_id'] = $agency_id;
        $data['member_id'] = $member_id;
        $data['is_request'] = $isRequest;
        $data['created_at'] = date('Y-m-d H:i:s');

        $Model->setTable('entertainment_tb');

        $resultInsert = $Model->insertLocal($data);

        $sqlExist = "SELECT id AS LastID FROM entertainment_tb order by id desc";
        $resultSelect = $Model->load($sqlExist);


        $Model = Load::library('Model');
        $condition = "entertainment_id = '{$resultSelect['LastID']}'";
        $Model->setTable('entertainment_type_many_tb');
        $result = $Model->delete($condition);


        $EntertainmentTypesCount = count($param['EntertainmentTypes']);
        $counter = 1;
        $ValQuery = '';
        if (!empty($param['EntertainmentTypes'])) {

            foreach ($param['EntertainmentTypes'] as $type) {
                $ValQuery .= '(' . $resultSelect['LastID'] . ',' . $type . ')' . ($counter == $EntertainmentTypesCount ? "" : ",");
                $counter++;
            }
            $sqlInsert = " INSERT INTO entertainment_type_many_tb (entertainment_id,type_id) VALUES " . $ValQuery;
            $Model->execQuery($sqlInsert);
        }


        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'ثبت تفریح با موفقیت انجام شد';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند ثبت تفریح';
        }


        return $output;
    }

    public function InsertGallery($info) {

        $Model = Load::library('Model');

        // آپلود فایل هتل //
        if (isset($_FILES['file']) && $_FILES['file'] != "") {

            $config = Load::Config('application');
            $config->pathFile('entertainment/');
            $success = $config->UploadFile("pic", "file", 99900000);
            $explod_name_pic = explode(':', $success);

            if ($explod_name_pic[0] == "done") {

                $Model = Load::library('Model');
                $Model->setTable('entertainment_gallery_tb');
                $sqlExist = "SELECT id AS existID FROM entertainment_gallery_tb WHERE entertainment_id = '{$info['id']}' AND file='{$explod_name_pic[1]}'";
                $resultSelect = $Model->load($sqlExist);

                if (!empty($resultSelect['existID'])) {
                    $condition = "id = '{$resultSelect['existID']}'";
                    $result = $Model->delete($condition);
                }

                $data['entertainment_id'] = $info['id'];
                $data['file'] = $explod_name_pic[1];

                $res = $Model->insertLocal($data);
                $sqlExist = "SELECT * FROM entertainment_gallery_tb WHERE entertainment_id = '{$info['id']}' AND file='{$explod_name_pic[1]}' ORDER BY id desc";
                $resultSelect = $Model->load($sqlExist);

                if ($res) {
                    $output['result_status'] = 'success';
                    $output['FileGalleryId'] = $resultSelect['id'];
                    $output['result_message'] = 'ثبت تفریح با موفقیت انجام شد';
                } else {
                    $output['result_status'] = 'error';
                    $output['FileGalleryId'] = '';
                    $output['result_message'] = 'خطا در فرایند ثبت تفریح';
                }
                return json_encode($output);
            } else {
                return $output;
            }

        } else {
            $data['gallery'] = '';
        }
    }

    public function RemoveSingleGallery($Param) {
        $Model = Load::library('Model');
        $sqlExist = "SELECT * FROM entertainment_gallery_tb WHERE id = '{$Param['GalleryId']}'";
        $resultSelect = $Model->load($sqlExist);
        $Model->setTable('entertainment_gallery_tb');
        if (!empty($resultSelect['id'])) {

            $condition = "id = '{$resultSelect['id']}'";
            $result = $Model->delete($condition);
            unlink(PIC_ROOT . 'entertainment/' . $resultSelect['file']);
        }
        $output['result_status'] = 'success';
        $output['FileGalleryId'] = $resultSelect['id'];
        $output['result_message'] = 'حذف شد';

        echo json_encode($output);

    }

    public function GetEntertainmentGalleryData($Param) {

        if (isset($Param['entertainment_id'])) {
            $Param = $Param['entertainment_id'];
        }
        $Model = Load::library('Model');
        $sqlExist = "SELECT * FROM entertainment_gallery_tb WHERE entertainment_id = '{$Param}'";
        $resultSelect = $Model->select($sqlExist);

        $FinalResult['data'] = $resultSelect;
        return json_encode($FinalResult);

    }

    public function PreReserveEntertainment($params) {

        if (!isset($params['EntertainmentRequest'])) {
            parse_str($params['dataForm'], $params);
        }


        $EntertainmentId = filter_var($params['EntertainmentId'], FILTER_SANITIZE_STRING);

        $entertainment_data = $this->GetEntertainmentData('', '', '','', $EntertainmentId);
        $country_id = $entertainment_data['country_id'];
        $city_id = $entertainment_data['city_id'];

        $ClientId = filter_var($params['client_id'], FILTER_SANITIZE_STRING);
        if (!isset($params['EntertainmentRequest'])) {
            $passengerCount = filter_var($params['CountPeople'], FILTER_SANITIZE_STRING);
        }
        $EntertainmentPrice = filter_var($params['EntertainmentPrice'], FILTER_SANITIZE_STRING);
        $EntertainmentDiscountAmount = filter_var($params['EntertainmentDiscountAmount'], FILTER_SANITIZE_STRING);
        if (!empty($EntertainmentDiscountAmount)) {
            $EntertainmentDiscountPrice = filter_var($params['EntertainmentDiscountPrice'], FILTER_SANITIZE_STRING);
        } else {
            $EntertainmentDiscountPrice = 0;
        }

        $EntertainmentTitle = filter_var($params['EntertainmentTitle'], FILTER_SANITIZE_STRING);
        if (!isset($params['EntertainmentRequest'])) {
            $EntertainmentFactorNumber = filter_var($params['EntertainmentFactorNumber'], FILTER_SANITIZE_STRING);
        }else{
            $EntertainmentFactorNumber = filter_var($params['factorNumber'], FILTER_SANITIZE_STRING);

        }
        if (Session::IsLogin()) {
            $EntertainmentUserId = Session::getUserId();
        } else {
            $EntertainmentUserId = $params['IdMember'];
        }
        $user = functions::infoMember($EntertainmentUserId);
        $serviceTitle = 'privateEntertainment';
        if (!isset($params['EntertainmentRequest'])) {
            if ($passengerCount <= 0) {
                $response = [
                    'result_status' => 'error',
                    'result_message' => 'حداقل افراد یک نفر میباشد'
                ];
                return json_encode($response);
            }
        }
        if (!isset($params['EntertainmentRequest'])) {
            $EntertainmentPassengerBirthDay = filter_var($params['birthday'], FILTER_SANITIZE_STRING);
            $EntertainmentPassengerGender = filter_var($params['gender'], FILTER_SANITIZE_STRING);
            $EntertainmentPassengerNameFa = filter_var($params['nameFa'], FILTER_SANITIZE_STRING);
            $EntertainmentPassengerFamilyFa = filter_var($params['familyFa'], FILTER_SANITIZE_STRING);
            $EntertainmentPassengerNameEn = filter_var($params['nameEn'], FILTER_SANITIZE_STRING);
            $EntertainmentPassengerFamilyEn = filter_var($params['familyEn'], FILTER_SANITIZE_STRING);
            $EntertainmentPassengerStartDate = filter_var($params['StartDate'], FILTER_SANITIZE_STRING);
            $EntertainmentPassengerNationalCode = filter_var($params['NationalCode'], FILTER_SANITIZE_STRING);
        }
//        var_dump($params);
//        die;
        if (!isset($params['EntertainmentRequest'])) {
            if (Session::IsLogin()) {
                $EntertainmentPassengerMobile = filter_var((@$params['Mobile_buyer'] == '' ? $params['Mobile'] : $params['Mobile_buyer']), FILTER_SANITIZE_STRING);
                $EntertainmentPassengerEmail = filter_var((@$params['Email_buyer'] == '' ? $params['Email'] : $params['Email_buyer']), FILTER_SANITIZE_STRING);

            } else {
                $EntertainmentPassengerMobile = filter_var($params['Mobile'], FILTER_SANITIZE_STRING);
                $EntertainmentPassengerTelephone = filter_var($params['Telephone'], FILTER_SANITIZE_STRING);
                $EntertainmentPassengerEmail = filter_var($params['Email'], FILTER_SANITIZE_STRING);
            }
        }else {
            $EntertainmentPassengerMobile = filter_var($params['requestedMemberPhoneNumber'], FILTER_SANITIZE_STRING);
//            $EntertainmentPassengerNameFa= filter_var($params['requestedMemberName'], FILTER_SANITIZE_STRING);
        }

        $BookData['requestNumber'] = DateTimeSetting::jdate("YmdHis", time(), '', '', 'en') . round(microtime(true) * rand('11', '99') * (sqrt(rand(11, 88))));
//        $BookData['factor_number'] = functions::generateFactorNumber();
        $BookData['factor_number'] = $EntertainmentFactorNumber;
        $BookData['passenger_gender'] = $EntertainmentPassengerGender;
        $BookData['passenger_name'] = $EntertainmentPassengerNameFa;
        $BookData['passenger_family'] = $EntertainmentPassengerFamilyFa;
        $BookData['passenger_name_en'] = $EntertainmentPassengerNameEn;
        $BookData['passenger_family_en'] = $EntertainmentPassengerFamilyEn;
        $BookData['passenger_birthday'] = $EntertainmentPassengerBirthDay;
        $BookData['passenger_national_code'] = $EntertainmentPassengerNationalCode;
        $BookData['passenger_reserve_date'] = $EntertainmentPassengerStartDate;
        $BookData['member_id'] = $user['id'];
        $BookData['member_name'] = $user['name'] . ' ' . $user['family'];
        $BookData['member_email'] = $user['email'];
        $BookData['member_mobile'] = $user['mobile'];
        $BookData['member_phone'] = $user['telephone'];
        $BookData['mobile_buyer'] = $EntertainmentPassengerMobile;
        $BookData['email_buyer'] = $EntertainmentPassengerEmail;
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $irantechCommission = Load::controller('irantechCommission');
        $it_commission = $irantechCommission->getEntertainmentCommission('privateEntertainment', 'reservationEntertainment');

        if (!empty($user)) {
          $checkSubAgency = functions::checkExistSubAgency();

        if ($user['fk_agency_id'] > 0 || $checkSubAgency) {
            $agencyId = ($checkSubAgency) ? SUB_AGENCY_ID : $user['fk_agency_id'];
            $sql = " SELECT * FROM agency_tb WHERE id='{$agencyId}'";
            $agency = $model->load($sql);

            $BookData['agency_id'] = $agency['id'];
            $BookData['agency_name'] = $agency['name_fa'];
            $BookData['agency_accountant'] = $agency['accountant'];
            $BookData['agency_manager'] = $agency['manager'];
            $BookData['agency_mobile'] = $agency['mobile'];
        }
        }
        $BookData['EntertainmentId'] = $EntertainmentId;
        $BookData['EntertainmentCountry'] = $country_id;
        $BookData['EntertainmentCity'] = $city_id;
        $BookData['EntertainmentTitle'] = $EntertainmentTitle;
        $BookData['Price'] = $EntertainmentPrice;
        $BookData['FullPrice'] = $passengerCount * $EntertainmentPrice;
        $BookData['CountPeople'] = $passengerCount;
        $BookData['DiscountAmount'] = $EntertainmentDiscountAmount;
        $BookData['DiscountPrice'] = $BookData['FullPrice'] - ($BookData['FullPrice'] * $EntertainmentDiscountAmount) / 100;
        if (!isset($params['EntertainmentRequest'])) {
            $BookData['successfull'] = 'prereserve';
        }else{
            $BookData['successfull'] = 'Requested';
        }
        $BookData['payment_type'] = 'cash';
        $BookData['payment_date'] = '';
        $BookData['name_bank_port'] = '';
        $BookData['number_bank_port'] = '';
        $BookData['tracking_code_bank'] = '';
        $BookData['creation_date_int'] = time();
        $BookData['unique_code'] = $this->generateUniqueCode();;
        $BookData['last_edit_int'] = time();
        $BookData['request_cancel'] = 'none';
        $BookData['name_bank_port'] = '';
        $BookData['irantech_commission'] = $it_commission;
        $BookData['serviceTitle'] = 'privateEntertainment';





        if (isset($params['BookId']) && !empty($params['BookId'])) {
            $condition = " factor_number='" . $EntertainmentFactorNumber . "'  ";
            $model->setTable("book_entertainment_tb");
            $result = $model->update($BookData, $condition);
            if ($result != 0) {
               $ModelBase->setTable('report_entertainment_tb');
               $ModelBase->update($BookData, $condition);
                if ($result != 0) {
                    return json_encode(["factor_number" => $BookData['factor_number']]);
                }
            }

        }else {
            $model->setTable("book_entertainment_tb");
            $result = $model->insertLocal($BookData);

            if ($result != 0) {
                $BookData['client_id'] = $ClientId;
                $ModelBase->setTable("report_entertainment_tb");
                $result = $ModelBase->insertLocal($BookData);
                if ($result != 0) {
                    return json_encode(["factor_number" => $BookData['factor_number']]);
                }
            }
        }




    }

    public function currencyModel() {
        return Load::getModel('currencyModel');
    }
    public function currencyEquivalentModel() {
        return Load::getModel('currencyEquivalentModel');
    }

    public function getCurrency() {

        $currency = $this->currencyModel()->get()->where('IsEnable', 'Enable')->all();

        if (empty($currency)) {
            $currency = array();
        }
        $Equivalent = array();
        foreach ($currency as $equivalent) {
            $resultCurrencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $equivalent['CurrencyCode'])->find();
            if (!empty($resultCurrencyEquivalent)) {
                $resultCurrencyEquivalent['CurrencyTitle'] =  $equivalent['CurrencyTitle'];
                $resultCurrencyEquivalent['CurrencyTitleEn'] =  $equivalent['CurrencyTitleEn'];
                $resultCurrencyEquivalent['CurrencyFlag']  =  $equivalent['CurrencyFlag'];
                $Equivalent[] = $resultCurrencyEquivalent;
            }
        }
        return $Equivalent;

    }
//    public function infoCurrencyItem($currencyCode) {
//
//        $currency = $this->currencyModel()->get()->where('IsEnable', 'Enable')->where('CurrencyCode' , $currencyCode )->limit(0, 1)->all();
//        $Equivalent = array();
//        foreach ($currency as $equivalent) {
//            $resultCurrencyEquivalent = $this->currencyEquivalentModel()->get()->where('CurrencyCode', $equivalent['CurrencyCode'])->find();
//            if (!empty($resultCurrencyEquivalent)) {
//                $resultCurrencyEquivalent['CurrencyTitle'] =  $equivalent['CurrencyTitle'];
//                $resultCurrencyEquivalent['CurrencyFlag']  =  $equivalent['CurrencyFlag'];
//                $Equivalent[] = $resultCurrencyEquivalent;
//            }
//        }
//        return $Equivalent;
//    }


    public function GetEntertainmentData($country_id = null, $city_id = null ,  $category_id = null, $is_request=null, $id = null, $data_table = false ) {

        $Model = Load::library('Model');
        $Condition = '';


        if ($category_id != '' && $category_id != 0) {
            $Condition .= "AND Entertainment.category_id='{$category_id}'";
        }

        if ($id != '') {
            $Condition .= "AND Entertainment.id='{$id}'";
        }

        if ($country_id != '' && $country_id != 'all') {
            $Condition .= "AND Entertainment.country_id='{$country_id}'";
        }

        if ($city_id != '' && $city_id != 'all') {
            $Condition .= "AND Entertainment.city_id='{$city_id}'";
        }
        if ($is_request != '') {
            $Condition .= "AND Entertainment.is_request='{$is_request}'";
        }
        if (!$data_table) {
            $Condition .= " AND Entertainment.accepted_at IS NOT NULL AND ECategory.approval='granted' ";
        }

        $sql = "SELECT 
                (SELECT
                    MAX( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE 
                    Entertainment.validate='1'
                  AND ECategory.validate='1'
                  
                  " . $Condition . "
                ) AS MaxEntertainmentPrice,
                (
                SELECT
                    MIN( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE
                 Entertainment.validate='1' 
                 AND ECategory.validate='1' 
                 
                 " . $Condition . "
                ) AS MinEntertainmentPrice,
                Entertainment.*,
                RCity.name AS RCityTitle,
                RCountry.name AS RCountryTitle,
                ECategory.id AS CategoryId,
                ECategory.parent_id AS CategoryParentId,
                ECategory.title AS CategoryTitle,
                ECategory.validate AS CategoryValidate,
                EBaseCategory.id AS BaseCategoryId,
                EBaseCategory.parent_id AS BaseCategoryParentId,
                EBaseCategory.title AS BaseCategoryTitle,
                EBaseCategory.validate AS BaseCategoryValidate

                FROM entertainment_tb AS Entertainment
                INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id=Entertainment.category_id
                INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id=EBaseCategory.id
                INNER JOIN reservation_city_tb AS RCity ON RCity.id=Entertainment.city_id
                INNER JOIN reservation_country_tb AS RCountry ON RCountry.id=Entertainment.country_id
            
                WHERE Entertainment.validate='1'  AND ECategory.validate='1' " . $Condition;
//echo $sql;
//die;
        $getDiscountAmount = $this->getDiscount();
        if(CLIENT_ID == '273'){
//            var_dump($sql);
//            die();
        }
//           var_dump($sql);
//            die();
        if ($id != null) {


            $result = $Model->load($sql);

            if ($result['currency_type'] > 0 ) {
                $currency_amount = functions::CalculateCurrencyPrice( [
                    'price' => $result['currency_price'] ,
                    'currency_type' => $result['currency_type']
                ] );
//                if ($result['price'] > 0) {
//                    $result['price'] =  floatval($result['price']+ $currency_amount['AmountCurrency']);
//                }else {
//                    $result['price'] =   $currency_amount['AmountCurrency'];
//                }
                if ($result['currency_type'] > 0) {
                    $currency_amount = functions::CalculateCurrencyPrice( [
                        'price' => $result['currency_price'] ,
                        'currency_type' => $result['currency_type']
                    ] );
                    if ($result['price'] > 0) {
                        $result['price'] =  floatval($result['price']+ $currency_amount['AmountCurrency']);
                    }else {
                        $result['price'] = (int) $currency_amount['AmountCurrency'];
                    }

                }

            }
//            if (($result['title_en'] == NULL || $result['title_en'] == "0") &&(REQUEST != 'detailEntertainment'  || REQUEST != 'submitRequest' || REQUEST != 'passengerDetailReservationEntertainment')) {
//                $result['title'] = $result['title'];
//            }else{
//                $result['title'] = $result['title_en'];
//            }

            if ((REQUEST == 'detailEntertainment'  || REQUEST == 'submitRequest' || REQUEST == 'passengerDetailReservationEntertainment')) {

               if ($result['title_en'] == NULL || $result['title_en'] == "0") {
                   $result['title'] = $result['title'];

               }else {
                   $result['title'] = $result['title_en'];
               }
            }

            $getDiscount['discountPrice'] = $result['price'] - $this->calculateEntertainmentDiscount($result, $getDiscountAmount);
            $result['discountAmount'] = $getDiscountAmount;
            $result['discountPrice'] = ($getDiscount['discountPrice']);

            $result['getEntertainmentTypes'] = $this->GetTypes($result['id']);

        } else {


            $result = $Model->select($sql);
            $counter = 0;


            foreach ($result as $item) {
//                $info_currency = $this->infoCurrencyItem($item['currency_type']);
                if ($item['currency_type'] > 0) {
                    $currency_amount = functions::CalculateCurrencyPrice( [
                        'price' => $item['currency_price'] ,
                        'currency_type' => $item['currency_type']
                    ] );
                    if ($item['price'] > 0) {
                        $item['price'] =  floatval($item['price']+ $currency_amount['AmountCurrency']);
                    }else {
                        $item['price'] = (int) $currency_amount['AmountCurrency'];
                    }

                }
                if ($item['title_en'] == NULL || $item['title_en'] == "0") {

                    $item['title'] = $item['title'];
                }else{
                    $item['title'] = $item['title_en'];
                }

                $getDiscount['discountPrice'] = $item['price'] - $this->calculateEntertainmentDiscount($item, $getDiscountAmount);
                $item['discountPrice'] = ($getDiscount['discountPrice']);

                $result[$counter] = $item;
                $counter++;
            }

        }

        return ($result);
    }
    public function GetEntertainmentDataAdmin($country_id = null, $city_id = null ,  $category_id = null, $is_request=null, $id = null, $data_table = false ) {

        $Model = Load::library('Model');
        $Condition = '';


        if ($category_id != '' && $category_id != 0) {
            $Condition .= "AND Entertainment.category_id='{$category_id}'";
        }

        if ($id != '') {
            $Condition .= "AND Entertainment.id='{$id}'";
        }

        if ($country_id != '' && $country_id != 'all') {
            $Condition .= "AND Entertainment.country_id='{$country_id}'";
        }

        if ($city_id != '' && $city_id != 'all') {
            $Condition .= "AND Entertainment.city_id='{$city_id}'";
        }
        if ($is_request != '') {
            $Condition .= "AND Entertainment.is_request='{$is_request}'";
        }
        if (!$data_table) {
            $Condition .= " AND Entertainment.accepted_at IS NOT NULL AND ECategory.approval='granted' ";
        }

        $sql = "SELECT 
                (SELECT
                    MAX( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE 
                    Entertainment.validate='1'
                  AND ECategory.validate='1'
                  
                  " . $Condition . "
                ) AS MaxEntertainmentPrice,
                (
                SELECT
                    MIN( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE
                 Entertainment.validate='1' 
                 AND ECategory.validate='1' 
                 
                 " . $Condition . "
                ) AS MinEntertainmentPrice,
                Entertainment.*,
                RCity.name AS RCityTitle,
                RCountry.name AS RCountryTitle,
                ECategory.id AS CategoryId,
                ECategory.parent_id AS CategoryParentId,
                ECategory.title AS CategoryTitle,
                ECategory.validate AS CategoryValidate,
                EBaseCategory.id AS BaseCategoryId,
                EBaseCategory.parent_id AS BaseCategoryParentId,
                EBaseCategory.title AS BaseCategoryTitle,
                EBaseCategory.validate AS BaseCategoryValidate

                FROM entertainment_tb AS Entertainment
                INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id=Entertainment.category_id
                INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id=EBaseCategory.id
                INNER JOIN reservation_city_tb AS RCity ON RCity.id=Entertainment.city_id
                INNER JOIN reservation_country_tb AS RCountry ON RCountry.id=Entertainment.country_id
            
                WHERE Entertainment.validate='1'  AND ECategory.validate='1' " . $Condition;
//echo $sql;
//die;
        $getDiscountAmount = $this->getDiscount();
        if(CLIENT_ID == '273'){
//            var_dump($sql);
//            die();
        }
//           var_dump($sql);
//            die();
        if ($id != null) {


            $result = $Model->load($sql);



            if ((REQUEST == 'detailEntertainment'  || REQUEST == 'submitRequest' || REQUEST == 'passengerDetailReservationEntertainment')) {

                if ($result['title_en'] == NULL || $result['title_en'] == "0") {
                    $result['title'] = $result['title'];

                }else {
                    $result['title'] = $result['title_en'];
                }
            }

            $getDiscount['discountPrice'] = $result['price'] - $this->calculateEntertainmentDiscount($result, $getDiscountAmount);
            $result['discountAmount'] = $getDiscountAmount;
            $result['discountPrice'] = ($getDiscount['discountPrice']);

            $result['getEntertainmentTypes'] = $this->GetTypes($result['id']);

        } else {


            $result = $Model->select($sql);
            $counter = 0;


            foreach ($result as $item) {
//                $info_currency = $this->infoCurrencyItem($item['currency_type']);
                if ($item['currency_type'] > 0) {
                    $currency_amount = functions::CalculateCurrencyPrice( [
                        'price' => $item['currency_price'] ,
                        'currency_type' => $item['currency_type']
                    ] );
                    if ($item['price'] > 0) {
                        $item['price'] =  floatval($item['price']+ $currency_amount['AmountCurrency']);
                    }else {
                        $item['price'] = (int) $currency_amount['AmountCurrency'];
                    }

                }
                if ($item['title_en'] == NULL || $item['title_en'] == "0") {

                    $item['title'] = $item['title'];
                }else{
                    $item['title'] = $item['title_en'];
                }

                $getDiscount['discountPrice'] = $item['price'] - $this->calculateEntertainmentDiscount($item, $getDiscountAmount);
                $item['discountPrice'] = ($getDiscount['discountPrice']);

                $result[$counter] = $item;
                $counter++;
            }

        }

        return ($result);
    }

    public function calculateEntertainmentDiscount($entertainment, $get_discount_amount) {
        $entertainment_discount = $entertainment['discount_price'];
        $entertainment_price = $entertainment['price'];

        if ($entertainment_discount) {
            return $this->calculateDiscount($entertainment_price, $entertainment_discount);
        }
        return $this->calculateDiscount($entertainment_price, $get_discount_amount);

    }

    public function calculateDiscount($price, $discount) {
        return ($price * $discount) / 100;
    }

    public function GetTypes($enter_id = null, $type_id = null, $fullData = false) {
        $Model = Load::library('Model');
        $Condition = '';

        if (!empty($enter_id)) {
            $sql = "SELECT * FROM entertainment_type_many_tb 
                    WHERE entertainment_id='{$enter_id}'";
            $result = $Model->select($sql);
            $data = [];
            if ($fullData) {
                $sql = "SELECT
                            TypeTB.* 
                        FROM
                            entertainment_type_tb AS TypeTB
                            INNER JOIN entertainment_type_many_tb AS MultiTB ON MultiTB.type_id= TypeTB.id
                            WHERE MultiTB.entertainment_id ='{$enter_id}'
                            GROUP BY TypeTB.id";
                $result = $Model->select($sql);
            } else {
                foreach ($result as $item) {
                    array_push($data, $item['type_id']);
                }
                $result = $data;
            }
        } else {

            if ($type_id != '') {
                $Condition .= "AND type_id='{$type_id}'";
            }
            $sql = "SELECT * FROM entertainment_type_tb 
                WHERE '1'='1' " . $Condition;

            $result = $Model->select($sql);
        }
        return ($result);
    }

    public function generateUniqueCode() {
        $uniqueCode = rand(000000, 999999);

        $Model = Load::library('Model');
        $query = "SELECT id FROM book_entertainment_tb WHERE unique_code = '{$uniqueCode}'";
        $result = $Model->load($query);

        if (empty($result)) {
            return $uniqueCode;
        } else {
            return $this->generateUniqueCode();
        }
    }

    public function updateSuccessfull($factorNum, $value) {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array(
            'successfull' => $value
        );

        $condition = " factor_number='" . $factorNum . "' ";
        $Model->setTable('book_entertainment_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            $ModelBase->setTable('report_entertainment_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function updateBank($codRahgiri, $factorNum) {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $data = array(
            'tracking_code_bank' => $codRahgiri,
            'payment_date' => date('Y-m-d H:i:s')
        );

        $condition = " factor_number='" . $factorNum . "' AND successfull = 'bank' ";
        $Model->setTable('book_entertainment_tb');
        $res = $Model->update($data, $condition);

        if ($res) {
            $ModelBase->setTable('report_entertainment_tb');
            $ModelBase->update($data, $condition);
        }
    }

    public function visaBook($factorNumber, $payType = null) {
        $model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');
        $objTransaction = Load::controller('transaction');
        $smsController = Load::controller('smsServices');

        $this->factorNumber = trim($factorNumber);
        $this->EntertainmentInfo = $this->GetInfoEntertainment($this->factorNumber);

        //prevent book agian in refresh of page
        //        echo $this->EntertainmentInfo['successfull'];
        //        die();
        if ($this->EntertainmentInfo['successfull'] != 'book') {


            if ($payType != 'credit') {
                // Caution: آپدیت تراکنش به موفق
                $objTransaction->setCreditToSuccess($this->factorNumber, $this->EntertainmentInfo['tracking_code_bank']);
            }

            $data['successfull'] = 'book';
            $data['payment_date'] = date('Y-m-d H:i:s');

            if ($payType == 'credit') {
                $data['payment_type'] = 'credit';
            } elseif ($this->EntertainmentInfo['tracking_code_bank'] == 'member_credit') {
                $data['payment_type'] = 'member_credit';
                $data['tracking_code_bank'] = '';
            } else {
                $data['payment_type'] = 'cash';
            }

            $condition = " factor_number='{$this->factorNumber}' ";
            $model->setTable('book_entertainment_tb');
            $res = $model->update($data, $condition);

            if ($res) {
                $ModelBase->setTable('report_entertainment_tb');
                $ModelBase->update($data, $condition);
                $this->okBook = true;
                $this->payment_date = $data['payment_date'];
            }

        }

        if ($this->okBook == true) {
            //email to buyer
            $this->emailVisaSelf($this->factorNumber);

            //sms to buyer
            $objSms = $smsController->initService('0');
            if ($objSms) {
                $messageVariables = array(
                    'sms_name' => $this->EntertainmentInfo['member_name'],
                    'sms_service' => 'تفریحات',
                    'sms_factor_number' => $this->EntertainmentInfo['factor_number'],
                    'sms_entertainment_name' => $this->EntertainmentInfo['EntertainmentTitle'],
                    'sms_agency' => CLIENT_NAME,
                    'sms_agency_mobile' => CLIENT_MOBILE,
                    'sms_agency_phone' => CLIENT_PHONE,
                    'sms_agency_email' => CLIENT_EMAIL,
                    'sms_agency_address' => CLIENT_ADDRESS,
                );
                $smsArray = array(
                    'smsMessage' => $smsController->getUsableMessage('afterEntertainmentReserve', $messageVariables),
                    'cellNumber' => !empty($this->EntertainmentInfo['mobile_buyer']) ? $this->EntertainmentInfo['mobile_buyer'] : $this->EntertainmentInfo['member_mobile'],
                    'smsMessageTitle' => 'afterEntertainmentReserve',
                    'memberID' => (!empty($this->EntertainmentInfo['member_id']) ? $this->EntertainmentInfo['member_id'] : ''),
                    'receiverName' => $messageVariables['sms_name'],
                );
                $smsController->sendSMS($smsArray);
            }

        } elseif ($this->okBook != true && $payType == 'credit') {

            //delete success transaction if book failed
            $this->delete_transaction_current($this->factorNumber);

            //delete success credit of agency if book failed
            $this->delete_credit_Agency_current($this->factorNumber);
        }

    }

    public function GetInfoEntertainment($factorNumber) {
        $factorNumber = trim($factorNumber);

        if (TYPE_ADMIN == '1') {
            $ModelBase = Load::library('ModelBase');

            $sql = "select *," . " (SELECT COUNT(id) FROM report_entertainment_tb WHERE factor_number='{$factorNumber}') AS CountId " . " from report_entertainment_tb where factor_number='{$factorNumber}'  ";
            $result = $ModelBase->load($sql);
        } else {
            Load::autoload('Model');
            $Model = new Model();

            $sql = "select *," . " (SELECT COUNT(id) FROM book_entertainment_tb WHERE factor_number='{$factorNumber}') AS CountId " . " from book_entertainment_tb where factor_number='{$factorNumber}' ";
            $result = $Model->load($sql);
        }
        return $result;

    }

    public function emailVisaSelf($factor_number) {
        $EntertainmentInfo = $this->GetInfoEntertainment($factor_number);

        if (!empty($EntertainmentInfo)) {

            $res_pdf = $this->bookRecords($factor_number);
            $count_reserve = count($res_pdf);

            /*$emailContent = '
            <tr>
                <td valign="top" class="mcnTextContent" style="padding: 18px;color: #000000;font-size: 14px;font-weight: normal;text-align: center;">
                    <h3 class="m_-2679729263370124627null" style="text-align:center;display:block;margin:0;padding:0;color:#000000;font-family:tahoma,verdana,segoe,sans-serif;font-size:22px;font-style:normal;font-weight:bold;line-height:150%;letter-spacing:normal">
    رزرو '.$count_reserve.' عدد
                        <span style="color:#FFFFFF"><strong>' . $EntertainmentInfo['visa_title'] . '</strong></span>
    به مقصد
                        <span style="color:#FFFFFF"><strong>' . $EntertainmentInfo['visa_destination'] . '</strong></span>
                    </h3>
                    <div style="margin-top: 20px;text-align:right;color:#FFFFFF; font-family:tahoma,verdana,segoe,sans-serif">
                    با سلام <br>
    دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم <br>
                    لطفا جهت مشاهده و چاپ واچر(های) ویزا روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید
                    </div>
                </td>
            </tr>
            ';*/

            foreach ($res_pdf as $k => $each) {

                $param['pdf'][$k]['url'] = ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingEntertainment&id=' . $each['unique_code'];
                $param['pdf'][$k]['button_title'] = 'چاپ واچر' . $each['passenger_name'] . ' ' . $each['passenger_family'];

                /*$pdfButton .= '
                <tr>
                    <td align="center" valign="middle" class="mcnButtonContent" style="font-family: Tahoma, Verdana, Segoe, sans-serif; font-size: 14px;">
                        <a class="mcnButton " title="چاپ واچر" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingVisa&id=' . $each['unique_code'] . '" target="_blank" style="background-color: #284861;padding: 15px;margin:5px 0;border-radius: 10px;font-weight: bold;letter-spacing: 0px;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">چاپ واچر '.$each['passenger_name'].' '.$each['passenger_family'].'</a>
                    </td>
                </tr>
                ';*/
            }

            $emailBody = 'با سلام' . '<br>';
            $emailBody .= 'دوست عزیز؛ از اینکه خدمات ما را انتخاب نموده اید سپاسگزاریم' . '<br>';
            $emailBody .= 'لطفا جهت مشاهده و چاپ واچر(های) ویزا روی دکمه چاپ واچر مربوطه که در قسمت پایین قرار دارد کلیک نمایید' . '<br>';

            $param['title'] = 'رزرو ' . $count_reserve . ' عدد' . $EntertainmentInfo['EntertainmentTitle'] . ' به مقصد' . $EntertainmentInfo['EntertainmentTitle'];
            $param['body'] = $emailBody;


            $to = $EntertainmentInfo['email_buyer'];
            $subject = "رزرو ویزا";
            $message = functions::emailTemplate($param);
            $headers = "From: noreply@" . CLIENT_DOMAIN . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8";
            ini_set('SMTP', 'smtphost');
            ini_set('smtp_port', 25);

            mail($to, $subject, $message, $headers);
        }
    }

    public function bookRecords($factorNumber) {

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT * FROM report_entertainment_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  * FROM book_entertainment_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $Model->select($sql);

        }

        return $result;
    }

    public function delete_transaction_current($factorNumber) {
        if (!$this->checkBookStatus($factorNumber)) {
            $Model = Load::library('Model');
            $data['PaymentStatus'] = 'pending';
            $condition = "FactorNumber = '{$factorNumber}' AND FactorNumber !=''";
            $Model->setTable('transaction_tb');
            $Model->update($data, $condition);

            //for admin panel , transaction table
            $this->transactions->updateTransaction($data, $condition);
        }
    }

    public function checkBookStatus($factorNumber) {
        $Model = Load::library('Model');

        $query = "SELECT successfull FROM book_entertainment_tb WHERE factor_number = '{$factorNumber}'";
        $result = $Model->load($query);

        return $result['successfull'] == 'book' ? true : false;
    }

    public function delete_credit_Agency_current($factorNumber) {
        if (!$this->checkBookStatus($factorNumber)) {
            $Model = Load::library('Model');
            $condition = "requestNumber = '{$factorNumber}' AND requestNumber !='' AND type='decrease'";
            $Model->setTable('credit_detail_tb');
            $Model->delete($condition);
        }
    }

    public function createPdfContent($factorNumber, $cash = null, $cancelStatus = null) {


        if (TYPE_ADMIN == '1') {
            $Model = Load::library('ModelBase');
            $tableName = 'report_entertainment_tb';

        } else {
            $Model = Load::library('Model');
            $tableName = 'book_entertainment_tb';
        }
        if (TYPE_ADMIN == '1') {
            $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";

            $info_Entertainment = $Model->load($sql);
        } else {
            $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";

            $info_Entertainment = $Model->load($sql);
        }

        $main_city_controller = Load::controller('mainCity');
        $main_country_controller = Load::controller('mainCountry');

        $city_name = $main_city_controller->fetchCityRecord($info_Entertainment['EntertainmentCity'])[0]['name'];
        $country_name = $main_country_controller->getCountryRecords($info_Entertainment['EntertainmentCountry'])[0]['name'];

        $GetEntertainmentData = $this->GetEntertainmentData('', '', '','', $info_Entertainment['EntertainmentId']);
        $ClientId = CLIENT_ID;
        $agencyController = Load::controller('agency');
        $agencyInfo = $agencyController->infoAgency($info_Entertainment['agency_id'], $ClientId);

        if ($agencyInfo['hasSite']) {
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/agencyPartner/' . CLIENT_ID . '/logo/' . CLIENT_LOGO;

        } else {
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
            $StampAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_STAMP;
        }
        $ClientMainDomain = CLIENT_MAIN_DOMAIN;
        $phone = CLIENT_PHONE;
        $ClientAddress = CLIENT_ADDRESS;
        $PhoneManage = CLIENT_MOBILE;
        $AgencyName = CLIENT_NAME;


        if (!empty($GetEntertainmentData)) {


            require 'library/barcode/qrcode/phpqrcode.php';
            $PNG_TEMP_DIR = PIC_ROOT . '/qrcode/';
            if (!file_exists($PNG_TEMP_DIR))
                mkdir($PNG_TEMP_DIR);
            $filename = $PNG_TEMP_DIR . $info_Entertainment['requestNumber'] . '.png';


            $qr = QRcode::png($info_Entertainment['requestNumber'], $filename, 'L', 6, 6);

            $qrCodeImage = '<img style="float:left;width:300px;" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/qrcode/' . $info_Entertainment['requestNumber'] . '.png" >';


            ?>
          <!DOCTYPE html>
          <html>
          <head>
            <title>مشاهده فایل pdf تفریح</title>
            <style type="text/css">
                .divborder {
                    border: 1px solid #CCC;
                }

                .divborderPoint {
                    border: 1px solid #CCC;
                    background-color: #FFF;
                    border-radius: 5px;
                    z-index: 100000000;
                    width: 200px;
                    padding: 5px;
                    margin-right: 20px;
                }

                .page td {
                    padding: 0;
                    margin: 0;
                }

                .page {
                    border-collapse: collapse;
                }

                @font-face {
                    font-family: "Yekan";
                    font-style: normal;
                    font-weight: normal;
                    src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
                    url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
                    url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");

                }

                table {
                    font-family: Yekan !important;
                    border-collapse: collapse;
                }

                table.solidBorder, .solidBorder th, .solidBorder td {
                    border: 1px solid #CCC;
                }

                .element:last-child {
                    page-break-after: auto;
                }

                @page {
                    margin-bottom: 140px;
                }

                .pdf-footer {
                    position: fixed;
                    bottom: 40px;
                    right: 100px;
                    left: 100px;
                    font-size: 18px;
                    border-top: 1px solid #ccc;
                    padding-top: 15px;
                }
            </style>

          </head>
          <body><?php


          ?>
          <table width="100%" align="center" style="margin: 100px ; border: 1px solid #CCC;" cellpadding="0"
                 cellspacing="0"
                 class="page">

              <?php
              ?>
            <tr style="text-align: center !important;">
              <td style="font-size: 30px; font-weight: 700;padding: 10px ;text-align: center !important;">
                <div style="text-align: center !important;">رسید رزرو تفریحات</div>
              </td>
            </tr>


            <tr>
              <td style="width: 30%; text-align: center; padding-bottom: 5px; " valign="bottom">

                <table>
                  <tr>
                    <td><img src="<?php echo $LogoAgency ?>" height="100" style="max-width: 230px;"></td>
                  </tr>
                </table>

              </td>
              <td style="width: 70%;">
                <table style="" cellpadding="0" cellspacing="0" class="page">
                  <tr>
                    <td style="width: 100%; color: #FFF; height: 120px; " colspan="2">
                      sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
                      asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                      asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                      asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                      asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                      asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3"
                        style="border: 1px solid #CCC; font-size: 20px; font-weight: bolder; padding: 10px ;"
                        width="50%">
                      <span
                        style="float: right;font-size: 18px;  color:#006cb5 ; text-align: left">نام و نام خانوادگی : </span>

                      <span
                        style="float:right;"><?php echo $info_Entertainment['passenger_name'] . ' ' . $info_Entertainment['passenger_family'] ?></span>
                    </td>

                  </tr>
                </table>
              </td>
            </tr>
            <tr>

              <td style="width: 30%;  border: 1px solid #CCC;" align="center">
                <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" border="0">
                  <tr style="border-bottom: 1px solid #CCC">
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">نام تفریحات</span>
                    </td>
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span
                        style="float: left ;display: block;font-size: 18px; position: relative; left: 0;"><?php echo $GetEntertainmentData['title']; ?> </span>
                    </td>
                  </tr>

                  <tr style="">
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">مقصد</span>
                    </td>
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span
                        style="float: left ;display: block;font-size: 18px; position: relative; left: 0;"><?php echo $country_name; ?> / <?php echo $city_name; ?> </span>
                    </td>
                  </tr>

                  <tr style="border-bottom: 1px solid #CCC">
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">نام مجموعه</span>
                    </td>
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span
                        style="float: left ;display: block;font-size: 18px; position: relative; left: 0;"><?php echo $GetEntertainmentData['BaseCategoryTitle']; ?> </span>
                    </td>
                  </tr>
                  <tr style="border-bottom: 1px solid #CCC">
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">نام زیر مجموعه</span>
                    </td>
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span
                        style="float: left ;display: block;font-size: 18px; position: relative; left: 0;"><?php echo $GetEntertainmentData['CategoryTitle']; ?> </span>
                    </td>
                  </tr>
                  <tr style="border-bottom: 1px solid #CCC">
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">شماره فاکتور</span>
                    </td>
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span
                        style="float: left ;display: block;font-size: 18px; position: relative; left: 0;"><?php echo $GetEntertainmentData['factorNumber']; ?> </span>
                    </td>
                  </tr>
                  <tr style="">
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">شماره واچر</span>
                    </td>
                    <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                        height="51">
                      <span
                        style="float: left ;display: block;font-size: 18px; position: relative; left: 0;"><?php echo $info_Entertainment['requestNumber']; ?> </span>
                    </td>
                  </tr>


                </table>
              </td>

              <td style="width: 70%; border: 1px solid #CCC; border-right:none ; border-top:none; vertical-align: top">

                <table style="width: 100%;border:1px solid #CCC" cellpadding="0" cellspacing="0" class="page" border="0"
                       valign="top">
                  <tr>
                    <td style="border-left: 1px solid #CCC;" width="450" align="center">
                      <table style="width: 100%;" cellpadding="0" cellspacing="0" class="page" border="0">
                        <tr>
                          <td width="" style="border-bottom:1px solid #CCC">
                            <table style="width: 100%; font-size: 20px" cellpadding="0" cellspacing="0"
                                   class="page" border="0" align="center">
                              <tr>
                                <td colspan="" width="250" align="center" valign="middle"
                                    style="font-size: 25px;">
                                  <img style="float:left;width:300px;text-align: center"
                                       src=" <?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pic/qrcode/' . $info_Entertainment['requestNumber']; ?>.png">
                                </td>

                              </tr>

                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <table width="450" cellpadding="0" cellspacing="0" class="page" border="0">
                              <tr>
                                <td width="50%" height="70" align="center" valign="middle"
                                    style="border-left: 1px solid #CCC;">
                                  وضعیت
                                </td>
                                <td width="50%" height="70" align="center" valign="middle"
                                    style="font-size: 20px;">
                                    <?php echo($info_Entertainment['successfull'] == 'book' ? "پرداخت شده" : "پرداخت نشده"); ?>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>

                    <td width="210" height="100%">
                      <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" border="0">
                        <tr style="border-bottom: 1px solid #CCC">
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">تعداد نفرات</span>
                          </td>
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left ;display: block; position: relative; left: 0;"><?php echo $info_Entertainment['CountPeople']; ?> </span>
                          </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #CCC">
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">کد ملی</span>
                          </td>
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left ;display: block; position: relative; left: 0;"><?php echo $info_Entertainment['passenger_national_code']; ?> </span>
                          </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #CCC">
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">موبایل خریدار</span>
                          </td>
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left ;display: block; position: relative; left: 0;"><?php echo $info_Entertainment['mobile_buyer']; ?> </span>
                          </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #CCC">
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">ایمیل خریدار</span>
                          </td>
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left ;display: block; position: relative; left: 0;"><?php echo $info_Entertainment['email_buyer']; ?> </span>
                          </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #CCC">
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">تاریخ رزرو</span>
                          </td>
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span
                              style="float: left ;display: block; position: relative; left: 0;"><?php echo str_replace('-', '/', $info_Entertainment['passenger_reserve_date']); ?> </span>
                          </td>
                        </tr>

                        <tr style="border-bottom: 1px solid #CCC">
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                            <span style="float: left;font-size: 18px;  color:#006cb5 ; text-align: left">قیمت</span>
                          </td>
                          <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                              height="51">
                              <?php if ($info_Entertainment['DiscountAmount'] > 0) { ?>
                                <span
                                  style="float: left ; position: relative; left: 0; text-decoration: line-through"><?php echo $info_Entertainment['FullPrice']; ?> تومان </span>
                              <?php } ?>
                            <span
                              style="float: left ;display: block; position: relative; left: 0;"><?php echo $info_Entertainment['DiscountPrice']; ?> تومان </span>


                          </td>
                        </tr>


                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="padding: 10px; border-top: 1px solid #CCC ">
                      <span style="float: right; font-size: 18px; color:#006cb5;">شماره رزرو</span>
                      <span></span>
                      <span
                        style="float: left; margin-right: 20px; font-size: 18px;"><?php echo $info_Entertainment['requestNumber']; ?></span>
                    </td>
                  </tr>
                </table>

              </td>
            </tr>

          </table>


<!--          <div class="divborder" style="margin: 100px ;">
            <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> به نکات زیر توجه
              نمایید:
            </div>
            <table width="100%" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td></td>
              </tr>

              <tr>
                <td style="padding-bottom: 20px">
                  <ul>
                    <li>حداکثر بار مجاز برابر با 20کیلو گرم می باشد</li>
                    <li>مسافر گرامی، با توجه به شیوع ویروس کرونا استفاده از ماسک در بدو ورود به فرودگاه الزامی
                      میباشد. در غیر این صورت حراست فرودگاه از ورود شما جلوگیری خواهد نمود
                    </li>
                    <li>در هنگام سوار شدن حتما مدرک شناسایی (کارت ملی) همراه خود داشته باشید</li>
                    <li>حتما 2 ساعت قبل از پرواز در فرودگاه حاضر باشید</li>
                    <li>در صورت کنسلی پرواز توسط ایرلاین، مسافر و یا تعجیل ؛ یا تاخیر بیش از 2 ساعت خواهشمند است
                      نسبت به مهر نمودن بلیط در فرودگاه و یا دریافت رسید اقدام نمایید
                    </li>
                    <li>ارائه کارت شناسایی عکس دار و معتبر جهت پذیرش بلیط و سوار شدن به هواپیما</li>
                    <li>ترمینال 1 : کیش‌ایر، وارش،زاگرس</li>
                    <li>ترمینال 2 : ایران ایر، ایر تور، آتا، قشم ایر، معراج، نفت(کارون)</li>
                    <li>ترمینال 4 : ماهان، کاسپین، آسمان، اترک، تابان، سپهران،فلای پرشیا،ساها،پویا</li>
                    <li>درصورتی که بلیط شما به هر دلیلی با مشکل مواجه شد لطفا با شماره تلفن های آژانس که در
                      انتهای
                      بلیط نمایش داده شده تماس حاصل فرمائید
                    </li>

                  </ul>

                </td>

              </tr>

            </table>
          </div>-->


          <div class="pdf-footer">
             <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                   <td>
                      وب سایت :
                       <?php echo $AgencyName; ?>
                   </td>

                   <td align="center">
                      تلفن پشتیبانی :
                       <?php echo $phone; ?>
                   </td>

                   <td align="left">
                      تلفن و تلگرام پشتیبانی :
                       <?php echo $PhoneManage; ?>
                   </td>
                </tr>

                <tr>
                   <td colspan="3" style="padding-top: 10px;">
                      آدرس :
                       <?php echo $ClientAddress; ?>
                   </td>
                </tr>
             </table>
          </div>



          <?php ?>
          </body>
          </html>
            <?php
        } else {
            echo '<div style = "text-align:center ; fon-size:20px ;font-family: Yekan;" > اطلاعات مورد نظر موجود نمی باشد </div > ';
        }

        return $PrintTicket = ob_get_clean();
    }

    public function createPdfContent2($factorNumber, $cash = null, $cancelStatus = null) {


        // outputs image directly into browser, as PNG stream


        if (TYPE_ADMIN == '1') {
            $Model = Load::library('ModelBase');
            $tableName = 'report_entertainment_tb';

        } else {
            $Model = Load::library('Model');
            $tableName = 'book_entertainment_tb';
        }
        $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";

        $info_Entertainment = $Model->load($sql);

        $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";

        $info_Entertainment = $Model->load($sql);
        $GetEntertainmentData = $this->GetEntertainmentData('','','','', $info_Entertainment['EntertainmentId']);


        require 'library/barcode/qrcode/phpqrcode.php';
        $PNG_TEMP_DIR = PIC_ROOT . '/qrcode/';
        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);
        $filename = $PNG_TEMP_DIR . $info_Entertainment['requestNumber'] . '.png';


        $qr = QRcode::png($info_Entertainment['requestNumber'], $filename, 'L', 6, 6);

        $qrCodeImage = '<img style="float:left;" src="' . ROOT_ADDRESS_WITHOUT_LANG . '/pic/qrcode/' . $info_Entertainment['requestNumber'] . '.png" >';


        $printBoxCheck = '';
        $printBoxCheck .= ' <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>مشاهده فایل pdf هتل</title>
                    </head>
                    <body>';

        if (!empty($info_Entertainment)) {
            $printBoxCheck .= '<div style="margin:30px auto 0;background-color: #fff;line-height: 24px;">
        
                                <div style="margin:30px auto 0;background-color: #fff;">
                
                    <div style="margin: 10px auto 0;">
                        <div style="font-size: 14px;font-weight: bold;vertical-align: text-bottom;margin: 20px 0 0 0;width: 45%;display: inline-block;text-align: center;height: 67px;font: inherit;float: right;">
                            ';
            if (isset($cancelStatus) && $cancelStatus != '') {
                $printBoxCheck .= functions::Xmlinformation('Cancellationprint');
            } else {
                $printBoxCheck = $info_Entertainment['Entertainment_name'];
            }
            $printBoxCheck .= '
                        </div>
                        <div style="margin-top:20px;width:15%;display: inline-block;text-align: center;height:100px;float: right;">
                            <img src="' . FRONT_CURRENT_THEME . 'project_files/images/logo.png" style="max-height: 100px;">
                        </div>
                    
                
                        <div style="line-height:50px;width:15%;display: inline-block;text-align: center;height:100px;float: right;position:relative;">
                            <span style="background: #fff;font-size: 16px;font-weight: bold;">' . CLIENT_NAME . '</span>
                        </div>
                    </div>
                    ';


            $printBoxCheck .= '
                            <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">';


            $printBoxCheck .= '
                            <div class="row" style="padding: 8px;font-weight: bold;background-color: #2E3231;margin: 0;color: #fff;">
        
                                <div style="width: 30%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">شماره فاکتور : </span><span>';
            $printBoxCheck .= $info_Entertainment['factor_number'];
            $payDate = functions::set_date_payment($info_Entertainment['payment_date']);
            $payDate = explode(' ', $payDate);
            $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">تاریخ خرید : </span><span>';
            $printBoxCheck .= $payDate[0];
            $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">ساعت خرید : </span><span>';
            $printBoxCheck .= $payDate[1];
            $printBoxCheck .= '</span>
                                </div>
        
                            </div>';


            $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">نام تفریح : </span><span>';
            $printBoxCheck .= $GetEntertainmentData['title'];
            $printBoxCheck .= '</span>
                                </div>
                                
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">دسته : </span><span>';
            $printBoxCheck .= $GetEntertainmentData['BaseCategoryTitle'];
            $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">زیر دسته  : </span><span>';
            $printBoxCheck .= $GetEntertainmentData['CategoryTitle'];
            $printBoxCheck .= '</span>
                                </div>
                            </div>';


            $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">قیمت کل : </span><span>';
            $printBoxCheck .= number_format($info_Entertainment['FullPrice']) . ' ريال ';
            $printBoxCheck .= '</span>
                                </div>
                                
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">درصد تخفیف : </span><span>';
            $printBoxCheck .= number_format($info_Entertainment['DiscountAmount']) . '%';
            $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">مبلغ پرداخت شده  : </span><span>';
            $printBoxCheck .= number_format($info_Entertainment['DiscountPrice']) . ' ريال ';
            $printBoxCheck .= '</span>
                                </div>
                            </div>';

            $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                
                                
                                
                                
                                <div style="width: 100%;float: left;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span><div style="float: left">';
            $printBoxCheck .= $qrCodeImage;
            $printBoxCheck .= '</div></span>
                                </div>
                                </div>
        
                            </div>';

            $printBoxCheck .= '
                            <div style="border: 1px solid #2E3231;margin: 5px 40px 5px 40px;">';


            $printBoxCheck .= '
                            <div class="row" style="padding: 8px;font-weight: bold;background-color: #2E3231;margin: 0;color: #fff;">
        
                                <div style="width: 30%;position: relative;float: right;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">مشخصات خریدار</span><span>';
            $printBoxCheck .= '</span>
                                </div>
        
        
                            </div>';


            $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">نام ونام خانوادگی کاربر : </span><span>';
            $printBoxCheck .= (empty($info_Entertainment['member_name']) || $info_Entertainment['member_name'] == ' ' ? $info_Entertainment['passenger_name'] . ' ' . $info_Entertainment['passenger_family'] : $info_Entertainment['member_name']);
            $printBoxCheck .= '</span>
                                </div>
                                
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">جنسیت : </span><span>';
            $printBoxCheck .= functions::Xmlinformation($info_Entertainment['passenger_gender']);
            $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">تاریخ تولد  : </span><span>';
            $printBoxCheck .= $info_Entertainment['passenger_birthday'];
            $printBoxCheck .= '</span>
                                </div>
                            </div>';


            $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">کد ملی : </span><span>';
            $printBoxCheck .= $info_Entertainment['passenger_national_code'];
            $printBoxCheck .= '</span>
                                </div>
                                
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">موبایل : </span><span>';
            $printBoxCheck .= $info_Entertainment['mobile_buyer'];
            $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">ایمیل  : </span><span>';
            $printBoxCheck .= $info_Entertainment['member_email'];
            $printBoxCheck .= '</span>
                                </div>
                            </div>';


            if ($info_Entertainment['member_name'] != ' ') {


                $printBoxCheck .= '
                            <div class="row" style="padding: 8px;margin: 0;">
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;">نام آژانس : </span><span>';
                $printBoxCheck .= $info_Entertainment['agency_name'];
                $printBoxCheck .= '</span>
                                </div>
                                
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;der-box;">
                                    <span style="font-weight: bold;"> نام حسابدار آژانس : </span><span>';
                $printBoxCheck .= $info_Entertainment['agency_accountant'];
                $printBoxCheck .= '</span>
                                </div>
        
                                <div style="width: 30%;float: right;position: relative;min-height: 1px;padding-right: .9375rem;padding-left: .9375rem;box-sizing: border-box;">
                                    <span style="font-weight: bold;">شماره تماس آژانس  : </span><span>';
                $printBoxCheck .= $info_Entertainment['agency_mobile'];
                $printBoxCheck .= '</span>
                                </div>
                            </div>';
            }

            $printBoxCheck .= '
                        </div>
                        </div>
                                </body>
                </html> ';
            return $printBoxCheck;
        }
    }

    public function bookList($reportForExcel = null, $intendedUser = null) {
        $conditions = "";

        $date = dateTimeSetting::jdate("Y-m-d", time());
        $date_now_explode = explode('-', $date);
        $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
        $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);


        if (!empty($intendedUser['member_id'])) {
            $conditions .= ' AND member_id=' . $intendedUser['member_id'] . ' ';
        }

        if (!empty($intendedUser['agency_id'])) {
            $conditions .= ' AND agency_id=' . $intendedUser['agency_id'] . ' ';
        }
        if (!empty($_POST['member_id'])) {
            $conditions .= ' AND member_id=' . $_POST['member_id'] . ' ';
        }

        if (!empty($_POST['agency_id'])) {
            $conditions .= ' AND agency_id=' . $_POST['agency_id'] . ' ';
        }

        if (!empty($_POST['date_of']) && !empty($_POST['to_date'])) {
            $date_of = explode('-', $_POST['date_of']);
            $date_to = explode('-', $_POST['to_date']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $conditions .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";
        } else {
            $conditions .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }

        if (!empty($_POST['status'])) {
            if ($_POST['status'] == 'all') {
                $conditions .= " AND (successfull = 'nothing' OR successfull = 'prereserve' OR successfull = 'bank' OR successfull = 'book') ";
            } else if ($_POST['status'] == 'book') {
                $conditions .= " AND (successfull = 'book')";
            } else {
                $conditions .= " AND (successfull != 'book') ";
            }
        }

        if (!empty($_POST['factor_number'])) {
            $conditions .= " AND factor_number = '{$_POST['factor_number']}'";
        }

        if (!empty($_POST['client_id']) && TYPE_ADMIN == '1') {
            if ($_POST['client_id'] != "all") {
                $conditions .= " AND client_id = '{$_POST['client_id']}'";
            }
        }

        if (!empty($_POST['passenger_name'])) {
            $conditions .= " AND (passenger_name LIKE '%{$_POST['passenger_name']}%' OR passenger_family LIKE '%{$_POST['passenger_name']}%')";
        }

        if (!empty($_POST['member_name'])) {
            $conditions .= " AND member_name LIKE '%{$_POST['member_name']}%'";
        }

        if (!empty($_POST['payment_type'])) {
            if ($_POST['payment_type'] == 'all') {
                $conditions .= " AND (payment_type != '' OR payment_type != 'none')";
            } elseif ($_POST['payment_type'] == 'credit') {
                $conditions .= " AND (payment_type = 'credit' OR payment_type = 'member_credit')";
            } else {
                $conditions .= " AND payment_type = '{$_POST['payment_type']}'";
            }
        }

        $get_session_sub_manage = Session::getAgencyPartnerLoginToAdmin();

        if(Session::CheckAgencyPartnerLoginToAdmin() && $get_session_sub_manage=='AgencyHasLogin'){
            $check_access = $this->getController('manageMenuAdmin')->getAccessServiceCounter(Session::getInfoCounterAdmin());

            $conditions .= " AND serviceTitle IN ({$check_access})";
        }

        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT  rep.*, cli.AgencyName AS NameAgency, cli.Domain AS DomainAgency, " . " SUM(rep.DiscountPrice) AS totalPrice, " . " SUM(rep.irantech_commission) AS irantech_commission ," . " SUM( CountPeople ) AS CountPeople " . " FROM report_entertainment_tb AS rep LEFT JOIN clients_tb AS cli ON cli.id = rep.client_id " . " WHERE 1 = 1 " . $conditions . " GROUP BY rep.requestNumber " . " ORDER BY rep.creation_date_int DESC ";


            $bookList = $ModelBase->select($sql);
        } else {

            $Model = Load::library('Model');
            $sql = "SELECT *, SUM(DiscountPrice) AS totalPrice, 
                 SUM(irantech_commission) AS irantech_commission ,
                 SUM( CountPeople ) AS CountPeople
                 FROM book_entertainment_tb 
                 WHERE 1 = 1  {$conditions}
                 GROUP BY requestNumber
                 ORDER BY creation_date_int DESC ";
            $bookList = $Model->select($sql);

        }


        $this->bookCount = count($bookList);


        $dataRows = [];
        $this->CountPeople = 0;
        $this->totalOurCommission = 0;
        $this->totalPrice = 0;


        if (empty($bookList)) {
            $bookList = array();
        }

        $main_city_controller = Load::controller('mainCity');
        $main_country_controller = Load::controller('mainCountry');


        foreach ($bookList as $k => $book) {
            $city_name = $main_city_controller->fetchCityRecord($book['EntertainmentCity'])[0]['name'];
            $country_name = $main_country_controller->getCountryRecords($book['EntertainmentCountry'])[0]['name'];

            $numberColumn = $k + 2;

            $InfoMember = functions::infoMember($book['member_id'], $book['client_id']);
            $creation_date_int = dateTimeSetting::jdate('Y-m-d (H:i:s)', $book['creation_date_int']);

            $dataRows[$k]['id'] = $book['id'];
            $dataRows[$k]['number_column'] = $numberColumn - 1;
            $dataRows[$k]['creation_date_int'] = $creation_date_int;
            $dataRows[$k]['member_name'] = $book['member_name'];
            $dataRows[$k]['factor_number'] = $book['factor_number'];
            $dataRows[$k]['EntertainmentTitle'] = $book['EntertainmentTitle'];
            $dataRows[$k]['EntertainmentId'] = $book['EntertainmentId'];
            $dataRows[$k]['EntertainmentCountry'] = $country_name;
            $dataRows[$k]['EntertainmentCity'] = $city_name;
            $dataRows[$k]['payment_date'] = $book['payment_date'];
            $dataRows[$k]['agency_name'] = $book['agency_name'];
            $dataRows[$k]['CountPeople'] = $book['CountPeople'];
            $dataRows[$k]['DiscountPrice'] = $book['DiscountPrice'];
            $dataRows[$k]['successfull'] = $book['successfull'];
            $dataRows[$k]['requestNumber'] = $book['requestNumber'];
            $dataRows[$k]['passenger_family'] = $book['passenger_family'];
            $dataRows[$k]['passenger_name'] = $book['passenger_name'];
            $dataRows[$k]['passenger_reserve_date'] = $book['passenger_reserve_date'];
            $dataRows[$k]['passenger_gender'] = $book['passenger_gender'];
            $dataRows[$k]['passenger_national_code'] = $book['passenger_national_code'];
            $dataRows[$k]['email_buyer'] = $book['email_buyer'];
            $this->totalPrice = $book['DiscountPrice'];
            if (!isset($reportForExcel) || (isset($reportForExcel) && $reportForExcel == 'no')) {


                $dataRows[$k]['is_member'] = $InfoMember['is_member'];
                $dataRows[$k]['fk_counter_type_id'] = $InfoMember['fk_counter_type_id'];
                $dataRows[$k]['member_email'] = $book['member_email'];
                $dataRows[$k]['CountPeople'] = $book['CountPeople'];

                if ($book['successfull'] == 'book') {
                    $this->CountPeople = $book['CountPeople'];
                    $this->totalOurCommission += $book['irantech_commission'];
                    $this->totalPricer += $book['DiscountPrice'];
                }
                $dataRows[$k]['irantech_commission'] = $book['irantech_commission'];
                $dataRows[$k]['status'] = $book['successfull'];
                $dataRows[$k]['NameAgency'] = $book['NameAgency'];
                $dataRows[$k]['payment_type'] = $book['payment_type'];
                $dataRows[$k]['name_bank_port'] = $book['name_bank_port'];
                $dataRows[$k]['client_id'] = $book['agency_id'];

            }
        }

        return $dataRows;
    }

    public function entertainmentInfoTracking($factor_number) {

        $book = $this->GetInfoEntertainment($factor_number);

        $result = '';
        if (!empty($book)) {

            $result .= '
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>' . functions::Xmlinformation("EntertainmentTitle") . '</th>
                    <th>' . functions::Xmlinformation("WachterNumber") . '</th>
                    <th>' . functions::Xmlinformation("Buydate") . '</th>
                    <th>' . functions::Xmlinformation("Namepassenger") . '</th>
                    <th>قیمت پرداختی</th>
                    <th>تعداد نفرات</th>
                    <th>' . functions::Xmlinformation("Status") . '</th>
                    <th>' . functions::Xmlinformation("See") . '</th>
                </tr>
                </thead>
                <tbody>
            ';

            $creation_date_int = dateTimeSetting::jdate('Y-m-d', $book['creation_date_int']);
            $prePrice = $book['visa_prepayment_cost'] * ($book['adt_count'] + $book['chd_count'] + $book['inf_count']);
            $prePrice = functions::calcDiscountCodeByFactor($prePrice, $book['factor_number']);

            if ($book['successfull'] == 'book') {
                $status = functions::Xmlinformation("Definitivereservation");
            } else if ($book['successfull'] == 'prereserve') {
                $status = functions::Xmlinformation("Prereservation");
            } else if ($book['successfull'] == 'bank') {
                $status = functions::Xmlinformation("NavigateToPort");
            } else if ($book['successfull'] == 'Requested') {
                $status = functions::Xmlinformation("Requested")->__toString().' <span class="badge badge-warning">'.functions::Xmlinformation("WaitForAcceptation")->__toString().'</span>';
            } else if ($book['successfull'] == 'RequestAccepted') {
                $status = functions::Xmlinformation("RequestAccepted")->__toString().' <span class="badge badge-success">'.functions::Xmlinformation("CompleteReservationRequestInformation")->__toString().'</span>';
            } else if ($book['successfull'] == 'RequestRejected') {
                $status = functions::Xmlinformation("RequestRejected");
            } else if ($book['successfull'] == 'nothing') {
                $status = functions::Xmlinformation("Unknow");
            } else {
                $status = functions::Xmlinformation("Unknow");
            }

//            $op = '<a  id="myBtn" href="' . ROOT_ADDRESS . '/detailEntertainment/' . $book['EntertainmentId'] . '" class="btn btn-primary fa fa-eye margin-10" title="' . functions::Xmlinformation("SeeBooking") . '"></a>';
            $op = '<a  id="myBtn" target="_blank" href="' . ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=entertainment&id=' . $book['factor_number'] . '" class="btn btn-primary fa fa-eye margin-10" title="' . functions::Xmlinformation("SeeBooking") . '"></a>';







            if ( $book['successfull'] == 'RequestAccepted') {


                $serviceName = "entertainment";
                $op .= '<form action="'.ROOT_ADDRESS.'/detailEntertainment" method="post" id="formReservationTour">
                            <input name="serviceName" type="hidden" value="' . $serviceName . '">
                            <input name="idMember" type="hidden" value="' . $book['member_id'] . '">
                            <input name="memberMobile" type="hidden" value="' . $book['member_mobile'] . '">
                            <input name="factor_number" type="hidden" value="' . $book['factor_number'] . '">
                            <input id="EntertainmentId" name="EntertainmentId" type="hidden" value="' . $book['EntertainmentId'] . '">
                            <input id="BookId" name="BookId" type="hidden" value="' . $book['id'] . '">
                             <button class="btn site-bg-main-color" type="submit"> '.functions::Xmlinformation('ResumeReservation').'</button>
                        </form>';

            }


            $result .= '<tr>';
            $result .= '<td>' . $book['EntertainmentTitle'];
            $result .= '</td>';
            $result .= '<td>' . $book['factor_number'] . '</td>';
            $result .= '<td>' . $creation_date_int . '</td>';
            $result .= '<td>' . $book['passenger_name'] . ' ' . $book['passenger_family'] . '</td>';
            $result .= '<td>' . number_format($book['DiscountPrice']) . '</td>';
            $result .= '<td>' . $book['CountPeople'] . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td>' . $op . '</td>';
            $result .= '</tr>';
            $result .= '</table>';

            return $result;

        }

    }

    public function validateEntertainmentCategory($params) {
        $params['id'] = filter_var($params['id'], FILTER_VALIDATE_INT);


        $Model = Load::library('Model');
        $sqlExist = "SELECT id AS existID FROM entertainment_category_tb WHERE id = '{$params['id']}'";

        $resultSelect = $Model->load($sqlExist);

        if (!empty($resultSelect['existID'])) {

            $data['validate'] = $params['validate'];
            $Condition = "id='{$params['id']}'";
            $Model->setTable('entertainment_category_tb');
            $resultInsert = $Model->update($data, $Condition);


        }
        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'ویرایش موضوع تفریح با موفقیت انجام شد';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند ویرایش موضوع';
        }
        return json_encode($output);
    }

    public function validateEntertainment($params) {
        $params['id'] = filter_var($params['id'], FILTER_VALIDATE_INT);


        $Model = Load::library('Model');
        $sqlExist = "SELECT id AS existID FROM entertainment_tb WHERE id = '{$params['id']}'";

        $resultSelect = $Model->load($sqlExist);

        if (!empty($resultSelect['existID'])) {

            $data['validate'] = $params['validate'];
            $Condition = "id='{$params['id']}'";
            $Model->setTable('entertainment_tb');
            $resultInsert = $Model->update($data, $Condition);


        }
        if ($resultInsert) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'ویرایش موضوع تفریح با موفقیت انجام شد';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند ویرایش موضوع';
        }
        return json_encode($output);
    }

    public function newEntertainmentCategory($Param) {
        parse_str($Param['Param'], $ParseParam);
        $data['title'] = $ParseParam['EntertainmentCategoryTitle'][0];

        $category = $this->getModel('entertainmentCategoryModel')->get();
        $data['validate'] = '1';


        $check_existence = $category
            ->where('title', $data['title'])
            ->where('parent_id', $ParseParam['RadioParent'])
            ->all()[0];


        if ($check_existence) {
            $member_id = Session::getUserId();
            $agency_id = functions::infoMember($member_id);

            $entertainment_category_member = $this->getModel('entertainmentCategoryMemberModel')->get();
            $result = $entertainment_category_member = $entertainment_category_member->insertWithBind([
                'category_id' => $check_existence['id'],
                'agency_id' => $agency_id['fk_agency_id'],
                'member_id' => $member_id,
            ]);
        } else {


            if ($ParseParam['FormStatus'][0] == 'new') {
                $data['parent_id'] = $ParseParam['RadioParent'];

                $result = $category->insertWithBind($data);
            } else {
                $data['validate'] = ($ParseParam['EntertainmentCategoryValidation'][0] == 'on' ? "1" : "0");
                $condition = "id='{$ParseParam['FormStatus'][0]}'";
                $result = $category->update($data, $condition);
            }
        }

        if ($result) {


            $member_id = Session::getUserId();
            $agency_id = functions::infoMember($member_id);

            $entertainment_category_member = $this->getModel('entertainmentCategoryMemberModel')->get();
            $entertainment_category_member = $entertainment_category_member->insertWithBind([
                'category_id' => $result,
                'agency_id' => $agency_id['fk_agency_id'],
                'member_id' => $member_id,
            ]);

            $FinalResult = [
                'status' => true,
                'message' => 'ثبت شد',
                'lastId' => $result
            ];
        } else {
            $FinalResult = [
                'status' => false,
                'message' => 'خطا ، دوباره تلاش کنید'
            ];
        }
        echo json_encode($FinalResult);
    }

    public function editEntertainmentCategory($params) {
        parse_str($params['Param'], $ParseParam);
        $ParseParam['id'] = filter_var($ParseParam['id'][0], FILTER_VALIDATE_INT);

        $member_id = Session::getUserId();
        $agency_id = functions::infoMember($member_id);

        $entertainment_category_member = $this->getModel('entertainmentCategoryMemberModel');
        $entertainment_category = $this->getModel('entertainmentCategoryMemberModel');


        $category = $this->getModel('entertainmentCategoryModel');
        $check_existence = $category
            ->get()
            ->join($entertainment_category_member->getTable(), 'category_id', 'id', 'inner')
            ->where($category->getTable() . '.id', $ParseParam['id'])
            ->all()[0];

        if ($check_existence) {

            $data['title'] = $ParseParam['title'][0];
            $data['validate'] = $ParseParam['validate'][0];
            $data['parent_id'] = $check_existence['parent_id'];
            $Condition = "id='{$ParseParam['id']}'";

            $check_entertainment_category_member_existence = $entertainment_category_member->get()
                ->where('category_id', $ParseParam['id'])
                ->all();

            $category = $this->getModel('entertainmentCategoryModel');
            if (count($check_entertainment_category_member_existence) > 1) {

                $entertainment = $this->getModel('entertainmentModel');


                $entertainment_category_member->delete('category_id = ' . $ParseParam["id"] . ' AND agency_id=' . $agency_id['fk_agency_id'] . ' AND member_id=' . $member_id);

                $result = $category->insertWithBind($data);


                $entertainment_category_member->get()->insertWithBind([
                    'category_id' => $result,
                    'agency_id' => $agency_id['fk_agency_id'],
                    'member_id' => $member_id,
                ]);

                /*  $category->get()
                      ->where('parent_id',$ParseParam['id'])
                      ->updateWithBind([
                          'category_id'=>$result
                      ]);*/


                $conditions = [
                    'category_id' => $ParseParam['id'],
                    'agency_id' => $agency_id['fk_agency_id'],
                    'member_id' => $member_id,
                ];

                $result = $entertainment->get()
                    ->updateWithBind([
                        'category_id' => $result
                    ], $conditions);


                //remove category
                //create new one category
                //change all entertainment category_id ( new id )


            } else {
                //just update category
                $result = $category->updateWithBind($data, 'id = ' . $ParseParam['id']);
            }


        }
        if ($result) {
            $output['result_status'] = 'success';
            $output['result_message'] = 'ویرایش موضوع تفریح با موفقیت انجام شد';
        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'خطا در فرایند ویرایش موضوع';
        }
        return json_encode($output);
    }


    public function manageAcceptEntertainment($Param) {
        $Model = Load::library('Model');
        if ($Param['action'] == 'accept') {
            $data['accepted_at'] = date('Y-m-d H:i:s');
        } else {
            $data['accepted_at'] = '0';
        }
        $Model->setTable("entertainment_tb");
        $condition = "id='{$Param['id']}'";
        $result = $Model->update($data, $condition);
        if ($result) {
            $FinalResult = [
                'status' => true,
                'message' => 'ثبت شد',
            ];
        } else {
            $FinalResult = [
                'status' => false,
                'message' => 'خطا ، دوباره تلاش کنید'
            ];
        }
        echo json_encode($FinalResult);
    }

    public function getReportEntertainmentAgency($agencyId) {
        /** @var bookEntertainmentModel $bookEntertainmentModel */
        $bookEntertainmentModel = Load::getModel('bookEntertainmentModel');

        return $bookEntertainmentModel->getReportEntertainmentAgency($agencyId);

    }

    public function getCountries($filter = true,$value=null) {


        if (!$filter) {
            $main_country = Load::controller('mainCountry');
            return $main_country->findCountryRecord('id,name,name_en');
        }



        $country_model = $this->getModel('reservationCountryModel')->get(['reservation_country_tb.*'], true);
        $entertainment = $this->getModel('entertainmentModel')->getTable();
        $categories_table = $this->getModel('entertainmentCategoryModel');
        $categories = $this->getModel('entertainmentCategoryModel')->getTable();


        $country_model = $country_model
            ->join($entertainment, 'country_id', 'id', 'INNER')
            ->join($entertainment, 'id', 'category_id', 'INNER', $categories);

        $country_model = $country_model->where('entertainment_category_tb.validate', 1);
        if (!empty($value)) {
            $country_model = $country_model->where('reservation_country_tb.name',"%{$value}%",'like');
        }
        $country_model = $country_model->where('entertainment_category_tb.approval', 'granted');
        $country_model = $country_model->where('entertainment_tb.validate', 1);
        $country_model = $country_model->where('entertainment_tb.accepted_at', '0000-00-00 00:00:00', '!=');

        $country_model = $country_model->groupBy('reservation_country_tb.id');

        $country_model = $country_model->all();
        return   $country_model;

    }


    public function getCities($params) {
//        var_dump($params);
//        die;
        $filter = true;
        if (isset($params['filter']) && ($params['filter'] == 'false' || $params['filter'] == false)) {
            $filter = false;
        }



        if ($filter == false) {


            $main_country = Load::controller('mainCity');
            return $main_country->getCountryCities($params['country_id'], 'id,name');
        }


        $city = $this->getModel('reservationCityModel')->get('reservation_city_tb.*', true);
        $entertainment = $this->getModel('entertainmentModel')->getTable();
        $categories = $this->getModel('entertainmentCategoryModel')->getTable();


        $city = $city
            ->join($entertainment, 'city_id', 'id', 'inner')
            ->join($entertainment, 'id', 'category_id', 'inner', $categories);
        $city = $city->where('entertainment_category_tb.validate', 1);
        if (!empty($params['value'])) {
            $city = $city->where('reservation_city_tb.name',"%{$params['value']}%",'like');
        }
        $city = $city->where('entertainment_category_tb.approval', 'granted');
        if( $params['country_id'] != 'all') {
            $city = $city->where('entertainment_tb.country_id', $params['country_id']);
        }

        $city = $city->where('entertainment_tb.validate', 1);
        $city = $city->where('entertainment_tb.accepted_at', '0000-00-00 00:00:00', '!=');
        $city = $city->groupBy('reservation_city_tb.id');
        $result = $city->all();

        if(isset($params['is_json']) && $params['is_json']){
            return  functions::withSuccess($result,200,'data fetched successfully');
        }
        return $result;
    }

    public function getParentCategory($id) {
        $category = $this->getModel('entertainmentCategoryModel')->get();
        $category = $category->where('id', $id)
            ->all()[0];

        $parent = $this->getModel('entertainmentCategoryModel')->get()
            ->where('id', $category['parent_id'])->all()[0];
        return $parent;
    }

    public function getCategories($params) {
        $Model = Load::library('Model');

//        $entertainment = $this->getModel('entertainmentModel');
//        $categories = $this->getModel('entertainmentCategoryModel');

        /*$query = $this->getModel('entertainmentCategoryModel')->get()
           ->join($entertainment->getTable(), 'category_id', 'id')
           ->where($categories->getTable()  . '.validate', 1)
           ->where($categories->getTable()  . '.approval', 'granted')
           ->where($entertainment->getTable()  . '.validate', 1)
           ->where($entertainment->getTable()  . '.accepted_at', '0000-00-00 00:00:00', '!=');*/

        $where = '' ;
        if(isset($params['city_id']) && $params['city_id'] != 'all'){
            $where = " AND t.city_id = " . $params['city_id'];
//            $query->where($entertainment->getTable()  . '.city_id', $params['city_id']);
        }

        if (!empty($params['value'])) {
//            $where .= " AND c1.title like '%" . $params['value']."%'";
            $where .= " AND c2.title like '%" . $params['value']."%'";
        }


        $query = "
          SELECT
              CASE WHEN c1.parent_id = '".$params['parent_id']."' THEN c1.id ELSE c2.id   END as id ,  
              CASE WHEN c1.parent_id = '".$params['parent_id']."' THEN c1.title  ELSE c2.title   END as title   
          FROM
              entertainment_tb t
              JOIN entertainment_category_tb c1 ON t.category_id = c1.id
              LEFT JOIN entertainment_category_tb c2 ON c1.parent_id = c2.id
          WHERE 
              CASE WHEN  c1.parent_id = 0 THEN c1.validate = 1  ELSE  c2.validate = 1 END
           AND
              CASE WHEN  c1.parent_id = 0 THEN c1.approval = 'granted'  ELSE  c2.approval = 'granted' END 
              $where
          GROUP BY CASE WHEN  c1.parent_id = 0 THEN c1.id  ELSE  c2.id END
          " ;
//echo $query;
//die;

//        if(isset($params['parent_id'])){
//            $query->where($categories->getTable() . '.parent_id', $params['parent_id']);
//        }
//        $query->groupBy($categories->getTable(). '.id');
//        $result = $query->all();
        $result = $Model->select( $query );

        if($params['is_json']){
            return functions::withSuccess($result,200,'data fetched successfully');
        }

        return $result ;

    }
    public function getCategoriesSub($params) {
        $Model = Load::library('Model');

//        $entertainment = $this->getModel('entertainmentModel');
//        $categories = $this->getModel('entertainmentCategoryModel');

        /*$query = $this->getModel('entertainmentCategoryModel')->get()
           ->join($entertainment->getTable(), 'category_id', 'id')
           ->where($categories->getTable()  . '.validate', 1)
           ->where($categories->getTable()  . '.approval', 'granted')
           ->where($entertainment->getTable()  . '.validate', 1)
           ->where($entertainment->getTable()  . '.accepted_at', '0000-00-00 00:00:00', '!=');*/



        $query = "
          SELECT
               c1.id  as id ,  c1.title as title   
          FROM
              entertainment_tb t
               left JOIN entertainment_category_tb c1 ON t.category_id = c1.id
          WHERE 
               c1.parent_id = '".$params['parent_id']."' AND c1.validate = 1  AND  c1.approval =  'granted' AND t.validate = 1
               GROUP BY c1.title
          " ;
//echo $query;
//die;

        $result = $Model->select( $query );

        if($params['is_json']){
            return functions::withSuccess($result,200,'data fetched successfully');
        }

        return $result ;

    }

    public function getSubCategories($params) {

        $entertainment = $this->getModel('entertainmentModel');
        $categories = $this->getModel('entertainmentCategoryModel');
        $query = $categories->get()
            ->join($entertainment->getTable(), 'category_id', 'id', 'inner')
            ->where($categories->getTable()  . '.validate', 1)
            ->where($categories->getTable()  . '.approval', 'granted');


        if(isset($params['city_id'])){
            $query->where($entertainment->getTable()  . '.city_id', $params['city_id']);
        }
        if(isset($params['parent_id'])){
            $query->where($categories->getTable() . '.parent_id', $params['parent_id']);
        }

        if (!empty($params['value'])) {
            $query = $query->where($categories->getTable().'.title',"%{$params['value']}%",'like');
        }


        $query->groupBy($categories->getTable(). '.id');

        $result = $query->all();


        if($params['is_json']){
            return functions::withSuccess($result,200,'data fetched successfully');
        }

        return $result ;

    }


    public function changeCategoryApproval($id) {
        if (!$this->is_admin()) {
            $categories = $this->getModel('entertainmentCategoryModel');
            $check_existence = $categories->get()
                ->where('id', $id)
                ->all()[0];

            if ($check_existence) {
                if ($check_existence['approval'] == 'granted') {
                    $categories->get()
                        ->updateWithBind([
                            'approval' => 'denied'
                        ], 'id = ' . $id);
                } else {
                    $categories->get()
                        ->updateWithBind([
                            'approval' => 'granted'
                        ], 'id = ' . $id);
                }
                $output['result_status'] = 'success';
                $output['result_message'] = 'وضعیت دسته بندی با موفقیت تغییر یافت';

            } else {
                $output['result_status'] = 'error';
                $output['result_message'] = 'sorry, no category found';
            }


        } else {
            $output['result_status'] = 'error';
            $output['result_message'] = 'فقط مدیریت میتواند این مورد را تغییر دهد';
        }
        echo json_encode($output);
    }

    public function getFullDetail($category_id = null, $id = null, $dataTable = false, $admin = false) {
//      var_dump($id);
//      die;
        $Model = Load::library('Model');
        $Condition = '';
        if ($category_id != '' && $category_id != 0) {
            $Condition .= "AND Entertainment.category_id='{$category_id}'";
        }
        if ($id != '') {
            $Condition .= "AND Entertainment.id='{$id}'";
        }

        if (!$admin) {

            $member_id = Session::getUserId();

            $agency_id = functions::infoMember($member_id);
            $agency_id = $agency_id['fk_agency_id'];

            $Condition .= "AND Entertainment.member_id='{$member_id}' AND Entertainment.agency_id='{$agency_id}' ";
        }


        $sql = "SELECT 
                (SELECT
                    MAX( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE 1=1 " . $Condition . "
                ) AS MaxEntertainmentPrice,
                (
                SELECT
                    MIN( Entertainment.price ) 
                FROM
                    entertainment_tb AS Entertainment
                    INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id = Entertainment.category_id
                    INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id = EBaseCategory.id 
                WHERE 1=1 " . $Condition . "
                ) AS MinEntertainmentPrice,
                Entertainment.*,
                ECategory.id AS CategoryId,
                ECategory.parent_id AS CategoryParentId,
                ECategory.title AS CategoryTitle,
                ECategory.validate AS CategoryValidate,
                EBaseCategory.id AS BaseCategoryId,
                EBaseCategory.parent_id AS BaseCategoryParentId,
                EBaseCategory.title AS BaseCategoryTitle,
                EBaseCategory.validate AS BaseCategoryValidate

                FROM entertainment_tb AS Entertainment
                INNER JOIN entertainment_category_tb AS ECategory ON ECategory.id=Entertainment.category_id
                INNER JOIN entertainment_category_tb AS EBaseCategory ON ECategory.parent_id=EBaseCategory.id
            
                WHERE 1=1 " . $Condition;
        if ($id != null) {
            $result = $Model->load($sql);
            $getDiscountAmount = $this->getDiscount();
            if ($getDiscountAmount != '0') {
                $getDiscount['discountPrice'] = $result['price'] - ($result['price'] * $getDiscountAmount) / 100;
                $result['discountAmount'] = $getDiscountAmount;
                $result['discountPrice'] = ($getDiscount['discountPrice']);
            }
        } else {
            $result = $Model->select($sql);
            $counter = 0;
            $getDiscountAmount = $this->getDiscount();

            if ($getDiscountAmount != '0') {
                foreach ($result as $item) {
                    $getDiscount['discountPrice'] = $item['price'] - ($item['price'] * $getDiscountAmount) / 100;
                    $item['discountPrice'] = ($getDiscount['discountPrice']);

                    $result[$counter] = $item;
                    $counter++;
                }
            }
        }
        if ($dataTable === "true") {
            if ($result) {
                foreach ($result as $key => $item) {

                    $CategoryTitle = '
                        <div class="d-flex">
                          <button type="button" 
                            onClick="getCategoryData($(\'#entertainment_category_list\'),\'' . $item['CategoryParentId'] . '\',true);" 
                            class="btn btn-outline-info w-100 d-flex justify-content-center">
                                ' . $item['CategoryTitle'] . '
                          </button>
                        </div>';

                    $entertainmentAcceptedAt = '
                        <div class="d-flex">
                          <button disabled type="button" 
                            class="btn btn-outline-' . (empty($item['accepted_at']) || $item['accepted_at'] == 0 ? 'danger' : 'success') . ' w-100 d-flex row-gap flex-wrap justify-content-center">
                                <span class="d-block w-100">
                                ' . (empty($item['accepted_at']) || $item['accepted_at'] == 0 ? functions::Xmlinformation('WaitingForAccepted') : functions::Xmlinformation('Accepted')) . '
                                </span>
                                <span class="d-block text-muted small w-100">
                                ' . (empty($item['accepted_at']) || $item['accepted_at'] == 0 ? '' : functions::ConvertDateByLanguage(SOFTWARE_LANG, $item['accepted_at'], '-', 'Miladi', true)) . '
                                </span>
                          </button>
                        </div>';


                    $entertainmentGallery = '<div class="d-flex">
                          <button type="button" 
                            onClick="entertainmentGalleryModal($(this),\'' . $item['CategoryParentId'] . '\',\'' . $item['id'] . '\')" 
                            data-target="#exampleModal"
                            data-entertainment-id="' . $item['id'] . '"
                            class="btn btn-outline-warning w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('Gallery') . '
                          </button>
                        </div>';


                    $entertainmentEdit = '<div class="d-flex">
                          <button type="button" 
                            onClick="editEntertainmentModal($(this),\'' . $item['CategoryParentId'] . '\',\'' . $item['id'] . '\')" 
                            data-target="#exampleModal"
                            data-entertainment-id="' . $item['id'] . '"
                            class="btn btn-outline-info w-100 d-flex justify-content-center">
                                ' . functions::Xmlinformation('EditEntertainment') . '
                          </button>
                        </div>';

                    $entertainmentValidate = '<div class="d-flex">
                          <button type="button" 
                            onClick="validateEntertainment($(this)' . ($item['validate'] == 1 ? '' : ',\'1\'') . ')" 
                            data-entertainment-id="' . $item['id'] . '"
                            class="btn btn-sm btn-outline-' . ($item['validate'] == 1 ? 'danger' : 'secondary') . ' w-100 d-flex justify-content-center">
                                ' . ($item['validate'] == 1 ? functions::Xmlinformation('DeleteEntertainment') : functions::Xmlinformation('RestoreEntertainment')) . '
                          </button>
                        </div>';


                    $array_table[$key] = $item;
                    $array_table[$key]['CategoryTitle'] = $CategoryTitle;
                    $array_table[$key]['EntertainmentAcceptedAt'] = $entertainmentAcceptedAt;
                    $array_table[$key]['EntertainmentGallery'] = $entertainmentGallery;
                    $array_table[$key]['EntertainmentEdit'] = $entertainmentEdit;
                    $array_table[$key]['EntertainmentDelete'] = $entertainmentValidate;
                }

                $result = $array_table;
                $result = ["data" => $result];
            } else {
                $result = '';
            }
        }
        return ($result);
    }

    public function registerBookRecord($params) {
        $_POST = $params;

         self::PreReserveEntertainment($_POST);
        return $params['factorNumber'];
    }

    public function getBookDataEntertainment_old($factorNumber) {


        if (TYPE_ADMIN == '1') {
            $Model = Load::library('ModelBase');
            $tableName = 'report_entertainment_tb';

        } else {
            $Model = Load::library('Model');
            $tableName = 'book_entertainment_tb';
        }
        if (TYPE_ADMIN == '1') {
            $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";

            $info_Entertainment = $Model->load($sql);
        } else {
            $sql = "SELECT * FROM $tableName  WHERE factor_number='{$factorNumber}' ";

            $info_Entertainment = $Model->load($sql);
        }

        $main_city_controller = Load::controller('mainCity');
        $main_country_controller = Load::controller('mainCountry');

        $city_name = $main_city_controller->fetchCityRecord($info_Entertainment['EntertainmentCity'])[0]['name'];
        $country_name = $main_country_controller->getCountryRecords($info_Entertainment['EntertainmentCountry'])[0]['name'];


        $result = $this->GetEntertainmentData('', '', '','', $info_Entertainment['EntertainmentId']);

//var_dump($result);
        return $result;

    }


    public function getBookDataEntertainment($factorNumber) {
        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "SELECT * FROM report_entertainment_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $ModelBase->select($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "SELECT  * FROM book_entertainment_tb WHERE factor_number = '{$factorNumber}' ";
            $result = $Model->select($sql);

        }
        $main_city_controller = Load::controller('mainCity');
        $main_country_controller = Load::controller('mainCountry');
        foreach ($result as $key => $value) {

            $result[$key]['city_name'] = $main_city_controller->fetchCityRecord($value['EntertainmentCity'])[0]['name'];
            $result[$key]['country_name'] = $main_country_controller->getCountryRecords($value['EntertainmentCountry'])[0]['name'];
            $result[$key]['BaseCategoryTitle'] = $this->GetEntertainmentData('', '', '','', $value['EntertainmentId'])['BaseCategoryTitle'];
            $result[$key]['CategoryTitle'] = $this->GetEntertainmentData('', '', '','', $value['EntertainmentId'])['CategoryTitle'];

        }
        return $result;
    }

    public function changeStatus($factorNumber, $status) {
        $book_update = $this->getModel('bookEntertainmentModel')->updateWithBind([
            'successfull' => $status
        ], [
            'factor_number' => $factorNumber
        ]);

        $report_update = $this->report_entertainment_local_model->updateWithBind([
            'successfull' => $status
        ], [
            'factor_number' => $factorNumber
        ]);

        return ($book_update && $report_update);
    }


}

