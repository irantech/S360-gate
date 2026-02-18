{load_presentation_object filename="parvazBookingLocal" assign="objBookingLocal"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}

{* variables needed to be set for display *}
{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var='offCode' value=''}


{$objBookingLocal->returnBankSource7($smarty.get.requestNumber,$smarty.post['input_bank_resultpay'])}

{if $objBookingLocal->transactionStatus neq 'failed' && $objBookingLocal->trackingCode neq ''}
    {$bankTrackingCode = $objBookingLocal->trackingCode}
    {$successPayment = 'true'}

    {$objBookingLocal->updateBank($objBookingLocal->trackingCode,$objBookingLocal->factorNumber)}

    {if ($objBookingLocal->ok_flight['dept'] eq true)}
        {* برای تثبیت استفاده خریدار از کد تخفیف *}
        {load_presentation_object filename="discountCodes" assign="objDiscountCodes"}
        {$objDiscountCodes->DiscountCodesUseConfirm($objBookingLocal->factorNumber)}
        {* برای تثبیت اعتبار کسر شده در هنگام خرید مسافر آنلاین *}
        {$objMembers->memberCreditConfirm($objBookingLocal->factorNumber, $objBookingLocal->trackingCode)}
        {* برای ثبت اعتبار تخفیف کد معرف به معرف خریدار در صورتی که اولین خرید باشد *}
        {if $objSession->IsLogin()}
            {$objMembers->addCreditToReagent()}
        {/if}

    {/if}

{else}
    {$successPayment = 'false'}
    {$errorPaymentMessage = $objBookingLocal->failMessage}

    {$objBookingLocal->delete_transaction_current($objBookingLocal->factorNumber)}
{/if}



{* display with initialized variables *}
{if $successPayment eq 'true'}

    {if $objBookingLocal->ok_flight['dept'] eq true}
        <div class="return-bank-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 mr-auto ml-auto">
                        <div class="return-bank-inner">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="success-icon">
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 507.2 507.2" style="enable-background:new 0 0 507.2 507.2;"
                                             xml:space="preserve">
                                        <circle style="fill:#32BA7C;" cx="253.6" cy="253.6" r="253.6"/>
                                            <path style="fill:#0AA06E;"
                                                  d="M188.8,368l130.4,130.4c108-28.8,188-127.2,188-244.8c0-2.4,0-4.8,0-7.2L404.8,152L188.8,368z"/>
                                            <g>
                                                <path style="fill:#FFFFFF;"
                                                      d="M260,310.4c11.2,11.2,11.2,30.4,0,41.6l-23.2,23.2c-11.2,11.2-30.4,11.2-41.6,0L93.6,272.8c-11.2-11.2-11.2-30.4,0-41.6l23.2-23.2c11.2-11.2,30.4-11.2,41.6,0L260,310.4z"/>
                                                <path style="fill:#FFFFFF;"
                                                      d="M348.8,133.6c11.2-11.2,30.4-11.2,41.6,0l23.2,23.2c11.2,11.2,11.2,30.4,0,41.6l-176,175.2c-11.2,11.2-30.4,11.2-41.6,0l-23.2-23.2c-11.2-11.2-11.2-30.4,0-41.6L348.8,133.6z"/>
                                            </g>
                                    </svg>
                                    </div>
                                    <div class="success-text">
                                        <div class="success-text-title">##Successpayment##</div>
                                        <div class="success-text-info">
                                            <p>##SuccessMessageRetrunBank##</p>
                                        </div>
                                    </div>
                                        <div class="faktor-btns">
                                        <span>##Wentflight##  </span>
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=boxCheck&id={$objBookingLocal->request_number['dept']}"
                                           class="" target="_blank">##BoxCheck##</a>
                                        {if $objBookingLocal->ok_flight['dept'] eq true}

                                            {if $objBookingLocal->IsInternal eq '1'}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=parvazBookingLocal&id={$objBookingLocal->request_number['dept']}"
                                                   class="" target="_blank">##PdfFile##</a>
                                            {else}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=ticketForeign&id={$objBookingLocal->request_number['dept']}"
                                                   class="" target="_blank">##PdfFile##</a>
                                            {/if}
                                            <a onclick="modalEmail('{$objBookingLocal->request_number[$direction]}');"
                                               class="" target="_blank">##Sendemailanother##</a>
                                            </div>
                                        {/if}
                                </div>
                                <div class="col-md-6">
                                    <div class="panel-return">
                                        <div class="panel-return-head">
                                            <span>##PurchaseInformation##</span>
                                        </div>
                                        <div class="panel-return-content">
                                            <div>
                                                <span> ##Agentbank##</span><span>##privateGetWay##</span>
                                            </div>
                                            <div>
                                                <span>##Buydate##</span><span>{$objFunctions->set_date_payment($objBookingLocal->payment_date)}</span>
                                            </div>
                                            <div><span>##TrackingCode##</span><span>{$bankTrackingCode}</span></div>
                                            <div>
                                                <span>##Invoicenumber##</span><span>{$objBookingLocal->factor_num}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {foreach $objBookingLocal->direction as $direction}
                                        {if $objBookingLocal->ok_flight[$direction] eq true}


                                            {$offCode = $objOffCode->offCodeUse($objBookingLocal->factor_num, $objBookingLocal->ticketInfo[$direction]['serviceTitle'], $objBookingLocal->ticketInfo[$direction]['desti_airport_iata'], $objBookingLocal->ticketInfo[$direction]['origin_airport_iata'])}
                                            {if $offCode neq ''}
                                                <div class="text-code-takhfif">
                                                    {assign var='code' value=$offCode['code']}
                                                    {assign var='title' value=$offCode['title']}
                                                    {functions::StrReplaceInXml(["@@CodeDiscount@@"=>$code,"@@title@@"=>$title],"AwardDiscountCode")}
                                                </div>
                                            {/if}
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {if $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
            <div class="return-bank-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mr-auto ml-auto">
                            <div class="return-bank-inner price-change">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="change-price">
                                            <div class="change-price-titile">
                                                ##IncreasePrice##
                                            </div>
                                            <div>##DearCounter##</div>
                                            <div class="change-price-info">
                                                <p>##NewPriceForTicket##</p>


                                                <p>##InfoNewPriceForTicket##</p>
                                                <div class="change-price-input">
                                                    <input placeholder="##EnterYourPriceToRial##" type="text"
                                                           name="ChangePriceStepFinal"
                                                           data-factorNumber="{$objBookingLocal->factor_num}"
                                                           id="ChangePriceStepFinal">
                                                    <button onclick="ChangePriceStepFinal()"
                                                            id="ChangePriceStepFinalBtn">##Send##
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    {else}
        <div class="return-bank-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 mr-auto ml-auto">
                        <div class="return-bank-inner return-error">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="success-icon">
                                        <?xml version="1.0" encoding="iso-8859-1"?>
                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 507.2 507.2" style="enable-background:new 0 0 507.2 507.2;"
                                             xml:space="preserve">
                                    <circle style="fill:#F15249;" cx="253.6" cy="253.6" r="253.6"/>
                                            <path style="fill:#AD0E0E;"
                                                  d="M147.2,368L284,504.8c115.2-13.6,206.4-104,220.8-219.2L367.2,148L147.2,368z"/>
                                            <path style="fill:#FFFFFF;" d="M373.6,309.6c11.2,11.2,11.2,30.4,0,41.6l-22.4,22.4c-11.2,11.2-30.4,11.2-41.6,0l-176-176
                                        c-11.2-11.2-11.2-30.4,0-41.6l23.2-23.2c11.2-11.2,30.4-11.2,41.6,0L373.6,309.6z"/>
                                            <path style="fill:#D6D6D6;" d="M280.8,216L216,280.8l93.6,92.8c11.2,11.2,30.4,11.2,41.6,0l23.2-23.2c11.2-11.2,11.2-30.4,0-41.6
                                        L280.8,216z"/>
                                            <path style="fill:#FFFFFF;" d="M309.6,133.6c11.2-11.2,30.4-11.2,41.6,0l23.2,23.2c11.2,11.2,11.2,30.4,0,41.6L197.6,373.6
                                        c-11.2,11.2-30.4,11.2-41.6,0l-22.4-22.4c-11.2-11.2-11.2-30.4,0-41.6L309.6,133.6z"/>
                                    </svg>

                                    </div>
                                    <div class="success-text">
                                        <div class="success-text-title">##ProblemreservationTicket##</div>
                                        <div class="success-text-info">
                                            <p>
                                                {if $paymentType eq 'credit'}
                                                    {functions::StrReplaceInXml(["@@PaymentType@@"=>"##Validity##","@@typeReserve@@"=>"##BookTicket##"],"ErrorReserveReturnBank")}
                                                {else}
                                                    {functions::StrReplaceInXml(["@@PaymentType@@"=>"##Vajh##","@@typeReserve@@"=>"##BookTicket##"],"ErrorReserveReturnBank")}
                                                {/if}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}

{else}
    <div class="return-bank-box">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="return-bank-inner return-error">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="success-icon">
                                    <?xml version="1.0" encoding="iso-8859-1"?>
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 507.2 507.2" style="enable-background:new 0 0 507.2 507.2;"
                                         xml:space="preserve">
                                    <circle style="fill:#F15249;" cx="253.6" cy="253.6" r="253.6"/>
                                        <path style="fill:#AD0E0E;"
                                              d="M147.2,368L284,504.8c115.2-13.6,206.4-104,220.8-219.2L367.2,148L147.2,368z"/>
                                        <path style="fill:#FFFFFF;" d="M373.6,309.6c11.2,11.2,11.2,30.4,0,41.6l-22.4,22.4c-11.2,11.2-30.4,11.2-41.6,0l-176-176
                                        c-11.2-11.2-11.2-30.4,0-41.6l23.2-23.2c11.2-11.2,30.4-11.2,41.6,0L373.6,309.6z"/>
                                        <path style="fill:#D6D6D6;" d="M280.8,216L216,280.8l93.6,92.8c11.2,11.2,30.4,11.2,41.6,0l23.2-23.2c11.2-11.2,11.2-30.4,0-41.6
                                        L280.8,216z"/>
                                        <path style="fill:#FFFFFF;" d="M309.6,133.6c11.2-11.2,30.4-11.2,41.6,0l23.2,23.2c11.2,11.2,11.2,30.4,0,41.6L197.6,373.6
                                        c-11.2,11.2-30.4,11.2-41.6,0l-22.4-22.4c-11.2-11.2-11.2-30.4,0-41.6L309.6,133.6z"/>
                                    </svg>

                                </div>
                                <div class="success-text">
                                    <div class="success-text-title">##Note##</div>
                                    <div class="success-text-info">
                                        <p>{$errorPaymentMessage}</p>

                                        <p>##NoPayment##</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}


{* email modal to display *}
<div id="ModalSendEmail" class="modal">

    <!-- Modal content -->
    <div class="modal-content" style="width:56%">
        <div class="modal-header site-bg-main-color">
            <span class="close CloseEmail" onclick="modalEmailClose()">&times;</span>
            <h6 class="modal-h">##Sendemailanother##</h6>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label>##EmailOfAnotherWhoSentHimTicket##</label>
                </div>

                <div class="col-md-11 margin-10">
                    <input type="email" class="form-control margin-10 text-left" name="Email" id="SendForOthers">
                    <input type="hidden" class="form-control margin-10 text-left" name="request_number"
                           id="request_number">
                </div>

                <div class="col-md-2">
                    <img src="assets/images/load21.gif"
                         style="display:none; top: 10px !important; right:35px !important" class="loader-tracking"
                         id="loaderTracking">
                </div>
            </div>
        </div>
        <div class="modal-footer site-bg-main-color">
            <div class="col-md-12 text-left">

                <input type="button" class="btn btn-success margin-10" value="##Send##" onclick="SendEmailForOther();"
                       id="SendEmailForOther">
                <input class="close btn btn-danger margin-10" onclick="modalEmailClose()" type="button"
                       value="##Closing##">
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>


<div id="ModalPublic" class="modal">
    <div class="modal-content" id="ModalPublicContent"></div>
</div>