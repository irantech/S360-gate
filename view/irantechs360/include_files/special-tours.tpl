{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="special_tour_params" value=['type'=>'special','limit'=> '5','dateNow' => $dateNow]}

{assign var='special_tours' value=$obj_main_page->getToursReservation($special_tour_params)}


{assign var="langVar" value=""}
{assign var="priceVar" value="_r"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="_en"}
    {assign var="priceVar" value="_a"}
{/if}

<div class="section_special_tour">
    <div class="container">
        <div class="titr">
            ##specialTours##
        </div>
        <div class=" popular_places_area">
            <div class="">
                <div class="owl-carousel owl_tour_local owl-rtl owl-loaded owl-drag">
                                {foreach $special_tours as $tour}
                                    <div class="item ">
                                    <div class="single_place">
                                        <div class="thumb">
                                            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tour['tour_pic']}" alt="{$tour['tour_name']}">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id_same']}/{$tour['tour_name_en']}" class="prise">
                                                <div class="package__details__inner">
                                                    {if $tour["min_price$priceVar"]}

                                                    <p>##Startprice##</p>
                                                    <p class="packg__prize">

                                                            {$tour["min_price$priceVar"]|number_format}   ##Rial##

                                                        <span>

                                                        </span>
                                                    </p>
                                                    {/if}

                                                </div>
                                            </a>
                                        </div>
                                        <div class="place_info">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id_same']}/{$tour['tour_name_en']|replace:' ':'-'}">
                                                <h3>{$tour["tour_name$langVar"]}</h3>
                                            </a>

                                            <div class="rating_days flex-wrap d-flex justify-content-between">
                                            <span class="w-100"><i class="fa fa-clock"></i> ##Tourduration## : <em>{$tour['night']} ##Timenight## </em>
                                            </span>
                                                <span class="w-100">
                                                <i class="far fa-calendar-alt"></i> ##dateMove## :
                                                    {assign var="year" value=substr($tour['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($tour['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($tour['start_date'], 6)}

                                                <span>{$year}/{$month}/{$day}</span>
                                            </span>

                                            </div>
                                        </div>
                                        <div class="btn_theme">
                                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$tour['id_same']}/{$tour["tour_name_en"]|replace:' ':'-'}">
                                                <button class="btn theme-btn seub-btn b-0">
                                                <span>
                                                    ##TourDetails##
                                                </span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {/foreach}
{*                    <div class="owl-nav disabled">*}
{*                        <button type="button" role="presentation" class="owl-prev disabled">*}
{*                            <span aria-label="Previous">‹</span>*}
{*                        </button>*}
{*                        <button type="button" role="presentation" class="owl-next disabled">*}
{*                            <span aria-label="Next">›</span>*}
{*                        </button>*}
{*                    </div>*}
{*                    <div class="owl-dots disabled"></div>*}
                </div>
            </div>

        </div>

    </div>

</div>