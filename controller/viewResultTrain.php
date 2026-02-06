<?php
/**
 * Class viewResultTrain
 * @property viewResultTrain $viewResultTrain
 */
class viewResultTrain extends resultTrainApi
{
    public function dataAjaxTrain($params)
    {

  /*      if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'indobare.com') !== false)) {

            echo json_encode($params['result']);

        }*/
        $textTrain = $this->textTrain();
        ob_start();
        ?>
        <form action="#" method="post" id="TrainFormHidden"
              name="TrainFormHidden">
            <input type="hidden" name="serviceIdBib" id="serviceIdBib" value="">
            <input type="hidden" name="IsCoupe" id="IsCoupe" value="<?php echo $params['Coupe'] ?>">
            <input type="hidden" name="PassengerCount" id="PassengerCount" value="<?php echo $params['passengerCount'] ?>">
            <input type="hidden" name="search_multi_way" id="search_multi_way" value="<?php echo $params['directions'] ?>">
        </form>
        <div class=" s-u-ajax-container">

        <div class="s-u-result-wrapper">

        <?php

        require_once 'Train/sortByTimeAndPrice.php';

        ?>
        <div id="s-u-result-wrapper-ul" class="s-u-result_train">
            <div id="ticketselected" class=" mart10 marb10"></div>


            <?php functions::showConfigurationContents('train_search_advertise','<div class="advertise">','</div>','<div class="image_train_gif">','</div>'); ?>
            
            <!--<div class="image_train_gif">
                <img src="<?php /*echo ROOT_ADDRESS_WITHOUT_LANG */?>/pic/train_gif.gif" alt="">


            </div>-->
        <div class="items" id="route_went">

                <?php

                if(!empty($params['result']))
                {
                    foreach ($params['result'] as $direction => $everyTurn) {
                        foreach ($everyTurn as $key => $ticketTrain) {
                            $key = $key+1 ; ?>
                            <script type="text/javascript">
                                $("#<?php echo $ticketTrain['Owner'] ?>-filter").css("display", "flex");
                            </script>
                            <div class="showListSort">




                                <div class="international-available-box <?php echo functions::classTimeLOCAL(functions::format_hour($ticketTrain['ExitTime'])) ;?>
                            <?php echo ($ticketTrain['TypeRoute'] == 'dept') ? 'deptTrain':'returnTrain'?> "

                                    <?php echo ($ticketTrain['TypeRoute'] == 'dept') ? '':'style="display:none"'?>
                                     id="<?php echo $key ?>-row" data-price="<?php echo $ticketTrain['Cost'] ?>"
                                     data-companytrain="<?php echo $ticketTrain['Owner'] ?>"
                                     data-capacity="<?php echo $ticketTrain['Counting'] ?>"
                                     data-time="<?php echo functions::classTimeLOCAL(functions::format_hour($ticketTrain['ExitTime'])) ?>">

                                    <div class="international-available-item">
                                        <div class="international-available-info">
                                            <div class="international-available-item-right-Cell ">
                                                <?php
                                                $specific = true ;
                                                include 'Train/logoTrain.php';
                                                include 'Train/infoTrain.php';
                                                ?>
                                            </div>
                                            <?php
                                            include 'Train/infoPriceTrain.php';
                                            include 'Train/infoDetailTrain.php';
                                            ?>


                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                    <?php if($ticketTrain['isSpecific']){?>
                                        <div class="ribbon"><span> قطار چارتری  </span></div>
                                    <?php }?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }else{
                    ?>
                    <div class="userProfileInfo-messge ">
                        <div class="messge-login BoxErrorSearch">
                            <div style="float: right;"><i
                                        class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                            </div>
                            <div class="TextBoxErrorSearch">

                                <?php echo functions::Xmlinformation('Noresult') ?><br/>
                                <?php echo functions::Xmlinformation('Changeserach') ?>


                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>



        </div>
        </div>
        <!-- modal -->
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


            $(document).ready(function () {
                $('body').delegate('.DetailSelectTicket', 'click', function () {
                    $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
                });


                $( ".currency-gds" ).click(function() {
                    $('.change-currency').toggle();
                    if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                        $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
                    } else {
                        $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
                    }
                });
            });

            $(function () {

                var minPrice = parseInt('<?php echo $params['minPrice'] ?>'),
                maxPrice = parseInt('<?php echo $params['maxPrice'] ?>');
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
                        filterBusPrice();

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

                function filterBusPrice() {
                    $(".international-available-box").hide().filter(function () {
                        return filterSlider(this);
                    }).show();
                }

            });



            <!-- loader -->
        </script>
        <script>
            $(window).load(function(){
                $(".loader-section").hide();
                $("#resultFake").hide();
                $(".items").css("display","block");
            });
        </script>
        <?php
        return $PrintPrivateTicket = ob_get_clean();
    }

    public function textTrain()
    {
        $dataFlight['Previousday'] = functions::Xmlinformation("Previousday");
        $dataFlight['Pricesort'] = functions::Xmlinformation("Pricesort");
        $dataFlight['Timesort'] = functions::Xmlinformation("Timesort");
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


        return $dataFlight;
    }


}