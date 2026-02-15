{load_presentation_object filename="searchService" assign="objSearchService"}
{if isset($smarty.get.id) && $smarty.get.id !== '' && $smarty.const.TYPE_ADMIN eq '1'}
    {assign var="client_id" value=$smarty.get.id}
{else}
    {assign var="client_id" value=$smarty.const.CLIENT_ID}
{/if}


{assign var="services" value=$objSearchService->checkAccessService(true,$client_id)}
{assign var="services_order" value=$objSearchService->checkAccessService(true,$client_id)}

{assign var="avalable_services" value=['Bus','Flight','Insurance','Tour','Hotel','Train','Visa','Entertainment']}


<div class="container-fluid">
    <div class="row">

        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0">لیست اولویت ها در صفحه app</h3>
                <p class="text-muted m-b-30">
                    در لیست زیر میتوانید اولویت ها را تغییر دهید
                </p>


                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>اولویت</th>
                            <th>خدمات</th>
                            <th>ویرایش</th>


                        </tr>
                        </thead>
                        <tbody>
                        {foreach key=keyService item=itemService from=$services}
                            {if in_array($itemService['MainService'],$avalable_services)}
                                <tr>
                                    <td>{$itemService['order_number']}</td>
                                    <td>{$itemService['Title']}</td>

                                    <td>
                                        <div class="input-group">
                                                <span class="input-group-addon">
                                                    <span class=' fa fa-list'></span>
                                                </span>
                                            <input type="text" onchange='serviceOrderChange($(this),"{$itemService['id']}","{$client_id}")'
                                                   value="{$itemService['order_number']}"
                                                   class="form-control text-right "
                                                   data-toggle="tooltip" data-placement="top"
                                                   data-original-title="{$itemCounter.name}" />


                                        </div>
                                    </td>

                                </tr>
                            {/if}

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
        <span> ویدیو آموزشی بخش تنظیمات تخفیف</span>
    </div>

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/396/-.html" target="_blank" class="i-btn"></a>

</div>
<script type="text/javascript">
  function serviceOrderChange(_this,service_group_id,client_id) {
    var order = _this.val()

    $.post(amadeusPath + 'user_ajax.php',
      {
        flag: 'serviceOrderChange',
        client_id: client_id,
        service_group_id: service_group_id,
        order_number: order,
      },
      function(data) {

        var res = data.split(':')

        if (data.indexOf('success') > -1) {
          $.toast({
            heading: 'اولویت',
            text: res[1],
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

        } else {

          $.toast({
            heading: 'اولویت',
            text: res[1],
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6,
          })

        }

      })

  }
</script>