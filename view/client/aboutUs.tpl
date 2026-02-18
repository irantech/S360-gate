{load_presentation_object filename="aboutUs" assign="objAbout"}

{assign var="aboutUsData" value=$objAbout->GetData()}
<style>
    .header_top {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #ddd;
    }
    .about_text{
        margin-bottom: 1rem;
        text-align:justify;
        text-align-last:right;
        font-size:15px
    }
    .main_img_about{
        width: 100%;
        height:400px;
        position:relative;
        z-index: 2;
        display:flex;
        flex-direction:column;
        align-items: flex-end;
        justify-content:flex-end;
    }
    .main_img_about::after {
        content: "";
        background: linear-gradient(transparent,#000a);
        height: 100%;
        width: 100%;
        position: absolute;
        z-index: -1;
    }
    .main_img_about > img{
        position:absolute;
        z-index: -1;
        width: 100%;
        height:100%;
        object-fit: cover;
    }
    .main_img_about > div > h2{
        font-size: 1.728em;
        color: #fff;
        margin-bottom: 1rem;
    }
    .main_img_about > div > p{
        font-size: 1.286em;
        color: #fff;
        margin-bottom: 2rem;
    }
    .about_text{
        margin: 3em auto !important;
        background-color: #fff !important;
        padding: 0 30px 15px !important;
        border-radius: 3px !important;
        box-shadow: 0 -1px 1px 0 rgb(0 0 0 / 5%), 0 1px 5px 0 rgb(0 0 0 / 15%) !important;
    }
    .about_text_header{
        margin: 0 -30px 1em;
        border-bottom: 1px solid #e1e1e1;
        height: 50px;
        display: flex;
        align-items: center;
        padding: 0 30px;
    }
    .about_text_header > i{
        margin-left: 10px;
        color: #585858;
        font-size: 1.5em;
    }
    .about_text_header > h2{
        font-size: 1.2em;
        margin-bottom:0;
    }
    li {
        list-style: disc !important;
    }
    ul {
         margin-bottom: 0 !important;
         padding-right: 0 !important;
    }
</style>
<script>
  $(".content_tech > .container").removeClass("container")
  $(".content_tech").addClass("p-0")

</script>


<div class='main_img_about'>
    {if $aboutUsData['banner_file'] eq ''}
        <img class='main_img_about' src="assets/images/about_img.jpg" alt="">
    {else}
        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/aboutUs/{$aboutUsData['banner_file']}" alt="{$aboutUsData['title']}">
    {/if}
    <div class='container'>
        <h2>{$aboutUsData['title']}</h2>
    </div>
</div>


<div class='container'>
    <div class="about_page p-0">
{*        <div class='header_top'>*}
{*            <h3 class="site-main-text-color">##AboutUs##</h3>*}
{*        </div>*}
        <div class='about_text'>
            <div class='about_text_header'>
                <i class='fa fa-users'></i>
                <h2>##AboutUs##</h2>
            </div>
            {$aboutUsData['body']}
        </div>
    </div>
</div>
