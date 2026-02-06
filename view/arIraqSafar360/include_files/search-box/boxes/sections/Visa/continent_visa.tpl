<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="form-group">
  <select data-placeholder="القارة" name="visa_continent"
          id="visa_continent"
          class="select2_in  select2-hidden-accessible continent-visa-js"
          onchange="fillComboByContinent(this)" tabindex="-1"
          aria-hidden="true">
    <option value="">##ChoseOption##...</option>
	{foreach $continents as $continent}
    <option value="{$continent['id']}">{$continent['titleFa']}</option>
   {/foreach}
  </select>
 </div>
</div>