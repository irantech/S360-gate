{load_presentation_object filename="visa" assign="objVisa"}


{assign var="visaOptionByKeyArray" value=['clientID'=>$smarty.const.CLIENT_ID,'key'=>'marketPlace']}
{assign var="visaOptionByKey" value=$objVisa->visaOptionByKey($visaOptionByKeyArray)}

{if $objSession->IsLogin() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and $visaOptionByKey['value'] eq 'available'}



{load_presentation_object filename="country" assign="objCountry"}
{load_presentation_object filename="currency" assign="objCurrencyList"}
{assign var="continents" value=$objCountry->continentsList()}

{load_presentation_object filename="visa" assign="objVisa"}
{load_presentation_object filename="visaType" assign="objVisaType"}
{assign var="visaTypeList" value=$objVisaType->allVisaTypeList()}
{assign var="visaList" value=$objVisa->agencyVisaList($smarty.session.userId)}



{if $smarty.const.SOFTWARE_LANG eq 'fa'}
    {assign var="DeptDatePickerClass" value='shamsiDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='shamsiReturnCalendar'}
{else}
    {assign var="DeptDatePickerClass" value='gregorianDeptCalendar'}
    {assign var="ReturnDatePickerClass" value='gregorianReturnCalendar'}
{/if}


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

    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`visaPanelLinks.tpl"}

    <style>
        table.dataTable thead .sorting{
            background-image: none !important;
        }
    </style>

    <div class="col-md-12 mb-4 bg-white p-3">
        <table id="visaList" class="table table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">##VisaName##</th>
                <th scope="col">##ReservationMethod##</th>
                <th scope="col">##Country##</th>
                <th scope="col">##VisaType##</th>
                <th scope="col">##Validity##</th>
                <th scope="col">##AcceptStatus##</th>
                <th scope="col">##Action##</th>
            </tr>
            </thead>
            <tbody>
            {assign var="number" value="0"}
            {foreach key=key item=item from=$visaList}
                {assign var="visaExpiration" value=$objVisa->visaExpirationDiff($item['id'])}
                {$number=$number+1}
                <tr class="text-center">
                    <th scope="row">{$number}</th>
                    <td>{$item['title']}</td>
                    <td>
                        {if $item['redirectUrlCheck'] === '1'}
                            <span class="fa fa-phone"></span>
                            ##PhoneCall##
                        {else}
                        {if $item['OnlinePayment'] === 'yes'}
                            <span class="fa fa-credit-card-alt"></span>
                            ##S360OnlinePay##
                        {else}
                            <span class="fa fa-calendar-alt"></span>
                            ##Reservation##
                        {/if}
                        {/if}

                    </td>
                    <td>{$item['countryName']}</td>
                    <td>{$item['visaTypeName']}</td>
                    <td title="{$visaExpiration['result_message']['expired_at']}">{$visaExpiration['result_message']['remainingTile']}</td>
                    <td>
                        {if $item['validate'] == 'granted'} <span class="text-success">تایید شده</span> {else} <span class="text-warning">در صف انتظار</span> {/if}
                        {if $item['adminReview'] != ''}
                        <span class="text-info"
                              data-id="{$item['id']}"
                              data-target="#visaModal"
                              onclick="showVisaModal($(this))">
                            (<span class="fa fa-info"></span>)
                        </span>
                        {/if}
                    </td>
                    <td>
                        <div class="btn-group flex-wrap" role="group" aria-label="Basic example">
                            <button
                                    data-id="{$item['id']}"
                                    onclick="deleteVisaStatus($(this))"
                                    type="button" class="btn btn-sm btn-outline-danger"><span
                                        class="fa fa-remove"></span> حذف
                            </button>
                            <a href="{$smarty.const.ROOT_ADDRESS}/visaEdit&id={$item['id']}"
                                    class="btn btn-sm btn-outline-info"><span class="fa fa-edit"></span>
                                ویرایش
                            </a>
                            <button type="button"
                                    data-id="{$item['id']}"
                                    data-target="#visaModal"
                                    onclick="showVisaModal($(this))"
                                    class="btn btn-sm btn-outline-secondary"><span class="fa fa-eye"></span> نمایش
                            </button>
                            <a href="{$smarty.const.ROOT_ADDRESS}/resultVisa/{$item['countryCode']}/all/1-0-0"
                               target="_blank" class="btn btn-sm btn-outline-primary"><span
                                        class="fa fa-link"></span> ##Link##
                            </a>
                        </div>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="visaModal" tabindex="-1" aria-labelledby="visaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="visaModalLabel">Modal title</span>
                    <button type="button" class="close ml-0 mr-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="visaModalContent" class="modal-body">
                    ***
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
{*                    <button type="button" class="btn btn-primary">Save changes</button>*}
                </div>
            </div>
        </div>
    </div>


    {* ********************* editor_TinyMCE ********************* *}
    {literal}
        <script type="text/javascript" src="assets/editor_TinyMCE/editor/tinymce.min.js"></script>
        <script type="text/javascript" src="assets/editor_TinyMCE/editor.js"></script>
    {/literal}
    {* ********************* editor_TinyMCE ********************* *}


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

<link rel="stylesheet" type="text/css" href="assets/css/ldbtn.min.css">
<script src="assets/js/profile.js"></script>
<script type="text/javascript" src="assets/js/customForVisa.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#visaList').DataTable();
    });

</script>
