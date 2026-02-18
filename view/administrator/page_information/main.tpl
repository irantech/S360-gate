{load_presentation_object filename="infoPages" assign="objInfoPages"}
{assign var="pages" value=$objInfoPages->getPages()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

                <li class="active">عنوان صفحات</li>
            </ol>
        </div>
    </div>

    <div class="white-box d-flex flex-wrap col-xs-12 p-30 gap-10">
        <div class="plans w-100">
            <div class="d-flex gap-10 w-100">
                <label class="plan basic-plan w-100 m-0" for="main_page">
                    <input checked type="radio" onchange='toggleable($(this));'
                           value='main_page'
                           name="page_type"
                           id="main_page" />
                    <div class="plan-content w-100">
                        <img loading="lazy"
                             src="assets/images/git.png"
                             alt="" />
                        <div class="plan-details">
                            <span>صفحات داخلی</span>
                            <p>ویرایش نام صفحات داخلی</p>
                        </div>
                    </div>
                </label>

                <label class="plan complete-plan w-100 m-0" for="main_services">
                    <input type="radio" onchange='toggleable($(this))'
                           id="main_services"
                           value='main_services'
                           name="page_type" />
                    <div class="plan-content w-100">
                        <img loading="lazy"
                             src="assets/images/search-icon.png"
                             alt="" />
                        <div class="plan-details">
                            <span>صفحات نتایج جستجو</span>
                            <p>
                                ویرایش نام صفحات نتایج جستجوی سرویس های شما
                            </p>
                        </div>
                    </div>
                </label>
            </div>
        </div>


    </div>

    <div class="row">


        <div class="col-sm-12">
            <div class="white-box">



                <div class="row">
                    <div class="col-sm-12">
                        <div class="border border-primary rounded white-box">
                            <h3 class="box-title m-b-0 font-bold font-16">آپلود فایل Robots.txt</h3>
                            <p class="text-muted  ">
                                در این قسمت میتوانید فایل روبوت را آپلود نمایید. توجه داشته باشید که:

                            </p>
                            <ul class='m-b-30'>
                                <li>پسوند فایل فقط می تواند txt  باشد</li>

                            </ul>

                            <form id="uploadRobotsTxt" method="post" enctype="multipart/form-data">
                                <input type='hidden' value='infoPages' id='className' name='className'>
                                <input type='hidden' value='uploadRobotsFile' id='method' name='method'>
                                <div class="form-group col-sm-6">
                                    <label for="robots_file">آپلود فایل</label>
                                    <input type="file" name="robots_file" id="robots_file"
                                           class="dropify" data-height="100" />

                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group  pull-right">
                                            <button type="submit" class="btn btn-info waves-effect waves-light">
                                                <span class="btn-label"><i class="fa fa-plus"></i></span>
                                                ارسال فایل
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>

                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/page_information/insert"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    تعریف عنوان جدید
                </a>
                <a onclick="createSiteMap('{$smarty.const.CLIENT_ID}'); return false"
                   class="btn btn-info waves-effect waves-light mb-5" type="button">
                    <span class="btn-label"><i class="fa fa-plus"></i></span>
                    ایجاد نقشه سایت
                </a>



                <div class="w-100 main_page-toggleable   flex-wrap">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>زبان</th>
                                <th>title</th>
                                <th>آدرس صفحه</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $objInfoPages->getMainPages() as $key=>$item}
                                <tr>
                                    <td>{$key+1}</td>
                                    <td>{$languages[$item.language]}</td>
                                    <td>{$item.title}</td>
                                    <td>
                                        {$item.switch.title}
                                    </td>
                                    <td class='align-items-center d-flex gap-7'>
                                        <a href="edit&id={$item.id} " class="">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary rounded"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="ویرایش بخش">
                                            </i>
                                        </a>
                                        <button class="btn btn-sm btn-outline btn-danger "
                                                onclick='deletePage("{$item.id}")'
                                                data-id="{$item.id}"><i class="fa fa-trash"></i> حذف
                                        </button>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="w-100 main_services-toggleable  d-none flex-wrap">
                    <div class="table-responsive w-100">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>زبان</th>
                                <th>title</th>
                                <th>سرویس</th>
                                <th>آدرس صفحه</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $objInfoPages->getServicePages() as $key=>$item}
                                <tr>
                                    <td>{$key+1}</td>
                                    <td>{$item.title}</td>
                                    <td>{$languages[$item.language]}</td>
                                    <td class='align-items-center d-flex gap-7'>
                                        {if $item.service.service}
                                            <span class='fa fa-check-square bg-success rounded-max p-3'></span>
                                            {$objFunctions->Xmlinformation($item.service.service)}
                                        {/if}
                                    </td>

                                    <td>
                                        {$item.service.origin_name}
                                        به
                                        {$item.service.destination_name}
                                    </td>
                                    <td class='align-items-center d-flex gap-7'>
                                        <a href="edit&id={$item.id} " class="">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit tooltip-primary rounded"
                                               data-toggle="tooltip" data-placement="top" title=""
                                               data-original-title="ویرایش بخش">
                                            </i>
                                        </a>
                                        <button class="btn btn-sm btn-outline btn-danger "
                                                onclick='deletePage("{$item.id}")'
                                                data-id="{$item.id}"><i class="fa fa-trash"></i> حذف
                                        </button>
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
</div>

<script type="text/javascript" src="assets/modules/js/page_information/page_information.js"></script>