{load_presentation_object filename="onlinePayment" assign="objOnlinePayment"}
{load_presentation_object filename="members" assign="objMembers"}
{load_presentation_object filename="interactiveOffCodes" assign="objOffCode"}

{* variables needed to be set for display *}
{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='factor_number' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var='offCode' value=''}

{if isset($smarty.get.FactorNumber) && $smarty.get.FactorNumber neq ''}
    {$factor_number=$smarty.get.FactorNumber}
{else}
    {$factor_number=$smarty.post.factorNumber}
{/if}


    {load_presentation_object filename="bank" assign="objBank"}
    {$objBank->initBankParams($smarty.get.bank)}
    {$objBank->executeBank('return')}


    {if $objBank->transactionStatus neq 'failed' && $objBank->trackingCode neq ''}


        {if $objBank->trackingCode eq 'member_credit'}
            {$paymentType = 'credit'}
        {else}
            {$paymentType = 'cash'}
            {$paymentBank = $objBank->bankTitle}

            {$bankTrackingCode = $objBank->trackingCode}
        {/if}
        {$successPayment = 'true'}
        {$objOnlinePayment->updateBank($objBank->trackingCode, $objBank->factorNumber)}
        {$objOnlinePayment->setBook('cash',$objBank->factorNumber)}

    {else}
        {$successPayment = 'false'}
        {$errorPaymentMessage = $objBank->failMessage}

        {$objOnlinePayment->callFailed('cancel',$factor_number,$errorPaymentMessage)}

    {/if}



{* display with initialized variables *}
{if $successPayment eq 'true'}

    {if  $objBank->factorNumber neq ''}
        {assign var='finalFactorNumber' value=$objBank->factorNumber}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
            <div class="main-bank-box">

                <div class="mbb-preload mbb-preload-icon">
                    <img src="assets/images/pre-bank.png">
                </div>
                <h4 class="mbb-bank-title mbb-bank-title-green">
                    <span>##Successpayment##</span>
                </h4>

                <div class="mbb-detail">
                    <p class="clearfix">
                        <span class="pull-right">
                            {if $paymentType eq 'cash'}##Agentbank## {else}##Typepayment## {/if}
                        </span>
                        <span class="pull-left">{if $paymentBank neq ''}{$paymentBank}{else}##Credit##{/if}</span>
                    </p>

                    {if $paymentType eq 'cash' && $bankTrackingCode neq ''}
                        <p class="clearfix">
                            <span class="pull-right"> ##TrackingCode##</span>
                            <span class="pull-left">{$bankTrackingCode}</span>
                        </p>
                    {/if}

                    <p class="clearfix">
                        <span class="pull-right"> ##Invoicenumber##</span>
                        <span class="pull-left">{$finalFactorNumber}</span>
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-10 justify-content-center gap-column-20">
{*                    <a class="w-sm-12" href="{$smarty.const.ROOT_ADDRESS}/eBusTicket&num={$finalFactorNumber}">*}
{*                        <button type="button" class="align-items-center btn btn-labeled btn-outline-primary d-flex font-12 justify-content-between w-100">*}
{*                            <span class="btn-label"><i class="fa fa-print"></i></span>*}
{*                            <span class="d-flex justify-content-center w-100">##Printreservation##</span>*}
{*                        </button>*}
{*                    </a>*}

{*                    <a class="w-sm-12" href="{$smarty.const.ROOT_ADDRESS}/pdf&target=bookingBusShow&id={$finalFactorNumber}">*}
{*                        <button type="button" class="align-items-center btn btn-labeled btn-outline-warning d-flex font-12 justify-content-between w-100">*}
{*                            <span class="btn-label"><i class="fa fa-file-pdf-o"></i></span>*}
{*                            <span class="d-flex justify-content-center w-100">##Download## pdf</span>*}
{*                        </button>*}
{*                    </a>*}
{*                    {if  $smarty.session.layout eq 'pwa'}*}
{*                        <a class="w-sm-12" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}'/app/'">*}
{*                            <button type="button" class="align-items-center btn btn-labeled btn-outline-warning d-flex font-12 justify-content-between w-100">*}
{*                                <span class="btn-label"><i class="fa fa-file-pdf-o"></i></span>*}
{*                                <span class="d-flex justify-content-center w-100">##returnToApp##</span>*}
{*                            </button>*}
{*                        </a>*}
{*                    {else}*}
{*                        <a class="w-sm-12" onclick="modalEmail('{$finalFactorNumber}');" target="_blank">*}
{*                            <button type="button" class="align-items-center btn btn-labeled btn-outline-info d-flex font-12 justify-content-between w-100">*}
{*                                <span class="btn-label"><i class="fa fa-envelope-o"></i></span>*}
{*                                <span class="d-flex justify-content-center w-100">##Sendemail##</span>*}
{*                            </button>*}
{*                        </a>*}
{*                    {/if}*}
                </div>


            </div>
        </div>
    {else}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
            <div class="main-bank-box">
                <div class="mbb-preload mbb-preload-icon-alert">
                    <img src="assets/images/pre-bank-red.png">
                </div>
                <h4 class="mbb-bank-title mbb-bank-title-red">
                    <span>##Problemreservation##</span>
                </h4>
                <div class="mbb-detail">
                    <p class="clearfix txtCenter">
                        {if $objOnlinePayment->errorMessage neq ''}
                            <span class="txtCenter">{$objOnlinePayment->errorMessage}</span>
                        {else}
                            <span class="txtCenter">##Incasehotelreservationpleasecontactcompanyrefund##</span>
                        {/if}
                    </p>
                </div>
            </div>
        </div>
    {/if}

{else}
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
        <div class="main-bank-box">
            <div class="mbb-preload mbb-preload-icon-alert">
                <img src="assets/images/pre-bank-red.png">
            </div>
            <h4 class="mbb-bank-title mbb-bank-title-red">
                <span>##Note##</span>
            </h4>
            <div class="mbb-detail">
                <p class="clearfix txtCenter">
                    <span class="txtCenter">{$errorPaymentMessage}</span>
                </p>
            </div>
        </div>
    </div>
{/if}


{* info modal to display *}
{*<div id="ModalPublic" class="modal">*}
{*    <div class="modal-content" id="ModalPublicContent"></div>*}
{*</div>*}


{* email modal to display *}
{*<div id="ModalSendEmail" class="modal" >*}

{*    <!-- Modal content -->*}
{*    <div class="modal-content" style="width:56%">*}
{*        <div class="modal-header">*}
{*            <span class="close CloseEmail" onclick="modalEmailClose()">&times;</span>*}
{*            <h6 class="modal-h">##Sendemailanother##     </h6>*}
{*        </div>*}
{*        <div class="modal-body">*}
{*            <div class="row">*}
{*                <div class="col-md-12">*}
{*                    <label>##SendHotelToAnother##</label>*}
{*                </div>*}

{*                <div class="col-md-11 margin-10">*}
{*                    <input type="email" class="form-control margin-10 text-left" name="Email" id="SendForOthers">*}
{*                </div>*}

{*                <div class="col-md-2">*}
{*                    <img src="assets/images/load21.gif" style="display:none; top: 10px !important; right:35px !important" class="loader-tracking" id="loaderTracking" >*}
{*                </div>*}
{*            </div>*}
{*        </div>*}
{*        <div class="modal-footer">*}
{*            <div class="col-md-12 text-left" >*}
{*                <input type="hidden" id="typeApplication" name="typeApplication" value="busTicket">*}
{*                <input type="hidden" id="factorNumber" name="factorNumber" value="{$objBank->factorNumber}">*}
{*                <input type="button" class="btn btn-success margin-10" value="##Send##"  onclick="SendHotelEmailForOther();" id="SendEmailForOther">*}
{*                <input  class="close btn btn-danger margin-10" onclick="modalEmailClose()" type="button" value="##Closing##">*}
{*            </div>*}
{*            <div class="clear"></div>*}
{*        </div>*}
{*    </div>*}
{*</div>*}