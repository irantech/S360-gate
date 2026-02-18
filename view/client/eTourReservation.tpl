{literal}
<style type="text/css">
    .container{ border-bottom: 0px !important; }
    .temp{ margin: 0 auto;}
    .temp-wrapper{ padding: 0;}
    .temp-content{ overflow: visible; padding: 0;}
    .main{ margin:30px auto 0;background-color: #fff;}
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
        	font-size: 12px;
	}
	.description{
		width: 93%;
		margin: 5px 40px 5px 40px;
        	font-size: 12px;
	}
	.description p{
		padding-right: 8px;
	}
	.span{font-weight: bold;}
    .s-u-header{display: none !important;}
    .menu{display: none !important;}
    .s-u-counter-menu{display: none !important;}
    .detail{display: none !important}
    footer{display: none !important;}
    .backToTop{display: none !important;}
    .header-col-15{ width: 15%; }
    .header-col-20{ width: 20%; }
    .header-col-25{ width: 25%; }
    .header-col-30{ width: 30%; }
    .header-col-35{ width: 35%; }
    .header-col-40{ width: 40%; }
    .header-col-45{ width: 45%; }
    .header-col-50{ width: 50%; }
    .header-col-75{ width: 75%; }
    .header-col-85{ width: 85%; }
    .header-col-100{ width: 100%; }
    .clear-both{ clear: both; }
    .thead-td{ border:1px solid #666 ; padding: 8px ; font-weight:bold }
    .tbody-td{ border:1px solid #666 ; padding: 8px }
    .pagebreak { page-break-after: always; }
    
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
    .header-logo-hotel span{
        display: block;
        margin-bottom: 5px;
    }
    .main-title{
		position: relative;
		font-size: 18px;
		margin: 8px auto;
		color: #171717;
		text-align: center;
		padding: 0 10px;
		background: #fff;
    	width: 91%;
    }
	.main-title::before {
	    content: '
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
    ul {
        list-style: none; /* Remove list bullets */
        padding: 0;
        margin: 0;
    }

    li {
        padding-left: 16px;
    }

    li:before {
        content: "•";
        padding: 5px;
        color: #68a195;
        /*font-size: 20px;*/
    }
    .spanDate{
        direction: rtl;
        text-align: right;
        display: inline-block;
    }

    #downloadLink {
        background-color: #75b2a6;
        color: #fff;
        padding: 2px 10px 2px 10px;
        border-radius: 50px;
        font-size: 12px !important;
        font-weight: 700 !important;
        border: 2px solid #75b2a6;
    }
    #downloadLink:hover {
        background-color: #fff;
        color: #75b2a6;
    }
    #downloadLink i{
        padding-right: 4px;
    }
	
</style>
{/literal}


{load_presentation_object filename="resultHotelLocal" assign="objResult"}

{assign var='infoBook' value=functions::GetInfoTour($smarty.get.num)}
{assign var='infoAgency' value=functions::infoAgencyByMemberId($infoBook['tour_agency_user_id'])}
{assign var='cancellationRules' value=functions::getTourCancellationRules($infoBook['tour_code'])}

    <div class="main">

        <div class="header-logo">
            <div class="header-logo-hotel">
                <span><img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$infoAgency['logo']}" style="max-height: 80px;"></span>
                <span>##TourProviderAgency##: {$infoBook['tour_agency_name']}</span>
            </div>

            <div class="header-logo-hotel">
                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.LOGO_AGENCY}" style="max-height: 80px;">
            </div>
        </div>

        <div class="border">

            <div class="row titleVoucherHotel">

                <div class="col-md-3">
                    <span>
                        {if $infoBook['status'] eq 'BookedSuccessfully'}
                            ##Definitivereservation##
                        {elseif $infoBook['status'] eq 'TemporaryReservation'}
                            ##Temporaryreservation##
                        {/if}
                    </span>
                </div>

                <div class="col-md-3">
                    <span class="span">##WachterNumber## : </span><span>{$infoBook['factor_number']}</span>
                </div>

                <div class="col-md-3">
                    <span class="span">##Buydate## : </span><span>{$objResult->set_date_reserve($infoBook['payment_date'])}</span>
                </div>

                <div class="col-md-3">
                    <span class="span">##Buytime## : </span><span>{$objResult->set_time_payment($infoBook['payment_date'])}</span>
                </div>

            </div>

            <div class="row VoucherHotel">
                <div class="col-md-3">
                    <span>##Nametour## : </span>
                    <span>{$infoBook['tour_name']}</span>
                </div>

                <div class="col-md-3">
                    <span>##codeTour## : </span>
                    <span>{$infoBook['tour_code']}</span>
                </div>

                <div class="col-md-3">
                    <span>##TotalPrice## : </span>
                    <span>{$infoBook['tour_total_price']|number_format:0:".":","}</span>
                </div>

                <div class="col-md-3">
                    <span>##Pricepayment## : </span>
                    {if $infoBook['status'] eq 'BookedSuccessfully'}
                        <span>{$infoBook['tour_total_price']|number_format:0:".":","}</span>
                        {else}
                        <span>{$infoBook['tour_payments_price']|number_format:0:".":","}</span>
                    {/if}
                </div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-3">
                    <span>##Origin## : </span>
                    <span>{$infoBook['tour_origin_country_name']} {$infoBook['tour_origin_city_name']} {$infoBook['tour_origin_region_name']} </span>
                </div>

                <div class="col-md-3">
                    <span>##ToursOfCity## : </span>
                    <span>{$infoBook['tour_cities']}</span>
                </div>

                <div class="col-md-3">
                    <span>##Wentdate## : </span>
                    <span>{$infoBook['tour_start_date']}</span>
                </div>

                <div class="col-md-3">
                    <span>##Returndate## : </span>
                    <span>{$infoBook['tour_end_date']}</span>
                </div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-3">
                    {if $infoBook['tour_night'] gt 0}
                        <span>{$infoBook['tour_night']}</span>
                        <span> ##Timenight## </span>
                    {else}
                        <span>{$infoBook['tour_day']}</span>
                        <span> ##Day## </span>
                    {/if}
                </div>

                <div class="col-md-3">
                    <span>##Permissibleamount##: </span>
                    <span>{$infoBook['tour_free']}</span>
                    <span> ##Kg## </span>
                </div>

                <div class="col-md-3">
                    <span>##Visa##: </span>
                    <span>{if $infoBook['tour_visa'] eq 'yes'}##Have##{else}##Donthave##{/if}</span>
                </div>

                <div class="col-md-3">
                    <span>##Insurance##: </span>
                    <span>{if $infoBook['tour_insurance'] eq 'yes'}##Have##{else}##Donthave##{/if}</span>
                </div>
            </div>

            <div class="row VoucherHotel">

                <div class="col-md-6">
                    <span>رفت {$infoBook['tour_type_vehicle_name_dept']}: </span>
                    <span>{$infoBook['tour_airline_name_dept']}</span>
                </div>

                {if $infoBook['tour_type_vehicle_name_return'] neq ''}
                <div class="col-md-6">
                    <span>برگشت {$infoBook['tour_type_vehicle_name_return']}: </span>
                    <span>{$infoBook['tour_airline_name_return']}</span>
                </div>
                {/if}

            </div>

        </div>



        <div class="border">
            <div class="row VoucherHotel">
                <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##PackageTour##</span></div>
            </div>

            {assign var="package" value=$infoBook['tour_package']|json_decode:true}
            {*assign var=tourTypeIdArray value=$infoBook['tour_type']|json_decode:true*}
            {*if 1|in_array:$tourTypeIdArray*}
            {if $infoBook['tour_night'] eq 0}

                <div class="row VoucherHotel">
                    <div class="col-md-4">
                        <span class="span">{$package['adult_count_oneDayTour']} ##Adult##: </span>
                        <span>{$package['adult_price_oneDayTour']|number_format:0:".":","} ##Rial##</span>
                    </div>
                    {if $package['child_count_oneDayTour'] gt 0}
                    <div class="col-md-4">
                        <span class="span">{$package['child_count_oneDayTour']} ##Child##: </span>
                        <span>{$package['child_price_oneDayTour']|number_format:0:".":","} ##Rial##</span>
                    </div>
                    {/if}
                    {if $package['infant_count_oneDayTour'] gt 0}
                    <div class="col-md-4">
                        <span class="span">{$package['infant_count_oneDayTour']} ##Baby##: </span>
                        <span>{$package['infant_price_oneDayTour']|number_format:0:".":","} ##Rial##</span>
                    </div>
                    {/if}
                </div>

            {else}

                {foreach $package['infoHotel'] as $hotel}
                    <div class="row VoucherHotel">
                        <div class="col-md-5">
                            <span class="span">##Hotelstaycity## {$hotel['city_name']}</span>
                        </div>
                        <div class="col-md-5">
                            <span class="span">##Hotel##: </span>
                            <span>{$hotel['hotel_name']}</span>
                        </div>
                        <div class="col-md-2">
                            <span class="span">##Serviceroom##: </span>
                            <span>{$hotel['room_service']}</span>
                        </div>
                    </div>
                {/foreach}
                <div class="row VoucherHotel">
                    
                    {foreach $package['infoRooms'] as $room}

                        <div class="col-md-4">
                            <span class="span">{$room['count']} ##Roomcount## {$room['name_fa'][0]}</span>
                            <span>{$room['total_price']|number_format:0:".":","} ##Rial## </span>
                            {if $room['total_price_a'] gt 0}
                                 + <span>{$room['total_price_a']|number_format:0:".":","} {$room['currency_type']} </span>
                            {/if}
                        </div>
                    {/foreach}
                </div>

            {/if}



        </div>


        <div class="border">
            <div class="row VoucherHotel">
                <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##Informationpassenger##</span></div>
            </div>

            {assign var='infoTourPassengers' value=functions::GetInfoTourPassengers($smarty.get.num)}
            <div class="row VoucherHotel">
                <div class="col-md-4">
                    <span class="span">##Namefamily## :</span>
                </div>
                <div class="col-md-3">
                    <span class="span">##Nationalnumber##</span> /
                    <span class="span">##Numpassport##:</span>
                </div>
                <div class="col-md-3">
                    <span class="span">##Happybirthday##: </span>
                </div>
                <div class="col-md-2">
                    <span class="span">##Downloadimg##</span>
                </div>
            </div>
            {foreach $infoTourPassengers as $passengers}
                <div class="row VoucherHotel">
                    <div class="col-md-4">
                        <span>{$passengers['passenger_name']} {$passengers['passenger_family']}</span>
                        {if $passengers['passenger_name_en'] neq '' || $passengers['passenger_family_en'] neq ''}
                             / <span>{$passengers['passenger_name_en']} {$passengers['passenger_family_en']}</span>
                        {/if}
                    </div>
                    <div class="col-md-3">
                        {if $passengers['passenger_national_code'] neq ""}
                            <span> {$passengers['passenger_national_code']} </span>
                        {/if}
                        /
                        {if $passengers['passportNumber'] neq ""}
                            <span> {$passengers['passportNumber']} </span>
                        {/if}
                    </div>
                    <div class="col-md-3">
                        <span>
                            {if $passengers['passenger_birthday'] neq ""}
                                {$passengers['passenger_birthday']}
                            {else}
                                {$passengers['passenger_birthday_en']}
                            {/if}
                        </span>
                    </div>
                    <div class="col-md-2">
                        <span>
                            {if $passengers['passenger_national_image'] neq ""}
                                <a id="downloadLink" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/passengersImages/{$passengers['passenger_national_image']}" target="_blank"
                                   type="application/octet-stream">##Downloadimg##<i class="fa fa-download"></i>
                                </a>
                            {elseif  $passengers['passenger_passport_image'] neq ""}
                                <a id="downloadLink" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/passengersImages/{$passengers['passenger_passport_image']}" target="_blank"
                                   type="application/octet-stream">##Downloadimg##<i class="fa fa-download"></i>
                                </a>
                            {/if}
                        </span>
                    </div>
                </div>
            {/foreach}

        </div>


        <h2 style="font-size: 16px;display: block;text-align: right;margin: 10px 40px 0px 40px;font-weight:bold">
            <span> ##Termsconditionsreservationinside##:  </span>
        </h2>
        <div class="description">
            {$cancellationRules}
            {*<ul>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
                <li>.</li>
            </ul>*}
        </div>
        <div class="clear-both"></div>
        <hr/>

        <div class="description text-center">
            <div class="header-col-50 pull-right">
                ##Site## : <div style="direction: ltr; display: inline-block;">{$smarty.const.CLIENT_MAIN_DOMAIN}</div>
            </div>
            <div class="header-col-50 pull-right">
                ##Telephone## : <div style="direction: ltr; display: inline-block;">{$smarty.const.CLIENT_PHONE}</div>
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