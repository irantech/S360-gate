<div class="international-available-item-left-Cell my-slideup">
    <div class="inner-avlbl-itm ">
        <div class="">
        <span class="iranL priceSortAdt">
            <?php
            $PriceCalculated = functions::setPriceChanges($ticket['Airline'], $ticket['FlightType_li'], $ticket['AdtPrice'],$ticket['BasPriceOriginAdt'], 'Portal', 'public',$ticket['SourceId']);
            $PriceCalculated = explode(':', $PriceCalculated);
            $MainPriceCurrency = functions::CurrencyCalculate($PriceCalculated[1]);
            $floatMom = (Session::getCurrency() >  0) ? 2 : 0 ;
           

            if ($PriceCalculated[2] == 'YES') {
                $PriceWithDiscount = functions::CurrencyCalculate($PriceCalculated[0]);
                ?>
                <i class="iranB text-decoration-line displayb CurrencyCal"
                   data-amount="<?php echo round($PriceCalculated[1]); ?>">
                    <?php echo number_format($MainPriceCurrency['AmountCurrency'],$floatMom) ?>
                </i>
                <i class="iranB site-main-text-color-drck CurrencyCal"
                   data-amount="<?php echo round($PriceCalculated[0]); ?>">
                    <?php echo number_format($PriceWithDiscount['AmountCurrency'],$floatMom); ?>
                </i>
                <span class="CurrencyText">
                    <?php echo $PriceWithDiscount['TypeCurrency'] ?>
                </span>
            <?php } else { ?>
                <i class="iranB site-main-text-color-drck CurrencyCal"
                   data-amount="<?php echo round($PriceCalculated[1]); ?>">
                    <?php echo number_format($MainPriceCurrency['AmountCurrency'],$floatMom) ?>
                </i>
                <span class="CurrencyText">
                    <?php echo $MainPriceCurrency['TypeCurrency'] ?>
                </span>
            <?php } ?>

        </span>
        <span class="iranL txtHiddenPrice">
            <?php echo 'original=>' . number_format($ticket['OriginalSource']) . '<br/>total=>' . number_format($ticket['TotalSource']) . '<br/>provider=>' . $ticket['Description']  ?>
        </span>
        <div class="SelectTicket">
            <a class="international-available-btn site-bg-main-color site-main-button-color-hover nextStepclass"
               id="nextStep_<?php echo str_replace('#', '', $ticket['FlightID']) . $ticket['ReturnFlightID'] ?>">


                <?php echo $dataArrayFlight['Selectionflight']; ?>
            </a>

            <!--<a class="s-u-select-flight s-u-select-flight1-change">رزرو</a>-->
            <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
            <a href="" onclick="return false" class="f-loader-check f-loader-check-change"
               id="loader_check_<?php echo str_replace('#', '', $ticket['FlightID']) ?>" style="display:none"></a>
            <input type="hidden" value="<?php echo Session::getCurrency() ?>" class="CurrencyCode">
            <input type="hidden" value="<?php echo $ticket['FlightID'] ?>" class="FlightID">
            <input type="hidden" value="<?php echo $ticket['ReturnFlightID'] ?>" class="ReturnFlightID">
            <input type="hidden" value="<?php echo $ticket['AdtPrice'] ?>" class="AdtPrice">
            <input type="hidden" value="<?php echo $ticket['ChdPrice'] ?>" class="ChdPrice">
            <input type="hidden" value="<?php echo $ticket['InfPrice'] ?>" class="InfPrice">
            <input type="hidden" value="<?php echo $ticket['CabinType'] ?>" class="CabinType">
            <input type="hidden" value="<?php echo $ticket['Airline'] ?>" id="Airline_Code" class="Airline_Code">
            <input type="hidden" value="<?php echo isset($ticket['SourceId']) ? $ticket['SourceId'] : '' ?>" id="SourceId" class="SourceId">
            <input type="hidden" value="<?php echo $ticket['FlightType_li'] ?>" id="FlightType" class="FlightType">
            <input type="hidden" value="<?php echo $ticket['UniqueCode'] ?>" id="uniqueCode" class="uniqueCode">
            <input type="hidden" value="<?php echo number_format($ticket['AdtPrice']) ?>" id="priceWithoutDiscount" class="priceWithoutDiscount">
            <input type="hidden" value="<?php echo functions::checkConfigPid($ticket['Airline'],'external',$ticket['FlightType_li']) ?>" id="PrivateM4" class="priceWithoutDiscount">
            <input type="hidden" value="<?php echo $ticket['Capacity'] ?>" id="Capacity" class="priceWithoutDiscount">
            <input type="hidden" value="<?php echo 'dept' ?>" class="FlightDirection">

        </div>
        </div>
    </div>
</div>