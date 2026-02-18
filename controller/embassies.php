<?php

class embassies extends clientAuth {
    protected $embassies_model;
    public function __construct() {
        parent::__construct();
        $this->embassies_model = $this->getModel('embassiesModel');
    }

    public function addEmbassy($params)
    {
        $json_contact_information = json_encode($params['embassyNumber'],256);

        $exist = $this->embassies_model->get('id')
            ->where('name', $params['embassyName'])
            ->where('country_id', $params['country'])
            ->where('address', $params['embassyAddress'])
            ->where('language', $params['language'])
            ->where('description', $params['embassyDescription'])
            ->where('contact_information', $json_contact_information)
            ->where('lat', $params['lat'])
            ->where('lng', $params['lng'])
            ->find();
        if (!$exist) {
            $insert_data = $this->embassies_model
                ->insertWithBind([
                    'name' => $params['embassyName'],
                    'address' => $params['embassyAddress'],
                    'country_id' => $params['country'],
                    'language' => $params['language'],
                    'description' => $params['embassyDescription'],
                    'contact_information' => $json_contact_information,
                    'lat' => $params['lat'],
                    'lng' => $params['lng']
                ]);
            if ($insert_data) {
                return functions::JsonSuccess($insert_data, 'اطلاعات سفارت خانه با موفقیت ثبت گردید');
            }
            return functions::JsonError($insert_data, 'خطا در ثبت اطلاعات سفارت خانه',200);
        }
        return functions::JsonError(false, 'اطلاعات سفارت خانه وارد شده، قبلا ثبت شده است',200);
    }
    public function getEmbassies($get_all = null)
    {
        if ($get_all) {
            $embassies = $this->embassies_model->get()->all();
        } else {
            $embassies = $this->embassies_model
                ->get()
                ->where('language', SOFTWARE_LANG)
                ->all();
        }


        return $this->embassyIndexes($embassies);
    }

    public function embassyIndexes($embassies) {
        $result=[];
        foreach ($embassies as $key=>$embassy) {
            $result[$key]=$embassy;
            $result[$key]['contact_information']=json_decode($embassy['contact_information'],true);
            $result[$key]['country']=$this->getEmbassyCountry($embassy);
            $result[$key]['flag']=ROOT_ADDRESS_WITHOUT_LANG.'/pic/flags/'.$result[$key]['country']['code_two_letter'].'.png';

        }

        return $result;
    }
    public function getEmbassyCountry($embassy) {

        $country_controller=$this->getController('country');
        return $country_controller->getCountry($embassy['country_id']);
    }
    public function getEmbassy($id)
    {
        return $this->embassies_model->get()->where('id', $id)->all();
    }
    public function getCountries()
    {
        $country_controller=$this->getController('country');
        return $country_controller->getCountries();
    }
    public function editEmbassy($params)
    {
        $json_contact_information = json_encode($params['embassyNumber'],256);
        $update_data = $this->embassies_model->get()
            ->updateWithBind([
                'name' => $params['embassyName'],
                'address' => $params['embassyAddress'],
                'language' => $params['language'],
                'country_id' => $params['country'],
                'description' => $params['embassyDescription'],
                'contact_information' => $json_contact_information,
                'lat' => $params['lat'],
                'lng' => $params['lng']
            ],[
                'id' => $params['id']
            ]);
        if ($update_data) {
            return functions::JsonSuccess($update_data, 'اطلاعات سفارت خانه با موفقیت بروز گردید');
        }
        return functions::JsonError($update_data, 'خطا در بروزرسانی اطلاعات سفارت خانه',200);
    }

    public function removeEmbassy($params) {
        $result= $this->embassies_model->delete([
            'id'=>$params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'سفارت خانه مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف سفارت خانه',200);
    }
}