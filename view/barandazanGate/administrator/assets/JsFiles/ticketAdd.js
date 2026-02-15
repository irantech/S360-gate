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

// Day Selection Cards JavaScript
var selectedGrades = [];
var dayCards = {};

// Initialize day cards
$(document).ready(function() {
    // Initialize day cards object
    for (let i = 0; i < 7; i++) {
        dayCards[i] = {
            selected: false,
            departureTime: '',
            capacities: {}
        };
    }
    
    // Watch for vehicle grades changes
    const vehicleGradesSelect = document.getElementById('vehicle_grades');
    console.log(vehicleGradesSelect,'vehicleGradesSelect');
    
    function attachVehicleGradesEvents() {
        if ($('#vehicle_grades').length) {
            // Remove any existing event listeners to prevent duplicates
            $('#vehicle_grades').off('change select2:select select2:unselect');
            
            // For Select2 elements, we need to use jQuery events
            $('#vehicle_grades').on('change', function() {
                console.log('vehicleGradesSelect change event fired');
                updateSelectedGrades();
                updateAllDayCards();
            });
            
            // Also listen for Select2 specific events
            $('#vehicle_grades').on('select2:select select2:unselect', function() {
                console.log('Select2 event fired');
                updateSelectedGrades();
                updateAllDayCards();
            });
            
            console.log('Vehicle grades events attached successfully');
        } else {
            console.log('Vehicle grades element not found, retrying...');
            // Retry after a short delay
            setTimeout(attachVehicleGradesEvents, 100);
        }
    }
    
    // Attach events
    attachVehicleGradesEvents();
    
    // Initial update
    updateSelectedGrades();
    updateAllDayCards();
    
    // Ensure Select2 is ready before attaching events
    if ($.fn.select2) {
        // Wait for Select2 to be fully initialized
        setTimeout(function() {
            $('#vehicle_grades').on('change', function() {
                console.log('Select2 change event fired (delayed)');
                updateSelectedGrades();
                updateAllDayCards();
            });
        }, 500);
    }
    
    // Override form submission to include day data
    const form = document.getElementById('FormTicket');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Add hidden inputs for selected days data
            const selectedDaysData = getSelectedDaysData();
            
            // Remove any existing day data inputs
            const existingInputs = form.querySelectorAll('input[name^="day_data_"]');
            existingInputs.forEach(input => input.remove());
            
            // Add new hidden inputs
            selectedDaysData.forEach(function(dayData, index) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'day_data_' + index;
                hiddenInput.value = JSON.stringify(dayData);
                form.appendChild(hiddenInput);
            });
            
            // Add total count
            const countInput = document.createElement('input');
            countInput.type = 'hidden';
            countInput.name = 'selected_days_count';
            countInput.value = selectedDaysData.length;
            form.appendChild(countInput);
        });
    }
});

// Toggle day card visibility and update capacities
function toggleDayCard(dayIndex) {
    const checkbox = document.getElementById('sh' + dayIndex);
    const dayCard = document.getElementById('dayCard' + dayIndex);
    
    if (checkbox.checked) {
        dayCard.classList.add('active');
        dayCards[dayIndex].selected = true;
        updateDayCardCapacities(dayIndex);
    } else {
        dayCard.classList.remove('active');
        dayCards[dayIndex].selected = false;
        clearDayCardCapacities(dayIndex);
    }
}

// Update selected grades from vehicle grades select
function updateSelectedGrades() {
    const vehicleGradesSelect = document.getElementById('vehicle_grades');
    console.log(vehicleGradesSelect,'vehicleGradesSelect');
    selectedGrades = [];
    
    if (vehicleGradesSelect) {
        // Use jQuery to get selected options from Select2
        $('#vehicle_grades option:selected').each(function() {
            selectedGrades.push({
                id: $(this).val(),
                name: $(this).text()
            });
        });
        
        console.log('Selected grades:', selectedGrades);
    }
}

// Update all day cards with new capacities
function updateAllDayCards() {
    for (let i = 0; i < 7; i++) {
        if (dayCards[i].selected) {
            updateDayCardCapacities(i);
        }
    }
}

// Update capacity fields for a specific day
function updateDayCardCapacities(dayIndex) {
    const capacityFieldsContainer = document.getElementById('capacityFields' + dayIndex);
    if (!capacityFieldsContainer) return;
    
    // Clear existing capacity fields
    capacityFieldsContainer.innerHTML = '';
    
    // Add capacity field for each selected grade
    selectedGrades.forEach(function(grade, index) {
        const capacityField = document.createElement('div');
        capacityField.className = 'capacity-field';
        capacityField.innerHTML = `
            <label for="day_capacity_${dayIndex}_${grade.id}">${grade.name}: </label>
            <input type="number" 
                   name="day_capacity_${dayIndex}_${grade.id}" 
                   id="day_capacity_${dayIndex}_${grade.id}" 
                   placeholder="ظرفیت"
                   min="0"
                   onkeypress="isDigit(this)" 
                   onkeyup="javascript:separator(this);">
        `;
        capacityFieldsContainer.appendChild(capacityField);
    });
}

// Clear capacity fields for a specific day
function clearDayCardCapacities(dayIndex) {
    const capacityFieldsContainer = document.getElementById('capacityFields' + dayIndex);
    if (capacityFieldsContainer) {
        capacityFieldsContainer.innerHTML = '';
    }
}

// Get all selected days data
function getSelectedDaysData() {
    const selectedDays = [];
    
    for (let i = 0; i < 7; i++) {
        if (dayCards[i].selected) {
            const departureTime = document.getElementById('day_departure_time_' + i);
            const dayData = {
                dayIndex: i,
                departureTime: departureTime ? departureTime.value : '',
                capacities: {}
            };
            
            // Get capacities for each grade
            selectedGrades.forEach(function(grade) {
                const capacityInput = document.getElementById('day_capacity_' + i + '_' + grade.id);
                dayData.capacities[grade.id] = capacityInput ? capacityInput.value : '';
            });
            
            selectedDays.push(dayData);
        }
    }
    
    return selectedDays;
}