<ul class="nav nav-tabs" id="myTabSearchBox" role="tablist">
    {foreach $info_access_client_to_service as $key=>$client}
            {if $client['MainService'] neq 'Flight'}
                {if $active_tab}
                    {if $client['MainService'] eq $active_tab}
                        <li class="nav-item">
                            <a class="nav-link {if $key eq '0'}active{/if}"
                               href="#{$client['MainService']}"
                               id="{$client['MainService']}-tab"
                               data-toggle="tab"
                               role="tab"
                               aria-controls="{$client['MainService']}"
                               aria-selected="true">
                                <span>
                                    <i class="{$obj_main_page->classTabsSearchBox($client['MainService'])}">&#xe800;</i>
                                    <h4> {$client['Title']} </h4>
                                </span>
                            </a>
                        </li>
                    {/if}
                {else}
                    <li class="nav-item">
                        <a class="nav-link {if  $key eq '0'} active{/if}"
                           href="#{$client['MainService']}"
                           id="{$client['MainService']}-tab"
                           data-toggle="tab"
                           role="tab"
                           aria-controls="{$client['MainService']}"
                           aria-selected="false">
                           <span>
                                <i class="{$obj_main_page->classTabsSearchBox($client['MainService'])}">{$obj_main_page->iconTabsSearchBox($client['MainService'])}</i>

                                <h4>{$client['Title']}</h4>
                           </span>
                        </a>
                    </li>
                {/if}
        {/if}
    {/foreach}
</ul>