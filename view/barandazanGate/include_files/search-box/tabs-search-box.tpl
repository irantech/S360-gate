{assign var='tab_counter' value=0}
{foreach $info_access_client_to_service as $key=>$client}
    {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}
        {if ( $smarty.const.GDS_SWITCH eq 'mainPage' ) || ($active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService'])}
            {foreach $obj_main_page->newClassTabsSearchBox($client['MainService']) as $tab_id => $icon}
                <li class="nav-item">
                    <a onclick="changeText(`{$obj_main_page->nameBoxSearchBox($tab_id)}` , 'null')"
                       class="{$client['MainService']}-tab-pic nav-link {if $tab_counter eq 0 }active{/if}"
                       id="{$tab_id}-tab" data-toggle="tab" href="#{$tab_id}">

                        <div>
                            {$icon}
                            <h4>{$obj_main_page->nameTabsSearchBox($tab_id)}</h4>
                        </div>

                    </a>
                </li>
                {$tab_counter = $tab_counter + 1}
            {/foreach}
        {/if}
    {/if}
{/foreach}

        