{assign var="role"  value=$objFunctions->hasAccessMarketPlace('hotel' , $smarty.const.MARKET_HOTEL_ID)}
{if $role['has_access']}
<main>

            <div class="d-flex">
                <div class="col-lg-2 parent-page-side position-static">
                    {include file="./hotelSideBar.tpl"}
                </div>
                <div class="col-lg-10 col-md-12 col-sm-12 col-12 parent-log-marketPlace">
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`marketPlace/hotel/log.tpl"}
                </div>
            </div>

</main>



{literal}
    <script src="assets/marketPlace/js/hotel.js"></script>
{/literal}

{/if}

