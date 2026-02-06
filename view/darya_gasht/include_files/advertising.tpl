{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}
{if !empty($advertises) }
<section class="ads container py-5 my-5">
    <div class="parent-ads">
        {foreach $advertises as $item}
            <a class='items-ads' href="javascript:">
                <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$item['image']}" alt="{$item['title']}">
            </a>
        {/foreach}
    </div>
</section>
{/if}