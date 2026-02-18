{load_presentation_object filename="organizationLevel" assign="ObjOrganization"}
{assign var="info" value=$ObjOrganization->getOrganizationByID($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>خدمات ویژه</li>
                <li><a href="organization">لیست سطوح سازمانی</a></li>
                <li class="active">ویرایش سطح سازمانی</li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش سطح سازمانی</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید سطوح سازمانی که در کد تخفیف مورد استفاده قرار می گیرد را در سیستم ثبت نمائید</p>

                <form data-toggle="validator" id="organizationEdit" method="post">
                    <input type="hidden" name="flag" value="organizationEdit">
                    <input type="hidden" name="id" value="{$info['id']}">

                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">سطح سازمانی</label>
                        <input type="text" class="form-control" id="title" name="title" value="{$info['title']}"
                               placeholder="سطح سازمانی را وارد نمائید">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/organizationLevel.js"></script>

