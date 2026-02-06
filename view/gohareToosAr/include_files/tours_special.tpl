
{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}

{assign var="internal_tour_params" value=['type'=>'','limit'=> '4','dateNow' => $dateNow, 'country' =>'internal']}
{assign var="foreging_tour_params" value=['type'=>'','limit'=> '4','dateNow' => $dateNow, 'country' =>'external']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
<section class="tour-demo">
    <div class="container">
        <div class="title-demo">
            <div class="text-title-demo">
                <h2>الجولات الشعبية</h2>
                <p>
                    السفر حول العالم، جولات محلية ودولية مطلوبة للاستمتاع بجماليات العالم
                </p>
            </div>
            <a href="{$smarty.const.ROOT_ADDRESS}/page/Tour" class="more-title-demo">
                <span>جولات أكثر</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path></svg>
            </a>
        </div>

        <div class="tour-owl-parent">
            <div class="owl-carousel owl-theme tour-owl">
                {foreach $foreginTours as $item}
                    <div class="item">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="parent-link-tour">
                            <div class="parent-img-tour">
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name_en']}">
                            </div>
                            <div class="parent-text-tour">
                                <span class="city-tour">{$item['destination_city_name']}</span>
                                <h4>{$item['tour_name_en']}</h4>
                                <div class="night-tour">
                                    <i class="fa-sharp fa-solid fa-clock"></i>
                                    {$item['night']}  ليالي
                                </div>
                                <div class="price-tour">
                                    {*
                                    <div class="start-tour">
                                        <i class="fa-solid fa-star"></i>
                                        <span>4.8</span>
                                        <span class="reviews">320 تقييمًا</span>
                                    </div>
                                    *}
                                    <div class="start-price">
                                        <span>بداية السعر</span>
                                        <span class="number-price">100
                                         {$item['min_price']['discountedMinPriceR']|number_format} ریال
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <img class="circle-tour" src="{$item['logo_transport']}" alt="{$item['airline_name']}">
                        </a>
                    </div>
                {/foreach}


                {foreach $internalTours as $item}
                    <div class="item">
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="parent-link-tour">
                            <div class="parent-img-tour">
                                <img  src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name_en']}">
                            </div>
                            <div class="parent-text-tour">
                                <span class="city-tour">{$item['destination_city_name']}</span>
                                <h4>{$item['tour_name_en']}</h4>
                                <div class="night-tour">
                                    <i class="fa-sharp fa-solid fa-clock"></i>
                                    {$item['night']}  ليالي
                                </div>
                                <div class="price-tour">
                                    {*
                                    <div class="start-tour">
                                        <i class="fa-solid fa-star"></i>
                                        <span>4.8</span>
                                        <span class="reviews">320 تقييمًا</span>
                                    </div>
                                     *}
                                    <div class="start-price">
                                        <span>بداية السعر</span>
                                        <span class="number-price">{$item['min_price']['discountedMinPriceR']|number_format}  ريال</span>
                                    </div>
                                </div>
                            </div>
                            <img class="circle-tour" src="{$item['logo_transport']}" alt="{$item['airline_name']}">
                        </a>
                    </div>
                {/foreach}



            </div>
        </div>


    </div>
</section>
