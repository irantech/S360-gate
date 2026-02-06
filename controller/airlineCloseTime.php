<?php

//    error_reporting(1);
//    error_reporting(E_ALL);
//    @ini_set('display_errors', 1);
//    @ini_set('display_errors', 'on');

class airlineCloseTime  extends clientAuth {


    public function __construct() {

        parent::__construct();
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

    public function getAll()
    {
        $airline_model = $this->getModel('airlineModel');
        $airlines = $airline_model
            ->get()
            ->limit(0, 20)
            ->all();

        $airline_close_time_model = $this->getModel('airlineCloseTimeModel');
        $closeTimes = $airline_close_time_model
            ->get()
            ->limit(0, 20)
            ->all();

        foreach ($airlines as &$airline) {
            foreach ($closeTimes as $closeTime) {
                if ($airline['id'] === $closeTime['airline_id']) {
                    $airline['close_time_internal'] = $closeTime['internal'];
                    $airline['close_time_external'] = $closeTime['external'];
                    break;
                }
            }
        }
        unset($airline);

        return $airlines;
    }

    public function getCloseTimeList()
    {
        $airline_close_time_model = $this->getModel('airlineCloseTimeModel');
        $closeTimes = $airline_close_time_model
            ->get()
            ->all();
        return $closeTimes;
    }

    public function getGlobalTime()
    {
        $airline_close_time_model = $this->getModel('airlineCloseTimeModel');
        $globalTime = $airline_close_time_model
            ->get()
            ->where('airline_id' , 'GLOBAL')
            ->find();
        return $globalTime;
    }

    public function insertTime()
    {
        $internalTime = $_POST['internalTime'];
        $externalTime = $_POST['externalTime'];
        $airlineId = $_POST['airlineId'];

        if ($airlineId === '') {
            $update_data = [
                'internal' => $internalTime,
                'external' => $externalTime,
            ];
            $update_result = $this->getModel('airlineCloseTimeModel')->get()
                ->updateWithBind($update_data, [
                    'airline_id' => 'GLOBAL'
                ]);
            if ($update_result) {
                $message = 'ویرایش تنظیمات کلی با موفقیت انجام شد';
                return $this->returnJson(true, $message);
            } else {
                $message = 'در ویرایش تنظیمات کلی خطایی رخ داده';
                return $this->returnJson(false, $message);
            }
        }
        else {

            $airline_close_time_model = $this->getModel('airlineCloseTimeModel');
            $airline = $airline_close_time_model
                ->get()
                ->where('airline_id' , $airlineId)
                ->find();

            if ($airline) {
                $update_data = [
                    'internal' => $internalTime,
                    'external' => $externalTime,
                ];
                $update_result = $this->getModel('airlineCloseTimeModel')->get()
                    ->updateWithBind($update_data, [
                        'airline_id' => $airlineId
                    ]);

                if ($update_result) {
                    $message = 'ویرایش تنظیمات ایرلاین موفقیت انجام شد';
                    return $this->returnJson(true, $message);
                } else {
                    $message = 'در ویرایش ایرلاین خطایی رخ داده';
                    return $this->returnJson(false, $message);
                }
            } else {
                $airline_model = $this->getModel('airlineModel');
                $airline = $airline_model
                    ->get()
                    ->where('id' , $airlineId)
                    ->find();

                $insert_data = [
                    'airline_id' => $airline['id'],
                    'internal' => $internalTime,
                    'external' => $externalTime,
                ];
                $insert_result = $this->getModel('airlineCloseTimeModel')
                    ->insertWithBind($insert_data);

                if ($insert_result) {
                    $message = 'ویرایش تنظیمات ایرلاین موفقیت انجام شد';
                    return $this->returnJson(true, $message);
                } else {
                    $message = 'در ویرایش ایرلاین خطایی رخ داده';
                    return $this->returnJson(false, $message);
                }
            }
        }
    }

    public function deleteCloseTime($airlineId)
    {
        $airline_close_time_model = $this->getModel('airlineCloseTimeModel');
        $airline = $airline_close_time_model
            ->get()
            ->where('airline_id' , $airlineId)
            ->find();

        if (!$airline) {
            $message = 'عملیات با موفقیت انجام شد';
            return $this->returnJson(true, $message);
        }

        $airline_close_time_model = $this->getModel('airlineCloseTimeModel');
        $delete_result = $airline_close_time_model->delete("airline_id='{$airlineId}'");
        if ($delete_result) {
            $message = 'عملیات با موفقیت انجام شد';
            return $this->returnJson(true, $message);
        } else {
            $message = 'در انجام در عملیات خطایی رخ داده است';
            return $this->returnJson(false, $message);
        }
    }

}