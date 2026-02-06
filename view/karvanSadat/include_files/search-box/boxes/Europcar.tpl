{load_presentation_object filename="mainCity" assign="objCity"}
                        {assign var="type_data" value=['is_active'=>1 , 'limit' =>30]}
                        {assign var='listTypeCar' value=$obj_main_page->getTypeCar($type_data)}<div class="__box__ tab-pane {if $active} active {/if}" id="Europcar">
<div class="col-md-12 col-12">
<div class="row">
<form class="d_contents" data-action="/" id="cartype_rentCar_js" method="post" name="cartype_rentCar_js" target="_blank">
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
<select aria-hidden="true" class="select2 select2-hidden-accessible" data-placeholder="نوع ماشین" id="cartype_rentCar" name="cartype_rentCar" tabindex="-1">
<option value="">##ChoseOption##...</option>
{foreach $listTypeCar as $car}
<option value="{$car['id']}">{$car['title']}</option>
{/foreach}
</select>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group">
<input class="form-control deptCalendar hasDatepicker" id="rentdate_rentCar" name="rentdate_rentCar" placeholder="تاریخ اجاره" type="text"/>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
<select aria-hidden="true" class="select2 select2-hidden-accessible" data-placeholder=" محل اجاره" id="rentstation_rentCar" name="rentstation_rentCar" tabindex="-1">
 {foreach $objCity->getCityAll() as $key => $city}
<option value="{$city['id']}">
استان {$city['name']}
</option>
{/foreach}
</select>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col p-1">
<div class="form-group">
<input class="form-control deptCalendar hasDatepicker" id="dept_rentCar" name="dept_rentCar" placeholder="تاریخ تحویل" type="text"/>
</div>
</div>
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
<select aria-hidden="true" class="select2 select2-hidden-accessible" data-placeholder=" محل تحویل" id="deliverystation_rentCar" name="deliverystation_rentCar" tabindex="-1">
<option value="">##ChoseOption##...</option>
{foreach $objCity->getCityAll() as $key => $city}
<option value="{$city['id']}">
استان {$city['name']}
</option>
{/foreach}
</select>
</div>
</div>
<div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search p-1">
<button class="btn theme-btn seub-btn b-0" onclick="rentcar_local()" type="button">
<span>
 جستجو
</span>
</button>
</div>
</form>
</div>
</div>
</div>
