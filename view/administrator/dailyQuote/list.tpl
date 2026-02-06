{load_presentation_object filename="dailyQuote" assign="objDailyQuote"}
{assign var="list_daily_quote" value=$objDailyQuote->listDailyQuote()}
{*/سمت سایت از کد زیر استفاده شود/*}
{*{assign var="type_data" value=['is_active'=>1 , 'limit' =>1 , 'check_date' =>1]}*}
{*{assign var='list_daily_quote' value=$objDailyQuote->listDailyQuote($type_data)}*}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/dailyQuote/list">سخن روز</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/dailyQuote/add"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    سخن روز جدید
                </a>
                <h3 class="box-title m-b-0">لیست سخن روز</h3>

                <p class="text-muted m-b-30"> سخن روز در صورت فعال بودن و داشتن تاریخ اعتبار در سایت نمایش داده خواهد شد
                <br>
                برای فعال سازی روی آیکون وضعیت کلیک نمائید
                </p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">

                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>متن</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            <th>اعتبار</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {if $list_daily_quote != ''}
                        {foreach key=key item=item from=$list_daily_quote}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.text|mb_substr:0:60}.</td>
                            <td class="align-middle">{$item.date_of}</td>
                            <td class="align-middle">{$item.to_date}</td>
                            {if $item.expired=='ON'}
                            <td class="align-middles" >
                                <a class="btn btn-success" style="color:#fff;">اعتبار دارد</a>
                            </td>
                                {else}
                            <td class="align-middle">
                                <a class="btn btn-danger" style="color:#fff;">منقضی</a>
                            </td>
                            {/if}
                            <td class="align-middle">
                                <a href="#"
                                   onclick="updateActiveDailyQuote('{$item.id}'); return false">
                                    {if $item.is_active}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                        <input type="checkbox" class="js-switch" data-color="#99d683"
                                               data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td class="align-middle">
                                <a href="edit&id={$item.id} " class=""><i
                                            class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary"
                                            data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="ویرایش سخن روز"></i></a>

                                <button class="btn btn-sm btn-outline btn-danger deleteDailyQuote"
                                        data-id="{$item.id}">
                                    <i class="fa fa-trash"></i> حذف
                                </button>
                </div>
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

<script type="text/javascript" src="assets/JsFiles/dailyQuote.js"></script>

