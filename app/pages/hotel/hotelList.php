<?php
//error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));


$LogoAppAddress = FRONT_THEMES_DIR . FRONT_TEMPLATE_NAME . '/project_files/images/applogo.png';
$LogoApp = ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FRONT_TEMPLATE_NAME . '/project_files/images/applogo.png';
$LogoWeb = ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FRONT_TEMPLATE_NAME . '/project_files/images/logo.png';


$cityId = !empty($_GET['cityId']) ? $_GET['cityId'] : '';
$startDate = !empty($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = !empty($_GET['endDate']) ? $_GET['endDate'] : '';
$nights = !empty($_GET['nights']) ? $_GET['nights'] : '';

$objResultHotelLocal = Load::controller('resultHotelLocal');
$cityName = $objResultHotelLocal->getCity($cityId);
$arrayPrice = $objResultHotelLocal->getMinMaxPriceHotelByCityId($cityId, $startDate);
?>

<div class="page blit-search-page" id="page-blit">


    <input type="hidden" name="cityId" id="cityId" value="<?php echo $cityId; ?>">
    <input type="hidden" name="startDate" id="startDate" value="<?php echo $startDate; ?>">
    <input type="hidden" name="endDate" id="endDate" value="<?php echo $endDate; ?>">
    <input type="hidden" name="nights" id="nights" value="<?php echo $nights; ?>">

    <div class="page-content">
        <div class="nav-info site-bg-main-color hotel-result">
            <div class="nav-search-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title-result-hotel">هتل های شهر <?php echo $cityName; ?></div>
                <div class="title-result-hotel-date">از
                    <span><?php echo $startDate; ?></span>
                    تا
                    <span><?php echo $endDate; ?></span>
                    <span>( 3 شب )</span></div>

            </div>
        </div>
        <div class="hotel-resutlt-options">
            <div class="hotel-result-sorting" id="blit-hotel-sorting">
                <div class="svg-icon">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 460.088 460.088" style="enable-background:new 0 0 460.088 460.088;"
                         xml:space="preserve">
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
			</svg>
                </div>
                مرتب سازی
            </div>
            <div data-popup="#filters" class="hotel-result-filter popup-open">
                <div class="svg-icon">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         width="971.986px" height="971.986px" viewBox="0 0 971.986 971.986"
                         style="enable-background:new 0 0 971.986 971.986;"
                         xml:space="preserve">
					<g>
                        <path d="M370.216,459.3c10.2,11.1,15.8,25.6,15.8,40.6v442c0,26.601,32.1,40.101,51.1,21.4l123.3-141.3
					c16.5-19.8,25.6-29.601,25.6-49.2V500c0-15,5.7-29.5,15.8-40.601L955.615,75.5c26.5-28.8,6.101-75.5-33.1-75.5h-873
					c-39.2,0-59.7,46.6-33.1,75.5L370.216,459.3z"/>
                    </g>
				</svg>
                </div>
                فیلتر ها
            </div>
        </div>


        <div class="first-preloader site-bg-main-color">
            <div class="img-preloader">
                <img src="<?php echo file_exists($LogoAppAddress) ? $LogoApp : $LogoWeb; ?>" alt="">
                <div id="loader"></div>
                </br>
                </br>
                <h4>سیستم درحال جمع آوری تمامی هتل ها میباشد.</h4>
                </br>
                <h4>لطفا صبور باشید...</h4>
            </div>
        </div>

        <div class="hotel-result-items" id="resultHotelList"></div>


        <div class="popup" id="filters">
            <div class="view">
                <div class="page">
                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="title">فیلتر هتل ها</div>
                            <div class="right">
                                <a href="#" class="link popup-close">بستن</a>
                            </div>
                        </div>
                    </div>
                    <div class="page-content">
                        <div class="block">


                            <input type="hidden" id="minPriceWithoutComma" name="minPriceWithoutComma" value="<?php echo $arrayPrice['minPrice']; ?>">
                            <input type="hidden" id="maxPriceWithoutComma" name="maxPriceWithoutComma" value="<?php echo $arrayPrice['maxPrice']; ?>">
                            <input type="hidden" id="checkPrice" name="checkPrice" value="true">

                            <div class="filter-item filter-price">
                                <span class="filter-item-head">قیمت (ریال)</span>
                                <div class="block-title display-flex justify-content-space-between">
                                    <span class="price-value">
                                        <span class="min-price-value"><?php echo number_format($arrayPrice['minPrice']); ?> ریال</span>
                                        <span class="max-price-value"><?php echo number_format($arrayPrice['maxPrice']); ?> ریال</span>
                                    </span>
                                </div>
                                <div class="list simple-list">
                                    <ul>
                                        <li class="item-row">
                                            <div class="item-cell item-cell-shrink-3">
                                                <div
                                                        id="price-filter-hotel"
                                                        class="range-slider range-slider-init color-green"
                                                        data-label="true"
                                                        data-dual="true"
                                                        data-min="<?php echo $arrayPrice['minPrice']; ?>"
                                                        data-max="<?php echo $arrayPrice['maxPrice']; ?>"
                                                        data-step="10000"
                                                        data-value-left="<?php echo $arrayPrice['minPrice']; ?>"
                                                        data-value-right="<?php echo $arrayPrice['maxPrice']; ?>"
                                                ></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                            <div class="filter-item filter-airline">
                                <span class="filter-item-head">نمایش هتل های</span>
                                <div class="list">
                                    <ul>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox"
                                                       name="hotel-star-checkbox_all"
                                                       id="hotel-star-checkbox_all"
                                                       value="all"
                                                       class="hotelStarCheckboxAll"
                                                       checked="checked"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">همه</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox"
                                                       name="hotel-star-checkbox_5"
                                                       id="hotel-star-checkbox_5"
                                                       value="5"
                                                       class="hotelStarCheckbox"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">5 ستاره</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox"
                                                       name="hotel-star-checkbox_4"
                                                       id="hotel-star-checkbox_4"
                                                       value="4"
                                                       class="hotelStarCheckbox"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">4 ستاره</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox"
                                                       name="hotel-star-checkbox_3"
                                                       id="hotel-star-checkbox_3"
                                                       value="3"
                                                       class="hotelStarCheckbox"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">3 ستاره</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox"
                                                       name="hotel-star-checkbox_2"
                                                       id="hotel-star-checkbox_2"
                                                       value="2"
                                                       class="hotelStarCheckbox"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">2 ستاره</div>
                                                </div>
                                            </label>
                                        </li>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox"
                                                       name="hotel-star-checkbox_1"
                                                       id="hotel-star-checkbox_1"
                                                       value="1"
                                                       class="hotelStarCheckbox"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">1 ستاره</div>
                                                </div>
                                            </label>
                                        </li>
                                    </ul>

                                </div>
                            </div>


                            <div class="filter-item filter-airline">
                                <span class="filter-item-head">نوع اقامتگاه</span>
                                <div class="list">
                                    <ul>
                                        <li>
                                            <label class="item-checkbox item-content">
                                                <input type="checkbox" name="hotel-type-checkbox_all"
                                                       id="hotel-type-checkbox_all" value="allTypeHotel"
                                                       class="hotelTypeCheckboxAll"
                                                       checked="checked"/>
                                                <i class="icon icon-checkbox"></i>
                                                <div class="item-inner">
                                                    <div class="item-title">همه</div>
                                                </div>
                                            </label>
                                        </li>
                                        <?php
                                        $objResultHotelLocal->AllHotelType();
                                        foreach ($objResultHotelLocal->All_HotelType as $hotelType) {
                                            ?>
                                            <li>
                                                <label class="item-checkbox item-content">
                                                    <input type="checkbox"
                                                           name="hotel-type-checkbox_<?php echo $hotelType['Code']; ?>"
                                                           id="hotel-type-checkbox_<?php echo $hotelType['Code']; ?>"
                                                           value="<?php echo $hotelType['Code']; ?>"
                                                           class="hotelTypeCheckbox"/>
                                                    <i class="icon icon-checkbox"></i>
                                                    <div class="item-inner">
                                                        <div class="item-title"><?php echo $hotelType['Name']; ?></div>
                                                    </div>
                                                </label>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>


                                    <div class="bottom-btn">
                                        <a class="site-bg-main-color link popup-close setFilterHotel">اعمال فیلتر</a>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

