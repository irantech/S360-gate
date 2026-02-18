{assign var="type_data" value=['is_active'=>1 , 'limit' =>30 , 'order' =>'ASC']}
{assign var='listTypeCar' value=$obj_main_page->getTypeCar($type_data)}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
    <div class="parent-input-search-box">
        <i class="parent-svg-input-search-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M127.7 106.8L103.4 176H408.6l-24.2-69.2c-5.6-16-20.8-26.8-37.8-26.8H165.4c-17 0-32.1 10.7-37.8 26.8zm-79.6 82L82.3 90.9C94.7 55.6 128 32 165.4 32H346.6c37.4 0 70.7 23.6 83.1 58.9l34.3 97.9C492.6 205.4 512 236.4 512 272v80 48 56c0 13.3-10.7 24-24 24s-24-10.7-24-24V400H48v56c0 13.3-10.7 24-24 24s-24-10.7-24-24V400 352 272c0-35.6 19.3-66.6 48.1-83.2zM416 224H96c-26.5 0-48 21.5-48 48v80H464V272c0-26.5-21.5-48-48-48zM112 256a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm256 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg>
        </i>
        <div class="caption-input-search-box">انتخاب خودرو</div>
        <select data-placeholder="  نوع خودرو"
                name="type_rent_car" id="type_rent_car"
                class="select2  select2-hidden-accessible  type_rent_car-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {foreach $listTypeCar as $car}
                <option value="{$car['id']}">{$car['title']}</option>
            {/foreach}
        </select>
    </div>
</div>