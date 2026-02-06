<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));
/**
 * Class ModalIncreaseAccountBalance
 * @property ModalIncreaseAccountBalance $ModalIncreaseAccountBalance
 */
class ModalIncreaseAccountBalance
{
  public $Method;
  public $id;

  public function __construct()
  {
    $Method = $_POST['Method'];
    $member_id = $_POST['member_id'];
    self::$Method($member_id);
  }

  public function ModalShow($member_id)
  {

    /** @var bankList $bank_list_controller */
    $bank_list_controller = Load::controller('bankList');
    $banks = $bank_list_controller->getListActiveBank();

    ?>

    <div class="modal_custom" onclick="closeModalParent(event)">
      <div class="container col-lg-4">
        <div class="main_modal_custom">
          <div class="header_modal_custom w-100">
            <h2>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 256c70.7 0 128-57.31 128-128S294.7 0 224 0C153.3 0 96 57.31 96 128S153.3 256 224 256zM224 48c44.11 0 80 35.89 80 80c0 44.11-35.89 80-80 80C179.9 208 144 172.1 144 128C144 83.89 179.9 48 224 48zM274.7 304H173.3C77.61 304 0 381.6 0 477.3C0 496.5 15.52 512 34.66 512h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304zM48.71 464C55.38 401.1 108.7 352 173.3 352H274.7c64.61 0 117.1 49.13 124.6 112H48.71zM616 200h-48v-48C568 138.8 557.3 128 544 128s-24 10.75-24 24v48h-48C458.8 200 448 210.8 448 224s10.75 24 24 24h48v48C520 309.3 530.8 320 544 320s24-10.75 24-24v-48h48C629.3 248 640 237.3 640 224S629.3 200 616 200z"/></svg>
              افزایش موجودی
            </h2>
            <button onclick="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M312.1 375c9.369 9.369 9.369 24.57 0 33.94s-24.57 9.369-33.94 0L160 289.9l-119 119c-9.369 9.369-24.57 9.369-33.94 0s-9.369-24.57 0-33.94L126.1 256L7.027 136.1c-9.369-9.369-9.369-24.57 0-33.94s24.57-9.369 33.94 0L160 222.1l119-119c9.369-9.369 24.57-9.369 33.94 0s9.369 24.57 0 33.94L193.9 256L312.1 375z"/></svg></button>
          </div>
          <div class="w-100">
            <div class="reportCreditAgency__bank_style-new">
                <?php $counterBank = 0; ?>
              <?php foreach($banks as $bank){?>
                <label class="reportCreditAgency__custom-radio">
                  <input <?php if ($counterBank == 0){?> checked <?php } ?> type="radio" value="<?php echo $bank['bank_dir']; ?>" name="bank_to_pay">
                  <span class="reportCreditAgency__radio-btn">
                              <svg class="reportCreditAgency__svg-check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path></svg>
                              <div class="reportCreditAgency__hobbies-icon">
                                  <img src="../view/client/assets/images/bank/bank<?php echo $bank['title_en']; ?>.png" >
                                  <span><?php echo $bank['title'] ?></span>
                            </div>
                  </span>
                </label>
              <?php $counterBank++; } ?>
            </div>
          </div>
          <div class="center_modal_custom w-100">
            <div class="box-style">
              <div class="box-style-padding">
                <form id="memberChangePassword" action="user_ajax.php" method="post" class='row'>
                  <div class="col-8">
                    <div class="form-profile d-flex flex-wrap gap-0 row mt-0">
                      <label class="label_style w-100">
                        <input type="text" name="amount_to_pay" id="amount_to_pay" placeholder='مبلغ مورد نظر'>
                      </label>
                       <span>ریال</span>
                    </div>
                  </div>
                  <div class="col-4 box_btn mt-0">
                    <?php $bank_inputs = json_encode(['serviceType' => 'charge_credit_member','type_pay'=>''],256|64); ?>
                    <?php $bank_action = ROOT_ADDRESS.'/goBankChargeCreditMember'; ?>
                    <button type="button" class="w-100 px-0 submitChangePasswordProfile" onclick='goBankCreditAgency("<?php echo $bank_action ?>",<?php echo $bank_inputs ?>)'> پرداخت </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
       document.getElementById('amount_to_pay').addEventListener('input', function (e) {
          let input = e.target;
          let value = input.value.replace(/,/g, '');
          if (!isNaN(value)) {
             input.value = Number(value).toLocaleString('en-US');
          } else {
             input.value = '';
          }
       });


       function hide_and_show_pass(e){
        if (e.currentTarget.parentNode.querySelector('input').getAttribute("type") === 'text'){
          e.currentTarget.innerHTML = '<svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M150.7 92.77C195 58.27 251.8 32 320 32C400.8 32 465.5 68.84 512.6 112.6C559.4 156 590.7 207.1 605.5 243.7C608.8 251.6 608.8 260.4 605.5 268.3C592.1 300.6 565.2 346.1 525.6 386.7L630.8 469.1C641.2 477.3 643.1 492.4 634.9 502.8C626.7 513.2 611.6 515.1 601.2 506.9L9.196 42.89C-1.236 34.71-3.065 19.63 5.112 9.196C13.29-1.236 28.37-3.065 38.81 5.112L150.7 92.77zM189.8 123.5L235.8 159.5C258.3 139.9 287.8 128 320 128C390.7 128 448 185.3 448 256C448 277.2 442.9 297.1 433.8 314.7L487.6 356.9C521.1 322.8 545.9 283.1 558.6 256C544.1 225.1 518.4 183.5 479.9 147.7C438.8 109.6 385.2 79.1 320 79.1C269.5 79.1 225.1 97.73 189.8 123.5L189.8 123.5zM394.9 284.2C398.2 275.4 400 265.9 400 255.1C400 211.8 364.2 175.1 320 175.1C319.3 175.1 318.7 176 317.1 176C319.3 181.1 320 186.5 320 191.1C320 202.2 317.6 211.8 313.4 220.3L394.9 284.2zM404.3 414.5L446.2 447.5C409.9 467.1 367.8 480 320 480C239.2 480 174.5 443.2 127.4 399.4C80.62 355.1 49.34 304 34.46 268.3C31.18 260.4 31.18 251.6 34.46 243.7C44 220.8 60.29 191.2 83.09 161.5L120.8 191.2C102.1 214.5 89.76 237.6 81.45 255.1C95.02 286 121.6 328.5 160.1 364.3C201.2 402.4 254.8 432 320 432C350.7 432 378.8 425.4 404.3 414.5H404.3zM192 255.1C192 253.1 192.1 250.3 192.3 247.5L248.4 291.7C258.9 312.8 278.5 328.6 302 333.1L358.2 378.2C346.1 381.1 333.3 384 319.1 384C249.3 384 191.1 326.7 191.1 255.1H192z"/></svg>'
          e.currentTarget.parentNode.querySelector('input').setAttribute("type","password")
        } else if(e.currentTarget.parentNode.querySelector('input').getAttribute("type") === 'password'){
          e.currentTarget.innerHTML = '<svg class="eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M160 256C160 185.3 217.3 128 288 128C358.7 128 416 185.3 416 256C416 326.7 358.7 384 288 384C217.3 384 160 326.7 160 256zM288 336C332.2 336 368 300.2 368 256C368 211.8 332.2 176 288 176C287.3 176 286.7 176 285.1 176C287.3 181.1 288 186.5 288 192C288 227.3 259.3 256 224 256C218.5 256 213.1 255.3 208 253.1C208 254.7 208 255.3 208 255.1C208 300.2 243.8 336 288 336L288 336zM95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 80C222.8 80 169.2 109.6 128.1 147.7C89.6 183.5 63.02 225.1 49.44 256C63.02 286 89.6 328.5 128.1 364.3C169.2 402.4 222.8 432 288 432C353.2 432 406.8 402.4 447.9 364.3C486.4 328.5 512.1 286 526.6 256C512.1 225.1 486.4 183.5 447.9 147.7C406.8 109.6 353.2 80 288 80V80z"/></svg>'
          e.currentTarget.parentNode.querySelector('input').setAttribute("type","text")
        }
      }
      function formGroupNew(name){
        if (name === "Female"){
          $('#male').prop("checked", false)
          $('#female').prop("checked", true)
        } else if (name === "Male") {
          $('#female').prop("checked", false)
          $('#male').prop("checked", true)
        }
      }
      $('html , body').click(() => {
        $(".dropdown_custom > div").hide()
        $(".list_calender_profile").hide()
      })
      $(".country_label_profile").hide()
      $(".dropdown_custom > div").hide()
      $(".select2").select2();
      $(".dropdown_custom > button").click((event) => {
        $(".dropdown_custom > div").toggle()
        event.stopPropagation()
        return false
      })

      function closeModal(){
        $(".modal_custom").remove()
        $("body,html").removeClass("overflow-hidden");
      }
      function dropdown_custom_btn(e){
        $(".dropdown_custom > button > span").text(e.innerHTML)
        $(".dropdown_custom > div > div > button").removeClass("active");
        $(e).addClass("active");
        if(e.innerHTML === 'غیر ایرانی'){
          $(".country_label_profile").show()
          $(".nationalNumber_label_profile").hide()
        } else {
          $(".country_label_profile").hide()
          $(".nationalNumber_label_profile").show()
        }
      }
    </script>

    <?php

  }


}

new ModalIncreaseAccountBalance();
?>