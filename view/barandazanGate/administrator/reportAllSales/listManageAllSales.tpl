{if $smarty.const.TYPE_ADMIN eq 1 }
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
            <h4 class="page-title FloatLeft">گزارشات مدیریتی </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <form action='/' id="form-sales" class="form-filter d-flex justify-content-end align-items-end">
                    <div class="col-12 col-sm-6 form-group">
                        <label for='date_of'>از تاریخ :</label>
                        <input type="text" class="form-control start_date datepicker date_of" value="{dateTimeSetting::yesterday()}"
                               id="date_of">
                    </div>
                    <div class="col-12 col-sm-6 form-group">
                        <label for="to_date">تا تاریخ :</label>
                        <input type="text" class="form-control end_date datepickerReturn to_date" value="{$objFunctions->timeNow()}"
                               id="to_date">
                    </div>
                    <div class='col-12 col-sm-2 form-group'>
                        <div class='mt-2'></div>
                        <button type="button" id="button-sales" class='btn btn-info btn-block'>اعمال فیلتر</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>

        #list-sales-table tr
        {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        #list-sales-table tbody
        {
            overflow-y: scroll;
            /* height: 600px; */
            max-height: 500px;
            display: block;
            width: 100%;
        }

        .nav-link.active
        {

        }

        .loader {
            width: 8px;
            height: 40px;
            border-radius: 4px;
            display: block;
            margin: 20px auto;
            position: relative;
            background: currentColor;
            color: #FFF;
            box-sizing: border-box;
            animation: animloader 0.3s 0.3s linear infinite alternate;
        }

        .loader::after, .loader::before {
            content: '';
            width: 8px;
            height: 40px;
            border-radius: 4px;
            background: currentColor;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 20px;
            box-sizing: border-box;
            animation: animloader 0.3s  0.45s  linear infinite alternate;
        }
        .loader::before {
            left: -20px;
            animation-delay: 0s;
        }

        @keyframes animloader {
            0%   { height: 48px}
            100% { height: 4px}
        }

        .mask
        {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #00000073;
            top: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mask .loader
        {

        }



    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">گزارش مدیریتی فروش </h3>
                <!--------------tab items------------->
                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active" id="home-tab" role="tab" aria-controls="home" aria-selected="true">لیست رزرو ها</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="clinet_content" data-bs-toggle="tab"  role="tab" aria-controls="profile" aria-selected="false">تولید محتوا</a>
                    </li>

                </ul>
                <!---------contents---------------->

                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive">
                            <table id="list-sales-table" class="table table-striped">
                                <thead style='position:sticky;top:0'>

                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <table id="list-content-table" class="table table-striped">
                            <thead style='position:sticky;top:0'>
                            <th>ردیف</th>
                            <th>شناسه سرویس گیرنده</th>
                            <th>تعداد اخبار</th>
                            <th>تعداد مجله</th>
                            <th>تعداد وبلاگ</th>
                            <th>هتل ( داخلی و خارجی )</th>
                            <th>پرواز  ( داخلی و خارجی )</th>
                            <th>تعداد تور های داخلی</th>
                            <th>تعداد تور های خارجی</th>
                            <th>تعداد کل</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

                <!--------------------------------->

            <script>
                $(document).ready(function(){

                  $('body').on('click','.nav-tabs .nav-item',function(e){
                    var $this = $(this)
                    var $index = $this.index()

                    var $tab_content = $('.tab-content');
                    var $tab_panes = $tab_content.find('.tab-pane');
                        $tab_panes.removeClass('active')
                        $tab_panes.removeClass('show')
                        $tab_panes.addClass('fade')
                    $('.nav-tabs .nav-item').removeClass('active')


                    var $pane = $tab_panes.eq($index)
                    $pane.addClass('active')
                    $pane.removeClass('fade')
                    $pane.addClass('show')
                    $this.addClass('active')

                  })




                })
            </script>
            </div>
        </div>
    </div>

</div>

<!-- علامت لودینگ -->
<div id="loading-indicator" style="display: none;">
    <p>در حال بارگذاری...</p>
</div>

<style>
#loading-indicator {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    padding: 20px;
    border-radius: 5px;
    z-index: 9999;
    text-align: center;
}   

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
<script type="text/javascript" src="assets/JsFiles/reportAllSales.js"></script>

{/if}