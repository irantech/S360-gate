{if $smarty.const.TYPE_ADMIN eq '1'}
    {load_presentation_object filename="reportAgenciesSearch" assign="objSearch"}


    <div class="container-fluid">
        <div class="row bg-title">


            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    {if  $smarty.const.TYPE_ADMIN eq '1'}
                        <li class="active"><a href="reportAgenciesSearch"></a>گزارش سرچ ها</li>
                    {/if}
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">

                    <form id="SearchAgency" method="post"
                          action="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reportSearchFlight/reportAgenciesSearch">

                        <div class="form-group col-sm-6">
                            <label for="date_of" class="control-label">تاریخ از</label>
                            <input type="text" class="form-control datepicker" name="date_of"
                                   value="{if $smarty.post.date_of}{$smarty.post.date_of}{else}{$objFunctions->timeNow()}{/if}"
                                   id="date_of" placeholder="تاریخ شروع جستجو را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="to_date" class="control-label">تاریخ تا</label>
                            <input type="text" class="form-control datepickerReturn" name="to_date"
                                   value="{if $smarty.post.to_date}{$smarty.post.to_date}{else}{$objFunctions->timeNow()}{/if}"
                                   id="to_date" placeholder="تاریخ پایان جستجو را وارد نمائید">
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="agency_name" class="control-label">نام آژانس</label>
                            <input type="text" class="form-control " name="agency_name"
                                   value="{if $smarty.post.agency_name}{$smarty.post.agency_name}{/if}"
                                   id="agency_name" placeholder="نام آژانس مورد نظر را وارد کنید">
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-primary">شروع جستجو</button>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>

            </div>
        </div>

        <div class="row">

            <div class="col-sm-12">
                <div class="white-box">
                    {assign var="searches" value=$objSearch->getAllAgenciesSearch()}
                    {assign var="totalInternal" value=0}
                    {assign var="totalInternational" value=0}
                    {assign var="totalAll" value=0}

                    <div class="table-responsive">
                        <table id="all_transactions" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام مشتری</th>
                                <th>تعداد سرچ داخلی</th>
                                <th>تعداد سرچ خارجی</th>
                                <th>مجموع سرچ ها</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            {foreach key=key item=item from=$searches}
                                {$number=$number+1}

                                {assign var="totalInternal" value=$totalInternal+$item.internal_search_count}
                                {assign var="totalInternational" value=$totalInternational+$item.international_search_count}
                                {assign var="totalAll" value=$totalAll+$item.total_search_count}

                                <tr id="del-{$item.id}">
                                    <td>{$number}</td>
                                    <td>{$item.agency_name}</td>
                                    <td>{$item.internal_search_count}</td>
                                    <td>{$item.international_search_count}</td>
                                    <td>{$item.total_search_count}</td>
                                    <td class="align-middle">
                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reportSearchFlight/reportAgencyDetail?agency_id={$item.agency_id}&agency_name={$item.agency_name}">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1e fa fa-book tooltip-primary"
                                               data-toggle="tooltip" data-placement="top"
                                               data-original-title="گزارش جزئیات سرچ"></i>
                                        </a>

                                        <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reportSearchFlight/reportAgencyTimeDetail?agency_id={$item.agency_id}&agency_name={$item.agency_name}">
                                            <i class="fcbtn btn btn-outline btn-info btn-1c tooltip-info fa fa-eye"
                                               data-toggle="tooltip" data-placement="top"
                                               data-original-title="گزارش زمانی"></i>
                                        </a>
                                    </td>
                                </tr>
                            {/foreach}
                            </tbody>

                            <tfoot>
                            <tr>
                                <th colspan="2" class="text-right">مجموع</th>
                                <th>{$totalInternal}</th>
                                <th>{$totalInternational}</th>
                                <th>{$totalAll}</th>
                                <th></th>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <div class="i-section">
        <div class="i-info">
            <span> ویدیو آموزشی بخش گزارش تراکنش ها   </span>
        </div>

        <a href="https://www.iran-tech.com/whmcs/knowledgebase/367/--.html" target="_blank" class="i-btn"></a>

    </div>

    <script type="text/javascript" src="assets/JsFiles/accountcharge.js"></script>


{/if}