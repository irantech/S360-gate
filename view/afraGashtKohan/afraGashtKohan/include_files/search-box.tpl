{assign var="info_access_client_to_service" value=$info_access_client_to_service}
{load_presentation_object filename="specialPages" assign="objSpecialPages"}


<section class="search_box">
    <div class='container'>
    </div>
    <div class="container search_box_div">
        {if  $smarty.const.GDS_SWITCH eq 'mainPage'}
           <h2 id="titr_searchBox">##Reservation## <em></em> <span id="text_search"> ##foreigneIranTours## </span></h2>
        {/if}
       {include file="./search-box/tabs-search-box.tpl"}
       {include file="./search-box/boxs-search.tpl"}
    </div>
    <svg version="1.1" id="circle_banner" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 250" enable-background="new 0 0 500 250" xml:space="preserve" preserveAspectRatio="none"><path fill="#FFFFFF" d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"></path></svg>
</section>
{include file="include_files/banner-slider.tpl" }







