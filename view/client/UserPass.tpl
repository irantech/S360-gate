{include file="`$smarty.const.FRONT_CURRENT_CLIENT`clientProfile.tpl"}
<div class="client-head-content">
{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}


{load_presentation_object filename="user" assign="objUser"}

<div class="main-Content-top s-u-passenger-wrapper-change" >
    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color userpass-tilte">
        <i class="zmdi zmdi-account-box-mail zmdi-hc-fw mart10"></i> ##Changpassword##
    </span>
    <div class="panel-default-change site-border-main-color">

        <form class=" s-u-result-item-change" method="post" id="ChangePass">
            <input type="hidden" name="member_id"  id="member_id" value="{$objUser->userId}">
            <div class=" col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="userProfileInfo-change userProfileInfo" >
                    <span>   ##Newpassword## :</span>
                    <input type="password"  name="new_pass"  id="new_pass" value="">
                </div>
            </div>
            <div class=" col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="userProfileInfo-change userProfileInfo" >
                    <span>   ##Repeatpassword##:</span>
                    <input class="align-left" type="password" name="con_pass"  id="con_pass" value="">
                </div>
            </div>
{*            <div class=" col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="userProfileInfo-change userProfileInfo" >
                    <span>   ##Securitycode## :</span>
                        <input type="text" placeholder="##Securitycode##" name="signin-captcha2" id="signin-captcha2" class="full-width has-padding">
                         <a id="captchaRefresh" title="refresh image" onclick="reloadCaptcha();"></a>
                            <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid={$smarty.const.CAPTCHA_SID}" alt="">
                </div>
            </div>*}
            <div class="userProfileInfo-btn userProfileInfo-btn-change col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color" type="button" value=" ##Recordchange##" onclick="ChangePassword(); return false">
            </div>


        </form>
    </div>
</div>

{else}
<div class="userProfileInfo-messge">
    <div class="messge-login">
##Pleaslogin##
    </div>
</div>
{/if}
</div>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function () {
        $('#userProfile').DataTable();
    });
</script>
{/literal}