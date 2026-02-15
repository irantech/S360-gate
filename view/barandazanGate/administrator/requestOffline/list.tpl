{load_presentation_object filename="requestOffline" assign="objRequestOffline"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class='active'>لیست درخواست های خدمات</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="table-responsive table-bordered">
                    <table id="myTable" class="table table-striped table-hover">
                        <thead class="thead-default">
                        <tr>
                            <th>ردیف</th>
                            <th>خدمات</th>
                            <th>تاریخ ثبت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="rowNum" value=0}
                        {assign var="main_requests" value=$objRequestOffline->getRequestList($section)}

                        {foreach $main_requests['data'] as $request}
                            {assign var="request_data" value=$request.requested_data|json_encode}

                            {$rowNum=$rowNum+1}
                            <tr>
                                <td>{$rowNum}</td>
                                <td>{$objFunctions->Xmlinformation($request.service_name)} </td>
                                <td>{$request.created_at}</td>
                                <td>
                                    {if $request.read_at }
                                        <div class="label_request_read_at">خوانده شده</div>
                                    {else}
                                        <button class="btn btn-sm btn-outline btn-default" onclick='requestOfflineSelectedToggle($(this),"{$request.id}")'>
                                            <span>
                                                افزودن به لیست خوانده شده ها
                                            </span>
                                        </button>
                                    {/if}

                                </td>
                                <td>
                                    <button onclick='ModalRequestOffline({$request_data}, "{$request.full_name}" , "{$request.mobile}" , "{$request.description}");return false' data-target="#ModalPublic" data-toggle="modal" class="btn btn-sm btn-outline btn-default">
                                        <span>
                                            مشاهده اطلاعات درخواست
                                        </span>
                                    </button>
                                    <button class="btn btn-sm btn-outline btn-danger deleteRequestOffline"
                                            data-id="{$request.id}">
                                        <i class="fa fa-trash"></i>
                                        حذف
                                    </button>
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;" id="ModalPublic"></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/requestOffline.js"></script>
