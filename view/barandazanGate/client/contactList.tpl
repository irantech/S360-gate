{load_presentation_object filename="contactUs" assign="objcontact"}
{assign var="contactList" value=$objcontact->GetData()}

{if $objSession->IsLogin() && $objSession->getTypeUser() eq 'agency'}


{include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
 <div class="client-head-content">


    <style>
        table.dataTable thead .sorting{
            background-image: none !important;
        }
    </style>

    <div class="col-md-12 mb-4 bg-white p-3">
        <table id="contactList" class="table table-sm">
            <thead>
            <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">##Namefamily##</th>
                <th scope="col"> ##Mobile##</th>
                <th scope="col">##Email##</th>
                <th scope="col">##Show##</th>
            </tr>
            </thead>
            <tbody>
            {assign var="number" value="0"}
            {foreach key=key item=item from=$contactList}
                {$number=$number+1}
                <tr class="text-center">
                    <th scope="row">{$number}</th>
                    <td>{$item['name']}</td>
                    <td>{$item['mobile']}</td>
                    <td>{$objFunctions->ConvertToJalaliOfDateGregorian($item.created_at)}</td>
                    <td>
                        <span class="btn btn-info"
                                  data-id="{$item['id']}"
                                  data-target="#contactModal"
                                  onclick="showContactModal($(this))">
                            (<span class="fa fa-info"></span>)
                        </span>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="contactModalLabel">##Shownformation##</span>
                    <button type="button" class="close ml-0 mr-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="contactModalContent" class="modal-body">
                    ***
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">##Close##</button>
                    {*                    <button type="button" class="btn btn-primary">Save changes</button>*}
                </div>
            </div>
        </div>
    </div>


</div>
<link rel="stylesheet" type="text/css" href="assets/css/ldbtn.min.css">
<script type="text/javascript" src="assets/js/customForContactUs.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#contactList').DataTable();
    });

</script>

{else}
    {$objFunctions->redirectOutAgency()}
{/if}