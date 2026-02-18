<div class="__box__ tab-pane {if  $smarty.const.GDS_SWITCH eq 'page'} active {/if}" id="Train">
<div class='parent-text-train-link'>
 <h4>قطار اجازه نمایش در سایت دیگری ندارد برای دیدن نمونه کار قطار روی لینک زیر کلیلک کنید</h4>
 <div class='parent-link-train'>
  <a target="_blank" rel="noopener noreferrer" href='https://railtour.ir/' class=''>
   <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" height="24px" viewBox="0 0 24 24" width="24px" class="vt-link-icon"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M9 5v2h6.59L4 18.59 5.41 20 17 8.41V15h2V5H9z"></path></svg>
   <span>railtour.ir</span>
  </a>
{*  <a target="_blank" rel="noopener noreferrer" href='https://ghatar.ir/' class=''>*}
{*   <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" height="24px" viewBox="0 0 24 24" width="24px" class="vt-link-icon"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M9 5v2h6.59L4 18.59 5.41 20 17 8.41V15h2V5H9z"></path></svg>*}
{*   <span>ghatar.ir</span>*}
{*  </a>*}
 </div>
</div>

{* <div class="d-flex flex-wrap gap-search-box">*}
{*  <div class="cheng-one-two-way dropdown-toggle-cheng-train" >*}
{*   <h4 class="dropdown-text-train">یک طرفه</h4>*}
{*   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">*}
{*    <path d="M362.7 203.9l-159.1 144c-6.125 5.469-15.31 5.469-21.44 0L21.29 203.9C14.73 197.1 14.2 187.9 20.1 181.3C26.38 174.4 36.5 174.5 42.73 180.1L192 314.5l149.3-134.4c6.594-5.877 16.69-5.361 22.62 1.188C369.8 187.9 369.3 197.1 362.7 203.9z"/>*}
{*   </svg>*}
{*   <ul class="filter_ul-one-two-way dropdown-menu-train" >*}
{*    <li data-text='یک طرفه' class="switch-way-js">یک طرفه</li>*}
{*    <li data-text='رفت و برگشت' class="switch-way-js">رفت و برگشت</li>*}
{*   </ul>*}
{*  </div>*}
{*  <div class='d-flex flex-wrap w-100'>*}
{*   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search col_with_route p-1">*}
{*    <div class="parent-input-search-box">*}
{*     <i class="parent-svg-input-search-box">*}
{*      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>*}
{*     </i>*}
{*     <div class="caption-input-search-box">مبدأ خود را وارد کنید</div>*}
{*     <select data-placeholder="مبدأ ( نام شهر)"*}
{*             name="origin_train"*}
{*             id="origin_train"*}
{*             class="select2_in  select2-hidden-accessible origin-train-js"*}
{*             tabindex="-1" aria-hidden="true">*}
{*      <option value="">انتخاب کنید...</option>*}
{*     </select>*}
{*    </div>*}
{*    <button onclick="reversRouteTrain()" class="switch_routs" type="button" name="button">*}
{*     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M443.3 139.3c6.2-6.2 6.2-16.4 0-22.6l-96-96c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6L393.4 112 16 112c-8.8 0-16 7.2-16 16s7.2 16 16 16l377.4 0-68.7 68.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0l96-96zm-342.6 352c6.2 6.2 16.4 6.2 22.6 0s6.2-16.4 0-22.6L54.6 400 432 400c8.8 0 16-7.2 16-16s-7.2-16-16-16L54.6 368l68.7-68.7c6.2-6.2 6.2-16.4 0-22.6s-16.4-6.2-22.6 0l-96 96c-6.2 6.2-6.2 16.4 0 22.6l96 96z"/></svg>*}
{*    </button>*}
{*   </div>*}
{*   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">*}
{*    <div class="parent-input-search-box">*}
{*     <i class="parent-svg-input-search-box">*}
{*      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 192c0-79.5-64.5-144-144-144S48 112.5 48 192c0 12.4 4.5 31.6 15.3 57.2c10.5 24.8 25.4 52.2 42.5 79.9c28.5 46.2 61.5 90.8 86.2 122.6c24.8-31.8 57.8-76.4 86.2-122.6c17.1-27.7 32-55.1 42.5-79.9C331.5 223.6 336 204.4 336 192zm48 0c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192zm-160 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm-112 0a80 80 0 1 1 160 0 80 80 0 1 1 -160 0z"/></svg>*}
{*     </i>*}
{*     <div class="caption-input-search-box">مقصد خود را وارد کنید</div>*}
{*     <select data-placeholder="مقصد ( نام شهر  )"*}
{*             name="destination_train"*}
{*             id="destination_train"*}
{*             class="select2_in  select2-hidden-accessible destination-train-js" tabindex="-1" aria-hidden="true">*}
{*      <option value="">انتخاب کنید...</option>*}
{*     </select></div>*}
{*   </div>*}
{*   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search p-1">*}
{*    <div class="parent-input-search-box">*}
{*     <i class="parent-svg-input-search-box">*}
{*      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>*}
{*     </i>*}
{*     <div class="caption-input-search-box">تاریخ  رفت خود را انتخاب کنید</div>*}
{*     <input type="text"*}
{*            id="train_departure_date"*}
{*            name="train_departure_date"*}
{*            class="trainReturnCalendar train-departure-date-js in-tarikh  went"*}
{*            placeholder="تاریخ رفت">*}
{*    </div>*}
{*   </div>*}
{*   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search date_search p-1">*}
{*    <div class="parent-input-search-box">*}
{*     <i class="parent-svg-input-search-box">*}
{*      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>*}
{*     </i>*}
{*     <div class="caption-input-search-box">تاریخ برگشت خود را انتخاب کنید</div>*}
{*     <input disabled="" type="text"*}
{*            id="train_arrival_date"*}
{*            name="train_arrival_date"*}
{*            class="  train-arrival-date-js trainReturnCalendar return_input"*}
{*            placeholder="تاریخ برگشت">*}
{*    </div>*}
{*   </div>*}
{*   <div class="col-lg-2 col-md-6 col-sm-6 col-12 col_search p-1">*}
{*    <div class="inp-s-num adt box-of-count-passenger box-of-count-passenger-js">*}
{*     <input type="hidden" class="train-adult-js" name="count_adult_train" id="count_adult_train" value="1">*}
{*     <input type="hidden" class="train-child-js" name="count_child_train" id="count_child_train">*}
{*     <input type="hidden" class="train-infant-js" name="count_infant_train" id="count_infant_train">*}
{*     <i class="parent-svg-input-search-box">*}
{*      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>*}
{*     </i>*}
{*     <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">*}
{*      <span class="text-count-passenger text-count-passenger-js">1 مسافر </span>*}
{*      <i>*}
{*       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M201 337c-9.4 9.4-24.6 9.4-33.9 0L7 177c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l143 143L327 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L201 337z"/></svg>*}
{*      </i>*}
{*     </div>*}
{*     <div class="caption-input-search-box">تعداد مسافر</div>*}
{*     <div class="cbox-count-passenger cbox-count-passenger-js">*}
{*      <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">*}
{*       <div class="row">*}
{*        <div class="col-xs-12 col-sm-6 col-6">*}
{*         <div class="type-of-count-passenger"><h6> بزرگسال </h6> (بزرگتر از ۱۲*}
{*          سال)*}
{*         </div>*}
{*        </div>*}
{*        <div class="col-xs-12 col-sm-6 col-6">*}
{*         <div class="num-of-count-passenger">*}
{*          <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>*}
{*          <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="train" data-value="train-adult" data-type="adult">1</i>*}
{*          <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>*}
{*         </div>*}
{*        </div>*}
{*       </div>*}
{*      </div>*}
{*      <div class="col-xs-12 cbox-count-passenger-ch child-number-js">*}
{*       <div class="row">*}
{*        <div class="col-xs-12 col-sm-6 col-6">*}
{*         <div class="type-of-count-passenger"><h6> کودک </h6>(بین 2 الی 12 سال)*}
{*         </div>*}
{*        </div>*}
{*        <div class="col-xs-12 col-sm-6 col-6">*}
{*         <div class="num-of-count-passenger">*}
{*          <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>*}
{*          <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="train" data-value="train-child" data-type="child">0</i>*}
{*          <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>*}
{*         </div>*}
{*        </div>*}
{*       </div>*}
{*      </div>*}
{*      <div class="col-xs-12 cbox-count-passenger-ch infant-number-js">*}
{*       <div class="row">*}
{*        <div class="col-xs-12 col-sm-6 col-6">*}
{*         <div class="type-of-count-passenger"><h6> نوزاد </h6>(کوچکتر از 2 سال)*}
{*         </div>*}
{*        </div>*}
{*        <div class="col-xs-12 col-sm-6 col-6">*}
{*         <div class="num-of-count-passenger">*}
{*          <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>*}
{*          <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="train" data-value="train-adult" data-type="infant">0</i>*}
{*          <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>*}
{*         </div>*}
{*        </div>*}
{*       </div>*}
{*      </div>*}


{*      <div class="col-12 cbox-count-check ">*}
{*       <div class="row">*}

{*        <div class="radios textbox col-xl-12 ">*}

{*         <div class="TripTypeRadio ">*}
{*          <div class="form-group non-selectable">*}
{*           <input type="radio" value="3" id="rd-check" name="Type_seat_train"*}
{*                  class="form-control-rd train-seat-type-js" checked="checked">*}
{*           <label for="rd-check" class="form-control-rd-lbl">*}

{*            <span></span>*}

{*           </label>*}
{*           <label for="rd-check" class="pointer">مسافرین*}
{*            عادی</label>*}
{*          </div>*}
{*         </div>*}
{*         <div class=" TripTypeRadio  ">*}
{*          <div class="form-group non-selectable">*}
{*           <input type="radio" value="1" data-radio-type="one" id="rd-check2" name="Type_seat_train"*}
{*                  class="form-control-rd train-seat-type-js">*}
{*           <label for="rd-check2" class="form-control-rd-lbl">*}
{*            <span></span>*}
{*           </label>*}
{*           <label for="rd-check2" class="pointer">ویژه*}
{*            برادران</label>*}
{*          </div>*}
{*         </div>*}

{*         <div class=" TripTypeRadio  ">*}
{*          <div class="form-group non-selectable">*}
{*           <input type="radio" value="2" data-radio-type="one" id="rd-check3"*}
{*                  name="Type_seat_train" class="form-control-rd train-seat-type-js">*}
{*           <label for="rd-check3" class="form-control-rd-lbl">*}
{*            <span></span>*}
{*           </label>*}
{*           <label for="rd-check3" class="pointer">ویژه*}
{*            خواهران</label>*}
{*          </div>*}
{*         </div>*}

{*         <div class="checkbox_coupe">*}
{*          <input type="checkbox" id="coupe" class='train-coupe-type-js'>*}
{*          <label for="coupe">کوپه در بست</label>*}
{*         </div>*}

{*        </div>*}

{*       </div>*}
{*      </div>*}

{*      <div class="div_btn"><span class="btn btn-close ">تأیید</span></div>*}
{*     </div>*}
{*    </div>*}
{*   </div>*}
{*   <div class="col-lg-2 col-md-6 col-sm-6 col-12 btn_s col_search margin-center p-1">*}
{*    <button type="button" onclick="searchTrain(true)" class="btn theme-btn seub-btn b-0">*}
{*     <span>جستجو</span>*}
{*     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M368 208A160 160 0 1 0 48 208a160 160 0 1 0 320 0zM337.1 371.1C301.7 399.2 256.8 416 208 416C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208c0 48.8-16.8 93.7-44.9 129.1L505 471c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L337.1 371.1z"/></svg>*}
{*    </button>*}
{*   </div>*}
{*  </div>*}
{* </div>*}
</div>