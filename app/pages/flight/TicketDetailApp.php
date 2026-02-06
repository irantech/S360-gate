<?php
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';

$TypeZoneFlight = ($_GET['TypeZoneFlight']=='Local') ? "Local" : "Foreign" ;

$TicketDetail = Load::controller('TicketDetailApp');
$ResultTicketDetail = $TicketDetail->ShowTicketDetailApp($_GET['Uniq_id'],$TypeZoneFlight);



?>
<div class="page">
  <div class="page-content">
    <div class="nav-search site-bg-main-color-before">
    <div class="nav-search-inner">
      <div class="back-link">
        <a href="#" class="link back">
			<span></span>
        </a>
      </div>
      <div class="title">جزییات بلیط انتخاب شده</div>
    </div>
    </div>
    <div class="blit-detail">

        <input type="hidden"  name="Uniq_id" id="Uniq_id" value="<?php echo !empty($_GET['Uniq_id']) ? $_GET['Uniq_id'] : '' ?>">
        <input type="hidden"  name="TypeZoneFlight" id="TypeZoneFlight" value="<?php echo !empty($_GET['TypeZoneFlight'])? $_GET['TypeZoneFlight'] : '' ?>">
        <input type="hidden"  name="SourceId" id="SourceId" value="<?php echo !empty($_GET['SourceId'])? $_GET['SourceId'] : '' ?>">

        <div class="toolbar tabbar">
                <div class="toolbar-inner">
                    <a href="#tab-1" class="tab-link tab-link-active blit-choose-css-reset">اطلاعات پرواز</a>
                    <a href="#tab-2" class="tab-link">جزئیات قیمت</a>
                    <a href="#tab-3" class="tab-link">قوانین و مقررات</a>
                </div>
            </div>
            <div class="tabs-animated-wrap">
                <div class="tabs">
                    <div id="tab-1" class="page-content tab tab-active">


                            <div class="blit-detail-info-flight-div">
                                <div class="block">
                                <?php include 'SectionDetailFlight/SectionInfoFlight.php' ?>
                                <div class="blit-detail-choose-blit-div">
                                    <a href="#" class="blit-detail-choose-blit site-bg-main-color GoToPassengersDetailApp" >
                                        <span>رزرو بلیط</span>
                                        <i class="preloader color-white myhidden"></i>
                                    </a>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div id="tab-2" class="page-content tab">
                        <div class="block">

                            <?php include 'SectionDetailFlight/SectionInfoPrice.php' ?>
                        </div>
                    </div>
                    <div id="tab-3" class="page-content tab">
                        <div class="block">
                            <p>حضور مسافر حداقل یک ساعت و نیم قبل از زمان پرواز در فرودگاه الزامی است. همراه داشتن مدرک شناسایی معتبر جهت سوارشدن به هواپیما الزامی است. اطلاع رسانی تاخیر، تعجیل و کنسلی پرواز از طریق شماره تلفن همراه درج شده کاربر صورت می پذیرد. بلیط های صادر شده به نام مسافرین بوده و غیر قابل انتقال به غیر و غیر قابل اصلاح نام مسافر می باشد. در صورت ابطال یا تاخیر بیش از ۲ ساعت پرواز، مسافر باید اصل بلیط مهر شده توسط ایستگاه شرکت هواپیمایی در فرودگاه را ارسال نماید. احتمال تغییر پروازهای چارتری ، بیشتر از سیستمی است و در برخی مواقع ممکن است پرواز لغو گردد که در این مواقع وجه از چارتر کننده دریافت و به شما عودت داده می شود. مبلغ جریمه کنسل کردن پروازهای سیستمی طبق قوانین شرکت های هواپیمایی و پروازهای چارتری طبق قوانین چارتر کنندگان می باشد که مسافر اعلام می گردد. درصورتی که مسافر بخواهد بلیط دو پرواز متوالی را تهیه نماید، بایسـتی حداقل ۳ ساعت بین رسیدن پـرواز اول به مقصد و حرکت پرواز دوم فاصـله باشد. در غیر این صورت مسئولیت کنسل شدن بلیط دوم با مسافر می‌باشد. لازم به ذکر است که اگر پرواز رفت و برگشت از دو ایرلاین مختلف باشند، در صورت لغو پرواز رفت یا انصراف مسافر از پرواز به دلیل تاخیر بیش از دو ساعت، ممکن است لغو پرواز برگشت شامل جریمه‌ی کنسلی شود بر اساس قوانین موجود، صدور بلیط در مسـیرهای عتبات عالیات برای اتباع کشورهای افغانسـتان، هند، بنـگلادش و پاکستان مقدور نیست و درصورت خرید بلیط توسط این افراد، تمام مسئولیت‌های بعدی، بر عهده‌ی خودِ کاربر خواهد بود. مسئولیت کنترل ویزای کشور مقصد و ویزای ترانزیت بعهده مسافر است. در صورت نیاز به کسب اطلاعات بیشتر با ما تماس حاصل فرمایید. در صورت بروز هرگونه مشکل با بخش پشتیبانی ما تماس بگیرید. </p>
                        </div>
                    </div>
                </div>
            </div>


</div>
