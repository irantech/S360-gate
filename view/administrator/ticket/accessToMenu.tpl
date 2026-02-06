{load_presentation_object filename="admin" assign="objAdmin"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li class="active">تعیین دسترسی سوابق خرید کانتر</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
{*            <h4 class="page-title FloatLeft">Dashboard 3</h4>*}
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست وضعیت دسترسی کانتر</h3>
                <p class="text-muted m-b-30">شما از طریق لیست زیر میتوانید به کانتر مورد نظر دسترسی های مد نظر خود را بدهید
                    <span class="pull-right">
                         <a href="accessHistory&id={$smarty.get.id}" class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن دسترسی سوابق
                </a>
                    </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام منو</th>
                            <th>وضعیت دسترسی</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objAdmin->listLevel3Admin()}
                            {$number=$number+1}
                            <tr>
                                <td class="align-middle">{$number}</td>
                                <td class="align-middle">{$item.title}</td>
                                <td class="align-middle">
                                    <a href="#"
                                       onclick="StatusAccess('{$item.id}','{$smarty.get.id}'); return false">
                                        {if $objAdmin->accessMenuCounter($item.id,$smarty.get.id)}
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript" src="assets/JsFiles/menuAdmin.js"></script>


