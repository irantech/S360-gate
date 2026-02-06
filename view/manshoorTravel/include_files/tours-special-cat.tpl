
{assign var="internal_tour_farhangi_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'internal','category' => '23']}
{assign var="internal_tour_tafrihi_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'internal','category' => '24']}
{assign var="internal_tour_ziarati_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'internal','category' => '25']}
{assign var="internal_tour_norozi_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'internal','category' => '38']}

{assign var='tour_internal_farhangi' value=$obj_main_page->getToursReservation($internal_tour_farhangi_params)}
{assign var='tour_internal_tafrihi' value=$obj_main_page->getToursReservation($internal_tour_tafrihi_params)}
{assign var='tour_internal_ziarati' value=$obj_main_page->getToursReservation($internal_tour_ziarati_params)}
{assign var='tour_internal_norozi' value=$obj_main_page->getToursReservation($internal_tour_norozi_params)}

{assign var="external_tour_farhangi_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'external','category' => '23']}
{assign var="external_tour_tafrihi_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'external','category' => '24']}
{assign var="external_tour_ziarati_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'external','category' => '25']}
{assign var="external_tour_norozi_params" value=['type'=>'','limit'=> '100','dateNow' => $dateNow, 'country' =>'external','category' => '38']}

{assign var='tour_external_farhangi' value=$obj_main_page->getToursReservation($external_tour_farhangi_params)}
{assign var='tour_external_tafrihi' value=$obj_main_page->getToursReservation($external_tour_tafrihi_params)}
{assign var='tour_external_ziarati' value=$obj_main_page->getToursReservation($external_tour_ziarati_params)}
{assign var='tour_external_norozi' value=$obj_main_page->getToursReservation($external_tour_norozi_params)}

<section class="tourSpecial">
    <div class="tour_main container">
        <h2 class="title">دسته بندی تور های خاص</h2>
        <nav class="mt-4">
            <div class="nav nav-tabs mb-2" id="nav-tab2" role="tablist">
                <a aria-controls="tour_kh" aria-selected="true" class="nav-link mask active" data-toggle="tab" href="#tour_d" id="tour_d_btn" role="tab"> داخلی </a>
                <a aria-controls="tour_kh" aria-selected="false" class="nav-link mask" data-toggle="tab" href="#tour_kh" id="tour_kh_btn" role="tab"> خارجی </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent2">
            <div aria-labelledby="nav-home-tab" class="tab-pane fade show active" id="tour_d" role="tabpanel">
                <nav>
                    <div class="nav nav-tabs" id="tour_d_tab" role="tablist">
                        <a aria-controls="nav-home" aria-selected="false" class="nav-link active mask" data-toggle="tab" href="#tour_d_tab_4" id="tour_d_tab_btn_4" role="tab"> نوروزی </a>
                        <a aria-controls="nav-home" aria-selected="false" class="nav-link mask" data-toggle="tab" href="#tour_d_tab_1" id="tour_d_tab_btn_1" role="tab"> فرهنگی </a>
                        <a aria-controls="nav-profile" aria-selected="true" class="nav-link mask" data-toggle="tab" href="#tour_d_tab_2" id="tour_d_tab_btn_2" role="tab"> تفریحی </a>
                        <a aria-controls="nav-profile2" aria-selected="false" class="nav-link mask" data-toggle="tab" href="#tour_d_tab_3" id="tour_d_tab_btn_3" role="tab"> زیارتی </a>
                    </div>
                </nav>
                <div class="tab-content" id="tour_d_tabContent">


                    <div aria-labelledby="nav-home-tab" class="tab-pane fade" id="tour_d_tab_1" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_internal_farhangi as $item}
                            <div class="item">
                                <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                    <div class="mask mask-hexagon img-tour-special">
                                        <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                    </div>
                                    <article class="parent-body-tour">
                                        <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                        <div class="calculator">
                                            <span>اعتبار تور </span>
                                            <span>
                                                 {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                            </span>
                                        </div>
                                        <h6> {$item['tour_name']} </h6>
                                        <button class="btn-more">جزئیات </button>
                                    </article>
                                </a>
                            </div>
                            {/foreach}


                        </div>
                    </div>


                    <div aria-labelledby="nav-profile-tab" class="tab-pane fade" id="tour_d_tab_2" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_internal_tafrihi as $item}
                            <div class="item">
                                <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                    <div class="mask mask-hexagon img-tour-special">
                                        <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                    </div>
                                    <article class="parent-body-tour">
                                        <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                        <div class="calculator">
                                            <span>اعتبار تور </span>
                                            <span>
                                                {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                {assign var="day" value=substr($item['start_date'], 6)}
                                                {$year}/{$month}/{$day}
                                            </span>
                                        </div>
                                        <h6> {$item['tour_name']} </h6>
                                        <button class="btn-more">جزئیات </button>
                                    </article>
                                </a>
                            </div>
                            {/foreach}
                        </div>
                    </div>
                    <div aria-labelledby="nav-profile2-tab" class="tab-pane fade" id="tour_d_tab_3" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_internal_ziarati as $item}
                                <div class="item">
                                    <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="mask mask-hexagon img-tour-special">
                                            <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <article class="parent-body-tour">
                                            <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                            <div class="calculator">
                                                <span>اعتبار تور </span>
                                                <span>
                                                 {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                            </span>
                                            </div>
                                            <h6> {$item['tour_name']} </h6>
                                            <button class="btn-more">جزئیات </button>
                                        </article>
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                    <div aria-labelledby="nav-profile3-tab" class="tab-pane fade show active" id="tour_d_tab_4" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_internal_norozi as $item}
                                <div class="item">
                                    <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="mask mask-hexagon img-tour-special">
                                            <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <article class="parent-body-tour">
                                            <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                            <div class="calculator">
                                                <span>اعتبار تور </span>
                                                <span>
                                                 {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                            </span>
                                            </div>
                                            <h6> {$item['tour_name']} </h6>
                                            <button class="btn-more">جزئیات </button>
                                        </article>
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
            <div aria-labelledby="tour_kh" class="tab-pane fade" id="tour_kh" role="tabpanel">
                <nav>
                    <div class="nav nav-tabs" id="tour_kh_tab" role="tablist">
                        <a aria-controls="nav-home" aria-selected="false" class="nav-link active mask" data-toggle="tab" href="#tour_kh_tab_4" id="tour_kh_tab_btn_4" role="tab"> نوروزی </a>
                        <a aria-controls="nav-home" aria-selected="false" class="nav-link mask" data-toggle="tab" href="#tour_kh_tab_1" id="tour_kh_tab_btn_1" role="tab"> فرهنگی </a>
                        <a aria-controls="nav-profile" aria-selected="true" class="nav-link mask" data-toggle="tab" href="#tour_kh_tab_2" id="tour_kh_tab_btn_2" role="tab"> تفریحی </a>
                        <a aria-controls="nav-profile2" aria-selected="false" class="nav-link mask" data-toggle="tab" href="#tour_kh_tab_3" id="tour_kh_tab_btn_3" role="tab"> زیارتی </a>
                    </div>
                </nav>
                <div class="tab-content" id="tour_kh_tabContent">
                    <div aria-labelledby="nav-home-tab" class="tab-pane fade" id="tour_kh_tab_1" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_external_farhangi as $item}
                                <div class="item">
                                    <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="mask mask-hexagon img-tour-special">
                                            <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <article class="parent-body-tour">
                                            <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                            <div class="calculator">
                                                <span>اعتبار تور </span>
                                                <span>
                                                 {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                            </span>
                                            </div>
                                            <h6> {$item['tour_name']} </h6>
                                            <button class="btn-more">جزئیات </button>
                                        </article>
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                    <div aria-labelledby="nav-profile-tab" class="tab-pane fade" id="tour_kh_tab_2" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_external_tafrihi as $item}
                                <div class="item">
                                    <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="mask mask-hexagon img-tour-special">
                                            <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <article class="parent-body-tour">
                                            <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                            <div class="calculator">
                                                <span>اعتبار تور </span>
                                                <span>
                                                 {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                            </span>
                                            </div>
                                            <h6> {$item['tour_name']} </h6>
                                            <button class="btn-more">جزئیات </button>
                                        </article>
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                    <div aria-labelledby="nav-profile2-tab" class="tab-pane fade" id="tour_kh_tab_3" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_external_ziarati as $item}
                                <div class="item">
                                    <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="mask mask-hexagon img-tour-special">
                                            <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <article class="parent-body-tour">
                                            <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                            <div class="calculator">
                                                <span>اعتبار تور </span>
                                                <span>
                                                 {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                            </span>
                                            </div>
                                            <h6> {$item['tour_name']} </h6>
                                            <button class="btn-more">جزئیات </button>
                                        </article>
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                    <div aria-labelledby="nav-profile3-tab" class="tab-pane fade show active" id="tour_kh_tab_4" role="tabpanel">
                        <div class="tourSpecialS owl-carousel owl-theme">
                            {foreach $tour_external_norozi as $item}
                                <div class="item">
                                    <a class="d-flex align-items-center justify-content-between flex-column" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id_same']}/{$item['tour_slug']}">
                                        <div class="mask mask-hexagon img-tour-special">
                                            <img alt="{$item['tour_name']}" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                        </div>
                                        <article class="parent-body-tour">
                                            <div class="money">  قیمت  <span>{$item['min_price']['discountedMinPriceR']|number_format}</span> ریال</div>
                                            <div class="calculator">
                                                <span>اعتبار تور </span>
                                                <span>
                                                 {assign var="year" value=substr($item['start_date'], 0, 4)}
                                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                                    {assign var="day" value=substr($item['start_date'], 6)}
                                                    {$year}/{$month}/{$day}
                                            </span>
                                            </div>
                                            <h6> {$item['tour_name']} </h6>
                                            <button class="btn-more">جزئیات </button>
                                        </article>
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>