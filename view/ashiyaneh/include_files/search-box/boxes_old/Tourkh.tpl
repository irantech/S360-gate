<div class="__box__ tab-pane" id="Tourkh">
    <div class="_external international-tour-js" id="international_tour">
        <div class="col-12">
            <div class="row">
                <form class="d_contents" data-action="https://s360online.iran-tech.com/" id="gdsPortalLocal"
                      method="post" name="gdsPortalLocal" target="_blank">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                        <div class="form-group">
                            <input class="form-control" disabled="" placeholder="origin country: Iran

" type="text" />
                            <input id="tourOriginCountryPortal" name="tourOriginCountryPortal" type="hidden"
                                   value="1" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                        <div class="form-group">
                            <select aria-hidden="true"
                                    class="select2_in select2-hidden-accessible international-tour-origin-city-js"
                                    data-placeholder="origin city" id="tourOriginCityPortal" name="tourOriginCityPortal"
                                    onchange="getArrivalCitiesTour('international',this)" tabindex="-1">
                                <option value="">انتخاب کنید...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                        <div class="form-group">
                            <select aria-hidden="true"
                                    class="select2_in select2-hidden-accessible international-destination-tour-js"
                                    data-placeholder="destination country" id="tourDestinationCountryPortal"
                                    name="tourDestinationCountryPortal"
                                    onchange="getDestinationCityTour('international',this)" tabindex="-1">
                                <option value="">انتخاب کنید...</option>
                            </select></div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                        <div class="form-group">
                            <select aria-hidden="true"
                                    class="select2_in select2-hidden-accessible international-destination-city-tour-js"
                                    data-placeholder="destination city" id="tourDestinationCityPortal"
                                    name="tourDestinationCityPortal" tabindex="-1">
                                <option value="">انتخاب کنید...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                        <div class="form-group">
                            <select aria-hidden="true"
                                    class="select2_in DeptYearOnChange_js select2-hidden-accessible international-date-travel-tour-js"
                                    data-placeholder="travel date" id="tourDeptDateInternational"
                                    name="tourDeptDateInternational" tabindex="-1">
                                <option value="">انتخاب کنید...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search">
                        <button class="btn theme-btn seub-btn b-0" onclick="searchInternationalTour()" type="button">
                            <span><i class="fa-solid fa-magnifying-glass"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>