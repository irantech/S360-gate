<?php

class newsLetter extends clientAuth {
    /**
     * @var string
     */
    protected $table = 'news_letter_tb';
    private $newsLetterTb,$page_limit;
    /**
     * @var string
     */

    public function __construct() {
        parent::__construct();
        $this->page_limit = 6;
        $this->newsLetterTb = 'news_letter_tb';
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        $return = json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $return;
    }
    public function addNewsLetterIndexes(array $newsLetterList) {
        $result = [];

        foreach ($newsLetterList as $key => $newsLetter) {

            $result[$key] = $newsLetter;
            $time_date = functions::ConvertToDateJalaliInt($newsLetter['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);

        }

        return $result;
    }

    public function registerUserNewsLetter($params) {
        $data_register_guest_user = array();
        foreach ($params as $key=>$param){
            $data_register_guest_user[$key] = functions::checkParamsInput($param);
        }

        $dataNewsLetter = [
            'name' =>  $params['full_name'],
            'email' =>  $data_register_guest_user['email'],
            'mobile' =>  $data_register_guest_user['mobile'],
            'language' => SOFTWARE_LANG,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $result_register_guest_user = $this->getModel('newsLetterModel')->insertWithBind($dataNewsLetter);
        if($result_register_guest_user){
            return functions::withSuccess('',200,'ثبت اطلاعات با موفقیت انجام شد');
        }
        return functions::withError('',400,'خطا در ثبت اطلاعات ،لطفا با پشتیبان تماس بگیرید!');
    }


    public function listNewsLetter($data = []) {
        $voteList = $this->getModel('newsLetterModel')->get()->orderBy('id' , 'desc')->all(false);
        $result = $this->addNewsLetterIndexes($voteList);
        return $result;
    }

    public function createNewsLetterExcel($param) {
        $_POST = $param;
        $resultNewsLetter = $this->listNewsLetter();


        if (!empty($resultNewsLetter)) {


            // برای نام گذاری سطر اول فایل اکسل //
//            $firstRowColumnsHeading = ['ردیف', 'تاریخ عضویت', 'نام و نام خانوادگی', 'شماره همراه', 'ایمیل'];
            $firstRowColumnsHeading = ['ردیف', 'شماره همراه'];

            $firstRowWidth = [10, 20, 25, 20, 20, 30, 10, 10, 15,10, 10,
                15,10, 20,20, 10,10, 15, 10, 10, 15, 15, 15,
                10, 15];


            $dataRows = [];
            foreach ($resultNewsLetter as $k => $letter) {
                $numberColumn = $k + 2;

//                $created_at = (!empty($letter['created_at'])) ? dateTimeSetting::jdate('Y-m-d (H:i:s)', $letter['created_at']) : '';

                // ایجاد آرایه ای از اطلاعات  (هر چیزی که میخواهیم در فایل اکسل قرار دهیم) برای ساخت فایل اکسل //
                $dataRows[$k]['number_column'] = $numberColumn - 1;
//                $dataRows[$k]['created_at'] = $created_at;
//                $dataRows[$k]['name'] = $letter['name'];
                $dataRows[$k]['mobile'] = $letter['mobile']. ' ';
//                $dataRows[$k]['email'] = $letter['email'];

            }


            $objCreateExcelFile = Load::controller('createExcelFile');
            $resultExcel = $objCreateExcelFile->create($dataRows, $firstRowColumnsHeading , $firstRowWidth);

            if ($resultExcel['message'] == 'success') {
                return 'success|' . $resultExcel['fileName'];
            } else {
                return 'error|متاسفانه در ساخت فایل اکسل مشکلی پیش آمده. لطفا مجددا تلاش کنید';
            }


        } else {
            return 'error|اطلاعاتی برای ساخت فایل اکسسل وجود ندارد.';
        }


    }

    public function findNewsLetterById($id) {
        return $this->getModel('newsLetterModel')->get()->where('id', $id)->find();
    }


    public function deleteNewsLetter($data_update) {
        $check_exist = $this->findNewsLetterById($data_update['id']);
        if ($check_exist) {
            $result_update= $this->getModel('newsLetterModel')->delete("id='{$data_update['id']}'");
            if ($result_update) {
                return functions::withSuccess('', 200, 'حذف خبرنامه با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف جدبد');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }




}







