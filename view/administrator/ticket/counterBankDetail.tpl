{load_presentation_object filename="members" assign="objCounter"}
{load_presentation_object filename="agency" assign="objAgency"}
{assign var="Details" value=$objCounter->showBankDetails($smarty.get.id)}
{$objCounter->showedit($smarty.get.id)}
{$objAgency->getCounterType()}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $objsession->adminIsLogin()}
                    <li><a href="agencyList">همکاران</a></li>
                {else}
                    <li>کاربران</li>
                {/if}
                <li><a href="counterList&id={$smarty.get.agencyID}">کانترها</a></li>
                <li class="active">مشخصات حساب بانکی</li>
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
                {if $objsession->adminIsLogin()}
                    {assign var="AgencyId" value=$smarty.get.agencyID}
                {else}
                    {assign var="AgencyId" value=$objsession->getAgencyId()}
                {/if}

                <form id="EditBankInfoCounter" method="post" name="EditBankInfoCounter" data-toggle="validator" enctype="multipart/form-data">

                    <input type="hidden" name="flag" id="flag" value="update_counter_bank_detail">
                    <input type="hidden" name="agency_id" id="agency_id" value="{$AgencyId}">
                    <input type="hidden" name="memberID" id="memberID" value="{$objCounter->list['id']}">
                    {if $objCounter->list['fk_counter_type_id'] eq 1}
                    <input type="hidden" name="typeMember" id="typeMember" value="mother">
{else}
                        <input type="hidden" name="typeMember" id="typeMember" value="normal">
                    {/if}
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
                        {if $objCounter->list['fk_counter_type_id'] eq 1}

                            <div class="form-group col-sm-6">
                            <label for="picture" class="flr">عکس پرسنلی:<span class="condition">"سایز عکس حداکثر 200کیلوبایت باشد"</span></label>
                            <input type="file" name="picture" id="picture"  placeholder="عکس پرسنلی" aria-invalid="false">
                        </div>
                            {if $Details['picture'] neq ''}
                    <div class="form-group col-sm-6">
                                <div class="image-Emerald">
                                    <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$Details['picture']}">
                                </div>
                        </div>
                            {/if}
                        {/if}



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


<script type="text/javascript" src="assets/JsFiles/counter.js"></script>

