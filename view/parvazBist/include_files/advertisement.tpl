
{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}


<section class="i_modular_adds advertising py-5">
<div class="container">
{if !empty($advertises) }
    {$advertises[0]['content']}
{/if}
</div>
</section>
