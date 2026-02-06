{load_presentation_object filename="specialPages" assign="objSpecialPages"}
{assign var="searchServices" value=['flight'=>'specialFlightPic','hotel'=> 'specialHotelPic','train' => 'specialTrainPic',
'bus' =>'specialBusPic', 'tour' =>'specialTourPic', 'insurance' =>'specialInsurancePic', 'visa' =>'specialVisaPic', 'gasht' =>'specialGashtPic',
'mainPage' =>'MainPagePic']}


{foreach $searchServices as $key => $val}
    {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}

    {if $homePage}
        {assign var=$val value=$homePage.files.main_file.src}
    {/if}
    {assign var="homePage" value=""}
{/foreach}

<style>
  .__banner_tabs__ {
  {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
    background-image: url("{$page.files.main_file.src}");
  {else}
    background-image: url("{$specialFlightPic}");
  {/if}
  }
  {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page' &&
   ($specialFlightPic || $specialHotelPic || $specialTrainPic ||
   $specialBusPic || $specialTourPic || $specialInsurancePic || $specialVisaPic || $specialGashtPic)}
  .banner-slider {
    display: none;
  }
  {/if}
</style>


<script>
    {literal}
    if($(window).width() > 576){
        {/literal}
        {if $specialFlightPic}
        {literal}
      $('.Flight-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialFlightPic}{literal}")')});
      $('.Flight-tab-pic').click(function () {$('.text-banner').html('رزرو هواپیما')});
        {/literal}
        {/if}
        {if $specialHotelPic}
        {literal}
      $('.Hotel-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialHotelPic}{literal}")')});
      $('.Hotel-tab-pic').click(function () {$('.text-banner').html('رزرو هتل')});
        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
      $('.Train-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialTrainPic}{literal}")')});
      $('.Train-tab-pic').click(function () {$('.text-banner').html('رزرو قطار')});
        {/literal}
        {/if}
        {if $specialBusPic}
        {literal}
      $('.Bus-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialBusPic}{literal}")')});
      $('.Bus-tab-pic').click(function () {$('.text-banner').html('رزرو اتوبوس')});
        {/literal}
        {/if}
        {if $specialTourPic}
        {literal}
      $('.Tour-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")')});
      $('.Tour-tab-pic').click(function () {$('.text-banner').html('رزرو تورهای داخلی و خارجی')});
        {/literal}
        {/if}
        {if $specialInsurancePic}
        {literal}
      $('.Insurance-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialInsurancePic}{literal}")')});
      $('.Insurance-tab-pic').click(function () {$('.text-banner').html('رزرو بیمه')});
        {/literal}
        {/if}
        {if $specialVisaPic}
        {literal}
      $('.Visa-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialVisaPic}{literal}")')});
      $('.Visa-tab-pic').click(function () {$('.text-banner').html('رزرو ویزا')});
        {/literal}
        {/if}
        {if $specialGashtPic}
        {literal}
      $('.GashtTransfer-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialGashtPic}{literal}")')});
      $('.GashtTransfer-tab-pic').click(function () {$('.text-banner').html('رزرو گشت و ترنسفر')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}