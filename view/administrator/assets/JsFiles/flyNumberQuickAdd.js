$(document).ready(function() {
    // Initialize airport data arrays for quick add
    if (typeof internalAirports === 'undefined') {
        window.internalAirports = [];
    }
    if (typeof internationalAirports === 'undefined') {
        window.internationalAirports = [];
    }
    
    // Populate arrays from the DOM if available
    $('#quick_origin_airport option[data-type="internal"]').each(function() {
        internalAirports.push({
            code: $(this).val(),
            name: $(this).text(),
            type: 'internal'
        });
    });
    
    $('#quick_origin_airport option[data-type="international"]').each(function() {
        internationalAirports.push({
            code: $(this).val(),
            name: $(this).text(),
            type: 'international'
        });
    });
    quickListAirline();
    listTypeOfPlane();

});

// Function to handle origin airport change in quick add
function quickOnOriginAirportChange() {
    var selectedOption = $('#quick_origin_airport option:selected');
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
                if (response && response.status === 'success') {
                    var data = response.data;
                    
                    // Fill hidden fields
                    $('#quick_origin_country').val(data.country_id);
                    $('#quick_origin_city').val(data.city_id);
                    $('#quick_select_type_flight').val(data.flight_type);
                    
                    // Populate origin region dropdown
                    if (data.city_id) {
                        quickFillComboRegion(data.city_id, 'quick_origin_region');
                    }
                    
                    // Update destination airport options based on flight type
                    //quickUpdateDestinationAirportOptions(data.flight_type);
                
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
        $('#quick_origin_country').val('');
        $('#quick_origin_city').val('');
        $('#quick_select_type_flight').val('');
        $('#quick_origin_region').empty().append('<option value="">منطقه مبدا</option>');
        $('#quick_destination_airport').empty().append('<option value="">ابتدا فرودگاه مبدا را انتخاب کنید</option>');
    }
}

// Function to handle destination airport change in quick add
function quickOnDestinationAirportChange() {
    var selectedOption = $('#quick_destination_airport option:selected');
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
                if (response && response.status === 'success') {
                    var data = response.data;
                    
                    // Fill hidden fields
                    $('#quick_destination_country').val(data.country_id);
                    $('#quick_destination_city').val(data.city_id);
                    
                    // Populate destination region dropdown
                    if (data.city_id) {
                        quickFillComboRegion(data.city_id, 'quick_destination_region');
                    }
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
        $('#quick_destination_country').val('');
        $('#quick_destination_city').val('');
        $('#quick_destination_region').empty().append('<option value="">منطقه مقصد</option>');
    }
}

// Function to update destination airport options based on flight type for quick add
function quickUpdateDestinationAirportOptions(flightType) {
    var destinationSelect = $('#quick_destination_airport');
    
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
            $('#quick_origin_airport option[data-type="internal"]').each(function() {
                var option = $(this);
                destinationSelect.append('<option value="' + option.val() + '" data-type="' + option.data('type') + '">' + option.text() + '</option>');
            });
        }
    } else if (flightType === 'international') {
        // Add international airports
        if (window.internationalAirports && window.internationalAirports.length > 0) {
            window.internationalAirports.forEach(function(airport) {
                destinationSelect.append('<option value="' + airport.code + '" data-type="' + airport.type + '">' + airport.name + '</option>');
            });
        } else {
            // Fallback: get airports from the origin select
            $('#quick_origin_airport option[data-type="international"]').each(function() {
                var option = $(this);
                destinationSelect.append('<option value="' + option.val() + '" data-type="' + option.data('type') + '">' + option.text() + '</option>');
            });
        }
    }
}

// Function to fill region combo for quick add
function quickFillComboRegion(cityId, comboRegionId) {
    $.post(amadeusPath + 'hotel_ajax.php',
        {
            City: cityId,
            ComboRegion: comboRegionId,
            flag: "FillComboCity"
        },
        function (data) {
            $("#" + comboRegionId).html(data);
        })
}

// Function to list airlines for quick add
function  onchangeTypeOfVehicle(){
    quickListAirline();
    listTypeOfPlane();
}
function quickListAirline() {
    var type_of_vehicle = $('#quick_type_of_vehicle').val();
    $.post(amadeusPath + 'hotel_ajax.php',
        {
            type_of_vehicle: type_of_vehicle,
            flag: "listTransportCompanies"
        },
        function (data) {
            $("#quick_airline").html(data);
        })
}
function listTypeOfPlane(){
    var  type_of_vehicle = $('#quick_type_of_vehicle').val();
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'reservationPublicFunctions',
            method: 'listTypeOfPlane',
            type_of_vehicle: type_of_vehicle,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response && response.status === 'success') {
                $('#type_of_plane').html(response.data);
            }
        }
    });
}
// Function to parse time input and convert to HH:MM format
function parseTimeInput(timeString) {
    if (!timeString) return { hours: '00', minutes: '00' };
    
    // Remove any extra spaces
    timeString = timeString.trim();
    
    // Handle different formats
    let hours, minutes;
    
    // Format: 11:30, 11.30, 11/30
    if (timeString.includes(':') || timeString.includes('.') || timeString.includes('/')) {
        const separator = timeString.includes(':') ? ':' : (timeString.includes('.') ? '.' : '/');
        const parts = timeString.split(separator);
        hours = parts[0];
        minutes = parts[1] || '00';
    }
    // Format: 1130, 230 (4 digits or 3 digits)
    else if (timeString.length >= 3) {
        if (timeString.length === 4) {
            hours = timeString.substring(0, 2);
            minutes = timeString.substring(2, 4);
        } else if (timeString.length === 3) {
            hours = timeString.substring(0, 1);
            minutes = timeString.substring(1, 3);
        }
    }
    // Single number (assume hours)
    else {
        hours = timeString;
        minutes = '00';
    }
    
    // Validate and format
    hours = parseInt(hours) || 0;
    minutes = parseInt(minutes) || 0;
    
    // Ensure valid ranges
    if (hours < 0 || hours > 24) hours = 0;
    if (minutes < 0 || minutes > 59) minutes = 0;
    
    return {
        hours: hours.toString().padStart(2, '0'),
        minutes: minutes.toString().padStart(2, '0')
    };
}

// Function to validate time input
function validateTimeInput(timeString, isDuration = false) {
    if (!timeString) return true; // Allow empty
    
    const parsed = parseTimeInput(timeString);
    const hours = parseInt(parsed.hours);
    const minutes = parseInt(parsed.minutes);
    
    if (isDuration) {
        // Duration validation (0-24 hours, 0-59 minutes)
        return hours >= 0 && hours <= 24 && minutes >= 0 && minutes <= 59;
    } else {
        // Departure time validation (0-23 hours, 0-59 minutes)
        return hours >= 0 && hours <= 23 && minutes >= 0 && minutes <= 59;
    }
}

// Function to save fly number from quick add
function quickSaveFlyNumber() {
    // Validate required fields
    var originAirport = $('#quick_origin_airport').val();
    var destinationAirport = $('#quick_destination_airport').val();
    var flyCode = $('#quick_fly_code').val();
    var typeOfVehicle = $('#quick_type_of_vehicle').val();
    var airline = $('#quick_airline').val();
    var type_of_plane = $('#type_of_plane').val();
    var flightType = $('#quick_select_type_flight').val();
    var departureTime = $('#quick_departure_time').val();
    var duration = $('#quick_duration').val();

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
        return;
    }
    
    if (!flyCode) {
        $.toast({
            heading: 'خطا در فرم',
            text: 'لطفاً شماره پرواز را وارد کنید',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }
    
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
        return;
    }
    
    // Validate departure time
    if (departureTime && !validateTimeInput(departureTime, false)) {
        $.toast({
            heading: 'خطا در فرم',
            text: 'فرمت ساعت حرکت صحیح نیست. مثال: 11:30 یا 1130',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }
    
    // Validate duration
    if (duration && !validateTimeInput(duration, true)) {
        $.toast({
            heading: 'خطا در فرم',
            text: 'فرمت مدت زمان صحیح نیست. مثال: 2:30 یا 230',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }
    
    // Parse time inputs
    var departureParsed = parseTimeInput(departureTime);
    var durationParsed = parseTimeInput(duration);
    
    // Prepare form data
    var formData = {
        flag: 'insert_flyNumber',
        origin_airport_name: originAirport,
        destination_airport_name: destinationAirport,
        origin_country: $('#quick_origin_country').val(),
        origin_city: $('#quick_origin_city').val(),
        origin_region: $('#quick_origin_region').val(),
        destination_country: $('#quick_destination_country').val(),
        destination_city: $('#quick_destination_city').val(),
        destination_region: $('#quick_destination_region').val(),
        total_capacity: '0',
        select_type_flight: flightType,
        fly_code: flyCode,
        type_of_vehicle: typeOfVehicle,
        airline: airline,
        type_of_plane: type_of_plane,
        vehicle_grade_id: '', // Set to null as requested
        // Add parsed time fields
        departure_hours: departureParsed.hours,
        departure_minutes: departureParsed.minutes,
        hours: durationParsed.hours,
        minutes: durationParsed.minutes,
        // Add default values for other required fields
        free: '',
        day_onrequest: ''
    };
    // Show loading state
    var saveBtn = $('button[onclick="quickSaveFlyNumber()"]');
    var originalText = saveBtn.html();
    saveBtn.html('<i class="fa fa-spinner fa-spin"></i> در حال ذخیره...').prop('disabled', true);
    $.ajax({
        url: amadeusPath + 'hotel_ajax.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            var parts = response.split(':');
            if (parts[0].trim() === 'success') {
                // Show success message
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
                
                // Reset form and reload page after short delay
                setTimeout(function() {
                    quickResetForm();
                    loadFilteredFlyData();
                }, 1000);


            } else {
                // Show error message
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
        },
        complete: function() {
            // Restore button state
            saveBtn.html(originalText).prop('disabled', false);
        }
    });
}

// Function to reset quick add form
function quickResetForm() {
    $('#quick_origin_airport').val('');
    $('#quick_destination_airport').empty().append('<option value="">انتخاب مقصد...</option>');
    $('#quick_fly_code').val('');
    $('#quick_type_of_vehicle').val('');
    $('#quick_airline').empty().append('<option value="">...انتخاب شرکت حمل و نقل</option>');
    $('#type_of_plane').empty().append('<option value="">...مدل وسیله نقلیه</option>');
    
    // Reset time fields
    $('#quick_departure_time').val('');
    $('#quick_duration').val('');

    // Clear hidden fields
    $('#quick_origin_country').val('');
    $('#quick_origin_city').val('');
    $('#quick_select_type_flight').val('');
    $('#quick_origin_region').empty().append('<option value="">انتخاب ترمینال مبدا...</option>');
    $('#quick_destination_country').val('');
    $('#quick_destination_city').val('');
    $('#quick_destination_region').empty().append('<option value="">انتخاب ترمینال مقصد...</option>');
} 