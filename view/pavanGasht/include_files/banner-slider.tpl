
{load_presentation_object filename="specialPages" assign="objSpecialPages"}

{assign var="searchServices" value=['flight'=>'specialFlightPic','InternalFlight'=>'specialInternalFlightPic','ExternalFlight'=>'specialExternalFlightPic','hotel'=> 'specialHotelPic','train' => 'specialTrainPic',
'bus' =>'specialBusPic', 'tour' =>'specialTourPic', 'TourExternal' =>'specialTourExternalPic', 'insurance' =>'specialInsurancePic', 'visa' =>'specialVisaPic', 'gasht' =>'specialGashtPic',
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
    .img-banner {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
    background-image: url("{$page.files.main_file.src}");

    {else}
        background-image: url("{$specialTourPic}");
    {/if}
    }




</style>
{*{$page.files.main_file.src|var_dump}*}
{*{$specialTourPic|var_dump}*}
{*{$specialEuropcarPic|var_dump}*}
<script>
    {literal}
    if($(window).width() > 576){
        {/literal}

        {if $specialTourPic}
        {literal}
       $('.Tour-tab-pic').click(function () {$('.img-banner').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTourExternalPic}
        {literal}
       $('.TourForeign-tab-pic').click(function () {$('.img-banner').css('background-image' , 'url("{/literal}{$specialTourExternalPic}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}