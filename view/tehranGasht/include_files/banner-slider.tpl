{load_presentation_object filename="specialPages" assign="objSpecialPages"}

{assign var="searchServices" value=[
'flight'           => 'specialFlightPic',
'InternalFlight'   => 'specialInternalFlightPic',
'ExternalFlight'   => 'specialExternalFlightPic',
'hotel'            => 'specialHotelPic',
'train'            => 'specialTrainPic',
'bus'              => 'specialBusPic',
'tour'             => 'specialTourPic',
'travelInsurance'        => 'specialInsurancePic',
'visa'             => 'specialVisaPic',
'gasht'            => 'specialGashtPic',
'entertainment'    => 'specialEntertainmentPic',
'Europcar'         => 'specialEuropcarPic',
'mainPage'         => 'MainPagePic'
]}

{assign var="specialPic" value=[]}

{foreach $searchServices as $key => $legacyVar}
    {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}
    {if $homePage}
        {assign var="imgSrc" value=$homePage.files.main_file.src}
        {assign var="imgTitle" value=$homePage.title}
        {assign var="imgHeading" value=$homePage.heading}

        {assign var="specialPic" value=$specialPic|@array_merge:[
        $key => [
        'src'     => $imgSrc,
        'title'   => $imgTitle,
        'heading' => $imgHeading
        ]
        ]}

        {assign var=$legacyVar value=$imgSrc}
    {/if}
{/foreach}

{assign var="defaultText" value=[
'flight' => ['title'=>'رزرو بلیط هواپیما','heading'=>'پرواز داخلی و خارجی'],
'hotel'  => ['title'=>'رزرو هتل','heading'=>'هتل‌های داخلی و خارجی'],
'tour'   => ['title'=>'تورهای ویژه','heading'=>'تورهای داخلی و خارجی'],
'bus'    => ['title'=>'بلیط اتوبوس','heading'=>'سفر مقرون‌به‌صرفه'],
'visa'   => ['title'=>'اخذ ویزا','heading'=>'راهنمای کامل ویزا'],
'travelInsurance'=>['title'=>'بیمه مسافرتی','heading'=>'سفر امن']
]}

{foreach $defaultText as $k => $t}
    {if isset($specialPic.$k)}
        {if !$specialPic.$k.title}
            {assign var="specialPic.$k.title" value=$t.title}
        {/if}
        {if !$specialPic.$k.heading}
            {assign var="specialPic.$k.heading" value=$t.heading}
        {/if}
    {/if}
{/foreach}

{if $page && $page.slug}
    {assign var="pageKey" value=$page.slug}
{else}
    {assign var="pageKey" value="flight"}
{/if}

{if $page.files.main_file.src}
    {assign var="defaultBg" value=$page.files.main_file.src}
{elseif isset($specialPic.$pageKey.src)}
    {assign var="defaultBg" value=$specialPic.$pageKey.src}
{else}
    {assign var="defaultBg" value=$specialPic.flight.src}
{/if}

<style>
    .banner-safiran{
        background-image:url("{$defaultBg}");
    }
</style>

<script>
    {literal}
    $(document).ready(function(){

       $('#title-banner').text('{/literal}{$specialPic.$pageKey.title}{literal}');
       $('#caption-banner').text('{/literal}{$specialPic.$pageKey.heading}{literal}');

       if($(window).width() <= 576) return;
        {/literal}

        {if $specialInternalFlightPic}
        {literal}
       $('#Flight_internal-tab').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialInternalFlightPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialExternalFlightPic}
        {literal}
       $('#Flight_external-tab').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialExternalFlightPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialHotelPic}
        {literal}
       $('.Hotel-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialHotelPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialTrainPic}
        {literal}
       $('.Train-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialTrainPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialBusPic}
        {literal}
       $('.Bus-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialBusPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialTourPic}
        {literal}
       $('.Tour-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialTourPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialInsurancePic}
        {literal}
       $('.Insurance-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialInsurancePic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialVisaPic}
        {literal}
       $('.Visa-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialVisaPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialGashtPic}
        {literal}
       $('.GashtTransfer-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialGashtPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialEntertainmentPic}
        {literal}
       $('.Entertainment-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialEntertainmentPic}{literal}")');
       });
        {/literal}
        {/if}

        {if $specialEuropcarPic}
        {literal}
       $('.Europcar-tab-pic').click(function(){
          $('.banner-safiran').css('background-image','url("{/literal}{$specialEuropcarPic}{literal}")');
       });
        {/literal}
        {/if}

        {literal}
    });
</script>
{/literal}
