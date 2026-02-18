$(document).ready(function () {


});
(function() {
    [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
        new CBPFWTabs(el);
    });
})();
$('#logIncreasePriceFlight').DataTable({
    dom: 'lBfrtip',
    // buttons: [
    //     'copy', 'excel', 'print'
    // ]

    buttons: [
        {
            extend: 'excel',
            text: 'دریافت فایل اکسل',
            exportOptions: {}
        },
        {
            extend: 'print',
            text: 'چاپ سطر های لیست',
            exportOptions: {}
        },
        {
            extend: 'copy',
            text: 'کپی لیست',
            exportOptions: {}
        }

    ]
});


