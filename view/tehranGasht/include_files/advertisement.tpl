{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}
{if !empty($advertises) }
<section class="i_modular_adds advertising">
    <div class="container">
        <div class="ads-parent">
            <div class="owl-carousel owl-theme owl-loaded owl-ads1">
                {foreach $advertises as $key => $item}
                {if $key%2 ==  0}
                <div class="__i_modular_nc_item_class_0 item ads1">
                    {$item['content']}
                </div>
                {/if}
                {/foreach}
            </div>
            <div class="owl-carousel owl-theme owl-loaded owl-ads2">
                {foreach $advertises as $key => $item}
                    {if $key%2 ==  1}
                        <div class="__i_modular_nc_item_class_0 item ads1">
                            {$item['content']}
                        </div>
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>
</section>
{/if}