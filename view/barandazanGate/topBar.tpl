{load_presentation_object filename="Session" assign="objSession"}
{assign var="check_is_counter" value=$obj_main_page->checkIsCounter()}
{assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}

{if $obj_main_page->isLogin()}

    <div class="sup-menu-flex sup-menu-flex-login">
        <div>
            <h2>{$objSession->getNameUser()}</h2>
            <div class="d-flex justify-content-between align-items-center">
                {if $typeMember eq 'Counter'}
                    <span class="sup-menu-flex_span">{$objFunctions->CalculateCredit($objSession->getUserId())} </span>
                {elseif $typeMember eq 'Ponline'}
                    <span class="sup-menu-flex_span">{$objFunctions->getOnlineMemberCredit()|number_format}  ریال</span>
                {/if}
                {if $check_is_counter neq 1}
                <a class="sup-menu-flex_a" href="{$smarty.const.ROOT_ADDRESS}/profile">
                    <span>##ChargeAccount##</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M203.9 405.3c5.877 6.594 5.361 16.69-1.188 22.62c-6.562 5.906-16.69 5.375-22.59-1.188L36.1 266.7c-5.469-6.125-5.469-15.31 0-21.44l144-159.1c5.906-6.562 16.03-7.094 22.59-1.188c6.918 6.271 6.783 16.39 1.188 22.62L69.53 256L203.9 405.3z"></path></svg>
                </a>
                {/if}
            </div>
        </div>
        <a class="" href="{$smarty.const.ROOT_ADDRESS}/profile">
            <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 304h-96C78.8 304 0 382.8 0 480c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32C448 382.8 369.2 304 272 304zM48.99 464C56.89 400.9 110.8 352 176 352h96c65.16 0 119.1 48.95 127 112H48.99zM224 256c70.69 0 128-57.31 128-128c0-70.69-57.31-128-128-128S96 57.31 96 128C96 198.7 153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48z"></path></svg></i>
            ##userAccount##
        </a>
        <a href="{$smarty.const.ROOT_ADDRESS}/userBook">
            <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M296.2 336h-144c-13.2 0-24 10.8-24 24c0 13.2 10.8 24 24 24h144c13.2 0 24-10.8 24-24C320.2 346.8 309.4 336 296.2 336zM296.2 224h-144c-13.2 0-24 10.8-24 24c0 13.2 10.8 24 24 24h144c13.2 0 24-10.8 24-24C320.2 234.8 309.4 224 296.2 224zM352.1 128h-32.07l.0123-80c0-26.51-21.49-48-48-48h-96c-26.51 0-48 21.49-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64c0 17.67 14.4 32 32.07 32s31.94-14.33 31.94-32h128c0 17.67 14.39 32 32.06 32s31.93-14.33 31.93-32c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM176.1 48h96V128h-96V48zM368.2 416c0 8.836-7.164 16-16 16h-256c-8.836 0-16-7.164-16-16V192c0-8.838 7.164-16 16-16h256c8.836 0 16 7.162 16 16V416z"></path></svg></i>
            ##MyTravels##
        </a>
        <a href="{$smarty.const.ROOT_ADDRESS}/passengerList">
            <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 32H160C124.7 32 96 60.65 96 96v224c0 35.35 28.65 64 64 64h352c35.35 0 64-28.65 64-64V96C576 60.65 547.3 32 512 32zM528 320c0 8.822-7.178 16-16 16h-65.61c-7.414-36.52-39.68-64-78.39-64h-64c-38.7 0-70.97 27.48-78.39 64H160c-8.822 0-16-7.178-16-16V96c0-8.822 7.178-16 16-16h352c8.822 0 16 7.178 16 16V320zM336 112c-35.35 0-64 28.65-64 64s28.65 64 64 64s64-28.65 64-64S371.3 112 336 112zM456 480H120C53.83 480 0 426.2 0 360v-240C0 106.8 10.75 96 24 96S48 106.8 48 120v240c0 39.7 32.3 72 72 72h336c13.25 0 24 10.75 24 24S469.3 480 456 480z"></path></svg></i>
            ##PassengerListProfile##
        </a>
        {if $check_is_counter neq true}

            <a href="{$smarty.const.ROOT_ADDRESS}/transactionUser">
                <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M558.1 63.1L535 40.97C525.7 31.6 525.7 16.4 535 7.03C544.4-2.343 559.6-2.343 568.1 7.029L632.1 71.02C637.5 75.52 640 81.63 640 87.99C640 94.36 637.5 100.5 632.1 104.1L568.1 168.1C559.6 178.3 544.4 178.3 535 168.1C525.7 159.6 525.7 144.4 535 135L558.1 111.1L160 111.1V127.1C160 163.3 131.3 191.1 96 191.1H80V285.5L32 333.5V127.1C32 92.65 60.65 63.1 96 63.1H383.6L384 63.99L558.1 63.1zM560 319.1V226.5L608 178.5V383.1C608 419.3 579.3 447.1 544 447.1L81.94 447.1L104.1 471C114.3 480.4 114.3 495.6 104.1 504.1C95.6 514.3 80.4 514.3 71.03 504.1L7.029 440.1C2.528 436.5-.0003 430.4 0 423.1C0 417.6 2.529 411.5 7.03 407L71.03 343C80.4 333.7 95.6 333.7 104.1 343C114.3 352.4 114.3 367.6 104.1 376.1L81.94 399.1L255.1 399.1C256.1 399.1 256.3 399.1 256.4 399.1H480V383.1C480 348.6 508.7 319.1 544 319.1H560zM224 255.1C224 202.1 266.1 159.1 320 159.1C373 159.1 416 202.1 416 255.1C416 309 373 351.1 320 351.1C266.1 351.1 224 309 224 255.1V255.1z"></path></svg></i>
                ##InventoryTransactions##
            </a>


        {/if}
        <a href="{$smarty.const.ROOT_ADDRESS}/club">
            <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M440 84.99V212.8L440.1 212.9L544.1 249.1C563.2 256.8 576 274.9 576 295.2V421.4C576 440.8 564.3 458.3 546.4 465.7L442.4 508.8C430.6 513.6 417.4 513.6 405.6 508.8L288 460.1L170.4 508.8C158.6 513.6 145.4 513.6 133.6 508.8L29.65 465.7C11.7 458.3 0 440.8 0 421.4V295.2C0 274.9 12.76 256.8 31.87 249.1L135.9 212.9L136 212.8V84.99C136 64.7 148.8 46.6 167.9 39.78L271.9 2.669C282.3-1.054 293.7-1.054 304.1 2.669L408.1 39.78C427.2 46.6 440 64.7 440 84.99H440zM293.4 32.81C289.9 31.57 286.1 31.57 282.6 32.81L178.6 69.92C176.3 70.75 174.2 72.1 172.6 73.79L287.1 118L403.4 73.79C401.8 72.1 399.7 70.75 397.4 69.92L293.4 32.81zM168.1 212.9L271.1 249.9V146.2L167.1 106.3V212.8L168.1 212.9zM304 249.9L407.9 212.9L408 212.8V106.3L304 146.2V249.9zM159.1 348.6V478.4L271.1 432.1V308.2L159.1 348.6zM41.88 436.2L127.1 471.8V348.1L31.1 308.9V421.4C31.1 427.8 35.9 433.7 41.88 436.2V436.2zM416 348.6L304 308.2V432.1L416 478.4V348.6zM448 471.8L534.1 436.2C540.1 433.7 544 427.8 544 421.4V308.9L448 348.1V471.8zM157.4 243C153.9 241.8 150.1 241.8 146.6 243L44.55 279.4L144.4 320.2L258.5 279.1L157.4 243zM317.5 279.1L431.6 320.2L531.4 279.4L429.4 243C425.9 241.8 422.1 241.8 418.6 243L317.5 279.1z"></path></svg></i>
            {if empty($about_user)}
                {load_presentation_object filename="user" assign="objUser"}
                {assign var="about_user" value = $objUser->getAboutClub()}
            {/if}
            {if isset($about_user) && $about_user['about_title_customer_club'] != ""}
                {$about_user['about_title_customer_club']}
            {else}
                ##ClubRoom##
            {/if}
        </a>
        <a target="_parent" class="logout-head" onclick="signout()">
            <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M505 273c9.4-9.4 9.4-24.6 0-33.9L377 111c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l87 87L184 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l246.1 0-87 87c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273zM168 80c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 32C39.4 32 0 71.4 0 120L0 392c0 48.6 39.4 88 88 88l80 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-80 0c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l80 0z"/></svg></i>
            ##S360Exit##
        </a>
    </div>
{else}
    <div class="sup-menu-flex">
        <div class="sup-menu-flex-r">
            <a target="_parent" class="log-reg-sub" href="{$smarty.const.ROOT_ADDRESS}/loginUser">
                <div>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                    <path d="M131.5,472H60.693c-8.538,0-13.689-4.765-15.999-7.606c-3.988-4.906-5.533-11.29-4.236-17.519
                        c20.769-99.761,108.809-172.616,210.445-174.98c1.693,0.063,3.39,0.105,5.097,0.105c1.722,0,3.434-0.043,5.142-0.107
                        c24.853,0.567,49.129,5.24,72.236,13.917c10.34,3.885,21.871-1.352,25.754-11.693c3.883-10.34-1.352-21.871-11.693-25.754
                        c-3.311-1.244-6.645-2.408-9.995-3.512C370.545,220.021,392,180.469,392,136C392,61.01,330.991,0,256,0
                        c-74.991,0-136,61.01-136,136c0,44.509,21.492,84.092,54.643,108.918c-30.371,9.998-58.871,25.546-83.813,46.062
                        c-45.732,37.617-77.529,90.086-89.532,147.743c-3.762,18.066,0.744,36.622,12.363,50.908C25.221,503.847,42.364,512,60.693,512
                        H131.5c11.046,0,20-8.954,20-20C151.5,480.954,142.546,472,131.5,472z M160,136c0-52.935,43.065-96,96-96s96,43.065,96,96
                        c0,51.367-40.554,93.438-91.326,95.885c-1.557-0.028-3.114-0.052-4.674-0.052c-1.564,0-3.127,0.023-4.689,0.051
                        C200.546,229.43,160,187.362,160,136z"/>
                        <path d="M496.689,344.607c-8.561-19.15-27.845-31.558-49.176-31.607h-62.372c-0.045,0-0.087,0-0.133,0
                        c-22.5,0-42.13,13.26-50.029,33.807c-1.051,2.734-2.336,6.178-3.677,10.193H200.356c-5.407,0-10.583,2.189-14.35,6.068
                        l-34.356,35.388c-7.567,7.794-7.529,20.203,0.085,27.95l35,35.612c3.76,3.826,8.9,5.981,14.264,5.981h65c11.046,0,20-8.954,20-20
                        c0-11.046-8.954-20-20-20h-56.614l-15.428-15.698L208.814,397h137.491c9.214,0,17.235-6.295,19.426-15.244
                        c1.618-6.607,3.648-12.959,6.584-20.596c1.936-5.036,6.798-8.16,12.741-8.16c0.013,0,0.026,0,0.039,0h62.371
                        c5.656,0.013,10.524,3.053,12.705,7.932c5.369,12.012,11.78,30.608,11.828,50.986c0.048,20.529-6.356,39.551-11.739,51.894
                        c-2.17,4.978-7.079,8.188-12.56,8.188c-0.011,0-0.022,0-0.033,0h-63.125c-5.533-0.013-10.716-3.573-12.896-8.858
                        c-2.339-5.671-4.366-12.146-6.197-19.797c-2.571-10.742-13.367-17.366-24.105-14.796c-10.743,2.571-17.367,13.364-14.796,24.106
                        c2.321,9.699,4.978,18.118,8.121,25.738c8.399,20.364,27.939,33.555,49.827,33.606h63.125c0.043,0,0.083,0,0.126,0
                        c21.351-0.001,40.647-12.63,49.18-32.201c6.912-15.851,15.137-40.511,15.072-67.975
                        C511.935,384.434,503.638,360.153,496.689,344.607z"/>
                        <circle cx="431" cy="412" r="20"/>
                </svg>

                </div>
                <span>##S360UserLogin##</span>
            </a>
        </div>
        <div class="sup-menu-flex-l">
            <a target="_parent" class="log-reg-sub" href="{$smarty.const.ROOT_ADDRESS}/registerUser">
                <div>
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                    <circle cx="370" cy="346" r="20"/>
                        <path d="M460,362c11.046,0,20-8.954,20-20v-74c0-44.112-35.888-80-80-80h-24.037v-70.534C375.963,52.695,322.131,0,255.963,0
                        s-120,52.695-120,117.466V188H112c-44.112,0-80,35.888-80,80v164c0,44.112,35.888,80,80,80h288c44.112,0,80-35.888,80-80
                        c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20c0,22.056-17.944,40-40,40H112c-22.056,0-40-17.944-40-40V268
                        c0-22.056,17.944-40,40-40h288c22.056,0,40,17.944,40,40v74C440,353.046,448.954,362,460,362z M335.963,188h-160v-70.534
                        c0-42.715,35.888-77.466,80-77.466s80,34.751,80,77.466V188z"/>
                        <circle cx="219" cy="346" r="20"/>
                        <circle cx="144" cy="346" r="20"/>
                        <circle cx="294" cy="346" r="20"/>
                </svg>
                </div>
                <span>##S360UserRegister##</span>
            </a>

        </div>
    </div>
{/if}