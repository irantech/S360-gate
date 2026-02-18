
<link href="/gds/dist/css/cip.css" rel='stylesheet'/>
<div class="w-100 position-unset" id="vueApp">
    {if $objSession->IsLogin() eq false }
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl" useType="cip"}
        {/if}
    <cip :const-data="{
            'airport':`{$smarty.const.CIP_AIRPORT_SEARCH}`,
            'flight_type':`{$smarty.const.CIP_FLIGHT_TYPE_SEARCH}`,
            'trip_type':`{$smarty.const.CIP_TRIP_TYPE_SEARCH}`,
            'date':`{$smarty.const.CIP_DATE_SEARCH}`,
            'adult':`{$smarty.const.SEARCH_ADULT}`,
            'child':`{$smarty.const.SEARCH_CHILD}`,
            'infant':`{$smarty.const.SEARCH_INFANT}`,
            }"></cip>
</div>
<script src="/gds/dist/js/cip.js"></script>

<script type="text/javascript">
   setTimeout(function() {
      $('.lazy_loader_flight').slideDown({
         start: function() {
            $(this).css({
               display: 'flex',
            })
         },
      })
      loadArticles('Flight', '{$smarty.const.SEARCH_DESTINATION}')
   }, 600000)


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
   $(document).ready(function() {
      /*   if($(window).width() > 990){
             $(".parent_sidebar").scrollWithPage(".foreign-result-search");
         }*/

      $('body').delegate('ul.tabs li', 'click', function() {
         $(this).siblings().removeClass('current')
         $(this).parent('ul.tabs').siblings('.tab-content').removeClass('current')
         var tab_id = $(this).attr('data-tab')
         $(this).addClass('current')
         $(this).parent('ul.tabs').siblings('#' + tab_id).addClass('current')
      })
      //change currency
      /*     $( ".currency-gds" ).click(function() {
               $('.change-currency').toggle();
               if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
                   $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
               } else {
                   $( ".currency-inner .currency-arrow" ).addClass('currency-rotate')
               }
           });*/
      $('body').on('click', '.btn-research', function() {
         loadingToggle($(this))
         location.reload(true)
      })


      $('body').delegate('.slideDownAirDescription', 'click', function() {
         $(this).parents('.international-available-details').find('.international-available-panel-min').addClass('international-available-panel-max')
         $(this).parents('.international-available-details').find('.slideUpAirDescription').removeClass('displayiN')
         $(this).parents('.international-available-details').find('.dital-row-visa').removeClass('displayiN')
      })

      $('body').delegate('.slideUpAirDescription', 'click', function() {
         $(this).addClass('displayiN')
         $(this).parents('.international-available-details').find('.international-available-panel-min').removeClass('international-available-panel-max')
         $(this).parents('.international-available-details').find('.dital-row-visa').addClass('displayiN')
         $(this).parents('.international-available-details').find('.international-available-detail-btn.more_1').removeClass('displayiN')
      })

      $('body').on('click', '.s-u-filter-title', function() {
         $(this).parent().find('.s-u-filter-content').slideToggle()
         $(this).parent().toggleClass('hidden_filter')
      })

      $('body').delegate('.DetailSelectTicket', 'click', function() {
         $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast')
      })

   })

</script>

