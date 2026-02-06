<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 3/4/2019
 * Time: 7:49 PM
 */

class flightInternalFake
{

    public function __construct()
    {

    }


    public function DataAjaxSearchFake($tickets, $flightNumber = null)
    {
        ob_start();
        $i = 0;
        ?>
        <div class=" s-u-ajax-container ResultFake">
            <div class="s-u-result-wrapper">


                <?php
                if ($flightNumber == '') {
                    ?>
                    <div class="sorting2">
                        <div class="sorting-inner date-change iranL prev">
                            <a class="prev-date" onclick="return false">
                                <i class="zmdi zmdi-chevron-right iconDay "></i>
                                <span><?php echo functions::Xmlinformation("Previousday") ?></span>
                            </a>
                        </div>
                        <div class="sorting-inner price sorting-active-color-main">
                    <span class="svg">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26"
                             xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
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

                        <div class="sorting-inner time">
                    <span class="svg">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26"
                             xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                          <g>
                            <path d="M11,3H1C0.4,3,0,3.4,0,4v2c0,0.6,0.4,1,1,1h10c0.6,0,1-0.4,1-1V4C12,3.4,11.6,3,11,3z"/>
                            <path d="m11,11h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                            <path d="m11,19h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"/>
                            <path d="m25.7,15.3l-1.4-1.4c-0.2-0.2-0.5-0.3-0.7-0.3-0.3,0-0.5,0.1-0.7,0.3l-2,2c-0.3,0.3-0.9,0.1-0.9-0.4v-13.5c0-0.5-0.5-1-1-1h-2c-0.5,0-1,0.5-1,1v22c0,0.3 0.1,0.5 0.3,0.7s0.5,0.3 0.7,0.3c0.3,0 0.5-0.1 0.7-0.3l8-8c0.2-0.2 0.3-0.4 0.3-0.7 0-0.3-0.1-0.5-0.3-0.7z"/>
                          </g>
                        </svg>
                    </span>
                            <span class="text-price-sort iranL"><?php echo functions::Xmlinformation("BaseStartTime") ?></span>
                            <input type="hidden" value="desc" name="currentTimeSort" id="currentTimeSort">
                        </div>

                        <div class="sorting-inner date-change iranL next">
                            <a class="next-date" onclick="return false">
                                <span><?php echo functions::Xmlinformation("Nextday") ?></span>
                                <i class="zmdi zmdi-chevron-left iconDay "></i>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>


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

                <ul id="s-u-result-wrapper-ul" style="filter: blur(3px);">
                    <div class="selectedTicket mart10 marb10"></div>

                    <div class="items">
                        <?php
                        $i = 0.8;
                        foreach ($tickets as $ticket) {

                            if ($ticket['Type'] == 'local') {
                                $i += 0.8;
                            } else {
                                $DelayArray = array(0.8, 0.9, 1, 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7);
                                $i += array_rand($DelayArray);
                            }


                            ?>

                            <!-- گرفتن بلیطهای موجود -->
                            <div class="showListSort fakelist"
                                 style="animation-duration: 0.8s; animation-delay: <?php echo $i ?>s;">
                                <div class="international-available-box">
                                    <div class="international-available-item ">
                                        <div class="international-available-info">
                                            <div class="international-available-item-right-Cell ">
                                                <div class=" international-available-airlines  ">
                                                    <div class="international-available-airlines-logo">
                                                        <img height="50" width="50"
                                                             src="<?php echo functions::getAirlinePhoto($ticket['Airline']) ?>"
                                                             alt="<?php echo $ticket['Airline'] ?>"
                                                             title="<?php echo $ticket['Airline'] ?>">
                                                    </div>

                                                    <div class="international-available-airlines-log-info">
                                                        <span class="iranM txt12"><?php echo functions::Xmlinformation("Numflight") ?>
                                                            : <?php echo $ticket['FlightNo'] ?></span>
                                                        <span class="sandali-span2 iranL txt10"><?php echo $ticket['Capacity'] ?>
                                                            <?php echo functions::Xmlinformation("Chair") ?></span>
                                                    </div>
                                                </div>

                                                <div class="international-available-airlines-info ">
                                                    <div class="airlines-info destination txtLeft">

                                                        <span class="iranB txt18"><?php echo $ticket['DepartureCity'] ?></span>
                                                        <span class="iranM txt19 timeSortDep"><?php echo functions::format_hour($ticket['DepartureTime']) ?></span>

                                                    </div>

                                                    <div class="airlines-info">
                                                        <div class="airlines-info-inner">
                                                        <span class="iranL txt12">
                                                        <?php
                                                        $dateFlight = functions::NewFormatDate($ticket['DepartureDate']);
                                                        echo $dateFlight['day'] . ' ,' . $dateFlight['date_now'];
                                                        ?>
                                                        </span>
                                                            <div class="airline-line">
                                                                <div class="loc-icon">
                                                                    <svg version="1.1" class="site-main-text-color"
                                                                         id="Layer_1"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         x="0px"
                                                                         y="0px"
                                                                         width="32px"
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

                                                                <div class="plane-icon">
                                                                    <svg version="1.1" id="Capa_1"
                                                                         xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         x="0px"
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
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         x="0px"
                                                                         y="0px"
                                                                         width="32px"
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

                                                            </div>

                                                            <span class="flight-type iranB txt13"><?php echo $ticket['FlightType'] ?></span>
                                                            <span class="sit-class iranL txt13"><?php echo $ticket['SeatClass'] ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="airlines-info destination txtRight">
                                                        <span class="iranB txt18"><?php echo $ticket['ArrivalCity'] ?></span>
                                                        <span class="iranM txt19"><?php echo functions::format_hour_arrival($ticket['Origin'], $ticket['Destination'], $ticket['DepartureTime']) ?> </span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="international-available-item-left-Cell">
                                                <?php
                                                $PriceCalculated = functions::setPriceChanges($ticket['Airline'], $ticket['FlightType_li'], $ticket['AdtPrice'], 'Local', strtolower($ticket['FlightType_li']) == 'system' ? '' : 'public');
                                                $PriceCalculated = explode(':', $PriceCalculated);

                                                $MainPriceCurrency = functions::CurrencyCalculate($PriceCalculated[1]);
                                                ?>

                                                <div class="inner-avlbl-itm <?php echo ($PriceCalculated[2] == 'YES') ? 'off-price' : ''; ?>">
                                                    <span class="iranL  priceSortAdt">
														<?php
                                                        if ($PriceCalculated[2] == 'YES') {
                                                            $PriceWithDiscount = functions::CurrencyCalculate($PriceCalculated[0]);

                                                            ?>
                                                            <span class="iranL old-price text-decoration-line CurrencyCal"
                                                                  data-amount="<?php echo $PriceCalculated[1]; ?>"><?php echo functions::numberFormat($MainPriceCurrency['AmountCurrency']) ?></span>
                                                            <i class="iranM site-main-text-color-drck CurrencyCal"
                                                               data-amount="<?php echo $PriceCalculated[0]; ?>"><?php echo functions::numberFormat($PriceWithDiscount['AmountCurrency']); ?></i>
                                                            <span class="CurrencyText"><?php echo $PriceWithDiscount['TypeCurrency'] ?></span>
                                                            <?php
                                                        } else { ?>
                                                            <i class="iranM site-main-text-color-drck CurrencyCal"
                                                               data-amount="<?php echo $PriceCalculated[1]; ?>"><?php echo functions::numberFormat($MainPriceCurrency['AmountCurrency']) ?></i>
                                                            <span class="CurrencyText"><?php echo $MainPriceCurrency['TypeCurrency'] ?></span>
                                                        <?php } ?>
                                                    </span>

                                                    <div>

                                                        <a class="international-available-btn site-bg-main-color  site-main-button-color-hover nextStepclass"
                                                           id="nextStep_<?php echo $ticket['FlightID'] ?>"><?php echo functions::Xmlinformation("Selectionflight") ?></a>


                                                    </div>

                                                </div>


                                            </div>

                                            <div class="clear"></div>
                                        </div>
                                        <div class="international-available-details">

                                            <span class="international-available-detail-btn slideDownHotelDescription">
													<div class="my-more-info"><?php echo functions::Xmlinformation("MoreDetails") ?>
                                                        <i class="fa fa-angle-down"></i></div></span>
                                            <span class="international-available-detail-btn  slideUpHotelDescription displayiN"><i
                                                        class="fa fa-angle-up site-main-text-color"></i></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <?php
                        }
                        ?>
                    </div>
                </ul>
            </div>
        </div>

        <?php
        return $PrintTicket = ob_get_clean();
    }


}
