
<?php

  if($ticketTrain['Owner'] == 15 && $ticketTrain['WagonName'] == "5 ستاره رويال " ) {
      $ticketTrain['Owner'] = '36';
  }

    if($ticketTrain['Owner']==31 && $ticketTrain['CompartmentCapicity'])
    {
        $capacity = $ticketTrain['CompartmentCapicity'] ;
    }else{
        $capacity = '';
    }

$photo = $this->getController('baseCompanyBus')->getCompanyTrainPhoto($ticketTrain['Owner'],$capacity) ;
$title = $this->getController('baseCompanyBus')->getCompanyTrainById($ticketTrain['Owner']) ;

if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    var_dump($title);
//    die();
}
?>
<div class=" international-available-airlines  ">

    <div class="international-available-airlines-logo">
        <img height="50" width="50"
             src="<?php echo functions::getCompanyTrainPhoto($ticketTrain['Owner'],$capacity)?>"
             alt="<?php echo  functions::getCompanyTrainById($ticketTrain['Owner'])?>"
             title="<?php echo  functions::getCompanyTrainById($ticketTrain['Owner'])?>">
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