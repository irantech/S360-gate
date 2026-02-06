
<div id="sort_train" class="sorting2">
    <div class="sorting-inner date-change iranL prev <?php if($params['directions'] == 'TwoWay'){echo 'disable_two' ;}  ?>">
        <a class="prev-date"
           href="<?php if ($params['directions'] == 'OneWay' && $this->indate($params['DepartureDate']) == true) {
               echo ROOT_ADDRESS . '/resultTrainApi/' . $params['DepartureCityCode'] . '-' . $params['ArrivalCityCode'] . '/' . $this->DatePrev($params['DepartureDate']) . '/' . $params['TypeWagon'] . '/' . $params['AdultCount'] . '-' . $params['ChildCount'] . '-' . $params['InfantCount'] . '/' . $params['Coupe'];
           } else {
               ?> javascript:<?php
           } ?>">
            <i class="zmdi zmdi-chevron-right iconDay "></i>
            <span><?php echo $textTrain['Previousday'] ?></span>
        </a>
    </div>
    <div class="sorting-inner price sorting-active-color-main " id="priceSortSelectForTrain">
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
        <span class="text-price-sort iranL"><?php echo $textTrain['Pricesort']?></span>
        <input type="hidden" value="desc" name="currentPriceSortTrain" id="currentPriceSortTrain">
    </div>
    <div class="sorting-inner time " id="dateSortSelectForTrain">
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

        <span class="text-price-sort iranL"><?php echo $textTrain['Timesort'] ?></span>

        <input type="hidden" value="desc" name="currentTimeSortTrain" id="currentTimeSortTrain" />

    </div>
    <div class="sorting-inner date-change iranL next <?php if($params['directions'] == 'TwoWay'){echo 'disable_two' ;}  ?>">
        <a class="next-date"
           href="<?php if ($params['directions'] == 'OneWay' && $this->indate($params['DepartureDate']) == true) {
               echo ROOT_ADDRESS . '/resultTrainApi/' . $params['DepartureCityCode'] . '-' . $params['ArrivalCityCode'] . '/' . $this->DateNext($params['DepartureDate']) . '/' . $params['TypeWagon'] . '/' . $params['AdultCount'] . '-' . $params['ChildCount'] . '-' . $params['InfantCount'] . '/' . $params['Coupe'];
           } else {
               ?> javascript:<?php
           } ?>">
            <span><?php echo $textTrain['Nextday'] ?></span>
            <i class="zmdi zmdi-chevron-left iconDay "></i>
        </a>
    </div>

</div>