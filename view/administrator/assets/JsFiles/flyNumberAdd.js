$(document).ready(function() {
    // Initialize airport data arrays if they don't exist
    if (typeof internalAirports === 'undefined') {
        window.internalAirports = [];
    }
    if (typeof internationalAirports === 'undefined') {
        window.internationalAirports = [];
    }
    
    // Handle form submission
    $('#FormFlyNumber').on('submit', function(e) {
        e.preventDefault();

        // Reset borders
        $('#origin_airport_name, #destination_airport_name, #select_type_flight, #day_onrequest').css('border-color', '');

        // Validate airports
        var originAirport = $('#origin_airport_name').val();
        var destinationAirport = $('#destination_airport_name').val();
        if (!originAirport || !destinationAirport) {
            $.toast({
                heading: 'خطا در فرم',
                text: 'لطفاً هر دو فرودگاه مبدا و مقصد را انتخاب کنید',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            if (!originAirport) $('#origin_airport_name').css('border-color', 'red');
            if (!destinationAirport) $('#destination_airport_name').css('border-color', 'red');
            return;
        }

        // Validate flight type
        var flightType = $('#select_type_flight').val();
        if (!flightType) {
            $.toast({
                heading: 'خطا در فرم',
                text: 'نوع پرواز تعیین نشده است. لطفاً فرودگاه‌ها را مجدداً انتخاب کنید',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            $('#select_type_flight').css('border-color', 'red');
            return;
        }

        // Validate total capacity
       /* var totalCapacity = $('#total_capacity').val();
        if (!totalCapacity || isNaN(totalCapacity) || totalCapacity <= 0) {
            $.toast({
                heading: 'خطا در فرم',
                text: 'ظرفیت کل وارد نشده یا معتبر نیست',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            $('#total_capacity').css('border-color', 'red');
            return;
        }*/

        // Validate stop-sale time
        var dayOnRequest = $('#day_onrequest').val();
        if (!dayOnRequest || isNaN(dayOnRequest) || dayOnRequest < 0) {
            $.toast({
                heading: 'خطا در فرم',
                text: 'زمان توقف فروش وارد نشده یا معتبر نیست',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 3500,
                textAlign: 'right',
                stack: 6
            });
            $('#day_onrequest').css('border-color', 'red');
            return;
        }

        // Submit via Ajax
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                var parts = response.split(':');
                if (parts[0].trim() === 'success') {
                    $.toast({
                        heading: 'افزودن شماره پرواز',
                        text: parts[1].trim(),
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'success',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });

                    if (parts.length > 2 && parts[2].trim()) {
                        var flyId = parts[2].trim();
                        setTimeout(function() {
                            if (confirm('شماره پرواز با موفقیت ذخیره شد. آیا می‌خواهید بلیط برای این پرواز اضافه کنید؟')) {
                                window.location.href = 'ticketAdd?fly_id=' + flyId;
                            } else {
                                window.location.href = 'flyNumber';
                            }
                        }, 1000);
                    } else {
                        setTimeout(function() {
                            window.location.href = 'flyNumber';
                        }, 1000);
                    }
                } else {
                    $.toast({
                        heading: 'خطا در افزودن شماره پرواز',
                        text: parts[1].trim(),
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
                $.toast({
                    heading: 'خطا در ارتباط',
                    text: 'خطا در ارتباط با سرور',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });
    });


});

// Function to handle origin airport change
function onOriginAirportChange() {
    var selectedOption = $('#origin_airport_name option:selected');
    var airportCode = selectedOption.val();
    var flightType = selectedOption.data('type');
    
    if (airportCode) {
        // Get airport information
        $.ajax({
            type: "post",
            url: `${amadeusPath}ajax`,
            data: JSON.stringify({
                className: 'reservationPublicFunctions',
                method: 'getAirportInfo',
                airport_code: airportCode,
                to_json: true
            }),
            contentType: "application/json",
            success: function(response) {
                // Check if response is successful
                console.log('response',response)
                if (response && response.status === 'success') {
                    var data = response.data;
                    
                    // Fill hidden fields
                    $('#origin_country').val(data.country_id);
                    $('#origin_city').val(data.city_id);
                    $('#origin_region').val(data.region_id || '');
                    
                    // Set flight type based on the selected airport
                    $('#select_type_flight').val(data.flight_type);
                    
                    // Update destination airport options based on flight type
                    updateDestinationAirportOptions(data.flight_type);
                
                } else {
                    $.toast({
                        heading: 'خطا',
                        text: (response && response.error) ? response.error : 'خطا در دریافت اطلاعات فرودگاه',
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
                $.toast({
                    heading: 'خطا در ارتباط',
                    text: 'خطا در ارتباط با سرور',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });
    } else {
        // Clear hidden fields if no airport selected
        $('#origin_country').val('');
        $('#origin_city').val('');
        $('#origin_region').val('');
        $('#select_type_flight').val('');
    }
}

// Function to handle destination airport change
function onDestinationAirportChange() {
    var selectedOption = $('#destination_airport_name option:selected');
    var airportCode = selectedOption.val();
    
    if (airportCode) {
        // Get airport information
        $.ajax({
            type: "post",
            url: `${amadeusPath}ajax`,
            data: JSON.stringify({
                className: 'reservationPublicFunctions',
                method: 'getAirportInfo',
                airport_code: airportCode,
                to_json: true
            }),
            contentType: "application/json",
            success: function(response) {
                // Check if response is successful
                if (response && response.status === 'success') {
                    var data = response.data;
                    
                    // Fill hidden fields
                    $('#destination_country').val(data.country_id);
                    $('#destination_city').val(data.city_id);
                    $('#destination_region').val(data.region_id || '');
                    const  origin_city = $('#destination_city').val();
                    FillComboRegion(origin_city, 'destination_region');
                } else {
                    $.toast({
                        heading: 'خطا',
                        text: (response && response.error) ? response.error : 'خطا در دریافت اطلاعات فرودگاه',
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
                $.toast({
                    heading: 'خطا در ارتباط',
                    text: 'خطا در ارتباط با سرور',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'error',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            }
        });
    } else {
        // Clear hidden fields if no airport selected
        $('#destination_country').val('');
        $('#destination_city').val('');
        $('#destination_region').val('');
    }
}

// Function to update destination airport options based on flight type
function updateDestinationAirportOptions(flightType) {
    var destinationSelect = $('#destination_airport_name');
    
    // Clear current options
    destinationSelect.empty();
    destinationSelect.append('<option value="">انتخاب کنید....</option>');
    
    if (flightType === 'internal') {
        // Add internal airports
        if (window.internalAirports && window.internalAirports.length > 0) {
            window.internalAirports.forEach(function(airport) {
                destinationSelect.append('<option value="' + airport.code + '" data-type="' + airport.type + '">' + airport.name + '</option>');
            });
        } else {
            // Fallback: get airports from the origin select
            $('#origin_airport_name option[data-type="internal"]').each(function() {
                var option = $(this);
                destinationSelect.append('<option value="' + option.val() + '" data-type="' + option.data('type') + '">' + option.text() + '</option>');
            });
        }
    } else if (flightType === 'international') {
        console.log('internationalAirports',internationalAirports)
        // Add international airports
        if (window.internationalAirports && window.internationalAirports.length > 0) {
            window.internationalAirports.forEach(function(airport) {
                destinationSelect.append('<option value="' + airport.code + '" data-type="' + airport.type + '">' + airport.name + '</option>');
            });
        } else {
            // Fallback: get airports from the origin select
            $('#origin_airport_name option[data-type="international"]').each(function() {
                var option = $(this);
                destinationSelect.append('<option value="' + option.val() + '" data-type="' + option.data('type') + '">' + option.text() + '</option>');
            });
        }
    }
    const  origin_city = $('#origin_city').val();
    FillComboRegion(origin_city, 'origin_region');
    $('.select2').each(function() {
        if ($(this).hasClass('select2-hidden-accessible')) {
            $(this).select2('destroy');
        }
    });
    $(".select2").select2();
} 