
<?php

    if($ticketTrain['Owner']==31 && $ticketTrain['CompartmentCapicity'])
    {
        $capacity = $ticketTrain['CompartmentCapicity'] ;
    }else{
        $capacity = '';
    }
?>
<div class=" international-available-airlines  ">

    <div class="international-available-airlines-logo">
        <img height="50" width="50"
             src="<?php echo $photo ?>"
             alt="<?php echo  $title ?> "
             title="<?php echo $title ?>">
    </div>

    <div class="international-available-airlines-log-info">

        <!--         <span class="iranM txt12">  {$objFunctions->getCompanyTrainById($ticketTrain['Owner'])}</span>-->
        <span class="iranM txt12">شماره قطار :<?php echo $ticketTrain['TrainNumber'] ?></span>
        <div class="esterdad-blit">
            <span class="sandali-span2 iranL txt10 site-main-text-color" <?php
            if ($ticketTrain['Counting'] < 12 && $ticketTrain['Counting'] > 0) {
                echo 'style="color: darkred"';
            } ?>
            >
            <?php echo $ticketTrain['Counting'] . ' ' . functions::Xmlinformation('Chair');
            if ($ticketTrain['Counting'] < 12 && $ticketTrain['Counting'] > 0) {
                echo ' '.functions::Xmlinformation('Finishing');
            } ?>
                <?php  if($ticketTrain['isSpecific']){
                    ?><i class="irretrievable-text iranLa">
                    
                    غیر قابل استرداد</i><?php
                }?>
    </span>


        </div>

    </div>
</div>