{load_presentation_object filename="specialPages" assign="objSpecialPages"}

{assign var="searchServices" value=['flight'=>'specialFlightPic','InternalFlight'=>'specialInternalFlightPic','ExternalFlight'=>'specialExternalFlightPic','hotel'=> 'specialHotelPic','train' => 'specialTrainPic',
'bus' =>'specialBusPic', 'tour' =>'specialTourPic', 'insurance' =>'specialInsurancePic', 'visa' =>'specialVisaPic', 'gasht' =>'specialGashtPic',
'entertainment' =>'specialEntertainmentPic', 'Europcar' =>'specialEuropcarPic',
'mainPage' =>'MainPagePic']}
{foreach $searchServices as $key => $val}
    {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}
    {if $homePage}
        {assign var=$val value=$homePage.files.main_file.src}
    {/if}
    {assign var="homePage" value=""}
{/foreach}
{*{$searchServices|var_dump}*}

<style>
    .banner-demo {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
    {*background-image: url("{$page.files.main_file.src}");*}

    {else}
        background-image: url("{$specialVisaPic}");
    {/if}
    }




</style>

{*{$specialHotelPic|var_dump}*}
{*{$specialEuropcarPic|var_dump}*}
<script>
    {literal}
    if($(window).width() > 576){
        {/literal}

        {if $specialInternalFlightPic}
        {literal}
       $('#Flight_internal-tab').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialInternalFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialExternalFlightPic}
        {literal}
       $('#Flight_external-tab').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialExternalFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialHotelPic}
        {literal}
       $('.Hotel-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialHotelPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
       $('.Train-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialTrainPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialBusPic}
        {literal}
       $('.Bus-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialBusPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTourPic}
        {literal}
       $('.Tour-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialInsurancePic}
        {literal}
       $('.Insurance-tab').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialInsurancePic}{literal}")')});
        {/literal}
        {/if}
        {if $specialVisaPic}
        {literal}
       $('.Visa-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialVisaPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialGashtPic}
        {literal}
       $('.GashtTransfer-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialGashtPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialEntertainmentPic}
        {literal}
       $('.Entertainment-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialEntertainmentPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialEuropcarPic}
        {literal}
       $('.Europcar-tab-pic').click(function () {$('.banner-demo').css('background-image' , 'url("{/literal}{$specialEuropcarPic}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}