<div class="tab-pane show active" id="flight" role="tabpanel" aria-labelledby="flight-tab">


    <div class="radios">
        <div class="switch">

            <input autocomplete="off" type="radio" class="switch-input" name="flight_switch" value="1"
                   id="fdakheli">
            <label for="fdakheli" class="switch-label switch-label-on">##Internal##</label>
            <input autocomplete="off" type="radio" class="switch-input" name="flight_switch" value="2"
                   id="fkharegi">
            <label checked for="fkharegi" class="switch-label switch-label-off">##Foreign## </label>


            <span class="switch-selection site-bg-main-color"></span>
        </div>
    </div>

    <div id="flight_dakheli" class="row ">

        <form class="d_contents">

            <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">

                <div class="cntr">

                    <label for="fd_rb1" class="btn-radio">

                        <input autocomplete="off" checked="" type="radio" id="fd_rb1" name="fd_rb"
                               value="1"
                               class="" onclick="removeMultiple('fd_rb2')">
                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                            <circle class="site-svg-path-color" cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                  class="inner site-svg-path-color"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                  class="outer site-svg-path-color"></path>
                        </svg>
                        <span>##Oneway## </span>
                    </label>

                    <label for="fd_rb2" class="btn-radio">

                        <input  type="radio" id="fd_rb2" name="fd_rb" value="2"
                                class="multiWays "  onclick="createMultiple('fd_rb2')">
                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                            <circle class="site-svg-path-color" cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                  class="inner site-svg-path-color"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                  class="outer site-svg-path-color"></path>
                        </svg>
                        <span>##Twoway## </span>
                    </label>

                </div>

            </div>

            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">

                    <select data-placeholder=" ##Selectsource## "
                            name="origin"
                            id="origin_local" onchange="select_Airport('{$smarty.const.SOFTWARE_LANG}')"
                            class="select2">
                        <option value="">##ChoseOption##...</option>
                        {foreach $departures as $departure}
                            <option value="{$departure['Departure_Code']}">{$departure[$objFunctions->changeFieldNameByLanguage('Departure_City')]} ({$departure['Departure_Code']})</option>
                        {/foreach}


                    </select>
                </div>
            </div>


            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                <div class="form-group">
                    <select data-placeholder="##Selectdestination## " name="destination"
                            id="destination_local"
                            class="select2">

                    </select>
                </div>
            </div>


            <div class="col-lg-4 col-md-5 col-sm-6 col-12 col_search date_search">
                <div class="form-group">
                    <input readonly type="text"
                           class="{$DeptDatePickerClass} form-control went open_return_date_js"
                           name="dept_date_local" id="dept_date_local" placeholder="##Datetravelwent##">
                </div>
                <div class="form-group">
                    <input autocomplete="off" readonly disabled name="dept_date_local_return"
                           id="dept_date_local_return"
                           type="text"
                           class="checktest {$ReturnDatePickerClass} form-control return_input "
                           placeholder="##Datewentback##">
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
                <div class="select inp-s-num adt box-of-count-nafar">
                    <input type="hidden" class="l-bozorgsal"
                           name="gds_adults_no_local" id="qtyf1"
                           value="1">
                    <input type="hidden"
                           class="l-kodak" name="gds_childs_no_local"
                           id="qtyf2">
                    <input type="hidden" class="l-nozad"
                           name="gds_infants_no_local"
                           id="qtyf3">
                    <div class="box-of-count-nafar-boxes">

                                    <span class="text-count-nafar">
                                        ##Countpassengers##
                                    </span>
                        <span class="fas fa-caret-down down-count-nafar site-color-main-color-before"></span>

                    </div>
                    <div class="cbox-count-nafar">
                        <div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-nafar">
                                        <h6> ##Adult## </h6> (12 ##yearsandup##)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-nafar"><i
                                                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
                                        <i class="number-count counting-of-count-nafar"
                                           data-number="1" data-min="1"
                                           data-value="l-bozorgsal"
                                           id="bozorgsal">1</i>
                                        <i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 cbox-count-nafar-ch koodak-num">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-nafar">
                                        <h6> ##Child## </h6>(##Children12Years##)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-nafar"><i
                                                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
                                        <i class="number-count counting-of-count-nafar"
                                           data-number="0" data-min="0"
                                           data-value="l-kodak">0</i>
                                        <i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 cbox-count-nafar-ch nozad-num">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-nafar">
                                        <h6> ##Baby## </h6>(##Young2Years##)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-nafar"><i
                                                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
                                        <i class="number-count counting-of-count-nafar"
                                           data-number="0" data-min="0"
                                           data-value="l-nozad">0</i>
                                        <i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="div_btn">

                            <span class="btn btn-close site-bg-main-color ">##Closing##</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                <button type="button" onclick="submitLocalSide('local')"
                        class="btn theme-btn seub-btn b-0 site-bg-main-color">
                                    <span>
                                    ##Search##
                                </span>
                </button>
            </div>

        </form>

    </div>


    <div id="flight_khareji" class="row  ">
        <form class="d_contents"  id="gds_portal" name="gds_portal">
            <div class="col-md-12 col-xs-12 col-sm-12 d-ceckboxs">
                <div class="cntr">
                    <label for="fk_rb1" class="btn-radio">
                        <input autocomplete="off" checked="" class="multiselectportal" type="radio"
                               id="fk_rb1" name="fk_rb"
                               value="1" onclick="removeMultiple('fd_rb2')">
                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                            <circle class="site-svg-path-color" cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                  class="inner site-svg-path-color"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                  class="outer site-svg-path-color"></path>
                        </svg>
                        <span>##Oneway## </span>
                    </label>

                    <label for="fk_rb2" class="btn-radio">

                        <input autocomplete="off" type="radio" class="multiWays multiselectportal" id="fk_rb2"
                               name="fk_rb"
                               value="2" onclick="createMultiple('fk_rb2')" >
                        <svg width="20px" height="20px" viewBox="0 0 20 20">
                            <circle class="site-svg-path-color" cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
                                  class="inner site-svg-path-color"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
                                  class="outer site-svg-path-color"></path>
                        </svg>
                        <span>##Twoway##</span>
                    </label>

                </div>


            </div>

            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
                <div class="form-group">
                                <span class="origin_start ">
                                       <input id="OriginPortal" class=" form-control inputSearchForeign" type="text"
                                              lang="{$smarty.const.SOFTWARE_LANG}"
                                              name="origin"  placeholder="##Origin##">

                            </span>
                    <img src="assets/images/load.gif" id="LoaderForeignDep" name="LoaderForeignDep"
                         class="loaderSearch">
                    <input id="origin_foreign" class="" type="hidden" value=""
                           name="origin_foreign">
                    <ul id="ListAirPort" class="resultFlight_international" style="display: none">
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col">
                <div class="form-group">
                                 <span class="destnition_start">
                                    <input id="DestinationPortal" class=" form-control inputSearchForeign" type="text"
                                           value=""
                                           placeholder="##Destination##"
                                           name="destination" lang="{$smarty.const.SOFTWARE_LANG}">
                                </span>

                    <img src="assets/images/load.gif" id="LoaderForeignReturn" name="LoaderForeignReturn"
                         class="loaderSearch">
                    <input id="destination_foreign" class="" type="hidden" value=""
                           name="destination_foreign">
                    <ul id="ListAirPortRetrun" class="resultFlight_international" style="display: none">
                    </ul>
                </div>
            </div>


            <div class="col-lg-4 col-md-5 col-sm-6 col-12 col_search date_search">
                <div class="form-group">
                    <input readonly type="text" class="checktest1 {$DeptDatePickerClass} form-control went "
                           name="dept_date_foreign"
                           id="dept_date_foreign" placeholder="##Datetravelwent##">
                </div>
                <div class="form-group">
                    <input autocomplete="off" readonly disabled type="text"
                           name="dept_date_foreign_return"
                           id="dept_date_foreign_return"
                           class="form-control return_input2 checktest1 {$ReturnDatePickerClass}"
                           placeholder="##Datewentback##">
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 col-12 col_search">
                <div class="select inp-s-num adt box-of-count-nafar">
                    <input type="hidden" class="l-bozorgsal-2"
                           name="gds_infants_no_portal" id="qty1" value="1">
                    <input type="hidden" class="l-kodak-2"
                           name="gds_childs_no_portal" id="qty2">
                    <input type="hidden" class="l-nozad-2"
                           name="gds_infants_no_portal" id="qty3">
                    <div class="box-of-count-nafar-boxes">
                                    <span class="text-count-nafar">
                                1 ##Adult## ,0 ##Child## ,0 ##Baby##
                                </span>
                        <span class="fas fa-caret-down down-count-nafar site-color-main-color-before"></span>

                    </div>
                    <div class="cbox-count-nafar">
                        <div class="col-xs-12 cbox-count-nafar-ch bozorg-num">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-nafar">
                                        <h6> ##Adult## </h6> (12 ##yearsandup##)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-nafar"><i
                                                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
                                        <i class="number-count counting-of-count-nafar"
                                           data-number="1" data-min="1"
                                           data-value="l-bozorgsal"
                                           id="bozorgsal">1</i>
                                        <i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 cbox-count-nafar-ch koodak-num">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-nafar">
                                        <h6> ##Child## </h6>(##Children12Years##)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-nafar"><i
                                                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
                                        <i class="number-count counting-of-count-nafar"
                                           data-number="0" data-min="0"
                                           data-value="l-kodak">0</i>
                                        <i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 cbox-count-nafar-ch nozad-num">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-nafar">
                                        <h6> ##Baby## </h6>(##Young2Years##)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-nafar"><i
                                                class="fas fa-plus counting-of-count-nafar plus-nafar"></i>
                                        <i class="number-count counting-of-count-nafar"
                                           data-number="0" data-min="0"
                                           data-value="l-nozad">0</i>
                                        <i class="fas fa-minus counting-of-count-nafar minus-nafar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="div_btn">
                            <span class="btn btn-close site-bg-main-color ">##Closing##</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search">
                <button type="button" class="btn theme-btn seub-btn b-0 site-bg-main-color"
                        onclick="submitLocalSide('international')"><span>##Search##</span></button>
            </div>

        </form>
    </div>
</div>