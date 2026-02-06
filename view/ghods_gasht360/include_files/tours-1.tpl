{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
{assign var="tourPopularForegin" value=$objResult->ReservationTourCountries('yes', false , 106)}
{assign var="tourPopularIran" value=$objResult->ReservationTourCities('=1', 'return' , false , 106)}

{if $tourPopularForegin || $tourPopularIran}
    <section class="popular">
        <div class="container">
            <div class="title" data-aos="fade-up">
                <h2>مقاصد پرطرفدار</h2>
                <p>
                    برگزاری تورهای پرطرفدار داخلی و خارجی با بهترین کیفیت و امکانات
                </p>
            </div>
            <ul data-aos="fade-up" class="nav nav-pills d-flex align-items-center justify-content-center" id="popular-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-popular-khareji" data-toggle="pill"
                            data-target="#tour-popular-khareji" type="button" role="tab" aria-controls="tour-khareji"
                            aria-selected="false"> خارجی
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="tab-popular-dakheli" data-toggle="pill"
                            data-target="#tour-popular-dakheli" type="button" role="tab" aria-controls="tour-dakheli"
                            aria-selected="true"> داخلی
                    </button>
                </li>
            </ul>
            <div data-aos="fade-up" class="parent-tab-tour">
                <div class="tab-content" id="popular-Content">
                    <div class="tab-pane fade " id="tour-popular-dakheli" role="tabpanel"
                         aria-labelledby="tab-popular-dakheli">
                        <div class="popular-parent">
                            {foreach key=key_tour item=item_tour from=$tourPopularIran}

                                <a  href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/1-{$item_tour.id}-all/{$objDate->jdate("Y-m-d", '', '', '', 'en')}/106/0"
                                    class="item-popular-box">
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item_tour.tour_pic}" alt="{$item_tour.name}">
                                    <div class="text-popular">
                                        <h2>{($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}</h2>
                                    </div>
                                </a>
                            {/foreach}
                        </div>
                    </div>
                    <div class="tab-pane fade show active" id="tour-popular-khareji" role="tabpanel"
                         aria-labelledby="tab-popular-khareji">
                        <div class="popular-parent">
                            {assign var="count" value="1"}
                            {foreach key=key_tour item=item_tour from=$tourPopularForegin}



                                <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/{$item_tour.country_id}-all/all/106/0"
                                   class="item-popular-box {if $count > 4}display-none-mobile{/if}">
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item_tour.tour_pic}" alt="{$item_tour.name}">
                                    <div class="text-popular">
                                        <h2>{($smarty.const.SOFTWARE_LANG == 'fa') ? $item_tour.name : $item_tour.name_en}</h2>
                                    </div>
                                </a>
                                {$count = $count + 1}
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
            <a data-aos="fade-up" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/all-all/all/3" class="btn-more">
                نمایش تمام مقاصد
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
    </section>
{/if}
