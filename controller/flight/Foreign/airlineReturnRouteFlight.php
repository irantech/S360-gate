<div class=" international-available-airlines  ">

    <div class="international-available-airlines-logo international_logo_coming_back foreign  <?php echo $ticket['return']['ReturnRoutes'][0]['Airline']['Code']; ?>">
        <div class="logo-airline-ico-foreign"></div>
    </div>
    <div class="international-available-airlines-log-info">
        <?php if (count($ticket['return']['ReturnRoutes']) <= 1) { ?>
            <span class="open txt13">
                <?php echo  $params['airlineList'][$ticket['return']['ReturnRoutes'][0]['Airline']['Code']][functions::ChangeIndexNameByLanguage(SOFTWARE_LANG,'name','_fa')] ?></span>
        <?php } else { ?>
            <span class="open txt13 boldtxt"><?php
                echo  $dataArrayFlight['MultiAirline'] ?></span>
        <?php } ?>


    </div>
</div>