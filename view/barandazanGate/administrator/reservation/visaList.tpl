{load_presentation_object filename="visa" assign="objVisa"}
{assign var="visaList" value=$objVisa->agencyVisaList()}

{load_presentation_object filename="country" assign="objCountry"}
<style>
    .numeric-input {
        max-width: 150px;
        margin: 0 auto;
        text-align: center;
    }

    .ajax-status {
        font-size: 12px;
        min-height: 20px;
    }
</style>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">

            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
                <li>مدیریت ویزا رزرواسیون</li>
                <li class="active">لیست ویزا ها</li>
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
                <h3 class="box-title m-b-0">لیست ویزا ها </h3>
                <p class="text-muted m-b-30  ">در لیست زیر ویزا ها را میتوانید مشاهده و ویرایش نمایید.
                    <span class="pull-right">
                         <a href="visaAdd" class="btn btn-info waves-effect waves-light " type="button">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>افزودن ویزا
                        </a>
                    </span>
                </p>
                <div class="table-responsive">

                    <table id="myTable" class="table table-striped ">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>وضعیت</th>
                                <th>اولویت</th>
                                <th>کشور</th>
                                <th>قیمت</th>
                                <th>پلن</th>
                                <th>نوع</th>
                                <th>سوالات متداول</th>
                                <th>مدارک</th>
                                <th>مراحل اخذ</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="number" value="0"}

                            {foreach $visaList as $item}
                                {assign var="visaExpirationInfo" value=$objVisa->visaExpirationDiff($item.id)}

                                {$number = $number + 1}
                                {assign var="visaCountry" value=$objCountry->getCountryByCode($item.countryCode)}
                                <tr>
                                    <td>{$number}</td>
                                    <td>
                                        {$item.title}
                                    </td>
                                    <td>
                                        <a href="#">
                                            <div style='float: right;'
                                                 onclick="visaValidate('{$item.id}'); return false;">
                                                <input type="checkbox"
                                                       class="js-switch2"
                                                       data-color="#99d683"
                                                       data-secondary-color="#f96262"
                                                       data-size="small"
                                                       {if $item.validate eq 'granted'}checked="checked"{/if} />
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                        <input
                                                type="number"
                                                class="form-control form-control-sm numeric-input"
                                                style="width:98px"
                                                data-id="{$item['id']}"
                                                placeholder="مقدار را وارد کنید"
                                                value="{$item['priority']|default:''}">
                                        <div class="ajax-status mt-1" id="status-{$item['id']}"></div>
                                    </td>
                                    <td>{$visaCountry.name}</td>
                                    <td>{$item.mainCost|number_format}</td>
                                    <td title="{$visaExpirationInfo['result_message']['expired_at_fa']}">{$visaExpirationInfo['result_message']['remainingTile']}</td>
                                    <td>{$item.category_title}</td>
                                    <td>
                                        {*onclick="logical_deletion('{$item.id}', 'visa_tb'); return false"*}
                                        <a href="visaFaqList&visaId={$item.id}"
                                           id="DelChangePrice-2"
                                           class="popoverBox popover-danger" data-toggle="popover" title=""
                                           data-placement="right">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c fa fa-question "></i>
                                        </a>
                                    </td>
                                    <td>
                                        {*onclick="logical_deletion('{$item.id}', 'visa_tb'); return false"*}
                                        <a href="visaDocsList&visaId={$item.id}"
                                           id="DelChangePrice-2"
                                           class="popoverBox  popover-danger" data-toggle="popover" title=""
                                           data-placement="right">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c fa fa-clipboard-check "></i>
                                        </a>
                                    </td>
                                    <td>
                                        {*onclick="logical_deletion('{$item.id}', 'visa_tb'); return false"*}
                                        <a href="visaStepList&visaId={$item.id}"
                                           id="DelChangePrice-2"
                                           class="popoverBox  popover-danger" data-toggle="popover" title=""
                                           data-placement="right">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c fa fa-edit "></i>
                                        </a>
                                    </td>
                                    <td>
                                        {*onclick="logical_deletion('{$item.id}', 'visa_tb'); return false"*}
                                        <a href="visaEdit&id={$item.id}"
                                           id="DelChangePrice-2"
                                           class="popoverBox  popover-danger" data-toggle="popover" title=""
                                           data-placement="right">
                                            <i class="fcbtn btn btn-outline btn-primary btn-1c fa fa-eye "></i>
                                        </a>
                                    </td>
                                    <td>
                                        {*onclick="logical_deletion('{$item.id}', 'visa_tb'); return false"*}
                                        <a onclick="logical_deletion('{$item.id}', 'visa_tb'); return false"
                                           id="DelChangePrice-2"
                                           class="popoverBox  popover-danger" data-toggle="popover" title=""
                                           data-placement="right">
                                            <i class="fcbtn btn btn-outline btn-danger btn-1c fa fa-remove "></i>
                                        </a>
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

<div class="i-section">
    <div class="i-info">
        <span> ویدیو آموزشی بخش لیست ویزاها  </span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/392/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript">
   $(document).ready(function () {
      $('#visaList').DataTable();

      $(document).on('input', '.numeric-input', function() {
         var input = $(this);
         var visaId = input.data('id');
         var value = input.val();
         var statusDiv = $('#status-' + visaId);

         // نمایش وضعیت لودینگ
         statusDiv.html('<span class="text-info">در حال ارسال...</span>');

         // ارسال درخواست AJAX
         $.ajax({
            url: amadeusPath + 'visa_ajax.php',
            type: 'POST',
            data: {
               visa_id: visaId,
               value: value,
               flag: 'changePriority'
            },
            success: function(response) {
               console.log(response);
               if(response) {
                  statusDiv.html('<span class="text-success">' + 'اولویت با موفقیت بارگذاری شد' + '</span>');

                  // پاک کردن پیام بعد از 3 ثانیه
                  setTimeout(function() {
                     statusDiv.fadeOut(500, function() {
                        $(this).html('').show();
                     });
                  }, 3000);
               } else {
                  statusDiv.html('<span class="text-danger">' + response.message + '</span>');
               }
            },
            error: function(xhr, status, error) {
               statusDiv.html('<span class="text-danger">خطا در ارتباط با سرور</span>');
               console.error('AJAX Error:', error);
            }
         });
      });

      // محدودیت برای ورود فقط اعداد
      $(document).on('keypress', '.numeric-input', function(e) {
         var charCode = (e.which) ? e.which : e.keyCode;
         if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
         }
         return true;
      });
   });
</script>
<script type="text/javascript" src="assets/JsFiles/visa.js"></script>
<script type="text/javascript" src="assets/JsFiles/reservationBasicInformation.js"></script>