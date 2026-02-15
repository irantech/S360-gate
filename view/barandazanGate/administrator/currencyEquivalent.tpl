{load_presentation_object filename="currencyEquivalent" assign="objCurrencyEquivalent"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنطیمات</li>
                <li class="active">تنظیمات نرخ ارز</li>
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
                <h3 class="box-title m-b-0">لیست انوع ارز
                </h3>
                <p class="text-muted m-b-30">
                    در لیست زیر شما میتوانید ارز هایی که به سیستم اضافه نموده اید،
                    <span class="pull-right">
                <a href="currencyEquivalentAdd" class="btn btn-info waves-effect waves-light" type="button">
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
                            <th>معادل</th>
                            <th>وضعیت</th>
                            <th>پیش فرض</th>
                            <th>سوابق تغییرات ارز</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objCurrencyEquivalent->ListCurrencyEquivalent()}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.CurrencyTitle}</td>
                                <td>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <input type="text"
                                               class="form-control"
                                               value="{$item.EqAmount}"
                                               name="EqAmount"
                                               id="EqAmount"
                                               data-code = "{$item.CurrencyCode}"
                                               onchange="UpdatePriceCurrency(this)"/>
                                    </div>
                                    ریال
                                </td>
                                <td><a href="#" onclick="StatusCurrencyEquivalent('{$item.CurrencyCode}'); return false">
                                        {if $item.IsEnable eq 'Enable'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>

                                <a href="#" onclick="DefaultCurrencyEquivalent('{$item.CurrencyCode}'); return false">
                                        {if $item.DefaultCurrency eq '1'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>

                                    <a href="currencyHistoryEquivalent&id={$item.CurrencyCode}" class=""><i
                                                class="fcbtn btn btn-outline btn-primary btn-1e fa fa-list-ul tooltip-primary"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="مشاهده سوابق ارز"></i></a>
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
        <span> ویدیو آموزشی بخش تنظیمات نرخ ارز   </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/362/--.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/currencyEquivalent.js"></script>