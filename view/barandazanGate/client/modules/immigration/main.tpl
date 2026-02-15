{load_presentation_object filename="agency" assign="objAgency"}
{load_presentation_object filename="country" assign="objCountry"}
{load_presentation_object filename="currency" assign="objCurrencyVisa"}
{load_presentation_object filename="articles" assign="obj_articles" }
{load_presentation_object filename="faqs" assign="obj_faqs" }
{assign var="visa" value=$objVisa->getVisaByID($visa_id)}
{assign var="searchContinent" value=$objCountry->getCountryByCode($smarty.const.IMMIGRATION_COUNTRY)}
{assign var="visaTypeMoreDetail" value=$objVisa->getVisaTypeMoreDetail(['country_id'=>$searchContinent.countryID,'type_id'=>$visa['visaTypeID']])}

<section class="immigration-internal-page">
    <div class="container">
        <div class="parent-immigration-internal-page">
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 p-0">
                <div class="parent-img">
                    <img class="img-back1" src="assets/images/immigration1.png" alt="img-back">
                    <img class="img-back2" src="assets/images/immigration2.png" alt="img-back">
                    <img class="img-back3" src="assets/images/immigration3.png" alt="img-back">
                    <img class="img-back4" src="assets/images/immigration4.png" alt="img-back">
                    <img class="img-main5" src="assets/images/immigration5.png" alt="img-visa">
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 p-0">
                <div class="parent-text-immigration-internal-page">
                    <div class="parent-titr-tab">
                        <h2>{$visa['title']}</h2>
                        {if $visa['documents'] and $visa['descriptions']}
                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">توضیحات</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">مدارک</button>
                                </li>
                            </ul>
                        {/if}
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <p>{$visa['descriptions']}</p>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <h6>مدارک : </h6>
                            <p>{$visa['documents']}</p>
                        </div>
                    </div>
                    <div class="parent-data-immigration-internal-page">
                        {if $visa['deadline']}
                            <div class="item-immigration-internal-page">
                                <i class="fa-solid fa-badge-check"></i>
                                زمان تحویل: <span class="answer"> {$visa['deadline']}</span>
                            </div>
                        {/if}
                        {if $visa['validityDuration']}
                            <div class="item-immigration-internal-page">
                                <i class="fa-solid fa-badge-check"></i>
                                اعتبار ویزا: <span class="answer">{$visa['validityDuration']}</span>
                            </div>
                        {/if}
                    </div>
                    <div class="parent-data-immigration-internal-page">
                        {if $visa['allowedUseNo']}
                            <div class="item-immigration-internal-page">
                                <i class="fa-solid fa-badge-check"></i>
                                تعداد ورود: <span class="answer">{$visa['allowedUseNo']}</span>
                            </div>
                        {/if}
                        {if $visa['visaTypeTitle']}
                            <div class="item-immigration-internal-page">
                                <i class="fa-solid fa-badge-check"></i>
                                نوع ویزا: <span class="answer">{$visa['visaTypeTitle']}</span>
                            </div>
                        {/if}
                    </div>
                    <div>
                        {if $visa['redirectUrlCheck'] == '1'}
                            <div class="prices_visa">

                                <span class="">
                                    {if $visa['mainCost'] neq $visa['priceWithDiscount']}
                                        <p class="visa-text">
                                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($visa['mainCost'])}
                                            <span class="old-price text-decoration-line CurrencyCal CurrencyText"
                                                  data-amount="{$visa['mainCost']}">{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</span>
                                        </p>
                                    {/if}
                                    {assign var="discountCurrency" value=$objFunctions->CurrencyCalculate($visa['priceWithDiscount'])}
                                    <span class="price_visa"
                                          data-amount="{$visa['priceWithDiscount']}">{$objFunctions->numberFormat($discountCurrency.AmountCurrency)}</span>
                                    <span class="  d-inline-block font13 align-items-center align-center align-content-center justify-content-center">
                                        {if $visa['OnlinePayment'] eq 'yes'}
                                            {$discountCurrency.TypeCurrency}
                                        {else}
                                            {if $visa['currencyType'] eq '0'}
                                                تومان
                                            {else}
                                                {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($visa['currencyType'])}
                                                {$VisacurrencyType.CurrencyTitle}
                                            {/if}

                                        {/if}

                                    </span>

                                </span>
                                <div class="prepayment flex-wrap">
                                    <i class="d-block w-100"> ##PrePrice##: </i>
                                    {assign var="prePaymentCurrency" value=$objFunctions->CurrencyCalculate($visa['prePaymentCost'])}
                                    <span class=" iranM site-main-text-color-drck CurrencyCal"
                                          data-amount="{$visa['prePaymentCost']}">{$objFunctions->numberFormat($prePaymentCurrency.AmountCurrency)}</span>
                                    {*<i class="CurrencyText">
                                        {if $item.OnlinePayment eq 'yes'}
                                            {$prePaymentCurrency.TypeCurrency}
                                        {else}
                                            {if $item.currencyType eq '0'}
                                                تومان
                                            {else}
                                                {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($item.currencyType)}
                                                {$VisacurrencyType.CurrencyTitle}
                                            {/if}
                                        {/if}
                                    </i>*}
                                </div>
                            </div>
                            <div class="">
                                {assign var="agencyInfoByIdMember" value=$objAgency->AgencyInfoByIdMember($visa['agency_id'])}
                            </div>

                        {else}
                            <div class="">
                                <div class="prices_visa">

                                    {if $visa['mainCost'] neq $visa['priceWithDiscount']}
                                        <p class="visa-text">
                                            {assign var="mainCurrency" value=$objFunctions->CurrencyCalculate($visa['mainCost'])}
                                            <span class=""
                                                  data-amount="{$visa['mainCost']}">{$objFunctions->numberFormat($mainCurrency.AmountCurrency)}</span>
                                        </p>
                                    {/if}
                                    {assign var="discountCurrency" value=$objFunctions->CurrencyCalculate($visa['priceWithDiscount'])}
                                    <i class="d-block "> ##Price##: </i>
                                    <span class="price_visa" data-amount="{$visa['priceWithDiscount']}" style='text-align: right;'>
                                        {$objFunctions->numberFormat($discountCurrency.AmountCurrency)}

                                        {if $visa['OnlinePayment'] eq 'yes'}
                                            {$discountCurrency.TypeCurrency}
                                        {else}
                                            {if $visa['currencyType'] eq '0'}
                                                تومان
                                            {else}
                                                {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($visa['currencyType'])}
                                                {$VisacurrencyType.CurrencyTitle}
                                            {/if}
                                        {/if}

                                    </span>

                                </div>
                                <div class="marb5 visa-text text-center priceSortAdt_visa">
                                    <p class="">
                                        <span class="d-block"> ##PrePrice##: </span>
                                        {assign var="prePaymentCurrency" value=$objFunctions->CurrencyCalculate($visa['prePaymentCost'])}
                                        <span class=" iranM CurrencyCal"
                                              data-amount="{$visa['prePaymentCost']}">{$objFunctions->numberFormat($prePaymentCurrency.AmountCurrency)}</span>
                                        <i class="CurrencyText">
                                            {if $visa['OnlinePayment'] eq 'yes'}
                                                {$prePaymentCurrency.TypeCurrency}
                                            {else}
                                                {if $item.currencyType eq '0'}
                                                    تومان
                                                {else}
                                                    {assign var="VisacurrencyType" value=$objCurrencyVisa->ShowInfo($visa['currencyType'])}
                                                    {$VisacurrencyType.CurrencyTitle}
                                                {/if}
                                            {/if}
                                        </i>
                                    </p>
                                </div>
                            </div>
                        {/if}
                    </div>


                    <button class="btn-reservation" onclick="sendToVisaPassengers()">
                        رزرو
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class='immigration-card'>
    <div class='container'>
        <div class='parent-immigration-card'>
            <div class='immigration-card-item'>
                <div class='icon-card-immigration'>
                    <svg class='svg-box-one' xmlns="http://www.w3.org/2000/svg" version="1.0" width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"  stroke="none">
                            <path d="M627 1273 c-4 -3 -7 -48 -7 -99 l0 -93 -146 -75 c-138 -71 -151 -76 -210 -76 l-64 0 0 30 0 30 69 0 69 0 -1 58 c0 31 -6 60 -11 64 -13 9 -128 10 -150 2 -13 -5 -16 -23 -16 -95 0 -79 -2 -89 -18 -89 -10 0 -27 -7 -38 -15 -19 -14 -19 -15 4 -54 16 -30 22 -56 22 -105 l0 -65 -56 -3 c-73 -4 -87 -22 -53 -69 13 -18 26 -54 29 -78 6 -57 28 -66 32 -14 3 37 4 38 46 41 41 3 42 2 42 -28 0 -18 6 -33 15 -36 22 -9 22 -276 0 -294 -8 -7 -15 -23 -15 -36 0 -22 -4 -24 -45 -24 l-45 0 0 145 c0 122 -2 145 -15 145 -13 0 -15 -23 -15 -143 0 -138 -1 -143 -23 -152 -20 -9 -22 -17 -22 -75 l0 -65 495 0 c433 0 495 2 495 15 0 13 -61 15 -477 18 l-478 2 0 35 0 35 600 0 600 0 0 -35 0 -34 -92 -3 c-75 -2 -93 -6 -93 -18 0 -12 19 -15 110 -15 l110 0 0 65 c0 58 -2 66 -22 75 -23 10 -23 12 -23 220 l0 210 26 39 c36 53 25 70 -50 74 l-56 3 0 65 c0 49 6 75 23 105 22 39 22 40 3 54 -11 8 -28 15 -38 15 -13 0 -18 8 -18 30 l0 30 69 0 c75 0 88 8 71 40 -8 14 -8 26 0 41 19 35 -3 49 -77 49 -98 0 -103 -5 -103 -105 l0 -85 -62 0 c-58 0 -74 6 -210 76 -148 75 -148 75 -148 109 l0 35 63 0 c72 0 91 11 75 45 -7 15 -7 29 0 41 18 37 5 44 -82 44 -46 0 -86 -3 -89 -7z m128 -58 c0 -23 -3 -25 -47 -25 -44 0 -48 2 -48 25 0 23 4 25 48 25 44 0 47 -2 47 -25z m-465 -160 c0 -23 -4 -25 -45 -25 -41 0 -45 2 -45 25 0 23 4 25 45 25 41 0 45 -2 45 -25z m925 0 c0 -23 -3 -25 -47 -25 -44 0 -48 2 -48 25 0 23 4 25 48 25 44 0 47 -2 47 -25z m-460 -65 c109 -59 110 -60 69 -60 -39 0 -72 -19 -57 -33 3 -4 44 -7 90 -7 l83 0 0 -370 c0 -363 0 -370 -20 -370 -19 0 -20 7 -20 94 0 112 -9 126 -75 126 -66 0 -75 -14 -75 -126 0 -87 -1 -94 -20 -94 -19 0 -20 7 -20 98 0 63 -4 102 -12 110 -16 16 -100 16 -116 0 -8 -8 -12 -47 -12 -110 0 -89 -2 -98 -19 -98 -10 0 -21 9 -24 20 -3 11 -12 20 -21 20 -9 0 -16 -8 -16 -20 0 -16 -7 -20 -35 -20 l-36 0 3 93 3 92 30 0 c28 0 30 -3 33 -43 3 -34 7 -43 20 -40 23 4 28 63 7 94 -13 20 -24 24 -65 24 -63 0 -70 -12 -70 -129 0 -84 -1 -91 -20 -91 -20 0 -20 7 -20 370 l0 370 186 0 c171 0 185 1 182 18 -3 15 -19 17 -148 20 l-145 3 110 59 c61 33 112 60 115 60 3 0 55 -27 115 -60z m-455 -125 c0 -24 -2 -25 -70 -25 -58 0 -71 3 -80 19 -5 11 -10 22 -10 25 0 3 36 6 80 6 79 0 80 0 80 -25z m840 19 c0 -3 -5 -14 -10 -25 -9 -16 -22 -19 -80 -19 -68 0 -70 1 -70 25 0 25 1 25 80 25 44 0 80 -3 80 -6z m-840 -139 l0 -55 -65 0 -65 0 0 55 0 55 65 0 65 0 0 -55z m810 0 l0 -55 -65 0 -65 0 0 55 0 55 65 0 65 0 0 -55z m-810 -120 l0 -25 -107 0 c-85 0 -110 3 -125 17 -10 9 -18 20 -18 25 0 4 56 8 125 8 l125 0 0 -25z m930 18 c0 -3 -7 -15 -17 -25 -14 -15 -32 -18 -125 -18 l-108 0 0 25 0 25 125 0 c69 0 125 -3 125 -7z m-930 -93 c0 -17 -7 -20 -45 -20 -38 0 -45 3 -45 20 0 17 7 20 45 20 38 0 45 -3 45 -20z m770 0 c0 -17 -7 -20 -45 -20 -38 0 -45 3 -45 20 0 17 7 20 45 20 38 0 45 -3 45 -20z m128 -192 l2 -208 -45 0 c-41 0 -45 2 -45 24 0 13 -7 29 -15 36 -22 18 -22 285 0 294 9 3 15 18 15 36 0 30 1 31 43 28 l42 -3 3 -207z m-898 2 l0 -140 -30 0 -30 0 0 140 0 140 30 0 30 0 0 -140z m740 0 l0 -140 -30 0 -30 0 0 140 0 140 30 0 30 0 0 -140z m-362 -117 l3 -93 -41 0 -40 0 0 88 c0 49 3 92 7 96 4 4 21 6 38 4 l30 -3 3 -92z m180 0 l3 -93 -36 0 -35 0 0 88 c0 49 3 92 7 96 4 4 19 6 33 4 25 -3 25 -5 28 -95z m-558 -78 c0 -11 -12 -15 -45 -15 -33 0 -45 4 -45 15 0 11 12 15 45 15 33 0 45 -4 45 -15z m770 0 c0 -11 -12 -15 -45 -15 -33 0 -45 4 -45 15 0 11 12 15 45 15 33 0 45 -4 45 -15z"/>
                            <path d="M424 826 c-3 -7 -4 -40 -2 -72 l3 -59 49 -3 c32 -2 52 1 57 10 10 15 12 99 3 122 -8 21 -102 23 -110 2z m76 -61 c0 -28 -4 -35 -20 -35 -16 0 -20 7 -20 35 0 28 4 35 20 35 16 0 20 -7 20 -35z"/>
                            <path d="M584 827 c-3 -8 -4 -41 -2 -73 l3 -59 55 0 55 0 0 70 0 70 -53 3 c-38 2 -54 -1 -58 -11z m76 -62 c0 -28 -4 -35 -20 -35 -16 0 -20 7 -20 35 0 28 4 35 20 35 16 0 20 -7 20 -35z"/>
                            <path d="M744 827 c-3 -8 -4 -41 -2 -73 l3 -59 55 0 55 0 0 70 0 70 -53 3 c-38 2 -54 -1 -58 -11z m76 -62 c0 -28 -4 -35 -20 -35 -16 0 -20 7 -20 35 0 28 4 35 20 35 16 0 20 -7 20 -35z"/>
                            <path d="M424 596 c-3 -7 -4 -40 -2 -72 l3 -59 55 0 55 0 3 58 c2 35 -2 64 -9 73 -15 18 -98 19 -105 0z m76 -66 c0 -33 -3 -40 -20 -40 -17 0 -20 7 -20 40 0 33 3 40 20 40 17 0 20 -7 20 -40z"/>
                            <path d="M592 601 c-9 -5 -12 -27 -10 -72 l3 -64 55 0 55 0 3 58 c2 35 -2 64 -9 73 -12 15 -76 19 -97 5z m68 -71 c0 -33 -3 -40 -20 -40 -17 0 -20 7 -20 40 0 33 3 40 20 40 17 0 20 -7 20 -40z"/>
                            <path d="M751 596 c-7 -9 -11 -38 -9 -73 l3 -58 55 0 55 0 3 64 c2 45 -1 67 -10 72 -21 14 -85 10 -97 -5z m69 -66 c0 -33 -3 -40 -20 -40 -17 0 -20 7 -20 40 0 33 3 40 20 40 17 0 20 -7 20 -40z"/>
                        </g>
                    </svg>
                </div>
                <div class='text-card-immigration'>
                    <h3>
                        رزرو سریع و امن وقت سفارت
                    </h3>
                    <p>
                        انواع وقت سفارت توریستی و تحصیلی آمریکا
                    </p>
                </div>
            </div>
            <div class='immigration-card-item'>
                <div class='icon-card-immigration'>
                    <svg class='svg-box-two' xmlns="http://www.w3.org/2000/svg" version="1.0" width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"  stroke="none">
                            <path d="M587 1262 c-10 -10 -17 -26 -17 -35 0 -14 -12 -17 -78 -17 -113 0 -116 -4 -120 -135 -4 -115 8 -155 48 -155 16 0 20 -7 20 -30 0 -45 23 -47 73 -6 40 33 50 36 105 36 65 0 92 15 92 51 0 26 6 24 57 -17 50 -41 73 -39 73 6 0 23 4 30 19 30 38 0 51 37 51 147 0 144 1 143 -173 143 -117 0 -136 -2 -150 -18z m278 -127 l0 -100 -29 -3 c-18 -2 -30 -11 -33 -23 -7 -24 -9 -24 -40 1 -14 11 -32 20 -39 20 -11 0 -14 18 -14 72 0 84 -15 108 -67 108 -23 0 -33 5 -33 15 0 13 19 15 128 13 l127 -3 0 -100z m-195 -70 l0 -105 -62 0 c-50 0 -67 -5 -94 -25 l-33 -25 -3 22 c-2 17 -12 24 -33 28 l-30 5 -3 89 c-2 49 -1 95 2 103 4 10 36 13 131 13 l125 0 0 -105z"/>
                            <path d="M513 1113 c-7 -2 -13 -11 -13 -19 0 -11 15 -14 63 -14 69 0 83 6 66 27 -11 13 -90 17 -116 6z"/>
                            <path d="M450 1095 c0 -10 7 -15 18 -13 21 4 19 22 -2 26 -10 2 -16 -3 -16 -13z"/>
                            <path d="M452 1033 c3 -16 15 -18 93 -18 73 0 90 3 90 15 0 12 -18 16 -93 18 -85 3 -93 1 -90 -15z"/>
                            <path d="M158 1028 c-62 -36 -85 -111 -53 -172 15 -28 14 -31 -10 -56 l-25 -26 0 -217 c0 -271 -8 -257 145 -257 l105 0 0 -125 c0 -120 1 -127 25 -150 31 -32 69 -32 101 0 l25 25 -3 180 -3 180 78 0 77 0 0 -155 0 -155 -28 0 c-38 0 -52 -17 -52 -62 l0 -38 100 0 100 0 0 38 c0 45 -14 62 -52 62 l-28 0 0 155 0 155 78 0 77 0 -3 -180 -3 -180 25 -25 c32 -32 70 -32 101 0 24 23 25 30 25 150 l0 125 103 0 c154 0 147 -12 147 257 l0 217 -25 26 c-25 26 -25 27 -9 59 32 64 2 140 -68 177 -99 51 -227 -71 -177 -169 17 -32 61 -77 76 -77 23 0 14 -15 -49 -77 l-63 -61 -97 -4 c-107 -3 -127 -13 -132 -64 -3 -23 -8 -29 -26 -29 -18 0 -23 6 -26 29 -5 51 -25 61 -132 64 l-97 4 -62 61 c-64 62 -73 77 -50 77 15 0 59 45 76 77 27 52 -1 126 -61 163 -42 26 -84 25 -130 -2z m111 -33 c81 -41 56 -160 -36 -172 -37 -5 -46 -2 -73 25 -79 79 9 199 109 147z m831 0 c59 -31 68 -98 20 -147 -27 -27 -36 -30 -73 -25 -91 12 -117 129 -38 172 34 18 55 18 91 0z m-902 -219 c15 -8 61 -49 102 -90 l74 -76 86 0 c97 0 135 -15 111 -44 -11 -13 -34 -16 -113 -16 l-100 0 -72 70 c-40 39 -78 70 -84 70 -20 0 -13 -25 13 -50 23 -21 25 -31 25 -107 l0 -83 -65 0 -65 0 0 160 c0 141 2 160 18 169 23 14 38 13 70 -3z m953 4 c18 -10 19 -23 19 -170 l0 -160 -65 0 -65 0 0 83 c0 76 2 86 25 107 26 25 33 50 13 50 -6 0 -44 -31 -84 -70 l-72 -70 -100 0 c-79 0 -102 3 -113 16 -24 29 14 44 111 44 l86 0 69 71 c100 102 134 121 176 99z m-802 -297 c1 -31 -1 -33 -34 -33 l-35 0 0 61 0 61 34 -29 c26 -21 35 -36 35 -60z m651 27 l0 -60 -35 0 c-32 0 -35 2 -35 30 0 21 10 39 33 60 17 16 33 30 35 30 1 0 2 -27 2 -60z m-110 -30 l0 -30 -250 0 -250 0 0 30 0 30 250 0 250 0 0 -30z m-479 -80 c18 -10 19 -23 19 -174 0 -137 -3 -166 -16 -177 -11 -9 -20 -10 -32 -2 -14 8 -18 34 -22 149 l-5 139 -120 5 -120 5 -3 33 -3 32 141 0 c78 0 150 -5 161 -10z m757 -22 l-3 -33 -120 -5 -120 -5 -5 -139 c-4 -115 -8 -141 -22 -149 -12 -8 -21 -7 -32 2 -13 11 -16 40 -16 177 0 145 2 164 18 173 9 6 81 11 160 11 l143 0 -3 -32z m-468 -328 c0 -6 -27 -10 -60 -10 -33 0 -60 4 -60 10 0 6 27 10 60 10 33 0 60 -4 60 -10z"/>
                        </g>
                    </svg>
                </div>
                <div class='text-card-immigration'>
                    <h3>
                        خدمات تخصصی مشاوره
                    </h3>
                    <p>
                        مشاوره وقت سفارت و مصاحبه ویزا
                    </p>
                </div>
            </div>
            <div class='immigration-card-item'>
                <div class='icon-card-immigration'>
                    <svg class='svg-box-three' xmlns="http://www.w3.org/2000/svg" version="1.0" width="128.000000pt" height="128.000000pt" viewBox="0 0 128.000000 128.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,128.000000) scale(0.100000,-0.100000)"  stroke="none">
                            <path d="M20 1260 c-20 -20 -20 -33 -20 -620 0 -587 0 -600 20 -620 19 -19 33 -20 470 -20 439 0 451 1 470 20 19 19 20 31 18 148 -3 105 -6 127 -18 127 -12 0 -16 -21 -18 -114 -1 -64 -8 -121 -14 -128 -15 -18 -858 -19 -876 -1 -17 17 -17 1159 0 1176 17 17 859 17 876 0 9 -9 12 -72 12 -220 0 -201 1 -208 20 -208 19 0 20 7 20 220 0 207 -1 221 -20 240 -19 19 -33 20 -470 20 -437 0 -451 -1 -470 -20z"/>
                            <path d="M197 1143 c-12 -11 -8 -98 5 -111 9 -9 87 -12 289 -12 240 0 278 2 290 16 10 13 10 17 -2 25 -8 5 -135 9 -282 9 -250 0 -268 1 -265 18 3 16 27 17 278 22 236 4 275 7 275 20 0 13 -40 15 -291 18 -160 1 -293 -1 -297 -5z"/>
                            <path d="M1166 995 c-13 -14 -28 -25 -34 -25 -6 0 -21 -19 -34 -42 -17 -32 -30 -43 -47 -43 -28 0 -38 -19 -21 -40 10 -12 -4 -43 -74 -163 -48 -82 -98 -178 -111 -213 -14 -35 -33 -77 -41 -92 -10 -18 -14 -40 -10 -58 4 -21 -1 -35 -17 -55 l-23 -26 -13 26 c-16 28 -57 36 -79 14 -9 -9 -12 -2 -12 34 0 54 -28 85 -61 68 -23 -13 -83 -190 -69 -204 16 -16 35 12 61 89 l23 70 6 -45 c7 -56 15 -70 44 -70 12 0 28 6 35 13 11 10 14 9 18 -1 7 -19 33 -42 48 -42 7 0 29 18 49 40 20 22 45 40 56 40 31 0 145 151 244 324 61 106 93 153 102 149 23 -8 17 -29 -32 -114 -34 -58 -44 -83 -36 -91 17 -17 36 4 82 87 45 81 50 115 19 144 l-20 19 23 43 c13 24 23 53 24 64 0 11 4 32 8 48 19 66 -60 104 -108 52z m69 -25 c3 -5 2 -17 -2 -25 -8 -13 -12 -13 -27 -2 -11 8 -16 19 -12 25 9 15 33 16 41 2z m-47 -67 c15 -9 28 -18 30 -19 2 -1 -7 -18 -18 -38 -21 -35 -22 -35 -50 -21 -40 20 -43 30 -25 65 18 35 26 36 63 13z m-67 -110 c16 -10 29 -20 29 -24 0 -10 -161 -289 -167 -289 -12 0 -63 35 -63 44 0 5 12 30 27 55 95 165 135 231 140 231 2 0 18 -8 34 -17z m-161 -353 c0 -17 -58 -60 -73 -54 -20 7 -21 17 -5 60 l11 32 34 -16 c18 -9 33 -19 33 -22z m-90 -95 c14 -16 6 -35 -16 -35 -8 0 -14 10 -14 25 0 28 12 32 30 10z"/>
                            <path d="M260 960 c0 -19 7 -20 230 -20 223 0 230 1 230 20 0 19 -7 20 -230 20 -223 0 -230 -1 -230 -20z"/>
                            <path d="M344 819 c-15 -25 22 -29 257 -27 223 3 244 4 247 21 3 16 -14 17 -247 17 -169 0 -252 -4 -257 -11z"/>
                            <path d="M155 689 c-16 -25 20 -29 236 -27 191 3 224 5 224 18 0 13 -33 15 -227 18 -157 2 -229 -1 -233 -9z"/>
                            <path d="M664 689 c-13 -22 15 -30 97 -27 70 3 84 6 87 21 3 15 -6 17 -87 17 -54 0 -93 -4 -97 -11z"/>
                            <path d="M163 593 c-18 -7 -16 -30 3 -37 24 -9 207 -7 223 3 8 5 11 16 8 25 -5 13 -24 16 -114 15 -59 0 -114 -3 -120 -6z"/>
                            <path d="M453 584 c-9 -24 15 -34 89 -34 74 0 98 6 98 25 0 19 -24 25 -106 25 -59 0 -76 -3 -81 -16z"/>
                            <path d="M217 440 c-193 -61 -155 -349 46 -350 89 0 155 48 177 132 10 34 9 43 -4 56 -13 14 -16 12 -27 -14 -31 -80 -41 -96 -71 -114 -116 -71 -255 59 -193 180 33 64 126 91 194 55 16 -8 31 -11 35 -8 36 37 -86 86 -157 63z"/>
                            <path d="M303 288 l-43 -42 -29 28 c-27 26 -51 28 -51 5 0 -20 59 -69 82 -69 31 0 113 82 105 104 -9 24 -18 20 -64 -26z"/>
                        </g>
                    </svg>
                </div>
                <div class='text-card-immigration'>
                    <h3>
                        خدمات مدارک ویزا
                    </h3>
                    <p>
                        راهنمایی تخصصی، تکمیل فرم درخواست و مدارک ویزا
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{assign var="data_search_blog" value=[
'service'=>'Visa',
'section'=>'mag',
'origin'=>"`$visa['countryCode']`",
'secondary'=>"`$visa['visaTypeID']`"
]}

{assign var="data_search_faq" value=[
'service'=>'Visa',
'origin'=>"`$visa['countryCode']`",
'secondary'=>"`$visa['visaTypeID']`"
]}

{assign var='articles' value=$obj_articles->getByPosition($data_search_blog)}
{assign var='faqs' value=$obj_faqs->getByPosition($data_search_faq)}

{if !empty($articles) }
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`modules/immigration/article.tpl" articles=$articles title='مقالات ویژه'}
{/if}
{if !empty($faqs) }
{include file="`$smarty.const.FRONT_CURRENT_CLIENT`faqs.tpl"
service='Visa'
origin="`$visa['countryCode']`"
type="`$visa['visaTypeID']`"
}
{/if}





    <form method="post" action="" name="visaForm" id="visaForm">
        <input type="hidden" name="adultQty" id="adultQty" value="1"/>
        <input type="hidden" name="childQty" id="childQty" value="0"/>
        <input type="hidden" name="infantQty" id="infantQty" value="0"/>
        <input type="hidden" name="visa_type" id="visa_type" value="{$visa['visaTypeID']}"/>
        <input type="hidden" name="distination_code" id="distination_code" value="{$smarty.const.IMMIGRATION_COUNTRY}"/>
        <input type="hidden" name="visaID" id="visaID" value="{$smarty.const.IMMIGRATION_ID}"/>
        <input type="hidden" name="CurrencyCode" class="CurrencyCode" value='{$objSession->getCurrency()}'/>
    </form>

<script src="assets/modules/js/immigration.js"></script>