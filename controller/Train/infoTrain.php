
<div class="international-available-airlines-info ">
    <div class="airlines-info destination txtLeft">

        <span class="iranB txt18"><?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['DepartureCity'] : $params['ArrivalCity']?></span>
        <span class="iranB txt18 timeSortTrain"><?php echo $ticketTrain['ExitTime'] ?></span>


    </div>

    <div class="airlines-info">
        <div class="airlines-info-inner">
           <span class="iranL txt12">
                  <?php
                  $this->DateJalali(((!empty($params['ArrivalDate']) && $ticketTrain['TypeRoute'] != 'dept' ) ? $params['ArrivalDate'] : $params['DepartureDate']), $params['lang']);
                  echo $this->day . ' ,' . $this->date_now;
                  ?>
           </span>
            <div class="airline-line">
                <div class="loc-icon">
                    <svg version="1.1" class="site-main-text-color"
                         id="Layer_1"
                         xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         x="0px" y="0px" width="32px"
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

                <div class="plane-icon busicon_zm" style="transform: rotate(0deg);">

                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_3" enable-background="new 0 0 64 64"
                         viewBox="0 0 64 64">
                        <g>
                            <path d="m18 51h-10-7v2h62v-2h-5-10z" data-original="#000000" class="active-path"
                                  data-old_color="#000000" fill="#C4C4C4"/>
                            <path d="m26 13h37v-2h-37c-2.453 0-4.489 1.779-4.91 4.113-8.318.746-15.758 5.59-19.766 13.035l-.204.378c-.079.146-.12.308-.12.474v13c0 .552.448 1 1 1h1v2h-2v2h4.184c-.112.314-.184.648-.184 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h4.369c-.113.314-.185.648-.185 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h24.369c-.113.314-.185.648-.185 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h4.369c-.113.314-.185.648-.185 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h2.184v-2h-58v-2h58v-2h-59-1v-2h1c1.654 0 3-1.346 3-3s-1.346-3-3-3h-1v-3.748l.084-.156c4.018-7.461 11.777-12.096 20.251-12.096h39.665v-2h-39.665c-.051 0-.101.005-.152.005.412-1.164 1.513-2.005 2.817-2.005zm-17 35c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm10 0c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm30 0c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm10 0c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm-55-13c.551 0 1 .449 1 1s-.449 1-1 1h-1v-2z"
                                  data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"/>
                            <path d="m24.324 19c-7.334 0-14.234 3.907-18.008 10.196l-.174.29c-.185.309-.19.694-.012 1.007s.51.507.87.507h22c.552 0 1-.448 1-1v-10c0-.552-.448-1-1-1zm3.676 10h-19.167c3.537-4.968 9.346-8 15.491-8h3.676z"
                                  data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"/>
                            <path d="m33 19c-.552 0-1 .448-1 1v10c0 .552.448 1 1 1h10c.552 0 1-.448 1-1v-10c0-.552-.448-1-1-1zm9 10h-8v-8h8z"
                                  data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"/>
                            <path d="m47 19c-.552 0-1 .448-1 1v10c0 .552.448 1 1 1h10c.552 0 1-.448 1-1v-10c0-.552-.448-1-1-1zm9 10h-8v-8h8z"
                                  data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"/>
                        </g>
                    </svg>
                </div>

                <div class="loc-icon-destination">
                    <svg version="1.1" class="site-main-text-color"
                         id="Layer_1"
                         xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         x="0px" y="0px" width="32px"
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


        </div>

        <span class="iranB txt11  span_train_logo">
             <i class="wagonname site-main-text-color"><?php echo $ticketTrain['WagonName']; ?></i>

            <i class="cope_no">
                                           <?php if($ticketTrain['IsCompartment'] == '1'){
                                               echo functions::StrReplaceInXml(['@@CompartmentCapicity@@' => $ticketTrain['CompartmentCapicity']], 'CompartmentCapicity');
                                           } ?>
                </i>
                                       </span>
        <?php if($ticketTrain['isSpecific']){
            ?>
            <span class="system_charter_train site-main-text-color">چارتری</span>
        <?php
        } ?>
    </div>

    <div class="airlines-info destination txtRight namecity_zm">
        <span class="iranB txt18"><?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['ArrivalCity'] : $params['DepartureCity']?></span>
        <span class="iranB txt18"><?php echo $ticketTrain['TimeOfArrival'] ?></span>

    </div>
</div>