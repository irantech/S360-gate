{assign var="info_page" value=$obj_main_page->pageInfo}
{if $objFunctions->checkNoIndex()}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/robots/noIndex.tpl"}
{else}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/canonical/main.tpl" obj_main_page=$obj_main_page}
{/if}
{if  $info_page}
    <title>{$info_page['title']}</title>
    {if isset($info_page['all_meta_tags']) && $info_page['all_meta_tags']}
        {assign var="meta_tags" value=$info_page['all_meta_tags']}
        {foreach $meta_tags as $key=>$tag}
            {if $tag['name'] neq ''}
                <meta name="{$tag['name']}" content="{$tag['content']}">
            {/if}
        {/foreach}
    {/if}
{/if}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/pageInfo/og.tpl" obj_main_page=$obj_main_page}
