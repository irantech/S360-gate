
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

{*
{load_presentation_object filename="bank" assign="objBank"}
{$objBank->initBankParams($smarty.post.bank)}
{$objBank->calculateAmount('increaseCreditAgency')}
{$objBank->executeBank('go')}
{if $objBank->failMessage neq ''}
       <div class="txtCenter txtRed txt17"> :خطا {$objBank->failMessage} </div>
{/if}
*}
