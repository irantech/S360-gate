<?php

/**
 * Class resultBusTicket
 * @property resultBusTicket $resultBusTicket
 */
class resultBusTicket extends apiBus
{
    public $error=false;
    public $errorMessage;
    public $isLogin;
    public $counterId;
    public $serviceDiscount=[];
    public $accessBus;
    public $accessReservationBus=false;


    public function __construct()
    {
     

        parent::__construct();
        $this->accessBus=parent::accessApiBus();
        $this->accessReservationBus=parent::accessBusReservation();
        $this->isLogin=Session::IsLogin();
        if($this->isLogin){
            $this->counterId=functions::getCounterTypeId($_SESSION['userId']);
        }else{
            $this->counterId='5';
        }
        $this->serviceDiscount['public']=functions::ServiceDiscount($this->counterId, 'PublicBus');
        $this->serviceDiscount['private']=functions::ServiceDiscount($this->counterId, 'PrivateBus');
    }

    public function setPriceChanges($Price) {
        $IsLogin = Session::IsLogin();
        $counterTypeId = ($IsLogin) ? Session::getCounterTypeId() : '5';
        $Discount=functions::ServiceDiscount($counterTypeId,'PublicBus');



        if ($Discount['off_percent'] > 0) {
            $Price = round($Price-(($Price * $Discount['off_percent']) / 100));
        }else{
            $Price = 0;

        }

        return $Price;

    }

    public function generateHtml($array)
    {
        $output = '<div class="items items_buses">';

        foreach ($array as $item) {

                $output .= '<div class="showListSort">
                      <div class="international-available-box early ASS"
                           data-price="' . $item['price'] . '"
                             data-company="' . $item['baseCompany'] . ' ' . $item['companyName'] . '"
                             data-dateMove="' . $item['dateMove'] . '"
                             data-freechairs="' . $item['countFreeChairs'] . '"
                             data-timeMove="' . $item['textTimeMove'] . '"
                             data-time="' . $item['timeMove'] . '"
                             data-special="' . $item['is_special'] . '" >
                           ';

                $output .= '<div class="international-available-item">
                      <div class="international-available-info bus_page">
                      <div class="p-2 international-available-item-right-Cell bus_page my-slideup">';


                $output .= '<div class=" international-available-airlines ">
                  <div class="international-available-airlines-logo roundedLogo">
                      <img src="' . $item['getCompanyBusPhoto'] . '"
                           alt="' . $item['baseCompany'] . '"
                           title="' . $item['baseCompany'] . '"
                           width="50" height="50">
                  </div>
                  <div class="international-available-airlines-log-info">
                      <span class="iranM silence_heading">' . $item['baseCompany'] . '</span>
                  </div>';
                if ($item['carType'] && $item['carType'] != '') {
                    $output.='<div class="d-flex flex-wrap justify-content-center bus-facilities-badge">'.$item['carType'].'</div>';
                }

                $output .= '</div>';

                $output .= '<div class="international-available-airlines-info international-available-bus-info align-content-between">';
                $output .= '  <div class="iranL departure-time"> <h2>' . $item['timeMove'] . '</h2></div>
                              ';

                $output .= '
<div class="box-item-bus">
<div class="airlines-info bus-info_ destination txtLeft">
                      <span class="iranB bold_text">' . $item['TextOriginTerminal'] . '</span>
                  </div>
<div class="airlines-info bus-info_">
                  <div class="col-md-12">
                      <div class="airline-line">';

                $output .= '

                  <div class="plane-icon busicon_zm">
                      <svg xmlns="http://www.w3.org/2000/svg"
                           xmlns:xlink="http://www.w3.org/1999/xlink"
                           version="1.1" id="Capa_1" x="0px" y="0px"
                           viewBox="0 0 350.451 350.451"
                           style="enable-background:new 0 0 350.451 350.451;"
                           xml:space="preserve"><g>
                              <g>
                                  <g>
                                      <path d="M77.695,208.593c-17.985,0-32.562,14.571-32.562,32.559c0,17.988,14.576,32.559,32.562,32.559    c17.992,0,32.564-14.57,32.564-32.559C110.259,223.163,95.687,208.593,77.695,208.593z M77.695,255.306    c-7.818,0-14.153-6.334-14.153-14.154c0-7.822,6.335-14.154,14.153-14.154c7.819,0,14.159,6.332,14.159,14.154    C91.854,248.972,85.514,255.306,77.695,255.306z"
                                            data-original="#000000"
                                            class="active-path"
                                            data-old_color="#000000"
                                            fill="#C4C4C4"></path>
                                      <path d="M268.854,208.593c-17.986,0-32.561,14.571-32.561,32.559c0,17.988,14.574,32.559,32.561,32.559    c17.992,0,32.564-14.57,32.564-32.559S286.846,208.593,268.854,208.593z M268.854,255.306c-7.818,0-14.154-6.334-14.154-14.154    c0-7.822,6.336-14.154,14.154-14.154c7.82,0,14.16,6.332,14.16,14.154C283.014,248.972,276.674,255.306,268.854,255.306z"
                                            data-original="#000000"
                                            class="active-path"
                                            data-old_color="#000000"
                                            fill="#C4C4C4"></path>
                                      <path d="M330.998,76.741H38.915c-10.701,0-21.207,8.579-23.348,19.064L3.892,138.423C1.751,148.908,0,166.242,0,176.944v44.751    c0,10.7,8.756,19.456,19.457,19.456h19.839c0-21.17,17.226-38.395,38.398-38.395c21.174,0,38.401,17.223,38.401,38.395h114.358    c0-21.17,17.227-38.395,38.398-38.395c21.176,0,38.402,17.223,38.402,38.395h23.74c10.703,0,19.457-8.754,19.457-19.456V96.197    C350.455,85.496,341.699,76.741,330.998,76.741z M80.856,158.836H35.512l7.186-17.019c1.254-2.97-0.137-6.394-3.106-7.648    c-2.972-1.254-6.395,0.138-7.647,3.107l-8.91,21.103c-6.015-1.581-9.676-7.214-8.437-13.89l10.46-41.74    c1.465-7.891,9.23-14.348,17.256-14.348h38.543L80.856,158.836L80.856,158.836z M167.439,158.836H92.53V88.401h74.909V158.836z     M254.021,158.836h-74.908V88.401h74.908V158.836z M338.523,144.244c0,8.026-6.566,14.593-14.594,14.593h-58.234V88.402h58.234    c8.027,0,14.594,6.567,14.594,14.593V144.244z"
                                            data-original="#000000"
                                            class="active-path"
                                            data-old_color="#000000"
                                            fill="#C4C4C4"></path>
                                  </g>
                              </g>
                          </g>
                  </svg>
                  </div>';
                $output .= '<div class="loc-icon-destination">
                                                                            <svg version="1.1" class=""
                                                                                 id="Layer_1"
                                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                 x="0px"
                                                                                 y="0px" width="32px" viewBox="0 0 512 512"
                                                                                 style="enable-background:new 0 0 512 512;"
                                                                                 xml:space="preserve">
                                                                            <g>
                                                                                <g>
                                                                                    <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
                                                                                        c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
                                                                                        c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                                                                </g>
                                                                            </g>
                                                                        </svg>
                                                                        </div>';
                $output .= '</div>

                                                                </div>
                                                            </div>';

                $output .= ' <div class="airlines-info bus-info_ destination txtRight namecity_zm">
                              <span class="iranB bold_text">' . $item['TextDestinationTerminal'] . '</span>
                          </div>';


                /* if ($item['description'] && $item['description'] != '') {
                     $output.='<div class="d-flex flex-wrap font-12 justify-content-center text-muted w-100">'.$item['description'].'</div>';
                 }*/
                $output .= '</div>';
                $output .= '</div>';

                $output .= '<div class="col-md-12 p-0 esterdad-blit text-right">
                 <span class="iranL col-md-12 silence_text silence_div3 d-flex text-dark capacity-parent">
                     <span class="capacity-col" style="color: #f7f7f7;right: 90px;color: rgba(0,0,0,0);background: none;">S.' . $item['sourceCode'] . '</span>
                 </span>
             </div>';


                $output .= '</div>';


                $output .= '<div class="inner-avlbl-itm international-available-item-left-Cell my-slideup pr-3">
                                                    <div class="inner-avlbl-itm">';

                $output .= '<span class="iranL priceSortAdt1">';

                if ($item['setPriceChanges'] > 0) {

                    $output .= '<div class="decent">

                    <i class="iranM site-main-text-color-drck discount"  style="text-decoration: line-through" data-amount="' . $item['mainCurrency']['AmountCurrency'] . '">
                      ' . Functions::numberFormat($item['mainCurrency']['AmountCurrency']) . '
                    </i>
                      <span class="CurrencyText">' . $item['mainCurrency']['TypeCurrency'] . '</span>

                 </div>

                   <div class="decent">
                       <i class="iranM site-main-text-color-drck CurrencyCal " 
                       data-amount="' . $item['setPriceChanges'] . '">
                       ' . Functions::numberFormat($item['setPriceChanges']) . '</i>';
                } else {
                    $output .= '<i class="iranM site-main-text-color-drck CurrencyCal "
                    data-amount="' . $item['price'] . '">
                    ' . Functions::numberFormat($item['mainCurrency']['AmountCurrency']) . '
                  </i>';

                }
                $output .= '<span class="CurrencyText">' . $item['mainCurrency']['TypeCurrency'] . '</span>
                                                        </div>
                                                        </span>';
                $output .= '<div class="SelectTicket"> 
                          <a class="init-loading international-available-btn site-bg-main-color ';

                if ($item['countFreeChairs'] > 0) {
                    $output .=' site-main-button-color-hover ';
                }else{
                    $output .=' btn-cancle ';

                }
                $output .='"';

                if ($item['countFreeChairs'] > 0) {


                    $output .= ' onclick="reserveBusTicket(\'' . $item['busCode'] . '\', \'' . $item['sourceCode'] . '\',true,$(this))"';

                }
                $output .= '>';

                if ($item['countFreeChairs'] > 0) {

                    $output .= functions::Xmlinformation('Ticketselect');
                } else {
                    $output .= functions::Xmlinformation('CompletionCapacity');
                }
                $output .= '</a>
                          </div>';

                $output .= '
                                 <span class="iranL  silence_text silence_div3 d-flex text-dark capacity-parent">
                     <span class="capacity-col mt-1">  <span class="number-remaining-seats">' . $item['countFreeChairs'] . '</span><span class="remaining-seats">صندلی باقی مانده</span></span>
          
   
                 </span>
                ';

                $output .='</div>
                  </div>';


                $output .= '<div class="ticketSubDetail international-available-details">
                 <div>
                     <div class="international-available-panel-min">';

                $output .= '<div id="tab-1-0" class="tab-content current">
                  <div class="international-available-airlines-detail-tittle">
                  
                  
                  
                  
                  
                      <div class="Container">
                          <ul class="justifyCenter Container-progessbar">
                              <li class="active">' . $item['origin']['cityName'] . '</li>';

                if (isset($item['droppingPoints']) && count($item['droppingPoints']) > 1) {
                    foreach ($item['droppingPoints'] as $droppingPoint) {


                        if ($droppingPoint != $item['destination']['cityName']) {

                            $output .= '<li class="">' . $droppingPoint . '</li>';
                        }
                    }
                }


                $output .= '<li class="active">' . $item['destination']['cityName'] . '</li>';


                $output .= '</ul>
                          </div>
                      </div>
                  </div>';

                $output.='
               <div data-name="bus-extra-descriptions-loading" class="align-items-center d-flex flex-wrap gap-10 justify-content-center w-100">
                  
               </div>
                <div data-name="bus-extra-descriptions" class=" w-100">
                    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                           '.functions::Xmlinformation('ConsoleFines').'
                    </span>
                    <div class="panel-default-change-Buyer-parent row">
                        <div data-name="bus-refund-rules" class="desctiptionBus right w-100">
                              <div class="alert-bus">
                                 <h6>10% جریمه</h6>
                                 <p>از زمان صدور تا 1 ساعت قبل از حرکت</p>
                           </div>
                                 <div class="alert-bus">
                                    <h6>50% جریمه حضوری</h6>
                                    <p>از 1 ساعت قبل از حرکت تا پس از آن</p>
                                 </div>
                        </div>
                    </div>
                </div>';

                $output .= '</div>
                  </div>';


                $output .= '<span class="international-available-detail-btn slideDownHotelDescription">';

                if (Session::IsLogin()) {

                $counterId = functions::getCounterTypeId($_SESSION['userId']);
                $baseCompany = (isset($item['baseCompany']) && $item['baseCompany'] != '') ? $item['baseCompany'] : $item['companyName'];
                $resultBaseCompany = functions::getIdBaseCompanyBus($baseCompany);
                $paramPointClub = [];
                $paramPointClub['service'] = ($item['webServiceType'] == 'public') ? 'PublicBus' : 'PrivateBus';
                $paramPointClub['baseCompany'] = $resultBaseCompany['id'];
                $paramPointClub['company'] = $item['companyName'];
                $paramPointClub['counterId'] = $counterId;
                $paramPointClub['price'] = $item['price'];
                $pointClub = functions::CalculatePoint($paramPointClub);
                if ($pointClub > 0) {

                    $output .= '<div class="text_div_morei site-main-text-color iranM txt12">
                  ' . functions::Xmlinformation('Yourpurchasepoints') . ' : ' . $pointClub . ' ' . functions::Xmlinformation('Point') .
                        '</div>';
                }
            }
                $output .= '<div onclick="showDescriptionDetail(this, \'' . $item['busCode'] . '\', \'' . $item['sourceCode'] . '\')" class="my-more-info">' . Functions::Xmlinformation('detailAndCacellation') . '
                      <i class="fa fa-angle-down"></i>
                  </div>';

            $output .= ' </span>
                               <span class="international-available-detail-btn  slideUpHotelDescription displayiN">
                                   <i class="fa fa-angle-up site-main-text-color"></i>
                               </span>
                           </div>

                               </div>

                               <div class="clear"></div>
                           </div>
                       </div>
                    ';
        }


        $output.='</div>';


        return $output;

    }

    public function getBuses($param)
    {

        $check_free_chair_all_buses = true ;
        if(!$param['cityOrigin'] && !$param['cityDestination'] && !$param['dateMove']){
            ob_start();
            ?>
            <div class="userProfileInfo-messge ">
                <div class="messge-login BoxErrorSearch">
                    <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                    </div>
                    <div class="TextBoxErrorSearch">
                        <?php echo functions::Xmlinformation('Noresult'); ?>
                        <br/>
                        <?php echo functions::Xmlinformation('Changeserach'); ?>
                    </div>
                </div>
            </div>
            <?php
            $resultBuses=ob_get_clean();
        }else{
            ob_start();
            $getDateJalali=$this->getDateJalali($param['dateMove']);
//            $route=$this->getRoute($param['cityOrigin'], $param['cityDestination']);

            $final_html_data='';
            $originCity=functions::getRoute($param['cityOrigin']);
            $cityDestination=functions::getRoute($param['cityDestination']);


            $originCityName=$originCity['name_fa'];
            $destinationsCityName=$cityDestination['name_fa'];



            $resultInfoSourcesApi=$this->accessBus;

            if(SOFTWARE_LANG=='en' || SOFTWARE_LANG=='ar' || substr($param['dateMove'], "0", "4") > 2000){
                $param['dateMove']=functions::ConvertToJalali($param['dateMove']);
            }

            $dateNow=dateTimeSetting::jdate("Ymd", '', '', '', 'en');
            $dateMove=str_replace("-", "", $param['dateMove']);
            $dateMove=str_replace("/", "", $dateMove);
            $data['userName']=USERNAME_CLIENT;
            $data['date']=$param['dateMove'];
            $data['route']=[
                [
                    "originCityId"=>$originCity['code'],
                    "destinationCityId"=>$cityDestination['code']
                ]
            ];
            $jsonData=json_encode($data);


            $bus_reservation_result=[];

           
            if($this->accessBusReservation){
                if(trim($dateMove) >= trim($dateNow)){
                  $reservation_data=$this->getController('busPanel')->getBusReservationData($param);

                  foreach ($reservation_data as $key=>$item){
                    $bus_reservation_result[$key]=$item;
                    $bus_reservation_result[$key]['source_name']='reservation_bus';

                  }
                }
            }


            if($resultInfoSourcesApi || $bus_reservation_result){
              if($resultInfoSourcesApi){
                  
                $busSearchApiData=$resultBuses=parent::busSearch($jsonData);

                }
             
                if(trim($dateMove) >= trim($dateNow)){
                    if($this->checkApiSuccessfulStatus($resultBuses) && $resultInfoSourcesApi) {
                        $countBuses = count($resultBuses['response']['data']);
                        $arrayPrice = [];
                        $arrayCompanyBusTB = [];
                        foreach (functions::getAllCompanyBus() as $company) {
                            $arrayCompanyBusTB[trim($company['name_fa'])] = $company['id'];
                        }
                    }

 
                            $html_data = [
                                'api' => [],
                                'reservation' => [],
                            ];

                            if ($this->checkApiSuccessfulStatus($resultBuses)  && $resultInfoSourcesApi) {
                                $sort = array();
                                $freeBus = array();
                                $notFreeBus = array();
                                foreach ($resultBuses['response']['data'] as $keySort => $arraySort) {
                                    if ($arraySort['countFreeChairs'] > 0) {
                                        $sort['countFreeChairs'][$keySort] = $arraySort['countFreeChairs'];
                                        $sort['price'][$keySort] = $arraySort['price'];
                                        $notFreeBus[] = $arraySort;
                                    }else{
                                        $freeBus[] = $arraySort ;
                                    }

                                }
                                if (!empty($sort)) {
                                    @array_multisort($sort['countFreeChairs'], SORT_DESC, $sort['price'], SORT_ASC, $resultBuses['response']['data']);
                                }

                                usort($notFreeBus, function ($a, $b) {
                                    return strtotime($a['timeMove']) - strtotime($b['timeMove']);
                                });

                                $resultBuses['response']['data'] = array_merge($notFreeBus , $freeBus);
                                foreach ($resultBuses['response']['data'] as $numberBus => $bus) {

                                    if ($bus['sourceCode'] === '15') {
                                        $sourceName = 'alterabo';
                                    } else if ($bus['sourceCode'] === '10') {
                                        $sourceName = 'safar724';
                                    } else {
                                        $sourceName = 'Payaneha';
                                    }


                                    $price = (round($bus['beforeDiscountPrice']));
                                    $arrayParamPriceChanges = [];
                                    $arrayParamPriceChanges['originCity'] = $param['cityOrigin'];
                                    $arrayParamPriceChanges['destinationCity'] = $param['cityDestination'];
                                    $arrayParamPriceChanges['companyId'] = isset($arrayCompanyBusTB[trim($bus['baseCompany'])]) ? $arrayCompanyBusTB[trim($bus['baseCompany'])] : 0;
                                    $arrayParamPriceChanges['counterId'] = $this->counterId;
                                    $arrayParamPriceChanges['date'] = $param['dateMove'];
                                    $arrayParamPriceChanges['price'] = $price;
                                    $resBusTicketPriceChanges = functions::getBusTicketPriceChanges($arrayParamPriceChanges);
                                    if ($resBusTicketPriceChanges != false) {
                                        $price = round($resBusTicketPriceChanges['price']);
                                    }


                                    //$priceWithoutDiscount = 0;
                                    /*if(!empty($this->serviceDiscount[$reservation_bus['webServiceType']]) && $this->serviceDiscount[$reservation_bus['webServiceType']]['off_percent'] > 0){
                                        //$priceWithoutDiscount = $price;
                                        $price=round($price-(($price*$this->serviceDiscount[$reservation_bus['webServiceType']]['off_percent'])/100));
                                    }*/

                                    if ($price > 0) {
                                        $arrayPrice[] = ($price);
                                    }

                                    $CurrencyCalculate = Functions::CurrencyCalculate($price);
                                    if($bus['countFreeChairs'] > 0) {
                                        $check_free_chair_all_buses = false;
                                    }
                                    $html_data['api'][] = [
                                        'is_special' => 0,
                                        'sourceName' => $sourceName,
                                        'sourceCode' => $bus['sourceCode'],
                                        'price' => $price,
                                        'baseCompany' => $bus['baseCompany'],
                                        'getCompanyBusPhoto' => Functions::getCompanyBusPhoto($bus['baseCompany']),
                                        'dateMove' => $bus['dateMove'],
                                        'countFreeChairs' => $bus['countFreeChairs'],
                                        'textTimeMove' => functions::classTimeLOCAL($bus['timeMove'],false),
                                        'timeMove' => $bus['timeMove'],
                                        'busCode' => $bus['busCode'],
                                        'carType' => $bus['carType'],
                                        'origin' => $bus['origin'],
                                        'webServiceType' => $bus['webServiceType'],
                                        'description' => $bus['description'],
                                        'destination' => $bus['destination'],
                                        'cancellationTime' => $bus['cancellationTime'],
                                        'mainCurrency' => $CurrencyCalculate,
                                        'setPriceChanges' => $this->setPriceChanges($CurrencyCalculate['AmountCurrency']),
                                        'TextOriginTerminal' => ($bus['originTerminal'] != '') ? $bus['originTerminal'] : $bus['originCity'],
                                        'TextDestinationTerminal' => ($bus['destinationTerminal'] != '') ? $bus['destinationTerminal'] : $bus['destinationCity'],
                                    ];


                                }

                                }

                            if ($bus_reservation_result) {


                                foreach ($bus_reservation_result as $reservation_bus) {



                                    $price = $reservation_bus['price'];
                                    if ($reservation_bus['price'] > 0) {
                                        $arrayPrice[] = ($price);
                                    }

                                    $CurrencyCalculate = Functions::CurrencyCalculate($price);

                                    $html_data['reservation'][] = [
                                        'is_special' => 1,
                                        'sourceName' => 'reservation_bus',
                                        'sourceCode' => 'reservation_bus',
                                        'price' => $price,
                                        'baseCompany' => $reservation_bus['company']['name_fa'],
                                        'getCompanyBusPhoto' => $reservation_bus['company']['logo'],
                                        'dateMove' => $reservation_bus['move_date'],
                                        'countFreeChairs' => $reservation_bus['left_chairs_count'],
                                        'textTimeMove' => functions::classTimeLOCAL($reservation_bus['move_time'],false),
                                        'timeMove' => $reservation_bus['move_time'],
                                        'busCode' => $reservation_bus['id'],
                                        'carType' => $reservation_bus['vehicle_name'],
                                        'origin' => [
                                            'cityName' => $reservation_bus['origin']['name_fa']
                                        ],
                                        'webServiceType' => $reservation_bus['webServiceType'],
                                        'destination' => [
                                            'cityName' => $reservation_bus['destination']['name_fa']
                                        ],
                                        'description' => $reservation_bus['description'],
                                        'cancellationTime' => '',
                                        'mainCurrency' => $CurrencyCalculate,
                                        'setPriceChanges' => $this->setPriceChanges($CurrencyCalculate['AmountCurrency']),
                                        'TextOriginTerminal' => $reservation_bus['origin_station_name'],
                                        'TextDestinationTerminal' => $reservation_bus['destination_station_name'],
                                        'droppingPoints' => json_decode($reservation_bus['dropping_points'], true),
                                    ];

                                }


                            }

                            if(count($html_data['reservation']) > 0 || count($html_data['api'])> 0 ){

                            echo $this->generateHtml(array_merge($html_data['reservation'],$html_data['api']));
                            }else{
                                ?>
                                <div class="w-100 d-flex flex-wrap d-none">
<!---->
<!--                                        <div class="col-lg-12 p-0">-->
<!--                                            <div class="alert alert-danger" role="alert">-->
<!--                                                <div class="row vertical-align d-flex gap-10">-->
<!--                                                    <div class="col-xs-1 text-center">-->
<!--                                                        <i class="fa fa-exclamation-triangle fa-2x"></i>-->
<!--                                                    </div>-->
<!--                                                    <div class="col-xs-11">-->
<!--                                                        --><?php
//                                                            echo functions::Xmlinformation('Noresult');
//                                                        ?>
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->

                                </div>


                                <?php
                            }
                    $resultBuses=ob_get_clean();

                            $minPrice = min($arrayPrice);
                            $maxPrice = max($arrayPrice);


                            ?>



                        <script>
                            $(".filter-price-text span:nth-child(1) i").html('<?php echo number_format($maxPrice); ?>');
                            $(".filter-price-text span:nth-child(2) i").html('<?php echo number_format($minPrice); ?>');

                            let minPriceBus =$('#minPriceBus i').text() ;
                            let maxPriceBus = $('#maxPriceBus i').text() ;

                            if(minPriceBus == maxPriceBus){
                                $('#priceBoxBus').hide()
                            }


                            $("#slider-range").slider({
                                range: true,
                                min: <?php echo $minPrice; ?>,
                                max: <?php echo $maxPrice; ?>,
                                step: 1000,
                                animate: false,
                                values: [<?php echo $minPrice; ?>, <?php echo $maxPrice; ?>],
                                slide: function (event, ui) {

                                    let minRange = ui.values[0];
                                    let maxRange = ui.values[1];

                                    $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));
                                    $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));

                                    let busList = $(".showListSort");
                                    busList.hide().filter(function () {
                                        let price = parseInt($(this).children('div').data("price"), 10);
                                        return price >= minRange && price <= maxRange;
                                    }).show();
                                }
                            });
                        </script>

                        <?php




                        // filter time move



                        ?>
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowAllTimeMove" id="foodTypeAll"
                                   name="foodType" value="all" checked>
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="foodTypeAll"><?php echo Functions::Xmlinformation('All') ?></label>
                        </p>
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersTimeMove"
                                   id="timeMove_1" name="timeMove_1" value="early">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="timeMove_1"><?php echo Functions::Xmlinformation('Morning') ?>
                                <i>0-8</i></label>
                        </p>
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersTimeMove"
                                   id="timeMove_2" name="timeMove_2" value="morning">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="timeMove_2"><?php echo Functions::Xmlinformation('Timemorning') ?>
                                <i>8-12</i></label>
                        </p>
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersTimeMove"
                                   id="timeMove_3" name="timeMove_3" value="afternoon">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="timeMove_3"><?php echo Functions::Xmlinformation('Timeevening') ?> <i>12-18</i></label>
                        </p>
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowByFiltersTimeMove"
                                   id="timeMove_4" name="timeMove_4" value="night">
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="timeMove_4"><?php echo Functions::Xmlinformation('Timenight') ?>
                                <i>18-24</i></label>
                        </p>


                        <script>
                            // time move
                            $(".ShowByFiltersTimeMove").on("click", function () {
                                $('.ShowAllTimeMove').prop('checked', true);
                                let busList = $(".showListSort");
                                let isCheck = 0;
                                busList.hide();
                                $("input:checkbox.ShowByFiltersTimeMove").each(function () {
                                    let check = $(this).prop('checked');
                                    let time = $(this).val();
                                    if (check == true) {
                                        isCheck++;
                                        $('.ShowAllTimeMove').prop('checked', false);
                                        busList.filter(function () {
                                            let timeMove = $(this).children('div').data("timemove");
                                            if (timeMove == time) {
                                                return true;
                                            }
                                        }).show();
                                    }
                                });

                                setTimeout(function () {
                                    if (isCheck == 0) {
                                        busList.show();
                                    }
                                }, 30);

                                $('html, body').animate({
                                    scrollTop: $('.showListSort').offset().top
                                }, 'slow');
                            });

                            $(".ShowAllTimeMove").on("click", function () {
                                let busList = $(".showListSort");
                                busList.show();
                                let check = $(this).prop('checked');
                                if (check == true) {
                                    $("input:checkbox.ShowByFiltersTimeMove").each(function () {
                                        $(this).prop("checked", false);
                                    });
                                } else {
                                    $(".ShowAllTimeMove").prop("checked", true);
                                }
                                $('html, body').animate({
                                    scrollTop: $('.showListSort').offset().top
                                }, 'slow');
                            });
                            // end time move
                        </script>
                        <?php

                        $filterTimeMove=ob_get_clean();


                        // filter company

                        ?>
                        <p class="raste-item">
                            <input type="checkbox" class="FilterHoteltype ShowAllCompanyName"
                                   id="check_list_all" name="check_list_all" value="all" checked>
                            <label class="FilterHoteltypeName site-main-text-color-a"
                                   for="check_list_all"><?php echo Functions::Xmlinformation('All') ?></label>
                        </p>
                        <?php
                        foreach($arrayCompanyName as $k=>$company){
                            ?>
                            <p class="raste-item">
                                <input type="checkbox" class="FilterHoteltype ShowByCompanyName"
                                       id="check_list_<?php echo $k; ?>" name="check_list_<?php echo $k; ?>"
                                       value="<?php echo $company; ?>">
                                <label class="FilterHoteltypeName site-main-text-color-a"
                                       for="check_list_<?php echo $k; ?>"><?php echo $company; ?></label>
                            </p>
                            <?php
                        }
                        ?>
                        <script>
                            // company
                            $(".ShowByCompanyName").on("click", function () {
                                $('.ShowAllCompanyName').prop('checked', true);
                                let busList = $(".showListSort");
                                let isCheck = 0;
                                busList.hide();
                                $("input:checkbox.ShowByCompanyName").each(function () {
                                    let check = $(this).prop('checked');
                                    let val = $(this).val();
                                    if (check == true) {
                                        isCheck++;
                                        $('.ShowAllCompanyName').prop('checked', false);
                                        busList.filter(function () {
                                            let company = $(this).children('div').data("company");
                                            let search = company.indexOf(val);
                                            if (search > -1) {
                                                return true;
                                            }
                                        }).show();
                                    }
                                });

                                setTimeout(function () {
                                    if (isCheck == 0) {
                                        busList.show();
                                    }
                                }, 30);

                                $('html, body').animate({
                                    scrollTop: $('.showListSort').offset().top + 100
                                }, 'slow');

                            });

                            $(".ShowAllCompanyName").on("click", function () {
                                let busList = $(".showListSort");
                                busList.show();
                                let check = $(this).prop('checked');
                                if (check == true) {
                                    $("input:checkbox.ShowByCompanyName").each(function () {
                                        $(this).prop("checked", false);
                                    });
                                } else {
                                    $(".ShowAllCompanyName").prop("checked", true);
                                }
                                $('html, body').animate({
                                    scrollTop: $('.showListSort').offset().top
                                }, 'slow');
                            });
                            // end company
                        </script>
                        <?php
                        $filterCompanyName=ob_get_clean();





                }else{
                    ob_start();
                    ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 p-0">
                                <div class="alert alert-danger" role="alert">
                                    <div class="row vertical-align">
                                        <div class="col-xs-1 text-center">
                                            <i class="fa fa-exclamation-triangle fa-2x"></i>
                                        </div>
                                        <div class="col-xs-11">
                                            <?php
                                            if(!empty($busSearchApiData['response']['Error']['Persian'])){

                                                if(SOFTWARE_LANG==='fa'){
                                                    echo $busSearchApiData['response']['Error']['Persian'];
                                                }else{
                                                    echo $busSearchApiData['response']['Error']['English'];
                                                }
                                            }else{
                                                echo functions::Xmlinformation('Noresult');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $resultBuses=ob_get_clean();
                }


            }
            else{
                ob_start();
                ?>
                <div class="userProfileInfo-messge ">
                    <div class="messge-login BoxErrorSearch">
                        <div style="float: right;"><i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                        </div>
                        <div class="TextBoxErrorSearch">
                            <?php echo functions::Xmlinformation('Noaccesstihspage'); ?>
                            <br/>
                            <?php echo functions::Xmlinformation('Changeserach'); ?>
                        </div>
                    </div>
                </div>
                <?php
                $resultBuses=ob_get_clean();
            }

        }

        $not_available_bus = false;
        if($check_free_chair_all_buses || (isset($countBuses)) && $countBuses == 0) {
          $not_available_bus = true;
        }


        $return=[
            'requestNumber'=>$busSearchApiData['response']['requestNumber'],
            'resultBuses'=>$resultBuses,
            'originCityName'=>(isset($originCityName)) ? $originCityName : '',
            'destinationsCityName'=>(isset($destinationsCityName)) ? $destinationsCityName : '',
            'date'=>$getDateJalali,
            'notAvailableBus'=> $not_available_bus,
            'countBuses'=>(isset($countBuses)) ? $countBuses : 0,
            'filterTimeMove'=>(isset($filterTimeMove)) ? $filterTimeMove : '',
            'filterCompanyName'=>(isset($filterCompanyName)) ? $filterCompanyName : ''
        ];
        return json_encode($return);

    }

    #region DateJalali
    public function getDateJalali($date)
    {
        $explode_date=explode('-', $date);
        if($explode_date[0] > 1450){
            $jmktime=mktime('0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0]);
        }else{
            $jmktime=dateTimeSetting::jmktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
        }

        return [
            'dataString'=>dateTimeSetting::jdate(" j F Y", $jmktime),
            'dateJalali'=>dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en'),
            'dayName'=>dateTimeSetting::jdate("l", $jmktime)
        ];
    }
    #endregion


    #region getDestinationCities
    public function getDestinationCities($departureCityIataCode)
    {
        $ModelBase=Load::library('ModelBase');
        $sql="
        SELECT DISTINCT
            Arrival_City AS DestinationsCityNamePersian,
            Arrival_City_En AS DestinationsCityName,
            Arrival_City_IataCode AS DestinationsIataCode 
        FROM
            bus_route_tb 
        WHERE
            Departure_City_IataCode = '{$departureCityIataCode}' 
        ORDER BY
            priorityArrival = 0,
            priorityArrival
        ";
        $result=$ModelBase->select($sql);

        return $result;
    }
    #endregion

    #region [getDetailBusTicket]
    public function getDetailBusTicket(array $param)
    {


        $factorNumber=trim($param['factorNumber']);
        $objModel=Load::library('Model');
        $sql=" SELECT * FROM temporary_bus_tb WHERE factor_number = '{$factorNumber}' ";
        $busDetail=$objModel->Load($sql, 'assoc');

        if(!empty($busDetail)){
            $objResult=Load::controller('resultBusTicket');
            $price=round($busDetail['beforeDiscountPrice']);
//            $beforeDiscountPrice=round($busDetail['beforeDiscountPrice'],-4);

            $company=functions::getIdBaseCompanyBus($busDetail['base_company']);

            $arrayParamPriceChanges['originCity']=$busDetail['origin_city_iata'];
            $arrayParamPriceChanges['destinationCity']=$busDetail['destination_city_iata'];
            $arrayParamPriceChanges['companyId']=(isset($company['id']) && $company['id']!='') ? $company['id'] : 0;
            $arrayParamPriceChanges['counterId']=$this->counterId;
            $arrayParamPriceChanges['date']=$busDetail['date_move'];
            $arrayParamPriceChanges['price']=$price;
//            $arrayParamPriceChanges['beforeDiscountPrice']=$beforeDiscountPrice;
            $resBusTicketPriceChanges=functions::getBusTicketPriceChanges($arrayParamPriceChanges);
            if($resBusTicketPriceChanges!=false){
                $price=($resBusTicketPriceChanges['price']);
            }

            $priceWithoutDiscount=0;

            if(!empty($this->serviceDiscount[$busDetail['web_service_type']]) && $this->serviceDiscount[$busDetail['web_service_type']]['off_percent'] > 0){
                $priceWithoutDiscount=$price;
                $price=($price-(($price*$this->serviceDiscount[$busDetail['web_service_type']]['off_percent'])/100));
            }



            $result=[
                'detailBus'=>$busDetail,
                'priceWithoutDiscount'=>($priceWithoutDiscount),
                'price'=>($price),
                'seates'=>json_decode($busDetail['seates'], true),
                'refundRules'=>json_decode($busDetail['refundRules'], true),
//                'seates'=>json_decode($this->generateBusSeats(25),ture),
                'date'=>$objResult->getDateJalali($busDetail['date_move'])
            ];
            return $result;
        }else{
            $this->error=true;
            $this->errorMessage=$busDetail['ErrorDetail']['MessagePersian'];
            return false;
        }
    }
    #endregion

    #region setTemporaryBus
    public function createTemporaryBus($params)
    {

        $temporary_bus_model = $this->getModel('temporaryBusModel');

        $data=[
          'factor_number'=>$params['factor_number'],
          'requestNumber'=>$params['requestNumber'],
          'origin_city_iata'=>$params['origin_city_iata'],
          'destination_city_iata'=>$params['destination_city_iata'],
          'source_code'=>$params['source_code'],
          'source_name'=>$params['source_name'],
          'web_service_type'=>$params['web_service_type'],
          'bus_code'=>$params['bus_code'],
          'available_payment_methods'=>$params['available_payment_methods'],
          'date_move'=>$params['date_move'],
          'time_move'=>$params['time_move'],
          'origin_city'=>$params['origin_city'],
          'origin_name'=>$params['origin_name'],
          'origin_terminal'=>$params['origin_terminal'],
          'destination_city'=>$params['destination_city'],
          'destination_name'=>$params['destination_name'],
          'destination_terminal'=>$params['destination_terminal'],
          'car_type'=>$params['car_type'],
          'count_free_chairs'=>$params['count_free_chairs'],
          'price'=>$params['price'],
          'beforeDiscountPrice'=>$params['beforeDiscountPrice'],
          'company'=>$params['company'],
          'base_company'=>$params['base_company'],
          'description'=>$params['description'],
          'refundRules'=>json_encode($params['refundRules'],true),
          'seates'=>$params['seates']
        ];


        $resultInsert=$temporary_bus_model->insertWithBind($data);
        if($resultInsert){
            return true;
        }
        return false;
    }

    public function generateBusSeats($number,$used_chairs)
    {

      $is_minibus=false;
      $minibus_seats_number=0;
      if($number >= 13 && $number <= 16){
        $minibus_seats_number=$number;
        $number=60;
        $is_minibus=true;
      }

        $all_chairs=[];
        foreach ($used_chairs as $chair){
            $all_chairs[]=$chair['passenger_chairs'];
        }

        $rows = 1;
        $column = 1;
        $counter = 0;
        $seat_data = [];
        for ($key = 0; $key <= $number - 1; $key++) {

            if (($key+1) == 13 && $number != 44 && $number != 60) {
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 1,
                    'status' => 'Disable',
                ];
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 2,
                    'status' => 'Disable',
                ];
                $rows++;
                $column = 5;
            }
            elseif (($key+1) == 14 && ($number == 26 || $number == 29|| $number == 30)) {

                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 1,
                    'status' => 'Disable',
                ];
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 2,
                    'status' => 'Disable',
                ];
                $rows++;
                $column = 5;
            }
            elseif (($key+1) == 15 && $number == 30) {


                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 1,
                    'status' => 'Disable',
                ];
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 2,
                    'status' => 'Disable',
                ];
                $rows++;
                $column = 5;
            }
            elseif (($key+1) == 21 && ($number == 44 || $number == 60)) {
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 1,
                    'status' => 'Disable',
                ];
                $rows++;
                $column = 4;
            }
            elseif (($key+1) == 22 && ($number == 44 || $number == 60)) {
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 2,
                    'status' => 'Disable',
                ];
                $column = 5;
            }
            elseif (($key+1) == 23 && ($number == 44 || $number == 60)) {
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 1,
                    'status' => 'Disable',
                ];

                $rows++;
                $column = 4;
            }
            elseif (($key+1) == 24 && ($number == 44 || $number == 60)) {
                $seat_data[] = [
                    'chairNumber' => '',
                    'row' => $rows,
                    'column' => 2,
                    'status' => 'Disable',
                ];
                $column = 5;
            }
            else {
                if ($number != 44 && $number != 60 && $counter !== 0 && $counter % 3 == 0) {
                    $rows++;
                    $column = 1;
                }elseif(($number == 44 || $number == 60) && $counter !== 0 && $counter % 4 == 0){
                    $rows++;
                    $column = 1;
                }

                $counter++;
            }




            $status='Available';
            if($is_minibus && $key + 1 > $minibus_seats_number){
              $status='Disable';
            }



            if(in_array($key + 1,$all_chairs)){
                $status=$used_chairs[$key + 1]['passenger_gender'] == 'Male'? 'BookedForMale':'BookedForFemale';
            }

            $seat_data[] = [
                'chairNumber' => $key + 1,
                'row' => $rows,
                'column' => $column,
                'status' => $status,
            ];
            if ($column == 2 & $number != 44 & $number != 60) {
                $column += 3;
            }elseif($column == 2 & ($number == 44 || $number == 60)){
                $column += 2;
            } else {
                $column++;
                if (($key+1) == 13 && $number != 44 && $number != 60) {
                    $column = 1;
                }
                elseif (($key+1) == 14 && ($number == 26 || $number == 29|| $number == 30)) {
                    $column = 1;
                }
                elseif (($key+1) == 15 && $number == 30) {
                    $column = 1;
                }
                elseif (($key+1) == 21 && ($number == 44 || $number == 60)) {

                }
                elseif (($key+1) == 22 && ($number == 44 || $number == 60)) {
                    $column = 1;
                }
                elseif (($key+1) == 23 && ($number == 44 || $number == 60)) {

                }
                elseif (($key+1) == 24 && ($number == 44 || $number == 60)) {
                    $column = 1;
                }

            }
        }



        return json_encode($seat_data);
    }

    public function setTemporaryBus($param)
    {

      $data=[
          'factor_number' => functions::generateFactorNumber(),
          'requestNumber' => $param['requestNumber'],
          'origin_city_iata' => $param['originCity'],
          'destination_city_iata' => $param['destinationCity'],
          'source_code' => $param['sourceCode'],
          'bus_code' => $param['busCode'],
          'available_payment_methods' => 'Credit',
      ];

        if($this->accessBusReservation() && $param['sourceCode']=='reservation_bus'){
          $reservation_bus=$this->getController('reservationBus');
          $bus_detail=$reservation_bus->getData(['id'=>$param['busCode']])[0];


            $data ['source_name']= CLIENT_NAME;
            $data ['web_service_type']= 'private';
            $data ['date_move']= $bus_detail['move_date'];
            $data ['time_move']= $bus_detail['move_time'];
            $data ['origin_city']= $bus_detail['origin']['name_fa'];
            $data ['origin_name']= $bus_detail['origin']['name_fa'];
            $data ['origin_terminal']= $bus_detail['origin_station_name'];
            $data ['destination_city']= $bus_detail['destination']['name_fa'];
            $data ['destination_name']= $bus_detail['destination']['name_fa'];
            $data ['destination_terminal']= $bus_detail['destination_station_name'];
            $data ['car_type']= $bus_detail['vehicle_name'];
            $data ['count_free_chairs']= $bus_detail['left_chairs_count'];
            $data ['price']= $bus_detail['price'];
            $data ['beforeDiscountPrice']= $bus_detail['price'];
            $data ['company']= $bus_detail['company']['name_fa'];
            $data ['base_company']= $bus_detail['base_company']['name_fa'];
            $data ['description']= $bus_detail['description'];
            $data ['seates']= $this->generateBusSeats($bus_detail['chairs_count'],$bus_detail['used_chairs']);

            $create_temporary_bus=$this->createTemporaryBus($data);

            if($create_temporary_bus){
                return 'success|'.json_encode(['requestNumber'=>$data['requestNumber'],'factor_number'=>$data['factor_number']],true);
            }else{
                return 'error|'.Functions::Xmlinformation('NewRequestError');
            }
        }



        $data['UserName']= USERNAME_CLIENT;
        $data['busCode']=$param['busCode'];
        $data['sourceCode']=$param['sourceCode'];
        $data['requestNumber']=$param['requestNumber'];
        $jsonData=json_encode($data);



        $busDetail=parent::busDetail($jsonData);

        if($this->checkApiSuccessfulStatus($busDetail)){

            $temporaryBusModel=$this->getModel('temporaryBusModel');
            $check_exist=$temporaryBusModel->get()->where('requestNumber',$data['requestNumber'])->find();
            if(!$check_exist['id']) {

                $dataInsert['factor_number'] =$factor_number= functions::generateFactorNumber();
                $dataInsert['requestNumber'] = $data['requestNumber'];
                $dataInsert['origin_city_iata'] = $param['originCity'];
                $dataInsert['destination_city_iata'] = $param['destinationCity'];
                $dataInsert['source_code'] = $busDetail['response']['data']['sourceCode'];
                $dataInsert['source_name'] = $busDetail['response']['data']['sourceName'];
                $dataInsert['web_service_type'] = $busDetail['response']['data']['webServiceType'];
                $dataInsert['bus_code'] = $busDetail['response']['data']['busCode'];
                $dataInsert['available_payment_methods'] = $busDetail['response']['data']['availablePaymentMethods'];
                $dataInsert['date_move'] = $busDetail['response']['data']['dateMove'];
                $dataInsert['time_move'] = $busDetail['response']['data']['timeMove'];
                $dataInsert['origin_city'] = $busDetail['response']['data']['originCity'];
                $dataInsert['origin_name'] = $busDetail['response']['data']['originName'];
                $dataInsert['origin_terminal'] = $busDetail['response']['data']['originTerminal'];
                $dataInsert['destination_city'] = $busDetail['response']['data']['destinationCity'];
                $dataInsert['destination_name'] = $busDetail['response']['data']['destinationName'];
                $dataInsert['destination_terminal'] = $busDetail['response']['data']['destinationTerminal'];
                $dataInsert['car_type'] = $busDetail['response']['data']['carType'];
                $dataInsert['count_free_chairs'] = $busDetail['response']['data']['countFreeChairs'];
                $how_much_percent  = ($busDetail['response']['data']['commision'] / 100) * $busDetail['response']['data']['beforeDiscountPrice'] ;
  							$dataInsert['price'] = $busDetail['response']['data']['beforeDiscountPrice'] - $how_much_percent;
//                $dataInsert['price'] = $busDetail['response']['data']['price'];
                $dataInsert['beforeDiscountPrice'] = $busDetail['response']['data']['beforeDiscountPrice'];
                $dataInsert['company'] = $busDetail['response']['data']['company'];
                $dataInsert['base_company'] = $busDetail['response']['data']['baseCompany'];
                $dataInsert['description'] = $busDetail['response']['data']['description'];
                $dataInsert['refundRules'] = json_encode($busDetail['response']['data']['refundRules'], true);

                $dataInsert['seates'] = json_encode($busDetail['response']['data']['seates'], true);
                $temporaryBusModel->insertWithBind($dataInsert);
                $resultInsert=$temporaryBusModel->get()->where('requestNumber',$data['requestNumber'])->find();
            }else{
                $resultInsert=$check_exist;
                $factor_number=$check_exist['factor_number'];
            }
            if($resultInsert){

                return 'success|'.json_encode([
                        'requestNumber'=>$data['requestNumber'],
                        'refundRules'=>json_decode($resultInsert['refundRules'],true),
                        'factor_number'=>$factor_number
                    ],true);
            }else{
                return 'error|'.Functions::Xmlinformation('NewRequestError');
            }
        }else{
            return 'error|'.Functions::Xmlinformation('NewRequestError');
        }

    }
    #endregion

    #region setBusTicketPreReserve
    public function setBusTicketPreReserve($factorNumber, $availablePaymentMethods)
    {
        /*if ($availablePaymentMethods == 'Credit') {

            $dataUpdateBook['payment_date'] = Date('Y-m-d H:i:s');
            $dataUpdateBook['status'] = 'prereserve';
            $condition = " passenger_factor_num = '{$factorNumber}' ";

            $Model = Load::library('Model');
            $Model->setTable('book_bus_tb');
            $resultUpdate[] = $Model->update($dataUpdateBook, $condition);

            $ModelBase = Load::library('ModelBase');
            $ModelBase->setTable('report_bus_tb');
            $resultUpdate[] = $ModelBase->update($dataUpdateBook, $condition);

            if (!in_array("0", $resultUpdate)) {
                $result['result'] = 'success';

            } else {
                $result['result'] = 'error';
                $result['message'] = 'خطایی در ثبت اطلاعات رخ داده است.';
            }

        } elseif ($availablePaymentMethods == 'Online') {

            $Model = Load::library('Model');

            $resultBusReserve = parent::busReserve($factorNumber);
            if (!empty($resultBusReserve) && !isset($resultBusReserve['ErrorDetail'])) {

                $objTransaction = Load::controller('transaction');
                $reserveInfo = functions::GetInfoBus($factorNumber);
                $comment = " رزرو بلیط اتوبوس " . $reserveInfo['OriginCity'] . " - " . $reserveInfo['DestinationCity']
                    . " (" . $reserveInfo['CompanyName'] . ")، تاریخ حرکت: " . $reserveInfo['DateMove'] . " - ساعت حرکت: " . $reserveInfo['TimeMove']
                    . " به شماره فاکتور: " . $reserveInfo['passenger_factor_num'];
                $reason = 'buy_bus';
                if (isset($reserveInfo['irantech_commission']) && $reserveInfo['irantech_commission'] > 0) {
                    $priceTransaction = $reserveInfo['irantech_commission'] * $reserveInfo['CountId'];
                }
                // Caution: اعتبارسنجی صاحب سیستم
                $check = $objTransaction->checkCredit($priceTransaction);
                if ($check['status'] == 'TRUE') {
                    $existTransaction = $objTransaction->getTransactionByFactorNumber($factorNumber);
                    if (empty($existTransaction)) {
                        // Caution: کاهش اعتبار موقت صاحب سیستم
                        $reduceTransaction = $objTransaction->decreasePendingCredit($priceTransaction, $factorNumber, $comment, $reason);
                        if ($reduceTransaction) {

                            $dataUpdateBook['order_code'] = $resultBusReserve['ID'];
                            $dataUpdateBook['payment_date'] = Date('Y-m-d H:i:s');
                            $dataUpdateBook['status'] = 'prereserve';

                            $condition = " passenger_factor_num = '{$factorNumber}' ";
                            $Model->setTable('book_bus_tb');
                            $resultUpdate[] = $Model->update($dataUpdateBook, $condition);

                            $ModelBase = Load::library('ModelBase');
                            $ModelBase->setTable('report_bus_tb');
                            $resultUpdate[] = $ModelBase->update($dataUpdateBook, $condition);

                            if (!in_array("0", $resultUpdate)) {
                                $result['result'] = 'success';
                                $result['paymentEndpoint'] = $resultBusReserve['PaymentEndpoint'];

                            } else {
                                $result['result'] = 'error';
                                $result['message'] = (isset($resultBusReserve['MessagePersian'])) ? $resultBusReserve['MessagePersian'] : 'خطایی در ثبت اطلاعات رخ داده است.';
                            }


                        } else {
                            $result['result'] = 'error';
                            $result['message'] = functions::Xmlinformation('ErrorDecreaseCredit');
                        }
                    } else {
                        $result['result'] = 'error';
                        $result['message'] = functions::Xmlinformation('ChargeRialSystem');
                    }
                } else {
                    $result['result'] = 'error';
                    $result['message'] = functions::Xmlinformation('ErrorDecreaseCreditByFactorNumber');
                }

            } else {
                $result['result'] = 'error';
                $result['message'] = 'خطایی از سمت ارائه دهنده سرویس دریافت شده.';
            }


        } else {
            $result['result'] = 'error';
            $result['message'] = 'نوع پرداخت برای رزرو این بلیط اتوبوس مشخص نیست.';
        }*/

        $dataUpdateBook['payment_date']=Date('Y-m-d H:i:s');
        $dataUpdateBook['status']='prereserve';
        $condition=" passenger_factor_num = '{$factorNumber}' ";

        $Model=Load::library('Model');
        $Model->setTable('book_bus_tb');
        $resultUpdate[]=$Model->update($dataUpdateBook, $condition);

        $ModelBase=Load::library('ModelBase');
        $ModelBase->setTable('report_bus_tb');
        $resultUpdate[]=$ModelBase->update($dataUpdateBook, $condition);

        if(!in_array("0", $resultUpdate)){
            $result['result']='success';

        }else{
            $result['result']='error';
            $result['message']='خطایی در ثبت اطلاعات رخ داده است.';
        }

        return json_encode($result);
    }
    #endregion


    #region checkInquireBusTicket
    public function checkInquireBusTicket($factorNumber)
    {
        //$Model = Load::library('Model');
        $ModelBase=Load::library('ModelBase');
        $objApiBus=Load::library('apiBus');

        $sql=" SELECT * FROM report_bus_tb 
                  WHERE  
                    passenger_factor_num = '{$factorNumber}'  
                    AND ( status = 'temporaryReservation' OR status = 'prereserve' OR status = 'book' ) ";
        $resultBook=$ModelBase->load($sql);
        if(!empty($resultBook)){

            $resultInquireBusTicket=$objApiBus->inquireBusTicket($resultBook['sourceCode'], $resultBook['order_code']);
            //echo 'inquireBusTicket ::: <br>' . Load::plog($resultInquireBusTicket);
            if(!empty($resultInquireBusTicket) && !isset($resultInquireBusTicket['ErrorDetail'])){

                return 'error | وضعیت رزرو '.$resultInquireBusTicket['Status'].' اعلام شده است. ';

                /*if ($resultInquireBusTicket['Status'] == 'Issued') {

                    $dataUpdateBook['status'] = 'book';
                    $dataUpdateBook['pnr'] = $resultInquireBusTicket['TicketNumber'];
                    $dataUpdateBook['ClientTraceNumber'] = isset($resultInquireBusTicket['ClientTraceNumber']) ? $resultInquireBusTicket['ClientTraceNumber'] : '';

                    $condition = " passenger_factor_num='{$factorNumber}' ";
                    $Model->setTable('book_bus_tb');
                    $res[] = $Model->update($dataUpdateBook, $condition);

                    $ModelBase->setTable('report_bus_tb');
                    $res[] = $ModelBase->update($dataUpdateBook, $condition);

                    if (!in_array("0", $res)) {
                        return 'success | رزرو با موفقیت انجام شده است. ';

                    } else {
                        return 'error | خطایی در ثبت تغییرات رخ داده است. لطفا مجددا پیگیری کنید.';
                    }

                } else {

                    $dataUpdateBook['status'] = 'cancel';

                    $condition = " passenger_factor_num='{$factorNumber}' ";
                    $Model->setTable('book_bus_tb');
                    $res[] = $Model->update($dataUpdateBook, $condition);

                    $ModelBase->setTable('report_bus_tb');
                    $res[] = $ModelBase->update($dataUpdateBook, $condition);

                    if (!in_array("0", $res)) {
                        return 'error | وضعیت رزرو ' . $resultInquireBusTicket['Status'] . ' اعلام شده است. ';

                    } else {
                        return 'error | خطایی در ثبت تغییرات رخ داده است. لطفا مجددا پیگیری کنید.';
                    }
                }*/


            }else{

                return 'error | '.$resultInquireBusTicket['ErrorDetail']['MessagePersian'];

                /*$dataUpdateBook['status'] = 'cancel';

                $condition = " passenger_factor_num='{$factorNumber}' ";
                $Model->setTable('book_bus_tb');
                $res[] = $Model->update($dataUpdateBook, $condition);

                $ModelBase->setTable('report_bus_tb');
                $res[] = $ModelBase->update($dataUpdateBook, $condition);

                if (!in_array("0", $res)) {
                    return 'error | ' . $resultInquireBusTicket['ErrorDetail']['MessagePersian'];

                } else {
                    return 'error | خطایی در ثبت تغییرات رخ داده است. لطفا مجددا پیگیری کنید.';
                }*/


            }
        }else{
            return 'error | بلیطی با این شماره فاکتور یافت نشد';
        }
    }
    #endregion

    /**
     * @param $resultBuses
     * @return bool
     */
    public function checkApiSuccessfulStatus($resultBuses)
    {
        return !empty($resultBuses) && $resultBuses['response']['SuccessfulStatus']['client'] && $resultBuses['response']['SuccessfulStatus']['provider'];
    }

    public function getBusCities(){

        $notExistRoute = [];
        $ModelBase=Load::library('ModelBase');
        $city_list = parent::getCities();
        foreach ( $city_list as $key => $city) {
            $sql=" SELECT * FROM bus_route_tb 
                  WHERE  code = '{$city["ID"]}' ";
            $resultBusRoute = $ModelBase->load($sql);
            if(!$resultBusRoute){
                $busRouteModel = $this->getModel('busRouteModel');
                $data=[
                    'name_fa'=>$city["Name"],
                    'name_en'=>$city["EnglishName"],
                    'code'=>$city["ID"]
                ];
                $resultInsert=$busRouteModel->insertWithBind($data);
                if(!$resultInsert) {
                    $notExistRoute[] = $city;
                }
            }
        }
    }
}