{load_presentation_object filename="personnel" assign="objPersonnel"}

{include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/personnel/main.tpl" objPersonnel=$objPersonnel}
