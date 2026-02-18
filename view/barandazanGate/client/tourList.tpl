
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
    {load_presentation_object filename="dateTimeSetting" assign="objDateTimeSetting"}
    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
        {assign var="correctDate" value=$objDateTimeSetting->jdate("Y-m-d", '', '', '', 'en') }
    {else}
        {assign var="correctDate" value=date("Y-m-d") }
    {/if}


    {if $objTour->accessReservationTour() and $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter'}

        <div id="popup-upload-file">
            <div class="modal" id="modal-upload-file">
                <div class="modal_header">
                    <div class="container">
                        <span>##deleteandinserttypetour##</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="close" id="close-upload-file">
                            <path d="M505.943 6.058c-8.077-8.077-21.172-8.077-29.25 0L6.06 476.693c-8.077 8.077-8.077 21.172 0 29.25 4.038 4.04 9.332 6.057 14.625 6.057 5.293 0 10.586-2.02 14.625-6.06L505.943 35.307c8.076-8.076 8.076-21.17 0-29.248z"/>
                            <path d="M505.942 476.694L35.306 6.06C27.23-2.02 14.134-2.02 6.058 6.06c-8.077 8.075-8.077 21.17 0 29.247l470.636 470.636c4.038 4.04 9.332 6.058 14.625 6.058 5.292 0 10.586-2.018 14.623-6.056 8.075-8.078 8.075-21.173 0-29.25z"/>
                        </svg>
                    </div>
                </div>
                <div class="modal_body">
                    <div class="container">
                        <p>##deleteandinserttypetourdiscriptions##</p>
                        <form id='deleteAndInertTourTypeForm' name="deleteAndInertTourTypeForm" method='post'
                              enctype='multipart/form-data'>
                            <input type="hidden" name="flag" id="flag" value="deleteAndInertTourType"/>
                            <input type="hidden" name="isOneDayTour" id="isOneDayTour" value=""/>
                            <input type="hidden" name="idSame" id="idSame" value=""/>

                            <div class="s-u-passenger-item s-u-passenger-item-change form-group no-star width70"
                                 id="selectTourType">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change form-group width30 no-star">
                                <a href="#"
                                   onclick="deleteAndInertTourType();return false"
                                   class="btn btn-success fa fa-check width100 button-new-detail" title="##Sendinformation##">
                                    ##Sendinformation## </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="modal_overlay"></div>
        </div>




        <div id="popup-upload-file">
            <div class="modal" id="modal-discount">
                <div class="modal_header">
                    <div class="container">
                        <span>##Discount##</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="close" id="close-discount">
                            <path d="M505.943 6.058c-8.077-8.077-21.172-8.077-29.25 0L6.06 476.693c-8.077 8.077-8.077 21.172 0 29.25 4.038 4.04 9.332 6.057 14.625 6.057 5.293 0 10.586-2.02 14.625-6.06L505.943 35.307c8.076-8.076 8.076-21.17 0-29.248z"/>
                            <path d="M505.942 476.694L35.306 6.06C27.23-2.02 14.134-2.02 6.058 6.06c-8.077 8.075-8.077 21.17 0 29.247l470.636 470.636c4.038 4.04 9.332 6.058 14.625 6.058 5.292 0 10.586-2.018 14.623-6.056 8.075-8.078 8.075-21.173 0-29.25z"/>
                        </svg>
                    </div>
                </div>
                <div class="modal_body">
                    <div class="container">
                        <p>لطفا نوع تخفیف (ریالی یا درصد) را انتخاب کنید و بعد براساس انتخاب نوع تخفیف مقدار آن را وارد کنید.</p>
                        <form id='discountTourForm' name="discountTourForm" method='post'
                              enctype='multipart/form-data'>
                            <input type="hidden" name="flag" id="flag" value="setDiscountTour"/>
                            <input type="hidden" name="idSameTour" id="idSameTour" value=""/>

                            <div class="s-u-passenger-item s-u-passenger-item-change form-group no-star width30">
                                <select name="discountType" id="discountType">
                                    <option value="" selected="selected">انتخاب کنید</option>
                                    <option value="price">ریالی</option>
                                    <option value="percent">درصد</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change form-group no-star width30">
                                <input type="text" name="discount" id="discount" placeholder="" value="">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change form-group width40 no-star">
                                <a href="#"
                                   onclick="setDiscountTour();return false"
                                   class="btn btn-success fa fa-check width100" title="##Sendinformation##">
                                    ##Sendinformation## </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal_overlay"></div>
        </div>


            {load_presentation_object filename="reservationTour" assign="objResult"}
        <div class="main-Content-bottom-table Dash-ContentL-B-Table ">
            <div class=" site-bg-main-color title_table">
                <i class="icon-table"></i>
                {if isset($smarty.get.id)}
                    <h3>##Archivetour##:</h3>
                    <a class="archive-tour" href="{$smarty.const.ROOT_ADDRESS}/tourList"> ##Reporttour##</a>
                {else}
                    <h3>##Listsettour## :</h3>
                    <a class="archive-tour" href="{$smarty.const.ROOT_ADDRESS}/tourList&id=archive"> ##Archivetour##</a>
                    <a class="archive-tour" href="{$smarty.const.ROOT_ADDRESS}/tourRegistration"> ##Newtourentry##</a>
                {/if}
            </div>

            <div class="content-table">

                <table id="tourList" class="display" cellspacing="0" width="100%">

                <thead>
                <tr>
                    <th>##Row##</th>
                    <th> ##Createdate##<br>##Createhour##</th>
                    <th> ##Nametour##<br>##Codetour##</th>
                    <th> ##Datestarthold##<br> ##Dateendhold##</th>
                    <th> ##Countnight## <br> ##Countday##</th>

                    {if !isset($smarty.get.id)}


                        <th>##Gallery##</th>
                        <th>##Status##</th>
                        <th>##countReserve##</th>
                        <th>##Showdate##</th>
                        <th>##Action##</th>

                    {/if}

                </tr>
                </thead>

                <tbody>
                {assign var="number" value="0"}
                {if isset($smarty.get.id)}
                    {assign var="reportTour" value=$objResult->archiveReportTour($smarty.session.userId)}
                {else}
                    {assign var="reportTour" value=$objResult->reportTour($smarty.session.userId)}
                {/if}


                {foreach key=key item=item from=$reportTour}
                    {$number=$number+1}

                    {if 1|in_array:$item['tour_type_id']}
                        {assign var="isOneDayTour" value="yes"}
                    {else}
                        {assign var="isOneDayTour" value="no"}
                    {/if}


                    <tr>
                        <td data-content="##Row##">{$number}</td>

                        <td data-content="##Createdate##">{$item['create_date_in']}
                            <hr style="color: #f4fffe;">{$item['create_time_in']}</td>
                        <td data-content="##Nametour##">{$item[$objFunctions->ChangeIndexNameByLanguage($item['language'],'tour_name')]}
                            <hr style="color: #f4fffe;">{$item['tour_code']}</td>
                        <td data-content="##Datestarthold##">{$objFunctions->convertDate($item['minDate'])}
                            <hr style="color: #f4fffe;">{$objFunctions->convertDate($item['maxDate'])}
                        </td>
                        <td data-content="##Countnight##">
                            {$item['night']} ##Night##
                            <hr style="color: #f4fffe;">{$item['day']} ##Day##
                        </td>


                        {if !isset($smarty.get.id)}

<!--                            <td data-content="##Typetour##">
                                <div id="btn-upload-file">
                                    <a class="btn btn_action site-bg-main-color" onclick="isOpenModalTourType('{$item['id_same']}', '{$isOneDayTour}');">
                                        ##deleteandinserttypetour##
                                    </a>
                                </div>
                            </td>-->
                            <td data-content="##Gallery##">
                                <a href="{$smarty.const.ROOT_ADDRESS}/tourGallery&id={$item['id_same']}"
                                   class="btn_action site-bg-main-color fa fa-picture-o"></a>
                            </td>
                            <td data-content="##Status##">

                                {if $objFunctions->convertDate($item['maxDate']) le $correctDate }
                                    <div class="btn-warning">##Expired##</div>
                                {else}
                                    {if $item['is_show'] eq ''}
                                        <div class="btn-warning"> ##Pending##</div>
                                    {elseif $item['is_show'] eq 'yes'}
                                        <div class="btn-success"> ##Showinsite##</div>
                                    {elseif $item['is_show'] eq 'no'}
                                        <div class="btn-danger">##Disallowshowinssite##</div>
                                    {/if}
                                {/if}


                            </td>
                            <td data-content="##countReserve##">
                                <button class="site-bg-main-color" onclick="modalListForReserveTour('{$item.tour_code}');">
                                    <span >{$objResult->getTourBookingCountPanel($item['tour_code'])}
                                   رزرو</span>
                                </button>
                            </td>
                            <td data-content="##Showdate##">
                                <a href="{$smarty.const.ROOT_ADDRESS}/listTourDates&id={$item['id_same']}"
                                   class="btn_action site-bg-main-color fa fa-list"></a>
                            </td>


                            <td data-content="##Action##">
<!--                                <a data-title="تخفیف" onclick="isOpenModalTourDiscount('{$item['id_same']}', '{$item['discount_type']}', '{$item['discount']}');"
                                   class="btn_action site-bg-main-color fa fa-percent tooltip_w"></a>-->

                                <a data-title="ویرایش" href="{$smarty.const.ROOT_ADDRESS}/groupTourEdit&id={$item['id_same']}"
                                   class="btn_action site-bg-main-color fa fa-pencil-square-o tooltip_w"></a>
                                <a data-title="حذف" onclick="logicalDeletion('{$item.id_same}', 'id_same'); return false;"
                                   class="btn_action site-bg-main-color fa fa-times tooltip_w"></a>
                            </td>
                        {/if}

                    </tr>
                {/foreach}
                <div id="ModalPublic" class="modal">
                    <div class="modal-content" id="ModalPublicShowReserveList"></div>
                </div>

            </table>
            </div>
        </div>
    {literal}
        <script type="text/javascript">
            $(document).ready(function () {
                $('#tourList').DataTable();
            });
            $(function () {
                $(document).tooltip();
            });
        </script>
        <script type="text/javascript">
           function modalListForReserveTour(tour_code) {
              setTimeout(function () {
                 $('.loaderPublicForHotel').fadeOut(500);
                 $("#ModalPublic").fadeIn(700);
              }, 1000);
              $.post(libraryPath + 'ModalCreatorForTour.php',
                 {
                    Controller: 'manifestTourController',
                    Method: 'ModalShowForReserveTour',
                    factorNumber: tour_code
                 },
                 function (data) {
                    $('#ModalPublicShowReserveList').html(data);
                 });
           }
        </script>
        <script>
            function isOpenModalTourType(idSame, isOneDayTour) {

                $('#idSame').val(idSame);
                $('#isOneDayTour').val(isOneDayTour);

                $.ajax({
                    type: 'post',
                    url: amadeusPath + 'tour_ajax.php',
                    data: {
                        idSame: idSame,
                        flag: 'createSelectTourType'
                    },
                    success: function (data) {
                        $('#selectTourType').html(data);
                        $(".select2").select2();
                        document.querySelector("#popup-upload-file #modal-upload-file").classList.add("is_open");
                    }
                });

            }
            document.querySelector("#popup-upload-file #close-upload-file").addEventListener("click", function () {
                document.querySelector("#popup-upload-file #modal-upload-file").classList.remove("is_open");
            });

            function isOpenModalTourDiscount(idSame, discountType, discount) {
                $('#idSameTour').val(idSame);
                if (discountType != '') {
                    $('#discountType').val(discountType).change();
                }
                $('#discount').val(discount);
                document.querySelector("#popup-upload-file #modal-discount").classList.add("is_open");
            }
            document.querySelector("#popup-upload-file #close-discount").addEventListener("click", function () {
                document.querySelector("#popup-upload-file #modal-discount").classList.remove("is_open");
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