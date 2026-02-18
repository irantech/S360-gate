/**
 * ========================================
 * LOTTERY SYSTEM - Client Side
 * ========================================
 */

(function() {
    'use strict';


    // ========================================
    // CONFIG
    // ========================================
    const CONFIG = {
        ajaxUrl: (typeof amadeusPath !== 'undefined' ? amadeusPath : '/gds/') + 'ajax',
        otpLength: 4,
        countdownSeconds: 120
    };


    // ========================================
    // STATE
    // ========================================
    let currentStep = 1;
    let userPhone = '';
    let countdownTimer = null;
    let remainingSeconds = 0;
    let userData = null; // ذخیره اطلاعات کاربر برای لاگین

    // ========================================
    // GET ELEMENTS
    // ========================================
    function getElements() {
        return {
            modal: document.getElementById('lottery-modal'),
            trigger: document.querySelector('.lottery-trigger'),
            closeBtn: document.querySelectorAll('.lottery-modal-close, .lottery-modal-close-btn'),
            overlay: document.querySelector('.lottery-modal-overlay'),
            steps: document.querySelectorAll('.lottery-step'),

            phoneInput: document.getElementById('lottery-phone'),
            phoneError: document.getElementById('phone-error'),
            phoneNextBtn: document.querySelector('.lottery-step-1 .lottery-next'),

            codeInput: document.getElementById('lottery-code'),
            codeError: document.getElementById('code-error'),
            codeNextBtn: document.querySelector('.lottery-step-2 .lottery-next'),
            countdownDisplay: document.getElementById('countdown-timer'),
            countdownContainer: document.getElementById('countdown-container'),
            resendBtn: document.getElementById('resend-otp'),

            prizeImage: document.getElementById('lottery-prize-image'),
            backBtns: document.querySelectorAll('.lottery-back')
        };
    }

    // ========================================
    // UTILITY FUNCTIONS
    // ========================================
    function showError(element, message) {
        if (!element) return;
        element.textContent = message;
        element.style.display = 'block';
        element.style.opacity = '1';
    }

    function clearError(element) {
        if (!element) return;
        element.textContent = '';
        element.style.display = 'none';
        element.style.opacity = '0';
    }

    function setLoading(button, loading) {
        if (!button) return;
        if (loading) {
            button.classList.add('loading');
            button.disabled = true;
            button.dataset.originalText = button.textContent;
            button.textContent = 'در حال پردازش...';
        } else {
            button.classList.remove('loading');
            button.disabled = false;
            if (button.dataset.originalText) {
                button.textContent = button.dataset.originalText;
            }
        }
    }

    // ========================================
    // COUNTDOWN
    // ========================================
    function startCountdown() {
        const elements = getElements();

        remainingSeconds = CONFIG.countdownSeconds;
        updateCountdownDisplay();

        // نمایش countdown و مخفی کردن دکمه resend
        if (elements.countdownContainer) {
            elements.countdownContainer.style.display = 'block';
        }
        if (elements.resendBtn) {
            elements.resendBtn.style.display = 'none';
        }

        if (countdownTimer) {
            clearInterval(countdownTimer);
        }

        countdownTimer = setInterval(function() {
            remainingSeconds--;
            updateCountdownDisplay();

            if (remainingSeconds <= 0) {
                stopCountdown();
                enableResend();
            }
        }, 1000);
    }

    function stopCountdown() {
        if (countdownTimer) {
            clearInterval(countdownTimer);
            countdownTimer = null;
        }
    }

    function updateCountdownDisplay() {
        const elements = getElements();
        if (!elements.countdownDisplay) return;

        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;
        const display = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        elements.countdownDisplay.textContent = display;

        if (remainingSeconds <= 10) {
            elements.countdownDisplay.classList.add('warning');
        } else {
            elements.countdownDisplay.classList.remove('warning');
        }
    }

    function enableResend() {
        const elements = getElements();

        // مخفی کردن countdown و نمایش دکمه resend
        if (elements.countdownContainer) {
            elements.countdownContainer.style.display = 'none';
        }
        if (elements.resendBtn) {
            elements.resendBtn.style.display = 'inline-block';
            elements.resendBtn.disabled = false;
            elements.resendBtn.textContent = 'ارسال مجدد کد';
        }
    }

    function disableResend() {
        const elements = getElements();
        // نمایش countdown و مخفی کردن resend button
        if (elements.countdownContainer) {
            elements.countdownContainer.style.display = 'block';
        }
        if (elements.resendBtn) {
            elements.resendBtn.style.display = 'none';
            elements.resendBtn.disabled = true;
        }
    }

    // ========================================
    // VALIDATION
    // ========================================
    function validatePhone(phone) {
        const cleanPhone = phone.replace(/[\s-]/g, '');

        if (!cleanPhone) {
            return { valid: false, message: 'لطفاً شماره موبایل را وارد کنید' };
        }

        if (cleanPhone.length !== 11) {
            return { valid: false, message: 'شماره موبایل باید 11 رقم باشد' };
        }

        if (!/^09[0-9]{9}$/.test(cleanPhone)) {
            return { valid: false, message: 'فرمت شماره موبایل صحیح نیست' };
        }

        return { valid: true, phone: cleanPhone };
    }

    function validateCode(code) {
        const cleanCode = code.replace(/\s/g, '');

        if (!cleanCode) {
            return { valid: false, message: 'لطفاً کد تأیید را وارد کنید' };
        }

        if (cleanCode.length !== CONFIG.otpLength) {
            return { valid: false, message: 'کد تأیید باید ' + CONFIG.otpLength + ' رقم باشد' };
        }

        if (!/^[0-9]{4}$/.test(cleanCode)) {
            return { valid: false, message: 'کد تأیید فقط باید شامل اعداد باشد' };
        }

        return { valid: true, code: cleanCode };
    }

    // ========================================
    // API CALLS
    // ========================================
    function requestOTP(phone) {


        const requestData = {
            className: 'lottery',
            method: 'requestOtp',
            phone: phone
        };



        return fetch(CONFIG.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {


            if (!response.ok) {
                throw new Error('خطا');
            }

            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);

                return data;
            } catch (e) {
                throw new Error('خطا در پردازش پاسخ سرور');
            }
        })
        .catch(error => {

            throw error;
        });
    }
    function getLotteryIdFromUrl() {
        const parts = window.location.pathname.split('/').filter(Boolean)
        return parseInt(parts[parts.length - 1], 10) || 0
    }
    function verifyOTP(phone, code) {
        const lotteryId = getLotteryIdFromUrl()
        const requestData = {
            className: 'lottery',
            method: 'verifyOtp',
            phone: phone,
            code: code,
            lottery_id: lotteryId
        };


        return fetch(CONFIG.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {


            return response.text();

        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                return data;
            } catch (e) {

                throw new Error('خطا در پردازش پاسخ سرور');
            }
        })
        .catch(error => {
            throw error;
        });
    }

    // ========================================
    // STEP HANDLERS
    // ========================================
    function handleStep1Next() {
        const elements = getElements();

        if (!elements.phoneInput) {
            return;
        }

        const phone = elements.phoneInput.value.trim();

        const validation = validatePhone(phone);

        if (!validation.valid) {
            showError(elements.phoneError, validation.message);
            elements.phoneInput.classList.add('error');
            return;
        }

        clearError(elements.phoneError);
        elements.phoneInput.classList.remove('error');

        setLoading(elements.phoneNextBtn, true);

        requestOTP(validation.phone)
            .then(response => {
                setLoading(elements.phoneNextBtn, false);

                if (response && response.success) {
                    userPhone = validation.phone;
                    goToStep(2);
                    startCountdown();
                    disableResend();
                } else {
                    const errorMsg = response && response.message ? response.message : 'خطا در ارسال کد';
                    showError(elements.phoneError, errorMsg);
                }
            })
            .catch(error => {
                setLoading(elements.phoneNextBtn, false);
                const errorMsg = error.message || 'خطا در ارسال درخواست';
                showError(elements.phoneError, errorMsg);
            });
    }

    function handleStep2Next() {
        const elements = getElements();

        if (!elements.codeInput) {
            return;
        }

        const code = elements.codeInput.value.trim();

        const validation = validateCode(code);

        if (!validation.valid) {
            showError(elements.codeError, validation.message);
            elements.codeInput.classList.add('error');
            return;
        }

        clearError(elements.codeError);
        elements.codeInput.classList.remove('error');

        setLoading(elements.codeNextBtn, true);

        verifyOTP(userPhone, validation.code)
            .then(response => {
                setLoading(elements.codeNextBtn, false);

                if (response.success) {
                    stopCountdown();

                    // ذخیره اطلاعات کاربر برای لاگین بعد از بستن مودال
                    if (response.data && response.data.user) {
                        userData = response.data.user;
                    }

                    if (response.data && response.data.prize) {
                        showPrize(response.data.prize);
                    }

                    goToStep(3);
                } else {

                    const elements = getElements();

                    showError(elements.codeError , response.message);
                }
            })
            .catch(error => {
                setLoading(elements.codeNextBtn, false);
                showError(elements.codeError, error.message || 'خطا در تأیید کد');
            });
    }

    function handleResendOTP() {
        const elements = getElements();

        if (!userPhone) {
            return;
        }

        clearError(elements.codeError);
        setLoading(elements.resendBtn, true);

        requestOTP(userPhone)
            .then(response => {
                setLoading(elements.resendBtn, false);

                if (response.success) {
                    startCountdown();
                    disableResend();
                    showError(elements.codeError, 'کد جدید ارسال شد');
                    setTimeout(() => clearError(elements.codeError), 3000);
                } else {
                    showError(elements.codeError, response.message || 'خطا در ارسال مجدد');
                }
            })
            .catch(error => {
                setLoading(elements.resendBtn, false);
                showError(elements.codeError, error.message || 'خطا در ارسال درخواست');
            });
    }

    function showPrize(prize) {
        const elements = getElements();

        if (!elements.prizeImage || !prize) return;

        if (prize.image_path) {
            elements.prizeImage.src = '/gds/pic/' +  prize.image_path;
            elements.prizeImage.alt = prize.alt || 'جایزه شما';
        }
    }

    /**
     * لاگین کردن کاربر بعد از دریافت جایزه
     */
    function loginUser(user) {
        console.log('loginUser called with:', user);

        if (!user || !user.phone) {
            console.error('اطلاعات کاربر معتبر نیست');
            return;
        }

        // ارسال درخواست لاگین به سرور برای ست کردن session
        const requestData = {
            className: 'lottery',
            method: 'loginAfterLottery',
            phone: user.phone,
            user_id: user.id
        };

        console.log('Sending login request:', requestData);

        fetch(CONFIG.ajaxUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('Login response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Login response data:', data);

            if (data.success) {
                console.log('Login successful! Reloading page...');
                // لاگین موفق - صفحه رو reload کن تا session فعال بشه
                window.location.reload();
            } else {
                console.error('خطا در لاگین:', data.message);
                alert('خطا در ورود به سیستم: ' + data.message);
            }
        })
        .catch(error => {
            console.error('خطا در ارسال درخواست لاگین:', error);
            alert('خطا در ارسال درخواست لاگین');
        });
    }

    // ========================================
    // MODAL CONTROLS
    // ========================================
    function openModal() {
        const elements = getElements();

        if (!elements.modal) {
            return;
        }

        elements.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        goToStep(1);
    }

    function closeModal() {
        const elements = getElements();

        if (!elements.modal) return;

        // اگر کاربر جایزه رو دریافت کرده (step 3) و اطلاعات کاربر داریم، لاگین کن
        const shouldLogin = currentStep === 3 && userData !== null;

        console.log('closeModal - Debug:', {
            currentStep: currentStep,
            userData: userData,
            shouldLogin: shouldLogin
        });

        elements.modal.style.display = 'none';
        document.body.style.overflow = '';

        // لاگین کردن کاربر قبل از ریست (چون ریست userData را null می‌کند)
        if (shouldLogin) {
            const userDataCopy = userData;
            resetModal();
            loginUser(userDataCopy);
        } else {
            resetModal();
        }
    }

    function resetModal() {
        const elements = getElements();

        currentStep = 1;
        userPhone = '';
        userData = null;
        stopCountdown();

        if (elements.phoneInput) elements.phoneInput.value = '';
        if (elements.codeInput) elements.codeInput.value = '';

        clearError(elements.phoneError);
        clearError(elements.codeError);

        if (elements.phoneInput) elements.phoneInput.classList.remove('error');
        if (elements.codeInput) elements.codeInput.classList.remove('error');

        // ریست کردن نمایش countdown و resend button
        if (elements.countdownContainer) {
            elements.countdownContainer.style.display = 'block';
        }
        if (elements.resendBtn) {
            elements.resendBtn.style.display = 'none';
            elements.resendBtn.disabled = true;
        }
        if (elements.countdownDisplay) {
            elements.countdownDisplay.textContent = '2:00';
        }
    }

    function goToStep(stepNumber) {
        const elements = getElements();

        elements.steps.forEach((step, index) => {
            if (index + 1 === stepNumber) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });

        currentStep = stepNumber;

        setTimeout(() => {
            if (stepNumber === 1 && elements.phoneInput) {
                elements.phoneInput.focus();
            } else if (stepNumber === 2 && elements.codeInput) {
                elements.codeInput.focus();
            }
        }, 300);
    }

    // ========================================
    // EVENT LISTENERS
    // ========================================
    function setupEventListeners() {
        const elements = getElements();

        // Open modal
        if (elements.trigger) {
            elements.trigger.addEventListener('click', function(e) {
                e.preventDefault();
                openModal();
            });
        } else {
        }

        // Close modal
        elements.closeBtn.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                closeModal();
            });
        });

        // Close on overlay
        if (elements.overlay) {
            elements.overlay.addEventListener('click', closeModal);
        }

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && elements.modal && elements.modal.style.display === 'flex') {
                closeModal();
            }
        });

        // Step 1 next
        if (elements.phoneNextBtn) {
            elements.phoneNextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                handleStep1Next();
            });
        } else {
        }

        // Step 2 next
        if (elements.codeNextBtn) {
            elements.codeNextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                handleStep2Next();
            });
        }

        // Resend
        if (elements.resendBtn) {
            elements.resendBtn.addEventListener('click', function(e) {
                e.preventDefault();
                handleResendOTP();
            });
        }

        // Back buttons
        elements.backBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const backStep = parseInt(this.dataset.back);
                if (backStep) {
                    stopCountdown();
                    goToStep(backStep);
                }
            });
        });

        // Phone input
        if (elements.phoneInput) {
            elements.phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            elements.phoneInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    handleStep1Next();
                }
            });
        }

        // Code input
        if (elements.codeInput) {
            elements.codeInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            elements.codeInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    handleStep2Next();
                }
            });
        }
    }

    // ========================================
    // INIT
    // ========================================
    function init() {
        setupEventListeners();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
