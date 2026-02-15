{load_presentation_object filename="mainCity" assign="objCity"}
{load_presentation_object filename="employmentMilitary" assign="objMilitary"}
{load_presentation_object filename="employmentEducationalCertificate" assign="objEmploymentEducationalCertificate"}
{load_presentation_object filename="employmentRequestedJob" assign="objemploymentRequestedJob"}
{assign var="classNameBirthdayCalendar" value="shamsiBirthdayCalendar"}
{if $smarty.const.SOFTWARE_LANG neq 'fa'}
    {$classNameBirthdayCalendar="gregorianBirthdayCalendar"}
{/if}
<section class="title-form">
    <img src="assets/images/How%20to%20sell%20your%20web%20design%20business%20for%20top%20dollar.jpg" alt="img">
    <div class="container">
        <h2> ##CooperationRequestForm## {$smarty.const.CLIENT_NAME}</h2>
        <svg class="title-sum" version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2677.000000 186.000000" preserveAspectRatio="xMidYMid meet">
            <g transform="translate(0.000000,186.000000) scale(0.100000,-0.100000)" stroke="none">
                <path d="M18275 1689 c-1865 -8 -3306 -27 -4740 -64 -544 -13 -1285 -32 -1645 -40 -360 -8 -1224 -38 -1920 -65 -696 -27 -1384 -54 -1530 -60 -473 -18 -706 -30 -1975 -100 -687 -38 -1421 -79 -1630 -90 -209 -11 -445 -25 -525 -30 -185 -13 -3173 -267 -3300 -281 -321 -34 -792 -91 -832 -100 -62 -14 -131 -74 -153 -134 -25 -65 -17 -150 21 -211 37 -59 114 -106 176 -106 24 1 225 21 448 46 494 55 560 61 2040 186 652 56 1228 105 1280 111 52 5 869 52 1815 104 946 52 1752 97 1790 100 39 3 426 19 860 35 435 17 1200 46 1700 65 1242 48 4063 112 5740 130 737 8 2006 15 2819 15 l1480 0 1365 -40 c1161 -34 1500 -48 2256 -90 1719 -96 2482 -149 2620 -180 70 -16 136 -11 190 14 140 65 186 235 98 367 -41 62 -98 93 -215 118 -288 59 -1221 124 -3028 211 -707 34 -703 34 -1800 61 -443 11 -967 24 -1165 29 -198 5 -414 9 -480 8 -66 -1 -858 -5 -1760 -9z"></path>
            </g>
        </svg>
    </div>
</section>
<section class="employment-form position-relative">
    <div class="">
        <div class="parent-employment-form">
            <div class="parent-form">
                <form id="reserve-employment" enctype="multipart/form-data"  >
                    <div class="box-data-family">
                        <div class="title-Internal">
                            <svg class="svg-title svg-title-2" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                                <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                                <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                            </svg>
                            <h5>##PersonalInformation##</h5>
                        </div>
                        <div class="parent-form-private">
                            <div class="item-input">
                                <label for="employment-name">##Namefamily##</label>
                                <input type="text" name="employment-name"  id="employment-name" placeholder="##Namefamily##...">
                                <i class="fa-light fa-user icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="employment-birth">##DateOfBirth##</label>
                                <input type="text" name="employment-birth"  id="employment-birth" class="{$classNameBirthdayCalendar}" autocomplete="off" placeholder="##DateOfBirth##...">
                                <i class="fa-light fa-calendar-days icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label>##Gender##</label>
                                <select class="select2" name="employment-gender" id="employment-gender">
                                    <option value="" disabled selected>
                                        ##GenderSelect##
                                    </option>
                                    <option value="1">
                                        ##Sir##
                                    </option>
                                    <option value="2">
                                        ##Lady##
                                    </option>
                                </select>
                            </div>
                            <div class="item-input army">
                                <label>##StatusOfDutySystem##</label>
                                <select class="select2" name="employment-military" id="employment-military">
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    {foreach $objMilitary->getEmploymentMilitaries() as $key=>$military}
                                        <option value="{$military['id']}">
                                            {$military['title']}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="item-input diamond">
                                <label>##Maritalstatus##</label>
                                <select class="select2" name="employment-married" id="employment-married">
                                    <option value="" disabled selected>

                                        ##ChoseOption##
                                    </option>
                                    <option value="1">
                                        ##Single##
                                    </option>
                                    <option value="2">
                                        ##Married##
                                    </option>
                                </select>
                            </div>
                            <div class="item-input">
                                <label for="employment-major">##FieldOfStudy##</label>
                                <input type="text" name="employment-major"  id="employment-major" placeholder="##YourMajor##">
                                <i class="fa-light fa-book-open-cover icon-input-item"></i>
                            </div>
                            <div class="item-input evidence">
                                <label>##LastDegree##</label>
                                <select class="select2" name="employment-last_educational_certificate" id="employment-last_educational_certificate">
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    {foreach $objEmploymentEducationalCertificate->getEmploymentEducationalCertificates() as $key=>$value}
                                        <option value="{$value['id']}">
                                            {$value['title']}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="item-input">
                                <label for="employment-email">##Email##</label>
                                <input type="text" name="employment-email" id="employment-email" placeholder="example@site.com">
                                <i class="fa-light fa-envelope icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="employment-mobile">##Mobile##</label>
                                <input type="text" name="employment-mobile"  id="employment-mobile" placeholder="##YourMobileNumber##">
                                <i class="fa-light fa-mobile icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="employment-phone">##Callphone##</label>
                                <input type="text" name="employment-phone" id="employment-phone" placeholder="##YourLandlineNumber##">
                                <i class="fa-light fa-phone-rotary icon-input-item"></i>
                            </div>
                            <div class="item-input state">
                                <label>##State##</label>
                                <select class="select2" name="employment-city" id="employment-city">
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    {foreach $objCity->getCityAll() as $key => $city}
                                        <option value="{$city['id']}">
                                            ##State## {$city['name']}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="item-input">
                                <label for="address">##Address##</label>
                                <input type="text" name="employment-address"  id="employment-address" placeholder="##YourResidentialAddress##">
                                <i class="fa-regular fa-location-dot icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label>##RequestedJob##</label>
                                <select class="select2" name="employment-requested_job" id="employment-requested_job">
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    {foreach $objemploymentRequestedJob->listRequestedJobs() as $key => $job}
                                        <option value="{$job['id']}">
                                            {$job['title']}
                                        </option>
                                    {/foreach}
                                </select>
                            </div>


                            <div class="item-input">
                                <label for="request-rights">##RequestedRights##</label>
                                <input type="text" name="employment-requested_salary" id="employment-requested_salary" placeholder="##YourRights##">
                                <i class="fa-light fa-coins icon-input-item"></i>
                            </div>
                            <div id="myDiv">
                                <span for="request-rights">##CollaborationType##</span>
                                <label class="radio">
                                    <input type="checkbox" id="radio1" name="radio1" value='1' checked>
                                    <span>##FullTime##</span>
                                </label>
                                <label class="radio">
                                    <input type="checkbox" id="radio2" name="radio1" value='2'>
                                    <span>##PartTime##</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-job duplicate-form1 ">
                        <div class="title-Internal d-flex align-items-center justify-content-between">
                            <h5>##JobRecords##</h5>
                            <svg class="svg-title" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                                <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                                <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                            </svg>
                            <button class="plus-btn plus-1-old plus1" type="button">##AddNew##</button>
                        </div>
                        <div class="parent-form-job duplicate-lang1 myform1">
                            <!--  <i class="fa-regular fa-xmark-large delete-item"></i>-->
                            <div class="item-input">
                                <label for="name-job">##ProfessionTitle##</label>
                                <input type="text" name="experience[company_post][]" id="experience_company_name" class="form-empty"  placeholder="##YourJobTitle##">
                                <i class="fa-light fa-user icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="company">##CompanyNameYou##</label>
                                <input type="text" name="experience[company_name][]" id="experience_company_name" class="form-empty"  placeholder="##CompanyNameYou##...">
                                <i class="fa-light fa-building icon-input-item icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="company-number">##CompanyPhone##</label>
                                <input type="text" name="experience[company_tell][]"  id="experience_company_tell" class="form-empty"  placeholder="##Callphone##...">
                                <i class="fa-light fa-phone-rotary icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="company-day">##DurationOfEmployment##</label>
                                <input type="text" name="experience[employment_period][]" id="experience_employment_period" class="form-empty" placeholder="مدت زمان همکاری شما...">
                                <i class="fa-light fa-calendar-days icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="company-price">##Receivables##</label>
                                <input type="text" name="experience[receive_salary][]" id="experience_receive_salary" class="form-empty" placeholder="##YourRights##...">
                                <i class="fa-light fa-coins icon-input-item"></i>
                            </div>
                            <div class="item-input minus1">
                                <label for="company-left">##ReasonForWithdrawal##</label>
                                <input type="text" name="experience[reason_left][]"  id="experience_reason_left" class="form-empty" placeholder="##ReasonForWithdrawal##...">
                                <i class="fa-light fa-face-sad-tear icon-input-item"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-professional duplicate-form2 ">
                        <div class="title-Internal d-flex align-items-center justify-content-between">
                            <h5>##OtherSkills##</h5>
                            <svg class="svg-title" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                                <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                                <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                            </svg>
                            <button class="plus-btn plus-2 plus2" type="button">##AddNew##</button>
                        </div>
                        <div class="parent-form-professional duplicate-lang2 myform2">
                            <!--<i class="fa-regular fa-xmark-large delete-item"></i>-->
                            <div class="item-input">
                                <label for="name-professional">##SkillName##</label>
                                <input type="text" name="skills[skill_name][]" class="form-empty" id="skills_skill_name" placeholder="##SkillName##...">
                                <i class="fa-sharp fa-light fa-brain-circuit icon-input-item"></i>
                            </div>
                            <div class="item-input ability minus2 ">
                                <label>##AbilityLevel##</label>
                                <select class="select2" name="skills[ability_level][]" >
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    <option value="1">
                                        ##Weak##
                                    </option>
                                    <option value="2">
                                        ##Average##
                                    </option>
                                    <option value="3">
                                        ##OK##
                                    </option>
                                    <option value="4">
                                        ##Great##
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-education duplicate-form3">
                        <div class="title-Internal d-flex align-items-center justify-content-between">
                            <h5>##EducationalRecords##</h5>
                            <svg class="svg-title" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                                <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                                <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                            </svg>
                            <button class="plus-btn plus-3 plus3" type="button">##AddNew##</button>
                        </div>
                        <div class="parent-form-education duplicate-lang3 myform3">
                            <!--                                <i class="fa-regular fa-xmark-large delete-item"></i>-->
                            <div class="item-input">
                                <label for="education-1">##Section##</label>
                                <input type="text"  name="education[educational_cross][]" class="form-empty" placeholder="##YourDegree##">
                                <i class="fa-light fa-book-open-cover icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="education-2">##String##</label>
                                <input type="text"  name="education[educational_field][]" class="form-empty" placeholder="##YourMajor##">
                                <i class="fa-light fa-book-open-cover icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="education-3">##InstitutionName##</label>
                                <input type="text"  name="education[educational_name_institution][]" class="form-empty" placeholder="##InstitutionName##...">
                                <i class="fa-light fa-building-columns icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="education-4">##InstitutionLocation##</label>
                                <input type="text"  name="education[educational_institute_location][]" class="form-empty" placeholder="##InstitutionLocation##...">
                                <i class="fa-regular fa-location-dot icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="education-5">##StartDate##</label>
                                <input type="text"  name="education[educational_start_date][]"   class="{$classNameBirthdayCalendar} form-empty employment-date" placeholder="##StartDateOn##">
                                <i class="fa-light fa-calendar-days icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="education-6">##TerminationDate##</label>
                                <input type="text"  name="education[educational_end_date][]"     class="{$classNameBirthdayCalendar} form-empty employment-date" placeholder="##TerminationDate##...">
                                <i class="fa-light fa-calendar-days icon-input-item"></i>
                            </div>
                            <div class="item-input">
                                <label for="education-7">##Rate##</label>
                                <input type="text"  name="education[average][]" placeholder="##Rate##..." class="form-empty">
                                <i class="fa-light fa-star icon-input-item"></i>
                            </div>
                            <div class="item-input minus3">
                                <label for="education-8">##DissertationTitle##</label>
                                <input type="text"  name="education[project_title][]" placeholder="##DissertationTitle##..." class="form-empty">
                                <i class="fa-light fa-book-open-cover icon-input-item"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-language duplicate-form4">
                        <div class="title-Internal d-flex align-items-center justify-content-between">
                            <h5>##ForeignLanguages##</h5>
                            <svg class="svg-title" width="37" height="34" viewBox="0 0 37 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="24" r="10" fill="currentColor"></circle>
                                <circle cx="30" cy="13" r="7" fill="currentColor" fill-opacity="0.4"></circle>
                                <circle cx="15" cy="4" r="4" fill="currentColor" fill-opacity="0.7"></circle>
                            </svg>
                            <button class="plus-btn plus-4 plus4" type="button">##AddNew##</button>
                        </div>
                        <div class="parent-form-language duplicate-lang4 myform4">
                            <!-- <i class="fa-regular fa-xmark-large delete-item"></i>-->
                            <div class="item-input">
                                <label for="language">##Language##</label>
                                <input type="text"  id="language" name="languages[language_name][]" class="form-empty" placeholder="##EnterYourLanguage##">
                                <i class="fa-sharp fa-light fa-globe icon-input-item"></i>
                            </div>
                            <div class="item-input ability">
                                <label>##Call_skills_surface##</label>
                                <select class="select2" name="languages[language_conversational_skill_level][]" >
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    <option value="1">
                                        ##Weak##
                                    </option>
                                    <option value="2">
                                        ##Average##
                                    </option>
                                    <option value="3">
                                        ##OK##
                                    </option>
                                    <option value="4">
                                        ##Great##
                                    </option>
                                </select>
                            </div>
                            <div class="item-input ability">
                                <label>##Office_skills_deck##</label>
                                <select class="select2" name="languages[language_correspondence_skill_level][]" >
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    <option value="1">
                                        ##Weak##
                                    </option>
                                    <option value="2">
                                        ##Average##
                                    </option>
                                    <option value="3">
                                        ##OK##
                                    </option>
                                    <option value="4">
                                        ##Great##
                                    </option>
                                </select>
                            </div>
                            <div class="item-input ability" >
                                <label>##Translation_Skills_Deck##</label>
                                <select class="select2"  name="languages[language_translation_skill_level][]">
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    <option value="1">
                                        ##Weak##
                                    </option>
                                    <option value="2">
                                        ##Average##
                                    </option>
                                    <option value="3">
                                        ##OK##
                                    </option>
                                    <option value="4">
                                        ##Great##
                                    </option>
                                </select>
                            </div>
                            <div class="item-input lamp minus4">
                                <label>##HaveACertificate##</label>
                                <select class="select2" name="languages[language_certified][]" >
                                    <option value="" disabled selected>
                                        ##ChoseOption##
                                    </option>
                                    <option value="1">
                                        ##Yess##
                                    </option>
                                    <option value="2">
                                        ##Nnoo##
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="btn-send">
                        <button type="submit" id="employmentButton" >##Sendinformation##</button>
                    </div>
                </form>
            </div>
            <div class="col-img">
                <div class="parent-img">
                    <img src="assets/images//2.png" alt="img">
                </div>
            </div>
        </div>
    </div>
</section>

{literal}
    <script src="assets/modules/js/employment.js"></script>

{/literal}


