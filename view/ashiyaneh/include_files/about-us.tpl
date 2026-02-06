{$check_general = true}

{if $check_general}
    <section class="i_modular_about_us about">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 my-div-mobile">
                    <div class="parent-about">
                        <h5 class="titr-top">Arvan Travel</h5>
                        <h2>ABOUT US</h2>
                        <h3>Explore all the world with us</h3>
                        <p class="__aboutUs_class__">{$htmlContent = $about['body']|strip_tags}{$htmlContent|truncate:300}</p>
                        <ul class="ul-about">
                            <li>
                                <div class="li-about-img">
                                    <img src="project_files/images/group.png" />
                                </div>
                                <div class="d-flex flex-column">
                                    <h5>Years of companionship with travelers</h5>
                                    <p>We are with you with more than ten years of work experience in the world of

                                        travel</p>
                                </div>
                            </li>
                            <li>
                                <div class="li-about-img">
                                    <img src="project_files/images/suitcase.png" />
                                </div>
                                <div class="d-flex flex-column">
                                    <h5>Travel with confidence</h5>
                                    <p>You can confidently trust Persian Golf and enjoy a high quality travel

                                        experience</p>
                                </div>
                            </li>
                        </ul>
                        <div class="phone-call-about">
                            <div class="icon-about-phone">
                                <svg viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M272 0C404.5 0 512 107.5 512 240c0 8.8-7.2 16-16 16s-16-7.2-16-16c0-114.9-93.1-208-208-208c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-80c0-8.8 7.2-16 16-16c79.5 0 144 64.5 144 144c0 8.8-7.2 16-16 16s-16-7.2-16-16c0-61.9-50.1-112-112-112c-8.8 0-16-7.2-16-16zm73 174.7c11.3-13.8 30.3-18.5 46.7-11.4l112 48c17.6 7.5 27.4 26.5 23.4 45.1l-24 112c-4 18.4-20.3 31.6-39.1 31.6l0 0c-6.1 0-12.2-.1-18.3-.4l-.1 0h0c-4.6-.2-9.1-.4-13.7-.8C183.5 494.5 0 300.7 0 64v0C0 45.1 13.2 28.8 31.6 24.9l112-24c18.7-4 37.6 5.8 45.1 23.4l48 112c7 16.4 2.4 35.4-11.4 46.7l-40.6 33.2c26.7 46 65.1 84.4 111.1 111.1L329 286.7zM448 480c3.8 0 7-2.6 7.8-6.3l24-112c.8-3.7-1.2-7.5-4.7-9l-112-48c-3.3-1.4-7.1-.5-9.3 2.3l-33.2 40.6c-9.9 12.1-27.2 15.3-40.8 7.4c-50.9-29.5-93.3-71.9-122.7-122.7c-7.9-13.6-4.7-30.9 7.4-40.8l40.6-33.2c2.8-2.3 3.7-6.1 2.3-9.3l-48-112c-1.5-3.5-5.3-5.5-9-4.7l-112 24C34.6 57 32 60.2 32 64v0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0c0 229.6 186.1 415.8 415.7 416l.3 0z"></path>
                                </svg>
                            </div>
                            <div class="text-about-phone">
                                <p>For information</p>
                                <a class="__phone_class__"
                                   href="tel:{$smarty.const.CLIENT_PHONE}">{$smarty.const.CLIENT_PHONE}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-6 col-sm-12 col-12 d-none d-lg-block">
                    <div class="about-img position-relative">
                        <div class="parent-img">
                            <img alt="about" src="project_files/images/about-us.jpg" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}