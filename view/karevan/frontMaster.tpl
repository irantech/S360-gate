{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
 <title>{$obj->Title_head()}</title>
  <meta name="description" content="{$obj->Title_head()}">
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=0">
  <base href="{$smarty.const.CLIENT_DOMAIN}" />
  <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.ico" />
  <link rel="shortcut icon" type="image/x-icon" href="project_files/images/favicon.png" />
  
  <!-- Main CSS files -->
  <link rel="stylesheet" href="project_files/css/baseFa.css"> 
  <link rel="stylesheet" type="text/css" href="project_files/css/camera.css">
  <!-- Animation CSS file -->
  <link rel="stylesheet" href="project_files/css/animate.css">
  <!-- custom CSS file -->
  <link rel="stylesheet" href="project_files/css/lightgallery.css">
  <link rel="stylesheet" href="project_files/css/custom.css">
    <!-- plugin css file -->
  <link rel="stylesheet" href="project_files/css/plugin.css" >
  <link rel="stylesheet" href="project_files/css/responsive.css"> 
  <!-- jQuery Library files -->
  <script type="text/javascript" src="project_files/js/modernizr.js"></script>
  <script src="project_files/js/jquery-2.1.4.min.js"></script>
  
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}

</head>
<body>
	<div class="blackContainer"></div>
    <div class="body-wrapper scrollbar-dynamic">
        
         {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket}
        <div class="top-wrapper">
        
            <header>
<!--               	<a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/user/home.php" class="lang" target="_blank">En</a> -->
                <div class="logo-title">
                  <a class="logo" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/"><img src="project_files/images/logo.png" alt="تورآنتالیا-تور-تور ترکیه-نماینده انحصاری سان اکسپرس در ایران-کاروان هوایی2000-تورلحظه آخری-آژانس هواپیمایی"></a>
                  <div class="title">
                    <h1><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">{$smarty.const.CLIENT_NAME}</a></h1>
                    <h2>آژانس خدمات مسافرتی و گردشگری</h2>
                    <h2>نماینده انحصاری هواپیمایی سان اکسپرس در ایران</h2>
                  </div>
                </div>
                <div class="logo-phone">
                  <span class="f-tel-menu"></span><p class="txtRight lh20  marb10" dir="ltr"><span  class="ltr SMFooterPhone txt18 txtFFF yekan padr10">{$smarty.const.CLIENT_PHONE}</span></p>
                </div>
            	
            	<div class="clear"></div>
            	
            	<div class="top-menu">
            		<a class="mobMenu"></a>
            
             		<div class="mainMenuContainer yekan">
             		   <span class="close-menu"></span>
                        
                       <ul class="mainMenu">
                            <li class="active"><a class="img001" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">صفحه اصلی</a></li>
                            <li><a class="img006"  href="http://customeronline.karevan2000.com" target="_blank" style="color: red">خرید آنلاین تور</a></li>
                            <li class="" ><a class="img002">تورها</a>
                              <ul class="subMenu">
                                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour" class="m-h-out ">تورهای خارجی</a></li>
                                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1" class="m-h-out">تورهای داخلی</a></li>
                              </ul>
                            </li>
                            
                            {*<li class="has-menu m-h" ><a class="img003">تور ویژه</a>*}
                              {*<ul class="subMenu">*}
                                {*<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=tour&sptour=1" class="m-h-out ">تور ویژه خارجی</a></li>*}
                                {*<li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantour&level=1&sptour=1" class="m-h-out ">تور ویژه داخلی </a></li>*}
                              {*</ul>*}
                            {*</li>*}
            
                            <li class="has-menu m-h" ><a class="img004" >هتل ها</a>
                              <ul class="subMenu">
                                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=hotelcountry" class="m-h-out ">هتل های خارجی</a></li>
                                <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=iranhotelcity" class="m-h-out">هتل های داخلی</a></li>
                              </ul>
                            </li>    
                            
                            <li><a class="img005"  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=visacountry">اطلاعات ویزا</a></li>
                            <li><a class="img006"  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutcountry">معرفی کشورها</a></li>
                            <li><a class="img007"  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=3">مجله الکترونیک</a></li>
                            <li><a class="img10"   href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=specific&id=119" > اطلاعات ضروری سفر </a></li>
                            <li><a class="img008" >ارتباط با ما</a>
            	                <ul class="subMenu">
            		                <li><a class="img008"  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus">درباره ما</a></li>
            		                <li><a class="img009"  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus">تماس با ما</a></li>
            		                <li><a class="img005"  href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules">قوانین و مقررات</a></li>
            	                </ul>
                            </li>
                            <li>
	                            {if $objSession->IsLogin() }
	                            <a class="img010">کاربران</a>
	                            {else}
	                            <a class="img010">مسافران</a>
	                            {/if}
				                <ul class="subMenu">
				                  {if $objSession->IsLogin() }
		                            <li><a href="{$smarty.const.ROOT_ADDRESS}/userProfile">اطلاعات کاربری</a></li>
		                            <li><a href="{$smarty.const.ROOT_ADDRESS}/UserBuy">مشاهده خرید / استرداد </a></li>
		                            <li><a href="{$smarty.const.ROOT_ADDRESS}/TrackingCancelTicket">سوابق کنسلی</a></li>
                                    {if $smarty.const.IS_ENABLE_CLUB eq 1}
                                     <li> <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/login.php?clubID={$hashedPass}">ورود به باشگاه</a></li>
                                    {/if}
                                      {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
                                          <li>
                                              <a href="{$smarty.const.ROOT_ADDRESS}/Emerald">
                                                  <i class="fa fa-diamond margin-left-10 font-i"></i>زمرد</a>
                                          </li>
                                          <li>
                                              <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/Emerald/rahnamaye_zomorod_360.pdf">
                                                  <i class="fa fa-book margin-left-10 font-i"></i>راهنمای دریافت زمرد</a>
                                          </li>
                                      {/if}
                                      <li><a href="{$smarty.const.ROOT_ADDRESS}/UserPass">تغییر کلمه عبور</a></li>

                                      <li><a class="icon icon-study" onclick="signout()">خروج</a></li>
		                          {else}
				                	<li><a class="img008"  href="{$smarty.const.ROOT_ADDRESS}/loginUser">ورود</a></li>
					                <li><a class="img009 "  href="{$smarty.const.ROOT_ADDRESS}/registerUser">ثبت نام</a></li>
					              {/if}
				                </ul>
			                </li>

                           

                       </ul>
                     </div>
            
            	 </div>
                 <!-- menu-->
              
        	</header>
            
          
        
        </div>
        {/if}
        <!-- end top wrapper -->
        
        <div class="clear"></div>
    
        <!-- temp -->
        <div class="container temp">
            <div class="temp-content">
                <div class="clear"></div>
                <div class="temp-wrapper">
                
        		  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        		       
        	    </div>
            </div>
        </div>
        <!-- end temp -->
    
     
    	<!--Footer-->
    	 {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket}
    	<footer>
    	 <div class="top-footer" ">
    		<div class="container">
    	      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 wow slideInRight" data-wow-delay=".5s">
    	          <h5 class="f-title">اطلاعات تماس</h5>
    	            <p class="txt14 txtRight txtFFF lh20  marb10" dir="rtl"><span class="f-address"></span><span class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</span></p>
    	
    	            <p class="txtRight lh20  marb10" dir="ltr"><span class="f-tel"></span><span  class="ltr SMFooterPhone txt18 txtFFF yekan padr10">{$smarty.const.CLIENT_PHONE}</span></p>
    	    	
    	            <p class="txtRight lh20  marb10" dir="rtl"><span class="f-email"></span><a class="SMFooterEmail txt16 txtFFF tdNU padr10">{$smarty.const.CLIENT_EMAIL}</a></p>
    	       </div>
    	       
    	     <div class="mag-footer-cell col-xs-12 col-sm-12 col-md-8 col-lg-8 marb10 map-footers"> 
                   <div id="g-map"> </div> 
             </div>
    
          </div>
        </div>
    
    	
    		<!--CopyRight-->    
    		<div class="copyright " >
    			<div class="container">
    				<div class="col-lg-8 col-md-8 col-xs-12 company " >
    					<p class="txt14 yekan txtEEE">کلیه حقوق وب سایت متعلق به <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">{$smarty.const.CLIENT_NAME}</a> می باشد.</p>
    				</div>
    				<div class="col-lg-4 col-md-4 col-xs-12 irantech " >
    					<p class="txt14 yekan txtEEE">طراحی وب سایت: <a href="http://iran-tech.com/" target="_blank" class="irantech-link">ایران تکنولوژی</a><a href="http://www.safarbank.ir/tour/" target="_blank" class="cheapTour">تور ارزان</a></p>
    				</div>
    			</div>
    		</div>
    
    	</footer>
    	{/if}
    
    </div>
    
    <!--BACK TO TOP BUTTON-->
    <div class="backToTop"></div>


    <!-- jQuery Site Scipts -->
    {literal}
     <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtZ3tGybs75zk_7ic_Fij2QbqyFyG7wRU"></script>
            <script type="text/javascript">
                // When the window has finished loading create our google map below
                google.maps.event.addDomListener(window, 'load', init);
                function init() {
                    // Basic options for a simple Google Map
                    var mapOptions = {
                        zoom: 16,
                        scrollwheel: false,
                        center: new google.maps.LatLng({/literal}{$smarty.const.CLIENT_MAP_LAT}, {$smarty.const.CLIENT_MAP_LNG}{literal}),
                        mapTypeControlOptions: {
                            mapTypeIds: [google.maps.MapTypeId.TERRAIN]
                        },
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        // changing colors style goes her
                        styles: [{"featureType": "landscape", "stylers": [{"hue": "#FFBB00"}, {"saturation": 43.400000000000006}, {"lightness": 37.599999999999994}, {"gamma": 1}]}, {"featureType": "road.highway", "stylers": [{"hue": "#FFC200"}, {"saturation": -61.8}, {"lightness": 45.599999999999994}, {"gamma": 1}]}, {"featureType": "road.arterial", "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 51.19999999999999}, {"gamma": 1}]}, {"featureType": "road.local", "stylers": [{"hue": "#FF0300"}, {"saturation": -100}, {"lightness": 52}, {"gamma": 1}]}, {"featureType": "water", "stylers": [{"hue": "#0078FF"}, {"saturation": -13.200000000000003}, {"lightness": 2.4000000000000057}, {"gamma": 1}]}, {"featureType": "poi", "stylers": [{"hue": "#00FF6A"}, {"saturation": -1.0989010989011234}, {"lightness": 11.200000000000017}, {"gamma": 1}]}]
                    };
                    var mapElement = document.getElementById('g-map');
                    var map = new google.maps.Map(mapElement, mapOptions);
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng({/literal}{$smarty.const.CLIENT_MAP_LAT}, {$smarty.const.CLIENT_MAP_LNG}{literal}),
                        map: map,
                        title: '{/literal}{$smarty.const.CLIENT_NAME}{literal}',
                        icon: 'project_files/images/nav.png'
                    });
                    var infowindow = new google.maps.InfoWindow({
                        content: '<div class="googleLabel">{/literal}{$smarty.const.CLIENT_ADDRESS}{literal}</div>'
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker);
                    });
                }
            </script>
    <script type="text/javascript" src="project_files/js/wow.js"></script>
  	<script>
      wow = new WOW();
      wow.init();

    </script>

    <script src="project_files/js/jquery.vide.js"></script>
    <script src="project_files/js/script.js"></script>
	{/literal}
  
	{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}

</body>
</html>