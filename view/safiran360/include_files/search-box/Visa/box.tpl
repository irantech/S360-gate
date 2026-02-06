
{assign var="countries" value=$obj_main_page->getListCountriesAll()}
<div class="__box__ tab-pane {if $active} active {/if}" id="Visa">
 <div class="col-md-12 col-12">
  <div class="row">
   <form class="d_contents" data-action="://s360online.iran-tech.com/" id="gdsVisa" method="post" name="gdsVisa" target="_blank">
    <input type='hidden' value='True' id='visa_continent' name='visa_continent' class='continent-visa-js'>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="form-group">
      <select aria-hidden="true" class="select2_in select2-hidden-accessible country-visa-js" data-placeholder=" مقصد" id="country_id" name="country_id" onchange="getVisaTypeSpecialCountry(this)" tabindex="-1">
       <option  value="">##ChoseOption##...</option>
       {foreach $countries as $country}
        <option value="{$country['countryCode']}">{$country['titleFa']}</option>
       {/foreach}
      </select>
     </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="form-group">
      <select aria-hidden="true" class="select2_in select2-hidden-accessible visa-type-js" data-placeholder=" نوع ویزا" id="visa_type" name="visa_type" tabindex="-1">
       <option selected="selected" value="">نوع ویزا</option>
      </select>
     </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 col_search p-1">
     <div class="select inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
      <input class="adult-visa-js" id="count_adult_internal" name="count_adult_internal" type="hidden" value="1">
      <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
 <span class="text-count-passenger text-count-passenger-js">
1 مسافر
 </span>
       <span class="fas fa-caret-down down-count-passenger">
 </span>
      </div>
      <div class="cbox-count-passenger cbox-count-passenger-js">
       <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
        <div class="row">
         <div class="col-xs-12 col-sm-6 col-6">
          <div class="type-of-count-passenger">
           <h6>
            مسافر
           </h6>
          </div>
         </div>
         <div class="col-xs-12 col-sm-6 col-6">
          <div class="num-of-count-passenger">
           <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-visa="yes">
           </i>
           <i class="number-count-js number-count counting-of-count-passenger" data-min="1" data-number="1" data-type="adult" data-value="internal-adult">
            1
           </i>
           <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-visa="yes">
           </i>
          </div>
         </div>
        </div>
       </div>
       <div class="div_btn">
<span class="btn btn-close">
 تأیید
</span>
       </div>
      </div>
     </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 col-12 btn_s col_search margin-center p-1">
     <button class="btn theme-btn seub-btn b-0" onclick="searchVisa()" type="button">
<span>
 جستجو
</span>
     </button>
    </div>
   </form>
  </div>
 </div>
</div>
