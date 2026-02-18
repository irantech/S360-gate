<?php
class sources extends clientAuth
{

    public function __construct() 
    {
        parent::__construct();
    }
    public function listAllSource() {
        $sourceList = $this->getModel('sourceModel')
            ->get()
            ->orderBy('name_fa')
            ->all();
        return $sourceList;
    }
    public function SourceStatus($params)
    {
        if (isset($params['source_id'])) {
            // Check current status
            $current = $this->getModel(sourceModel::class)
                ->get(['isActive'])
                ->where('id', $params['source_id'])
                ->find();
            if($current['isActive']==1){
                $isActive='0';
            }
            else{$isActive='1';}

            $result = $this->getModel(sourceModel::class)
                ->get()
                ->updateWithBind([
                    'isActive' => $isActive
                ], [
                    'id' => $params['source_id']
                ]);

            if ($result) {
                $resultCore = $this->getController('settingCore')->SourceStatusCore($params['source_id'],$isActive);

                if ($resultCore) {
                    return [
                        'success' => true,
                        'message' => 'Status updated successfully'
                    ];
                }else {
                    return [
                        'success' => false,
                        'message' => $resultCore.'Failed to update status in core'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to update status'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Missing source_id parameter'
            ];
        }
    }
    public function saveSource()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $data = [
            'name' => isset($input['name']) ? $input['name'] : '',
            'name_fa' => isset($input['name_fa']) ? $input['name_fa'] : '',
            'nickName' => isset($input['nickName']) ? $input['nickName'] : '',
            'sourceType' => isset($input['sourceType']) ? $input['sourceType'] : '',
            'sourceCode' => isset($input['sourceCode']) ? $input['sourceCode'] : '',
            'fareStatus' => isset($input['fareStatus']) ? $input['fareStatus'] : '',
            's_d_a_d' => isset($input['s_d_a_d']) ? $input['s_d_a_d'] : '0',
            's_kh_a_kh' => isset($input['s_kh_a_kh']) ? $input['s_kh_a_kh'] : '0',
            's_kh_a_d' => isset($input['s_kh_a_d']) ? $input['s_kh_a_d'] : '0',
            'ch_d_a_d' => isset($input['ch_d_a_d']) ? $input['ch_d_a_d'] : '0',
            'ch_kh_a_kh' => isset($input['ch_kh_a_kh']) ? $input['ch_kh_a_kh'] : '0',
            'ch_kh_a_d' => isset($input['ch_kh_a_d']) ? $input['ch_kh_a_d'] : '0',
            's_kh_a_kh_au' => isset($input['s_kh_a_kh_au']) ? $input['s_kh_a_kh_au'] : '0',
            'isActive' => isset($input['isActive']) && $input['isActive'] ? '1' : '0',
            'username' => isset($input['username']) ? $input['username'] : '',
            'password' => isset($input['password']) ? $input['password'] : '',
            'token' => isset($input['token']) ? $input['token'] : '',
            'creationDate' => date('Y/m/d'),
            'creationTime' => date('H:i:s'),
            'creationDateInt' => time()
        ];
        // اگر id خالی باشد، یعنی INSERT انجام بده
        if (empty($input['id'])) {
            $res = $this->getModel('sourceModel')->insertWithBind($data);
            $id='';
        } else {
            // در غیر این صورت UPDATE کن

            // در ویرایش نباید فیلدهای زمان ایجاد تغییر کنند
            unset(
                $data['creationDate'],
                $data['creationTime'],
                $data['creationDateInt']
            );

            $res = $this->getModel('sourceModel')
                ->get()
                ->updateWithBind(
                    $data,
                    ['id' => $input['id']]
                );
            $id=$input['id'];
        }
        if ($res) {
            unset(
                $data['fareStatus'],
                $data['s_d_a_d'],
                $data['s_kh_a_kh'],
                $data['s_kh_a_d'],
                $data['ch_d_a_d'],
                $data['ch_kh_a_kh'],
                $data['ch_kh_a_d'],
                $data['s_kh_a_kh_au']
            );
            $resultCore = $this->getController('settingCore')->saveSourceCore($data,$id);
            $resultCore = json_decode($resultCore, true);
            // بررسی وضعیت برگشتی از API
            if (isset($resultCore['status']) && $resultCore['status'] == 'success') {
                functions::JsonSuccess($resultCore['Message']);
            } else {
                functions::JsonError(isset($resultCore['Message']) ? $resultCore['Message'] : 'خطا در ارتباط با سرور مرکزی');
            }

        } else {
            functions::JsonError('خطا در ثبت رکورد');
        }
    }
    public function getSourceById()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = isset($input['id']) ? intval($input['id']) : 0;

        if ($id <= 0) {
            functions::JsonError('شناسه نامعتبر است');
            return;
        }

        $source = $this->getModel('sourceModel')
            ->get()
            ->where('id', $id)
            ->find();
        return $source;
    }

}
