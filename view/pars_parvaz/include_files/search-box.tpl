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

{assign var="info_access_client_to_service" value=$info_access_client_to_service}
{load_presentation_object filename="specialPages" assign="objSpecialPages"}

<div class="i_modular_banner_gallery __banner_tabs__ banner">
    <div class="i_modular_searchBox search_box container">
        <h2 id="titr_searchBox">رزرو <em>بلیط</em> <span id="text_search">هواپیمای داخلی </span></h2>
        <ul class="__search_box_tabs__ nav nav-tabs" id="myTab" role="tablist">{include file="./search-box/tabs-search-box.tpl"}</ul>
        <div class="__search_boxes__ tab-content" id="myTabContent">{include file="./search-box/boxs-search.tpl"}</div>
    </div>
    <div class="WaveStyle WaweBot">
        <svg viewbox="0 0 2000 128">
            <use xlink:href="#waveStyle">
                <symbol id="waveStyle">
                    <path d="M1999.5,22.2c-346-0.6-524.6-4.7-878.8,4.4c-286.6,7.4-442.3,54-608.1,51.2C307.3,74.3,202.5,5-0.5,28.1v100.4l2000-0.5V22.2z" opacity="0.2"></path>
                    <path d="M-0.3,46.1C251,15.3,440.9,84.7,499.6,98.4c54.7,12.8,122.5,12,186.7-5.3c154.2-41.6,315.5-70.9,475.2-67.5s324.6,22.4,484.3,19.7c133-2.3,302.8,1.7,352.8,3.7c0,21.3,0,80,0,80H-0.5L-0.3,46.1z" opacity="0.2"></path>
                    <path d="M2000,41.2c-139.8-12.7-219.9-10.8-360.2-11.2c-285.5-0.8-487.5,18-736.2,51.1C647,115.4,546.7,116.4,199.2,53.6C140.3,43,59.5,45.6-0.5,52.3V130h2000L2000,41.2z" opacity="0.4"></path>
                    <path d="M1634.6,50.1c-193.8,11.9-366.9,24.9-569,50c-110.2,13.7-221.2,21.5-332.3,19.6c-187-3.3-344.5-29.7-560.9-69.8c-122.2-22.6-172.8-4-172.8-4V130h1998V46C1997.5,46,1831,38.1,1634.6,50.1z"></path>
                </symbol>
            </use>
        </svg>
    </div>
</div>
{include file="include_files/banner-slider.tpl" }
