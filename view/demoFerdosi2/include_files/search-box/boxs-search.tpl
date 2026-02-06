{assign var="obj_main_page" value=$obj_main_page }
                        {foreach $info_access_client_to_service as $key=>$client}
                            {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}
                                {if  $smarty.const.GDS_SWITCH eq 'mainPage'}
                                    {include file="../../../include/searchBox/{$client['MainService']}.tpl"}
                                 {else}
                                    {if $active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService']}
                                        {include file="../../../include/searchBox/{$client['MainService']}.tpl"}
                                    {/if}
                                {/if}
                            {/if}
                        {/foreach}
                        
                        
                        