{load_presentation_object filename="clients" assign="objReport"}
{assign var="reports" value=$objReport->listClosedClients()}
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default ">
            <div class="panel-heading TitleSectionsDashboard" style="cursor: pointer;" data-toggle="collapse" data-target="#ActiveBoxCloseUser">
                <h6 style="font-weight: 500; font-size: 17px; color: #3c3939; margin: 0;">
                    لیست مشتریانی که فاکتورهایش را پرداخت نکرده و سمت کاربر ایشان بسته شده است
                    <div class="pull-right"><i class="ti-minus"></i></div>
                </h6>
            </div>
                <div id="ActiveBoxCloseUser" class="panel-collapse collapse in" style="overflow: auto;">
                    <div class="panel-body clearfix">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th class="text-center">آژانس</th>
                                <th class="text-center">دامنه</th>
                                <th class="text-center"> عملیات </th>
                            </tr>
                            </thead>
                            <tbody>
                                {assign var="index" value=1}
                                {foreach from=$reports item=row name=reports}
                                        <tr>
                                            <td>{$index}</td>
                                            <td>{$row.AgencyName}</td>
                                            <td>{$row.MainDomain}</td>
                                            <td>
                                                <a href="#" onclick="changeStatusFactor('{$row.id}', this); return false;">باز شود</a>
                                            </td>
                                        </tr>
                                        {assign var="index" value=$index+1}
                                {/foreach}
                            </tbody>
                         </table>
                     </div>
                </div>
            </div>
    </div>
</div>
<script>
   function changeStatusFactor(id, el) {

      // گرفتن tr بدون jQuery سنگین
      var row = el.parentNode.parentNode;

      $.ajax({
         type: "post",
         url: amadeusPath + "ajax",
         data: JSON.stringify({
            className: 'clients',
            method: 'setStatusFactorClient',
            client_id: id,
            to_json: true
         }),
         contentType: "application/json",
         success: function(response) {
            if (response.status) {
               $.toast({
                  heading: 'وضعیت فاکتور',
                  text: response.message,
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
               setTimeout(function() {
                  row.style.display = 'none';
               }, 1000);
            } else {
               $.toast({
                  heading: 'وضعیت فاکتور',
                  text: response.message,
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'error',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
            }
         },
         error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
         }
      });
   }
</script>