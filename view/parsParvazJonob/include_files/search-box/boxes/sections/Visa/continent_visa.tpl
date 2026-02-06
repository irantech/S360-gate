<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
<select aria-hidden="true" class="select2_in select2-hidden-accessible continent-visa-js" data-placeholder=" قاره" id="visa_continent" name="visa_continent" onchange="fillComboByContinent(this)" tabindex="-1">
 {foreach $continents as $continent}
<option value="">##ChoseOption##...</option>
<option value="{$continent['id']}">{$continent['titleFa']}</option>
{/foreach}
</select>
</div>
</div>