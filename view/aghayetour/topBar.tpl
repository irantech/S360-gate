<div class="topbar">

    <div class="container">
        <div class="col-md-12 user_links">
            {if $objSession->IsLogin() }
                <a target="_parent" class="userProfile-name" href="{$smarty.const.ROOT_ADDRESS}/userProfile">
                    <span>{$objSession->getNameUser()} عزیز خوش آمدید</span>


                    {assign var="typeMember" value=$objFunctions->TypeUser($objSession->getUserId())}
                    {if $typeMember eq 'Counter'}
                        <span class="CreditHide">(اعتبار آژانس شما {$objFunctions->CalculateCredit($objSession->getUserId())}
                            ریال)</span>
                    {elseif $typeMember eq 'Ponline'}
                        {assign var="infoMember" value=$objFunctions->infoMember($objSession->getUserId())}
                        {if $infoMember.is_member eq '1' && $infoMember.fk_counter_type_id eq '5'}
                            <span class="CreditHide">(امتیاز شما {$objFunctions->getOnlineMemberCredit()|number_format}
                                ریال)</span>
                        {/if}
                    {/if}

                  

                </a>
                <div class="logined-links">
                    <div class="user_box_profile">
                        <a target="_parent" href="{$smarty.const.ROOT_ADDRESS}/userProfile">پروفایل کاربری</a>
                    </div>
                    <div class="user_box_logout">
                        <a style=" cursor: pointer " class="no-border" target="_parent" onclick="signout()">خروج</a>
                    </div>
                </div>
            {else}
                <ul>
                    <li><a  target="_parent" href="{$smarty.const.ROOT_ADDRESS}/registerUser"><i class="fa fa-user"></i> ثبت نام </a></li>
                    <li><a  target="_parent" href="{$smarty.const.ROOT_ADDRESS}/loginUser"><i class=fakey">

                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512.002 512.002" style="width: 12px; vertical-align: middle; enable-background:new 0 0 512.002 512.002;" xml:space="preserve">
<g>
    <g>
        <circle cx="364" cy="140.062" r="32"/>
    </g>
</g>
                                    <g>
                                        <g>
                                            <path d="M506.478,165.937c-10.68-27.194-30.264-66.431-62.915-98.927c-32.535-32.384-71.356-51.408-98.194-61.666
			c-29.464-11.261-62.945-4.163-85.295,18.082l-78.538,78.17c-23.281,23.171-29.991,58.825-16.698,88.72
			c4.122,9.272,8.605,18.341,13.395,27.103L5.858,389.793C2.107,393.544,0,398.631,0,403.936v88c0,11.046,8.954,20,20,20h88
			c11.046,0,20-8.954,20-20v-36l36-0.001c11.046,0,20-8.954,20-20v-35.999h36c11.046,0,20-8.954,20-20c0-11.046-8.954-20-20-20h-56
			c-11.046,0-20,8.954-20,20v35.999l-36,0.001c-11.046,0-20,8.954-20,20v36H40V412.22l177.355-177.354
			c6.516-6.516,7.737-16.639,2.958-24.517c-6.931-11.424-13.298-23.632-18.923-36.285c-6.599-14.841-3.237-32.57,8.366-44.119
			l78.537-78.169c11.213-11.159,28.011-14.718,42.798-9.068c23.222,8.876,56.69,25.214,84.256,52.652
			c27.735,27.604,44.62,61.567,53.9,85.197c5.791,14.748,2.272,31.503-8.965,42.687l-79.486,79.114
			c-11.575,11.519-28.851,14.887-44.016,8.58c-12.507-5.202-24.62-11.382-36-18.367c-9.413-5.778-21.729-2.83-27.507,6.584
			c-5.778,9.414-2.831,21.73,6.583,27.508c13.152,8.072,27.136,15.207,41.562,21.207c30.142,12.539,64.525,5.8,87.595-17.161
			l79.486-79.113C511.044,229.157,518.101,195.534,506.478,165.937z"/>

                                        </g>
                                    </g>

</svg>



                            </i>ورود</a></li>
                </ul>
            {/if}
        </div>
        <div class="col-md-12">
            <div class="row" style="display: flex;flex-wrap: wrap;">

                <div class="logo_number">

                    <ul>

                        <li>
                            <a  target="_parent" class="flex-row" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}">
                                <div class="logo logoHolder flex-col">
                                    <img src="https://aghayetour.com/fa/user/images/logo.png" alt="آقای تور">
                                </div>

                                <div class="textholder centering">
                                    <div class="logoSubtext">
                                        <h1>آقای تور</h1>
                                        <span>(الهی گشت)</span>
                                    </div>




                                </div>
                            </a>
                        </li>



                    </ul>

                </div>


                <div class="regis_log {if $objSession->IsLogin() } logined {/if}">
                        <span class="">
                        <div class="entxt">Aghaye  tour</div>
                        <div class="phone_number">

                                <span>پشتیبانی 24 ساعته</span>
                             <a  target="_parent" class="SMFooterPhone">09106818838</a>
                          </div>
                        </span>


                    <div class="lang">
                        <a target="_parent" data-toggle="tooltip" data-placement="top" title="English" href="https://{$smarty.const.CLIENT_MAIN_DOMAIN}/en/user/home.php">

                            <img src="https://aghayetour.com/fa/user/images/en.png" alt="ElahiGasht English">

                        </a>
                    </div>

                </div>


            </div>
        </div>

    </div>

</div>