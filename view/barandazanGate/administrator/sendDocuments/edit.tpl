{load_presentation_object filename="sendDocuments" assign="objSendDocument"}
{assign var="getData" value=$objSendDocument->getDetailDocument($smarty.get.id)}
{assign var="listPeople" value=$objSendDocument->listPeopleDocument($smarty.get.id)}
{assign var="list_received_documents" value=$objSendDocument->getReceivedDocument($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/sendDocuments/list">
                        لیست مدارک
                    </a>
                </li>
                <li class='active'>
                    جزییات مدارک
                    <span class='font-bold underdash'>{$getData['name']}</span>
                </li>
            </ol>
        </div>
    </div>

    <div class="row orderServices">
        <div class="container">
            <h2>جزییات مدارک ارسالی {$getData['name']}</h2>
            <p>همه اطلاعات ارسالی را در این قسمت مشاهده نمائید</p>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>کد ملی </th>
                    <th>شماره همراه </th>
                    <th>ایمیل </th>
                </tr>
                </thead>
                <tbody>
                {foreach key=key item=item from=$listPeople}
                <tr>
                    <td>{if $item.name}{$item.name}{else}---{/if}</td>

                    <td>{if $item.national_code}{$item.national_code}{else}---{/if}</td>

                    <td>{if $item.mobile}{$item.mobile}{else}---{/if}</td>

                    <td>{if $item.email}{$item.email}{else}---{/if}</td>
                </tr>
                {/foreach}

                </tbody>
            </table>

        </div>
        <div class="container">
            <h2>لیست مدارک ارسالی {$getData['name']}</h2>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>فایل </th>
                </tr>
                </thead>
                <tbody>
                {assign var="number" value="0"}
                {if $list_received_documents != ''}
                {foreach key=key item=item from=$list_received_documents}
                {$number=$number+1}
                <tr>
                    <td>مدرک شماره {$number}</td>
                    <td><a target='_blank' href='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/sendDocuments/{$smarty.const.CLIENT_ID}/{$item.file_path}' >مشاهده فایل</a></td>
                </tr>
                {/foreach}
                {/if}

                </tbody>
            </table>

        </div>

        <form data-toggle="validator" method="post" id="editForAdminRespons" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="sendDocuments">
            <input type="hidden" name="method" value="updateAdminResponse">
            <input type="hidden" name="document_id" value="{$getData.id}">


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>نتیجه بررسی ادمین</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="created_at">تاریخ ارسال مدارک توسط کاربر</label>
                                <input type="text" class="form-control" name="created_at" id="created_at"
                                       disabled value="{$getData.created_at}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="status_id">وضعیت مدارک</label>
                                <select  name="status_id" id="status_id" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    <option value="not_seen" {if $getData.status == 'not_seen'} selected="" {/if}  disabled="disabled">بررسی نشده</option>
                                    <option value="seen" {if $getData.status == 'seen'} selected="" {/if} disabled="disabled">مشاهده شده</option>
                                    <option value="accept" {if $getData.status == 'accept'} selected="" {/if} >پذیرفته شد</option>
                                    <option value="reject" {if $getData.status == 'reject'} selected="" {/if} >رد شد</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="admin_result">یادداشت ادمین </label>
                                <textarea name="admin_result" class="form-control" id="admin_result"
                                          placeholder="یادداشت ادمین">{$getData.admin_result}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class=' col-12 d-flex  align-items-center justify-content-center w-100 parentbtn-btn-fixed'>
                <button class="btn btn-success btn-block btn-fixed" type="submit" id="submit-button">ذخیره</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/sendDocuments.js">
