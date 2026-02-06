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
    .parent-data-demo {
    {if $page.files.main_file.src && $smarty.const.GDS_SWITCH eq 'page'}
        {*background-image: url("{$page.files.main_file.src}");*}

    {else}
        background-image: url("{$specialFlightPic}");
    {/if}
    }




</style>
{assign var="searchServicesText" value=[
'hotel'=> ['title'=>'رزرو هتل‌های داخلی و خارجی با بهترین قیمت', 'caption'=>' بهترین هتل‌ها را در داخل و خارج از کشور با تخفیف‌های ویژه رزرو کنید و از سفری راحت و بی‌دغدغه لذت ببرید. '],
'tour' => ['title'=>'تورهای ویژه داخلی و خارجی با خدمات استثنایی', 'caption'=>'با بلیت دات وان، سفرهای داخلی و خارجی خود را به تورهایی فراموش‌ نشدنی تبدیل کنید. '],
'flight' => ['title'=>'رزرو بلیط هواپیما داخلی و خارجی', 'caption'=>' برای خرید آنلاین بلیط هواپیما در بلیت دات وان کافیست مبدا، مقصد و تاریخ پرواز خود را انتخاب کنید. '],
'bus' => ['title'=>'سفر راحت با رزرو بلیط اتوبوس‌های داخلی ', 'caption'=>' بلیت دات وان بهترین گزینه‌ها را برای رزرو بلیط اتوبوس‌های داخلی با قیمت‌های مناسب و خدمات عالی ارائه می‌دهد. '],
'insurance' => ['title'=>'بیمه مسافرتی مطمئن برای سفرهای داخلی و خارجی', 'caption'=>' بهترین بیمه مسافرتی با پوشش‌های جامع و قیمت‌های رقابتی را تهیه کنید و با خیال راحت به سفرهای داخلی و خارجی بروید. '],
'visa' => ['title'=>'اخذ ویزای سریع و مطمئن برای مقاصد بین‌المللی', 'caption'=>'فرآیند اخذ ویزا را به سادگی و با اطمینان کامل انجام دهید و به راحتی برای سفرهای بین‌المللی خود آماده شوید.']

]}

{*{$specialFlightPic|var_dump}*}
{*{$specialEuropcarPic|var_dump}*}
<script>


    {literal}
    $(document).ready(function() {

       $('#title-banner').text('{/literal}{$searchServicesText.flight.title}{literal}')
       $('#caption-banner').text('{/literal}{$searchServicesText.flight.caption}{literal}')
    });

    if($(window).width() > 576){
        {/literal}

        {if $specialFlightPic}
        {literal}
      $('.Flight-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialFlightPic}{literal}")')

         $('#title-banner').text('{/literal}{$searchServicesText.flight.title}{literal}');
         $('#caption-banner').text('{/literal}{$searchServicesText.flight.caption}{literal}');

      });
        {/literal}
        {/if}
        {if $specialExternalFlightPic}
        {literal}
      $('#Flight_external-tab').click(function () {$('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialExternalFlightPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialHotelPic}
        {literal}
            $('.Hotel-tab-pic').click(function () {

               $('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialHotelPic}{literal}")')
               $('#title-banner').text('{/literal}{$searchServicesText.hotel.title}{literal}');
               $('#caption-banner').text('{/literal}{$searchServicesText.hotel.caption}{literal}');

            });


        {/literal}
        {/if}
        {if $specialTrainPic}
        {literal}
      $('.Train-tab-pic').click(function () {$('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialTrainPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialBusPic}
        {literal}
      $('.Bus-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialBusPic}{literal}")')
         $('#title-banner').text('{/literal}{$searchServicesText.bus.title}{literal}');
         $('#caption-banner').text('{/literal}{$searchServicesText.bus.caption}{literal}');


      });
        {/literal}
        {/if}
        {if $specialTourPic}
        {literal}
      $('.Tour-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialTourPic}{literal}")')
         $('#title-banner').text('{/literal}{$searchServicesText.tour.title}{literal}');
         $('#caption-banner').text('{/literal}{$searchServicesText.tour.caption}{literal}');


      });

        {/literal}
        {/if}
        {if $specialInsurancePic}
        {literal}
      $('.Insurance-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialInsurancePic}{literal}")')
         $('#title-banner').text('{/literal}{$searchServicesText.insurance.title}{literal}');
         $('#caption-banner').text('{/literal}{$searchServicesText.insurance.caption}{literal}');

      });
        {/literal}
        {/if}
        {if $specialVisaPic}
        {literal}
      $('.Visa-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialVisaPic}{literal}")')
         $('#title-banner').text('{/literal}{$searchServicesText.visa.title}{literal}');
         $('#caption-banner').text('{/literal}{$searchServicesText.visa.caption}{literal}');

      });
        {/literal}
        {/if}
        {if $specialGashtPic}
        {literal}
      $('.GashtTransfer-tab-pic').click(function () {$('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialGashtPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialEntertainmentPic}
        {literal}
      $('.Entertainment-tab-pic').click(function () {$('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialEntertainmentPic}{literal}")')});
        {/literal}
        {/if}
        {if $specialEuropcarPic}
        {literal}
      $('.Europcar-tab-pic').click(function () {$('.parent-data-demo').css('background-image' , 'url("{/literal}{$specialEuropcarPic}{literal}")')});
        {/literal}
        {/if}
        {literal}

    }
</script>
{/literal}