{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="special_tour_params" value=['type'=>'special','limit'=> '5','dateNow' => $dateNow]}

{assign var='special_tours' value=$obj_main_page->getToursReservation($special_tour_params)}

<section class="tour py-5">
    <div class="container">
        <div class="tourMain">
            <div class="title col-12 pb-4">
                <h2>تور های ویژه</h2>
            </div>
            <div class="tour_owl owl-carousel owl-theme">
                {foreach $special_tours as $tour}

                <div class="item">
                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id']}/{$tour['slug']}" class="tourLink">
                        <div class="tourImg">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" alt="{$tour['tour_name']}">
                        </div>
                        <div class="tourText">
                            <h3>{$tour['tour_name']}</h3>
                            <div>
                                <span>3 شب</span><span>اعتبار تور :
                                    {assign var="year" value=substr($tour['start_date'], 0, 4)}
                                    {assign var="month" value=substr($tour['start_date'], 4, 2)}
                                    {assign var="day" value=substr($tour['start_date'], 6)}
                                    {$year}/{$month}/{$day}
                                </span>
                            </div>
                            <h4>قیمت : {$tour['min_price_r']|number_format} ریال </h4>
                            <span>مشاهده</span>
                        </div>
                    </a>
                </div>
                {/foreach}

            </div>
        </div>
    </div>
</section>
