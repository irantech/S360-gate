<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 9/17/2018
 * Time: 12:13 PM
 */
/**
 * Class flightInternal
 * @property flightInternal $flightInternal
 */
class flightInternal extends resultLocal
{
    public function __construct(){
    }


    public function FlightInternalLang()
    {
        $dataFlight['Previousday'] = functions::Xmlinformation("Previousday");
        $dataFlight['Baseprice'] = functions::Xmlinformation("Baseprice");
        $dataFlight['BaseStartTime'] =functions::Xmlinformation("BaseStartTime");
        $dataFlight['Nextday'] =functions::Xmlinformation("Nextday");
        $dataFlight['Irretrievable'] =functions::Xmlinformation("Irretrievable");
        $dataFlight['Chair'] =functions::Xmlinformation("Chair");
        $dataFlight['Numflight'] =functions::Xmlinformation("Numflight");
        $dataFlight['PhoneNumberToBookings'] =functions::Xmlinformation("PhoneNumberToBookings");
        $dataFlight['Informationflight'] =functions::Xmlinformation("Informationflight");
        $dataFlight['CancellationPrice'] =functions::Xmlinformation("CancellationPrice");
        $dataFlight['TermsandConditions'] =functions::Xmlinformation("TermsandConditions");
        $dataFlight['Flighttime'] =functions::Xmlinformation("Flighttime");
        $dataFlight['Permissibleamount'] =functions::Xmlinformation("Permissibleamount");
        $dataFlight['Kilograms'] =functions::Xmlinformation("Kilograms");
        $dataFlight['Numflight'] =functions::Xmlinformation("Numflight");
        $dataFlight['Classrate'] =functions::Xmlinformation("Classrate");
        $dataFlight['AccordingCivilAviation'] =functions::Xmlinformation("AccordingCivilAviationOrganizationResponsibilityResponsibleFlying");
        $dataFlight['ResponsibilityAllTravel'] =functions::Xmlinformation("ResponsibilityAllTravelInformationEntryIncorrectPassengerRePurchase");
        $dataFlight['MustEnterValidMobileNecessary'] =functions::Xmlinformation("MustEnterValidMobileNecessary");
        $dataFlight['AviationRegulationsBabyChildAdultAges'] =functions::Xmlinformation("AviationRegulationsBabyChildAdultAges");
        $dataFlight['CanNotBuyBabyChildTicket'] =functions::Xmlinformation("CanNotBuyBabyChildTicketOnlineIndividuallySeparatelyAdultTickets");
        $dataFlight['AircraftDetermined'] =functions::Xmlinformation("AircraftDeterminedAnyChangeAircraftCarrierHoldingFlight");
        $dataFlight['PresenceDomestic'] =functions::Xmlinformation("PresenceDomesticFlightsRequiredForeignFlightsRequiredDocuments");
        $dataFlight['MoreDetails'] =functions::Xmlinformation("MoreDetails");
        $dataFlight['Flight'] =functions::Xmlinformation("Flight");
        $dataFlight['On'] =functions::Xmlinformation("On");
        $dataFlight['Selectionflight'] =functions::Xmlinformation("Selectionflight");
        $dataFlight['PickWentFlight'] =functions::Xmlinformation("PickWentFlight");
        $dataFlight['PickBackFlight'] =functions::Xmlinformation("PickBackFlight");
        $dataFlight['CompletionCapacity'] =functions::Xmlinformation("CompletionCapacity");
        $dataFlight['SystemType'] =functions::Xmlinformation("SystemType");
        $dataFlight['Unknown'] =functions::Xmlinformation("Unknown");
        $dataFlight['Typeairline'] =functions::Xmlinformation("Typeairline");



        return $dataFlight ;
    }

    #region dataAjaxSearch
    public function DataAjaxSearch($origin, $destination, $dept_date, $return_date, $adult, $child, $infant, $airlines, $tickets, $ticketsPrivate, $maxPrice, $minPrice, $ticketsClose, $MultiWay, $lang, $searchFlightNumber)
    {


        $fee = Load::controller('cancellationFeeSetting');
        $dataArrayFlight = $this->FlightInternalLang();
        ob_start();

        foreach ($airlines  as $airline) {

            $priceMin = functions::MinPriceForAirline($airline, $tickets['dept']);

            $priceMin = functions::setPriceChanges($airline,$priceMin['FlightType'][0],$priceMin['price'],'Local',strtolower($priceMin['FlightType'][0]) == 'system' ? '' : 'public');

            $priceMinExplode = explode(':',$priceMin);

            ?>
            <script type="text/javascript">
                $("#<?php echo $airline ?>-filter").css("display", "flex");
                $("#<?php echo $airline ?>-minPrice").html('<?php echo number_format($priceMinExplode[0].'-'.$priceMin['FlightType']) ?>');
            </script>
        <?php }
        ?>



        <div class=" s-u-ajax-container">
            <div id="lightboxContainer" class="lightboxContainerOpacity">
                <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/view/client/assets/images/load21.gif" width="120px"
                     alt="" class="LoadLightbox"
                     style="display: none;"></div>
            <div class="s-u-result-wrapper">

                <?php
                if ($searchFlightNumber == ''){
                    include 'flight/Internal/beforeListFlight.php';
                }
                include 'flight/Internal/lowestPrice.php';
                ?>
                <input type="hidden" value="<?php echo $adult ?>" id="adult_qty">
                <input type="hidden" value="<?php echo $child ?>" id="child_qty">
                <input type="hidden" value="<?php echo $infant ?>" id="infant_qty">
                <input type="hidden" value="<?php echo $this->minPrice ?>" id="min_price">
                <input type="hidden" value="<?php echo $this->maxPrice ?>" id="max_price">
                <input type="hidden" value="<?php echo 'Local' ?>" id="TypeZoneFlight">
                <input type="hidden" value="<?php echo $origin ?>" id="originFlight">
                <input type="hidden" value="<?php echo $destination ?>" id="destinationFlight">
                <ul id="s-u-result-wrapper-ul">
                    <div class="selectedTicket mart10 marb10"></div>
                    <?php functions::showConfigurationContents('local_flight_search_advertise','<div class="advertises">','</div>','<div class="advertise-item">','</div>');?>
                    <div class="items item_flight">
                        <?php
                        // reservation ticket
                        if (!empty($ticketsPrivate)) {
                            echo $this->TicketPrivateCharter($ticketsPrivate, $origin, $destination, $adult, $child, $infant, $MultiWay, $return_date, $dept_date);
                        }
                        $startForeach = round((microtime(true))*1000);
                        foreach ($tickets as $direction => $everyTurn) {
                            foreach ($everyTurn as $i => $ticket) {?>
                                <!-- گرفتن بلیطهای موجود -->
                                <div class="showListSort">
                                    <div class="international-available-box
                                    <?php echo functions::classTimeLOCAL($this->format_hour($ticket['DepartureTime'])) . ' '
                                        . $ticket['Airline'] . ' '
                                        . ($ticket['FlightType_li'] == 'system' ? 'system' : 'charter') . ' '
                                        . $ticket['SeatClassEn'] . ' '
                                        . $direction . 'Flight' . ' '
                                        . $ticket['FlightNo'] ?>"
                                         id="<?php echo $i ?>-row"
                                         data-flightNo="<?php echo $ticket['FlightNo']; ?>"
                                         data-price="<?php echo $ticket['AdtPrice'] ?>"
                                         data-type="<?php echo $ticket['FlightType_li'] == 'system' ? 'system' : 'charter' ?>"
                                         data-seat="<?php echo $ticket['SeatClassEn'] ?>"
                                         data-airline="<?php echo $ticket['Airline'] ?>"
                                         data-typeAppTicket="noReservation"
                                         data-time="<?php echo functions::classTimeLOCAL($this->format_hour($ticket['DepartureTime'])) ?>"
                                    >

                                        <input type="hidden" value="noReservation" name="typeAppTicket" id="typeAppTicket">
                                        <div class="international-available-item ">
                                            <?php if($ticket['FlightType_li'] == 'system'){?>
                                                <span class="blit-mob-charter"><?php echo $dataArrayFlight['SystemType'];?></span>
                                                <?php }?>

                                            <div class="international-available-info">
                                                <div class="international-available-item-right-Cell ">

                                                    <div class="right_busin_div">

                                                        <?php if($ticket['SeatClassEn']=='business'){?>
                                                            <div class="site-bg-main-color">

                                                                <span class="iranM txt12">
                                                                    <?php echo $ticket['SeatClass']?>
                                                                </span>

                                                            </div>
                                                        <?php }?>

                                                    </div>

                                                    <?php

                                                    $ArrivalTime =  functions::CalculateArrivalTime($ticket['LongTime'], $ticket['DepartureTime']);

                                                       include  'flight/Internal/airlineFlightInternal.php';

                                                       include  'flight/Internal/infoFlightInternal.php';
                                                  ?>
                                                </div>
                                                <div class="international-available-item-left-Cell">
                                                 <?php  include 'flight/Internal/priceInternal.php';
                                                 ?>
                                                </div>
                                                <?php include 'flight/Internal/detailsInternalFlight.php';
                                                ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        if(empty($ticketsClose))
                        {
                            $ticketsClose = array();
                        }

                        foreach ($ticketsClose as $direction => $everyTurn) {
                            foreach ($everyTurn as $i => $ticket) {
                                ?>

                                <!-- گرفتن بلیطهای موجود -->
                                <div class="showListSort">
                                    <div class="international-available-box
                                    <?php echo functions::classTimeLOCAL($this->format_hour($ticket['DepartureTime'])) . ' '
                                        . $ticket['Airline'] . ' '
                                        . ($ticket['FlightType_li'] == 'system' ? 'system' : 'charter') . ' '
                                        . $ticket['SeatClassEn'] . ' '
                                        . $direction . 'Flight' . ' '
                                        . $ticket['FlightNo'] ?>"
                                         id="<?php echo $i ?>-row"
                                         data-flightNo="<?php echo $ticket['FlightNo'] ?>"
                                         data-price="<?php echo $ticket['AdtPrice'] ?>"
                                         data-type="<?php echo $ticket['FlightType_li'] == 'system' ? 'system' : 'charter' ?>"
                                         data-seat="<?php echo $ticket['SeatClassEn'] ?>"
                                         data-airline="<?php echo $ticket['Airline'] ?>"
                                         data-typeAppTicket="noReservation"
                                         data-time="<?php echo functions::classTimeLOCAL($this->format_hour($ticket['DepartureTime'])) ?>"
                                    >

                                        <input type="hidden" value="noReservation" name="typeAppTicket" id="typeAppTicket">
                                        <div class="international-available-item ">
                                            <?php if($ticket['FlightType_li'] == 'system'){?>
                                                <span class="blit-mob-charter"><?php echo $dataArrayFlight['SystemType'];?></span>
                                            <?php }?>

                                            <div class="international-available-info">
                                                <div class="international-available-item-right-Cell ">
                                                    <div class="right_busin_div">

                                                        <?php if($ticket['SeatClassEn']=='business'){?>
                                                            <div class="site-bg-main-color">

                                                                <span class="iranM txt12">
                                                                    <?php echo $ticket['SeatClass']?>
                                                                </span>

                                                            </div>
                                                        <?php }?>

                                                    </div>
                                                    <?php

                                                    $ArrivalTime =  functions::CalculateArrivalTime($ticket['LongTime'], $ticket['DepartureTime']);

                                                    include  'flight/Internal/airlineFlightInternal.php';

                                                    include  'flight/Internal/infoFlightInternal.php';
                                                    ?>
                                                </div>
                                                <div class="international-available-item-left-Cell">
                                                    <?php  include 'flight/Internal/priceInternalFlightClose.php';
                                                    ?>
                                                </div>
                                                <?php include 'flight/Internal/detailsInternalFlight.php';
                                                ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        if (empty($tickets['dept']) && empty($ticketsPrivate) && empty($ticketsClose)) {
                            ?>
                            <div class="userProfileInfo-messge ">
                                <div class="messge-login BoxErrorSearch ">
                                    <div style="float: right"  class="alarm_icon_msg">
                                        <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                                    </div>
                                    <div class="TextBoxErrorSearch">
                                        <br/>
                                        <?php echo functions::Xmlinformation("ThereNoFlightAvailableDateFlightsFull"); ?>
                                        <?php echo functions::Xmlinformation("Searchanotherdate"); ?>

                                    </div>
                                </div>
                            </div>
                        <?php }
                        ?>


                    </div>
                    <div class="sticky-article d-none"></div>
                </ul>
            </div>

        </div>





        <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>

        <!-- modal -->
<!--        <script type="text/javascript" src="--><?php //echo ROOT_ADDRESS_WITHOUT_LANG ?><!--/view/client/assets/js/modal-login.js"></script>-->

        <script type="text/javascript">
            $(document).ready(function () {

                if ($(window).width() < 960) {
                    $('html, body').animate({
                        scrollTop: $('#sendFlight').offset().top
                    }, 'slow');
                }
            });

            $(function () {
                var minPrice =parseInt('<?php echo (isset($this->PminPrice) && $this->PminPrice > 0) ? (($minPrice < $this->PminPrice) ? $minPrice : $this->PminPrice) : $minPrice ?>'),
                    maxPrice = parseInt('<?php echo (isset($this->PmaxPrice) && $this->PminPrice > 0) ? (($maxPrice > $this->PmaxPrice) ? $maxPrice : $this->PmaxPrice) : $maxPrice ?>');

                    //                    $filter_lists = $(".s-u-filter-item > div  > ul"),
//                    $filter_checkboxes = $(".s-u-filter-item input.check-switch"),
//                    $ticketsFlight = $(".international-available-box");

//                $filter_checkboxes.change(filterflight);



                $('#slider-range').slider({
                    range: true,
                    min: minPrice,
                    max: maxPrice,
                    step: 1000,
                    values: [minPrice, maxPrice],
                    slide: function (event, ui) {

                        $("#amount").val(addCommas(ui.values[0]) + " - " + addCommas(ui.values[1]));
                        minPrice = ui.values[0];
                        maxPrice = ui.values[1];
                        filterflightPrice();

                    }
                });

                $("#amount").val(addCommas(minPrice) + " - " + addCommas(maxPrice));

                function addCommas(nStr) {
                    nStr += '';
                    x = nStr.split('.');
                    x1 = x[0];
                    x2 = x.length > 1 ? '.' + x[1] : '';
                    var rgx = /(\d+)(\d{3})/;
                    while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + ',' + '$2');
                    }
                    return x1 + x2;
                }

                function filterSlider(elem) {
                    var price = parseInt($(elem).data("price"), 10);
                    return price >= minPrice && price <= maxPrice;
                }

                function filterflightPrice() {
                    $(".international-available-box").hide().filter(function () {
                        return filterSlider(this);
                    }).show();
                }

            });

        </script>

        <script type="text/javascript">
            $(document).ready(function () {

                $('body').delegate(".slideDownAirDescription", "click", function () {
                    $(this).parents('.international-available-details').find(".international-available-panel-min").addClass("international-available-panel-max");
                    $(this).parents('.international-available-detail-btn').addClass("displayiN")
                    $(this).parents('.international-available-details').find('.slideUpAirDescription').removeClass("displayiN");

                });

                $('body').delegate(".slideUpAirDescription", "click", function () {

                    $(this).parents('.international-available-details').find(".international-available-panel-min").removeClass("international-available-panel-max");
                    $(this).parents('.international-available-details').find('.international-available-detail-btn').removeClass("displayiN");
                    $(this).addClass("displayiN");

                });

                $('body').delegate(".slideDownHotelDescription", "click", function () {

                    $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max");
                    $(".international-available-item-right-Cell").addClass("my-slideup");
                    $(".international-available-item-left-Cell").addClass("my-slideup");
                    $(this).closest(".slideDownHotelDescription").addClass("displayiN");
                    $(this).siblings(".slideUpHotelDescription").removeClass("displayiN");
                });

                $('body').delegate(".slideUpHotelDescription", "click", function () {

                    $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
                    $(this).siblings(".slideDownHotelDescription").removeClass("displayiN");
                    $(this).closest(".slideUpHotelDescription").addClass("displayiN");
                });
                $('body').delegate(".my-slideup", "click", function () {

                    $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");
                    $(this).siblings().find(".slideDownHotelDescription").removeClass("displayiN");
                    $(this).siblings().find(".slideUpHotelDescription").addClass("displayiN");
                });
            });

            $('body').delegate('.detailShow', 'click', function () {
                var InfoTab = $(this).attr('InfoTab');
                var counterTab = $(this).attr('counterTab');


                $(".loaderDetail").show();
                $.post(amadeusPath + 'user_ajax.php',
                    {
                        flag: 'detailRulCancelTicket',
                        param: InfoTab
                    },
                    function (data) {
                        setTimeout(function () {
                            $(".loaderDetail").hide();
                            $('#tab-2-' + counterTab).html(data);
                        }, 10);
                    });
            });
        </script>

        <script>
            $(document).ready(function () {

                $('body').delegate('ul.tabs li', "click", function () {

                    $(this).siblings().removeClass("current");
                    $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");


                    var tab_id = $(this).attr('data-tab');


                    $(this).addClass('current');
                    $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");

                });
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#lowerSortSelect').click(function () {

                    $('.lowest').toggle();
                });
            });
            $('.select2').select2();
            $('.select2-num').select2({minimumResultsForSearch: Infinity,});
        /*    setTimeout(function () {
                $.confirm({
                    theme: 'supervan', // 'material', 'bootstrap'
                    title: '<?php echo functions::Xmlinformation("Update"); ?>',
                    icon: 'fa fa-refresh',
                    content: '<?php echo functions::Xmlinformation("updatepriceandcapacity"); ?>',
                    rtl: true,
                    closeIcon: true,
                    type: 'orange',
                    buttons: {
                        confirm: {
                            text: '<?php echo functions::Xmlinformation("Approve"); ?>',
                            btnClass: 'btn-green',
                            action: function () {
                                location.reload();
                            }
                        },
                        cancel: {
                            text: '<?php echo functions::Xmlinformation("Optout"); ?>',
                            btnClass: 'btn-orange',
                        }
                    }
                });
            }, 600);*/


        </script>
        <?php
        return $PrintTicket = ob_get_clean();
    }
    #endregion


    #region TicketPrivateCharter
    public function TicketPrivateCharter($ticketsPrivate, $origin, $destination, $adult, $child, $infant, $MultiWay, $return_date, $dept_date)
    {
        ob_start();
        $resultReservationTicket = Load::controller('resultReservationTicket');

        foreach ($ticketsPrivate as $direction => $everyTurn) {

            if ($everyTurn[0]['VehicleName'] == 'هواپیما') {

                foreach ($everyTurn as $i => $PTicket) {
                    ?>
                    <!-- گرفتن بلیط های رزرواسیون -->
                    <div class="showListSort">
                        <div class="international-available-box <?php echo functions::classTimeLOCAL($this->format_hour($PTicket['PDepartureTime'])) . ' ' . $PTicket['PAirline'] . ' ' . 'charter' . ' ' . $direction . 'Flight' ?> "
                             id="<?php echo $i ?>-row" data-price="<?php echo $PTicket['PAdtPrice'] ?>"
                             data-type="<?php echo($PTicket['PFlightType_li'] == 'system' ? 'system' : 'charter') ?>"
                             data-airline="<?php echo $PTicket['PAirline'] ?>"
                             data-typeAppTicket="reservation"
                             data-time="<?php echo functions::classTimeLOCAL($this->format_hour($PTicket['PDepartureTime'])) ?>">

                            <input type="hidden" value="reservation" name="typeAppTicket" id="typeAppTicket">

                            <div class="ribbon">
                                <span>
                                    <?php echo functions::Xmlinformation("specialoffer"); ?>
                                </span>
                            </div>

                            <div class="international-available-item ">

                                <div class="international-available-item-right-Cell ">

                                    <div class=" international-available-airlines  ">

                                        <div class="international-available-airlines-logo">
                                            <img height="50" width="50"
                                                 src="<?php echo functions::getAirlinePhoto($PTicket['PAirline']) ?>"
                                                 alt="<?php echo $PTicket['PAirline'] ?>"
                                                 title="<?php echo $PTicket['PAirline'] ?>">
                                        </div>

                                        <div class="international-available-airlines-log-info">
                                            <span class="iranM txt12"><?php echo functions::Xmlinformation("Numflight"); ?>
                                                : <?php echo $PTicket['PFlightNo'] ?></span>
                                            <span class="sandali-span2 iranM txt10"><?php echo $PTicket['PCapacity'] ?>
                                                <?php echo functions::Xmlinformation("Chair"); ?></span>
                                        </div>
                                    </div>

                                    <div class="international-available-airlines-info">
                                        <div class="airlines-info destination txtLeft">

                                            <span class="iranB txt18"><?php echo functions::NameCity($PTicket['PDepartureParentRegionName']) ?></span>
                                            <span class="iranM txt19 timeSortDep"><?php echo $this->format_hour($PTicket['PDepartureTime']) ?></span>


                                        </div>

                                        <div class="airlines-info">
                                            <div class="airlines-info-inner">
                                        <span class="iranL txt12">
                                        <?php
                                            parent::DateJalali($direction == 'return' ? $return_date : $dept_date);
                                        echo $this->day . ' ,' . $this->date_now;
                                        ?>
                                        </span>
                                                <div class="airline-line">
                                                    <div class="loc-icon">

                                                    </div>

                                                    <div class="plane-icon">
                                                        <svg version="1.1" id="Capa_1"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="32px" viewBox="0 0 512 512"
                                                             enable-background="new 0 0 512 512" xml:space="preserve">
                                                <path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
                                                    c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
                                                    l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
                                                    l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
                                                    c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
                                                    C430.607,126.934,464.363,87.021,445.355,67.036z"/>
                                                </svg>

                                                    </div>
                                                    <div class="loc-icon-destination">
                                                        <svg version="1.1" class="site-main-text-color" id="Layer_1"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="32px" viewBox="0 0 512 512"
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
                                                <span class="flight-type iranB txt13"><?php echo $PTicket['PFlightType'] ?></span>
                                                <span class="sit-class iranL txt13"><?php echo functions::Xmlinformation("Economics"); ?></span>
                                                <span class="source" style="color: white;display:inline-block;">reservation</span>


                                            </div>
                                        </div>

                                        <div class="airlines-info destination txtRight">

                                            <span class="iranB txt18"><?php echo functions::NameCity($PTicket['PArrivalParentRegionName']) ?></span>
                                            <span class=" txt19"><?php echo $this->getTimeArrival($PTicket['Hour'], $PTicket['Minutes'], $PTicket['PDepartureTime']) ?></span>


                                        </div>
                                        <div class="mob-parvaz-info">
                                            <span class="mob-parvaz-airline-name">8598</span>
                                            <span class="mob-parvaz-capacity"> - 2 صندلی</span>
                                            <span class="mob-parvaz-red-text"> - غیر قابل استرداد</span>
                                        </div>

                                    </div>

                                </div>

                                <div class="international-available-item-left-Cell">
                                    <div class="inner-avlbl-itm">
                                        <div>
                                     <span class="iranL priceSortAdt">
                                    <?php
                                    $MainPriceCurrency = functions::CurrencyCalculate($PTicket['PAdtPrice']);
                                    if ($PTicket['PriceWithDiscount'] != '') {
                                        $PriceWithDiscount = functions::CurrencyCalculate($PTicket['PriceWithDiscount']);
                                        ?>
                                        <span class="iranL old-price text-decoration-line CurrencyCal"
                                              data-amount="<?php echo round($PTicket['PAdtPrice']); ?>"><?php echo functions::numberFormat($MainPriceCurrency['AmountCurrency']) ?></span>
                                        <i class="iranM new-price site-main-text-color-drck CurrencyCal"
                                           data-amount="<?php echo round($PTicket['PriceWithDiscount']); ?>"><?php echo functions::numberFormat($PriceWithDiscount['AmountCurrency']); ?></i>
                                        <span class="CurrencyText"><?php echo $MainPriceCurrency['TypeCurrency'] ?></span>
                                        <?php
                                    } else {
                                        ?>
                                        <i class="iranM site-main-text-color-drck CurrencyCal"
                                           data-amount="<?php echo round($PTicket['PAdtPrice']); ?>"><?php echo functions::numberFormat($MainPriceCurrency['AmountCurrency']) ?></i>
                                        <span class="CurrencyText"><?php echo $MainPriceCurrency['TypeCurrency'] ?></span>
                                        <?php
                                    }
                                    ?>
                                </span>


                                        <div class="special-p">

                                            <a class="international-available-btn site-bg-main-color site-main-button-color-hover SendInfoReservationFlight"
                                               onclick="sendInfoReservationFlight('<?php echo $PTicket['ID']; ?>')"
                                               id="btnReservationFlight_<?php echo $PTicket['ID']; ?>">
                                                <?php echo(($MultiWay != 'TwoWay') ? functions::Xmlinformation("Selectionflight") : (($direction == 'dept') ? functions::Xmlinformation("PickWentFlight") : functions::Xmlinformation("PickBackFlight"))); ?>
                                            </a>

                                            <a href="" onclick="return false"
                                               class="f-loader-check f-loader-check-change"
                                               id="loader_check_<?php echo $PTicket['ID']; ?>" style="display:none"></a>

                                            <input type="hidden" id="Origin<?php echo $PTicket['ID']; ?>"
                                                   name="Origin<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $origin; ?>">
                                            <input type="hidden" id="Destination<?php echo $PTicket['ID']; ?>"
                                                   name="Destination<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $destination ?>">
                                            <input type="hidden" id="DateFlight<?php echo $PTicket['ID']; ?>"
                                                   name="DateFlight<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $PTicket['PPersianDepartureDate'] ?>">
                                            <input type="hidden" id="Price<?php echo $PTicket['ID']; ?>"
                                                   name="price<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $PTicket['PAdtPrice'] ?>">
                                            <input type="hidden" id="CountAdult<?php echo $PTicket['ID']; ?>"
                                                   name="CountAdult<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $adult ?>">
                                            <input type="hidden" id="CountChild<?php echo $PTicket['ID']; ?>"
                                                   name="CountChild<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $child ?>">
                                            <input type="hidden" id="CountInfo<?php echo $PTicket['ID']; ?>"
                                                   name="CountInfo<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $infant ?>">
                                            <input type="hidden" id="FlightNumber<?php echo $PTicket['ID']; ?>"
                                                   name="FlightNumber<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $PTicket['PFlightNo'] ?>">
                                            <input type="hidden" id="TypeVehicle<?php echo $PTicket['ID']; ?>"
                                                   name="TypeVehicle<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $PTicket['TypeVehicle'] ?>">
                                            <input type="hidden" id="FlightDirection<?php echo $PTicket['ID']; ?>"
                                                   name="FlightDirection<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $direction ?>">
                                            <input type="hidden" id="MultiWay<?php echo $PTicket['ID']; ?>"
                                                   name="MultiWay<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo $MultiWay ?>">
                                            <input type="hidden" id="typeApplication<?php echo $PTicket['ID']; ?>"
                                                   name="typeApplication<?php echo $PTicket['ID']; ?>"
                                                   value="reservation">
                                            <input type="hidden" id="CurrencyCode<?php echo $PTicket['ID']; ?>"
                                                   name="CurrencyCode<?php echo $PTicket['ID']; ?>"
                                                   value="<?php echo Session::getCurrency() ?>" class="CurrencyCode">


                                        </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="international-available-details">
                                    <div>
                                        <div class=" international-available-panel-min">
                                            <ul class="tabs">

                                                <li class="tab-link current site-border-top-main-color"
                                                    data-tab="tab-1-<?php echo $i; ?>"><?php echo functions::Xmlinformation("Informationflight"); ?>
                                                </li>
                                                <li class="tab-link site-border-top-main-color"
                                                    data-tab="tab-2-<?php echo $i; ?>"><?php echo functions::Xmlinformation("CancellationPrice"); ?>
                                                </li>
                                                <li class="tab-link site-border-top-main-color"
                                                    data-tab="tab-3-<?php echo $i; ?>"><?php echo functions::Xmlinformation("TermsandConditions"); ?>
                                                </li>

                                            </ul>

                                            <div id="tab-1-<?php echo $i; ?>" class="tab-content current">
                                                <div class="international-available-airlines-detail-tittle">
                                            <span class="iranB txt13 lh25 displayb txtRight">
                                                <i class="fa fa-circle site-main-text-color txt12"></i> <?php echo functions::Xmlinformation("Flight"); ?> <?php echo functions::NameCity($PTicket['PDepartureParentRegionName']) ?>
                                                <?php echo functions::Xmlinformation("On"); ?> <?php echo functions::NameCity($PTicket['PArrivalParentRegionName']) ?>
                                            </span>

                                                    <div class=" international-available-airlines-detail  site-border-right-main-color">

                                                        <div class="international-available-airlines-logo-detail logo-airline-ico">
                                                            <img height="30" width="30"
                                                                 src="<?php echo functions::getAirlinePhoto($PTicket['PAirline']) ?>"
                                                                 alt="<?php echo $PTicket['PAirline'] ?>"
                                                                 title="<?php echo $PTicket['PAirline'] ?>">
                                                        </div>

                                                        <div class="international-available-airlines-info-detail ">
                                                            <span class="iranL txt13 displayib"><?php echo $this->AirPlaneType($PTicket['PAircraft']) ?></span>
                                                            <span class="iranL txt13 displayib fltl"><?php echo $PTicket['Hour'] . ':' . $PTicket['Minutes']; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="international-available-airlines-detail   site-border-right-main-color">

                                                        <div class="airlines-detail-box ">

                                                        <span class="padt0 iranb txt12 lh18 displayb"><?php echo functions::Xmlinformation("Permissibleamount"); ?>
                                                            : <i
                                                                    class="iranNum">20 <?php echo functions::Xmlinformation("Kilograms"); ?></i> </span>
                                                            <span class="padt0 iranL txt12 lh18 displayb"><?php echo functions::Xmlinformation("Kilograms"); ?>
                                                                : <i
                                                                        class="openL"> <?php echo $PTicket['PFlightNo'] ?> </i> </span>
                                                            <span class="padt0 iranL txt12 lh18 displayb"><?php echo functions::Xmlinformation("Classrate"); ?>
                                                                : <i
                                                                        class="openL"><?php echo $PTicket['PCabinType'] ?> </i> </span>

                                                        </div>

                                                        <div class="airlines-detail-box ">


                                                            <span class="iranB txt15 displayb"><?php echo $this->format_hour($PTicket['PDepartureTime']) ?> </span>
                                                            <span class="iranL txt13 displayb"><?php echo $PTicket['PPersianDepartureDate'] ?></span>
                                                            <span class="iranL txt13 displayb"><?php echo functions::NameCity($PTicket['PDepartureParentRegionName']) ?></span>

                                                        </div>

                                                        <div class="airlines-detail-box ">

                                                            <span class="iranB txt15 displayb"><?php echo $this->getTimeArrival($PTicket['Hour'], $PTicket['Minutes'], $PTicket['PDepartureTime']) ?> </span>
                                                            <span class="iranL txt13 displayb"><?php echo $PTicket['PArrivalDate'] ?></span>
                                                            <span class="iranL txt13 displayb"><?php echo functions::NameCity($PTicket['PArrivalParentRegionName']) ?></span>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <div id="tab-2-<?php echo $i; ?>"
                                                 class="tab-content price-Box-Tab">
                                                <p class="iranL txt13 lh25 displayb">
                                                    <?php
                                                    $cancelingParam = array('CabinType' => $PTicket['PCabinType'], 'AdtPrice' => $PTicket['PAdtPrice'], 'PriceWithDiscount' => $PTicket['PriceWithDiscount'], 'ChdPrice' => $PTicket['PChdPrice'], 'ChdPriceWithDiscount' => $PTicket['PChdPriceWithDiscount'], 'InfPrice' => $PTicket['PInfPrice'], 'InfPriceWithDiscount' => $PTicket['PInfPriceWithDiscount']);
                                                    $resultReservationTicket->infoTicketForPopup($cancelingParam);
                                                    ?>
                                                </p>
                                            </div>
                                            <div id="tab-3-<?php echo $i; ?>" class="tab-content">
                                                <p class="iranL txt13 lh25">
                                                    <?php echo $PTicket['DescriptionTicket']; ?>
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                    <span class="international-available-detail-btn slideDownHotelDescription">

                                        <?php
                                        if (Session::IsLogin()) {
                                            $counterId = functions::getCounterTypeId($_SESSION['userId']);
                                            $resultPointClub = functions::InfoAirline($PTicket['PAirline']);
                                            $typeService = functions::TypeService($PTicket['PFlightType_li'], 'Local', 'private', '', '');
                                            $param['service'] = $typeService;
                                            $param['baseCompany'] = $resultPointClub['id'];
                                            $param['company'] = $PTicket['PFlightNo'];
                                            $param['counterId'] = $counterId;
                                            if ($PTicket['PriceWithDiscount'] != '') {
                                                $param['price'] = $PTicket['PriceWithDiscount'];
                                            } else {
                                                $param['price'] = $PTicket['PAdtPrice'];
                                            }

                                            $pointClub = functions::CalculatePoint($param);
                                            if ($pointClub > 0) {
                                                ?>
                                                <div class="text_div_morei site-main-text-color iranM txt12"><?php echo functions::Xmlinformation('Yourpurchasepoints'); ?> : <?php echo $pointClub; ?> <?php echo functions::Xmlinformation('Point'); ?> </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    <div class="my-more-info"><?php echo functions::Xmlinformation("MoreDetails"); ?>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    </span>
                                    <span class="international-available-detail-btn  slideUpHotelDescription displayiN">

                                        <i class="fa fa-angle-up"></i>
                                    </span>
                                </div>

                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>
                    <?php
                }

            }


        }

        return $PrintPrivateTicket = ob_get_clean();

    }
    #endregion
}