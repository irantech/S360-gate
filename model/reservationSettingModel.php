<?php

class reservationSettingModel extends Model {

    protected $table = "reservation_setting_tb";

    public function getAll() {

        return  $this->get(['*'])->all();
    }

    public function getById($id) {
        return  $this->get(['*'])->where('id' , $id)->find();
    }
    public function getByTitle($title) {
        return  $this->get(['*'])->where('title' , $title)->find();
    }
    public function getByTitleService($title , $service) {
        return  $this->get(['*'])->where('title' , $title)->where('service' , $service )->all();
    }
    public function enableSetting($id) {
        $data = [
          'enable' => 1
        ];
        return $this->update($data, [
                'id' => $id
        ]);
    }

    public function disableSetting($id) {
        $data = [
            'enable' => 0
        ];
        return $this->update($data, [
            'id' => $id
        ]);
    }
    public function changeEnable($id) {
        $setting = $this->getById($id);

        if($setting['enable'] == 0 ){
            $data = [
                'enable' => 1
            ];
        }else{
            $data = [
                'enable' => 0
            ];
        }
        $Condition = "id='{$setting['id']}' ";
        return  $this->update($data, $Condition);

    }
}