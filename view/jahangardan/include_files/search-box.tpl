{assign var="info_access_client_to_service" value=$info_access_client_to_service}
{$active_tab}
{if !isset($active_tab)}
    {assign var="active_tab" value=null}
{else}

{/if}

<div class="section_slider w-100">
    <div class="container searchs_box">
        {include file="./search-box/tabs-search-box.tpl" active_tab=$active_tab}
        {include file="./search-box/boxs-search.tpl" active_tab=$active_tab}
    </div>
</div>




