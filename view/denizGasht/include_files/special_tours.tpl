{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="tour_params" value=['type'=>'special','limit'=> '6','dateNow' => $dateNow, 'country' =>'','city' => null]}
{assign var='tour_special' value=$obj_main_page->getToursReservation($tour_params)}
{if $tour_special}
    {assign var='check_general' value=true}
{/if}
{assign var="min_" value=0}
{assign var="max_" value=5}

{if $check_general}
    <section class="special_tours">
        <div class="container">
            <div class="box_special_tours">
                <div class="title">
                    <h2>محبوب ترین تورها</h2>
                    <p>
                        برگزاری تورهای داخلی و خارجی با بهترین کیفیت و امکانات
                    </p>
                </div>

                <div class="grid01">
                    {foreach $tour_special as $item}
                        {if $min_ <= $max_}
                            <div>
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}"
                                   class="parent_special_tours">
                                    <div class="img_card position-relative">
                                        <div class="parent-img">
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"
                                                 alt="{$item['tour_name']}">
                                        </div>
                                        <div class="card_price">
                                            <p>
                                                {if $item['min_price_r'] != 0}
                                                    {$item['min_price_r']|number_format} ریال
                                                {/if}
                                                {if  $item['min_price_r'] != 0 &&  $item['min_price_a'] }  {/if}
                                                {if $item['min_price_a'] && $item['min_price_a'] != 0}

                                                    + {$item['min_price_a']|number_format} {$item['currency_type']}
                                                {/if}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text_card">
                                        <h3 class="titel-head-card">
                                            {$item['tour_name']}
                                        </h3>
                                        <div class="d-flex align-items-center justify-content-between box_cap">
                                            <div>
                                                <span class="title">رفت</span>
                                                <span class="detail">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                        </span></div>
                                            <div class="d-flex align-items-center">
                                            <span>
                                                <i class="far fa-moon _light-gray-color"></i>
                                            </span>
                                                <span>
                                            <span class="detail">{$item['night']} شب </span>
                                            </div>
                                        </div>
                                        <div class="airline">
                                            <span>ایرلاین</span>
                                            <span class='airline-name'>{$item['airline_name']}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            {$min_ = $min_ + 1}
                        {/if}
                    {/foreach}
                </div>

                <a class="btn-more" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/all">
                    مشاهده بیشتر
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </section>
{/if}
