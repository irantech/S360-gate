{load_presentation_object filename="reservationBasicInformation" assign="objResult"}
<header>
    <div class="container">
        <div class="navbar-content">
            <div class="d-flex align-items-center">
                <!-- Hamburger Menu Button -->
                <button class="menu-toggle" aria-label="Toggle menu">
                    <svg aria-hidden="true" class="e-font-icon-svg e-fas-stream" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M16 128h416c8.84 0 16-7.16 16-16V48c0-8.84-7.16-16-16-16H16C7.16 32 0 39.16 0 48v64c0 8.84 7.16 16 16 16zm480 80H80c-8.84 0-16 7.16-16 16v64c0 8.84 7.16 16 16 16h416c8.84 0 16-7.16 16-16v-64c0-8.84-7.16-16-16-16zm-64 176H16c-8.84 0-16 7.16-16 16v64c0 8.84 7.16 16 16 16h416c8.84 0 16-7.16 16-16v-64c0-8.84-7.16-16-16-16z"></path></svg>
                </button>
                <div class="logo">
                    <a href="https://hamintour.com">
                        <img src="project_files/images/logo.png" alt="{$obj->Title_head()}" class="logo-img">
                    </a>
                </div>
                <nav class="nav-menu">
                    <ul>
                        <li><a href="https://hamintour.com/">الصفحة الرئيسية</a></li>
                        <li><a href="https://hamintour.com/cart/">سلة التسوق</a></li>
                        <li><a href="https://hamintour.com/blog/">مجلة سياحية</a></li>
                        <li><a href="https://hamintour.com/about-us/">من نحن</a></li>
                        <li><a href="https://hamintour.com/contact-us/">مركز الاستجابة</a></li>
                    </ul>
                </nav>
            </div>
            <div class="user-cart">
                <a class="user-login {if $obj_main_page->isLogin()}show-box-login-js main-navigation__button2{else}main-navigation__button1{/if}" href="{if $obj_main_page->isLogin()}javascript:{else}{$smarty.const.ROOT_ADDRESS}/authenticate{/if}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><g id="Iconly/Regular/Two-tone/Profile"><g id="Profile"><path id="Stroke 1" fill-rule="evenodd" clip-rule="evenodd" d="M11.9848 15.3462C8.11719 15.3462 4.81433 15.931 4.81433 18.2729C4.81433 20.6148 8.09624 21.2205 11.9848 21.2205C15.8524 21.2205 19.1543 20.6348 19.1543 18.2938C19.1543 15.9529 15.8734 15.3462 11.9848 15.3462Z" stroke="#464646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path id="Stroke 3" opacity="0.4" fill-rule="evenodd" clip-rule="evenodd" d="M11.9848 12.0059C14.5229 12.0059 16.58 9.94779 16.58 7.40969C16.58 4.8716 14.5229 2.81445 11.9848 2.81445C9.44667 2.81445 7.38858 4.8716 7.38858 7.40969C7.38001 9.93922 9.42382 11.9973 11.9524 12.0059H11.9848Z" stroke="#464646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g></g></svg>
                    <span>{include file="../../include/signIn/topBarName.tpl"}</span>
                </a>
                <div class="main-navigation__sub-menu2 arrow-up show-content-box-login-js" style="display: none">
                    {include file="../../include/signIn/topBar.tpl"}
                </div>
                <!--                <div class="cart">-->
                <!--                    <i class="fas fa-shopping-bag"></i>-->
                <!--                </div>-->
                <a href="https://hamintour.com/shop/" class="offer-badge">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M4.79426 7.05575C4.79426 5.80675 5.80726 4.79375 7.05526 4.79375H8.08426C8.68026 4.79375 9.25326 4.55775 9.67726 4.13675L10.3963 3.41675C11.2773 2.53175 12.7093 2.52775 13.5943 3.40875L13.6033 3.41675L14.3233 4.13675C14.7463 4.55775 15.3193 4.79375 15.9163 4.79375H16.9443C18.1933 4.79375 19.2063 5.80675 19.2063 7.05575V8.08275C19.2063 8.68075 19.4423 9.25275 19.8633 9.67675L20.5833 10.3967C21.4683 11.2777 21.4733 12.7087 20.5923 13.5947L20.5833 13.6037L19.8633 14.3237C19.4423 14.7457 19.2063 15.3197 19.2063 15.9157V16.9447C19.2063 18.1937 18.1933 19.2057 16.9443 19.2057H15.9163C15.3193 19.2057 14.7463 19.4427 14.3233 19.8637L13.6033 20.5827C12.7233 21.4687 11.2913 21.4727 10.4053 20.5917C10.4023 20.5887 10.3993 20.5857 10.3963 20.5827L9.67726 19.8637C9.25326 19.4427 8.68026 19.2057 8.08426 19.2057H7.05526C5.80726 19.2057 4.79426 18.1937 4.79426 16.9447V15.9157C4.79426 15.3197 4.55726 14.7457 4.13626 14.3237L3.41726 13.6037C2.53126 12.7227 2.52726 11.2907 3.40826 10.4057L3.41726 10.3967L4.13626 9.67675C4.55726 9.25275 4.79426 8.68075 4.79426 8.08275V7.05575" stroke="#464646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path opacity="0.4" d="M9.42993 14.5694L14.5699 9.42944" stroke="#464646" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path opacity="0.4" d="M14.5667 15.3223C14.3667 15.3223 14.1767 15.2423 14.0367 15.1023C13.9667 15.0323 13.9167 14.9423 13.8767 14.8523C13.8367 14.7623 13.8167 14.6733 13.8167 14.5723C13.8167 14.4723 13.8367 14.3723 13.8767 14.2823C13.9167 14.1923 13.9667 14.1123 14.0367 14.0423C14.3167 13.7623 14.8167 13.7623 15.0967 14.0423C15.1667 14.1123 15.2267 14.1923 15.2667 14.2823C15.2967 14.3723 15.3167 14.4723 15.3167 14.5723C15.3167 14.6733 15.2967 14.7623 15.2667 14.8523C15.2267 14.9423 15.1667 15.0323 15.0967 15.1023C14.9567 15.2423 14.7667 15.3223 14.5667 15.3223Z" fill="#464646"></path><path opacity="0.4" d="M9.42651 10.1826C9.32651 10.1826 9.23651 10.1616 9.14651 10.1216C9.05651 10.0816 8.96651 10.0326 8.89651 9.96264C8.82651 9.88264 8.77651 9.80264 8.73651 9.71264C8.69651 9.62164 8.67651 9.53264 8.67651 9.43264C8.67651 9.33164 8.69651 9.23264 8.73651 9.14264C8.77651 9.05264 8.82651 8.96264 8.89651 8.90264C9.18651 8.62164 9.67651 8.62164 9.95651 8.90264C10.0965 9.04164 10.1765 9.23264 10.1765 9.43264C10.1765 9.53264 10.1665 9.62164 10.1265 9.71264C10.0865 9.80264 10.0265 9.88264 9.95651 9.96264C9.88651 10.0326 9.80651 10.0816 9.71651 10.1216C9.62651 10.1616 9.52651 10.1826 9.42651 10.1826Z" fill="#464646"></path></svg>
                    <span>عرض اليوم</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <a href="https://hamintour.com">
                <img src="project_files/images/logo.png" alt="HAMINTOUR Logo" class="logo-img">
            </a>
            <button class="close-menu" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="mobile-menu-nav">
            <ul>
                <li><a href="#">الصفحة الرئيسية</a></li>
                <li><a href="#">سلة التسوق</a></li>
                <li><a href="#">مجلة سياحية</a></li>
                <li><a href="#">من نحن</a></li>
                <li><a href="#">مركز الاستجابة</a></li>
            </ul>
        </nav>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>
</header>