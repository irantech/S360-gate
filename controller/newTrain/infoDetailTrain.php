<div class="international-available-details">
    <div>
        <div class=" international-available-panel-min">
            <ul class="tabs">
                <li class="tab-link current site-border-top-main-color"
                    data-tab="tab-1-<?php echo $key ?>"><?php echo functions::Xmlinformation('InfoTicket') ?>
                </li>

                <li class="tab-link site-border-top-main-color"
                    data-tab="tab-2-<?php echo $key ?>"><?php echo functions::Xmlinformation('TermsandConditions') ?>
                </li>
            </ul>

            <div id="tab-1-<?php echo $key ?>"
                 class="tab-content current">
                <div class="international-available-airlines-detail-tittle">
                    <span class="iranB  lh25 displayb txtRight">
                        <i class="fa fa-circle site-main-text-color "></i><?php echo functions::Xmlinformation('Startfrom') ?>
                        <?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['DepartureCity'] : $params['ArrivalCity'] ?>
                        <?php echo functions::Xmlinformation('Toto') ?>
                        <?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['ArrivalCity'] : $params['DepartureCity'] ?>
                    </span>

                    <div class=" international-available-airlines-detail  site-border-right-main-color">

                        <div class="international-available-airlines-logo-detail">
                            <img height="50" width="50"
                                 src="<?php echo functions::getCompanyTrainPhoto($ticketTrain['Owner']) ?>"
                                 alt="<?php echo functions::getCompanyTrainPhoto($ticketTrain['Owner']) ?>"
                                 title="<?php echo functions::getCompanyTrainPhoto($ticketTrain['Owner']) ?>">
                        </div>

                        <div class="international-available-airlines-info-detail my-info-detail">
                            <span class="iranL txt15 displayib"
                                  style="margin-left: 10px;"><?php echo functions::Xmlinformation('facilities') ?>
                                :  </span>
                            <div class="row">
                                <?php if ($ticketTrain['AirConditioning'] == true) { ?>
                                    <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pic/fan.png' ?>" title="تهویه"
                                         style="margin-left: 10px">
                                <?php } ?>
                                <?php if ($ticketTrain['Media'] == true) { ?>
                                    <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pic/tv.png' ?>"
                                         title="صوت و تصویر">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="international-available-airlines-detail site-border-right-main-color">
                        <div class="airlines-detail-box train-detail-box col-md-4 col-sm-12">

                                                <span class="padt0 iranb lh18 displayb"><?php echo functions::Xmlinformation('Passengercompany') ?>
                                                    : <i
                                                            class="iranNum"><?php echo functions::getCompanyTrainById($ticketTrain['Owner']) ?></i> </span>
                            <span class="padt0 iranL lh18 displayb">
                                                           <?php echo functions::Xmlinformation('Allseat') ?>:
                                                             <i class=""> <?php echo $ticketTrain['CountingAll'] ?></i> </span>
                            <span class="padt0 iranL  lh18 displayb">

                            تعداد صندلی های باقی مانده: <i class=""><?php echo $ticketTrain['Counting'] ?></i> </span>

                        </div>

                        <div class="airlines-detail-box train-detail-box col-md-4 col-sm-12">

                            <span class="iranB txt15 displayb"><?php echo $ticketTrain['ExitTime'] ?></span>&nbsp;
                            <span class="iranL displayb"><?php echo $this->DateJalaliRequest ?></span>&nbsp;
                            <span class="iranL displayb"><?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['DepartureCity'] : $params['ArrivalCity'] ?></span>

                        </div>

                        <div class="airlines-detail-box train-detail-box col-md-4 col-sm-12">
                            <span class="iranB txt15 displayb"><?php echo $ticketTrain['TimeOfArrival'] ?></span>&nbsp;
                            <span class="iranL displayb"><?php echo $this->DateJalaliRequest ?></span>&nbsp;
                            <span class="iranL displayb"><?php echo ($ticketTrain['TypeRoute'] == 'dept') ? $params['ArrivalCity'] : $params['DepartureCity'] ?></span>
                        </div>
                        <h5 class="titr_service_train"">نوع خدمات</h5>

                        <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pic/spinner.gif' ?>"
                             class="loaderSearchTrain"
                             id="loaderSearch<?php echo $key ?>"
                             name="loaderSearch">
                        <div class="airlines-detail-box train-detail-box train-services-box"
                             style="width: 100%;display: flex;flex-wrap: wrap;" id="extera_service_<?php echo $key ?>">

                        </div>

                    </div>

                </div>
            </div>

            <div id="tab-2-<?php echo $key ?>" class="tab-content">
                <div class="iranL  lh25 displayb">
                    <?php echo ($ticketTrain['Hint']) ? "<div class='alert alert-warning'>{$ticketTrain['Hint']}</div>" : '' ?>
                    <ul>
                        <li>1. حضور در ایستگاه یک ساعت قبل از حرکت الزامی است. ده دقیقه قبل از حرکت قطار از ورود شما به
                            قطار
                            جاوگیری خواهد شد
                        </li>
                        <li>2. همراه داشتن بلیت یا کارت قطار و کارت شناسایی معتبر تا انتهای سفر الزامی است.درصورت
                            غیرهمنام
                            بودن بلیت،از سوار شدن مسافر به قطار جلوگیری می گردد
                        </li>
                        <li>3. خانواده معظم شهدا و جانبازان عزیز(با درصد جانبازی بیش از 25)در صورت ارائه کارت بنیاد شهید
                            و
                            امور ایثارگران و همراه جانباز در صورت داشتن مجوز همراهی و همچنین مسافران 2 الی 12 سال،مشول
                            50%
                            تخفیف می شوند و کودکان زیر 2 سال نیز در صورت درخواست جا با ارائه شناسنامه،مشمول 50% تخفیف می
                            شوند.درصورت همراه نداشتن کارت بنیاد شهید و امور ایثارگران و یا عدم حضور مسافر مشمول تخفیف در
                            قطار،مبلغ مابه التفاوت در هنگام کنترل بلیت توسط رئیس قطار اخذ خواهد شد.
                        </li>
                        <li>4. طبق مقررات،تا یک ساعت پس از صدور بلیت به شرط عدم حرکت قطار و مراجعه به آژانس
                            صادرکننده،بلیت
                            با پرداخت 100% بهای آن قابل استرداد می باشد.درصورت استرداد تا ساعت 12:00 روز قبل از حرکت
                            ،90% کل
                            بهای بلیت و تا 3 ساعت مانده به حرکت قطار،70% کل بهای بلیت و تا لحظه حرکت قطار،50% کل بهای
                            بلیت
                            به مسافر پرداخت می شود.بعد از زمان حرکت درج شده و روی بلیت،بلیت قابل استرداد نمی باشد.همراه
                            داشتن کارت شناسایی معتبر به هنگام استرداد بلیت الزامی است.
                        </li>
                        <li>5. سامانه اطلاع رسانی و پاسخگویی به شکایات معاونت مسافری راه آهن ج.ا.ا 5149- 021 برای کلیه
                            قطارهای مسافری و همچنین سامانه 300004609 و نیز 12-44281610- 021 جهت شرکت جوپار آماده
                            پاسخگویی می
                            باشد.
                        </li>
                        <li>6. استعمال دخانیات در قطار ممنوع می باشد.جهت اطلاع از شرایط سفر با قطار و سایر قوانین و
                            مقررات
                            به سایت www.rai.ir مراجعه نمایید
                        </li>
                        <li style="color:red;">7.بلیطهای چارتری غیرقابل استرداد بوده و هیچ هزینه ای بابت استرداد این
                            بلیطها عودت نخواهد شد
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <span class="international-available-detail-btn slideDownHotelDescription">

        <?php
        /*if((isset($_SERVER["HTTP_HOST"]) && strpos($_SERVER["HTTP_HOST"],'indobare.com') !== false) ) {//local
            echo Load::plog($ticketTrain);
        }*/
        if (Session::IsLogin()) {
            /** @var TYPE_NAME $ticketTrain ['isSpecific'] */

            $counterId = functions::getCounterTypeId($_SESSION['userId']);
            $idCompany = functions::getIdCompanyTrainByCode($ticketTrain['Owner']);


            $param['service'] = $discountType;
            $param['baseCompany'] = $idCompany;
            $param['company'] = $ticketTrain['TrainNumber'];
            $param['counterId'] = $counterId;

            /** @var TYPE_NAME $discount */
            $param['price'] = ($ticketTrain['Cost'] - $discount);
//            if($discount != 0 ){
//                $param['price'] = ($ticketTrain['Cost'] - $discount);
//            }else{
//                $param['price'] = $ticketTrain['Cost'];
//            }

            $pointClub = functions::CalculatePoint($param);
            $priceClub = functions::CalculatePricePoint($param);
            if ($pointClub > 0) {
                ?>
                <div class="text_div_morei site-main-text-color iranM ">
                    <?php echo functions::StrReplaceInXml(['@@point@@' => $pointClub, '@@price@@' => $priceClub], 'textPointTrain') ?>
                </div>
                <?php
            }
        }
        ?>

        <div class="my-more-info-train "
             onclick="display_more_info_train($(this),<?php echo $key ?>)"
             data-unique-id='<?php echo $ticketTrain['UniqueId'] ?>'> <?php echo functions::Xmlinformation('Moredetail') ?>
            <i class="fa fa-angle-down"></i></div></span>
    <input type="hidden" name="SCP<?php echo $key ?>" id="SCP<?php echo $key ?>"
           value="<?php echo $ticketTrain['CircularPeriod'] ?>">
    <input type="hidden" name="TrainNO<?php echo $key ?>" id="TrainNO<?php echo $key ?>"
           value="<?php echo $ticketTrain['TrainNumber'] ?>">
    <input type="hidden" name="Scps<?php echo $key ?>" id="Scps<?php echo $key ?>"
           value="<?php echo $ticketTrain['CircularNumberSerial'] ?>">
    <input type="hidden" name="WagonTypeCode<?php echo $key ?>" id="WagonTypeCode<?php echo $key ?>"
           value="<?php echo $ticketTrain['WagonType'] ?>">
    <input type="hidden" name="MovDateTrain<?php echo $key ?>" id="MovDateTrain<?php echo $key ?>"
           value="<?php echo $ticketTrain['MoveDate'] ?>">
    <input type="hidden" name="MovTimeTrain<?php echo $key ?>" id="MovTimeTrain<?php echo $key ?>"
           value="<?php echo $ticketTrain['ExitTime'] ?>">
    <input type="hidden" name="serviceSessionId<?php echo $key ?>" id="serviceSessionId<?php echo $key ?>"
           value="<?php echo $ticketTrain['serviceSessionId'] ?>">

    <span class="international-available-detail-btn  slideUpHotelDescription displayiN"><i
                class="fa fa-angle-up site-main-text-color"></i></span>
</div>