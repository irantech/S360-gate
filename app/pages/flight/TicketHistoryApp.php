<?php

error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

require  '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
//spl_autoload_register(array('Load', 'autoload'));

$TicketDetailAppController = Load::controller('TicketDetailApp');
$UserBuy = $TicketDetailAppController->TicketHistory();
?>
<div class="page" data-page="blit-info-1">

  <div class="page-content">
    <div class="nav-info site-bg-main-color">
    <div class="nav-info-inner">
      <div class="back-link">
        <a href="#" class="link back">
			<span></span>
        </a>
      </div>
      <div class="title">سوابق خرید</div>
    </div>
    </div>
    <div class="blit-info-page">


	  
		<div>
		<!--<table>
		<thead>
		<tr>
		<th class="label-cell">ردیف</th>
		<th class="label-cell">مبدا</th>
		<th class="label-cell">مقصد</th>
		<th class="label-cell">تاریخ خرید</th>
		<th class="label-cell">شماره فاکتور</th>
		<th class="label-cell">ایرلاین</th>
		<th class="label-cell">زمان حرکت</th>
		<th class="label-cell">مبلغ</th>
		<th class="label-cell">وضعیت</th>
		<th class="label-cell"> مشاهده بلیط</th>
		<th class="label-cell">استرداد</th>
		</tr>
		</thead>
		<tbody>

        <?php /*foreach ($UserBuy as $key=>$buy){

            $Airline = functions::InfoAirline($buy['airline_iata']);
            */?>

            <tr>
                <td class="numeric-cell"><?php /*echo $key + 1 */?></td>
                <td class="label-cell"><?php /*echo $buy['origin_city'] */?></td>
                <td class="label-cell"><?php /*echo $buy['desti_city'] */?></td>
                <td class="numeric-cell"><?php /*echo dateTimeSetting::jdate("Y-m-d H:i:s" ,$buy['creation_date_int']); */?></td>
                <td class="numeric-cell"><?php /*echo $buy['factor_number'] */?></td>
                <td class="label-cell"><?php /*echo $Airline['name_fa'].'('. (!empty($buy['flight_number']) ? $buy['flight_number'] : "--").')' */?></td>
                <td class="numeric-cell"><?php /*echo functions::DateJalali($buy['date_flight']);
                    echo functions::format_hour($buy['time_flight'])
                */?></td>
                <td class="label-cell"><?php /*echo functions::calcDiscountCodeByFactor(functions::CalculateDiscount($buy['request_number']),$buy['factor_number']) */?></td>
                <td class="label-cell"><?php
/*                  if($buy['successfull'] == 'prereserve'){
                        echo '<span class="button  color-orange">پیش رزرو</span>';
                    }else if($buy['successfull'] == 'bank'){
                        echo '<span class="button  color-Blue">هدایت به درگاه</span>';
                    }else if($buy['successfull'] == 'book'){
                        echo '<span class="button  color-green">رزرو قطعی</span>';
                    }else{
                          echo '<span class="button  color-red">نا مشخص</span>';
                      }*/?></td>
                <?php /*if($buy['successfull']=='book'){*/?>
                <td class="label-cell"><a href="#" class="button button-fill color-yellow showTicket" Requestnumber="<?php /*echo $buy['request_number']*/?>">مشاهده</a></td>
                <td class="label-cell"><a href="#" class="button button-fill color-gray cancelTicket" Requestnumber="<?php /*echo $buy['request_number']*/?>">استرداد</a></td>
                <?php /*}else{
                    */?>
                <td class="label-cell">-</td>
                <td class="label-cell">-</td>

                    <?php
/*                } */?>
            </tr>
        <?php /*} */?>

		</tbody>
		</table>-->




            <?php foreach ($UserBuy as $key=>$buy){
                $Airline = functions::InfoAirline($buy['airline_iata']);
                ?>
            <div class="blit-item savabegh-item site-border-main-color">

                <div class="blit-i-airline">
                    <img src="<?php echo functions::getAirlinePhoto($buy['airline_iata']) ?>"
                         alt="<?php echo $buy['airline_iata'] ?>"
                         title="<?php echo $buy['airline_iata'] ?>">
                </div>
                <div class="blit-i-info">
                    <div class="blit-i-info-top">
                        <div class="blit-i-city">
                            <span><?php echo $buy['origin_city'] ?></span>
                            <span>
				<svg class="site-bg-svg-color" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="432.243px" height="432.243px" viewBox="0 0 432.243 432.243"
                     style="enable-background:new 0 0 432.243 432.243;"
                     xml:space="preserve">
				<g>
				<g>
					<path d="M396.132,225.557l-29.051-16.144v-13.14c0-8.836-7.164-16-16-16c-7.342,0-13.515,4.952-15.396,11.693l-24.446-13.585
						v-12.108c0-8.836-7.164-16-16-16c-7.021,0-12.968,4.526-15.125,10.813l-21.689-12.053c-1.607-31.051-4.521-59.535-8.582-83.175
						c-3.221-18.753-7.029-33.617-11.318-44.179C236.346,16.317,229.72,0,216.123,0c-13.598,0-20.224,16.317-22.402,21.679
						c-4.289,10.562-8.097,25.426-11.318,44.179c-4.06,23.64-6.975,52.124-8.582,83.175l-21.69,12.053
						c-2.157-6.287-8.106-10.813-15.124-10.813c-8.837,0-16,7.164-16,16v12.108l-24.448,13.585
						c-1.882-6.742-8.055-11.693-15.396-11.693c-8.837,0-16,7.164-16,16v13.14L36.11,225.557c-3.174,1.766-5.143,5.11-5.143,8.741
						v41.718c0,3.237,1.568,6.275,4.208,8.151s6.024,2.356,9.083,1.291l128.616-44.829c1.189,40.082,4.47,77.047,9.528,106.496
						c0.917,5.342,1.884,10.357,2.895,15.059l-66.969,37.215c-1.725,0.958-2.794,2.774-2.794,4.749v22.661
						c0,1.761,0.852,3.41,2.286,4.431c1.434,1.018,3.272,1.278,4.935,0.701l78.279-27.284c3.598,4.531,8.53,8.329,15.088,8.329
						c6.558,0,11.49-3.798,15.087-8.329l78.279,27.284c0.584,0.201,1.188,0.303,1.788,0.303c1.113,0,2.216-0.342,3.146-1.004
						c1.434-1.021,2.285-2.669,2.285-4.431v-22.662c0-1.974-1.068-3.791-2.793-4.748l-66.969-37.215c1.01-4.7,1.977-9.715,2.895-15.059
						c5.059-29.447,8.339-66.414,9.527-106.496l128.617,44.829c1.071,0.374,2.184,0.558,3.29,0.558c2.05,0,4.078-0.631,5.791-1.849
						c2.642-1.875,4.209-4.914,4.209-8.151v-41.718C401.275,230.667,399.308,227.321,396.132,225.557z"/>
				</g>
				</g>
				</svg>
				</span>
                            <span><?php echo $buy['desti_city'] ?></span>
                        </div>
                        <div class="blit-i-time timeSortDep"><?php
                    echo functions::format_hour($buy['time_flight'])
                ?></div>
                    </div>
                    <div class="blit-i-info-bottom">
                        <div class="blit-i-airline-name"><?php echo $Airline['name_fa'].'('. (!empty($buy['flight_number']) ? $buy['flight_number'] : "--").')' ?>

                        </div>
                        <div class="blit-i-charter"><?php echo functions::DateJalali($buy['date_flight']);?></div>
                    </div>
                </div>
                <div class="blit-i-bottom savabegh-kharid-item">
                    <div class="savabegh-price">
                        <span>قیمت</span>
                        <span><?php $price = functions::calcDiscountCodeByFactor(functions::CalculateDiscount($buy['request_number']),$buy['factor_number']) ;
                                    echo number_format($price);
                            ?> ریال </span>
                    </div>
                    <div class="savabegh-faktor">
                        <span>شماره فاکتور</span>
                        <span><?php echo $buy['factor_number'] ?></span>
                    </div>
                    <div class="savabegh-date">
                        <span>تاریخ خرید</span>
                        <span><?php echo dateTimeSetting::jdate('Y-m-d H:i:s',$buy['creation_date_int'])?></span>
                    </div>
                    <div class="savabegh-btns">
                        <a class="site-border-main-color site-main-text-color cancelTicket"  Requestnumber="<?php echo $buy['request_number']?>">استرداد</a>
                        <a class="site-bg-main-color showTicket" Requestnumber="<?php echo $buy['request_number']?>">مشاهده</a>
                    </div>

                </div>
            </div>
            <?php } ?>



		</div>	  
	  
    </div>

</div>
</div>
