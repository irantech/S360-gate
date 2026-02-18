{load_presentation_object filename="reservationHotel" assign="objResult"}
{load_presentation_object filename="Session" assign="objSession" }
{assign var="hotel_list" value=$objResult->hasAccessHotelList() }
{assign var="agency" value=$objFunctions->infoAgencyByMemberId($objSession->getUserId())}
<section class="side">
    <div class='sidebar-user'>
        <img src="assets/images/1.png" alt="img">
        <div class='parent-sidebar-user'>
            <div class='parent-name-select-hotel'>
                <div class="hotel-name-super-admin" onclick='showSelectHotel()'>
                    {foreach $hotel_list['hotel_list'] as $hotel}
                        {if $hotel['id'] == $smarty.const.MARKET_HOTEL_ID}
                            <span>{$hotel['name']}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M201 337c-9.4 9.4-24.6 9.4-33.9 0L7 177c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l143 143L327 143c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L201 337z"/></svg>
                        {/if}
                    {/foreach}
                </div>
                <div class='select-hotel'>
                    <input id='hotelSearch' type="text" placeholder='جستجو هتل'>
                    {foreach $hotel_list['hotel_list'] as $hotel}
                        <div id='searchResults' class='searchResults'>
                            <a href='{$smarty.const.ROOT_ADDRESS}/hotel/{$hotel['id']}' class='search-history'>
                                <h2>{$hotel['name']}</h2>
                                <div class='search-history-location'>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M272 192C272 236.2 236.2 272 192 272C147.8 272 112 236.2 112 192C112 147.8 147.8 112 192 112C236.2 112 272 147.8 272 192zM192 240C218.5 240 240 218.5 240 192C240 165.5 218.5 144 192 144C165.5 144 144 165.5 144 192C144 218.5 165.5 240 192 240zM384 192C384 279.4 267 435 215.7 499.2C203.4 514.5 180.6 514.5 168.3 499.2C116.1 435 0 279.4 0 192C0 85.96 85.96 0 192 0C298 0 384 85.96 384 192H384zM192 32C103.6 32 32 103.6 32 192C32 207.6 37.43 229 48.56 255.4C59.47 281.3 74.8 309.4 92.14 337.5C126.2 392.8 166.6 445.7 192 477.6C217.4 445.7 257.8 392.8 291.9 337.5C309.2 309.4 324.5 281.3 335.4 255.4C346.6 229 352 207.6 352 192C352 103.6 280.4 32 192 32z"/></svg>
                                    <span>{$hotel['city_name']}</span>
                                </div>
                            </a>
                        </div>
                    {/foreach}
                </div>
            </div>
            <div class="user-name-side">{$agency['user_name']}</div>
        </div>
    </div>
    <nav class='sidebar-navbar'>
        <ul>

            <li>
                <a class='navbar-item' href='{$smarty.const.ROOT_ADDRESS}/hotel/{$smarty.const.MARKET_HOTEL_ID}'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 416V160H232V432H64c-8.8 0-16-7.2-16-16zm232 16V160H464V416c0 8.8-7.2 16-16 16H280zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z"/></svg>
                    <span>داشبورد</span>
                </a>
            </li>
            {if 'counter'|in_array:$role['type']  || $role['type'] == 'admin'}
            <li>
                <a class='navbar-item'  href='{$smarty.const.ROOT_ADDRESS}/bookings/{$smarty.const.MARKET_HOTEL_ID}'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M153.8 72.1c8.9-9.9 8.1-25-1.8-33.9s-25-8.1-33.9 1.8L63.1 101.1 41 79C31.6 69.7 16.4 69.7 7 79s-9.4 24.6 0 33.9l40 40c4.7 4.7 11 7.2 17.6 7s12.8-3 17.2-7.9l72-80zm0 160c8.9-9.9 8.1-25-1.8-33.9s-25-8.1-33.9 1.8L63.1 261.1 41 239c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l40 40c4.7 4.7 11 7.2 17.6 7s12.8-3 17.2-7.9l72-80zM216 120H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H216c-13.3 0-24 10.7-24 24s10.7 24 24 24zM192 256c0 13.3 10.7 24 24 24H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H216c-13.3 0-24 10.7-24 24zM160 416c0 13.3 10.7 24 24 24H488c13.3 0 24-10.7 24-24s-10.7-24-24-24H184c-13.3 0-24 10.7-24 24zm-64 0a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                    <span>سوابق خرید</span>
                </a>
            </li>
            <li>
                <a class='navbar-item' href='{$smarty.const.ROOT_ADDRESS}/roomManagement/{$smarty.const.MARKET_HOTEL_ID}'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                    <span>ویرایش اتاق</span>
                </a>
            </li>
            <li>
                <a class='navbar-item' href='{$smarty.const.ROOT_ADDRESS}/hotelLog/{$smarty.const.MARKET_HOTEL_ID}'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M128 0c13.3 0 24 10.7 24 24V64H296V24c0-13.3 10.7-24 24-24s24 10.7 24 24V64h40c35.3 0 64 28.7 64 64v16 48H432 400 288 48V448c0 8.8 7.2 16 16 16H284.5c12.3 18.8 28 35.1 46.3 48H64c-35.3 0-64-28.7-64-64V192 144 128C0 92.7 28.7 64 64 64h40V24c0-13.3 10.7-24 24-24zM288 368a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-80c-8.8 0-16 7.2-16 16v64c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H448V304c0-8.8-7.2-16-16-16z"/></svg>
                    <span>گزارش تغییرات</span>
                </a>
            </li>
            {/if}
            {if 'accountant'|in_array:$role['type']  || $role['type'] == 'admin'}
            <li>
                <a class='navbar-item'  href='{$smarty.const.ROOT_ADDRESS}/hotelFinancialCenter/{$smarty.const.MARKET_HOTEL_ID}'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 24c0 13.3 10.7 24 24 24h54.1L286.7 159.3 191.6 77.8c-9-7.7-22.4-7.7-31.3 .1l-120 104c-10 8.7-11.1 23.8-2.4 33.9s23.8 11.1 33.9 2.4l104.4-90.5 96.3 82.5c9.5 8.2 23.7 7.6 32.6-1.3l127-127V136c0 13.3 10.7 24 24 24s24-10.7 24-24V24c0-13.3-10.7-24-24-24H344c-13.3 0-24 10.7-24 24zM103.5 304h305c3.6 29 26.6 51.9 55.5 55.5v49c-29 3.6-51.9 26.6-55.5 55.5h-305c-3.6-29-26.6-51.9-55.5-55.5v-49c28.9-3.6 51.9-26.6 55.5-55.5zM48 256c-26.5 0-48 21.5-48 48V464c0 26.5 21.5 48 48 48H464c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48H48zM256 448a64 64 0 1 0 0-128 64 64 0 1 0 0 128z"/></svg>
                    <span>صورت وضعیت مالی</span>
                </a>
            </li>
            <li>
                <a class='navbar-item' href='{$smarty.const.ROOT_ADDRESS}/hotelInvoices/{$smarty.const.MARKET_HOTEL_ID}'>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M336 448V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320c8.8 0 16-7.2 16-16zM0 64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM192 215.6c11 0 20 9 20 20v10.1c7.2 1.1 14.2 2.5 20.6 4.1c10.7 2.5 17.4 13.3 14.9 24.1s-13.3 17.4-24.1 14.9c-11-2.6-21.8-4.5-31.7-4.7c-8.2-.1-16.7 1.6-22.4 4.6c-5.2 2.8-5.3 4.7-5.3 5.9c0 .4 0 .4 0 .4c0 0 0 0 0 0c.3 .4 1.4 1.6 4.4 3.2c6.5 3.5 15.8 6 28.6 9.5l.7 .2c11.2 3 25.4 6.8 36.8 13.2c12.4 7 25.2 19.2 25.4 39.3c.3 20.7-11.7 34.8-25.7 42.5c-6.9 3.8-14.6 6.3-22.3 7.8v10.1c0 11-9 20-20 20s-20-9-20-20V409.7c-10-1.9-19.3-4.8-27.5-7.3l0 0c-2.1-.7-4.2-1.3-6.1-1.9c-10.6-3.1-16.6-14.3-13.5-24.9s14.3-16.6 24.9-13.5c2.5 .7 4.9 1.5 7.2 2.2l0 0 0 0c13.6 4.1 24.2 7.3 35.7 7.7c8.9 .3 17.2-1.5 22.4-4.4c4.4-2.5 5.1-4.5 5-6.9l0-.1c0-.5 .2-2-5-4.8c-6.4-3.6-15.7-6.3-28.3-9.7l-1.7-.5c-10.9-2.9-24.5-6.6-35.4-12.4c-12.2-6.5-25.4-18.4-25.6-38.6c-.1-21 13.2-34.4 26.7-41.5c6.7-3.5 14-5.9 21.3-7.3V235.6c0-11 9-20 20-20zM96 96h80c8.8 0 16 7.2 16 16s-7.2 16-16 16H96c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h80c8.8 0 16 7.2 16 16s-7.2 16-16 16H96c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                    <span>لیست فاکتور ها</span>
                </a>
            </li>
            {/if}
            <li>
                <a class='support-item-navbar' href='tel:{$agency['phone']}'>
                    <span>پشتیبانی</span>
                    <h3>{$agency['phone']}</h3>
                </a>
            </li>
        </ul>
    </nav>
</section>