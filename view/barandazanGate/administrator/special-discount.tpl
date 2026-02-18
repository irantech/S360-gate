{load_presentation_object filename="servicesDiscount" assign="objServicesDiscount"}
{assign var="listSpecialServiceDiscount" value=$objServicesDiscount->listSpecialServiceDiscount()} {*گرفتن لیست تخفیف ها*}

{assign var="getAllServices" value=$objServicesDiscount->getAllServices()} {*گرفتن لیست خدمات*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li class="active">تخفیف ها</li>
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
                <h3 class="box-title m-b-0">اضافه کردن تخفیف جدید</h3>
                <p class="text-muted m-b-30">
                    در فرم زیر میتوانید  تخفیف را براساس پیش شماره تلفن و یا پیش مشاره کارت ملی اعمال کنید
                    <small class="color-red">( توجه داشته باشید این تخفیف فقط برای اولین خرید برای مشتری شما اعمال خواهد شد)</small>
                </p>

                    <form name="special_discount" id="special_discount" method="post" class="d-flex flex-wrap">
                        <div class="form-group  col-sm-32">
                            <label for="service_title">عنوان سرویس:</label>
                            <select name="service_title" id="service_title" class="form-control select2">
                                <option value="">انتخاب کنید</option>
                                {foreach $getAllServices as $key=>$service}
                                    {if $key lt '8'}
                                    <option value="{$service.TitleEn}">{$service.TitleFa}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group  col-sm-3">
                            <label for="type_get_discount">تخفیف بر اساس:</label>
                            <select name="type_get_discount" id="type_get_discount" class="form-control" onchange="detectTypeDiscount(this)">
                                <option value="">انتخاب کنید</option>
                                <option value="phone">بر اساس پیش شماره همراه </option>
                                <option value="national_code">بر اساس کد ملی</option>
                            </select>
                        </div>

                        <div class="form-group  col-sm-2">
                            <label for="type_discount">نوع تخفیف:</label>
                            <select name="type_discount" id="type_discount" class="form-control" >
                                <option value="">انتخاب کنید</option>
                                <option value="cash">نقدی</option>
                                <option value="percent">درصد</option>
                            </select>
                        </div>

                        <div class="form-group  col-sm-2">
                            <label for="pre_code">پیش شماره/کد ملی:</label>
                            <input type="text" name="pre_code" id="pre_code" value="" class="form-control" maxlength="4">
                        </div>
                        <div class="form-group  col-sm-2">
                            <label for="amount">میزان تخفیف:</label>
                            <input type="text" name="amount" id="amount" value="" class="form-control">
                        </div>

                        <div class="form-group  col-sm-3">
                            <label></label>
                            <button class="btn btn-primary">ارسال</button>
                        </div>

                    </form>
            </div>

        </div>
    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"> تخفیف های خاص </h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th> ردیف</th>
                            <th>نام سرویس</th>
                            <th>نوع</th>
                            <th>بر اساس</th>
                            <th>شماره همراه/کد ملی</th>
                            <th>میزان/مبلغ</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$listSpecialServiceDiscount}

                            {$number=$number+1}
                            <tr>
                                <td>{$number}</td>
                                <td>{$item['service_title']}</td>
                                <td>{$item['type_discount']}</td>
                                <td>{$item['type_get_discount']}</td>
                                <td>{$item['pre_code']}</td>
                                <td>{$item['amount']} </td>
                                <td>{$item['is_del_title']} </td>
                                <td>
                                    {if $item['is_del'] eq '0'}
                                        <a onclick="deleteSpecialDiscount('{$item['id']}')"
                                           class=""><i
                                                    class="fcbtn btn btn-outline btn-danger btn-1e fa fa-close tooltip-danger"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="حذف تخفیف"></i></a>
                                        {else}
                                        <a href="#" onclick="return false"
                                           class=""><i
                                                    class="fcbtn btn btn-outline btn-default btn-1e fa fa-trash tooltip-default"
                                                    data-toggle="tooltip" data-placement="top" title=""
                                                    data-original-title="حذف شده"></i></a>
                                    {/if}
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

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش تنظیمات تخفیف</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/396/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript" src="assets/JsFiles/servicesDiscount.js"></script>