{load_presentation_object filename="redirectBank" assign="objRedirectBank"}
{assign var="redirectBank" value=$objRedirectBank->redirectBankUrls()}

<div class="row bank_box_row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 " >
        <div class="main-bank-box">
            <div class="mbb-preload">
                <img src="assets/images/pre-bank.png">
            </div>
            <h4 class="mbb-bank-title">
                {if $smarty.post.bankType eq 'credit'}
                    <span>##Ongoingoperations## </span>
                {else}
                    <span>##Transferfromsiteport## </span>
                    <span>##Bank##</span>
                {/if}
            </h4>
            {if $smarty.post.bankType neq 'credit'}
                <div class="mbb-bank-img">
                    <div class="boxer"><img src="project_files/images/logo.png" /></div>
                    <div class="boxer fr-box"> <img class="flash-row" src="assets/images/fading-arrows.gif" /></div>
                    <div class="boxer"><img src="assets/images/bank/bank{$smarty.post.bankType}.png" /></div>
                </div>
                <div class="txtAlertBank">

                    ##Ticketswillisspaidbankagainsite##

                     </div>
            {/if}
        </div>
    </div>
</div>




{if $smarty.post.serviceType eq 'chargeAccountUser'}
    {load_presentation_object filename="members" assign="objmemberCredit"}
    {assign var="ParamsAccountChargeUser" value=["price"=>$smarty.post.price,"factorNumber"=>$smarty.post.factorNumber]}
    {$objmemberCredit->increaseChargeAccount($ParamsAccountChargeUser)}

{/if}


{if $smarty.post.serviceType eq 'increaseCreditAgency'}
    {load_presentation_object filename="transaction" assign="transaction"}
    {assign var="factorNumberCreditagency" value=$transaction->addTransactionToClientANDAgency($smarty.post)}

{/if}

{load_presentation_object filename="parvazBookingLocal" assign="objBook"}
{if $smarty.post.bankType neq 'credit'}
    {$objBook->setPortBank($smarty.post.bankType,$smarty.post.RequestNumber)}
{/if}
{if $redirectBank}
{literal}
<script language="javascript" type="text/javascript">

  function sendForm(link, inputs) {
    let redirectUrl = {/literal}'{$smarty.const.SERVER_HTTP}{$redirectBank['replace_url']}/gds/{$smarty.const.SOFTWARE_LANG}/transferToBank'{literal}
    let form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", redirectUrl);

    let decodedInputs = $.parseJSON(inputs);
    $.each(decodedInputs, function (i, item) {
      let hiddenField = document.createElement("input");
      hiddenField.setAttribute("name", i);
      hiddenField.setAttribute("value", item);
      form.appendChild(hiddenField);
    });
    let hiddenUrl = document.createElement("input");
    hiddenUrl.setAttribute("name", "link");
    hiddenUrl.setAttribute("value", link);
    form.appendChild(hiddenUrl);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
  }
</script>
{/literal}
{else}
<script language="javascript" type="text/javascript">
    function sendForm(link, inputs) {
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", link);

        var decodedInputs = $.parseJSON(inputs);
        $.each(decodedInputs, function (i, item) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("name", i);
            hiddenField.setAttribute("value", item);
            form.appendChild(hiddenField);
        });

        document.body.appendChild(form);
        console.log(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>
{/if}
{load_presentation_object filename="bank" assign="objBank"}
{$objBank->initBankParams($smarty.post.bankType)}
{$objBank->calculateAmount('cip', $smarty.post.requestNumber)}
{$objBank->executeBank('go')}

{if $objBank->failMessage eq ''}
    {$objBook->sendUserToBank($objBank->factorNumber)}
{else}
    <div class="txtCenter txtRed txt17"> ##Error##: {$objBank->failMessage} </div>
{/if}
