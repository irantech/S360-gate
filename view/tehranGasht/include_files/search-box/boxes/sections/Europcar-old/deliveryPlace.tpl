
<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="##recivePlace##"
                name="delivery_place_rent_car"
                id="delivery_place_rent_car"
                class="select2_in select2-hidden-accessible select-delivery-place-rent-car-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {foreach $obj_main_page->getCarCityList() as $key => $city}
                <option value="{$city['id']}">
                     {$city['name']}
                </option>
            {/foreach}
            <option value="202">سایر</option>
        </select>
    </div>
</div>