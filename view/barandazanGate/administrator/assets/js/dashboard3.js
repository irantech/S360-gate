// function checkCreditSeven(){
//     $.ajax({
//         type: 'POST',
//         url: amadeusPath + 'ajax',
//         dataType: 'JSON',
//         data: JSON.stringify({
//             className: 'infoCreditCharter724',
//             method: 'getCreditCharter724'
//         }),
//         success: function(data) {
//             $('#Source7Credit').html(data.data.credit)
//         },
//         error:function(error) {
//             $('#Source7Credit').html(0)
//         }
//     });
// }
function checkGRSCredit(){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'user_ajax.php',
        data:
          {
              flag: 'checkGRSCredit',
          },
        success: function (data) {

            $('#GRSCredit').html(data)
        }
    });
}
$(document).ready(function () {


    $(".select2").select2();
    // checkCreditSeven();
    checkGRSCredit();
    //
    if(typeAdmin == 1 && adminFile !== "" && adminFile === 'itadmin') {
            // Set intervals only if adminFile is not empty and is 'itadmin'
            // setInterval(checkCreditSeven, 120000);
            setInterval(checkGRSCredit, 600000);
    }




    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1450',
        onSelect: function (dateText) {
            $(".datepickerReturn").datepicker('option', 'minDate', dateText);

            var newdate = new Date(dateText);
            newdate.setDate(newdate.getDate() + 31);

            if (newdate.getMonth() == 10) {
                var dd = newdate.getDate();
                var mm = newdate.getMonth() - 9;
                var y = newdate.getFullYear() + 1;
            } else {
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var y = newdate.getFullYear();
            }

            var someFormattedDate = y + '-' + mm + '-' + dd;
            $(".datepickerReturn").datepicker('option', 'maxDate', someFormattedDate);
        },
    });

    $(".datepicker-miladi").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        regional: ''
    });

    $(".datepickerOfToday").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: '1300:1450',
        minDate: 'Y-m-d',
        onSelect: function (dateText) {
            $(".datepickerOfTodayReturn").datepicker('option', 'minDate', dateText);
        },
    });

    $(".datepickerReturn, .datepickerOfTodayReturn").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });

    "use strict";
    $(".counter").counterUp({
        delay: 100,
        time: 1200
    });

    //data tables Option
    $('#myTable, .doDataTable').DataTable();

    var table = $('#example').DataTable({
        "columnDefs": [{
            "visible": false,
            "targets": 2
        }],
        "order": [
            [2, 'asc']
        ],
        "displayLength": 25,
        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;
            api.column(2, {
                page: 'current'
            }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                    last = group;
                }
            });
        }
    });
    // Order by the grouping
    $('#example tbody').on('click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            table.order([2, 'desc']).draw();
        } else {
            table.order([2, 'asc']).draw();
        }
    });

    var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
    $.fn.bootstrapBtn = bootstrapButton            // give $().bootstrapBtn the Bootstrap functionality

});


function getCount() {

    $.post(amadeusPath + 'user_ajax.php',
        {
            flag: 'CountUnreadMessage'
        },
        function (data) {
            $('#countMessageAjax').html(data);
            $('#inputUnreadMessage').val(data);


        });
}

function HeaderModalShowMessage(id) {


    $.post(libraryPath + 'ModalCreator.php',
        {
            Controller: 'message',
            Method: 'ModalShowMessage',
            Param: id
        },
        function (data) {
            if ($('#inputUnreadMessage').val() <= 1) {
                $('.notify').remove();
            }
            $('#noView-' + id).removeClass('mdi-bell-off btn-danger tooltip-danger').addClass('mdi-bell-ring btn-success tooltip-success').attr('data-original-title', 'این پیام قبلا مشاهده شده است');
            $('#preview-' + id).remove();
            $('#ModalPublic').html(data);
        });
}

function sendCronjob(DomainAdmin) {



    $.ajax({
        url: "https://www.iran-tech.com/old/v10/fa/admin/cronjob/cronjob_gds_for_club.php",
        type: 'POST',
        data: {
            DomainAdmin: DomainAdmin
        },
        success: function (Response) {

        }
    });
    $.toast({
        heading: 'بروز رسانی باشگاه مشتریان',
        text: 'بروز رسانی با موفقیت انجام شد',
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'success',
        hideAfter: 3500,
        textAlign: 'right',
        stack: 6
    });

}
