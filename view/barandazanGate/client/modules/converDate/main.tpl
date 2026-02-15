
{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/conver-data.css'>
{else}
    <link rel='stylesheet' href='assets/modules/css/conver-data.css'>
{/if}


<section class="section_convertdate py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-12 box-convertdate">
                <div class="clubTitle">
                    <h2>تبدیل تاریخ</h2>
                </div>
                <div class="captin_box">
                    <div class="form__group field">
                        <input value="" type="text" readonly="" class="convertShamsiMiladiCalendar form__field " placeholder="تاریخ شمسی را وارد کنید" name="txtShamsiCalendar" id="txtShamsiCalendar">
                        <button type="button" onclick='convertJalaliToMiladi()' id="shamsiConvertButton" class="form__label btn_abs">
                             تبدیل به میلادی
                        </button>
                    </div>
                    <div class="resultdate" id="showJalaliResult"></div>
                    <div class="form__group field">
                        <input type="text" readonly="" class="convertMiladiShamsiCalendar form__field " placeholder="تاریخ میلادی را وارد کنید" name="txtMiladiCalendar" id="txtMiladiCalendar">
                        <button type="button" onclick='convertMiladiToJalali()' id="miladiConvertButton" class="form__label btn_abs">
                            تبدیل به شمسی
                        </button>
                    </div>
                    <div class="resultdate" id="showMiladiResult"></div>
                </div>
            </div>
            <div class="col-lg-4 col-12 w-100 h-100 d-flex justify-content-end align-items-center icon-convertdate">
                <img src="assets/images/calendar-clock.png" alt="calendar-clock">
            </div>
        </div>
    </div>
</section>


