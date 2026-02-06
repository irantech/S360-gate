{assign var="userInfo" value=functions::infoMember($smarty.session.userId)}
{assign var="hashedPass" value=functions::HashKey({$userInfo['email']},'encrypt')}


{if $objSession->IsLogin() }
    <div class="sup-menu-flex sup-menu-flex-login">
        <div class="sup-menu-flex-r">
            <div class="login-head-icon">
                <?xml version="1.0"?>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  version="1.1"  x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g>
                        <g xmlns="http://www.w3.org/2000/svg">
                            <path style="" d="M453.71,409.92V512H58.29V409.92c0-85.15,69.28-154.42,154.42-154.42h86.58   C384.43,255.5,453.71,324.77,453.71,409.92z" fill="#a38eff" data-original="#00a5ff" class=""/>
                            <path style="" d="M375.41,119.41c0,65.84-53.57,119.41-119.41,119.41s-119.41-53.57-119.41-119.41S190.16,0,256,0   S375.41,53.57,375.41,119.41z" fill="#a38eff" data-original="#00a5ff" class=""/>
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                            <path style="" d="M256,238.82V0c65.84,0,119.41,53.57,119.41,119.41S321.84,238.82,256,238.82z" fill="#a38eff" data-original="#0087ff" class=""/>
                            <path style="" d="M453.71,409.92V512H256V255.5h43.29C384.43,255.5,453.71,324.77,453.71,409.92z" fill="#a38eff" data-original="#0087ff" class=""/>
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                        <g xmlns="http://www.w3.org/2000/svg">
                        </g>
                    </g></svg>



            </div>
            <div class="hello-login"><span>{functions::StrReplaceInXml(["@@getNameUser@@"=>$objSession->getNameUser()],"S360UserWelcome")}</span></div>
            {assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}
            {if $typeMember eq 'Counter'}
                <div class="etebar-login"><span>##S360Accreditation##</span>
                    <span><i>{$objFunctions->CalculateCredit($objSession->getUserId())}</i> <i>##S360Rial##</i></span>
                </div>
            {elseif $typeMember eq 'Ponline'}
                <div class="etebar-login"><span>##S360YourPriceIs##</span>
                    <span><i>{$objFunctions->getOnlineMemberCredit()|number_format} </i> <i>##S360IsRial##</i></span>
                </div>
            {/if}

            {if $smarty.const.IS_ENABLE_CLUB eq 1}

                    <a class="club_" target="_parent" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/fa/user/login.php?clubID={$hashedPass}">##S360CustomerClub##</a>
            {/if}
        </div>
        <div class="sup-menu-flex-l ">
            <ul class="support-menu__links">
                <li class="support-menu__link"><a target="_parent"  href="{$smarty.const.ROOT_ADDRESS}/userProfile" >
                        ##S360Profile##
                    </a></li>
                <li class="support-menu__link"><a target="_parent" href="{$smarty.const.ROOT_ADDRESS}/UserBuy" >
                        ##S360Showbuy##
                    </a></li>

                <li class="support-menu__link"><a target="_parent" href="{$smarty.const.ROOT_ADDRESS}/TrackingCancelTicket">
                        ##S360Precedents##
                    </a></li>
                <li class="support-menu__link"><a target="_parent"
                            href="{$smarty.const.ROOT_ADDRESS}/UserTracking">
                        ##S360UserTracking##
                    </a></li>
                <li class="support-menu__link"><a target="_parent" href="{$smarty.const.ROOT_ADDRESS}/UserPass">
                        ##S360Recordchange##
                    </a></li>
            </ul>
            <div class="log-reg-head">
                <a target="_parent" class="logout-head" onclick="signout()">##S360Exit##</a>
            </div>
        </div>
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



