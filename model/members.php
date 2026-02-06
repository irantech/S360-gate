<?php
//if($_SERVER['REMOTE_ADDR'] == '93.118.161.174') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}
class members_tb extends Model {

	protected $table = 'members_tb';
	protected $pk = 'id';

	public function getAll() {
		$result = parent::select("select * from $this->table  ORDER BY $this->pk ASC");

		return $result;
	}

	/**
	 * @param $type number beetwen 0(for get online passengers) or 1(for get counters exept online passenger).
	 * @param $id number(id counter_type_tb) , for get counters with special type
	 * @return array
	 * an associative array on success
	 */
	public function getCounters($type = 5, $id = '') {
		if ($type == '' || $type == 5) {
			$result = parent::select("select * from $this->table where is_member='0' and del='no'  ORDER BY $this->pk ASC");
		} elseif ($type == 1 && $id == '') {
			$result = parent::select("select * from $this->table where is_member='1'  and del='no'  ORDER BY $this->pk ASC");
		} else {
			$result = parent::select("select * from $this->table where fk_counter_type_id ='$id' and del='no'  ORDER BY $this->pk ASC");
		}

		return $result;
	}
	
	/**
	 * @param $id number(id agency_tb) , for get counters with special agency
	 *
	 * @return array
	 */
	public function getCountersByAgency($id = '',$isMember) {
		if($isMember=='2')//مدیر
            $CommandMember="AND member.is_member = '2' ";
        else
            $CommandMember="
                AND ( member.fk_counter_type_id > '0' AND member.fk_counter_type_id <> '5' )
                AND member.is_member != '2' ";//کانتر

        $sql="SELECT
            member.*,
            agency.name_fa AS agencyName,
            ( SELECT COUNT( DISTINCT request_number ) FROM book_local_tb WHERE member_id = member.id AND successfull = 'book' AND request_cancel <> 'confirm' AND agency_id = {$id}) + ( SELECT COUNT( DISTINCT passenger_factor_num ) FROM book_bus_tb WHERE member_id = member.id AND STATUS = 'book' AND request_cancel <> 'confirm' AND agency_id = {$id}) + ( SELECT COUNT( DISTINCT requestNumber ) FROM book_entertainment_tb WHERE member_id = member.id AND successfull = 'book' AND request_cancel <> 'confirm' AND agency_id = {$id}) + ( SELECT COUNT( DISTINCT request_number ) FROM book_hotel_local_tb WHERE member_id = member.id AND STATUS = 'BookedSuccessfully' AND agency_id = {$id}) + ( SELECT COUNT( DISTINCT factor_number ) FROM book_insurance_tb WHERE member_id = member.id AND STATUS = 'book' ) + ( SELECT COUNT( DISTINCT factor_number ) FROM book_tour_local_tb WHERE member_id = member.id AND `status`= 'BookedSuccessfully' AND cancel_status <> 'SuccessfullyCancel' AND agency_id = {$id} ) + ( SELECT COUNT( DISTINCT requestNumber ) FROM book_train_tb WHERE member_id = member.id AND successfull = 'book' AND request_cancel <> 'confirm' AND agency_id = {$id}) + ( SELECT COUNT( DISTINCT factor_number ) FROM book_visa_tb WHERE member_id = member.id AND STATUS = 'book' AND agency_id = {$id}) AS CountCustomer,
            ( SELECT COUNT( id ) FROM passengers_tb WHERE fk_members_tb_id = member.id AND del = 'no' ) AS CountPassenger 
        FROM
            {$this->table} AS member
            LEFT JOIN agency_tb AS agency ON agency.id = member.fk_agency_id 
        WHERE
            member.fk_agency_id = {$id} 
            AND member.del = 'no' 
            ".$CommandMember." 
        ORDER BY
            id ASC
	    ";
        $result = parent::select($sql);
		return $result;
	}


	public function members_insert($members) {


		$cardNo = $this->generateCardNo();
		//do not repeat reagent code
		do {
			$reagentCode = functions::generateRandomCode(5);
			$resultRepeat = $this->getByReagentCode($reagentCode);
		} while ($resultRepeat != 0 && is_array($resultRepeat));

        /** @param string $index_name Either "email" or "mobile". */
        if(!filter_var($members['entry'], FILTER_VALIDATE_EMAIL)){
            $data['mobile'] = $members['entry'];
            $infoRegisterClub['mobile'] = $members['entry'];
        }

		$data['password'] = $this->encryptPassword($members['password']);
		$data['name'] = $members['name'];
		$data['family'] = $members['family'];
        $data['user_name'] = strtolower($members['entry']);
        if(functions::isMobileOrEmail($members['entry']) ==='mobile'){
            $data['mobile'] = $members['entry'];
        }
		$data['TypeOs'] = $members['TypeOs'];
		$data['fk_counter_type_id'] = '5';
		$data['fk_agency_id'] = SUB_AGENCY_ID > 0 ? SUB_AGENCY_ID : '0';
		$data['is_member'] = '1';
		$data['card_number'] = $cardNo;
		$data['reagent_code'] = $reagentCode;


		return parent::insertLocal($data);



	}

//	افزودن کاربری که قبلا به عنوان مهمان خرید داشته است
    public function guestMembersInsert($members) {


        $cardNo = $this->generateCardNo();
        //do not repeat reagent code
        do {
            $reagentCode = functions::generateRandomCode(5);
            $resultRepeat = $this->getByReagentCode($reagentCode);
        } while ($resultRepeat != 0 && is_array($resultRepeat));

        if(trim($members['name']) !="" && trim($members['family']) !="")
        {
            /** @param string $index_name Either "email" or "mobile". */
            if(filter_var($members['entry'], FILTER_VALIDATE_EMAIL)){
                $index_name='user_name';
            }else{
                $data['mobile'] = $members['entry'];
                $index_name='mobile';
                $infoRegisterClub['mobile'] = $members['entry'];
            }


            $data['password'] = $this->encryptPassword($members['password']);
            $data['user_name'] = strtolower($members['entry']);
            if(functions::isMobileOrEmail($members['entry']) ==='mobile'){
                $data['mobile'] = $members['entry'];
            }
            $data['name'] = $members['name'];
            $data['family'] = $members['family'];
            $data['TypeOs'] = $members['TypeOs'];
            $data['fk_counter_type_id'] = '5';
            $data['fk_agency_id'] = '0';
            $data['is_member'] = '1';
            $data['card_number'] = $cardNo;
            $data['reagent_code'] = $reagentCode;
            $condition="{$index_name}='{$members['entry']}'";
            return parent::update($data,$condition);
        }
        return false;


    }

	//افزودن کانتر به سیستم

	public function generateCardNo() {
        $result = parent::load("select MAX(card_number) as MaxCardNo from $this->table");
		if (!empty($result)) {
			$maxCardNo = $result['MaxCardNo'];
		} else {
			$maxCardNo = 0;
		}

		if ($maxCardNo == 0) {
			$card_number = CLIENT_PRE_CARD_NO . "00000001";
		} else {
			$dynamic_section = substr($maxCardNo, 8, 8) + 1;
			$zero_section = '';
//            $card_number = sprintf("%s%08d", CLIENT_PRE_CARD_NO,$dynamic_section);
			for ($j = strlen($dynamic_section); $j < 8; $j++) {
				$zero_section .= '0';
			}
			$card_number = CLIENT_PRE_CARD_NO . $zero_section . $dynamic_section;
		}

		return $card_number;

	}

	public function getByReagentCode($reagentCode) {
		$result = parent::load("select * from $this->table where reagent_code = '$reagentCode'");
		if (!empty($result)) {
			return $result;
		} else {
			return 0;
		}
	}

	public function encryptPassword($password) {
		return hash('sha512', 'sd45sv#FEgfe@%&*4RG656Sssd5' . $password . '4sF7s85fEW');
	}

	//    function members_delete($id) {
	//        $data['del'] = "yes";
	//        $res = parent::update($data, "id='$id'");
	//        if ($res) {
	//            echo 'success:حذف کانتر با موفقیت صورت گرفت';
	//        } else {
	//            echo 'خطا در حذف کانتر ،لطفا با وب مستر خود تماس گرفته یا مجددا تلاش نمائید';
	//        }
	//    }

	public function addCounter($members) {

        if(trim($members['name']) !="" && trim($members['family']) !="") {
            $cardNo = $this->generateCardNo();

            $data['email'] = strtolower($members['email']);
            $data['name'] = $members['name'];
            $data['password'] = $this->encryptPassword($members['password']);
            $data['family'] = $members['family'];
            $data['mobile'] = $members['mobile'];
            $data['fk_counter_type_id'] = $members['typeCounter'];
            $data['fk_agency_id'] = $members['agency_id'];
            $data['is_member'] = '1';
            $data['accessAdmin'] = $members['accessAdmin'];
            $data['card_number'] = $cardNo;

            return parent::insertLocal($data);
        }
        return false;
	}

	public function Login($entry, $password_data) {
        $entry = strtolower($entry);
		 $sql = "SELECT * FROM $this->table WHERE  user_name='{$entry}' AND password='{$password_data}' AND is_member = '1' AND active='on'";

		return parent::load($sql);
	}

    public function LoginByEntry($email) {
         $sql = "SELECT * FROM $this->table WHERE  email='{$email}' AND is_member = '1' AND active='on'";

        return parent::load($sql);
    }

	public function updateCounter($info_counter) {

        $checkMembersExist = $this->getCheckMembersExist($info_counter['email']);

        if (!empty($checkMembersExist) && ($checkMembersExist['email'] != $info_counter['email'])) {
			echo "error : این ایمیل قبلا ثبت شده است،لطفا ایمیل دیگری را وارد نمائید";
		} else {
			$result = parent::load("select * from $this->table where $this->pk = '{$info_counter['counter_id']}' and  del='no'");

			$id = $info_counter['counter_id'];
			if (!empty($result)) {

			    if(trim($info_counter['name'])!="" && trim($info_counter['family']) !="")
                {
                    $data['email'] = strtolower($info_counter['email']);
                    $data['name'] = $info_counter['name'];
                    $data['family'] = $info_counter['family'];
                    $data['mobile'] = $info_counter['mobile'];
                    $data['email'] = $info_counter['email'];
                    $data['fk_agency_id'] = $info_counter['agency_id'];
                    $data['accessAdmin'] = $info_counter['accessAdmin'];
                    $data['fk_counter_type_id'] = $info_counter['typeCounter'];
                    if (empty($info_counter['password'])) {
                        $data['password'] = $result['password'];
                    } else {
                        $data['password'] = $this->encryptPassword($info_counter['password']);
                    }

                    $res_update = parent::update($data, "id='{$id}'");

                    if ($res_update) {
                        echo 'success : اطلاعات کانتر با موفقیت ویرایش شد';
                    } else {
                        echo 'error : خطا در ویرایش اطلاعات کانتر';
                    }
                }else{
                    echo 'error : خطا در ویرایش اطلاعات کانتر';
                }

			} else {

				echo "error : کانتر مورد نظر وجود ندارد،با وب مستر خود تماس بگیرید";
			}
		}

	}

	public function updateProfile($InfoMembers, $id) {

	    if(trim($InfoMembers['name']) !="" && trim($InfoMembers['family']) !="")
        {
            return parent::update($InfoMembers, " id = '{$id}' ");
        }
		return false ;
	}

	public function convert_counter($id) {

		$data['fk_counter_type_id'] = '5';
		$data['fk_agency_id'] = '0';

		$infoMember = self::get($id);
		$dataClub['counterTypeId'] = $data['fk_counter_type_id'];
		$dataClub['cardNumber'] = $infoMember['card_number'];
		$resultCurl = functions::UpdateMemberInClub($dataClub);
		functions::insertLog('infoResultUpdateUserInClub=>' . json_encode($resultCurl), 'log_update_userInClub');

		return parent::update($data, "id='$id'");
	}

	public function getNum($id) {

		//        echo "select count(id) from $this->table where del!='yes' and fk_agency_id='$id'";
		$members = parent::load("select count(id) AS count_id from $this->table where del!='yes' and fk_agency_id='$id'");

		return $members;
	}

	public function updatePass($pass, $id) {
		$data = array('password' => $pass);

		return parent::update($data, "id='$id'");

	}

	public function active($id) {
		$rec = self::get($id);
		if ($rec['active'] == 'on') {
			$data = array('active' => "off");
		} else {
			$data = array('active' => "on");
		}
		$res = parent::update($data, "id='{$id}'");
		if ($res) {
			echo 'success : وضعیت کاربر با موفقیت تغییر یافت';
		} else {
			echo 'error : خطا در تغییر وضعیت کاربر';
		}
	}
	
	/**
	 * @param array|string $id
	 *
	 * @return mixed
	 */
	public function get($id = null) {
		$id = ($id) ? $id : Session::getUserId();
		$result = parent::load("SELECT * FROM $this->table WHERE $this->pk = '{$id}'");
        return $result;
	}

	public function activeUser($id) {
		$rec = self::get($id);
		if ($rec['active'] == 'on') {
			$data = array('active' => "off");
		} else {
			$data = array('active' => "on");
		}
		$res = parent::update($data, "id='{$id}'");
		if ($res) {
			echo 'success : وضعیت کاربر با موفقیت تغییر یافت';
		} else {
			echo 'error : خطا در تغییر وضعیت کاربر';
		}
	}

	public function getByEmail($email) {

		$result = parent::load("select * from $this->table where `user_name`= '$email'");
		if (!empty($result)) {
			return $result;
		} else {
			return 0;
		}
	}

    public function getByEntry($entry) {
        $sql="select * from $this->table where (`user_name`= '$entry' OR `mobile`= '$entry') order by `id` limit 1";
        $result = parent::load($sql);

        if (!empty($result)) {
            return $result;
        } else {
            return 0;
        }
    }
    public function checkByEntry($entry) {
        $sql="select count(id) as existence from $this->table where (`user_name`= '$entry' OR `mobile`= '$entry') order by `id` limit 1";
        $result = parent::load($sql);

        if (!empty($result['existence']) && $result['existence'] > 0) {
            return true;
        } else {
            return false;
        }
    }

	public function getById($id) {
		$result = parent::load("select * from $this->table where id= '$id'");
		if (!empty($result)) {
			return $result;
		} else {
			return 0;
		}
	}

	public function getByRememberCode($code) {
		$result = parent::load("select * from $this->table where remember_code= '$code'");
		if (!empty($result)) {
			return $result;
		} else {
			return 0;
		}
	}

	public function membersCreditAdd($data) {
		$data['creationDateInt'] = time();

		parent::setTable('members_credit_tb');

		return parent::insertLocal($data);
	}

	public function getPresenterReagentCode($id) {
		$query = "SELECT reagentCode FROM members_credit_tb WHERE memberId = '{$id}' AND reason = 'reagent_code_presented'";
		$result = parent::load($query);

		if (!empty($result)) {
			return $result['reagentCode'];
		} else {
			return 0;
		}
	}

	public function memberHasFirstBuy($id) {
		$query = "SELECT COUNT(id) AS FirstBuy FROM members_first_buy_tb WHERE memberId = '{$id}'";
		$result = parent::load($query);

		if ($result['FirstBuy'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function memberFirstBuyAdd($id) {
		$data['memberId'] = $id;
		$data['creationDateInt'] = time();

		parent::setTable('members_first_buy_tb');

		return parent::insertLocal($data);
	}

	public function getMemberCredit($id) {
		$query = "SELECT
                  (SELECT SUM(amount) FROM members_credit_tb WHERE state = 'charge' AND status = 'success' AND memberId = '{$id}') AS TotalCharge,
                  (SELECT SUM(amount) FROM members_credit_tb WHERE state = 'buy' AND status = 'success' AND memberId = '{$id}') AS TotalBuy
                  ";
		$result = parent::load($query);


		if (!empty($result)) {
			return $result['TotalCharge'] - $result['TotalBuy'];
		} else {
			return 0;
		}
	}

	public function getPresentedMembers($reagentCode) {
		$query = "SELECT M.id, M.name, M.family, MC.amount, MC.creationDateInt, " . " (SELECT creationDateInt FROM members_first_buy_tb WHERE memberId = M.id) AS firstBuyDate" . " FROM members_tb M INNER JOIN members_credit_tb MC ON M.id = MC.memberId " . " WHERE MC.reason = 'reagent_code_presented' AND MC.reagentCode = '{$reagentCode}' AND status = 'success' ";

		return parent::select($query);
	}

	public function memberCreditsList($id) {
		$query = "SELECT * FROM members_credit_tb WHERE memberId = '{$id}' AND status = 'success' ";

		return parent::select($query);
	}

    public function listMembersAgency($agencyId)
    {
        $query = "SELECT * FROM {$this->table} WHERE fk_agency_id = '{$agencyId}' AND del='no'";

		return parent::select($query);
	}

    /**
     * @param $email
     * @return mixed
     */
    public function getCheckMembersExist($email) {
        $checkMembersExist = parent::load("select * from $this->table where  user_name = '{$email}' and  del='no'");
        return $checkMembersExist;
    }

}
