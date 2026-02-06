<div class="col-lg-2 col-md-6 col-sm-6 col-12 p-1 col_search">
    <div class="form-group">
        {assign var='cities' value=$obj_main_page->trainListCity()}
        <select data-placeholder="مقصد ( نام شهر  )"
                name="destination_train"
                id="destination_train"
                class="select2_in  select2-hidden-accessible destination-train-js" tabindex="-1" aria-hidden="true">
            <option value="">انتخاب کنید...</option>
            {foreach $cities as $city}
                <option value="{$city['Code']}">{$city['Name']}</option>
            {/foreach}
        </select></div>
</div>