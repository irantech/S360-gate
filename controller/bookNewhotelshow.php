<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class bookNewhotelshow extends baseController
{

    public function createPdfContent($param)
    {

        $html = '
<!doctype html>
<html lang="en">
  <head>
    <title>Hotel Voucher</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">


    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" href="'.ROOT_ADDRESS_WITHOUT_LANG.'/view/administrator/assets/css/bootstrap.css" media="all">
    <link rel="stylesheet" href="'.ROOT_ADDRESS_WITHOUT_LANG.'/view/administrator/assets/css/new-pdf-voucher.css" media="all">
  </head>
  <body style="direction: ltr !important">
    <div class="container page-content">';
        $location = ROOT_ADDRESS_WITHOUT_LANG.'/view/administrator/assets/images/laika/';
        if(TYPE_ADMIN){
            $model = Load::getModel('reportHotelModel');
        }else{
            $model = Load::getModel('bookHotelLocal');
        }
        $all_passengers = $model->get()->where('factor_number',$param)->where('status','BookedSuccessfully')->all();
        $rooms = $model->get()->where('factor_number',$param)->where('status','BookedSuccessfully')->groupBy('room_index')->all();
        if(!is_array($all_passengers) || empty($all_passengers[0])){
            $html .= '<div class="alert alert-danger">data requested not found please check and try again</div>';
//            return $html;
        }else{
            $first_passenger = $all_passengers[0];
            $created_at = date('jS M Y' , $first_passenger['creation_date_int']);
            $hotel_name = $first_passenger['hotel_name_en'] ? $first_passenger['hotel_name_en'] : $first_passenger['hotel_name'];

            $extra_detail = json_decode($first_passenger['extra_hotel_details'],true);
            $start_date_gregorian = functions::ConvertToMiladi($first_passenger['start_date']);
            $end_date_gregorian = functions::ConvertToMiladi($first_passenger['end_date']);
      
            $hotel_details = [
                'name'=>$first_passenger['hotel_name'],
                'extra_bed_count'=>$first_passenger['extra_bed_count'],
                'image'=>$first_passenger['hotel_pictures'],
                'address'=>$first_passenger['hotel_address'],
                'tel'=>$first_passenger['hotel_telNumber'],
                'stars'=>$first_passenger['hotel_starCode'],
                'factor_number'=>$first_passenger['factor_number'],
                'pnr'=>$first_passenger['pnr'],
                'gps_coordinates'=>json_decode($first_passenger['hotel_location'],true),
                'nights'=>$first_passenger['number_night'],
                'room_price'=>functions::CurrencyCalculate($first_passenger['room_online_price']  , '9373') ,
                'total_price'=>functions::CurrencyCalculate($first_passenger['total_price'] , '9373'),
                'check_in'=>[
                    'time'=>$first_passenger['hotel_entryHour'],
                    'date'=>$start_date_gregorian,
                    'd'=>date('d',strtotime($start_date_gregorian)),
                    'F'=>date('F',strtotime($start_date_gregorian)),
                    'l'=>date('l',strtotime($start_date_gregorian)),
                    'Y'=>date('Y',strtotime($start_date_gregorian)),
                    'Z'=>date('jS M Y',strtotime($start_date_gregorian)),

                ],
                'check_out'=>[
                    'time'=>$first_passenger['hotel_leaveHour'],
                    'date'=>$end_date_gregorian,
                    'd'=>date('d',strtotime($end_date_gregorian)),
                    'F'=>date('F',strtotime($end_date_gregorian)),
                    'l'=>date('l',strtotime($end_date_gregorian)),
                    'Y'=>date('Y',strtotime($end_date_gregorian)),
                    'Z'=>date('jS M Y',strtotime($end_date_gregorian)),
                ],
                'important_notices'=> htmlentities('test remark 1'),
                'min_age'=>18,
                'rooms_count'=>count($rooms),
                'instructions'=>htmlentities($extra_detail['Instructions']),
                'special_instructions'=>htmlentities($extra_detail['SpecialInstructions']),
            ];
            $room_details = [];
            foreach ($rooms as $room) {
                $detail = [
                    'room_name'=>$room['room_name'],
                    'bed_type'=>'FullBed',
                ];
                $adult_count =  0 ;
                $children_count =  0 ;
                foreach ($all_passengers as $passenger) {

                    if($passenger['passenger_age'] == 'Adt'){
                        $adult_count ++ ;
                    }else{
                        $children_count ++;
                    }

                    if($passenger['room_index'] != $room['room_index']){
                        continue;
                    }
                    if($passenger['passenger_birthday_en'] != ""){
                        $passenger_type = functions::type_passengers($passenger['passenger_birthday_en']);
                    }else{
                        $passenger_type = functions::type_passengers(functions::ConvertToMiladi($passenger['passenger_birthday']));
                    }
                    $detail['passengers'][] = [
                        'name'=>$passenger['passenger_name_en'] . ' '. $passenger['passenger_family_en'],
                        'type'=> $passenger_type
                    ];
                }
                $room_details[] = $detail;
            }
            $pdf_details = [
                'room'=>$room_details,
                'hotel'=>$hotel_details
            ];
//            echo json_encode($hotel_details);die();
//            echo json_encode($pdf_details,256);die();


            $html .= '<div class="card">
  <div class="card-body p-2">
  
  
   <table style="width:100%;line-height:20px !important;">
   <tbody>
    <tr>
       <td style="width: 80%;vertical-align: top;">
          <table class="w-100">
    <tbody>
    
    <tr class="w-100" style="width: 100%" >
    <td colspan="6">
       <img src="'.$location.'/laika.png"  alt="logo" class="logo-image">
    </td>
    </tr>
    <tr class="hotel-details-row d-flex" style="width: 100%;">
    <td colspan="6" class="w-100" style="width: 100%;">
    
    </td>
    </tr>
    </tbody>
 </table>
        </td>
       <td>
            <img src="'.$location.'/laika1.png"  alt="logo" class="right-image">
            <div style="font-size: 10px">New booking hotel request #'.$hotel_details['factor_number'].'</div>  
            <img src="'.$location.'/laika2.png"  alt="logo" class="right-image">
            <span>Request on: '.$created_at.'</span>
        
        </td>
   </tr>
    </tbody>
    </table>
  </div>';



            $html .= '
  <div class="card-body middle-section p-2">
  <table class=" detail-border" style="width:150px; font-size:15px ;  ">
    <tbody >
       <tr >
       <td style="font-weight: bold;">To:'.$hotel_name.'</td>
       </tr>
         <tr>
       <td>'.$hotel_details['tel'].'</td>
       </tr>
         <tr>
       <td>'.$hotel_details['address'].'</td>
       </tr>
    </tbody>
 </table>
  <table class="w-100 detail-border-right"  style="font-size:15px ; margin-top : 30px; ">
    <tbody class="detail-border mt-2">
     
         <tr>
       <td>Dear Mam/Sir</td>
       </tr>
         <tr>
       <td>This is a request to book a room for our guest, at your property with following details: </td>
       </tr>
    </tbody>
 </table>
  </div>';


            $html .= '<div>
  <div class="card-detail-body">
  
  
   <table style="width:100%;line-height:20px !important; font-size:15px ; margin-top : 30px;">
   <tbody  >
    <tr class="detail-border">
       <td style="width: 100%;vertical-align: top;">
          <table class="w-100">
    <tbody>
    
    <tr class="w-100 ">
        <td >
             <img src="'.$location.'/laika4.png"  alt="logo" class="detail-image">
        </td>

        <td colspan="3" >
        <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
        <td colspan="3" >
                <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
            <td colspan="3" >
                <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
       
        <td colspan="3" >
       
          <div style="with: 80%">
           <img src="'.$location.'/laika8.png"  alt="logo" class="icon-image">
          </div>
           
        </td>
          <td colspan="3" >
              <div syle="font-size:20px ; font-weight: bold;">
              <span style="font-weight: bold;">Arrival:</span>
             '.($hotel_details['check_in']['l']).' '.($hotel_details['check_in']['Z']).'
              </div>
              <div syle="font-size:20px; font-weight: bold;">
                  <span style="font-weight: bold;">Departure:</span>
              '.($hotel_details['check_out']['l']).' '.($hotel_details['check_out']['Z']).'</div>
             
          </td>
    </tr>
    
    </tbody>
 </table>
        </td>
     
   </tr>
    </tbody>
    </table>
  </div>';


            foreach ($room_details as $rk => $room_detail) {

                $html .= '<div>
  <div class="card-detail-body">
  
  
   <table style="width:100%;line-height:20px !important; font-size:15px ; margin-top : 30px;">
   <tbody  >
    <tr class="detail-border">
       <td style="width: 80%;vertical-align: top;">
          <table class="w-100">
    <tbody>
    
        <tr class="w-100 ">
        <td >
             <img src="' . $location . '/laika5.png"  alt="logo" class="detail-image">
        </td>

        <td colspan="3" >
        <img src="' . $location . '/white.png"  alt="logo" class="icon-image">
        </td>
        <td colspan="3" >
                <img src="' . $location . '/white.png"  alt="logo" class="icon-image">
        </td>
            <td colspan="3" >
                <img src="' . $location . '/white.png"  alt="logo" class="icon-image">
        </td>
       
        <td colspan="3" >
       
          <div style="with: 80%">
           <img src="' . $location . '/laika9.png"  alt="logo" class="icon-image">
          </div>
           
        </td>
          <td colspan="3" >
            
              <div syle="font-size:20px; font-weight: bold;">
              '.$room_detail['room_name'].'
              </div>
             
          </td>
    </tr>
    
    </tbody>
 </table>
        </td>
     
   </tr>
    </tbody>
    </table>
  </div>';
            }

            $html .= '<div>
  <div class="card-detail-body">
  
  
   <table style="width:100%;line-height:20px !important; font-size:15px ; margin-top : 30px;">
   <tbody  >
    <tr class="detail-border">
       <td style="width: 80%;vertical-align: top;">
          <table class="w-100">
    <tbody>
    
        <tr class="w-100 ">
        <td >
             <img src="'.$location.'/laika6.png"  alt="logo" class="detail-image">
        </td>

        <td colspan="3" >
        <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
        <td colspan="3" >
                <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
            <td colspan="3" >
                <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
       
        <td colspan="3" >
       
          <div style="with: 80%">
           <img src="'.$location.'/laika10.png"  alt="logo" class="icon-image">
          </div>
           
        </td>
          <td colspan="3" >
              <div syle="font-size:20px ; font-weight: bold;">
              <span style="font-weight: bold;">' . $adult_count . ' Adult(s) and' . $children_count . ' Children</span>
            
              </div>';
            foreach ($all_passengers as $rk => $passenger) {
                $html .= '
              <div syle="font-size:20px; font-weight: bold;">' . $passenger['passenger_name_en'] . '' . $passenger['passenger_family_en'] . '</div>';
            }
                $html .= '</td>
    </tr>
    
    </tbody>
 </table>
        </td>
     
   </tr>
    </tbody>
    </table>
  </div>';


            $html .= '<div>
  <div class="card-detail-body">
  
  
   <table style="width:100%;line-height:20px !important; font-size:15px ; margin-top : 30px;">
   <tbody  >
    <tr class="detail-border">
       <td style="width: 100%;vertical-align: top;">
          <table class="w-100">
    <tbody>
    
    <tr class="w-100 ">
        <td>
             <img src="'.$location.'/laika7.png"  alt="logo" class="detail-image">
        </td>

        <td colspan="3" >
        <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
        <td colspan="3" >
                <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
            <td colspan="3" >
                <img src="'.$location.'/white.png"  alt="logo" class="icon-image">
        </td>
       
        <td colspan="3" >
       
          <div style="with: 80%">
           <img src="'.$location.'/laika11.png"  alt="logo" class="icon-image">
          </div>
           
        </td>
          <td colspan="3" >
              <div syle="font-size:20px ; font-weight: bold;">
              <span style="font-weight: bold;">voucher number:</span>
             '.($hotel_details['pnr']).'
              </div>
          
             
          </td>
    </tr>
    
    </tbody>
 </table>
        </td>
     
   </tr>
    </tbody>
    </table>
  </div>';


      $html .= '<div class="card-detail-last-body" syle="font-size:20px; font-weight: bold;">
    <table syle="font-size:20px; font-weight: bold;">
    <tbody syle="font-size:20px; font-weight: bold;">
    <tr syle="font-size:20px; font-weight: bold;">
        <td>
         <img src="'.$location.'/laika12.png"  alt="logo" class="up-footer-image">
      </td>
          <td class="detail-border-right "  >
                <img src="'.$location.'/white.png"  alt="logo" class="icon-footer-image">
        </td>
       <td  syle="font-size:40px; font-weight: bold;">
       
            <div syle="font-size:40px; font-weight: bold;">
           Room: <span syle="font-size:40px; font-weight: bold;">'.$hotel_details['room_price']['TypeCurrency'].' '.$hotel_details['room_price']['AmountCurrency'].'</span>
          </div>
           <div syle="font-size:20px; font-weight: bold;">
             Services: <span>AED 0.000</span>
          </div>
           <div syle="font-size:20px; font-weight: bold;">
               <span syle="font-size:20px; font-weight: bold;">TOTAL TAX INCLUDE</span>
               <span>'.$hotel_details['total_price']['TypeCurrency'].' '.$hotel_details['total_price']['AmountCurrency'].'</span>
          </div>
      </td>
  </tr>
  </tbody>
</table>
   
          </div>';

            $html .= '<div class="w-100 card-detail-last-last-body">
 
            <img src="'.$location.'/laika13.png"  alt="footer" class="footer-image">
   
          </div>';





            $html .= '
</tr>
</table>
</div>
</div>';

        }
        $html .= '</div></body></html>';
//        echo $html;die();
        return $html;
    }

}
?>