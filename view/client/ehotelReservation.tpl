{literal}
<style type="text/css">
    .container{ display:table; border-bottom: 0px !important; }
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
	}
	.description{
		width: 93%;
		margin: 5px 40px 5px 40px;
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
    .nborder{border: none;}
    .btn-confirmHotel{
        border: 2px solid #75b2a6;
        padding: 5px 15px 5px 15px;
        background: #fff;
        color: #75b2a6;
        font-family: 'IRANSansMedium', 'IRANSansNumber';
        font-size: 12px;
        border-radius: 4px;
        transition: .2s;
        width: 86%;
        bottom: 10px;
        cursor: pointer;
        display: inline-block;
        text-align: center;
    }
    .btn-confirmHotel:hover {
        background: rgb(117, 178, 166);
        border-color: rgb(117, 178, 166);
        color: #f0eeee;
    }
    .text-voucher-hotel {
        margin: 5px 40px 5px 40px;
        font: normal 13px "Yekan", "YekanNumbers";
    }

    .text-voucher-hotel span {
        display: block;
        line-height: 40px;
    }

    .text-b {
        font-weight: bold;
    }
    .box-confirmHotel{
        position: relative;
        width: 36%;
        display: block;
        margin: 10px 0;
        text-align: center;
    }

    .description-voucher {
        line-height: 25px;
        font-size: 12px;
    }

    .description-voucher span {
        padding: 0 8px;
        line-height: 24px;
    }
    .directionLTR{direction: ltr;}
    .directionRTL{direction: rtl;}
	
</style>
{/literal}


{load_presentation_object filename="resultHotelLocal" assign="objResult"}

    {assign var='list' value=$objResult->getHotelDataNew($smarty.get.num)}
    {assign var="listOneDayTour" value=$objResult->getInfoReserveOneDayTour($smarty.get.num)}

    <div class="main">

        <div class="header-logo">
            <div class="header-logo-hotel" style="font-size: 15px;font-weight: bold;vertical-align: text-bottom;">
                {$list[0]['hotel_name']}
            </div>
            <div class="header-logo-hotel">
                <img src="project_files/images/logo.png" style="max-height: 80px;">
            </div>
        </div>

        <div class="text-voucher-hotel">

            <span>##Requestreservationhotel##</span>

            <span> ##Managerreservationhotel##  <b>{$list[0]['hotel_name']}</b>  </span>

            <span class="text-b">##Hidonated##</span>

            <div class="description-voucher">
                <span>##RoomReservationDateInThisList##</span>
                <span>##NecessaryArrangementForReservation##</span>
                <span>##TellUsDecreaseIncreaseCancel##</span>
            </div>


        </div>

        <div class="main-title">
            <span class="span-main-title">##HotelWatcher##</span>
        </div>

        {foreach key=key item=item from=$list}

        {if $key lt 1}

        <div class="border">

            <div class="row titleVoucherHotel">

                <div class="col-md-4 ">
                    <span class="span">##WachterNumber## : </span><span>{$item['request_number']}</span>
                </div>

                <div class="col-md-4 ">
                    <span class="span">##Buydate## : </span><span>{$objResult->set_date_reserve($item['payment_date'])}</span>
                </div>

                <div class="col-md-4 ">
                    <span class="span">##Buytime## : </span><span>{$objResult->set_time_payment($item['payment_date'])}</span>
                </div>

            </div>

            <div class="row VoucherHotel">
                <div class="col-md-6 ">
                    <span class="span">##Namehotel## : </span><span>{$item['hotel_name']}</span>
                </div>

                <div class="col-md-6 ">
                    <span class="span">##Hotelgrade## : </span><span>{$item['hotel_starCode']}</span>
                </div>

            </div>

            <div class="row VoucherHotel">

                <div class="col-md-6 ">
                    <span class="span">##Clockdeliveryroom## : </span><span> {$item['hotel_entryHour']} </span><span class="span"> تخلیه </span><span> {$item['hotel_leaveHour']}</span>
                </div>

                <div class="col-md-6 ">
                    <span class="span">##Hotelwork## : </span><span>{$item['hotel_telNumber']}</span>
                </div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-12 ">
                    <span class="span">##Addresshotel## : </span><span>{$item['hotel_address']}</span>
                </div>
            </div>

        </div>


        <div class="border">
            <div class="row VoucherHotel">
                <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##Informationguest##</span></div>
            </div>
            {/if}

            {if $item['flat_type'] eq 'DBL'}
                {assign var='flatType' value='##Bed##'}
            {elseif $item['flat_type'] eq 'EXT'}
                {assign var='flatType' value='##ExtrabedAdult##'}
            {else}
                {assign var='flatType' value='##Extrabedchild##'}
            {/if}
            <div class="row VoucherHotel">
                <div class="col-md-3 "><span class="span">##Room## : </span><span>{$item['room_name']} ({$flatType})</span>
                </div>
                <div class="col-md-3 "><span class="span">##Namefamily## :</span><span>{$item['passenger_name']} {$item['passenger_family']}</span>
                </div>
                <div class="col-md-3 "><span class="span">##Nationalnumber##/##Passport##:</span><span>{if ($item['passenger_national_code'] neq "")} {$item['passenger_national_code']} {else} {$item['passportNumber']} {/if}</span>
                </div>
                <div class="col-md-3 "><span class="span">##Happybirthday##: </span><span>{if $item['passenger_birthday'] neq ""} {$item['passenger_birthday']} {else} {$item['passenger_birthday_en']} {/if}</span>
                </div>
            </div>
            {/foreach}
        </div>

        {if $item['type_application'] eq 'reservation' && $listOneDayTour neq ''}
            <div class="border">
                <div class="row VoucherHotel">
                    <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##RequestDetails## ##Onetour##</span></div>
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


        {if $item['origin'] neq ''}
        <div class="border">
            <div class="row VoucherHotel">
                <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##Informationtravel##</span></div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-6"><span class="span">##Destination## :</span><span></span></div>
                <div class="col-md-6"><span class="span"> ##Origin##:</span><span>{$item['origin']}</span></div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-3"><span class="span">##NameTransport## :</span><span>{$item['airline_went']}</span></div>
                <div class="col-md-3"><span class="span">##Numflight## : </span><span>{$item['flight_number_went']}</span></div>
                <div class="col-md-3"><span class="span">##Starttime## : </span><span>{$item['hour_went']}</span></div>
                <div class="col-md-3"><span class="span">##Wentdate## : </span><span>{$item['flight_date_went']}</span></div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-3"><span class="span">##NameTransport## :</span>{$item['airline_back']}<span></span></div>
                <div class="col-md-3"><span class="span">##Numflight##  : </span><span>{$item['flight_number_back']}</span></div>
                <div class="col-md-3"><span class="span">##Returntime## : </span><span>{$item['hour_back']}</span></div>
                <div class="col-md-3"><span class="span">##Returndate## : </span><span>{$item['flight_date_back']}</span></div>
            </div>
        </div>
        {/if}


        <div class="border nborder">
            <div class="row VoucherHotel">
                <div class="col-md-6">
                    <span class="span"> ##ReserveLiability##: </span>
                    <span></span>
                </div>
                <div class="col-md-6">
                    <span class="span"> ##AgencyResponsible##: </span>
                    <span>{$item['agency_name']} / {$item['agency_accountant']}</span>
                </div>
            </div>
        </div>


        <form name="form1" method="post" action="">
            <div class="border nborder">
                <div class="row VoucherHotel">
                    <div class="col-md-12 directionLTR">
                        <div class="col-md-10"><span><input type="radio" name="confirmHotel" id="confirm" value="Ok" {if $item['status_confirm_hotel'] eq 'Ok'}checked{/if}></span></div>
                        <div class="col-md-2"> <span class="span"> Confirm  </span></div>
                    </div>
                    <div class="col-md-12 directionLTR">
                        <div class="col-md-10"><span><input type="radio" name="confirmHotel" id="reject" value="No" {if $item['status_confirm_hotel'] eq 'No'}checked{/if}></span></div>
                        <div class="col-md-2"> <span class="span"> Reject  </span></div>
                    </div>
                    <div class="col-md-12 directionLTR">
                        <div class="col-md-10"><span><input type="radio" name="confirmHotel" id="cancelConfirm" value="Cancel" {if $item['status_confirm_hotel'] eq 'Cancel'}checked{/if}></span></div>
                        <div class="col-md-2"> <span class="span"> Cancel Confirm  </span></div>
                    </div>
                    <div class="col-md-12 directionLTR">
                        <div class="col-md-10"><span><input type="text" id="codeConfirmHotel" name="codeConfirmHotel" value="{$item['code_confirm_hotel']}"></span></div>
                        <div class="col-md-2"> <span class="span"> code  </span></div>
                    </div>
                    <div class="col-md-12 directionLTR">
                        <div class="col-md-10"><span><textarea type="text" id="commentConfirmHotel" name="commentConfirmHotel">{$item['comment_confirm_hotel']}</textarea></span></div>
                        <div class="col-md-2"> <span class="span"> comment  </span></div>
                    </div>

                    <div class="col-md-12 directionLTR">
                        <span class="box-confirmHotel">
                            <button type="button" onclick="statusConfirmHotel({$item['factor_number']})"
                                    class="btn-confirmHotel site-main-button-color-hover">##Setstatusreservationroom##</button>
                        </span>
                    </div>

                    <div class="col-md-12 directionLTR">
                        <span class="box-confirmHotel" id="messageBook"></span>
                    </div>

                </div>
            </div>
        </form>

        <div class="clear-both"></div>

        <hr/>

        <div class="description text-center">
            <div class="header-col-50 pull-right">
                ##site## : <div style="direction: ltr; display: inline-block;">{$smarty.const.CLIENT_MAIN_DOMAIN}</div>
            </div>
            <div class="header-col-50 pull-right">
                ##Telephone## : <div style="direction: ltr; display: inline-block;">{$smarty.const.CLIENT_PHONE}</div>
            </div>
            <div class="header-col-100 pull-right"> ##Address## : {$smarty.const.CLIENT_ADDRESS} </div>

        </div>

        <div class="clear-both"></div>

    </div>


        

    </body>
</html>

{literal}
<script type="text/javascript">
    $(document).ready(function () {
        window.print();
    });
</script>
{/literal}