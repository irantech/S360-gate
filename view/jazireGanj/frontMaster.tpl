
    {include file="include_files/header.tpl" }

{if $smarty.const.GDS_SWITCH eq 'app'  || $smarty.const.GDS_SWITCH eq 'page'}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
{else}
    <div class="content_tech">
        <div {if $smarty.const.GDS_SWITCH neq 'roomManagement' &&
        $smarty.const.GDS_SWITCH neq 'hotelLog' && $smarty.const.GDS_SWITCH neq 'bookings' && $smarty.const.GDS_SWITCH neq 'hotelInvoices' &&
        $smarty.const.GDS_SWITCH neq 'hotelFinancialCenter' && $smarty.const.GDS_SWITCH neq 'hotel' && $smarty.const.GDS_SWITCH neq 'newInvoice'
             }class="container"{/if}>

            {if $smarty.const.GDS_SWITCH neq 'mainPage' && $smarty.const.GDS_SWITCH neq 'page' && $smarty.const.GDS_SWITCH neq 'detailTour' }
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/breadcrumb/main.tpl" obj_main_page=$obj_main_page}
            {/if}

            <div class="temp-wrapper">
                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentMain.tpl" obj=$obj}
            </div>
        </div>
    </div>
{/if}



{include file="include_files/footer.tpl" }


{*<div class="float-sm">
    <!--<div class="fl-fl float-fb">
        <i class="fab fa-facebook"></i>
        <a href="" target="_blank"> Like us!</a>
    </div>
    <div class="fl-fl float-tw">
        <i class="fab fa-twitter"></i>
        <a href="" target="_blank">Follow us!</a>
    </div>-->
    <div class="fl-fl float-gp">
        <i class="fab fa-telegram"></i>
        <a class="SMTelegram" href="" target="_blank">Join us!</a>
    </div>
    <div class="fl-fl float-rs">
        <i class="fab fa-whatsapp"></i>
        <a class="SMWhatsApp" href="" target="_blank">Contact us!</a>
    </div>
    <div class="fl-fl float-ig">
        <i class="fab fa-instagram"></i>
        <a class="SMInstageram" href="" target="_blank">Follow us!</a>
    </div>
    <!--<div class="fl-fl float-pn">
        <i class="fab fa-pinterest"></i>
        <a href="" target="_blank">Follow us!</a>
    </div>-->
</div>*}
{literal}
    <script type="text/javascript" src="project_files/js/scripts.js"></script>
    <script type="text/javascript" src="project_files/js/megamenu.js"></script>
    <script type="text/javascript" src="project_files/js/modernizr.js"></script>
{/literal}

{include file="include_files/script-footer.tpl"}
</body>

</html>
