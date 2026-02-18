{load_presentation_object filename="iranVisa" assign="objIranVisa"}
{assign var="getData" value=$objIranVisa->getIranVisa($smarty.get.id)}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/iranVisa/list">
                        لیست درخواست ویزای ایران
                    </a>
                </li>
                <li class='active'>
                    جزییات درخواست ویزای ایران
                    <span class='font-bold underdash'>{$getData['name_family']}</span>
                </li>
            </ol>
        </div>
    </div>

    <div class="row orderServices">
        <div class="container">
            <h2>جزییات درخواست ویزای ایران {$getData['name_family']}</h2>
            <p>همه اطلاعات ارسالی را در این قسمت مشاهده نمائید</p>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>متن </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>نام</td>
                    <td>{if $getData['name']}{$getData['name']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>نام خانوادگی</td>
                    <td>{if $getData['family']}{$getData['family']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>نام مستعار</td>
                    <td>{if $getData['nickName']}{$getData['nickName']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>ملیت</td>
                    <td>{if $getData['nationality']}{$getData['nationality']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>جنسیت</td>
                    <td>{if $getData['sex']} {$getData['gender_title']} {else}---{/if}</td>
                </tr>
                <tr>
                    <td>کشور محل تولد</td>
                    <td>{if $getData['country_birth']}{$getData['country_birth']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>نام پدر</td>
                    <td>{if $getData['father_name']}{$getData['father_name']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>نوع پاسپورت</td>
                    <td>
                            {if $getData.type_passport eq 'Ordinary'}
                                ##Ordinary##
                            {elseif $getData.type_passport eq 'Service'}
                                ##ServicePassport##
                            {elseif $getData.type_passport eq 'Political'}
                                ##Political##
                            {elseif $getData.type_passport eq 'Travel-Document'}
                                ##TravelDocument##
                            {elseif $getData.type_passport eq 'Laissez-Passer'}
                                ##LaissezPasser##
                            {elseif $getData.type_passport eq 'Refuge'}
                                ##Refuge##
                            {else}
                                ---
                            {/if}
                    </td>
                </tr>
                <tr>
                    <td>عنوان شغل</td>
                    <td>{if $getData['profession_title']}{$getData['profession_title']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>نام شرکت</td>
                    <td>{if $getData['company_name']}{$getData['company_name']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>آیا تاکنون به ایران آمده اید؟</td>
                    <td>{if $getData['ever_been_iran']}{$getData['ever_been_iran']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>چند سال پیش به ایران آمده اید؟</td>
                    <td>{if $getData['number_trip_iran']}{$getData['number_trip_iran']} سال پیش{else}---{/if}</td>
                </tr>
                <tr>
                    <td>موبایل</td>
                    <td>{if $getData['mobile']}{$getData['mobile']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>وضعیت تاهل</td>
                    <td>
                        {if $getData['married'] eq 'Single'}
                            ##Single##
                        {elseif $getData['married'] eq 'Married'}
                            ##Married##
                        {elseif $getData['married'] eq 'Divorced'}
                            ##Divorced##
                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>نوع ویزا</td>
                    <td>
                            {if $getData['type_visa'] eq 'Tourist'}
                                ##Tourist##
                            {elseif $getData['type_visa'] eq 'Business'}
                                ##Business##
                            {elseif $getData['type_visa'] eq 'Divorced'}
                                ##Divorced##
                            {elseif $getData['type_visa'] eq 'Multiple_Entry'}
                                ##MultipleEntry##
                            {elseif $getData['type_visa'] eq 'Pilgrimage'}
                                ##Pilgrimage##
                            {elseif $getData['type_visa'] eq 'Treatment'}
                                ##Treatment##
                            {else}
                                ---
                            {/if}
                    </td>
                </tr>
                <tr>
                    <td>تاریخ ورود</td>
                    <td>{if $getData['enter_date']}{$getData['enter_date']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>تاریخ خروج</td>
                    <td>{if $getData['exit_date']}{$getData['exit_date']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>ملیت پیشین</td>
                    <td>{if $getData['previous_nationality']}{$getData['previous_nationality']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>موبایل</td>
                    <td>{if $getData['mobile']}{$getData['mobile']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>تلفن ثابت</td>
                    <td>{if $getData['phone']}{$getData['phone']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>ایمیل</td>
                    <td>{if $getData['email']}{$getData['email']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>هتل محل اقامت</td>
                    <td>{if $getData['hotels_accommodation']}{$getData['hotels_accommodation']}{else}---{/if}</td>
                </tr>

                <tr>
                    <td>عکس پاسپورت</td>
                    {if $getData['file_passport'] neq ''}
                    <td><a href='{$getData['file']}' target='_blank'><img src='assets/css/images/view_file.png' width='50' height='50'> </a></td>
                    {else}
                        <td>---</td>

                    {/if}
                </tr>
                <tr>
                    <td>تصویر کاربر</td>
                    {if $getData['pic_user'] neq ''}
                    <td><a href='{$getData['pic']}' target='_blank'><img src='assets/css/images/view_file.png' width='50' height='50'> </a></td>
                    {else}
                        <td>---</td>

                    {/if}
                </tr>

                </tbody>
            </table>

        </div>

        <form data-toggle="validator" method="post" id="editForAdminRespons" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="iranVisa">
            <input type="hidden" name="method" value="updateAdminResponse">
            <input type="hidden" name="request_id" value="{$getData.sId}">


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
                                       disabled value="{$getData.created_at}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="status_id">وضعیت درخواست</label>
                                <select  value="{$getData.status}" name="status_id" id="status_id" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    {foreach $objStatus->getRequestServiceStatusList() as $status}
                                        <option value="{$status['id']}"  {if $getData['status']==$status['value']} selected{/if} {if $status['value']=='seen' || $status['value']=='not_seen'} disabled="disabled"{/if}>{$status['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="admin_response">یادداشت ادمین </label>
                                <textarea name="admin_response" class="form-control" id="admin_response"
                                          placeholder="یادداشت ادمین">{$getData['admin_response']}</textarea>
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

<script type="text/javascript" src="assets/JsFiles/iranVisa.js">
