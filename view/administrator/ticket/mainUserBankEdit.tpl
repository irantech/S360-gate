{load_presentation_object filename="members" assign="objCounter"}
{load_presentation_object filename="agency" assign="objAgency"}
{assign var="Details" value=$objCounter->showBankDetails($smarty.get.id)}
{$objAgency->getCounterType()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="agencyList">همکاران</a></li>
                <li><a href="counterList&id={$smarty.get.agencyID}">کاربرها</a></li>
                <li class="active">مشخصات حساب بانکی </li>
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
                <h3 class="box-title m-b-0">ویرایش  مشخصات حساب بانکی کاربر </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اطلاعات حساب بانکی کاربر  را در سیستم ویرایش نمائید</p>

                <form id="EditBankInfo" method="post" name="EditBankInfo" data-toggle="validator">
                    <input type="hidden" name="flag" id="flag" value="update_user_bank_detail">
                    <input type="hidden" name="memberID" id="memberID" value="{$smarty.get.id}">
                    <div class="form-group col-sm-6 ">

                        <label for="name" class="control-label">نام و نام خانوادگی صاحب حساب</label>
                        <input type="text" class="form-control" id="nameHesab" name="nameHesab"
                               placeholder="نام  و نام خانوادگی صاحب حساب را وارد نمائید" value="{$Details['name_hesab']}">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="family" class="control-label">شماره شبا</label>
                        <input type="text" class="form-control" id="sheba" name="sheba"
                               placeholder="شماره شبای کاربر را وارد نمائید" value="{$Details['sheba']}">

                    </div>


                    <div class="form-group col-sm-6">
                        <label for="mobile" class="control-label">شماره حساب بانکی</label>
                        <input type="text" class="form-control" id="hesabBank" name="hesabBank"
                               placeholder=" شماره حساب بانکی کاربر را وارد نمائید" value="{$Details['bank_hesab']}">

                    </div>






                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/mainUser.js"></script>

