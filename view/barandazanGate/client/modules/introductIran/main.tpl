
{load_presentation_object filename="introductIran" assign="objAboutIran"}
{assign var="iranProvince" value=$objAboutIran->listProvinceSite()}


{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/introductIran-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/introductIran.css'>
{/if}
<div class="">
    <div class="header_aboutiran">
        <h2>##GoharAboutIran##</h2>
        <div class="search_aboutiran">
            <form class="w-100">
                <input type="text"
                       placeholder="##SearchByProvince## ..."
                       autocomplete="off"
                       onkeyup="search(this)" >
            </form>
        </div>
    </div>
    {if $iranProvince}
    <div class="aboutiran_grid" id="citySearch">
        {foreach $iranProvince as $item}
        <a href="{$smarty.const.ROOT_ADDRESS}/introductIran/{$item.id}" class="aboutiran_box" >
            <div class="img_box">
                <img src="{$item.pic_show}" alt="{$item.title}" title='{$item.title}'>
            </div>
            <h2>{$item.title}</h2>
            <p>{$objAboutIran->my_substr(strip_tags($item.note_province) , 0 , 800)}</p>
            <button>##ReadMore##</button>
        </a>
        {/foreach}
    </div>
    {else}
        <div class="aboutiran_grid" style="text-align: right;">
                <p class='error'>
                    ##NotResultsFound##
                </p>
        </div>
    {/if}
    <div class="aboutiran_grid error" id='citySearchRes' style='display: none ; text-align: right;' >
        <p >
            ##NotResultsFound##
        </p>
    </div>
</div>
{if $iranProvince}
<div class="owl-carousel owl-theme owl-mobile" >
    {foreach $iranProvince as $item}
    <div class="item" >
        <a href="{$smarty.const.ROOT_ADDRESS}/introductIran/{$item.id}" class="aboutiran_box">
            <div class="img_box"><img src="{$item.pic_show}" alt="{$item.title}" title='{$item.title}'></div>
            <h2>{$item.title}</h2>
            <p>{$objAboutIran->my_substr(strip_tags($item.note_province) , 0 , 800)}</p>
            <button>##ReadMore##</button>
        </a>
    </div>
{/foreach}
</div>
{/if}


{literal}
    <script src="assets/modules/js/introductIran.js"></script>
    <script src="assets/modules/js/owl.carousel.min.js"></script>
{/literal}