<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 2020-01-15
 * Time: 16:55
 */

/**
 * Class extraTrainMethod
 * @property extraTrainMethod $extraTrainMethod
 */
class extraTrainMethod
{

    #region CheckedLogin
    public function CheckedLogin()
    {
        $result = Session::IsLogin();
        $result2 = Session::getTypeUser();
        if ($result && $result2 == 'counter') {
            return 'successLoginTrain';
        }

        return 'errorLoginTrain';
    }
    #endregion


    #region DateJalali
    public function DateJalali($param)
    {
        $explode_date = explode('-', date("Y-m-d", strtotime($param)));

        if ($explode_date[0] > 1450) {
            $jmktime = mktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
        }


        $this->date_now = dateTimeSetting::jdate(" j F Y", $jmktime);

        $this->DateJalaliRequest = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');

        $this->day = dateTimeSetting::jdate("l", $jmktime);
    }

#endregion


    public function insertTemporaryTrain($input)
    {
//        echo json_encode($input);
        functions::insertLog(__METHOD__ . ' PARAMS - ' . json_encode($input,256|64), 'train_log');
        /** @var temporaryTrainModel $temp_train */
        $temp_train = Load::getModel('temporaryTrainModel');
        $resultExist = $temp_train->get()->where('ServiceCode', $input['ServiceCode'])->find();

        if (empty($resultExist) || (!empty($resultExist) && $input['Route_type'] != '1')) {
            $data['PassengerNum'] = $input['PassengerNum'];
            $data['ServiceCode'] = $input['ServiceCode'];
            $data['CompanyName'] = $input['CompanyName'];
            $data['RetStatus'] = $input['RetStatus'];
            $data['Remain'] = $input['Remain'];
            $data['TrainNumber'] = $input['TrainNumber'];
            $data['WagonType'] = $input['WagonType'];
            $data['WagonName'] = $input['WagonName'];
            $data['PathCode'] = $input['PathCode'];
            $data['CircularPeriod'] = $input['CircularPeriod'];
            $data['MoveDate'] = $input['MoveDate'];
            $data['ExitDate'] = $input['ExitDate'];
            $data['ExitTime'] = $input['ExitTime'];
            $data['Counting'] = $input['Counting'];
            $data['SoldCount'] = $input['SoldCount'];
            $data['degree'] = $input['degree'];
            $data['AvaliableSellCount'] = $input['AvaliableSellCount'];
            $data['Cost'] = $input['Cost'];
            $data['FullPrice'] = $input['FullPrice'];
            $data['CompartmentCapicity'] = $input['CompartmentCapicity'];
            $data['IsCompartment'] = $input['IsCompartment'];
            $data['CircularNumberSerial'] = $input['CircularNumberSerial'];
            $data['CountingAll'] = $input['CountingAll'];
            $data['RateCode'] = $input['RateCode'];
            $data['AirConditioning'] = $input['AirConditioning'];
            $data['Media'] = $input['Media'];
            $data['TimeOfArrival'] = $input['TimeOfArrival'];
            $data['RationCode'] = $input['RationCode'];
            $data['soldcounting'] = $input['soldcounting'];
            $data['SeatType'] = $input['SeatType'];
            $data['Owner'] = $input['Owner'];
            $data['AxleCode'] = $input['AxleCode'];
            $data['Departure_City'] = $input['Departure_City'];
            $data['Arrival_City'] = $input['Arrival_City'];
            $data['Dep_Code'] = $input['Dep_Code'];
            $data['Arr_Code'] = $input['Arr_Code'];
            $data['Adult'] = $input['ADULT'];
            $data['Child'] = $input['CHILD'];
            $data['Infant'] = $input['INFANT'];
            $data['code'] = $input['RequestNumber'];
            $data['ServiceSessionId'] = $input['ServiceSessionId'];
            $data['Route_type'] = $input['Route_type'];
            $data['is_specifice'] = $input['isSpecific'];
            $data['SourceId'] = $input['SourceId'];
            $data['UniqueId'] = $input['UniqueId'];
            $result = $temp_train->insertWithBind($data);
            if ($result) {
                return $temp_train->getLastId();
            }
        }

        return $resultExist['id'];

    }

    public function saveSelectedTrain($input)
    {
//        echo json_encode($input);
        functions::insertLog(__METHOD__ . ' PARAMS - ' . json_encode($input,256|64), 'train_log');
        /** @var temporaryTrainModel $temp_train */
        $temp_train = Load::getModel('temporaryTrainModel');
        $resultExist = $temp_train->get()->where('ServiceCode', $input['ServiceCode'])->find();

        if (empty($resultExist) || (!empty($resultExist) && $input['Route_type'] != '1')) {
            $data['PassengerNum'] = $input['PassengerNum'];
            $data['ServiceCode'] = $input['ServiceCode'];
            $data['CompanyName'] = $input['CompanyName'];
            $data['RetStatus'] = $input['RetStatus'];
            $data['Remain'] = $input['Remain'];
            $data['TrainNumber'] = $input['TrainNumber'];
            $data['WagonType'] = $input['WagonType'];
            $data['WagonName'] = $input['WagonName'];
            $data['PathCode'] = $input['PathCode'];
            $data['CircularPeriod'] = $input['CircularPeriod'];
            $data['MoveDate'] = $input['MoveDate'];
            $data['ExitDate'] = $input['ExitDate'];
            $data['ExitTime'] = $input['ExitTime'];
            $data['Counting'] = $input['Counting'];
            $data['SoldCount'] = $input['SoldCount'];
            $data['degree'] = $input['degree'];
            $data['AvaliableSellCount'] = $input['AvaliableSellCount'];
            $data['Cost'] = $input['Cost'];
            $data['FullPrice'] = $input['FullPrice'];
            $data['CompartmentCapicity'] = $input['CompartmentCapicity'];
            $data['IsCompartment'] = $input['IsCompartment'];
            $data['CircularNumberSerial'] = $input['CircularNumberSerial'];
            $data['CountingAll'] = $input['CountingAll'];
            $data['RateCode'] = $input['RateCode'];
            $data['AirConditioning'] = $input['AirConditioning'];
            $data['Media'] = $input['Media'];
            $data['TimeOfArrival'] = $input['TimeOfArrival'];
            $data['RationCode'] = $input['RationCode'];
            $data['soldcounting'] = $input['soldcounting'];
            $data['SeatType'] = $input['SeatType'];
            $data['Owner'] = $input['Owner'];
            $data['AxleCode'] = $input['AxleCode'];
            $data['Departure_City'] = $input['Departure_City'];
            $data['Arrival_City'] = $input['Arrival_City'];
            $data['Dep_Code'] = $input['Dep_Code'];
            $data['Arr_Code'] = $input['Arr_Code'];
            $data['Adult'] = $input['ADULT'];
            $data['Child'] = $input['CHILD'];
            $data['Infant'] = $input['INFANT'];
            $data['code'] = $input['RequestNumber'];
            $data['ServiceSessionId'] = $input['ServiceSessionId'];
            $data['Route_type'] = $input['Route_type'];
            $data['is_specifice'] = $input['isSpecific'];
            $data['SourceId'] = $input['SourceId'];
            $data['UniqueId'] = $input['UniqueId'];
            $result = $temp_train->insertWithBind($data);
            if ($result) {
                return $temp_train->getLastId();
            }
        }

        return $resultExist['id'];

    }
}