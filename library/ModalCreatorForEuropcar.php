<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));

class ModalCreatorForEuropcar
{

    public $Method;
    public $target;
    public $id;

    public function __construct()
    {

        $Method = $_POST['Method'];
        $factorNumber = $_POST['factorNumber'];

        self::$Method($factorNumber);
    }

    public function ModalShow($factorNumber)
    {

        $infoBook = functions::GetInfoEuropcar($factorNumber);

        ?>

        <div class="modal-header site-bg-main-color">
            <span class="close" onclick="modalClose('{$item.request_number}')">&times;</span>
            <h6 class="modal-h"><?php echo functions::Xmlinformation("Viewpurchasetobookingnumber"); ?>:<?php echo $factorNumber; ?> </h6>
        </div>

            <div class="modal-body">

            <?php
            $expGetDateTime = explode("T", $infoBook['get_car_date_time']);
            $expReturnDateTime = explode("T", $infoBook['return_car_date_time']);
            ?>
            <div class="row margin-both-vertical-20">
                <div class="col-md-12 modal-text-center modal-h">
                    <span> <?php echo functions::Xmlinformation("CarReservationFeatures"); ?> <?php echo $infoBook['car_name'] . " " . $infoBook['car_name_en']; ?> </span>
                    (<span> <?php echo functions::Xmlinformation("Paymentamount"); ?>: <?php echo number_format($infoBook['total_price']); ?> <?php echo functions::Xmlinformation("Rial"); ?> </span>)
                </div>
            </div>

            <div class="row">

                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Delivery"); ?> : </span>
                    <span><?php echo $infoBook['source_station_name']; ?></span>
                </div>

                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Deliverydate"); ?> : </span>
                    <span><?php echo $expGetDateTime[0]; ?></span>
                </div>

                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Timedelivery"); ?> : </span>
                    <span><?php echo $expGetDateTime[1]; ?></span>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Return"); ?> : </span>
                    <span><?php echo $infoBook['dest_station_name']; ?></span>
                </div>

                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Returndate"); ?> : </span>
                    <span><?php echo $expReturnDateTime[0]; ?></span>
                </div>

                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("ClockBack"); ?> : </span>
                    <span><?php echo $expReturnDateTime[1]; ?></span>
                </div>

            </div>

            <div class="row">

                <div class="col-md-2">
                    <span><?php echo functions::Xmlinformation("Capacity"); ?>: </span>
                    <span><?php echo $infoBook['car_passenger_count']; ?></span>
                    <span> <?php echo functions::Xmlinformation("People"); ?> </span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("MaximumKm"); ?>: </span>
                    <span><?php echo $infoBook['car_allowed_km']; ?></span>
                    <span> km </span>
                </div>

                <div class="col-md-2">
                    <span><?php echo functions::Xmlinformation("Minimumagedriver"); ?>: </span>
                    <span><?php echo $infoBook['car_min_age_to_rent']; ?></span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Priceperkilometerextra"); ?>: </span>
                    <span><?php echo $infoBook['car_add_km_cos_rial']; ?></span>
                    <span> <?php echo functions::Xmlinformation("Rial"); ?> </span>
                </div>

                <?php if($infoBook['car_insurance_cost_rial'] != 0){ ?>
                <div class="col-md-2">
                    <span><?php echo functions::Xmlinformation("Insuranceprice"); ?>: </span>
                    <span><?php echo $infoBook['car_insurance_cost_rial']; ?></span>
                    <span> <?php echo functions::Xmlinformation("Rial"); ?> </span>
                </div>
                <?php } ?>

            </div>


            <div class="row modal-padding-bottom-15">
                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Refundtype"); ?> :</span>
                    <span>
                        <?php
                        if ($infoBook['refund_type'] == '1'){
                            echo functions::Xmlinformation("Checkbook");
                        } else if ($infoBook['refund_type'] == '2'){
                            echo functions::Xmlinformation("Promissorynote");
                        } else if ($infoBook['refund_type'] == '3'){
                            echo functions::Xmlinformation("Cash");
                        }
                        ?>
                    </span>
                </div>
                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Typevehiclecrimewarranty"); ?>:</span>
                    <span>
                        <?php
                        if ($infoBook['driving_crimes_type'] == '1'){
                            echo functions::Xmlinformation("Checkbook");
                        } else if ($infoBook['driving_crimes_type'] == '2'){
                            echo functions::Xmlinformation("Promissorynote");
                        } else if ($infoBook['driving_crimes_type'] == '3'){
                            echo functions::Xmlinformation("Cash");
                        }
                        ?>
                    </span>
                </div>
                <div class="col-md-3">
                    <span> <?php echo functions::Xmlinformation("Deliverycarincustomersite"); ?> </span>
                    <span>
                        <?php
                        if ($infoBook['has_source_station_return_cost'] == '1'){
                            echo functions::Xmlinformation("Have");
                        } else if ($infoBook['has_source_station_return_cost'] == '2'){
                            echo functions::Xmlinformation("Donthave");
                        }
                        ?>
                    </span>
                </div>
                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Refundscaratthecustomerpremises"); ?></span>
                    <span>
                        <?php
                        if ($infoBook['has_dest_station_return_cost'] == '1'){
                            echo functions::Xmlinformation("Have");
                        } else if ($infoBook['has_dest_station_return_cost'] == '2'){
                            echo functions::Xmlinformation("Donthave");
                        }
                        ?>
                    </span>
                </div>
            </div>


            <?php
            $thingInfo = json_decode($infoBook['reserve_car_thing_info'], true);
            if ($thingInfo != '') {
                ?>
                <div class="row margin-top-10">
                    <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation("Selectedcaraccessorieslist"); ?></span></div>
                </div>

                <?php
                foreach ($thingInfo as $thing){
                    ?>
                    <div class="row modal-padding-bottom-15">
                        <div class="col-md-6">
                            <span><?php echo functions::Xmlinformation("Title"); ?>:</span><span><?php echo $thing['thingsName'] ?></span>
                        </div>
                        <div class="col-md-3">
                            <span><?php echo functions::Xmlinformation("Numberofrequests"); ?>:</span><span><?php echo $thing['countThings'] ?></span>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>



            <div class="row margin-top-10">
                <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation("InformationSaler"); ?></span></div>
            </div>

            <div class="row modal-padding-bottom-15">
                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span><span><?php echo $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'] ?></span>
                </div>
                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Nationalnumber"); ?>/<?php echo functions::Xmlinformation("Passport"); ?> :</span><span><?php echo (!empty($infoBook['passenger_national_code'])) ? $infoBook['passenger_national_code'] : $infoBook['passportNumber'] ?></span>
                </div>
                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("DateOfBirth"); ?> : </span><span dir="rtl"><?php echo (!empty($infoBook['passenger_birthday'])) ? $infoBook['passenger_birthday'] : $infoBook['passenger_birthday_en'] ?></span>
                </div>
            </div>

            <div class="row modal-padding-bottom-15">
                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Mobile"); ?> :</span><span><?php echo $infoBook['passenger_mobile'] ?></span>
                </div>
                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Telephone"); ?> : </span><span><?php echo $infoBook['passenger_telephone'] ?></span>
                </div>
                <div class="col-md-4">
                    <span><?php echo functions::Xmlinformation("Email"); ?> : </span><span dir="rtl"><?php echo $infoBook['passenger_email'] ?></span>
                </div>
            </div>


        </div>

        <?php

    }


    public function ModalShowBook($factorNumber)
    {
        $objDiscountCode = Load::controller('discountCodes');
        $infoBook = functions::GetInfoEuropcar($factorNumber);

        $objResultBookHotelShow = Load::controller('bookhotelshow');
        $objResultEuropcar = Load::controller('resultEuropcarLocal');
        $objResultEuropcar->getDay($infoBook['get_car_date_time'], $infoBook['return_car_date_time'])
        ?>

        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">مشاهده مشخصات اجاره خودرو
                        &nbsp; <?php echo !empty($infoBook['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان'; ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <?php
                    
                    if (TYPE_ADMIN == '1') {
                        ?>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات ارائه دهنده رزرو</span>
                            </div>
                        </div>

                        <div class="row margin-both-vertical-20">
                            <div class="col-md-4 "><span>نام آژانس  : </span><span>ایران تکنولوژی</span></div>
                            <div class="col-md-4 "><span> نام مدیر آژانس: </span><span>جناب آقای افشار</span></div>
                            <div class="col-md-4 "><span class=""> شماره تلفن: </span>021-88866609<span class="yn"></span>
                            </div>
                            <div class="col-md-4 "><span> وب سایت : </span><span>http://www.iran-tech.com</span></div>
                            <div class="col-md-8 "><span>آدرس: </span><span>
تهران - خیابان مطهری - بعد از مفتح - پلاک 180 - واحد 1 </span></div>
                        </div>
                    <?php } ?>
                    <hr style="margin: 5px 0;"/>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold" style="color: #fb002a;">
                            <span>مشخصات کاربر</span></div>
                    </div>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-4 "><span>نام و نام خانوادگی  : </span><span><?php echo $infoBook['member_name']; ?></span></div>
                        <div class="col-md-4 "><span class=""> شماره تلفن موبایل: </span><span class="yn"><?php echo $infoBook['member_mobile']; ?></span></div>
                        <div class="col-md-4 "><span>ایمیل :</span><span><?php echo $infoBook['member_email']; ?></span></div>
                    </div>
                    <hr style="margin: 5px 0;"/>


                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات پرداخت</span>
                        </div>
                    </div>

                    <?php if($infoBook['status']=='BookedSuccessfully'){ ?>

                        <div class="row margin-both-vertical-20">
                            <div class="col-md-4"><span class=" pull-left">تاریخ پرداخت : </span><span class="yn">
                                    <?php echo($infoBook['payment_date'] != '' ? functions::set_date_payment($infoBook['payment_date']) : 'پرداخت نشده'); ?>
                            </span>
                            </div>

                            <?php if ($infoBook['payment_date'] != ''){ ?>

                                <div class="col-md-4"><span>نوع پرداخت: </span><span>
                                    <?php
                                    if ($infoBook['payment_type'] == 'cash') {
                                        echo 'نقدی';
                                    } else if ($infoBook['payment_type'] == 'credit') {
                                        echo 'اعتباری';
                                    }
                                    ?>
                                </span>
                                </div>


                                <div class="col-md-4">
                                    <span>کد پیگیری بانک: </span>
                                    <span class="yn">
                                        <?php echo !empty($infoBook['tracking_code_bank']) ? $infoBook['tracking_code_bank'] : 'ندارد'; ?>
                                    </span>
                                </div>


                                <?php if (TYPE_ADMIN == '1' && $infoBook['payment_type'] == 'cash') { ?>

                                    <div class="col-md-4">
                                        <span>نام بانک: </span>
                                        <span><?php echo $objResultBookHotelShow->namebank($infoBook['name_bank_port'], $infoBook['client_id']); ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="">شماره درگاه: </span>
                                        <span class="yn"><?php echo $objResultBookHotelShow->numberPortBnak($infoBook['name_bank_port'], $infoBook['client_id']); ?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <span>صاحب امتیاز درگاه: </span>
                                        <span><?php echo $objResultBookHotelShow->numberPortBnak($infoBook['name_bank_port'], $infoBook['client_id']) == '379918' ? 'ایران تکنولوژی' : $objResultBookHotelShow->nameAgency($infoBook['client_id']); ?></span>
                                    </div>
                                <?php } ?>


                            <?php } ?>



                        </div>
                    <?php }else { ?>

                        <div class="row margin-both-vertical-20">
                            <div class="col-md-4">
                                <span class=" pull-left">تاریخ پرداخت : </span><span class="yn">پرداخت نشده</span>
                            </div>
                        </div>

                    <?php } ?>


                    <hr style="margin: 5px 0;"/>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                            <span>مشخصات رزرو</span></div>
                    </div>
                    <div class="row margin-both-vertical-20">

                        <?php
                        $payDate = (!empty($infoBook['payment_date']) ? functions::set_date_payment($infoBook['payment_date']) : '');
                        if($payDate != ''){ $payDate = explode(' ', $payDate); }
                        ?>

                        <div class="col-md-3">
                            <span class=" pull-left">تاریخ رزرو: </span>
                            <span class="yn"><?php echo !empty($infoBook['payment_date']) ? $payDate[0] : 'ندارد';?></span>
                        </div>
                        <div class="col-md-3">
                            <span class=" pull-left">ساعت رزرو: </span>
                            <span class="yn"><?php echo !empty($infoBook['payment_date']) ? $payDate[1] : 'ندارد'; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span>شماره واچر :</span>
                            <span class="yn"><?php echo $infoBook['factor_number']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span>مبلغ پرداختی:</span>
                            <span class="yn"><?php echo $infoBook['total_price']; ?></span>
                        </div>

                        <?php
                        $discountCodeInfo = $objDiscountCode->getDiscountCodeByFactor($infoBook['factor_number']);
                        if (!empty($discountCodeInfo)) {
                            ?>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <span>کد تخفیف:</span>
                                    <span class="yn"><?php echo $discountCodeInfo['discountCode']; ?></span>
                                </div>
                                <div class="col-md-8 ">
                                    <span>قیمت پس از اعمال کد تخفیف</span>
                                    <span class="yn">
                                        <?php echo number_format($infoBook['total_price'] - $discountCodeInfo['amount']); ?> ریال
                                    </span>
                                </div>
                            </div>
                        <?php } ?>

                    </div>


                    <hr style="margin: 5px 0;"/>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-4">
                            <span class=" pull-left">ایستگاه تحویل: </span>
                            <span class="yn"><?php echo $infoBook['payment_date'];?></span>
                        </div>
                        <div class="col-md-4">
                            <span class=" pull-left">تاریخ تحویل: </span>
                            <span class="yn"><?php echo $objResultEuropcar->getCarDate; ?></span>
                        </div>
                        <div class="col-md-4">
                            <span>ساعت تحویل:</span>
                            <span class="yn"><?php echo $objResultEuropcar->getCarTime; ?></span>
                        </div>
                    </div>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-4">
                            <span class=" pull-left">ایستگاه بازگشت: </span>
                            <span class="yn"><?php echo $infoBook['payment_date'];?></span>
                        </div>
                        <div class="col-md-4">
                            <span class=" pull-left">تاریخ بازگشت: </span>
                            <span class="yn"><?php echo $objResultEuropcar->returnCarDate; ?></span>
                        </div>
                        <div class="col-md-4">
                            <span>ساعت بازگشت:</span>
                            <span class="yn"><?php echo $objResultEuropcar->returnCarTime; ?></span>
                        </div>
                    </div>

                    <hr style="margin: 5px 0;"/>
                    <div class="row margin-top-10 margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات خریدار </span>
                        </div>
                    </div>
                    

                    <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                        <div class="col-md-3">
                            <span>نام و نام خانوادگی :</span>
                            <span><?php echo $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'] . '(' . ($infoBook['passportCountry'] != 'IRN' && $infoBook['passportCountry'] != '' ? $infoBook['passportCountry'] : 'IRN') . ')'; ?> </span>
                        </div>
                        <div class="col-md-3">
                            <span>شماره ملی/پاسپورت:</span>
                            <span class="yn"><?php echo $infoBook['passenger_national_code'] == '0000000000' ? $infoBook['passportNumber'] : $infoBook['passenger_national_code']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span class=" pull-left">تاریخ تولد:</span>
                            <span class="yn"><?php echo !empty($infoBook['passenger_birthday']) ? $infoBook['passenger_birthday'] : $infoBook['passenger_birthday_en']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span class=" pull-left">مویابل:</span>
                            <span class="yn"><?php echo $infoBook['passenger_mobile']; ?></span>
                        </div>
                    </div>

                    <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                        <div class="col-md-2">
                            <span class=" pull-left">تلفن:</span>
                            <span class="yn"><?php echo $infoBook['passenger_telephone']; ?></span>
                        </div>
                        <div class="col-md-2">
                            <span class=" pull-left">ایمیل:</span>
                            <span class="yn"><?php echo $infoBook['passenger_email']; ?></span>
                        </div>
                        <div class="col-md-8">
                            <span class=" pull-left">آدرس:</span>
                            <span class="yn"><?php echo $infoBook['passenger_address']; ?></span>
                        </div>
                    </div>
                        

                </div>
            </div>

        </div>

        <?php

    }

}

new ModalCreatorForEuropcar();
?>