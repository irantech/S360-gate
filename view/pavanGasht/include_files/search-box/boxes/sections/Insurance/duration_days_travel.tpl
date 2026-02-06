<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search p-1">
    <div class="form-group">
        <select data-placeholder="انتخاب مدت سفر"
                name="travel_time" id="travel_time"
                class="select2_in travel-time-js select2-hidden-accessible"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {assign var="durations" value=['5','7','8','15','23','31','45','62','92','182','186','365']}
            {foreach $durations as $days}
                <option value="{$days}">##untill## {$days} ##Day##</option>
            {/foreach}
        </select></div>
</div>


