{include file="include_files/header.tpl" }<!-- donwn -->

{assign var="data_search_public" value=['page_type'=>'attach',
'position'=> ['MainPage','internalFlight', 'Bus', 'Insurance']]}
{assign var='specialPageData' value=$obj_main_page->getSpecialPageData($data_search_public)}


<main>
    {include file="include_files/banner-slider.tpl"}

</main>

</body>
{include file="include_files/script-footer.tpl"}<!-- donwn -->
