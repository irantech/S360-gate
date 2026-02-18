<?php


class contentPdf extends clientAuth{
    public function __construct() {
        parent::__construct();
    }

    public function createPdfContent($param, $method, $extra_param) {
        return $this->$method($param);
    }


    public function transactionReceipt($param) {
        $info_transaction = $this->getController('transaction')->getTransactionByFactorNumber($param);

        $print_box_check = '';
        if ($info_transaction) {

            $payment_date = functions::DateJalali($info_transaction['PriceDate']);
            $date = dateTimeSetting::jdate("Y/m/d (H:i:s)", time(), '', '', 'en');

            $print_box_check .= '
          <!DOCTYPE html>
            <html>
                  <head>
                     <title>رسید تراکنش</title>
                     <style>
                          table {
                             border-collapse: collapse;
                          }
                                
                        tr {
                          border-bottom: 1pt solid black;
                          }
                      </style>
                  </head>
                  <body style="padding:100px">
                     <table width="1000"  border ="1" align="center" cellpadding="5" cellspacing="10" bordercolor="#888888"  style="margin:50px">
                        <tr>
                          <td align="center">
                              <table width="1000" border="0" cellspacing="0" cellpadding="0" style="margin:10px; ">
                                   <tr height="50px"  style="margin:12px; ">
                                      <td align="center" height="40" >
                                            <span style="font-size:16px;font-weight:bold" class="lh50">رسید تراکنش</span>                              
                                      </td>
                                  </tr>
                                   <tr dir="rtl" align="right"  style="margin:50px; ">
                                  <td align="right" dir="rtl">
                                    <table width="1000" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="30" width="35%" id="print_sandogh" dir="rtl" class="lh50"><span style="font-size:16px; font-family: BKoodakBold;" class="lh50">شماره فاکتور :</span> <span style="font-size:15px">' . $info_transaction['FactorNumber'] . '</span></td>
                                        <td height="30" width="35%" id="print_sandogh" dir="rtl" class="lh50" style="font-size:16px">تاریخ صدور:<span style="font-size:15px; text_align:right; direction:rtl !important;" dir="rtl" class="lh50">' . $date . '</span>  </td>
                                        <td height="30" width="30%" id="print_sandogh" dir="rtl" class="lh50" style="font-size:16px"> تاریخ پرداخت:<span style="font-size:15px" dir="ltr" class="lh50">' . $payment_date . '</span></td>
                                      </tr>
                                      </table>
                                       <table width="1000" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td id="print_sandogh" height="80"><b style="font-size:16px">بابت خدمات  :</b></td>
                                            <td id="print_sandogh" height="80"> <span style="font-size:16px">  پرداخت شارژ حساب ' . number_format($info_transaction['Price']) . ' ریال بابت شارژ پنل کاربری با شماره پیگیری:' . $info_transaction['BankTrackingCode'] . '<span>  </td>
                                        </tr>	15
                                        </table>

                                </td>
                              </tr>
                              </table>
                          </td>
                        </tr>
                     </table>
                   </body>
             </html> ';
        }

        return $print_box_check;
    }

}