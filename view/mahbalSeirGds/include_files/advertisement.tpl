{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}

{if !empty($advertises) }
<section class="i_modular_adds advertising advertising-div mt-4">
<div class="Advertising_slider container owl-carousel owl-theme">
 {foreach $advertises as $item}
<div class="__i_modular_nc_item_class_0 item">
    {$item['content']}
</div>
 {/foreach}

</div>
</section>
{/if}