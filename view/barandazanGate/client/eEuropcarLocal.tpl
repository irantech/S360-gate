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
	
</style>
{/literal}


{load_presentation_object filename="resultHotelLocal" assign="objResult"}
{load_presentation_object filename="resultEuropcarLocal" assign="objResultEuropcar"}

{assign var='infoBook' value=functions::GetInfoEuropcar($smarty.get.num)}

    <div class="main">

        <div class="header-logo">
            <div class="header-logo-hotel" style="font-size: 15px;font-weight: bold;vertical-align: text-bottom;">
                {if $infoBook['status'] eq 'BookedSuccessfully'}
                    ##Carvoucher##
                {else}
##Tempvoucher##                {/if}
            </div>
            <div class="header-logo-hotel">
                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.LOGO_AGENCY}" style="max-height: 80px;">
            </div>
        </div>

        {*<div class="main-title">
            <span class="span-main-title">واچر اجاره خودرو</span>
        </div>*}


        <div class="border">

            <div class="row titleVoucherHotel">

                <div class="col-md-4 ">
                    <span class="span">##WachterNumber## : </span><span>{$infoBook['factor_number']}</span>
                </div>

                <div class="col-md-4 ">
                    <span class="span">##Buydate## : </span><span>{$objResult->set_date_reserve($infoBook['payment_date'])}</span>
                </div>

                <div class="col-md-4 ">
                    <span class="span">##Buytime## : </span><span>{$objResult->set_time_payment($infoBook['payment_date'])}</span>
                </div>

            </div>

            <div class="row VoucherHotel">
                <div class="col-md-4">
                    <span>##Namecar##  : </span>
                    <span>{$infoBook['car_name']}</span>
                </div>

                <div class="col-md-4">
                    <span>##Model## : </span>
                    <span>{$infoBook['car_name_en']}</span>
                </div>

                <div class="col-md-4">
                    <span>##Pricepayment## : </span>
                    <span>{$infoBook['total_price']|number_format:0:".":","}</span>
                </div>
            </div>

            {$objResultEuropcar->getDay($infoBook['get_car_date_time'], $infoBook['return_car_date_time'])}
            <div class="row VoucherHotel">
                <div class="col-md-4">
                    <span>##Delivery## : </span>
                    <span>{$infoBook['source_station_name']}</span>
                </div>

                <div class="col-md-4">
                    <span> ##Deliverydate## : </span>
                    <span>{$objResultEuropcar->getCarDate}</span>
                </div>

                <div class="col-md-4">
                    <span>##Timedelivery## : </span>
                    <span>{$objResultEuropcar->getCarTime}</span>
                </div>
            </div>
            
            <div class="row VoucherHotel">
                <div class="col-md-4">
                    <span>##Return## : </span>
                    <span>{$infoBook['dest_station_name']}</span>
                </div>

                <div class="col-md-4">
                    <span>##Returndate## : </span>
                    <span>{$objResultEuropcar->returnCarDate}</span>
                </div>

                <div class="col-md-4">
                    <span>##Returntime## : </span>
                    <span>{$objResultEuropcar->returnCarTime}</span>
                </div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-2">
                    <span>##Capacity##: </span>
                    <span>{$infoBook['car_passenger_count']}</span>
                    <span> ##People## </span>
                </div>

                <div class="col-md-3">
                    <span>##MaximumKm##: </span>
                    <span>{$infoBook['car_allowed_km']}</span>
                    <span> km </span>
                </div>

                <div class="col-md-2">
                    <span>##Minimumagedriver##: </span>
                    <span>{$infoBook['car_min_age_to_rent']}</span>
                </div>

                <div class="col-md-3">
                    <span>##Priceperkilometerextra##: </span>
                    <span>{$infoBook['car_add_km_cos_rial']}</span>
                    <span> ##Rial## </span>
                </div>

                {if $infoBook['car_insurance_cost_rial'] neq 0}
                <div class="col-md-2">
                    <span>##Insuranceprice##: </span>
                    <span>{$infoBook['car_insurance_cost_rial']}</span>
                    <span> ##Rial## </span>
                </div>
                {/if}

            </div>

            <div class="row VoucherHotel">
                <div class="col-md-3">
                    <span>##Refundtype## :</span>
                    <span>
                        {if ($infoBook['refund_type'] == '1')}
                            ##Checkbook##
                        {elseif ($infoBook['refund_type'] == '2')}
                            ##Promissorynote##
                        {elseif ($infoBook['refund_type'] == '3')}
                            ##Cash##
                        {/if}
                    </span>
                </div>
                <div class="col-md-3">
                    <span>##Typevehiclecrimewarranty##:</span>
                    <span>
                        {if ($infoBook['driving_crimes_type'] == '1')}
                            ##Checkbook##
                        {elseif ($infoBook['driving_crimes_type'] == '2')}
                            ##Promissorynote##
                        {elseif ($infoBook['driving_crimes_type'] == '3')}
                            ##Cash##
                        {/if}
                    </span>
                </div>
                <div class="col-md-3">
                    <span> ##Deliverycarincustomersite## </span>
                    <span>
                        {if ($infoBook['has_source_station_return_cost'] == '1')}
                            ##Have##
                        {elseif ($infoBook['has_source_station_return_cost'] == '2')}
                            ##Donthave##
                        {/if}
                    </span>
                </div>
                <div class="col-md-3">
                    <span> ##Refundscaratthecustomerpremises## </span>
                    <span>
                        {if ($infoBook['has_dest_station_return_cost'] == '1')}
                            ##Have##
                        {elseif ($infoBook['has_dest_station_return_cost'] == '2')}
                            ##Donthave##
                        {/if}
                    </span>
                </div>
            </div>

            <div class="row VoucherHotel">
            </div>


        </div>


        {assign var="thingInfo" value=$objResultEuropcar->jsonDecodeThing($infoBook['reserve_car_thing_info'])}
        {if $thingInfo neq ''}
        <div class="border">
            <div class="row VoucherHotel">
                <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##Selectedcaraccessorieslist##</span></div>
            </div>

            <div class="row VoucherHotel">
                {foreach $thingInfo as $thing}
                <div class="col-md-6"><span class="span">##Title##: </span><span>{$thing['thingsName']}</span></div>
                <div class="col-md-6"><span class="span">##Numberofrequests##: </span><span>{$thing['countThings']}</span></div>
                {/foreach}
            </div>

        </div>
        {/if}


        <div class="border">
            <div class="row VoucherHotel">
                <div class="col-md-12 modal-text-center modal-h" style="border: none;"><span>##InformationSaler## </span></div>
            </div>

            <div class="row VoucherHotel">
                <div class="col-md-3"><span class="span"> ##Namefamily##   :</span><span>{$infoBook['passenger_name']} {$infoBook['passenger_family']}</span></div>
                <div class="col-md-3">
                    {if ($infoBook['passenger_national_code'] neq "")}
                        <span class="span">##Nationalnumber##:</span>
                        <span> {$infoBook['passenger_national_code']} </span>
                    {else}
                        <span class="span">##Numpassport##:</span>
                        <span> {$infoBook['passportNumber']} </span>
                    {/if}
                </div>
                <div class="col-md-3"><span class="span">##Happybirthday##: </span>
                    <span>
                        {if $infoBook['passenger_birthday'] neq ""}
                            {$infoBook['passenger_birthday']}
                        {else}
                            {$infoBook['passenger_birthday_en']}
                        {/if}
                    </span>
                </div>
                <div class="col-md-3"><span class="span">##Email##: </span><span>{$infoBook['passenger_email']}</span></div>

            </div>

            <div class="row VoucherHotel">
                <div class="col-md-2"><span class="span">##Telephone##: </span><span>{$infoBook['passenger_telephone']}</span></div>
                <div class="col-md-2"><span class="span">##Phonenumber##: </span><span>{$infoBook['passenger_mobile']}</span></div>
                <div class="col-md-8"><span class="span">##Address##: </span><span>{$infoBook['passenger_address']}</span></div>
            </div>


        </div>


        {*<h2 style="font-size: 16px;display: block;text-align: right;margin: 10px 40px 0px 40px;font-weight:bold">
            <span> شرایط و ضوابط برای خدمات ترانسفر داخلی:  </span>
        </h2>
        <div class="description">
            <ul>
                <li>مدت انتظار راننده در فرودگاه، به مدت 1 ساعت از زمان اعلام شده توسط خریدار خدمات می باشد.</li>
                <li>تاخیر بیش از یک ساعت شامل هزینه ساعت اضافی می گردد.</li>
                <li>اعتبار واچر از زمان اعلام شده توسط خریدارخدمات، به مدت 3 ساعت می باشدکه در صورت عدم مراجعه مسافر واچر باطل و رزرو کنسل تلقی می گردد.</li>
                <li>انتظار بیش از 3 ساعت در فرودگاه منوط به درخواست خریدار خدمات می باشد.</li>
                <li>در صورت تردد در محدوده طرح ترافیک شهرها، گزینه مجوز طرح ترافیک در قسمت تجهیزات اضافه انتخاب شود.</li>
                <li>هرگونه اصلاح یا تغییر در رزرو در صورت تماس با سرویس دهنده تا 24 ساعت قبل از شروع خدمات مقدور می باشد.</li>
                <li>در خصوص تغییرات اعمال شده کمتر از 24 ساعت پیش از شروع خدمات، یوروپکار مسئولیتی در قبال انجام خدمات درخواستی ندارد.</li>
                <li>انتخاب" گروه خودرو" به عهده مشتری و انتخاب "نوع خودرو" به عهده یوروپکار می باشد.</li>
                <li>در صورت لغو رزرو تا 24 ساعت قبل از شروع خدمات 10% هزینه، تا قبل از 12 ساعت 50% هزینه و درصورت عدم مراجعه مسافر 100% هزینه ترانسفر دریافت خواهد شد.</li>
                <li>راننده موظف به ارائه خدمات طبق ووچر صادره می باشد. در صورت نیاز به خدمات بیشتر، خریدار خدمات موظف به تماس با ایستگاه سرویس دهنده جهت انجام هرگونه هماهنگی می باشد.</li>
                <li>راننده موظف به ارائه خدمات طبق ووچر صادره می باشد. در صورت نیاز به خدمات بیشتر، خریدار خدمات موظف به تماس با ایستگاه سرویس دهنده جهت انجام هرگونه هماهنگی می باشد.</li>
            </ul>
        </div>
        <div class="clear-both"></div>
        <hr/>*}

        <h2 style="font-size: 16px;display: block;text-align: right;margin: 10px 40px 0px 40px;font-weight:bold">
            <span> ##TermsConditionsRentalInside##:  </span>
        </h2>
        <div class="description">
            <ul>
                <li>##MinimumRentalHoursFullDay##</li>
                <li>##PriceDecreaseNumberSelectedDays##</li>
                <li>##CostGasolineResponsibilityCustomer##</li>
                <li>##PermittedCalculatedDailyBasis##</li>
                <li>##CustomerCanDeliverCarStationTransfer##</li>
                <li>##DeliveryReturnCarCustomerPremises##</li>
                <li>##SomeAirportsChargesCalculated##</li>
                <li>##FineRefundedCustomerDaysRefundCar##</li>
                <li>##AllCarCompaniesInsurance##</li>
                <li>##AgeRangeYearsSomeGroup##</li>
                <li>##DeliveryRefundOfficeStationSurcharges##</li>
                <li>##AddressStatedCustomerDeliveryReturnCarScope##</li>
                <li>##CleanCarDeliveredCustomer##</li>
                <li>##ProvideRequiredDocumentation##</li>
                <li>##PaymentRentCash##</li>
            </ul>
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