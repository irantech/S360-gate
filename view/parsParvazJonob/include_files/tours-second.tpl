{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_external" value=['type'=>'','limit'=> '1','dateNow' => $dateNow, 'country' =>'external','city' => null]}
                        {assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
                        {if $tour_external}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_external" value=0}
                        {assign var="max_external" value=0}
                    
{assign var="tour_params_external" value=['type'=>'','limit'=> '1','dateNow' => $dateNow, 'country' =>'external','city' => null]}
                        {assign var='tour_external' value=$obj_main_page->getToursReservation($tour_params_external)}
                        {if $tour_external}
                            {assign var='check_general' value=true}
                        {/if}
                        {assign var="min_external" value=0}
                        {assign var="max_external" value=0}
                    
{if $check_general}
<div aria-labelledby="pills-profile-tab" class="i_modular_tours tab-pane fade" id="pills-profile" role="tabpanel">
<div class="__tour__external__ owl-carousel owl-theme owl-tab-tour">

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}
                        

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}
                        
<div class="__i_modular_nc_item_class_0 item">
<a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
</div>
<div class="parent-text-owl">
<h2 class="__title_class__ titr-tour-tab">{$item['tour_name']}</h2>
<div class="money-tour-tab">
<span>
<i class="fa-light fa-sack-dollar"></i>
                                                            قیمت:
                                                        </span>
<span class="color-toman">
<span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>
                                                تومان
                                            </span>
</div>
<div class="money-calendar-tab">
<span>
<i class="fa-light fa-calendar-days"></i>
                                                            تاریخ حرکت:
                                                        </span>
<span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                {assign var="day" value=substr($item['start_date'], 6)}
                                {$year}/{$month}/{$day}
                                </span>
</div>
<div class="parent-btn-night">
<div class="night">
<i class="fa-light fa-clock"></i>
<span class="__night_class__">{$item['night']}</span>شب
                                            </div>
<button class="btn-tour-tab">
                                                مشاهده بیشتر
                                                <i class="fa-solid fa-arrow-left"></i>
</button>
</div>
</div>
</a>
</div>

                            {$min_external = $min_external + 1}
                            {/if}
                        {/foreach}
                        

                            {$min_external = $min_external + 1}
                            {/if}
                        {/foreach}
                        





</div>
<div class="__tour__external__ parent-desc">

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}
                        

                        {foreach $tour_external as $item}
                            {if $min_external <= $max_external}
                        
<div class="__i_modular_nc_item_class_0 items">
<a class="link-parent" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
<div class="parent-img-tour">
<img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
</div>
<div class="parent-text-owl">
<h2 class="__title_class__ titr-tour-tab">{$item['tour_name']}</h2>
<div class="money-tour-tab">
<span>
<i class="fa-light fa-sack-dollar"></i>
                                                            قیمت:
                                                        </span>
<span class="color-toman">
<span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span>
                                                تومان
                                            </span>
</div>
<div class="money-calendar-tab">
<span>
<i class="fa-light fa-calendar-days"></i>
                                                            تاریخ حرکت:
                                                        </span>
<span class="__date_class__">{assign var="year" value=substr($item['start_date'], 0, 4)}
                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                {assign var="day" value=substr($item['start_date'], 6)}
                                {$year}/{$month}/{$day}
                                </span>
</div>
<div class="parent-btn-night">
<div class="night">
<i class="fa-light fa-clock"></i>
<span class="__night_class__">{$item['night']}</span>شب
                                            </div>
<button class="btn-tour-tab">
                                                مشاهده بیشتر
                                                <i class="fa-solid fa-arrow-left"></i>
</button>
</div>
</div>
</a>
</div>

                            {$min_external = $min_external + 1}
                            {/if}
                        {/foreach}
                        

                            {$min_external = $min_external + 1}
                            {/if}
                        {/foreach}
                        





</div>
</div>
{/if}