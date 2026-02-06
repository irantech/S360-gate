{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{if $smarty.session.layout neq 'pwa'}
    {if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
        <footer class="i_modular_footer footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    مسیر های پر تردد داخلی از تهران
                                </h3>
                                <ul class="links double_links">
                                    {assign 'cities' ['MHD' => functions::Xmlinformation('S360MHD'),'TBZ' => functions::Xmlinformation('S360TBZ'),'AWZ' =>  functions::Xmlinformation('S360AWZ'),'AZD' => functions::Xmlinformation('S360AZD'),'KSH' =>functions::Xmlinformation('S360KSH'),'RAS' => functions::Xmlinformation('S360RAS') , 'ADU' => functions::Xmlinformation('S360ADU') , 'BND' =>  functions::Xmlinformation('S360BND')]}
                                    {foreach $cities as $item}
                                        <li>
                                            <a onclick="calenderFlightSearch('THR','{$item@key}')"
                                               data-target="#calenderBox" data-toggle="modal">
                                                ##S360FlightTo## {$item}
                                            </a>
                                        </li>
                                    {/foreach}
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    مسیر های پر تردد خارجی از تهران
                                </h3>
                                <ul class="links double_links">


                                    {assign 'cities' ['ISTALL' => functions::Xmlinformation('S360ISTALL'),'DXB' => functions::Xmlinformation('S360DXB'),'BON' => functions::Xmlinformation('S360BON'),'SYD' => functions::Xmlinformation('S360SYD'),'DXBALL' => functions::Xmlinformation('S360DXBALL'),'BERALL' => functions::Xmlinformation('S360BERALL'), 'LONALL' => functions::Xmlinformation('S360YXUALL'), 'NJF' => functions::Xmlinformation('S360NJF')]}

                                    {foreach $cities as $item}
                                        <li>
                                            <a href="{$smarty.const.ROOT_ADDRESS}/international/1/IKA-{$item@key}/{$objDate->tomorrow()}/1-0-0">
                                                ##S360FlightTo## {$item}
                                            </a>
                                        </li>
                                    {/foreach}

                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo">
                            <div class="footer_widget">
                                <h3 class="footer_title">
                                    خدمات توریستی
                                </h3>
                                <ul class="links double_links">
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                                            تور
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/flight">
                                            پرواز
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/page/hotel">
                                            هتل
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/mag">وبلاگ</a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/rules" target="_blank">قوانین و مقررات</a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/aboutUs" target="_blank">درباره ما</a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/contactUs" target="_blank">تماس با ما</a>
                                    </li>
                                    <li>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/UserTracking" target="_blank">پیگیری خرید</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-lg-3 col_foo foo_contact">
                            <div class="address footer_widget">
                                <h3 class="footer_title">
                                    تماس با ما
                                </h3>
                                <div class="contact_info_text">
                                    <i class="fa-regular fa-map-location-dot">
                                    </i>
                                    <a class="__address_class__">
                                        {$smarty.const.CLIENT_ADDRESS}
                                    </a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fa-regular fa-phone">
                                    </i>
                                    <a class="__phone_class__" href="tel:{$smarty.const.CLIENT_PHONE}" target="_top">
                                        {$smarty.const.CLIENT_PHONE}
                                    </a>
                                </div>
                                <div class="contact_info_text">
                                    <i class="fa-regular fa-envelope">
                                    </i>
                                    <a class="__email_class__" href="mailto:{$smarty.const.CLIENT_EMAIL}" target="_top">
                                        {$smarty.const.CLIENT_EMAIL}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col_namads">
                                <a href="https://www.cao.ir/paxrights" rel="nofollow" target="_blank">
                                    <img alt="" src="project_files/images/certificate1.png" />
                                </a>
                                <a href="https://www.cao.ir/" rel="nofollow" target="_blank">
                                    <img alt="" src="project_files/images/certificate2.png" />
                                </a>
                                <a href="https://aira.ir/" rel="nofollow" target="_blank">
                                    <img alt="" src="project_files/images/certificate3.png" />
                                </a>
                                <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=630594&Code=rPOcFa0k0VmsL3HNqey71BP3n3YRPHC4'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=630594&Code=rPOcFa0k0VmsL3HNqey71BP3n3YRPHC4' alt='' style='cursor:pointer' code='rPOcFa0k0VmsL3HNqey71BP3n3YRPHC4'></a>
                                <a href="javascript" rel="nofollow" target="_blank">
                                    <img alt="" src="project_files/images/samandeh.jpg" />
                                </a>
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
                                    طراحی سایت آژانس مسافرتی
                                </a>
                                : ایران تکنولوژی
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