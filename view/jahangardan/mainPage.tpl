{include file="include_files/header.tpl" }

{assign var="data_search_public" value=['page_type'=>'attach','position'=> ['MainPage','internalFlight','internationalFlight']]}
{assign var='specialPageData' value=$obj_main_page->getSpecialPageData($data_search_public)}

{foreach $specialPageData as $specialPage}
    {if $specialPage['position'] eq 'internalFlight'}
        {assign var='specialInternalFlight' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'internationalFlight'}
        {assign var='specialInternationalFlight' value=$specialPage}
    {/if}
    {if $specialPage['position'] eq 'MainPage'}
        {assign var='specialMainPage' value=$specialPage}
    {/if}
{/foreach}

<main>
    <section class="banner">

        {include file="include_files/banner-slider.tpl" }

        <!--   start search box-->
        {include file="include_files/search-box.tpl"}
        <!--   end search box-->
    </section>

    <!--   start best -->
    {include file="include_files/best.tpl" }
    <!--   end best -->

    <!--   start fast search flight -->
    {include file="include_files/fast-search-flight.tpl"}
    <!--   end fast search flight -->

    <!--   start articles -->
    {include file="include_files/articles.tpl"}
    <!--   end articles -->


    <!--   start about -->
{*    {include file="include_files/about.tpl"}*}
    <!--   end about -->

    <!--   start weather letter -->
{*    {include file="include_files/weather.tpl"}*}
    <!--   end weather letter -->

    <!--   start news letter -->
    {include file="include_files/news_letter.tpl"}
    <!--   end news letter -->

</main>

{include file="include_files/footer.tpl"}

</body>
{include file="include_files/script-footer.tpl"}