{load_presentation_object filename="memberGroups" assign="objGroups"}
{assign var="groupInfo" value=$objGroups->getGroupByID($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="memberGroups">لیست گروه بندی اعضا</a></li>
                <li class="active">ویرایش گروه</li>
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
                <h3 class="box-title m-b-0">ویرایش گروه</h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید گروه بندی مورد نیاز برای اعضای سیستم را ثبت نمائید</p>

                <form data-toggle="validator" id="memberGroupsEdit" method="post">
                    <input type="hidden" name="flag" value="memberGroupsEdit">
                    <input type="hidden" name="id" value="{$groupInfo['id']}">

                    <div class="form-group col-sm-6 ">
                        <label for="title" class="control-label">عنوان گروه</label>
                        <input type="text" class="form-control" id="title" name="title" value="{$groupInfo['title']}"
                               placeholder="عنوان گروه را وارد نمائید">
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

<script type="text/javascript" src="assets/JsFiles/memberGroups.js"></script>

