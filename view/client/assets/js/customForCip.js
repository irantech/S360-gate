/**
 * CIP Passenger Form Manager
 * Manages passenger input forms based on selectedCip data from localStorage
 */

(function() {
    'use strict';

    // Country list for nationality dropdown
    const countries = [
        { code: 'IR', name: 'ایران', nameEn: 'Iran' },
        { code: 'AF', name: 'افغانستان', nameEn: 'Afghanistan' },
        { code: 'AE', name: 'امارات', nameEn: 'UAE' },
        { code: 'TR', name: 'ترکیه', nameEn: 'Turkey' },
        { code: 'IQ', name: 'عراق', nameEn: 'Iraq' },
        { code: 'SA', name: 'عربستان', nameEn: 'Saudi Arabia' },
        { code: 'PK', name: 'پاکستان', nameEn: 'Pakistan' },
        { code: 'IN', name: 'هند', nameEn: 'India' },
        { code: 'CN', name: 'چین', nameEn: 'China' },
        { code: 'RU', name: 'روسیه', nameEn: 'Russia' },
        { code: 'DE', name: 'آلمان', nameEn: 'Germany' },
        { code: 'FR', name: 'فرانسه', nameEn: 'France' },
        { code: 'GB', name: 'انگلستان', nameEn: 'United Kingdom' },
        { code: 'US', name: 'آمریکا', nameEn: 'United States' },
        { code: 'CA', name: 'کانادا', nameEn: 'Canada' },
        { code: 'AU', name: 'استرالیا', nameEn: 'Australia' }
    ];

    /**
     * Get passenger data from localStorage
     */
    function getSelectedCip() {
        try {
            const cipData = localStorage.getItem('selectedCip');
            if (!cipData) {
                console.warn('No selectedCip found in localStorage');
                return null;
            }

            // Check expiration
            const expiration = localStorage.getItem('cipExpiration');
            if (expiration && new Date().getTime() > parseInt(expiration)) {
                console.warn('CIP data has expired');
                localStorage.removeItem('selectedCip');
                localStorage.removeItem('cipExpiration');
                return null;
            }

            return JSON.parse(cipData);
        } catch (error) {
            console.error('Error reading selectedCip from localStorage:', error);
            return null;
        }
    }

    /**
     * Get passenger quantity from CIP data (from PassengerDatas array)
     * Structure: PassengerDatas[].PassengerQuantity contains the count for each type
     */
    function getPassengerQuantity(cipData) {
        if (!cipData || !cipData.PassengerDatas || !Array.isArray(cipData.PassengerDatas)) {
            return { adult: 1, child: 0, infant: 0 };
        }

        const passengerDatas = cipData.PassengerDatas;

        let adult = 0;
        let child = 0;
        let infant = 0;

        passengerDatas.forEach(passenger => {
            const type = passenger.PassengerType ? passenger.PassengerType.toUpperCase() : '';
            const qty = parseInt(passenger.PassengerQuantity) || 0;

            switch (type) {
                case 'ADT':
                    adult = qty;
                    break;
                case 'CHD':
                    child = qty;
                    break;
                case 'INF':
                    infant = qty;
                    break;
            }
        });

        // If no passengers found, default to 1 adult
        if (adult === 0 && child === 0 && infant === 0) {
            adult = 1;
        }

        console.log('Passenger counts:', { adult, child, infant });
        return { adult, child, infant };
    }

    /**
     * Generate country options HTML
     */
    function generateCountryOptions(selectedCode = 'IR') {
        return countries.map(country =>
            `<option value="${country.code}" ${country.code === selectedCode ? 'selected' : ''}>
                ${country.name} (${country.nameEn})
            </option>`
        ).join('');
    }

    /**
     * Generate single passenger form HTML - Classic 3-column layout
     */
    function generatePassengerForm(index, type, typeLabel) {
        const typeClass = type.toLowerCase();

        return `
        <div class="cip-passenger-box" data-passenger-index="${index}" data-passenger-type="${type}">
            <div class="cip-passenger-header">
                <div class="cip-passenger-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="cip-passenger-title">
                    <span class="cip-passenger-number">مسافر ${index + 1}</span>
                    <span class="cip-passenger-type cip-passenger-type-${typeClass}">${typeLabel}</span>
                </div>
                <span class="cip-phonebook-btn" onclick="cipOpenPhonebook('CIP${index}')">
                    <i class="fa-solid fa-address-book"></i> دفترچه تلفن
                </span>
            </div>

            <div class="cip-passenger-body">
                <!-- Row 1: Name, Family, Gender -->
                <div class="cip-form-row">
                    <div class="cip-form-group">
                        <label class="cip-label">
                            نام (انگلیسی)
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   id="nameEnCIP${index}"
                                   name="passengers[${index}][firstName]"
                                   class="cip-input"
                                   placeholder="First Name"
                                   pattern="[A-Za-z\s]+"
                                   data-validate="english-name"
                                   required>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <label class="cip-label">
                            نام خانوادگی (انگلیسی)
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   id="familyEnCIP${index}"
                                   name="passengers[${index}][lastName]"
                                   class="cip-input"
                                   placeholder="Last Name"
                                   pattern="[A-Za-z\s]+"
                                   data-validate="english-name"
                                   required>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <label class="cip-label">
                            جنسیت
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <select id="genderCIP${index}" name="passengers[${index}][gender]" class="cip-select" required>
                                <option value="">انتخاب کنید</option>
                                <option value="${type === 'ADT' ? 'MR' : 'MSTR'}">مرد</option>
                                <option value="${type === 'ADT' ? 'MS' : 'MISS'}">زن</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Row 2: BirthDate, Nationality, NationalCode -->
                <div class="cip-form-row">
                    <div class="cip-form-group">
                        <label class="cip-label">
                            تاریخ تولد
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   id="birthdayCIP${index}"
                                   name="passengers[${index}][birthDate]"
                                   class="cip-input cip-birthdate-picker"
                                   placeholder="1990/01/01"
                                   readonly
                                   data-passenger-type="${type}"
      
                                   style="cursor: pointer;"
                                   required>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <label class="cip-label">
                            ملیت
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <select id="nationalityCIP${index}"
                                    name="passengers[${index}][nationality]"
                                    class="cip-select cip-nationality-select"
                                    data-index="${index}"
                                    required>
                                ${generateCountryOptions('IR')}
                            </select>
                        </div>
                    </div>

                    <div class="cip-form-group cip-national-code-group" data-index="${index}">
                        <label class="cip-label">
                            کد ملی
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   id="NationalCodeCIP${index}"
                                   name="passengers[${index}][nationalCode]"
                                   class="cip-input"
                                   placeholder="0012345678"
                                   maxlength="10"
                                   data-validate="national-code"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Passport -->
                <div class="cip-form-row">
                    <div class="cip-form-group">
                        <label class="cip-label">
                            شماره گذرنامه
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   id="passportNumberCIP${index}"
                                   name="passengers[${index}][passportNumber]"
                                   class="cip-input"
                                   placeholder="A12345678"
                                   data-validate="passport"
                                   oninvalid="this.setCustomValidity('این فیلد الزامی است')"
                                   oninput="this.setCustomValidity('')"
                                   required>
                        </div>
                    </div>
                    <div class="cip-form-group">
                        <label class="cip-label">
                            تاریخ انقضا پاسپورت
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   id="passportExpireDateCIP${index}"
                                   name="passengers[${index}][passportExpireDate]"
                                   class="cip-input cip-passport-expire-picker"
                                   placeholder="2026/01/01"
                                   readonly
                                   style="cursor: pointer;"
                                   required>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="passengers[${index}][passengerType]" value="${type}">
            </div>
        </div>
        `;
    }

    /**
     * Generate all passenger forms
     */
    function generateAllPassengerForms(container, quantity) {
        let html = '';
        let index = 0;

        // Adults
        for (let i = 0; i < quantity.adult; i++) {
            html += generatePassengerForm(index, 'ADT', 'بزرگسال');
            index++;
        }

        // Children
        for (let i = 0; i < quantity.child; i++) {
            html += generatePassengerForm(index, 'CHD', 'کودک');
            index++;
        }

        // Infants
        for (let i = 0; i < quantity.infant; i++) {
            html += generatePassengerForm(index, 'INF', 'نوزاد');
            index++;
        }

        container.innerHTML = html;
    }

    /**
     * Initialize date pickers
     */
    function initializeDatePickers() {
        if (typeof $.fn.datepicker === 'undefined') return;

        // تاریخ تولد میلادی برای مسافران
        $('.cip-birthdate-picker').each(function() {
            var $el = $(this);
            if ($el.hasClass('hasDatepicker')) return;

            // تعیین محدودیت‌های سنی براساس نوع مسافر
            var passengerType = $el.data('passenger-type');
            var today = new Date();
            var maxDate = new Date();
            var minDate = null;
            var yearRange = '1920:2026';

            if (passengerType === 'INF') {
                // نوزاد: 0-2 سال
                minDate = new Date();
                minDate.setFullYear(today.getFullYear() - 2);
                yearRange = (today.getFullYear() - 2) + ':' + today.getFullYear();
            } else if (passengerType === 'CHD') {
                // کودک: 2-12 سال
                maxDate = new Date();
                maxDate.setFullYear(today.getFullYear() - 2);
                minDate = new Date();
                minDate.setFullYear(today.getFullYear() - 12);
                yearRange = (today.getFullYear() - 12) + ':' + (today.getFullYear() - 2);
            } else {
                // بزرگسال: بالای 12 سال
                maxDate = new Date();
                maxDate.setFullYear(today.getFullYear() - 12);
                yearRange = '1920:' + (today.getFullYear() - 12);
            }

            $el.datepicker({
                numberOfMonths: 1,
                maxDate: maxDate,
                minDate: minDate,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy/mm/dd',
                yearRange: yearRange,
                beforeShow: function(n) {
                    if (typeof e === 'function') e(n, true);
                    $("#ui-datepicker-div").addClass("INH_class_Datepicker");
                }
            });
            $el.datepicker('option', $.datepicker.regional['']);
            $el.datepicker('option', 'dateFormat', 'yy/mm/dd');
        });

        // تاریخ انقضا پاسپورت میلادی برای مسافران
        $('.cip-passport-expire-picker').each(function() {
            var $el = $(this);
            if ($el.hasClass('hasDatepicker')) return;

            $el.datepicker({
                numberOfMonths: 1,
                minDate: new Date(),
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy/mm/dd',
                yearRange: '2025:2040',
                beforeShow: function(n) {
                    if (typeof e === 'function') e(n, true);
                    $("#ui-datepicker-div").addClass("INH_class_Datepicker");
                }
            });
            $el.datepicker('option', $.datepicker.regional['']);
            $el.datepicker('option', 'dateFormat', 'yy/mm/dd');
        });
    }

    /**
     * Handle nationality change
     */
    function handleNationalityChange(event) {
        const select = event.target;
        const index = select.dataset.index;
        const nationalCodeGroup = document.querySelector(`.cip-national-code-group[data-index="${index}"]`);
        const nationalCodeInput = nationalCodeGroup.querySelector('input');
        const passportInput = document.querySelector(`input[name="passengers[${index}][passportNumber]"]`);
        const passportLabel = passportInput.closest('.cip-form-group').querySelector('.cip-optional');

        if (select.value === 'IR') {
            // Iranian: National code required, passport optional
            nationalCodeGroup.style.display = 'block';
            nationalCodeInput.required = true;
            passportInput.required = false;
            if (passportLabel) passportLabel.textContent = '(اختیاری برای ایرانیان)';
        } else {
            // Non-Iranian: Passport required, national code hidden
            nationalCodeGroup.style.display = 'none';
            nationalCodeInput.required = false;
            nationalCodeInput.value = '';
            passportInput.required = true;
            if (passportLabel) passportLabel.textContent = '(الزامی)';
        }
    }

    /**
     * Validate English name
     */
    function validateEnglishName(value) {
        return /^[A-Za-z\s]+$/.test(value);
    }

    /**
     * Validate Iranian national code
     */
    function validateNationalCode(code) {
        if (!/^\d{10}$/.test(code)) return false;

        const check = parseInt(code[9]);
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(code[i]) * (10 - i);
        }
        const remainder = sum % 11;
        return (remainder < 2 && check === remainder) || (remainder >= 2 && check === 11 - remainder);
    }

    /**
     * Validate form field
     */
    function validateField(input) {
        const validateType = input.dataset.validate;
        const value = input.value.trim();
        let isValid = true;
        let errorMessage = '';

        if (input.required && !value) {
            isValid = false;
            errorMessage = 'این فیلد الزامی است';
        } else if (value) {
            switch (validateType) {
                case 'english-name':
                    if (!validateEnglishName(value)) {
                        isValid = false;
                        errorMessage = 'فقط حروف انگلیسی مجاز است';
                    }
                    break;
                case 'national-code':
                    if (input.required && !validateNationalCode(value)) {
                        isValid = false;
                        errorMessage = 'کد ملی نامعتبر است';
                    }
                    break;
                case 'passport':
                    if (input.required && !value) {
                        isValid = false;
                        errorMessage = 'این فیلد الزامی است';
                    }
                    break;
            }
        }

        // Update UI
        const formGroup = input.closest('.cip-form-group');
        const existingError = formGroup.querySelector('.cip-error-message');

        if (existingError) {
            existingError.remove();
        }

        if (!isValid) {
            formGroup.classList.add('cip-has-error');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'cip-error-message';
            errorDiv.textContent = errorMessage;
            formGroup.appendChild(errorDiv);
        } else {
            formGroup.classList.remove('cip-has-error');
        }

        return isValid;
    }

    /**
     * Validate all forms
     */
    function validateAllForms() {
        const inputs = document.querySelectorAll('.cip-passenger-box input[required], .cip-passenger-box select[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    /**
     * Get all passenger data
     */
    function getAllPassengerData() {
        const boxes = document.querySelectorAll('.cip-passenger-box');
        const passengers = [];

        boxes.forEach((box, index) => {
            const passenger = {
                firstName: box.querySelector(`input[name="passengers[${index}][firstName]"]`).value,
                lastName: box.querySelector(`input[name="passengers[${index}][lastName]"]`).value,
                gender: box.querySelector(`select[name="passengers[${index}][gender]"]`).value,
                birthDate: box.querySelector(`input[name="passengers[${index}][birthDate]"]`).value,
                nationality: box.querySelector(`select[name="passengers[${index}][nationality]"]`).value,
                nationalCode: box.querySelector(`input[name="passengers[${index}][nationalCode]"]`).value,
                passportNumber: box.querySelector(`input[name="passengers[${index}][passportNumber]"]`).value,
                passportExpireDate: box.querySelector(`input[name="passengers[${index}][passportExpireDate]"]`).value,
                passengerType: box.querySelector(`input[name="passengers[${index}][passengerType]"]`).value
            };
            passengers.push(passenger);
        });

        return passengers;
    }

    /**
     * Get all service data including extra inputs
     */
    function getAllServiceData() {
        const serviceRows = document.querySelectorAll('.cip-service-row, .cip-service-card');
        const processedIds = new Set();
        const result = [];

        serviceRows.forEach(row => {
            const serviceId = row.getAttribute('data-service-id');
            if (processedIds.has(serviceId)) return;
            processedIds.add(serviceId);

            const quantityInput = document.getElementById(`cip-service-${serviceId}`) ||
                                  document.getElementById(`cip-service-${serviceId}-mobile`);
            const quantity = quantityInput ? (parseInt(quantityInput.value) || 0) : 0;

            if (quantity <= 0) return;

            // به ازای هر واحد از سرویس یک آبجکت جدا با ServiceInputAnswer
            for (let i = 0; i < quantity; i++) {
                const inputValues = [];
                const inputs = document.querySelectorAll(`[name^="services[cip-service-${serviceId}][units][${i}]"]`);
                inputs.forEach(input => {
                    const match = input.name.match(/\[units\]\[\d+\]\[(.+?)\]$/);
                    if (match) {
                        const fieldName = match[1];
                        let value = input.value || '';

                        if (fieldName === 'luggage_count' && value) {
                            value = 'Bag:' + value;
                        } else if (fieldName === 'passenger_count' && value) {
                            value = 'Pax:' + value;
                        }

                        if (value) {
                            inputValues.push(value);
                        }
                    }
                });

                result.push({
                    CipId: serviceId,
                    CipName: (row.querySelector('strong') ? row.querySelector('strong').textContent.trim() : ''),
                    Price: row.getAttribute('data-unit-price') || 0,
                    ServiceInputAnswer: inputValues.join('<br />')
                });
            }
        });

        return result;
    }

    /**
     * Generate Flight Info Box HTML
     */
    function convertToPersianDate(gregorianDate) {
        if (!gregorianDate) return '';

        try {
            const date = new Date(gregorianDate);

            if (isNaN(date.getTime())) {
                console.error('Invalid date format:', gregorianDate);
                return '';
            }

            const gy = date.getFullYear();
            const gm = date.getMonth() + 1;
            const gd = date.getDate();

            // الگوریتم استاندارد تبدیل میلادی به شمسی
            const g_d_m = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
            const gy2 = (gm > 2) ? (gy + 1) : gy;
            let days = 355666 + (365 * gy) + Math.floor((gy2 + 3) / 4) - Math.floor((gy2 + 99) / 100) + Math.floor((gy2 + 399) / 400) + gd + g_d_m[gm - 1];

            let jy = -1595 + (33 * Math.floor(days / 12053));
            days = days % 12053;

            jy += 4 * Math.floor(days / 1461);
            days = days % 1461;

            if (days > 365) {
                jy += Math.floor((days - 1) / 365);
                days = (days - 1) % 365;
            }

            let jm, jd;
            if (days < 186) {
                jm = 1 + Math.floor(days / 31);
                jd = 1 + (days % 31);
            } else {
                jm = 7 + Math.floor((days - 186) / 30);
                jd = 1 + ((days - 186) % 30);
            }

            const persianMonths = [
                'فروردین', 'اردیبهشت', 'خرداد',
                'تیر', 'مرداد', 'شهریور',
                'مهر', 'آبان', 'آذر',
                'دی', 'بهمن', 'اسفند'
            ];

            return {
                year: jy,
                month: jm,
                day: jd,
                monthName: persianMonths[jm - 1],
                fullDate: `${jy}/${jm.toString().padStart(2, '0')}/${jd.toString().padStart(2, '0')}`,
                readableDate: `${jd} ${persianMonths[jm - 1]} ${jy}`
            };

        } catch (error) {
            console.error('Error converting date:', error);
            return '';
        }
    }

// تابع ساده‌تر برای استفاده سریع
    function toPersianDateSimple(dateStr) {
        const result = convertToPersianDate(dateStr);
        return result ? result.fullDate : '';
    }

    /**
     * تبدیل تاریخ شمسی به میلادی
     * @param {string} persianDate - تاریخ شمسی به فرمت "yyyy/MM/dd"
     * @returns {string} تاریخ میلادی به فرمت "yyyy-MM-dd"
     */
    function persianToGregorian(persianDate) {
        if (!persianDate) return '';

        try {
            // تبدیل ارقام فارسی/عربی به انگلیسی
            persianDate = persianDate.replace(/[۰-۹]/g, function(d) {
                return d.charCodeAt(0) - 1776;
            }).replace(/[٠-٩]/g, function(d) {
                return d.charCodeAt(0) - 1632;
            });

            const parts = persianDate.split('/');
            if (parts.length !== 3) return '';

            const jy = parseInt(parts[0]);
            const jm = parseInt(parts[1]);
            const jd = parseInt(parts[2]);

            if (isNaN(jy) || isNaN(jm) || isNaN(jd)) return '';

            // الگوریتم استاندارد تبدیل شمسی به میلادی
            let gy = (jy <= 979) ? 621 : 1600;
            let jyAdj = (jy <= 979) ? jy : (jy - 979);

            gy += 365 * jyAdj;

            let tempDays = Math.floor(jyAdj / 33) * 8 + Math.floor(((jyAdj % 33) + 3) / 4);
            gy += tempDays;

            let days;
            if (jm <= 6) {
                days = (jm - 1) * 31;
            } else {
                days = (jm - 7) * 30 + 186;
            }
            days += jd - 1;

            let gm = 0;
            let gd = 0;

            gy += Math.floor(days / 365);
            days = days % 365;

            // اگر jy <= 979 باشه، 79 روز اضافه میکنیم (فاصله ابتدای سال میلادی تا 1 فروردین)
            if (jy <= 979) {
                days += 79;
            } else {
                days += 80;
            }

            if (days >= 365) {
                gy++;
                days -= 365;

                // بررسی کبیسه میلادی
                const isLeap = (gy % 4 === 0 && gy % 100 !== 0) || (gy % 400 === 0);
                if (isLeap && days >= 366) {
                    gy++;
                    days -= 366;
                }
            }

            const gDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            const isLeapYear = (gy % 4 === 0 && gy % 100 !== 0) || (gy % 400 === 0);
            if (isLeapYear) gDaysInMonth[1] = 29;

            for (let i = 0; i < 12; i++) {
                if (days < gDaysInMonth[i]) {
                    gm = i + 1;
                    gd = days + 1;
                    break;
                }
                days -= gDaysInMonth[i];
            }

            return `${gy}-${gm.toString().padStart(2, '0')}-${gd.toString().padStart(2, '0')}`;

        } catch (error) {
            console.error('Error converting Persian to Gregorian:', error);
            return '';
        }
    }


    /**
     * Generate hour options (00-23)
     */
    function generateHourOptions() {
        let options = '';
        for (let i = 0; i < 24; i++) {
            const hour = i.toString().padStart(2, '0');
            options += `<option value="${hour}">${hour}</option>`;
        }
        return options;
    }

    /**
     * Generate minute options (00-59, step 5)
     */
    function generateMinuteOptions() {
        let options = '';
        for (let i = 0; i < 60; i += 5) {
            const minute = i.toString().padStart(2, '0');
            options += `<option value="${minute}">${minute}</option>`;
        }
        return options;
    }

    /**
     * Initialize Airline Search (like Cip.js style)
     */
    function initAirlineSelect2() {
        var $airlineInput = $('#cip-airline-input');
        var $airlineList = $('#cip-airline-list');
        var $airlineHidden = $('#cip-airline-select');

        if (!$airlineInput.length) return;

        // Load airlines on focus
        $airlineInput.on('focus keyup', function() {
            var search_value = $(this).val().trim();
            showAirlineList(search_value);
        });

        // Close list when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.cip-autocomplete-wrapper').length) {
                $airlineList.hide();
            }
        });
    }

    function showAirlineList(search_value) {
        var $listContainer = $('#cip-airline-list');

        $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                method: 'airLineListJson',
                className: 'airline'
            }),
            success: function (response) {
                console.log('Response:', response); // برای دیباگ

                var data = Array.isArray(response)
                   ? response
                   : (response && response.data ? response.data : []);

                // فیلتر جستجو
                if (search_value) {
                    var search = search_value.trim().toLowerCase();
                    data = data.filter(function (item) {
                        if (!item) return false;
                        return (item.name_fa && item.name_fa.toLowerCase().includes(search)) ||
                           (item.name_en && item.name_en.toLowerCase().includes(search)) ||
                           (item.abbreviation && item.abbreviation.toLowerCase().includes(search));
                    });
                }

                // فقط ایرلاین‌های فعال
                data = data.filter(function (item) {
                    if (!item || !item.active) return false;
                    return ['yes', '1', 'true', 'on', 'active']
                       .includes(item.active.toString().toLowerCase());
                });

                // مرتب‌سازی فارسی
                data.sort(function (a, b) {
                    return (a.name_fa || '').localeCompare(b.name_fa || '', 'fa');
                });

                var html = '<ul>';

                data.slice(0, 15).forEach(function (item) {
                    // تبدیل item به string قابل استفاده در onclick
                    var itemJson = JSON.stringify(item)
                       .replace(/'/g, "\\'")
                       .replace(/"/g, '&quot;');

                    html += `
                <li onclick="window.onAirlineSelectCip(${itemJson}, this)">
                    <div class="div_c_sr">
                        <span class="c-text">${escapeHtml(item.name_fa)}</span>
                        ${item.abbreviation ? `<em>(${escapeHtml(item.abbreviation.trim())})</em>` : ''}
                    </div>
                </li>`;
                });

                html += '</ul>';

                $listContainer.html(
                   data.length
                      ? html
                      : '<ul><li>نتیجه‌ای یافت نشد</li></ul>'
                ).show();
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                $listContainer.html('<ul><li>خطا در دریافت اطلاعات</li></ul>').show();
            }
        });
    }

// تابع escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) { return map[m]; });
    }

// فقط یک بار این تابع را تعریف کنید
    window.onAirlineSelectCip = function(item, element) {
        console.log('Selected airline:', item);

        // مثال: پر کردن فیلدها
        if (item && item.name_fa && item.abbreviation) {
            $('#cip-airline-input').val(item.name_fa + ' (' + item.abbreviation + ')');
            $('#cip-airline-input').data('airlineName', item.name_fa);
            $('#cip-airline-select').val(item.abbreviation);
            $('#cip_airline_id').val(item.id); // اگر فیلد ID دارید
        }

        // مخفی کردن لیست
        $('#cip-airline-list').hide();

        // اضافه کردن کلاس انتخاب شده به آیتم
        $(element).addClass('selected').siblings().removeClass('selected');
    };
    /**
     * Initialize Airport Search (like Cip.js style)
     */
    function initAirportSelect2() {
        var $airportInput = $('#cip-airport-input');
        var $airportList = $('#cip-airport-list');

        if (!$airportInput.length) return;

        // Load airports on focus/keyup
        $airportInput.on('focus keyup', function() {
            var search_value = $(this).val().trim();
            showAirportListCip(search_value);
        });

        // Close list when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.cip-autocomplete-wrapper').length) {
                $airportList.hide();
            }
        });
    }

    function showAirportListCip(search_value) {
        var $listContainer = $('#cip-airport-list');

        // Request for internal flights
        var internalRequest = $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                method: 'searchCitiesFlightInternal',
                className: 'newApiFlight',
                value: search_value || '',
                use_customer_db: true,
                is_group: true
            })
        });

        // Request for international flights
        var internationalRequest = $.ajax({
            type: 'POST',
            url: amadeusPath + 'ajax',
            dataType: 'json',
            data: JSON.stringify({
                method: 'cityForSearchInternational',
                className: 'routeFlight',
                iata: search_value || '',
                is_json: true
            })
        });

        // Combine both results
        $.when(internalRequest, internationalRequest).done(function(internalRes, internationalRes) {
            var internalData = internalRes[0].data || [];
            var internationalData = internationalRes[0].data || [];
            var combinedData = internalData.concat(internationalData);

            // Filter items that have airport name
            combinedData = combinedData.filter(function(item) {
                var airport_name = item.AirportFa || item.AirportEn || '';
                return airport_name && airport_name.trim() !== '';
            });

            // Get first 10 items
            combinedData = combinedData.slice(0, 10);

            var html = '';

            combinedData.forEach(function(item) {
                var airport_name = item.AirportFa || item.AirportEn || '';
                var code = item.DepartureCode || item.Departure_Code || '';

                html += "<li onclick='onAirportSelectCip(" + JSON.stringify(item).replace(/'/g, "&apos;") + ", this)'>" +
                        "<div class='div_c_sr'>" +
                        "<i class='svg_icon'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 384 512' width='16' height='16'><path d='M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 160C174.3 160 160 174.3 160 192C160 209.7 174.3 224 192 224C209.7 224 224 209.7 224 192C224 174.3 209.7 160 192 160zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 48C112.5 48 48 112.5 48 192C48 204.4 52.49 223.6 63.3 249.2C73.78 274 88.66 301.4 105.8 329.1C134.2 375.3 167.2 419.1 192 451.7C216.8 419.1 249.8 375.3 278.2 329.1C295.3 301.4 310.2 274 320.7 249.2C331.5 223.6 336 204.4 336 192C336 112.5 271.5 48 192 48V48z'/></svg></i>" +
                        "<span class='c-text'>" + airport_name + "</span>" +
                        "<em>(" + code + ")</em>" +
                        "</div></li>";

                // Show sub airports if exists
                if (item.sub && item.sub.length > 0) {
                    item.sub.slice(0, 2).forEach(function(subItem) {
                        var sub_airport = subItem.AirportFa || subItem.AirportEn || '';
                        if (!sub_airport) return;

                        html += "<li onclick='onAirportSelectCip(" + JSON.stringify(subItem).replace(/'/g, "&apos;") + ", this)'>" +
                                "<div class='div_c_sr sub-airport'>" +
                                "<i class='svg_icon'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 384 512' width='16' height='16'><path d='M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192z'/></svg></i>" +
                                "<span class='c-text'>" + sub_airport + "</span>" +
                                "<em>(" + (subItem.DepartureCode || subItem.Departure_Code || '') + ")</em>" +
                                "</div></li>";
                    });
                }
            });

            if (!html) {
                $listContainer.html('<ul><li>نتیجه‌ای یافت نشد</li></ul>').show();
            } else {
                $listContainer.html('<ul>' + html + '</ul>').show();
            }
        });
    }

    // Global function for airport selection
    window.onAirportSelectCip = function(item, element) {
        var airport_name = item.AirportFa || item.AirportEn || '';
        var code = item.DepartureCode || item.Departure_Code || '';

        $('#cip-airport-input').val(airport_name + ' (' + code + ')');
        $('#cip-airport-select').val(code);
        $('#cip-airport-list').hide();
    };


    /**
     * Get flight info data
     */
    function getFlightInfoData() {
        const hour = document.getElementById('cip-flight-hour')?.value || '00';
        const minute = document.getElementById('cip-flight-minute')?.value || '00';
        const flightDate = document.getElementById('cip-flight-date')?.value || '';
        const gregorianDate = persianToGregorian(flightDate);
        const cipData = JSON.parse(localStorage.getItem('selectedCip') || '{}');

        return {
            AirlineIata: $('#cip-airline-select').val() || '',
            FlightNumber: document.getElementById('cip-flight-number')?.value || '',
            AirportCodeCip: cipData.CipInfo?.AirportCode || '',
            FlightType: cipData.CipInfo?.FlightType || '',
            TripType: cipData.CipInfo?.TripType || '',
            AirportCode: $('#cip-airport-select').val() || '',
            DateTime: gregorianDate ? `${gregorianDate} ${hour}:${minute}` : ''
        };
    }

    /**
     * Validate flight info
     */
    function validateFlightInfo() {
        let isValid = true;
        const flightInfo = getFlightInfoData();

        // Validate airline
        if (!flightInfo.AirlineIata) {
            $('#cip-airline-select').closest('.cip-form-group').addClass('cip-has-error');
            isValid = false;
        } else {
            $('#cip-airline-select').closest('.cip-form-group').removeClass('cip-has-error');
        }

        // Validate flight number
        const flightNumberInput = document.getElementById('cip-flight-number');
        if (!flightInfo.FlightNumber) {
            flightNumberInput?.closest('.cip-form-group')?.classList.add('cip-has-error');
            isValid = false;
        } else {
            flightNumberInput?.closest('.cip-form-group')?.classList.remove('cip-has-error');
        }

        // Validate airport
        if (!flightInfo.AirportCode) {
            $('#cip-airport-select').closest('.cip-form-group').addClass('cip-has-error');
            isValid = false;
        } else {
            $('#cip-airport-select').closest('.cip-form-group').removeClass('cip-has-error');
        }

        // Validate time
        const hour = document.getElementById('cip-flight-hour')?.value;
        const minute = document.getElementById('cip-flight-minute')?.value;
        const timeWrapper = document.querySelector('.cip-time-wrapper')?.closest('.cip-form-group');
        if (!hour || !minute) {
            timeWrapper?.classList.add('cip-has-error');
            isValid = false;
        } else {
            timeWrapper?.classList.remove('cip-has-error');
        }

        return isValid;
    }

    /**
     * Initialize CIP Passenger Forms
     */
    function initCipPassengerForms() {
        const container = document.querySelector('.parent-hotel-details--new');
        if (!container) {
            console.warn('Container .parent-hotel-details--new not found');
            return;
        }

        const cipData = getSelectedCip();
        if (!cipData) {
            container.innerHTML = `
                <div class="cip-error-box">
                    <i class="fa-solid fa-exclamation-triangle"></i>
                    <p>اطلاعات CIP یافت نشد. لطفا دوباره از صفحه جستجو اقدام کنید.</p>
                    <a href="javascript:history.back()" class="cip-btn-back">بازگشت</a>
                </div>
            `;
            return;
        }

        const quantity = getPassengerQuantity(cipData);
        const totalPassengers = quantity.adult + quantity.child + quantity.infant;

        // Create passengers wrapper
        const passengersWrapper = document.createElement('div');
        passengersWrapper.className = 'cip-passengers-wrapper';
        passengersWrapper.innerHTML = `
            <div class="cip-passengers-header">
                <h2 class="cip-section-title">
                    <i class="fa-solid fa-users"></i>
                    اطلاعات مسافران
                </h2>
                <div class="cip-passengers-summary">
                    <span class="cip-summary-item">
                        <i class="fa-solid fa-user"></i>
                        ${quantity.adult} بزرگسال
                    </span>
                    ${quantity.child > 0 ? `
                    <span class="cip-summary-item">
                        <i class="fa-solid fa-child"></i>
                        ${quantity.child} کودک
                    </span>
                    ` : ''}
                    ${quantity.infant > 0 ? `
                    <span class="cip-summary-item">
                        <i class="fa-solid fa-baby"></i>
                        ${quantity.infant} نوزاد
                    </span>
                    ` : ''}
                </div>
            </div>
            <div class="cip-passengers-forms"></div>
        `;

        // 1. Create contact box (مشخصات تماس خریدار)
        const contactHtml = generateContactBox();
        container.insertAdjacentHTML('beforeend', contactHtml);

        // 2. Create flight info box (اطلاعات سفر)
        const flightInfoHtml = generateFlightInfoBox(cipData);
        container.insertAdjacentHTML('beforeend', flightInfoHtml);

        // 3. Create passengers wrapper (اطلاعات مسافرین)
        container.appendChild(passengersWrapper);

        // Generate passenger forms
        const formsContainer = passengersWrapper.querySelector('.cip-passengers-forms');
        generateAllPassengerForms(formsContainer, quantity);

        const serviceHtml = generateServiceBox(cipData);
        container.insertAdjacentHTML('beforeend', serviceHtml);

        // Create footer with submit button
        const footerHtml = `
<!--            <div class="cip-passengers-footer">-->
<!--                <button type="button" class="cip-btn-submit" id="cipSubmitBtn">-->
<!--                    <span>ادامه و تایید</span>-->
<!--                    <i class="fa-solid fa-arrow-left"></i>-->
<!--                </button>-->
<!--            </div>-->
        `;
        container.insertAdjacentHTML('beforeend', footerHtml);

        // Initialize date pickers
        initializeDatePickers();

        // Initialize Select2 for airline and airport
        initAirlineSelect2();
        initAirportSelect2();

        // Add event listeners for nationality
        document.querySelectorAll('.cip-nationality-select').forEach(select => {
            select.addEventListener('change', handleNationalityChange);
            // Trigger initial state
            handleNationalityChange({ target: select });
        });

        // اعتبارسنجی کد ملی تکراری
        document.querySelectorAll('input[name*="[nationalCode]"]').forEach(input => {
            input.addEventListener('blur', function() {
                const currentValue = this.value.trim();
                if (!currentValue) return;

                // چک کردن تکراری بودن
                const allNationalCodes = document.querySelectorAll('input[name*="[nationalCode]"]');
                let duplicateCount = 0;

                allNationalCodes.forEach(otherInput => {
                    if (otherInput.value.trim() === currentValue) {
                        duplicateCount++;
                    }
                });

                if (duplicateCount > 1) {
                    this.setCustomValidity('این کد ملی قبلاً وارد شده است');
                    this.reportValidity();
                    this.value = '';
                } else {
                    this.setCustomValidity('');
                }
            });
        });

        // اعتبارسنجی شماره گذرنامه تکراری
        document.querySelectorAll('input[name*="[passportNumber]"]').forEach(input => {
            input.addEventListener('blur', function() {
                const currentValue = this.value.trim();
                if (!currentValue) return;

                // چک کردن تکراری بودن
                const allPassports = document.querySelectorAll('input[name*="[passportNumber]"]');
                let duplicateCount = 0;

                allPassports.forEach(otherInput => {
                    if (otherInput.value.trim() === currentValue) {
                        duplicateCount++;
                    }
                });

                if (duplicateCount > 1) {
                    this.setCustomValidity('این شماره گذرنامه قبلاً وارد شده است');
                    this.reportValidity();
                    this.value = '';
                } else {
                    this.setCustomValidity('');
                }
            });
        });

        // Validate on blur
        document.querySelectorAll('.cip-passenger-box input, .cip-passenger-box select').forEach(input => {
            input.addEventListener('blur', () => validateField(input));
        });

        // Submit handler
        let isSubmitting = false;
        const submitBtn = document.getElementById('cipSubmitBtn') || document.getElementById('cip-continue-btn');
        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // جلوگیری از ارسال مجدد
                if (isSubmitting) return;

                const passengersValid = validateAllForms();
                const flightInfoValid = validateFlightInfo();

                if (passengersValid && flightInfoValid) {
                    const passengerData = getAllPassengerData();
                    const flightInfoData = getFlightInfoData();
                    const serviceData = getAllServiceData();
                    const sessionID = cipData.CipId || '';

                    // ساخت آرایه Books - همه سرویس‌ها درون یک آرایه Services
                    const books = passengerData.map(function(p) {
                        let passengerTitle = '';
                        // تعیین عنوان مسافر براساس نوع مسافر و جنسیت
                        if (p.passengerType === 'ADT') {
                            // بزرگسال
                            if (p.gender === 'MR' || p.gender === 'Male') {
                                passengerTitle = 'MR';
                            } else if (p.gender === 'MS' || p.gender === 'Female') {
                                passengerTitle = 'MS';
                            }
                        } else if (p.passengerType === 'CHD' || p.passengerType === 'INF') {
                            // کودک یا نوزاد
                            if (p.gender === 'MSTR' || p.gender === 'Male') {
                                passengerTitle = 'MSTR';
                            } else if (p.gender === 'MISS' || p.gender === 'Female') {
                                passengerTitle = 'MISS';
                            }
                        } else {
                            // استفاده مستقیم از مقدار gender (برای حالتی که مقادیر جدید را داریم)
                            passengerTitle = p.gender;
                        }

                        let passengerType = 'Adt';
                        if (p.passengerType === 'CHD') {
                            passengerType = 'Chd';
                        } else if (p.passengerType === 'INF') {
                            passengerType = 'Inf';
                        }

                        const dateOfBirth = p.birthDate ? p.birthDate.replace(/\//g, '-') : '';
                        console.log('flightInfoData: ' , flightInfoData)
                        return {
                            FirstName: p.firstName,
                            LastName: p.lastName,
                            PassportNumber: p.passportNumber || '',
                            DateOfBirth: dateOfBirth,
                            PassengerTitle: passengerTitle,
                            PassportExpireDate: p.passportExpireDate || '',
                            Nationality: p.nationality,
                            NationalCode: p.nationalCode || '',
                            PassengerType: passengerType,
                            Services: serviceData.length > 0 ? serviceData : null,
                            AirlineIata: flightInfoData.AirlineIata,
                            FlightNumber: flightInfoData.FlightNumber,
                            AirportCode: flightInfoData.AirportCode,
                            DateTime: flightInfoData.DateTime
                        };
                    });

                    const contactMobile = document.getElementById('cip-contact-mobile')?.value || '';
                    const contactEmail = document.getElementById('cip-contact-email')?.value || '';
                    const cipDataForRequest = JSON.parse(localStorage.getItem('selectedCip') || '{}');
                    const requestNumber = cipDataForRequest.Code || '';
                    const cipName = cipDataForRequest.CipInfo?.Title?.fa || '';
                    const airlineName = $('#cip-airline-input').data('airlineName') || '';

                    // محاسبه قیمت کل مسافران
                    let totalPrice = 0;
                    if (cipDataForRequest.PassengerDatas && Array.isArray(cipDataForRequest.PassengerDatas)) {
                        cipDataForRequest.PassengerDatas.forEach(pd => {
                            const qty = parseInt(pd.PassengerQuantity) || 0;
                            const pricePerPerson = parseFloat(pd.TotalPrice) || 0;
                            totalPrice += pricePerPerson * qty;
                        });
                    }

                    // محاسبه قیمت سرویس‌های جانبی
                    const serviceRows = document.querySelectorAll('.cip-service-row');
                    const processedIds = new Set();
                    serviceRows.forEach(row => {
                        const serviceId = row.getAttribute('data-service-id');
                        if (processedIds.has(serviceId)) return;
                        processedIds.add(serviceId);
                        const unitPrice = parseFloat(row.getAttribute('data-unit-price')) || 0;
                        const desktopInput = document.getElementById(`cip-service-${serviceId}`);
                        const mobileInput = document.getElementById(`cip-service-${serviceId}-mobile`);
                        const quantityInput = desktopInput || mobileInput;
                        if (!quantityInput) return;
                        const quantity = parseInt(quantityInput.value) || 0;
                        totalPrice += unitPrice * quantity;
                    });

                    const postData = {
                        method: 'PreReserve',
                        className: 'cip',
                        Books: books,
                        SessionID: sessionID,
                        Mobile: contactMobile,
                        Email: contactEmail,
                        RequestNumber: requestNumber,
                        CipName: cipName,
                        TotalPrice: totalPrice,
                        AirlineName: airlineName,
                        AirportCodeCip: flightInfoData.AirportCodeCip,
                        TripType: flightInfoData.TripType,
                        FlightType: flightInfoData.FlightType,
                    };

                    console.log('Submitting data:', postData);

                    // غیرفعال کردن دکمه و قفل ارسال
                    isSubmitting = true;
                    submitBtn.disabled = true;
                    submitBtn.querySelector('span').textContent = 'در حال ارسال...';

                    $.ajax({
                        type: 'POST',
                        url: amadeusPath + 'ajax',
                        dataType: 'json',
                        data: JSON.stringify(postData),
                        success: function(response) {
                            console.log('PreReserve response:', response);
                            if (response && response.Result && response.Result.ProviderStatus === 'Success') {
                                // ذخیره اطلاعات رزرو برای مرحله بعد
                                localStorage.setItem('cipPreReserveResult', JSON.stringify(response));
                                // رفتن به صفحه پیش فاکتور
                                showPreInvoice(response, passengerData);
                                goToNextStep();
                            } else {
                                var errorMsg = 'خطا در ثبت رزرو. لطفا با پشتیبانی تماس حاصل فرمایید .';
                                if (response && response.Result && response.Result.ProviderStatus) {
                                    errorMsg = 'وضعیت: ' + response.Result.ProviderStatus;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطا در ثبت رزرو',
                                    text: errorMsg,
                                    confirmButtonText: 'متوجه شدم',
                                    confirmButtonColor: '#d33',
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('PreReserve error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'خطا در ارتباط با سرور',
                                text: 'لطفا دوباره تلاش کنید.',
                                confirmButtonText: 'متوجه شدم',
                                confirmButtonColor: '#d33',
                            });
                        },
                        complete: function() {
                            isSubmitting = false;
                            submitBtn.disabled = false;
                            submitBtn.querySelector('span').textContent = 'ادامه خرید';
                        }
                    });
                } else {
                    // Scroll to first error
                    const firstError = document.querySelector('.cip-has-error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }
    }



    /**
     * Generate Buyer Contact Info Box
     */
    function generateContactBox() {
        return `
        <div class="cip-contact-wrapper">
            <div class="cip-contact-header">
                <h2 class="cip-section-title">
                    <i class="fa-solid fa-address-book"></i>
                    مشخصات تماس خریدار
                </h2>
            </div>
            <div class="cip-contact-body">
                <div class="cip-form-row">
                    <div class="cip-form-group">
                        <label class="cip-label">
                            شماره موبایل
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="tel"
                                   name="contact[mobile]"
                                   id="cip-contact-mobile"
                                   class="cip-input"
                                   placeholder="09123456789"
                                   maxlength="11"
                                   value="${typeof cipUserMobile !== 'undefined' ? cipUserMobile : ''}"
                                   ${typeof cipUserMobile !== 'undefined' && cipUserMobile ? 'disabled' : ''}
                                   required>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <label class="cip-label">
                            ایمیل
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="email"
                                   name="contact[email]"
                                   id="cip-contact-email"
                                   class="cip-input"
                                   placeholder="example@email.com"
                                   value="${typeof cipUserEmail !== 'undefined' ? cipUserEmail : ''}"
                                   ${typeof cipUserEmail !== 'undefined' && cipUserEmail ? 'disabled' : ''}
                                   required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
    }

    function generateFlightInfoBox(cipData) {
        // Get date from cipData
        const flightDate = toPersianDateSimple(cipData.CipInfo.Date) || '';

        return `
        <div class="cip-flight-info-wrapper">
            <div class="cip-flight-info-header">
                <h2 class="cip-section-title">
                    <i class="fa-solid fa-plane"></i>
                     اطلاعات سفر (برای ارائه خدمات صحیح لطفا اطلاعات پرواز خود را وارد نمایید)
                </h2>
            </div>
            <div class="cip-flight-info-body">
                <div class="cip-form-row">
                    <div class="cip-form-group">
                        <label class="cip-label">
                            شرکت هواپیمایی
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper cip-autocomplete-wrapper">
                            <input type="text"
                                   id="cip-airline-input"
                                   class="cip-input"
                                   placeholder="شرکت هواپیمایی که سوار می شوید ..."
                                   autocomplete="off">
                            <input type="hidden" name="flightInfo[airline]" id="cip-airline-select">
                            <div id="cip-airline-list" class="cip-autocomplete-list"></div>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <label class="cip-label">
                            شماره پرواز
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   name="flightInfo[flightNumber]"
                                   id="cip-flight-number"
                                   class="cip-input"
                                   placeholder="مثال: 1080"
                                   pattern="[0-9]+"
                                   title="فقط عدد وارد کنید"
                                   required>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <label class="cip-label">
                            فرودگاه
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper cip-autocomplete-wrapper">
                            <input type="text"
                                   id="cip-airport-input"
                                   class="cip-input"
                                   placeholder="فرودگاهی که سوار می شوید ..."
                                   autocomplete="off">
                            <input type="hidden" name="flightInfo[airport]" id="cip-airport-select">
                            <div id="cip-airport-list" class="cip-autocomplete-list"></div>
                        </div>
                    </div>
                </div>

                <div class="cip-form-row">
                    <div class="cip-form-group">
                        <label class="cip-label">
                            تاریخ پرواز
                        </label>
                        <div class="cip-input-wrapper">
                            <input type="text"
                                   name="flightInfo[flightDate]"
                                   id="cip-flight-date"
                                   class="cip-input cip-input-disabled"
                                   value="${flightDate}"
                                   disabled
                                   readonly>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <label class="cip-label">
                            ساعت پرواز
                            <span class="cip-required">*</span>
                        </label>
                        <div class="cip-input-wrapper cip-time-wrapper">
                            <select name="flightInfo[flightMinute]"
                                    id="cip-flight-minute"
                                    class="cip-select cip-time-select"
                                    required>
                                <option value="">دقیقه</option>
                                ${generateMinuteOptions()}
                            </select>
                            <span class="cip-time-separator">:</span>
                            <select name="flightInfo[flightHour]"
                                    id="cip-flight-hour"
                                    class="cip-select cip-time-select"
                                    required>
                                <option value="">ساعت</option>
                                ${generateHourOptions()}
                            </select>
                        </div>
                    </div>

                    <div class="cip-form-group">
                        <!-- Empty for alignment -->
                    </div>
                </div>
            </div>
        </div>
        `;
    }




// تابع formatPrice
    function formatPrice(price) {
        if (typeof price !== 'number') {
            price = parseFloat(price) || 0;
        }
        return new Intl.NumberFormat('fa-IR').format(price);
    }

// تابع toggle برای فعال/غیرفعال کردن سرویس
    function toggleService(serviceId, checkbox) {
        const isChecked = checkbox.checked;
        const serviceRow = document.querySelector(`[data-service-id="${serviceId}"]`);

        // پیدا کردن اینپوت‌های مربوطه
        const desktopInput = document.getElementById(serviceId);
        const mobileInput = document.getElementById(serviceId + '-mobile');
        const quantityControl = serviceRow.querySelector('.cip-quantity-control');

        if (isChecked) {
            // فعال کردن
            if (desktopInput) desktopInput.value = 1;
            if (mobileInput) mobileInput.value = 1;
            if (quantityControl) {
                quantityControl.style.opacity = '1';
                quantityControl.style.pointerEvents = 'auto';
            }

            // فعال کردن اینپوت عددی
            if (desktopInput) desktopInput.readOnly = false;
            if (mobileInput) mobileInput.readOnly = false;

            // نمایش اینپوت‌های اضافی
            showExtraInputs(serviceId, 1);

            // به‌روزرسانی قیمت
            updateServiceTotal(serviceId);
        } else {
            // غیرفعال کردن
            if (desktopInput) desktopInput.value = 0;
            if (mobileInput) mobileInput.value = 0;
            if (quantityControl) {
                quantityControl.style.opacity = '0.5';
                quantityControl.style.pointerEvents = 'none';
            }

            // غیرفعال کردن اینپوت عددی
            if (desktopInput) desktopInput.readOnly = true;
            if (mobileInput) mobileInput.readOnly = true;

            // مخفی کردن اینپوت‌های اضافی
            hideExtraInputs(serviceId);

            // به‌روزرسانی قیمت
            updateServiceTotal(serviceId);
        }
    }

// تابع افزایش تعداد
    function increaseQuantity(serviceId, hasCheckbox = false) {
        const desktopInput = document.getElementById(serviceId);
        const mobileInput = document.getElementById(serviceId + '-mobile');
        const input = desktopInput || mobileInput;

        if (!input) return;

        const currentValue = parseInt(input.value) || 0;
        const maxValue = parseInt(input.max) || 10;

        if (currentValue < maxValue) {
            const newValue = currentValue + 1;

            // به‌روزرسانی اینپوت‌ها
            if (desktopInput) desktopInput.value = newValue;
            if (mobileInput) mobileInput.value = newValue;

            // نمایش اینپوت‌های اضافی
            showExtraInputs(serviceId, newValue);

            // به‌روزرسانی قیمت
            updateServiceTotal(serviceId);

            // فعال/غیرفعال کردن دکمه‌ها
            updateQuantityButtons(serviceId, newValue);
        }
    }

// تابع کاهش تعداد
    function decreaseQuantity(serviceId, hasCheckbox = false) {
        const desktopInput = document.getElementById(serviceId);
        const mobileInput = document.getElementById(serviceId + '-mobile');
        const input = desktopInput || mobileInput;

        if (!input) return;

        const currentValue = parseInt(input.value) || 0;
        const minValue = parseInt(input.min) || 0;

        if (currentValue > minValue) {
            const newValue = currentValue - 1;

            // به‌روزرسانی اینپوت‌ها
            if (desktopInput) desktopInput.value = newValue;
            if (mobileInput) mobileInput.value = newValue;

            // نمایش اینپوت‌های اضافی
            showExtraInputs(serviceId, newValue);

            // به‌روزرسانی قیمت
            updateServiceTotal(serviceId);

            // فعال/غیرفعال کردن دکمه‌ها
            updateQuantityButtons(serviceId, newValue);
        }
    }

// تابع نمایش اینپوت‌های اضافی
    function showExtraInputs(serviceId, quantity) {
        const desktopExtraInputs = document.getElementById(`extra-inputs-${serviceId}`);
        const mobileExtraInputs = document.getElementById(`extra-inputs-mobile-${serviceId}`);

        if (quantity > 0) {
            if (desktopExtraInputs) {
                generateExtraInputs(desktopExtraInputs, serviceId, quantity, 'desktop');
                desktopExtraInputs.style.display = 'block';
            }
            if (mobileExtraInputs) {
                generateExtraInputs(mobileExtraInputs, serviceId, quantity, 'mobile');
                mobileExtraInputs.style.display = 'block';
            }
        } else {
            if (desktopExtraInputs) {
                desktopExtraInputs.innerHTML = '';
                desktopExtraInputs.style.display = 'none';
            }
            if (mobileExtraInputs) {
                mobileExtraInputs.innerHTML = '';
                mobileExtraInputs.style.display = 'none';
            }
        }
    }

// تابع مخفی کردن اینپوت‌های اضافی
    function hideExtraInputs(serviceId) {
        const desktopExtraInputs = document.getElementById(`extra-inputs-${serviceId}`);
        const mobileExtraInputs = document.getElementById(`extra-inputs-mobile-${serviceId}`);

        if (desktopExtraInputs) {
            desktopExtraInputs.innerHTML = '';
            desktopExtraInputs.style.display = 'none';
        }
        if (mobileExtraInputs) {
            mobileExtraInputs.innerHTML = '';
            mobileExtraInputs.style.display = 'none';
        }
    }

// تابع تولید اینپوت‌های اضافی
    function generateExtraInputs(container, serviceId, quantity, type = 'desktop') {
        // پاک کردن اینپوت‌های موجود
        container.innerHTML = '';

        // دریافت تنظیمات اینپوت از data attribute
        const serviceRow = document.querySelector(`[data-service-id="${serviceId.replace('cip-service-', '')}"]`);
        let inputConfig = null;

        if (serviceRow) {
            const configAttr = serviceRow.getAttribute('data-input-config');
            if (configAttr) {
                try {
                    inputConfig = JSON.parse(configAttr);
                } catch (e) {
                    console.error('Error parsing input config:', e);
                }
            }
        }

        // دریافت نوع سرویس از data attribute
        let cipService = '';
        if (serviceRow) {
            cipService = serviceRow.getAttribute('data-cip-service') || '';
        }

        // ایجاد اینپوت‌های جدید
        for (let i = 0; i < quantity; i++) {
            let inputHTML = '';
            inputHTML += inputService(cipService, serviceId, i);

            container.insertAdjacentHTML('beforeend', inputHTML);
        }

        // فراخوانی datepicker برای فیلدهای تاریخ (اگر وجود داشته باشد)
        initDatepickers(container);
    }

// تابع مقداردهی اولیه datepicker شمسی برای اینپوت‌های داینامیک سرویس‌ها
    function initDatepickers(container) {
        if (typeof $.fn.datepicker === 'undefined') return;

        setTimeout(function() {
            $(container).find('.cip-birthdate-picker').each(function() {
                var $el = $(this);
                if ($el.hasClass('hasDatepicker')) {
                    $el.datepicker('destroy');
                }
                $el.datepicker({
                    numberOfMonths: 1,
                    maxDate: 'Y/M/D',
                    showButtonPanel: true,
                    changeMonth: true,
                    changeYear: true,
                    beforeShow: function(n) {
                        if (typeof e === 'function') e(n, true);
                        $("#ui-datepicker-div").addClass("INH_class_Datepicker");
                    }
                });
                if ($.datepicker.regional && $.datepicker.regional.fa) {
                    $el.datepicker('option', $.datepicker.regional.fa);
                }
                $el.datepicker('option', 'yearRange', '1300:1410');
                $el.datepicker('option', 'changeMonth', true);
                $el.datepicker('option', 'changeYear', true);
            });
        }, 50);
    }

// تابع به‌روزرسانی دکمه‌های + و -
    function updateQuantityButtons(serviceId, currentValue) {
        const desktopInput = document.getElementById(serviceId);
        const mobileInput = document.getElementById(serviceId + '-mobile');

        if (!desktopInput && !mobileInput) return;

        const maxValue = parseInt(desktopInput?.max || mobileInput?.max || 10);
        const minValue = parseInt(desktopInput?.min || mobileInput?.min || 0);

        // پیدا کردن دکمه‌ها
        const minusBtns = document.querySelectorAll(`[onclick*="decreaseQuantity('${serviceId}'"]`);
        const plusBtns = document.querySelectorAll(`[onclick*="increaseQuantity('${serviceId}'"]`);

        // به‌روزرسانی وضعیت دکمه‌ها
        minusBtns.forEach(btn => {
            btn.disabled = currentValue <= minValue;
        });

        plusBtns.forEach(btn => {
            btn.disabled = currentValue >= maxValue;
        });
    }

// تابع به‌روزرسانی قیمت کل (اصلاح شده - قیمت ثابت بدون محاسبه)
    function updateServiceTotal(serviceId) {
        const desktopInput = document.getElementById(serviceId);
        const mobileInput = document.getElementById(serviceId + '-mobile');
        const input = desktopInput || mobileInput;

        if (!input) return;

        const quantity = parseInt(input.value) || 0;
        const unitPrice = parseFloat(input.getAttribute('data-price')) || 0;

        const totalInput = document.getElementById(`${serviceId}-total-input`);

        if (totalInput) {
            totalInput.value = quantity > 0 ? unitPrice * quantity : 0;
            totalInput.setAttribute('data-quantity', quantity);
            totalInput.setAttribute('data-unit-price', unitPrice);
        }

        updateGrandTotal();
    }

// تابع محاسبه جمع کل همه سرویس‌ها
    function updateGrandTotal() {
        const totalInputs = document.querySelectorAll('input[id$="-total-input"]');
        let grandTotal = 0;

        totalInputs.forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });

        // به‌روزرسانی نمایش جمع کل
        const grandTotalElement = document.getElementById('cip-services-grand-total');
        const grandTotalInput = document.getElementById('cip-services-total-input');

        if (grandTotalElement) {
            grandTotalElement.textContent = formatPrice(grandTotal);
        }
        if (grandTotalInput) {
            grandTotalInput.value = grandTotal;
        }

        // به‌روزرسانی باکس خلاصه سرویس‌ها
        updateSelectedServicesSummary();
    }

// تابع به‌روزرسانی باکس خلاصه سرویس‌های انتخاب شده
    function updateSelectedServicesSummary() {
        const summaryContainer = document.getElementById('cip-selected-services-list');
        const ancillaryTotalElement = document.getElementById('cip-ancillary-total');
        const grandTotalSummaryElement = document.getElementById('cip-grand-total-summary');
        const emptyMessage = document.getElementById('cip-summary-empty-message');
        const summaryContent = document.getElementById('cip-summary-content');

        if (!summaryContainer) return;

        // دریافت قیمت سرویس اصلی از localStorage و به‌روزرسانی نمایش جزئیات
        let totalPassengerPrice = 0;
        try {
            const cipData = JSON.parse(localStorage.getItem('selectedCip') || '{}');
            // محاسبه قیمت و جزئیات مسافران
            if (cipData.PassengerDatas && Array.isArray(cipData.PassengerDatas)) {
                let passengerDetailsHTML = '';

                // جمع‌آوری قیمت‌ها براساس نوع مسافر
                const passengerGroups = {
                    ADT: { label: 'بزرگسال', totalPrice: 0, totalQty: 0 },
                    CHD: { label: 'کودک', totalPrice: 0, totalQty: 0 },
                    INF: { label: 'نوزاد', totalPrice: 0, totalQty: 0 }
                };

                cipData.PassengerDatas.forEach(pd => {
                    const qty = parseInt(pd.PassengerQuantity) || 0;
                    const pricePerPerson = parseFloat(pd.TotalPrice) || 0;
                    const type = pd.PassengerType ? pd.PassengerType.toUpperCase() : '';

                    // قیمت کل = قیمت هر نفر × تعداد
                    const totalPriceForType = pricePerPerson * qty;

                    totalPassengerPrice += totalPriceForType;

                    // جمع کردن قیمت‌ها براساس نوع
                    if (passengerGroups[type]) {
                        passengerGroups[type].totalPrice += totalPriceForType;
                        passengerGroups[type].totalQty += qty;
                    }
                });

                // ایجاد HTML جزئیات هر نوع مسافر
                Object.keys(passengerGroups).forEach(type => {
                    const group = passengerGroups[type];
                    if (group.totalQty > 0 && group.totalPrice > 0) {
                        passengerDetailsHTML += `
                            <div class="cip-passenger-detail-row" style="padding: 8px 0; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #555;">
                                <span>${group.label} (${group.totalQty} نفر)</span>
                                <span style="direction: ltr;">${formatPrice(group.totalPrice)} ریال</span>
                            </div>
                        `;
                    }
                });

                // به‌روزرسانی نمایش جمع سرویس اصلی
                const mainServiceElement = document.getElementById('cip-main-service-price');
                if (mainServiceElement) {
                    mainServiceElement.textContent = formatPrice(totalPassengerPrice);
                }

                // به‌روزرسانی جزئیات مسافران
                let passengerDetailsContainer = document.getElementById('cip-passenger-details');
                if (passengerDetailsContainer && passengerDetailsHTML) {
                    // فقط محتوای داخلی را به‌روزرسانی می‌کنیم
                    const detailsContent = `
                        <div style="font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #333;">جزئیات مسافران:</div>
                        ${passengerDetailsHTML}
                    `;
                    passengerDetailsContainer.innerHTML = detailsContent;
                }
            }
        } catch (e) {
            console.error('Error reading main service price:', e);
        }

        // جمع‌آوری سرویس‌های انتخاب شده - یکتاسازی بر اساس CipId
        const serviceRows = document.querySelectorAll('.cip-service-row');
        const processedIds = new Set();
        const selectedServices = [];
        let ancillaryTotal = 0;

        serviceRows.forEach(row => {
            const serviceId = row.getAttribute('data-service-id');

            // اگر قبلاً این سرویس پردازش شده، از آن رد شو
            if (processedIds.has(serviceId)) return;
            processedIds.add(serviceId);

            const unitPrice = parseFloat(row.getAttribute('data-unit-price')) || 0;

            // پیدا کردن input تعداد - اول دسکتاپ بعد موبایل
            const desktopInput = document.getElementById(`cip-service-${serviceId}`);
            const mobileInput = document.getElementById(`cip-service-${serviceId}-mobile`);
            const quantityInput = desktopInput || mobileInput;

            if (!quantityInput) return;

            const quantity = parseInt(quantityInput.value) || 0;

            if (quantity > 0) {
                ancillaryTotal += unitPrice * quantity;

                const titleElement = row.querySelector('strong');
                const title = titleElement ? titleElement.textContent : 'سرویس';

                selectedServices.push({
                    id: serviceId,
                    title: title,
                    quantity: quantity,
                    unitPrice: unitPrice
                });
            }
        });

        // به‌روزرسانی نمایش
        if (selectedServices.length === 0) {
            if (emptyMessage) emptyMessage.style.display = 'block';
            if (summaryContent) summaryContent.style.display = 'none';
        } else {
            if (emptyMessage) emptyMessage.style.display = 'none';
            if (summaryContent) summaryContent.style.display = 'block';

            // ایجاد HTML لیست سرویس‌ها - قیمت ثابت
            let listHTML = '';
            selectedServices.forEach(service => {
                listHTML += `
                    <div class="cip-summary-item" data-service-id="${service.id}">
                        <span class="cip-summary-item-title">${service.title}</span>
                        <div class="cip-summary-item-details">
                            <span class="cip-summary-item-qty">${service.quantity} عدد</span>
                            <span class="cip-summary-item-price">${formatPrice(service.unitPrice * service.quantity)} ریال</span>
                        </div>
                    </div>
                `;
            });
            summaryContainer.innerHTML = listHTML;
        }

        // به‌روزرسانی جمع سرویس‌های جانبی
        if (ancillaryTotalElement) {
            ancillaryTotalElement.textContent = formatPrice(ancillaryTotal);
        }

        // به‌روزرسانی جمع کل نهایی
        const grandTotal = totalPassengerPrice + ancillaryTotal;
        if (grandTotalSummaryElement) {
            grandTotalSummaryElement.textContent = formatPrice(grandTotal);
        }

        // به‌روزرسانی input مخفی جمع کل
        const grandTotalInput = document.getElementById('cip-final-total-input');
        if (grandTotalInput) {
            grandTotalInput.value = grandTotal;
        }

        // نکته: قیمت سرویس اصلی قبلاً در بالا به‌روزرسانی شده است
    }

// تابع تولید HTML باکس خلاصه
    function generateSelectedServicesSummary(cipData) {
        // دریافت قیمت واحد و محاسبه جزئیات هر نوع مسافر
        let unitPrice = 0;
        let totalPassengerPrice = 0;
        let passengerDetailsHTML = '';

        if (cipData && cipData.PassengerDatas && Array.isArray(cipData.PassengerDatas)) {
            // قیمت واحد از بزرگسال (ADT)
            const adultPassenger = cipData.PassengerDatas.find(pd =>
                pd.PassengerType && pd.PassengerType.toUpperCase() === 'ADT'
            );

            if (adultPassenger) {
                // قیمت کل بزرگسال (بدون تقسیم)
                unitPrice = parseFloat(adultPassenger.TotalPrice) || 0;
            } else if (cipData.PassengerDatas.length > 0) {
                // اگر بزرگسال نبود، از اولین مسافر استفاده کن
                unitPrice = parseFloat(cipData.PassengerDatas[0].TotalPrice) || 0;
            }

            // جمع‌آوری قیمت‌ها براساس نوع مسافر
            const passengerGroups = {
                ADT: { label: 'بزرگسال', totalPrice: 0, totalQty: 0 },
                CHD: { label: 'کودک', totalPrice: 0, totalQty: 0 },
                INF: { label: 'نوزاد', totalPrice: 0, totalQty: 0 }
            };

            cipData.PassengerDatas.forEach(pd => {
                const qty = parseInt(pd.PassengerQuantity) || 0;
                const pricePerPerson = parseFloat(pd.TotalPrice) || 0;
                const type = pd.PassengerType ? pd.PassengerType.toUpperCase() : '';

                // قیمت کل = قیمت هر نفر × تعداد
                const totalPriceForType = pricePerPerson * qty;

                totalPassengerPrice += totalPriceForType;

                // جمع کردن قیمت‌ها براساس نوع
                if (passengerGroups[type]) {
                    passengerGroups[type].totalPrice += totalPriceForType;
                    passengerGroups[type].totalQty += qty;
                }
            });

            // نمایش جزئیات هر نوع مسافر
            Object.keys(passengerGroups).forEach(type => {
                const group = passengerGroups[type];
                if (group.totalQty > 0 && group.totalPrice > 0) {
                    passengerDetailsHTML += `
                        <div class="cip-passenger-detail-row" style="padding: 8px 0; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #555;">
                            <span>${group.label} (${group.totalQty} نفر)</span>
                            <span style="direction: ltr;">${formatPrice(group.totalPrice)} ریال</span>
                        </div>
                    `;
                }
            });
        }

        // دریافت عنوان سرویس اصلی
        const mainServiceTitle = cipData?.CipInfo?.Title?.fa || 'سرویس CIP';

        return `
        <div class="cip-selected-services-summary">
            <div class="cip-summary-header">
                <h3>
                    <i class="fa-solid fa-receipt"></i>
                    خلاصه سفارش
                </h3>
            </div>
            <div class="cip-summary-body">
                <!-- سرویس اصلی - قیمت واحد -->
                <div class="cip-summary-row" style="padding: 10px 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
                    <span style="font-weight: 600;">
                        <i class="fa-solid fa-star"></i>
                        ${mainServiceTitle}
                    </span>
                    <span style="color: #666; font-size: 14px;">
                        ${formatPrice(unitPrice)} ریال
                    </span>
                </div>

                <!-- جزئیات مسافران -->
                ${passengerDetailsHTML ? `
                <div id="cip-passenger-details" style="padding: 10px; background: #f8f9fa; border-radius: 4px; margin: 10px 0;">
                    <div style="font-weight: 600; margin-bottom: 8px; font-size: 14px; color: #333;">جزئیات مسافران:</div>
                    ${passengerDetailsHTML}
                </div>
                ` : ''}

                <!-- جمع سرویس اصلی -->
                <div class="cip-summary-total-row main-service" style="padding: 10px; display: flex; justify-content: space-between; align-items: center; font-weight: 600">
                    <span class="cip-summary-total-label">جمع سرویس اصلی:</span>
                    <span class="cip-summary-total-value">
                        <span id="cip-main-service-price">${formatPrice(totalPassengerPrice)}</span>
                        <small>ریال</small>
                    </span>
                </div>

                <!-- پیام خالی بودن -->
                <div id="cip-summary-empty-message" class="cip-summary-empty">
                    <i class="fa-solid fa-basket-shopping"></i>
                    <p>هنوز سرویس جانبی انتخاب نشده است</p>
                </div>

                <!-- محتوای سرویس‌های انتخاب شده -->
                <div id="cip-summary-content" style="display: none;">
                    <div class="cip-summary-divider"></div>

                    <!-- لیست سرویس‌های جانبی انتخاب شده -->
                    <div id="cip-selected-services-list"></div>

                    <div class="cip-summary-divider"></div>

                    <!-- جمع سرویس‌های جانبی -->
                    <div class="cip-summary-total-row ancillary-total">
                        <span class="cip-summary-total-label">جمع سرویس‌های جانبی:</span>
                        <span class="cip-summary-total-value">
                            <span id="cip-ancillary-total">0</span>
                            <small>ریال</small>
                        </span>
                    </div>
                </div>

                <!-- جمع کل نهایی -->
                <div class="cip-summary-total-row grand-total">
                    <span class="cip-summary-total-label">جمع کل:</span>
                    <span class="cip-summary-total-value">
                        <span id="cip-grand-total-summary">${formatPrice(totalPassengerPrice)}</span>
                        <small>ریال</small>
                    </span>
                </div>
            </div>

            <!-- دکمه ادامه خرید -->
            <div class="cip-continue-btn-wrapper">
                <button type="submit" class="cip-continue-btn" id="cip-continue-btn">
                    <span>ادامه خرید</span>
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            </div>

            <input type="hidden" name="finalTotal" id="cip-final-total-input" value="${totalPassengerPrice}">
        </div>
        `;
    }

    function inputService(serviceName, serviceId, index) {
        let html = '';

        switch (serviceName) {
            case 'pet':
                html = `
                <div class="cip-extra-input-group mb-3" data-unit="${index + 1}">
                    <label class="small text-muted mb-2 d-block fw-bold">
                        حیوان خانگی 
                    </label>
                    <div class="cip-service-inputs-grid">
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][pet_info]"
                                   placeholder="نوع حیوان و وزن تقریبی"
                                   ${index === 0 ? 'required' : ''}>
                        </div>
                    </div>
                </div>
                `;
                break;

            case 'transfer':
                html = `
                <div class="cip-extra-input-group mb-3" data-unit="${index + 1}">
                    <label class="small text-muted mb-2 d-block fw-bold">
                        ترانسفر - واحد ${index + 1}
                    </label>
                    <div class="cip-service-inputs-grid">
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][origin_address]"
                                   placeholder="آدرس مبدا"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][destination_address]"
                                   placeholder="آدرس مقصد"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm cip-birthdate-picker"
                                   name="services[${serviceId}][units][${index}][date]"
                                   placeholder="انتخاب تاریخ"
                                   readonly
                                   style="cursor: pointer;"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][time]"
                                   placeholder="ساعت (مثال: 14:30)"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="tel"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][phone]"
                                   placeholder="شماره تلفن"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="number"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][luggage_count]"
                                   placeholder="تعداد چمدان"
                                   min="0"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="number"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][passenger_count]"
                                   placeholder="تعداد مسافر"
                                   min="1"
                                   required>
                        </div>
                    </div>
                </div>
                `;
                break;

            case 'attendant':
                html = `
                <div class="cip-extra-input-group mb-3" data-unit="${index + 1}">
                    <label class="small text-muted mb-2 d-block fw-bold">
                        همراه - واحد ${index + 1}
                    </label>
                    <div class="cip-service-inputs-grid">
                        <div class="cip-service-input-item">
                            <input class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][first_name]"
                                   placeholder="نام (انگلیسی)"
                                   pattern="[A-Za-z\\s]+"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][last_name]"
                                   placeholder="نام خانوادگی (انگلیسی)"
                                   pattern="[A-Za-z\\s]+"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <select class="form-control form-control-sm"
                                    name="services[${serviceId}][units][${index}][gender]"
                                    required>
                                <option value="">انتخاب جنسیت</option>
                                <option value="male">آقا</option>
                                <option value="female">خانم</option>
                            </select>
                        </div>
                        <div class="cip-service-input-item">
                            <select class="form-control form-control-sm"
                                    name="services[${serviceId}][units][${index}][nationality]"
                                    required>
                                ${generateCountryOptions('IR')}
                            </select>
                        </div>
                        <div class="cip-service-input-item">
                            <input class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][national_code]"
                                   placeholder="کد ملی"
                                   maxlength="10"
                                   required>
                        </div>
                    </div>
                </div>
                `;
                break;

            case 'parking':
                html = `
                <div class="cip-extra-input-group mb-3" data-unit="${index + 1}">
                    <label class="small text-muted mb-2 d-block fw-bold">
                        پارکینگ - واحد ${index + 1}
                    </label>
                    <div class="cip-service-inputs-grid">
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][vehicle_type]"
                                   placeholder="نوع خودرو"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][vehicle_color]"
                                   placeholder="رنگ خودرو"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm cip-birthdate-picker"
                                   name="services[${serviceId}][units][${index}][delivery_date]"
                                   placeholder="انتخاب تاریخ تحویل"
                                   readonly
                                   style="cursor: pointer;"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][delivery_time]"
                                   placeholder="ساعت تحویل (مثال: 14:30)"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="text"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][license_plate]"
                                   placeholder="پلاک خودرو"
                                   required>
                        </div>
                        <div class="cip-service-input-item">
                            <input type="number"
                                   class="form-control form-control-sm"
                                   name="services[${serviceId}][units][${index}][days_count]"
                                   placeholder="تعداد روز"
                                   min="1"
                                   required>
                        </div>
                    </div>
                </div>
                `;
                break;

            default:
                html = '';
                break;
        }

        return html;
    }

    function generateServiceBox(cipData) {
        console.log('Generating service box with data:', cipData);
        // دریافت سرویس‌ها از cipData
        const services = cipData.Services || [];

        // اگر سرویسی موجود نیست، باکس نمایش داده نشود
        if (services.length === 0) return '';

        let desktopHTML = '';
        let mobileHTML = '';

        // ایجاد ردیف‌های جدول برای دسکتاپ و کارت برای موبایل
        services.forEach((service, index) => {
            const serviceId = service.CipId || index;
            const safeId = `cip-service-${serviceId}`;
            const maxQuantity = service.max_quantity || 10; // حداکثر تعداد مجاز
            const minQuantity = service.min_quantity || 0;  // حداقل تعداد مجاز
            const defaultValue = 0;
            const totalPrice = service.PassengerDatas?.[0]?.TotalPrice || 0;
            const pricePerUnit = service.PassengerDatas?.[0]?.Price || totalPrice; // قیمت هر واحد
            const title = service.CipInfo?.Title?.fa || 'سرویس';
            const description = service.CipInfo?.Desciption?.fa || '';
            const hasCheckbox = service.has_checkbox || false; // آیا چک‌باکس دارد؟
            const serviceCip = service.CipInfo.CipService;
            // تنظیمات اینپوت‌های سفارشی برای هر سرویس
            // ساختار: { fields: [{ type: 'text|number|select|date|textarea', label: '', name: '', placeholder: '', required: bool, options: [{value, label}] }] }
            const inputConfig = service.input_config || null;
            const inputConfigAttr = inputConfig ? `data-input-config='${JSON.stringify(inputConfig)}'` : '';

            // تولید اینپوت‌های اضافی بر اساس تعداد پیش‌فرض
            let extraInputsHTML = '';
            let mobileExtraInputsHTML = '';

            for (let i = 0; i < defaultValue; i++) {
                if (inputConfig && inputConfig.fields && inputConfig.fields.length > 0) {
                    // extraInputsHTML = inputService(serviceCip, serviceId, i);
                    // mobileExtraInputsHTML = inputService(serviceCip, serviceId, i);
                container.innerHTML += inputService(serviceCip, serviceId, i)
                console.log('data: ' , extraInputsHTML)


                } else {
                    inputService(serviceCip , serviceId , i)
                }
            }

            // HTML برای دسکتاپ (جدول)
            desktopHTML += `
        <tr class="cip-service-row" data-service-id="${serviceId}" data-unit-price="${pricePerUnit}" data-cip-service="${serviceCip}" ${inputConfigAttr}>
            <td class="cip-service-title">
                <div class="cip-service-title-wrapper">
                    <div class="d-flex align-items-start">
                        ${hasCheckbox ? `
                            <div class="form-check ml-2 mt-1">
                                <input type="checkbox" 
                                       class="form-check-input cip-service-checkbox" 
                                       id="checkbox-${safeId}"
                                       ${defaultValue > 0 ? 'checked' : ''}
                                       onchange="toggleService('${safeId}', this)">
                                <label class="form-check-label" for="checkbox-${safeId}"></label>
                            </div>
                        ` : ''}
                        <div>
                            <strong>${title}</strong>
                            ${description ? `<small class="cip-service-desc d-block mt-1">${description}</small>` : ''}
                        </div>
                    </div>
                </div>
            </td>

            <td class="cip-service-quantity">
                <div class="cip-quantity-control" style="${hasCheckbox && defaultValue === 0 ? 'opacity: 0.5; pointer-events: none;' : ''}">
                    <button type="button"
                            class="cip-quantity-btn cip-quantity-minus"
                            onclick="decreaseQuantity('${safeId}', ${hasCheckbox})"
                            ${defaultValue <= minQuantity ? 'disabled' : ''}>
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <input type="number"
                           id="${safeId}"
                           name="services[${serviceId}][quantity]"
                           class="cip-quantity-input"
                           value="${defaultValue}"
                           min="${minQuantity}"
                           max="${maxQuantity}"
                           data-price="${pricePerUnit}"
                           onchange="updateServiceTotal('${safeId}')"
                           ${hasCheckbox && defaultValue === 0 ? 'readonly' : ''}>
                    <button type="button"
                            class="cip-quantity-btn cip-quantity-plus"
                            onclick="increaseQuantity('${safeId}', ${hasCheckbox})"
                            ${defaultValue >= maxQuantity ? 'disabled' : ''}>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </td>

            <td class="cip-service-total">
                <div class="cip-fixed-price-display">
                    <span class="cip-price-value">${formatPrice(pricePerUnit)}</span>
                    <small class="cip-price-unit">ریال</small>
                </div>
                <input type="hidden"
                       name="services[${serviceId}][total]"
                       id="${safeId}-total-input"
                       value="${defaultValue > 0 ? pricePerUnit : 0}"
                       data-quantity="${defaultValue}"
                       data-unit-price="${pricePerUnit}">
                <input type="hidden"
                       name="services[${serviceId}][unit_price]"
                       value="${pricePerUnit}">
            </td>
        </tr>
        ${['pet','transfer','attendant','parking'].includes(serviceCip) ? `
        <tr class="cip-extra-inputs-row">
            <td colspan="3" style="padding: 0; border-bottom: 1px solid var(--cip-gray-100);">
                <div class="cip-extra-inputs" id="extra-inputs-${safeId}"
                     style="display: ${defaultValue > 0 ? 'block' : 'none'}">
                    ${extraInputsHTML}
                </div>
            </td>
        </tr>
        ` : ''}
        `;

            // HTML برای موبایل (کارت)
            mobileHTML += `
        <div class="cip-service-card" data-service-id="${serviceId}" data-unit-price="${pricePerUnit}" data-cip-service="${serviceCip}" ${inputConfigAttr}>
            <div class="cip-service-card-header">
                <div class="cip-service-card-title">
                    <div class="d-flex align-items-start">
                        ${hasCheckbox ? `
                            <div class="form-check ml-2 mt-1">
                                <input type="checkbox" 
                                       class="form-check-input cip-service-checkbox" 
                                       id="checkbox-mobile-${safeId}"
                                       ${defaultValue > 0 ? 'checked' : ''}
                                       onchange="toggleService('${safeId}', this)">
                                <label class="form-check-label" for="checkbox-mobile-${safeId}"></label>
                            </div>
                        ` : ''}
                        <div>
                            <strong>${title}</strong>
                            ${description ? `<small class="cip-service-card-desc d-block mt-1">${description}</small>` : ''}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="cip-service-card-body">
                ${['pet','transfer','attendant','parking'].includes(serviceCip) ? `
                <!-- اینپوت‌های اضافی در موبایل -->
                <div class="cip-extra-inputs mb-3" id="extra-inputs-mobile-${safeId}"
                     style="display: ${defaultValue > 0 ? 'block' : 'none'}">
                    ${mobileExtraInputsHTML}
                </div>
                ` : ''}
                
                <div class="cip-service-card-row">
                    <div class="cip-service-card-label">تعداد:</div>
                    <div class="cip-service-card-value">
                        <div class="cip-quantity-control mobile" style="${hasCheckbox && defaultValue === 0 ? 'opacity: 0.5; pointer-events: none;' : ''}">
                            <button type="button" 
                                    class="cip-quantity-btn cip-quantity-minus" 
                                    onclick="decreaseQuantity('${safeId}', ${hasCheckbox})"
                                    ${defaultValue <= minQuantity ? 'disabled' : ''}>
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <input type="number" 
                                   id="${safeId}-mobile"
                                   name="services[${serviceId}][quantity]"
                                   class="cip-quantity-input"
                                   value="${defaultValue}"
                                   min="${minQuantity}"
                                   max="${maxQuantity}"
                                   data-price="${pricePerUnit}"
                                   onchange="updateServiceTotal('${safeId}')"
                                   ${hasCheckbox && defaultValue === 0 ? 'readonly' : ''}>
                            <button type="button" 
                                    class="cip-quantity-btn cip-quantity-plus" 
                                    onclick="increaseQuantity('${safeId}', ${hasCheckbox})"
                                    ${defaultValue >= maxQuantity ? 'disabled' : ''}>
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="cip-service-card-row">
                    <div class="cip-service-card-label">قیمت:</div>
                    <div class="cip-service-card-value">
                        <div class="cip-fixed-price-display">
                            <span class="cip-price-value">${formatPrice(pricePerUnit)}</span>
                            <small class="cip-price-unit">ریال</small>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden"
                   name="services[${serviceId}][total]"
                   id="${safeId}-total-input-mobile"
                   value="${defaultValue > 0 ? pricePerUnit : 0}"
                   data-quantity="${defaultValue}"
                   data-unit-price="${pricePerUnit}">
            <input type="hidden"
                   name="services[${serviceId}][unit_price]"
                   value="${pricePerUnit}">
        </div>
        `;
        });

        return `
    <div class="cip-services-wrapper">
        <div class="cip-services-header" onclick="this.parentElement.classList.toggle('cip-services-open')" style="cursor: pointer;">
            <h2 class="cip-section-title">
                <i class="fa-solid fa-concierge-bell"></i>
                سرویس های جانبی
            </h2>
            <i class="fa-solid fa-chevron-down cip-services-toggle-icon"></i>
        </div>

        <div class="cip-services-content" style="display: none;">
            <!-- نسخه دسکتاپ (جدول) -->
            <div class="cip-services-desktop d-none d-md-block">
                <div class="cip-services-body">
                    <div class="cip-table-responsive">
                        <table class="cip-services-table">
                            <thead>
                                <tr>
                                    <th width="60%">شرح / عنوان سرویس</th>
                                    <th width="20%">تعداد</th>
                                    <th width="20%">قیمت کل</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${desktopHTML}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- نسخه موبایل (کارت) -->
            <div class="cip-services-mobile d-md-none">
                <div class="cip-services-cards">
                    ${mobileHTML}
                </div>
            </div>
        </div>
    </div>

    <!-- باکس خلاصه سرویس‌های انتخاب شده -->
    ${generateSelectedServicesSummary(cipData)}
    `;
    }


    /**
     * Go to next step in stepper
     */
    function goToNextStep() {
        const $current = $('#steps .step.active');
        if (!$current.length) return;

        // step فعلی → done
        $current.removeClass('active').addClass('done');

        // جایگزینی آیکن با تیک
        const $iconWrapper = $current.find('span').first();
        if (!$iconWrapper.find('.fa-check').length) {
            $iconWrapper.html('<i class="fa fa-check"></i>');
        }

        // separator بعدی
        $current.next('.separator').addClass('done');

        // step بعدی → active
        const $nextStep = $current.nextAll('.step').first();
        if ($nextStep.length) {
            $nextStep.addClass('active');
        }
    }

    /**
     * Show pre-invoice page after successful PreReserve
     */
    function showPreInvoice(response, passengerData) {
        const container = document.querySelector('.parent-hotel-details--new');
        if (!container) return;

        const cipData = JSON.parse(localStorage.getItem('selectedCip') || '{}');
        const reserveCode = (response && response.Code) || '';

        // ساخت لیست مسافران
        let passengersHTML = '';
        passengerData.forEach(function(p, index) {
            const pType = p.passengerType ? p.passengerType.toUpperCase() : 'ADT';
            const typeLabel = pType === 'ADT' ? 'بزرگسال' : (pType === 'CHD' ? 'کودک' : 'نوزاد');
            const typeIcon = pType === 'ADT' ? 'fa-user' : (pType === 'CHD' ? 'fa-child' : 'fa-baby');
            const typeBadgeClass = pType === 'ADT' ? 'adult' : (pType === 'CHD' ? 'child' : 'infant');
            const docNumber = p.passportNumber || '-';
            const nationalCode = p.nationalCode || '-';
            const genderVal = p.gender || '';
            const genderLabel = (genderVal === 'MR' || genderVal === 'Male') ? 'آقا' :
                                (genderVal === 'MS' || genderVal === 'Female') ? 'خانم' :
                                (genderVal === 'MSTR') ? 'پسر' :
                                (genderVal === 'MISS') ? 'دختر' : '-';

            // پیدا کردن نام ملیت از لیست کشورها
            const nationalityCode = p.nationality || '';
            const countryObj = countries.find(c => c.code === nationalityCode);
            const nationalityLabel = countryObj ? countryObj.name : nationalityCode;

            passengersHTML += `
                <div class="cinv-passenger-card" style="animation-delay: ${index * 0.1}s">
                    <div class="cinv-passenger-top">
                        <div class="cinv-passenger-avatar">
                            <i class="fa-solid ${typeIcon}"></i>
                        </div>
                        <div class="cinv-passenger-name-wrap">
                            <span class="cinv-passenger-name">${p.firstName} ${p.lastName}</span>
                            <span class="cinv-passenger-badge ${typeBadgeClass}">${typeLabel}</span>
                        </div>
                        <span class="cinv-passenger-num">#${index + 1}</span>
                    </div>
                    <div class="cinv-passenger-grid">
                        <div class="cinv-info-chip">
                            <i class="fa-solid fa-venus-mars"></i>
                            <div>
                                <small>جنسیت</small>
                                <span>${genderLabel}</span>
                            </div>
                        </div>
                        <div class="cinv-info-chip">
                            <i class="fa-regular fa-calendar"></i>
                            <div>
                                <small>تاریخ تولد</small>
                                <span>${p.birthDate || '-'}</span>
                            </div>
                        </div>
                        <div class="cinv-info-chip">
                            <i class="fa-solid fa-globe"></i>
                            <div>
                                <small>ملیت</small>
                                <span>${nationalityLabel}</span>
                            </div>
                        </div>
                        <div class="cinv-info-chip">
                            <i class="fa-solid fa-id-card"></i>
                            <div>
                                <small>کد ملی</small>
                                <span>${nationalCode}</span>
                            </div>
                        </div>
                        <div class="cinv-info-chip">
                            <i class="fa-solid fa-passport"></i>
                            <div>
                                <small>شماره گذرنامه</small>
                                <span>${docNumber}</span>
                            </div>
                        </div>
                        <div class="cinv-info-chip">
                            <i class="fa-regular fa-calendar-xmark"></i>
                            <div>
                                <small>انقضا گذرنامه</small>
                                <span>${p.passportExpireDate || '-'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        // محاسبه قیمت‌ها
        let totalPassengerPrice = 0;
        let priceDetailsHTML = '';

        if (cipData.PassengerDatas && Array.isArray(cipData.PassengerDatas)) {
            const passengerGroups = {
                ADT: { label: 'بزرگسال', icon: 'fa-user', totalPrice: 0, totalQty: 0 },
                CHD: { label: 'کودک', icon: 'fa-child', totalPrice: 0, totalQty: 0 },
                INF: { label: 'نوزاد', icon: 'fa-baby', totalPrice: 0, totalQty: 0 }
            };

            cipData.PassengerDatas.forEach(pd => {
                const qty = parseInt(pd.PassengerQuantity) || 0;
                const pricePerPerson = parseFloat(pd.TotalPrice) || 0;
                const type = pd.PassengerType ? pd.PassengerType.toUpperCase() : '';
                const totalPriceForType = pricePerPerson * qty;
                totalPassengerPrice += totalPriceForType;

                if (passengerGroups[type]) {
                    passengerGroups[type].totalPrice += totalPriceForType;
                    passengerGroups[type].totalQty += qty;
                }
            });

            Object.keys(passengerGroups).forEach(type => {
                const group = passengerGroups[type];
                if (group.totalQty > 0 && group.totalPrice > 0) {
                    priceDetailsHTML += `
                        <div class="cinv-price-line">
                            <div class="cinv-price-line-right">
                                <i class="fa-solid ${group.icon}"></i>
                                <span>${group.label}</span>
                                <span class="cinv-price-qty">${group.totalQty} نفر</span>
                            </div>
                            <span class="cinv-price-amount">${formatPrice(group.totalPrice)} <small>ریال</small></span>
                        </div>
                    `;
                }
            });
        }

        // محاسبه سرویس‌های جانبی
        let ancillaryTotal = 0;
        let servicesHTML = '';
        const serviceRows = document.querySelectorAll('.cip-service-row');
        const processedIds = new Set();

        serviceRows.forEach(row => {
            const serviceId = row.getAttribute('data-service-id');
            if (processedIds.has(serviceId)) return;
            processedIds.add(serviceId);

            const unitPrice = parseFloat(row.getAttribute('data-unit-price')) || 0;
            const desktopInput = document.getElementById(`cip-service-${serviceId}`);
            const mobileInput = document.getElementById(`cip-service-${serviceId}-mobile`);
            const quantityInput = desktopInput || mobileInput;
            if (!quantityInput) return;

            const quantity = parseInt(quantityInput.value) || 0;
            if (quantity > 0) {
                const serviceTotal = unitPrice * quantity;
                ancillaryTotal += serviceTotal;
                const titleElement = row.querySelector('strong');
                const title = titleElement ? titleElement.textContent : 'سرویس';

                servicesHTML += `
                    <div class="cinv-price-line">
                        <div class="cinv-price-line-right">
                            <i class="fa-solid fa-concierge-bell"></i>
                            <span>${title}</span>
                            <span class="cinv-price-qty">${quantity} عدد</span>
                        </div>
                        <span class="cinv-price-amount">${formatPrice(serviceTotal)} <small>ریال</small></span>
                    </div>
                `;
            }
        });

        const grandTotal = totalPassengerPrice + ancillaryTotal;
        const mainServiceTitle = cipData?.CipInfo?.Title?.fa || 'سرویس CIP';

        // ساخت HTML پیش فاکتور
        container.innerHTML = `
            <div class="cinv-wrapper">

                <!-- هدر موفقیت‌آمیز -->
                <div class="cinv-success-banner d-none">
                    <div class="cinv-success-icon-wrap">
                        <div class="cinv-success-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </div>
                    <h2 class="cinv-success-title">رزرو با موفقیت ثبت شد</h2>
                    <p class="cinv-success-subtitle">لطفا اطلاعات زیر را بررسی و تایید نمایید</p>
                    ${reserveCode ? `
                    <div class="cinv-reserve-code">
                        <span>کد رزرو</span>
                        <strong>${reserveCode}</strong>
                    </div>
                    ` : ''}
                </div>

                <!-- لایوت دو ستونه -->
                <div class="cinv-body">

                    <!-- ستون اصلی -->
                    <div class="cinv-main-col">

                        <!-- کارت اطلاعات سرویس -->
                        <div class="cinv-card">
                            <div class="cinv-card-header">
                                <div class="cinv-card-icon"><i class="fa-solid fa-plane-departure"></i></div>
                                <h3>اطلاعات سرویس</h3>
                            </div>
                            <div class="cinv-card-body">
                                <div class="cinv-service-detail">
                                    <div class="cinv-info-chip highlight">
                                        <i class="fa-solid fa-star"></i>
                                        <div>
                                            <small>نام سرویس</small>
                                            <span>${mainServiceTitle}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- کارت مسافران -->
                        <div class="cinv-card">
                            <div class="cinv-card-header">
                                <div class="cinv-card-icon"><i class="fa-solid fa-users"></i></div>
                                <h3>اطلاعات مسافران</h3>
                                <span class="cinv-card-badge">${passengerData.length} نفر</span>
                            </div>
                            <div class="cinv-card-body cinv-passengers-list">
                                ${passengersHTML}
                            </div>
                        </div>
                    </div>

                    <!-- ستون سایدبار (قیمت) -->
                    <div class="cinv-side-col">
                        <div class="cinv-price-card">
                            <div class="cinv-price-card-header">
                                <i class="fa-solid fa-receipt"></i>
                                <h3>جزئیات قیمت</h3>
                            </div>

                            <div class="cinv-price-card-body">
                                <!-- سرویس اصلی -->
                                <div class="cinv-price-group">
                                    <div class="cinv-price-group-label">
                                        <i class="fa-solid fa-star"></i>
                                        سرویس اصلی
                                    </div>
                                    ${priceDetailsHTML}
                                    <div class="cinv-price-subtotal">
                                        <span>جمع سرویس اصلی</span>
                                        <span>${formatPrice(totalPassengerPrice)} <small>ریال</small></span>
                                    </div>
                                </div>

                                ${servicesHTML ? `
                                <div class="cinv-price-group">
                                    <div class="cinv-price-group-label">
                                        <i class="fa-solid fa-concierge-bell"></i>
                                        سرویس‌های جانبی
                                    </div>
                                    ${servicesHTML}
                                    <div class="cinv-price-subtotal">
                                        <span>جمع سرویس‌های جانبی</span>
                                        <span>${formatPrice(ancillaryTotal)} <small>ریال</small></span>
                                    </div>
                                </div>
                                ` : ''}
                            </div>

                            <div class="cinv-price-total">
                                <span>مبلغ قابل پرداخت</span>
                                <span class="cinv-price-total-value">${formatPrice(grandTotal)} <small>ریال</small></span>
                            </div>

                            <!-- قوانین -->
                            <div class="cinv-rules">
                                <label class="cinv-rules-label">
                                    <input type="checkbox" id="cipRulesCheck">
                                    <span class="cinv-checkbox-custom"></span>
                                    <span><a href="/gds/fa/rules" target="_blank">قوانین و مقررات</a> را مطالعه کرده و می‌پذیرم.</span>
                                </label>
                            </div>

                            <!-- دکمه پرداخت -->
                            <button type="button" class="cinv-pay-btn" id="cipFinalApproveBtn">
                                <i class="fa-solid fa-lock"></i>
                                <span>تایید و پرداخت امن</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // اسکرول به بالا
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // رویداد دکمه تایید نهایی
        document.getElementById('cipFinalApproveBtn').addEventListener('click', function() {
            if (!document.getElementById('cipRulesCheck').checked) {
                // نمایش خطا روی چک‌باکس
                var rulesEl = document.querySelector('.cinv-rules');
                rulesEl.classList.add('cinv-rules-error');
                setTimeout(function() { rulesEl.classList.remove('cinv-rules-error'); }, 2000);
                return;
            }

            // ست کردن قیمت نهایی در تگ price-after-discount-code
            var finalTotalInput = document.getElementById('cip-final-total-input');
            var finalTotal = finalTotalInput ? parseInt(finalTotalInput.value) || 0 : 0;
            var priceAfterDiscountEl = document.querySelector('.price-after-discount-code');
            if (priceAfterDiscountEl && finalTotal > 0) {
                priceAfterDiscountEl.innerHTML = formatPrice(finalTotal) + '<i>ریال</i>';
                priceAfterDiscountEl.classList.remove('d-none');
            }

            // ست کردن requestNumber از localStorage در دکمه‌های پرداخت
            var cipDataForPay = JSON.parse(localStorage.getItem('selectedCip') || '{}');
            var reqNumber = cipDataForPay.Code || '';

            // آپدیت دکمه پرداخت بانکی (go_bank_click)
            var bankBtn = document.querySelector('.go_bank_click');
            if (bankBtn) {
                var bankOnclick = bankBtn.getAttribute('onclick');
                bankBtn.setAttribute('onclick', bankOnclick.replace(/"requestNumber"\s*:\s*""/, '"requestNumber":"' + reqNumber + '"'));
            }

            // آپدیت input مخفی go_bank_app
            var bankAppInput = document.getElementById('go_bank_app');
            if (bankAppInput) {
                var bankAppData = JSON.parse(bankAppInput.value || '{}');
                bankAppData.requestNumber = reqNumber;
                bankAppInput.value = JSON.stringify(bankAppData);
            }

            // آپدیت دکمه پرداخت اعتباری (creditpay)
            var creditBtn = document.getElementById('creditpay');
            if (creditBtn) {
                var creditOnclick = creditBtn.getAttribute('onclick');
                creditBtn.setAttribute('onclick', creditOnclick.replace(/"requestNumber"\s*:\s*""/, '"requestNumber":"' + reqNumber + '"'));
            }

            // نمایش بخش پرداخت
            var payContent = document.querySelector('.main-pay-content');
            if (payContent) {
                payContent.style.setProperty('display', 'flex', 'important');
                payContent.scrollIntoView({ behavior: 'smooth' });
            }
            goToNextStep();
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCipPassengerForms);
    } else {
        initCipPassengerForms();
    }
    function cipOpenPhonebook(id) {
        $("#numberRow").attr('value', id);
        $("#lightboxContainer").addClass("displayBlock");
        $('.last-p-popup').fadeIn();
    }

    // Close phonebook popup when clicking backdrop or close button
    $(document).ready(function() {
        $("div#lightboxContainer").on('click', function() {
            $(this).removeClass("displayBlock");
            $(".last-p-popup").fadeOut();
        });
        $(document).on('click', '.s-u-close-last-p', function() {
            $("#lightboxContainer").removeClass("displayBlock");
            $(".last-p-popup").fadeOut();
        });
    });

// Export functions to window
    window.cipOpenPhonebook = cipOpenPhonebook;
    window.increaseQuantity = increaseQuantity;
    window.decreaseQuantity = decreaseQuantity;
    window.updateServiceTotal = updateServiceTotal;
    window.updateGrandTotal = updateGrandTotal;
    window.toggleService = toggleService;
    window.showExtraInputs = showExtraInputs;
    window.hideExtraInputs = hideExtraInputs;
    window.generateExtraInputs = generateExtraInputs;
    window.updateQuantityButtons = updateQuantityButtons;
    window.formatPrice = formatPrice;
    window.updateSelectedServicesSummary = updateSelectedServicesSummary;
    window.generateSelectedServicesSummary = generateSelectedServicesSummary;
    window.initDatepickers = initDatepickers;
    window.goToNextStep = goToNextStep;
    window.showPreInvoice = showPreInvoice;
    // Export for external use
    window.CipPassengerManager = {
        getSelectedCip,
        getPassengerQuantity,
        validateAllForms,
        getAllPassengerData,
        getAllServiceData
    };

})();
