<?php


class airLineFineController extends clientAuth
{
    protected $Model;

    public function __construct()
    {
        parent::__construct();
        $this->Model = load::library('ModelBase');
        $this->Model->execQuery("SET SESSION group_concat_max_len = 1000000;");
    }
    function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    public function add_airlineFine($params){
        $package_data['airline_iata_id'] = $params['airline_uniqe_iata'];
        $this->Model->setTable('airline_fine_package_tb');
        $last_package_id = $this->Model->insertWithBind($package_data);
        $fineData = $params['FineData'];
        $class_fare_ids = $params['class_fare_ids'];
        $result = $this->insert_fine_rate($last_package_id,$fineData,$class_fare_ids);
        if($result){
            return $this->returnJson(true, "پکیج نرخی با موفقیت اضافه گردید");
        }
        return  $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);

    }
    public function edit_airlineFine($params){

        $package_id = $params['package_id'];
        $airline_uniqe_iata = $params['airline_uniqe_iata'];
        $data['airline_iata_id'] = $airline_uniqe_iata;
        $condition = "id = $package_id";
        $this->Model->setTable('airline_fine_package_tb');
        $this->Model->updateWithBind($data,$condition);
        $this->Model->setTable('airline_fine_percentage_tb');
        $condition = "fine_package_id = $package_id";
        $this->Model->delete($condition);
        $this->Model->setTable('airline_fine_class_fare_tb');
        $this->Model->delete($condition);
        $fineData = $params['FineData'];
        $class_fare_ids = $params['class_fare_ids'];
        $result = $this->insert_fine_rate($package_id,$fineData,$class_fare_ids);
        if($result){
            return $this->returnJson(true, "پکیج نرخی با موفقیت تغییر گردید");
        }
        return  $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);
    }
    public function remove_airlineFine($param){
        $package_id = $param['id'];
        $data['status'] = 'disable';
        $this->Model = load::library('ModelBase');
        $condition = "id = $package_id";
        $this->Model->setTable('airline_fine_package_tb');
        $result =  $this->Model->updateWithBind($data,$condition);
        if($result){
            return $this->returnJson(true, "پکیج نرخی با موفقیت حذف گردید");
        }
        return  $this->returnJson(false, "عملیات با خطا مواجه شد",  null, 500);
    }
    private function insert_fine_rate($package_id,$fineData,$class_fare_ids){
        $result=[];
        foreach ($fineData as $fine){
            $this->Model->setTable('airline_fine_percentage_tb');

            $data = array();
            $data['fine_package_id'] = $package_id;
            if($fine['from_day_date'] != '')
                $data['from_day_date'] = $fine['from_day_date'] ;
            if($fine['from_hour_date'] != '')
                $data['from_hour_date'] = $fine['from_hour_date'] ;
            if($fine['until_day_date'] != '')
                $data['until_day_date'] = $fine['until_day_date'] ;
            if($fine['until_hour_date'] != '')
                $data['until_hour_date'] = $fine['until_hour_date'] ;
            if($fine['fine_percentage'] != '')
                $data['fine_percentage'] = $fine['fine_percentage'] ;
            if($fine['from_issuance_hour'] != '')
                $data['from_issuance_hour'] = $fine['from_issuance_hour'] ;
            if($fine['fine_description'] != '')
                $data['fine_description'] = $fine['fine_description'] ;
            if($fine['fine_description_en'] != '')
                $data['fine_description_en'] = $fine['fine_description_en'] ;

            $this->Model->insertWithBind($data);
        }
        foreach ($class_fare_ids as $class_fare_id){
            $this->Model->setTable('airline_fine_class_fare_tb');
            $nestedData = array();
            $nestedData['class_fare_id'] = $class_fare_id;
            $nestedData['fine_package_id'] = $package_id;
            $result = $this->Model->insertWithBind($nestedData);
        }
        return $result;
    }

    public function airlineFineList()
    {

        $sql = "
    SELECT
        afpt.id AS package_id,
        asi.id as airline_iata_id,
        asi.airline_name,
        asi.airline_uniqe_iata,
        afpt.status AS package_status,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"class_id\":', afct.id,
                ',\"class_name\":\"', REPLACE(afct.class_name, '\"', '\\\"'), '\"}'
            )), ']')
            FROM airline_fine_class_fare_tb afcft
            INNER JOIN airline_fare_class_tb afct 
                ON afct.id = afcft.class_fare_id
            WHERE afcft.fine_package_id = afpt.id
        ) AS fare_classes,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"from_day\":', IF(afpt2.from_day_date IS NULL, '0', afpt2.from_day_date),
                ',\"from_hour\":', IF(afpt2.from_hour_date IS NULL, '0', afpt2.from_hour_date),
                ',\"until_day\":', IF(afpt2.until_day_date IS NULL, '0', afpt2.until_day_date),
                ',\"until_hour\":', IF(afpt2.until_hour_date IS NULL, '0', afpt2.until_hour_date),
                ',\"from_issuance_hour\":', IF(afpt2.from_issuance_hour IS NULL, '0', afpt2.from_issuance_hour),
                ',\"fine_description\":', IF(afpt2.fine_description IS NULL, 'null',
                    CONCAT('\"', REPLACE(afpt2.fine_description, '\"', '\\\"'), '\"')
                ),
                ',\"fine_description_en\":', IF(afpt2.fine_description_en IS NULL, 'null',
                    CONCAT('\"', REPLACE(afpt2.fine_description_en, '\"', '\\\"'), '\"')
                ),
                ',\"fine_percentage\":', IF(afpt2.fine_percentage IS NULL, 'null', afpt2.fine_percentage),
                '}'
            )), ']')
            FROM airline_fine_percentage_tb afpt2
            WHERE afpt2.fine_package_id = afpt.id
        ) AS fine_percentages
    FROM airline_fine_package_tb afpt
    INNER JOIN airline_standard_iata asi 
        ON asi.id = afpt.airline_iata_id
    WHERE afpt.status = 'active'
    ORDER BY afpt.id DESC ;
    ";

        $result = $this->Model->select($sql);



        foreach ($result as &$row) {

            $row['fare_classes'] = json_decode($row['fare_classes'], true);
            $row['fine_percentages'] = json_decode($row['fine_percentages'], true);

            if (!is_array($row['fine_percentages'])) {
                $row['fine_percentages'] = [];
            }

            // normalize fine_percentages
            $normalizedPercentages = [];
            foreach ($row['fine_percentages'] as $fp) {
                $normalizedPercentages[] = $this->normalizeFineRow([
                    'from_day_date'   => $fp['from_day'],
                    'from_hour_date'  => $fp['from_hour'],
                    'until_day_date'  => $fp['until_day'],
                    'until_hour_date' => $fp['until_hour'],
                    'from_issuance_hour' => $fp['from_issuance_hour'],
                    'fine_description' => $fp['fine_description'],
                    'fine_description_en' => $fp['fine_description_en'],
                    'fine_percentage' => $fp['fine_percentage'],
                    'is_tax_refund'   => isset($fp['is_tax_refund']) ? $fp['is_tax_refund'] : 0
                ]);
            }

            $row['fine_percentages'] = $normalizedPercentages;
        }

        return $result;
    }
    public function airlineFineListGroupedByTimeRanges()
    {
        $fineList = $this->airlineFineList();
        $grouped = [];

        foreach ($fineList as $item) {

            $timeRangeKeys = [];
            $seen = [];
            $uniquePercentages = [];

            // گرفتن درصدهای جریمه یکتا بر اساس تایم رنج
            foreach ($item['fine_percentages'] as $fp) {

                $rangeKey = sprintf(
                    "%d-%d-%d-%d",
                    (int)$fp['from_day'],
                    (int)$fp['from_hour'],
                    (int)$fp['until_day'],
                    (int)$fp['until_hour']
                );

                if (!isset($seen[$rangeKey])) {
                    $seen[$rangeKey] = true;

                    // نرمالایز کردن و اضافه کردن title و fine_text
                    $normalized = $this->normalizeFineRow([
                        'from_day_date'   => $fp['from_day'],
                        'from_hour_date'  => $fp['from_hour'],
                        'until_day_date'  => $fp['until_day'],
                        'until_hour_date' => $fp['until_hour'],
                        'from_issuance_hour' => $fp['from_issuance_hour'],
                        'fine_percentage' => $fp['fine_percentage'],
                        'fine_description' => $fp['fine_description'],
                        'fine_description_en' => $fp['fine_description_en'],
                        'is_tax_refund'   => isset($fp['is_tax_refund']) ? $fp['is_tax_refund'] : 0
                    ]);


                    $uniquePercentages[] = $normalized;
                    $timeRangeKeys[] = $rangeKey;
                }
            }

            // merge درصدهای متوالی
            $item['merged_percentages'] = $this->mergeConsecutivePercentages($uniquePercentages);

            // چون fine_percentages اصلی هم لازمه، همون uniquePercentages رو ست میکنیم
            $item['fine_percentages'] = $uniquePercentages;

            // حذف تکراری از fare_classes
            $seenClasses = [];
            $uniqueClasses = [];

            foreach ($item['fare_classes'] as $fc) {
                if (!isset($seenClasses[$fc['class_id']])) {
                    $seenClasses[$fc['class_id']] = true;
                    $uniqueClasses[] = $fc;
                }
            }

            $item['fare_classes'] = $uniqueClasses;

            // گروه بندی بر اساس airline + time ranges
            sort($timeRangeKeys);
            $groupKey = $item['airline_iata_id'] . '|' . implode('|', $timeRangeKeys);

            if (!isset($grouped[$groupKey])) {
                $grouped[$groupKey] = [
                    'airline_iata_id' => $item['airline_iata_id'],
                    'time_ranges'     => $uniquePercentages, // شامل title
                    'items'           => []
                ];
            }

            $grouped[$groupKey]['items'][] = $item;
        }


        return array_values($grouped);
    }
    private function mergeConsecutivePercentages($percentages)
    {
        $merged = [];
        $i = 0;
        $count = count($percentages);

        while ($i < $count) {

            $current = $percentages[$i];
            $colspan = 1;

            // merge consecutive percentages with same fine_percentage and is_tax_refund
            while (
                ($i + $colspan) < $count &&
                (int)$percentages[$i + $colspan]['fine_percentage'] === (int)$current['fine_percentage'] &&
                (int)$percentages[$i + $colspan]['is_tax_refund'] === (int)$current['is_tax_refund']
            ) {
                $colspan++;
            }

            // خروجی merged با حفظ اطلاعات اصلی
            $merged[] = [
                'from_day'        => isset($current['from_day']) ? $current['from_day'] : 0,
                'from_hour'       => isset($current['from_hour']) ? $current['from_hour'] : 0,
                'until_day'       => isset($current['until_day']) ? $current['until_day'] : 0,
                'until_hour'      => isset($current['until_hour']) ? $current['until_hour'] : 0,
                'fine_percentage' => isset($current['fine_percentage']) ? $current['fine_percentage'] : null,
                'fine_description' => isset($current['fine_description']) ? $current['fine_description'] : null,
                'fine_description_en' => isset($current['fine_description_en']) ? $current['fine_description_en'] : null,
                'is_tax_refund'   => isset($current['is_tax_refund']) ? (int)$current['is_tax_refund'] : 0,
                'title'           => isset($current['title']) ? $current['title'] : '',
                'fine_text'       => isset($current['fine_text']) ? $current['fine_text'] : '',
                'colspan'         => $colspan
            ];

            $i += $colspan;
        }

        return $merged;
    }
    private function buildFineRangeTitle($FD, $FH, $UD, $UH,$FIH,$lang)
    {
        $FD = (int)$FD;
        $FH = (int)$FH;
        $UD = (int)$UD;
        $UH = (int)$UH;
        if($lang == 'fa'){
            if ($FD && $FH && $UD && $UH) {
                return "از ساعت {$FH} ، {$FD} روز قبل از پرواز تا ساعت {$UH} ، {$UD} روز قبل از پرواز";
            } elseif ($FD && $FH && !$UD && $UH) {
                return "از ساعت {$FH} ، {$FD} روز قبل از پرواز تا {$UH} ساعت قبل از پرواز";
            } elseif (!$FD && $FH && !$UD && $UH) {
                return "از {$FH} ساعت مانده به پرواز تا {$UH} ساعت مانده به پرواز";
            } elseif (!$FD && !$FH && $UD && $UH) {
                return "تا ساعت {$UH} ، {$UD} روز قبل از پرواز";
            } elseif (!$FD && !$FH && !$UD && $UH) {
                return "تا {$UH} ساعت مانده به پرواز";
            } elseif ($FD && $FH && !$UD && !$UH) {
                return "از ساعت {$FH} ، {$FD} روز مانده به پرواز";
            } elseif (!$FD && $FH && !$UD && !$UH) {
                return "از {$FH} ساعت مانده به پرواز به بعد";
            } elseif (!$FD && !$FH && !$UD && !$UH && !$FIH) {
                return "بعد از پرواز (no show)";
            } elseif($FIH){
                return "از صدور تا {$FIH} ساعت پس از صدور";
            }else{
                return "بازده نامشخص";
            }
        }
        if($lang == 'en'){
            if ($FD && $FH && $UD && $UH) {
                return "From {$FH}:00, {$FD} days before the flight until {$UH}:00, {$UD} days before the flight";
            } elseif ($FD && $FH && !$UD && $UH) {
                return "From {$FH}:00, {$FD} days before the flight until {$UH} hours before the flight";
            } elseif (!$FD && $FH && !$UD && $UH) {
                return "From {$FH} hours before the flight until {$UH} hours before the flight";
            } elseif (!$FD && !$FH && $UD && $UH) {
                return "Until {$UH}:00, {$UD} days before the flight";
            } elseif (!$FD && !$FH && !$UD && $UH) {
                return "Until {$UH} hours before the flight";
            } elseif ($FD && $FH && !$UD && !$UH) {
                return "From {$FH}:00, {$FD} days before the flight";
            } elseif (!$FD && $FH && !$UD && !$UH) {
                return "From {$FH} hours before the flight onwards";
            } elseif (!$FD && !$FH && !$UD && !$UH && $FIH) {
                return "After the flight (No-show)";
            }elseif($FIH){
                return "From issuance until {$FIH} hours after issuance";
            }
            else{
                return "Unknown range";
            }

        }

        return false;
    }
    private function buildFineText($finePercentage,$description, $isTaxRefund = false,$lang)
    {

        $FP = $finePercentage;
        if($lang == 'fa') {
            if ($FP === 0) {
                return "بدون جریمه";
            }

            if ($FP === 100) {
                if ($isTaxRefund) {
                    return "استرداد مالیات";
                }
                return "غیرقابل استرداد";
            }
            if(empty($FP)){
                if($description)
                    return $description['description_fa'];
            }
        }
        if($lang == 'en'){
            if ($FP === 0) {
                return "No penalty";
            }

            if ($FP === 100) {
                if ($isTaxRefund) {
                    return "Tax refund";
                }
                return "Non-refundable";
            }
            if(empty($FP)){
                if($description)
                    return $description['description_en'];
            }
        }

        return "%{$FP}";
    }
    public function normalizeFineRow($row)
    {
        $FD = isset($row['from_day_date']) ? (int)$row['from_day_date'] : 0;
        $FH = isset($row['from_hour_date']) ? (int)$row['from_hour_date'] : 0;
        $UD = isset($row['until_day_date']) ? (int)$row['until_day_date'] : 0;
        $UH = isset($row['until_hour_date']) ? (int)$row['until_hour_date'] : 0;
        $FIH = isset($row['from_issuance_hour']) ? (int)$row['from_issuance_hour'] : 0;
        $FP = isset($row['fine_percentage']) ? $row['fine_percentage'] : null;
        $FDES = isset($row['fine_description']) ? (string)$row['fine_description'] : null;
        $FDESEN = isset($row['fine_description_en']) ? (string)$row['fine_description_en'] : null;
        $FineDes = [
            'description_fa' => $FDES,
            'description_en' => $FDESEN,
        ];
        $isTaxRefund = isset($row['is_tax_refund']) ? (int)$row['is_tax_refund'] : 0;

        return [
            'from_day'        => $FD,
            'from_hour'       => $FH,
            'until_day'       => $UD,
            'until_hour'      => $UH,
            'from_issuance_hour'      => $FIH,
            'fine_description'      => $FDES,
            'fine_description_en'      => $FDESEN,
            'fine_percentage' => $FP,
            'title'           => $this->buildFineRangeTitle($FD, $FH, $UD, $UH,$FIH,'fa'),
            'title_en'           => $this->buildFineRangeTitle($FD, $FH, $UD, $UH,$FIH,'en'),
            'fine_text'       => $this->buildFineText($FP,$FineDes, $isTaxRefund,'fa'),
            'fine_text_en'       => $this->buildFineText($FP,$FineDes, $isTaxRefund,'en'),
            'is_tax_refund'   => $isTaxRefund
        ];
    }
    public function getAirlineFineData($id)
    {
        if(!$id){
            return false;
        }
        $sql = "
    SELECT
        afpt.id AS package_id,
        asi.id as airline_iata_id,
        asi.airline_name,
        asi.airline_uniqe_iata,
        afpt.status AS package_status,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"class_id\":', afct.id,
                ',\"class_name\":\"', REPLACE(afct.class_name, '\"', '\\\"'), '\"}'
            )), ']')
            FROM airline_fine_class_fare_tb afcft
            INNER JOIN airline_fare_class_tb afct 
                ON afct.id = afcft.class_fare_id
            WHERE afcft.fine_package_id = afpt.id
        ) AS fare_classes,
        (
            SELECT CONCAT('[', GROUP_CONCAT(CONCAT(
                '{\"from_day\":', IF(afpt2.from_day_date IS NULL, 'null', afpt2.from_day_date),
                ',\"from_hour\":', IF(afpt2.from_hour_date IS NULL, 'null', afpt2.from_hour_date),
                ',\"until_day\":', IF(afpt2.until_day_date IS NULL, 'null', afpt2.until_day_date),
                ',\"until_hour\":', IF(afpt2.until_hour_date IS NULL, 'null', afpt2.until_hour_date),
                ',\"from_issuance_hour\":', IF(afpt2.from_issuance_hour IS NULL, 'null', afpt2.from_issuance_hour),
                ',\"fine_description\":', IF(afpt2.fine_description IS NULL, 'null',
                    CONCAT('\"', REPLACE(afpt2.fine_description, '\"', '\\\"'), '\"')
                ),
                ',\"fine_description_en\":', IF(afpt2.fine_description_en IS NULL, 'null',
                    CONCAT('\"', REPLACE(afpt2.fine_description_en, '\"', '\\\"'), '\"')
                ),
                ',\"fine_percentage\":', IF(afpt2.fine_percentage IS NULL, 'null', afpt2.fine_percentage),
                '}'
            )), ']')
            FROM airline_fine_percentage_tb afpt2
            WHERE afpt2.fine_package_id = afpt.id
        ) AS fine_percentages
    FROM airline_fine_package_tb afpt
    INNER JOIN airline_standard_iata asi 
        ON asi.id = afpt.airline_iata_id
    WHERE afpt.status = 'active' And afpt.id = {$id}
    ORDER BY afpt.id DESC
    ";

        $result = $this->Model->select($sql);


        foreach ($result as &$row) {
            $row['fare_classes'] = json_decode($row['fare_classes'], true);
            $row['fine_percentages'] = json_decode($row['fine_percentages'], true);
        }
        return $result;
    }

}

?>