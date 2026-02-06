<?php

//if(  $_SERVER['REMOTE_ADDR']=='93.118.161.174'  ) {
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

class lottery extends positions
{
    public $listAll, $listAccess, $noPhotoUrl, $articlesBaseUrl;
    private $lotteriesTb, $services;
    /**
     * @var string
     */
    public $page_limit;
    /**
     * @var string
     */
    private $photoUrl;

    public function __construct() {




        parent::__construct();
        $this->lotteriesTb = 'lotteries';
        $this->page_limit = 6;

        $this->services = Load::controller('services');
//        $this->noPhotoUrl = 'project_files/'. SOFTWARE_LANG .'/images/no-photo.png';
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->photoUrl = ROOT_ADDRESS_WITHOUT_LANG . '/pic/articles/';
        //$this->noPhotoUrl = 'no-photo.jpg';

//        $this->setSection(GDS_SWITCH);



    }


    /**
     * @param $params
     * @return bool
     */
    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $fileName = $fileName.".".$ext;
        return $fileName;
    }

    public function InsertLottery($params) {
        // Log is_prize data for debugging
        if (isset($params['is_prize'])) {
        }
        /** @var lotteryModel $Model */
        $lottery_model = $this->getModel('lotteryModel');
        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');
        $dataInsert = [
            'title' => $params['title'],
            'description' => $params['description'],
            'is_active' => 1,
            'cover_image' => '',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $config = Load::Config('application');
        $path = "lottery/";
        $config->pathFile($path);
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['name'] != "" && $dataInsert['cover_image'] == '') {
            $_FILES['cover_image']['name'] = self::changeNameUpload($_FILES['cover_image']['name']);

            $feature_upload = $config->UploadFile("pic", "cover_image", "5120000");
            $explode_name_pic = explode(':', $feature_upload);

            if ($explode_name_pic[0] == 'done') {
                $feature_image = $path . $explode_name_pic[1];
                $dataInsert['cover_image'] = $feature_image;
            }
        }

        if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {

            $separated_files = functions::separateFiles('gallery_files');
            foreach ($separated_files as $image_key => $separated_file) {
                $_FILES['file'] = '';
                $_FILES['file'] = $separated_file;

                if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                    $_FILES['cover_image'] = $separated_file;
                    $_FILES['cover_image']['name'] = self::changeNameUpload($_FILES['cover_image']['name']);
                    $feature_upload = $config->UploadFile("pic", "cover_image", "5120000");
                    $explode_name_pic = explode(':', $feature_upload);
                    if ($explode_name_pic[0] == 'done') {
                        $feature_image = $path . $explode_name_pic[1];
                        $dataInsert['cover_image'] = $feature_image;
                    }


                }
            }
        }

        $insert = $lottery_model->insertWithBind($dataInsert);
        if ($insert) {

            if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {

                $separated_files = functions::separateFiles('gallery_files');
                foreach ($separated_files as $image_key => $separated_file) {
                    $_FILES['file'] = $separated_file;
                    if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                        $success = $feature_upload;
                    } else {

                        $_FILES['file']['name'] = self::changeNameUpload($_FILES['file']['name']);
                        $success = $config->UploadFile("pic", "file", "5120000");
                    }

                    $explode_name_pic = explode(':', $success);
                    if ($explode_name_pic[0] == "done") {
                        // دریافت is_prize برای این عکس خاص از آرایه
                        $is_prize = isset($params['is_prize'][$image_key]) ? (int)$params['is_prize'][$image_key] : 0;

                        $lottery_gallery_model->insertWithBind([
                            'lottery_id' => $insert,
                            'is_prize' => $is_prize,
                            'image_path' => $path . $explode_name_pic[1],
                        ]);
                    }

                }
            }

            $dataInsert['section'] = $params['section'];
            return self::returnJson(true, 'قرعه کشی با موفقیت در سیستم ثبت شد', $dataInsert);
        }

        return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);


    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $return;
    }

    public function UpdateLottery($params) {
        /** @var application $config */
        /** @var lotteryModel $lottery_model */


        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');
        $lottery_model = $this->getModel('lotteryModel');
        $lottery = $lottery_model->get()
            ->where('id', $params['lottery_id'])
            ->find();

        // آپدیت is_prize برای تصاویر موجود
        if (isset($params['existing_is_prize']) && is_array($params['existing_is_prize'])) {
            foreach ($params['existing_is_prize'] as $gallery_id => $is_prize_value) {
                $lottery_gallery_model->updateWithBind([
                    'is_prize' => (int)$is_prize_value
                ], [
                    'id' => $gallery_id
                ]);
            }
        }

        $dataUpdate = [
            'title' => $params['title'],
            'description' => $params['description'],
            'updated_at' => date('Y-m-d H:i:s', time()),
//                'feature_alt_image' => $params['feature_alt_image'],
        ];


        $config = Load::Config('application');
        $path = "lottery/";
        $config->pathFile($path);

        if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {
            $separated_files = functions::separateFiles('gallery_files');
            foreach ($separated_files as $image_key => $separated_file) {
                $_FILES['file'] = '';
                $_FILES['file'] = $separated_file;

                if ($params['gallery_selected'] && $params['gallery_selected'] == $image_key) {
                    $_FILES['image_path'] = $separated_file;
//                        $params['feature_alt_image'] = $params['gallery_file_alts'][$image_key];
                    $_FILES['image_path']['name'] = self::changeNameUpload($_FILES['image_path']['name']);
                    $feature_upload = $config->UploadFile("pic", "image_path", "5120000");
                    $explode_name_pic = explode(':', $feature_upload);
                    if ($explode_name_pic[0] == 'done') {
                        $feature_image = $path . $explode_name_pic[1];
                        $dataUpdate['image_path'] = $feature_image;
//                            $dataUpdate['feature_alt_image'] = $params['feature_alt_image'];
                    }

                } else {
                    $_FILES['file']['name'] = self::changeNameUpload($_FILES['file']['name']);
                    $success = $config->UploadFile("pic", "file", 5120000);
                    $explode_name_pic = explode(':', $success);
                }


                if ($explode_name_pic[0] == "done") {
                    // دریافت is_prize برای این عکس خاص از آرایه
                    $is_prize = isset($params['is_prize'][$image_key]) ? (int)$params['is_prize'][$image_key] : 0;

                    $lottery_gallery_model->insertWithBind([
                        'lottery_id' => $params['lottery_id'],
                        'is_prize' => $is_prize,
                        'image_path' => 'lottery/' . $explode_name_pic[1],
//                            'alt' => $params['gallery_file_alts'][$image_key],
                    ]);
                }

            }
        }


        if (isset($_FILES['cover_image']) && $_FILES['cover_image'] != "" && $dataUpdate['cover_image'] == '') {
            $_FILES['cover_image']['name'] = self::changeNameUpload($_FILES['cover_image']['name']);
            $feature_upload = $config->UploadFile("pic", "cover_image", "5120000");
            $explode_name_pic = explode(':', $feature_upload);

            if ($explode_name_pic[0] == 'done') {
                $feature_image = $path . $explode_name_pic[1];
                $dataUpdate['cover_image'] = $feature_image;
//                    $dataUpdate['feature_alt_image'] = $params['feature_alt_image'];
            }
        }


        if ($params['previous_gallery_selected']) {
            $check_exist = $lottery_gallery_model->get()
                ->where('id', $params['previous_gallery_selected'])
                ->find();
            if ($check_exist) {
                $dataUpdate['cover_image'] = $check_exist['file'];
//                    $dataUpdate['feature_alt_image'] = $check_exist['alt'];


            }

        }


        if ($params['previous_gallery_file_alts']) {
            foreach ($params['previous_gallery_file_alts'] as $key => $alt) {
                $lottery_gallery_model->updateWithBind([
                    'alt' => $alt
                ], [
                    'id' => $key
                ]);
            }
        }

        $update = $lottery_model->updateWithBind($dataUpdate, ['id' => $params['lottery_id']]);

        if($update){
            return functions::JsonSuccess($dataUpdate, 'اطلاعات با موفقیت ویرایش گردید');

        }else{
            return self::returnJson(false, 'خطا در ثبت اطلاعات در سیستم.', null, 500);

        }



    }

    public function getAdminLotteries($section) {

        $lottery_model = $this->getModel('lotteryModel');
        $lottery_table = $lottery_model->getTable();


        $lotteries = $lottery_model
            ->get([
                $lottery_table . '.*',
            ], true);

        $lotteries = $lotteries
            ->where($lottery_table . '.deleted_at', null, 'IS');


        $lotteries = $lotteries->all(false);

        return $lotteries;
    }

    public function getAdminUserListLotteries($section = null) {
        $lottery_participants_model = $this->getModel('lotteryParticipantsModel');
        $members_model = $this->getModel('membersModel');
        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');

        $participants_table = $lottery_participants_model->getTable(); // lottery_participants
        $members_table = $members_model->getTable();                   // members_tb
        $gallery_table = $lottery_gallery_model->getTable();           // lottery_gallery


        $result = $lottery_participants_model
            ->get([
                "{$participants_table}.*",
                "{$members_table}.*",
                "{$gallery_table}.*",
            ], true)

            ->join(
                $gallery_table,
                'id',                    // PK در gallery
                'lottery_gallery_id',    // FK در participants
                'INNER'
            )

            // JOIN members_tb
            ->join(
                $members_table,          // جدول مقصد
                'id',                    // PK در members
                'user_id',               // FK در participants
                'INNER'
            )

            ->where($participants_table . '.lottery_id', (int) $_GET['id'])
            ->all(false);

        return $result;
    }


    /**
     * @param array $lotteries
     * @return array
     * @return array
     */

    /**
     * @param $lottery_id
     * @return array
     */


    public function lotteryGallery($lottery_id) {
        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');
        $model = $this->getModel('lotteryModel');
        $data = $lottery_gallery_model->get()
            ->where('lottery_id', $lottery_id)
            ->all();
        $lottery = $model->get()
            ->where('id', $lottery_id)
            ->find();

        $result = [];
        foreach ($data as $key => $item) {
            $file_path = isset($item['image_path']) ? $item['image_path'] : $item['file'];
            if($lottery['cover_image'] != $file_path) {
                $result[] = [
                    'src' => SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/' . $file_path,
                    'alt' => $item['alt'] ?: 'gallery image ' . $key,
                    'id' => $item['id'],
                    'is_prize' => isset($item['is_prize']) ? $item['is_prize'] : 0,
                ];
            }

        }
        return $result;
    }


    public function getLotteries($section, $page = null , $order = null) {
        $lottery_model = $this->getModel('lotteryModel');
        $lottery_count_model = $this->getModel('lotteryModel');
        $lottery_table = $lottery_model->getTable();



        $lottery_count = $lottery_count_model
            ->get([
                'count(' . $lottery_table . '.id) as count',
            ], true);


        $lotteries = $lottery_model
            ->get([
                $lottery_table . '.*',
            ], true);

        $lotteries = $lotteries
            ->where($lottery_table . '.deleted_at', null, 'IS');


        $count = $lottery_count->find();

        $result['items_count'] = $count['count'];
        $result['per_page'] = $this->page_limit;
        $result['count'] = ceil($count['count'] / $this->page_limit);
        $result['current_page'] = ROOT_ADDRESS . '/' . $section . '?page=' . $page;

        for ($x = 0; $x < $result['count']; $x++) {
            $count = ($x + 1);
            $result['links'][] = [
                'index' => $count,
                'link' => ROOT_ADDRESS . '/' . $section . '?page=' . $count
            ];
        }



        if ($page) {
            $offset = ($page - 1) * $this->page_limit;
            $lotteries = $lotteries->limit($offset, $this->page_limit);
        }


        $lotteries = $lotteries->all(false);

        $result['data'] = $lotteries;
        return $result;
    }


    public function GetLotteryGalleryData($params) {
        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');

        $data = $lottery_gallery_model->get()
            ->where('lottery_id', $params['lottery_id'])
            ->all();

        return $this->returnJson(true, true, $data);
    }

    public function RemoveSingleGallery($Param) {
        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');

        $check_exist = $lottery_gallery_model->get()
            ->where('id', $Param['GalleryId'])
            ->find();

        if ($check_exist) {
            $lottery_gallery_model->delete([
                'id' => $check_exist['id']
            ]);
            unlink(PIC_ROOT . 'lottery/' . $check_exist['file']);
        }

        return $this->returnJson(true, 'حذف شد', $check_exist['id']);
    }
//
    public function addToGallery($info) {
        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');


        if (isset($_FILES['file']) && $_FILES['file'] != "") {
            $config = Load::Config('application');
            $config->pathFile('lottery/');
            $_FILES['file']['name'] = self::changeNameUpload($_FILES['file']['name']);
            $success = $config->UploadFile("pic", "file", 5120000);
            $explode_name_pic = explode(':', $success);

            if ($explode_name_pic[0] == "done") {

                $check_exist = $lottery_gallery_model->get()
                    ->where('lottery_id', $info['id'])
                    ->where('image_path', $explode_name_pic[1])
                    ->find();

                if ($check_exist) {
                    $lottery_gallery_model->delete([
                        'id' => $check_exist['id']
                    ]);
                }
                $insert_result = $lottery_gallery_model->insertWithBind([
                    'lottery_id' => $info['id'],
                    'image_path' => 'lottery/' .  $explode_name_pic[1],
                ]);
                if ($insert_result) {
                    return $this->returnJson(true, 'ثبت گالری با موفقیت انجام شد', $insert_result);
                }
                return $this->returnJson(false, 'خطا در فرایند ثبت گالری');
            }
        }
    }

    public function updateGallery($info) {
        $lottery_gallery_model = $this->getModel('lotteryGalleryModel');

        $image = $lottery_gallery_model
            ->get()
            ->where('id', $info['id'])
            ->find();
        if ($image) {
            $alt = filter_var($info['alt'], FILTER_SANITIZE_STRING);
            $update_result = $lottery_gallery_model->updateWithBind([
                'alt' => $alt
            ], [
                'id' => $image['id']
            ]);

            if ($update_result) {
                return $this->returnJson(true, 'ویرایش گالری با موفقیت انجام شد', $update_result);
            }
            return $this->returnJson(false, 'خطا در فرایند ویرایش گالری');
        }
    }


    public function DeleteLottery($formData = []) {

        if (!isset($formData['id'])) {
            return self::returnJson(false, 'قرعه کشی مورد نظر یافت نشد', null, 404);
        }
        $lottery_model = Load::getModel('lotteryModel');
        $lottery_gallery_model = Load::getModel('lotteryGalleryModel');

        $delete = [
            'deleted_at' => date('Y-m-d H:i:s', time()),
        ];

        $lottery_gallery_model->delete("lottery_id='{$formData['id']}'");

        if ($lottery_model->updateWithBind($delete, "id='{$formData['id']}'")) {
            return self::returnJson(true, 'قرعه کشی با موفقیت حذف شد');
        }

        return self::returnJson(false, 'خطا در حذف اطلاعات', null, 400);
    }

    public function getLottery($id) {

        $lottery_model = $this->getModel('lotteryModel');
        $lottery_table = $lottery_model->getTable();

        $lottery = $lottery_model
            ->get(
                [
                    $lottery_table . '.*',
                ], true
            )
            ->where($lottery_table . '.id', $id)->where($lottery_table . '.deleted_at', null, 'IS')
//            ->where($article_table . '.language' , SOFTWARE_LANG)
            ->find(false);




        if ($lottery) {
            $lottery['gallery'] = $this->lotteryGallery($id);
        }

        return $lottery;
    }

    public function deleteArticleImage($data_delete) {

        $check_exist_lottery =  $this->getModel('lotteryModel')->get()->where('id', $data_delete['id'])->find();
        if ($check_exist_lottery) {
            if($check_exist_lottery['cover_image'] != ''){
                $path = PIC_ROOT.$check_exist_lottery['cover_image'];
                unlink($path);
                $data = [
                    'cover_image' => ''
                ];
                $update = $this->getModel('lotteryModel')->updateWithBind($data, ['id' => $data_delete['id']]);
                if ($update) {
                    return functions::withSuccess('', 200, 'حذف تصویر  با موفقیت انجام شد');
                }
            }
        }

    }

//
//    public function apiGetArticle($params) {
//        $result = $this->getByPosition($params);
//        return functions::withSuccess($result);
//    }

    // ========================================
    // LOTTERY OTP SYSTEM
    // ========================================

    /**
     * Request OTP - Generate and send OTP via SMS
     *
     * @param array $params ['phone' => '09123456789']
     * @return string JSON response
     */
    public function requestOtp($params) {
        try {
            // Validate phone number
            $phone = isset($params['phone']) ? trim($params['phone']) : '';

            if (empty($phone)) {
                return $this->jsonResponse(false, 'شماره موبایل الزامی است', null, 400);
            }

            // Validate Iranian phone format
            if (!preg_match('/^09[0-9]{9}$/', $phone)) {
                return $this->jsonResponse(false, 'فرمت شماره موبایل صحیح نیست', null, 400);
            }

            // Generate 4-digit OTP
            $otp = $this->generateOtp();

            // Store OTP in database
            if (!$this->storeOtp($phone, $otp)) {
                return $this->jsonResponse(false, 'خطا در ذخیره کد تأیید', null, 500);
            }

            // Send SMS using existing SMS service
            $smsSent = $this->sendOtpSms($phone, $otp);
//            $smsSent = true;

            if (!$smsSent) {
                return $this->jsonResponse(false, 'خطا در ارسال پیامک', null, 500);
            }

            // Log for debugging


            return $this->jsonResponse(true, 'کد تأیید با موفقیت ارسال شد', [
                'phone' => $phone,
                'expires_in_seconds' => 120
            ], 200);

        } catch (Exception $e) {

            return $this->jsonResponse(false, 'خطای سیستمی رخ داده است', null, 500);
        }
    }


    /**
     * Verify OTP - Validate OTP and register/login user
     *
     * @param array $params ['phone' => '09123456789', 'code' => '1234']
     * @return string JSON response with user data and prize
     */
    public function verifyOtp($params) {

        try {


            // Validate inputs
            $phone = isset($params['phone']) ? trim($params['phone']) : '';
            $code = isset($params['code']) ? trim($params['code']) : '';

            if (empty($phone) || empty($code)) {
                return $this->jsonResponse(false, 'شماره موبایل و کد تأیید الزامی است', null, 400);
            }

            // Validate code format (4 digits)
            if (!preg_match('/^[0-9]{4}$/', $code)) {
                return $this->jsonResponse(false, 'کد تأیید باید 4 رقم باشد', null, 400);
            }

            // Validate OTP using verificationCode style
            $validationResult = $this->validateOtpCode($phone, $code);

            if (!$validationResult['status']) {
                $message = isset($validationResult['message']) ? $validationResult['message'] : 'کد تأیید نامعتبر است';

                // Translate message
                if ($message === 'optExpired') {
                    $message = 'کد تأیید منقضی شده و کد جدید ارسال شد';
                }

                return $this->jsonResponse(false, $message, null, 401);
            }

            // OTP is valid - Register or get existing user
            $user = $this->registerOrGetUser($phone);

            if (!$user) {
                return $this->jsonResponse(false, 'خطا در ثبت نام کاربر', null, 500);
            }

            // دریافت lottery_id از پارامترها
            $lotteryId = isset($params['lottery_id']) ? (int) $params['lottery_id'] : null;

            // اگر lottery_id مشخص نشده، از آخرین لاتاری فعال استفاده می‌شود
            if (!$lotteryId) {
                $lotteryModel = $this->getModel('lotteryModel');
                $latestLottery = $lotteryModel->get()
                    ->where('deleted_at', null, 'IS')
                    ->where('is_active', 1)
                    ->orderBy('id', 'DESC')
                    ->find();
                $lotteryId = $latestLottery ? $latestLottery['id'] : 1;
            }

            // محاسبه موقعیت شرکت‌کننده (تعداد شرکت‌کنندگان فعلی + 1)
            $participantsModel = $this->getModel('lotteryParticipantsModel');

            // روش اول: استفاده از count (اگر در دسترس باشد)
            try {
                $participants = $participantsModel->get()
                    ->where('lottery_id', $lotteryId)
                    ->all();
                $currentParticipantsCount = is_array($participants) ? count($participants) : 0;
            } catch (Exception $e) {
                // روش جایگزین: استفاده از SQL خام
                $Model = Load::library('Model');
                $sql = "SELECT COUNT(*) as total FROM lottery_participants WHERE lottery_id = '{$lotteryId}'";
                $result = $Model->load($sql);
                $currentParticipantsCount = isset($result['total']) ? (int)$result['total'] : 0;
            }

            $participantPosition = $currentParticipantsCount + 1;

            // انتخاب جایزه بر اساس موقعیت و احتمال
            $prize = $this->selectRandomPrize($lotteryId, $participantPosition);

            if (!$prize) {
                return $this->jsonResponse(false, 'خطا در انتخاب جایزه', null, 500);
            }
            // Log participation
            $result = $this->logLotteryParticipation($user['id'], $lotteryId, $prize['id']);

            if ($result === 'already_exists') {
                return $this->jsonResponse(false, 'شما قبلاً در این قرعه‌کشی شرکت کرده‌اید', null, 409);
            }

            if ($result !== true) {
                return $this->jsonResponse(false, 'خطا در ثبت شرکت در قرعه‌کشی', null, 500);
            }
            // Return success with user and prize data
            return $this->jsonResponse(true, 'ورود موفقیت‌آمیز بود', [
                'user' => [
                    'id' => $user['id'],
                    'phone' => $user['phone'],
                    'registered_at' => $user['created_at']
                ],
                'prize' => $prize
            ], 200);

        } catch (Exception $e) {

            return $this->jsonResponse(false, 'خطای سیستمی رخ داده است', null, 500);
        }
    }

    // ========================================
    // PRIVATE HELPER METHODS
    // ========================================

    /**
     * Generate random 4-digit OTP
     *
     * @return string 4-digit OTP
     */
    private function generateOtp() {
        return str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store OTP in database (similar to verificationCode::store)
     *
     * @param string $phone
     * @param string $code
     * @return bool
     */
    private function storeOtp($phone, $code) {
        try {
            $Model = Load::library('Model');
            $Model->setTable('verification_codes_tb');

            $otpData = [
                'entry' => $phone,
                'code' => $code,
                'status' => 'unused',
                'created_at' => date('Y-m-d H:i:s')
            ];

            return $Model->insertLocal($otpData);

        } catch (Exception $e) {

            return false;
        }
    }

    /**
     * Validate OTP code (similar to verificationCode::validateCode)
     *
     * @param string $phone
     * @param string $code
     * @return array ['status' => bool, 'message' => string]
     */
    private function validateOtpCode($phone, $code) {
        try {
            $Model = Load::library('Model');
            $Model->setTable('verification_codes_tb');

            // Get OTP record
            $sql = "SELECT * FROM verification_codes_tb
                    WHERE entry = '{$phone}'
                    AND code = '{$code}'
                    AND status = 'unused'
                    ORDER BY created_at DESC
                    LIMIT 1";

            $validateRecord = $Model->load($sql);

            if (!$validateRecord) {
                return [
                    'status' => false,
                    'message' => 'کد تأیید نامعتبر است'
                ];
            }

            // Check if expired (2 minutes)
            if ($this->isOtpExpired($validateRecord['created_at'], 2)) {
                // Mark as expired
                $this->changeOtpStatus($validateRecord['id'], 'expired');

                // Send new OTP
                $newOtp = $this->generateOtp();
                $this->storeOtp($phone, $newOtp);
                $this->sendOtpSms($phone, $newOtp);

                return [
                    'status' => false,
                    'message' => 'optExpired'
                ];
            }

            // Mark as used
            $this->changeOtpStatus($validateRecord['id'], 'used');

            return [
                'status' => true
            ];

        } catch (Exception $e) {

            return [
                'status' => false,
                'message' => 'خطا در اعتبارسنجی'
            ];
        }
    }

    /**
     * Check if OTP is expired (similar to verificationCode::isExpired)
     *
     * @param string $created_at
     * @param int $validTime Minutes
     * @return bool
     */
    private function isOtpExpired($created_at, $validTime = 2) {
        $current_time = time();
        $created_at_time = strtotime($created_at);
        $time_diff_minutes = ($current_time - $created_at_time) / 60;

        return $time_diff_minutes >= $validTime;
    }

    /**
     * Change OTP status (similar to verificationCode::changeStatus)
     *
     * @param int $id
     * @param string $status (unused, used, expired)
     * @return bool
     */
    private function changeOtpStatus($id, $status) {
        try {
            $Model = Load::library('Model');
            $Model->setTable('verification_codes_tb');

            return $Model->update([
                'status' => $status
            ], "id = '{$id}'");

        } catch (Exception $e) {

            return false;
        }
    }

    /**
     * Send OTP via SMS using existing SMS service (similar to verificationCode::create)
     *
     * @param string $phone
     * @param string $otp
     * @return bool Success status
     */
    private function sendOtpSms($phone, $otp) {
        try {
            // Initialize SMS controller
            $smsController = Load::controller('smsServices');
            $objSms = $smsController->initService('0', CLIENT_ID); // '0' means auto-select service

            if (!$objSms) {
                return false;
            }

            // Get verification code pattern
            $verification_pattern = $smsController->getPattern('verification_code');

            // Get pattern message
            $params = [
                'code' => 'registerLogin',
                'param1' => $otp
            ];
            $patternMessage = Load::controller('patternMessage');
            $pattern_message = $patternMessage->getPatternMessage($params);

            // Send via pattern if available
            if ($verification_pattern) {
                $smsArray = [
                    'data' => ['verification_code' => $otp],
                    'cellNumber' => $phone,
                    'code' => $verification_pattern['pattern'],
                    'smsMessage' => $pattern_message
                ];

                $result = $smsController->smsSendPattern($smsArray);



                return true;
            }

            // Fallback: send simple SMS
            $smsMessage = "کد تأیید قرعه‌کشی: {$otp}\nاین کد تا 2 دقیقه معتبر است.";

            $smsArray = [
                'smsMessage' => $smsMessage,
                'cellNumber' => $phone
            ];

            $result = $smsController->sendSMS($smsArray);



            return true;

        } catch (Exception $e) {

            return false;
        }
    }

    /**
     * Register new user or get existing user by phone
     *
     * @param string $phone
     * @return array|false User data or false on failure
     */
    private function registerOrGetUser($phone) {
        try {
            $Model = Load::library('Model');

            // Check if user already exists
            $Model->setTable('members_tb');
            $sql = "SELECT * FROM members_tb WHERE mobile = '{$phone}' LIMIT 1";
            $existingUser = $Model->load($sql);

            if ($existingUser) {
                // User exists - return existing user
                return [
                    'id' => $existingUser['id'],
                    'phone' => $existingUser['mobile'],
                    'created_at' => $existingUser['register_date']
                ];
            }

            // User doesn't exist - create new user
            $userData = [
                'name' => '-',
                'family' => '-',
                'name_en' => '-',
                'family_en' => '-',
                'national_type' => '',
                'national_code' => '0000000000',
                'passport_country_code' => 0,
                'mobile' => $phone,
                'user_name' => 'user_' . $phone,
                'password' => password_hash($phone, PASSWORD_DEFAULT),
                'birthday' => '0000-00-00',
                'birthday_en' => '0000-00-00',
                'expire_passport_ir' => '0000-00-00',
                'expire_passport_en' => '0000-00-00',
                'address' => '-',
                'card_number' => 0,
                'is_member' => 0,
                'fk_counter_type_id' => 5,
                'fk_agency_id' => 0,
                'TypeOs' => 'web',
                'is_login_app' => 0,
                'register_date' => date('Y-m-d H:i:s'),
                'active' => 'on',
            ];

            $Model->setTable('members_tb');
            $res = $Model->insertLocal($userData);
            $userId = $Model->getLastId();

            if (!$res) {
                return false;
            }

            return [
                'id' => $userId,
                'phone' => $phone,
                'created_at' => $userData['register_date']
            ];

        } catch (Exception $e) {

            return false;
        }
    }

//    /**
//     * Select random prize based on is_prize probability distribution
//     *
//     * این متد احتمال برد را بر اساس نسبت تصاویر جایزه محاسبه می‌کند:
//     * - فرمول احتمال: (تعداد تصاویر is_prize=1) / (تعداد تصاویر is_prize=0) * 100
//     * - برای هر 100 شرکت‌کننده، تعداد برنده بر اساس این نسبت تعیین می‌شود
//     * - پس از هر 100 نفر، چرخه جدیدی شروع شده و دوباره همان احتمال اعمال می‌شود
//     *
//     * @param int|null $lotteryId شناسه قرعه‌کشی (اختیاری - اگر ارسال نشود از آخرین lottery استفاده می‌شود)
//     * @param int|null $participantPosition موقعیت شرکت‌کننده (1-based index)
//     * @return array|false اطلاعات جایزه انتخاب شده یا false در صورت خطا
//     */
//    private function selectRandomPrize($lotteryId = null, $participantPosition = null) {
//        try {
//            $lotteryGalleryModel = $this->getModel('lotteryGalleryModel');
//
//            // اگر lottery_id مشخص نشده، از آخرین lottery فعال استفاده کن
//            if (!$lotteryId) {
//                $lotteryModel = $this->getModel('lotteryModel');
//                $latestLottery = $lotteryModel->get()
//                    ->where('deleted_at', null, 'IS')
//                    ->where('is_active', 1)
//                    ->orderBy('id', 'DESC')
//                    ->find();
//                $lotteryId = $latestLottery ? $latestLottery['id'] : 1;
//            }
//
//            // STEP 1: شمارش تصاویر جایزه (is_prize = 1)
//            $prizeImages = $lotteryGalleryModel->get()
//                ->where('lottery_id', $lotteryId)
//                ->where('is_prize', 1)
//                ->all();
//
//            // STEP 2: شمارش تصاویر غیر جایزه (is_prize = 0)
//            $nonPrizeImages = $lotteryGalleryModel->get()
//                ->where('lottery_id', $lotteryId)
//                ->where('is_prize', 0)
//                ->all();
//
//            // اطمینان از اینکه آرایه‌ها معتبر هستند
//            $prizeImages = is_array($prizeImages) ? $prizeImages : [];
//            $nonPrizeImages = is_array($nonPrizeImages) ? $nonPrizeImages : [];
//
//            $prizeCount = count($prizeImages);
//            $nonPrizeCount = count($nonPrizeImages);
//
//            // بررسی وجود تصاویر جایزه
//            if ($prizeCount === 0) {
//                functions::insertLog(
//                    'No prize images (is_prize=1) found for lottery_id: ' . $lotteryId,
//                    'lottery_no_prizes_error'
//                );
//                // Fallback: برگرداندن اولین تصویر موجود
//                $anyImage = $lotteryGalleryModel->get()
//                    ->where('lottery_id', $lotteryId)
//                    ->find();
//                return $anyImage ?: false;
//            }
//
//            // اگر هیچ تصویر غیر جایزه نداریم، از تعداد کل استفاده می‌کنیم
//            if ($nonPrizeCount === 0) {
//                $allImages = $lotteryGalleryModel->get()
//                    ->where('lottery_id', $lotteryId)
//                    ->all();
//                $nonPrizeCount = max(count($allImages) - $prizeCount, 1); // حداقل 1
//            }
//
//            // STEP 3: محاسبه نسبت برد
//            // فرمول: (تعداد جوایز / تعداد غیر جوایز) * 100
//            $winProbabilityPercentage = ($prizeCount / $nonPrizeCount) * 5;
//
//            // STEP 4: محاسبه تعداد برنده در هر 100 نفر
//            $winnersPerHundred = round($winProbabilityPercentage);
//            // اطمینان از اینکه حداقل 1 برنده و حداکثر 100 برنده داریم
//            $winnersPerHundred = max(1, min(5, $winnersPerHundred));
//
//            // STEP 5: تعیین موقعیت شرکت‌کننده در چرخه 100 نفره
//            if ($participantPosition === null) {
//                // اگر موقعیت مشخص نشده، از تعداد شرکت‌کنندگان فعلی + 1 استفاده کن
//                $participantsModel = $this->getModel('lotteryParticipantsModel');
//                try {
//                    $participants = $participantsModel->get()
//                        ->where('lottery_id', $lotteryId)
//                        ->all();
//                    $currentCount = is_array($participants) ? count($participants) : 0;
//                } catch (Exception $e) {
//                    $Model = Load::library('Model');
//                    $sql = "SELECT COUNT(*) as total FROM lottery_participants WHERE lottery_id = '{$lotteryId}'";
//                    $result = $Model->load($sql);
//                    $currentCount = isset($result['total']) ? (int)$result['total'] : 0;
//                }
//                $participantPosition = $currentCount + 1;
//            }
//
//            // STEP 6: محاسبه موقعیت در چرخه جاری (1 تا 100)
//            $positionInCycle = (($participantPosition - 1) % 5) + 1;
//            $cycleNumber = ceil($participantPosition / 5);
//
//            // STEP 7: تولید یا دریافت موقعیت‌های برنده برای این چرخه
//            $winningPositions = $this->generateWinningPositionsForCycle(
//                $lotteryId,
//                $cycleNumber,
//                $winnersPerHundred
//            );
//
//            // STEP 8: بررسی آیا این شرکت‌کننده برنده است
//            $isWinner = in_array($positionInCycle, $winningPositions);
//
//            // STEP 9: انتخاب تصویر مناسب
//            if ($isWinner) {
//                // برنده است - یک جایزه تصادفی انتخاب کن
//                if (!empty($prizeImages)) {
//                    $randomPrizeIndex = array_rand($prizeImages);
//                    $selectedImage = $prizeImages[$randomPrizeIndex];
//                } else {
//                    // Fallback: اگر جایزه‌ای نداریم، اولین تصویر موجود را برگردان
//                    functions::insertLog('No prize images available in winner selection', 'lottery_error');
//                    $anyImage = $lotteryGalleryModel->get()
//                        ->where('lottery_id', $lotteryId)
//                        ->find();
//                    return $anyImage ?: false;
//                }
//
//                // Log اطلاعات برنده
//                functions::insertLog(
//                    json_encode([
//                        'lottery_id' => $lotteryId,
//                        'participant_position' => $participantPosition,
//                        'cycle_number' => $cycleNumber,
//                        'position_in_cycle' => $positionInCycle,
//                        'is_winner' => true,
//                        'prize_id' => $selectedImage['id'],
//                        'win_probability' => round($winProbabilityPercentage, 2) . '%',
//                        'winners_per_hundred' => $winnersPerHundred
//                    ]),
//                    'lottery_winner_selected'
//                );
//            } else {
//                // برنده نیست - یک تصویر غیر جایزه انتخاب کن
//                if (!empty($nonPrizeImages)) {
//                    $randomIndex = array_rand($nonPrizeImages);
//                    $selectedImage = $nonPrizeImages[$randomIndex];
//                } elseif (!empty($prizeImages)) {
//                    // اگر تصویر غیر جایزه نداریم، از جوایز استفاده کن
//                    $randomIndex = array_rand($prizeImages);
//                    $selectedImage = $prizeImages[$randomIndex];
//                } else {
//                    // Fallback نهایی
//                    functions::insertLog('No images available for non-winner', 'lottery_error');
//                    $anyImage = $lotteryGalleryModel->get()
//                        ->where('lottery_id', $lotteryId)
//                        ->find();
//                    return $anyImage ?: false;
//                }
//
//                // Log اطلاعات غیر برنده
//                functions::insertLog(
//                    json_encode([
//                        'lottery_id' => $lotteryId,
//                        'participant_position' => $participantPosition,
//                        'cycle_number' => $cycleNumber,
//                        'position_in_cycle' => $positionInCycle,
//                        'is_winner' => false,
//                        'image_id' => $selectedImage['id']
//                    ]),
//                    'lottery_participant_result'
//                );
//            }
//
//            return $selectedImage;
//
//        } catch (Exception $e) {
//            functions::insertLog(
//                json_encode([
//                    'error' => $e->getMessage(),
//                    'trace' => $e->getTraceAsString(),
//                    'lottery_id' => $lotteryId,
//                    'participant_position' => $participantPosition
//                ]),
//                'lottery_prize_selection_error'
//            );
//
//            // Fallback: برگرداندن اولین جایزه موجود
//            $Model = Load::library('Model');
//            $sql = "SELECT * FROM lottery_gallery WHERE lottery_id = '{$lotteryId}' AND is_prize = 1 LIMIT 1";
//            $fallbackPrize = $Model->load($sql);
//            return $fallbackPrize ?: false;
//        }
//    }
//
//    /**
//     * تولید یا دریافت موقعیت‌های برنده برای یک چرخه خاص
//     *
//     * این متد اطمینان می‌دهد که برای هر چرخه 100 نفره، موقعیت‌های برنده
//     * یکبار به صورت تصادفی تولید و ذخیره می‌شوند و برای تمام شرکت‌کنندگان
//     * همان چرخه، از همان موقعیت‌ها استفاده می‌شود
//     *
//     * @param int $lotteryId شناسه قرعه‌کشی
//     * @param int $cycleNumber شماره چرخه (1، 2، 3، ...)
//     * @param int $winnerCount تعداد برنده در این چرخه
//     * @return array آرایه موقعیت‌های برنده (اعداد بین 1 تا 100)
//     */
//    private function generateWinningPositionsForCycle($lotteryId, $cycleNumber, $winnerCount) {
//        // استفاده از static cache برای جلوگیری از کوئری‌های مکرر
//        static $cache = [];
//        $cacheKey = "lottery_{$lotteryId}_cycle_{$cycleNumber}";
//
//        // چک کردن cache حافظه
//        if (isset($cache[$cacheKey])) {
//            return $cache[$cacheKey];
//        }
//
//        // OPTION 1: استفاده از seed تصادفی قابل تکرار
//        // با استفاده از lottery_id و cycle_number به عنوان seed، می‌توانیم
//        // نتایج تصادفی یکسانی برای همان چرخه تولید کنیم
//        $seed = $lotteryId * 1000000 + $cycleNumber;
//        mt_srand($seed);
//
//        // تولید آرایه‌ای از اعداد 1 تا 100
//        $allPositions = range(1, 5);
//
//        // مخلوط کردن با استفاده از seed
//        for ($i = count($allPositions) - 1; $i > 0; $i--) {
//            $j = mt_rand(0, $i);
//            $temp = $allPositions[$i];
//            $allPositions[$i] = $allPositions[$j];
//            $allPositions[$j] = $temp;
//        }
//
//        // انتخاب تعداد مورد نیاز از موقعیت‌های برنده
//        $winningPositions = array_slice($allPositions, 0, $winnerCount);
//        sort($winningPositions); // مرتب‌سازی برای خوانایی بهتر
//
//        // بازگرداندن seed به حالت تصادفی واقعی
//        mt_srand();
//
//        // ذخیره در cache
//        $cache[$cacheKey] = $winningPositions;
//
//        // Log برای debug
//        functions::insertLog(
//            json_encode([
//                'lottery_id' => $lotteryId,
//                'cycle_number' => $cycleNumber,
//                'winner_count' => $winnerCount,
//                'winning_positions' => $winningPositions,
//                'seed_used' => $seed
//            ]),
//            'lottery_cycle_positions_generated'
//        );
//
//        return $winningPositions;
//    }
//
//    /**
//     * دریافت لیست کامل برندگان یک قرعه‌کشی
//     *
//     * این متد تمام شرکت‌کنندگان را تجزیه و تحلیل کرده و لیستی از
//     * برندگان با جوایز مرتبطشان را برمی‌گرداند
//     *
//     * @param int $lotteryId شناسه قرعه‌کشی
//     * @return array لیست برندگان با اطلاعات کامل
//     */
//    public function getLotteryWinners($lotteryId) {
//        try {
//            $participantsModel = $this->getModel('lotteryParticipantsModel');
//            $membersModel = $this->getModel('membersModel');
//            $galleryModel = $this->getModel('lotteryGalleryModel');
//
//            // دریافت تمام شرکت‌کنندگان به ترتیب زمان ثبت
//            $participants = $participantsModel->get()
//                ->where('lottery_id', $lotteryId)
//                ->orderBy('participated_at', 'ASC')
//                ->all();
//
//            if (empty($participants)) {
//                return [
//                    'success' => false,
//                    'message' => 'هیچ شرکت‌کننده‌ای یافت نشد',
//                    'data' => []
//                ];
//            }
//
//            // محاسبه آمار جوایز
//            $prizeStats = $this->calculatePrizeStatistics($lotteryId);
//
//            $winners = [];
//            $position = 1;
//
//            foreach ($participants as $participant) {
//                // دریافت اطلاعات جایزه از lottery_gallery_id
//                $prize = $galleryModel->get()
//                    ->where('id', $participant['lottery_gallery_id'])
//                    ->find();
//
//                // بررسی آیا این جایزه یک برنده است
//                if ($prize && isset($prize['is_prize']) && $prize['is_prize'] == 1) {
//                    // دریافت اطلاعات کاربر
//                    $user = $membersModel->get()
//                        ->where('id', $participant['user_id'])
//                        ->find();
//
//                    $cycleNumber = ceil($position / 5);
//                    $positionInCycle = (($position - 1) % 5) + 1;
//
//                    $winners[] = [
//                        'participant_id' => $participant['id'],
//                        'user_id' => $participant['user_id'],
//                        'user_phone' => $user ? $user['mobile'] : 'N/A',
//                        'user_name' => $user ? ($user['name'] . ' ' . $user['family']) : 'نامشخص',
//                        'prize_id' => $prize['id'],
//                        'prize_image' => SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/' . $prize['image_path'],
//                        'position' => $position,
//                        'cycle_number' => $cycleNumber,
//                        'position_in_cycle' => $positionInCycle,
//                        'participated_at' => $participant['participated_at']
//                    ];
//                }
//
//                $position++;
//            }
//
//            return [
//                'success' => true,
//                'message' => 'لیست برندگان با موفقیت دریافت شد',
//                'statistics' => $prizeStats,
//                'total_participants' => count($participants),
//                'total_winners' => count($winners),
//                'data' => $winners
//            ];
//
//        } catch (Exception $e) {
//            functions::insertLog(
//                json_encode(['error' => $e->getMessage()]),
//                'lottery_get_winners_error'
//            );
//
//            return [
//                'success' => false,
//                'message' => 'خطا در دریافت لیست برندگان',
//                'data' => []
//            ];
//        }
//    }
//
//    /**
//     * محاسبه آمار و احتمالات جوایز یک قرعه‌کشی
//     *
//     * @param int $lotteryId شناسه قرعه‌کشی
//     * @return array آمار کامل جوایز
//     */
//    private function calculatePrizeStatistics($lotteryId) {
//        try {
//            $galleryModel = $this->getModel('lotteryGalleryModel');
//
//            // شمارش جوایز
//            $prizeImages = $galleryModel->get()
//                ->where('lottery_id', $lotteryId)
//                ->where('is_prize', 1)
//                ->all();
//
//            // شمارش غیر جوایز
//            $nonPrizeImages = $galleryModel->get()
//                ->where('lottery_id', $lotteryId)
//                ->where('is_prize', 0)
//                ->all();
//
//            $prizeCount = count($prizeImages);
//            $nonPrizeCount = count($nonPrizeImages);
//            $totalImages = $prizeCount + $nonPrizeCount;
//
//            // محاسبه احتمال
//            $winProbability = 0;
//            if ($nonPrizeCount > 0) {
//                $winProbability = ($prizeCount / $nonPrizeCount) * 5;
//            } elseif ($totalImages > 0) {
//                $winProbability = ($prizeCount / $totalImages) * 5;
//            }
//
//            $winnersPerHundred = round($winProbability);
//
//            return [
//                'total_images' => $totalImages,
//                'prize_images_count' => $prizeCount,
//                'non_prize_images_count' => $nonPrizeCount,
//                'win_probability_percentage' => round($winProbability, 2),
//                'winners_per_hundred_participants' => $winnersPerHundred,
//                'formula' => "({$prizeCount} / {$nonPrizeCount}) * 5 = " . round($winProbability, 2) . "%"
//            ];
//
//        } catch (Exception $e) {
//            return [
//                'error' => $e->getMessage()
//            ];
//        }
//    }
//
    /**
     * Log lottery participation for analytics
     *
     * @param int $userId
     * @param int $lotteryId
     * @param int $lotteryGalleryId
     * @return bool|string Success status or 'already_exists'
     */
    public function logLotteryParticipation($userId, $lotteryId, $lotteryGalleryId) {
        try {
            $Model = Load::library('Model');
            $Model->setTable('lottery_participants');



            $checkSql = "
                SELECT id
                FROM lottery_participants
                WHERE user_id = '{$userId}' AND lottery_id = '{$lotteryId}'
                LIMIT 1
            ";
            $exists = $Model->load($checkSql);

            if ($exists) {
                return 'already_exists';
            }

            $participationData = [
                'user_id' => $userId,
                'lottery_id' => $lotteryId,
                'lottery_gallery_id' => $lotteryGalleryId,
                'participated_at' => date('Y-m-d H:i:s'),
            ];



            $insertId = $Model->insertLocal($participationData);

            if (!$insertId) {
                return false;
            }

            return true;

        } catch (Exception $e) {

            return false;
        }
    }




    private function selectRandomPrize($lotteryId = null, $participantPosition = null) {
        try {
            $lotteryGalleryModel = $this->getModel('lotteryGalleryModel');

            // اگر lottery_id مشخص نشده، از آخرین فعال استفاده کن
            if (!$lotteryId) {
                $lotteryModel = $this->getModel('lotteryModel');
                $latestLottery = $lotteryModel->get()
                    ->where('deleted_at', null, 'IS')
                    ->where('is_active', 1)
                    ->orderBy('id', 'DESC')
                    ->find();
                $lotteryId = $latestLottery ? $latestLottery['id'] : 1;
            }

            // دریافت تصاویر غیرجایزه
            $nonPrizeImages = $lotteryGalleryModel->get()
                ->where('lottery_id', $lotteryId)
                ->where('is_prize', 0)
                ->all();
            $nonPrizeImages = is_array($nonPrizeImages) ? $nonPrizeImages : [];

            // تعداد شرکت‌کننده‌ها و موقعیت
            $participantsModel = $this->getModel('lotteryParticipantsModel');
            $participants = $participantsModel->get()
                ->where('lottery_id', $lotteryId)
                ->all();
            $currentCount = is_array($participants) ? count($participants) : 0;
            if ($participantPosition === null) {
                $participantPosition = $currentCount + 1;
            }

            // محاسبه cycleSize بر اساس نسبت جوایز
            $galleryModel = $this->getModel('lotteryGalleryModel');
            $allImages = $galleryModel->get()
                ->where('lottery_id', $lotteryId)
                ->all();
            $totalImages = is_array($allImages) ? count($allImages) : 1;

            // محاسبه تعداد کل جوایز
            $prizeImagesTotal = $galleryModel->get()
                ->where('lottery_id', $lotteryId)
                ->where('is_prize', 1)
                ->all();
            $totalPrizeImages = is_array($prizeImagesTotal) ? count($prizeImagesTotal) : 0;

            // cycleSize = تعداد شرکت‌کنندگان در هر چرخه (ثابت = 100)
            $cycleSize = 100;

            $positionInCycle = (($participantPosition - 1) % $cycleSize) + 1;
            $cycleNumber = ceil($participantPosition / $cycleSize);
            // دریافت جوایز استفاده نشده در چرخه فعلی (با پاس دادن cycleNumber و cycleSize)
            $unusedPrizes = $this->getUnusedPrizes($lotteryId, $cycleNumber, $cycleSize);
            $prizeCount = count($unusedPrizes);

            // تعداد برنده‌ها در چرخه فعلی = تعداد کل جوایز (محدود به اندازه چرخه)
            // مثال: اگر 2 جایزه داریم و cycleSize=100 → winnersPerCycle = 2
            // IMPORTANT: این مقدار برای تمام شرکت‌کنندگان یک چرخه باید ثابت باشد
            $winnersPerCycle = min($totalPrizeImages, $cycleSize);

            $winningPositions = $this->generateWinningPositionsForCycle(
                $lotteryId,
                $cycleNumber,
                $winnersPerCycle,
                $cycleSize
            );

            $isWinner = in_array($positionInCycle, $winningPositions);

            // لاگ برای دیباگ


            if ($isWinner && $prizeCount > 0) {
                // برنده است و جایزه موجود است
                // انتخاب کاملاً تصادفی (True Random) - بدون seed
                $randomKey = array_rand($unusedPrizes);
                $selectedImage = $unusedPrizes[$randomKey];


            } elseif ($isWinner && $prizeCount == 0) {
                // برنده است اما جایزه کافی نیست - تصویر غیر جایزه بده


                if (!empty($nonPrizeImages)) {
                    $randomIndex = array_rand($nonPrizeImages);
                    $selectedImage = $nonPrizeImages[$randomIndex];
                } else {
                    // fallback - استفاده از اولین تصویر موجود
                    $allImagesForFallback = $galleryModel->get()
                        ->where('lottery_id', $lotteryId)
                        ->all();
                    $selectedImage = !empty($allImagesForFallback) ? $allImagesForFallback[0] : false;
                }
            } else {
                // تصویر غیرجایزه
                if (!empty($nonPrizeImages)) {
                    $randomIndex = array_rand($nonPrizeImages);
                    $selectedImage = $nonPrizeImages[$randomIndex];
                } else {
                    // fallback - اگر تصویر غیر جایزه نداریم، از جوایز استفاده کن
                    if (!empty($unusedPrizes)) {
                        $selectedImage = $unusedPrizes[array_rand($unusedPrizes)];
                    } else {
                        // fallback نهایی
                        $allImagesForFallback = $galleryModel->get()
                            ->where('lottery_id', $lotteryId)
                            ->all();
                        if (!empty($allImagesForFallback)) {
                            $selectedImage = $allImagesForFallback[array_rand($allImagesForFallback)];
                        } else {
                            return false;
                        }
                    }
                }


            }

            return $selectedImage;

        } catch (Exception $e) {

            return false;
        }
    }

    /**
     * تولید موقعیت‌های برنده برای یک چرخه
     *
     * روش True Random با ذخیره در دیتابیس:
     * - اولین شرکت‌کننده چرخه: موقعیت‌های تصادفی تولید و در DB ذخیره می‌شود
     * - بقیه شرکت‌کنندگان چرخه: از DB می‌خوانند
     * این روش اطمینان می‌دهد که موقعیت‌ها برای همه شرکت‌کنندگان یک چرخه یکسان است
     *
     * @param int $lotteryId شناسه قرعه‌کشی
     * @param int $cycleNumber شماره چرخه
     * @param int $winnerCount تعداد برنده در چرخه
     * @param int $cycleSize اندازه چرخه (تعداد کل موقعیت‌ها)
     */
    private function generateWinningPositionsForCycle($lotteryId, $cycleNumber, $winnerCount, $cycleSize = 100) {
        try {
            if ($winnerCount <= 0 || $cycleSize <= 0) {
                return array();
            }

            // محدود کردن تعداد برنده به اندازه چرخه
            $winnerCount = min($winnerCount, $cycleSize);

            $Model = Load::library('Model');
            $Model->setTable('lottery_cycle_positions');

            // STEP 1: چک کردن آیا این چرخه قبلاً ثبت شده یا نه
            $sql = "SELECT winning_positions
                    FROM lottery_cycle_positions
                    WHERE lottery_id = '{$lotteryId}'
                    AND cycle_number = '{$cycleNumber}'
                    AND cycle_size = '{$cycleSize}'
                    LIMIT 1";

            $existingCycle = $Model->load($sql);

            if ($existingCycle && !empty($existingCycle['winning_positions'])) {
                // این چرخه قبلاً ثبت شده - از DB بخوان
                $winningPositions = json_decode($existingCycle['winning_positions'], true);



                return is_array($winningPositions) ? $winningPositions : array();
            }

            // STEP 2: این چرخه جدید است - تصادفی تولید کن
            // استفاده از mt_rand برای PHP 5.6 compatibility
            $allPositions = range(1, $cycleSize);
            $winningPositions = array();

            // انتخاب تصادفی بدون تکرار
            $availablePositions = $allPositions;
            for ($i = 0; $i < $winnerCount; $i++) {
                $randomIndex = mt_rand(0, count($availablePositions) - 1);
                $winningPositions[] = $availablePositions[$randomIndex];
                array_splice($availablePositions, $randomIndex, 1);
            }

            sort($winningPositions);

            // STEP 3: در دیتابیس ذخیره کن
            $insertData = [
                'lottery_id' => $lotteryId,
                'cycle_number' => $cycleNumber,
                'cycle_size' => $cycleSize,
                'winning_positions' => json_encode($winningPositions, JSON_UNESCAPED_UNICODE)
            ];

            $Model->insertLocal($insertData);



            return $winningPositions;

        } catch (Exception $e) {


            // Fallback: تولید تصادفی بدون ذخیره
            $count = min($winnerCount, $cycleSize);
            $allPositions = range(1, $cycleSize);
            $result = array();

            for ($i = 0; $i < $count; $i++) {
                $randomIndex = mt_rand(0, count($allPositions) - 1);
                $result[] = $allPositions[$randomIndex];
                array_splice($allPositions, $randomIndex, 1);
            }

            sort($result);
            return $result;
        }
    }
    /**
     * دریافت جوایز استفاده نشده در چرخه فعلی
     * این متد جوایزی را برمی‌گرداند که is_prize=1 هستند و در چرخه فعلی استفاده نشده‌اند
     *
     * @param int $lotteryId شناسه قرعه‌کشی
     * @param int|null $cycleNumber شماره چرخه فعلی (اختیاری)
     * @param int|null $cycleSize اندازه هر چرخه (اختیاری)
     * @return array لیست جوایز استفاده نشده در چرخه فعلی
     */
    private function getUnusedPrizes($lotteryId, $cycleNumber = null, $cycleSize = null) {
        try {
            $Model = Load::library('Model');

            // دریافت تمام جوایز (is_prize = 1)
            $galleryModel = $this->getModel('lotteryGalleryModel');
            $allPrizes = $galleryModel->get()
                ->where('lottery_id', $lotteryId)
                ->where('is_prize', 1)
                ->all();

            if (!is_array($allPrizes) || count($allPrizes) === 0) {
                return [];
            }

            // اگر cycleNumber و cycleSize مشخص شده، فقط جوایز استفاده نشده در این چرخه را برگردان
            if ($cycleNumber !== null && $cycleSize !== null) {
                // محاسبه محدوده participant position های این چرخه
                $cycleStartPosition = (($cycleNumber - 1) * $cycleSize) + 1;
                $cycleEndPosition = $cycleNumber * $cycleSize;

                // دریافت تمام شرکت‌کنندگان این lottery به ترتیب زمان شرکت
                $sql = "SELECT lp.id, lp.lottery_gallery_id, lg.is_prize
                        FROM lottery_participants lp
                        INNER JOIN lottery_gallery lg ON lp.lottery_gallery_id = lg.id
                        WHERE lp.lottery_id = '{$lotteryId}'
                        ORDER BY lp.participated_at ASC";

                $allParticipants = $Model->loadAll($sql);
                $usedInCycle = [];

                if (is_array($allParticipants)) {
                    $position = 1;
                    foreach ($allParticipants as $participant) {
                        // بررسی اینکه آیا این شرکت‌کننده در چرخه فعلی است
                        if ($position >= $cycleStartPosition && $position <= $cycleEndPosition) {
                            // اگر جایزه گرفته (is_prize = 1)، به لیست استفاده شده اضافه کن
                            if ($participant['is_prize'] == 1) {
                                $usedInCycle[] = $participant['lottery_gallery_id'];
                            }
                        }
                        $position++;
                    }
                }

                // فیلتر کردن جوایز: فقط جوایزی که در این چرخه استفاده نشده‌اند
                $unusedPrizes = [];
                foreach ($allPrizes as $prize) {
                    if (!in_array($prize['id'], $usedInCycle)) {
                        $unusedPrizes[] = $prize;
                    }
                }





                return $unusedPrizes;

            } else {
                // رفتار قدیمی: بر اساس کل استفاده‌ها (برای backward compatibility)
                $sql = "SELECT lp.lottery_gallery_id, COUNT(*) as usage_count
                        FROM lottery_participants lp
                        INNER JOIN lottery_gallery lg ON lp.lottery_gallery_id = lg.id
                        WHERE lp.lottery_id = '{$lotteryId}' AND lg.is_prize = 1
                        GROUP BY lp.lottery_gallery_id";
                $usedPrizesResult = $Model->loadAll($sql);

                $usageCount = [];
                if (is_array($usedPrizesResult)) {
                    foreach ($usedPrizesResult as $row) {
                        $usageCount[$row['lottery_gallery_id']] = (int)$row['usage_count'];
                    }
                }

                $minUsage = 0;
                if (!empty($usageCount)) {
                    $minUsage = min($usageCount);
                }

                $unusedPrizes = [];
                foreach ($allPrizes as $prize) {
                    $currentUsage = isset($usageCount[$prize['id']]) ? $usageCount[$prize['id']] : 0;
                    if ($currentUsage == $minUsage) {
                        $unusedPrizes[] = $prize;
                    }
                }

                if (empty($unusedPrizes)) {
                    $unusedPrizes = $allPrizes;
                }

                return $unusedPrizes;
            }

        } catch (Exception $e) {

            return [];
        }
    }

    /**
     * دریافت وضعیت جوایز یک قرعه‌کشی
     * نشان می‌دهد که چند جایزه استفاده شده و چند جایزه باقی مانده
     * و چند بار چرخه Recycle شده است
     *
     * @param int $lotteryId
     * @return array آمار کامل جوایز
     */
    public function getPrizesStatus($lotteryId) {
        try {
            $Model = Load::library('Model');
            $galleryModel = $this->getModel('lotteryGalleryModel');

            // دریافت تمام جوایز
            $allPrizes = $galleryModel->get()
                ->where('lottery_id', $lotteryId)
                ->where('is_prize', 1)
                ->all();

            $totalPrizes = is_array($allPrizes) ? count($allPrizes) : 0;

            if ($totalPrizes === 0) {
                return [
                    'success' => false,
                    'message' => 'هیچ جایزه‌ای برای این قرعه‌کشی تعریف نشده است',
                    'total_prizes' => 0
                ];
            }

            // دریافت آمار استفاده از جوایز
            $sql = "SELECT lottery_gallery_id, COUNT(*) as usage_count
                    FROM lottery_participants lp
                    INNER JOIN lottery_gallery lg ON lp.lottery_gallery_id = lg.id
                    WHERE lp.lottery_id = '{$lotteryId}' AND lg.is_prize = 1
                    GROUP BY lottery_gallery_id";
            $usageStats = $Model->loadAll($sql);

            $usageCount = [];
            $totalWinners = 0;
            if (is_array($usageStats)) {
                foreach ($usageStats as $stat) {
                    $usageCount[$stat['lottery_gallery_id']] = (int)$stat['usage_count'];
                    $totalWinners += (int)$stat['usage_count'];
                }
            }

            // محاسبه چرخه فعلی بر اساس حداقل استفاده
            $minUsage = empty($usageCount) ? 0 : min($usageCount);
            $maxUsage = empty($usageCount) ? 0 : max($usageCount);
            $currentCycle = $minUsage + 1;

            // جوایز استفاده نشده در چرخه فعلی
            $unusedPrizes = $this->getUnusedPrizes($lotteryId);
            $unusedCount = count($unusedPrizes);
            $usedCountInCycle = $totalPrizes - $unusedCount;

            // محاسبه جزئیات هر جایزه
            $prizesDetail = [];
            foreach ($allPrizes as $prize) {
                $prizeUsage = isset($usageCount[$prize['id']]) ? $usageCount[$prize['id']] : 0;
                $prizesDetail[] = [
                    'id' => $prize['id'],
                    'image_path' => $prize['image_path'],
                    'total_usage' => $prizeUsage,
                    'available_in_current_cycle' => $prizeUsage <= $minUsage
                ];
            }

            return [
                'success' => true,
                'lottery_id' => $lotteryId,
                'total_prizes' => $totalPrizes,
                'current_cycle' => $currentCycle,
                'used_prizes_in_current_cycle' => $usedCountInCycle,
                'unused_prizes_in_current_cycle' => $unusedCount,
                'total_winners_all_cycles' => $totalWinners,
                'min_usage_per_prize' => $minUsage,
                'max_usage_per_prize' => $maxUsage,
                'prizes_detail' => $prizesDetail,
                'prizes_available' => true, // همیشه true چون Recycle می‌شود
                'recycle_info' => "جوایز به صورت چرخشی استفاده می‌شوند. هر جایزه حداقل {$minUsage} بار و حداکثر {$maxUsage} بار استفاده شده است."
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * محاسبه آمار جوایز - فرمول هماهنگ با متد اصلی
     */
    private function calculatePrizeStatistics($lotteryId) {
        try {
            $galleryModel = $this->getModel('lotteryGalleryModel');

            $prizeImages = $galleryModel->get()
                ->where('lottery_id', $lotteryId)
                ->where('is_prize', 1)
                ->all();

            $nonPrizeImages = $galleryModel->get()
                ->where('lottery_id', $lotteryId)
                ->where('is_prize', 0)
                ->all();

            $prizeCount = count($prizeImages);
            $nonPrizeCount = count($nonPrizeImages);
            $totalImages = $prizeCount + $nonPrizeCount;

            $winRatio = $totalImages > 0 ? $prizeCount / $totalImages : 0;
            $winnersPerHundred = ceil($winRatio * 100); // استفاده از ceil برای گرد کردن به بالا

            return [
                'total_images' => $totalImages,
                'prize_images_count' => $prizeCount,
                'non_prize_images_count' => $nonPrizeCount,
                'win_probability_percentage' => round($winRatio * 100, 2),
                'winners_per_100_participants' => $winnersPerHundred,
                'formula' => "({$prizeCount} / {$totalImages}) × 100 = " . round($winRatio * 100, 2) . " → ceil = {$winnersPerHundred}"
            ];

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Standard JSON response helper
     *
     * @param bool $success
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return string JSON response
     */
    private function jsonResponse($success, $message, $data = null, $statusCode = 200) {
        http_response_code($statusCode);

        $response = [
            'success' => $success,
            'message' => $message,
            'code' => $statusCode
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * لاگین کردن کاربر بعد از دریافت جایزه
     * این متد از Session::LoginDo استفاده می‌کند
     *
     * @param array $params ['phone' => '09123456789', 'user_id' => 123]
     * @return string JSON response
     */
    public function loginAfterLottery($params) {
        try {
            $phone = isset($params['phone']) ? trim($params['phone']) : '';
            $userId = isset($params['user_id']) ? (int)$params['user_id'] : 0;

            if (empty($phone) || $userId <= 0) {
                return $this->jsonResponse(false, 'اطلاعات کاربر معتبر نیست', null, 400);
            }

            // دریافت اطلاعات کاربر از دیتابیس
            $Model = Load::library('Model');
            $Model->setTable('members_tb');
            $sql = "SELECT * FROM members_tb WHERE id = '{$userId}' AND mobile = '{$phone}' LIMIT 1";
            $user = $Model->load($sql);

            if (!$user) {
                return $this->jsonResponse(false, 'کاربر یافت نشد', null, 404);
            }

            // ست کردن session برای لاگین کاربر با استفاده از Session::LoginDo
            $Session = Load::library('Session');

            // fullname: نام کامل کاربر
            $fullname = trim($user['name'] . ' ' . $user['family']);

            // id: شناسه کاربر
            $id = $user['id'];

            // cardNo: شماره کارت (برای باشگاه مشتریان)
            $cardNo = isset($user['card_number']) ? $user['card_number'] : null;

            // type: نوع کاربر (counter یا agency)
            $type = 'counter';

            // فراخوانی متد LoginDo
            $Session::LoginDo($fullname, $id, $cardNo, $type);



            return $this->jsonResponse(true, 'ورود موفقیت‌آمیز بود', array(
                'user_id' => $user['id'],
                'redirect' => ROOT_ADDRESS . '/profile'
            ), 200);

        } catch (Exception $e) {

            return $this->jsonResponse(false, 'خطای سیستمی رخ داده است', null, 500);
        }
    }

}