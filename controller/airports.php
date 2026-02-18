<?php


class airports extends baseController
{
    public function __construct()
    {
    }

    public function findOrigin($params = [])
    {
        $search_for = $params['search_for'];
        if (strlen($search_for) < 3) {
            return functions::withError([], 400, functions::StrReplaceInXml(['length' => '3'], 'MinLengthSearch'));
        }
        $model = $this->getModel('airportModel');
        $result = $model->get('DepartureCode,DepartureCityEn,DepartureCityFa,DepartureCityAr,AirportFa,AirportEn,AirportAr,CountryFa,CountryEn,CountryAr,ParentCode,IsPopular , IsInternal')
            ->like('DepartureCode', $search_for)->like('DepartureCityEn', $search_for)
            ->like('DepartureCityFa', $search_for)->like('DepartureCityAr', $search_for)
            ->like('AirportFa', $search_for)->like('AirportEn', $search_for)
            ->like('AirportAr', $search_for)->like('CountryFa', $search_for)
            ->like('CountryAr', $search_for)->like('CountryEn', $search_for)
            ->all();


        foreach ($result as $key => $item) {

            if ($item['IsInternal'] == 1) {
                $result[$key]['FlightType'] = 'Internal';
            } else {
                $result[$key]['FlightType'] = 'External';
            }
            unset($result[$key]['IsInternal']);
        }

        if (!$result) {
            return functions::withError([], 404, functions::Xmlinformation('DetailNotFound')->__toString());
        }

        return functions::withSuccess(array_values($result));
    }

    public function findDestination($params)
    {
        $search_for = $params['search_for'];
        $origin_code = $params['origin'];

        $airport = $this->getModel('airportModel');
        $origin = $airport->get('DepartureCode,IsInternal')->where('DepartureCode', $origin_code)->find();
        $result = $airport->get('DepartureCode,DepartureCityEn,DepartureCityFa,DepartureCityAr,AirportFa,AirportEn,AirportAr,CountryFa,CountryEn,CountryAr,ParentCode,IsPopular,IsInternal')
            ->where($airport->getTable() . '.DepartureCode', $origin_code, '!=')
            ->openParentheses()
            ->like('DepartureCode', $search_for)
            ->like('DepartureCityEn', $search_for)
            ->like('DepartureCityFa', $search_for)
            ->like('DepartureCityAr', $search_for)
            ->like('AirportFa', $search_for)
            ->like('AirportEn', $search_for)
            ->like('AirportAr', $search_for)
            ->like('CountryFa', $search_for)
            ->like('CountryAr', $search_for)
            ->like('CountryEn', $search_for)
            ->closeParentheses();

        if ($origin['DepartureCode'] == 'THR') {
            $result = $result->where('IsInternal', 1);
        }

        if ($origin['DepartureCode'] == 'IKA') {
            $result = $result->where('IsInternal', 0);
        }
        $result->orderBy('CASE WHEN ' . $airport->getTable() . ".DepartureCode = '$search_for'", 'THEN 1 ELSE 2 END');
        $result = $result->all();

        if (!$result) {
            return functions::withError([], 404, functions::Xmlinformation('DetailNotFound')->__toString());
        }

        foreach ($result as $key => $item) {

            if ($origin['IsInternal'] == 1 && $item['IsInternal'] == 1) {
                $result[$key]['FlightType'] = 'Internal';
            } else {
                $result[$key]['FlightType'] = 'External';
            }
            unset($result[$key]['IsInternal']);
            if ($origin['IsInternal'] == 0 && $item['DepartureCode'] == 'THR') {
                unset($result[$key]);
            }
        }

        return functions::withSuccess(array_values($result));

    }

    public function allAirports($params = [])
    {

        $result = $this->getModel('airportModel')->get();

        if (isset($params['search']['value']) && !empty($params['search']['value'])) {
            $search_for = $params['search']['value'];
            $result = $result->like('DepartureCode', $search_for)->like('DepartureCityEn', $search_for)
                ->like('DepartureCityFa', $search_for)->like('DepartureCityAr', $search_for)
                ->like('AirportFa', $search_for)->like('AirportEn', $search_for)
                ->like('AirportAr', $search_for)->like('CountryFa', $search_for)
                ->like('CountryAr', $search_for)->like('CountryEn', $search_for);
        }
        $total = count($result->all());

        if (isset($params['order'])) {
            foreach ($params['order'] as $order) {
                $field_by_column = ['id', 'AirportFa', 'DepartureCode', 'DepartureCityFa', 'CountryFa', 'IsInternal'];
                $result = $result->orderBy($field_by_column[$order['column']], strtoupper($order['dir']));
            }
        }

        if (isset($params['length']) && isset($params['start']) && $params['length'] != '-1') {
            $result = $result->limit($params['start'], $params['length']);
        }

        $result = $result->all();
        $json = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $result,
            'req' => $params
        ];
        return functions::toJson($json);
    }

    public function updateAirport($request = [])
    {
        $id = $request['airport_id'];
        unset($request['airport_id']);
        $fields = ['AirportFa', 'AirportEn', 'AirportAr', 'CountryFa', 'CountryEn', 'CountryAr', 'DepartureCityFa', 'DepartureCityEn', 'DepartureCityAr', 'DepartureCode', 'IsInternal',];
        $model = $this->getModel('airportModel');
        $airport = $model->get($fields)->where('id', $id)->find();
        $update_data = [];
        foreach ($request as $key => $item) {
            if (array_key_exists($key, $airport) && $item != $airport[$key]) {
                $update_data[$key] = $item;
            }
        }

//        return functions::toJson([$airport,$update_data,$request]);

        $update = $model->updateWithBind($update_data, ['id' => $id]);
        if ($update) {
            return functions::withSuccess(null, 200, 'بروزرسانی فرودگاه با موفقیت انجام شد');
        }
        return functions::withError(null, 400, 'خطا در بروزرسانی فرودگاه لطفا اطلاعات را بررسی کنید');
    }

    public function newAirport($request = [])
    {
        $fields = ['AirportFa', 'AirportEn', 'AirportAr', 'CountryFa', 'CountryEn', 'CountryAr', 'DepartureCityFa', 'DepartureCityEn', 'DepartureCityAr', 'DepartureCode', 'IsInternal',];
        $model = $this->getModel('airportModel');
        $airport = $model->get()->where('DepartureCode', $request['DepartureCode'])->find();
        if (is_array($airport) && isset($airport['DepartureCode'])) {
            return functions::withError(['Airport exist'], 400, 'فرودگاه با این کد IATA وجود دارد');
        }

        $data_insert = [];
        foreach ($fields as $field) {
            $data_insert[$field] = trim($request[$field]);
        }
        $insert = $model->insertWithBind($data_insert);
        if ($insert) {
            return functions::withSuccess(['insert correct'], 201, 'فرودگاه جدید اضافه شد');
        }

        return functions::withError(['failed insert'], 500, 'خطا در افزودن فرودگاه');
    }

    public function deleteAirport($params = [])
    {
        $model = $this->getModel('airportModel');
        $airport = $model->get()->where('id',$params['id'])->find();
        if(!$airport){
            return functions::withError(null,404,'فرودگاهی یافت نشد');
        }
        $delete = $model->delete("id='{$params['id']}'");

        if($delete){
            return functions::withSuccess(null,200,'فرودگاه با موفقیت حذف شد');
        }
        return functions::withError(null,500,'خطا در حذف فرودگاه');
    }

    public function searchAirports($params)
    {
        $airports = $this->getController('airports');
        if(isset($params['origin'])){
            return $airports->findDestination($params);
        }
        return $airports->findOrigin($params);
    }


    public function getAirPorts() {
        $airports =  $this->getModel('airportModel')->get()->all();

        $final_airports = [];
        foreach ($airports as $airport) {
            $final_airports[$airport['DepartureCode']] = $airport ;
        }
        return $final_airports ;
    }
}