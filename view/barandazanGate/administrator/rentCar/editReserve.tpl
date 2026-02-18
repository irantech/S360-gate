{load_presentation_object filename="rentCar" assign="objRentCar"}
{assign var="getData" value=$objRentCar->getRentCarReserve($smarty.get.id)}
{load_presentation_object filename="requestServiceStatus" assign="objStatus"}
{assign var="info_car" value=$objRentCar->getRentCar($getData['carId'])}
{assign var="info_category" value=$objRentCar->getCategory($info_car['cat_id'])}
{assign var="info_brand" value=$objRentCar->getBrand($info_car['brand_id'])}
{load_presentation_object filename="mainCity" assign="objCity"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">

                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>
                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/rentCar/iranVisa/list">
                        لیست درخواست اجاره خودرو
                    </a>
                </li>
                <li class='active'>
                    جزییات درخواست اجاره خودرو
                    <span class='font-bold underdash'>{$getData['name']}</span>
                </li>
            </ol>
        </div>
    </div>

    <div class="row orderServices">
        <div class="container">
            <h2>اطلاعات درخواست کننده خودرو</h2>
            <p>همه اطلاعات درخواست کننده را در این قسمت مشاهده نمائید</p>
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
                    <td>تعداد</td>
                    <td>{if $getData['count_people']}{$getData['count_people']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>تاریخ اجاره</td>
                    <td>{if $getData['rent_date']}{$getData['rent_date']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>محل اجاره</td>
                    <td>
                        {if $getData['rent_place']}

                            {if $getData['rent_place']==202}
                                سایر
                           {else}
                                استان  {$getData['rent_place_name']}
                            {/if}

                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>تاریخ تحویل</td>
                    <td>{if $getData['delivery_date']}{$getData['delivery_date']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>محل تحویل</td>
                    <td>
                        {if $getData['delivery_place']}
                            {if $getData['delivery_place']==202}
                                سایر
                            {else}
                                استان  {$getData['delivery_place_name']}
                            {/if}

                        {else}
                            ---
                        {/if}
                    </td>
                </tr>
                <tr>
                    <td>ایمیل</td>
                    <td>{if $getData['email']}{$getData['email']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>موبایل</td>
                    <td>{if $getData['mobile']}{$getData['mobile']}{else}---{/if}</td>
                </tr>






                </tbody>
            </table>

        </div>

        <div class="container">
            <h2>جزییات خودروی درخواستی </h2>
            <p>همه اطلاعات خودرو درخواست شده را در این قسمت مشاهده نمائید</p>
            <table class="table table-bordered request-table">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>متن </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>نام خودرو</td>
                    <td>{if $info_car['title']}{$info_car['title']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>کد خودرو</td>
                    <td>{if $info_car['code']}{$info_car['code']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>قیمت مشتری</td>
                    <td>{if $info_car['price_customer']}{$info_car['price_customer']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>قیمت همکار</td>
                    <td>{if $info_car['price_colleague']}{$info_car['price_colleague']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>دسته بندی خودرو</td>
                    <td>{if $info_car['cat_id']}{$info_category['title']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>برند خودرو</td>
                    <td>{if $info_car['brand_id']}{$info_brand['title']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>توضیحات کوتاه خودرو</td>
                    <td>{if $info_car['content']}{$info_car['content']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>توضیحات بیشتر خودرو</td>
                    <td>{if $info_car['description']}{$info_car['description']}{else}---{/if}</td>
                </tr>
                <tr>
                    <td>اطلاعات بیشتری از خودروی درخواستی ببینید</td>
                    <td>
                        <a href="carEdit&id={$info_car['id']}" target='_blank' class="btn btn-primary">
                            اطلاعات کامل خودرو
                        </a>
                    </td>
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

<script type="text/javascript" src="assets/JsFiles/rentCar.js">
