{load_presentation_object filename="wholeSystemSalesInformation" assign="objSales"}
{assign var="salesInformation" value=$objSales->ShowTotalSales()}
{if $salesInformation.total_sales_ticket > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-ticket text-info me-2 FontSize26 align-middle"></i> بلیط هواپیما
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_ticket}</span>
                    </li>
                    <li class="FontSize17">
                        <span>تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_ticket}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش بلیط هواپیما
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_ticket} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_ticket} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_hotel > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-bed text-success me-2 FontSize26 align-middle"></i> هتل
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_hotel}</span>
                    </li>
                    <li class="FontSize17 mb-2">
                        <span>تعداد اتاق:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_room_hotel}</span>

                        <span class="mr-42">تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_hotel}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش هتل
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_hotel} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_hotel} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_train > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-train text-primary me-2 FontSize26 align-middle"></i> قطار
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_train}</span>
                    </li>
                    <li class="FontSize17">
                        <span>تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_train}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش قطار
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_train} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_train} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_bus > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-bus text-warning me-2 FontSize26 align-middle"></i> اتوبوس
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_bus}</span>
                    </li>
                    <li class="FontSize17">
                        <span>تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_bus}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش اتوبوس
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_bus} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_bus} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_insurance > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-heartbeat text-danger me-2 FontSize26 align-middle"></i>  بیمه
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_insurance}</span>
                    </li>
                    <li class="FontSize17">
                        <span>تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_insurance}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش بیمه
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_insurance} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_insurance} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_tour > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-globe text-purple me-2 FontSize26 align-middle"></i>  تور
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_tour}</span>
                    </li>
                    <li class="FontSize17">
                        <span>تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_tour}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش تور
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_tour} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_tour} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_visa > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-suitcase text-secondary me-2 FontSize26 align-middle" style="color: #6c757d;"></i> ویزا
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_visa}</span>
                    </li>
                    <li class="FontSize17">
                        <span>تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_visa}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش ویزا
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_visa} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_visa} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_entertainment > 0}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="fa fa-star text-pink me-2" style="color: #ff69b4;"></i> تفریحات
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>تعداد فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_sales_entertainment}</span>
                    </li>
                    <li class="FontSize17">
                        <span>تعداد مسافر:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_passengers_entertainment}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش تفریحات
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_entertainment} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_entertainment} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
{if $salesInformation.total_sales_gasht > 0}
    <div class="row">
    <div class="col-lg-6  col-md-6 col-sm-6 col-xs-12">
        <div class="white-box border">
            <h3 class="box-title"> تعداد فروش/مسافر در گشت </h3>
            <ul class="list-inline two-part">
                <li class="hidden-xs hidden-sm"><i class="fa fa-map-signs text-info"></i></li>
                <li class="text-start text-nowrap flex-grow-1">
                    <span class=" yn FontSize26">{$salesInformation.total_sales_gasht}</span>
                    <span class=" yn FontSize26"> / </span>
                    <span class=" yn FontSize26">{$salesInformation.total_passengers_gasht}</span>
                </li>
            </ul>
        </div>
    </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="white-box border">
                <h3 class="box-title FontSize26">
                    <i class="ti-money text-purple me-2 FontSize26 align-middle"></i> فروش گشت
                </h3>
                <ul class="list-unstyled mt-3">
                    <li class="FontSize17 mb-2">
                        <span>مبلغ کل فروش:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_selling_price_gasht} ریال</span>
                    </li>
                    <li class="FontSize17">
                        <span>مبلغ کل سود:</span>
                        <span class="yn FontSize17 ms-2">{$salesInformation.total_profit_gasht} ریال</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/if}
<div class="row mx-1">
    <div class="col-12">
        <div class="white-box p-4 bg-white border rounded">
            <h3 class="box-title mb-4">جمع نهایی</h3>
            <div class="row text-center">
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <span class="d-block FontSize18 mb-1">تعداد فروش</span>
                        <span class="d-block FontSize26">{$salesInformation.total_sales}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <span class="d-block FontSize18 mb-1">تعداد مسافر</span>
                        <span class="d-block FontSize26">{$salesInformation.total_passengers}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <span class="d-block FontSize18 mb-1">مبلغ فروش</span>
                        <span class="d-block FontSize26">{$salesInformation.total_selling_price}</span>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="stat-box">
                        <span class="d-block FontSize18 mb-1">مبلغ سود</span>
                        <span class="d-block FontSize26">{$salesInformation.total_profit_price}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


