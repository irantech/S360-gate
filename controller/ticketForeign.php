<?php
/**
 * Class ticketForeign
 * @property ticketForeign $ticketForeign
 */
class ticketForeign extends apiLocal
{
    public function __construct()
    {

    }


    public function createPdfContent($param , $cash)
    {
        //        if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//            var_dump('aaaaa');
//            die();
//        }
        $airline_model = $this->getModel('airlineModel') ;

        $agencyController = Load::controller('agency');
        if (TYPE_ADMIN == '1') {
            Load::autoload('ModelBase');
            $ModelBase = new ModelBase();
            $sql = "select * from report_tb where request_number='{$param}' AND (successfull='book' OR successfull='private_reserve')";
            $info_ticket = $ModelBase->select($sql);
        } else {
            $info_ticket = $this->getTicketDataByRequestNumber($param);
        }
        $sqlAirline = "SELECT * FROM airline_tb WHERE abbreviation = '".$info_ticket[0]['airline_iata']."'";
        $infoAirline =  $airline_model->select($sqlAirline);
functions::insertLog(json_encode($infoAirline) , '000shojaee');
        $DetailsTicket = functions::infoDetailsForeign($param);
        $ClientId = (!empty($info_ticket[0]['client_id']) && ($info_ticket[0]['client_id'] == '79')) ? $info_ticket[0]['client_id'] : CLIENT_ID;
        if($ClientId=='79')
        {
            $LogoAgencyPic =(!empty($info_ticket[0]['agency_id']) && ($info_ticket[0]['agency_id'] > 0) && !empty($agencyInfo['domain'])) ? (!empty($agencyInfo['logo']) ? $agencyInfo['logo'] :'') : CLIENT_LOGO;
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG.'/pic/'. $LogoAgencyPic;

        }else{
            $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG.'/pic/'. CLIENT_LOGO;
        }

        $StampAgency = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_STAMP;
        $ClientMainDomain = CLIENT_MAIN_DOMAIN;
        $phone = CLIENT_PHONE;
        $ClientAddress = CLIENT_ADDRESS;


        $PhoneManage = CLIENT_MOBILE;
        $AgencyName = CLIENT_NAME;
        
        $alarm_message = explode('/',$info_ticket[0]['supplier_address']);
        $agency_info = $agencyController->infoAgency($info_ticket[0]['agency_id'], $ClientId);
        if (!empty($info_ticket)) {

            ob_start();
            ?>

            <!DOCTYPE html>
            <html>
            <head>
                <title>ticket PDF Flight</title>
                <style type="text/css">
                    /
                    /
                    tr td {
                    / / border: 1 px solid #000;
                    / /
                    }

                    .divborder {
                        border: 1px solid #CCC;
                    }

                    .divborderPoint {
                        border: 1px solid #CCC;
                        border-radius: 5px;
                        z-index: 10000000000000;
                        width: 350px;
                        padding: 10px;
                        margin-left: 20px;
                        color: #006cb5 !important;
                    / / float: left;
                        margin-right: 480px;
                        background-color: #FFFFFF;
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
                    }

                    .element:last-child {
                        page-break-after: auto;
                    }

                    .textRed{
                        color:#ee384e
                    }
                </style>
            </head>
        <body>

            <?php

            foreach ($info_ticket as $info) {

                ?>
                <table width="100%" align="center" style="margin: 10px 100px " cellpadding="0" cellspacing="0"
                       class="page">

                    <tr>
                        <td style="padding: 5px; ">
                            <img src="<?php echo $LogoAgency; ?>" style="max-width: 150px">
                        </td>
                    </tr>
                    <tr style="background-color: #CCC; ">
                        <td style="padding: 5px;" colspan="2" align="left">
                            Electronic Ticket - pnr : <?php echo $info['pnr'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 5px;" align="left" width="80%">
                            <?php echo $info['passenger_name_en'] . ' ' . $info['passenger_family_en'] ?>
                        </td>
                        <td style="padding: 5px;" align="left" width="20%">
                            :Traveller
                        </td>

                    </tr>

                    <?php if($info['api_id'] != '16'){?>
                      <tr>
                        <td style="padding: 5px;" align="left" width="80%">
                            <?php echo $info['eticket_number']; ?>
                        </td>
                        <td style="padding: 5px;" align="left" width="20%">
                            :E-TicketNumber
                        </td>
                      </tr>
                    <?php } ?>



                    <tr>
                        <td style="padding: 5px;" align="left" width="80%">
                            <?php echo date('Y M d', strtotime($info['creation_date'])); ?>
                        </td>
                        <td style="padding: 5px;" align="left" width="20%">
                            :Date Of issue
                        </td>

                    </tr>

                    <tr>
                        <td style="padding: 5px;" align="left" width="80%">

                            <?php
                            if ($cash == 'no') {
                                echo 'cashe';
                            }else{
                                $PriceTicket = functions::CalculateDiscountOnePerson($info['request_number'],$info['passportNumber']) ;


                                $AddOnPrice = ((!empty($info['amount_added']) && $info['amount_added'] > 0) ? $info['amount_added'] : '0');
                                if($agency_info['type_payment'] == 'currency' && !empty($agency_info)){
                                    /** @var currencyEquivalent $currency_equivalent_controller */
                                    $currency_equivalent_controller = Load::controller('currencyEquivalent');
                                    $priceTotal = functions::ticketPriceCurrency($PriceTicket,$info['currency_equivalent']) +  $AddOnPrice ;
                                    $info_currency =  $currency_equivalent_controller->InfoCurrency($info['currency_code']);
                                    $title_currency = $info_currency['CurrencyTitleEn'];
                                }else{

                                    if(ISCURRENCY == '1' &&  empty($agency_info))
                                    {
                                        $price = functions::CurrencyCalculate($PriceTicket );
                                        $priceTotal = $price['AmountCurrency'] + $AddOnPrice;
                                        $title_currency = $price['TypeCurrency'];

                                    }else{
                                        $priceTotal = $PriceTicket + $AddOnPrice ;
                                        $title_currency='';
                                    }

                                }

                                echo  (Session::getCurrency() && ISCURRENCY == '1') ? number_format($priceTotal,2)  :  number_format($priceTotal);
                                echo ' ';
                                echo   (($title_currency =="") ? 'IRR' : $title_currency);
                            }

                             ?>
                        </td>
                        <td style="padding: 5px;" align="left" width="20%">
                            :Price
                        </td>

                    </tr>


                </table>

                <table width="100%" align="left" style="margin: 10px 100px " cellpadding="0" cellspacing="0"
                       class="page">
                    <tr style="background-color: #CCC; ">
                        <td style="padding: 5px;" colspan="5" align="left">
                            flight Details
                        </td>
                    </tr>
                    <?php foreach ($DetailsTicket as $key => $detail) {
                        ?>
                        <tr>
                            <td style="padding: 5px;" align="left">
                                <table align="left" width="100%">
                                    <tr>
                                        <td>
                                            <?php echo $detail['OriginAirportIata'] . ' ' . 'To' . ' ' . $detail['DestinationAirportIata'] . ' ' . 'on' . ' ' . date('Y M d', strtotime($detail['DepartureDate'])) ; ?>
                                        </td>
                                    </tr>
                                </table>

                                <table align="left" width="100%">
                                    <tr>


                                        <td style="padding: 5px;" width="20%">
                                            <?php
                                            echo 'Baggage:' . ' ' . functions::baggageTitle($info,$detail,'Ticket');
                                            ?>
                                        </td>
                                        <td style="padding: 5px;" width="20%">
                                            <?php
                                            echo 'Cabin/Class:' . ' ' . $detail['CabinType'] . '/' . (($info_ticket[0]['seat_class'] == 'B' || $info_ticket[0]['seat_class'] == 'C') ? 'Business' : 'Economy');
                                            ?>
                                        </td>
                                        <td style="padding: 5px;" width="20%">
                                            <?php
                                            echo 'FlightNumber/Aircraft:' . ' ' . $detail['FlightNumber'] . '/' . $detail['AircraftName'];
                                            ?>
                                        </td>

                                        <td style="padding: 5px;" width="25%" align="left">
                                            <?php
                                            echo 'Airline:' . ' ' . $this->InfoAirline($detail['Airline_IATA']) . '-' . $detail['Airline_IATA'] ;
                                            ?>
                                        </td>
                                        <td style="padding: 5px;" width="10%" align="left">
                                            <img src="<?php
                                            echo functions::getAirlinePhoto($detail['Airline_IATA']);
                                            ?>"
                                                 style="width: 50px ; height: 30px; border: 1px solid #ccccff; border-radius:3mm / 3mm">
                                        </td>

                                    </tr>
                                </table>

                                <table align="left" width="100%" style="border-bottom: 1px solid #ccccff">
                                    <tr>
                                        <?php if ($info['api_id'] == '16'){?>
                                            <td style="padding: 5px;" width="20%">
                                                <?php
                                                echo 'pnr:' . ' ' . (($detail['TypeRoute']=='Dept') ? $info['pnr']: $info['pnr_return']);
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td style="padding: 5px;" width="15%" align="left">
                                            <?php
                                            echo 'Time:' . ' ' . $detail['DepartureTime'];
                                            ?>
                                        </td>
                                        <td style="padding: 5px;" width="15%" align="left">
                                            <?php
                                            echo 'Date:' . ' ' . date('Y M d', strtotime($detail['DepartureDate']));
                                            ?>
                                        </td>
                                        <td style="padding: 5px;" width="<?php echo $info['api_id']=='16' ? '50%' : '70%'?>" align="left">
                                            <?php $Airport = functions::NameCityForeign($detail['OriginAirportIata']);

                                            echo 'Departure:' . ' ' . $Airport['AirportEn'] . '-' . $detail['OriginAirportIata'] . ',' . $Airport['DepartureCityEn'] . ',' . $Airport['CountryEn'] ;
                                            ?>
                                        </td>


                                    </tr>
                                    <tr>
                                        <?php if ($info['api_id'] == '16'){?>
                                            <td style="padding: 5px;" width="20%">
                                                <?php
                                                echo 'ETicketNumber:' . ' ' . (($detail['TypeRoute']=='Dept') ? $info['eticket_number']: $info['eticket_number_return']);
                                                ?>
                                            </td>
                                        <?php } ?>
                                        <td style="padding: 5px;" width="<?php echo $info['api_id']=='16' ? '15%' : '25%'?>" align="left">
                                            <?php
                                            echo 'Time:' . ' ' . $detail['ArrivalTime'];
                                            ?>
                                        </td>
                                        <td style="padding: 5px;" width="<?php echo $info['api_id']=='16' ? '15%' : '25%'?>" align="left">
                                            <?php
                                            echo  !empty($detail['ArrivalDate']) ? 'Date:' . ' ' .  date('Y M d', strtotime($detail['ArrivalDate'])) : '';
                                            ?>
                                        </td>
                                        <td style="padding: 5px;" width="50%" align="left">
                                            <?php $Airport = functions::NameCityForeign($detail['DestinationAirportIata']);

                                            echo 'Arrival:' . ' ' . $Airport['AirportEn'] . '-' . $detail['DestinationAirportIata'] . ',' . $Airport['DepartureCityEn'] . ',' . $Airport['CountryEn'] ;
                                            ?>
                                        </td>


                                    </tr>
                                </table>

                            </td>


                        </tr>
                        <?php
                    } ?>
                </table>
                <table width="100%" align="center" style="margin: 10px 100px;"
                       cellpadding="0" cellspacing="0" class="page">

                    <tr style="background-color: #CCC; ">
                        <td style="padding: 5px;" align="left">
                            Fare Conditions
                        </td>
                    </tr>
                    <tr style=" ">
                        <td style="padding: 5px;" align="left">
                            <p class="textRed">-<?php echo $alarm_message[1]?></p>
                            <p>-Cancellation charges shall be as per airline rules. Service charge is applicable for issue, change, refund.</p>
                            <br/>
                            <p>-Date change charges as applicable.</p>
                            <br/>
                            <p>E-Ticket Notice</p>
                            <br/>
                            <p>Carriage and other service provided by the carrier are subject to terms & conditions of carriage. These conditions may be obtained from the
                                respective carrier.</p>
                            <br/>
                            <p>check-in Time</p>
                            <br/>
                            <p>We Recommend the following minimum check-in time:- Domestic - 2 hour prior to departure. All other destinations (i---ding USA) -4 hours prior to
                                departure.</p>
                            <br/>
                            <p>Passport/Visa/Health</p>
                          
                            <p>Please ensure that you have all the required travel documents for your entire journey i.e., valid Passport & necessary visas, and that you have had the
                                recommended inoculations for your destination(s).
                                Insurance</p>

                            <p>We strongly recommend that you avail travel insurance for the antire journey.</p>

                            <p>Online check  in mandatory</p>

                            <p>UKraine International Airlines require you to do a mandatory online Check-in up to 24 hours prior to departure. UKrain International
                                Airlines can charge 60 EUR or more passenger for not carrying an online boarding pass to the check-in counter. Please contact us 24
                                hours prior to departure with a copy of the passport to complete online check-in. We will take no responsibility if the UKraine International
                                Airlines check-in counter denies boarding or charges any additional fee for not carrying an online boarding pass. Please contact us for your
                                boarding pass.</p>


                           <?php   $ikaAirportEn = (
                               $info['origin_airport_iata'] === 'IKA' ||
                               $info['desti_airport_iata'] === 'IKA'
                           ) ? 'Imam Khomeini' : '';

                           ?>


                    <?php  if ($info['origin_airport_iata'] == 'IKA'){ ?>
                          <p style="font-weight:bold !important;">
                             This flight departs from the terminal  <?=   $infoAirline[0]['out_ika'] . ' ' . $ikaAirportEn ?> It takes place.
                          </p>
                        <?php }  if ($info['desti_airport_iata'] == 'IKA'){ ?>
                          <p style="font-weight:bold !important;">
                             This flight departs from the arrivals terminal  <?=  $infoAirline[0]['enter_ika'] . ' ' . $ikaAirportEn ?> It takes place.
                          </p>
                  <?php } ?>

                            <br/>
                        </td>
                    </tr>


                </table>


                <table width="100%" align="center" style="margin: 10px 100px ;border:1px solid #6c6c6c  "
                       cellpadding="0" cellspacing="0" class="page">

                    <tr style=" ">
                        <td style="padding: 5px;" align="right">
                            <p>کاربر گرامی لطفا به نکات زیر توجه فرمائید:</p>
                            <br/>
                            <p>این سیستم امکان تهیه بلیط هواپیما در تمام دنیا را برای مسافران محترم فراهم نموده است؛
                                اعتبار بلیط صادره را تضمین نموده و از سوی دیگر بررسی صحت مدارک لازمه سفر جهت ورود به
                                کشور مقصد و یا نقطه میانی (ترانزیت)از قبیل دارا بودن دو طرفه ،واچر هتل انواع ویزا و سایر
                                مدارک و فرم های مورد نیاز و محدودیت های گمرکی ،ارزی و ... به عمده مسافر می باشد</p>
                            <br/>
                            <p>انقضا پاسپورت شما بایستی 180 روز از تاریخ برگشت اعتبار داشته باشد</p>
                            <br/>
                            <p>در صورتی که پرواز شما از ایرلاین اوکراینی  میباشد،برای استفاده از این بلیط باید 24 ساعت قبل از پرواز از طریق وب سایت ایرلاین مذکور اقدام به
                                دریافت کارت پرواز خود نموده و برگه پرینت شده را حتما همراه خود داشته باشید</p>
                        </td>
                    </tr>




                </table>

                <div style="margin: 10px 800px 0px 300px ; width: 90%">
                    <?php if($StampAgency != ROOT_ADDRESS_WITHOUT_LANG.'/pic/'){ ?>
                        <img src="<?php echo $StampAgency ?>" height="100" style="max-width: 230px;">
                    <?php } ?>
                </div>

                <br/>
                <br/>
                <?php if($info['api_id'] == '14'){?>
                <br/>
                <br/>
                <br/>
                <br/>
              
                <?php } ?>

            
                <div class="element"></div>
                <hr style="margin: 50px 100px 100px 100px ; width: 90%"/>
                <table width="100%" align="center" style="margin: 10px 100px 50px 100px ; font-size: 17px" scellpadding="0"
                       cellspacing="0">

                    <tr>
                        <td>
                            وب سایت :
                            <?php echo $ClientMainDomain; ?>

                        </td>
                    <?php if($info['api_id'] != '14'){?>
                        <td> تلفن پشتیبانی :
                            <?php echo $phone; ?>
                        </td>
                        <td> تلفن و تلگرام پشتیبانی :
                            <?php echo $PhoneManage; ?>
                        </td>
                    <?php }?>
                    </tr>
                <?php if($info['api_id'] != '14'){?>
                    <tr>
                        <td colspan="2">
                            آدرس :
                            <?php echo $ClientAddress; ?>

                        </td>
                    </tr>
                <?php }?>

                </table>
                <?php

            }?>

                </body>
            </html>
            <?php
        } else { ?>
            <div style="text-align:center ; font-size:20px ;font-family: Yekan;">No INFORMATION</div><?php
        }
        return $PrintTicket = ob_get_clean();

    }


    public function InfoAirline($iata)
    {
        $AirLien = functions::InfoAirline($iata);

        return $AirLien['name_en'];
    }


    public function getTicketDataByRequestNumber($request_number)
    {
        Load::autoload('Model');
        $model = new Model();

        $query = "SELECT * FROM book_local_tb WHERE  request_number='{$request_number}' AND (successfull='book' OR successfull='private_reserve')";
        $info_ticket = $model->select($query);

        return $info_ticket;
    }

}