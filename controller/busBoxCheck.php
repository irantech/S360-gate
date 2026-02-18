<?php

// require '../config/bootstrap.php';
// require LIBRARY_DIR . 'Load.php';
// require CONFIG_DIR . 'config.php';

//new boxCheck();
/**
 * Class boxCheck
 * @property busBoxCheck $busBoxCheck
 */
class busBoxCheck
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

        if (TYPE_ADMIN == '1' || TYPE_ADMIN == '2') {
            Load::autoload('ModelBase');
            $Model = new ModelBase();
            $sql = "SELECT * , "
                . " (SELECT count(id)   FROM  report_bus_tb WHERE passenger_factor_num='{$param}' ) AS CountTicket "
                . "  FROM  report_bus_tb  WHERE passenger_factor_num='{$param}'";
            $res = $Model->load($sql);

            $request_number = $res['passenger_factor_num'];
        } else {

            Load::autoload('Model');
            $Model = new Model();

            $sql = "SELECT * , "
                . " (SELECT count(id)   FROM  book_bus_tb WHERE order_code='{$param}' ) AS CountTicket "
                . "  FROM  book_bus_tb  WHERE order_code='{$param}'";

            $res = $Model->load($sql);

            $request_number = $res['order_code'];
        }



//        $Price = functions::CalculateDiscount($res['request_number'], 'yes');
//        $Price += ($res['amount_added']*$res['CountTicket']);
        $Price = $res['total_price'];

        $date = dateTimeSetting::jdate("Y/m/d (H:i:s)", time(), '', '', 'en');
        $sodorDate = dateTimeSetting::jdate("Y/m/d", $res['creation_date_int'], '', '', 'en');
        $busDate =  explode("-",$res['DateMove']);
        $busDate =  $busDate[0].'/'.$busDate[1].'/'.$busDate[2];

        $page_pdf = "yes";
        $type_pay = functions::Xmlinformation("AccountInformationRegistered");

        $prinBoxCheck ='';
        $prinBoxCheck .= '
  <!DOCTYPE html>
<html>
<head>
<title>'.functions::Xmlinformation("BoxCheck").'</title>
</head>
<body>


        <table  width="1000"   border="0" align="center" cellpadding="0" cellspacing="10" >
            <tr height="120">
                <td width="1000" align="center">
                    <img class="h-img" src="' . FRONT_CURRENT_THEME . 'project_files/images/logo.png" style="width:100px; height:50px;" >
                </td>
            </tr>
        </table>';


        for ($i = 1; $i <= 3; $i++) {
            $prinBoxCheck .= '
            <table width="1000"  border="1" align="center" cellpadding="0" cellspacing="10" bordercolor="#888888" >
                <tr style="margin :10px padding:10px;">
                    <td>
                        <table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin:10px; ">
                          <tr height="50px"  style="margin:10px; ">
                        	<td align="center" height="40" ><span style="font-size:16px;font-weight:bold" class="style2">';

            if ($i == 1) {
                $prinBoxCheck .= '<span style="font-size:18px;font-weight:bold" class="lh50">'.functions::Xmlinformation("CustomerReceipts").'</span>';
            } else if ($i == 2) {
                $prinBoxCheck .= '<span style="font-size:18px;font-weight:bold" class="lh50">'.functions::Xmlinformation("CounterReceipts").'</span>';
            } else if ($i == 3) {
                $prinBoxCheck .= '<span style="font-size:18px;font-weight:bold" class="lh50">'.functions::Xmlinformation("CashierReceipts").'</span>';
            }
            $prinBoxCheck .= '	
                        	</span></td>
                          </tr>
                        
                          <tr dir="rtl" align="right"  style="margin:10px; ">
                        	<td align="right" dir="rtl">
                              <table width="1000" border="0" cellspacing="0" cellpadding="0">
                            	  <tr>
                            		<td height="30" width="200" id="print_sandogh" class="lh50"><span style="font-size:15px; font-family: BKoodakBold;" class="lh50">'.functions::Xmlinformation("Invoicenumber").' :</span> <span style="font-size:15px">' . $request_number . '</span></td>
                            		<td height="30" width="250" id="print_sandogh" dir="rtl" class="lh50" style="font-size:15px">'.functions::Xmlinformation("Issuedate").':<span style="font-size:15px; text_align:right; direction:rtl !important;" dir="rtl" class="lh50">' . $date . '</span>  </td>
                            		<td height="30" width="250" id="print_sandogh" dir="rtl" class="lh50" style="font-size:15px"> '.functions::Xmlinformation("DateOfContract").':<span style="font-size:15px" dir="ltr" class="lh50">' . $sodorDate . '</span></td>
                            		<td align="right" width="300" id="print_sandogh" dir="rtl" >
                            		    <div style="direction:rtl; text-align:right;"><span style="font-size:15px" class="dir-rtl">'.functions::Xmlinformation("Numberreservation").':</span><span dir="rtl" style="font-size:15px">' . $request_number . '</span></div>
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

            if ($i == 1) {
                $prinBoxCheck .= $type_pay . ' ' . ':' . ' ' . $res['passenger_name'].' '.$res['passenger_family'] . '</td>';

            } else {
                $prinBoxCheck .= $type_pay . ' ' . ':' . ' ' . $res['member_name'] . '</td>';

            }
            $prinBoxCheck .= '</tr>
            	              </table>
                            </td>
                          </tr>
                          <tr>
            	            <td height="30" id="print_sandogh" dir="rtl" style="font-size:18px">
                              <span style="font-size:18px">  '.functions::Xmlinformation("Phonenumber").' :</span> ' . ($i !=1 ? $res['member_mobile'] : $res['passenger_mobile']) . '
            		        </td>
                          </tr>
                          <tr>
            	            <td  id="print_sandogh" dir="rtl" style="font-size:18px" height="30">
                              <span style="font-size:18px">  '.functions::Xmlinformation("Amount").' :</span> ' . number_format($Price) . ' '.functions::Xmlinformation("Rial").'
            		        </td>
                          </tr>
                          <tr>';


                $prinBoxCheck .= '
            	            <td style="font-size:18px" height="30" id="print_sandogh" dir="rtl">
            '.functions::Xmlinformation("ForExportServices").' ' . $res['CountTicket'] . ' '.functions::Xmlinformation("NumberOfBus").' ' . $res['OriginCity'] . ' '.functions::Xmlinformation("On").' ' . ' ' . $res['DestinationCity'] . ' ' . functions::Xmlinformation("ToReservationNumber") . ' ' . $request_number . ' ' . '  '.functions::Xmlinformation("ToDate").'  <span style="direction:rtl">' . ($i!=1 ? $sodorDate : $busDate) . '</span> </span>
                            </td>';


            $prinBoxCheck .= '
                          </tr>
            	    
                          <tr>
                	        <td  dir="rtl">
            	               <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="margin:10px; ">
                            	  <tr>
                            		<td width="600" id="print_sandogh" height="80"><b style="font-size:15px" class="lh100">'.functions::Xmlinformation("StampCashierSignature").'</b></td>
                            	  </tr>
                	              <tr>
                            		<td id="print_sandogh" colspan="2" height="20">'.functions::Xmlinformation("NoStampSignatureIsInvalid").'</td>
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
