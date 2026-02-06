
{load_presentation_object filename="aboutIran" assign="objAboutIran"}
{assign var="iranCity" value=$objAboutIran->GetCity()}
{if $smarty.const.SOFTWARE_LANG eq 'en' || $smarty.const.SOFTWARE_LANG eq 'ru'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/aboutIran-en.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/aboutIran.css'>
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
    {if $iranCity}
    <div class="aboutiran_grid" id="citySearch">
        {foreach $iranCity as $item}
        <a href="{$smarty.const.ROOT_ADDRESS}/aboutIran/{$item.id}" class="aboutiran_box" >
            <div class="img_box">
                <img src="{$item.photo}" alt="{$item.ci_name}" title='{$item.ci_name}'>
            </div>
            <h2>{$item.ci_name}</h2>
            <p>{$objAboutIran->my_substr(strip_tags($item.ci_tari) , 0 , 800)}</p>
            <button>##ReadMore##</button>
        </a>
        {/foreach}
    </div>
    {else}
        <div class='alert alert-warning d-flex flex-wrap font-15 font-weight-bold justify-content-center mr-3 w-100'>
            ##NoInformationToDisplay##
        </div>
    {/if}
</div>
{if $iranCity}
<div class="owl-carousel owl-theme owl-mobile" >
    {foreach $iranCity as $item}
    <div class="item" >
        <a href="{$smarty.const.ROOT_ADDRESS}/aboutIran/{$item.id}" class="aboutiran_box">
            <div class="img_box"><img src="{$item.photo}" alt="{$item.ci_name}" title='{$item.ci_name}'></div>
            <h2>{$item.ci_name}</h2>
            <p>{$objAboutIran->my_substr(strip_tags($item.ci_tari) , 0 , 800)}</p>
            <button>##ReadMore##</button>
        </a>
    </div>
{/foreach}
</div>
{/if}


{literal}
    <script src="assets/modules/js/aboutIran.js"></script>
    <script src="assets/modules/js/owl.carousel.min.js"></script>
{/literal}