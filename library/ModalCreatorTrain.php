<?php
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));

class ModalCreatorTrain
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
        $Param = $_POST['ticketnumber'];
        $Param2 = isset($_POST['ParamId']) ? $_POST['ParamId'] : '';
        $Param3 = isset($_POST['ParamClientId']) ? $_POST['ParamClientId'] : '';
        self::$Method($Param, $Param2, $Param3);
    }



    public function ModalShowTrain($Param)
    {
        $user = Load::controller($this->Controller);
        $Tickets = functions::info_train_client($Param);
        ?>

        <div class="modal-header site-bg-main-color">
            <span class="close" onclick="modalClose()">&times;</span>
            <h6 class="modal-h"><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber") ?>:<?php echo $Param; ?> </h6>
        </div>
        <div class="modal-body">
            <?php
            foreach ($Tickets as $key => $view) {
                if ($key < 1) {
                    ?>
                    <div class="row margin-both-vertical-20">
                    <div class="col-md-12 modal-text-center modal-h"><span> <?php echo functions::Xmlinformation("Flightprofile") ?></span></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 ">
                            <span><?php echo functions::Xmlinformation("Date"); ?> <?php echo $view['payment_type'] == 'cash' ? functions::Xmlinformation("Payment") : functions::Xmlinformation("Buy"); ?> : </span>
                            <span dir="rtl"><?php echo !empty($view['payment_date']) ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid") ?></span>
                        </div>

                        <div class="col-md-4 ">

                            <span><?php echo functions::Xmlinformation("Reservationdate") ?> : </span>
                            <span dir="rtl"><?php echo $user->set_date_reserve($view['creation_date']) ?></span></div>
                        <div class="col-md-4 ">
                            <span><?php echo functions::Xmlinformation("WachterNumber") ?> :</span>

                            <span><?php echo $view['request_number'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 ">

                            <span><?php echo functions::Xmlinformation("Origin") ?> /   <?php echo functions::Xmlinformation("Destination") ?>: </span><span><?php echo $view['origin_city'] ?>
                                / <?php echo $view['desti_city'] ?></span>
                        </div>
                        <div class="col-md-4 ">
                            <span><?php echo functions::Xmlinformation("Count") ?> :</span><span><?php echo $view['CountId']; ?></span>
                        </div>


                        <div class="col-md-4 "><span><?php echo functions::Xmlinformation("Dateandtimeofflight") ?>:</span>
                            <span> <?php echo $user->format_hour($view['time_flight']) . ' ' . $user->DateJalali($view['date_flight']) ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 ">

                            <span> <?php echo functions::Xmlinformation("Nameairline") ?> :</span>
                            <span><?php echo $view['airline_name'] ?></span>
                        </div>
                        <div class="col-md-4 ">

                            <span><?php echo functions::Xmlinformation("Classflight") ?>: </span>
                            <span><?php echo ($view['seat_class'] == 'C' || $view['seat_class'] == 'B') ? functions::Xmlinformation("BusinessType") : functions::Xmlinformation("EconomicsType") ?> </span>
                        </div>

                        <div class="col-md-4 "><span> <?php echo functions::Xmlinformation("Typeflight") ?>: </span>
                            <span><?php echo $view['flight_type'] == 'system' ?   functions::Xmlinformation("SystemType")  : functions::Xmlinformation("CharterType")  ?> </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 ">

                            <span><?php functions::Xmlinformation("Numflight") ?>:</span><span><?php echo $view['flight_number'] ?> </span>
                        </div>
                        <div class="col-md-4 ">
                            <span dir="rtl"><?php functions::Xmlinformation("PnrCode") ?> :</span><span><?php echo $view['pnr']; ?></span>
                        </div>

                        <div class="col-md-4 "><span><?php functions::Xmlinformation("Amount") ?> :</span>
                            <span> <?php
                                if ($view['percent_discount'] > 0) {
                                    echo '<span style="text-decoration: line-through;">' . number_format($user->TotalPriceByFactorNumber($view['factor_number'])) . '</span>,'
                                        . ' ' . '<span>' . number_format($user->TotalPriceByFactorNumber($view['factor_number'])) . '</span>';
                                } else {
                                    echo '<span>' . number_format($user->TotalPriceByFactorNumber($view['factor_number'])) . '</span>';
                                }
                                ?> <?php functions::Xmlinformation("Rial") ?>
                            </span>
                        </div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-12 modal-text-center modal-h"><span><?php functions::Xmlinformation("Travelerprofile") ?></span></div>
                    </div>
                <?php } ?>

                <div class="row modal-padding-bottom-15">
                    <div class="col-md-3 ">


                        <span><?php echo functions::Xmlinformation("Namefamily") ?> :</span>
                        <span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span><?php echo functions::Xmlinformation("Nationalnumber"); ?>/<?php echo functions::Xmlinformation("Passport"); ?>:</span>
                        <span><?php echo ($view['passenger_national_code'] != '0000000000') ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span dir="rtl"><?php echo functions::Xmlinformation("DateOfBirth") ?>: </span>
                        <span><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span dir="rtl"><?php echo functions::Xmlinformation("Ticketnumber") ?>: </span>
                        <span><?php echo $view['eticket_number']; ?></span>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="modal-footer site-bg-main-color">

        </div>

        <?php
    }


    #region ModalSendEmailForOther

    public function ModalSenEmailForOther($Param, $ClientID)
    {
        ?>
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ارسال ایمیل بلیط برای دیگران</h4>
                </div>
                <form method="post" id="SendEmailForOtherModal" name="SendEmailForOtherModal">
                    <input type="hidden" name="flag" value="SendEmailForOther">
                    <input type="hidden" name="request_number" value="<?php echo $Param ?>">
                    <input type="hidden" name="ClientID" value="<?php echo $ClientID ?>">
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="Reason">ایمیل گیرنده</label>
                                    <input type="text" class="form-control" name="email" id="email">
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer site-bg-main-color">

                        <button type="button" class="btn btn-primary  pull-right" data-dismiss="modal">بستن</button>
                        <button type="submit" class="btn btn-success pull-right">ارسال اطلاعات</button>

                    </div>

                </form>
                <script type="text/javascript">
                    $("#SendEmailForOtherModal").validate({
                        rules: {
                            email: {
                                required: true,
                                email: true
                            }
                        },
                        messages: {},
                        errorElement: "em",
                        errorPlacement: function (error, element) {
                            // Add the `help-block` class to the error element
                            error.addClass("help-block");

                            if (element.prop("type") === "checkbox") {
                                error.insertAfter(element.parent("label"));
                            } else {
                                error.insertAfter(element);
                            }
                        },
                        submitHandler: function (form) {

                            $(form).ajaxSubmit({
                                url: amadeusPath + 'user_ajax.php',
                                type: "post",
                                success: function (response) {
                                    var res = response.split(':');

                                    if (response.indexOf('success') > -1) {
                                        $.toast({
                                            heading: 'ارسال ایمیل به دیگران',
                                            text: res[1],
                                            position: 'top-right',
                                            loaderBg: '#fff',
                                            icon: 'success',
                                            hideAfter: 3500,
                                            textAlign: 'right',
                                            stack: 6
                                        });

                                        setTimeout(function () {
                                            $('#ModalPublic').modal('hide');
                                        }, 1000);


                                    } else {

                                        $.toast({
                                            heading: 'ارسال ایمیل به دیگران',
                                            text: res[1],
                                            position: 'top-right',
                                            loaderBg: '#fff',
                                            icon: 'error',
                                            hideAfter: 3500,
                                            textAlign: 'right',
                                            stack: 6
                                        });

                                    }


                                }
                            });
                        },
                        highlight: function (element, errorClass, validClass) {
                            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
                        },
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
                        }


                    });
                </script>
            </div>
        </div>

        </div>

        <?php
    }
    #endregion



    #region showModalTicketClose
    public function showModalTicketClose($Param, $clientId)
    {
        ?>
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">بسته شدن بلیط</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="descriptionClose"> توضیحات</label>
                                <textarea class="form-control" id="descriptionClose" name="descriptionClose" placeholder="توضیحات"></textarea>
                            </div>
                        </div>
                    </div>
                </div><!--setTicketClose-->
                <div class="modal-footer site-bg-main-color">
                    <button type="button" class="btn btn-primary  pull-left"
                            onclick="setTicketClose('<?php echo $Param; ?>', '<?php echo $clientId; ?>')">
                        ارسال اطلاعات
                    </button>
                </div>
            </div>
        </div>
        <?php
    }

    #endregion




    #region ModalShowBook

    public function ModalShowBook($Param)
    {
      $objbook = Load::controller('resultTrainApi');
        $user = Load::controller('bookingTrain');
        $Tickets = functions::GetInfoTrain($Param);
        ?>

        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">مشاهده مشخصات بلیط
                        &nbsp; <?php echo !empty($Tickets[0]['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان' ?></h4>
                </div>
                <div class="modal-body">
                    <?php
                    $objbook->DateJalali($Tickets[0]['ExitDate']);
                    ?>


                            <div class="row margin-both-vertical-20">
                                <div class="col-md-12 text-center text-bold" style="color: #fb002a;">
                                    <span>مشخصات کاربر</span></div>
                            </div>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-4 ">
                                    <span>نام و نام خانوادگی  : </span><span><?php echo $Tickets[0]['member_name'] ?></span>
                                </div>
                                <div class="col-md-4 ">
                                    <span class=""> شماره تلفن موبایل: </span><span
                                            class="yn"><?php echo $Tickets[0]['member_mobile'] ?></span>
                                </div>
                                <div class="col-md-4 ">
                                    <span>ایمیل :</span><span><?php echo $Tickets[0]['member_email'] ?></span>
                                </div>
                            </div>


                            <hr style="margin: 5px 0;"/>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-12 text-center text-bold" style="color: #fb002a;"><span>اطلاعات خریدار </span>
                                </div>
                            </div>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-6 ">
                                    <span>شماره تماس  : </span><span><?php echo $Tickets[0]['mobile_buyer'] ?></span>
                                </div>
                                <div class="col-md-6 ">
                                    <span class=""> ایمیل: </span><span
                                            class="yn"><?php echo $Tickets[0]['email_buyer'] ?></span>
                                </div>
                            </div>
                            <hr style="margin: 5px 0;"/>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات پرداخت</span>
                                </div>
                            </div>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-4">
                                    <span class=" pull-left">تاریخ پرداخت : </span>
                                    <span class="yn"><?php echo($Tickets[0]['payment_date'] != '' ? functions::set_date_payment($Tickets[0]['payment_date']) : 'پرداخت نشده'); ?></span>
                                </div>
                                <div class="col-md-4">
                                    <span>نوع پرداخت: </span>
                                    <span><?php
                                        if ($Tickets[0]['payment_type'] == 'cash') {
                                            echo 'نقدی';
                                        } else if ($Tickets[0]['payment_type'] == 'credit' || $Tickets[0]['payment_type'] == 'member_credit') {
                                            echo 'اعتباری';
                                        }
                                        ?></span>
                                </div>
                                <div class="col-md-4">
                                    <span>کد پیگیری بانک: </span>
                                    <span class="yn"><?php echo !empty($Tickets[0]['tracking_code_bank']) ? $Tickets[0]['tracking_code_bank'] : 'ندارد' ?></span>
                                </div>
                            </div>
                            <hr style="margin: 5px 0;"/>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                                <span>مشخصات قطار </span>
                            </div>
                        </div>
                        <div class="row margin-both-vertical-20">

                            <div class="col-md-8">
                                <span class=" pull-left">تاریخ رزرو بلیط : </span>
                                <span class="yn"
                                      dir="ltr"><?php echo dateTimeSetting::jdate('Y-m-d (H:i:s)', $Tickets[0]['creation_date_int']) ?></span>
                            </div>
                            <div class="col-md-4">
                                <span>شماره واچر :</span>
                                <span class="yn"><?php echo $Tickets[0]['factor_number'] ?></span>
                            </div>
                        </div>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-4 ">
                                <span>مبدا /مقصد: </span>
                                <span><?php echo $Tickets[0]['Departure_City'] . '/' . $Tickets[0]['Arrival_City'] ?></span>
                            </div>
                            <div class="col-md-4 ">
                                <span>تعداد :</span>
                                <span><?php echo $Tickets[0]['CountId']; ?></span>
                            </div>
                            <div class="col-md-4 ">
                                <span class=" pull-left">ساعت و تاریخ حرکت:</span>
                                <span class="yn"><?php echo  $Tickets[0]['ExitTime'] . ' ' . $objbook->DateJalaliRequest ?> </span>
                            </div>
                        </div>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-4 ">
                                <span>نام شرکت ریلی/نوع واگن :</span>
                                <span><?php echo $Tickets[0]['CompanyName'] ?>/<?php echo $Tickets[0]['WagonName']; ?></span>
                            </div>
                            <?php
                                if($Tickets[0]['Service']) {
                            ?>

                            <div class="col-md-4 ">
                                <span>خدمات اضافی :</span>
                                <span><?php echo $Tickets[0]['Service'] ?></span>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="row margin-both-vertical-20">
                            <?php if ($Tickets[0]['type_app'] != 'Reservation') { ?>

                                <div class="col-md-4 ">
                                    <span class="">شماره قطار:</span>
                                    <span class="yn"><?php echo $Tickets[0]['TrainNumber'] ?> </span>
                                </div>
                                <div class="col-md-4 ">
                                    <span class=" pull-left">شماره بلیط :</span>
                                    <span class="yn"><?php echo $Tickets[0]['TicketNumber'] ?></span>
                                </div>

                            <?php } ?>

                            <div class="col-md-4 ">
                                <span>مبلغ :</span>
                                <span class="yn">
                                <?php
                                $totalPrice =  $user->TotalPriceByTicketNumberAdmin($Param, $Tickets[0]['successfull']); ?>
                                    <span><?php echo number_format($totalPrice) ?></span>
                                </span> <span>ریال</span>
                            </div>

                        </div>


                    <div class="row margin-top-10 margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                            <span>مشخصات مسافرین</span></div>
                    </div>

                    <?php

                    foreach ($Tickets as $view) {
                        ?>
                        <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                            <div class="col-md-3 ">
                                <span>نام فارسی:</span>
                                <span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] . ' (' . $view['passportCountry'] . ') '; ?> </span>
                            </div>
                            <div class="col-md-3 ">
                                <span class=" pull-left">تولد شمسی:</span>
                                <span class="yn"><?php echo !empty($view['passenger_birthday']) ? $view['passenger_birthday'] : '----' ?></span>
                            </div>
                            <div class="col-md-3 ">
                                <span>شماره پاسپورت:</span>
                                <span class="yn"><?php echo !empty($view['passportNumber']) ? $view['passportNumber'] : '----' ?></span>
                            </div>
                            <div class="col-md-3 ">
                                <span class=" pull-left">شماره بلیط:</span>
                                <span class="yn"><?php echo !empty($view['TicketNumber']) ? $view['TicketNumber'] : '----' ?></span>
                            </div>
                            <div class="col-md-3 ">
                                <span>نام انگلیسی:</span>
                                <span><?php echo $view['passenger_name_en'] . ' ' . $view['passenger_family_en'] . ' (' . $view['passportCountry'] . ') '; ?> </span>
                            </div>
                            <div class="col-md-3 ">
                                <span class=" pull-left">تولد میلادی:</span>
                                <span class="yn"><?php echo !empty($view['passenger_birthday_en']) ? $view['passenger_birthday_en'] : '----' ?></span>
                            </div>
                            <div class="col-md-3 ">
                                <span class=" pull-left">انقضای پاسپورت:</span>
                                <span class="yn"><?php echo !empty($view['passportExpire']) ? $view['passportExpire'] : '----' ?></span>
                            </div>
                            <div class="col-md-3 ">
                                <span>هزینه بلیط:</span>
                                    <?php if ($view['discount_inf_price'] > 0) { ?>

                                   <span class="yn" style="text-decoration: line-through; color: red"><?php echo ($view['successfull'] =='book')? number_format($view['priceTicketReportA']): number_format($view['Cost']+ $view['service_price'])?> </span>
                                   <span class="yn" ><?php echo ($view['successfull'] =='book')? number_format($view['priceTicketReportA']-$view['discount_inf_price']): number_format($view['Cost']+ $view['service_price']-$view['discount_inf_price'])?> </span> <span>ریال</span>
                                    <?php }else{ ?>
                                      <span class="yn"><?php echo ($view['successfull'] =='book')? number_format($view['priceTicketReportA']): number_format($view['Cost']+ $view['service_price'])?> </span> <span>ریال</span>
                                    <?php } ?>


                            </div>
                            <div class="col-md-3 ">
                                <span>شماره ملی:</span>
                                <span class="yn"><?php echo $view['passenger_national_code'] != '0000000000' ? $view['passenger_national_code'] : '----' ?></span>
                            </div>
                        </div>

                    <?php } ?>

                    <div class="modal-footer site-bg-main-color"></div>
                </div>
            </div>

        </div>

        <?php
    }

    #endregion

}

/**
 * این کلاس چون از طریق جاوا اسکریپت فراخوانی میشود
 * همین جا صدا زده شده
 * لطفا پاک نشود
 */
new ModalCreatorTrain();
?>