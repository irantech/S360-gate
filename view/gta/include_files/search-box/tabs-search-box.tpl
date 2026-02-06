
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
                        {if $smarty.const.GDS_SWITCH eq 'mainPage' }
                        <li class="nav-item">
                            <a  class=" nav-link " href="https://voffice.khatamtour.com/v_office/log_in/?page=vSYaBH50bSVhZnVpO2VjzDZnb192O21eBy5ydD90bDU0BDhiOnVjzDZnb3BeOakaxSR0zA2" target='_blank'>
                                <div>
                                    <img style="width: 36px!important; height: 36px!important;position: static !important;display: block !important;" src="project_files/images/svttttt.png" alt="img">
                                    <h4>تور بازنشستگی</h4>
                                </div>
                            </a>
                        </li>
                            <li class="nav-item">
                                <a  class=" nav-link " href="https://gta.ir/gds/fa/authenticate" target='_blank'>
                                    <div>
                                        <img style="width: 36px!important; height: 36px!important;position: static !important;display: block !important;" src="project_files/images/47747447.png" alt="img">
                                        <h4>پرشین کارت</h4>
                                    </div>
                                </a>
                            </li>
                        {/if}
        