{load_presentation_object filename="partner" assign="objPartner"}
{if $smarty.const.TYPE_ADMIN eq '1'}
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    <li class="active">مشتریان نرم افزار پرواز</li>
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
                    <h3 class="box-title m-b-0">لیست مشتریان نرم افزار پرواز</h3>
                    <p class="text-muted m-b-30">کلیه مشتریان نرم افزار پرواز را در این لیست میتوانید مشاهده کنید <br/>
                        <span class="text-danger d-block" style="text-align: left;">به میزان کل شارژ مبلغ 5,922,193,210 ریال اضافه کنید. برداشت شرکت در تمام سالها تا تاریخ 1404/04/29 می باشد. </span>
                        <span class="pull-right">
                            <a href="flyAppClientArchived" class="btn btn-primary waves-effect waves-light " type="button">
                                <span class="btn-label"><i class="fa fa-archive"></i></span>لیست مشتریان آرشیو شده
                            </a>
                                        <a href="flyAppClientAdd" class="btn btn-info waves-effect waves-light " type="button">
                                <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن مشتری جدید
                            </a>

                           <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/excelZomorod.php?type=excel&method=customer" class="btn btn-primary waves-effect waves-light " type="button">
                                <span class="btn-label"><i class="fa fa-download"></i></span>دریافت فایل اکسل زمرد
                            </a>
                             <a href="#" onclick="creditSeven(); return false" class="btn btn-info waves-effect waves-light " type="button">
                                <span class="btn-label"><i class="fa fa-download"></i></span>اعتبار در سرور 7
                            </a>
                             <a href="#" class="btn btn-primary waves-effect waves-light " type="button">
                                کل میزان شارژ : <span id="totalCharge"></span>
                            </a>
                            <a href="#" class="btn btn-primary waves-effect waves-light " type="button">
                                 مجموع همه شارژها : <span id="totalChargeCustomer"></span>
                            </a>
                        </span>
                    </p>
                    <p id="Source7Credit" style="color:red;" class="float-left"></p>
                    <div class="table-responsive table-responsive-custom">
                        <table id="myTable" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>سر دسته</th>
                                <th>نام همکار</th>
                                <th>نام مدیر</th>
                                <th>تعداد خرید موفق</th>
                                <th>تعداد نفرات</th>
                                <th>میزان شارژ حساب</th>
                                <th>نوع تسویه</th>
                                <th>آیدی تیکت مشتری</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {assign var="number" value="0"}
                            {assign var="totalCharge" value=0}
                            {assign var="totalChargeCustomer" value=0}
                            {assign var="dbChecked" value=[]}
                            {foreach $objPartner->index() as $item}
                                {assign var="amount" value=$objFunctions->calculateChargeUserPrice({$item.id})}
                                {assign var="totalChargeCustomer" value=$totalChargeCustomer+$amount}
                                {if !in_array($item.DbName, $dbChecked)}
                                    {assign var="totalCharge" value=$totalCharge+$amount}
                                    {append var="dbChecked" value=$item.DbName}
                                    {assign var="isFirstForDb" value=true}
                                {else}
                                    {assign var="isFirstForDb" value=false}
                                {/if}

                                {$number=$number+1}
                                <tr id="del-{$item.id}">
                                    <td>{$number}</td>
                                    <td>
                                        {if $isFirstForDb}
                                            رکورد مادر
                                        {else}
                                            &#8211;
                                        {/if}
                                    </td>
                                    <td>{$item.AgencyName}--{$item.MainDomain}</td>
                                    <td>{$item.Manager}</td>
                                    <td>{$objPartner->countBuy($item.id)}</td>
                                    <td>{$objPartner->countPeople($item.id)}</td>
                                    {if $isFirstForDb}
                                        <td>
                                            {$amount|number_format}
                                        </td>
                                        <td>
                                            {$objFunctions->generateChargeUserString($amount)}
                                        </td>
                                        <td>
                                            {if $item.hash_id_whmcs == ''}
                                                <span style="color: red;">کد ندارد</span>
                                            {else}
                                                <span style="color: green;">کد دارد</span>
                                            {/if}
                                        </td>
                                        <td>
                                        <div class="btn-group m-r-10">

                                            <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button">  عملیات <span class="caret"></span></button>

                                            <ul role="menu" class="dropdown-menu dropdown-menu-left animated flipInY">
                                                <li class="li-list-operator archive-{$item.id}">
                                                    <a onclick='archive($(this),"{$item.id}")' class=""><i
                                                            class="fcbtn btn btn-outline btn-warning btn-1e fa fa-archive tooltip-warning"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="آرشیو مشتری"></i></a>
                                                </li>
                                                <li class="li-list-operator archive-{$item.id}">
                                                    <a href="agencyFlightLimitation&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-warning btn-1e fa fa-archive tooltip-warning"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="لیمیت سرچ پرواز"></i></a>
                                                </li>

                                                <li class="li-list-operator">
                                                    <a href="flyAppClientEdit&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-primary btn-1e fa fa-pencil tooltip-primary"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="ویرایش مشتری"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="airlineClinetNewDomestic&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-info btn-1e fa fa-plane tooltip-info"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="اطلاعات ایرلاین های داخلی"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="airlineClinetNewForeign&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-info btn-1e fa fa-plane tooltip-info"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="اطلاعات ایرلاین های خارجی"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/transactionUser&id={$item.id} " class=""><i
                                                                class="fcbtn btn btn-outline btn-success btn-1e fa fa-money tooltip-success"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="مشاهده تراکنش ها"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="bankList&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-warning btn-1e fa fa-bank tooltip-warning"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="اطلاعات بانک"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="errorLog&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-danger btn-1e  fa fa-exclamation-triangle tooltip-danger "
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title=" سوابق خطای وب سرویس"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="#" onclick="modalLogAdmin('{$item.id}')" class="" data-toggle="modal" data-target="#ModalPublic"><i
                                                                class="fcbtn btn btn-outline btn-default btn-1e  fa fa-list tooltip-default "
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title=" سوابق ورود به پنل"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="selectColor&ClientId={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-primary btn-1e fa fa-fire tooltip-primary"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="تعیین رنگ"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a href="settingAccessUserClientList&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-warning btn-1e fa fa-key tooltip-warning"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="دسترسی ها"></i></a>
                                                </li>
                                                <li class="li-list-operator"><a href="settingIrantechCommission&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-info btn-1e fa fa-percent tooltip-info"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="تنظیم سهم ایران تکنولوژی"></i></a>
                                                </li>
                                                <li class="li-list-operator"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/sms/setSmsService&id={$item.id}" class=""><i
                                                                class="fcbtn btn btn-outline btn-success btn-1e fa fa-comment tooltip-success"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="تنظیم پنل پیامک"></i></a>
                                                </li>
                                                <li class="li-list-operator"><a href="https://{$item.Domain}/gds/itadmin/login&id={$item.token}" class="" target="_blank"><i
                                                                class="fcbtn btn btn-outline btn-success btn-1e fa fa-sign-in tooltip-success"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="ورود به ادمین مشتری"></i></a>
                                                </li>
                                                <li class="li-list-operator">
                                                    <a onclick="ModalShowInfoPid('{$item.id}');return false"
                                                       data-toggle="modal"
                                                       data-target="#ModalPublic">
                                                        <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                                           data-toggle="tooltip"
                                                           data-placement="top" title=""
                                                           data-original-title="مشاهده اطلاعات پید"></i>
                                                    </a>
                                                </li>
                                                <li class="li-list-operator"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reservation/visaOptions&id={$item.id}" class="" target="_blank"><i
                                                                class="fcbtn btn btn-outline btn-warning btn-1e fa fa-table tooltip-warning"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="تنظیمات ویزا"></i></a>
                                                </li>
                                                <li class="li-list-operator"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/configurations/listClientsAccess?id={$item.id}" class="" target="_blank"><i class="fcbtn btn btn-outline btn-default btn-1e fa fa-toggle-on"
                                                                                                                                                                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                                                                                                                                                                    data-original-title="دسترسی تبلیغات و غیره"></i></a>
                                                </li>

                                                <li class="li-list-operator">
                                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/listClientCommission&id={$item.id}" class="" target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-success btn-1e fa fa-magnet tooltip-success"
                                                           data-toggle="tooltip" data-placement="top" title=""data-original-title="کمیسیون وایت لیبل"></i>
                                                    </a>
                                                </li>

                                                <li class="li-list-operator">
                                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/searchService/orderList?id={$item.id}" class="" target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1e  fa fa-list tooltip-default "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="ویرایش اولویت سرویس ها"></i>
                                                    </a>
                                                </li>

                                                <li class="li-list-operator">
                                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/ticket/jacketCustomerAdd?id={$item.id}" class="" target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1e  fa fa-user "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="مشتری ژاکت"></i>
                                                    </a>
                                                </li>

                                                <li class="li-list-operator">
                                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/access/listAccessAdmin&id={$item.id}" class="" target="_blank">
                                                        <i class="fcbtn btn btn-outline btn-danger btn-1e fa fa-unlock "
                                                           data-toggle="tooltip" data-placement="top" title=""
                                                           data-original-title="سطح دسترسی ادمین"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    {else}
                                        <td style="color:#ccc;">&#8211;</td>
                                        <td style="color:#ccc;">&#8211;</td>
                                        <td style="color:#ccc;">&#8211;</td>
                                        <td style="color:#ccc;">&#8211;</td>
                                    {/if}
                                </tr>
                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
{else}
    <script>
      window.location = 'admin';
    </script>
{/if}
<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      const totalCharge = {$totalCharge};
      const span = document.getElementById("totalCharge");
      if (span) {
         span.textContent = totalCharge.toLocaleString() + " ریال";
      }
       const totalChargeCustomer = {$totalChargeCustomer};
       const span1 = document.getElementById("totalChargeCustomer");
       if (span1) {
           span1.textContent = totalChargeCustomer.toLocaleString() + " ریال";
       }
   });
</script>
