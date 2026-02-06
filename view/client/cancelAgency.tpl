{load_presentation_object filename="agency" assign="objAgency"}
{if $objSession->IsLogin() && $smarty.session.typeUser eq 'agency' && $smarty.session.AgencyId gt 0}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    <div class="client-head-content w-100">

        <div class="row">

            <div class="col-lg-12">
                <button class="order-button">
                    استرداد و کنسلی
                    <span class="icon">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                    </span>
                </button>
                <table onclick="" id="cancelAgency" class="table table-sm">

                </table>
            </div>

        </div>
    </div>

{literal}
    <script>
        $(document).ready(function () {
            getCategoryData('#cancelAgency');
        });


        function getCategoryData(targetTable) {
            targetTable = $(targetTable);
            var columns = [

                {
                    "title": "ردیف",
                    "data": "column"
                },{
                    "title": "شماره رزرو/شماره فاکتور",
                    "data": "requestNumberAndFactorNumber"
                },{
                    "title": "درصد جریمه",
                    "data": "percentPenalty"
                },{
                    "title": "مبلغ استرداد",
                    "data": "amountReturned"
                },{
                    "title": "وضعیت",
                    "data": "status"
                },
              {
                "title": "موضوع کنسلی",
                "data": "type"
              }
            ];

            // targetTable.DataTable({
            //     dom: "Bfrtip",
            //     'processing': true,
            //     'serverSide': true,
            //     'serverMethod': 'post',
            //     'ajax': {
            //         'url': amadeusPath + "user_ajax.php",
            //         'data': {
            //             flag: 'cancelAgency',
            //             dataTable: true,
            //         },
            //     },
            //     columns: columns
            //
            // });

           targetTable.DataTable({
              dom: "Bfrtip",
              processing: true,
              serverSide: true,
              serverMethod: 'post',
              ajax: {
                 url: amadeusPath + "user_ajax.php",
                 data: {
                    flag: 'cancelAgency',
                    dataTable: true,
                 },
              },
              columns: columns,
              columnDefs: [
                 {
                    targets: 2,
                    width: "100px",
                    className: "text-center" 
                 }
              ]
           });

        }



    </script>
{/literal}
{else}
    {$objFunctions->redirectOutAgency()}
{/if}