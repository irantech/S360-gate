{load_presentation_object filename="mainCity" assign="objCity"}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
    <div class="form-group">
        <select data-placeholder="محل تحویل"
                name="delivery_place_rent_car"
                id="delivery_place_rent_car"
                class="select2_in select2-hidden-accessible select-delivery-place-rent-car-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {foreach $objCity->getCityAll() as $key => $city}
                <option value="{$city['id']}">
                    شهر {$city['name']}
                </option>
            {/foreach}
            <option value="202">انتخاب دیگر</option>
        </select>
    </div>
</div>