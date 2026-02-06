<?php

require '../../config/bootstrap.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php';
spl_autoload_register(array('Load', 'autoload'));


$MessagesController = Load::controller('messageClientOnline');

$Messages = $MessagesController->ListMessage();
?>


<div class="page" data-page="blit-info-1">

    <div class="page-content">
        <div class="nav-info site-bg-main-color">
            <div class="nav-info-inner">
                <div class="back-link">
                    <a href="#" class="link back">
                        <span></span>
                    </a>
                </div>
                <div class="title">پیام ها</div>
            </div>
        </div>
        <div class="blit-info-page">

            <?php

            if (!empty($Messages)) {
                foreach ($Messages as $message) {
                    ?>
                    <div class="card massage-item">
                        <div class="card-header">
                            <div class="massage-item-title"><?php echo $message['title'] ?></div>
                            <div class="massage-item-date">
                                <span class="massage-item-date-date"><?php echo dateTimeSetting::jdate("Y-m-d", $message['creationDateInt']) ?></span>
                                <span class="massage-item-date-time"><?php echo dateTimeSetting::jdate("H:i", $message['creationDateInt']) ?></span>
                            </div>
                        </div>
                        <div class="card-content card-content-padding" style="text-align: center">
                            <img src="<?php echo ROOT_ADDRESS_WITHOUT_LANG . '/pic/MessageClient/' . $message['image'] ?>"
                                 width="50%">
                        </div>
                        <div class="card-footer">
                            <div class="massage-item-content">
                                <?php echo $message['description'] ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-danger margin-left-right-9">
                    پیامی موجود نمی باشد
                </div>
            <?php
            } ?>


        </div>

    </div>
</div>
