$(document).ready(function(){
    var numberOfMonthsResponsive;
    if ($(window).width() < 992) {
        numberOfMonthsResponsive = 1;
    } else {
        numberOfMonthsResponsive = 2;
    }
    var initialInfo={};
    var citeisDept;
    var citeisArrival;
    var next = '';
    var prev = '';
    var storedFlightInfo = {};
    var flightsFlagg = 1;
    var resultInit;
    var result = {};
    var Advertises = [];
    var allCurrency ;
    var currencyInfo;
    var isCurrency;
    // var currencyTypFlag ='0';
    allCurrency = JSON.parse(localStorage.getItem("allCurrency"));
    var logo = localStorage.getItem("logo");
    var url = window.location.href;
    var rootMain = url.split("/");
    var rootMainPath = rootMain[0];

    //-------------------------------------------------------------------

    $('body').on('click', '.s-u-filter-title', function () {
        $(this).parent().find('.s-u-filter-content').slideToggle();
        $(this).parent().toggleClass('hidden_filter');
    })
    $('body').delegate('.DetailSelectTicket', 'click', function () {
        $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast');
    });

    $('body').delegate(".slideDownAirDescription", "click", function () {
        $(this).parents('.international-available-details').find(".international-available-panel-min").addClass("international-available-panel-max");
        $(this).parents('.international-available-details').find('.slideUpAirDescription').removeClass("displayiN");
        $(this).parents('.international-available-details').find('.dital-row-visa').removeClass('displayiN');
    });

    $('body').delegate(".slideUpAirDescription", "click", function () {
        $(this).addClass("displayiN");
        $(this).parents('.international-available-details').find(".international-available-panel-min").removeClass("international-available-panel-max");
        $(this).parents('.international-available-details').find('.dital-row-visa').addClass('displayiN');
        $(this).parents('.international-available-details').find('.international-available-detail-btn.more_1').removeClass('displayiN');
    });

    $('.silence_span').removeClass('ph-item2').html($('.row-visa').length + ' ' + useXmltag("NumberFlightFound"));
    $('.slideDownHotelDescription').click(function () {
        $(this).parents('.row-visa').find('.dital-row-visa').toggleClass('displayiN');
        $(this).parents('.row-visa').find('.dital-row-visa').find('p').css({'font-family': 'inherit'});
        $(this).parents('.row-visa').find('.dital-row-visa').find('p *').css({'font-family': 'inherit'});
        $(this).toggleClass('displayiN');
        $('.slideUpHotelDescription').toggleClass('displayiN');
    });
    $('.slideUpHotelDescription').click(function () {
        $(this).parents('.row-visa').find('.dital-row-visa').toggleClass('displayiN');
        $(this).toggleClass('displayiN');
        $('.slideDownHotelDescription').toggleClass('displayiN');
    });
    $('body').delegate(".slideDownHotelDescription", "click", function () {
        $(this).siblings().find(".international-available-panel-min").addClass("international-available-panel-max");
        $(".international-available-item-right-Cell").addClass("my-slideup");
        $(".international-available-item-left-Cell").addClass("my-slideup");
    });
    $('body').delegate(".slideUpHotelDescription", "click", function () {
        $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");

    });
    $('body').delegate(".my-slideup", "click", function () {
        $(this).siblings().find(".international-available-panel-min").removeClass("international-available-panel-max");

    });
    $('body').delegate('ul.tabs li', "click", function () {
        $(this).siblings().removeClass("current");
        $(this).parent("ul.tabs").siblings(".tab-content").removeClass("current");
        var tab_id = $(this).attr('data-tab');
        $(this).addClass('current');
        $(this).parent("ul.tabs").siblings("#" + tab_id).addClass("current");
    });
    $('body').delegate(".plus", "click", function () {
        var idplus = $(this).attr('id');
        var value;
        if(idplus === 'add1'){
            value = 1;
        }else if(idplus === 'add2'){
            value = 2;
        }else{
            value = 3;
        }
        var currentVal = parseInt($("#qty" + value).val());
        if (!isNaN(currentVal)) {
            $("#qty" + value).val(currentVal + 1);
        }
    });
    $('body').delegate(".minus", "click", function () {
        var idplus = $(this).attr('id');
        var value;
        if(idplus === 'minus1'){
            value = 1;
        }else if(idplus === 'minus2'){
            value = 2;
        }else{
            value = 3;
        }
        var currentVal = parseInt($("#qty" + value).val());
        if (!isNaN(currentVal)) {
            if (currentVal > 0) {
                $("#qty" + value).val(currentVal - 1);
            }
        }
    });
    //change currency
    $('body').on('click','.currency-gds',function (){
        $(this).find('.change-currency').toggle();
        if ($(".currency-inner .currency-arrow").hasClass("currency-rotate")) {
            $( ".currency-inner .currency-arrow" ).removeClass('currency-rotate');
        } else {
            $( ".currency-inner .currency-arrow" ).addClass('currency-rotate');
        }
    })

    var elem = document.getElementById("myBar");
    // datepicker after ajax call

    $("body").on("click", ".gregorianDeptCalendar", function () {
        if (!$(this).hasClass("hasDatepicker")) {
            var dateToday = new Date();
            var dateToday2 = $("#dept_date_local").val();
            $(this).datepicker({
                regional: '',
                numberOfMonths: 2,
                minDate: 'Y/M/D',
                showButtonPanel: !0,
                onSelect: function(dateText){
                    $(".gregorianReturnCalendar").datepicker('option', 'minDate', dateText);
                }
            });

            $(this).datepicker("show");
        }


    });
    $("body").on("click", ".gregorianReturnCalendar", function () {
        if (!$(this).hasClass("hasDatepicker")) {
            var dateToday = new Date();
            var dateToday2 = $("#dept_date_local").val();
            $(this).datepicker({
                regional: '',
                numberOfMonths: 2,
                minDate: $('.gregorianDeptCalendar').val(),
                showButtonPanel: !0,
                beforeShow: function(n) {
                    e(n, !0);
                    $("#ui-datepicker-div").addClass("INH_class_Datepicker")
                }
            });

            $(this).datepicker("show");
        }


    });
    $("body").on("click", ".shamsiOnlyDeptCalendar", function () {
        if (!$(this).hasClass("hasDatepicker")) {
            var dateToday = new Date();
            var dateToday2 = $("#dept_date_local").val();
            $(this).datepicker({
                onSelect: function(dateToday2){
                    dateToday2 = $("#dept_date_local").val();
                    $(".shamsiOnlyReturnCalendar.hasDatepicker").datepicker('option', 'minDate', dateToday2);

                },
                showOtherMonths: true,
                selectOtherMonths: true,
                numberOfMonths:numberOfMonthsResponsive,
                defaultDate: "+1w",
                minDate: dateToday,
                setDate:dateToday,
                showButtonPanel: true
            });

            $(this).datepicker("show");
        }


    });
    $("body").on("click", ".shamsiOnlyReturnCalendar", function () {
        if (!$(this).hasClass("hasDatepicker")) {
            var dateToday2 = $("#dept_date_local").val();

            $(this).datepicker({

                showOtherMonths: true,
                selectOtherMonths: true,
                numberOfMonths:2,
                defaultDate: "+1w",
                minDate: $('.shamsiOnlyDeptCalendar').val(),
                setDate:dateToday2,
                showButtonPanel: true,
                rootMainPath:rootMainPath

            });

            $(this).datepicker("show");

        }

    });
    //-------------------------------------------------
   dateRout2().then(function (response) {
       initialInfo = JSON.parse(localStorage.getItem("initialInfo"));
       currencyInfo = JSON.parse(localStorage.getItem("currencyInfo"));
       isCurrency = JSON.parse(localStorage.getItem("isCurrency"));
/*
       if (!currencyInfo) {
           currencyTypFlag = '0';
       } else {
           currencyTypFlag = currencyInfo.CurrencyCode;
       }
*/

       Vue.component('my-alert', {

           template: `

<div>
    <div id="loader-page" class="lazy-loader-parent ">
          <div class="loader-page container site-bg-main-color">
              <div class="parent-in row">
                   
                    <div class="loader-txt">
                      <div id="flight_loader">
                          <span class="loader-date">
                            
                      %%initialInfo?.dataSearch?.DateFlightWithName%%
                    
                          </span>
                        <div class="wrapper">
                        
                          <div class="locstart"></div>
                          <div class="flightpath">
                            <div class="airplane"></div>
                          </div>
                          <div class="locend"></div>
                        </div>
                      </div>
<!--                          <div class="logo-img">
                          <img  v-bind:src="logo" alt="logo" class="logo-icon">
                                </div>-->
                        
                          <div class="loader-distinc">
                           
                          ${useXmltag('Searching')}
                          ${useXmltag('Flight')}
                          
                             ${useXmltag('From')}
                           <span>
                             %%initialInfo?.dataSearch?.NameDeparture%%
                            </span>
                              ${useXmltag('On')}
                            <span>
                             %%initialInfo?.dataSearch?.NameArrival%%
                            </span>
                            ${useXmltag('ForYou')}
                        </div>   
                    </div>
                   
                   <!-- <div class="wrapper2"></div>
                      <div class="marquee"><p>لطفا منتظر بمانید...</p></div>-->
              </div>
           
          </div>
    </div>
   <div class="s-u-black-container"></div>
   <div  class="row">  
 
      <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 parvaz-sidebar col-padding-5" v-model="initialInfo">
         <div class="parent_sidebar">
          <div v-if="isCurrency" class="currency-gds">
            <div v-if="currencyTypFlag != 0 " class="currency-inner DivDefaultCurrency">           
                <img v-bind:src="rootMainPath + '/gds/pic/flagCurrency/'+ currencyInfo?.CurrencyFlag" alt="" id="IconDefaultCurrency">
                <span class="TitleDefaultCurrency">%%currencyInfo?.CurrencyTitleFa%%</span>
                <span class="currency-arrow"></span>
            </div>            
            <div  v-if="currencyTypFlag  == 0" class="currency-inner DivDefaultCurrency"> 
                <img v-bind:src="rootMainPath+ '/gds/pic/flagCurrency/Iran.png'" alt="kk" id="IconDefaultCurrency">
                <span class="TitleDefaultCurrency">${useXmltag('IranianRial')}</span>
                <span class="currency-arrow"></span>
            </div>
            <div v-if="flights && flights.length > 0" class="change-currency">
                <div class="change-currency-inner">
                    <div class="change-currency-item main" v-on:click="ConvertCurrency('0','Iran.png','ریال ایران')">
                        <img v-bind:src="rootMainPath+'/gds/pic/flagCurrency/Iran.png'" alt="hh">
                        <span>${useXmltag('Iran')}</span>
                    </div>                                    
                    <div v-for="Currency in allCurrency" class="change-currency-item" v-on:click="ConvertCurrency(Currency?.CurrencyCode,Currency?.CurrencyFlag,Currency?.CurrencyTitle)">
                        <img v-bind:src="rootMainPath+'/gds/pic/flagCurrency/'+Currency?.CurrencyFlag" alt="">
                        <span>%%Currency?.CurrencyTitle%%</span>
                    </div>                                  
                </div>           
            </div>
         </div>   
         <div class="filter_airline_flight">
            <div class="filtertip parvaz-filter-change site-bg-main-color site-bg-color-border-bottom ">
               <!--<div  v-if="initialInfo?.MultiWay == 'TwoWay'" >                                            
                  <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
                  <span class="tooltiptextWeightDay">${useXmltag('Previousday')}</span>
                  <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color">
                  </i>
                  </span>
               </div> -->
               <a  v-if="initialInfo?.MultiWay == 'OneWay'"  v-bind:href="urlPrevNewUrl" v-on:click="prevDayVue()">                                            
               <span class=" chooseiconDay icons tooltipWeighDay right site-border-text-color">
               <span class="tooltiptextWeightDay">${useXmltag('Previousday')}</span>
               <i class="zmdi zmdi-chevron-right iconDay site-secondary-text-color">
               </i>
               </span>
               </a>
               <div class="tip-content">
                  <p class="">
                     <span class=" bold counthotel" v-text="initialInfo?.dataSearch?.NameDeparture"></span>
                     ${useXmltag('On')}
                     <span class=" bold counthotel" v-text="initialInfo?.dataSearch?.NameArrival"></span>
                  </p>
                  <p class="counthotel " v-text="initialInfo?.dataSearch?.DateFlightWithName"></p>
                  <div class="silence_span" v-if="arrFlights?.dept?.resultFlight.length > 0" >%%arrFlights?.dept?.resultFlight.length%% 
                     ${useXmltag('NumberFlightFound')}
                  </div>
               </div>
             <!-- <div v-if="initialInfo?.MultiWay == 'TwoWay'">                                
                  <span class=" chooseiconDay icons tooltipWeighDay left site-border-text-color">
                  <span class="tooltiptextWeightDay">${useXmltag('Nextday')}</span>
                  <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                  </i>
                  </span>
               </div> -->
               <a v-if="initialInfo?.MultiWay == 'OneWay'" v-bind:href="urlNextNewUrl" v-on:click="nextDayVue()">
                   <span class=" chooseiconDay icons tooltipWeighDay left site-border-text-color">
                   <span class="tooltiptextWeightDay">${useXmltag('Nextday')}</span>
                   <i class="zmdi zmdi-chevron-left iconDay site-secondary-text-color">
                   </i>
                   </span>
               </a>
               <div class="open-sidebar-parvaz " onclick="showSearchBoxTicket()">${useXmltag('ChangeSearchType')}</div>
            </div>
            <!-- search box -->                            
            <div class=" s-u-update-popup-change">
               <form class="search-wrapper" action="" method="post">
                  <div class="displayib padr20 padl20" >
                    <div class="ways_btns">

                        <div  onclick="changeWays_('Oneway')" v-on:click="changeWaysVue()"  class="radiobtn Oneway">
    
                            <input type="radio" id="huey" name="drone" value="huey">
                            <label class=" site-bg-main-color-before" for="huey">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(-1,-1.2246467991473532e-16,1.2246467991473532e-16,-1,512,512)">
                                        <g xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20    c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285    l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018    l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z" style="" class=""></path>
                                            </g>
                                        </g>
                                    </g>
                            </svg>
                                ${useXmltag('Oneway')}
                            </label>
                        </div>
                        <div  onclick="changeWays_('Twoway')" v-on:click="changeWaysVue()" class="radiobtn Twoway">
                            <input type="radio" id="dewey" name="drone" value="dewey" >
                            <label class="site-bg-main-color-before" for="dewey">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" version="1.1" x="0" y="0" viewBox="0 0 907.62 907.619" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
                                        <g xmlns="http://www.w3.org/2000/svg">
                                            <path d="M591.672,907.618c28.995,0,52.5-23.505,52.5-52.5V179.839l42.191,41.688c10.232,10.11,23.567,15.155,36.898,15.155   c13.541,0,27.078-5.207,37.347-15.601c20.379-20.625,20.18-53.865-0.445-74.244L626.892,15.155C617.062,5.442,603.803,0,589.993,0   c-0.104,0-0.211,0-0.314,0.001c-13.923,0.084-27.244,5.694-37.03,15.6l-129.913,131.48c-20.379,20.625-20.18,53.865,0.445,74.244   c20.626,20.381,53.866,20.181,74.245-0.445l41.747-42.25v676.489C539.172,884.113,562.677,907.618,591.672,907.618z"></path>
                                            <path d="M315.948,0c-28.995,0-52.5,23.505-52.5,52.5v676.489l-41.747-42.25c-20.379-20.625-53.62-20.825-74.245-0.445   c-20.625,20.379-20.825,53.619-0.445,74.244l129.912,131.479c9.787,9.905,23.106,15.518,37.029,15.601   c0.105,0.001,0.21,0.001,0.315,0.001c13.81,0,27.07-5.442,36.899-15.155L484.44,760.78c20.625-20.379,20.824-53.619,0.445-74.244   c-20.379-20.626-53.62-20.825-74.245-0.445l-42.192,41.688V52.5C368.448,23.505,344.943,0,315.948,0z" style=""></path>
                                        </g>
                                    </g>
                                </svg>
                                ${useXmltag('Twoway')}
                                </label>
                        </div>
    
                    </div>
                  
                  
                  </div>  
                  <div class="d-flex flex-wrap align-items-center position-relative">             
                      <div class="s-u-form-block s-u-num-inp s-u-num-inp-change">
                         <div class="s-u-in-out-wrapper raft raft-change change-bor">
                            <select class="select2 option1 " name="origin" id="origin_local" style="width:100%;"
                               tabindex="2" :onchange="'select_Airport('+langWithQuote+')'" v-bind:title="initialInfo?.dataSearch?.NameDeparture">


                                <option  v-bind:value="initialInfo?.dataSearch?.origin" selected="selected" >
                                    %%initialInfo?.dataSearch?.NameDeparture%%(%%initialInfo?.dataSearch?.origin%%)
                                </option>
                                
                               <option :selected="initialInfo?.dataSearch?.origin == city['Departure_Code']" v-for="city in citeisDept" v-bind:value="city['Departure_Code']" >                                                                             
                                  %%city['Departure_CityByLanguage']%%(%%city['Departure_Code']%%)                                                     
                               </option>
                             
                            </select>
                         </div>
                      </div>
                      <div class="swap-flight-box" onclick="reversOriginDestination()">
                         <span class="swap-flight"><i class="zmdi zmdi-swap site-main-text-color"></i></span>
                      </div>
                      <div class="s-u-form-block s-u-num-inp s-u-num-inp-change bargasht bargasht-change change-bor">
                     <div class="s-u-in-out-wrapper ">

                    
                      
                        <select class="select2 option1 " name="destination" id="destination_local" style="width:100%;"
                           tabindex="2" v-bind:title="initialInfo?.dataSearch?.NameArrival">
                         
                           <option  v-bind:value="initialInfo?.dataSearch?.destination" selected="selected" >
                              %%initialInfo?.dataSearch?.NameArrival%%(%%initialInfo?.dataSearch?.destination%%)
                           </option>
                           <option :selected="initialInfo?.dataSearch?.destination == city['Arrival_Code']" v-for="city in citeisArrival" v-bind:value="city['Arrival_Code']">
                              %%city['Arrival_CityByLanguage']%%(%%city['Arrival_Code']%%)                                                       
                           </option>
                        </select>
                     </div>
                  </div>
                  </div> 
                  <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                     <div class="s-u-form-date-wrapper">
                        <div class="s-u-date-pick">
                           <div class="s-u-jalali s-u-jalali-change">
                              <i class="zmdi zmdi-calendar-note site-main-text-color"></i>
                              <input :class="(lang == 'fa')?'shamsiOnlyDeptCalendar':'gregorianDeptCalendar'" type="text" name="dept_date" id="dept_date_local" placeholder="${useXmltag('Wentdate')}" readonly="readonly" v-bind:value="initialInfo?.dataSearch?.departureDate">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div v-if="initialInfo?.MultiWay == 'OneWay'" class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 hidden" id="returnDate">
                     <div class="s-u-form-date-wrapper">
                        <div class="s-u-date-pick">
                           <div class="s-u-jalali s-u-jalali-change">                    
                              <i class="zmdi zmdi-calendar-note site-main-text-color"></i>                                                   
                              <input :class="(lang == 'fa')?'shamsiOnlyReturnCalendar':'gregorianReturnCalendar'" type="text" name="dept_date_return" id="dept_date_local_return" placeholder="${useXmltag('Returndate')}" readonly="readonly" v-bind:value="initialInfo?.dataSearch?.arrivalDate">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div v-if="initialInfo?.MultiWay == 'TwoWay'" class="s-u-form-block s-u-num-inp s-u-num-inp-change width100 " id="returnDate">
                     <div class="s-u-form-date-wrapper">
                        <div class="s-u-date-pick">
                           <div class="s-u-jalali s-u-jalali-change">                    
                              <i class="zmdi zmdi-calendar-note site-main-text-color"></i>                                                   
                              <input class="shamsiOnlyReturnCalendar" type="text" name="dept_date_return" id="dept_date_local_return" placeholder="${useXmltag('Returndate')}" readonly="readonly" v-bind:value="initialInfo?.dataSearch?.arrivalDate">
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--
                     <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-datepicker-multi-2 ui-datepicker-multi ui-datepicker-rtl"></div>
                     -->
                  <div class="number_passengers">
                      <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                         <div class="s-u-form-input-wrapper">
                            <p class="s-u-number-input  s-u-number-input-change  inp-adt inp-adt-change">
                               <i class="plus zmdi zmdi-plus-circle site-main-text-color-h " id="add1" ></i>
                               <span>
                                   <input class="site-main-text-color-drck" id="qty1" type="text" :value="initialInfo?.dataSearch?.adult" name="adult" min="0" max="9">
                                    ${useXmltag('Adult')}
                                </span>                                                                 
                               <i class="minus zmdi zmdi-minus-circle site-main-text-color-h " id="minus1"></i>
                            </p>
                         </div>
                      </div>
                      <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                         <div class="s-u-form-input-wrapper">
                            <p class="s-u-number-input  s-u-number-input-change  inp-child inp-child-change">
                              <i class="plus zmdi zmdi-plus-circle site-main-text-color-h " id="add2"></i>
                               <span>
                               <input class="site-main-text-color-drck" id="qty2" type="text" :value="initialInfo?.dataSearch?.child" name="child" min="0" max="9">
                                    ${useXmltag('Child')}
                                </span>
                               <i class="minus zmdi zmdi-minus-circle site-main-text-color-h " id="minus2"></i>
                            </p>
                         </div>
                      </div>
                      <div class="s-u-form-block s-u-num-inp s-u-num-inp-change width100">
                         <div class="s-u-form-input-wrapper">
                            <p class="s-u-number-input  s-u-number-input-change  inp-baby inp-baby-change">
                              <i class="plus zmdi zmdi-plus-circle site-main-text-color-h " id="add3"></i>
                               <span>
                                    <input class="site-main-text-color-drck" id="qty3" type="text" :value="initialInfo?.dataSearch?.infant" name="infant" min="0" max="9">
                                    ${useXmltag('Baby')}
                                </span>
                               <i class="minus zmdi zmdi-minus-circle site-main-text-color-h " id="minus3"></i>
                            </p>
                         </div>
                     </div>
                  </div>
                  <div class="s-u-search-wrapper s-u-num-inp s-u-num-inp-search-change">
                     <a href="" onclick="return false" class="f-loader-check f-loader-check-bar" id="loader_check_submit" style="display:none"></a>
                     <button type="button" onclick="submitLocalSideVue()" id="sendFlight" class="site-bg-main-color">${useXmltag('Search')}</button>
                  </div>
               </form>
               <div class="message_error_portal"></div>
            </div>
         </div>
         <ul id="s-u-filter-wrapper-ul">
            <span class="s-u-close-filter"></span>            
            <!-- pricefilter -->
            <li class="s-u-filter-item" data-group="flight-price" id="flight_price_range">
               <input type="hidden" name="minPrice" id="minPriceRange" value="">
               <input type="hidden" name="maxPrice" id="maxPriceRange" value="">
               <span class="s-u-filter-title"><i class="zmdi zmdi-money"></i>&nbsp;${useXmltag('Price')}</span>
               <div class=" s-u-filter-content slider_range_parent">
                  <p>
                     <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;"
                        onload="selectPriceRange('', '');">
                  </p>
                  <div id="slider-range" v-on:mouseover="totalRange()"></div>
               </div>
            </li>
            <!-- flight type filter -->
            <li class="s-u-filter-item" data-group="flight-type">
               <span class="s-u-filter-title"><i class="zmdi zmdi-flight-takeoff"></i>&nbsp;${useXmltag('Typeflight')}</span>
               <div class="s-u-filter-content">
                  <ul class="s-u-filter-item-time filter-type-ul">
                     <li>
                        <label>${useXmltag('All')}</label>
                        <input class="check-switch" type="checkbox" id="filter-type" value="all">
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color checked filter-to-check all-filter"  v-bind:id="'FlightType_li'+'/'+all" v-on:click="filterFlightVue('FlightType_li'+'/'+all)"></span>
                     </li>
                     <li v-for="item in arrFlights?.typeFlightFilter">
                        <label>%%item.name%%</label>
                        <input class="check-switch" type="checkbox" v-bind:id="'filter-'+item.EnName" v-bind:value="item.EnName" >
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color filter-to-check"  v-bind:id="'FlightType_li'+'/'+item.EnName" v-on:click="filterFlightVue('FlightType_li'+'/'+item.EnName)"></span>
                     </li>
                  </ul>
               </div>
            </li>
            <!-- seat class filter -->
            <li class="s-u-filter-item" data-group="flight-seat">
               <span class="s-u-filter-title"><i class="zmdi zmdi-airline-seat-recline-extra"></i>&nbsp;${useXmltag('Classflight')}</span>
               <div class="s-u-filter-content">
                  <ul class="s-u-filter-item-time filter-seat-ul">
                     <li>
                        <label>${useXmltag('All')}</label>
                        <input class="check-switch" type="checkbox" id="filter-seat" value="all">
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color checked filter-to-check all-filter" v-bind:id="'SeatClassEn'+'/'+all" v-on:click="filterFlightVue('SeatClassEn'+'/'+all)" ></span>
                     </li>
                     <li v-for="item in arrFlights?.seatClassFilter">
                        <label>%%item.name%%</label>
                        <input class="check-switch" type="checkbox" v-bind:id="'filter-'+item.EnName" v-bind:value="item.EnName">
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color filter-to-check" v-bind:id="'SeatClassEn'+'/'+item.EnName" v-on:click="filterFlightVue('SeatClassEn'+'/'+item.EnName)"></span>
                     </li>
                  </ul>
               </div>
            </li>
            <!-- airline filter -->
            <li class="s-u-filter-item" data-group="flight-airline">
               <span class="s-u-filter-title "><i class="zmdi zmdi-local-airport"></i>&nbsp;${useXmltag('Airline')}</span>
               <div class="s-u-filter-content">
                  <span class="f-loader f-loader-check" style="display: none;"></span>
                  <ul class="s-u-filter-item-time filter-airline-ul">
                     <li>
                        <label>${useXmltag('All')}</label>
                        <input class="check-switch" type="checkbox" id="filter-airline" value="all">
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color checked filter-to-check all-filter" v-bind:id="'Airline'+'/'+all" v-on:click="filterFlightVue('Airline'+'/'+all)"></span>
                     </li>
                     <li v-if="flightsFlagg == 4"  class="" v-for="item in arrFlights?.return?.MinPriceAirline" >    
                        <label>
                        <i v-bind:id="item?.EnName+'-minPrice'" v-text="(item?.price)"></i>
                        %%item?.name%% 
                        </label>
                        <input class="check-switch" type="checkbox" v-bind:id="'filter-'+item?.EnName" v-bind:value="item?.EnName">
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color" v-bind:id="'Airline'+'/'+item?.EnName" v-on:click="filterFlightVue('Airline'+'/'+item?.EnName)"></span>                            
                     </li>
                      <li v-if="flightsFlagg != 4"  class="" v-for="item in arrFlights?.dept?.MinPriceAirline" >    
                        <label>
                        <i v-bind:id="item?.EnName+'-minPrice'" v-text="(item?.price)"></i>
                        %%item?.name%%
                        </label>
                        <input class="check-switch" type="checkbox" v-bind:id="'filter-'+item?.EnName" v-bind:value="item?.EnName">
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color" v-bind:id="'Airline'+'/'+item?.EnName" v-on:click="filterFlightVue('Airline'+'/'+item?.EnName)"></span>                            
                     </li>
                  </ul>
               </div>
            </li>
            <!-- time filter -->
            <li class="s-u-filter-item" data-group="flight-time">
               <span class="s-u-filter-title"><i class="zmdi zmdi-time"></i>&nbsp;${useXmltag('RunTime')}
               </span>
               <div class="s-u-filter-content">
                  <ul class="s-u-filter-item-time filter-time-ul">
                     <li>
                        <label>${useXmltag('All')}</label>
                        <input class="check-switch" type="checkbox" id="filter-time" value="all"  >
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color checked filter-to-check all-filter" v-bind:id="'timeFilter'+'/'+all" v-on:click="filterFlightVue('timeFilter'+'/'+all)"></span>
                     </li>
                     <li v-for="item in arrFlights?.timeFilter">
                        <label> <i>(%%item.value%%)</i>%%item.time%%</label>
                        <input class="check-switch" type="checkbox" v-bind:id="'filter-'+item?.time" v-bind:value="item?.value">
                        <span data-inactive="${useXmltag('Inactive')}" data-active="${useXmltag('Active')}" class="tzCBPart site-bg-filter-color " v-bind:id="'timeFilter'+'/'+item?.value" v-on:click="filterFlightVue('timeFilter'+'/'+item?.value)"></span>
                     </li>
                  </ul>
               </div>
            </li>
         </ul>
        </div>         
      </div>
      <div id="result" class="col-lg-9 col-md-12 col-sm-12 col-xs-12 flight_body_search col-padding-5"  v-model ="arrFlights" >
         <!--loader-->   
          <!-- <div class="flight_body_search loader-parent">
            <div class="loader-section">
               <div class="images-loader">
                  <div class="images-circle owl-carousel">
                     <div class="images-circle-item">                    
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a18.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a16.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a17.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a19.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a20.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a21.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a22.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a23.png'"/>
                     </div>
                     <div class="images-circle-item">
                        <img v-bind:src="rootMainPath+'/gds/pic/airline/a24.png'"/>
                     </div>
                  </div>
               </div>
               <div class="my-progress">
                  <div id="myBar" class="my-progress-bar site-bg-main-color" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                     <span class="site-bg-main-color-before site-bg-main-color-after-for-loader site-bg-main-color" id="myBarSpan">% 0</span>
                  </div>
               </div>
            </div>
            <div id="resultFake"></div>
         </div>-->
         <div class="s-u-ajax-container">
            <div class="s-u-result-wrapper">              
               <div class="result-vue" id="result-vue">
                  <!--<?php if ($searchFlightNumber == ''){?> -->                         
                  <div class="sorting2" id="sortFlightInternal">
                     <div class="sorting-inner date-change iranL prev">
                        <a v-if="initialInfo?.MultiWay == 'OneWay'" class="prev-date" v-bind:href="urlPrevNewUrl" v-on:click="prevDayVue()">
                        <i class="zmdi zmdi-chevron-right iconDay "></i>
                        <span> ${useXmltag('Previousday')}</span>                                    
                        </a>
                        <div v-if="initialInfo?.MultiWay == 'TwoWay'" class="prev-date disabled" >
                           <i class="zmdi zmdi-chevron-right iconDay "></i>
                           <span> ${useXmltag('Previousday')}</span>                                    
                        </div>
                     </div>
                     <div class="sorting-inner price sorting-active-color-main desc" id="priceSortSelectVue" v-on:click="sortPriceVue()" >
                        <span class="svg">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                              <g>
                                 <path d="M11,3H1C0.4,3,0,3.4,0,4v2c0,0.6,0.4,1,1,1h10c0.6,0,1-0.4,1-1V4C12,3.4,11.6,3,11,3z"></path>
                                 <path d="m11,11h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"></path>
                                 <path d="m11,19h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"></path>
                                 <path d="m25.7,15.3l-1.4-1.4c-0.2-0.2-0.5-0.3-0.7-0.3-0.3,0-0.5,0.1-0.7,0.3l-2,2c-0.3,0.3-0.9,0.1-0.9-0.4v-13.5c0-0.5-0.5-1-1-1h-2c-0.5,0-1,0.5-1,1v22c0,0.3 0.1,0.5 0.3,0.7s0.5,0.3 0.7,0.3c0.3,0 0.5-0.1 0.7-0.3l8-8c0.2-0.2 0.3-0.4 0.3-0.7 0-0.3-0.1-0.5-0.3-0.7z"></path>
                              </g>
                           </svg>
                        </span>
                        <span class="text-price-sort iranL">${useXmltag('Baseprice')}</span>
                        <input type="hidden" value="desc" name="" id=""  v-model="flights">
                     </div>
                     <div class="sorting-inner time desc" id="timeSortSelectVue" v-on:click="sortTimeVue()">
                        <span class="svg">
                           <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 26 26">
                              <g>
                                 <path d="M11,3H1C0.4,3,0,3.4,0,4v2c0,0.6,0.4,1,1,1h10c0.6,0,1-0.4,1-1V4C12,3.4,11.6,3,11,3z"></path>
                                 <path d="m11,11h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"></path>
                                 <path d="m11,19h-10c-0.6,0-1,0.4-1,1v2c0,0.6 0.4,1 1,1h10c0.6,0 1-0.4 1-1v-2c0-0.6-0.4-1-1-1z"></path>
                                 <path d="m25.7,15.3l-1.4-1.4c-0.2-0.2-0.5-0.3-0.7-0.3-0.3,0-0.5,0.1-0.7,0.3l-2,2c-0.3,0.3-0.9,0.1-0.9-0.4v-13.5c0-0.5-0.5-1-1-1h-2c-0.5,0-1,0.5-1,1v22c0,0.3 0.1,0.5 0.3,0.7s0.5,0.3 0.7,0.3c0.3,0 0.5-0.1 0.7-0.3l8-8c0.2-0.2 0.3-0.4 0.3-0.7 0-0.3-0.1-0.5-0.3-0.7z"></path>
                              </g>
                           </svg>
                        </span>
                        <span class="text-price-sort iranL">${useXmltag('BaseStartTime')}</span>
                        <input type="hidden" value="desc" name="" id=""  v-model ="flights" >
                     </div>
                     <div class="sorting-inner date-change iranL next">
                       <div v-if="initialInfo?.MultiWay == 'TwoWay'" class="next-date disabled">
                           <span>${useXmltag('Nextday')} </span>
                           <i class="zmdi zmdi-chevron-left iconDay "></i>
                        </div> 
                        <a v-if="initialInfo?.MultiWay == 'OneWay'" class="next-date" v-bind:href="urlNextNewUrl" v-on:click="nextDayVue()">
                        <span>${useXmltag('Nextday')} </span>
                        <i class="zmdi zmdi-chevron-left iconDay "></i>
                        </a>
                     </div>
                     <div class="dateprice filter_search_mobile ">
                        <div class=" site-border-main-color lowerSortSelectVue" id="lowerSortSelect" onclick="getUserAccount()" v-on:click="togglecalendar()" >
                           <span class="dataprice-icon">
                              <svg class="site-bg-svg-color" height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg">
                                 <path d="m452 40h-24v-40h-40v40h-264v-40h-40v40h-24c-33.085938 0-60 26.914062-60 60v352c0 33.085938 26.914062 60 60 60h392c33.085938 0 60-26.914062 60-60v-352c0-33.085938-26.914062-60-60-60zm-392 40h24v40h40v-40h264v40h40v-40h24c11.027344 0 20 8.972656 20 20v48h-432v-48c0-11.027344 8.972656-20 20-20zm392 392h-392c-11.027344 0-20-8.972656-20-20v-264h432v264c0 11.027344-8.972656 20-20 20zm-136-42h120v-120h-120zm40-80h40v40h-40zm0 0"></path>
                              </svg>
                           </span>
                           <span class="text-dateprice site-main-text-color">${useXmltag('CalenderPrice')}</span>
                           <input type="hidden" value="desc" name="currentTimeSort" id="currentTimeSort">
                        </div>
                      
                     </div>
                    <div class="filter_search_mobile_res">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0" y="0" viewBox="0 0 512 512" xml:space="preserve" class="site-bg-svg-color">
                              <g>
                                 <g xmlns="http://www.w3.org/2000/svg">
                                    <path d="m420.404 0h-328.808c-50.506 0-91.596 41.09-91.596 91.596v328.809c0 50.505 41.09 91.595 91.596 91.595h328.809c50.505 0 91.595-41.09 91.595-91.596v-328.808c0-50.506-41.09-91.596-91.596-91.596zm61.596 420.404c0 33.964-27.632 61.596-61.596 61.596h-328.808c-33.964 0-61.596-27.632-61.596-61.596v-328.808c0-33.964 27.632-61.596 61.596-61.596h328.809c33.963 0 61.595 27.632 61.595 61.596z" data-original="#000000" style="" class=""></path>
                                   <path d="m432.733 112.467h-228.461c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-35.661c-8.284 0-15 6.716-15 15s6.716 15 15 15h35.662c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h228.461c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-273.133 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" data-original="#000000" style="" class=""></path>
                                   <path d="m432.733 241h-35.662c-6.281-18.655-23.927-32.133-44.672-32.133s-38.39 13.478-44.671 32.133h-228.461c-8.284 0-15 6.716-15 15s6.716 15 15 15h228.461c6.281 18.655 23.927 32.133 44.672 32.133s38.391-13.478 44.672-32.133h35.662c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-80.333 32.133c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.686 17.133 17.133-7.686 17.133-17.133 17.133z" data-original="#000000" style="" class=""></path>
                                   <path d="m432.733 369.533h-164.194c-6.281-18.655-23.926-32.133-44.672-32.133s-38.391 13.478-44.672 32.133h-99.928c-8.284 0-15 6.716-15 15s6.716 15 15 15h99.928c6.281 18.655 23.926 32.133 44.672 32.133s38.391-13.478 44.672-32.133h164.195c8.284 0 15-6.716 15-15s-6.716-15-15.001-15zm-208.866 32.134c-9.447 0-17.133-7.686-17.133-17.133s7.686-17.133 17.133-17.133 17.133 7.685 17.133 17.132-7.686 17.134-17.133 17.134z" data-original="#000000" style="" class=""></path>
                                 </g>
                              </g>
                           </svg>
                      <span class="site-main-text-color">${useXmltag('Filter')} </span>
                    </div>
                  </div>
                  <!-- <?php } ?>-->   
                   <!--Advertises-->
                   <div class="advertises" v-if="initialInfo?.Advertises.length > 0">
                   
                     <div class="advertise-item" v-for="(advertise, index) in initialInfo?.Advertises" v-html="advertise?.content"></div>
                   </div>
                   <!--EndAdvertises-->
                  <div class="lowest animated fadeIn" id="lowest">
                     <div class="price-data-title">
                        <span>
                        ${translateXmlByParams('MessageLowestPrice',{'origin' : initialInfo.dataSearch.NameDeparture , 'destination' : initialInfo.dataSearch.NameArrival})}
                  
                        </span>
                     </div>
                     <span class="f-loader f-loader-check flightFifteen" >
                       
                       <div class="stage filter-contrast">
                          <div class="dot-shuttle"></div>
                        </div>
                     </span>
                     <input type="hidden" value="" id="checkOpenFifteenFlight">
                     <div id="showDataFlight" class="owl-carousel"></div>
                  </div>        
                  <ul style="display:none;" id="s-u-result-wrapper-ul" v-if="flightsFlagg == 1 || !flights || flights.length == 0" class="items item_flight">
                     <div class="userProfileInfo-messge ">
                        <div class="messge-login BoxErrorSearch ">
                           <div class="alarm_icon_msg">
                              <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
                           </div>
                           <div class="TextBoxErrorSearch">
                              ${useXmltag('Noflight')} ${useXmltag('Changedate')}. 
                           </div>
                        </div>
                     </div>
                  </ul>
                  <ul id="s-u-result-wrapper-ul" else >
                     <div class="selectedTicket mart10 marb10"></div>
                     <div class="items item_flight">
                        <div v-if="flightsFlagg == 4 && selectedFlight?.FlightNo ">
                           <div id="returnSelected" class="vue-class">
                              <div class="return selectedTicket mart10 marb10" id="vueReturn">
                                 <h5 class="raft-ticket"><a v-on:click="undoFlightSelectVue()" v-model="flights"><i class="zmdi zmdi-close site-secondary-text-color"></i></a>${useXmltag('TicketSelected')}</h5>
                                 <div class="international-available-box international-available-info site-main-text-color">
                                    <div class="international-available-item-right-Cell ">
                                       <div class=" international-available-airlines  ">
                                          <div class="international-available-airlines-logo">
                                             <div v-bind:class="selectedFlight?.Airline">
                                                <div class="logo-airline-ico"></div>
                                             </div>
                                          </div>
                                          <div class="international-available-airlines-log-info">
                                             <span class="iranM ">
                                             %%selectedFlight?.FlightNo%%</span>
                                             <div class="esterdad-blit" > 
                                             <span class="sandali-span2 iranL  site-main-text-color"  v-if="(selectedFlight?.Capacity > 0 && selectedFlight?.Capacity !='')">
                                             <i class="font-chanhe "></i>
                                               %%selectedFlight?.Capacity%%  ${useXmltag('Chair')}</span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="international-available-airlines-info ">
                                          <div class="airlines-info txtLeft">
                                           <span class="iranL " v-text="selectedFlight?.DepartureCity"></span>
                                             <span class="iranB txt15" v-text="selectedFlight?.DepartureTime"></span>
                                             <span class="iranL " v-text="selectedFlight?.DepartureDate"></span>
                                           
                                             <span class="iranB ">${useXmltag('Classrate')}</span>
                                          </div>
                                          <div class="airlines-info ">
                                             <span>---------------------</span>
                                             <span>---------------------</span>
                                             <span>---------------------</span>
                                             <span>---------------------</span>
                                          </div>
                                          <div class="airlines-info txtRight">
                                             <span class="iranL " v-text="selectedFlight?.ArrivalCity"></span>
                                             <span class="iranB txt15 timeSortDep" v-text="selectedFlight?.ArrivalTime"></span>
                                             <span class="iranL " v-text="selectedFlight?.ArrivalDate"></span>
                                             <span class="iranB " v-text="selectedFlight?.SeatClass"></span>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="international-available-item-left-Cell">
                                       <div class="inner-avlbl-itm selectedFlightClass">
                                          <span class="iranL  priceSortAdt">
                                          <span v-if="selectedFlight.AdtWithDiscount > 0" class="iranL priceSortAdt">
                                          <span class="iranL old-price text-decoration-line CurrencyCal" v-text="number_format_vue(selectedFlight?.AdtPrice)" ></span>
                                          <i v-text="number_format_vue(selectedFlight?.AdtWithDiscount)" class="iranB site-main-text-color-drck CurrencyCal" ></i>
                                          <span class="CurrencyText">%%selectedFlight?.currencyType%%</span>
                                          </span>
                                          <span v-if="selectedFlight.AdtWithDiscount == 0" class="iranL priceSortAdt">
                                          <i v-text="number_format_vue(selectedFlight?.AdtPrice)" class="iranB site-main-text-color-drck CurrencyCal" ></i>
                                          <span class="CurrencyText">%%selectedFlight?.currencyType%%</span>
                                          </span>  
                                          </span>
                                       </div>
                                    </div>
                                    <input type="hidden" v-bind:value="selectedFlightUniqueId" name="selected_session_filght_Id" class="selected_session_filght_Id">
                                 </div>
                                 <div class="twowayWarning">
                                    <p>به نکات زیر توجه کنید</p>
                                    <ul>
                                       <li>با توجه به محدودیت هایی که در تفاهم دو ایرلاین موسوم به قرارداد 14 جانبه در ایران وجود دارد بعضا ایرلاین ها در صورت کنسلی یک طرف از پرواز تعهدی نسبت به کنسل نمودن طرف دیگر پرواز ندارند، لذا در انتخاب این نوع پروازها دقت بفرمایید.</li>
                                       <li>طبق شرایط ایرلاین ها در پروازهای چارتری در کمتر از یک درصد مواقع امکان دارد پرواز چارتر غیرقابل استفاده باشد. قطعا در زمان بروز این مشکل، به شما اطمینان داده می شود بخش پشتیبانی شبانه روزی ما سعی خواهد نمود تا پروازی جایگزین برای شما تهیه کرده و ضرر مالی احتمالی شما را جبران نماید. ما خود را موظف می دانیم تا سفر خوشی را برای شما فراهم کنیم.</li>
                                    </ul>
                                 </div>
                                 <h5 class="bargasht-ticket">${useXmltag('SelectReturnTicket')}</h5>
                              </div>
                           </div>
                        </div>                        
                        <div v-model="arrFlights"  v-for="(item, index) in flights" class="showListSort" >
                           <div class="international-available-box" id=""  data-flightNo="" data-price="" data-type="" data-seat="" data-airline="" data-typeAppTicket="noReservation" data-time="" >
                              <input type="hidden" value="noReservation" name="typeAppTicket" id="typeAppTicket">
                              <div class="international-available-item " v-bind:class="item?.Airline">
                                 <div class="international-available-info">
                                    <div class="international-available-item-right-Cell ">
                                       <div v-if="item.SeatClassEn == 'business'" class="right_busin_div">
                                          <div class="site-bg-main-color">
                                             <span class="iranM ">%%item?.SeatClass%%</span>
                                          </div>
                                       </div>
                                       <div v-if="item.SeatClassEn != 'business'" class="right_busin_div"></div>
                                       <div class=" international-available-airlines">
                                          <div class="international-available-airlines-logo">
                                             <div>
                                                <div class="logo-airline-ico"></div>
                                             </div>
                                        
                                             
                                          </div>
                                               <div class="international-available-airlines-log-info  pt-2">
                                           
                                             <div class="esterdad-blit"> 
                                                <span class="sandali-span2 iranL  text-dark"><i class="font-chanhe "></i> 
                                                  %% item.AirlineName%%
                                                </span>
                                             </div>
                                          </div>
                                          <div class="international-available-airlines-log-info pt-2">
                                           
                                             <div class="esterdad-blit" v-if="item?.Capacity > 0"> 
                                                <span class="sandali-span2 iranL  site-main-text-color"><i class="font-chanhe "></i> 
                                                &nbsp;%%item?.Capacity%% ${useXmltag('Chair')}
                                                </span>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="international-available-airlines-info ">
                                          <div class="airlines-info destination txtLeft">
                                             <span class="iranB txt18" v-text="item.DepartureCity"></span>
                                             <span class="iranM txt19 timeSortDep" v-text="item.DepartureTime"></span>
                                          </div>
                                          <div class="airlines-info">
                                             <div class="airlines-info-inner">
                                                                                                                   
                                                <div class="airline-line">
                                                   <div class="loc-icon">
                                                     <i class="flat_circle site-bg-main-color "></i>
                                                    
                                                   </div>
                                                   <div class="plane-icon">
                                                      <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                                                         <path d="M445.355,67.036l-0.391-0.392c-19.986-19.006-59.898,14.749-59.898,14.749l-72.463,57.049l-76.285-13.52
                                                            c11.005-15.953,14.32-31.79,6.983-39.127c-9.503-9.503-33.263-1.15-53.068,18.655c-3.464,3.464-6.568,7.049-9.297,10.657
                                                            l-58.574-10.381L83.346,137.97l159.044,72.979L140.427,334.152l-63.505-11.906l-16.083,16.06L173.696,451.16l16.058-16.082
                                                            l-11.906-63.506l123.204-101.963l72.979,159.043l33.244-39.016l-10.381-58.574c3.609-2.729,7.193-5.832,10.658-9.297
                                                            c19.805-19.805,28.158-43.564,18.656-53.066c-7.339-7.338-23.177-4.022-39.13,6.982l-13.52-76.284l57.049-72.464
                                                            C430.607,126.934,464.363,87.021,445.355,67.036z"></path>
                                                      </svg>
                                                   </div>
                                                   <div class="loc-icon-destination">
                                                      <svg version="1.1" class="site-main-text-color" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="32px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                         <g>
                                                            <g>
                                                               <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
                                                                  c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
                                                                  c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"></path>
                                                            </g>
                                                         </g>
                                                      </svg>
                                                   </div>
                                                </div>
                                                <span class="flight-type iranB " v-if ="item?.FlightTypeKidding != null " > %% item?.FlightTypeKidding %% </span>
                                                <span class="flight-type iranB " v-else-if ="item?.FlightType_li == 'system'" > ${useXmltag('SystemType')} </span>
                                                <span v-else  class="flight-type iranB " >${useXmltag('CharterType')}</span>                                                                        
                                                <span class="source" style="color: white">%%item?.SourceName%%</span>                                                                       
                                             </div>
                                          </div>
                                          <div class="airlines-info destination txtRight">
                                             <span class="iranB txt18" v-text="item?.ArrivalCity"></span>
                                             <span class="iranM txt19" v-text="item?.ArrivalTime"></span>                                                                      
                                          </div>
                                       </div>
                                    </div>
                                    <div class="international-available-item-left-Cell">
                                       <div class="inner-avlbl-itm ">
                                          <div v-if="item?.AdtPrice > 0" >
                                             <span v-if="item.hasDiscount=='yes'" class="iranL priceSortAdt">
                                             <span class="iranL old-price text-decoration-line CurrencyCal" v-text="number_format_vue(item?.AdtPrice)" ></span>
                                             <i v-text="number_format_vue(item?.AdtWithDiscount)" class="iranB site-main-text-color-drck CurrencyCal" ></i>
                                              <span class="CurrencyText">%% item?.typeCurrency%%</span>
                                             </span>
                                             <span v-if="item.hasDiscount == 'No'" class="iranL priceSortAdt">
                                             <i v-text="number_format_vue(item?.AdtPrice)" class="iranB site-main-text-color-drck" ></i>
                                             <span class="CurrencyText">%% item?.typeCurrency%%</span>
                                             </span>
                                                                                       
                                             <div v-if="flightsFlagg == 2" class="SelectTicket SelectTicket1" id="typeFlightPeraian">
                                                <a v-bind:id="'nextStep_'+item.FlightID"   class="international-available-btn site-bg-main-color" v-on:click="returnFlightsVue(item?.FlightID,'dept',item?.UniqueCode)">
                                                  ${useXmltag('Selectionflight')}                                                                   
                                                </a>
                                                <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
                                                <a href="" onclick="return false" class="f-loader-check f-loader-check-change" v-bind:id="'loader_check_'+item.FlightID" style="opacity: 1; display: none;"></a>
                                                <input type="hidden" value="" class="CurrencyCode">
                                                <input type="hidden" v-bind:value="item?.FlightID" class="FlightID">
                                                <input type="hidden" v-bind:value="item?.FlightNo" class="FlightNumber">
                                                <input type="hidden" v-bind:value="item?.AdtPrice" class="AdtPrice">
                                                <input type="hidden" v-bind:value="item?.chdPrice" class="ChdPrice">
                                                <input type="hidden" v-bind:value="item?.infantPrice" class="InfPrice">
                                                <input type="hidden" v-bind:value="item?.CabinType" class="CabinType">
                                                <input type="hidden" v-bind:value="item?.Airline" class="Airline_Code">
                                                <input type="hidden" v-bind:value="item?.SourceId" class="SourceId">
                                                <input type="hidden" v-bind:value="item?.FlightType_li" class="FlightType">
                                                <input type="hidden" v-bind:value="item?.UniqueCode" class="uniqueCode">
                                                <input type="hidden" v-bind:value="item?.AdtWithDiscount" class="priceWithoutDiscount">
                                                <input type="hidden" v-bind:value="'private'" class="PrivateM4">
                                                <input type="hidden" v-bind:value="item?.Capacity" class="Capacity">                                                                       
                                                <input type="hidden" v-if="arrFlights?.MultiWay == 'OneWay'" v-bind:value="'dept'" class="FlightDirection">
                                                <input type="hidden" v-if="(arrFlights?.MultiWay == 'TwoWay' && item?.DirectionFlight == 'dept')" v-bind:value="'dept'" class="FlightDirection">
                                                <input type="hidden" v-if="(arrFlights?.MultiWay == 'TwoWay' && item?.DirectionFlight == 'return')" v-bind:value="'return'" class="FlightDirection">                                                                        
                                                <input type="hidden" v-bind:value="adultNum" id="adult_qty">
                                                <input type="hidden" v-bind:value="childNum" id="child_qty">
                                                <input type="hidden" v-bind:value="infantNum" id="infant_qty">
                                                <input type="hidden" v-bind:value="arrFlights?.dept?.minPrice" id="min_price">
                                                <input type="hidden" v-bind:value="arrFlights?.dept?.maxPrice" id="max_price">
                                                <input type="hidden" v-bind:value="'Local'" id="TypeZoneFlight">
                                                <input type="hidden" v-bind:value="item?.DepartureCode" id="originFlight">
                                                <input type="hidden" v-bind:value="item?.ArrivalCode" id="destinationFlight">                                                                       
                                                <input type="hidden"  v-bind:value="arrFlights?.MultiWay"  v-bind:name="'MultiWayTicket'"  v-bind:id="'MultiWayTicket'" />
                                                <input type="hidden"  v-bind:id="'searchFlightNumber'"  v-bind:name="'searchFlightNumber'" v-bind:value="item?.FlightNo">                                                                      
                                                <input type="hidden" value=""  v-bind:name="'PrivateCharter'"  v-bind:id="'PrivateCharter'">
                                                <input type="hidden" value=""  v-bind:name="'IdPrivate'"  v-bind:id="'IdPrivate'">                                                                                                                             
                                             </div>
                                             <div v-show="flightsFlagg == 3" class="SelectTicket SelectTicket3" id="typeFlightPeraian">
                                                <a v-bind:id="'nextStep_'+item.FlightID"   class="international-available-btn site-bg-main-color  site-main-button-color-hover aa" v-on:click="returnFlightsVue(item?.FlightID,'dept',item?.UniqueCode)">
                                                  ${useXmltag('Selectionflight')} </a>
                                                <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
                                                <a href="" onclick="return false" class="f-loader-check f-loader-check-change" v-bind:id="'loader_check_'+item.FlightID" style="opacity: 1; display: none;"></a>
                                                <input type="hidden" value="" class="CurrencyCode">
                                                <input type="hidden" v-bind:value="item?.FlightID" class="FlightID">
                                                <input type="hidden" v-bind:value="item?.FlightNo" class="FlightNumber">
                                                <input type="hidden" v-bind:value="item?.AdtPrice" class="AdtPrice">
                                                <input type="hidden" v-bind:value="item?.chdPrice" class="ChdPrice">
                                                <input type="hidden" v-bind:value="item?.infantPrice" class="InfPrice">
                                                <input type="hidden" v-bind:value="item?.CabinType" class="CabinType">
                                                <input type="hidden" v-bind:value="item?.Airline" class="Airline_Code">
                                                <input type="hidden" v-bind:value="item?.SourceId" class="SourceId">
                                                <input type="hidden" v-bind:value="item?.FlightType_li" class="FlightType">
                                                <input type="hidden" v-bind:value="item?.UniqueCode" class="uniqueCode">
                                                <input type="hidden" v-bind:value="item?.AdtWithDiscount" class="priceWithoutDiscount">
                                                <input type="hidden" v-bind:value="'private'" class="PrivateM4">
                                                <input type="hidden" v-bind:value="item?.Capacity" class="Capacity">                                                                       
                                                <input type="hidden" v-if="arrFlights?.MultiWay == 'OneWay'" v-bind:value="'dept'" class="FlightDirection">
                                                <input type="hidden" v-if="(arrFlights?.MultiWay == 'TwoWay' && item?.DirectionFlight == 'dept')" v-bind:value="'dept'" class="FlightDirection">
                                                <input type="hidden" v-if="(arrFlights?.MultiWay == 'TwoWay' && item?.DirectionFlight == 'return')" v-bind:value="'return'" class="FlightDirection">
                                                <input type="hidden" v-bind:value="adultNum" id="adult_qty">
                                                <input type="hidden" v-bind:value="childNum" id="child_qty">
                                                <input type="hidden" v-bind:value="infantNum" id="infant_qty">
                                                <input type="hidden" v-bind:value="arrFlights?.dept?.minPrice" id="min_price">
                                                <input type="hidden" v-bind:value="arrFlights?.dept?.maxPrice" id="max_price">
                                                <input type="hidden" v-bind:value="'Local'" id="TypeZoneFlight">
                                                <!--<input type="hidden" v-if="flightsFlagg == 4" v-bind:value="'resultLocalVue'" id="TypeZoneFlight">-->
                                                <input type="hidden" v-bind:value="item?.DepartureCode" id="originFlight">
                                                <input type="hidden" v-bind:value="item?.ArrivalCode" id="destinationFlight">
                                                <input type="hidden"  v-bind:value="arrFlights?.MultiWay"  v-bind:name="'MultiWayTicket'"  v-bind:id="'MultiWayTicket'" />
                                                <!--                                                                        <input type="hidden" v-if="flightsFlagg == 4"   v-bind:value="'TwoWay'"  v-bind:name="'MultiWayTicket'"  v-bind:id="'MultiWayTicket'" />-->
                                                <input type="hidden"  v-bind:id="'searchFlightNumber'"  v-bind:name="'searchFlightNumber'" v-bind:value="item?.FlightNo">
                                                <input type="hidden" value=""  v-bind:name="'PrivateCharter'"  v-bind:id="'PrivateCharter'">
                                                <input type="hidden" value=""  v-bind:name="'IdPrivate'"  v-bind:id="'IdPrivate'">
                                             </div>
                                             <div v-if="flightsFlagg == 4" class="SelectTicket SelectTicket4" id="typeFlightPeraian">
                                                <a v-bind:id="'nextStep_'+item.FlightID"   class="international-available-btn site-bg-main-color  site-main-button-color-hover aa" v-on:click="returnFlightsVue(item?.FlightID,'return',item?.UniqueCode)"> ${useXmltag('PickBackFlight')}                                                                     
                                                </a>
                                                <input type="hidden" value="" name="session_filght_Id" id="session_filght_Id">
                                                <a href="" onclick="return false" class="f-loader-check f-loader-check-change" v-bind:id="'loader_check_'+item.FlightID" style="opacity: 1; display: none;"></a>
                                                <input type="hidden" value="" class="CurrencyCode">
                                                <input type="hidden" v-bind:value="item?.FlightID" class="FlightID">
                                                <input type="hidden" v-bind:value="item?.FlightNo" class="FlightNumber">
                                                <input type="hidden" v-bind:value="item?.AdtPrice" class="AdtPrice">
                                                <input type="hidden" v-bind:value="item?.chdPrice" class="ChdPrice">
                                                <input type="hidden" v-bind:value="item?.infantPrice" class="InfPrice">
                                                <input type="hidden" v-bind:value="item?.CabinType" class="CabinType">
                                                <input type="hidden" v-bind:value="item?.Airline" class="Airline_Code">
                                                <input type="hidden" v-bind:value="item?.SourceId" class="SourceId">
                                                <input type="hidden" v-bind:value="item?.FlightType_li" class="FlightType">
                                                <input type="hidden" v-bind:value="item?.UniqueCode" class="uniqueCode">
                                                <input type="hidden" v-bind:value="item?.AdtWithDiscount" class="priceWithoutDiscount">
                                                <input type="hidden" v-bind:value="'private'" class="PrivateM4">
                                                <input type="hidden" v-bind:value="item?.Capacity" class="Capacity">                                                                       
                                                <input type="hidden" v-if="arrFlights?.MultiWay == 'OneWay'" v-bind:value="'dept'" class="FlightDirection">
                                                <input type="hidden" v-if="(arrFlights?.MultiWay == 'TwoWay' && item?.DirectionFlight == 'dept')" v-bind:value="'dept'" class="FlightDirection">
                                                <input type="hidden" v-if="(arrFlights?.MultiWay == 'TwoWay' && item?.DirectionFlight == 'return')" v-bind:value="'return'" class="FlightDirection">
                                                <input type="hidden" v-bind:value="adultNum" id="adult_qty">
                                                <input type="hidden" v-bind:value="childNum" id="child_qty">
                                                <input type="hidden" v-bind:value="infantNum" id="infant_qty">
                                                <input type="hidden" v-bind:value="arrFlights?.dept?.minPrice" id="min_price">
                                                <input type="hidden" v-bind:value="arrFlights?.dept?.maxPrice" id="max_price">
                                                <input type="hidden" v-bind:value="'Local'" id="TypeZoneFlight">
                                                <!--                                                                        <input type="hidden" v-if="flightsFlagg == 4" v-bind:value="'resultLocalVue'" id="TypeZoneFlight">-->
                                                <input type="hidden" v-bind:value="item?.DepartureCode" id="originFlight">
                                                <input type="hidden" v-bind:value="item?.ArrivalCode" id="destinationFlight">
                                                <input type="hidden"  v-bind:value="arrFlights?.MultiWay"  v-bind:name="'MultiWayTicket'"  v-bind:id="'MultiWayTicket'" />
                                                <!--                                                                        <input type="hidden" v-if="flightsFlagg == 4"   v-bind:value="'TwoWay'"  v-bind:name="'MultiWayTicket'"  v-bind:id="'MultiWayTicket'" />-->
                                                <input type="hidden"  v-bind:id="'searchFlightNumber'"  v-bind:name="'searchFlightNumber'" v-bind:value="item?.FlightNo">
                                                <input type="hidden" value=""  v-bind:name="'PrivateCharter'"  v-bind:id="'PrivateCharter'">
                                                <input type="hidden" value=""  v-bind:name="'IdPrivate'"  v-bind:id="'IdPrivate'">
                                             </div>
                                          </div>
                                        
                                        
                                          <div v-if="item.is_complete" class="SelectTicket">
                                             <a class="international-available-btn flight-false">اتمام ظرفیت</a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="international-available-details">
                                       <div>
                                          <div class=" international-available-panel-min">
                                             <ul class="tabs">
                                                <li class="tab-link current site-border-top-main-color " data-tab="tab-1-0">${useXmltag('Informationflight')} </li>
                                                <li class="tab-link site-border-top-main-color detailShow" data-tab="tab-2-0" infotab="{&quot;CabinType&quot;:&quot;&quot;,&quot;AdtPrice&quot;:6746000,&quot;ChdPrice&quot;:0,&quot;InfPrice&quot;:0,&quot;Airline&quot;:&quot;IV&quot;,&quot;FlightType&quot;:&quot;charter&quot;,&quot;CounterId&quot;:&quot;5&quot;,&quot;SourceId&quot;:&quot;8&quot;}" countertab="0">
                                                   ${useXmltag('Price')}
                                                </li>
                                                <li class="tab-link site-border-top-main-color" data-tab="tab-3-0"> ${useXmltag('TermsandConditions')}</li>
                                             </ul>
                                             <div id="tab-1-0" class="tab-content current">
                                                <div class="international-available-airlines-detail-tittle">
                                                   <span class="iranB  lh25 displayb txtRight">
                                                   <i class="fa fa-circle site-main-text-color "></i>
                                                   ${useXmltag('Flight')}
                                                   %%item?.DepartureCity%%
                                                   ${useXmltag('On')}
                                                   %%item?.ArrivalCity%%
                                                   </span>                                             
                                                   <div class=" international-available-airlines-detail  site-border-right-main-color">
                                                      <div class="international-available-airlines-logo-detail logo-airline-ico">
                                                      </div>
                                                      <div class="international-available-airlines-info-detail my-info-detail ">
                                                         <span class="airline_s"> ${useXmltag('Airline')} :                                                           
                                                         %%item?.AirlineName%%
                                                           <em>-</em>
                                                         </span> 
                                                         <span class="flightnumber_s ">
                                                         <i> ${useXmltag('FlightNumber')} : </i>
                                                           %%item?.FlightNo%%
                                                           <em>-</em>
                                                         </span> 
                                                         <span class="seatClass_s">
                                                           %%item?.SeatClass%%
                                                           <em>-</em>
                                                         </span>    
                                                        <span class="capacity_s" v-if="item?.Capacity > 0">
                                                         <i> ${useXmltag('Capacity')} : </i>
                                                           %%item?.Capacity%%
                                                          <em>-</em>
                                                         </span> 
                                                        <span class="flighttime_s">
                                                         ${useXmltag('Flighttime')} :  
                                                         %%item?.LongTime?.Minutes%%  
                                                          : 
                                                         %%item?.LongTime?.Hour%%
                                                         </span>
                                                           <span class="flighttime_s" v-if='item?.FlightTypeKidding !=null'> 
                                                           <em>-</em>
                                                            %%item?.FlightTypeKidding%% 
                                                          </span>
                                                      </div>
                                                        
                                                   </div>
                                                   <div class="international-available-airlines-detail   site-border-right-main-color">
                                                      <div class="airlines-detail-box ">  
                                                         <span >%%item?.DepartureCity%%</span>
                                                         <span >%%item?.DepartureDate%% </span>
                                                         <span >%%item?.DepartureTime%%</span>  
                                                         
                                                      </div>
                                                      <div class="airlines-detail-box "> 
                                                      <span > %%item?.ArrivalCity%%</span>                                                   
                                                      <span >%%item?.ArrivalDate%% </span>
                                                      <span>%%item?.ArrivalTime%%</span>
                                                      </div>
                                                      <div class="airlines-detail-box-2 "> 
                                                       <span class="padt0 iranb  lh18 displayb">
                                                           ${useXmltag('Permissible')} : 
                                                         <i class="iranNum">%%item?.Baggage%% ${useXmltag('Kg')} </i>
                                                         </span>            
                                                         <span class="padt0 iranL  lh18 displayb">${useXmltag('Classrate')} : <i class="openL"></i>
                                                           %%item?.CabinType%% 
                                                         </span> 
                                                         <span class="padt0 iranb  lh18 displayb">
                                                           ${useXmltag('Typeairline')} : 
                                                         <i class="iranNum">%%item?.Aircraft%%  </i>
                                                         </span>                                        
                                                        
                                                         
                                                                                                             
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div id="tab-2-0" class="tab-content price-Box-Tab">
                                                <div class="pop-up-h site-bg-main-color">
                                                   <span> ${useXmltag('TicketDetailsBasedPriceID')} : </span>
                                                </div>
                                                <div class="price-Content site-border-main-color">
                                                   <p id="AlertPanelHTC"></p>
                                                   <div class="tblprice">
                                                      <div>
                                                         <div class="tdpricelabel">${useXmltag('Adult')} : </div>
                                                         <div class="tdprice"><i v-text="number_format_vue(item?.AdtPrice)"></i>${useXmltag('Rial')}</div>
                                                         <div class="tdpricelabel">${useXmltag('Child')} : </div>
                                                         <div class="tdprice"><i>${useXmltag('PreInvoiceStep')}</i></div>
                                                         <div class="tdpricelabel">${useXmltag('Inf')} : </div>
                                                         <div class="tdprice"><i>${useXmltag('PreInvoiceStep')}</i></div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="cancel-policy cancel-policy-charter">
                                                   <span class="site-bg-main-color">
                                                   ${useXmltag('ThecharterflightscharterunderstandingCivilAviationOrganization')}
                                                   </span>
                                                </div>
                                             </div>
                                             <div id="tab-3-0" class="tab-content">
                                                <p class="iranL  lh25 displayb">
                                                </p>
                                                <ul>
                                                   <li>1- ${useXmltag('AccordingCivilAviationOrganizationResponsibilityResponsibleFlying')}</li>
                                                   <li>2- ${useXmltag('ResponsibilityAllTravelInformationEntryIncorrectPassengerRePurchase')}</li>
                                                   <li>3- ${useXmltag('MustEnterValidMobileNecessary')}</li>
                                                   <li>4- ${useXmltag('AviationRegulationsBabyChildAdultAges')}</li>
                                                   <li>5- ${useXmltag('CanNotBuyBabyChildTicketOnlineIndividuallySeparatelyAdultTickets')}</li>
                                                   <li>6- ${useXmltag('AircraftDeterminedAnyChangeAircraftCarrierHoldingFlight')}</li>
                                                   <li>7- ${useXmltag('PresenceDomesticFlightsRequiredForeignFlightsRequiredDocuments')}</li>
                                                   <li>8- ${useXmltag('FlightTypeKiddingReserve')}</li>
                                                </ul>
                                                <p></p>
                                             </div>
                                          </div>
                                       </div>
                                       <span class="international-available-detail-btn more_1 ">
                                          <div class="my-more-info slideDownAirDescription">
                                             ${useXmltag('MoreDetails')}<i class="fa fa-angle-down"></i>
                                          </div>
                                       </span>
                                       <span class="international-available-detail-btn  slideUpAirDescription displayiN"><i class="fa fa-angle-up site-main-text-color"></i></span>
                                    </div>
                                 </div>
                                 <div class="clear"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </ul>
               </div>
            </div>
         </div>
      </div>
     
   </div>
   <slot/>
</div>       
        `,
           data: function () {
               return {
                   arrFlights: {},
                   flightsFlagg: flightsFlagg,
                   typeFilter: [],
                   all: 'all',
                   id: '',
                   width: 0,
                   returnFlag: 0,
                   flights: [],
                   state: '',
                   selectedFlight: {},
                   adultNum: 1,
                   childNum: 0,
                   infantNum: 0,
                   flightIDClick: 0,
                   selectedFlightUniqueId: 0,
                   returnFlightIdClick: 0,
                   url: url,
                   next: initialInfo?.next,
                   prev: initialInfo?.prev,
                   initialInfo: initialInfo,
                   citeisDept: [],
                   citeisDeptByLanguage: [],
                   citeisArrival: [],
                   urlNextNewUrl: url,
                   urlPrevNewUrl: url,
                   allCurrency: allCurrency,
                   currencyInfo: currencyInfo,
                   isCurrency:isCurrency,
                   // currencyTypFlag: '0',
                   rootMainPath: rootMainPath,
                   logo: logo,
                   langWithQuote: "'"+lang+"'",


               }
           },

           delimiters: ['%%', '%%'],
           props: ['arrFlights', 'message', 'citeisDept', 'citeisDeptByLanguage', 'citeisArrival'],
           methods: {
               filterFlightVue: function (element) {

                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   this.arrFlights = storedFlightInfo;

                 /*  if (this.flightsFlagg === 4) {
                       this.flights = storedFlightInfo.return.resultFlight;
                   } else {
                       this.flights = storedFlightInfo.dept.resultFlight;
                   }*/

                   var search;
                   var obj = document.getElementById(element);
                   var elementId = $(obj).attr('id');
                   $(obj).parents('ul.s-u-filter-item-time').find('li span.all-filter').removeClass('checked');
                   $(obj).toggleClass('checked');

                   search = elementId.split("/");
                   if (search[1] === 'all') {
                       $(obj).parents('ul.s-u-filter-item-time').find('li span.checked').removeClass('checked');
                       $(obj).addClass('checked');
                       var indexf = 0;
                       while (indexf < this.typeFilter.length && this.typeFilter.length > 0) {
                           if (this.typeFilter[indexf][0] === search[0]) {
                               this.typeFilter.splice(indexf, 1);
                               indexf--;
                           }
                           indexf++;
                       }
                   } else {
                       if ($(obj).hasClass('checked')) {
                           this.typeFilter.push([search[0], search[1]]);
                       } else {
                           var indexd = 0;
                           while (indexd < this.typeFilter.length && this.typeFilter.length > 0) {
                               if (this.typeFilter[indexd][0] === search[0] && this.typeFilter[indexd][1] === search[1]) {
                                   this.typeFilter.splice(indexd, 1);
                               }
                               indexd++;
                           }
                           if (!$(obj).parents('ul.s-u-filter-item-time').find('li span').hasClass('checked')) {
                               $(obj).parents('ul.s-u-filter-item-time').find('li span.all-filter').addClass('checked');
                           }
                       }
                   }

                   var filterArray = storedFlightInfo;
                   if (filterArray?.dept?.resultFlight.length > 0) {
                       var i = 0;
                       var item1 = [];
                       var item2 = [];
                       var item3 = [];
                       var item4 = [];
                       for (var j = 0; this.typeFilter.length > j && this.typeFilter.length > 0; j++) {
                           if (this.typeFilter[j][0] === 'FlightType_li') {
                               item1.push(this.typeFilter[j][1]);
                           }
                           if (this.typeFilter[j][0] === 'SeatClassEn') {
                               item2.push(this.typeFilter[j][1]);
                           }
                           if (this.typeFilter[j][0] === 'Airline') {
                               item3.push(this.typeFilter[j][1]);
                           }
                           if (this.typeFilter[j][0] === 'timeFilter') {
                               item4.push(this.typeFilter[j][1]);
                           }
                       }

                       if (item1.length === 0 && item2.length === 0 && item3.length === 0 && item4.length === 0) {
                           this.arrFlights = storedFlightInfo;
                           if (this.flightsFlagg === 4) {
                               this.flights = storedFlightInfo.return.resultFlight;
                           } else {
                               this.flights = storedFlightInfo.dept.resultFlight;
                           }
                       } else {
                           filterArray = storedFlightInfo;
                           if (this.flightsFlagg === 4) {
                               while (i < filterArray.return.resultFlight.length) {
                                   if ((jQuery.inArray(filterArray.return.resultFlight[i].FlightType_li, item1) < 0 && item1.length > 0)
                                       || (jQuery.inArray(filterArray.return.resultFlight[i].SeatClassEn, item2) < 0 && item2.length > 0)
                                       || (jQuery.inArray(filterArray.return.resultFlight[i].Airline, item3) < 0 && item3.length > 0)
                                   ) {
                                       filterArray.return.resultFlight.splice(i, 1);
                                       if (i >= 0) {
                                           i--;
                                       }
                                   }
                                   i++;
                               }
                           } else {
                               while (i < filterArray.dept.resultFlight.length) {
                                   if ((jQuery.inArray(filterArray.dept.resultFlight[i].FlightType_li, item1) < 0 && item1.length > 0)
                                       || (jQuery.inArray(filterArray.dept.resultFlight[i].SeatClassEn, item2) < 0 && item2.length > 0)
                                       || (jQuery.inArray(filterArray.dept.resultFlight[i].Airline, item3) < 0 && item3.length > 0)
                                   ) {
                                       filterArray.dept.resultFlight.splice(i, 1);
                                       if (i >= 0) {
                                           i--;
                                       }
                                   }
                                   i++;
                               }
                           }
                           /*--------------timeFilter-------------*/
                           var itemValue = [];
                           var itemValueFinal = [];
                           var timeArray;
                           var timeTemp;
                           if (item4.length > 0) {
                               j = 0;
                               while (j < item4.length) {
                                   timeArray = item4[j].split("-");
                                   itemValue[j] = [parseInt(timeArray[0]), parseInt(timeArray[1])];
                                   j++;
                               }
                               i = 0;
                               if (this.flightsFlagg === 4) {
                                   while (i < filterArray.return.resultFlight.length) {
                                       timeTemp = [];
                                       timeTemp = filterArray.return.resultFlight[i].DepartureTime.split(":");
                                       indexBaze = 0;
                                       while (indexBaze < itemValue.length) {
                                           if (parseInt(timeTemp[0]) >= itemValue[indexBaze][0] && parseInt(timeTemp[0]) <= itemValue[indexBaze][1]) {
                                               itemValueFinal.push(filterArray.return.resultFlight[i]);
                                           }
                                           indexBaze++;
                                       }
                                       i++;
                                   }
                                   filterArray.return.resultFlight = itemValueFinal;
                               } else {
                                   while (i < filterArray.dept.resultFlight.length) {
                                       timeTemp = [];
                                       timeTemp = filterArray.dept.resultFlight[i].DepartureTime.split(":");
                                       indexBaze = 0;
                                       while (indexBaze < itemValue.length) {
                                           if (parseInt(timeTemp[0]) >= itemValue[indexBaze][0] && parseInt(timeTemp[0]) <= itemValue[indexBaze][1]) {
                                               itemValueFinal.push(filterArray.dept.resultFlight[i]);
                                           }
                                           indexBaze++;
                                       }
                                       i++;
                                   }
                                   filterArray.dept.resultFlight = itemValueFinal;
                               }

                           }
                           /*--------------End timeFilter-------------*/



                           this.arrFlights = filterArray;



                           
                            var testArr = {};
                           if (this.flightsFlagg === 4) {
                               if(filterArray.return.resultFlight.length > 0){
                                   this.flights = filterArray.return.resultFlight;
                               }else{
                                   this.flights = [];
                                   testArr = {};
                                   testArr.NameArrival = filterArray.NameArrival;
                                   testArr.NameDeparture = filterArray.NameDeparture;
                                   testArr.seatClassFilter = filterArray.seatClassFilter;
                                   testArr.timeFilter = filterArray.timeFilter;
                                   testArr.typeFlightFilter = filterArray.typeFlightFilter;
                                   this.arrFlights = testArr;

                               }

                           } else {
                               if(filterArray.dept.resultFlight.length > 0){
                                   this.flights = filterArray.dept.resultFlight;
                               }else{
                                   this.flights = [];
                                   testArr = {};
                                   testArr.NameArrival = filterArray.NameArrival;
                                   testArr.NameDeparture = filterArray.NameDeparture;
                                   testArr.seatClassFilter = filterArray.seatClassFilter;
                                   testArr.timeFilter = filterArray.timeFilter;
                                   testArr.typeFlightFilter = filterArray.typeFlightFilter;
                                   this.arrFlights = testArr;
                               }

                           }

                       }

                   } else {

                       this.arrFlights = storedFlightInfo;
                       if (this.flightsFlagg === 4) {
                           this.flights = storedFlightInfo.return.resultFlight;
                       } else {
                           this.flights = storedFlightInfo.dept.resultFlight;
                       }
                   }


                   return (this.flights);
               },
               changeWaysVue: function () {



               },
               sortPriceVue: function () {
                   $("#timeSortSelectVue").removeClass('sorting-active-color-main');
                   $("#priceSortSelectVue").addClass("sorting-active-color-main");
                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   this.arrFlights = storedFlightInfo;
                   var tempFlight = [];
                   tempFlight = this.flights;
                   if ($("#priceSortSelectVue").hasClass('desc')) {
                       $("#priceSortSelectVue").removeClass('desc');
                       $("#priceSortSelectVue").addClass('asc');
                       for (var i = 0; i < parseInt(tempFlight.length) && tempFlight.length > 0; i++) {
                           key = i;
                           for (var j = i; j < parseInt(tempFlight.length) && tempFlight.length > 0; j++) {
                               if (tempFlight[j].AdtPrice > 0 && tempFlight[key].AdtPrice > 0) {
                                   if (parseInt(tempFlight[j].AdtPrice) >= parseInt(tempFlight[key].AdtPrice)) {

                                       temp = tempFlight[i];
                                       temp3 = tempFlight[j];
                                       tempFlight[i] = temp3;
                                       tempFlight[j] = temp;
                                   }
                               }

                           }
                       }

                       this.flights = tempFlight;
                       if ($("#priceSortSelectVue").hasClass('rotated-icon')) {
                           $("#priceSortSelectVue").removeClass('rotated-icon');
                       } else {
                           $("#priceSortSelectVue").addClass('rotated-icon');
                       }
                       return (this.flights);

                   }
                   else {
                       $("#priceSortSelectVue").removeClass('asc');
                       $("#priceSortSelectVue").addClass('desc');
                       for (var i = 0; i < parseInt(tempFlight.length) && tempFlight.length > 0; i++) {
                           key = i;
                           for (var j = i; j < parseInt(tempFlight.length) && tempFlight.length > 0; j++) {
                               if (tempFlight[j].AdtPrice > 0 && tempFlight[key].AdtPrice > 0) {
                                   if (parseInt(tempFlight[j].AdtPrice) <= parseInt(tempFlight[key].AdtPrice)) {
                                       temp = tempFlight[i];
                                       temp3 = tempFlight[j];
                                       tempFlight[i] = temp3;
                                       tempFlight[j] = temp;
                                   }
                               }

                           }
                       }

                       this.flights = tempFlight;
                       if ($("#priceSortSelectVue").hasClass('rotated-icon')) {
                           $("#priceSortSelectVue").removeClass('rotated-icon');
                       } else {
                           $("#priceSortSelectVue").addClass('rotated-icon');
                       }
                       return (this.flights);

                   }


               },
               sortTimeVue: function () {
                   $("#priceSortSelectVue").removeClass('sorting-active-color-main');
                   $("#timeSortSelectVue").addClass("sorting-active-color-main");
                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   this.arrFlights = storedFlightInfo;
                   var tempFlight = [];
                   tempFlight = this.flights;
                   var time = [];
                   var timeTemp = [];
                   for (var i = 0; i < parseInt(tempFlight.length) && tempFlight.length > 0; i++) {
                       timeTemp = [];
                       timeTemp = tempFlight[i].DepartureTime.split(":");
                       time[i] = parseInt(timeTemp[0]);
                   }
                   var timeTemp1,timeTemp2;
                   if ($("#timeSortSelectVue").hasClass('desc')) {
                       $("#timeSortSelectVue").removeClass('desc');
                       $("#timeSortSelectVue").addClass('asc');
                       for (var i = 0; i < parseInt(tempFlight.length) && tempFlight.length > 0; i++) {
                           key = i;
                           for (var j = i; j < parseInt(tempFlight.length) && tempFlight.length > 0; j++) {
                               timeTemp1 = tempFlight[j].DepartureTime.split(":");
                               timeTemp2 = tempFlight[key].DepartureTime.split(":");
                               if (parseInt(timeTemp1[0]) >= parseInt(timeTemp2[0])) {

                                   temp = tempFlight[i];
                                   temp3 = tempFlight[j];
                                   tempFlight[i] = temp3;
                                   tempFlight[j] = temp;
                               }
                           }
                       }
                       this.flights = tempFlight;
                       if ($("#timeSortSelectVue").hasClass('rotated-icon')) {
                           $("#timeSortSelectVue").removeClass('rotated-icon');
                       } else {
                           $("#timeSortSelectVue").addClass('rotated-icon');
                       }
                       return (this.flights);

                   } else {
                       $("#timeSortSelectVue").removeClass('asc');
                       $("#timeSortSelectVue").addClass('desc');
                       for (var i = 0; i < parseInt(tempFlight.length) && tempFlight.length > 0; i++) {
                           key = i;
                           for (var j = i; j < parseInt(tempFlight.length) && tempFlight.length > 0; j++) {
                               timeTemp1 = tempFlight[j].DepartureTime.split(":");
                               timeTemp2 = tempFlight[key].DepartureTime.split(":");
                               if (parseInt(timeTemp1[0]) < parseInt(timeTemp2[0])) {

                                   temp = tempFlight[i];
                                   temp3 = tempFlight[j];
                                   tempFlight[i] = temp3;
                                   tempFlight[j] = temp;
                               }
                           }
                       }
                       this.flights = tempFlight;
                       if ($("#timeSortSelectVue").hasClass('rotated-icon')) {
                           $("#timeSortSelectVue").removeClass('rotated-icon');
                       } else {
                           $("#timeSortSelectVue").addClass('rotated-icon');
                       }
                       return (this.flights);
                   }
               },
               returnFlightsVue: function (flightId, type, UniqueCode) {
                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   var selectedFlight;
                   var adt = $('#adult_qty').val();
                   var chd = $('#child_qty').val();
                   var inf = $('#infant_qty').val();
                   var flights = [];
                   var TxtBottun = useXmltag("Selectionflight");
                   this.typeFilter = [];
                   if (type == 'dept') {
                       flights = storedFlightInfo?.dept?.resultFlight;
                   } else {

                       flights = storedFlightInfo?.return?.resultFlight;

                   }

                   for (var i = 0; i < parseInt(flights.length) && flights.length > 0; i++) {

                       if (flights[i].FlightID === flightId && flights[i].UniqueCode === UniqueCode) {
                           selectedFlight = flights[i];
                       }
                   }
                   var adt = $('#adult_qty').val();
                   var chd = $('#child_qty').val();
                   var inf = $('#infant_qty').val();
                   var TypeZoneFlight = 'Local';
                   var Flight = selectedFlight?.FlightID;
                   var ReturnFlightID = selectedFlight?.ReturnFlightID;
                   var AirlineCode = selectedFlight?.Airline;
                   var SourceId = selectedFlight?.SourceId;
                   var FlightType = selectedFlight?.FlightType_li;
                   var Capacity = selectedFlight?.Capacity;
                   var PrivateM4 = 'public';
                   var UniqueCode = selectedFlight?.UniqueCode;
                   var CurrencyCode = '';
                   var priceWithoutDiscount = (selectedFlight?.AdtWithDiscount);
                   var userCapacity = (parseInt(adt) + parseInt(chd));
                   var MultiWay = this.initialInfo.MultiWay;
                   var FlightDirection = selectedFlight?.DirectionFlight;
                   var CapacityCalculate = userCapacity + 1;
                   var FlightReplaced = '';
                   var TxtBottun = '';

                   if (selectedFlight !== null && typeof selectedFlight !== "undefined") {
                       FlightReplaced = Flight.replace(/#/g, '');
                   }

                   $('#FlightIdSelect').val(Flight);
                   if (TypeZoneFlight == 'Local') {
                       if (MultiWay != 'TwoWay') {

                           TxtBottun = useXmltag("Selectionflight");
                       } else {
                           if (FlightDirection == 'return') {
                               TxtBottun = useXmltag('PickBackFlight');
                           } else {
                               TxtBottun = useXmltag('PickWentFlight');
                           }
                       }
                   } else {
                       TxtBottun = useXmltag("Selectionflight");
                   }
                   $.ajax({
                       type: 'POST',
                       context: this,
                       url: amadeusPath + 'user_ajax.php',
                       data: {
                           flag: 'checkTicketDiscountPrice',
                           AirlineCode: AirlineCode,
                           FlightType: FlightType,
                           Price: priceWithoutDiscount,
                           TypeZoneFlight: TypeZoneFlight,
                           SourceId : SourceId
                       },
                       success: function (data) {

                           var res = data.split(':');
                           if ((MultiWay == 'OneWay' && res[1] == 'YES') || (MultiWay == 'TwoWay' && (res[1] == 'YES' || $(".selectedTicket .priceSortAdt span").length > 0))) {

                               var payablePrice = parseInt(res[0]);

                               if ((MultiWay == 'TwoWay' && FlightDirection == 'return' && TypeZoneFlight == 'Local')) {
                                   if ($(".selectedTicket .priceSortAdt span").length > 0) {
                                       payablePrice = payablePrice + parseInt($(".selectedTicket .priceSortAdt span").html().replace(/,/g, ''));
                                   } else {
                                       payablePrice = payablePrice + parseInt($(".selectedTicket .priceSortAdt i").html().replace(/,/g, ''));
                                   }
                               }

                               // var text = "مایلم بلیط را بدون ثبت نام با قیمت " + number_format_vue(payablePrice) + " خریداری کنم";
                               var text = useXmltag("Purchasewithoutregistration");
                               $('#noLoginBuy').val(text);

                           } else {
                               var text = useXmltag("Purchasewithoutregistration");
                               $('#noLoginBuy').val(text);
                           }
                           FlightReplaced = FlightReplaced.replace('==', '');
                           FlightReplaced = FlightReplaced.replace('=', '');
                           FlightReplaced = FlightReplaced.replace('#', '');

                           $('#nextStep_' + FlightReplaced).attr('disabled', 'disabled').css('opacity', '0.5').text(useXmltag("Pending"));
                           $('#loader_check_' + FlightReplaced).css('opacity', '1').show();


                           $.ajax({
                               type: 'POST',
                               url: amadeusPath + 'user_ajax.php',
                               context: this,
                               dataType: 'JSON',
                               data:
                                   {
                                       flag: 'revalidate_Fight',
                                       adt: adt,
                                       chd: chd,
                                       inf: inf,
                                       Flight: Flight,
                                       ReturnFlightID: ReturnFlightID,
                                       AirlineCode: AirlineCode,
                                       UniqueCode: UniqueCode,
                                       SourceId: SourceId,
                                       MultiWay: MultiWay,
                                       FlightDirection: FlightDirection,
                                       CurrencyCode: CurrencyCode,
                                       uniq_id: $('.selected_session_filght_Id').val()
                                   },
                               success: function (data) {

                                   if (data.result_status == 'SuccessLogged' || data.result_status == 'SuccessNotLoggedIn') {

                                       $('#session_filght_Id').val(data.result_uniq_id);
                                       $("#ZoneFlight").val(TypeZoneFlight);
                                       $('#loader_check_' + FlightReplaced).hide();
                                       $('#nextStep_' + FlightReplaced).removeAttr('disabled', true).css('opacity', '1').text(TxtBottun);
                                       if ((FlightDirection == 'dept') && TypeZoneFlight == 'Local') {
                                           this.selectedFlightUniqueId = $('#session_filght_Id').val();

                                       }
                                       if ((MultiWay == 'TwoWay' && FlightDirection == 'dept')) {
                                           $('html, body').animate({scrollTop: $('.selectedTicket').offset().top}, 3000);
                                           this.flightsFlagg = 4;
                                           this.flights = storedFlightInfo.return.resultFlight;
                                           this.selectedFlight = selectedFlight;

                                           $('.international-available-box.returnFlight').filter(function (index) {
                                               //if dept and return date is the same, return flights filter by dept choose
                                               if ($('#dept_date_local').val() == $('#dept_date_local_return').val()) {
                                                   var returnFlightTime = $(this).find('.timeSortDep').html();
                                                   return (returnFlightTime.substr(0, 2) > data.result_selected_time && $(this).find('.source').html() != 'reservation');
                                               } else {
                                                   return $(this).find('.source').html() != 'reservation';
                                               }
                                           }).fadeIn(1500);

                                       } else {
                                           if (data.result_status == 'SuccessLogged') {
                                               if (SmsAllow == '1' || TelAllow == '1') {
                                                   var isShowLoginPopup = $('#isShowLoginPopup').val();
                                                   var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                                   if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                                       $("#login-popup").trigger("click");
                                                   } else {
                                                       popupBuyNoLogin(useTypeLoginPopup);
                                                   }

                                               } else {
                                                   send_info_passengers();
                                               }

                                           } else if (data.result_status == 'SuccessNotLoggedIn') {
                                               var isShowLoginPopup = $('#isShowLoginPopup').val();
                                               var useTypeLoginPopup = $('#useTypeLoginPopup').val();
                                               if (isShowLoginPopup == '' || isShowLoginPopup == '1') {
                                                   $("#login-popup").trigger("click");
                                               } else {
                                                   popupBuyNoLogin(useTypeLoginPopup);
                                               }
                                           }
                                       }
                                   } else if (data.result_status == 'Error') {

                                       $('#loader_check_' + FlightReplaced).hide();
                                       $('#nextStep_' + FlightReplaced).removeAttr('disabled', 'disabled').css('opacity', '0.5').text(useXmltag("NonBookable")).css('background', '#A40127');
                                       $.alert({
                                           title: useXmltag("SearchFlight"),
                                           icon: 'fa fa-refresh',
                                           content: data.result_message,
                                           rtl: true,
                                           type: 'red'
                                       });
                                       return false;
                                   } else {
                                       $('#loader_check_' + FlightReplaced).hide();
                                       $('#nextStep_' + FlightReplaced).removeAttr('disabled', 'disabled').css('opacity', '0.5').text(useXmltag("NonBookable")).css('background', '#A40127');
                                       $.alert({
                                           title: useXmltag("SearchFlight"),
                                           icon: 'fa fa-refresh',
                                           content: useXmltag("CanNotBookedTryLater"),
                                           rtl: true,
                                           type: 'red'
                                       });
                                       return false;
                                   }
                               }
                           });
                       }
                   });
                   return (this.flights);
               },
               undoFlightSelectVue: function () {
                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   if (typeof (this.arrFlights.dept) !== "undefined" && this.arrFlights.dept !== '') {
                       this.returnFlag = 0;
                       this.flights = storedFlightInfo.dept.resultFlight;
                       this.flightsFlagg = 3;
                       this.state = '';
                       return (this.flights);
                   } else {
                       this.flightsFlagg = 1;
                   }
               },
               totalRange: function () {
                   if ($("#minPriceRange").val() > 0 || $("#maxPriceRange").val() > 0) {
                       var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                       var minPrice = parseInt($("#minPriceRange").val());
                       var maxPrice = parseInt($("#maxPriceRange").val());
                       this.arrFlights = storedFlightInfo;
                       var arrayFilter = [];
                       var resultArray = [];
                       if (this.flightsFlagg === 4) {
                           arrayFilter = storedFlightInfo.return.resultFlight;
                       } else {
                           arrayFilter = storedFlightInfo.dept.resultFlight;
                       }
                       var i = 0;
                       var j = 0;
                       while (i < arrayFilter.length && arrayFilter.length > 0) {
                           if (arrayFilter[i].AdtPrice >= minPrice && arrayFilter[i].AdtPrice <= maxPrice) {
                               resultArray[j] = arrayFilter[i];
                               j++;
                           }
                           i++;
                       }
                       this.flights = resultArray;
                       return (this.flights);

                   }
               },
               nextDayVue: function () {
                   localStorage.setItem("currencyInfo", this.currencyInfo);
                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   var next = this.url.split("/");
                   var newUrl;
                   if (storedFlightInfo.MultiWay == 'OneWay') {
                       newUrl = next[0] + '//' + next[1] + '/' + next[2] + '/' + next[3] + '/' + next[4] + '/' + next[5] + '/' + next[6] + '/' + next[7] + '/' + this.next + '/' + next[9] + '/' + next[10];
                       this.url = newUrl;
                   }
               },
               prevDayVue: function () {
                   localStorage.setItem("currencyInfo", this.currencyInfo);
                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   var prev = this.url.split("/");
                   var newUrl;
                   if (storedFlightInfo.MultiWay == 'OneWay') {
                       newUrl = prev[0] + '//' + prev[1] + '/' + prev[2] + '/' + prev[3] + '/' + prev[4] + '/' + prev[5] + '/' + prev[6] + '/' + prev[7] + '/' + this.prev + '/' + prev[9] + '/' + prev[10];
                       this.url = newUrl;
                   }
               },
               togglecalendar: function () {
                   $('#lowest').toggle();
               },
               ajaxGetFlights: function () {
                   let _self = this;
                   axios.post(amadeusPath + 'axios',
                       {
                           method: 'getFlight',
                           urlWeb: location.pathname.substring(0),
                       },
                       {
                           'Content-Type': 'application/json'
                       }).then(function (response) {
                       // your action after success
                       $("#loader-page").hide();
                       $("#s-u-result-wrapper-ul").css('display','block');
                       /*$(".loader-parent").hide();*/
                       $("#result-vue").show();
                       var result;
                       result = JSON.stringify(response.data);
                       localStorage.setItem("FlightInfo", result);
                       _self.arrFlights = response.data;
                       if (response.data.MultiWay === 'TwoWay') {
                           _self.flightsFlagg = 3;
                       } else if (response.data.MultiWay === 'OneWay') {
                           _self.flightsFlagg = 2;
                       }
                       _self.flights = _self.arrFlights?.dept?.resultFlight;
                       var storedFlightInfo = response.data;

                       if (storedFlightInfo !== null && storedFlightInfo !== undefined) {
                           if (storedFlightInfo?.dept?.resultFlight.length > 0) {
                               $("#s-u-result-wrapper-ul").hide();
                           }
                           if (storedFlightInfo.dept) {
                               var minPrice = parseInt(storedFlightInfo.dept.minPrice),
                                   maxPrice = parseInt(storedFlightInfo.dept.maxPrice);
                           } else {
                               var minPrice = NaN, maxPrice = NaN;

                           }
                           $('.f-loader-check').fadeOut("slow");
                           if(minPrice > 0 && maxPrice >0)
                           {
                               $('#slider-range').slider({
                                   range: true,
                                   min: minPrice,
                                   max: maxPrice,
                                   step: 1000,
                                   values: [minPrice, maxPrice],
                                   slide: function (event, ui) {
                                       $("#amount").val(addCommas(ui.values[0]) + " - " + addCommas(ui.values[1]));
                                       minPrice = ui.values[0];
                                       maxPrice = ui.values[1];
                                       $("#minPriceRange").attr('value', minPrice);
                                       $("#maxPriceRange").attr('value', maxPrice);
                                       /* filterflightPrice();*/

                                   }
                               });
                               $("#amount").val(addCommas(minPrice) + " - " + addCommas(maxPrice));
                           }else{
                               $('#flight_price_range').css('display','none');
                           }

                          if($(window).width() > 576){

                           $("#lowest").css('display', 'block');
                          }
                           getUserAccount();
                           // if (_self.currencyInfo) {
                           //     _self.ConvertCurrency(_self.currencyInfo.CurrencyCode, _self.currencyInfo.CurrencyFlag, _self.currencyInfo.CurrencyTitleFa);
                           // }
                       }
                   }.bind(_self)) .catch(function (error) {
                      
                           _self.currencyTypFlag = '0';
                           _self.currencyInfo = {};
                           // your action on error success
                           console.log(error);
                       }.bind(_self));

               },
               ConvertCurrency: function (Code, Icon, Title) {
                   if (typeof Icon === "undefined") {
                       if (typeof this.currencyInfo?.CurrencyFlag !== "undefined") {
                           Icon = this.currencyInfo?.CurrencyFlag;
                       } else {
                           Icon = 'Iran.png';
                       }
                   }
                   var ValCurrency = Code;
                   var tempPrice;
                   var currencyInfo;
                   var storedFlightInfo = JSON.parse(localStorage.getItem("FlightInfo"));
                   this.flights = storedFlightInfo?.dept?.resultFlight;
                   var tempPriceArr = this.flights;
                   $('#IconDefaultCurrency').attr('src', rootMainPath + '/gds/pic/flagCurrency/' + Icon);
                   $('.TitleDefaultCurrency').html(Title);

                   $.ajax({
                       type: 'POST',
                       url: amadeusPath + 'user_ajax.php',
                       context: this,
                       dataType: 'JSON',
                       data:
                           {
                               flag: 'CurrencyEquivalent',
                               ValCurrency: ValCurrency,

                           },
                       success: function (response) {
                           var stri;
                           var striW;
                           var calculateCurrencyi;
                           var calculateCurrencyiW;
                           if (ValCurrency > 0) {
                               this.currencyTypFlag = response.CurrencyCode;
                               for (var i = 0; i < tempPriceArr.length > 0; i++) {
                                   stri = tempPriceArr[i].priceWithOutCurrency;
                                   striW = tempPriceArr[i].priceDiscountWithOutCurrency;

                                   calculateCurrencyi = (stri / response.EqAmount);
                                   if (calculateCurrencyi % 1 !== 0) {
                                       calculateCurrencyi = calculateCurrencyi.toFixed(2); //float
                                   }else{
                                       calculateCurrencyi = 0 ;
                                   }

                                   if(striW > 0 ){
                                       calculateCurrencyiW = (stri / response.EqAmount);
                                       if (calculateCurrencyiW % 1 !== 0) {
                                           calculateCurrencyiW = calculateCurrencyiW.toFixed(2); //float
                                       }else{
                                           calculateCurrencyiW = 0;
                                       }
                                       tempPriceArr[i].AdtWithDiscount = calculateCurrencyiW;
                                   }
                                   tempPriceArr[i].AdtPrice = calculateCurrencyi;

                               }
                               currencyInfo = JSON.stringify(response);
                               this.currencyTypFlag = parseInt(currencyInfo.CurrencyCode);

                               $('.CurrencyText').html(response.CurrencyTitleEn);

                           } else {
                               this.currencyTypFlag = '0';
                               currencyInfo = JSON.stringify({});
                               if(lang !='fa'){
                                   for (var i = 0; i < tempPriceArr.length > 0; i++) {
                                       stri = tempPriceArr[i].priceWithOutCurrency;
                                       striW = tempPriceArr[i].priceDiscountWithOutCurrency;

                                       tempPriceArr[i].AdtWithDiscount = striW > 0 ? strW : 0;

                                       tempPriceArr[i].AdtPrice = stri;

                                   }
                               }else{
                                   tempPriceArr = storedFlightInfo?.dept?.resultFlight;

                               }
                               $('.CurrencyText').html(useXmltag("Rial"));
                           }
                           localStorage.setItem("currencyInfo", currencyInfo);


                           this.flights = tempPriceArr;
                           
                           $('.CurrencyCode').val(ValCurrency);
                       }
                   });


               },

           },
           created: function () {

               this.message = this.innerHTML; // <---- NOT WORKING
           },
           mounted() {
               var gdsSwitch = 'local';
               this.citeisDept = JSON.parse(localStorage.getItem("citeisDept"));
               this.citeisArrival = JSON.parse(localStorage.getItem("citeisArrival"));
               var elem = document.getElementById("myBar");
               var elementInternal = document.getElementById("myBarSpan");
               /*    if(gdsSwitch == 'local'){
                       this.id = setInterval(frame1, 100);
                   }
                   function frame1() {

                       if (this.width == 100) {
                           clearInterval(this.id);
                       } else if (this.width < 30) {
                           this.width++;
                           elem.style.width = this.width + '%';
                           if (elementInternal) {
                               elementInternal.innerHTML = '% ' + this.width * 1;
                           }


                       } else if (this.width >= 30 && this.width < 50) {
                           setInterval(frame2, 2500);
                       } else if (this.width >= 50 && this.width < 80) {
                           setInterval(frame3, 3000);
                       } else if (this.width >= 80 && this.width < 100) {
                           setInterval(frame4, 4000);
                       }
                   }
                   function frame2() {
                       if (this.width >= 30 && this.width < 50) {
                           this.width++;
                           elem.style.width = this.width + '%';
                           if (elementInternal) {
                               elementInternal.innerHTML = '% ' + this.width * 1;
                           }

                       }
                   }
                   function frame3() {
                       if (this.width >= 50 && this.width < 80) {
                           this.width++;
                           elem.style.width = this.width + '%';
                           if (elementInternal) {
                               elementInternal.innerHTML = '% ' + this.width * 1;
                           }

                       }
                   }
                   function frame4() {
                       if (this.width >= 80 && this.width < 100) {
                           this.width++;
                           elem.style.width = this.width + '%';
                           if (elementInternal) {
                               elementInternal.innerHTML = '% ' + this.width * 1;
                           }

                       }
                   }
                   $('.images-circle').owlCarousel({
                       items: 1,
                       rtl: true,
                       loop: true,
                       mouseDrag: false,
                       touchDrag: false,
                       autoplay: true,
                       smartSpeed: 0.1,
                       pullDrag: false,
                       margin: 0,
                       autoplaySpeed: 1,
                       dots: false,
                       autoplayHoverPause: true,
                   });*/
               if (typeof (this.initialInfo) !== "undefined" && this.initialInfo !== '') {
                   this.width = '100%';
                   $("#myBar").css('width', '100%');
                   $("#myBarSpan").attr('value', '100%');
                   $("#myBarSpan").html('100%');

                   if (this.initialInfo?.MultiWay == 'TwoWay') {
                       $("#dewey").attr('checked','');
                       $("#huey").removeAttr('checked');
                       $("#dewey").addClass('checked');
                       this.flightsFlagg = 3;
                   } else {
                       $("#huey").attr('checked','');
                       $("#dewey").removeAttr('checked');
                       $("#huey").addClass('checked');
                       $("#returnDate").addClass('hidden');
                       this.flightsFlagg = 2;
                   }

                       this.adultNum = parseInt(this.initialInfo.dataSearch.adult);
                       this.childNum = parseInt(this.initialInfo.dataSearch.child);
                       this.infantNum = parseInt(this.initialInfo.dataSearch.infant);

                       $("#qty1").attr('value', this.adultNum);
                       $("#qty2").attr('value', this.childNum);
                       $("#qty3").attr('value', this.infantNum);

                   $("#dept_date_local").attr('value', this.initialInfo?.departureDate);
                   $("#dept_date_local_return").attr('value', this.initialInfo?.arrivalDate);

               }
               var urlTemp = this.url.split("/");
               this.urlNextNewUrl = urlTemp[0] + '//' + urlTemp[1] + '/' + urlTemp[2] + '/' + urlTemp[3] + '/' + urlTemp[4] + '/' + urlTemp[5] + '/' + urlTemp[6] + '/' + urlTemp[7] + '/' + this.next + '/' + urlTemp[9] + '/' + urlTemp[10];
               this.urlPrevNewUrl = urlTemp[0] + '//' + urlTemp[1] + '/' + urlTemp[2] + '/' + urlTemp[3] + '/' + urlTemp[4] + '/' + urlTemp[5] + '/' + urlTemp[6] + '/' + urlTemp[7] + '/' + this.prev + '/' + urlTemp[9] + '/' + urlTemp[10];
               this.ajaxGetFlights();
               $('.select2').select2();


           },

           computed: {},


       });
       new Vue({
           delimiters: ['%%', '%%'],
           el: "#appFlight",
           data: {
               arrFlights: {},
               flightsFlagg: 0,
               initialInfo: {},
               Advertises : []
           },

           methods: {},

           mounted() {
               /*createTicket();*/
           }

       });

   });




});
function number_format_vue(num) {
    num = num.toString();
    return num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
function submitLocalSideVue(type) {
    let _self = this;
    $('#loader_check_submit').css('display', 'block');
    $('#sendFlight').css('opacity', '0.4').attr('onclick', false);

    var initialInfolast =JSON.parse(localStorage.getItem("initialInfo"));
    var multiWay;
    if($("#returnDate").hasClass('hidden')){
        multiWay = '1';
        initialInfolast.MultiWay = 'OneWay';
    }else{
        multiWay = '2';
        initialInfolast.MultiWay = 'TwoWay';
    }


    var origin = $("#origin_local").val();
    var nameorgin = $("#destination_local").attr('title');
    var namearriv = $("#destination_local").attr('title');

    var destination = $("#destination_local").val();
    var dept_date = $("#dept_date_local").val();
    var return_date = '';
    var flightNumber = $("#searchFlightNumber").val();

    if ($("#dept_date_local_return").parents('.s-u-form-block').css('display','block')) {
        return_date = $("#dept_date_local_return").val();

    }

    // var classf = $("#classf_local").val();
    var adult = Number($("#qty1").val());
    var child = Number($("#qty2").val());
    var infant = Number($("#qty3").val());

    if (origin == "" || destination == "" || dept_date == "" || adult == "" || (multiWay == '2' && return_date == '')) {

        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("Pleaseenterrequiredfields"),
            rtl: true,
            type: 'red'
        });
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSideVue()');
    } else if (adult == 0) {
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("LeastOneAdult"),
            rtl: true,
            type: 'red'
        });
        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSideVue()');
    } else if ((adult + child) > 9 || infant > adult) {

        $('#loader_check_submit').css('display', 'none');
        $('#sendFlight').css('opacity', '1').attr('onclick', 'submitLocalSideVue()');
        $.alert({
            title: useXmltag("BookTicket"),
            icon: 'fa fa-cart-plus',
            content: useXmltag("SumAdultsChildrenNoGreaterThanAdult"),
            rtl: true,
            type: 'red'
        });
    } else {

        initialInfolast.dataSearch.orgin = origin;
        initialInfolast.dataSearch.destination = destination;
        initialInfolast.dataSearch.departureDate = dept_date;
        initialInfolast.dataSearch.arrivalDate = return_date;
        initialInfolast.dataSearch.adult = adult;
        initialInfolast.dataSearch.child = child;
        initialInfolast.dataSearch.infant = infant;

        localStorage.setItem("initialInfo",initialInfolast);

        _self.initialInfo = initialInfolast;
        if (dept_date.indexOf('/') > -1) {
            var dept_date_aa = dept_date.replace('/', '-');
            var date_final = dept_date_aa.replace('/', '-');
        } else {
            var date_final = dept_date;
        }

        if (return_date.indexOf('/') > -1) {
            var return_date_aa = return_date.replace('/', '-');
            var return_date_final = return_date_aa.replace('/', '-');
        } else {
            var return_date_final = return_date;
        }

        if (multiWay == 2) {
            date_final = date_final + "&" + return_date;
        }else{
            date_final = date_final;
        }

        var ori_dep = origin + "-" + destination;
        var num = adult + "-" + child + "-" + infant;
        if (type != "" && type == 'international') {
            var typeSearch = 'international';
        } else {
            var typeSearch = 'searchFlight'
        }

        var flightNumberSearch = "";
       /* if (flightNumber != '' && typeof flightNumber !== 'undefined') {
            var flightNumberSearch = "/" + flightNumber;
        }*/
        var url = amadeusPathByLang + typeSearch + "/" + multiWay + "/" + ori_dep + "/" + date_final + "/Y/" + num + flightNumberSearch;
        window.location.href = url;

    }
}

async function dateRout2(){
    var result = {};
    let _self = this;

    let res = await axios.post(amadeusPath + 'axios',
        {
            method:'dateRout',
            urlWeb : location.pathname.substring(0),
        },
        {
            'Content-Type':'application/json'
        }).then(async function (response) {

        // your action after success
        result  = JSON.stringify(response.data);
        localStorage.setItem("initialInfo",result);
        _self.initialInfo = response.data;
        if(response.data.MultiWay === 'TwoWay'){
            _self.flightsFlagg = 3;
        }else if(response.data.MultiWay === 'OneWay'){
            _self.flightsFlagg = 2;
        }
        _self.logo = localStorage.getItem("logo");
        _self.currencyInfo = JSON.parse(localStorage.getItem("currencyInfo"));

        var url = window.location.href;
        var rootMain = url.split("/");
        _self.rootMainPath = rootMain[0];

        if(Object.keys(_self.currencyInfo).length === 0) {
            _self.currencyTypFlag = '0';
        }else{
            _self.currencyTypFlag = parseInt(_self.currencyInfo.CurrencyCode);
        }
        if(result!== null && result!== undefined){
            var citeisDept = await getCities('dept',response.data.dataSearch);

            _self.citeisDept = citeisDept;
            var citeisArrival = await getCities('arrival',response.data.dataSearch);
            
            _self.citeisArrival = citeisArrival;
        }
    }.bind(_self)).catch(function (error) {
        // your action on error success
        console.log(error);
    }.bind(_self));

    // Don't forget to return something
   return res;
}
async function getCities(param,result){
    var initialInfo =JSON.parse(localStorage.getItem("initialInfo"));
    let _self = this;
    var paramArr = [];
    paramArr[0] = param;
    paramArr[1] = result;
    await axios.post(amadeusPath + 'axios',
        {
            method:'getCities',
            param:paramArr,
        },
        {
            'Content-Type':'application/json'
        }).then(function (response) {
        // your action after success
        var result;
        if(param === 'dept'){
            result  = JSON.stringify(response.data);
            localStorage.setItem("citeisDept",result);
            _self.citeisDept = result;
        }else{
            result  = JSON.stringify(response.data);
            localStorage.setItem("citeisArrival",result);
            _self.citeisArrival = result;
           }
    }.bind(_self))
    .catch(function (error) {
        // your action on error success
        console.log(error);
    }.bind(_self));
}
function getUserAccount() {

    var initialInfo = JSON.parse(localStorage.getItem("initialInfo"));
    var checkVisible = false;
    var origin = initialInfo?.dataSearch?.origin;
    var destination = initialInfo?.dataSearch?.destination;
    var checkOpenFifteenFlight = $('#checkOpenFifteenFlight').val();
    var typePage;
    if ($("#lowerSortSelect").hasClass('lowerSortSelectVue')) {
        typePage = 'searchFlight';
    } else {
        typePage = 'Local';
    }

    if (checkOpenFifteenFlight == "") {
        $('.flightFifteen').fadeIn();
        $('#showDataFlight').html('');
        $('#checkOpenFifteenFlight').val('buys');
        if (!checkVisible) {
            $.ajax({
                type: 'POST',
                url: amadeusPath + 'user_ajax.php',
                data:
                    {
                        Origin: origin,
                        Destination: destination,
                        type: typePage,
                        flag: "fifteenFlight"
                    },
                success: function (data) {
                    $('#showDataFlight').html(data);
                    $('.flightFifteen').fadeOut("slow");
                    $('#showDataFlight').owlCarousel({
                        items: 2,
                        dots:false,
                        navigation: true,
                        rtl: true,
                        nav: true,
                        margin: 7,
                        responsive: {


                            400: {
                                margin: 7.5,
                                items: 3,
                            },

                            576: {
                                margin: 7,
                                items: 4,
                            },
                            768: {
                                margin: 7,
                                items: 5,
                            },
                            990: {
                                items: 5,
                            },
                            1200: {
                                items: 6,
                            }
                        }
                    });


                }

            });
        }
    }

}
$(function () {

    $('body').delegate('.btn-number-js', 'click', function (e) {
        e.preventDefault();


        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    $(".btn-number-js[data-type='plus'][data-field='" + fieldName + "']").prop("disabled", false);
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).prop("disabled", true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                    $(".btn-number-js[data-type='minus'][data-field='" + fieldName + "']").prop("disabled", false);
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).prop("disabled", true);
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(".btn-number-js[data-type='minus'][data-field='" + fieldName + "']").prop("disabled", false);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number-js').focusin(function () {
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number-js').change(function () {

        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name1 = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number-js[data-type='minus'][data-field='" + name1 + "']").prop("disabled", false)
        } else {
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number-js[data-type='plus'][data-field='" + name1 + "']").prop("disabled", false)
        } else {
            $(this).val($(this).data('oldValue'));
        }

    });
    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    function filterSlider(elem) {
        var price = parseInt($(elem).data("price"), 10);
        return price >= minPrice && price <= maxPrice;
    }
    function filterflightPrice() {
        $(".international-available-box").hide().filter(function () {
            return filterSlider(this);
        }).show();
    }

});


