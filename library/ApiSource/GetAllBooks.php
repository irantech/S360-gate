<?php

require '../../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

class GetAllBooks
{

    public function __construct()
    {
        $domainName = $_SERVER["HTTP_HOST"];
        $this->GetSuccessRecords($domainName);
    }

    public function GetSuccessRecords($domain)
    {

        $admin = Load::controller('admin');
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        
        $SqlClient = "SELECT * FROM clients_tb WHERE Domain='{$domain}'";
        $result = $ModelBase->load($SqlClient);

        if (!empty($result)) {


            $sql = "SELECT id, CONCAT(name ,' ',family) AS name , card_number FROM members_tb WHERE is_member='1'";

            $res = $admin->ConectDbClient($sql, $result['id'], "SelectAll");
            $bookArray = array();
            $i = 0;
            
            foreach ($res as $item) {

                $bookArray[$i]['card_no'] = $item['card_number'];
                $bookArray[$i]['name'] = $item['name'];

                $sqlBook = " SELECT * FROM book_local_tb WHERE member_id='{$item['id']}' AND successfull = 'book' GROUP BY request_number";
                $resultBook = $admin->ConectDbClient($sqlBook, $result['id'], "SelectAll");

                if ($resultBook) {
                    
                    Load::autoload('apiLocal');
                    $apiLocal = new apiLocal();
                    $j = 0;
                    foreach ($resultBook as $book) {

                        $bookArray[$i]['books'][$j]['reserve_code'] = $book['request_number'];
                        $bookArray[$i]['books'][$j]['reserve_date'] = substr($book['payment_date'], 0, 10);
                        $bookArray[$i]['books'][$j]['reserve_type'] = functions::detectFlight($book['origin_airport_iata'],$book['desti_airport_iata']) == '0' ? 'پرواز داخلی' : 'پرواز خارجی';
                        $bookArray[$i]['books'][$j]['reserve_origin'] = $book['origin_city'];
                        $bookArray[$i]['books'][$j]['reserve_destination'] = $book['desti_city'];
                        $bookArray[$i]['books'][$j]['reserve_price'] = functions::CalculateDiscount($book['request_number'], ($book['flight_type'] == 'charter' ? 'yes' : 'no'));
                        $bookArray[$i]['books'][$j]['score'] = functions::CalculatePoint($bookArray[$i]['books'][$j]['reserve_price'], functions::detectFlight($book['origin_airport_iata'],$book['desti_airport_iata']));
                        $bookArray[$i]['books'][$j]['bonusAmount'] = functions::CalculateBonusAmount($bookArray[$i]['books'][$j]['score'], functions::detectFlight($book['origin_airport_iata'],$book['desti_airport_iata']));

                        $j++;
                    }
                } else{
                    $bookArray[$i]['books'] = array();
                }
                
                $i++;
            }

            echo json_encode($bookArray);

        }
        else
        {
            echo 'کاربر مورد نظر وجود ندارد';
        }
    }

}

new GetAllBooks();