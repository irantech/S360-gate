<div class=" international-available-airlines  ">

    <div class="international-available-airlines-logo">
        <div class="logo-airline-ico"></div>
    </div>

    <div class="international-available-airlines-log-info">
        <span class="iranM txt12"><i><?php  echo $dataArrayFlight['Numflight'] ?> : </i><?php echo $ticket['FlightNo'] ?></span>
        <div class="esterdad-blit">
            <span class="sandali-span2 iranL txt10"><?php echo ($ticket['Capacity'] <= '9') ? $ticket['Capacity'] : '+9' ?>
                <?php  echo $dataArrayFlight['Chair'] ?>
                <?php $feePrice = $fee->FeeByAirlineAndCabinType($ticket['Airline'],$ticket['CabinType']);
                if($feePrice) {
                    ?>
                    <i class="irretrievable-text iranLa">
                    -
                    <?php echo $dataArrayFlight['Irretrievable'] ?></i><?php
                }
                ?>

            </span>

        </div>

    </div>
</div>