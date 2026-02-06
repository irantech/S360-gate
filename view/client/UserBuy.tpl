{load_presentation_object filename="user" assign="objUser"}
{if $objSession->IsLogin()}

{assign var="statusShow" value=""}
{assign var="statusText" value=""}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`clientProfile.tpl"}
    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
        {assign var='noLimitCalendar' value="shamsiNoLimitCalendar"}
        {assign var="sDate" value=$objFunctions->DatePrev($objDate->jdate("Y-m-d", '', '', '', 'en'), '7')}
        {assign var="eDate" value=$objDate->jdate("Y-m-d", '', '', '', 'en')}

    {else}
        {assign var='noLimitCalendar' value="gregorianNoLimitCalendar"}
        {assign var="sDate" value=$objFunctions->DatePrev(date("Y-m-d"), '7')}
        {assign var="eDate" value=date("Y-m-d")}
    {/if}

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
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 half_padding_l col-padding-5">
            <div class="filterBox">
                <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom padt10 padb10">
                    <p class="txt14">
                        <span class="txt15 iranM ">##Service##</span>
                    </p>
                </div>

                <div class="filtertip-searchbox site-main-text-color-drck light_border_1">
                    <div class="filter-content padb10 padt10">

                        {assign var="arrayServices" value=Functions::getServicesAgency()}
                        {assign var="checkedForFirst" value="0"}
                        {foreach $arrayServices as $k=>$services}
                        {assign var="servicesByLanguage" value=Functions::ConvertArrayByLanguage($k)}
                            {$checkedForFirst = $checkedForFirst + 1}
                            <div class="UserBuy-tab-link current" data-tab="tab-{$k}">
                                <input id="radio-{$k}" class="radio-custom" name="radio-group" type="radio"
                                       {if $checkedForFirst eq "1"}checked{/if} value="{$k}"
                                    onchange="getUserBuy()">
                                <label for="radio-{$k}" class="radio-custom-label">{$servicesByLanguage}</label>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>

            <div class="filterBox">
                <div class="filtertip_hotel site-bg-main-color site-bg-color-border-bottom padt10 padb10">
                    <p class="txt14">
                        <span class="txt15 iranM "> ##Statusreservation##</span>
                    </p>
                </div>

                <div class="filtertip-searchbox site-main-text-color-drck light_border_1">
                    <div class="filter-content padb10 padt10">

                        <div class="Status-tab-link current" data-tab="">
                            <input id="status-1" class="radio-custom" name="status-group" type="radio" checked>
                            <label for="status-1" class="radio-custom-label  ">##All##</label>
                        </div>
                        <div class="Status-tab-link " data-tab=" ##Definitivereservation##">
                            <input id="status-2" class="radio-custom" name="status-group" type="radio">
                            <label for="status-2" class="radio-custom-label  ">##Definitivereservation## </label>
                        </div>
                        <div class="Status-tab-link " data-tab="##RedirectPayment##  ">
                            <input id="status-3" class="radio-custom" name="status-group" type="radio">
                            <label for="status-3" class="radio-custom-label  "> ##RedirectPayment##</label>
                        </div>
                        <div class="Status-tab-link " data-tab=" ##Prereservation##">
                            <input id="status-4" class="radio-custom" name="status-group" type="radio">
                            <label for="status-4" class="radio-custom-label  "> ##Prereservation##</label>
                        </div>
                        <div class="Status-tab-link " data-tab="##Unknow## ">
                            <input id="status-5" class="radio-custom" name="status-group" type="radio">
                            <label for="status-5" class="radio-custom-label  ">##Unknow## </label>
                        </div>
                        <div class="Status-tab-link " data-tab="##Cancel##">
                            <input id="status-6" class="radio-custom" name="status-group" type="radio">
                            <label for="status-6" class="radio-custom-label  ">##Cancel##</label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 half_padding_r col-padding-5" id="result">

            <div class="main-Content-bottom-table Dash-ContentL-B-Table light_border_1">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">

                    <i class="icon-table"></i>
                    <h3>##YourBuy## :</h3>
                    <a class="archive-tour" href="{$smarty.const.ROOT_ADDRESS}/TrackingCancelTicket">##Cancelarchive##</a>
                </div>




                <div class="user-buy-box">
                    <div class="user-buy-search-box">
                        <span>
                            <lable for="startDate">##Buydateaz##:</lable>
                            <input type="text" name="startDate" id="startDate"
                                   class="{$noLimitCalendar}"
                                   value="{$sDate}" onchange="getUserBuy()">
                        </span>
                        <span>
                            <lable for="endDate">##Buydateta##:</lable>
                            <input type="text" name="endDate" id="endDate"
                                   class="{$noLimitCalendar}"
                                   value="{$eDate}" onchange="getUserBuy()">
                        </span>
                        <span>
                            <lable for="factorNumber">##Invoicenumber##/##Voucher##:</lable>
                            <input type="text" name="factorNumber" id="factorNumber"
                                   value="" placeholder="##Invoicenumber##/##WachterNumberenter##"
                                   onkeyup="getUserBuy()">
                        </span>
                    </div>
                    <div class="loader-box-user-buy">
                        <span></span>
                        <span>##Loading##</span>
                    </div>

                    <div id="tab-user-buy" class="UserBuy-tab-content current"></div>
                </div>


            </div>
        </div>
    </div>

    <div id="ModalPublic" class="modal">
        <div class="modal-content" id="ModalPublicContent"></div>
    </div>

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
                    <form id='registerPassengersFileVisaForm' name="registerPassengersFileVisaForm" method='post'
                          enctype='multipart/form-data'>
                        <input type="hidden" name="flag" id="flag" value="registerPassengersFileVisa"/>
                        <input type="hidden" name="factorNumber" id="factorNumber" value=""/>

                        <label for="passengersFileTour" class="displayNone">##DownloadTravelTourFiles##</label>
                        <div class="s-u-passenger-item  s-u-passenger-item-change form-group width70">
                            <div class="field">
                                <i class="btn-upload-file fa fa-upload"></i>
                                <input type="text" name="passengersFileText" value="" size="40"
                                       class="file_input_replacement" placeholder="##Selectfile##"
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

    {*
    {if $objSession->IsLogin()}
        {if $objFunctions->popZomorod() eq 'NoCookie' && $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}
            {load_presentation_object filename="Emerald" assign="objEmerald"}
            {load_presentation_object filename="members" assign="objMembers"}
            {assign var="infoZomorod" value=$objMembers->infoZomorod($objSession->getUserId())}
            {assign var="sumrequest" value=$objEmerald->sumRequestVerified({$objSession->getUserId()})}

                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}

                <div id="ModalZomorod" class="modal">
                    <div class="modal-content  zomorodModal" id="ModalZomorodContent ">
                        <div class="">##Dearfriend## {$objSession->getNameUser()}<br/></div>
                        <div class="modal-text-center">
                            <span>
                                {assign var="InfoZomoord" value=$infoZomorod}
                                {assign var="leaguePoints" value=$objFunctions->leaguePoints($infoZomorod)|number_format}
                                {assign var="sumrequest" value=$sumrequest}
                                {assign var="br" value="</br>"}
                                {assign var="Remind" value=($objFunctions->leaguePoints($infoZomorod))-($sumrequest)}
                                {functions::StrReplaceInXml(["@@infoZomorod@@"=>$InfoZomoord,"@@leaguePoints@@"=>$leaguePoints,"@@sumrequest@@"=>$sumrequest,"@@br@@"=>$br,"@@Remind@@"=>$Remind],"MessageInfoZomorod")}
                            </span>
                        </div>
                        <a href="https://www.iran-tech.com/league" target="_blank">
                            <div class="modal-text-center"><img src="assets/images/award.jpg" style="width: 90%;"><br/>
                            </div>
                            <div class="modal-text-center textNewsZomorod"> ##Showinrate##...</div>
                        </a>
                    </div>
                </div>


            {/if}
        {/if}
    {/if}
    *}

</div>

{literal}
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                getUserBuy();
            }, 100);
        });

        function getUserBuy() {
            let appType = $('input[name=radio-group]:checked').val();
            if(appType == 'tour'){
                $('.tourHistory').addClass('show_tour_History-Link');

            }
            else{
                $('.tourHistory').removeClass('show_tour_History-Link');
            }
            let startDate = $('#startDate').val();
            let endDate = $('#endDate').val();
            let factorNumber = $('#factorNumber').val();
            $('.loader-box-user-buy').removeClass('displayN');
            $('#tab-user-buy').html('');
            setTimeout(function () {
                $.ajax({
                    type: 'POST',
                    url: amadeusPath + 'user_ajax.php',
                    data:
                        {
                            flag: 'getUerBuy',
                            appType: appType,
                            startDate: startDate,
                            endDate: endDate,
                            factorNumber: factorNumber
                        },
                    success: function (data) {

                        if (data != ''){
                            $('.loader-box-user-buy').addClass('displayN');
                            $('#tab-user-buy').html(data);


                            var table = $('#userProfile').DataTable();
                            $('.Status-tab-link').on('click', function () {
                                var tab_status = $(this).attr('data-tab');
                                table.search(tab_status).draw();
                            });

                        }


                    }
                });
            }, 100);
        }

    </script>
    <script>
        $(document).on("click",".dropdownUserBuy", function () {
        var dropDownContent = $(this).find(".dropdown-content-UserBuy");
        var otherDropDowns = $('.dropdown-content-UserBuy:visible').not(dropDownContent);
            dropDownContent.slideToggle("displayb");
            otherDropDowns.slideUp('fast');
        });
        $(document).click(function (event) {
            if (!$(event.target).closest("#ModalPublicContent").length) {
                $("body").find("#ModalPublic").fadeOut(300);
            }
            $("body").find("#ModalZomorod").fadeOut(300);
        });
        $(document).ready(function () {
            $("#ModalZomorod").fadeIn(500);
        });
        // $(".dropdownUserBuy").on("click", function () {
        //     $(this).find(".dropdown-content-UserBuy").slideToggle("displayb");
        // });
    </script>
    <script type="text/javascript">
        var table = $('#userProfile').DataTable();
        $('.Status-tab-link').on('click', function () {
            var tab_status = $(this).attr('data-tab');
            table.search(tab_status).draw();
            // $(".dropdownUserBuy").on("click", function () {
            //     $(this).find(".dropdown-content-UserBuy").slideToggle("displayb");
            // });
        });
        /*$(function () {
            $(document).tooltip();
        });*/
    </script>
    <script>
        const modal = document.querySelector("#popup-upload-file .modal");
        const close = document.querySelector("#popup-upload-file .close");
        function isOpenModalVisa(factorNumber, documents) {
            $('#factorNumber').val(factorNumber);
            $('#documents-visa').html('مدارک مورد نیاز: ' + documents);
            modal.classList.add("is_open");
        }
        close.addEventListener("click", function () {
            modal.classList.remove("is_open");
        });
    </script>
    <script>
        $(function () {
            $('.file_input_replacement').click(function () {
                //This will make the element with class file_input_replacement launch the select file dialog.
                var assocInput = $(this).siblings("input[type=file]");
                assocInput.click();
            });
            $('.file_input_with_replacement').change(function () {
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
    {$objUser->redirectOut()}
{/if}