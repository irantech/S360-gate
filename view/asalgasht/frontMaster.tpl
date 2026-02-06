{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="hashedPass" value=functions::HashKey({$smarty.session.cardNo},'encrypt')}
<!DOCTYPE html>
<html class="no-js" lang="en">
    
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">

  <!-- Page Title Here -->
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



  <link rel="stylesheet" href="project_files/css/custom.css">
    <!-- plugin css file -->
 
  <link rel="stylesheet" href="project_files/css/plugin.css" >
  <!-- <link rel="stylesheet" href="project_files/css/responsive1.css">  -->
  <link rel="stylesheet" href="project_files/css/responsive.css"> 
  <!-- jQuery Library files -->

    <script src="project_files/js/jquery-2.1.4.min.js"></script>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
    <!-- Start of DANA Chat Script-->
    <script type='text/javascript'>
        window.$_DANACHAT_API || (function (d, w) {
            var r = $_DANACHAT_API = function (c) { r._.push(c); };
            w.__danachat_app_base_url = '/Dana/';w.__danachat_host_url = 'https://asalgasht.danaabr.com';
            w.__danachat_account = 'E433FD9C3AE424C56FD4CCF8A5BE630256EC76F3D1A7C52B0B7B324C8255FA59C84308247C9A4C01';
            w.__danachat_widget = 'E433FD9C3AE424C56FD4CCF8A5BE630256EC76F3D1A7C52B0B7B324C8255FA59C84308247C9A4C01';
            w.__danachat_profile = 'E433FD9C3AE424C56FD4CCF8A5BE630256EC76F3D1A7C52B0B7B324C8255FA59C84308247C9A4C01';
            w.__danachat_version = 1;w.__danachat_ci = 'DanaChatApp';w.__danachat_cs = '311089434AFB6B7D5842AEDC542356CC6AD25B1E';
            r._ = [];var rc = d.createElement('script');rc.type = 'text/javascript';rc.async = true;rc.setAttribute('charset', 'utf-8');
            rc.src = w.__danachat_host_url + w.__danachat_app_base_url + 'Resources/Dana/chat/js/dpx.danachat.embed.js' + '?' + new Date().getTime();
            var s = d.getElementsByTagName('script')[0];s.parentNode.insertBefore(rc, s);
        })(document, window);
    </script>
    <!-- End of DANA Chat Script -->
        
</head>
<body>
<div class="blackContainer"></div>
<div class="body-wrapper">
  {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket}
  <div class="top-wrapper temp-top-wrapper">

    <header class="float-panel navbar navbar-fixed-top">
      <div class=" top-navbar-wrapper">

                            <div class="container">
                                

                                <div class="sfm-headerBar-social col-lg-7 col-md-7 col-sm-12 col-xs-12 ">
                                    <div class="topLogin">
                                        <ul>  
                                                  {if $objSession->IsLogin() }
                                            <li>
                                                <div class="dashboard_menu">
                                                  <button><i class="fa fa-user" aria-hidden="true"></i></button>
                                                  <ul id="dropdown-list">

                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                                                        <i class="fa fa-user margin-left-10 font-i"></i>اطلاعات کاربری</a>
                                                    </li>
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/UserBuy">
                                                        <i class="fa fa-shopping-cart margin-left-10 font-i"></i>مشاهده خرید / استرداد </a>
                                                    </li>
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/TrackingCancelTicket">
                                                        <i class="fa fa-ban  margin-left-10 font-i"></i> سوابق کنسلی</a>
                                                    </li>

                                                    {if $smarty.const.IS_ENABLE_CLUB eq 1}
                                                    <li>
                                                        <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/login.php?clubID={$hashedPass}">
                                                        <i class="fa fa-users  margin-left-10 font-i"></i> ورود به باشگاه</a>
                                                    </li>
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
                                                    <li>
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/UserPass">
                                                        <i class="fa fa-key margin-left-10 font-i"></i>تغییر کلمه عبور</a>
                                                    </li>
                                                        <li>
                                                        <a class="icon icon-study" onclick="signout()">
                                                        <i class="fa fa-sign-out margin-left-10 font-i"></i>خروج</a>
                                                    </li>
                                                  </ul>
                                                </div>

                                                <a class="userProfile-name" href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                                                    <span >دوست عزیز {$objSession->getNameUser()} خوش آمدید</span>
                                                    {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
                                                    <span class="CreditHide yekanB">اعتبار آژانس شما {$objFunctions->CalculateCredit($objSession->getUserId())}ریال می باشد </span>
                                                    {/if}
                                                </a>

                                            </li>
                                                    {else}
                                            <li> 
                                              
                                            	<a href="{$smarty.const.ROOT_ADDRESS}/registerUser">
                                                <i class="fa fa-user " aria-hidden="true"></i> 
                                                <span> ثبت نام </span></a>
                                            </li>
                                            <li>
                                                <a href="{$smarty.const.ROOT_ADDRESS}/loginUser">
                                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                                <span>ورود</span></a> 
                                            </li>
                                            {/if}
                                        </ul>
                                    </div>
                                </div>
                                <div class="sfm-headerBar-menu col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                    <div class="sfm-headerBar-mail fa fa-envelope-o"><a class="SMFooterEmail">{$smarty.const.CLIENT_EMAIL}</a></div>
                                    <div class="sfm-headerBar-phone fa fa-phone"><span class="SMFooterPhone">{$smarty.const.CLIENT_PHONE}</span></div>
                                </div>
                                <div class="clear"></div>
                            </div>
      </div>
  <div class=" container">
  <div class="row">
    <div class="logo">
      <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/" >
        <img src="project_files/images/logo.png" alt="{$smarty.const.CLIENT_NAME}">
      </a>
  <!--     <div class="title">
        <h2> شرکت خدمات مسافرتی و جهانگردی </h2>
      </div> -->
    </div>

    <div class="main-menu">

       <nav>
            <div class="menu-toggle">
                
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

          <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
                <li>
                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/home.php"><span class="title">صفحه اصلی</span></a>
                </li>
                <li>
                    <a href="javascript:;"><span class="title">تورها</span></a>
                    <ul>
                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=irantourcity&level=1">تور داخلی</a></li>
                        <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=countrytour">تور خارجی</a></li>
                        <li id="other-tour">
                            <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=alltours" class="SMAllTours"> تورها در یک نگاه</a>
                        </li>
                    </ul>
                </li>

                <li><a href="javascript:;"><span class="title">اطلاعات گردشگری</span></a>
                  <ul>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutcountry" class ="SMAboutCountry"><span class="title ">معرفی کشورها</span></a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutiran" class="SMAboutIran"> <span class="title ">معرفی ایران </span></a></li>
                   
                  </ul>
                
                <li>
                  <a href="javascript:;"> <span class="title">خدمات</span></a>
                  <ul>
                    <li><a href="{$smarty.const.ROOT_ADDRESS}/UserTracking"><span class="title">پیگیری خرید</span></a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=visacountry" class="SMVisa"> <span class="title SMVisa">اطلاعات ویزا</span></a></li>
                    <li><a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=pay" class="SMPay"><span class="title SMPay">پرداخت آنلاین</span></a>  </li>
                  </ul>
                </li>
                <li>
                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=packageregister" class="SMPackageRegister"><span class="title SMPackage">عضویت همکار</span></a>
                </li>   
                 <li>
                    <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=contactus" class="SMContactUs"><span class="title">تماس با ما</span></a>
                </li>                         

               </ul>
        </nav>
    </div>
  </div>
</div>
    
</header>

</div>
 {/if}
 <div class="clear"></div> 


    <!-- temp -->
    <div class="container temp">
   		<div class="temp-content">
        	<div class="temp-wrapper">
        		{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        	</div>
    	</div>
    </div>
<!-- end temp -->
<div class="clear"></div>



  <!--Footer-->
   {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket}
 <footer>

    <div class="footer " >
      <div class="container">
        <div class="row">
           <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <h4 class="footerTitle"><span>دسترسی سریع</span></h4>
               <ul class="footer-list-menu">

                <li class="items">
                    <span><i class="fa fa-circle addressIcon addressIconSize "></i></span>
                    <span > <a class="SMRules" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=rules">قوانین و مقررات</a></span>
                </li>
                <li class="items">
                    <span><i class="fa fa-circle addressIcon addressIconSize"></i></span>
                    <span > <a class="" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگری خرید</a></span>
                </li>
                  <li class="items">
                    <span><i class="fa fa-circle addressIcon addressIconSize"></i></span>
                    <span > <a class="SMVisa" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=visacountry">اطلاعات ویزا</a></span>
                </li>
                  <li class="items">
                    <span><i class="fa fa-circle addressIcon addressIconSize"></i></span>
                    <span > <a class="SMPay" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=pay" class="m-pay">پرداخت آنلاین</a></span>
                </li>
              </ul>
               <div class="zarinpal_">

                   <script src="https://cdn.zarinpal.com/trustlogo/v1/trustlogo.js" type="text/javascript"></script>

               </div>
            </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
            <h4 class="footerTitle"><span>تماس باما</span></h4>
             
              <ul class="footer-list-menu">
                <li class="items lh40">
                   <span><i class="fa fa-map-marker addressIcon"></i></span>
                  <span class="SMFooterAddress">{$smarty.const.CLIENT_ADDRESS}</span>
                </li>

                <li class="items lh40">
                    <span><i class="fa fa-volume-control-phone  addressIcon "></i></span>
                    <span class="ltr">
                      <a class="SMFooterPhone ">{$smarty.const.CLIENT_PHONE}</a>
                    </span>
                </li>
                <li class="items lh40">
                    <span><i class="fa fa-envelope addressIcon txt13"></i></span>
                    <a  class="SMFooterEmail  ">{$smarty.const.CLIENT_EMAIL}</a>
                </li>
              </ul>
             <ul class="footer-list-menu">
             
              <div class="contact-details dark social">
                
                <span><i class="fa fa-paper-plane addressIconSocial "><a  target="_blank" class="SMTelegram "></a></i></span>
                <span><i class="fa fa-instagram addressIconSocial "><a  target="_blank" class="SMInstageram "></a></i></span>
                <span><i class="fa fa-facebook addressIconSocial "><a  target="_blank" class="SMFaceBook "></a></i></span>
                <span><i class="fa fa-twitter addressIconSocial "><a  target="_blank" class="SMTwitter"></a></i></span>
                
               </div>
            </ul>
            </div>

        
          <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 ">
            <div id="maphotel" class="gmap3"></div>

          </div>
 
        </div>
      </div>
    </div>

        <!--CopyRight-->    
          <div class="copyright " >
            <div class="container">
              <div class="col-lg-7 col-md-12 col-xs-12 company " >
                <p class="txt14 yekan txtBlue">کلیه حقوق وب سایت متعلق به <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/">{$smarty.const.CLIENT_NAME}</a> می باشد.</p>
              </div>
              <div class="col-lg-5 col-md-12 col-xs-12 irantech " >
                <p class="txt14 yekan txtBlue">طراحی وب سایت: <a class="it-link" href="http://iran-tech.com/" target="_blank">ایران تکنولوژی</a></p>
              </div>
            </div>
          </div>
  </footer>
  {/if}
</div> 

    <!--BACK TO TOP BUTTON-->
    <div class="backToTop"></div>


  {literal}
    <script type='text/javascript' src='project_files/js/jquery.easing.1.3.js'></script> 
    
    <script type='text/javascript' src='project_files/js/camera.min.js'></script> 

  <script type='text/javascript'>
  $(document).scroll(function () {
      var y = $(window).scrollTop();
      if (y > 300) {
        $('.backToTop').fadeIn('slow');
      } else {
        $('.backToTop').fadeOut('slow');
      }
    });

    $(".backToTop").click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
    });
  </script>
 <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCtZ3tGybs75zk_7ic_Fij2QbqyFyG7wRU" type="text/javascript"></script>
  <script type="text/javascript" src="project_files/js/gmap3.min.js"></script>


      <script type="text/javascript">
        $(function(){
      
        $("#maphotel").gmap3({
          marker:{latLng: [26.727038, 54.281641],
            options:{draggable:true },
            events:{ dragend: function(marker){
                $(this).gmap3({
                  getaddress:{latLng:marker.getPosition(),callback:function(results){ var map = $(this).gmap3("get"),
                  infowindow = $(this).gmap3({get:"infowindow"}),content = results && results[1] ? results && results[1].formatted_address : "no address";if (infowindow){infowindow.open(map, marker);infowindow.setContent(content);
                    } else {$(this).gmap3({infowindow:{anchor:marker, options:{content: content} }});} }
                              }
                          });
                        } 
                     }
                 }, map:{options:{zoom:15}
          }  });
        
      });
    </script>
        <script src="project_files/js/ace-responsive-menu.js" type="text/javascript"></script>
    <script type="text/javascript">
         $(document).ready(function () {
             $("#respMenu").aceResponsiveMenu({
                 resizeWidth: '768', 
                 animationSpeed: 'fast', 
                 accoridonExpAll: false 
             });
         });
    </script>
{/literal}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
</body>
</html>
