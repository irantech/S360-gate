{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="foregin_tour_params" value=['limit'=> '20','dateNow' => $dateNow , 'category' => '18']}
{assign var='foregin_tours' value=$obj_main_page->getToursReservation($foregin_tour_params)}

{*{if $foregin_tours}*}
<section class="special_tours">
    <div class="container">
        <div class="box_special_tours">
            <div class="titel_special_tours">
                <h4>تورهای ویژه پا به پا سفر</h4>
                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/7/1">
                    مشاهده بیشتر
                    <i class="fa-light fa-chevron-left"></i>
                </a>
            </div>
            <div class="owl-carousel owl-theme owl_special_tours">
                {foreach $foregin_tours as $item}
                    {assign var="tour_type_id" value=$item['tour_type_id']}
                    {assign var="isInstallment" value=strpos($tour_type_id, '"17"')}
                    <div class="item">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="parent_special_tours">
                            <div class="img_card position-relative">
                                <div class="parent-img">
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"
                                         alt="{$item['tour_name']}">
                                </div>
                                <div class="d-flex align-items-center night">
                                  <span class='d-flex'>
                                      <i class="fa-light fa-moon ml-1 d-flex align-items-center"></i>
                                   <span class="detail">{$item['night']} شب </span>
                                  </span>
                                </div>
                                {if $isInstallment !== false}
                                    <span class="installment-label">
                                                    اقساطی
                                                </span>
                                {/if}
                            </div>
                            <div class="text_card">
                                <h3 class="titel-head-card">
                                    {$item['tour_name']}
                                </h3>
                                <div class='text_card2 box_cap'>
                                    <div class="d-flex align-items-center justify-content-between date-special-tour">
                                        <div>
                                            <span class="title ml-1">
                                                <i class="fa-light fa-calendar"></i>
                                            </span>
                                            <span class="detail">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                        </span>
                                        </div>
                                    </div>
                                    <div class="airline">
                                        <span>
                                            <img src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 35px'>
                                        </span>
                                        <span class='airline-name'>{$item['airline_name']}</span>
                                    </div>
                                </div>
                                <div class="card_price">
                                    <p>
                                        {if $item['min_price_r'] != 0}
                                            {$item['min_price_r']|number_format} ریال
                                        {/if}
                                        {if  $item['min_price_r'] != 0 &&  $item['min_price_a'] } + {/if}
                                        {if $item['min_price_a']}

                                            {$item['min_price_a']|number_format} {$item['currency_type']}
                                        {/if}
                                    </p>
                                </div>

                            </div>
                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</section>
{*{/if}*}