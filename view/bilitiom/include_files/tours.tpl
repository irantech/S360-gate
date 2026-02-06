
{assign var=dateNow value=dateTimeSetting::jdate("Ymd", "", "", "", "en")}
{assign var="noroz_tours_params" value=['type'=>'','limit'=> '15','dateNow' => $dateNow,'category' => '14']}
{assign var='norozyTours' value=$obj_main_page->getToursReservation($noroz_tours_params)}



    <section class="i_modular_tours tour-noruzi">
        <div class="container">
            <div class="title-safiran">
                <div class="text-title-safiran">
                    <div class="parent-svg-title">
                        <svg height="" viewbox="0 0 48 48" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M26.8113 29.9347C26.9242 29.8266 27.0464 29.7076 27.1767 29.5783C28.0261 28.7354 29.1458 27.5282 30.2522 26.1142C32.6323 23.0723 34.2777 19.9187 34.2777 17.5832C34.2777 12.6033 30.9933 8.39052 26.4726 6.99277L20.6601 6.79108C15.7603 7.93726 12.1113 12.3341 12.1113 17.5832C12.1113 18.6325 12.4726 19.9708 13.2565 21.5485C14.0265 23.0981 15.0944 24.6598 16.2318 26.0915C17.3608 27.5125 18.4998 28.7324 19.36 29.5989C19.4783 29.7181 19.5909 29.8302 19.6969 29.9347H20.9792C24.6229 29.9347 23.5811 29.9347 25.8135 29.9347H26.8113ZM25.8135 29.9347H20.9792C20.2514 28.8735 19.5335 27.7208 18.8851 26.5204C17.3879 23.749 16.1312 20.4879 16.1977 17.4175C16.2935 12.9986 18.0337 9.58219 20.6601 6.79108L26.4726 6.99277C25.7484 7.43513 25.0683 7.94802 24.4419 8.52284C21.7705 10.974 20.1667 13.7636 20.0856 17.5053C20.0409 19.5681 20.9209 22.11 22.3062 24.6744C23.3699 26.6436 24.6559 28.4879 25.8135 29.9347ZM28.2375 33.8236H18.1515C18.1515 33.8236 8.22241 25.0692 8.22241 17.5832C8.22241 9.31431 14.9256 2.61108 23.1945 2.61108C31.4633 2.61108 38.1666 9.31431 38.1666 17.5832C38.1666 25.0692 28.5386 33.8236 28.2375 33.8236Z"
                                  fill-rule="evenodd"></path>
                            <path d="M25.8135 29.9347H20.9792C24.6229 29.9347 23.5811 29.9347 25.8135 29.9347Z"></path>
                            <path d="M16.7779 37.8056C16.7779 37.2687 17.2132 36.8334 17.7501 36.8334H28.6389C29.1758 36.8334 29.6111 37.2687 29.6111 37.8056V42.4722C29.6111 44.083 28.3053 45.3889 26.6944 45.3889H19.6946C18.0837 45.3889 16.7779 44.083 16.7779 42.4722V37.8056Z"></path>
                        </svg>
                        <h2>تورهای نوروزی 1404 بیلیتیوم </h2>
                    </div>
                    <p>با بیلیتیوم، سفری به یادماندنی را در سال ۱۴۰۴ تجربه کنید</p>
                </div>
                <a class="more-title-safiran" href="{$smarty.const.ROOT_ADDRESS}/page/tour">
                    <span>بیشتر</span>
                    <svg viewbox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">
                        <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M234.8 36.25c3.438 3.141 5.156 7.438 5.156 11.75c0 3.891-1.406 7.781-4.25 10.86L53.77 256l181.1 197.1c6 6.5 5.625 16.64-.9062 22.61c-6.5 6-16.59 5.594-22.59-.8906l-192-208c-5.688-6.156-5.688-15.56 0-21.72l192-208C218.2 30.66 228.3 30.25 234.8 36.25z"></path>
                    </svg>
                </a>
            </div>
            <div class="__tour__category__ owl-carousel owl-theme owl-tour-safiran">
                {foreach $norozyTours as $item}
                <div class="__i_modular_nc_item_class_0 item">
                    <a class="tourMain_a" href="{$smarty.const.ROOT_ADDRESS}/detailTour/{$item['id']}/{$item['tour_slug']}">
                        <img alt='{$item["alt"]}' class="__image_class__" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['tour_pic']}" />
                        <div>
                            <h2 class="__title_class__">{$item['tour_name']}</h2>
                            <span>
                                <i class="far fa-moon-stars"></i>
                                مدت تور :
                                <span class="__night_class__">{if $item['night'] eq '0'}بدون اقامت{else}{$item['night']} شب {/if}</span>
                            </span>
                            <span>
                                <i class="far fa-calendar-range"></i>
                                تاریخ حرکت :
                                <span class="__date_class__">
                                    {assign var="year" value=substr($item['start_date'], 0, 4)}
                                    {assign var="month" value=substr($item['start_date'], 4, 2)}
                                    {assign var="day" value=substr($item['start_date'], 6)}
                                    {$year}/{$month}/{$day}
                                </span>
                            </span>
                            <div class="___price_class__">{$item['min_price']['discountedMinPriceR']|number_format}  ریال</div>
                        </div>
                    </a>
                </div>
                {/foreach}

            </div>
        </div>
    </section>
