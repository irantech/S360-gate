{load_presentation_object filename="employmentRequestedJob" assign="objJob"}
{assign var="list_job" value=$objJob->listRequestedJobs()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/list">لیست درخواست استخدام</a></li>
                <li  class="active" ><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/listJobRequested">لیست مشاغل</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/addJobRequested"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    افزودن شغل جدید
                </a>
                <h3 class="box-title m-b-0">لیست مشاغل درخواستی فرم استخدام</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست مشاغل را مشاهده نمائید</p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {assign var="sum" value="0"}
                        {if $list_job != ''}
                        {foreach key=key item=item from=$list_job}
                        {$number=$number+1}
                        <tr id="del-{$item.id}">
                            <td class="align-middle"><span class="badge badge-info">{$number}</span></td>
                            <td class="align-middle">{$item.title}</td>

                            <td class="align-middle">
                                <a href="editJobRequested&id={$item.id} " class="btn btn-sm btn-outline gap-4 btn-primary">ویرایش</a>

                                <button class="btn btn-sm btn-outline btn-danger deleteJob"
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

<script type="text/javascript" src="assets/JsFiles/employmentRequestedJob.js"></script>

