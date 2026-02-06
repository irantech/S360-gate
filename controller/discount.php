<?php 
class Discount
{
	public $message=''; 	  //message that show after insert new agency

	public function __construct(){		
		 //////////// edit discount ///////////////////
		if (isset($_POST['flag']) and $_POST['flag']=='edit'){ 
			$airline=Load::model('airline');
			$counter=Load::model('counter_type');
			$listAriline=$airline->getAll();
			$listType=$counter->getAll('all');
			foreach ($listAriline as $valA){
				foreach ($listType as $valT){
					$post=$valA['id']."-".$valT['id'];
					if($valT['id']!='0' and isset($_POST["$post"])){
						
						$result=self::update($valA['id'],$valT['id'],$_POST["$post"]);						
					}
				}
			}
			$this->message='<p class="m-success">بروز رسانی با موفقیت صورت گرفت</p>';
		}
	}
	
	public function update($airlinID,$counterTypeID,$amount){
		$discount=Load::model('discount');
		return $discount->update($airlinID,$counterTypeID,$amount);
	}	
	/**
	 * get percent of discount
	 * @return integer
	 */
	public function get($airlineID,$counterID) {
		$discount=Load::model('discount');
		return $discount->get($airlineID,$counterID);
	}

	public function discountSpecialTrain($param)
	{
		$Model = Load::library('Model');

		$startDateInt = functions::FormatDateJalali($param['startDate']);
		$endDateInt = functions::FormatDateJalali($param['endDate']);

		   $sql = " SELECT 
                    counterTypeId 
                 FROM  
                    discount_private_train_tb 
                 WHERE 
                    type_service='{$param['services']}'
                    AND base_company='{$param['base_company']}' 
                    AND company='{$param['company']}'
                   	AND (( start_date >= '{$param['startDate']}' AND end_date <= '{$param['endDate']}') OR
                   ( start_date <= '{$param['startDate']}' AND end_date >= '{$param['endDate']}' )) 
                    AND is_enable = '1'  ";
		$check = $Model->select($sql, 'assoc');
		foreach ($check as $val){
			$arrayCheck[] = $val['counterTypeId'];
		}
		$res = [];
		for ($i = 0; $i <= $param['countCounter']; $i++){
			if (isset($param['percent' . $i]) && $param['percent' . $i] > 0
				&& (empty($arrayCheck) || (!empty($arrayCheck) && !in_array($param['counter_id' . $i], $arrayCheck)))){

				$data['percent'] = $param['percent'.$i];
				$data['type_service'] = $param['services'];
				$data['base_company'] = isset($param['base_company']) ? $param['base_company'] : 'all';
				$data['company'] = (isset($param['company']) && $param['company'] != '') ? $param['company'] : 'all';
				$data['counterTypeId'] = $param['counter_id' . $i];
				$data['start_date'] = $param['startDate'];
				$data['end_date'] = $param['endDate'];
				$data['is_enable'] = '1';
				$data['creation_date_int'] = time();

				$Model->setTable('discount_private_train_tb');
				$res[] = $Model->insertLocal($data);

			}
			$data = [];
		}

		if ((empty($res)) || (!empty($res) && in_array('0', $res))) {
			return 'error : خطا در  تغییرات';
		} else {
			return 'success :  تغییرات با موفقیت انجام شد';
		}
	}

	public function discountList()
	{
		$Model = Load::library('Model');
		$sql = " SELECT 
                    * 
                 FROM  
                    discount_private_train_tb ORDER BY creation_date_int DESC ";

		$discount = $Model->select($sql, 'assoc');

		return  $discount ;
	}

    public function NameServicePoint($type_service)
    {

        $ModelBase = Load::library('ModelBase');

        $Sql = "SELECT
                    services.*,
                    services_group.Title AS TitleServicesGroup,
                    services_group.MainService AS MainServiceGroup
                FROM 
                    services_tb AS services
                    INNER JOIN services_group_tb AS services_group ON services.ServiceGroupId = services_group.id
                WHERE TitleEn='{$type_service}' ";

        $result = $ModelBase->load($Sql);

        return $result;
    }
	public function deletePercentTrain($param)
	{
		$id = $param['id'];
		$Model = Load::library('Model');

		$sql = " SELECT * FROM discount_private_train_tb WHERE id='{$id}'";
		$resQuery = $Model->load($sql);

		if (!empty($resQuery)) {
			$d['is_enable'] = '0';
			$d['disable_date_int'] = time();
			$Model->setTable('discount_private_train_tb');
			$res = $Model->update($d, "id='{$id}'");

			if ($res) {
				return ' success : تخفیف تخصیص داده شده با موفقیت حذف شد';
			} else {
				return ' error : خطا در حذف تخفیف';
			}

		} else {
			return ' error : ارسال اطلاعات نا معتبر';
		}
	}
}

?>
