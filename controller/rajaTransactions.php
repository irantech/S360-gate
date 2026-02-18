<?php
//if($_SERVER['REMOTE_ADDR']==='178.131.171.199'){
//    error_reporting(1);
//    error_reporting(E_ALL | E_STRICT);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');
//}

define('BASE_PATH', dirname(__DIR__));

spl_autoload_register(function ($class) {
    $prefix = 'Box\\Spout\\';
    $base_dir = BASE_PATH . '/library/Spout/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
}, true, false);

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;


class rajaTransactions extends clientAuth
{

    public function __construct() {
        parent::__construct();
        $this->uploadsTb = 'raja_transactions_tb';
        $this->page_limit = 1;
        $this->noPhotoUrl = 'project_files/images/no-photo.png';
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
        $this->uploadsBaseUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/' . SOFTWARE_LANG . '/rajaTransactions' . '/';
    }

    public static function format_datetime_to_jalali($datetime) {
        // جدا کردن تاریخ و زمان از هم
        list($date, $time) = explode(' ', $datetime); // "2025-06-07", "19:15:58"
        list($gy, $gm, $gd) = explode('-', $date);    // سال، ماه، روز میلادی

        // تبدیل به شمسی
        list($jy, $jm, $jd) = dateTimeSetting::gregorian_to_jalali($gy, $gm, $gd);

        // صفر پر کردن ماه و روز شمسی
        $jm = str_pad($jm, 2, '0', STR_PAD_LEFT);
        $jd = str_pad($jd, 2, '0', STR_PAD_LEFT);

        return $time . ' ' . dateTimeSetting::tr_num("$jy/$jm/$jd", 'fa');
    }
    public function addUploadsIndexes(array $uploadsList) {
        $result = [];
        foreach ($uploadsList as $key => $upload) {
            $result[$key] = $upload;
            $time_date = $this->format_datetime_to_jalali($upload['created_at']);
            $result[$key]['created_at'] = $time_date;
            $result[$key]['file'] = $this->photoUrl . 'rajaTransactions/' . CLIENT_ID . '/'. $upload['excel_file'];
            $result[$key]['link'] = "{$this->uploadsBaseUrl}{$upload['id']}";
        }
        return $result;
    }
    public function listExcel($data_main_page = []) {
        $result = [];
        $uploadList = $this->getModel('rajaTransactionsModel');
        $upload_table = $uploadList->getTable();
        if (!isset($data_main_page['limit']) || empty($data_main_page['limit'])) {
            $data_main_page['limit'] = 10;
        }

        $listUpload = $uploadList
            ->get(['*'], true)
            ->where('deleted_at', null , 'is')
            ->orderBy($upload_table . '.id', 'DESC')
            ->all(false);
        foreach ($listUpload as $key => $value) {
            $pic = $listUpload[$key]['file'];
            $ext = explode(".", $pic);
            $ext = strtolower($ext[count($ext)-1]);
            if (in_array ( $ext, array ('xlsx') ) ) {
                $type = 'pic';
            }
            else{
                $type = 'file';
            }
            $listUpload[$key]['type'] = $type;
            $listUpload[$key]['kind'] = $ext;
        }
        $result = $this->addUploadsIndexes($listUpload);
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

    private function generateTrackingCode() {
        $rajaTransactions_model = $this->getModel('rajaTransactionsModel');

        do {
            $code = substr(mt_rand(100000000, 999999999) . mt_rand(0, 9), 0, 10);
            $exists = $rajaTransactions_model
                ->get(['tracking_code'], false)
                ->where('tracking_code', $code)
                ->all();
        } while (!empty($exists));

        return $code;
    }

    public function InsertExel($params) {
        $rajaTransactions_model = $this->getModel('rajaTransactionsModel');
        $rajaTransactionsDetail_model = $this->getModel('rajaTransactionsDetailModel');

        if (!isset($_FILES['gallery_files']) || empty($_FILES['gallery_files'])) {
            return self::returnJson(false, 'هیچ فایلی ارسال نشده است', null, 500);
        }

        $separated_files = functions::separateFiles('gallery_files');

        // جلوگیری از آپلود چند فایل
        if (count($separated_files) > 1) {
            return self::returnJson(false, 'فقط یک فایل اکسل مجاز است', null, 400);
        }

        $config = Load::Config('application');
        $path = "rajaTransactions/" . CLIENT_ID . "/";
        $config->pathFile($path);

        $tracking_code = $this->generateTrackingCode();
        $excel_data = [];
        $expectedColumnsCount = 18; // تعداد ستون‌هایی که انتظار داریم

        $separated_file = $separated_files[0];
        $_FILES['file'] = $separated_file;

        $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['xlsx'];
        if (!in_array($ext, $allowed_extensions)) {
            return self::returnJson(false, 'فرمت فایل مجاز نیست. فقط فایل‌های اکسل با پسوند xlsx مجاز هستند', null, 500);
        }

        $_FILES['file']['name'] = date("sB") . "-" . rand(10, 10000) . "." . $ext;

        $type = 'pic'; // چون اکسل داخل فولدر pic آپلود میشه
        $upload_result = $config->UploadFile($type, "file", 99900000);

        $explode_name = explode(':', $upload_result);
        if ($explode_name[0] !== "done") {
            return self::returnJson(false, 'آپلود فایل با خطا مواجه شد', $upload_result, 500);
        }

        $file_name = $explode_name[1];
        $file_path = BASE_PATH . '/pic/rajaTransactions/' . CLIENT_ID . '/' . $file_name;
        if (!file_exists($file_path)) {
            return self::returnJson(false, 'فایل اکسل یافت نشد', null, 500);
        }

        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($file_path);
        foreach ($reader->getSheetIterator() as $sheet) {
            $rowIndex = 0;
            foreach ($sheet->getRowIterator() as $row) {
                $rowIndex++;

                $cells = $row->getCells();
                $row_data = [];
                foreach ($cells as $cell) {
                    $row_data[] = $cell->getValue();
                }

                if ($rowIndex === 1) {
                    // بررسی تعداد ستون‌ها در ردیف اول
                    if (count($row_data) !== $expectedColumnsCount) {
                        $reader->close();
                        return self::returnJson(false, 'تعداد ستون‌های فایل اکسل با قالب مورد انتظار مطابقت ندارد', null, 400);
                    }
                    continue;
                }

                // اضافه کردن کد رهگیری به ردیف داده‌ها
                $row_data['tracking_code'] = $tracking_code;
                $excel_data[] = $row_data;
            }
        }

        $reader->close();

        if (empty(trim($params['description']))) {
            return self::returnJson(false, 'دلیل تراکنش تعیین نشده', null, 400);
        }

        // حذف ردیف‌های خالی انتهایی اگر وجود داشته باشد
        $excel_data = array_slice($excel_data, 0, count($excel_data) - 4);

        // ذخیره رکورد فایل اکسل
        $insert_excel_list = $rajaTransactions_model->insertWithBind([
            'excel_file'     => $file_name,
            'comment'        => trim($params['description']),
            'created_at'     => date('Y-m-d H:i:s'),
            'detail'         => 'test',
            'tracking_code'  => $tracking_code,
        ]);

        // ذخیره ردیف‌های فایل اکسل
        $insert_detail_list = false;
        foreach ($excel_data as $row) {
            $insert_detail_list = $rajaTransactionsDetail_model->insertWithBind([
                'row_exel' => $row[0],
                'agency_code' => $row[1],
                'agency_name' => $row[2],
                'city_name' => $row[3],
                'representation_name' => $row[4],
                'payment_id' => $row[5],
                'received_passenger' => $row[6],
                'return_traveler' => $row[7],
                'station_services' => $row[8],
                'gross_income' => $row[9],
                'agency_share' => $row[10],
                'tax' => $row[11],
                'insurance_deposit' => $row[12],
                'previous_credit_debit' => $row[13],
                'fine' => $row[14],
                'depositable_amount' => $row[15],
                'deposit' => $row[16],
                'contradiction' => $row[17],
                'tracking_code_file' => $tracking_code,
            ]);
        }

        if ($insert_detail_list && $insert_excel_list) {
            return self::returnJson(true, 'آپلود فایل با موفقیت انجام شد', $tracking_code);
        } else {
            return self::returnJson(false, 'خطا در آپلود فایل جدید', null, 400);
        }
    }

    public function getDetail($tracking_code) {
        $rajaTransactionsDetail_model = $this->getModel('rajaTransactionsDetailModel');
        $agencyModel = $this->getModel('agencyModel');
        $rajaTransactionsDetail_table = $rajaTransactionsDetail_model->getTable();

        $details = $rajaTransactionsDetail_model
            ->get(
                [
                    $rajaTransactionsDetail_table . '.*',
                ], true
            )
            ->where($rajaTransactionsDetail_table . '.tracking_code_file', $tracking_code)
            ->all();

        foreach ($details as &$detail) {
            $agency = $agencyModel
                ->get(['id'], true)
                ->where('raja_unique_code', $detail['agency_code'])
                ->find(false);

            $detail['is_valid_agency'] = $agency ? true : false;
        }

        return $details;
    }


    public function processExcel($tracking_code)
    {

        $rajaTransactions_model = $this->getModel('rajaTransactionsModel');
        $rajaDetailModel      = $this->getModel('rajaTransactionsDetailModel');
        $agencyModel          = $this->getModel('agencyModel');
        $creditDetailModel    = $this->getModel('CreditDetailModel');

        $details = $rajaDetailModel
            ->get(['*'], false)
            ->where('tracking_code_file', $tracking_code)
            ->all();

        $excel_file = $rajaTransactions_model
            ->get(['*'], true)
            ->where('tracking_code', $tracking_code)
            ->find(false);



        if (empty($details)) {
            return $this->returnJson(false, 'هیچ اطلاعاتی در جزئیات این اکسل وجود ندارد');
        }

        $errors = [];
        $validRows = [];

        foreach ($details as $row) {
            $rajaCode = trim($row['agency_code']);
            $agencyName = $row['agency_name'];
            $depositable_amount = (float) $row['depositable_amount'];

            if ($rajaCode === '' || !is_numeric($row['depositable_amount'])) {
                $errors[] = "ردیف مربوط به کد «{$rajaCode}» معتبر نیست (مقدار مبلغ: {$row['depositable_amount']}).";
                continue;
            }

            $agency = $agencyModel
                ->get(['*'], true)
                ->where('raja_unique_code', $rajaCode)
                ->find(false);

            if (!$agency) {
                $errors[] = "آژانس {$agencyName} با کد رجای {$rajaCode} یافت نشد";
                continue;
            }

            $validRows[] = [
                'agency_id' => $agency['id'],
                'amount'    => $depositable_amount
            ];
        }

        if (!empty($errors)) {
            $message = "تعداد " . count($errors) . " آژانس در سیستم ثبت نشده اند یا کد اشتباهی برایشان تنظیم شده ، از طریق جزییات لیست این آژانس ها را بررسی نمایید";
            return $this->returnJson(false, $message);
        }

        // فاز اینسرت
        $successCount = 0;
        foreach ($validRows as $item) {
            if ($item['amount'] >= 0) {
                $infoCredit = [
                    'agencyID'  => $item['agency_id'],
                    'credit'    => $item['amount'],
                    'becauseOf' => 'decrease',
                    'comment'   => $excel_file['comment'],
                ];
            } else {
                $positivAmount = abs($item['amount']);
                $infoCredit = [
                    'agencyID'  => $item['agency_id'],
                    'credit'    => $positivAmount,
                    'becauseOf' => 'increase',
                    'comment'   => $excel_file['comment'],
                ];
            }


            $insertController = Load::controller('creditDetail');
            $insertResult = $insertController->insert_credit($infoCredit , false);
            $data = array(
                'applied_at' => Date('Y-m-d H:i:s')
            );
            $condition = " tracking_code='" . $tracking_code . "'";

            $listUpload = $rajaTransactions_model->update($data,$condition);
            $successCount++;
        }

        return $this->returnJson(true, "تراکنش‌های اعتبار برای ".$successCount." آژانس با موفقیت ثبت شد");
    }

    public function deleteExcel($tracking_code) {
        $uploadList = $this->getModel('rajaTransactionsModel');
        $data = array(
            'deleted_at' => Date('Y-m-d H:i:s')
        );
        $condition = " tracking_code='" . $tracking_code . "'";

        $listUpload = $uploadList->update($data,$condition);

        if ($listUpload) {
            return $this->returnJson(true, "حذف رکورد با کد رهگیری ".$tracking_code." با موفقیت انجام شد");
        } else {
            return $this->returnJson(false, "حذف رکورد با کد رهگیری ".$tracking_code." با خطا مواجه شد",  null, 500);
        }

    }

}
