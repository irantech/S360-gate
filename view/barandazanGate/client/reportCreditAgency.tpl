{load_presentation_object filename="agency" assign="objAgency"}
{assign var='checkAccessService' value=$objAgency->checkAccessSubAgency()}
{if $objSession->IsLogin() && $smarty.session.typeUser eq 'agency' && $smarty.session.AgencyId gt 0}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    {assign var="profile" value=$objAgency->getAgency($objSession->getAgencyId())} {*گرفتن اطلاعات کاربر*}
    {assign var="info_credit" value=$objAgency->getSumCreditAgency($objSession->getAgencyId())} {*گرفتن اطلاعات کاربر*}
    {assign var="total_credit" value=$objAgency->CreditAgency($objSession->getAgencyId())} {*گرفتن اطلاعات کاربر*}
    {assign var="total_credit" value=$objAgency->CreditAgency($objSession->getAgencyId())}

    {assign var='bank_list' value=$objAgency->getBankList()}
    <div class="container">
        <div class="row agency-credit-payment">
            <div class="alert alert-secondary parent-agency-box" role="alert">
              <div class='agency-item'>
                  <span class=''>اعتبار غیر مالی:</span>
                  <span>{$profile['limit_credit']|number_format} ریال</span>
              </div>
                <div class='agency-item'>
                    <span class=''>اعتبار شارژی:</span>
                    <span>{$info_credit['sum_increase_credit']|number_format} ریال</span>
                </div>
                <div class='agency-item'>
                    <span class=''>خرید:</span>
                    <span>{$info_credit['sum_decrease_credit']|number_format} ریال</span>
                </div>
                <div class='agency-item'>
                    <span class=''>باقیمانده اعتبار:</span>
                    <span>{$total_credit|number_format} ریال</span>
                </div>
            </div>
            <div class="col-12 col-lg-6 p-0">
                <p class="reportCreditAgency__parent-form-pay_p">برای افزایش اعتبار از کادر زیر استفاده نمایید :</p>
                <div class="reportCreditAgency__bank_style-new pl-2">
                    {foreach $bank_list as $bank}
                    <label class="reportCreditAgency__custom-radio">
                        <input type="radio" value="{$bank['bank_dir']}" name="bank_to_pay">
                        <span class="reportCreditAgency__radio-btn">
                            <svg class="reportCreditAgency__svg-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path></svg>
                            <div class="reportCreditAgency__hobbies-icon">
                                <img src="assets/images/bank/bank{$bank['title_en']}.png" alt="{$bank['title']}">
                                <span>{$bank['title']}</span>
                            </div>
                        </span>
                    </label>
                    {/foreach}
                </div>

                {if $profile['limit_credit'] > 0 && $profile['time_limit_credit'] neq ""}
                    {assign var="type_pay" value="settle"}
                    {assign var="price" value=$total_credit}
                {else}
                    {assign var="type_pay" value="increase"}
                    {assign var="price" value=0}

                {/if}

                <div class='form-group w-100 d-flex m-0'>
                    {assign var="bankInputs" value=['serviceType' => 'charge_credit_sign','type_pay'=>$type_pay ,'additionalData' => $profile['raja_unique_code']]}
                    {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankCreditAgency"}
                    <input type="text" class="form-control reportCreditAgency__width_calc" name="amount_to_pay" id="amount_to_pay" placeholder='مبلغ مورد نظر را وارد نمایید'{if $type_pay eq 'settle'} readonly="readonly" {/if}{if $price lt 0 } value="{$price|abs}" {/if} >
                    <button class="btn btn-info mr-1 cashPaymentLoader" {if $type_pay eq 'settle' && $price lt 0 }onclick='goBankCreditAgency("{$bankAction}",{$bankInputs|json_encode})' {elseif $type_pay neq 'settle'}onclick='goBankCreditAgency("{$bankAction}",{$bankInputs|json_encode})'{else}disabled="disabled"{/if}><i>پرداخت</i></button>
                </div>

            </div>
            <div class="col-12 col-lg-6 p-0">
                <img class='reportCreditAgency__img-style-card-hand-smart-phone-laptop' src='assets/images/bank/reportCreditAgency.png' alt='card-hand-smart-phone-laptop'>
            </div>
        </div>
    </div>

    <div class="client-head-content w-100">
        <div class="loaderPublic" style="display: none;">
            <div class="positioning-container">
                <div class="spinning-container">
                    <div class="airplane-container">
                        <span class="zmdi zmdi-airplane airplane-icon site-main-text-color"></span>
                    </div>
                </div>
            </div>
            <div class='loader'>
                <div class='loader_overlay'></div>
                <div class='loader_cogs'>
                    <i class="fa fa-globe site-main-text-color-drck"></i>
                </div>
            </div>
        </div>
        <div class="loaderPublicForHotel" style="display: none;"></div>
        <div class="row">

            <div class="col-lg-12">
                <table onclick="" id="reportCreditAgency" class="table table-sm">
                </table>
            </div>
        </div>
    </div>
{literal}
    <script>
        $(document).ready(function () {
            getCategoryData('#reportCreditAgency');
        });

        function refreshData(targetTable) {
            targetTable.DataTable().clear().destroy();
            targetTable.children('tr').remove();
            targetTable.children('tbody').remove();
            targetTable.children('thead').remove();

        }

        function getCategoryData(targetTable) {
            targetTable = $(targetTable);
            if (targetTable.children('thead').length > 0) {
                refreshData(targetTable);
            }
            var columns = [

                {
                    "title": "شماره واچر/فاکتور",
                    "data": "requestNumber"
                }, {
                    "title": "توضیحات",
                    "data": "comment"
                }, {
                    "title": "تاریخ ترکنش",
                    "data": "dateBuy"
                }, {
                  "title": "مبلغ تراکنش (ریال)",
                  "data": "credit"
               },
               {
                  "title": "مانده (ریال)",
                  "data": "balance_after"
               },
            //    {
            //         "title": "دلیل تراکنش",
            //         "data": "reason"
            //     }
            // ,
               {
                    "title": "نوع تراکنش",
                    "data": "typeCredit"
                } ,{
                  "title": "type",
                  "data": "type"
               }
            ];

            targetTable.DataTable({
                dom: "Bfrtip",
                info: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                'serverMethod': 'post',
                'ajax': {
                    'url': amadeusPath + "user_ajax.php",
                    'data': {
                        flag: 'agencyCreditReport',
                        dataTable: false,
                    },
                },
                columns: columns

            });

        }
    </script>
{/literal}
{else}
    {$objFunctions->redirectOutAgency()}
{/if}