$(document).ready(function() {
    // Check if we have pre-filled fly data
    if (typeof hasFlyData !== 'undefined' && hasFlyData) {
        // Handle form submission to ensure disabled fields are included
        $('#FormTicket').on('submit', function(e) {
            // Enable disabled fields temporarily for form submission
            var disabledFields = $(this).find('select:disabled, input:disabled');
            disabledFields.prop('disabled', false);
            
            // Submit the form
            return true;
        });
        
        // Initialize dependent dropdowns properly with existing functions
        initializeDependentDropdowns();
        
        // Add visual indication that fields are pre-filled
        $('select:disabled, input[readonly]').addClass('pre-filled-field');
        
        // Add tooltip to readonly fields
        $('select:disabled, input[readonly]').each(function() {
            $(this).attr('title', 'این فیلد از اطلاعات پرواز پیش‌فرض شده است');
        });
        
        // Show info message about pre-filled data
        showPreFilledInfo();
    }
});

function initializeDependentDropdowns() {
    // Store original values before triggering changes
    var originCityValue = $('#origin_city').val();
    var originRegionValue = $('#origin_region').val();
    var destinationCityValue = $('#destination_city').val();
    var destinationRegionValue = $('#destination_region').val();
    
    // Handle origin country -> origin city dependency
    if ($('#origin_country').val()) {
        // Use existing FillComboCity function
        FillComboCity($('#origin_country').val(), 'origin_city');
        
        // Wait for cities to load, then set the city value
        setTimeout(function() {
            if (originCityValue) {
                // Check if the option exists in the dropdown
                var cityOption = $('#origin_city option[value="' + originCityValue + '"]');
                if (cityOption.length > 0) {
                    $('#origin_city').val(originCityValue);
                    
                    // Handle origin city -> origin region dependency
                    if (originCityValue) {
                        FillComboRegion(originCityValue, 'origin_region');
                        
                        // Wait for regions to load, then set the region value
                        setTimeout(function() {
                            if (originRegionValue) {
                                var regionOption = $('#origin_region option[value="' + originRegionValue + '"]');
                                if (regionOption.length > 0) {
                                    $('#origin_region').val(originRegionValue);
                                }
                            }
                        },1800);
                    }
                } else {
                    // If option doesn't exist, try to add it manually
                    $('#origin_city').append('<option value="' + originCityValue + '" selected>' + $('#origin_city option:selected').text() + '</option>');
                }
            }
        },800);
    }
    
    // Handle destination country -> destination city dependency
    if ($('#destination_country').val()) {
        // Use existing FillComboCity function
        FillComboCity($('#destination_country').val(), 'destination_city');
        
        // Wait for cities to load, then set the city value
        setTimeout(function() {
            if (destinationCityValue) {
                // Check if the option exists in the dropdown
                var cityOption = $('#destination_city option[value="' + destinationCityValue + '"]');
                if (cityOption.length > 0) {
                    $('#destination_city').val(destinationCityValue);
                    
                    // Handle destination city -> destination region dependency
                    if (destinationCityValue) {
                        FillComboRegion(destinationCityValue, 'destination_region');
                        
                        // Wait for regions to load, then set the region value
                        setTimeout(function() {
                            if (destinationRegionValue) {
                                var regionOption = $('#destination_region option[value="' + destinationRegionValue + '"]');
                                if (regionOption.length > 0) {
                                    $('#destination_region').val(destinationRegionValue);
                                }
                            }
                        }, 1800);
                    }
                } else {
                    // If option doesn't exist, try to add it manually
                    $('#destination_city').append('<option value="' + destinationCityValue + '" selected>' + $('#destination_city option:selected').text() + '</option>');
                }
            }
        }, 800);
    }
}

function showPreFilledInfo() {
    // Create info message
    var infoHtml = '<div class="alert alert-info" role="alert">' +
        '<i class="fa fa-info-circle"></i> ' +
        'اطلاعات پرواز از شماره پرواز انتخاب شده بارگذاری شده است. ' +
        'فیلدهای غیرقابل ویرایش از اطلاعات پرواز پیش‌فرض شده‌اند.' +
        '</div>';
    
    // Insert at the top of the form
    $('#FormTicket').prepend(infoHtml);
}

// Function to handle form validation for pre-filled forms
function validatePreFilledForm() {
    var isValid = true;
    
    // Check if required fields after start_date are filled
    $('#FormTicket input[required], #FormTicket select[required]').each(function() {
        if (!$(this).is(':disabled') && !$(this).is('[readonly]')) {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        }
    });
    
    return isValid;
}

// Enhanced function to handle cascading dropdowns with proper timing and existing functions
function handleCascadingDropdowns() {
    var cascadingPairs = [
        { 
            parent: '#origin_country', 
            child: '#origin_city', 
            childValue: $('#origin_city').val(),
            grandChild: '#origin_region',
            grandChildValue: $('#origin_region').val(),
            delay: 300 
        },
        { 
            parent: '#destination_country', 
            child: '#destination_city', 
            childValue: $('#destination_city').val(),
            grandChild: '#destination_region',
            grandChildValue: $('#destination_region').val(),
            delay: 300 
        }
    ];
    
    cascadingPairs.forEach(function(pair) {
        var parentSelect = $(pair.parent);
        var childSelect = $(pair.child);
        var grandChildSelect = $(pair.grandChild);
        
        if (parentSelect.val() && pair.childValue) {
            // Use existing FillComboCity function
            FillComboCity(parentSelect.val(), childSelect.attr('id'));
            
            // Wait for child options to load, then set the value
            setTimeout(function() {
                if (childSelect.find('option[value="' + pair.childValue + '"]').length > 0) {
                    childSelect.val(pair.childValue);
                    
                    // Handle grandchild if exists
                    if (grandChildSelect.length && pair.grandChildValue) {
                        FillComboRegion(pair.childValue, grandChildSelect.attr('id'));
                        
                        setTimeout(function() {
                            if (grandChildSelect.find('option[value="' + pair.grandChildValue + '"]').length > 0) {
                                grandChildSelect.val(pair.grandChildValue);
                            }
                        }, pair.delay);
                    }
                }
            }, pair.delay);
        }
    });
} 