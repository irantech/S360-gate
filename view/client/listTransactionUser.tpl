{load_presentation_object filename="memberCredit" assign="objMemberCredit"}
{load_presentation_object filename="user" assign="objUser"}
{if $objSession->IsLogin()}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`clientProfile.tpl"}
    <div class="client-head-content">

        <div class="main-Content-bottom-table Dash-ContentL-B-Table ">
            <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title site-bg-main-color">
                <i class="icon-table"></i>
                <h3>##Transactionlist##:</h3>
            </div>

            <table id="UserTransaction" class="display" cellspacing="0" width="100%">

                <thead>
                <tr>
                    <th>##Row##</th>
                    <th>##Invoicenumber##</th>
                    <th>##Amount##</th>
                    <th> ##Typepayment##</th>
                    <th>##Description##</th>
                    <th>##Status##</th>
                    {*<th>##TrackingCode##</th>*}
                    <th>##Date##</th>
                </tr>
                </thead>

                <tbody>
                {assign var="number" value="1"}
                {foreach key=key item=item from=$objMemberCredit->listAllSuccessCreditMember()}
                    <tr>
                        <td>{$number++}</td>
                        <td>
                            {$item.factorNumber}
                        </td>

                        <td>
                            {$item.amount|number_format}
                        </td>

                        <td dir="ltr">
                            {if $item.reason eq 'charge'}
                                ##ChargeAccount##
                            {elseif $item.reason eq 'buy'}
                                ##Buy##
                            {elseif $item.reason eq 'reagent_code_presented'}
                                ##GiftCodeReference##
                            {/if}

                        </td>

                        <td dir="ltr">
                            {$item.comment}
                        </td>

                        <td>

                                {if $item.status eq 'success'}
                            <span class='success-bg-text-with-padding-and-radius'>##Successpayment##  </span>
                                {elseif $item.status eq 'error'}
                                    <span class='error-bg-text-with-padding-and-radius'>##ErrorPayment##  </span>
                                {elseif $item.status eq 'progress'}
                                    <span class='pending-bg-text-with-padding-and-radius'>##Processing##  </span>
                                {/if}

                        </td>

                   {*     <td>
                            {$item.bankTrackingCode}

                        </td>*}
                        <td>
                            {$objDate->jdate("Y-m-d H:i:s",$item.creationDateInt)}
                        </td>


                    </tr>
                {/foreach}

            </table>
        </div>

        <div id="ModalPublic" class="modal">

            <div class="modal-content" id="ModalPublicContent">

            </div>

        </div>
    </div>
    </div>

{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#UserTransaction').DataTable();


        });


    </script>
{/literal}

{else}
    {$objUser->redirectOut()}
{/if}
