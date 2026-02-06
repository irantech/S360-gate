<?php
require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));


$RequestNumber = filter_var($_GET['RequestNumber'], FILTER_SANITIZE_STRING);
$user = Load::controller('user');
$InfoCancelTicket = $user->InfoModalTicketCancel($RequestNumber);
?>
<div class="page" data-page="ruls">

    <div class="page-content">
        <div class="nav-info">
            <div class="nav-info-inner site-bg-main-color">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">کنسل کردن بلیط</div>
            </div>
        </div>
        <div class="blank-page">
            <div class="blit-cancel">
                <div class="blit-cancel-title">
                    <span>کنسل کردن خرید به شماره رزرو</span>
                    <span><?php echo $RequestNumber ?></span>
                </div>

                <div class="list media-list blit-cancel-choose-pasenger">
                    <span class="title-blit-cancel-choose-pasenger">لطفا مسافر مورد نظر را انتخاب کنید</span>
                    <ul>
                        <?php
                        foreach ($InfoCancelTicket as $i => $info) {
                            $NationalCodeUser = $info['NationalCode'];
                            ?>
                            <input type="hidden" value="<?php echo $info['factor_number'] ?>" name="FactorNumber"
                                   id="FactorNumber"/>
                            <input type="hidden" value="<?php echo $info['member_id'] ?>" name="MemberId"
                                   id="MemberId"/>
                            <li>
                                <label class="item-checkbox item-content">
                                    <input type="checkbox" name="SelectUser[]" id="SelectUser" class="SelectUser"

                                           <?php echo (!empty($info['Status']) && !empty($NationalCodeUser) && $info['Status'] != 'SetCancelClient') ? 'disabled ="disabled"' : ''; ?>

                                           value="<?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] . '-' . $info['passenger_age'] : $info['passportNumber'] . '-' . $info['passenger_age'] ?>"/>
                                    <i class="icon icon-checkbox"></i>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title"><?php echo $info['passenger_name'] . ' ' . $info['passenger_family']; ?></div>
                                            <div class="item-after"><?php
                                                switch ($info['passenger_age']) {

                                                    case 'Adt':
                                                        echo 'بزرگسال';
                                                        break;

                                                    case 'Chd':
                                                        echo 'کودک';
                                                        break;

                                                    case 'Inf':
                                                        echo 'نوزاد';
                                                        break;
                                                }
                                                ?></div>
                                        </div>
                                        <div class="item-subtitle"><span>شماره پاسپورت / کد ملی :</span> <span><?php echo ($info['passenger_national_code'] != '0000000000') ? $info['passenger_national_code'] : $info['passportNumber'] ?></span></div>
                                        <div class="item-subtitle"><span>تاریخ تولد :</span> <span><?php echo (!empty($info['passenger_birthday'])) ? $info['passenger_birthday'] : $info['passenger_birthday_en'] ?></span></div>

                                        <?php
                                        if (!empty($info['Status']) && !empty($NationalCodeUser) && $info['Status'] != 'nothing') {
                                            if ($info['Status'] == 'SetCancelClient') {
                                                ?>
                                                <div class="item-subtitle"><div class=" button   button-fill">رد درخواست شده است</div></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="item-subtitle "><div class=" button  button-fill">قبلا اقدام شده است</div></div>

                                                <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </label>
                            </li>
                        <?php } ?>

                    </ul>
                </div>

                <?php
                if (functions::TypeUser(CLIENT_ID) == 'Ponline') {
                    ?>
                    <div class="list no-hairlines-md blit-cancel-choose-bank">
                        <span class="title-blit-cancel-choose-bank">لطفا اطلاعات حساب بانکی خود را وارد کنید</span>
                        <ul>
                            <li class="item-content item-input">
                                <div class="item-inner">
                                    <div class="item-title item-label">شماره کارت بانکی</div>
                                    <div class="item-input-wrap">
                                        <input type="text" placeholder="xxxx xxxx xxxx xxxx"  id="CardNumber" name="CardNumber">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="item-content item-input">
                                <div class="item-inner">
                                    <div class="item-title item-label">نام صاحب حساب</div>
                                    <div class="item-input-wrap">
                                        <input type="text" placeholder="مانند علی قلی پور" id="AccountOwner" name="AccountOwner">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>
                            <li class="item-content item-input">
                                <div class="item-inner">
                                    <div class="item-title item-label">نام بانک کارت</div>
                                    <div class="item-input-wrap">
                                        <input type="text" placeholder="مانند بانک ملت" id="NameBank" name="NameBank">
                                        <span class="input-clear-button"></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

<!--                <div class="blit-price-cancel blit-price-cancel-page">-->
<!--                    <span class="blit-price-detail-title">جزئیات نرخ کنسلی بلیط</span>-->
<!--                    <div>-->
<!--                        <span> کلاس پروازی <span> Y </span> </span>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <span>تا 12 ظهر 3 روز قبل از پرواز</span>-->
<!--                        <span>20% جریمه</span>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <span>تا 12 ظهر 1 روز قبل از پرواز</span>-->
<!--                        <span>20% جریمه</span>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <span>تا 3 ساعت قبل از پرواز</span>-->
<!--                        <span>20% جریمه</span>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <span>تا 30 دقیقه قبل از پرواز</span>-->
<!--                        <span>20% جریمه</span>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <span>از 30 دقیقه قبل پرواز به بعد</span>-->
<!--                        <span>20% جریمه</span>-->
<!--                    </div>-->
<!--                </div>-->




                <div class="list no-hairlines-md cancel-page-bottom">
                    <ul>
                        <li class="item-content item-input">
                            <div class="item-media">
                                <i class="icon demo-list-icon"></i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">دلیل کنسلی را انتخاب کنید</div>
                                <div class="item-input-wrap input-dropdown-wrap">
                                    <select  name="ReasonUser" onchange="SelectReason(this)"   id="ReasonUser">
                                        <option value=""> دلیل کنسلی را انتخاب کنید...</option>
                                        <option value="PersonalReason">کنسلی به دلایل شخصی</option>
                                        <option value="DelayTwoHours">تاخیر بیش از 2 ساعت</option>
                                        <option value="CancelByAirline">لغو پررواز توسط ایرلاین</option>
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <label class="item-checkbox item-content">
                                <input type="checkbox"  value="" id="PercentNoMatter" name="PercentNoMatter""/>
                                <i class="icon icon-checkbox"></i>
                                <div class="item-inner">
                                    <div class="item-title">برای من درصد جریمه اهمیتی ندارد ،لطفا سریعا کنسل گردد</div>
                                </div>
                            </label>
                        </li>
                        <li>
                            <label class="item-checkbox item-content">
                                <input type="checkbox" id="Ruls" name="Ruls" />
                                <i class="icon icon-checkbox"></i>
                                <div class="item-inner">
                                    <div class="item-title">قوانین را مطالعه کرده ام و اعتراضی ندارم</div>
                                </div>
                            </label>
                        </li>

                    </ul>
                </div>

                
             <a href="#" class="button button-fill site-bg-main-color cancel-btn SendInfoCancel" onclick="SelectUser('<?php echo $RequestNumber ?>')">
                          <span> ارسال اطلاعات</span>
                        <i class="preloader color-white myhidden"></i>
                    </a>

            </div>


        </div>
    </div>
</div>
