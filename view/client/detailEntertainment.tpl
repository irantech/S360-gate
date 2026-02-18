<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css"/>
{load_presentation_object filename="entertainment" assign="objEntertainment"}
{load_presentation_object filename="Session" assign="objSession"}
{load_presentation_object filename="dateTimeSetting" assign="dateTimeSetting"}
{load_presentation_object filename="passengersDetailLocal" assign="objDetail"}
{$objDetail->getCustomers()}

{assign var="InfoMember" value=$objFunctions->infoMember($objSession->getUserId())}
{if $smarty.post.BookId && $smarty.post.EntertainmentId && $smarty.post.serviceName=='entertainment' && $smarty.post.factor_number}
{assign var="EntertainmentData" value=$objEntertainment->GetEntertainmentData('','','','',$smarty.post.EntertainmentId)}
{else}
{assign var="EntertainmentData" value=$objEntertainment->GetEntertainmentData('','','','',$smarty.const.ENTERTAINMENT_ID)}
{/if}
{assign var="GetEntertainmentGalleryData" value=$objEntertainment->GetEntertainmentGalleryData($EntertainmentData['id'])}
{assign var="EntertainmentTypeData" value=$objEntertainment->GetTypes($EntertainmentData['id'],'',true)}
{assign var="GetEntertainmentGallery" value=$GetEntertainmentGalleryData|json_decode:true}
{*{assign var="EntertainmentDataTable" value=$EntertainmentData['datatable']|json_decode:true}*}
{*{$smarty.const.ENTERTAINMENT_ID}*}
{assign var="PageUrl" value="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/temp.php?irantech_parvaz=aboutus"}
{assign var="discount_amount" value="0"}
{if $EntertainmentData['discount_price'] neq 0}
    {$discount_amount = $EntertainmentData['discount_price']}
{elseif $EntertainmentData['discountAmount'] neq 0}

    {$discount_amount = $EntertainmentData['discountAmount']}


{/if}


{if $smarty.const.SOFTWARE_LANG eq 'en'}
    <link rel='stylesheet' href='assets/styles/css/modules-en/fun-en.css'>
{else}
    <link rel='stylesheet' href='assets/styles/fun.css'>
{/if}



<div id="steps">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##S360Entertainment##</h3>
        </div>
        <i class="separator donetoactive"></i>
        <div class="step active">
        <span class="flat_icon_airplane">
        <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577" width="25"
             xmlns="http://www.w3.org/2000/svg">
    <g>
        <path d="m441 145.789h29v105h-29z"/>
        <path d="m60 85.789h-60v387.898l60-209.999z"/>
        <path d="m86.314 280.789-60 210h420.263l55-210z"/>
        <g>
            <path d="m210.074 85.789c-19.299 0-35 15.701-35 35v20c0 19.299 15.701 35 35 35 11.095 0 21.303-5.118 28.008-14.041 4.574-6.089 6.992-13.337 6.992-20.959v-20c0-7.622-2.418-14.871-6.993-20.962-6.706-8.921-16.914-14.038-28.007-14.038z"/>
            <path d="m150.074 250.789h119.926.074v-28.82c0-10.283-4.439-20.067-12.18-26.844l-5.646-4.941c-11.675 9.932-26.667 15.605-42.174 15.605-16.086 0-30.814-5.887-42.176-15.602l-5.647 4.94c-7.737 6.773-12.177 16.557-12.177 26.841z"/>
            <path d="m410 145.789v-135h-320v240h29.901.099.074v-28.82c0-18.933 8.172-36.944 22.42-49.417l7.624-6.67c-3.245-7.725-5.044-16.202-5.044-25.093v-20c0-35.841 29.159-65 65-65 20.312 0 39.749 9.727 51.991 26.018l.002.003c8.51 11.329 13.007 24.808 13.007 38.979v20c0 8.747-1.719 17.228-5.031 25.104l7.609 6.658c14.25 12.475 22.422 30.486 22.422 49.418v28.82h110.926v-105zm-30 15h-55v-30h55zm0-60h-85v-30h85z"/>
        </g>
    </g>
</svg>

            </span>
            <h3>##UsersInformation##</h3>

        </div>
        <i class="separator"></i>
        <div class="step " >
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
         style="direction: ltr">06:00</div>

</div>

<div class="col-md-12 p-0 d-flex flex-wrap mb-4">
    <div class="col-lg-9 col-md-8 p-0">
        <div class="col-md-12 p-0">
            <div class="BaseTourBox mb-0">
                <div class="w-100 BaseDivBackGroundImage">
                    <div class="DivBackGroundImage"
                         style="background-image: url('{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$EntertainmentData['pic']}')">
                        <div class="Details">
                            <h1>{$EntertainmentData['title']}</h1>
                        </div>
                    </div>
                </div>
                <div class="w-100 mt-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb CustomBreadCrumb site-bg-main-color">
                            <li class="breadcrumb-item"><a>{$EntertainmentData['BaseCategoryTitle']}</a></li>
                            <li class="breadcrumb-item"><a
                                        href="{$smarty.const.ROOT_ADDRESS}/resultEntertainment/{$EntertainmentData['country_id']}/{$EntertainmentData['city_id']}/{$EntertainmentData['CategoryId']}">
                                    {$EntertainmentData['CategoryTitle']}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{$EntertainmentData['title']}</li>
                        </ol>
                    </nav>
                </div>
                {if $EntertainmentData['description']}
                    <div class="w-100 mt-3 Description Description-reserv2">
                        {* <div class="TourTitreDiv">
                             <span>خدمات</span>
                         </div>*}
                        <span class="s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                    ##Description## <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>
                    </span>
                        <div class="table Datatable BaseTourBox">
                        {$EntertainmentData['description']}
                        </div>

                    </div>
                {/if}
                {assign var=hasValidRow value=false}

                {foreach from=$EntertainmentData['datatable']|json_decode:true item=item}
                    {if $item.title|trim != '' || $item.body|trim != ''}
                        {assign var=hasValidRow value=true}
                        {break}
                    {/if}
                {/foreach}

                {if $hasValidRow}
                    <div class="w-100 mt-3 Description Description-reserv2">
                        <span class="s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                            ##Service## <i class="zmdi zmdi-ticket-star mart10 zmdi-hc-fw"></i>
                        </span>

                        <table class="table Datatable BaseTourBox">
                            <tbody>
                            {foreach from=$EntertainmentData['datatable']|json_decode:true item=item}
                                {if $item.title|trim != '' || $item.body|trim != ''}
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

                {if $GetEntertainmentGallery['data'][0] != '' || $EntertainmentData['video']}
                <div class="w-100 mt-3 Description Description-reserv3">
                   {* <div class="TourTitreDiv">
                        <span>##Gallery##</span>
                    </div>*}
                    <span class="TourTitreDiv s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                    ##Gallery## <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>
                </span>
                    <div class="w-100 mb-3 Description BaseTourBox">

                        {if $EntertainmentData['video'] != ''}
                            <div class="w-100 pt-3">


                                <iframe src="{$EntertainmentData['video']}" title="{$EntertainmentData['title']}" style='width: 100%;min-height: 400px'></iframe>

                            </div>
                        {/if}
                        {if $GetEntertainmentGallery['data'][0] != ''}
                        <div class="Entertainment-owl-carousel owl-carousel gallery">
                            {foreach key=key item=item from=$GetEntertainmentGallery['data']}
                                <div class="item">
                                    <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$item.file}">
                                        <img src="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/entertainment/{$item.file}">
                                    </a>
                                </div>
                            {/foreach}
                        </div>
                        {/if}
                    </div>
                </div>
                {/if}


                <div class="w-100 mt-3 Description Description-reserv">
                <span class="s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                    ##InformationSaler##
                        {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                            <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                  onclick="setHidenFildnumberRow('')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Userbook##
                                </span>
                        {/if}
                </span>

                <form method="post" id="formPassengerDetailEntertainment" action="{$smarty.const.ROOT_ADDRESS}/factorLocal">

                    <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">


                        <div class="panel-default-change pull-right">
                            <div class="clear"></div>
                            <div class="panel-body-change">
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="CountPeople">##Countpeople##</label>
                                    <input required="required" id="CountPeople" type="text" placeholder="##Countpeople##"
                                           name="CountPeople" min="1"
                                           class="">
                                </div>
                                <div class="s-u-passenger-item  s-u-passenger-item-change d-none">

                                    <select id="gender" name="gender">
                                        <option disabled selected="selected">##Sex##</option>
                                        <option selected value="Male">##Sir##</option>
                                        <option value="Female">##Lady##</option>
                                    </select>
                                </div>
                                {if $smarty.const.SOFTWARE_LANG == 'fa'}
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="nameFa">##FirstName##</label>

                                    <input required="required" id="nameFa" type="text" placeholder="##FirstName##" name="nameFa"
                                           onkeypress=" return persianLetters(event, 'nameFa')" class="justpersian">
                                </div>

                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <label for="familyFa">##LastName##</label>
                                    <input required="required" id="familyFa" type="text" placeholder="##LastName##"
                                           name="familyFa" onkeypress=" return persianLetters(event, 'familyFa')"
                                           class="justpersian">
                                </div>
                                {/if}
<!--                                <div class="s-u-passenger-item-no-star s-u-passenger-item-change justIranian">
                                    <label for="birthday">##shamsihappybirthday##</label>
                                    <input  id="birthday" type="text" placeholder="##shamsihappybirthday##"
                                           name="birthday"
                                           class="shamsiAdultBirthdayCalendar" readonly="readonly">
                                </div>-->
<!--                                <div class="s-u-passenger-item-no-star s-u-passenger-item-change justIranian">
                                    <label for="NationalCode">##Nationalnumber##</label>
                                    <input  id="NationalCode" type="tel" placeholder="##Nationalnumber##"
                                           name="NationalCode"
                                           maxlength="10" class="UniqNationalCode"
                                           onkeyup="return checkNumber(event, 'NationalCode')">
                                </div>-->
                                <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                    <label for="StartDate">##PleaseenterReserveDateRow##</label>
                                    <input required="required" id="StartDate" type="text" placeholder="##PleaseenterReserveDateRow##"
                                           name="StartDate"
                                           class="shamsiFromTodayCalendar" readonly="readonly">
                                </div>
                                <div id="message"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    {if $objSession->IsLogin()}
                        <span class="s-u-last-p-pasenger2 s-u-last-p-pasenger-change site-main-text-color">
                        ##InformationSaler##
                        </span>
                        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">

                            {* <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color">##InformationSaler##
                                <i class="zmdi zmdi-account-box-phone zmdi-hc-fw"></i>
                             </span>*}

                            <div class="clear"></div>
                            <div class="panel-default-change-Buyer boxInformationBuyer">
                                <div class="s-u-passenger-items widthInputInformationBuyer s-u-passenger-item-change no-star">
                                    <label class="text-dark" for="Mobile_buyer">##SalerPhone##</label>
                                    <input required="required" id="Mobile_buyer" type="tel" placeholder="##SalerPhone##"
                                           name="Mobile_buyer"
                                           value="{$InfoMember.mobile}"
                                           onkeypress="return checkNumber(event, 'Mobile_buyer')"/>
                                </div>

                                <div class="s-u-passenger-items s-u-passenger-items_email widthInputInformationBuyer padl0 s-u-passenger-item-change no-star">
                                    <label class="text-dark" for="Email_buyer">##Emailbuyer##</label>
                                    <input id="Email_buyer" type="email" placeholder="##Emailbuyer##"
                                           name="Email_buyer"
                                           value="{$InfoMember.email}"/>
                                </div>
                                <div id="errorInfo"></div>
                            </div>
                            <div class="clear"></div>
                        </div>

                    {/if}

                    {if not $objSession->IsLogin()}
                        <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
            <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color">
                ##InformationSaler##
            </span>
                            <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                            <div class="clear"></div>
                            <div class="panel-default-change-Buyer">
                                <div class="s-u-passenger-items
                     {($smarty.const.SOFTWARE_LANG != 'fa') ? 'display-none-after':''} s-u-passenger-item-change">
                                    <label class="text-dark" for="Mobile">##MobilePhone##</label>
                                    <input required="required" id="Mobile" type="tel" placeholder="##MobilePhone##" name="Mobile"
                                           class=""
                                           onkeypress="return checkNumber(event, 'Mobile')">
                                </div>
                                <div class="{($smarty.const.SOFTWARE_LANG != 'fa') ? 's-u-passenger-item':''}
                     s-u-passenger-items s-u-passenger-item-change padl0 s-u-passenger-items_email">
                                    <label class="text-dark" for="Email">##Email##(##optional##)</label>
                                    <input id="Email" type="email" placeholder="##Email##(##optional##)"
                                           name="Email" class="">
                                </div>
                                <div id="messageInfo"></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    {/if}


                    <div class="clear"></div>
                    <input type="hidden" value="{$EntertainmentData['title']}" name="EntertainmentTitle">
                    {if $smarty.post.BookId && $smarty.post.EntertainmentId && $smarty.post.serviceName=='entertainment' && $smarty.post.factor_number}
                    <input type="hidden" value="{$EntertainmentData['id']}" name="EntertainmentId">
                    {else}
                    <input type="hidden" value="{$smarty.const.ENTERTAINMENT_ID}" name="EntertainmentId">
                    {/if}
                    <input type="hidden" value="{$EntertainmentData['price']}" name="EntertainmentPrice">
                    <input type="hidden" value="" id="numberRow" name="numberRow">
                    <input type="hidden" value="{$smarty.const.CLIENT_ID}" name="client_id">
                    <input type="hidden" id="IdMember" name="IdMember">
{*                    <input type="hidden" value="{$EntertainmentData['factorNumber']}" name="EntertainmentFactorNumber">*}
                    {if $smarty.post.BookId && $smarty.post.EntertainmentId && $smarty.post.serviceName=='entertainment' && $smarty.post.factor_number}
                    <input type="hidden" value="{$smarty.post.factor_number}" name="EntertainmentFactorNumber">
                    {else}
                    <input type="hidden" value="{$objFunctions->generateFactorNumber()}" name="EntertainmentFactorNumber">
                    {/if}
                    {if $discount_amount neq 0}
                        <input type="hidden" value="{$EntertainmentData['discountPrice']}" name="EntertainmentDiscountPrice">
                        <input type="hidden" value="{$discount_amount}" name="EntertainmentDiscountAmount">
                    {else}
                        <input type="hidden" value="{$EntertainmentData['price']}" name="EntertainmentDiscountPrice">
                        <input type="hidden" value="0" name="EntertainmentDiscountAmount">
                    {/if}



                    <div class="btns_factors_n">


                        <div class="passengersDetailLocal_next">
                            <a href="" onclick="return false" class="f-loader-check loaderpassengers"
                               id="loader_check"
                               style="display:none"></a>
                            {if $smarty.post.BookId && $smarty.post.EntertainmentId && $smarty.post.serviceName=='entertainment' && $smarty.post.factor_number}
                                <input type="hidden" value="{$smarty.post.BookId}" name="BookId" id="BookId">
                                <button
                                        id="send_data"
                                        type="button"
                                        onclick="PreReserveEntertainment('{$EntertainmentData['id']}',$(this))"
                                        class='btn s-u-submit-passenger site-bg-main-color s-u-submit-passenger-Buyer'>
                                 ##Editbookings##
                                </button>
                           {else}
                            <button
                                    id="send_data"
                                    type="button"
                                    onclick="PreReserveEntertainment('{$EntertainmentData['id']}',$(this))"
                                    class='btn s-u-submit-passenger site-bg-main-color s-u-submit-passenger-Buyer'>
                                ##NextStepInvoice##
                            </button>
                            {/if}

                        </div>

                    </div>
                </form>
                <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
            </div>


            </div>
        </div>
    </div>
    <div  class="col-lg-3 col-md-4 parent-fun-padding" style="z-index: 100;">

        <div class="z-unset  fun_reserve">

                <div class="pricing-card basic">
                    <div class="pricing-header site-bg-main-color">
                        <span class="plan-title">##Reserve##</span>
                        <div class="price-circle site-border-main-color">
                            <span class="price-title text-dark">

                                {if $EntertainmentData['discountAmount'] neq 0 || $EntertainmentData['discount_price'] neq 0}
                                    <strike class="strikePrice">
                                        <span class="currency text-dark priceOff CurrencyCal ThisPrice"
                                              data-target="value">
                                            {$EntertainmentData['price']|number_format}
                                        </span>
                                    </strike>
                                    <span>{$EntertainmentData['discountPrice']|number_format}</span>
                                    <small>##Rial##</small>

{else}

                                    <span>{$EntertainmentData['price']|number_format}</span>
                                    <small>##Rial##</small>
                                {/if}
                            </span>
                            {*                            <span class="info">/ Month</span>*}
                        </div>
                    </div>
                    <div class="badge-box ">



                        {if $discount_amount neq 0}

                            <span class="d-block p-2 site-bg-second-color">##Discount## {$discount_amount|number_format}%</span>
                        {/if}
                    </div>
                    {if $EntertainmentTypeData}
                    <ul class="mb-4">
                        {foreach key=key item=item from=$EntertainmentTypeData}
                            <li>
                                <strong><span class="site-bg-main-color {$item.logo}"></span></strong> {$item.title}
                            </li>
                        {/foreach}

                    </ul>
                    {/if}
                    <div class="buy-button-box d-none">
                        <a href="#" class="buy-now">##Reserve##</a>
                    </div>


        </div>
    </div>
</div>

{include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}


<!-- login and register popup -->
{assign var="useType" value="entertainment"}
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`contentLoginRegister.tpl"}
<!-- login and register popup -->
<script src="assets/js/script.js"></script>
<script src="assets/js/jquery.fancybox.min.js"></script>
<script src="assets/js/scrollWithPage.min.js"></script>
<script src="assets/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript">
    /*$('.counter').counter();

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
<style>
    .fun_reserve{
        position: sticky !important;
        top: 60px !important;
        bottom: auto !important;
        left: auto !important;
        right: auto !important;
        width: auto !important;
        transform: none !important;
    }

    .parent-fun-padding {
        position: relative;
    }

    .sticky-scope {
        position: relative;
        height: calc(100% - 200px); /* ارتفاع فوتر */
    }

    .fun_reserve {
        position: sticky !important;
        top: 20px;
        z-index:-10;
    }

</style>

<script>
    if($(window).width() > 990){
        $(".fun_reserve").scrollWithPage(".colum-se");
    }
    $(document).ready(function () {
      $('.Entertainment-owl-carousel').owlCarousel({
        rtl: true,
        loop: true,
        margin: 10,
        dots: true,
        nav: false,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2,
          },
          1000: {
            items: 4,
          },
        },
      })
        // add all to same gallery
        $(".gallery a").attr("data-fancybox", "mygallery");
        // assign captions and title from alt-attributes of images:
        $(".gallery a").each(function () {
            $(this).attr("data-caption", $(this).find("img").attr("alt"));
            $(this).attr("title", $(this).find("img").attr("alt"));
        });
        // start fancybox:
        $(".gallery a").fancybox();
    });
</script>
    
