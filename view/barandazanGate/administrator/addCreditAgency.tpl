{assign var="infoBank" value=$objFunctions->InfoBank()}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active"> افزایش اعتبار</li>

            </ol>
        </div>
    </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">

                    <h3 class="box-title m-b-0">افزودن اعتبار حساب کاربری</h3>
                    <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید اعتبار حساب کاربری خود را افزایش
                        دهید </p>

                    <form id="increaseCreditAgency" method="post" action="goToBankAgency" >
                        <input type="hidden" name="flag" value="increaseCreditAgency">
                        <input type="hidden" name="idMemberLoginToAdmin" value="{$smarty.session.memberIdCounterInAdmin}">

                        <div class="form-group col-sm-6">

                            <label for="amount" class="control-label">مبلغ اعتبار<small class="text-muted m-b-30"></small></label>
                            <input type="text" class="form-control" id="amount" name="amount"
                                   placeholder="مبلغ مورد نظر را به ریال وارد نمایید">
                        </div>

                            <div class="form-group col-sm-6 ">
                                <label for="typeCredit" class="control-label">نوع افزایش اعتبار</label>
                                <select class="form-control" name="typeCredit" id="typeCredit"  onchange="selectBank(this);">
                                    <option value="">انتخاب کنید...</option>
                                        <option value="fast">افزایش اعتبار آنی</option>
{*                                        <option value="slow">افزایش اعتبار بعد از تایید مدیریت</option>*}
                                </select>
                            </div>

                        <div class="form-group col-sm-6" style="display:none"  id="selectBankAgency">
                            {foreach $infoBank as $key => $bank}
                                <div class="radio radio-primary">
                                    <i class="fa fa-check tick_bank"></i>
                                    <input class="input_bank" type="radio" name="bank" value="{$bank['bank_dir']}"
                                           id="{$bank['bank_dir']}" {if $key eq 0}checked="checked"{/if} disabled="disabled">
                                    <label for="{$bank['bank_dir']}">
                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/assets/images/bank/bank{$bank['title_en']}.png"
                                             alt="{$bank['title']}" class="s-u-bank-logo s-u-bank-logo-bank">
                                    </label>
                                </div>
                            {/foreach}
                        </div>

                        <div class="form-group col-sm-6 ">


                            <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                                 id="loadingbank">
                            <button type="submit" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank">
                                پرداخت
                            </button>
                            </div>
                    </form>


                    <div class="clearfix"></div>

                </div>
            </div>
        </div>


</div>

<script type="text/javascript" src="assets/JsFiles/accountcharge.js"></script>


