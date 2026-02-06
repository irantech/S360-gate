<div class="row">
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
                <div class="txtAlertBank">##Bankback##</div>
            {/if}
        </div>
    </div>
</div>

{load_presentation_object filename="bookingGasht" assign="objBook"}

{if $smarty.post.bankType neq 'credit'}

    {$objBook->setPortBankGasht($smarty.post.bankType,$smarty.post.factorNumber)}
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
{$objBank->initBankParams($smarty.post.bankType)}
{$objBank->calculateAmount('gasht', $smarty.post.factorNumber)}

{$objBank->executeBank('go')}

{if $objBank->failMessage eq ''}
    {$objBook->sendUserToBankForGasht($smarty.post.factorNumber)}
{else}
    <div class="txtCenter txtRed txt17"> ##Error##: {$objBank->failMessage} </div>
{/if}