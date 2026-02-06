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


$ParvazBookingLocal = Load::controller('parvazBookingLocal');
$members = Load::controller('members');
$interactiveOffCodes = Load::controller('interactiveOffCodes');
$discountCodes = Load::controller('discountCodes');
$bank = Load::controller('bank');

$paymentType = '';
$paymentBank = '';
$bankTrackingCode = '';
$successPayment = '';
$errorPaymentMessage = '';
$offCode = '';


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
if ($_POST['flag'] == 'credit'){

    $paymentType = 'credit';

    if ($_POST['factorNumber'] = '') {
        $successPayment = 'true';
        $ParvazBookingLocal->flightBook($_POST['factorNumber'], 'credit');
    } else {
        $successPayment = 'false';
        {
            $errorPaymentMessage = 'متاسفانه پرداختی صورت نگرفته است';
        }
    }

} elseif ($_POST['flag'] == 'currencyPayment') {

    $paymentType = 'currency';
    $paymentBank = 'ارزی';

    if ($_POST['trackingCode'] == '') {
        $successPayment = 'true';
        $bankTrackingCode = $_POST['trackingCode'];

        $ParvazBookingLocal->updateBank($_POST['trackingCode'], $_POST['factorNumber']);
        $ParvazBookingLocal->flightBook($_POST['factorNumber']);

        if ($ParvazBookingLocal->ok_flight['dept'] == true || $objBookingLocal->ok_flight['TwoWay'] == true) {

            $discountCodes->DiscountCodesUseConfirm($_POST['factorNumber']);

        }

    } else {
        $successPayment = 'false';
        $errorPaymentMessage = 'متاسفانه پرداختی صورت نگرفته است';

        $ParvazBookingLocal->delete_transaction_current($_POST['factorNumber']);
    }
}else {
    $bank->initBankParams($_GET['bank']);
    $bank->executeBank('return');

    if ($bank->transactionStatus != 'failed' && $bank->trackingCode != '') {

        if ($bank->trackingCode == 'member_credit') {
            $paymentType = 'credit';
        } else {
            $paymentType = 'cash';
            $paymentBank = $bank->bankTitle;
            $bankTrackingCode = $bank->trackingCode;
        }
        $successPayment = 'true';

        $ParvazBookingLocal->updateBank($bank->trackingCode, $bank->factorNumber);
        $ParvazBookingLocal->flightBook($bank->factorNumber);

        if ($ParvazBookingLocal->ok_flight['dept'] == true || $ParvazBookingLocal->ok_flight['TwoWay'] == true) {

            $discountCodes->DiscountCodesUseConfirm($bank->factorNumber);

            $members->memberCreditConfirm($bank->factorNumber, $bank->trackingCode);

            if (session::IsLogin()) {
                $members->addCreditToReagent();
            }

        } else {
            $successPayment = 'false';
            $errorPaymentMessage = $objBank->failMessage;

            $ParvazBookingLocal->delete_transaction_current($objBank->factorNumber);
        }

    }

}
if ($successPayment == 'true') {
    if ($ParvazBookingLocal->ok_flight['dept'] == true || $ParvazBookingLocal->ok_flight['TwoWay'] == true) {
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
                                <span>   <?php echo ($paymentType == 'cash') ? 'بانک عامل' : 'نوع پرداخت' ?></span>
                                <span><?php echo ($paymentBank != '') ? $paymentBank : "اعتباری" ?></span>
                            </div>
                            <div>
                                <span>شماره پیگیری</span>
                                <span><?php echo $bankTrackingCode ?></span>
                            </div>
                            <div>
                                <span>تاریخ خرید</span>
                                <span><?php echo functions::set_date_payment($ParvazBookingLocal->payment_date) ?></span>
                            </div>
                            <div>
                                <span>شماره فاکتور</span>
                                <span><?php echo $ParvazBookingLocal->factor_num ?></span>
                            </div>
                        </div>
                    <?php
                            $offCode = $interactiveOffCodes->offCodeUse($ParvazBookingLocal->factor_num, $ParvazBookingLocal->ticketInfo[$direction]['serviceTitle'], $ParvazBookingLocal->ticketInfo[$direction]['desti_airport_iata'], $ParvazBookingLocal->ticketInfo[$direction]['origin_airport_iata']);
                            if ($offCode != '') {
                                echo "<div class='alert alert-success'>تبریک؛ شما از ما کد  {$offCode['code']} از{$offCode['title']} دریافت نمودید</div>";
                            }
                    ?>
                       <?php foreach ($ParvazBookingLocal->direction as $direction) { ?>
                        <div>
                            <span>نوع پرواز:</span>
                            <span> <?php if ($direction == 'TwoWay') {
                                    echo ' دو طرفه خارجی';
                                } elseif ($direction == 'dept') {
                                    echo '  رفت';
                                } elseif ($direction == 'return') {
                                    echo ' برگشت';
                                }
                                ?></span>
                        </div>


                        <?php if ($ParvazBookingLocal->ok_flight[$direction] == true) { ?>

                            <div class="btns">
                                <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pdf&target=parvazBookingLocal&id=' . $ParvazBookingLocal->request_number[$direction] ?>"
                                   class="btns-download site-bg-main-color" target="_blank">
                                    دانلود PDF بلیط
                                </a>
                                <a href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/app/' ?>"
                                   class="return-app site-border-main-color site-main-text-color">بازگشت به
                                    برنامه</a>
                            </div>

                            <!--                                {* نمایش کد ترانسفر پس از خرید موفق *}                      -->
                            <?php 


                        } else { ?>

                            <div class="alert alert-danger">
                                متاسفانه رزرو این پرواز با مشکل مواجه شده است، لطفا برای برگرداندن
                               <span> <?php ($paymentType == 'credit') ? 'اعتبار' : 'وجه'; ?></span>
                                خود با
                                شرکت تماس بگیرید
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <div class="btns">

                        <a href="<?php echo 'safar360://callback/1' ?>"
                           class="return-app site-border-main-color site-main-text-color">بازگشت به
                            برنامه</a>
                    </div>
                </div>
            </div>
        </div>


        <?php
    } else {
        ?>

        <div class="alert alert-danger">

            اشکالی در رزرو بلیط رخ داده لطفا برای برگرداندن وجه خود با شرکت تماس بگیرید

        </div>

        <div class="btns">

            <a href="<?php echo 'safar360://callback/0' ?>"
               class="return-app site-border-main-color site-main-text-color">بازگشت به
                برنامه</a>
        </div>

        <?php
    }

} else { ?>
    <div class="alert alert-danger">
        شما پرداختی نداشته ایدو از پرداخت انصراف داده اید
		
    </div>

    <div class="btns">

        <a href="<?php echo 'safar360://callback/0' ?>"
           class="return-app site-border-main-color site-main-text-color">بازگشت به
            برنامه</a>
    </div>
<?php } ?>


<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>


</body>

</html>