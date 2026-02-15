{load_presentation_object filename="bookshow" assign="objbook"}

{load_presentation_object filename="bookhotelshow" assign="objbookHotel"}
{load_presentation_object filename="factorHotelLocal" assign="objFactor"}
{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}



<div class="loaderPublic" style="display: none;">
<div class="positioning-container" >
    <div class="spinning-container">
        <div class="airplane-container"><span class="zmdi zmdi-airplane airplane-icon site-main-text-color"></span></div>
    </div>
</div>

<div class='loader'>
    <div class='loader_overlay'></div>
    <div class='loader_cogs'>
            <i class="fa fa-globe site-main-text-color-drck"></i>
    </div>
</div>

</div>
<div class='parent-tab-user-tracking'>
    <ul class="nav nav-pills nav-user-tracking " id="pills-tab-user-tracking" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link nav-link-user-tracking active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home-user-tracking" type="button" role="tab" aria-controls="pills-home-user-tracking" aria-selected="true">
                 ##PursueThePurchaseOfServices##
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link nav-link-user-tracking" onclick="closePurchase()"  id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile-user-tracking" type="button" role="tab" aria-controls="pills-profile-user-tracking" aria-selected="false">
                ##OtherRequests##
            </button>
        </li>
    </ul>
    <div class="tab-content tab-user-tracking w-100" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home-user-tracking" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class=''>
                <div class="s-u-popup-in-result" id="FormTracking">
                    <div class="cd-user-modal-container userTracking">  <!--   this is the container wrapper -->
                        <div class="cd-login is-selected">  <!--  log in form -->
                            <form class="cd-form-new">
                                <div class="maxl">
                                    <div style="z-index: 5898" class="continput_trik">
                                        <fieldset>
                                            {assign var="arrayServices" value=Functions::getServicesAgency()}
                                            {assign var="checkedForFirst" value="0"}
                                            {foreach $arrayServices as $k=>$services}
                                                {assign var="servicesByLanguage" value=Functions::ConvertArrayByLanguage($k)}
                                                {$checkedForFirst = $checkedForFirst+ 1}
                                                <label class='label-tracking' for="radio-{$k}">
                                                    <img src="assets/images/tracking/{$k}.svg" alt="img-svg">
                                                    <div class=''>
                                                        <input class='input-tracking' type="radio" name="typeSearch" value="{$k}" id="radio-{$k}"
                                                               {if $checkedForFirst eq "1" || $smarty.get.type eq $k}checked{/if} onclick="changePlaceHolder('{$k}')">
                                                        <span >{$servicesByLanguage}</span>
                                                    </div>
                                                </label>
                                            {/foreach}
                                        </fieldset>
                                    </div>
                                </div>
                                <p class="fieldset parent-fieldset-input-tracking">
                                    <input class="full-width has-padding has-border" id="request_number" type="text"
                                           placeholder="##Numberreservation## (##Voucher##) ##Or## ##Ticketnumber## ##Or## pnr ##countinueStatmentTrackingUser##" value="{$smarty.get.id}">
                                </p>
                                <div class="message-login txtCenter txtRed"></div>
                                <img src="assets/images/load21.gif" style="display:none" class="loader-tracking" id="loaderTracking">
                                <p class="fieldset parent-fieldset-btn-tracking">
                                    <input class="" type="button" value="##Sendinformation##"
                                           onclick="SendTrackingInfo()" id="submitInfoTracking">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile-user-tracking" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class=''>
                <div class="s-u-popup-in-result" id="FormTrackingRequest">
                    <div class="cd-user-modal-container userTracking">  <!--   this is the container wrapper -->
                        <div class="cd-login is-selected">  <!--  log in form -->
                            <form class="cd-form-new">
                                <div class="maxl">
                                    <div style="z-index: 5898" class="continput_trik">
                                        <fieldset>
                                            <label class='label-tracking active' for="radio-employment">
                                                <input type="radio" name="typeSearchRequest" value="employment" checked id="radio-employment" >
                                                <span > ##Application##</span>
                                            </label>
                                            <label class='label-tracking' for="radio-contact">
                                                <input type="radio" name="typeSearchRequest" value="contactUs"  id="radio-contact" >
                                                <span > ##chopContactUs##</span>
                                            </label>

                                           {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                            <label class='label-tracking' for="radio-feedback">
                                                <input type="radio" name="typeSearchRequest" value="feedback"  id="radio-feedback" >
                                                <span > ##GoharFeedBack##</span>
                                            </label>
                                            <label class='label-tracking' for="radio-lastMinute">
                                                <input type="radio" name="typeSearchRequest" value="lastMinute"  id="radio-lastMinute" >
                                                <span > ##S360Min90##</span>
                                            </label>
                                            {/if}
                                            <label class='label-tracking' for="radio-orderServices">
                                                <input type="radio" name="typeSearchRequest" value="orderServices"  id="radio-orderServices" >
                                                <span > ##OrderServices##</span>
                                            </label>
                                            <label class='label-tracking' for="radio-representatives">
                                                <input type="radio" name="typeSearchRequest" value="representatives"  id="radio-representatives" >
                                                <span > ##NasimBeheshtAgent##</span>
                                            </label>

                                            {if $smarty.const.SOFTWARE_LANG neq 'fa'}
                                            <label for="radio-iranVisa">
                                                <input type="radio" name="typeSearchRequest" value="orderIranVisa"  id="radio-iranVisa" >
                                                <span > ##IranVisaApplicationForm##</span>
                                            </label>
                                            {/if}
                                            <label class='label-tracking' for="radio-sendDocuments">
                                                <input type="radio" name="typeSearchRequest" value="sendDocuments"  id="radio-sendDocuments" >
                                                <span > ##sendDocuments##</span>
                                            </label>
                                            <label class='label-tracking' for="radio-appointment">
                                                <input type="radio" name="typeSearchRequest" value="appointment"  id="radio-appointment" >
                                                <span> ##requestAppointment##</span>
                                            </label>
                                        </fieldset>
                                    </div>
                                </div>
                                <p class="fieldset parent-fieldset-input-tracking">
                                    <input class="full-width has-padding has-border" id="request_service_number" type="text"
                                           placeholder="##RequestTrackingCode##" value="">
                                </p>
                                <div class="message-login txtCenter txtRed"></div>
                                <img src="assets/images/load21.gif" style="display:none" class="loader-tracking" id="loaderTrackingRequest">
                                <p class="fieldset parent-fieldset-btn-tracking">
                                    <input class="" type="button" value="##Sendinformation##"
                                           onclick="SendTrackingRequestInfo()" id="submitInfoTrackingRequest">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<div class="main-Content-bottom-table Dash-ContentL-B-Table" style="display:none" id="trListReserve">


</div>










<div class="main-Content-bottom-table Dash-ContentL-B-Table" style="display:none" id="trListRequestService">


</div>
<div id="modalRequestService" class="modal ">
    <div class="modal-content" id="ModalPublicContentRrequest" style='display: block'>


    </div>

</div>


<!-- bank connect -->
<div class="main-pay-content">

    <div class="s-u-p-factor-bank s-u-p-factor-bank-change" id="factor_bank">
        <h4 class="site-bg-main-color site-bg-color-border-bottom">##onlinepayment##</h4>

        <div id="railBanks" style="display: none">
            {assign var="infoBank" value=$objFunctions->InfoBank()}
{*            {$infoBank|var_dump}*}
            {if $infoBank|count > 0}
                <div class="s-u-select-bank mart30">
                    <form>
                        <div class="main-banks-logo">
                            {foreach $infoBank as $key => $bank}
                                <div class="bank-logo">
                                    <input type="radio" name="bank" value="{$bank['bank_dir']}" id="{$bank['bank_dir']}" {if $key eq 0}checked="checked"{/if}>
                                    <label for="{$bank['bank_dir']}">
                                        <img src="assets/images/bank/bank{$bank['title_en']}.png"
                                             alt="{$bank['title']}"
                                             class="s-u-bank-logo w-100 s-u-bank-logo-bank">
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </form>
                    ##Thesupermarketacceptsallbankcardnetworkmembershurry##
                    <span class="author"><i>##Youresteemedtravelersubjectapprovalregulations##</i></span>
                </div>

                <div class="s-u-select-update-wrapper" id="payBankButton"></div>
            {else}
                <div class="s-u-select-update-wrapper">
                    <a class="s-u-select-update s-u-select-update-change disabledButtonPayOnline">##Unfortunatelythereisactivebank##</a>
                </div>
            {/if}
        </div>

        <div id="currencyBanks" style="display: none">
            {assign var="infoBank" value=$objFunctions->InfoBank('1')}
            {if $infoBank|count > 0}
                <div class="s-u-select-bank mart30 onlinePaymentBox">
                    <div class="col-md-2"></div>
                    <form class="col-md-8">
                        <div class="col-md-12 form-group marb5">
                            <input type="text" name="cardNumber" id="cardNumber" class="form-control" placeholder=" ##Cardnumber##" />
                        </div>
                        <div class="col-md-6 form-group marb5">
                            <input type="text" name="cardExpireMonth" id="cardExpireMonth" class="form-control" placeholder="##Cardexpirationmonth##" />
                        </div>
                        <div class="col-md-6 form-group marb5">
                            <input type="text" name="cardExpireYear" id="cardExpireYear" class="form-control" placeholder="##Cardexpirationdate##" />
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" name="cardCVC" id="cardCVC" class="form-control" placeholder="##Code## CVC" />
                        </div>
                    </form>
                    <div class="col-md-2"></div>
                </div>

                <div class="s-u-select-update-wrapper" id="payCurrencyButton"></div>
            {else}
                <div class="s-u-select-update-wrapper">
                    <a class="s-u-select-update s-u-select-update-change disabledButtonPayOnline">##Unfortunatelythereisactivebank##</a>
                </div>
            {/if}
        </div>

    </div>

    {if  $objFactor->IsLogin eq true  && $objMember->list['fk_counter_type_id'] !='5'}
        <div class="s-u-p-factor-bank s-u-p-factor-bank-change marr10">
            <h4 class="site-bg-main-color site-bg-color-border-bottom site-main-button-flat-color">##Paycredit##</h4>
            <div class="s-u-select-bank mart30">
                <form id="formcredit" method="post"  target="_self">
                    <div class="boxerFactorLogo"><img src="project_files/images/logo.png" alt="logo"></div>
                </form>

                ##Nowagencycredentials## {$objFunctions->CalculateCredit()} ##Rial## ##Dodo##
                <span class="author"><i>##Yourreputablepurchasingagencyconfirmationlawsregulations##</i></span>
            </div>
            <div class="s-u-select-update-wrapper" id="payCreditButton"></div>

        </div>
    {/if}

</div>



<!--  modal for visa  -->
<div id="popup-upload-file">
    <div class="modal">
        <div class="modal_header">
            <div class="container">
                <span>##uploadingVisaDocuments##</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="close">
                    <path d="M505.943 6.058c-8.077-8.077-21.172-8.077-29.25 0L6.06 476.693c-8.077 8.077-8.077 21.172 0 29.25 4.038 4.04 9.332 6.057 14.625 6.057 5.293 0 10.586-2.02 14.625-6.06L505.943 35.307c8.076-8.076 8.076-21.17 0-29.248z"/>
                    <path d="M505.942 476.694L35.306 6.06C27.23-2.02 14.134-2.02 6.058 6.06c-8.077 8.075-8.077 21.17 0 29.247l470.636 470.636c4.038 4.04 9.332 6.058 14.625 6.058 5.292 0 10.586-2.018 14.623-6.056 8.075-8.078 8.075-21.173 0-29.25z"/>
                </svg>
            </div>
        </div>
        <div class="modal_body">
            <div class="container">
                <p>##descriptionsDownloadTravelTourFiles##</p>
                <p id="documents-visa"></p>
                <form id='registerPassengersFileVisaForm' name="registerPassengersFileVisaForm" method='post' enctype='multipart/form-data'>
                    <input type="hidden" name="flag" id="flag" value="registerPassengersFileVisa"/>
                    <input type="hidden" name="factorNumber" id="factorNumber" value=""/>

                    <label for="passengersFileTour" class="displayNone">##DownloadTravelTourFiles##</label>
                    <div class="s-u-passenger-item  s-u-passenger-item-change form-group width70">
                        <div class="field">
                            <i class="btn-upload-file fa fa-upload"></i>
                            <input type="text" name="passengersFileText" value="" size="40"
                                   class="file_input_replacement" placeholder="انتخاب فایل"
                                   style="padding-right: 115px;">
                            <input type="file" name="passengersFile[]" id="passengersFile"
                                   class="file_input_with_replacement" multiple="multiple">
                        </div>
                    </div>
                    <div class="s-u-passenger-item s-u-passenger-item-change form-group width30 no-star">
                        <a href="#"
                           onclick="registerPassengersFileVisa();return false"
                           class="btn btn-success fa fa-check width100" title="##sendFile##">
                            ##sendFile## </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="modal_overlay"></div>
</div>
<!-- end modal for visa  -->



<div id="ModalPublic" class="modal">
    <div class="modal-content" id="ModalPublicContent">
    </div>
</div>


{literal}
    <script type="text/javascript">
        {/literal}
        {if $smarty.get.id neq ''}
            {literal}
                setTimeout(function () {
                    SendTrackingInfo();
                }, 100);
            {/literal}
        {/if}
        {literal}
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#userProfile').DataTable();
        });
        $(document).tooltip();
    </script>

    <script>
        const modal = document.querySelector("#popup-upload-file .modal");
        const close = document.querySelector("#popup-upload-file .close");
        function isOpenModalVisa(factorNumber, documents) {
            $('#factorNumber').val(factorNumber);
            $('#documents-visa').html('مدارک مورد نیاز: ' + documents);
            modal.classList.add("is_open");
        }
        close.addEventListener("click", function(){
            modal.classList.remove("is_open");
        });

        function changePlaceHolder($type) {

            if($type=='train'){
                    $('#request_number').attr('placeholder',useXmltag('Numberreservation') +' '+  useXmltag('Or')+' ' + useXmltag('Ticketnumber'))
                }else{
                    $('#request_number').attr('placeholder',useXmltag('Numberreservation') +' ('+  useXmltag('Voucher') + ')' + useXmltag('Or')+' ' + useXmltag('Ticketnumber') + ' ' + useXmltag('Or')+' ' + 'pnr')
                }
        }
    </script>

    <script>

        $(function(){
            $('.file_input_replacement').click(function(){
                //This will make the element with class file_input_replacement launch the select file dialog.
                var assocInput = $(this).siblings("input[type=file]");
                console.log(assocInput);
                assocInput.click();
            });
            $('.file_input_with_replacement').change(function(){
                //This portion can be used to trigger actions once the file was selected or changed. In this case, if the element triggering the select file dialog is an input, it fills it with the filename
                var thisInput = $(this);
                var assocInput = thisInput.siblings("input.file_input_replacement");
                if (assocInput.length > 0) {
                    var filename = (thisInput.val()).replace(/^.*[\\\/]/, '');
                    assocInput.val(filename);
                }
            });
        });

        function removemeNew(){
          $("#modalRequestService").hide();
        }

        function closePurchase() {
          $("#trListReserve").hide();
        }
    </script>

{/literal}