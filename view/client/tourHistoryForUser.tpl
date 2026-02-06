{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
<main>
    <section class="profile_section mt-3 mb-3 row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 position-static">
                    <div class="menu-profile-ris d-lg-none">
                        <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}" class="logo_img"><img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}' alt='logo'></a>
                        <button onclick="openMenuProfile()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 88C0 74.75 10.75 64 24 64H424C437.3 64 448 74.75 448 88C448 101.3 437.3 112 424 112H24C10.75 112 0 101.3 0 88zM0 248C0 234.7 10.75 224 24 224H424C437.3 224 448 234.7 448 248C448 261.3 437.3 272 424 272H24C10.75 272 0 261.3 0 248zM424 432H24C10.75 432 0 421.3 0 408C0 394.7 10.75 384 24 384H424C437.3 384 448 394.7 448 408C448 421.3 437.3 432 424 432z"/></svg></button>
                    </div>
                    <div onclick="closeMenuProfile()" class="bg-black-profile-ris d-lg-none"></div>
                    <div class="box-style sticky-100">
                        {include file="./profileSideBar.tpl"}
                    </div>
                </div>
                <div class="col-lg-9">
{else}
       {include file="`$smarty.const.FRONT_CURRENT_CLIENT`clientProfile.tpl"}
{/if}
<div class="client-head-content">
    {load_presentation_object filename="resultTourLocal" assign="objTour"}
    {if $objTour->accessReservationTour() and $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}

        {load_presentation_object filename="bookTourShow" assign="objBook"}

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

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="tourHistory">
                <span>
                    <a href="{$smarty.const.ROOT_ADDRESS}/tourHistoryForUser">
                        <i class="fa fa-outdent margin-left-10 font-i"></i> ##Reportbuytour##   </a>
                </span>
                <span>
                    <a href="{$smarty.const.ROOT_ADDRESS}/tourHistoryForUser&status=TemporaryReservation">
                        <i class="fa fa-th-list margin-left-10 font-i"></i>##Requestlistsettour##</a>
                </span>
                <span>
                    <a href="{$smarty.const.ROOT_ADDRESS}/tourHistoryForUser&status=CancellationRequest">
                        <i class="fa fa-outdent margin-left-10 font-i"></i>##Cancelequestlistsettour##</a>
                </span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                    {if $smarty.get.status eq 'TemporaryReservation'}
                        <h3>##Requestlistsettour##</h3>
                    {elseif $smarty.get.status eq 'CancellationRequest'}
                        <h3>##Cancelequestlistsettour##</h3>
                    {else}
                        <h3>##Reportbuytour##</h3>
                    {/if}
                </div>

                <table id="tourWishList" class="display" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>##Row##</th>
                        <th>##Tour##</th>
                        <th>##Origin##<br/>##Destination##</th>
                        <th> ##Enterdate##<br>##Stayigtime##</th>
                        <th>##Invoicenumber## <br>##Buydate##</th>
                        <th>##Status##</th>
                        <th> ##Amountcurrency##</th>
                        <th>##Show##</th>
                        {*if $smarty.get.status eq 'TemporaryReservation' || $smarty.get.status eq 'CancellationRequest'*}
                        <th>##Action##</th>
                        {*/if*}
                    </tr>
                    </thead>

                    <tbody>
                    {assign var="number" value="1"}
                    {assign var="tourList" value=$objBook->userBuyTour($smarty.session.userId, $smarty.get.status)}
                    {foreach key=key item=item from=$tourList}
                        <tr>
                            <td>
                                {$number++}
                            </td>
                            <td>{$item.tour_name}</td>
                            <td>
                                {$item.tour_origin_country_name} - {$item.tour_origin_city_name}
                                - {$item.tour_origin_region_name}
                                <hr style="border: 1px dashed #d1d1d1;">
                                {$item.tour_cities}
                            </td>
                            <td>
                                {$item.tour_start_date}
                                <hr style="border: 1px dashed #d1d1d1;">
                                {if $item.tour_night gt 0}{$item.tour_night} ##Timenight## {/if} {$item.tour_night}
                                ##Day##
                            </td>
                            <td dir="ltr">
                                {$item.factor_number}
                                <hr style="border: 1px dashed #d1d1d1;">
                                {if $item.creation_date_int neq ''} {$objDate->jdate('Y-m-d (H:i:s)', $item.creation_date_int)} {else} ـــــ {/if}
                            </td>
                            <td>
                                ##Totalamount##:
                                {$item.tour_total_price|number_format}
                                <hr style="border: 1px dashed #d1d1d1;">
                                ##Paymentamount## :
                                {$item.tour_payments_price|number_format}
                                <hr style="border: 1px dashed #d1d1d1;">

                                {if $item.tour_total_price_a eq 0 && $item.status eq 'BookedSuccessfully'}##Definitivereservation##
                                {elseif $item.tour_total_price_a gt 0 && $item.tour_total_price_a eq $item.tour_payments_price_a && $item.status eq 'BookedSuccessfully'} ##Definitivereservation##
                                {elseif $item.tour_total_price_a gt 0 && $item.tour_total_price_a gt $item.tour_payments_price_a && $item.status eq 'BookedSuccessfully'} ##Definitivereservation## ( ##Withoutpayingforeigncurrency##)
                                {elseif $item.status eq 'PreReserve'}##Prereservation## (##ConfirmedCounter##)
                                {elseif $item.status eq 'TemporaryReservation'}##Temporaryreservation## (##Paymentprebookingamount##)
                                {elseif $item.status eq 'TemporaryPreReserve'}##Temporaryprebooking##
                                {elseif $item.status eq 'bank' && $item.tracking_code_bank eq ''}##Unsuccessfulinternetpayment##
                                {elseif $item.cancel_status eq 'CancellationRequest'}##Cancelrequestpassenger##
                                {elseif $item.status eq 'Cancellation'}##Cancellation##
                                    <hr style="border: 1px dashed #d1d1d1;">
                                    {$item.cancellation_comment}
                                {else}##Unknow##
                                {/if}
                            </td>

                            <td>
                                ##Totalamountcurrency##:
                                {$item.tour_total_price_a|number_format} {$item.currency_title_fa}
                                <hr style="border: 1px dashed #d1d1d1;">
                                ##Paymentamountcurrency##:
                                {$item.tour_payments_price_a|number_format} {$item.currency_title_fa}
                            </td>

                            <td>
                                <div class="dropdownUserBuy">
                                    <button class="dropbtnUserBuy"> ##Detail##</button>
                                    <div class="dropdown-content-UserBuy ">
                                        <a id="myBtn" onclick="modalListForTour('{$item.factor_number}');"
                                           class="btn btn-primary fa fa-search margin-10"
                                           title="##ShowReservation##"></a>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/eTourReservation&num={$item.factor_number}"
                                           class="btn btn-dropbox fa fa-print  margin-10"
                                           target="_blank" title="##Showinformation## ">
                                        </a>
                                        <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=BookingTourLocal&id={$item.factor_number}"
                                           title="مشاهده فایل pdf"
                                           class="btn btn-info  fa fa-file-pdf-o" target="_blank">
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {if $smarty.get.status eq 'TemporaryReservation'}
                                <a href="#"
                                   onclick="confirmationTourReservation('{$item.factor_number}');return false"
                                   class="btn btn-success margin-10 fa fa-check" title=" ##Approvereservation##">
                                    ##Approvereservation## </a>
                                {elseif $smarty.get.status eq 'CancellationRequest'}
                                    <a href="#"
                                       onclick="tourConfirmCancellationRequest('{$item.factor_number}');return false"
                                       class="btn btn-danger fa fa-times margin-10" title="  ##Approvecanclerequest##">
                                        ##Approvecanclerequest## </a>
                                    <input type="text" id="cancelPrice{$item.factor_number}"
                                           name="cancelPrice{$item.factor_number}" value=""
                                           placeholder=" ##Emteramountconsignment##   (##Rial##)"
                                           onkeypress="isDigit(this)" onkeyup="javascript:separator(this);"
                                           style="width: 65%;"/>
                                {elseif $item.status eq 'BookedSuccessfully'}
                                    <div id="btn-upload-file">
                                        <a class="btn" onclick="isOpenModal('{$item.factor_number}');">##DownloadTravelTourFiles##</a>
                                    </div>
                                    {if $item.passengers_file_tour neq ''}
                                        {assign var="arrayFile" value=$item.passengers_file_tour|json_decode}
                                        <hr style="border: 1px dashed #d1d1d1;">

                                        <div class="dropdownUserBuy">
                                            <button class="dropbtnUserBuy tourFile"> ##DownloadTourDocumentsFile##</button>
                                            <div class="dropdown-content-UserBuy">
                                                {foreach $arrayFile as $k=>$file}
                                                    <span>
                                                        <a id="downloadLink" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/reservationTour/passengersImages/{$file}" target="_blank"
                                                           type="application/octet-stream"><i class="fa fa-download"></i> ##file## {$k + 1}</a>
                                                    </span>
                                                {/foreach}
                                            </div>
                                        </div>
                                    {/if}
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>

            </div>
        </div>

        <div id="ModalPublic" class="modal">
            <div class="modal-content" id="ModalPublicContent"></div>
        </div>

        <div id="popup-upload-file">
            <div class="modal">
                <div class="modal_header">
                    <div class="container">
                        <span>##DownloadTravelTourFiles##</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="close">
                            <path d="M505.943 6.058c-8.077-8.077-21.172-8.077-29.25 0L6.06 476.693c-8.077 8.077-8.077 21.172 0 29.25 4.038 4.04 9.332 6.057 14.625 6.057 5.293 0 10.586-2.02 14.625-6.06L505.943 35.307c8.076-8.076 8.076-21.17 0-29.248z"/>
                            <path d="M505.942 476.694L35.306 6.06C27.23-2.02 14.134-2.02 6.058 6.06c-8.077 8.075-8.077 21.17 0 29.247l470.636 470.636c4.038 4.04 9.332 6.058 14.625 6.058 5.292 0 10.586-2.018 14.623-6.056 8.075-8.078 8.075-21.173 0-29.25z"/>
                        </svg>
                    </div>
                </div>
                <div class="modal_body">
                    <div class="container">
                        {*<h2>بارگذاری فایل های تور مسافر</h2>*}
                        <p>##descriptionsDownloadTravelTourFiles##</p>
                        <form id='registerPassengersFileTourForm' name="registerPassengersFileTourForm" method='post' enctype='multipart/form-data'>
                            <input type="hidden" name="flag" id="flag" value="registerPassengersFileTour"/>
                            <input type="hidden" name="factorNumber" id="factorNumber" value=""/>

                            <label for="passengersFileTour" class="displayNone">##DownloadTravelTourFiles##</label>
                            <div class="s-u-passenger-item  s-u-passenger-item-change form-group width70">
                                <div class="field">
                                    <i class="btn-upload-file fa fa-upload"></i>
                                    <input type="text" name="passengersFileText" value="" size="40"
                                           class="file_input_replacement" placeholder="انتخاب فایل"
                                           style="padding-right: 115px;">
                                    <input type="file" name="passengersFileTour[]" id="passengersFileTour"
                                           class="file_input_with_replacement" multiple="multiple">
                                </div>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change form-group width30 no-star">
                                <a href="#"
                                   onclick="registerPassengersFileTour();return false"
                                   class="btn btn-success fa fa-check width100" title="##sendFile##">
                                    ##sendFile## </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal_overlay"></div>
        </div>


    {literal}

        <script>
            const modal = document.querySelector("#popup-upload-file .modal");
            const close = document.querySelector("#popup-upload-file .close");
            function isOpenModal(factorNumber) {
                $('#factorNumber').val(factorNumber);
                modal.classList.add("is_open");
            }
            close.addEventListener("click", function(){
                modal.classList.remove("is_open");
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#tourWishList').DataTable();
            });
            $(function () {
                //$(document).tooltip();
            });

            $(".dropdownUserBuy").on("click", function () {
                $(this).find(".dropdown-content-UserBuy").slideToggle("displayb");
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
        <div class="userProfileInfo-messge">
            <div class="messge-login">
                ##Pleaselogin##
            </div>
        </div>
    {/if}
</div>
{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
                </div>
            </div>
        </div>
    </section>
</main>
{/if}
<script src="assets/js/profile.js"></script>