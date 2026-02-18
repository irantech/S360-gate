{load_presentation_object filename="reservationTicket" assign="objResult"}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت بلیط رزرواسیون</li>
                <li class="active">سوابق خرید بلیط</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

        </div>


    </div>
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">سوابق خرید بلیط</h3>
                <p class="text-muted m-b-30">

                </p>
                <div class="table-responsive" style="width: 100%;">
                    <table id="myTable" class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نماینده</th>
                            <th>شماره بلیط</th>
                            <th>کد رفرنس</th>
                            <th>مشخصات<br>نام / سن</th>
                            <th>مسیر</th>
                            <th>رفت<br>تاریخ / پرواز</th>
                            <th>برگشت<br>تاریخ / پرواز</th>
                            <th>شرکت حمل و نقل</th>
                            <th>زمان خرید<br>تاریخ / ساعت</th>
                            <th>جریمه<br>برگشت / رفت</th>
                            <th>چاپ</th>
                            <th>قیمت با کسر کمسیون</th>
                        </tr>
                        </thead>
                        <tbody>
                        {*assign var="number" value="0"*}
                        {*foreach key=key item=item from=$objResult->viewTicket()*}
                        {*$number=$number+1*}

                        <tr id="del-{$item.id}">
                            <td id="borderFlyNumber-{*$item.id*}">{*$number*}</td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                            <td></td>

                        </tr>
                        {*/foreach*}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="assets/JsFiles/reservationTicket.js"></script>