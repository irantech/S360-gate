<?php

error_reporting(0);
//error_reporting (E_ALL | E_STRICT);
//@ini_set ('display_errors', 1);
//@ini_set ('display_errors', 'on');

require './config/bootstrap.php';
require 'ManageTicket.php';
spl_autoload_register(array('Load', 'autoload'));
/**
 * Class TicketInternalApp
 * @property TicketInternalApp $TicketInternalApp
 */
class TicketInternalApp extends ManageTicket
{
    private $tickets = array();
    private $MultiWay = "OneWay";
    private $activeAirlines = array();
    private $maxPrice = '';
    private $minPrice = '';

    public function __construct()
    {

    }

    #origin ProcessTicket
    public function ProcessTicket($param)
    {

        /** @var resultLocal $resultLocal */
        $resultLocal =Load::controller('resultLocal');
        $ResultTicket = parent::GetResultTicket($param, $this->MultiWay);


        //departure flights
        $tickets_output['dept'] = $ResultTicket;
        //sort
        $sort = array();
        if (empty($tickets_output['dept'])) {
            $tickets_output['dept'] = array();
        }
        foreach ($tickets_output['dept'] as $k => $ticket) {
            $sort['FlightNo'][$k] = $ticket['OutputRoutes'][0]['FlightNo'];
            $sort['Airline'][$k] = $ticket['OutputRoutes'][0]['Airline']['Code'];
            $sort['FlightType'][$k] = $ticket['FlightType'];
            $sort['SeatClass'][$k] = $ticket['SeatClass'];
            $sort['DepartureTime'][$k] = $ticket['OutputRoutes'][0]['DepartureTime'];
            $sort['AdtPrice'][$k] = $ticket['AdtPrice'];
        }

        if (!empty($sort)) {
            array_multisort($sort['FlightNo'], SORT_ASC, $sort['Airline'], SORT_ASC, $sort['DepartureTime'], SORT_DESC, $sort['FlightType'], SORT_ASC, $sort['AdtPrice'], SORT_ASC, $tickets_output['dept']);
        }

        //return flights in twoway
        if ($param['return_date'] != '') {
            $this->MultiWay = 'TwoWay';
            $ReturnResultTicketInternal = parent::GetResultTicket($param, $this->MultiWay);
            $tickets_output['return'] = $ReturnResultTicketInternal;

            //در صورتیکه جستجو دوطرفه بود و پرواز برگشت نداشت، پروازهای رفت هم خالی میکنیم تا نمایش ندهد
            if (empty($tickets_output['return'])) {
                $tickets_output['dept'] = array();
            }

            //sort
            $sort = array();
            if (empty($tickets_output['return'])) {
                $tickets_output['return'] = array();
            }
            foreach ($tickets_output['return'] as $k => $ticket) {

                $sort['FlightNo'][$k] = $ticket['OutputRoutes'][0]['FlightNo'];
                $sort['Airline'][$k] = $ticket['OutputRoutes'][0]['Airline']['Code'];
                $sort['FlightType'][$k] = $ticket['FlightType'];
                $sort['SeatClass'][$k] = $ticket['SeatClass'];
                $sort['DepartureTime'][$k] = $ticket['OutputRoutes'][0]['DepartureTime'];
                $sort['AdtPrice'][$k] = $ticket['AdtPrice'];
            }

            if (!empty($sort)) {
                array_multisort($sort['FlightNo'], SORT_ASC, $sort['Airline'], SORT_ASC, $sort['DepartureTime'], SORT_DESC, $sort['FlightType'], SORT_ASC, $sort['AdtPrice'], SORT_ASC, $tickets_output['return']);
            }
        }

        //origin & destination name
        $OriginCity = functions::NameCity($param['origin']);
        $DestinationCity = functions::NameCity($param['destination']);

        foreach ($tickets_output as $direction => $newarray) {

            $i = 0;
            $count = count($newarray);
            for ($key = 0; $key < $count; $key++) {

                if ($newarray[$key]['Capacity'] > 0) {
                    $this->tickets[$direction][$i]['FlightNo'] = $newarray[$key]['OutputRoutes'][0]['FlightNo'];
                    $this->tickets[$direction][$i]['Airline'] = $newarray[$key]['OutputRoutes'][0]['Airline']['Code'];
                    $this->tickets[$direction][$i]['DepartureDate'] = $newarray[$key]['OutputRoutes'][0]['DepartureDate'];
                    if (isset($newarray[$key]['SourceId']) && !empty($newarray[$key]['SourceId'])) {

                        $this->tickets[$direction][$i]['SourceId'] = $newarray[$key]['SourceId'];
                    }

                    $dateArrival = explode('T', $newarray[$key]['OutputRoutes'][0]['DepartureDate']);
                    $this->tickets[$direction][$i]['ArrivalDate'] = functions::Date_arrival($param['origin'], $param['destination'], $newarray[$key]['OutputRoutes'][0]['DepartureTime'], $dateArrival[0]);

                    $miladidate = explode('-', $dateArrival[0]);
                    $datePersian = dateTimeSetting::gregorian_to_jalali($miladidate[0], $miladidate[1], $miladidate[2], '/');

                    $this->tickets[$direction][$i]['DepartureParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Departure']['ParentRegionName'];
                    $this->tickets[$direction][$i]['DepartureCode'] = $newarray[$key]['OutputRoutes'][0]['Departure']['Code'];
                    $this->tickets[$direction][$i]['DepartureCity'] = ($direction == 'dept' ? $OriginCity : $DestinationCity);
                    $this->tickets[$direction][$i]['ArrivalParentRegionName'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['ParentRegionName'];
                    $this->tickets[$direction][$i]['ArrivalCode'] = $newarray[$key]['OutputRoutes'][0]['Arrival']['Code'];
                    $this->tickets[$direction][$i]['ArrivalCity'] = ($direction == 'dept' ? $DestinationCity : $OriginCity);
                    $this->tickets[$direction][$i]['Aircraft'] = $newarray[$key]['OutputRoutes'][0]['Aircraft']['Manufacturer'];
                    $this->tickets[$direction][$i]['FlightType'] = ($newarray[$key]['FlightType'] == "" || strtolower($newarray[$key]['FlightType']) == "charter") ? 'اکونومی' : 'سیستمی';
                    $this->tickets[$direction][$i]['FlightType_li'] = ($newarray[$key]['FlightType'] == "" || strtolower($newarray[$key]['FlightType']) == 'charter') ? 'charter' : 'system';
                    $this->tickets[$direction][$i]['PersianDepartureDate'] = $datePersian;
                    $this->tickets[$direction][$i]['DepartureTime'] = $newarray[$key]['OutputRoutes'][0]['DepartureTime'];
                    $this->tickets[$direction][$i]['SeatClass'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? 'بیزینس' : 'اکونومی');
                    $this->tickets[$direction][$i]['SeatClassEn'] = (($newarray[$key]['SeatClass'] == 'C' || $newarray[$key]['SeatClass'] == 'B') ? 'business' : 'economy');
                    $this->tickets[$direction][$i]['CabinType'] = $newarray[$key]['OutputRoutes'][0]['CabinType'];
                    $this->tickets[$direction][$i]['AdtPrice'] = $newarray[$key]['AdtPrice'];
                    $this->tickets[$direction][$i]['ChdPrice'] = $newarray[$key]['ChdPrice'];
                    $this->tickets[$direction][$i]['InfPrice'] = $newarray[$key]['InfPrice'];
                    $this->tickets[$direction][$i]['BasPriceOriginAdt'] = $newarray[$key]['BasPriceOriginAdt'];
                    $this->tickets[$direction][$i]['TaxPriceOriginAdt'] = $newarray[$key]['TaxPriceOriginAdt'];
                    $this->tickets[$direction][$i]['CommissionPriceAdt'] = $newarray[$key]['CommissionPriceAdt'];
                    $this->tickets[$direction][$i]['Capacity'] = $newarray[$key]['Capacity'];
                    $this->tickets[$direction][$i]['Supplier'] = $newarray[$key]['Supplier']['Name'];
                    $this->tickets[$direction][$i]['UserId'] = !empty($newarray[$key]['UserId']) ? $newarray[$key]['UserId'] : '';
                    $this->tickets[$direction][$i]['UserName'] = !empty($newarray[$key]['UserName']) ? $newarray[$key]['UserName'] : '';
                    $this->tickets[$direction][$i]['SourceId'] = !empty($newarray[$key]['SourceId']) ? $newarray[$key]['SourceId'] : '';
                    $this->tickets[$direction][$i]['SourceName'] = !empty($newarray[$key]['SourceName']) ? $newarray[$key]['SourceName'] : '';
                    $this->tickets[$direction][$i]['UniqueCode'] = $newarray[$key]['UniqueCode'];
                    $this->tickets[$direction][$i]['IsInternal'] = $newarray[$key]['IsInternal'];
                    $this->tickets[$direction][$i]['Reservable'] = $newarray[$key]['Reservable'];
                    $this->tickets[$direction][$i]['FlightID'] = $newarray[$key]['FlightID'];
                    $this->tickets[$direction][$i]['ReturnFlightID'] = $newarray[$key]['ReturnFlightID'];


                }
                $i++;
            }
        }

        foreach ($this->tickets as $direction => $every_turn) {
            $filter_sort = array();
            foreach ($every_turn as $kelid => $filter) {
                $filter_sort['AdtPrice'][$kelid] = $filter['AdtPrice'];
                $time = functions::format_hour($filter['DepartureTime']);
                $filter_sort['DepartureTime'][$kelid] = str_replace(':', '', $time);
            }

            if (!empty($filter_sort)) {
                array_multisort($filter_sort['AdtPrice'], SORT_ASC, $filter_sort['DepartureTime'], SORT_ASC, $this->tickets[$direction]);
            }
        }

        /*foreach ($this->tickets as $direction => $every_turn) {


            $isInternal = ($every_turn[0]['IsInternal']) ? 'isInternal': 'isExternal' ;
            $this->tickets[$direction] = $resultLocal->deleteInactiveAirline($every_turn,$isInternal,'');
        }
        echo json_encode($this->tickets);*/
        return $this->tickets;
    }
    #endorigin

    #origin ShowUiTicket
    public function ShowUiTicket($Param)
    {

        $Tickets = $this->ProcessTicket($Param);

        ob_start();
        ?>

        <div class="selectedTicket"></div>
        <?php
        if (!empty($Tickets)) {
            foreach ($Tickets as $direction => $everyTurn) {
                foreach ($everyTurn as $Key => $Ticket) {
                    ?>

                    <div class="showListSort">
                        <div class="blit-item site-border-main-color <?php echo functions::classTimeLOCAL(functions::format_hour($Ticket['DepartureTime'])) . ' ' . $Ticket['Airline'] . ' ' . ($Ticket['FlightType_li'] == 'system' ? 'system' : 'charter') . ' ' . $Ticket['SeatClassEn'] . ' ' . $direction . 'Flight' ?>">
                            <input type="hidden" value="desc" name="currentTimeSort" id="currentTimeSort">
                            <div class="blit-i-airline">
                                <img src="<?php echo functions::getAirlinePhoto($Ticket['Airline']) ?>"
                                     alt="<?php echo $Ticket['Airline'] ?>"
                                     title="<?php echo $Ticket['Airline'] ?>">
                            </div>
                            <div class="blit-i-info">
                                <div class="blit-i-info-top">
                                    <div class="blit-i-city">
                                        <span><?php echo $Ticket['DepartureCity'] ?></span>
                                        <span>
				<svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="432.243px" height="432.243px" viewBox="0 0 432.243 432.243"
                     style="enable-background:new 0 0 432.243 432.243;"
                     xml:space="preserve">
				<g>
				<g>
					<path d="M396.132,225.557l-29.051-16.144v-13.14c0-8.836-7.164-16-16-16c-7.342,0-13.515,4.952-15.396,11.693l-24.446-13.585
						v-12.108c0-8.836-7.164-16-16-16c-7.021,0-12.968,4.526-15.125,10.813l-21.689-12.053c-1.607-31.051-4.521-59.535-8.582-83.175
						c-3.221-18.753-7.029-33.617-11.318-44.179C236.346,16.317,229.72,0,216.123,0c-13.598,0-20.224,16.317-22.402,21.679
						c-4.289,10.562-8.097,25.426-11.318,44.179c-4.06,23.64-6.975,52.124-8.582,83.175l-21.69,12.053
						c-2.157-6.287-8.106-10.813-15.124-10.813c-8.837,0-16,7.164-16,16v12.108l-24.448,13.585
						c-1.882-6.742-8.055-11.693-15.396-11.693c-8.837,0-16,7.164-16,16v13.14L36.11,225.557c-3.174,1.766-5.143,5.11-5.143,8.741
						v41.718c0,3.237,1.568,6.275,4.208,8.151s6.024,2.356,9.083,1.291l128.616-44.829c1.189,40.082,4.47,77.047,9.528,106.496
						c0.917,5.342,1.884,10.357,2.895,15.059l-66.969,37.215c-1.725,0.958-2.794,2.774-2.794,4.749v22.661
						c0,1.761,0.852,3.41,2.286,4.431c1.434,1.018,3.272,1.278,4.935,0.701l78.279-27.284c3.598,4.531,8.53,8.329,15.088,8.329
						c6.558,0,11.49-3.798,15.087-8.329l78.279,27.284c0.584,0.201,1.188,0.303,1.788,0.303c1.113,0,2.216-0.342,3.146-1.004
						c1.434-1.021,2.285-2.669,2.285-4.431v-22.662c0-1.974-1.068-3.791-2.793-4.748l-66.969-37.215c1.01-4.7,1.977-9.715,2.895-15.059
						c5.059-29.447,8.339-66.414,9.527-106.496l128.617,44.829c1.071,0.374,2.184,0.558,3.29,0.558c2.05,0,4.078-0.631,5.791-1.849
						c2.642-1.875,4.209-4.914,4.209-8.151v-41.718C401.275,230.667,399.308,227.321,396.132,225.557z"/>
				</g>
				</g>
				</svg>
				</span>
                                        <span><?php echo $Ticket['ArrivalCity'] ?></span>
                                    </div>
                                    <div class="blit-i-time timeSortDep"><?php echo functions::format_hour($Ticket['DepartureTime']) ?></div>
                                </div>
                                <div class="blit-i-info-bottom">
                                    <div class="blit-i-airline-name"><?php $InfoAirline = functions::InfoAirline($Ticket['Airline']);
                                        echo $InfoAirline['name_fa'] . ' (' . $Ticket['FlightNo'] . ')' ?>
                                        <span> ظرفیت <?php echo $Ticket['Capacity'] ?> نفر</span>
                                    </div>
                                    <!--                                    <div class="blit-i-charter">-->
                                    <?php //echo $Ticket['FlightType'] ?><!--</div>-->
                                </div>
                            </div>
                            <div class="blit-i-rezerv">
                                <?php

                                $infoRequestTicketArray = array(
                                    'Origin' => $Ticket['DepartureCode'],
                                    'Destination' => $Ticket['ArrivalCode'],
                                    'CabinType' => $Ticket['CabinType'],
                                    'Airline' => $Ticket['Airline'],
                                    'FlightNo' => $Ticket['FlightNo'],
                                    'DepartureTime' => functions::format_hour($Ticket['DepartureTime']),
                                    'DepartureDate' => str_replace('/', '-', $Ticket['PersianDepartureDate']),
                                );

                                $infoRequestTicketJson = functions::clearJsonHiddenCharacters(json_encode($infoRequestTicketArray));

                                ?>
                                <input type="hidden" name="InfoTicketResult-<?php echo $Ticket['FlightID'] ?>"
                                       id="InfoTicketResult-<?php echo $Ticket['FlightID'] ?>"
                                       value='<?php echo $infoRequestTicketJson ?>'>
                                <!--<div class="popup popup-about popup-<?php /*echo $Ticket['FlightID']*/ ?>">
                                    <div class="block">
                                        <div class="head-my-popup">
                                            <p>درخواست رزرو پرواز</p>
                                            <a class="link popup-close" href="#">بستن</a>
                                        </div>
                                        <div class="blit-i-rezerv-btn blit-i-sms-rezerv">
                                            <input type="hidden" name="InfoTicketResult" id="InfoTicketResult"
                                                   value='<?php /*echo $infoRequestTicketJson */ ?>'>
                                            <a class="SendRequestOfflineTicket site-bg-main-color">درخواست رزرو پیامکی</a>
                                        </div>


                                        <div class="blit-i-rezerv-btn blit-i-call-rezerv">
                                            <a href="tel:<?php /*echo CLIENT_PHONE*/ ?>" class="site-bg-main-color link external">درخواست رزرو تلفنی</a>
                                        </div>

                                        <div class="blit-i-rezerv-btn blit-i-call-rezerv">
                                            <a class=" link site-bg-main-color GoToRevalidate"
                                               data-FlightId="<?php /*echo $Ticket['FlightID'] */ ?>"
                                               data-UniqueCode="<?php /*echo $Ticket['UniqueCode'] */ ?>"
                                               data-SourceId="<?php /*echo $Ticket['SourceId'] */ ?>"
                                               data-adult="<?php /*echo $Param['adult'] */ ?>"
                                               data-child="<?php /*echo $Param['child'] */ ?>"
                                               data-infant="<?php /*echo $Param['infant'] */ ?>"
                                               data-FlightDirection="<?php /*echo $direction */ ?>"
                                            >رزرو آنلاین</a>
                                        </div>
                                    </div>
                                </div>-->

                            </div>

                            <div class="blit-i-bottom">
                                <div class="blit-i-charter">
                                    <span class="site-bg-main-color"><?php echo $Ticket['FlightType'] ?></span>
                                </div>
                                <div class="blit-i-price">
                                    <?php
                                    $PriceCalculated = functions::setPriceChanges($Ticket['Airline'], $Ticket['FlightType_li'], $Ticket['AdtPrice'],$Ticket['AdtFare'], 'Local', strtolower($Ticket['FlightType_li']) == 'system' ? '' : 'public',$Ticket['SourceId']);
                                    $PriceCalculated = explode(':', $PriceCalculated);

                                    $MainPriceCurrency = $PriceCalculated[1];// functions::CurrencyCalculate($PriceCalculated[1]);

                                    if ($PriceCalculated[2] == 'YES') {
                                        $PriceWithDiscount = $PriceCalculated[0];//functions::CurrencyCalculate($PriceCalculated[0]);
                                        ?>
                                        <span class="old-price"><?php echo functions::numberFormat($MainPriceCurrency/*$MainPriceCurrency['AmountCurrency']*/) ?></span>
                                        <span class="new-price"><?php echo functions::numberFormat($PriceWithDiscount/*$PriceWithDiscount['AmountCurrency']*/); ?>
                                            <span><?php echo 'ریال';//$PriceWithDiscount['TypeCurrency'] ?></span></span>
                                        <?php
                                    } else { ?>
                                        <span class="new-price"><?php echo functions::numberFormat($MainPriceCurrency/*$MainPriceCurrency['AmountCurrency']*/); ?>
                                            <span><?php echo 'ریال';//$MainPriceCurrency['TypeCurrency'] ?></span></span>
                                    <?php } ?>
                                </div>
                                <div class="blit-i-more">
                                    <input type="hidden"
                                           value="<?php echo Session::getCurrency() ?>"
                                           class="CurrencyCode">
                                    <input type="hidden" value=""
                                           name="session_filght_Id"
                                           id="session_filght_Id">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['AdtPrice'] ?>"
                                           class="AdtPrice">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['ChdPrice'] ?>"
                                           class="ChdPrice">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['InfPrice'] ?>"
                                           class="InfPrice">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['CabinType'] ?>"
                                           class="CabinType">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['Airline'] ?>"
                                           class="Airline_Code">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['FlightType_li'] ?>"
                                           class="FlightType">
                                    <input type="hidden"
                                           value="<?php echo number_format($PriceCalculated[1]) ?>"
                                           class="priceWithoutDiscount">
                                    <input type="hidden"
                                           value="<?php echo functions::checkConfigPid($Ticket['Airline'],'internal',$Ticket['FlightType_li']) ?>"
                                           class="PrivateM4">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['Capacity'] ?>"
                                           class="Capacity">
                                    <input type="hidden"
                                           value="<?php echo $Ticket['SourceName'] ?>"
                                           class="source">

                                    <a class="button site-bg-main-color button-fill  <?php echo (IS_ENABLE_SMS_ORDER == '1' || IS_ENABLE_TEL_ORDER == '1') ? 'open-vertical-' . $Ticket['FlightID'] . ' flightReserveOffline' : 'GoToRevalidate' ?> "
                                       href="#" data-popup=".popup-about"
                                       data-FlightId="<?php echo $Ticket['FlightID'] ?>"
                                       data-UniqueCode="<?php echo $Ticket['UniqueCode'] ?>"
                                       data-SourceId="<?php echo $Ticket['SourceId'] ?>"
                                       data-adult="<?php echo $Param['adult'] ?>"
                                       data-child="<?php echo $Param['child'] ?>"
                                       data-infant="<?php echo $Param['infant'] ?>"
                                       data-FlightDirection="<?php echo $direction ?>"
                                       data-Phone="<?php echo CLIENT_PHONE ?>"
                                    >
                                        <span><?php echo(($this->MultiWay != 'TwoWay') ? 'انتخاب پرواز' : (($direction == 'dept') ? 'انتخاب پرواز رفت' : 'انتخاب پرواز برگشت')); ?> </span>
                                        <i class="preloader color-white myhidden"></i>

                                    </a>


                                    </body>
                                    <!--                            <a href="" onclick="return false" class="f-loader-check f-loader-check-change"-->
                                    <!--                               id="loader_check_-->
                                    <?php //echo  $Ticket['FlightID']; ?><!--" style="display:none"></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        } else {
            ?>

            <div class="alert alert-danger margin-left-right-9">
                پروازی موجود نمی باشد،لطفا تاریخ دیگری را جستجو نمائید
            </div>

            <?php
        }


        return $PrintTicket = ob_get_clean();


    }

#endorigin


#region deleteInactiveAirline
//لیست ایرلاین های فعال
    private function deleteInactiveAirline($Tickets)
    {
        $arr = $Tickets;
        $airline = Load::model('airline');

        $arrReturn = array();
        $resultsTotalCharter724 = functions::array_filter_by_value($arr, 'SourceId', '8');
        $resultsSystemPrivate = functions::array_filter_by_value($arr, 'SourceId', '1');
        $resultsSystemReplacedSource4 = functions::array_filter_by_value($arr, 'SourceId', '11');
        $resultsSystemReplacedSource13 = functions::array_filter_by_value($arr, 'SourceId', '13');
        foreach ($resultsSystemPrivate as $item) {
            $exist[] = $item['Airline'];
        }
        foreach ($resultsSystemReplacedSource4 as $source11) {
            $SystemPublicExist[] = $source11['Airline'];
            $SystemPublicExistFlightNumber[] = $source11['FlightNo'];
        }
        foreach ($resultsTotalCharter724 as $Source7) {
            $Source7Exist[] = $Source7['Airline'];
            $Source7FlightNumber[] = $Source7['FlightNo'];
        }


        foreach ($resultsSystemReplacedSource13 as $source13) {
            $Source13Exist[] = $source13['Airline'];
            $Source13FlightNumber[] = $source13['FlightNo'];
        }
        $ArrayAirlineSystem = $airline->getActiveAirline('system');
        $ArrayAirlinePrivateSystem = $airline->getActiveAirline('private');
        $ArrayAirlineCharter = $airline->getActiveAirline('charter');

        $sourceIdPrivate = functions::SourceIdPrivate();

        foreach ($arr as $rec) {
            if (strtolower($rec['FlightType_li']) == "system") {
                if (in_array($rec['Airline'], $ArrayAirlinePrivateSystem) && in_array($rec['Airline'], $ArrayAirlineSystem)) {
                    if (functions::compareDate($rec['DepartureDate'], ((in_array($rec['SourceId'], $sourceIdPrivate)) ? $rec['DepartureTime'] : ''), '') == 'true') {
                        if ($rec['SourceId'] == '1') {
                            $arrReturn[] = $rec;
                        } else if (!in_array($rec['Airline'], $exist) && ($rec['SourceId'] == '8')) {
                            $arrReturn[] = $rec;
                        }
                    }
                } else if (((in_array($rec['Airline'], $ArrayAirlineSystem)) && (!in_array($rec['Airline'], $ArrayAirlinePrivateSystem)))) {
                    if ($rec['SourceId'] == '11') {
                        $arrReturn[] = $rec;
                    } else if ((!in_array($rec['Airline'], $SystemPublicExist) && !in_array($rec['FlightNo'], $SystemPublicExistFlightNumber) && ($rec['SourceId'] == '13'))) {

                        $arrReturn[] = $rec;
                    } else if ((!in_array($rec['Airline'], $SystemPublicExist) && !in_array($rec['Airline'], $Source13Exist) && ($rec['SourceId'] == '8'))) {
                        $arrReturn[] = $rec;
                    }
                }


            } else if (strtolower($rec['FlightType_li']) == "charter") {
                if (in_array($rec['Airline'], $ArrayAirlineCharter)) {
                    if ($rec['SourceId'] == '8') {
                        $arrReturn[] = $rec;
                    } else if (!in_array($rec['Airline'], $Source7Exist) || (!in_array($rec['FlightNo'], $Source7FlightNumber))) {
                        $arrReturn[] = $rec;
                    }
                }
            }
        }
        return $arrReturn;


    }
#endregion
}