{if  $smarty.session.layout neq 'pwa' }
    {if $smarty.const.SOFTWARE_LANG eq 'en'}
        {include file="../HeaderEn.tpl" mainPage=$main_page info_page=$info_page obj_main_page=$obj_main_page}
    {elseif $smarty.const.SOFTWARE_LANG eq 'ar'}
        {include file="../HeaderAr.tpl" mainPage=$main_page info_page=$info_page  obj_main_page=$obj_main_page}
    {else}
        {include file="../HeaderFa.tpl" mainPage=$main_page info_page=$info_page  obj_main_page=$obj_main_page}
    {/if}
{/if}