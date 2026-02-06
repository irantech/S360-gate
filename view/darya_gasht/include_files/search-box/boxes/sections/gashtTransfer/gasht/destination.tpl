
{assign var="cities" value=$obj_main_page->getCitiesGashtTransfer()}
<div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="مقصد ( نام شهر)"
                name="gasht_destination" id="gasht_destination"
                class="select2_in gasht-destination-js select2-hidden-accessible"
                tabindex="-1"
                aria-hidden="true">
            <option value="">انتخاب کنید...</option>
            {foreach $cities as $city}
                <option value="{$city['city_code']}">{$city['city_name']}</option>
            {/foreach}

        </select></div>
</div>