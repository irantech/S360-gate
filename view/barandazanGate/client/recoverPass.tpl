{load_presentation_object filename="members" assign="objMember"}
{if $smarty.get.key neq ''}
{assign var='flag' value='yes'}
{/if}

{if $flag eq 'yes'}

{assign var="hashedPass" value=functions::HashKey({$smarty.get.key},'decrypt')}

{if $objMember->findUser($hashedPass) neq ''}
<div class="s-u-popup-in-result">

   <div class=""> <!--  this is the entire modal form, including the background -->

     <div class="cd-user-modal-container">  <!--   this is the container wrapper -->
            <div class="cd-login is-selected">  <!--  log in form -->

                <form class="cd-form" id="RecoverPassword">
                    <input type="hidden" value="{$smarty.get.key}" id="member_id">
                    <p class="fieldset">
                        <input class="full-width has-padding has-border" id="new_pass" type="password" placeholder="##Newpassword##" value="">
                        <span class="cd-error-message" id="error-signin-email2"></span>
                    </p>
                    <p class="fieldset">
                        <input class="full-width has-padding has-border" id="con_pass" type="password"  placeholder="##Repeatpassword##" value="">
                        <span class="cd-error-message" id="error-signin-password2"></span>
                    </p>
                    <div class="message-login txtCenter txtRed"></div>
                    <p class="fieldset">
                        <input class="full-width " type="button" value="##Registerinformation##" onclick="ChangePassForRecovery()">
                </form>
            </div>
        </div>
    </div>
</div>
{else}
<div class="s-u-bank-wrapper s-u-bank-wrapper-change">
    <p class="s-u-bank-result s-u-bank-result-error-change">##Bugpasswordrecoveryprocess##</p>
    <div class="s-u-bank-content-error-change">##Passwordrecoverylinkisvalid##</div>
</div>
{/if}
{else}
<div class="s-u-bank-wrapper s-u-bank-wrapper-change">
    <p class="s-u-bank-result s-u-bank-result-error-change">##Bugpasswordrecoveryprocess##</p>
    <div class="s-u-bank-content-error-change">##expireddeadlinerequest## <br/> ##Requestnewpasswordpassword## </div>
</div>

{/if}
