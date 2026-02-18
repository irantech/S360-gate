<?php
/**
 * Class resultBus
 * @property resultBus $resultBus
 */
class resultBus extends baseController
{
    public $errorPage;

    public function __construct()
    {
    }


    public function getBusList($param)
    {

        $param['deptDate'] = str_replace('-', '', $param['deptDate']);
        if (isset($param['destination']) && $param['destination']==''){
            $param['destination'] = $param['origin'];
        }

        $dateNow = dateTimeSetting::jdate("Ymd",'','','','en');
        $date = $param['deptDate'];
        if (trim($date) >= trim($dateNow)){
            $this->errorPage = false;
        } else {
            $this->errorPage = true;
        }
        $controllerPublic = Load::controller('reservationPublicFunctions');
        $date1 = $controllerPublic->dateNextFewDays($date, ' - 15');
        $date2 = $controllerPublic->dateNextFewDays($date, ' + 15');



        $objReservationTicket = Load::controller('resultReservationTicket');
        $tickets = $objReservationTicket->searchReservationTickets($param['origin'], $param['destination'], $param['deptDate'], '', $param['isShowAll']);
        $errorSearch = $objReservationTicket->errorSearch;
        $resultLocal = Load::controller('resultLocal');

        if (empty($tickets)) {
            $tickets = array();
        }

        $sort = array();
        foreach ($tickets as $k => $ticket) {
            $sort['FlightNo'][$k] = $ticket['FlightNumber'];
            $sort['Airline'][$k] = $ticket['Airline'];
            $sort['FlightType'][$k] = $ticket['FlightType'];
            $sort['SeatClass'][$k] = $ticket['SeatClass'];
            $sort['DepartureTime'][$k] = $ticket['DepartureTime'];
            $sort['AdtPrice'][$k] = $ticket['AdtPrice'];
        }

        if (!empty($sort)) {
            array_multisort($sort['FlightNo'], SORT_ASC, $sort['Airline'], SORT_ASC, $sort['DepartureTime'], SORT_DESC, $sort['AdtPrice'], SORT_ASC, $tickets);
        }


        $i = 0;
        $count = count($tickets);
        for ($key = 0; $key < $count; $key++) {

            $this->Bus[$i]['PFlightNo'] = $tickets[$key]['FlightNumber'];
            $this->Bus[$i]['PAirline'] = $tickets[$key]['Airline'];
            $this->Bus[$i]['TypeVehicle'] = $tickets[$key]['TypeVehicle'];
            $this->Bus[$i]['VehicleName'] = $tickets[$key]['VehicleName'];
            $dateArrival = $tickets[$key]['FlightDate'];
            $DateMiladi = functions::ConvertToMiladi(str_replace('/', '-', $dateArrival));

            $this->Bus[$i]['id'] = $tickets[$key]['ID'];
            $this->Bus[$i]['PDepartureParentRegionName'] = $tickets[$key]['OriginAirport'];
            $this->Bus[$i]['PArrivalParentRegionName'] = $tickets[$key]['DestinationAirport'];
            $this->Bus[$i]['OriginRegionId'] = $tickets[$key]['OriginRegionId'];
            $this->Bus[$i]['OriginRegionName'] = $tickets[$key]['OriginRegionName'];
            $this->Bus[$i]['DestinationRegionId'] = $tickets[$key]['DestinationRegionId'];
            $this->Bus[$i]['DestinationRegionName'] = $tickets[$key]['DestinationRegionName'];
            $this->Bus[$i]['PAircraft'] = $tickets[$key]['TypeVehicle'];
            $this->Bus[$i]['PFlightType'] = $tickets[$key]['FlightType'] == "charter" ? functions::Xmlinformation("CharterType") : '<lable class="iranB txtColor" >'.functions::Xmlinformation("SystemType").'</lable>';
            $this->Bus[$i]['PFlightType_li'] = strtolower($tickets[$key]['FlightType']) == "system" ? 'system' : 'charter';
            $this->Bus[$i]['PPersianDepartureDate'] = $dateArrival;
            $this->Bus[$i]['PDepartureTime'] = $tickets[$key]['DepartureTime'];
            $this->Bus[$i]['Minutes'] = $tickets[$key]['Minutes'];
            $this->Bus[$i]['Hour'] = $tickets[$key]['Hour'];
            $this->Bus[$i]['PSeatClass'] = ($tickets[$key]['SeatClass'] == 'Y' ? functions::Xmlinformation("EconomicsType") : functions::Xmlinformation("BusinessType"));
            $this->Bus[$i]['PCabinType'] = $tickets[$key]['CabinType'];
            $this->Bus[$i]['PAdtPrice'] = $tickets[$key]['AdtPrice'];
            $this->Bus[$i]['PriceWithDiscount'] = $tickets[$key]['PriceWithDiscount'];
            $this->Bus[$i]['PChdPrice'] = $tickets[$key]['ChdPrice'];
            $this->Bus[$i]['PChdPriceWithDiscount'] = $tickets[$key]['ChdPriceWithDiscount'];
            $this->Bus[$i]['PInfPrice'] = $tickets[$key]['InfPrice'];
            $this->Bus[$i]['PInfPriceWithDiscount'] = $tickets[$key]['InfPriceWithDiscount'];
            $this->Bus[$i]['PCapacity'] = $tickets[$key]['Capacity'];
            $this->Bus[$i]['Weight'] = $tickets[$key]['Weight'];
            $this->Bus[$i]['ID'] = $tickets[$key]['ID'];
            $this->Bus[$i]['DescriptionTicket'] = $tickets[$key]['DescriptionTicket'];
            $this->Bus[$i]['ServicesTicket'] = $tickets[$key]['ServicesTicket'];
            $this->Bus[$i]['Image'] = $tickets[$key]['Image'];
            $this->Bus[$i]['FlightDate'] = $tickets[$key]['FlightDate'];
            $this->Bus[$i]['PArrivalDate'] = $resultLocal->Date_arrival_private($tickets[$key]['Hour'], $tickets[$key]['Minutes'], $tickets[$key]['DepartureTime'], $DateMiladi);
            $this->Bus[$i]['Special'] = $tickets[$key]['Special'];


            $i++;
        }

        $filter_sort = array();
        if (empty($this->Bus)) {
            $this->Bus = array();
        }

        foreach ($resultLocal->Bus as $kelid => $Ticket) {
            $filter_sort['AdtPrice'][$kelid] = $Ticket['PAdtPrice'];
            $time = $resultLocal->format_hour($Ticket['PDepartureTime']);
            $filter_sort['DepartureTime'][$kelid] = str_replace(':', '', $time);
            $price[] = $Ticket['AdtPrice'];
        }
        $this->countReservationTicket = count($this->Bus);
        $this->minPrice = !empty($price) ? min($price) : '0';
        $this->maxPrice = !empty($price) ? max($price) : '0';

        if (!empty($filter_sort)) {
            array_multisort($filter_sort['AdtPrice'], SORT_ASC, $filter_sort['DepartureTime'], SORT_ASC, $this->Bus);
        }

        $this->adult_qty = $param['adult'];
        $this->child_qty = $param['child'];
        $this->infant_qty = $param['infant'];


        $TicketResult = $this->DataAjaxSearch($param['origin'], $param['destination'], $param['deptDate'], $param['adult'], $param['child'], $param['infant'], $this->Bus, 'OneWay', $errorSearch, $param['lang']);
        return $TicketResult;
    }


    #region dataAjaxSearch
    public function DataAjaxSearch($origin, $destination, $deptDate, $adult, $child, $infant, $listBus, $MultiWay, $errorSearch, $lang)
    {
        $resultLocal = Load::controller('resultLocal');
        $date = substr($deptDate, 0, 4).'-'.substr($deptDate, 4, 2).'-'.substr($deptDate, 6, 2);

        ob_start();
        ?>
        <div class=" s-u-ajax-container bus">
            <div id="lightboxContainer" class="lightboxContainerOpacity">
                <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/view/client/assets/images/load21.gif" width="120px"
                     alt="" class="LoadLightbox"
                     style="display: none;"></div>
            <div class="s-u-result-wrapper">

                <div class="sorting2">

                    <div class="sorting-inner date-change iranL prev">
                        <a class="prev-date" <?php echo 'href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . $lang . '/resultBus/' . $origin . '-' . $destination . '/' . $resultLocal->DatePrev($date) . '/' . $adult . '-' . $child . '-' . $infant . '"'; ?>>
                            <i class="zmdi zmdi-chevron-right iconDay"></i>
                            <span><?php echo functions::Xmlinformation("Previousday") ?></span>
                        </a>

                    </div>

                    <div class="sorting-inner sorting-active-color-main time" id="dateSortSelectForBus">
                    <span class="svg">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                          <g>
                            <path d="M11,3H1C0.4,3,0,3.4,0,4v2c0,0.6,0.4,1,1,1h10c0.6,0,1-0.4,1-1V4C12,3.4,11.6,3,11,3z"/>
                            <path d="m11,11h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                            <path d="m11,19h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                            <path d="m25.7,15.3l-1.4-1.4c-0.2-0.2-0.5-0.3-0.7-0.3-0.3,0-0.5,0.1-0.7,0.3l-2,2c-0.3,0.3-0.9,0.1-0.9-0.4v-13.5c0-0.5-0.5-1-1-1h-2c-0.5,0-1,0.5-1,1v22c0,0.3 0.1,0.5 0.3,0.7s0.5,0.3 0.7,0.3c0.3,0 0.5-0.1 0.7-0.3l8-8c0.2-0.2 0.3-0.4 0.3-0.7 0-0.3-0.1-0.5-0.3-0.7z"/>
                          </g>
                        </svg>
                    </span>

                        <span class="text-price-sort iranL"><?php echo functions::Xmlinformation("Baseddatemove") ?></span>
                        <input type="hidden" value="desc" name="currentDateSort" id="currentDateSort">
                    </div>

                    <div class="sorting-inner price" id="priceSortSelectForBus">
                    <span class="svg">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                          <g>
                            <path d="M11,3H1C0.4,3,0,3.4,0,4v2c0,0.6,0.4,1,1,1h10c0.6,0,1-0.4,1-1V4C12,3.4,11.6,3,11,3z"/>
                            <path d="m11,11h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                            <path d="m11,19h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                            <path d="m25.7,15.3l-1.4-1.4c-0.2-0.2-0.5-0.3-0.7-0.3-0.3,0-0.5,0.1-0.7,0.3l-2,2c-0.3,0.3-0.9,0.1-0.9-0.4v-13.5c0-0.5-0.5-1-1-1h-2c-0.5,0-1,0.5-1,1v22c0,0.3 0.1,0.5 0.3,0.7s0.5,0.3 0.7,0.3c0.3,0 0.5-0.1 0.7-0.3l8-8c0.2-0.2 0.3-0.4 0.3-0.7 0-0.3-0.1-0.5-0.3-0.7z"/>
                          </g>
                        </svg>

                    </span>
                        <span class="text-price-sort iranL"><?php echo functions::Xmlinformation("Baseprice") ?></span>
                        <input type="hidden" value="desc" name="currentPriceSort" id="currentPriceSort">
                    </div>

                    <div class="sorting-inner date-change iranL next">
                        <a class="next-date" <?php echo 'href="' . ROOT_ADDRESS_WITHOUT_LANG . '/' . $lang . '/resultBus/' . $origin . '-' . $destination . '/' . $resultLocal->DateNext($date) . '/' . $adult . '-' . $child . '-' . $infant . '"';  ?>>
                            <span><?php echo functions::Xmlinformation("Nextday") ?></span>
                            <i class="zmdi zmdi-chevron-left iconDay"></i>
                        </a>
                    </div>
                </div>

                <li class="s-u-result-item-header displayiN">
                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-logo-icon"></p>
                    </div>
                    <div class="s-u-result-item-wrapper">
                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-time-out"></p>
                        </div>
                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-duration-local"></p>
                        </div>
                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-flight-number-local"></p>
                        </div>
                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-flight-number"></p>
                        </div>
                    </div>
                    <div class="s-u-result-item-div">
                        <p class="s-u-result-item-div-title s-u-result-item-div-flight-price"></p>
                    </div>
                </li>

                <input type="hidden" value="<?php echo $adult ?>" id="adult_qty">
                <input type="hidden" value="<?php echo $child ?>" id="child_qty">
                <input type="hidden" value="<?php echo $infant ?>" id="infant_qty">
                <input type="hidden" value="<?php echo $this->minPrice ?>" id="min_price">
                <input type="hidden" value="<?php echo $this->maxPrice ?>" id="max_price">
                <input type="hidden" value="resultBus" id="TypeZoneFlight">


                <ul id="s-u-result-wrapper-ul" class="tour-joy">
                    <div class="selectedTicket mart10 marb10"></div>
                    <div class="items">
                        <?php
                        foreach ($listBus as $i => $bus) {
                            //if ($bus['Special'] == 'yes') {
                                ?>
                                <div class="showListSort <?php if ($bus['Special'] == 'yes') { echo 'special-tour-items'; } ?>">
                                    <div class="international-available-box <?php if ($bus['Special'] == 'yes') { echo 'special-tour-item'; } ?> <?php echo functions::classTimeLOCAL($resultLocal->format_hour($bus['PDepartureTime'])) . ' ' . 'deptFlight' ?> "
                                         id="<?php echo $i ?>-row"
                                         data-price="<?php echo $bus['PAdtPrice'] ?>"
                                         data-type="charter"
                                         data-seat="Y"
                                         data-airline="<?php echo $bus['PAirline'] ?>"
                                         data-time="<?php echo functions::classTimeLOCAL($resultLocal->format_hour($bus['PDepartureTime'])) ?>">

                                        <input type="hidden" name="dateSort" id="dateSort" value="<?php echo str_replace('/', '', $bus['FlightDate']); ?>">
                                        <input type="hidden" name="specialSort" id="specialSort" value="<?php echo $bus['Special'] ?>">

                                        <?php if ($bus['Special'] == 'yes') { ?>
                                            <div class="special-ribbon"><span> <?php echo functions::Xmlinformation("specialoffer") ?> </span></div>
                                        <?php } ?>


                                <div class="international-available-item ">

                                    <div class="international-available-item-right-Cell ">

                                        <div class=" international-available-airlines  ">

                                            <div class="international-available-airlines-logo">
                                                <img height="50" width="50" alt="" title=""
                                                     src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/pic/<?php echo $bus['Image']; ?>">
                                            </div>

                                            <div class="international-available-airlines-log-info">
                                                            <span class="iranM txt12">
                                                                <?php
                                                                if ($bus['OriginRegionName'] != '' && $bus['DestinationRegionName'] != '' && $bus['OriginRegionName'] != $bus['DestinationRegionName']) {
                                                                    echo $bus['OriginRegionName'] . ' - ' . $bus['DestinationRegionName'];
                                                                } else if ($bus['OriginRegionName'] != '') {
                                                                    echo $bus['OriginRegionName'];
                                                                } else if ($bus['DestinationRegionName'] != '') {
                                                                    echo $bus['DestinationRegionName'];
                                                                }
                                                                ?>
                                                            </span>
                                                <span class="iranM txt12"> <?php echo functions::Xmlinformation("Tour") ?>
                                                    <?php echo $bus['PFlightNo']; ?>
                                                            </span>
                                            </div>
                                        </div>

                                        <div class="international-available-airlines-info">
                                            <div class="airlines-info destination txtLeft">
                                                <span class="iranB txt18"><?php echo functions::Xmlinformation("Starttime") ?></span>
                                                <span class="iranM txt19 timeSortDep"><?php echo $resultLocal->format_hour($bus['PDepartureTime']) ?></span>
                                            </div>



                                            <div class="airlines-info">
                                                <div class="airlines-info-inner">
                                                            <span class="iranL txt12">
                                                            <?php
                                                            $this->DateJalali(str_replace("/", "-", $bus['FlightDate']));
                                                            echo $this->day . ' ,' . $this->date_now;
                                                            ?>
                                                            </span>
                                                    <div class="airline-line">
                                                        <div class="loc-icon">
                                                            <svg version="1.1"
                                                                 class="site-main-text-color"
                                                                 id="Layer_1"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                 x="0px" y="0px" width="32px"
                                                                 viewBox="0 0 512 512"
                                                                 style="enable-background:new 0 0 512 512;"
                                                                 xml:space="preserve">
                                                                    <g>
                                                                        <g>
                                                                            <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
                                                                                c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
                                                                                c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                                                                        </g>
                                                                    </g>
                                                                    </svg>
                                                        </div>

                                                        <div class="plane-icon"></div>
                                                        <div class="loc-icon-destination">
                                                            <svg version="1.1"
                                                                 class="site-main-text-color"
                                                                 id="Layer_1"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                 x="0px" y="0px" width="32px"
                                                                 viewBox="0 0 512 512"
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
                                                        </div>


                                                    </div>
                                                    <span class="sandali-span iranM txt10"><?php echo functions::Xmlinformation("Remainingcapacity") ?> <?php echo $bus['PCapacity'] ?>
                                                           <?php echo functions::Xmlinformation("People") ?></span>
                                                    <span class="sandali-span iranM txt10"><?php echo $bus['VehicleName'] . '  ' . $bus['PAircraft']; ?></span>
                                                    <span class="source"
                                                          style="color: white;display:inline-block;"><?php echo functions::Xmlinformation("Reservation") ?></span>


                                                </div>
                                            </div>

                                            <div class="airlines-info destination txtRight">
                                                <span class="iranB txt18"><?php echo functions::Xmlinformation("Returntime") ?></span>
                                                <span class="iranM txt19"><?php echo $resultLocal->getTimeArrival($bus['Hour'], $bus['Minutes'], $bus['PDepartureTime']) ?></span>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="international-available-item-left-Cell">
                                        <div class="inner-avlbl-itm">
                                                    <span class="iranL priceSortAdt">
                                                        <?php
                                                        if ($bus['PriceWithDiscount'] != '') {
                                                            ?>
                                                            <span class="iranL old-price text-decoration-line
                                                            "><?php echo number_format($bus['PAdtPrice']) ?></span>
                                                            <i class="iranM new-price site-main-text-color-drck"><?php echo number_format($bus['PriceWithDiscount']); ?></i><?php echo functions::Xmlinformation("Rial") ?>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <i class="iranM site-main-text-color-drck"><?php echo number_format($bus['PAdtPrice']) ?></i><?php echo functions::Xmlinformation("Rial") ?><?php
                                                        }
                                                        ?>
                                                    </span>

                                            <div class="special-p">

                                                <a class="international-available-btn site-bg-main-color site-main-button-color-hover SendInfoReservationFlight"
                                                   onclick="sendInfoReservationFlight('<?php echo $bus['ID']; ?>')"
                                                   id="btnReservationFlight_<?php echo $bus['ID']; ?>"><?php echo functions::Xmlinformation("Reservation") ?></a>

                                                <a href="" onclick="return false"
                                                   class="f-loader-check f-loader-check-change"
                                                   id="loader_check_<?php echo $bus['ID']; ?>"
                                                   style="display:none"></a>

                                                <input type="hidden"
                                                       id="Origin<?php echo $bus['ID']; ?>"
                                                       name="Origin<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $origin; ?>">
                                                <input type="hidden"
                                                       id="Destination<?php echo $bus['ID']; ?>"
                                                       name="Destination<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $destination ?>">
                                                <input type="hidden"
                                                       id="DateFlight<?php echo $bus['ID']; ?>"
                                                       name="DateFlight<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $bus['PPersianDepartureDate'] ?>">
                                                <input type="hidden" id="Price<?php echo $bus['ID']; ?>"
                                                       name="price<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $bus['PAdtPrice'] ?>">
                                                <input type="hidden"
                                                       id="CountAdult<?php echo $bus['ID']; ?>"
                                                       name="CountAdult<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $adult ?>">
                                                <input type="hidden"
                                                       id="CountChild<?php echo $bus['ID']; ?>"
                                                       name="CountChild<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $child ?>">
                                                <input type="hidden"
                                                       id="CountInfo<?php echo $bus['ID']; ?>"
                                                       name="CountInfo<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $infant ?>">
                                                <input type="hidden"
                                                       id="FlightNumber<?php echo $bus['ID']; ?>"
                                                       name="FlightNumber<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $bus['PFlightNo'] ?>">
                                                <input type="hidden"
                                                       id="TypeVehicle<?php echo $bus['ID']; ?>"
                                                       name="TypeVehicle<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $bus['TypeVehicle'] ?>">
                                                <input type="hidden"
                                                       id="FlightDirection<?php echo $bus['ID']; ?>"
                                                       name="FlightDirection<?php echo $bus['ID']; ?>"
                                                       value="dept">
                                                <input type="hidden"
                                                       id="MultiWay<?php echo $bus['ID']; ?>"
                                                       name="MultiWay<?php echo $bus['ID']; ?>"
                                                       value="<?php echo $MultiWay ?>">
                                                <input type="hidden"
                                                       id="typeApplication<?php echo $bus['ID']; ?>"
                                                       name="typeApplication<?php echo $bus['ID']; ?>"
                                                       value="reservationBus">


                                            </div>

                                        </div>


                                    </div>

                                    <div class="international-available-details">
                                        <div>
                                            <div class=" international-available-panel-min">
                                                <ul class="tabs">
                                                    <li class="tab-link current site-border-top-main-color"
                                                        data-tab="tab-2-<?php echo $i; ?>">
                                                    </li><?php echo functions::Xmlinformation("Description") ?>

                                                    <li class="tab-link site-border-top-main-color"
                                                        data-tab="tab-3-<?php echo $i; ?>">
                                                    </li>
                                                    <?php echo functions::Xmlinformation("Service") ?>
                                                </ul>

                                                <div id="tab-2-<?php echo $i; ?>"
                                                     class="tab-content current">
                                                    <p class="iranL txt13 lh25 displayb"><?php echo $bus['DescriptionTicket']; ?></p>
                                                </div>

                                                <div id="tab-3-<?php echo $i; ?>" class="tab-content">
                                                    <p class="iranL txt13 lh25"><?php echo $bus['ServicesTicket']; ?></p>
                                                </div>

                                            </div>
                                        </div>
                                        <?php if ($bus['DescriptionTicket'] != '' || $bus['ServicesTicket'] != '') { ?>
                                            <span class=" btn-available-d-n slideDownHotelDescription">
                                                        <div class="my-more-info"> <?php echo functions::Xmlinformation("Moredetail") ?> <i
                                                                    class="fa fa-angle-down"></i></div>
                                                    </span>
                                        <?php } ?>
                                        <span class=" btn-available-d-n   slideUpHotelDescription displayiN">
                                                        <i class="fa fa-angle-up"></i></span>
                                    </div>

                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <?php
                            //}
                        }
                        ?>
                    </div>
                </ul>



            </div>


            <?php
            if (empty($listBus)) {
                ?>
                <div class="userProfileInfo-messge">
                    <div class="messge-login BoxErrorSearch">
                        <div style="float: right;">
                            <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                        </div>
                        <div class="TextBoxErrorSearch">
                            <?php echo functions::Xmlinformation("Therenobusavailabledatebusesfull") ?>
                            <br/>
                            <?php echo functions::Xmlinformation("Searchanotherdate") ?>

                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>

        <!-- modal -->
        <script type="text/javascript" src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/view/client/assets/js/modal-login.js"></script>


        <script type="text/javascript">
            $(document).ready(function () {
                $('body').delegate(".slideDownHotelDescription","click", function () {

                    $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max");
                    $(".international-available-item-right-Cell").addClass("my-slideup");
                    $(".international-available-item-left-Cell").addClass("my-slideup");
                    $(this).closest(".slideDownHotelDescription").addClass("displayiN");
                    $(this).siblings(".slideUpHotelDescription").removeClass("displayiN");
                });

                $('body').delegate(".slideUpHotelDescription","click", function () {

                    $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
                    $(this).siblings(".slideDownHotelDescription").removeClass("displayiN");
                    $(this).closest(".slideUpHotelDescription").addClass("displayiN");
                });
                $('body').delegate(".my-slideup","click", function () {

                    $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
                    $(this).siblings().find(".slideDownHotelDescription").removeClass("displayiN");
                    $(this).siblings().find(".slideUpHotelDescription").addClass("displayiN");
                });
            });
        </script>

        <script>
            $(document).ready(function () {

                $('body').delegate('ul.tabs li',"click", function () {

                    $(this).siblings().removeClass("current");
                    $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");


                    var tab_id = $(this).attr('data-tab');


                    $(this).addClass('current');
                    $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

                });
            });
        </script>

        <script type="text/javascript">
            $('.select2').select2();
            $('.select2-num').select2({minimumResultsForSearch: Infinity,});
            setTimeout(function () {
                $.confirm({
                    theme: 'supervan', // 'material', 'bootstrap'
                    title: <?php functions::Xmlinformation("Update") ?>,
                    icon: 'fa fa-refresh',
                    content: <?php functions::Xmlinformation("updatepriceandcapacity") ?>,
                    rtl: true,
                    closeIcon: true,
                    type: 'orange',
                    buttons: {
                        confirm: {
                            text:  <?php functions::Xmlinformation("Approve") ?>,
                            btnClass: 'btn-green',
                            action: function () {
                                location.reload();
                            }
                        },
                        cancel: {
                            text: <?php functions::Xmlinformation("Optout") ?>,
                            btnClass: 'btn-orange'
                        }
                    }
                });
            }, 600000);


        </script>
        <?php
        return $PrintTicket = ob_get_clean();
    }
    #endregion



    public function DateJalali($param, $type = null)
    {
        $explode_date = explode('-', $param);

        if ($explode_date[0] > 1450) {
            $jmktime = mktime('0', '0', '0', $explode_date[1], $explode_date['2'], $explode_date[0]);
        } else {
            $jmktime = dateTimeSetting::jmktime(0, 0, 0, $explode_date[1], $explode_date[2], $explode_date[0]);
        }


        $this->date_now = dateTimeSetting::jdate(" j F Y", $jmktime);
        if (empty($type)) {
            $this->DateJalaliRequest = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');
        } else if ($type == 'TwoWay') {
            $this->DateJalaliRequestReturn = dateTimeSetting::jdate("Y-m-d", $jmktime, '', '', 'en');
        }
        $this->day = dateTimeSetting::jdate("l", $jmktime);
    }


    /**
     * @throws Exception
     */
    public function getBusRoutes($params)
    {

        $bus_routes=$this->getModel('busRouteModel')->get();

            $bus_routes=$bus_routes->where('iataCode','','!=');

        if ($params['value']) {
            $bus_routes=$bus_routes->where('name_fa','%'.$params['value'].'%','like');
            $bus_routes=$bus_routes->orwhere('name_en','%'.$params['value'].'%','like');
            $bus_routes=$bus_routes->orwhere('iataCode','%'.$params['value'].'%','like');
            $bus_routes=$bus_routes->orwhere('code','%'.$params['value'].'%','like');
        }




        $limit = '20';
        if (isset($params['limit'])){
            $limit = $params['limit'];
        }
        $bus_routes=$bus_routes->limit(0, $limit);

        $bus_routes=$bus_routes->all();



        return $bus_routes;
    }
    
    
}