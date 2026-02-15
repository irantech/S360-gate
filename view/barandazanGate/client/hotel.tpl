{assign var="role"  value=$objFunctions->hasAccessMarketPlace('hotel' , $smarty.const.MARKET_HOTEL_ID)}
{if $role['has_access']}
<main>
    <div class="d-flex">
                <div class="col-lg-2 parent-page-side position-static">
                    {include file="./hotelSideBar.tpl"}
                </div>
                <div class="col-lg-10 col-md-12 col-sm-12 col-12 parent-log-marketPlace">
                    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`marketPlace/hotel/dashboard.tpl"}
                </div>
            </div>
</main>



{literal}
    <script src="assets/marketPlace/js/highcharts.js"></script>
    <script src="assets/marketPlace/js/hotel.js"></script>
    <script>
      $(document).ready(function () {
        setTimeout(function () {
          setChartData('today')
        }, 100);
      });
    </script>
{/literal}



<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: inherit;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>

{/if}