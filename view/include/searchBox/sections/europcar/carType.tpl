{assign var="type_data" value=['is_active'=>1 , 'limit' =>30 , 'order' =>'ASC']}
{assign var='listTypeCar' value=$obj_main_page->getTypeCar($type_data)}
<div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
    <div class="form-group">
        <select data-placeholder="##TypeCar##"
                name="type_rent_car"
                id="type_rent_car"
                class="select2_in  select2-hidden-accessible type_rent_car-js"
                tabindex="-1" aria-hidden="true">
            <option value="">##ChoseOption##...</option>
            {foreach $listTypeCar as $car}
                <option value="{$car['id']}">{$car['title']}</option>
            {/foreach}
        </select>
    </div>
</div>