{load_presentation_object filename="specialPages" assign="objSpecialPages"}

{assign var="searchServices" value=['flight'=>'specialFlightPic','hotel'=> 'specialHotelPic','train' => 'specialTrainPic',
'bus' =>'specialBusPic', 'tour' =>'specialTourPic', 'insurance' =>'specialInsurancePic', 'visa' =>'specialVisaPic', 'gasht' =>'specialGashtPic',
'mainPage' =>'MainPagePic']}

{assign var="searchServicesText" value=[
'flight'=> ['title'=>'رزرو بلیط هواپیما', 'caption'=>'برای خرید آنلاین بلیط هواپیما در پترو تولز کافیست مبدا، مقصد و تاریخ پرواز خود را انتخاب کنید.'],
'hotel'=> ['title'=>'رزرو هتل های داخلی', 'caption'=>'بهترین هتل‌ها را با تخفیف‌های ویژه رزرو کنید و از سفری راحت و بی‌دغدغه لذت ببرید. '],
'bus'=> ['title'=>'سفر راحت با رزرو بلیط اتوبوس‌های داخلی', 'caption'=>'پترو تولز بهترین گزینه‌ها را برای رزرو بلیط اتوبوس‌های داخلی با قیمت‌های مناسب و خدمات عالی ارائه می‌دهد.'],
'tour' => ['title'=>'تورهای ویژه داخلی و خارجی با خدمات استثنایی', 'caption'=>'با پترو تولز، سفرهای داخلی و خارجی خود را به تورهایی فراموش‌ نشدنی تبدیل کنید.']
]}

{foreach $searchServices as $key => $val}
    {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}
    {if $homePage}
        {assign var=$val value=$homePage.files.main_file.src}
    {/if}
    {assign var="homePage" value=""}
{/foreach}

<style>
    .banner-safiran {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
        background-image: url("{$page.files.main_file.src}");
    {else}
        background-image: url("{$specialFlightPic}");
    {/if}
    }
</style>

<script>
    {literal}
    $(document).ready(function() {
       // تنظیم متن و عنوان پیش‌فرض برای بنر
        {/literal}
        {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
        {* اگر صفحه اصلی باشد، از محتوای صفحه استفاده کن *}
        {else}
        {* در غیر این صورت از محتوای پیش‌فرض پرواز استفاده کن *}
       $('#title-banner').text('{$searchServicesText.flight.title}');
       $('#caption-banner').text('{$searchServicesText.flight.caption}');
        {/if}
        {literal}
    });
    {/literal}
</script>

{*{$specialHotelPic|var_dump}*}
{*{$specialEuropcarPic|var_dump}*}
<script>
    {literal}
    if($(window).width() > 576){
        {/literal}

        {if $specialFlightPic}
        {literal}
       $('.Flight-tab-pic').click(function () {
          // تغییر عکس
          $('.banner-safiran').css('background-image' , 'url("{/literal}{$specialFlightPic}{literal}")');
          // تغییر عنوان
          $('#title-banner').text('{/literal}{$searchServicesText.flight.title}{literal}');
          // تغییر متن
          $('#caption-banner').text('{/literal}{$searchServicesText.flight.caption}{literal}');
       });
        {/literal}
        {/if}
        {if $specialHotelPic}
        {literal}
       $('.Hotel-tab-pic').click(function () {
          // تغییر عکس
          $('.banner-safiran').css('background-image' , 'url("{/literal}{$specialHotelPic}{literal}")');
          // تغییر عنوان
          $('#title-banner').text('{/literal}{$searchServicesText.hotel.title}{literal}');
          // تغییر متن
          $('#caption-banner').text('{/literal}{$searchServicesText.hotel.caption}{literal}');
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
       $('.Bus-tab-pic').click(function () {
          // تغییر عکس
          $('.banner-safiran').css('background-image' , 'url("{/literal}{$specialBusPic}{literal}")');
          // تغییر عنوان
          $('#title-banner').text('{/literal}{$searchServicesText.bus.title}{literal}');
          // تغییر متن
          $('#caption-banner').text('{/literal}{$searchServicesText.bus.caption}{literal}');
       });
        {/literal}
        {/if}
        {if $specialTourPic}
        {literal}
       $('.Tour-tab-pic').click(function () {
          // تغییر عکس
          $('.banner-safiran').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")');
          // تغییر عنوان
          $('#title-banner').text('{/literal}{$searchServicesText.tour.title}{literal}');
          // تغییر متن
          $('#caption-banner').text('{/literal}{$searchServicesText.tour.caption}{literal}');
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