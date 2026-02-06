<?php


require '../../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require LIBRARY_DIR . 'Session.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';

$bankList = functions::InfoBank();


?>
<!doctype html>
<html lang="fa">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo ROOT_ADDRESS_WITHOUT_LANG?>/app/css/framework7.rtl.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_ADDRESS_WITHOUT_LANG?>/app/css/awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_ADDRESS_WITHOUT_LANG?>/app/css/booking/booking.css">
    <link rel="stylesheet" href="<?php echo ROOT_ADDRESS_WITHOUT_LANG?>/app/css/icons.css">
    <link rel="stylesheet" href="<?php echo ROOT_ADDRESS_WITHOUT_LANG?>/app/css/app.css">
    <link rel="stylesheet" href="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/library/StyleSheet.php'; ?>">
    <title>تاتیل پیج</title>
</head>

<body>
<header class="site-bg-main-color">
    <h2>
        بازگشت از بانک
    </h2>
</header>
<div class="page">

    <?php
    $nameApplication = !empty($_GET['nameApplication']) ? $_GET['nameApplication'] : '';
    if ($nameApplication == 'flight'){

//        $RequestNumber = json_decode($_GET['RequestNumber'], true);
//        $ServiceType = json_decode($_GET['ServiceType'], true);

        $RequestNumberDept = (isset($_GET['requestNumberDept']) && $_GET['requestNumberDept'] != '') ? $_GET['requestNumberDept']:'';
        $RequestNumberReturn = (isset($_GET['requestNumberReturn']) && $_GET['requestNumberReturn'] != '') ? $_GET['requestNumberReturn'] : '';
        $RequestNumberTwoWay = (isset($_GET['requestNumberTwoWay']) && $_GET['requestNumberTwoWay'] != '') ? $_GET['requestNumberTwoWay'] : '';
        $ServiceTypeDept = (isset($_GET['serviceTitleDept']) && $_GET['serviceTitleDept'] != '') ? $_GET['serviceTitleDept'] : '';
        $ServiceTypeReturn = (isset($_GET['serviceTitleReturn']) && $_GET['serviceTitleReturn'] != '') ? $_GET['serviceTitleReturn'] : '';
        $ServiceTypeTwoWay = (isset($_GET['serviceTitleTwoWay']) && $_GET['serviceTitleTwoWay'] != '') ? $_GET['serviceTitleTwoWay'] : '';

        $RequestNumber= array();
        if(!empty($RequestNumberDept) && !empty($RequestNumberReturn))
        {
            $RequestNumber['dept'] = $RequestNumberDept;
            $RequestNumber['return'] = $RequestNumberReturn;
        }else if(!empty($RequestNumberDept) && empty($RequestNumberReturn)){
            $RequestNumber['dept'] = $RequestNumberDept;
        }else if(!empty($RequestNumberTwoWay)){
            $RequestNumber['TwoWay'] = $RequestNumberTwoWay;
        }


        $BankInputArray = array(
            'flag' => $_GET['flag'],
            'factorNumber' => $_GET['factorNumber'],
            'RequestNumber' => $RequestNumber,
            'RequestNumberDept' => $RequestNumberDept,
            'RequestNumberReturn' => $RequestNumberReturn,
            'RequestNumberTwoWay' => $RequestNumberTwoWay,
            'ServiceTypeDept' => $ServiceTypeDept,
            'ServiceTypeReturn' => $ServiceTypeReturn,
            'ServiceTypeTwoWay' => $ServiceTypeTwoWay
        );
        $bankInputs = functions::clearJsonHiddenCharacters(json_encode($BankInputArray));

        $bankAction = ROOT_ADDRESS_WITHOUT_LANG . '/app/ReturnBank/goBank' . ucfirst($nameApplication) . '.php';

    } elseif ($nameApplication == 'hotel') {

        $BankInputArray = array(
            'flag' => $_GET['flag'],
            'factorNumber' => $_GET['factorNumber'],
            'typeApplication' => $_GET['typeApplication'],
            'typeTrip' => isset($_GET['typeTrip']) ? $_GET['typeTrip'] : '',
            'serviceType' => $_GET['serviceType']
        );
        //echo Load::plog($BankInputArray);
        $bankInputs = functions::clearJsonHiddenCharacters(json_encode($BankInputArray));

        $bankAction = ROOT_ADDRESS_WITHOUT_LANG . '/app/ReturnBank/goBank' . ucfirst($nameApplication) . '.php';
    }

    ?>

    <div class="page-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">انتخاب روش پرداخت</div>
            </div>
        </div>
        <div class="blit-info-page">


            <div class="choose-bank">
                <div class="select-pay-method">
                    <span>انتخاب روش پرداخت</span>
                    <div class="list media-list">
                        <ul>
                            <li>
                                <label class="item-radio item-content">
                                    <input class="pay-method-checkbox" type="radio" name="pay-method" value="online"
                                           checked/>
                                    <i class="icon icon-radio"></i>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title">پرداخت آنلاین</div>
                                        </div>
                                    </div>
                                </label>
                            </li>
                            <!--<li>
                                 <label class="item-radio item-content">
                                     <input class="pay-method-checkbox" type="radio" name="pay-method" value="credit"/>
                                     <i class="icon icon-radio" checked></i>
                                     <div class="item-inner">
                                         <div class="item-title-row">
                                             <div class="item-title etebar-title">پرداخت از اعتبار حساب</div>
                                             <div class="etebar-hesab">
                                                 <span>اعتبار حساب</span>
                                                 <span>2,600,000 ریال</span>
                                             </div>
                                         </div>
                                     </div>
                                 </label>
                             </li>-->
                        </ul>
                    </div>

                </div>
                <div class="banks-method">
                    <span>لطفا درگاه پرداخت را انتخاب کنید</span>
                    <div class="list media-list">
                        <ul>
                            <?php foreach ($bankList as $key => $bank) { ?>
                                <li>
                                    <label class="item-radio item-content">
                                        <input type="radio" name="bank" id="<?php echo $bank['bank_dir'] ?>"
                                               value="<?php echo $bank['bank_dir'] ?>" class="BankRadioButton">
                                        <i class="icon icon-radio" checked></i>
                                        <div class="item-media">
                                            <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/app/bank/bank' . $bank['title_en'] . '.png' ?>"
                                                 alt="<?php echo $bank['title'] ?>">
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title-row">
                                                <div class="item-title">پرداخت از درگاه
                                                    بانک <?php echo $bank['title'] ?></div>
                                            </div>
                                        </div>
                                    </label>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>


            <input type="hidden" value="" name="ChooseBank" id="ChooseBank">
            <div class="bottom-btn">
                <a href="#" class="bot-btn site-bg-main-color online-pay" onclick="goBankForApp(this);" bankInputs='<?php echo $bankInputs; ?>' bankAction='<?php echo $bankAction; ?>'>
                    <span>پرداخت آنلاین</span>
                    <i class="preloader color-white myhidden"></i>
                </a>
                <!--<a href="#" class="bot-btn etebari-pay myhidden">پرداخت اعتباری</a>-->
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="<?php echo ROOT_ADDRESS_WITHOUT_LANG?>/app/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_ADDRESS_WITHOUT_LANG?>/app/js/externalPageJs.js"></script>


</body>

</html>
