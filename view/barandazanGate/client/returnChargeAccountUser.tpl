
{*{if $objSession->IsLogin()}*}

    {load_presentation_object filename="bank" assign="objBank"}
    {load_presentation_object filename="memberCredit" assign="objmember"}
    {$objBank->initBankParams($smarty.get.bank)}
    {$objBank->executeBank('return')}

    {assign value=$objBank->trackingCode var="TrackingCode"}


{if $objBank->transactionStatus neq 'failed' && ($TrackingCode neq '')}

    {$objmember->UpdateChargeAccountUser($smarty.get.factorNumber,$TrackingCode,'success')}

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
                                        <path style="fill:#0AA06E;"  d="M188.8,368l130.4,130.4c108-28.8,188-127.2,188-244.8c0-2.4,0-4.8,0-7.2L404.8,152L188.8,368z"/>
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
                                </div>
                                <div class='d-flex justify-content-center mt-3'>
                                    <a href='{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}' class='back_btn'>##Return##</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel-return">
                                    <div class="panel-return-head">
                                        <span>##PurchaseInformation##</span>
                                    </div>
                                    <div class="panel-return-content">
                                        <div>
                                            <span>  </span>
                                        </div>

                                        <div><span>##TrackingCode##</span><span>
                                             {$TrackingCode}</span></div>
                                        <div>
                                            <span>##Invoicenumber##</span><span>{$smarty.get.factorNumber}</span>
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
{else}
    {$objmember->UpdateChargeAccountUser($initializeAdminBank['factorNumber'],$initializeAdminBank['trackingCode'],'error')}
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
                                    <div class="success-text-title">##Payment##</div>
                                    <div class="success-text-info">
                                        <p>
                                            {$objBank->failMessage}
                                        </p>
                                        <div class='d-flex justify-content-center mt-3'>
                                            <a href='{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}' class='back_btn'>##Return##</a>
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

{*{else}*}

{*    {$objFunctions->redirectOut()}*}
{*{/if}*}