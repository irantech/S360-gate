{load_presentation_object filename="members" assign="objMembers"}
{assign var="list" value=$objMembers->presentedMembers($smarty.get.id)}

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li><a href="mainUserList">کاربران</a></li>
                <li class="active"> استفاده کنندگان از کد معرف</li>
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
                <h3 class="box-title m-b-0">لیست کاربرانی که از کد معرف این کاربر استفاده کرده اند</h3>
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped ">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام و نام خانوادگی</th>
                                <th>مقدار اعتبار</th>
                                <th>تاریخ استفاده از کد معرف</th>
                                <th>تاریخ اولین خرید</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="number" value="0"}
                            {foreach key=key item=item from=$list}
                                {$number=$number+1}
                                <tr>
                                    <td>{$number}</td>
                                    <td>{$item.name} {$item.family}</td>
                                    <td>{$item.amount|number_format}</td>
                                    <td>{$objDate->jdate('Y-m-d', $item.creationDateInt)}</td>
                                    <td>{if $item.firstBuyDate}{$objDate->jdate('Y-m-d', $item.firstBuyDate)}{else}------{/if}</td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>