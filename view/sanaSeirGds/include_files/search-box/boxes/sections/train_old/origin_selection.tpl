<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route">
    {assign var='cities' value=$obj_main_page->trainListCity()}
    <div class="form-group">
            <select data-placeholder="مبدأ ( نام شهر)"
                    name="origin_train"
                    id="origin_train"
                    class="select2_in  select2-hidden-accessible origin-train-js"
                    tabindex="-1" aria-hidden="true">
            <option value="">انتخاب کنید...</option>
                {foreach $cities as $city}
                    <option value="{$city['Code']}">{$city['Name']}</option>
                {/foreach}

        </select>
    </div>
    <button onclick="reversRouteTrain()" class="switch_routs" type="button" name="button">
        <i class="fas fa-exchange-alt"></i>
    </button>
</div>