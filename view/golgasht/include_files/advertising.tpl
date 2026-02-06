{load_presentation_object filename="functions" assign="objFunctions"}
{assign var="advertises" value=$objFunctions->getConfigContentByTitle('home_page_advertise')}

    {if !empty($advertises) }
<section class="advertising py-5">
    <div class="container">
        {$advertises[0]['content']}
    </div>
</section>
{/if}
