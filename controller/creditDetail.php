<?php

/**
 * Class CreditDetail
 * @property CreditDetail $CreditDetail
 */
class CreditDetail extends clientAuth
{

	public $id = '';
	public $agencyID = '';
	public $credit = '';
	public $becauseOf = '';
	public $date = '';
	public $comment = '';
	public $list;
	public $message;
	public $total_charge;
	public $total_buy;
	public $total_transaction;

	public function __construct(){
        parent::__construct();
	}
    //region [agencyModel]
    /**
     * @return bool|mixed|agencyModel
     */
    public function agencyModel() {
        return Load::getModel( 'agencyModel' );
    }
    //endregion

    //region [creditDetailModel]
    /**
     * @return bool|mixed|creditDetailModel
     */
    public function creditDetailModel() {
        return Load::getModel( 'creditDetailModel' );
    }
    //endregion

	/**
	 * get all credit company
	 * @return information array
	 */
	public function getAll($agencyID)
	{

		$agencyID = !empty($agencyID) ? $agencyID : Session::getAgencyId();
		$Model = Load::library('Model');

        $sql_list = "SELECT * FROM credit_detail_tb WHERE fk_agency_id='{$agencyID}' AND (PaymentStatus='success' OR PaymentStatus IS NULL)  ORDER BY register_date DESC";

		$this->list = $Model->select($sql_list);

		$sql_charge = "SELECT sum(credit) AS total_charge FROM credit_detail_tb WHERE type='increase' AND fk_agency_id='{$agencyID} ' AND (PaymentStatus='success' OR PaymentStatus IS NULL)";
		$charge = $Model->load($sql_charge);
		$this->total_charge = $charge['total_charge'];

		$sql_buy = "SELECT sum(credit) AS total_buy FROM credit_detail_tb WHERE type='decrease' AND fk_agency_id='{$agencyID}' AND (PaymentStatus='success' OR PaymentStatus IS NULL)";
		$buy = $Model->load($sql_buy);
		$this->total_buy = $buy['total_buy'];

		$this->total_transaction = $this->total_charge - $this->total_buy;
	}

	public function getAllCharge($agencyID)
	{
		/** @var credit_detail_tb $agency */
		$agency = Load::model('credit_detail');

		return $agency->getAllCharge($agencyID);
	}

	public function insert_credit($infoCredit , $hasOutput = true)
	{
		$agency =  $this->agencyModel()->get()->where('id',$infoCredit['agencyID'])->find();
		if (!empty($agency)) {
            $info_currency_equivalent = array();
		    if($agency['type_currency'] > 0){
                /** @var currencyEquivalent $currency_equivalent */
                $currency_equivalent_controller = Load::controller('currencyEquivalent');
                $info_currency_equivalent = $currency_equivalent_controller->InfoCurrency($agency['type_currency']);
            }
			$data ['fk_agency_id'] = $infoCredit['agencyID'];
            $data['currency_code'] = $agency['type_currency'] > 0 ? $agency['type_currency'] : 0;
            $data['currency_equivalent'] = $info_currency_equivalent['EqAmount'] > 0 ?  $info_currency_equivalent['EqAmount'] : 0;
			$data['credit'] = $infoCredit['credit'];
			$data['type'] = $infoCredit['becauseOf'];
			$data['credit_date'] = dateTimeSetting::jdate("Y-m-d", time(),'','','en');
			$data['comment'] = $infoCredit['comment'];
			$data['creation_date_int'] = time();
            $result  = $this->creditDetailModel()->insertWithBind($data);
			$last_id = $this->creditDetailModel()->getLastId();
			if ($result && $hasOutput) {
				/*todo : function to insert agency credit in accountant system */
//				functions::accountantApiRequestInsertBrokerData($infoCredit['agencyID'], $infoCredit['credit'], 'decrease',$infoCredit['comment']);

				echo 'success :اعتبار مورد نظر با موفقیت ثبت گردید';

			} elseif($hasOutput) {
				echo 'error :  بروز اشکال در ثبت اعتبار ';
			}

		} elseif($hasOutput) {
			echo 'error : آژانس مورد نظر معتبر نمی باشد';
		}
	}

	public function DateJalali($param)
	{
		$split = explode(' ', $param);
		$explode_date = explode('-', $split[0]);
		$date_now = dateTimeSetting::gregorian_to_jalali($explode_date[0], $explode_date[1], $explode_date[2], '/');

		return isset($split[1]) ? $split[1] . ' ' . $date_now : $date_now;
	}

    public function timeToDateJalali($time)
    {
        return dateTimeSetting::jdate("Y/m/d H:i:s", $time,'','','en');
    }


    //region [findCreditRecode]

    /**
     * @param $request_number
     * @return mixed
     */
    public function findCreditRecode($request_number) {

	    return $this->getModel('creditDetailModel')->get()->where('requestNumber',$request_number)->find();
	}
    //endregion

    public function addIncreaseCreditByAgency($params) {

        $agency_id = Session::getAgencyId();
        $info_credit = $this->getModel('creditDetailModel')->get()->where('factorNumber',$params['factor_number'])
            ->where('fk_agency_id',$agency_id)
            ->where('PaymentStatus','success')
            ->find();

        if(empty($info_credit)){
            $type_pay = ($params['reason']=='settle') ? 'تسویه اعتبار مصرف شده غیر مالی' : 'افزایش اعتبار' ;
            $info_agency = $this->getController('agency')->infoAgency($agency_id,CLIENT_ID);
            $data_transaction['fk_agency_id'] = $agency_id;
            $data_transaction['credit'] = $params['price'];
            $data_transaction['factorNumber'] = $params['factor_number'];
            $data_transaction['type'] = 'increase';
            $data_transaction['reason'] = ($params['reason']=='settle') ? 'settle' : 'deposit';
            $data_transaction['member_id'] = 0;
            $data_transaction['comment'] = $type_pay.' توسط آژانس ';
            $data_transaction['comment'] .= $info_agency['name_fa'];
            $data_transaction['PaymentStatus'] = 'pending';
            $data_transaction['creation_date_int'] = time();
            $data_transaction['credit_date'] = dateTimeSetting::jdate('Y-m-d',time(),'','','en');

            $this->getModel('creditDetailModel')->insertLocal($data_transaction);
        }
    }

    public function updateIncreaseCreditByAgency($params) {
        $agency_id = Session::getAgencyId();
        $info_credit = $this->getModel('creditDetailModel')->get()->where('factorNumber',$params['factor_number'])
            ->where('fk_agency_id',$agency_id)
            ->where('PaymentStatus','pending')
            ->find();

        if(!empty($info_credit)){
            $type_pay = ($info_credit['reason']=='settle') ? 'تسویه اعتبار مصرف شده غیر مالی' : 'افزایش اعتبار' ;
            $info_agency = $this->getController('agency')->infoAgency($agency_id);
            $comment = $type_pay ;
            $comment .= " ،توسط آژانس ";
            $comment .= $info_agency['name_fa'] ;
            $comment .= " با شماره پیگیری ";
            $comment .= $params['tracking_code'] ;
            $data_transaction['trackingCode'] = $params['tracking_code'];
            $data_transaction['comment'] = $comment;
            $data_transaction['PaymentStatus'] = 'success';

            $condition = "factorNumber ='{$params['factor_number']}' AND fk_agency_id='{$agency_id}'";

            $this->getModel('creditDetailModel')->update($data_transaction,$condition);
        }



    }


}
