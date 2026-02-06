$(document).ready(function () {
    $('.select2BusRouteSearch').select2({
        ajax: {
            type: 'POST',
            url: amadeusPath + 'bus_ajax.php',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchingValue: params.term, // search term
                    flag: 'select2BusRouteSearch'
                };
            },
            cache: true
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        },
        placeholder: 'جستجو بین شهر ها',
        minimumInputLength: 1,
        language: {
            inputTooShort: function () {
                return "شما باید حداقل یک حرف وارد کنید";
            },searching: function () {
                return "در حال جستجو ... ";
            }
        }


    });
});