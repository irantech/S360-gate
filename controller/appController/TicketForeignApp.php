<?php
require './config/bootstrap.php';
require 'ManageTicket.php';
spl_autoload_register (array('Load', 'autoload'));
/**
 * Class TicketForeignApp
 * @property TicketForeignApp $TicketForeignApp
 */
class TicketForeignApp extends ManageTicket
{
    private $tickets = array();
    private $MultiWay = "OneWay";
    private $activeAirlines = array();

    #origin __construct
    public function __construct()
    {

    }
    #endregion

    #origin ProcessTicket
    public function ProcessTicket($Param)
    {
        if (!empty($Param['return_date'])) {
            $this->MultiWay = 'TwoWay';
        }
        $ResultTicket = parent::GetResultTicket($Param, $this->MultiWay);
        if (empty($ResultTicket)) {
            $ResultTicket = array();
        }



        $CountTicket = $this->CountTicketOfSource;
        $count = count($ResultTicket);


        $i = 0;
        for ($key = 0; $key < $count; $key++) {


                $KeyRoute = (count($ResultTicket[$key]['OutputRoutes']) - 1);
                $KeyRouteReturn = (count($ResultTicket[$key]['ReturnRoutes']) - 1);
                $originCity = functions::NameCityForeign($ResultTicket[$key]['OutputRoutes'][0]['Departure']['Code']);
                $originCityReturn = functions::NameCityForeign($ResultTicket[$key]['ReturnRoutes'][0]['Departure']['Code']);
                $destinationCity = functions::NameCityForeign($ResultTicket[$key]['OutputRoutes'][$KeyRoute]['Arrival']['Code']);
                $destinationCityReturn = functions::NameCityForeign($ResultTicket[$key]['ReturnRoutes'][$KeyRouteReturn]['Arrival']['Code']);

                $tickets[$i]['FlightNo'] = $ResultTicket[$key]['OutputRoutes'][0]['FlightNo'];
                $tickets[$i]['FlightNoReturn'] = $ResultTicket[$KeyRouteReturn]['ReturnRoutes'][0]['FlightNo'];

                $tickets[$i]['Airline'] = $ResultTicket[$key]['OutputRoutes'][0]['Airline']['Code'];
                $tickets[$i]['DepartureDate'] = $ResultTicket[$key]['OutputRoutes'][0]['DepartureDate'];
                if (isset($ResultTicket[$key]['SourceId']) && !empty($ResultTicket[$key]['SourceId'])) {
                    $tickets[$i]['SourceId'] = $ResultTicket[$key]['SourceId'];
                }

                $tickets[$i]['ArrivalDate'] = $ResultTicket[$key]['OutputRoutes'][$KeyRoute]['ArrivalDate'];
                $tickets[$i]['ArrivalTime'] = $ResultTicket[$key]['OutputRoutes'][$KeyRoute]['ArrivalTime'];


                $DepartureDatePersian = explode('T', $ResultTicket[$key]['OutputRoutes'][0]['DepartureDate']);
                $miladidate = explode('-', $DepartureDatePersian[0]);
                $datePersian = dateTimeSetting::gregorian_to_jalali($miladidate[0], $miladidate[1], $miladidate[2], '/');


                $tickets[$i]['DepartureParentRegionName'] = $ResultTicket[$key]['OutputRoutes'][0]['Departure']['ParentRegionName'];
                $tickets[$i]['DepartureCode'] = $ResultTicket[$key]['OutputRoutes'][0]['Departure']['Code'];
                $tickets[$i]['ArrivalParentRegionName'] = $ResultTicket[$key]['OutputRoutes'][0]['Arrival']['ParentRegionName'];
                $tickets[$i]['ArrivalCode'] = $ResultTicket[$key]['OutputRoutes'][$KeyRoute]['Arrival']['Code'];
                $tickets[$i]['Aircraft'] = $ResultTicket[$key]['OutputRoutes'][0]['Aircraft']['Manufacturer'];
                $tickets[$i]['FlightType'] = (strtolower($ResultTicket[$key]['FlightType']) == "system") ? 'سیستمی' : '';
                $tickets[$i]['FlightType_li'] = (strtolower($ResultTicket[$key]['FlightType']) == "system") ? 'system' : 'charter';
                $tickets[$i]['PersianDepartureDate'] = $datePersian;
                $tickets[$i]['DepartureTime'] = $ResultTicket[$key]['OutputRoutes'][0]['DepartureTime'];
                $tickets[$i]['SeatClass'] = (($ResultTicket[$key]['SeatClass'] == 'C' || $ResultTicket[$key]['SeatClass'] == 'B') ? 'بیزینس' : 'اکونومی');
                $tickets[$i]['SeatClassEn'] = (($ResultTicket[$key]['SeatClass'] == 'C' || $ResultTicket[$key]['SeatClass'] == 'B') ? 'business' : 'economy');
                $tickets[$i]['CabinType'] = $ResultTicket[$key]['OutputRoutes'][0]['CabinType'];
                $tickets[$i]['AdtPrice'] = $ResultTicket[$key]['AdtPrice'];
                $tickets[$i]['ChdPrice'] = $ResultTicket[$key]['ChdPrice'];
                $tickets[$i]['InfPrice'] = $ResultTicket[$key]['InfPrice'];
                $tickets[$i]['BasPriceOriginAdt'] = $ResultTicket[$key]['BasPriceOriginAdt'];
                $tickets[$i]['TaxPriceOriginAdt'] = $ResultTicket[$key]['TaxPriceOriginAdt'];
                $tickets[$i]['CommissionPriceAdt'] = $ResultTicket[$key]['CommissionPriceAdt'];
                $tickets[$i]['Capacity'] = $ResultTicket[$key]['Capacity'];
                $tickets[$i]['Supplier'] = $ResultTicket[$key]['Supplier']['Name'];
                $tickets[$i]['UserId'] = !empty($ResultTicket[$key]['UserId']) ? $ResultTicket[$key]['UserId'] : '';
                $tickets[$i]['UserName'] = !empty($ResultTicket[$key]['UserName']) ? $ResultTicket[$key]['UserName'] : '';
                $tickets[$i]['SourceId'] = !empty($ResultTicket[$key]['SourceId']) ? $ResultTicket[$key]['SourceId'] : '';
                $tickets[$i]['SourceName'] = !empty($ResultTicket[$key]['SourceName']) ? $ResultTicket[$key]['SourceName'] : '';
                $tickets[$i]['UniqueCode'] = $ResultTicket[$key]['UniqueCode'];
                $tickets[$i]['OutputRoutes'] = $ResultTicket[$key]['OutputRoutes'];
                $tickets[$i]['FlightID'] = $ResultTicket[$key]['FlightID'];
                $tickets[$i]['ReturnFlightID'] = $ResultTicket[$key]['ReturnFlightID'];
                $tickets[$i]['TotalOutputFlightDuration'] = $ResultTicket[$key]['TotalOutputFlightDuration'];
                $tickets[$i]['TotalOutputStopDuration'] = $ResultTicket[$key]['TotalOutputStopDuration'];
                $tickets[$i]['Origin'] = $originCity['DepartureCityFa'];
                $tickets[$i]['Destination'] = $destinationCity['DepartureCityFa'];


                $DepartureDatePersianReturn = explode('T', $ResultTicket[$key]['ReturnRoutes'][0]['DepartureDate']);
                $miladiDateReturn = explode('-', $DepartureDatePersianReturn[0]);
                $datePersianReturn = dateTimeSetting::gregorian_to_jalali($miladiDateReturn[0], $miladiDateReturn[1], $miladiDateReturn[2], '/');


                if (isset($ResultTicket[$key]['ReturnRoutes']) && !empty($ResultTicket[$key]['ReturnRoutes'])) {
                    $tickets[$i]['return']['ArrivalDate'] = $ResultTicket[$key]['ReturnRoutes'][$KeyRouteReturn]['ArrivalDate'];
                    $tickets[$i]['return']['ArrivalTime'] = $ResultTicket[$key]['ReturnRoutes'][$KeyRouteReturn]['ArrivalTime'];
                    $tickets[$i]['return']['DepartureParentRegionName'] = $ResultTicket[$key]['ReturnRoutes'][0]['Departure']['ParentRegionName'];
                    $tickets[$i]['return']['DepartureCode'] = $ResultTicket[$key]['ReturnRoutes'][0]['Departure']['Code'];
                    $tickets[$i]['return']['ArrivalParentRegionName'] = $ResultTicket[$key]['ReturnRoutes'][0]['Arrival']['ParentRegionName'];
                    $tickets[$i]['return']['ArrivalCode'] = $ResultTicket[$key]['ReturnRoutes'][$KeyRouteReturn]['Arrival']['Code'];
                    $tickets[$i]['return']['Aircraft'] = $ResultTicket[$key]['ReturnRoutes'][0]['Aircraft']['Manufacturer'];
                    $tickets[$i]['return']['DepartureTime'] = $ResultTicket[$key]['ReturnRoutes'][0]['DepartureTime'];
                    $tickets[$i]['return']['PersianDepartureDate'] = $datePersianReturn;
                    $tickets[$i]['return']['CabinType'] = $ResultTicket[$key]['ReturnRoutes'][0]['CabinType'];
                    $tickets[$i]['return']['ReturnRoutes'] = $ResultTicket[$key]['ReturnRoutes'];
                    $tickets[$i]['return']['FlightID'] = $ResultTicket[$key]['FlightID'];
                    $tickets[$i]['TotalReturnFlightDuration'] = $ResultTicket[$key]['TotalReturnFlightDuration'];
                    $tickets[$i]['TotalReturnStopDuration'] = $ResultTicket[$key]['TotalReturnStopDuration'];
                    $tickets[$i]['return']['OriginReturn'] = $originCityReturn['DepartureCityFa'];
                    $tickets[$i]['return']['DestinationReturn'] = $destinationCityReturn['DepartureCityFa'];
                }
                $i++;
            }



        $filter_sort = array();
        foreach ($tickets as $kelid => $filter) {
            $filter_sort['AdtPrice'][$kelid] = $filter['AdtPrice'];
            $time = functions::format_hour($filter['DepartureTime']);
            $filter_sort['DepartureTime'][$kelid] = str_replace(':', '', $time);
        }

        if (!empty($filter_sort)) {
            array_multisort($filter_sort['AdtPrice'], SORT_ASC, $filter_sort['DepartureTime'], SORT_ASC, $tickets);
        }


//        echo Load::plog(json_encode($tickets));
//        die();
        $TypeRoute = (empty($param['return_date'])) ? 'Dept' : 'Return';
        $tickets = $this->DeleteInActiveAirlineTicketForeign($tickets, $TypeRoute);
//        echo Load::plog($tickets); die();
        return $tickets;

    }

    #endorigin

    public function ShowUiTicket($Param)
    {
        $Tickets = $this->ProcessTicket($Param);
        ob_start();
        ?>

        <div class="selectedTicket"></div>
        <?php
        if (!empty($Tickets)) {
             foreach ($Tickets as $Key => $Ticket) {
                ?>
                <div class="showListSort">
                    <div class="blit-item blit-foreign-item site-border-main-color <?php echo functions::classTimeLOCAL(functions::format_hour($Ticket['DepartureTime'])) . ' ' . $Ticket['Airline'] . ' ' . ($Ticket['FlightType_li'] == 'system' ? 'system' : 'charter') . ' ' . $Ticket['SeatClassEn'] . ' ' . 'deptFlight' ?>">
                        <input type="hidden" value="desc" name="currentTimeSort" id="currentTimeSort">
                        <div class="blit-i-airline">

                            <img src="<?php echo functions::getAirlinePhoto($Ticket['Airline']) ?>"
                                 alt="<?php echo $Ticket['Airline']?>"
                                 title="<?php echo $Ticket['Airline'] ?>">
                        </div>
                        <div class="blit-i-info">
                            <div class="blit-i-info-top">
                                <div class="blit-i-city">
                                    <span><?php echo $Ticket['Origin'] ?></span>
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
                                    <span><?php echo $Ticket['Destination'] ?></span>
                                </div>
                                <div
                                        class="blit-i-time timeSortDep"><?php echo functions::format_hour($Ticket['DepartureTime']) ?></div>
                            </div>
                            <div class="blit-i-info-bottom">
                                <div
                                        class="blit-i-airline-name blit-i-tool-parvaz">

                                    طول پرواز <?php


                                    $Day = substr($Ticket['TotalOutputFlightDuration'], 0, 1);

                                    $hours = substr($Ticket['TotalOutputFlightDuration'], 2, 2);

                                    $minuets = substr($Ticket['TotalOutputFlightDuration'], 5, 2);

                                    $hours = $hours > '09' ? $hours : str_replace('0', '', $hours);

                                    echo (($Day > '0') ? $Day . 'روز' : '') . $hours . ' ساعت و ' . $minuets . ' دقیقه';

                                    ?>

                                </div>
                                <span class="blit-i-tavaghof"><?php echo (count($Ticket['OutputRoutes']) > 1) ? functions::ConvertNumberToAlphabet(count($Ticket['OutputRoutes']) - 1) . ' ' . 'توقف' : 'بدون توقف'; ?></span>

                            </div>
                        </div>

                        <?php if (isset($Ticket['return']['ReturnRoutes']) && !empty($Ticket['return']['ReturnRoutes'])) {?>
                            <div class="blit-i-airline blit-i-bargasht">
                                <img src="<?php echo functions::getAirlinePhoto($Ticket['return']['ReturnRoutes'][0]['Airline']['Code']) ?>"
                                     alt="<?php echo $Ticket['return']['ReturnRoutes'][0]['Airline']['Code'] ?>"
                                     title="<?php echo $Ticket['return']['ReturnRoutes'][0]['Airline']['Code'] ?>">
                            </div>
                            <div class="blit-i-info blit-i-bargasht">
                                <div class="blit-i-info-top">
                                    <div class="blit-i-city">
                                    <span><?php echo $Ticket['return']['OriginReturn'] ?></span>
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
                                        <span><?php echo $Ticket['return']['DestinationReturn'] ?></span>
                                    </div>
                                    <div
                                            class="blit-i-time timeSortDep"><?php echo functions::format_hour($Ticket['return']['ReturnRoutes'][0]['DepartureTime']) ?></div>
                                </div>
                                <div class="blit-i-info-bottom">
                                    <div
                                            class="blit-i-airline-name blit-i-tool-parvaz">

                                        طول پرواز <?php
                                        $Day = substr($Ticket['TotalReturnFlightDuration'], 0, 1);

                                        $hours = substr($Ticket['TotalReturnFlightDuration'], 2, 2);

                                        $minuets = substr($Ticket['TotalReturnFlightDuration'], 5, 2);

                                        $hours = $hours > '09' ? $hours : str_replace('0', '', $hours);

                                       echo  (($Day > '0') ? $Day . 'روز' : '') . '' . $hours . ' ساعت و ' . $minuets . ' دقیقه';
                                       ?>

                                    </div>

                                    <span class="blit-i-tavaghof"><?php echo (count($Ticket['return']['ReturnRoutes']) > 1) ? functions::ConvertNumberToAlphabet((count($Ticket['return']['ReturnRoutes']) - 1)) . ' ' . 'توقف' : 'بدون توقف'; ?></span>

                                </div>
                            </div>
                        <?php } ?>

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

                            <input type="hidden" name="InfoTicketResult-<?php echo $Ticket['FlightID']?>" id="InfoTicketResult-<?php echo str_replace('#','',$Ticket['FlightID'])?>"
                                   value='<?php echo $infoRequestTicketJson ?>'>
<!--                            <div class="popup popup-about popup---><?php //echo $Ticket['FlightID'] ?><!--">-->
<!--                                <div class="block">-->
<!--                                    <div class="head-my-popup">-->
<!--                                        <p>درخواست رزرو پرواز</p>-->
<!--                                        <a class="link popup-close" href="#">بستن</a>-->
<!--                                    </div>-->
<!--                                    <div class="blit-i-rezerv-btn blit-i-sms-rezerv">-->
<!--                                        <input type="hidden" name="InfoTicketResult" id="InfoTicketResult"-->
<!--                                               value='--><?php //echo $infoRequestTicketJson ?><!--'>-->
<!--                                        <a class="SendRequestOfflineTicket site-bg-main-color">درخواست رزرو پیامکی</a>-->
<!--                                    </div>-->
<!---->
<!---->
<!--                                    <div class="blit-i-rezerv-btn blit-i-call-rezerv">-->
<!--                                        <a href="tel:--><?php //echo CLIENT_PHONE ?><!--"-->
<!--                                           class="site-bg-main-color link external">درخواست رزرو تلفنی</a>-->
<!--                                    </div>-->
<!---->
<!--                                    <div class="blit-i-rezerv-btn blit-i-call-rezerv">-->
<!--                                        <a class=" link site-bg-main-color GoToRevalidate"-->
<!--                                           data-FlightId="--><?php //echo $Ticket['FlightID'] ?><!--"-->
<!--                                           data-UniqueCode="--><?php //echo $Ticket['UniqueCode'] ?><!--"-->
<!--                                           data-SourceId="--><?php //echo $Ticket['SourceId'] ?><!--"-->
<!--                                           data-adult="--><?php //echo $Param['adult'] ?><!--"-->
<!--                                           data-child="--><?php //echo $Param['child'] ?><!--"-->
<!--                                           data-infant="--><?php //echo $Param['infant'] ?><!--"-->
<!--                                           data-FlightDirection="--><?php //echo 'dept' ?><!--"-->
<!--                                        >رزرو آنلاین</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

                        </div>

                        <div class="blit-i-bottom">
                            <?php if(!empty($Ticket['FlightType'])){?>
                            <div class="blit-i-charter">
                                <span class="site-bg-main-color"><?php echo $Ticket['FlightType'] ?></span>
                            </div>
                     <?php }?>
                            <div class="blit-i-price">
                                <?php
                                $PriceCalculated = functions::setPriceChanges($Ticket['Airline'], $Ticket['FlightType_li'], $Ticket['AdtPrice'], 'Portal', 'public');
                                $PriceCalculated = explode(':', $PriceCalculated);

                                $MainPriceCurrency = $PriceCalculated[1];// functions::CurrencyCalculate($PriceCalculated[1]);

                                if ($PriceCalculated[2] == 'YES') {
                                    $PriceWithDiscount = $PriceCalculated[0];//functions::CurrencyCalculate($PriceCalculated[0]);
                                    ?>
                                    <span
                                            class="old-price"><?php echo functions::numberFormat($MainPriceCurrency/*$MainPriceCurrency['AmountCurrency']*/) ?></span>
                                    <span
                                            class="new-price"><?php echo functions::numberFormat($PriceWithDiscount/*$PriceWithDiscount['AmountCurrency']*/); ?>
                                        <span><?php echo 'ریال';//$PriceWithDiscount['TypeCurrency'] ?></span></span>
                                    <?php
                                } else { ?>
                                    <span
                                            class="new-price"><?php echo functions::numberFormat($MainPriceCurrency/*$MainPriceCurrency['AmountCurrency']*/); ?>
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
                                       value="<?php echo functions::checkConfigPid($Ticket['Airline'],'external',$Ticket['FlightType_li']) ?>"
                                       class="PrivateM4">
                                <input type="hidden"
                                       value="<?php echo $Ticket['Capacity'] ?>"
                                       class="Capacity">
                                <input type="hidden"
                                       value="<?php echo $Ticket['SourceName'] ?>"
                                       class="source">

                                <a class="button site-bg-main-color button-fill  <?php echo (IS_ENABLE_SMS_ORDER == '1' || IS_ENABLE_TEL_ORDER == '1') ? 'open-vertical-'.$Ticket['FlightID'].' flightReserveOffline' : 'GoToRevalidate' ?> "
                                   href="#" data-popup=".popup-about"
                                   data-FlightId="<?php echo $Ticket['FlightID'] ?>"
                                   data-UniqueCode="<?php echo $Ticket['UniqueCode'] ?>"
                                   data-SourceId="<?php echo $Ticket['SourceId'] ?>"
                                   data-adult="<?php echo $Param['adult'] ?>"
                                   data-child="<?php echo $Param['child'] ?>"
                                   data-infant="<?php echo $Param['infant'] ?>"
                                   data-FlightDirection="<?php echo 'dept' ?>"
                                   data-Phone="<?php echo CLIENT_PHONE ?>"
                                >
                                    <span><?php echo 'انتخاب پرواز'; ?> </span>
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

        } else {
            ?>

            <div class="alert alert-danger margin-left-right-9">
                پروازی موجود نمی باشد،لطفا تاریخ دیگری را جستجو نمائید
            </div>

            <?php
        }


        return $PrintTicket = ob_get_clean();
    }

    #region DeleteInActiveAirlineTicketForeign
    private function DeleteInActiveAirlineTicketForeign($Param, $TypeRoute)
    {
        $airline = Load::model('airline');

        $Source5 = functions::array_filter_by_value($Param, 'SourceId', '1');
        $Source8 = functions::array_filter_by_value($Param, 'SourceId', '8');

        foreach ($Source5 as $item) {
            $existSource5Airline[] = $item['Airline'];
        }
        foreach ($Source8 as $itemSource8) {
            $existSource8Airline[] = $itemSource8['Airline'];
            $existSource8FlightNo[] = $itemSource8['FlightNo'];
        }

        foreach ($Param as $rec) {
            if ($TypeRoute == 'Return' && isset($rec['return']) && !empty($rec['return'])) {
                if ($rec['SourceId'] == '1') {
                    $arrReturn[] = $rec;
                } else {
                    if (!in_array($rec['Airline'], $existSource5Airline) && ($rec['SourceId'] == '8')) {
                        $arrReturn[] = $rec;
                    }else if (!in_array($rec['Airline'], $existSource5Airline) && !in_array($rec['Airline'], $existSource8Airline) && ($rec['SourceId'] == '10')) {
                        $arrReturn[] = $rec;
                    }
                }
            } else if ($TypeRoute == 'Dept') {
                if ($rec['SourceId'] == '1') {
                    $arrReturn[] = $rec;
                } else {
                    if (!in_array($rec['Airline'], $existSource5Airline) && ($rec['SourceId'] == '8')) {
                        $arrReturn[] = $rec;
                    }else if (!in_array($rec['Airline'], $existSource5Airline) && !in_array($rec['Airline'], $existSource8Airline) && ($rec['SourceId'] == '10')) {
                        $arrReturn[] = $rec;
                    }
                }
            }
        }

        return $arrReturn;
    }
    #endregion
}