{load_presentation_object filename="specialPages" assign="objSpecialPages"}

{assign var="searchServices" value=['flight'=>'specialFlightPic','InternalFlight'=>'specialInternalFlightPic','ExternalFlight'=>'specialExternalFlightPic','hotel'=> 'specialHotelPic','train' => 'specialTrainPic',
'bus' =>'specialBusPic', 'tour' =>'specialTourPic', 'insurance' =>'specialInsurancePic', 'visa' =>'specialVisaPic', 'gasht' =>'specialGashtPic',
'entertainment' =>'specialEntertainmentPic', 'Europcar' =>'specialEuropcarPic',
'mainPage' =>'MainPagePic']}
{assign var="searchServicesText" value=[
'hotel'=> ['title'=>'دارکوب 724 مرکز رزرواسیون هتل های داخلی و خارجی', 'caption'=>'رزرو هتل در سراسر جهان'],
'tour' => ['title'=>'دارکوب 724 مرکز رزرواسیون تور های داخلی و خارجی', 'caption'=>'تورهای مسافرتی']
]}
{foreach $searchServices as $key => $val}
    {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}
    {if $homePage}
        {assign var=$val value=$homePage.files.main_file.src}
    {/if}
    {assign var="homePage" value=""}
{/foreach}
{*{$searchServices|var_dump}*}

<style>
    .banner-safiran {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
    background-image: url("{$page.files.main_file.src}");

    {else}
        background-image: url("{$specialHotelPic}");
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
       $('#Flight_internal-tab').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialInternalFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialExternalFlightPic}
        {literal}
       $('#Flight_external-tab').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialExternalFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialHotelPic}
        {literal}
       $('.Hotel-tab-pic').click(function () {
          // تغییر عکس
          $('.banner-safiran').css('background-image' , 'url("{/literal}{$specialHotelPic}{literal}")');
          // تغییر متن
          $('#title-banner').text('{/literal}{$searchServicesText.hotel.title}{literal}');
       });
        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
       $('.Train-tab-pic').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialTrainPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialBusPic}
        {literal}
       $('.Bus-tab-pic').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialBusPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialTourPic}
        {literal}
       $('.Tour-tab-pic').click(function () {
          // تغییر عکس
          $('.banner-safiran').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")');
          // تغییر متن
          $('#title-banner').text('{/literal}{$searchServicesText.tour.title}{literal}');
       });
        {/literal}
        {/if}
        {if $specialInsurancePic}
        {literal}
       $('.Insurance-tab').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialInsurancePic}{literal}")')});
        {/literal}
        {/if}
        {if $specialVisaPic}
        {literal}
       $('.Visa-tab-pic').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialVisaPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialGashtPic}
        {literal}
       $('.GashtTransfer-tab-pic').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialGashtPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialEntertainmentPic}
        {literal}
       $('.Entertainment-tab-pic').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialEntertainmentPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialEuropcarPic}
        {literal}
       $('.Europcar-tab-pic').click(function () {$('.banner-safiran').css('background-image' , 'url("{/literal}{$specialEuropcarPic}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}