{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}

{assign var="special_tour_params" value=['type'=>'special','limit'=> '4','dateNow' => $dateNow]}
{assign var='special_tours' value=$obj_main_page->getToursReservation($special_tour_params)}

{assign var="internal_tour_params" value=['type'=>'','limit'=> '4','dateNow' => '', 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'','limit'=> '4','dateNow' => '', 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}

<section class="tours-style-demo">
    <div class="container">

        <!-- تور ویژه -->
        <div class="section-title">
            <h2>تور های ویژه</h2>
        </div>

        <div class="tour-carousel owl-carousel" id="specialCarousel">
            {foreach $special_tours as $tour}
                <div class="tour-card">
                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id_same']}/{$tour['tour_slug']}">
                        <div class="tour-img">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" alt="{$tour['tour_name']}">
                        </div>
                        <div class="tour-info">
                            <p class="tour-city">{$tour['tour_name']}</p>
                            <span class="tour-time">
                                تاریخ حرکت : {$tour.start_date|substr:0:4}/{$tour.start_date|substr:4:2}/{$tour.start_date|substr:6:2}
                                <span>{$tour.night} شب</span>
                            </span>
                            <p class="price">شروع قیمت از <span>{$tour['min_price_r']|number_format} تومان</span></p>
                        </div>
                    </a>
                </div>
            {/foreach}
        </div>

        <!-- تور داخلی -->
        <div class="section-title mt-5">
            <h2>تور های داخلی</h2>
        </div>

        <div class="tour-carousel owl-carousel" id="internalCarousel">
            {foreach $internalTours as $item}
                <div class="tour-card">
                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                        <div class="tour-img">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                        </div>
                        <div class="tour-info">
                            <p class="tour-city">{$item['tour_name']}</p>
                            <span class="tour-time">
                                تاریخ حرکت : {$tour.start_date|substr:0:4}/{$tour.start_date|substr:4:2}/{$tour.start_date|substr:6:2}
                                <span>{$tour.night} شب</span>
                            </span>
                            <p class="price">شروع قیمت از <span>{$item['min_price']['discountedMinPriceR']|number_format} تومان</span></p>
                        </div>
                    </a>
                </div>
            {/foreach}
        </div>

        <!-- تور خارجی -->
        <div class="section-title mt-5">
            <h2>تور های خارجی</h2>
        </div>

        <div class="tour-carousel owl-carousel" id="foreignCarousel">
            {foreach $foreginTours as $item}
                <div class="tour-card">
                    <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                        <div class="tour-img">
                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                        </div>
                        <div class="tour-info">
                            <p class="tour-city">{$item['tour_name']}</p>
                            <span class="tour-time">
                                تاریخ حرکت : {$tour.start_date|substr:0:4}/{$tour.start_date|substr:4:2}/{$tour.start_date|substr:6:2}
                                <span>{$tour.night} شب</span>
                            </span>
                            <p class="price">شروع قیمت از <span>{$item['min_price']['discountedMinPriceR']|number_format} تومان</span></p>
                        </div>
                    </a>
                </div>
            {/foreach}
        </div>

    </div>
</section>


<script>
    $(document).ready(function(){
        $('.tour-carousel').owlCarousel({
            rtl: true,
            loop: false,
            margin: 10,       // فاصله کمتر
            nav: true,
            dots: false,
            mouseDrag: true,   // فعال برای اسکرول با موس
            touchDrag: true,   // فعال برای اسکرول موبایل
            responsive:{
                0:{ items:1 },
                576:{ items:2 },
                768:{ items:3 },
                992:{ items:4 }  // همیشه 4 کارت روی دسکتاپ
            }
        });
    });

</script>
