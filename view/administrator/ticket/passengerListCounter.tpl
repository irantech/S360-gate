{load_presentation_object filename="passengers" assign="objPassengers"}

{assign var="list" value=$objPassengers->getAll($smarty.get.id)}

{if $objsession->adminIsLogin()}
    {assign var="AgencyId" value=$smarty.get.id}
{else}
    {assign var="AgencyId" value=$objsession->getAgencyId()}

{/if}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                {if $objAdmin->isLogin()}
                    <li><a href="agencyList">همکاران</a></li>
                {else}
                    <li>کاربران</li>
                {/if}
                <li><a href="counterList&id={$smarty.get.agencyID}">کانتر ها</a></li>
                <li class="active">لیست مسافران</li>
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
                <h3 class="box-title m-b-0">لیست مسافران</h3>
                <p class="text-muted m-b-30"> در لیست زیر شما میتوانید لیست مسافران کانتر زیر مجموعه خود را مشاهده
                    نمائید
                    <span class="pull-right">
                        <a href="passengerAddCounter&id={$smarty.get.id}{if $objsession->adminIsLogin()}&agencyID={$smarty.get.agencyID}{/if}"
                           class="btn btn-info waves-effect waves-light "
                           type="button">
                            <span class="btn-label"><i class="mdi mdi-account-multiple-plus"></i></span>افزودن مسافر جدید
                        </a>
                    </span>

                </p>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>نام انگلیسی</th>
                            <th>تاریخ تولد</th>
                            <th>کد ملی/شماره پاسپورت</th>
                            <th>نوع مسافر</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var="number" value="0"}
                        {foreach key=key item=item from=$list} {*نمایش اسامی کانترها*}
                            {$number=$number+1}
                            <tr id="del-{$item.id}">
                                <td>{$number}</td>
                                <td>{$item.name} {$item.family}</td>
                                <td>{$item.name_en} {$item.family_en}</td>
                                <td>{if $item.birthday_fa==""}{$item.birthday}{else}{$item.birthday_fa}{/if}</td>
                                <td>{if $item.NationalCode == ""}{$item.passportNumber}{else}{$item.NationalCode}{/if}</td>
                                <td>{if $item.is_foreign eq '1'} خارجی {else} ایرانی{/if}</td>
                                <td>
                                    <a href="passengerEditCounter&id={$item.id}&CounterId={$smarty.get.id}{if $objsession->adminIsLogin()}&agencyID={$smarty.get.agencyID}{/if}"><i
                                                class="fcbtn btn btn-outline btn-primary btn-1b  tooltip-primary mdi mdi-account-edit "
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title=" ویرایش مسافر "></i></a>
                                    <a href="#" onclick="delete_passenger_list('{$item.id}');
                                            return false;"><i data-toggle="tooltip" data-placement="top" title=""
                                                              data-original-title=" حذف  مسافر "
                                                              class="fcbtn btn btn-outline btn-danger btn-1b  tooltip-danger mdi mdi-account-remove "></i></a>

                                    <a href="passengerTicketHistory&Code={if $item.NationalCode == ""}{$item.passportNumber}{else}{$item.NationalCode}{/if}{if $objsession->adminIsLogin()}&AgencyId={$smarty.get.agencyID}{/if}"><i
                                                class="fcbtn btn btn-outline btn-info  btn-1b  tooltip-info mdi mdi-format-list-numbers "
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title=" مشاهده سوابق خرید مسافر"></i></a>
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

<script type="text/javascript" src="assets/JsFiles/passenger.js"></script>