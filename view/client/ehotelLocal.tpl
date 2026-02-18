{literal}
<style type="text/css">
    .main{ margin:30px auto 0;background-color: #fff; direction:rtl;}
	.border{border: 1px solid #75B2A6;margin: 5px 40px 5px 40px;}
	.titleVoucherHotel{
		padding: 8px;
		font-weight: bold;
		background-color: #75B2A6;
		margin: 0;
		color: #fff;
	}
	.VoucherHotel{
		padding: 8px;
		margin: 0;
        font-size: 17px;
	}
	.description{
		width: 93%;
		margin: 5px 40px 5px 40px;
        	font-size: 17px;
	}
	.description p{
		padding-right: 8px;
	}
	.span{font-weight: bold;}
    footer{display: none !important;}
    .header-col-50{ width: 50%; }
    .header-col-100{ width: 100%; }
    .clear-both{ clear: both; }
    .header-logo{
		margin:10px auto 0;
    }
    .header-logo-hotel{
		margin: 20px 0 0 0;
		width: 49%;
		display: inline-block;
		text-align: center;
    	height: 67px;
    }
    .main-title{
		position: relative;
		font-size: 17px;
		margin: 8px auto;
		color: #171717;
		text-align: center;
		padding: 0 10px;
		background: #fff;
    	width: 91%;
    }
	.main-title::before {
	    content: '';
	    width: 100%;
	    height: 1px;
	    bottom: 13px;
	    background: #75B2A6;
	    position: absolute;
	    margin: 0 auto;
	    display: block;
	    left: 0;
	    z-index: 1;
	}
	.span-main-title{
		background: #fff;
		position: relative;
		z-index: 1;
		padding: 0 15px;
	}
    .spanDate{
        direction: rtl;
        text-align: right;
        display: inline-block;
    }
    @media print {
        header{
            display: none;}
        .style_print{
            position: absolute;
            bottom: 0;
        }
    }
</style>
{/literal}

{load_presentation_object filename="resultHotelLocal" assign="objResult"}

    {assign var='list' value=$objResult->getHotelDataNew($smarty.get.num)}
    {assign var="listOneDayTour" value=$objResult->getInfoReserveOneDayTour($smarty.get.num)}

    <div class="main">

        <div class="header-logo">
            <div class="header-logo-hotel" style="font-size: 25px;font-weight: bold;vertical-align: text-bottom;">
                {$list[0]['hotel_name']}
            </div>
            <div class="header-logo-hotel">
                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.LOGO_AGENCY}" style="max-height: 80px;">
            </div>
        </div>

        <div class="main-title">
            <span class="span-main-title">##HotelWatcher##</span>
        </div>

        {foreach key=key item=item from=$list}

        {if $key lt 1}

        <div class="border">

            <div class="row titleVoucherHotel">

                <div class="col-md-4 text-right">
                    <span class="span">##WachterNumber## : </span><span>{$item['factor_number']}</span>
                </div>

                <div class="col-md-4 text-right">
                    <span class="span">##Buydate## : </span><span>{$objResult->set_date_reserve($item['payment_date'])}</span>
                </div>

                <div class="col-md-4 text-right">
                    <span class="span">##Buytime## : </span><span>{$objResult->set_time_payment($item['payment_date'])}</span>
                </div>

            </div>

            <div class="row VoucherHotel">
                <div class="col-md-6 text-right">
                    <span class="span">##Namehotel## : </span><span>{$item['hotel_name']}</span>
                </div>

                <div class="col-md-6 text-right">
                    <span class="span">##Hotelgrade## : </span><span>{$item['hotel_starCode']}</span>
                </div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-6 text-right">
                    <span class="span">##Enterdate## : </span><span class="spanDate">{$item['start_date']}</span>
                </div>
                <div class="col-md-6 text-right">
                    <span class="span">##Exitdate## : </span><span class="spanDate">{$item['end_date']}</span>
                </div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-6 text-right">
                    <span class="span">##TimeGaveRoom## : </span><span> {$item['hotel_entryHour']} </span><span class="span"> ##Discharge## </span><span> {$item['hotel_leaveHour']}</span>
                </div>

                <div class="col-md-6 text-right">
                    <span class="span">##Hotelwork## : </span><span>{$item['hotel_telNumber']}</span>
                </div>
            </div>
             <div class="row VoucherHotel">
                 <div class="col-md-6 text-right">
                     <span class="span">##ConfirmationHotel## : </span><span>{$item['pnr']}</span>
                 </div>
             </div>
            {if $item['time_entering_room'] neq ''}
            <div class="row VoucherHotel">
                <div class="col-md-6 text-right">
                    <span class="span">##Addresshotel## : </span><span>{$item['hotel_address']}</span>
                </div>
                <div class="col-md-6 text-right">
                    <span class="span">##timeEnteringRoom## : </span><span>{$item['time_entering_room']}</span>
                </div>
            </div>
            {else}
                <div class="row VoucherHotel">
                    <div class="col-md-12 text-right">
                        <span class="span">##Addresshotel## : </span><span>{$item['hotel_address']}</span>
                    </div>
                </div>
            {/if}
        </div>


        <div class="border">
            <div class="row VoucherHotel">
                <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##Informationguest## (##Firstguesroom##)</span></div>
            </div>
            {/if}

            {if $item['type_application'] eq 'reservation'}

                {if $item['flat_type'] eq 'DBL'}
                    {assign var='flatType' value='##Bed##'}
                {elseif $item['flat_type'] eq 'EXT'}
                    {assign var='flatType' value='##ExtrabedAdult##'}
                {elseif $item['flat_type'] eq 'ECHD'}
                    {assign var='flatType' value='##Extrabedchild##'}
                {/if}

                <div class="row VoucherHotel">
                    <div class="col-md-3 text-right"><span class="span">##Room## : </span><span>{$item['room_name']}</span>
                    </div>
                    <div class="col-md-2 text-right"><span class="span">##Flat## : </span><span>{$flatType}</span>
                    </div>
                    <div class="col-md-3 text-right"><span class="span"> ##Namefamily##   :</span><span>{$item['passenger_name']} {$item['passenger_family']}</span>
                    </div>
                    <div class="col-md-2 text-right">
                        {if ($item['passenger_national_code'] neq "")}
                            <span class="span"> ##Nationalnumber##:</span>
                            <span> {$item['passenger_national_code']} </span>
                        {else}
                            <span class="span">##Numpassport## :</span>
                            <span> {$item['passportNumber']} </span>
                        {/if}
                    </div>
                    <div class="col-md-2"><span class="span">##Happybirthday## : </span><span>{if $item['passenger_birthday'] neq ""} {$item['passenger_birthday']} {else} {$item['passenger_birthday_en']} {/if}</span>
                    </div>
                </div>
            {else}

                <div class="row VoucherHotel">
                    <div class="col-md-3 text-right"><span class="span">##Room## : </span><span>{$item['room_name']}</span>
                    </div>
                    {if ($item['passenger_name'] neq "")}
                    <div class="col-md-4 text-right"><span class="span">  ##Namefamily##  :</span><span>{$item['passenger_name']} {$item['passenger_family']}</span>
                    </div>
                   {else}
                    <div class="col-md-4 text-right"><span class="span">  ##Namefamily##  :</span><span>{$item['passenger_name_en']} {$item['passenger_family_en']}</span>
                    </div>
                   {/if}
                    <div class="col-md-3 text-right">
                        {if ($item['passenger_national_code'] neq "")}
                            <span class="span"> ##Nationalnumber##:</span>
                            <span> {$item['passenger_national_code']} </span>
                        {else}
                            <span class="span">##Numpassport## :</span>
                            <span> {$item['passportNumber']} </span>
                        {/if}
                    </div>
                    {if $item['source_id'] neq '29'}
                    <div class="col-md-2 text-right"><span class="span">##Happybirthday## : </span><span>{if $item['passenger_birthday'] neq ""} {$item['passenger_birthday']} {else} {$item['passenger_birthday_en']} {/if}</span>
                    </div>
                    {/if}
                </div>

            {/if}

            {/foreach}
        </div>


        {if $item['type_application'] eq 'reservation' && $listOneDayTour neq ''}
            <div class="border">
                    <div class="row VoucherHotel">
                        <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##Informationrequest## ##Onetour##</span></div>
                    </div>
                    {foreach  $listOneDayTour  as $val}
                        <div class="row VoucherHotel">
                            <div class="col-md-8">
                                <span class="span">##Title## : </span><span>{$val['title']}</span>
                            </div>
                            <div class="col-md-4">
                                <span class="span">##Price## :</span><span>{$val['price']}</span>
                            </div>
                        </div>
                    {/foreach}
            </div>
        {/if}


        {if $item['type_application'] eq 'reservation' && $item['origin'] neq ''}
            <div class="border">
                <div class="row VoucherHotel">
                    <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span> ##Informationtravel##</span></div>
                </div>

                <div class="row VoucherHotel">
                    <div class="col-md-6"><span class="span">##Destination## :</span><span></span></div>
                    <div class="col-md-6"><span class="span"> ##Origin## :</span><span>{$item['origin']}</span></div>
                </div>

                <div class="row VoucherHotel">
                    <div class="col-md-3"><span class="span"> ##NameTransport## : </span><span>{$item['airline_went']}</span></div>
                    <div class="col-md-3"><span class="span">##Numflight##  : </span><span>{$item['flight_number_went']}</span></div>
                    <div class="col-md-3"><span class="span"> ##Starttime## : </span><span>{$item['hour_went']}</span></div>
                    <div class="col-md-3"><span class="span"> ##Wentdate## : </span><span>{$item['flight_date_went']}</span></div>
                </div>

                <div class="row VoucherHotel">
                    <div class="col-md-3"><span class="span">##NameTransport##  : </span>{$item['airline_back']}<span></span></div>
                    <div class="col-md-3"><span class="span">##Numflight##  : </span><span>{$item['flight_number_back']}</span></div>
                    <div class="col-md-3"><span class="span">##Returntime##  : </span><span>{$item['hour_back']}</span></div>
                    <div class="col-md-3"><span class="span">##Returndate##  : </span><span>{$item['flight_date_back']}</span></div>
                </div>
            </div>
        {/if}


        <h2 style="font-size: 20px;display: block;text-align: right;margin: 10px 40px 0px 40px;font-weight:bold;margin-top: 1rem;margin-bottom: 1rem">
            <span> ##RespectableTravelerIsRequest##:  </span>
        </h2>

        <div class="description">
            <ul class='text-right'>
                <li>
                    ##Duelimitationsseasonhotelbookingshotel##
                    ##Assurancecaseproblemappropriateconditionsbook##
                </li>
                <li>##NeedBirthCertificateHotel##</li>
                <li>##HoursOfDeliveryAndEvacuationOfTheRoom##</li>
                <li>##VarietyHotelNoObligationProvide##</li>
                <li>##DepartureBasedPassengerRequest##</li>
                <li>##CancellationHotelReservationAmountNoRefundable##</li>
            </ul>
        </div>

        <div class="clear-both"></div>


        <div class="description text-center style_print">
            <hr/>
            <div class="header-col-50 pull-right">
                ##Site## : <div style="direction: ltr; display: inline-block;">{$smarty.const.CLIENT_MAIN_DOMAIN}</div>
            </div>
            <div class="header-col-50 pull-right">
                ##Telephone## : <div style="direction: ltr; display: inline-block;">{$smarty.const.CLIENT_PHONE}</div>
            </div>
            <div class="header-col-50 pull-right">
                ##ConfirmationHotel## : <div style="direction: ltr; display: inline-block;">{$item['pnr']}</div>
            </div>
            <div class="header-col-100 pull-right"> ##Address## : {$smarty.const.CLIENT_ADDRESS} </div>

        </div>

        <div class="clear-both"></div>

    </div>





{literal}
<script type="text/javascript">

    $(document).ready(function () {

        window.print();
    });
</script>
{/literal}