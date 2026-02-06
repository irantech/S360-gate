<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
<select aria-hidden="true" class="select2_in entertainment-destination-country-js select2-hidden-accessible" data-placeholder="انتخاب کشور مقصد" id="select_entertainment_country" name="select_entertainment_country" onchange="getEntertainmentCities($(this))" tabindex="-1">
<option value="">##ChoseOption##...</option>
{foreach $countries as $country}
<option  "" value="{$country['id']}">{$country['name']}</option>
{/foreach}
</select>
</div>
</div>