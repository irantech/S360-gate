{load_presentation_object filename="aboutUs" assign="objAbout"}
{assign var="about"  value=$objAbout->getData()}
{assign var="socialLinks"  value=$about['social_links']|json_decode:true}
{if $smarty.session.layout neq 'pwa'}
{if $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotel && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintTicket && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservation && $smarty.const.GDS_SWITCH neq $smarty.const.ConstPrintHotelReservationAhuan}
    <footer class="footer">
    <div class="but-top" id="scroll-top"><a href="javascript:" class="fa fa-angle-up"></a></div>

    <div class="footer_main container">
        <ul class="m-0 p-0 d-flex">
            <li class="col-12 col-md-6 my-4 col-lg-4 call">
                <h6>تماس با ما</h6>
                <span> <i class="far fa-map-marker"></i> آدرس : {$smarty.const.CLIENT_ADDRESS}</span>
                <span> <i class="far fa-phone"></i>
                    شماره :
                    <a href="tel:09422022012">09422022012</a>
                </span>
                <span> <i class="far fa-phone"></i>
                    شماره :
                    <a href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                </span>
                <span>
                     <i class="far fa-envelope"></i>
                    ایمیل :
                    <a href="mailto:{$smarty.const.CLIENT_EMAIL}">{$smarty.const.CLIENT_EMAIL}</a>
                </span>
                <div class="footer_icons">
                    {foreach $socialLinks as $key => $socialMedia}
                        {if $socialMedia['social_media'] == 'instagram'}
                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-instagram footer_instagram"></a>
                        {/if}
                        {if $socialMedia['social_media'] == 'whatsapp'}
                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-whatsapp footer_whatsapp"></a>
                        {/if}
                        {if $socialMedia['social_media'] == 'telegram'}
                            <a target="_blank" href="{$socialMedia['link']}" class="fab fa-telegram footer_telegram"></a>
                        {/if}
                    {/foreach}

                </div>
            </li>
            <li class="col-12 col-md-6 my-4 col-lg-4">
                <h6>دسترسی آسان</h6>
                <div class="asan">
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/mag">مجله پرواز</a>
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/UserTracking">پیگیری خرید</a>
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/loginUser">باشگاه مشتریان</a>
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/rules">قوانین و مقررات</a>
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/aboutUs">درباره ما</a>
                    <a class="asan_link" href="{$smarty.const.ROOT_ADDRESS}/contactUs">تماس با ما</a>
                </div>
            </li>
            <li class="col-12 col-md-6 my-4 col-lg-4 d-flex flex-column">
                <h6>نماد ها</h6>
{*                <h6>کد رهگیری</h6>*}
{*                <form class="TrcBox w-100" action="/refrense/پیگیری-کد-رهگیری" method="get" name="FormCodeRahgiriPrj" id="FormCodeRahgiriPrj" style="width: 100%;">*}
{*                    <div class="code" style="margin-top: 1rem;">*}
{*                        <input id="txtsearch" aria-describedby="basic-addon1" type="text" name="CodeRahgiriTemp" onfocus="{this.value='';}" onblur="if (this.value==''){this.value='کد رهگیری خود را وارد کنید...';}" value="کد رهگیری خود را وارد کنید..." autocomplete="off">*}
{*                        <button class="btn button-winona" type="submit">*}
{*                            <i class="fas fa-check"></i>*}
{*                        </button>*}
{*                    </div>*}
{*                </form>*}
                <div class="namads">
                    <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=333084&Code=Ukgv28UaHTMaUC1GYQeO'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=333084&Code=Ukgv28UaHTMaUC1GYQeO' alt='' style='cursor:pointer' code='Ukgv28UaHTMaUC1GYQeO'></a>
                    <a target="_blank" href="http://www.aira.ir/"><img src="project_files/images/namad-1.png" alt="namad-1"></a>
                    <a>
                        <img referrerpolicy='origin' id = 'rgvjfukzoeuknbqejzpejzpe' style = 'cursor:pointer' onclick = 'window.open("https://logo.samandehi.ir/Verify.aspx?id=368277&p=xlaogvkamcsiuiwkjyoejyoe", "Popup","toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30")' alt = 'logo-samandehi' src = 'https://logo.samandehi.ir/logo.aspx?id=368277&p=qftiwlbqaqgwodrfyndtyndt' />
                    </a>
                    <a target="_blank" href="https://farasa.cao.ir/sysworkflow/fa/modern/3810212626028ab03488017019616799/6464336316028ab04e3c618028352200.php"><img src="project_files/images/namad-3.png" alt="namad-3"></a>
                </div>
            </li>
        </ul>
    </div>
    <div class="last_text col-12">
        <a class="last_a" href="https://www.iran-tech.com/" target="_blank">طراحی سایت گردشگری</a>
        <p class="last_p_text">: ایران تکنولوژی</p>
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