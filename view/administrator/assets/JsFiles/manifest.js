$(document).ready(function () {
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });

    // Initialize dropify for file upload styling
    $('.dropify').dropify();

    // Check if we're on the upload page and initialize upload functionality
    if ($('#uploadManifestForm').length > 0) {
        initializeUploadPage();
        }


});

function manifest_toggle_status(sourceId) {
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'toggleStatus',
            source_id: sourceId,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
           console.log(response)
            if (response.data.success) {
                $.toast({
                    heading: 'وضعیت مانیفست',
                    text: 'وضعیت مانیفست با موفقیت تغییر کرد',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
                
                // Reload page to reflect changes
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                $.toast({
                    heading: 'وضعیت مانیفست',
                    text: response.data.message || 'خطا در تغییر وضعیت',
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
                heading: 'وضعیت مانیفست',
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
}

// Manifest Results Functions
function toggleDate(dateId) {
    const dateContent = document.getElementById(dateId);
    const dateSection = dateContent.closest('.date-section');
    
    if (dateContent.classList.contains('show')) {
        dateContent.classList.remove('show');
        dateSection.classList.remove('expanded');
    } else {
        dateContent.classList.add('show');
        dateSection.classList.add('expanded');
        
        // Add waterfall effect to route cards
        const routeCards = dateContent.querySelectorAll('.route-card');
        routeCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'none';
            setTimeout(() => {
                card.style.animation = 'staggerIn 0.3s ease-out';
            }, 10);
        });
    }
}

function toggleRoute(routeId) {
    const routeContent = document.getElementById(routeId);
    const routeCard = routeContent.closest('.route-card');
    
    if (routeContent.classList.contains('show')) {
        routeContent.classList.remove('show');
        routeCard.classList.remove('expanded');
    } else {
        routeContent.classList.add('show');
        routeCard.classList.add('expanded');
        
        // Add waterfall effect to flight items
        const flightItems = routeContent.querySelectorAll('.flight-item');
        flightItems.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.05}s`;
            item.style.animation = 'none';
            setTimeout(() => {
                item.style.animation = 'staggerIn 0.25s ease-out';
            }, 10);
        });
    }
}

// Global variable to store current modal's passenger data
let currentModalPassengersData = null;

// Function to show flight details modal
function showFlightDetailsModal(airlineIata, flightNumber, date, routeName, timeFlight) {
    // Prevent event bubbling
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Show loading state
    const modalContent = document.getElementById('ModalPublic');
    modalContent.innerHTML = `
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fa fa-plane"></i>
                در حال بارگذاری...
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">در حال بارگذاری...</span>
            </div>
        </div>
    `;
    
    // Show modal
    $('#ModalPublic').modal('show');
    
    // Fetch flight details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightDetails',
            airline_iata: airlineIata,
            flight_number: flightNumber,
            flight_date: date,
            route_name: routeName,
            time_flight: timeFlight,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.data.status) {
                showFlightDetailsInModal(response.data.data, airlineIata, flightNumber, date, routeName, timeFlight);
            } else {
                showFlightDetailsError(response.message || 'خطا در دریافت اطلاعات پرواز');
            }
        },
        error: function() {
            showFlightDetailsError('خطا در ارتباط با سرور');
        }
    });
}

// Function to show passengers modal
function showPassengersModal(airlineIata, flightNumber, date, routeName, timeFlight) {
    // Prevent event bubbling
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Get passengers data from the clicked element
    const clickedElement = event.target.closest('[data-passengers]');
    if (!clickedElement) return;
    
    const passengersData = JSON.parse(clickedElement.getAttribute('data-passengers'));
    
    // Store passenger data globally for export functions
    currentModalPassengersData = passengersData;
    
    // Create modal content
    const modalContent = `
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fa fa-users"></i>
                مسافران پرواز ${airlineIata} ${flightNumber}
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="flight-info-simple mb-4">
                <div class="flight-details-row">
                    <div class="flight-detail-item">
                        <span class="detail-label">تاریخ:</span>
                        <span class="detail-value">${date}</span>
                    </div>
                    <div class="flight-detail-item">
                        <span class="detail-label">مسیر:</span>
                        <span class="detail-value">${routeName}</span>
                    </div>
                    <div class="flight-detail-item">
                        <span class="detail-label">زمان:</span>
                        <span class="detail-value">${timeFlight}</span>
                    </div>
                    <div class="flight-detail-item">
                        <span class="detail-label">مسافران:</span>
                        <span class="detail-value">${passengersData.length} نفر</span>
                    </div>
                </div>
            </div>
            
            <div class="passengers-section">
                <div class="passengers-table-container">
                    <table class="table passengers-minimal-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>نام مسافر</th>
                                <th style="width: 80px;">نوع</th>
                                <th style="width: 120px;">کد ملی</th>
                                <th>آژانس</th>
                                <th style="width: 120px;">شماره رزرو</th>
                                <th style="width: 130px;">شماره تماس</th>
                                <th style="width: 100px;">PNR</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${passengersData.map((passenger, index) => `
                                <tr>
                                    <td class="text-center">
                                        <span class="row-number">${index + 1}</span>
                                    </td>
                                    <td>
                                        <span class="passenger-name">${passenger.passenger_name} ${passenger.passenger_family}</span>
                                    </td>
                                    <td class="text-center">
                                        ${getSimplePassengerTypeBadge(passenger.passenger_age)}
                                    </td>
                                    <td>
                                        <span class="national-code">${passenger.passenger_national_code}</span>
                                    </td>
                                    <td class="agency-name">${passenger.agency_name}</td>
                                    <td>
                                        <span class="booking-code">${passenger.request_number}</span>
                                    </td>
                                    <td>
                                        <span class="phone-number">${passenger.member_mobile}</span>
                                    </td>
                                    <td>
                                        ${passenger.pnr ? `<span class="pnr-code">${passenger.pnr}</span>` : '<span class="no-data">-</span>'}
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">
                بستن
            </button>
            <button type="button" class="btn btn-primary" onclick="exportPassengersToTxt('${airlineIata}', '${flightNumber}', '${date}')">
                <i class="fa fa-download"></i> 
                دریافت فایل
            </button>
        </div>
    `;
    
    // Set modal content
    document.getElementById('ModalPublic').innerHTML = modalContent;
    
    // Show modal using Bootstrap's modal API
    $('#ModalPublic').modal('show');
}

// Function to show flight details in modal
function showFlightDetailsInModal(flightData, airlineIata, flightNumber, date, routeName, timeFlight) {
    const modalContent = `
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fa fa-plane"></i>
                جزئیات پرواز ${airlineIata} ${flightNumber}
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="flight-info-simple mb-4">
                <div class="flight-details-row">
                    <div class="flight-detail-item">
                        <span class="detail-label">تاریخ:</span>
                        <span class="detail-value">${date}</span>
                    </div>
                    <div class="flight-detail-item">
                        <span class="detail-label">مسیر:</span>
                        <span class="detail-value">${routeName}</span>
                    </div>
                    <div class="flight-detail-item">
                        <span class="detail-label">زمان:</span>
                        <span class="detail-value">${timeFlight}</span>
                    </div>
                    <div class="flight-detail-item">
                        <span class="detail-label">ایرلاین:</span>
                        <span class="detail-value">${flightData.airline_name || airlineIata}</span>
                    </div>
                </div>
            </div>
            
            ${generateTicketsContent(flightData.tickets)}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">
                بستن
            </button>
            <button type="button" class="btn btn-primary" onclick="exportFlightDetailsToTxt('${airlineIata}', '${flightNumber}', '${date}')">
                <i class="fa fa-download"></i> 
                دریافت فایل
            </button>
        </div>
    `;
    
    document.getElementById('ModalPublic').innerHTML = modalContent;
}

// Function to show flight details error
function showFlightDetailsError(errorMessage) {
    const modalContent = `
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fa fa-exclamation-triangle"></i>
                خطا
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                ${errorMessage}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                بستن
            </button>
        </div>
    `;
    
    document.getElementById('ModalPublic').innerHTML = modalContent;
}

// Function to generate tickets content for modal
function generateTicketsContent(tickets) {
    if (!tickets || tickets.length === 0) {
        return `
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                هیچ بلیطی برای این پرواز یافت نشد.
            </div>
        `;
    }
    
    let content = '<div class="tickets-section">';
    
    tickets.forEach((ticketData, index) => {
        const totalPassengers = (ticketData.manifest_records ? ticketData.manifest_records.length : 0) +
           (ticketData.book_records ? ticketData.book_records.length : 0)

        content += `
            <div class="ticket-detail-card mb-4">
                <div class="ticket-detail-header">
                    <h5 class="ticket-detail-title">
                        <i class="fa fa-ticket-alt"></i>
                        بلیط ${index + 1} - ${ticketData.ticket.exit_hour}
                    </h5>
                    <div class="ticket-detail-stats">
                  
                        <span class="badge badge-info">مسافران: ${totalPassengers}</span>
                    </div>
                </div>
                
                ${generatePassengersContent(ticketData)}
            </div>
        `
        // <span className="badge badge-primary">ظرفیت: ${ticketData.ticket.fly_total_capacity}</span>
        // <span className="badge badge-success">پر شده: ${ticketData.ticket.fly_full_capacity}</span>
        // <span className="badge badge-warning">باقی: ${ticketData.ticket.remaining_capacity}</span>
    });

    content += "</div>"
    return content
}

// Function to generate passengers content
function generatePassengersContent(ticketData) {
    const manifestRecords = ticketData.manifest_records || []
    const bookRecords = ticketData.book_records || []

    if (manifestRecords.length === 0 && bookRecords.length === 0) {
        return `
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i>
                هیچ مسافری برای این بلیط یافت نشد.
            </div>
        `;
    }
    
    let content = '<div class="passengers-details">';
    
    // Manifest records
    if (manifestRecords.length > 0) {
        content += `
            <div class="passenger-section mb-3">
                <h6 class="passenger-section-title">
                    <i class="fa fa-upload"></i>
                    مسافران مانیفست (${manifestRecords.length} نفر)
                </h6>
                <div class="passengers-table-container">
                    <table class="table passengers-minimal-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>نام مسافر</th>
                                <th style="width: 120px;">کد ملی</th>
                                <th style="width: 100px;">نوع</th>
                                <th style="width: 120px;">شماره بلیط</th>
                                <th style="width: 130px;">شماره تماس</th>
                                <th style="width: 120px;">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${manifestRecords.map((passenger, index) => `
                                <tr>
                                    <td class="text-center">
                                        <span class="row-number">${index + 1}</span>
                                    </td>
                                    <td>
                                        <span class="passenger-name">${passenger.passenger_name} ${passenger.passenger_family}</span>
                                    </td>
                                    <td>
                                        <span class="national-code">${passenger.passenger_national_code || '-'}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="simple-badge">${passenger.passenger_type || '-'}</span>
                                    </td>
                                    <td>
                                        <span class="ticket-number">${passenger.ticket_number || '-'}</span>
                                    </td>
                                    <td>
                                        <span class="phone-number">${passenger.member_phone || '-'}</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-passenger" onclick="editPassenger('${passenger.id}', 'manifest')" title="ویرایش مسافر">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    // Book records
    if (bookRecords.length > 0) {
        content += `
            <div class="passenger-section mb-3">
                <h6 class="passenger-section-title">
                    <i class="fa fa-book"></i>
                    مسافران فرم رزرو (${bookRecords.length} نفر)
                </h6>
                <div class="passengers-table-container">
                    <table class="table passengers-minimal-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>نام مسافر</th>
                                <th style="width: 120px;">کد ملی</th>
                                <th style="width: 100px;">وضعیت</th>
                                <th style="width: 130px;">شماره تماس</th>
                                <th style="width: 150px;">ایمیل</th>
                                <th style="width: 120px;">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${bookRecords.map((passenger, index) => `
                                <tr>
                                    <td class="text-center">
                                        <span class="row-number">${index + 1}</span>
                                    </td>
                                    <td>
                                        <span class="passenger-name">${passenger.passenger_name} ${passenger.passenger_family}</span>
                                    </td>
                                    <td>
                                        <span class="national-code">${passenger.passenger_national_code || '-'}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-${passenger.successfull === 'book' ? 'success' : 'warning'}">${passenger.successfull}</span>
                                    </td>
                                    <td>
                                        <span class="phone-number">${passenger.member_phone || '-'}</span>
                                    </td>
                                    <td>
                                        <span class="email">${passenger.member_email || '-'}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-warning btn-edit-passenger" onclick="editPassenger('${passenger.id}', 'book')" title="ویرایش مسافر">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            ${passenger.request_number ? `
                                                <button type="button" class="btn btn-sm btn-info btn-book-details" onclick="ModalShowBookForFlight('${passenger.request_number}');return false" title="مشاهده جزئیات رزرو">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            ` : ''}
                                        </div>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    content += '</div>';
    return content;
}

// Helper function to get passengers summary
function getPassengersSummary(passengersData) {
    const summary = passengersData.reduce((acc, passenger) => {
        const type = passenger.passenger_age;
        acc[type] = (acc[type] || 0) + 1;
        return acc;
    }, {});
    
    const summaryItems = [];
    if (summary.Adt) summaryItems.push(`${summary.Adt} بزرگسال`);
    if (summary.Chd) summaryItems.push(`${summary.Chd} کودک`);
    if (summary.Inf) summaryItems.push(`${summary.Inf} نوزاد`);
    
    return summaryItems.join(' • ');
}

// Clear modal data when modal is closed
$(document).on('hidden.bs.modal', '#ModalPublic', function () {
    currentModalPassengersData = null;
});

// Helper function to get passenger type badge
function getPassengerTypeBadge(passengerAge) {
    switch(passengerAge) {
        case 'Adt':
            return '<span class="badge badge-adult">بزرگسال</span>';
        case 'Chd':
            return '<span class="badge badge-child">کودک</span>';
        case 'Inf':
            return '<span class="badge badge-infant">نوزاد</span>';
        default:
            return `<span class="badge badge-default">${passengerAge}</span>`;
    }
}

// Helper function to get simple passenger type badge
function getSimplePassengerTypeBadge(passengerAge) {
    switch(passengerAge) {
        case 'Adt':
            return '<span class="simple-badge">بزرگسال</span>';
        case 'Chd':
            return '<span class="simple-badge">کودک</span>';
        case 'Inf':
            return '<span class="simple-badge">نوزاد</span>';
        default:
            return `<span class="simple-badge">${passengerAge}</span>`;
    }
}

// Function to export passengers to TXT file
function exportPassengersToTxt(airlineIata, flightNumber, date) {
    // Get passengers data from the global variable
    if (!currentModalPassengersData) {
        $.toast({
            heading: 'دریافت فایل TXT',
            text: 'خطا: داده مسافران یافت نشد',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }
    
    const passengersData = currentModalPassengersData;
    
    // Implementation for TXT export
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'exportPassengersToTxt',
            airline_iata: airlineIata,
            flight_number: flightNumber,
            flight_date: date,
            passengers_data: passengersData,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                // Download the TXT file
                window.open(response.data.file_url, '_blank');
                
                $.toast({
                    heading: 'دریافت فایل TXT',
                    text: 'فایل TXT با موفقیت ایجاد شد',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'دریافت فایل TXT',
                    text: response.message || 'خطا در ایجاد فایل TXT',
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
                heading: 'دریافت فایل TXT',
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
}

// Function to export flight details to TXT file
function exportFlightDetailsToTxt(airlineIata, flightNumber, date) {
    // Implementation for flight details TXT export
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'exportFlightDetailsToTxt',
            airline_iata: airlineIata,
            flight_number: flightNumber,
            flight_date: date,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {

            console.log('response',response)
            if (response.data.status) {
                // Download the TXT file
                window.open(response.data.data.file_url, '_blank');
                
                $.toast({
                    heading: 'دریافت فایل TXT',
                    text: 'فایل TXT با موفقیت ایجاد شد',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'دریافت فایل TXT',
                    text: response.message || 'خطا در ایجاد فایل TXT',
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
                heading: 'دریافت فایل TXT',
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
}

// Function to export passengers to Excel (placeholder)
function exportPassengersToExcel(airlineIata, flightNumber, date) {
    // Get passengers data from the global variable
    if (!currentModalPassengersData) {
        $.toast({
            heading: 'دریافت اکسل',
            text: 'خطا: داده مسافران یافت نشد',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }
    
    console.log('Export to Excel:', airlineIata, flightNumber, date);
    
    // Implementation for Excel export
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'exportPassengersToExcel',
            airline_iata: airlineIata,
            flight_number: flightNumber,
            flight_date: date,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                // Download the Excel file
                window.open(response.file_url, '_blank');
                
                $.toast({
                    heading: 'دریافت اکسل',
                    text: 'فایل اکسل با موفقیت ایجاد شد',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3500,
                    textAlign: 'right',
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'دریافت اکسل',
                    text: 'خطا در ایجاد فایل اکسل',
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
                heading: 'دریافت اکسل',
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
}

// Initialize manifest results page functionality
$(document).ready(function() {
    // Add smooth scrolling
    document.documentElement.style.scrollBehavior = 'smooth';
    
    // Close modal when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest("#ModalPublic").length && !$(event.target).closest(".btn-passenger-modal").length) {
            $("#ModalPublic").modal('hide');
        }
    });
    
    // Clear passenger data when modal is hidden
    $('#ModalPublic').on('hidden.bs.modal', function() {
        currentModalPassengersData = null;
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey) {
            if (e.key === 'e' || e.key === 'E') {
                e.preventDefault();
                // Expand all flights
                document.querySelectorAll('.flight-details').forEach(detail => {
                    detail.classList.add('show');
                    detail.closest('.flight-item').classList.add('expanded');
                });
            } else if (e.key === 'c' || e.key === 'C') {
                e.preventDefault();
                // Collapse all flights
                document.querySelectorAll('.flight-details').forEach(detail => {
                    detail.classList.remove('show');
                    detail.closest('.flight-item').classList.remove('expanded');
                });
            }
        }
    });
}); 

// ========== UPLOAD PAGE FUNCTIONALITY ==========

// Initialize upload page functionality
function initializeUploadPage() {
    // Initialize datepicker
    $('.datepicker').datepicker({
        format: "yyyy/mm/dd",
        language: "fa",
        autoclose: true,
        todayHighlight: true
    });
    
    // Enable button when file is selected
    $('#manifest_file').on('change', function() {
        handleManifestFileSelection(this);
    });
    
    // Form validation and submission using uploadFiles pattern
    $('#uploadManifestForm').validate({
        rules: {
            manifest_date: 'required',
            route: 'required',
            airline_iata: 'required',
            manifest_file: 'required'
        },
        messages: {
            manifest_date: {
                required: "تاریخ مانیفست الزامی است"
            },
            route: {
                required: "مسیر پرواز الزامی است"
            },
            airline_iata: {
                required: "کد ایرلاین الزامی است"
            },
            manifest_file: {
                required: "آپلود فایل مانیفست الزامی است"
            }
        },
        errorElement: 'em',
        errorPlacement: function(error, element) {
            error.addClass('help-block');
            if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent('label'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            // Show loading state
            const button = $('#uploadButton');
            button.addClass('loading').prop('disabled', true);
            $('.form-control-modern').addClass('form-loading');
            
            // Reset validation results
            $('#validation-results').hide().removeClass('error');
            
            $(form).ajaxSubmit({
                url: amadeusPath + 'ajax',
                type: 'POST',
                success: function(response) {
                    let displayIcon = response.success === true ? 'success' : 'error';
                    
                    if (response.success === true) {
                        showValidationSuccess(response);
                        
                        setTimeout(function() {
                            button.html('لطفا صبر کنید...');
                            button.prop('disabled', true);
                        }, 200);
                        
                        setTimeout(function() {
                            window.location = `${amadeusPath}itadmin/manifest/results`;
                        }, 3000);
                    } else {
                        showValidationError(response);
                        
                        $.toast({
                            heading: 'آپلود مانیفست',
                            text: response.message,
                            position: 'top-right',
                            icon: displayIcon,
                            hideAfter: 4000,
                            textAlign: 'right',
                            stack: 6
                        });
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'خطای غیرمنتظره در ارتباط با سرور';
                    
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || errorMessage;
                    } catch (e) {
                        if (status === 'timeout') {
                            errorMessage = 'زمان اتصال به سرور به پایان رسید. لطفاً مجدداً تلاش کنید.';
                        }
                    }
                    
                    showValidationError({ message: errorMessage, error_type: 'connection_error' });
                    
                    $.toast({
                        heading: 'آپلود مانیفست',
                        text: errorMessage,
                        position: 'top-right',
                        icon: 'error',
                        hideAfter: 4000,
                        textAlign: 'right',
                        stack: 6
                    });
                },
                complete: function() {
                    // Reset loading state
                    button.removeClass('loading').prop('disabled', false);
                    $('.form-control-modern').removeClass('form-loading');
                }
            });
        },
        highlight: function(element, errorClass, validClass) {
            $(element)
                .parents('.form-group')
                .addClass('has-error')
                .removeClass('has-success');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element)
                .parents('.form-group')
                .addClass('has-success')
                .removeClass('has-error');
        }
    });
    
    // Auto-uppercase airline IATA
    $('#airline_iata').on('input', function() {
        this.value = this.value.toUpperCase();
    });
}

// Handle manifest file selection (from file input or drag/drop)
function handleManifestFileSelection(fileInput) {
    const button = $('#uploadButton');
    const previewGallery = $('#preview-gallery');
    
    if (fileInput.files && fileInput.files.length > 0) {
        const file = fileInput.files[0];
        
        // Validate file type
        if (!file.name.toLowerCase().endsWith('.txt')) {
            $.toast({
                heading: 'نوع فایل نامعتبر',
                text: 'لطفاً فقط فایل‌های با پسوند .txt آپلود کنید.',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 4000,
                textAlign: 'right',
                stack: 6
            });
            fileInput.value = '';
            button.prop('disabled', true);
            previewGallery.hide();
            return;
        }
        
        // Validate file size (max 10MB)
        if (file.size > 10 * 1024 * 1024) {
            $.toast({
                heading: 'حجم فایل زیاد',
                text: 'حجم فایل نباید از 10 مگابایت بیشتر باشد.',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'error',
                hideAfter: 4000,
                textAlign: 'right',
                stack: 6
            });
            fileInput.value = '';
            button.prop('disabled', true);
            previewGallery.hide();
            return;
        }
        
        // Show file preview
        button.prop('disabled', false);
        previewGallery.show().html(`
            <div class="manifest-file-preview">
                <div class="file-preview-content">
                    <div class="file-icon">
                        <i class="fa fa-file-alt"></i>
                    </div>
                    <div class="file-info">
                        <h6 class="file-name">${file.name}</h6>
                        <p class="file-details">
                            <span class="file-size">${(file.size / 1024).toFixed(1)} KB</span>
                            <span class="file-type">متن ساده</span>
                        </p>
                    </div>
                    <div class="file-actions">
                        <button type="button" class="btn-remove-file" onclick="removeManifestFile()">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `);
    } else {
        button.prop('disabled', true);
        previewGallery.hide();
    }
}

// Drag and drop handler for manifest files
function dropHandlerUploadManifest(ev) {
    ev.preventDefault();
    
    const fileInput = document.getElementById('manifest_file');
    const dt = new DataTransfer();
    
    if (ev.dataTransfer && ev.dataTransfer.items) {
        // Handle dropped files
        const files = [...ev.dataTransfer.items]
            .filter(item => item.kind === 'file')
            .map(item => item.getAsFile());
            
        if (files.length === 0) {
            return;
        }
        
        // Only take the first file for manifest upload
        const file = files[0];
        dt.items.add(file);
        fileInput.files = dt.files;
        
        // Handle the file selection
        handleManifestFileSelection(fileInput);
    }
    
    // Remove drag over styling
    document.getElementById('drop_zone').classList.remove('dragover');
}

// Drag over handler for manifest files
function dragOverHandlerUploadManifest(ev) {
    ev.preventDefault();
    document.getElementById('drop_zone').classList.add('dragover');
}

// Drag leave handler for manifest files
function dragLeaveHandlerUploadManifest(ev) {
    ev.preventDefault();
    document.getElementById('drop_zone').classList.remove('dragover');
}

// Remove selected manifest file
function removeManifestFile() {
    const fileInput = document.getElementById('manifest_file');
    const button = $('#uploadButton');
    const previewGallery = $('#preview-gallery');
    
    fileInput.value = '';
    button.prop('disabled', true);
    previewGallery.hide();
}

// Show validation success message
function showValidationSuccess(response) {
    const validationSection = $('#validation-results');
    const validationContent = $('#validation-content');
    
    let content = `
        <div class="success-message">
            <div class="success-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="success-content">
                <h6>آپلود با موفقیت انجام شد!</h6>
                <p>${response.message}</p>
            </div>
        </div>
    `;
    
    if (response.stats) {
        content += `
            <div class="upload-stats">
                <h6><i class="fa fa-chart-bar"></i> آمار آپلود:</h6>
                <div class="stats-grid-small">
                    <div class="stat-item">
                        <span class="stat-label">رکوردهای پردازش شده:</span>
                        <span class="stat-value">${response.stats.total_processed}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">نام فایل:</span>
                        <span class="stat-value">${response.stats.file_name}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">حجم فایل:</span>
                        <span class="stat-value">${response.stats.file_size}</span>
                    </div>
                    ${response.stats.warnings_count > 0 ? `
                    <div class="stat-item warning">
                        <span class="stat-label">هشدارها:</span>
                        <span class="stat-value">${response.stats.warnings_count} مورد</span>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
    }
    
    validationContent.html(content);
    validationSection.show();
    
    // Auto-scroll to results
    validationSection[0].scrollIntoView({ behavior: 'smooth' });
}

// Show validation error message
function showValidationError(response) {
    const validationSection = $('#validation-results');
    const validationContent = $('#validation-content');
    
    validationSection.addClass('error');
    
    const errorLines = response.message.split('\n');
    let content = `
        <div class="error-message">
            <div class="error-icon">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div class="error-content">
                <h6>خطا در پردازش فایل</h6>
            </div>
        </div>
    `;
    
    if (errorLines.length > 1) {
        content += '<div class="error-list"><ul>';
        errorLines.forEach(function(line, index) {
            if (line.trim() && index > 0) { // Skip the first line (title)
                content += `<li>${line.trim()}</li>`;
            }
        });
        content += '</ul></div>';
    } else {
        content += `<div class="error-simple">${response.message}</div>`;
    }
    
    // Add help text based on error type
    if (response.error_type === 'validation_error') {
        content += `
            <div class="error-help">
                <h6><i class="fa fa-lightbulb"></i> راهنمایی:</h6>
                <ul>
                    <li>بررسی کنید که تاریخ، مسیر و کد ایرلاین وارد شده با محتوای فایل مطابقت داشته باشد</li>
                    <li>فرمت فایل باید .txt و محتوای آن CSV باشد</li>
                    <li>هر خط باید حداقل 11 ستون داشته باشد</li>
                    <li>فرمت تاریخ در فایل باید YY/MM/DD باشد</li>
                </ul>
            </div>
        `;
    }
    
    validationContent.html(content);
    validationSection.show();
    
    // Auto-scroll to results
    validationSection[0].scrollIntoView({ behavior: 'smooth' });
}

// Function to edit passenger
function editPassenger(recordId, recordType) {
    // Prevent event bubbling
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Show loading state
    const modalContent = document.getElementById('ModalPublic');
    modalContent.innerHTML = `
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fa fa-edit"></i>
                در حال بارگذاری...
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="spinner-border" role="status">
                <span class="sr-only">در حال بارگذاری...</span>
            </div>
        </div>
    `;
    
    // Show modal
    $('#ModalPublic').modal('show');
    
    // Fetch passenger details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getPassengerForEdit',
            record_id: recordId,
            record_type: recordType,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.data.status) {
                showEditPassengerForm(response.data.data.record, response.data.data.record_type);
            } else {
                showEditPassengerError(response.message || 'خطا در دریافت اطلاعات مسافر');
            }
        },
        error: function() {
            showEditPassengerError('خطا در ارتباط با سرور');
        }
    });
}

// Function to show edit passenger form
function showEditPassengerForm(passenger, recordType) {
    const modalContent = `
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fa fa-edit"></i>
                ویرایش اطلاعات مسافر
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="editPassengerForm">
                <input type="hidden" id="editRecordId" value="${passenger.id}">
                <input type="hidden" id="editRecordType" value="${recordType}">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="editPassengerName">نام مسافر *</label>
                            <input type="text" class="form-control" id="editPassengerName" value="${passenger.passenger_name || ''}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="editPassengerFamily">نام خانوادگی مسافر *</label>
                            <input type="text" class="form-control" id="editPassengerFamily" value="${passenger.passenger_family || ''}" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="editPassengerNationalCode">کد ملی</label>
                            <input type="text" class="form-control" id="editPassengerNationalCode" value="${passenger.passenger_national_code || ''}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="editPassportNumber">شماره پاسپورت</label>
                            <input type="text" class="form-control" id="editPassportNumber" value="${passenger.passportNumber || ''}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="editPassengerType">نوع مسافر</label>
                            <select class="form-control" id="editPassengerType">
                                <option value="ADL" ${passenger.passenger_type === 'ADL' ? 'selected' : ''}>بزرگسال</option>
                                <option value="CHD" ${passenger.passenger_type === 'CHD' ? 'selected' : ''}>کودک</option>
                                <option value="INF" ${passenger.passenger_type === 'INF' ? 'selected' : ''}>نوزاد</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="editPassengerGender">جنسیت</label>
                            <select class="form-control" id="editPassengerGender">
                                <option value="M" ${passenger.passenger_gender === 'M' ? 'selected' : ''}>مرد</option>
                                <option value="F" ${passenger.passenger_gender === 'F' ? 'selected' : ''}>زن</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="editMemberPhone">شماره تماس</label>
                            <input type="text" class="form-control" id="editMemberPhone" value="${passenger.member_phone || ''}">
                        </div>
                    </div>
                </div>
                
                ${recordType === 'manifest' ? `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editTicketNumber">شماره بلیط</label>
                                <input type="text" class="form-control" id="editTicketNumber" value="${passenger.ticket_number || ''}">
                            </div>
                        </div>
                    </div>
                ` : `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editPassengerBirthday">تاریخ تولد</label>
                                <input type="text" class="form-control" id="editPassengerBirthday" value="${passenger.passenger_birthday || ''}" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editMemberEmail">ایمیل</label>
                                <input type="email" class="form-control" id="editMemberEmail" value="${passenger.member_email || ''}">
                            </div>
                        </div>
                    </div>
                `}
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">
                انصراف
            </button>
            <button type="button" class="btn btn-primary" onclick="savePassengerEdit()">
                <i class="fa fa-save"></i> 
                ذخیره تغییرات
            </button>
        </div>
    `;
    
    document.getElementById('ModalPublic').innerHTML = modalContent;
}

// Function to save passenger edit
function savePassengerEdit() {
    const recordId = document.getElementById('editRecordId').value;
    const recordType = document.getElementById('editRecordType').value;
    
    // Collect form data
    const passengerData = {
        passenger_name: document.getElementById('editPassengerName').value,
        passenger_family: document.getElementById('editPassengerFamily').value,
        passenger_national_code: document.getElementById('editPassengerNationalCode').value,
        passportNumber: document.getElementById('editPassportNumber').value,
        passenger_type: document.getElementById('editPassengerType').value,
        passenger_gender: document.getElementById('editPassengerGender').value,
        member_phone: document.getElementById('editMemberPhone').value
    };
    
    // Add type-specific fields
    if (recordType === 'manifest') {
        passengerData.ticket_number = document.getElementById('editTicketNumber').value;
    } else if (recordType === 'book') {
        passengerData.passenger_birthday = document.getElementById('editPassengerBirthday').value;
        passengerData.member_email = document.getElementById('editMemberEmail').value;
    }
    
    // Validate required fields
    if (!passengerData.passenger_name || !passengerData.passenger_family) {
        $.toast({
            heading: 'خطا در ویرایش',
            text: 'نام و نام خانوادگی مسافر الزامی است',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'error',
            hideAfter: 3500,
            textAlign: 'right',
            stack: 6
        });
        return;
    }
    
    // Show loading state
    const saveButton = document.querySelector('.modal-footer .btn-primary');
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> در حال ذخیره...';
    saveButton.disabled = true;
    
    // Send update request
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'updatePassenger',
            record_id: recordId,
            record_type: recordType,
            passenger_data: passengerData,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.data.status) {
                let successMessage = response.data.message;
                
                // Add sync information for book records
                if (recordType === 'book') {
                    successMessage += ' (همگام‌سازی با جدول گزارش انجام شد)';
                }
                
                $.toast({
                    heading: 'ویرایش مسافر',
                    text: successMessage,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 4000,
                    textAlign: 'right',
                    stack: 6
                });
                
                // Close modal
                $('#ModalPublic').modal('hide');
                
                // Refresh the flight details modal
                setTimeout(() => {
                    // You might want to refresh the current flight details here
                    // For now, just show a success message
                }, 1000);
                
            } else {
                $.toast({
                    heading: 'خطا در ویرایش',
                    text: response.message || 'خطا در بروزرسانی اطلاعات',
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
                heading: 'خطا در ویرایش',
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
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        }
    });
}

// Function to show edit passenger error
function showEditPassengerError(errorMessage) {
    const modalContent = `
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="fa fa-exclamation-triangle"></i>
                خطا
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i>
                ${errorMessage}
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                بستن
            </button>
        </div>
    `;
    
    document.getElementById('ModalPublic').innerHTML = modalContent;
}

