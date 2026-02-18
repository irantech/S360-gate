{$category['title']}


{if isset($category['parent']) && $category['parent'] != ''}

    <div class='pr-3'>
        {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/articles/show_category.tpl" key=1 category=$category['parent']}
    </div>

{/if}