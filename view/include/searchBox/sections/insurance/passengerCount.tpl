<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select name="number_of_passengers"
                id="number_of_passengers"
                data-placeholder="##ChoosePassangersNumber##"
                class="select2_in passengers-count-js select2-hidden-accessible number-of-passengers-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption## ...</option>
            {for $num=1 to 9}
                <option value="{$num}" {if $num eq $smarty.const.INSURANCE_NUM_MEMBER} selected="selected" {/if}>{$num} ##People##</option>
            {/for}
        </select>
    </div>
</div>