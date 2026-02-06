{assign var="data_main_comment" value=['is_active'=>'1','limit'=> 10]}
{assign var='comments' value=$obj_main_page->commentMainPage($data_main_comment)}

{if $comments|count > 0}
<section class="Comments">
 <div class="newsletterMain">
  <div class="container">
   <div>
    <div class="parent-Comments">
     <h2>نظرات</h2>
     <div class="owl-carousel owl-theme owl-Comments">
      {foreach $comments as $key => $item}
      <div class="item-Comments">
       <i class="fa-solid fa-quote-left"></i>
       <p>
        {$item['text']}
       </p>
      </div>
      {/foreach}

     </div>
    </div>
   </div>
  </div>
 </div>
</section>
{/if}