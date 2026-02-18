{load_presentation_object filename="bookshow" assign="objbook"}

{assign var="infoBook" value=$objbook->info_flight_directions($smarty.post.factorNumber)}

{if $smarty.const.CLIENT_ID eq '314'}
    {load_presentation_object filename="functions" assign="objFunctions"}
    {assign var="filename" value="`$smarty.post.factorNumber`_log_white_label"}
    {$objFunctions->insertLog({$smarty.post|json_encode},$filename)}
    {assign var="filename" value="`$smarty.post.factorNumber`_log_white_label_response"}
    {$objFunctions->insertLog({$infoBook|json_encode},$filename)}
    {assign var="filename" value="`$smarty.post.factorNumber`_log_white_label_object"}
    {$objFunctions->insertLog({$objBookingLocal|json_encode},$filename)}
{/if}

{if $smarty.post.successPayment eq true}
    {if $smarty.post.type_ticket eq 'success'}
        {assign var="statusBook" value=false}
        {assign var="statusBookDept" value=false}
        {assign var="statusBookReturn" value=false}
        {if ($infoBook[0]['successfull'] eq 'book') && ($infoBook[1]['successfull'] eq '')}
            {$statusBook= true}
            {$statusBookDept= true}
        {elseif ($infoBook[0]['successfull'] eq 'book') || ($infoBook[1]['successfull'] eq 'book')}
            {$statusBook= true}
            {if $infoBook[0]['successfull'] eq 'book' }
                {$statusBookDept= true}
            {elseif $infoBook[1]['successfull'] eq 'book'}
                {$statusBookReturn= true}
            {/if}
        {/if}

        {if $statusBook}
            <div class="return-bank-box">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mr-auto ml-auto d-flex justify-content-center">
                            <div class="successful-flight-booking-box">
                                <!-- Success Icon -->
                                <div class="success-icon">
                                    <div class="icon-circle">
                                        <i class="fa-regular fa-ticket"></i>
                                    </div>
                                </div>

                                <!-- Success Message -->
                                <h2 class="success-title">##Successpayment##</h2>
                                <p class="success-subtitle">##SuccessMessageRetrunBank##</p>

                                <!-- Transaction Details -->
                                <div class="transaction-details">
                                    <div class="detail-row">
                                        <span class="detail-label">{if $smarty.post.paymentType eq 'cash'}##Agentbank##{else}##Typepayment##{/if}</span>
                                        <span class="detail-value">{if $smarty.post.paymentType eq 'cash'}{$paymentBank}{else}##Credit##{/if}</span>
                                    </div>

                                    <div class="detail-row">
                                        <span class="detail-label">##Invoicenumber##</span>
                                        <span class="detail-value">{$infoBook[0]['factor_number']}</span>
                                    </div>

                                    {if $smarty.post.paymentType eq 'cash'}
                                        <div class="detail-row">
                                            <span class="detail-label">##TrackingCode##</span>
                                            <span class="detail-value">{$smarty.post.bankTrackingCode}</span>
                                        </div>
                                    {/if}

                                    <div class="detail-row">
                                        <span class="detail-label">##Buydate##</span>
                                        <span class="detail-value">{$objFunctions->set_date_payment($infoBook[0]['payment_date'])}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="action-buttons">
                                    {foreach $infoBook as $bookFlight}
                                        {if isset($infoBook[1])}
                                            {if $statusBookDept eq true || $statusBookReturn eq true}
                                                <!-- دکمه دانلود PDF -->
                                                {if $bookFlight['IsInternal'] eq '1'}
                                                    {if $bookFlight['api_id'] eq '14' && $bookFlight['direction'] eq 'TwoWay'}
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=TicketTwoWay&id={$bookFlight['request_number']}"
                                                           class="btn-click btn-pdf" target="_blank">
                                                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                            ##Printticket##
                                                        </a>
                                                    {else}
                                                        <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=parvazBookingLocal&id={$bookFlight['request_number']}"
                                                           class="btn-click btn-pdf" target="_blank">
                                                            <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                            ##Printticket##
                                                        </a>
                                                    {/if}
                                                {else}
                                                    <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=ticketForeign&id={$bookFlight['request_number']}"
                                                       class="btn-click btn-pdf" target="_blank">
                                                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        ##PdfFile##
                                                    </a>
                                                {/if}

                                                <!-- دکمه چاپ رسید -->
                                                <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=boxCheck&id={$bookFlight['request_number']}"
                                                   class="btn-click btn-receipt" target="_blank">
                                                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                    </svg>
                                                    ##BoxCheck##
                                                </a>
                                            {else}
                                                <!-- پیام نیاز به زمان بیشتر -->
                                                {assign value="" var="type_direction_flight"}
                                                {if $bookFlight['direction'] eq 'dept'}
                                                    {$type_direction_flight='##Wentflight##'}
                                                {else}
                                                    {$type_direction_flight='##Returnflight##'}
                                                {/if}
                                                <div class="alert-message">
                                                    برای رزرو پرواز {$type_direction_flight} به مدت زمان بیشتری نیاز هست
                                                </div>
                                            {/if}
                                        {else}
                                            <!-- حالت تک پرواز -->
                                            {if $bookFlight['IsInternal'] eq '1'}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=parvazBookingLocal&id={$bookFlight['request_number']}"
                                                   class="btn-click btn-pdf" target="_blank">
                                                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    ##Printticket##
                                                </a>
                                            {else}
                                                <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=ticketForeign&id={$bookFlight['request_number']}"
                                                   class="btn-click btn-pdf" target="_blank">
                                                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    ##PdfFile##
                                                </a>
                                            {/if}

                                            <a href="{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pdf&target=boxCheck&id={$bookFlight['request_number']}"
                                               class="btn-click btn-receipt" target="_blank">
                                                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                </svg>
                                                ##BoxCheck##
                                            </a>
                                        {/if}
                                    {/foreach}

                                    <!-- دکمه‌های اضافی که در همه حالات نمایش داده می‌شوند -->
                                    {foreach $infoBook as $bookFlight}
                                        {if $bookFlight['IsInternal'] eq '1'}
                                            <a href="{$smarty.const.ROOT_ADDRESS}/pdf&target=bookshow&id={$bookFlight['request_number']}"
                                               class="btn-click btn-english" target="_blank">
                                                ##PrintEnglishticket##
                                            </a>
                                        {/if}
                                        {break}
                                    {/foreach}
                                </div>

                                <!-- بخش کد تخفیف -->
                                {foreach $objBookingLocal->direction as $direction}
                                    {if $objBookingLocal->ok_flight[$direction] eq true}
                                        {$offCode = $objOffCode->offCodeUse($objBookingLocal->factor_num, $objBookingLocal->ticketInfo[$direction]['serviceTitle'], $objBookingLocal->ticketInfo[$direction]['desti_airport_iata'], $objBookingLocal->ticketInfo[$direction]['origin_airport_iata'])}
                                        {if $offCode neq ''}
                                            <div class="text-code-takhfif" style="margin-top: 20px; text-align: center; padding: 15px; background: #f0f9ff; border-radius: 8px;">
                                                {assign var='code' value=$offCode['code']}
                                                {assign var='title' value=$offCode['title']}
                                                کد تخفیف: {$code} - {$title}
                                            </div>
                                        {/if}
                                    {/if}
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        {else}
            <div class="main-bank-box">
                <div class="mbb-preload mbb-preload-icon-alert">
                    <img src="assets/images/pre-bank-red.png">
                </div>
                <h4 class="mbb-bank-title mbb-bank-title-red">
                    <span>##Note##</span>
                </h4>
                <div class="mbb-detail">
                    <div class="success-text-title style-mbb-bank-text">
                        <span>##dear_passenger##</span>
                        ##ProblemreservationTicket##
                        <span>##ProblemreservationTicket_description##</span>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <a target='_blank' href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}" class="mbb-bank-btn new-btn-coming-back">
                        <span>##Returntohome##</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"></path></svg>
                    </a>
                </div>

            </div>

        {/if}
    {else}
       <p class="d-none">
           {$objbook->changeFlagToPending(['factor_number'=>$infoBook[0]['factor_number']])}
       </p>
        <div class="main-bank-box">
            <div class="mbb-preload mbb-preload-icon-alert">
                <img src="assets/images/pre-bank-red.png">
            </div>
            <h4 class="mbb-bank-title mbb-bank-title-red">
                <span>##Note##</span>
            </h4>
            <div class="mbb-detail">
                <p class="clearfix txtCenter">
                    <span class="txtCenter">##ProblemreservationTicket##</span>
                </p>
            </div>
            <div class="d-flex align-items-center justify-content-center">
                <a target='_blank' href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}" class="mbb-bank-btn new-btn-coming-back">
                    <span>##Returntohome##</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"></path></svg>
                </a>
            </div>

        </div>
    {/if}

{else}
    <div class="main-bank-box">
        <div class="mbb-preload mbb-preload-icon-alert">
            <img src="assets/images/pre-bank-red.png">
        </div>
        <h4 class="mbb-bank-title mbb-bank-title-red">
            <span>##Note##</span>
        </h4>
        <div class="mbb-detail">
            <p class="clearfix txtCenter">
                <span class="txtCenter">##CancelPay##</span>
            </p>
        </div>
        <div class="d-flex align-items-center justify-content-center">
            <a target='_blank' href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}" class="mbb-bank-btn new-btn-coming-back">
                <span>##Returntohome##</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L143 409c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-95-95L488 280c13.3 0 24-10.7 24-24s-10.7-24-24-24L81.9 232l95-95c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z"></path></svg>
            </a>
        </div>

    </div>
{/if}
