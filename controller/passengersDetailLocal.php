<?php

class passengersDetailLocal extends apiLocal
{
    /* variables that recived for search */

    //region [variable]
    public $OriginCity;    // flight of city
    public $DestiCity;    // flight to city
    public $OriginAirportIata;   // Code Iata OriginCity Airport
    public $DestiAirportIata;   // Code Iata DestiCity Airport
    public $AirlineName;                      //Airline Name 
    public $Airline_IATA;  //Iata Code Airline 
    public $AircraftCode;  //Code manufacure Airplane
    public $FlightNo;  //Number Flight 
    public $Date;  //Date Flight 
    public $Time;                                 //Time  Flight 
    public $AdtPrice;                           //Adult Price (age>12year) 
    public $ChdPrice;                           //Child Price (age >2 year and age<12 year)
    public $InfPrice;                            //Infant Price (age < 2 year)
    public $PriceChange;                            //amount of price changes
    public $PriceChangeType;                        //increase or decrease
    public $FlightType;                         // Charter Or System 
    public $SubSystem;                         // Wich Software Suplier
    public $Capacity;                             // Capacity Flight 
    public $date_register;                     // Date Of register Recorde ticket in temperory
    public $SupplierID;                         // ID Supplier
    public $SupplierName;                     // Name Of supplier
    public $Description;                     //Description of ticket
    public $SeatClass;                     // Economy(Y) Or Business(C)
    public $customerID;                     // Customers ID
    public $token_session;                     // session returned of request Revalidate
    public $check_session;                     // session for check refresh page
    public $CheckCredit;                     // session for check refresh page
    public $CabinType;                     // session for check refresh page
    public $Adt_qty;
    public $Chd_qty;
    public $Inf_qty;
    public $LinkCaptcha;
    public $AdtPriceByChange;
    public $ChdPriceByChange;
    public $InfPriceByChange;
    public $Amount = 0;
    public $SourceID;
    public $countRoute;
    public $dateForeignJalaliDeparture;
    public $dateForeignMiladiDeparture;
    public $dateForeignJalaliArrival;
    public $dateForeignMiladiArrival;
    public $dateDeptForeignJalaliDeparture;
    public $dateDeptForeignMiladiDeparture;
    public $dateReturnForeignJalaliArrival;
    public $dateReturnForeignMiladiArrival;
    public $dateDeptForeignJalaliArrival;
    public $dateDeptForeignMiladiArrival;
    public $dateReturnForeignJalaliDeparture;
    public $dateReturnForeignMiladiDeparture;
    public $ArrayDeptForeign;
    public $ArrayReturnForeign;
    public $Direction;  //dept and return for twoways
    public $AdtPriceType;  //dept and return for twoways
    public $CurrencyCode;
    public $isInternal;
    public $reSearchAddress;
    public $flightMKTime;
    public $CheckAdtPrice;
    public $CheckChdPrice;
    public $CheckInfPrice;
    public $temporary;
    public $originalCaptcha;
    public $arrivalCaptcha;
    public $LinkCaptchaReturn;
    public $FinalTotalPrice;
    public $diff_price;

    /* Search results */
    public $classPersian;  // ranslate $detailsReturn to persian
    public $passengers = array();   // Array contains customer passengers
    public $priceDetails = array();  // Array contain price ticket
    public $RoutesTicket = array();  // Array contain price ticket
    public $arrayTemp = array();  // Array contain price ticket
    //endregion


    /**
     * passengersDetailLocal constructor.
     */
    public function __construct()
    {
        parent::__construct();


        $this->customerID = Session::getUserId();

//        $transaction = Load::controller('transaction');
//        $transactionPrice = 0;
        if (GDS_SWITCH == "passengersDetailLocal") {
             $this->temporary = isset($_POST['temporary']) ? $_POST['temporary'] : '';
             $result_temporary_local = $this->getController('temporaryLocal')->getSpecificTemporary($this->temporary);

             $check_test_parto = functions::isTestServer() && $_POST['MultiWayTicket'] =='TwoWay' && $result_temporary_local['TwoWay']['IsInternalFlight']=='1' ;
             if($check_test_parto){
                 $_POST['ZoneFlight'] = 'TestParto';
             }



            foreach ($result_temporary_local as $direction => $rec) {
                if($direction =='TwoWay' && $result_temporary_local['TwoWay']['IsInternalFlight']=='1')
                {
                    $_POST['ZoneFlight'] = 'TestParto';
                }

                $this->Direction[$direction] = $direction;
                $this->CurrencyCode = $rec['CurrencyCode'];
                $this->isInternal = $rec['IsInternalFlight'];
                $this->countRoute[$direction] = 0 ;


                if(!empty($rec['LinkCaptcha'])) {

                    if($rec['SourceID']=='16'){
                        $captchas = json_decode($rec['LinkCaptcha'],true) ;
                        $url = str_replace('https','http',$captchas['dept']);
                        $image = file_get_contents($url);
                        $this->LinkCaptcha[$direction] = base64_encode($image);
                        $this->originalCaptcha[$direction] = $captchas['dept'];



                        $url_return = str_replace('https','http',$captchas['return']);
                        $image_return = file_get_contents($url_return);
                        $this->LinkCaptchaReturn[$direction] = base64_encode($image_return);
                        $this->arrivalCaptcha[$direction] = $captchas['return'];

                    }else{
                        $url = str_replace('https','http',$rec['LinkCaptcha']);
                        $image = file_get_contents($url);

                        $this->LinkCaptcha[$direction] = base64_encode($image);
                        $this->originalCaptcha[$direction] = $rec['LinkCaptcha'];
                    }
                }else{
                    $this->LinkCaptcha[$direction] = '';
                    $this->originalCaptcha[$direction] = '';
                }

                $price_temporary = $this->getController('temporaryLocal')->getPriceTemporaryLocal($rec);

                if($rec['SourceID']=='14'){

                    $request_number = explode('-',$rec['token_session']);
                    $search_prices = $this->getModel('searchPricesModel')->get()->where('client_id',CLIENT_ID)->where('request_number',$request_number[0])->find();
                    $prices = json_decode($search_prices['prices'],true);

                    $price_selected = [];
                    foreach ($prices as $item) {
                        if($item['flightId'] == $search_prices['flight_id_selected']){
                            $price_selected = $item['prices'];
                        }
                    }

                    $data_count = [
                        'adult_count'=> $rec['Adt_qty'],
                        'child_count'=> $rec['Adt_qty'],
                        'infant_count'=> $rec['Adt_qty'],
                    ];


                    $price_search = $this->getController('temporaryLocal')->getTotalSearchPrice($price_selected,$data_count);

                    $this->diff_price = $price_temporary['FinalTotalPrice'] - $price_search ;

                }


                functions::insertLog('this_price ==>'.json_encode($price_temporary,256),'checkPrice');



                $this->AdtPriceType[$direction]     =  $price_temporary['adult']['type_currency'] ;
                $this->FinalTotalPrice[$direction]  =  $price_temporary['FinalTotalPrice'] ;
                $this->AdtPriceByChange[$direction] = ($price_temporary['adult']['has_discount']  =='yes')  ?  $price_temporary['adult']['TotalPriceWithDiscount'] : $price_temporary['adult']['TotalPrice'];
                $this->ChdPriceByChange[$direction] = ($price_temporary['child']['has_discount']  =='yes')  ?  $price_temporary['child']['TotalPriceWithDiscount'] : $price_temporary['child']['TotalPrice'];
                $this->InfPriceByChange[$direction] = ($price_temporary['infant']['has_discount'] =='yes')  ?  $price_temporary['infant']['TotalPriceWithDiscount'] : $price_temporary['infant']['TotalPrice'];


                /*
                //calculate transaction price
                $transactionPrice += $transaction->CheckCreditTemproryStep($rec);
                $this->PriceChange[$direction] = $rec['PriceChange'];
                $this->PriceChangeType[$direction] = $rec['PriceChangeType'];

                $type_change_price = ($rec['IsInternalFlight'] == '1') ? true :false ;
                $AdtPriceByChange = functions::setPriceChanges($rec['Airline_IATA'], $rec['FlightType'], $rec['AdtPrice'],$rec['AdtFare'],($_POST['ZoneFlight'] == 'Local') ? 'Local' : 'Portal', strtolower($rec['FlightType']) == 'system' ? '' : 'public',$rec['SourceID']);
                $ChdPriceByChange = functions::setPriceChanges($rec['Airline_IATA'], $rec['FlightType'], $rec['ChdPrice'],$rec['ChdFare'],($_POST['ZoneFlight'] == 'Local') ? 'Local' : 'Portal', strtolower($rec['FlightType']) == 'system' ? '' : 'public',$rec['SourceID']);
                $InfPriceByChange = functions::setPriceChanges($rec['Airline_IATA'], $rec['FlightType'], $rec['InfPrice'],$rec['InfFare'],($_POST['ZoneFlight'] == 'Local') ? 'Local' : 'Portal', strtolower($rec['FlightType']) == 'system' ? '' : 'public',$rec['SourceID']);


                $AdtPriceByChangeExploded = explode(':', $AdtPriceByChange);
                $ChdPriceByChangeExploded = explode(':', $ChdPriceByChange);
                $InfPriceByChangeExploded = explode(':', $InfPriceByChange);

                $InfoCurrencyAdult = functions::CurrencyCalculate($AdtPriceByChangeExploded[1],$currency_code);
                $InfoCurrencyChild = functions::CurrencyCalculate($ChdPriceByChangeExploded[1],$currency_code);
                $InfoCurrencyInfant = functions::CurrencyCalculate($InfPriceByChangeExploded[1],$currency_code);


                $this->AdtPrice[$direction] = $InfoCurrencyAdult['AmountCurrency'];
                $this->ChdPrice[$direction] = $InfoCurrencyChild['AmountCurrency'];
                $this->InfPrice[$direction] = $InfoCurrencyInfant['AmountCurrency'];
                $this->AdtPriceType[$direction] = $InfoCurrencyAdult['TypeCurrency'];

                $InfoCurrencyAdultByChange = functions::CurrencyCalculate($AdtPriceByChangeExploded[0],$rec['CurrencyCode']);
                $InfoCurrencyChildByChange = functions::CurrencyCalculate($ChdPriceByChangeExploded[0],$rec['CurrencyCode']);

                $this->AdtPriceByChange[$direction] = $InfoCurrencyAdultByChange['AmountCurrency'];
                $this->ChdPriceByChange[$direction] = $InfoCurrencyChildByChange['AmountCurrency'];
                $this->InfPriceByChange[$direction] = $this->InfPrice[$direction];
                 // Caution: اعتبارسنجی صاحب سیستم
                $objTransaction = Load::controller('transaction');
                $checkTransaction = $objTransaction->checkCredit($transactionPrice,'online');
                $this->CabinType[$direction] = $rec['CabinType'];*/



                if ($rec['IsInternalFlight'] == '0' ||( $rec['IsInternalFlight'] == '1' && $direction == 'TwoWay')  ||     $_POST['ZoneFlight'] == 'TestParto') {
                    $this->RoutesTicket[$direction] = $this->DetailRoutes($rec['id']);
                    $this->countRoute[$direction] = count($this->RoutesTicket[$direction]);
                    if ($direction == 'TwoWay' || $direction == 'multi_destination') {
                        foreach ($this->RoutesTicket[$direction] as $Key => $TwoWayTicketForeign) {
                            if ($TwoWayTicketForeign['TypeRoute'] == 'Dept') {
                                $this->ArrayDeptForeign [] = $TwoWayTicketForeign;
                            } elseif ($TwoWayTicketForeign['TypeRoute'] == 'Return') {
                                $this->ArrayReturnForeign [] = $TwoWayTicketForeign;
                            }
                        }

                        $this->dateDeptForeignJalaliDeparture[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali(str_replace('/', '-', $this->ArrayDeptForeign [0]['Date'])));
                        $this->dateDeptForeignMiladiDeparture[$direction] = date_format(date_create(functions::ConvertToMiladi(str_replace('/', '-', $this->ArrayDeptForeign [0]['Date']))), "jM");
                        $this->dateDeptForeignJalaliArrival[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali($this->RoutesTicket[$direction][(count($this->ArrayDeptForeign)) - 1]['ArrivalDate']));
                        $this->dateDeptForeignMiladiArrival[$direction] = date_format(date_create($this->RoutesTicket[$direction][(count($this->ArrayDeptForeign)) - 1]['ArrivalDate']), "jM");


                        $this->dateReturnForeignJalaliDeparture[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali(str_replace('/', '-', $this->ArrayReturnForeign[0]['Date'])));
                        $this->dateReturnForeignMiladiDeparture[$direction] = date_format(date_create(functions::ConvertToMiladi(str_replace('/', '-', $this->ArrayReturnForeign[0]['Date']))), "jM");
                        $this->dateReturnForeignJalaliArrival[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']));
                        $this->dateReturnForeignMiladiArrival[$direction] = date_format(date_create($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']), "jM");


                    } else {
                        $this->dateForeignJalaliDeparture[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali(str_replace('/', '-', $this->RoutesTicket[$direction][0]['Date'])));
                        $this->dateForeignMiladiDeparture[$direction] = date_format(date_create(functions::ConvertToMiladi(str_replace('/', '-', $this->RoutesTicket[$direction][0]['Date']))), "jM");
                        $this->dateForeignJalaliArrival[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']));
                        $this->dateForeignMiladiArrival[$direction] = date_format(date_create($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']), "jM");
                    }

                }

                if ($rec['IsInternalFlight'] == '1') {
                    $this->OriginCity[$direction] = $rec['OriginCity'];
                    $this->DestiCity[$direction] = $rec['DestiCity'];
                    $this->OriginAirportIata[$direction] = $rec['OriginAirportIata'];
                    $this->DestiAirportIata[$direction] = $rec['DestiAirportIata'];
                    $this->AirlineName[$direction] = $rec['AirlineName'];
                    $this->Airline_IATA[$direction] = $rec['Airline_IATA'];
                    $this->AircraftCode[$direction] = $rec['AircraftCode'];
                    $this->FlightNo[$direction] = $rec['FlightNo'];
                    $this->Date[$direction] = $rec['Date'];
                    $this->Time[$direction] = $rec['Time'];
                    $this->CabinType[$direction] = $rec['CabinType'];
                }



                $this->FlightType[$direction] = $rec['FlightType'];


                $this->Capacity[$direction] = $rec['Capacity'];


                $this->Adt_qty = $rec['Adt_qty'];
                $this->Chd_qty = $rec['Chd_qty'];
                $this->Inf_qty = $rec['Inf_qty'];
                $this->token_session[$direction] = $rec['token_session'];
                $this->SeatClass[$direction] = ($rec['SeatClass'] == 'C' || $rec['SeatClass'] == 'B') ? functions::Xmlinformation('Business') : functions::Xmlinformation('Economics');
                $this->SourceID[$direction] = $rec['SourceID'];
                $this->totalQty = $this->Adt_qty + $this->Chd_qty + $this->Inf_qty;
            }


            $this->CheckCredit ='TRUE';// $checkTransaction['status'];


        }
        else {


            $this->temporary = isset($_POST['temporary']) ? $_POST['temporary'] : '';


            $model = Load::model('temporary_local');
            $records = $model->get($this->temporary);


            $this->arrayTemp = $records ;

            if(isset($records) && !empty($records)) {
                
                foreach ($records as $direction => $rec) {


                    if ($rec['SourceID'] == '14') {
                        $price_temporary = $this->getController('temporaryLocal')->getPriceTemporaryLocal($rec);
                        if(isset($price_temporary['adult']['TotalPriceOriginal'])){
                            $this->arrayTemp[$direction]['AdtPrice'] = $price_temporary['adult']['TotalPriceOriginal'];
                        }
                        if(isset($price_temporary['child']['TotalPriceOriginal'])) {
                            $this->arrayTemp[$direction]['ChdPrice'] = $price_temporary['child']['TotalPriceOriginal'];
                        }
                        if(isset($price_temporary['infant']['TotalPriceOriginal'])) {
                            $this->arrayTemp[$direction]['InfPrice'] = $price_temporary['infant']['TotalPriceOriginal'];
                        }


                    }

                    $this->Direction[$direction] = $direction;
                    $this->RoutesTicket[$direction] = $this->DetailRoutes($rec['id']);

                    $this->countRoute[$direction] = count($this->RoutesTicket[$direction]);
                    $this->CurrencyCode = $rec['CurrencyCode'];
                    $this->isInternal = $rec['IsInternalFlight'];

                    if ($rec['IsInternalFlight'] == '0' || (isset($_POST['type']) && $_POST['type']=='package') || $_POST['ZoneFlight'] == 'TestParto') {
                        if ($direction == 'TwoWay') {
                            foreach ($this->RoutesTicket[$direction] as $Key => $TwoWayTicketForeign) {
                                if ($TwoWayTicketForeign['TypeRoute'] == 'Dept') {
                                    $this->ArrayDeptForeign [] = $TwoWayTicketForeign;

                                } elseif ($TwoWayTicketForeign['TypeRoute'] == 'Return') {
                                    $this->ArrayReturnForeign [] = $TwoWayTicketForeign;
                                }
                            }

                            $this->dateDeptForeignJalaliDeparture[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali(str_replace('/', '-', $this->ArrayDeptForeign [0]['Date'])));
                            $this->dateDeptForeignMiladiDeparture[$direction] = date_format(date_create(functions::ConvertToMiladi(str_replace('/', '-', $this->ArrayDeptForeign [0]['Date']))), "jM");
                            $this->dateDeptForeignJalaliArrival[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali($this->RoutesTicket[$direction][(count($this->ArrayDeptForeign)) - 1]['ArrivalDate']));
                            $this->dateDeptForeignMiladiArrival[$direction] = date_format(date_create($this->RoutesTicket[$direction][(count($this->ArrayDeptForeign)) - 1]['ArrivalDate']), "jM");


                            $this->dateReturnForeignJalaliDeparture[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali(str_replace('/', '-', $this->ArrayReturnForeign[0]['Date'])));
                            $this->dateReturnForeignMiladiDeparture[$direction] = date_format(date_create(functions::ConvertToMiladi(str_replace('/', '-', $this->ArrayReturnForeign[0]['Date']))), "jM");
                            $this->dateReturnForeignJalaliArrival[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']));
                            $this->dateReturnForeignMiladiArrival[$direction] = date_format(date_create($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']), "jM");


                        } else {
                            $this->dateForeignJalaliDeparture[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali(str_replace('/', '-', $this->RoutesTicket[$direction][0]['Date'])));
                            $this->dateForeignMiladiDeparture[$direction] = date_format(date_create(functions::ConvertToMiladi(str_replace('/', '-', $this->RoutesTicket[$direction][0]['Date']))), "jM");
                            $this->dateForeignJalaliArrival[$direction] = dateTimeSetting::jdate("dF", functions::FormatDateJalali($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']));
                            $this->dateForeignMiladiArrival[$direction] = date_format(date_create($this->RoutesTicket[$direction][($this->countRoute[$direction]) - 1]['ArrivalDate']), "jM");
                        }

                    }


                    if ($rec['IsInternalFlight'] == '1') {
                        $this->OriginCity[$direction] = $rec['OriginCity'];
                        $this->DestiCity[$direction] = $rec['DestiCity'];
                        $this->OriginAirportIata[$direction] = $rec['OriginAirportIata'];
                        $this->DestiAirportIata[$direction] = $rec['DestiAirportIata'];
                        $this->AirlineName[$direction] = $rec['AirlineName'];
                        $this->Airline_IATA[$direction] = $rec['Airline_IATA'];
                        $this->AircraftCode[$direction] = $rec['AircraftCode'];
                        $this->FlightNo[$direction] = $rec['FlightNo'];
                        $this->Date[$direction] = $rec['Date'];
                        $this->Time[$direction] = $rec['Time'];
                        $this->CabinType[$direction] = $rec['CabinType'];
                        $this->LinkCaptcha[$direction] = $rec['LinkCaptcha'];


                    }

                    $this->LinkCaptcha[$direction] = $rec['LinkCaptcha'];
                    $this->Date[$direction] = $rec['Date'];
                    $this->Time[$direction] = $rec['Time'];
                    $this->PriceChange[$direction] = $rec['PriceChange'];
                    $this->PriceChangeType[$direction] = $rec['PriceChangeType'];


                    $AdtPriceByChange = functions::setPriceChanges($rec['Airline_IATA'], $rec['FlightType'], $rec['AdtPrice'],$rec['AdtFare'],($rec['IsInternalFlight']) ? 'Local' : 'Portal', strtolower($rec['FlightType']) == 'system' ? '' : 'public');
                    $ChdPriceByChange = functions::setPriceChanges($rec['Airline_IATA'], $rec['FlightType'], $rec['ChdPrice'],$rec['ChdFare'],($rec['IsInternalFlight']) ? 'Local' : 'Portal', strtolower($rec['FlightType']) == 'system' ? '' : 'public');
                    $InfPriceByChange = functions::setPriceChanges($rec['Airline_IATA'], $rec['FlightType'], $rec['InfPrice'],$rec['InfFare'],($rec['IsInternalFlight']) ? 'Local' : 'Portal', strtolower($rec['FlightType']) == 'system' ? '' : 'public');


                    $AdtPriceByChangeExploded = explode(':', $AdtPriceByChange);
                    $ChdPriceByChangeExploded = explode(':', $ChdPriceByChange);
                    $InfPriceByChangeExploded = explode(':', $InfPriceByChange);



                    $InfoCurrencyAdult = functions::CurrencyCalculate($AdtPriceByChangeExploded[1],$rec['CurrencyCode']);
                    $InfoCurrencyChild = functions::CurrencyCalculate($ChdPriceByChangeExploded[1],$rec['CurrencyCode']);
                    $InfoCurrencyInfant = functions::CurrencyCalculate($InfPriceByChangeExploded[1],$rec['CurrencyCode']);


                    $this->AdtPrice[$direction] = $InfoCurrencyAdult['AmountCurrency'];
                    $this->ChdPrice[$direction] = $InfoCurrencyChild['AmountCurrency'];
                    $this->InfPrice[$direction] = $InfoCurrencyInfant['AmountCurrency'];
                    $this->AdtPriceType[$direction] = $InfoCurrencyAdult['TypeCurrency'];

                    $InfoCurrencyAdultByChange = functions::CurrencyCalculate($AdtPriceByChangeExploded[0],$rec['CurrencyCode']);
                    $InfoCurrencyChildByChange = functions::CurrencyCalculate($ChdPriceByChangeExploded[0],$rec['CurrencyCode']);

                    $this->AdtPriceByChange[$direction] = $InfoCurrencyAdultByChange['AmountCurrency'];
                    $this->ChdPriceByChange[$direction] = $InfoCurrencyChildByChange['AmountCurrency'];
                    $this->InfPriceByChange[$direction] = $this->InfPrice[$direction];


                    $this->CheckAdtPrice[$direction] = $rec['AdtPrice'] ;
                    $this->CheckChdPrice[$direction] = $rec['ChdPrice'] ;
                    $this->CheckInfPrice[$direction] = $rec['InfPrice'] ;
                    $this->FlightType[$direction] = $rec['FlightType'];
                    $this->Capacity[$direction] = $rec['Capacity'];
                    $this->Description[$direction] = $rec['Description'];
                    $this->Adt_qty = $rec['Adt_qty'];
                    $this->Chd_qty = $rec['Chd_qty'];
                    $this->Inf_qty = $rec['Inf_qty'];
                    $this->token_session[$direction] = $rec['token_session'];
                    $this->SeatClass[$direction] =($rec['SeatClass'] == 'C' || $rec['SeatClass'] == 'B')  ? 'بیزینس' : 'اکونومی';
                    $this->SourceID[$direction] = $rec['SourceID'];
                    $this->Amount += (intval($this->Adt_qty) * ($AdtPriceByChangeExploded[2] == 'YES' ? $this->AdtPriceByChange[$direction] : $this->AdtPrice[$direction])) + (intval($this->Chd_qty) * ($ChdPriceByChangeExploded[2] == 'YES' ? $this->ChdPriceByChange[$direction] : $this->ChdPrice[$direction])) + (intval($this->Inf_qty) * $this->InfPrice[$direction]);
                }
            }


        }


        if ($this->isInternal == '0' || (isset($_POST['type']) && $_POST['type'] == 'package') ||  $_POST['ZoneFlight'] == 'TestParto') {


            if ($direction == 'TwoWay') {
                $this->ArrayDeptForeign[0]['Date'] = $this->dateConvert($this->ArrayDeptForeign[0]['Date']);
                $this->ArrayReturnForeign[0]['Date'] = $this->dateConvert($this->ArrayReturnForeign[0]['Date']);
            } else {
                $this->RoutesTicket['dept'][0]['Date'] = $this->dateConvert($this->RoutesTicket['dept'][0]['Date']);
            }


            switch ($direction){
                case 'TwoWay':
                    $searchDate =  str_replace('/', '-',$this->ArrayDeptForeign[0]['Date'] . '&' . $this->ArrayReturnForeign[0]['Date']) ;
                    $searchDestination = $this->ArrayDeptForeign[0]['OriginAirportIata'] . '-' . $this->RoutesTicket['TwoWay'][(count($this->ArrayDeptForeign)) - 1]['DestiAirportIata'] ;
                    break;
                case 'multi_destination':
                    $searchDate =  str_replace('/', '-',$this->dateConvert($this->RoutesTicket['multi_destination'][0]['Date'])) ;
                    $searchDestination = $this->RoutesTicket['multi_destination'][0]['OriginAirportIata'] . '-' . $this->RoutesTicket['multi_destination'][0]['DestiAirportIata'] ;
                    break;
                default:
                    $searchDate =   str_replace('/', '-',$this->RoutesTicket['dept'][0]['Date']) ;
                    $searchDestination = $this->RoutesTicket['dept'][0]['OriginAirportIata'] . '-' . $this->RoutesTicket['dept'][count($this->RoutesTicket['dept']) - 1]['DestiAirportIata'] ;


            }

        } else {

            if(isset($this->Date['dept']) && !empty($this->Date['dept'])) {

                $this->Date['dept'] = $this->dateConvert($this->Date['dept']);

            }


            if (isset($this->Date['return']) && !empty($this->Date['return'])) {

                $this->Date['return'] = $this->dateConvert($this->Date['return']);
            }

            $searchDate = str_replace('/', '-', $this->Date['dept'] . (!empty($this->Date['return']) ? '&' . $this->Date['return'] : ''));

            $searchDestination = $this->OriginAirportIata['dept'] . '-' . $this->DestiAirportIata['dept'];

        }

        $firstDate = substr($searchDate, 0, 10);
        $this->flightMKTime = (SOFTWARE_LANG !='fa') ? $firstDate : functions::convertJalaliDateToGregInt($firstDate);
        $this->reSearchAddress = ROOT_ADDRESS . '/' . ($this->isInternal == '1' ? 'search-flight' : 'international') . '/' . (!empty($this->Date['return']) ? '2' : '1') . '/' . $searchDestination . '/' . $searchDate . '/Y/' . $this->Adt_qty . '-' . $this->Chd_qty . '-' . $this->Inf_qty;
    }

    /**
     * Get number of interrupt in fly
     * @param $num int not null
     * @return number of interrupt
     * @author Anari
     */
    public function interrupt($num)
    {
        if ($num == '0') {
            return 'بدون توقف';
        } else {
            return ($num) . 'توقف';
        }
    }

    private function dateConvert($date_var)
    {
        if (SOFTWARE_LANG != 'fa')
            return functions::ConvertToMiladi($date_var, '-');
        else return $date_var;
    }
    public function monthsPersian($value) {
        $month = Array();
        $month[1]='فروردین';
        $month[2]='اردیبهشت';
        $month[3]='خرداد';
        $month[4]='تیر';
        $month[5]='مرداد';
        $month[6]='شهریور';
        $month[7]='مهر';
        $month[8]='آبان';
        $month[9]='آذر';
        $month[10]='دی';
        $month[11]='بهمن';
        $month[12]='اسفند';
        return $month;
    }
    public function monthsMiladi() {
        $month = Array();
        $month[1]='January';
        $month[2]='February';
        $month[3]='March';
        $month[4]='April';
        $month[5]='May';
        $month[6]='June';
        $month[7]='July';
        $month[8]='August';
        $month[9]='September';
        $month[10]='October';
        $month[11]='November';
        $month[12]='December';
        return $month;
    }
    public function changeMonthIr($data) {
        $index = self::monthsPersian();
        for ($i = 1; $i < count($index); $i++) {
            if ($i < 10) {
                $i = ltrim($i, '0');
            }
            if ($i ==  $data) {
                $result = $index[$i];
            }
        }
        return $result;
    }
    public function changeMonthNoIr($data) {
        $index = self::monthsMiladi();
        for ($i = 1; $i < count($index); $i++) {
            if ($i < 10) {
                $i = ltrim($i, '0');
            }
            if ($i ==  $data) {
                $result = $index[$i];
            }
        }
        return $result;
    }
    public function removeZeroBeginningNumber($data) {
        if ($data < 10) {
            $data = ltrim($data, '0');
        }
        return $data;
    }
    public function getCustomers()
    {
        $result =  $this->getController('passengers')->getAll($this->customerID);
//        $date_birth_ir = explode('-', $result['birthday_fa'] );
//        $result['date_year_ir'] = $date_birth_ir[0];
//        $result['date_month_ir'] = self::changeMonthIr($date_birth_ir[1]);
//        $result['date_day_ir'] = self::removeZeroBeginningNumber($date_birth_ir[2]);
        $this->passengers= $result;

    }

    public function format_hour($num)
    {

        $time = date("H:i", strtotime($num));

        return $time;
    }

    public function LongTimeFlightHours($param1, $param2)
    {
        $flight_route = new ModelBase();

        $sql = " SELECT   *  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'  ";

        $flight_route = $flight_route->load($sql);

        if (!empty($flight_route['TimeLongFlight'])) {
            $explode_date = explode(':', $flight_route['TimeLongFlight']);

            $jmktime = dateTimeSetting::jmktime($explode_date[0], $explode_date[1], $explode_date[2]);

            $hour_long = dateTimeSetting::jdate("H", $jmktime,'','','en');

            return $hour_long;
        } else {
            return 'نامشخص';
        }
    }

    public function LongTimeFlightMinutes($param1, $param2)
    {
        $flight_route = new ModelBase();

        $sql = " SELECT   *  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'  ";

        $flight_route = $flight_route->load($sql);

        if (!empty($flight_route['TimeLongFlight'])) {
            $explode_date = explode(':', $flight_route['TimeLongFlight']);

            $jmktime = dateTimeSetting::jmktime($explode_date[0], $explode_date[1], $explode_date[2]);

            $Minutes_time = dateTimeSetting::jdate("i", $jmktime,'','','en');

            return $Minutes_time;
        }
    }

    public function format_hour_arrival($param1, $param2, $param3)
    {
        $flight_route = new ModelBase();

        $sql = " SELECT   *  FROM flight_route_tb  WHERE Departure_Code='{$param1}' AND Arrival_Code='{$param2}'  ";

        $flight_route = $flight_route->load($sql);

        if (!empty($flight_route['TimeLongFlight'])) {

            $explode_date = explode(':', $flight_route['TimeLongFlight']);

            $jmktime = dateTimeSetting::jmktime($explode_date[0], $explode_date[1], 0);

            if ($explode_date[0] > 00) {
                $cal1 = $explode_date[0] * 60;
            } else {
                $cal1 = 0;
            }

            if ($explode_date[1] > 00) {
                $cal2 = $explode_date[1];
            } else {
                $cal2 = 0;
            }

            $calTotal = $cal1 + $cal2;
            $time = strtotime($this->format_hour($param3));
            $ArivallTime = date("H:i", strtotime('+' . $calTotal . ' minutes', $time));

            return $ArivallTime;
        }
    }

    public function AirPlaneType($param)
    {

        $air_plan = new ModelBase();

        $sql = " SELECT   name_fa,name_en  FROM airplan_type  WHERE name_en='{$param}'  ";


        $type = $air_plan->load($sql);
        return !empty($type['name_fa']) ? $type['name_fa'] : $param;
    }

    public function AirPlaneTypeData($param)
    {

        $air_plan =Load::library('ModelBase');

         $sql = " SELECT   name_fa,name_en  FROM airplan_type  WHERE name_en='{$param}'  ";
        $type = $air_plan->load($sql);

        return !empty($type['name_fa']) ? $type[functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name','_fa')] : $param;
    }

    public function set_session()
    {

        $_SESSION['PostData'] = md5(uniqid(rand(), true));

        return $_SESSION['PostData'];
    }

    public function SetTimeLimit($PassengerCount)
    {
        $PassengerCount = ($PassengerCount > 8) ? 8 : $PassengerCount;
        //به ازای هر نفر یک دقیقه و 30 ثانیه اضافه می شود
        $time = strtotime('08:00');
        return $new_time = date("H:i", strtotime('+' . (($PassengerCount - 1) * 80) . ' minutes', $time));
    }

    public function SetTimeLimitHotel($PassengerCount)
    {
        $PassengerCount = ($PassengerCount > 8) ? 8 : $PassengerCount;
        //به ازای هر نفر یک دقیقه و 30 ثانیه اضافه می شود
        $time = strtotime('09:00');
        return $new_time = date("H:i", strtotime('+' . (($PassengerCount - 1) * 150) . ' minutes', $time));
    }

    public function type_user($brithday)
    {

        $date_two = date("Y-m-d", strtotime("-2 year"));
        $date_twelve = date("Y-m-d", strtotime("-12 year"));


        if (strcmp($brithday, $date_two) > 0) {
            return "Inf";
        } elseif (strcmp($brithday, $date_two) <= 0 && strcmp($brithday, $date_twelve) > 0) {
            return "Chd";
        } else {
            return "Adt";
        }
    }

    public function DetailRoutes($id)
    {
        Load::autoload('Model');
        $Model = new Model();
        $resultDetailTicket = $Model->select("SELECT * FROM temporary_routes_tb WHERE TemporaryId='{$id}'",'assoc');
        return $resultDetailTicket;
    }

    public function  escapefile_url($url){
        $parts = parse_url($url);
        $path_parts = array_map('rawurldecode', explode('/', $parts['path']));

        return
            $parts['scheme'] . '://' .
            $parts['host'] .
            implode('/', array_map('rawurlencode', $path_parts)) .
            (isset($parts['query']) ? '?'.rawurldecode($parts['query']) : '')
            ;
    }
}

?>
