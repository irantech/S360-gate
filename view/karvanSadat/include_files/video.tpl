{assign var="type_data" value=['is_active'=>1 , 'limit' =>1]}
{assign var='list_video' value=$obj_main_page->getVideo($type_data)}
{if $list_video[0]['iframe_code']}
<section class="video">
 <div class="video-parent">
  <div class="container">
   <div>
    <h2> کاروان سادات ؛ تجربه زیارتی متفاوت</h2>
    {*
    <video class="iframe-parent" controls="" poster="project_files/images/poster-video.png">
     <source src="project_files/images/karbala.mp4" type="video/mp4" />
    </video>
 *}
{*    {$list_video[0]['iframe_code']}*}

    <iframe src="{$list_video[0]['iframe_code']}"  width='100%' height='800'></iframe>
   </div>
  </div>
 </div>
</section>
{/if}
