<div class="last-p-popup last-p-popup-change">

    <div class="main-Content-bottom Dash-ContentL-B">
        <div class="main-Content-bottom-table Dash-ContentL-B-Table">
            <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                <i class="icon-table"></i>
                <h3>##FormertravelersUser##</h3>
                <span class="s-u-close-last-p" onclick="setHidenCloseLastP()"></span>
            </div>

            <div class="content-table">
                <table id="passengers" class="display" cellspacing="0" width="100%">

                    <thead>
                    <tr>
                        <th>##Sex##</th>
                        <th>##Name## </th>
                        <th>##Family## </th>
                        <th>##Happybirthday##</th>
                        <th>##Nationalnumber##/##Numpassport##</th>
                        <th>##Selection##</th>
                    </tr>
                    </thead>

                    <tbody>
                    <!-- {assign var="number" value="1"} -->
                    <!-- {assign var="selectPassengerLocal" value="this"} -->
                        {if $smarty.const.GDS_SWITCH == 'passengersDetailInsurance'}
                            {assign var="selectPassengerLocal" value="'insurance'"}
                        {/if}
                        {foreach key=key item=item from=$objDetail->passengers}
                        <tr>


                            {assign var="type" value="0"}
                            {if $item['birthday'] eq '0000-00-00'}
                                {$type = $objDetail->type_user($objFunctions->ConvertToMiladi($item['birthday_fa']))}
                            {else}
                                {$type = $objDetail->type_user($item['birthday'])}
                            {/if}

                            <td data-content="##Sex##">{if $item['gender'] eq 'Male'}
                                    {if $type eq 'Adt'}
                                        ##Sir##
                                    {elseif $type eq 'Chd'}
                                        ##Boy##
                                    {elseif $type eq 'Inf'}
                                        ##Baby##
                                    {/if}
                                {elseif $item['gender'] eq 'Female'}
                                    {if $type eq 'Adt'}
                                        ##Lady##
                                    {elseif $type eq 'Chd'}
                                        ##Girl##
                                    {elseif $type eq 'Inf'}
                                        ##Baby##
                                    {/if}
                                {/if}
                            </td>


                                <td data-content="##Name##">{$item['name_en']}</td>
                                <td data-content="##Family##">{$item['family_en']}</td>
                         

                            <td data-content="##Happybirthday##">
                                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                                        {$item['birthday_fa']}
                                {else}
                                    {if $item['birthday'] eq '0000-00-00'}
                                        {$item['birthday_fa']}
                                    {else}
                                        {$item['birthday']}
                                    {/if}
                                {/if}
                            </td>
                            <td data-content="##Nationalnumber##">{if $item['NationalCode']!=""}{$item['NationalCode']} {else}{$item['passportNumber']} {/if}</td>
                            <td data-content="##Selection##">
                                <button type='button'
                                        title='##ChoseOption##'
                                        onclick="selectPassengerLocal('{$item['id']}', {$selectPassengerLocal},$(this))"
                                        class='btn site-bg-main-color s-u-last-p-select'>
                                    <i class=" fa fa-check"></i>
                                </button>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>


                </table>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function (){
        $('#passengers').DataTable( {
            responsive: true
        } );
    })
</script>