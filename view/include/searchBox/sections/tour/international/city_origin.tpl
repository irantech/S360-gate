{assign var="params" value=['type'=>'international']}
{assign var="cities" value=$obj_main_page->getOriginTourCities($params)}

{assign var="langVar" value=""}
{assign var="priceVar" value=""}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="_en"}
    {assign var="priceVar" value="_en"}
{/if}

<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group ">
        <select data-placeholder="##Origincity##"
                name="tourOriginCityPortal"
                id="tourOriginCityPortal"
                onchange="getArrivalCitiesTour('international',this)"
                class="select2_in select2-hidden-accessible international-tour-origin-city-js"
                tabindex="-1"
                aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {foreach $cities as $city}
                <option value="{$city['id']}">{$city["name$langVar"]}</option>
            {/foreach}
        </select>
    </div>
</div>