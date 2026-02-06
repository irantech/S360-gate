<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
<div class="form-group">
<select aria-hidden="true" class="select-route-bus-js select-destination-route-bus-js select2-hidden-accessible select2" data-placeholder="نام شهر مقصد" id="destination_bus" name="destination_bus" tabindex="-1">
<option value="">##ChoseOption##...</option>
{foreach $cities as $city}
<option value="{$city['id']}">{$city['text']}</option>
{/foreach}
</select>
</div>
</div>