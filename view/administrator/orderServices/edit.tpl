{load_presentation_object filename="orderServices" assign="objOrder"}
{assign var="getOrder" value=$objOrder->getOrderServices($smarty.get.id)}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/orderServices/list">
                        لیست درخواست خدمات
                    </a>
                </li>
                <li class='active'>
                    جزییات درخواست خدمات
                    <span class='font-bold underdash'>{$getOrder['name']}</span>
                </li>
            </ol>
        </div>
    </div>

    <div class="row orderServices">


        <div class="container">
            <h2>جزییات درخواست خدمات {$getOrder['name']}</h2>
            <p>همه اطلاعات ارسالی را در این قسمت مشاهده نمائید</p>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>متن درخواست</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>نام </td>
                    <td>{if $getOrder['name']}{$getOrder['name']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>نام خانوادگی </td>
                    <td>{if $getOrder['family']}{$getOrder['family']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>سن</td>
                    <td>{if $getOrder['age']}{$getOrder['age']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>تعداد درخواستی</td>
                    <td>{if $getOrder['number_requests']}{$getOrder['number_requests']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>موبایل</td>
                    <td>{if $getOrder['mobile']}{$getOrder['mobile']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>ایمیل</td>
                    <td>{if $getOrder['email']}{$getOrder['email']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>آدرس</td>
                    <td>{if $getOrder['address']}{$getOrder['address']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>کشور</td>
                    <td>

                        {if $getOrder['country']}
                           {$getOrder['country_name']}
                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>نوع درخواست</td>
                    <td>

                        {if $getOrder['kind_service']}
                            {$getOrder['kind_title']}
                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>توضیحات</td>
                    <td>{if $getOrder['comment']}{$getOrder['comment']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>از تاریخ</td>
                    <td>{if $getOrder['date_start']}{$getOrder['date_start']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>تا تاریخ</td>
                    <td>{if $getOrder['date_end']}{$getOrder['date_end']}{else}---{/if}</td>
                </tr>

                <tr>
                    <td>فایل دریافتی</td>
                    {if $getOrder['file'] neq ''}
                    <td><a href='{$getOrder['file_order']}' target='_blank'><img src='assets/css/images/view_file.png' width='50' height='50'> </a></td>
                    {else}
                        <td>---</td>

                    {/if}
                </tr>


                </tbody>
            </table>

        </div>

        <form data-toggle="validator" method="post" id="editOrderServices" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="orderServices">
            <input type="hidden" name="method" value="updateOrderServices">
            <input type="hidden" name="order_services_id" value="{$getOrder.sId}">


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex flex-wrap gap-10">
                    <div class="bg-white d-flex flex-wrap rounded w-100 ">
                        <div class='d-flex justify-content-between align-content-center flex-wrap w-100'>
                            <h4 class='d-flex flex-wrap font-bold m-0 py-3 px-4'>نتیجه بررسی ادمین</h4>
                        </div>

                        <hr class='m-0 mb-4 w-100'>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="created_at">تاریخ ثبت این درخواست</label>
                                <input type="text" class="form-control" name="created_at" id="created_at"
                                       disabled value="{$getOrder.created_at}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="status_id">وضعیت درخواست</label>
                                <select  value="{$getOrder.status}" name="status_id" id="status_id" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    {foreach $objStatus->getRequestServiceStatusList() as $status}
                                        <option value="{$status['id']}"  {if $getOrder['status']==$status['value']} selected{/if} {if $status['value']=='seen' || $status['value']=='not_seen'} disabled="disabled"{/if}>{$status['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="admin_response">یادداشت ادمین </label>
                                <textarea name="admin_response" class="form-control" id="admin_response"
                                          placeholder="یادداشت ادمین">{$getOrder['admin_response']}</textarea>
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

<script type="text/javascript" src="assets/JsFiles/orderServices.js">
