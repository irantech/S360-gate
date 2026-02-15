{*load_presentation_object filename="user" assign="objUser"*}
{if $objSession->IsLogin()}

{assign var="statusShow" value=""}
{assign var="statusText" value=""}
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
        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 half_padding_l">
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
                                    onchange="getUserCancelBuy()">
                                <label for="radio-{$k}" class="radio-custom-label">{$servicesByLanguage}</label>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 half_padding_r" id="result">

            <div class="main-Content-bottom-table Dash-ContentL-B-Table light_border_1">
                <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                    <i class="icon-table"></i>
                    <h3>##Cancellist## :</h3>
                </div>

                {assign var="sDate" value=$objFunctions->DatePrev($objDate->jdate("Y-m-d", '', '', '', 'en'), '7')}
                {assign var="eDate" value=$objDate->jdate("Y-m-d", '', '', '', 'en')}

                <div class="user-buy-box">
                    <div class="user-buy-search-box">
                        <span>
                            <lable for="startDate">##Buydateaz##:</lable>
                            <input type="text" name="startDate" id="startDate"
                                   class="shamsiNoLimitCalendar"
                                   value="{$sDate}" onchange="getUserCancelBuy()">
                        </span>
                        <span>
                            <lable for="endDate">##Buydateta##:</lable>
                            <input type="text" name="endDate" id="endDate"
                                   class="shamsiNoLimitCalendar"
                                   value="{$eDate}" onchange="getUserCancelBuy()">
                        </span>
                        <span>
                            <lable for="factorNumber">##Invoicenumber##/##Voucher##:</lable>
                            <input type="text" name="factorNumber" id="factorNumber"
                                   value="" placeholder="##Invoicenumber##/##WachterNumberenter##"
                                   onkeyup="getUserCancelBuy()">
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

</div>
{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
        </div>
        </div>
     </div>
   </section>
</main>
{/if}
{literal}
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                getUserCancelBuy();
            }, 100);
        });

        function getUserCancelBuy() {
            let appType = $('input[name=radio-group]:checked').val();
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
                            flag: 'getUerCancelBuy',
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
            $(this).find(".dropdown-content-UserBuy").slideToggle("displayb");
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
    </script>
    <script type="text/javascript">
        var table = $('#userProfile').DataTable();
        $('.Status-tab-link').on('click', function () {
            var tab_status = $(this).attr('data-tab');
            table.search(tab_status).draw();
        });
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
    <script src="assets/js/profile.js"></script>
{/literal}



{else}
    {$objUser->redirectOut()}
{/if}