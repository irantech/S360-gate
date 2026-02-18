{load_presentation_object filename="articles" assign="objArticles"}

{assign var='articles' value=$objArticles->getByPosition($moduleData)}

{if !empty($articles)}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/mag/sliderBlog.tpl" articles=$articles title='مقالات ویژه'}
{/if}
