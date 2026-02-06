{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '5','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
                        {assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
                        {if $tour_internal}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_internal" value=0}
                        {assign var="max_internal" value=4}
                    
{assign var="tour_params_external" value=['type'=>'','limit'=> '5','dateNow' => $dateNow, 'country' =>'external','city' => null]}
                        {assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
                        {if $tour_external}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_external" value=0}
                        {assign var="max_external" value=4}
                    
{if $check_general}
<section class="i_modular_tours tour-kanoun">
<div class="container">
<div class="title-kanoun">
<div class="text-title-kanoun">
<h2>تورهای محبوب </h2>
<p>سفرهای ویژه با تجربیات بی‌نظیر در دنیای گردشگری</p>
</div>
<a class="more-title-kanoun" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
<span>تورهای بیشتر</span>
<svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
</a>
</div>
<div>
<div class="parent-ul-tour col-lg-12 col-md-12 col-12">
<ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab" role="tablist">
<li class="nav-item" role="presentation">
<button aria-controls="tour-dakheli" aria-selected="true" class="nav-link active" data-target="#tour-dakheli" data-toggle="pill" id="tab-tour-dakheli" role="tab" type="button"> داخلی

                            </button>
</li>
<li class="nav-item" role="presentation">
<button aria-controls="tour-khareji" aria-selected="false" class="nav-link" data-target="#tour-khareji" data-toggle="pill" id="tab-tour-khareji" role="tab" type="button"> خارجی

                            </button>
</li>
</ul>
</div>
<div class="parent-tab-tour">
<div class="tab-content" id="pills-tabContent">
<div aria-labelledby="tab-tour-dakheli" class="__tour__internal__ tab-pane fade show active" id="tour-dakheli" role="tabpanel">
<div class="owl-carousel owl-theme tour-owl">

                        {foreach $tour_internal as $item}
                            {if $min_internal <= $max_internal}
                        
<div class="__i_modular_nc_item_class_0 item">
<a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
</div>
<div class="parent-text-owl">
<h2 class="__title_class__">{$item['tour_name']}</h2>
<div class="parent-rating">
<div class="rating-stars">
{for $i = 0; $i < count($item['rate_average']); $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}
<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
</div>
<span>آرا      (<custom class="__rate_count_class__">{$item['rate_count']}</custom>)</span>
</div>
<div class="money-tour-tab ___price_class__">
    <span>
        <i class="fa-light fa-sack-dollar"></i>
         قیمت:
    </span>
    <span class='color-toman'>
          {$item['min_price']['discountedMinPriceR']|number_format}
    </span>
</div>
<div class="money-calendar-tab __date_class__">
    <span>
        <i class="fa-light fa-calendar-days"></i>
         تاریخ حرکت:
    </span>
    <span>
         {assign var="year" value=substr($item['start_date'], 0, 4)}
        {assign var="month" value=substr($item['start_date'], 4, 2)}
        {assign var="day" value=substr($item['start_date'], 6)}
        {$year}/{$month}/{$day}
    </span>
</div>
<div class="night __night_class__">
    <i class="fa-light fa-clock"></i>
    <span>{$item['night']}</span>
</div>
<button class="btn-tour-tab">
          مشاهده بیشتر
</button>
</div>
</a>
</div>

                            {$min_internal = $min_internal + 1}
                            {/if}
                        {/foreach}
                        




</div>
</div>
<div aria-labelledby="tab-tour-khareji" class="__tour__external__ tab-pane fade" id="tour-khareji" role="tabpanel">
<div class="owl-carousel owl-theme tour-owl">

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}
                        
<div class="__i_modular_nc_item_class_0 item">
<a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
</div>
<div class="parent-text-owl">
<h2 class="__title_class__">{$item['tour_name']}</h2>
<div class="parent-rating">
<div class="rating-stars">
{for $i = 0; $i < count($item['rate_average']); $i++}<svg class="__star_class_light__1" viewbox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>{/for}



</div>
<span class="">آرا      (<custom class="__rate_count_class__">{$item['rate_count']}</custom>)</span>
</div>
<div class="money-tour-tab ___price_class__">
    <span>
      <i class="fa-light fa-sack-dollar"></i>
       قیمت:
    </span>
    <span class='color-toman'>
            {$item['min_price']['discountedMinPriceR']|number_format}
    </span>
</div>
<div class="money-calendar-tab __date_class__">
    <span>
          <i class="fa-light fa-calendar-days"></i>
           تاریخ حرکت:
    </span>
    <span>
        {assign var="year" value=substr($item['start_date'], 0, 4)}
        {assign var="month" value=substr($item['start_date'], 4, 2)}
        {assign var="day" value=substr($item['start_date'], 6)}
        {$year}/{$month}/{$day}
    </span>
</div>
<div class="night __night_class__">
    <i class="fa-light fa-clock"></i>
    {$item['night']}
</div>
<button class="btn-tour-tab">

                                                مشاهده بیشتر

                                            </button>
</div>
</a>
</div>

                            {$min_external = $min_external + 1}
                            {/if}
                        {/foreach}
                        




</div>
</div>
</div>
</div>
</div>
</div>
</section>
{/if}