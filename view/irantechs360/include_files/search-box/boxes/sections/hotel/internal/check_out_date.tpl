<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
    <div class="form-group">
        <input type="text"
               class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} init-miladi-return-datepicker {else} init-shamsi-return-datepicker {/if} init-miladi-return-datepicker form-control check-out-date-js"
               name="endDateForHotelLocal"
               readonly=""
               autocomplete="off"
               id="endDateForHotelLocal"
               placeholder="##Exitdate##"
               data-type='internal'>
        <i class="fal fa-calendar-alt"></i>
    </div>
</div>
