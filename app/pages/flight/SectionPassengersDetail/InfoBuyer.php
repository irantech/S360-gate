<?php

 if ($ResultTicketDetail['dept']['SourceID'] == '8' || $ResultTicketDetail['return']['SourceID'] == '8' || $ResultTicketDetail['TowWay']['SourceID'] == '8') {

     if (isset($ResultTicketDetail['dept']['LinkCaptcha']) && !empty($ResultTicketDetail['dept']['LinkCaptcha'])) {
//            $captchaOneWay =$ResultTicketDetail['dept']['LinkCaptcha'];

         $img = file_get_contents($ResultTicketDetail['dept']['LinkCaptcha']);

// Encode the image string data into base64
         $captchaOneWay = base64_encode($img);
     }
     if (isset($ResultTicketDetail['return']['LinkCaptcha']) && !empty($ResultTicketDetail['return']['LinkCaptcha'])) {
         $imgReturn = file_get_contents($ResultTicketDetail['return']['LinkCaptcha']);
            $captchaReturn = base64_encode($imgReturn);
        }
?>

     <?php
        if(isset($ResultTicketDetail['return']['LinkCaptcha']) && isset($ResultTicketDetail['dept']['LinkCaptcha'])){
            ?>
            <div class="off-code">
                 <span>
                     <input type="text" id="CaptchaCode" name="CaptchaCode" class="form-control"  placeholder="کد امنیتی پرواز رفت  را وارد کنید">
                 </span>
                        <span style="padding: 10px;">
                    <img src="<?php echo 'data:image/png;base64,'.$captchaOneWay ?>" style="width: 100px;" id="ImageCaptcha">
                </span>
            </div>

            <div class="off-code">
                         <span>
                             <input type="text" id="CaptchaReturnCode" name="CaptchaReturnCode" class="form-control" placeholder="کد امنیتی پرواز برگشت  را وارد کنید">
                         </span>
                        <span style="padding: 10px;">
                             <img src="<?php echo 'data:image/png;base64,'.$captchaReturn ?>" style="width: 100px;" id="ImageCaptcha">
                </span>
            </div>
            <?php
        }else if(isset($ResultTicketDetail['dept']['LinkCaptcha'])){
            ?>
                <div class="off-code">
                     <span>
                         <input type="text" id="CaptchaCode" name="CaptchaCode" class="form-control"
                                placeholder="کد امنیتی پرواز  را وارد کنید">
                     </span>
                    <span style="padding: 10px;">
                        <img src="<?php echo 'data:image/png;base64,'.$captchaOneWay ?>" style="width: 100px;" id="ImageCaptcha">
                    </span>
                </div>
            <?php
        }
     ?>



<?php } ?>

<div class="buyer-info">
    <span>اطلاعات خریدار</span>
    <div class="list">
        <ul>
            <li class="item-content item-input">
                <div class="item-media">
                    <i class="buyer-mob-icon site-bg-main-color"></i>
                </div>
                <div class="item-inner">
                    <div class="item-title item-floating-label">تلفن همراه</div>
                    <div class="item-input-wrap">
                        <input type="text" name="Mobile_buyer" id="Mobile_buyer"
                               value="<?php echo $InfoMember['mobile'] ?>">
                        <span class="input-clear-button"></span>
                    </div>
                </div>
            </li>

            <!--            <li class="item-content item-input">-->
            <!--              <div class="item-media">-->
            <!--                <i class="buyer-phone-icon"></i>-->
            <!--              </div>-->
            <!--              <div class="item-inner">-->
            <!--                <div class="item-title item-floating-label">تلفن ثابت</div>-->
            <!--                <div class="item-input-wrap">-->
            <!--                  <input type="text">-->
            <!--                  <span class="input-clear-button"></span>-->
            <!--                </div>-->
            <!--              </div>-->
            <!--            </li>-->

            <li class="item-content item-input">
                <div class="item-media">
                    <i class="buyer-email-icon site-bg-main-color"></i>
                </div>
                <div class="item-inner">
                    <div class="item-title item-floating-label">ایمیل</div>
                    <div class="item-input-wrap">
                        <input type="text" name="Email_buyer" id="Email_buyer"
                               value="<?php echo $InfoMember['email'] ?>">
                        <span class="input-clear-button"></span>
                    </div>
                </div>
            </li>

        </ul>
    </div>

</div>