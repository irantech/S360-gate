<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search p-1">
    <div class="form-group">
        <select name="number_of_passengers"
                id="number_of_passengers"
                data-placeholder="انتخاب تعداد مسافر"
                class="select2_in passengers-count-js select2-hidden-accessible number-of-passengers-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {for $i=1 to 9}
                <option value="{$i}">{$i} ##People##</option>
            {/for}        </select>
    </div>
</div>

