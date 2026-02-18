<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));

class ModalCreatorForReservationTicket
{

    #region variable
    public $Controller;
    public $Method;
    public $target;
    public $id;
    #endregion

    #region __construct
    public function __construct()
    {

        $this->Controller = $_POST['Controller'];
        $Method = $_POST['Method'];
        $param = $_POST['Param'];
        $param2 = isset($_POST['ParamId']) ? $_POST['ParamId'] : '';
        $param3 = isset($_POST['ParamClientId']) ? $_POST['ParamClientId'] : '';
        self::$Method($param, $param2, $param3);
    }
    #endregion

    #region ModalShow
    public function ModalShow($param)
    {

        $user = Load::controller($this->Controller);
        $tickets = $user->infoReservationTicket($param);

        $resultReservationTicket = Load::controller('resultReservationTicket');
        $typeReservation = $resultReservationTicket->getTypeVehicleByTicketId($tickets[0]['fk_id_ticket']);
        ?>

        <div class="modal-header site-bg-main-color">
            <span class="close" onclick="modalClose('')">&times;</span>
            <h6 class="modal-h"><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber"); ?>:<?php echo $param; ?> </h6>
        </div>
        <div class="modal-body">
            <?php
            foreach ($tickets as $key => $view) {
                if ($key < 1) {
                    ?>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation("ReservationProfile"); ?></span></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 "><span
                            ><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?>
                                : </span><span><?php echo !empty($view['payment_date']) ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid") ?></span>
                        </div>
                        <div class="col-md-4 "><span><?php echo functions::Xmlinformation("Reservationdate"); ?> : </span><span
                                    style=''><?php echo $user->set_date_reserve($view['creation_date']) ?></span></div>
                        <div class="col-md-4 "><span
                                ><?php echo functions::Xmlinformation("Invoicenumber"); ?> :</span><span><?php echo $view['factor_number'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 "><span
                            ><?php echo functions::Xmlinformation("Origin"); ?> /<?php echo functions::Xmlinformation("Destination"); ?>: </span><span><?php echo $view['origin_city'] ?>
                                /<?php echo $view['desti_city'] ?></span></div>
                        <div class="col-md-4 "><span>تعداد :</span><span
                                    style=''><?php echo $user->count; ?></span></div>
                        <div class="col-md-4 "><span
                            ><?php echo functions::Xmlinformation("DateAndTime"); ?> :</span><span> <?php echo $user->format_hour($view['time_flight']) ?>
                                &nbsp; &nbsp; <?php echo $user->DateJalali($view['date_flight']) ?></span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 ">
                            <?php if ($view['type_app']=='reservationBus'){ ?>
                                <span><?php echo functions::Xmlinformation("Nametour"); ?>: </span><span><?php echo $view['flight_number'] ?> </span>
                            <?php } else { ?>
                                <span><?php echo functions::Xmlinformation("Numflight"); ?>: </span><span><?php echo $view['flight_number'] ?> </span>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 "><span><?php echo $typeReservation; ?> :</span><span
                                    style=''><?php echo $view['airline_name']; ?></span></div>
                        <div class="col-md-4 "><span><?php echo functions::Xmlinformation("Amount"); ?> :</span><span> <span><?php echo number_format($view['total_price']); ?></span> <?php echo functions::Xmlinformation("Rial"); ?> </span></div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation("Travelerprofile"); ?></span></div>
                    </div>
                <?php } ?>

                <div class="row modal-padding-bottom-15">
                    <div class="col-md-4 "><span
                        ><?php echo functions::Xmlinformation("Namefamily"); ?> :</span><span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
                    </div>
                    <div class="col-md-4 "><span
                        ><?php echo functions::Xmlinformation("nationalCodeOrPassPort"); ?>:</span><span><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
                    </div>
                    <div class="col-md-4 "><span
                        ><?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span><span><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="modal-footer site-bg-main-color">

        </div>

        <?php
    }
    #endregion



    #region setCancelReservationTicket
    public function setCancelReservationTicket($requestNumber)
    {
        $user = Load::controller($this->Controller);
        $tickets = $user->infoReservationTicket($requestNumber);

        $objTicket = Load::controller('reservationTicket');
        $percentCancel = $objTicket->getCancellationsTicket($tickets[0]['fk_id_ticket'], $tickets[0]['date_flight'], $tickets[0]['time_flight']);

        ?>
        <div class="modal-header site-bg-main-color">

            <div class="col-md-7">
                <h6 class="modal-h"><?php echo functions::Xmlinformation("Cancelpurchasebookingnumber")?><?= $requestNumber ?></h6>
            </div>

            <div class="col-md-3">
                <div class="reservation-cancellations-ticket">جریمه کنسلی به ازای هر نفر: <i><?= $percentCancel ?></i> درصد</div>
            </div>

            <div class="col-md-2">
                <span class="close" onclick="modalClose()">×</span>
            </div>

        </div>

        <div class="modal-body" style="overflow: initial;">
            <div class="modal-padding-bottom-15">
                <div class="row">
                    <div class="col-md-12 modal-text-center modal-h "><?php echo functions::Xmlinformation("Pleaseselectthedesiredpassenger")?></div>
                </div>

                <div class="row">

                    <?php
                    foreach ($tickets as $i => $info) {

                        $price = ($info['discount_' . strtolower($info['passenger_age']) . '_price'] > 0) ? $info['discount_' . strtolower($info['passenger_age']) . '_price'] : $info[strtolower($info['passenger_age']) . '_price'];
                        $valueInput = ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] . '-' . $info['passenger_age'] . '-' . $price : $info['passportNumber'] . '-' . $info['passenger_age'] . '-' . $price;
                        ?>

                        <div class="col-md-12">
                            <div class="col-md-1">
                                <input class="form-control SelectUser" type="checkbox"
                                       name="SelectUser[]" id="SelectUser"
                                       value="<?php echo $valueInput;  ?>"
                                    <?php
                                    echo (!empty($info['Status']) && !empty($info['NationalCode']) && $info['Status'] != 'SetCancelClient') ? 'disabled ="disabled"' : '';
                                    ?>>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo $info['passenger_name'] . ' ' . $info['passenger_family']; ?></span>
                            </div>

                            <div class="col-md-3">
                                <span><?php echo functions::Xmlinformation("Nationalnumber")?>/<?php echo functions::Xmlinformation("Passport")?>:</span>
                                <span><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span>
                            </div>
                            <div class="col-md-2">
                                <span><?php echo functions::Xmlinformation("DateOfBirth")?>: </span>
                                <span><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span>
                            </div>

                            <div class="col-md-1">
                                <span>
                                    <?php
                                    switch ($info['passenger_age']) {

                                        case 'Adt':
                                            echo functions::Xmlinformation("Adult");
                                            break;

                                        case 'Chd':
                                            echo functions::Xmlinformation("Child");
                                            break;

                                        case 'Inf':
                                            echo functions::Xmlinformation("Baby");
                                            break;
                                    }
                                    ?>
                                </span>
                            </div>

                            <div class="col-md-3 txtCenter">
                                <?php
                                if (!empty($info['Status']) && !empty($info['NationalCode']) && $info['Status'] != 'nothing') {
                                    if ($info['Status'] == 'SetCancelClient') {
                                        ?>
                                        <div class="btn btn-danger"><?php echo functions::Xmlinformation("Deniedrequest") ?></div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="btn btn-warning"><?php echo functions::Xmlinformation("Actionhasalreadybeentaken") ?></div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <?php
                    }
                    ?>

                </div>

                <?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') { ?>
                    <div class="row">
                        <div class="col-md-12 modal-text-center modal-h ">
                            <label for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                            <label style="float:right;"><?php echo functions::Xmlinformation("Cardnumber") ?></label>
                            <input class="form-control " type="text" id="CardNumber" name="CardNumber"
                                   style="float: right;margin-right: 10px">
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                            <label style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
                            <input class="form-control " type="text" id="AccountOwner" name="AccountOwner"
                                   style="float: right;margin-right: 10px">
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                            <label style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
                            <input class="form-control " type="text" id="NameBank" name="NameBank"
                                   style="float: right;margin-right: 10px">
                        </div>
                    </div>
                <?php } ?>


                <div class="row">
                    <div class="col-md-12 modal-text-center modal-h ">
                        <label for="ReasonUser"><?php echo functions::Xmlinformation("Pleaseselectyourdesiredoptions") ?></label>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-12  nopad ">
                        <select class="form-control mart5" name="ReasonUser" onchange="SelectReason(this)"
                                id="ReasonUser">
                            <option value=""><?php echo functions::Xmlinformation("Choosereasonfortheconsole") ?></option>
                            <option value="PersonalReason"><?php echo functions::Xmlinformation("Canselforpersonalreasons") ?></option>
                            <option value="DelayTwoHours"><?php echo functions::Xmlinformation("Delaymorethantwohours") ?></option>
                            <option value="CancelByAirline"><?php echo functions::Xmlinformation("AbandonedbyAirline") ?></option>
                        </select>
                    </div>
                    <div class="col-md-5 col-lg-5 col-sm-12  nopad ">
                        <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 nopad">
                            <input class="form-control " type="checkbox" id="PercentNoMatter" name="PercentNoMatter"
                                   style="height: 40px">
                        </div>
                        <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12 lh45 nopad">
                            <?php echo functions::Xmlinformation("Idonotcareaboutthepercentagepenaltypleasebesurecancel") ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 col-sm-12  nopad ">
                        <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 nopad">
                            <input class="form-control " type="checkbox" id="Ruls" name="Ruls" style="height: 40px">
                        </div>
                        <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12 lh45">
                            <?php echo functions::Xmlinformation("Iam") ?> <a
                                    href="<?php echo URL_RULS ?>"
                                    style="margin-top: 5px"><?php echo functions::Xmlinformation("Seerules") ?></a> <?php echo functions::Xmlinformation("IhavestudiedIhavenoobjection") ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="DescriptionReason showContentTextModal" style="display : none"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal-footer site-bg-main-color">
            <div class="col-md-12" style="text-align:left;">
                <input class="close btn btn-primary btn-send-information"
                       onclick="requestCancelReservationTicket('<?= $requestNumber ?>', '<?= $percentCancel ?>')"
                       type="button" value="<?php echo functions::Xmlinformation("Sendinformation") ?>">
            </div>
        </div>
        <?php




    }
    #endregion

}

new ModalCreatorForReservationTicket();
?>