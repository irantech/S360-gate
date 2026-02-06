<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
<select aria-hidden="true" class="select2_in select2-hidden-accessible international-destination-city-tour-js" data-placeholder="شهر مقصد" id="tourDestinationCityPortal" name="tourDestinationCityPortal" tabindex="-1">
<option value="">##ChoseOption##...</option>
 {foreach $date_tour as $date}
<option value="{$date['value']}">{$date['text']}</option>
{/foreach}
 </select>
</div>
</div>