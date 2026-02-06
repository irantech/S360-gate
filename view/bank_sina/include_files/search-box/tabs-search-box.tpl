{assign var="info_access_client_to_service" value=$info_access_client_to_service}
{load_presentation_object filename="specialPages" assign="objSpecialPages"}
{foreach $info_access_client_to_service as $key=>$client}
    {if  $smarty.const.GDS_SWITCH eq 'mainPage' && $client['MainService'] eq 'Flight'}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="flight-tab" data-toggle="tab" href="#flight"
                           role="tab" aria-controls="flight" aria-selected="true">
                                        <span>
                                <i class="fal fa-plane-alt"></i>
                                <h4>پرواز</h4>
                            </span>
                        </a>
                    </li>
                </ul>
    {else}
        {if $active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight' || $active_tab eq $client['MainService']}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="flight-tab" data-toggle="tab" href="#flight"
                           role="tab" aria-controls="flight" aria-selected="true">
                                        <span>
                                <i class="fal fa-plane-alt"></i>
                                <h4>##Hotel##</h4>
                            </span>
                        </a>
                    </li>
                </ul>
        {/if}
    {/if}
{/foreach}
