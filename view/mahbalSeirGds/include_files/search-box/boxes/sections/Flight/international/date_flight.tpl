<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search">
<div class="form-group">
<input class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} deptCalendar-en {else} deptCalendar {/if} form-control went departure-date-international-js" id="departure_date_international" name="departure_date_international" placeholder="##Enterdate##" readonly="" type="text"/>
<i class="fal fa-calendar-alt"></i>
</div>
<div class="form-group">
<input class="form-control return_input2 {if $smarty.const.SOFTWARE_LANG neq 'fa'} returnCalendar-en {else} returnCalendar {/if}  international-arrival-date-js" disabled="" id="arrival_date_international" name="arrival_date_international" placeholder="##Exitdate##" readonly="" type="text"/>
<i class="fal fa-calendar-alt"></i>
</div>
</div>