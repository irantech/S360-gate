
{load_presentation_object filename="aboutCountry" assign="objAboutCountry"}
{assign var="listCountry" value=$objAboutCountry->GetCountry()}


<div class="">
    <div class="header_aboutiran">
        <h2>معرفی کشورها</h2>
        <div class="search_aboutiran">
            <form class="w-100">
                <input type="text"
                       placeholder="جستجو بر اساس نام کشور ..."
                       autocomplete="off"
                       onkeyup="search(this)">
            </form>
        </div>
    </div>
    {if $listCountry}
        <div class="aboutiran_grid" id="citySearch">
            {foreach $listCountry as $item}
                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/aboutCountry/detailcountry/{$item.cid}" class="aboutiran_box" >
                    <div class="img_box">
                        <img src="{$item.photo}" alt="{$item.c_country}" title='{$item.c_country}'>
                    </div>
                    <h2>{$item.c_country}</h2>
{*                    <p>{$objAboutCountry->my_substr(strip_tags($item.comment) , 0 , 300  )}</p>*}
                    <button>ادامه مطلب</button>
                </a>
            {/foreach}

        </div>
    {else}
        <div class="aboutiran_grid" >
            <p class='error'>
                نتیجه ای یافت نشد!
            </p>
        </div>
    {/if}
    <div class="aboutiran_grid error" id='citySearchRes' style='display: none' >
        <p >
            نتیجه ای یافت نشد!
        </p>
    </div>
</div>
<div class="owl-carousel owl-theme owl-mobile">
    {foreach $listCountry as $item}
    <div class="item">
        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/aboutCountry/detailcountry/{$item.cid}" class="aboutiran_box" >
            <div class="img_box">
                <img src="{$item.photo}" alt="{$item.c_country}" title='{$item.c_country}'>
            </div>
            <h2>{$item.c_country}</h2>
            {*<p>{$objAboutCountry->my_substr(strip_tags($item.comment) , 0 , 300  )}</p>*}
            <button>ادامه مطلب</button>
        </a>
    </div>
    {/foreach}
</div>

{literal}
    <script src="assets/modules/js/aboutCountry.js"></script>
    <script src="assets/modules/js/owl.carousel.min.js"></script>
{/literal}