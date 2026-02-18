
{if $smarty.const.GALLERY_ID eq ''}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/gallery/main.tpl"
     objGallery=$objGallery}
{else}
  {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/gallery/item.tpl" }
{/if}


