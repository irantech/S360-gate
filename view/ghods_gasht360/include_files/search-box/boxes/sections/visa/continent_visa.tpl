{assign var="continents" value=$obj_main_page->getListContinents()}

<div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
    <div class="form-group">

        <select data-placeholder=" ##Continent##" name="visa_continent"
                                    id="visa_continent"
                                    class="select2_in  select2-hidden-accessible continent-visa-js"
                                    onchange="fillComboByContinent(this)" tabindex="-1"
                                    aria-hidden="true">
            <option selected="selected" value="">##ChoseOption##...</option>

            {foreach $continents as $continent}
                <option value="{$continent['id']}">{$continent['titleFa']}</option>
            {/foreach}

        </select></div>
</div>