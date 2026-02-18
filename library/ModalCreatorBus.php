<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));
/**
 * Class ModalCreatorBus
 * @property ModalCreatorBus $ModalCreatorBus
 */
class ModalCreatorBus
{

    public $Controller;
    public $Method;
    public $target;
    public $id;

    #region __construct
    public function __construct()
    {
        $this->Controller = $_POST['Controller'];
        $Method = $_POST['Method'];
        $Param = $_POST['Param'];
        self::$Method($Param);
    }
    #endregion

    #region ModalShowBusBook
    public function ModalShowBusBook($factorNumber)
    {
        $objbook = Load::controller($this->Controller);
        $book = $objbook->getBookReportBusTicket($factorNumber);


        ?>

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> مشاهده بلیط اتوبوس
                        &nbsp; <?php echo !empty($book[0]['member_name']) ? 'کاربر اصلی ' : 'کاربرمهمان' ?></h4>
                </div>

                <div class="modal-body">

                    <?php
                    if ($book[0]['member_name'] != '') {
                        ?>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-12 text-center text-bold" style="color: #fb002a;">
                                <span>مشخصات کاربر</span></div>
                        </div>
                        <div class="row margin-both-vertical-20">
                            <div class="col-md-6 ">
                                <span>نام : </span>
                                <span><?php echo $book[0]['member_name']; ?></span>
                            </div>
                            <div class="col-md-6 ">
                                <span class=""> شماره تلفن موبایل: </span>
                                <span class="yn"><?php echo $book[0]['member_mobile']; ?></span>
                            </div>
                            <div class="col-md-6 ">
                                <span>ایمیل :</span>
                                <span><?php echo $book[0]['member_email']; ?></span>
                            </div>
                          <div class="col-md-6 ">
                                <span>تاریخ تولد :</span>
                                <span dir='ltr'><?php echo $book[0]['passenger_birthday']; ?></span>
                            </div>
                        </div>
                        <hr style="margin: 5px 0;"/>
                        <?php
                    }
                    ?>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold" style="color: #fb002a;">
                            <span>اطلاعات مسافران </span>
                        </div>
                    </div>
                    <?php
                      foreach($book as $key => $passenger) {
                        ?>
                        <div class="row margin-both-vertical-20">
                          <div class="col-md-3 ">
                            <span>نام و نام خانوادگی: </span>
                            <span><?php echo $passenger['passenger_name'] . ' ' . $passenger['passenger_family']; ?></span>
                          </div>
                          <div class="col-md-3 ">
                            <span>شماره موبایل: </span>
                            <span><?php echo $passenger['passenger_mobile'] ?></span>
                          </div>
                          <div class="col-md-3 ">
                            <span class=""> ایمیل: </span>
                            <span class="yn"><?php echo $passenger['passenger_email'] ?></span>
                          </div>
                          <div class="col-md-1 ">
                            <span>تعداد: </span>
                            <span><?php echo $passenger['passenger_number'] ?></span>
                          </div>
                          <div class="col-md-3 ">
                            <span>کد ملی مسافران: </span>
                            <span><?php echo $passenger['passenger_national_code'] ?></span>
                          </div>
                          <div class="col-md-3 ">
                            <span>تاریخ تولد مسافر: </span>
                            <span dir='ltr'><?php echo $passenger['passenger_birthday'] ?></span>
                          </div>
                          <div class="col-md-3 ">
                            <span>جنسیت مسافران: </span>
                              <?php
//                              $chairs = explode(',' , $passenger['genders']) ;
//
//                              foreach($chairs as $chair) {
                                  ?>
                                <span><?php echo  $passenger['passenger_gender'] == 'Male' ? 'اقا' : 'خانم' ?></span>
<!--                              --><?php //} ?>
                          </div>
                          <div class="col-md-2 ">
                            <span>شماره صندلی: </span>

                            <span><?php echo $passenger['passenger_chairs'] ?></span>
                          </div>
                        </div>
                    <?php
                      }
                    ?>

                    <hr style="margin: 5px 0;"/>


                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                            <span>مشخصات پرداخت</span>
                        </div>
                    </div>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-4">
                            <span class=" pull-left">تاریخ پرداخت : </span>
                            <span class="yn"
                                  dir="ltr"><?php echo($book[0]['payment_date'] != '' ? functions::set_date_payment($book[0]['payment_date']) : 'پرداخت نشده'); ?></span>
                        </div>
                        <div class="col-md-4">
                            <span>کد پیگیری بانک: </span>
                            <span class="yn"><?php echo !empty($book[0]['tracking_code_bank']) ? $book[0]['tracking_code_bank'] : 'ندارد'; ?></span>
                        </div>
                        <div class="col-md-4">
                            <span class="">شماره بلیط: </span>
                            <span class="yn"><?php echo $book[0]['pnr'] ?></span>
                        </div>
                    </div>
                    <hr style="margin: 5px 0;"/>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                            <span>مشخصات بلیط</span></div>
                    </div>



                    <div class="row margin-both-vertical-20">

                        <div class="col-md-3">
                            <span class=" pull-left">مبدا : </span>
                            <span class="yn"><?php echo $book[0]['OriginCity'] ?></span>
                        </div>
                        <div class="col-md-3">
                            <span>مقصد انتخابی :</span>
                            <span class="yn"><?php echo $book[0]['DestinationCity'] ?></span>
                        </div>
                        <div class="col-md-3">
                            <span>تاریخ حرکت :</span>
                            <span><?php echo $book[0]['DateMove']; ?></span>
                        </div>
                        <div class="col-md-3">
                            <span>ساعت حرکت :</span>
                            <span><?php echo $book[0]['TimeMove']; ?></span>
                        </div>
                    </div>
                    <hr style="margin: 5px 0;"/>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 text-center text-bold " style="color: #fb002a;">
                            <span>اطلاعات شرکت مسافربری</span>
                        </div>
                    </div>

                    <div class="row margin-both-vertical-20">
                        <div class="col-md-4 ">
                            <span>شرکت مسافربری: </span><span>  <?php echo $book[0]['CompanyName'] ?></span>
                        </div>
                        <div class="col-md-4 "><span
                                    class=" pull-left">نوع اتوبوس:</span><span><?php echo $book[0]['CarType'] ?></span>
                        </div>
                        <div class="col-md-4 ">
                            <span class=" pull-left">زمان برای ابطال بلیط:</span>
                            <span class="yn"><?php echo $book[0]['CancellationTime'] ?></span>
                        </div>
                    </div>


                    <div class="row modal-padding-bottom-15 margin-both-vertical-20">

                        <div class="col-md-4 ">
                            <span>مبلغ اصلی:</span>
                            <span class="yn"><?php echo number_format($book[0]['price_api']) ?></span> ریال
                        </div>
                        <div class="col-md-4 ">
                            <span>هزینه کل:</span>
                            <span class="yn"><?php echo number_format($book[0]['OriginalPrice']) ?></span> ریال
                        </div>
                        <div class="col-md-4 ">
                            <span>هزینه پرداختی :</span>
                            <span class="yn"><?php echo number_format($book[0]['total_price']) ?></span> ریال
                        </div>

                        <?php
                            $objDiscountCode = Load::controller('discountCodes');

                        if (TYPE_ADMIN == '1'){
                            $discountCodeInfo = $objDiscountCode->getDiscountCodeByFactorAndClientId($book[0]['passenger_factor_num'],$book[0]['client_id']);
                        }else{
                            $discountCodeInfo = $objDiscountCode->getDiscountCodeByFactor($book[0]['passenger_factor_num']);
                        }
                            if (!empty($discountCodeInfo) ) {
                                ?>
                                <div class="row margin-both-vertical-20">
                                    <div class="col-md-4 ">
                                        <span>کد تخفیف:</span>
                                        <span class="yn"><?php echo $discountCodeInfo['discountCode']; ?></span>
                                    </div>
                                    <div class="col-md-8 ">
                                        <span>قیمت پس از اعمال کد تخفیف</span>
                                        <span class="yn"><?php echo number_format($book[0]['total_price'] - $discountCodeInfo['amount']); ?>
											ریال</span>
                                    </div>
                                </div>
                            <?php
                        } ?>


                        <?php if ($book[0]['status'] == 'book') { ?>

                            <div class="col-md-4 ">
                                <span>پرینت:</span>
                                <span class="yn">
                                    <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusShow&id=' . $book[0]['passenger_factor_num'] ?>"
                                            target="_blank"><i class="fa fa-print"></i></a>
                                </span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="modal-footer site-bg-main-color">
                        <?php

                        if(isset($book[0]['request_cancel']) && $book[0]['request_cancel'] == 'confirm') {
                            ?>
                          <div class="col-md-12 text-left text-bold " style="color: #fb002a;">
                            <span>این بلیط کنسل شده</span></div>
                        <?php }?>
                    </div>

                </div>
            </div>

        </div>

        <?php
    }
    #endregion

    #region ModalShowBus
    public function ModalShowBus($Param)
    {
        $user = Load::controller($this->Controller);
        $records = $user->info_bus_client($Param);
        ?>

        <div class="modal-header site-bg-main-color">
            <span class="close" onclick="modalClose('')">&times;</span>
            <h6 class="modal-h"><?php echo functions::Xmlinformation("ViewPurchaseInvoiceNumber"); ?>
                :<?php echo $Param; ?> </h6>
        </div>
        <div class="modal-body">
            <?php
            foreach ($records as $key => $view) {
                if ($key < 1) {
                    ?>
                    <div class="row margin-both-vertical-20">
                        <div class="col-md-12 modal-text-center modal-h">
                            <span><?php echo functions::Xmlinformation("BusTicketSpecificationsFrom"); ?>
                                <?php echo $view['OriginName'] ?>
                                <?php echo functions::Xmlinformation("On"); ?>
                                <?php echo $view['SelectedDestName']; ?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 ">
                            <span><?php echo functions::Xmlinformation("Buydate"); ?> : </span>
                            <span dir="ltr"><?php echo $view['payment_date'] != '0000-00-00 00:00:00' ? functions::set_date_payment($view['payment_date']) : functions::Xmlinformation("Unpaid"); ?></span>
                        </div>
                        <div class="col-md-4 ">
                            <span dir="rtl"><?php echo functions::Xmlinformation("Reservationdate"); ?> : </span>
                            <span style=''><?php echo $user->set_date_reserve(substr($view['creation_date'], 0, 10)) ?></span>
                        </div>
                        <div class="col-md-4 ">
                            <span><?php echo functions::Xmlinformation("Passengercompany"); ?>: </span>
                            <span><?php echo $view['CompanyName'] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Ticketnumber"); ?> :</span>
                            <span style=''><?php echo $view['pnr'] ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Count"); ?> :</span>
                            <span style=''><?php echo $view['passenger_number'] ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("SeatNumber"); ?> :</span>
                            <span style=''><?php echo $view['passenger_chairs'] ?></span>
                        </div>
                        <div class="col-md-3 ">
                            <span><?php echo functions::Xmlinformation("Amount"); ?> :</span>
                            <span> <?php echo number_format($view['Price'] * $view['passenger_number']) ?>
                                <?php echo functions::Xmlinformation("Rial"); ?></span>
                        </div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-12 modal-text-center modal-h">
                            <span><?php echo functions::Xmlinformation("PassengerProfile"); ?></span></div>
                    </div>
                <?php } ?>

                <div class="row modal-padding-bottom-15">
                    <div class="col-md-3 ">
                        <span><?php echo functions::Xmlinformation("Namefamily"); ?> :</span>
                        <span><?php echo $view['passenger_name'] . ' ' . $view['passenger_family'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span><?php echo functions::Xmlinformation("NationalCode"); ?>: </span>
                        <span dir="rtl"><?php echo $view['passenger_national_code'] ?></span>
                    </div>
                    <div class="col-md-3 ">
                        <span> <?php echo functions::Xmlinformation("GetTicket"); ?>

                            :</span>
                        <span>
            <?php if ($view['status'] == 'book') { ?>
                <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=bookingBusApi&id=' . $view['passenger_factor_num'] ?>"
                   target="_blank"><i class="fa fa-print"></i></a>
                <?php
            } else {
                echo 'ـــــ';
            }
            ?>
                        </span>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="modal-footer site-bg-main-color">

        </div>

        <?php
    }
    #endregion

}

new ModalCreatorBus();
?>