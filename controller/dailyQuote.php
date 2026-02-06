<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class dailyQuote extends clientAuth {
    /**
     * @var string
     */
    private $dailyQuoteTb , $page_limit;
    /**
     * @var string
     */
    public function __construct() {
    parent::__construct();
    $this->dailyQuoteTb = 'daily_quote_tb';
    $this->page_limit = 6;
    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    /**
     * @param array $dailyQuoteList
     * @return array
     */

    public function addDailyQuoteIndexes(array $dailyQuoteList){
        $result = [];
        foreach ($dailyQuoteList as $key => $dailyQuote) {
            $result[$key] = $dailyQuote;
            $time_date = functions::ConvertToDateJalaliInt($dailyQuote['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
            $result[$key]['is_active'] = "{$dailyQuote['is_active']}";
            $result[$key]['tiny_text'] = strip_tags(substr_replace($dailyQuote['text'], "...", 250));

        }
        return $result;
    }

    public function listDailyQuote($data_main_page = []) {

        $result = [];
        $dailyQuoteList = $this->getModel('dailyQuoteModel')->get();
        $daily_table = $dailyQuoteList->getTable();
        if ($data_main_page['check_date'] == 1) {
            $dailyQuoteList->where('to_date',time(),'>')->where(time(),'date_of','>');
        }
        if ($data_main_page['check_date'] == 1) {
           $order =  "->orderBy('id' ,'DESC')";
        }else{
            $order =  "->orderBy('id' ,'DESC')";
        }
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }

        if ($data_main_page['is_active'] ) {
            $dailyQuoteList->where($daily_table . '.is_active', 1);
        }
        $dailyQuoteList->orderBy('id' ,'DESC')->limit(0,$data_main_page['limit']);
        $listDailyQuote = $dailyQuoteList->all();

        foreach ($listDailyQuote as $key => $value) {
            if ($value['to_date']>time())  {
                $expired = 'ON';
            } else {
                $expired = 'OFF';
            }
            $listDailyQuote[$key]['expired'] = $expired;

            $date_of = dateTimeSetting::jdate( "Y-m-d", $value['date_of'], '', '', 'en' );
           $to_date = dateTimeSetting::jdate( "Y-m-d", $value['to_date'], '', '', 'en' );
            $listDailyQuote[$key]['date_of'] = $date_of;
            $listDailyQuote[$key]['to_date'] = $to_date;
        }
       $result = $this->addDailyQuoteIndexes($listDailyQuote);
        return $result;

    }

    public function insertDailyQuote($params) {
        $date_of = explode('-', $_POST['date_of']);
        $date_to = explode('-', $_POST['to_date']);
        $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
        $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
        $dataDailyQuote = [
            'text' => $params['text'],
            'color' => $params['color'],
            'link' => $params['link'],
            'date_of' => $date_of_int,
            'to_date' => $date_to_int,
            'is_active' => false,
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        $insert = $this->getModel('dailyQuoteModel')->insertWithBind($dataDailyQuote);
        if ($insert) {
            return self::returnJson(true, 'افزودن سخن روز با موفقیت انجام شد');
        }
        return self::returnJson(false, 'خطا در ثبت سخن روز جدید.', null, 500);
    }
    public function findDailyQuoteById($id) {
        return $this->getModel('dailyQuoteModel')->get()->where('id', $id)->find();
    }
    public function updateActiveDailyQuote($data_update) {
        $check_exist_daily_quote = $this->findDailyQuoteById($data_update['id']);
        if ($check_exist_daily_quote) {
            $data_update_status['is_active'] = ($check_exist_daily_quote['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_daily_quote['id']}'";
            $condition_update_not_status ="id!='{$check_exist_daily_quote['id']}'";
            $result_update_daily_quote = $this->getModel('dailyQuoteModel')->updateWithBind($data_update_status,$condition_update_status);
            $this->getModel('dailyQuoteModel')->updateWithBind(['is_active' =>  0],$condition_update_not_status);

            if ($result_update_daily_quote) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت ');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }
    public function getDailyQuote($id) {
        $daily_quote_model = $this->getModel('dailyQuoteModel');
        $daily_quote_table = $daily_quote_model->getTable();
        $daily_quote = $daily_quote_model
            ->get(
                [
                    $daily_quote_table . '.*',
                ], true
            )
            ->where($daily_quote_table . '.id', $id)
            ->find(false);
        $daily_quote['date_of'] = dateTimeSetting::jdate( "Y-m-d", $daily_quote['date_of'], '', '', 'en' );
        $daily_quote['to_date'] = dateTimeSetting::jdate( "Y-m-d", $daily_quote['to_date'], '', '', 'en' );
        return $daily_quote;
    }

    public function deleteDailyQuote($data_update) {
        $check_exist_daily_quote = $this->findDailyQuoteById($data_update['id']);
        if ($check_exist_daily_quote) {
            $result_update_daily_quote = $this->getModel('dailyQuoteModel')->delete("id='{$data_update['id']}'");
            if ($result_update_daily_quote) {
                return functions::withSuccess('', 200, 'حذف سخن با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در حذف');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function updateDailyQuote($params) {
        /** @var dailyQuoteModel $daily_quote_model */
        $daily_quote_model = $this->getModel('dailyQuoteModel');
        $date_of = explode('-', $_POST['date_of']);
        $date_to = explode('-', $_POST['to_date']);
        $date_of_int = dateTimeSetting::jmktime(0, 0, 0, $date_of[1], $date_of[2], $date_of[0]);
        $date_to_int = dateTimeSetting::jmktime(23, 59, 59, $date_to[1], $date_to[2], $date_to[0]);
        $data = [
            'text' => $params['text'],
            'link' => $params['link'],
            'color' => $params['color'],
            'date_of' => $date_of_int,
            'to_date' => $date_to_int,
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $update = $daily_quote_model->updateWithBind($data, ['id' => $params['id']]);
        if ($update) {
            return functions::withSuccess('', 200, 'ویرایش سخن روز  با موفقیت انجام شد');
        }

    }


}