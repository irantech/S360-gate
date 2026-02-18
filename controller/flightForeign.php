<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 9/8/2018
 * Time: 3:07 PM
 */

/**
 * Class flightForeign
 * @property flightForeign $flightForeign
 */
class flightForeign extends resultLocal
{
    public function __construct()
    {
        parent::__construct();
    }


    public function FlightForeign()
    {
        $dataFlight['Previousday'] = functions::Xmlinformation("Previousday");
        $dataFlight['Baseprice'] = functions::Xmlinformation("Baseprice");
        $dataFlight['BaseStartTime'] = functions::Xmlinformation("BaseStartTime");
        $dataFlight['Nextday'] = functions::Xmlinformation("Nextday");
        $dataFlight['MultiWayAirline'] = functions::Xmlinformation("MultiWayAirline");
        $dataFlight['Day'] = functions::Xmlinformation("Day");
        $dataFlight['Hour'] = functions::Xmlinformation("Hour");
        $dataFlight['And'] = functions::Xmlinformation("And");
        $dataFlight['Minutes'] = functions::Xmlinformation("Minutes");
        $dataFlight['Stop'] = functions::Xmlinformation("Stop");
        $dataFlight['Nostop'] = functions::Xmlinformation("Nostop");
        $dataFlight['Airline'] = functions::Xmlinformation("Airline");
        $dataFlight['Howmanypaths'] = functions::Xmlinformation("Howmanypaths");
        $dataFlight['Selectionflight'] = functions::Xmlinformation("Selectionflight");
        $dataFlight['Informationflight'] = functions::Xmlinformation("Informationflight");
        $dataFlight['Ticketrules'] = functions::Xmlinformation("Ticketrules");
        $dataFlight['TermsandConditions'] = functions::Xmlinformation("TermsandConditions");
        $dataFlight['ForcePassengerPresent'] = functions::Xmlinformation("Presencepassengerobligatoryhalfhoursbeforetimeflightairport");
        $dataFlight['ForceHavePassport'] = functions::Xmlinformation("Havingvalididentificationdocumentboardingaircraft");
        $dataFlight['InfoDetailFlight'] = functions::Xmlinformation("Delayhurryflightnotificationmadeviamobilenumber");
        $dataFlight['Theticketsissuedpassengersnon'] = functions::Xmlinformation("Theticketsissuedpassengersnon");
        $dataFlight['Youreceivehappysendemailsendusemail'] = functions::Xmlinformation("Youreceivehappysendemailsendusemail");
        $dataFlight['TicketSince'] = functions::Xmlinformation("Probabilitychangingcharterflightssystemcasesflightswillreturncharterercase");
        $dataFlight['Serviceslicens'] = functions::Xmlinformation("ServiceslicensestoragesmaintenanceServicescustomshoistingtransportcargohandling");
        $dataFlight['Passengerwishes'] = functions::Xmlinformation("PassengerwishesmakebetweenflightOtherwiseresponsibilitypassengercancelticket");
        $dataFlight['Shoulddifferent'] = functions::Xmlinformation("Shoulddifferentcancellationhourscancellationflightconsignmentfine");
        $dataFlight['Underpossible'] = functions::Xmlinformation("UnderpossiblenationalsAfghanistanBangladeshPakistanfutureresponsibilitiesuser");
        $dataFlight['Responsibility'] = functions::Xmlinformation("ResponsibilityvisacontrolpassengerresponsibilityContactyoufurtherinformation");
        $dataFlight['Inorderairport'] = functions::Xmlinformation("InorderairportCheckconditionspassengersrequiredcompletedatebeforestayresponsibilitypassenger");
        $dataFlight['Moredetail'] = functions::Xmlinformation("Moredetail");
        $dataFlight['RuleFlightAirPortIstanbul'] = functions::Xmlinformation("RuleFlightAirPortIstanbul");
        $dataFlight['MultiAirline'] = functions::Xmlinformation("MultiAirline");


        return $dataFlight;
    }

#region DataAjaxSearchForeign

    public function DataAjaxSearchForeign($params)
    {
        $dataArrayFlight = $this->FlightForeign();
        ob_start();
        ?>
        <div class=" s-u-ajax-container foreign">

            <div class="s-u-result-wrapper">

                <?php include 'flight/Foreign/beforeFlightList.php' ?>

                <ul id="s-u-result-wrapper-ul" class="foraign">
                    <div class="selectedTicket mart10 marb10"></div>
                    <?php functions::showConfigurationContents('external_flight_search_advertise', '<div class="advertises">', '</div>', '<div class="advertise-item">', '</div>'); ?>
                    <div class="items item_flight" id="showTicketItems">
                        <?php

                        /* بلیط رزرواسیون خارجی*/
                        $this->PrivateTicket($params['privateFlightReservation'], $params['origin'], $params['destination'], $params['adult'], $params['child'], $params['infant'], $params['MultiWay'], $params['return_date'], $params['dept_date']);
                        /* اتمام بلیط رزرواسیون خارجی*/

                        $count = 0;
                        /*بلیط وب سرویس آنلاین خارجی*/
                        foreach ($params['tickets'] as $i => $ticket) {
                            /*    $start = round((microtime(true))*1000) ;
                                echo '<br/>first foreach =>'. $start;*/
                            ?>
                            <div class="showListSort">
                                <div class="international-available-box  foreign <?php echo functions::classTimeLOCAL($this->format_hour($ticket['DepartureTime'])) . ' ' . $ticket['Airline'] . ' ' . ($ticket['FlightType_li'] == 'system' ? 'system' : 'charter') . ' ' . 'deptFlight' ?>"
                                     id="<?php echo $i ?>-row" data-price="<?php echo $ticket['AdtPrice'] ?>"
                                     data-type="<?php echo $ticket['FlightType_li'] == 'system' ? 'system' : 'charter' ?>"
                                     data-seat="<?php echo $ticket['SeatClassEn'] ?>"
                                     data-airline="<?php echo $ticket['Airline'] ?>"
                                     data-time="<?php echo functions::classTimeLOCAL($this->format_hour($ticket['DepartureTime'])) ?>"
                                     data-interrupt="<?php
                                     switch (count($ticket['OutputRoutes'])) {
                                         case '1':
                                             echo 'NoInterrupt';
                                             break;
                                         case '2':
                                             echo 'OneInterrupt';
                                             break;
                                         case '3':
                                             echo 'TwoInterrupt';
                                             break;
                                         default:
                                             echo 'NoInterrupt';
                                             break;
                                     }
                                     ?>">
                                    <div class="international-available-item">
                                        <div class="international-available-info">
                                            <div class="international-available-item-right-Cell my-slideup">
                                                <div class="right_busin_div">

                                                    <?php if ($ticket['SeatClassEn'] == 'business') { ?>
                                                        <div class="site-bg-main-color">

                                                                <span class="iranM ">
                                                                    <?php echo $ticket['SeatClass'] ?>
                                                                </span>

                                                        </div>
                                                    <?php } ?>

                                                </div>

                                                <?php
                                                include 'flight/Foreign/airlineOutPutFlight.php';

                                                include 'flight/Foreign/detailOutPutFlight.php';


                                                if (isset($ticket['return']['ReturnRoutes']) && !empty($ticket['return']['ReturnRoutes'])) {

                                                    echo '<div class="right_busin_div"></div>';
                                                    include 'flight/Foreign/airlineReturnRouteFlight.php';

                                                    include 'flight/Foreign/detailReturnRouteFlight.php';

                                                } ?>

                                            </div>

                                            <?php include 'flight/Foreign/priceFlight.php' ?>
                                            <div class="international-available-details">
                                                <div>
                                                    <div class=" international-available-panel-min">
                                                        <ul class="tabs">
                                                            <li class="tab-link  site-border-top-main-color detailShow"
                                                                data-tab="tab-1-<?php echo $i; ?>"
                                                                counterTab="<?php echo $i ?>"><?php echo $dataArrayFlight['Informationflight']; ?>
                                                            </li>
                                                            <li class="tab-link site-border-top-main-color current"
                                                                data-tab="tab-2-<?php echo $i; ?>"><?php echo $dataArrayFlight['TermsandConditions']; ?>
                                                            </li>
                                                            <li class="tab-link site-border-top-main-color"
                                                                data-tab="tab-3-<?php echo $i; ?>"
                                                                onclick="getrules('<?php echo $i ?>','<?php echo $ticket['SourceId'] ?>','<?php echo $ticket['UniqueCode'] ?>','<?php echo $ticket['FlightID'] ?>')"><?php echo $dataArrayFlight['Ticketrules']; ?>
                                                            </li>


                                                        </ul>

                                                        <div id="tab-1-<?php echo $i; ?>" class="tab-content  ">

                                                            <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/view/client/assets/images/load21.gif"
                                                                 width="120px"
                                                                 alt="" class="loaderDetail"
                                                                 style="display: none;width: 50px;position: relative;">
                                                        </div>
                                                        <div id="tab-2-<?php echo $i; ?>" class="tab-content current">
                                                            <p class="iranL  lh25 displayb">

                                                                <?php include 'flight/Foreign/rulsDetails.php' ?>

                                                            </p>
                                                        </div>
                                                        <div id="tab-3-<?php echo $i; ?>" class="tab-content">
                                                            <div class="container">
                                                                <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/view/client/assets/images/load21.gif"
                                                                     width="120px"
                                                                     alt="" class="loaderDetail"
                                                                     style="display: none;width: 50px;position: relative;"
                                                                     id="loaderDetail<?php echo $i ?>">
                                                                <div class="accordion_roul" id="ruls<?php echo $i ?>">
                                                                </div>
                                                            </div>

                                                            <!--<p class="iranL  lh25 displayb">
                                                        <?php /*echo $dataArrayFlight['Inorderairport'] */ ?>

                                                    </p>-->
                                                        </div>

                                                    </div>
                                                </div>
                                                <span class="international-available-detail-btn more_1 ">

                                            <?php
                                            if (Session::IsLogin()) {
                                                $counterId = functions::getCounterTypeId($_SESSION['userId']);
                                                $resultPointClub = functions::InfoAirline($ticket['Airline']);
                                                $checkPrivate = functions::checkConfigPid($ticket['Airline'], 'external', strtolower($ticket['FlightType_li']));
                                                $typeService = functions::TypeService($ticket['FlightType_li'], 'Portal', strtolower($ticket['FlightType_li']) == 'system' ? '' : 'public', $checkPrivate, $ticket['Airline']);
                                                $param['service'] = $typeService;
                                                $param['baseCompany'] = $resultPointClub['id'];
                                                $param['company'] = $ticket['FlightNo'];
                                                $param['counterId'] = $counterId;
                                                if ($PriceCalculated[2] == 'YES') {
                                                    $param['price'] = $PriceCalculated[0];
                                                } else {
                                                    $param['price'] = $PriceCalculated[1];
                                                }
                                                $pointClub = functions::CalculatePoint($param);
                                                if ($pointClub > 0) {
                                                    ?>
                                                    <div class="text_div_morei site-main-text-color iranM "><?php echo functions::Xmlinformation('Yourpurchasepoints'); ?> : <?php echo $pointClub; ?> <?php echo functions::Xmlinformation('Point'); ?></div>
                                                    <?php
                                                }
                                            }
                                            ?>

                                                     <div class="my-more-info slideDownAirDescription">
                                                         <?php echo $dataArrayFlight['Moredetail'] ?><i
                                                                 class="fa fa-angle-down"></i>
                                                     </div></span>
                                                <span class="international-available-detail-btn slideUpAirDescription displayiN">
                                                    <i class="fa fa-angle-up"></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>


                                    <div class="clear"></div>
                                </div>
                            </div>
                            <?php
                            /* echo '<br/>end foreach =>'. round((microtime(true))*1000);
                             echo '<br/>total In foreach =>'. (round((microtime(true))*1000)-$start);*/
                        }
                        ?>
                    </div>
                    <?php
                    /* اتمام ویوی بلیط وب سرویس آنلاین خارجی*/

                    if (empty($params['tickets']) && empty($params['reservationTicket'])) {
                        ?>
                        <div class="userProfileInfo-messge ">
                            <div class="messge-login BoxErrorSearch BoxErrorSearch_n">
                                <div class="alarm_icon_msg"><i
                                            class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                                </div>
                                <div class="TextBoxErrorSearch">

                                    <?php if ($params['filterSearch'] == 'filter') {
                                        echo functions::Xmlinformation("NotResultForSearch"); ?>
                                        <br/>
                                        <?php echo functions::Xmlinformation("ChangeSaerchFilter");
                                    } else {
                                        echo functions::Xmlinformation("ThereNoFlightAvailableDateFlightsFull"); ?>
                                        <br/>
                                        <?php echo functions::Xmlinformation("Searchanotherdate");
                                    } ?>

                                </div>
                            </div>
                        </div>

                    <?php }
                    ?>

                    <?php
                    foreach ($params['airlines'] as $airline) {

                        $priceMin = min($params['priceAirline'][$airline]);
                        $priceMin = functions::setPriceChanges($airline, $priceMin['FlightType'][0], $priceMin, 'Portal', strtolower($priceMin['FlightType'][0]) == 'system' ? '' : 'public');

                        $priceMinExplode = explode(':', $priceMin);
                        ?>
                        <script type="text/javascript">
                            $("#<?php echo $airline ?>-filter").css("display", "flex");
                            $("#<?php echo $airline ?>-minPrice").html('<?php echo number_format($priceMinExplode[1]) ?>');
                        </script>
                    <?php } ?>

            </div>
            <div class="sticky-article d-none"></div>
            </ul>

        </div>
        </div>

        <?php
        $countTicketInPage = functions::countTicketInPage();
        if ($params['countTicket'] > $countTicketInPage) {
            $receiveCount = round(intval($params['countTicket']) / intval($countTicketInPage));
        } else {
            $receiveCount = '1';
        }

        if (($params['countTicket'] > 0) && ($receiveCount > 1) && !empty($params['tickets'])) {
            ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <?php

                    for ($i = 0; $i < ($receiveCount); $i++) {
                        $dataPage['nameFile'] = $params['tickets'][0]['UniqueCode'] . '/' . $i;
                        $dataPage['numberPage'] = $i;
                        $dataPage['countTicket'] = $params['countTicket'];
                        $dataPage['adult'] = $params['adult'];
                        $dataPage['child'] = $params['child'];
                        $dataPage['infant'] = $params['infant'];
                        $dataPage['dept_date'] = $params['dept_date'];
                        $dataPage['page'] = $params['page'];
                        $dataPage['lang'] = $params['lang'];
                        $dataPage['origin'] = $params['origin'];
                        $dataPage['destination'] = $params['destination'];
                        ?>
                        <?php if ($params['page'] != $i) { ?>

                            <li onclick=" goToPage('<?php echo $dataPage['nameFile'] ?>','<?php echo $dataPage['numberPage'] ?>','<?php echo $dataPage['countTicket'] ?>','<?php echo $dataPage['origin'] ?>','<?php echo $dataPage['destination'] ?>','<?php echo $dataPage['adult'] ?>','<?php echo $dataPage['child'] ?>','<?php echo $dataPage['infant'] ?>','<?php echo $dataPage['dept_date'] ?>','<?php echo $dataPage['page'] ?>','<?php echo $dataPage['lang'] ?>','<?php echo $dataPage['return_date'] ?>');  return false;"
                                class="page-item"><a class="page-link"><?php echo $i + 1; ?></a></li>
                        <?php } else {
                            ?>
                            <li class="page-item <?php if ($params['page'] == $i) {
                                echo 'active';
                            } ?>">
                                <a class="page-link" href="#"><?php echo $i + 1; ?> <span
                                            class="sr-only">(current)</span></a>
                            </li>


                            <?php
                        }
                    }
                    ?>

                </ul>
            </nav>
        <?php } ?>
        <div class="price-Box displayNone" id="ShowInfoFlightCabinType"></div>

        <!-- modal -->
        <script type="text/javascript"
                src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/view/client/assets/js/modal-login.js"></script>


        <script type="text/javascript">
            $(function () {
                var minPrice = <?php echo (isset($this->PminPrice) && $this->PminPrice > 0) ? (($params['minPrice'] < $params['PminPrice']) ? $params['minPrice'] : $params['PminPrice']) : $params['minPrice'] ?>,
                    maxPrice = <?php echo (isset($this->PmaxPrice) && $this->PminPrice > 0) ? (($params['maxPrice'] > $params['PmaxPrice']) ? $params['maxPrice'] : $params['PmaxPrice']) : $params['maxPrice'] ?>,
                    $filter_lists = $(".s-u-filter-item > div  > ul"),
                    $filter_checkboxes = $(".s-u-filter-item input.check-switch"),
                    $tickets = $(".international-available-box");
                $filter_checkboxes.change(filterflight);

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

                    $tickets.hide().filter(function () {
                        return filterSlider(this);
                    }).show();
                }

            });
            $(document).ready(function () {
                if ($(window).width() < 960) {
                    $('html, body').animate({
                        scrollTop: $('#sendFlight').offset().top
                    }, 'slow');
                }

                // Handler for .ready() called.

                $('body').delegate('.detailShow', 'click', function () {
                    var uniqueCode = $(this).parents().siblings('div.international-available-item-left-Cell').find('div.inner-avlbl-itm').find('input.uniqueCode').val();
                    var FlightID = $(this).parents().siblings('div.international-available-item-left-Cell').find('div.inner-avlbl-itm').find('input.FlightID').val();
                    var counterTab = $(this).attr('counterTab');
                    var dataInfo = {
                        'uniqueCode': uniqueCode,
                        'FlightID': FlightID,
                    };
                    $(".loaderDetail").show();
                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            flag: 'detailTicketForeign',
                            param: dataInfo
                        },
                        function (data) {
                            setTimeout(function () {
                                $(".loaderDetail").hide();
                                $('#tab-1-' + counterTab).html(data);
                            }, 10);

                        });
                });
            });

        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $(".slideDownHotelDescription").on("click", function () {
                    $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max ");
                    $(this).closest(".slideDownHotelDescription").addClass("displayiN");
                    $(this).siblings(".slideUpHotelDescription").removeClass("displayiN");
                });

                $(".slideUpHotelDescription").on("click", function () {

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
        </script>
        <script>
            $(document).ready(function () {

                $('body').on('click', '.accordion-item', function () {
                    $('.accordion-item').removeClass('accordion-active');
                    $(this).toggleClass('accordion-active');
                });
                $('ul.tabs li').on("click", function () {

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


            function getrules(counter, sourceId, requestNumber, flightId) {
                <?php

                $rule_text = functions::Xmlinformation('NoRulesForFlight');
                if (SOFTWARE_LANG == 'ar') {
                    $rule_text = functions::showConfigurationContents('custom_ar_flight_rule_text', '', '', '', '', false);
                    if (empty($rule_text)) {
                        $rule_text = functions::Xmlinformation('NoRulesForFlight');
                    }
                }
                if (SOFTWARE_LANG == 'en') {
                    $rule_text = functions::showConfigurationContents('custom_en_flight_rule_text', '', '', '', '', false);
                    if (empty($rule_text)) {
                        $rule_text = functions::Xmlinformation('NoRulesForFlight');
                    }
                }
                ?>


                if (sourceId != '10') {

                    $('#ruls' + counter).html(`
                        <div class="accordion-item ">
                             <button id="accordion-button-1" aria-expanded="false">
                               <span class="accordion-title-roul site-main-text-color">

                                       <p><?php echo $rule_text;?></p> </span></button>
                        </div>
                    `)
                } else {
                    $("#loaderDetail" + counter).show();
                    $.post(amadeusPath + 'user_ajax.php',
                        {
                            flag: 'getRuleFlightForeign',
                            requestNumber: requestNumber,
                            flightId: flightId,
                            adult: 1,
                            child: 0,
                            infant: 0,

                        }, function (data) {
                            $('#ruls' + counter).html(data);
                            setTimeout(function () {
                                $("#loaderDetail" + counter).hide();
                            }, 10);
                        });
                }
            }
        </script>
        <?php
        return $PrintTicket = ob_get_clean();
    }

#endregion


#region PrivateTicket
    public function PrivateTicket($ticketsPrivate, $origin, $destination, $adult, $child, $infant, $MultiWay, $return_date, $dept_date)
    {

        ob_start();
        $resultReservationTicket = Load::controller('resultReservationTicket');
        ?>
        <input type="hidden" id="PrivateCharter">
        <input type="hidden" id="IdPrivate">

        <?php
        foreach ($ticketsPrivate as $direction => $everyTurn) {
            foreach ($ticketsPrivate as $j => $firstarrays) {
                foreach ($firstarrays as $i => $PTicket) {
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
                                <span><?php echo functions::Xmlinformation("specialoffer"); ?></span>
                            </div>

                            <div class="international-available-item ">

                                <div class="international-available-item-right-Cell ">

                                    <div class=" international-available-airlines  ">

                                        <div class="international-available-airlines-logo logo-airline-ico">
                                        </div>

                                        <div class="international-available-airlines-log-info">
                                            <span class="iranM ">
                                                <?php echo functions::Xmlinformation("Numflight"); ?>
                                                : <?php echo $PTicket['PFlightNo'] ?></span>
                                            <span class="sandali-span2 iranM "><?php echo $PTicket['PCapacity'] ?>
                                                <?php echo functions::Xmlinformation("Chair"); ?></span>
                                        </div>
                                    </div>

                                    <div class="international-available-airlines-info">
                                        <div class="airlines-info destination txtLeft">

                                             <span class="iranB txt18"><?php

                                                 $Departure = functions::NameCityForeign($PTicket['PDepartureParentRegionName']);
                                                 echo $Departure[functions::changeFieldNameByLanguage('DepartureCity')];
                                                 ?></span>
                                            <span class="iranM txt19 timeSortDep"><?php echo $this->format_hour($PTicket['PDepartureTime']) ?></span>


                                        </div>

                                        <div class="airlines-info">
                                            <div class="airlines-info-inner">
                                        <span class="iranL ">
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
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                             y="0px"
                                                             width="32px" viewBox="0 0 512 512"
                                                             enable-background="new 0 0 512 512"
                                                             xml:space="preserve">
                                                <path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
                                                    c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
                                                    l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
                                                    l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
                                                    c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
                                                    C430.607,126.934,464.363,87.021,445.355,67.036z"/>
                                                </svg>

                                                    </div>
                                                    <div class="loc-icon-destination">
                                                        <svg version="1.1" class="site-main-text-color"
                                                             id="Layer_1"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                             y="0px"
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
                                                <span class="flight-type iranB "><?php echo $PTicket['PFlightType'] ?></span>
                                                <span class="sit-class iranL "><?php echo functions::Xmlinformation("Economics"); ?></span>
                                                <span class="source" style="color: white;display:inline-block;">reservation</span>


                                            </div>
                                        </div>

                                        <div class="airlines-info destination txtRight">

                                             <span class="iranB txt18"><?php
                                                 $Arrival = functions::NameCityForeign($PTicket['PArrivalParentRegionName']);
                                                 echo $Arrival[functions::changeFieldNameByLanguage('DepartureCity')];
                                                 ?></span>
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
                                                   id="loader_check_<?php echo $PTicket['ID']; ?>"
                                                   style="display:none"></a>

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
                                                <input type="hidden"
                                                       id="FlightDirection<?php echo $PTicket['ID']; ?>"
                                                       name="FlightDirection<?php echo $PTicket['ID']; ?>"
                                                       value="<?php echo $direction ?>">
                                                <input type="hidden" id="MultiWay<?php echo $PTicket['ID']; ?>"
                                                       name="MultiWay<?php echo $PTicket['ID']; ?>"
                                                       value="<?php echo $MultiWay ?>">
                                                <input type="hidden"
                                                       id="typeApplication<?php echo $PTicket['ID']; ?>"
                                                       name="typeApplication<?php echo $PTicket['ID']; ?>"
                                                       value="reservation">
                                                <input type="hidden" id="CurrencyCode<?php echo $PTicket['ID']; ?>"
                                                       name="CurrencyCode<?php echo $PTicket['ID']; ?>"
                                                       value="<?php echo Session::getCurrency() ?>"
                                                       class="CurrencyCode">


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
                                            <span class="iranB  lh25 displayb txtRight">
                                                <i class="fa fa-circle site-main-text-color "></i> <?php echo functions::Xmlinformation("Flight"); ?> <?php echo functions::NameCity($PTicket['PDepartureParentRegionName']) ?>
                                                <?php echo functions::Xmlinformation("On"); ?> <?php
                                                $Arrival = functions::NameCityForeign($PTicket['PArrivalParentRegionName']);
                                                echo $Arrival[functions::changeFieldNameByLanguage('DepartureCity')];
                                                ?>
                                            </span>

                                                    <div class=" international-available-airlines-detail  site-border-right-main-color">

                                                        <div class="international-available-airlines-logo-detail logo-airline-ico">
                                                        </div>

                                                        <div class="international-available-airlines-info-detail ">
                                                            <span class="iranL  displayib"><?php echo $this->AirPlaneType($PTicket['PAircraft']) ?></span>
                                                            <span class="iranL  displayib fltl"><?php echo $PTicket['Hour'] . ':' . $PTicket['Minutes']; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="international-available-airlines-detail   site-border-right-main-color">

                                                        <div class="airlines-detail-box ">

                                                        <span class="padt0 iranb  lh18 displayb"><?php echo functions::Xmlinformation("Permissibleamount"); ?>
                                                            : <i
                                                                    class="iranNum">20 <?php echo functions::Xmlinformation("Kilograms"); ?></i> </span>
                                                            <span class="padt0 iranL  lh18 displayb"><?php echo functions::Xmlinformation("Kilograms"); ?>
                                                                : <i
                                                                        class="openL"> <?php echo $PTicket['PFlightNo'] ?> </i> </span>
                                                            <span class="padt0 iranL  lh18 displayb"><?php echo functions::Xmlinformation("Classrate"); ?>
                                                                : <i
                                                                        class="openL"><?php echo $PTicket['PCabinType'] ?> </i> </span>

                                                        </div>

                                                        <div class="airlines-detail-box ">


                                                            <span class="iranB txt15 displayb"><?php echo $this->format_hour($PTicket['PDepartureTime']) ?> </span>
                                                            <span class="iranL  displayb"><?php echo $PTicket['PPersianDepartureDate'] ?></span>
                                                            <span class="iranL  displayb"><?php $Departure = functions::NameCityForeign($PTicket['PDepartureParentRegionName']);
                                                                echo $Departure[functions::changeFieldNameByLanguage('DepartureCity')]; ?></span>

                                                        </div>

                                                        <div class="airlines-detail-box ">

                                                            <span class="iranB txt15 displayb"><?php echo $this->getTimeArrival($PTicket['Hour'], $PTicket['Minutes'], $PTicket['PDepartureTime']) ?> </span>
                                                            <span class="iranL  displayb"><?php echo $PTicket['PArrivalDate'] ?></span>
                                                            <span class="iranL  displayb"><?php $Arrival = functions::NameCityForeign($PTicket['PArrivalParentRegionName']);
                                                                echo $Arrival[functions::changeFieldNameByLanguage('DepartureCity')];
                                                                ?></span>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <div id="tab-2-<?php echo $i; ?>"
                                                 class="tab-content price-Box-Tab">
                                                <p class="iranL  lh25 displayb">
                                                    <?php
                                                    $cancelingParam = array('CabinType' => $PTicket['PCabinType'], 'AdtPrice' => $PTicket['PAdtPrice'], 'PriceWithDiscount' => $PTicket['PriceWithDiscount'], 'ChdPrice' => $PTicket['PChdPrice'], 'ChdPriceWithDiscount' => $PTicket['PChdPriceWithDiscount'], 'InfPrice' => $PTicket['PInfPrice'], 'InfPriceWithDiscount' => $PTicket['PInfPriceWithDiscount']);
                                                    $resultReservationTicket->infoTicketForPopup($cancelingParam);
                                                    ?>
                                                </p>
                                            </div>
                                            <div id="tab-3-<?php echo $i; ?>" class="tab-content">
                                                <p class="iranL  lh25">
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
                                                <div class="text_div_morei site-main-text-color iranM "><?php echo functions::Xmlinformation('Yourpurchasepoints'); ?> : <?php echo $pointClub; ?> <?php echo functions::Xmlinformation('Point'); ?> </div>
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

        echo $PrintPrivateTicket = ob_get_clean();
    }

#endregion

    //region detailTicketForeign
    public function detailTicketForeign($param)
    {

        $fileDirect = LOGS_DIR . 'cashFlight/' . $param['param']['uniqueCode'] . '.txt';
        $strJsonFileContents = file_get_contents($fileDirect);
        $strJsonFileContents = json_decode($strJsonFileContents, true);

        foreach ($strJsonFileContents as $keyDetailTicket => $ticket) {

            if ($ticket['FlightID'] == $param['param']['FlightID']) {
                ob_start(); ?>

                <div class="international-available-airlines-detail-tittle">
                <span class="iranB  lh25 displayb txtRight">
                    <i class="fa fa-circle site-main-text-color "></i><?php echo functions::Xmlinformation("Wentflight") ?>
                </span>
                    <?php  foreach ($ticket['OutputRoutes'] as $key => $route) {
                        if (substr($route['transit'], 0, 7) != "0:00:00" && !empty($route['transit'])) { ?>
                            <div class="international-available-airlines-detail airlines-stops-time  ">
                                                                    <span class="iranB  lh25 displayib txtRight">

                                                                        <span class=" iranb  lh18 displayib"> <?php echo functions::Xmlinformation("Stopat") ?>
                                                                            :</span>
                                                                        <span class="open  displayib"><?php
                                                                            $DepartureRoute = functions::NameCityForeign($route['Departure']['Code']);

                                                                            echo $DepartureRoute[functions::changeFieldNameByLanguage('DepartureCity')] . '(' . $DepartureRoute[functions::changeFieldNameByLanguage('Airport')] . ')' ?></span>
                                                                    </span>
                                <span class="open  lh25 displayib fltl">
                                                                        <?php $Transit = explode(':', $route['transit']);
                                                                        echo (($Transit[0] > '0') ? $Transit[0] . functions::Xmlinformation("Day") . ' ' . functions::Xmlinformation("And") : ' ') . $Transit[1] . ' ' . functions::Xmlinformation("Hour") . ' ' . functions::Xmlinformation("And") . ' ' . $Transit[2] . functions::Xmlinformation("Minutes");
                                                                        ?>
                                                                    </span>

                            </div>

                        <?php } ?>

                        <div class=" international-available-airlines-detail  site-border-right-main-color">

                            <div class="international-available-airlines-logo-detail">
                                <img height="30" width="30"
                                     src="<?php echo functions::getAirlinePhoto($route['Airline']['Code']); ?>"
                                     alt="<?php echo $route['Airline']['Code'] ?>"
                                     title="<?php echo $route['Airline']['Code'] ?>">
                            </div>

                            <div class="international-available-airlines-info-detail side-logo-detail">
                                <!--                                                                <span class="openB airline-name-detail  displayib">Airline Name</span>-->

                                <span class="airline_s">
                                    <i>
                                    <?php echo functions::Xmlinformation("Airline") ?> :
                                        </i>
                                    <?php
                                    $Airline = functions::InfoAirline($route['Airline']['Code']);
                                    echo functions::Xmlinformation(functions::Xmlinformation("Airline")) . ' ' . $Airline[functions::ChangeIndexNameByLanguage(SOFTWARE_LANG, 'name', '_fa')]; ?>
                               <em>-</em>
                                </span>

                                <span class="flightnumber_s">
                                    <i><?php echo functions::Xmlinformation("Numflight") ?>
                                    : </i><?php echo $route['FlightNo'] ?>
                                    <em>-</em>
                                </span>
                                <span class="seatClass_s">
                                    <?php echo ($ticket['SeatClass'] == 'B' || $ticket['SeatClass'] == 'C') ? functions::Xmlinformation("Business") : functions::Xmlinformation("Economics"); ?>
                                <em>-</em>
                                </span>

                                <span class="capacity_s ">

                                    <?php echo functions::Xmlinformation('Capacity') . ' : ' . (($ticket['SourceId'] == '1') ? '' : (($ticket['Capacity'] >= '10' ? '+10' : $ticket['Capacity']) . functions::Xmlinformation("People")));
                                                                        ?>
                                                                    </span>
                            </div>
                        </div>

                        <div class="international-available-airlines-detail   site-border-right-main-color">

                            <div class="airlines-detail-box-foreign origin-detail-box">

                                <span class="open  displayb"><?php

                                    $DepartureRoute = functions::NameCityForeign($route['Departure']['Code']);
                                    echo $DepartureRoute[functions::changeFieldNameByLanguage('DepartureCity')] ?></span>
                                <span class="open  displayb"><?php echo $DepartureRoute[functions::changeFieldNameByLanguage('Airport')] ?></span>

                                <span class="openB  displayb">
                                   <i> <?php echo functions::Xmlinformation("RunTime") ?>:</i>

                                    <?php
                                     $dateToMiladiDeparture = date_create($route['DepartureDate']);

                                     $dateLetter = date_format($dateToMiladiDeparture, "jM"); ?>

                                    ( <?php echo $dateLetter ?>)
                                    <?php echo $this->format_hour($route['DepartureTime']) ?> - <?php echo functions::ConvertDateByLanguage(SOFTWARE_LANG, functions::convertDateFlight($route['DepartureDate']), '/') ?>

                                       </span>

                            </div>

                            <div class="airlines-detail-box-foreign destination-detail-box">
                                <span class="open  displayb"><?php $DepartureRoute = functions::NameCityForeign($route['Arrival']['Code']);
                                    echo $DepartureRoute[functions::changeFieldNameByLanguage('DepartureCity')] ?></span>
                                <span class="open  displayb"><?php echo $DepartureRoute[functions::changeFieldNameByLanguage('Airport')] ?></span>
                                <span class="openB  displayb"> <i><?php
                                    if ($ticket['SourceId'] != '8') {

                                        echo functions::Xmlinformation("ArrivingTime") .':'?>
                                        </i>
                                        <?php $dateToMiladiDeparture = date_create($route['ArrivalDate']);

                                        $dateLetter = date_format($dateToMiladiDeparture, "jM");
                                             ?>

                                        ( <?php echo $dateLetter ?>)
                                        <?php echo substr($route['ArrivalTime'], 0, 5)
                                            . ' - ' .
                                            functions::ConvertDateByLanguage(SOFTWARE_LANG, functions::convertDateFlight($route['ArrivalDate']), '/');

                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="airlines-detail-box details-detail-box ">
                                <span class="w-100">
                                    <?php echo functions::Xmlinformation("Permissibleamount") ?>
                                    :  <i class="iranNum"><?php echo functions::baggageTitle($ticket, $route) ?></i>
                                </span>

                                <span class="w-100">
                                     <?php if(!empty( $route['CabinType'])){?>
                                    <?php echo functions::Xmlinformation("Classrate") ?>
                                    :  <i class="openL"><?php echo $route['CabinType'] ?> </i>
                                     <?php } ?>
                                </span>

                                <span class="w-100">
                              <!--  <?php /*echo functions::Xmlinformation('Typeairline'); */ ?>
                                    :
                                <i class="openL"><?php /*echo !empty($ticket['Aircraft']) ? $ticket['Aircraft']: functions::Xmlinformation('Unknown') */ ?>
                                </i>-->
                            </span>

                            </div>
                        </div>


                    <?php } ?>
                </div>
                <?php if (!empty($ticket['ReturnRoutes'])) { ?>
                    <!--شروع نمایش جزئیات پرواز برگشت-->
                    <div class="international-available-airlines-detail-tittle border-solid">
                                                    <span class="iranB  lh25 displayb txtRight">
                                                        <i class="fa fa-circle site-main-text-color "></i> <?php echo functions::Xmlinformation("Returnflight") ?>
                                                    </span>
                        <?php foreach ($ticket['ReturnRoutes'] as $key => $route) {

                            if (substr($route['transit'], 0, 7) != "0:00:00" && !empty($route['transit'])) { ?>
                                <div class="international-available-airlines-detail airlines-stops-time  ">
                                    <span class="iranB  lh25 displayib txtRight">
                                        <span class=" iranb  lh18 displayib"> <?php echo functions::Xmlinformation("Stopat") ?>:</span>
                                        <span class="open  displayib"><?php
                                            $DepartureRoute = functions::NameCityForeign($route['Departure']['Code']);
                                            echo $DepartureRoute[functions::changeFieldNameByLanguage('DepartureCity')] ?></span>
                                    </span>
                                    <span class="open  lh25 displayib fltl">
                                        <?php $Transit = explode(':', $route['transit']);
                                        echo ($Transit[0] > '0') ? $Transit[0] . functions::Xmlinformation("Day") . ' ' . functions::Xmlinformation("And") : ' ' . $Transit[1] . ' ' . functions::Xmlinformation("Hour") . ' ' . functions::Xmlinformation("And") . ' ' . $Transit[2] . functions::Xmlinformation("Minutes");
                                        ?>
                                    </span>

                                </div>

                            <?php } ?>

                            <div class=" international-available-airlines-detail  site-border-right-main-color">

                                <div class="international-available-airlines-logo-detail">
                                    <img height="30" width="30"
                                         src="<?php echo functions::getAirlinePhoto($route['Airline']['Code']); ?>"
                                         alt="<?php echo $route['Airline']['Code'] ?>"
                                         title="<?php echo $route['Airline']['Code'] ?>">
                                </div>

                                <div class="international-available-airlines-info-detail side-logo-detail">
                                    <!--                                                                <span class="openB airline-name-detail  displayib">Airline Name</span>-->
                                    <span class="openB airline-name-detail  displayib"><?php echo functions::Xmlinformation("Airline") ?>
                                        :<?php $Airline = functions::InfoAirline($route['Airline']['Code']);
                                        echo $Airline['name_fa'] ?> </span>-
                                    <span class="iranL  displayib"><?php echo functions::Xmlinformation("Numflight") ?>
                                        : <?php echo $route['FlightNo'] ?></span>-
                                    <span class="iranL  displayib"><?php echo ($ticket['SeatClass'] == 'B' || $ticket['SeatClass'] == 'C') ? 'بیزینس' : 'اکونومی'; ?></span>-
                                    <span class="iranL  displayib">
                                                                        <?php echo functions::Xmlinformation('Capacity') . ' : ' . (($ticket['SourceId'] == '1') ? '' : (($ticket['Capacity'] >= '10' ? '+10' : $ticket['Capacity']) . functions::Xmlinformation("People")));
                                                                        ?>
                                                                    </span>
                                </div>
                            </div>

                            <div class="international-available-airlines-detail   site-border-right-main-color">

                                <div class="airlines-detail-box origin-detail-box">

                                    <span class="open  displayb"><?php $DepartureRoute = functions::NameCityForeign($route['Departure']['Code']);
                                        echo $DepartureRoute[functions::changeFieldNameByLanguage('DepartureCity')] ?></span>
                                    <span class="open  displayb"><?php echo $DepartureRoute[functions::changeFieldNameByLanguage('Airport')] ?></span>
                                    <span class="openB  displayb"><?php echo functions::Xmlinformation("RunTime") ?> : <?php echo $this->format_hour($route['DepartureTime']) ?> - <?php echo functions::ConvertDateByLanguage(SOFTWARE_LANG, functions::convertDateFlight($route['DepartureDate']), '/');
                                        $dateToMiladiDeparture = date_create($route['DepartureDate']);

                                        $dateLetter = date_format($dateToMiladiDeparture, "jM"); ?>

                                    ( <?php  echo $dateLetter ?>)</span>
                                    <!--  <span class="openL  displayb"><?php echo !empty($route['Departure']['City']) ? $route['Departure']['City'] . '-' . $this->NameCityForeign($route['Departure']['Code']) : $this->NameCityForeign($route['Departure']['Code']) ?></span> -->
                                </div>

                                <div class="airlines-detail-box-foreign destination-detail-box">
                                    <span class="open  displayb"><?php $ArrivalRoute = functions::NameCityForeign($route['Arrival']['Code']);
                                        echo $ArrivalRoute[functions::changeFieldNameByLanguage('DepartureCity')] ?></span>
                                    <span class="open  displayb"><?php echo $ArrivalRoute[functions::changeFieldNameByLanguage('Airport')] ?></span>
                                    <span class="openB  displayb"><?php echo functions::Xmlinformation("ArrivingTime") ?> : <?php
                                        if ($ticket['SourceId'] != '8') {
                                            $dateToMiladiDeparture = date_create($route['ArrivalDate']);

                                            $dateLetter = date_format($dateToMiladiDeparture, "jM"); ?>

                                            ( <?php echo $dateLetter ?>)
                                            <?php
                                        }
                                        echo $route['ArrivalTime'] ?> - <?php


                                        echo functions::ConvertDateByLanguage(SOFTWARE_LANG, functions::convertDateFlight($route['ArrivalDate']), '/');

                                        ?></span>
                                    <!--   <span class="open  displayb"></span> -->

                                    <!--    <span class="openL  displayb"><?php echo !empty($route['Arrival']['City']) ? $route['Arrival']['City'] . '-' . $this->NameCityForeign($route['Arrival']['Code']) : $this->NameCityForeign($route['Arrival']['Code']) ?></span> -->
                                </div>

                                <div class="airlines-detail-box details-detail-box ">
                                                            <span class="padt0 iranb  lh18 displayb"><?php echo functions::Xmlinformation("Permissibleamount") ?>
                                                                :  <i class="iranNum"><?php echo(empty($route['Baggage']) ? functions::Xmlinformation('NoBaggage') : (($route['Baggage'][0]['Code'] == 'Piece') ? functions::StrReplaceInXml(['@@numberPiece@@' => $route['Baggage'][0]['allowanceAmount'], '@@amountPiece@@' => $route['Baggage'][0]['Charge']], 'AmountBaggage') : $route['Baggage'][0]['Charge'] . functions::Xmlinformation("Kg"))); ?></i> </span>
                                    <span class="padt0 iranL  lh18 displayb"><?php echo functions::Xmlinformation("Classrate") ?>
                                        :  <i
                                                class="openL"><?php echo $route['CabinType'] ?> </i> </span>
                                    <span class="padt0 iranb  lh18 displayb"></span>
                                </div>
                            </div>


                        <?php } ?>
                    </div>
                    <!--پایان نمایش جزئیات پرواز برگشت-->
                <?php } ?>

                <?php
                return $PrintTicket = ob_get_clean();
            }

        }
    }
    //endregion
}