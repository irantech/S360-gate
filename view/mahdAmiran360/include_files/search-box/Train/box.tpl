{assign var='cities' value=$obj_main_page->getBusRoutes()}
<div class="__box__ tab-pane {if $active} active {/if}" id="Train">
 <div class="switches">
  <label for="rdo_train" class="btn-radio select-type-way-js" data-type='train'>
   <input checked="" type="radio" id="rdo_train" name="DOM_TripMode_train" value="1" class="train-one-way-js">
   <svg width="20px" height="20px" viewBox="0 0 20 20">
    <circle cx="10" cy="10" r="9"></circle>
    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
          class="inner"></path>
    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
          class="outer"></path>
   </svg>
   <span>یک طرفه </span>
  </label>
  <label for="rdo_train2" class="btn-radio select-type-way-js mr-4" data-type='train'>
   <input type="radio" id="rdo_train2" name="DOM_TripMode_train" value="2" class="train-two-way-js">
   <svg width="20px" height="20px" viewBox="0 0 20 20">
    <circle cx="10" cy="10" r="9"></circle>
    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z"
          class="inner"></path>
    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z"
          class="outer"></path>
   </svg>
   <span>دو طرفه </span>
  </label>
 </div>
 <div class="row m-auto">
  <div class='d_contents'>
   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route p-1">
    {assign var='cities' value=$obj_main_page->trainListCity()}
    <div class="form-group">
     <select data-placeholder="مبدأ ( نام شهر)"
             name="origin_train"
             id="origin_train"
             class="select2_in  select2-hidden-accessible origin-train-js"
             tabindex="-1" aria-hidden="true">
      <option value="">انتخاب کنید...</option>
      {foreach $cities as $city}
       <option value="{$city['Code']}">{$city['Name']}</option>
      {/foreach}

     </select>
    </div>
    <button onclick="reversRouteTrain()" class="switch_routs" type="button" name="button">
     <i>
      <svg viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"></path></svg>
     </i>
    </button>
   </div>
   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
    <div class="form-group">
     {assign var='cities' value=$obj_main_page->trainListCity()}
     <select data-placeholder="مقصد ( نام شهر  )"
             name="destination_train"
             id="destination_train"
             class="select2_in  select2-hidden-accessible destination-train-js" tabindex="-1" aria-hidden="true">
      <option value="">انتخاب کنید...</option>
      {foreach $cities as $city}
       <option value="{$city['Code']}">{$city['Name']}</option>
      {/foreach}
     </select></div>
   </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-12 col_search date_search p-1">
    <div class="form-group">
     <input readonly="" type="text"
            id="train_departure_date"
            name="train_departure_date"
            class="trainReturnCalendar train-departure-date-js in-tarikh form-control went"
            placeholder="تاریخ رفت">
    </div>
    <div readonly="" class="form-group">
     <input disabled="" type="text"
            id="train_arrival_date"
            name="train_arrival_date"
            class="form-control form-control train-arrival-date-js trainReturnCalendar return_input"
            placeholder="تاریخ برگشت">
    </div>
   </div>
   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">
    <div class="select inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
     <input type="hidden" class="train-adult-js" name="count_adult_train" id="count_adult_train" value="1">
     <input type="hidden" class="train-child-js" name="count_child_train" id="count_child_train">
     <input type="hidden" class="train-infant-js" name="count_infant_train" id="count_infant_train">
     <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
      <span class="text-count-passenger text-count-passenger-js">1 بزرگسال ,0 کودک ,0 نوزاد</span>
      <span class="fas fa-caret-down down-count-passenger"></span>
     </div>
     <div class="cbox-count-passenger cbox-count-passenger-js">
      <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
       <div class="row">
        <div class="col-xs-12 col-sm-6 col-6">
         <div class="type-of-count-passenger"><h6> بزرگسال </h6> (بزرگتر از ۱۲
          سال)
         </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-6">
         <div class="num-of-count-passenger">
          <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
          <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="train" data-value="train-adult" data-type="adult">1</i>
          <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
         </div>
        </div>
       </div>
      </div>
      <div class="col-xs-12 cbox-count-passenger-ch child-number-js">
       <div class="row">
        <div class="col-xs-12 col-sm-6 col-6">
         <div class="type-of-count-passenger"><h6> کودک </h6>(بین 2 الی 12 سال)
         </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-6">
         <div class="num-of-count-passenger">
          <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
          <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="train" data-value="train-child" data-type="child">0</i>
          <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
         </div>
        </div>
       </div>
      </div>
      <div class="col-xs-12 cbox-count-passenger-ch infant-number-js">
       <div class="row">
        <div class="col-xs-12 col-sm-6 col-6">
         <div class="type-of-count-passenger"><h6> نوزاد </h6>(کوچکتر از 2 سال)
         </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-6">
         <div class="num-of-count-passenger">
          <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js"></i>
          <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="train" data-value="train-adult" data-type="infant">0</i>
          <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js"></i>
         </div>
        </div>
       </div>
      </div>


      <div class="col-12 cbox-count-check ">
       <div class="row">

        <div class="radios textbox col-xl-12 ">

         <div class="TripTypeRadio ">
          <div class="form-group non-selectable">
           <input type="radio" value="3" id="rd-check" name="Type_seat_train"
                  class="form-control-rd train-seat-type-js" checked="checked">
           <label for="rd-check" class="form-control-rd-lbl">

            <span></span>

           </label>
           <label for="rd-check" class="pointer">مسافرین
            عادی</label>
          </div>
         </div>
         <div class=" TripTypeRadio  ">
          <div class="form-group non-selectable">
           <input type="radio" value="1" data-radio-type="one" id="rd-check2" name="Type_seat_train"
                  class="form-control-rd train-seat-type-js">
           <label for="rd-check2" class="form-control-rd-lbl">
            <span></span>
           </label>
           <label for="rd-check2" class="pointer">ویژه
            برادران</label>
          </div>
         </div>

         <div class=" TripTypeRadio  ">
          <div class="form-group non-selectable">
           <input type="radio" value="2" data-radio-type="one" id="rd-check3"
                  name="Type_seat_train" class="form-control-rd train-seat-type-js">
           <label for="rd-check3" class="form-control-rd-lbl">
            <span></span>
           </label>
           <label for="rd-check3" class="pointer">ویژه
            خواهران</label>
          </div>
         </div>

         <div class="checkbox_coupe">
          <input type="checkbox" id="coupe" class='train-coupe-type-js'>
          <label for="coupe">کوپه در بست</label>
         </div>

        </div>

       </div>
      </div>

      <div class="div_btn"><span class="btn btn-close ">تأیید</span></div>
     </div>


    </div>
   </div>

   <div class="col-lg-2 col-md-3 col-sm-6 col-12 btn_s col_search margin-center p-1">
    <button type="button" onclick="searchTrain(true)" class="btn theme-btn seub-btn b-0">
     <span>جستجو</span>
    </button>
   </div>
  </div>
 </div>

</div>
