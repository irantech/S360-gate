{load_presentation_object filename="user" assign="objUser"}
{assign var="check_is_counter" value=$objUser->checkIsCounter() }
{if $objSession->IsLogin()}

    {if $smarty.const.SOFTWARE_LANG eq 'fa'}
        {assign var='noLimitCalendar' value="shamsiNoLimitCalendar"}
        {assign var="sDate" value=$objFunctions->DatePrev($objDate->jdate("Y-m-d", '', '', '', 'en'), '7')}
        {assign var="eDate" value=$objDate->jdate("Y-m-d", '', '', '', 'en')}

    {else}
        {assign var='noLimitCalendar' value="gregorianNoLimitCalendar"}
        {assign var="sDate" value=$objFunctions->DatePrev(date("Y-m-d"), '7')}
        {assign var="eDate" value=date("Y-m-d")}
    {/if}

    <style>
        /* ===== Wrapper جدید ===== */
        .info_new_wrapper {
            margin-top: 15px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 15px;

            /* حالت پیش‌فرض بسته */
            height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all 0.3s ease;
        }

        /* زمانی که باز میشه */
        .info_new_wrapper.active {
            height: auto;
            opacity: 1;
        }

        /* هر باکس جدید داخل Wrapper */
        .info_new_box {
            background: #fff;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.07);
            border: 1px solid #eee;
        }

        /* عنوان باکس */
        .info_new_box_title {
            font-size: 15px;
            font-weight: bold;
            padding-bottom: 10px;
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        /* آیتم داخل باکس */
        .info_new_item {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
        }

        /* title و value */
        .info_new_item span:first-child {
            color: #666;
        }
        .info_new_item span:last-child {
            font-weight: bold;
            color: #333;
        }
        /* رپِر دکمه‌ها */
        .info_new_buttons {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #e5e5e5;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* دکمه‌های اصلی */
        .info_new_buttons button,
        .info_new_buttons a {
            background: #2563eb; /* آبی شیک */
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s ease-in-out;
            position: relative;
        }

        /* حالت hover */
        .info_new_buttons button:hover,
        .info_new_buttons a:hover {
            background: #1e4fc6; /* آبی تیره‌تر */
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        /* دکمه استرداد */
        .info_new_buttons .recovery-btn {
            background: #dc2626 !important; /* قرمز */
        }

        .info_new_buttons .recovery-btn:hover {
            background: #b91c1c !important; /* قرمز تیره‌تر */
        }

        /* لودر حالت کوچک */
        .info_new_buttons .bouncing-loader {
            transform: scale(0.6);
            margin-right: 4px;
        }




    </style>


    <main>
    <section class="profile_section mt-3 mb-3 row">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 position-static">
                    <div class="menu-profile-ris d-lg-none">
                        <a href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}" class="logo_img"><img src='{$smarty.const.ROOT_ADDRESS_WITHOUT_LANG}/pic/{$smarty.const.CLIENT_LOGO}' alt='logo'></a>
                        <button onclick="openMenuProfile()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 88C0 74.75 10.75 64 24 64H424C437.3 64 448 74.75 448 88C448 101.3 437.3 112 424 112H24C10.75 112 0 101.3 0 88zM0 248C0 234.7 10.75 224 24 224H424C437.3 224 448 234.7 448 248C448 261.3 437.3 272 424 272H24C10.75 272 0 261.3 0 248zM424 432H24C10.75 432 0 421.3 0 408C0 394.7 10.75 384 24 384H424C437.3 384 448 394.7 448 408C448 421.3 437.3 432 424 432z"/></svg></button>
                    </div>
                    <div onclick="closeMenuProfile()" class="bg-black-profile-ris d-lg-none"></div>
                    <div class="box-style sticky-100">
                        {include file="./profileSideBar.tpl"}
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="box-style">
                        <div class="box-style-padding">
                            <h2 class="title">##SearchOrder##</h2>
                            <form id="FormUserDataSearchFilter" name="FormUserDataSearchFilter" method='post'
                                  enctype='multipart/form-data'>
                            <div class="form-profile">
                                <label class="label_style">
                                    <span>##OrderNumber##</span>
                                    <input type="text" name="factorNumber" id="factorNumber"  placeholder="##OrderNumber##">
                                </label>
                                <label class="label_style">
                                    <span>##DateOf##</span>
                                    <input type="text" name="startDate" id="startDate"
                                           class="{$noLimitCalendar}" value="{$sDate}" readonly placeholder="##DateOf##">
                                </label>
                                <label class="label_style">
                                    <span>##ToDate##</span>
                                    <input type="text"  name="endDate" id="endDate"
                                           class="{$noLimitCalendar}"
                                           value="{$eDate}"  readonly placeholder="##ToDate##">
                                </label>
                                <label class="label_style">
                                    <span>##Namepassenger##</span>
                                    <input type="text" name="passengerName" id="passengerName"  placeholder="##Namepassenger##">
                                </label>
                                <div class="label_style">
                                    <span>##Service##</span>
                                    <div class="calender_profile calender_profile_grid_1">
                                        <div>
                                            <select name="serviceType" id="serviceType" class="list_calender_profile select2" >
                                                <option value='all' selected >##All##</option>
                                                {assign var="arrayServices" value=Functions::getServicesAgency()}
                                                {assign var="checkedForFirst" value="0"}
                                                {foreach $arrayServices as $k=>$services}
                                                {assign var="servicesByLanguage" value=Functions::ConvertArrayByLanguage($k)}
                                                {$checkedForFirst = $checkedForFirst + 1}
                                                    {if $k neq 'package'}
                                                <option value={$k}>{$services}</option>
                                                    {/if}
                                                {/foreach}
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="label_style">
                                    <span>##Statusreservation##</span>
                                    <div class="calender_profile calender_profile_grid_1">
                                        <div>
                                            <select name="statusGroup" id="statusGroup" class="list_calender_profile select2" >
                                                <option value="">##All##</option>
                                                <option value="book"> ##Definitivereservation##</option>
                                                <option value="bank">##NotPaid##</option>
                                                <option value="prereserve">##Prereservation##</option>
                                                <option value="nothing">##BookingFailed##</option>
                                                <option value="cancel">##Refunded##</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box_btn mt-4">
                                <button id="Search_getUserBuy" type="button" onclick="getUserBuy()">##Search##</button>
                            </div>

                            </form>
                        </div>
                    </div>
                    <div id="memberResultSearch" class="memberResultSearch">
                    </div>
                    <div id="ModalResultProfile"></div>
                </div>
            </div>
        </div>
    </section>
</main>
{literal}
    <script src="assets/js/profile.js"></script>
    <script src="assets/js/userBook/userBook.js"></script>
    <script src="assets/js/userBook/bookUserShow.js"></script>
    <script>
      $(document).ready(function () {
        setTimeout(function () {
          getUserBuy();
        }, 100);
      });
      function getUserBuy() {
          bookUserHistoryFilter();
      }
    </script>

{/literal}
{else}
    {$objUser->redirectOut()}
{/if}
