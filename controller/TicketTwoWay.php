<?php

//error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//     @ini_set('display_errors', 1);
//     @ini_set('display_errors', 'on');

class TicketTwoWay extends clientAuth
{

    public function __construct() {
        parent::__construct();
    }

    public function createPdfContent($param, $cash, $cancelStatus){

        $resultLocal = Load::controller('resultLocal');


        $conditionCancelStatus = '';
        if (isset($cancelStatus) && $cancelStatus != ''){
            $conditionCancelStatus = " AND report.request_cancel = '{$cancelStatus}' ";
        }


        $info_ticket = $this->getTicketDataByRequestNumber($param, $conditionCancelStatus);



        $ClientId =  CLIENT_ID;
        $agencyController = Load::controller('agency');
        $agencyInfo = $agencyController->infoAgency($info_ticket[0]['agency_id'], $ClientId);

        if($agencyInfo['hasSite'])
        {
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/agencyPartner/' .CLIENT_ID.'/logo/'. CLIENT_LOGO;

        }else{
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
            $StampAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_STAMP;
        }
        $ClientMainDomain = CLIENT_MAIN_DOMAIN;
        $phone = CLIENT_PHONE;
        $ClientAddress = CLIENT_ADDRESS;


        $PhoneManage = CLIENT_MOBILE;
        $AgencyName = CLIENT_NAME;
//    }

        $gender = '';
        $genderEn = '';
        $airplan = '';
        $PrintTicket = '';


        if (!empty($info_ticket)) {

            ob_start();

            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>مشاهده فایل pdf بلیط</title>
                <style type="text/css">
                    .divborder {
                        border: 1px solid #CCC;
                    }

                    .divborderPoint {
                        border: 1px solid #CCC;
                        background-color: #FFF;
                        border-radius: 5px;
                        z-index: 100000000;
                        width: 200px;
                        padding: 5px;
                        margin-right: 20px;
                    }

                    .page td {
                        padding: 0;
                        margin: 0;
                    }

                    .page {
                        border-collapse: collapse;
                    }

                    @font-face {
                        font-family: "Yekan";
                        font-style: normal;
                        font-weight: normal;
                        src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
                        url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
                        url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");

                    }

                    table {
                        font-family: Yekan !important;
                        border-collapse: collapse;
                    }

                    table.solidBorder, .solidBorder th, .solidBorder td {
                        border: 1px solid #CCC;
                    }

                    .element:last-child {
                        page-break-after: auto;
                    }
                </style>

            </head>
            <body>
            <?php

            foreach ($info_ticket as $key=>$info) {

                $routes = $this->getModel('bookRoutesModel')->get()->where('RequestNumber',$info['request_number'])->all();

                if ($info['passenger_age'] == "Adt") {
                    $infoAge = 'بزرگسال';
                } else if ($info['passenger_age'] == 'Chd') {
                    $infoAge = 'کودک';
                } else if ($info['passenger_age'] == 'Inf') {
                    $infoAge = 'نوزاد';
                }
                if ($info['passenger_gender'] == 'Male') {
                    $gender = ' آقای';
                    $genderEn = 'Mr';
                } else if ($info['passenger_gender'] == 'Female') {
                    $gender = ' خانم';
                    $genderEn = 'Ms';
                }

                if ($info['flight_type'] == '' || $info['flight_type'] == 'charter') {
                    $flight_type = 'چارتری';
                } else if ($info['flight_type'] == 'system') {
                    $flight_type = 'سیستمی';
                }

                if (($info['seat_class'] == 'C' || $info['seat_class'] == 'B')) {
                    $seat_class = 'بیزینس';
                } else {
                    $seat_class = 'اکونومی';
                }

                $CabinType = $info['cabin_type'];

                $Price = '0';
                if (functions::TypeUser($info['member_id']) == 'Ponline') {
                    $Price = functions::CalculateDiscountOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
                    $PriceWithOut = 0;
                } else if (functions::TypeUser($info['member_id']) == 'Counter') {
                    $Price = functions::CalculatePriceTicketOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
                    $PriceWithOut = functions::CalculateDiscountOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
                }

                $AddOnPrice = ((!empty($info['amount_added']) && $info['amount_added'] > 0) ? $info['amount_added'] : '0');
                $priceTotal = $Price + $AddOnPrice;
                $priceTotalWithOutDiscount = $PriceWithOut + $AddOnPrice;


                $cancelTicketPrice = 0;



                $picAirline = functions::getAirlinePhoto($info['airline_iata']);
                $airlineName = functions::InfoAirline($info['airline_iata']);
                // $price = functions::CalculateDiscountOnePerson($info['request_number'], $info['passenger_national_code'] == '0000000000' ? $info['passenger_national_code'] : $info['passportNumber'], 'yes');
                $airplan = 'https://safar360.com/gds/view/client/assets/images/air.png';


                foreach ($routes as $key=>$route) {
                    ?>
                  <div  style="<?php echo ($key==0) ? 'margin-top: 1000px' : 'margin-top: 30px' ?>">
                    <table width="100%" align="center" style="margin: 20px 100px 20px 100px ; border: 1px solid #CCC;   " cellpadding="0" cellspacing="0"
                           class="page">

                      <tr>
                        <td style="width: 30%; text-align: center; padding-bottom: 5px; " valign="bottom">

                          <table>
                            <tr>
                              <td><img src="<?php echo $LogoAgency ?>" height="100" style="max-width: 230px;"></td>
                            </tr>
                          </table>

                        </td>
                        <td style="width: 70%;">
                          <table style="" cellpadding="0" cellspacing="0" class="page">
                            <tr>
                              <td style="width: 100%; color: #FFF; height: 120px; " colspan="2">
                                sdfsdfsdfasddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
                                asdsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                                asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                                asdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddsd
                              </td>
                            </tr>
                            <tr>
                              <td style="border: 1px solid #CCC; font-size: 20px; font-weight: bolder; padding: 10px ; border-left: none;"
                                  width="50%">
                                <span style="float:right;"><?php //echo $gender . ' ' . $info['passenger_name'] . ' ' . $info['passenger_family'] ?> </span>
                              </td>
                              <td width="50%"
                                  style=" border: 1px solid #CCC; font-size: 20px;  font-weight: bolder; padding: 10px ; text-align: left; border-right: none; direction:ltr">
                                <span style="float:left;text-align: left"><?php echo '(' . $genderEn . ')' . $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] ?></span>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>

                        <td style="width: 30%;  border: 1px solid #CCC;" align="center">
                          <table style="width: 100%" cellpadding="0" cellspacing="0" class="page">
                            <tr style="border-bottom: 1px solid #CCC">
                              <td width="280px" align="center" style="border-bottom: 1px solid #CCC">
                                <table cellpadding="0" cellspacing="0" class="page">
                                  <tr>
                                    <td align="center">
                                      <img src="<?php echo $picAirline ?>" style="float:right; width: 50px;margin-top: 0px; margin-right:10px">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td align="center" style="float: right; font-size: 18px; margin-bottom: 10px;">
                                        <?php echo "هواپیمایی {$airlineName['name_fa']}";?>
                                    </td>
                                  </tr>
                                </table>


                              </td>
                            </tr>
                            <tr>
                              <td>
                                <table style="width: 100%" cellpadding="0" cellspacing="0" class="page">
                                  <tr style="">
                                    <td width="140" height="35" align="right"
                                        style="padding: 5px; border-bottom: 1px solid #CCC ">
                                      <span style="float: right;font-size: 11px;  color:#006cb5; position: relative; right: 0;">پرواز</span>
                                      <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                      <span style="float: left ; position: relative; left: 0;"><?php echo $route['FlightNumber']; ?></span>
                                    </td>

                              </td>
                              <td width="140" align="center"
                                  style="padding: 5px; border-right: 1px solid #CCC;  border-bottom: 1px solid #CCC">
                                <span style="float: right;"><?php echo $seat_class ?></span>
                                <span style="float: left;"><?php echo '(' . $info['cabin_type'] . ' )' ?></span>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" height="35" align="right"
                                  style="padding: 5px ; border-bottom: 1px solid #CCC" width="280">
                                  <?php echo !empty($info['eticket_number']) ? '<span style="float: right; font-size: 11px;  color:#006cb5 ;text-align: right">شماره بلیط</span>' : ''; ?>
                                <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <span style="float: left;"><?php echo !empty($info['eticket_number']) ? $info['eticket_number'] : '' ?> </span>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center" style="padding: 20px 10px" width="280">
                                <img src="https://safar360.com/gds/library/barcode/barcode_creator.php?barcode=<?php echo trim($info['eticket_number']) ?>"
                                     style="max-width: 100px; min-height: 50px">
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                    </td>

                    <td style="width: 70%; border: 1px solid #CCC; border-right:none ; border-top:none; vertical-align: top">

                      <table style="width: 100%;border:1px solid #CCC" cellpadding="0" cellspacing="0" class="page" border="0"
                             valign="top">
                        <tr>
                          <td style="border-left: 1px solid #CCC;" width="450">
                            <table style="width: 100%;" cellpadding="0" cellspacing="0" class="page" border="0">
                              <tr>
                                <td>
                                  <table style="width: 100%; font-size: 20px" cellpadding="0" cellspacing="0"
                                         class="page" border="0">
                                    <tr>
                                      <td width="200" height="70" align="center" valign="middle"
                                          style="font-size: 25px">
                                          <?php echo $route['OriginCity']; ?>
                                      </td>
                                      <td width="50" align="center" valign="middle">
                                        <img src="<?php echo $airplan ?>"
                                             style="float:right; max-height:30px;"/>
                                      </td>
                                      <td width="200" align="center" valign="middle" style="font-size: 25px">
                                          <?php echo $route['DestinationCity']; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="200" height="70" align="center" valign="middle"
                                          style="font-size: 15px">
                                          <?php echo ' فرودگاه '.$route['OriginCity']; ?>
                                      </td>
                                      <td width="50" align="center" valign="middle">
<!--                                        <img src="<?php echo $airplan ?>"
                                             style="float:right; max-height:30px;"/>-->
                                      </td>
                                      <td width="200" align="center" valign="middle" style="font-size: 15px">
                                          <?php echo  ' فرودگاه '.$route['DestinationCity']; ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="200" height="30" align="center" valign="middle"
                                          style="font-size: 25px">
                                          <?php echo substr($route['DepartureTime'], 0, 5 ); ?>
                                      </td>
                                      <td width="50" align="center" valign="middle">

                                      </td>
                                      <td width="200" align="center" valign="middle" style="font-size: 25px">
                                          <?php echo  substr($route['ArrivalTime'], 0, 5 ); ?>
                                      </td>
                                    </tr>
                                    <tr style="padding-top:20px">
                                      <td width="200" align="center" valign="middle" style="font-size: 15px">
                                          <?php $date = functions::OtherFormatDate($route['DepartureDate']);

                                          echo   $date['LetterDay'].'<br/>'.$date['DepartureDate']   ;
                                          ?>
                                      </td>
                                      <td width="50" align="center" valign="middle">

                                      </td>
                                      <td width="200" align="center" valign="middle" style="font-size: 15px;">
                                          <?php $date = functions::OtherFormatDate($route['ArrivalDate']);

                                          echo   $date['LetterDay'].'<br/>'.$date['DepartureDate']   ;
                                          ?>
                                      </td>
                                    </tr>

                                  </table>
                                </td>
                              </tr>

                            </table>
                          </td>

                          <td width="210" height="100%">
                            <table style="width: 100%" cellpadding="0" cellspacing="0" class="page" border="0">
                              <tr style="border-bottom: 1px solid #CCC">
                                <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                                    height="50">
                                  <span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">ملیت</span>
                                  <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                  <span style="float: left ; position: relative; left: 0;"><?php echo functions::country_code(($info['passportCountry'] != 'IRN' && $info['passportCountry'] != '' ? $info['passportCountry'] : 'IRN'), 'fa') ?></span>
                                </td>
                              </tr>
                              <tr style="border-bottom: 1px solid #CCC">
                                <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC "
                                    height="50">
                                  <span style="float: left;font-size: 11px;  color:#006cb5 ; text-align: left">رده سنی</span>
                                  <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                  <span style="float: left ; position: relative; left: 0;"><?php echo $infoAge ?></span>
                                </td>
                              </tr>
                              <tr style="border-bottom: 1px solid #CCC">
                                <td width="160" align="right" style="padding: 5px; border-bottom: 1px solid #CCC;"
                                    height="50">
                                  <span><?php echo !empty($info['pnr']) ? $info['pnr'] : '' ?></span>
                                  <span style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <?php echo !empty($info['pnr']) ? '<span style="font-size: 11px;  color:#006cb5;">PNR</span>' : ''; ?>
                                </td>
                              </tr>
                              <tr style="border-bottom: 1px solid #CCC">
                                <td width="160" align="right" height="50" style="padding-right: 5px">
                                  <span style="float: right;font-size: 11px;  color:#006cb5; ">نوع پرواز</span>
                                  <span style="float: left ; position: relative; left: 0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <?php echo $flight_type;   ?>

                                </td>
                              </tr>

                            </table>
                          </td>
                        </tr>
                        <tr>
                            <?php

                            $check_client_configuration = functions::checkClientConfigurationAccess('show_flight_pdf_date',CLIENT_ID);

                            ?>
                          <td <?php if (!$check_client_configuration) {
                              echo 'colspan="2"';
                          } ?> style="padding: 10px; border-top: 1px solid #CCC ">
                            <span style="float: right; font-size: 11px; color:#006cb5;">شماره رزرو</span>
                            <span></span>
                            <span style="float: left; margin-right: 20px; font-size: 17px;"><?php echo $info['request_number'] ?> </span>
                            <span style="float: right; font-size: 11px; color:#006cb5;"> رزرو شده در  </span>
                            <span><?php echo $AgencyName ?></span>
                          </td>


                            <?php

                            $check_client_configuration= functions::checkClientConfigurationAccess('show_flight_pdf_date',CLIENT_ID);
                            if($check_client_configuration){
                                ?>
                              <td colspan="1" style="padding: 10px; border-top: 1px solid #CCC ">

                                <span style="float: right; font-size: 11px; color:#006cb5;"> در تاریخ </span>
                                <span style="direction:rtl !important;"><?php echo functions::printDateIntByLanguage('Y-m-d (H:i)',$info['creation_date_int'],SOFTWARE_LANG) ?></span>
                              </td>
                            <?php } ?>
                        </tr>
                      </table>

                    </td>
                    </tr>

                    </table>

                  </div>
                  <?php
                }
                ?>
              <div class="divborder" style="margin: 50px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '150px':'100px'?> 100px ;">
                <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint">قیمت</div>
                <table width="100%" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td></td>
                  </tr>

                  <tr>
                    <td style="padding: 20px;" width="80%">
                      قیمت پرداخت شده
                    </td>
                    <td style="padding: 20px;" width="20%">
                      <?php
                      if (functions::TypeUser($info['member_id']) == 'Counter') {
                          if ($info['percent_discount'] > 0) {
                              echo '<span style="float: left ; position: relative; left: 0; text-decoration: line-through">' . number_format($priceTotal) . ' ریال</span> ';
                              echo '<br/>';
                              echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotalWithOutDiscount) . ' ریال</span> ';
                          } else {
                              echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotal) . ' ریال</span> ';
                          }
                      }else{
                          echo '<span style="float: left ; position: relative; left: 0;">' . number_format($priceTotal) . ' ریال</span> ';
                      }

                      ?>
                    </td>
                  </tr>

                </table>
              </div>

                <?php
                if ($info['request_cancel'] != 'confirm' && ($info['successfull'] == 'book' || $info['successfull'] == 'private_reserve')){
                    ?>
                    <div class="divborder" style="margin: 50px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '150px':'100px'?> 100px ;">
                        <div style="font-size: 19px ; color: #006cb5; margin-top: -20px" class="divborderPoint"> به نکات زیر توجه
                            نمایید:
                        </div>
                        <table width="100%" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td></td>
                            </tr>

                            <tr>
                                <td style="padding-bottom: 20px; padding-right: 20px">
                                    <ul>
                                        <li>هزینه های کنسلی طبق قوانین ایرلاین محاسبه میگردد</li>
                                        <li> مسافر گرامی، شما می بایستی 2 ساعت قبل از زمان پرواز در فرودگاه حضور داشته باشید.</li>
                                        <li>حتما 2 ساعت قبل از پرواز در فرودگاه حاضر باشید</li>
                                        <li> در صورت ایجاد هرگونه محدودیت در پذیرش مسافر، این شرکت هیچگونه مسئولیتی در این خصوص نخواهد داشت و کلیه خسارات متوجه خریدار می باشد
                                        </li>

                                    </ul>

                                </td>

                            </tr>

                        </table>
                    </div>
                    <?php
                }
                ?>




                <div style="position:fixed;  bottom: 0 ; ">
                    <?php if($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/'){ ?>
                        <div style='width: 90%' >
                            <img src="<?php echo $StampAgency ?>" height="100" style="max-width: 230px; float: left; margin: 0 -50px 0 0">
                        </div>
                    <?php } ?>
                    <hr style="margin: <?php echo ($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/') ? '10px' : '100px';?> 100px 5px 100px ; width: 90%"/>
                    <table width="100%" align="center" style="width:100%; margin: 10px 100px <?php echo ($info['request_cancel'] !='confirm' && $cash=='no') ? '20px' : '10px'?> 50px ;    font-size: 17px" scellpadding="0"
                           cellspacing="0">

                        <tr>
                            <td>
                                وب سایت :
                                <?php echo $ClientMainDomain; ?>

                            </td>
                            <td> تلفن پشتیبانی :
                                <?php echo $phone; ?>
                            </td>
                            <?php if($info_ticket[0]['agency_id']) {?>
                                <td> تلفن کانتر فروش :
                                    <?php echo $PhoneManage; ?>
                                </td>
                            <?php  } ?>
                        </tr>
                        <tr>
                            <td colspan="2">
                                آدرس :
                                <?php echo $ClientAddress; ?>

                            </td>
                        </tr>

                    </table>

                </div>
            <?php  } ?>
            </body>
            </html>
            <?php
        } else {
            echo '<div style = "text-align:center ; fon-size:20px ;font-family: Yekan;" > اطلاعات مورد نظر موجود نمی باشد </div > ';
        }

        return $PrintTicket = ob_get_clean();
    }

    public function getTicketDataByRequestNumber($request_number, $conditionCancelStatus = null)
    {
        $model = Load::library('Model');

        //$query = "SELECT * FROM book_local_tb WHERE  request_number='{$request_number}' AND (successfull='book' OR successfull='private_reserve')";
         $query = "SELECT  book.* FROM book_local_tb as book 
                 WHERE book.request_number='{$request_number}'";


        return $model->select($query);
    }


}