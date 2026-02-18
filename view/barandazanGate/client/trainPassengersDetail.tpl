<link href="assets/css/jquery.counter-analog.css" rel="stylesheet" type="text/css" />
{load_presentation_object filename="trainPassengersDetail" assign="objDetail"}
{assign var="InfoTrain" value=$objDetail->getTrain()}
{literal}
    <script type="text/javascript">
      window.onload = () => {
        getServiceTrain()
        getViewPriceTicket()
        getFreePassengerServices()
      }

    </script>
{/literal}

{$objDetail->getCustomers()}
<div style="display:none" class="lazy-loader-parent lazy_loader_flight">
    <div class="modal-content-flight">
        <div class="modal-body-flight">
            <div class="img_timeoute_svg">

                <svg id="Capa_1" enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                     xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <circle cx="211.748" cy="217.219" fill="#365e7d" r="211.748" />
                        <path d="m423.496 217.219c0-116.945-94.803-211.748-211.748-211.748-4.761 0-9.482.173-14.165.483 105.408 6.964 189.73 91.05 197.055 196.357.498 7.155-5.367 13.072-12.538 12.919-1.099-.023-2.201-.035-3.306-.035-87.332 0-158.129 70.797-158.129 158.129 0 8.201.627 16.255 1.833 24.118 2.384 15.542-8.906 29.961-24.594 31.022-.107.007-.214.014-.321.021 4.683.309 9.404.483 14.165.483 117.636-.001 211.748-95.585 211.748-211.749z"
                              fill="#2b4d66" />
                        <circle cx="211.748" cy="217.219" fill="#f4fbff" r="162.544" />
                        <path d="m374.292 217.219c0-89.77-72.773-162.544-162.544-162.544-4.404 0-8.765.181-13.08.525 83.965 6.687 149.953 77.174 149.461 162.972-.003.004-.006.007-.009.011-68.587 13.484-119.741 70.667-126.655 138.902-1.189 11.73-10.375 21.111-22.124 22.097-.224.019-.448.037-.673.055 94.649 7.542 175.624-67.027 175.624-162.018z"
                              fill="#daf1f4" />
                        <g>
                            <g>
                                <path d="m211.748 104.963c-4.268 0-7.726-3.459-7.726-7.726v-10.922c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.922c0 4.267-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d" />
                            </g>
                            <g>
                                <path d="m296.588 140.105c-1.978 0-3.955-.755-5.464-2.264-3.017-3.017-3.017-7.909.001-10.927l7.723-7.722c3.017-3.017 7.909-3.016 10.927.001 3.017 3.017 3.017 7.909-.001 10.927l-7.723 7.722c-1.508 1.508-3.486 2.263-5.463 2.263z"
                                      fill="#365e7d" />
                            </g>
                            <g>
                                <path d="m342.653 224.945h-10.923c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.726 7.726z"
                                      fill="#365e7d" />
                            </g>
                            <g>
                                <path d="m214.925 359.027c-4.268 0-7.726-3.459-7.726-7.726v-10.923c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v10.923c.001 4.268-3.458 7.726-7.726 7.726z"
                                      fill="#365e7d" />
                            </g>
                            <g>
                                <path d="m119.185 317.508c-1.977 0-3.955-.755-5.464-2.263-3.017-3.018-3.017-7.909 0-10.928l7.723-7.723c3.018-3.016 7.909-3.016 10.928 0 3.017 3.018 3.017 7.909 0 10.928l-7.723 7.723c-1.51 1.509-3.487 2.263-5.464 2.263z"
                                      fill="#365e7d" />
                            </g>
                            <g>
                                <path d="m91.766 224.945h-10.922c-4.268 0-7.726-3.459-7.726-7.726 0-4.268 3.459-7.726 7.726-7.726h10.923c4.268 0 7.726 3.459 7.726 7.726s-3.459 7.726-7.727 7.726z"
                                      fill="#365e7d" />
                            </g>
                            <g>
                                <path d="m126.908 140.105c-1.977 0-3.955-.755-5.463-2.263l-7.723-7.722c-3.018-3.017-3.018-7.909-.001-10.927 3.018-3.018 7.91-3.017 10.927-.001l7.723 7.722c3.018 3.017 3.018 7.909.001 10.927-1.509 1.509-3.487 2.264-5.464 2.264z"
                                      fill="#365e7d" />
                            </g>
                        </g>
                        <g>
                            <path d="m211.748 228.123h-37.545c-4.268 0-7.726-3.459-7.726-7.726s3.459-7.726 7.726-7.726h29.819v-65.392c0-4.268 3.459-7.726 7.726-7.726s7.726 3.459 7.726 7.726v73.119c0 4.266-3.458 7.725-7.726 7.725z"
                                  fill="#2b4d66" />
                        </g>
                        <circle cx="378.794" cy="373.323" fill="#dd636e" r="133.206" />
                        <path d="m378.794 240.117c-5.186 0-10.3.307-15.331.884 66.345 7.604 117.875 63.941 117.875 132.322s-51.53 124.718-117.875 132.322c5.032.577 10.145.884 15.331.884 73.568 0 133.206-59.638 133.206-133.206 0-73.567-59.638-133.206-133.206-133.206z"
                              fill="#da4a54" />
                        <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-6.034-6.034-15.819-6.034-21.853 0l-39.246 39.246-39.246-39.246c-6.034-6.036-15.819-6.034-21.853 0-6.035 6.034-6.035 15.819 0 21.853l39.246 39.246-39.246 39.246c-6.035 6.034-6.035 15.819 0 21.853 3.017 3.017 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526l39.246-39.246 39.246 39.246c3.017 3.018 6.972 4.526 10.927 4.526s7.909-1.509 10.927-4.526c6.035-6.034 6.035-15.819 0-21.853z"
                              fill="#f4fbff" />
                        <g>
                            <path d="m400.647 373.323 39.246-39.246c6.035-6.034 6.035-15.819 0-21.853-5.885-5.884-15.327-6.013-21.388-.42.154.142.315.271.465.42 6.035 6.034 6.035 15.819 0 21.853l-32.777 32.777c-3.573 3.573-3.573 9.366 0 12.939l32.777 32.777c6.035 6.034 6.035 15.819 0 21.853-.149.15-.311.279-.465.421 2.954 2.726 6.703 4.106 10.462 4.106 3.955 0 7.909-1.509 10.927-4.526 6.035-6.034 6.035-15.819 0-21.853z"
                                  fill="#daf1f4" />
                        </g>
                    </g>
                </svg>
            </div>
            <span class="timeout-modal__title site-main-text-color">##Endofsearchtime##!</span>

            <p class="timeout-modal__flight">
                به منظور بروزرسانی قیمت ها و قطارها، لطفا جستجوی خود را از ابتدا انجام دهید.
            </p>
            <button onclick="BackToHome('{$objDetail->reSearchAddress}'); return false" type="button"
                    class="loading_on_click btn btn-research site-bg-main-color">
                ##Repeatsearch##
            </button>
            <a class="btn btn_back_home site-main-text-color"
               href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}{$mainPage}">##Returntohome##</a>

        </div>
    </div>
</div>


<div id="steps">
    <div class="steps_items">
        <div class="step done ">

            <span class=""><i class="fa fa-check"></i></span>
            <h3>##Selectiontrain##</h3>
        </div>
        <i class="separator donetoactive"></i>
        <div class="step active">
        <span class="flat_icon_airplane">
        <svg id="Capa_1" enable-background="new 0 0 501.577 501.577" height="25" viewBox="0 0 501.577 501.577"
             width="25"
             xmlns="http://www.w3.org/2000/svg">
    <g>
        <path d="m441 145.789h29v105h-29z" />
        <path d="m60 85.789h-60v387.898l60-209.999z" />
        <path d="m86.314 280.789-60 210h420.263l55-210z" />
        <g>
            <path d="m210.074 85.789c-19.299 0-35 15.701-35 35v20c0 19.299 15.701 35 35 35 11.095 0 21.303-5.118 28.008-14.041 4.574-6.089 6.992-13.337 6.992-20.959v-20c0-7.622-2.418-14.871-6.993-20.962-6.706-8.921-16.914-14.038-28.007-14.038z" />
            <path d="m150.074 250.789h119.926.074v-28.82c0-10.283-4.439-20.067-12.18-26.844l-5.646-4.941c-11.675 9.932-26.667 15.605-42.174 15.605-16.086 0-30.814-5.887-42.176-15.602l-5.647 4.94c-7.737 6.773-12.177 16.557-12.177 26.841z" />
            <path d="m410 145.789v-135h-320v240h29.901.099.074v-28.82c0-18.933 8.172-36.944 22.42-49.417l7.624-6.67c-3.245-7.725-5.044-16.202-5.044-25.093v-20c0-35.841 29.159-65 65-65 20.312 0 39.749 9.727 51.991 26.018l.002.003c8.51 11.329 13.007 24.808 13.007 38.979v20c0 8.747-1.719 17.228-5.031 25.104l7.609 6.658c14.25 12.475 22.422 30.486 22.422 49.418v28.82h110.926v-105zm-30 15h-55v-30h55zm0-60h-85v-30h85z" />
        </g>
    </g>
</svg>

            </span>
            <h3>##PassengersInformation##</h3>

        </div>
        <i class="separator"></i>
        <div class="step ">
             <span class="flat_icon_airplane">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="25" height="25">
    <g id="Contact_form" data-name="Contact form">
        <path d="M20.293,30.707A1,1,0,0,1,20,30v3h3a1,1,0,0,1-.707-.293Z" />
        <path d="M21,29H20v1a1,1,0,0,1,1-1Z" />
        <path d="M23,20.586,24.586,19H21a1,1,0,0,1,.707.293Z" />
        <path d="M21,39H20v1a1,1,0,0,1,1-1Z" />
        <path d="M23,30.586,24.586,29H21a1,1,0,0,1,.707.293Z" />
        <path d="M20.293,40.707A1,1,0,0,1,20,40v3h3a1,1,0,0,1-.707-.293Z" />
        <path d="M23,40.586,24.586,39H21a1,1,0,0,1,.707.293Z" />
        <path d="M21,19H20v1a1,1,0,0,1,1-1Z" />
        <path d="M49.351,35.187,52,37.836V4H14V49H47.183A7.243,7.243,0,0,1,48.331,45.5l-4.638-4.638a4.032,4.032,0,0,1,0-5.661A4.1,4.1,0,0,1,49.351,35.187ZM47,21H31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Zm1,3a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2H47A1,1,0,0,1,48,24ZM18,7a1,1,0,0,1,1-1H47a1,1,0,0,1,1,1v6a1,1,0,0,1-1,1H19a1,1,0,0,1-1-1ZM40,35H31a1,1,0,0,1,0-2h9a1,1,0,0,1,0,2Zm1,5a1,1,0,0,1-1,1H31a1,1,0,0,1,0-2h9A1,1,0,0,1,41,40ZM28.707,37.707l-5,5A1,1,0,0,1,23,43h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V38a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,33h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V28a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414Zm0-10-5,5A1,1,0,0,1,23,23h2a1,1,0,0,1,0,2H19a1,1,0,0,1-1-1V18a1,1,0,0,1,1-1h6a1,1,0,0,1,.931.655l1.362-1.362a1,1,0,0,1,1.414,1.414ZM43,43a1,1,0,0,1,0,2H31a1,1,0,0,1,0-2ZM31,31a1,1,0,0,1,0-2H47a1,1,0,0,1,0,2Z" />
        <path d="M58.01,61,58,59.616a2.985,2.985,0,0,1,.5-1.678l.653-.981A4.979,4.979,0,0,0,60,54.183v-13.7a6.959,6.959,0,0,0-2.05-4.95L54,31.584v8.252l2.427,2.427a1,1,0,0,1-1.414,1.414l-7.07-7.07a2.071,2.071,0,0,0-2.841.006,2.022,2.022,0,0,0,.008,2.833l5.247,5.247a1,1,0,0,1,.053,1.357,5.3,5.3,0,0,0-.1,6.746l.465.575a1,1,0,1,1-1.554,1.258l-.47-.58A7.3,7.3,0,0,1,47.316,51H43.905a8.915,8.915,0,0,0,1.356,6.584l.572.863A1,1,0,0,1,46,59v2Z" />
        <rect x="20" y="8" width="26" height="4" />
        <path d="M20.293,20.707A1,1,0,0,1,20,20v3h3a1,1,0,0,1-.707-.293Z" />
    </g>
</svg>
             </span>
            <h3> ##Approvefinal## </h3>
        </div>
        <i class="separator"></i>
        <div class="step">
            <span class="flat_icon_airplane">
               <svg id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"
                    xmlns="http://www.w3.org/2000/svg">
            <path d="m215.249 166.435h-102.992c-5.613 0-10.704 1.331-14.991 3.705-8.425 4.665-13.736 13.37-13.736 24.015v55.92 36.08c0 7.481 2.879 14.302 7.584 19.418 5.254 5.714 12.786 9.303 21.142 9.303h9.267l-5.763 13.771h-12.752c-5.523 0-10 4.477-10 10s4.477 10 10 10h19.385.108 82.56c.011 0 .022.002.033.002.017 0 .034-.002.051-.002h19.353c5.523 0 10-4.477 10-10s-4.477-10-10-10h-12.688l-5.619-13.771h9.058c15.839 0 28.725-12.884 28.725-28.721v-91.996c0-15.287-12.886-27.724-28.725-27.724zm-107.63 20.889c1.447-.643 3.065-.889 4.641-.889h41.493v53.64h-50.221v-45.916c0-2.954 1.317-5.607 4.087-6.835zm-1.529 104.994c-1.579-1.579-2.557-3.759-2.557-6.163v-26.08h120.437v26.08c0 4.809-3.912 8.72-8.72 8.72h-102.99c-2.407 0-4.59-.978-6.17-2.557zm117.88-52.243h-50.217v-53.64h41.497c4.808 0 8.72 3.463 8.72 7.72zm-33.761 88.572h-52.768l5.763-13.771h41.386z" />
            <path d="m122.78 280.18c3.43 8.375 15.802 7.893 18.701-.608 2.949-8.647-6.792-16.407-14.603-11.791-4.202 2.483-5.971 7.906-4.098 12.399z" />
            <path d="m186.26 280.18c1.61 3.93 5.727 6.477 9.964 6.148 4.127-.32 7.693-3.2 8.859-7.171 2.472-8.42-6.869-15.819-14.517-11.498-4.33 2.446-6.221 7.928-4.306 12.521z" />
            <path d="m414.428 195.81h-43.7c-5.522 0-10 4.477-10 10s4.478 10 10 10h43.7c5.522 0 10-4.477 10-10s-4.478-10-10-10z" />
            <path d="m414.428 246.075h-43.7c-5.522 0-10 4.477-10 10s4.478 10 10 10h43.7c5.522 0 10-4.477 10-10s-4.478-10-10-10z" />
            <path d="m414.428 296.34h-131.38c-5.522 0-10 4.477-10 10s4.478 10 10 10h131.38c5.522 0 10-4.477 10-10s-4.478-10-10-10z" />
            <path d="m283.048 215.81h15.503v40.265c0 5.523 4.478 10 10 10s10-4.477 10-10v-40.265h13.511c5.522 0 10-4.477 10-10s-4.478-10-10-10h-49.014c-5.522 0-10 4.477-10 10s4.477 10 10 10z" />
            <path d="m502 76.985h-492c-5.523 0-10 4.477-10 10v124.37c0 5.523 4.477 10 10 10 15.461 0 28.04 12.579 28.04 28.04 0 15.467-12.579 28.05-28.04 28.05-5.523 0-10 4.477-10 10v137.57c0 5.523 4.477 10 10 10h492c5.522 0 10-4.477 10-10v-137.57c0-5.523-4.478-10-10-10-15.461 0-28.04-12.583-28.04-28.05 0-15.461 12.579-28.04 28.04-28.04 5.522 0 10-4.477 10-10v-124.37c0-5.523-4.478-10-10-10zm-10 338.03h-472v-25.235h472zm-38.04-165.62c0 23.066 16.333 42.389 38.04 47.003v73.382h-472v-73.382c21.707-4.614 38.04-23.937 38.04-47.003 0-23.062-16.333-42.38-38.04-46.993v-60.182h329.441c5.522 0 10-4.477 10-10s-4.478-10-10-10h-329.441v-25.235h472v25.235h-54.581c-5.522 0-10 4.477-10 10s4.478 10 10 10h54.581v60.182c-21.707 4.613-38.04 23.931-38.04 46.993z" />
            <path d="m384.8 136.04c1.613 3.934 5.718 6.476 9.964 6.148 4.173-.323 7.775-3.265 8.896-7.304 2.362-8.512-7.182-15.758-14.768-11.235-4.197 2.503-5.97 7.884-4.092 12.391z" />
        </svg>
             </span>
            <h3> ##TicketReservation## </h3>
        </div>
    </div>

    <div class="counter counter-analog" data-direction="down" data-format="59:59" data-stop="00:00"
         style="direction: ltr">  {$objFunctions->SetTimeLimit()}</div>

</div>

{assign var="check" value=$objDetail->checkExists($InfoTrain[0].code,'trainPassengersDetail','train')}

{if $check eq null}
    {assign var="comapreDate" value=$objFunctions->compareDateTrain($InfoTrain[0]['MoveDate'],$InfoTrain[0]['ExitDate'])}
    {assign var="comapreDateReturn" value=$objFunctions->compareDateTrain($InfoTrain[1]['MoveDate'],$InfoTrain[1]['ExitDate'])}
                {assign var="insert" value=$objDetail->insertCode(['code'=>$InfoTrain[0].code,'service'=>'train','method'=>'trainPassengersDetail'])}
    <div id="lightboxContainer" class="lightboxContainerOpacity"></div>
    <!-- last passenger list -->
    {include file="`$smarty.const.FRONT_CURRENT_CLIENT`passengerPopup.tpl"}
    <!--end  last passenger list -->
    <div class="s-u-content-result">

        <div class="col-lg-12 col-md-12 col-sm-12 col-12 s-u-passenger-wrapper-change">
        <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
         <i class="zmdi zmdi-ticket-star mart10  zmdi-hc-fw"></i>
              ##Isbuying##
        </span>
            <div class="s-u-result-wrapper">
                <ul>
                    <li class="s-u-result-item-header displayiN">
                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-logo-icon"></p>
                        </div>
                        <div class="s-u-result-item-wrapper">

                            <div class="s-u-result-item-div">
                                <p class="s-u-result-item-div-title s-u-result-item-div-time-out"></p>
                            </div>

                            <div class="s-u-result-item-div">
                                <p class="s-u-result-item-div-title s-u-result-item-div-duration-local"></p>
                            </div>

                            <div class="s-u-result-item-div">
                                <p class="s-u-result-item-div-title s-u-result-item-div-flight-number-local"></p>
                            </div>

                            <div class="s-u-result-item-div">
                                <p class="s-u-result-item-div-title s-u-result-item-div-flight-number"></p>
                            </div>

                        </div>


                        <div class="s-u-result-item-div">
                            <p class="s-u-result-item-div-title s-u-result-item-div-flight-price"></p>
                        </div>

                    </li>
                    <!-- result item -->

                    <li class="s-u-result-item s-u-result-item-change wow blit-flight-passenger blit-train-passenger fadeInDown">

                        {assign var="allowCompartmentCapicity" value=""}
                        {assign var="CompartmentCapicity" value=$InfoTrain[0]['CompartmentCapicity']}
                        {if $CompartmentCapicity && $InfoTrain[0]['Owner']}
                            {$allowCompartmentCapicity=$CompartmentCapicity}
                        {else}
                            {$allowCompartmentCapicity=''}
                        {/if}

                        <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                            <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                                <img src="{$objDetail->getCompanyTrainPhoto($InfoTrain[0]['Owner'],$allowCompartmentCapicity)}"
                                     alt="{$objDetail->getCompanyTrainById($InfoTrain[0]['Owner'])}"
                                     title="{$objDetail->getCompanyTrainById($InfoTrain[0]['Owner'])}">
                            </div>

                            <div class="s-u-result-item-div s-u-result-content-item-div-change">
                                <span> شماره قطار : {$InfoTrain[0]['TrainNumber']}</span>
                            </div>

                        </div>
                        <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                            <div class="details-wrapper-change">

                                <div class="s-u-result-raft first-row-change">
                                    <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5 ">

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$InfoTrain[0]['Departure_City']}</span>

                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[0]['ExitTime'])}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$objDetail->DateJalali($InfoTrain[0]['ExitDate'])}
                                            {$objDetail->day},{$objDetail->date_now}</span>

                                            <span>نوع واگن: {$InfoTrain[0]['WagonName']}</span>
                                            <span>{if $InfoTrain[0]['IsCompartment'] eq 1}کوپه ای {$InfoTrain[0]['CompartmentCapicity']} نفره{/if}</span>
                                        </div>

                                        <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                            <span class="iranB">{$InfoTrain[0]['Arrival_City']}</span>
                                            <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[0]['TimeOfArrival'])}</span>

                                        </div>


                                    </div>
                                    <div class="left-Cell-change">
                                        <div class="s-u-bozorg s-u-bozorg-change">
                                            {*                                        {assign var="discountManual" value=objDetail->getDiscount($InfoBus.Price,$InfoBus.OriginalPrice)}*}
                                            <span class="s-u-bozorg price price_dept">
                                                    {if $objSession->IsLogin()}
                                                        {if $InfoTrain[0]['is_specifice'] eq 'yes'}
                                                            {assign var="TypeTrain" value="PrivateTrain"}
                                                        {else}
                                                            {assign var="TypeTrain" value="Train"}
                                                        {/if}
                                                        <i>{assign var="discount" value=$objDetail->CalculateDiscount($TypeTrain,$InfoTrain[0]['Owner'],$InfoTrain[0]['Cost'],$InfoTrain[0]['TrainNumber'],$objFunctions->ConvertToJalali($comapreDate))}</i>
                                                        <i>
                                                         {$objFunctions->numberFormat($InfoTrain[0]['Cost'] - $discount['costOff'])}</i>

{else}

                                                        <i>{$objFunctions->numberFormat($InfoTrain[0]['Cost'])}</i>
                                                    {/if}
												##Rial##
                                                </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </li>

                    {if  isset($InfoTrain[1])}
                        <li class="s-u-result-item s-u-result-item-change wow blit-flight-passenger fadeInDown">
                            <div class="s-u-result-item-div s-u-result-item-div-change col-xs-3 col-sm-2 s-u-result-item-div-width">
                                <div class="s-u-result-item-div-logo s-u-result-item-div-logo-change">
                                    <img src="{$objDetail->getCompanyTrainPhoto($InfoTrain[1]['Owner'])}"
                                         alt="{$objDetail->getCompanyTrainById($InfoTrain[1]['Owner'])}"
                                         title="{$objDetail->getCompanyTrainById($InfoTrain[1]['Owner'])}">
                                </div>

                                <div class="s-u-result-item-div s-u-result-content-item-div-change">
                                    <span> شماره قطار : {$InfoTrain[1]['TrainNumber']}</span>
                                </div>

                            </div>
                            <div class="s-u-result-item-wrapper s-u-result-item-wrapper-change col-xs-9 col-sm-10">

                                <div class="details-wrapper-change">

                                    <div class="s-u-result-raft first-row-change">
                                        <div class="s-u-result-item-div  s-u-result-items-div-change right-Cell-change fltr padb5  ">

                                            <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                                <span class="iranB">{$InfoTrain[1]['Departure_City']}</span>

                                                <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[1]['ExitTime'])}</span>
                                            </div>

                                            <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                        <span class="s-u-result-item-date-format s-u-result-item-date-format-change iranB">{$objDetail->DateJalali($InfoTrain[1]['ExitDate'])}
                                            {$objDetail->day},{$objDetail->date_now}</span>

                                                <span>نوع واگن: {$InfoTrain[1]['WagonName']}</span>
                                                <span>{if $InfoTrain[1]['IsCompartment'] eq 1}کوپه ای {$InfoTrain[1]['CompartmentCapicity']} نفره{/if}</span>
                                            </div>

                                            <div class="s-u-result-item-div s-u-result-items-div-change displayib padl15 fltr">
                                                <span class="iranB">{$InfoTrain[1]['Arrival_City']}</span>
                                                <span class="s-u-bozorg s-u-bozorg-change  txt14 yekanB"> {$objFunctions->format_hour($InfoTrain[1]['TimeOfArrival'])}</span>

                                            </div>


                                        </div>
                                        <div class="left-Cell-change">
                                            <div class="s-u-bozorg s-u-bozorg-change">
                                                {*                                        {assign var="discountManual" value=objDetail->getDiscount($InfoBus.Price,$InfoBus.OriginalPrice)}*}
                                                <span class="s-u-bozorg price price_return">
                                                        {*    {if $objSession->IsLogin()}
                                                                {if $InfoTrain[1]['is_specifice'] eq 'yes'}
                                                                    {assign var="TypeTrain" value="PrivateTrain"}
                                                                {else}
                                                                    {assign var="TypeTrain" value="Train"}
                                                                {/if}
                                                                <i>{assign var="discount" value=$objDetail->CalculateDiscount($TypeTrain,$InfoTrain[1]['Owner'],$InfoTrain[1]['Cost'],$InfoTrain[1]['TrainNumber'],$objFunctions->ConvertToJalali($comapreDate))}</i>
                                                                <i>{$objFunctions->numberFormat($InfoTrain[1]['Cost'] - $discount['costOff'])}</i>
                                                            {else}
                                                                <i>{$objFunctions->numberFormat($InfoTrain[1]['Cost'])}</i>
                                                            {/if}*}
                                                                                                           <i>{$objFunctions->numberFormat($InfoTrain[1]['Cost'])}</i>  ##Rial##

                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {if {$lockseatreturn['SellStatus']} eq '0' && {$smarty.post.IsCoupe} eq '1'}
                                    <div class="alertCupe_train" id="alertCupeReturn">

                                        <span><i class="flat_alert"></i> هم اکنون در این قطار امکان رزرو کوپه دربست فراهم نمی باشد ! </span>
                                        <button onclick="CancleCoupeReturn()"> کوپه دربست نمی خواهم</button>
                                        <button class='loading_on_click '
                                                onclick="BackToHome('{$objDetail->reSearchAddress}'; return false)">
                                            جستجوی مجدد
                                        </button>
                                    </div>
                                {/if}

                            </div>
                        </li>
                    {/if}

                </ul>
            </div>



        </div>

        <div class="clear"></div>

        <form method="post" id="formPassengerDetailTrain" action="{$smarty.const.ROOT_ADDRESS}/trainFactor">
            {for $i=1 to $InfoTrain[0]['Adult']}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                         <span class="s-u-last-p-bozorgsal s-u-last-p-bozorgsal-change site-main-text-color">
                             ##Adult##

                            {if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                                <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                                      onclick="setHidenFildnumberRow('A{$i}')">
                                    <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> ##Passengerbook##
                                        </span>
                            {/if}
                         </span>

                    <div class="panel-default-change ">
                        <div class="panel-heading-change">

                            <span class="hidden-xs-down">##Nation##:</span>

                        <span class="kindOfPasenger">
						    <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"
                                       value="0" class="nationalityChange" checked="checked">
                                <div class="checkbox ">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                   </svg>
                                </div>
							</label>
                        </span>
                        <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Noiranian##</span>
                                <input type="radio" name="passengerNationalityA{$i}" id="passengerNationalityA{$i}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox ">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                   </svg>
                                </div>
							</label>
                        </span>
                            <span class="member-price  members-price-adult">

                                        {if isset($InfoTrain[1]) neq ''}
                                            {assign var="CostAdult" value= ($InfoTrain[0]['Cost'])+($InfoTrain[1]['Cost'])}
                                        {else}
                                            {assign var="CostAdult" value= $InfoTrain[0]['Cost']}
                                        {/if}
                                        <i>{$objFunctions->numberFormat($CostAdult)} </i> ریال
                                </span>


                        </div>

                        <div class="clear"></div>

                        <div class="panel-body-change">
                            <div class="s-u-passenger-item  s-u-passenger-item-change ">
                                <select id="genderA{$i}" name="genderA{$i}" class="select2">
                                    <option value=""  selected="selected">##Sex##</option>
                                    <option value="Male">##Sir##</option>
                                    <option value="Female">##Lady##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="nameEnA{$i}" type="text" placeholder="##Nameenglish##" name="nameEnA{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEnA{$i}')" class="">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="familyEnA{$i}" type="text" placeholder="##Familyenglish##"
                                       name="familyEnA{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEnA{$i}')" class="">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnA{$i}" type="text"
                                       placeholder="##miladihappybirthday##(##Noiranian##)"
                                       name="birthdayEnA{$i}" class="gregorianAdultBirthdayCalendar"
                                       readonly="readonly">
                            </div>
{*                            onkeypress=" return persianLetters(event, 'nameFaA{$i}')"*}
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="nameFaA{$i}" type="text" placeholder="##Name##" name="nameFaA{$i}"

                                       >
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="familyFaA{$i}" type="text" placeholder="##Family##"
                                       name="familyFaA{$i}"

                                       >
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthdayA{$i}" type="text" placeholder="##shamsihappybirthday##"
                                       name="birthdayA{$i}"
                                       class="shamsiAdultBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCodeA{$i}" type="tel" placeholder="##Nationalnumber##"
                                       name="NationalCodeA{$i}"
                                       maxlength="10" class="UniqNationalCode"
                                       onkeyup="return checkNumber(event, 'NationalCodeA{$i}')">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                                <select name="passportCountryA{$i}" id="passportCountryA{$i}"
                                        class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportNumberA{$i}" type="text" placeholder="##Numpassport##"
                                       name="passportNumberA{$i}" class="UniqPassportNumber"
                                       onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberA{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportExpireA{$i}" class="gregorianFromTodayCalendar" type="text"
                                       placeholder="##Passportexpirydate##" name="passportExpireA{$i}">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change unrequrid services-option-dept-js"
                                 data-services=''>
                                <div class="loader-select-service">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                </div>

                                <select class="select2 service-dept-js" id="serviceA{$i}" name="serviceA{$i}"
                                        disabled="disabled">
                                    <option value='' selected="selected">سرویس رفت</option>
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change unrequrid free-option-dept-js"
                                 data-services=''>
                                <div class="loader-select-free-option">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                </div>

                                <select class="select2 free-dept-js" id="freeA{$i}" name="freeA{$i}"
                                        disabled="disabled">
                                    <option value='' selected="selected">سرویس رایگان</option>
                                </select>
                            </div>
                            {if isset($InfoTrain[1])}
                            <div class="s-u-passenger-item  s-u-passenger-item-change unrequrid services-option-return-js">
                                <div class="loader-select-service">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                </div>
                                <select id="serviceReturnA{$i}" name="serviceReturnA{$i}"
                                        class="select2 service-return-js">
                                    <option value='' selected="selected">سرویس برگشت</option>
                                </select>
                            </div>
                            <div class="s-u-passenger-item  s-u-passenger-item-change unrequrid free-option-return-js">
                                <div class="loader-select-free-option">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                </div>
                                <select id="freeReturnA{$i}" name="freeReturnA{$i}"
                                        class="select2 free-return-js">
                                    <option value='' selected="selected">سرویس رایگان برگشت</option>
                                </select>
                            </div>
                            {/if}
                            <div class="alert_msg" id="messageA{$i}"></div>


                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/for}

            {for $i=1 to $InfoTrain[0]['Child']}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change  first">

                <span class="s-u-last-p-koodak s-u-last-p-koodak-change site-main-text-color">
                 ##Child##
					{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                        <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                              onclick="setHidenFildnumberRow('C{$i}')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerbook##
                        </span>
                    {/if}
                </span>
                    <div class="panel-default-change site-border-main-color">
                        <div class="panel-heading-change">

                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
						    <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityC{$i}" id="passengerNationalityC{$i}"
                                       value="0" class="nationalityChange" checked="checked">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                   </svg>
                                </div>
							</label>
                        </span>
                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Noiranian##</span>
                                <input type="radio" name="passengerNationalityC{$i}" id="passengerNationalityC{$i}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                   </svg>
                                </div>
							</label>
                        </span>
                            <span class="member-price members-price-child">
                                <div class="loader-select-service-currency">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                    <i class="type-currency-train">ریال</i>
                                </div>
                            </span>


                        </div>

                        <div class="clear"></div>

                        <div class="panel-body-change">
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <select id="genderC{$i}" name="genderC{$i}" class="select2">
                                    <option value=""  selected="selected">##Sex##</option>
                                    <option value="Male">##Boy##</option>
                                    <option value="Female">##Girl##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="nameEnC{$i}" type="text" placeholder="##Nameenglish##" name="nameEnC{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEnC{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="familyEnC{$i}" type="text" placeholder="##Familyenglish##"
                                       name="familyEnC{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEnC{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnC{$i}" type="text" placeholder="##miladihappybirthday##"
                                       name="birthdayEnC{$i}" class="gregorianChildBirthdayCalendar"
                                       readonly="readonly">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="nameFaC{$i}" type="text" placeholder="##Name##" name="nameFaC{$i}"

                                       >
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="familyFaC{$i}" type="text" placeholder="##Family##"
                                       name="familyFaC{$i}"

                                       >
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthdayC{$i}" type="text" placeholder="##shamsihappybirthday##"
                                       name="birthdayC{$i}"
                                       class="shamsiChildBirthdayCalendar" readonly="readonly">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCodeC{$i}" type="tel" placeholder="##Nationalnumber##"
                                       name="NationalCodeC{$i}"
                                       maxlength="10" class="UniqNationalCode"
                                       onkeyup="return checkNumber(event, 'NationalCodeC{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                                <select name="passportCountryC{$i}" id="passportCountryC{$i}"
                                        class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportNumberC{$i}" type="text" placeholder="##Numpassport##"
                                       name="passportNumberC{$i}" class="UniqPassportNumber"
                                       onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberC{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportExpireC{$i}" class="gregorianFromTodayCalendar" type="text"
                                       placeholder="##Passportexpirydate##" name="passportExpireC{$i}">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change unrequrid services-option-dept-js"
                                 data-services=''>
                                <div class="loader-select-service">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                </div>
                                <select class="select2 service-dept-js" id="serviceC{$i}" name="serviceC{$i}"
                                        disabled="disabled">
                                    <option value='' selected="selected">سرویس رفت</option>
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change unrequrid free-option-dept-js"
                                 data-services=''>
                                <div class="loader-select-free-option">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                </div>

                                <select class="select2 free-dept-js" id="freeC{$i}" name="freeC{$i}"
                                        disabled="disabled">
                                    <option value='' selected="selected">سرویس رایگان</option>
                                </select>
                            </div>
                                {if isset($InfoTrain[1])}
                                    <div class="s-u-passenger-item  s-u-passenger-item-change unrequrid services-option-return-js">
                                        <div class="loader-select-service">
                                            <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                        </div>
                                        <select id="serviceReturnC{$i}" name="serviceReturnC{$i}"
                                                class="select2 service-return-js">
                                            <option value='' selected="selected">سرویس برگشت</option>
                                        </select>
                                    </div>
                                    <div class="s-u-passenger-item  s-u-passenger-item-change unrequrid free-option-return-js">
                                        <div class="loader-select-free-option">
                                            <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                        </div>
                                        <select id="freeReturnC{$i}" name="freeReturnC{$i}"
                                                class="select2 free-return-js">
                                            <option value='' selected="selected">سرویس رایگان برگشت</option>
                                        </select>
                                    </div>
                            {/if}

                            <div id="messageC{$i}" class="alert_msg"></div>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/for}
            {for $i=1 to $InfoTrain[0]['Infant']}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change first">
                <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color">
               ##Baby##
					{if $objSession->IsLogin() and ($smarty.session.typeUser eq 'counter')}
                        <span class="s-u-last-passenger-btn s-u-last-passenger-btn-change"
                              onclick="setHidenFildnumberRow('I{$i}')">
                            <i class="zmdi zmdi-pin-account zmdi-hc-fw"></i>##Passengerlist##
                        </span>
                    {/if}
                </span>
                    <div class="panel-default-change  site-border-main-color">
                        <div class="panel-heading-change">

                            <span class="hidden-xs-down">##Nation##:</span>

                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Iranian##</span>
                                <input type="radio" name="passengerNationalityI{$i}" id="passengerNationalityI{$i}"
                                       value="0" class="nationalityChange" checked="checked">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                   </svg>
                                </div>
							</label>
                        </span>
                            <span class="kindOfPasenger">
                            <label class="control--checkbox">
                                <span>##Noiranian##</span>
                                <input type="radio" name="passengerNationalityI{$i}" id="passengerNationalityI{$i}"
                                       value="1" class="nationalityChange">
                                <div class="checkbox">
                                    <div class="filler"></div>
                                    <svg fill="#000000" viewBox="0 0 30 30">
                                    <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                   </svg>
                                </div>
							</label>
                        </span>
                            <span class="member-price members-price-infant" >
                                <div class="loader-select-service-currency">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit">
                                    </span>
                                    <i class="type-currency-train">ریال</i>
                                </div>
                            </span>


                        </div>

                        <div class="clear"></div>

                        <div class="panel-body-change ">
                            <div class="s-u-passenger-item s-u-passenger-item-change">
                                <select id="genderI{$i}" name="genderI{$i}" class="select2">
                                    <option value=""  selected="selected">##Sex##</option>
                                    <option value="Male">##Boy##</option>
                                    <option value="Female">##Girl##</option>
                                </select>
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="nameEnI{$i}" type="text" placeholder="##Nameenglish##" name="nameEnI{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'nameEnI{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="familyEnI{$i}" type="text" placeholder="##Familyenglish##"
                                       name="familyEnI{$i}"
                                       onkeypress="return isAlfabetKeyFields(event, 'familyEnI{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="birthdayEnI{$i}" type="text" placeholder="##miladihappybirthday##"
                                       name="birthdayEnI{$i}" class="gregorianInfantBirthdayCalendar"
                                       readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="nameFaI{$i}" type="text" placeholder="##Name##" name="nameFaI{$i}"

                                       >
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="familyFaI{$i}" type="text" placeholder="##Family##"
                                       name="familyFaI{$i}"

                                       >
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="birthdayI{$i}" type="text" placeholder="##shamsihappybirthday##"
                                       name="birthdayI{$i}"
                                       class="shamsiInfantBirthdayCalendar" readonly="readonly">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change justIranian">
                                <input id="NationalCodeI{$i}" type="tel" placeholder="##Nationalnumber##"
                                       name="NationalCodeI{$i}"
                                       maxlength="10" class="UniqNationalCode"
                                       onkeyup="return checkNumber(event, 'NationalCodeI{$i}')">
                            </div>

                            <div class="s-u-passenger-item s-u-passenger-item-change select-meliat noneIranian">
                                <select name="passportCountryI{$i}" id="passportCountryI{$i}"
                                        class="select2">
                                    <option value="">##Countryissuingpassport##</option>
                                    {foreach $objFunctions->CountryCodes() as $Country}
                                        <option value="{$Country['code']}">{$Country['titleFa']}</option>
                                    {/foreach}
                                </select>
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportNumberI{$i}" type="text" placeholder="##Numpassport##"
                                       name="passportNumberI{$i}" class="UniqPassportNumber"
                                       onkeypress="return isAlfabetNumberKeyFields(event, 'passportNumberI{$i}')">
                            </div>
                            <div class="s-u-passenger-item s-u-passenger-item-change noneIranian">
                                <input id="passportExpireI{$i}" class="gregorianFromTodayCalendar" type="text"
                                       placeholder="##Passportexpirydate##" name="passportExpireI{$i}">
                            </div>
                            <div id="messageI{$i}" class="alert_msg"></div>


                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/for}

            {if $smarty.post.IsCoupe eq 1}
                <div class=" s-u-passenger-wrapper-change first">
                  <span class="s-u-last-p-nozad s-u-last-p-nozad-change site-main-text-color">
                مابه التفاوت
                </span>
                    <div style="border: none" class="panel-default-change site-border-main-color">
                        <div class="panel-heading-change panel-heading-change-n">
                            {if isset($InfoTrain[1])}
                                <span class="hidden-xs-down">مابه التفاوت کوپه دربست رفت و برگشت</span>
                            {else}
                                <span class="hidden-xs-down">مابه التفاوت کوپه دربست رفت </span>
                            {/if}
                            <div class="panel_price">
                                <div class="loader-select-service-coupe">
                                    <span href="" onclick="return false" class="f-loader-check-train" id="loader_check_submit"></span>
                                    <i class="type-currency-train">ریال</i>
                                </div>
                                <span class="member-price totalpricecoupe members-price-coupe">

                                </span>


                            </div>
                        </div>

                        <div class="clear"></div>
                        <div class="panel-body-change ">
                            <div class="col-md-6 col-coope">
                                <div>
                                    <h6>کوپه دربست(مسیر رفت)</h6>
                                </div>

                                <label class="control--checkbox">
                                    <span>می خواهم کوپه خود را دربست خریداری نمایم.</span>
                                    <input type="checkbox" name="CheckCoupe" id="CheckCoupe" value="1"
                                           onclick="selectedcoupe()" class="nationalityChange" checked="checked">
                                    <div class="checkbox">
                                        <div class="filler"></div>
                                        <svg fill="#000000" viewBox="0 0 30 30">
                                            <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                        </svg>
                                    </div>
                                </label>


                            </div>
                            {if isset($InfoTrain[1])}
                                <div class="col-md-6 col-coope">
                                    <div>
                                        <h6>کوپه دربست(مسیر برگشت)</h6>
                                    </div>

                                    <label class="control--checkbox">
                                        <span>می خواهم کوپه خود را دربست خریداری نمایم.</span>
                                        <input type="checkbox" name="CheckCoupeReturn" id="CheckCoupeReturn"
                                               value="1"
                                               checked onclick="selectedcoupereturn()">
                                        <div class="checkbox">
                                            <div class="filler"></div>
                                            <svg fill="#000000" viewBox="0 0 30 30">
                                                <path d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z" />
                                            </svg>
                                        </div>
                                    </label>

                                </div>
                            {/if}
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/if}

            {if $objSession->IsLogin()}
                {assign var="info_member" value=$objDetail->getMember()}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color ">

                    ##InformationSaler##
                </span>
                    <input type="hidden" name="UsageNotLogin" value="no" id="UsageNotLogin">
                    <div class="clear"></div>
                    <div class="panel-default-change-Buyer ">


                        <div class="panel-default-change ">

                            <div class="clear"></div>

                            <div class="panel-body-change">


                                <div class="s-u-passenger-items widthInputInformationBuyer s-u-passenger-item-change">
                                    <input id="Email" type="email" placeholder="##Email##" name="Email"
                                           class="dir-ltr"
                                           value="{$info_member['email']}">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change widthInputInformationBuyer">
                                    <input id="Mobile_buyer" type="tel" placeholder="##SalerPhone##"
                                           name="Mobile_buyer" maxlength="11" required="required"
                                           class="UniqNationalCode"
                                           onkeyup="return checkNumber(event, 'Mobile_buyer')"
                                           value="{$info_member['mobile']}">
                                </div>

                            </div>
                        </div>
                        <div class="clear"></div>

                        <div id="messageInfo4" class="messageInfo3"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            {else}
                <div class="s-u-passenger-wrapper s-u-passenger-wrapper-change-Buyer  first">
                <span class="s-u-last-p-pasenger s-u-last-p-pasenger-change site-main-text-color ">

                    ##Travelerprofile##
                </span>
                    <input type="hidden" name="UsageNotLogin" value="yes" id="UsageNotLogin">
                    <div class="clear"></div>
                    <div class="panel-default-change-Buyer">


                        <div class="panel-default-change">

                            <div class="clear"></div>

                            <div class="panel-body-change">


                                <div class="s-u-passenger-items s-u-passenger-item-change">
                                    <input id="Email" type="email" placeholder="##Email##" name="Email"
                                           class="dir-ltr">
                                </div>
                                <div class="s-u-passenger-items s-u-passenger-item-change">
                                    <input id="Telephone" type="tel" placeholder="##Phone##" name="Telephone"
                                           class=""
                                           onkeypress="return checkNumber(event, 'Telephone')">
                                </div>
                                <div class="s-u-passenger-item s-u-passenger-item-change">
                                    <input id="Mobile_buyer" type="tel" placeholder="##SalerPhone##"
                                           name="Mobile_buyer" maxlength="11"
                                           class="UniqNationalCode"
                                           onkeyup="return checkNumber(event, 'Mobile_buyer')">
                                </div>

                            </div>
                        </div>
                        <div class="clear"></div>

                        <div id="messageInfo" class="messageInfo alert_msg"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            {/if}

            <input type="hidden" name="is_specific_dept" value="{if $InfoTrain[0]['is_specifice'] eq 'yes'} yes {else} no {/if}">
            <input type="hidden" id="time_remmaining" value="" name="time_remmaining">
            <input type="hidden" id="ServiceCode" value="{$InfoTrain[0]['ServiceCode']}" name="ServiceCode">
            <input type="hidden" id="is_coupe" value="{$smarty.post.IsCoupe}" name="is_coupe">
            <input type="hidden" id="priceAdultA" value="" name="priceAdultA">
            <input type="hidden" id="priceNonIranian" value="" name="nonIranian">
            <input type="hidden" id="priceChildC" value="" name="priceChildC">
            <input type="hidden" id="priceInfantI" value="" name="priceInfantI">
            {if isset($InfoTrain[1])}
            <input type="hidden" name="is_specific_return" value="{if $InfoTrain[1]['is_specifice'] eq 'yes'} yes {else} no {/if}">
            <input type="hidden" name="priceAdultReturnA" id="priceAdultReturnA" value="">
            <input type="hidden" name="priceNoneIranianReturn" id="priceNoneIranianReturn" value="">
            <input type="hidden" name="priceChildReturnC" id="priceChildReturnC" value="">
            <input type="hidden" name="priceInfantReturnI" id="priceInfantReturnI" value="">

                <input type="hidden" id="SellSerial_return" name="SellSerial_return" value="{$smarty.post.SellSerial_return}">
                <input type="hidden" id="SellStatus_return" name="SellStatus_return" value="{$smarty.post.SellStatus_return}">
                <input type="hidden" id="SellStatus_return" name="SellMasterId_return" value="{$smarty.post.SellMasterId_return}">
                <input type="hidden" id="WagonNumbers_return" name="WagonNumbers_return" value="{$smarty.post.WagonNumbers_return}">
                <input type="hidden" id="WagonNumbers_return" name="CompartmentNumbers_return" value="{$smarty.post.CompartmentNumbers_return}">
                <input type="hidden" id="SaleId_return" name="SaleId_return" value="{$smarty.post.SaleId_return}">
                <input type="hidden" id="request_number_return" name="request_number_return" value="{$smarty.post.request_number_return}">
            {/if}
            {if $smarty.post.IsCoupe eq 1}
                <input type="hidden" name="TariffPriceCoupe" id="TariffPriceCoupe" value="">
                <input type="hidden" name="TariffPriceCoupeReturn" id="TariffPriceCoupeReturn" value="">
                <input type="hidden" name="PriceExtraPersonCoupe" id="PriceExtraPersonCoupe" value="">
                <input type="hidden" name="PriceExtraPersonCoupeReturn" id="PriceExtraPersonCoupeReturn" value="">
                <input type="hidden" name="total_price" id="total_price" value="">
            {/if}
            <input type="hidden" id="success_load" value="false">
            <input type="hidden" id="SellSerial_dept" name="SellSerial_dept" value="{$smarty.post.SellSerial_dept}">
            <input type="hidden" id="SellStatus_dept" name="SellStatus_dept" value="{$smarty.post.SellStatus_dept}">
            <input type="hidden" id="SellStatus_dept" name="SellMasterId_dept" value="{$smarty.post.SellMasterId_dept}">
            <input type="hidden" id="WagonNumbers_dept" name="WagonNumbers_dept" value="{$smarty.post.WagonNumbers_dept}">
            <input type="hidden" id="WagonNumbers_dept" name="CompartmentNumbers_dept" value="{$smarty.post.CompartmentNumbers_dept}">
            <input type="hidden" id="SaleId_dept" name="SaleId_dept" value="{$smarty.post.SaleId_dept}">
            <input type="hidden" id="request_number_dept" name="request_number_dept" value="{$smarty.post.request_number_dept}">
        </form>
        <div class="clear"></div>
{*        <div class='recaptcha-parent'>*}
{*        {if $smarty.const.CLIENT_ID eq 239}*}
{*            {assign var="site_key" value='6LdB6nUqAAAAAEIfHIEgg2aD9JgBV75RMD_8Q-rR'}*}
{*        {elseif $smarty.const.CLIENT_ID eq 127}*}
{*            {assign var="site_key" value='6Lej9q0qAAAAAP45DEovfydlRg31vAshTTyQHtNi'}*}
{*        {/if}*}
{*        <div class="g-recaptcha" data-sitekey="{$site_key}"*}
{*             data-callback="onReCaptchaSuccess"></div>*}
{*        </div>*}
        <div class="btns_factors_n">
            <div class="btn_research__">
                <button type="button" class="cancel-passenger"
                        onclick="BackToHome('{$objDetail->reSearchAddress}'); return false">##Repeatsearch##
                    <i class="loading_on_click  fa fa-refresh"></i>
                </button>

            </div>

            <div class="passengersDetailLocal_next">
                <a href="" onclick="return false" class="f-loader-check loaderpassengers" id="loader_check"
                   style="display:none"></a>
                <input type="button"
                       onclick="checkfildtrain({$smarty.now},{$InfoTrain[0]['Adult']},{$InfoTrain[0]['Child']},{$InfoTrain[0]['Infant']})"
                       value="##NextStepInvoice##"
                       class="s-u-submit-passenger s-u-select-flight-change site-bg-main-color s-u-submit-passenger-Buyer"
                       id="send_data">

            </div>


        </div>
        </form>

    </div>
{else}
    <div class="userProfileInfo-messge mb-3">
        <div class="messge-login BoxErrorSearch">
            <div style="float: right;">
                <i class="fa fa-exclamation-triangle IconBoxErrorSearch"></i>
            </div>
            <div class="TextBoxErrorSearch px-4">
                <h6>اخطار بارگزاری صفحه</h6>
                <p>خطا در بارگزاری اطلاعات. لطفا مجدد از مرحله جستجو اقدام نمایید</p>
            </div>
        </div>
    </div>
{/if}


{literal}

<!-- counter menu -->
    <script src="assets/js/classie.js"></script>
    <script src="assets/js/sidebarEffects.js"></script>
<!-- jQuery Site Scipts -->
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jdate.min.js" type="text/javascript"></script>
    <script src="assets/js/jdate.js" type="text/javascript"></script>
    <script src="assets/js/jquery.counter.js" type="text/javascript"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">


  $(document).ready(function() {

    $('.counter').counter({})
    $('.counter').on('counterStop', function() {
      $('.lazy-loader-parent').css('display', 'flex')
    })
    var table = $('#passengers').DataTable()

    $('#passengers tbody').on('click', 'tr', function() {
      if ($(this).hasClass('selected')) {
        $(this).removeClass('selected')
      } else {
        table.$('tr.selected').removeClass('selected')
        $(this).addClass('selected')
      }
    })

    $('#button').click(function() {
      table.row('.selected').remove().draw(false)
    })


    $('ul.tabs li').on('click', function() {

      $(this).siblings().removeClass('current')
      $(this).parent('ul.tabs').siblings('.tab-content').removeClass('current')


      var tab_id = $(this).attr('data-tab')


      $(this).addClass('current')
      $(this).parent('ul.tabs').siblings('#' + tab_id).addClass('current')

    })

    $('body').delegate('.closeBtn', 'click', function() {

      $('.price-Box').removeClass('displayBlock')
      $('#lightboxContainer').removeClass('displayBlock')
    })

    $('div#lightboxContainer').click(function() {

      $('.price-Box').removeClass('displayBlock')
      $('#lightboxContainer').removeClass('displayBlock')
    })

    $('div#lightboxContainer').click(function() {

      $('.Cancellation-Box').removeClass('displayBlock')
      $('#lightboxContainer').removeClass('displayBlock')
    })

    $('div#lightboxContainer').click(function() {
      $('.last-p-popup').css('display', 'none')
    })

    $('.DetailSelectTicket').on('click', function(e) {
      $(this).parent().siblings('.DetailSelectTicketContect').slideToggle('fast')
    })

  })

  function pad(val) {
    var valString = val + ''
    if (valString.length < 2) {
      return '0' + valString
    } else {
      return valString
    }
  }

  function priceAdult(response) {
    if(response.data.adult[0].Prices !=undefined) {
      let member_price = response.data.adult[0].Prices.BasePrice.Amount
      $('#priceAdultA').val(member_price)
      if (response.data.adult[1] != undefined) {
        member_price = response.data.adult[1].Prices.BasePrice.Amount
        $('#priceAdultReturnA').val(member_price)
      }
    }


   /* if (response.data.discount[0] != undefined) {
      member_price -= response.data.discount[0]
    }*/

  /*  if (response.data.discount[1] != undefined) {
      member_price -= response.data.discount[1]
    }*/

    // $('.members-price-adult').html(`<i>${number_format(member_price)}</i> ریال`)
  }

  function priceChild(response) {

    let member_price = response.data.child[0].Prices.BasePrice.Amount
    let member_price_total = parseInt(member_price);
    $('#priceChildC').val(member_price);
    if (response.data.child[1] != undefined) {
      member_price_return = response.data.child[1].Prices.BasePrice.Amount
      $('#priceChildReturnC').val(member_price_return)
      member_price_total = member_price_total + parseInt(member_price_return);

    }

    $('#success_load').val(true)
  /*  if (response.data.discount[0] != undefined) {
      member_price -= response.data.discount[0]
    }
    if (response.data.discount[1] != undefined) {
      member_price -= response.data.discount[1]
    }*/

    $('.members-price-child').html(`<i>${number_format(member_price_total)}</i> ریال`)
  }

  function priceNonIranian(response) {

    let member_price = response.data.nonIranian[0].Prices.BasePrice.Amount
    $('#priceNonIranian').val(member_price);
    if (response.data.nonIranian[1] != undefined) {
      member_price_return = response.data.nonIranian[1].Prices.BasePrice.Amount
      $('#priceNoneIranianReturn').val(member_price_return)
    }
  }

  function priceInfant(response) {
    let member_price = response.data.infant[0].Prices.BasePrice.Amount
    let member_price_total = parseInt(member_price);
    $('#priceInfantI').val(member_price);
    if (response.data.child[1] != undefined) {
      member_price_return = response.data.infant[1].Prices.BasePrice.Amount
      $('#priceInfantIReturnI').val(member_price_return)
      member_price_total = member_price_total + parseInt(member_price_return);

    }

    $('#success_load').val(true)
    /*  if (response.data.discount[0] != undefined) {
        member_price -= response.data.discount[0]
      }
      if (response.data.discount[1] != undefined) {
        member_price -= response.data.discount[1]
      }*/

    $('.members-price-infant').html(`<i>${number_format(member_price_total)}</i> ریال`)
  }

  function getViewPriceTicket() {
    $('#success_load').val(false)
    // for (i = 1; i <= adult_number; i++) {
    //   let adult_nationality = $('input[name=passengerNationalityA' + i + ']:checked').val()
    //   nationality.adult.push(adult_nationality)
    // }
    // for (i = 1; i <= child_number; i++) {
    //   let child_nationality = $('input[name=passengerNationalityC' + i + ']:checked').val()
    //   nationality.child.push(child_nationality)
    // }
    // for (i = 1; i <= infant_number; i++) {
    //   let infant_nationality = $('input[name=passengerNationalityI' + i + ']:checked').val()
    //   nationality.infant.push(infant_nationality)
    // }


    // for (i = 1; i <= adult_number; i++) {
    //   let adult_nationality = $('input[name=passengerNationalityA' + i + ']:checked').val()
    //   nationality.push(adult_nationality)
    // }
    // for (i = 1; i <= child_number; i++) {
    //   let child_nationality = $('input[name=passengerNationalityC' + i + ']:checked').val()
    //   nationality.push(child_nationality)
    // }
    // for (i = 1; i <= infant_number; i++) {
    //   let infant_nationality = $('input[name=passengerNationalityI' + i + ']:checked').val()
    //   nationality.push(infant_nationality)
    // }

    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'getViewPriceTicket',
        className: 'trainPassengersDetail',
        service_code: "{/literal}{$InfoTrain[0]['ServiceCode']}{literal}",
        is_coupe: "{/literal}{$smarty.post.IsCoupe}{literal}"
      }),
      success: function(response) {
        console.log(response)

        priceAdult(response)
        if (response.data.nonIranian !== undefined) {
          priceNonIranian(response)
        }
        if (response.data.child !== undefined) {
          priceChild(response)
        }

        if (response.data.infant !== undefined) {
          priceInfant(response)
        }

        if (response.data.coupe != undefined) {
          let price_dept_coupe = response.data.coupe.price_base_coupe[0];
          let price_total_coupe =  response.data.coupe.total[0] ;
          $('#TariffPriceCoupe').val(price_dept_coupe)
          $('#PriceExtraPersonCoupe').val(price_total_coupe)
          $('#total_price').val(price_total_coupe)
          if(response.data.coupe.price_base_coupe[1] != undefined){
            let price_return_coupe = response.data.coupe.price_base_coupe[1];
            let price_return_coupe_total = response.data.coupe.total[1];

            console.table([price_return_coupe,price_return_coupe_total])
            $('#TariffPriceCoupeReturn').val(price_return_coupe)
            $('#PriceExtraPersonCoupeReturn').val(price_return_coupe_total)
            price_total_coupe += parseInt(price_return_coupe_total);
            $('#total_price').val(price_total_coupe)
          }
          $('.members-price-coupe').html(`<i>${number_format(parseInt(price_total_coupe))}</i> ریال`)
          $('.loader-select-service-coupe').hide()
        }

        $('#success_load').val(true)
      },
      error: function(error) {
        $('#success_load').val(false)
      },
    })
  }

  function getServiceTrain() {
    $('.loader-select-service').show()
    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'getServiceTrain',
        className: 'trainPassengersDetail',
        service_code: "{/literal}{$InfoTrain[0]['ServiceCode']}{literal}",
        is_coupe: "{/literal}{$smarty.post.IsCoupe}{literal}",
      }),
      success: function(response) {
        $('.loader-select-service').show()
        console.log('sss In')
        let services = response.data
        let service_option_parent = $('.service-dept-js')
        let service_option_parent_return = $('.service-return-js')
        if (services[0] !== undefined) {
          let service_dept = services[0]


          if(service_dept.length > 0){
            Object.keys(services[0]).forEach(key => {
              let price_option = (parseInt(service_dept[key]['ShowMoney']) == 0) ? 'رایگان' : service_dept[key]['ShowMoney']
              let option_text = `${service_dept[key]['ServiceTypeName']}- ${price_option}`
              let option_value = `${service_dept[key]['ServiceTypeName']} @@ ${service_dept[key]['ShowMoney']} @@ ${service_dept[key]['ServiceTypeCode']}`
              let new_option = new Option(option_text, option_value, true, true)
              service_option_parent.append(new_option).trigger('open').removeAttr('disabled')
              service_option_parent.val('')
            })
            $('.loader-select-service').hide()

          }else{
            let option_text ='رفت-بدون سرویس';
            let option_value = ''
            let new_option = new Option(option_text, option_value, true, true)
            service_option_parent.append(new_option).trigger('open').attr('disabled','disabled')
            $('.loader-select-service').hide()
          }

        }else{
            let option_text ='رفت-بدون سرویس';
            let option_value = ''
            let new_option = new Option(option_text, option_value, true, true)
            service_option_parent.append(new_option).trigger('open').attr('disabled','disabled')

            $('.loader-select-service').hide()
          }

        if (services[1] !== undefined) {
          let service_return = services[1]

          if(service_option_parent_return.length > 0){
            console.log('first==>'+service_option_parent_return )
          Object.keys(services[1]).forEach(key => {
            let price_option = (parseInt(service_return[key]['ShowMoney']) == 0) ? 'رایگان' : service_return[key]['ShowMoney']
            let option_text = `${service_return[key]['ServiceTypeName']}- ${price_option}`
            let option_value = `${service_return[key]['ServiceTypeName']} @@ ${service_return[key]['ShowMoney']} @@ ${service_return[key]['ServiceTypeCode']}`
            let new_option = new Option(option_text, option_value, true, true)
            service_option_parent_return.append(new_option).trigger('open')
            service_option_parent_return.val('')
          })
          $('.loader-select-service').hide()
            }else{
            console.log('els first==>'+service_option_parent_return )

            let option_text ='برگشت-بدون سرویس';
            let option_value = ''
            let new_option = new Option(option_text, option_value, true, true)
            service_option_parent_return.append(new_option).trigger('open').attr('disabled','disabled')
             $('.loader-select-service').hide()

            }
        }else{
          console.log('els first==>'+service_option_parent_return )
          let option_text ='برگشت-بدون سرویس';
          let option_value = ''
          let new_option = new Option(option_text, option_value, true, true)
          service_option_parent_return.append(new_option).trigger('open').attr('disabled','disabled')
          $('.loader-select-service').hide()
        }

        $('#success_load').val(true)
      },
      error: function(error) {
        $('#success_load').val(false)
      },
    })
  }



  function getFreePassengerServices() {
    $('.loader-select-free-option').show()
    $.ajax({
      type: 'POST',
      url: amadeusPath + 'ajax',
      dataType: 'json',
      data: JSON.stringify({
        method: 'getFreePassengerServices',
        className: 'trainPassengersDetail',
        service_code: "{/literal}{$InfoTrain[0]['ServiceCode']}{literal}",
        is_coupe: "{/literal}{$smarty.post.IsCoupe}{literal}",
      }),
      success: function(response) {
        $('.loader-select-free-option').show()
        console.log('sss In')
        let services = response.data
        let service_option_parent = $('.free-dept-js')
        let service_option_parent_return = $('.free-return-js')
        if (services[0] !== undefined) {
          let service_dept = services[0]


          if(service_dept.length > 0){
            Object.keys(services[0]).forEach(key => {
              let option_text = `${service_dept[key]['ServiceTypeName']}`
              let option_value = `${service_dept[key]['ServiceTypeName']} @@ ${service_dept[key]['ServiceTypeCode']}`
              let new_option = new Option(option_text, option_value, true, true)
              service_option_parent.append(new_option).trigger('open').removeAttr('disabled')
              service_option_parent.val('')
            })
            $('.loader-select-free-option').hide()

          }else{
            let option_text ='رفت-بدون سرویس رایگان';
            let option_value = ''
            let new_option = new Option(option_text, option_value, true, true)
            service_option_parent.append(new_option).trigger('open').attr('disabled','disabled')
            $('.loader-select-free-option').hide()
          }

        }else{
          let option_text ='رفت-بدون سرویس رایگان';
          let option_value = ''
          let new_option = new Option(option_text, option_value, true, true)
          service_option_parent.append(new_option).trigger('open').attr('disabled','disabled')

          $('.loader-select-free-option').hide()
        }

        if (services[1] !== undefined) {
          let service_return = services[1]

          if(service_option_parent_return.length > 0){
            Object.keys(services[1]).forEach(key => {
              let option_text = `${service_return[key]['ServiceTypeName']}`
              let option_value = `${service_return[key]['ServiceTypeName']} @@ ${service_return[key]['ServiceTypeCode']}`
              let new_option = new Option(option_text, option_value, true, true)
              service_option_parent_return.append(new_option).trigger('open')
              service_option_parent_return.val('')
            })
            $('.loader-select-free-option').hide()
          }else{
            let option_text ='برگشت-بدون سرویس رایگان';
            let option_value = ''
            let new_option = new Option(option_text, option_value, true, true)
            service_option_parent_return.append(new_option).trigger('open').attr('disabled','disabled')
            $('.loader-select-free-option').hide()

          }
        }else{

          let option_text ='برگشت-بدون سرویس رایگان';
          let option_value = ''
          let new_option = new Option(option_text, option_value, true, true)
          service_option_parent_return.append(new_option).trigger('open').attr('disabled','disabled')
          $('.loader-select-free-option').hide()
        }

        $('#success_load').val(true)
      },
      error: function(error) {
        $('#success_load').val(false)
      },
    })
  }


  // hide popup
  $('.s-u-t-r-p .s-u-t-r-p-h').on('click', function(e) {
    e.preventDefault()
    $('.s-u-black-container').fadeOut('slow')
    $('.s-u-t-r-p').fadeOut('fast')
    return false
  })
  $('.s-u-b-r-p .s-u-t-r-p-h').on('click', function(e) {
    e.preventDefault()
    $('.s-u-black-container').fadeOut('slow')
    $('.s-u-b-r-p').fadeOut('fast')
    return false
  })
  $('.s-u-black-container').on('click', function(e) {
    e.preventDefault()
    $('.s-u-black-container').fadeOut('slow')
    $('.s-u-b-r-p').fadeOut('fast')
    $('.s-u-t-r-p').fadeOut('fast')
  })
</script>
{/literal}