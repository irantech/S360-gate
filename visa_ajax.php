<?php
//$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;
//
//$except_char = ['descriptions' , 'documents' , 'title' , 'validityDuration' ,'allowedUseNo'];
//
//foreach ($_POST as $key=>$item) {
//    if(!in_array($key , $except_char)){
//
//        $item_after_replace[$key] = str_replace($array_special_char, '', $item);
//
//        $_POST[$key] = $item_after_replace[$key];
//    }
//
//}


require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

if (isset($_POST['flag']) && $_POST['flag'] == 'continentActivate') {
    unset($_POST['flag']);

    $controller = Load::controller('country');
    $result = $controller->continentActivate($_POST['id']);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'countryActivate') {
    unset($_POST['flag']);

    $controller = Load::controller('country');
    $result = $controller->countryActivate($_POST['id']);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaTypeAdd') {
    unset($_POST['flag']);

    $controller = Load::controller('visaType');
    $result = $controller->visaTypeAdd($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaTypeEdit') {
    unset($_POST['flag']);

    $controller = Load::controller('visaType');
    $result = $controller->visaTypeEdit($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaActivate') {
    unset($_POST['flag']);

    $controller = Load::controller('visa');
    $result = $controller->visaActivate($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaValidate') {
    unset($_POST['flag']);

    $controller = Load::controller('visa');
    $result = $controller->visaValidate($_POST);

    echo json_encode($result);
}elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaOptions') {
    unset($_POST['flag']);

    $controller = Load::controller('visa');
    $result = $controller->visaOptionChangeStatus($_POST);

    echo json_encode($result);
}elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaAdminReviewChange') {
    unset($_POST['flag']);

    $controller = Load::controller('visa');
    $result = $controller->visaAdminReviewChange($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'initAllCountries') {
    unset($_POST['flag']);

    $Controller = Load::controller('country');
    $result = $Controller->reservationCountriesByContinentID($_POST['continentID']);


    foreach ($result as $each){
        if(isset($_POST['correctCountry'])){
            echo '<option '.($_POST['correctCountry']=== $each['abbreviation']?' selected ':'').' value="' . $each['abbreviation'] . '">' . $each['name'] . '</option>';
        }else{
            echo '<option value="' . $each['abbreviation'] . '">' . $each['name'] . '</option>';
        }
    }
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'initCountries') {
    unset($_POST['flag']);
    /**@var resultReservationVisa $resultVisaController*/

    $resultVisaController = Load::controller('resultReservationVisa');
    $result = $resultVisaController->countriesHaveVisa($_POST['continentID']);



    foreach ($result as $each){
        echo '<option value="' . $each['abbreviation'] . '">' . $each['name'] . '</option>';
    }
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'initTypes') {
    unset($_POST['flag']);
    /**@var resultReservationVisa $resultVisaController*/

    $resultVisaController = Load::controller('resultReservationVisa');
    $result = $resultVisaController->allCountryVisaTypes($_POST['countryID']);



    foreach ($result as $each){
        echo '<option value="' . $each['id'] . '">' . $each['title'] . '</option>';
    }
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaAdd') {
    unset($_POST['flag']);


    /**@var $controller visa */
    $controller = Load::controller('visa');

    $result = $controller->visaAdd($_POST);

    echo json_encode($result);
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaEdit') {
    unset($_POST['flag']);
    /** @var visa $controller */
    $controller = Load::controller('visa');
    $result = $controller->visaEdit($_POST);

    echo json_encode($result);
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'update_custom_file_field') {
    unset($_POST['flag']);

    /** @var visa $controller */
    $controller = Load::controller('visa');
    $result = $controller->updateCustomFileField($_POST);

    echo json_encode($result);
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'update_visa_files') {
    unset($_POST['flag']);

    /** @var visa $controller */
    $controller = Load::controller('visa');
    $result = $controller->updateVisaFiles($_POST);

    echo json_encode($result);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'checkUserLogin') {
    unset($_POST['flag']);

    $resultLogin = Session::IsLogin();
    $resultTypeLogin = Session::getTypeUser();

    if ($resultLogin && $resultTypeLogin == 'counter') {
        $return['result_status'] = 'success';
    } else{
        $return['result_status'] = 'error';
    }

    echo json_encode($return);
}

elseif (isset($_POST['flag']) && $_POST['flag'] == 'visaPreReserve') {
    unset($_POST['flag']);

    $factorNumber = filter_var($_POST['factorNumber'], FILTER_SANITIZE_NUMBER_INT);
    $Model = Load::library('Model');
    $ModelBase = Load::library('ModelBase');

    $data['status'] = 'prereserve';

    $Condition = " factor_number = '{$factorNumber}' ";
    $Model->setTable("book_visa_tb");
    $res[] = $Model->update($data, $Condition);

    $ModelBase->setTable("report_visa_tb");
    $res[] = $ModelBase->update($data, $Condition);

    if (in_array('0', $res)){

        $return['result_status'] = 'error';
        $return['result_message'] = functions::Xmlinformation('ErrorUnknownBuyHotel');

    } else {
        $return['result_status'] = 'success';
    }

    echo json_encode($return);
}

if (isset($_POST['flag']) && $_POST['flag'] == 'SendVisaEmailForOther') {
    $members = Load::controller('members');
    unset($_POST['flag']);
    echo $members->SendVisaEmailForOther($_POST['email'], $_POST['request_number']);
}



if (isset($_POST['flag']) && $_POST['flag'] == 'createExcelFile') {
    unset($_POST['flag']);

    $controller = Load::controller('bookingVisa');
    $result = $controller->createExcelFile($_POST);

    echo $result;
}

if (isset($_POST['flag']) && $_POST['flag'] == 'deleteVisaStatus') {
    unset($_POST['flag']);

    $controller = Load::controller('visa');
    $result = $controller->deleteVisaStatus($_POST);

    echo $result;
}if (isset($_POST['flag']) && $_POST['flag'] == 'visaDetailData') {
    unset($_POST['flag']);

    $controller = Load::controller('visa');
    $result = $controller->visaDetailData($_POST);

    echo $result;
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'changeVisaTypeMoreDetail') {
    unset($_POST['flag']);

    $controller = Load::controller('visa');
    $result = $controller->changeVisaTypeMoreDetail($_POST);

    echo $result;
}


if (isset($_POST['flag']) && $_POST['flag'] == 'registerPassengersFileVisa') {
    unset($_POST['flag']);


    $Model = Load::library('Model');
    $ModelBase = Load::library('ModelBase');

    if (isset($_FILES['passengersFile']) && $_FILES['passengersFile'] != "") {

        $config = Load::Config('application');
        $config->pathFile('reservationVisa/passengersImages/');

        $resultUpload = $config->uploadFiles("", "passengersFile", "");
        $dataPic = array();
        foreach ($resultUpload as $k=>$pic) {
            if ($pic['message'] == 'done') {
                $dataPic[] = $pic['fileName'];
            }
        }
        if (!empty($dataPic)){
            $data['passengers_file'] = json_encode($dataPic);

            $Condition = " factor_number ='{$_POST['factorNumber']}' ";
            $Model->setTable("book_visa_tb");
            $res2[] = $Model->update($data, $Condition);

            $ModelBase->setTable("report_visa_tb");
            $res2[] = $ModelBase->update($data, $Condition);
            if (in_array('0', $res2)) {
                echo 'error:'.functions::Xmlinformation('RequestWasNotRegistered');
            } else {

                echo 'success:'.functions::Xmlinformation('ApplicationSuccessfullyRegistered');
            }

        } else {
            echo 'error:'.functions::Xmlinformation('RequestWasNotRegistered');
        }


    } else {
        echo 'error:'.functions::Xmlinformation('RequestWasNotRegistered');
    }

}