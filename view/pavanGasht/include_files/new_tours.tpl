{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'internal','category' => '9']}
{assign var="foreging_tour_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'category' =>'7']}
{assign var="earth_tours_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow,'category' => '3']}
{assign var="norozy_tours_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow,'category' => '13']}
{assign var="recent_tours_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow,  'category' => '6']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
{assign var='earthTours' value=$obj_main_page->getToursReservation($earth_tours_params)}
{assign var='norozyTours' value=$obj_main_page->getToursReservation($norozy_tours_params)}
{assign var='recentTours' value=$obj_main_page->getToursReservation($recent_tours_params)}

{if !empty($internalTours) || !empty($foreginTours) || !empty($earthTours)  || !empty($norozyTours)  || !empty($recentTours)}
    <section class="new_tours">
        <div class="container">
            <div class="titel_site">
                <h4>جدیدترین تورها آژانس خدمات مسافرت هوائی و جهانگردی</h4>
                <ul class="nav nav-pills " id="tab-tour" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tour1" data-toggle="pill" data-target="#content-tour1" type="button" role="tab" aria-controls="content-tour1" aria-selected="true">داخلی</button>
                    </li>
                    {if $foreginTours}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tour2" data-toggle="pill" data-target="#content-tour2" type="button" role="tab" aria-controls="content-tour2" aria-selected="false">خارجی</button>
                    </li>
                    {/if}
                    {if $norozyTours}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link nowruz-link-tour-new" id="tour4" data-toggle="pill" data-target="#content-tour4" type="button" role="tab" aria-controls="content-tour4" aria-selected="false">
                            نوروزی
                        </button>
                    </li>
                    {/if}
                    {if $earthTours}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tour3" data-toggle="pill" data-target="#content-tour3" type="button" role="tab" aria-controls="content-tour3" aria-selected="false">زمینی
                        </button>
                    </li>
                    {/if}
                </ul>
            </div>
            <div id="tab-content-tour" class="tab-content">
                <div class="tab-pane fade show active" id="content-tour1" role="tabpanel" aria-labelledby="tour1">
                    <div class="tour-list-component">
                        <div class="tours_titr">
                            <div class="d-flex flex-wrap w-100">
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-pen-to-square icon_titr"></i>
                                        <span class="text_titr">عنوان تور</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-bed-front icon_titr"></i>
                                        <span class="text_titr">مدت اقامت</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-plane-up icon_titr"></i>
                                        <span class="text_titr">ایرلاین</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-coins icon_titr"></i>
                                        <span class="text_titr">قیمت</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="respancive_flex">
                        {foreach $internalTours as $item}
                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">{if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
                                            <i class="fa-light fa-plane-up"></i>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        <div class="parent_item">
                                     <span class="Money_color font-weight-bold">
                                         <i class="fa-light fa-sack-dollar"></i>
                                        {$item['min_price_r']|number_format}
                                        <span class="text_toman">ریال</span>
                                    </span>
                                        </div>
                                        <i class="fa-solid fa-caret-left arrow_after"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {/foreach}

                    </div>
                </div>
                <div class="tab-pane fade show " id="content-tour2" role="tabpanel" aria-labelledby="tour2">
                    <div class="tour-list-component">
                        <div class="tours_titr">
                            <div class="d-flex flex-wrap w-100">
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-pen-to-square icon_titr"></i>
                                        <span class="text_titr">عنوان تور</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-bed-front icon_titr"></i>
                                        <span class="text_titr">مدت اقامت</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-plane-up icon_titr"></i>
                                        <span class="text_titr">ایرلاین</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-coins icon_titr"></i>
                                        <span class="text_titr">قیمت</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="respancive_flex">
                        {foreach $foreginTours as $item}

                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">{if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
                                            <i class="fa-light fa-plane-up"></i>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        <div class="parent_item">
                                     <span class="Money_color font-weight-bold">
                                         <i class="fa-light fa-sack-dollar"></i>
                                        {$item['min_price_r']|number_format}
                                        <span class="text_toman">ریال</span>
                                    </span>
                                        </div>
                                        <i class="fa-solid fa-caret-left arrow_after"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {/foreach}
                    </div>
                </div>
                <div class="tab-pane fade show " id="content-tour3" role="tabpanel" aria-labelledby="tour3">
                    <div class="tour-list-component">
                        <div class="tours_titr">
                            <div class="d-flex flex-wrap w-100">
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-pen-to-square icon_titr"></i>
                                        <span class="text_titr">عنوان تور</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-bed-front icon_titr"></i>
                                        <span class="text_titr">مدت اقامت</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-plane-up icon_titr"></i>
                                        <span class="text_titr">ایرلاین</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-coins icon_titr"></i>
                                        <span class="text_titr">قیمت</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="respancive_flex">
                        {foreach $norozyTours as $item}
                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">{if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
                                            <i class="fa-light fa-plane-up"></i>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        <div class="parent_item">
                                     <span class="Money_color font-weight-bold">
                                         <i class="fa-light fa-sack-dollar"></i>
                                        {$item['min_price_r']|number_format}
                                        <span class="text_toman">ریال</span>
                                    </span>
                                        </div>
                                        <i class="fa-solid fa-caret-left arrow_after"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {/foreach}
                    </div>
                </div>
                <div class="tab-pane fade show " id="content-tour4" role="tabpanel" aria-labelledby="tour4">
                    <div class="tour-list-component">
                        <div class="tours_titr">
                            <div class="d-flex flex-wrap w-100">
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-pen-to-square icon_titr"></i>
                                        <span class="text_titr">عنوان تور</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-bed-front icon_titr"></i>
                                        <span class="text_titr">مدت اقامت</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-plane-up icon_titr"></i>
                                        <span class="text_titr">ایرلاین</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 border_my">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-light fa-coins icon_titr"></i>
                                        <span class="text_titr">قیمت</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="respancive_flex">
                        {foreach $earthTours as $item}
                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">{if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
                                            <i class="fa-light fa-plane-up"></i>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        <div class="parent_item">
                                     <span class="Money_color font-weight-bold">
                                         <i class="fa-light fa-sack-dollar"></i>
                                        {$item['min_price_r']|number_format}
                                        <span class="text_toman">ریال</span>
                                    </span>
                                        </div>
                                        <i class="fa-solid fa-caret-left arrow_after"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {/foreach}
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex align-items-center justify-content-center ">
                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour" class="btn_link_more">
                    مشاهده بیشتر
                </a>
            </div>
        </div>
    </section>




{/if}


























