{load_presentation_object filename="user" assign="objUser"}

{assign var="check_is_counter" value=$objUser->checkIsCounter() }
{if $objSession->IsLogin()}


    <div class="box-style">
        <div class="box-style-padding">
            <h2 class="title">##SearchOrder##</h2>
            <input type="hidden" name="hotel_id" id="hotel_id" value='{$smarty.const.MARKET_HOTEL_ID}'>
            <form id="FormUserDataSearchFilter" name="FormUserDataSearchFilter" method='post'
                  enctype='multipart/form-data'>
                <div class="form-profile">
                    <div class="label_style">
                        <span>وضعیت</span>
                        <div class="calender_profile calender_profile_grid_1">
                            <div>
                                <select name="status" id="status" class="list_calender_profile select2" >
                                    <option value="" selected>همه</option>
                                    <option value="waiting">در حال بررسی</option>
                                    <option value="payed">پرداخت شده</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <label class="label_style">
                        <span>شماره فاکتور</span>
                        <input type="text" name="tracing_code" id="tracing_code" placeholder="شماره فاکتور">
                    </label>
                </div>

                <div class="box_btn mt-4">
                    <button id="Search_getUserBuy" type="button" onclick="getHotelInvoiceList()">##Search##</button>
                </div>

            </form>
        </div>
    </div>
    <div id="memberResultSearch" class="memberResultSearch">
        <div class='loading'>
            <div class="box-style"><div class="box-style-padding"><div class="loading_css"></div></div></div>
        </div>
        <div class="table-responsive d-none" style="width: 100%;">
            <table id="booking" class="table table-striped text-center">
                <thead>
                <tr>
                    <th>شماره فاکتور</th>
                    <th>صادر کننده</th>
                    <th>تاریخ صدور</th>
                    <th>تعداد رزرو</th>
                    <th>مبلغ(ریال)</th>
                    <th>وضعیت فاکتور</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
{literal}
    <script>
      $(document).ready(function () {
        setTimeout(function () {
          getInvoiceList();
        }, 100);
      });
      function getInvoiceList() {
        getHotelInvoiceList();
      }
    </script>
{/literal}
{else}
    {$objUser->redirectOut()}
{/if}
