<ul class="nav nav-tabs" id="myTab" role="tablist">
    {foreach $info_access_client_to_service as $key=>$client}
        {if  $smarty.const.GDS_SWITCH eq 'mainPage' && $obj_main_page->classTabsSearchBox($client['MainService'])}
            <li class="nav-item">
                <a onclick="changeText(`{$obj_main_page->nameBoxSearchBox($client['MainService'])}` , 'null')" class="nav-link
                    {if $client['MainService'] eq 'Flight' }active{/if}"
                     id="{$client['MainService']}-tab" data-toggle="tab" href="#{$client['MainService']}">
                                <span>
                                    {$obj_main_page->classTabsSearchBox($client['MainService'])}
                                    <h4>{$obj_main_page->nameTabsSearchBox($client['MainService'])}</h4>
                                </span>
                </a>
            </li>
        {else}
            {if $active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService']}
                <li class="nav-item">
                    <a onclick="changeText(`{$obj_main_page->nameBoxSearchBox($client['MainService'])}` , 'null')" class="nav-link active"
                       id="{$client['MainService']}-tab" data-toggle="tab" href="#{$client['MainService']}">
                                <span>
                                    {$obj_main_page->classTabsSearchBox($client['MainService'])}
                                    <h4>{$obj_main_page->nameTabsSearchBox($client['MainService'])}</h4>
                                </span>
                    </a>
                </li>
            {/if}
        {/if}
    {/foreach}
</ul>

