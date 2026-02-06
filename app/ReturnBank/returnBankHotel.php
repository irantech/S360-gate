<?php

error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

require '../../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


$objBookingLocal = Load::controller('BookingHotelLocal');
$objMembers = Load::controller('members');
$objOffCode = Load::controller('interactiveOffCodes');


/* ***  variables needed to be set for display *** */
$paymentType = '';
$paymentBank = '';
$bankTrackingCode = '';
$successPayment = '';
$errorPaymentMessage = '';
$offCode = '';


$linkView = '';
$linkPDF = '';
if (CLIENT_NAME == 'آهوان') {
    $linkView = 'ehotelAhuan';
    $linkPDF = 'hotelVoucherAhuan';
} elseif (CLIENT_NAME == 'زروان مهر آریا') {
    $linkView = 'ehotelZarvan';
    $linkPDF = 'BookingHotelLocal';
} else {
    $linkView = 'ehotelLocal';
    $linkPDF = 'BookingHotelLocal';
}

?>
<!doctype html>
<html lang="fa">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/style-responsive.css">
    <title>تاتیل پیج</title>
</head>

<body>
<header class="site-bg-main-color">
    <h2>
        بازگشت از بانک
    </h2>
</header>
<?php

if (isset($_POST['flag']) && $_POST['flag'] == 'credit') {

    $paymentType = 'credit';
    if ($_POST['factorNumber'] = '') {
        $successPayment = 'true';
        $objBookingLocal->HotelBookCredit($_POST['factorNumber'], 'credit');
    } else {
        $successPayment = 'false';
        $errorPaymentMessage = 'متاسفانه پرداختی صورت نگرفته است';
    }

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'currencyPayment') {

    $paymentType = 'currency';
    $paymentBank = 'ارزی';

    if ($_POST['trackingCode'] == '') {
        $successPayment = 'true';
        $bankTrackingCode = $_POST['trackingCode'];

        $objBookingLocal->updateBank($_POST['trackingCode'], $_POST['factorNumber']);
        $objBookingLocal->HotelBook($_POST['factorNumber']);

        if ($objBookingLocal->okHotel == true) {
            /* برای تثبیت استفاده خریدار از کد تخفیف */
            $objDiscountCodes = Load::controller('discountCodes');
            $objDiscountCodes->DiscountCodesUseConfirm($_POST['factorNumber']);
        }

    } else {
        $successPayment = 'false';
        $errorPaymentMessage = 'متاسفانه پرداختی صورت نگرفته است';
        $objBookingLocal->delete_transaction_current($_POST['factorNumber']);
    }

} else {
    /* پرداخت از طریق بانکها */


    $objBank = Load::controller('bank');
    $objBank->initBankParams($_GET['bank']);
    $objBank->executeBank('return');

    if ($objBank->transactionStatus != 'failed' && $objBank->trackingCode != '') {

        if ($objBank->trackingCode == 'member_credit') {
            $paymentType = 'credit';
        } else {
            $paymentType = 'cash';
            $paymentBank = $objBank->bankTitle;
            $bankTrackingCode = $objBank->trackingCode;
        }
        $successPayment = 'true';

        $objBookingLocal->updateBank($objBank->trackingCode, $objBank->factorNumber);
        $objBookingLocal->HotelBook($objBank->factorNumber);

        if ($objBookingLocal->okHotel == true) {

            /* برای تثبیت استفاده خریدار از کد تخفیف */
            $objDiscountCodes = Load::controller('discountCodes');
            $objDiscountCodes->DiscountCodesUseConfirm($objBank->factorNumber);

            /* برای تثبیت اعتبار کسر شده در هنگام خرید مسافر آنلاین */
            $objMembers->memberCreditConfirm($objBank->factorNumber, $objBank->trackingCode);

            /* برای ثبت اعتبار تخفیف کد معرف به معرف خریدار در صورتی که اولین خرید باشد */
            if (session::IsLogin()) {
                $objMembers->addCreditToReagent();
            }

        } else {
            $successPayment = 'false';
            $errorPaymentMessage = $objBank->failMessage;

            $objBookingLocal->delete_transaction_current($objBank->factorNumber);
        }

    }

}


/* display with initialized variables */
if ($successPayment == 'true') {

    if ($objBookingLocal->okHotel == true) {
        ?>

        <div class="checkout">
            <div class="container">
                <div class="col-xs-12">
                    <div class="chekout-inner">
                        <div class="alert alert-success">
                            پرداخت شما با موفقیت انجام شد
                        </div>

                        <div class="salam">
                            <div>
                                <span><?php echo ($paymentType == 'cash') ? 'بانک عامل' : 'نوع پرداخت' ?></span>
                                <span><?php echo ($paymentBank != '') ? $paymentBank : "اعتباری" ?></span>
                            </div>
                            <div>
                                <span>شماره پیگیری</span>
                                <span><?php echo $bankTrackingCode ?></span>
                            </div>
                            <!--<div>
                                <span>تاریخ خرید</span>
                                <span><?php /*echo functions::set_date_payment($objBookingLocal->payment_date); */ ?></span>
                            </div>-->
                            <div>
                                <span>شماره فاکتور</span>
                                <span><?php echo $objBookingLocal->factor_number ?></span>
                            </div>
                        </div>
                        <?php
                        /*$offCode = $interactiveOffCodes->offCodeUse($objBookingLocal->factor_number, $objBookingLocal->hotelInfo['serviceTitle'], $objBookingLocal->hotelInfo['destination_iata']);
                        if ($offCode != '') {
                            echo "<div class='alert alert-success'>تبریک؛ شما از ما کد  {$offCode['code']} از{$offCode['title']} دریافت نمودید</div>";
                        }*/
                        ?>


                    </div>
                </div>
            </div>
        </div>


        <?php
    } else {
        ?>

        <div class="alert alert-danger">
            اشکالی در رزرو بلیط رخ داده لطفا برای برگرداندن وجه خود با شرکت تماس بگیرید
            <br>
            <?php
            if (isset($objBookingLocal->errorMessage) && $objBookingLocal->errorMessage != '') {
                echo $objBookingLocal->errorMessage;
            } elseif (isset($errorPaymentMessage) && $errorPaymentMessage != '') {
                echo $errorPaymentMessage;
            }
            ?>
        </div>
        <?php
    }

} else { ?>
    <div class="alert alert-danger">شما پرداختی نداشته ایدو از پرداخت انصراف داده اید</div>
<?php } ?>


<div class="btns">
    <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/app/' ?>"
       class="return-app site-border-main-color site-main-text-color">بازگشت به برنامه
    </a>
</div>


<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
</body>
</html>