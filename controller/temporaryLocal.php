<?php


class temporaryLocal extends clientAuth {

    public function __construct(){
        parent::__construct();
    }


    public function getSpecificTemporary($id_temporary){
        $result_temporaries = $this->getModel('temporaryLocalModel')->get()->where('uniq_id',$id_temporary)->groupBy('Direction')->all();
        $final_result_temporaries = array();
        foreach ($result_temporaries as $result_temporary) {
            $final_result_temporaries[$result_temporary['Direction']] = $result_temporary ;
        }
        return $final_result_temporaries ;

    }

    public function getPriceTemporaryLocal($data_temporary){



        $flight_type = strtolower($data_temporary['FlightType']);
        $source_id = $data_temporary['SourceID'];
        $is_internal = $data_temporary['IsInternalFlight'];
        $type_zone = ($is_internal) ? 'Local' : 'Portal';
        $info_currency = $this->getController('currencyEquivalent')->InfoCurrency(Session::getCurrency());
        $data_check_status_airline = array(
            'airline_iata' => $data_temporary['Airline_IATA'],
            'source_id' => $source_id,
            'flight_type' => $flight_type,
            'is_internal' => $is_internal,
        );

        $check_private = $this->getController('configFlight')->checkConfigStatusSpecificAirline($data_check_status_airline);
        $isForeignAirline = $this->getController('airline')->isForeignAirline($data_temporary['Airline_IATA']);
        $isCounter = $this->getController('login')->isCounter();
        $isCounter = json_decode($isCounter);
        $isSafar360 = functions::isSafar360();

        $calculate_price_change = array(
            'change_type' => $data_temporary['PriceChangeType'],
            'price' => $data_temporary['PriceChange'],
        );
        $arraySourceIncreasePriceFlightSystem = functions::sourceIncreasePriceFlightSystem();

        $discount['off_percent'] = $data_temporary['discount_amount'];

        $add_on_price = 0;
        $it_commission = 0;
        $change_price = false;

        $prices = array(
                'adult' => array(
                    'TotalPrice' => $data_temporary['AdtPrice'],
                    'BasePrice' => $data_temporary['AdtFare'],
                    'CommisionPrice' => $data_temporary['AdtCom'],
                    'count'     => $data_temporary['Adt_qty']
                ),
                'child' => array(
                    'TotalPrice' => $data_temporary['ChdPrice'],
                    'BasePrice' => $data_temporary['ChdFare'],
                    'CommisionPrice' => $data_temporary['ChdCom'],
                    'count'     => $data_temporary['Chd_qty']
                ),
                'infant' => array(
                    'TotalPrice' => $data_temporary['InfPrice'],
                    'BasePrice' => $data_temporary['InfFare'],
                    'CommisionPrice' => $data_temporary['InfCom'],
                    'count'     => $data_temporary['Inf_qty']

                ),
        );

        $foreignAirline = null;

        if ($data_temporary['FlightType'] === 'system') {
            $commissionKeys = array(
                'adult'  => 'adt_system_commission',
                'child'  => 'chd_system_commission',
                'infant' => 'inf_system_commission'
            );

            foreach ($commissionKeys as $type => $key) {
                $commission = !empty($data_temporary[$key]) ? $data_temporary[$key] : 0;
                $prices[$type]['Commission'] = $commission;
            }

            $airlineModel = $this->getModel('airlineModel');
            $airlineForCom = $airlineModel->get(['abbreviation','foreignAirline','amadeusStatus'], true)->where('abbreviation', $data_temporary['Airline_IATA'])->all();
            if (!isset($airlineForCom[0]['foreignAirline'])) {
                $foreignAirline = null;
            }
            if ($airlineForCom[0]['foreignAirline'] == 'active' || $airlineForCom[0]['foreignAirline'] == null || empty($airlineForCom[0]['foreignAirline']) ) {
                $foreignAirline = true;
            } else {
                $foreignAirline = false;
            }
        }


        $price['adult']['TotalPrice'] = $data_temporary['AdtPrice'];
        $price['adult']['TotalPriceWithDiscount'] = 0;
        $price['adult']['BasePrice'] = $data_temporary['AdtFare'];
        $price['adult']['CommisionPrice'] = $data_temporary['AdtCom'];
        $price['child']['TotalPrice'] = $data_temporary['ChdPrice'];
        $price['child']['TotalPriceWithDiscount'] = 0;
        $price['child']['BasePrice'] = $data_temporary['ChdFare'];
        $price['child']['CommisionPrice'] = $data_temporary['ChdCom'];
        $price['infant']['TotalPrice'] = $data_temporary['InfPrice'];
        $price['infant']['TotalPriceWithDiscount'] = 0;
        $price['infant']['BasePrice'] = $data_temporary['InfFare'];
        $price['infant']['CommisionPrice'] = $data_temporary['InfCom'];
        $price['hasDiscount'] = 'No';




        foreach ($prices as $key => $price_type) {
            $price[$key]['has_discount'] = 'No';
            $price[$key]['type_currency'] = functions::Xmlinformation('Rial')->__toString();

            $price_type['TotalPrice'] =  $price[$key]['TotalPrice'];

            $price_type['BasePrice']  =   $price[$key]['BasePrice'];
            if ($calculate_price_change['price'] > 0 && ($flight_type == 'charter' || ($type_zone == 'Portal')
                    || in_array($source_id, $arraySourceIncreasePriceFlightSystem)) && $price_type['TotalPrice'] > 0) {

                if($check_private=='public' && $source_id =='14' && $type_zone == 'Portal'){
                    $price_type['TotalPrice'] += ($price_type['TotalPrice'] * (IT_COMMISSION/100) );
                    $price[$key]['TotalPriceOriginal'] =  $price_type['TotalPrice'];
                }

                if ($calculate_price_change['change_type'] == 'cost') {
                    $change_price = true;
                    $add_on_price = $calculate_price_change['price'];
                } elseif ($calculate_price_change['change_type'] == 'percent') {

                    $change_price = true;
                    if(in_array($source_id,$arraySourceIncreasePriceFlightSystem) && $type_zone == 'Local' && $flight_type =='system'){
                        $add_on_price = (($price_type['BasePrice'] * $calculate_price_change['price']) / 100);
                    }else{
                        $add_on_price = (($price_type['TotalPrice'] * $calculate_price_change['price']) / 100);
                    }
                }
                $price[$key]['TotalPrice'] = $price_type['TotalPrice'];


                $price[$key]['TotalPrice'] += $add_on_price;

                if ($type_zone == 'Local') {
                    $it_commission = $this->getController('irantechCommission')->getFlightCommission($data_temporary['service_title'], $source_id);

                    $price[$key]['TotalPrice'] += $it_commission;
                }
            }
            else {

                $price[$key]['TotalPrice'] = $price_type['TotalPrice'];
                if($check_private=='public' && $source_id =='14' && $type_zone == 'Portal'){

                    $price[$key]['TotalPrice'] += ($price[$key]['TotalPrice'] * (IT_COMMISSION/100) ) ;
                    $price[$key]['TotalPriceOriginal'] =  $price[$key]['TotalPrice'] ;

                }

                //                سیستمی های داخلی فلایتو 3 درصد FARE افزایش دارند
                if($flight_type == 'system' && $source_id =='17' && $type_zone == 'Local'){
                    $price[$key]['TotalPrice'] += (($price_type['BasePrice'] * 3) / 100);
                }
            }


            if ((($type_zone == 'Portal' && $change_price) ||
                    ($type_zone != 'Portal')) && $discount['off_percent'] > 0 && $price_type['TotalPrice'] > 0) {
                $price[$key]['has_discount'] = 'yes';
                if ((!empty($calculate_price_change) && $flight_type == 'charter') || ($type_zone == 'Portal') || in_array($source_id,$arraySourceIncreasePriceFlightSystem)) {

                    $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - (($add_on_price * $discount['off_percent']) / 100));
                } elseif ($check_private == 'public' && $flight_type == 'system') {
                    $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - ($price_type['Commission'] * ($discount['off_percent'] / 100)));
                } elseif ($check_private == 'private' && $flight_type == 'system') {
                    $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - ($price[$key]['CommisionPrice'] * ($discount['off_percent'] / 100)));
                }
            }
            elseif ($flight_type == 'system' && !$foreignAirline && $type_zone == 'Portal') {
                $price[$key]['has_discount'] = 'yes';
                $price[$key]['TotalPriceWithDiscount'] = round($price[$key]['TotalPrice'] - (($price[$key]['CommisionPrice'] * $discount['off_percent']) / 100));
            }
            $origin_price_total_after_change = $price[$key]['TotalPrice'];
            $origin_price_discount_total_after_change = $price[$key]['TotalPriceWithDiscount'];
            if (SOFTWARE_LANG != 'fa') {
                $base_price_currency = functions::CurrencyCalculate($price[$key]['BasePrice'], $info_currency['CurrencyCode'], $info_currency['EqAmount'], $info_currency['CurrencyTitleEn']);
                $total_price_currency = functions::CurrencyCalculate($price[$key]['TotalPrice'], $info_currency['CurrencyCode'], $info_currency['EqAmount'], $info_currency['CurrencyTitleEn']);
                $total_price_with_discount = functions::CurrencyCalculate($price[$key]['TotalPriceWithDiscount'], $info_currency['CurrencyCode'], $info_currency['EqAmount'], $info_currency['CurrencyTitleEn']);
               
                $price[$key]['BasePrice'] = $base_price_currency['AmountCurrency'];
                $price[$key]['TotalPrice'] = $total_price_currency['AmountCurrency'];
                $price[$key]['TotalPriceWithDiscount'] = $total_price_with_discount['AmountCurrency'];
                $price[$key]['type_currency'] = $total_price_currency['TypeCurrency'];
            }
            $price[$key]['price_with_out_currency'] = $origin_price_total_after_change;
            $price[$key]['price_discount_with_out_currency'] = $origin_price_discount_total_after_change;

            if ($flight_type == 'system' && $check_private=='private' && !$isForeignAirline && ($isSafar360 || $isCounter)) {
                if ($price[$key]['has_discount'] =='yes') {
                    $price[$key]['TotalPriceWithDiscount'] -= $price[$key]['CommisionPrice'];
                } else {
                    $price[$key]['TotalPrice'] -= $price[$key]['CommisionPrice'];
                }
            }

            if ($price[$key]['has_discount'] =='yes') {
                $FinalTotalPrice = (int)$price[$key]['TotalPriceWithDiscount'];
            } else {
                $FinalTotalPrice = (int)$price[$key]['TotalPrice'];
            }

            $price['FinalTotalPrice'] += ( $FinalTotalPrice *  (int)$price_type['count']);

        }


        return $price ;
    }


    public function getTotalSearchPrice($price,$count) {
        
        return ($price['adult']['price']*$count['adult_count']) +($price['child']['price']*$count['child_count']) +($price['infant']['price']*$count['infant_count']);
    }

}