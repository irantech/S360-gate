<?php

class userCancelBuy
{

    public $Model ;
    public $ModelBase ;
    public $id ;

    public function __construct()
    {
        $this->Model = Load::library('Model');
        $this->ModelBase = Load::library('ModelBase');
        $this->id = Session::getUserId();
    }

    public function getFlightBuyCancelList($param)
    {
        list($number, $bookList) = $this->getInfoCancelTrain($param);
        ob_start();
        ?>

        <div class="content-table">
            <table id="userProfile" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th><?php echo functions::Xmlinformation('Row'); ?></th>
            <th><?php echo functions::Xmlinformation('Reasonrequest'); ?></th>
            <th><?php echo functions::Xmlinformation('Numberreservation'); ?></th>
            <th><?php echo functions::Xmlinformation('Dateapplication'); ?></th>
            <th><?php echo functions::Xmlinformation('Approvaldate'); ?>/<?php echo functions::Xmlinformation('Rejectrequest'); ?></th>
            <th><?php echo functions::Xmlinformation('Percentagepenalty'); ?></th>
            <th><?php echo functions::Xmlinformation('Refundamount'); ?></th>
            <th><?php echo functions::Xmlinformation('Status'); ?></th>
            <th><?php echo functions::Xmlinformation('Showmoredetail'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($bookList as $item) {
            $number++;
            ?>
            <tr>
                <td data-content="<?php echo functions::Xmlinformation('Row'); ?>"><?php echo $number; ?></td>
                <td data-content="<?php echo functions::Xmlinformation('Reasonrequest'); ?>">
                    <?php
                    if ($item['ReasonMember'] == 'PersonalReason') {
                        echo functions::Xmlinformation('Cancelbecauseperson');
                    } elseif ($item['ReasonMember'] == 'DelayTwoHours') {
                        echo functions::Xmlinformation('Delaymorethantwohours');
                    } elseif ($item['ReasonMember'] == 'CancelByAirline') {
                        echo functions::Xmlinformation('Canceledby') . ' ' . functions::Xmlinformation('Airline');
                    } else {
                        echo '-----------';
                    }
                    ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Numberreservation'); ?>">
                    <a target="_blank" href="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pdf&target=trainBooking&id=<?php echo $item['RequestNumber']; ?>"><?php echo $item['RequestNumber']; ?></a>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Dateapplication'); ?>">
                    <?php echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateRequestMemberInt']); ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Approvaldate'); ?>">
                    <?php
                    if ($item['DateSetCancelInt'] != '0' || $item['DateConfirmCancelInt'] != '0' || $item['DateSetFailedIndemnityInt'] != '0') {

                        if ($item['Status'] == 'SetCancelClient') {
                            echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateSetCancelInt']);
                        } elseif ($item['Status'] == 'ConfirmCancel') {
                            echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateConfirmCancelInt']);
                        } elseif ($item['Status'] == 'SetFailedIndemnity') {
                            echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateSetFailedIndemnityInt']);
                        } else {
                            echo '-------';
                        }

                    } else {
                        echo '-------';
                    }
                    ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Percentagepenalty'); ?>">
                    <?php
                    if ($item['Status'] == 'ConfirmCancel') {
                        echo $item['PercentIndemnity'] . ' % ';
                    } else {
                        echo '-------';
                    }
                    ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Refundamount'); ?>">
                    <?php
                    if ($item['PriceIndemnity'] != '' && $item['Status'] == 'ConfirmCancel') {
                        echo number_format($item['PriceIndemnity']) . ' ' . functions::Xmlinformation('Rial');
                    } else {
                        echo '-------';
                    }
                    ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                    <?php
                    if ($item['Status'] == 'RequestMember') {
                        echo '<div class="btn btn-primary">' . functions::Xmlinformation('SendRequest') . '</div>';
                    } elseif ($item['Status'] == 'SetCancelClient' || $item['Status'] == 'SetFailedIndemnity') {
                        echo '<div class="btn btn-danger">' . functions::Xmlinformation('Rejectrequest') . '</div>';
                    } elseif ($item['Status'] == 'RequestClient' || $item['Status'] == 'SetIndemnity' || $item['Status'] == 'ConfirmClient') {
                        echo '<div class="btn btn-warning">' . functions::Xmlinformation('Pending') . '</div>';
                    } elseif ($item['Status'] == 'ConfirmCancel') {
                        echo '<div class="btn btn-success">' . functions::Xmlinformation('Approve') . '</div>';
                    } elseif ($item['Status'] == 'close') {
                        echo '<div class="btn btn-success">' . functions::Xmlinformation('closeTicket') . '</div>';
                    } else {
                        echo '-------';
                    }
                    ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Showmoredetail'); ?>">
                    <a onclick="ModalTrackingCancelTicket('<?php echo $item['RequestNumber']; ?>','<?php echo $item['id']; ?>')"
                       class="btn btn-bitbucket fa fa-search"></a>
                    <?php
                    if ($item['Status'] == 'ConfirmCancel' &&  $param['appType'] != 'train') {
                    if ($param['appType'] == 'bus') {?>

                        <a href="<?php echo SERVER_HTTP . CLIENT_DOMAIN . '/gds/pdf&target=bookingBusShow&id=' . $item['FactorNumber'] . '&cancelStatus=confirm'; ?>"
                           class="btn btn-info  fa fa-file-pdf-o" style="margin: 5px;"
                           target="_blank"> <?php echo functions::Xmlinformation('Cancellationprint'); ?> </a>

                    <?php }
                    else {

                       ?>
                        <a href="<?php echo SERVER_HTTP . CLIENT_DOMAIN . '/gds/pdf&target=parvazBookingLocal&id=' . $item['RequestNumber'] . '&cancelStatus=confirm'; ?>"
                           class="btn btn-info  fa fa-file-pdf-o" style="margin: 5px;"
                           target="_blank"> <?php echo functions::Xmlinformation('Cancellationprint'); ?> </a>
                        <?php
                    }
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

    public function getOtherServiceBuyCancelList($param)
    {
        $number = 0;
        $Model = Load::library('Model');
        $id = Session::getUserId();
        $sql = " SELECT * FROM cancel_buy_tb WHERE id_member = '{$id}' ";
        if (isset($param['appType']) && $param['appType'] != '') {
            $sql .= " AND type_application ='{$param['appType']}'";
        }
        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $param['startDate']);
            $date_to = explode('-', $param['endDate']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);


            $sql .= " AND creation_date_int >= '{$date_of_int}' AND creation_date_int  <= '{$date_to_int}'";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND factor_number ='{$param['factor_number']}'";
        }
        $sql .= "  ORDER BY creation_date_int DESC ";
        $bookList = $Model->select($sql);

        ob_start();
        ?>

        <div class="content-table">
            <table id="userProfile" class="display" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th><?php echo functions::Xmlinformation('Row'); ?></th>
            <th><?php echo functions::Xmlinformation('Invoicenumber'); ?></th>
            <th><?php echo functions::Xmlinformation('UserNameLogin'); ?></th>
            <th><?php echo functions::Xmlinformation('Dateandtimeofrequest'); ?>
                <br><?php echo functions::Xmlinformation('UserDescription'); ?></th>
            <th><?php echo functions::Xmlinformation('Dateandtimeofrequestconfirmation'); ?>
                <br><?php echo functions::Xmlinformation('ManagementDescription'); ?></th>
            <th><?php echo functions::Xmlinformation('Percentageofconsoles'); ?>
                <br><?php echo functions::Xmlinformation('Consularamount'); ?></th>
            <th><?php echo functions::Xmlinformation('Consoledateandtime'); ?></th>
            <th><?php echo functions::Xmlinformation('Action'); ?></th>
            <th><?php echo functions::Xmlinformation('Status'); ?></th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($bookList as $item) {
            $number++;

            $infoMember = functions::infoMember($item['id_member']);
            ?>
            <tr>
                <td data-content="<?php echo functions::Xmlinformation('Row'); ?>"><?php echo $number; ?></td>
                <td data-content="<?php echo functions::Xmlinformation('Invoicenumber'); ?>">
                    <?php if($param['appType']=='train'){
                        ?>
                        <a  href="<?php echo ROOT_ADDRESS_WITHOUT_LANG ?>/pdf&target=trainBooking&id=<?php echo  $item['factor_number']; ?>" target="_blank" ><?php echo  $item['factor_number']; ?></a>
                        <?php
                    }else{ echo $item['factor_number']; }
                    ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('UserNameLogin'); ?>">
                    <?php echo $infoMember['name'] . ' ' . $infoMember['family'];; ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Dateandtimeofrequest'); ?>">
                    <?php echo $item['request_date'] . ' ' . $item['request_time']; ?>
                    <br>
                    <?php echo $item['comment_user']; ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Dateandtimeofrequestconfirmation'); ?>">
                    <?php echo $item['confirm_date'] . ' ' . $item['confirm_time']; ?>
                    <br>
                    <?php echo $item['comment_admin']; ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Percentageofconsoles'); ?>">
                    <?php if ($item['cancel_percent'] != '') { echo $item['cancel_percent'] . ' % '; } ?>
                    <?php if ($item['cancel_price'] != '') {
                        echo '<br>' . number_format($item['cancel_price']) . ' ریال ';
                    }
                        ?>
                </td>

                <td data-content="<?php echo functions::Xmlinformation('Consoledateandtime'); ?>"><?php echo $item['cancelled_date'] . ' ' . $item['cancelled_time']; ?></td>
                <td data-content="<?php echo functions::Xmlinformation('Action'); ?>">
                    <?php
                    if ($item['status'] == 'confirm_admin') {
                       ?>
                        <a onclick="registerCancelBuy('<?php echo $item['factor_number']; ?>','<?php echo $item['type_application']; ?>')"
                           class="btn btn-bitbucket btnListTrain"><i class="fa fa-check"></i>   کنسل میکنم </a>
                        <?php
                    }
                    if ($item['status'] == 'cancelled') {
                        $pdf = SERVER_HTTP . CLIENT_DOMAIN;
                        switch ($item['type_application']) {
                            case 'hotel':
                                $pdf .= '/gds/pdf&target=BookingHotelLocal&id=' . $item['factor_number'] . '&cancelStatus=cancelled';
                                break;
                            default :
                                $pdf = '';
                                break;
                        }
                        if ($pdf != '' &&  $param['appType'] != 'train') {
                            ?>
                            <a href="<?php echo $pdf; ?>"
                               class="btn btn-info  fa fa-file-pdf-o" style="margin: 5px;"
                               target="_blank"> <?php echo functions::Xmlinformation('Cancellationprint'); ?> </a>
                            <?php
                        }
                    }
                    ?>
                </td>
                <td data-content="<?php echo functions::Xmlinformation('Status'); ?>">
                    <?php
                    if ($item['status'] == 'request_user') {
                        echo '<span class="btn btn-warning cursor-default btnListTrain cursor-auto">درخواست کنسلی کاربر</span>';
                    } elseif ($item['status'] == 'confirm_admin') {
                        echo '<span class="btn btn-success cursor-default btnListTrain cursor-auto">اعلام جریمه کنسلی</span>';
                    } elseif ($item['status'] == 'reject_cancel_request') {
                        echo '<span class="btn btn-danger cursor-default btnListTrain cursor-auto">رد درخواست کنسلی کاربر</a>';
                    } elseif ($item['status'] == 'cancelled') {
                        echo '<span class="btn btn-danger cursor-default btnListTrain cursor-auto">کنسل شده</span>';
                    } else {
                        echo '-------';
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


    public function getTrainBuyCancelList($param)
    {
        list($number, $bookList) = $this->getInfoCancelTrain($param);
        ob_start();
        ?>

        <table id="userProfile" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><?php echo functions::Xmlinformation('Row'); ?></th>
                <th><?php echo functions::Xmlinformation('Reasonrequest'); ?></th>
                <th><?php echo functions::Xmlinformation('Numberreservation'); ?></th>
                <th><?php echo functions::Xmlinformation('Dateapplication'); ?></th>
                <th><?php echo functions::Xmlinformation('Approvaldate'); ?>/<?php echo functions::Xmlinformation('Rejectrequest'); ?></th>
                <th><?php echo functions::Xmlinformation('Percentagepenalty'); ?></th>
                <th><?php echo functions::Xmlinformation('Refundamount'); ?></th>
                <th><?php echo functions::Xmlinformation('Status'); ?></th>
                <th><?php echo functions::Xmlinformation('Showmoredetail'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($bookList as $item) {
                $number++;
                ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td>
                        <?php
                        if ($item['ReasonMember'] == 'PersonalReason') {
                            echo functions::Xmlinformation('Cancelbecauseperson');
                        } elseif ($item['ReasonMember'] == 'DelayTwoHours') {
                            echo functions::Xmlinformation('Delaymorethantwohours');
                        } elseif ($item['ReasonMember'] == 'CancelByAirline') {
                            echo functions::Xmlinformation('Canceledby') . ' ' . functions::Xmlinformation('Airline');
                        } else {
                            echo '-----------';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $item['RequestNumber']; ?>
                    </td>
                    <td>
                        <?php echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateRequestMemberInt']); ?>
                    </td>
                    <td>
                        <?php
                        if ($item['DateSetCancelInt'] != '0' || $item['DateConfirmCancelInt'] != '0' || $item['DateSetFailedIndemnityInt'] != '0') {

                            if ($item['Status'] == 'SetCancelClient') {
                                echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateSetCancelInt']);
                            } elseif ($item['Status'] == 'ConfirmCancel') {
                                echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateConfirmCancelInt']);
                            } elseif ($item['Status'] == 'SetFailedIndemnity') {
                                echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $item['DateSetFailedIndemnityInt']);
                            } else {
                                echo '-------';
                            }

                        } else {
                            echo '-------';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($item['Status'] == 'ConfirmCancel') {
                            echo $item['PercentIndemnity'] . ' % ';
                        } else {
                            echo '-------';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($item['PriceIndemnity'] != '' && $item['Status'] == 'ConfirmCancel') {
                            echo number_format($item['PriceIndemnity']) . ' ' . functions::Xmlinformation('Rial');
                        } else {
                            echo '-------';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($item['Status'] == 'RequestMember') {
                            echo '<div class="btn btn-primary">' . functions::Xmlinformation('SendRequest') . '</div>';
                        } elseif ($item['Status'] == 'SetCancelClient' || $item['Status'] == 'SetFailedIndemnity') {
                            echo '<div class="btn btn-danger">' . functions::Xmlinformation('Rejectrequest') . '</div>';
                        } elseif ($item['Status'] == 'RequestClient' || $item['Status'] == 'SetIndemnity' || $item['Status'] == 'ConfirmClient') {
                            echo '<div class="btn btn-warning">' . functions::Xmlinformation('Pending') . '</div>';
                        } elseif ($item['Status'] == 'ConfirmCancel') {
                            echo '<div class="btn btn-success">' . functions::Xmlinformation('Approve') . '</div>';
                        } elseif ($item['Status'] == 'close') {
                            echo '<div class="btn btn-success">' . functions::Xmlinformation('closeTicket') . '</div>';
                        } else {
                            echo '-------';
                        }
                        ?>
                    </td>
                    <td>
                        <a onclick="ModalTrackingCancelTicket('<?php echo $item['RequestNumber']; ?>','<?php echo $item['id']; ?>')"
                           class="btn btn-bitbucket fa fa-search"></a>
                        <?php
                        if ($item['Status'] == 'ConfirmCancel' ) {
                            ?>
                            <a href="<?php echo SERVER_HTTP . CLIENT_DOMAIN . '/gds/pdf&target=parvazBookingLocal&id=' . $item['RequestNumber'] . '&cancelStatus=confirm'; ?>"
                               class="btn btn-info  fa fa-file-pdf-o" style="margin: 5px;"
                               target="_blank"> <?php echo functions::Xmlinformation('Cancellationprint'); ?> </a>
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

        <?php
        $print = ob_get_clean();
        return $print;

    }

    /**
     * @param $param
     * @return array
     */
    private function getInfoCancelTrain($param)
    {
        $number = 0;

        $sql = " SELECT   dCancel.*,Cancel.NationalCode AS NationalCode 
                 FROM    cancel_ticket_details_tb AS dCancel  
                 LEFT JOIN  cancel_ticket_tb AS Cancel ON Cancel.IdDetail = dCancel.id 
                 WHERE   dCancel.MemberId='{$this->id}' AND TypeCancel='{$param['appType']}'";


        if (!empty($param['startDate']) && !empty($param['endDate'])) {

            $date_of = explode('-', $param['startDate']);
            $date_to = explode('-', $param['endDate']);
            $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
            $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
            $sql .= " AND 
                        (
                        (dCancel.DateRequestMemberInt >= '{$date_of_int}' AND dCancel.DateRequestMemberInt  <= '{$date_to_int}')
                        OR (dCancel.DateSetCancelInt >= '{$date_of_int}' AND dCancel.DateSetCancelInt  <= '{$date_to_int}')
                        OR (dCancel.DateRequestCancelClientInt >= '{$date_of_int}' AND dCancel.DateRequestCancelClientInt  <= '{$date_to_int}')
                        OR (dCancel.DateSetIndemnityInt >= '{$date_of_int}' AND dCancel.DateSetIndemnityInt  <= '{$date_to_int}')
                        OR (dCancel.DateSetFailedIndemnityInt >= '{$date_of_int}' AND dCancel.DateSetFailedIndemnityInt  <= '{$date_to_int}')
                        OR (dCancel.DateConfirmClientInt >= '{$date_of_int}' AND dCancel.DateConfirmClientInt  <= '{$date_to_int}')
                        OR (dCancel.DateConfirmCancelInt >= '{$date_of_int}' AND dCancel.DateConfirmCancelInt  <= '{$date_to_int}')
                        )
                         ";

        }
        if (isset($param['factorNumber']) && $param['factorNumber'] != '') {
            $sql .= " AND (dCancel.RequestNumber = '{$param['factorNumber']}' OR dCancel.FactorNumber = '{$param['factorNumber']}') ";
        }
        $sql .= "
                GROUP BY Cancel.IdDetail
                ORDER BY dCancel.id DESC ";
        $bookList = $this->Model->select($sql);
        return array($number, $bookList);
    }


}