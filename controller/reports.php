<?php


class reports extends clientAuth
{
//    public function __construct()
//    {
//        parent::__construct();
//        ob_start("ob_gzhandler");
//    }
//
//    public function __destruct()
//    {
//        ob_flush();
//    }

    public function reportFlightTotalSales($params = [])
    {
//        $columns = ['ردیف', 'نام آژانس', 'تعداد فروش', 'مبلغ (ریال)'];
        $title_field = 'clients_tb.AgencyName';
        $group_field = 'client_id';
        $source_error_codes = [
            '909090',
            '10253',
            '100023',
            'Err0107013',
            '00000',
            '-407',
            '-777',
            '-430',
            'ERROR111',
            '10216',
            '10142',
            '-4000',
            '10165',
            '10202',
            'EntityIsNu',
            'Err0111010',
            'HttpError',
            'Err0107038'

        ];
        $flight_errors =  self::getFlightErrors($source_error_codes);

        $concat_field = '';
        if (isset($params['filtered_on']) && $params['filtered_on'] == 'route_name') {
            $title_field = "CONCAT(report_tb.origin_city,' به ' ,report_tb.desti_city)";
            $concat_field = ",CONCAT(report_tb.origin_airport_iata,report_tb.desti_airport_iata) AS route_concat";
            $group_field = 'route_concat';
            $columns[1] = 'مسیر پروازی';
        }
        if(isset($params['filtered_on']) && $params['filtered_on'] == 'source'){
            $title_field = 'report_tb.api_id';

        }
        /** @var reportModel $model */
        $model = $this->getModel('reportModel');

        $item = [];

        $result = $model->get("report_tb.id,report_tb.api_id,report_tb.request_cancel,report_tb.request_number,report_tb.successfull,clients_tb.id AS client_id,$title_field AS title_field
         $concat_field,
        report_tb.adt_price,
            report_tb.chd_price,
            report_tb.inf_price ", true)->join(' clients_tb', 'id', 'client_id');


        if (isset($params['search']['value']) && !empty($params['search']['value'])) {
            $search_for = $params['search']['value'];
            $result = $result->setSql("WHERE clients_tb.AgencyName LIKE '%$search_for%'");
        }
        if (isset($params['start_date']) && !empty($params['start_date'])) {
            $result->where('creation_date', functions::ConvertToMiladi($params['start_date']), '>=');
        }
        if (isset($params['end_date']) && !empty($params['end_date'])) {
            $result->where('creation_date', functions::ConvertToMiladi($params['end_date']), '<=');
        }

        $sql = $result->toSql();
//        $count_total = count($result->all());
        $result = $result->all();

        $response = [];
        $successful_array = ['nothing', 'prereserve', 'credit', 'error', 'bank', 'book', 'processing', 'private_reserve'];
        $c_total = $c_error = $c_success = $c_cancel = 0;
        $filter_one_key = 'client_id';
        if (isset($params['filtered_on']) && $params['filtered_on'] == 'route_name') {
            $filter_one_key = 'route_concat';
        }
        if (isset($params['filtered_on']) && $params['filtered_on'] == 'source') {
            $filter_one_key = 'api_id';
        }
        $filtered_array = [];
        foreach ($result as $db_row) {
            if ($filter_one_key == 'api_id') {
                $db_row['title_field'] = functions::showFlightSourceName($db_row['api_id']);
            }
            $filtered_array[$db_row[$filter_one_key]][] = $db_row;
        }
        $final_result = [];
        $index = 0;
        foreach ($filtered_array as $field_key => $data_array) {
            $index++;
            $final_result[$field_key] = [
                'id' => $index,
                'total_count' => 0,
                'total_cancel' => 0,
                'total_success' => 0,
                'total_error' => 0,
                'total_user_error' => 0,
                'total_source_error' => 0,
                'total_other' => 0,
                'total_price' => 0,
                'title_field' => '',
                'cancel' => [],
                'error' => [],
                'source_error'=>[],
                'success' => [],
                'other' => [],
                'user_error' => []
            ];

            $temp_array = [
                'cancel',
                'success',
                'error'
            ];
            $final_result[$field_key]['total_count']= count($data_array);

            foreach ($data_array as $child_row) {
                $final_result[$field_key]['title_field'] = $child_row['title_field'];
                if ($child_row['request_cancel'] == 'confirm') {
                    $final_result[$field_key]['cancel'][] = $child_row;
                }

                if ($child_row['successfull'] == 'book' || $child_row['successfull'] == 'private_reserve') {
                    $final_result[$field_key]['success'][] = $child_row;
                    $final_result[$field_key]['total_price'] +=  ($child_row['adt_price'] + $child_row['chd_price'] + $child_row['inf_price']);
                }

                if ($child_row['successfull'] == 'error') {
                    $final_result[$field_key]['error'][] = $child_row;
                    if(in_array($child_row['request_number'],array_keys($flight_errors))){
                        $final_result[$field_key]['source_error'][] = $child_row;
                    }else{
                        $final_result[$field_key]['user_error'][] = $child_row;
                    }
                }
                if($child_row['successfull'] != 'book' && $child_row['successfull'] != 'private_reserve' && $child_row['successfull'] != 'error'){
                    $final_result[$field_key]['other'][] = $child_row;
                }
                $final_result[$field_key]['rows'][] = $child_row;
            }

                if (isset($params['filter_total']) && $params['filter_total'] == 'reserve') {
                    $final_result[$field_key]['rows'] = self::unique_multidimensional_array($final_result[$field_key]['rows'], 'request_number');
                    $final_result[$field_key]['cancel'] = self::unique_multidimensional_array($final_result[$field_key]['cancel'], 'request_number');
                    $final_result[$field_key]['error'] = self::unique_multidimensional_array($final_result[$field_key]['error'], 'request_number');
                    $final_result[$field_key]['source_error'] = self::unique_multidimensional_array($final_result[$field_key]['source_error'], 'request_number');
                    $final_result[$field_key]['success'] = self::unique_multidimensional_array($final_result[$field_key]['success'], 'request_number');
                    $final_result[$field_key]['other'] = self::unique_multidimensional_array($final_result[$field_key]['other'], 'request_number');
                    $final_result[$field_key]['user_error'] = self::unique_multidimensional_array($final_result[$field_key]['user_error'], 'request_number');
                }

                $final_result[$field_key]['total_success'] = count($final_result[$field_key]['success']);
                $final_result[$field_key]['total_error'] = count($final_result[$field_key]['error']);
                $final_result[$field_key]['total_source_error'] = count($final_result[$field_key]['source_error']);
                $final_result[$field_key]['total_cancel'] = count($final_result[$field_key]['cancel']);
                $final_result[$field_key]['total_count'] = count($final_result[$field_key]['rows']);
                $final_result[$field_key]['total_other'] = count($final_result[$field_key]['other']);
                $final_result[$field_key]['total_user_error'] = count($final_result[$field_key]['user_error']);
        }


        $col = '';
        if (isset($params['order'])) {
            foreach ($params['order'] as $order) {

                $field_by_column = ['id', 'title_field', 'total_user_error','total_source_error','total_other', 'total_count', 'total_success', 'total_error', 'total_cancel', 'total_price'];
                $col = $field_by_column[$order['column']];
                $sort_flag = strtoupper($order['dir']) == 'DESC' ? SORT_DESC : SORT_ASC;
                $sort = array();
                foreach ($final_result as $keySort => $arraySort) {
                    $sort[$col][$keySort] = $arraySort['total_success'];
                }
                if (!empty($sort)) {
                    array_multisort($sort[$col], $sort_flag, $final_result);
                }
            }

        }

        if (isset($params['length']) && isset($params['start'])) {
            $final_result = array_slice($final_result, $params['start'], $params['length'], true);
        }

        $data = [];
        foreach (array_values($final_result) as $k => $val) {
            $data[] = $val;
        }
        $json = [
            'recordsTotal' => count($filtered_array),
            'recordsFiltered' => count($filtered_array),
            'data' => $data,
            'sql'=>$sql,
            'data_result'=>$result
        ];
        return functions::toJson($json);

    }

    public function unique_multidimensional_array($array, $key)
    {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach ($array as $val) {
            if (isset($val[$key]) && !in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function getFlightErrors($error_codes = [])
    {
        $model = $this->getModel('logErrorFlightsModel');

        $all = $model->get();
        if($error_codes){
            $all = $all->whereIn('message_admin',$error_codes);
        }
        $all = $all->all();
        $result = [];
        foreach ($all as $item) {
            $result[$item['request_number']] = $item;
        }
        return $result;
    }


}