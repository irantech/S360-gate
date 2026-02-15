{assign var="role"  value=$objFunctions->hasAccessMarketPlace('hotel' , $smarty.const.MARKET_HOTEL_ID)}
{if $role['has_access']}
<main>
    <div class="d-flex">
        {include file="./hotelSideBar.tpl"}
        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`marketPlace/hotel/calender.tpl"}
    </div>

</main>



{literal}
    <script src="assets/marketPlace/js/hotel.js"></script>
{/literal}
{/if}