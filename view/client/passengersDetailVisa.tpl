<link href="assets/styles/visa.css" rel="stylesheet" type="text/css"/>

{load_presentation_object filename="resultReservationVisa" assign="objResultVisa"}
{load_presentation_object filename="visa" assign="objVisa"}
{load_presentation_object filename="country" assign="objCountry"}
{load_presentation_object filename="currency" assign="objCurrencyVisa"}

{assign var="visaInfo" value=$objVisa->getVisaByID($smarty.post.visaID)}
{assign var="visaFaqInfo" value=$objVisa->visaFaqWithById($smarty.post.visaID)}
{assign var="visaDetails" value=$objVisa->getVisaDetail($smarty.post.visaID)}
{assign var="dataDocs" value=$objVisa->DocsAdditionalData($smarty.post.visaID)}
{assign var="dataStep" value=$objVisa->StepAdditionalData($smarty.post.visaID)}

{*{assign var="countryInfo" value=$objCountry->getCountryByCode($visaInfo.countryCode)}*}
{*{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}*}
{*{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}*}

{*{$objDetail->getCustomers()}   *}
{*گرفتن اطلاعات مربوط به مسافران هر مشتری*}

<section class="visa">
    <div class="head-image">
        <img src="/gds/pic/{$visaInfo.cover_image}" alt="" class="head-img"/>
    </div>
    <form method="post"
          id="formPassengerDetailVisaa">
    <div class="conitaner">
        <div class="visa-intro">
            <div class="visa-intro-country">
                <img src="/gds/pic/country/{$smarty.const.CLIENT_ID}/{$visaInfo.pic}" class="visa-intro-country-icon"/>
            </div>
            <h1 class="visa-intro-title">{$visaInfo.title}</h1>
            <p class="visa-intro-dedline"> پردازش در {$visaInfo.deadline} </p>

            <div class="visa-page-passenger passenger-number d-block d-lg-none">
                <div class="inp-s-num adt box-of-count-passenger box-of-count-passenger-js">
                    <input type="hidden" class="internal-adult-js" name="count_adult_internal" id="count_adult_internal" value="1">
                    <input type="hidden" class="internal-child-js" name="count_child_internal" id="count_child_internal" value="0">
                    <input type="hidden" class="internal-infant-js" name="count_infant_internal" id="count_infant_internal" value="0">
                    <i class="parent-svg-input-search-box">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                    </i>
                    <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
                        <span class="text-count-passenger text-count-passenger-js">1 مسافر</span>
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M201 337c-9.4 9.4-24.6 9.4-33.9 0L7 177c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l143 143L327 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L201 337z"/></svg>
                        </i>
                    </div>
                    {*                            <div class="caption-input-search-box">تعداد مسافر</div>*}
                    <div class="cbox-count-passenger cbox-count-passenger-js">
                        <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-passenger"><h6> بزرگسال </h6>  (بالای 18 سال)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-passenger">
                                        <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                        <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="internal" data-type="adult">1</i>
                                        <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 cbox-count-passenger-ch child-number-js">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-passenger">
                                        <h6> کودک </h6> (پایین 18 سال)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-passenger"><i
                                                class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                        <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="internal" data-type="child">0</i>
                                        <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 cbox-count-passenger-ch infant-number-js d-none">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="type-of-count-passenger">
                                        <h6> نوزاد </h6>(کوچکتر از 2 سال)
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-6">
                                    <div class="num-of-count-passenger">
                                        <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                        <i class="number-count-js number-count counting-of-count-passenger"
                                           data-number="0" data-min="0" data-search="internal" data-type="infant">0</i>
                                        <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="div_btn">
                            <span class="btn btn-close ">تأیید</span>
                        </div>
                    </div>
                </div>
                <hr/>
                <button class="btn-visa w-100" onclick="chooseVisa({$smarty.post.visaID})" >درخواست ویزا</button>

            </div>


        </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12">
                    <div class="card-body">
                        <div class="card-body-dedline">
                            <svg viewBox="0 0 24 24" width="32px" height="32px" fill="currentColor"><path d="M15.75 3a.75.75 0 0 1 .745.663l.005.087v.75h2.25a2.25 2.25 0 0 1 2.246 2.118L21 6.75v12A2.25 2.25 0 0 1 18.75 21H5.25A2.25 2.25 0 0 1 3 18.75v-12A2.25 2.25 0 0 1 5.25 4.5H7.5v-.75a.75.75 0 0 1 1.495-.087L9 3.75v.75h6v-.75a.75.75 0 0 1 .75-.75Zm3.75 6.75h-15v9c0 .385.29.702.663.745l.087.005h13.5a.75.75 0 0 0 .75-.75v-9ZM6.75 15a.75.75 0 0 1 .745.662l.005.088v.75a.75.75 0 0 1-1.495.087L6 16.5v-.75a.75.75 0 0 1 .75-.75Zm3 0a.75.75 0 0 1 .745.662l.005.088v.75a.75.75 0 0 1-1.495.087L9 16.5v-.75a.75.75 0 0 1 .75-.75Zm3 0a.75.75 0 0 1 .745.662l.005.088v.75a.75.75 0 0 1-1.495.087L12 16.5v-.75a.75.75 0 0 1 .75-.75Zm-6-3.75a.75.75 0 0 1 .745.662L7.5 12v.75a.75.75 0 0 1-1.495.088L6 12.75V12a.75.75 0 0 1 .75-.75Zm3 0a.75.75 0 0 1 .745.662L10.5 12v.75a.75.75 0 0 1-1.495.088L9 12.75V12a.75.75 0 0 1 .75-.75Zm3 0a.75.75 0 0 1 .745.662L13.5 12v.75a.75.75 0 0 1-1.495.088L12 12.75V12a.75.75 0 0 1 .75-.75Zm3 0a.75.75 0 0 1 .745.662L16.5 12v.75a.75.75 0 0 1-1.495.088L15 12.75V12a.75.75 0 0 1 .75-.75Zm3-5.25H16.5v.75a.75.75 0 0 1-1.495.087L15 6.75V6H9v.75a.75.75 0 0 1-1.495.087L7.5 6.75V6H5.25a.75.75 0 0 0-.745.663L4.5 6.75v1.5h15v-1.5a.75.75 0 0 0-.663-.745L18.75 6Z"></path></svg>
                            <h3>زمان پردازش ویزا</h3>
                            <span> پردازش در {$visaInfo.deadline} </span>

                        </div>
                        <div class="card-body-expire">
                            <svg viewBox="0 0 24 24" width="32px" height="32px" fill="currentColor"><path d="M12 1.5c5.799 0 10.5 4.701 10.5 10.5S17.799 22.5 12 22.5 1.5 17.799 1.5 12 6.201 1.5 12 1.5ZM12 3a9 9 0 0 0-9 9 9 9 0 0 0 9 9 9 9 0 0 0 9-9 9 9 0 0 0-9-9Zm-.75 3.75a.75.75 0 0 1 .745.662L12 7.5V12h4.5a.75.75 0 0 1 .745.662l.005.088a.75.75 0 0 1-.662.745l-.088.005h-5.25a.75.75 0 0 1-.745-.662l-.005-.088V7.5a.75.75 0 0 1 .75-.75Z" fill-rule="evenodd"></path></svg>                            <h3>اعتبار ویزا پس از صدور</h3>
                            <span>{$visaInfo.validityDuration}</span>
                        </div>


                    </div>

                    {if !empty($visaInfo.price_table)}
                    <div class="price-table">
                        <span> قیمت</span>
                        <div class="price-table-body">
                            {$visaInfo.price_table}
                        </div>
                    </div>
                    {/if}

                    {if !empty($dataStep)}
                    <div class="step-visa mt-4">
                        <span> مراحل اخذ</span>
                        <div class="step-content-visa">
                        <ul class="list">
                            {foreach key=key item=item from=$dataStep['AdditionalData']|json_decode:true}

                            <li>
                                <div class="list-svg">
                                    <i class="{$item.icon}"></i>
                                </div>
                                <div class="list-info">
                                <span>{$item.title}</span>
                                <p>{$item.body}</p>
                                </div>
                            </li>
                         {/foreach}
                        </ul>
                    {if $dataStep['note']}
                        <div class="alert-info-step-visa">
                            <div class="alert alert-info">
                               {$dataStep['note']}
                            </div>
                        </div>

                    {/if}

                        </div>
                    </div>
                    {/if}


                    {if !empty($dataDocs)}

                    <div class="docs-visa">
                        <span> مدارک مورد نیاز</span>
                        <div class="docs-content-visa">
                        <ul class="list">
                            {foreach key=key item=item from=$dataDocs['AdditionalData']|json_decode:true}

                            <li>
                                <div class="list-svg">
                                    <i class="{$item.icon}"></i>
                                </div>
                                <div class="list-info">
                                    <span>{$item.title}</span>
                                    <p>{$item.body}</p>
                                </div>
                            </li>
                            {/foreach}
                        </ul>

                            {if $dataDocs['note']}
                                <div class="alert-info-step-visa">
                                    <div class="alert alert-info">
                                        {$dataDocs['note']}
                                    </div>
                                </div>

                            {/if}
                        </div>
                    </div>
                {/if}

                    {if !empty($visaInfo.descriptions)}
                        <div class="visa-description">
                            <p>
                                {$visaInfo.descriptions}
                            </p>
                        </div>
                    {/if}

                    {if $visaFaqInfo }

                <div class="faq-visa" id="accordion-faq" role="tablist" aria-multiselectable="true">
                    <span> سوالات متداول</span>
                    {foreach $visaFaqInfo as $visaFaq}
                    <div class=" panel-default card" style="border:1px solid #ebebeb !important ;border-radius:10px !important;padding:1px !important;padding-bottom: 0px !important;">
                        <div class="panel-heading card-header" style="border-color: #ebebeb !important;" role="tab" id="heading-faq-{$visaFaq.id}">
                            <h4 class="panel-title mb-0 parent-accordion">
                                <i class="icone-question">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 160c0-44.2 35.8-80 80-80h32c44.2 0 80 35.8 80 80v4.6c0 24.1-12 46.6-32.1 59.9l-52.3 34.9C133.4 274.2 120 299.2 120 326v2c0 13.3 10.7 24 24 24s24-10.7 24-24v-2c0-10.7 5.3-20.7 14.2-26.6l52.3-34.9c33.4-22.3 53.4-59.7 53.4-99.8V160c0-70.7-57.3-128-128-128H128C57.3 32 0 89.3 0 160c0 13.3 10.7 24 24 24s24-10.7 24-24zm96 320a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                                </i>
                                <a class="btn-link w-100 collapsed" data-toggle="collapse" data-parent="#accordion-faq"
                                   href="#Collapse-faq-{$visaFaq.id}" aria-expanded="false" aria-controls="Collapse-faq-{$visaFaq.id}">
                                    {$visaFaq.question}
                                    <i class="fa icone-arrow"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="Collapse-faq-{$visaFaq.id}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-faq-{$visaFaq.id}"
                             style="">
                          <p>
                              {$visaFaq.answer}
                          </p>
                        </div>
                    </div>
                    {/foreach}

                </div>
                    {/if}


                </div>

                <div class="col-xl-4 col-lg-4 d-lg-block d-none">
                    <div class="visa-page-passenger passenger-number  passenger-number-position">
                        <div class="form-group" style="margin-bottom: 8px !important;">
                            <select data-placeholder=" نوع ویزا" name="visa_detail" id="visa_detail"
                                    class="select2 visa-style-select">
                                <option selected="selected" value="">انتخاب کنید...</option>
                                {foreach $visaDetails as $visaDetail}
                                    <option value="{$visaDetail.id}">
                                        {$visaDetail.title}
                                    </option>
                                {/foreach}

                            </select>
                        </div>
                        <div class="inp-s-num adt box-of-count-passenger box-of-count-passenger-js box-of-count-passenger-visa">
                            <input type="hidden" class="internal-adult-js" name="count_adult_internal" id="count_adult_internal" value="1">
                            <input type="hidden" class="internal-child-js" name="count_child_internal" id="count_child_internal" value="0">
                            <input type="hidden" class="internal-infant-js" name="count_infant_internal" id="count_infant_internal" value="0">
                            <i class="parent-svg-input-search-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>
                            </i>
                            <div class="box-of-count-passenger-boxes box-of-count-passenger-boxes-js">
                                <span class="text-count-passenger text-count-passenger-js">1 مسافر</span>
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M201 337c-9.4 9.4-24.6 9.4-33.9 0L7 177c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l143 143L327 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L201 337z"/></svg>
                                </i>
                            </div>
{*                            <div class="caption-input-search-box">تعداد مسافر</div>*}
                            <div class="cbox-count-passenger cbox-count-passenger-js">
                                <div class="col-xs-12 cbox-count-passenger-ch adult-number-js">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="type-of-count-passenger"><h6> بزرگسال </h6> (بالای 18 سال)
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="num-of-count-passenger">
                                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger" data-number="1" data-min="1" data-search="internal" data-type="adult">1</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 cbox-count-passenger-ch child-number-js">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="type-of-count-passenger">
                                                <h6> کودک </h6>(زیر 18 سال)
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="num-of-count-passenger"><i
                                                        class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger" data-number="0" data-min="0" data-search="internal" data-type="child">0</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 cbox-count-passenger-ch infant-number-js d-none">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="type-of-count-passenger">
                                                <h6> نوزاد </h6>(کوچکتر از 2 سال)
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-6">
                                            <div class="num-of-count-passenger">
                                                <i class="fa fa-plus counting-of-count-passenger add-to-count-passenger-js" data-parvaz="yes"></i>
                                                <i class="number-count-js number-count counting-of-count-passenger"
                                                   data-number="0" data-min="0" data-search="internal" data-type="infant">0</i>
                                                <i class="fa fa-minus counting-of-count-passenger minus-to-count-passenger-js" data-parvaz="yes"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="div_btn">
                                    <span class="btn btn-close">تأیید</span>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <input type="hidden" name="time_remmaining" id="time_remmaining" value=""/>
                        <input type="hidden" name="factorNumber" id="factorNumber" value="{$objResultVisa->generateFactorNumber()}"/>
                        <input type="hidden" name="OnlinePayment" id="OnlinePayment" value="{$visaInfo.OnlinePayment}"/>
                        <input type="hidden" name="visaID" id="visaID" value="{$smarty.post.visaID}"/>
                        <input type="hidden" name="idMember" id="idMember" value=""/>
                        <input type="hidden" name="prePaymentCost" id="prePaymentCost" value="{$visaInfo.prePaymentCost}"/>
                        <input type="hidden" name="mainCost" id="mainCost" value="{$visaInfo.mainCost}"/>

                        <input type="hidden" name="CurrencyCode" id="CurrencyCode" value="{$smarty.post.CurrencyCode}"/>
    </form>
{*                        <button class="btn-visa" >درخواست ویزا</button>*}
                        <button class="btn-visa w-100" onclick="chooseVisa({$smarty.post.visaID})" >درخواست ویزا</button>

                    </div>


                </div>

            </div>
        </div>
    </div>



</section>
{assign var="useType" value="visa"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}

<script>
   const step1Data = {
      firstName: document.querySelector("#firstName").value,
      lastName: document.querySelector("#lastName").value,
   };

   $(document).ready(function () {

      $('#visa_detail').select2({
         placeholder: "نوع ویزا",
         dir: "rtl",
         width: '100%'
      });

      // وقتی select2 ساخته شد، نمایش بده
      $('#visa_detail').addClass('show-select2');
   });

   sessionStorage.setItem("step1", JSON.stringify(step1Data));
   // برو صفحه ۲
   location.href = "/step2.html";
</script>
<script src="assets/js/script.js"></script>

