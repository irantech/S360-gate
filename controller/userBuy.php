<?php
/**
 * Class userBuy
 * @property userBuy $userBuy
 */
class userBuy extends clientAuth
{

    public function getFlightBuyList($param)
    {

        $objUser = Load::controller('user');
        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();

        $info_agency = functions::infoAgencyByMemberId($id);
        $sql = "SELECT   
                    origin_city,desti_city,request_number,creation_date_int,airline_name,
                    flight_number,time_flight,date_flight,factor_number,successfull,IsInternal,type_app,flight_type,
                    currency_code,currency_equivalent
                 FROM book_local_tb 
                 WHERE 
                    member_id='{$id}' AND request_number > '0' AND successfull<>'nothing' ";

        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }/* else {

            $date = dateTimeSetting::jdate("Y-m-d", time());
            $date_now_explode = explode('-', $date);
            $date_now_int_start = dateTimeSetting::jmktime(0, 0, 0, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);
            $date_now_int_end = dateTimeSetting::jmktime(23, 59, 59, $date_now_explode[1], $date_now_explode[2], $date_now_explode[0]);

            $sql .= "AND creation_date_int >= '{$date_now_int_start}' AND creation_date_int  <= '{$date_now_int_end}'";
        }*/

        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (request_number = '{$param['factorNumber']}' OR factor_number = '{$param['factorNumber']}') ";
        }

        $sql .= "
                GROUP BY request_number 
                ORDER BY creation_date_int DESC ";

        $bookList = $Model->select($sql);


        ob_start();
        ?>
 <div class="content-table">
        <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Origin'); ?>
                    <br/><?php echo functions::Xmlinformation('Destination'); ?></th>
                <th><?php echo functions::Xmlinformation('Busydate'); ?>
                    <br/><?php echo functions::Xmlinformation('WachterNumber'); ?></th>
                <th><?php echo functions::Xmlinformation('Namepassenger'); ?>
                    <br/><?php echo functions::Xmlinformation('Airline'); ?></th>
                <th><?php echo functions::Xmlinformation('Numflight'); ?>
                    <br/><?php echo functions::Xmlinformation('RunTime'); ?></th>
                <th><?php echo functions::Xmlinformation('Amount'); ?></th>
                <th><?php echo functions::Xmlinformation('Status'); ?></th>
                <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($bookList as $item) {
                $number++;
                ?>
                <tr>
                    <td data-content="<?php echo functions::Xmlinformation('Row'); ?>"><?php echo $number; ?></td>
                    <td data-content="<?php echo functions::Xmlinformation('Origin'); ?>">
                        <?php
                        if ($item['origin_city'] != '') {
                            echo $item['origin_city'] . '<br/>' . $item['desti_city'];
                        } else {
                            echo '-----------';
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('WachterNumber'); ?>" dir="ltr">
                        <?php
                        if ($item['creation_date_int'] != '') {
                            echo functions::printDateIntByLanguage('Y-m-d (H:i:s)',$item['creation_date_int'],SOFTWARE_LANG) . '<br/>';
                        } else {
                            echo '-----------';
                        }
                        echo $item['request_number'];
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Namepassenger'); ?>">
                        <?php
                        echo $objUser->showBuy($item['request_number']) . '<br/>' . $item['airline_name'];
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Numflight'); ?>">
                        <?php
                        echo $item['flight_number'] . '<br/>' . $objUser->format_hour($item['time_flight']) . ' ' . functions::printDateIntByLanguage('Y-m-d',strtotime($item['date_flight']),SOFTWARE_LANG);
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Amount'); ?>">
                        <?php
                        $amountBuy = functions::CalculateDiscount($item['request_number']) ;
                        $calculate_currency = $item['currency_equivalent'] > 0 ? functions::ticketPriceCurrency($amountBuy,$item['currency_equivalent']): $amountBuy;
                        $number_format_float = ($info_agency['type_payment'] == 'currency' && SOFTWARE_LANG !="fa") ? 2 : 0 ;
                        echo number_format(functions::calcDiscountCodeByFactor($calculate_currency, $item['factor_number']),$number_format_float);
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                        <?php
                        if ($item['successfull'] == 'nothing') {
                            echo functions::Xmlinformation('Unknow');
                        }elseif ($item['successfull'] == 'error') {

                            if($item['flight_type']=='system'){
                                echo functions::Xmlinformation('ErrorAirline');
                            }elseif($item['flight_type']=='charter'){
                                echo functions::Xmlinformation('ErrorCharter');
                            }

                        }elseif ($item['successfull'] == 'prereserve') {
                            echo functions::Xmlinformation('Prereservation');
                        } elseif ($item['successfull'] == 'bank') {
                            echo functions::Xmlinformation('RedirectPayment');
                        } elseif ($item['successfull'] == 'book') {
                            echo functions::Xmlinformation('Definitivereservation');
                        }elseif ($item['successfull'] == 'processing') {
                            echo functions::Xmlinformation('processingPrintFlight');
                        }elseif ($item['successfull'] == 'pending') {
                            echo functions::Xmlinformation('pendingPrintFlight');
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">
                        <div class="dropdownUserBuy">
                            <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>

                            <div class="dropdown-content-UserBuy ">
                                <?php
                                if ($item['type_app'] == 'reservation' || $item['type_app'] == 'reservationBus') {
                                    ?>
                                    <a id="myBtn"
                                       onclick="modalListForReservationTicket('<?php echo $item['request_number']; ?>');"
                                       class="btn btn-primary fa fa-search margin-10"
                                       title="<?php echo functions::Xmlinformation('ShowReservation'); ?>  <?php echo functions::Xmlinformation('Ticket'); ?>"></a>
                                    <?php
                                    if ($item['successfull'] == 'book') {
                                        ?>
                                        <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=BookingReservationTicket&id=<?php echo $item['request_number']; ?>"
                                           title="<?php echo functions::Xmlinformation('Pdff'); ?>"
                                           class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>
                                        <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=boxCheck&id=<?php echo $item['request_number']; ?>"
                                           title="<?php echo functions::Xmlinformation('Viewbill'); ?>"
                                           class="btn btn-info  fa fa-money margin-10"
                                           target="_blank"></a>

                                        <?php
                                    }

                                    $objReservationTicket = Load::controller('reservationTicket');
                                    $percentCancel = $objReservationTicket->getCancellationsTicket($item['fk_id_ticket'], $item['date_flight'], $item['time_flight']);

                                    if ($item['type_app'] == 'reservation' && $item['successfull'] == 'book'
                                        && $objUser->compareDate($item['date_flight'], $item['time_flight'], '') == 'true' && $percentCancel > 0) {
                                        ?>
                                        <a id="cancelbyuser"
                                           title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                                           onclick="modalCancelReservationTicket('<?php echo $item['request_number']; ?>'); return false;"
                                           class="btn btn-danger fa fa-times"></a>
                                        <?php
                                    }

                                } else {

                                    ?>
                                    <a id="myBtn" onclick="modalList('<?php echo $item['request_number']; ?>');"
                                       class="btn btn-primary fa fa-search margin-10"
                                       title="<?php echo functions::Xmlinformation('ShowReservation'); ?> <?php echo functions::Xmlinformation('Ticket'); ?>"></a>

                                    <?php
                                    if ($item['successfull'] == 'book') {

                                        if ($item['IsInternal'] == '0') {
                                            ?>
                                            <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=ticketForeign&id=<?php echo $item['request_number']; ?>"
                                               title="<?php echo functions::Xmlinformation('pdff'); ?>"
                                               class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=<?php echo (SOFTWARE_LANG != 'fa' ? 'bookshow' : 'parvazBookingLocal'); ?>&id=<?php echo $item['request_number']; ?>"
                                               title="<?php echo functions::Xmlinformation('pdff'); ?>"
                                               class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>
                                            <?php
                                            $typeMember = functions::TypeUser(session::getUserId());
                                            if ($typeMember == 'Counter') {
                                                ?>
                                                <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=<?php echo (SOFTWARE_LANG != 'fa' ? 'bookshow' : 'parvazBookingLocal'); ?>&id=<?php echo $item['request_number']; ?>&cash=no"
                                                   title="<?php echo functions::Xmlinformation('Freeticket'); ?>"
                                                   class="btn btn-primary  fa fa-file-pdf-o" target="_blank"></a>
                                                <?php
                                            }
                                        }

                                        ?>
                                        <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=boxCheck&id=<?php echo $item['request_number']; ?>"
                                           title="<?php echo functions::Xmlinformation('Viewbill'); ?>"
                                           class="btn btn-info  fa fa-money margin-10"
                                           target="_blank"></a>
                                        <a id="cancelbyuser"
                                           title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                                           onclick="ModalCancelUser('flight','<?php echo $item['request_number']; ?>'); return false;"
                                           class="btn btn-danger fa fa-times"></a>

                                        <?php
                                          if(CLIENT_ID == 271){
                                          $reservationProof = Load::controller('reservationProof');
                                          $file = $reservationProof->getProofFile($item['request_number'] , 'Flight');
                
                                          if($file && isset($file) && !empty($file)){
                                        ?>
                                          <a onclick="modalForReservationProof('<?php echo $item['request_number']; ?>' , 'Flight');"
                                             title="<?php echo functions::Xmlinformation('ViewProof'); ?>"
                                             class="btn btn-info  fa fa-download margin-10"
                                             target="_blank"></a>
                                        <?php }
                                          }?>

                                        <?php

                                    }

                                }


                                ?>
                            </div>
                        </div>
                        <?php
                        if ($item['successfull'] == 'book') {?>
                        <div class="cancle-flight mt-2">
                          <a id="cancelbyuser"
                             onclick="ModalCancelUser('flight','<?php echo $item['request_number']; ?>'); return false;"
                             class="btn btn-danger"><?php echo functions::Xmlinformation('CancelFlightUser'); ?></a>
                        </div>
                        <?php } ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
 </div>
        <?php
        $print = ob_get_clean();
        return $print;

    }

    public function getHotelBuyList($param)
    {

        $objUser = Load::controller('user');
        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();

        $sql = "SELECT   
                    *
                 FROM book_hotel_local_tb 
                 WHERE 
                    member_id='{$id}' ";

        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (factor_number = '{$param['factorNumber']}') ";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);

        ob_start();
        ?>
             <div class="content-table">
                <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Hotel'); ?>
                    <br/><?php echo functions::Xmlinformation('Destination'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Buydate'); ?>
                    <br/><?php echo functions::Xmlinformation('Invoicenumber'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Enterdate'); ?>
                    <br/><?php echo functions::Xmlinformation('Stayigtime'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Customername'); ?></th>
                <th><?php echo functions::Xmlinformation('Amount'); ?></th>
                <th><?php echo functions::Xmlinformation('Status'); ?></th>
                <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($bookList as $item) {
                $number++;
                ?>
                <tr>
                    <td data-content="<?php echo functions::Xmlinformation('Row'); ?>">
                        <?php echo $number; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Hotel'); ?>">
                        <?php echo $item['hotel_name'] . '<br/>' . $item['city_name']; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Buydate'); ?>" dir="ltr">
                        <?php
                        if ($item['creation_date_int'] != '') {
                            echo functions::printDateIntByLanguage('Y-m-d (H:i:s)',$item['creation_date_int'],SOFTWARE_LANG);
                        } else {
                            echo '---------';
                        }
                        echo '<br/>' . $item['factor_number'];
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Enterdate'); ?>">
                        <?php

                        echo functions::printDateIntByLanguage('Y-m-d',functions::convertJalaliDateToGregInt($item['start_date']),SOFTWARE_LANG);

                         ?> <br/> <?php echo $item['number_night']; ?><?php echo functions::Xmlinformation('Night'); ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Customername'); ?>">
                        <?php echo $item['passenger_leader_room_fullName']; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Amount'); ?>">
                        <?php echo number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number'])); ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                        <?php
                        if ($item['status'] == 'BookedSuccessfully') {
                            echo functions::Xmlinformation('Definitivereservation');
                        } elseif ($item['status'] == 'bank') {
                            echo functions::Xmlinformation('RedirectPayment');
                        } elseif ($item['status'] == 'PreReserve') {
                            echo functions::Xmlinformation('Prereservation');
                        }elseif ($item['status'] == 'OnRequest') {
                            echo functions::Xmlinformation('OnRequestedHotel');
                        } elseif ($item['status'] == 'Cancelled') {
                            echo functions::Xmlinformation('Cancel');
                        } elseif ($item['status'] == 'pending') {
                            echo functions::Xmlinformation('pendingPrintFlight');
                        } else {
                            echo functions::Xmlinformation('Unknow');
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">
                        <div class="dropdownUserBuy">
                            <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>
                            <div class="dropdown-content-UserBuy ">
                                <a id="myBtn" onclick="modalListForHotel('<?php echo $item['factor_number']; ?>');"
                                   class="btn btn-primary fa fa-search margin-10"
                                   title="  <?php echo functions::Xmlinformation('ShowReservation'); ?> <?php echo functions::Xmlinformation('Hotel'); ?>"></a>
                                <?php
                                if ($item['status'] == 'BookedSuccessfully') {
                                    ?>
<!--
                                    <a href="<?php echo ROOT_ADDRESS; ?>/ehotelLocal&num=<?php echo $item['factor_number']; ?>"
                                       class="btn btn-dropbox fa fa-print  margin-10"
                                       target="_blank"
                                       title="  <?php echo functions::Xmlinformation('Shownformation'); ?> <?php echo functions::Xmlinformation('hotel'); ?>"></a>

-->

                                    <?php
                                    if($item['isInternal'] != 0){ ?>
                                    <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=BookingHotelNew&id=<?php echo $item['factor_number']; ?>"
                                       title="<?php echo functions::Xmlinformation('Pdff'); ?>"
                                       class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>
                                        <?php }

                                    if($item['isInternal'] == 0){ ?>
                                    <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=bookhotelshow&id=<?php echo $item['factor_number']; ?>"
                                       title="<?php echo functions::Xmlinformation('Englishpdf'); ?>"
                                       class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>
                                  <?php
                                    }

                                    if (CLIENT_ID == 271) {
                                      $reservationProof = Load::controller('reservationProof');
                                      $file = $reservationProof->getProofFile($item['factor_number'] , 'Hotel');

                                      if($file && isset($file) && !empty($file)){
                                  ?>
                                  <a onclick="modalForReservationProof('<?php echo $item['factor_number']; ?>' , 'Hotel');"
                                     title="<?php echo functions::Xmlinformation('ViewProof'); ?>"
                                     class="btn btn-info  fa fa-download margin-10"
                                     target="_blank"></a>
                                  <?php
                                        }
                                    }
                                  ?>
                                  <a id="cancelbyuser"
                                     title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                                     onclick="modalCancelBuy('hotel', '<?php echo $item['factor_number']; ?>'); return false;"
                                     class="btn btn-danger fa fa-times"></a>
                                  <?php
                                  /*if ($item['type_application'] == 'externalApi') {
                                      */?><!--
                                      <a title="کنسل کردن"
                                         onclick="modalCancelExternalHotel('<?php /*echo $item['factor_number']; */?>'); return false;"
                                         class="btn btn-danger fa fa-times"></a>
                                      --><?php
/*                                    }*/
                                }
                                if ($item['type_application'] == 'reservation' && $objUser->checkForEdit($item['status'], $item['start_date']) == 'true') {
                                    ?>
                                    <a href="<?php echo ROOT_ADDRESS; ?>/editReserveHotel&id=<?php echo $item['factor_number']; ?>"
                                       title="<?php echo functions::Xmlinformation('Editbookings'); ?>"
                                       class="btn btn-editReserve fa fa-pencil margin-10" target="_blank"></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
             </div>
        <?php
        $print = ob_get_clean();
        return $print;


    }

    public function getInsuranceBuyList($param)
    {

        $objUser = Load::controller('user');
        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();

        $sql = "SELECT   
                    *
                 FROM book_insurance_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (request_number = '{$param['factorNumber']}' OR factor_number = '{$param['factorNumber']}') ";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);


        ob_start();
        ?>
             <div class="content-table">
                <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Typeinsurance'); ?>
                    / <?php echo functions::Xmlinformation('Destination'); ?>
                    <br/><?php echo functions::Xmlinformation('Insurancetitle'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Buydate'); ?>
                    <br/><?php echo functions::Xmlinformation('Insurancenumber'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Namepassenger'); ?></th>
                <th><?php echo functions::Xmlinformation('Amount'); ?></th>
                <th><?php echo functions::Xmlinformation('Status'); ?></th>
                <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($bookList as $item) {
                $number++;
                ?>
                <tr>
                    <td data-content="<?php echo functions::Xmlinformation('Row'); ?>">
                        <?php echo $number; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Typeinsurance'); ?>">
                        <?php
                        echo $item['source_name_fa'] . ' / ' . $item['destination'];
                        if ($item['caption'] != '') {
                            echo '<br/>' . $item['caption'];
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Buydate'); ?>" dir="ltr">
                        <?php
                        if ($item['creation_date_int'] != '') {
                            echo functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'],SOFTWARE_LANG);
                        } else {
                            echo '---------';
                        }
                        echo '<br/>' . $item['pnr'];
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Namepassenger'); ?>">
                        <?php echo $objUser->showBuyInsurance($item['factor_number']); ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Amount'); ?>">
                        <?php echo number_format(functions::calcDiscountCodeByFactor($objUser->total_price_insurance($item['factor_number']), $item['factor_number'])); ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                        <?php
                        if ($item['status'] == 'book') {
                            echo functions::Xmlinformation('Definitivereservation');
                        } elseif ($item['status'] == 'bank') {
                            echo functions::Xmlinformation('RedirectPayment');
                        } elseif ($item['status'] == 'prereserve') {
                            echo functions::Xmlinformation('Prereservation');
                        } elseif ($item['status'] == 'cancel') {
                            echo functions::Xmlinformation('Cancel');
                        } else {
                            echo functions::Xmlinformation('Unknow');
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">
                        <div class="dropdownUserBuy">
                            <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>
                            <div class="dropdown-content-UserBuy ">
                                <a id="myBtn" onclick="modalListInsurance('<?php echo $item['factor_number']; ?>');"
                                   class="btn btn-primary fa fa-search margin-10"
                                   title="<?php echo functions::Xmlinformation('ShowReservation'); ?> <?php echo functions::Xmlinformation('Insurance'); ?>"></a>
                                <?php
                                if ($item['status'] == 'book') {
                                    ?>
                                    <?php

                                    if (CLIENT_ID == 271) {
                                        $reservationProof = Load::controller('reservationProof');
                                        $file = $reservationProof->getProofFile($item['factor_number'] , 'Insurance');

                                        if($file && isset($file) && !empty($file)){
                                            ?>
                                    <a onclick="modalForReservationProof('<?php echo $item['factor_number']; ?>' , 'Insurance');"
                                       title="<?php echo functions::Xmlinformation('ViewProof'); ?>"
                                       class="btn btn-info  fa fa-download margin-10"
                                       target="_blank"></a>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <a id="cancelbyuser"
                                       title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                                       onclick="modalCancelBuy('insurance', '<?php echo $item['factor_number']; ?>'); return false;"
                                       class="btn btn-danger fa fa-times"></a>

                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
             </div>
        <?php
        $print = ob_get_clean();
        return $print;


    }

    public function getGashttransferBuyList($param)
    {

        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT * "
            . " FROM book_gasht_local_tb "
            . " WHERE member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND passenger_factor_num = '{$param['factorNumber']}' ";
        }
        $sql .= "
                GROUP BY passenger_factor_num 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);

        ob_start();
        ?>
             <div class="content-table">
                <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Servicetype') . ' / ' . functions::Xmlinformation('Servicename'); ?>
                    <br/><?php echo functions::Xmlinformation('Destination'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Buydate'); ?>
                    <br/><?php echo functions::Xmlinformation('Invoicenumber'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Namepassenger'); ?>
                    <br/><?php echo functions::Xmlinformation('Countpeople'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Totalamount'); ?></th>
                <th><?php echo functions::Xmlinformation('Status'); ?></th>
                <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($bookList as $item) {
                $number++;
                ?>
                <tr>
                    <td data-content="<?php echo functions::Xmlinformation('Row'); ?>">
                        <?php echo $number; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Servicetype') . ' / ' . functions::Xmlinformation('Servicename'); ?>">
                        <?php
                        if ($item['passenger_serviceRequestType'] == 0) {
                            echo functions::Xmlinformation('Gasht');
                        } else {
                            echo functions::Xmlinformation('transfer');
                        }
                        echo ' / ' . $item['passenger_serviceName'] . '<br/>' . $item['passenger_serviceCityName'];
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Buydate'); ?>" dir="ltr">
                        <?php
                        if ($item['creation_date_int'] != '') {
                            echo functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'],SOFTWARE_LANG);

                         } else {
                            echo '---------';
                        }
                        echo '<br/>' . $item['passenger_factor_num'];
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Namepassenger'); ?>">
                        <?php echo $item['passenger_name'] . ' ' . $item['passenger_family'] . '<br/>' . $item['passenger_number']; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Totalamount'); ?>">
                        <?php echo number_format($item['passenger_number'] * $item['passenger_servicePriceAfterOff']); ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                        <?php
                        if ($item['status'] == 'prereserve') {
                            echo functions::Xmlinformation('Prereservation');
                        } elseif ($item['status'] == 'bank') {
                            echo functions::Xmlinformation('RedirectPayment');
                        } elseif ($item['status'] == 'book') {
                            echo functions::Xmlinformation('Definitivereservation');
                        } elseif ($item['status'] == 'cancel') {
                            echo functions::Xmlinformation('Cancel');
                        } else {
                            echo functions::Xmlinformation('Unknow');
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">
                        <div class="dropdownUserBuy">
                            <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>
                            <div class="dropdown-content-UserBuy ">
                                <a id="myBtn" onclick="modalListGasht('<?php echo $item['passenger_factor_num']; ?>');"
                                   class="btn btn-primary fa fa-search margin-10"
                                   title="<?php echo functions::Xmlinformation('Seebookingpatrolstransfers'); ?>"></a>
                                <?php
                                if ($item['status'] == 'book') {
                                    ?>
                                    <a id="cancelbyuser"
                                       title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                                       onclick="modalCancelBuy('gashttransfer', '<?php echo $item['passenger_factor_num']; ?>'); return false;"
                                       class="btn btn-danger fa fa-times"></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
             </div>
        <?php
        $print = ob_get_clean();
        return $print;


    }

    public function getTourBuyList($param)
    {

        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT   
                    *
                 FROM book_tour_local_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND factor_number = '{$param['factorNumber']}' ";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);

        ob_start();
        ?>
             <div class="content-table">
                <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Tour'); ?></th>
                <th><?php echo functions::Xmlinformation('Origin'); ?></th>
                <th><?php echo functions::Xmlinformation('Destination'); ?></th>
                <th><?php echo functions::Xmlinformation('Enterdate'); ?>
                    <br/><?php echo functions::Xmlinformation('Stayigtime'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Invoicenumber'); ?>
                    <br/><?php echo functions::Xmlinformation('Buydate'); ?>
                    <br/><?php echo functions::Xmlinformation('Paymentamount'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Status'); ?></th>
                <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
            </tr>
            </thead>

            <tbody>
            <?php
            $tourReservationController=Load::controller('reservationTour');

            foreach ($bookList as $item) {

                $tourDetail=$tourReservationController->infoTourById($item['tour_id']);

                $isRequest=false;
                if($tourDetail['is_request'] =='1')
                    $isRequest=true;



                $number++;
                ?>
                <tr>
                    <td data-content="<?php echo functions::Xmlinformation('Row'); ?>">
                        <?php echo $number; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Tour'); ?>"><?php echo $item['tour_name'] . '(' . $item['tour_type'] . ')'; ?></td>
                    <td data-content="<?php echo functions::Xmlinformation('Origin'); ?>"><?php echo $item['tour_origin_country_name'] . ' - ' . $item['tour_origin_city_name'] . ' - ' . $item['tour_origin_region_name']; ?></td>
                    <td data-content="<?php echo functions::Xmlinformation('Destination'); ?>"><?php echo $item['tour_cities']; ?></td>
                    <td data-content="<?php echo functions::Xmlinformation('Enterdate'); ?>">
                        <?php
                        echo functions::printDateIntByLanguage('Y-m-d',functions::convertJalaliDateToGregInt($item['tour_start_date']),SOFTWARE_LANG);
 ?>


                        <hr style="border: 1px dashed #d1d1d1;">
                        <?php
                        if ($item['tour_night'] > 0) {
                            echo $item['tour_night'] . functions::Xmlinformation('Night');
                        } else {
                            echo $item['tour_day'] . functions::Xmlinformation('Day');
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Invoicenumber'); ?>" dir="ltr">
                        <?php echo $item['factor_number']; ?>
                        <hr style="border: 1px dashed #d1d1d1;">
                        <?php
                        if ($item['creation_date_int'] != '') {
                            echo functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'],SOFTWARE_LANG);


                        } else {
                            echo '---------';
                        }
                        ?>
                        <hr style="border: 1px dashed #d1d1d1;">
                        <?php echo number_format($item['tour_payments_price']); ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                        <?php


                        if ($isRequest && $item['status'] == 'Requested') {
                            echo 'درخواست شده';
                        }
                        elseif  ($isRequest && $item['status'] == 'RequestRejected') {
                            echo '  درخواست رد شده';
                        }
                        elseif  ($isRequest && $item['status'] == 'RequestAccepted') {
                            echo ' درخواست تایید شده';
                        }


                        elseif ($item['status'] == 'BookedSuccessfully') {
                            echo '<span class="text-success">'.functions::Xmlinformation('Definitivereservation').'</span>';
                        } elseif ($item['status'] == 'TemporaryReservation') {
                            echo functions::Xmlinformation('Temporaryreservation') . ' (' . functions::Xmlinformation('Paymentprebookingamount') . ')';
                        } elseif ($item['status'] == 'PreReserve') {
                            echo '<span class="text-warning">'.functions::Xmlinformation('Temporaryreservation') . ' (' . functions::Xmlinformation('Paymentprebookingamount') . ')'.'</span>';
                            ?>
                            <a href="<?php echo ROOT_ADDRESS; ?>/UserTracking&type=tour&id=<?php echo $item['factor_number']; ?>"
                               class="s-u-check-step s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 site-main-button-color">پرداخت</a>
                            <?php
                        } elseif ($item['status'] == 'TemporaryPreReserve') {
                            echo functions::Xmlinformation('Temporaryprebooking');
                        } elseif ($item['status'] == 'bank') {
                            echo functions::Xmlinformation('RedirectPayment');
                        } elseif ($item['status'] == 'CancellationRequest') {
                            echo functions::Xmlinformation('Cancelrequestpassenger');
                        } elseif ($item['status'] == 'Cancellation') {
                            echo functions::Xmlinformation('Cancellation') . '<hr style="border: 1px dashed #d1d1d1;">' . $item['cancellation_comment'];
                        } else {
                            echo functions::Xmlinformation('Unknow');
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">

                        <div class="dropdownUserBuy">
                            <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>
                            <div class="dropdown-content-UserBuy ">
                                <a id="myBtn" onclick="modalListForTour('<?php echo $item['factor_number']; ?>');"
                                   class="btn btn-primary fa fa-search margin-10"
                                   title="<?php echo functions::Xmlinformation('ShowReservation'); ?>"></a>
                                <?php
                                if ($item['status'] == 'BookedSuccessfully') {
                                    ?>
                                    <a href="<?php echo ROOT_ADDRESS; ?>/eTourReservation&num=<?php echo $item['factor_number']; ?>"
                                       class="btn btn-dropbox fa fa-print  margin-10"
                                       target="_blank"
                                       title="<?php echo functions::Xmlinformation('Shownformation'); ?>">
                                    </a>
                                    <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=BookingTourLocal&id=<?php echo $item['factor_number']; ?>"
                                       title="<?php echo functions::Xmlinformation('pdff'); ?>"
                                       class="btn btn-info  fa fa-file-pdf-o" target="_blank">
                                    </a>
                                    <?php
                                }
                                if ($item['status'] == 'BookedSuccessfully') {
                                    ?>
                                    <a id="cancelbyuser"
                                       title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                                       onclick="modalCancelBuy('tour', '<?php echo $item['factor_number']; ?>'); return false;"
                                       class="btn btn-danger fa fa-times"></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                        if ($item['passengers_file_tour'] != '') {
                            $arrayFile = json_decode($item['passengers_file_tour']);
                            ?>
                            <hr style="border: 1px dashed #d1d1d1;">

                            <div class="dropdownUserBuy">
                                <button class="dropbtnUserBuy tourFile"><?php echo functions::Xmlinformation('DownloadTourDocumentsFile'); ?></button>
                                <div class="dropdown-content-UserBuy">
                                    <?php
                                    foreach ($arrayFile as $k => $file) {
                                        ?>
                                        <span>
                                            <a id="downloadLink"
                                               href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pic/reservationTour/passengersImages/<?php echo $file; ?>"
                                               target="_blank"
                                               type="application/octet-stream"><i
                                                        class="fa fa-download"></i><?php echo functions::Xmlinformation('file'); ?> <?php echo $k + 1; ?></a>
                                        </span>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
             </div>
        <?php
        $print = ob_get_clean();
        return $print;


    }

    public function getVisaBuyList($param)
    {

        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT  
                    *, (SELECT documents FROM visa_type_tb AS visaType WHERE visaType.title = visa_type) AS documents_visa
                FROM book_visa_tb 
                WHERE member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND factor_number = '{$param['factorNumber']}' ";
        }
        $sql .= "
                GROUP BY factor_number 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);

        ob_start();
        ?>
             <div class="content-table">
                <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Titlevisa'); ?>
                    <br/><?php echo functions::Xmlinformation('Typevisa'); ?>
                    / <?php echo functions::Xmlinformation('Destination'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Buydate'); ?>
                    <br/><?php echo functions::Xmlinformation('Invoicenumber'); ?>
                </th>
                <th><?php echo functions::Xmlinformation('Namepassenger'); ?></th>
                <th><?php echo functions::Xmlinformation('Amount'); ?></th>
                <th>
                    <?php echo functions::Xmlinformation('Status'); ?>/
                    <br/><?php echo functions::Xmlinformation('ProcessStatus'); ?>

                </th>
                <th><?php echo functions::Xmlinformation('Show'); ?><span class="d-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>

            </tr>
            </thead>

            <tbody>
            <?php
            /** @var visaRequestStatus $visaRequestStatus */
            $visaRequestStatus = Load::controller('visaRequestStatus');

            foreach ($bookList as $item) {
                $number++;
                ?>
                <tr>
                    <td data-content="<?php echo functions::Xmlinformation('Row'); ?>">
                        <?php echo $number; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Titlevisa'); ?>">
                        <?php echo $item['visa_title'] . '<br/>' . $item['visa_type'] . ' / ' . $item['visa_destination']; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Buydate'); ?>" dir="ltr">
                        <?php
                        if ($item['creation_date_int'] != '') {
                            echo functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'],SOFTWARE_LANG);

                        } else {
                            echo '---------';
                        }
                        echo '<br/>' . $item['factor_number'];
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Namepassenger'); ?>">
                        <?php echo $item['passenger_name'] . ' ' . $item['passenger_family']; ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Amount'); ?>">
                        <?php echo number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number'])); ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                        <?php
                        if ($item['status'] == 'prereserve') {
                            echo functions::Xmlinformation('Prereservation');
                        } elseif ($item['status'] == 'bank') {
                            echo functions::Xmlinformation('RedirectPayment');
                        } elseif ($item['status'] == 'book') {
                            echo functions::Xmlinformation('Definitivereservation');
                        } elseif ($item['status'] == 'cancel') {
                            echo functions::Xmlinformation('Cancel');
                        } else {
                            echo functions::Xmlinformation('Unknow');
                        }
                        if($item['status'] == 'book'){
                            $process_status = isset($visaRequestStatus->getSingle($item['visa_request_status_id'])['title']) ? $visaRequestStatus->getSingle($item['visa_request_status_id'])['title'] : functions::Xmlinformation('NotSpecified');
                        	echo '/<br />'.$process_status;
                        }

                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">
                        <div class="dropdownUserBuy">
                            <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>
                            <div class="dropdown-content-UserBuy ">
                                <a id="myBtn" onclick="modalListVisa('<?php echo $item['factor_number']; ?>');"
                                   class="btn btn-primary fa fa-search margin-10"
                                   title="<?php echo functions::Xmlinformation('ShowReservation'); ?>  <?php echo functions::Xmlinformation('Visa'); ?>"></a>
                                <?php
                                if ($item['status'] == 'book') {
                                    ?>
                                    <a id="cancelbyuser"
                                       title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                                       onclick="modalCancelBuy('visa', '<?php echo $item['factor_number']; ?>'); return false;"
                                       class="btn btn-danger fa fa-times"></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </td>

                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
             </div>
        <?php
        $print = ob_get_clean();
        return $print;


    }

    public function getTrainBuyList($param)
    {
        $objUser = Load::controller('user');
        $train = Load::controller('bookingTrain');
        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = "SELECT   
                    *
                 FROM book_train_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            if(SOFTWARE_LANG == 'fa'){
                $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }else{
                $date_of_int = mktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
                $date_to_int = mktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            }
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (factor_number = '{$param['factorNumber']}' OR requestNumber='{$param['factorNumber']}') ";
        }
        $sql .= "GROUP BY factor_number,TrainNumber
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);

        ob_start();
        ?>
             <div class="content-table">
                <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Origin'); ?>
                    <br/><?php echo functions::Xmlinformation('Destination'); ?></th>
                <th><?php echo functions::Xmlinformation('Buydate'); ?>
                    <br/><?php echo functions::Xmlinformation('WachterNumber'); ?></th>
                <th><?php echo functions::Xmlinformation('TrainName');?><br/>
                   <?php echo functions::Xmlinformation('TrainNumber'); ?></th>
                <th><?php  echo functions::Xmlinformation('dateMove');?>
                    <br/><?php echo functions::Xmlinformation('RunTime'); ?></th>
                <th><?php echo functions::Xmlinformation('Namepassenger'); ?></th>
                <th><?php echo functions::Xmlinformation('Amount'); ?></th>
                <th><?php echo functions::Xmlinformation('Status'); ?></th>
                <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($bookList as $item) {
                $number++;
                ?>
                <tr>
                    <td data-content="<?php echo functions::Xmlinformation('Row'); ?>"><?php echo $number; ?></td>
                    <td data-content="<?php echo functions::Xmlinformation('Origin'); ?>">
                        <?php
                        if ($item['Departure_City'] != '') {
                            echo $item['Departure_City'] . '<br/>' . $item['Arrival_City'];
                        } else {
                            echo '-----------';
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Buydate'); ?>" dir="ltr">
                        <?php
                        if ($item['creation_date_int'] != '') {
                            echo functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'],SOFTWARE_LANG)

                            . '<br/>';
                        } else {
                            echo '-----------';
                        }

                            echo  $item['factor_number'] ;

                       ?>

                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('TrainName');?>">
                        <?php
                        echo $item['CompanyName'] . '<br/>' . $item['TrainNumber'];
                        ?>
                    </td>
                    <td data-content="<?php  echo functions::Xmlinformation('dateMove');?>">
                        <?php
                        echo functions::printDateIntByLanguage('Y-m-d', strtotime($item['ExitDate']),SOFTWARE_LANG)

                                                                . '<br/>' . $objUser->format_hour($item['ExitTime']);
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Namepassenger'); ?>"> <?php
                        echo $item['member_name'];
                        ?></td>
                    <td data-content="<?php echo functions::Xmlinformation('Amount'); ?>">
                        <?php
//                        echo number_format(functions::calcDiscountCodeByFactor(functions::CalculateDiscount($item['request_number']), $item['factor_number']));

                            echo number_format($train->TotalPriceByRequestNumber($item['requestNumber'],$item['successfull']));
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                        <?php
                        if ($item['successfull'] == 'nothing') {
                            echo functions::Xmlinformation('Unknow');
                        } elseif ($item['successfull'] == 'prereserve') {
                            echo functions::Xmlinformation('Prereservation');
                        } elseif ($item['successfull'] == 'bank') {
                            echo functions::Xmlinformation('RedirectPayment');
                        } elseif ($item['successfull'] == 'book') {
                            echo functions::Xmlinformation('Definitivereservation');
                        }
                        ?>
                    </td>
                    <td data-content="<?php echo functions::Xmlinformation('Show'); ?>" style="width: 21%">

                        <?php if ($item['successfull'] == 'book') { ?>
                        <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=trainBooking&id=<?php echo $item['requestNumber']; ?>"
                           title="<?php echo functions::Xmlinformation('ViewTickets'); ?>"
                           class="btn btn-primary  btnListTrain" target="_blank" style="width: 49px"><?php  echo functions::Xmlinformation('ViewTickets');?></a>
                           <!-- <a id="cancelbyuser"
                               title="<?php /*echo functions::Xmlinformation('Cancelflight'); */?>"
                               onclick="ModalCancelUser('train', '<?php /*echo $item['requestNumber']; */?>'); return false;"
                               class="btn btn-danger btnListTrain" style="width: 49px"><?php /* echo functions::Xmlinformation('Cancelflight');*/?></a>-->
                        <a id="cancelbyuser"
                           title="<?php echo functions::Xmlinformation('Cancelflight'); ?>"
                           href="https://refund.raja.ir/" target="_blank"
                           class="btn btn-danger btnListTrain" style="width: 49px"><?php  echo functions::Xmlinformation('Cancelflight');?></a>
                    <?php } ?>

                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
             </div>
        <?php
        $print = ob_get_clean();
        return $print;


    }

    public function getBusBuyList($param)
    {
        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();

        $sql = "SELECT   
                    * , GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs
                 FROM book_bus_tb 
                 WHERE 
                    member_id='{$id}' ";
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (passenger_factor_num = '{$param['factorNumber']}') ";
        }
        $sql .= "
                GROUP BY passenger_factor_num 
                ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);

        ob_start();
        ?>
            <div class="content-table">
                <table id="userProfile" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><?php echo functions::Xmlinformation('Row'); ?></th>
                        <th><?php echo functions::Xmlinformation("Origin"); ?><br/><?php echo functions::Xmlinformation("Destination"); ?></th>
                        <th><?php echo functions::Xmlinformation("Passengercompany"); ?><br/><?php echo functions::Xmlinformation("busType"); ?></th>
                        <th><?php echo functions::Xmlinformation("Invoicenumber"); ?><br/><?php echo functions::Xmlinformation("Ticketnumber"); ?></th>
                        <th><?php echo functions::Xmlinformation("SeatNumber"); ?></th>
                        <th><?php echo functions::Xmlinformation("dateMove"); ?><br/><?php echo functions::Xmlinformation("timeMove"); ?></th>
                        <th><?php echo functions::Xmlinformation("Totalamount"); ?></th>
                        <th><?php echo functions::Xmlinformation("Status"); ?></th>
                        <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach ($bookList as $item) {
                        $number++;
                        ?>
                        <tr>
                            <td data-content="<?php echo functions::Xmlinformation('Row'); ?>"><?php echo $number; ?></td>
                            <td data-content="<?php echo functions::Xmlinformation("Origin"); ?>"><?php echo $item['OriginCity'] . '<br/>' . $item['DestinationCity']; ?></td>
                            <td data-content="<?php echo functions::Xmlinformation("Passengercompany"); ?>"><?php echo $item['CompanyName']; ?></td>
                            <td data-content="<?php echo functions::Xmlinformation("Invoicenumber"); ?>"><?php echo $item['passenger_factor_num'] . '<br/>' . $item['pnr']; ?></td>
                            <td data-content="<?php echo functions::Xmlinformation("SeatNumber"); ?>"><?php echo $item['chairs']; ?></td>
                            <td data-content="<?php echo functions::Xmlinformation("dateMove"); ?>"><?php echo $item['DateMove'] . '<br/>' . $item['TimeMove']; ?></td>
                            <td data-content="<?php echo functions::Xmlinformation("Totalamount"); ?>"><?php echo number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['passenger_factor_num'])); ?></td>
                            <td data-content="<?php echo functions::Xmlinformation("Status"); ?>">
                                <?php
                                switch ($item['status']) {
                                    case 'book':
                                        $status = functions::Xmlinformation("Definitivereservation");
                                        break;
                                    case 'temporaryReservation':
                                        $status = functions::Xmlinformation("Temporaryreservation");
                                        break;
                                    case 'prereserve':
                                        $status = functions::Xmlinformation("Prereservation");
                                        break;
                                    case 'bank':
                                        $status = functions::Xmlinformation("NavigateToPort");
                                        break;
                                    case 'cancel':
                                        $status = functions::Xmlinformation("Cancel");
                                        break;
                                    case 'nothing':
                                        $status = functions::Xmlinformation("Unknown");
                                        break;
                                    default:
                                        $status = functions::Xmlinformation("Unknown");
                                        break;
                                }
                                echo $status;
                                ?>
                            </td>
                            <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">
                                <?php
                                if ($item['status'] == 'book') {
                                    ?>
                                    <div class="dropdownUserBuy">
                                        <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>
                                        <div class="dropdown-content-UserBuy ">
                                            <a href="<?php echo ROOT_ADDRESS; ?>/eBusTicket&num=<?php echo $item['passenger_factor_num']; ?>"
                                               class="btn btn-dropbox fa fa-print  margin-10"
                                               target="_blank"
                                               title="  <?php echo functions::Xmlinformation('Shownformation'); ?> <?php echo functions::Xmlinformation('Bus'); ?>"></a>

                                            <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=bookingBusShow&id=<?php echo $item['passenger_factor_num']; ?>"
                                               title="<?php echo functions::Xmlinformation('Pdff'); ?>"
                                               class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>
                                            <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=busBoxCheck&id=<?php echo $item['passenger_factor_num']; ?>"
                                               title="<?php echo functions::Xmlinformation('Viewbill'); ?>"
                                               class="btn btn-info  fa fa-money margin-10"
                                               target="_blank"></a>
<!--                                            <a href="--><?php //echo ROOT_ADDRESS_WITHOUT_LANG; ?><!--/pdf&target=bookingBusForeign&id=--><?php //echo $item['passenger_factor_num']; ?><!--"-->
<!--                                               title="--><?php //echo functions::Xmlinformation('pdff'); ?><!--"-->
<!--                                               class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>-->
                                            <?php
                                            if (CLIENT_ID == 271) {
                                                $reservationProof = Load::controller('reservationProof');
                                                $file = $reservationProof->getProofFile($item['order_code'] , 'Bus');

                                                if($file && isset($file) && !empty($file)){
                                            ?>
                                            <a onclick="modalForReservationProof('<?php echo $item['order_code']; ?>' , 'Bus');"
                                               title="<?php echo functions::Xmlinformation('ViewProof'); ?>"
                                               class="btn btn-info  fa fa-download margin-10"
                                               target="_blank"></a>
                                          <?php
                                              }
                                            }
                                          ?>
                                            <a id="cancelbyuser"
                                               onclick="ModalCancelUser('bus','<?php echo $item['order_code']; ?>'); return false;"
                                               title="<?php echo functions::Xmlinformation('RefundTicket'); ?>"
                                               class="btn btn-danger fa fa-times"></a>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        <?php
        $print = ob_get_clean();
        return $print;
    }

    public function getEntertainmentBuyList($param)
    {
        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();

        $bookEntertainmentModel=$this->getModel('bookEntertainmentModel');

        $result=$bookEntertainmentModel->get()
            ->where('member_id',$id);


        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $_POST['startDate']);
            $date_to = explode('-', $_POST['endDate']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $result=$result->where('creation_date_int',$date_of_int,'>=')
                ->where('creation_date_int',$date_to_int,'<=');

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $result=$result->where('factor_number',$param['factorNumber']);
        }

        $result=$result->groupBy('factor_number')
            ->orderBy('creation_date_int','desc')
        ->all();

        $bookList = $result;

        ob_start();
        ?>
      <div class="content-table">
        <table id="userProfile" class="display" cellspacing="0" width="100%">
          <thead>
          <tr>
            <th><?php echo functions::Xmlinformation('Row'); ?></th>
            <th><?php echo functions::Xmlinformation("Destination"); ?></th>
            <th><?php echo functions::Xmlinformation("EntertainmentTitle"); ?></th>
            <th><?php echo functions::Xmlinformation("Invoicenumber"); ?><br/><?php echo functions::Xmlinformation("Ticketnumber"); ?></th>
            <th><?php echo functions::Xmlinformation("Countpeople"); ?></th>
            <th><?php echo functions::Xmlinformation("Totalamount"); ?></th>
            <th><?php echo functions::Xmlinformation('Show'); ?><span class="display-block"><?php echo functions::Xmlinformation('Cancel'); ?></span></th>
          </tr>
          </thead>

          <tbody>
          <?php
          foreach ($bookList as $item) {
            $entertainment=$this->getController('entertainment');
              $entertainment=$entertainment->GetEntertainmentData(null,null,null , null,$item['EntertainmentId'],null);

              $number++;

              ?>
            <tr>
              <td data-content="<?php echo functions::Xmlinformation('Row'); ?>"><?php echo $number; ?></td>
              <td data-content="<?php echo functions::Xmlinformation("Destination"); ?>"><?php echo $entertainment['RCountryTitle'] . '-' . $entertainment['RCityTitle']; ?></td>
              <td data-content="<?php echo functions::Xmlinformation("EntertainmentTitle"); ?>"><?php echo $entertainment['title']; ?></td>
              <td data-content="<?php echo functions::Xmlinformation("Invoicenumber"); ?>"><?php echo $item['factor_number'] ?></td>
              <td data-content="<?php echo functions::Xmlinformation("Countpeople"); ?>"><?php echo $item['CountPeople']; ?></td>
              <td data-content="<?php echo functions::Xmlinformation("Totalamount"); ?>"><?php echo number_format($entertainment['price']); ?></td>

              <td data-content="<?php echo functions::Xmlinformation('Show'); ?>">
                  <?php
                  switch ($item['successfull']) {
                      case 'book':
                          $status = functions::Xmlinformation("Definitivereservation");
                          break;
                      case 'temporaryReservation':
                          $status = functions::Xmlinformation("Temporaryreservation");
                          break;
                      case 'prereserve':
                          $status = functions::Xmlinformation("Prereservation");
                          break;
                      case 'bank':
                          $status = functions::Xmlinformation("NavigateToPort");
                          break;
                      case 'cancel':
                          $status = functions::Xmlinformation("Cancel");
                          break;
                      case 'nothing':
                          $status = functions::Xmlinformation("Unknown");
                          break;
                      default:
                          $status = functions::Xmlinformation("Unknown");
                          break;
                  }
                  echo $status;
                  ?>
                  <?php
                  if ($item['successfull'] == 'book') {
                      ?>
                    <div class="dropdownUserBuy">
                      <button class="dropbtnUserBuy"><?php echo functions::Xmlinformation('Detail'); ?></button>
                      <div class="dropdown-content-UserBuy ">
                        <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=entertainment&id=<?php echo $item['factor_number']; ?>"
                           title="<?php echo functions::Xmlinformation('Pdff'); ?>"
                           class="btn btn-info  fa fa-file-pdf-o" target="_blank"></a>

                      </div>
                    </div>
                      <?php
                  }
                  ?>
              </td>
            </tr>
              <?php
          }
          ?>
          </tbody>
        </table>
      </div>

        <?php
        $print = ob_get_clean();
        return $print;
    }

    /**
     * @throws Exception
     */
    public function apiGetFlightData($params)
    {

        $id = Session::getUserId();
        $info_agency = functions::infoAgencyByMemberId($id);
        $objUser = Load::controller('user');

        $flight_data = $this->getModel('bookLocalModel');
        $flight_data = $flight_data->get('origin_city,desti_city,request_number,creation_date_int,airline_name,member_id,
                    flight_number,time_flight,date_flight,factor_number,successfull,IsInternal,type_app,flight_type,
                    currency_code,currency_equivalent');
        $flight_data = $flight_data->where('member_id', $id)
            ->where('request_number', '0', '>')
            ->where('successfull', 'nothing', '<>');


        if (!empty($params['date_range']['start']) && !empty($params['date_range']['end'])) {
            $start_date = explode('-', $params['date_range']['start']);
            $end_date = explode('-', $params['date_range']['end']);
            if (SOFTWARE_LANG === 'fa') {
                $start_date_int = dateTimeSetting::jmktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = dateTimeSetting::jmktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            } else {
                $start_date_int = mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = mktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            }
            $flight_data = $flight_data->where('creation_date_int', $start_date_int, '>=')
                ->where('creation_date_int', $end_date_int, '<=');
        }
        if (!empty($params['factor_number'])) {
            $flight_data = $flight_data->where('request_number', $params['factor_number'])
                ->orWhere('factor_number', $params['factor_number']);
        }
        if (!empty($params['reserve_status']) && $params['reserve_status'] !== 'all' && $params['reserve_status'] !== 'canceled') {
            $flight_data = $flight_data->where('successfull', $params['reserve_status']);
        }
        if (!empty($params['reserve_status']) && $params['reserve_status'] === 'canceled') {
            $flight_data = $flight_data->where('request_cancel', 'confirm');
        }



        $flight_data = $flight_data->groupBy('request_number');
        $flight_data = $flight_data->orderBy('creation_date_int');

        $data=$flight_data->all();
        $result=[];
        foreach ($data as $key=>$item) {
            $result[$key]=$item;
            $result[$key]['creation_date_int']=functions::printDateIntByLanguage('Y-m-d (H:i:s)',$item['creation_date_int'],SOFTWARE_LANG);

            $amountBuy = functions::CalculateDiscount($item['request_number']) ;
            $calculate_currency = $item['currency_equivalent'] > 0 ? functions::ticketPriceCurrency($amountBuy,$item['currency_equivalent']): $amountBuy;
            $number_format_float = ($info_agency['type_payment'] == 'currency' && SOFTWARE_LANG !="fa") ? 2 : 0 ;
            $result[$key]['price']= number_format(functions::calcDiscountCodeByFactor($calculate_currency, $item['factor_number']),$number_format_float);
            $result[$key]['passenger']= $objUser->showBuy($item['request_number']);
            $result[$key]['date_flight']= functions::printDateIntByLanguage('Y-m-d',strtotime($item['date_flight']),SOFTWARE_LANG);

        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function apiGetHotelData($params)
    {

        $objUser = Load::controller('user');
        $number = 0;
        $id = Session::getUserId();

        $hotel_data = $this->getModel('bookHotelLocalModel');
        $hotel_data = $hotel_data->get();
        $hotel_data = $hotel_data->where('member_id', $id);


        if (!empty($params['date_range']['start']) && !empty($params['date_range']['end'])) {
            $start_date = explode('-', $params['date_range']['start']);
            $end_date = explode('-', $params['date_range']['end']);
            if (SOFTWARE_LANG === 'fa') {
                $start_date_int = dateTimeSetting::jmktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = dateTimeSetting::jmktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            } else {
                $start_date_int = mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = mktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            }
            $hotel_data = $hotel_data->where('creation_date_int', $start_date_int, '>=')
                ->where('creation_date_int', $end_date_int, '<=');
        }
        if (!empty($params['factor_number'])) {
            $hotel_data = $hotel_data->Where('factor_number', $params['factor_number']);
        }
        if (!empty($params['reserve_status']) && $params['reserve_status'] !== 'all') {
            if($params['reserve_status'] === 'book')
                $reserve_status='BookedSuccessfully';
            if($params['reserve_status'] === 'prereserve')
                $reserve_status='PreReserve';
            if($params['reserve_status'] === 'nothing')
                $reserve_status='OnRequest';
            if($params['reserve_status'] === 'canceled')
                $reserve_status='Cancelled';

            $hotel_data = $hotel_data->where('status', $reserve_status);
        }


        $hotel_data = $hotel_data->groupBy('factor_number');
        $hotel_data = $hotel_data->orderBy('creation_date_int');

        $data=$hotel_data->all();
        $result=[];
        foreach ($data as $key=>$item) {
            $result[$key] = $item;
            $result[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'], SOFTWARE_LANG);



            $result[$key]['price'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['factor_number']));


        }
        return $result;
    }
    /**
     * @throws Exception
     */
    public function apiGetInsuranceData($params)
    {

        $objUser = Load::controller('user');
        $number = 0;
        $id = Session::getUserId();

        $insurance_data = $this->getModel('bookInsuranceModel');
        $insurance_data = $insurance_data->get();
        $insurance_data = $insurance_data->where('member_id', $id);


        if (!empty($params['date_range']['start']) && !empty($params['date_range']['end'])) {
            $start_date = explode('-', $params['date_range']['start']);
            $end_date = explode('-', $params['date_range']['end']);
            if (SOFTWARE_LANG === 'fa') {
                $start_date_int = dateTimeSetting::jmktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = dateTimeSetting::jmktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            } else {
                $start_date_int = mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = mktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            }
            $insurance_data = $insurance_data->where('creation_date_int', $start_date_int, '>=')
                ->where('creation_date_int', $end_date_int, '<=');
        }
        if (!empty($params['factor_number'])) {
            $insurance_data = $insurance_data->where('factor_number', $params['factor_number']);
        }

        if (!empty($params['reserve_status']) && $params['reserve_status'] !== 'all') {
            if($params['reserve_status'] === 'book')
                $reserve_status='book';
            if($params['reserve_status'] === 'prereserve')
                $reserve_status='prereserve';
            if($params['reserve_status'] === 'nothing')
                $reserve_status='nothing';
            if($params['reserve_status'] === 'canceled')
                $reserve_status='cancel';

            $insurance_data = $insurance_data->where('status', $reserve_status);
        }

        $insurance_data = $insurance_data->groupBy('factor_number');
        $insurance_data = $insurance_data->orderBy('creation_date_int');

        $data=$insurance_data->all();
        $result=[];
        foreach ($data as $key=>$item) {
            $result[$key] = $item;
            $result[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'], SOFTWARE_LANG);



            $result[$key]['price'] = number_format(functions::calcDiscountCodeByFactor($objUser->total_price_insurance($item['factor_number']), $item['factor_number']));


        }
        return $result;
    }

    /**
     * @throws Exception
     */
    public function apiGetTourData($params)
    {

        $objUser = Load::controller('user');
        $number = 0;
        $id = Session::getUserId();

        $tour_data = $this->getModel('bookTourLocalModel');
        $tour_data = $tour_data->get();
        $tour_data = $tour_data->where('member_id', $id);


        if (!empty($params['date_range']['start']) && !empty($params['date_range']['end'])) {
            $start_date = explode('-', $params['date_range']['start']);
            $end_date = explode('-', $params['date_range']['end']);
            if (SOFTWARE_LANG === 'fa') {
                $start_date_int = dateTimeSetting::jmktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = dateTimeSetting::jmktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            } else {
                $start_date_int = mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = mktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            }
            $tour_data = $tour_data->where('creation_date_int', $start_date_int, '>=')
                ->where('creation_date_int', $end_date_int, '<=');
        }
        if (!empty($params['factor_number'])) {
            $tour_data = $tour_data->where('factor_number', $params['factor_number']);
        }

        if (!empty($params['reserve_status']) && $params['reserve_status'] !== 'all') {
            if($params['reserve_status'] === 'book')
                $reserve_status='BookedSuccessfully';
            if($params['reserve_status'] === 'prereserve')
                $reserve_status='TemporaryReservation';
            if($params['reserve_status'] === 'nothing')
                $reserve_status='TemporaryPreReserve';
            if($params['reserve_status'] === 'canceled')
                $reserve_status='Cancellation';

            $tour_data = $tour_data->where('status', $reserve_status);
        }

        $tour_data = $tour_data->groupBy('factor_number');
        $tour_data = $tour_data->orderBy('creation_date_int');

        $data=$tour_data->all();
        $result=[];
        foreach ($data as $key=>$item) {
            $result[$key] = $item;
            $result[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'], SOFTWARE_LANG);



            $result[$key]['start_date'] = functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['tour_start_date'], SOFTWARE_LANG);
            $result[$key]['price'] = number_format($item['tour_payments_price']);


        }
        return $result;
    }
    /**
     * @throws Exception
     */
    public function apiGetBusData($params)
    {

        $objUser = Load::controller('user');
        $number = 0;
        $id = Session::getUserId();

        $bus_data = $this->getModel('bookBusModel');
        $bus_data = $bus_data->get([
                '*',
                "GROUP_CONCAT(passenger_chairs SEPARATOR ', ') as chairs",
        ]);
        $bus_data = $bus_data->where('member_id', $id);


        if (!empty($params['date_range']['start']) && !empty($params['date_range']['end'])) {
            $start_date = explode('-', $params['date_range']['start']);
            $end_date = explode('-', $params['date_range']['end']);
            if (SOFTWARE_LANG === 'fa') {
                $start_date_int = dateTimeSetting::jmktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = dateTimeSetting::jmktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            } else {
                $start_date_int = mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = mktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            }
            $bus_data = $bus_data->where('creation_date_int', $start_date_int, '>=')
                ->where('creation_date_int', $end_date_int, '<=');
        }
        if (!empty($params['factor_number'])) {
            $bus_data = $bus_data->where('passenger_factor_num', $params['factor_number']);
        }

        if (!empty($params['reserve_status']) && $params['reserve_status'] !== 'all') {
            if($params['reserve_status'] === 'book')
                $reserve_status='book';
            if($params['reserve_status'] === 'prereserve')
                $reserve_status='prereserve';
            if($params['reserve_status'] === 'nothing')
                $reserve_status='nothing';
            if($params['reserve_status'] === 'canceled')
                $reserve_status='cancel';

            $bus_data = $bus_data->where('status', $reserve_status);
        }

        $bus_data = $bus_data->groupBy('passenger_factor_num');
        $bus_data = $bus_data->orderBy('creation_date_int');

        $data=$bus_data->all();
        $result=[];
        foreach ($data as $key=>$item) {
            $result[$key] = $item;
            $result[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'], SOFTWARE_LANG);




            $result[$key]['start_date'] = functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['tour_start_date'], SOFTWARE_LANG);
            $result[$key]['price'] = number_format(functions::calcDiscountCodeByFactor($item['total_price'], $item['passenger_factor_num']));


        }
        return $result;
    }


    /**
     * @throws Exception
     */
    public function apiGetTrainData($params)
    {

        $objUser = Load::controller('user');
        $train = Load::controller('bookingTrain');
        $number = 0;
        $id = Session::getUserId();

        $train_data = $this->getModel('bookTrainModel');
        $train_data = $train_data->get();
        $train_data = $train_data->where('member_id', $id);


        if (!empty($params['date_range']['start']) && !empty($params['date_range']['end'])) {
            $start_date = explode('-', $params['date_range']['start']);
            $end_date = explode('-', $params['date_range']['end']);
            if (SOFTWARE_LANG === 'fa') {
                $start_date_int = dateTimeSetting::jmktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = dateTimeSetting::jmktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            } else {
                $start_date_int = mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]);
                $end_date_int = mktime(23, 59, 59, $end_date[1], $end_date[2], $end_date[0]);
            }
            $train_data = $train_data->where('creation_date_int', $start_date_int, '>=')
                ->where('creation_date_int', $end_date_int, '<=');
        }
        if (!empty($params['factor_number'])) {
            $train_data = $train_data->where('factor_number', $params['factor_number']);
        }

        if (!empty($params['reserve_status']) && $params['reserve_status'] !== 'all' && $params['reserve_status'] !== 'canceled') {
            $train_data = $train_data->where('successfull', $params['reserve_status']);
        }
        if (!empty($params['reserve_status']) && $params['reserve_status'] === 'canceled') {
            $train_data = $train_data->where('request_cancel', 'confirm');
        }

        $train_data = $train_data->groupBy('factor_number,TrainNumber');
        $train_data = $train_data->orderBy('creation_date_int');

        $data=$train_data->all();
        $result=[];
        foreach ($data as $key=>$item) {
            $result[$key] = $item;
            $result[$key]['creation_date_int'] = functions::printDateIntByLanguage('Y-m-d (H:i:s)', $item['creation_date_int'], SOFTWARE_LANG);



            $result[$key]['ExitDate'] = functions::DateJalali($item['ExitDate']);
             $result[$key]['price'] = number_format($train->TotalPriceByRequestNumber($item['requestNumber'],$item['successfull']));


        }
        return $result;
    }
    /**
     * @throws Exception
     */
    public function apiGetData($params)
    {
        $is_login = Session::IsLogin();


        if ($is_login) {
            if ($params['tab_index']) {
                $data = [];
                switch ($params['tab_index']) {
                    case 'flight':
                        $data = $this->apiGetFlightData($params['form']);
                        break;
                    case 'hotel':
                        $data = $this->apiGetHotelData($params['form']);
                        break;
                    case 'insurance':
                        $data = $this->apiGetInsuranceData($params['form']);
                        break;
                    case 'tour':
                        $data = $this->apiGetTourData($params['form']);
                        break;
                    case 'bus':
                        $data = $this->apiGetBusData($params['form']);
                        break;
                    case 'train':
                        $data = $this->apiGetTrainData($params['form']);
                        break;

                    default:

                        break;
                }

                return functions::withSuccess($data);
            }
        }
        return functions::withError(false,403);
    }
    /**
     * > It returns the client's main domain and the online url
     *
     * @return The client data is being returned.
     */
    public function apiGetClientData()
    {
         $data=[
          'client_data'=>CLIENT_MAIN_DOMAIN,
          'online_url'=>'https://'.CLIENT_DOMAIN,
        ];
        return functions::withSuccess($data);
    }


    public function apiGetCancellationData($data) {

        $type = $data['type'];
        $request_number = $data['request_number'];
        $booking_bus_ticket = $this->getController('user');
        $result['data'] = $booking_bus_ticket->InfoModalTicketCancel($request_number, $type);
        if ($type == 'flight') {
            $Fee = functions::FeeCancelFlight($result['data'][0]['airline_iata'], $result['data'][0]['cabin_type']);
            $member = $this->getController('members');
            $result['is_counter'] = $member->isCounter();
            $result['fee'] = $Fee;
        }
        return functions::withSuccess($result);

    }




    /*start new code 1402/06/07*/

    public function getBuyBookMember($param)
    {

        $objUser = Load::controller('user');
//        $Model = Load::library('Model');
        $user_id = Session::getUserId();

        if ($user_id) {
            if ($param['target'] == 'all' || $param['target'] == '') {
                parse_str($param['filter'], $param);
                $_POST = $param;
//                echo json_encode($param);
//            die;
                $data_book = $objUser->getBookAllItem($param);
            } elseif ($param['target'] == 'flight') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllFlight($param);
            } elseif ($param['target'] == 'hotel') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllHotel($param);
            } elseif ($param['target'] == 'insurance') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllInsurance($param);
            } elseif ($param['target'] == 'gashttransfer') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllGashttransfer($param);
            } elseif ($param['target'] == 'tour') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllTour($param);
            } elseif ($param['target'] == 'visa') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllVisa($param);
            } elseif ($param['target'] == 'bus') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllBus($param);
            } elseif ($param['target'] == 'train') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllTrain($param);
            } elseif ($param['target'] == 'entertainment') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllEntertainment($param);
            } elseif ($param['target'] == 'europcar') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllEuropcar($param);
            }elseif ($param['target'] == 'exclusivetour') {
                parse_str($param['filter'], $param);
                $_POST = $param;
                $data_book = $objUser->getBookAllExclusiveTour($param);
            }

        }

        return json_encode( $data_book );

    }



}