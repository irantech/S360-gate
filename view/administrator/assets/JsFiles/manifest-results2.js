// Manifest Results 2 - JavaScript File
// Global variables
let selectedRows = new Set();
let allFlightsData = {};
let currentPage = 1;
let currentPerPage = 20;
let selectedTickets = []; // آرایه برای تمام چک‌باکس‌های انتخاب شده
let activeModalSource = null;
let ticket_id_ForExcelNira='';
// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    updateRecordCount();
    setupEventListeners();

    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    if (dateFrom) dateFrom.value = todayJalali;
    if (dateTo) dateTo.value = tomorrowJalali;
});

$(window).on('load', function() {
    setTimeout(function() {
        $('.dataTables_scrollHeadInner').css('width', '100%');
    }, 500);
});

// Update record count
function updateRecordCount() {
    const rowCount = document.querySelectorAll('.flight-row').length;
    const recordCountElement = document.getElementById('recordCount');
    if (recordCountElement) {
        recordCountElement.textContent = rowCount;
    }
}

function populateSelect(selectId, values) {
    const select = document.getElementById(selectId);
    if (!select) return;
    
    values.forEach(value => {
        const option = document.createElement('option');
        option.value = value;
        option.textContent = value;
        select.appendChild(option);
    });
}

// Setup event listeners
function setupEventListeners() {
    // Row selection
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedRows.add(this.value);
            } else {
                selectedRows.delete(this.value);
            }
            updateSelectionUI();
        });
    });

}

// Toggle select all
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    if (!selectAllCheckbox) return;
    
    rowCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
        if (selectAllCheckbox.checked) {
            selectedRows.add(checkbox.value);
        } else {
            selectedRows.delete(checkbox.value);
        }
    });
    
    updateSelectionUI();
}

// Update selection UI
function updateSelectionUI() {
    const selectedCount = selectedRows.size;
    const totalCount = document.querySelectorAll('.row-checkbox').length;
    const recordCountElement = document.querySelector('.record-count');
    
    if (recordCountElement && selectedCount > 0) {
        recordCountElement.innerHTML = 
            `تعداد رکورد: <strong>${totalCount}</strong> | انتخاب شده: <strong class="text-primary">${selectedCount}</strong>`;
    } else {
        updateRecordCount();
    }
}

// Expand all rows
function expandAllRows() {
    // This would expand any collapsible content if implemented
    console.log('Expand all rows');
}

// Collapse all rows
function collapseAllRows() {
    // This would collapse any expanded content if implemented
    console.log('Collapse all rows');
}

// Show flight details   status  capacity
function showFlightDetails(ticket_id) {
    // Show loading state
    const loadingContent = `
        <div class="flight-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری جزئیات پرواز...</p>
        </div>
    `;
    $('#flightDetailsContent').html(loadingContent);
    $('#flightDetailsModal').modal('show');
    ticket_id_ForExcelNira=ticket_id;
    // Load flight details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightDetails',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            console.log('response', response);
            if (response.status && response.data.data) {
                const flightDetails = response.data.data;
                console.log('flightDetails',flightDetails)


                renderFlightDetailsModal(flightDetails);
            } else {
                showErrorModal('خطا در بارگذاری جزئیات پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
function showFlightStatus(ticket_id) {
    // عنوان مودال
    $('#globalOperationTitle').text('وضعیت پرواز');
    // Show loading state
    const loadingContent = `
        <div class="flight-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری وضعیت پرواز...</p>
        </div>
    `;
    $('#globalOperationContent').html(loadingContent);
    $('#globalOperationModal').modal('show');

    // Load flight details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightStatus',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                const flightStatus = response.data.data; // مقدار فعلی از دیتابیس
                const statusContent = `
                    <div class="form-group text-right ">
                        <select id="flightStatusSelect" class="form-control">
                            <option value="none" ${!flightStatus || flightStatus === 'none' ? 'selected' : ''}>-- انتخاب کنید --</option>
                            <option value="Cancelled" ${flightStatus === 'Cancelled' ? 'selected' : ''}>کنسلی</option>
                            <option value="Blocked" ${flightStatus === 'Blocked' ? 'selected' : ''}>مسدودی</option>
                            <option value="Actived" ${flightStatus === 'Actived' ? 'selected' : ''}>فعال</option>
                        </select>
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-success btn-block" onclick="saveFlightStatus('${ticket_id}')">
                            <i class="fa fa-save"></i> ذخیره
                        </button>
                    </div>
                `;

                $('#globalOperationContent').html(statusContent);
            } else {
                showErrorModal('خطا در بارگذاری وضعیت پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
function saveFlightStatus(ticket_id) {
    const newStatus = $('#flightStatusSelect').val();

    if (!newStatus) {
        alert('لطفاً یک وضعیت انتخاب کنید.');
        return;
    }

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'setFlightStatus',
            ticket_id: ticket_id,
            status: newStatus,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                // نمایش پیام موفقیت در مودال
                $('#globalOperationContent').html(`
                    <div class="text-center">
                        <i class="fa fa-check-circle text-success fa-2x"></i>
                        <p>${response.message || 'وضعیت پرواز با موفقیت ذخیره شد.'}</p>
                    </div>
                `);

                // بعد از 2 ثانیه: مودال بسته شود و جدول دوباره بارگذاری شود
                setTimeout(function() {
                    $('#globalOperationModal').modal('hide');

                    // بارگذاری مجدد جدول با اعمال فیلترهای فعلی
                    loadManifestData();
                }, 1000);
            } else {
                showErrorModal(response.message || 'خطا در ذخیره وضعیت پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
function ShowTotalFlightCapacity(ticket_id) {
    $('#globalOperationTitle').text('ویرایش ظرفیت کل پرواز');

    const loadingContent = `
        <div class="flight-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری اطلاعات...</p>
        </div>
    `;
    $('#globalOperationContent').html(loadingContent);
    $('#globalOperationModal').modal('show');

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getTotalFlightCapacity',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                const totalCapacity = parseInt(response.data.data.capacity) || 0;
                const reservedCount = parseInt(response.data.data.reserved_count) || 0;

                const capacityContent = `
                    <div style="text-align:right;">ظرفیت کل فعلی: <strong>${totalCapacity}</strong></div>
                    <div class="form-group text-right d-flex align-items-center mt-2">
                        <button class="btn btn-secondary btn-sm mr-2" id="decreaseDelta">-</button>
                        <input type="number" id="capacityDeltaInput" 
                               class="form-control text-center"
                               value="0" 
                               style="width:80px">
                        <button class="btn btn-secondary btn-sm ml-2" id="increaseDelta">+</button>
                        <small class="text-muted ml-3" style="font-size: 11px;">رزروهای فعلی: ${reservedCount}</small>
                    </div>
                    <div class="form-group text-right mt-2">
                        <button class="btn btn-success btn-block" 
                                onclick="saveTotalFlightCapacity('${ticket_id}', ${reservedCount})">
                            <i class="fa fa-save"></i> ذخیره
                        </button>
                    </div>
                `;
                $('#globalOperationContent').html(capacityContent);

                $('#increaseDelta').click(function() {
                    let current = parseInt($('#capacityDeltaInput').val());
                    $('#capacityDeltaInput').val(current + 1);
                });

                $('#decreaseDelta').click(function() {
                    let current = parseInt($('#capacityDeltaInput').val());
                    $('#capacityDeltaInput').val(current - 1);
                });

            } else {
                showErrorModal('خطا در بارگذاری اطلاعات.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
function saveTotalFlightCapacity(ticket_id, reservedCount) {
    const delta = parseInt($('#capacityDeltaInput').val()) || 0; // تغییرات وارد شده
    const currentCapacity = parseInt($('#globalOperationContent strong').text()) || 0;
    const newCapacity = currentCapacity + delta;

    if (newCapacity < reservedCount) {
        alert(`ظرفیت نمی‌تواند کمتر از تعداد رزروهای انجام شده (${reservedCount}) باشد.`);
        return;
    }

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'updateTotalFlightCapacity',
            ticket_id: ticket_id,
            delta: delta, // ارسال delta به سرور
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                $('#globalOperationContent').html(`
                    <div class="alert alert-success text-center">
                        ${response.message || 'عملیات با موفقیت انجام شد'}
                    </div>
                `);

                setTimeout(function() {
                    $('#globalOperationModal').modal('hide');
                    loadManifestData();
                }, 1000);
            } else {
                showErrorModal(response.message || 'خطا در ذخیره ظرفیت کل پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}

function ShowStatusManifest(ticket_id) {
    // عنوان مودال
    $('#globalOperationTitle').text('وضعیت مانیفست');
    // Show loading state
    const loadingContent = `
        <div class="flight-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری وضعیت مانیفست...</p>
        </div>
    `;
    $('#globalOperationContent').html(loadingContent);
    $('#globalOperationModal').modal('show');

    // Load flight details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightManifestStatus',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                const status_manifest = response.data.data; // مقدار فعلی از دیتابیس
                const statusContent = `
                    <div class="form-group text-right ">
                        <label class="switch">
                            <input type="checkbox" id="manifestStatusToggle" ${status_manifest == 1 ? 'checked' : ''}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    
                    <div class="form-group text-right">
                        <button class="btn btn-success btn-block" onclick="saveFlightManifestStatus('${ticket_id}')">
                            <i class="fa fa-save"></i> ارسال شود
                        </button>
                    </div>
                `;

                $('#globalOperationContent').html(statusContent);
            } else {
                showErrorModal('خطا در بارگذاری وضعیت مانیفست.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
function saveFlightManifestStatus(ticket_id) {
    const newManifestStatus = $('#manifestStatusToggle').is(':checked') ? 1 : 0;
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'setFlightManifestStatus',
            ticket_id: ticket_id,
            status_manifest: newManifestStatus,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                // نمایش پیام موفقیت در مودال
                $('#globalOperationContent').html(`
                    <div class="text-center">
                        <i class="fa fa-check-circle text-success fa-2x"></i>
                        <p>${response.message || 'وضعیت مانیفست با موفقیت ذخیره شد.'}</p>
                    </div>
                `);

                // بعد از 2 ثانیه: مودال بسته شود و جدول دوباره بارگذاری شود
                setTimeout(function() {
                    $('#globalOperationModal').modal('hide');

                    // بارگذاری مجدد جدول با اعمال فیلترهای فعلی
                    loadManifestData();
                }, 1000);
            } else {
                showErrorModal(response.message || 'خطا در ذخیره وضعیت مانیفست.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}

function EditFlightSchedule(ticket_id) {
    // عنوان مودال
    $('#globalOperationTitle').text('ویرایش برنامه پروازی');
    // Show loading state
    const loadingContent = `
        <div class="flight-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری اطلاعات پایه برنامه پرواز...</p>
        </div>
    `;
    $('#globalOperationContent').html(loadingContent);
    $('#globalOperationModal .modal-dialog').addClass('modal-xl');
    $('#globalOperationModal').modal('show');

    // Load flight details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightSchedule',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status === "success" && response.data && response.data.status) {
                const info_parvaz = response.data.data;

                // ساخت options برای فروشنده
                let agencyOptions = agencies.map(a =>
                   `<option value="${a.id}" ${a.id == info_parvaz.SellerId ? 'selected' : ''}>${a.name}</option>`
                ).join('');

                // فیلتر کردن فقط نوع هواپیماهایی که با TypeOfVehicleId یکی هستند
                let airplaneOptions = TypeOfPlanes
                   .filter(p => p.id_vehicle == info_parvaz.TypeOfVehicleId)
                   .map(p =>
                      `<option value="${p.id}" ${p.id == info_parvaz.TypeOfPlane ? 'selected' : ''}>
                            ${p.name} (${p.abbreviation})
                        </option>`
                   )
                   .join('');

                // ساخت HTML دراپ‌داون برای شماره پرواز (قرار می‌دیم داخل Content)
                const flyCodeDropdownHtml = `
                    <div class="filter-group" style="position: relative; width: 100%;">
                        <label for="flyCodeFilter">شماره پرواز:</label>
                    
                        <div class="dropdown">
                            <div class="form-control filter-select dropdown-toggle d-flex justify-content-between align-items-center"
                                 id="flyCodeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                 role="button" style="padding: 0.75rem 1rem !important;">
                                <span id="flyCodeDropdownText">انتخاب کنید</span>
                                <i class="fa fa-chevron-down small" aria-hidden="true"></i>
                            </div>
                    
                            <div class="dropdown-menu w-100 p-2" aria-labelledby="flyCodeDropdown"
                                 style="max-height:260px; overflow-y:auto;">
                                <input type="text" id="flyCodeSearchInput" class="form-control form-control-sm mb-2"
                                       placeholder="جستجو یا شماره جدید...">
                                <ul id="flyCode_list" class="list-unstyled mb-0"></ul>
                            </div>
                        </div>
                    
                        <input type="hidden" name="flyCode_idModal" id="flyCode_idModal">
                        <input type="hidden" name="flyCode_textModal" id="flyCode_textModal">
                    </div>
                    `;


                const Content = `
                        <div class="row">
                            <div class="form-group text-right col-md-6">
                                <label class="d-block text-right">نام فروشنده:</label>
                                <select id="SellerId" class="form-control">${agencyOptions}</select>
                            </div>
                            <div class="form-group text-right col-md-6">
                                <label class="d-block text-right">قیمت هر صندلی:</label>
                                <input type="text" id="SellerPrice" class="form-control" value="${info_parvaz.SellerPrice || ''}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group text-right col-md-6">
                               ${flyCodeDropdownHtml}
                           </div>

                            <div class="form-group text-right col-md-6">
                                <label>ساعت پرواز:</label>
                                <input type="text" id="exitHour" class="form-control" value="${info_parvaz.ExitHours || ''}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group text-right col-md-6">
                                <label>بار مجاز:</label>
                                <input type="text" id="free" class="form-control" value="${info_parvaz.Free || ''}">
                            </div>
                            <div class="form-group text-right col-md-6">
                                <label>نوع هواپیما:</label>
                                <select id="typeOfPlane" class="form-control">${airplaneOptions}</select>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-success btn-block" onclick="saveFlightSchedule('${ticket_id}')">
                                <i class="fa fa-save"></i> ذخیره
                            </button>
                        </div>
                    `;

                $('#globalOperationContent').html(Content);
                populateFlyCodeList(ListAllFlyCode);
                selectFlyCodeDefault(info_parvaz, ListAllFlyCode);
            } else {
                showErrorModal((response.data && response.data.message) || 'خطا در بارگذاری اطلاعات پایه برنامه پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}

function saveFlightSchedule(ticket_id) {
    const SellerId = $('#SellerId').val();
    const SellerPrice = $('#SellerPrice').val();
    const exitHour = $('#exitHour').val();
    const typeOfPlane = $('#typeOfPlane').val();
    const free = $('#free').val();
    const flyCode_id= $('#flyCode_idModal').val();
    const flyCode_text = $('#flyCode_textModal').val();

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'setFlightSchedule',
            ticket_id: ticket_id,
            SellerId: SellerId,
            SellerPrice: SellerPrice,
            exitHour: exitHour,
            typeOfPlane: typeOfPlane,
            free: free,
            flyCode_id: flyCode_id,
            flyCode_text: flyCode_text,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                // نمایش پیام موفقیت در مودال
                $('#globalOperationContent').html(`
                    <div class="text-center">
                        <i class="fa fa-check-circle text-success fa-2x"></i>
                        <p>${response.message || 'برنامه پرواز با موفقیت ویرایش شد.'}</p>
                    </div>
                `);

                // بعد از 2 ثانیه: مودال بسته شود و جدول دوباره بارگذاری شود
                setTimeout(function() {
                    $('#globalOperationModal').modal('hide');

                    // بارگذاری مجدد جدول با اعمال فیلترهای فعلی
                    loadManifestData();
                }, 1000);
            } else {
                showErrorModal(response.message || 'خطا در ویرایش برنامه پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
// Render the improved flight details modal
function renderFlightDetailsModal(flightDetails) {
    const routeParts = flightDetails.route_name.split('-');
    const origin = routeParts[0] || '';
    const destination = routeParts[1] || '';
    
    // Calculate statistics
    const stats = calculateFlightStats(flightDetails);

    const modalContent = `
        <div class="flight-details-official">
            <!-- Flight Information Table -->
            <table class="flight-info-table">
                <thead>
                    <tr>
                        <th colspan="4">اطلاعات پرواز</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>هواپیمایی:</strong></td>
                        <td>${flightDetails.airline.name_fa || flightDetails.airline.name_en}</td>
                        <td><strong>شماره پرواز:</strong></td>
                        <td>${flightDetails.flight_number}</td>
                    </tr>
                    <tr>
                        <td><strong>مبدأ:</strong></td>
                        <td>${origin}</td>
                        <td><strong>مقصد:</strong></td>
                        <td>${destination}</td>
                    </tr>
                    <tr>
                        <td><strong>تاریخ:</strong></td>
                        <td>${formatDate(flightDetails.date)}</td>
                        <td><strong>ساعت پرواز:</strong></td>
                        <td>${flightDetails.exit_hour}</td>
                    </tr>
                    <tr>
                        <td><strong>تعداد بلیط:</strong></td>
                        <td>${flightDetails.tickets || 0}</td>
                        <td><strong>ظرفیت کل:</strong></td>
                        <td>${flightDetails.fly_total_capacity || 0}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Statistics Table -->
            <table class="stats-table">
                <thead>
                    <tr>
                        <th colspan="4">آمار مسافران</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>کل مسافران:</strong></td>
                        <td><strong>مانیفست:</strong></td>
                        <td><strong>رزرو:</strong></td>
                        <td><strong>عملیات:</strong></td>
                    </tr>
                    <tr>
                        <td>${stats.totalPassengers}</td>
                        <td>${stats.manifestCount}</td>
                        <td>${stats.bookCount}</td>
                        <td>
                            <button class="btn-action" onclick="downloadManifest('${flightDetails.airline.abbreviation}', '${flightDetails.flight_number}', '${flightDetails.date}', '${flightDetails.route_name}', '${flightDetails.exit_hour}', '${flightDetails.ticket_id}')" title="دانلود مانیفست">
                                دانلود
                            </button>
                 
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Passenger Tabs -->
            <div class="passenger-tabs-container">
                <div class="passenger-tabs-header">
                    <button class="tab-btn active" onclick="switchPassengerTab('all')" data-tab="all">
                        همه مسافران (${stats.totalPassengers})
                    </button>
                    <button class="tab-btn" onclick="switchPassengerTab('manifest')" data-tab="manifest">
                        مانیفست (${stats.manifestCount})
                    </button>
                    <button class="tab-btn" onclick="switchPassengerTab('book')" data-tab="book">
                        رزرو (${stats.bookCount})
                    </button>
                </div>
                
                <!-- All Passengers Tab -->
                <div class="tab-content active" id="tab-all">
                    <table class="passenger-list-table">
                        <thead>
                            <tr>
                                <th colspan="8">
                                لیست همه مسافران 
                                 ( <a onclick="FunCreateExcelNira()" href="#">خروجی اکسل نیرا</a> )
                                </th>
                            </tr>
                            <tr>
                                <th>نوع</th>
                                <th>نام و نام خانوادگی</th>
                                <th>جنسیت</th>
                                <th>کد ملی</th>
                                <th>پاسپورت</th>
                                <th>شماره بلیط</th>
                                <th>شماره تماس</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${renderPassengerTableRows(flightDetails)}
                        </tbody>
                    </table>
                </div>
                
                <!-- Manifest Passengers Tab -->
                <div class="tab-content" id="tab-manifest">
                    <table class="passenger-list-table">
                        <thead>
                            <tr>
                                <th colspan="8">لیست مسافران مانیفست</th>
                            </tr>
                            <tr>
                                <th>نام و نام خانوادگی</th>
                                <th>جنسیت</th>
                                <th>کد ملی</th>
                                <th>پاسپورت</th>
                                <th>شماره بلیط</th>
                                <th>شماره تماس</th>
                                <th>آژانس</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${renderManifestPassengerTableRows(flightDetails)}
                        </tbody>
                    </table>
                </div>
                
                <!-- Book Passengers Tab -->
                <div class="tab-content" id="tab-book">
                    <table class="passenger-list-table">
                        <thead>
                            <tr>
                                <th colspan="8">لیست مسافران رزرو</th>
                            </tr>
                            <tr>
                                <th>نام و نام خانوادگی</th>
                                <th>جنسیت</th>
                                <th>کد ملی</th>
                                <th>پاسپورت</th>
                                <th>شماره درخواست</th>
                                <th>تاریخ رزرو</th>
                                <th>شماره تماس</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${renderBookPassengerTableRows(flightDetails)}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    `;
    
    $('#flightDetailsContent').html(modalContent);
    
    // Store flight details for later use
    $('#flightDetailsModal').data('flightDetails', flightDetails);
}

// Calculate flight statistics
function calculateFlightStats(flightDetails) {
    let manifestCount = 0;
    let bookCount = 0;
    
    // Handle the actual data structure
    if (flightDetails.manifest_records && Array.isArray(flightDetails.manifest_records)) {
        manifestCount = flightDetails.manifest_records.length;
    }
    
    if (flightDetails.book_records && Array.isArray(flightDetails.book_records)) {
        bookCount = flightDetails.book_records.length;
    }
    
    return {
        totalPassengers: manifestCount + bookCount,
        manifestCount: manifestCount,
        bookCount: bookCount
    };
}

// Render compact passenger table grouped by ticket
function renderCompactPassengerTable(flightDetails) {
    if (!flightDetails.tickets || flightDetails.tickets === 0) {
        return `
            <div class="empty-passengers-compact">
                <i class="fa fa-users"></i>
                <p>هیچ مسافری یافت نشد</p>
            </div>
        `;
    }
    
    // Check if we have any passengers
    const manifestCount = flightDetails.manifest_records ? flightDetails.manifest_records.length : 0;
    const bookCount = flightDetails.book_records ? flightDetails.book_records.length : 0;
    const totalPassengers = manifestCount + bookCount;
    
    if (totalPassengers === 0) {
        return `
            <div class="empty-passengers-compact">
                <i class="fa fa-users"></i>
                <p>هیچ مسافری یافت نشد</p>
            </div>
        `;
    }
    
    return `
        <div class="ticket-groups-compact">
            <div class="ticket-group-compact" data-ticket-id="${flightDetails.ticket_id}">
                <div class="ticket-header-compact">
                    <div class="ticket-info-compact">
                        <span class="ticket-id-compact">بلیط #${flightDetails.ticket_id}</span>
                        <span class="ticket-time-compact">${flightDetails.exit_hour || '-'}</span>
                        <span class="ticket-capacity-compact">ظرفیت: ${flightDetails.fly_total_capacity || 0}</span>
                    </div>
                    <div class="ticket-stats-compact">
                        <span class="stat-badge manifest-stat">${manifestCount} مانیفست</span>
                        <span class="stat-badge book-stat">${bookCount} رزرو</span>
                    </div>
                </div>
                <div class="passenger-list-compact">
                    ${flightDetails.manifest_records ? flightDetails.manifest_records.map(passenger => `
                        <div class="passenger-item-compact" data-type="manifest" data-ticket-id="${flightDetails.ticket_id}">
                            <div class="passenger-info-compact">
                                <div class="passenger-name-compact">
                                    <strong>${passenger.passenger_name || ''} ${passenger.passenger_family || ''}</strong>
                                    <span class="passenger-type-badge manifest">مانیفست</span>
                                </div>
                                <div class="passenger-details-compact">
                                    <span class="detail-item">
                                        <span class="label">کد ملی:</span>
                                        <span class="value">${passenger.passenger_national_code || '-'}</span>
                                    </span>
                                    <span class="detail-item">
                                        <span class="label">بلیط:</span>
                                        <span class="value">${passenger.ticket_number || '-'}</span>
                                    </span>
                                    <span class="detail-item">
                                        <span class="label">پاسپورت:</span>
                                        <span class="value">${passenger.passportNumber || '-'}</span>
                                    </span>
                                    ${passenger.agency_name ? `
                                    <span class="detail-item">
                                        <span class="label">آژانس:</span>
                                        <span class="value agency-value">${passenger.agency_name}</span>
                                    </span>
                                    ` : ''}
                                </div>
                            </div>
                            <div class="passenger-actions-compact">
                                <button class="action-btn" 
                                        onclick="editPassenger(${passenger.id}, 'manifest', '${encodeURIComponent(JSON.stringify(flightDetails))}')"
                                        title="ویرایش">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    `).join('') : ''}
                    ${flightDetails.book_records ? flightDetails.book_records.map(passenger => `
                        <div class="passenger-item-compact" data-type="book" data-ticket-id="${flightDetails.ticket_id}">
                            <div class="passenger-info-compact">
                                <div class="passenger-name-compact">
                                    <strong>${passenger.passenger_name || ''} ${passenger.passenger_family || ''}</strong>
                                    <span class="passenger-type-badge book">رزرو</span>
                                </div>
                                <div class="passenger-details-compact">
                                    <span class="detail-item">
                                        <span class="label">کد ملی:</span>
                                        <span class="value">${passenger.passenger_national_code || '-'}</span>
                                    </span>
                                    <span class="detail-item">
                                        <span class="label">بلیط:</span>
                                        <span class="value">${passenger.request_number || '-'}</span>
                                    </span>
                                    <span class="detail-item">
                                        <span class="label">پاسپورت:</span>
                                        <span class="value">${passenger.passportNumber || '-'}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="passenger-actions-compact">
                                <button class="action-btn" 
                                        onclick="editPassenger(${passenger.id}, 'book', '${encodeURIComponent(JSON.stringify(flightDetails))}')"
                                        title="ویرایش">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    `).join('') : ''}
                </div>
            </div>
        </div>
    `;
}

// Render passenger table rows for official design
function renderPassengerTableRows(flightDetails) {
    if (!flightDetails.tickets || flightDetails.tickets === 0) {
        return `
            <tr>
                <td colspan="8" class="empty-state-cell">
                    <i class="fa fa-users"></i>
                    <span>هیچ مسافری یافت نشد</span>
                </td>
            </tr>
        `;
    }
    
    // Check if we have any passengers
    const manifestCount = flightDetails.manifest_records ? flightDetails.manifest_records.length : 0;
    const bookCount = flightDetails.book_records ? flightDetails.book_records.length : 0;
    const totalPassengers = manifestCount + bookCount;
    
    if (totalPassengers === 0) {
        return `
            <tr>
                <td colspan="8" class="empty-state-cell">
                    <i class="fa fa-users"></i>
                    <span>هیچ مسافری یافت نشد</span>
                </td>
            </tr>
        `;
    }
    
    let rows = '';
    
    // Add manifest passengers
    if (flightDetails.manifest_records) {
        flightDetails.manifest_records.forEach(passenger => {
            rows += `
                <tr>
                    <td>مانیفست</td>
                    <td>${passenger.passenger_name || ''} ${passenger.passenger_family || ''}</td>
                    <td>${passenger.passenger_age || '-'}</td>
                    <td>${passenger.passenger_national_code || '-'}</td>
                    <td>${passenger.passportNumber || '-'}</td>
                    <td>${passenger.ticket_number || '-'}</td>
                    <td>${passenger.member_phone || '-'}</td>
                    <td>
                        <button class="btn-action-small" onclick="editPassenger(${passenger.id}, 'manifest', '${encodeURIComponent(JSON.stringify(flightDetails))}')" title="ویرایش">
                            ویرایش
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    // Add book passengers
    if (flightDetails.book_records) {
        flightDetails.book_records.forEach(passenger => {
            rows += `
                <tr>
                    <td>رزرو</td>
                    <td>${passenger.passenger_name || ''} ${passenger.passenger_family || ''}</td>
                    <td>${passenger.passenger_age || '-'}</td>
                    <td>${passenger.passenger_national_code || '-'}</td>
                    <td>${passenger.passportNumber || '-'}</td>
                    <td>${passenger.request_number || '-'}</td>
                    <td>${passenger.member_phone || '-'}</td>
                    <td>
                        <button class="btn-action-small" onclick="editPassenger(${passenger.id}, 'book', '${encodeURIComponent(JSON.stringify(flightDetails))}')" title="ویرایش">
                            ویرایش
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    return rows;
}

// Render manifest passenger table rows
function renderManifestPassengerTableRows(flightDetails) {
    if (!flightDetails.manifest_records || flightDetails.manifest_records.length === 0) {
        return `
            <tr>
                <td colspan="8" class="empty-state-cell">
                    <i class="fa fa-users"></i>
                    <span>هیچ مسافر مانیفستی یافت نشد</span>
                </td>
            </tr>
        `;
    }
    
    return flightDetails.manifest_records.map(passenger => `
        <tr>
            <td>${passenger.passenger_name || ''} ${passenger.passenger_family || ''}</td>
            <td>${passenger.passenger_age || '-'}</td>
            <td>${passenger.passenger_national_code || '-'}</td>
            <td>${passenger.passportNumber || '-'}</td>
            <td>${passenger.ticket_number || '-'}</td>
            <td>${passenger.member_phone || '-'}</td>
            <td>${passenger.agency_name || ' '}  - ${passenger.seat_charter_code || ' '}</td>
            <td>
                <button class="btn-action-small" onclick="editPassenger(${passenger.id}, 'manifest', '${encodeURIComponent(JSON.stringify(flightDetails))}')" title="ویرایش">
                    ویرایش
                </button>
            </td>
        </tr>
    `).join('');
}

// Render book passenger table rows
function renderBookPassengerTableRows(flightDetails) {
    if (!flightDetails.book_records || flightDetails.book_records.length === 0) {
        return `
            <tr>
                <td colspan="8" class="empty-state-cell">
                    <i class="fa fa-users"></i>
                    <span>هیچ مسافر رزروی یافت نشد</span>
                </td>
            </tr>
        `;
    }
    
    return flightDetails.book_records.map(passenger => `
        <tr>
            <td>${passenger.passenger_name || ''} ${passenger.passenger_family || ''}</td>
            <td>${passenger.passenger_age || '-'}</td>
            <td>${passenger.passenger_national_code || '-'}</td>
            <td>${passenger.passportNumber || '-'}</td>
            <td>${passenger.request_number || '-'}</td>
            <td>${passenger.member_phone || '-'}</td>
            <td>${passenger.creation_date || '-'}</td>
            <td>
                <button class="btn-action-small" onclick="editPassenger(${passenger.id}, 'book', '${encodeURIComponent(JSON.stringify(flightDetails))}')" title="ویرایش">
                    ویرایش
                </button>
            </td>
        </tr>
    `).join('');
}

// Switch passenger tab function
function switchPassengerTab(tabName) {
    // Update active tab button
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    
    // Update active tab content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.getElementById(`tab-${tabName}`).classList.add('active');
}

// Filter passengers function
function filterPassengers(type) {
    // Update active filter button
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter passenger items
    const passengerItems = document.querySelectorAll('.passenger-item-compact');
    passengerItems.forEach(item => {
        if (type === 'all' || item.dataset.type === type) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Hide empty ticket groups
    const ticketGroups = document.querySelectorAll('.ticket-group-compact');
    ticketGroups.forEach(group => {
        const visiblePassengers = group.querySelectorAll('.passenger-item-compact[style*="block"], .passenger-item-compact:not([style*="none"])');
        if (visiblePassengers.length === 0) {
            group.style.display = 'none';
        } else {
            group.style.display = 'block';
        }
    });
}

// Download manifest function
function downloadManifest(airline, flightCode, date, route, time,ticket_id) {
    // Show loading state
    const downloadBtn = event.target;
    const originalText = downloadBtn.innerHTML;
    downloadBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> در حال دانلود...';
    downloadBtn.disabled = true;
    
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'exportFlightDetailsToTxt',
            airline_iata: airline,
            flight_number: flightCode,
            flight_date: date,
            route_name: route,
            time_flight: time,
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.data.status) {
                // Create download link
                const link = document.createElement('a');
                link.href = response.data.data.file_url;
                link.download = response.data.data.file_name;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Show success message
                showSuccessMessage('فایل مانیفست با موفقیت دانلود شد');
            } else {
                showErrorMessage('خطا در دانلود فایل مانیفست: ' + response.data.message);
            }
        },
        error: function() {
            showErrorMessage('خطا در ارتباط با سرور');
        },
        complete: function() {
            // Restore button
            downloadBtn.innerHTML = originalText;
            downloadBtn.disabled = false;
        }
    });
}
// Show error modal
function showErrorModal(message) {
    const errorContent = `
        <div class="error-modal">
            <div class="error-icon">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <h5>خطا</h5>
            <p>${message}</p>
            <button class="btn btn-primary" data-dismiss="modal">باشه</button>
        </div>
    `;
    $('#flightDetailsContent').html(errorContent);
}

// Manage agency close time
function manageAgencyCloseTime(agencyLockSeatId, agencyName) {
    // Show loading state
    const loadingContent = `
        <div class="agency-close-time-modal">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-clock-o"></i>
                    مدیریت زمان بسته شدن آژانس
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <div class="loading-spinner">
                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                    <p class="mt-3">در حال بارگذاری...</p>
                </div>
            </div>
        </div>
    `;
    
    $('#sellerDetailsContent').html(loadingContent);
    
    // Fetch data from API
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getAgencyCloseTimeData',
            agency_lock_seat_id: agencyLockSeatId,
            agency_name: agencyName,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            try {
                const result = response.data;
                if (result.status && result.data) {
                    renderAgencyCloseTimeModal(result.data);
                } else {
                    showErrorModal('خطا در دریافت اطلاعات: ' + (result.message || 'خطای نامشخص'));
                }
            } catch (e) {
                showErrorModal('خطا در پردازش پاسخ سرور');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور');
        }
    });
}

// Render the simple modal
function renderAgencyCloseTimeModal(data) {
    const { agency_lock_seat_id, agency_name, current_settings } = data;
    
    // Format current values for display
    const currentInternal = current_settings ? current_settings.internal || '' : '';
    const currentExternal = current_settings ? current_settings.external || '' : '';
    
    const modalContent = `
        <div class="agency-close-time-modal">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-clock-o"></i>
                    زمان اضافی آژانس
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="agency-info">
                    <h6 class="agency-name">${agency_name}</h6>
                    <p class="agency-description">تنظیم دقیقه‌های اضافی برای آپلود مانیفست</p>
                </div>
                
                <form id="agencyCloseTimeForm">
                    <input type="hidden" id="agencyLockSeatId" value="${agency_lock_seat_id}">
                    
                    <!-- Additional Minutes Section -->
                    <div class="time-section">
                        <div class="section-header">
                            <i class="fa fa-plus-circle"></i>
                            <span>دقیقه‌های اضافی</span>
                        </div>
                        <div class="time-input-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">پروازهای داخلی</label>
                                    <div class="quick-options">
                                        <button type="button" class="time-option ${currentInternal === '3' ? 'active' : ''}" onclick="selectTimeOption('internal', '3')">3 دقیقه</button>
                                        <button type="button" class="time-option ${currentInternal === '5' ? 'active' : ''}" onclick="selectTimeOption('internal', '5')">5 دقیقه</button>
                                        <button type="button" class="time-option ${currentInternal === '10' ? 'active' : ''}" onclick="selectTimeOption('internal', '10')">10 دقیقه</button>
                                        <button type="button" class="time-option ${currentInternal === '15' ? 'active' : ''}" onclick="selectTimeOption('internal', '15')">15 دقیقه</button>
                                    </div>
                                    <input type="number" id="internalTime" class="form-control mt-2" 
                                           placeholder="سفارشی" min="0" max="60" 
                                           value="${currentInternal}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">پروازهای خارجی</label>
                                    <div class="quick-options">
                                        <button type="button" class="time-option ${currentExternal === '3' ? 'active' : ''}" onclick="selectTimeOption('external', '3')">3 دقیقه</button>
                                        <button type="button" class="time-option ${currentExternal === '5' ? 'active' : ''}" onclick="selectTimeOption('external', '5')">5 دقیقه</button>
                                        <button type="button" class="time-option ${currentExternal === '10' ? 'active' : ''}" onclick="selectTimeOption('external', '10')">10 دقیقه</button>
                                        <button type="button" class="time-option ${currentExternal === '15' ? 'active' : ''}" onclick="selectTimeOption('external', '15')">15 دقیقه</button>
                                    </div>
                                    <input type="number" id="externalTime" class="form-control mt-2" 
                                           placeholder="سفارشی" min="0" max="60" 
                                           value="${currentExternal}">
                                </div>
                            </div>
                            <div class="help-text">
                                <i class="fa fa-info-circle"></i>
                                این دقیقه‌ها به زمان بسته شدن ایرلاین اضافه می‌شود
                            </div>
                        </div>
                    </div>
                    
                    ${current_settings ? `
                        <div class="current-status">
                            <div class="status-badge">
                                <i class="fa fa-check-circle"></i>
                                زمان اضافی تنظیم شده است
                            </div>
                        </div>
                    ` : ''}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                ${current_settings ? 
                    `<button type="button" class="btn btn-outline-danger" onclick="deleteAgencyCloseTime('${agency_lock_seat_id}')">
                        <i class="fa fa-trash"></i> حذف
                    </button>` : ''
                }
                <button type="button" class="btn btn-primary" onclick="saveAgencyCloseTime()">
                    <i class="fa fa-save"></i> ذخیره
                </button>
            </div>
        </div>
    `;
    
    $('#sellerDetailsContent').html(modalContent);
}

// Save agency close time
function saveAgencyCloseTime() {
    const agencyLockSeatId = $('#agencyLockSeatId').val();
    const internalTime = $('#internalTime').val();
    const externalTime = $('#externalTime').val();
    
    if (!agencyLockSeatId) {
        alert('خطا: شناسه آژانس یافت نشد');
        return;
    }
    
    // Validate that at least one time is set
    if (!internalTime && !externalTime) {
        alert('لطفاً حداقل یکی از دقیقه‌های داخلی یا خارجی را تنظیم کنید');
        return;
    }
    
    // Validate time format (expecting minutes as numbers)
    if (internalTime && !/^\d+$/.test(internalTime)) {
        alert('دقیقه داخلی باید عدد صحیح باشد');
        return;
    }
    
    if (externalTime && !/^\d+$/.test(externalTime)) {
        alert('دقیقه خارجی باید عدد صحیح باشد');
        return;
    }
    
    // Validate range (0-60 minutes)
    if (internalTime && (parseInt(internalTime) < 0 || parseInt(internalTime) > 60)) {
        alert('دقیقه داخلی باید بین 0 تا 60 باشد');
        return;
    }
    
    if (externalTime && (parseInt(externalTime) < 0 || parseInt(externalTime) > 60)) {
        alert('دقیقه خارجی باید بین 0 تا 60 باشد');
        return;
    }
    
    // Show loading state
    const saveButton = $('.modal-footer .btn-primary');
    const originalText = saveButton.html();
    saveButton.html('<i class="fa fa-spinner fa-spin"></i> در حال ذخیره...').prop('disabled', true);
    
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'saveAgencyCloseTime',
            agency_lock_seat_id: agencyLockSeatId,
            internal_time: internalTime,
            external_time: externalTime,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            try {
                const result = response.data;

                if (result.status) {
                    // Show success message
                    const successContent = `
                        <div class="agency-close-time-modal">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    <i class="fa fa-check-circle"></i>
                                    موفقیت
                                </h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="success-message">
                                    <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                                    <p class="success-text">${result.message}</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="closeAndRefresh()">باشه</button>
                            </div>
                        </div>
                    `;
                    $('#sellerDetailsContent').html(successContent);
                } else {
                    alert('خطا: ' + result.message);
                    saveButton.html(originalText).prop('disabled', false);
                }
            } catch (e) {
                alert('خطا در پردازش پاسخ سرور');
                saveButton.html(originalText).prop('disabled', false);
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
            saveButton.html(originalText).prop('disabled', false);
        }
    });
}

// Delete agency close time
function deleteAgencyCloseTime(agencyLockSeatId) {
    if (!confirm('آیا از حذف تنظیمات زمان بسته شدن این آژانس اطمینان دارید؟')) {
        return;
    }
    
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'deleteAgencyCloseTime',
            agency_lock_seat_id: agencyLockSeatId,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            try {
                const result = response.data;
                if (result.status) {
                    alert(result.message);
                    // Refresh the seller details modal
                    const flightDetails = $('#sellerDetailsModal').data('flightDetails');
                    if (flightDetails) {
                        showSellerDetails(
                            flightDetails.flight_code || flightDetails.flight_number,
                            flightDetails.seller_title || 'نامشخص',
                            flightDetails.seller_price || '0',
                            flightDetails.ticket_id,
                           ''
                        );
                    }
                } else {
                    alert('خطا: ' + result.message);
                }
            } catch (e) {
                alert('خطا در پردازش پاسخ سرور');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور');
        }
    });
}

// Validate time format
function isValidTimeFormat(timeString) {
    if (!timeString) return true; // Allow empty
    
    // Check for HH:MM format
    if (/^\d{1,2}:\d{2}$/.test(timeString)) {
        const parts = timeString.split(':');
        const hours = parseInt(parts[0]);
        const minutes = parseInt(parts[1]);
        return hours >= 0 && hours <= 23 && minutes >= 0 && minutes <= 59;
    }
    
    // Check for decimal format (e.g., 2.5 for 2 hours 30 minutes)
    if (/^\d+(\.\d+)?$/.test(timeString)) {
        const hours = parseFloat(timeString);
        return hours >= 0 && hours <= 24;
    }
    
    // Check for HHMM format
    if (/^\d{4}$/.test(timeString)) {
        const hours = parseInt(timeString.substring(0, 2));
        const minutes = parseInt(timeString.substring(2, 4));
        return hours >= 0 && hours <= 23 && minutes >= 0 && minutes <= 59;
    }
    
    return false;
}



// Format minutes for display
function formatMinutes(minutes) {
    const mins = parseInt(minutes);
    if (mins < 60) {
        return `${mins} دقیقه`;
    } else if (mins === 60) {
        return '1 ساعت';
    } else {
        const hours = Math.floor(mins / 60);
        const remainingMins = mins % 60;
        if (remainingMins === 0) {
            return `${hours} ساعت`;
        } else {
            return `${hours} ساعت ${remainingMins} دقیقه`;
        }
    }
}

// Select time option
function selectTimeOption(type, minutes) {
    // Update the input field
    document.getElementById(type + 'Time').value = minutes;
    
    // Update active state of buttons
    const section = document.querySelector(`#${type}Time`).closest('.time-section');
    section.querySelectorAll('.time-option').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
}

// Show error modal
function showErrorModal(message) {
    const errorContent = `
        <div class="agency-close-time-modal">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-exclamation-triangle"></i>
                    خطا
                </h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <div class="error-message">
                    <i class="fa fa-times-circle fa-3x text-danger mb-3"></i>
                    <p class="error-text">${message}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
            </div>
        </div>
    `;
    
    $('#sellerDetailsContent').html(errorContent);
}

// Close modal and refresh seller details
function closeAndRefresh() {
    $('#sellerDetailsModal').modal('hide');
    
    // Refresh the seller details modal after a short delay
    setTimeout(() => {
        const flightDetails = $('#sellerDetailsModal').data('flightDetails');
        if (flightDetails) {
            showSellerDetails(
                flightDetails.flight_code || flightDetails.flight_number,
                flightDetails.seller_title || 'نامشخص',
                flightDetails.seller_price || '0',
                flightDetails.ticket_id,
               ''
            );
        }
    }, 300);
}

// Render agency lock seat modal
function renderAgencyLockSeatModal(flightCode, sellerTitle, sellerPrice, agencyData, ticket_id, flightDetails,remainingTotal) {
    // console.log('flightDetails',flightDetails)
    // Use flight details from server response instead of extracting from HTML
    const flightInfo = {
        airline: flightDetails.airline?.name_fa || flightDetails.airline?.name_en || '-',
        aircraft_type: flightDetails.airline?.abbreviation || '-',
        departure_time: flightDetails.exit_hour || '-',
        duration: flightDetails.duration || '-',
        arrival_time: flightDetails.finish_time || '-',
        destination: flightDetails.route_name ? flightDetails.route_name.split('-')[1] || '-' : '-',
        origin: flightDetails.route_name ? flightDetails.route_name.split('-')[0] || '-' : '-',
        flight_date: formatDate(flightDetails.date) || '-',
        day_of_week: getDayNameFromDate(flightDetails.date) || '-',
        flight_class: flightDetails.vehicle_grade_name || flightDetails.vehicle_grade || '-'
    };

    const modalContent = `
        <div class="agency-lock-seat-content-official">
            <!-- Official Flight Information Table -->
            <table class="flight-info-table">
                <thead>
                    <tr>
                        <th colspan="4">اطلاعات پرواز</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>هواپیمایی:</strong></td>
                        <td>${flightInfo.airline}</td>
                        <td><strong>شماره پرواز:</strong></td>
                        <td>${flightCode}</td>
                    </tr>
                    <tr>
                        <td><strong>مبدأ:</strong></td>
                        <td>${flightInfo.origin}</td>
                        <td><strong>مقصد:</strong></td>
                        <td>${flightInfo.destination}</td>
                    </tr>
                    <tr>
                        <td><strong>تاریخ:</strong></td>
                        <td>${flightInfo.flight_date}</td>
                        <td><strong>ساعت پرواز:</strong></td>
                        <td>${flightInfo.departure_time}</td>
                    </tr>
                    <tr>
                        <td><strong>نوع هواپیما:</strong></td>
                        <td>${flightInfo.aircraft_type}</td>
                        <td><strong>کلاس:</strong></td>
                        <td>${flightInfo.flight_class}</td>
                    </tr>
                    <tr>
                        <td><strong>فروشنده:</strong></td>
                        <td>${sellerTitle}</td>
                        <td><strong>قیمت:</strong></td>
                        <td>${sellerPrice} تومان</td>
                    </tr>
                </tbody>
            </table>

            <!-- Statistics Table -->
            <table class="stats-table">
                <thead>
                    <tr>
                        <th colspan="3">آمار کلی</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>تعداد آژانس‌ها:</strong></td>
                        <td><strong>تعداد صندلی های واگذار شده:</strong></td>
                        <td><strong>صندلی های مانده:</strong></td>
                    </tr>
                    <tr>
                        <td>${agencyData.total_agencies || 0}</td>
                        <td>${agencyData.total_seats || 0}</td>
                        <td>${remainingTotal || 0}</td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Vehicle Grade Summary Table (if exists) -->
            ${renderVehicleGradeSummaryTable(agencyData.agencies || [], agencyData.vehicle_grades || [])}

            <!-- Agency Assignment Table -->
            <table class="agency-assignment-table">
                <thead>
                    <tr>
                        <th colspan="5">تخصیص صندلی به آژانس‌ها</th>
                    </tr>
                    <tr>
                        <th>نام آژانس</th>
                        <th>تعداد صندلی</th>
                        <th>ظرفیت مانده</th>
                        <th>وضعیت زمان</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    ${renderAgencyAssignmentTableRows(agencyData.agencies || [])}
                </tbody>
            </table>
        </div>
    `;

    activeModalSource = 'showSellerDetailsModal';
    $('#sellerDetailsContent').html(modalContent);
}

$('#sellerDetailsModal').on('hidden.bs.modal', function () {
    if (activeModalSource === 'showSellerDetailsModal') {
        activeModalSource = null;
        loadManifestData();
    }
});

// Helper function to get day name from date
function getDayNameFromDate(dateString) {
    if (!dateString) return '-';
    
    const dayNames = ['یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه', 'شنبه'];
    
    // Try different date formats
    let dateObj = null;
    
    // Try Y/m/d format
    if (dateString.includes('/')) {
        const parts = dateString.split('/');
        if (parts.length === 3) {
            dateObj = new Date(parts[0], parts[1] - 1, parts[2]);
        }
    }
    
    // Try Y-m-d format
    if (!dateObj && dateString.includes('-')) {
        dateObj = new Date(dateString);
    }
    
    // Try Ymd format (without separators)
    if (!dateObj && dateString.length === 8) {
        const year = dateString.substring(0, 4);
        const month = dateString.substring(4, 6);
        const day = dateString.substring(6, 8);
        dateObj = new Date(year, month - 1, day);
    }
    
    // Check if date is valid and get day of week
    if (dateObj && !isNaN(dateObj.getTime())) {
        const dayOfWeek = dateObj.getDay();
        return dayNames[dayOfWeek] || '-';
    }
    
    return '-';
}

// Render agency lock seat table
function renderAgencyLockSeatTable(agencies) {
    if (!agencies || agencies.length === 0) {
        return `
            <div class="empty-agency-state">
                <i class="fa fa-building"></i>
                <p>هیچ آژانسی برای این پرواز تخصیص داده نشده است.</p>
            </div>
        `;
    }

    return `
        <div class="agency-table-container">
            <table class="agency-table">
                <thead>
                    <tr>
                        <th>نام آژانس</th>
                        <th>ظرفیت</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    ${agencies.map(agency => `
                        <tr class="agency-row">
                            <td class="agency-name">
                                <i class="fa fa-building"></i>
                                <span>${agency.agency_name || 'نامشخص'}</span>
                            </td>
                            
                            <td class="agency-seats">
                                <span class="seat-count">${agency.count_agency || 0}</span>
                                <span class="seat-label">صندلی</span>
                            </td>
                            <td class="flight-date">
                                ${formatDate(agency.flight_date)}
                            </td>
                           
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

// Render compact agency lock seat table
function renderAgencyLockSeatTableCompact(agencies) {
    if (!agencies || agencies.length === 0) {
        return `
            <div class="empty-agency-state-compact">
                <i class="fa fa-building"></i>
                <p>هیچ آژانسی برای این پرواز تخصیص داده نشده است.</p>
            </div>
        `;
    }

    return `
        <div class="agency-table-container-compact">
            <table class="agency-table-compact">
                <thead>
                    <tr>
                        <th>نام آژانس</th>
                        <th>ظرفیت</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    ${agencies.map(agency => `
                        <tr class="agency-row-compact">
                            <td class="agency-name-compact">
                                <i class="fa fa-building"></i>
                                <span>${agency.agency_name || 'نامشخص'}</span>
                            </td>
                            
                            <td class="agency-seats-compact">
                                <span class="seat-count-compact">${agency.count_agency || 0}</span>
                                <span class="seat-label-compact">صندلی</span>
                            </td>
                            <td class="flight-date-compact">
                                ${formatDate(agency.flight_date)}
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

// Render ultra compact agency lock seat table
function renderAgencyLockSeatTableUltraCompact(agencies) {
    if (!agencies || agencies.length === 0) {
        return `
            <div class="empty-agency-state-ultra">
                <i class="fa fa-building"></i>
                <p>هیچ آژانسی برای این پرواز تخصیص داده نشده است.</p>
            </div>
        `;
    }

    return `
        <div class="agency-table-container-ultra">
            <table class="agency-table-ultra">
                <thead>
                    <tr>
                        <th>آژانس</th>
                        <th>ظرفیت</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    ${agencies.map(agency => `
                        <tr class="agency-row-ultra">
                            <td class="agency-name-ultra">
                                <i class="fa fa-building"></i>
                                <span>${agency.agency_name || 'نامشخص'}</span>
                            </td>
                            <td class="agency-seats-ultra">
                                <span class="seat-count-ultra">${agency.count_agency || 0}</span>
                            </td>
                            <td class="flight-date-ultra">
                                ${formatDate(agency.flight_date)}
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

// Render agency assignment table rows
function renderAgencyAssignmentTableRows(agencies) {
    if (!agencies || agencies.length === 0) {
        return `
            <tr>
                <td colspan="4" class="empty-state-cell">
                    <i class="fa fa-building"></i>
                    <span>هیچ آژانسی برای این پرواز تخصیص داده نشده است.</span>
                </td>
            </tr>
        `;
    }

    return agencies.map(agency => `
        <tr>
            <td>${agency.agency_name || 'نامشخص'}</td>
            <td>
                <input type="number" id="capacity_${agency.agency_lock_seat_id}" 
                       value="${agency.count_agency || 0}" 
                       class="form-control form-control-sm d-inline-block w-auto">
                
                <button class="btn btn-sm btn-primary" 
                        onclick="updateAgencyCapacity('${agency.agency_lock_seat_id}')">
                    <i class="fa fa-save"></i> ذخیره
                </button>
            </td>
            <td>
               ${
                   agency.count_passenger_total > 0
                      ? (agency.count_agency - agency.count_passenger_total)
                      : agency.count_agency
                }
            </td>
            <td>
                ${agency.close_time ? 
                    `<span class="badge badge-success">
                        ${agency.close_time.internal ? `داخلی: +${agency.close_time.internal}د` : ''}
                        ${agency.close_time.external ? `خارجی: +${agency.close_time.external}د` : ''}
                    </span>` : 
                    `<span class="badge badge-secondary">تنظیم نشده</span>`
                }
            </td>
            <td>
                <button class="btn btn-sm btn-primary" onclick="manageAgencyCloseTime('${agency.agency_lock_seat_id}', '${agency.agency_name}')">
                    <i class="fa fa-clock-o"></i> مدیریت زمان
                </button>
            </td>
        </tr>
    `).join('');
}

function updateAgencyCapacity(agencyLockSeatId) {
    const newCapacity = $(`#capacity_${agencyLockSeatId}`).val();

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'updateAgencyCapacity',
            agency_lock_seat_id: agencyLockSeatId,
            capacity: newCapacity,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            console.log("✅ پاسخ سرور:", response);
            const serverData = response.data || {};

            if (serverData.success) {
                alert('✅ ' + serverData.message);
            } else {
                alert('❌ ' + serverData.message);
            }
        },
        error: function(xhr, status, error) {
            console.log("❌ خطای Ajax:", {xhr, status, error});
            alert('❌ خطا در ارتباط با سرور.');
        }
    });
}

// Render vehicle grade capacities
function renderVehicleGradeCapacities(vehicleGradeCapacities) {
    if (!vehicleGradeCapacities || vehicleGradeCapacities.length === 0) {
        return '<span class="no-capacity">بدون ظرفیت</span>';
    }

    const capacityItems = vehicleGradeCapacities
        .filter(grade => grade.capacity > 0) // Only show grades with capacity
        .map(grade => `
            <div class="capacity-item">
                <span class="grade-name">${grade.grade_name || grade.grade_abbreviation}</span>
                <span class="capacity-value">${grade.capacity}</span>
            </div>
        `)
        .join('');

    if (capacityItems === '') {
        return '<span class="no-capacity">بدون ظرفیت</span>';
    }

    return `
        <div class="capacity-breakdown">
            ${capacityItems}
        </div>
    `;
}

// Render vehicle grade summary
function renderVehicleGradeSummary(agencies, vehicleGrades) {
    if (!agencies || agencies.length === 0 || !vehicleGrades || vehicleGrades.length === 0) {
        return '';
    }

    // Calculate total capacities by vehicle grade
    const gradeTotals = {};
    vehicleGrades.forEach(grade => {
        gradeTotals[grade.id] = {
            name: grade.name,
            abbreviation: grade.abbreviation,
            total: 0
        };
    });

    // Sum up capacities from all agencies
    agencies.forEach(agency => {
        if (agency.vehicle_grade_capacities) {
            agency.vehicle_grade_capacities.forEach(gradeCapacity => {
                if (gradeTotals[gradeCapacity.grade_id]) {
                    gradeTotals[gradeCapacity.grade_id].total += gradeCapacity.capacity;
                }
            });
        }
    });

    // Filter grades that have capacity
    const gradesWithCapacity = Object.values(gradeTotals).filter(grade => grade.total > 0);

    if (gradesWithCapacity.length === 0) {
        return '';
    }

    return `
        <div class="vehicle-grade-summary">
            <div class="summary-header">
                <h6><i class="fa fa-chart-pie"></i> خلاصه ظرفیت بر اساس درجه</h6>
            </div>
            <div class="summary-content">
                ${gradesWithCapacity.map(grade => `
                    <div class="summary-item">
                        <span class="grade-name">${grade.name || grade.abbreviation}</span>
                        <span class="total-capacity">${grade.total}</span>
                    </div>
                `).join('')}
            </div>
        </div>
    `;
}

// Render compact vehicle grade summary
function renderVehicleGradeSummaryCompact(agencies, vehicleGrades) {
    if (!agencies || agencies.length === 0 || !vehicleGrades || vehicleGrades.length === 0) {
        return '';
    }

    // Calculate total capacities by vehicle grade
    const gradeTotals = {};
    vehicleGrades.forEach(grade => {
        gradeTotals[grade.id] = {
            name: grade.name,
            abbreviation: grade.abbreviation,
            total: 0
        };
    });

    // Sum up capacities from all agencies
    agencies.forEach(agency => {
        if (agency.vehicle_grade_capacities) {
            agency.vehicle_grade_capacities.forEach(gradeCapacity => {
                if (gradeTotals[gradeCapacity.grade_id]) {
                    gradeTotals[gradeCapacity.grade_id].total += gradeCapacity.capacity;
                }
            });
        }
    });

    // Filter grades that have capacity
    const gradesWithCapacity = Object.values(gradeTotals).filter(grade => grade.total > 0);

    if (gradesWithCapacity.length === 0) {
        return '';
    }

    return `
        <div class="vehicle-grade-summary-compact">
            <div class="summary-header-compact">
                <h6><i class="fa fa-chart-pie"></i> خلاصه ظرفیت</h6>
            </div>
            <div class="summary-content-compact">
                ${gradesWithCapacity.map(grade => `
                    <div class="summary-item-compact">
                        <span class="grade-name-compact">${grade.name || grade.abbreviation}</span>
                        <span class="total-capacity-compact">${grade.total}</span>
                    </div>
                `).join('')}
            </div>
        </div>
    `;
}

// Render ultra compact vehicle grade summary
function renderVehicleGradeSummaryUltraCompact(agencies, vehicleGrades) {
    if (!agencies || agencies.length === 0 || !vehicleGrades || vehicleGrades.length === 0) {
        return '';
    }

    // Calculate total capacities by vehicle grade
    const gradeTotals = {};
    vehicleGrades.forEach(grade => {
        gradeTotals[grade.id] = {
            name: grade.name,
            abbreviation: grade.abbreviation,
            total: 0
        };
    });

    // Sum up capacities from all agencies
    agencies.forEach(agency => {
        if (agency.vehicle_grade_capacities) {
            agency.vehicle_grade_capacities.forEach(gradeCapacity => {
                if (gradeTotals[gradeCapacity.grade_id]) {
                    gradeTotals[gradeCapacity.grade_id].total += gradeCapacity.capacity;
                }
            });
        }
    });

    // Filter grades that have capacity
    const gradesWithCapacity = Object.values(gradeTotals).filter(grade => grade.total > 0);

    if (gradesWithCapacity.length === 0) {
        return '';
    }

    return `
        <div class="vehicle-grade-summary-ultra">
            <div class="summary-header-ultra">
                <span class="summary-title-ultra">خلاصه ظرفیت:</span>
            </div>
            <div class="summary-content-ultra">
                ${gradesWithCapacity.map(grade => `
                    <span class="summary-item-ultra">
                        <span class="grade-name-ultra">${grade.name || grade.abbreviation}</span>
                        <span class="total-capacity-ultra">${grade.total}</span>
                    </span>
                `).join('')}
            </div>
        </div>
    `;
}

// Render vehicle grade summary table
function renderVehicleGradeSummaryTable(agencies, vehicleGrades) {
    if (!agencies || agencies.length === 0 || !vehicleGrades || vehicleGrades.length === 0) {
        return '';
    }

    // Calculate total capacities by vehicle grade
    const gradeTotals = {};
    vehicleGrades.forEach(grade => {
        gradeTotals[grade.id] = {
            name: grade.name,
            abbreviation: grade.abbreviation,
            total: 0
        };
    });

    // Sum up capacities from all agencies
    agencies.forEach(agency => {
        if (agency.vehicle_grade_capacities) {
            agency.vehicle_grade_capacities.forEach(gradeCapacity => {
                if (gradeTotals[gradeCapacity.grade_id]) {
                    gradeTotals[gradeCapacity.grade_id].total += gradeCapacity.capacity;
                }
            });
        }
    });

    // Filter grades that have capacity
    const gradesWithCapacity = Object.values(gradeTotals).filter(grade => grade.total > 0);

    if (gradesWithCapacity.length === 0) {
        return '';
    }

    return `
        <table class="vehicle-grade-summary-table">
            <thead>
                <tr>
                    <th colspan="${gradesWithCapacity.length}">خلاصه ظرفیت بر اساس کلاس</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    ${gradesWithCapacity.map(grade => `
                        <td><strong>${grade.name || grade.abbreviation}</strong></td>
                    `).join('')}
                </tr>
                <tr>
                    ${gradesWithCapacity.map(grade => `
                        <td>${grade.total}</td>
                    `).join('')}
                </tr>
            </tbody>
        </table>
    `;
}

// Show agency lock seat error
function showAgencyLockSeatError(message) {
    const errorContent = `
        <div class="agency-error-modal">
            <div class="error-icon">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <h5>خطا</h5>
            <p>${message}</p>
            <button class="btn btn-primary" data-dismiss="modal">باشه</button>
        </div>
    `;
    $('#sellerDetailsContent').html(errorContent);
}

// Get day name from day number
function getDayName(dayNumber) {
    const dayNames = ['شنبه', 'یکشنبه', 'دوشنبه', 'سه‌شنبه', 'چهارشنبه', 'پنج‌شنبه', 'جمعه'];
    return dayNames[dayNumber] || 'نامشخص';
}

// Show seller details modal
function showSellerDetails(flightCode, sellerTitle, sellerPrice, ticket_id,remainingTotal) {
    // Show loading state
    const loadingContent = `
        <div class="seller-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری اطلاعات پرواز و آژانس‌ها...</p>
        </div>
    `;
    $('#sellerDetailsContent').html(loadingContent);
    $('#sellerDetailsModal').modal('show');
    
    // Store flight details for refresh functionality
    $('#sellerDetailsModal').data('flightDetails', {
        flight_code: flightCode,
        seller_title: sellerTitle,
        seller_price: sellerPrice,
        ticket_id: ticket_id
    });

    // First, get flight details using ticket_id
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightDetails',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(flightResponse) {
            if (flightResponse.status && flightResponse.data && flightResponse.data.data) {
                const flightDetails = flightResponse.data.data;
                
                // Now get agency lock seat data
                $.ajax({
                    type: "post",
                    url: `${amadeusPath}ajax`,
                    data: JSON.stringify({
                        className: 'manifestController',
                        method: 'getAgencyLockSeatData',
                        flight_code: flightCode,
                        ticket_id: ticket_id,
                        to_json: true
                    }),
                    contentType: "application/json",
                    success: function(agencyResponse) {
                        if (agencyResponse.status && agencyResponse.data) {
                            renderAgencyLockSeatModal(flightCode, sellerTitle, sellerPrice, agencyResponse.data.data, ticket_id, flightDetails,remainingTotal);
                        } else {
                            showAgencyLockSeatError('خطا در بارگذاری اطلاعات آژانس‌ها.');
                        }
                    },
                    error: function() {
                        showAgencyLockSeatError('خطا در بارگذاری اطلاعات آژانس‌ها.');
                    }
                });
            } else {
                showAgencyLockSeatError('خطا در بارگذاری اطلاعات پرواز.');
            }
        },
        error: function() {
            showAgencyLockSeatError('خطا در ارتباط با سرور.');
        }
    });
}

// Show success message
function showSuccessMessage(message) {
    // You can implement a toast notification system here
    alert(message);
}

// Show error message
function showErrorMessage(message) {
    // You can implement a toast notification system here
    alert(message);
}

// Edit passenger
function editPassenger(recordId, recordType, flightDetails) {
    flightDetails = JSON.parse(decodeURIComponent(flightDetails));
    const passenger = findPassenger(recordId, recordType, flightDetails);
    
    if (!passenger) {
        alert('مسافر یافت نشد.');
        return;
    }

    showEditPassengerForm(passenger, recordType, flightDetails);
}

// Find passenger in flight details
function findPassenger(recordId, recordType, flightDetails) {
    let passenger = null;
    
    if (recordType === 'manifest' && flightDetails.manifest_records) {
        passenger = flightDetails.manifest_records.find(p => p.id == recordId);
    } else if (recordType === 'book' && flightDetails.book_records) {
        passenger = flightDetails.book_records.find(p => p.id == recordId);
    }
    
    return passenger;
}

// Show edit passenger form
function showEditPassengerForm(passenger, recordType, flightDetails) {
    const modalContent = `
        <div class="modal-header">
            <h5 class="modal-title">ویرایش مسافر</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editPassengerForm">
                <input type="hidden" id="editRecordId" value="${passenger.id}">
                <input type="hidden" id="editRecordType" value="${recordType}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>نام</label>
                        <input type="text" class="form-control" id="editPassengerName" value="${passenger.passenger_name || ''}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>نام خانوادگی</label>
                        <input type="text" class="form-control" id="editPassengerFamily" value="${passenger.passenger_family || ''}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>کد ملی</label>
                        <input type="text" class="form-control" id="editPassengerNationalCode" value="${passenger.passenger_national_code || ''}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>شماره پاسپورت</label>
                        <input type="text" class="form-control" id="editPassportNumber" value="${passenger.passportNumber || ''}">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
            <button type="button" class="btn btn-primary" onclick="savePassengerEdit('${encodeURIComponent(JSON.stringify(flightDetails))}')">ذخیره</button>
        </div>
    `;

    $('#flightDetailsContent').html(modalContent);
}

// Save passenger edit
function savePassengerEdit(flightDetails) {
    flightDetails = JSON.parse(decodeURIComponent(flightDetails));
    const recordId = $('#editRecordId').val();
    const recordType = $('#editRecordType').val();

    const passengerData = {
        passenger_name: $('#editPassengerName').val(),
        passenger_family: $('#editPassengerFamily').val(),
        passenger_national_code: $('#editPassengerNationalCode').val(),
        passportNumber: $('#editPassportNumber').val(),
    };

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
                // Refresh flight details to show updated data
                showFlightDetails(flightDetails.airline_name, flightDetails.flight_number, flightDetails.flight_date, flightDetails.route_name, flightDetails.time_flight);
            } else {
                alert('خطا در بروزرسانی مسافر.');
            }
        },
        error: function() {
            alert('خطا در ارتباط با سرور.');
        }
    });
}

// Export flight data
function exportFlightData(flightCode) {
    // Implementation for exporting flight data
    console.log('Export flight data:', flightCode);
    
    // You can implement the actual export logic here
    // For example, redirect to an export endpoint
    // window.location.href = `${amadeusPath}manifest/exportFlight?flight_code=${flightCode}`;
}

// Edit flight
function editFlight(flightCode) {
    // Implementation for editing flight
    console.log('Edit flight:', flightCode);
    
    // You can implement the actual edit logic here
    // For example, redirect to an edit page
    // window.location.href = `${amadeusPath}manifest/editFlight?flight_code=${flightCode}`;
}

// Print table
function printTable() {
    window.print();
}

// Export to Excel
function exportToExcel() {
    // Implementation for Excel export
    console.log('Export to Excel');
    
    // You can implement the actual Excel export logic here
    // For example, redirect to an Excel export endpoint
    // window.location.href = `${amadeusPath}manifest/exportToExcel`;
}

// Refresh data
function refreshData() {
    location.reload();
}

// Clear all filters
function clearFilters() {
    // تاریخ‌ها رو نگه داریم
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    if (dateFrom) dateFrom.value = todayJalali;
    if (dateTo) dateTo.value = tomorrowJalali;

    const filterInputs = [
        'airlineFilter', 'originFilter', 'destinationFilter',
        'flightClassFilter', 'seller_id_filter', 'flyCodeFilter', 'statusFilter'
    ];

    filterInputs.forEach(inputId => {
        const element = document.getElementById(inputId);
        if (!element) return;

        // اول select2 رو چک کن
        if ($(element).hasClass('select2')) {
            $(element).val(null).trigger('change'); // همه انتخاب‌ها پاک میشن
        }
        else if (element.tagName === 'SELECT') {
            element.selectedIndex = 0;
        }
        else if (element.type === 'hidden') {
            element.value = '';
            // بروزرسانی متن نمایش dropdown
            let textSpan = null;
            if (inputId === 'flyCodeFilter') textSpan = document.getElementById('flightDropdownFilterText');
            else if (inputId === 'seller_id_filter') textSpan = document.getElementById('sellerDropdownFilterText');

            if (textSpan) textSpan.textContent = 'انتخاب کنید';
        }
        else {
            element.value = '';
        }
    });

    // Reset page
    currentPage = 1;

    // Reload data
    loadManifestData();
}

function clearSellerFilter() {
    document.getElementById('seller_id_filter').value = '';
    document.getElementById('sellerDropdownFilterText').innerText = 'انتخاب کنید';
}
function clearFlyCodeFilter() {
    document.getElementById('flyCodeFilter').value = '';
    document.getElementById('flightDropdownFilterText').innerText = 'انتخاب کنید';
}
// Pagination functions
function changePage(page) {
    currentPage = page;
    loadManifestData();
}

function changePerPage(perPage) {
    currentPerPage = parseInt(perPage);
    currentPage = 1; // Reset to first page when changing per page
    loadManifestData();
}

function loadManifestData() {
    $(".loaderPublic").css("display","block");
    const filters = {
        date_from: $('#dateFrom').val() || '',
        date_to: $('#dateTo').val() || '',
        airline: $('#airlineFilter').val() || '',
        origin: $('#originFilter').val() || '',
        destination: $('#destinationFilter').val() || '',
        flight_class: $('#flightClassFilter').val() || '',
        seller: $('#seller_id_filter').val() || '',
        fly_code: $('#flyCodeFilter').val() || '',
        departure_time_from: $('#departureTimeFrom').val() || '',
        departure_time_to: $('#departureTimeTo').val() || '',
        duration: $('#durationFilter').val() || '',
        status: $('#statusFilter').val() || '',
        week_days: $('#weekDaysFilterSelect').val() || [],
        page: currentPage,
        per_page: currentPerPage
    };

    const tableContainer = document.querySelector('.ShowResultManiFest');
    const paginationContainer = document.querySelector('.pagination-container');
    const mainTableContainer = document.querySelector('.table-container');
    const flightsTable = document.getElementById('flightsTable');
    const boxEditSelected = document.getElementById('BoxEditSelected');
    const boxEmptyState = document.querySelector('.empty-state');

    // مخفی کردن pagination تا بارگذاری انجام شود
    if (paginationContainer) paginationContainer.style.display = 'none';

    // نمایش loading داخل جدول
    if (tableContainer) {
        tableContainer.innerHTML = `
            <div class="loading-state" style="text-align: center; padding: 2rem;">
                <i class="fa fa-spinner fa-spin" style="font-size: 2rem; color: #007bff;"></i>
                <p style="margin-top: 1rem; color: #666;">در حال بارگذاری...</p>
            </div>
        `;
    }

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getPaginatedManifestTable',
            filters: filters,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            $(".loaderPublic").css("display","none");
            const hasData = response?.status && response?.data && response?.data?.data?.table_html;
            if (hasData) {
                if (tableContainer) tableContainer.innerHTML = response.data.data.table_html;

                // نمایش بخش‌ها
                if (mainTableContainer) mainTableContainer.style.display = '';
                if (flightsTable) flightsTable.style.display = '';
                if (boxEditSelected) boxEditSelected.style.display = '';
                if (boxEmptyState) boxEmptyState.style.display = 'none';

                setupEventListeners();
                updateRecordCount();

                // Destroy جدول قبلی اگر موجود باشد
                if ($.fn.DataTable.isDataTable('#flightsTable')) {
                    $('#flightsTable').DataTable().destroy();
                }
                const table = $('#flightsTable').DataTable({
                    pageLength: 200,
                    lengthMenu: [
                        [200, 400, 600, 800, 1000],
                        [200, 400, 600, 800, 1000]
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json'
                    },
                    ordering: false,
                    searching: true,
                    responsive: true,
                    scrollY: '70vh',
                    scrollCollapse: true,
                    paging: true,
                    fixedHeader: true,

                    initComplete: function() {
                        $('#flightsTable_wrapper .dataTables_filter, #flightsTable_wrapper .dataTables_length').css({
                            'margin': '10px'
                        });
                    }
                });

                table.on('draw.dt', function () {
                    $('.dataTables_scrollHeadInner').css({
                        'width': '100%',
                        'padding-left': '0'
                    });
                });
                $('.dataTables_scrollHeadInner').css({
                    'width': '100%',
                    'padding-left': '0'
                });
                $('[data-toggle="tooltip"]').tooltip();

            } else {
                // در صورت نبود داده‌ها
                if (mainTableContainer) mainTableContainer.style.display = 'none';
                if (flightsTable) flightsTable.style.display = 'none';
                if (boxEditSelected) boxEditSelected.style.display = 'none';

                if (tableContainer) {
                    tableContainer.innerHTML = `
                        <div class="empty-state" style="text-align:center; padding:2rem;">
                            <i class="fa fa-plane-slash" style="font-size:2rem; color:#888;"></i>
                            <h3 style="margin-top:1rem;">هیچ پروازی یافت نشد</h3>
                            <p>هیچ پرواز یا بلیطی در سیستم رزرواسیون یافت نشد.</p>
                            <button class="btn btn-primary" onclick="loadManifestData()">
                                <i class="fa fa-refresh"></i> بروز رسانی
                            </button>
                        </div>
                    `;
                }
            }
        },
        error: function() {
            $(".loaderPublic").css("display","none");
            showErrorMessage('خطا در ارتباط با سرور');
        }
    });
}


// Utility functions
function formatDate(dateString) {
    // Convert date format if needed
    if (dateString && dateString.length === 8) {
        const year = dateString.substring(0, 4);
        const month = dateString.substring(4, 6);
        const day = dateString.substring(6, 8);
        return `${year}/${month}/${day}`;
    }
    return dateString;
}

function formatTime(timeString) {
    // Format time string if needed
    if (timeString && timeString.length === 4) {
        const hour = timeString.substring(0, 2);
        const minute = timeString.substring(2, 4);
        return `${hour}:${minute}`;
    }
    return timeString;
}

// Parse duration string (HH:MM:SS) to minutes
function parseDurationToMinutes(durationString) {
    if (!durationString) return 0;
    
    const parts = durationString.split(':');
    if (parts.length < 2) return 0;
    
    const hours = parseInt(parts[0]) || 0;
    const minutes = parseInt(parts[1]) || 0;
    
    return (hours * 60) + minutes;
}
// انتخاب فروشنده
function selectSellerFilter(id, name) {
    document.getElementById("seller_id_filter").value = id;
    document.getElementById("sellerDropdownFilterText").innerText = name;
    $('.dropdown-menu').removeClass('show');
    $('#sellerDropdownFilter').dropdown('toggle');
}

// انتخاب پرواز
function selectFlight(id, name) {
    document.getElementById("flyCodeFilter").value = id;
    document.getElementById("flightDropdownFilterText").innerText = name;
    $('.dropdown-menu').removeClass('show');
    $('#flightDropdownFilter').dropdown('toggle');
}

// فیلتر جستجو در فروشنده
function filterSellerListFilter(input) {
    var filter = input.value.toLowerCase();
    $('#seller_list_filter li').each(function() {
        $(this).toggle($(this).text().toLowerCase().includes(filter));
    });
}

// فیلتر جستجو در پرواز
function filterFlightList(input) {
    var filter = input.value.toLowerCase();
    $('#flight_list li').each(function() {
        $(this).toggle($(this).text().toLowerCase().includes(filter));
    });
}
// ======= 1) پس از رندر کردن Content =======
$('#globalOperationContent').html(Content);

// ======= 2) پر کردن لیست شماره پرواز =======
function esc(str){
    return String(str === null || typeof str === 'undefined' ? '' : str).replace(/"/g,'&quot;');
}
function populateFlyCodeList(list){
    let flyListHtml = list.map(f => {
        return `<li>
                    <a href="javascript:void(0)" class="dropdown-item py-1" data-id="${f.id}" data-text="${esc(f.name)}">
                        ${esc(f.name)}
                    </a>
                </li>`;
    }).join('');
    $('#flyCode_list').html(flyListHtml);

    // event کلیک روی آیتم‌ها
    $('#flyCode_list a').off('click').on('click', function(e){
        e.preventDefault();
        const id = $(this).data('id');
        const text = $(this).data('text');
        $('#flyCodeDropdownText').text(text);
        $('#flyCode_idModal').val(id);
        $('#flyCode_textModal').val(text);
    });

    // فیلتر جستجو
    // 1) فیلتر جستجو و همزمان ست کردن متن تایپ‌شده
    // 1) فیلتر جستجو و همزمان ست کردن متن تایپ‌شده
    $('#flyCodeSearchInput').off('keyup').on('keyup', function(){
        const typed = $(this).val().trim().toLowerCase();
        $('#flyCode_textModal').val($(this).val());

        $('#flyCode_list li').each(function(){
            const txt = $(this).text().toLowerCase();
            $(this).toggle(txt.indexOf(typed) !== -1);
        });

        // اگر دقیقا match با آیتم موجود داشت، hidden id را هم ست کن
        const matched = ListAllFlyCode.find(f => f.name.toLowerCase() === typed);
        if (matched) {
            $('#flyCode_idModal').val(matched.id);
            $('#flyCodeDropdownText').text(matched.name);
        } else {
            // آیتم جدید است
            $('#flyCode_idModal').val('');
            $('#flyCodeDropdownText').text($(this).val());
        }
    });



    // فوکوس هنگام باز شدن dropdown
    $('#flyCodeDropdown').on('shown.bs.dropdown', function () {
        $('#flyCodeSearchInput').val('');
        $('#flyCodeSearchInput').focus();
    });
}

// ======= 3) ست کردن مقدار پیش‌فرض =======
function selectFlyCodeDefault(info_parvaz, list){
    let found = list.find(f => String(f.id) === String(info_parvaz.IdFlyCode));
    if(found){
        $('#flyCodeDropdownText').text(found.name);
        $('#flyCode_idModal').val(found.id);
        $('#flyCode_textModal').val(found.name);
    } else if(info_parvaz.NumberFlyCode){
        $('#flyCodeDropdownText').text(info_parvaz.NumberFlyCode);
        $('#flyCode_idModal').val('');
        $('#flyCode_textModal').val(info_parvaz.NumberFlyCode);
    } else {
        $('#flyCodeDropdownText').text('انتخاب کنید');
        $('#flyCode_idModal').val('');
        $('#flyCode_textModal').val('');
    }
}
// وقتی کاربر input را ترک کرد یا dropdown بسته شد
$('#flyCodeDropdown').on('hide.bs.dropdown', function () {
    const typed = $('#flyCodeSearchInput').val().trim();
    const found = ListAllFlyCode.find(f => f.name === typed);
    if (!found && typed.length > 0) {
        // آیتم جدید تایپ شده
        $('#flyCodeDropdownText').text(typed);
        $('#flyCode_textModal').val(typed);
        $('#flyCode_idModal').val(''); // یعنی آیتم جدید است
    }
});
// ======= 4) فراخوانی =======
populateFlyCodeList(ListAllFlyCode);
selectFlyCodeDefault(info_parvaz, ListAllFlyCode);

function openBulkEditModal(ticket_id) {
    // عنوان مودال
    $('#globalOperationTitle').text('ویرایش برنامه پروازی');
    // Show loading state
    const loadingContent = `
        <div class="flight-details-loading">
            <div class="loading-spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <p>در حال بارگذاری اطلاعات پایه برنامه پرواز...</p>
        </div>
    `;
    $('#globalOperationContent').html(loadingContent);
    $('#globalOperationModal .modal-dialog').addClass('modal-xl');
    $('#globalOperationModal').modal('show');

    // Load flight details via AJAX
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightSchedule',
            ticket_id: ticket_id,
            to_json: true
        }),
        contentType: "application/json",
        success: function(response) {
            if (response.status === "success" && response.data && response.data.status) {
                const info_parvaz = response.data.data;

                // ساخت options برای فروشنده
                let agencyOptions = agencies.map(a =>
                   `<option value="${a.id}" ${a.id == info_parvaz.SellerId ? 'selected' : ''}>${a.name}</option>`
                ).join('');

                // فیلتر کردن فقط نوع هواپیماهایی که با TypeOfVehicleId یکی هستند
                let airplaneOptions = TypeOfPlanes
                   .filter(p => p.id_vehicle == info_parvaz.TypeOfVehicleId)
                   .map(p =>
                      `<option value="${p.id}" ${p.id == info_parvaz.TypeOfPlane ? 'selected' : ''}>
                            ${p.name} (${p.abbreviation})
                        </option>`
                   )
                   .join('');

                // ساخت HTML دراپ‌داون برای شماره پرواز (قرار می‌دیم داخل Content)
                const flyCodeDropdownHtml = `
                    <div class="filter-group" style="position: relative; width: 100%;">
                       <div class="d-flex align-items-center mb-1">
                            <input type="checkbox" class="ml-2 update-field" id="chkFlyCode">
                            <label for="flyCodeDropdown" class="mb-0">شماره پرواز:</label>
                       </div>
                    
                        <div class="dropdown">
                            <div class="form-control filter-select dropdown-toggle d-flex justify-content-between align-items-center"
                                 id="flyCodeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                 role="button" style="padding: 0.75rem 1rem !important;">
                                <span id="flyCodeDropdownText">انتخاب کنید</span>
                                <i class="fa fa-chevron-down small" aria-hidden="true"></i>
                            </div>
                    
                            <div class="dropdown-menu w-100 p-2" aria-labelledby="flyCodeDropdown"
                                 style="max-height:260px; overflow-y:auto;">
                                <input type="text" id="flyCodeSearchInput" class="form-control form-control-sm mb-2"
                                       placeholder="جستجو یا شماره جدید...">
                                <ul id="flyCode_list" class="list-unstyled mb-0"></ul>
                            </div>
                        </div>
                    
                        <input type="hidden" name="flyCode_idModal" id="flyCode_idModal">
                        <input type="hidden" name="flyCode_textModal" id="flyCode_textModal">
                    </div>
                    `;
                const Content = `
                      <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-warning text-center" role="alert" style="font-weight: 500;">
                                ⚠️ فقط اطلاعات پیش‌فرض اولین رکورد انتتخاب شده، نمایش داده شده است.<br/>
                                هر فیلدی که تیکش خورده باشد، آن فیلد را برای همه رکوردها اعمال خواهیم کرد.
                            </div>
                        </div>
                      </div>
                      <div class="row">
                            <div class="form-group text-right col-md-6">
                                <div class="d-flex align-items-center mb-1">
                                    <input type="checkbox" class="ml-2 update-field" id="chkSellerId">
                                    <label for="SellerId" class="mb-0">نام فروشنده:</label>
                                </div>
                                <select id="SellerId" class="form-control">${agencyOptions}</select>
                            </div>
                        
                            <div class="form-group text-right col-md-6">
                                <div class="d-flex align-items-center mb-1">
                                    <input type="checkbox" class="ml-2 update-field" id="chkSellerPrice">
                                    <label for="SellerPrice" class="mb-0">قیمت هر صندلی:</label>
                                </div>
                                <input type="text" id="SellerPrice" class="form-control" value="${info_parvaz.SellerPrice || ''}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group text-right col-md-6">
                                ${flyCodeDropdownHtml}
                            </div>
                        
                            <div class="form-group text-right col-md-6">
                                <div class="d-flex align-items-center mb-1">
                                    <input type="checkbox" class="ml-2 update-field" id="chkExitHour">
                                    <label for="exitHour" class="mb-0">ساعت پرواز:</label>
                                </div>
                                <input type="text" id="exitHour" class="form-control" value="${info_parvaz.ExitHours || ''}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group text-right col-md-6">
                                <div class="d-flex align-items-center mb-1">
                                    <input type="checkbox" class="ml-2 update-field" id="chkFree">
                                    <label for="free" class="mb-0">بار مجاز:</label>
                                </div>
                                <input type="text" id="free" class="form-control" value="${info_parvaz.Free || ''}">
                            </div>
                        
                            <div class="form-group text-right col-md-6">
                                <div class="d-flex align-items-center mb-1">
                                    <input type="checkbox" class="ml-2 update-field" id="chkTypeOfPlane">
                                    <label for="typeOfPlane" class="mb-0">نوع هواپیما:</label>
                                </div>
                                <select id="typeOfPlane" class="form-control">${airplaneOptions}</select>
                            </div>
                        </div>
                        
                        <div class="form-group text-right mt-3">
                            <button class="btn btn-success btn-block" onclick="saveBulkEdit()">
                                <i class="fa fa-save"></i> ذخیره
                            </button>
                        </div>


                    `;

                $('#globalOperationContent').html(Content);
                populateFlyCodeList(ListAllFlyCode);
                selectFlyCodeDefault(info_parvaz, ListAllFlyCode);
            } else {
                showErrorModal((response.data && response.data.message) || 'خطا در بارگذاری اطلاعات پایه برنامه پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}
function saveBulkEdit() {
    // شیء پایه برای ارسال
    let dataToSend = {
        className: 'manifestController',
        method: 'setBulkEdit',
        ticket_ids: selectedTickets,
        to_json: true
    };

    // فقط فیلدهایی که تیک خوردن به dataToSend اضافه می‌شن
    if ($('#chkSellerId').is(':checked')) dataToSend.SellerId = $('#SellerId').val();
    if ($('#chkSellerPrice').is(':checked')) dataToSend.SellerPrice = $('#SellerPrice').val();
    if ($('#chkExitHour').is(':checked')) dataToSend.exitHour = $('#exitHour').val();
    if ($('#chkTypeOfPlane').is(':checked')) dataToSend.typeOfPlane = $('#typeOfPlane').val();
    if ($('#chkFree').is(':checked')) dataToSend.free = $('#free').val();
    if ($('#chkFlyCode').is(':checked')) {
        dataToSend.flyCode_id = $('#flyCode_idModal').val();
        dataToSend.flyCode_text = $('#flyCode_textModal').val();
    }

    // اگر هیچ تیکی نخوره، جلو ارسال رو بگیریم
    if (Object.keys(dataToSend).length <= 4) { // یعنی فقط فیلدهای پایه وجود دارن
        showErrorModal('هیچ فیلدی برای ویرایش انتخاب نشده است.');
        return;
    }

    // ارسال داده با Ajax
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify(dataToSend),
        contentType: "application/json",
        success: function(response) {
            if (response.status) {
                $('#globalOperationContent').html(`
                    <div class="text-center">
                        <i class="fa fa-check-circle text-success fa-2x"></i>
                        <p>${response.message || 'برنامه پرواز با موفقیت ویرایش شد.'}</p>
                    </div>
                `);

                setTimeout(function() {
                    $('#globalOperationModal').modal('hide');
                    loadManifestData();
                }, 1000);
            } else {
                showErrorModal(response.message || 'خطا در ویرایش برنامه پرواز.');
            }
        },
        error: function() {
            showErrorModal('خطا در ارتباط با سرور.');
        }
    });
}

function FunCreateExcelManifest() {
    $(".loaderPublic").css("display","block");
    const filters = {
        date_from: document.getElementById('dateFrom') ? document.getElementById('dateFrom').value : '',
        date_to: document.getElementById('dateTo') ? document.getElementById('dateTo').value : '',
        airline: document.getElementById('airlineFilter') ? document.getElementById('airlineFilter').value : '',
        origin: document.getElementById('originFilter') ? document.getElementById('originFilter').value : '',
        destination: document.getElementById('destinationFilter') ? document.getElementById('destinationFilter').value : '',
        flight_class: document.getElementById('flightClassFilter') ? document.getElementById('flightClassFilter').value : '',
        seller: document.getElementById('seller_id_filter') ? document.getElementById('seller_id_filter').value : '',
        fly_code: document.getElementById('flyCodeFilter') ? document.getElementById('flyCodeFilter').value : '',
        departure_time_from: document.getElementById('departureTimeFrom') ? document.getElementById('departureTimeFrom').value : '',
        departure_time_to: document.getElementById('departureTimeTo') ? document.getElementById('departureTimeTo').value : '',
        duration: document.getElementById('durationFilter') ? document.getElementById('durationFilter').value : '',
        status: document.getElementById('statusFilter') ? document.getElementById('statusFilter').value : '',
        week_days: $('#weekDaysFilterSelect').val() || [],
        OutForExcelManifest:'Yes'
    };

    // Send AJAX request
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getPaginatedManifestTable',
            filters: filters,
            to_json: true
        }),
        contentType: "application/json",
        success: function (data) {
            $(".loaderPublic").css("display","none");
            if (data.data.status == 'success') {
                var res = data.data.data.split('|'); // ← اینجا از data.data استفاده کن
                var url = amadeusPath + 'pic/excelFile/' + res[1];
                var isFileExists = fileExists(url);
                if (isFileExists) {
                    window.open(url, 'Download');
                } else {
                    $.toast({
                        heading: 'دریافت فایل اکسل',
                        text: 'متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید.',
                        position: 'top-right',
                        loaderBg: '#fff',
                        icon: 'error',
                        hideAfter: 3500,
                        textAlign: 'right',
                        stack: 6
                    });
                }
            } else {
                // اگر message فرمت 'error|text' داشته باشه، فقط text رو نشون بده
                var errorMessage = 'خطا در دریافت فایل اکسل';
                if (data.message && data.message.indexOf('|') > -1) {
                    var parts = data.message.split('|');
                    errorMessage = parts[1] || errorMessage;
                } else if (data.message) {
                    errorMessage = data.message;
                }

                $.toast({
                    heading: 'دریافت فایل اکسل',
                    text: errorMessage,
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
            showErrorMessage('خطا در ارتباط با سرور');
        }
    });
}

function FunPrintManifest() {
    $(".loaderPublic").css("display","block");
    const dateFrom = $('#dateFrom').val() ? $('#dateFrom').val() : '';
    const dateTo = $('#dateTo').val() ? $('#dateTo').val() : '';

    const filters = {
        date_from: $('#dateFrom').val() || '',
        date_to: $('#dateTo').val() || '',
        airline: $('#airlineFilter').val() || '',
        origin: $('#originFilter').val() || '',
        destination: $('#destinationFilter').val() || '',
        flight_class: $('#flightClassFilter').val() || '',
        seller: $('#seller_id_filter').val() || '',
        fly_code: $('#flyCodeFilter').val() || '',
        departure_time_from: $('#departureTimeFrom').val() || '',
        departure_time_to: $('#departureTimeTo').val() || '',
        duration: $('#durationFilter').val() || '',
        status: $('#statusFilter').val() || '',
        week_days: $('#weekDaysFilterSelect').val() || [],
        OutForPrintManifest: 'Yes'
    };

    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getPaginatedManifestTable',
            filters: filters,
            to_json: true
        }),
        contentType: "application/json",
        success: function (response) {
            $(".loaderPublic").css("display","none");
            // بررسی ساختار صحیح پاسخ
            const hasData = response?.status === 'success' && response?.data?.data?.table_html;

            if (hasData) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = response.data.data.table_html;

                // حذف ستون اول و آخر از هدر
                $(tempDiv).find('thead tr').each(function() {
                    $(this).find('th:first-child, th:last-child').remove();
                });

                // حذف ستون اول و آخر از بدنه
                $(tempDiv).find('tbody tr').each(function() {
                    $(this).find('td:first-child, td:last-child').remove();
                });
                const tableHtml = tempDiv.innerHTML;

                $('#btn-print_manifest').css('opacity', '1');
                $('#loader-excel').addClass('displayN');

                const win = window.open('', '_blank');
                win.document.open();
                win.document.write(`
               <html>
               <head>
                   <title>لیست پروازها</title>
                   <meta charset="utf-8">
                   <style>
                       body { font-family: tahoma; direction: rtl; text-align: center; margin: 30px; }
                       h3 { margin-bottom: 20px; }
                       table { border-collapse: collapse; width: 100%; }
                       th, td { border: 1px solid #ccc; padding: 6px; font-size: 13px; }
                       th { background-color: #eee; }
                       @media print {
                           button { display: none; }
                           body { margin: 0; }
                       }
                   </style>
               </head>
              <body>
                    <h3>لیست پروازها</h3>
                    <p style="font-size:13px; color:#555;direction: rtl;">
                       <b> ${dateFrom || '-'} </b>
                       <b> تا </b>
                       <b> ${dateTo || '-'} </b>
                    </p>
                    ${tableHtml}
                    <button onclick="window.print()">چاپ</button>
              </body>
             </html>
            `);
                win.document.close();
            } else {
                console.error('ساختار پاسخ اشتباه است:', response);
                showErrorMessage('خطا در دریافت داده برای پرینت');
            }
        },
        error: function () {
            showErrorMessage('خطا در ارتباط با سرور');
        }
    });
}

function fileExists(url) {
    if(url){
        var req = new XMLHttpRequest();
        req.open('GET', url, false);
        req.send();
        return req.status == 200;
    } else {
        return false;
    }
}
function FunCreateExcelNira() {

    // ─── گرفتن تعداد رکورد از کاربر ─── //
    var count_type = prompt("تعداد رکورد در فایل اکسل را وارد کنید (5 یا 9):", "5");
    if (count_type === null) return;     // کاربر لغو کرد
    count_type = count_type.trim();

    if (count_type !== "5" && count_type !== "9") {
        alert("عدد فقط باید 5 یا 9 باشد.");
        return;
    }

   $(".loaderPublic").css("display","block");
    $.ajax({
        type: "post",
        url: `${amadeusPath}ajax`,
        data: JSON.stringify({
            className: 'manifestController',
            method: 'getFlightDetails',
            ticket_id: ticket_id_ForExcelNira,
            ChkExcelNira: 'Yes',
            count_type: count_type,
            to_json: true
        }),
        contentType: "application/json",
        success: function (data) {
            $(".loaderPublic").css("display","none");
            console.log(data); // همیشه خروجی را چک کن

            if (data.status === 'success' && data.fileName) {
                var url = amadeusPath + 'pic/excelFile/' + data.fileName;
                window.open(url, '_blank');
            } else {
                $.toast({
                    heading: 'دریافت فایل اکسل',
                    text: data.message || 'خطا در دریافت فایل اکسل',
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
            showErrorMessage('خطا در ارتباط با سرور');
        }
    });
}