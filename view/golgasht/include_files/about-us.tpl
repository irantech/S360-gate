{assign var='specialPageData' value=$obj_main_page->getSpecialPageData($data_search_public)}

{foreach $specialPageData as $specialPage}
 {if $specialPage['position'] eq 'MainPage'}
  {assign var='specialMainPage' value=$specialPage}
 {/if}
{/foreach}
{if $specialMainPage['content']}
 <section class="i_modular_about_us about py-5">
  <div class="container">
   <h2 class="about_title">
    سفری به یادماندنی با بهترین‌ها
   </h2>
   <p class="__aboutUs_class__ about_p">

    {$specialMainPage['content']}
   </p>
  </div>
 </section>
{/if}
