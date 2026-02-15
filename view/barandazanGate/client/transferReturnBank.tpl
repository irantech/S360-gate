{load_presentation_object filename="redirectBank" assign="objRedirectBank"}
{assign var="redirectBank" value=$objRedirectBank->replaceRedirectBankUrls()}
{assign var="returnUrl" value=$objRedirectBank->createReturnUrl($smarty.get)}

{if $redirectBank}

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 Clr">
    <div class="main-bank-box">

        <div class='w-100 d-flex justify-content-center'>
            <img src="assets/images/redirectBank.png" style='width:250px'>
        </div>

    </div>
</div>


<form action='{$smarty.const.SERVER_HTTP}{$redirectBank['url']}/gds/{$smarty.const.SOFTWARE_LANG}/{$smarty.get['redirectUrl']}{$returnUrl}' method='post' class='submitForm'>
    {foreach $smarty.post as $key => $data}
       <input type='hidden' name='{$key}' value='{$data}'>
    {/foreach}
</form>

{literal}
    <script>
      $('document').ready(function(){
        $( ".submitForm" ).trigger( "submit" );
      });
      function noBack() {
        window.history.forward();
      }
    </script>

{/literal}
{/if}