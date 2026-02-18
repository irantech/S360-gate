{load_presentation_object filename="airline" assign="objAirline"}
{$objAirline->getAllDomestic($smarty.get.id)}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                <li class="active"> وضعیت خطوط پروازی</li>
                {if $smarty.get.id neq ''}
                <li>{$objFunctions->ClientName($smarty.get.id)}</li>
                {/if}
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست وضعیت خطوط پروازی</h3>
                <p class="text-muted m-b-30"> شما میتوانید در لیست زیر خطوط پروازی مورد نظر خود را فعال یا غیر فعال کنید
                    <a href="#" onclick="showAllAirlineConfig('{$smarty.get.id}',{$objAirline->ids})" type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#ModalPublic">
                        <span class="btn-label"><i class="fa fa-plane"></i></span>                    تنظیمات جمعی ایرلاین ها
                    </a>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام فارسی</th>
                            <th>نام انگلیسی</th>
                            <th>مخفف</th>
                            <th>چارتری</th>
                            <th>سیستمی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objAirline->list}
                        {$number=$number+1}
                        <tr>
                            <td class="align-middle">{$number}</td>
                            <td class="align-middle">{$item.name_fa}</td>
                            <td class="align-middle">{$item.name_en}</td>
                            <td class="align-middle">{$item.abbreviation}</td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="StatusAirline('{$smarty.get.id}', '{$item.abbreviation}', 'charter'); return false">
                                    {if $objAirline->GetAirlineInfo($item.abbreviation,'charter') eq 'ok'}
                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                           data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                           data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="#"
                                   onclick="StatusAirline('{$smarty.get.id}', '{$item.abbreviation}', 'system'); return false">
                                    {if $objAirline->GetAirlineInfo($item.abbreviation,'system') eq 'ok'}
                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                           data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                           data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td>

                                    <a href="#" onclick="showConfigAirline('{$smarty.get.id}','{$item.abbreviation}')" class="" data-toggle="modal" data-target="#ModalPublic"><i
                                                class="fcbtn btn btn-outline btn-info btn-1e  fa fa-cubes tooltip-info"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title=" تنطیمات ایرلاین"></i></a>
                                <a href="#" onclick="ShowLogConfigAirline('{$smarty.get.id}','{$item.abbreviation}')" class="" data-toggle="modal" data-target="#ModalPublic"><i
                                            class="fcbtn btn btn-outline btn-warning btn-1e  fa fa-list-ol tooltip-warning "
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title=" سوابق تنظیمات ایرلاین"></i></a>


                            </td>
                        </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/airline.js"></script>


