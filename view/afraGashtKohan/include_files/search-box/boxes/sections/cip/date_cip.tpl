<div class="{if isset($col) } {$col} {else} col-lg-2{/if} col-md-6 col-sm-6 col-12 cip col_search date_search">
    <div class="form-group">
        <input type="text"
               autocomplete="off"
               readonly=""
               class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} init-miladi-datepicker {else} init-shamsi-datepicker {/if} form-control check-in-date-js"
               name="startDateForCip"
               id="startDateForCip"
               placeholder="##Enterdate##"
              >
        <i class="fal fa-calendar-alt"></i>
    </div>
</div>