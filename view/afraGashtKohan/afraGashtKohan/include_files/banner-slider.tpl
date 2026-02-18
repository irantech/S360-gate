{assign var="searchServices" value=['flight'=>'specialFlightPic','hotel'=> 'specialHotelPic',
'train' => 'specialTrainPic','bus' =>'specialBusPic',
'fun' => 'specialFunPic','visa' =>'specialVisaPic',
'tour-transfer' => 'specialGashtPic','car' =>'specialCarPic',
'flight-hotel' => 'specialPackagePic',
'tour' =>'specialTourPic',
'insurance' =>'specialInsurancePic',
'Europcar' =>'specialEuropcarPic',
'mainPage' =>'MainPagePic']}

{foreach $searchServices as $key => $val}
    {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}
    {if $homePage}
        {assign var=$val value=$homePage.files.main_file.src}
    {/if}
    {assign var="homePage" value=""}
{/foreach}

<style>
    .search_box {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
        background-image: url("{$page.files.main_file.src}");
    {else}
        background-image: url("{$specialTourPic}");
    {/if}
    }
</style>

<script>
    {literal}
    if($(window).width() > 576){
        {/literal}
        {if $specialFlightPic}
        {literal}
      $('#Flight-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialHotelPic}
        {literal}
      $('#Hotel-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialHotelPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
      $('#Train-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialTrainPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialBusPic}
        {literal}
      $('#Bus-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialBusPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTourPic}
        {literal}
      $('#Tour-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialInsurancePic}
        {literal}
      $('#Insurance-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialInsurancePic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
      $('#Train-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialTrainPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialFunPic}
        {literal}
      $('#Entertainment-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialFunPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialVisaPic}
        {literal}
      $('#Visa-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialVisaPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialGashtPic}
        {literal}
      $('#GashtTransfer-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialGashtPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialPackagePic}
        {literal}
      $('#Package-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialPackagePic}{literal}")')});
        {/literal}
        {/if}
        {if $specialCarPic}
        {literal}
      $('#Car-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialCarPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialEuropcarPic}
        {literal}
      $('#Europcar-tab').click(function () {$('.search_box').css('background-image' , 'url("{/literal}{$specialEuropcarPic}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}