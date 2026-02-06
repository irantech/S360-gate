
{*   <li class="nav-item">*}
{*        <a class="nav-link  {if ($smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'internalFlight') || $smarty.const.GDS_SWITCH eq 'mainPage' ||  $active_tab eq NULL } active {/if}" href="#Flight"  id="Flight-tab" data-toggle="tab" >*}
{*                <span>*}
{*                    <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M320 93.68V178.3L397.1 222.4C350.6 254 320 307.4 320 368C320 422.2 344.5 470.7 383.1 502.1C381 508.3 375.9 512 369.1 512C368.7 512 367.4 511.8 366.1 511.5L256 480L145.9 511.5C144.6 511.8 143.3 512 142 512C134.3 512 128 505.7 128 497.1V456C128 450.1 130.4 446.2 134.4 443.2L192 400V329.1L20.4 378.2C10.17 381.1 0 373.4 0 362.8V297.3C0 291.5 3.076 286.2 8.062 283.4L192 178.3V93.68C192 59.53 221 0 256 0C292 0 320 59.53 320 93.68H320zM640 368C640 447.5 575.5 512 496 512C416.5 512 352 447.5 352 368C352 288.5 416.5 224 496 224C575.5 224 640 288.5 640 368zM540.7 324.7L480 385.4L451.3 356.7C445.1 350.4 434.9 350.4 428.7 356.7C422.4 362.9 422.4 373.1 428.7 379.3L468.7 419.3C474.9 425.6 485.1 425.6 491.3 419.3L563.3 347.3C569.6 341.1 569.6 330.9 563.3 324.7C557.1 318.4 546.9 318.4 540.7 324.7H540.7z"/></svg></i>*}
{*                    <h4>هواپیما</h4>*}
{*                </span>*}
{*        </a>*}
{*    </li>*}
    <li class="nav-item">
        <a class="nav-link {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'Hotel' || $smarty.const.GDS_SWITCH eq 'mainPage' ||  $active_tab eq NULL} active {/if} " id="Hotel-tab" data-toggle="tab" href="#Hotel">
                <span>
                    <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M280 145.3V112h16C309.3 112 320 101.3 320 88S309.3 64 296 64H215.1C202.7 64 192 74.75 192 87.1S202.7 112 215.1 112H232v33.32C119.6 157.3 32 252.4 32 368h448C480 252.4 392.4 157.3 280 145.3zM488 400h-464C10.75 400 0 410.7 0 423.1C0 437.3 10.75 448 23.1 448h464c13.25 0 24-10.75 24-23.1C512 410.7 501.3 400 488 400z"/></svg></i>
                    <h4>هتل</h4>
                </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'Tour'} active {/if} " id="Tour-tab" data-toggle="tab" href="#Tour">
                <span>
                   <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M368 128h-47.95l.0123-80c0-26.5-21.5-48-48-48h-96c-26.5 0-48 21.5-48 48L128 128H80C53.5 128 32 149.5 32 176v256C32 458.5 53.5 480 80 480h16.05L96 496C96 504.9 103.1 512 112 512h32C152.9 512 160 504.9 160 496L160.1 480h128L288 496c0 8.875 7.125 16 16 16h32c8.875 0 16-7.125 16-16l.0492-16H368c26.5 0 48-21.5 48-48v-256C416 149.5 394.5 128 368 128zM176.1 48h96V128h-96V48zM336 384h-224C103.2 384 96 376.8 96 368C96 359.2 103.2 352 112 352h224c8.801 0 16 7.199 16 16C352 376.8 344.8 384 336 384zM336 256h-224C103.2 256 96 248.8 96 240C96 231.2 103.2 224 112 224h224C344.8 224 352 231.2 352 240C352 248.8 344.8 256 336 256z"/></svg></i>
                   <h4>تور</h4>
                </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'Visa'} active {/if}" id="Visa-tab" data-toggle="tab" href="#Visa">
            <span>
                <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M129.6 208c5.25 31.25 25.62 57.13 53.25 70.38C175.3 259.4 170.3 235 168.8 208H129.6zM129.6 176h39.13c1.5-27 6.5-51.38 14.12-70.38C155.3 118.9 134.9 144.8 129.6 176zM224 286.8C231.8 279.3 244.8 252.3 247.4 208H200.5C203.3 252.3 216.3 279.3 224 286.8zM265.1 105.6C272.8 124.6 277.8 149 279.3 176h39.13C313.1 144.8 292.8 118.9 265.1 105.6zM384 0H64C28.65 0 0 28.65 0 64v384c0 35.35 28.65 64 64 64h320c35.2 0 64-28.8 64-64V64C448 28.8 419.2 0 384 0zM336 416h-224C103.3 416 96 408.8 96 400S103.3 384 112 384h224c8.75 0 16 7.25 16 16S344.8 416 336 416zM224 320c-70.75 0-128-57.25-128-128s57.25-128 128-128s128 57.25 128 128S294.8 320 224 320zM265.1 278.4c27.62-13.25 48-39.13 53.25-70.38h-39.13C277.8 235 272.8 259.4 265.1 278.4zM200.6 176h46.88C244.7 131.8 231.8 104.8 224 97.25C216.3 104.8 203.2 131.8 200.6 176z"/></svg></i>
                <h4>ویزا</h4>
            </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'holidays'} active {/if}" id="holidays-tab" data-toggle="tab" href="#holidays">
            <span>
                <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M400 192H32C14.25 192 0 206.3 0 224v192c0 53 43 96 96 96h192c53 0 96-43 96-96h16c61.75 0 112-50.25 112-112S461.8 192 400 192zM336 416c0 26.5-21.5 48-48 48H96c-26.5 0-48-21.5-48-48V240h288V416zM400 368H384v-128h16c35.25 0 64 28.75 64 64S435.3 368 400 368zM107.9 100.7C120.3 107.1 128 121.4 128 136c0 13.25 10.75 23.89 24 23.89S176 148.1 176 135.7c0-31.34-16.83-60.64-43.91-76.45C119.7 52.03 112 38.63 112 24.28c0-13.25-10.75-24.14-24-24.14S64 11.03 64 24.28C64 55.63 80.83 84.92 107.9 100.7zM219.9 100.7C232.3 107.1 240 121.4 240 136c0 13.25 10.75 23.86 24 23.86S288 148.1 288 135.7c0-31.34-16.83-60.64-43.91-76.45C231.7 52.03 224 38.63 224 24.28c0-13.25-10.75-24.18-24-24.18S176 11.03 176 24.28C176 55.63 192.8 84.92 219.9 100.7z"/></svg></i>
                <h4>تعطیلات</h4>
            </span>
        </a>

    <li class="nav-item">
        <a class="nav-link {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'TravelProgram'} active {/if}" href="javascript:" id="program-tab">
            <span>
                <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M172.6 328.9L184 344L242.3 259.8C248.8 250.4 262.8 250.7 268.9 260.3L352.4 391.4C359.1 402.1 351.5 416 338.9 416H112.5C99.22 416 91.72 400.8 99.81 390.2L147.2 328.7C153.6 320.3 166.3 320.4 172.6 328.9V328.9zM96 256C96 238.3 110.3 224 128 224C145.7 224 160 238.3 160 256C160 273.7 145.7 288 128 288C110.3 288 96 273.7 96 256zM152 64H296V24C296 10.75 306.7 0 320 0C333.3 0 344 10.75 344 24V64H384C419.3 64 448 92.65 448 128V448C448 483.3 419.3 512 384 512H64C28.65 512 0 483.3 0 448V128C0 92.65 28.65 64 64 64H104V24C104 10.75 114.7 0 128 0C141.3 0 152 10.75 152 24V64zM48 448C48 456.8 55.16 464 64 464H384C392.8 464 400 456.8 400 448V192H48V448z"/></svg></i>
                <h4>برنامه سفر</h4>
            </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'Insurance'} active {/if}" id="Insurance-tab" data-toggle="tab" href="#Insurance">
            <span>
                <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M115.4 136.8l102.1 37.35c35.13-81.62 86.25-144.4 139-173.7c-95.88-4.875-188.8 36.96-248.5 111.7C101.2 120.6 105.2 133.2 115.4 136.8zM247.6 185l238.5 86.87c35.75-121.4 18.62-231.6-42.63-253.9c-7.375-2.625-15.12-4.062-23.12-4.062C362.4 13.88 292.1 83.13 247.6 185zM521.5 60.51c6.25 16.25 10.75 34.62 13.13 55.25c5.75 49.87-1.376 108.1-18.88 166.9l102.6 37.37c10.13 3.75 21.25-3.375 21.5-14.12C642.3 210.1 598 118.4 521.5 60.51zM528 448h-207l65-178.5l-60.13-21.87l-72.88 200.4H48C21.49 448 0 469.5 0 496C0 504.8 7.163 512 16 512h544c8.837 0 16-7.163 16-15.1C576 469.5 554.5 448 528 448z"/></svg></i>
                <h4>بیمه مسافرتی</h4>
            </span>
        </a>
    </li>
    <li class="nav-item soon">
        <a class="nav-link {if $smarty.const.GDS_SWITCH eq 'page' && $active_tab eq 'rentCar'} active {/if}" id="europcar-tab" href="javascript:">
            <span>
                <i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M39.61 196.8L74.8 96.29C88.27 57.78 124.6 32 165.4 32H346.6C387.4 32 423.7 57.78 437.2 96.29L472.4 196.8C495.6 206.4 512 229.3 512 256V448C512 465.7 497.7 480 480 480H448C430.3 480 416 465.7 416 448V400H96V448C96 465.7 81.67 480 64 480H32C14.33 480 0 465.7 0 448V256C0 229.3 16.36 206.4 39.61 196.8V196.8zM109.1 192H402.9L376.8 117.4C372.3 104.6 360.2 96 346.6 96H165.4C151.8 96 139.7 104.6 135.2 117.4L109.1 192zM96 256C78.33 256 64 270.3 64 288C64 305.7 78.33 320 96 320C113.7 320 128 305.7 128 288C128 270.3 113.7 256 96 256zM416 320C433.7 320 448 305.7 448 288C448 270.3 433.7 256 416 256C398.3 256 384 270.3 384 288C384 305.7 398.3 320 416 320z"/></svg></i>
                <h4>دربستی واجاره خودرو</h4>
            </span>
        </a>
    </li>
