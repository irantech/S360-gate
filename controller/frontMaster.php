<?php

class FrontMaster extends clientAuth
{

    public $page = '';
    public $session_token = '';

    public function __construct()
    {
        parent::__construct();
        $this->session_token = isset($_POST['temporary']) ? $_POST['temporary'] : '';
        $fileName = REQUEST;


        if (strpos(REQUEST, '&')) {
            $fileName = substr(REQUEST, 0, strpos(REQUEST, '&'));
        }

        if (file_exists(FRONT_CURRENT_CLIENT . $fileName . '.tpl')) {

            $this->page = $fileName; // go local or amadeus serch

        } else {
            if (substr_count($fileName, FOLDER_ADMIN)) { // go admin panel
                if (file_exists(FRONT_CURRENT_ADMIN . '/' . ADMIN_FILE . '.tpl')) {
                    $this->page = '../' . ADMIN_DIR . '/' . ADMIN_FILE;
                } else {

                    $this->page = '../' . ADMIN_DIR . '/404';

                }
            } elseif (GDS_SWITCH == 'mainPage') {
                $this->page = GDS_SWITCH;
            }
        }

        if (!empty($this->page) || GDS_SWITCH == 'view') {

             $this->page .= '.tpl';


        } else {
            header('location: ' . ROOT_ADDRESS_WITHOUT_LANG . '/404.shtml');
        }
    }

    public function Title_head()
    {
        $result_Local = Load::controller('resultLocal');

        $temprory_res = array();
        if (!empty($this->session_token)) {
            $temprory_res = $this->getController('temporaryLocal')->getSpecificTemporary($this->session_token);
        }

        switch (GDS_SWITCH) {
            case 'local':

                functions::StrReplaceInXml(['@@origin@@'=>$result_Local->NameCity(SEARCH_ORIGIN),'@@destination@@'=>$result_Local->NameCity(SEARCH_DESTINATION)]);
                $title = 'خرید بلیط هواپیما از ' . $result_Local->NameCity(SEARCH_ORIGIN) . ' ' . 'به' . ' ' .  $result_Local->NameCity(SEARCH_DESTINATION). '|' . CLIENT_NAME;
                break;
            case 'passengersDetailLocal':
                $title = 'خرید بلیط هواپیما ' . $temprory_res['OriginCity'] . ' ' . 'به' . ' ' . $temprory_res['DestiCity'] . ' ' . 'هواپیمایی ' . ' ' . $temprory_res['AirlineName'] . '|' . CLIENT_NAME;
                break;
            case 'factorLocal':
                $title = 'خرید بلیط هواپیما ' . $temprory_res['OriginCity'] . ' ' . 'به' . ' ' . $temprory_res['DestiCity'] . ' ' . 'هواپیمایی ' . ' ' . $temprory_res['AirlineName'] . '|' . ' ' . 'پیش فاکتور' . ' ' . '|' . CLIENT_NAME;
                break;
            case 'roomHotelLocal':
                $hotelNameFa = '';
                if (TYPE_APPLICATION == 'reservation'){
                    $conditions = "id = '".HOTEL_ID."'";
                    $result = functions::getValueFields('reservation_hotel_tb', 'name', $conditions);
                    $hotelNameFa = $result['name'];
                } elseif (TYPE_APPLICATION == 'api') {
                    $conditions = "hotel_id = '".HOTEL_ID."'";
                    $result = functions::getValueFieldsFromBase('hotel_room_prices_tb', 'hotel_name', $conditions);
                    $hotelNameFa = $result['hotel_name'];
                }
                if (!empty($hotelNameFa)){
                    $title = $hotelNameFa . ' | ' . CLIENT_NAME;
                } else {
                    $title = CLIENT_NAME;
                }
                break;
            default :
                $title = CLIENT_NAME;
                break;
        }

        return $title;
    }

}

?>
