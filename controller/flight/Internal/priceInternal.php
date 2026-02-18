<?php
$PriceCalculated = functions::setPriceChanges($ticket['Airline'], $ticket['FlightType_li'], $ticket['AdtPrice'],$ticket['BasPriceOriginAdt'], 'Local', strtolower($ticket['FlightType_li']) == 'system' ? '' : 'public',$ticket['SourceId']);
$PriceCalculated = explode(':', $PriceCalculated);

$MainPriceCurrency = functions::CurrencyCalculate($PriceCalculated[1]);

?>
<div class="inner-avlbl-itm <?php echo ($PriceCalculated[2] == 'YES') ? 'off-price' : ''; ?>">
    <div>
    <span class="iranL  priceSortAdt">
        <?php
        if ($PriceCalculated[2] == 'YES') {
            $PriceWithDiscount = functions::CurrencyCalculate($PriceCalculated[0]);
            ?>
            <span class="iranL old-price text-decoration-line CurrencyCal" data-amount="<?php echo $PriceCalculated[1]; ?>">
                <?php echo functions::numberFormat($MainPriceCurrency['AmountCurrency']) ?></span>
            <i cass="iranM site-main-text-color-drck CurrencyCal" data-amount="<?php echo $PriceCalculated[0]; ?>">
                <?php echo functions::numberFormat($PriceWithDiscount['AmountCurrency']); ?>
            </i>
            <span class="CurrencyText"><?php echo $PriceWithDiscount['TypeCurrency'] ?></span>
            <?php
        } else { ?>
            <i class="iranM site-main-text-color-drck CurrencyCal" data-amount="<?php echo $PriceCalculated[1]; ?>">
                <?php echo functions::numberFormat($MainPriceCurrency['AmountCurrency']) ?></i>
            <span class="CurrencyText"><?php echo $MainPriceCurrency['TypeCurrency'] ?></span>
        <?php } ?>
    </span>

    <div class="SelectTicket">
        <?php if ($ticket['Reservable'] == true) { ?>
            <a class="international-available-btn site-bg-main-color  site-main-button-color-hover nextStepclass"
               id="nextStep_<?php echo $ticket['FlightID'] ?>">
                <?php echo(($MultiWay != 'TwoWay') ? $dataArrayFlight['Selectionflight'] : (($direction == 'dept') ? $dataArrayFlight['PickWentFlight'] : $dataArrayFlight['PickBackFlight'])); ?></a>
        <?php } else { ?>
            <a class="international-available-btn site-main-button-color-hover flight-false"><?php echo  $dataArrayFlight['CompletionCapacity']; ?></a>
        <?php } ?>


        <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
        <a href="" onclick="return false" class="f-loader-check f-loader-check-change" id="loader_check_<?php echo $ticket['FlightID'] ?>" style="display:none"></a>
        <input type="hidden" value="<?php echo Session::getCurrency() ?>" class="CurrencyCode">
        <input type="hidden" value="<?php echo $ticket['FlightID'] ?>" class="FlightID">
        <input type="hidden" value="<?php echo $ticket['FlightNo'] ?>" class="FlightNumber">
        <input type="hidden" value="<?php echo $ticket['AdtPrice'] ?>" class="AdtPrice">
        <input type="hidden" value="<?php echo $ticket['ChdPrice'] ?>" class="ChdPrice">
        <input type="hidden" value="<?php echo $ticket['InfPrice'] ?>" class="InfPrice">
        <input type="hidden" value="<?php echo $ticket['CabinType'] ?>" class="CabinType">
        <input type="hidden" value="<?php echo $ticket['Airline'] ?>" class="Airline_Code">
        <input type="hidden" value="<?php echo isset($ticket['SourceId']) ? $ticket['SourceId'] : '' ?>" class="SourceId">
        <input type="hidden" value="<?php echo $ticket['FlightType_li'] ?>" class="FlightType">
        <input type="hidden" value="<?php echo $ticket['UniqueCode'] ?>" class="uniqueCode">
        <input type="hidden" value="<?php echo number_format($PriceCalculated[1]) ?>" class="priceWithoutDiscount">
        <input type="hidden" value="<?php echo functions::checkConfigPid($ticket['Airline'],'internal',$ticket['FlightType_li']) ?>" class="PrivateM4">
        <input type="hidden" value="<?php echo $ticket['Capacity'] ?>" class="Capacity">
        <input type="hidden" value="<?php echo $direction ?>" class="FlightDirection">

        <?php if (IS_ENABLE_TEL_ORDER == '1' && $direction == 'dept'){ ?>

        <div class="tell-sms-btns" style="display: none;">

            <div class="tell-btn-order tooltipSearch">

                <span class="tooltiptext"><?php echo $dataArrayFlight['PhoneNumberToBookings']; ?>:<?php echo CLIENT_PHONE ?></span>
                <svg version="1.1" id="Capa_1"
                     xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink"
                     x="0px"
                     y="0px"
                     viewBox="0 0 512.076 512.076"
                     style="enable-background:new 0 0 512.076 512.076;"
                     xml:space="preserve">

                    <g transform="translate(-1 -1)">

                        <g>
                            <path d="M499.639,396.039l-103.646-69.12c-13.153-8.701-30.784-5.838-40.508,6.579l-30.191,38.818
				c-3.88,5.116-10.933,6.6-16.546,3.482l-5.743-3.166c-19.038-10.377-42.726-23.296-90.453-71.04s-60.672-71.45-71.049-90.453
				l-3.149-5.743c-3.161-5.612-1.705-12.695,3.413-16.606l38.792-30.182c12.412-9.725,15.279-27.351,6.588-40.508l-69.12-103.646
				C109.12,1.056,91.25-2.966,77.461,5.323L34.12,31.358C20.502,39.364,10.511,52.33,6.242,67.539
				c-15.607,56.866-3.866,155.008,140.706,299.597c115.004,114.995,200.619,145.92,259.465,145.92
				c13.543,0.058,27.033-1.704,40.107-5.239c15.212-4.264,28.18-14.256,36.181-27.878l26.061-43.315
				C517.063,422.832,513.043,404.951,499.639,396.039z M494.058,427.868l-26.001,43.341c-5.745,9.832-15.072,17.061-26.027,20.173
				c-52.497,14.413-144.213,2.475-283.008-136.32S8.29,124.559,22.703,72.054c3.116-10.968,10.354-20.307,20.198-26.061
				l43.341-26.001c5.983-3.6,13.739-1.855,17.604,3.959l37.547,56.371l31.514,47.266c3.774,5.707,2.534,13.356-2.85,17.579
				l-38.801,30.182c-11.808,9.029-15.18,25.366-7.91,38.332l3.081,5.598c10.906,20.002,24.465,44.885,73.967,94.379
				c49.502,49.493,74.377,63.053,94.37,73.958l5.606,3.089c12.965,7.269,29.303,3.898,38.332-7.91l30.182-38.801
				c4.224-5.381,11.87-6.62,17.579-2.85l103.637,69.12C495.918,414.126,497.663,421.886,494.058,427.868z"/>
                            <path d="M291.161,86.39c80.081,0.089,144.977,64.986,145.067,145.067c0,4.713,3.82,8.533,8.533,8.533s8.533-3.82,8.533-8.533
				c-0.099-89.503-72.63-162.035-162.133-162.133c-4.713,0-8.533,3.82-8.533,8.533S286.448,86.39,291.161,86.39z"/>
                            <path d="M291.161,137.59c51.816,0.061,93.806,42.051,93.867,93.867c0,4.713,3.821,8.533,8.533,8.533
				c4.713,0,8.533-3.82,8.533-8.533c-0.071-61.238-49.696-110.863-110.933-110.933c-4.713,0-8.533,3.82-8.533,8.533
				S286.448,137.59,291.161,137.59z"/>
                            <path d="M291.161,188.79c23.552,0.028,42.638,19.114,42.667,42.667c0,4.713,3.821,8.533,8.533,8.533s8.533-3.82,8.533-8.533
				c-0.038-32.974-26.759-59.696-59.733-59.733c-4.713,0-8.533,3.82-8.533,8.533S286.448,188.79,291.161,188.79z"/>
                        </g>
                    </g>
                </svg>
            </div>
            <?php }
            if (IS_ENABLE_SMS_ORDER == '1' && $direction == 'dept'){

            $infoRequestTicketArray = array(
                'Origin' => $origin,
                'Destination' => $destination,
                'CabinType' => $ticket['CabinType'],
                'Airline' => $ticket['Airline'],
                'FlightNo' => $ticket['FlightNo'],
                'DepartureTime' => functions::format_hour($ticket['DepartureTime']),
                'DepartureDate' => str_replace('/', '-', $ticket['PersianDepartureDate']),
            );

            $infoRequestTicketJson = functions::clearJsonHiddenCharacters(json_encode($infoRequestTicketArray));
            ?>
            <div class="sms-btn-order">
                <a class="smsRequestTicket" InfoRequest='<?php echo $infoRequestTicketJson ?>' id="smsRequestTicket-<?php echo $ticket['FlightID'] ?>">
                    <svg version="1.1" id="Capa_1"
                         xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         x="0px"
                         y="0px"
                         viewBox="0 0 490 490"
                         style="enable-background:new 0 0 490 490;"
                         xml:space="preserve">
                        <g>
                            <path d="M460.968,141.771C460.968,63.596,397.911,0,320.409,0s-140.56,63.596-140.56,141.771c0,10.753,1.176,21.292,3.451,31.476
		h-74.015c-44.246,0-80.253,36.276-80.253,80.882v75.708c0,44.605,36.007,80.882,80.253,80.882h125.607L333.029,490v-82.616
		c33.615-9.944,57.555-41.181,57.555-77.547V264.85C432.681,240.322,460.968,194.23,460.968,141.771z M359.96,329.837
		c0,25.54-18.916,46.983-44.007,49.899l-13.547,1.57v44.575l-56.688-45.786H109.285c-27.364,0-49.629-22.549-49.629-50.258v-75.708
		c0-27.708,22.265-50.257,49.629-50.257h84.694c8.635,17.815,21.037,33.78,36.726,46.878v88.373l70.489-56.942
		c20.598,2.897,40.458,1.221,58.766-4.143V329.837z M320.409,252.933c-6.669,0-13.607-0.688-20.605-2.034l-6.983-1.331
		l-31.491,25.435v-39.327l-6.146-4.591c-28.411-21.263-44.71-53.816-44.71-89.315c0-61.293,49.316-111.147,109.936-111.147
		s109.936,49.854,109.936,111.147S381.029,252.933,320.409,252.933z"/>
                            <g>
                                <ellipse cx="257.399" cy="137.09" rx="20.54"
                                         ry="20.738"/>
                            </g>
                            <g>
                                <ellipse cx="320.409" cy="137.09" rx="20.54"
                                         ry="20.738"/>
                            </g>
                            <g>
                                <ellipse cx="383.419" cy="137.09" rx="20.54" ry="20.738"/>
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
    <?php } ?>

    </div>
    </div>
</div>
