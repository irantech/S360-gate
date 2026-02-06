{load_presentation_object filename="visa" assign="objVisa"}

{include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/immigration/main.tpl" visa_id=$smarty.const.IMMIGRATION_ID country_code=$smarty.const.IMMIGRATION_COUNTRY objVisa=$objVisa}


