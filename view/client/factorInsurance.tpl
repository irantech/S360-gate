<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="insurance" assign="objInsurance"}
{assign var ="price_calculate_information" value=$objInsurance->priceCalculateInformation()}   {*گرفتن اطلاعات مربوط به مسافران هر مشتری*}
{assign var="discount_data" value=$price_calculate_information['discount_data']}
{assign var="markup_data" value=$price_calculate_information['markup_data']}

{load_presentation_object filename="factorInsurance" assign="objFactor"}
{$objFactor->bookInsert()} {**ثبت اطلاعات مربوط به مسافران**}

{load_presentation_object filename="members" assign="objMember"}
{$objMember->get()}
<div class="lazy-loader-parent lazy_loader_flight">
    <div class="modal-content-flight">
        <div class="modal-body-flight">
            <div class="img_timeoute_svg">

                <svg id="Capa_1" enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                     xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <circle cx="211.748" cy="217.219" fill="#365e7d" r="211.748"/>
                        <path d="m423.496 217.219c0-116.945-94.803-211.748-211.748-211.748-4.761 0-9.482.173-14.165.483 105.408 6.964 189.73 91.05 197.055 196.357.498 7.155-5.367 13.072-12.538 12.919-1.099-.023-2.201-.035-3.306-.035-87.332 0-158.129 70.797-158.129 158.129 0 8.201.627 16.255 1.833 24.118 2.384 15.542-8.906 29.961-24.594 31.022-.107.007-.214.014-.321.021 4.683.309 9.404.483 14.165.483 117.636-.001 211.748-95.585 211.748-211.749z"
                              fill="#2b4d66"/>
                        <circle cx="211.748" cy="217.219" fill="#f4fbff" r="162.544"/>
                        <path d="m374.292 217.219c0-89.77-72.773-162.544-162.544-162.544-4.404 0-8.765.181-13.08.525 83.965 6.687 149.953 77.174 149.461 162.972-.003.004-.006.007-.009.011-68.587 13.484-119.741 70.667-126.655 138.902-1.189 11.73-10.375 21.111-22.124 22.097-.224.019-.448.037-.673.055 94.649 7.542 175.624-67.027 175.624-162.018z"
                              fill="#daf1f4"/>
                        <g>
                            <g>
                                <path d="m211.748 104.963c-4.268 0-7.726-3.459-7.726-7.726v-10.922c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.922c0 4.267-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m296.588 140.105c-1.978 0-3.955-.755-5.464-2.264-3.017-3.017-3.017-7.909.001-10.927l7.723-7.722c3.017-3.017 7.909-3.016 10.927.001 3.017 3.017 3.017 7.909-.001 10.927l-7.723 7.722c-1.508 1.508-3.486 2.263-5.463 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m342.653 224.945h-10.923c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m214.925 359.027c-4.268 0-7.726-3.459-7.726-7.726v-10.923c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.923c.001 4.268-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m119.185 317.508c-1.977 0-3.955-.755-5.464-2.263-3.017-3.018-3.017-7.909 0-10.928l7.723-7.723c3.018-3.016 7.909-3.016 10.928 0 3.017 3.018 3.017 7.909 0 10.928l-7.723 7.723c-1.51 1.509-3.487 2.263-5.464 2.263z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m91.766 224.945h-10.922c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.727 7.726z"
                                      fill="#365e7d"/>
                            </g>
                            <g>
                                <path d="m126.908 140.105c-1.977 0-3.955-.755-5.463-2.263l-7.723-7.722c-3.018-3.017-3.018-7.909-.001-10.927 3.018-3.018 7.91-3.017 10.927-.001l7.723 7.722c3.018 3.017 3.018 7.909.001 10.927-1.509 1.509-3.487 2.264-5.464 2.264z"
                                      fill="#365e7d"/>
                            </g>
                        </g>
                        <g>
                            <path d="m211.748 228.123h-37.545c-4.268 0-7.726-3.459-7.726-7.726s3.459-7.726 7.726-7.726h29.819v-65.392c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v73.119c0 4.266-3.458 7.725-7.726 7.725z"
                                  fill="#2b4d66"/>
                        </g>
                        <circle cx="378.794" cy="373.323" fill="#dd636e" r="133.206"/>
                        <path d="m378.794 240.117c-5.186 0-10.3.307-15.331.884 66.345 7.604 117.875 63.941 117.875 132.322s-51.53 124.718-117.875 132.322c5.032.577 10.145.884 15.331.884 73.568 0 133.206-59.638 133.206-133.206 0-73.567-59.638-133.206-133.206-133.206z"
                              fill="#da4a54"/>
                        <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-6.034-6.034-15.819-6.034-21.853 0l-39.246 39.246-39.246-39.246c-6.034-6.036-15.819-6.034-21.853 0-6.035 6.034-6.035 15.819 0 21.853l39.246 39.246-39.246 39.246c-6.035 6.034-6.035 15.819 0 21.853 3.017 3.017 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526l39.246-39.246 39.246 39.246c3.017 3.018 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526c6.035-6.034 6.035-15.819 0-21.853z"
                              fill="#f4fbff"/>
                        <g>
                            <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-5.885-5.884-15.327-6.013-21.388-.42.154.142.315.271.465.42 6.035 6.034 6.035 15.819 0 21.853l-32.777 32.777c-3.573 3.573-3.573 9.366 0 12.939l32.777 32.777c6.035 6.034 6.035 15.819 0 21.853-.149.15-.311.279-.465.421 2.954 2.726 6.703 4.106 10.462 4.106 3.955 0 7.909-1.509 10.927-4.526 6.035-6.034 6.035-15.819 0-21.853z"
                                  fill="#daf1f4"/>
                        </g>
                    </g>
                </svg>
            </div>
            <span class="timeout-modal__title site-main-text-color">پایان زمان جستجو!</span>

            <p class="timeout-modal__flight">
                به منظور بروزرسانی قیمت ها، لطفا جستجوی خود را از ابتدا انجام دهید.
            </p>
            <a class="btn btn_back_home site-main-text-color" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">بازگشت به صفحه اصلی</a>
        </div>
    </div>
</div>
<div class="s-u-content-result">

    {*<div>*}
    {*<div class="counter counter-analog" data-direction="down" data-format="59:59.9" data-stop="00:00:00.0" data-interval="100" style="direction: ltr">{$smarty.post.time_remmaining}:0</div>*}
    {*</div>*}
    <div id="steps">
        <div class="steps_items">
            <div class="step done ">

                <span class=""><i class="fa fa-check"></i></span>
                <h3>##Searchinsurance##</h3>
            </div>
            <i class="separator done "></i>
            <div class="step  done">
        <span class="flat_icon_airplane">
        <i class="fa fa-check"></i>
            </span>
                <h3>##PassengersInformation##</h3>

            </div>
            <i class="separator donetoactive"></i>
            <div class="step active" >
             <span class="flat_icon_airplane">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="25" height="25">
    <g id="Contact_form" data-name="Contact form">
        <path d="M20.293,30.707A1,1,0,0,1,20,30v3h3a1,1,0,0,1-.707-.293Z"/>
        <path d="M21,29H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M23,20.586,24.586,19H21a1,1,0,0,1,.707.293Z"/>
        <path d="M21,39H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M23,30.586,24.586,29H21a1,1,0,0,1,.707.293Z"/>
        <path d="M20.293,40.707A1,1,0,0,1,20,40v3h3a1,1,0,0,1-.707-.293Z"/>
        <path d="M23,40.586,24.586,39H21a1,1,0,0,1,.707.293Z"/>
        <path d="M21,19H20v1a1,1,0,0,1,1-1Z"/>
        <path d="M49.351,35.187,52,37.836V4H14V49H47.183A7.243,7.243,0,0,1,48.331,45.5l-4.638-4.638a4.032,4.032,0,0,1,0-5.661A4.1,4.1,0,0,1,49.351,35.187ZM47,21H31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Zm1,3a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2H47A1,1,0,0,1,48,24ZM18,7a1,1,0,0,1,1-1H47a1,1,0,0,1,1,1v6a1,1,0,0,1-1,1H19a1,1,0,0,1-1-1ZM40,35H31a1,1,0,0,1,0-2h9a1,1,0,0,1,0,2Zm1,5a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2h9A1,1,0,0,1,41,40ZM28.707,37.707l-5,5A1,1,0,0,1,23,43h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V38a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,33h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V28a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,23h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414ZM43,43a1,1,0,0,1,0,2H31a1,1,0,0,1,0-2ZM31,31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Z"/>
        <path d="M58.01,61,58,59.616a2.985,2.985,0,0,1,.5-1.678l.653-.981A4.979,4.979,0,0,0,60,54.183v-13.7a6.959,6.959,0,0,0-2.05-4.95L54,31.584v8.252l2.427,2.427a1,1,0,0,1-1.414,1.414l-7.07-7.07a2.071,2.071,0,0,0-2.841.006,2.022,2.022,0,0,0,.008,2.833l5.247,5.247a1,1,0,0,1,.053,1.357,5.3,5.3,0,0,0-.1,6.746l.465.575a1,1,0,1,1-1.554,1.258l-.47-.58A7.3,7.3,0,0,1,47.316,51H43.905a8.915,8.915,0,0,0,1.356,6.584l.572.863A1,1,0,0,1,46,59v2Z"/>
        <rect x="20" y="8" width="26" height="4"/>
        <path d="M20.293,20.707A1,1,0,0,1,20,20v3h3a1,1,0,0,1-.707-.293Z"/>
    </g>
</svg>
             </span>
                <h3> ##Approvefinal## </h3>
            </div>
            <i class="separator"></i>
            <div class="step" >
            <span class="flat_icon_airplane">
                <svg  enable-background="new 0 0 512 512" height="25" viewBox="0 0 512 512" width="25"
                      xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <g>
                            <path d="m497 91h-331c-8.28 0-15 6.72-15 15 0 8.27-6.73 15-15 15s-15-6.73-15-15c0-8.28-6.72-15-15-15h-91c-8.28 0-15 6.72-15 15v300c0 8.28 6.72 15 15 15h91c8.28 0 15-6.72 15-15 0-8.27 6.73-15 15-15s15 6.73 15 15c0 8.28 6.72 15 15 15h331c8.28 0 15-6.72 15-15v-300c0-8.28-6.72-15-15-15zm-361 210h-61c-8.28 0-15-6.72-15-15s6.72-15 15-15h61c8.28 0 15 6.72 15 15s-6.72 15-15 15zm60-60h-121c-8.28 0-15-6.72-15-15s6.72-15 15-15h121c8.28 0 15 6.72 15 15s-6.72 15-15 15zm250.61 85.61c-5.825 5.825-15.339 5.882-21.22 0l-64.39-64.4v47.57l25.61 25.61c5.85 5.86 5.85 15.36 0 21.22-5.825 5.825-15.339 5.882-21.22 0l-19.39-19.4-19.39 19.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l25.61-25.61v-47.57l-64.39 64.4c-5.86 5.85-15.36 5.85-21.22 0-5.85-5.86-5.85-15.36 0-21.22l85.61-85.61v-53.78c0-8.28 6.72-15 15-15s15 6.72 15 15v53.78l85.61 85.61c5.85 5.86 5.85 15.36 0 21.22z"/>
                        </g>
                    </g>
                </svg>
            </span>
                <h3> ##Insuranceissuance## </h3>
            </div>
        </div>

        <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
             style="direction: ltr"> {$smarty.post.time_remmaining}</div>
    </div>
    <div id="lightboxContainer" class="lightboxContainerOpacity" style="display: none"></div>

    {*<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change " >
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color lh30">
            ##Note## <i class="zmdi zmdi-alert-circle lh25  zmdi-hc-fw"></i>
        </span>
        <div class="s-u-result-wrapper">
            <span class="s-u-result-item-change direcR iranR txt12 txtRed">
                ##DontReloadPageInfo##
            </span>
        </div>
    </div>
*}
    <div class="Clr"></div>

    <div class="s-u-passenger-wrapper-change">
        <div class="s-u-p-f-container s-u-result-item-change ">

            <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change s-u-last-p-bozorgsal-change-edit site-main-text-color lh30">
                ##Invoice##
            </span>

            <div class="s-u-result-wrapper ">
                <div class="insurance-passenger-main-box">
                    <div class="insurance-passenger-main-box-img">
                        <span><img src="assets/images/{$smarty.post.source_name}Insurance.png"></span>
                    </div>
                    <div class=" insurance-passenger-box-content">
                        <div class="insurance-passenger-content">
                            <div class="insurance-passenger--new">
                                <h2 class="insurance-passenger-description">
                                    {$smarty.post.caption}
                                </h2>
                                <div class="parent-data-insurance--new">
                                     <span class="insurance-passenger-name">##Insurancetitle##:
                                    <i> {$objFactor->source_name_fa} </i>
                                </span>
                                    <span class="insurance-passenger-content-location  ">
                                    ##Destination##: <span>{$smarty.post.destination}</span>
                                </span>
                                </div>

{*                                <span class="insurance-passenger-content-location  ">*}
{*                                        <i class="fa fa-map-marker"></i>*}
{*                                  ##Origin##: {$smarty.post.origin}*}
{*                               </span>*}


                            </div>
                            <div class="insurance-passenger-text">
                                <ul>
                                    <li class="insurance-passenger-check-text">
                                      ##Durationtrip## :
                                        <span class="insurance-passenger-date" dir="rtl">{$smarty.post.num_day}</span>
                                        ##Day##
                                    </li>
                                    <li class="insurance-passenger-check-text">
                                         ##Countpassengers## :
                                        <span class="insurance-passenger-date" dir="rtl">{$smarty.post.member}</span>
                                        ##People##
                                    </li>
                                    {assign var="totalMainCurrency" value=$objFunctions->CurrencyCalculate($smarty.post.price, $smarty.post.CurrencyCode)}
                                    <li class="insurance-passenger-check-text">
                                        ##Insuranceprice## :
                                        <span class="insurance-passenger-date"
                                              dir="rtl">{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}</span> {$totalMainCurrency.TypeCurrency}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="main-Content-bottom Dash-ContentL-B">
        <div class="main-Content-bottom-table Dash-ContentL-B-Table">
            <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                <i class="icon-table"></i>
                <h3>##Listpassengers##</h3>
                <p>
                    (<i> {$objFactor->Adt_qty} ##Adult## </i> -
                    <i>{$objFactor->Chd_qty} ##Child##</i> -
                    <i> {$objFactor->Inf_qty} ##Baby## </i>)
                </p>
            </div>

            <table id="passengers" class="display" cellspacing="0" width="100%">

                <thead>
                <tr>
                    <th>##Ages##</th>
{*                    {if  $objFactor->data['info']|count > 1 || $objFactor->data['info']|count eq 1 && $objFactor->data['info'][1]['passengerNationality'] eq 0}*}
{*                        <th>##Name##</th>*}
{*                        <th>##Family##</th>*}
{*                    {/if}*}
                    <th>##Nameenglish##</th>
                    <th>##Familyenglish##</th>
                    <th>##Happybirthday##</th>
                    <th>##Numpassport##/##Nationalnumber##</th>
                    <th>##Price##</th>
                </tr>
                </thead>
                <tbody>
                {assign var="finalMainCurrency" value=0}

                {foreach $objFactor->data['info']  as $i=>$passenger}


                    {assign var="everyMainCurrency" value=$objFunctions->CurrencyCalculate($objInsurance->calculatePrice($passenger['insurance_baseprice'] + $passenger['insurance_tax'],$markup_data,$discount_data), $smarty.post.CurrencyCode)}
                    {$finalMainCurrency=$finalMainCurrency + $everyMainCurrency.AmountCurrency}
                    <tr>
                        <td>
                            {if $passenger['passenger_age'] == Inf} ##Baby##
                            {elseif $passenger['passenger_age'] == Chd} ##Child##
                            {elseif $passenger['passenger_age'] == Adt} ##Adult##
                            {/if}
                        </td>
{*                        {if  $objFactor->data['info']|count > 1 || $objFactor->data['info']|count eq 1 && $objFactor->data['info'][1]['passengerNationality'] eq 0}*}
{*                        <td><p>{$passenger['passenger_name']}</p></td>*}
{*                        <td><p>{$passenger['passenger_family']}</p></td>*}
{*                        {/if}*}
                        <td><p>{$passenger['passenger_name_en']}</p></td>
                        <td><p>{$passenger['passenger_family_en']}</p></td>
                        <td>
                            <p>{if !$passenger['passenger_birth_date']} {$passenger['passenger_birth_date_en']} {else} {$passenger['passenger_birth_date']}{/if}</p>
                        </td>
                        <td><p>{$passenger['passport_number']}</p></td>
                        <td><p>{$objFunctions->numberFormat($everyMainCurrency.AmountCurrency)}</p></td>
                    </tr>
                {/foreach}
                <tr>
                    <td  {if  $objFactor->data['info']|count > 1 || $objFactor->data['info']|count eq 1 && $objFactor->data['info'][1]['passengerNationality'] eq 0} colspan="7" {else}colspan="5" {/if} class="txtLeft">##TotalPrice## :

                        <span>{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)} {$totalMainCurrency.TypeCurrency}</span>
                    </td>
                </tr>
                </tbody>


            </table>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change  "
         style="padding: 0">
        <div class="s-u-result-wrapper">
            <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
                <div style="text-align: right">
                    {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] =='5'}
                        <div class="s-u-result-item-RulsCheck-item">
{*                            <input class="FilterHoteltype Show_all FilterHoteltypeName-top" id="discount_code" name=""*}
{*                                   value="" type="checkbox">*}
{*                            <label class="FilterHoteltypeName site-main-text-color-a  " for="discount_code">##Ihavediscountcodewantuse##</label>*}

                            <div class="col-sm-12  parent-discount ">
                                <div class="row separate-part-discount">
                                    <div class="col-sm-6 col-lg-4 col-10 d-flex flex-column pr-0">
                                        <label for="discount-code">##RegisterDiscountCode##</label>
                                        <input type="text" id="discount-code" class="form-control" placeholder="##Codediscount## ...">
                                        <span class="discount-code-error"></span>
                                    </div>
                                    <div class="col-sm-2 col-2 d-flex p-0">
                                <span class="input-group-btn">
                                    <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode"
                                           value="{$PriceTotal}"/>
                                    <button type="button"
                                            onclick='setDiscountCode({$serviceType|json_encode}, {$smarty.post.CurrencyCode})'
                                            class="site-secondary-text-color site-bg-main-color iranR discount-code-btn">##Apply##</button>
                                </span>
                                    </div>
                                </div>
                                <div class="row separate-part-discount">
                                    <div class="info-box__price info-box__item pull-left">
                                        <div class="item-discount">
                                            <span class="item-discount__label">##Amountpayable## :</span>
                                            <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}</span>
                                            <span class="price__unit-price">{$totalMainCurrency.TypeCurrency}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {else}
{*                        <span class="price-after-discount-code d-none">{$objFunctions->numberFormat($totalMainCurrency.AmountCurrency)}</span>*}
                    {/if}
                    <p class="s-u-result-item-RulsCheck-item">
                        <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                               name="heck_list1" value="" type="checkbox">
                        <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                            <a class="txtRed" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a>
                            ##IhavestudiedIhavenoobjection##
                        </label>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="inputs_bottom">

{*        <div class="">*}
{*            <input type="button" value="##Optout##" class="loading_on_click cancel-passenger cancel_btn" onclick="BackToHome(); return false">*}
{*        </div>*}
        <div class=" ">
            <a href="" onclick="return false" class="f-loader-check loaderfactors" id="loader_check"
               style="display:none"></a>
            <a class="s-u-check-step btn_insurance site-main-button-color s-u-select-flight-change s-u-submit-passenger-Buyer txt15 lh40 factorLocal-btn"
               id="final_ok_and_insert_passenger" onclick="preReserveInsurance({$objFactor->factor_number})">##Approvefinal##</a>
        </div>
    </div>
    <div id="messageBook" class="error-flight"></div>

    <!-- bank connect -->
    <div class="main-pay-content">


        <!-- payment methods drop down -->
        {assign var="memberCreditPermition" value="0"}
        {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] == '5'}
            {$memberCreditPermition = "1"}
        {/if}

        {assign var="counterCreditPermition" value="0"}
        {if $objSession->IsLogin() && $objMember->list['fk_counter_type_id'] != '5'}
            {$counterCreditPermition = "1"}
        {/if}

        {assign var="PaymentSamanInsurance" value="0"}
        {if $objFunctions->checkClientConfigurationAccess('insurance_private_port')}
            {$PaymentSamanInsurance = "1"}
        {/if}



        {assign var="bankInputs" value=['type_service'=>'insurance','flag' => 'check_credit_insurance', 'factorNumber' => $objFactor->factor_number, 'serviceType' => $objFactor->serviceTitle]}
        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankInsurance"}

        {assign var="creditInputs" value=['flag' => 'buyByCreditInsurance', 'factorNumber' => $objFactor->factor_number]}
        {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankInsurance"}

        {assign var="currencyPermition" value="0"}
        {if $smarty.const.ISCURRENCY && $smarty.post.CurrencyCode > 0}
            {$currencyPermition = "1"}
            {assign var="currencyInputs" value=['flag' => 'check_credit_insurance', 'factorNumber' => $objFactor->factor_number, 'serviceType' => $objFactor->serviceTitle, 'amount' => $finalMainCurrency, 'currencyCode' => $smarty.post.CurrencyCode]}
            {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankInsurance"}
        {/if}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
        <!-- payment methods drop down -->


    </div>

</div>


{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $('body').delegate('.closeBtn', 'click', function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });

            $("div#lightboxContainer").click(function () {

                $(".price-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $(this).find(".closeBtn").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $("div#lightboxContainer").click(function () {

                $(".Cancellation-Box").removeClass("displayBlock");
                $("#lightboxContainer").removeClass("displayBlock");
            });
            $('.DetailSelectTicket').on('click', function (e) {
                $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
            });
        });
    </script>
{/literal}
{literal}
<!-- jQuery Site Scipts -->
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script>
    $('.counter').counter({});
    $('.counter').on('counterStop', function () {
        $('.lazy_loader_flight').slideDown({
            start: function () {
                $(this).css({
                    display: "flex"
                })
            }
        });

});
</script>
    <script src="assets/js/script.js"></script>

<!-- modal login    -->
    <script type="text/javascript" src="assets/js/modal-login.js"></script>
{/literal}