<?php
$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;
foreach ($_POST as $key=>$item) {
    $item_after_replace[$key] = str_replace($array_special_char, '', $item);

    $_POST[$key] = $item_after_replace[$key];
}

require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));


if (isset($_POST['flag'])) {

    $flag = $_POST['flag'];
    unset($_POST['flag']);

    switch ($flag) {
        case 'getResultBusSearch':

	        /** @var resultBusTicket $objBus */
            $objBus = Load::controller('resultBusTicket');
	        $result = $objBus->getBuses($_POST);
            break;
        case 'selectDest':
            $Bus = load::controller('resultBusTicket');
            $destinations = $Bus->getDestinationCities($_POST['cityOrigin']);
            $result = '<option value="">'. functions::Xmlinformation('ChoseOption').'</option>';
            foreach ($destinations as $dest) {
                $result .= '<option value="' . $dest['DestinationsIataCode'] . '">' . $dest['DestinationsCityNamePersian'] . '</option>';
            }
            break;
        case 'flagSetTemporaryBus':
            $Bus = load::controller('resultBusTicket');
            $result = $Bus->setTemporaryBus($_POST);
            break;
        case 'busTicketPreReserve':
            $Bus = load::controller('resultBusTicket');
            $result = $Bus->setBusTicketPreReserve($_POST['factorNumber'], $_POST['availablePaymentMethods']);
            break;
        case 'createExcelFile':
            $controller = Load::controller('bookingBusShow');
            $result = $controller->createExcelFile($_POST);
            break;
        case 'selectDestForAdminPanel':
            $Bus = load::controller('resultBusTicket');
            $destinations = $Bus->getDestinationCities($_POST['cityOrigin']);
            $result = '<option value="">'. functions::Xmlinformation('ChoseOption').'</option>';
            $result .= '<option value="all">همه شهرها</option>';
            foreach ($destinations as $dest) {
                $result .= '<option value="' . $dest['DestinationsIataCode'] . '">' . $dest['DestinationsCityNamePersian'] . '</option>';
            }
            break;
        case 'insertBusTicketPriceChanges':
            $Bus = load::controller('busTicketPriceChanges');
            $result = $Bus->setBusTicketPriceChanges($_POST);
            break;
        case 'deleteBusTicketPriceChanges':
            $Bus = load::controller('busTicketPriceChanges');
            $result = $Bus->deleteBusTicketPriceChanges($_POST['id']);
            break;
        case 'flagCheckInquireBusTicket':
            $Bus = load::controller('resultBusTicket');
            $result = $Bus->checkInquireBusTicket($_POST['factorNumber']);
            break;
        case 'flagInsertBaseCompanyBus':
            $Bus = load::controller('busPanel');
            $result = $Bus->insertBaseCompanyBus($_POST);
            break;
        case 'flagUpdateBaseCompanyBus':
            $Bus = load::controller('busPanel');
            $result = $Bus->updateBaseCompanyBus($_POST);
            break;
        case 'flagInsertBusCompany':
            $Bus = load::controller('busPanel');
            $result = $Bus->insertBusCompany($_POST);
            break;
        case 'flagUpdateBusCompany':
            $Bus = load::controller('busPanel');
            $result = $Bus->updateBusCompany($_POST);
            break;
        case 'flagLogicalDeletion':
            $Bus = load::controller('busPanel');
            $result = $Bus->logicalDeletion($_POST);
            break;
        case 'select2BusRouteSearch':
            $Bus = Load::controller('busPanel');
            $result = $Bus->select2BusRouteSearch($_POST);
            break;
        default:
            $result = 'not fund ' . $flag;
            break;
    }


    echo $result;

} else {
    echo 'not fund flag';
}

?>