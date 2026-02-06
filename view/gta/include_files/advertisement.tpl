{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}

{if !empty($advertises) }
<section class="i_modular_adds advertising">
    <div class="container">
        {foreach $advertises as $key => $item}
            {if $key == 0}
                <div class="__i_modular_nc_item_class_0 parent-advertising-img2">
                    {$item['content']}
                </div>
            {/if}
        {/foreach}
        <div class="advertising-parent">
            {foreach $advertises as $key => $item}
                {if $key ==1 || $key ==2 }
                    <div class="__i_modular_nc_item_class_2 parent-advertising-img">
                        {$item['content']}
                    </div>
                {/if}
            {/foreach}
        </div>
    </div>
    </div>
</section>
{/if}