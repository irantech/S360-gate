
{assign var="countries" value=$obj_main_page->getCountryEntertainment()}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="انتخاب کشور مقصد"
                name="select_entertainment_country"
                id="select_entertainment_country"
                class="select2_in entertainment-destination-country-js select2-hidden-accessible"
                onchange="getEntertainmentCities($(this))" tabindex="-1" aria-hidden="true">
            <option value="">انتخاب کنید...</option>
            {foreach $countries as $country}
                <option value='{$country['id']}'>{$country['name']}</option>
            {/foreach}

        </select></div>
</div>