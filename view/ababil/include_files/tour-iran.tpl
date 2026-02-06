{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'','limit'=> '3','dateNow' => $dateNow, 'country' =>'internal']}
{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}

{if !empty($internalTours)}
    <section class="tour_internal d-flex py-5">
        <div class="container">
            <div class="title">
                <h2>تور داخلی</h2>
            </div>
            <div class="tour_grid">
                {foreach $internalTours as $item}
                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                    <div class="imgBox">
                        <img  src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                    </div>
                    <div class="tour_txt">
                        <div class="tour_txt_header">
                            <h2>{$item['tour_name']}</h2>
                            <span>3 شب</span>
                        </div>
                        <div class="tour_txt_footer">
                            <h5>تاریخ حرکت :
                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                {assign var="day" value=substr($item['start_date'], 6)}
                                {$year}/{$month}/{$day}</h5>
                            <h6> قیمت : {$item['min_price_r']} تومان</h6>
                        </div>
                    </div>
                </a>
                {/foreach}

            </div>
            <div class="moreBtnMobile justify-content-center mt-3"><a href="{$smarty.const.ROOT_ADDRESS}/page/tour" class="button">بیشتر</a></div>
        </div>
    </section>
{/if}
