<div class="top-dashboard-control d-lg-flex justify-content-between align-items-center ">
    <h1 class="mb-0 d-none d-lg-block">پیشخوان</h1>
    <div class="dashboard-filter">
        <div>
            <input type="hidden" name="hotel_id" id="hotel_id" value='{$smarty.const.MARKET_HOTEL_ID}'>
            <div class="sort-box sort-booking d-flex align-items-center">
                <span class="font-weight-bold pl-2 ">نمایش براساس</span>
                <div class="filter-box-btn-dashboard">
                    <div class="todayRadio  parent-input-today-week btn btn-sm sort-btn btn-primary">
                        <label for="dayType1">امروز</label>
                        <input type="radio" name="dayType" id="dayType1" value="today" checked="">
                    </div>
                    <div class="tomorrowRadio parent-input-today-week  btn btn-sm sort-btn btn-glass-secondary">
                        <label for="dayType2">فردا</label>
                        <input type="radio" name="dayType" id="dayType2" value="tomorrow">
                    </div>
                    <div class="weekRadio btn  parent-input-today-week btn-sm sort-btn btn-glass-secondary">
                        <label for="dayType3">7 روز آینده</label>
                        <input type="radio" name="dayType" id="dayType3" value="week">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class='d-flex parent-item-dashboard'>
    <div class='info-box col-md-5 p-4 p-lg-5'>
        <h2 class='dashboard-title'>وضعیت ظرفیت مجموع اتاق‌ها در {$smarty.const.CLIENT_NAME}</h2>
        <div class='parent-box-item-dashboard'>
            <div class='box-item-dashboard'>
                <h1>ظرفیت رزروشده</h1>
                <p>ظرفیتی که از طریق {$smarty.const.CLIENT_NAME} رزرو شده است.</p>
            </div>
            <h3 class="reserved_count"></h3>
        </div>
        <div class='parent-box-item-dashboard'>
            <div class='box-item-dashboard'>
                <h1>ظرفیت موجود</h1>
                <p>ظرفیت باقیمانده اتاق‌های هتل در سایت {$smarty.const.CLIENT_NAME}.</p>
            </div>
            <h3 class="available_count"></h3>
        </div>
        <div class='parent-box-item-dashboard'>
            <div class='box-item-dashboard'>
                <h1>ظرفیت اتاق</h1>
                <p>ظرفیت مجموع اتاق‌هایی که هتل شما به {$smarty.const.CLIENT_NAME} اختصاص داده‌ است.</p>
            </div>
            <h3 class="total_count"></h3>
        </div>
    </div>
    <div class='chart-box p-4 p-lg-5 col-md-7'>
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>

    </div>
</div>



