{assign var="date_tour" value=$obj_main_page->datesTour()}

                        {assign var="cities" value=$obj_main_page->getOriginTourCities(['get_origin' =>true])}
                        {assign var="params" value=['type'=>'international']}
                        {assign var="cities_international" value=$obj_main_page->getOriginTourCities($params)}
                        <div class="__box__ tab-pane {if $active} active {/if}" id="Tour">
 <div class="radios switches">
<div class="switch">
 <input autocomplete="off" class="switch-input switch-input-tour-js" id="btn_switch_tour_international" name="btn_switch_tour" type="radio" value="1">
 <label class="switch-label switch-label-on" for="btn_switch_tour_international">
خارجی
 </label>
 <input autocomplete="off" checked="" class="switch-input switch-input-tour-js" id="btn_switch_tour_internal" name="btn_switch_tour" type="radio" value="2">
 <label class="switch-label switch-label-off" for="btn_switch_tour_internal">
داخلی
 </label>
 <span class="switch-selection">
 </span>
</div>
 </div>
 <div class="internal-tour-js" id="internal_tour">
<div class="col-12">
 <div class="row">
<form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsTourLocal" method="post" name="gdsTourLocal" target="_blank">
 <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <select aria-hidden="true" class="select2_in select2-hidden-accessible internal-origin-tour-js" data-placeholder="نام شهر مبدأ" id="internal_origin_tour" name="internal_origin_tour" onchange="getArrivalCitiesTour('internal',this)" tabindex="-1">
<option value="">##ChoseOption##...</option>
{foreach $cities as $city}
<option value="{$city['id']}">{$city['name']}</option>
{/foreach}
 </select>
</div>
 </div>
 <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <select aria-hidden="true" class="select2_in select2-hidden-accessible internal-destination-tour-js" data-placeholder="نام شهر مقصد" id="tourDestinationCityLocal" name="tourDestinationCityLocal" tabindex="-1">
<option value="">##ChoseOption##...</option>
 </select>
</div>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <select aria-hidden="true" class="select2_in DeptYearOnChange_js select2-hidden-accessible internal-date-travel-tour-js" data-placeholder="تاریخ مسافرت" id="tourDeptDateLocal" name="tourDeptDateLocal" tabindex="-1">
<option value="">##ChoseOption##...</option>
 {foreach $date_tour as $date}
<option value='{$date['value']}'>{$date['text']}</option>
{/foreach}
 </select>
</div>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
<button class="btn theme-btn seub-btn b-0" onclick="searchInternalTour()" type="button">
 <span>
جستجو
 </span>
</button>
 </div>
</form>
 </div>
</div>
 </div>
 <div class="international-tour-js" id="international_tour">
<div class="col-12">
 <div class="row">
<form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsPortalLocal" method="post" name="gdsPortalLocal" target="_blank">
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <input class="form-control" disabled="" placeholder="کشور مبدا: ایران" type="text">
 <input id="tourOriginCountryPortal" name="tourOriginCountryPortal" type="hidden" value="1">
</div>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <select aria-hidden="true" class="select2_in select2-hidden-accessible international-tour-origin-city-js" data-placeholder=" شهر مبدا" id="tourOriginCityPortal" name="tourOriginCityPortal" onchange="getArrivalCitiesTour('international',this)" tabindex="-1">
<option value="">##ChoseOption##...</option>
{foreach $cities_international as $city}
<option value="{$city['id']}">{$city['name']}</option>
{/foreach}
 </select>
</div>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <select aria-hidden="true" class="select2_in select2-hidden-accessible international-destination-tour-js" data-placeholder="کشور مقصد" id="tourDestinationCountryPortal" name="tourDestinationCountryPortal" onchange="getDestinationCityTour('international',this)" tabindex="-1">
<option value="">##ChoseOption##...</option>
 </select>
</div>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <select aria-hidden="true" class="select2_in select2-hidden-accessible international-destination-city-tour-js" data-placeholder="شهر مقصد" id="tourDestinationCityPortal" name="tourDestinationCityPortal" tabindex="-1">
<option value="">##ChoseOption##...</option>
 </select>
</div>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
<div class="form-group">
 <select aria-hidden="true" class="select2_in DeptYearOnChange_js select2-hidden-accessible international-date-travel-tour-js" data-placeholder="تاریخ مسافرت" id="tourDeptDateInternational" name="tourDeptDateInternational" tabindex="-1">
{foreach $date_tour as $date}
<option value='{$date['value']}'>{$date['text']}</option>
{/foreach}
 </select>
</div>
 </div>
 <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search p-1">
<button class="btn theme-btn seub-btn b-0" onclick="searchInternationalTour()" type="button">
 <span>
جستجو
 </span>
</button>
 </div>
</form>
 </div>
</div>
 </div>
</div>
