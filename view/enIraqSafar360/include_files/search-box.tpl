<section class="banner-demo">
    <div class="dot-overlay"></div>
    <div class="container">
        <div class="parent-banner-demo">
            <div class="text-banner-demo">
                <h2>Discover new destinations!</h2>
                <h2>Unforgettable and memorable experiences</h2>
            </div>
            <div class="search_box">
                <div class="i_modular_searchBox search_box_div">
                    <ul class="__search_box_tabs__ nav" id="searchBoxTabs">
                        {include file="./search-box/tabs-search-box.tpl"}
                    </ul>
                    <div class="__search_boxes__ tab-content" id="searchBoxContent">
                        {include file="./search-box/boxs-search.tpl"}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{include file="include_files/banner-slider.tpl"}

<style>
    .banner-slider-display {
        display: none;
    }
</style>