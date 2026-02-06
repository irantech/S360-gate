<?php

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class apiCodeExist extends baseController
{
    public function insertCode($params = array())
    {
        $dataInsert = [
            'unique_code' => $params['code'],
            'service_type' => $params['service'],
            'method' => $params['method'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->getModel('apiCodeExistModel')->insertWithBind($dataInsert);
    }

    public function checkExists($code, $method = '', $service = '')
    {

        $model = $this->getModel('apiCodeExistModel');
        $result = $model->get('id')->where('unique_code', $code);
        if ($method) {
            $result = $result->where('method', $method);
        }
        if ($service) {
            $result = $result->where('service_type', $service);
        }

       $result =  $result->orderBy('id','DESC')->find() ;
        functions::insertLog('request==>' . $code . 'cvvvv '.json_encode($result).'==> checkExists','log_train_fateme');

        return $result ;
    }
}