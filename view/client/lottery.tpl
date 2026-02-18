
{load_presentation_object filename="lottery" assign="objLottery"}
{load_presentation_object filename="members" assign="objMembers"}
{assign var="section" value='lottery'}


{if $smarty.const.LOTTERY_ID eq ''}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/lottery/main.tpl" section=$section objLottery=$objLottery}
{else}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/lottery/item.tpl" id=$smarty.const.LOTTERY_ID section=$section objLottery=$objLottery objMembers=$objMembers}
{/if}


