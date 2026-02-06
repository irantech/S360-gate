<?php
require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
spl_autoload_register(array('Load', 'autoload'));

$LogoAppAddress = FRONT_THEMES_DIR.FRONT_TEMPLATE_NAME.'/project_files/images/applogo.png';
$LogoApp = ROOT_ADDRESS_WITHOUT_LANG . '/view/'.FRONT_TEMPLATE_NAME.'/project_files/images/applogo.png';
$LogoWeb = ROOT_ADDRESS_WITHOUT_LANG . '/view/'.FRONT_TEMPLATE_NAME.'/project_files/images/logo.png' ;
?>

<div class="page blit-search-page" id="page-blit">

    <input type="hidden" name="origin" id="origin" value="<?php echo !empty($_GET['Origin']) ? $_GET['Origin'] : '' ?>">
    <input type="hidden" name="destination" id="destination"
           value="<?php echo !empty($_GET['Destination']) ? $_GET['Destination'] : '' ?>">
    <input type="hidden" name="dept_date" id="dept_date"
           value="<?php echo !empty($_GET['DepartureDate']) ? $_GET['DepartureDate'] : '' ?>">
    <input type="hidden" name="return_date" id="return_date"
           value="<?php echo !empty($_GET['ReturnDate']) ? $_GET['ReturnDate'] : '' ?>">
    <input type="hidden" name="adult" id="adult"
           value="<?php echo !empty($_GET['AdultNumber']) ? $_GET['AdultNumber'] : '0' ?>">
    <input type="hidden" name="child" id="child"
           value="<?php echo !empty($_GET['ChildNumber']) ? $_GET['ChildNumber'] : '0' ?>">
    <input type="hidden" name="infant" id="infant"
           value="<?php echo !empty($_GET['InfantNumber']) ? $_GET['InfantNumber'] : '0' ?>">
    <input type="hidden" name="foreign" id="foreign"
           value="<?php echo !empty($_GET['Foreign']) ? $_GET['Foreign'] : '' ?>">
    <input type="hidden" class="Login" name="Login" id="Login" value="<?php echo Session::IsLogin() ?>">
    <input type="hidden" class="SourceId" name="SourceId" id="SourceId" value="<?php echo $_GET['SourceId'] ?>">
    <input type="hidden" value="<?php echo $_GET['MultiWay'] ?>" name="MultiWayTicket" id="MultiWayTicket"/>
    <input type="hidden" value="<?php echo 'Local' ?>" id="TypeZoneFlightList">
    <input type="hidden" value="" id="FlightIDReserveOffline">
    <div class="page-content">
        <div class="preloader color-white"></div>
        <div class="nav-search site-bg-main-color-before">
            <div class="nav-search-inner">
                <div class="back-link">
                    <a href="" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">جست و جو بلیط داخلی</div>
                <div class="blit-search-info">
                    <div class="blit-search-desti">از
                        <?php echo functions::NameCity($_GET['Origin']); ?>
                        به
                        <?php echo functions::NameCity($_GET['Destination']); ?></div>
                    <div class="blit-search-date"><?php $Date = functions::OtherFormatDate($_GET['DepartureDate']);
                        echo $Date['LetterDay'] . ' ' . $Date['NowDay']; ?></div>
                </div>
            </div>
        </div>
        <div class="popover popover-about">
            <div class="popover-inner">
                <div class="block">
                    <p>About</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac diam ac quam euismod porta vel a nunc. Quisque sodales scelerisque est, at porta justo cursus ac.</p>
                </div>
            </div>
        </div>


        <div class="sorting">
            <div class="sorting-price">
                <input type="hidden" value="desc" name="currentPriceSort" id="currentPriceSort">
                <span class="s-p-svg">
				<svg class="site-bg-svg-color" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 460.088 460.088" style="enable-background:new 0 0 460.088 460.088;"
                     xml:space="preserve">
				<g>
					<g>
						<g>
							<path d="M25.555,139.872h257.526V88.761H25.555C11.442,88.761,0,100.203,0,114.316C0,128.429,11.442,139.872,25.555,139.872z"/>
							<path d="M25.555,242.429h257.526v-51.111H25.555C11.442,191.318,0,202.76,0,216.874C0,230.988,11.442,242.429,25.555,242.429z"/>
							<path d="M25.555,293.874v0.001C11.442,293.875,0,305.316,0,319.43s11.442,25.555,25.555,25.555h178.91
								c-2.021-6.224-3.088-12.789-3.088-19.523c0-11.277,2.957-22.094,8.48-31.588H25.555z"/>
							<path d="M450.623,302.611c-12.62-12.621-33.083-12.621-45.704,0l-26.535,26.535V52.926c0-17.849-14.469-32.317-32.318-32.317
								s-32.318,14.469-32.318,32.317v276.22l-26.535-26.535c-12.621-12.62-33.083-12.621-45.704,0
								c-12.621,12.621-12.621,33.083,0,45.704l81.7,81.699c12.596,12.6,33.084,12.643,45.714,0l81.7-81.699
								C463.243,335.694,463.244,315.232,450.623,302.611z"/>
						</g>
					</g>
				</g>
				</svg>		
			</span>
                <span class="site-main-text-color">بر اساس قیمت</span>
            </div>
            <div class="sorting-time">
                <input type="hidden" value="desc" name="currentTimeSort" id="currentTimeSort">
                <span class="s-p-svg">
				<svg class="site-bg-svg-color" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 460.088 460.088" style="enable-background:new 0 0 460.088 460.088;"
                     xml:space="preserve">
				<g>
					<g>
						<g>
							<path d="M25.555,139.872h257.526V88.761H25.555C11.442,88.761,0,100.203,0,114.316C0,128.429,11.442,139.872,25.555,139.872z"/>
							<path d="M25.555,242.429h257.526v-51.111H25.555C11.442,191.318,0,202.76,0,216.874C0,230.988,11.442,242.429,25.555,242.429z"/>
							<path d="M25.555,293.874v0.001C11.442,293.875,0,305.316,0,319.43s11.442,25.555,25.555,25.555h178.91
								c-2.021-6.224-3.088-12.789-3.088-19.523c0-11.277,2.957-22.094,8.48-31.588H25.555z"/>
							<path d="M450.623,302.611c-12.62-12.621-33.083-12.621-45.704,0l-26.535,26.535V52.926c0-17.849-14.469-32.317-32.318-32.317
								s-32.318,14.469-32.318,32.317v276.22l-26.535-26.535c-12.621-12.62-33.083-12.621-45.704,0
								c-12.621,12.621-12.621,33.083,0,45.704l81.7,81.699c12.596,12.6,33.084,12.643,45.714,0l81.7-81.699
								C463.243,335.694,463.244,315.232,450.623,302.611z"/>
						</g>
					</g>
				</g>
				</svg>		
			</span>
                <span class="site-main-text-color">بر اساس ساعت حرکت</span>
            </div>
        </div>

        <div id="TicketInternal">
            <div class="first-preloader site-bg-main-color">
                <div class="img-preloader">
                    <img src="<?php echo  file_exists($LogoAppAddress) ? $LogoApp : $LogoWeb;?>"
                         alt="">
                    <div id="loader"></div>
                    </br>
                    </br>
                    <h4> در حال یافتن بهترین قیمت ها از تمامی ایرلاین ها
                        </br>
                        لطفا صبور باشید... </h4>
                </div>

            </div>
        </div>

        <div class="bottom-options">
            <div class="change-date">
                <a href="#" class="prev-date" id="DatePrev"
                   onclick="<?php if (empty($_GET['ReturnDate']) && (functions::indate($_GET['DepartureDate']) == 'true')) { ?>SearchAgain('<?php echo functions::DatePrev($_GET['DepartureDate']) ?>','<?php echo $_GET['Origin'] ?>','<?php echo $_GET['Destination'] ?>','<?php echo $_GET['AdultNumber'] ?>','<?php echo $_GET['ChildNumber'] ?>','<?php echo $_GET['InfantNumber'] ?>')<?php } else {
                       echo 'return false;';
                   } ?>">

            <span class="change-date-svg">
				<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129"
                     xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
					<g>
					<path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"/>
					</g>
				</svg>
			</span>
                    <span>روز قبل</span>
                </a>
                <a href="#" class="next-date" id="DateNext"
                   onclick="<?php if (empty($_GET['ReturnDate'])) { ?>SearchAgain('<?php echo functions::DateNext($_GET['DepartureDate']) ?>','<?php echo $_GET['Origin'] ?>','<?php echo $_GET['Destination'] ?>','<?php echo $_GET['AdultNumber'] ?>','<?php echo $_GET['ChildNumber'] ?>','<?php echo $_GET['InfantNumber'] ?>')<?php } else {
                       echo 'return false;';
                   } ?>">

                    <span>روز بعد</span>
                    <span class="change-date-svg">
		<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px"
             viewBox="0 0 477.175 477.175" style="enable-background:new 0 0 477.175 477.175;" xml:space="preserve">
			<g>
				<path d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225
					c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"/>
			</g>
		</svg>
		</span>
                </a>
            </div>
            <a href="#" class="filters popup-open" data-popup="#filters">
		<span>
			<svg class="site-bg-svg-color" height="394pt" viewBox="-5 0 394 394.00003" width="394pt"
                 xmlns="http://www.w3.org/2000/svg">
			<path d="m367.820312 0h-351.261718c-6.199219-.0117188-11.878906 3.449219-14.710938 8.960938-2.871094 5.585937-2.367187 12.3125 1.300782 17.414062l128.6875 181.285156c.042968.0625.089843.121094.132812.183594 4.675781 6.3125 7.207031 13.960938 7.21875 21.816406v147.800782c-.027344 4.375 1.691406 8.582031 4.773438 11.6875 3.085937 3.101562 7.28125 4.851562 11.65625 4.851562 2.222656-.003906 4.425781-.445312 6.480468-1.300781l72.3125-27.570313c6.476563-1.980468 10.777344-8.09375 10.777344-15.453125v-120.015625c.011719-7.855468 2.542969-15.503906 7.214844-21.816406.042968-.0625.089844-.121094.132812-.183594l128.691406-181.289062c3.667969-5.097656 4.171876-11.820313 1.300782-17.40625-2.828125-5.515625-8.511719-8.9765628-14.707032-8.964844zm0 0"/>
			</svg>
		</span>
                <span>فیلتر ها</span>

            </a>
        </div>


        <div class="popup" id="filters">
            <div class="view">
                <div class="page">
                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="title">فیلتر بلیط ها</div>
                            <div class="right">
                                <a href="#" class="link popup-close">بستن</a>
                            </div>
                        </div>
                    </div>
                    <div class="page-content">
                        <div class="block">
                            <div class="filter-item filter-price">
                                <span class="filter-item-head">قیمت (ریال)</span>
                                <div class="block-title display-flex justify-content-space-between">
					<span class="price-value">
						<span class="min-price-value">14,500,000 تومان</span>
						<span class="max-price-value">19,500,000 تومان</span>
					</span>
                                </div>
                                <div class="list simple-list">
                                    <ul>
                                        <li class="item-row">
                                            <div class="item-cell item-cell-shrink-3">
                                                <!-- Dual range slider with all the parameters passed via data- attributes -->
                                                <div
                                                        id="price-filter"
                                                        class="range-slider range-slider-init color-green"
                                                        data-label="true"
                                                        data-dual="true"
                                                        data-min="1450000"
                                                        data-max="1950000"
                                                        data-step="10000"
                                                        data-value-left="1450000"
                                                        data-value-right="1950000"
                                                ></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="filter-item filter-airline">
                                <span class="filter-item-head">ایرلاین</span>
                                <div class="list">
                                    <ul>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox" name="demo-checkbox" value="allairlines"
                                                       checked="checked"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">همه ایرلاین ها</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox" name="demo-checkbox" value="aseman"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">آسمان</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox" name="demo-checkbox" value="airtour"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">ایرتور</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox" name="demo-checkbox" value="taban"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">تابان</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox" name="demo-checkbox" value="mahan"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">ماهان</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox" name="demo-checkbox" value="zagros"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">زاگرس</div>
                                                </div>
                                            </label>
                                        </li>
                                    </ul>
                                    <div class="bottom-btn">
                                        <a href="#" class="link popup-close">اعمال فیلتر</a>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

