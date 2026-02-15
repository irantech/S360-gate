<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
<div class="form-group">
<select aria-hidden="true" class="select-route-bus-js select-origin-route-bus-js" data-placeholder="نام شهر مبدأ" id="origin_bus" name="origin_bus" tabindex="-1">
<option value="">##ChoseOption##...</option>
{*{foreach $cities as $city}*}
{*<option value="{$city['id']}">{$city['text']}</option>*}
{*{/foreach}*}
</select>
</div>
</div>