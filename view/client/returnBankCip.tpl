{assign var='paymentType' value=''}
{assign var='paymentBank' value=''}
{assign var='bankTrackingCode' value=''}
{assign var='successPayment' value=''}
{assign var='errorPaymentMessage' value=''}
{assign var='offCode' value=''}
{load_presentation_object filename="bookCip" assign="objBook"}
{assign var="item" value= $objBook->getItem($smarty.post['requestNumber'])}

{if $smarty.post['flag'] !='credit'}
{*    {var_dump($smarty.post)}*}
{*    {var_dump($smarty.get)}*}
    {load_presentation_object filename="bank" assign="objBank"}
    {$objBank->initBankParams($smarty.get.bank)}
    {$objBank->executeBank('return')}
    {if $objBank->transactionStatus neq 'failed' && $objBank->trackingCode neq ''}
        {if $objBank->trackingCode eq 'member_credit'}
            {$paymentType = 'member_credit'}
        {else}
            {$paymentType = 'cash'}
            {$paymentBank = $objBank->bankTitle}
            {$bankTrackingCode = $objBank->trackingCode}
        {/if}
        {$successPayment = true}
    {else}
        {$successPayment = false}
        {$errorPaymentMessage = $objBank->failMessage}
    {/if}
    {assign var="infoReserve" value=['paymentType' => $paymentType, 'factorNumber' => $objBank->factorNumber,'trackingCode'=>$objBank->trackingCode,'successPayment'=>$successPayment
    ,'paymentBank'=>$paymentBank]}
    {assign var="factorNumber" value= $objBank->factorNumber}
    {var_dump($infoReserve)}
{else}
    {$paymentType='credit'}
    {assign var="factorNumber" value=$item[0]['factor_number']}
    {$successPayment = true}
    {assign var="infoReserve" value=['paymentType' => $paymentType, 'factorNumber' => $factorNumber,'trackingCode'=>'','successPayment'=>$successPayment
    ,'paymentBank'=>'']}
{/if}


{if $successPayment eq true}

    <div class="row bank_box_row mx-auto">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 d-flex justify-content-center" >
            <div class="successful-flight-payment-box">
                <!-- Success Icon -->
                <div class="problem-icon">
                    <div class="icon-circle">
                        <span class="loader"></span>
                    </div>
                </div>
                <h2 class="problem-title">##messagePrepairFlight_success##</h2>

                <div class="transaction-details-problem">
                    <div class="detail-row">
                        <span class="detail-label">##messagePrepairFlight_button##</span>
                        <span class="detail-value">{$infoReserve.factorNumber}</span>
                    </div>
                    <p>##messagePrepairFlight_load##</p>
                </div>
            </div>
        </div>
    </div>
    <form id="SendDataToBookedTicket"></form>




{literal}
    <script type="text/javascript">
       window.onload =
          function () {

             let  successPayment = '{/literal}{$successPayment}{literal}'
             let  factorNumber = '{/literal}{$factorNumber}{literal}';

             console.log('successPayment: ' , successPayment)
             console.log('factorNumber: ' , factorNumber)

             let time_delay = 70000 ;
             // let time_delay = 1000 ;
             showDown(event);
             let request =
                $.ajax({
                   url: amadeusPath + 'ajax',
                   type: 'POST',
                   dataType: 'JSON',
                   data: JSON.stringify({
                      method: 'book',
                      className: 'bookCip',
                      factorNumber:factorNumber,
                      paymentType:'{/literal}{$infoReserve.paymentType}{literal}',
                      trackingCode:'{/literal}{$infoReserve.trackingCode}{literal}',
                      successPayment:'{/literal}{$infoReserve.successPayment}{literal}',
                      paymentBank:'{/literal}{$infoReserve.paymentBank}{literal}',
                   }),
                   success: function (response) {
                      console.log('response: ' , response)
                      createSuccessSection();
                   },
                   error: function (error) {
                      console.log('error: ' , error)
                      if (typeof error.responseJSON.code === 'undefined' || typeof error.responseJSON.code === null) {
                         createErrorSection(500);
                      } else {
                         createErrorSection(error.responseJSON.code);
                      }
                   }
                });

             setTimeout(function() {
                request.abort(); // If you want to abort the xhr which are still executing after 2 minutes

             }, time_delay );
             // Disable right mouse click Script
             document.onmousedown="if (event.button==2) return false";
             document.oncontextmenu=new Function("return false");
             document.onkeydown = showDown();
          }

       function showDown(evt) {
          evt = (evt) ? evt : ((event) ? event : null);
          if (evt) {
             if (event.keyCode === 8) {
// When backspace is pressed but not in form element
                cancelKey(evt);
             } else if (event.keyCode === 116) {
// When F5 is pressed
                cancelKey(evt);
             } else if (event.keyCode === 122) {
// When F11 is pressed
                cancelKey(evt);
             } else if (event.ctrlKey && (event.keyCode === 78 || event.keyCode === 82)) {
// When ctrl is pressed with R or N
                cancelKey(evt);
             } else if (event.altKey && event.keyCode === 37) {
// stop Alt left cursor
                return false;
             }
          }
       }

       function cancelKey(evt) {
          if (evt.preventDefault) {
             evt.preventDefault();
             return false;
          } else {
             evt.keyCode = 0;
             evt.returnValue = false;
          }
       }

       function homePage() {
          window.location.href = window.location.origin;
       }

       function createSuccessSection(){


          let  is_login = '{/literal}{$objSession->IsLogin()}{literal}';
          let element = $('.bank_box_row');

          let link_profile = `${amadeusPathByLang}Profile`;
          let link_tracking = `${amadeusPathByLang}UserBook`;


          let statement_error_login = `
<div class="error-flight-payment-box">
    <div class="problem-icon">
        <div class="icon-circle" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="fa-regular fa-ticket"></i>
        </div>
    </div>
    <h2 class="problem-title" style="color: #10b981;">${useXmltag('Successpayment')}</h2>
    <div class="transaction-details-problem">
        <p>${useXmltag('SuccessMessageRetrunBank')}</p>
    </div>
    <div class="action-buttons">
        <a href="${link_profile}" class="btn-click btn-pdf btn-pdf-success" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="fa-regular fa-user"></i>
            ${useXmltag('userAccount')}
        </a>
        <a href="javascript:" class="btn-click btn-receipt" onclick="homePage()">
            <i class="fa-regular fa-house"></i>
            ${useXmltag('OsafarHome')}
        </a>
    </div>
</div>
`;


          let statement_error_no_login = `

<div class="error-flight-payment-box">
    <div class="problem-icon">
        <div class="icon-circle">
            <i class="fa-regular fa-circle-exclamation"></i>
        </div>
    </div>
    <h2 class="problem-title">${useXmltag('BookingFailed')}</h2>
    <div class="transaction-details-problem">
        <p>${useXmltag('SuccessMessageRetrunBank')}</p>
    </div>
    <div class="action-buttons">
        <a href="${link_tracking}" class="btn-click btn-pdf">
            <i class="fa-regular fa-user"></i>
            ${useXmltag('TrackOrder')}
        </a>
        <a href="javascript:" class="btn-click btn-receipt" onclick="homePage()">
            <i class="fa-regular fa-house"></i>
            ${useXmltag('OsafarHome')}
        </a>
    </div>
</div>

`;

          let final_statement = (is_login) ? statement_error_login : statement_error_no_login ;
          let section_div_error = `
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 d-flex justify-content-center" >
                          ${final_statement}
                </div>
      `;

          element.html(section_div_error);

       }

       function createPendingSection(factor_number){


          let  is_login = '{/literal}{$objSession->IsLogin()}{literal}';
          let element = $('.bank_box_row');

          let link_profile = `${amadeusPathByLang}userBook`;
          let link_tracking = `${amadeusPathByLang}UserTracking`;

          let statement_pending_login = `


<div class="error-flight-payment-box">
    <div class="problem-icon">
        <div class="icon-circle bg-warning">
            <i class="fa-regular fa-arrows-rotate"></i>
        </div>
    </div>
    <h2 class="problem-title">${useXmltag('pendingFlight')}</h2>
    <p class="problem-subtitle">${useXmltag('moreTimeProcessFlight')}</p>
    <div class="transaction-details-problem">
        ${translateXmlByParams('messageProcessingFlight',{'paramProcess':'با ورود به حساب کاربری'})}
    </div>
    <div class="action-buttons">
        <a href="${link_profile}" class="btn-click btn-receipt">
            <i class="fa-regular fa-house btn-icon"></i>
            ${useXmltag('userAccount')}
        </a>
    </div>
</div>
`;


          let statement_pending_no_login = `
<div class="error-flight-payment-box">
    <div class="problem-icon">
        <div class="icon-circle bg-warning">
            <i class="fa-regular fa-arrows-rotate"></i>
        </div>
    </div>
    <h2 class="problem-title">${useXmltag('pendingFlight')}</h2>
    <p class="problem-subtitle">${useXmltag('moreTimeProcessFlight')}</p>
    <div class="transaction-details-problem">
        ${translateXmlByParams('messageProcessingFlight',{'paramProcess':'با ورود به حساب کاربری'})}
    </div>
    <div class="action-buttons">
        <a href="${link_tracking}" class="btn-click btn-receipt">
            <i class="fa-regular fa-house btn-icon"></i>
            ${useXmltag('TrackOrder')}
        </a>
    </div>
</div>
`;

          let final_statement = (is_login) ? statement_pending_login : statement_pending_no_login ;
          let section_div_pending = `
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 " >
                    <div class="main-bank-box">
                        <div class="mbb-preload mbb-preload-time">
                            <img src="assets/images/pre-bank.png">
                        </div>
                        <div class="mbb-bank-time">
                          ${final_statement}
                        </div>
                    </div>
                </div>
      `;

          element.html(section_div_pending);


          $.ajax({
             url: amadeusPath + 'ajax',
             type: 'POST',
             dataType: 'JSON',
             data: JSON.stringify({
                method: 'changeFlagToPending',
                className: 'bookshow',
                factor_number:factor_number,
             }),
             success: function (response) {

             }
          });


       }

       function createErrorSection(errorCode){


          let  is_login = '{/literal}{$objSession->IsLogin()}{literal}';
          let element = $('.bank_box_row');

          let link_profile = `${amadeusPathByLang}Profile`;
          let link_tracking = `${amadeusPathByLang}UserBook`;

          let errorMessage;
          if (errorCode == 500) {
             errorMessage = useXmltag('unexpectedErrorFlight');
          } else if(errorCode == 403) {
             errorMessage = useXmltag('recurringBooking');
          } else if (errorCode == 400) {
             errorMessage = useXmltag('errorFlight');
          } else {
             errorMessage = useXmltag('unexpectedErrorFlight');
          }

          let statement_error_login = `


<div class="error-flight-payment-box">
    <div class="problem-icon">
        <div class="icon-circle">
            <i class="fa-regular fa-circle-exclamation"></i>
        </div>
    </div>
    <h2 class="problem-title">${useXmltag('BookingFailed')}</h2>
    <div class="transaction-details-problem">
        <p>${errorMessage}</p>
    </div>
    <div class="action-buttons">
        <a href="${link_profile}" class="btn-click btn-pdf">
            <i class="fa-regular fa-user"></i>
            ${useXmltag('userAccount')}
        </a>
        <a href="javascript:" class="btn-click btn-receipt" onclick="homePage()">
            <i class="fa-regular fa-house"></i>
            ${useXmltag('OsafarHome')}
        </a>
    </div>
</div>

`;


          let statement_error_no_login = `

<div class="error-flight-payment-box">
    <div class="problem-icon">
        <div class="icon-circle">
            <i class="fa-regular fa-circle-exclamation"></i>
        </div>
    </div>
    <h2 class="problem-title">${useXmltag('BookingFailed')}</h2>
    <div class="transaction-details-problem">
        <p>${errorMessage}</p>
    </div>
    <div class="action-buttons">
        <a href="${link_tracking}" class="btn-click btn-pdf">
            <i class="fa-regular fa-user"></i>
            ${useXmltag('TrackOrder')}
        </a>
        <a href="javascript:" class="btn-click btn-receipt" onclick="homePage()">
            <i class="fa-regular fa-house"></i>
            ${useXmltag('OsafarHome')}
        </a>
    </div>
</div>

`;

          let final_statement = (is_login) ? statement_error_login : statement_error_no_login ;
          let section_div_error = `
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padr0 padl0 marb40 d-flex justify-content-center" >
                          ${final_statement}
                </div>
      `;

          element.html(section_div_error);

       }
    </script>

    <style>
        .error-flight-payment-box .action-buttons .btn-pdf-success:hover {
            box-shadow: 0 6px 20px #10b981;
        }
    </style>
{/literal}


{else}
    <!--
    <div class="return-bank-box">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mr-auto ml-auto">
                    <div class="return-bank-inner return-error">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="success-icon">
                                    <?xml version="1.0" encoding="iso-8859-1"?>
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 507.2 507.2" style="enable-background:new 0 0 507.2 507.2;"
                                         xml:space="preserve">
                                    <circle style="fill:#F15249;" cx="253.6" cy="253.6" r="253.6"/>
                                        <path style="fill:#AD0E0E;"
                                              d="M147.2,368L284,504.8c115.2-13.6,206.4-104,220.8-219.2L367.2,148L147.2,368z"/>
                                        <path style="fill:#FFFFFF;" d="M373.6,309.6c11.2,11.2,11.2,30.4,0,41.6l-22.4,22.4c-11.2,11.2-30.4,11.2-41.6,0l-176-176
                                        c-11.2-11.2-11.2-30.4,0-41.6l23.2-23.2c11.2-11.2,30.4-11.2,41.6,0L373.6,309.6z"/>
                                        <path style="fill:#D6D6D6;" d="M280.8,216L216,280.8l93.6,92.8c11.2,11.2,30.4,11.2,41.6,0l23.2-23.2c11.2-11.2,11.2-30.4,0-41.6
                                        L280.8,216z"/>
                                        <path style="fill:#FFFFFF;" d="M309.6,133.6c11.2-11.2,30.4-11.2,41.6,0l23.2,23.2c11.2,11.2,11.2,30.4,0,41.6L197.6,373.6
                                        c-11.2,11.2-30.4,11.2-41.6,0l-22.4-22.4c-11.2-11.2-11.2-30.4,0-41.6L309.6,133.6z"/>
                                    </svg>

                                </div>
                                <div class="success-text">
                                    <div class="success-text-title">##Note##</div>
                                    <div class="success-text-info">
                                        {if $smarty.post}
                                        <p>{$smarty.post.errorPaymentMessage}</p>
                                        {else}
                                        <p>##CancelPay##</p>
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
-->
    <div class="error-flight-payment-box">
        <!-- Success Icon -->
        <div class="problem-icon">
            <div class="icon-circle">
                <i class="fa-regular fa-circle-exclamation"></i>
            </div>
        </div>
        <h2 class="problem-title">##errorPaymentFlight##</h2>
        <div class="transaction-details-problem">
            {if $smarty.post}
                <p>{$smarty.post.errorPaymentMessage}</p>
            {else}
                <p>##CancelPay##</p>
            {/if}
        </div>
        <div class="action-buttons">
            <a href="{$smarty.const.SERVER_HTTP}{$smarty.const.CLIENT_DOMAIN}" class="btn-click btn-receipt">
                <i class="fa-regular fa-house btn-icon"></i>
                ##Home##
            </a>
        </div>
    </div>
{/if}