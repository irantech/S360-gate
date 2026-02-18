{load_presentation_object filename="country" assign="objCountry"}
{assign var="continents" value=$objCountry->continentsList()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>اطلاعات پایه رزرواسیون</li>
                <li class="active">تعریف کشور / شهر</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                {if $smarty.const.TYPE_ADMIN eq '1'}
                    <div class="box-btn-excel">
                        <a href="../hotel/externalHotelCity&page=1" class="btn btn-primary waves-effect waves-light" type="button">
                            <span class="btn-label"><i class="fa fa-check"></i></span>                                    لیست شهرهای هتل خارجی (وب سرویس)
                        </a>
                    </div>
                    <div class="box-btn-excel">
                        <a href="../busTicket/busCity" class="btn btn-warning waves-effect waves-light" type="button">
                            <span class="btn-label"><i class="fa fa-check"></i></span>                                    لیست شهرهای اتوبوس (وب سرویس)
                        </a>
                    </div>
                    <br>
                {/if}
                <h3 class="box-title m-b-0">تعریف کشور / شهر</h3>
                <div class="table-responsive w-100">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام قاره</th>
                            <th>محبوب</th>
                            <th>تعریف کشور</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="counter" value=1}
                        {foreach $continents as $each}
                            <tr>

                                <td>{$counter}</td>

                                <td>{$each.titleFa}</td>

                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <input type="number" 
                                               value="{$each.sort_order|default:0}" 
                                               min="0" 
                                               max="999"
                                               style="width: 60px; text-align: center;"
                                               onchange="setSortOrder('continent', {$each.id}, this.value)"
                                               class="form-control" />
                                        <a href="#" onclick="toggleFavoriteContinent('{$each.id}'); return false;">
                                            {if $each.sort_order > 0}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small" checked/>
                                            {else}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small"/>
                                            {/if}
                                        </a>
                                    </div>
                                </td>

                                <td>
                                    <a href="country&id={$each.id}" class="btn btn-success waves-effect waves-light" type="button">
                                        <span class="btn-label"><i class="fa fa-check"></i></span>                                    اضافه کردن کشور
                                    </a>
                                </td>

                            </tr>
                            {assign var="counter" value=$counter+1}
                        {/foreach}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش تعریف کشور و شهر   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/380/---.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>