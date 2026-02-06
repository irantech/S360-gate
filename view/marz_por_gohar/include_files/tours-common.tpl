{assign var='reservationTourCities' value=$obj_main_page->getReservationTourCities()}
{assign var='reservationTourExternalCities' value=$obj_main_page->getReservationTourCities('external')}

{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="noroz_tours_params" value=['type'=>'special','limit'=> '40','dateNow' => $dateNow]}
{assign var='toursNorozy' value=$obj_main_page->getToursReservation($noroz_tours_params)}
{if $reservationTourCities || $reservationTourExternalCities || $toursNorozy}
<section class="tour">
    <div class="container">
        <div class="title">
            <div class="box-right">
                <svg class="svg-title svg-title-2" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                    <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                    <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                </svg>
                <div class="text-title">
                    <h3>نمایش تور ها</h3>
                    <span>مشاهده مناسب ترین تورهای داخلی و خارجی</span>
                </div>
            </div>
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">تور خارجی</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">تور داخلی</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="pills-noroz-tab" data-toggle="pill" data-target="#pills-noroz" type="button" role="tab" aria-controls="pills-noroz" aria-selected="true">تورهای ویژه</button>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="parent-tour-item">
                    {foreach $reservationTourCities as $key => $tourCountry}
                        <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/1-{$tourCountry['id']}/all/all" class="item-tour">
                        <div class="img-tour">
                            {if $tourCountry['tour_pic']}
                                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tourCountry['tour_pic']}" alt="{$tourCountry['name']}">
                            {else}
                                <img src="project_files/images/nophoto.png">
                            {/if}
                            <div class="img-tour-hover">
                                <i class="fa-regular fa-link"></i>
                                <span>مشاهده جزئیات</span>
                            </div>
                        </div>
                        <div class="text-tour">
                            <h6>   {$tourCountry['name']}</h6>
                        </div>
                    </a>
                    {/foreach}
                </div>
            </div>
            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="parent-tour-item">
                    {foreach $reservationTourExternalCities as $key => $tourCountry}
                         <a href="{$smarty.const.ROOT_ADDRESS}/resultTourLocal/1-all/{$tourCountry['id_country']}-{$tourCountry['id']}/all/all" class="item-tour">
                            <div class="img-tour">
                                {if $tourCountry['tour_pic']}
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$tourCountry['tour_pic']}" alt="{$tourCountry['name']}">
                                {else}
                                    <img src="project_files/images/nophoto.png">
                                {/if}
                                <div class="img-tour-hover">
                                    <i class="fa-regular fa-link"></i>
                                    <span>مشاهده جزئیات</span>
                                </div>
                            </div>
                            <div class="text-tour">
                                <h6>   {$tourCountry['name']}</h6>
                            </div>
                        </a>
                    {/foreach}
                </div>
            </div>

            <div class="tab-pane fade " id="pills-noroz" role="tabpanel" aria-labelledby="pills-noroz-tab">
                <div class="parent-tour-item">
                    {foreach $toursNorozy as $item}
                        <a href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}" class="item-tour">
                            <div class="img-tour">
                                {if $item['tour_pic']}
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" alt="{$item['tour_name']}">
                                {else}
                                    <img src="project_files/images/nophoto.png">
                                {/if}
                                <div class="img-tour-hover">
                                    <i class="fa-regular fa-link"></i>
                                    <span>مشاهده جزئیات</span>
                                </div>
                            </div>
                            <div class="text-tour">
                                <h6>  {$item['tour_name']}</h6>
                            </div>
                        </a>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
</section>
{/if}
