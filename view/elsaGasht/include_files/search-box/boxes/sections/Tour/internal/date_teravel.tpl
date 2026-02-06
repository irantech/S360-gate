<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
 {assign var="date_tour" value=$obj_main_page->datesTour()}

 <div class="form-group">
<select aria-hidden="true" class="select2_in DeptYearOnChange_js select2-hidden-accessible internal-date-travel-tour-js" data-placeholder="تاریخ مسافرت" id="tourDeptDateLocal" name="tourDeptDateLocal" tabindex="-1">
<option value="">##ChoseOption##...</option>
 {foreach $date_tour as $date}
<option value="{$date['value']}">{$date['text']}</option>
{/foreach}
 </select>
</div>
</div>