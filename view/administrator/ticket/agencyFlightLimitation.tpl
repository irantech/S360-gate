{load_presentation_object filename="reportAgenciesSearch" assign="objSearch"}
{$objSearch->fillExistLimitations($smarty.get.id)}


<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <ol class="breadcrumb FloatRight">
                <li><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/admin">خانه</a></li>
            </ol>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h3 class="box-title m-b-0"></h3>
                <p class="text-muted m-b-30 textPriceChange">
                </p>
                <form id="agencyFlight" method="post" onsubmit="return submitLimitation(event)">
                    <input type="hidden" id="client_id" name="client_id" value="{$smarty.get.id}">
                    <div class="form-group col-sm-6">
                        <label for="internal_search_limit" class="control-label">تعداد لیمیت پرواز داخلی روزانه</label>
                        <input type="number" class="form-control" name="vehicle_grade" value="{$objSearch->internal_search_limit}"
                               id="internal_search_limit" placeholder="تعداد لیمیت پرواز داخلی روزانه">
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="international_search_limit" class="control-label">تعداد لیمیت پرواز خارجی روزانه</label>
                        <input type="number" class="form-control" name="vehicle_grade_abbreviation" value="{$objSearch->international_search_limit}"
                               id="international_search_limit" placeholder="تعداد لیمیت پرواز خارجی روزانه">
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="form-group  pull-right">
                                <button type="submit" class="btn btn-primary">ارسال اطلاعات</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>

<div class="i-section">

    <a href="https://www.iran-tech.com/whmcs/knowledgebase/385/--.html" target="_blank" class="i-btn"></a>

</div>

<script>
   function submitLimitation(e) {
      e.preventDefault();

      const internal_search_limit = document.getElementById('internal_search_limit').value;
      const international_search_limit = document.getElementById('international_search_limit').value;
      const client_id = document.getElementById('client_id').value;

      $.ajax({
         url: amadeusPath + 'user_ajax.php',
         type: 'POST',
         data: {
            internal_search_limit: internal_search_limit,
            flag:'insert_flight_limitation',
            international_search_limit: international_search_limit,
            client_id:client_id
         },
         success: function(response) {
            if (response) {
               $.toast({
                  heading: 'موفق',
                  text: "لیمیت با موفقیت اضافه گردید",
                  position: 'top-right',
                  loaderBg: '#fff',
                  icon: 'success',
                  hideAfter: 3500,
                  textAlign: 'right',
                  stack: 6
               });
               setTimeout(function(){
                  window.location.reload();
               },300)
            } else {
               alert(response.message || 'خطا در ذخیره');
            }
         },
         error: function() {
            alert('خطا در ارتباط با سرور');
         }
      });

      return false;
   }
</script>
