{load_presentation_object filename="currency" assign="objCurrencyList"}

{if $smarty.const.TYPE_ADMIN eq '1'}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنطیمات</li>
                <li class="active">تنظیمات نرخ ارز مادر</li>
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
                <h3 class="box-title m-b-0">تنظیمات نرخ ارز مادر</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر شما میتوانید ارز هایی که به سیستم اضافه نموده اید را مشاهده کنید
                    <span class="pull-right">
                <a href="currencyAdd" class="btn btn-info waves-effect waves-light" type="button">
                    <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن ارز جدید
                </a>

                </span>
                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان ارز</th>
                            <th>عنوان لاتین ارز</th>
                            <th>قیمت ارز</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objCurrencyList->CurrencyList()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.CurrencyTitle}</td>
                                <td>{$item.CurrencyTitleEn}</td>
{*                                <td>*}
{*                                    {if $item.CurrencyPrice}*}
{*                                    {$item.CurrencyPrice}*}
{*                                    {else}*}
{*                                    ---*}
{*                                    {/if}*}

{*                                </td>*}
                                <td>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <input type="text"
                                               class="form-control"
                                               value="{$item.CurrencyPrice}"
                                               name="EqAmount"
                                               id="EqAmount"
                                               data-code = "{$item.CurrencyCode}"
                                               onchange="UpdatePriceGdsCurrency(this)"/>
                                    </div>
                                    ریال
                                </td>
                                <td><a href="#" onclick="StatusCurrency('{$item.id}'); return false">
                                        {if $item.IsEnable eq 'Enable'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a></td>
                                <td>
                                    <a href="currencyEdit&id={$item.id}" class=""><i
                                                class="fcbtn btn btn-outline btn-info btn-1e fa fa-pencil tooltip-info"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="ویرایش ارز"></i></a>
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


<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش لیست ارزهای متداول   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/365/--.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/currency.js"></script>
{/if}