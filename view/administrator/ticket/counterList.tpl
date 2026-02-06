{load_presentation_object filename="members" assign="objCounter"}
{load_presentation_object filename="counterType" assign="objCounterType"}
{load_presentation_object filename="agencyDepartments" assign="objAgencyDepart"}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $objsession->adminIsLogin()}
                    <li><a href="agencyList">همکاران</a></li>
                {else}
                    <li>کاربران</li>
                {/if}
                <li class="active">کانترها</li>
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
                <h3 class="box-title m-b-0">لیست کانتر</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست کانتر های همکار زیر مجموعه خود را مشاهده
                    نمائید

                        <span class="pull-right">
                         <a href="counterAdd&agencyID={$smarty.get.id}" class="btn btn-info waves-effect waves-light " type="button">
                             <span class="btn-label"><i class="fa fa-user-plus"></i></span>افزودن کانتر جدید
                        </a>
                    </span>
                </p>
                <div class="table-responsive"  style="padding-bottom: 90px;">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کانتر</th>
                            <th>نام کاربری کانتر</th>
                            <th>نوع کانتر</th>
                            <th>آژانس مربوطه</th>
                            <th>واحد</th>
                            <th>تعداد خرید</th>
                            <th>تعداد مسافران</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="departList" value=[]}
                        {foreach $objAgencyDepart->getAgencyDepart() as $depart}
                            {assign var="temp" value=["id"=>$depart.id,"title"=>$depart.title]}
                            {assign var="departList" value=$departList|@array_merge:[$temp]}
                        {/foreach}

                        {assign var="number" value="0"}
                        {assign var="Id" value=$smarty.get.id}

                        {foreach key=key item=item from=$objCounter->getCountersByAgency($Id,'1')} {*نمایش اسامی
                        کانترها*}
                            {$objCounterType->get($item.fk_counter_type_id)} {*گرفتن عنوان از جدول نوع کانتر*}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.name} {$item.family}</td>
                                <td>{$item.user_name}</td>
                                <td>{$objCounterType->list['name']}</td>
                                <td>{$item.agencyName}</td>
                                <td>
                                    {assign var="unitName" value=""}
                                    {foreach $departList as $d}
                                        {if $d.id == $item.id_departments}
                                            {assign var="unitName" value=$d.title}
                                        {/if}
                                    {/foreach}
                                    {$unitName|default:"-"}
                                </td>
                                <td>{$item.CountCustomer}</td>
                                <td>{$item.CountPassenger}</td>
                                <td>
                                    <a href="#" onclick="active_counter_list('{$item.id}'); return false;">
                                        {if $item.active eq 'on'}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   data-secondary-color="#f96262" data-size="small" checked/>
                                        {else}
                                            <input type="checkbox" class="js-switch" data-color="#99d683"
                                                   &id={$item.id}  data-secondary-color="#f96262" data-size="small"/>
                                        {/if}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group m-r-10">
                                        <button aria-expanded="false" data-toggle="dropdown"
                                                class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light"
                                                type="button">
                                            عملیات <span class="caret"></span>
                                        </button>
                                        <ul role="menu" class="dropdown-menu dropdown-menu-left animated flipInY">

                                            <li class="li-list-operator">
                                                <a href="counterEdit&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                                    <i class="fcbtn btn btn-outline btn-primary btn-1f tooltip-primary ti-pencil-alt"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="ویرایش کانتر"></i>
                                                </a>
                                            </li>

                                            {assign var="check_access" value=$objFunctions->checkClientConfigurationAccess('is_access_admin')}
                                            {if $check_access eq true}
                                                <li class="li-list-operator">
                                                    {if $item.accessAdmin eq '1'}
                                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/menuPermissions/list_for_counter&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                                            <i class="fcbtn btn btn-outline btn-warning btn-1e fa fa-key tooltip-warning"
                                                               data-toggle="tooltip" data-placement="top"
                                                               data-original-title="سطح دسترسی منوها"></i>
                                                        </a>
                                                    {else}
                                                        <a href="#" onclick="return false">
                                                            <i class="fcbtn btn btn-outline btn-default btn-1e fa fa-key tooltip-default"
                                                               data-toggle="tooltip" data-placement="top"
                                                               data-original-title="کاربر دسترسی به ادمین ندارد، در صورت نیاز از ویرایش کانتر دسترسی لازم را بدهید"></i>
                                                        </a>
                                                    {/if}
                                                </li>
                                                {if $item.accessAdmin eq '1'}
                                                    <li class="li-list-operator">
                                                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/pagesPermissions/pagesPermissions&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                                                <i class="fcbtn btn btn-outline btn-warning btn-1e fa fa-key tooltip-warning"
                                                                   data-toggle="tooltip" data-placement="top"
                                                                   data-original-title="سطح دسترسی صفحات"></i>
                                                            </a>
                                                    </li>
                                                {/if}
                                            {/if}

                                            <li class="li-list-operator">
                                                <a href="passengerListCounter&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                                    <i class="fcbtn btn btn-outline btn-info btn-1f tooltip-info ti-view-list-alt"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="لیست مسافران"></i>
                                                </a>
                                            </li>

                                            <li class="li-list-operator">
                                                <a href="counterTicketHistory&id={$item.id}{if $smarty.get.id}&agencyID={$smarty.get.id}{/if}">
                                                    <i class="fcbtn btn btn-outline btn-success btn-1f tooltip-success icon-basket"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="سوابق خرید کانتر"></i>
                                                </a>
                                            </li>

                                            <li class="li-list-operator">
                                                <a href="#" onclick="passengerOnlineConvert('{$item.id}'); return false;">
                                                    <i class="fcbtn btn btn-outline btn-warning btn-1f tooltip-warning icon-user-unfollow"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="تبدیل کانتر به مسافر آنلاین"></i>
                                                </a>
                                            </li>

                                            <li class="li-list-operator">
                                                <a href="counterBankDetail&id={$item.id}{if $objsession->adminIsLogin()}&agencyID={$Id}{/if}">
                                                    <i class="fcbtn btn btn-outline btn-danger btn-1f tooltip-danger ti-money"
                                                       data-toggle="tooltip" data-placement="top"
                                                       data-original-title="مشخصات حساب بانکی"></i>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </td>


                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="assets/JsFiles/counter.js"></script>