{load_presentation_object filename="agency" assign="objAgency"}
{if $objSession->IsLogin() && $smarty.session.typeUser eq 'agency' && $smarty.session.AgencyId gt 0}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    <div class="client-head-content w-100">
        <div class="row mb-4">
            <div class="col-lg-12">
                <a href="{$smarty.const.ROOT_ADDRESS}/counterAgencyAdd" target="_blank" class="btn-add-new-user" onclick="openAddUserModal()">
                    <span class="btn-icon">+</span>
                    <span class="btn-text">افزودن کاربر جدید</span>
                    <span class="btn-hover-effect"></span>
                </a>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12">
                <table onclick="" id="memebersAgency" class="table table-sm">

                </table>
            </div>

        </div>
    </div>

{literal}
    <script>
        $(document).ready(function () {
            getCategoryData('#memebersAgency');
        });


        function getCategoryData(targetTable) {
            targetTable = $(targetTable);


            var columns = [

                {
                    "title": "ردیف",
                    "data": "column"
                },{
                    "title": "نام و نام خانوادگی",
                    "data": "nameAndFamily"
                },{
                    "title": "نام کاربری",
                    "data": "email"
                },{
                    "title": "موبایل",
                    "data": "mobile"
                },{
                    "title": "نوع کاربر",
                    "data": "typeUser"
                },
               {
                  "title": "تعداد مسافر",
                  "data": "passengerCount",
                  "render": function(data, type, row, meta) {
                     return '<a href="javascript:void(0)" onclick="goToAgencyPassengers(' + row.memberId + ')" style="color: #007bff; text-decoration: underline;">' + data + '</a>';
                  }
                }
            ];

            targetTable.DataTable({
                dom: "Bfrtip",
                info: false,
                searching: false,
                paging: false,
                processing: true,
                serverSide: true,
                'serverMethod': 'post',
                'ajax': {
                    'url': amadeusPath + "user_ajax.php",
                    'data': {
                        flag: 'membersAgency',
                        dataTable: true,
                    },
                },
                columns: columns

            });

        }

        function goToAgencyPassengers(memberId) {
           // ایجاد فرم برای ارسال POST
           var form = document.createElement('form');
           form.method = 'POST';
           form.action = amadeusPathByLang + 'agencyPassengers';
           form.style.display = 'none';
           form.target = "_blank";

           var memberIdField = document.createElement('input');
           memberIdField.type = 'hidden';
           memberIdField.name = 'memberId';
           memberIdField.value = memberId;
           form.appendChild(memberIdField);

           document.body.appendChild(form);
           form.submit();
        }
    </script>
{/literal}
{else}
    {$objFunctions->redirectOutAgency()}
{/if}