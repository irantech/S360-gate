<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css" />
<link rel='stylesheet' href='assets/modules/css/mag.css'>

<link rel='stylesheet' href='assets/css/galleryTour/style.css'>
<link rel='stylesheet' href='assets/css/galleryTour/mBox.css'>

{load_presentation_object filename="resultTourLocal" assign="objResult"}

{load_presentation_object filename="reservationTour" assign="objReservetionTour"}
{load_presentation_object filename="comments" assign="objComments"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="dateTimeSetting" assign="dateTimeSetting"}
{load_presentation_object filename="members" assign="objMembers"}
{assign var="showTourToman" value = $objFunctions->isEnableSetting('toman')}
{if $showTourToman}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('toman')}
{else}
    {assign var="iranCurrency" value=$objFunctions->Xmlinformation('Rial')}
{/if}

{assign var="user_info" value=$objMembers->getMember()}
{*{$objResult->getInfoTourByIdTour($smarty.const.TOUR_ID)}*}
{$objResult->getInfoTourByIdSameTour($smarty.const.TOUR_ID_SAME)}

{assign var="sessionid" value=$objSession->getUserId()}
{assign var="allComments" value=$objComments->getComments('tour',$objResult->arrayTour['infoTour']['id_same'])}
{if $objResult->arrayTour['is_api'] eq true}
    {assign var="tourRouteData" value=$objResult->arrayTour['tour_routes']}
{else}
    {assign var="tourRouteData" value=$objReservetionTour->getTourRouteData($objResult->arrayTour['infoTour']['id'])}
{/if}


{if !empty($sessionid)}
    {load_presentation_object filename="user" assign="objUser"}
    {assign var="profile" value=$objUser->getProfile({$objSession->getUserId()})}
{/if}

<!-- login and register popup -->
{assign var="useType" value="tour"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->

{assign var="tourTypeIdArray" value=$objResult->arrayTour['infoTour']['tour_type_id']|json_decode:true}
{assign var="TourTravelProgram" value=$objResult->listTourTravelProgram($objResult->arrayTour['infoTour']['id_same'],$objResult->arrayTour['is_api'])}
{assign var="TourGalleryList" value=$objResult->arrayTour['gallery']}

{if $objResult->arrayTour['is_api'] eq true}
    {assign var="TourTravelProgramData" value=$TourTravelProgram['data']}

{else}
    {assign var="TourTravelProgramData" value=$TourTravelProgram['data']|json_decode:true}
{/if}
<input type='hidden' name='page-url' value='https://{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}'>

<style>
    .content_tech .container:first-child {
        max-width: unset !important;
        margin-left: unset !important;
        margin-right: unset !important;
        padding-left: unset !important;
        padding-right: unset !important;
    }
    .cover-img-tour-3i .my-breadcrumbs.container {
        max-width: unset !important;
        padding-right: 15px !important;
        padding-left: 15px !important;
        margin-right: auto !important;
        margin-left: auto !important;
    }
    @media (min-width: 576px) {
        .cover-img-tour-3i .my-breadcrumbs.container {
            max-width: 540px !important;
        }
    }
    @media (min-width: 768px) {
        .cover-img-tour-3i .my-breadcrumbs.container {
            max-width: 720px !important;
        }
    }
    @media (min-width: 992px) {
        .cover-img-tour-3i .my-breadcrumbs.container {
            max-width: 960px !important;
        }
    }
    @media (min-width: 1200px) {
        .cover-img-tour-3i .my-breadcrumbs.container {
            max-width: 1140px !important;
        }
    }
</style>


{if 1|in_array:$tourTypeIdArray}
    {assign var="typeTourReserve" value="oneDayTour"}
{else}
    {assign var="typeTourReserve" value="noOneDayTour"}
{/if}





<section class='cover-img-tour position-relative {if $TourGalleryList|count>3}cover-img-tour-3i{/if}'>
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/breadcrumb/detail.tpl"}

{*    {if $TourGalleryList|count<4}*}
{*        <div class='central-title'>*}
{*            <h1>*}
{*                {if $smarty.const.SOFTWARE_LANG eq 'fa'}*}
{*                    {$objResult->arrayTour['infoTour']['tour_name']}*}
{*                {else}*}
{*                    {$objResult->arrayTour['infoTour']['tour_name_en']}*}
{*                {/if}*}
{*            </h1>*}
{*        </div>*}
{*    {/if}*}

    {if $objResult->arrayTour['infoTour']['tour_file']}
        <a id="fileUrlPackageMob" target="_blank" href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$objResult->arrayTour['infoTour']['tour_file']}' class="parent-share-tour-img-caver">
            <i class="fa-light fa-download"></i>
            <span>##PackageTour##</span>
        </a>
    {/if}


    {if $TourGalleryList|count>3}
        <div class="container">
            <div class="mBox parent-tour-image">
                <img src='{if $objResult->arrayTour['is_api'] eq true} https://safar360.com/gds{else}{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}{/if}/pic/reservationTour/{$objResult->arrayTour['infoTour']['tour_cover']}'
                     alt='img-tour'>
                {foreach $TourGalleryList as $gallery_key=>$item}
                    <img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['pic_name']}'
                         alt='{$item['pic_title']}'>
                {/foreach}
                {if $TourGalleryList|count>5}
                    <div class="more-image">
                        <svg viewBox="0 0 24 24" width="1.5em" fill="currentColor" data-v-2c57d7f8="">
                            <path d="M20.251 4.5c1.24 0 2.25 1.01 2.25 2.249v10.5c0 .276-.058.536-.149.78l.004.005-.007.006a2.246 2.246 0 0 1-2.098 1.46H3.749A2.253 2.253 0 0 1 1.5 17.25V6.749c0-1.24 1.009-2.25 2.25-2.25h16.5Zm0 1.5H3.749A.75.75 0 0 0 3 6.749v8.096l1.987-3.12c.79-1.24 2.172-1.975 3.706-1.975h.06c1.553.02 2.938.79 3.703 2.06l.828 1.374a4.495 4.495 0 0 1 2.639-.853c1.427 0 2.76.66 3.566 1.766L21 16.172V6.749a.75.75 0 0 0-.749-.75Zm-5.197.75c1.21 0 2.196.985 2.196 2.196v.108a2.198 2.198 0 0 1-2.196 2.196h-.109a2.198 2.198 0 0 1-2.195-2.196v-.108c0-1.211.985-2.196 2.195-2.196h.11Z"></path>
                        </svg>
                        <span>{$TourGalleryList|count-5}</span>
                        ##otherImage##
                    </div>
                {/if}
            </div>
        </div>
        <div class="mBox mBox-owl">
            <div class="parent-owl-tour-image">
                <div class="owl-carousel owl-theme owl-tour-image owl-rtl owl-loaded owl-drag">
                    <img src='{if $objResult->arrayTour['is_api'] eq true} https://safar360.com/gds{else}{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}{/if}/pic/reservationTour/{$objResult->arrayTour['infoTour']['tour_cover']}'
                         alt='img-tour'>
                    {foreach $TourGalleryList as $gallery_key=>$item}
                        <img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$item['pic_name']}'
                             alt='{$item['pic_title']}'>
                    {/foreach}
                </div>
                <div class="more-image">
                    <svg viewBox="0 0 24 24" width="1.5em" fill="currentColor" data-v-2c57d7f8="">
                        <path d="M20.251 4.5c1.24 0 2.25 1.01 2.25 2.249v10.5c0 .276-.058.536-.149.78l.004.005-.007.006a2.246 2.246 0 0 1-2.098 1.46H3.749A2.253 2.253 0 0 1 1.5 17.25V6.749c0-1.24 1.009-2.25 2.25-2.25h16.5Zm0 1.5H3.749A.75.75 0 0 0 3 6.749v8.096l1.987-3.12c.79-1.24 2.172-1.975 3.706-1.975h.06c1.553.02 2.938.79 3.703 2.06l.828 1.374a4.495 4.495 0 0 1 2.639-.853c1.427 0 2.76.66 3.566 1.766L21 16.172V6.749a.75.75 0 0 0-.749-.75Zm-5.197.75c1.21 0 2.196.985 2.196 2.196v.108a2.198 2.198 0 0 1-2.196 2.196h-.109a2.198 2.198 0 0 1-2.195-2.196v-.108c0-1.211.985-2.196 2.195-2.196h.11Z"></path>
                    </svg>
                    <span>{$TourGalleryList|count}</span>
                    ##image2##
                </div>
            </div>
        </div>

    {else}
        <img src='{if $objResult->arrayTour['is_api'] eq true} https://safar360.com/gds{else}{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}{/if}/pic/reservationTour/{$objResult->arrayTour['infoTour']['tour_cover']}'
             alt='img-tour'>
    {/if}



</section>

{*{if $TourGalleryList|count>3}*}
{*    <div class='central-title-3i'>*}
{*        <h1>*}
{*            {if $smarty.const.SOFTWARE_LANG eq 'fa'}*}
{*                {$objResult->arrayTour['infoTour']['tour_name']}*}
{*            {else}*}
{*                {$objResult->arrayTour['infoTour']['tour_name_en']}*}
{*            {/if}*}
{*        </h1>*}
{*    </div>*}
{*{/if}*}

<div class='container position-relative z-index-3 '>
    <section class='box-title-tour {if $TourGalleryList|count>3}box-title-tour-3i{/if}'>
        <div class='parent-title-tour'>
            <div class=' {if $objResult->arrayTour.arrayDate|@count < 3}col-xl-9 col-lg-8 col-md-7 col-sm-6 col-8{else}col-xl-12 col-lg-12 col-md-12 col-sm-6 col-8 parent-package-tour{/if} p-0 parent-package'>
                <div class=''>
                    <div class='parent-new-titr'>
                        <h3 class='main-title'>
                            {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                {$objResult->arrayTour['infoTour']['tour_name']}
                            {else}
                                {$objResult->arrayTour['infoTour']['tour_name_en']}
                            {/if}
                        </h3>
                        {if $objResult->arrayTour.arrayDate|@count < 3}
                            <div class='parent-rate-subscription'>
                                {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/rates/rates-type-2.tpl"
                                item_id=$objResult->arrayTour['infoTour']['id_same']
                                section='tour'}
                            </div>
                        {/if}
                        <a id="fileUrlPackage" target="_blank" href="" class="parent-share-tour d-none file_package">
                            <i class="fa-light fa-download"></i>
                            <span>##PackageTour##</span>
                        </a>
                        <a onclick="shareBtn('{$objResult->arrayTour['infoTour'][$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'tour_name')]}')"
                           class="parent-share-tour">
                            <i class="fa-light fa-share-nodes"></i>
                            <span>##Share##</span>
                        </a>
                        {*                         {if $objResult->arrayTour['infoTour']['tour_file']}*}
                        {*                            <a   data-name="tour-file-download" target="_blank" href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$objResult->arrayTour['infoTour']['tour_file']}' class="parent-share-tour">*}
                        {*                                <i class="fa-light fa-download"></i>*}
                        {*                                <span>##PackageTour##</span>*}
                        {*                            </a>*}
                        {*                         {/if}*}
                    </div>
                    <div class='d-flex flex-wrap align-items-center parent-item-data-title-tour'>
                        <div class='item-data-title-tour residence'>
                            <div>
                                <i class="fa-regular fa-clock"></i>
                                ##Stayigtime##
                            </div>
                            <p> {$objResult->arrayTour['infoTour']['night']} ##Night## </p>
                        </div>
                        <div class='item-data-title-tour departure-date'>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2024 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>                                ##StartDate##
                            </div>

                            <p>
                                {if isset($objResult->arrayTour["arrayDate"][0])}
                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}

                                        {$objFunctions->dateFormatSpecialJalali($objResult->arrayTour["arrayDate"][0]['startDate'],'F')}

                                    {else}
                                        <span>{date('F', $objResult->arrayTour["arrayDate"][0]['startDate']|replace:'/':'-'|strtotime)}</span>
                                    {/if}
                                {else}
                                    <span>-</span>
                                {/if}
                            </p>
                        </div>
                        <div data-name='starts_array' class='item-data-title-tour  d-none'>
                            <div>
                                <i class="fa-regular fa-bed-empty"></i>
                                ##Hotel##
                            </div>
                            <p>
                                <span data-name='value'></span>
                                ##Star##</p>
                        </div>
                    </div>
                    <div class='btn-click-bottom-tour'>
                        <a href='https://{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}#result-data-click'
                           id='s1' class='item-btn-click-bottom-tour'>
                            <i class="fa-regular fa-circle-chevron-left"></i>
                            ##Package##
                        </a>
                        <a href='https://{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}#flight-tour-click'
                           id='s2' class='item-btn-click-bottom-tour'>
                            <i class="fa-regular fa-circle-chevron-left"></i>
                            ##Trasport##
                        </a>
                        <a href='https://{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}#travel-program-click'
                           id='s3' class='item-btn-click-bottom-tour'>
                            <i class="fa-regular fa-circle-chevron-left"></i>
                            ##Travelprogram##
                        </a>
                        <a href='https://{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}#submit_new_comment'
                           id='s4' class='item-btn-click-bottom-tour item-btn-click-bottom-tour-respancive'>
                            <i class="fa-regular fa-circle-chevron-left"></i>
                            ##Comments##
                        </a>

                        <div class="parent-reservation-btn-tour">
                            <a href="https://{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}#result-data-click"
                               data-name='link-to-package' class="reservation-btn-tour ">
                                <i class="fa-regular fa-circle-check"></i>
                                ##Tourreservation##
                                <span class="tooltiptext text-package-tooltip">
                                        ##PleaseChooseYourPackage##
                                        </span>
                            </a>

                        </div>
                    </div>
                </div>
                {if $objResult->arrayTour.arrayDate|@count < 3}
                {else}
                    <div class='parent-start-price'>
                        <div class='parent-rate-subscription'>
                            {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/rates/rates-type-2.tpl"
                            item_id=$objResult->arrayTour['infoTour']['id_same']
                            section='tour'}
                        </div>
                        <div class='parent-price-first'>
                            <h5 class='{if $objResult->arrayTour['minPrice']['minPriceA'] neq 0}flex-column-multi-price{else}flex-row-alone-rial{/if}'>
                                <div class=''>##StartingPrice##</div>
                                {assign var="originalR" value=$objResult->arrayTour['minPrice']['minPriceR']}
                                {assign var="afterDiscount" value=$objResult->arrayTour['minPrice']['discount']['after_discount']}
                                {if $afterDiscount > 0}
                                    {assign var="finalR" value=$afterDiscount}
                                {else}
                                    {assign var="finalR" value=$originalR}
                                {/if}
                                <span>
                                {if $finalR neq 0}
                                    {$finalR|number_format}

                                    {if $showTourToman}
                                        <span>##toman##</span>
                                    {else}
                                        <span>##Rial##</span>
                                    {/if}
                                {/if}
                                    {if $objFunctions->isEnableSetting('eachPerson')}
                                        <span>##EachPerson##</span>
                                    {/if}

                                    {if $objResult->arrayTour['minPrice']['minPriceR'] neq 0 && $objResult->arrayTour['minPrice']['minPriceA'] neq 0 }+{/if}
                                    {if $objResult->arrayTour['minPrice']['minPriceA'] neq 0}
                                        {$objResult->arrayTour['minPrice']['minPriceA']|number_format}
                                        {$objResult->arrayTour['minPrice']['CurrencyTitleFa']}
                                    {/if}
                                </span>
                            </h5>
                            <input type='hidden' name='price_per_person' id='price_per_person' value='{$objFunctions->isEnableSetting('eachPerson')}'>
                        </div>
                    </div>
                {/if}
            </div>
            {if $objResult->arrayTour.arrayDate|@count < 3}
                <div class='col-xl-3 col-lg-4 col-md-5 col-sm-3 col-4 p-0 div-date-tour'>
                    <h5>##datesoftheevent##</h5>
                    <div class='parent-date' data-name="package-dates">

                        {foreach $objResult->arrayTour["arrayDate"] as $date_key=>$date}
                            <button
                                    {if $date['capacity'] == 0}disabled{/if}
                                    type="button"
                                    data-start-date="{$date['startDate']}"
                                    data-capacity="{$date['capacity']}"
                                    data-api='{$objResult->arrayTour['is_api']}'
                                    onclick="triggerTourPackages($(this) , '{$date['id']}','{$date['startDate']}','{$date['endDate']}')"
                                    class='parent-date-link {if $date['capacity'] == 0} fullCapacity {/if} {if $date_key == 0} {else} active {/if}'>

                                <div class='round-trip-date text-right text-en-left'>
                                    {if $objFunctions->isShamsiDate($date['startDate'])}
                                        <span class='day-item'>{$objFunctions->dateFormatSpecialJalali($date['startDate'],'l')}</span>
                                        <span class='date-item'>{$objFunctions->dateFormatSpecialJalali($date['startDate'],'d F Y')}</span>
                                    {else}
                                        <span class='day-item'>{date('l', strtotime($date['startDate']))}</span>
                                        <span class='date-item'>{date('d F Y', $date['startDate']|replace:'/':'-'|strtotime)}</span>
                                        {*                                        <span class='date-item' dir='ltr'>{date('Y F d', $date['startDate']|replace:'/':'-'|strtotime)}</span>*}

                                    {/if}
                                    {if $objFunctions->isShamsiDate($date['startDate'])}
                                        <span class='d-none' data-name="start-date-selected" >{$objFunctions->dateFormatSpecialJalali($date['startDate'],'l d F')}</span>
                                    {else}
                                        <span class='d-none' data-name="start-date-selected">{date('l d F', $date['startDate'])}</span>
                                    {/if}


                                </div>
                                <div class='arrow-date'>
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                </div>
                                <div class='round-trip-date text-left text-en-right'>
                                    {if $objFunctions->isShamsiDate($date['endDate'])}
                                        <span class='day-item'>{$objFunctions->dateFormatSpecialJalali($date['endDate'],'l')}</span>
                                        <span class='date-item'>{$objFunctions->dateFormatSpecialJalali($date['endDate'],'d F Y')}</span>
                                    {else}
                                        <span class='day-item'>{date('l', strtotime($date['endDate']))}</span>
                                        <span class='date-item'>{date('d F Y', $date['endDate']|replace:'/':'-'|strtotime)}</span>
                                        {*                                    <span class='date-item' dir='ltr'>{date('Y F d', $date['endDate']|replace:'/':'-'|strtotime)}</span>*}

                                    {/if}
                                    {if $objFunctions->isShamsiDate($date['startDate'])}
                                        <span class='d-none' data-name="end-date-selected">{$objFunctions->dateFormatSpecialJalali($date['endDate'],'l d F')}</span>
                                    {else}
                                        <span class='d-none' data-name="end-date-selected">{date('l d F', $date['endDate'])}</span>
                                    {/if}
                                </div>
                                {if $date['capacity'] == 0 }
                                    <div class="{if $date['capacity'] == 0} text_fullCapacity {/if}">##FullCapacity##</div>
                                {/if}
                            </button>
                        {/foreach}



                        <span class='line'></span>
                    </div>
                    <div class='parent-price-first'>
                        <h5 class='{if $objResult->arrayTour['minPrice']['minPriceA'] neq 0}flex-column-multi-price{else}flex-row-alone-rial{/if}'>
                            <div class=''>##StartingPrice##</div>

                            {assign var="originalR" value=$objResult->arrayTour['minPrice']['minPriceR']}
                            {assign var="afterDiscount" value=$objResult->arrayTour['minPrice']['discount']['after_discount']}
                            {if $afterDiscount > 0}
                                {assign var="finalR" value=$afterDiscount}
                            {else}
                                {assign var="finalR" value=$originalR}
                            {/if}
                            <span>
                                {if $finalR neq 0}
                                    {$finalR|number_format}

                                    {if $showTourToman}
                                        <span>##toman##</span>
                                    {else}
                                        <span>##Rial##</span>
                                    {/if}
                                {/if}
                                {if $objFunctions->isEnableSetting('eachPerson')}
                                    <span>##EachPerson##</span>
                                {/if}

                                {if $objResult->arrayTour['minPrice']['minPriceR'] neq 0 && $objResult->arrayTour['minPrice']['minPriceA'] neq 0 }+{/if}
                                {if $objResult->arrayTour['minPrice']['minPriceA'] neq 0}
                                    {$objResult->arrayTour['minPrice']['minPriceA']|number_format}
                                    {$objResult->arrayTour['minPrice']['CurrencyTitleFa']}
                                {/if}

                                {*<pre>{$objResult->arrayTour['minPrice']|print_r}</pre>*}
                                </span>
                        </h5>
                        <input type='hidden' name='price_per_person' id='price_per_person' value='{$objFunctions->isEnableSetting('eachPerson')}'>
                    </div>
                </div>
            {/if}
        </div>
        <div class='parent-title-tour_res'>
            <div class="carousel" data-name="package-responsive-dates">
                {foreach $objResult->arrayTour["arrayDate"] as $date_key=>$date}
                    <div data-name="package-responsive-date"
                         class="carousel__item {if $date_key == 0} {else} active {/if}"
                         data-start-date="{$date['startDate']}"
                         data-api='{$objResult->arrayTour['is_api']}'
                         onclick="triggerTourPackages($(this) , '{$date['id']}','{$date['startDate']}','{$date['endDate']}')"   >
                        <div class="card select-date">
                            <a href="javascript:void(0)" class="active">

                                <div class="select-date__item">
                                    <span>{$objFunctions->dateFormatSpecialJalali($date['startDate'],'d')}</span>
                                    <span>{$objFunctions->dateFormatSpecialJalali($date['startDate'],'F')}</span>
                                </div>
                                <div class="select-date__item">
                                    <span>{$objFunctions->dateFormatSpecialJalali($date['endDate'],'d')}</span>
                                    <span>{$objFunctions->dateFormatSpecialJalali($date['endDate'],'F')}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                {/foreach}

            </div>
            <div class='wrapper-road-map'>
                <div class='card'>
                    <ul class='nav road-map'>
                        <li class='nav-item road-map-item'>
                            <a href='#travel-program-click' class='nav-link'>##Travelprogram##</a>
                        </li>

                        <li class='nav-item road-map-item'>
                            <a href='#documents-tour-click' class='nav-link'>##TourInformation##</a>
                        </li>
                        <li class='nav-item road-map-item parent-reservation-btn-tour'>

                            <a href='javascript:' class='nav-link reservation-btn-tour'>
                                ##Tourreservation##
                                <span class="tooltiptext text-package-tooltip">
                                ##PleaseChooseYourPackage##
                            </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    {if $objResult->arrayTour.arrayDate|@count > 2}
        <div class="tour-more-data-new">
            <h4>تاریخ‌ تورهای در حال برگزاری</h4>
            <div class="owl-carousel owl-theme owl-count-day" data-name="package-dates">
                {foreach $objResult->arrayTour["arrayDate"] as $date_key=>$date}
                    <div class="item">
                        <button
                                {if $date['capacity'] == 0}disabled{/if}
                                type="button"
                                data-start-date="{$date['startDate']}"
                                data-capacity="{$date['capacity']}"
                                data-api='{$objResult->arrayTour['is_api']}'
                                onclick="triggerTourPackages($(this) , '{$date['id']}','{$date['startDate']}','{$date['endDate']}')"
                                class='parent-date-link {if $date['capacity'] == 0} fullCapacity {/if} {if $date_key == 0} {else} active {/if}'>
                            <div class="parent-title-data-count">
                                {$objFunctions->dateFormatSpecialJalali($date['startDate'], 'F Y')}
                                {*                            شهریور 1404*}
                                {*                        <article class="capacity-completion">تکمیل ظرفیت</article>*}
                            </div>
                            <div class="parent-data-count">
                                <div class='round-trip-date text-right text-en-left'>
                                    {if $objFunctions->isShamsiDate($date['startDate'])}
                                        <span class="title-item">رفت</span>
                                        <span class='date-item'>{$objFunctions->dateFormatSpecialJalali($date['startDate'],'d')}</span>
                                        <span class='day-item'>{$objFunctions->dateFormatSpecialJalali($date['startDate'],'l')}</span>
                                    {else}
                                        <span class='day-item'>{date('l', strtotime($date['startDate']))}</span>
                                        <span class='date-item'>{date('d F Y', $date['startDate']|replace:'/':'-'|strtotime)}</span>
                                        {*                                        <span class='date-item' dir='ltr'>{date('Y F d', $date['startDate']|replace:'/':'-'|strtotime)}</span>*}

                                    {/if}
                                    {if $objFunctions->isShamsiDate($date['startDate'])}
                                        <span class='d-none' data-name="start-date-selected" >{$objFunctions->dateFormatSpecialJalali($date['startDate'],'l d F')}</span>
                                    {else}
                                        <span class='d-none' data-name="start-date-selected">{date('l d F', $date['startDate'])}</span>
                                    {/if}


                                </div>
                                <div class='arrow-date'>
                                    <i class="fa-solid fa-arrow-left-long"></i>
                                </div>
                                <div class='round-trip-date text-left text-en-right'>
                                    {if $objFunctions->isShamsiDate($date['endDate'])}
                                        <span class="title-item">برگشت</span>
                                        <span class='date-item'>{$objFunctions->dateFormatSpecialJalali($date['endDate'],'d')}</span>
                                        <span class='day-item'>{$objFunctions->dateFormatSpecialJalali($date['endDate'],'l')}</span>
                                    {else}
                                        <span class='day-item'>{date('l', strtotime($date['endDate']))}</span>
                                        <span class='date-item'>{date('d F Y', $date['endDate']|replace:'/':'-'|strtotime)}</span>
                                        {*                                    <span class='date-item' dir='ltr'>{date('Y F d', $date['endDate']|replace:'/':'-'|strtotime)}</span>*}

                                    {/if}
                                    {if $objFunctions->isShamsiDate($date['startDate'])}
                                        <span class='d-none' data-name="end-date-selected">{$objFunctions->dateFormatSpecialJalali($date['endDate'],'l d F')}</span>
                                    {else}
                                        <span class='d-none' data-name="end-date-selected">{date('l d F', $date['endDate'])}</span>
                                    {/if}
                                </div>
                                {if $date['capacity'] == 0 }
                                    <div class="{if $date['capacity'] == 0} text_fullCapacity {/if}">##FullCapacity##</div>
                                {/if}
                            </div>
                        </button>
                    </div>
                {/foreach}
            </div>
        </div>
    {/if}
    <section class='tab-mobile-date'>

    </section>
    <section class="tour-Internal">
        <h3 class='title-tour-detail-section'>
            حمل و نقل
        </h3>

        <input type='hidden' name='selected_package_id' id='selected_package_id'>
        <section data-name="package-item" class="box-hotel1 d-none">
            <div class="gallery-hotel">
                {literal}
                <div class="d-flex flex-wrap">
                    <div data-name="package-hotels-item" class="d-flex w-100 flex-wrap">
                        <div class='hotel-tour d-flex flex-wrap hotel-tour p-0 w-100' data-name="package-hotel-item">
                            <div class='parent-hotel-tour d-flex flex-wrap  w-100'>
                                <div class='col-lg-3 col-md-4 col-sm-4 col-4 p-0 parent-hotel-tour-img'>


                                    <div data-name='hotel-gallery' class="owl-carousel owl-theme owl-hotel-slider1">
                                        <div data-name='hotel-gallery-item' class="item">
                                            <div class="w-100">
                                                <img data-name="has-hotel-gallery-item-index"
                                                     data-index='[{"src":"pic_address"},{"alt":"name_en"}]'
                                                     src="" alt="owl-img" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class='col-lg-9 col-md-8 col-sm-8 col-8 p-0 parent-hotel-tour-option'>
                                    <div class='hotel-star-tour'>
                                        <div class='star-hotel-tour'>
                                            <h2 onclick="triggerHotelDetail($(this))" data-hotel-type="reservation" data-name="has-index" data-index='[
                                      {/literal}



                                      {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                {literal}
                                            {"html":"name_en"}
                                            {/literal}
                                                  {else}
                                                   {literal}
                                                       {"html":"name"}
                                            {/literal}

                                                  {/if}
                                            {literal}
                                      ,{"data-hotel-name":"name_en"},{"data-hotel-id":"id"}]'></h2>
                                            <span data-name="has-index" data-index='{"html":"room_type"}' style="font-size: 14px; color: #666; margin-right: 10px;"></span>


                                            <h6 onclick="triggerHotelDetail($(this))" data-hotel-type="reservation" data-name="has-index" data-index='[
                                             {/literal}

                                                   {literal}
                                                       {"html":"name_en"}
                                            {/literal}

                                            {literal}
                                      ,{"data-hotel-name":"name_en"},{"data-hotel-id":"id"}]'></h6>
                                            <span class='lg-only'>

                                          <div
                                                  class='d-flex flex-row-reverse lg-only'
                                                  data-name="has-index"
                                                  data-index='{"html":"star_code"}'></div>

                                        </span>

                                        </div>
                                        <div>
                                            {/literal}
                                            {if $objFunctions->isEnableSetting('mobile')}
                                                <a class='a_phone_for_tour' href='tel:{$smarty.const.CLIENT_PHONE}'>
                                                    <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M480.3 320.3L382.1 278.2c-21.41-9.281-46.64-3.109-61.2 14.95l-27.44 33.5c-44.78-25.75-82.29-63.25-108-107.1l33.55-27.48c17.91-14.62 24.09-39.7 15.02-61.05L191.7 31.53c-10.16-23.2-35.34-35.86-59.87-30.19l-91.25 21.06C16.7 27.86 0 48.83 0 73.39c0 241.9 196.7 438.6 438.6 438.6c24.56 0 45.53-16.69 50.1-40.53l21.06-91.34C516.4 355.5 503.6 330.3 480.3 320.3zM463.9 369.3l-21.09 91.41c-.4687 1.1-2.109 3.281-4.219 3.281c-215.4 0-390.6-175.2-390.6-390.6c0-2.094 1.297-3.734 3.344-4.203l91.34-21.08c.3125-.0781 .6406-.1094 .9531-.1094c1.734 0 3.359 1.047 4.047 2.609l42.14 98.33c.75 1.766 .25 3.828-1.25 5.062L139.8 193.1c-8.625 7.062-11.25 19.14-6.344 29.14c33.01 67.23 88.26 122.5 155.5 155.5c9.1 4.906 22.09 2.281 29.16-6.344l40.01-48.87c1.109-1.406 3.187-1.938 4.922-1.125l98.26 42.09C463.2 365.2 464.3 367.3 463.9 369.3z"/></svg></i>
                                                    {$smarty.const.CLIENT_MOBILE}
                                                </a>
                                            {/if}
                                            {literal}

                                            <span class='sm-only'>
                                          <i class="fa fa-star icone-star"></i>
                                          <span
                                                  data-name="has-index"
                                                  data-index='{"html":"star_code"}'></span>
                                          ##Star##
                                        </span>

                                        </div>
                                    </div>
                                    <div class='hotel-option-tour'>
                                        <div class='hotel-tour-option-box1'>
                                            <div class='city-name-hotel-tour'>
                                                <i class="fa-regular fa-location-dot"></i>
                                                {/literal}
                                                <span data-name="has-index"
                                                  {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                  {literal}
                                                      data-index='{"html":"city_name_en"}'
                                                  {/literal}
                                                  {else}
                                                  {literal}
                                                      data-index='{"html":"city_name"}'
                                                  {/literal}
                                                  {/if}
                                                        {literal}
                                                  >

                                            </span>
                                            </div>
                                            <span class='night-hotel-tour'>
                                            <i class="fa-regular fa-moon"></i>
                                            <span
                                                    data-name="has-index"
                                                    data-index='{"html":"night"}'></span>
                                     ##Night##
                                        </span>
                                            <span
                                                    class='all-name-hotel-tour'
                                                    data-name="has-index"
                                                    data-index='{"html":"room_service"}'>
                      All
                    </span>
                                        </div>



                                        <div class='hotel-tour-option-box2'>
                                            <a onclick="triggerHotelDetail($(this),'facilities-section')"
                                               data-hotel-type="reservation"
                                               data-name="has-index"
                                               data-index='[{"data-hotel-name":"name_en"},{"data-hotel-id":"id"}]'
                                               class='btn-option'>
                                                <i class="fa-regular fa-link"></i>
                                                ##facilities##
                                            </a>
                                            <a onclick="triggerHotelDetail($(this),'gallery-section')"
                                               data-hotel-type="reservation"
                                               data-name="has-index"
                                               data-index='[{"data-hotel-name":"name_en"},{"data-hotel-id":"id"}]'
                                               class='btn-option'>
                                                <i class="fa-regular fa-link"></i>
                                                ##Gallery##
                                            </a>
                                            <a onclick="triggerHotelDetail($(this),'detail-section')"
                                               data-hotel-type="reservation"
                                               data-name="has-index"
                                               data-index='[{"data-hotel-name":"name_en"},{"data-hotel-id":"id"}]'
                                               class='btn-details'>
                                                <i class="fa-regular fa-link"></i>
                                                ##HotelDetail##
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/literal}


                <div class="box-bed-money">
                    <div class="d-flex flex-wrap">
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 responsive-mobile-order-10 responsive-padding-col change-display">
                            <div class="parent-tour-data">
                                <div class="titr-data">
                                    <h5>##TourDates##</h5>
                                </div>

                                <div
                                        data-name="package-dates"
                                        class="d-flex future-date overflow-auto">

                                </div>
                                {literal}
                                    <div
                                            class="present-date"
                                            style="margin-top: auto">
                                        <div class="parent-calendar">
                                            <div class="calendar-went">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <i class=" fa-light fa-person-walking-luggage icone-calendar-day"></i>
                                                    <span
                                                            data-name="has-package-index"
                                                            data-index='{"html":"start_date_week"}'
                                                            class="calendar-day">
                                      شنبه
                                    </span>
                                                </div>
                                                <span
                                                        data-name="has-package-index"
                                                        data-index='{"html":"start_date_human_string"}'></span>
                                            </div>
                                        </div>
                                        <div class="parent-calendar">
                                            <div class="calendar-went">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <i class="fa-light fa-person-walking-luggage"></i>
                                                    <span
                                                            data-name="has-package-index"
                                                            data-index='{"html":"end_date_week"}'
                                                            class="calendar-day">
                                      جمعه
                                    </span>
                                                </div>
                                                <span
                                                        data-name="has-package-index"
                                                        data-index='{"html":"end_date_human_string"}'></span>
                                            </div>
                                        </div>
                                    </div>
                                {/literal}
                            </div>
                        </div>
                        <div data-name="price-rooms" class="col-lg-9 col-md-12 col-sm-12 col-12 p-0 parent-grid-price">
                            {literal}

                            <div
                                    data-name="price-room"
                                    class="box-number-beds item">
                            <span
                                    data-name="has-package-room-index"
                                    data-index='{"html":"name"}'
                                    class="head-number-beds site-bg-main-color">
                              یک تخته (هرنفر)
                            </span>
                                <div class="first-price check_exist_discount">
                             <span
                                     data-name="has-package-room-index"
                                     data-index='{"html":"price"}'></span>
                                    <i>{/literal}{$iranCurrency}{literal}</i>

                                    <div data-name='currency-box'>
                                           <span
                                                   data-name="has-package-room-index"
                                                   data-type='currency_price'
                                                   data-index='{"html":" "}'></span>
                                    </div>
                                </div>
                                <div class="d-flex first-price flex-wrap ">
                                    <div class='d-flex gap-2 price-tour-rial'>
                                      <span
                                              class="d-flex flex-wrap"
                                              data-name="has-package-room-index"
                                              data-index='{"html":"final_price"}'></span>
                                        <i class="d-flex flex-wrap">{/literal}{$iranCurrency}{literal}</i>
                                    </div>

                                    <div data-name='currency-box' class='d-flex gap-2 price-tour-currency'>
                                           <span class="d-flex flex-wrap"
                                                 data-name="has-package-room-index"
                                                 data-type='currency_price'
                                                 data-index='{"html":"currency_price"}'></span>

                                        <i class="d-flex flex-wrap"
                                           data-name="has-package-room-index"
                                           data-type='currency_name'
                                           data-index='{"html":"currency_name"}'></i>
                                    </div>
                                </div>
                                <div
                                        class="w-100 d-flex align-items-center parent-btn-number-beds">
                              <span
                                      onclick='triggerPackageRoomCount($(this),"increase")'
                                      class="enter-number-beds site-main-bg-color-h">
                                <i class="fa-solid fa-plus"></i>
                              </span>
                                    <span
                                            data-name="value"
                                            class="number-beds-counter">
                                0
                              </span>
                                    <span
                                            onclick='triggerPackageRoomCount($(this),"decrease")'
                                            class="enter-number-beds site-main-bg-color-h">
                                <i class="fa-solid fa-minus"></i>
                              </span>
                                    <input
                                            type="hidden"
                                            value='0'
                                            data-name="has-package-room-index"
                                            min="0"
                                            data-index='[{"max":"capacity"},{"data-price":"final_price"},{"data-coefficient":"coefficient"},{"data-index-name":"index"},{"data-type":"type"},{"data-currency-price":"currency_price"},{"data-currency-name":"currency_name"}]' />
                                </div>
                            </div>


                            {/literal}
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12 col-12 p-0 responsive-padding-col price-mb">
                            <div class="parent-tour-price">
                                <div class="titr-data">
                                    <h5>##YourTourPrice##</h5>
                                </div>
                                <input type='hidden' data-name='prepayment-percentage'
                                       value='{$objResult->arrayTour['infoTour']['prepayment_percentage']}'
                                >
                                <div class="price-all-tour">
                                    <span data-name="selected-package-price">0</span>
                                    {$iranCurrency}
                                </div>
                                {if $objResult->arrayTour['infoTour']['prepayment_percentage'] gt 0}
                                    <div
                                            class="d-flex flex-wrap justify-content-center gap-5 price-prepayment-tour small text-center">
                                        ##Prereserve##
                                        <span>
                                            ({$objResult->arrayTour['infoTour']['prepayment_percentage']}%)
                                          </span>
                                        :
                                        <span
                                                data-name="selected-package-prepayment-price"
                                                style="display: none;"
                                                class="font-15 font-weight-bold w-100">
                                            0
                                          </span>
                                    </div>
                                {/if}

                                <form action="" method="post" id="formReservationTour">
                                    <input name="serviceName" id="serviceName" type="hidden" value="tour">
                                    <input name="is_api" id="is_api" type="hidden" value="{$objResult->arrayTour['is_api']}">
                                    <input id="is_request" name="is_request" type="hidden"
                                           value="{if $objResult->arrayTour['infoTour']['is_request'] eq 1}1{else}0{/if}">
                                    <input name="selectDate" id="selectDate" type="hidden">
                                    <input id="tourCode" name="tourCode" type="hidden"
                                           value="{$objResult->arrayTour['infoTour']['tour_code']}">
                                    <input id="tour_id" name="tour_id" type="hidden" value="{$smarty.const.TOUR_ID}">
                                    <input type="hidden" id="cities" name="cities"
                                           value="{$objResult->arrayTour['destination_cities']}">
                                    <input type="hidden" id="serviceTitle" name="serviceTitle"
                                           value="{$objResult->arrayTour['serviceTitle']}">
                                    <input type="hidden" value="{$tour['startDate']} | {$tour['endDate']}"
                                           id="startDate" name="startDate">
                                    <input type="hidden" id="prepaymentPercentage" name="prepaymentPercentage"
                                           value="{$objResult->arrayTour['infoTour']['prepayment_percentage']}">
                                    <input type="hidden" name="totalOriginPrice" id="totalOriginPrice" value="0">
                                    <input type="hidden" name="totalPrice" id="totalPrice" value="0">
                                    <input type="hidden" name="totalPriceA" id="totalPriceA" value="0">
                                    <input type="hidden" name="paymentPrice" id="paymentPrice" value="0">
                                    <input type="hidden" name="passengerCount" id="passengerCount" value="0">
                                    <input type="hidden" name="passengerCountADT" id="passengerCountADT" value="0">
                                    <input type="hidden" name="passengerCountCHD" id="passengerCountCHD" value="0">
                                    <input type="hidden" name="passengerCountINF" id="passengerCountINF" value="0">

                                    <input type="hidden" name="currencyTitleFa" id="currencyTitleFa"
                                           value="{$objResult->arrayTour['infoTourRout']['currency_type']}">
                                    <input type="hidden" name="countRoom" id="countRoom" value="">
                                    <input type="hidden" value="{$typeTourReserve}" name="typeTourReserve"
                                           id="typeTourReserve">
                                    {literal}
                                        <input type="hidden" data-name="has-package-index" data-index='{"value":"id"}'
                                               id="packageId" name="packageId">
                                    {/literal}
                                </form>

                                <button type='button'
                                        onclick='reserveTourV2($(this),{if $objResult->arrayTour['infoTour']['is_request'] eq 1}true{else}false{/if})'
                                        class="btn-Reservation-bed ">
                                    ##ResumeReservation##
                                </button>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="flight-tour-mobile" >
            <div class="box-flight-mobile">
                <div class="flight-mobile-header">
                    <div class="flight-mobile-title">
                        ##Starttour##
                    </div>
                    <div class="flight-mobile-city">
                        <h6>{$objResult->arrayTour['infoTour']['origin_city_name']} </h6>
                        {*                                           <span>Tehran</span>*}
                    </div>
                    <!--                   <div class="flight-mobile-icon">-->
                    <!--                       <i class="fa-solid fa-plus"></i>-->
                    <!--                   </div>-->
                </div>
            </div>
            {foreach $tourRouteData['destinations'] as $route_key=>$rout}
                <div class="box-flight-mobile ">
                    <div class="flight-mobile-header flight-mobile-click" onclick="flightPath()">
                        <div class="flight-mobile-title">
                            {if count($tourRouteData['destinations']) eq $route_key+1}
                                ##EndOfTravel##
                            {else}
                                {if $route_key eq 0}
                                    ##destinationFirst##
                                {elseif $route_key eq 1}
                                    ##destinationSecond##
                                {elseif $route_key eq 2}
                                    ##destinationThird##
                                {elseif $route_key eq 3}
                                    ##destinationFourth##
                                {elseif $route_key eq 4}
                                    ##destinationFifth##
                                {elseif $route_key eq 5}
                                    ##destinationSixth##
                                {elseif $route_key eq 6}
                                    ##destinationSeventh##
                                {elseif $route_key eq 7}
                                    ##destinationEighth##
                                {elseif $route_key eq 8}
                                    ##destinationNinth##
                                {elseif $route_key eq 9}
                                    ##destinationTenth##
                                {/if}
                            {/if}
                        </div>
                        <div class="flight-mobile-city">
                            <h6>
                                {if count($tourRouteData['destinations']) eq $route_key+1}
                                    {$rout['city_name']}
                                {else}
                                    {$rout['city_name']}
                                    <span>
                                                    ({$rout['night']}##Night##)
                                                </span>
                                {/if}
                            </h6>
                            {*                                           <span>Tehran</span>*}
                        </div>
                        {*                                       {if count($tourRouteData['destinations']) neq $route_key+1}*}
                        <div class="flight-mobile-icon">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        {*                                       {/if}*}
                    </div>
                    <div class="flight-mobile-body">
                        <div class="fly-route-flight-mobile">
                            <div class="fly-route-destination">
                                <h6>     {if $route_key eq 0}
                                        {$tourRouteData['origin']['city_name']}
                                    {else}
                                        {$tourRouteData['destinations'][$route_key-1]['city_name']}
                                    {/if}</h6>
                                <span>ایران/تهران</span>
                            </div>
                            <div class="fly-route-icon">
                                <i class="custom-bg-svg {$rout['vehicle']['icon']}"></i>
                            </div>
                            <div class="fly-route-destination">
                                <h6> {$rout['city_name']}</h6>
                                <span>ایران/تهران</span>
                            </div>
                        </div>
                        <div class="airline-flight-mobile">
                            <div class="logo-airline-flight-mobile">
                                <img
                                        src="{$rout['vehicle']['src']}"
                                        alt="{$rout['vehicle']['name_en']}" />
                                <h6>{$rout['vehicle']['name']}</h6>
                            </div>
                            <div class="economy">
                                ECONOMY
                            </div>
                        </div>
                        <div class="clock-flight-mobile">
                            <div class="parent-clock-flight-mobile">
                                               <span>
                                                   {if $rout['vehicle']['name'] eq 'هواپیما'}
                                                       ##FlightExactTime##
                                                   {else}
                                                       ##timeMove##
                                                   {/if}
                                               </span>
                                <span>{$rout['exit_hours']}</span>
                            </div>
                            <div class="parent-clock-flight-mobile">
                                               <span>
                                               {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                                                   ##FlightDuration##
                                               {else}
                                                   ##Durationmovement##
                                               {/if}
                                        </span>

                                <span>
                                                   {$rout['hours']}
                                               </span>
                            </div>
                            {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                                <div class="value-bar">
                                    ##Permissible## :
                                    <span>{$objResult->arrayTour['infoTour']['free']}</span>
                                    <small>کیلو</small>
                                </div>
                            {/if}
                        </div>
                    </div>
                </div>
            {/foreach}
        </section>



        <a id='reservation-fix-btn'
           href='https://{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}#result-data-click'
           class='reservation-fix' data-name='link-to-package'>
            <i class="fa-regular fa-circle-check"></i>
            ##Tourreservation##
        </a>


        <section class="flight-tour" id='flight-tour-click'>
            <div class="dates">
                {if $objFunctions->isShamsiDate($date['startDate'])}
                    <span data-name='startDate'> {$objFunctions->dateFormatSpecialJalali($date['startDate'],'l d F')}</span>
                    <i class="fa-regular fa-arrow-left-long"></i>
                    <span data-name='endDate'>{$objFunctions->dateFormatSpecialJalali($date['endDate'],'l d F')}</span>
                {else}
                    <span data-name='startDate'> {date('l d F', $date['startDate'])}</span>
                    <i class="fa-regular fa-arrow-left-long"></i>
                    <span data-name='endDate'>{date('l d F', $date['endDate']|replace:'/':'-'|strtotime)}</span>
                {/if}
            </div>
            <div class="tour-travel-parent">
                <div class="tour-travel-item">
                    <div class="label-tour-travel">
                        <span class="origin">
                               <span>{$objResult->arrayTour['infoTour']['origin_city_name']} </span>
                        <i>(##Starttour##)</i>
                        </span>
                    </div>
                </div>
                {foreach $tourRouteData['destinations'] as $route_key=>$rout}
                    <div class="tour-travel-item">
                        <div class="card-tour">
                            <div class="card-tour-body">
                                <div class="{if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}col-lg-4{else}col-lg-6{/if} col-md-6 col-sm-12 col-12 card-col-flight flex-row card-col-flight-flex">
                                    <div class="airport-of-origin">
                                        {if $route_key eq 0}
                                            <div>  {$tourRouteData['origin']['abbreviationOrg']}</div>
                                        {else}
                                            <div>  {$tourRouteData['destinations'][$route_key-1]['abbreviationDEs']}</div>
                                        {/if}
                                        <div title=" ">
                                            {if $route_key eq 0}
                                                {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                    {$tourRouteData['origin']['city_name_en']}
                                                {else}
                                                    {$tourRouteData['origin']['city_name']}
                                                {/if}
                                            {else}
                                                {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                    {$tourRouteData['destinations'][$route_key-1]['city_name_en']}
                                                {else}
                                                    {$tourRouteData['destinations'][$route_key-1]['city_name']}
                                                {/if}
                                            {/if}
                                        </div>
                                    </div>
                                    <div>
                                        <i class="custom-bg-svg {$rout['vehicle']['icon']}"></i>
                                    </div>
                                    <div class="destination-airport">
                                        <div>  {$rout['abbreviationDEs']}</div>
                                        <div>
                                            {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                                {$rout['city_name_en']}
                                            {else}
                                                {$rout['city_name']}
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12 col-12 card-col-flight">
                                    <img
                                            src="{$rout['vehicle']['src']}"
                                            alt="{$rout['vehicle']['name_en']}" />
                                    <div class="name-airline">
                                        {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                            {$rout['vehicle']['name_en']}
                                        {else}
                                            {$rout['vehicle']['name']}
                                        {/if}
                                    </div>
                                </div>
                                {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                                    <div class="col-lg-2 col-md-6 col-sm-12 col-12 card-col-flight">
                                        <div class="title-bar">ECONOMY</div>
                                        <div class="value-bar">
                                            ##Permissible## :
                                            <span>{$objResult->arrayTour['infoTour']['free']}</span>
                                            <small>کیلو</small>
                                        </div>
                                    </div>
                                {/if}
                                <div class="col-lg-2 col-md-6 col-sm-12 col-12 card-col-flight">
                                    <small class="small-title">
                                        {if $rout['vehicle']['name'] eq 'هواپیما'}
                                            ##FlightExactTime##
                                        {else}
                                            ##timeMove##
                                        {/if}
                                    </small>
                                    <span class="fly-time">{$rout['exit_hours']}</span>
                                </div>
                                <div class="col-lg-2 col-md-6 col-sm-12 col-12 card-col-flight">
                                    <small class="small-title">
                                        {if $objResult->arrayTour['infoTourRout'][$k]['type_vehicle_name'] eq 'هواپیما'}
                                            ##FlightDuration##
                                        {else}
                                            ##Durationmovement##
                                        {/if}
                                    </small>
                                    <span class="flight-duration">
                                {$rout['hours']}
                              </span>
                                </div>
                            </div>
                        </div>
                        {if count($tourRouteData['destinations']) eq $route_key+1}
                            <div class="label-ending">
                                <span class="origin-ending">
                                 <span>
                                        {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                            {$rout['city_name_en']}
                                        {else}
                                            {$rout['city_name']}
                                        {/if}
                                 </span>
                                 <i>(##EndOfTravel##)</i>
                                 </span>
                            </div>
                        {else}
                            <div class="label-tour-travel-two">
                              <span class="origin">
                                  <span>
                                         {if $smarty.const.SOFTWARE_LANG eq 'en'}
                                             {$rout['city_name_en']}
                                         {else}
                                             {$rout['city_name']}
                                         {/if}
                                  </span>
                                  <i> ({$rout['night']} ##Night##)</i>
                              </span>
                            </div>
                        {/if}
                    </div>
                {/foreach}
            </div>
        </section>
        <div data-name="result-loading"
             class='h-300 align-items-center d-flex flex-wrap gap-10 justify-content-center w-100 loader-parent'>
            <div class='loader-spinner'></div>
            <span class='font-13'>##LoadingPackages##</span>
        </div>
        <div data-name="result-data" id='result-data-click'></div>


        {if $TourTravelProgramData.day[0].title !== '' && (!empty($TourTravelProgramData.day) || !empty($objResult->arrayTour['infoTour']['travel_program'])) }
            <section class="travel-program" id='travel-program-click'>
                <div class="header-travel-program">
                    <h4>##Travelprogram##</h4>
                    <button

                            class="open-accordion">
                        <span>##OpeningAll##</span>
                        <i class="fa-light fa-lock-keyhole-open"></i>
                    </button>
                </div>
                <div
                        id="accordion-travel-program"
                        role="tablist"
                        aria-multiselectable="true">
                    {if empty($TourTravelProgramData.day)}
                        <div class="box-travel-program card">
                            <div class="card-header-travel-program"
                                 role="tab"
                                 id="heading-travel-program-default">
                                <h4 class="panel-title mb-0 parent-accordion-travel-program">
                                    <a
                                            class="collapsed btn-link w-100"
                                            data-toggle="collapse"
                                            data-parent="#accordion-travel-program-default"
                                            href="#Collapse-travel-program-default"
                                            aria-expanded="false"
                                            aria-controls="Collapse-travel-program-default">

                                        <i class="fa-light fa-person-walking-luggage icone-tour-day"></i>


                                        <span class="internal-headline-accordion">##Travelprogram##</span>

                                        <i class="fa icone-arrow-travel-program"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="Collapse-travel-program-default"
                                 class="collapse show"
                                 role="tabpanel"
                                 aria-labelledby="heading-travel-program-default">
                                <div class="d-flex flex-wrap parent-collapse-accordion">
                                    <div class="col-lg-7 col-md-6 col-sm-12 col-12 p-0">
                                        <div class="parent-text-accordion-day">
                                            {$objResult->arrayTour['infoTour']['travel_program']}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {else}
                        {assign var=TourTravelProgramCounter value=1}
                        {foreach $TourTravelProgramData.day as $TourTravelProgramDay_key=>$TourTravelProgramDay}
                            <div class="box-travel-program card">
                                <div
                                        class="card-header-travel-program"
                                        role="tab"
                                        id="heading-travel-program-{$TourTravelProgramDay_key}">
                                    <h4 class="panel-title mb-0 parent-accordion-travel-program">
                                        <a
                                                class="collapsed btn-link w-100"
                                                data-toggle="collapse"
                                                data-parent="#accordion-travel-program"
                                                href="#Collapse-travel-program-{$TourTravelProgramDay_key}"
                                                aria-expanded="false"
                                                aria-controls="Collapse-travel-program-{$TourTravelProgramDay_key}">
                                            {if $TourTravelProgramDay_key eq 0}
                                                <i class="fa-light fa-flag-checkered icone-start"></i>
                                            {elseif count($TourTravelProgramData.day) eq $TourTravelProgramDay_key+1}
                                                <i class="fa-light fa-flag-checkered icone-final"></i>
                                            {else}
                                                <i class="fa-light fa-person-walking-luggage icone-tour-day"></i>
                                            {/if}


                                            <span class="internal-headline-accordion">##Day## {$TourTravelProgramDay_key + 1}:</span>
                                            <span>{$TourTravelProgramDay['title']}</span>
                                            <i class="fa icone-arrow-travel-program"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div
                                        id="Collapse-travel-program-{$TourTravelProgramDay_key}"
                                        class="collapse {if $TourTravelProgramDay_key eq 0 } show {/if}"
                                        role="tabpanel"
                                        aria-labelledby="heading-travel-program-{$TourTravelProgramDay_key}">
                                    <div class="d-flex flex-wrap parent-collapse-accordion">
                                        <div class="col-lg-7 col-md-6 col-sm-12 col-12 p-0">
                                            <div class="parent-text-accordion-day">
                                                {$TourTravelProgramDay['body']}
                                            </div>
                                        </div>
                                        {if $TourTravelProgramDay.gallery}
                                            {assign var="has_gallery" value=false}
                                            {foreach $TourTravelProgramDay.gallery as $TourTravelProgramGallery}
                                                {if $TourTravelProgramGallery.file}
                                                    {assign var="has_gallery" value=true}
                                                {/if}
                                            {/foreach}
                                            <div class="col-lg-5 col-md-6 col-sm-12 col-12 p-0">
                                                {if $has_gallery}

                                                    <div class="parent-owl-accordion">
                                                        <div class="owl-carousel owl-theme owl-accordion-day">
                                                            {foreach $TourTravelProgramDay.gallery as $TourTravelProgramGallery}

                                                                <div class="item">
                                                                    {if $objResult->arrayTour['is_api'] eq true}
                                                                        <img
                                                                                src="{$TourTravelProgramGallery.file}"
                                                                                alt="{$TourTravelProgramGallery.title}" />
                                                                    {else}
                                                                        <img
                                                                                src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/{$TourTravelProgramGallery.file}"
                                                                                alt="{$TourTravelProgramGallery.title}" />
                                                                    {/if}

                                                                </div>

                                                            {/foreach}
                                                        </div>
                                                    </div>
                                                {/if}
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        {/foreach}

                    {/if}
                </div>
            </section>
        {/if}
        <section class="documents-tour" id='documents-tour-click'>
            <div class="parent-documents-tour">
                {literal}
                    <svg class='svg-tab-rules' version="1.1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 750 500"
                         style="enable-background:new 0 0 750 500;" xml:space="preserve">
<style type="text/css">
    .st0 {
        clip-path: url(#SVGID_2_);
    }

    .st1 {
        opacity: 0.65;
        fill: url(#SVGID_3_);
    }

    .st2 {
        opacity: 0.65;
        fill: url(#SVGID_4_);
    }

    .st3 {
        opacity: 0.65;
        fill: url(#SVGID_5_);
    }

    .st4 {
        opacity: 0.65;
        fill: url(#SVGID_6_);
    }

    .st5 {
        opacity: 0.65;
        fill: url(#SVGID_7_);
    }

    .st6 {
        opacity: 0.65;
        fill: url(#SVGID_8_);
    }

    .st7 {
        opacity: 0.65;
        fill: url(#SVGID_9_);
    }

    .st8 {
        opacity: 0.65;
        fill: url(#SVGID_10_);
    }
</style>
                        <g id="BACKGROUND">
                        </g>
                        <g id="OBJECTS">
                            <g>
                                <defs>
                                    <rect id="SVGID_1_" width="750" height="500" />
                                </defs>
                                <clipPath id="SVGID_2_">
                                    <use xlink:href="#SVGID_1_" style="overflow:visible;opacity:0.65;" />
                                </clipPath>
                                <g class="st0">
                                    <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="27.7265"
                                                    y1="184.2158" x2="156.6296" y2="137.7641">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="0.34" style="stop-color:#FAFBFC" />
                                        <stop offset="0.7145" style="stop-color:#EDF0F2" />
                                        <stop offset="1" style="stop-color:#DEE3E6" />
                                    </linearGradient>
                                    <polygon class="st1" points="-16,-16 278,310 -23,292 -31,7    " />
                                    <linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="175.4757"
                                                    y1="367.3152" x2="151.4758" y2="503.5732">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="1" style="stop-color:#DEE3E6" />
                                    </linearGradient>
                                    <polygon class="st2" points="-28,333 350,566 -23,543    " />
                                    <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="293.3757"
                                                    y1="430.8185" x2="300.3435" y2="282.1734">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="1" style="stop-color:#DEE3E6" />
                                    </linearGradient>
                                    <polygon class="st3" points="-23,242 613,566 350,566 -28,333    " />
                                    <linearGradient id="SVGID_6_" gradientUnits="userSpaceOnUse" x1="401.2128"
                                                    y1="439.2213" x2="459.2773" y2="390.4471">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="1" style="stop-color:#DEE3E6" />
                                    </linearGradient>
                                    <polygon class="st4" points="464.5,603.5 212.5,205.5 684.5,593.5    " />
                                    <linearGradient id="SVGID_7_" gradientUnits="userSpaceOnUse" x1="536.0672"
                                                    y1="276.4095" x2="465.7038" y2="177.9008">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="1" style="stop-color:#DEE3E6" />
                                    </linearGradient>
                                    <polygon class="st5" points="278.5,309.7 750,182 750,339    " />
                                    <linearGradient id="SVGID_8_" gradientUnits="userSpaceOnUse" x1="294.8868"
                                                    y1="441.7101" x2="314.6288" y2="312.807">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="1" style="stop-color:#DEE3E6" />
                                    </linearGradient>
                                    <polygon class="st6" points="90,514 278,310 464,603    " />
                                    <linearGradient id="SVGID_9_" gradientUnits="userSpaceOnUse" x1="362.8745"
                                                    y1="231.9957" x2="346.6165" y2="101.9314">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="1" style="stop-color:#DEE3E6" />
                                    </linearGradient>
                                    <polygon class="st7" points="-23,188 769,314 764,359 -23,312    " />
                                    <linearGradient id="SVGID_10_" gradientUnits="userSpaceOnUse" x1="71.5524"
                                                    y1="422.5268" x2="36.7137" y2="520.0752">
                                        <stop offset="0" style="stop-color:#FFFFFF" />
                                        <stop offset="1" style="stop-color:#DEE3E6;stop-opacity:0" />
                                    </linearGradient>
                                    <polygon class="st8" points="-23,434.5 153.9,444.6 90,515 -10,515    " />
                                </g>
                            </g>
                        </g>
</svg>
                {/literal}
                <div class="parent-ul-tab col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                    <ul class="nav nav-pills" id="pills-tab-rules" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                    class="nav-link active"
                                    id="tab-description"
                                    data-toggle="pill"
                                    data-target="#content-tab-description"
                                    type="button"
                                    role="tab"
                                    aria-controls="content-tab-description"
                                    aria-selected="false">
                                <div class="parent-svg-tab">
                                    <i class="fa-sharp fa-light fa-message-exclamation"></i>
                                </div>
                                <span class="tab-text">##MoreExplain##</span>
                                <span class="tab-text-mobile" style="display:none;">توضیحات</span>
                            </button>
                        </li>
                        <li
                                class="nav-item"
                                role="presentation">
                            <button
                                    class="nav-link"
                                    id="tab-documents"
                                    data-toggle="pill"
                                    data-target="#content-documents"
                                    type="button"
                                    role="tab"
                                    aria-controls="content-documents"
                                    aria-selected="true">
                                <div class="parent-svg-tab">
                                    <i class="fa-light fa-books"></i>
                                </div>
                                <span class="tab-text">##Requireddocuments##</span>
                                <span class="tab-text-mobile" style="display:none;">مدارک</span>
                            </button>
                        </li>
                        <li
                                class="nav-item"
                                role="presentation">
                            <button
                                    class="nav-link"
                                    id="tab-cancel"
                                    data-toggle="pill"
                                    data-target="#content-cancel"
                                    type="button"
                                    role="tab"
                                    aria-controls="content-cancel"
                                    aria-selected="false">
                                <div class="parent-svg-tab">
                                    <i class="fa-light fa-file-xmark"></i>
                                </div>
                                <span class="tab-text">##Cancellationrules##</span>
                                <span class="tab-text-mobile" style="display:none;">کنسلی</span>

                            </button>
                        </li>
                        <li
                                class="nav-item"
                                role="presentation">
                            <button
                                    class="nav-link"
                                    id="tab-regulation"
                                    data-toggle="pill"
                                    data-target="#content-regulation"
                                    type="button"
                                    role="tab"
                                    aria-controls="content-regulation"
                                    aria-selected="false">
                                <div class="parent-svg-tab">
                                    <i class="fa-light fa-scale-unbalanced"></i>
                                </div>
                                <span class="tab-text">##TermsandConditions##</span>
                                <span class="tab-text-mobile" style="display:none;">عمومی</span>

                            </button>
                        </li>
                    </ul>
                </div>
                <div class="parent-content-tab-rules col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                    <div
                            class="d-flex flex-wrap tab-content w-100"
                            id="pills-tabContent-rules">
                        <div
                                class="tab-pane fade show active"
                                id="content-tab-description"
                                role="tabpanel"
                                aria-labelledby="tab-description">
                            <div class="parent-content">
                                {$objResult->arrayTour['infoTour']['description']}
                            </div>
                        </div>
                        <div
                                class="tab-pane fade "
                                id="content-documents"
                                role="tabpanel"
                                aria-labelledby="tab-documents">
                            <div class="parent-content">
                                {$objResult->arrayTour['infoTour']['required_documents']}
                            </div>
                        </div>
                        <div
                                class="tab-pane fade"
                                id="content-cancel"
                                role="tabpanel"
                                aria-labelledby="tab-cancel">
                            <div class="parent-content">
                                {$objResult->arrayTour['infoTour']['cancellation_rules']}
                            </div>
                        </div>
                        <div
                                class="tab-pane fade"
                                id="content-regulation"
                                role="tabpanel"
                                aria-labelledby="tab-regulation">
                            <div class="parent-content">
                                {$objResult->arrayTour['infoTour']['rules']}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section class="tour-information" id='tour-information-click'>
            <div class="parent-tour-information-item">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0 ">
                    <div class="tour-details">
                        <div class="box-data-top">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-4 p-0">
                                <div class="box-data-top-item">
                                    <div class="icone-data-tour">
                                        <i class="fa-light fa-clock"></i>
                                    </div>
                                    <div class="text-data-tour">
                                        <span class="box-data-top-titr">##Tourduration##</span>
                                        <span>{$objResult->arrayTour['infoTour']['day']} ##Day##</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-4 p-0">
                                <div class="box-data-top-item">
                                    <div class="icone-data-tour">
                                        <i class="fa-light fa-dumbbell"></i>
                                    </div>
                                    <div class="text-data-tour">
                                        <span class="box-data-top-titr">##TourDifficulties##</span>
                                        <span>
                                   {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'easy' } ##Easy## {/if}
                                            {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'average' } ##Average## {/if}
                                            {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'hard' } ##Hard## {/if}
                                            {if $objResult->arrayTour['infoTour']['tour_difficulties'] == 'very_hard' } ##VeryHard## {/if}
                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-4 p-0">
                                <div class="box-data-top-item">
                                    <div class="icone-data-tour">
                                        <i class="fa-light fa-barcode"></i>
                                    </div>
                                    <div class="text-data-tour">
                                        <span class="box-data-top-titr">##codeTour##</span>
                                        <span>{$objResult->arrayTour['infoTour']['tour_code']}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-4 p-0">
                                <div class="box-data-top-item">
                                    <div class="icone-data-tour">
                                        <i class="fa-light fa-barcode"></i>
                                    </div>
                                    <div class="text-data-tour">
                                        <span class="box-data-top-titr">##organizer##</span>
                                        <span>{$objResult->arrayTour['infoTour']['agency_name']}</span>
                                    </div>
                                </div>
                            </div>
                            <!--                           <div class="col-lg-4 col-md-3 col-sm-6 col-12 p-0">-->
                            <!--                               <div class="box-data-top-item">-->
                            <!--                                   <div class="icone-data-tour">-->
                            <!--                                       <i class="fa fa-earth-americas"></i>-->
                            <!--                                   </div>-->
                            <!--                                   <div class="text-data-tour">-->
                            <!--                                       <span class="box-data-top-titr">زبان</span>-->
                            <!--                                       <span>فارسی</span>-->
                            <!--                                   </div>-->
                            <!--                               </div>-->
                            <!--                           </div>-->
                        </div>
                        <div class="box-data-bottom">
                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-sm-12 col-12">
                                    <ul class="include">

                                        {foreach explode(',',$objResult->arrayTour['infoTour']['tour_services']) as $tour_service}
                                            <li class="list-unstyled">
                                                <i class="fa-solid fa-check"></i>
                                                {$tour_service}
                                            </li>
                                        {/foreach}

                                    </ul>
                                </div>
                                {*                                <div class="col-lg-6 col-md-6 col-sm-12 col-6">*}
                                {*                                    {if $objResult->arrayTour['infoTour']['tour_services_not_selected']}*}
                                {*                                    <ul class="exclude">*}

                                {*                                        <li class="list-unstyled">*}
                                {*                                            <i class="fa-regular fa-xmark"></i>*}
                                {*                                            ##Visa##*}
                                {*                                        </li>*}
                                {*                                        <li class="list-unstyled">*}
                                {*                                            <i class="fa-regular fa-xmark"></i>*}
                                {*                                            ##Lunch##*}
                                {*                                        </li>*}
                                {*                                        <li class="list-unstyled">*}
                                {*                                            <i class="fa-regular fa-xmark"></i>*}
                                {*                                            ##AdditionalServices##*}
                                {*                                        </li>*}


                                {*                                        {foreach explode(',',$objResult->arrayTour['infoTour']['tour_services_not_selected']) as $tour_service}*}
                                {*                                            <li class="list-unstyled">*}
                                {*                                                <i class="fa-solid fa-x"></i>*}
                                {*                                                {$tour_service}*}
                                {*                                            </li>*}
                                {*                                        {/foreach}*}
                                {*                                        {/if}*}
                                {*                                    </ul>*}
                                {*                                </div>*}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-12 px-2 d-none">
                    <div class="counter-card">
                        <div class="parent-img-counter">
                            <img
                                    src=""
                                    alt="img-counter" />
                        </div>
                        <div class="counter-info">
                            <h6>
                                <i class="fa-light fa-user"></i>
                                ایمون زائد
                            </h6>
                            <p>مدیر مسئول تور</p>
                            <div class="relationship-counter">
                                <a
                                        href="javascript:"
                                        class="phone-number-counter">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a
                                        href="javascript:"
                                        class="phone-number-counter">
                                    <i class="fa-brands fa-telegram"></i>
                                </a>
                                <a
                                        href="javascript:"
                                        class="phone-number-counter">
                                    <i class="fa-solid fa-phone"></i>
                                </a>
                                <a
                                        href="javascript:"
                                        class="phone-number-counter">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12 px-2 d-none">
                    <div class="modal-map">
                        <div id="g-map"></div>
                    </div>
                </div>
            </div>
        </section>
        <!--                <section class="hashtag-tour d-none">
                                   <div class="parent-hashtag">
                                       <a href="javascript:" class="item-hashtag-tour">
                                           تور گردشگری
                                       </a>
                                       <a href="javascript:" class="item-hashtag-tour">
                                           تور تهران گردی
                                       </a>
                                       <a href="javascript:" class="item-hashtag-tour">
                                           تور جاذبه های ایران
                                       </a>
                                       <a href="javascript:" class="item-hashtag-tour">
                                           تور دور اروپا
                                       </a>
                                   </div>
                           </section>-->

    </section>
    <div class="parent_comment_form">
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/comments/comments-type-2.tpl"
        comments=$objResult->arrayTour['comments']
        user_info=$user_info
        item_id=$objResult->arrayTour['infoTour']['id_same']
        section='tour'}
    </div>


</div>

<div class="content-ditail2">


</div>


<!-- Modal Filter -->
<div class="modal fade" id="filter_tour" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">##advancedsearch##</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="mdi mdi-close" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 col-xs-12 col_filter">
                        <span class="filter-title site-main-text-color">##Namehotel##</span>
                        <div class="filter-content_tour ">
                            <input type="text" placeholder="##Namehotel##" id="inputSearchHotelName"
                                   name="inputSearchHotelName">
                            <i class="fa fa-search fa-stack-1x form-hotel-item-searchHotelName-i site-main-text-color"></i>
                        </div>
                    </div>

                    <input type="hidden" name="inputSearchHotelStar" id="inputSearchHotelStar">
                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span class="filter-title site-main-text-color">  ##Starhotel##</span>
                            <div class="filter-content padb0">
                                <span class="event_star star_big mt-4" data-starnum="0"><i></i></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="inputSearchHotelMinPrice" id="inputSearchHotelMinPrice" value="">
                    <input type="hidden" name="inputSearchHotelMaxPrice" id="inputSearchHotelMaxPrice" value="">
                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span class="filter-title site-main-text-color"> ##Price## ({$iranCurrency})</span>
                            <div class="filter-content padb0">
                                <div class="filter-price-text">
                                    <span> <i></i> {$iranCurrency}</span>
                                    <span> <i></i> {$iranCurrency}</span>
                                </div>
                                <div id="slider-range"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span class="filter-title site-main-text-color">  ##Line##</span>
                            <div class="filter-content padb0">
                                <select class="js-example-basic-multiple select2"
                                        name="inputSearchHotelType[]" id="inputSearchHotelType" multiple="multiple">
                                    <option value="all">##All##</option>
                                    <option value="1">##Hotel##</option>
                                    <option value="2">##HotelApartments##</option>
                                    <option value="3">##Guesthouse##</option>
                                    <option value="4">##traditionalhouse##</option>
                                    <option value="5">##Traditionalhotel##</option>
                                    <option value="6">##Ecotourismresort##</option>
                                    <option value="7">##ForestHotel##</option>
                                    <option value="8">##RecreationalCulturalComplex##</option>
                                    <option value="9">##Boardinghouse##</option>
                                    <option value="10">##Motel##</option>
                                    <option value="12">##Villa##</option>
                                    <option value="13">##Inn##</option>
                                    <option value="14">##Residentialcomplex##</option>
                                    <option value="15">##Localhome##</option>
                                    <option value="16">##HotelVilla##</option>
                                    <option value="100">##Hostel##</option>
                                    <option value="101">##Boutique##</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {load_presentation_object filename="reservationBasicInformation" assign="objBasic"}
                    {$objBasic->showFacilities()}
                    <div class="col-md-6 col-xs-12 col_filter">
                        <div class="filtertip-searchbox">
                            <span class="filter-title site-main-text-color">  ##PossibilitiesHotel##</span>
                            <div class="filter-content padb0">
                                <select class="js-example-basic-multiple select2"
                                        name="inputSearchHotelFacilities[]" id="inputSearchHotelFacilities"
                                        multiple="multiple">
                                    {foreach $objBasic->listFacilities as $facilities}
                                        <option value="{$facilities['id']}">{$facilities['title']}</option>
                                        <option value="{$facilities['id']}">{$facilities['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 col-xs-12 col_filter col_filter_search">
                    <a class="btn site-bg-main-color site-secondary-text-color btn_search"
                       onclick="setFilterHotel();return false;">##Search##</a>
                </div>

            </div>
        </div>
    </div>
</div>

<form method="post" id="formHotel" action="" target="_blank">
    <input type="hidden" name="isShowReserve" id="isShowReserve" value="no">
</form>
{assign var="ArrayDate_FirstArray" value=reset($objResult->arrayTour['arrayDate'])}
{*<script type="text/javascript">*}
{*    getResultTourPackage('{$objResult->arrayTour['infoTour']['tour_code']}', '{$objResult->arrayTour['infoTour']['start_date']}', '{$typeTourReserve}');*}
{*    getResultTourPackage_newView('{$smarty.const.TOUR_ID}', '{$objResult->arrayTour['infoTour']['tour_code']}', '{$ArrayDate_FirstArray['startDate']}', '{$ArrayDate_FirstArray['endDate']}', '{$typeTourReserve}')*}
{*</script>*}


{literal}

    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script type="text/javascript">
       /*  $('.counter').counter({});

         $('.counter').on('counterStop', function () {
             $('.lazy_loader_flight').slideDown({
                 start: function () {
                     $(this).css({
                         display: "flex"
                     })
                 }
             });

         });*/


       $('.owl-count-day').owlCarousel({
          rtl:true,
          loop: false,
          margin: 15,
          dots: false,
          autoplay: false,
          autoplayTimeout: 15000,
          autoplaySpeed:3000,
          nav:false,
          stagePadding: 50,
          responsiveClass: true,
          responsive:{
             0:{
                items:1
             },
             500:{
                items:2
             },
             600:{
                items:4,
             },
             1000:{
                items:5,
             }
          }
       });


    </script>

    <script>
       $(function(){
          $('.event_star').voteStar({
             callback: function(starObj, starNum){
                $('#inputSearchHotelStar').val(starNum);
             }
          });
       });

       $(function () {
          $("#slider-range").slider({
             range: true,
             min:   parseInt($('#inputSearchHotelMinPrice').val()),
             max:  parseInt($('#inputSearchHotelMaxPrice').val()),
             step: 1000,
             animate: false,
             values: [parseInt($('#inputSearchHotelMinPrice').val()), parseInt($('#inputSearchHotelMaxPrice').val())],
             slide: function (event, ui) {

                var minRange = ui.values[0];
                var maxRange = ui.values[1];

                $('#inputSearchHotelMinPrice').val(minRange);
                $('#inputSearchHotelMaxPrice').val(maxRange);

                $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));
                $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));

             }
          });
       });

       function setFilterHotel() {

          let hotelNameSearch = $('#inputSearchHotelName').val();
          let starSearch = parseInt($('#inputSearchHotelStar').val());
          let minPriceSearch = parseInt($('#inputSearchHotelMinPrice').val());
          let maxPriceSearch = parseInt($('#inputSearchHotelMaxPrice').val());
          let facilitiesSearch = $('#inputSearchHotelFacilities').val();
          let hotelTypeSearch = $('#inputSearchHotelType').val();

          let listPackage = $('.divTableRow');
          listPackage.hide().filter(function () {

             let flagSearchHotelName = true;
             let flagSearchHotelStar = true;
             let flagSearchTypeSearch = true;
             let flagSearchFacilities = true;
             let flagSearchPrice = true;

             let listHotel = $(this).find(".divTableCell .packageinfo");
             listHotel.each(function () {

                if (hotelNameSearch != ''){
                   let hotelName = $(this).data("hotelname");
                   let searchName = hotelName.indexOf(hotelNameSearch);
                   if (searchName > -1){
                      flagSearchHotelName = true;
                   } else {
                      flagSearchHotelName = false;
                   }
                }

                if (starSearch > 0){
                   let hotelStar = parseInt($(this).data("hotelstar"), 10);
                   if (hotelStar <= starSearch){
                      flagSearchHotelStar = true;
                   } else {
                      flagSearchHotelStar = false;
                   }
                }

                if (hotelTypeSearch != null){
                   let hotelTypeCode = $(this).data("hoteltypecode").toString();
                   if (jQuery.inArray(hotelTypeCode, hotelTypeSearch) > -1){
                      flagSearchTypeSearch = true;
                   } else {
                      flagSearchTypeSearch = false;
                   }
                }

                if (facilitiesSearch != null){
                   let hotelFacilities = $(this).data("hotelfacilities");
                   hotelFacilities = hotelFacilities.split(',');
                   for ( let i = 0, l = facilitiesSearch.length; i < l; i++ ) {
                      if (jQuery.inArray(facilitiesSearch[i], hotelFacilities) == -1){
                         flagSearchFacilities = flagSearchFacilities && false;
                      }
                   }
                }

             });


             let prices = $(this).find('input[name*=RoomPrice]');
             prices.each(function () {
                let price  = $(this).val();
                if (price > 0 && !(price >= minPriceSearch && price <= maxPriceSearch)){
                   flagSearchPrice = flagSearchPrice && false;
                }
             });

             /*console.log('flagSearchHotelName', flagSearchHotelName);
             console.log('flagSearchHotelStar', flagSearchHotelStar);
             console.log('flagSearchTypeSearch', flagSearchTypeSearch);
             console.log('flagSearchFacilities', flagSearchFacilities);
             console.log('flagSearchPrice', flagSearchPrice);*/

             return flagSearchHotelName && flagSearchHotelStar && flagSearchTypeSearch && flagSearchFacilities && flagSearchPrice;
          }).show();

          setTimeout(function () {
             $('#filter_tour').removeClass('show');
          }, 200);
       }
    </script>



    <script src="assets/js/html5gallery.js"></script>
    <script>
       $(document).ready(function () {

          $('[data-toggle="tooltip"]').tooltip();



       });
    </script>
    <script>
       function openTab(cityName) {
          var i;
          var x = document.getElementsByClassName("city");
          for (i = 0; i < x.length; i++) {
             x[i].style.display = "none";
          }
          document.getElementById(cityName).style.display = "block";
       }
    </script>
    <script>
       $(document).ready(function () {
          /*$('.collapse__').click(function () {
              $('.mdi-chevron-down').toggleClass('mdi-chevron-up');
              $('#bundle-prices-109133301').toggleClass('show_hotels_');
          });*/

          var widthw = $(window).width();
          var hei = $(window).height();

          if (widthw < 768) {
             openTab('masir');
             $('#masirha_').addClass('active-tab');
             $('.n-mx-qeymat').addClass('fixedd');
             $('.n-mx-qeymat').css('bottom', 0);
          }


       });

       $(window).resize(function () {
          var widthw = $(window).width();
          var hei = $(window).height();

          if (widthw < 768) {
             $('.n-mx-qeymat').addClass('fixedd');
             $('.n-mx-qeymat').css('bottom', 0);
          }
          else {
             $('.n-mx-qeymat').removeClass('fixedd');
          }
       });
    </script>

    <script>
       $(document).ready(function () {
          var widthw = $(window).width();

          var $nav = $('#fixing_sc'),
             posTop = $nav.position().top;
          $(window).scroll(function () {
             if (widthw > 767) {
                var $hei_nav = $nav.height();
                var y = $(this).scrollTop();
                if (y > posTop) {
                   $nav.addClass('fixed_to_top');
                   $('#tabs11').css('margin-top', $hei_nav + 22);
                } else {
                   $nav.removeClass('fixed_to_top');
                   $('#tabs11').css('margin-top', '11px');
                }
             }

          });


          $('.entekab-date-click').click(function () {
             $('.scrollhereshowlist').removeClass('blou');
             $(this).parents('.scrollhereshowlist').addClass('blou');

          });
          var w = $(window).width();
          var ww = w - 160;
          $('.joz-div-xs').css('width', ww);


          $('.toggle-icon span').click(function () {
             $('.joz-toggle').toggleClass('display-joz');
             $('.toggle-icon span').toggleClass('mdi-arrow-up-thick');

          });

          $(".w3-bar button").click(function () {
             $('.w3-bar button').removeClass('active-tab');
             $(this).addClass('active-tab');
          });


          $('.tbl-div-tbl').click(function () {
             $(this).addClass('ezafe-class');
          });

          $('.toggle-div-tbl').click(function () {
             $('.tbl-div-tbl').removeClass('ezafe-class');
          });

       });

    </script>
    <script>
       $(window).resize(function () {
          var w = $(window).width();
          var ww = w - 100;
          $('.joz-div-xs').css('width', ww);
       })
    </script>

    <script type="text/javascript" src="assets/js/modal-login.js"></script>
    <script src="assets/js/scrollWithPage.min.js"></script>
    <script type="text/javascript">
       if($(window).width() > 990){
          $(".BaseTourBox_1").scrollWithPage(".tour_search_parrnet");
       }
       $.fn.blink = function (options) {
          var defaults = {delay: 500};
          var options = $.extend(defaults, options);
          return $(this).each(function (idx, itm) {
             setInterval(function () {
                if ($(itm).css("visibility") === "visible") {
                   $(itm).css('visibility', 'hidden');
                }
                else {
                   $(itm).css('visibility', 'visible');
                }
             }, options.delay);
          });
       };


       $(document).ready(function () {
          /* ===== Logic for creating fake Select Boxes ===== */
          $('.sel').each(function () {
             $(this).children('select').css('display', 'none');

             var $current = $(this);

             $(this).find('option').each(function (i) {
                if (i == 0) {
                   $current.prepend($('<div>', {
                      class: $current.attr('class').replace(/sel/g, 'sel__box')
                   }));

                   var placeholder = $(this).text();
                   $current.prepend($('<span>', {
                      class: $current.attr('class').replace(/sel/g, 'sel__placeholder'),
                      text: placeholder,
                      'data-placeholder': placeholder
                   }));

                   return;
                }

                $current.children('div').append($('<span>', {
                   class: $current.attr('class').replace(/sel/g, 'sel__box__options'),
                   text: $(this).text(),
                   val: $(this).val()
                }));
             });
          });

// Toggling the `.active` state on the `.sel`.
          $('.sel').click(function () {
             $(this).toggleClass('active');
          });

// Toggling the `.selected` state on the options.
          $('.btn--').click(function () {
             openTab('hotels');
             $('.w3-bar .w3-button').removeClass('active-tab');
             $('.w3-bar .w3-button:first-child').addClass('active-tab');
             $([document.documentElement, document.body]).animate({
                scrollTop: $("#tabs11").offset().top
             }, 2000);
          });


          $('.blink').blink({delay: 400});

          // hotelFacilities
          $('.contentHideMaxListItem ul.hotelFacilities').hideMaxListItems({
             'max': 6,
             'speed': 500,
             'moreText': '##Open## ([COUNT] ##Case##)'
          });

          $("#dynamicAdd").on("click", function (e) {
             e.preventDefault();
             $('.contentHideMaxListItem ul.hotelFacilities').append('<li>DYNAMIC LIST ITEM 1</li><li>DYNAMIC LIST ITEM 2</li><li>DYNAMIC LIST ITEM 3</li>');
             $('.content ul.hotelFacilities').hideMaxListItems({
                'max': 6,
                'speed': 500,
                'moreText': '##Open##([COUNT])'
             });

          });
          $("#dynamicRemove").on("click", function (e) {
             e.preventDefault();
             $('.contentHideMaxListItem ul.hotelFacilities> li').not(':nth-child(1),:nth-child(2),:nth-child(3)').remove();
             $('.contentHideMaxListItem ul.hotelFacilities').hideMaxListItems({
                'max': 6,
                'speed': 500,
                'moreText': '##Open## ([COUNT])'
             });
          });

          $(".slideDownHotelDescription").on("click", function () {
             $(this).siblings(".slideHotelDescriptionMin").addClass("slideHotelDescriptionMax");
             $(this).closest(".slideDownHotelDescription").addClass("displayiN");
             $(this).siblings(".slideUpHotelDescription").removeClass("displayiN");
          });

          $(".slideUpHotelDescription").on("click", function () {

             $(this).siblings(".slideHotelDescriptionMin").removeClass("slideHotelDescriptionMax");
             $(this).siblings(".slideDownHotelDescription").removeClass("displayiN");
             $(this).closest(".slideUpHotelDescription").addClass("displayiN");
          });

          //DistanceToImportantPlaces
          $(".slideDownHotelNear").click(function () {
             $(".slideHotelNearMin").addClass("slideHotelNearMax");
             $(".slideDownHotelNear").addClass("displayN");
             $(".slideUpHotelNear").removeClass("displayN");
          });
          $(".slideUpHotelNear").click(function () {
             $(".slideHotelNearMin").removeClass("slideHotelNearMax");
             $(".slideDownHotelNear").removeClass("displayN");
             $(".slideUpHotelNear").addClass("displayN");
          });

          $("body").delegate(".DetailPrice", "click", function () {
             $(this).parent().parent().next(".RoomDescription").toggleClass("trShowHideHotelDetail");
             $(this).parent().parent().next(".RoomDescription").find(".DetailPriceView").toggleClass("displayiN");
             $(this).children(".DetailPrice .fa").toggleClass("fa-caret-down fa-caret-up");
          });
       });
    </script>
    <script>
       $(document).ready(function () {

          $('#filter_btn_tour').click(function () {
             $('#filter_tour').addClass('show');
          });
          $('#filter_tour .modal-dialog').bind('click', function (e) {
             //as when we click inside the menu it bubbles up and closes the menu when it hits html we have to stop the propagation while its open
             e.stopPropagation();
          });
          $('#filter_tour').click(function () {
             $(this).removeClass('show');
          });

          $('.close').click(function () {
             $('#filter_tour').removeClass('show');
          });

       });
    </script>
    <script>
       $(function () {
          $('ul.menu-quick li a').bind('click', function (event) {

             var $anchor = $(this);
             var headerHeight = $('header').height();
             $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - headerHeight

             }, 1500, 'easeInOutExpo');

             var x = $anchor.attr('href');
             if (x == '#showTableHotelRoomForAjax') {
                getInfoHotelRoomPriceForAjax();
             }

             event.preventDefault();

          });
       });
    </script>

    <script>
       $(document).ready(function () {
          $('.mb-0').hover(function () {
             $(this).parents('.rounded').find('.hotelname img').css('display', 'block');
          });
          $('.mb-0').mouseleave(function () {
             $(this).parents('.rounded').find('.hotelname img').css('display', 'none');
          });
       });
    </script>

    <script>
       /*var downloadButton = document.querySelector('.buttond--');
       if (downloadButton) {
           downloadButton.addEventListener('click', function (event) {
               event.preventDefault();

               /!* Start loading process. *!/
               downloadButton.classList.add('loading');

               /!* Set delay before switching from loading to success. *!/
               window.setTimeout(function () {
                   downloadButton.classList.remove('loading');
                   downloadButton.classList.add('success');
               }, 3000);

               /!* Reset animation. *!/
               window.setTimeout(function () {
                   downloadButton.classList.remove('success');
               }, 8000);
           });
       };*/
    </script>
    <script src="assets/js/html5gallery.js"></script>


<script>
   $(document).ready(function () {


      $('.share_js').each(function (){
         $(this).attr('data-title','{/literal}{$objResult->arrayTour['infoTour'][$objFunctions->ChangeIndexNameByLanguage($smarty.const.SOFTWARE_LANG,'tour_name')]}{literal}')
         $(this).attr('data-url','https://{/literal}{$smarty.server['HTTP_HOST']}{$smarty.server['REQUEST_URI']}{literal}')
      })

      // =============number input
      function add(value1, value2) {
         var currentVal = parseInt($("#countt" + value1 + value2).val());
         if (!isNaN(currentVal)) {
            $("#countt" + value).val(currentVal + 1);
         }
      }

      function minus(value1, value2) {
         var currentVal = parseInt($("#countt" + value1 + value2).val());
         if (!isNaN(currentVal)) {
            if (currentVal > 0) {
               $("#countt" + value).val(currentVal - 1);
            }
         }
      }

      function closeOver(f, value) {
         return function () {
            f(value);
         };
      }

      $(function () {
         var numButtons = 6;
         var countPackage = parseInt($('#countPackage').val());
         for (var j = 0; j <= countPackage; j++) {
            for (var i = 1; i <= numButtons; i++) {
               $("#add" + i + j).click(closeOver(add, i, j));
               $("#minus" + i + j).click(closeOver(minus, i, j));
            }
         }

      });


      /*$('body').on('click', 'i.plus', function () {
          var packageId = $(this).attr('packageId');
          calculatePricesTour(packageId, 'countt');
      });
      $('body').on('click', 'i.minus', function () {
          var packageId = $(this).attr('packageId');
          calculatePricesTour(packageId, 'countt');
      });*/
      $('.mBox').mBox({
         imagesPerPage: 4 ,
         displayThumbnails: true
      });
   });
   let openAccordion = document.querySelector(".open-accordion");
   let openAccordionS = document.querySelector(".open-accordion > span");
   let openAccordionI = document.querySelector(".open-accordion > i");
   openAccordion.addEventListener('click', function () {

      if (openAccordionS.innerText === 'باز کردن همه'){
         $('.collapse').collapse('show');
         openAccordionS.innerText = 'بسته شدن';
         openAccordionI.classList.add('fa fa-lock');
         openAccordionI.classList.remove('fa fa-lock-open');


      }else{
         $('.collapse').collapse('hide');
         openAccordionS.innerText = 'باز کردن همه';
         openAccordionI.classList.add('fa fa-lock-open');
         openAccordionI.classList.remove('fa fa-lock');
      }
   });
   $('.owl-tour-image').owlCarousel({
      rtl:true,
      loop:false,
      margin:5,
      nav:false,
      navText: ["<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M505 273c9.4-9.4 9.4-24.6 0-33.9L369 103c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l95 95L24 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l406.1 0-95 95c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273z\"/></svg>","<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d=\"M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z\"/></svg>"],
      autoplay: false,
      autoplayTimeout: 5000,
      autoplaySpeed:1000,
      dots:false,
      stagePadding: 70,
      responsive:{
         0:{
            items:1,
         }
      }
   });

</script>

    <script src="assets/js/sharer.min.js"></script>




{/literal}