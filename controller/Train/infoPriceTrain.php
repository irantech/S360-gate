<?php

/** @var TYPE_NAME $ticketTrain['isSpecific'] */
if($ticketTrain['isSpecific'])
    {
        $discountType = 'PrivateTrain';
    }else{
        $discountType = 'Train';
    }
/** @var TYPE_NAME $ticketTrain */

//    $discount= $this->getDiscount($ticketTrain['Cost'],$discountType);
//    $discountPercent = $this->discountTrain($discountType);

//if ((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"], 'indobare.com') !== false)) {
    $userId = !empty($_SESSION['userId']) ? $_SESSION['userId'] : '';
    $counterInfo = functions::infoCounterType($userId);
    $idCompany = functions::getIdCompanyTrainByCode($ticketTrain['Owner']);
    $compareDate = functions::ConvertToJalali(functions::compareDateTrain($ticketTrain['MoveDate'],$ticketTrain['ExitDate']));
    $discountInfo = functions::getDiscountSpecialTrain($discountType,$idCompany,$ticketTrain['TrainNumber'],$counterInfo['id'],$compareDate);
    $discount= $this->getDiscount($ticketTrain['Cost'],$discountInfo['percent']);
//    $discountPercent = $this->discountTrain($discountInfo['percent']);





?>
<div class="international-available-item-left-Cell">
    <div class="inner-avlbl-itm">
        <span class="iranL priceSortAdtTrain">
                <?php if($discountInfo['percent'] > 0)
                   { ?>
                      <span class="dis_percentage"> <?php
                          echo round($discountInfo['percent']).'%';
                          ?></span>
                       <?php }
            if (($ticketTrain['FullPrice']-$ticketTrain['Cost']) > 0){?>

               <span class="iranL old-price text-decoration-line CurrencyCal" data-amount="<?php echo $ticketTrain['FullPrice']?>"><?php echo functions::numberFormat($ticketTrain['FullPrice']) . ' <em>'. functions::Xmlinformation('Rial') . '</em>'; ?> </span>
           <?php } ?>
            <?php if($discount != 0){?>

                <span class="iranL old-price text-decoration-line CurrencyCal" data-amount="<?php echo $ticketTrain['Cost']?>"><?php echo functions::numberFormat($ticketTrain['Cost']). ' '. functions::Xmlinformation('Rial'); ?></span>
            <?php }else{ ?>
            <i class="iranM site-main-text-color-drck CurrencyCal "
               data-amount="<?php echo $ticketTrain['Cost']?>"><?php echo functions::numberFormat($ticketTrain['Cost']);?></i>
                <span class="CurrencyText" ><?php echo functions::Xmlinformation('Rial'); ?></span>
            <?php } ?>
             <?php if($discount != 0){?>
                <i class="iranM site-main-text-color-drck CurrencyCal "
                   data-amount="<?php echo $discount?>"><?php echo functions::numberFormat(round($ticketTrain['Cost']-$discount));?></i>
                <span class="CurrencyText site-main-text-color-drck"><?php echo functions::Xmlinformation('Rial'); ?></span>
             <?php } ?>
        </span>

        <div class="SelectTicket" data-ticket-detail='<?php echo json_encode($ticketTrain,256|64); ?>' direction="<?php echo ($ticketTrain['TypeRoute'] == 'return') ? 'return':'dept' ?>">
            <?php
            if(functions::compareTimeTrainForShowList($ticketTrain['ExitTime'],substr($ticketTrain['MoveDate'], 0, 10),substr($ticketTrain['ExitDate'], 0, 10))) {
                if ($ticketTrain['Counting'] <= 0 || $ticketTrain['Counting'] < $params['passengerCount']) {
                    ?>
                    <a class="international-available-btn train-false">
                        <?php echo functions::Xmlinformation('CompletionCapacity') ?></a>
                <?php } elseif ($ticketTrain['IsCompartment'] != '1' && $params['Coupe'] == '1') {
                    ?>
                    <span><?php echo functions::Xmlinformation('TrainNotCoupe') ?></span>
                <?php } elseif ($ticketTrain['CompartmentCapicity'] > $ticketTrain['Counting'] && $ticketTrain['IsCompartment'] == 1 && $params['Coupe'] == 1) { ?>
                    <span><?php echo functions::Xmlinformation('LostCapacityOfOneCoupe') ?></span>
                <?php } else { ?>
                    <a class="international-available-btn site-bg-main-color nextStepclassTrain" id="nextStep_<?php /** @var TYPE_NAME $key */
                       echo $key ?>" keyId="<?php echo $key ?>">
                        <?php echo !empty($params['ArrivalDate']) ? ((!empty($params['ArrivalDate']) && $ticketTrain['TypeRoute'] != 'dept') ? functions::Xmlinformation('Returnticket') : functions::Xmlinformation('Onewayticket')) : functions::Xmlinformation('Ticketselect') ?></a>
                <?php }
            }else{
                ?>
                <a class="international-available-btn site-main-button-color-hover flight-false">
                    <?php echo functions::Xmlinformation('CompletionCapacity') ?></a>
                <?php
            }?>


            <input type="hidden" value="" name="session_Service_Id" id="session_Service_Id">
            <span href="" onclick="return false" class="f-loader-check f-loader-check-change" id="loader_check_<?php echo $key ?>" style="display:none"></span>
            <input type="hidden" value="<?php echo Session::getCurrency()?>" class="CurrencyCode">
            <input type="hidden" value="<?php echo functions::generateRandomCode(15)?>" class="ServiceCode">
            <input type="hidden" value="<?php echo functions::getCompanyTrainById($ticketTrain['Owner'])?>" class="CompanyName">
            <input type="hidden" value="<?php echo $ticketTrain['RetStatus']?>" class="RetStatus">
            <input type="hidden" value="<?php echo $ticketTrain['Remain']?>" class="Remain">
            <input type="hidden" value="<?php echo $ticketTrain['TrainNumber']?>" class="TrainNumber">
            <input type="hidden" value="<?php echo $ticketTrain['WagonType']?>" class="WagonType">
            <input type="hidden" value="<?php echo $ticketTrain['WagonName']?>" class="WagonName">
            <input type="hidden" value="<?php echo $ticketTrain['PathCode']?>" class="PathCode">
            <input type="hidden" value="<?php echo $ticketTrain['CircularPeriod']?>" class="CircularPeriod">
            <input type="hidden" value="<?php echo $ticketTrain['MoveDate']?>" class="MoveDate">
            <input type="hidden" value="<?php echo $ticketTrain['ExitDate']?>" class="ExitDate">
            <input type="hidden" value="<?php echo $ticketTrain['ExitTime']?>" class="ExitTime">
            <input type="hidden" value="<?php echo $ticketTrain['Counting']?>" class="Counting">
            <input type="hidden" value="<?php echo $ticketTrain['SoldCount']?>" class="SoldCount">
            <input type="hidden" value="<?php echo $ticketTrain['degree']?>" class="degree">
            <input type="hidden" value="<?php echo $ticketTrain['AvaliableSellCount']?>" class="AvaliableSellCount">
            <input type="hidden" value="<?php echo $ticketTrain['Cost']?>" class="Cost">
            <input type="hidden" value="<?php echo $ticketTrain['FullPrice']?>" class="FullPrice">
            <input type="hidden" value="<?php echo $ticketTrain['CompartmentCapicity']?>" class="CompartmentCapicity">
            <input type="hidden" value="<?php echo $ticketTrain['IsCompartment']?>" class="IsCompartment">
            <input type="hidden" value="<?php echo $ticketTrain['CircularNumberSerial']?>" class="CircularNumberSerial">
            <input type="hidden" value="<?php echo $ticketTrain['CountingAll']?>" class="CountingAll">
            <input type="hidden" value="<?php echo $ticketTrain['RateCode']?>" class="RateCode">
            <input type="hidden" value="<?php echo $ticketTrain['AirConditioning']?>" class="AirConditioning">
            <input type="hidden" value="<?php echo $ticketTrain['Media']?>" class="Media">
            <input type="hidden" value="<?php echo $ticketTrain['TimeOfArrival']?>" class="TimeOfArrival">
            <input type="hidden" value="<?php echo $ticketTrain['RationCode']?>" class="RationCode">
            <input type="hidden" value="<?php echo $ticketTrain['soldcounting']?>" class="soldcounting">
            <input type="hidden" value="<?php echo $ticketTrain['SeatType']?>" class="SeatType">
            <input type="hidden" value="<?php echo $ticketTrain['Owner']?>" class="Owner">
            <input type="hidden" value="<?php echo $ticketTrain['AxleCode']?>" class="AxleCode">
            <input type="hidden" value="<?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['DepartureCity'] : $params['ArrivalCity']?>" class="Departure_City">
            <input type="hidden" value="<?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['ArrivalCity'] : $params['DepartureCity']?> " class="Arrival_City">
            <input type="hidden" value="<?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['DepartureCityCode'] : $params['ArrivalCityCode']?>" class="Dep_Code">
            <input type="hidden" value="<?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['ArrivalCityCode'] : $params['DepartureCityCode']?>" class="Arr_Code">
            <input type="hidden" value="<?php echo $params['PassengerNumber']?>" id="passengerNum">
            <input type="hidden" value="<?php echo $params['AdultCount']?>" id="adult">
            <input type="hidden" value="<?php echo $params['ChildCount']?>" id="child">
            <input type="hidden" value="<?php echo $params['InfantCount']?>" id="infant">
            <input type="hidden" value="<?php echo $ticketTrain['serviceSessionId'] ?>" id="serviceSessionId">
            <input type="hidden" value="<?php echo $ticketTrain['code'] ?>" id="code">
            <input type="hidden" value="<?php echo $params['Coupe'] ?>" id="isCoupe">
            <input type="hidden" name="specific" id="specific" value="<?php echo ($ticketTrain['isSpecific']) ? 'yes' : 'no'?>">
            <input type="hidden" value="<?php echo $ticketTrain['SourceId'] ?>" id="SourceId">
            <input type="hidden" value="<?php echo $params['passengerCount'] ?>" id="passengerCount">
        </div>

    </div>

</div>
