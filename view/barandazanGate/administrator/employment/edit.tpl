{load_presentation_object filename="employment" assign="objEmployment"}
{assign var="employment" value=$objEmployment->getEmployment($smarty.get.id)}
{load_presentation_object filename="mainCity" assign="objCity"}
{load_presentation_object filename="employmentMilitary" assign="objMilitary"}
{load_presentation_object filename="employmentEducationalCertificate" assign="objEmploymentEducationalCertificate"}
{*{load_presentation_object filename="employmentRequestedJob" assign="objemploymentRequestedJob"}*}
{load_presentation_object filename="requestServiceStatus" assign="objEmploymentStatus"}
{load_presentation_object filename="employmentRequestedJob" assign="objJob"}
{assign var="info_job" value=$objJob->getRequestedJob($employment['requested_job'])}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/employment/list">
                        لیست درخواست استخدام
                    </a>
                </li>
                <li class='active'>
                    جزییات درخواست همکاری
                    <span class='font-bold underdash'>{$employment['name']}</span>
                </li>
            </ol>
        </div>
    </div>

    <div class="row employment">


        <div class="container">
            <h2>جزییات درخواست همکاری {$employment['name']}</h2>
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
                    <td>نام و نام خانوادگی</td>
                    <td>{if $employment['name']}{$employment['name']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>تاریخ تولد</td>
                    <td>{if $employment['birth']}{$employment['birth']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>جنسیت</td>
                    <td>{if $employment['gender']}{$employment['gender']}{else}---{/if}</td>
                </tr>

                <tr>
                    <td>وضعیت نظام وظیفه</td>
                    <td>
                        {if $employment['military']}
                            {foreach $objMilitary->getEmploymentMilitary($employment['military']) as $military}
                                {$military['title']}
                            {/foreach}
                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>وضعیت تاهل</td>
                    <td>{if $employment['married']}{$employment['married']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>رشته تحصیلی</td>
                    <td>{if $employment['major']}{$employment['major']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>آخرین مدرک تحصیلی</td>
                    <td>
                        {if $employment['last_educational_certificate']}
                            {foreach $objEmploymentEducationalCertificate->getEmploymentEducationalCertificate($employment['last_educational_certificate']) as $certificate}
                                {$certificate['title']}
                            {/foreach}
                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>ایمیل</td>
                    <td>{$employment['email']}</td>
                </tr>
                <tr>
                    <td>موبایل</td>
                    <td>{$employment['mobile']}</td>
                </tr>
                <tr>
                    <td>شماره تماس</td>
                    <td>{$employment['phone']}</td>
                </tr>
                <tr>
                    <td>استان</td>
                    <td>
                        {foreach $objCity->getCityAll() as $key => $city}
                            {if $employment['city']==$city['id']}
                                استان {$city['name']}
                            {/if}
                        {/foreach}
                    </td>
                </tr>
                <tr>
                    <td>آدرس</td>
                    <td>{$employment['address']}</td>
                </tr>
                <tr>
                    <td>شغل درخواستی</td>
                    <td>
                        {if $employment['requested_job']}
                                {$info_job['title']}
                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>حقوق درخواستی</td>
                    <td>{$employment['requested_salary']}</td>
                </tr>
                <tr>
                    <td>نوع همکاری</td>
                    <td>{$employment['cooperation_type']}</td>
                </tr>


                </tbody>
            </table>


        </div>
        {if $objEmployment->getExperienceList($employment['eId'])}
            <div class="container">
                <h2>لیست سوابق شغلی {$employment['name']}</h2>
                <p>همه سوابق شغلی را در این قسمت مشاهده نمائید</p>
                <table class="table table-bordered request-table">
                    <thead>
                    <tr>
                        <th>عنوان شغل</th>
                        <th>نام شرکت </th>
                        <th>تلفن شرکت </th>
                        <th>مدت اشتغال </th>
                        <th>حقوق دریافتی </th>
                        <th>علت کناره گیری </th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $objEmployment->getExperienceList($employment['eId']) as $key => $value}
                        <tr>
                            <td>{$value['company_post']}</td>
                            <td>{$value['company_name']}</td>
                            <td>{$value['company_tell']}</td>
                            <td>{$value['employment_period']}</td>
                            <td>{$value['receive_salary']}</td>
                            <td>{$value['reason_left']}</td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>


            </div>
        {/if}

        {if $objEmployment->getSkillsList($employment['eId'])}
            <div class="container">
                <h2>لیست مهارت شغلی {$employment['name']}</h2>
                <p>همه مهارت های شغلی را در این قسمت مشاهده نمائید</p>
                <table class="table table-bordered request-table">
                    <thead>
                    <tr>
                        <th>نام مهارت</th>
                        <th>میزان توانایی </th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $objEmployment->getSkillsList($employment['eId']) as $key => $value}
                        <tr>
                            <td>{$value['skill_name']}</td>
                            <td>
                                {if $value['ability_level']==1}
                                    ضعیف
                                {elseif $value['ability_level']==2}
                                    متوسط
                                {elseif $value['ability_level']==3}
                                    خوب
                                {elseif $value['ability_level']==4}
                                    عالی
                                {/if}
                            </td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>


            </div>
        {/if}
        {if $objEmployment->getEducationList($employment['eId'])}
            <div class="container">
                <h2>لیست سوابق تحصیلی {$employment['name']}</h2>
                <p>لیست سوابق تحصیلی را در این قسمت مشاهده نمائید</p>
                <table class="table table-bordered request-table">
                    <thead>
                    <tr>
                        <th>مقطع</th>
                        <th>رشته </th>
                        <th>نام موسسه </th>
                        <th>محل موسسه </th>
                        <th>تاریخ شروع </th>
                        <th>تاریخ خاتمه </th>
                        <th>معدل </th>
                        <th>عنوان مقاله </th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $objEmployment->getEducationList($employment['eId']) as $key => $value}
                        <tr>
                            <td>{$value['educational_cross']}</td>
                            <td>{$value['educational_field']}</td>
                            <td>{$value['educational_name_institution']}</td>
                            <td>{$value['educational_institute_location']}</td>
                            <td>{$value['educational_start_date']}</td>
                            <td>{$value['educational_end_date']}</td>
                            <td>{$value['average']}</td>
                            <td>{$value['project_title']}</td>

                        </tr>
                    {/foreach}

                    </tbody>
                </table>


            </div>
        {/if}
        {if $objEmployment->getLanguageList($employment['eId'])}
            <div class="container">
                <h2>لیست زبان های خارجی {$employment['name']}</h2>
                <p>لیست زبان های خارجی را در این قسمت مشاهده نمائید</p>
                <table class="table table-bordered request-table">
                    <thead>
                    <tr>
                        <th>نام زبان</th>
                        <th>سطح مهارت مکالمه </th>
                        <th>سطح مهارت مکاتبه </th>
                        <th>سطح مهارت ترجمه </th>
                        <th>دارای گواهی نامه </th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach $objEmployment->getLanguageList($employment['eId']) as $key => $value}
                        <tr>
                            <td>{$value['language_name']}</td>
                            <td>
                                {if $value['language_conversational_skill_level']==1}
                                    ضعیف
                                {elseif $value['language_conversational_skill_level']==2}
                                    متوسط
                                {elseif $value['language_conversational_skill_level']==3}
                                    خوب
                                {elseif $value['language_conversational_skill_level']==4}
                                    عالی
                                {/if}
                            </td>
                            <td>
                                {if $value['language_correspondence_skill_level']==1}
                                    ضعیف
                                {elseif $value['language_correspondence_skill_level']==2}
                                    متوسط
                                {elseif $value['language_correspondence_skill_level']==3}
                                    خوب
                                {elseif $value['language_correspondence_skill_level']==4}
                                    عالی
                                {/if}
                            </td>
                            <td>
                                {if $value['language_translation_skill_level']==1}
                                    ضعیف
                                {elseif $value['language_translation_skill_level']==2}
                                    متوسط
                                {elseif $value['language_translation_skill_level']==3}
                                    خوب
                                {elseif $value['language_translation_skill_level']==4}
                                    عالی
                                {/if}
                            </td>
                            <td>
                                {if $value['language_certified']==1}
                                    بله
                                {elseif $value['language_certified']==2}
                                    خیر
                                {/if}
                            </td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>


            </div>
        {/if}

        <form data-toggle="validator" method="post" id="editEmployment" enctype='multipart/form-data'>
            <input type="hidden" name="className" value="employment">
            <input type="hidden" name="method" value="updateEmployment">
            <input type="hidden" name="employment_id" value="{$employment.sId}">


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
                                       disabled value="{$employment.created_at}">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="status_id">وضعیت درخواست</label>
                                <select  value="{$employment.status}" name="status_id" id="status_id" class="form-control select2">
                                    <option value="">انتخاب کنید</option>
                                    {foreach $objEmploymentStatus->getRequestServiceStatusList() as $status}
                                        <option value="{$status['id']}"  {if $employment['status']==$status['value']} selected{/if} {if $status['value']=='seen' || $status['value']=='not_seen'} disabled="disabled"{/if}>{$status['title']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="control-label" for="admin_response">یادداشت ادمین </label>
                                <textarea name="admin_response" class="form-control" id="admin_response"
                                          placeholder="یادداشت ادمین">{$employment['admin_response']}</textarea>
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

<script type="text/javascript" src="assets/JsFiles/employment.js">
