<div class="lazy-loader-parent lazy_loader_flight">
    <div class="modal-content-flight">
        <div class="modal-body-flight">
            <div class="icon-container">
                <div class="clock-icon">
                    <div class="clock-face">
                        <div class="clock-hand"></div>
                        <div class="clock-hand-short"></div>
                        <div class="clock-center"></div>
                    </div>
                </div>
            </div>
            <span class="timeout-modal__title">##Endofsearchtime##!</span>
            <p class="timeout-modal__flight">
                به منظور بروزرسانی قیمت ها لطفا جستجوی  خود را از ابتدا انجام دهید.
            </p>
            <div class="parent-modal-final-search">
                <button onclick="BackToHome('{$objHotel->generateResearchAddress()}'); return false" type="button" class="loading_on_click btn btn-research site-bg-main-color">
                    ##Repeatsearch##
                </button>
                <a class="btn btn_back_home" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">##Returntohome##</a>
            </div>
        </div>
    </div>
</div>