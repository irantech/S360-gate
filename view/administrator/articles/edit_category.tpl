

<div {if $key == 0 } data-name='categories' {else} data-name='added-categories' {/if} class="d-flex flex-wrap w-100 form-group form-new w-100">
    <input type='text'
           data-name='categories{$category['id']}'
            {if $key == 0 } oninput='searchCategory($(this),"{$category['parent_id']}")' {else} oninput='searchCategory($(this))' {/if}
           autocomplete='off'
           value='{$category['title']}'
           name='categories[]' class='form-control w-100'>

<!--    <button type="button"
               onclick="removeCategories($(this),'{$category.id}')"
               class="btn {if $key == 0} btn-default {else} btn-danger {/if} p-1 font-12 gap-2 rounded">
        <span class="fa fa-trash"></span>
        حذف
    </button>-->
    <div data-name='result-box'
         class='select-categories w-100 align-items-center border d-none flex-wrap justify-content-center p-2 rounded'>
    </div>
</div>


{if isset($category['parent']) && $category['parent'] != ''}
    <div class='p-2 w-100 d-flex flex-wrap flex-column-reverse'>
        {include file="{$smarty.const.FRONT_CURRENT_ADMIN}/articles/edit_category.tpl" key=1 category=$category['parent']}
    </div>
{/if}