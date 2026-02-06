
                        {assign var='tab_counter' value=0}
                        {foreach $info_access_client_to_service as $key=>$client}
                            {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}
                                {if ( $smarty.const.GDS_SWITCH eq 'mainPage' ) || ($active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService'])}
                                    {foreach $obj_main_page->newClassTabsSearchBox($client['MainService']) as $tab_id => $icon}
                                        <li class="nav-item  {$active_tab} sheet-js">
                                            <a data-name="{$client['MainService']}"
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
                        <li class="nav-item">
                            <a class="nav-link link-tab-mobile" href="{$smarty.const.ROOT_ADDRESS}/UserTracking" target="_blank" rel="noopener noreferrer">
                                <div>
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><defs><style>.fa-secondary</style></defs><path class="fa-primary" d="M0 24C0 10.7 10.7 0 24 0H69.5c26.9 0 50 19.1 55 45.5l51.6 271c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/><path class="fa-secondary" d="M170.7 288H459.2c32.6 0 61.1-21.8 69.5-53.3l41-152.3C576.6 57 557.4 32 531.1 32h-411c2 4.2 3.5 8.8 4.4 13.5L170.7 288z"/></svg>
                                    </i>
                                    <h4>پیگیری خرید</h4>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-tab-mobile"  href="{$smarty.const.ROOT_ADDRESS}/club" target="_blank" rel="noopener noreferrer">
                                <div>
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><defs><style>.fa-secondary</style></defs><path class="fa-primary" d="M280.1 44.45C296.3 16.91 325.9 0 357.8 0H360C408.6 0 448 39.4 448 88C448 136.6 408.6 176 360 176H288V256H224V176H152C103.4 176 64 136.6 64 88C64 39.4 103.4 0 152 0H154.2C186.1 0 215.7 16.91 231.9 44.45L256 85.46L280.1 44.45zM190.5 68.78C182.9 55.91 169.1 48 154.2 48H152C129.9 48 112 65.91 112 88C112 110.1 129.9 128 152 128H225.3L190.5 68.78zM286.7 128H360C382.1 128 400 110.1 400 88C400 65.91 382.1 48 360 48H357.8C342.9 48 329.1 55.91 321.5 68.78L286.7 128zM224 512V288H288V512H224z"/><path class="fa-secondary" d="M152 176H224V256H32C14.33 256 0 241.7 0 224V160C0 142.3 14.33 128 32 128H73.6C88.16 156.5 117.8 176 152 176zM480 256H288V176H360C394.2 176 423.8 156.5 438.4 128H480C497.7 128 512 142.3 512 160V224C512 241.7 497.7 256 480 256zM32 288H224V512H80C53.49 512 32 490.5 32 464V288zM288 512V288H480V464C480 490.5 458.5 512 432 512H288z"/></svg>
                                    </i>
                                    <h4>باشگاه مشتریان</h4>
                                </div>
                            </a>
                        </li>
