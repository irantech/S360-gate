{load_presentation_object filename="weather" assign="objWeather"}

{assign var="list_weather" value=$objWeather->listWeather()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/weather/list">لیست شهرها</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">


                <h3 class="box-title m-b-0">لیست شهرها</h3>

                <p class="text-muted m-b-30"> در لیست زیر شما می توانید شهر منتخب خود را برای نمایش در صفحه آب و هوا انتخاب نمایید،
                <br>
                برای این کار از تیک ستون شهر منتخب روی آیتم مورد نظر کلیک نمایید، با این کار شهر منتخب قبلی غیرفعال خواهد شد
                    <br>
                    در نظر داشته باشید تنها یک شهر امکان نمایش در قسمت شهر منتخب را دارا می باشد
                    <br>
                    در نمایش سمت سایت شهر منتخب شما در بالای صفحه و بقیه شهرها در قسمت پایین صفحه نمایش داده خواهند شد
                </p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عنوان انگلیسی</th>
                            <th>شهر منتخب</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_weather != ''}
                            {foreach key=key item=item from=$list_weather}
                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                                    <td class="align-middle">{$item.title}</td>

                                    <td class="align-middle">{$item.title_en}</td>
                                    <td class="align-middle">
                                        <a href="#"
                                           onclick="updateStatusWeather('{$item.id}'); return false">
                                            {if $item.active=='is_active'}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small" checked/>
                                            {else}
                                                <input type="checkbox" class="js-switch" data-color="#99d683"
                                                       data-secondary-color="#f96262" data-size="small"/>
                                            {/if}
                                        </a>
                                    </td>

                                </tr>
                            {/foreach}
                        {/if}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/weather.js"></script>

