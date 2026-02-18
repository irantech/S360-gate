
{assign var="countries" value=$obj_main_page->getCountryEntertainment()}

{assign var="langVar" value=""}
{assign var="priceVar" value=""}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="_en"}
    {assign var="priceVar" value="_en"}
{/if}
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="##SelectDestinationCountry##"
                name="select_entertainment_country"
                id="select_entertainment_country"
                class="select2_in entertainment-destination-country-js select2-hidden-accessible"
                onchange="getEntertainmentCities($(this))" tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {foreach $countries as $country}
                <option value='{$country['id']}'>{$country["name$langVar"]}</option>
            {/foreach}

        </select></div>
</div>