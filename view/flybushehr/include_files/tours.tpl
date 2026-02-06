{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_internal" value=['type'=>'','limit'=> '3','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
                        {assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
                        {if $tour_internal}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_internal" value=0}
                        {assign var="max_internal" value=2}
                    
{assign var="tour_params_internal" value=['type'=>'','limit'=> '3','dateNow' => $dateNow, 'country' =>'internal','city' => null]}
                        {assign var='tour_internal' value=$obj_main_page->getToursReservation($tour_params_internal)}
                        {if $tour_internal}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_internal" value=0}
                        {assign var="max_internal" value=2}
                    
{if $check_general}
<section class="i_modular_tours container tour py-5">
<div class="title_tour pb-4">
<div>
<h2>تور</h2>
</div>
<ul class="nav nav-pills mb-3" id="pills-tabTwo" role="tablist">
<li class="nav-item">
<a aria-controls="pills-home" aria-selected="true" class="nav-link active" data-toggle="pill" href="#pills-homeTwo" id="pills-home-tabTwo" role="tab">داخلی</a>
</li>
<li class="nav-item">
<a aria-controls="pills-profile" aria-selected="false" class="nav-link" data-toggle="pill" href="#pills-profileTwo" id="pills-profile-tabTwo" role="tab">خارجی</a>
</li>
</ul>
</div>
<div class="tab-content" id="pills-tabContentTwo">
<div aria-labelledby="pills-home-tab" class="__tour__internal__ tab-pane fade show active" id="pills-homeTwo" role="tabpanel">
<div class="tour_style">

                        {foreach $tour_internal as $item}
                            {if $min_internal <= $max_internal}
                        
<a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
<div class="col-md-4 p-0"><img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/></div>
<div class="col-md-8 p-0">
<h2 class="__title_class__">{$item['tour_name']}</h2>
<span>
<i class="far ml-2 fa-clock-rotate-left"></i>
                                مدت تور :
                                <span class="__night_class__">{$item['night']}</span>
</span>
<span>
<i class="far ml-2 fa-calendar-note"></i> تاریخ حرکت :
                                <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                {assign var="day" value=substr($item['start_date'], 6)}
                                {$year}/{$month}/{$day}
                                </span>
</span>
<span>
<i class="far ml-2 fa-coin"></i>قیمت :
                                <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>
<span>ریال</span>
</span>
</div>
</a>

                            {$min_internal = $min_internal + 1}
                            {/if}
                        {/foreach}
                        


</div>
</div>
<div aria-labelledby="pills-profile-tab" class="__tour__internal__ tab-pane fade" id="pills-profileTwo" role="tabpanel">
<div class="tour_style">

                        {foreach $tour_internal as $item}
                            {if $min_internal <= $max_internal}
                        
<a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
<div class="col-md-4 p-0"><img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/></div>
<div class="col-md-8 p-0">
<h2 class="__title_class__">{$item['tour_name']}</h2>
<span>
<i class="far ml-2 fa-clock-rotate-left"></i>
                                مدت تور :
                                <span class="__night_class__">{$item['night']}</span>
</span>
<span>
<i class="far ml-2 fa-calendar-note"></i> تاریخ حرکت :
                                <span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                {assign var="day" value=substr($item['start_date'], 6)}
                                {$year}/{$month}/{$day}
                                </span>
</span>
<span>
<i class="far ml-2 fa-coin"></i>قیمت :
                                <span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>
<span>ریال</span>
</span>
</div>
</a>

                            {$min_internal = $min_internal + 1}
                            {/if}
                        {/foreach}
                        


</div>
</div>
</div>
</section>
{/if}