<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>

                    <li><a href="flyAppClient"> نرم افزار پرواز</a></li>
                    <li class="active">ریسپانس سرور </li>

            </ol>
        </div>
    </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">

                    <h3 class="box-title m-b-0">مشاهده ریسپانس منابع</h3>
                    <p class="text-muted m-b-30"> شما با استفاده از فرم زیر میتوانید ریسپانس سرور مورد نظر خود را ببینید</p>

                        <div class="form-group col-sm-6">

                            <label for="code" class="control-label">کد جستجو</label>
                            <input type="text" class="form-control" id="code" name="code"
                                   placeholder="کد مورد نظر را  وارد نمایید">
                        </div>


                        <img src="assets/plugins/images/load21.gif" class="LoaderPayment"
                             id="loadingbank">
                        <button type="button" class="fcbtn btn btn-info btn-outline btn-1b margin-top-23" id="btnbank" onclick="jsonCode()">
                            ارسال
                        </button>

                    <div class="clearfix"></div>

                    <div id="showSearch" style="text-align:left; direction: ltr">

                    </div>

                </div>
            </div>
        </div>
</div>

<script type="text/javascript">

    function jsonCode() {

        $('#loadingbank').show();
        var codeSearch = $('#code').val();
        $.ajax({
            type: 'POST',
            url: amadeusPath + 'user_ajax.php',
            dataType: 'JSON',
            data:
                {
                    flag: 'searchSourceApi',
                    code: codeSearch
                },
            success: function (data) {
                $('#loadingbank').hide();
                document.getElementById("showSearch").innerHTML = '<pre>'+JSON.stringify(data, undefined,4)+'</pre>';
            }
        });

    }


</script>