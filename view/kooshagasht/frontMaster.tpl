{load_presentation_object filename="frontMaster" assign="obj"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="reservationBasicInformation" assign="objResult"}

{assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
{assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="{$obj->Title_head()}">
    <title>{$obj->Title_head()}</title>
    <base href="https://{$smarty.const.CLIENT_DOMAIN}"/>

    <link rel="icon" type="image/png" sizes="32x32" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="project_files/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="project_files/images/favicon.png">

    <link rel="stylesheet" href="project_files/css/bootstrap.min.css">
    <link rel="stylesheet" href="project_files/css/all.css">
    <link rel="stylesheet" href="project_files/css/style.css">

    <link rel="stylesheet" href="project_files/css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="https://search.kooshagasht.ir/fa/user/GlobalFile/css/register.css">

    {literal}
        <script src="project_files/js/jquery-3.4.1.min.js"></script>
    {/literal}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentHead.tpl"}
</head>
<body>

<header>
    <div class="header_f">
        <div class="top_header">

            <div class="container-fluid px-5">
                <a class="link_header_top" href="{$smarty.const.ROOT_ADDRESS}/UserTracking" style="
    display: flex;
    color: #fff;
">پیگیری خرید</a>
            </div>

        </div>

        <div class="container-fluid px-5">

            <div class="row">

                <nav id="navigation1" class="navigation">
                    <div class="nav-header">
                        <div class="logo">
                            <a class="nav-brand" href="https://kooshagasht.ir/">
                                <img src="project_files/images/ic.png" alt=""/>
                            </a>
                        </div>

                        <div class="nav-toggle"></div>
                    </div>
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu ">
                            <li>
                                <a class="active-menu" href="https://kooshagasht.ir/">
                                    <i class="fas fa-home"></i> صفحه اصلی</a>
                            </li>
                            <li class="megam local-tour">
                               <a href="#"  onclick="return false" >تورهای داخلی</a>
                                <div class="megamenu-panel">
                                    <div class="megamenu-lists">
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d9%88-%d9%85%d9%86%d8%a7%d8%b3%d8%a8-%da%a9%db%8c%d8%b4/"
                                                   target="_blank">تورهای کیش </a>
                                            </li>
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d8%a7%d8%b5%d9%81%d9%87%d8%a7%d9%86/"
                                                   target="_blank">تورهای اصفهان</a>
                                            </li>


                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d9%85%d8%b4%d9%87%d8%af/"
                                                   target="_blank">تورهای مشهد </a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"
                                                   target="_blank">تورهای یزد</a>
                                            </li>
                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%da%86%d8%a7%d8%a8%d9%87%d8%a7%d8%b1/"
                                                   target="_blank">تورهای چابهار </a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"
                                                   target="_blank">تورهای تبریز</a>
                                            </li>
                                        </ul>

                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b2%d8%b1%d8%a7%d9%86-%d9%82%d8%b4%d9%85/"
                                                   target="_blank">تورهای قشم </a>
                                            </li>
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d8%b4%db%8c%d8%b1%d8%a7%d8%b2/"
                                                   target="_blank">تورهای شیراز</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="megam "><a href="#" onclick="return false">تورهای خارجی</a>
                                <div class="megamenu-panel">
                                    <div class="megamenu-lists">
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d9%81%d8%b1%d8%a7%d9%86%d8%b3%d9%87/"
                                                   target="_blank">
                                                    <img src="project_files/images/country/france-24x24.png" alt="">
                                                    تور فرانسه
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d9%85%d9%86%d8%b3%d8%aa%d8%a7%d9%86/"
                                                   target="_blank">
                                                    <img src="project_files/images/country/armenia-24x24.png" alt="" />
                                                    تور ارمنستان </a>
                                            </li>
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d8%af%d8%a8%db%8c/"
                                                   target="_blank">
                                                    <img src="project_files/images/country/united-arab-emirates-1-24x24.png" alt="" />
                                                    تور دبی </a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/turkey-1-24x24.png" alt="" />
                                                    تور ترکیه </a>
                                            </li>



                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d9%87%d9%85%d9%87-%da%86%db%8c%d8%b2-%d8%af%d8%b1-%d8%b1%d8%a7%d8%a8%d8%b7%d9%87-%d8%a8%d8%a7-%d8%a7%db%8c%d8%aa%d8%a7%d9%84%db%8c%d8%a7/"
                                                  >
                                                    <img src="project_files/images/country/italy-24x24.png" alt="" />
                                                    تور ایتالیا </a>
                                            </li>
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%da%a9%d9%88%d8%b4%db%8c-%d8%a2%d8%af%d8%a7%d8%b3%db%8c/"
                                                  >
                                                    <img src="project_files/images/country/turkey-1-24x24.png" alt="" />
                                                    تور کوش آداسی</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/germany-24x24.png" alt="" />
                                                    تور آلمان</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/thailand-1-24x24.png" alt="" />
                                                    تور پاتایا</a>
                                            </li>
                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d8%aa%d8%a7%db%8c%d9%84%d9%86%d8%af/" alt="" />
                                                    تور تایلند</a>
                                            </li>
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d8%a7%d8%b3%d8%aa%d8%a7%d9%86%d8%a8%d9%88%d9%84/"
                                                  >
                                                    <img src="project_files/images/country/turkey-1-24x24.png" alt="" />
                                                    تور استانبول</a>
                                            </li>

                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/india-1-24x24.png" alt="" />
                                                    تور هند</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/georgia-24x24.png" alt="" />
                                                    تور تفلیس</a>
                                            </li>
                                        </ul>

                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d8%aa%d9%88%d8%b1-%d8%a7%d8%b1%d8%b2%d8%a7%d9%86-%d8%a7%d9%86%d8%af%d9%88%d9%86%d8%b2%db%8c/"
                                                  >
                                                    <img src="project_files/images/country/indonesia-1-36x36.png" alt="" />
                                                    تور اندونزی</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/sri-lanka-24x24.png" alt="" />
                                                    تور سریلانکا</a>
                                            </li>

                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/georgia-24x24.png" alt="" />
                                                    تور گرجستان</a>
                                            </li>

                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >
                                                    <img src="project_files/images/country/thailand-1-24x24.png" alt="" />
                                                    تور پوکت</a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="megam mvisa"><a href="#" onclick="return false">ویزاها</a>
                                <div class="megamenu-panel">
                                    <div class="megamenu-lists">
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false"> ویزای شینگن</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا گرجستان</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا اکراین</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا مالزی</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false"> ویزا چین</a>
                                            </li>



                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false">ویزا کانادا</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا هند</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا تایلند</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا گرجستان</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا بلغارستان</a>
                                            </li>
                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false">ویزا فرانسه</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا ترکیه</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا اسپانیا</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا ایتالیا</a>
                                            </li>

                                        </ul>

                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false">ویزا انگلستان</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا امارات</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا کرواسی</a>
                                            </li>
                                            <li>
                                               <a href="#"  onclick="return false">ویزا آذربایجان</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="megam mticket">
                               <a href="#"  onclick="return false" onclick="return false">بلیط</a>
                                <div class="megamenu-panel">
                                    <div class="megamenu-lists">
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >پرواز داخلی</a>
                                            </li>

                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >پرواز خارجی</a>
                                            </li>

                                        </ul>
                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false"
                                                  >قطار</a>
                                            </li>
                                        </ul>

                                        <ul class="megamenu-list list-col-4">
                                            <li>
                                               <a href="#"  onclick="return false">اتوبوس</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="megam mform">
                               <a href="#"  onclick="return false" >فرم ها</a>
                                <div class="megamenu-panel">
                                    <div class="megamenu-lists">
                                        <ul class="megamenu-list list-col-5">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d9%81%d8%b1%d9%85-%d8%a8%db%8c%d9%88%da%af%d8%b1%d8%a7%d9%81%db%8c-%d9%85%d8%aa%d9%82%d8%a7%d8%b6%db%8c%d8%a7%d9%86/" target="_blank">فرم بیوگرافی</a>
                                            </li>

                                        </ul>
                                        <ul class="megamenu-list list-col-5">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d9%81%d8%b1%d9%85-%d8%aa%d9%88%d8%b1%d9%87%d8%a7%db%8c-%d8%b3%d9%84%d8%a7%d9%85%d8%aa/" target="_blank">فرم تور های سلامت</a>
                                            </li>

                                        </ul>
                                        <ul class="megamenu-list list-col-5">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d9%81%d8%b1%d9%85-%d8%b1%d8%b2%d9%88%d9%85%d9%87-%d8%aa%d8%ad%d8%b5%db%8c%d9%84%db%8c/">فرم رزومه تحصیلی</a>
                                            </li>
                                        </ul>

                                        <ul class="megamenu-list list-col-5">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d9%81%d8%b1%d9%85-%d9%85%d9%87%d8%a7%d8%ac%d8%b1%d8%aa/">فرم مهاجرت</a>
                                            </li>
                                        </ul>
                                        <ul class="megamenu-list list-col-5">
                                            <li>
                                                <a href="https://kooshagasht.ir/%d9%81%d8%b1%d9%85-%d8%a7%d8%b1%d8%b2%db%8c%d8%a7%d8%a8%db%8c-%d9%88%db%8c%d8%b2%d8%a7/" target="_blank">فرم ارزیابی ویزا</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li><a href="https://kooshagasht.ir/%d9%87%d9%85%da%a9%d8%a7%d8%b1%db%8c-%d8%af%d8%b1-%d8%b3%d8%a7%db%8c%d8%aa/">همکاری</a></li>
                            <li><a href="https://kooshagasht.ir/about-us/">درباره ما</a></li>
                            <li><a href="https://kooshagasht.ir/about-us/">ارتباط با ما</a></li>
                        </ul>
                    </div>

                    <div class="left-menu">



                        <div class="d-flex align-items-center">
                            <div class="menu-login">
                                <div class="c-header__btn">
                                    <div class="c-header__btn-login" href="javascript:;">
                                       <a href="#"  onclick="return false" aria-label="fas|user" class="w-text-h">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    </div>
                                    <div class="main-navigation__sub-menu2 arrow-up">
                                        {include file="`$smarty.const.FRONT_THEMES_DIR`kooshagasht/topBar.tpl"}
                                    </div>
                                </div>
                            </div>
                        </div>




                       <a href="#"  onclick="return false" class="w-text-h2">
                            <i class="fas fa-phone"></i>
                            <span class="w-text-value">09125857635</span>
                        </a>

                    </div>
                </nav>


            </div>

        </div>

    </div>
</header>



<div class="content_tech">

    <div class="container">
        <div class="temp-wrapper">
            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl"}
        </div>

    </div>
</div>

{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
    <footer>

        <div class="container">
            <div class="row">

                <div class="col-md-4 d-flex align-items-center">


                    <div class="img_f w-100">

                        <div class="owl-carousel owl-img-footer">
                            <div class="item">
                                <img src="project_files/images/1.png" alt="1.jpeg">
                            </div>

                            <div class="item">
                                <img src="project_files/images/2.png" alt="2.jpeg">
                            </div>
                            <div class="item">
                                <img src="project_files/images/3.png" alt="3.jpeg">
                            </div>
                            <div class="item">
                                <img src="project_files/images/5.png" alt="5.jpeg">
                            </div>
                            <div class="item">
                                <img src="project_files/images/6.png" alt="6.jpeg">
                            </div>

                        </div>

                    </div>


                </div>
                <div class="col-md-8">
                    <div class="w-tabs-list-h">

                        <a class="w-tabs-item active_t"  href="javascript:void(0);">
                            <span class="w-tabs-item-title">تور با قطار</span>
                        </a>

                        <a class="w-tabs-item" href="javascript:void(0);">
                            <span class="w-tabs-item-title">تور داخلی</span>
                        </a>

                        <a class="w-tabs-item active" href="javascript:void(0);">
                            <span class="w-tabs-item-title">تور خارجی</span>
                        </a>

                        <a class="w-tabs-item" href="javascript:void(0);">
                            <span class="w-tabs-item-title">تور زیارتی</span>
                        </a>

                    </div>

                    <div class="w-tabs-sections titles-align_none icon_chevron cpos_right">

                        <div class="w-tabs-section active_t_f">
                            <div class="list_f">
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="w-tabs-section">
                            <div class="list_f">
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="w-tabs-section">
                            <div class="list_f">
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="w-tabs-section">
                            <div class="list_f">
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                                <ul>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور آنتالیا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور کانادا</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false"> تور انگلیس</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور ترکیه</a></li>
                                    <li><i class="fas fa-angle-double-left"></i><a href="#"  onclick="return false">تور مکزیک</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>


                    <div class="vc_column-inner">
                        <div class="wpb_wrapper"><p>09125857635 <i class="fas fa-phone-square-alt"></i></p>
                            <hr>
                            <p>Kooshagasht@yahoo.com <i class="fas fa-envelope-open-text"></i></p>
                        </div>
                    </div>

                    <div class="logo_footer">

                        <a href="https://kooshagasht.ir/"><img src="project_files/images/ic.png" alt=""></a>

                    </div>

                </div>

            </div>
        </div>




    </footer>
{/if}
<div class="copy-right">

    <div class="container">
        <div class="row">
            <div class="col-md-6 text-right">
                تمامی حقوق مادی و معنوی متعلق به شرکت کوشا گشت می‌باشد.
            </div>
            <div class="col-md-6">
                <a href="https://iran-tech.com/"> طراح سایت گردشگری </a>   :ایران تکنولوژی
            </div>
        </div>
    </div>

</div>
{literal}
    <script src="project_files/js/megamenu.js"></script>
    <script type="text/javascript">
        $('.menu-login').click(function (e) {
            e.stopPropagation();
            $('.main-navigation__sub-menu2').toggleClass('active_log');
        });



        $('body').click(function (e) {

            $('.main-navigation__sub-menu2').removeClass('active_log');

        });
        function signout() {
            $.post('https://online.kooshagasht.ir/gds/user_ajax.php',
                {flag: 'signout'},
                function (data) {
                    window.top.location.href ="https://search.kooshagasht.ir";
                }
            )
        }
    </script>

    <script src="project_files/js/scripts.js"></script>
{/literal}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentFooter.tpl"}
</body>
</html>