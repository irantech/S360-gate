{include file="include_files/header.tpl" }

{assign var="data_search_public" value=['page_type'=>'attach','position'=> ['MainPage','internalFlight','internationalFlight']]}
{assign var='specialPageData' value=$obj_main_page->getSpecialPageData($data_search_public)}
<main>
    {include file="include_files/search-box.tpl"}


    {include file="include_files/tours-common.tpl"}
{*    {include file="include_files/tours-norozi.tpl"}*}

    {include file="include_files/blog.tpl"}

    {include file="include_files/news-letter.tpl"}

</main>
{include file="include_files/footer.tpl"}
{include file="include_files/script-footer.tpl"}
