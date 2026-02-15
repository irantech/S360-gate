{assign var="service_type" value=$smarty.get.type_service}
{*"appBank/{$service_type}.tpl"*}
{include file="./appBank/{$service_type}.tpl"}