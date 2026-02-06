<?php
$cancelingParam = array('CabinType' => $ticket['CabinType'], 'AdtPrice' => $ticket['AdtPrice'], 'ChdPrice' => $ticket['ChdPrice'], 'InfPrice' => $ticket['InfPrice'], 'Airline' => $ticket['Airline'], 'FlightType' => $ticket['FlightType_li'], 'CounterId' => isset($InfoCounter['id']) ? $InfoCounter['id'] : '5', 'SourceId' => $ticket['SourceId']);
$jsonData = json_encode($cancelingParam);
//                    functions::cancelingRules($cancelingParam);
?>
<div class="international-available-details">
    <div>
        <div class=" international-available-panel-min">
            <ul class="tabs">
                <li class="tab-link current site-border-top-main-color " data-tab="tab-1-<?php echo $i; ?>">
                    <?php echo $dataArrayFlight['Informationflight']; ?>
                </li>
                <li class="tab-link site-border-top-main-color detailShow" data-tab="tab-2-<?php echo $i; ?>" InfoTab='<?php echo $jsonData?>' counterTab="<?php echo $i ;?>">
                    <?php echo $dataArrayFlight['CancellationPrice']; ?>
                </li>
                <li class="tab-link site-border-top-main-color" data-tab="tab-3-<?php echo $i; ?>">
                    <?php echo $dataArrayFlight['TermsandConditions']; ?>
                </li>
            </ul>

            <div id="tab-1-<?php echo $i; ?>"
                 class="tab-content current">
                <div class="international-available-airlines-detail-tittle">
                    <span class="iranB txt13 lh25 displayb txtRight">
                        <i class="fa fa-circle site-main-text-color txt12"></i>
                        <?php echo $dataArrayFlight['Flight']; ?>
                        <?php echo $ticket['DepartureCity'] ?>
                        <?php echo $dataArrayFlight['On']; ?>
                        <?php echo $ticket['ArrivalCity'] ?>
                    </span>

                    <div class=" international-available-airlines-detail  site-border-right-main-color">

                        <div class="international-available-airlines-logo-detail logo-airline-ico"></div>

                        <div class="international-available-airlines-info-detail my-info-detail">
                            <span class="iranL txt13 displayib">
                                <?php echo $dataArrayFlight['Typeairline'].':'; ?>
                               <?php echo !empty($ticket['Aircraft']) ? $ticket['Aircraft']: $dataArrayFlight['Unknown'] ?>

                            </span>
                            <span class="my-seperator"> | </span>
                            <span class="iranL txt13 displayib fltl">
                                <?php echo $dataArrayFlight['Flighttime']; ?> :
                                <?php echo $ArrivalTime['Hour'] . ':' . $ArrivalTime['Minutes'] ?>
                            </span>
                        </div>
                    </div>

                    <div class="international-available-airlines-detail   site-border-right-main-color">

                        <div class="airlines-detail-box ">

                            <span class="padt0 iranb txt12 lh18 displayb">
                                <?php echo $dataArrayFlight['Permissibleamount']; ?>:
                                <i class="iranNum"><?php echo ($ticket['SeatClassEn']=='business') ? '40' : '20'?>
                                    <?php echo $dataArrayFlight['Kilograms']; ?>
                                </i>
                            </span>
                            <span class="padt0 iranL txt12 lh18 displayb">
                                <?php echo $dataArrayFlight['Numflight']; ?>:
                                <i class="openL">
                                    <?php echo $ticket['FlightNo'] ?>
                                </i>
                            </span>
                            <span class="padt0 iranL txt12 lh18 displayb">
                                <?php echo $dataArrayFlight['Classrate']; ?>
                                :
                                <i class="openL"><?php echo $ticket['CabinType'] ?>
                                </i>
                            </span>


                        </div>

                        <div class="airlines-detail-box ">

                            <span class="iranB txt15 displayb"><?php echo $this->format_hour($ticket['DepartureTime']) ?> </span>
                            <span class="iranL txt13 displayb"><?php echo functions::ConvertDateByLanguage(SOFTWARE_LANG,$ticket['PersianDepartureDate']);?></span>
                            <span class="iranL txt13 displayb"><?php echo $ticket['DepartureCity'] ?></span>

                        </div>

                        <div class="airlines-detail-box ">

                            <span class="iranB txt15 displayb"><?php echo $ArrivalTime['time'] ?> </span>
                            <span class="iranL txt13 displayb"><?php echo functions::ConvertDateByLanguage(SOFTWARE_LANG,$ticket['ArrivalDate']);?></span>
                            <span class="iranL txt13 displayb"><?php echo $ticket['ArrivalCity'] ?></span>

                        </div>

                    </div>

                </div>
            </div>

            <div id="tab-2-<?php echo $i; ?>" class="tab-content price-Box-Tab" >
                    <img style="width: 30px;" id="tab-2-<?php echo $i; ?>-loader"
                         src="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/view/client/assets/images/load21.gif">
                <p class="iranL txt13 lh25 displayb">
                </p>
            </div>
            <div id="tab-3-<?php echo $i; ?>" class="tab-content">
                <p class="iranL txt13 lh25 displayb">
                <ul>
                    <li>
                        1- <?php echo $dataArrayFlight['AccordingCivilAviation']; ?>
                    </li>
                    <li>
                        2- <?php echo $dataArrayFlight['ResponsibilityAllTravel']; ?>
                    </li>
                    <li>
                        3- <?php echo $dataArrayFlight['MustEnterValidMobileNecessary']; ?>
                    </li>
                    <li>
                        4- <?php echo $dataArrayFlight['AviationRegulationsBabyChildAdultAges']; ?>
                    </li>
                    <li>
                        5- <?php echo $dataArrayFlight['CanNotBuyBabyChildTicket']; ?>
                    </li>
                    <li>
                        6- <?php echo $dataArrayFlight['AircraftDetermined']; ?>
                    </li>
                    <li>
                        7- <?php echo $dataArrayFlight['PresenceDomestic']; ?>
                    </li>
                </ul>
                </p>
            </div>

        </div>
    </div>
    <span class="international-available-detail-btn more_1 ">
        <?php
        if (Session::IsLogin()) {
            $counterId = functions::getCounterTypeId($_SESSION['userId']);
            $resultPointClub = functions::InfoAirline($ticket['Airline']);
            $checkPrivate = functions::checkConfigPid($ticket['Airline'],'internal',$ticket['FlightType_li']);
            $typeService = functions::TypeService($ticket['FlightType_li'], 'Local', strtolower($ticket['FlightType_li']) == 'system' ? '' : 'public', $checkPrivate, $ticket['Airline']);
            $param['service'] = $typeService;
            $param['baseCompany'] = $resultPointClub['id'];
            $param['company'] = $ticket['FlightNo'];
            $param['counterId'] = $counterId;
            if ($PriceCalculated[2] == 'YES') {
                $param['price'] = $PriceCalculated[0];
            }else{
                $param['price'] = $PriceCalculated[1];
            }
            $pointClub = functions::CalculatePoint($param);
            if ($pointClub > 0) {
                ?>
                <div class="text_div_morei site-main-text-color iranM txt12"><?php echo functions::Xmlinformation('Yourpurchasepoints'); ?> : <?php echo $pointClub; ?> <?php echo functions::Xmlinformation('Point'); ?></div>
                <?php
            }
        }
        ?>

        <div class="my-more-info slideDownAirDescription">
            <?php echo $dataArrayFlight['MoreDetails']; ?>
            <i class="fa fa-angle-down"></i>
        </div>
    </span>
    <span class="international-available-detail-btn  slideUpAirDescription displayiN">

        <i class="fa fa-angle-up site-main-text-color"></i>
    </span>
</div>