{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
{load_presentation_object filename="Emerald" assign="objUser"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="members" assign="objMembers"}
{assign var="infoZomorod" value=$objMembers->infoZomorod($objSession->getUserId())}
{assign var="profile" value=$objUser->getProfile({$objSession->getUserId()})}
{assign var="sessionid" value=$objSession->getUserId()}
{assign var="sumrequestall" value=$objUser->SumRequestAll({$objSession->getUserId()})}
{assign var="sumrequest" value=$objUser->sumRequestVerified({$objSession->getUserId()})}
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

{if $smarty.const.SOFTWARE_LANG eq 'fa'}
<div class="client-head-content">
<div class="main-Content-top s-u-passenger-wrapper-change" >
    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
       <a href="https://www.iran-tech.com/temp.php?irantech=league"> <i class="zmdi zmdi-star zmdi-hc-fw mart10"></i> ##EmeraldLeague##</a>
    </span>
    <div class="panel-default-change site-border-main-color">
        <div class="s-u-result-item-change">
            <div class="description-Emerald">
                <form  id="RequestZomorod" method="post" name="RequestZomorod">
                <span>
                    {functions::StrReplaceInXml(["@@sumrequest@@"=>$sumrequest,"@@leaguePoints@@"=>$objFunctions->leaguePoints($infoZomorod)|number_format,"@@infoZomorod@@"=>$infoZomorod],"EmeraldsEquivalentRialsDepositedAccount")}
                    </br>
                    {functions::StrReplaceInXml(["@@leaguePoints@@"=>($objFunctions->leaguePoints($infoZomorod))-($sumrequest)],"HaveInfoZomorodRialsYouCanGet")}
                    <input type="text" name="payRial" id="payRial" value="" placeholder="##RequiredAmountRial##">
                    ##GetIt##
                </span>
            </div>
            <div class="userProfileInfo-btn userProfileInfo-btn-change">
                <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color" type="submit" value="##Submitapplication##">
            </div>







                            <input type="hidden" value="RequestZomorod" name="flag">
                            <input type="hidden" value="{$sessionid}" name="userid" >
                            <input type="hidden" value="{$profile['fk_agency_id']}" name="agencyId">
                            <input type="hidden" value="{$sumrequestall}" name="cond">
                            <input type="hidden" value="{($objFunctions->leaguePoints($infoZomorod))-($sumrequest)}" name="remain">
                            <input type="hidden" value="{$profile['sheba']}" name="cond2">




                    </form>


<div class="Emerald-section">


</div>
            <div class="main-Content-bottom Dash-ContentL-B">
                <div class="main-Content-bottom-table Dash-ContentL-B-Table">
                    <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                        <i class="icon-table"></i><h3>##YourRequestsList## :</h3>
                    </div>

                    <table id="Emerald" class="display" cellspacing="0" width="100%">

                        <thead>
                        <tr>
                            <th>##Row##</th>
                            <th>##Description##</th>
                            <th>##RegistrationDate##</th>
                            <th>##DateOfPayment##</th>
                            <th>##Depositamount##</th>
                        </tr>
                        </thead>

                        <tbody>
                        {assign var="number" value="1"}
                        {foreach key=key item=item from=$objUser->getAllRequest({$objSession->getUserId()})}
                            <tr>
                                <td>{$number++}</td>
                                {if {$item['status']} eq 'Progress'}  <td style="color: darkorange">##Pending##</td>{else}<td style="color: green">##Paid##</td>{/if}
                                <td>{$item['date']}</td>
                                <td>{$item['paydate']}</td>
                                <td>{$item['value']}</td>
                            </tr>
                        {/foreach}
                        <tbody>


                    </table>

                </div>
            </div>
            <a  target="_blank" href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/Emerald/rahnamaye_zomorod_360.pdf" class="btn btn-lg btn-success"> راهنمای دریافت زمرد</a>

        </div>

    </div>
</div>
{else}
    <div class="userProfileInfo-messge">
        <div class="messge-login">
           ##Pleasslogin##
        </div>
    </div>
{/if}
</div>
</div>
{/if}
{if in_array($smarty.const.CLIENT_ID, $objFunctions->newLogin())}
            </div>
        </div>
        </div>
    </section>
</main>
{/if}
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#Emerald').DataTable();
        });
    </script>
    <script src="assets/js/profile.js"></script>
{/literal}