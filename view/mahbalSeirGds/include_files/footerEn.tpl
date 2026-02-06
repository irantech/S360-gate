{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <svg enable-background="new 0 0 500 250" id="wave_footer" preserveaspectratio="none" version="1.1"
             viewbox="0 0 500 250" x="0px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" y="0px">
        <path d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"
              id="path_footer_svg"></path>
        </svg>
        <footer class="i_modular_footer footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    ##S360ConvertDate##
                                </h3>
                                <div class="date_conversion">
                                    <div class="date_conversion_div">
                                        <div class="date_conversion_input">
                                            <input class="form-control convertShamsiMiladiCalendar" id="txtShamsiCalendar" name="txtShamsiCalendar"
                                                   placeholder="##ConvertToGregorian##" readonly="" type="text" value="" />
                                            <span class="resultdate" id="showJalaliResult">
         </span>
                                        </div>
                                        <div class="date_conversion_btn">
                                            <button id="shamsiConvertButton" onclick="convertJalaliToMiladi()">
                                                <i class="fas fa-exchange-alt">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="date_conversion_div">
                                        <div class="date_conversion_input">
                                            <input class="form-control convertMiladiShamsiCalendar"  name="txtMiladiCalendar" id="txtMiladiCalendar"
                                                   placeholder="##ConvertSolar##" readonly="" type="text" value="" />
                                            <span class="resultdate" id="showMiladiResult">
         </span>
                                        </div>
                                        <div class="date_conversion_btn">
                                            <button  id="miladiConvertButton" onclick="convertMiladiToJalali()">
                                                <i class="fas fa-exchange-alt">
                                                </i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    ##IntroducingServices##
                                </h3>
                                <ul class="links double_links">

                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                            ##Hotels##
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs">
                                            ##Contactus##
                                        </a>
                                    </li>
                                    <li>
                                        <a class="SMChange" href="{$smarty.const.ROOT_ADDRESS}/currency">
                                            ##currency##
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="i_modular_newsletter footer_widget news_main">
                                <h3 class="footer_title">
                                    Subscribe to newsletter
                                </h3>
                                <form class="w-100" id="FormSmsPrj" method="post" name="FormSmsPrj">
                                    <label class="col-12 p-0">
                                        <input autocomplete="off" class="__name_class__ full-name-js" id="NameSms"
                                               name="NameSms" placeholder="##Name##" type="text" value="" />
                                    </label>
                                    <label class="col-12 p-0">
                                        <input class="__email_class__ email-js"
                                               href="mailto:{$smarty.const.CLIENT_EMAIL}" id="EmailSms" name="EmailSms"
                                               onchange="Email(value,'SpamEmail')" placeholder="##Email##"
                                               type="email" value="">

                                    </label>
                                    <label class="col-12 p-0">
                                        <input class="__phone_class__ mobile-js" href="tel:{$smarty.const.CLIENT_PHONE}"
                                               id="CellSms" name="CellSms" onchange="Mobile(value,'SpamCell')"
                                               placeholder="##Phonenumber##" type="text" value="">

                                    </label>
                                    <div class="btn_mmore col-12 p-0">
                                        <a class="__submit_class__ w-100" id="ButSms" onclick="submitNewsLetter()">
                                            ##Send##
                                        </a>
                                    </div>
                                </form>
                                <span id="SpamCell">
                                 </span>
                                <span id="SpamEmail">
                                  </span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo foo_contact">
                            <div class="address footer_widget">
                                <h3 class="footer_title">
                                    ##Contactus##
                                </h3>
                                <div class="contact_info_text">
                                    <i class="fas fa-map-marked-alt">
                                    </i>
                                    <a class="__address_class__ SMFooterAddress">
{*                                        {$smarty.const.CLIENT_ADDRESS}*}
                                        Iran , Tehran , Artesh Blvd. , Bagh-e Arghavan building complex , No. 4
                                    </a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fas fa-phone">
                                    </i>
                                    <a class="__phone_class__ SMFooterPhoneEn" href="tel:{$smarty.const.CLIENT_PHONE}"
                                       target="_top">
                                        {$smarty.const.CLIENT_PHONE}
                                    </a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fas fa-envelope">
                                    </i>
                                    <a class="__email_class__ SMFooterEmail" href="mailto:{$smarty.const.CLIENT_EMAIL}"
                                       target="_top">
                                        {$smarty.const.CLIENT_EMAIL}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-start align-items-center">
                            <div class="col-12 col-md-8 p-0 d-flex flex-wrap flex-column">
                                <div class="col_namads col-12 mt-3 p-0">
                                    <a href="https://www.mcth.ir/" rel="nofollow" target="_blank">
                                        <img alt="certificate" src="project_files/images/certificate1.png" />
                                    </a>
                                    <a href="https://caa.gov.ir/" rel="nofollow" target="_blank">
                                        <img alt="certificate" src="project_files/images/certificate2.png" />
                                    </a>
                                    <a href="https://www.iata.org/" rel="nofollow" target="_blank">
                                        <img alt="certificate" src="project_files/images/certificate3.png" />
                                    </a>
                                    <a href="https://trustseal.enamad.ir/?id=12589&amp;Code=7nW7b5eqZ81QkPZJcp29"
                                       referrerpolicy="origin" target="_blank">
                                        <img alt="" code="7nW7b5eqZ81QkPZJcp29" referrerpolicy="origin"
                                             src="https://trustseal.enamad.ir/logo.aspx?id=12589&amp;Code=7nW7b5eqZ81QkPZJcp29"
                                             style="cursor:pointer" />
                                    </a>
                                    <a href="javascript" rel="nofollow" target="_blank">
                                        <img alt="logo-samandehi" id="rgvjesgtesgtfukzesgtoeuk"
                                             onclick='window.open("https://logo.samandehi.ir/Verify.aspx?id=300608&amp;p=xlaoobpdobpdgvkaobpdmcsi", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")'
                                             referrerpolicy="origin"
                                             src="https://logo.samandehi.ir/logo.aspx?id=300608&amp;p=qftilymalymawlbqlymaaqgw"
                                             style="cursor:pointer">
                                        </img>
                                    </a>
                                </div>
                                <div class="d-lg-flex d-none mt-3 col-12 p-0">
                                    <a class="footer-img"
                                       href="https://www.iran-tech.com/parvazco" target="_blank">
                                        <img alt="footer-img-1" src="project_files/images/footer-img-1.jpg" />
                                        <span>
                                         اتوماسیون crm
                                        </span>
                                    </a>
                                    <a class="footer-img" href="http://charterjoo.ir/" target="_blank">
                                        <img alt="footer-img-2" src="project_files/images/footer-img-2.jpg" />
                                        <span>
                                         فروش بلیط آنلاین
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 p-0">
                                <div class="footer_column">
                                    <a href="https://www.google.com/maps/place/35%C2%B047'35.7%22N+51%C2%B032'10.4%22E/@35.7932517,51.5384036,17z/data=!3m1!4b1!4m5!3m4!1s0x0:0xc1f6fa09e0d1d6a1!8m2!3d35.7932474!4d51.5362149?hl=fa"
                                       target="_blank">


                                            <div class='w-100 h-100' id='map'></div>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-right_text">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="copyright_content d-flex flex-row justify-content-center">
                                <a href="https://www.iran-tech.com/" target="_blank">
                                    ##S360WebsiteDesignTravelAgency##
                                </a>
                                :
                                ##S360IT##
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="modal fade bd-example-modal-lg modal-calender-js" id="calenderBox"
             tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal_center_flight">
                <div class="modal-content modal-content-js">

                </div>
            </div>
        </div>
    {/if}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`pwaFooter.tpl"}
{/if}



{literal}

<!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />

<script>
    {/literal}
    const GoogleMapLatitude = {$smarty.const.CLIENT_MAP_LAT}
    const GoogleMapLongitude = {$smarty.const.CLIENT_MAP_LNG}

    {literal}
    map = L.map('map').setView([GoogleMapLatitude, GoogleMapLongitude], 14 )
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
    }).addTo(map)
    newMarkerGroup = new L.LayerGroup()
    var marker = null
    marker = L.marker({

      lat: GoogleMapLatitude,
      lng: GoogleMapLongitude,

    }).addTo(map)
    setTimeout(() => {
      map.invalidateSize()
    }, "1000")

</script>

{/literal}
{literal}
    <script src="assets/js/customForContactUs.js"></script>
{/literal}
