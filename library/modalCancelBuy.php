<?php

require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));


class modalCancelBuy
{

    public function __construct()
    {
        $methodName = $_POST['methodName'];
        self::$methodName();
    }

    public function showModalCancelBuy()
    {

        $typeApplication = $_POST['typeApplication'];
        $factorNumber = $_POST['factorNumber'];

        ?>
        <div class="modal-header site-bg-main-color">
            <div class="col-md-10">
                <h6 class="modal-h"><?php echo functions::Xmlinformation("Cancelpurchasebookingnumber")?> <?php echo $factorNumber; ?></h6>
            </div>
            <div class="col-md-2">
                <span class="close" onclick="modalClose()">×</span>
            </div>
        </div>

        <form method="post" name="cancelBuyForm" id="cancelBuyForm" enctype="multipart/form-data">

            <input type="hidden" name="flag" id="flag" value="flagRequestCancel">
            <input type="hidden" name="typeApplication" id="typeApplication" value="">
            <input type="hidden" name="factorNumber" id="factorNumber" value="">

            <div class="modal-body" style="overflow: initial;">
                <div class="modal-padding-bottom-15">

                    <?php if (functions::TypeUser(CLIENT_ID) == 'Ponline') { ?>
                        <div class="row">
                            <div class="col-md-12 modal-text-center modal-h ">
                                <label><?php echo functions::Xmlinformation("Pleaseenteryourinformationreturningmoneyyouraccount") ?></label>
                                
                                <?php if($typeApplication=='train'){?>
				<br/>
                                <label style="color: red"><?php echo functions::Xmlinformation('descriptionCancelTrain');?></label>
                                <?php } ?>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                                <label style="float:right;"><?php echo functions::Xmlinformation("Cardnumber") ?></label>
                                <input class="form-control " type="text" id="cardNumber" name="cardNumber"
                                       style="float: right;margin-right: 10px">
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                                <label style="float:right;"><?php echo functions::Xmlinformation("Namebankowner") ?></label>
                                <input class="form-control " type="text" id="accountOwner" name="accountOwner"
                                       style="float: right;margin-right: 10px">
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12 nopad  " style="direction: rtl;margin: 10px">
                                <label style="float:right;"><?php echo functions::Xmlinformation("Cardname") ?></label>
                                <input class="form-control " type="text" id="nameBank" name="nameBank"
                                       style="float: right;margin-right: 10px">
                            </div>
                        </div>
                    <?php } ?>


                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 lh45">
                        <textarea name="comment" id="comment"
                                  rows="2" cols="50" placeholder="دلیل درخواست کنسلی خود را وارد کنید..."
                                  class="form-control" style="float: right;margin-right: 5px;"></textarea>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 nopad">
                            <div class="col-md-1 col-lg-1 col-sm-12 col-xs-12 nopad">
                                <input class="form-control" type="checkbox" id="Ruls" name="Ruls" style="height: 40px">
                            </div>
                            <div class="col-md-11 col-lg-11 col-sm-12 col-xs-12 lh45">
                                <?php echo functions::Xmlinformation("Iam") ?> <a
                                        href="<?php echo URL_RULS ?>"
                                        style="margin-top: 5px" target="_blank"><?php echo functions::Xmlinformation("Seerules") ?></a>
                                <?php echo functions::Xmlinformation("IhavestudiedIhavenoobjection") ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>


        <div class="modal-footer site-bg-main-color">
            <div class="col-md-12 " style="text-align:left;">
                <input class="btn btn-primary btn-send-information"
                       onclick="requestCancelBuy('<?php echo $typeApplication; ?>', '<?php echo $factorNumber; ?>')"
                       type="button" value="<?php echo functions::Xmlinformation("Sendinformation") ?>">
            </div>
        </div>


        <?php

    }


    public function showModalConfirmCancelBuy()
    {

        $factor_number = $_POST['factor_number'];
        $typeRequest = $_POST['typeRequest'];
        $clientId = $_POST['clientId'];
        $typeApp = $_POST['type_app'];
        ?>
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header site-bg-main-color">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <?php
                    if ($typeRequest == 'Confirm') {
                        ?>
                        <h4 class="modal-title">تایید درخواست کنسلی</h4>
                        <?php
                    } elseif ($typeRequest == 'Reject') {
                        ?>
                        <h4 class="modal-title">رد درخواست کنسلی</h4>
                        <?php
                    }
                    ?>
                </div>
                <div class="modal-body">

                    <?php
                    if ($typeRequest == 'Confirm') {
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="cancelPercent">درصد کنسلی</label>
                                    <input type="text" name="cancelPercent" id="cancelPercent"
                                           class="form-control"
                                           placeholder="درصد کنسلی جریمه را وارد کنید...">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="cancelPrice">مبلغ جریمه</label>
                                    <input type="text" name="cancelPrice" id="cancelPrice"
                                           class="form-control"
                                           placeholder="مبلغ جریمه را وارد کنید...">
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>


                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="descriptionClient">توضیحات
                                    <small>(شما میتوانید توضیحات خود را در اینجا وارد نمائید)</small>
                                </label>
                                <textarea class="form-control" id="descriptionClient" name="descriptionClient"
                                          placeholder="متن توضیحات خود را وارد نمائید"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer site-bg-main-color">
                    <?php
                    if ($typeRequest == 'Confirm') {
                        ?>
                        <button type="button" class="btn btn-primary  pull-left"
                                onclick="setConfirmCancel('<?php echo $factor_number; ?>', '<?php echo $clientId; ?>','<?php echo $typeApp?>')">ثبت اطلاعات</button>
                        <?php
                    } elseif ($typeRequest == 'Reject') {
                        ?>
                        <button type="button" class="btn btn-primary  pull-left"
                                onclick="setRejectCancelRequest('<?php echo $factor_number; ?>', '<?php echo $clientId; ?>','<?php echo $typeApp?>')">ثبت اطلاعات</button>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
        <?php

    }


}

new modalCancelBuy();