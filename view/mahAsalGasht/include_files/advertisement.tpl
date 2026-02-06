{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}

{if !empty($advertises) }
    <section class="i_modular_adds advertising">
        <div class="container">
            <div class="owl-carousel owl-theme owl-tablighat">
                {foreach $advertises as $item}
                    <div class="__i_modular_nc_item_class_{$item['id']} item">
                        {$item['content']}
                    </div>
                {/foreach}


            </div>
        </div>
    </section>
{/if}