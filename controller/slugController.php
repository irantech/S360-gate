<?php

class slugController extends ClientAuth
{
    protected static $model;
    protected static $lang = ['en', 'fa', 'ar' ,'ru'];

    public static function getModelClass() {
        return static::$model;
    }

    public function modelItems($model) {
        $model = strtolower($model);

        $class_name = $model . 'SlugController';
        /** @var tourSlugController $controller */

        $controller = new $class_name();
        return $controller->getData();
    }
    public function getCityName($city_id) {
        return $this->getModel(reservationCityModel::class)
            ->get()
            ->where("id", $city_id)
            ->find(false);
    }

    public static function getLang() {
        return static::$lang;
    }

    public function getServices() {

        $services = $this->getAccessServiceClient();
        $list = [];
        foreach ($services as $service) {
            if (in_array($service['MainService'], array('Entertainment', 'Europcar'))) {
                continue;
            }
            $list[$service['MainService']] = $service;
        }
        /* $list['Public'] = [
             'Title' => 'عمومی',
             'id' => '',
             'MainService' => 'Public',
             'order_number' => '50',
         ];*/
        /*todo other services*/
        return ['Tour' => [
            "Title" => "تور",
            "id" => "6",
            "MainService" => "Tour",
            "order_number" => "7",
        ]];
    }


    public function findById($id, $self = false) {
            $result = $this->getModel(slugModel::class)
                ->get()
                ->where("id", $id)
                ->where('model', self::getModelClass())
                ->where('deleted_at', null, ' IS ')
                ->orderBy()
                ->find(false);
            $result['self'] = true;

        return $result;
    }

    public function callUpdate($params) {
        $result = $this->update($params['id'], $params['self'], $params['new_slug'], $params['lang']);
        if ($result) {
            return json_encode([
                'status' => true,
            ]);
        }
    }

    public function update($id, $self, $new_slug, $lang) {
             $result = $this->getModel(slugModel::class)
                ->get()
                ->where("id", $id)
                ->where('model', self::getModelClass())
                ->where('deleted_at', null, ' IS ')
                ->orderBy()
                ->find(false);



        if ($result) {

            $result['slug_' . $lang] = $new_slug;
            if ($self === true || $self === '1' || $self === 1) {

                $this->getModel(slugModel::class)->get()
                    ->updateWithBind($result, [
                        'id' => $id,
                    ]);
            } else {
                $result['parent_slug_id'] = $result['id'];
                unset($result['id']);
                unset($result['created_at']);
                unset($result['updated_at']);
                unset($result['deleted_at']);
                $this->getModel(slugModel::class)->get()
                    ->insertWithBind($result);
            }


        }
        return $result;
    }

    public function getSlug($slug, $lang = null) {
        if (!$lang) {
            $lang = SOFTWARE_LANG;
        }

        $slug = strtok($slug, '&?'); // Remove query parameters if present
        //remove "تور-های" from slug

        $slug = str_ireplace('تور-های-', '', $slug);

        $result = $this->getModel(slugModel::class)
            ->get()
            ->where('model', self::getModelClass())
            ->where("slug_" . $lang, $slug)
            ->where('deleted_at', null, ' IS ')
            ->orderBy()
            ->find(false);



        $result['self'] = true;



        $result = $this->getModel(slugModel::class)
            ->get()
            ->where('model', self::getModelClass())
            ->where("slug_" . $lang, $slug)
            ->where('deleted_at', null, ' IS ')
            ->orderBy()
            ->find(false);


        $result['self'] = true;

//        if (isset($result['id'])&& !$result['id']) {
//            $result = $this->getModel(slugBaseModel::class)
//                ->get()
//                ->where('model', self::getModelClass())
//                ->where("slug_" . $lang, $slug)
//                ->where('deleted_at', null, ' IS ')
//                ->orderBy()
//                ->find(false);
//            $result['self'] = false;
//        }


        if (isset($result['id']) && $result['id']) {
            $result['data'] = json_decode($result['data'], true);
            return $result;
        }

        return null;
    }

    public function callReverse($params) {
        return $this->reverse([
            'country_id'=>$params['params']['country_id'],
            'city_id'=>$params['params']['city_id']
        ]);
    }
    public function reverse($params, $redirect = false) {


        $slugModel = $this->getModel('slugModel')
            ->get()
            ->where('model', self::getModelClass());


        foreach ($params as $key => $value) {

            $slugModel = $slugModel->where('data LIKE', '%"' . $key . '":"' . $value . '"%', '');
        }
     
        $result = $slugModel->where('deleted_at', null, ' IS ')
            ->orderBy()
            ->find(false);

        if ($result) {
            $result['self'] = true;
        }


        return $result;
    }

    public function getByParentId($id) {
        return $this->getModel(slugModel::class)
            ->get()
            ->where('parent_slug_id', $id)
            ->where('deleted_at', null, ' IS ')
            ->orderBy()
            ->find(false);
    }

    public function merge($array1, $array2) {
        foreach ($array2 as $key => $value) {
            if (isset($value['parent_slug_id'])) {
                foreach ($array1 as $index => $item) {
                    if ($item['id'] == $value['parent_slug_id']) {
                        $array1[$index] = $value;
                        break;
                    }
                }
            }
        }
        return $array1;
    }

    public function getData() {

        $self = $this->getModel(slugModel::class)
            ->get()
            ->where('model', self::getModelClass())
            ->all();



        $re_self=[];
        foreach ($self as $key=>$item) {
            $re_self[$key]=$item;
            $re_self[$key]['self']=1;
        }


        return $re_self;
    }

    public function store($title, $data) {


        $slugData = ['model' => self::getModelClass(), 'data' => json_encode($data, 256 | 64)];

        $status = true;
        foreach (self::getLang() as $lang) {
            $slug = Functions::slugify($title[$lang]);


            if ($this->getSlug($slug, $lang)) {
                $status = false;
            }
            $slugData["slug_$lang"] = $slug;
        }
        
            $this->getModel('slugModel')->get()->insertWithBind($slugData);

    }
}
