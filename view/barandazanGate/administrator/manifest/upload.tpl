{load_presentation_object filename="manifestController" assign="objManifestController"}
{load_presentation_object filename="settingCore" assign="objFunctions"}

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title">آپلود مانیفست پرواز</h2>
                <p class="page-subtitle">آپلود و پردازش فایل مانیفست مسافران</p>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin">خانه</a></li>
                    <li class="breadcrumb-item"><a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/itadmin/manifest/sources">چارترکنندگان</a></li>
                    <li class="breadcrumb-item active">آپلود مانیفست</li>
            </ol>
            </nav>
        </div>
    </div>

    <!-- Main Upload Card -->
    <div class="upload-container">
        <div class="upload-card">
            <div class="upload-card-header">
                <div class="upload-header-content">
                    <div class="upload-icon">
                        <i class="fa fa-cloud-upload-alt"></i>
                    </div>
                    <div>
                        <h3 class="upload-title">آپلود فایل مانیفست</h3>
                        <p class="upload-description">فایل متنی (.txt) حاوی اطلاعات مسافران را آپلود کنید</p>
                    </div>
                </div>
            </div>

            <div class="upload-card-body">
                <form id="uploadManifestForm" data-toggle="validator" method="post" enctype="multipart/form-data">
                    <input type='hidden' value='uploadManifest' id='method' name='method'>
                    <input type='hidden' value='manifestController' id='className' name='className'>

                    <!-- Flight Information Section -->
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fa fa-plane"></i>
                            اطلاعات پرواز
                        </h4>
                        <p class="section-subtitle">این اطلاعات با محتوای فایل آپلودی مطابقت خواهد شد</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group-modern">
                            <label for="manifest_date" class="form-label">
                                <i class="fa fa-calendar-alt"></i>
                                تاریخ پرواز
                            </label>
                            <input type="text" class="form-control-modern datepicker" name="manifest_date"  
                                   autocomplete="off" id="manifest_date" 
                                   placeholder="تاریخ پرواز را انتخاب کنید" required>
                            <div class="form-help">
                                <i class="fa fa-info-circle"></i>
                                تاریخ باید با تاریخ موجود در فایل مانیفست مطابقت داشته باشد
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="route" class="form-label">
                                <i class="fa fa-route"></i>
                                مسیر پرواز
                            </label>
                            <input type="text" class="form-control-modern" name="route" id="route" 
                                   placeholder="مثال: THR-MHD" required>
                            <div class="form-help">
                                <i class="fa fa-info-circle"></i>
                                مسیر با فرمت کد فرودگاه مبدا - کد فرودگاه مقصد
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="airline_iata" class="form-label">
                                <i class="fa fa-tag"></i>
                                کد یاتا ایرلاین
                            </label>
                            <input type="text" class="form-control-modern" name="airline_iata" id="airline_iata" 
                                   placeholder="مثال: I3" required maxlength="2" style="text-transform: uppercase;">
                            <div class="form-help">
                                <i class="fa fa-info-circle"></i>
                                کد دو حرفی ایرلاین مطابق استاندارد IATA
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="section-header">
                        <h4 class="section-title">
                            <i class="fa fa-file-upload"></i>
                            آپلود فایل مانیفست
                        </h4>
                        <p class="section-subtitle">فایل متنی (.txt) حاوی اطلاعات مسافران را انتخاب کنید</p>
                    </div>

                    <div class="upload-zone-container">
                        <label for='manifest_file' id="drop_zone" class='upload-zone'
                               ondrop="dropHandlerUploadManifest(event);"
                               ondragover="dragOverHandlerUploadManifest(event);"
                               ondragleave="dragLeaveHandlerUploadManifest(event);">
                            <div class="upload-zone-content">
                                <div class="upload-zone-icon">
                                    <i class="fa fa-cloud-upload-alt"></i>
                                </div>
                                <h5 class="upload-zone-title">فایل مانیفست را اینجا بکشید</h5>
                                <p class="upload-zone-subtitle">یا کلیک کنید تا فایل را انتخاب کنید</p>
                                <div class="upload-zone-specs">
                                    <span class="spec-item">
                                        <i class="fa fa-file-alt"></i>
                                        فرمت: TXT
                                    </span>
                                    <span class="spec-item">
                                        <i class="fa fa-weight"></i>
                                        حداکثر: 10MB
                                    </span>
                                </div>
                            </div>
                        </label>

                        <input type='file' class='d-none' name='manifest_file' id='manifest_file' accept=".txt" required>

                        <div id='preview-gallery' class='upload-preview'></div>
                    </div>

                    <!-- Validation Results Area -->
                    <div id="validation-results" class="validation-section" style="display: none;">
                        <div class="validation-header">
                            <h5 class="validation-title">
                                <i class="fa fa-check-circle"></i>
                                نتایج بررسی فایل
                            </h5>
                        </div>
                        <div id="validation-content" class="validation-content">
                            <!-- Results will be populated here -->
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="submit-section">
                        <button class="btn-upload" type="submit" id='uploadButton' disabled>
                            <i class="fa fa-upload"></i>
                            <span class="btn-text">آپلود و پردازش مانیفست</span>
                            <div class="btn-loading" style="display: none;">
                                <i class="fa fa-spinner fa-spin"></i>
                                در حال پردازش...
                            </div>
                        </button>
                        
                        <div class="submit-help">
                            <i class="fa fa-lightbulb"></i>
                            پس از آپلود، فایل بررسی شده و در صورت صحت اطلاعات، در سیستم ثبت خواهد شد
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Card -->
        <div class="help-card">
            <div class="help-header">
                <h4 class="help-title">
                    <i class="fa fa-question-circle"></i>
                    راهنمای آپلود
                </h4>
            </div>
            <div class="help-content">
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fa fa-file-alt"></i>
                    </div>
                    <div class="help-text">
                        <strong>فرمت فایل:</strong>
                        فایل باید با پسوند .txt و با فرمت CSV باشد
                    </div>
                </div>
                
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <div class="help-text">
                        <strong>ساختار داده:</strong>
                        هر خط شامل: شماره بلیت، کد آژانس، نام/نام خانوادگی، نوع مسافر، ایرلاین، شماره پرواز، تاریخ، کد ملی، پاسپورت، جنسیت، تلفن
                    </div>
                </div>
                
                <div class="help-item">
                    <div class="help-icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="help-text">
                        <strong>نکات مهم:</strong>
                        اطلاعات وارد شده در فرم باید دقیقاً با محتوای فایل مطابقت داشته باشد
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Upload Page Styles */
body {
    font-family: 'Vazir', 'Tahoma', sans-serif;
    background: #f8fafc;
    color: #2d3748;
}

.page-header {
    background: white;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.page-title {
    font-size: 2.25rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 0.5rem 0;
}

.page-subtitle {
    color: #718096;
    margin: 0;
    font-size: 1.125rem;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #4299e1;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #718096;
}

.upload-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    align-items: start;
}

.upload-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.upload-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem;
    color: white;
}

.upload-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.upload-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.upload-title {
    font-size: 1.75rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
}

.upload-description {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 1rem;
}

.upload-card-body {
    padding: 2.5rem;
}

.section-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #4299e1;
}

.section-subtitle {
    color: #718096;
    margin: 0;
    font-size: 1rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.form-group-modern {
    position: relative;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.form-label i {
    color: #4299e1;
    width: 16px;
}

.form-control-modern {
    width: 100%;
    padding: 1rem 1.25rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    background: #fafbfc;
    transition: all 0.2s ease;
    color: #2d3748;
}

.form-control-modern:focus {
    outline: none;
    border-color: #4299e1;
    background: white;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.form-help {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #718096;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.form-help i {
    color: #a0aec0;
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.upload-zone-container {
    margin-bottom: 2rem;
}

.upload-zone {
    display: block;
    width: 100%;
    min-height: 200px;
    border: 3px dashed #cbd5e0;
    border-radius: 16px;
    background: #f7fafc;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.upload-zone:hover {
    border-color: #4299e1;
    background: #edf2f7;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 153, 225, 0.2);
}

.upload-zone.dragover {
    border-color: #38a169;
    background: #f0fff4;
    animation: pulse 1s ease infinite alternate;
}

@keyframes pulse {
    0% { transform: scale(1); }
    100% { transform: scale(1.02); }
}

.upload-zone-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 2rem;
    text-align: center;
    height: 100%;
}

.upload-zone-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(66, 153, 225, 0.3);
}

.upload-zone-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
}

.upload-zone-subtitle {
    color: #718096;
    margin: 0 0 1.5rem 0;
    font-size: 1rem;
}

.upload-zone-specs {
    display: flex;
    gap: 2rem;
    justify-content: center;
}

.spec-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #4a5568;
    font-size: 0.875rem;
    background: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
}

.spec-item i {
    color: #4299e1;
}

.upload-preview {
    margin-top: 1.5rem;
    padding: 1rem;
    background: #f7fafc;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    min-height: 50px;
    display: none;
}

.validation-section {
    margin: 2rem 0;
    padding: 1.5rem;
    background: #f0fff4;
    border: 1px solid #9ae6b4;
    border-radius: 12px;
}

.validation-header {
    margin-bottom: 1rem;
}

.validation-title {
    color: #2f855a;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.validation-content {
    color: #2d3748;
}

.submit-section {
    text-align: center;
    margin-top: 3rem;
}

.btn-upload {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: none;
    padding: 1rem 3rem;
    border-radius: 12px;
    font-size: 1.125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
    position: relative;
    overflow: hidden;
    min-width: 250px;
}

.btn-upload:hover:not(:disabled) {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(72, 187, 120, 0.4);
}

.btn-upload:disabled {
    background: #a0aec0;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.btn-text, .btn-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.submit-help {
    margin-top: 1rem;
    color: #718096;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.submit-help i {
    color: #f6ad55;
}

/* Help Card */
.help-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    height: fit-content;
    position: sticky;
    top: 2rem;
}

.help-header {
    background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
    color: white;
    padding: 1.5rem;
}

.help-title {
    margin: 0;
    font-weight: 600;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.help-content {
    padding: 1.5rem;
}

.help-item {
    display: flex;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.help-item:last-child {
    border-bottom: none;
}

.help-icon {
    width: 40px;
    height: 40px;
    background: #f7fafc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4299e1;
    flex-shrink: 0;
}

.help-text {
    color: #4a5568;
    line-height: 1.5;
}

.help-text strong {
    color: #2d3748;
    display: block;
    margin-bottom: 0.25rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .upload-container {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .help-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .upload-zone-specs {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .upload-card-body, .page-header {
        padding: 1.5rem;
    }
    
    .upload-header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
}

/* Loading States */
.form-loading .form-control-modern {
    opacity: 0.6;
    pointer-events: none;
}

.btn-upload.loading .btn-text {
    display: none;
}

.btn-upload.loading .btn-loading {
    display: flex;
}

/* Error States */
.form-control-modern.error {
    border-color: #e53e3e;
    background-color: #fed7d7;
}

.validation-section.error {
    background: #fed7d7;
    border-color: #e53e3e;
}

.validation-section.error .validation-title {
    color: #c53030;
}

.validation-section.error .validation-title i {
    content: '\f071'; /* exclamation-triangle */
}

/* Success and Error Message Styles */
.success-message, .error-message {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    border-radius: 8px;
}

.success-message {
    background: #f0fff4;
    border: 1px solid #9ae6b4;
}

.error-message {
    background: #fed7d7;
    border: 1px solid #feb2b2;
}

.success-icon, .error-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.success-icon {
    background: #48bb78;
    color: white;
}

.error-icon {
    background: #e53e3e;
    color: white;
}

.success-content h6, .error-content h6 {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
    font-size: 1.125rem;
}

.success-content h6 {
    color: #2f855a;
}

.error-content h6 {
    color: #c53030;
}

.success-content p, .error-content p {
    margin: 0;
    color: #2d3748;
    line-height: 1.5;
}

/* Upload Stats */
.upload-stats {
    margin-top: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.upload-stats h6 {
    margin: 0 0 1rem 0;
    color: #2d3748;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.upload-stats h6 i {
    color: #4299e1;
}

.stats-grid-small {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f7fafc;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.stat-item.warning {
    background: #fffaf0;
    border-color: #fbb6ce;
}

.stat-label {
    font-size: 0.875rem;
    color: #4a5568;
    font-weight: 500;
}

.stat-value {
    font-weight: 600;
    color: #2d3748;
    font-size: 0.875rem;
}

.stat-item.warning .stat-value {
    color: #d69e2e;
}

/* Error List */
.error-list {
    margin: 1rem 0;
}

.error-list ul {
    margin: 0;
    padding: 0 0 0 1.5rem;
    color: #2d3748;
}

.error-list li {
    margin-bottom: 0.5rem;
    line-height: 1.4;
    font-size: 0.9rem;
}

.error-simple {
    color: #2d3748;
    line-height: 1.5;
    margin: 1rem 0;
    padding: 1rem;
    background: white;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

/* Error Help */
.error-help {
    margin-top: 1.5rem;
    padding: 1rem;
    background: #f0f5ff;
    border-radius: 8px;
    border: 1px solid #bee3f8;
}

.error-help h6 {
    margin: 0 0 0.75rem 0;
    color: #2b6cb0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.error-help h6 i {
    color: #f6ad55;
}

.error-help ul {
    margin: 0;
    padding: 0 0 0 1.5rem;
    color: #2d3748;
}

.error-help li {
    margin-bottom: 0.5rem;
    line-height: 1.4;
    font-size: 0.9rem;
}

/* Loading Enhancement */
.form-loading {
    opacity: 0.6;
    pointer-events: none;
}

/* File Preview Styles */
.manifest-file-preview {
    margin-top: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    transition: all 0.2s ease;
}

.file-preview-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.file-info {
    flex: 1;
}

.file-name {
    margin: 0 0 0.5rem 0;
    color: #2d3748;
    font-weight: 600;
    font-size: 1rem;
}

.file-details {
    margin: 0;
    display: flex;
    gap: 1rem;
    color: #718096;
    font-size: 0.875rem;
}

.file-size {
    font-weight: 500;
}

.file-type {
    position: relative;
    padding-left: 1rem;
}

.file-type::before {
    content: '•';
    position: absolute;
    left: 0.5rem;
    color: #cbd5e0;
}

.file-actions {
    flex-shrink: 0;
}

.btn-remove-file {
    width: 30px;
    height: 30px;
    background: #fed7d7;
    border: 1px solid #feb2b2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #e53e3e;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-remove-file:hover {
    background: #e53e3e;
    color: white;
    transform: scale(1.1);
}

/* Enhanced drag over state */
.upload-zone.dragover {
    border-color: #38a169;
    background: linear-gradient(135deg, #f0fff4 0%, #e6fffa 100%);
    transform: scale(1.02);
    box-shadow: 0 8px 25px rgba(56, 161, 105, 0.3);
}

.upload-zone.dragover .upload-zone-icon {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    animation: bounce 1s ease infinite alternate;
}

@keyframes bounce {
    0% { transform: translateY(0); }
    100% { transform: translateY(-5px); }
}

/* Responsive adjustments for validation */
@media (max-width: 768px) {
    .stats-grid-small {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .success-message, .error-message {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .stat-item {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
    
    .file-preview-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .file-details {
        justify-content: center;
    }
}
</style>

<link href="/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.fa.min.js" charset="UTF-8"></script>

<script type="text/javascript" src="assets/JsFiles/manifest.js"></script>

 