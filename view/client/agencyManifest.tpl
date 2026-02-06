{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="manifestController" assign="objManifestController"}
{assign var='checkAccessService' value=$objAgency->checkAccessSubAgency()}

{if $objSession->IsLogin() && $smarty.session.typeUser eq 'agency' && $smarty.session.AgencyId gt 0}
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`agencyMenu.tpl"}
    {assign var="profile" value=$objAgency->getAgency($objSession->getAgencyId())}
    
    {* Get accessible flights data for dropdowns *}
    {assign var="accessibleDates" value=$objManifestController->getAgencyAccessibleDates($objSession->getAgencyId())}
    {assign var="accessibleRoutes" value=$objManifestController->getAgencyAccessibleRoutes($objSession->getAgencyId())}
    {assign var="accessibleAirlines" value=$objManifestController->getAgencyAccessibleAirlines($objSession->getAgencyId())}
    <div class="container">
        <!-- Page Header -->
        

        <!-- Main Content Row -->
        <div class="row mt-4">
            <!-- Upload Form Column -->
            <div class="col-lg-12 col-md-12">
                <div class="agency-upload-card ">
                   

                    <div class="card-body-agency">
                        <form id="uploadManifestForm" data-toggle="validator" method="post" enctype="multipart/form-data">
                            <input type='hidden' value='uploadManifest' id='method' name='method'>
                            <input type='hidden' value='manifestController' id='className' name='className'>

                            <!-- Flight Information Section -->
                            <div class="form-section-agency">
                                <h5 class="section-title-agency">
                                    <i class="fa fa-plane"></i>
                                    اطلاعات پرواز
                                </h5>

                                {if empty($accessibleDates)}
                                    <div class="alert alert-warning" role="alert">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        <strong>هیچ پروازی برای آپلود مانیفست در دسترس نیست.</strong><br>
                                        لطفاً با مدیر سیستم تماس بگیرید تا پروازهای مورد نیاز را برای شما فعال کند.
                                    </div>
                                {else}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group-agency">
                                                <label for="manifest_date" class="form-label-agency">
                                                    <i class="fa fa-calendar-alt"></i>
                                                    تاریخ پرواز
                                                </label>
                                                <select class="form-control-agency" name="manifest_date" id="manifest_date" required>
                                                    <option value="">انتخاب تاریخ پرواز</option>
                                                    {foreach from=$accessibleDates item=date}
                                                        <option value="{$date.value}"
                                                                {if $date.status == '(کنسلی)'}disabled style="color:red;"{/if}>
                                                            {$date.label} {$date.status}
                                                        </option>
                                                    {/foreach}
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group-agency">
                                                <label for="route" class="form-label-agency">
                                                    <i class="fa fa-route"></i>
                                                    مسیر پرواز
                                                </label>
                                                <select class="form-control-agency" name="route" id="route" required disabled>
                                                    <option value="">ابتدا تاریخ را انتخاب کنید</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group-agency">
                                                <label for="airline_iata" class="form-label-agency">
                                                    <i class="fa fa-tag"></i>
                                                    ایرلاین و کلاس پرواز
                                                </label>
                                                <select class="form-control-agency" name="airline_iata" id="airline_iata" required disabled>
                                                    <option value="">ابتدا مسیر را انتخاب کنید</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                {/if}
                            </div>

                            <!-- File Upload Section -->
                            <div class="form-section-agency" {if empty($accessibleDates)}style="opacity: 0.5; pointer-events: none;"{/if}>
                                <div class="upload-zone-agency-container">
                                    <label for='manifest_file' id="drop_zone" class='upload-zone-agency'
                                           ondrop="dropHandlerUploadManifest(event);"
                                           ondragover="dragOverHandlerUploadManifest(event);"
                                           ondragleave="dragLeaveHandlerUploadManifest(event);"
                                           onclick="chooseUploadType(event)">
                                        <div class="upload-zone-content-agency">
                                            <div class="upload-zone-icon-agency">
                                                <i class="fa fa-cloud-upload-alt"></i>
                                            </div>
                                            <h6 class="upload-zone-title-agency">فایل مورد نظر را اینجا بکشید یا کلیک کنید</h6>
                                            <p class="upload-zone-subtitle-agency">فرمت: TXT | حداکثر: 10MB</p>
                                        </div>
                                    </label>

                                    <input type='file' class='d-none' name='manifest_file' id='manifest_file' accept=".txt" required>
                                    <div id='preview-gallery' class='upload-preview-agency'></div>
                                </div>
                            </div>

                            <!-- Validation Results -->
                            <div id="validation-results" class="validation-section-agency" style="display: none;">
                                <div class="validation-header-agency">
                                    <h6 class="validation-title-agency">
                                        <i class="fa fa-check-circle"></i>
                                        نتایج بررسی فایل
                                    </h6>
                                </div>
                                <div id="validation-content" class="validation-content-agency">
                                    <!-- Results will be populated here -->
                                </div>
                            </div>

                            <!-- Submit Section -->
                            <div class="submit-section-agency">
                                <button class="btn-upload-agency" type="submit" id='uploadButton' 
                                        {if empty($accessibleDates)}disabled{/if}>
                                    <i class="fa fa-upload"></i>
                                    <span class="btn-text">آپلود و پردازش مانیفست</span>
                                    <div class="btn-loading" style="display: none;">
                                        <i class="fa fa-spinner fa-spin"></i>
                                        در حال پردازش...
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- پنجره انتخاب نوع آپلود -->
        <div id="uploadTypeModal" class="upload-type-modal" style="display:none;">
            <div class="upload-type-content">
                <h5>کدام گزینه را آپلود می‌کنید؟</h5>
                <div class="upload-type-buttons">
                    <button type="button" onclick="selectUploadType('راویس')">راویس</button>
                    <button type="button" onclick="selectUploadType('مقیم')">مقیم</button>
                    <button type="button" onclick="selectUploadType('سپهر')">سپهر</button>
                </div>
                <button class="upload-type-cancel" onclick="closeUploadTypeModal()">انصراف</button>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="assets/js/manifest.js"></script>
    <link rel="stylesheet" href="assets/css/manifestUpload.css">
{else}
    {$objFunctions->redirectOutAgency()}
{/if}

