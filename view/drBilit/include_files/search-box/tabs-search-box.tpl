<ul class="nav nav-tabs" id="myTab">

    {foreach $info_access_client_to_service as $key=>$client}
        {*        {if $smarty.const.GDS_SWITCH eq 'page'  &&  $client['MainService'] == 'Flight'}*}
        {*            {$active_tab = 'Flight'}*}
        {*        {else}*}
        {*            {$active_tab = $active_tab}*}
        {*        {/if}*}
        {if $smarty.const.GDS_SWITCH eq 'mainPage' && $client['MainService']  ||
        $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'Insurance' && $client['MainService'] eq 'Insurance' ||
        $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'internalFlight' && $client['MainService'] == 'Flight' ||
        $smarty.const.GDS_SWITCH eq 'page' && $client['MainService'] eq $active_tab}

            <li class="nav-item " >
                <a class="nav-link {if ($smarty.const.GDS_SWITCH eq 'mainPage' && $key eq '0' )  ||  ($smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'internalFlight' && $client['MainService'] == 'Flight' ) || ($smarty.const.GDS_SWITCH eq 'page' && $active_tab eq $client['MainService'])}active{/if}"
                   id="{$client['MainService']}-tab"
                   data-toggle="tab"
                   href="#{$client['MainService']}" role="tab" aria-controls="{$client['MainService']}" aria-selected="false">
                       <span>
                            <i class="{$obj_main_page->classTabsSearchBox($client['MainService'])}"></i>
                            <h4>{$client['Title']}</h4>
                        </span>
                </a>

            </li>
        {/if}
    {/foreach}
</ul>
