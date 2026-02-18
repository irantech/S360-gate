<?php
//if($_SERVER['REMOTE_ADDR'] == '93.118.161.174') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class agency  extends clientAuth {
	
	public $nameFa = '';
	public $nameEn = '';
	public $accountant = '';
	public $manager = '';
	public $phone = '';
	public $mobile = '';
	public $fax = '';
	public $postalcode = '';
	public $email = '';
	public $addressFa = '';
	public $addressEn = '';
	public $tmpLogo = '';
	public $nameLogo = '';
	public $username = '';
	public $pass = '';
	public $typeCounter = '';
	public $payment = '';
	public $deleteID = '';
	public $editID = '';
	public $edit = '';
	public $counterID = '';
	public $message = '';    //message that show after insert new agency
	public $list = array();    //array that include list of agency
	public $option = '';    // a string inclode metods of CounterType for show in Select Tag
	public $optionAgency = '';  // a string inclode metods of agency for show in Select Tag
	
	/**
	 * if form was send  "get data-> upload logo -> insert DB"
	 */
	
	public function __construct() {

	    parent::__construct();
	}


    //region [subAgencyModel]
    /**
     * @return bool|mixed|subAgencyModel
     */
    public function subAgencyModel() {
        return Load::getModel('subAgencyModel');
    }
    //endregion

    //region [agencyModel]
    /**
     * @return bool|mixed|agencyModel
     */
    public function agencyModel() {
        return Load::getModel( 'agencyModel' );
    }
    //endregion
    //region [application]
    /**
     * @return application|mixed
     */
    public function application() {
        return Load::Config( 'application' );
    }
    //endregion


    /**
     * @param $agency
     * @return string
     */
    public function insert_agency($agency ) {
        //check inke tekrari nabashe code moghim ya seatCharter
        $resultSeatCharterCode= $this->getModel('agencyModel')
            ->get(['id'])
            ->where('seat_charter_code' , $agency['seat_charter_code'])
            ->where('del' , 'no' )
            ->find();
        if($resultSeatCharterCode['id']>0 && !empty($agency['seat_charter_code'])){
            return "error : خطا در تکراری بودن کد یکتای مقیم";
        }

        $resultSepehrUsername= $this->getModel('agencyModel')
            ->get(['id'])
            ->where('sepehr_username' , $agency['sepehr_username'])
            ->where('del' , 'no' )
            ->find();
        if($resultSepehrUsername['id']>0 && !empty($agency['sepehr_username'])){
            return "error : خطا در تکراری بودن نام کاربری سپهر";
        }
        $agency_attachment_model = $this->getModel('agencyAttachmentModel');
        $status_upload        = true;
		$data                  = $agency;
        unset($data['gallery_file_alts']);
        unset($data['gallery_files']);
        $data['bank_data']     = json_encode($agency['bank_data']);
		$data['password']      = functions::encryptPassword( $agency['password'] );
		$data['email']         = strtolower( $agency['email'] );
		$data['del']           = "no";
		$data['active'] = ( isset($agency['hasSite']) && $agency['hasSite'] == 1 ) ? 'off' : 'on';

		//logo
        $data['logo'] = $this->uploadPic('logo');
        $status_upload = !empty($data['logo']) ? true : false;

        // license
        if (isset($_FILES['license']) && $_FILES['license'] != "") {
            $data['license'] = $this->uploadPic('license');
            $status_upload = !empty($data['license']) ? true : false;
        }

        // newspaper
        if (isset($_FILES['newspaper']) && $_FILES['newspaper'] != ""){
        $data['newspaper'] = $this->uploadPic('newspaper');
        $status_upload = !empty($data['newspaper']) ? true : false;
        }

        //aboutMePic
        if (isset($_FILES['aboutMePic']) && $_FILES['aboutMePic'] != ""){
        $data['aboutMePic'] = $this->uploadPic('aboutMePic');
        $status_upload = !empty($data['aboutMePic']) ? true : false;
        }

		if ( $status_upload ) {
            $data['time_limit_credit'] = functions::FormatDateJalali($agency['time_limit_credit']);
			$result = $this->agencyModel()->insertWithBind( $data );
			if ( $result ) {

                if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {
                    $separated_files = functions::separateFiles('gallery_files');
                    foreach ($separated_files as $file_key => $separated_file) {

                        $_FILES['file'] = $separated_file;
                        $config = Load::Config('application');
                        $config->pathFile('agencyPartner/' . CLIENT_ID .'/attachments/' );
                        $success = $config->UploadFile("pic", "file", 99900000);

                        $explode_name_pic = explode(':', $success);
                        if ($explode_name_pic[0] == "done") {

                            $insert_result = $agency_attachment_model->insertWithBind([
                                'client_id' => CLIENT_ID ,
                                'agency_id' => $result,
                                'file_path' => $explode_name_pic[1],
                            ]);
                        }

                    }
                }
				if ( isset($data['hasSite']) && $data['hasSite'] ) {
					$checkExistSubAgencyResult = $this->subAgencyModel()->get()->where('url_agency',$data['domain'] )->where('client_id',CLIENT_ID)->find();
					if (empty( $checkExistSubAgencyResult )) {
						$dataSubAgency['agency_id']  = $this->agencyModel()->getLastId();
						$dataSubAgency['client_id']  = CLIENT_ID;
						$dataSubAgency['url_agency'] = $data['domain'];
						$dataSubAgency['language']   = $data['language'];
						$this->subAgencyModel()->insertWithBind( $dataSubAgency );
					}
				}
                if (isset($data['sepehr_username']) && !empty($data['sepehr_username']) && $data['sepehr_username'] != ''
                && isset($data['sepehr_password']) && !empty($data['sepehr_password']) && $data['sepehr_password'] != '') {
                    $insertedAgency = $this->agencyModel()
                        ->get(['id'])
                        ->where('sepehr_username', $data['sepehr_username'])
                        ->orderBy('id', 'DESC')
                        ->limit(0, 1)
                        ->find();
                    $dataSubAgencyCore['gds_id']  = $insertedAgency['id'];
                    $dataSubAgencyCore['agency_name']  = $this->getClientAuthFlightInfo();
                    $dataSubAgencyCore['name_fa']  = $data['name_fa'];
                    $dataSubAgencyCore['sepehr_username']  = $data['sepehr_username'];
                    $dataSubAgencyCore['sepehr_password']  = $data['sepehr_password'];
                    $resultInsertSubAgencyCore = Load::controller( 'settingCore' )->insertSubAgencyCore($dataSubAgencyCore);

                    if (!isset($resultInsertSubAgencyCore['status']) || $resultInsertSubAgencyCore['status'] != 'success') {
                        return 'error : خطا در ثبت اطلاعات سپهر';
                    }
                }
                return "success : آژانس جدید با موفقیت ثبت شد";
			} else {
				return "error : خطا در ثبت آژانس";
			}
		} else {
			return "error:خطا در ثبت آژانس هنگام اپلود عکس ";
		}


	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	public function edit_agency( $data ) {
        //check inke tekrari nabashe code moghim ya seatCharter
        $resultSeatCharterCode= $this->getModel('agencyModel')
            ->get(['id'])
            ->where('seat_charter_code' , $data['seat_charter_code'])
            ->where('del' , 'no' )
            ->where('id' , $data['edit_id'],'!=' )
            ->find();
        if($resultSeatCharterCode['id']>0 && !empty($data['seat_charter_code'])) {
            return "error : خطا در تکراری بودن کد یکتای مقیم";
        }
        $resultSepehrUsername= $this->getModel('agencyModel')
            ->get(['id'])
            ->where('sepehr_username' , $data['sepehr_username'])
            ->where('del' , 'no' )
            ->where('id' , $data['edit_id'],'!=' )
            ->find();
        if($resultSepehrUsername['id']>0 && !empty($data['sepehr_username'])){
            return "error : خطا در تکراری بودن نام کاربری سپهر";
        }

        $agency_attachment_model = $this->getModel('agencyAttachmentModel');
        $agency_model = $this->getModel('agencyModel');

        $result        = $this->agencyModel()->get()->where('id' , $data['edit_id'] )->find();
		$status_upload      = false;

		if ( ! empty( $result ) ) {
			$id                                      = $result['id'];
            $dataEditAgency['birthday']              = ! empty( $data['birthday'] ) ? $data['birthday'] : $result['birthday'];
            $dataEditAgency['agency_national_code']  = ! empty( $data['agency_national_code'] ) ? $data['agency_national_code'] : $result['agency_national_code'];
            $dataEditAgency['economic_code']         = ! empty( $data['economic_code'] ) ? $data['economic_code'] : $result['economic_code'];
            $dataEditAgency['staff_number']          = ! empty( $data['staff_number'] ) ? $data['staff_number'] : $result['staff_number'];
            $dataEditAgency['bank_data']             = ! empty( $data['bank_data'] ) ? json_encode($data['bank_data']) : $result['bank_data'];
            $dataEditAgency['email']              = ! empty( $data['email'] ) ? strtolower( $data['email'] ) : $result['email'];
			$dataEditAgency['name_fa']            = ! empty( $data['nameFa'] ) ? $data['nameFa'] : $result['nameFa'];
			$dataEditAgency['name_En']            = ! empty( $data['nameEn'] ) ? $data['nameEn'] : $result['nameEn'];
			$dataEditAgency['accountant']         = ! empty( $data['accountant'] ) ? $data['accountant'] : $result['accountant'];
			$dataEditAgency['manager']            = ! empty( $data['manager'] ) ? $data['manager'] : $result['manager'];
			$dataEditAgency['phone']              = ! empty( $data['phone'] ) ? $data['phone'] : $result['phone'];
			$dataEditAgency['mobile']             = ! empty( $data['mobile'] ) ? $data['mobile'] : $result['mobile'];
			$dataEditAgency['domain']             = ! empty( $data['domain'] ) ? $data['domain'] : $result['domain'];
			$dataEditAgency['mainDomain']         = ! empty( $data['mainDomain'] ) ? $data['mainDomain'] : $result['mainDomain'];
			$dataEditAgency['fax']                = ! empty( $data['fax'] ) ? $data['fax'] : $result['fax'];
			$dataEditAgency['postal_code']        = ! empty( $data['postal_code'] ) ? $data['postal_code'] : $result['postal_code'];
			$dataEditAgency['city_iata']          = ! empty( $data['city_iata'] ) ? $data['city_iata'] : $result['city_iata'];
			$dataEditAgency['address_fa']         = ! empty( $data['addressFa'] ) ? $data['addressFa'] : $result['addressFa'];
			$dataEditAgency['address_en']         = ! empty( $data['addressEn'] ) ? $data['addressEn'] : $result['addressEn'];
			$dataEditAgency['isColleague']        = ! empty( $data['isColleague'] ) ? $data['isColleague'] : $result['isColleague'];
			$dataEditAgency['colorMainBg']        = isset( $data['colorMainBg'] ) ? $data['colorMainBg'] : $result['colorMainBg'];
			$dataEditAgency['colorMainBgHover']   = isset( $data['colorMainBgHover'] ) ? $data['colorMainBgHover'] : $result['colorMainBgHover'];
			$dataEditAgency['colorMainText']      = isset( $data['colorMainText'] ) ? $data['colorMainText'] : $result['colorMainText'];
			$dataEditAgency['colorMainTextHover'] = isset( $data['colorMainTextHover'] ) ? $data['colorMainTextHover'] : $result['colorMainTextHover'];
			$dataEditAgency['payment']            = ! empty( $data['payment'] ) ? $data['payment'] : $result['payment'];
			$dataEditAgency['aboutAgency']        = ! empty( $data['aboutAgency'] ) ? $data['aboutAgency'] : $result['aboutAgency'];
			$dataEditAgency['del']                = "no";
			$dataEditAgency['hasSite']            = ! empty( $data['hasSite'] ) ? $data['hasSite'] : $result['hasSite'];
			$dataEditAgency['limit_credit']       = (empty( $data['payment'] ) || $data['payment']=='cash') ? 0 : $data['limit_credit'];
			$dataEditAgency['type_payment']       = ! empty( $data['type_payment'] ) ? $data['type_payment'] : $result['type_payment'];
			$dataEditAgency['type_currency']      = ! empty( $data['type_currency'] ) ? $data['type_currency'] : $result['type_currency'];
            $dataEditAgency['time_limit_credit']  = ! empty( $data['time_limit_credit'] ) ? functions::FormatDateJalali($data['time_limit_credit']) : $result['time_limit_credit'];
            $dataEditAgency['raja_unique_code']   = ! empty( $data['raja_unique_code'] ) ? $data['raja_unique_code'] : $result['raja_unique_code'];
            $dataEditAgency['seat_charter_code']  = ! empty( $data['seat_charter_code'] ) ? $data['seat_charter_code'] : $result['seat_charter_code'];
            $dataEditAgency['sepehr_username']    = ! empty( $data['sepehr_username'] ) ? $data['sepehr_username'] : $data['sepehr_username'];
            $dataEditAgency['sepehr_password']    = ! empty( $data['sepehr_password'] ) ? $data['sepehr_password'] : $result['sepehr_password'];
            $dataEditAgency['ravis_code']         = ! empty( $data['ravis_code'] ) ? $data['ravis_code'] : $result['ravis_code'];

            if ( $dataEditAgency['hasSite'] == 1 && $dataEditAgency['domain'] != $result['domain'] ) {
				$dataEditAgency['active'] = ( $dataEditAgency['hasSite'] == 1 ) ? 'off' : 'on';
			}

			if ( empty( $data['password'] ) ) {
				$dataEditAgency['password'] = $result['password'];
			} else {
				$dataEditAgency['password'] = functions::encryptPassword( $data['password'] );
			}

			// logo
			if ( empty( $_FILES['logo'] ) ) {
				$success         = "done:" . $result['logo'];
                $dataEditAgency['logo'] = explode( ':', $success );
                $status_upload = true ;
			} else {
                $dataEditAgency['logo'] = $this->uploadPic('logo');
                $status_upload = !empty($data['logo']) ? true : false;
			}


			// license
            if ( empty( $_FILES['license'] ) ) {
                $dataEditAgency['license'] = $result['license'];
                $status_upload = true ;
            } else {
                $path = PIC_ROOT . 'agencyPartner/' . CLIENT_ID . '/license/'.$result['license'];
                $dataEditAgency['license'] = $this->uploadPic('license');
                !empty($dataEditAgency['license']) ? unlink($path) : '';
                $status_upload = !empty($dataEditAgency['license']) ? true : false;
            }
			// newspaper
            if ( empty( $_FILES['newspaper'] ) ) {
                $dataEditAgency['newspaper'] = $result['newspaper'];
                $status_upload = true ;
            } else {
                $path = PIC_ROOT . 'agencyPartner/' . CLIENT_ID . '/newspaper/'.$result['newspaper'];
                $dataEditAgency['newspaper'] = $this->uploadPic('newspaper');
                !empty($dataEditAgency['newspaper']) ? unlink($path) : '';
                $status_upload = !empty($dataEditAgency['newspaper']) ? true : false;
            }

			//pic aboutMePic
            if ( empty( $_FILES['aboutMePic'] ) ) {
                $dataEditAgency['aboutMePic'] = $result['aboutMePic'];
                $status_upload = true ;
            } else {
                $path = PIC_ROOT . 'agencyPartner/' . CLIENT_ID . '/aboutMePic/'.$result['aboutMePic'];
                $dataEditAgency['aboutMePic'] = $this->uploadPic('aboutMePic');
                !empty($dataEditAgency['aboutMePic']) ? unlink($path) : '';
                $status_upload = !empty($dataEditAgency['aboutMePic']) ? true : false;
            }

			if (  $status_upload ) {

                if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {
                    $separated_files = functions::separateFiles('gallery_files');
                    foreach ($separated_files as $file_key => $separated_file) {

                        $_FILES['file'] = $separated_file;
                        $config = Load::Config('application');
                        $config->pathFile('agencyPartner/' . CLIENT_ID .'/attachments/' );
                        $success = $config->UploadFile("pic", "file", 99900000);
                        $explode_name_pic = explode(':', $success);
                        if ($explode_name_pic[0] == "done") {

                            $insert_result = $agency_attachment_model->insertWithBind([
                                'client_id' => CLIENT_ID ,
                                'agency_id' => $result['id'],
                                'file_path' => $explode_name_pic[1],
                            ]);
                        }

                    }
                }




				$editAgency = $agency_model->updateWithBind( $dataEditAgency, "id='{$id}'" );
				if ( isset($editAgency) ) {
					$subAgencyInfo['id']       = $id;
					$subAgencyInfo['domain']   = $dataEditAgency['domain'];
					$checkExistSubAgencyResult = $this->subAgencyModel()->get()
                        ->where('client_id',CLIENT_ID)
                        ->where('agency_id',$result['id'])
                        ->where('url_agency',$dataEditAgency['domain'])->find();

					if ( $dataEditAgency['hasSite'] == 1 && empty( $checkExistSubAgencyResult ) ) {
						$dataSubAgency['agency_id']  = $this->agencyModel()->getLastId();
						$dataSubAgency['client_id']  = CLIENT_ID;
						$dataSubAgency['url_agency'] = $dataEditAgency['domain'];
						$this->subAgencyModel()->insertWithBind( $dataSubAgency );
					}
                    elseif ( $dataEditAgency['hasSite'] == 0 && ! empty( $checkExistSubAgencyResult ) ) {
                        $this->subAgencyModel()->deleteSubAgency( $checkExistSubAgencyResult );
					}
                    if (isset($data['sepehr_username']) && isset($data['sepehr_password'])) {
                        $dataSubAgencyCore['gds_id']  = $result['id'];
                        $dataSubAgencyCore['agency_name']  = $this->getClientAuthFlightInfo();
                        $dataSubAgencyCore['name_fa']  = ! empty( $data['nameFa'] ) ? $data['nameFa'] : $result['nameFa'];
                        $dataSubAgencyCore['sepehr_username']  = $data['sepehr_username'];
                        $dataSubAgencyCore['sepehr_password']  = $data['sepehr_password'];
                        $resultEditSubAgencyCore = Load::controller( 'settingCore' )->editSubAgencyCore($dataSubAgencyCore);
                        if (!isset($resultEditSubAgencyCore['status']) || $resultEditSubAgencyCore['status'] != 'success') {
                            return 'error : خطا در ثبت اطلاعات سپهر';
                        }
					}

					return 'success : اطلاعات آژانس با موفقیت ویرایش شد';
				} else {
					return 'error : خطا در ویرایش اطلاعات آژانس';
				}
			} else {
				return 'error :خطا در ویرایش اطلاعات آژانس' ;
			}

		}
        else {
			return "error : آژانس مورد نظر وجود ندارد،با وب مستر خود تماس بگیرید";
		}
	}

	public function showedit( $id = null ) {

		/** @var Model $Model */
		$Model = Load::library( 'Model' );
		
		if ( isset( $id ) && ! empty( $id ) ) {
			$edit_query = " SELECT * FROM  agency_tb  WHERE id='{$id}'";
			$res_edit   = $Model->load( $edit_query );
			if ( ! empty( $res_edit ) ) {
				$this->edit = $res_edit;
			} else {
				header( "Location: " . ROOT_ADDRESS . '/' . FOLDER_ADMIN . "/404.tpl" );
			}
		} else {
			header( "Location: " . ROOT_ADDRESS . '/' . FOLDER_ADMIN . "/404.tpl" );
		}
	}
	
	/**
	 * get all agency company
	 * @return array
	 */
	public function getAll() {
		/** @var agency_tb $agency */
		/** @var members_tb $members */
		/** @var credit_detail_tb $credit_detail */
		/** @var currency $currency */
		$agency  = Load::model( 'agency' );
		$currency  = Load::controller( 'currency' );
		$members = Load::model( 'members' );
		$credit_detail = Load::model( 'credit_detail' );
		$this->list    = $agency->getAll();
		foreach ( $this->list as $key => $rec ) {

			$num                              = $members->getNum( $rec['id'] );
			$this->list[ $key ]['numCounter'] = $num['count_id'];
			
			$credit_detail_info = $credit_detail->getAll_credit_desc( $rec['id'] );
			$credit_detail_asc  = $credit_detail->getAll_credit_asc( $rec['id'] );
//if($rec['id'] == '60'){
//    echo json_encode([$credit_detail_info , $credit_detail_asc]);
//    die();
//}

			$data_currency  = $currency->ShowInfo( $rec['type_currency'] );

            $this->list[$key]['currency_title'] = $data_currency['CurrencyTitle'];
            $this->list[$key]['type_payment_title'] = ($rec['type_payment'] == 'currency') ? 'ارزی' : 'ریالی';
            $this->list[$key]['limit_credit'] = $rec['limit_credit'] ;
            $this->list[$key]['check_time_limit_credit'] = ($rec['time_limit_credit'] > time()) ;
            $this->list[$key]['type_payment'] = $rec['type_payment'];
            $this->list[$key]['buy'] = $credit_detail_info['desc_credit'];
            $this->list[$key]['give'] = $credit_detail_asc['asc_credit'];
            $this->list[$key]['credit'] = $credit_detail_asc['asc_credit'] - $credit_detail_info['desc_credit'];
			
		}
		
	}
	
	/**
	 * delete agency company
	 */
	public function delete_agency( $id ) {
        /** @var agency_tb $agency */
		$agency = Load::model( 'agency' );
		$rec    = $agency->get( $id );
		/** @var members_tb $members */
		$members = Load::model( 'members' ); //analyze that agency don't have counters
		$num     = $members->getNum( $rec['id'] );
		if ( $num['count_id'] > 0 ) {
			return 'error : به دلیل داشتن کانتر این همکار قابل حذف نمی باشد';
		} else {
			
			$data['del'] = 'yes';
			Load::autoload( 'Model' );
			$mod = new Model();
			$mod->setTable( 'agency_tb' );
			$res = $mod->update( $data, "id='{$id}'" );
			
			if ( $res ) {

                $idArray = [
                    'gds_id' => $id,
                ];

                $resultDeleteSubAgencyCore = Load::controller( 'settingCore' )->deleteSubAgencyCore($idArray);
                if (!isset($resultDeleteSubAgencyCore['status']) || $resultDeleteSubAgencyCore['status'] != 'success') {
                    return 'error : خطا در حذف اطلاعات سپهر';
                }

				return 'success : حذف همکار مورد نظر با موفقیت انجام شد';
			} else {
				return 'error : خطا در حذف همکار';
			}
		}
		
		
		//         return $agency->delete($id);
	}

	/**
	 * get one agency company
	 * @return array
	 */
	public function get( $id = null ) {
		/** @var agency_tb $agency */
		$id     = ! empty( $id ) ? $id : Session::getAgencyId();
		$agency = Load::model( 'agency' );
		if ( $id != '' ) {
			$this->editID = $id;
		}
		$this->list = $agency->get( $id );
		
	}
	
	public function getCounterType() {
		/** @var counter_type_tb $counter */
		$counter = Load::model( 'counter_type' );
		$result  = $counter->getAll();
		
		$this->option = $result;
		
		//echo $this->option;
	}
	
	public function getNameCounterType( $id ) {
		/** @var counter_type_tb $counter */
		$counter = Load::model( 'counter_type' );
		$result  = $counter->getById( $id );
		
		return $result['name'];
	}
	
	public function getListAgency() {
		/** @var agency_tb $agency */
		$agency             = Load::model( 'agency' );
		$result             = $agency->getAll();
		$this->optionAgency = '';
		foreach ( $result as $val ) {
			$this->optionAgency .= "<option value='" . $val['id'] . "'> " . $val['name_fa'] . "</option>";
		}
		//echo $this->option;
	}
	
	public function login( $email, $password, $remember = 'off' ) {
		/** @var agency_tb $model */
		$model  = Load::model( 'agency' );
		$result = $model->login( $email, $password );
		if ( ! empty( $result ) ) {
			Session::LoginDo( $result['name_fa'], $result['id'], '', 'agency' );
			return true;
		}
		return false;
	}
	
	
	public function infoAgency( $id, $ClientId = null ) {
		if ( TYPE_ADMIN == '1' ) {
			/** @var admin $admin */
			$admin        = Load::controller( 'admin' );
			$AgencyQuery  = " SELECT * FROM  agency_tb  WHERE id='{$id}'";
			$AgencyResult = $admin->ConectDbClient( $AgencyQuery, $ClientId, "Select", "", "", "" );
		} else {
			/**/
			$AgencyResult = $this->agencyModel()->get()->where('id',$id)->find();
		}
		
		
		return $AgencyResult;
		
	}
	
	
	public function CreditAgency( $AgencyId ) {
		
		/** @var credit_detail_tb $credit_detail */
		$credit_detail = Load::model( 'credit_detail' );
		
		$credit_detail_info = $credit_detail->getAll_credit_desc( $AgencyId );
		$credit_detail_asc  = $credit_detail->getAll_credit_asc( $AgencyId );


		return  $credit_detail_asc['asc_credit'] - $credit_detail_info['desc_credit'];
		

	}
	
	
	public function CountTicketAgency( $AgencyId ) {
		/** @var Model $Model */
		$Model                   = Load::library( 'Model' );
		$queryCountTicketAgency  = "SELECT  count(request_number) AS TotalTicket,
                          (SELECT COUNT(request_number) FROM book_local_tb WHERE agency_id='{$AgencyId}' AND successfull='book' AND (flight_type='charter' OR flight_type='charterPrivate') AND request_cancel<>'confirm') AS CharterTicket,
                          (SELECT COUNT(request_number) FROM book_local_tb WHERE agency_id='{$AgencyId}' AND successfull='book' AND flight_type='system' AND request_cancel<>'confirm') AS SystemTicket
                          FROM  book_local_tb  WHERE agency_id='{$AgencyId}' AND request_cancel<>'confirm' AND successfull='book'";
		$ResultCountTicketAgency = $Model->load( $queryCountTicketAgency );
		
		return $ResultCountTicketAgency;
	}
	
	
	public function TicketsAgency( $AgencyId, $Limit = 'Yes' ) {
		/** @var Model $Model */
		$Model                  = Load::library( 'Model' );
		$queryCountTicketAgency = "SELECT  * FROM  book_local_tb  WHERE agency_id='{$AgencyId}' AND request_cancel<>'confirm' AND successfull='book' GROUP BY request_number ORDER BY creation_date_int ";
		
		if ( $Limit == 'Yes' ) {
			$queryCountTicketAgency .= " DESC LIMIT 0,5";
		}
		$ResultCountTicketAgency = $Model->select( $queryCountTicketAgency );
		
		return $ResultCountTicketAgency;
	}
	
	public function TicketsCancelAgency( $AgencyId ) {
		Load::autoload( 'Model' );
		$Model = new Model();
		$sql   = "SELECT cancel.*, book.origin_city,book.desti_city,book.flight_number,book.request_number
                FROM cancel_ticket_details_tb AS cancel
                LEFT JOIN book_local_tb AS book ON book.request_number = cancel.RequestNumber
                WHERE cancel.Status='RequestMember' AND book.agency_id='{$AgencyId}' ORDER BY  cancel.id DESC LIMIT 0,5   ";
		
		$resultCancel = $Model->select( $sql );
		
		return $resultCancel;
		
	}
	
	//    public function TotalAmountTicketAgency($AgencyId)
	//    {
	//        $Model = Load::library ('Model');
	//        $queryCountTicketAgency = "SELECT  * FROM  book_local_tb  WHERE agency_id='{$AgencyId}' GROUP BY request_number ORDER BY creation_date_int ";
	//
	//        $ticketAmount = $Model->select($queryCountTicketAgency);
	//
	//        if(empty($ticketAmount))
	//        {
	//            $ticketAmount = array();
	//        }
	//
	//        $Amount = 0;
	//        foreach ($ticketAmount as $ticket)
	//        {
	//            $Amount += functions::CalculateDiscount($ticket['request_number']);
	//        }
	//
	//        return $Amount ;
	//    }
	
	
	#region cityIataList
	public function cityIataList( $limit = null ) {
		
		/** @var Model $Model */
		$Model    = Load::library( 'Model' );
		$sql      = "
            SELECT DISTINCT
                ( FR.Departure_Code ) AS city_iata,
                FR.Departure_City AS city_name 
            FROM
                flight_route_tb AS FR
                INNER JOIN agency_tb AS A ON A.city_iata = FR.Departure_Code
            WHERE
                FR.local_portal = '0'
            ORDER BY
                FR.priorityDeparture
            {$limit}
            ";
		$cityList = $Model->select( $sql );
		
		return $cityList;
	}
	#endregion
	
	
	#region getAgencyListByCity
	public function getAgencyListByCity( $city_iata ) {
		$city = '';
		if ( isset( $city_iata ) && $city_iata != 'all' ) {
			$city = strtoupper( $city_iata );
			$city = " AND city_iata = '{$city}' ";
		}
		
		/** @var Model $Model */
		$Model      = Load::library( 'Model' );
		$sql        = " SELECT * FROM agency_tb  WHERE del='no' {$city} ORDER BY id DESC ";
		$agencyList = $Model->select( $sql );
		
		return $agencyList;
	}
	
	#endregion
	
	public function AgencyInfoByIdMember( $id ) {
		/** @var Model $Model */
		$Model = Load::library( 'Model' );
		$sql   = "SELECT agency.* FROM agency_tb AS agency
                LEFT JOIN members_tb AS member ON  member.fk_agency_id = agency.id
                WHERE member.id ='{$id}'";
		
		return $Model->load( $sql );
	}
	
	public function changeStatusAgency( $id ) {
		/** @var agency_tb $agency */
		$infoAgency = $this->getAgency( $id );
		if ( empty( $infoAgency['id'] ) ) {
            return 'error : خطا در غیر فعال کردن همکار لطفا با پشتیبانی تماس بگیرید';
		} else {
			$Model          = Load::library( 'Model' );
            if ($infoAgency['active'] == 'on') {
                $data['active'] = 'off';
            } else {
                $data['active'] = 'on';
            }

			$Model->setTable( 'agency_tb' );
			$res = $Model->update( $data, "id='{$id}'" );
			if ( $res ) {
                return 'success : وضعیت همکار با موفقیت تغییر یافت';
			} else {
                return 'error : خطا در تغییر وضعیت همکار';
			}
		}
	}
	
	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getAgency( $id ) {
		return $this->getModel('agencyModel')->get()->where('id',$id)->find();
	}
	
	public function checkWhiteLabelAgency( $id ) {
		$agencyInfo = $this->getAgency( $id );
		if ( ( ! empty( $agencyInfo['hasSite'] ) && $agencyInfo['hasSite'] != '1' ) || empty( $agencyInfo['hasSite'] ) ) {
			header( "Location: " . ROOT_ADDRESS . '/' . FOLDER_ADMIN . "/404.tpl" );
		}
	}
	
	public function checkExistAccessAgency( $agencyId, $id ) {
		$Model = Load::library( 'Model' );
		
		$sql = "SELECT * FROM  access_agency_service_tb WHERE agencyId='{$agencyId}' AND servicesGroupId='{$id}'";
		
		return $Model->load( $sql, 'assoc' );
		
	}
	
	public function changeStatusServiceAgency( $data ) {
		$Model            = Load::library( 'Model' );
		$infoAccessAgency = $this->checkExistAccessAgency( $data['agencyId'], $data['servicesGroupId'] );
		
		if ( ! empty( $infoAccessAgency ) ) {
			$conditionDelete = "agencyId='{$data['agencyId']}' AND servicesGroupId='{$data['servicesGroupId']}'";
			
			$Model->setTable( 'access_agency_service_tb' );
			$deleteAccess = $Model->delete( $conditionDelete );
			
			if ( $deleteAccess ) {
				$message['status']  = 'success';
				$message['message'] = 'تغییر دسترسی همکار با موفقیت انجام شد ';
			} else {
				$message['status']  = 'error';
				$message['message'] = 'خطا در تغییر دسترسی  همکار';
			}
			
		} else {
			$data['agencyId']        = $data['agencyId'];
			$data['servicesGroupId'] = $data['servicesGroupId'];
			$Model->setTable( 'access_agency_service_tb' );
			$deleteAccess = $Model->insertLocal( $data );
			
			if ( $deleteAccess ) {
				$message['status']  = 'success';
				$message['message'] = 'تغییر دسترسی همکار با موفقیت انجام شد ';
			} else {
				$message['status']  = 'error';
				$message['message'] = 'خطا در تغییر دسترسی  همکار';
			}
		}
		
		return json_encode( $message );
	}
	
	public function acceptSubAgencyWhiteLabel( $data ) {
		$Model            = Load::library( 'Model' );
		$infoAccessAgency = $this->getAgency( $data['agencyId'] );
		
		if ( ! empty( $infoAccessAgency ) ) {
			$conditionDelete      = "id='{$data['agencyId']}'";
			$dataUpdate['active'] = 'on';
			$Model->setTable( 'agency_tb' );
			$update = $Model->update( $dataUpdate, $conditionDelete );
			
			if ( $update ) {
				$message['status']  = 'success';
				$message['message'] = 'تغییر وضعیت همکار با موفقیت انجام شد ';
			} else {
				$message['status']  = 'error';
				$message['message'] = 'خطا در تغییر وضعیت  همکار';
			}
			
		} else {
			$message['status']  = 'error';
			$message['message'] = 'خطا در شناسایی  همکار';
			
		}
		
		return json_encode( $message );
	}
	
	public function listRequestAgency() {
		$clients = functions::AllClients();
		$admin   = Load::controller( 'admin' );
		
		$sqlAgency = "SELECT * FROM agency_tb WHERE active='off' AND hasSite='1'";
		foreach ( $clients as $key => $client ) {
			
			$agencyInfo = $admin->ConectDbClient( $sqlAgency, $client['id'], "Select", "", "", "" );
			if ( ! empty( $agencyInfo ) ) {
				$agency[]                     = $agencyInfo;
				$agency[ $key ]['clientName'] = $client['AgencyName'];
			}
			
		}
		
		
		return $agency;
	}
	
	public function checkAccessSubAgency() {
		/** @var searchService $checkAccessController */
		$checkAccessController = Load::controller( 'searchService' );
		return $checkAccessController->checkAccessService();
	}
	
	
	public function getReportCreditAgency() {
		/** @var credit_detail_tb $creditDetail */
		$creditDetail = Load::model( 'credit_detail' );
		
		$agencyId           = Session::getAgencyId();
		$resultCreditDetail = $creditDetail->getAll( $agencyId );
		
		
		$listCredit = array();

        $type_service_title = '';
		foreach ( $resultCreditDetail as $key => $creditAgency ) {
			$listCredit[ $key ]['requestNumber'] = !empty( $creditAgency['requestNumber']) ? $creditAgency['requestNumber']: $creditAgency['factorNumber'];
            if ($creditAgency['type'] === 'increase') {
                $listCredit[ $key ]['credit'] = '<span class="text-success">' . number_format($creditAgency['credit']) . ' + </span>';
            } else {
                $listCredit[ $key ]['credit'] = '<span class="text-danger">(' . number_format($creditAgency['credit']) . ')</span>';
            }
			$listCredit[ $key ]['comment']       = $creditAgency['comment'];
			$listCredit[ $key ]['dateBuy']       = dateTimeSetting::jdate( 'H:i:s Y-m-d ', $creditAgency['creation_date_int'], '', '', 'en' );
//			$listCredit[ $key ]['reason']        = functions::translateReasonCredit( $creditAgency['reason'] );
			$listCredit[ $key ]['typeCredit']    = ( $creditAgency['type'] == 'increase' ) ? functions::Xmlinformation( 'ChargeAccountOrCreditor' )->__toString() : functions::Xmlinformation( 'DecreaseChargeOrDebtor' )->__toString();
			$listCredit[ $key ]['type']    = $creditAgency['type'];
            if ($creditAgency['balance_after'] < 0) {
                $creditAgency['balance_after'] =  '(' . number_format(abs($creditAgency['balance_after'])) . ')';
            } else {
                $creditAgency['balance_after'] = number_format($creditAgency['balance_after']);
            }
			$listCredit[ $key ]['balance_after']    = $creditAgency['balance_after'];
		}
        
		return json_encode( array( 'data' => $listCredit ) );
		
	}
	
	public function getAgencyAttachments( $agencyId = null,$clientId = null ) {
		if(!$agencyId){
			return false;
		}
		/** @var agencyAttachmentModel $agencyAttachment */
		$agencyAttachment = Load::getModel( 'agencyAttachmentModel' );
        return $agencyAttachment->getAgencyAttachments($agencyId,$clientId);

	}
	
	public function agencyUploadAttachments( $data ) {
		
		$agencyAttachment = Load::getModel( 'agencyAttachmentModel' );
		$config           = Load::Config( 'application' );
		$result           = false;
		if ( isset( $_FILES['file'] ) && $_FILES['file'] != "" ) {
			$config->pathFile( 'agencyPartner/' . CLIENT_ID . '/attachments/' );
			$success          = $config->UploadFile( "", "file", "" );
			$explode_name_pic = explode( ':', $success );
			if ( $explode_name_pic[0] != 'done' ) {
				$errorUploadPic        = true;
				$errorMessageUploadPic = $success;
				
				return functions::withError( $success, 500, functions::Xmlinformation( 'UploadError' )->__toString() );
			}
			$data['agency_id'] = isset($data['agency_id']) ? $data['agency_id'] : Session::getAgencyId();
			$result = $agencyAttachment->newAttachment( $data['agency_id'], CLIENT_ID, $explode_name_pic[1] );
			
			return functions::withSuccess( $result, 201, functions::Xmlinformation( 'UploadSuccess' )->__toString() );
		}
		
		return functions::withError( $result, 400, functions::Xmlinformation( 'UploadError' )->__toString() );
	}
	
	public function agencyRemoveAttachments( $data ) {
		$agencyAttachment = Load::getModel( 'agencyAttachmentModel' );
		$remove = $agencyAttachment->deleteAttachment($data['attachment_id']);
		
		if($remove){
			return functions::withSuccess($remove,200,'Removed successfully');
		}
		return functions::withSuccess($remove,400,'Remove Error');
	}

    /**
     * @param $name_file
     * @return array
     */
    private function uploadPic($name_file ) {
// logo
        $application = $this->application() ;
        $application->pathFile('agencyPartner/' . CLIENT_ID . '/'. $name_file .'/');
        $success = $application->UploadFile("pic", $name_file, "");
        $explode_name_pic = explode(':', $success);
        if ($explode_name_pic[0] == 'done') {
            $info_file = $explode_name_pic[1];
        } else {
            $info_file = '';
        }
        return $info_file;
    }


    public function showInfoCurrency($currency_code) {
        /** @var currency $info_currency */
        $currency_controller = Load::controller('currency');
        $info_currency = $currency_controller->ShowInfo($currency_code);
        return $info_currency ;
    }


    public function getDocuments( $agencyId = null ) {

        if(!$agencyId){
            return false;
        }
        /** @var agencyAttachmentModel $agencyAttachment */
        $agencyDocuments = Load::getModel( 'agencyDocumentModel' );
        return $agencyDocuments->getDocuments($agencyId);
    }

    public function RemoveSingleFile($Param){

        $agency_attachment_model = $this->getModel('agencyAttachmentModel');

        $check_exist = $agency_attachment_model->get()
            ->where('id', $Param['GalleryId'])
            ->find();

        if ($check_exist) {

            $agency_attachment_model->delete([
                'id' => $check_exist['id']
            ]);
            $path = PIC_ROOT . 'agencyPartner/' . CLIENT_ID . '/attachments/'. $check_exist['file_path'];
            unlink($path);
        }

        return $this->returnJson(true, 'حذف شد', $check_exist['id']);
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], 256 | 64);

        return $return;
    }


    public function getAgencies() {
        return $this->getModel('agencyModel')->get()->where('del' , 'no')->all();
    }
    public function getCharterAgencies() {
        return $this->getModel('agencyModel')
            ->get()
            ->where('del' , 'no')
            ->where('seat_charter_code' , '','!=')
            ->all();
    }
    public function getBankList() {
        return $this->getController('bankList')->index();
    }

    public function getSumCreditAgency($agency_id) {

        /** @var credit_detail_tb $credit_detail */
        $credit_detail = Load::model( 'credit_detail' );

        $credit_detail_info['sum_decrease_credit'] = $credit_detail->getAll_credit_desc( $agency_id )['desc_credit'];
        $credit_detail_info['sum_increase_credit']  = $credit_detail->getAll_credit_asc( $agency_id )['asc_credit'];

        return $credit_detail_info ;
    }

    public function getAllPassengers($agencyId , $memberId = null) {
        Load::autoload('Model');
        $Model = new Model();
        $sql = "
                    SELECT 
                        passenger.name AS passengerName,
                        passenger.family AS passengerFamily,
                        passenger.name_en AS passengerNameEn,
                        passenger.family_en AS passengerFamilyEn,
                        passenger.birthday AS passengerBirthday,
                        passenger.birthday_fa AS passengerBirthdayFa,
                        passenger.NationalCode AS nationalCode,
                        passenger.passportNumber AS passportNumber,
                        passenger.is_foreign AS isForeign,
                        member.name AS counterName,
                        member.family AS counterFamily,
                        passenger.register_date AS registerDate
                    FROM 
                        passengers_tb AS passenger
                        INNER JOIN members_tb AS member ON member.id = passenger.fk_members_tb_id
                        INNER JOIN agency_tb AS agency ON agency.id = member.fk_agency_id
                    WHERE 
                        member.fk_agency_id = {$agencyId}
                        AND member.del = 'no'
                        AND passenger.del = 'no'
                        AND (member.fk_counter_type_id > '0'  )
                    ";
        if ($memberId !== null && $memberId > 0) {
            $sql .= " AND member.id = {$memberId} ";
        }
        $sql .= "
                    ORDER BY 
                        passenger.register_date ASC
                    ";
        $result = $Model->select($sql);
        return $result;
    }
    public function subAgencyInfo() {
        $is_login = Session::IsLogin();
        $is_counter = Session::getTypeUser();
        $is_counter_login = ($is_login && $is_counter == 'counter') ? true: false;
        $UserInfo = array();
        if($is_counter_login){
            $UserId = Session::getUserId();
            $agencyInfo = $this->AgencyInfoByIdMember($UserId);
            return $agencyInfo;
        }
        else {
            return null;
        }
    }
}