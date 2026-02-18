{load_presentation_object filename="specialPages" assign="objSpecialPages"}



{* -----------------------------------
   1) تعریف سرویس‌ها و آرایه کلی
----------------------------------- *}

{assign var="searchServices" value=[
'flight'=>'specialFlightPic',
'InternalFlight'=>'specialInternalFlightPic',
'ExternalFlight'=>'specialExternalFlightPic',
'hotel'=> 'specialHotelPic',
'train' => 'specialTrainPic',
'bus' =>'specialBusPic',
'tour' =>'specialTourPic',
'insurance' =>'specialInsurancePic',
'visa' =>'specialVisaPic',
'gasht' =>'specialGashtPic',
'entertainment' =>'specialEntertainmentPic',
'Europcar' =>'specialEuropcarPic',
'mainPage' =>'MainPagePic'
]}

{assign var="specialPic" value=[]}


{assign var="specialPic" value=[]}

{foreach $searchServices as $key => $val}

   {assign var="homePage" value=$objSpecialPages->unSlugPage($key)}

   {if $homePage}

      {* ساخت آرایه تک عنصره شامل src, title, heading *}
      {capture name="temp_src"}{$homePage.files.main_file.src}{/capture}
      {capture name="temp_title"}{$homePage.title}{/capture}
      {capture name="temp_heading"}{$homePage.heading}{/capture}

      {* merge در آرایه کلی specialPic *}
      {assign var="specialPic" value=$specialPic|@array_merge:[
      $key => [
      'src'     => $smarty.capture.temp_src,
      'title'   => $smarty.capture.temp_title,
      'heading' => $smarty.capture.temp_heading
      ]
      ]}

   {/if}

{/foreach}






{* -----------------------------------
   2) متن‌های پیش‌فرض
----------------------------------- *}

{assign var="searchServicesText" value=[]}

{assign var="searchServicesText.hotel.title" value="رزرو هتل‌های داخلی و خارجی با بهترین قیمت"}
{assign var="searchServicesText.hotel.caption" value="بهترین هتل‌ها را با تخفیف‌های ویژه رزرو کنید."}

{assign var="searchServicesText.tour.title" value="تورهای ویژه داخلی و خارجی"}
{assign var="searchServicesText.tour.caption" value="تورهای داخلی و خارجی با بهترین خدمات."}

{assign var="searchServicesText.flight.title" value="رزرو بلیط هواپیما داخلی و خارجی"}
{assign var="searchServicesText.flight.caption" value="کافیست مبدا و مقصد را وارد کنید."}

{assign var="searchServicesText.bus.title" value="رزرو بلیط اتوبوس"}
{assign var="searchServicesText.bus.caption" value="سفر راحت با قیمت مناسب."}

{assign var="searchServicesText.insurance.title" value="بیمه مسافرتی"}
{assign var="searchServicesText.insurance.caption" value="بیمه معتبر برای سفر امن."}

{assign var="searchServicesText.visa.title" value="اخذ ویزا سریع و مطمئن"}
{assign var="searchServicesText.visa.caption" value="فرآیند دریافت ویزا با راهنمایی کامل."}





{* -----------------------------------
   3) Fallback برای title و heading
----------------------------------- *}

{foreach $searchServicesText as $key => $item}

   {if isset($specialPic.$key)}

      {if !$specialPic.$key.title}
         {assign var="specialPic.$key.title" value=$item.title}
      {/if}

      {if !$specialPic.$key.heading}
         {assign var="specialPic.$key.heading" value=$item.caption}
      {/if}

   {else}

      {assign var="specialPic.$key" value=[]}
      {assign var="specialPic.$key.src"     value=""}
      {assign var="specialPic.$key.title"   value=$item.title}
      {assign var="specialPic.$key.heading" value=$item.caption}

   {/if}

{/foreach}
{if $page.files.main_file.src}
   {assign var="defaultBg" value=$page.files.main_file.src}

   {* اگر صفحه تصویر نداشت ولی سرویسش در specialPic وجود دارد *}
{elseif isset($specialPic.$pageKey.src) && $specialPic.$pageKey.src}
   {assign var="defaultBg" value=$specialPic.$pageKey.src}

   {* fallback نهایی *}
{else}
   {* از سرویس flight (یا هر fallback دیگر) *}
   {assign var="defaultBg" value=$specialPic.flight.src}
{/if}
{if $page && $page.slug}
   {assign var="pageKey" value=$page.slug}
{else}
   {assign var="pageKey" value="flight"} {* fallback پیشفرض *}
{/if}





{* -----------------------------------
   4) پس زمینه اولیه
----------------------------------- *}

<style>
   .parent-data-demo {
      background-image: url("{$defaultBg}");
   }
</style>

{assign var=title value=$specialPic.$pageKey.title|default:$page.title}
{assign var=heading value=$specialPic.$pageKey.heading|default:$page.heading}





{* -----------------------------------
   5) جاوااسکریپت کلیک تب‌ها
----------------------------------- *}

<script>
   {literal}
   $(document).ready(function() {
      $('#title-banner').text('{/literal}{$title}{literal}');
      $('#caption-banner').text('{/literal}{$heading}{literal}');
   });

   if($(window).width() > 576){
      {/literal}


      {* ----------- Flight ----------- *}
      {if isset($specialPic.flight)}
      {literal}
      $('.Flight-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.flight.src}{literal}")');
         $('#title-banner').text('{/literal}{$specialPic.flight.title}{literal}');
         $('#caption-banner').text('{/literal}{$specialPic.flight.heading}{literal}');
      });
      {/literal}
      {/if}


      {* ----------- External Flight ----------- *}
      {if isset($specialPic.ExternalFlight)}
      {literal}
      $('#Flight_external-tab').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.ExternalFlight.src}{literal}")');
      });
      {/literal}
      {/if}


      {* ----------- Hotel ----------- *}
      {if isset($specialPic.hotel)}
      {literal}
      $('.Hotel-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.hotel.src}{literal}")');
         $('#title-banner').text('{/literal}{$specialPic.hotel.title}{literal}');
         $('#caption-banner').text('{/literal}{$specialPic.hotel.heading}{literal}');
      });
      {/literal}
      {/if}


      {* ----------- Train ----------- *}
      {if isset($specialPic.train)}
      {literal}
      $('.Train-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.train.src}{literal}")');
      });
      {/literal}
      {/if}


      {* ----------- Bus ----------- *}
      {if isset($specialPic.bus)}
      {literal}
      $('.Bus-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.bus.src}{literal}")');
         $('#title-banner').text('{/literal}{$specialPic.bus.title}{literal}');
         $('#caption-banner').text('{/literal}{$specialPic.bus.heading}{literal}');
      });
      {/literal}
      {/if}


      {* ----------- Tour ----------- *}
      {if isset($specialPic.tour)}
      {literal}
      $('.Tour-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.tour.src}{literal}")');
         $('#title-banner').text('{/literal}{$specialPic.tour.title}{literal}');
         $('#caption-banner').text('{/literal}{$specialPic.tour.heading}{literal}');
      });
      {/literal}
      {/if}


      {* ----------- Insurance ----------- *}
      {if isset($specialPic.insurance)}
      {literal}
      $('.Insurance-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.insurance.src}{literal}")');
         $('#title-banner').text('{/literal}{$specialPic.insurance.title}{literal}');
         $('#caption-banner').text('{/literal}{$specialPic.insurance.heading}{literal}');
      });
      {/literal}
      {/if}


      {* ----------- Visa ----------- *}
      {if isset($specialPic.visa)}
      {literal}
      $('.Visa-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.visa.src}{literal}")');
         $('#title-banner').text('{/literal}{$specialPic.visa.title}{literal}');
         $('#caption-banner').text('{/literal}{$specialPic.visa.heading}{literal}');
      });
      {/literal}
      {/if}


      {* ----------- Gasht ----------- *}
      {if isset($specialPic.gasht)}
      {literal}
      $('.GashtTransfer-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.gasht.src}{literal}")');
      });
      {/literal}
      {/if}


      {* ----------- Entertainment ----------- *}
      {if isset($specialPic.entertainment)}
      {literal}
      $('.Entertainment-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.entertainment.src}{literal}")');
      });
      {/literal}
      {/if}


      {* ----------- Europcar ----------- *}
      {if isset($specialPic.Europcar)}
      {literal}
      $('.Europcar-tab-pic').click(function () {
         $('.parent-data-demo').css('background-image', 'url("{/literal}{$specialPic.Europcar.src}{literal}")');
      });
      {/literal}
      {/if}


      {literal}
   }
</script>
{/literal}
