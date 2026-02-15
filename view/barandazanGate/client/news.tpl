{load_presentation_object filename="articles" assign="objArticles"}
{load_presentation_object filename="members" assign="objMembers"}
{assign var="section" value='news'}


{if $smarty.const.NEWS_TITLE eq ''}
    {*    main page*}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/news/main.tpl" section=$section objArticles=$objArticles}
{else}
    {if $smarty.const.NEWS_CATEGORY neq ''}
        {*    category page*}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/mag/categoryArticles.tpl" section=$section objArticles=$objArticles}
    {else}
        {*    item page*}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/mag/item.tpl" title=$smarty.const.NEWS_TITLE section=$section objArticles=$objArticles objMembers=$objMembers}
    {/if}
{/if}


