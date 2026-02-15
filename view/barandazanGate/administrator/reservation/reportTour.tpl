{load_presentation_object filename="reservationTour" assign="objResult"}
{load_presentation_object filename="tourSlugController" assign="objTourSlugController"}

{load_presentation_object filename="functions" assign="objFunctions"}
{load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}

{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="correctDate" value=$objDateTimeSetting->jdate("Y-m-d", '', '', '', 'en') }
{else}
    {assign var="correctDate" value=date("Y-m-d") }
{/if}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت تور رزرواسیون</li>
                <li class="active">گزارش تور</li>
            </ol>
        </div>
    </div>

    
    <div class="row">

        <div class="col-sm-12">
            <div class='parent-toast-notifications'>
                <div class='parent-icon-notifications'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                </div>
                <div class='parent-description-notifications'>
                    <h3>همکار محترم،</h3>
                    <h4>نرم‌افزار سفر 360 به امکانات جدیدی برای سئو مجهز شده است، از جمله:</h4>
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>افزودن Title و Description</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>استفاده از تگ h1</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>اتصال صفحات به یکدیگر</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>آدرس‌دهی دلخواه (Slug)</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>Canonical Link</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>ایجاد متن سؤالات دلخواه در صفحات</span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 256C320 344.4 248.4 416 160 416C71.63 416 0 344.4 0 256C0 167.6 71.63 96 160 96C248.4 96 320 167.6 320 256zM160 144C98.14 144 48 194.1 48 256C48 317.9 98.14 368 160 368C221.9 368 272 317.9 272 256C272 194.1 221.9 144 160 144z"/></svg>
                            <span>و...</span>
                        </li>
                    </ul>
                    <div class='parent-support'>
                        <p>برای اطلاع از چگونگی دسترسی به این امکانات، لطفاً با پشتیبانی ایران تکنولوژی تماس بگیرید.</p>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M375.8 275.2c-16.4-7-35.4-2.4-46.7 11.4l-33.2 40.6c-46-26.7-84.4-65.1-111.1-111.1L225.3 183c13.8-11.3 18.5-30.3 11.4-46.7l-48-112C181.2 6.7 162.3-3.1 143.6 .9l-112 24C13.2 28.8 0 45.1 0 64v0C0 295.2 175.2 485.6 400.1 509.5c9.8 1 19.6 1.8 29.6 2.2c0 0 0 0 0 0c0 0 .1 0 .1 0c6.1 .2 12.1 .4 18.2 .4l0 0c18.9 0 35.2-13.2 39.1-31.6l24-112c4-18.7-5.8-37.6-23.4-45.1l-112-48zM441.5 464C225.8 460.5 51.5 286.2 48.1 70.5l99.2-21.3 43 100.4L154.4 179c-18.2 14.9-22.9 40.8-11.1 61.2c30.9 53.3 75.3 97.7 128.6 128.6c20.4 11.8 46.3 7.1 61.2-11.1l29.4-35.9 100.4 43L441.5 464zM48 64v0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0s0 0 0 0"/></svg>
                            شماره تماس: 02188866609</span>
                    </div>
                </div>
            </div>
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش تور</h3>
                <p class="text-muted m-b-30">
                    <span class="pull-right" style="margin: 10px;">
                         <a href="archiveReportTour" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-eye"></i></span>آرشیو تورها
                        </a>
                    </span>
                </p>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ ایجاد</th>
                            <th>نوع کانتر<br>نام کانتر</th>
                            <th>نام تور<br>کد تور</th>
                            <th>شروع<br>پایان</th>
                            <th>چند شب<br>چند روز</th>
                            {*<th>نظر کاربران</th>*}
                            <th>وضعیت</th>
                            <th>نمایش در نامک</th>
{*                            <th>الویت</th>*}
                            {*<th>مشاهده</th>*}
                            <th>زمان شروع <br> فروش تور<br> لحظه آخری (روز)</th>
                            <th>تور ویژه</th>
                            <th>پیشنهادی</th>
                            <th>انتخاب تور زماندار</th>
                            <th>تعداد رزرو</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var=reportTour value=$objResult->reportTour(null,true)}
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$reportTour}
                            {assign var="slugAssignArray" value=[
                            'country_id' => $item['destination_country_id'],
                            'city_id' => $item['destination_city_id']
                            ]}

                            {assign var="citySlug" value=$objTourSlugController->reverse($slugAssignArray)}
                            {assign var="countrySlug" value=$objTourSlugController->reverse([
                            'country_id' => $item['destination_country_id'],
                            'city_id' =>'all'
                            ])}

                            {$number=$number+1}

                            {assign var="typeMember" value=$objFunctions->infoMember($item.user_id)}
                            {assign var="tourNameByLanguage" value=$item[$objFunctions->ChangeIndexNameByLanguage($item['language'],'tour_name')]}
                            {assign var="infoCounterType" value=$objFunctions->infoCounterType($typeMember['fk_counter_type_id'])}



                            <tr id="del-{$item['id']}">
                                <td id="borderFlyNumber-{$item['id']}">{$number}</td>

                                <td class='text-sm'>
                                    {$item['create_date_in']}
                                    <hr style="margin:3px">
                                    {$item['create_time_in']}
                                </td>

                                <td>
                                    {$infoCounterType['name']}
                                    <hr style="margin:3px">
                                    {$typeMember['name']} {$typeMember['family']}
                                </td>

                                <td>
                                    <a href="detailTour&id={$item['id_same']}">
                                        {$tourNameByLanguage}
                                    </a>
                                    <hr style="margin:3px">
                                    {$item['tour_code']}
                                </td>

                                <td class='text-sm'>
                                    {$objFunctions->convertDate($item['minDate'])}
                                    <hr style="margin:3px">
                                    {$objFunctions->convertDate($item['maxDate'])}
                                </td>

                                <td class='text-sm'>
                                    {$item['night']} شب
                                    <hr style="margin:3px">
                                    {$item['day']} روز
                                </td>

                                {*<td>
                                    <a href="userComments&id={$item['id_same']}&page=reservationTour" class="btn btn-info waves-effect waves-light" type="button">
                                        <span class="btn-label"><i class="fa fa-eye"></i></span>مشاهده نظر کاربران
                                    </a>
                                </td>*}

                                <td>
                                    {if $item['is_show'] eq ''}
                                        <span title='ثبت جدید تور' class='fa fa-info-circle bg-warning p-2 text-white rounded'></span>
                                    {elseif $item['is_show'] eq 'yes'}
                                        <span title='نمایش در سایت' class='fa fa-check bg-success p-2 text-white rounded'></span>
                                    {elseif $item['is_show'] eq 'no'}
                                        <span title='عدم نمایش در سایت' class='fa fa-trash bg-danger p-2 text-white rounded'></span>
                                    {/if}
                                    <br>
                                    <br>
                                    {if $objFunctions->convertDate($item['maxDate']) le $correctDate }
                                        <div class="btn-warning" style='font-size: 12px;'>##Expired##</div>
                                    {else}
                                        {if $item['is_show'] eq ''}
                                            <div class="btn-warning" style='font-size: 12px;'> ##Pending##</div>
                                        {elseif $item['is_show'] eq 'yes'}
                                            <div class="btn-success" style='font-size: 12px;'> ##Showinsite##</div>
                                        {elseif $item['is_show'] eq 'no'}
                                            <div class="btn-danger" style='font-size: 12px;'>##Disallowshowinssite##</div>
                                        {/if}
                                    {/if}
                                    <br>
                                    {if (isset($item['changeTourPrices']) && $item['changeTourPrices'] neq '')}
                                        <a href='changeTourPricesLogs&id={$item['id_same']}' class='btn btn-primary rounded'>
                                            مشاهده تغییرات قیمت
                                        </a>

                                    {/if}

                                </td>

                                <td class='text-sm'>
                                    {if isset($citySlug['slug_fa']) && isset($countrySlug['slug_fa'])}

                                    <a data-toggle="modal"
                                       data-target="#ModalPublic"
                                       onclick='ModalShowSlugs("{$countrySlug['id']}","{$countrySlug['self']}")'
                                          dir='ltr' title='{$objFunctions->urlTo("tours/`$countrySlug['slug_fa']`")}'>
                                        {$countrySlug['slug_fa']}
                                    </a>
                                    <hr>
                                    <span data-toggle="modal"
                                          data-target="#ModalPublic"
                                          onclick='ModalShowSlugs("{$citySlug['id']}","{$citySlug['self']}")'
                                          dir='ltr' title='{$objFunctions->urlTo("tours/`$citySlug['slug_fa']`")}'>
                                        {$citySlug['slug_fa']}
                                    </span>
                                    {/if}
                                </td>


{*                                <td class="text-align-center" onclick="EditInPlaceTour('{$item['id_same']}','{$item['priority']}')" id="{$item['id_same']}{$item['priority']}">*}
{*                                    {$item['priority']}*}
{*                                </td>*}

                                {*<td>
                                    <a href="detailTour&id={$item['id_same']}" class="btn btn-success waves-effect waves-light" type="button">
                                        <span class="btn-label"><i class="fa fa-eye"></i></span>مشاهده جزئیات کامل
                                    </a>
                                    {if $item['changeTourPrices'] neq ''}
                                        <br>
                                        <br>
                                        <a href="changeTourPricesLogs&id={$item['id_same']}" class="btn btn-block btn-outline btn-primary">مشاهده تغییرات قیمت</a>
                                    {/if}
                                </td>*}

                                <td>
                                    <input type="text" id="startTimeLastMinuteTour-{$item['id_same']}"
                                           class='p-0 form-control rounded text-center'
                                           style='width: 40px;'
                                           name="startTimeLastMinuteTour-{$item['id_same']}"
                                           value="{if isset($item['start_time_last_minute_tour'])}{$item['start_time_last_minute_tour']}{/if}"
                                           placeholder="--"
                                           onchange="setStartTimeLastMinuteTour('{$item['id_same']}');">
                                </td>

                                <td>
                                    <a onclick="isSpecialTour('{$item['id_same']}'); return false;">
                                        {if $item['is_special'] eq 'yes'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>

                                <td>

                                    <a onclick="changeSuggestedStatus('{$item['id_same']}'); return false;">
                                        {if $item['suggested'] eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>

                                <td>
                                    <a onclick="isFirstTour('{$item['id_same']}'); return false;">
                                        {if (isset($item['is_first'])) && $item['is_first'] eq 'yes'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683" data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                    {if $item['discount'] gt 0 && $item['discount_type'] eq 'price'}
                                        <br><br><b>{$item['discount']} ریال</b><b> تخفیف </b>
                                    {elseif $item['discount'] gt 0 && $item['discount_type'] eq 'percent'}
                                        <br><br><b>{$item['discount']} %</b><b> تخفیف </b>
                                    {/if}
                                </td>


                                <td data-content="##countReserve##">
                                    <div class="reserve-count-wrapper">
                                        <button class="reserve-count-btn" onclick="modalListForReserveTour('{$item['tour_code']}');">
                                            <span class="reserve-icon">👥</span>
                                            <span class="reserve-number">{$objResult->getTourBookingCountPanel($item['tour_code'])}</span>
                                            <span class="reserve-text">رزرو</span>
                                        </button>
                                    </div>
                                </td>

                                <style>
                                    .reserve-count-wrapper {
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                        padding: 5px;
                                    }

                                    .reserve-count-btn {
                                        display: flex;
                                        flex-direction: column;
                                        align-items: center;
                                        justify-content: center;
                                        background: linear-gradient(135deg, #f73d54  0%, #f03c52  100%);
                                        border: none;
                                        border-radius: 10px;
                                        padding: 10px 12px;
                                        color: white;
                                        cursor: pointer;
                                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                                        box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3);
                                        min-width: 75px;
                                        position: relative;
                                        overflow: hidden;
                                        font-family: 'Vazir', 'Segoe UI', sans-serif;
                                    }

                                    .reserve-count-btn:hover {
                                        transform: translateY(-2px);
                                        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
                                        background: linear-gradient(135deg, #f03c52  0%, #f73d54  100%);
                                    }

                                    .reserve-count-btn:active {
                                        transform: translateY(0);
                                        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
                                    }

                                    .reserve-icon {
                                        font-size: 16px;
                                        margin-bottom: 3px;
                                        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));
                                        transition: transform 0.3s ease;
                                    }

                                    .reserve-count-btn:hover .reserve-icon {
                                        transform: scale(1.1);
                                    }

                                    .reserve-number {
                                        font-size: 16px;
                                        font-weight: bold;
                                        margin-bottom: 1px;
                                        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
                                        font-family: 'Courier New', monospace;
                                    }

                                    .reserve-text {
                                        font-size: 10px;
                                        opacity: 0.9;
                                        font-weight: 500;
                                        letter-spacing: -0.2px;
                                    }

                                    /* افکت‌های مدرن */
                                    .reserve-count-btn::before {
                                        content: '';
                                        position: absolute;
                                        top: -50%;
                                        left: -50%;
                                        width: 200%;
                                        height: 200%;
                                        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
                                        transform: rotate(45deg);
                                        transition: all 0.6s ease;
                                        opacity: 0;
                                    }

                                    .reserve-count-btn:hover::before {
                                        opacity: 1;
                                        animation: shimmer 1.5s ease;
                                    }

                                    @keyframes shimmer {
                                        0% {
                                            transform: translateX(-100%) translateY(-100%) rotate(45deg);
                                        }
                                        100% {
                                            transform: translateX(100%) translateY(100%) rotate(45deg);
                                        }
                                    }

                                    /* استایل برای حالت‌های مختلف تعداد */
                                    .reserve-count-btn.low-count {
                                        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
                                        box-shadow: 0 3px 12px rgba(255, 107, 107, 0.3);
                                    }

                                    .reserve-count-btn.medium-count {
                                        background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%);
                                        box-shadow: 0 3px 12px rgba(255, 167, 38, 0.3);
                                    }

                                    .reserve-count-btn.high-count {
                                        background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%);
                                        box-shadow: 0 3px 12px rgba(76, 175, 80, 0.3);
                                    }

                                    /* استایل‌های ریسپانسیو */
                                    @media (max-width: 1200px) {
                                        .reserve-count-btn {
                                            padding: 8px 10px;
                                            min-width: 70px;
                                        }

                                        .reserve-number {
                                            font-size: 15px;
                                        }

                                        .reserve-text {
                                            font-size: 9px;
                                        }
                                    }

                                    @media (max-width: 768px) {
                                        .reserve-count-wrapper {
                                            padding: 3px;
                                        }

                                        .reserve-count-btn {
                                            padding: 6px 8px;
                                            min-width: 65px;
                                            border-radius: 8px;
                                        }

                                        .reserve-number {
                                            font-size: 14px;
                                        }

                                        .reserve-icon {
                                            font-size: 14px;
                                            margin-bottom: 2px;
                                        }

                                        .reserve-text {
                                            font-size: 8px;
                                        }
                                    }

                                    @media (max-width: 480px) {
                                        .reserve-count-btn {
                                            padding: 5px 6px;
                                            min-width: 60px;
                                        }

                                        .reserve-number {
                                            font-size: 13px;
                                        }

                                        .reserve-text {
                                            font-size: 7px;
                                        }
                                    }





                                    </style>





                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="ModalPublic" class="modal">
            <div class="modal-content" id="ModalPublicShowReserveList"></div>
        </div>
    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش گزارش تور   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/389/-.html" target="_blank" class="i-btn"></a>

</div>

<script type="text/javascript" src="assets/JsFiles/reservationTour.js"></script>
<script type="text/javascript" src="assets/JsFiles/routeFlight.js"></script>