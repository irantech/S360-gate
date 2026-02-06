{assign var="tour_params1" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'','category' => '3']}
{assign var="tour_params2" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'','category' => '4']}
{assign var="tour_params3" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'','category' => '5']}
{assign var="tour_params4" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'','category' => '6']}
{assign var="tour_params5" value=['type'=>'','limit'=> '6','dateNow' => $dateNow, 'country' =>'','category' => '7']}

{assign var='tour_cat_1' value=$obj_main_page->getToursReservation($tour_params1)}
{assign var='tour_cat_2' value=$obj_main_page->getToursReservation($tour_params2)}
{assign var='tour_cat_3' value=$obj_main_page->getToursReservation($tour_params3)}
{assign var='tour_cat_4' value=$obj_main_page->getToursReservation($tour_params4)}
{assign var='tour_cat_5' value=$obj_main_page->getToursReservation($tour_params5)}

{if $tour_cat_1 || $tour_cat_2 || $tour_cat_3 || $tour_cat_4 || $tour_cat_5}
    {assign var='check_general' value=true}
{/if}

{if $check_general}
    <section class="i_modular_tours tour_category py-5">
        <div class="container">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 class="title">خدمات فلای ایرتور</h2>
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button aria-controls="pills-home" aria-selected="true" class="nav-link active" data-target="#pills-home" data-toggle="pill" id="pills-home-tab" role="tab" type="button">
                            سفرهای لوکس
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button aria-controls="pills-profile" aria-selected="false" class="nav-link" data-target="#pills-profile" data-toggle="pill" id="pills-profile-tab" role="tab" type="button">
                            سفرهای ماجراجویانه
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button aria-controls="pills-profile-2" aria-selected="false" class="nav-link" data-target="#pills-profile-2" data-toggle="pill" id="pills-profile-2-tab" role="tab" type="button">
                            مسافرت انفرادی
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button aria-controls="pills-profile-3" aria-selected="false" class="nav-link" data-target="#pills-profile-3" data-toggle="pill" id="pills-profile-3-tab" role="tab" type="button">
                            مناسب برای خانواده
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button aria-controls="pills-profile-4" aria-selected="false" class="nav-link" data-target="#pills-profile-4" data-toggle="pill" id="pills-profile-4-tab" role="tab" type="button">
                            دیگر خدمات
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-4" id="pills-tabContent">
                <div aria-labelledby="pills-home-tab" class="__tour__ tab-pane fade show active" id="pills-home" role="tabpanel">
                    <div class="news_grid">
                        {foreach $tour_cat_1 as $item}
                                <a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                    <div class="imgBox">
                                        <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                    </div>
                                    <div class="news_txt">
                                        <div class="news_txt_header">
                                            <h2 class="__title_class__">{$item['tour_name']}</h2>
                                        </div>
                                        <div class="news_txt_footer">
                                            <h5>{$item['night']} شب</h5>
                                        </div>
                                    </div>
                                </a>
                        {/foreach}
                    </div>
                </div>

                <div aria-labelledby="pills-profile-tab" class="__tour__ tab-pane fade" id="pills-profile" role="tabpanel">
                    <div class="news_grid">

                        {foreach $tour_cat_2 as $item}

                                <a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                    <div class="imgBox">
                                        <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                    </div>
                                    <div class="news_txt">
                                        <div class="news_txt_header">
                                            <h2 class="__title_class__">{$item['tour_name']}</h2>
                                        </div>
                                        <div class="news_txt_footer">
                                            <h5>{$item['night']} شب</h5>
                                        </div>
                                    </div>
                                </a>


                        {/foreach}



                    </div>
                </div>

                <div aria-labelledby="pills-profile-2-tab" class="__tour__ tab-pane fade" id="pills-profile-2" role="tabpanel">
                    <div class="news_grid">
                        {foreach $tour_cat_3 as $item}
                                <a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                    <div class="imgBox">
                                        <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                    </div>
                                    <div class="news_txt">
                                        <div class="news_txt_header">
                                            <h2 class="__title_class__">{$item['tour_name']}</h2>
                                        </div>
                                        <div class="news_txt_footer">
                                            <h5>{$item['night']} شب</h5>
                                        </div>
                                    </div>
                                </a>
                        {/foreach}
                    </div>
                </div>

                <div aria-labelledby="pills-profile-3-tab" class="__tour__ tab-pane fade" id="pills-profile-3" role="tabpanel">
                    <div class="news_grid">
                        {foreach $tour_cat_4 as $item}
                                <a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                    <div class="imgBox">
                                        <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                    </div>
                                    <div class="news_txt">
                                        <div class="news_txt_header">
                                            <h2 class="__title_class__">{$item['tour_name']}</h2>
                                        </div>
                                        <div class="news_txt_footer">
                                            <h5>{$item['night']} شب</h5>
                                        </div>
                                    </div>
                                </a>
                        {/foreach}
                    </div>
                </div>

                <div aria-labelledby="pills-profile-4-tab" class="__tour__ tab-pane fade" id="pills-profile-4" role="tabpanel">
                    <div class="news_grid">
                        {foreach $tour_cat_5 as $item}

                                <a class="__i_modular_nc_item_class_0" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                                    <div class="imgBox">
                                        <img alt="{$item['tour_name']}" class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}"/>
                                    </div>
                                    <div class="news_txt">
                                        <div class="news_txt_header">
                                            <h2 class="__title_class__">{$item['tour_name']}</h2>
                                        </div>
                                        <div class="news_txt_footer">
                                            <h5>{$item['night']} شب</h5>
                                        </div>
                                    </div>
                                </a>


                        {/foreach}



                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
