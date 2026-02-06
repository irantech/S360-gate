<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
<div class="form-group">
<select aria-hidden="true" class="select2_in DeptYearOnChange_js select2-hidden-accessible internal-date-travel-tour-js" data-placeholder="travel date" id="tourDeptDateLocal" name="tourDeptDateLocal" tabindex="-1">
<option value="">##ChoseOption##...</option>
 {foreach $date_tour as $date}
<option value="{$date['value']}">{$date['text']}</option>
{/foreach}
 </select>
</div>
</div>