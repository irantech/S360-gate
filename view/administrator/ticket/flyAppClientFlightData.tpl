{assign var="DeptDatePickerClass" value='shamsiDeptCalendar'}
{assign var="ReturnDatePickerClass" value='shamsiReturnCalendar'}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li class="active">دریافت اطلاعات پرواز مشتری</li>
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
                <br>
                <h3 class="box-title m-b-0">دریافت اطلاعات پرواز مشتری</h3>
                </p>
                <p id="Source7Credit" style="color:red;" class="float-left"></p>
                <form id="flightDataCode" method="POST" onsubmit="return false">
                    <div class="form-group col-sm-6">
                        <label for="type" class="control-label">نوع خدمات</label>
                        <select name="type" id="type" class="form-control">
                            <option value="flight">پرواز</option>
                            <option value="hotel">هتل</option>
                            <option value="bus">اتوبوس</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="code" class="control-label">کد درخواست</label>
                        <input type="number" class="form-control" placeholder="کد درخواست" name="code">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="startDate" class="control-label">از تاریخ:</label>
                        <input type="text" class="{$DeptDatePickerClass} form-control"
                               name="date_start" id="startDate"  autocomplete='off'
                               placeholder="از تاریخ">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="endDate" class="control-label">تا تاریخ</label>
                        <input type="text" class="{$ReturnDatePickerClass} form-control"
                               name="date_end" id="endDate"  autocomplete='off' placeholder="تا تاریخ">
                    </div>
                    <input type="hidden" name="flag" value="client_flight_data">
                    <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                </form>
                <br>
                <br>
                <div class="table-responsive table-responsive-custom">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کد</th>
                            <th>مرحله</th>
                            <th>تامین کننده</th>
                            <th>درخواست</th>
                            <th>ریسپانس</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {

        // datepicker after ajax call
        $("body").on("click", ".shamsiDeptCalendar", function () {
            if (!$(this).hasClass("hasDatepicker")) {
                $(this).datepicker();
                $(this).datepicker("show");
            }
        });
        $("body").on("click", ".shamsiReturnCalendar", function () {
            if (!$(this).hasClass("hasDatepicker")) {
                $(this).datepicker();
                $(this).datepicker("show");
            }
        });

    });

</script>
<script type="text/javascript" src="assets/JsFiles/FlayAppClient.js"></script>

