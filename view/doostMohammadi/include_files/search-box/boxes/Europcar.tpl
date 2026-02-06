{assign var="type_data" value=['is_active'=>1 , 'limit' =>30 , 'order' =>'ASC']}
{load_presentation_object filename="mainCity" assign="objCity"}
{assign var='listTypeCar' value=$obj_main_page->getTypeCar($type_data)}
<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Europcar">
    <h4 class='title-searchBox-mobile'>جستجو برای اجاره خودرو</h4>
    <div class="d-flex flex-wrap gap-search-box">
        <div class="parent-empty-search-box"></div>
        <div class="d-flex flex-wrap w-100">
            <form data-action="/" method="post" target="_blank" class="d_contents"
                  name="cartype_rentCar_js" id="cartype_rentCar_js">
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M127.7 106.8L103.4 176H408.6l-24.2-69.2c-5.6-16-20.8-26.8-37.8-26.8H165.4c-17 0-32.1 10.7-37.8 26.8zm-79.6 82L82.3 90.9C94.7 55.6 128 32 165.4 32H346.6c37.4 0 70.7 23.6 83.1 58.9l34.3 97.9C492.6 205.4 512 236.4 512 272v80 48 56c0 13.3-10.7 24-24 24s-24-10.7-24-24V400H48v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V400 352 272c0-35.6 19.3-66.6 48.1-83.2zM416 224H96c-26.5 0-48 21.5-48 48v80H464V272c0-26.5-21.5-48-48-48zM112 256a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm256 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
                        </i>
                        <div class="caption-input-search-box">انتخاب خودرو</div>
                        <select data-placeholder="  نوع خودرو"
                                name="cartype_rentCar" id="cartype_rentCar"
                                class="select2  select2-hidden-accessible"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            {foreach $listTypeCar as $car}
                                <option value="{$car['id']}">{$car['title']}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                        </i>
                        <label for='rentdate_rentCar' class="caption-input-search-box">تاریخ اجاره خودرو</label>
                        <input type="text"
                               class="init-shamsi-datepicker  form-control  rent-start-date-js"
                               name="rentdate_rentCar" id="rentdate_rentCar"
                               placeholder="تاریخ اجاره">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"></path></svg>
                        </i>
                        <div class="caption-input-search-box">شهر اجاره خود را انتخاب کنید</div>
                        <select data-placeholder="   محل اجاره"
                                name="rentstation_rentCar" id="rentstation_rentCar"
                                class="select2  select2-hidden-accessible"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            {foreach $objCity->getCityAll() as $key => $city}
                                <option value="{$city['id']}">
                                    استان {$city['name']}
                                </option>
                            {/foreach}
                            <option value="202">سایر</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"></path></svg>
                        </i>
                        <label for='dept_rentCar' class="caption-input-search-box">تاریخ تحویل خودرو</label>
                        <input type="text"
                               class="init-shamsi-datepicker  form-control  delivery_rent-car-date-js"
                               name="dept_rentCar" id="dept_rentCar"
                               placeholder="تاریخ تحویل">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
                    <div class="parent-input-search-box">
                        <i class="parent-svg-input-search-box">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"></path></svg>
                        </i>
                        <div class="caption-input-search-box">شهر محل تحویل خودرو</div>
                        <select data-placeholder=" محل تحویل"
                                name="deliverystation_rentCar"
                                id="deliverystation_rentCar"
                                class="select2  select2-hidden-accessible"
                                tabindex="-1" aria-hidden="true">
                            <option value="">انتخاب کنید...</option>
                            {foreach $objCity->getCityAll() as $key => $city}
                                <option value="{$city['id']}">
                                    استان {$city['name']}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
                    <button type="button" onclick="rentcar_local()" class="btn theme-btn seub-btn b-0">
                        <span>جستجو</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>