<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search">
<div class="form-group">
<input class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} deptCalendar-en {else} deptCalendar {/if} form-control went departure-date-internal-js" id="departure_date_internal" name="departure_date_internal" placeholder="##Enterdate##" readonly="" type="text"/>
<i class="fal fa-calendar-alt"></i>
</div>
<div class="form-group">
<input class="checktest {if $smarty.const.SOFTWARE_LANG neq 'fa'} returnCalendar-en {else} returnCalendar {/if} form-control return_input internal-arrival-date-js" disabled="" id="arrival_date_internal" name="arrival_date_internal" placeholder="##Exitdate##" readonly="" type="text"/>
<i class="fal fa-calendar-alt"></i>
</div>
</div>