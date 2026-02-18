{assign var="date_tour" value=$obj_main_page->datesTour()}
<div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
 <div class="parent-input-search-box">
  <i class="parent-svg-input-search-box">
   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
  </i>
  <div class="caption-input-search-box"> ##EnterTravelDate##</div>
  <select data-placeholder="##Wentdate##"
          name="tourDeptDateLocal"
          id="tourDeptDateLocal"
          class="select2_in DeptYearOnChange_js select2-hidden-accessible internal-date-travel-tour-js"
          tabindex="-1" aria-hidden="true">
   <option value="">####ChoseOption##...##</option>

   {foreach $date_tour as $date}
    <option value='{$date['value']}'>{$date['text']}</option>
   {/foreach}

  </select>
 </div>
</div>