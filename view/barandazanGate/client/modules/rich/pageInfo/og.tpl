{*{assign var="info_page" value=$obj_main_page->pageInfo}*}
{*{$info_page|var_dump}*}
{*{$smarty.const.REQUEST|var_dump}*}
{*{$smarty.const.MAG_TITLE|var_dump}*}
{*{if ($smarty.const.MAG_TITLE neq '' || $smarty.const.NEWS_TITLE neq '') && ($smarty.const.REQUEST eq 'mag' || $smarty.const.REQUEST eq 'news')}*}
{*{load_presentation_object filename="articles" assign="objArticles"}*}
{*{assign var="article" value=$objArticles->getCategoryArticle($smarty.const.REQUEST,$smarty.const.MAG_TITLE)}*}
{*{/if}*}

{if $smarty.const.MAG_TITLE neq '' && $smarty.const.REQUEST eq 'mag'}
    {load_presentation_object filename="articles" assign="objArticles"}
    {assign var="article" value=$objArticles->getCategoryArticle($smarty.const.REQUEST,$smarty.const.MAG_TITLE)}

{elseif $smarty.const.NEWS_TITLE neq '' && $smarty.const.REQUEST eq 'news'}
    {load_presentation_object filename="articles" assign="objArticles"}
    {assign var="article" value=$objArticles->getCategoryArticle($smarty.const.REQUEST,$smarty.const.NEWS_TITLE)}

{/if}
<meta property="og:locale" content="{$smarty.const.SOFTWARE_LANG}-IR" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="{$smarty.const.TITLE_SITE}"/>
<meta property="og:title" content="{$info_page['title']}" />
<meta property="og:description" content="{$info_page['description']}">
<meta property="og:url" content="https://{$smarty.const.CLIENT_MAIN_DOMAIN}" />
{if $smarty.const.MAG_TITLE neq '' && $smarty.const.REQUEST eq 'mag'}
    <meta property="og:image" content="{$article['image']}"/>
    <meta property="og:image:secure_url" content="{$article['image']}">
{elseif $smarty.const.NEWS_TITLE neq '' && $smarty.const.REQUEST eq 'news'}
    <meta property="og:image" content="{$article['image']}"/>
    <meta property="og:image:secure_url" content="{$article['image']}">
{else}
    <meta property="og:image" content="project_files/images/logo.png"/>
    <meta property="og:image:secure_url" content="project_files/images/logo.png">
{/if}
<meta property="og:image:width" content="200" />
<meta property="og:image:height" content="200" />
<meta property="og:image:type" content="image/jpg">