{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params_external" value=['type'=>'special','limit'=> '3','dateNow' => $dateNow, 'country' =>'external','city' => null]}
{assign var='tour_external_special' value=$obj_main_page->getToursReservation($tour_params_external)}
{if $tour_external_special}
    {assign var='check_tour' value=true}
{/if}
{assign var="min_external_external" value=0}
{assign var="max_external_external" value=3}

{if $check_tour}
    <section class="i_modular_tours accordion-gallery">
        <div class="__tour__external__special__ container">
            <div class="title-center">
                <div class="text-title-center">
                    <h2>پیشنهاد سفر ایران تکنولوژی</h2>
                    <p>کاوش در زیبایی‌های دنیا: چهار مقصد جذاب برای سفرهای آینده</p>
                </div>
            </div>
            <div class="parent-accordion-gallery">
                <div class="gallery-wrap">

                    {foreach $tour_external_special as $item}
                        {if $min_external_external <= $max_external_external}

                            <div style='background-image:url("{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}")' class="__i_modular_nc_item_class_0 item-accordion-gallery item-1">
                                <div class="accordion-gallery-box-hover">
                                    <h2 class="__title_class__">{$item['tour_name']}</h2>
                                    <p class="__description_class__">{$item['description']}</p>
                                    <h3><span class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</h3>
                                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">

                                        اطلاعات بیشتر

                                    </a>
                                </div>
                            </div>

                            {$min_external_external = $min_external_external + 1}
                        {/if}
                    {/foreach}




                </div>
            </div>
        </div>
    </section>
{/if}