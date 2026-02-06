{load_presentation_object filename="reservationHotel" assign="objResult"}
{load_presentation_object filename="resultTourLocal" assign="objTour"}
{load_presentation_object filename="user" assign="objUser"}
{load_presentation_object filename="resultReservationVisa" assign="objResultVisa"}
{load_presentation_object filename="visa" assign="objVisa"}
{load_presentation_object filename="entertainment" assign="objEntertainment"}

{assign var="check_is_counter" value=$objUser->checkIsCounter() }
{assign var="visaOptionByKeyArray" value=['clientID'=>$smarty.const.CLIENT_ID,'key'=>'marketPlace']}
{assign var="visaOptionByKey" value=$objVisa->visaOptionByKey($visaOptionByKeyArray)}

<div class="sideBar">
            <a class="d-flex d-lg-none" href="http://{$smarty.const.CLIENT_MAIN_DOMAIN}/{$MainUrlAddress}">
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M567.5 229.7C577.6 238.3 578.9 253.4 570.3 263.5C561.7 273.6 546.6 274.9 536.5 266.3L512 245.5V432C512 476.2 476.2 512 432 512H144C99.82 512 64 476.2 64 432V245.5L39.53 266.3C29.42 274.9 14.28 273.6 5.7 263.5C-2.875 253.4-1.634 238.3 8.473 229.7L272.5 5.7C281.4-1.9 294.6-1.9 303.5 5.7L567.5 229.7zM144 464H192V312C192 289.9 209.9 272 232 272H344C366.1 272 384 289.9 384 312V464H432C449.7 464 464 449.7 464 432V204.8L288 55.47L112 204.8V432C112 449.7 126.3 464 144 464V464zM240 464H336V320H240V464z"/></svg>
                </i>
                ##Home##
            </a>
            <a href="{$smarty.const.ROOT_ADDRESS}/profile" {if $smarty.const.GDS_SWITCH eq profile} class="active_sideBar_item" {/if}>
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M272 304h-96C78.8 304 0 382.8 0 480c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32C448 382.8 369.2 304 272 304zM48.99 464C56.89 400.9 110.8 352 176 352h96c65.16 0 119.1 48.95 127 112H48.99zM224 256c70.69 0 128-57.31 128-128c0-70.69-57.31-128-128-128S96 57.31 96 128C96 198.7 153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80S144 172.1 144 128C144 83.89 179.9 48 224 48z"/></svg>
                </i>
                ##userAccount##
            </a>
            <a {if $smarty.const.SOFTWARE_LANG == 'fa'} href="{$smarty.const.ROOT_ADDRESS}/userBook" {else}  href="{$smarty.const.ROOT_ADDRESS}/userBuy" {/if} {if $smarty.const.GDS_SWITCH eq userBook} class="active_sideBar_item" {/if}>
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M296.2 336h-144c-13.2 0-24 10.8-24 24c0 13.2 10.8 24 24 24h144c13.2 0 24-10.8 24-24C320.2 346.8 309.4 336 296.2 336zM296.2 224h-144c-13.2 0-24 10.8-24 24c0 13.2 10.8 24 24 24h144c13.2 0 24-10.8 24-24C320.2 234.8 309.4 224 296.2 224zM352.1 128h-32.07l.0123-80c0-26.51-21.49-48-48-48h-96c-26.51 0-48 21.49-48 48L128 128H96.12c-35.35 0-64 28.65-64 64v224c0 35.35 28.58 64 63.93 64c0 17.67 14.4 32 32.07 32s31.94-14.33 31.94-32h128c0 17.67 14.39 32 32.06 32s31.93-14.33 31.93-32c35.35 0 64.07-28.65 64.07-64V192C416.1 156.7 387.5 128 352.1 128zM176.1 48h96V128h-96V48zM368.2 416c0 8.836-7.164 16-16 16h-256c-8.836 0-16-7.164-16-16V192c0-8.838 7.164-16 16-16h256c8.836 0 16 7.162 16 16V416z"/></svg>
                </i>
                ##MyTravels##
            </a>
            <a href="{$smarty.const.ROOT_ADDRESS}/passengerList" {if $smarty.const.GDS_SWITCH eq passengerList} class="active_sideBar_item" {/if}>
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M512 32H160C124.7 32 96 60.65 96 96v224c0 35.35 28.65 64 64 64h352c35.35 0 64-28.65 64-64V96C576 60.65 547.3 32 512 32zM528 320c0 8.822-7.178 16-16 16h-65.61c-7.414-36.52-39.68-64-78.39-64h-64c-38.7 0-70.97 27.48-78.39 64H160c-8.822 0-16-7.178-16-16V96c0-8.822 7.178-16 16-16h352c8.822 0 16 7.178 16 16V320zM336 112c-35.35 0-64 28.65-64 64s28.65 64 64 64s64-28.65 64-64S371.3 112 336 112zM456 480H120C53.83 480 0 426.2 0 360v-240C0 106.8 10.75 96 24 96S48 106.8 48 120v240c0 39.7 32.3 72 72 72h336c13.25 0 24 10.75 24 24S469.3 480 456 480z"/></svg>
                </i>
                ##PassengerListProfile##
            </a>
            {if $check_is_counter neq true}
            <a href="{$smarty.const.ROOT_ADDRESS}/transactionUser" {if $smarty.const.GDS_SWITCH eq transactionUser} class="active_sideBar_item" {/if}>
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M558.1 63.1L535 40.97C525.7 31.6 525.7 16.4 535 7.03C544.4-2.343 559.6-2.343 568.1 7.029L632.1 71.02C637.5 75.52 640 81.63 640 87.99C640 94.36 637.5 100.5 632.1 104.1L568.1 168.1C559.6 178.3 544.4 178.3 535 168.1C525.7 159.6 525.7 144.4 535 135L558.1 111.1L160 111.1V127.1C160 163.3 131.3 191.1 96 191.1H80V285.5L32 333.5V127.1C32 92.65 60.65 63.1 96 63.1H383.6L384 63.99L558.1 63.1zM560 319.1V226.5L608 178.5V383.1C608 419.3 579.3 447.1 544 447.1L81.94 447.1L104.1 471C114.3 480.4 114.3 495.6 104.1 504.1C95.6 514.3 80.4 514.3 71.03 504.1L7.029 440.1C2.528 436.5-.0003 430.4 0 423.1C0 417.6 2.529 411.5 7.03 407L71.03 343C80.4 333.7 95.6 333.7 104.1 343C114.3 352.4 114.3 367.6 104.1 376.1L81.94 399.1L255.1 399.1C256.1 399.1 256.3 399.1 256.4 399.1H480V383.1C480 348.6 508.7 319.1 544 319.1H560zM224 255.1C224 202.1 266.1 159.1 320 159.1C373 159.1 416 202.1 416 255.1C416 309 373 351.1 320 351.1C266.1 351.1 224 309 224 255.1V255.1z"/></svg>
                </i>
                ##InventoryTransactions##
            </a>
            {/if}


           {if  $smarty.const.IS_ENABLE_CLUB eq 1}
            <a href="{$smarty.const.ROOT_ADDRESS}/club" {if $smarty.const.GDS_SWITCH eq club ||  $smarty.const.GDS_SWITCH eq listPointClubUser} class="active_sideBar_item" {/if}>
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M440 84.99V212.8L440.1 212.9L544.1 249.1C563.2 256.8 576 274.9 576 295.2V421.4C576 440.8 564.3 458.3 546.4 465.7L442.4 508.8C430.6 513.6 417.4 513.6 405.6 508.8L288 460.1L170.4 508.8C158.6 513.6 145.4 513.6 133.6 508.8L29.65 465.7C11.7 458.3 0 440.8 0 421.4V295.2C0 274.9 12.76 256.8 31.87 249.1L135.9 212.9L136 212.8V84.99C136 64.7 148.8 46.6 167.9 39.78L271.9 2.669C282.3-1.054 293.7-1.054 304.1 2.669L408.1 39.78C427.2 46.6 440 64.7 440 84.99H440zM293.4 32.81C289.9 31.57 286.1 31.57 282.6 32.81L178.6 69.92C176.3 70.75 174.2 72.1 172.6 73.79L287.1 118L403.4 73.79C401.8 72.1 399.7 70.75 397.4 69.92L293.4 32.81zM168.1 212.9L271.1 249.9V146.2L167.1 106.3V212.8L168.1 212.9zM304 249.9L407.9 212.9L408 212.8V106.3L304 146.2V249.9zM159.1 348.6V478.4L271.1 432.1V308.2L159.1 348.6zM41.88 436.2L127.1 471.8V348.1L31.1 308.9V421.4C31.1 427.8 35.9 433.7 41.88 436.2V436.2zM416 348.6L304 308.2V432.1L416 478.4V348.6zM448 471.8L534.1 436.2C540.1 433.7 544 427.8 544 421.4V308.9L448 348.1V471.8zM157.4 243C153.9 241.8 150.1 241.8 146.6 243L44.55 279.4L144.4 320.2L258.5 279.1L157.4 243zM317.5 279.1L431.6 320.2L531.4 279.4L429.4 243C425.9 241.8 422.1 241.8 418.6 243L317.5 279.1z"/></svg>
                </i>
                {if empty($about_user)}
                    {load_presentation_object filename="user" assign="objUser"}
                    {assign var="about_user" value = $objUser->getAboutClub()}
                {/if}
                {if $about_user['about_title_customer_club']}
                    {$about_user['about_title_customer_club']}
                {else}
                    ##ClubRoom##
                {/if}
            </a>
           {/if}




        {if $objTour->accessReservationTour() eq 'True'  and
        $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and
        $objSession->getCounterTypeId() eq 1 and $smarty.const.SOFTWARE_LANG == 'fa'
        }
        <a href="{$smarty.const.ROOT_ADDRESS}/tourList" {if $smarty.const.GDS_SWITCH eq tourList ||  $smarty.const.GDS_SWITCH eq tourRegistration ||  $smarty.const.GDS_SWITCH eq tourGallery ||  $smarty.const.GDS_SWITCH eq groupTourEdit ||  $smarty.const.GDS_SWITCH eq listTourDates} class="active_sideBar_item" {/if}>
            <i>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M147.3 84.69L190.6 41.37C196.6 35.37 204.8 32 213.3 32H416C433.7 32 448 46.33 448 64V128C448 145.7 433.7 160 416 160H213.3C204.8 160 196.6 156.6 190.6 150.6L147.3 107.3C141.1 101.1 141.1 90.94 147.3 84.69V84.69zM400 111.1V79.1H219.9L203.9 95.1L219.9 111.1H400zM64 63.1C81.67 63.1 96 78.33 96 95.1C96 113.7 81.67 127.1 64 127.1C46.33 127.1 32 113.7 32 95.1C32 78.33 46.33 63.1 64 63.1zM64 223.1C81.67 223.1 96 238.3 96 255.1C96 273.7 81.67 287.1 64 287.1C46.33 287.1 32 273.7 32 255.1C32 238.3 46.33 223.1 64 223.1zM64 448C46.33 448 32 433.7 32 416C32 398.3 46.33 384 64 384C81.67 384 96 398.3 96 416C96 433.7 81.67 448 64 448zM147.3 404.7L190.6 361.4C196.6 355.4 204.8 352 213.3 352H416C433.7 352 448 366.3 448 384V448C448 465.7 433.7 480 416 480H213.3C204.8 480 196.6 476.6 190.6 470.6L147.3 427.3C141.1 421.1 141.1 410.9 147.3 404.7V404.7zM400 432V400H219.9L203.9 416L219.9 432H400zM190.6 310.6L147.3 267.3C141.1 261.1 141.1 250.9 147.3 244.7L190.6 201.4C196.6 195.4 204.8 192 213.3 192H480C497.7 192 512 206.3 512 224V288C512 305.7 497.7 320 480 320H213.3C204.8 320 196.6 316.6 190.6 310.6V310.6zM203.9 255.1L219.9 271.1H464V239.1H219.9L203.9 255.1z"/></svg>
            </i>
            ##Tourlist##
        </a>
    {/if}
    {if $objResult->accessReservationHotel() eq 'True'  and
        $objFunctions->checkClientConfigurationAccess("hotel_market_place") and
        $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and
        $objSession->getCounterTypeId() eq 1}
        <a href="{$smarty.const.ROOT_ADDRESS}/hotelList">
            <i>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M147.3 84.69L190.6 41.37C196.6 35.37 204.8 32 213.3 32H416C433.7 32 448 46.33 448 64V128C448 145.7 433.7 160 416 160H213.3C204.8 160 196.6 156.6 190.6 150.6L147.3 107.3C141.1 101.1 141.1 90.94 147.3 84.69V84.69zM400 111.1V79.1H219.9L203.9 95.1L219.9 111.1H400zM64 63.1C81.67 63.1 96 78.33 96 95.1C96 113.7 81.67 127.1 64 127.1C46.33 127.1 32 113.7 32 95.1C32 78.33 46.33 63.1 64 63.1zM64 223.1C81.67 223.1 96 238.3 96 255.1C96 273.7 81.67 287.1 64 287.1C46.33 287.1 32 273.7 32 255.1C32 238.3 46.33 223.1 64 223.1zM64 448C46.33 448 32 433.7 32 416C32 398.3 46.33 384 64 384C81.67 384 96 398.3 96 416C96 433.7 81.67 448 64 448zM147.3 404.7L190.6 361.4C196.6 355.4 204.8 352 213.3 352H416C433.7 352 448 366.3 448 384V448C448 465.7 433.7 480 416 480H213.3C204.8 480 196.6 476.6 190.6 470.6L147.3 427.3C141.1 421.1 141.1 410.9 147.3 404.7V404.7zM400 432V400H219.9L203.9 416L219.9 432H400zM190.6 310.6L147.3 267.3C141.1 261.1 141.1 250.9 147.3 244.7L190.6 201.4C196.6 195.4 204.8 192 213.3 192H480C497.7 192 512 206.3 512 224V288C512 305.7 497.7 320 480 320H213.3C204.8 320 196.6 316.6 190.6 310.6V310.6zM203.9 255.1L219.9 271.1H464V239.1H219.9L203.9 255.1z"/></svg>
            </i>
            ##HotelManagement##
        </a>
    {/if}
    {if $objResultVisa->reservationVisaAuth() eq 'True'  and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and $visaOptionByKey['value'] eq 'available' and $smarty.const.SOFTWARE_LANG == 'fa'}

            <a href="{$smarty.const.ROOT_ADDRESS}/visaList"  {if $smarty.const.GDS_SWITCH eq visaNew || $smarty.const.GDS_SWITCH eq visaList} class="active_sideBar_item" {/if}>
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M384 0H64C28.65 0 0 28.65 0 64v384c0 35.34 28.65 64 64 64h320c35.2 0 64-28.8 64-64V64C448 28.8 419.2 0 384 0zM400 448c0 8.836-7.164 16-16 16H64c-8.836 0-16-7.164-16-16V64c0-8.836 7.164-16 16-16h320c8.836 0 16 7.164 16 16V448zM336 384h-224C103.3 384 96 391.3 96 400S103.3 416 112 416h224c8.75 0 16-7.25 16-16S344.8 384 336 384zM224 328c66.25 0 120-53.75 120-120S290.3 88 224 88S104 141.8 104 208S157.8 328 224 328zM310.4 192h-34.63c-1.375-23.62-5.751-45-12.25-62.25C287.6 142 305.4 164.6 310.4 192zM275.8 224h34.63c-5 27.38-22.88 50-46.88 62.25C269.1 269 274.4 247.6 275.8 224zM224 122.3C230.9 130.6 241.5 154.6 244 192h-40C206.5 154.6 217.1 130.6 224 122.3zM244 224C241.5 261.4 230.9 285.4 224 293.8C217.1 285.4 206.5 261.4 204 224H244zM184.5 129.8C177.1 147 173.6 168.4 172.3 192H137.6C142.6 164.6 160.4 142 184.5 129.8zM172.3 224C173.6 247.6 177.1 269 184.5 286.3C160.5 274 142.6 251.4 137.6 224H172.3z"/></svg>
                </i>
                ##SaleVisa##
            </a>
    {/if}

    {if $objEntertainment->reservationEntertainmentAuth() and $objFunctions->TypeUser($objSession->getUserId()) eq 'Counter' and   $objSession->getCounterTypeId() eq 1 and $smarty.const.SOFTWARE_LANG == 'fa'}
            <a href="{$smarty.const.ROOT_ADDRESS}/entertainmentPanel"  {if $smarty.const.GDS_SWITCH eq entertainmentPanel } class="active_sideBar_item" {/if}>
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M130.7 313.9C126.5 300.4 137.8 288 151.1 288H364.5C378.7 288 389.9 300.4 385.8 313.9C368.1 368.4 318.2 408 258.2 408C198.2 408 147.5 368.4 130.7 313.9V313.9zM217.6 228.8L217.6 228.8L217.4 228.5C217.2 228.3 217 228 216.7 227.6C216 226.8 215.1 225.7 213.9 224.3C211.4 221.4 207.9 217.7 203.7 213.1C194.9 206.2 184.8 200 176 200C167.2 200 157.1 206.2 148.3 213.1C144.1 217.7 140.6 221.4 138.1 224.3C136.9 225.7 135.1 226.8 135.3 227.6C134.1 228 134.8 228.3 134.6 228.5L134.4 228.8L134.4 228.8C132.3 231.6 128.7 232.7 125.5 231.6C122.2 230.5 120 227.4 120 224C120 206.1 126.7 188.4 136.6 175.2C146.4 162.2 160.5 152 176 152C191.5 152 205.6 162.2 215.4 175.2C225.3 188.4 232 206.1 232 224C232 227.4 229.8 230.5 226.5 231.6C223.3 232.7 219.7 231.6 217.6 228.8V228.8zM377.6 228.8L377.4 228.5C377.2 228.3 377 228 376.7 227.6C376 226.8 375.1 225.7 373.9 224.3C371.4 221.4 367.9 217.7 363.7 213.1C354.9 206.2 344.8 200 336 200C327.2 200 317.1 206.2 308.3 213.1C304.1 217.7 300.6 221.4 298.1 224.3C296.9 225.7 295.1 226.8 295.3 227.6C294.1 228 294.8 228.3 294.6 228.5L294.4 228.8L294.4 228.8C292.3 231.6 288.7 232.7 285.5 231.6C282.2 230.5 280 227.4 280 224C280 206.1 286.7 188.4 296.6 175.2C306.4 162.2 320.5 152 336 152C351.5 152 365.6 162.2 375.4 175.2C385.3 188.4 392 206.1 392 224C392 227.4 389.8 230.5 386.5 231.6C383.3 232.7 379.7 231.6 377.6 228.8L377.6 228.8zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"/></svg>
                </i>
                ##Entertainment##
            </a>
    {/if}

    <a class="d-flex" onclick="signout()" href="javascript:">
        <i>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M505 273c9.4-9.4 9.4-24.6 0-33.9L377 111c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l87 87L184 232c-13.3 0-24 10.7-24 24s10.7 24 24 24l246.1 0-87 87c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0L505 273zM168 80c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 32C39.4 32 0 71.4 0 120L0 392c0 48.6 39.4 88 88 88l80 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-80 0c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l80 0z"></path></svg>
        </i>
        ##Exit##
    </a>

        </div>

