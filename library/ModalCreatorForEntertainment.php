<?php
require '../config/bootstrap.php';
require CONFIG_DIR.'config.php';
require LIBRARY_DIR.'Load.php';
require CONFIG_DIR.'application.php';
spl_autoload_register(array(
    'Load',
    'autoload'));

/**
 * Class ModalCreatorForHotel
 * @property ModalCreatorForEntertainment $ModalCreatorForEntertainment
 */
class ModalCreatorForEntertainment
{

    public $Controller;
    public $Method;
    public $target;
    public $id;

    public function __construct()
    {
        if (isset($_POST['Controller'])) {
            $this->Controller=$_POST['Controller'];
        }
        $Method = $_POST['Method'];
        if (isset($_POST['Param'])) {
            $Param=$_POST['Param'];
        }
        if (isset($_POST['factorNumber'])) {
            $factorNumber = $_POST['factorNumber'];
            self::$Method($factorNumber);
        }
        if (isset($Param)) {
            self::$Method($Param);
        }
    }

    public function GetSubCategories($Param)
    {

        $Model=Load::library('Model');
        if(empty($Param)){
            $query = " SELECT * FROM  entertainment_category_tb";
            $res = $Model->select($query);
        }else{
            $query = " SELECT * FROM  entertainment_category_tb WHERE parent_id =".$Param;
            $res = $Model->select($query);
        }
        $FinalResult['data']='';
        foreach($res as $item){
            $FinalResult['data'].='<option value="'.$item['id'].'">'.$item['title'].'</option>';
        }

        if ($res) {
            $FinalResult['status']='success : ثبت شد ';
        } else {
            $FinalResult['status']='error : خطا ، دوباره تلاش کنید';
        }
        echo json_encode($FinalResult);

    }

    public function ModalGetEntertainmentTypeData($Param=null)
    {
        $Model=Load::library('Model');
        if(empty($Param)){
            $query = " SELECT * FROM  entertainment_type_tb";
            $res = $Model->select($query);
        }else{
            $query = " SELECT * FROM  entertainment_type_tb WHERE id =".$Param;
            $res = $Model->select($query);
        }
        $FinalResult['data']=$res;
        echo json_encode($FinalResult);
    }
    public function ModalAddType($Param)
    {
        parse_str($Param, $ParseParam);

        $Model=Load::library('Model');
        $Model->setTable('entertainment_type_tb');
        $NewData['title']=$ParseParam['EntertainmentTypeName'];
        $NewData['logo']=$ParseParam['EntertainmentTypeIcon'];
        if($ParseParam['FormStatus'] == 'new'){
            $result=$Model->insertLocal($NewData);
        }else{
            $condition = "id='{$ParseParam['FormStatus']}'";
            $result=$Model->update($NewData, $condition);
        }

        if ($result) {
            $FinalResult['status']='success : ثبت شد ';
        } else {
            $FinalResult['status']='error : خطا ، دوباره تلاش کنید';
        }
        echo json_encode($FinalResult);

    }

    public function ModalRemove($Param)
    {
        if (!empty($Param)) {
            $Model = Load::library('Model');
            $condition = "id = '{$Param}'";
            $Model->setTable('entertainment_type_tb');
            $result=$Model->delete($condition);

            if ($result) {
                $FinalResult['status']='success : حذف شد ';
            } else {
                $FinalResult['status']='error : خطا ، دوباره تلاش کنید';
            }
            echo json_encode($FinalResult);
        }
    }

    public function ModalShowAddType($Param)
    { ?>
      <div class="modal-dialog modal-xl">
        <div class="modal-content col-md-12 p-0">
          <div class="modal-header col-md-12">
            <h5 class="modal-title" id="modalOptionsLabel"><?php echo functions::Xmlinformation('Options'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>


          <div class="modal-body col-md-12 ">


            <div class="col-md-12 d-flex flex-wrap p-0">


              <div class="col-md-6 StickyDiv">
                <form id="NewEntertainmentType" method="post">
                  <div class="form-group">
                    <label for="EntertainmentTypeName"><?php echo functions::Xmlinformation('NameNewType'); ?></label>
                    <input required name="EntertainmentTypeName" type="text" class="form-control"
                           id="EntertainmentTypeName"
                           aria-describedby="emailHelp" placeholder="<?php echo functions::Xmlinformation('TypeName'); ?>">
                    <small id="emailHelp" class="form-text text-muted">
                        <?php echo functions::Xmlinformation('NameNewTypeCommentForModalAdd'); ?>
                    </small>
                  </div>
                  <div class="form-group">
                    <label for="EntertainmentTypeIcon"> <?php echo functions::Xmlinformation('IconNewType'); ?></label>
                    <div class="col-md-12 d-flex flex-wrap p-0 pt-3 border IconBox">
                        <?php
                        $icons=[
                            'mdi mdi-access-point-network',
                            'mdi mdi-checkbox-blank-circle-outline',
                            'mdi mdi-account-card-details',
                            'mdi mdi-alert-circle',
                            'mdi mdi-asterisk',
                            'mdi mdi-battery-40',
                            'mdi mdi-bike',
                            'mdi mdi-binoculars',
                            'mdi mdi-bookmark-music',
                            'mdi mdi-bowling',
                            'mdi mdi-broom',
                            'mdi mdi-brush',
                            'mdi mdi-bus',
                            'mdi mdi-calendar-clock',
                            'mdi mdi-camcorder',
                            'mdi mdi-car-connected',
                            'mdi mdi-castle',
                            'mdi mdi-check-all',
                            'mdi mdi-close',
                            'mdi mdi-food',
                            'mdi mdi-food-off',
                            'mdi mdi-scale-bathroom',
                            'mdi mdi-sd',
                            'mdi mdi-seat-flat',
                            'fa-solid fa-camera-movie',
                            'fa-regular fa-ferris-wheel',
                            'fa-solid fa-ship',
                            'fa fa-cutlery',
                            'fa-solid fa-masks-theater',
                            'fa-solid fa-camera-retro'
                        ];
                        foreach($icons as $icon){
                            ?>
                          <div data-target="IconBoxSelector" data-value="mdi <?php echo $icon; ?>"
                               class="col-md-3 text-center item mb-3">
                            <div class="border text-center" onclick="EntertainmentTypeClick($(this),'<?php echo $icon; ?>')">
                              <span class="<?php echo $icon; ?>"></span>
                            </div>
                          </div>
                        <?php } ?>
                      <input type="hidden" name="EntertainmentTypeIcon">
                      <input type="hidden" name="FormStatus" value="new">
                    </div>

                  </div>
                  <button data-target="SubmitForm" type="button" onclick="SubmitNewEntertainmentType()" class="btn btn-primary mt-4">
                      <?php echo functions::Xmlinformation('AddItem'); ?>
                  </button>
                </form>
              </div>
              <div class="col-md-6">
                <table class="table table-hover">
                  <thead>
                  <tr>
                    <th scope="col"><?php echo functions::Xmlinformation('NameType'); ?></th>
                    <th scope="col"><?php echo functions::Xmlinformation('Icon'); ?></th>
                    <th scope="col" colspan="2"><?php echo functions::Xmlinformation('Action'); ?></th>
                  </tr>
                  </thead>
                  <tbody id="AllEntertainmentType">

                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    <?php }

    public function RemoveEntertainmentCategory($Param)
    {
        if (!empty($Param)) {
            $Model = Load::library('Model');
            $condition = "id = '{$Param}'";
            $Model->setTable('entertainment_category_tb');
            $result=$Model->delete($condition);

            if ($result) {
                $FinalResult['status']='success : '.functions::Xmlinformation('DeletedItem');
            } else {
                $FinalResult['status']='error : '.functions::Xmlinformation('ErrorTryAgain');
            }
            echo json_encode($FinalResult);
        }
    }
    public function RemoveEntertainment($Param)
    {
        if (!empty($Param)) {
            $Model = Load::library('Model');
            $condition = "id = '{$Param}'";
            $Model->setTable('entertainment_tb');
            $result=$Model->softDelete($condition);

            if ($result) {
                $FinalResult['status']='success : '.functions::Xmlinformation('DeletedItem');
            } else {
                $FinalResult['status']='error : '.functions::Xmlinformation('ErrorTryAgain');
            }
            echo json_encode($FinalResult);
        }
    }

    public function ModalNewEntertainmentCategory($Param)
    {
        parse_str($Param, $ParseParam);
        $Model = Load::library('Model');
        $Model->setTable("entertainment_category_tb");
        $data['title']=$ParseParam['EntertainmentCategoryTitle'];
        if($ParseParam['FormStatus'] == 'new'){
            $data['parent_id']=$ParseParam['RadioParent'];
            $result=$Model->insertLocal($data);
        }else{
            $data['validate']=($ParseParam['EntertainmentCategoryValidation'] == 'on' ? "1":"0");
            $condition = "id='{$ParseParam['FormStatus']}'";
            $result=$Model->update($data, $condition);
        }

        if ($result) {
            $FinalResult['status']='success : '.functions::Xmlinformation('SuccessfullyRecorded');
        } else {
            $FinalResult['status']='error : '.functions::Xmlinformation('ErrorTryAgain');
        }
        echo json_encode($FinalResult);
    }

    public function ModalShowEditCategory($Param)
    {
        $EntertainmentController = Load::controller('entertainment');
        $SingleGetData=$EntertainmentController->GetData('',$Param);
        ?>
      <div class="modal-dialog modal-lg">
        <div class="modal-content col-md-12 p-0">
          <div class="modal-header col-md-12  site-bg-main-color">
            <span class="close" onclick="modalClose('')">&times;</span>
            <h6 class="modal-h"><?php echo functions::Xmlinformation('EditCategory'); ?></h6>
          </div>


          <div class="modal-body col-md-12 ">


            <div class="col-md-12 p-0">


              <form id="EditEntertainmentCategory" method="post">
                <div class="form-group">
                  <label for="EntertainmentCategoryTitle">نام</label>
                  <input required name="EntertainmentCategoryTitle" type="text" class="form-control"
                         id="EntertainmentCategoryTitle"
                         aria-describedby="emailHelp" value="<?php echo $SingleGetData['CategoryTitle']; ?>" placeholder="نام">

                </div>

                <div class="form-group">
                  <label for="EntertainmentCategoryValidation"><?php echo functions::Xmlinformation('DisplayPermission'); ?></label>
                  <input <?php if($SingleGetData['CategoryValidate'] == 1) {echo'checked="checked"';} ?> required name="EntertainmentCategoryValidation" type="checkbox" class="form-control"
                                                                                                         id="EntertainmentCategoryValidation"
                                                                                                         aria-describedby="emailHelp" placeholder="مجوز نمایش">

                </div>
                <input type="hidden" name="FormStatus" value="<?php echo $SingleGetData['CategoryId']; ?>">
                <button data-target="SubmitForm" type="button" onclick="SubmitEditEntertainmentCategory()" class="btn btn-primary mt-4">
                  به روزرسانی
                </button>
              </form>
            </div>

          </div>

        </div>
      </div>
      </div>
    <?php }




    public function ModalShowBook($factorNumber)
    {


        $entertainmentController = Load::controller('entertainment');
        /** @var controller $entertainmentController */
        $infoBook=$entertainmentController->getBookDataEntertainment($factorNumber);

        $requestStatuses=[
            [
                'index'=>'Requested',
                'title'=>'درخواست شده',
            ],
            [
                'index'=>'RequestRejected',
                'title'=>'رد کردن درخواست',
            ],
            [
                'index'=>'RequestAccepted',
                'title'=>'تایید درخواست',
            ],
        ];
        ?>

      <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header site-bg-main-color">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">مشاهده مشخصات رزرو تفریحات
              <?php echo($infoBook[0]['EntertainmentTitle']);?>
          </h4>
        </div>
        <div class="modal-body">

          <div class="row margin-both-vertical-20">
            <div class="col-md-12 text-center text-bold " style="color: #fb002a;">
              <span>مشخصات رزرو</span></div>
          </div>


          <hr style="margin: 5px 0;"/>
          <div class="row margin-both-vertical-20">
            <div class="col-md-3">
              <span class=" pull-left">نام تفریحات: </span>
              <span class="yn"><?php echo $infoBook[0]['EntertainmentTitle']; ?></span>
            </div>
            <div class="col-md-3">
              <span class=" pull-left">مقصد: </span>
              <span class="yn"><?php echo $infoBook[0]['city_name']; ?> / <?php echo $infoBook[0]['country_name']; ?></span>
            </div>
          </div>
          <div class="row margin-both-vertical-20">
            <div class="col-md-3">
              <span class=" pull-left">نام مجموعه: </span>
              <span class="yn"><?php echo $infoBook[0]['BaseCategoryTitle']; ?></span>
            </div>
            <div class="col-md-3">
              <span class=" pull-left">نام زیرمجموعه: </span>
              <span class="yn"><?php echo $infoBook[0]['CategoryTitle']; ?></span>
            </div>
          </div>
          <div class="row margin-both-vertical-20">
            <div class="col-md-4">
              <span class=" pull-left">شماره فاکتور: </span>
              <span class="yn"><?php echo $infoBook[0]['factor_number']; ?></span>
            </div>
            <div class="col-md-4">
              <span class=" pull-left">ﺷﻤﺎره واچر: </span>
              <span class="yn"><?php echo $infoBook[0]['requestNumber']; ?></span>
            </div>
          </div>
          <div class="row margin-both-vertical-20">
            <div class="col-md-4">
              <span class=" pull-left">ﺗﻌﺪاد ﻧﻔﺮات: </span>
              <span class="yn"><?php echo $infoBook[0]['CountPeople']; ?></span>
            </div>
            <div class="col-md-4">
              <span class=" pull-left">کد ملی: </span>
               <?php if ($infoBook[0]['passenger_national_code']) { ?>
              <span class="yn"><?php echo $infoBook[0]['passenger_national_code'];  ?></span>
            <?php }else{ ?>
                   <span>---</span>
               <?php } ?>
            </div>
          </div>

          <div class="row margin-both-vertical-20">
            <div class="col-md-4">
              <span class=" pull-left">تاریخ رزرو: </span>
              <span class="yn"><?php echo str_replace('-', '/', $infoBook[0]['passenger_reserve_date']); ?></span>
            </div>
            <div class="col-md-4">
              <span class=" pull-left">قیمت: </span>
              <span class="yn">
                  <?php if ($infoBook[0]['DiscountAmount'] > 0) { ?>
                  <span
                    style="float: left ; position: relative; left: 0; text-decoration: line-through"><?php echo $infoBook[0]['FullPrice']; ?> تومان </span>
                  <?php } ?>
                            <span
                              style="float: left ;display: block; position: relative; left: 0;"><?php echo $infoBook[0]['DiscountPrice']; ?> تومان </span>
</span>
            </div>
          </div>
          <div class="row margin-both-vertical-20">
            <div class="col-md-4">
              <table width="450" cellpadding="0" cellspacing="0" class="page" border="0">
                <tr>
                  <td width="50%" height="70" align="center" valign="middle"
                      style="border-left: 1px solid #CCC;">
                    وضعیت
                  </td>
                  <td width="50%" height="70" align="center" valign="middle"
                      style="font-size: 20px;">
                      <?php echo($infoBook[0]['successfull'] == 'book' ? "پرداخت شده" : "پرداخت نشده"); ?>

                      <?php if ($infoBook[0]['successfull'] == 'Requested') { ?>
                        <span
                          style="float: left ; position: relative; left: 0; ">(درخواست رزرو)</span>
                      <?php } ?>
                  </td>
                </tr>
              </table>
            </div>

          </div>


          <hr style="margin: 5px 0;"/>
          <div class="row margin-top-10 margin-both-vertical-20">
            <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>مشخصات خریدار </span>
            </div>
          </div>

          <div class="row modal-padding-bottom-15 margin-both-vertical-20">
            <div class="col-md-4">
              <span class=" pull-left">نام خریدار: </span>
              <span class="yn"><?php echo $infoBook[0]['member_name']; ?></span>
            </div>
            <div class="col-md-4">
              <span class=" pull-left">موبایل خریدار: </span>
              <span class="yn"><?php echo $infoBook[0]['mobile_buyer']; ?></span>
            </div>

          </div>

          <hr style="margin: 5px 0;"/>
          <div class="row margin-top-10 margin-both-vertical-20">
            <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>اطلاعات مسافر </span>
            </div>
          </div>

          <div class="row modal-padding-bottom-15 margin-both-vertical-20">
            <div class="col-md-4">
              <span class=" pull-left">نام مسافر: </span>
              <span class="yn"><?php echo $infoBook[0]['passenger_name']; ?> /<?php echo $infoBook[0]['passenger_name_en']; ?> </span>
            </div>
            <div class="col-md-4">
              <span class=" pull-left">نام خانوادگی مسافر: </span>
              <span class="yn"><?php echo $infoBook[0]['passenger_family']; ?> /<?php echo $infoBook[0]['passenger_family_en']; ?></span>
            </div>

          </div>

            <?php if ($infoBook[0]['successfull'] == 'Requested' || $infoBook[0]['successfull'] == 'RequestAccepted' || $infoBook[0]['successfull'] == 'RequestRejected') { ?>
          <hr style="margin: 5px 0;"/>
          <div class="row margin-top-10 margin-both-vertical-20">
            <div class="col-md-12 text-center text-bold " style="color: #fb002a;"><span>ویرایش وضعیت درخواست</span>
            </div>
          </div>
          <div class="row modal-padding-bottom-15 margin-both-vertical-20">
            <div class='col-md-12'>
                <?php     foreach ($requestStatuses as $requestStatus) {?>
                  <button data-name='<?php echo $requestStatus['index'];?>' onclick='changeRequestedEntertainmentStatus($(this),"<?php echo $infoBook[0]['factor_number']; ?>","<?php echo $requestStatus['index'];?>")'
                          class='btn <?php if($requestStatus['index'] != $infoBook[0]['successfull']){echo 'btn-outline'; } ?> btn-primary'><?php echo $requestStatus['title'];?></button>
                <?php }?>


            </div>
          </div>
           <?php } ?>

        </div>

      </div>

        <?php

    }


}

new ModalCreatorForEntertainment();
?>