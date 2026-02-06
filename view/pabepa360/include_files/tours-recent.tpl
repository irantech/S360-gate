{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="internal_tour_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow, 'country' =>'internal','category' => '9']}
{assign var="foreging_tour_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow, 'country' =>'external','category' => '5']}
{assign var="installment_tour_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow, 'category' =>'17']}
{assign var="foreging_tour_cat_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow, 'category' =>'16']}
{assign var="earth_tours_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow,'category' => '3']}
{assign var="summer_tours_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow,'category' => '14']}
{assign var="recent_tours_params" value=['type'=>'','limit'=> '20','dateNow' => $dateNow,  'category' => '6']}

{assign var='internalTours' value=$obj_main_page->getToursReservation($internal_tour_params)}
{assign var='foreginTours' value=$obj_main_page->getToursReservation($foreging_tour_params)}
{assign var='installmentTours' value=$obj_main_page->getToursReservation($installment_tour_params)}
{assign var='earthTours' value=$obj_main_page->getToursReservation($earth_tours_params)}
{*{assign var='summerTours' value=$obj_main_page->getToursReservation($summer_tours_params)}*}
{assign var='recentTours' value=$obj_main_page->getToursReservation($recent_tours_params)}



{if !empty($internalTours) || !empty($foreginTours) || !empty($earthTours)  || !empty($summerTours)  || !empty($recentTours) || !empty($installmentTours)}
<section class="new_tours">
    <div class="container">
        <div class="titr_Terms_Conditions">
            <h4>جدیدترین تورهای پا به پا سفر</h4>
            <ul class="nav nav-pills " id="tab-tour" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">داخلی</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">خارجی</button>
                </li>
{*                <li class="nav-item" role="presentation">*}
{*                    <button class="nav-link nowruz-link-tour-new" id="pills-contact-tab" data-toggle="pill" data-target="#pills-norozi" type="button" role="tab" aria-controls="pills-norozi" aria-selected="false">*}
{*                        <img src='project_files/images/fish-bowl.png'>*}
{*                        نوروزی*}
{*                    </button>*}
{*                </li>*}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">زمینی </button>
                </li>
                {*
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-summer-tab" data-toggle="pill" data-target="#pills-summer" type="button" role="tab" aria-controls="pills-summer" aria-selected="false">تابستانه </button>
                </li>
                *}

                {if $recentTours|count neq 0}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-last-minute-tab" data-toggle="pill" data-target="#pills-last-minute" type="button" role="tab" aria-controls="pills-last-minute" aria-selected="false">لحظه آخری </button>
                </li>
                {/if}
                {if $installmentTours|count neq 0}
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-installment-tour-tab" data-toggle="pill" data-target="#pills-installment-tour" type="button" role="tab" aria-controls="pills-installment-tour" aria-selected="false">تور اقساطی</button>
                </li>
                {/if}
            </ul>
        </div>
        <div class="tab-content" id="tab-content-tour">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="tour-list-component">
                    <div class="tours_titr">
                        <div class="d-flex flex-wrap w-100">
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-pen-to-square icon_titr"></i>
                                    <span class="text_titr">عنوان تور</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-calendar"></i>
                                    <span class="text_titr">تاریخ حرکت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-bed-front icon_titr"></i>
                                    <span class="text_titr">مدت اقامت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-globe icon_titr"></i>
                                    <span class="text_titr">حمل و نقل</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-coins icon_titr"></i>
                                    <span class="text_titr">قیمت</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="respancive_flex">
                    <span  class="span_tours_js respancive_flex">
                        {foreach $internalTours as $item}
                            {assign var="tour_type_id" value=$item['tour_type_id']}
                            {assign var="isInstallment" value=strpos($tour_type_id, '"17"')}

                            <div class="tour-list-body">
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-person-walking-luggage person-icon-recent-tour"></i>
                                            <span class="font-weight-bold hover_titel">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">  {if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
{*                                            <img src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 35px'>*}
                                            <img src="{$item['logo_transport']}" style='width : 35px'>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                                                                    {if $isInstallment !== false}
                                                                                        <span class="installment-label">
                                                    اقساطی
                                                </span>
                                                                                    {/if}
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

                    </span>
                    <a  class="btn-more--new" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-all/all/9">
                        نمایش تمام تورها
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
{*                    <a class="btn-more--new showMoreRecentTour" href="javascript:">*}
{*                        <span>*}
{*                        نمایش بیشتر*}
{*                        </span>*}
{*                        <i class="fa-solid fa-arrow-down"></i>*}
{*                    </a>*}
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="tour-list-component">
                    <div class="tours_titr">
                        <div class="d-flex flex-wrap w-100">
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-pen-to-square icon_titr"></i>
                                    <span class="text_titr">عنوان تور</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-calendar"></i>
                                    <span class="text_titr">تاریخ حرکت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-bed-front icon_titr"></i>
                                    <span class="text_titr">مدت اقامت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-globe icon_titr"></i>
                                    <span class="text_titr">حمل و نقل</span>
                                </div>
                            </div>
                            <div class="col border_my">
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
                        {assign var="tour_type_id" value=$item['tour_type_id']}
                        {assign var="isInstallment" value=strpos($tour_type_id, '"17"')}
                        {if $item['type_vehicle_id'] eq '1'}
                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-person-walking-luggage person-icon-recent-tour"></i>
                                            <span class="font-weight-bold hover_titel">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">  {if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
{*                                            <img src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 35px'>*}
                                            <img src="{$item['logo_transport']}" style='width : 35px'>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        {if $isInstallment !== false}
                                            <span class="installment-label">
                                                    اقساطی
                                                </span>
                                        {/if}
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
                        {/if}
                    {/foreach}

                    <a class="btn-more--new showMoreRecentTour" href="javascript:">
                        <span>
                        نمایش بیشتر
                        </span>
                        <i class="fa-solid fa-arrow-down"></i>
                    </a>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="tour-list-component">
                    <div class="tours_titr">
                        <div class="d-flex flex-wrap w-100">
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-pen-to-square icon_titr"></i>
                                    <span class="text_titr">عنوان تور</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-calendar"></i>
                                    <span class="text_titr">تاریخ حرکت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-bed-front icon_titr"></i>
                                    <span class="text_titr">مدت اقامت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-globe icon_titr"></i>
                                    <span class="text_titr">حمل و نقل</span>
                                </div>
                            </div>
                            <div class="col border_my">
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
                        {assign var="tour_type_id" value=$item['tour_type_id']}
                        {assign var="isInstallment" value=strpos($tour_type_id, '"17"')}
                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-person-walking-luggage person-icon-recent-tour"></i>
                                            <span class="font-weight-bold hover_titel">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">  {if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
{*                                            <img src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 35px'>*}
                                            <img src="{$item['logo_transport']}" style='width : 35px'>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        {if $isInstallment !== false}
                                            <span class="installment-label">
                                                    اقساطی
                                                </span>
                                        {/if}
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
                    <a  class="btn-more--new" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/3">
                        نمایش تمام تورها
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
{*                    <a class="btn-more--new showMoreRecentTour" href="javascript:">*}
{*                        <span>*}
{*                        نمایش بیشتر*}
{*                        </span>*}
{*                        <i class="fa-solid fa-arrow-down"></i>*}
{*                    </a>*}
                </div>
            </div>
            <div class="tab-pane fade" id="pills-summer" role="tabpanel" aria-labelledby="pills-summer-tab">
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
                                    <i class="fa-light fa-globe icon_titr"></i>
                                    <span class="text_titr">حمل و نقل</span>
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
                    {foreach $summerTours as $item}
                        {assign var="tour_type_id" value=$item['tour_type_id']}
                        {assign var="isInstallment" value=strpos($tour_type_id, '"17"')}
                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="tour_body">
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
                                            <span class="font-weight-bold">  {if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
                                            <img src="{$item['logo_transport']}" style='width : 35px'>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        {if $isInstallment !== false}
                                            <span class="installment-label">
                                                    اقساطی
                                                </span>
                                        {/if}
                                        <div class="parent_item">
                                     <span class="Money_color font-weight-bold">
                                         <i class="fa-light fa-sack-dollar"></i>

                                          {if $item['min_price_r'] != 0}
                                              {$item['min_price_r']|number_format} ریال
                                          {/if}
                                         {if  $item['min_price_r'] != 0 &&  $item['min_price_a'] &&  $item['min_price_a'] != 0} + {/if}
                                         {if $item['min_price_a'] &&  $item['min_price_a'] != 0}

                                             {$item['min_price_a']|number_format} {$item['currency_type']}
                                         {/if}

                                    </span>
                                        </div>
                                        <i class="fa-solid fa-caret-left arrow_after"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    {/foreach}
                    <a  class="btn-more--new" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                        نمایش تمام تورها
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
{*                    <a class="btn-more--new showMoreRecentTour" href="javascript:">*}
{*                        <span>*}
{*                        نمایش بیشتر*}
{*                        </span>*}
{*                        <i class="fa-solid fa-arrow-down"></i>*}
{*                    </a>*}
                </div>
            </div>
            <div class="tab-pane fade" id="pills-last-minute" role="tabpanel" aria-labelledby="pills-last-minute-tab">
                <div class="tour-list-component">
                    <div class="tours_titr">
                        <div class="d-flex flex-wrap w-100">
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-pen-to-square icon_titr"></i>
                                    <span class="text_titr">عنوان تور</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-calendar"></i>
                                    <span class="text_titr">تاریخ حرکت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-bed-front icon_titr"></i>
                                    <span class="text_titr">مدت اقامت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-globe icon_titr"></i>
                                    <span class="text_titr">حمل و نقل</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-coins icon_titr"></i>
                                    <span class="text_titr">قیمت</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="respancive_flex">
                    {foreach $recentTours as $item}
                        {assign var="tour_type_id" value=$item['tour_type_id']}
                        {assign var="isInstallment" value=strpos($tour_type_id, '"17"')}
                        <div class="tour-list-body">
                            <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                <div class="d-flex flex-wrap w-100 h-100%">
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-location-dot"></i>
                                            <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                            <i class="fa-light fa-person-walking-luggage person-icon-recent-tour"></i>
                                            <span class="font-weight-bold hover_titel">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="d-flex parent_item">
                                            <i class="fa-light fa-moon"></i>
                                            <span class="font-weight-bold">  {if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                        <div class="parent_item">
                                    <span>
{*                                            <img src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 35px'>*}
                                            <img src="{$item['logo_transport']}" style='width : 35px'>
                                            {$item['airline_name']}
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                        {if $isInstallment !== false}
                                            <span class="installment-label">
                                                    اقساطی
                                                </span>
                                        {/if}
                                        <div class="parent_item">
                                     <span class="Money_color font-weight-bold">
                                         <i class="fa-light fa-sack-dollar"></i>
                                        {$item['min_price_r']|number_format}
                                         <span class="text_toman">ریال</span>
                                    </span>
                                        </div>
                                        <i class="fa-solid fa-caret-left arrow_after"></i>
                                    </div>
                                </div>                            </a>
                        </div>
                    {/foreach}
                    <a  class="btn-more--new" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/6">
                        نمایش تمام تورها
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
{*                    <a class="btn-more--new showMoreRecentTour" href="javascript:">*}
{*                        <span>*}
{*                        نمایش بیشتر*}
{*                        </span>*}
{*                        <i class="fa-solid fa-arrow-down"></i>*}
{*                    </a>*}
                </div>
            </div>
            <div class="tab-pane fade" id="pills-installment-tour" role="tabpanel" aria-labelledby="pills-installment-tour-tab">
                <div class="tour-list-component">
                    <div class="tours_titr">
                        <div class="d-flex flex-wrap w-100">
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-pen-to-square icon_titr"></i>
                                    <span class="text_titr">عنوان تور</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-calendar"></i>
                                    <span class="text_titr">تاریخ حرکت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-bed-front icon_titr"></i>
                                    <span class="text_titr">مدت اقامت</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-globe icon_titr"></i>
                                    <span class="text_titr">حمل و نقل</span>
                                </div>
                            </div>
                            <div class="col border_my">
                                <div class="d-flex align-items-center">
                                    <i class="fa-light fa-coins icon_titr"></i>
                                    <span class="text_titr">قیمت</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="respancive_flex">
                    {foreach $installmentTours as $item}
                        {assign var="tour_type_id" value=$item['tour_type_id']}
                        {assign var="isInstallment" value=strpos($tour_type_id, '"17"')}

                            <div class="tour-list-body">
                                <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}" class="tour_body">
                                    <div class="d-flex flex-wrap w-100 h-100%">
                                        <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                            <div class="parent_item">
                                                <i class="fa-light fa-location-dot"></i>
                                                <span class="font-weight-bold hover_titel">{$item['tour_name']}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                            <div class="parent_item">
                                                <i class="fa-light fa-person-walking-luggage person-icon-recent-tour"></i>
                                                <span class="font-weight-bold hover_titel">
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                            </span>
                                            </div>
                                        </div>
                                        <div class="col-lg col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-start border_my padding_my">
                                            <div class="d-flex parent_item">
                                                <i class="fa-light fa-moon"></i>
                                                <span class="font-weight-bold">  {if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my">
                                            <div class="parent_item">
                                    <span>
{*                                            <img src="{$item['logo_transport']}" alt="{$item['airline_name']}" style='width : 35px'>*}
                                            <img src="{$item['logo_transport']}" style='width : 35px'>
                                            {$item['airline_name']}

                                    </span>
                                            </div>
                                        </div>
                                        <div class="col-lg col-md-12 col-sm-12 col-12 d-flex align-items-center justify-content-start border_my padding_my position-relative parent_after">
                                            {if $isInstallment !== false}
                                                <span class="installment-label">
                                                    اقساطی
                                                </span>
                                            {/if}
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
                    <a  class="btn-more--new" href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/all-all/all-all/all/17">
                        نمایش تمام تورها
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
{*                    <a class="btn-more--new showMoreRecentTour" href="javascript:">*}
{*                        <span>*}
{*                        نمایش بیشتر*}
{*                        </span>*}
{*                        <i class="fa-solid fa-arrow-down"></i>*}
{*                    </a>*}
                </div>
            </div>
        </div>
    </div>
</section>

{/if}