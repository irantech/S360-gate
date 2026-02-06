<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
    <div class="form-group">
        <select aria-hidden="true" class="select2 select2-hidden-accessible"
                data-placeholder=" محل تحویل" id="deliverystation_rentCar"
                name="deliverystation_rentCar" tabindex="-1">
            <option value="">##ChoseOption##...</option>
            {foreach $objCity->getCityAll() as $key => $city}
                <option value="{$city['id']}">
                    استان {$city['name']}
                </option>
            {/foreach}
        </select>
    </div>
</div>
