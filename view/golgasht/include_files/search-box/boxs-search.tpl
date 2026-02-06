{assign var="obj_main_page" value=$obj_main_page }
{foreach $info_access_client_to_service as $key=>$client}
    {if $obj_main_page->newClassTabsSearchBox($client['MainService'])}
        {if  $smarty.const.GDS_SWITCH eq 'mainPage'}
            {include file="./boxes/{$client['MainService']}.tpl" client=$client}
         {else}
            {if $active_tab eq 'internalFlight' && $client['MainService'] eq 'Flight'
            || $active_tab eq $client['MainService']}
                {include file="./boxes/{$client['MainService']}.tpl" client=$client active=true}
            {/if}
        {/if}
    {/if}
{/foreach}

{include file="include_files/banner-slider.tpl"}

{*    {literal}*}
{*        <script>*}
{*    if($(window).width() > 576){*}
{*      $('#Flight-tab').click(function (){*}
{*        $('.banner-demo').css('background-image', 'url("project_files/images/flight-bg-js.jpg")');*}
{*      });*}
{*      $('#Hotel-tab').click(function (){*}
{*        $('.banner-demo').css('background-image', 'url("project_files/images/hotel-bg-js.jpg")');*}
{*      });*}
{*      $('#Bus-tab').click(function (){*}
{*        $('.banner-demo').css('background-image', 'url("project_files/images/bus-bg-js.jpg")');*}
{*      });*}
{*      $('#Insurance-tab').click(function (){*}
{*        $('.banner-demo').css('background-image', 'url("project_files/images/bimeh-bg-js.jpg")');*}
{*      });*}
{*      $('#Tour-tab').click(function (){*}
{*        $('.banner-demo').css('background-image', 'url("project_files/images/tour-bg-js.jpg")');*}
{*      });*}
{*      $('#Entertainment-tab').click(function (){*}
{*        $('.banner-demo').css('background-image', 'url("project_files/images/tafrihat-bg-js.jpg")');*}
{*      });*}
{*      $('#Visa-tab').click(function (){*}
{*        $('.banner-demo').css('background-image', 'url("project_files/images/visa-bg-js.jpg")');*}
{*      });*}
{*    }*}
{*</script>*}
{*{/literal}*}



                        