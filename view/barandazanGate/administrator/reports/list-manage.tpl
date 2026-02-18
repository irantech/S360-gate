{if $smarty.const.TYPE_ADMIN eq 1}
{assign var="start_date" value=$objFunctions->getDifferDate('','-1 month','jalali')}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">گزارشات کلی فروش</li>
            </ol>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h4 class="page-title FloatLeft">گزارشات مدیریتی</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <form action='/' id="flights-report" class="form-filter d-flex justify-content-end align-items-end">
                    <div class="col-12 col-sm-3 form-group">
                        <label for='date_of'>از تاریخ :</label>
                        <input type="text" class="form-control start_date datepicker date_of" value="{$objFunctions->timeNow()}"
                               id="date_of">
                    </div>
                    <div class="col-12 col-sm-3 form-group">
                        <label for="to_date">تا تاریخ :</label>
                        <input type="text" class="form-control end_date datepickerReturn to_date" value="{$objFunctions->timeNow()}"
                               id="to_date">
                    </div>

                    <div class='col-12 col-sm-2 form-group'>
                        <div class='mt-2'>فیلتر بر اساس</div>
                        <select name="filtered_on" id="filtered_on" class="form-control">
                            <option value="agency_name">نام آژانس</option>
                            <option value="route_name">مسیر پروازی</option>
                            <option value="source">منبع</option>
                        </select>
                    </div>
                    <div class='col-12 col-sm-2 form-group'>
                        <div class='mt-2'>نمایش بر اساس</div>
                        <select name="filter_total" id="filter_total" class="form-control">
                            <option value="passenger">تعداد نفرات</option>
                            <option value="reserve">تعداد رزرو</option>
                        </select>
                    </div>
                    <div class='col-12 col-sm-2 form-group'>
                        <div class='mt-2'></div>
                        <button type="submit" class='btn btn-info btn-block'>اعمال فیلتر</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش مدیریتی فروش بلیط</h3>
                <p class="text-muted m-b-30">میزان فروش به تفکیک <span class="filtered_on">آژانس</span></p>
                <div class="table-responsive">
                    <table id="flights-report-table" class="table table-striped">
                        <thead></thead>
                        <tbody></tbody>
                        <tfoot><tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<style>
    .filtered_on{
        color: #132f3b;
    }
    .column-value {
        font-size: 18px;
        font-weight: bold;
    }

    .column-percentage {
        margin: 12px;
        font-size: 14px;
        font-weight: 100;
    }

    .column-percentage.success {
        color: #00ab00;
    }

    .column-percentage.error {
        color: #a4a4a4;
    }
    .column-percentage.source-error {
        color: #f85a44;
    }

    .column-percentage.warning {
        color: orange;
    }
</style>
<script type="text/javascript"
        src="assets/plugins/bower_components/datatables-plugins/editor/dataTables.editor.min.js"></script>
<script type="text/javascript" src="assets/JsFiles/reports.js"></script>

{/if}