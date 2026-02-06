<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>

{load_presentation_object filename="entertainment" assign="objEntertainment"}
{load_presentation_object filename="factorTourLocal" assign="objFactor"}
{assign var="EntertainmentData" value=$objEntertainment->GetEntertainmentData('','','','',$smarty.post.EntertainmentId)}
{assign var="EntertainmentTypeData" value=$objEntertainment->GetTypes($EntertainmentData['id'],'',true)}
{assign var="serviceType" value="privateEntertainment"}
{assign var="totalEntertainmentPrice"
value=$smarty.post.EntertainmentDiscountPrice * $smarty.post.CountPeople}


{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/fun-en.css'>
{else}
    <link rel='stylesheet' href='assets/styles/fun.css'>
{/if}

<div id="steps" class="hideStepsInMobile">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Tourreservation##</h3>
        </div>
        <i class="separator  done"></i>
        <div class="step done">
        <span class="flat_icon_airplane">
       <i class="fa fa-check"></i>
             </span>
            <h3>##PassengersInformation##</h3>

        </div>
        <i class="separator donetoactive"></i>
        <div class="step active">
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
        <div class="step">
            <span class="flat_icon_airplane">
                 <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                      width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000"
                      preserveAspectRatio="xMidYMid meet">
<metadata>
Created by potrace 1.16, written by Peter Selinger 2001-2019
</metadata>
<g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"
   fill="#000000" stroke="none">
<path d="M499 1247 c-223 -115 -217 -433 9 -544 73 -36 182 -38 253 -6 237
107 248 437 17 552 -52 27 -72 31 -139 31 -68 0 -85 -4 -140 -33z m276 -177
c19 -21 18 -22 -75 -115 l-94 -95 -53 52 -53 52 22 23 22 23 31 -30 31 -30 69
70 c38 39 72 70 76 70 3 0 14 -9 24 -20z"/>
<path d="M70 565 l0 -345 570 0 570 0 0 345 0 345 -104 0 -104 0 -6 -34 c-9
-47 -75 -146 -124 -184 -75 -60 -126 -77 -232 -77 -106 0 -157 17 -232 77 -49
38 -115 137 -124 184 l-6 34 -104 0 -104 0 0 -345z m980 -150 l0 -105 -145 0
-145 0 0 105 0 105 145 0 145 0 0 -105z m-410 -75 l0 -30 -205 0 -205 0 0 30
0 30 205 0 205 0 0 -30z"/>
<path d="M0 150 c0 -45 61 -120 113 -139 39 -15 1015 -15 1054 0 52 19 113 94
113 139 0 7 -207 10 -640 10 -433 0 -640 -3 -640 -10z"/>
</g>
</svg>
            </span>
            <h3> ##TicketReservation## </h3>
        </div>
    </div>

    <div class="counter d-none counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr"> 06:00
    </div>

</div>
<div class="col-md-12 p-0">
    <div class="BaseTourBox col-md-12 ">
        <div class="col-md-12 pr-0 pl-0 pt-2">
            <div class="w-100 row">
                <!--                <div class="col-lg-5 p-0">
                    <img class="w-100 img_BaseTourBox" src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$EntertainmentData.pic}">
                </div>-->
                <div class="col-lg-7 p-0 {if $smarty.const.SOFTWARE_LANG eq 'en'} pl-3{else} pr-3{/if}">

                    <h1 class="title_fun site-border-main-color">
                        {$EntertainmentData.title}
                    </h1>

                    {* ================= SERVICES ================= *}
                    {if isset($EntertainmentTypeData) && $EntertainmentTypeData|@count > 0}
                        <div class="col-md-12 no-pad site-border-main-color">
                            <div class="TourTitreDiv">
                                <span>##Service##</span>
                            </div>

                            <ul class="TourTitreUl">
                                {foreach from=$EntertainmentTypeData item=item}
                                    <li class="site-bg-main-color-a">
                                        <span class="site-bg-main-color mdi {$item.logo}"></span>
                                        {$item.title}
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    {/if}

                    {* ================= DATATABLE ================= *}
                    {assign var=datatable value=$EntertainmentData.datatable|json_decode:true}
                    {assign var=hasValidDatatable value=false}

                    {* تشخیص اینکه آیا حداقل یک ردیف قابل نمایش داریم یا نه *}
                    {if isset($datatable) && $datatable|@count > 0}
                        {foreach from=$datatable item=row}
                            {if ($row.title|trim neq '') || ($row.body|trim neq '')}
                                {assign var=hasValidDatatable value=true}
                                {break}
                            {/if}
                        {/foreach}
                    {/if}

                    {* رندر جدول فقط در صورت وجود دیتای واقعی *}
                    {if $hasValidDatatable}
                        <div class="w-100 mt-3 Description">
                            <table class="table Datatable table-striped table-bordered table-responsive mb-0">
                                <tbody>
                                {foreach from=$datatable item=item}
                                    {if ($item.title|trim neq '') || ($item.body|trim neq '')}
                                        <tr>
                                            <td>{$item.title}</td>
                                            <td>{$item.body}</td>
                                        </tr>
                                    {/if}
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    {/if}

                </div>




            </div>
        </div>
    </div>
</div>

<div class="w-100 col-xs-12 mb-3">
    <div class="main-Content-bottom Dash-ContentL-B">
        <div class="main-Content-bottom-table Dash-ContentL-B-Table">
            <div class="main-Content-bottom-table-Title Dash-ContentL-B-Title l-p-p-header l-p-p-header-change site-bg-main-color">
                <i class="icon-table"></i>
                <h3> ##InformationSaler## </h3>
                <p class="site-bg-main-color-a"> ##Invoicenumber## :{$smarty.post.EntertainmentFactorNumber}</p>
            </div>
            <div class="table-responsive p-0">
                <table id="passengers" class="table table-striped table-bordered mb-0">
                    <thead>
                    <tr>
                        {if $smarty.const.SOFTWARE_LANG == 'fa'}
                            <th>##Name##</th>
                        {/if}
                        {if $smarty.const.SOFTWARE_LANG == 'fa'}
                            <th>##Family##</th>
                        {/if}
                        {if {$smarty.post.gender}}
                        <th>##Sex##</th>
                        {/if}
                        <th>##Countpeople##</th>
                        <th>##AskedDate##</th>
                        <th>##YourMobileNumber##</th>
                        <th>##Price##</th>
                        <th>##Discount##</th>
                        <th>##Finalprice##</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        {if $smarty.const.SOFTWARE_LANG == 'fa'}
                            <td><p>{$smarty.post.nameFa}</p></td>
                        {/if}

                        {if $smarty.const.SOFTWARE_LANG == 'fa'}
                            <td><p>{$smarty.post.familyFa}</p></td>
                        {/if}

                        {if {$smarty.post.gender}}
                            <td><p>{$smarty.post.gender}</p></td>
                        {/if}
                        <td><p>{$smarty.post.CountPeople}</p></td>
                        <td><p>{$smarty.post.StartDate}</p></td>
                        <td>
                            <p>
                                {if $smarty.post.Mobile_buyer == ''}
                                    {$smarty.post.Mobile}
                                {else}
                                    {$smarty.post.Mobile_buyer}
                                {/if}
                            </p>
                        </td>
                        <td><p>{$smarty.post.EntertainmentPrice|number_format}</p></td>
                        <td>
                            <p>
                                {(
                                ($smarty.post.EntertainmentPrice - $smarty.post.EntertainmentDiscountPrice)
                                * $smarty.post.CountPeople
                                )|number_format}
                            </p>
                        </td>
                        <td>
                            <p>
                                {($smarty.post.EntertainmentDiscountPrice * $smarty.post.CountPeople)|number_format}
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<div class=" s-u-passenger-wrapper-change s-u-passenger-wrapper "
     style="padding: 0">

    <div class="s-u-result-wrapper">
        <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
            <div style="width: 100%">

                {if $objSession->IsLogin()}
                    <div class="s-u-result-item-RulsCheck-item">
                        <div class="col-sm-12 parent-discount">
                            <div class="discount-code-new">
                                <div class="title-discount-code">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M200.3 81.5C210.9 61.5 231.9 48 256 48s45.1 13.5 55.7 33.5C317.1 91.7 329 96.6 340 93.2c21.6-6.6 46.1-1.4 63.1 15.7s22.3 41.5 15.7 63.1c-3.4 11 1.5 22.9 11.7 28.2c20 10.6 33.5 31.6 33.5 55.7s-13.5 45.1-33.5 55.7c-10.2 5.4-15.1 17.2-11.7 28.2c6.6 21.6 1.4 46.1-15.7 63.1s-41.5 22.3-63.1 15.7c-11-3.4-22.9 1.5-28.2 11.7c-10.6 20-31.6 33.5-55.7 33.5s-45.1-13.5-55.7-33.5c-5.4-10.2-17.2-15.1-28.2-11.7c-21.6 6.6-46.1 1.4-63.1-15.7S86.6 361.6 93.2 340c3.4-11-1.5-22.9-11.7-28.2C61.5 301.1 48 280.1 48 256s13.5-45.1 33.5-55.7C91.7 194.9 96.6 183 93.2 172c-6.6-21.6-1.4-46.1 15.7-63.1S150.4 86.6 172 93.2c11 3.4 22.9-1.5 28.2-11.7zM256 0c-35.9 0-67.8 17-88.1 43.4c-33-4.3-67.6 6.2-93 31.6s-35.9 60-31.6 93C17 188.2 0 220.1 0 256s17 67.8 43.4 88.1c-4.3 33 6.2 67.6 31.6 93s60 35.9 93 31.6C188.2 495 220.1 512 256 512s67.8-17 88.1-43.4c33 4.3 67.6-6.2 93-31.6s35.9-60 31.6-93C495 323.8 512 291.9 512 256s-17-67.8-43.4-88.1c4.3-33-6.2-67.6-31.6-93s-60-35.9-93-31.6C323.8 17 291.9 0 256 0zM192 224a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm160 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM337 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L175 303c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L337 209z"></path></svg>
                                    <h2>##RegisterDiscountCode##</h2>
                                </div>
                                <div class="discount-code-data">
                                    <h3>##IfYouHaveAdiscountCode##</h3>
                                    <div class="form-discount-code">
                                        <input type="text" placeholder="##Codediscount## ..." id="discount-code">
                                        <input type="hidden" name="priceWithoutDiscountCode" id="priceWithoutDiscountCode"
                                               value="{$totalEntertainmentPrice}"/>
                                        <button type="button" onclick='setDiscountCode({$serviceType|json_encode}, {$smarty.post.CurrencyCode})' class="site-bg-main-color">
                                            ##Apply##
                                        </button>
                                    </div>
                                    <span class="discount-code-error"></span>
                                </div>
                            </div>
                            <div class="row">
                                {*                            <div class="info-box__price info-box__item pull-left">
                                                                <div class="item-discount">
                                                                    <span class="item-discount__label">##Amountpayable## :</span>
                                                                    <span class="price__amount-price price-after-discount-code">{$objFunctions->numberFormat($objDetail->Amount)}</span>
                                                                    <span class="price__unit-price">{$objDetail->AdtPriceType[$direction]}</span>
                                                                </div>
                                                            </div>*}
                                <div class="a-takhfif-box">
                                    <div class="a-takhfif-box-inner">
                                        <div class="a-takhfif-before ">
                                            <span>##PreviousPrice##</span>
                                            <span> {$totalEntertainmentPrice|number_format}
                                                </span>
                                        </div>
                                        <div class="a-takhfif-offer">
                                            <span>##DiscountAmount##</span>
                                            <span><span class="discountAmount">0</span>
                                        </div>
                                        <div class="a-takhfif-after">
                                            <span>##FinalAmount##</span>
                                            <span class="price-after-discount-code">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                {/if}


            </div>




        </div>
    </div>

</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 s-u-passenger-wrapper-change">
    <div class="s-u-result-wrapper">
        <div class="s-u-result-item-change direcR iranR txt12 txtRed s-u-result-item-RulsCheck">
            <div style="text-align: right">
                <p class="s-u-result-item-RulsCheck-item">
                    <input class="FilterHoteltype Show_by_filters FilterHoteltypeName-top" id="RulsCheck"
                           name="heck_list1" value="" type="checkbox">
                    <label class="FilterHoteltypeName site-main-text-color-a " for="RulsCheck">
                        <a class="site-main-text-color" href="{$smarty.const.URL_RULS}" target="_blank">##Seerules## </a> ##IhavestudiedIhavenoobjection##

                    </label>
                </p>


            </div>

        </div>

    </div>

</div>

<div class="w-100 text-center col-xs-12">
    <div class="btn-final-confirmation w-100 text-center" id="btn-final-Reserve">

        <a class="s-u-check-step s-u-submit-passenger-Buyer site-bg-main-color"
           id="final_ok_and_insert_passenger"
           onclick="reserveEntertainmentTemprory('{$smarty.post.EntertainmentFactorNumber}')">##Approvefinal## </a>
    </div>
    <div id="messageBook" class="error-flight"></div>
</div>


<div class="w-100 col-xs-12">
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

        {assign var="bankInputs" value=['flag' => 'check_credit_entertainment', 'factorNumber' => $smarty.post.EntertainmentFactorNumber, 'paymentStatus' => 'prePayment', 'serviceType' => $serviceType]}
        {assign var="bankAction" value="`$smarty.const.ROOT_ADDRESS`/goBankEntertainment"}

        {assign var="creditInputs" value=['flag' => 'buyByCreditEntertainment', 'factorNumber' => $smarty.post.EntertainmentFactorNumber]}
        {assign var="creditAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankEntertainment"}

        {assign var="currencyPermition" value="0"}
        {if $smarty.const.ISCURRENCY && $CurrencyCode > 0}
            {$currencyPermition = "1"}
            {assign var="currencyInputs" value=['flag' => 'check_credit_tour', 'factorNumber' => $smarty.post.factorNumber, 'paymentStatus' => 'prePayment', 'serviceType' => $serviceType, 'amount' => $totalCurrency.AmountCurrency, 'currencyCode' => $CurrencyCode]}
            {assign var="currencyAction" value="`$smarty.const.ROOT_ADDRESS`/returnBankEntertainment"}
        {/if}

        {include file="`$smarty.const.FRONT_CURRENT_CLIENT`paymentMethods.tpl"}
        <!-- payment methods drop down -->

    </div>
</div>
{literal}
    <style>
        /* ===============================
       PAYMENT LAYOUT (BANK / CREDIT)
    ================================ */

        .main-pay-content {
            display: none;
            gap: 20px;
            padding: 20px;
            align-items: stretch;
            background: #f9fafb;
        }

        /* ===============================
           PAYMENT CARD
        ================================ */

        .s-u-p-factor-bank {
            flex: 1;
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            padding: 18px;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease, box-shadow .25s ease;
            min-height: 320px;
        }

        .s-u-p-factor-bank:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 40px rgba(0,0,0,.10);
        }

        /* ===============================
           CARD HEADER
        ================================ */

        .s-u-p-factor-bank > h4 {
            background: linear-gradient(135deg, #1565c0, #1e88e5);
            color: #fff;
            border-radius: 12px;
            padding: 12px;
            margin: -18px -18px 18px -18px;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
        }

        /* ===============================
           BANK LOGOS
        ================================ */

        .s-u-select-bank {
            background: #f1f3f5;
            border-radius: 12px;
            padding: 16px;
        }

        .main-banks-logo {
            display: flex !important;
            flex-direction: row !important;
            justify-content: center;
            align-items: center;
            gap: 20px;              /* فاصله بین بانک‌ها */
            flex-wrap: nowrap;      /* فقط یک ردیف */
            padding: 20px 0;
        }

        .bank-logo {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .bank-logo:hover {
            border-color: #1e88e5;
            box-shadow: 0 6px 20px rgba(0,0,0,.08);
        }

        .s-u-bank-logo-bank {
            width: 42px !important;
            height: auto !important;
            object-fit: contain;
        }

        /* ===============================
           LOGO (CREDIT BOX FIX)
        ================================ */

        .boxerFactorLogo {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 120px;
            margin-bottom: 16px;
        }

        .boxerFactorLogo img {
            max-width: 160px;
            max-height: 80px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        /* ===============================
           CREDIT INFO
        ================================ */

        .paymentCredit {
            background: #f9fafb;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin-top: 10px;
        }

        .paymentCredit p {
            font-size: 13px;
            color: #555;
            margin-bottom: 6px;
        }

        .paymentCredit span {
            font-size: 20px;
            font-weight: 700;
            color: #2e7d32;
        }

        /* ===============================
           ACTION BUTTON
        ================================ */

        .s-u-select-update-wrapper {
            margin-top: auto;
            padding-top: 16px;
        }

        .btn-form2 {
            display: inline-flex;
            width: 100%;
            padding: 13px;
            border-radius: 12px;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            background: linear-gradient(135deg, #e91e63, #c2185b);
            color: #fff !important;
            transition: all .25s ease;
        }

        .btn-form2:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(233,30,99,.35);
        }

        /* ===============================
           CREDIT CARD VARIANT
        ================================ */

        .s-u-p-factor-bank.marr10 {
            background: #fafafa;
        }

        .s-u-p-factor-bank.marr10 .btn-form2 {
            background: linear-gradient(135deg, #455a64, #607d8b);
        }

        /* ===============================
           MOBILE
        ================================ */

        @media (max-width: 768px) {
            .main-pay-content {
                flex-direction: column;
                padding: 12px;
            }

            .s-u-p-factor-bank {
                width: 100% !important;
            }
        }

        .main-banks-logo {
            display: flex !important;
            flex-direction: row !important;
            align-items: center;
            gap: 16px;

            flex-wrap: nowrap;          /* نشکنه */
            overflow-x: auto;           /* بره بقل */
            overflow-y: hidden;

            padding: 20px 10px;
            scroll-behavior: smooth;
        }

        /* اسکرول‌بار تمیز */
        .main-banks-logo::-webkit-scrollbar {
            height: 6px;
        }

        .main-banks-logo::-webkit-scrollbar-track {
            background: transparent;
        }

        .main-banks-logo::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

    </style>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script>
       /* $('.counter').counter();

        $('.counter').on('counterStop', function () {
            $('.lazy_loader_flight').slideDown({
                start: function () {
                    $(this).css({
                        display: "flex"
                    })
                }
            });

        });*/
    </script>
{/literal}