<?php

class sendDocuments extends clientAuth {
    /**
     * @var string
     */
    protected $table = 'send_documents_tb';
    private $sendDocumentsTb,$page_limit ;
    /**
     * @var string
     */

    public function __construct() {
        parent::__construct();
        $this->sendDocumentsTb = 'send_documents_tb';
        $this->page_limit = 6;
        $this->photoUrl = SERVER_HTTP . CLIENT_DOMAIN . '/gds/pic/';
    }

    public function addSendDocumentsIndexes(array $getList) {
        $result = [];
        foreach ($getList as $key => $list) {
            $result[$key] = $list;
            $time_date = functions::ConvertToDateJalaliInt($list['created_at']);
            $result[$key]['created_at'] = dateTimeSetting::jdate("j F Y", $time_date);
        }
        return $result;

    }

    public function returnJson($success = true, $message = '', $data = null, $statusCode = 200) {
        http_response_code($statusCode);
        return json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    }
    public function application() {
        return Load::Config( 'application' );
    }

    public function sendDocumentsModel() {
        return Load::getModel( 'sendDocumentsModel' );
    }
    public function findAboutByNationalCode($nationalCode) {
        return $this->getModel('sendDocumentsModel')->get()->where('national_code', $nationalCode)->find();
    }
    public function changeNameUpload($fileName) {
        $ext = explode(".", $fileName);
        $fileName = date("sB")."-" . rand(10, 10000);
        $ext = strtolower($ext[count($ext)-1]);
        $fileName = $fileName.".".$ext;
        return $fileName;
    }
    public function addDocuments($params) {
        if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {
        $count = 0;
        $tmp = mt_rand(1, 15);
        do {
            $tmp .= mt_rand(0, 15);
        } while (++$count < 16);
        $uniq = $tmp;
        $trackingCode = substr($uniq, 0, 10);

       if ($params['sendDocument'] && is_array($params['sendDocument']) ) {
           $array_final_document=array();
           foreach($params['sendDocument'] as $k => $v){
               foreach($v as $k1 => $v1){
                   $array_final_document[$k1][$k]=$v1;
               }
           }
       }
        $Model = Load::library('Model');
        $sql = "SELECT  MAX(id) as max_id  FROM send_documents_tb  ";
        $fetch = $Model->select($sql);
        $last_id = $fetch[0]['max_id']+1;
            foreach($array_final_document as $k=> $v) {
                $check_exist_national_code = $this->findAboutByNationalCode($v['national_code']);
                if ($check_exist_national_code) {
                    return functions::withSuccess('', 200, 'کد ملی '.$v['national_code'].' تکراری می باشد');
                }else {
                    if ($v['name'] == '') {
                        return functions::withSuccess('', 200, 'ورود نام و نام خانوادگی اجباری می باشد');
                    } elseif ($v['national_code'] == '') {
                        return functions::withSuccess('', 200, 'ورود کد ملی اجباری می باشد');
                    } elseif ($v['mobile'] == '') {
                        return functions::withSuccess('', 200, 'ورود شماره همراه اجباری می باشد');
                    }
                }

            }
            $userId = Session::getUserId();
        foreach($array_final_document as $k=> $v) {
                $dataSendDodument = [
                    'user_id' => $userId,
                    'parent_id' => $last_id,
                    'tracking_code' => $trackingCode,
                    'name' => $v['name'],
                    'national_code' => $v['national_code'],
                    'mobile' => $v['mobile'],
                    'email' => $v['email']
                ];

                $result = $this->getModel('sendDocumentsModel')->insertWithBind($dataSendDodument);
        }

            if (isset($_FILES['gallery_files']) && $_FILES['gallery_files'] != "") {
                $separated_files = functions::separateFiles('gallery_files');
                foreach ($separated_files as $file_key => $separated_file) {
                    $_FILES['file'] = $separated_file;
                    $_FILES['file']['name'] = self::changeNameUpload( $_FILES['file']['name']);
                    $config = Load::Config('application');
                    $config->pathFile('sendDocuments/' . CLIENT_ID .'/' );
                    $success = $config->UploadFile("pic", "file", 999000000000);
                    $explode_name_pic = explode(':', $success);
                    if ($explode_name_pic[0] == "done") {
                        $dataSendDocumentFile = [
                            'document_id' => $last_id,
                            'file_path' => $explode_name_pic[1]
                        ];
                       $this->getModel('sendDocumentAttachmentModel')->insertWithBind($dataSendDocumentFile);

                    }

                }
            }

//           return functions::withSuccess('', 200, 'ارسال اطلاعات با موفقیت انجام شد');
            $text_result = functions::Xmlinformation('YourRequestHasBeenSuccessfullyRegistered')->__toString(). '<br>'. functions::Xmlinformation('YourTrackingCode')->__toString() .':' . $trackingCode;
            return self::returnJson(true,  $text_result);

        }else{
            return functions::withSuccess('', 200, 'هیچ مدارکی ارسال نشده است');

        }




    }

    public function listDocuments($get_data = []) {
        $document_model = $this->getModel('sendDocumentsModel')->get()->where('deleted_at', null, 'IS')->groupBy('parent_id')->orderBy('id' , 'DESC');
        $result = $document_model->all(false);
        return $result;
    }
    public function listPeopleDocument($id) {
        $document_model = $this->getModel('sendDocumentsModel')->get()->where('deleted_at', null, 'IS')->where('parent_id', $id)->orderBy('id' , 'DESC');
        $result = $document_model->all(false);
        return $result;
    }

    public function getDetailDocument($id) {
        $document_model = $this->getModel('sendDocumentsModel')->get()->where('parent_id', $id)->orderBy('id' , 'DESC')->limit(1);
        $result_update = $document_model->all(false);
        if ($result_update[0]['status'] == 'not_seen'){
            $dataUpdate = [
                'status' => 'seen',
                'updated_seen_admin_at' => date('Y-m-d H:i:s', time()),
            ];
            $this->getModel('sendDocumentsModel')->updateWithBind($dataUpdate, ['parent_id' => $id]);
        }
        $document_model = $this->getModel('sendDocumentsModel');
        $document_table = $document_model->getTable();
        $result = $document_model
            ->get(
                [
                    $document_table . '.*',
                ], true
            )
            ->where($document_table . '.parent_id', $id)
            ->find(false);
        return $this->addSendDocumentsIndexes([$result])[0];
    }


    public function getReceivedDocument($id) {
        $list = $this->getModel('sendDocumentAttachmentModel')->get()->where('document_id', $id);
        return $list->all();
    }
    public function updateAdminResponse($params) {
        $dataUpdate = [
            'admin_result' => $params['admin_result'],
            'status' => $params['status_id'],
            'admin_id' => CLIENT_ID,
            'updated_at' => date('Y-m-d H:i:s', time()),
        ];
        $update = $this->getModel('sendDocumentsModel')->updateWithBind($dataUpdate, ['parent_id' => $params['document_id']]);
        if ($update) {
            return self::returnJson(true, functions::Xmlinformation('AdminResponseSuccessfullySystem')->__toString());
        }
        return self::returnJson(false, functions::Xmlinformation('Errorrecordinginformation')->__toString(), null, 500);
    }

    public function infoSendDocumentsTracking($trackingCode) {
        $document_model = $this->getModel('sendDocumentsModel');
        $document_table = $document_model->getTable();
        $sql = $document_model
            ->get(
                [
                    $document_table . '.*',
                ], true
            )
            ->where($document_table . '.tracking_code', $trackingCode)
            ->find(false);
        $list_model = $this->getModel('sendDocumentsModel')->get()->where('parent_id', $sql['id']);
        $list_person =  $list_model->all();

        $file_model = $this->getModel('sendDocumentAttachmentModel')->get()->where('document_id', $sql['id']);
        $list_file =  $file_model->all();

        if (!empty($sql)) {


            $result = '';
            $result .= '
            <div class="">
            <table class="display" cellspacing="0" width="100%" border="1" style="margin: 20px 0; border: 5px solid #b9b5b5;">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('Namefamily')->__toString().'</th>
                    <th>'.functions::Xmlinformation('NationalCode')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Mobile')->__toString().'</th>
                    <th>'.functions::Xmlinformation('Email')->__toString().'</th>
                </tr>
                </thead>
                <tbody>
            ';
            if (!empty($list_person)) {
                foreach ($list_person as $key => $value) {
                    $result .= '<tr>';
                    $result .= '<td>' . $value['name'] . '</td>';
                    $result .= '<td>' . $value['national_code'] . '</td>';
                    $result .= '<td>' . $value['mobile'] . '</td>';
                    $result .= '<td>' . $value['email'] . '</td>';
                    $result .= '</tr>';
                }
                $result .= '</table>';
                $result .= '</div>';
                $result .= '<div class="parent-file">';
                if ($sql['tracking_code']) {
                    $result .= '<div>';
                    $result .= '' . functions::Xmlinformation('TrackingCode')->__toString() . '  :  ';
                    $result .= '' . $sql['tracking_code'] . '';
                    $result .= '</div>';
                }

                if ($sql['status'] == 'not_seen') {
                    $result .= "<p class='text-order bg-warning' >" . functions::Xmlinformation('AdminHasNotseen')->__toString() . "</p>";
                } elseif ($sql['status'] == 'seen') {
                    $result .= "<p class='text-order bg-success' >" . functions::Xmlinformation('AdminHasSeen')->__toString() . "</p>";
                } elseif ($sql['status'] == 'accept') {
                    $result .= "<p class='text-order bg-success' >" . functions::Xmlinformation('AcceptUserRequest')->__toString() . "</p>";
                } elseif ($sql['status'] == 'reject') {
                    $result .= "<p class='text-order bg-danger' >" . functions::Xmlinformation('RejectUserRequest')->__toString() . "</p>";
                }
                $result .= '</div>';
                $result .= '<div class="parent-btn-order">';
                if ($sql['admin_result'] != '') {
                    $result .= '<div >';
                    $result .= '<span class=" ml-2">' . functions::Xmlinformation('AdminResponseToYourRequest')->__toString() . ' :</span>';
                    $result .= '<span class="font-18">' . $sql['admin_result'] . '</span>';
                    $result .= '</div>';
                }
                $result .= '</div>';
                $result .= '<div class="container">';
                $result .= '<h2 style="margin: 33px 0 0px 0; font-size: 20px; font-weight: bold;">لیست فایل های شما</h2>';
                $result .= '<table class="display" cellspacing="0" width="100%" border="1" style="margin: 20px 0; border: 5px solid #b9b5b5;">
                <thead>
                <tr>
                    <th>'.functions::Xmlinformation('Row')->__toString().'</th>
                    <th>'.functions::Xmlinformation('file')->__toString().'</th>
                </tr>
                </thead>';
                $result .= '<tbody>';
                $number = 0;
                foreach ($list_file as $key => $value) {
                    $value['file'] = $this->photoUrl . 'sendDocuments/' . CLIENT_ID . '/'. $value['file_path'];
                    $number = $number+1;
                    $result .= '<tr>';
                    $result .= '<td>' . $number . '</td>';
                    $result .= '<td><a href="' . $value['file'] . '" target="_blank">مشاهده فایل </a></td>';
                    $result .= '</tr>';
                }
                $result .= '</table>';
                $result .= '</div>';


            }
            $result .= '';
            return $result;

        }
    }
}


