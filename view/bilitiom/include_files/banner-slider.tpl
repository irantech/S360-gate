{load_presentation_object filename="specialPages" assign="objSpecialPages"}

{assign var="searchServices" value=['flight'=>'specialFlightPic','InternalFlight'=>'specialInternalFlightPic','ExternalFlight'=>'specialExternalFlightPic','hotel'=> 'specialHotelPic','train' => 'specialTrainPic',
'bus' =>'specialBusPic', 'tour' =>'specialTourPic', 'tourInternal' =>'specialTourInternalPic', 'tourExternal' =>'specialTourExternalPic', 'insurance' =>'specialInsurancePic', 'visa' =>'specialVisaPic', 'gasht' =>'specialGashtPic',
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
</style>

<script>
    {literal}
    if($(window).width() > 576){
        {/literal}
        {if $specialInternalFlightPic}
        {literal}
      $('#Flight_internal-tab').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialInternalFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialExternalFlightPic}
        {literal}
      $('#Flight_external-tab').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialExternalFlightPic}{literal}")')});
        {/literal}
        {/if}
{*        {if $specialFlightPic}*}
{*        {literal}*}
{*      $('.Flight-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialFlightPic}{literal}")')});*}
{*        {/literal}*}
{*        {/if}*}
        {if $specialHotelPic}
        {literal}
      $('.Hotel-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialHotelPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
      $('.Train-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialTrainPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialBusPic}
        {literal}
      $('.Bus-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialBusPic}{literal}")')});
        {/literal}
        {/if}
{*        {if $specialTourPic}*}
{*        {literal}*}
{*      $('.Tour-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")')});*}
{*        {/literal}*}
{*        {/if}*}
        {if $specialTourExternalPic}
        {literal}
      $('#Tour_external-tab').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialTourExternalPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTourInternalPic}
        {literal}
      $('#Tour_internal-tab').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialTourInternalPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialInsurancePic}
        {literal}
      $('.Insurance-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialInsurancePic}{literal}")')});
        {/literal}
        {/if}
        {if $specialVisaPic}
        {literal}
      $('.Visa-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialVisaPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialGashtPic}
        {literal}
      $('.GashtTransfer-tab-pic').click(function () {$('.__banner_tabs__').css('background-image' , 'url("{/literal}{$specialGashtPic}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}