{load_presentation_object filename="settingAccessUserClientList" assign="objAccess"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="flyAppClient">مشتریان نرم افزار پرواز</a></li>
                <li>تنظیمات</li>
                <li class="active">تنظیمات دسترسی</li>
                <li class="">{$objFunctions->ClientName($smarty.get.id)}</li>
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
                <h3 class="box-title m-b-0">لیست تنطیمات دسترسی</h3>
                <p class="text-muted m-b-30">کلیه دسترسی های کاربر را در این لیست میتوانید مشاهده کنید و نسبت به فعال و
                    غیر فعال نمودن آن ها اقدام نمائید

                    <span class="pull-right">
                         <a href="settingAccessUserClientAdd&id={$smarty.get.id}"
                            class="btn btn-info waves-effect waves-light " type="button">
                    <span class="btn-label"><i class="fa fa-bank"></i></span>افزودن تنظیمات دسترسی جدید
                </a>
                </span>

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام سرویس</th>
                            <th>نوع سرویس</th>
                            <th>نام منبع</th>
                            <th>وضعیت</th>
                            <th>ویرایش</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$objAccess->ListAccessUserClient($smarty.get.id)}

                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td>{$number}</td>
                            <td>{$item.TitleService}</td>
                            <td>{$item.ServiceGroupTitle}</td>
                            <td>{$item.TitleSource}</td>
                            <td>
                                <a href="#" onclick="Access_active('{$item.id}','{$item.ClientId}','{$item.ServiceId}','{$item.SourceId}'); return false;">
                                    {if $item.IsActive eq 'Active'}
                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                           data-secondary-color="#f96262" data-size="small" checked/>
                                    {else}
                                    <input type="checkbox" class="js-switch" data-color="#99d683"
                                           data-secondary-color="#f96262" data-size="small"/>
                                    {/if}
                                </a>
                            </td>
                            <td>
                                <a href="settingAccessUserClientEdit&ClientId={$item.ClientId}&id={$item.id}"
                                   class=""><i
                                        class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="ویرایش دسترسی"></i></a>
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

<script type="text/javascript" src="assets/JsFiles/settingAccessUserClient.js"></script>