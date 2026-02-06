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


$objBook = Load::controller('BookingHotelLocal');
$objBank = Load::controller('bank');

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
    <title>در حال انتقال به بانک</title>
</head>


<body>

<div class="first-preloader">
    <div class="img-preloader">

        <h1>در حال انتقال به بانک</h1>
        <p>لطفا منتظر باشید ...</p>
        <div id="loader"></div>
    </div>

</div>

<script type="text/javascript" src="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/app/js/jquery-2.1.4.min.js"></script>

<script language="javascript" type="text/javascript">
    function sendForm(link, inputs) {
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", link);

        var decodedInputs = $.parseJSON(inputs);
        $.each(decodedInputs, function (i, item) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("name", i);
            hiddenField.setAttribute("value", item);
            form.appendChild(hiddenField);
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>

<?php

$objBank->initBankParams($_POST['bankType']);
$objBank->calculateAmount('hotelApp', $_POST['factorNumber']);
$objBank->executeBank('go');

if ($objBank->failMessage == ''){
    $objBook->sendUserToBankForHotel($_POST['factorNumber']);
} else {
    ?>
    <div class="txtCenter txtRed txt17"> خطا: <?php echo $objBank->failMessage; ?> </div>
    <?php
}
?>


</body>

</html>