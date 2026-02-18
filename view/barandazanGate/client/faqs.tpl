{load_presentation_object filename="faqs" assign="object" }


{assign var='faqs' value=$object->getByPosition($moduleData)}
{if  $faqs neq ''}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/rich/faq/faqs.tpl"
    faqs=$faqs}
{/if}
