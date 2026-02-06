<?php
require '../../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));
$RequestNumber = filter_var($_GET['RequestNumberPdf'], FILTER_SANITIZE_STRING);
$FlightInfo = functions::info_flight_client($RequestNumber);

if ($FlightInfo[0]['IsInternal'] == '1') {
    $targetPdfTicket = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=parvazBookingLocal&id=" .$RequestNumber;
} else if ($FlightInfo[0]['IsInternal'] == '0') {
    $targetPdfTicket = ROOT_ADDRESS_WITHOUT_LANG . "/pdf&target=ticketForeign&id=" .$RequestNumber;
}
?>

<div class="page" data-page="PdfViewer">

    <div class="page-content">
        <div class="nav-info">
            <div class="nav-info-inner site-bg-main-color">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">مشاهده بلیط</div>
            </div>
        </div>
        <div class="blank-page">
            <object data=" <?php echo $targetPdfTicket?>" height="100%" type="application/pdf" width="100%"></object>

        </div>
    </div>
</div>
