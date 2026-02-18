
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
{*{$objFunctions->exitCode()}*}

{if isset($smarty.get.request_number_return) && $smarty.get.request_number_return neq ''}
    {assign var='request_number' value=['dept'=>$smarty.get.request_number_dept,'return'=>$smarty.get.request_number_return]}
{elseif isset($smarty.get.request_number_two_way) && $smarty.get.request_number_two_way neq ''}
    {assign var='request_number' value=['TwoWay'=>$smarty.get.request_number_two_way]}
{else}
    {assign var='request_number' value=['dept'=>$smarty.get.request_number_dept]}
{/if}

{load_presentation_object filename="parvazBookingLocal" assign="objBook"}
{if $smarty.post.bankType neq 'credit'}
    {$objBook->setPortBank($smarty.get.bankType,$request_number)}
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
    console.log(form);
    form.submit();
    document.body.removeChild(form);
  }
</script>

{load_presentation_object filename="bank" assign="objBank"}
{$objBank->initBankParams($smarty.get.bankType)}
{$objBank->calculateAmount('local', $request_number)}

{$objBank->executeBank('go')}

{$objBank->failMessage}
{*
{if $objBank->failMessage eq ''}
    {$objBook->sendUserToBank($objBank->factorNumber)}
{else}
    <div class="txtCenter txtRed txt17"> ##Error##: {$objBank->failMessage} </div>
{/if}
*}
