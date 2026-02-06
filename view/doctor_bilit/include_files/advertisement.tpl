

{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}
{*{$advertises|var_dump}*}
{if !empty($advertises) }
    <section class="i_modular_adds discount">
        <div class="container">
            <div class='parent-discount'>
                {foreach $advertises as $item}
                    <div class="__i_modular_nc_item_class_{$item['id']} item item-discount">
                        {$item['content']}
                    </div>
                {/foreach}
            </div>
        </div>
    </section>
{/if}