<?php
require '../config/bootstrap.php';
require CONFIG_DIR . 'config.php';
require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'application.php';
spl_autoload_register(array('Load', 'autoload'));
/**
 * Class ModalCreatorForPassenger
 * @property ModalCreatorForPassenger $ModalCreatorForPassenger
 */
class ModalCreatorForPassenger
{

    public $Method;
    public $target;
    public $id;

    public function __construct()
    {
        $Method = $_POST['Method'];
        $passenger_id = $_POST['passenger_id'];
        self::$Method($passenger_id);
    }

    public function ModalShow($passenger_id)
    {

        $condition="id = '".$passenger_id."'";
        $passengerInfo = functions::getValueFields('passengers_tb','*',$condition);

        ?>

        <div class="w-100 modal-header site-bg-main-color">
          <span class="close" onclick="modalClose('')">&times;</span>
          <h6 class="modal-h">  <?php echo functions::Xmlinformation("EditPassenger"); ?> : <?php echo $passengerInfo['name'].' '.$passengerInfo['family']; ?> </h6>
        </div>
        <div class="w-100 modal-body">
            <div class="row">
              <div class="form-group col-md-12">
                <form id="updatePassengerForm" action="user_ajax.php" method="post">
                  <input type="hidden" name="passengerId" value="<?php echo $passengerInfo['id']; ?>">
                  <input type="hidden" name="passengerNationalityEdit" value="<?php echo $passengerInfo['is_foreign']; ?>">
                  <input type="hidden" name="passengerPassportCountry" value="<?php echo $passengerInfo['passportCountry']; ?>">
                  <input type="hidden" name="memberID" value="<?php echo $passengerInfo['fk_members_tb_id']; ?>">
                  <div class="col-md-3 mb-3">
                    <label for="passengerName" class="font-13"><?php echo functions::Xmlinformation("Name"); ?></label>
                    <input type="text"
                           name="passengerName"
                           id="passengerName"
                           value="<?php echo $passengerInfo['name']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("Name"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerNameEn" class="font-13"><?php echo functions::Xmlinformation("Nameenglish"); ?></label>
                    <input type="text"
                           name="passengerNameEn"
                           id="passengerNameEn"
                           value="<?php echo $passengerInfo['name_en']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("Nameenglish"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerFamily" class="font-13"><?php echo functions::Xmlinformation("Family"); ?></label>
                    <input type="text"
                           name="passengerFamily"
                           id="passengerFamily"
                           value="<?php echo $passengerInfo['family']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("Family"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerFamilyEn" class="font-13"><?php echo functions::Xmlinformation("Familyenglish"); ?></label>
                    <input type="text"
                           name="passengerFamilyEn"
                           id="passengerFamilyEn"
                           value="<?php echo $passengerInfo['family_en']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("Familyenglish"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerGender" class="font-13"><?php echo functions::Xmlinformation("Sex"); ?></label>
                    <select class="form-control" name="passengerGender" id="passengerGender">
                      <option value="Male" <?php echo($passengerInfo['gender'] == 'Male' ? 'selected':''); ?>>
                          <?php echo functions::Xmlinformation("Male"); ?>
                      </option>
                      <option value="Female" <?php echo($passengerInfo['gender'] == 'Female' ? 'selected':''); ?>>
                          <?php echo functions::Xmlinformation("Female"); ?>
                      </option>
                    </select>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerBirthday" class="font-13"><?php echo functions::Xmlinformation("shamsihappybirthday"); ?></label>
                    <input type="text"
                           name="passengerBirthday"
                           id="passengerBirthday"
                           value="<?php echo $passengerInfo['birthday_fa']; ?>"
                           class="form-control shamsiBirthdayCalendar" placeholder="<?php echo functions::Xmlinformation("shamsihappybirthday"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerBirthdayEn" class="font-13"><?php echo functions::Xmlinformation("miladihappybirthday"); ?></label>
                    <input type="text"
                           name="passengerBirthdayEn"
                           id="passengerBirthdayEn"
                           value="<?php echo $passengerInfo['birthday']; ?>"
                           class="form-control gregorianBirthdayCalendar" placeholder="<?php echo functions::Xmlinformation("miladihappybirthday"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerregister_date" class="font-13"><?php echo functions::Xmlinformation("RegisterDate"); ?></label>
                    <input type="text"
                           disabled
                           value="<?php echo $passengerInfo['register_date']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("RegisterDate"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerlast_modify" class="font-13"><?php echo functions::Xmlinformation("Lastchangeupdate"); ?></label>
                    <input type="text"
                           disabled
                           value="<?php echo $passengerInfo['last_modify']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("Lastchangeupdate"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerNationalCode" class="font-13"><?php echo functions::Xmlinformation("NationalCode"); ?></label>
                    <input type="text"
                           name="passengerNationalCode"
                           id="passengerNationalCode"
                           value="<?php echo $passengerInfo['NationalCode']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("NationalCode"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerPassportNumber" class="font-13"><?php echo functions::Xmlinformation("Numpassport"); ?></label>
                    <input type="text"
                           name="passengerPassportNumber"
                           id="passengerPassportNumber"
                           value="<?php echo $passengerInfo['passportNumber']; ?>"
                           class="form-control" placeholder="<?php echo functions::Xmlinformation("Numpassport"); ?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="passengerPassportExpire" class="font-13"><?php echo functions::Xmlinformation("Passportexpirydate"); ?></label>
                    <input type="text"
                           name="passengerPassportExpire"
                           id="passengerPassportExpire"
                           value="<?php echo $passengerInfo['passportExpire']; ?>"
                           class="form-control gregorianBirthdayCalendar" placeholder="<?php echo functions::Xmlinformation("Passportexpirydate"); ?>">
                  </div>
                  <div class="col-md-12 mb-3 ">
                    <button type="button" class="submitPassengerUpdateForm btn btn-outline-primary"><?php echo functions::Xmlinformation("Update"); ?></button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php

    }


}

new ModalCreatorForPassenger();
?>