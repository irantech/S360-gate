<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));
/**
 * Class ModalCreatorForTour
 * @property ModalCreatorForTour $ModalCreatorForTour
 */
class ModalCreatorForTour extends clientAuth
{
    public $Controller;
    public $Method;
    public $target;
    public $factorNumber;
    public $id;



    public function __construct()
    {
        $Method = $_POST['Method'];
        $factorNumber = $_POST['factorNumber'];
        self::$Method($factorNumber);

    }

    public function ModalShow($factorNumber)
    {

        $infoBook = functions::GetInfoTour($factorNumber);
        $passengerList = functions::GetInfoTourPassengers($factorNumber);

        /** @var resultTourLocal $resultTourLocalController */
        $resultTourLocalController=Load::controller('resultTourLocal');

        $resultTourLocalController->getInfoTourByIdTour($infoBook['tour_id']);
        $tourDetail=$resultTourLocalController->arrayTour['infoTour'];
        $cities=[];
        if(SOFTWARE_LANG === 'fa'){
            $index_name='name';
            $index_name_tag='name_fa';
            $index_city='city_name';
        }else{
            $index_name=$index_name_tag='name_en';
            $index_city='city_name_en';


        }
        foreach($resultTourLocalController->arrayTour['infoTourRout'] as $route)
        {
            $cities[] = $route[$index_name];
        }


        ?>

        <div class="modal-header site-bg-main-color">
            <span class="close" onclick="modalClose('')">&times;</span>
            <h6 class="modal-h">  <?php echo functions::Xmlinformation("Viewpurchasetobookingnumber"); ?>:<?php echo $factorNumber; ?> </h6>
        </div>

            <div class="modal-body">

            <div class="row margin-both-vertical-20">
                <div class="col-md-12 modal-text-center modal-h">
                    <span> <?php echo functions::Xmlinformation("TourReservationSpecifications"); ?> <?php echo $infoBook['tour_name'] . " " . $infoBook['tour_code']; ?> </span>
                    (<span> <?php echo functions::Xmlinformation("Paymentamount"); ?>: <?php echo number_format($infoBook['tour_payments_price']); ?> <?php echo functions::Xmlinformation("Rial"); ?> </span>)
                </div>
            </div>

            <div class="row">

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Origin"); ?> : </span>
                    <span><?php

                        if(SOFTWARE_LANG === 'fa'){
                            echo $resultTourLocalController->arrayTour['infoTour']['country_name'] . ' - ' . $resultTourLocalController->arrayTour['infoTour']['name'] . ' - ' . $infoBook['tour_origin_region_name'];
                        }else{
                            echo $resultTourLocalController->arrayTour['infoTour']['country_name_en'] . ' - ' . $resultTourLocalController->arrayTour['infoTour']['name_en'] . ' - ' . $infoBook['tour_origin_region_name'];
                        }


                          ?></span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("ToursOfCity"); ?> : </span>
                    <span><?php echo join(', ',$cities); ?></span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Datetravelwent"); ?> : </span>
                    <span><?php echo $infoBook['tour_start_date']; ?></span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Datewentback"); ?> : </span>
                    <span><?php echo $infoBook['tour_end_date']; ?></span>
                </div>

            </div>


            <div class="row">

                <div class="col-md-3">
                    <?php if ($infoBook['tour_night'] > 0){ ?>
                        <span><?php echo $infoBook['tour_night']; ?></span>
                        <span> <?php echo functions::Xmlinformation("Night"); ?> </span>
                    <?php } ?>
                    <span><?php echo $infoBook['tour_day']; ?></span>
                    <span> <?php echo functions::Xmlinformation("Day"); ?> </span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Permissibleamount"); ?>: </span>
                    <span><?php echo $infoBook['tour_free']; ?></span>
                    <span> <?php echo functions::Xmlinformation("Kilograms"); ?> </span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Visa"); ?>: </span>
                    <span><?php if ($infoBook['tour_visa'] == 'yes'){ echo functions::Xmlinformation("Have");} else { echo functions::Xmlinformation("Donthave");}; ?></span>
                    <span><?php echo functions::Xmlinformation("Insurance"); ?>: </span>
                    <span><?php if ($infoBook['tour_insurance'] == 'yes'){ echo functions::Xmlinformation("Have");} else { echo functions::Xmlinformation("Donthave");}; ?></span>
                </div>

                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("TotalPrice"); ?>: </span>
                    <span><?php echo number_format($infoBook['tour_total_price']); ?> <?php echo functions::Xmlinformation("Rial"); ?> </span>
                </div>

            </div>


            <div class="row margin-top-10">
                <div class="col-md-12 modal-text-center modal-h"><span><?php echo functions::Xmlinformation("Travelerprofile"); ?></span></div>
            </div>
            <?php foreach ($passengerList as $passenger) { ?>
            <div class="row modal-padding-bottom-15">
                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span><span><?php echo $passenger['passenger_name'] . ' ' . $passenger['passenger_family'] ?></span>
                </div>
                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("nationalCodeOrPassPort"); ?> :</span><span><?php echo (!empty($passenger['passenger_national_code'])) ? $passenger['passenger_national_code'] : $passenger['passportNumber'] ?></span>
                </div>
                <div class="col-md-3">
                    <span><?php echo functions::Xmlinformation("DateOfBirth"); ?> : </span><span dir="rtl"><?php echo (!empty($passenger['passenger_birthday'])) ? $passenger['passenger_birthday'] : $passenger['passenger_birthday_en'] ?></span>
                </div>
                <div class="col-md-3">
                    <?php
                    if (!empty($passenger['passenger_national_image'])){
                        ?>
                        <a id="downloadLink" target="_blank"
                           href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . $passenger['passenger_national_image']; ?>"
                           type="application/octet-stream"><?php echo functions::Xmlinformation("Downloadimg"); ?><i class="fa fa-download"></i>
                        </a>
                        <?php
                    } elseif (!empty($infoBook['passenger_passport_image'])){
                        ?>
                        <a id="downloadLink" target="_blank"
                           href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . $passenger['passenger_passport_image']; ?>"
                           type="application/octet-stream"><?php echo functions::Xmlinformation("Downloadimg"); ?><i class="fa fa-download"></i>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php } ?>
        </div>

        <?php

    }


    public function ModalShowBook($factorNumber)
    {
        $objDiscountCode = Load::controller('discountCodes');
        $infoBook = functions::GetInfoTour($factorNumber);
        $passengerList = functions::GetInfoTourPassengers($factorNumber);
        /** @var reservationTour $tourController */
        $tourController=$this->getController('reservationTour');
        $priceChanged=$tourController->getRequestPriceChanged($factorNumber);
        $tourInfo=$tourController->infoTourById($infoBook['tour_id']);
        $objResultBookHotelShow = Load::controller('bookhotelshow');
        $requestStatuses=[
            [
                'index'=>'Requested',
                'title'=>'درخواست شده',
            ],
            [
                'index'=>'RequestRejected',
                'title'=>'رد کردن درخواست',
            ],
            [
                'index'=>'RequestAccepted',
                'title'=>'تایید درخواست',
            ],
        ];
        ?>

        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">مشاهده مشخصات رزرو تور
                        &nbsp; <?php echo !empty($infoBook['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان'; ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <?php

                    if (TYPE_ADMIN == '1') {
                        ?>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات ارائه دهنده تور</span>
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

                    <?php if($infoBook['status']=='BookedSuccessfully' || $infoBook['status']=='PreReserve'){ ?>

                        <div class="row margin-both-vertical-20">
                            <div class="col-md-4"><span class=" pull-left">تاریخ پرداخت : </span><span class="yn">
                                    <?php echo($infoBook['payment_date']);?>
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
                            <span>مبلغ کل:</span>
                            <span class="yn"><?php echo number_format($infoBook['tour_total_price']); ?></span>
                        </div>


                        <?php
                        if (!empty($infoBook['tour_discount'])) {?>
                            <div class="col-md-3">
                                <span>درصد تخفیف :</span>
                                <span class="yn"><?php echo number_format($infoBook['tour_discount']); ?></span>
                            </div>

                            <div class="col-md-3">
                                <span>مبلغ بعد از تخفیف :</span>
                                <span class="yn"><?php echo number_format($infoBook['tour_total_price']); ?></span>
                            </div>



                        <?php } ?>

                        <?php
                        if ($infoBook['status'] == 'PreReserve') {?>

                            <div class="col-md-3">
                                <span>مبلغ پیش پرداخت :</span>
                                <span class="yn"><?php echo number_format($infoBook['tour_payments_price']); ?></span>
                            </div>

                            <div class="col-md-3">
                                <span>مبلغ باقی مانده:</span>
                                <span class="yn"><?php echo number_format($infoBook['tour_total_price'] - $infoBook['tour_payments_price']); ?></span>
                            </div>

                        <?php }else{ ?>
                            <div class="col-md-3">
                                <span>مبلغ پرداختی:</span>
                                <span class="yn"><?php echo number_format($infoBook['tour_payments_price']); ?></span>
                            </div>
                        <?php } ?>





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
                        <div class="col-md-3">
                            <span class=" pull-left">نام تور: </span>
                            <span class="yn"><?php echo $infoBook['tour_name'];?></span>
                        </div>
                        <div class="col-md-3">
                            <span class=" pull-left">کد تور: </span>
                            <span class="yn"><?php echo  $infoBook['tour_code']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span class=" pull-left">مبدا: </span>
                            <span class="yn"><?php echo  $infoBook['tour_origin_country_name'] . ' - ' . $infoBook['tour_origin_city_name'] . ' - ' . $infoBook['tour_origin_region_name']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span class=" pull-left">شهرهای تور: </span>
                            <span class="yn"><?php echo  $infoBook['tour_cities']; ?></span>
                        </div>
                    </div>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-4">
                            <span class=" pull-left">تاریخ رفت: </span>
                            <span class="yn"><?php echo $infoBook['tour_start_date'];?></span>
                        </div>
                        <div class="col-md-4">
                            <span class=" pull-left">تاریخ برگشت: </span>
                            <span class="yn"><?php echo  $infoBook['tour_end_date']; ?></span>
                        </div>
                        <div class="col-md-4">
                            <span class="yn"><?php echo  $infoBook['tour_night']; ?></span>
                            <span> شب </span>
                            <span class="yn"><?php echo  $infoBook['tour_day']; ?></span>
                            <span> روز </span>
                        </div>
                    </div>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-4">
                            <span>میزان بار مجاز: </span>
                            <span><?php echo $infoBook['tour_free']; ?></span>
                            <span> کیلوگرم </span>
                        </div>
                        <div class="col-md-4">
                            <span>ویزا: </span>
                            <span><?php if ($infoBook['tour_visa'] == 'yes'){ echo 'دارد';} else { echo 'ندارد';}; ?></span>
                        </div>
                        <div class="col-md-4">
                            <span>بیمه: </span>
                            <span><?php if ($infoBook['tour_insurance'] == 'yes'){ echo 'دارد';} else { echo 'ندارد';}; ?></span>
                        </div>
                    </div>

                    <hr style="margin: 5px 0;"/>
                    <div class="row margin-top-10 margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات خریدار </span>
                        </div>
                    </div>

                <?php foreach ($passengerList as $passenger ) {?>
                    <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                        <div class="col-md-3">
                            <span>نام و نام خانوادگی :</span>
                            <span><?php echo $passenger['passenger_name'] . ' ' . $passenger['passenger_family'] . '(' . ($passenger['passportCountry'] != 'IRN' && $passenger['passportCountry'] != '' ? $passenger['passportCountry'] : 'IRN') . ')'; ?> </span>
                        </div>
                        <div class="col-md-3">
                            <span>شماره ملی/پاسپورت:</span>
                            <span class="yn"><?php echo $passenger['passenger_national_code'] == '0000000000' ? $passenger['passportNumber'] : $passenger['passenger_national_code']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span class=" pull-left">تاریخ تولد:</span>
                            <span class="yn"><?php echo !empty($passenger['passenger_birthday']) ? $passenger['passenger_birthday'] : $passenger['passenger_birthday_en']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <?php
                            if (!empty($passenger['passenger_national_image'])){
                                ?>
                                <a id="downloadLink" target="_blank"
                                   href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . $passenger['passenger_national_image']; ?>"
                                   type="application/octet-stream">دانلود عکس<i class="fa fa-download"></i>
                                </a>
                                <?php
                            } elseif (!empty($passenger['passenger_passport_image'])){
                                ?>
                                <a id="downloadLink" target="_blank"
                                   href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . $passenger['passenger_passport_image']; ?>"
                                   type="application/octet-stream">دانلود عکس<i class="fa fa-download"></i>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-md-12 p-0 mt-5">
                            <?php


                            $custom_file_fields=json_decode($passenger['custom_file_fields'],true);



                                if (!empty($custom_file_fields)){

                                    foreach ($custom_file_fields as $item){

                                        ?>
                            <div class="col-md-3">

                                        <a id="downloadLink" target="_blank"
                                           class="d-flex flex-wrap justify-content-center"
                                           href="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . array_values($item)[0]; ?>"
                                           type="application/octet-stream">
                                            <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG .'/pic/reservationTour/passengersImages/' . array_values($item)[0]; ?>"
                                                 class="w-100 p-3 mb-3 border rounded"
                                                 alt="<?php echo key($item);?>">
                                            <?php echo key($item);?><i class="fa mr-2 fa-download"></i>
                                        </a>
                            </div>
                                        <?php
                                    }
                                }
                            ?>

                    </div>


                </div>
                <?php  } ?>

                    <?php if($tourInfo['is_request'] == '1'){?>





                    <hr style="margin: 5px 0;"/>
                    <div class="row margin-top-10 margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>ویرایش وضعیت درخواست</span>
                        </div>
                    </div>

                    <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                        <div class='col-md-12'>
                            <?php     foreach ($requestStatuses as $requestStatus) {?>
                               <button data-name='<?php echo $requestStatus['index'];?>' onclick='changeRequestedTourStatus($(this),"<?php echo $infoBook['factor_number']; ?>","<?php echo $requestStatus['index'];?>")'
                                    class='btn <?php if($requestStatus['index'] != $infoBook['status']){echo 'btn-outline'; } ?> btn-primary'><?php echo $requestStatus['title'];?></button>
                            <?php }?>


                        </div>
                    </div>


                        <hr style="margin: 5px 0;"/>
                        <div class="row margin-top-10 margin-both-vertical-20">
                            <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>ویرایش قیمت درخواست</span>
                            </div>
                        </div>

                        <div class="row modal-padding-bottom-15 margin-both-vertical-20">
                            <div class='col-md-12'>
                                <input type='text'
                                       value='<?php echo $priceChanged;?>'
                                       class='form-control'
                                       onchange='changeRequestedTourPrice($(this),"<?php echo $infoBook['factor_number']; ?>")'>

                            </div>
                        </div>



                <?php } ?>



            </div>

        </div>

        <?php

    }








public function ModalShowForReserveTour($factorNumber)
{
    $tourCode = $factorNumber;
    $Model = Load::library('Model');

    // بررسی اولیه
    if (empty($tourCode)) {
        ?>
        <div class="manifest-modal-header manifest-bg-main-color">
            <span class="manifest-modal-close" onclick="closeModalReserve()">&times;</span>
            <h6 class="manifest-modal-title">اطلاعات تور</h6>
        </div>
        <div class="manifest-modal-body">
            <div class="manifest-empty-state">
                <p class="manifest-empty-text">کد تور نامعتبر می‌باشد.</p>
            </div>
        </div>
        <?php
        return;
    }

    // دریافت اطلاعات کلی تور
    $sqlTour = "SELECT * FROM reservation_tour_tb 
                WHERE tour_code = '{$tourCode}'
                ORDER BY id DESC LIMIT 1";
    $infoBook = $Model->select($sqlTour);

    if (empty($infoBook)) {
        ?>
        <div class="manifest-modal-header manifest-bg-main-color">
            <span class="manifest-modal-close" onclick="closeModalReserve()">&times;</span>
            <h6 class="manifest-modal-title">اطلاعات تور</h6>
        </div>
        <div class="manifest-modal-body">
            <div class="manifest-empty-state">
                <p class="manifest-empty-text">کد تور نامعتبر می‌باشد.</p>
            </div>
        </div>
        <?php
        return;
    }

    $infoBook = $infoBook[0];

    // دریافت لیست مسافران
    $sqlPassengers = "SELECT * FROM book_tour_local_tb 
                      WHERE tour_code = '{$tourCode}'
                      AND (status = 'BookedSuccessfully' 
                           OR (status = 'RequestAccepted' AND payment_status = 'fullPayment'))
                      ORDER BY id ASC";
    $passengerList = $Model->select($sqlPassengers);

    // محاسبه مجموع مبلغ
    $totalAmount = 0;
    foreach ($passengerList as $passenger) {
        $totalAmount += $passenger['tour_total_price'];
    }
?>
<div class="manifest-modal-header manifest-bg-main-color">
    <span class="manifest-modal-close" onclick="closeModalReserve()">&times;</span>
    <h6 class="manifest-modal-title">لیست مسافران تور: <?php echo $infoBook['tour_name'] . ' (' . $tourCode . ')'; ?></h6>
</div>

<div class="manifest-modal-body">
    <?php if (!empty($passengerList)) { ?>
        <div class="manifest-summary-section">
            <div class="manifest-price-summary">
                <span class="manifest-price-item manifest-total-amount">مجموع مبلغ مسافران: <?php echo number_format($totalAmount); ?> ریال</span>
            </div>
        </div>

        <div class="manifest-passenger-section">
            <div class="manifest-table-container">
                <div class="manifest-table-responsive">
                    <table class="manifest-passenger-table">
                        <thead class="manifest-table-header">
                            <tr>
                                <th width="5%">ردیف</th>
                                <th width="20%">نام و نام خانوادگی</th>
                                <th width="15%">کد ملی / پاسپورت</th>
                                <th width="12%">شماره همراه</th>
                                <th width="12%">تاریخ تولد</th>
                                <th width="8%">جنسیت</th>
                                <th width="8%">سن</th>
                                <th width="20%">مبلغ (ریال)</th>
                            </tr>
                        </thead>
                        <tbody class="manifest-table-body">
                            <?php
                            $counter = 1;
                            foreach ($passengerList as $passenger) {
                            ?>
                                <tr class="manifest-passenger-row">
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo $passenger['passenger_name'] . ' ' . $passenger['passenger_family']; ?></td>
                                    <td><?php echo !empty($passenger['passenger_national_code']) ? $passenger['passenger_national_code'] : $passenger['passportNumber']; ?></td>
                                    <td><?php echo $passenger['member_mobile']; ?></td>
                                    <td><?php echo !empty($passenger['passenger_birthday']) ? $passenger['passenger_birthday'] : $passenger['passenger_birthday_en']; ?></td>
                                    <td><?php echo $passenger['passenger_gender'] == 'Male' ? 'مرد' : ($passenger['passenger_gender'] == 'Female' ? 'زن' : 'نامشخص'); ?></td>
                                    <td><?php echo !empty($passenger['passenger_age']) ? $passenger['passenger_age'] : '---'; ?></td>
                                    <td><?php echo number_format($passenger['tour_total_price']); ?></td>
                                </tr>
                            <?php } ?>
                            <tr class="manifest-total-row">
                                <td colspan="7" class="manifest-total-label">جمع کل</td>
                                <td class="manifest-total-amount"><?php echo number_format($totalAmount); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="manifest-empty-state">
            <p class="manifest-empty-text">برای این تور رزروی صورت نگرفته است.</p>
        </div>
    <?php } ?>
</div>

    <script>
        // تابع بستن مودال
        function closeModalReserve() {
            const modal = document.getElementById('ModalPublic');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // بستن مودال با کلید ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModalReserve();
            }
        });

        // بستن مودال با کلیک خارج از محتوا
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('ModalPublic');
            const modalContent = document.querySelector('.manifest-modal-content');

            if (modal && modalContent && event.target === modal) {
                closeModalReserve();
            }
        });
    </script>

    <style>
        /* استایل‌های اصلی مودال */
        .manifest-modal-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px 8px 0 0;
            position: relative;
        }

        .manifest-modal-title {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .manifest-modal-close {
            float: left;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            margin-top: -5px;
            transition: opacity 0.3s ease;
            line-height: 1;
        }

        .manifest-modal-close:hover {
            opacity: 0.7;
            color: #ff6b6b;
        }

        .manifest-modal-body {
            padding: 20px;
            background: #f8f9fa;
        }

        /* بخش خلاصه قیمت */
        .manifest-summary-section {
            margin-bottom: 25px;
        }

        .manifest-price-summary {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .manifest-price-item {
            background: white;
            padding: 12px 20px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            font-weight: bold;
            color: #2c3e50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .manifest-total-amount {
            border-color: #27ae60;
            color: #27ae60;
        }

        .manifest-passenger-count {
            border-color: #3498db;
            color: #3498db;
        }

        /* استایل جدول */
        .manifest-table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .manifest-table-responsive {
            overflow-x: auto;
        }

        .manifest-passenger-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Vazir', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            min-width: 800px;
        }

        .manifest-table-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        }

        .manifest-table-header th {
            color: white;
            padding: 15px 8px;
            text-align: center;
            font-weight: 600;
            border: none;
            position: relative;
        }

        .manifest-table-header th:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 60%;
            background: rgba(255,255,255,0.3);
        }

        .manifest-table-body {
            background: white;
        }

        .manifest-passenger-row {
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f1f3f4;
        }

        .manifest-passenger-row:hover {
            background-color: #f8f9fa;
        }

        .manifest-passenger-row td {
            padding: 12px 8px;
            text-align: center;
            vertical-align: middle;
            border: none;
        }

        .manifest-row-number {
            font-weight: bold;
            color: #6c757d;
            background: #f8f9fa;
        }

        .manifest-passenger-name {
            font-weight: 600;
            color: #2c3e50;
            text-align: right !important;
        }

        .manifest-national-code {
            font-family: 'Courier New', monospace;
            font-weight: 500;
            color: #495057;
        }

        .manifest-mobile {
            direction: ltr;
            text-align: center;
            color: #6c757d;
        }

        .manifest-birthdate {
            font-size: 12px;
            color: #495057;
        }

        .manifest-gender {
            font-weight: 500;
        }

        .manifest-age {
            color: #6c757d;
            font-weight: 500;
        }

        .manifest-amount {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #27ae60;
            direction: ltr;
            text-align: left !important;
        }

        /* ردیف مجموع */
        .manifest-total-row {
            background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%) !important;
            font-weight: bold;
            border-top: 2px solid #27ae60;
        }

        .manifest-total-label {
            text-align: center;
            color: #155724;
            font-size: 14px;
            padding: 15px 8px;
        }

        .manifest-total-amount {
            color: #155724;
            font-size: 14px;
            padding: 15px 8px;
            text-align: left !important;
        }

        /* حالت خالی بهبود یافته */
        .manifest-empty-state {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .manifest-empty-icon {
            color: #f39c12;
            margin-bottom: 20px;
        }

        .manifest-empty-icon svg {
            stroke-width: 1.5;
        }

        .manifest-empty-title {
            color: #e67e22;
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: bold;
        }

        .manifest-empty-text {
            color: #7f8c8d;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .manifest-empty-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            text-align: right;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .manifest-detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .manifest-detail-item:last-child {
            border-bottom: none;
        }

        .manifest-detail-label {
            color: #6c757d;
            font-weight: 500;
        }

        .manifest-detail-value {
            color: #2c3e50;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }

        /* استایل برای حالت‌های خطا */
        .manifest-bg-error {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%) !important;
        }

        .manifest-bg-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%) !important;
        }

        /* ریسپانسیو */
        @media (max-width: 768px) {
            .manifest-modal-body {
                padding: 15px;
            }

            .manifest-price-summary {
                gap: 15px;
                flex-direction: column;
                align-items: center;
            }

            .manifest-price-item {
                padding: 10px 15px;
                font-size: 14px;
            }

            .manifest-passenger-table {
                font-size: 12px;
            }

            .manifest-passenger-row td {
                padding: 10px 6px;
            }

            .manifest-table-header th {
                padding: 12px 6px;
                font-size: 12px;
            }

            .manifest-empty-state {
                padding: 30px 15px;
            }

            .manifest-empty-title {
                font-size: 18px;
            }

            .manifest-empty-text {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .manifest-modal-header {
                padding: 12px 15px;
            }

            .manifest-modal-title {
                font-size: 14px;
            }

            .manifest-price-item {
                padding: 8px 12px;
                font-size: 13px;
            }

            .manifest-empty-details {
                padding: 15px;
            }
        }
    </style>
<?php
}


}

new ModalCreatorForTour();
?>