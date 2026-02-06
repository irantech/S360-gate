<?php

//if ($_SERVER['REMOTE_ADDR'] == '93.118.161.174') {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}


class commissionSources extends clientAuth
{

    public function __construct() {
        parent::__construct();
        $this->uploadsTb = 'raja_transactions_tb';
        $this->page_limit = 1;
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
        $this->uploadsBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/rajaTransactions' . '/';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function listCom() {

        $sourceModel = $this->getModel('sourceModel');
        $sourceTb = $sourceModel->getTable();

        $sourceList = $sourceModel
            ->get(['*'], true)
            ->where('isActive', 1)
            ->orderBy($sourceTb . '.id', 'DESC')
            ->all(false);

        return $sourceList;
    }

    public function sourceComById($sourceCode , $type) {

        $sourceModel = $this->getModel('sourceModel');
        $sourceTb = $sourceModel->getTable();

        $sourceList = $sourceModel
            ->get(['*'], true)
            ->where('isActive', 1)
            ->where('sourceCode', $sourceCode)
            ->where('sourceType', $type)
            ->orderBy($sourceTb . '.id', 'DESC')
            ->all(false);

        return $sourceList;
    }

    public function updateCom($params) {

        $sourceModel = $this->getModel('sourceModel');
        if ($params['type'] == 's_d_a_d') {
            $data = array(
                's_d_a_d' => $params['Commission'] / 100
            );
        }
        elseif ($params['type'] == 's_kh_a_kh') {
            $data = array(
                's_kh_a_kh' => $params['Commission']
            );
        }
        elseif ($params['type'] == 's_kh_a_d') {
            $data = array(
                's_kh_a_d' => $params['Commission'] / 100
            );
        }
        elseif ($params['type'] == 'ch_d_a_d') {
            $data = array(
                'ch_d_a_d' => $params['Commission']
            );
        }
        elseif ($params['type'] == 'ch_kh_a_kh') {
            $data = array(
                'ch_kh_a_kh' => $params['Commission']
            );
        }
        elseif ($params['type'] == 'ch_kh_a_d') {
            $data = array(
                'ch_kh_a_d' => $params['Commission']
            );
        }
        elseif ($params['type'] == 's_kh_a_kh_au') {
            $data = array(
                's_kh_a_kh_au' => $params['Commission'] / 100
            );
        }

        $condition = " sourceCode='" . $params['sourceCode'] . "'";

        $updateCommision = $sourceModel->update($data,$condition);

        if ($updateCommision) {
            return self::returnJson(true, "کمیسیون منبع ". $params['sourceCode'] ." با موفقیت تغییر یافت", null , 200);
        } else {
            return self::returnJson(false, "عملیات با خطا مواجه شد", null, 400);
        }
    }

    public function updateFareStatus($params) {

        $sourceModel = $this->getModel('sourceModel');

        $fareStatus = $params['fareStatus'];
        if (is_null($fareStatus) || $fareStatus === null || $fareStatus === '') {
            $data = array(
                'fareStatus' => null
            );
        } else {
            $data = array(
                'fareStatus' => $fareStatus
            );
        }

        $condition = " sourceCode='" . $params['sourceCode'] . "'";

        $updateFareStatus = $sourceModel->update($data, $condition);

        if ($updateFareStatus) {
            return self::returnJson(true, "وضعیت fare منبع ". $params['sourceCode'] ." با موفقیت تغییر یافت", null , 200);
        } else {
            return self::returnJson(false, "عملیات با خطا مواجه شد", null, 400);
        }
    }

    public function isForeignAirline(array $flight) {
        $airlineModel = $this->getModel('airlineModel');
        $code = isset($flight['OutputRoutes'][0]['Airline']['Code']) ? $flight['OutputRoutes'][0]['Airline']['Code'] : null;
        $airlineForCom = $airlineModel->get(['abbreviation','foreignAirline','amadeusStatus'], true)->where('abbreviation', $code)->all();
        if (!isset($airlineForCom[0]['foreignAirline'])) {
            return null;
        }
        if ($airlineForCom[0]['foreignAirline'] == 'active' || $airlineForCom[0]['foreignAirline'] == null || empty($airlineForCom[0]['foreignAirline']) ) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * محاسبه کمیسیون منبع برای پروازها
     * (سازگار با PHP 5.6 — بدون scalar type hints و بدون return type declarations و بدون '??')
     */
    public function sourceCommissionCalculation(array $flight, $method)
    {
        // Early return for non-matching client

        // Validate method parameter
        $validMethods = array('search', 'revalidate', 'book');
        if (!in_array($method, $validMethods)) {
            return $flight;
        }

        try {
            // Extract common data based on method
            $extractedData = $this->extractFlightData($flight, $method);
            if ($extractedData === null) {
                return $flight;
            }

            // Check if flight is private
            if ($this->isPrivateFlight($extractedData)) {
                return $flight;
            }

            // Calculate commission
            $commissionAmount = $this->calculateCommission($extractedData);
            if ($commissionAmount === 0) {
                return $flight;
            }

            // Apply commission to flight data
            return $this->applyCommission($flight, $commissionAmount, $method);

        } catch (Exception $e) {
            // Log error and return original flight data
            error_log("Error in sourceCommissionCalculation: " . $e->getMessage());
            return $flight;
        }
    }

    /**
     * محاسبه سود آژانس برای پروازهای سیستمی
     */
    public function setAgencyBenefitSystemFlight(array $flight, $method)
    {
        // Early return for non-matching client

        $validMethods = array('search', 'revalidate', 'book');
        if (!in_array($method, $validMethods)) {
            return $flight;
        }

        try {
            if ($method === 'search') {
                return $this->calculateAgencyBenefitForSearch($flight);
            } elseif ($method === 'revalidate') {
                return $this->calculateAgencyBenefitForRevalidate($flight);
            } elseif ($method === 'book') {
                return $this->calculateAgencyBenefitForBook($flight);
            }
        }
        catch (Exception $e) {
            error_log("Error in setAgencyBenefitSystemFlight: " . $e->getMessage());
            return ($method === 'search') ? $this->getDefaultAgencyBenefit() : $flight;
        }

        return $flight;
    }


    /**
     * استخراج داده‌های مورد نیاز بر اساس نوع متد
     */
    private function extractFlightData(array $flight, $method)
    {
        $data = array();

        switch ($method) {
            case 'search':
                $data['sourceId'] = isset($flight['SourceId']) ? $flight['SourceId'] : null;
                $data['airlineCode'] = isset($flight['OutputRoutes'][0]['Airline']['Code']) ? $flight['OutputRoutes'][0]['Airline']['Code'] : null;
                $data['isInternal'] = isset($flight['IsInternal']) ? $flight['IsInternal'] : false;
                $data['flightType'] = isset($flight['FlightType']) ? $flight['FlightType'] : null;
                break;

            case 'revalidate':
                $data['sourceId'] = isset($flight['SourceID']) ? $flight['SourceID'] : null;
                $data['airlineCode'] = isset($flight['Airline_IATA']) ? $flight['Airline_IATA'] : null;
                $data['isInternal'] = (isset($flight['IsInternalFlight']) && $flight['IsInternalFlight'] == '1');
                $data['flightType'] = isset($flight['FlightType']) ? $flight['FlightType'] : null;
                break;

            case 'book':
                $data['sourceId'] = isset($flight['api_id']) ? $flight['api_id'] : null;
                $flightBookLocal = $this->getFlightBookLocal(isset($flight['request_number']) ? $flight['request_number'] : '');
                if (empty($flightBookLocal)) {
                    return null;
                }
                $data['airlineCode'] = isset($flightBookLocal[0]['airline_iata']) ? $flightBookLocal[0]['airline_iata'] : null;
                $data['isInternal'] = (isset($flightBookLocal[0]['IsInternal']) && $flightBookLocal[0]['IsInternal'] == '1');
                $data['flightType'] = isset($flightBookLocal[0]['flight_type']) ? $flightBookLocal[0]['flight_type'] : null;
                break;

            default:
                return null;
        }

        // Validate required fields
        if (empty($data['sourceId']) || empty($data['airlineCode'])) {
            return null;
        }

        // Get source commission (with caching)
        $data['sourceCom'] = $this->getCachedSourceCom($data['sourceId']);
        if (empty($data['sourceCom'])) {
            return null;
        }

        // Get airline info (with caching)
        $data['airlineInfo'] = $this->getCachedAirlineInfo($data['airlineCode']);
        if (empty($data['airlineInfo'])) {
            return null;
        }

        return $data;
    }

    /**
     * بررسی خصوصی بودن پرواز
     */
    private function isPrivateFlight(array $data)
    {
        $abbrev = isset($data['airlineInfo']['abbreviation']) ? $data['airlineInfo']['abbreviation'] : null;
        $isInternalInt = (int) ($data['isInternal'] ? $data['isInternal'] : 0);
        $flightType = isset($data['flightType']) ? $data['flightType'] : null;
        $sourceId = isset($data['sourceId']) ? $data['sourceId'] : null;

        $checkResult = functions::checkConfigPid($abbrev, $isInternalInt, $flightType, $sourceId);

        return $checkResult === 'private';
    }

    /**
     * محاسبه میزان کمیسیون
     */
    private function calculateCommission(array $data)
    {
        $commission = 0;
        $sourceCom = isset($data['sourceCom']) ? $data['sourceCom'] : array();
        $airlineInfo = isset($data['airlineInfo']) ? $data['airlineInfo'] : array();
        $isInternal = isset($data['isInternal']) ? $data['isInternal'] : false;
        $flightType = isset($data['flightType']) ? $data['flightType'] : null;

        // Charter flights
        if ($flightType === 'charter') {
            if ($isInternal) {
                $commission = isset($sourceCom['ch_d_a_d']) ? $sourceCom['ch_d_a_d'] : 0;
            } else {
                $isForeignInactive = (isset($airlineInfo['foreignAirline']) && $airlineInfo['foreignAirline'] === 'inactive');
                $commission = $isForeignInactive
                    ? (isset($sourceCom['ch_kh_a_d']) ? $sourceCom['ch_kh_a_d'] : 0)
                    : (isset($sourceCom['ch_kh_a_kh']) ? $sourceCom['ch_kh_a_kh'] : 0);
            }
        } // System flights with amadeusStatus = 0
        elseif ($flightType === 'system' && (isset($airlineInfo['amadeusStatus']) ? $airlineInfo['amadeusStatus'] : '1') === '0') {
            if (!$isInternal && (isset($airlineInfo['foreignAirline']) ? $airlineInfo['foreignAirline'] : '') != 'inactive') {
                $commission = isset($sourceCom['s_kh_a_kh']) ? $sourceCom['s_kh_a_kh'] : 0;
            }
        }

        return (float)$commission;
    }

    /**
     * اعمال کمیسیون به داده‌های پرواز
     */
    private function applyCommission(array $flight, $commission, $method)
    {
        $commission = (float)$commission;
        if ($commission <= 0) {
            return $flight;
        }

        switch ($method) {
            case 'search':
                return $this->applyCommissionToSearch($flight, $commission);

            case 'revalidate':
                return $this->applyCommissionToRevalidate($flight, $commission);

            case 'book':
                return $this->applyCommissionToBook($flight, $commission);
        }

        return $flight;
    }

    /**
     * اعمال کمیسیون برای حالت search
     */
    private function applyCommissionToSearch(array $flight, $commission)
    {
        if (!isset($flight['PassengerDatas']) || !is_array($flight['PassengerDatas'])) {
            return $flight;
        }

        foreach ($flight['PassengerDatas'] as $key => $passenger) {
            if (isset($passenger['TotalPrice']) && $passenger['TotalPrice'] > 0) {
                $flight['PassengerDatas'][$key]['TotalPrice'] += $commission;
            }
            if (isset($passenger['BasePrice']) && $passenger['BasePrice'] > 0) {
                $flight['PassengerDatas'][$key]['BasePrice'] += $commission;
            }
        }

        return $flight;
    }

    /**
     * اعمال کمیسیون برای حالت revalidate
     */
    private function applyCommissionToRevalidate(array $flight, $commission)
    {
        $priceFields = array('AdtPrice', 'AdtFare', 'ChdPrice', 'ChdFare', 'InfPrice', 'InfFare');

        foreach ($priceFields as $field) {
            if (isset($flight[$field]) && $flight[$field] > 0) {
                $flight[$field] += $commission;
            }
        }

        return $flight;
    }

    /**
     * اعمال کمیسیون برای حالت book
     */
    private function applyCommissionToBook(array $flight, $commission)
    {
        $priceFields = array('adt_price', 'adt_fare', 'chd_price', 'chd_fare', 'inf_price', 'inf_fare');

        foreach ($priceFields as $field) {
            if (isset($flight[$field]) && $flight[$field] > 0) {
                $flight[$field] += $commission;
            }
        }

        return $flight;
    }

    /**
     * محاسبه سود آژانس برای جستجو
     */
    private function calculateAgencyBenefitForSearch(array $flight)
    {

        $defaultBenefit = $this->getDefaultAgencyBenefit();

        // Extract data
        $extractedData = $this->extractFlightData($flight, 'search');
        if ($extractedData === null) {
            return $defaultBenefit;
        }

        // Check if private
        if ($this->isPrivateFlight($extractedData)) {
            return $defaultBenefit;
        }

        // Only calculate for system flights
        if ($extractedData['flightType'] !== 'system') {
            return $defaultBenefit;
        }

        // Calculate commission difference
        $commissionDiff = $this->calculateAgencyCommissionDifference($extractedData);
        if ($commissionDiff <= 0) {
            return $defaultBenefit;
        }

        // Apply to passenger data
        return $this->applyAgencyBenefitToPassengers($flight, $commissionDiff);
    }

    /**
     * محاسبه سود آژانس برای revalidate
     */
    private function calculateAgencyBenefitForRevalidate(array $flight)
    {
        if (!isset($flight['FlightType']) || $flight['FlightType'] !== 'system') {
            return $flight;
        }

        $extractedData = $this->extractFlightData($flight, 'revalidate');
        if ($extractedData === null) {
            return $flight;
        }

        if ($this->isPrivateFlight($extractedData)) {
            return $flight;
        }

        $commissionDiff = $this->calculateAgencyCommissionDifference($extractedData);
        if ($commissionDiff <= 0) {
            return $flight;
        }

        $passengerTypes = array(
            'Adt' => array('price' => 'AdtPrice', 'fare' => 'AdtFare', 'commission' => 'adt_system_commission'),
            'Chd' => array('price' => 'ChdPrice', 'fare' => 'ChdFare', 'commission' => 'chd_system_commission'),
            'Inf' => array('price' => 'InfPrice', 'fare' => 'InfFare', 'commission' => 'inf_system_commission')
        );

        $systemCommissions = array();
        $totalCommission = 0;
        $hasCommission = false;
        $isCounter = $this->getController('login')->isCounter();
        $isCounter = json_decode($isCounter);
        $isSafar360 = functions::isSafar360();

        foreach ($passengerTypes as $type => $fields) {
            if (!empty($flight[$fields['fare']]) && $flight[$fields['fare']] > 0) {
                $commission = (int)($flight[$fields['fare']] * $commissionDiff);

                if (isset($flight[$fields['price']]) && $flight[$fields['price']] > 0 && ($isCounter || $isSafar360)) {
                    $flight[$fields['price']] -= $commission;
                }

                if ($commission > 0) {
                    $systemCommissions[$fields['commission']] = $commission;
                    $hasCommission = true;
                }
            }
        }

        if ($hasCommission) {
                foreach ($systemCommissions as $key => $value) {
                    $flight[$key] = $value;
                }
        }

        return $flight;
    }
    /**
     * محاسبه سود آژانس برای رزرو
     */
    private function calculateAgencyBenefitForBook(array $flight)
    {
        // Get flight book local data
        $flightBookLocal = $this->getFlightBookLocal(isset($flight['request_number']) ? $flight['request_number'] : '');
        if (empty($flightBookLocal) || (!isset($flightBookLocal[0]['flight_type']) || $flightBookLocal[0]['flight_type'] !== 'system')) {
            return $flight;
        }

        // Prepare data for extraction
        $tempFlight = $flight;
        $tempFlight['api_id'] = isset($flight['api_id']) ? $flight['api_id'] : null;
        $tempFlight['request_number'] = isset($flight['request_number']) ? $flight['request_number'] : '';

        // Extract data
        $extractedData = $this->extractFlightData($tempFlight, 'book');
        if ($extractedData === null) {
            return $flight;
        }

        // Check if private
        if ($this->isPrivateFlight($extractedData)) {
            return $flight;
        }

        // Calculate commission difference
        $commissionDiff = $this->calculateAgencyCommissionDifference($extractedData);
        if ($commissionDiff <= 0) {
            return $flight;
        }


        // Apply commission to fare fields
        $fareFields = array(
            'adt_fare' => 'adt_price',
            'chd_fare' => 'chd_price',
            'inf_fare' => 'inf_price'
        );

        $isCounter = $this->getController('login')->isCounter();
        $isCounter = json_decode($isCounter);
        $isSafar360 = functions::isSafar360();

        foreach ($fareFields as $fareField => $priceField) {
            if (!empty($flight[$fareField]) && $flight[$fareField] > 0) {
                $systemCommission = (int)($flight[$fareField] * $commissionDiff);
                $flight['system_flight_commission'] = $systemCommission;
                if ($isCounter || $isSafar360) {
                    $flight[$priceField] -= $systemCommission;
                }
                break;
            }
        }



        return $flight;
    }

    /**
     * محاسبه تفاوت کمیسیون آژانس
     */
    private function calculateAgencyCommissionDifference(array $data)
    {


        $sourceCom = isset($data['sourceCom']) ? $data['sourceCom'] : array();
        $airlineInfo = isset($data['airlineInfo']) ? $data['airlineInfo'] : array();
        $isInternal = isset($data['isInternal']) ? $data['isInternal'] : false;

        $airlineCommission = 0;
        $sourceCommission = 0;

        if ($isInternal) {
            $airlineCommission = (float)(isset($airlineInfo['Commission_internal']) ? $airlineInfo['Commission_internal'] : 0);
            $sourceCommission = (float)(isset($sourceCom['s_d_a_d']) ? $sourceCom['s_d_a_d'] : 0);
        }
        else {
            $airlineCommission = (float)(isset($airlineInfo['Commission_external']) ? $airlineInfo['Commission_external'] : 0);

            if ((isset($airlineInfo['foreignAirline']) ? $airlineInfo['foreignAirline'] : '') === 'inactive') {
                $sourceCommission = (float)(isset($sourceCom['s_kh_a_d']) ? $sourceCom['s_kh_a_d'] : 0);
            } elseif ((isset($airlineInfo['amadeusStatus']) ? $airlineInfo['amadeusStatus'] : '1') === '1') {
                $sourceCommission = (float)(isset($sourceCom['s_kh_a_kh_au']) ? $sourceCom['s_kh_a_kh_au'] : 0);
            }
        }

        // Use bcsub for precision if available, otherwise fallback to subtraction
        if (function_exists('bcsub')) {
            return (float) bcsub((string)$airlineCommission, (string)$sourceCommission, 3);
        } else {
            return (float) ($airlineCommission - $sourceCommission);
        }
    }

    /**
     * اعمال سود آژانس به داده‌های مسافران
     */
    private function applyAgencyBenefitToPassengers(array $flight, $commissionDiff)
    {
        $agencyBenefit = $this->getDefaultAgencyBenefit();

        if (!isset($flight['PassengerDatas']) || !is_array($flight['PassengerDatas'])) {
            return $agencyBenefit;
        }

        $typeMap = array(
            'ADT' => 'adult',
            'CHD' => 'child',
            'INF' => 'infant'
        );

        foreach ($flight['PassengerDatas'] as $passenger) {
            if (empty($passenger['BasePrice']) || $passenger['BasePrice'] <= 0) {
                continue;
            }

            $passengerType = isset($passenger['PassengerType']) ? $passenger['PassengerType'] : '';
            $benefitKey = isset($typeMap[$passengerType]) ? $typeMap[$passengerType] : strtolower($passengerType);

            if (array_key_exists($benefitKey, $agencyBenefit)) {
                $agencyBenefit[$benefitKey] = (int)($passenger['BasePrice'] * $commissionDiff);
            }
        }

        return $agencyBenefit;
    }

    /**
     * دریافت مقادیر پیش‌فرض سود آژانس
     */
    private function getDefaultAgencyBenefit()
    {
        return array(
            'adult' => 0,
            'child' => 0,
            'infant' => 0
        );
    }

    /**
     * دریافت اطلاعات رزرو محلی با cache
     */
    private function getFlightBookLocal($requestNumber)
    {
        static $cache = array();

        if (empty($requestNumber)) {
            return array();
        }

        if (!isset($cache[$requestNumber])) {
            $cache[$requestNumber] = $this->getModel('bookLocalModel')
                ->getTicketsByRequestNumber($requestNumber) ?: array();
        }

        return $cache[$requestNumber];
    }

    /**
     * دریافت کمیسیون منبع با cache
     */
    private function getCachedSourceCom($sourceId)
    {
        static $cache = array();

        if (!isset($cache[$sourceId])) {
            $result = $this->sourceComById($sourceId, 'flight');
            $cache[$sourceId] = (!empty($result) && isset($result[0])) ? $result[0] : array();
        }

        return $cache[$sourceId];
    }

    /**
     * دریافت اطلاعات airline با cache
     */
    private function getCachedAirlineInfo($airlineCode)
    {
        static $cache = array();

        if (!isset($cache[$airlineCode])) {
            $airlineModel = $this->getModel('airlineModel');
            $result = $airlineModel
                ->get(array('abbreviation', 'foreignAirline', 'amadeusStatus',
                    'Commission_internal', 'Commission_external'), true)
                ->where('abbreviation', $airlineCode)
                ->all();

            $cache[$airlineCode] = (!empty($result) && isset($result[0])) ? $result[0] : array();
        }

        return $cache[$airlineCode];
    }

}
