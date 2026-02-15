
$(document).ready(function () {



    $(".changePrice").change(function () {
        var price = $(this).val();
        price = price.replace(/,/g, "");
        var counter = $(this).parents('td').find('.counterID').val();
        var airline = $(this).parents('td').find('.airlineAbbr').val();
        var change_type = $(this).parents('td').find('.change_type').val();
        var locality = $(this).parents('td').find('.locality').val();
        var flight_type = $(this).parents('td').find('.flight_type').val();

        if(change_type === 'percent' && price > 100){

            $.toast({
                heading: 'تغییرات قیمت',
                text: 'خطا: مقدار نامعتبر (بیش از 100%)',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        } else {

            $.post(amadeusPath + 'user_ajax.php',
                {
                    flag: 'flightPriceChanges',
                    price: price,
                    counterID: counter,
                    airlineIata: airline,
                    change_type: change_type,
                    locality: locality,
                    flight_type: flight_type
                },
                function (data) {

                    var res = data.split(':');

                    if (data.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تغییرات قیمت',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    } else {

                        $.toast({
                            heading: 'تغییرات قیمت',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });

                    }

                });
        }

    });
    $("#localFlightPriceChangesAll").validate({
        rules: {
            localPriceChangesAll: {
                required: true,
                number: true,
            }
        },
        messages: {
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تغییرات قیمت',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='priceChanges';
                        }, 1000);
                    } else {
                        $.toast({
                            heading: 'تغییرات قیمت',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    }
                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    });
    $("#internationalFlightPriceChangesAll").validate({
        rules: {
            internationalPriceChangesAll: {
                required: true,
                number: true,
            }
        },
        messages: {
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            $(form).ajaxSubmit({
                url: amadeusPath + 'user_ajax.php',
                type: "post",
                success: function (response) {
                    var res = response.split(':');

                    if (response.indexOf('success') > -1) {
                        $.toast({
                            heading: 'تغییرات قیمت',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'success',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                        setTimeout(function(){
                            window.location ='priceChanges';
                        }, 1000);
                    } else {
                        $.toast({
                            heading: 'تغییرات قیمت',
                            text: res[1],
                            position: 'top-right',
                            loaderBg: '#fff',
                            icon: 'error',
                            hideAfter: 3500,
                            textAlign: 'right',
                            stack: 6
                        });
                    }
                }
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".form-group ").addClass("has-success").removeClass("has-error");
        }
    });


    let ajax_request = {
          url: amadeusPath + 'ajax',
          type: 'POST',
          dataType: 'JSON',
          data: function(d) {
              d.className = 'priceChanges'
              d.method = 'listFlightPriceChangesAdmin'
              return JSON.stringify(d)
          },
      },
      flight_table = $('#flight-price-changes-table')

    flight_table.DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 250,
        ajax: ajax_request,
        columnDefs: [{
            render: function(data, type, row) {
                let id = row['id_row'];
                return `<button type="button" class="btn btn-danger delete-price-change" onclick="deletePriceChanges('${id}')" data-id="${id}" data-toggle="tooltip"  data-placement="top" data-original-title="برای حذف این رکورد کیلک نمائید"><i class='fa fa-trash-o'></i></button>`
            }, targets: 8,
        }],
        columns: [
            {data: 'id', title: 'ردیف', sortable: false, searchable: false, visible: true},
            {data: 'id_row', title: 'ردیف', sortable: false, searchable: false, visible: false},
            {data: 'airline_name', title: 'نام ایرلاین', sortable: true, searchable: true, visible: true},
            {data: 'counter_type', title: 'نوع کانتر', sortable: true, searchable: false, visible: true},
            {data: 'locality', title: 'نوع جستجو', sortable: true, searchable: false, visible: true},
            {data: 'flight_type', title: 'نوع پرواز', sortable: true, searchable: false, visible: true},
            {data: 'change_type', title: 'نوع افزایش', sortable: true, searchable: false, visible: true},
            {data: 'price', title: 'میزان افزایش', sortable: false, searchable: false, visible: true},
            {data: 'action', title: 'عملیات', sortable: false, searchable: false, visible: true},
        ],
        order: [[3, 'DESC']],
    })

        let  ajax_request_history = {
        url: amadeusPath + 'ajax',
        type: 'POST',
        dataType: 'JSON',
        data: function(d) {
            d.className = 'priceChanges'
            d.method = 'historyChangePrice'
            d.airline_iata='ALL'
            return JSON.stringify(d)
        },
    }
    $('#flight-history-table').DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 250,
        ajax: ajax_request_history,
        columns: [
            {data: 'id', title: 'ردیف', sortable: false, searchable: false, visible: true},
            {data: 'price', title: 'میزان تغییر', sortable: true, searchable: false, visible: true},
            {data: 'change_type', title: 'نوع تغییر', sortable: true, searchable: false, visible: true},
            {data: 'counter_type', title: 'نوع کانتر', sortable: true, searchable: false, visible: true},
            {data: 'flight_type', title: 'نوع پرواز', sortable: true, searchable: false, visible: true}
            ],
        order: [[3, 'DESC']],
    })

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="hover"]').popover();
    $('[data-toggle="popover"]').popover();

});

function sendPriceChangeData(){
    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        data: JSON.stringify({
            className: 'priceChanges',
            method: 'addOrUpdatePriceChanges',
            airline_iata: document.getElementById('airline_iata').value,
            counter_type : document.getElementById('counter_type').value,
            locality : document.getElementById('locality').value,
            change_type : document.getElementById('change_type').value,
            flight_type : document.getElementById('flight_type').value,
            price : document.getElementById('price').value
        }),
        success: function (response) {
            $.toast({
                heading: 'افزایش قیمت',
                text: response.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon:  response.status,
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            // setTimeout(function () {
            //     location.reload();
            // },1000)
        },
        error: function (response) {
            $.toast({
                heading: 'افزایش قیمت',
                text: response.responseJSON.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: response.responseJSON.status,
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        }
    });
}

function deletePriceChanges(id) {

    $.ajax({
        type: 'POST',
        url: amadeusPath + 'ajax',
        data: JSON.stringify({
            className: 'priceChanges',
            method: 'deleteSpecificPriceChange',
            id

        }),
        success: function (response) {
            $.toast({
                heading: 'حذف افزایش قیمت',
                text: response.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon:  response.status,
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            setTimeout(function () {
                location.reload();
            },1000)
        },
        error: function (response) {
            $.toast({
                heading: ' حذف افزایش قیمت',
                text: response.responseJSON.message,
                position: 'top-right',
                loaderBg: '#fff',
                icon: response.responseJSON.status,
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });

        }
    });
}


function getHistoryChangePriceEachAirline(iata) {
    $('#flight-history-table').DataTable().destroy();
    let  ajax_request_history_eachAirline = {
        url: amadeusPath + 'ajax',
        type: 'POST',
        dataType: 'JSON',
        data: function(d) {
            d.className = 'priceChanges'
            d.method = 'historyChangePrice'
            d.airline_iata= iata
            return JSON.stringify(d)
        },
    }
    $('#flight-history-table').DataTable({
        processing: true,
        serverSide: true,
        searchDelay: 250,
        ajax: ajax_request_history_eachAirline,
        columns: [
            {data: 'id', title: 'ردیف', sortable: false, searchable: false, visible: true},
            {data: 'price', title: 'میزان تغییر', sortable: true, searchable: false, visible: true},
            {data: 'change_type', title: 'نوع تغییر', sortable: true, searchable: false, visible: true},
            {data: 'counter_type', title: 'نوع کانتر', sortable: true, searchable: false, visible: true},
            {data: 'flight_type', title: 'نوع پرواز', sortable: true, searchable: false, visible: true}
        ],
        order: [[3, 'DESC']],
    })
}


function restChangePrice(){

    $.confirm({
        theme: 'material',// 'material', 'bootstrap','supervan'
        title: 'ریست مقادیر تغییرات قیمت',
        icon: 'fa fa-trash',
        content: 'آیا از ریست کردن مقادیر تغییرات قیمت اطمینان دارید؟',
        rtl: true,
        closeIcon: true,
        type: 'orange',
        buttons: {
            confirm: {
                text: 'تایید',
                btnClass: 'btn-green',
                action: function () {
                    $.ajax({
                        type: 'POST',
                        url: amadeusPath + 'ajax',
                        data: JSON.stringify({
                            className: 'priceChanges',
                            method: 'resetChangePrice',
                        }),
                        success: function (response) {
                            $.toast({
                                heading: 'ریست افزایش قیمت',
                                text: response.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon:  response.status,
                                hideAfter: 3500,
                                textAlign: 'right',
                                stack: 6
                            });
                            setTimeout(function () {
                                location.reload();
                            },1000)
                        },
                        error: function (response) {
                            $.toast({
                                heading: 'ریست افزایش قیمت',
                                text: response.responseJSON.message,
                                position: 'top-right',
                                loaderBg: '#fff',
                                icon: response.responseJSON.status,
                                hideAfter: 3500,
                                textAlign: 'right',
                                stack: 6
                            });

                        }
                    });
                }
            },
            cancel: {
                text: 'انصراف',
                btnClass: 'btn-orange',
            }
        }
    });

}