<?php


class boxCheckCostumer
{

public $id = '';
public $list;
public $edit;

public function __construct()
{
    //$this->createPdfContent($_GET['id']);
}

public function createPdfContent($param)
{
if (TYPE_ADMIN == '1') {
    Load::autoload('ModelBase');
    $Model = new ModelBase();
    $sql = "SELECT *  FROM  report_tb  WHERE request_number='{$param}'";
} else {
    Load::autoload('Model');
    $Model = new Model();

    $sql = "SELECT *  FROM  book_local_tb  WHERE request_number='{$param}'";
    $res = $Model->select($sql);

}
ob_start();
$date = dateTimeSetting::jdate("Y/m/d (H:i:s)", time(), '', '', 'en');
$sodorDate = dateTimeSetting::jdate("Y/m/d", $res[0]['creation_date_int'], '', '', 'en');
$FlightDate = functions::convertDateFlight($res[0]['date_flight']);
$airlineName = functions::InfoAirline($res[0]['airline_iata']);
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?php  echo functions::Xmlinformation("BoxCheck")?></title>
        </head>
        <style>

            .costumer {
                 border: 1px solid black;
                 border-collapse: collapse;
                 margin: 10px;
             }
            .costumer-td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            .costumerNoBorder {
                border: none;
            }
        </style>
        <body>


        <table width="1000" border="0" align="center" cellpadding="0" cellspacing="10">
            <tr height="120">
                <td width="1000" align="center">
                    <img class="h-img" src="<?php echo FRONT_CURRENT_THEME ?>project_files/images/logo.png"
                         style="width:100px; height:50px;">
                </td>
            </tr>
        </table>

        <table width="1000"  align="center"  class="costumer" >
            <tr style="margin :10px; padding:10px;" class="costumerNoBorder">
                <td class="costumerNoBorder">
                    <table width="800">
                        <tr height="50px"  style="margin:10px; ">
                            <td align="center" height="40" >
                                <span style="font-size:16px;font-weight:bold" class="style2">
                                    <span style="font-size:18px;font-weight:bold" class="lh50"><?php echo  functions::Xmlinformation("CustomerReceipts") ?></span>
                                </span>
                            </td>
                        </tr>

                        <tr dir="rtl" align="right"  style="margin:10px; ">
                            <td align="right" dir="rtl">
                                <table width="1000" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="30" width="200" id="print_sandogh" class="lh50"><span style="font-size:15px; font-family: BKoodakBold;" class="lh50"><?php echo  functions::Xmlinformation("Invoicenumber") ?> :</span> <span style="font-size:15px"><?php echo  $res[0]['factor_number']?></span></td>
                                        <td height="30" width="250" id="print_sandogh" dir="rtl" class="lh50" style="font-size:15px"><?php echo  functions::Xmlinformation("Issuedate") ?>:<span style="font-size:15px; text_align:right; direction:rtl !important;" dir="rtl" class="lh50"><?php echo  $date ?></span>  </td>
                                        <td height="30" width="200" id="print_sandogh" dir="rtl" class="lh50" style="font-size:15px"> <?php echo  functions::Xmlinformation("DateOfContract") ?>:<span style="font-size:15px" dir="ltr" class="lh50"><?php echo  $sodorDate ?></span></td>
                                        <td align="right" width="250" id="print_sandogh" dir="rtl" >
                                            <div style="direction:rtl; text-align:right;">
                                                <span style="font-size:15px" class="dir-rtl">
                                                    <?php echo  functions::Xmlinformation("Numberreservation") ?>:
                                                </span>
                                                <span dir="rtl" style="font-size:15px"><?php echo  $res[0]['request_number'] ?></span></div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style="margin:10px; padding:10px;">
                <td>
                    <table width="800" align="center"  class="costumer">
                        <thead>
                        <tr class="costumer-td">
                            <th>نام و نام خانوادگی</th>
                            <th>شماره بلیط</th>
                            <th>مبلغ</th>
                        </tr>
                        </thead>
                        <?php
                        foreach ($res as $info) {
                            $Price = functions::CalculatePriceTicketOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes') + $info['amount_added'];
                            $passenger_name = $info['passenger_name_en'] ? $info['passenger_name_en'] : $info['passenger_name'] ;
                            $passenger_family = $info['passenger_family_en'] ? $info['passenger_family_en'] : $info['passenger_family'] ;
                            ?>
                            <tr class="costumer-td">
                                <td align="center"><?php echo $passenger_name.' '.$passenger_family?></td>
                                <td align="center"><?php echo $info['eticket_number']?></td>
                                <td align="center"><?php echo number_format($Price).'ریال'?></td>
                            </tr>
                            <?php
                        }
                        ?>

                    </table>
                </td>
            </tr>

            <tr style="margin:10px 30px 10px 10px; padding:10px" class="costumerNoBorder">
                <td style="font-size:18px;margin :10px; padding:10px" height="30" id="print_sandogh" dir="rtl">
                    <?php echo functions::Xmlinformation("ForExportServices") . ' ' .functions::Xmlinformation("BuyTicket") . ' ' . $res[0]['origin_city'] . ' ' . functions::Xmlinformation("On") . ' ' . ' ' . $info['desti_city'] . ' ' . functions::Xmlinformation('Airline') . ' ' . $airlineName['name_fa'] . ' ' . functions::Xmlinformation('FlightNumber') . ' ' . $res[0]['flight_number'] ?></span> </span>
                </td>
            </tr>

            <tr style="margin:10px 30px 10px 10px; padding:10px; " class="costumerNoBorder">
                <td  dir="rtl">
                   <b style="font-size:15px;margin :30px; padding:30px" class="lh100"><?php echo  functions::Xmlinformation("StampCashierSignature") ?></b>
                </td>
            </tr>
            <tr>
                  <td style="margin:10px 30px 10px 10px; padding:30px" id="print_sandogh" colspan="2" height="20"><?php echo functions::Xmlinformation("NoStampSignatureIsInvalid") ?></td>
            </td>
            </tr>


        </table>


<?php
return $PrintTicket = ob_get_clean();

}

public function createPdfContent1($param)
{
    if (TYPE_ADMIN == '1') {
        Load::autoload('ModelBase');
        $Model = new ModelBase();
        $sql = "SELECT *  FROM  report_tb  WHERE request_number='{$param}'";
    } else {
        Load::autoload('Model');
        $Model = new Model();

        $sql = "SELECT *  FROM  book_local_tb  WHERE request_number='{$param}'";
    }


    $res = $Model->select($sql);

    $prinBoxCheck = '';
    $prinBoxCheck .= '
  <!DOCTYPE html>
<html>
<head>
<title>' . functions::Xmlinformation("BoxCheck") . '</title>
</head>
<body>


        <table  width="1000"   border="0" align="center" cellpadding="0" cellspacing="10" >
            <tr height="120">
                <td width="1000" align="center">
                    <img class="h-img" src="' . FRONT_CURRENT_THEME . 'project_files/images/logo.png" style="width:100px; height:50px;" >
                </td>
            </tr>
        </table>';

    foreach ($res as $info) {
        $Price = functions::CalculatePriceTicketOnePerson($info['request_number'], ($info['passenger_national_code'] == '0000000000' || $info['passenger_national_code'] == '' ? $info['passportNumber'] : $info['passenger_national_code']), 'yes');
        $date = dateTimeSetting::jdate("Y/m/d (H:i:s)", time(), '', '', 'en');
        $sodorDate = dateTimeSetting::jdate("Y/m/d", $info['creation_date_int'], '', '', 'en');
        $FlightDate = functions::convertDateFlight($info['date_flight']);
        $airlineName = functions::InfoAirline($info['airline_iata']);
        $page_pdf = "yes";
        $type_pay = functions::Xmlinformation("FromCompanyLadySir");

        $prinBoxCheck .= '
            <table width="1000"  border="1" align="center" cellpadding="0" cellspacing="10" bordercolor="#888888" >
                <tr style="margin :10px padding:10px;">
                    <td>
                        <table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin:10px; ">
                          <tr height="50px"  style="margin:10px; ">
                        	<td align="center" height="40" ><span style="font-size:16px;font-weight:bold" class="style2">';
        $prinBoxCheck .= '<span style="font-size:18px;font-weight:bold" class="lh50">' . functions::Xmlinformation("CustomerReceipts") . '</span>	
                        	</span></td>
                          </tr>
                        
                          <tr dir="rtl" align="right"  style="margin:10px; ">
                        	<td align="right" dir="rtl">
                              <table width="1000" border="0" cellspacing="0" cellpadding="0">
                            	  <tr>
                            		<td height="30" width="200" id="print_sandogh" class="lh50"><span style="font-size:15px; font-family: BKoodakBold;" class="lh50">' . functions::Xmlinformation("Invoicenumber") . ' :</span> <span style="font-size:15px">' . $info['factor_number'] . '</span></td>
                            		<td height="30" width="250" id="print_sandogh" dir="rtl" class="lh50" style="font-size:15px">' . functions::Xmlinformation("Issuedate") . ':<span style="font-size:15px; text_align:right; direction:rtl !important;" dir="rtl" class="lh50">' . $date . '</span>  </td>
                            		<td height="30" width="250" id="print_sandogh" dir="rtl" class="lh50" style="font-size:15px"> ' . functions::Xmlinformation("DateOfContract") . ':<span style="font-size:15px" dir="ltr" class="lh50">' . $sodorDate . '</span></td>
                            		<td align="right" width="300" id="print_sandogh" dir="rtl" >
                            		    <div style="direction:rtl; text-align:right;"><span style="font-size:15px" class="dir-rtl">' . functions::Xmlinformation("Numberreservation") . ':</span><span dir="rtl" style="font-size:15px">' . $info['request_number'] . '</span></div>
                            		</td>
                            	  </tr>
            	              </table>
                            </td>
                          </tr>
                          <tr>
                            <td>
            		          <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="margin:10px; ">
                                <tr>
                    	           <td style="font-size:18px" height="30" id="print_sandogh" dir="rtl">';

        ////////////////دریافت از مسافر یا برگشت پول ؟؟/////

        $prinBoxCheck .= $type_pay . ' ' . ':' . ' ' . $info['passenger_name'] . ' ' . $info['passenger_family'] . ' ' . functions::Xmlinformation('Ticketnumber') . ' ' . $info['eticket_number'] . '</td>';

        $prinBoxCheck .= '
                        </tr>
            	              </table>
                            </td>
                          </tr>
                          <tr>
            	            <td height="30" id="print_sandogh" dir="rtl" style="font-size:18px">
                              <span style="font-size:18px">  ' . functions::Xmlinformation("Phonenumber") . ' :</span> ' . $info['mobile_buyer'] . '
            		        </td>
                          </tr>
                          <tr>
            	            <td  id="print_sandogh" dir="rtl" style="font-size:18px" height="30">
                              <span style="font-size:18px">  ' . functions::Xmlinformation("Amount") . ' :</span> ' . number_format($Price) . ' ' . functions::Xmlinformation("Rial") . '
            		        </td>
                          </tr>
                          <tr>';

        if ($info['type_app'] == 'reservationBus') {
            $prinBoxCheck .= '
            	            <td style="font-size:18px" height="30" id="print_sandogh" dir="rtl">
            	' . functions::Xmlinformation("CashierReceipts") . ' ' . $info['flight_number'] . ' - ' . $info['desti_city'] . ' ' . functions::Xmlinformation("ToReservationNumber") . ' ' . $info['request_number'] . ' ' . '  ' . functions::Xmlinformation("ToDate") . '  <span style="direction:rtl">' . ($i != 1 ? $sodorDate : $FlightDate) . '</span> </span>  
                            </td>';

        } else {
            $prinBoxCheck .= '
            	            <td style="font-size:18px" height="30" id="print_sandogh" dir="rtl">
            ' . functions::Xmlinformation("ForExportServices") . ' ' . $info['origin_city'] . ' ' . functions::Xmlinformation("On") . ' ' . ' ' . $info['desti_city'] . ' ' . functions::Xmlinformation('Airline') . ' ' . $airlineName['name_fa'] . ' ' . functions::Xmlinformation('FlightNumber') . ' ' . $info['flight_number'] . ' ' . functions::Xmlinformation("ToReservationNumber") . ' ' . $info['request_number'] . ' ' . '  ' . functions::Xmlinformation("ToDate") . '  <span style="direction:rtl">' . ($i != 1 ? $sodorDate : $FlightDate) . '</span> </span>  
                            </td>';
        }

        $prinBoxCheck .= '
                          </tr>
            	    
                          <tr>
                	        <td  dir="rtl">
            	               <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="margin:10px; ">
                            	  <tr>
                            		<td width="600" id="print_sandogh" height="80"><b style="font-size:15px" class="lh100">' . functions::Xmlinformation("StampCashierSignature") . '</b></td>
                            	  </tr>
                	              <tr>
                            		<td id="print_sandogh" colspan="2" height="20">' . functions::Xmlinformation("NoStampSignatureIsInvalid") . '</td>
                            	  </tr>
                	           </table>
            	            </td>
                          </tr>
             
                          <tr>
                        	  <td align="center"  class="footer_poshtibani">
            	                   <p style="text-align:center;width:1000px;height:30px;direction:rtl;line-height:30px;font-size:12px;margin-bottom:10px;">' . $footer_prints . '</p>
                        	  </td>
                          </tr>
              
            	       </table>
                    </td>
                </tr>
            </table>';

    }

    $prinBoxCheck .= ' </body>
</html> ';


    return $prinBoxCheck;

}

}

?>
