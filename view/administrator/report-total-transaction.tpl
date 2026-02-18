{load_presentation_object filename="partner" assign="objPartner"}
{assign value=$objPartner->getInfoTransaction() var="getInfoTransaction"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">گزارش کلی تراکنش ها </li>
            </ol>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">ویرایش پروفایل </h3>
                <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید  اطلاعات خود را در سیستم ویرایش  نمائید</p>
                <div class="table-responsive">
                    <table id="newTransaction" class="table table-striped">

                        <tr>
                            <th>اعتبار فعلی</th>
                            <td>{$getInfoTransaction['total_remaining_credit_clients']|number_format}</td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <th>شارژ امروز</th>
                            <td>{$getInfoTransaction['charge_today_credit_clients']|number_format}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>خرید امروز(پرواز)</th>
                            <td> </td>
                            <td>{$getInfoTransaction['buy_to_day']|number_format}</td>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>باقی مانده</th>
                            <td> </td>
                            <td> </td>
                            <td>{$getInfoTransaction['total_calculate']|number_format}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>

