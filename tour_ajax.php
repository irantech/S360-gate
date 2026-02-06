<?php
//error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//     @ini_set('display_errors', 1);
//     @ini_set('display_errors', 'on');
$array_special_char = ["\n", "‘", "’", "“", "”", "„" , "(", ")", "<", ">","</","/>","alert","+","from","sleep"] ;
$except_char = ['description' , 'requiredDocuments' , 'rules' , 'cancellationRules'];

foreach ($_POST as $key=>$item) {
  if(!in_array($key , $except_char)){

      $item_after_replace[$key] = str_replace($array_special_char, '', $item);

      $_POST[$key] = $item_after_replace[$key];
  }

}
require 'config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require CONFIG_DIR . 'configBase.php';
require LIBRARY_DIR . 'functions.php';
require CONTROLLERS_DIR . 'dateTimeSetting.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

//Session::init();
if (isset($_POST['flag']) && $_POST['flag'] == 'insertRowPackage') {
    unset($_POST['flag']);

    Load::autoload('Model');
    $Model = new Model();
    $objCurrency = Load::controller('currencyEquivalent');

    $fk_tour_id = filter_var($_POST['fk_tour_id'], FILTER_VALIDATE_INT);
    $id_same = filter_var($_POST['id_same'], FILTER_VALIDATE_INT);
    $rowAnyPackage = filter_var($_POST['countPackage'], FILTER_VALIDATE_INT);

    /*switch ($rowAnyPackage) {
        case '1':
            $textNumber = functions::Xmlinformation('First');
            break;
        case '2':
            $textNumber =  functions::Xmlinformation('Second');
            break;
        case '3':
            $textNumber = functions::Xmlinformation('Third');
            break;
        case '4':
            $textNumber =  functions::Xmlinformation('Fourth');
            break;
        case '5':
            $textNumber =  functions::Xmlinformation('Fifth');
            break;
        case '6':
            $textNumber =  functions::Xmlinformation('Sixth');
            break;
        case '7':
            $textNumber =  functions::Xmlinformation('Seventh');
            break;
        case '8':
            $textNumber =  functions::Xmlinformation('Eighth');
            break;
        case '9':
            $textNumber =  functions::Xmlinformation('ninth');
            break;
        default:
            $textNumber = '';
            break;
    }*/

    $sqlTourId = " SELECT 
                  id
              FROM
                  reservation_tour_tb
              WHERE
                  id_same = '{$id_same}'
              ";
    $resultTourId = $Model->load($sqlTourId);

    $sql = " SELECT 
                  TR.destination_city_id as cityId, TR.destination_city_name as cityName
              FROM
                  reservation_tour_tb AS T
                  LEFT JOIN reservation_tour_rout_tb AS TR ON T.id=TR.fk_tour_id
              WHERE
                  TR.fk_tour_id = '{$resultTourId['id']}' AND TR.night >= 1 AND TR.tour_title = 'dept' 
              ";

//
//    if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//      echo $sql;
//      die;
//    }

    $resultCity = $Model->select($sql);

    if (!empty($resultCity)) {


        $result = '';
        $result .= '';


        $result .= '<div id="rowAnyPackage' . $rowAnyPackage . '" class="bg-light-blue overflow-hidden rounded rowAnyRout package-box">';


            $result .= '
                        <div class="d-flex divDeleteRow justify-content-center rout-number">
                            <div class="align-items-center d-flex flex-wrap justify-content-between px-2 rout-number-50 w-100 mr-3">
                                <span style="flex-grow: 1; text-align: right;" class="font-weight-bold">' . functions::Xmlinformation('Package') .' '. $rowAnyPackage . '</span>

                                <button onclick="deleteRowPackage(\'' . $rowAnyPackage . '\')" class="btn btn-danger btn-sm font-12 p-1 px-2">
                                <span class="deleteRow fa fa-trash"></span>
                                    ' . functions::Xmlinformation('Delete') .'
                                </button>
                                <button data-toggle="modal" data-target="#ModalPublicContent" type="button" onclick="modalAddRoom(\'' . $rowAnyPackage . '\')" class="btn btn-primary btn-sm font-12 p-1 px-2">
                                <span class="addRoom fa fa-plus"></span>
                                    ' . functions::Xmlinformation('AddRoomPackage') .'
                                </button>

                            </div>
                        </div>
                        
                        
                        ';


        foreach ($resultCity as $k => $city) {


            $sqlHotel = "SELECT id, name FROM reservation_hotel_tb WHERE city='{$city['cityId']}' AND is_del = 'no'";
            $hotels = $Model->select($sqlHotel);

            $result .= '<div class="each-package-hotel">';
            $result .= '<input type="hidden" 
                                data-name="cityId" 
                                data-values="name,id"
                                class="change_counter_js"
                                value="' . $city['cityId'] . '" name="cityId' . $rowAnyPackage . $k . '" id="cityId' . $rowAnyPackage . $k . '">';
            $result .= '<input type="hidden"
                                data-name="cityName" 
                                data-values="name,id"
                                class="change_counter_js"  value="' . $city['cityName'] . '" name="cityName' . $rowAnyPackage . $k . '" id="cityName' . $rowAnyPackage . $k . '">';
            $result .= '<div class="d-flex flex-wrap gap-10 p-3 w-100">';
            $result .= '<div class="bg-white rounded row-tour-hotel w-100">
                     
                            
                            
                            <div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                                <span class="tour-price-r"> ' . functions::Xmlinformation('Selecthotelforcity') .' '. $city['cityName'] . '</span>
                            </div>
                            
                            <div class="p-2 py-4 tour-hotel w-100">
                                <div class="box-hotel d-flex flex-wrap w-100">
                                    <div class="col-md-4 no-star">
                                        <label for="hotelId' . $rowAnyPackage . $k . '"
                                               data-name="hotelId" 
                                               data-values="for"
                                               class="flr font-12 text-muted change_counter_js">'. functions::Xmlinformation('Selectionhotel').'</label>
                                        <select name="hotelId' . $rowAnyPackage . $k . '"
                                               data-name="hotelId" 
                                               data-values="name,id"
                                                id="hotelId' . $rowAnyPackage . $k . '" class="select2 change_counter_js" onchange="getRoomsHotel(this)">
                                            <option value="">'. functions::Xmlinformation('ChoseOption').'</option>
                                            ';
                                          foreach ($hotels as $hotel) {
                                              $result .= '<option value="' . $hotel['id'] . '">' . $hotel['name'] . '</option>';
                                          }
                                          $result .= '
                                        </select>
                                    </div>
                                    <div class="col-md-4 no-star">
                                        <label for="roomService' . $rowAnyPackage . $k . '"
                                               data-name="roomService" 
                                               data-values="for"
                                               class="flr font-12 text-muted change_counter_js">'. functions::Xmlinformation('Selectserviceroom').':</label>
                                        <select name="roomService' . $rowAnyPackage . $k . '"
                                               data-name="roomService" 
                                               data-values="name,id" id="roomService' . $rowAnyPackage . $k . '" class="select2 change_counter_js">
                                            <option value="" disabled="disabled" selected="">'. functions::Xmlinformation('ChoseOption').'</option>
                                            <option value="BB">BB</option>
                                            <option value="HB">HB</option>
                                            <option value="FB">FB</option>
                                            <option value="All">All</option>
                                            <option value="UAll">UAll</option>
                                            <option value="Exclusive">Exclusive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 no-star">
                                        <label for="roomType' . $rowAnyPackage . $k . '"
                                               data-name="roomType" 
                                               data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Selecttyperoom').':</label>
                                        <select name="roomType' . $rowAnyPackage . $k . '"
                                               data-name="roomType" 
                                               data-values="name,id" id="roomType' . $rowAnyPackage . $k . '" class="select2 change_counter_js hotel_rooms_selected">
                                            <option value=""  selected="">'. functions::Xmlinformation('ChoseOption').'</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            </div>  
                           ';
        }
        $result .= '<input type="hidden"
                                data-name="countHotel" 
                                data-values="name,id"
                                class="change_counter_js" value="' . $k . '" name="countHotel' . $rowAnyPackage . '" id="countHotel' . $rowAnyPackage . '">';


        $result .= '<div class="bg-white rounded row-tour-hotel w-100">';
        if(functions::isEnableSetting('eachPerson')) {
            $result .= '<p class="py-1 mt-1 text-dark bg-warning">'.functions::Xmlinformation('enterPricePerPerson').'</p>';
        } else {
            $result .= '<p class="py-1 mt-1 text-dark bg-warning">'.functions::Xmlinformation('enterPricePerRoom').'</p>';
        }

        $result .= '<div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                        <span class="tour-price-r">'.functions::Xmlinformation('PriceRial').' </span>
                    </div>';
        $result .= '<div class="d-flex flex-wrap p-2 py-4 tour-hotel w-100">';

        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="threeRoomPriceR' . $rowAnyPackage . '"
                                data-name="threeRoomPriceR" 
                                data-values="for"
                                class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomthreebed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="threeRoomPriceR' . $rowAnyPackage . '"
                                data-name="threeRoomPriceR" 
                                data-values="name,id"
                                 class="form-control font-12 change_counter_js" id="threeRoomPriceR' . $rowAnyPackage . '" 
                        onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('PriceRial').'">
                    </div>';

        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="doubleRoomPriceR' . $rowAnyPackage . '"
                                data-name="doubleRoomPriceR" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomtwobed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="doubleRoomPriceR' . $rowAnyPackage . '"
                                data-name="doubleRoomPriceR" 
                                data-values="name,id" class="form-control change_counter_js font-12" id="doubleRoomPriceR' . $rowAnyPackage . '" 
                        onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('PriceRial').'">
                    </div>';

        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="singleRoomPriceR' . $rowAnyPackage . '"
                                data-name="singleRoomPriceR" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomonebed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="singleRoomPriceR' . $rowAnyPackage . '"
                                data-name="singleRoomPriceR" 
                                data-values="name,id" class="form-control font-12 change_counter_js" id="singleRoomPriceR' . $rowAnyPackage . '" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('PriceRial').'">
                    </div>';

        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="childWithBedPriceR' . $rowAnyPackage . '"
                                data-name="childWithBedPriceR" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Childwithbed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="childWithBedPriceR' . $rowAnyPackage . '"
                                data-name="childWithBedPriceR" 
                                data-values="name,id" class="form-control font-12 change_counter_js" id="childWithBedPriceR' . $rowAnyPackage . '" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('PriceRial').'">
                    </div>';

        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="infantWithoutBedPriceR' . $rowAnyPackage . '"
                                data-name="infantWithoutBedPriceR" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Babywithoutbed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="infantWithoutBedPriceR' . $rowAnyPackage . '"
                                data-name="infantWithoutBedPriceR" 
                                data-values="name,id" class="form-control font-12 change_counter_js" id="infantWithoutBedPriceR' . $rowAnyPackage . '" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('PriceRial').'">
                    </div>';

        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="infantWithoutChairPriceR' . $rowAnyPackage . '"
                                data-name="infantWithoutChairPriceR" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Babywithoutchair').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="infantWithoutChairPriceR' . $rowAnyPackage . '"
                                data-name="infantWithoutChairPriceR" 
                                data-values="name,id" class="form-control font-12 change_counter_js" id="infantWithoutChairPriceR' . $rowAnyPackage . '" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('PriceRial').'">
                    </div>';

        $result .= '</div>';
        $result .= '</div>';


//        ----------

        $result .= '<div class="bg-white rounded row-tour-hotel w-100">';

        $result .= '<div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                        <span class="tour-price-r">'.functions::Xmlinformation('SpecialCounterPrice').' </span>
                    </div>';
        $result .= '<div class="p-2 py-4 tour-hotel w-100">
                      <div class="box-hotel justify-content-center d-flex flex-wrap w-100">';
        $counterType=Load::controller('counterType');
        $counterType->getAll('all');
        foreach($counterType->list as $counter_key=>$counter_type){
            $objController = Load::controller('resultTourLocal');
            $result.='<div class="col-lg-2.5 col-md-4 no-star">


                          <div class="d-flex font-13 font-weight-bolder justify-content-center p-2 py-2 w-100">
                              <span class="tour-price-r">'.$counter_type['name'].'</span>
                          </div>';

                          foreach($objController->tourDiscountFieldsIndex() as $entry_key=>$entry){
        $result.='
                              <div class="w-100 no-star mb-3">
                                  <label for="{$entry.index}{$counter_key}{$entry_key}"
                                         class="flr font-12 text-muted">'.$entry['title'].'
                                      ('.functions::Xmlinformation("Riali").'):</label>

                                  <input type="text"
                                         name="'.$entry['index'].'['.$rowAnyPackage.']['.$counter_key.']"
                                         id="'.$entry['index'].$counter_key.$entry_key.'"
                                         onkeypress="isDigit(this)"
                                         class="form-control font-12"
                                         onkeyup="javascript:separator(this);"
                                         value="0"
                                         placeholder="'.functions::Xmlinformation("Price").' '.functions::Xmlinformation("Riali").'">
                              </div>';

                          }
            $result.='</div>';
        }

        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';


//        ----------

        $result .= '<div class="bg-white rounded row-tour-hotel w-100">';

        $result .= '<div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                        <span class="tour-price-r">'.functions::Xmlinformation('Price').' '.functions::Xmlinformation('currency').' </span>
                    </div>';
        $result .= '<div class="d-flex flex-wrap p-2 py-4 tour-hotel w-100">';

        $result .= '<div class="col-md-3 mb-3 px-2 no-star width14">
                        <label for="currencyType' . $rowAnyPackage . '"
                                data-name="currencyType" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Typecurrency').' :</label>
                        <select name="currencyType' . $rowAnyPackage . '"
                                data-name="currencyType" 
                                data-values="name,id" id="currencyType' . $rowAnyPackage . '" class="select2 change_counter_js">
                              class="form-control font-12"
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('Donthave').'</option>';
        foreach ($objCurrency->ListCurrencyEquivalent() as $currency) {
            $result .= '<option value="' . $currency['CurrencyCode'] . '">' . $currency['CurrencyTitle'] . '</option>';
        }
        $result .= '
                        </select>
                    </div>';

        $result .= '<div class="col-md-3 mb-3 px-2 no-star width14">
                        <label for="threeRoomPriceA' . $rowAnyPackage . '"
                                data-name="threeRoomPriceA" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomthreebed').' ('.functions::Xmlinformation('Arzi').'):</label>
                        <input type="text" name="threeRoomPriceA' . $rowAnyPackage . '"
                                data-name="threeRoomPriceA" 
                                data-values="name,id" id="threeRoomPriceA' . $rowAnyPackage . '"
                              class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('ArziPrice').'">
                    </div>';

        $result .= '<div class="col-md-3 mb-3 px-2 no-star width14">
                        <label for="doubleRoomPriceA' . $rowAnyPackage . '"
                                data-name="doubleRoomPriceA" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomtwobed').' ('.functions::Xmlinformation('Arzi').'):</label>
                        <input type="text" name="doubleRoomPriceA' . $rowAnyPackage . '"
                                data-name="doubleRoomPriceA" 
                                data-values="name,id" id="doubleRoomPriceA' . $rowAnyPackage . '"
                              class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('ArziPrice').'">
                    </div>';

        $result .= '<div class="col-md-3 mb-3 px-2 no-star width14">
                        <label for="singleRoomPriceA' . $rowAnyPackage . '"
                                data-name="singleRoomPriceA" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomonebed').' ('.functions::Xmlinformation('Arzi').'):</label>
                        <input type="text" name="singleRoomPriceA' . $rowAnyPackage . '"
                                data-name="singleRoomPriceA" 
                                data-values="name,id" id="singleRoomPriceA' . $rowAnyPackage . '"
                              class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('ArziPrice').'">
                    </div>';

        $result .= '<div class="col-md-3 mb-3 px-2 no-star width14">
                        <label for="childWithBedPriceA' . $rowAnyPackage . '"
                                data-name="childWithBedPriceA" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Childwithbed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="childWithBedPriceA' . $rowAnyPackage . '"
                                data-name="childWithBedPriceA" 
                                data-values="name,id" id="childWithBedPriceA' . $rowAnyPackage . '"
                              class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('ArziPrice').'">
                    </div>';

        $result .= '<div class="col-md-3 mb-3 px-2 no-star width14">
                        <label for="infantWithoutBedPriceA' . $rowAnyPackage . '"
                                data-name="infantWithoutBedPriceA" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Babywithoutbed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="infantWithoutBedPriceA' . $rowAnyPackage . '"
                                data-name="infantWithoutBedPriceA" 
                                data-values="name,id" id="infantWithoutBedPriceA' . $rowAnyPackage . '"
                              class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('ArziPrice').'">
                    </div>';

        $result .= '<div class="col-md-3 mb-3 px-2 no-star width14">
                        <label for="infantWithoutChairPriceA' . $rowAnyPackage . '"
                                data-name="infantWithoutChairPriceA" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Babywithoutchair').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="infantWithoutChairPriceA' . $rowAnyPackage . '"
                                data-name="infantWithoutChairPriceA" 
                                data-values="name,id" id="infantWithoutChairPriceA' . $rowAnyPackage . '"
                              class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('ArziPrice').'">
                    </div>';

        /*$result .= '<div class="s-u-passenger-item no-star divDeleteRow">
                        <span class="delete-tour-span" onclick="deleteRowHotel('.$rowAnyPackage.')">
                            <span class="addRowHotel"></span>
                            <span class="deleteRow"></span>
                            <span class="deleteTXT">حذف پکیج</span>
                        </span>
                    </div>';*/

        $result .= '</div>';
        $result .= '</div>';

//        -----------



        $result .= '<div class="bg-white rounded row-tour-hotel w-100">';

        $result .= '<div class="border-bottom d-flex font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                        <span class="tour-price-r">'.functions::Xmlinformation('CapacityRoom').' </span>
                    </div>';
        $result .= '<div class="d-flex flex-wrap p-2 py-4 tour-hotel w-100">';

    $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="threeRoomCapacity' . $rowAnyPackage . '" 
                                data-name="threeRoomCapacity" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomthreebed').':</label>
                        <input type="text" name="threeRoomCapacity' . $rowAnyPackage . '"
                                data-name="threeRoomCapacity" 
                                data-values="name,id" id="threeRoomCapacity' . $rowAnyPackage . '"
                        class="form-control font-12 change_counter_js" 
                        onkeypress="isDigit(this)" placeholder="'.functions::Xmlinformation('CapacityRoom').'" value="9">
                    </div>';

    $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="doubleRoomCapacity' . $rowAnyPackage . '" 
                                data-name="doubleRoomCapacity" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomtwobed').':</label>
                        <input type="text" name="doubleRoomCapacity' . $rowAnyPackage . '"
                                data-name="doubleRoomCapacity" 
                                data-values="name,id" id="doubleRoomCapacity' . $rowAnyPackage . '"
                        class="form-control font-12 change_counter_js" 
                        onkeypress="isDigit(this)" placeholder="'.functions::Xmlinformation('CapacityRoom').'" value="9">
                    </div>';

    $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="singleRoomCapacity' . $rowAnyPackage . '" 
                                data-name="singleRoomCapacity" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Roomonebed').':</label>
                        <input type="text" name="singleRoomCapacity' . $rowAnyPackage . '"
                                data-name="singleRoomCapacity" 
                                data-values="name,id" id="singleRoomCapacity' . $rowAnyPackage . '"
                        class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" placeholder="'.functions::Xmlinformation('CapacityRoom').'" value="9">
                    </div>';

    $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="childWithBedCapacity' . $rowAnyPackage . '" 
                                data-name="childWithBedCapacity" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Childwithbed').':</label>
                        <input type="text" name="childWithBedCapacity' . $rowAnyPackage . '"
                                data-name="childWithBedCapacity" 
                                data-values="name,id" id="childWithBedCapacity' . $rowAnyPackage . '"
                        class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" placeholder="'.functions::Xmlinformation('CapacityRoom').'" value="9">
                    </div>';

    $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="infantWithoutBedCapacity' . $rowAnyPackage . '" 
                                data-name="infantWithoutBedCapacity" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Babywithoutbed').':</label>
                        <input type="text" name="infantWithoutBedCapacity' . $rowAnyPackage . '"
                                data-name="infantWithoutBedCapacity" 
                                data-values="name,id" id="infantWithoutBedCapacity' . $rowAnyPackage . '"
                        class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" placeholder="'.functions::Xmlinformation('CapacityRoom').'" value="9">
                    </div>';

    $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="infantWithoutChairCapacity' . $rowAnyPackage . '" 
                                data-name="infantWithoutChairCapacity" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::Xmlinformation('Babywithoutchair').':</label>
                        <input type="text" name="infantWithoutChairCapacity' . $rowAnyPackage . '"
                                data-name="infantWithoutChairCapacity" 
                                data-values="name,id" id="infantWithoutChairCapacity' . $rowAnyPackage . '"
                        class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" placeholder="'.functions::Xmlinformation('CapacityRoom').'" value="9">
                    </div>';

    $result .= '</div>';
    $result .= '</div>';

        $result .= '<div id="rowRooBed' . $rowAnyPackage . '"></div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '<div class="clear"></div>';

        echo $result;


    } else {
        echo functions::Xmlinformation('NothaveCity');
    }


}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'listRoutForTour') {
    unset($_POST['flag']);

    $objBasic = Load::controller('reservationBasicInformation');

    $rowAnyRout = filter_var($_POST['countRowAnyRout'], FILTER_VALIDATE_INT);
    $number = filter_var($_POST['number'], FILTER_VALIDATE_INT);
    /*switch ($number) {
        case '1':
            $textNumber = functions::Xmlinformation('First');
            break;
        case '2':
            $textNumber =  functions::Xmlinformation('Second');
            break;
        case '3':
            $textNumber = functions::Xmlinformation('Third');
            break;
        case '4':
            $textNumber =  functions::Xmlinformation('Fourth');
            break;
        case '5':
            $textNumber =  functions::Xmlinformation('Fifth');
            break;
        case '6':
            $textNumber =  functions::Xmlinformation('Sixth');
            break;
        case '7':
            $textNumber =  functions::Xmlinformation('Seventh');
            break;
        case '8':
            $textNumber =  functions::Xmlinformation('Eighth');
            break;
        case '9':
            $textNumber =  functions::Xmlinformation('ninth');
            break;
        default:
            $textNumber = '';
            break;
    }*/

    $typeRow = $_POST['typeRow'];
    if ($typeRow == 'rowRout') {
        $tourTitle = 'dept';
        $classW = 'width20';
    } elseif ($typeRow == 'rowReturnRoute') {
        $tourTitle = 'return';
        $classW = 'width25';
        $number = functions::Xmlinformation('JustReturn');
    }
    $result = '';
    $result .= '<div id="rowAnyRout' . $rowAnyRout . '" class="bg-light-blue overflow-hidden rounded rowAnyRout route_box">
                    
                    <input class="change_counter_js" data-values="name,id" data-name="tourTitle"
                          type="hidden" name="tourTitle' . $rowAnyRout . '" id="tourTitle' . $rowAnyRout . '" value="' . $tourTitle . '">
                    <div class="rout-number divDeleteRow">
                        <div class="align-items-center d-flex flex-wrap justify-content-between px-2 rout-number-50 w-100">
                            <span class="font-weight-bold" data-name="title-counter">' .functions::Xmlinformation('Destination') .' '. $number . '</span>
                           
                            <button onclick="removeRowRout(\'' . $rowAnyRout . '\')"
                                    data-name="remove-btn"
                                    class="btn btn-danger btn-sm font-12 p-1 px-2">
                            <span class="deleteRow fa fa-trash"></span>
                                حذف
                            </button>
                        </div>
                        <div class="rout-number-50">
                        ';
    if ($typeRow == 'rowRout') {
        $result .= '<span class="deleteRow" onclick="deleteRowRout(' . "'" . $rowAnyRout . "'" . ', ' . "'$typeRow'" . ')" >';
    }
    $result .= '
                            </span>
                        </div>
                    </div>';

    if ($typeRow == 'rowRout') {
        $result .= '
                    <div class="s-u-passenger-item no-star width20">
                        <label data-values="for" data-name="night" for="night' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('Countnight').':</label>
                        <input class="change_counter_js" data-values="name,id" data-name="night" type="text" name="night' . $rowAnyRout . '" id="night' . $rowAnyRout . '" value="" placeholder="'.functions::Xmlinformation('CountNight').'">
                    </div>';
        /*$result .= '
                    <div class="s-u-passenger-item no-star width10">
                        <label for="day' . $rowAnyRout . '" class="flr">'. functions::Xmlinformation('Countday').':</label>
                        <input type="text" name="day' . $rowAnyRout . '" id="day' . $rowAnyRout . '" value="" placeholder="'.functions::Xmlinformation('CountDay').'">
                    </div>';*/
    } elseif ($typeRow == 'rowReturnRoute') {
        $result .= '
                <input  class="change_counter_js" data-values="name,id" data-name="night" type="hidden" name="night' . $rowAnyRout . '" id="night' . $rowAnyRout . '" value="0">
                <input  class="change_counter_js" data-values="name,id" data-name="day" type="hidden" name="day' . $rowAnyRout . '" id="day' . $rowAnyRout . '" value="0">
                ';
    }

    $result .= '
                    <div class="s-u-passenger-item no-star ' . $classW . '">
                        <label data-values="for" data-name="destinationContinent" for="destinationContinent' . $rowAnyRout . '" class="flr change_counter_js">'. functions::Xmlinformation('Continent').' ('.functions::Xmlinformation('Destination').'):</label>
                        <select data-values="name,id,data-counter" data-name="destinationContinent" name="destinationContinent' . $rowAnyRout . '" id="destinationContinent' . $rowAnyRout . '" 
                            class="select2 change_counter_js" data-counter="'.$rowAnyRout.'" onchange="fillComboCountryByDataAttr($(this), ' . "'destination'" . ')">
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('ChoseOption').'</option>
                            <option value="1">'.functions::Xmlinformation('Asia').'</option>
                            <option value="2">'.functions::Xmlinformation('Eroup').'</option>
                            <option value="3">'.functions::Xmlinformation('American').'</option>
                            <option value="4">'.functions::Xmlinformation('Australia').'</option>
                            <option value="5">'.functions::Xmlinformation('Africa').'</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star ' . $classW . '">
                        <label data-values="for" data-name="destinationCountry" for="destinationCountry' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('Country').' ('.functions::Xmlinformation('Destination').'):</label>
                        <select data-values="name,id,data-counter" data-name="destinationCountry" name="destinationCountry' . $rowAnyRout . '" id="destinationCountry' . $rowAnyRout . '" 
                        class="select2 change_counter_js" data-counter="'.$rowAnyRout.'" onchange="fillComboCityByDataAttr($(this), ' . "'destination'" . ')">
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('ChoseOption').'</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star ' . $classW . '">
                        <label data-values="for" data-name="destinationCity" for="destinationCity' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('City').' ('.functions::Xmlinformation('Destination').'):</label>
                        <select data-values="name,id,data-counter" data-name="destinationCity" name="destinationCity' . $rowAnyRout . '" id="destinationCity' . $rowAnyRout . '" 
                        class="select2 change_counter_js" data-counter="'.$rowAnyRout.'" onchange="fillComboRegionByDataAttr($(this), ' . "'destination'" . ')">
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('ChoseOption').'</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star ' . $classW . '">
                        <label data-values="for" data-name="destinationRegion" for="destinationRegion' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('Area').' ('.functions::Xmlinformation('Destination').'):</label>
                        <select data-values="name,id" data-name="destinationRegion" name="destinationRegion' . $rowAnyRout . '" 
                              id="destinationRegion' . $rowAnyRout . '" class="select2 change_counter_js">
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('ChoseOption').'</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star width12">
                        <label data-values="for" data-name="typeVehicle" for="typeVehicle' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('Vehicletype').':</label>
                        <select data-values="name,id,data-counter" data-name="typeVehicle" name="typeVehicle' . $rowAnyRout . '" id="typeVehicle' . $rowAnyRout . '" 
                        class="select2 change_counter_js" data-counter="'.$rowAnyRout.'" onchange="listAirlineByDataAttr($(this))">
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('ChoseOption').'</option>';
    foreach ($objBasic->SelectAll('reservation_type_of_vehicle_tb') as $typeVehicle) {
        $result .= '<option value="' . $typeVehicle['id'] . '">' . $typeVehicle['name'] . '</option>';
    }
    $result .= '
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star">
                        <label data-values="for" data-name="airline" for="airline' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('Shippingcompany').':</label>
                        <select data-values="name,id" data-name="airline" name="airline' . $rowAnyRout . '" id="airline' . $rowAnyRout . '" class="select2 change_counter_js">
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('ChoseOption').'</option>
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star width12">
                        <label data-values="for" data-name="class" for="class' . $rowAnyRout . '" class="flr change_counter_js">'. functions::Xmlinformation('Classrate').':</label>
                        <select data-values="name,id" data-name="class" name="class' . $rowAnyRout . '" id="class' . $rowAnyRout . '" class="select2 change_counter_js">
                            <option value="" disabled="disabled" selected>'.functions::Xmlinformation('ChoseOption').'</option>';
    foreach ($objBasic->SelectAll('reservation_vehicle_grade_tb') as $vehicleGrade) {
        $result .= '<option value="' . $vehicleGrade['name'] . '">' . $vehicleGrade['name'] . '</option>';
    }
    $result .= '
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star width12 txt11">
                        <label data-values="for" data-name="exitHours" for="exitHours' . $rowAnyRout . '" class="flr change_counter_js">'. functions::Xmlinformation('Starttime').' ('. functions::Xmlinformation('Hour').'):</label>
                        <select data-values="name,id" data-name="exitHours" name="exitHours' . $rowAnyRout . '" id="exitHours' . $rowAnyRout . '" class="form-control change_counter_js">
                            ';
    for ($n = 0; $n <= 9; $n++) {
        $result .= '<option value="0' . $n . '">0' . $n . '</option>';
    }
    for ($n = 10; $n <= 24; $n++) {
        $result .= '<option value="' . $n . '">' . $n . '</option>';
    }
    $result .= '
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star width12 txt11">
                        <label data-values="for" data-name="exitMinutes" for="exitMinutes' . $rowAnyRout . '" class="flr change_counter_js">'. functions::Xmlinformation('Starttime').' ('. functions::Xmlinformation('Minutes').'):</label>
                        <select data-values="name,id" data-name="exitMinutes" name="exitMinutes' . $rowAnyRout . '" id="exitMinutes' . $rowAnyRout . '" class="form-control change_counter_js">
                        ';
    for ($n = 0; $n <= 9; $n++) {
        $result .= '<option value="0' . $n . '">0' . $n . '</option>';
    }
    for ($n = 10; $n <= 60; $n++) {
        $result .= '<option value="' . $n . '">' . $n . '</option>';
    }
    $result .= '
                        </select>
                    </div>
                    
                    
                    
                    <div class="s-u-passenger-item no-star width12">
                        <label data-values="for" data-name="hours" for="hours' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('Periodoftime').' ('. functions::Xmlinformation('Hour').'):</label>
                        <select data-values="name,id" data-name="hours" name="hours' . $rowAnyRout . '" id="hours' . $rowAnyRout . '" class="form-control change_counter_js">';
    for ($n = 0; $n <= 9; $n++) {
        $result .= '<option value="0' . $n . '">0' . $n . '</option>';
    }
    for ($n = 10; $n <= 24; $n++) {
        $result .= '<option value="' . $n . '">' . $n . '</option>';
    }
    $result .= '
                        </select>
                    </div>

                    <div class="s-u-passenger-item no-star width12">
                        <label data-values="for" data-name="minutes" for="minutes' . $rowAnyRout . '" class="flr change_counter_js">'.functions::Xmlinformation('Periodoftime').' ('. functions::Xmlinformation('Minutes').'):</label>
                        <select data-values="name,id" data-name="minutes" name="minutes' . $rowAnyRout . '" id="minutes' . $rowAnyRout . '" class="form-control change_counter_js">';
    for ($n = 0; $n <= 9; $n++) {
        $result .= '<option value="0' . $n . '">0' . $n . '</option>';
    }
    for ($n = 10; $n <= 60; $n++) {
        $result .= '<option value="' . $n . '">' . $n . '</option>';
    }
    $result .= '
                        </select>
                    </div>';

    $result .='           <div class="s-u-passenger-item  no-star">
                                <label data-values="for" data-name="minutes"
                                       for="is_rout_fake' . $rowAnyRout . '" class="flr change_counter_js"> نمایش این مقصد در نتایج جستجو :</label>
                                <select name="is_route_fake' . $rowAnyRout . '"
                                        data-values="name,id"
                                        data-name="is_route_fake"
                                        id="is_route_fake1" class="form-control change_counter_js">

                                     
                                        <option value="1">نمایش</option>
                                        <option value="0">عدم نمایش</option>
                                </select>
                            </div>';



    $result .= '
                </div>';

    echo $result;


}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'tourRegistration') {
    unset($_POST['flag']);
    /* @var reservationTour $objController */
    $objController = Load::controller('reservationTour');
    $result = $objController->insertTour($_POST, $_FILES);
    echo $result;
} elseif (isset($_POST['flag']) && $_POST['flag'] == 'tourPackageInsert') {

    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    if ($_POST['flagSecond'] == 'oneDayTourRegistration') {
        $result = $objController->insertOneDayTour($_POST);

    } elseif ($_POST['flagSecond'] == 'tourPackageRegistration') {
        $result = $objController->insertPackageTour($_POST);
    }
    echo $result;


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'editTour') {
    unset($_POST['flag']);

    /** @var reservationTour $objController */
    $objController = Load::controller('reservationTour');
    $result = $objController->editTour($_POST, $_FILES);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'changeTourPackagePrices') {
    unset($_POST['flag']);
    /** @var reservationTour $objController */
    $objController = Load::controller('reservationTour');
    $result = $objController->changeTourPackagePrices($_POST);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'tourPackageEdit') {
    unset($_POST['flag']);

    /** @var reservationTour $objController */
    $objController = Load::controller('reservationTour');
    if ($_POST['flagSecond'] == 'oneDayTourRegistration') {
        $result = $objController->editOneDayTour($_POST);

    } elseif ($_POST['flagSecond'] == 'tourPackageRegistration') {
        $result = $objController->editPackageTour($_POST);
    }
    echo $result;


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'editTourWithIdSame') {
    unset($_POST['flag']);
    /** @var $objController reservationTour*/
    $objController = Load::controller('reservationTour');
    $result = $objController->editTourWithIdSame($_POST, $_FILES);

    echo $result;


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'editTourPackageWithIdSame') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    if ($_POST['flagSecond'] == 'oneDayTourRegistration') {
        $result = $objController->editOneDayTourWithIdSame($_POST);

    } elseif ($_POST['flagSecond'] == 'tourPackageRegistration') {
        $result = $objController->editPackageTourWithIdSame($_POST);
    }
    echo $result;


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'isShowTour') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->registerIsShowTour($_POST['idTour'], $_POST['isShow'], $_POST['detail']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'deletionPackage') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->deletionPackage($_POST['id']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'deletionGroupPackage') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->deletionGroupPackage($_POST['idSame'], $_POST['numberPackage']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'deletionGroupPackageByTourId') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->deletionGroupPackageByTourId($_POST['tour_id'], $_POST['numberPackage']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'deletionRout') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->deletionRout($_POST['id']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'userCommentsInsert') {
    unset($_POST['flag']);

    $objController = Load::controller('resultTourLocal');
    $result = $objController->userCommentsInsert($_POST);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'agencyRate') {
    unset($_POST['flag']);

    $objController = Load::controller('resultTourLocal');
    $result = $objController->agencyRateInsert($_POST);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'isShowUserComments') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->registerIsShowUserComments($_POST['id'], $_POST['isShow']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'preReserveTour') {
    unset($_POST['flag']);

    $Model = Load::library('Model');
    $ModelBase = Load::library('ModelBase');

    $Model->setTable("book_tour_local_tb");
    $data['status'] = 'TemporaryPreReserve';
    $data['creation_date_int'] = time();


    $Condition = " factor_number ='{$_POST['factorNumber']}' ";
    $res2[] = $Model->update($data, $Condition);
    $info_tour_book_sql = "SELECT * FROM book_tour_local_tb where factor_number ='{$_POST['factorNumber']}'";
    $info_tour_book = $Model->load($info_tour_book_sql);

    if($info_tour_book['is_api']){
      $admin = Load::controller('admin');
      $admin->ConectDbClient('', $info_tour_book['client_id_api'], 'Update', $data, 'book_tour_local_tb', $Condition);
    }

    $ModelBase->setTable("report_tour_tb");
    $res2[] = $ModelBase->update($data, $Condition);

    if (in_array('0', $res2)) {
        echo 'error:'.functions::Xmlinformation('ErrorUnknownBuyHotel');
    } else {
        echo 'success';
    }


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'confirmationTourReservation') {
    unset($_POST['flag']);

    $Model = Load::library('Model');
    $ModelBase = Load::library('ModelBase');

    $infoBook = functions::GetInfoTour($_POST['factorNumber']);

    $data['total_price'] = $infoBook['tour_total_price'] - $infoBook['tour_payments_price'];
    $data['status'] = 'PreReserve';
    $data['creation_date_int'] = time();

    $Condition = " factor_number ='{$_POST['factorNumber']}' ";
    $Model->setTable("book_tour_local_tb");
    $res2[] = $Model->update($data, $Condition);

    $ModelBase->setTable("report_tour_tb");
    $res2[] = $ModelBase->update($data, $Condition);


    if (in_array('0', $res2)) {
        echo 'error:'.functions::Xmlinformation('ErrorUnknownBuyHotel');
    } else {

        $smsController = Load::controller('smsServices');

        $price = $infoBook['tour_total_price'] - $infoBook['tour_payments_price'];
        //sms to buyer
        $objSms = $smsController->initService('0');
        if ($objSms) {
            $mobile = $infoBook['member_mobile'];
            $name = $infoBook['passenger_name'] . ' ' . $infoBook['passenger_family'];

            $messageVariables = array(
                'sms_name' => $name,
                'sms_service' => 'تور',
                'sms_factor_number' => $_POST['factorNumber'],
                'sms_cost' => $price,
                'sms_tour_name' => $infoBook['tour_name'],
                'sms_tour_night' => $infoBook['tour_night'],
                'sms_tour_day' => $infoBook['tour_day'],
                'sms_tour_cities' => $infoBook['tour_cities'],
                'sms_tour_dept_date' => $infoBook['tour_start_date'],
                'sms_tour_return_date' => $infoBook['tour_end_date'],
                'sms_pdf' => ROOT_ADDRESS . "/pdf&target=BookingTourLocal&id=" . $_POST['factorNumber'],
                'sms_agency' => CLIENT_NAME,
                'sms_agency_mobile' => CLIENT_MOBILE,
                'sms_agency_phone' => CLIENT_PHONE,
                'sms_agency_email' => CLIENT_EMAIL,
                'sms_agency_address' => CLIENT_ADDRESS,
            );
            $smsArray = array(
                'smsMessage' => $smsController->getUsableMessage('confirmTourReserve', $messageVariables),
                'cellNumber' => $mobile,
                'smsMessageTitle' => 'confirmTourReserve',
                'memberID' => (!empty($infoBook['member_id']) ? $infoBook['member_id'] : ''),
                'receiverName' => $messageVariables['sms_name'],
            );

            $smsController->sendSMS($smsArray);

        }


        //sms to site manager
        $smsManager = " مدیر گرامی " . CLIENT_NAME . " درخواست رزرو تور " . $infoBook['tour_name'] . " از طرف کارگزار تایید شده و منتظر پرداخت مابقی مبلغ می باشد. ";
        $smsManager .= PHP_EOL . " شماره فاکتور: " . $_POST['factorNumber'];
        $objSms = $smsController->initService('1');
        if ($objSms) {
            $smsArray = array(
                'smsMessage' => $smsManager,
                'cellNumber' => CLIENT_MOBILE
            );
            $smsController->sendSMS($smsArray);
        }


        echo 'success:'.functions::Xmlinformation('SuccessReserve');
    }


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'registerPassengersFileTour') {
    unset($_POST['flag']);

    $Model = Load::library('Model');
    $ModelBase = Load::library('ModelBase');

    if (isset($_FILES['passengersFileTour']) && $_FILES['passengersFileTour'] != "") {

        $config = Load::Config('application');
        $config->pathFile('reservationTour/passengersImages/');

        $resultUpload = $config->uploadFiles("", "passengersFileTour", "");
        $dataPic = array();
        foreach ($resultUpload as $k=>$pic) {
            if ($pic['message'] == 'done') {
                $dataPic[] = $pic['fileName'];
            }
        }
        if (!empty($dataPic)){
            $data['passengers_file_tour'] = json_encode($dataPic);

            $Condition = " factor_number ='{$_POST['factorNumber']}' ";
            $Model->setTable("book_tour_local_tb");
            $res2[] = $Model->update($data, $Condition);

            $ModelBase->setTable("report_tour_tb");
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







} elseif (isset($_POST['flag']) && $_POST['flag'] == 'createPayButton') {

    unset($_POST['flag']);

    $bankInputs = array(
        'flag' => 'check_credit_tour',
        'factorNumber' => $_POST['factorNumber'],
        'typeTrip' => $_POST['typeTrip'],
        'paymentPrice' => $_POST['paymentPrice'],
        'serviceType' => $_POST['serviceType'],
        'paymentStatus'=>'fullPayment'
    );

    $creditInputs = array(
        'flag' => 'buyByCreditTourLocal',
        'factorNumber' => $_POST['factorNumber'],
        'paymentStatus'=>'fullPayment'
    );

    /*if($_POST['currencyCode'] > 0) {

        $paymentPriceCurrency = functions::CurrencyCalculate($_POST['paymentPrice'], $_POST['currencyCode'], $_POST['currencyEquivalent']);

        $currencyInputs = array(
            'flag' => 'check_credit_tour',
            'factorNumber' => $_POST['factorNumber'],
            'typeTrip' => $_POST['typeTrip'],
            'paymentPrice' => $_POST['paymentPrice'],
            'serviceType' => $_POST['serviceType'],
            'amount' => $paymentPriceCurrency['AmountCurrency'],
            'currencyCode' => $_POST['currencyCode'],
            'status' => 'BookedSuccessfully'
        );

        $output['result_currency'] = '<a class="s-u-select-update s-u-select-update-change site-main-button-flat-color" onclick=\'currencyPayment(this, amadeusPath + "returnBankTourLocal", '.json_encode($currencyInputs).')\'>پرداخت</a>';
    }*/


    $output['result_bank'] = '<a class="s-u-select-update s-u-select-update-change site-main-button-flat-color" onclick=\'goToBank(this, amadeusPath + "goBankTourLocal", ' . json_encode($bankInputs) . ')\'>'. functions::Xmlinformation('Payment').'</a>';
    $output['result_credit'] = '<a class="s-u-select-update s-u-select-update-change site-main-button-flat-color" onclick=\'creditBuy(this, amadeusPath + "returnBankTourLocal", ' . json_encode($creditInputs) . ')\'>'.functions::Xmlinformation('Paycredit').'</a>';

    echo json_encode($output);


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'tourGallery') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->insertTourGallery($_POST, $_FILES);

    echo $result;


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'isEditorActive') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->isEditorActive($_POST['id']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'isShowLoginPopupActive') {
    unset($_POST['flag']);

    $objController = Load::controller('settings');
    $result = $objController->isShowLoginPopupActive($_POST['id']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'isSpecialTour') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->isSpecialTour($_POST['idSame']);

    echo $result;

}elseif (isset($_POST['flag']) && $_POST['flag']==='changeSuggestedStatus') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->changeSuggestedStatus($_POST['idSame']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'isFirstTour') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->isFirstTour($_POST['idSame']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'setStartTimeLastMinuteTour') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->setStartTimeLastMinuteTour($_POST['idSame'], $_POST['startTimeLastMinuteTour']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'logicalDeletion') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->logicalDeletion($_POST['idSame'], $_POST['type']);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'logicalDeletionGalleryTour') {
    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    $result = $objController->logicalDeletionGalleryTour($_POST['id']);

    echo $result;


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'getResultTourPackage') {
    unset($_POST['flag']);


    $tourCode = $_POST['tourCode'];
    $tourId = $_POST['tour_id'];
    $startDate = str_replace('/', '', $_POST['startDate']);
    $endDate = str_replace('/', '', $_POST['endDate']);
    $typeTourReserve = $_POST['typeTourReserve'];

    $IsLogin = Session::IsLogin();
    if($IsLogin){
        $counterId=functions::getCounterTypeId($_SESSION['userId']);
    }else{
        $counterId='5';
    }
    $portalServiceDiscount['public']=functions::ServiceDiscount($counterId, 'PublicPortalTour');
    $portalServiceDiscount['private']=functions::ServiceDiscount($counterId, 'PrivatePortalTour');
    $localServiceDiscount['public']=functions::ServiceDiscount($counterId, 'PublicLocalTour');
    $localServiceDiscount['private']=functions::ServiceDiscount($counterId, 'PrivateLocalTour');

    ob_start();
    ?>
    <input type="hidden" id="typeTourReserve" name="typeTourReserve" value="<?php echo $typeTourReserve; ?>">

    <?php
    if ($typeTourReserve == 'noOneDayTour') {

        /** @var resultTourLocal $objResult*/
        $objResult = Load::controller('resultTourLocal');
        $objController = Load::controller('reservationTour');

        $Model = Load::library('Model');
        $sql = "
        SELECT
            T.tour_code, T.start_date, T.change_price, T.discount_type, T.discount,T.prepayment_percentage,
            T.adult_price_one_day_tour_r, T.child_price_one_day_tour_r, T.infant_price_one_day_tour_r,
            P.*
        FROM
            reservation_tour_tb AS T
            INNER JOIN reservation_tour_package_tb AS P ON T.id = P.fk_tour_id 
            INNER JOIN reservation_tour_hotel_tb As hotel ON hotel.fk_tour_id = T.id
        WHERE
            T.id_same = (SELECT id_same FROM reservation_tour_tb WHERE id='{$tourId}')
            AND T.start_date = '{$startDate}'
            AND T.is_show = 'yes'
            AND T.is_del = 'no'
            AND P.is_del = 'no'
        GROUP BY P.id 
        ORDER BY
            P.double_room_price_r
        ";
        $tourPackage = $Model->select($sql);



        $HotelRoomNameArray=array(
            "OneBed"=>array(
                'name'=>functions::Xmlinformation('OneBed'),
                'packagePriceName'=>'single_room_price_r',
                'capacityValue'=>'single_room_capacity',
                'type'=>'adult'),
            "TwoBed"=>array(
                'name'=>functions::Xmlinformation('TwoBed'),
                'packagePriceName'=>'double_room_price_r',
                'capacityValue'=>'double_room_capacity',
                'type'=>'adult'),
            "ThreeBed"=>array(
                'name'=>functions::Xmlinformation('ThreeBed'),
                'packagePriceName'=>'three_room_price_r',
                'capacityValue'=>'three_room_capacity',
                'type'=>'adult'),
            "Childwithbed"=>array(
                'name'=>functions::Xmlinformation('Childwithbed'),
                'packagePriceName'=>'child_with_bed_price_r',
                'capacityValue'=>'child_with_bed_capacity',
                'type'=>'child'),
            "Babywithoutbed"=>array(
                'name'=>functions::Xmlinformation('Babywithoutbed'),
                'packagePriceName'=>'infant_without_bed_price_r',
                'capacityValue'=>'infant_without_bed_capacity',
                'type'=>'infant'),
            "Babywithoutchair"=>array(
                'name'=>functions::Xmlinformation('Babywithoutchair'),
                'packagePriceName'=>'infant_without_chair_price_r',
                'capacityValue'=>'infant_without_chair_capacity',
                'type'=>'infant'));

        ?>


        <input type="hidden" id="selectPackage" name="selectPackage" value="first">
        <input type="hidden" name="discountType" id="discountType" value="<?php echo $tourPackage[0]['discount_type']; ?>">
        <input type="hidden" name="discount" id="discount" value="<?php echo $tourPackage[0]['discount']; ?>">


        <?php
        $counterPackage=1;


        foreach ($tourPackage as $countPackage => $package) {



            if (isset($package['currency_type']) && $package['currency_type'] != '') {
                ?>
                <input type="hidden" id="currencyTitleFa" name="currencyTitleFa"
                       value="<?php echo $package['currency_type']; ?>">
                <?php
            }

            ?>

        <div class="col-md-12  BaseTourBox ">
            <div class="TourTitreDiv" data-request-action="LoadPackages">
            <span>
                <span data-request-value="true" class="p-0"><?php echo $_POST['startDate']; ?></span>
                -
                <span data-request-value="true" class="p-0"><?php echo $_POST['endDate']; ?></span>
            </span>
            </div>
            <div class="col-md-12 p-4  BaseTourPackage">

                <div class="col-md-12 p-0">

                    <ul class="timeline pt-0 mb-4 col-md-12 site-border-main-color">

                        <?php
                        $hotels=$objController->infoTourHotelByIdPackage($package['id']);

                        foreach($hotels as $countHotel=>$hotel){

                            $infoReservationHotel=$objResult->getInfoReservationHotel($hotel['fk_hotel_id']);
                            $infoTourRoutByIdPackage=$objController->infoTourRoutByIdPackage($package['id'],$hotel['fk_city_id']);
                            $facilities='';
                            if(isset($infoReservationHotel['facilities']) && $infoReservationHotel['facilities']!=''){
                                $facilities=json_encode($infoReservationHotel['facilities']);
                            }


                            ?>


                                <li class="event LiDot col-md-12 p-2 mb-3" data-request-action="LoadPackages">

                                        <div class=" BaseHotelBox">

                                                <div class="hotel_t_image_name">
                                                    <a onclick="hotelDetail('reservation', '<?php echo $hotel['fk_hotel_id']; ?>', '<?php echo str_replace(" ", "-", $infoReservationHotel['name_en']); ?>')">
                                                        <div data-request-value="img" class="w-100 hotelImage"
                                                             style="background-image:url('<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pic/<?php echo $infoReservationHotel['logo']; ?>')"></div>
                                                    </a>
                                                    <div class=" hotel_tour_name">
                                                        <a onclick="hotelDetail('reservation', '<?php echo $hotel['fk_hotel_id']; ?>', '<?php echo str_replace(" ", "-", $infoReservationHotel['name_en']); ?>')">
                                                            <?php
                                                            if(SOFTWARE_LANG == 'en'){
                                                                echo $infoReservationHotel['name_en'];
                                                            }else{
                                                                echo $hotel['hotel_name'];
                                                            }
                                                            ?>
                                                        </a>
                                                        <div class="StarHotelIntroduce SimpleTooltip">
                                                            <span class="SimpleTooltipText"><?php echo ($infoReservationHotel['star_code']=='ندارد' ? functions::Xmlinformation('WithOut'):$infoReservationHotel['star_code']) .' '. functions::Xmlinformation('Star'); ?>  </span>

                                                            <?php
                                                            for ($s = 1; $s <= $infoReservationHotel['star_code']; $s++) {
                                                                ?>
                                                                <span class="fa fa-star"></span>
                                                                <?php
                                                            }
                                                            for ($ss = $s; $ss <= 5; $ss++) {
                                                                ?>
                                                                <span class="fa fa-star-o"></span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="HotelIntroduce">


                                                        <div class="futers_hotel">
                                                          <div class="LocationHotelIntroduce">
                                                              <?php
                                                              if(SOFTWARE_LANG == 'en'){
                                                                  echo $hotel['city_name_en'];
                                                              }else{
                                                                  echo $hotel['city_name'];
                                                              }    ?>
                                                          </div>
                                                          <div class="NigtsHotelIntroduce">
                                                              <?php echo $infoTourRoutByIdPackage[0]['night'].' '. functions::Xmlinformation('Night'); ?>
                                                          </div>
                                                          <div class="ServicesHotelIntroduce">
                                                              <?php echo $hotel['room_service'];?>
                                                          </div>
                                                        </div>

                                                </div>

                                        </div>

                                </li>
                        <?php } ?>
                    </ul>

                    <div class="col-md-12 mb-4 ">
                        <div class="col-md-12 p-0 forceInOneLine NewScrollType1">
                            <?php
                            $countRooms=1;
                            foreach($HotelRoomNameArray as $RoomKey => $RoomInfo){

                                $doDiscount=($objResult->calculateDiscount($tourId,['minPriceR'=>$package[$RoomInfo['packagePriceName']]],$package['id'],$RoomInfo['type']));

                                if(empty($doDiscount['discountedMinPriceR'])){
                                    $correctPrice=$package[$RoomInfo['packagePriceName']];

                                }else{
                                    $correctPrice=$doDiscount['discountedMinPriceR'];

                                }
                                $prepaymentPercentageValue=$objResult->prePaymentCalculate($correctPrice,$tourPackage[0]['prepayment_percentage']);


                                ?>
                                <div class=" BaseDivCountBtn">

                                        <div class="col-md-12 DivCountBtnItem">
                                            <span class="RoomType"><?php echo $RoomInfo['name']; ?></span>
                                                <span data-request-action="LoadPackages" class="RoomPrice">
                                                    <?php

                                                    if(empty($doDiscount['discountedMinPriceR'])){
                                                        echo number_format($package[$RoomInfo['packagePriceName']]);
                                                    }else{ ?>
                                                        <span class="strikePrice" style="text-decoration: line-through;">
                                                            <b class="pice-tour">
                                                                <?php

                                                                echo number_format($package[$RoomInfo['packagePriceName']]);
                                                                ?>
                                                            </b>
                                                        </span>
                                                        <?php echo number_format($doDiscount['discountedMinPriceR']); ?>
                                                    <?php }

                                                    ?></span>
                                            <div class="input-group custom-input-group" disabled="disabled">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-number-js"
                                                            data-type="plus"
                                                        <?php if($package[$RoomInfo['packagePriceName']] <= 0){
                                                            echo 'disabled';
                                                        } ?> data-field="count<?php echo $countRooms.$counterPackage; ?>">
                                                        <span class="mdi mdi-plus"></span>
                                                    </button>
                                                </div>

                                                <input type="text" name="count<?php echo $countRooms.$counterPackage; ?>"
                                                       id="count<?php echo $countRooms.$counterPackage; ?>"
                                                       class="select_nor_style form-control input-number-js" readonly
                                                    <?php if($package[$RoomInfo['packagePriceName']] <= 0){
                                                        echo 'disabled';
                                                    } ?>
                                                       onkeyup="calculatePricesTour('<?php echo $package['id']; ?>', 'count')"
                                                       onchange="calculatePricesTour('<?php echo $package['id']; ?>', 'count')"
                                                       data-prepayment-percentage-value="<?php echo $prepaymentPercentageValue; ?>"
                                                       min="0" value="0"
                                                       max="<?php echo $package[$RoomInfo['capacityValue']]; ?>">

                                        <input type="hidden" name="<?php echo $RoomInfo['packagePriceName'].$countRooms.$counterPackage; ?>"
                                           id="price<?php echo $countRooms.$counterPackage; ?>" value="<?php echo $correctPrice; ?>">

                                                <input type="hidden" name="prePayment_<?php echo $RoomInfo['packagePriceName'].$countRooms.$counterPackage; ?>"
                                                       id="prePaymentPrice<?php echo $countRooms.$counterPackage; ?>" value="<?php echo $prepaymentPercentageValue; ?>">

                                            <input type="hidden" name="origin_<?php echo $RoomInfo['packagePriceName'].$countRooms.$counterPackage; ?>"
                                                   id="originPrice<?php echo $countRooms.$counterPackage; ?>" value="<?php echo $package[$RoomInfo['packagePriceName']]; ?>">

                                    <input type="hidden" name="priceA<?php echo $countRooms.$counterPackage; ?>"
                                           id="priceA<?php echo $countRooms.$counterPackage; ?>"
                                           value="<?php echo $package['double_room_price_a']; ?>">

                                                <div class="input-group-btn">
                                                    <button type="button" class=" btn btn-default btn-number-js"
                                                            disabled="disabled" data-type="minus"
                                                            data-field="count<?php echo $countRooms.$counterPackage; ?>">
                                                        <span class="mdi mdi-minus"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>  

                                </div>


                            <?php $countRooms++; } ?>
                        </div>
                    </div>


            </div>
        </div>
        </div>

        <input type="hidden" id="isBook<?php echo $counterPackage; ?>"
                               name="isBook<?php echo $counterPackage; ?>" value="">

            <?php $counterPackage++; } ?>




        <input type="hidden" id="countPackage" name="countPackage" value="<?php echo $counterPackage - 1; ?>">
        <input type="hidden" id="packageId" name="packageId" value="">

        <?php

        ?>

        <?php
    } elseif ($typeTourReserve == 'oneDayTour') {
        $objResult = Load::controller('resultTourLocal');
        $objController = Load::controller('reservationTour');

        $Model = Load::library('Model');
        $sql = "
        SELECT
            adult_price_one_day_tour_r, child_price_one_day_tour_r, infant_price_one_day_tour_r, change_price
        FROM
            reservation_tour_tb
        WHERE
            tour_code = '{$tourCode}'
            AND start_date = '{$startDate}'
        ";
        $package = $Model->load($sql);
        ?>

        <input type="hidden" name="discountType" id="discountType" value="<?php echo $package[0]['discount_type']; ?>">
        <input type="hidden" name="discount" id="discount" value="<?php echo $package[0]['discount']; ?>">

        <div class="table-striped">
            <div class="divTable">

                <div class="divTableHeading ">
                    <div class="divTableRow">
                        <div class="divTableHead">
                            <div class="name-city-rout"><?php echo functions::Xmlinformation('TourOneDay') ?> </div>
                        </div>
                        <div class="divTableHead"><?php echo functions::Xmlinformation('Adult')?></div>
                        <div class="divTableHead"><?php echo functions::Xmlinformation('Child')?></div>
                        <div class="divTableHead"><?php echo functions::Xmlinformation('Baby')?></div>
                    </div>
                </div>


                <div class="divTableBody">
                    <div class="divTableRow">
                        <div class="divTableCell">
                            <div><?php echo functions::Xmlinformation('SelectCountPeople')?></div>
                        </div>
                        <div class="divTableCell">
                            <?php
                            if ($package['adult_price_one_day_tour_r'] > 0) {
                                $price_adult = $package['adult_price_one_day_tour_r'] + $package['change_price'];
                                $price_adult = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price_adult);
                                ?>
                                <p>
                                    <label class="green-text"
                                           style="display: inline-block"><?php echo number_format($price_adult['price']); ?></label>
                                </p>
                                <p>
                                    <input type="hidden" name="adultPriceOneDayTourR" id="adultPriceOneDayTourR"
                                           value="<?php echo $price_adult['price']; ?>">
                                    <select name="adultCountOneDayTour" id="adultCountOneDayTour"
                                            onchange="calculatePricesOnDayTour('no')">
                                        <option value="0" selected=""><?php echo functions::Xmlinformation('Count')?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </p>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="divTableCell">
                            <?php
                            if ($package['child_price_one_day_tour_r'] > 0) {
                                $price_child = $package['child_price_one_day_tour_r'] + $package['change_price'];
                                $price_child = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price_child);
                                ?>
                                <p>
                                    <label class="green-text"
                                           style="display: inline-block"><?php echo number_format($price_child['price']); ?></label>
                                </p>
                                <p>
                                    <input type="hidden" name="childPriceOneDayTourR" id="childPriceOneDayTourR"
                                           value="<?php echo $price_child['price']; ?>">
                                    <select name="childCountOneDayTour" id="childCountOneDayTour"
                                            onchange="calculatePricesOnDayTour('no')">
                                        <option value="0" selected=""><?php echo functions::Xmlinformation('Count')?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </p>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="divTableCell">
                            <?php
                            if ($package['infant_price_one_day_tour_r'] > 0) {
                                $price_infant = $package['infant_price_one_day_tour_r'] + $package['change_price'];
                                $price_infant = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price_infant);
                                ?>
                                <p>
                                    <label class="green-text" style="display: inline-block"><?php echo number_format($price_infant['price']); ?></label>
                                </p>
                                <p>
                                    <input type="hidden" name="infantPriceOneDayTourR" id="infantPriceOneDayTourR"
                                           value="<?php echo $price_infant['price']; ?>">
                                    <select name="infantCountOneDayTour" id="infantCountOneDayTour"
                                            onchange="calculatePricesOnDayTour('no')">
                                        <option value="0" selected=""><?php echo functions::Xmlinformation('Count')?></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>


            </div>
            <p></p>
        </div>

        <?php
    }
    ?>


    <?php
    echo $printTour = ob_get_clean();


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'getResultTourPackageForResponsive') {
    unset($_POST['flag']);

    $tourCode = $_POST['tourCode'];
    $startDate = str_replace('/', '', $_POST['startDate']);
    $typeTourReserve = $_POST['typeTourReserve'];

    ob_start();
    ?>
    <input type="hidden" id="typeTourReserve" name="typeTourReserve" value="<?php echo $typeTourReserve; ?>">

    <?php
    if ($typeTourReserve == 'noOneDayTour') {

        $objResult = Load::controller('resultTourLocal');
        $objController = Load::controller('reservationTour');

        $Model = Load::library('Model');
        $ModelTest = Load::library('Model');
        $sql = "
        SELECT
            T.tour_code, T.start_date, T.change_price, T.discount_type, T.discount,T.prepayment_percentage,
            T.adult_price_one_day_tour_r, T.child_price_one_day_tour_r, T.infant_price_one_day_tour_r,
            P.*
        FROM
            reservation_tour_tb AS T
            LEFT JOIN reservation_tour_package_tb AS P ON T.id = P.fk_tour_id 
        WHERE
            T.tour_code = '{$tourCode}'
            AND T.start_date = '{$startDate}'
            AND T.is_show = 'yes'
            AND T.is_del = 'no'
            AND P.is_del = 'no'
        ";
        $tourPackage = $Model->select($sql);
        ?>
        <div class="bg-white">
            <div class="row" style="width: 100%;">
                <div class="titr-col"><?php echo functions::Xmlinformation('PackageHotels')?></div>
                <?php
                foreach ($tourPackage as $countPackage => $package) {
                    ?>
                    <div class="box__hotel__price box__color">

                        <?php
                        $hotels = $objController->infoTourHotelByIdPackage($package['id']);
                        foreach ($hotels as $countHotel => $hotel) {

                            $infoReservationHotel = $objResult->getInfoReservationHotel($hotel['fk_hotel_id']);
                            ?>
                            <div class="box">
                                <a class="wall center">
                                    <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG; ?>/pic/<?php echo $infoReservationHotel['logo']; ?>"
                                         alt="<?php echo $hotel['hotel_name']; ?>">
                                </a>
                                <div class="info">
                                    <h2 class="font__bold">
                                        <a onclick="hotelDetail('reservation', '<?php echo $hotel['fk_hotel_id']; ?>', '<?php echo str_replace(" ", "-", $infoReservationHotel['name_en']); ?>')"><?php echo $hotel['hotel_name']; ?></a>
                                    </h2>
                                    <a href="javascript:void(0)" class="location">
                                        <i class="mdi mdi-map-marker"></i><?php echo $hotel['city_name']; ?>
                                    </a>
                                    <a href="javascript:void(0)" class="vaqedar">
                                        <div>
                                            <?php
                                            if ($infoReservationHotel['region'] > 0) {
                                                $objPublic = Load::controller('reservationPublicFunctions');
                                                $name = $objPublic->ShowName('reservation_region_tb', $infoReservationHotel['region']);
                                                ?>
                                                <span><?php echo functions::Xmlinformation('LocatedAt')?></span>
                                                <span><?php echo $name; ?></span>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($hotel['room_type'] != '') {
                                                ?>
                                                <span class="site-main-text-color">(<?php echo $hotel['room_type']; ?>
                                                    )</span>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </a>
                                    <div class="rate__small">
                                        <div class="bullet">
                                            <?php
                                            for ($s = 1; $s <= $infoReservationHotel['star_code']; $s++) {
                                                ?>
                                                <i class="fa fa-star orange-text"></i>
                                                <?php
                                            }
                                            for ($ss = $s; $ss <= 5; $ss++) {
                                                ?>
                                                <i class="fa fa-star-o orange-text"></i>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (isset($hotel['room_service']) && $hotel['room_service'] != '') {
                                    ?>
                                    <div class="services__ center">
                                        <span class=""><?php echo $hotel['room_service']; ?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="price">
                            <?php
                            if ($package['double_room_price_r'] > 0) {
                                $price = $package['double_room_price_r'] + $package['change_price'];
                                $price = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price);
                            ?>
                            <p>  <?php echo functions::Xmlinformation('PriceTwoBed')?>:
                                <span class="site-main-text-color"><?php echo number_format($price['price']); ?>
                                    <small><?php echo functions::Xmlinformation('Rial')?></small>
                                </span>
                            </p>
                            <?php } ?>
                            <a class="font__bold site-border-main-color collapse__ site-main-text-color" onclick="showDetailPrice('<?php echo $countPackage; ?>');"> <?php echo functions::Xmlinformation('Ratedetails')?>
                                <i class="mdi mdi-chevron-down"></i>
                            </a>
                        </div>

                        <div id="detail-prices-<?php echo $countPackage; ?>" class="collapse_ displayN" aria-expanded="true" style="">
                            <div class="carousel-2">
                                <div class="list">
                                    <ul class="slider">

                                        <?php if ($package['single_room_price_r'] > 0) {
                                            $price = $package['single_room_price_r'] + $package['change_price'];
                                            $price = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price);
                                            ?>
                                            <li class="slide slide-40">
                                                <div class="type"><p><?php echo functions::Xmlinformation('OneBed')?></p>
                                                    <div class="number">
                                                        <div class="main__center">
                                                        <span class="site-main-text-color"><?php echo number_format($price['price']); ?>
                                                            <small><?php echo functions::Xmlinformation('Rial')?></small>
                                                        </span>
                                                            <?php
                                                            if ($package['single_room_price_a'] > 0) {
                                                                ?>
                                                                +
                                                                <span class="site-main-text-color"><?php echo number_format($package['single_room_price_a']); ?>
                                                                    <small><?php echo $package['currency_type']; ?></small>
                                                                </span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <select name="SRC<?php echo $countPackage; ?>"
                                                            id="countResponsive1<?php echo $countPackage; ?>" class="select_nor_style"
                                                            onchange="calculatePricesTour('<?php echo $package['id']; ?>', 'countResponsive')">>
                                                        <option selected=""><?php echo functions::Xmlinformation('Countpeople')?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <?php
                                        } ?>


                                        <?php if ($package['double_room_price_r'] > 0) {
                                            $price = $package['double_room_price_r'] + $package['change_price'];
                                            $price = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price);
                                            ?>
                                            <li class="slide slide-40">
                                                <div class="type"><p><?php echo functions::Xmlinformation('TwoBed')?></p>
                                                    <div class="number">
                                                        <div class="main__center">
                                                            <span class="site-main-text-color"><?php echo number_format($price['price']); ?>
                                                                <small><?php echo functions::Xmlinformation('Rial')?></small>
                                                            </span>
                                                            <?php
                                                            if ($package['double_room_price_a'] > 0) {
                                                                ?>
                                                                +
                                                                <span class="site-main-text-color"><?php echo number_format($package['double_room_price_a']); ?>
                                                                    <small><?php echo $package['currency_type']; ?></small>
                                                                    </span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <select name="SRC<?php echo $countPackage; ?>"
                                                            id="countResponsive2<?php echo $countPackage; ?>" class="select_nor_style"
                                                            onchange="calculatePricesTour('<?php echo $package['id']; ?>', 'countResponsive')">>
                                                        <option selected=""><?php echo functions::Xmlinformation('Countpeople')?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <?php
                                        } ?>

                                        <?php if ($package['three_room_price_r'] > 0) {
                                            $price = $package['three_room_price_r'] + $package['change_price'];
                                            $price = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price);
                                            ?>
                                            <li class="slide slide-40">
                                                <div class="type"><p><?php echo functions::Xmlinformation('ThreeBed')?></p>
                                                    <div class="number">
                                                        <div class="main__center">
                                                            <span class="site-main-text-color"><?php echo number_format($price['price']); ?>
                                                                <small><?php echo functions::Xmlinformation('Rial')?></small>
                                                            </span>
                                                            <?php
                                                            if ($package['three_room_price_a'] > 0) {
                                                                ?>
                                                                +
                                                                <span class="site-main-text-color"><?php echo number_format($package['three_room_price_a']); ?>
                                                                    <small><?php echo $package['currency_type']; ?></small>
                                                                    </span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <select name="SRC<?php echo $countPackage; ?>"
                                                            id="countResponsive3<?php echo $countPackage; ?>"  class="select_nor_style"
                                                            onchange="calculatePricesTour('<?php echo $package['id']; ?>', 'countResponsive')">>
                                                        <option selected=""><?php echo functions::Xmlinformation('Countpeople')?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <?php
                                        } ?>

                                        <?php if ($package['child_with_bed_price_r'] > 0) {
                                            $price = $package['child_with_bed_price_r'] + $package['change_price'];
                                            $price = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price);
                                            ?>
                                            <li class="slide slide-40">
                                                <div class="type"><p><?php echo functions::Xmlinformation('Childwithbed')?></p>
                                                    <div class="number">
                                                        <div class="main__center">
                                                            <span class="site-main-text-color"><?php echo number_format($price['price']); ?>
                                                                <small><?php echo functions::Xmlinformation('Rial')?></small>
                                                            </span>
                                                            <?php
                                                            if ($package['child_with_bed_price_a'] > 0) {
                                                                ?>
                                                                +
                                                                <span class="site-main-text-color"><?php echo number_format($package['child_with_bed_price_a']); ?>
                                                                    <small><?php echo $package['currency_type']; ?></small>
                                                                    </span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <select name="SRC<?php echo $countPackage; ?>"
                                                            id="countResponsive4<?php echo $countPackage; ?>" class="select_nor_style"
                                                            onchange="calculatePricesTour('<?php echo $package['id']; ?>', 'countResponsive')">>
                                                        <option selected=""><?php echo functions::Xmlinformation('countpeople')?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <?php
                                        } ?>

                                        <?php if ($package['child_with_bed_price_r'] > 0) {
                                            $price = $package['child_with_bed_price_r'] + $package['change_price'];
                                            $price = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price);
                                            ?>
                                            <li class="slide slide-40">
                                                <div class="type"><p><?php echo functions::Xmlinformation('Babywithoutbed')?></p>
                                                    <div class="number">
                                                        <div class="main__center">
                                                            <span class="site-main-text-color"><?php echo number_format($price['price']); ?>
                                                                <small><?php echo functions::Xmlinformation('Rial')?></small>
                                                            </span>
                                                            <?php
                                                            if ($package['child_with_bed_price_a'] > 0) {
                                                                ?>
                                                                +
                                                                <span class="site-main-text-color"><?php echo number_format($package['child_with_bed_price_a']); ?>
                                                                    <small><?php echo $package['currency_type']; ?></small>
                                                                    </span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <select name="SRC<?php echo $countPackage; ?>"
                                                            id="countResponsive5<?php echo $countPackage; ?>" class="select_nor_style"
                                                            onchange="calculatePricesTour('<?php echo $package['id']; ?>', 'countResponsive')">>
                                                        <option selected=""><?php echo functions::Xmlinformation('Countpeople')?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <?php
                                        } ?>

                                        <?php if ($package['infant_without_bed_price_r'] > 0) {
                                            $price = $package['infant_without_bed_price_r'] + $package['change_price'];
                                            $price = $objResult->calculateDiscountedPrices($package['discount_type'], $package['discount'], $price);
                                            ?>
                                            <li class="slide slide-40">
                                                <div class="type"><p><?php echo functions::Xmlinformation('Babywithoutchair')?></p>
                                                    <div class="number">
                                                        <div class="main__center">
                                                            <span class="site-main-text-color"><?php echo number_format($price['price']); ?>
                                                                <small><?php echo functions::Xmlinformation('Rial')?></small>
                                                            </span>
                                                            <?php
                                                            if ($package['infant_without_bed_price_a'] > 0) {
                                                                ?>
                                                                +
                                                                <span class="site-main-text-color"><?php echo number_format($package['infant_without_bed_price_a']); ?>
                                                                    <small><?php echo $package['currency_type']; ?></small>
                                                                    </span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <select name="SRC<?php echo $countPackage; ?>"
                                                            id="countResponsive6<?php echo $countPackage; ?>" class="select_nor_style"
                                                            onchange="calculatePricesTour('<?php echo $package['id']; ?>', 'countResponsive')">>
                                                        <option selected=""><?php echo functions::Xmlinformation('Countpeople')?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <?php
                                        } ?>

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php

        ?>

        <?php
    } elseif ($typeTourReserve == 'oneDayTour') {

        $Model = Load::library('Model');
        $sql = "
        SELECT
            adult_price_one_day_tour_r, child_price_one_day_tour_r, infant_price_one_day_tour_r, change_price
        FROM
            reservation_tour_tb
        WHERE
            tour_code = '{$tourCode}'
            AND start_date = '{$startDate}'
        ";
        $package = $Model->load($sql);
        ?>
        <div class="bg-white">
            <div class="row" style="width: 100%;">

                <div class="titr-col"><?php echo functions::Xmlinformation('SelectCountPeopleOneDayTour')?></div>
                <div class="box__hotel__price box__color">

                    <div id="bundle-prices-1091333" class="collapse_" aria-expanded="true" style="">
                        <div class="carousel-2">
                            <div class="list">
                                <ul class="slider">

                                    <?php
                                    if ($package['adult_price_one_day_tour_r'] > 0) {
                                        $price_adult = $package['adult_price_one_day_tour_r'] + $package['change_price'];
                                        ?>
                                        <li class="slide slide-40">
                                            <div class="type"><p><?php echo functions::Xmlinformation('Adult')?></p>
                                                <div class="number">
                                                    <div class="main__center">
                                                        <span class="site-main-text-color"><?php echo number_format($price_adult); ?></span>
                                                    </div>
                                                </div>
                                                <select name="adultCountResponsive" id="adultCountResponsive"
                                                        onchange="calculatePricesOnDayTour('yes')">
                                                    <option value="0" selected=""><?php echo functions::Xmlinformation('Count')?></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                </select>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($package['child_price_one_day_tour_r'] > 0) {
                                        $price_child = $package['child_price_one_day_tour_r'] + $package['change_price'];
                                        ?>
                                        <li class="slide slide-40">
                                            <div class="type"><p><?php echo functions::Xmlinformation('Child')?></p>
                                                <div class="number">
                                                    <div class="main__center">
                                                        <span class="site-main-text-color"><?php echo number_format($price_child); ?></span>
                                                    </div>
                                                </div>
                                                <select name="childCountResponsive" id="childCountResponsive"
                                                        onchange="calculatePricesOnDayTour('yes')">
                                                    <option value="0" selected=""><?php echo functions::Xmlinformation('Count')?></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                </select>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if ($package['infant_price_one_day_tour_r'] > 0) {
                                        $price_infant = $package['infant_price_one_day_tour_r'] + $package['change_price'];
                                        ?>
                                        <li class="slide slide-40">
                                            <div class="type"><p><?php echo functions::Xmlinformation('Baby')?></p>
                                                <div class="number">
                                                    <div class="main__center">
                                                        <span class="site-main-text-color"><?php echo number_format($price_infant); ?></span>
                                                    </div>
                                                </div>
                                                <select name="infantCountResponsive" id="infantCountResponsive"
                                                        onchange="calculatePricesOnDayTour('yes')">
                                                    <option value="0" selected=""><?php echo functions::Xmlinformation('Count')?></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                </select>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                </ul>
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
    echo $printTour = ob_get_clean();


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'tourCancellationRequest') {
    unset($_POST['flag']);

    $objController = Load::controller('bookTourShow');
    $result = $objController->tourCancellationRequest($_POST['factorNumber']);
    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'tourConfirmCancellationRequest') {
    unset($_POST['flag']);

    $objController = Load::controller('bookTourShow');
    $result = $objController->tourConfirmCancellationRequest($_POST['factorNumber'], $_POST['cancelPrice']);
    echo $result;


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'successfullyCancel') {
    unset($_POST['flag']);

    $objController = Load::controller('bookTourShow');
    $result = $objController->successfullyCancel($_POST['factorNumber']);
    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'setTourPaymentsPriceA') {
    unset($_POST['flag']);

    $objController = Load::controller('bookTourShow');
    $result = $objController->setTourPaymentsPriceA($_POST['factorNumber'], $_POST['paymentsPriceA']);
    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'getTourCitiesAjax') {
    unset($_POST['flag']);

    $objController = Load::controller('resultTourLocal');
    $city = $objController->getAllCity($_POST['idCountry'], $_POST['tourType'], $_POST['route']);

    if($_POST['route'] == 'return') {
        $list = '<option value="all">'.functions::Xmlinformation('Destinationcity') .' ('.functions::Xmlinformation('All').')</option>';
    }else{
        $list = '<option value="all">'.functions::Xmlinformation('Origincity') .' ('.functions::Xmlinformation('All').')</option>';

    }
    foreach ($city as $val){
        $list .= '<option value="'.$val['id'].'">'.$val['name'].'</option>';
    }

    echo $list;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'getTourRegionAjax') {
    unset($_POST['flag']);

    $objController = Load::controller('resultTourLocal');
    $region = $objController->getAllRegion($_POST['idCity'], $_POST['tourType'], $_POST['route']);

    $list = '<option value="">انتخاب کنید....</option>';
    foreach ($region as $val){
        $list .= '<option value="'.$val['id'].'">'.$val['name'].'</option>';
    }

    echo $list;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'createExcelFile') {
    unset($_POST['flag']);

    $controller = Load::controller('bookTourShow');
    $result = $controller->createExcelFile($_POST);

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'createSelectTourType') {
    unset($_POST['flag']);

    $controller = Load::controller('resultTourLocal');
    $objTour = Load::controller('reservationTour');
    $tour = $objTour->infoTourByIdSame($_POST['idSame']);
    $arrayTourType = json_decode($tour['tour_type_id']);
    $result = '
    <select name="tourTypeId[]" id="tourTypeId" class="select2" multiple="multiple">
    ';

        foreach ($controller->getTourTypes() as $tourType){
            $selected = '';
            if (in_array($tourType['id'], $arrayTourType)){
                $selected = 'selected';
            }
            $result .= '<option value="'.$tourType['id'].'" '.$selected.'>'.(SOFTWARE_LANG == 'fa' ? $tourType['tour_type']:$tourType['tour_type_en']).'</option>';
        }
    $result .= '
    </select>
    ';

    echo $result;

} elseif (isset($_POST['flag']) && $_POST['flag'] == 'deleteAndInertTourType') {
    unset($_POST['flag']);

    $controller = Load::controller('reservationTour');

    if (empty($_POST['tourTypeId']) && $_POST['isOneDayTour'] == 'yes') {
        $_POST['tourTypeId'] = ["1"];
    } elseif (!empty($_POST['tourTypeId']) && $_POST['isOneDayTour'] == 'yes'){
        array_push($_POST['tourTypeId'], "1");
    } elseif (empty($_POST['tourTypeId']) && $_POST['isOneDayTour'] == 'no'){
        $_POST['tourTypeId'] = ["2"];
    } elseif (!empty($_POST['tourTypeId']) && $_POST['isOneDayTour'] == 'no'){
        array_push($_POST['tourTypeId'], "2");
    }
    $result = $controller->editTourTypeWithIdSame($_POST['idSame'], $_POST['tourTypeId']);

    if ($result){
        echo 'success : تغییرات نوع تور با موفقیت انجام شد ';
    } else {
        echo 'error : خطا در  تغییرات';
    }


} elseif (isset($_POST['flag']) && $_POST['flag'] == 'setDiscountTour') {
    unset($_POST['flag']);

    $controller = Load::controller('reservationTour');
    $result = $controller->setDiscountTour($_POST);

    if ($result){
        echo 'success : تغییرات نوع تور با موفقیت انجام شد ';
    } else {
        echo 'error : خطا در  تغییرات';
    }
}
if (isset($_POST['flag']) && $_POST['flag'] == 'orderTourActive') {
    unset($_POST['flag']);

    $result = Load::controller('reservationTour');
    echo $result->orderTourActive($_POST['id']);
}
elseif (isset($_POST['flag']) && $_POST['flag'] == 'getTourCountriesByTypeAjax') {
    unset($_POST['flag']);

    $objController = Load::controller('resultTourLocal');
    $city = $objController->getAllCountry('' , $_POST['route'] , $_POST['tourType']  , $_POST['idCity'] , $_POST['idCountry']);
    if($_POST['route'] == 'return') {
        $list = '<option value="all">'.functions::Xmlinformation('Destinationcountry') .' ('.functions::Xmlinformation('All').')</option>';

    }else{
        $list = '<option value="all">'.functions::Xmlinformation('Origincountry') .' ('.functions::Xmlinformation('All').')</option>';

    }

    foreach ($city as $val){
        $list .= '<option value="'.$val['id'].'">'.$val['name'].'</option>';
    }
    echo $list;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'modalAddRoomCount') {
    unset($_POST['flag']);
    $rowAnyPackage = filter_var($_POST['countPackage'], FILTER_VALIDATE_INT);
    $result = '';
    $result = '<div class="parent-modal centered" id="modal' . $rowAnyPackage . '">
            <div class="head-modal" onclick="closeModalBed()">
               <h3>تعداد تخت ها را مشخص کنید.</h3>
               <div class="parent-xmark">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M393.4 41.4c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3L269.3 256 438.6 425.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 301.3 54.6 470.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 9.4 86.6C-3.1 74.1-3.1 53.9 9.4 41.4s32.8-12.5 45.3 0L224 210.7 393.4 41.4z"/></svg>
                </div>
           </div>
            <div class="body-my-modal">
                    <div class="form-group col-sm-12">
                        <label for="room_count" class="control-label">تعداد تخت</label>
                        <select name="room_count" id="room_count" class="form-control">
                            <option value="">انتخاب کنید</option>
                            <option value="4">'.functions::Xmlinformation("Four").'</option>
                            <option value="5">'.functions::Xmlinformation("Five").'</option>
                            <option value="6">'.functions::Xmlinformation("Six").'</option>
                        </select>
                    </div>
            </div>
            <div class="foot-modal">
                 <button class="btn btn-primary" type="button" onclick="addRoomToPackage(' . $rowAnyPackage . ')">ارسال اطلاعات</button>
            </div>
        </div>';
    echo $result;
}
if (isset($_POST['flag']) && $_POST['flag'] == 'insertRoomToPackage') {
    unset($_POST['flag']);
    $bedCount = $_POST['bedCount'];
    $rowAnyPackage = filter_var($_POST['countPackage'], FILTER_VALIDATE_INT);
    switch ($bedCount) {
        case '4':
            $textNumber =  functions::Xmlinformation('Four');
            break;
        case '5':
            $textNumber =  functions::Xmlinformation('Five');
            break;
        case '6':
            $textNumber =  functions::Xmlinformation('Six');
            break;
        case '7':
            $textNumber =  functions::Xmlinformation('Seven');
            break;
        case '8':
            $textNumber =  functions::Xmlinformation('Eight');
            break;
        case '9':
            $textNumber =  functions::Xmlinformation('Nine');
            break;
        default:
            $textNumber = '';
            break;
    }
    switch ($bedCount) {
        case '4':
            $textNumberInput =  'four';
            break;
        case '5':
            $textNumberInput =  'five';
            break;
        case '6':
            $textNumberInput =  'six';
            break;
        case '7':
            $textNumberInput =  'seven';
            break;
        case '8':
            $textNumberInput =  'eight';
            break;
        case '9':
            $textNumberInput =  'nine';
            break;
        default:
            $textNumberInput = '';
            break;
    }
        $result = '';
        $result .= '';
        $result .= '<div id="customRoomPackage' . $rowAnyPackage . 'R' . $bedCount . '" class="bg-white rounded row-tour-hotel w-100">';
        $result .= '<div class="border-bottom d-flex justify-content-between font-13 font-weight-bolder no-star p-2 py-2 site-bg-color-dock-border text-justify w-100">
                        <span class="tour-price-r">'.functions::StrReplaceInXml(['@@number@@'=> $textNumber],'roomBedInfo').' </span>
                        <button onclick="deleteRoomPackage(\'' . $rowAnyPackage . '\' , '.$bedCount.')" class="btn btn-danger btn-sm font-12 p-1 px-2">
                          <span class="deleteRow fa fa-trash"></span>
                              ' . functions::Xmlinformation('Delete') .'
                        </button>
                    </div>';
        $result .= '<div class="d-flex flex-wrap p-2 py-4 tour-hotel w-100">';
        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="'. $textNumberInput .'RoomPriceR' . $rowAnyPackage . '"
                                data-name="' . $textNumberInput . 'RoomPriceR" 
                                data-values="for"
                                class="flr font-12 text-muted change_counter_js">'.functions::StrReplaceInXml(['@@number@@'=> $textNumber],'Roomcountbed').' ('.functions::Xmlinformation('Riali').'):</label>
                        <input type="text" name="'. $textNumberInput .'RoomPriceR' . $rowAnyPackage . '"
                                data-name="'. $textNumberInput .'RoomPriceR" 
                                data-values="name,id"
                                 class="form-control font-12 change_counter_js" id="'. $textNumberInput .'RoomPriceR' . $rowAnyPackage . '" 
                        onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('PriceRial').'">
                    </div>';
        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="'. $textNumberInput .'RoomPriceA' . $rowAnyPackage . '"
                                data-name="'. $textNumberInput .'RoomPriceA" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::StrReplaceInXml(['@@number@@'=> $textNumber],'Roomcountbed').' ('.functions::Xmlinformation('Arzi').'):</label>
                        <input type="text" name="'. $textNumberInput .'RoomPriceA' . $rowAnyPackage . '"
                                data-name="'. $textNumberInput .'RoomPriceA" 
                                data-values="name,id" id="'. $textNumberInput .'RoomPriceA' . $rowAnyPackage . '"
                              class="form-control font-12 change_counter_js" 
                         onkeypress="isDigit(this)" onkeyup="javascript:separator(this);" placeholder="'.functions::Xmlinformation('ArziPrice').'">
                    </div>';
        $result .= '<div class="col-md-4 mb-3 px-2 no-star width14">
                        <label for="'. $textNumberInput .'RoomCapacity' . $rowAnyPackage . '" 
                                data-name="'. $textNumberInput .'RoomCapacity" 
                                data-values="for" class="flr font-12 text-muted change_counter_js">'.functions::StrReplaceInXml(['@@number@@'=> $textNumber],'Roomcountbed').':</label>
                        <input type="text" name="'. $textNumberInput .'RoomCapacity' . $rowAnyPackage . '"
                                data-name="'. $textNumberInput .'RoomCapacity" 
                                data-values="name,id" id="'. $textNumberInput .'RoomCapacity' . $rowAnyPackage . '"
                        class="form-control font-12 change_counter_js" 
                        onkeypress="isDigit(this)" placeholder="'.functions::Xmlinformation('CapacityRoom').'" value="9">
                    </div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '<div class="clear"></div>';
        echo $result;
}

if (isset($_POST['flag']) && $_POST['flag'] == 'callGetTourPackage') {

    unset($_POST['flag']);
    functions::insertLog('at the beginning', 'load_package_slow');
    $objController = Load::controller('reservationTour');
    $result =   $objController->callGetTourPackage($_POST);
    functions::insertLog('at the end', 'load_package_slow');
    echo $result ;

}

if (isset($_POST['flag']) && $_POST['flag'] == 'getTourById') {

    unset($_POST['flag']);

    $objController = Load::controller('reservationTour');
    echo  $objController->getTourById($_POST);

}
?>