{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="noroz_tours_params" value=['type'=>'','dateNow' => $dateNow,'category' => '6']}
{assign var='toursNorozy' value=$obj_main_page->getToursReservation($noroz_tours_params)}


{assign var="langVar" value=""}
{assign var="priceVar" value="_r"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="_en"}
    {assign var="priceVar" value="_a"}
{/if}


{if $toursNorozy}
    <section class="i_modular_tours tour">
        <div class="container">
            <div class="title">
                <div class="box-right">
                    <svg class="svg-title svg-title-2" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                        <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                        <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                    </svg>
                    <div class="text-title">
                    <h3>تور های نوروزی</h3>
                    </div>
                </div>
                <a href="{$smarty.const.ROOT_ADDRESS}/page/tour" class="more-title">
                    مشاهده بیشتر
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>
            <div class="tab-content mt-4" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="__tour__internal__ tour_main">
                        {foreach $toursNorozy as $item}
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="__i_modular_nc_item_class_0 tour_box">
                            <img class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                            <div>
                                <h6 class="__title_class__">{$item["tour_name$langVar"]}</h6>
                                <span><span class="__night_class__">{$item["night"]}</span> شب</span>
                            </div>
                        </a>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}