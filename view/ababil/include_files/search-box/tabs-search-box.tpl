<ul class="nav nav-tabs" id="myTab">
    {foreach $info_access_client_to_service as $key=>$client}
        {if $client['MainService'] != 'Flight' and $client['MainService'] != 'Hotel' and $client['MainService']}
        <li class="nav-item">
            <a class="nav-link {if $key eq '0'}active{/if}"
               id="{$client['MainService']}-tab" data-toggle="tab" href="#{$client['MainService']}Tab"
               role="tab"
               aria-controls="{$client['MainService']}"
               aria-selected="false">
                            <span>
                                <h4>{$client['Title']}</h4>
                            </span>
            </a>
        </li>
        {/if}
    {/foreach}
</ul>