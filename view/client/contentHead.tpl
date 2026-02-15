<link href="assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet"/>

{if $smarty.const.SOFTWARE_LANG eq 'en' ||  $smarty.const.SOFTWARE_LANG eq 'ru'}
    {assign var='fileCss' value="/style-en"}
    {assign var='StyleSheet' value="StyleSheetEn"}
{else}
    {assign var='fileCss' value=""}
    {assign var='StyleSheet' value="StyleSheet"}
{/if}

{load_presentation_object filename="configurations" assign="objConfig"}

{*-------- {$smarty.session|print_r}*}
<link rel="stylesheet" href="assets/css{$fileCss}/jquery-confirm.min.css"/>

{if !in_array($smarty.const.GDS_SWITCH,['page'])}
<link rel="stylesheet" href="assets/css{$fileCss}/select2.min.css"/>
{/if}
<link type="text/css" rel="stylesheet" href="assets/datepicker/jquery-ui.min.css"/>
<link rel="stylesheet" href="assets/css{$fileCss}/owl.carousel.min.css"/>
<link rel="stylesheet" href="assets/css{$fileCss}/owl.theme.default.min.css"/>
<link rel="stylesheet" href="assets/css/jquery.fancybox.min.css"/>
<link rel="stylesheet" href="assets/css/bootstrap.min.css"/>


{if isset($smarty.session.layout) && $smarty.session.layout eq 'pwa'}
    <link rel="stylesheet" href="assets/app-Assets/css/font-awesom6.css"/>
    <link rel="stylesheet" href="assets/app-Assets/css/mainapp.css"/>
{/if}

{if
in_array($smarty.const.GDS_SWITCH,[
'resultInsurance',
'passengersDetailInsurance',
'factorInsurance'
])}
    <link rel="stylesheet" href="assets/styles/insurance.css"/>
    <link rel="stylesheet" href="assets/modules/css/mag.css"/>
{elseif
in_array($smarty.const.GDS_SWITCH ,[
'rentCar'
])
}
 <link rel="stylesheet" href="assets/styles/rentCar.css"/>
{elseif
in_array($smarty.const.GDS_SWITCH ,[
'reserveCar'
])
}

    <link rel="stylesheet" href="assets/styles/reserveCar/owl.carousel.min.css"/>
    <link rel="stylesheet" href="assets/styles/reserveCar/jquery.fancybox.min.css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles/reserveCar/style.css"/>
{elseif
    in_array($smarty.const.GDS_SWITCH,
    ['local',
    'international',
    'passengersDetailLocal',
    'goBankLocal',
    'factorLocal',
    'processFlight',
    'returnBankLocal',
    'showBookedTicketFlight',
    'internationalSearch',
    'searchFlight',
    'search-flight',
    'passengersDetailReservationTicket',
    'factorTicketReservation'
    ])
}
    <link rel="stylesheet" href="assets/styles{$fileCss}/flight.css"/>
{elseif
$smarty.const.GDS_SWITCH eq 'searchService' }
    <link rel="stylesheet" href="assets/styles{$fileCss}/subagency.css"/>
    <link rel="stylesheet" href="assets/css/placeholder-loading.min.css"/>
{elseif
$smarty.const.GDS_SWITCH eq 'app' }

    {elseif
in_array($smarty.const.GDS_SWITCH ,[
'buses',
'passengersDetailBusTicket',
'factorBusTicket'
])
}
    <link rel="stylesheet" href="assets/styles/bus.css"/>
{elseif
    in_array($smarty.const.GDS_SWITCH ,[
    'cancellationFee' ,
    'loginUser' ,
    'authenticate' ,
    'registerUser' ,
    'sendMailForm' ,
    'visaList' ,
    'visaNew' ,
    'tourList' ,
    'UserBuy' ,
    'tourGallery' ,
    'groupTourEdit' ,
    'UserPass' ,
    'UserTracking' ,
    'returnClub' ,
    'userProfile' ,
    'tourRegistration',
    'TrackingCancelTicket' ,
    'listTourDates' ,
    'entertainmentPanel' ,
    'editTour' ,
    'aboutUs',
    'rules',
    'loginAgency',
    'agencyProfile',
    'registerAgency',
    'reportAgency',
    'membersAgency',
    'counterAgencyAdd',
    'cancelAgency',
    'agencyPassengers',
    'listTransactionUser',
    'reportCreditAgency',
    'contactUs' ,
    'feedback'
    ])
}
    <link rel="stylesheet" href="assets/styles{$fileCss}/profile.css"/>
     <link rel="stylesheet" href="assets/styles/css/profile/profile.css"/>

{elseif in_array($smarty.const.GDS_SWITCH,[
    'roomManagement',
    'editHotel',
    'hotelList',
    'newHotel',
    'bookings' ,
    'hotelFinancialCenter',
    'hotelGallery',
'hotelRoomList' ,
'hotelRoomEdit' ,
'roomFacility',
    'roomGallery',
    'hotelInvoices',
    'hotelLog',
      'hotel',
    'hotelFacilities',
    'hotelRole',
    'newInvoice'
])
}
    <link rel="stylesheet" href="assets/styles{$fileCss}/profile.css"/>
    <link rel="stylesheet" href="assets/styles/css/profile/profile.css"/>
    <link rel="stylesheet" href="assets/marketPlace/css/hotel.css"/>
{elseif
    in_array($smarty.const.GDS_SWITCH,[
    'resultGasht',
    'passengersDetailGasht',
    'factorGasht',
    'GashtTransfer'
    ])
}
    <link rel="stylesheet" href="assets/styles/ghasht.css"/>
{elseif
in_array($smarty.const.GDS_SWITCH,[
'resultEntertainment',
'detailEntertainment',
'passengerDetailReservationEntertainment'
])
}
    <link rel="stylesheet" href="assets/styles/fun.css"/>
{elseif
    in_array(
    $smarty.const.GDS_SWITCH ,[
    'resultVisa',
    'passengersDetailVisa',
    'factorVisa'
    ])
}
    <link rel="stylesheet" href="assets/styles/visa.css"/>
{elseif in_array($smarty.const.GDS_SWITCH ,['rules'])}
    <link rel="stylesheet" href="assets/styles/rules.css"/>

{elseif
in_array($smarty.const.GDS_SWITCH, [ 'resultTrainApi','passengersDetailTrainApi','factorTrain',
'trainResult','trainFactor','trainPassengersDetail' ])}
    <link rel="stylesheet" href="assets/styles/train.css"/>
{elseif
    in_array($smarty.const.GDS_SWITCH,[
    'tours',
    'resultTourLocal',
    'passengerDetailReservationTour',
    'factorTourLocal',
    'detailTour',
    'detailTour-v2',
    'detailTour-v3'
    ])
}
    <link rel="stylesheet" href="assets/styles{$fileCss}/tour.css?v=2"/>
    <link rel="stylesheet" href="assets/styles{$fileCss}/tour-v2.css?v=2"/>
{elseif in_array($smarty.const.GDS_SWITCH,['exclusive-tour-detail'])}
    <link rel="stylesheet" href="assets/styles{$fileCss}/tour.css"/>
    <link rel="stylesheet" href="assets/styles{$fileCss}/tour-v2.css"/>
    <link rel='stylesheet' href="assets/styles{$fileCss}/exclusive-tour.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['cip-detail'])}
    <link rel='stylesheet' href="assets/styles{$fileCss}/cip.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['submitRequest'])}
    <link rel="stylesheet" href="assets/styles{$fileCss}/tour.css?v=2"/>
    <link rel="stylesheet" href="assets/styles{$fileCss}/tour-v2.css?v=2"/>
    <link rel="stylesheet" href="assets/styles{$fileCss}/hotel.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['mag','search-flight'])}
    <link rel="stylesheet" href="assets/modules/css/mag.css"/>

{elseif in_array($smarty.const.GDS_SWITCH,['recommendation'])}
    <link rel="stylesheet" href="assets/modules/css/recommendation.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['personnel'])}
    <link rel="stylesheet" href="assets/modules/css/personnel.css">
{elseif in_array($smarty.const.GDS_SWITCH,['appointment'])}
    <link rel="stylesheet" href="assets/modules/css/appointment.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['employment']) && $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/employment-en.css'>
{elseif in_array($smarty.const.GDS_SWITCH,['employment'])}
    <link rel="stylesheet" href="assets/modules/css/employment.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['sendDocuments'])}
    <link rel="stylesheet" href="assets/modules/css/sendDocuments.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['agencyList'])}
    <link rel="stylesheet" href="assets/styles/css/agent/agencyList.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['requestAgent'])}
    <link rel="stylesheet" href="assets/styles/css/agent/requestAgent.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['login'])}
    <link rel="stylesheet" href="assets/modules/css/login.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['register'])}
    <link rel="stylesheet" href="assets/modules/css/register.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['signRequest'])}
    <link rel="stylesheet" href="assets/modules/css/signRequest.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['vote'])}
    <link rel="stylesheet" href="assets/modules/css/vote.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['clock'])}
    <link rel="stylesheet" href="assets/modules/css/clock.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['orderServices'])}
    <link rel="stylesheet" href="assets/modules/css/orderServices.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['iranVisa'])}
        <link rel='stylesheet' href='assets/modules/css/iranVisa.css'>
{elseif in_array($smarty.const.GDS_SWITCH,['pay','payConfirm'])}
    <link rel="stylesheet" href="assets/modules/css/pay/style.css"/>
    <link rel="stylesheet" href="assets/modules/css/pay/owl.carousel.min.css"/>
    <link rel="stylesheet" href="assets/modules/css/pay/owl.theme.default.min.css"/>
{elseif in_array($smarty.const.GDS_SWITCH ,['profile','club','userBook','UserChangePass','visaEdit','passengerList','userWallet','transactionUser','listPointClubUser',
'tourList' ,'visaList' ,'visaNew' ,'tourGallery' ,'groupTourEdit','tourRegistration','listTourDates' ,'entertainmentPanel' ,'editTour' ])}
    <link rel="stylesheet" href="assets/styles/css/profile/profile.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['aboutIran'])}
    <link rel="stylesheet" href="assets/modules/css/aboutIran.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.theme.default.min.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['faq'])}
{if $smarty.const.SOFTWARE_LANG eq 'en'}

    <link rel="stylesheet" href="assets/styles/css/modules-en/faq-en.css"/>
    {else}
    <link rel="stylesheet" href="assets/modules/css/faq/faq.css"/>
{/if}
{elseif in_array($smarty.const.GDS_SWITCH,['aboutCountry'])}
    <link rel="stylesheet" href="assets/modules/css/aboutCountry.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.theme.default.min.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['weather'])}
    {if $smarty.const.SOFTWARE_LANG eq 'en'}
        <link rel='stylesheet' href='assets/styles/css/modules-en/weather-en.css'>
    {else}
        <link rel='stylesheet' href='assets/modules/css/weather.css'>
    {/if}
{elseif in_array($smarty.const.GDS_SWITCH,['video'])}
    <link rel="stylesheet" href="assets/modules/css/video.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.theme.default.min.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['gallery'])}
    <link rel="stylesheet" href="assets/styles/css/gallery/gallery.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.carousel.min.css"/>
    <link rel="stylesheet" href="assets/modules/css/owl.theme.default.min.css"/>
    <link rel="stylesheet" href="assets/modules/css/jquery.fancybox.min.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['currency'])}
    <link rel="stylesheet" href="assets/modules/css/currency.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['immigration','visa','pickup','embassy'])}
    <link rel="stylesheet" href="assets/modules/css/immigration.css"/>
{elseif in_array($smarty.const.GDS_SWITCH,['page'])}
    <link rel="stylesheet" href="assets/modules/css/page.css"/>

{elseif
in_array($smarty.const.GDS_SWITCH,[
'news'
])
}
<link rel="stylesheet" href="assets/modules/css/news.css"/>
{elseif
in_array($smarty.const.GDS_SWITCH,[
'embassies'
])
}
    <link rel="stylesheet" href="assets/styles{$fileCss}/embassies.css"/>
{elseif
in_array($smarty.const.GDS_SWITCH,[
'articles',
'searchHotel',
'passengersDetailReservationHotel',
'factorHotelLocal',
'resultExternalHotel',
'detailHotel',
'newPassengersDetail',
'resultHotelLocal',
'factorHotelNew'
])}
    <link rel="stylesheet" href="assets/styles{$fileCss}/hotel.css"/>
{elseif
in_array($smarty.const.GDS_SWITCH,[
'roomHotelLocal'
])}
    <link rel="stylesheet" href="assets/fonts/booking/booking.css"/>
    <link rel="stylesheet" href="assets/styles{$fileCss}/hotel.css"/>

{elseif
    in_array($smarty.const.GDS_SWITCH,[
    'searchPackage',
    'detailPassengersPackage',
    'factorPackage'
    ])}
    <link rel="stylesheet" href="assets/styles/stylePackage.css"/>
{elseif $smarty.const.GDS_SWITCH eq 'Zcontact' }
    <link rel="stylesheet" href="assets/styles/styleGasht.css"/>
{elseif $smarty.const.GDS_SWITCH eq 'rules' }
    <link rel="stylesheet" href="assets/styles/rules.css"/>
{else}
    <link rel="stylesheet" href="assets/css{$fileCss}/plugin.css"/>
    <!-- custom CSS file -->
    <link rel="stylesheet" href="assets/css{$fileCss}/jquery-confirm.min.css"/>
    <link rel="stylesheet" href="assets/css/nanoscroller.css"/>

    {*<link rel="stylesheet" href="assets/css/lobibox.min.css"/>*}

    <link rel="stylesheet" href="assets/css{$fileCss}/owl.carousel.min.css"/>
    <link rel="stylesheet" href="assets/css{$fileCss}/materialdesignicons.min.css"/>
    <link rel="stylesheet" href="assets/css{$fileCss}/owl.theme.default.min.css"/>
    <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css"/>

    <link rel="stylesheet" href="assets/css{$fileCss}/select2.min.css"/>
    <link rel="stylesheet" href="assets/css/addSlider.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/slider-pro.min.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="assets/css/placeholder-loading.min.css" media="screen"/>
    <link rel="stylesheet" href="assets/css{$fileCss}/custom.css"/>
    <link rel="stylesheet" type="text/css" href="{$smarty.const.ROOT_LIBRARY}/{$StyleSheet}.php" media="screen"/>
    <link rel="stylesheet" href="assets/css{$fileCss}/tour.css?v=2"/>
    <link rel="stylesheet" href="assets/css/hover.css"/>
    <link rel="stylesheet" href="assets/css{$fileCss}/azm.css"/>

{/if}




<link rel="stylesheet" type="text/css" href="{$smarty.const.ROOT_LIBRARY}/{$StyleSheet}.php" media="screen"/>
<link rel="stylesheet" href="assets/styles{$fileCss}/public.css"/>
<link rel="stylesheet" href="assets/css/sweetalert2.min.css"/>

{if $smarty.const.GDS_SWITCH eq 'reserveCar' }
    <link rel="stylesheet" href="assets/styles/reserveCar/select2.css"/>
{/if}


{*{if $smarty.const.SOFTWARE_LANG eq 'ar'}
    <link rel="stylesheet" href="assets/css/style-ar/ar.css"/>
{/if}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel="stylesheet" href="assets/css/style-en/en.css"/>
{/if}*}
<!-- coution: do not move this to up or down (or will conflict with jquery.ui.core) -->

{if $smarty.const.GDS_SWITCH neq 'app'}


    <script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>

    <!-- datepicker calendar -->
    <script type="text/javascript" src="assets/datepicker/jalali.js"></script>
    <script type="text/javascript" src="assets/datepicker/jquery.cookie.min.js"></script>
    <script type="text/javascript" src="assets/datepicker/jquery.ui.core.js"></script>
    <script type="text/javascript" src="assets/datepicker/jquery.ui.datepicker-cc.js"></script>
    <script type="text/javascript" src="assets/datepicker/datepicker-scripts.js"></script>
    <script type="text/javascript" src="assets/datepicker/datepicker-declarations.js"></script>
    <script type="text/javascript" src="assets/js/dropzone.min.js"></script>

    <!-- datatable scripts -->

    <link type="text/css" rel="stylesheet" href="assets/css/jquery.dataTables.min.css"/>
{/if}
<!-- Programer JS-->
<script type="text/javascript">
    var rootMainPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}';
    var returnableServices = {$objFunctions->returnableServices()|json_encode};
    var clientMainDomain = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_MAIN_DOMAIN}';
    var libraryPath = '{$smarty.const.ROOT_LIBRARY}/';
    var gdsSwitch = '{$smarty.const.GDS_SWITCH}';

    var amadeusPath = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/';
    var amadeusPathByLang = '{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}/gds/{$smarty.const.SOFTWARE_LANG}/';
    var lang = setLang('{$smarty.const.SOFTWARE_LANG}') ;

    var default_lang = '{$smarty.const.DEFAULT_LANG}';
    var main_color = '{$smarty.const.COLOR_MAIN_BG}';
    var main_dir_customer = '{$smarty.const.FRONT_TEMPLATE_NAME}';
    var refer_url = '{if isset($smarty.session.refer_url)} {$smarty.session.refer_url} {else} "" {/if}';
    var query_param_get = JSON.parse('{$smarty.get|json_encode}');

    function setLang(lang) {
      return  lang
    }
    function loadXMLDoc(filename)
    {

   xhttp=new XMLHttpRequest();
        xhttp.open("GET",filename,false);
        xhttp.send();
        return xhttp.responseXML;
    }
    function useXmltag(tagname) {

        // let get_translate = localStorage.getItem('translate_'+lang) ;

        result=xmlDoc.getElementsByTagName(tagname)[0];

        return result!=undefined ? result.childNodes[0].nodeValue : " ";

    }
    function translateXmlByParams(tagname, params) {
        let val = useXmltag(tagname);
        let entries = Object.entries(params);
        entries.forEach((para) => {
            let find = '@@' + para[0] + '@@';
            let regExp = new RegExp(find, 'g');
            val = val.replace(regExp, para[1])
        });
        return val;
    }

    xmlDoc=loadXMLDoc(rootMainPath+"/gds/langs/"+lang+"_frontMaster.xml");

</script>

<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="assets/js/sweetalert2.all.min.js"></script>

{if $smarty.const.GDS_SWITCH neq 'app'}
    <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.validate.js"></script>

    <script src="assets/js/galleryTour/mBox.js"></script>
    <script src="assets/js/galleryTour/script.js"></script>

    <script type="text/javascript" src="assets/js/customForHotel.js"></script>
    <script type="text/javascript" src="assets/js/customForExternalHotel.js"></script>
    <script type="text/javascript" src="assets/js/customForTour.js"></script>
    <script type="text/javascript" src="assets/js/customForInsurance.js"></script>
    <script type="text/javascript" src="assets/js/customForGasht.js"></script>
    <script type="text/javascript" src="assets/js/customForBus.js"></script>
    <script type="text/javascript" src="assets/js/customForEntertainment.js"></script>
    <script type="text/javascript" src="assets/js/customForVisa.js"></script>

    <script type="text/javascript" src="assets/js/customForTrain.js"></script>

    <script type="text/javascript" src="assets/js/customForVisa.js"></script>
    <script type="text/javascript" src="assets/js/jquery-confirm.min.js"></script>
    {*<script type="text/javascript" src="assets/js/lobibox.min.js"></script>*}
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.form.js"></script>
    <script type="text/javascript" src="assets/js/jquery.smoothscroll.min.js"></script>
    <script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>

{/if}
