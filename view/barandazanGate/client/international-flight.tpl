

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
            <div class="img_timeoute_svg">
                <svg id="Capa_1" enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                     xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <circle cx="211.748" cy="217.219" fill="#365e7d" r="211.748"/>
                        <path d="m423.496 217.219c0-116.945-94.803-211.748-211.748-211.748-4.761 0-9.482.173-14.165.483 105.408 6.964 189.73 91.05 197.055 196.357.498 7.155-5.367 13.072-12.538 12.919-1.099-.023-2.201-.035-3.306-.035-87.332 0-158.129 70.797-158.129 158.129 0 8.201.627 16.255 1.833 24.118 2.384 15.542-8.906 29.961-24.594 31.022-.107.007-.214.014-.321.021 4.683.309 9.404.483 14.165.483 117.636-.001 211.748-95.585 211.748-211.749z"
                              fill="#2b4d66"/>
                        <circle cx="211.748" cy="217.219" fill="#f4fbff" r="162.544"/>
                        <path d="m374.292 217.219c0-89.77-72.773-162.544-162.544-162.544-4.404 0-8.765.181-13.08.525 83.965 6.687 149.953 77.174 149.461 162.972-.003.004-.006.007-.009.011-68.587 13.484-119.741 70.667-126.655 138.902-1.189 11.73-10.375 21.111-22.124 22.097-.224.019-.448.037-.673.055 94.649 7.542 175.624-67.027 175.624-162.018z"
                              fill="#daf1f4"/>
                        <g>
                            <g>
                                <path d="m211.748 104.963c-4.268 0-7.726-3.459-7.726-7.726v-10.922c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.922c0 4.267-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m296.588 140.105c-1.978 0-3.955-.755-5.464-2.264-3.017-3.017-3.017-7.909.001-10.927l7.723-7.722c3.017-3.017 7.909-3.016 10.927.001 3.017 3.017 3.017 7.909-.001 10.927l-7.723 7.722c-1.508 1.508-3.486 2.263-5.463 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m342.653 224.945h-10.923c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m214.925 359.027c-4.268 0-7.726-3.459-7.726-7.726v-10.923c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.923c.001 4.268-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m119.185 317.508c-1.977 0-3.955-.755-5.464-2.263-3.017-3.018-3.017-7.909 0-10.928l7.723-7.723c3.018-3.016 7.909-3.016 10.928 0 3.017 3.018 3.017 7.909 0 10.928l-7.723 7.723c-1.51 1.509-3.487 2.263-5.464 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m91.766 224.945h-10.922c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.727 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m126.908 140.105c-1.977 0-3.955-.755-5.463-2.263l-7.723-7.722c-3.018-3.017-3.018-7.909-.001-10.927 3.018-3.018 7.91-3.017 10.927-.001l7.723 7.722c3.018 3.017 3.018 7.909.001 10.927-1.509 1.509-3.487 2.264-5.464 2.264z"
                                      fill="#365e7d"/>
                            </g>
                        </g>
                        <g>
                            <path d="m211.748 228.123h-37.545c-4.268 0-7.726-3.459-7.726-7.726s3.459-7.726 7.726-7.726h29.819v-65.392c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v73.119c0 4.266-3.458 7.725-7.726 7.725z"
                                  fill="#2b4d66"/>
                        </g>
                        <circle cx="378.794" cy="373.323" fill="#dd636e" r="133.206"/>
                        <path d="m378.794 240.117c-5.186 0-10.3.307-15.331.884 66.345 7.604 117.875 63.941 117.875 132.322s-51.53 124.718-117.875 132.322c5.032.577 10.145.884 15.331.884 73.568 0 133.206-59.638 133.206-133.206 0-73.567-59.638-133.206-133.206-133.206z"
                              fill="#da4a54"/>
                        <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-6.034-6.034-15.819-6.034-21.853 0l-39.246 39.246-39.246-39.246c-6.034-6.036-15.819-6.034-21.853 0-6.035 6.034-6.035 15.819 0 21.853l39.246 39.246-39.246 39.246c-6.035 6.034-6.035 15.819 0 21.853 3.017 3.017 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526l39.246-39.246 39.246 39.246c3.017 3.018 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526c6.035-6.034 6.035-15.819 0-21.853z"
                              fill="#f4fbff"/>
                        <g>
                            <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-5.885-5.884-15.327-6.013-21.388-.42.154.142.315.271.465.42 6.035 6.034 6.035 15.819 0 21.853l-32.777 32.777c-3.573 3.573-3.573 9.366 0 12.939l32.777 32.777c6.035 6.034 6.035 15.819 0 21.853-.149.15-.311.279-.465.421 2.954 2.726 6.703 4.106 10.462 4.106 3.955 0 7.909-1.509 10.927-4.526 6.035-6.034 6.035-15.819 0-21.853z"
                                  fill="#daf1f4"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="timeout-modal__title site-main-text-color">##Endofsearchtime## !</span>

            <p class="timeout-modal__flight">
                ##searchContentLoader##
            </p>
            <button type="button" class="btn btn-research site-bg-main-color" >
                ##Repeatsearch##
            </button>
            {if $smarty.session.layout eq 'pwa'}
                <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_DOMAIN}/gds/{$smarty.const.SOFTWARE_LANG}/app">##Returntohome##</a>

            {else}
                <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">##Returntohome##</a>

            {/if}
        </div>
    </div>
</div>

<script src="assets/js/vue/axios.js"></script>
<script type="text/javascript" language="JavaScript">
  window.axios = axios;
  window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
</script>
<script src="/gds/dist/flight/js/internationalFlight.js"></script>
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


