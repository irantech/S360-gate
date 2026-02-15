{assign var="continents" value=$obj_main_page->getListContinents()}
{assign var="langVar" value="Fa"}
{assign var="priceVar" value="Fa"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {assign var="langVar" value="En"}
    {assign var="priceVar" value="En"}
{/if}
<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
    <div class="parent-input-search-box">
        <select aria-hidden="true" class="select2_in select2-hidden-accessible continent-visa-js"
                data-placeholder=" قاره" id="visa_continent" name="visa_continent" onchange="fillComboByContinent(this)"
                tabindex="-1">
            {foreach $continents as $continent}
                <option value="">##ChoseOption##...</option>
                <option value="{$continent['id']}">{$continent['titleFa']}</option>
            {/foreach}
        </select>
    </div>
</div>