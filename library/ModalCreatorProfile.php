<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));
/**
 * Class ModalCreatorProfile
 * @property ModalCreatorProfile $ModalCreatorProfile
 */
class ModalCreatorProfile
{

    public $Method;
    public $id;

    public function __construct()
    {
        $Method = $_POST['Method'];
        $passenger_id = $_POST['passenger_id'];
        self::$Method($passenger_id);
    }
    public function yearsPersian() {
        $Year =  dateTimeSetting::jdate("Y",time(),'','','en');
        $arr = array();
        for($i = $Year - 90; $i <= $Year ; $i++) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function monthsPersian($value=null) {
        $month = Array();
        $month[1]='فروردین';
        $month[2]='اردیبهشت';
        $month[3]='خرداد';
        $month[4]='تیر';
        $month[5]='مرداد';
        $month[6]='شهریور';
        $month[7]='مهر';
        $month[8]='آبان';
        $month[9]='آذر';
        $month[10]='دی';
        $month[11]='بهمن';
        $month[12]='اسفند';
        return $month;
    }
    public function yearsMiladi() {
        $Year =  date("Y",time());
        $arr = array();
        for($i = $Year - 90; $i <= $Year ; $i++) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function monthsMiladi() {
        $month = Array();
        $month[1]='January';
        $month[2]='February';
        $month[3]='March';
        $month[4]='April';
        $month[5]='May';
        $month[6]='June';
        $month[7]='July';
        $month[8]='August';
        $month[9]='September';
        $month[10]='October';
        $month[11]='November';
        $month[12]='December';
        return $month;
    }
    public function yearsPersianExpire() {
        $Year =  dateTimeSetting::jdate("Y",time(),'','','en');
        $arr = array();
        for($i = $Year + 10; $Year <= $i ; $i--) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function yearsMiladiExpire() {
        $Year =  date("Y",time());
        $arr = array();
        for($i = $Year + 10; $Year <= $i ; $i--) {
            $arr[] = $i;
        }
        return $arr;
    }
    public function changeMonthIr($data) {
        $index = self::monthsPersian();
        for ($i = 1; $i < count($index)+1; $i++) {
            if ($i < 10) {
                $i = ltrim($i, '0');
            }
            if ($i ==  $data) {
                $result = $index[$i];
            }
        }
        return $result;
    }
    public function changeMonthNoIr($data) {
        $index = self::monthsMiladi();
        for ($i = 1; $i < count($index)+1; $i++) {
            if ($i < 10) {
                $i = ltrim($i, '0');
            }
            if ($i ==  $data) {
                $result = $index[$i];
            }
        }
        return $result;
    }
    public function removeZeroBeginningNumber($data) {
        if ($data < 10) {
            $data = ltrim($data, '0');
        }
        return $data;
    }
    public function getCountryName( $code ) {
        $ModelBase = Load::library( 'ModelBase' );
        $sql       = " SELECT titleFa FROM country_codes_tb WHERE code='" . $code . "' LIMIT 1 ";
        $result = $ModelBase->load( $sql );
        return $result['titleFa'];
    }
    public function ModalShowAdd($passenger_id)
    {

        $condition="id = '".$passenger_id."'";
        $passengerInfo = functions::getValueFields('passengers_tb','*',$condition);


        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
                    <?php echo functions::Xmlinformation("AddNewPassenger"); ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <form id="AddPassengerFormData" action="user_ajax.php" method="post">
                    <div class="userInformation-header">
                      <div class="userInformation-header-gender">
                        <div onclick="formGroupNew('Male')" class="form-groupNew">
                          <input checked="" name="passengerGender" value="Male" type="radio" id="male">
                          <label for="male"><?php echo functions::Xmlinformation("Sir"); ?></label>
                        </div>
                        <div onclick="formGroupNew('Female')" class="form-groupNew">
                          <input name="passengerGender" value="Female" type="radio" id="female">
                          <label for="female"><?php echo functions::Xmlinformation("Lady"); ?></label>
                        </div>
                      </div>
                      <div class="origin">
                        <div class="profile_dropdown_custom">
                          <button type='button'>
                            <span><?php echo functions::Xmlinformation("Iranian"); ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M360.5 217.5l-152 143.1C203.9 365.8 197.9 368 192 368s-11.88-2.188-16.5-6.562L23.5 217.5C13.87 208.3 13.47 193.1 22.56 183.5C31.69 173.8 46.94 173.5 56.5 182.6L192 310.9l135.5-128.4c9.562-9.094 24.75-8.75 33.94 .9375C370.5 193.1 370.1 208.3 360.5 217.5z"/></svg>
                          </button>
                          <div>
                            <div>
                              <button type='button' onclick="dropdown_custom_btn(event.target)" class="IranianSelect active"><?php echo functions::Xmlinformation("Iranian"); ?></button>
                              <button type='button' onclick="dropdown_custom_btn(event.target)" class="NoIranianSelect "><?php echo functions::Xmlinformation("Noiranian"); ?></button>
                              <input type="hidden" name="is_foreign" id="is_foreign" value="0" >
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-profile">
                      <label class="label_style">
                        <span class="d-flex justify-content-between align-items-center w-100"><?php echo functions::Xmlinformation("NameFaProfile"); ?>
                         <span class='star'>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                         </span>
                        </span>
                        <input type="text" name="passengerName" onkeypress=" return checkLetterPersian(event, 'passengerName')"
                               id="passengerName" placeholder="<?php echo functions::Xmlinformation("NameFaProfile"); ?>(<?php echo functions::Xmlinformation("Compulsory"); ?>)">
                      </label>
                      <label class="label_style">
                        <span class="d-flex justify-content-between align-items-center w-100">
                            <?php echo functions::Xmlinformation("FamilyFaProfile"); ?>
                            <span class='star'>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </span>
                        <input name="passengerFamily"  onkeypress=" return checkLetterPersian(event, 'passengerFamily')"
                               id="passengerFamily" type="text" placeholder="<?php echo functions::Xmlinformation("FamilyFaProfile"); ?>">
                      </label>
                      <label class="label_style">
                        <span><?php echo functions::Xmlinformation("NameEnProfile"); ?>
                        </span>
                        <input type="text" name="passengerNameEn" onkeypress="return checkLetterEnglish(event, 'passengerNameEn')"
                               id="passengerNameEn" placeholder="<?php echo functions::Xmlinformation("NameEnProfile"); ?>">
                      </label>
                      <label class="label_style">
                        <span><?php echo functions::Xmlinformation("FamilyEnProfile"); ?></span>
                        <input  type="text"  name="passengerFamilyEn" onkeypress="return checkLetterEnglish(event, 'passengerFamilyEn')"
                                id="passengerFamilyEn" placeholder="<?php echo functions::Xmlinformation("FamilyEnProfile"); ?>">
                      </label>
                      <div class="label_style nationalNumber_label_profile">
                        <span><?php echo functions::Xmlinformation("shamsihappybirthday"); ?></span>
                        <div class="calender_profile">
                          <div>
                            <select id="birth_day_ir" name="birth_day_ir" placeholder="<?php echo functions::Xmlinformation("Day"); ?>" class="select2">
                              <option value='0'>روز</option>
                                <?php
                                for ($day = 1; $day <= 31; $day++) {
                                    echo "<option value='$day'>$day</option>";
                                }
                                ?>
                            </select>
                          </div>

                          <div>
                            <select id="birth_month_ir" name="birth_month_ir" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                              <option value='0'>ماه</option>
                                <?php
                                foreach (self::monthsPersian() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>

                          <div>
                            <select id="birth_year_ir" name="birth_year_ir" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                              <option value='0'>سال</option>
                                <?php
                                foreach (self::yearsPersian() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="label_style country_label_profile">
                        <span><?php echo functions::Xmlinformation("miladihappybirthday"); ?></span>
                        <div class="calender_profile">
                          <div>
                            <select id="birth_day_miladi" name="birth_day_miladi" placeholder="<?php echo functions::Xmlinformation("Day"); ?>" class="select2">
                              <option value='0'>روز</option>
                                <?php
                                for ($day = 1; $day <= 31; $day++) {
                                    echo "<option value='$day'>$day</option>";
                                }
                                ?>
                            </select>
                          </div>

                          <div>
                            <select id="birth_month_miladi" name="birth_month_miladi" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                              <option value='0'>ماه</option>
                                <?php
                                foreach (self::monthsMiladi() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>

                          <div>
                            <select id="birth_year_miladi" name="birth_year_miladi" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                              <option value='0'>سال</option>
                                <?php
                                foreach (self::yearsMiladi() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="label_style country_label_profile">
                        <span><?php echo functions::Xmlinformation("PassportExpiration"); ?> ( <?php echo functions::Xmlinformation("ForeignFlight"); ?> )</span>
                        <div class="calender_profile">
                          <div>
                            <select id="date_passport_expire_day" name="date_passport_expire_day" placeholder="<?php echo functions::Xmlinformation("Day"); ?>" class="select2">
                              <option value='0'>روز</option>
                                <?php
                                for ($day = 1; $day <= 31; $day++) {
                                    echo "<option value='$day'>$day</option>";
                                }
                                ?>
                            </select>
                          </div>

                          <div>
                            <select id="date_passport_expire_month" name="date_passport_expire_month" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                              <option value='0'>ماه</option>
                                <?php
                                foreach (self::monthsMiladi() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>
                          <div>
                            <select id="date_passport_expire_year" name="date_passport_expire_year" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                              <option value='0'>سال</option>
                                <?php
                                foreach (self::yearsMiladiExpire() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="label_style  nationalNumber_label_profile">
                        <span><?php echo functions::Xmlinformation("PassportExpiration"); ?></span>
                        <div class="calender_profile">
                          <div>
                            <select id="date_passport_expire_day_ir" name="date_passport_expire_day_ir" placeholder="<?php echo functions::Xmlinformation("Day"); ?>" class="select2">
                              <option value='0'>روز</option>
                                <?php
                                for ($day = 1; $day <= 31; $day++) {
                                    echo "<option value='$day'>$day</option>";
                                }
                                ?>
                            </select>
                          </div>

                          <div>
                            <select id="date_passport_expire_month_ir" name="date_passport_expire_month_ir" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                              <option value='0'>ماه</option>
                                <?php
                                foreach (self::monthsPersian() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>

                          <div>
                            <select id="date_passport_expire_year_ir" name="date_passport_expire_year_ir" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                              <option value='0'>سال</option>
                                <?php
                                foreach (self::yearsPersianExpire() as $key => $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                                ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <label class="label_style">
                        <span><?php echo functions::Xmlinformation("PassportNumber"); ?></span>
                        <input type="text" name="passportNumber" maxlength='9'
                               id="passportNumber" placeholder="شماره گذرنامه (حداکثر 9 کاراکتر)">
                      </label>
                      <label class="label_style nationalNumber_label_profile">
                        <span class="d-flex justify-content-between align-items-center w-100">
                            <?php echo functions::Xmlinformation("Nationalnumber"); ?>
                            <span class='star'>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                            </span>
                        </span>
                        <input type="text" name="passengerNationalCode"
                               id="passengerNationalCode" placeholder="شماره ملی">
                      </label>
                      <div class="label_style country_label_profile">
                        <span><?php echo functions::Xmlinformation("Countryissuingpassport"); ?></span>
                        <div class="calender_profile calender_profile_grid_1">
                          <div>
                            <select name="ExpirationOfPassport_day_input" placeholder="<?php echo functions::Xmlinformation("Countryissuingpassport"); ?>" class="select2">
                                <?php
                                foreach (functions::CountryCodes() as $Country) {
                                    echo "<option value='{$Country['titleFa']}' data-id=\"{$Country['code']}\">{$Country['titleFa']}</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="passport_country_id" id="passport_country_id" value="<?php echo $passengerInfo['passportCountry']; ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="box_btn mt-4">
                      <button onclick="closeModal()"><?php echo functions::Xmlinformation("Abolish"); ?></button>
                      <button type="submit" class="submitPassengerAddFormData"><?php echo functions::Xmlinformation("Save"); ?></button>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        $(document).ready(function () {



        })
        function formGroupNew(name){
          if (name === "Female"){
            $('#male').prop("checked", false)
            $('#female').prop("checked", true)
          } else if (name === "Male") {
            $('#female').prop("checked", false)
            $('#male').prop("checked", true)
          }
        }
        $('html , body').click(() => {
          $(".profile_dropdown_custom > div").hide()
          $(".list_calender_profile").hide()
        })
        $(".country_label_profile").hide()
        $(".profile_dropdown_custom > div").hide()
        $(".select2").select2();
        $(".profile_dropdown_custom > button").click((event) => {
          $(".profile_dropdown_custom > div").toggle()
          event.stopPropagation()
          return false
        })
        function closeModal(){
          $(".modal_custom").remove();
          $("body,html").removeClass("overflow-hidden");
        }
        function dropdown_custom_btn(e){
          $(".profile_dropdown_custom > button > span").text(e.innerHTML)
          $(".profile_dropdown_custom > div > div > button").removeClass("active");
          $(e).addClass("active");
          if(e.innerHTML === 'غیر ایرانی'){
            $(".country_label_profile").show()
            $(".nationalNumber_label_profile").hide()
            document.getElementById("is_foreign").setAttribute('value','1');
          } else {
            $(".country_label_profile").hide()
            $(".nationalNumber_label_profile").show()
            document.getElementById("is_foreign").setAttribute('value','0');
          }
        }
      </script>

        <?php

    }
    public function ModalShowEdit($passenger_id)
    {

        $condition="id = '".$passenger_id."'";
        $passengerInfo = functions::getValueFields('passengers_tb','*',$condition);
        if (!empty($passengerInfo['birthday_fa'])) {
            $date_birth_ir = explode('-', $passengerInfo['birthday_fa']);
            $passengerInfo['date_year_ir'] = $date_birth_ir[0];
            $passengerInfo['date_month_ir'] = self::changeMonthIr($date_birth_ir[1]);
            $passengerInfo['date_day_ir'] = self::removeZeroBeginningNumber($date_birth_ir[2]);
        }else{
            $passengerInfo['date_year_ir'] = '';
            $passengerInfo['date_month_ir'] = '';
            $passengerInfo['date_day_ir'] = '';
        }
        if (!empty($passengerInfo['birthday']) ) {
            $date_birth_en = explode('-', $passengerInfo['birthday']);
            $passengerInfo['date_year_en'] = $date_birth_en[0];
            $passengerInfo['date_month_en'] = self::changeMonthNoIr($date_birth_en[1]);
            $passengerInfo['date_day_en'] = self::removeZeroBeginningNumber($date_birth_en[2]);
        }else{
            $passengerInfo['date_year_en'] = '';
            $passengerInfo['date_month_en'] = '';
            $passengerInfo['date_day_en'] = '';
        }
        if (!empty($passengerInfo['passportExpire'] )) {
            $date_passport_expire = explode('-', $passengerInfo['passportExpire']);
            $passengerInfo['date_passport_expire_year'] = $date_passport_expire[0];
            $passengerInfo['date_passport_expire_month'] = self::changeMonthNoIr($date_passport_expire[1]);
            $passengerInfo['date_passport_expire_day'] = self::removeZeroBeginningNumber($date_passport_expire[2]);
        }else{
            $passengerInfo['date_passport_expire_year'] = '';
            $passengerInfo['date_passport_expire_month'] = '';
            $passengerInfo['date_passport_expire_day'] = '';
        }
        if (!empty($passengerInfo['passportExpire_ir'] )) {
            $date_passport_expire_ir = explode('-', $passengerInfo['passportExpire_ir']);
            $passengerInfo['date_passport_expire_year_ir'] = $date_passport_expire_ir[0];
            $passengerInfo['date_passport_expire_month_ir'] = self::changeMonthIr($date_passport_expire_ir[1]);
            $passengerInfo['date_passport_expire_day_ir'] = self::removeZeroBeginningNumber($date_passport_expire_ir[2]);
        }else{
            $passengerInfo['date_passport_expire_year_ir'] = '';
            $passengerInfo['date_passport_expire_month_ir'] = '';
            $passengerInfo['date_passport_expire_day_ir'] = '';
        }
        $passengerInfo['country_name'] = self::getCountryName($passengerInfo['passportCountry']);

        ?>
      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom" >
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
                    <?php echo functions::Xmlinformation("ProfileEditTraveler"); ?> <?php echo $passengerInfo['name'] ?> <?php echo $passengerInfo['family'] ?>
                </h2>
                <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">

                    <form id="updatePassengerFormData" action="user_ajax.php" method="post">
                      <input type="hidden" name="passengerId" value="<?php echo $passengerInfo['id']; ?>">
                      <input type="hidden" name="memberID" value="<?php echo $passengerInfo['fk_members_tb_id']; ?>">
                      <div class="userInformation-header">

                        <div class="userInformation-header-gender">
                          <div class="form-groupNew">
                            <input onclick="formGroupNew('Male')" <?php echo($passengerInfo['gender'] == 'Male' ? 'checked=""':''); ?>  name="passengerGender" value="Male" type="radio" id="male">
                            <label for="male"><?php echo functions::Xmlinformation("Sir"); ?></label>
                          </div>
                          <div class="form-groupNew">
                            <input onclick="formGroupNew('Female')" <?php echo($passengerInfo['gender'] == 'Female' ? 'checked=""':''); ?>  name="passengerGender" value="Female" type="radio" id="female">
                            <label for="female"><?php echo functions::Xmlinformation("Lady"); ?></label>
                          </div>
                        </div>
                        <div class="origin">
                          <div class="profile_dropdown_custom">
                            <button type="button">
                                <?php
                                if ($passengerInfo['is_foreign'] == '1')
                                {
                                    echo " <span class='NoIranian'>" ?>
                                    <?php echo functions::Xmlinformation("Noiranian"); ?>
                                    <?php
                                    echo "</span>" ;
                                }else{
                                    echo " <span class='Iranian'>" ?>
                                    <?php echo functions::Xmlinformation("Iranian"); ?>
                                    <?php
                                    echo "</span>" ;
                                }
                                ?>
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M360.5 217.5l-152 143.1C203.9 365.8 197.9 368 192 368s-11.88-2.188-16.5-6.562L23.5 217.5C13.87 208.3 13.47 193.1 22.56 183.5C31.69 173.8 46.94 173.5 56.5 182.6L192 310.9l135.5-128.4c9.562-9.094 24.75-8.75 33.94 .9375C370.5 193.1 370.1 208.3 360.5 217.5z"/></svg>
                            </button>
                            <div>
                              <div>
                                <button type="button"  name="IR" onclick="dropdown_custom_btn(event.target)"  <?php echo($passengerInfo['is_foreign'] == '0' ? 'class="active"':''); ?> >ایرانی</button>
                                <button type="button"  name="NO_IR" onclick="dropdown_custom_btn(event.target)" <?php echo($passengerInfo['is_foreign'] == '1' ? 'class="active"':''); ?>>غیر ایرانی</button>
                                <input type="hidden" name="is_foreign" id="is_foreign" value="<?php echo $passengerInfo['is_foreign']; ?>" >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-profile">
                        <label class="label_style">
                          <span class="d-flex justify-content-between align-items-center w-100"><?php echo functions::Xmlinformation("NameFaProfile"); ?>
                           <span class='star'>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                           </span>
                          </span>
                          <input type="text" name="passengerName"
                                 id="passengerName"
                                 value="<?php echo $passengerInfo['name']; ?>"
                                 placeholder="<?php echo functions::Xmlinformation("Name"); ?>">
                        </label>
                        <label class="label_style">
                          <span class="d-flex justify-content-between align-items-center w-100"><?php echo functions::Xmlinformation("FamilyFaProfile"); ?>
                           <span class='star'>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                           </span>
                          </span>
                          <input type="text" name="passengerFamily" onkeypress=" return persianLetters(event, 'passengerFamily')"
                                 id="passengerFamily"
                                 value="<?php echo $passengerInfo['family']; ?>"
                                 placeholder="<?php echo functions::Xmlinformation("Family"); ?>">
                        </label>
                        <label class="label_style">
                          <span><?php echo functions::Xmlinformation("NameEnProfile"); ?></span>
                          <input type="text" name="passengerNameEn" onkeypress="return isAlfabetKeyFields(event, 'passengerNameEn')"
                                 id="passengerNameEn"
                                 value="<?php echo $passengerInfo['name_en']; ?>"
                                 placeholder="<?php echo functions::Xmlinformation("Nameenglish"); ?>">
                        </label>
                        <label class="label_style">
                          <span><?php echo functions::Xmlinformation("FamilyEnProfile"); ?></span>
                          <input type="text" name="passengerFamilyEn" onkeypress="return isAlfabetKeyFields(event, 'passengerFamilyEn')"
                                 id="passengerFamilyEn"
                                 value="<?php echo $passengerInfo['family_en']; ?>"
                                 placeholder="<?php echo functions::Xmlinformation("Familyenglish"); ?>">
                        </label>

                        <div class="label_style nationalNumber_label_profile">
                          <span><?php echo functions::Xmlinformation("shamsihappybirthday"); ?>  </span>
                          <div class="calender_profile">
                            <div>
                              <select id="birth_day_ir" name="birth_day_ir" placeholder="<?php echo functions::Xmlinformation("Day"); ?>" class="select2">
                                <option value='0'>روز</option>
                                  <?php
                                  for ($day = 1; $day <= 31; $day++) {
                                      echo "<option value=\"$day\"";
                                      if ($passengerInfo['date_day_ir'] == $day)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$day</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>

                            <div>
                              <select id="birth_month_ir" name="birth_month_ir" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                                <option value='0'>ماه</option>
                                  <?php
                                  foreach (self::monthsPersian() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_month_ir'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>

                            <div>
                              <select id="birth_year_ir" name="birth_year_ir" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                                <option value='0'>سال</option>
                                  <?php
                                  foreach (self::yearsPersian() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_year_ir'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="label_style country_label_profile">
                          <span><?php echo functions::Xmlinformation("miladihappybirthday"); ?></span>
                          <div class="calender_profile">
                            <div>
                              <select id="birth_day_miladi" name="birth_day_miladi" placeholder="<?php echo functions::Xmlinformation("Day"); ?>" class="select2">
                                <option value='0'>روز</option>
                                  <?php
                                  for ($day = 1; $day <= 31; $day++) {
                                      echo "<option value=\"$day\"";
                                      if ($passengerInfo['date_day_en'] == $day)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$day</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>
                            <div>
                              <select id="birth_month_miladi" name="birth_month_miladi" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                                <option value='0'>ماه</option>
                                  <?php
                                  foreach (self::monthsMiladi() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_month_en'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>

                            <div>
                              <select id="birth_year_miladi" name="birth_year_miladi" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                                <option value='0'>سال</option>
                                  <?php
                                  foreach (self::yearsMiladi() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_year_en'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="label_style  country_label_profile">
                          <span><?php echo functions::Xmlinformation("PassportExpiration"); ?> ( <?php echo functions::Xmlinformation("ForeignFlight"); ?> )</span>
                          <div class="calender_profile">
                            <div>
                              <select id="date_passport_expire_day" name="date_passport_expire_day" placeholder="<?php echo functions::Xmlinformation("Day"); ?>" class="select2">
                                <option value='0'>روز</option>
                                  <?php
                                  for ($day = 1; $day <= 31; $day++) {
                                      echo "<option value=\"$day\"";
                                      if ($passengerInfo['date_passport_expire_day'] == $day)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$day</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>

                            <div>
                              <select id="date_passport_expire_month" name="date_passport_expire_month" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                                <option value='0'>ماه</option>
                                  <?php
                                  foreach (self::monthsMiladi() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_passport_expire_month'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>

                            <div>
                              <select id="date_passport_expire_year" name="date_passport_expire_year" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                                <option value='0'>سال</option>
                                  <?php
                                  foreach (self::yearsMiladiExpire() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_passport_expire_year'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="label_style nationalNumber_label_profile">
                          <span><?php echo functions::Xmlinformation("PassportExpiration"); ?></span>
                          <div class="calender_profile">
                            <div>
                              <select id="date_passport_expire_day_ir"
                                      name="date_passport_expire_day_ir"
                                      placeholder="<?php echo functions::Xmlinformation("Day"); ?>"
                                      class="select2">
                                <option value='0'>روز</option>
                                  <?php
                                  for ($day = 1; $day <= 31; $day++) {
                                      echo "<option value=\"$day\"";
                                      if ($passengerInfo['date_passport_expire_day_ir'] == $day)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$day</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>
                            <div>
                              <select id="date_passport_expire_month_ir" name="date_passport_expire_month_ir" placeholder="<?php echo functions::Xmlinformation("Month"); ?>" class="select2">
                                <option value='0'>ماه</option>
                                  <?php
                                  foreach (self::monthsPersian() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_passport_expire_month_ir'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>
                            <div>
                              <select id="date_passport_expire_year_ir" name="date_passport_expire_year_ir" placeholder="<?php echo functions::Xmlinformation("Year"); ?>" class="select2">
                                <option value='0'>سال</option>
                                  <?php
                                  foreach (self::yearsPersianExpire() as $key => $value) {
                                      echo "<option value=\"$value\"";
                                      if ($passengerInfo['date_passport_expire_year_ir'] == $value)
                                      {
                                          echo "selected" ;
                                      }
                                      echo ">$value</option>" ;
                                  }
                                  ?>
                              </select>
                            </div>
                          </div>
                        </div>


                        <label class="label_style">
                          <span><?php echo functions::Xmlinformation("PassportNumber"); ?></span>
                          <input type="text"  name="passportNumber" id="passportNumber" maxlength='9'
                                 value="<?php echo $passengerInfo['passportNumber']; ?>"
                                 placeholder="<?php echo functions::Xmlinformation("Numpassport"); ?>">
                        </label>
                        <label class="label_style nationalNumber_label_profile">
                          <span class="d-flex justify-content-between align-items-center w-100">
                              <?php echo functions::Xmlinformation("Nationalnumber"); ?>
                             <span class='star'>
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M476.8 384C472.3 391.7 464.2 396 455.1 396c-4.094 0-8.234-1.031-12.03-3.25L280 297.7V488c0 13.25-10.75 24-24 24s-24-10.75-24-24V297.7l-163.1 95.09C64.25 394.1 60.11 396 56.02 396c-8.266 0-16.33-4.281-20.78-11.97c-6.641-11.47-2.734-26.16 8.719-32.78L208.2 256l-164.2-95.25C32.5 154.1 28.6 139.4 35.24 127.1c6.641-11.5 21.34-15.41 32.81-8.719L232 214.3V24C232 10.75 242.8 0 256 0s24 10.75 24 24v190.3l163.1-95.09c11.48-6.688 26.16-2.781 32.81 8.719c6.641 11.47 2.734 26.16-8.719 32.78L303.8 256l164.2 95.25C479.5 357.9 483.4 372.6 476.8 384z"></path></svg>
                             </span>
                          </span>
                          <input type="text" name="passengerNationalCode"  onkeyup="return checkNumber(event, 'passengerNationalCode')"
                                 id="passengerNationalCode"
                                 value="<?php echo $passengerInfo['NationalCode']; ?>"
                                 placeholder="<?php echo functions::Xmlinformation("NationalCode"); ?>">
                        </label>
                        <div class="label_style country_label_profile">
                          <span><?php echo functions::Xmlinformation("Countryissuingpassport"); ?></span>
                          <div class="calender_profile calender_profile_grid_1">
                            <div>
                              <input value="<?php echo $passengerInfo['country_name']; ?>"
                                     onclick="open_calender(event)"
                                     type="text"
                                     readonly
                                     placeholder="<?php echo functions::Xmlinformation("Countryissuingpassport"); ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/></svg>
                              <div class="list_calender_profile">
                                  <?php
                                  foreach (functions::CountryCodes() as $Country) {
                                      echo "<p  onclick='click_submit(event)' data-id=\"{$Country['code']}\" class=\"PassportCountry\">{$Country['titleFa']}</p>";
                                  }
                                  ?>
                              </div>

                            </div>
                            <input type="hidden" name="passport_country_id" id="passport_country_id" value="<?php echo $passengerInfo['passportCountry']; ?>">

                          </div>
                        </div>
                      </div>

                      <div class="box_btn mt-4">
                        <button type="button" onclick="modalClosePassenger()"><?php echo functions::Xmlinformation("Abolish"); ?></button>
                        <button type="button" class="submitPassengerUpdateFormData"><?php echo functions::Xmlinformation("Save"); ?></button>
                      </div>
                    </form>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        function formGroupNew(name){
          if (name === "Female"){
            $('#male').prop("checked", false)
            $('#female').prop("checked", true)
          } else if (name === "Male") {
            $('#female').prop("checked", false)
            $('#male').prop("checked", true)
          }
        }
        $(document).ready(() => {
          $('html , body').click(() => {
            $(".profile_dropdown_custom > div").hide()
            $(".list_calender_profile").hide()
          })
          if ($(".origin .profile_dropdown_custom .NoIranian").length === 1){
            $(".country_label_profile").show()
            $(".nationalNumber_label_profile").hide()
          }
          if ($(".origin .profile_dropdown_custom .Iranian").length === 1){
            $(".country_label_profile").hide()
            $(".nationalNumber_label_profile").show()
          }
          $(".select2").select2();
          $(".profile_dropdown_custom > button").click((event) => {
            $(".profile_dropdown_custom > div").toggle()
            event.stopPropagation()
            return false
          })
        });

        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
        function dropdown_custom_btn(e){
          $(".profile_dropdown_custom > button > span").text(e.innerHTML)
          $(".profile_dropdown_custom > div > div > button").removeClass("active");
          $(e).addClass("active");
          if(e.innerHTML === 'غیر ایرانی'){
            $(".country_label_profile").show()
            $(".nationalNumber_label_profile").hide()
            document.getElementById("is_foreign").setAttribute('value','1')
          } else {
            $(".country_label_profile").hide()
            $(".nationalNumber_label_profile").show()
            document.getElementById("is_foreign").setAttribute('value','0')
          }
        }
      </script>
        <?php

    }
    public function ModalShowDelete($passenger_id)
    {

        $condition="id = '".$passenger_id."'";
        $passengerInfo = functions::getValueFields('passengers_tb','*',$condition);


        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container col-lg-3">
          <div class="main_modal_custom">
            <h2><?php echo functions::Xmlinformation("ProfileAreYouSure"); ?></h2>
            <div class="box_btn">
              <button class="close_modal_passenger"><?php echo functions::Xmlinformation("Nnoo"); ?></button>
              <form id="PassengerDeleteForm" action="user_ajax.php" method="post">
                <input type="hidden" name="passengerId" value="<?php echo $passengerInfo['id']; ?>">
                <input type="hidden" name="memberID" value="<?php echo $passengerInfo['fk_members_tb_id']; ?>">
                <button type="button" class="PassengerDelete"><?php echo functions::Xmlinformation("Yess"); ?></button>
              </form>
            </div>
          </div>
        </div>
      </div>

        <?php

    }
    public function ModalShowChangePassword($passenger_id)
    {
        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container col-lg-4">
          <div class="main_modal_custom">
            <div class="header_modal_custom w-100">
              <h2>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
                  <?php echo functions::Xmlinformation("ChangePassword"); ?>
              </h2>
              <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
            </div>
            <div class="center_modal_custom">
              <div class="box-style">
                <div class="box-style-padding">
                  <form id="memberChangePassword" action="user_ajax.php" method="post">
                    <div class="form-profile d-flex flex-wrap gap-0 row">
<!--                      <label class="label_style col-12">
                        <span>
                          رمز عبور فعلی
                        <a href=''>ارسال پیامک به شماره همراه</a>
                        </span>
                        <input type="password" name="old_pass"
                               id="old_pass">
                        <i onclick="hide_and_show_pass(event)">
                          <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">&lt;!&ndash;! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. &ndash;&gt;<path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>
                        </i>
                      </label>-->
                      <label class="label_style col-6 pt-4">
                        <span><?php echo functions::Xmlinformation("NewPassword"); ?></span>
                        <input type="password" name="new_pass"
                               id="new_pass">
                        <i onclick="hide_and_show_pass(event)">
                          <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. <path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>-->
                        </i>
                      </label>
                      <label class="label_style col-6 pt-4">
                        <span><?php echo functions::Xmlinformation("RepeatNewPassword"); ?></span>
                        <input type="password" name="con_pass"
                               id="con_pass">
                        <i onclick="hide_and_show_pass(event)">
                          <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>
                        </i>
                      </label>
                    </div>
                    <div class="box_btn mt-4">
                      <button type="button" class="w-100 position-relative submitChangePasswordProfile">
                        <?php echo functions::Xmlinformation("Save"); ?>
                        <div class="bouncing-loader bouncing-loader-none">
                          <div></div>
                          <div></div>
                          <div></div>
                        </div>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        function hide_and_show_pass(e){
          if (e.currentTarget.parentNode.querySelector('input').getAttribute("type") === 'text'){
            e.currentTarget.innerHTML = '<svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>'
            e.currentTarget.parentNode.querySelector('input').setAttribute("type","password")
          } else if(e.currentTarget.parentNode.querySelector('input').getAttribute("type") === 'password'){
            e.currentTarget.innerHTML = '<svg class="eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M160 256C160 185.3 217.3 128 288 128C358.7 128 416 185.3 416 256C416 326.7 358.7 384 288 384C217.3 384 160 326.7 160 256zM288 336C332.2 336 368 300.2 368 256C368 211.8 332.2 176 288 176C287.3 176 286.7 176 285.1 176C287.3 181.1 288 186.5 288 192C288 227.3 259.3 256 224 256C218.5 256 213.1 255.3 208 253.1C208 254.7 208 255.3 208 255.1C208 300.2 243.8 336 288 336L288 336zM95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 80C222.8 80 169.2 109.6 128.1 147.7C89.6 183.5 63.02 225.1 49.44 256C63.02 286 89.6 328.5 128.1 364.3C169.2 402.4 222.8 432 288 432C353.2 432 406.8 402.4 447.9 364.3C486.4 328.5 512.1 286 526.6 256C512.1 225.1 486.4 183.5 447.9 147.7C406.8 109.6 353.2 80 288 80V80z"/></svg>'
            e.currentTarget.parentNode.querySelector('input').setAttribute("type","text")
          }
        }
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php

    }

    public function ModalConvertPoint($point) {
        ?>


        <div class="modal_custom" onclick="closeModalParent(event)">
            <div class="container col-lg-4">
                <div class="main_modal_custom">
                    <div class="header_modal_custom w-100">
                        <h2>
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M447.1 272.2c-8.766-1.562-16.97 4.406-18.42 13.12C415.3 370.3 342.3 432 255.1 432c-49.96 0-95.99-21.56-128.5-56.8l59.88-59.88C191.9 310.8 193.3 303.8 190.8 297.9C188.3 291.9 182.5 288 176 288h-128C39.16 288 32 295.2 32 304v128c0 6.469 3.891 12.31 9.875 14.78C43.86 447.6 45.94 448 48 448c4.156 0 8.25-1.625 11.31-4.688l45.6-45.6C143.3 438.9 197.4 464 256 464c101.1 0 188.3-72.91 205.1-173.3C462.6 281.9 456.7 273.7 447.1 272.2zM64 393.4V320h73.38L64 393.4zM470.1 65.22C468.1 64.41 466.1 64 464 64c-4.156 0-8.25 1.625-11.31 4.688l-45.6 45.6C368.7 73.15 314.6 48 256 48c-102 0-188.3 72.91-205.1 173.3C49.42 230.1 55.3 238.3 64.02 239.8c8.766 1.562 16.97-4.406 18.42-13.12C96.69 141.7 169.7 80 256 80c49.96 0 96.02 21.56 128.6 56.8l-59.88 59.88c-4.578 4.562-5.953 11.47-3.469 17.44C323.7 220.1 329.5 224 336 224h128C472.8 224 480 216.8 480 208v-128C480 73.53 476.1 67.69 470.1 65.22zM448 192h-73.38L448 118.6V192z"/></svg>
                           تبدیل امتیاز به اعتبار خرید
                        </h2>

                        <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
                    </div>
                    <div class="center_modal_custom w-100">
                        <div class="box-style">
                            <div class="box-style-padding">
                                <form id="memberChangePassword" action="user_ajax.php" method="post">
                                    <div class="form-profile d-flex flex-wrap gap-0 row">
                                        <label class="label_style col-12 pt-4">
                                            <span>میزان دلخواه خود برای تبدیل به اعتبار را وارد نمایید</span>
                                            <small style="color:red">
                                              امتیاز فعلی شما : <?php echo $point?>  امتیاز
                                            </small>
                                            <input type="text" name="point_user"  id="point_user">
                                        </label>
                                    </div>
                                    <div class="box_btn mt-4">
                                        <button type="button" class="w-100 convertPointToCredit" <?php if($point == 0) echo 'disabled';?> ><?php echo functions::Xmlinformation("Send"); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }


    public function ModalShowDiscountCode($discount_code) {
        ?>
        <div class="modal_custom" onclick="closeModalParent(event)">
            <div class="container col-lg-4">
                <div class="main_modal_custom">
                    <div class="header_modal_custom w-100">

                        <h2>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
                           دریافت کد تخفیف
                        </h2>

                        <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
                    </div>
                    <div class="center_modal_custom">
                        <div class="box-style">
                            <div class="box-style-padding">
                                <form id="memberChangePassword" action="user_ajax.php" method="post">
                                    <div class="form-profile d-flex flex-wrap gap-0 row">
                                        <label class="label_style col-12 pt-4">
                                            <span>برای کپی کد تخفبف لطفا روی ذکمه زیر کلکی کنید</span>
                                            <button onclick="copyOnClipboard(event , '<?php echo $discount_code; ?>');">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M502.6 70.63l-61.25-61.25C435.4 3.371 427.2 0 418.7 0H255.1c-35.35 0-64 28.66-64 64l.0195 256C192 355.4 220.7 384 256 384h192c35.2 0 64-28.8 64-64V93.25C512 84.77 508.6 76.63 502.6 70.63zM464 320c0 8.836-7.164 16-16 16H255.1c-8.838 0-16-7.164-16-16L239.1 64.13c0-8.836 7.164-16 16-16h128L384 96c0 17.67 14.33 32 32 32h47.1V320zM272 448c0 8.836-7.164 16-16 16H63.1c-8.838 0-16-7.164-16-16L47.98 192.1c0-8.836 7.164-16 16-16H160V128H63.99c-35.35 0-64 28.65-64 64l.0098 256C.002 483.3 28.66 512 64 512h192c35.2 0 64-28.8 64-64v-32h-47.1L272 448z"/></svg>
                                                <span><?php echo $discount_code; ?></span>
                                            </button>
                                        </label>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }


    public function ModalShowSpecialDiscount($type_discount) {
        $discount_controller = Load::controller('servicesDiscount');
        $data_special = [];
        if($type_discount == 'phone'){
            $data_special = $discount_controller->getAllSpecialDiscountByType($type_discount);
            $title = "لیست کد تلفن های دارای تخفیف";
        }else{
            $data_special = $discount_controller->getAllSpecialDiscountByType($type_discount);
            $title="لیست کد ملی های دارای تخفیف";
        }

        ?>
              <div class="modal_custom" onclick="closeModalParent(event)">
              <div class="container">
                <div class="main_modal_custom">
                  <div class="scrollIng_model">
                    <div class="header_modal_custom">
                      <h2><?php echo $title?></h2>
                      <button onclick="closeModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                          <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                          <path
                            d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z" />
                        </svg>
                      </button>
                    </div>
                    <div class="center_modal_custom">
                      <div class="box-style">
                        <div class="box-style-padding">
                          <div class="table-responsive-lg">
                            <table class="min-w-500px table table-bordered">
                              <thead>
                                <tr>
                                  <th>ردیف</th>
                                  <th>دسته بندی</th>
                                  <th>مبلغ</th>
                                  <th>سرویس</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <?php foreach ($data_special as $key=>$item) { ?>
                                  <tr>
                                    <td><?php echo $key+1 ; ?></td>
                                    <td><?php echo $item['pre_code']; ?></td>
                                    <td><?php echo number_format($item['amount']).' '. ($item['type_discount']=='cash') ? 'ریال' : ' درصد' ; ?></td>
                                    <td><?php echo functions::getServiceDiscountGroupTitle($item['service_title']) ; ?></td>
                                  </tr>
                                  <?php } ?>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         <?php
    }
    public function ModalTotalUserReward($member_id) {
        $reward_controller = Load::controller('user');
            $data_reward = $reward_controller->getTotalUserRewards($member_id);
        ?>
      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2><?php echo functions::Xmlinformation("ViewTotalUserMember") ?></h2>
                <button onclick="closeModal()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                      d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z" />
                  </svg>
                </button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div class="table-responsive-lg">
           <?php   if ($data_reward) {  ?>

        <table class="min-w-500px table table-bordered">
                        <thead>
                        <tr>
                          <th>ردیف</th>
                          <th>مبلغ</th>
                          <th>شماره فاکتور</th>
                          <th>پیام</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php foreach ($data_reward as $key=>$item) { ?>
                        <tr>
                          <td><?php echo $key+1 ; ?></td>
                          <td><?php echo number_format($item['amount']); ?></td>
                          <td><?php echo $item['factorNumber']; ?></td>
                          <td><?php echo $item['comment']; ?></td>
                        </tr>
                        <?php } ?>
                        </tr>
                        </tbody>
                      </table>
           <?php }else{ ?>
             <div class='error-modal'>
               <p >نتیجه ای یافت نشد</p>
             </div>
           <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <?php
    }
    public function ModalInvitedUserList($reagent_code) {
        $invited_controller = Load::controller('user');
            $data_invited = $invited_controller->getInvitedUserList($reagent_code);
        ?>
      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container">
          <div class="main_modal_custom">
            <div class="scrollIng_model">
              <div class="header_modal_custom">
                <h2><?php echo functions::Xmlinformation("ViewListInvitedList") ?></h2>
                <button onclick="closeModal()">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path
                      d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z" />
                  </svg>
                </button>
              </div>
              <div class="center_modal_custom">
                <div class="box-style">
                  <div class="box-style-padding">
                    <div class="table-responsive-lg">
                      <?php   if ($data_invited) {  ?>
                      <table class="min-w-500px table table-bordered">
                        <thead>
                        <tr>
                          <th>ردیف</th>
                          <th>نام و نام خانوادگی</th>
                          <th>تاریخ عضویت</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <?php foreach ($data_invited as $key=>$item) { ?>
                        <tr>
                          <td><?php echo $key+1 ; ?></td>
                          <td><?php echo $item['name']; ?> <?php echo $item['family']; ?></td>
                          <td><?php echo functions::ConvertToJalali($item['register_date']); ?></td>
                        </tr>
                        <?php } ?>
                        </tr>
                        </tbody>
                      </table>
                      <?php }else{ ?>
                        <div class='error-modal'>
                          <p >نتیجه ای یافت نشد</p>
                        </div>
                      <?php } ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <?php
    }



    public function ModalShowDecreaseMoney($passenger_id )
    {

        $invited_controller = Load::controller('user');
        $data_invited = $invited_controller->getCreditMember($passenger_id);
        $valid_amount = number_format($data_invited);

        ?>

      <div class="modal_custom" onclick="closeModalParent(event)">
        <div class="container col-lg-4">
          <div class="main_modal_custom">
            <div class="header_modal_custom w-100">
              <h2>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
                فرم برداشت وجه
              </h2>


              <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
            </div>
            <div class="center_modal_custom">
              <div class="box-style">
                <div class="box-style-padding">
                  <p>مبلغ قابل برداشت برای شما : <?php  echo $valid_amount;   ?></p>
                  <form id="memberRequestedMoneyOfCredit" action="user_ajax.php" method="post">
                    <div class="form-profile d-flex flex-wrap gap-0 row">
                      <label class="label_style col-12 pt-4">
                        <span>مقدار برداشتی</span>
                        <input type="text" name="requested_amount" id="requested_amount" value='<?php echo $data_invited;  ?>'>

                      </label>
                      <label class="label_style col-12 pt-4">
                        <span>شماره کارت برای واریز وجه درخواستی</span>
                        <input type="text" name="card_number" id="card_number" value=''>

                      </label>

                    </div>
                    <div class="box_btn mt-4">
                      <button type="button" class="w-100 position-relative submitRequestMoneyUser">
                          <?php echo functions::Xmlinformation("Save"); ?>
                        <div class="bouncing-loader bouncing-loader-none">
                          <div></div>
                          <div></div>
                          <div></div>
                        </div>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
        function hide_and_show_pass(e){
          if (e.currentTarget.parentNode.querySelector('input').getAttribute("type") === 'text'){
            e.currentTarget.innerHTML = '<svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>'
            e.currentTarget.parentNode.querySelector('input').setAttribute("type","password")
          } else if(e.currentTarget.parentNode.querySelector('input').getAttribute("type") === 'password'){
            e.currentTarget.innerHTML = '<svg class="eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M160 256C160 185.3 217.3 128 288 128C358.7 128 416 185.3 416 256C416 326.7 358.7 384 288 384C217.3 384 160 326.7 160 256zM288 336C332.2 336 368 300.2 368 256C368 211.8 332.2 176 288 176C287.3 176 286.7 176 285.1 176C287.3 181.1 288 186.5 288 192C288 227.3 259.3 256 224 256C218.5 256 213.1 255.3 208 253.1C208 254.7 208 255.3 208 255.1C208 300.2 243.8 336 288 336L288 336zM95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 80C222.8 80 169.2 109.6 128.1 147.7C89.6 183.5 63.02 225.1 49.44 256C63.02 286 89.6 328.5 128.1 364.3C169.2 402.4 222.8 432 288 432C353.2 432 406.8 402.4 447.9 364.3C486.4 328.5 512.1 286 526.6 256C512.1 225.1 486.4 183.5 447.9 147.7C406.8 109.6 353.2 80 288 80V80z"/></svg>'
            e.currentTarget.parentNode.querySelector('input').setAttribute("type","text")
          }
        }
        function closeModal(){
          $(".modal_custom").remove()
          $("body,html").removeClass("overflow-hidden");
        }
      </script>

        <?php

    }


}

new ModalCreatorProfile();
?>