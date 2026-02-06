<div class="col-12 col_search search_col">
    <p class="label_input">تاریخ رفت یا برگشت</p>
    <div class='date-in'>
        <div class="form-group">
            <input readonly="" type="text"
                   class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} deptCalendar-en {else} deptCalendar {/if} form-control went departure-date-internal-js "
                   name="departure_date_internal" id="departure_date_internal" placeholder="##CheckInDate##">
            <i class="fal fa-calendar-alt"></i>
        </div>
        <div class="form-group">
            <input readonly="" disabled="" name="arrival_date_internal" id="arrival_date_internal" type="text"
                   class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} returnCalendar-en {else} returnCalendar {/if} checktest  form-control return_input internal-arrival-date-js " placeholder="##CheckOutDate##">
            <i class="fal fa-calendar-alt"></i>
        </div>
    </div>
</div>