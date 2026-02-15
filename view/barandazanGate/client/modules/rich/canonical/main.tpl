{load_presentation_object filename="canonical" assign="objCanonical"}
{assign var="obj_main_page" value=$objCanonical->get()}
<link rel="canonical" href="{$obj_main_page}">