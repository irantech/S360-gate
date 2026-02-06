{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
                        {assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
                        {if $tour_internal}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_internal" value=0}
                        {assign var="max_internal" value=5}
                    
{assign var="tour_params_internal" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
                        {assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
                        {if $tour_internal}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_internal" value=0}
                        {assign var="max_internal" value=5}
                    
{assign var="tour_params_external" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'external','city' => null]}
                        {assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
                        {if $tour_external}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_external" value=0}
                        {assign var="max_external" value=5}
                    
{assign var="tour_params_external" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'external','city' => null]}
                        {assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
                        {if $tour_external}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_external" value=0}
                        {assign var="max_external" value=5}
                    
{if $check_general}
<section class="i_modular_tours tour-kanoun">
<div class="container">
<div class="title">
<div class="title-text">
<h3>Arvan Travel</h3>
<h2>ARVAN TOURS</h2>
</div>
<a class="read-more" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
<span>View more</span>
<svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
<!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
<path d="M297 239c9.4 9.4 9.4 24.6 0 33.9L105 465c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l175-175L71 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L297 239z"></path>
</svg>
</a>
</div>
<div>
<div class="parent-ul-tour col-lg-12 col-md-12 col-12">
<ul class="nav nav-pills d-flex align-items-center justify-content-center" id="pills-tab" role="tablist">
<li class="nav-item" role="presentation">
<button aria-controls="tour-dakheli" aria-selected="true" class="nav-link active" data-target="#tour-dakheli" data-toggle="pill" id="tab-tour-dakheli" role="tab" type="button">Iran
                            </button>
</li>
<li class="nav-item" role="presentation">
<button aria-controls="tour-khareji" aria-selected="false" class="nav-link" data-target="#tour-khareji" data-toggle="pill" id="tab-tour-khareji" role="tab" type="button">Foreign
                            </button>
</li>
</ul>
</div>
<div class="parent-tab-tour">
<div class="tab-content" id="pills-tabContent">
<div aria-labelledby="tab-tour-dakheli" class="tab-pane fade show active" id="tour-dakheli" role="tabpanel">
<div class="__tour__internal__ owl-carousel owl-theme tour-owl">

                        {foreach $tour_internal as $item}
                            {if $min_internal <= $max_internal}
                        
<div class="__i_modular_nc_item_class_0 item">
<a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
<span class="btn-main">
<i class="far fa-link"></i>
</span>
</div>
<div class="parent-text-owl">
<div class="parent-title-rank">
<h2 class="__title_class__">{$item['tour_name']}</h2>
</div>
<div class="des-tour">
<div class="money-tour-tab"> <i class="fa-light fa-sack-dollar color-green"></i>
<span class="___price_class__ color-toman">{$item['min_price']['discountedMinPriceR']|number_format}</span>
</div>
<div class="night">
<i class="fa-light fa-moon"></i>
<span><span class="__night_class__">{$item['night']}</span> night</span>
</div>
</div>
</div>
</a>
</div>

                            {$min_internal = $min_internal + 1}
                            {/if}
                        {/foreach}
                        





</div>
<div class="__tour__internal__ parent-tours">

                        {foreach $tour_internal as $item}
                            {if $min_internal <= $max_internal}
                        
<a class="__i_modular_nc_item_class_0 link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
<span class="btn-main">
<i class="far fa-link"></i>
</span>
</div>
<div class="parent-text-owl">
<div class="parent-title-rank">
<h2 class="__title_class__">{$item['tour_name']}</h2>
</div>
<div class="des-tour">
<div class="money-tour-tab"> <i class="fa-light fa-sack-dollar color-green"></i>
<span class="___price_class__ color-toman">{$item['min_price']['discountedMinPriceR']|number_format}</span>
</div>
<div class="night">
<i class="fa-light fa-moon"></i>
<span><span class="__night_class__">{$item['night']}</span> night</span>
</div>
</div>
</div>
</a>

                            {$min_internal = $min_internal + 1}
                            {/if}
                        {/foreach}
                        





</div>
</div>
<div aria-labelledby="tab-tour-khareji" class="tab-pane fade" id="tour-khareji" role="tabpanel">
<div class="__tour__external__ owl-carousel owl-theme tour-owl">

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}
                        
<div class="__i_modular_nc_item_class_0 item">
<a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
<span class="btn-main">
<i class="far fa-link"></i>
</span>
</div>
<div class="parent-text-owl">
<div class="parent-title-rank">
<h2 class="__title_class__">{$item['tour_name']}</h2>
</div>
<div class="des-tour">
<div class="money-tour-tab"> <i class="fa-light fa-sack-dollar color-green"></i>
<span class="___price_class__ color-toman">{$item['min_price']['discountedMinPriceR']|number_format}</span>
</div>
<div class="night">
<i class="fa-light fa-moon"></i>
<span><span class="__night_class__">{$item['night']}</span> night</span>
</div>
</div>
</div>
</a>
</div>

                            {$min_external = $min_external + 1}
                            {/if}
                        {/foreach}
                        





</div>
<div class="__tour__external__ parent-tours">

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}
                        
<a class="__i_modular_nc_item_class_0 link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
<span class="btn-main">
<i class="far fa-link"></i>
</span>
</div>
<div class="parent-text-owl">
<div class="parent-title-rank">
<h2 class="__title_class__">{$item['tour_name']}</h2>
</div>
<div class="des-tour">
<div class="money-tour-tab"> <i class="fa-light fa-sack-dollar color-green"></i>
<span class="___price_class__ color-toman">{$item['min_price']['discountedMinPriceR']|number_format}</span>
</div>
<div class="night">
<i class="fa-light fa-moon"></i>
<span><span class="__night_class__">{$item['night']}</span> night</span>
</div>
</div>
</div>
</a>

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