<?php
class bookingBusForeign extends clientAuth
{
#region getBookReportBusTicket
    public function getBookReportBusTicket($factorNumber)
    {
        if (TYPE_ADMIN == '1') {

            $ModelBase = Load::library('ModelBase');
            $sql = "select *, GROUP_CONCAT(passenger_name SEPARATOR ', ') AS passenger_name_list ,  GROUP_CONCAT(passenger_family SEPARATOR ', ') AS passenger_family_list, GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs , GROUP_CONCAT(passenger_national_code SEPARATOR ', ') AS nationalCodes , GROUP_CONCAT(passenger_gender SEPARATOR ', ') AS genders from report_bus_tb where passenger_factor_num = '{$factorNumber}' ";
            $resultBook = $ModelBase->load($sql);

        } else {

            $Model = Load::library('Model');
            $sql = "select *, GROUP_CONCAT(passenger_name SEPARATOR ', ') AS passenger_name_list ,  GROUP_CONCAT(passenger_family SEPARATOR ', ') AS passenger_family_list, GROUP_CONCAT(passenger_chairs SEPARATOR ', ') AS chairs , GROUP_CONCAT(passenger_national_code SEPARATOR ', ') AS nationalCodes , GROUP_CONCAT(passenger_gender SEPARATOR ', ') AS genders from book_bus_tb where passenger_factor_num = '{$factorNumber}' ";
            $resultBook = $Model->load($sql);
        }

        /*$chairs = '';
        foreach ($resultBook as $val) {
            $chairs .= $val['passenger_chairs'] . ', ';
        }

        $return = $resultBook[0];
        $return['chairs'] = substr($chairs, 0, -2);*/

        return $resultBook;
    }
    #endrigion

    #region createPdfContent
    public function findNameEnByNameFa($nameFa) {
        return $this->getModel('busRouteModel')->get()->where('name_fa', $nameFa)->find();
    }
    public function createPdfContent($factorNumber, $cash, $cancelStatus)
    {
        $function = Load::library('functions');
        $data = $this->getBookReportBusTicket($factorNumber);
        $find_name_en_Origin = $this->findNameEnByNameFa($data['OriginCity']);
        $find_name_en_destination = $this->findNameEnByNameFa($data['DestinationCity']);
        if($find_name_en_Origin) {
            $data['OriginCity'] = $find_name_en_Origin['name_en'];
        }
        if($find_name_en_destination) {
            $data['DestinationCity'] = $find_name_en_destination['name_en'];
        }


        $pdfContent = '';
        if ($data['status'] == 'book') {
            /** @var agency $agencyController */
            $agencyController = Load::controller('agency');
            $agencyInfo = $agencyController->infoAgency($data['agency_id'],CLIENT_ID);
            if($agencyInfo['hasSite'])
            {
                $logo = ROOT_ADDRESS_WITHOUT_LANG . '/pic/agencyPartner/' .CLIENT_ID.'/logo/'. CLIENT_LOGO;

            }else{
                $logo = ROOT_ADDRESS_WITHOUT_LANG . '/pic/' . CLIENT_LOGO;
            }
            $passenger_gender_list = $data['genders'] ;
            $passenger_gender_list = explode(',' , $passenger_gender_list  );

            $passenger_gender = [] ;
            foreach ($passenger_gender_list as $passenger) {
                $passenger_gender[] = ($passenger == 'Female' ? 'Female ' : ' Male') ;
            }
            $passenger_gender = implode('-' ,$passenger_gender );

            $pdfContent .= '
<!DOCTYPE html>
<html>
    <head>
        <title>Bus ticket with invoice number ' . $data['passenger_factor_num'] . '</title>
        <style type="text/css">
            @font-face {
                font-family: "Yekan";
                font-style: normal;
                font-weight: normal;
                src: url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff?#iefix") format("embedded-opentype"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.woff") format("woff"),
                url("../view/administrator/assets/css/font/web/persian/Yekan/Yekan.ttf") format("truetype");
            }
            table{
                margin: 10px 100px;
                font: normal 16px/30px Yekan;
            }
            .page {
                border-collapse: collapse;
                border: 1px solid #000;
            }
            .page td, .page th{
               padding:5px;
               margin:0;
               border-left: 1px solid #000;
               text-align: center;
               vertical-align: top;
            }
            .page td:first-child, .page th:first-child{
                border-left: none;
            }
            .page th{
                border-bottom: 1px solid #000;
            }
            .borderBottomTd{
                border-bottom: 1px solid #000;
            }
            p{
                font: bold 15px/25px Yekan;
            }
            .title{
                height: 120px;
                font: bold 18px/30px Yekan;
            }
            .borderTop{
                border-top: 1px solid #000;
            }
            .padd li{
                padding-left: 30px;
                padding-left: 30px;
            }
            .rtl{
                direction: ltr;
            }
            .ltr{
                direction: rtl;
            }
            .pageBreak{page-break-before: always;}
            .topFrame{
                border: 1px solid #000;
                background-color: #FFF;
                border-radius: 5px;
                z-index: 1000;
                width: 100px;
                padding: 5px 10px;
                margin: 0px 110px -35px;
                text-align: center;
            }
            .footer{
                position: absolute; 
                bottom: 30px; 
                width: 100%;
                text-align: center; 
            }
            .footer p{
                margin: 10px 100px;
                border: 1px solid #000;
            }
            .bold{
            font-weight:bold;
            }
        </style>
    </head>
    <body>';

            $pdfContent .= '
            <p style="height: 20px;"></p>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="ltr">
                <tr>
                    <td width="50%" align="left">Date of Issue: ' . substr($data['payment_date'], 0, 10) . '</td>
                </tr> 
                 <tr>
                    <td width="50%" align="left">Factor Number: ' . $data['passenger_factor_num'] . '</td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl">
                <tr>
                    <td width="33%"><img src="' . $logo . '" height="100" /></td>
                    <td width="34%" align="center" class="title">Bus ticket from ' . $data['OriginCity'] . ' to ' . $data['DestinationCity'] . '</td>
                    <td width="33%"></td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">Passenger information</th>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <ul>
                            <li>Name: ' . $data['passenger_name_list'] . '</li>
                            <li>Last name: ' . $data['passenger_family_list'] . '</li>
                            <li>National code: ' . $data['nationalCodes'] . '</li>
                            <li>Gender: ' . $passenger_gender . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="left">
                        <ul>
                            <li>Mobile number: ' . $data['passenger_mobile'] . '</li>
                            <li>Email: ' . $data['passenger_email'] . '</li>
                            <li>Number of people: ' . $data['passenger_number'] . '</li>
                            <li>Seat numbers: ' . $data['chairs'] . '</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">Ticket information</th>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <ul>
                            <li>Origin: ' . $data['OriginCity'] . '</li>
                            <li>Origin terminal: ' . $data['OriginTerminal'] . '</li>
                            <li>Date of departure: ' . $data['DateMove'] . '</li>
                            <li>Tracking Code: ' . $data['order_code'] . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="left">
                        <ul>
                            <li> Selected destination: ' . $data['DestinationCity'] . '</li>
                            <li> Final destination: ' . $data['DestinationName'] . '</li>
                            <li> Departure time: ' . $data['TimeMove'] . '</li>
                            <li> Ticket number: ' . $data['ClientTraceNumber'] . '</li>
                            <li> Reference number : ' . $data['pnr'] . '</li>
                       
                        </ul>
                    </td>
                </tr>
            </table>
            
           <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">Passenger company information</th>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <ul>
                            <li>' . $data['CompanyName'] . '</li>
                        </ul>
                    </td>
                     <td width="50%" align="left">
                        <ul>
                            <li> ' . $data['CarType'] . '</li>
                            
                        </ul>
                    </td>
                </tr>
            </table>
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="2">Information '.CLIENT_NAME.'</th>
                </tr>
                <tr>
                    <td width="50%" align="left">
                        <span>Website</span>
                    </td>
                     <td width="50%" align="left">
                        <span>' . CLIENT_MAIN_DOMAIN . '</span>
                    </td>
                </tr>
                  <tr>
                    <td width="50%" align="left">
                        <span>Phone number </span>
                    </td>
                     <td width="50%" align="left">
                        <span>' . CLIENT_PHONE . '</span>
                    </td>
                </tr>
            </table>
            
            
            
            
            
            <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th width="50%">Costs</th>
                    <th width="20%">Count</th>
                    <th width="30%">Amount in Rials</th>
                </tr>
                <tr>
                    <td class="borderBottomTd">Service amount</td>
                    <td class="borderBottomTd">' . $data['passenger_number'] . '</td>';
            if($cash == 'no') {
                $pdfContent .= '<td class="borderBottomTd bold">cache</td>';
            }else {
                $pdfContent .= '<td class="borderBottomTd">' . number_format($data['total_price']) . '</td>';
            }
            $pdfContent .= '</tr> ';

            if (!empty($discountCodeInfo) && $cash == 'no') {

                $pdfContent .= '
            <tr>
                <td class="borderBottomTd">Discount code price</td>
                <td class="borderBottomTd">1</td><td class="borderBottomTd">'.number_format($discountCodeInfo['amount']).'</td>
            </tr>

        ';
                $data['total_price']=$data['total_price'] - $discountCodeInfo['amount'];
            }

            $pdfContent .= '
                 <tr>
                    <td class="borderBottomTd bold">Total</td>
                    <td class="borderBottomTd bold"></td>';
            if($cash == 'no') {
                $pdfContent .= '<td class="borderBottomTd bold">cache</td>';
            }else {
                $pdfContent .= '<td class="borderBottomTd bold">' . number_format($data['total_price']) . '</td>';
            }
            $pdfContent .= '</tr>
            </table>';

            if ($data['request_cancel'] == 'confirm') {
                $cancelTicketDetailsModel=$this->getModel('cancelTicketDetailsModel')->get()
                    ->where('FactorNumber',$data['passenger_factor_num'])
                    ->find();
                $cancel_date=dateTimeSetting::jdate('Y-m-d (H:i:s)',$cancelTicketDetailsModel['DateConfirmCancelInt'],'','','en');
                $pdfContent .= '
                <table width="100%" align="center" cellpadding="0" cellspacing="0" class="page rtl">
                <tr>
                    <th colspan="1">Refund information</th>
                </tr>
                <tr>
                    <td width="100%" align="left">
                        <span>The above bus On  '.$cancel_date.' with percentage '.number_format($cancelTicketDetailsModel['PercentIndemnity']).' and cost '.number_format($cancelTicketDetailsModel['PriceIndemnity']).' has been returned</span>
                    </td>
                    
                </tr>
                 
            </table>
                
                ';
            }



            $pdfContent .= '
            <div class="footer">
                <table width="100%" align="center" cellpadding="0" cellspacing="0" class="rtl">
                    <tr>
                        <td align="center" colspan="2"><p>Address: ' . CLIENT_ADDRESS . '</p></td>
                    </tr>
                    <tr>
                        <td align="center"><p>Phone support: ' . CLIENT_PHONE . '</p></td>
                        <td align="center"><p>Web site: ' . CLIENT_MAIN_DOMAIN . '</p></td>
                    </tr>
                </table>
            </div>
            ';

            $pdfContent .= '
    </body>
</html>
            ';

            return $pdfContent;

        } else {
            return 'خطا: رزرو با شماره فاکتور مذکور قطعی نشده است';
        }


    }

}