{assign var='tab_counter' value=0}
{foreach $info_access_client_to_service as $key=>$client}
    {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}
        {if ( $smarty.const.GDS_SWITCH eq 'mainPage' ) || ($active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService'])}
            {foreach $obj_main_page->newClassTabsSearchBox($client['MainService']) as $tab_id => $icon}

                {if $tab_id neq 'Train'}
                <li class="nav-item" >
                    <a onclick="changeText(`{$obj_main_page->nameBoxSearchBox($tab_id)}` , 'null')"
                       class="{$tab_id}-tab-pic nav-link {if $tab_counter eq 0 }active{/if}"
                       id="{$tab_id}-tab" data-toggle="tab" href="#{$tab_id}">

                        <div>
                            {$icon}
                            <h4>{$obj_main_page->nameTabsSearchBox($tab_id)}</h4>
                        </div>

                    </a>
                </li>
                {else}
                    <li class="nav-item" >
                        <a
                           class="{$tab_id}-tab-pic nav-link"
                          href="https://train.mz724.ir/Ticket/Index.aspx?Rea=e3c9a17dc634450388fe19432c646170" target="_blank">

                            <div>
                                {$icon}
                                <h4>{$obj_main_page->nameTabsSearchBox($tab_id)}</h4>
                            </div>

                        </a>
                    </li>
                {/if}
                {$tab_counter = $tab_counter + 1}
            {/foreach}
        {/if}
    {/if}
{/foreach}

