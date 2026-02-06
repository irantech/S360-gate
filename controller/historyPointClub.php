<?php

class historyPointClub extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }


    public function setPointMemberIntoTable($params) {
var_dump($params['price']);
        $check_set_point = $this->getModel('historyPointClubModel')->get()->where('factor_number',$params['factor_number'])->find();
        if(empty($check_set_point)){
            functions::insertLog(json_encode($params,256),'check_point_Buy');
            $point_info = $this->pointClubService($params) ;

            functions::insertLog(json_encode($point_info,256),'check_point_Buy');

            if($point_info){
                $point = ceil( ( $params['price'] / $point_info['limitPrice'] ) ) * $point_info['pointToPrice'];
                functions::insertLog(json_encode($point,256),'check_point_Buy');

                $service_title = '';
                Switch($params['service']){

                    case 'Flight':
                        $service_title = 'پرواز';
                        break;
                    case 'Hotel':
                        $service_title = 'هتل';
                        break;
                    case 'Tour':
                        $service_title = 'تور';
                        break;
                    case 'Bus':
                        $service_title = 'اتوبوس';
                        break;
                    case 'Insurance':
                        $service_title = 'بیمه';
                        break;
                    case 'Train':
                        $service_title = 'قطار';
                        break;
                    case 'Visa':
                        $service_title = 'ویزا';
                        break;
                    case 'Entertainment':
                        $service_title = 'تفریحات';
                        break;
                    case 'GashtTransfer':
                        $service_title = 'گشت و ترانسفر';
                        break;
                    case 'Package':
                        $service_title = 'پرواز+ هتل';
                        break;
                    default:
                        $service_title = null;
                }
                $data_insert_table['member_id'] = Session::getUserId() ;
                $data_insert_table['point'] = $point;
                $data_insert_table['type_point'] = 'increase';
                $data_insert_table['comment'] = "اختصاص {$point} امتیاز بابت خرید خدمات {$service_title} به شماره فاکتور {$params['factor_number']}";
                $data_insert_table['factor_number'] = $params['factor_number'];
                $data_insert_table['is_consumed'] = 0;
                $data_insert_table['service'] = $params['service'];
                $data_insert_table['service_title'] = $params['service_title'];


                $this->getModel('historyPointClubModel')->insertWithBind($data_insert_table) ;
            }
        }


    }

    public function pointClubService($params) {
        return $this->getController('pointClub')->getPointClub($params['service_title'],$params['base_company'],$params['company'],$params['counter_id']);
    }

    public function getUnconsumedPointClub($member_id) {
        return $this->getModel('historyPointClubModel')->get(['SUM(point) as unconsumed_point'],true)->where('member_id',$member_id)->where('type_point','increase')->find();
    }

    public function getConsumedPoint($member_id) {
        return $this->getModel('historyPointClubModel')->get(['SUM(point) as consumed_point'],true)->where('member_id',$member_id)->where('type_point','decrease')->find();
    }

    public function getPointClubMember($member_id) {
        $plus_point = $this->getUnconsumedPointClub($member_id);
        $consumed_pint = $this->getConsumedPoint($member_id);

        $final_point =  $plus_point['unconsumed_point'] - $consumed_pint['consumed_point'] ;
        return ($final_point > 0) ? $final_point : 0;
    }

    public function getPointClubUser($member_id) {
        return $this->getModel('historyPointClubModel')->get()->where('member_id',$member_id)->all();
    }

    public function getPointClubFactorNumber($factor_number) {
        return $this->getModel('historyPointClubModel')->get()->where('factor_number', $factor_number)->find();
    }
    public function decreasePointForConvertToCredit($params) {

        $data_point['point'] = $params['point'] ;
        $data_point['member_id'] = Session::getUserId();
        $data_point['type_point'] = 'decrease' ;
        $data_point['comment'] = " کسر امتیاز {$params['point']} بابت تبدیل به اعتبار " ;
        $data_point['factor_number'] = $params['factor_number'] ;
        $data_point['is_consumed'] = 0 ;
        $data_point['service'] = 'Flight';//just because will not have to empty value  enum field
        $data_point['service_title'] = null;
        return $this->getModel('historyPointClubModel')->insertLocal($data_point);
    }


    public function decreasePointForConvertToDiscountCode($params) {
        $data_point['point'] = $params['point'] ;
        $data_point['member_id'] = Session::getUserId();
        $data_point['type_point'] = 'decrease' ;
        $data_point['comment'] = " کسر امتیاز {$params['point']}  بابت تبدیل به کد تخفیف{$params['discount_code']} " ;
        $data_point['factor_number'] = $params['factor_number'] ;
        $data_point['is_consumed'] = 0 ;
        $data_point['service'] = 'Flight';//just because will not have to empty value  enum field
        $data_point['service_title'] = null;
        return $this->getModel('historyPointClubModel')->insertLocal($data_point);
    }

    public function deleteSpecificPointByFactorNumber($factor_number) {
        if($factor_number !="")
        {
            return $this->getModel('historyPointClubModel')->delete("factor_number='{$factor_number}'");
        }
    }
}