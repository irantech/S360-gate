<ul class="nav" id="searchBoxTabs">
    {foreach $info_access_client_to_service as $key=>$client}
        {if  $smarty.const.GDS_SWITCH eq 'mainPage'}

            {if ($smarty.const.SOFTWARE_LANG eq 'fa') || $client['MainService'] neq 'Train' && $client['MainService'] neq 'Bus' &&
            $client['MainService'] neq 'Europcar' && $client['MainService'] neq 'GashtTransfer' && $client['MainService'] neq 'Package'}
                <li class="nav-item">
                    <a onclick="changeText(`{$obj_main_page->nameBoxSearchBox($client['MainService'])}` , 'null')" class="nav-link
                        {if $client['MainService'] eq 'Flight' }active{/if}"
                         id="{$client['MainService']}-tab" data-toggle="tab" href="#{$client['MainService']}">
                                    <span>
                                        <i class="{$obj_main_page->classTabsSearchBox($client['MainService'])}"></i>
                                        <h4>{$obj_main_page->nameTabsSearchBox($client['MainService'])}</h4>
                                    </span>
                    </a>
                </li>
            {/if}
        {else}
            {if $active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService']}
                <li class="nav-item">
                    <a onclick="changeText(`{$obj_main_page->nameBoxSearchBox($client['MainService'])}` , 'null')" class="nav-link active"
                       id="{$client['MainService']}-tab" data-toggle="tab" href="#{$client['MainService']}">
                                <span>
                                    <i class="{$obj_main_page->classTabsSearchBox($client['MainService'])}"></i>
                                    <h4>{$obj_main_page->nameTabsSearchBox($client['MainService'])}</h4>
                                </span>
                    </a>
                </li>
            {/if}
        {/if}
    {/foreach}
</ul>