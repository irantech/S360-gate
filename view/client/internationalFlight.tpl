
<div id="vueApp">
        <div class="s-u-black-container"></div>
        <div class="progress-container">
            <div class="progress-bar site-bg-main-color" id="myBarHead"></div>

        </div>
    <international-flight></international-flight>


    {assign var="moduleData" value=[
    'service'=>'internationalFlight',
    'origin'=>$smarty.const.SEARCH_ORIGIN,
    'destination'=>$smarty.const.SEARCH_DESTINATION,
    'return_date'=>$smarty.const.SEARCH_RETURN_DATE,
    'adult'=>$smarty.const.SEARCH_ADULT,
    'child'=>$smarty.const.SEARCH_CHILD,
    'infant'=>$smarty.const.SEARCH_INFANT
    ]}

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`textSearchResults.tpl"
    moduleData=$moduleData}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
    moduleData=$moduleData}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`articles.tpl"
    moduleData=$moduleData}



   {* {assign var='articles' value=$obj_articles->getArticlesPosition($data_search_blog)}
    {if !empty($articles)}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/mag/sliderBlog.tpl" articles=$articles title='مقالات ویژه'}
    {/if}*}


    <!-- login and register popup -->
    {assign var="useType" value="ticket"}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
    <!-- login and register popup -->
</div>


<div class="lazy-loader-parent lazy_loader_flight">

    <div class="modal-content-flight">
        <div class="modal-body-flight">
            <div class="icon-container">
                <div class="clock-icon">
                    <div class="clock-face">
                        <div class="clock-hand"></div>
                        <div class="clock-hand-short"></div>
                        <div class="clock-center"></div>
                    </div>
                </div>
            </div>
            <span class="timeout-modal__title">##Endofsearchtime## !</span>

            <p class="timeout-modal__flight">
                ##searchContentLoader##
            </p>
            <div class="parent-modal-final-search">
                <button type="button" class="btn btn-research site-bg-main-color" >
                    ##Repeatsearch##
                </button>
                {if $smarty.session.layout eq 'pwa'}
                    <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_DOMAIN}/gds/{$smarty.const.SOFTWARE_LANG}/app">##Returntohome##</a>

                {else}
                    <a class="btn btn_back_home" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">##Returntohome##</a>
                {/if}
            </div>
        </div>
    </div>
</div>

<script src="assets/js/vue/axios.js"></script>
<script type="text/javascript" language="JavaScript">
    window.axios = axios;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
</script>
<script src="assets/js/vueScripts/app.js"></script>
<script src="assets/js/script.js"></script>
<script src="assets/js/scrollWithPage.min.js"></script>
<script type="text/javascript">
    var SmsAllow = '{$smarty.const.IS_ENABLE_TEL_ORDER}';
    var TelAllow = '{$smarty.const.IS_ENABLE_SMS_ORDER}';
</script>
<script type="text/javascript">
 setTimeout(function () {
        $('.lazy_loader_flight').slideDown({
            start: function () {
                $(this).css({
                    display: "flex"
                })
            }
        });
        //loadArticles('Flight', '{$smarty.const.SEARCH_DESTINATION}');
    }, 600000);


/*
    window.onscroll = function() {
        $('.progress-container').css('opacity','1');


        var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        if(winScroll < 3){
            $('.progress-container').css('opacity','0');
        }
        var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        var scrolled = (winScroll / height) * 100;
        document.getElementById("myBarHead").style.width = scrolled + "%";
    }*/
    $(document).ready(function () {
     /*   if($(window).width() > 990){
            $(".parent_sidebar").scrollWithPage(".foreign-result-search");
        }*/

        $('body').delegate('ul.tabs li', "click", function () {
            $(this).siblings().removeClass("current");
            $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");
            var tab_id = $(this).attr('data-tab');
            $(this).addClass('current');
            $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");
        });
        //change currency
   /*     $( ".currency-gds" ).click(function() {
            $('.change-currency').toggle();
            if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
            } else {
                $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
            }
        });*/
        $('body').on('click','.btn-research',function (){
            location.reload(true);
        });


        $('body').delegate(".slideDownAirDescription", "click", function () {
            $(this).parents('.international-available-details').find(".international-available-panel-min").addClass("international-available-panel-max");
            $(this).parents('.international-available-details').find('.slideUpAirDescription').removeClass("displayiN");
            $(this).parents('.international-available-details').find('.dital-row-visa').removeClass('displayiN');
        });

        $('body').delegate(".slideUpAirDescription", "click", function () {
            $(this).addClass("displayiN");
            $(this).parents('.international-available-details').find(".international-available-panel-min").removeClass("international-available-panel-max");
            $(this).parents('.international-available-details').find('.dital-row-visa').addClass('displayiN');
            $(this).parents('.international-available-details').find('.international-available-detail-btn.more_1').removeClass('displayiN');
        });

        $('body').on('click', '.s-u-filter-title', function () {
            $(this).parent().find('.s-u-filter-content').slideToggle();
            $(this).parent().toggleClass('hidden_filter');
        })

        $('body').delegate('.DetailSelectTicket', 'click', function () {
            $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
        });

    });
</script>


