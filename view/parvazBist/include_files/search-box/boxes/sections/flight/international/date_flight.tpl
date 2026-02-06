<div class="col-12 col_search search_col">
    <p class="label_input">تاریخ رفت یا برگشت</p>
    <div class='date-out'>
        <div class="form-group">
            <input readonly="" type="text"
                   class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} deptCalendar-en {else} deptCalendar {/if} form-control went  departure-date-international-js" name="departure_date_international" id="departure_date_international" placeholder="##CheckInDate##">
            <i class="fal fa-calendar-alt"></i>
        </div>
        <div class="form-group">
            <input readonly="" disabled="" type="text" name="arrival_date_international" id="arrival_date_international" class="{if $smarty.const.SOFTWARE_LANG neq 'fa'} returnCalendar-en {else} returnCalendar {/if} form-control return_input2  returnCalendar international-arrival-date-js" placeholder="##CheckOutDate##">
            <i class="fal fa-calendar-alt"></i>
        </div>
    </div>
</div>