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
error_reporting(0);
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

if (!isset($_POST['flag'])) {
    echo functions::withError(false, 400, 'flag not sent');
    exit();
}
$flag = $_POST['flag'];
unset($_POST['flag']);
switch ($flag) {
    case 'services' :
        /** @var resultTrainApi $train_sevice */
        $train_sevice = load::controller('resultTrainApi');
        $service_train = '';
        $data['UniqueId'] = $_POST['UniqueId'];
        $data['IsExclusiveCompartment'] = $_POST['IsExclusiveCompartment'];
        $data['RequestNumber'] = $_POST['RequestNumber'];

        $services = $train_sevice->getTrainService($data);

        if (empty($services)) {
            $services = array();
        }
        foreach ($services as $key => $val) {
            if ($val['Active'] == 1) {
                $service_train
                    .= '<div class="col-md-4 services-train" >
<span >' . $val['ServiceTypeName'] . '</span>
<span>' . ($val['ShowMoney'] == 0 ? 'رایگان' : number_format($val['ShowMoney']) . '  ریال ') . '</span></div>';
            }
        }
        if (empty($service_train)) {
            $service_train = '<div class="col-md-4 services-train"><p class="alert alert-warning">برای دیدن خدمات قابل ارائه در این واگن باید آن را انتخاب کنید</p></div>';
        }
        echo $service_train;
        break;
    case 'trainServices':
        /** @var resultTrainApi $train_sevice */
        $train_sevice = load::controller('trainResult');
        $service_train = '';
        $data['UniqueId'] = $_POST['UniqueId'];
        $data['IsExclusiveCompartment'] = $_POST['IsExclusiveCompartment'];
        $data['RequestNumber'] = $_POST['RequestNumber'];

        $services = $train_sevice->getTrainService($data);

        if (empty($services)) {
            $services = array();
        }
        foreach ($services as $key => $val) {
            if ($val['Active'] == 1) {
                $service_train
                    .= '<div class="col-md-4 services-train" >
<span >' . $val['ServiceTypeName'] . '</span>
<span>' . ($val['ShowMoney'] == 0 ? 'رایگان' : number_format($val['ShowMoney']) . '  ریال ') . '</span></div>';
            }
        }
        if (empty($service_train)) {
            $service_train = '<div class="col-md-4 services-train"><p class="alert alert-warning">برای دیدن خدمات قابل ارائه در این واگن باید آن را انتخاب کنید</p></div>';
        }
        echo $service_train;
        break;
    case 'revalidate_train':
        /** @var extraTrainMethod $train */
        $train = Load::controller('extraTrainMethod');
        unset($_POST['flag']);
        echo $train->saveSelectedTrain($_POST);
        break;
    case 'revalidate_train2':
        /** @var extraTrainMethod $train */
        $train = Load::controller('extraTrainMethod');
        unset($_POST['flag']);
        echo $train->insertTemporaryTrain($_POST);
        break;
    case 'CheckedLogin':
        /** @var extraTrainMethod $Local */
        $Local = Load::controller('extraTrainMethod');
        echo $Local->CheckedLogin();
        break;
   /* case 'PreReserveTrain':
        Load::autoload('apiTrain');
        $controller = new apiTrain;

        $Model = Load::library('Model');

        $sql = " SELECT  *  FROM temporary_train_tb WHERE ServiceCode ='{$_POST['uniq_id']}' ";

        $records = $Model->load($sql);
        foreach ($records as $direction => $rec) {

            $result[$direction] = $controller->PreReserveFlight($rec['token_session']);

        }

        //    print_r($result);
        if (isset($result['dept']['result_status']) && $result['dept']['result_status'] == 'PreReserve'
            && (empty($records['return'])
                || (!empty($records['return'])
                    && $result['return']['result_status'] == 'PreReserve'))) {

            $result['total_status'] = 'success';

        } elseif (isset($result['TwoWay']['result_status']) && $result['TwoWay']['result_status'] == 'PreReserve') {
            $result['total_status'] = 'success';
        } else {
            $result['total_status'] = 'error';
        }

        echo functions::toJson($result);*/

    case 'createExcelFile':
        $controller = Load::controller('bookingTrain');
        $result = $controller->createExcelFile($_POST);
        echo $result;
        break;
    case 'getRouteSelected':
        /** @var extraTrainMethod $info */
        /** @var resultTrainApi $resultTrainApi */
        /** @var temporaryTrainModel $tempModel */
        //    $Model = Load::library('Model');
        $info = Load::controller('extraTrainMethod');
        $resultTrainApi = Load::controller('resultTrainApi');
        //    $sql = " SELECT  *  FROM temporary_train_tb WHERE id ='{$_POST['id']}' ";
        $tempModel = Load::getModel('temporaryTrainModel');
        $records = $tempModel->get()->where('id', $_POST['id'])->find();
        //    $records   = $Model->load($sql);
        if ($records) {
            $info->DateJalali($records['ExitDate']);
            $idCompany = functions::getIdCompanyTrainByCode($records['Owner']);
            if (Session::IsLogin()) {
                $discountInfo = functions::getDiscountSpecialTrain('Train', $idCompany, $records['TrainNumber'], Session::getCounterTypeId(), $info->DateJalaliRequest);

                $percentDiscount = $discountInfo['percent'];
            } else {
                $percentDiscount = 0;
            }

            if($records['WagonType'] == '5103') {
                $records['Owner'] = '36';
            }


            $data[0]
                = '<div class="selectedTicket">
                    <h5 class="raft-ticket"><a onclick="undoFlightSelectTrain('
                . $records['id']
                . ')"><i class="zmdi zmdi-close site-secondary-text-color"></i></a>'
                . functions::Xmlinformation("TicketSelected")
                . '</h5>
                    <div class="international-available-box international-available-info site-main-text-color">
                        
                        <div class="international-available-item-right-Cell ">
                            <div class=" international-available-airlines  ">
                                <div class="international-available-airlines-logo">
                                   <img height="50" width="50" src="'
                . functions::getCompanyTrainPhoto($records['Owner'])
                . '" alt="'
                . $records['CompanyName']
                . '" title="'
                . $records['CompanyName']
                . '">
                               </div>
    
                                
                            </div>
    
                            <div class="international-available-airlines-info ">
                                <div class="airlines-info txtLeft">
                                    <span class="iranL txt14">'
                . $records['Departure_City']
                . '</span>
                                    <span class="iranB txt15 timeSortDep">'
                . functions::format_hour($records['ExitTime'])
                . '</span>
                                    <span class="iranL txt12">'
                . $info->DateJalaliRequest
                . '</span>
                                  
                                </div>
    
                                <div class="airlines-info">
                                        <div class="airlines-info-inner">
                                
                                            <div class="airline-line">
                                                <div class="loc-icon">
                                                    <svg version="1.1" class="site-main-text-color" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                                                   <g>
                                                                                                       <g>
                                                                                                           <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
                                                                                                               c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
                                                                                                               c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                                                                                       </g>
                                                                                                   </g>
                                                                                                   </svg>
                                                </div>
                                
                                                <div class="plane-icon busicon_zm" style="transform: rotate(0deg);">
                                
                                                    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_3" enable-background="new 0 0 64 64" viewBox="0 0 64 64">
                                                        <g>
                                                            <path d="m18 51h-10-7v2h62v-2h-5-10z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"></path>
                                                            <path d="m26 13h37v-2h-37c-2.453 0-4.489 1.779-4.91 4.113-8.318.746-15.758 5.59-19.766 13.035l-.204.378c-.079.146-.12.308-.12.474v13c0 .552.448 1 1 1h1v2h-2v2h4.184c-.112.314-.184.648-.184 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h4.369c-.113.314-.185.648-.185 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h24.369c-.113.314-.185.648-.185 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h4.369c-.113.314-.185.648-.185 1 0 1.654 1.346 3 3 3s3-1.346 3-3c0-.352-.072-.686-.184-1h2.184v-2h-58v-2h58v-2h-59-1v-2h1c1.654 0 3-1.346 3-3s-1.346-3-3-3h-1v-3.748l.084-.156c4.018-7.461 11.777-12.096 20.251-12.096h39.665v-2h-39.665c-.051 0-.101.005-.152.005.412-1.164 1.513-2.005 2.817-2.005zm-17 35c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm10 0c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm30 0c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm10 0c0 .551-.449 1-1 1s-1-.449-1-1 .449-1 1-1 1 .449 1 1zm-55-13c.551 0 1 .449 1 1s-.449 1-1 1h-1v-2z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"></path>
                                                            <path d="m24.324 19c-7.334 0-14.234 3.907-18.008 10.196l-.174.29c-.185.309-.19.694-.012 1.007s.51.507.87.507h22c.552 0 1-.448 1-1v-10c0-.552-.448-1-1-1zm3.676 10h-19.167c3.537-4.968 9.346-8 15.491-8h3.676z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"></path>
                                                            <path d="m33 19c-.552 0-1 .448-1 1v10c0 .552.448 1 1 1h10c.552 0 1-.448 1-1v-10c0-.552-.448-1-1-1zm9 10h-8v-8h8z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"></path>
                                                            <path d="m47 19c-.552 0-1 .448-1 1v10c0 .552.448 1 1 1h10c.552 0 1-.448 1-1v-10c0-.552-.448-1-1-1zm9 10h-8v-8h8z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#C4C4C4"></path>
                                                        </g>
                                                    </svg>
                                                </div>
                                
                                                <div class="loc-icon-destination">
                                                    <svg version="1.1" class="site-main-text-color" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                                                   <g>
                                                                                                       <g>
                                                                                                           <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
                                                                                                               c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
                                                                                                               c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                                                                                       </g>
                                                                                                   </g>
                                                                                                   </svg>
                                                </div>
                                
                                            </div>
                                
                                
                                        </div>
                                
                                        <span class="iranB txt11  span_train_logo">
                                             <i class="wagonname site-main-text-color"></i>
                                                                        </span>
                                </div>
    
                                <div class="airlines-info txtRight">
                                    <span class="iranL txt14">'
                . $records['Arrival_City']
                . '</span>
                                    <span class="iranB txt15">'
                . $records['TimeOfArrival']
                . '</span>
                                    <span class="iranL txt12">'
                . $info->DateJalaliRequest
                . '</span>
              
                                </div>
                            </div>
                        </div>
                        
                        <div class="international-available-item-left-Cell">
                            <div class="inner-avlbl-itm">
                                <span class="iranL  priceSortAdt">
                                    <i class="iranB site-main-text-color-drck CurrencyCal" data-amount="'
                . $records['Cost']
                . '">'
                . functions::numberFormat($records['Cost'] - $resultTrainApi->getDiscount($records['Cost'], $percentDiscount))
                . '</i> <span class="CurrencyText"> ریال </span>
                                </span>
                            </div>
                        </div>                    
                    </div>
                    <h5 class="bargasht-ticket">'
                . functions::Xmlinformation("SelectReturnTicket")
                . '</h5>
                    <input type="hidden" id="servicecodeselected" value="'
                . $records['ServiceCode']
                . '">
                    </div>';
            $data[1] = $records['ServiceCode'];

        }
        //    functions::withSuccess($data);
        echo functions::toJson($data);
        break;
    case 'undoFlightSelectTrain':
        /** @var temporaryTrainModel $temporaryTrainModel */
        $temporaryTrainModel = Load::getModel('temporaryTrainModel');
        $condition = "id='{$_POST['id']}'";
        $result = $temporaryTrainModel->delete($condition);
        if ($result) {
            echo 'ok';
        }
        break;
    case 'ChangePriorityTrain':
        $routeTrain = Load::controller('routeTrain');
        unset($_POST['flag']);
        echo $routeTrain->SetPriorityParentDeparture($_POST);
        break;
    case 'resultTrainApi':
        /** @var resultTrainApi $routeTrain */
        $routeTrain = Load::controller('resultTrainApi');
        $dataSearch = json_decode($_POST['dataSearch'], true);
        echo $routeTrain->getResultTrain($dataSearch);
        break;
    case 'getInfoTicketTrain':
        $bookingTrain = Load::controller('bookingTrain');
        echo $bookingTrain->repeatTicket($_POST['requestNumber']);
        break;
    case 'preReserveTrain':
        /** @var bookingTrain $bookingTrain */
        $bookingTrain = Load::controller('bookingTrain');
        echo $bookingTrain->changeFlagTrain($_POST);
        break;
    case 'resultTrain':
        /** @var trainResult $trainResult */
        $trainResult = Load::controller('trainResult');
        $dataSearch = json_decode($_POST['dataSearch'], true);
        echo $trainResult->getResultTrain($dataSearch);
        break;
    case 'trainPreReserve':
        /** @var trainBooking $trainBooking */
        $trainBooking = Load::controller('trainBooking');
        echo $trainBooking->changeFlagTrain($_POST);
        break;
    default :
        echo functions::withError(false, 400, 'flag not found');
}
exit();

//
//if (isset($_POST['flag']) && $_POST['flag'] == "services") {
//
//    /** @var resultTrainApi $train_sevice */
//    $train_sevice = load::controller('resultTrainApi');
//    $service_train = '';
//    $data['UniqueId'] = $_POST['UniqueId'];
//    $data['IsExclusiveCompartment'] = $_POST['IsExclusiveCompartment'];
//    $data['RequestNumber'] = $_POST['RequestNumber'];
//
//    $services = $train_sevice->getTrainService($data);
//
//    if (empty($services)) {
//        $services = array();
//    }
//    foreach ($services as $key => $val) {
//        if ($val['Active'] == 1) {
//            $service_train
//                .= '<div class="col-md-4 services-train" >
//<span >' . $val['ServiceTypeName'] . '</span>
//<span>' . ($val['ShowMoney'] == 0 ? 'رایگان' : number_format($val['ShowMoney']) . '  ریال ') . '</span></div>';
//        }
//    }
//    if (empty($service_train)) {
//        $service_train = '<div class="col-md-4 services-train"><p class="alert alert-warning">برای دیدن خدمات قابل ارائه در این واگن باید آن را انتخاب کنید</p></div>';
//    }
//    echo $service_train;
//}
//if (isset($_POST['flag']) && $_POST['flag'] == "trainServices") {
//
//    /** @var resultTrainApi $train_sevice */
//    $train_sevice = load::controller('trainResult');
//    $service_train = '';
//    $data['UniqueId'] = $_POST['UniqueId'];
//    $data['IsExclusiveCompartment'] = $_POST['IsExclusiveCompartment'];
//    $data['RequestNumber'] = $_POST['RequestNumber'];
//
//    $services = $train_sevice->getTrainService($data);
//
//    if (empty($services)) {
//        $services = array();
//    }
//    foreach ($services as $key => $val) {
//        if ($val['Active'] == 1) {
//            $service_train
//                .= '<div class="col-md-4 services-train" >
//<span >' . $val['ServiceTypeName'] . '</span>
//<span>' . ($val['ShowMoney'] == 0 ? 'رایگان' : number_format($val['ShowMoney']) . '  ریال ') . '</span></div>';
//        }
//    }
//    if (empty($service_train)) {
//        $service_train = '<div class="col-md-4 services-train"><p class="alert alert-warning">برای دیدن خدمات قابل ارائه در این واگن باید آن را انتخاب کنید</p></div>';
//    }
//    echo $service_train;
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'revalidate_train') {
//    /** @var extraTrainMethod $train */
//    $train = Load::controller('extraTrainMethod');
//    unset($_POST['flag']);
//    echo $train->saveSelectedTrain($_POST);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'revalidate_train2') {
//    /** @var extraTrainMethod $train */
//    $train = Load::controller('extraTrainMethod');
//    unset($_POST['flag']);
//    echo $train->insertTemporaryTrain($_POST);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'CheckedLogin') {
//    unset($_POST['flag']);
//    /** @var extraTrainMethod $Local */
//    $Local = Load::controller('extraTrainMethod');
//    echo $Local->CheckedLogin();
//
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'PreReserveTrain') {
//    Load::autoload('apiTrain');
//    $controller = new apiTrain;
//
//    $Model = Load::library('Model');
//
//    $sql = " SELECT  *  FROM temporary_train_tb WHERE ServiceCode ='{$_POST['uniq_id']}' ";
//
//    $records = $Model->load($sql);
//    foreach ($records as $direction => $rec) {
//
//        $result[$direction] = $controller->PreReserveFlight($rec['token_session']);
//
//    }
//
//    //    print_r($result);
//    if (isset($result['dept']['result_status']) && $result['dept']['result_status'] == 'PreReserve'
//        && (empty($records['return'])
//            || (!empty($records['return'])
//                && $result['return']['result_status'] == 'PreReserve'))) {
//
//        $result['total_status'] = 'success';
//
//    } elseif (isset($result['TwoWay']['result_status']) && $result['TwoWay']['result_status'] == 'PreReserve') {
//        $result['total_status'] = 'success';
//    } else {
//        $result['total_status'] = 'error';
//    }
//
//    echo json_encode($result);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'createExcelFile') {
//    unset($_POST['flag']);
//
//    $controller = Load::controller('bookingTrain');
//    $result = $controller->createExcelFile($_POST);
//
//    echo $result;
//
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'getRouteSelected') {
//
//    /** @var extraTrainMethod $info */
//    /** @var resultTrainApi $resultTrainApi */
//    /** @var temporaryTrainModel $tempModel */
//    //    $Model = Load::library('Model');
//    $info = Load::controller('extraTrainMethod');
//    $resultTrainApi = Load::controller('resultTrainApi');
//    //    $sql = " SELECT  *  FROM temporary_train_tb WHERE id ='{$_POST['id']}' ";
//    $tempModel = Load::getModel('temporaryTrainModel');
//    $records = $tempModel->get()->where('id', $_POST['id'])->find();
//    //    $records   = $Model->load($sql);
//    if ($records) {
//        $info->DateJalali($records['ExitDate']);
//        $idCompany = functions::getIdCompanyTrainByCode($records['Owner']);
//        if (Session::IsLogin()) {
//            $discountInfo = functions::getDiscountSpecialTrain('Train', $idCompany, $records['TrainNumber'], Session::getCounterTypeId(), $info->DateJalaliRequest);
//
//            $percentDiscount = $discountInfo['percent'];
//        } else {
//            $percentDiscount = 0;
//        }
//
//
//        $data[0]
//            = '<div class="selectedTicket">
//                <h5 class="raft-ticket"><a onclick="undoFlightSelectTrain('
//            . $records['id']
//            . ')"><i class="zmdi zmdi-close site-secondary-text-color"></i></a>'
//            . functions::Xmlinformation("TicketSelected")
//            . '</h5>
//                <div class="international-available-box international-available-info site-main-text-color">
//
//                    <div class="international-available-item-right-Cell ">
//                        <div class=" international-available-airlines  ">
//                            <div class="international-available-airlines-logo">
//                               <img height="50" width="50" src="'
//            . functions::getCompanyTrainPhoto($records['Owner'])
//            . '" alt="'
//            . $records['CompanyName']
//            . '" title="'
//            . $records['CompanyName']
//            . '">
//                           </div>
//
//
//                        </div>
//
//                        <div class="international-available-airlines-info ">
//                            <div class="airlines-info txtLeft">
//                                <span class="iranL txt14">'
//            . $records['Departure_City']
//            . '</span>
//                                <span class="iranB txt15 timeSortDep">'
//            . functions::format_hour($records['ExitTime'])
//            . '</span>
//                                <span class="iranL txt12">'
//            . $info->DateJalaliRequest
//            . '</span>
//                                <span class="iranB txt13">نوع واگن</span>
//                            </div>
//
//                            <div class="airlines-info ">
//                                <span>---------------------</span>
//                                <span>---------------------</span>
//                                <span>---------------------</span>
//                                <span>---------------------</span>
//                            </div>
//
//                            <div class="airlines-info txtRight">
//                                <span class="iranL txt14">'
//            . $records['Arrival_City']
//            . '</span>
//                                <span class="iranB txt15">'
//            . $records['TimeOfArrival']
//            . '</span>
//                                <span class="iranL txt12">'
//            . $info->DateJalaliRequest
//            . '</span>
//                                <span class="iranB txt13">'
//            . $records['WagonName']
//            . '</span>
//                            </div>
//                        </div>
//                    </div>
//
//                    <div class="international-available-item-left-Cell">
//                        <div class="inner-avlbl-itm">
//                            <span class="iranL  priceSortAdt">
//                                <i class="iranB site-main-text-color-drck CurrencyCal" data-amount="'
//            . $records['Cost']
//            . '">'
//            . functions::numberFormat($records['Cost'] - $resultTrainApi->getDiscount($records['Cost'], $percentDiscount))
//            . '</i> <span class="CurrencyText"> ریال </span>
//                            </span>
//                        </div>
//                    </div>
//                </div>
//                <h5 class="bargasht-ticket">'
//            . functions::Xmlinformation("SelectReturnTicket")
//            . '</h5>
//                <input type="hidden" id="servicecodeselected" value="'
//            . $records['ServiceCode']
//            . '">
//                </div>';
//        $data[1] = $records['ServiceCode'];
//
//    }
//    //    functions::withSuccess($data);
//    echo json_encode($data);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'undoFlightSelectTrain') {
//    $Model = Load::library('Model');
//    $Model->setTable('temporary_train_tb');
//    $condition = "id='{$_POST['id']}'";
//    $result = $Model->delete($condition);
//    if ($result) {
//        echo 'ok';
//    }
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'ChangePriorityTrain') {
//    $routeTrain = Load::controller('routeTrain');
//    unset($_POST['flag']);
//    echo $routeTrain->SetPriorityParentDeparture($_POST);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'resultTrainApi') {
//
//    /** @var resultTrainApi $routeTrain */
//    $routeTrain = Load::controller('resultTrainApi');
//    unset($_POST['flag']);
//    $dataSearch = json_decode($_POST['dataSearch'], true);
//    echo $routeTrain->getResultTrain($dataSearch);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'getInfoTicketTrain') {
//    $bookingTrain = Load::controller('bookingTrain');
//    unset($_POST['flag']);
//    echo $bookingTrain->repeatTicket($_POST['requestNumber']);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'preReserveTrain') {
//    /** @var \bookingTrain $bookingTrain */
//    $bookingTrain = Load::controller('bookingTrain');
//    unset($_POST['flag']);
////	echo Load::plog( $_POST );
//    echo $bookingTrain->changeFlagTrain($_POST);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'resultTrain') {
//
//    /** @var trainResult $trainResult */
//    $trainResult = Load::controller('trainResult');
//    unset($_POST['flag']);
//
//    $dataSearch = json_decode($_POST['dataSearch'], true);
//    echo $trainResult->getResultTrain($dataSearch);
//}
//if (isset($_POST['flag']) && $_POST['flag'] == 'trainPreReserve') {
//    unset($_POST['flag']);
//    /** @var trainBooking $trainBooking */
//    $trainBooking = Load::controller('trainBooking');
//    echo $trainBooking->changeFlagTrain($_POST);
//}