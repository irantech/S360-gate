{load_presentation_object filename="entertainment" assign="objEntertainment"}
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('entertainment_search_advertise')}
{*{$smarty.const.CATEGORY_ID}*}
{assign var="EntertainmentSingleCategories" value=$objEntertainment->GetData('',$smarty.const.CATEGORY_ID)}
{assign var="params_category" value=['parent_id'=>0, 'city_id'=>$smarty.const.CITY_ID]}
{assign var="EntertainmentCategories" value=$objEntertainment->getCategories($params_category)}
{assign var="EntertainmentGetParentCategory" value=$objEntertainment->getParentCategory($smarty.const.CATEGORY_ID)}
{assign var="params_category" value=['parent_id'=>$EntertainmentGetParentCategory['id'], 'city_id'=>$smarty.const.CITY_ID]}
{assign var="EntertainmentSubCategories" value=$objEntertainment->getSubCategories($params_category)}
{assign var="EntertainmentCountries" value=$objEntertainment->getCountries()}
{assign var="EntertainmentCities" value=$objEntertainment->getCities(['country_id'=>$smarty.const.COUNTRY_ID])}
{assign var="params_category" value=['parent_id'=>$EntertainmentGetParentCategory['id'], 'city_id'=>$smarty.const.CITY_ID]}
{*{assign var="EntertainmentSubCategories" value=$params_category}*}
<input type="hidden" id="url_country_id" value="'{$smarty.const.COUNTRY_ID}'">
<input type="hidden" id="url_city_id" value="'{$smarty.const.CITY_ID}'">
<input type="hidden" id="url_category_id" value="'{$smarty.const.CATEGORY_ID}'">

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/fun-en.css'>
{else}
    <link rel='stylesheet' href='assets/styles/fun.css'>
{/if}


<div class="BaseModule w-100 row">
    <span data-target="PageUrl" data-value="{$smarty.const.ROOT_ADDRESS}"></span>
    <!-- FILTERS -->
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 nopad ">
        <div class="sidebar-right-parent">
            <div class="filterBox mb-0">
                <div class="filtertip_hotel parent_sidebar tours_loc_maining site-bg-main-color site-bg-color-border-bottom ">
                    <p style="text-align: right; display: inline-block;" class="txt14">
                      ##Entertainment##
                    </p>
                    <span class="silence_span">
                        <span></span>##NoEntertainmentFound##
                    </span>
                    <div class="open-sidebar-parvaz" onclick="showSearchBoxTicket()">
                        ##ChangeSearchType##
                    </div>
                </div>
            </div>
            <div class="s-u-update-popup-change">
                <div class="filterBox mb-0">

                    <div class="filtertip-searchbox filtertip_searchbox_35_ mb-3">
                        <div class="parent-col-right">

                            <div class="section_in_searchbox">
                                <div class="title-input-search">##Country##</div>
                                <div class="form-hotel-item form-hotel-item-searchBox mb-1">
                                    <div data-mode="ajax" data-target="BaseCountryId" class="select">
                                        <select onchange="GetCitiesOnSelectBox($(this),'{$smarty.const.COUNTRY_ID}','{$smarty.const.CITY_ID}','{$smarty.const.CATEGORY_ID}')" data-target="value"
                                                id="EntertainmentCountry" class="form-control select2">category_id
                                            <option value="all">##All##</option>
                                            {foreach key=key item=item from=$EntertainmentCountries}
                                                <option {if $item.id eq $smarty.const.COUNTRY_ID}selected{/if} value="{$item.id}">
                                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                        {$item.name}
                                                    {else}
                                                        {$item.name_en}
                                                    {/if}

                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="section_in_searchbox">
                                <div class="title-input-search">##City##</div>
                                <div class="form-hotel-item form-hotel-item-searchBox mb-1">
                                    <div data-mode="ajax" data-target="BaseCityId" class="select">
                                        <select onchange="GetCategoriesOnSelectBox($(this),'0','{$smarty.const.CATEGORY_ID}')" data-target="value"
                                                id="EntertainmentCity" class="form-control select2">
                                            <option value="all">##All##</option>
                                            {foreach key=key item=item from=$EntertainmentCities}
                                                <option {if $item.id eq $smarty.const.CITY_ID}selected{/if} value="{$item.id}">
                                                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                                        {$item.name}
                                                    {else}
                                                        {$item.name_en}
                                                    {/if}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="section_in_searchbox">
                                <div class="title-input-search">##EntertainmentBaseCategoy##</div>
                                <div class="form-hotel-item form-hotel-item-searchBox mb-1">
                                    <div data-mode="ajax" data-target="BaseCategoryId" class="select">
                                        <select onchange="GetSubCategoriesOnSelectBox($(this).val())" data-target="value"
                                                id="EntertainmentCategory" class="form-control select2">
                                            {foreach key=key item=item from=$EntertainmentCategories}
                                                <option {if $item.id == $EntertainmentGetParentCategory['id']}
                                                    selected
                                                {/if} value="{$item.id}">{$item.title}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="section_in_searchbox">
                                <div class="title-input-search">##EntertainmentSubCategoy##</div>
                                <div class="form-hotel-item form-hotel-item-searchBox mb-1">
                                    <div data-mode="ajax" data-target="CategoryId" class="select">
                                        <select data-target="value" class="form-control select2" id="EntertainmentSubCategory">
                                            {foreach key=key item=item from=$EntertainmentSubCategories}
                                                <option {if $item.id eq $smarty.const.CATEGORY_ID}selected{/if} value="{$item.id}">{$item.title}</option>
                                            {/foreach}
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="form-hotel-item  form-hotel-item-searchBox-btn">
                                <div class="input">
                                    <button class="site-bg-main-color" type="button" id="searchHotelLocal"
                                            onclick="GetEntertainmentData($('#EntertainmentCountry').val(),$('#EntertainmentCity').val(),$('#EntertainmentSubCategory').val(),'','',$(this),true)">##Search##
                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="filterBox mb-0 filter-parent" id="s-u-filter-wrapper">
                    <span class="s-u-close-filter"></span>
                    <div class="filtertip-searchbox filtertip_searchbox_35_ mt-0 mb-3">
                        <span class="filter-title"> ##Searchname##</span>
                        <div class="filter-content padb0">
                            <input type="text" class="form-hotel-item-searchHotelName" placeholder="##Name##"
                                   id="inputSearch">
                            <i class="fa fa-search fa-stack-1x form-hotel-item-searchHotelName-i site-main-text-color"></i>
                        </div>
                    </div>


                    <div class="filtertip-searchbox filtertip_searchbox_35_ mt-0 mb-3">
                        <span class="filter-title"> ##Price## (##Rial##)</span>
                        <div class="filter-content padb0">
                            <div class="filter-price-text">
                                <span> <i></i> </span> -
                                <span> <i></i> </span>
                            </div>
                            <div id="slider-range"></div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- LIST CONTENT-->
    <div class="col-lg-9 col-md-12  col-sm-12 col-xs-12 " id="result">

        <div class="sort-by-section clearfix box">
            <div class="info-login">
                <div class="head-info-login">
                    <span class="site-bg-main-color site-bg-color-border-right-b">
                                   ##Sortby##
                    </span>
                </div>
                <div class="form-sort hotel-sort">


                    {*<div class="s-u-form-input-number form-item form-item-sort countTiket">*}
                    {*<p>##Result##:<var>{$objResult->countTour}</var><kbd>##Tour##</kbd></p>*}
                    {*</div>*}
                    <div class="s-u-form-input-number form-item form-item-sort list_grid">
                        <a id="view_grid_a" data-toggle="tooltip" data-placement="top" title="##Network##"
                           class="view_list_grid active_g_list_a">
                            <i style="font-size: 35px;" class="zmdi zmdi-view-module site-main-text-color"></i></a>

                        <a id="view_list_a" data-toggle="tooltip" data-placement="top" title="##List##"
                           class="view_list_grid "><i style="font-size: 40px;"
                                                                     class="zmdi zmdi-view-list-alt site-main-text-color"></i></a>

                        <div class="filter_search_mobile_res">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" >
                              <g>
                                  <g xmlns="http://www.w3.org/2000/svg">
                                      <path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z" fill="#009aff" data-original="#000000" style="" class=""></path>
                                      <path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" fill="#009aff" data-original="#000000" style="" class=""></path>
                                      <path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" fill="#009aff" data-original="#000000" style="" class=""></path>
                                      <path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z" fill="#009aff" data-original="#000000" style="" class=""></path>
                                  </g>
                              </g>
                           </svg>
                            <span>##Filter## </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {if !empty($advertises) }
        <div class="advertises mb-2">
            {foreach $advertises as $item}
            <div class="advertise-item">
                <a class='items-ads' href="javascript:">
                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['image']}" alt="{$item['title']}">
                </a>
            </div>
            {/foreach}
        </div>
        {/if}
        <div class="BaseDiv actived_entertainment_grid">
            <div class="RepeatableDiv counter-0 d-none col-md-4" data-hotelname="">

                <div class="hotel-result-item hotelResultItem carItem p-0 normal-loop-box-style">

                    <div data-mode="parentAjax" data-target="discount" style="top: 6px"
                         class="ribbon-hotel site-bg-color-dock-border-top">
                        <span class="site-bg-main-color"><span data-target="value"></span></span>
                    </div>
                    <div class="col-md-12 tasvir_tour nopad">
                        <div data-mode="ajax" data-target="BaseUrl" class="hotel-result-item-image  site-bg-main-color-hover height240">
                            <div href="{$smarty.const.ROOT_ADDRESS}/detailEntertainment/"
                               data-mode="ajax" data-target="pic"
                              >
                                <img data-src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/"
                                     data-target="value" alt="awd">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 res_tour_matn nopad">
                        <div class="hotel-result-item-content tour-result-item-content height240">

                            <div data-mode="ajax" data-target="BaseUrl" style="padding: 15px 8px;" class=" col-md-12">
                                <div data-mode="ajax" data-target="title"
                                  >
                                    <b data-target="value" class="hotel-result-item-name site-main-text-color"></b>
                                </div>


                                <span
                                      class="hotel-result-item-content-location site-main-text-color fa-map-marker">
                                    <span>##Location##:
                                        <div data-mode="ajax" data-target="RCountryTitle">
                                            <span class="p-0" data-target="value"></span>
                                        </div> /
                                         <div data-mode="ajax" data-target="RCityTitle">
                                            <span class="p-0" data-target="value"></span>
                                        </div>
                                    </span>
                                </span>



                                <span data-mode="ajax" data-target="BaseCategoryTitle"
                                      class="hotel-result-item-content-location site-main-text-color fa-map-marker">
                                    <span>##EntertainmentBaseCategoy##:
                                        <span class="p-0" data-target="value"></span>
                                    </span>
                                </span>

                                <span data-mode="ajax" data-target="CategoryTitle"
                                      class="hotel-result-item-content-location site-main-text-color fa-map-marker width100">
                            <span>
                                ##EntertainmentSubCategoy##
                                &nbsp;:&nbsp;
                                <span class="p-0" data-target="value"></span>
                            </span>
                        </span>

                            </div>

                            <div class="col-md-12 rows-btn-- pb-2 pt-2">
                                <div class="row">

                        <span data-mode="ajax" data-target="BaseUrl" class="w-100 p-2 tour-result-item-right right-start-price--">
                            <div class="" data-mode="ajax" data-target="discountPrice"
                               href=""
                               target="_blank">
                                <div class="discountPrice d-flex justify-content-between" data-mode="ajax" data-target="price">
                                </div>
                            </div>
                        </span>


                         <span data-mode="ajax" data-target="BaseUrl" class="tour-result-item-left">

                            <a onclick='loadingToggle($(this))'
                                style="position: relative"
                                href="" class="intertainment-detail bookbtn mt1  site-bg-main-color site-main-button-color-hover ml-0">
                                ##Shownformation##
                            </a>
                             <div class='form-append'> </div>

                        </span>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<script src="assets/js/scrollWithPage.min.js"></script>
<script src="assets/js/script.js"></script>
{*<script src="assets/js/custom.js"></script>*}
<script src="assets/js/customForEntertainment.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        if($(window).width() > 990){
            $(".sidebar-right-parent").scrollWithPage(".BaseModule");
        }

        GetEntertainmentData('{$smarty.const.COUNTRY_ID}','{$smarty.const.CITY_ID}','{$smarty.const.CATEGORY_ID}','{$smarty.get.is_request}');

       {*alert({$smarty.get.is_request})*}
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 90000000,
            step: 50000,
            animate: false,
            values: [0, 90000000],
            slide: function (event, ui) {

                let minRange = ui.values[0];
                let maxRange = ui.values[1];

                $(".filter-price-text span:nth-child(2) i").html(addCommas(minRange));
                $(".filter-price-text span:nth-child(1) i").html(addCommas(maxRange));

                let hotels = $(".RepeatableDiv");
                hotels.hide().filter(function () {
                    let price = parseInt($(this).find('[data-mode="ajax"][data-target="price"] [data-target="value"]').text(), 10);
                    return price >= minRange && price <= maxRange;
                }).show();

            }
        });
        $('body').on('click', '.filter-title', function () {
            $(this).parent().find('.filter-content').slideToggle();
            $(this).parent().toggleClass('hidden_filter');
        })
        //filter
        $('.filter_search_mobile_res').click(function (){
            $('#s-u-filter-wrapper').css('left', '0').css('opacity', '1');
        });
        $('#s-u-filter-wrapper .s-u-close-filter').click(function (){
            $('#s-u-filter-wrapper').css('left', '-500px').css('opacity', '0');
        });


        $('body').on('click', '#s-u-filter-wrapper', function (e) {

            e.stopPropagation();

        });

if($(window).width() < 767) {
    $('body').on('click', function () {
        $('#s-u-filter-wrapper').css('left', '-500px').css('opacity', '0');
    })

}



    });
    //change search
    function showSearchBoxTicket() {
        $(".open-sidebar-parvaz").toggleClass('clos-sidebar-parvaz');

        $(".s-u-update-popup-change  > .filterBox").toggleClass('open-search-box');
    }
</script>