{assign var="params" value=['type'=>'international']}
{assign var="cities" value=$obj_main_page->getOriginTourCities($params)}
<div class="col-lg-2 p-1 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder=" شهر مبدا"
                name="tourOriginCityPortal"
                id="tourOriginCityPortal"
                onchange="getArrivalCitiesTour('international',this)"
                class="select2_in select2-hidden-accessible international-tour-origin-city-js"
                tabindex="-1"
                aria-hidden="true">
            <option value="">انتخاب کنید...</option>
            {foreach $cities as $city}
                <option value="{$city['id']}">{$city['name']}</option>
            {/foreach}
        </select>
    </div>
</div>

