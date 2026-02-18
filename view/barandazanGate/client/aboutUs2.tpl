{load_presentation_object filename="aboutUs" assign="objAbout"}
{load_presentation_object filename="specialPages" assign="objSpecialPages"}
{assign var="aboutUsData" value=$objAbout->GetData($smarty.const.SOFTWARE_LANG)}
{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/aboutUs-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/aboutUs2.css'>
{/if}
<div class='main_img_about_parent'>
    <div class='main_img_about'>
        {if $aboutUsData['banner_file'] eq ''}
            <img class='main_img_about' src="assets/images/aboutUsImg1.jpg" alt="">
        {else}
            <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/aboutUs/{$aboutUsData['banner_file']}" alt="{$aboutUsData['title']}">
        {/if}
        <div class='container'>
            <h2>##AboutUs##</h2>
            <p>{$aboutUsData['title']}</p>
        </div>
    </div>
    <div class='container'>
        <div class="about_page p-0">
            {*        <div class='header_top'>*}
            {*            <h3 class="site-main-text-color">##AboutUs##</h3>*}
            {*        </div>*}
            <div class='about_text' id='about_text'>
                <div class='about_text_header'>
                    {*                <i class='fa fa-users'></i>*}
                    {*                {if $aboutUsData['title']}*}
                    {*                <h2>{$aboutUsData['title']}</h2>*}
                    {*                {else}*}
                    {*                <h2>##AboutUs##</h2>*}
                    {*                {/if}*}
                    <h2>##LearnMoreAboutUs##</h2>
                </div>
                {$aboutUsData['body']}

                <div class='services-about'>
                    <p class='title-services-about'>
                        ##ServicesWeProvide## :
                    </p>
                    <div class='parent-services-about'>

                        {assign var="main_special_pages" value=$objSpecialPages->listPageForSite()}
                        {foreach $main_special_pages as $page}
                        <div class='bg-service-about'>
                            <a class='service-about' href='{$smarty.const.ROOT_ADDRESS}/page/{$page['slug']}'>
                                <div class='txt-service-about'>
                                    <h4>{$page['title']}</h4>
                                    {$page['content']}
                                    <div>
                                    <span>
                                        <i class="fa-solid fa-angle-left"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class='img-service-about'>
                                    <img src="{$page.files.main_file.src}" alt="{$page['title']}">
                                </div>
                                <span class='circle-service1'></span>
                                <span class='circle-service2'></span>
                            </a>
                        </div>
                        {/foreach}




                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<script src='assets/modules/js/aboutUs.js'>
