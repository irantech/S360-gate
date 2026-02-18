{load_presentation_object filename="user" assign="objUser"}
{if $objSession->IsLogin()}

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

    <div class="s-u-popup-in-result" id="FormTracking">
        <div class="cd-user-modal-container userTracking">  <!--   this is the container wrapper -->
            <div class="cd-login is-selected">  <!--  log in form -->
                <form class="cd-form">
                    <div class="maxl">
                        <div style="z-index: 5898" class="continput_trik">
                            <fieldset>
                                {assign var="arrayServices" value=Functions::getServicesAgency()}
                                {assign var="checkedForFirst" value="0"}
                                {foreach $arrayServices as $k=>$services}
                                    {assign var="servicesByLanguage" value=Functions::ConvertArrayByLanguage($k)}
                                    {$checkedForFirst = $checkedForFirst+ 1}
                                    <label for="radio-{$k}">
                                        <input type="radio" name="typeSearch" value="{$k}" id="radio-{$k}"
                                               {if $checkedForFirst eq "1" || $smarty.get.type eq $k}checked{/if}>
                                        <span >{$servicesByLanguage}</span>
                                    </label>
                                {/foreach}
                            </fieldset>
                        </div>
                    </div>
                    <p class="fieldset">
                        <input class="full-width has-padding has-border" id="request_number" type="text"
                               placeholder="##Numberreservation## (##Voucher##) ##Or## pnr" value="{$smarty.get.id}">
                    </p>
                    <div class="message-login txtCenter txtRed"></div>
                    <img src="assets/images/load21.gif" style="display:none" class="loader-tracking" id="loaderTracking">
                    <p class="fieldset">
                        <input class="full-width site-bg-main-color " type="button" value="##Sendinformation##"
                               onclick="SendTrackingInfo()" id="submitInfoTracking">
                    </p>
                </form>
            </div>
        </div>
    </div>

    <div class="main-Content-bottom-table Dash-ContentL-B-Table" style="display:none" id="trListReserve">


    </div>

    <!-- bank connect -->
    <div class="main-pay-content">

        <div class="s-u-p-factor-bank s-u-p-factor-bank-change" style="display: none" id="factor_bank">
            <h4 class="site-bg-main-color site-bg-color-border-bottom">##onlinepayment##</h4>

            <div id="railBanks" style="display: none">
                {assign var="infoBank" value=$objFunctions->InfoBank()}
                {if $infoBank|count > 0}
                    <div class="s-u-select-bank mart30">
                        <form>
                            <div class="main-banks-logo">
                                {foreach $infoBank as $key => $bank}
                                    <div class="bank-logo">
                                        <input type="radio" name="bank" value="{$bank['bank_dir']}" id="{$bank['bank_dir']}" {if $key eq 0}checked="checked"{/if}>
                                        <label for="{$bank['bank_dir']}"> <img src="assets/images/bank/bank{$bank['title_en']}.png" alt="{$bank['title']}" class="s-u-bank-logo s-u-bank-logo-bank"></label>
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
            <div class="s-u-p-factor-bank s-u-p-factor-bank-change marr10" style="display: none" >
                <h4 class="site-bg-main-color site-bg-color-border-bottom site-main-button-flat-color">##Paycredit##</h4>
                <div class="s-u-select-bank mart30">
                    <form id="formcredit" method="post"  target="_self">
                        <div class="boxerFactorLogo"><img src="project_files/images/logo.png" alt="logo"></div>
                    </form>

                    ##Nowagencycredentials## {$objFunctions->CalculateCredit()|number_format} ##Rial## ##Dodo##
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

    </script>

{/literal}
{else}
    <script>
        $.confirm({
            title: 'پیگیری خرید',
            content: 'لطفا برای پیگیری خرید وارد شوید و یا ثبت نام نمائید',
            buttons: {
                confirm: {
                    text: 'ورود',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function () {
                        window.location.href='loginUser'
                    }
                },
                cancel: {
                    text: 'ثبت نام',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        window.location.href='registerUser'
                    }
                }
            }
        });
    </script>
    {*{$objUser->redirectOut()}*}

{/if}