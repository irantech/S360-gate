$(document).ready(function () {



    // Check if we're on the upload page and initialize upload functionality
    if ($('#uploadManifestForm').length > 0) {
        console.log('awd')
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
    document.getElementById('ModalPublicContent').innerHTML = modalContent;

    // Show modal using Bootstrap's modal API
    $('#ModalPublic').modal('show');
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
        if (!$(event.target).closest("#ModalPublicContent").length && !$(event.target).closest(".btn-passenger-modal").length) {
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

    validationSection.removeClass('error').addClass('success');

    let content = `
        <div class="success-header-official">
            <div class="success-status">
                <div class="success-status-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="success-status-text">
                    <h5>آپلود مانیفست با موفقیت انجام شد</h5>
                    <p>فایل مانیفست با موفقیت پردازش و ذخیره شد</p>
                </div>
            </div>
            <div class="success-meta">
                <div class="success-meta-item">
                    <span class="meta-label">تاریخ آپلود:</span>
                    <span class="meta-value">${new Date().toLocaleDateString('fa-IR')}</span>
                </div>
            </div>
        </div>
    `;

    if (response.stats) {
        content += `
            <div class="success-summary-official">
                <h6>خلاصه آپلود</h6>
                <div class="summary-table">
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-file-alt"></i>
                            <span>نام فایل</span>
                        </div>
                        <div class="summary-cell value">
                            ${response.stats.file_name}
                        </div>
                    </div>
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-database"></i>
                            <span>رکوردهای پردازش شده</span>
                        </div>
                        <div class="summary-cell value">
                            ${response.stats.total_processed}
                        </div>
                    </div>
                    ${response.stats.total_original ? `
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-list"></i>
                            <span>کل رکوردهای فایل</span>
                        </div>
                        <div class="summary-cell value">
                            ${response.stats.total_original}
                        </div>
                    </div>
                    ` : ''}
                    ${response.stats.skipped_duplicates > 0 ? `
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-times-circle"></i>
                            <span>رکوردهای رد شده (تکراری)</span>
                        </div>
                        <div class="summary-cell value skipped">
                            ${response.stats.skipped_duplicates}
                        </div>
                    </div>
                    ` : ''}
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-hdd"></i>
                            <span>حجم فایل</span>
                        </div>
                        <div class="summary-cell value">
                            ${response.stats.file_size}
                        </div>
                    </div>
                    ${response.stats.warnings_count > 0 ? `
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-exclamation-triangle"></i>
                            <span>هشدارها</span>
                        </div>
                        <div class="summary-cell value warning">
                            ${response.stats.warnings_count} مورد
                        </div>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
    }

    // Add success details in code format
    const successLines = response.message.split('\n');
    if (successLines.length > 1) {
        content += `
            <div class="success-details-official">
                <h6>جزئیات پردازش</h6>
                <div class="success-code-block">
                    <div class="code-header">
                        <span class="code-title">فایل مانیفست - نتایج پردازش</span>
                        <span class="code-lang">Manifest Processing Results</span>
                    </div>
                    <pre class="success-code"><code>${generateSuccessCode(successLines)}</code></pre>
                </div>
            </div>
        `;
    }

    // Add note about duplicate handling if any duplicates were skipped
    if (response.stats && response.stats.skipped_duplicates > 0) {
        content += `
            <div class="success-actions-official">
                <h6>نکته مهم</h6>
                <div class="action-list">
                    <div class="action-item">
                        <div class="action-number">!</div>
                        <div class="action-text">رکوردهای تکراری به طور خودکار رد شدند و فقط رکوردهای جدید در سیستم ثبت شدند</div>
                    </div>
                    <div class="action-item">
                        <div class="action-number">!</div>
                        <div class="action-text">برای مشاهده جزئیات رکوردهای رد شده، بخش هشدارها را بررسی کنید</div>
                    </div>
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

    // Check if this is a structured duplicate error response
    if (response.message && response.message.startsWith('{')) {
        try {
            const errorData = JSON.parse(response.message);
            if (errorData.type === 'duplicate_validation_error') {
                showStructuredDuplicateError(errorData);
                return;
            }
        } catch (e) {
            // If JSON parsing fails, treat as regular error
        }
    }

    // Handle regular error messages
    const errorLines = response.message.split('\n');
    let content = `
        <div class="error-header-official">
            <div class="error-status">
                <div class="error-status-icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div class="error-status-text">
                    <h5>خطا در پردازش فایل مانیفست</h5>
                    <p>فایل آپلود شده دارای مشکلات اعتبارسنجی است</p>
                </div>
            </div>
            <div class="error-meta">
                <div class="error-meta-item">
                    <span class="meta-label">تاریخ بررسی:</span>
                    <span class="meta-value">${new Date().toLocaleDateString('fa-IR')}</span>
                </div>
            </div>
        </div>
    `;

    // Add error details in code format
    if (errorLines.length > 1) {
        content += `
            <div class="error-details-official">
                <h6>جزئیات خطاها</h6>
                <div class="error-code-block">
                    <div class="code-header">
                        <span class="code-title">فایل مانیفست - خطاهای اعتبارسنجی</span>
                        <span class="code-lang">Manifest Validation Errors</span>
                    </div>
                    <pre class="error-code"><code>${generateRegularErrorCode(errorLines)}</code></pre>
                </div>
            </div>
        `;
    } else {
        content += `
            <div class="error-details-official">
                <h6>جزئیات خطا</h6>
                <div class="error-code-block">
                    <div class="code-header">
                        <span class="code-title">فایل مانیفست - خطای اعتبارسنجی</span>
                        <span class="code-lang">Manifest Validation Error</span>
                    </div>
                    <pre class="error-code"><code>${response.message}</code></pre>
                </div>
            </div>
        `;
    }

    // Add help text based on error type
    if (response.error_type === 'validation_error') {
        content += `
            <div class="error-actions-official">
                <h6>اقدامات لازم</h6>
                <div class="action-list">
                    <div class="action-item">
                        <div class="action-number">1</div>
                        <div class="action-text">بررسی کنید که تاریخ، مسیر و کد ایرلاین وارد شده با محتوای فایل مطابقت داشته باشد</div>
                    </div>
                    <div class="action-item">
                        <div class="action-number">2</div>
                        <div class="action-text">فرمت فایل باید .txt و محتوای آن CSV باشد</div>
                    </div>
                    <div class="action-item">
                        <div class="action-number">3</div>
                        <div class="action-text">هر خط باید حداقل 11 ستون داشته باشد</div>
                    </div>
                    <div class="action-item">
                        <div class="action-number">4</div>
                        <div class="action-text">فرمت تاریخ در فایل باید YY/MM/DD باشد</div>
                    </div>
                </div>
            </div>
        `;
    }

    validationContent.html(content);
    validationSection.show();

    // Auto-scroll to results
    validationSection[0].scrollIntoView({ behavior: 'smooth' });
}

function showStructuredDuplicateError(errorData) {
    const validationSection = $('#validation-results');
    const validationContent = $('#validation-content');

    validationSection.addClass('error');

    // Create official error header
    let content = `
        <div class="error-header-official">
            <div class="error-status">
                <div class="error-status-icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div class="error-status-text">
                    <h5>خطا در اعتبارسنجی مانیفست</h5>
                    <p>موارد تکراری در فایل آپلود شده یافت شد</p>
                </div>
            </div>
            <div class="error-meta">
                <div class="error-meta-item">
                    <span class="meta-label">تعداد کل خطاها:</span>
                    <span class="meta-value">${errorData.total_duplicates}</span>
                </div>
                <div class="error-meta-item">
                    <span class="meta-label">تاریخ بررسی:</span>
                    <span class="meta-value">${new Date().toLocaleDateString('fa-IR')}</span>
                </div>
            </div>
        </div>
    `;

    // Add summary statistics in a clean format
    if (errorData.summary) {
        content += `
            <div class="error-summary-official">
                <h6>خلاصه خطاها</h6>
                <div class="summary-table">
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-id-card"></i>
                            <span>کد ملی تکراری</span>
                        </div>
                        <div class="summary-cell count ${errorData.summary.national_id_duplicates > 0 ? 'has-error' : ''}">
                            ${errorData.summary.national_id_duplicates}
                        </div>
                    </div>
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-ticket-alt"></i>
                            <span>شماره بلیت تکراری</span>
                        </div>
                        <div class="summary-cell count ${errorData.summary.ticket_duplicates > 0 ? 'has-error' : ''}">
                            ${errorData.summary.ticket_duplicates}
                        </div>
                    </div>
                    <div class="summary-row">
                        <div class="summary-cell">
                            <i class="fa fa-user"></i>
                            <span>نام تکراری</span>
                        </div>
                        <div class="summary-cell count ${errorData.summary.name_duplicates > 0 ? 'has-error' : ''}">
                            ${errorData.summary.name_duplicates}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Add detailed error list in code format
    if (errorData.duplicates && errorData.duplicates.length > 0) {
        content += `
            <div class="error-details-official">
                <h6>جزئیات خطاها</h6>
                <div class="error-code-block">
                    <div class="code-header">
                        <span class="code-title">فایل مانیفست - خطاهای اعتبارسنجی</span>
                        <span class="code-lang">Manifest Validation Errors</span>
                    </div>
                    <pre class="error-code"><code>${generateErrorCode(errorData.duplicates)}</code></pre>
                </div>
            </div>
        `;
    }

    // Add action section
    content += `
        <div class="error-actions-official">
            <h6>اقدامات لازم</h6>
            <div class="action-list">
                <div class="action-item">
                    <div class="action-number">1</div>
                    <div class="action-text">مسافران تکراری را از فایل مانیفست حذف کنید</div>
                </div>
                <div class="action-item">
                    <div class="action-number">2</div>
                    <div class="action-text">اطمینان حاصل کنید که کد ملی و شماره بلیت منحصر به فرد باشند</div>
                </div>
                <div class="action-item">
                    <div class="action-number">3</div>
                    <div class="action-text">بررسی کنید که مسافران قبلاً در سیستم ثبت نشده باشند</div>
                </div>
                <div class="action-item">
                    <div class="action-number">4</div>
                    <div class="action-text">فایل اصلاح شده را مجدداً آپلود کنید</div>
                </div>
            </div>
        </div>
    `;

    validationContent.html(content);
    validationSection.show();

    // Auto-scroll to results
    validationSection[0].scrollIntoView({ behavior: 'smooth' });
}

function generateErrorCode(duplicates) {
    let code = '';
    
    duplicates.forEach((duplicate, index) => {
        code += `// خطای شماره ${index + 1}\n`;
        code += `مسافر: ${duplicate.passenger_family} ${duplicate.passenger_name}\n`;
        
        if (duplicate.duplicate_types && duplicate.duplicate_types.length > 0) {
            code += `موارد تکراری:\n`;
            duplicate.duplicate_types.forEach(type => {
                const identifier = type === 'national_id' ? duplicate.national_id : 
                                 type === 'ticket' ? duplicate.ticket_number : '';
                const label = type === 'national_id' ? 'کد ملی' :
                             type === 'ticket' ? 'شماره بلیت' : 'نام و نام خانوادگی';
                code += `  - ${label}: ${identifier || 'نامشخص'}\n`;
            });
        } else if (duplicate.type) {
            const identifier = duplicate.identifier || '';
            const label = getIdentifierLabel(duplicate.type);
            code += `${label}: ${identifier}\n`;
        }
        
        if (duplicate.upload_timestamp) {
            code += `تاریخ آپلود قبلی: ${duplicate.upload_timestamp}\n`;
        }
        
        if (duplicate.line_numbers) {
            code += `خطوط فایل: ${duplicate.line_numbers}\n`;
        }
        
        code += '\n';
    });
    
    return code;
}

function generateRegularErrorCode(errorLines) {
    let code = '';
    
    errorLines.forEach((line, index) => {
        if (line.trim()) {
            if (index === 0) {
                // First line is usually the main error title
                code += `// ${line.trim()}\n`;
            } else {
                // Subsequent lines are detailed errors
                code += `${line.trim()}\n`;
            }
        }
    });
    
    return code;
}

function generateSuccessCode(successLines) {
    let code = '';
    
    successLines.forEach((line, index) => {
        if (line.trim()) {
            if (index === 0) {
                // First line is usually the main success message
                code += `// ${line.trim()}\n`;
            } else {
                // Subsequent lines are details
                code += `${line.trim()}\n`;
            }
        }
    });
    
    return code;
}

function getDuplicateTypeIcon(type) {
    switch (type) {
        case 'national_id':
        case 'file_national_id':
            return 'fa fa-id-card';
        case 'ticket':
        case 'file_ticket':
            return 'fa fa-ticket-alt';
        case 'name':
            return 'fa fa-user';
        default:
            return 'fa fa-exclamation-triangle';
    }
}

function getDuplicateTypeLabel(type) {
    switch (type) {
        case 'national_id':
            return 'کد ملی تکراری در سیستم';
        case 'file_national_id':
            return 'کد ملی تکراری در فایل';
        case 'ticket':
            return 'شماره بلیت تکراری در سیستم';
        case 'file_ticket':
            return 'شماره بلیت تکراری در فایل';
        case 'name':
            return 'نام تکراری در سیستم';
        default:
            return 'مورد تکراری';
    }
}

function getIdentifierLabel(type) {
    switch (type) {
        case 'national_id':
        case 'file_national_id':
            return 'کد ملی';
        case 'ticket':
        case 'file_ticket':
            return 'شماره بلیت';
        default:
            return 'شناسه';
    }
}



$(document).ready(function() {
    // Initialize cascading dropdowns
    initializeCascadingDropdowns();

    // Form validation function
    function validateForm() {
        var date = $('#manifest_date').val();
        var route = $('#route').val();
        var airline = $('#airline_iata').val();
        var file = $('#manifest_file').val();

        if (date && route && airline && file) {
            $('#uploadButton').prop('disabled', false);
        } else {
            $('#uploadButton').prop('disabled', true);
        }
    }

    // File input change handler
    $('#manifest_file').on('change', function() {
        validateForm();
    });

    // Add visual feedback for dropdowns
    $('.form-control-agency').on('focus', function() {
        $(this).addClass('focused');
    }).on('blur', function() {
        $(this).removeClass('focused');
    });

    // Cascading dropdown functionality
    function initializeCascadingDropdowns() {
        // Date change handler
        $('#manifest_date').on('change', function() {
            var selectedDate = $(this).val();

            // Reset route and airline dropdowns
            $('#route').html('<option value="">انتخاب مسیر پرواز</option>').prop('disabled', true);
            $('#airline_iata').html('<option value="">ابتدا مسیر را انتخاب کنید</option>').prop('disabled', true);

            if (selectedDate) {
                // Show loading state for route dropdown
                $('#route').html('<option value="">در حال بارگذاری...</option>');

                // Fetch routes for selected date using proper AJAX format
                $.ajax({
                    type: "post",
                    url: `${amadeusPath}ajax`,
                    data: JSON.stringify({
                        className: 'manifestController',
                        method: 'ajaxGetRoutesByDate',
                        date: selectedDate,
                        to_json: true
                    }),
                    contentType: "application/json",
                    success: function(response) {
                        if (response.status && response.data.success && response.data.routes && response.data.routes.length > 0) {
                            var routeOptions = '<option value="">انتخاب مسیر پرواز</option>';
                            $.each(response.data.routes, function(index, route) {
                                routeOptions += '<option value="' + route.value + '">' + route.label + '</option>';
                            });
                            $('#route').html(routeOptions).prop('disabled', false);
                        } else {
                            $('#route').html('<option value="">هیچ مسیری برای این تاریخ یافت نشد</option>').prop('disabled', true);
                        }
                    },
                    error: function() {
                        $('#route').html('<option value="">خطا در بارگذاری مسیرها</option>').prop('disabled', true);
                    }
                });
            }

            validateForm();
        });

        // Route change handler
        $('#route').on('change', function() {
            var selectedDate = $('#manifest_date').val();
            var selectedRoute = $(this).val();

            // Reset airline dropdown
            $('#airline_iata').html('<option value="">انتخاب ایرلاین</option>').prop('disabled', true);

            if (selectedRoute) {
                // Show loading state for airline dropdown
                $('#airline_iata').html('<option value="">در حال بارگذاری...</option>');

                // Fetch airlines for selected date and route using proper AJAX format
                $.ajax({
                    type: "post",
                    url: `${amadeusPath}ajax`,
                    data: JSON.stringify({
                        className: 'manifestController',
                        method: 'ajaxGetAirlinesByDateAndRoute',
                        date: selectedDate,
                        route: selectedRoute,
                        to_json: true
                    }),
                    contentType: "application/json",
                    success: function(response) {
                        if (response.status && response.data.success && response.data.airlines && response.data.airlines.length > 0) {
                            var airlineOptions = '<option value="">انتخاب ایرلاین</option>';
                            $.each(response.data.airlines, function(index, airline) {
                                airlineOptions += '<option value="' + airline.value + '">' + airline.airline_name+'('+airline.flight_number+')- کلاس '+airline.vehicle_grade+'- ظرفیت '+ airline.capacity+ ' - ساعت '+airline.exit_hour+'</option>';
                            });
                            $('#airline_iata').html(airlineOptions).prop('disabled', false);
                        } else {
                            $('#airline_iata').html('<option value="">هیچ ایرلاینی برای این مسیر یافت نشد</option>').prop('disabled', true);
                        }
                    },
                    error: function() {
                        $('#airline_iata').html('<option value="">خطا در بارگذاری ایرلاین‌ها</option>').prop('disabled', true);
                    }
                });
            }

            validateForm();
        });

        // Airline change handler
       /* $('#airline_iata').on('change', function() {
            validateForm();
            var selectedAirline = $(this).val();
            var selectedRoute = $('#route').val();
            var selectedDate = $('#manifest_date').val();
            if (selectedAirline && selectedRoute && selectedDate) {
                loadAgencyPassengers(selectedDate, selectedRoute, selectedAirline);
            } else {
                hidePassengersSection();
            }
        });*/
    }


    // Helper functions for showing messages
    function showSuccessMessage(message) {
        // You can implement your preferred notification system here
        alert('موفقیت: ' + message);
    }

    function showErrorMessage(message) {
        // You can implement your preferred notification system here
        alert('خطا: ' + message);
    }
});
function hidePassengersSection() {
    $('#agency-passengers-section').hide();
}
function showPassengersLoading() {
    var $section = $('#agency-passengers-section');
    var $content = $('#passengers-content');

    $content.html(`
        <div class="passengers-loading-agency">
            <i class="fa fa-spinner fa-spin"></i>
            <div>در حال بارگذاری مسافران...</div>
        </div>
    `);

    $section.show();
}

function getPassengerTypeText(type) {
    switch(type) {
        case 'ADL': return 'بزرگسال';
        case 'CHD': return 'کودک';
        case 'INF': return 'نوزاد';
        default: return type;
    }
}

function getGenderText(gender) {
    switch(gender) {
        case 'MR': return 'آقا';
        case 'MRS': return 'خانم';
        default: return gender || '-';
    }
}
function loadAgencyPassengers(ticket_id) {
    // Show loading state
    showPassengersLoading();
    $.ajax({
        type: 'POST',
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'ajaxGetAgencyPassengers',
            ticket_id: ticket_id,
            to_json: true
        }),
        success: function(response) {
            try {
                var data = (response.data);
                console.log('data',data)
                if (data.success) {
                    displayPassengers(data.passengers);
                } else {
                    showPassengersError('خطا در بارگذاری مسافران: ' + data.message);
                }
            } catch (e) {
                showPassengersError('خطا در پردازش پاسخ: ' + e.message);
            }
        },
        error: function() {
            showPassengersError('خطا در ارتباط با سرور');
        }
    });
}
function showPassengersError(message) {
    var $section = $('#agency-passengers-section');
    var $content = $('#passengers-content');

    $content.html(`
        <div class="no-passengers-agency">
            <i class="fa fa-exclamation-triangle"></i>
            <h6>خطا در بارگذاری</h6>
            <p>${message}</p>
        </div>
    `);

    $section.show();
}
function displayPassengers(passengers) {
    var $section = $('#agency-passengers-section');
    var $content = $('#passengers-content');
    var $count = $('#passengers-count');

    // Update count
   // $count.text(passengers.length + ' مسافر');

    if (passengers.length === 0) {
        $content.html(`
            <div class="no-passengers-agency">
                <i class="fa fa-users"></i>
                <p>هنوز مسافری برای این پرواز آپلود نشده است</p>
            </div>
        `);
    } else {
        // Create official table design
        var tableHtml = `
            <table class="passenger-list-table OutSerach">
                <thead>
                    <tr>
                        <th colspan="7">لیست مسافران آپلود شده</th>
                    </tr>
                    <tr>
                        <th>نام و نام خانوادگی</th>
                        <th>کد ملی</th>
                        <th>شماره بلیت</th>
                        <th>نوع مسافر</th>
                        <th>جنسیت</th>
                        <th>تلفن</th>
                        <th>تاریخ آپلود</th>
                    </tr>
                </thead>
                <tbody>
        `;

        passengers.forEach(function(passenger) {
            var passengerTypeText = getPassengerTypeText(passenger.passenger_type);
            var genderText = getGenderText(passenger.gender);

            tableHtml += `
                <tr>
                    <td>${passenger.passenger_family} ${passenger.passenger_name}</td>
                    <td>${passenger.national_id || '-'}</td>
                    <td>${passenger.ticket_number || '-'}</td>
                    <td>${passengerTypeText}</td>
                    <td>${genderText}</td>
                    <td>${passenger.phone_number || '-'}</td>
                    <td>${passenger.formatted_date || '-'}</td>
                </tr>
            `;
        });

        tableHtml += `
                </tbody>
            </table>
        `;

        $content.html(tableHtml);
    }

    $section.show();
}
// File upload drag and drop functionality
function chooseUploadType(event) {
    event.preventDefault(); // جلوگیری از باز شدن مستقیم input
    document.getElementById("uploadTypeModal").style.display = "flex";
}

function closeUploadTypeModal() {
    document.getElementById("uploadTypeModal").style.display = "none";
}

function selectUploadType(type) {
    closeUploadTypeModal();

    // در اینجا می‌توانی نوع انتخاب شده را در متغیر ذخیره کنی اگر لازم است
    console.log("نوع انتخاب شده:", type);

    // بعد از انتخاب معتبر، باکس انتخاب فایل باز شود
    document.getElementById("manifest_file").click();
}


function dropHandlerUploadManifest(event) {
    event.preventDefault();
    event.stopPropagation();

    var files = event.dataTransfer.files;
    if (files.length > 0) {
        $('#manifest_file')[0].files = files;
        updateFilePreview(files[0]);
    }

    $('#drop_zone').removeClass('dragover');
}

function dragOverHandlerUploadManifest(event) {
    event.preventDefault();
    event.stopPropagation();
    $('#drop_zone').addClass('dragover');
}

function dragLeaveHandlerUploadManifest(event) {
    event.preventDefault();
    event.stopPropagation();
    $('#drop_zone').removeClass('dragover');
}


function updateFilePreview(file) {
    var preview = $('#preview-gallery');
    var fileSize = (file.size / 1024 / 1024).toFixed(2);

    var previewHtml = `
        <div class="manifest-file-preview-agency">
            <div class="file-icon-agency">
                <i class="fa fa-file-text"></i>
            </div>
            <div class="file-info-agency">
                <div class="file-name-agency">${file.name}</div>
                <div class="file-details-agency">حجم: ${fileSize} MB</div>
            </div>
            <div class="file-actions-agency">
                <button type="button" class="btn-remove-file-agency" onclick="removeFile()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    `;

    preview.html(previewHtml).show();
}

function removeFile() {
    $('#manifest_file').val('');
    $('#preview-gallery').hide();
    validateForm();
}

