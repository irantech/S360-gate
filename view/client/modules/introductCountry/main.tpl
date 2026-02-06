
{load_presentation_object filename="introductCountry" assign="objAboutCountry"}
{assign var="listCountry" value=$objAboutCountry->listCountrySite()}

{*{$listCountry|var_dump}*}

{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/introductCountry-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/introductCountry.css'>
{/if}
<div class="">
    <div class="header_aboutiran">
        <h2>##GoharAboutWorld##</h2>
        <div class="search_aboutiran">
            <form class="w-100">
                <input type="text"
                       placeholder="##SearchByProvince## ..."
                       autocomplete="off"
                       onkeyup="search(this)" >
            </form>
        </div>
    </div>
    {if $listCountry}
    <div class="aboutiran_grid" id="citySearch">
        {foreach $listCountry as $item}
        <a href="{$smarty.const.ROOT_ADDRESS}/introductCountry/{$item.id}" class="aboutiran_box" >
            <div class="img_box">
                <img src="{$item.pic_show}" alt="{$item.title}" title='{$item.title}'>
            </div>
            <h2>{$item.title}</h2>
            <p>{$objAboutCountry->my_substr(strip_tags($item.note_1) , 0 , 800)}</p>
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
{if $listCountry}
<div class="owl-carousel owl-theme owl-mobile" >
    {foreach $listCountry as $item}
    <div class="item" >
        <a href="{$smarty.const.ROOT_ADDRESS}/introductCountry/{$item.id}" class="aboutiran_box">
            <div class="img_box"><img src="{$item.pic_show}" alt="{$item.title}" title='{$item.title}'></div>
            <h2>{$item.title}</h2>
            <p>{$objAboutCountry->my_substr(strip_tags($item.note_1) , 0 , 800)}</p>
            <button>##ReadMore##</button>
        </a>
    </div>
{/foreach}
</div>
{/if}


{literal}
    <script src="assets/modules/js/introductCountry.js"></script>
    <script src="assets/modules/js/owl.carousel.min.js"></script>
{/literal}