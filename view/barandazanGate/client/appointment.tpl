{load_presentation_object filename="appointments" assign="objAppointments"}

{include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/appointment/main.tpl" objRecommendation=$objAppointments}