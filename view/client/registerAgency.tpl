{load_presentation_object filename="banks" assign="objBanks"}

{assign var="allCities" value=$objFunctions->cityIataList()}
{assign var="bank_list" value=$objBanks->getBankList()}

{assign var="classNameBirthdayCalendar" value="shamsiBirthdayCalendar"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {$classNameBirthdayCalendar="gregorianBirthdayCalendar"}
{/if}


<div class="main-Content-top s-u-passenger-wrapper-change">
    <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
         ##AgencyRegistration##
    </span>
    <div class="panel-default-change site-border-main-color">
        <form class=" s-u-result-item-change" data-toggle="validator" id="agencyAdd" method="post">
            <input type="hidden" name="flag" value="agencyAdd">

            <div class="panel-body-change">

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="text" name="name_fa" value="" placeholder="##Nameagency##">
                </div>



                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="name_En" value="" placeholder="##EnglishName##">
                </div>

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="accountant" value="" placeholder="##Accountants##">
                </div>


                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="text" name="managerName" value="" placeholder="##CEOname##">
                </div>

                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="text" name="managerFamily" value="" placeholder="##CEOfamily##">
                </div>

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="text" name="phone" value="" placeholder=" ##Phone##">
                </div>

                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                    <div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                        <input type="text" name="mobile" value="" placeholder="##Phonenumber##">
                    </div>
                {/if}



                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="fax" value="" placeholder="##Fax##">
                </div>

                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="postal_code" value="" placeholder="##Postalcode##">
                </div>


                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="text" name="email" value="" placeholder="##Email##">
                </div>


                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="birthday" value="" class="{$classNameBirthdayCalendar}" placeholder="##Happybirthday##">
                </div>
                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="staff_number" value="" placeholder="##StaffNumber##">
                </div>
                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="economic_code" value="" placeholder="##EconomicCode##">
                </div>
                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group no-star">
                    <input type="text" name="agency_national_code" value="" placeholder="##AgencyNationalID##">
                </div>



                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="password" name="password" id="password" value="" placeholder="##Password##">
                </div>

                <div class=" s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="password" name="confirmPass" value="" placeholder="##Repeatpassword##">
                </div>

                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                    <div class="s-u-passenger-item  s-u-passenger-item-change select-meliat form-group">
                        <select name="city_iata" class="select2">
                            <option value="" disabled="disabled" selected>##City##</option>
                            {foreach $allCities as $city}
                                <option value="{$city.city_iata}">{$city.city_name}</option>
                            {/foreach}
                        </select>
                    </div>
                {/if}

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group width75">
                    <input type="text" name="address_fa" value="" placeholder="##Address##">
                </div>

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group width75 no-star">
                    <input type="text" name="address_en" value="" placeholder="##EnAddress##">
                </div>

                <div class="s-u-passenger-item  s-u-passenger-item-change form-group width75 no-star">
                    <input type="text" name="aboutAgency" value="" placeholder="##AboutAgency##">
                </div>

                <div class="w-100 mt-4">

                    <h3 class="box-title m-b-0">##Bankaccountdetail##</h3>
                    <hr>

                </div>

                <div class="row">
                    <div class="form-group col-sm-3  ">
                        <label for="bank_data[0][bank_list]" class="control-label">##Namebankwner##</label>
                        <select name="bank_data[0][bank_list]" id="bank_data[0][bank_list]" aria-required="true"
                                class="form-control select2">
                            <option value="">##ChoseOption## ...</option>
                            {foreach $bank_list as $bank}
                                <option value="{$bank.id}">{$bank.title}</option>
                            {/foreach}

                        </select>
                    </div>


                    <div class="col-sm-3 form-group">
                        <label for="bank_data[0][name]" class="control-label">
                            ##NameAccountHolder##
                        </label>
                        <input type="text" class="form-control"
                               name="bank_data[0][name]"
                               id="bank_data[0][name]"
                               value=""/>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="bank_data[0][account_number]" class="control-label">
                            ##AccountNumber##
                        </label>
                        <input type="text" class="dir_l form-control"
                               name="bank_data[0][account_number]"
                               id="bank_data[0][account_number]"
                               value=""/>
                    </div>


                    <div class="col-sm-3 form-group">
                        <label for="bank_data[0][card_number]" class="control-label">
                            ##Cardnumber##
                        </label>
                        <input type="text" class="dir_l input-mask form-control"
                               name="bank_data[0][card_number]"
                               id="bank_data[0][card_number]"
                               placeholder="9999-9999-9999-9999"
                               data-inputmask="'mask':'9999-9999-9999-9999'"
                               value=""/>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="bank_data[0][shaba]" class="control-label">
                            ##Shabanumber##
                        </label>
                        <input type="text" class="dir_l input-mask form-control"
                               name="bank_data[0][shaba]"
                               id="bank_data[0][shaba]"
                               data-inputmask="'mask':'IR99-9999-9999-9999-9999-9999-99'"
                               value=""/>
                    </div>
                </div>

                {*<div class="s-u-passenger-item  s-u-passenger-item-change form-group">
                    <input type="file" name="logo" value="" placeholder="لوگوی آژانس" title="لوگوی آژانس" style="color: transparent;direction: rtl;">
                </div>*}

                {if $smarty.const.SOFTWARE_LANG eq 'fa'}
                    <div class='parent-drop_zone-new-upload-input'>
                        <div class="drop_zone-new-upload-input col-lg-4 col-md-6 col-sm-12 col-12  s-u-passenger-item-change form-group ">
                            <div class="field drop_zone-new-field">
                                <i class="btn-upload-file fa fa-upload"></i>
                                <input type="text" name="logoText" value="" size="40" class="file_input_replacement" placeholder="##Loadingagencylogo##">
                                <input type="file" name="logo" class="file_input_with_replacement">
                            </div>
                        </div>
                        <div class="drop_zone-new-upload-input col-lg-4 col-md-6 col-sm-12 col-12  s-u-passenger-item-change form-group ">
                            <div class="field drop_zone-new-field">
                                <i class="btn-upload-file fa fa-upload"></i>
                                <input type="text" name="licenseText" value="" size="40" class="file_input_replacement" placeholder="##Blicens##">
                                <input type="file" name="license" class="file_input_with_replacement">
                            </div>
                        </div>
                    </div>
                {/if}

{*                   <div class="s-u-passenger-item  s-u-passenger-item-change form-group width33 no-star">*}
{*                       <div class="field">*}
{*                           <i class="btn-upload-file fa fa-upload"></i>*}
{*                           <input type="text" name="newspaperText" value="" size="40" class="file_input_replacement" placeholder="##Loadingofficialnewspaper## (##Adslatestchanges##)">*}
{*                           <input type="file" name="newspaper" class="file_input_with_replacement">*}
{*                       </div>*}
{*                   </div>*}

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopad ">

                    <h4 class='drop_zone-new-titr-uplod'>آپلود مدارک ساین</h4>

                    <div class="drop_zone-new-parent-label">
                        <label for='gallery_files'
                               id="drop_zone"
                               class='drop_zone-new-label d-flex flex-wrap justify-content-center align-items-center  p-5 '
                               ondrop="dropHandler(event , false , false);"
                               ondragover="dragOverHandler(event);">
                            <p>##DropFiles##</p>
                        </label>
                    </div>


                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                        <div class="d-flex flex-wrap form-group gap-5 w-100">
                            <label for="gallery_files" class="control-label d-none">##Selectfile##</label>
                            <input onchange="dropHandler(event , false  , false)" type='file'
                                   class=' d-none'
                                   multiple name='gallery_files[]' id='gallery_files'>

                            <div id='preview-gallery' class='drop_zone-new-parent-gallery'></div>
                        </div>
                    </div>
                </div>

                <div class="drop_zone-new-captcha drop_zone-new-captcha-input-star p-0 s-u-passenger-item-change form-group no-margin">
                    <input type="number" id="signup-captcha2" value="" placeholder="##Securitycode##">
                </div>

                <div class="drop_zone-new-captcha-number p-0 s-u-passenger-item-change form-group no-star no-margin">
                    <a id="captchaRefresh" style="float: left;margin: 0;" href="#" title="refresh image" onclick="reloadCaptcha(); return false"></a>
                    <img id="captchaImage" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/captcha/securimage_show.php?sid={$smarty.const.CAPTCHA_SID}" alt="captcha image" />
                </div>


                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopad ">
                    <div class="s-u-result-item-change direcR no-margin txt12 txtRed s-u-result-item-RulsCheck">
                        <div style="text-align: right">

                            <p class="s-u-result-item-RulsCheck-item">
                                <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck" name="heck_list1" value="" type="checkbox">
                                <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                                    <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##TermsandConditions## </a> ##Paziresh##
                                </label>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="userProfileInfo-btn userProfileInfo-btn-change">
                    <input class="s-u-select-flight-change site-secondary-text-color site-main-button-flat-color" type="submit" value="##Register##">
                </div>

            </div>

            <div class="userProfileInfo-messge passengerAddMessage">
                <div class="userProfileInfo-messge-Success {$objUser->classMessage}" >
                    {$addPassengerResult.result_message}
                </div>

                <div class="userProfileInfo-messge-Error {$objUser->classError}" >
                    {$addPassengerResult.result_message}
                </div>
            </div>


        </form>
    </div>
</div>

{literal}
    <script src="assets/js/dropzone.js"></script>

    <script>
      let added_files=[]
      function setAsSelectedImage(_this,file_name) {
        const selectedImageName = $('input[name="selectedImageName"]')
        const selectedImageRow = $('input[name="selectedImageRow"]')

        $('#previews').find('.btn-actions').each(function(){
          $(this).find('.btn-primary').addClass('btn-outline')
        })
        _this.removeClass('btn-outline')
        selectedImageName.val(file_name)
      }

      $(document).ready(function() {

      })
      $(function(){
        $('.file_input_replacement').click(function(){
          //This will make the element with class file_input_replacement launch the select file dialog.
          var assocInput = $(this).siblings("input[type=file]");
          console.log(assocInput);
          assocInput.click();
        });
        $('.file_input_with_replacement').change(function(){
          //This portion can be used to trigger actions once the file was selected or changed. In this case, if the element triggering the select file dialog is an input, it fills it with the filename
          var thisInput = $(this);
          var assocInput = thisInput.siblings("input.file_input_replacement");
          if (assocInput.length > 0) {
            var filename = (thisInput.val()).replace(/^.*[\\\/]/, '');
            assocInput.val(filename);
          }
        });
      });

    </script>
    <script type="text/javascript" src="assets/js/jquery.inputmask.min.js"></script>

    <script>
      $(document).ready(function () {

        $(".input-mask").inputmask();
      });
    </script>
{/literal}
