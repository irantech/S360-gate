{assign var="countries" value=$obj_main_page->countryInsurance()}
<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Insurance">
    <div class="col-md-12 col-12">
        <div class="row">
            <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsInsurance" method="post" name="gdsInsurance" target="_blank">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
                    <div class="form-group">

                        <select aria-hidden="true" class="select-route-insurance-js insurance-destination-country-js" data-placeholder="نام شهر مبدأ" id="origin_bus" name="origin_bus" tabindex="-1">
                            <option value="">##ChoseOption##...</option>

                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search">
                    <div class="form-group">
                        <select aria-hidden="true" class="select2_in travel-time-js select2-hidden-accessible" data-placeholder="انتخاب مدت سفر" id="travel_time" name="travel_time" tabindex="-1">
                            <option value="">##ChoseOption##...</option>
                            {assign var="durations" value=['5','7','8','15','23','31','45','62','92','182','186','365']}
                            {foreach $durations as $days}
                                <option value="5">##untill## {$days} ##Day##</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search">
                    <div class="form-group">
                        <select aria-hidden="true" class="select2_in passengers-count-js select2-hidden-accessible number-of-passengers-js" data-placeholder="انتخاب تعداد مسافر" id="number_of_passengers" name="number_of_passengers" tabindex="-1">
                            <option value="">##ChoseOption##...</option>
                            {for $i=1 to 9}
                                <option value="{$i}">{$i} ##People##</option>
                            {/for}
                        </select>
                    </div>
                </div>
                <div class="count-passenger count-passengers-js">
                    <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search search_col nafarat-bime passenger-age-div-js">
                        <div class="form-group">
                            <input autocomplete="off" class="form-control passengers-age-js shamsiBirthdayCalendar" id="txt_birth_insurance1" name="txt_birth_insurance1" placeholder="تاریخ تولد مسافر 1" type="text"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search d-flex margin-center">
                    <button class="btn theme-btn seub-btn b-0" onclick="searchInsurance()" type="button">
<span>
 جستجو
</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
