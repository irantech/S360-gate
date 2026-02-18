{load_presentation_object filename="priceChanges" assign="objPriceChanges"}
{assign var="historyAirlines" value=$objPriceChanges->getHistoryAirlines($smarty.get.type)}

{load_presentation_object filename="airline" assign="objAirline"}

{load_presentation_object filename="counterType" assign="objCounterType"}
{assign var="counterType" value=$objCounterType->counterTypeListByID()} {*گرفتن لیست انواع کانتر*}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>تنظیمات</li>
                <li><a href="priceChanges">تغییرات قیمت بلیط</a></li>
                <li class="active">سوابق تغییرات قیمت بلیط</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <!--<h4 class="page-title FloatLeft">Dashboard 3</h4>-->
        </div>

        <!-- /.col-lg-12 -->
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست سوابق تغییرات قیمت پروازها</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید سوابق تغییرات قیمت هر ایرلاین را مشاهده کنید
                </p>

                <div class="vtabs customvtab">
                    <ul class="nav tabs-vertical">
                        {assign var="airlineCount" value="1"}
                        {foreach key=keyAirline item=itemAirline from=$historyAirlines}
                            {assign var="airline" value=$objAirline->getByAbb($itemAirline.airline_iata)}
                            <li class="tab {if $airlineCount eq 1}active{/if}">
                                <a data-toggle="tab" href="#{$itemAirline.airline_iata}{$airlineCount}" aria-expanded="true" onclick="getHistoryChangePriceEachAirline('{$itemAirline.airline_iata}')"> {$airline.name_fa} ({$itemAirline.airline_iata}) </a>
                            </li>
                            {$airlineCount = $airlineCount + 1}
                        {/foreach}
                    </ul>
                    <div class="tab-content" style="width: 90%;">
                        {assign var="airlineCount" value="1"}
                        {foreach key=keyAirline item=itemAirline from=$historyAirlines}
                            <div id="{$itemAirline.airline_iata}{$airlineCount}" class="tab-pane {if $airlineCount eq 1}active{/if}">
                                <div class="table-responsive">
                                    <table id="flight-history-table" class="table table-striped">
                                        <thead></thead>
                                        <tbody></tbody>
                                        <tfoot><tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr></tfoot>
                                    </table>
                                </div>
                            </div>

                            </div>
                            {$airlineCount = $airlineCount + 1}
                        {/foreach}
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
<script type="text/javascript" src="assets/JsFiles/priceChanges.js"></script>