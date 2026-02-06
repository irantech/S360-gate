{assign var="type_data" value=['is_active'=>1 , 'limit' =>10]}
{assign var='banners' value=$obj_main_page->galleryBannerMain($type_data)}

<section class="i_modular_banner_gallery banner">
    <div class="banner-owl __banner_tabs__ ">
        <div class="owl-banner owl-carousel owl-theme ">

            {foreach $banners as $key => $banner}
                <div class="__i_modular_nc_item_class_0 item">
                    <img alt='{$banner["title"]}' class="__image_class__" src='{$banner["pic"]}' />
                </div>
            {/foreach}

        </div>
    </div>
    <div class="section_slider w-100">
        <div class="container searchs_box">
            <div class="paren-bg-search-box">
                <div class="i_modular_searchBox container search_box_div">
                    <ul class="__search_box_tabs__ nav"
                        id="searchBoxTabs">{include file="./search-box/tabs-search-box.tpl"}</ul>
                    <div class="__search_boxes__ tab-content"
                         id="searchBoxContent">{include file="./search-box/boxs-search.tpl"}</div>
                </div>
            </div>
        </div>
    </div>
</section>
