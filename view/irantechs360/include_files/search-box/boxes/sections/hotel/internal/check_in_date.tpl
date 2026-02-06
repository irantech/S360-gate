<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
    <div class="form-group">
        <input type="text"
               autocomplete="off"
               readonly=""
               class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} init-miladi-datepicker {else} init-shamsi-datepicker {/if} form-control check-in-date-js"
               name="startDateForHotelLocal"
               id="startDateForHotelLocal"
               placeholder="##Enterdate##"
               data-type='internal'>
        <i class="fal fa-calendar-alt"></i>
    </div>
</div>