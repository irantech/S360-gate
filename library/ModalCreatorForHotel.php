<?php

require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));

class ModalCreatorForHotel
{

    public $Controller;
    public $Method;
    public $target;
    public $id;

    public function __construct()
    {

        $this->Controller = $_POST['Controller'];
        $Method = $_POST['Method'];
        $Param = $_POST['Param'];

        self::$Method($Param);
    }

    public function ModalShow($Param)
    {

        $objbook = Load::controller($this->Controller);
        $Hotel = $objbook->info_hotel_client($Param);

        ?>

        <div class="modal-header site-bg-main-color">
            <span class="close" onclick="modalClose('<?php echo $Param; ?>')">&times;</span>
            <h6 class="modal-h">  <?php echo functions::Xmlinformation("Viewhotelpurchasetobookingnumber"); ?>:<?php echo $Param; ?> </h6>
        </div>

        <div class="modal-body">

            <?php
            foreach ($Hotel as $key => $view) {
                if ($key < 1) {
                    ?>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 modal-text-center modal-h"><span> <?php echo functions::Xmlinformation("Specifications"); ?> <?php echo $view['hotel_name'] ?></span></div>
                    </div>

                    <div class="row">

                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("City"); ?> : </span>
                            <span><?php echo $view['city_name'] ?></span>
                        </div>

                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Hotel"); ?> : </span>
                            <span><?php echo $view['hotel_name'] ?></span>
                        </div>

                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Stayigtime"); ?> : </span>
                            <span><?php echo $view['number_night'] ?></span>
                        </div>

                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Amount"); ?> : </span>
                            <span><?php echo number_format(functions::calcDiscountCodeByFactor($view['total_price'], $Param)) ?> <?php echo functions::Xmlinformation("Rial"); ?></span>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("HotelBookingDate"); ?> : </span>
                            <span dir="rtl"><?php echo $objbook->set_date_reserve($view['payment_date']) ?></span>
                        </div>

                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Enterdate"); ?> : </span>
                            <span dir="rtl"><?php echo $view['start_date'] ?></span>
                        </div>

                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Exitdate"); ?> : </span>
                            <span dir="rtl"><?php echo $view['end_date'] ?></span>
                        </div>
                      <div class="col-md-3 ">
                        <span><?php echo functions::Xmlinformation("Status"); ?> : </span>
                        <span dir="rtl">
                            <?php
                              if ($view['status'] == 'BookedSuccessfully') {
                                  echo functions::Xmlinformation('Definitivereservation');
                              } elseif ($view['status'] == 'bank') {
                                  echo functions::Xmlinformation('RedirectPayment');
                              } elseif ($view['status'] == 'PreReserve') {
                                  echo functions::Xmlinformation('Prereservation');
                              }elseif ($view['status'] == 'OnRequest') {
                                  echo functions::Xmlinformation('OnRequestedHotel');
                              } elseif ($view['status'] == 'Cancelled') {
                                  echo functions::Xmlinformation('Cancel');
                              } else {
                                  echo functions::Xmlinformation('Unknow');
                              }
                            ?>
                        </span>
                        </div>

                    </div>

                    <?php if (!empty($view['passenger_name']) || !empty($view['passenger_name_en'])){ ?>

                        <div class="row margin-top-10">
                            <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation("Travelerprofile"); ?></span></div>
                        </div>
                    <?php }else { ?>
                        <div class="row margin-top-10">
                            <div class="col-md-12 modal-text-center modal-h">
                                <span><?php echo functions::Xmlinformation("HeadOfRoom"); ?>: <?php echo $view['passenger_leader_room_fullName'] ?></span>
                            </div>
                        </div>
                    <?php } ?>


                <?php } ?>

                <?php if (!empty($view['passenger_name']) || !empty($view['passenger_name_en'])){ ?>
                    <div class="row modal-padding-bottom-15">
                        <div class="col-md-3"><span><?php echo functions::Xmlinformation("Room"); ?> : </span><span><?php echo $view['room_name'] ?></span>
                        </div>
                        <div class="col-md-3">
                            <span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span><span>
                                <?php
                                if (!empty($view['passenger_name'])){
                                    echo $view['passenger_name'] . ' ' . $view['passenger_family'];
                                } elseif (!empty($view['passenger_name_en'])){
                                    echo $view['passenger_name_en'] . ' ' . $view['passenger_family_en'];
                                }
                                ?>
                            </span>
                        </div>
                        <div class="col-md-3">
                            <span><?php echo functions::Xmlinformation("Nationalnumber"); ?>/<?php echo functions::Xmlinformation("Passport"); ?>:</span><span><?php echo (!empty($view['passenger_national_code'])) ? $view['passenger_national_code'] : $view['passportNumber'] ?></span>
                        </div>
                        <div class="col-md-3">
                            <span><?php echo functions::Xmlinformation("DateOfBirth"); ?>: </span><span dir="rtl"><?php echo (!empty($view['passenger_birthday'])) ? $view['passenger_birthday'] : $view['passenger_birthday_en'] ?></span>
                        </div>
                    </div>

                <?php }else { ?>
                    <div class="row modal-padding-bottom-15">
                        <div class="col-md-12">
                            <span><?php echo functions::Xmlinformation("Room"); ?> : </span><span><?php echo $view['room_name'] ?></span>
                        </div>
                    </div>
                <?php } ?>


            <?php } ?>




            <?php if ($Hotel[0]['type_application'] == 'reservation' && $Hotel[0]['origin'] != '') { ?>
                <div class="row margin-top-10">
                    <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation("Informationtravel"); ?></span></div>
                </div>
                <div class="row modal-padding-bottom-15">
                    <div class="col-md-6">
                        <span><?php echo functions::Xmlinformation("Origin"); ?> : </span><span></span>
                    </div>
                    <div class="col-md-6">
                        <span><?php echo functions::Xmlinformation("Destination"); ?> :</span><span><?php echo $Hotel[0]['origin'] ?></span>
                    </div>
                </div>
                <div class="row modal-padding-bottom-15">
                    <div class="col-md-3"><span> <?php echo functions::Xmlinformation('NameTransport')?>:</span><span><?php echo $Hotel[0]['airline_went'] ?></span></div>
                    <div class="col-md-3"><span> <?php echo functions::Xmlinformation('Numflight')?>: </span><span><?php echo $Hotel[0]['flight_number_went'] ?></span></div>
                    <div class="col-md-3"><span> <?php echo functions::Xmlinformation('Starttime')?>: </span><span><?php echo $Hotel[0]['hour_went'] ?></span></div>
                    <div class="col-md-3"><span> <?php echo functions::Xmlinformation('Wentdate')?>: </span><span><?php echo $Hotel[0]['flight_date_went'] ?></span></div>
                </div>
                <div class="row modal-padding-bottom-15">
                    <div class="col-md-3"><span><?php echo functions::Xmlinformation('NameTransport')?> :</span><?php echo $Hotel[0]['airline_back'] ?><span></span></div>
                    <div class="col-md-3"><span><?php echo functions::Xmlinformation('Numflight')?> : </span><span><?php echo $Hotel[0]['flight_number_back'] ?></span></div>
                    <div class="col-md-3"><span><?php echo functions::Xmlinformation('Returntime')?> : </span><span><?php echo $Hotel[0]['hour_back'] ?></span></div>
                    <div class="col-md-3"><span><?php echo functions::Xmlinformation('Datewentback')?>: </span><span><?php echo $Hotel[0]['flight_date_back'] ?></span></div>
                </div>
            <?php } ?>



            <?php if ($Hotel[0]['type_application'] == 'reservation' && $objbook->showOneDayTour == 'True'){
                ?>
                <div class="row margin-top-10">
                    <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation('AuthToureOneDay')?></span></div>
                </div>
                <?php
                foreach ($objbook->listOneDayTour as $val){
                    ?>
                    <div class="row modal-padding-bottom-15">
                        <div class="col-md-6">
                            <span> <?php echo functions::Xmlinformation('Title')?>: </span><span><?php echo $val['title'] ?></span>
                        </div>
                        <div class="col-md-6">
                            <span> <?php echo functions::Xmlinformation('Price')?>:</span><span><?php echo $val['price'] ?></span>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>

        <div class="modal-footer site-bg-main-color"></div>

        <?php

    }



    public function ModalShowBook($Param)
    {

        $objDiscountCode = Load::controller('discountCodes');
        $objbook = Load::controller($this->Controller);
        $Hotel = $objbook->info_hotel_client($Param, TYPE_ADMIN);
        ?>

        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">مشاهده مشخصات هتل
                        &nbsp; <?php echo !empty($Hotel[0]['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان'; ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <?php
                    foreach ($Hotel as $key => $view) {

                        if ($key < 1) {

                            if (TYPE_ADMIN == '1') {
                                ?>
                                <!--<div class="row margin-both-vertical-20">
                                    <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات ارائه دهنده هتل</span>
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
                                <hr style="margin: 5px 0;"/>-->
                            <?php } ?>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-12 text-center text-bold" style="color: #fb002a;">
                                    <span>مشخصات کاربر</span></div>
                            </div>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-4 "><span>نام و نام خانوادگی  : </span><span><?php echo $view['member_name']; ?></span></div>
                                <div class="col-md-4 "><span class=""> شماره تلفن موبایل: </span><span class="yn"><?php echo $view['member_mobile']; ?></span></div>
                                <div class="col-md-4 "><span>ایمیل :</span><span><?php echo $view['member_email']; ?></span></div>
                            </div>


                            <hr style="margin: 5px 0;"/>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-12 text-center text-bold" style="color: #fb002a;"><span>اطلاعات خریدار </span>
                                </div>
                            </div>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-6 "><span>نام  : </span><span><?php echo $view['passenger_leader_room_fullName'];?></span></div>
                                <div class="col-md-6 "><span class=""> موبایل : </span><span class="yn"><?php echo $view['passenger_leader_room'];?></span></div>

                            <?php if($view['passenger_leader_room_email']){ ?>
                                <div class="col-md-6 "><span class=""> ایمیل : </span><span class="yn"><?php echo $view['passenger_leader_room_email'];?></span></div>
                            <?php } ?>

                             <?php if($view['passenger_leader_room_postalcode']){ ?>
                                <div class="col-md-6 "><span class=""> کدپستی : </span><span class="yn"><?php echo $view['passenger_leader_room_postalcode'];?></span></div>
                             <?php } ?>

                             <?php if($view['passenger_leader_room_address']){ ?>
                                <div class="col-md-6 "><span class=""> آدرس : </span><span class="yn"><?php echo $view['passenger_leader_room_address'];?></span></div>
                             <?php } ?>

                            </div>
                            <hr style="margin: 5px 0;"/>


                            <div class="row margin-both-vertical-20">
                                <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات پرداخت</span>
                                </div>
                            </div>

                            <?php if($view['status']=='BookedSuccessfully' || $view['status']=='pending'){ ?>

                            <div class="row margin-both-vertical-20">
                                <div class="col-md-4"><span class=" pull-left">تاریخ پرداخت : </span><span class="yn">
                                        <?php echo($view['payment_date'] != '' ? functions::set_date_payment($view['payment_date']) : 'پرداخت نشده'); ?>
                                </span>
                                </div>
                                <?php if ($view['payment_date'] != ''){ ?>

                                    <div class="col-md-4"><span>نوع پرداخت: </span><span>
                                        <?php
                                        if ($view['payment_type'] == 'cash') {
                                            echo 'نقدی';
                                        } else if ($view['payment_type'] == 'credit') {
                                            echo 'اعتباری';
                                        }
                                        ?>
                                    </span>
                                    </div>


                                    <div class="col-md-4">
                                        <span>کد پیگیری بانک: </span>
                                        <span class="yn">
                                            <?php echo !empty($view['tracking_code_bank']) ? $view['tracking_code_bank'] : 'ندارد'; ?>
                                        </span>
                                    </div>


                                    <?php if (TYPE_ADMIN == '1' && $view['payment_type'] == 'cash') {
                                        ?>
                                        <div class="col-md-4">
                                            <span>نام بانک: </span>
                                            <span><?php echo $objbook->namebank($view['name_bank_port'], $view['client_id']); ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="">شماره درگاه: </span>
                                            <span class="yn"><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']); ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span>صاحب امتیاز درگاه: </span>
                                            <span><?php echo $objbook->numberPortBnak($view['name_bank_port'], $view['client_id']) == '379918' ? 'ایران تکنولوژی' : $objbook->nameAgency($view['client_id']); ?></span>
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
                                    <span>مشخصات هتل</span></div>
                            </div>
                            <div class="row margin-both-vertical-20">

                                <?php
                                $payDate = (!empty($view['payment_date']) ? functions::set_date_payment($view['payment_date']) : '');
                                if($payDate != ''){ $payDate = explode(' ', $payDate); }
                                ?>

                                <div class="col-md-4">
                                    <span class=" pull-left">تاریخ رزرو هتل : </span>
                                    <span class="yn"><?php echo !empty($view['payment_date']) ? $payDate[0] : 'ندارد';?></span>
                                </div>
                                <div class="col-md-4">
                                    <span class=" pull-left">ساعت رزرو هتل : </span>
                                    <span class="yn"><?php echo !empty($view['payment_date']) ? $payDate[1] : 'ندارد'; ?></span>
                                </div>
                                <div class="col-md-4">
                                    <span>شماره واچر :</span>
                                    <span class="yn"><?php echo $view['request_number']; ?></span></div>
                            </div>
                   <?php if (!empty($view['hotel_confirm_code'])) { ?>
                   <div class="col-md-4">
                      <span>کد کانفرم هتل :</span>
                      <span class="yn"><?php echo $view['hotel_confirm_code']; ?></span></div>
                </div>
                              <?php }?>
                            <div class="row margin-both-vertical-20">
                                <div class="col-md-4 ">
                                    <span>شهر : </span>
                                    <span><?php echo $view['city_name'] ; ?></span>
                                </div>
                                <div class="col-md-4 ">
                                    <span>هتل : </span>
                                    <span><?php echo $view['hotel_name'] ; ?></span>
                                </div>
                                <div class="col-md-4 ">
                                    <span>مدت اقامت : </span>
                                    <span><?php echo $view['number_night'] .' شب ' ; ?></span>
                                </div>
                            </div>
                            <div class="row margin-both-vertical-20">
                                <div class="col-md-4 ">
                                    <span>تاریخ ورود : </span>
                                    <span><?php echo $view['start_date'] ; ?></span>
                                </div>
                                <div class="col-md-4 ">
                                    <span>تاریخ خروج : </span>
                                    <span><?php echo  $view['end_date'] ; ?></span>
                                </div>
<!--                                <div class="col-md-4 ">-->
<!--                                    <span>هزینه هتل : </span>-->
<!--                                    <span class="yn">--><?php //echo number_format($view['total_price']); ?><!-- ربال </span>-->
<!--                                </div>-->
                                <?php
                                if ($view['payment_status'] != '') {?>

                                  <div class="col-md-3">
                                    <span>مبلغ پیش پرداخت :</span>
                                    <span class="yn"><?php echo number_format($view['hotel_payments_price']); ?></span>
                                  </div>

                                  <div class="col-md-3">
                                    <span>مبلغ باقی مانده:</span>
                                    <span class="yn"><?php echo number_format($view['total_price'] - $view['hotel_payments_price']); ?></span>
                                  </div>

                                <?php }else{ ?>
                                  <div class="col-md-3">
                                    <span>مبلغ پرداختی:</span>
                                    <span class="yn"><?php echo number_format($view['total_price']); ?></span>
                                  </div>
                                <?php } ?>
                            </div>
                            <?php
                            if ($view['status'] == 'Requested' && $view['payment_status'] != '') {?>
                           <div class="modal-footer site-bg-main-color"
                           style="display: flex;gap: 10px;align-items: end;">
                              <div style="display: flex;gap: 10px;flex-direction: column-reverse;">
                              <button type="button" class="btn btn-primary  pull-left" style="margin-right:2px;  height: fit-content;"
                                      onclick="ConfirmAdminRequestedPrereserveHotelUser('<?php echo $view['factor_number']; ?>')">
                                 تایید پیش پرداخت
                              </button>
                              <div style="display: flex;flex-direction: column;">
                                 <label for="ConfirmAdminRequestedPrereserveHotelUserCode">کد کانفرم هتل</label>
                                 <input name="ConfirmAdminRequestedPrereserveHotelUserCode" id="ConfirmAdminRequestedPrereserveHotelUserCode">
                              </div>
                              </div>
                              <button type="button" class="btn btn-danger  pull-left" style="height: fit-content;"
                                      onclick="RejectAdminRequestedPrereserveHotelUser('<?php echo $view['factor_number']; ?>')">
                                 عدم تایید پیش پرداخت
                              </button>

                           </div>
                            <?php }elseif($view['status'] == 'RequestAccepted' && $view['payment_status'] != ''){ ?>
                               <button type="button" class="btn btn-primary  pull-left" style="margin-right:2px">
                                  پیش رزرو توسط ادمین تایید شد
                               </button>
                            <?php }elseif($view['status'] == 'RequestRejected' && $view['payment_status'] != ''){ ?>
                               <button type="button" class="btn btn-danger  pull-left" style="margin-right:2px">
                                  پیش رزرو توسط ادمین رد شد
                               </button>
                            <?php } ?>



                            <?php
                            $discountCodeInfo = $objDiscountCode->getDiscountCodeByFactor($view['factor_number']);
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
                                            <?php echo number_format($view['total_price'] - $discountCodeInfo['amount']); ?>
                                    ریال</span>
                                    </div>
                                </div>
                            <?php } ?>

                            <hr style="margin: 5px 0;"/>

                            <div class="row margin-top-10 margin-both-vertical-20">
                                <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات مسافرین (سرگروه اول هر اتاق) </span>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                            <div class="col-md-3 ">
                                <span>نام و نام خانوادگی :</span>
                                <span>
                                    <?php
                                    if (!empty($view['passenger_name'])){
                                        echo $view['passenger_name'] . ' ' . $view['passenger_family']
                                            . '(' . ($view['passportCountry'] != 'IRN' && $view['passportCountry'] != '' ? $view['passportCountry'] : 'IRN') . ')';
                                    } elseif (!empty($view['passenger_name_en'])){
                                        echo $view['passenger_name_en'] . ' ' . $view['passenger_family_en']
                                            . '(' . ($view['passportCountry'] != 'IRN' && $view['passportCountry'] != '' ? $view['passportCountry'] : 'IRN') . ')';
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="col-md-3 ">
                                <span>شماره ملی/پاسپورت:</span>
                                <span class="yn"><?php echo $view['passenger_national_code'] == '0000000000' ? $view['passportNumber'] : $view['passenger_national_code']; ?></span>
                            </div>
                            <?php if(!($view['source_id']==29)){  ?>

                            <div class="col-md-3 ">
                                <span class=" pull-left">  تاریخ تولد:</span>
                                <span class="yn"><?php echo !empty($view['passenger_birthday']) ? $view['passenger_birthday'] : $view['passenger_birthday_en']; ?></span>
                            </div>
                            <?php }  ?>
                            <div class="col-md-3 ">
                                <span class=" pull-left">اتاق:</span>
                                <span class=" pull-left"><?php echo $view['room_count'] . ' باب ' . $view['room_name']; ?></span>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="modal-footer site-bg-main-color">


                    </div>
                </div>
            </div>

        </div>

        <?php

    }

    public function ModalShowEditBookHotel($Param)
    {

        $objbook = Load::controller($this->Controller);
        $edit = $objbook->infoEditBookingHotel($Param, TYPE_ADMIN);
        //echo Load::plog($edit);

        $hotel = functions::GetInfoHotel($Param);
        ?>

        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">مشاهده ویرایش های رزرو هتل
                        &nbsp; <?php echo !empty($hotel['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان'; ?>
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span> مشخصات <?php echo $hotel['hotel_name'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 ">
                            <span>شهر : </span>
                            <span><?php echo $hotel['city_name'] ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span>هتل : </span>
                            <span><?php echo $hotel['hotel_name'] ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span>مدت اقامت : </span>
                            <span><?php echo $hotel['number_night'] ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span>مبلغ : </span>
                            <span><?php echo number_format(functions::calcDiscountCodeByFactor($hotel['total_price'], $Param)) ?> ریال</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 ">
                            <span>تاریخ رزرو هتل : </span>
                            <span dir="rtl"><?php echo $objbook->set_date_reserve($hotel['payment_date']) ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span>تاریخ ورود : </span>
                            <span dir="rtl"><?php echo $hotel['start_date'] ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span>تاریخ خروج : </span>
                            <span dir="rtl"><?php echo $hotel['end_date'] ?></span>
                        </div>
                    </div>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>تغییرات انجام شده:</span>
                        </div>
                    </div>

                    <?php foreach ($edit as $key => $view) { ?>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-4"><span> تاریخ و ساعت تغییر: </span>
                                <span dir="rtl"><?php echo $objbook->set_date_reserve($view['creation_date']) ;?></span>
                                <span><?php echo $objbook->set_time_payment($view['creation_date']) ;?></span>
                            </div>
                            <div class="col-md-8">
                                <span>توضیحات: </span><span><?php echo $view['description'] ;?></span>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>

        </div>

        <?php

    }



    #region setCancelExternalHotel
    public function setCancelExternalHotel($factorNumber)
    {
        $objExternalHotel = Load::controller('resultExternalHotel');
        $resultCancel = $objExternalHotel->productCancelDetail($factorNumber);
        ?>
        <div class="modal-header site-bg-main-color">
            <div class="col-md-10">
                <h6 class="modal-h"><?php echo functions::Xmlinformation("Cancelpurchasebookingnumber")?><?= $factorNumber ?></h6>
            </div>
            <div class="col-md-2">
                <span class="close" onclick="modalClose()">×</span>
            </div>
        </div>

        <?php
        if ($resultCancel['error'] == false){
            ?>
            <div class="modal-body" style="overflow: initial;">
                <div class="modal-padding-bottom-15">

                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 reservation-cancellations-ticket">
                            <?php echo $resultCancel['message']; ?>
                        </div>
                    </div>

                    <?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') { ?>
                        <div class="row">
                            <div class="col-md-12 modal-text-center modal-h ">
                                <label><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                                <label style="float:right;"><?php echo functions::Xmlinformation("Cardnumber") ?></label>
                                <input class="form-control " type="text" id="cardNumber" name="cardNumber"
                                       style="float: right;margin-right: 10px">
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                                <label style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
                                <input class="form-control " type="text" id="accountOwner" name="accountOwner"
                                       style="float: right;margin-right: 10px">
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                                <label style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
                                <input class="form-control " type="text" id="nameBank" name="nameBank"
                                       style="float: right;margin-right: 10px">
                            </div>
                        </div>
                    <?php } ?>


                    <div class="row">
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
                           onclick="requestCancelExternalHotel('<?= $factorNumber ?>')"
                           type="button" value="<?php echo functions::Xmlinformation("Sendinformation") ?>">
                </div>
            </div>
            <?php

        } else {
            ?>
            <div class="modal-body" style="overflow: initial;">
                <div class="modal-padding-bottom-15">
                    <div class="row">
                        <div class="col-md-12 modal-text-center modal-h">
                            <?php echo $resultCancel['message']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>


        <?php




    }
    #endregion

    #region setCancelExternalHotel
    public function ModalSetHotelInvoice($param)
    {

        if(isset($param) && $param != '' ) {

        ?>
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
        <div class="modal-content">
               <div class="modal-header site-bg-main-color">
              <div class="col-md-10">
                <h6 class="modal-h">برای ثبت فاکتور رزرو انجام شده انجام شده موراد زیر را وارد کنید.</h6>
              </div>
              <div class="col-md-2">
                <span class="close" onclick="modalClose()">×</span>
              </div>
            </div>
              <div class="modal-body" style="overflow: initial;">
                <div class="modal-padding-bottom-15">

                    <input type='hidden' name='tracking_code' id='tracking_code' value='<?php echo $param ?>'>
                    <div class="row">
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" >
                        <label style="float:right;">واریز از</label>
                        <input class="form-control " type="text" id="from_company" name="nameBank"
                               style="float: right;margin-right: 10px">
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" >
                        <label style="float:right;">واریز به</label>
                        <input class="form-control " type="text" id="to_company" name="to_company"
                               style="float: right;margin-right: 10px">
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" >
                        <label style="float:right;">حساب مبدا</label>
                        <input class="form-control " type="text" id="origin_account" name="origin_account"
                               style="float: right;margin-right: 10px">
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <label style="float:right;">حساب مقصد</label>
                        <input class="form-control " type="text" id="destination_account" name="destination_account"
                               style="float: right;margin-right: 10px">
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" >
                        <label style="float:right;">نام صاحب حساب</label>
                        <input class="form-control " type="text" id="account_holder" name="account_holder"
                               style="float: right;margin-right: 10px">
                      </div>
                      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <label style="float:right;">توضیحات</label>
                        <input class="form-control " type="text" id="description" name="description"
                               style="float: right;margin-right: 10px">
                      </div>
                      <div class="col-md-12" style="text-align:left;">
                        <input class="close btn btn-primary btn-send-information"
                               onclick="setPaymentData('<?php echo $param ?>')"
                               type="button" value="<?php echo functions::Xmlinformation("Sendinformation") ?>">
                      </div>
                    </div>

                </div>
              </div>

        </div>
    </div>
        <?php
        }else{

            ?>
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header site-bg-main-color">
            <div class="col-md-10">
              <h6 class="modal-h">برای ثبت فاکتور خریدهای انتخاب شده موراد زیر را وارد کنید.</h6>
            </div>
            <div class="col-md-2">
              <span class="close" onclick="modalClose()">×</span>
            </div>
          </div>
            <div class="modal-body" style="overflow: initial;">
                <div class="modal-padding-bottom-15">
                    <div class="row">
                        <div class="col-md-12 modal-text-center modal-h">
                            شما برای ثبت فاکتور حداقل باید یک خرید را انتخاب کنید.
                        </div>
                    </div>
                </div>
            </div>
          </div>
          </div>
            <?php
        }
        ?>

        <?php

    }
    #endregion



}

new ModalCreatorForHotel();
?>