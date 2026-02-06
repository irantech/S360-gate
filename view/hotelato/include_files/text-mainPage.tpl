{assign var="data_search_public" value=['page_type'=>'attach' , 'location' => 'MainPage']}
{assign var='specialPageData' value=$obj_main_page->getSpecialPageData($data_search_public)}
{if $specialPageData[0] }
<section class='text-mainPage py-5'>
    <div class='container'>
        <div class="__aboutUs_class__ about_p">
            {$specialPageData[0]['content']}
        </div>
    </div>
</section>
{/if}