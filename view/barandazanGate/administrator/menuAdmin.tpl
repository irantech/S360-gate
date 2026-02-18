{load_presentation_object filename="admin" assign="objAdmin"}

{assign var="level1menu" value=$objAdmin->listLevel1Admin()}
{assign var="level2menu" value=$objAdmin->listLevel2Admin()}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">لیست منو ادمین</li>

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
                <form id="addMenuAdmin" method="post">
                    <input type="hidden" name="flag" value="addMenuAdmin">

                    <div class="form-group col-sm-4">
                        <label for="title" class="control-label">نام بخش</label>
                        <input type="text" name="title" id="title" value=""
                               class="form-control"
                               placeholder="لطفا نام صفحه را وارد کنید را وارد کنید">
                    </div>
                    <div class="form-group col-sm-8">
                        <label for="title" class="control-label">نام انگلیسی بخش <small style="color: red">(برای استفاده در نام تگ ترجمه چند زبانه - نامی که وارد میکنید باید هم نام با تگ آن در فایل های xml باشد.)</small></label>
                        <input type="text" name="title_en" id="title_en" value=""
                               class="form-control"
                               placeholder="لطفا نام انگلیسی صفحه را وارد کنید را وارد کنید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="mainMenu" class="control-label">بخش اصلی</label>
                        <select name="mainMenu" id="mainMenu"
                                class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            {foreach $level1menu as $key=>$level1}
                                <option value="{$level1.id}">{$level1.title}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="subMenu" class="control-label">بخش زیر مجموعه</label>
                        <select name="subMenu" id="subMenu"
                                class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            {foreach $level2menu as $key=>$level2}
                                <option value="{$level2.id}">{$level2.title}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="accessCustomer" class="control-label">آیا ادمین اصلی مشتری دسترسی دارد؟</label>
                        <select name="accessCustomer" id="accessCustomer"
                                class="form-control select2">
                            <option value="">انتخاب کنید....</option>
                            <option value="1">بله</option>
                            <option value="0">خیر</option>

                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="url" class="control-label"></label> آدرس صفحه<small style="color: red">به طور مثال (itadmin/ticket/ticketHistory)</small>
                        <input type="text" name="url" id="url" value=""
                               class="form-control"
                               placeholder="لطفا نام صفحه را وارد کنید را وارد کنید">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="url" class="control-label"></label> کلاس css منو<small style="color: red">هر کلاس را با یک فاصله وارد نمائید</small>
                        <input type="text" name="classIcon" id="classIcon" value=""
                               class="form-control"
                               placeholder=" به طور مثال fa fa-text  ">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/menuAdmin.js"></script>