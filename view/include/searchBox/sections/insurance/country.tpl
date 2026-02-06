{assign var="countries" value=$obj_main_page->countryInsurance()}
<div class="col-lg-3 col-md-4 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="##CountryName## ##Destination##"
                name="insurance_destination_country"
                id="insurance_destination_country"
                class="select2_in  select2-hidden-accessible insurance-destination-country-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption## ...</option>
            {foreach $countries as $country}
                <option value="{$country['abbr']}">
                    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                        {$country['persian_name']}
                    {else}
                        {$country['english_name']}
                    {/if}
                    ({$country['abbr']})</option>
            {/foreach}
        </select>
    </div>
</div>