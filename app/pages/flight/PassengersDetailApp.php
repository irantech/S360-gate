<?php
error_reporting(0);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');


require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require LIBRARY_DIR . 'Jalali.php';


$TicketDetail = Load::controller('TicketDetailApp');
$FlightZone = $_GET['TypeZoneFlight'] == 'Local' ? "Local" : "Foreign";
$ResultTicketDetail = $TicketDetail->ShowTicketDetailApp($_GET['Uniq_id'], $FlightZone);



//echo Load::plog($ResultTicketDetail);

$AdultCount = isset($ResultTicketDetail['dept']) ? $ResultTicketDetail['dept']['Adt_qty'] : $ResultTicketDetail['TwoWay']['Adt_qty'];
$ChildCount = isset($ResultTicketDetail['dept']) ? $ResultTicketDetail['dept']['Chd_qty'] : $ResultTicketDetail['TwoWay']['Chd_qty'];
$InfantCount = isset($ResultTicketDetail['dept']) ? $ResultTicketDetail['dept']['Inf_qty'] : $ResultTicketDetail['TwoWay']['Inf_qty'];

if(isset($ResultTicketDetail['dept']))
{
    $SourceID['dept']= $ResultTicketDetail['dept']['SourceID'];
}

if(isset($ResultTicketDetail['return']))
{
    $SourceID['return']= $ResultTicketDetail['return']['SourceID'];
}

if(isset($ResultTicketDetail['TwoWay']))
{
    $SourceID['TwoWay']= $ResultTicketDetail['TwoWay']['SourceID'];
}
$InfoMember = functions::infoMember(Session::getUserId());
$PassportCountry=functions::CountryCodes()

?>

<div class="page" data-page="blit-info-1">

    <input type="hidden" name="Uniq_id" id="Uniq_id"
           value="<?php echo !empty($_GET['Uniq_id']) ? $_GET['Uniq_id'] : '' ?>">
    <input type="hidden" name="TypeZoneFlightDetail" id="TypeZoneFlightDetail"
           value="<?php echo !empty($FlightZone) ? $FlightZone : '' ?>">
    <input type="hidden" name="AdultCount" id="AdultCount"
           value="<?php echo $AdultCount ?>">
    <input type="hidden" name="ChildCount" id="ChildCount"
           value="<?php echo $ChildCount ?>">
    <input type="hidden" name="InfantCount" id="InfantCount"
           value="<?php echo $InfantCount ?>">
    <input type="hidden" name="CurrentTime" id="CurrentTime"
           value="<?php echo time() ?>">
    <input type="hidden" name="SelectPassenger" id="SelectPassenger">
    <input type="hidden" name="SourceID" id="SourceID" value='<?php echo json_encode($SourceID)?>'>



    <div class="page-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="/" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">ورود مشخصات</div>
            </div>
        </div>
        <div class="blit-info-page">

            <?php
            include 'SectionPassengersDetail/TopDetail.php';
            ?>


            <form class="list" id="my-form">
                <div class="passenger-info">
                    <div class="accordion-list custom-accordion">
                        <input type="hidden" name="IdMember" id="IdMember" value="<?php echo Session::getUserId() ?>">
                        <input type="hidden" value="" name="RequestNumber_dept" id="RequestNumber_dept">
                        <input type="hidden" value="" name="RequestNumber_return" id="RequestNumber_return">
                        <input type="hidden" value="" name="RequestNumber_TwoWay" id="RequestNumber_TwoWay">

                        <?php
                        include 'SectionPassengersDetail/AdultPassengers.php';
                        ?>

                        <?php
                        include 'SectionPassengersDetail/ChildPassengers.php';
                        ?>


                        <?php
                        include 'SectionPassengersDetail/InfantPassengers.php';
                        ?>


        </div>
    </div>

<?php
    include 'SectionPassengersDetail/InfoBuyer.php';
?>
    </form>
    <div class="bottom-btn">
        <a href="#" class="bot-btn site-bg-main-color GoToFactorLocalApp">
            <span>ادامه</span>
            <i class="preloader color-white myhidden"></i>
        </a>
    </div>

</div>

            <?php include 'SectionPassengersDetail/DetailTicketPassengers.php'?>

        <div class="popup popup-passenger-lists">
            <div class="navbar">
                <div class="navbar-inner sliding">
                    <div class="title">لیست مسافران</div>
                    <a class="link popup-close" href="#">بستن</a>
                    <div class="subnavbar">
                        <form data-search-container=".virtual-list" data-search-item="li" data-search-in=".item-title"
                              class="searchbar searchbar-init">
                            <div class="searchbar-inner">
                                <div class="searchbar-input-wrap">
                                    <input type="search" placeholder="مسافر مورد نظر را جستوجو کنید"/>
                                    <i class="searchbar-icon"></i>
                                    <span class="input-clear-button"></span>
                                </div>
                                <span class="searchbar-disable-button if-not-aurora">لغو</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="searchbar-backdrop"></div>
            <div class="page-content">
                <div class="list simple-list searchbar-not-found">
                    <ul>
                        <li>چیزی پیدا نشد</li>
                    </ul>
                </div>
                <div class="list virtual-list media-list searchbar-found"></div>
            </div>
        </div>




</div>
</div>
