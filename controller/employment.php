<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class employment extends clientAuth {
    /**
     * @var string
     */
    protected $table = 'employment_tb';
    private $employmentTb,$page_limit,$requestServiceTb ,$employmentWorkExperienceTb,$employmentEducationalTb,
        $employmentWorkLanguagesTb, $employmentMilitary ,
        $employmentEducationalCertificate , $employmentRequestJob;
    /**
     * @var string
     */

    public function __construct() {
        parent::__construct();
        $this->employmentTb = 'employment_tb';
        $this->page_limit = 6;
        $this->requestServiceTb = 'request_service_tb';
        $this->employmentWorkExperienceTb = 'employment_work_experience_tb';
        $this->employmentEducationalTb = 'employment_educational_tb';
        $this->employmentWorkLanguagesTb = 'employment_languages_tb';
        $this->employmentMilitary = Load::controller('employmentMilitary');
        $this->employmentEducationalCertificate = Load::controller('employmentEducationalCertificate');
        $this->employmentRequestJob = Load::controller('employmentRequestedJob');
    }


    public function createPdfContent($requestId)
    {
        $employment_model = $this->getModel('employmentModel');
        $employment_table = $employment_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $employment = $employment_model->get([
            $employment_table.'.*',
            $employment_table . '.id AS eId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.id' , $requestId)
            ->where($request_service_table . '.module_title' , employment)
            ->find(false);

        $gender = $this->addEmploymentIndexes([$employment])[0]['gender'];
        if ($gender == 1) {
            $gender = 'مرد';
        }elseif ($gender == 2) {
            $gender = 'زن';
        }else {
            $gender = 'وارد نشده';
        }
        $employment['gender'] = $gender;
        $married = $this->addEmploymentIndexes([$employment])[0]['married'];
        if ($married == 1) {
            $married = 'مجرد';
        }elseif ($married == 2) {
            $married = 'متاهل';
        }else {
            $married = 'وارد نشده';
        }
        $employment['married'] = $married;
        $cooperation_type = $this->addEmploymentIndexes([$employment])[0]['cooperation_type'];
        $cooperation_type_c = explode(',', $cooperation_type);
        foreach ($cooperation_type_c as $key => $value) {
            if ($value == 1 ) {
                $type = 'تمام وقت';
            } elseif ($value == 2) {
                $type = 'نیمه وقت';
            }
            $last_arr[] = $type;
            $type = implode($last_arr, ',');
            $employment['cooperation_type'] = $type;
        }
        $employmentId = $employment['eId'];
        $experience_model = $this->getModel('employmentWorkExperienceModel')->get()->where('employment_id', $employmentId);
        $experience =  $experience_model->all();


        $skill_model = $this->getModel('employmentSkillModel')->get()->where('employment_id', $employmentId);
        $skill =  $skill_model->all();

        $education_model = $this->getModel('employmentEducationModel')->get()->where('employment_id', $employmentId);
        $education =  $education_model->all();

        $language_model = $this->getModel('employmentLanguageModel')->get()->where('employment_id', $employmentId);
        $language =  $language_model->all();

        $employmentMilitary = Load::controller( 'employmentMilitary' );
        $military   = $employmentMilitary->getEmploymentMilitary( $employment['military'] );

        $employmentEducationalCertificate = Load::controller( 'employmentEducationalCertificate' );
        $educational   = $employmentEducationalCertificate->getEmploymentEducationalCertificate( $employment['last_educational_certificate'] );

        $cityMain = Load::controller( 'mainCity' );
        $city = $cityMain->getCityAll( $employment['city'] );

        $requestedJob = Load::controller( 'employmentRequestedJob' );
        $job = $requestedJob->getRequestedJob( $employment['requested_job'] );
        $LogoAgency = ROOT_ADDRESS_WITHOUT_LANG.'/pic/'. CLIENT_LOGO;
        if (!empty($employmentId)) {
            ob_start();
            ?>
            <!doctype html>
            <html lang="fa" dir="rtl">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport"
                      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--                <title>PDF</title>-->
<!--                <link rel="stylesheet" href="../view/administrator/assets/css/employment/css/bootstrap.min.css">-->
<!--                <link rel="stylesheet" href="../view/administrator/assets/css/employment/css/style.css">-->

              <title>ticket PDF Employment</title>
              <style type="text/css">

                  @font-face {
                      font-family: 'yekanbakhBold';
                      src: url("../view/administrator/assets/css/employment/fonts/yekanbakhBold/Yekan-Bakh-FaNum-06-Bold.woff") format("woff");
                      font-weight: bold;
                      font-style: normal;
                  }
                  @font-face {
                      font-family: 'yekanbakhmedium';
                      src: url("../view/administrator/assets/css/employment/fonts/yekanbakhmedium/Yekan-Bakh-FaNum-05-Medium.woff") format("woff");
                  }

                  :root{
                      --mainColor: #1b1464;
                      --secondColor: #f8b21e;
                      --radius: 15px;
                  }
                  body{
                      font-family: 'yekanbakhmedium', sans-serif !important;
                      overflow-x: hidden;
                      direction: rtl;
                      padding: 0;
                      background: #d7d7d7 !important;
                      line-height: 24px;
                      text-align: right;
                      color: #4B5259 !important;
                  }
                  .parent-pdf{
                      /*! margin-top:50px; */
                      background: #fff;
                      padding: 20px 50px;
                  }
                  .header-pdf{
                      display: flex;
                      align-items: center;
                      background: #f7f7f7;
                      height: 30px;
                  }
                  .item-header{
                      display: flex;
                      align-items: center;
                      justify-content: center;
                      gap: 10px;
                  }
                  .item-header .text-title{
                      font-size: 14px;
                  }
                  .item-header .text-title-bold{
                      margin-bottom: 0;
                      color: #3333;
                  }
                  .logo-pdf{
                      display: flex;
                      align-items: center;
                      margin-bottom: 10px;
                      /*! margin-top: 20px; */
                      justify-content: center;
                      gap: 7px;
                  }
                  .parent-logo img{
                      width: 100px;
                  }
                  .title{
                      display: flex;
                      align-items: center;
                      justify-content: right;
                      width: 100%;
                      padding: 0 0 7px 0;
                      border-bottom: 1px solid #999;
                      gap: 7px;
                      margin-top: 30px;
                  }
                  .title img{
                      width: 28px;
                  }
                  .title h5 {
                      margin: 0;
                      color: #000;
                      margin-top: 10px;
                      font-size: 20px;
                      font-weight: 700;
                  }
                  .parent-data-user,.parent-records,.parent-skill,.parent-educational,.parent-language{
                      display: flex;
                      flex-wrap: wrap;
                      /*! padding: 30px 0; */
                      background: #f9fbfc;
                      margin-top: 10px;
                      margin-bottom: 10px;
                  }
                  .item-data{
                      display: flex;
                      align-items: center;
                      gap: 5px;
                      width: 30%;
                  }
                  .bold-text-data{
                      margin-bottom: 0;
                      font-size: 16px;
                      color: #000;
                  }
                  .text-data{
                      font-size: 14px;
                      color: #777;
                  }
                  .margin-bottomm{
                      margin-bottom: 10px;
                  }
                  .text-title-bold-header{
                      margin-bottom: 0  !important;
                      font-size: 16px  !important;
                      color: #333  !important;
                  }
                  .text-title-header{
                      font-size: 14px  !important;
                      color: #777  !important;
                  }
                  .text-logo{
                      display: flex  !important;
                      flex-direction: column  !important;
                      align-items: center  !important;
                  }
                  .logo-title{
                      font-size: 22px;
                  }
                  .item-data2{
                      width: 49%;
                  }
                  //table1
                  table.customTable {
                      width: 0%;
                      background-color: #FFFFFF;
                      border-collapse: collapse;
                      border-width: 1px;
                      border-color: #555555;
                      border-style: solid;
                      color: #000000;
                  }

                  table.customTable td, table.customTable th {
                      border-width: 1px;
                      border-color: #555555;
                      border-style: solid;
                      padding: 5px;
                  }

                  table.customTable thead {
                      background-color: #0E52A3;
                  }









                  table.customTable10 {
                      width: 100%;
                      background-color: #FFFFFF;
                      border-collapse: collapse;
                      border-width: 0px;
                      border-color: #CCCCCC;
                      border-style: solid;
                      color: #000000;
                  }

                  table.customTable10 td, table.customTable10 th {
                      border-width: 0px;
                      border-color: #CCCCCC;
                      border-style: solid;
                      padding: 5px;
                  }

                  table.customTable10 thead {
                      background-color: #7EA8F8;
                  }

              </style>
            </head>
            <body>
            <section class="pdf">
                <div class="container">
                    <div class="header-pdf">

                      <table class="customTable0" width='100%'>
                        <thead>
                        <tr>
                          <th>شماره تلفن</th>
                          <th>ایمیل</th>
                          <th>آدرس</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td style='text-align: center'><?php echo $employment['mobile']; ?></td>
                          <td style='text-align: center'><?php echo $employment['email']; ?></td>
                          <td style='text-align: center'><?php echo $employment['address']; ?></td>
                        </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="parent-pdf">
                        <div width='100%' class="logo-pdf">
                          <table class="customTable10">
                            <tbody>
                            <tr>
                              <td class='text-center'><img src="<?php echo $LogoAgency; ?>" alt="<?php echo $LogoAgency; ?>" style="max-width: 150px"></td>
                            </tr>
                            </tbody>
                          </table>
                        </div>

                        <div  class="data-user">
                            <div class="title">
                                <h5>اطلاعات شخصی</h5>
                            </div>
                            <div class="parent-data-user">

                              <table class="customTable" width='100%'>
                                <thead>
                                <tr>
                                  <th>نام و نام خانوادگی</th>
                                  <th>تاریخ تولد</th>
                                  <th>جنسیت</th>
                                  <th>وضعیت نظام وظیفه</th>
                                  <th>وضعیت تاهل</th>
                                  <th>رشته تحصیلی</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td><?php echo $employment['name']; ?></td>
                                  <td><?php echo $employment['birth']; ?></td>
                                  <td>
                                      <?php if ($employment['gender']) { ?>
                                      <?php echo $employment['gender'] ?>
                                      <?php }else{ ?>
                                       ---
                                      <?php } ?>
                                  </td>
                                  <td>
                                   <?php if(!empty($military)) {
                                      foreach ($military as $key => $value) { ?>
                                      <?php echo $value['title']  ?>
                                      <?php }
                                       }else{ ?>
                                       ---
                                   <?php } ?>
                                  </td>
                                  <td>
                                    <?php if($employment['married']) { ?>
                                    <?php echo $employment['married'] ?>
                                    <?php }else{ ?>
                                    ---
                                    <?php } ?>
                                  </td>
                                  <td>
                                    <?php if($employment['married']) { ?>
                                    <?php echo $employment['married'] ?>
                                    <?php }else{ ?>
                                    ---
                                    <?php } ?>
                                  </td>
                                </tr>
                                </tbody>
                              </table>
                            </div>
                        </div>

                        <?php if (!empty($experience)) { ?>
                        <div class="records">
                            <div class="title">
                                <h5>سوابق شغلی</h5>
                            </div>

                            <div class="parent-records">

                              <table class="customTable" width="100%">
                                <thead>
                                <tr>
                                  <th>عنوان شغلی</th>
                                  <th>نام شرکت</th>
                                  <th>تلفن شرکت</th>
                                  <th>مدت اشتغال</th>
                                  <th>حقوق دریافتی</th>
                                  <th>علت کناره گیری</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($experience as $key => $value) { ?>
                                <tr>
                                  <td><?php echo $value[company_post]  ?></td>
                                  <td><?php echo $value[company_name] ?></td>
                                  <td><?php echo $value[company_tell] ?></td>
                                  <td><?php echo $value[employment_period] ?></td>
                                  <td><?php echo $value[receive_salary] ?></td>
                                  <td><?php echo $value[reason_left] ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                              </table>

                            </div>
                        </div>
                        <?php } ?>

                        <?php if (!empty($skill)) { ?>
                        <div class="skill">
                            <div class="title">
                                <h5>سایر مهارت ها</h5>
                            </div>
                            <div class="parent-skill">

                              <table class="customTable" width='100%'>
                                <thead>
                                <tr>
                                  <th>نام مهارت</th>
                                  <th>میزان توانایی</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  foreach ($skill as $key => $value) { ?>
                                <tr>
                                  <td><?php echo $value[skill_name] ?></td>
                                  <td>
                                   <?php if ($value['ability_level'] == 1) { ?>
                                    ضعیف
                                    <?php } elseif ($value['ability_level'] == 2) { ?>
                                    متوسط
                                    <?php } elseif ($value['ability_level'] == 3) { ?>
                                    خوب
                                    <?php } elseif ($value['ability_level'] == 4) { ?>
                                    عالی
                                    <?php } ?>
                                  </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                              </table>
                            </div>

                        </div>
                        <?php } ?>

                        <?php if (!empty($education)) { ?>
                        <div class="educational">
                            <div class="title">
                                <h5>سوابق تحصیلی</h5>
                            </div>

                            <div class="parent-educational">

                              <table class="customTable" width='100%'>
                                <thead>
                                <tr>
                                  <th>مقطع</th>
                                  <th>رشته</th>
                                  <th>نام موسسه</th>
                                  <th>محل موسسه</th>
                                  <th>تاریخ شروع</th>
                                  <th>تاریخ خاتمه</th>
                                  <th>معدل</th>
                                  <th>عنوان پایان نامه</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($education as $key => $value) { ?>
                                <tr>
                                  <td><?php echo $value[educational_cross] ?></td>
                                  <td><?php echo $value[educational_field] ?></td>
                                  <td><?php echo $value[educational_name_institution] ?></td>
                                  <td><?php echo $value[educational_institute_location] ?></td>
                                  <td><?php echo $value[educational_start_date] ?></td>
                                  <td><?php echo $value[educational_end_date] ?></td>
                                  <td><?php echo  $value[average] ?></td>
                                  <td><?php echo $value[project_title] ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                              </table>

                            </div>
                        </div>
                        <?php } ?>

                      <?php  if (!empty($language)) { ?>
                        <div class="language">
                            <div class="title">
                                <h5>زبان های خارجی</h5>
                            </div>

                            <div class="parent-language">

                              <table class="customTable" width='100%'>
                                <thead>
                                <tr>
                                  <th>زبان</th>
                                  <th>سطح مهارت مکالمه</th>
                                  <th>سطح مهارت مکاتبه</th>
                                  <th>سطح مهارت ترجمه</th>
                                  <th>دارای گواهینامه ؟</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  foreach ($language as $key => $value) { ?>
                                <tr>
                                  <td><?php echo $value[language_name]  ?></td>
                                  <td>
                                    <?php if ($value['language_conversational_skill_level'] == 1) { ?>
                                      ضعیف
                                    <?php } elseif ($value['language_conversational_skill_level'] == 2) { ?>
                                      متوسط
                                    <?php } elseif ($value['language_conversational_skill_level'] == 3) { ?>
                                      خوب
                                    <?php } elseif ($value['language_conversational_skill_level'] == 4) { ?>
                                      عالی
                                    <?php } ?>
                                  </td>
                                  <td>
                                      <?php if ($value['language_correspondence_skill_level'] == 1) { ?>
                                        ضعیف
                                      <?php } elseif ($value['language_correspondence_skill_level'] == 2) { ?>
                                        متوسط
                                      <?php } elseif ($value['language_correspondence_skill_level'] == 3) { ?>
                                        خوب
                                      <?php } elseif ($value['language_correspondence_skill_level'] == 4) { ?>
                                        عالی
                                      <?php } ?>
                                  </td>
                                  <td>
                                      <?php if ($value['language_translation_skill_level'] == 1) { ?>
                                        ضعیف
                                      <?php } elseif ($value['language_translation_skill_level'] == 2) { ?>
                                        متوسط
                                      <?php } elseif ($value['language_translation_skill_level'] == 3) { ?>
                                        خوب
                                      <?php } elseif ($value['language_translation_skill_level'] == 4) { ?>
                                        عالی
                                      <?php } ?>
                                  </td>
                                  <td>
                                      <?php if ($value['language_certified'] == 1) { ?>
                                        بله
                                      <?php } elseif ($value['language_certified'] == 2) { ?>
                                        خیر
                                      <?php } ?>
                                  </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                              </table>

                            </div>
                        </div>
                      <?php } ?>
                    </div>
                </div>
            </section>

            </body>
            </html>

            <?php
        } else { ?>
            <div style="text-align:center ; font-size:20px ;font-family: Yekan;">No INFORMATION</div><?php
        }
        return $PrintTicket = ob_get_clean();




//            $result = '';
//            $result .= '';

//            return $result;
}




    public function addEmploymentIndexes(array $employmentList) {
        $result = [];

        foreach ($employmentList as $key => $employment) {
            $result[$key] = $employment;
            $time_date = functions::ConvertToDateJalaliInt($employment['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['military_get'] = $this->employmentMilitary->getEmploymentMilitary($employment['military']);
            $result[$key]['last_certificate'] = $this->employmentEducationalCertificate->getEmploymentEducationalCertificate($employment['last_educational_certificate']);
            $result[$key]['request_job'] = $this->employmentRequestJob->getRequestedJob($employment['requested_job']);
        }

        return $result;
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    }

    public function listEmployment()
    {

        $employment_model = $this->getModel('employmentModel');
        $employment_table = $employment_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $employment = $employment_model->get([
            $employment_table.'.*',
            $employment_table . '.id AS eId',
            $employment_table . '.language AS lang',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.module_title' , employment)->orderBy('eId' , 'DESC')->all(false);

        $result = $this->addEmploymentIndexes($employment);
        return $result;
    }


    private function getUserData($params) {
        if (Session::IsLogin()) {
            Load::library('Session');
            $user_id = Session::getUserId();
            $user_info = functions::infoMember($user_id);
            $data['user_id'] = $user_id;
            $data['name'] = $user_info['name'] . ' ' . $user_info['family'];
            $data['email'] = $user_info['email'];
            $data['validate']=0;
        } else {
            $data['user_id'] = 0;
            if (Session::adminIsLogin()) {
                $data['name'] = ' مدیریت '.CLIENT_NAME;
                $data['email'] = CLIENT_EMAIL;
                $data['validate']=1;
            } else {
                $data['name'] = $params['comment_name'];
                $data['email'] = $params['comment_email'];
                $data['validate']=0;
            }
        }
        return $data;
    }

    public function insertEmployment($params) {

        $user_data = $this->getUserData($params);
        $user_id = filter_var($user_data['user_id'], FILTER_SANITIZE_NUMBER_INT);

        $ii = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$ii < 16);
        $uniq = $tmp;
        $f_code = substr($uniq, 0, 10);

        $cooperation_type = '';
        if(isset($params['cooperation_type']) && is_array($params['cooperation_type'])) {
            foreach (@$params['cooperation_type'] as $k => $v) {
                $last_arr[] = $v;
                $cooperation_type = implode($last_arr, ',');
            }
        }

        $dataEmployment = [
            'name' => $params['name'],
            'user_id' => $user_id,
            'birth' => $params['birth'],
            'gender' => $params['gender'],
            'military' => $params['military'],
            'married' => $params['married'],
            'major' => $params['major'],
            'last_educational_certificate' => $params['last_educational_certificate'],
            'email' => $params['email'],
            'mobile' => $params['mobile'],
            'phone' => $params['phone'],
            'city' => $params['city'],
            'address' => $params['address'],
            'requested_job' => $params['requested_job'],
            'requested_salary' => $params['requested_salary'],
            'cooperation_type' => $cooperation_type,
            'language' => SOFTWARE_LANG,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];

        $temp_employment_model = Load::getModel('employmentModel');
        $insert_employment = $this->getModel('employmentModel')->insertWithBind($dataEmployment);
        if ($insert_employment) {
            $last_employment_id = $temp_employment_model->getLastId();
            $data_request = [
                'user_id' => $user_id,
                'module_id' => $last_employment_id,
                'module_title' => 'employment',
                'tracking_code' => $f_code,
            ];
            $temp_model = Load::getModel('requestServiceModel');
            $temp_model->insertWithBind($data_request);

                if(isset($params['experience']) && is_array($params['experience'])){
                    $array_final_experience=array();
                    foreach(@$params['experience'] as $k => $v){
                        foreach($v as $k1 => $v1){
                            $array_final_experience[$k1][$k]=$v1;
                        }
                    }
                    foreach($array_final_experience as $k=> $v){
                        $dataInsertExperience = [
                            'employment_id' => $last_employment_id,
                            'company_post' => $v[0],
                            'company_name' => $v[1],
                            'company_tell' => $v[2],
                            'employment_period' => $v[3],
                            'receive_salary' => $v[4],
                            'reason_left' => $v[5],
                        ];
                        $this->getModel('employmentWorkExperienceModel')->insertWithBind($dataInsertExperience);
                    }
                }

                if(isset($params['skills']) && is_array($params['skills'])){
                    $array_final_skills=array();
                    foreach($params['skills'] as $k => $v){
                        foreach($v as $k1 => $v1){
                            $array_final_skills[$k1][$k]=$v1;
                        }
                    }
                    foreach($array_final_skills as $k=> $v){
                        $dataInsertSkills = [
                            'employment_id' => $last_employment_id,
                            'skill_name' => $v[0],
                            'ability_level' => $v[1],
                        ];
                        $this->getModel('employmentSkillModel')->insertWithBind($dataInsertSkills);
                    }
                }

                if(isset($params['education']) && is_array($params['education'])){
                    $array_final_education=array();
                    foreach(@$params['education'] as $k => $v){
                        foreach($v as $k1 => $v1){
                            $array_final_education[$k1][$k]=$v1;
                        }
                    }
                    foreach($array_final_education as $k=> $v){
                        $dataInsertEducation = [
                            'employment_id' => $last_employment_id,
                            'educational_cross' => $v[0],
                            'educational_field' => $v[1],
                            'educational_name_institution' => $v[2],
                            'educational_institute_location' => $v[3],
                            'educational_start_date' => $v[4],
                            'educational_end_date' => $v[5],
                            'average' => $v[6],
                            'project_title' => $v[7],
                        ];
                        $this->getModel('employmentEducationModel')->insertWithBind($dataInsertEducation);
                    }
                }

                if(isset($params['languages']) && is_array($params['languages'])){
                    $array_final_languages=array();
                    foreach($params['languages'] as $k => $v){
                        foreach($v as $k1 => $v1){
                            $array_final_languages[$k1][$k]=$v1;
                        }
                    }
                    foreach($array_final_languages as $k=> $v){
                        $dataInsertLanguages = [
                            'employment_id' => $last_employment_id,
                            'language_name' => $v[0],
                            'language_conversational_skill_level' => $v[1],
                            'language_correspondence_skill_level' => $v[2],
                            'language_translation_skill_level' => $v[3],
                            'language_certified' => $v[4],
                        ];
                        $this->getModel('employmentLanguageModel')->insertWithBind($dataInsertLanguages);
                    }
                }

            }
        $msg = 'افزودن اطلاعات با موفقیت انجام شد' ."<br>". 'کد پیگیری شما :' .$f_code;
            return self::returnJson(true, $msg);

        return self::returnJson(false, 'خطا در ثبت اطلاعات جدید.', null, 500);

    }

    public function getEmployment($id) {

        $employment_model = $this->getModel('employmentModel');
        $employment_table = $employment_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();
        $request_record = $request_service_model->get()
            ->where('module_id', $id)
            ->where('module_title', employment)
            ->find();
        if ($request_record['status'] == 'not_seen'){
            $dataUpdate = [
                'status' => 'seen',
                'updated_seen_admin_at' => date('Y-m-d H:i:s', time()),
            ];
        $request_service_model->updateWithBind($dataUpdate, ['id' => $request_record['id']]);
    }

        $employment = $employment_model->get([
            $employment_table.'.*',
            $employment_table . '.id AS eId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($employment_table . '.id' , $id)
            ->where($request_service_table . '.module_title' , employment)
            ->find(false);

        $gender = $this->addEmploymentIndexes([$employment])[0]['gender'];
        if ($gender == 1) {
            $gender = 'مرد';
        }elseif ($gender == 2) {
            $gender = 'زن';
        }else {
            $gender = 'وارد نشده';
        }
        $employment['gender'] = $gender;
        $married = $this->addEmploymentIndexes([$employment])[0]['married'];
        if ($married == 1) {
            $married = 'مجرد';
        }elseif ($married == 2) {
            $married = 'متاهل';
        }else {
            $married = 'وارد نشده';
        }
        $employment['married'] = $married;
        $cooperation_type = $this->addEmploymentIndexes([$employment])[0]['cooperation_type'];
        $cooperation_type_c = explode(',', $cooperation_type);
        foreach ($cooperation_type_c as $key => $value) {
            if ($value == 1 ) {
                $type = 'تمام وقت';
            } elseif ($value == 2) {
                $type = 'نیمه وقت';
            }
            $last_arr[] = $type;
            $type = implode($last_arr, ',');
            $employment['cooperation_type'] = $type;
        }
        return $this->addEmploymentIndexes([$employment])[0];

    }

    public function getExperienceList($employmentId){
        $experience_model = $this->getModel('employmentWorkExperienceModel')->get()->where('employment_id', $employmentId);
        $result =  $experience_model->all();
        return  $result;
    }
    public function getSkillsList($employmentId){
        $skill_model = $this->getModel('employmentSkillModel')->get()->where('employment_id', $employmentId);
        $result =  $skill_model->all();
        return($result);
    }
    public function getEducationList($employmentId){
        $education_model = $this->getModel('employmentEducationModel')->get()->where('employment_id', $employmentId);
        $result =  $education_model->all();
        return($result);
    }
    public function getLanguageList($employmentId){
        $language_model = $this->getModel('employmentLanguageModel')->get()->where('employment_id', $employmentId);
        $result =  $language_model->all();
        return($result);
    }

    public function findEmploymentById($id) {
        return $this->getModel('employmentModel')->get()->where('id', $id)->find();
    }

    public function updateEmployment($params) {

        $employment_model = $this->getModel('requestServiceModel');

        $employment = $employment_model->get()
            ->where('id', $params['employment_id'])
            ->find();

        $dataUpdate = [
            'admin_response'  => $params['admin_response'],
            'status'  => $params['status_id'],
            'admin_id'  => CLIENT_ID,
            'updated_at'    => date('Y-m-d H:i:s', time()),
        ];

        $update = $employment_model->updateWithBind($dataUpdate, ['id' => $employment['id']]);


        if ($update) {

            return self::returnJson(true, 'درخواست با موفقیت در سیستم بروزرسانی شد');
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);
    }

    public function deleteEmployment($data) {
        $check_exist_employment= $this->findEmploymentById($data['id']);
        if ($check_exist_employment) {
            $this->getModel('employmentEducationModel')->delete("employment_id='{$data['id']}'");
            $this->getModel('employmentLanguageModel')->delete("employment_id='{$data['id']}'");
            $this->getModel('employmentSkillModel')->delete("employment_id='{$data['id']}'");
            $this->getModel('employmentWorkExperienceModel')->delete("employment_id='{$data['id']}'");
            $this->getModel('requestServiceModel')->delete("module_id='{$data['id']}' AND module_title='employment' ");
            $result_employment = $this->getModel('employmentModel')->delete("id='{$data['id']}'");

            if ($result_employment) {

                return functions::withSuccess('', 200, 'حذف  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }

    public function infoEmployment($trackingCode)
    {

        $employment_model = $this->getModel('employmentModel');
        $employment_table = $employment_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $employment = $employment_model->get([
            $employment_table.'.*',
            $employment_table . '.id AS eId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.tracking_code' , $trackingCode)
            ->where($request_service_table . '.module_title' , employment)
            ->find(false);
        if (!empty($employment)) {
        $gender = $this->addEmploymentIndexes([$employment])[0]['gender'];
        if ($gender == 1) {
            $gender = 'مرد';
        }elseif ($gender == 2) {
            $gender = 'زن';
        }else {
            $gender = 'وارد نشده';
        }
        $employment['gender'] = $gender;
        $married = $this->addEmploymentIndexes([$employment])[0]['married'];
        if ($married == 1) {
            $married = 'مجرد';
        }elseif ($married == 2) {
            $married = 'متاهل';
        }else {
            $married = 'وارد نشده';
        }
        $employment['married'] = $married;
        $cooperation_type = $this->addEmploymentIndexes([$employment])[0]['cooperation_type'];
        $cooperation_type_c = explode(',', $cooperation_type);
        foreach ($cooperation_type_c as $key => $value) {
            if ($value == 1 ) {
                $type = 'تمام وقت';
            } elseif ($value == 2) {
                $type = 'نیمه وقت';
            }
            $last_arr[] = $type;
            $type = implode($last_arr, ',');
            $employment['cooperation_type'] = $type;
        }


    $result = '';
    $result .= '
            <div >
            <table class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>شماره همراه</th>
                    <th>شماره ثابت</th>
                    <th>ایمیل</th>
                    <th>جنسیت</th>
                    <th>وضعیت تاهل</th>
                    <th>تاریخ تولد</th>
                </tr>
                </thead>
                <tbody>
            ';
    $result .= '<tr>';
    $result .= '<td>'.$employment['name'].'</td>';
    $result .= '<td>'.$employment['mobile'].'</td>';
    $result .= '<td>'.$employment['phone'].'</td>';
    $result .= '<td>'.$employment['email'].'</td>';
    $result .= '<td>'.$employment['gender'].'</td>';
    $result .= '<td>'.$employment['married'].'</td>';
    $result .= '<td>'.$employment['birth'].'</td>';
    $result .= '</tr>';
    $result .= '</table>';
    $result .= '</div>';
    $result .= '<hr>';
    $result .= '<div class="container">';
    $result .= '</div>';
    $result .= '<br>';
    $result .= '<br>';
    $result .= '<a  id="myBtn" class="btn btn-primary margin-10"  onclick="SendEmploymentInfo(' . "'" . $employment['sId'] . "'" . ')">مشاهده جزییات و پاسخ ادمین</a>';
    $result .= '';
    return $result;
}

    }

    public function infoEmploymentAll($requestId)
    {
        $employment_model = $this->getModel('employmentModel');
        $employment_table = $employment_model->getTable();
        $request_service_model = $this->getModel('requestServiceModel');
        $request_service_table = $request_service_model->getTable();

        $employment = $employment_model->get([
            $employment_table.'.*',
            $employment_table . '.id AS eId',
            $request_service_table.'.*',
            $request_service_table . '.id AS sId',
        ] ,true)
            ->join($request_service_table, 'module_id', 'id')
            ->where($request_service_table . '.id' , $requestId)
            ->where($request_service_table . '.module_title' , employment)
            ->find(false);

        $gender = $this->addEmploymentIndexes([$employment])[0]['gender'];
        if ($gender == 1) {
            $gender = 'مرد';
        }elseif ($gender == 2) {
            $gender = 'زن';
        }else {
            $gender = 'وارد نشده';
        }
        $employment['gender'] = $gender;
        $married = $this->addEmploymentIndexes([$employment])[0]['married'];
        if ($married == 1) {
            $married = 'مجرد';
        }elseif ($married == 2) {
            $married = 'متاهل';
        }else {
            $married = 'وارد نشده';
        }
        $employment['married'] = $married;
        $cooperation_type = $this->addEmploymentIndexes([$employment])[0]['cooperation_type'];
        $cooperation_type_c = explode(',', $cooperation_type);
        foreach ($cooperation_type_c as $key => $value) {
            if ($value == 1 ) {
                $type = 'تمام وقت';
            } elseif ($value == 2) {
                $type = 'نیمه وقت';
            }
            $last_arr[] = $type;
            $type = implode($last_arr, ',');
            $employment['cooperation_type'] = $type;
        }
        $employmentId = $employment['eId'];
        $experience_model = $this->getModel('employmentWorkExperienceModel')->get()->where('employment_id', $employmentId);
        $experience =  $experience_model->all();


        $skill_model = $this->getModel('employmentSkillModel')->get()->where('employment_id', $employmentId);
        $skill =  $skill_model->all();

        $education_model = $this->getModel('employmentEducationModel')->get()->where('employment_id', $employmentId);
        $education =  $education_model->all();

        $language_model = $this->getModel('employmentLanguageModel')->get()->where('employment_id', $employmentId);
        $language =  $language_model->all();

        $employmentMilitary = Load::controller( 'employmentMilitary' );
        $military   = $employmentMilitary->getEmploymentMilitary( $employment['military'] );

        $employmentEducationalCertificate = Load::controller( 'employmentEducationalCertificate' );
        $educational   = $employmentEducationalCertificate->getEmploymentEducationalCertificate( $employment['last_educational_certificate'] );

        $cityMain = Load::controller( 'mainCity' );
        $city = $cityMain->getCityAll( $employment['city'] );

        $requestedJob = Load::controller( 'employmentRequestedJob' );

        $job_title = $requestedJob->getRequestedJob( $employment['requested_job'] )['title'];

        if (!empty($employment)) {
            $result = '';
            $result .= '
			
				<div class="container-fluid">
				<div class="row employment">
            <div class="container">
            	<div class="modal-header site-bg-main-color  parent-header-form-me">
                    <h4 class="modal-title-request">مشاهده جزییات درخواست همکاری ' . $employment['name'] . '</h4>
                   <div  class="close-modal-me" onclick="removemeNew()">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/></svg>
                   </div>
			       	</div>
            <table class="request-table " cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>متن</th>
                </tr>
                </thead>
                <tbody>
            ';
            $result .= '<tr>';
            $result .= '<td>نام و نام خانوادگی</td>';
            $result .= '<td>' . $employment['name'] . '</td>';
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>تاریخ تولد</td>';
            if ($employment['birth']) {
                $result .= '<td>' . $employment['birth'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>جنسیت</td>';
            if ($employment['gender']) {
                $result .= '<td>' . $employment['gender'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>وضعیت نظام وظیفه</td>';
            if (!empty($military)) {
                foreach ($military as $key => $value) {
                    $result .= '<td>' . $value['title'] . '</td>';
                }
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>وضعیت تاهل</td>';
            if ($employment['married']) {
                $result .= '<td>' . $employment['married'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>رشته تحصیلی</td>';
            if ($employment['major']) {
                $result .= '<td>' . $employment['major'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>آخرین مدرک تحصیلی</td>';
            if (!empty($educational)) {
                foreach ($educational as $key => $value) {
                    $result .= '<td>' . $value['title'] . '</td>';
                }
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>ایمیل</td>';
            if ($employment['email']) {
                $result .= '<td>' . $employment['email'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>شماره همراه</td>';
            if ($employment['mobile']) {
                $result .= '<td>' . $employment['mobile'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>شماره تماس</td>';
            if ($employment['phone']) {
                $result .= '<td>' . $employment['phone'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>استان</td>';
            if (!empty($city)) {
                foreach ($city as $key => $value) {
                    if ($value['id'] == $employment['city'])
                        $result .= '<td>' . $value['name'] . '</td>';
                }
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>آدرس</td>';
            if ($employment['address']) {
                $result .= '<td>' . $employment['address'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>شغل درخواستی</td>';
                        $result .= '<td> '.$job_title.'</td>';
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>حقوق درخواستی</td>';
            if ($employment['requested_salary']) {
                $result .= '<td>' . $employment['requested_salary'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';
            $result .= '<tr>';
            $result .= '<td>نوع همکاری</td>';
            if ($employment['requested_salary']) {
                $result .= '<td>' . $employment['cooperation_type'] . '</td>';
            } else {
                $result .= '<td>---</td>';
            }
            $result .= '</tr>';

            $result .= '</table>';
            $result .= '<hr>';
            $result .= '<br>';

            if (!empty($experience)) {
                $result .= '<h2>لیست سوابق کاری</h2>';
                $result .= '
            <table class="request-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                     <th>عنوان شغل</th>
                    <th>نام شرکت </th>
                    <th>تلفن شرکت</th>
                    <th>مدت اشتغال</th>
                    <th>حقوق دریافتی</th>
                    <th>علت کناره گیری</th>
                </tr>
                </thead>
                <tbody>
            ';
                foreach ($experience as $key => $value) {
                    $result .= '<tr>';
                    $result .= '<td>' . $value[company_name] . '</td>';
                    $result .= '<td>' . $value[company_post] . '</td>';
                    $result .= '<td>' . $value[company_tell] . '</td>';
                    $result .= '<td>' . $value[employment_period] . '</td>';
                    $result .= '<td>' . $value[receive_salary] . '</td>';
                    $result .= '<td>' . $value[reason_left] . '</td>';
                    $result .= '</tr>';
                }
                $result .= '</table>';
            }

            if (!empty($skill)) {
                $result .= '<h2>لیست مهارت ها</h2>';
                $result .= '
       
            <table class="request-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                     <th>نام مهارت</th>
                    <th>میزان توانایی </th>
                </tr>
                </thead>
                <tbody>
            ';
                foreach ($skill as $key => $value) {
                    $result .= '<tr>';
                    $result .= '<td>' . $value[skill_name] . '</td>';
                    if ($value['ability_level'] == 1) {
                        $result .= ' <td>
                           ضعیف
                        </td>';
                    } elseif ($value['ability_level'] == 2) {
                        $result .= ' <td>
                           متوسط
                        </td>';
                    } elseif ($value['ability_level'] == 3) {
                        $result .= ' <td>
                           خوب
                        </td>';
                    } elseif ($value['ability_level'] == 4) {
                        $result .= ' <td>
                           عالی
                        </td>';
                    }
                    $result .= '</tr>';
                }
                $result .= '</table>';

            }

            if (!empty($education)) {
                $result .= '<h2>لیست سوابق تحصیلی </h2>';
                $result .= '
        
            <table class="request-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                     <th>مقطع</th>
                    <th>رشته </th>
                    <th>نام موسسه </th>
                    <th>محل موسسه </th>
                    <th>تاریخ شروع </th>
                    <th>تاریخ خاتمه </th>
                    <th>معدل </th>
                    <th>عنوان مقاله </th>
                </tr>
                </thead>
                <tbody>
            ';

                foreach ($education as $key => $value) {
                    $result .= '<tr>';
                    $result .= '<td>' . $value[educational_cross] . '</td>';
                    $result .= '<td>' . $value[educational_field] . '</td>';
                    $result .= '<td>' . $value[educational_name_institution] . '</td>';
                    $result .= '<td>' . $value[educational_institute_location] . '</td>';
                    $result .= '<td>' . $value[educational_start_date] . '</td>';
                    $result .= '<td>' . $value[educational_end_date] . '</td>';
                    $result .= '<td>' . $value[average] . '</td>';
                    $result .= '<td>' . $value[project_title] . '</td>';
                    $result .= '</tr>';
                }
                $result .= '</table>';

            }
            if (!empty($language)) {
                $result .= '<h2>لیست زبان های خارجی</h2>';
                $result .= '
            <div class="container">
            <table class="request-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>نام زبان</th>
                    <th>سطح مهارت مکالمه </th>
                    <th>سطح مهارت مکاتبه </th>
                    <th>سطح مهارت ترجمه </th>
                    <th>دارای گواهی نامه </th>
                </tr>
                </thead>
                <tbody>
            ';
                foreach ($language as $key => $value) {
                    $result .= '<tr>';
                    $result .= '<td>' . $value[language_name] . '</td>';
                    if ($value['language_conversational_skill_level'] == 1) {
                        $result .= ' <td>
                           ضعیف
                        </td>';
                    } elseif ($value['language_conversational_skill_level'] == 2) {
                        $result .= ' <td>
                           متوسط
                        </td>';
                    } elseif ($value['language_conversational_skill_level'] == 3) {
                        $result .= ' <td>
                           خوب
                        </td>';
                    } elseif ($value['language_conversational_skill_level'] == 4) {
                        $result .= ' <td>
                           عالی
                        </td>';
                    }

                    if ($value['language_correspondence_skill_level'] == 1) {
                        $result .= ' <td>
                           ضعیف
                        </td>';
                    } elseif ($value['language_correspondence_skill_level'] == 2) {
                        $result .= ' <td>
                           متوسط
                        </td>';
                    } elseif ($value['language_correspondence_skill_level'] == 3) {
                        $result .= ' <td>
                           خوب
                        </td>';
                    } elseif ($value['language_correspondence_skill_level'] == 4) {
                        $result .= ' <td>
                           عالی
                        </td>';
                    }

                    if ($value['language_translation_skill_level'] == 1) {
                        $result .= ' <td>
                           ضعیف
                        </td>';
                    } elseif ($value['language_translation_skill_level'] == 2) {
                        $result .= ' <td>
                           متوسط
                        </td>';
                    } elseif ($value['language_translation_skill_level'] == 3) {
                        $result .= ' <td>
                           خوب
                        </td>';
                    } elseif ($value['language_translation_skill_level'] == 4) {
                        $result .= ' <td>
                           عالی
                        </td>';
                    }

                    if ($value['language_certified'] == 1) {
                        $result .= ' <td>
                           بله
                        </td>';
                    } elseif ($value['language_certified'] == 2) {
                        $result .= ' <td>
                           خیر
                        </td>';
                    }

                    $result .= '</tr>';
                }
                $result .= '</table>';
                $result .= '</div>';
                $result .= '</div>';
                $result .= '</div>';
            }

            $result .= '<br>';
            $result .= '<br>';

            if ($employment['status'] == 'not_seen') {
                $result .= "<p class='btn btn-warning' style='margin: 10px 0 10px 0'>کاربری گرامی تاکنون ادمین درخواست شما را مشاهده نکرده است</p>";
            } elseif ($employment['status'] == 'seen') {
                $result .= "<p class='btn btn-primary' style='margin: 10px 0 10px 0'>کاربری گرامی ادمین پیام شما را مشاهده کرده است</p>";
            } elseif ($employment['status'] == 'accept') {
                $result .= "<p class='btn btn-success' style='margin: 10px 0 10px 0'>کاربری گرامی درخواست شما پذیرفته شده است</p>";
            } elseif ($employment['status'] == 'reject') {
                $result .= "<p class='btn btn-danger' style='margin: 10px 0 10px 0'>کاربری گرامی ادمین پیام شما رد شده است</p>";
            }
            $result .= '<hr>';
            $result .= '<div class="d-flex align-items-center">';
            $result .= '<p class="font-20">پاسخ ادمین به درخواست شما :</p>';
            if ($employment['admin_response']) {
                $result .= '<p class="font-20 mr-1">' . $employment['admin_response'] . '</p>';
            }else{
            $result .= '<p class="font-20 mr-1">هنوز پاسخی داده نشده است</p>';
            }
            $result .= '<br style="margin-bottom: 20px">';
            $result .= '</div>';
            $result .= '</div>';
            $result .= '';
            return $result;
        }
    }

}


