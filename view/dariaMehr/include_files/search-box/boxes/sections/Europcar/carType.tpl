<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
    <div class="form-group">
        <select aria-hidden="true" class="select2 select2-hidden-accessible"
                data-placeholder="نوع ماشین" id="cartype_rentCar" name="cartype_rentCar" tabindex="-1">
            <option value="">##ChoseOption##...</option>
            {foreach $listTypeCar as $car}
                <option value="{$car['id']}">{$car['title']}</option>
            {/foreach}
        </select>
    </div>
</div>
