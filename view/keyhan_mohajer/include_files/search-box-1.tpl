{assign var="type_data" value=['is_active'=>1 , 'limit' =>10]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}
{if $page.files.main_file}
    {$banners = [0 => ['pic' => $page.files.main_file.src , 'title' => 'page']]}
{/if}
<style>
    .banner-slider-display {
        display: none !important;
    }
</style>

<section class="i_modular_banner_gallery slider">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12 d-flex align-items-center">
                <div class="search_box">
                    <div class="search_box_texts">
                        <h2>موتور جستجو و مقایسه ویزا</h2>
                        <h3>راهنمای کامل برای دریافت ویزا</h3>
                    </div>
                    {include file="./search-box/boxs-search.tpl"}
                </div>
            </div>
            <div class="col-lg-6 col-12 img_search_box d-none d-lg-block">
                <div class="banner-owl">
                    <div class="owl-banner owl-carousel owl-theme">

                        {foreach $banners as $key => $banner}
                            <div class="__i_modular_nc_item_class_0 item">
                                <img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}'/>
                            </div>
                        {/foreach}



                    </div>
                </div>
                <!--                    <img src="project_files/images/top-view.png" alt="موتور جستجو و مقایسه ویزا">-->
            </div>
        </div>
    </div>
</section>
