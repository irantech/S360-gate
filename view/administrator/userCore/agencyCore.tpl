{if $smarty.const.TYPE_ADMIN eq 1}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/userCore/listAgencyCore">لیست آژانس - سرور</a></li>
                    <li class="active">ثبت آژانس</li>

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
                    <h3 class="box-title m-b-0">افزودن آژانس به سیستم Core</h3>

                    <form id="InsertAgencyCore" method="post">
                        <input type="hidden" name="Method" value="InsertAgency">
                        <input type="hidden" name="flag" value="InsertAgencyCore">

                        <div class="form-group col-sm-6">

                            <label for="name" class="control-label">نام آژانس</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="نام آژانس  مورد نظر را به لاتین وارد نمایید">
                        </div>


                        <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                             id="loadingbank">
                        <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank">
                            ارسال
                        </button>
                    </form>


                    <div class="clearfix"></div>

                </div>
            </div>
        </div>





</div>

<script type="text/javascript" src="assets/JsFiles/core.js"></script>
{/if}


