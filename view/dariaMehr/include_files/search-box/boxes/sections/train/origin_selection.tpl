<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route p-1">
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
        <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"></path></svg>
    </button>
</div>