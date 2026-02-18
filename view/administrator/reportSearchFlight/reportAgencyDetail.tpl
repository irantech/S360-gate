{if $smarty.const.TYPE_ADMIN eq '1'}
    {load_presentation_object filename="reportAgenciesSearch" assign="objSearch"}




    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <ol class="breadcrumb FloatRight">
                    <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                    {if  $smarty.const.TYPE_ADMIN eq '1'}
                        <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin/reportSearchFlight/reportAgenciesSearch">گزارش سرچ ها </a></li>
                        <li class="active"><a href="reportAgenciesSearch"></a>جزئیات گزارش سرچ آژانس  {$smarty.get.agency_name}</li>
                    {/if}
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">

                    <form id="SearchAgency" method="post"
                          action="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/reportSearchFlight/reportAgencyDetail?agency_id={$smarty.get.agency_id}&agency_name={$item.agency_name}">



                        <div class="form-group col-sm-6">
                            <label for="origin" class="control-label">شهر مبدا</label>
                            <select name="origin" id="origin" class="form-control select2">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                {foreach $objSearch->airportsTb() as $item }
                                    <option value="{$item.DepartureCode}" {if $smarty.post.origin eq $item.DepartureCode} selected {/if}>{$item.DepartureCityFa}</option>
                                {/foreach}
                            </select>
                        </div>


                        <div class="form-group col-sm-6">
                            <label for="destination" class="control-label">شهر مقصد</label>
                            <select name="destination" id="destination" class="form-control select2">
                                <option value="">انتخاب کنید....</option>
                                <option value="all">همه</option>
                                {foreach $objSearch->airportsTb() as $item }
                                    <option value="{$item.DepartureCode}" {if $smarty.post.destination eq $item.DepartureCode} selected {/if}>{$item.DepartureCityFa}</option>
                                {/foreach}
                            </select>
                        </div>



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
                            <label for="is_internal" class="control-label">نوع سرچ</label>
                            <select name="is_internal" id="is_internal" class="form-control">
                                <option value="">انتخاب کنید....</option>
                                <option value="">همه</option>
                                <option value="{'1'}" {if $smarty.post.is_internal eq 1} selected {/if}>{'پرواز داخلی'}</option>
                                <option value="{'2'}" {if $smarty.post.is_internal eq 2} selected {/if}>{'پرواز خارجی'}</option>
                            </select>
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
                    {assign var="totalAll" value=0}
                    {assign var="searches" value=$objSearch->getAllAgencyDetailSearch($smarty.get.agency_id)}

                    <div class="table-responsive">
                        <table id="all_transactions" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>مبدا</th>
                                <th>مقصد</th>
                                <th>تعداد سرچ</th>

                            </tr>
                            </thead>
                            <tbody>
                            {foreach key=key item=item from=$searches}
                                {assign var="totalAll" value=$totalAll+$item.total_search_count}
                                {$number=$number+1}
                                <tr id="del-{$item.id}" >
                                    <td>{$number}</td>
                                    <td>{$item.origin}</td>
                                    <td>{$item.destination}</td>
                                    <td>{$item.total_search_count}</td>
                                </tr>
                            {/foreach}
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="1" class="text-right">مجموع</th>
                                <th></th>
                                <th></th>
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