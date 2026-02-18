{assign var="date_tour" value=$obj_main_page->datesTour()}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="##Wentdate##"
                name="tourDeptDateInternational"
                readonly=""
                id="tourDeptDateInternational"
                class="select2_in DeptYearOnChange_js select2-hidden-accessible international-date-travel-tour-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>

            {foreach $date_tour as $date}
                <option value='{$date['value']}'>{$date['text']}</option>
            {/foreach}

        </select>
    </div>
</div>