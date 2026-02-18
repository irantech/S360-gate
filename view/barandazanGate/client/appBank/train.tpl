<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 " >
        <div class="main-bank-box">
            <div class="mbb-preload">
                <img src="assets/images/pre-bank.png">
            </div>
            <h4 class="mbb-bank-title">
                {if $smarty.get.bankType eq 'credit'}
                    <span>##Ongoingoperations## </span>
                {else}
                    <span>##Transferfromsiteport## </span>
                    <span>##Bank##</span>
                {/if}
            </h4>
            {if $smarty.get.bankType neq 'credit'}
                <div class="mbb-bank-img">
                    <div class="boxer"><img src="project_files/images/logo.png" /></div>
                    <div class="boxer fr-box"> <img class="flash-row" src="assets/images/fading-arrows.gif" /></div>
                    <div class="boxer"><img src="assets/images/bank/bank{$smarty.get.bankType}.png" /></div>
                </div>
                <div class="txtAlertBank">

                    ##Ticketswillisspaidbankagainsite##

                </div>
            {/if}
        </div>
    </div>
</div>


{load_presentation_object filename="bookingTrain" assign="objBook"}
{if $smarty.get.bankType neq 'credit'}
    {$objBook->setPortBankTrain($smarty.get.bankType,$smarty.get.factorNumber)}
{/if}

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
    form.submit();
    document.body.removeChild(form);
  }
</script>

{load_presentation_object filename="bank" assign="objBank"}
{$objBank->initBankParams($smarty.get.bankType)}
{$objBank->calculateAmount('train', $smarty.get.factorNumber)}
{$objBank->executeBank('go')}

{if $objBank->failMessage eq ''}
    {$objBook->sendUserToBankForTrain($objBank->factorNumber)}
{else}
    <div class="txtCenter txtRed txt17"> ##Error##: {$objBank->failMessage} </div>
{/if}