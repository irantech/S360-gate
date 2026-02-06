
{*
<div class="OWL_slider_banner owl-carousel owl-theme">
    <div class="item"><img src="project_files/images/images/s2.jpg" alt="s2"></div>
    <div class="item"><img src="project_files/images/images/s1.jpg" alt="s1"></div>
    <div class="item"><img src="project_files/images/images/s4.jpg" alt="s4"></div>
    <div class="item"><img src="project_files/images/images/s5.jpg" alt="s5"></div>
</div>
*}

{assign var="type_data" value=['is_active'=>1 , 'limit' =>5]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}
<div class="OWL_slider_banner owl-carousel owl-theme">
    {foreach $banners as $key => $banner}
        {if $banner['type']=='pic'}
        <div class="item">
            <img src="{$banner['pic']}" alt="{$banner['title']}">
            <div class="section_slider w-100" style="z-index: 1000; position: relative;">
                <div class="container searchs_box">
                    <div class="text_searchBox">
                        <h1>{$banner['title']}</h1>
                    </div>
                </div>
            </div>
        </div>
        {else}
    <div class="item">
            <video src="{$banner['pic']}"
                   width="100%"
                   height="100%"
                   type="video/mp4"
                   autoplay="autoplay"
                   loop
                   muted
                   style="object-fit: cover;">
            </video>
            <div class="section_slider w-100" style="z-index: 1000; position: relative;">
                <div class="container searchs_box">
                    <div class="text_searchBox">
                        <h1>{$banner['description']}</h1>
                    </div>
                </div>
            </div>
    </div>
        {/if}
    {/foreach}
</div>