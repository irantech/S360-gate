


{load_presentation_object filename="insurance" assign="objApiLocal"}
{load_presentation_object filename="bookingInsurance" assign="objBook"}
{$objBook->setPortBankInsurance('samanBankInsurance',$smarty.post.factorNumber)}
{$objBook->sendUserToBankForInsurance($smarty.post.factorNumber)}
{assign var="saman" value=$objApiLocal->ReserveByBankSamanInsurance($smarty.post) }

{if $saman eq false}
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
    <div class="row bank_box_row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 " >
            <div class="main-bank-box">
                <div class="mbb-preload">
                    <img src="assets/images/pre-bank.png">
                </div>
                <h4 class="mbb-bank-title">
                    <span>##Transferfromsiteport## </span>
                    <span>##Bank##</span>
                </h4>
                <div class="mbb-bank-img">
                    <div class="boxer fr-box"> <img class="flash-row" src="assets/images/fading-arrows.gif" /></div>
                </div>
                <div class="txtAlertBank">
                    ##Ticketswillisspaidbankagainsite##
                </div>

            </div>
        </div>
    </div>
{/if}
