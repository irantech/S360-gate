{load_presentation_object filename="dateTimeSetting" assign="objDate"}
{load_presentation_object filename="general" assign="objGeneral"}
{load_presentation_object filename="Session" assign="objSession"}

<div class="black-container" ></div>

<input type="hidden" value="{$smarty.const.ROOT_ADDRESS}">
{include file="`$smarty.const.FRONT_CURRENT_CLIENT``$obj->page`"}