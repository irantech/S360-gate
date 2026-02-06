<?php

/**
 * Class cancellationFeeSetting
 * @property cancellationFeeSetting $cancellationFeeSetting
 */
class cancellationFeeSetting extends clientAuth
{
    public $ResultSelectForEdit;

    public function __construct() {
        parent::__construct();
    }


    public function ListFee() {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $SqlFee = "SELECT * FROM cancellation_fee_settings_tb";

        $ResultSelect = $ModelBase->select($SqlFee);

        return $ResultSelect;

    }

    public function ListFeeByAirlineIata($airlineIata) {
        $ModelBase = Load::library('ModelBase');

        $SqlFee = "SELECT * FROM cancellation_fee_settings_tb WHERE AirlineIata = '{$airlineIata}'";

        return $ModelBase->select($SqlFee);
    }

    public function cancellationFeeByAirlineIataList() {

        $cancellationFeeModel = $this->getModel('cancellationFeeSettingModel');
        $cancellation = $cancellationFeeModel->getCancellationFeeSettingByAirlines();
        $airlines = functions::uniqueMultiArray($cancellation, 'abbreviation');
        $i = 0;
        $result = [];
        foreach ($airlines as $airline) {
            $result[$i]['abbreviation'] = $airline['abbreviation'];
            $result[$i]['name_en'] = $airline['name_en'];
            $result[$i]['name_fa'] = $airline['name_fa'];

            $count = 0;
            foreach ($cancellation as $cancel) {
                if ($airline['abbreviation'] == $cancel['AirlineIata']) {
                    $result[$i]['feeList'][$count]['TypeClass'] = $cancel['TypeClass'];
                    $result[$i]['feeList'][$count]['ThreeDaysBefore'] = $cancel['ThreeDaysBefore'];
                    $result[$i]['feeList'][$count]['OneDaysBefore'] = $cancel['OneDaysBefore'];
                    $result[$i]['feeList'][$count]['ThreeHoursBefore'] = $cancel['ThreeHoursBefore'];
                    $result[$i]['feeList'][$count]['ThirtyMinutesAgo'] = $cancel['ThirtyMinutesAgo'];
                    $result[$i]['feeList'][$count]['TypeClass'] = $cancel['TypeClass'];
                    $result[$i]['feeList'][$count]['OfThirtyMinutesAgoToNext'] = $cancel['OfThirtyMinutesAgoToNext'];
                    $count++;
                }
            }
            $i++;

        }
        return $result;
    }

    public function CancellationFeeAirlines() {
        $ModelBase = Load::library('ModelBase');

        $query = "SELECT A.name_fa, A.name_en, A.abbreviation  FROM airline_tb AS A INNER JOIN cancellation_fee_settings_tb AS CFS ON A.abbreviation = CFS.AirlineIata " .
            "WHERE A.active = 'on' AND A.del = 'no' GROUP BY A.abbreviation";

        return $ModelBase->select($query);
    }

    public function ShowInfoForEdit($param) {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $param = filter_var($param, FILTER_VALIDATE_INT);

        $SqlFeeEdit = "SELECT * FROM cancellation_fee_settings_tb WHERE id='{$param}'";

        $ResultSelectForEdit = $ModelBase->load($SqlFeeEdit);

        $this->ResultSelectForEdit = $ResultSelectForEdit;

    }

    public function CancellationFeeSettingAdd($param) {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $SqlFee = "SELECT id FROM cancellation_fee_settings_tb WHERE AirlineIata='{$param['AirlineIata']}' AND TypeClass='{$param['TypeClass']}' ";

        $ResultSelect = $ModelBase->load($SqlFee);

        if (empty($ResultSelect)):
            $data['AirlineIata'] = $param['AirlineIata'];
            $data['TypeClass'] = $param['TypeClass'];
            $data['ThreeDaysBefore'] = $param['ThreeDaysBefore'];
            $data['OneDaysBefore'] = $param['OneDaysBefore'];
            $data['ThreeHoursBefore'] = $param['ThreeHoursBefore'];
            $data['ThirtyMinutesAgo'] = $param['ThirtyMinutesAgo'];
            $data['OfThirtyMinutesAgoToNext'] = $param['OfThirtyMinutesAgoToNext'];
            $data['CreationDateInt'] = time();

            $ModelBase->setTable('cancellation_fee_settings_tb');
            $ResultInsert = $ModelBase->insertLocal($data);

            if ($ResultInsert) {
                return 'success: افزودن تنظیمات جدید جریمه کنسلی با موفقیت انجام شد';

            } else {
                return 'error:خطا در قرایند افزودن تنطیمات جریمه کنسلی';

            }
        else:
            return 'error:این مورد قبلا ثبت شده است،لطفا مقدار دیگری وارد نمائید و یا برای تغییر این مقدار به منوی ویرایش تنظیم در لیست تنظیمات بروید';
        endif;

    }

    public function CancellationFeeSettingEdit($param) {

        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();

        $SqlFee = "SELECT id FROM cancellation_fee_settings_tb WHERE id={$param['id']}";

        $ResultSelect = $ModelBase->load($SqlFee);

        if (!empty($ResultSelect)):
            $data['AirlineIata'] = $param['AirlineIata'];
            $data['TypeClass'] = $param['TypeClass'];
            $data['ThreeDaysBefore'] = $param['ThreeDaysBefore'];
            $data['OneDaysBefore'] = $param['OneDaysBefore'];
            $data['ThreeHoursBefore'] = $param['ThreeHoursBefore'];
            $data['ThirtyMinutesAgo'] = $param['ThirtyMinutesAgo'];
            $data['OfThirtyMinutesAgoToNext'] = $param['OfThirtyMinutesAgoToNext'];
            $data['LastEditInt'] = time();

            $Condition = "id='{$param['id']}'";
            $ModelBase->setTable('cancellation_fee_settings_tb');
            $ResultInsert = $ModelBase->update($data, $Condition);

            if ($ResultInsert) {
                return 'success: ویرایش تنظیمات جدید جریمه کنسلی با موفقیت انجام شد';

            } else {
                return 'error:خطا در قرایند ویرایش تنطیمات جریمه کنسلی';

            }
        else:
            return 'error:خطا در ویرایش تنطیمات،تنظیمات مورد نظر یافت نشد';
        endif;

    }


    public function CalculateIndemnity($RequestNumber) {
        $ModelBase = Load::library('ModelBase');

        $queryBook = "SELECT airline_iata,flight_type,date_flight,time_flight,cabin_type FROM report_tb WHERE request_number='{$RequestNumber}'";
        $resultBook = $ModelBase->load($queryBook);

        if (!empty($resultBook['cabin_type'])) {
            $queryIndemnity = "SELECT * FROM cancellation_fee_settings_tb WHERE AirlineIata='{$resultBook['airline_iata']}' AND TypeClass='{$resultBook['cabin_type']}'";
            $resultCancellationFeeSetting = $ModelBase->load($queryIndemnity);
          

        }

        $timeFlight = $resultBook['time_flight'];


//         $timeFlightExplode = functions::format_hour($timeFlight);

        $Replace = array("AM", "PM");
        $timeFlightExplode = str_replace($Replace, '', $timeFlight);
        $timeFlightExplode = explode(':', trim($timeFlightExplode));

        $dateFlight = functions::DateJalali(trim($resultBook['date_flight']));

        $dateFlightExplode = explode('-', $dateFlight);

        $timeStampFlight = dateTimeSetting::jmktime($timeFlightExplode[0], $timeFlightExplode[1], '0', $dateFlightExplode[1], $dateFlightExplode[2], $dateFlightExplode[0]);


        $timeCancel = time();
        $ThreeDaysBeforeInt = $timeStampFlight - (3 * 24 * 60 * 60);
        $OneDaysBeforeInt = $timeStampFlight - (24 * 60 * 60);
        $ThreeHoursBeforeInt = $timeStampFlight - (3 * 60 * 60);
        $ThirtyMinutesAgoInt = $timeStampFlight - (30 * 60);
        $HourCancel = dateTimeSetting::jdate("H", $timeCancel);


        if (strtolower($resultBook['flight_type']) == 'system' && !empty($resultCancellationFeeSetting)) {
            if (($timeCancel < $ThreeDaysBeforeInt) && ($HourCancel < 12)) {
                return $resultCancellationFeeSetting['ThreeDaysBefore'];
            } else if (($OneDaysBeforeInt > $timeCancel) && ($timeCancel > $ThreeDaysBeforeInt) && ($HourCancel < 12)) {
                return $resultCancellationFeeSetting['OneDaysBefore'];
            } else if ($ThreeHoursBeforeInt > $timeCancel && $timeCancel > $OneDaysBeforeInt) {
                return $resultCancellationFeeSetting['ThreeHoursBefore'];
            } else if ($ThirtyMinutesAgoInt > $timeCancel && $timeCancel > $ThreeHoursBeforeInt) {
                return $resultCancellationFeeSetting['ThirtyMinutesAgo'];
            } else {
                return $resultCancellationFeeSetting['OfThirtyMinutesAgoToNext'];
            }
        } else {
            return false;
        }
    }


    public function feeByAirlineAndCabinType($params) {

        $fee_cancel_finally= array();
        $fee_cancel = $this->getModel('cancellationFeeSettingModel')->get(['ThreeDaysBefore', 'OneDaysBefore', 'ThreeHoursBefore', 'ThirtyMinutesAgo', 'OfThirtyMinutesAgoToNext'],true)
            ->where('AirlineIata', $params['airline_iata'])->where('TypeClass', $params['cabin_type'])->find();

        if(!empty($fee_cancel)){
            $fee_cancel_finally= $fee_cancel ;
            if ($fee_cancel['ThreeDaysBefore'] == '100'
                AND $fee_cancel['OneDaysBefore'] == '100'
                AND $fee_cancel['ThreeHoursBefore'] == '100'
                AND $fee_cancel['ThirtyMinutesAgo'] == '100'
                AND $fee_cancel['OfThirtyMinutesAgoToNext'] == '100') {
                $fee_cancel_finally['born'] = 'yes';
            }else{
                $fee_cancel_finally['born'] = 'no';
            }
        }


        if($params['is_json']){

            return functions::withSuccess($fee_cancel_finally,200,'ok');
        }
        return $fee_cancel_finally ;
    }
}