<?php
//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
class faqs extends positions
{
    protected $faqs_model;

    public function __construct() {
        parent::__construct();
        $this->faqs_model = $this->getModel('faqsModel');
    }

    public function addFaq($params) {
        $position = [] ;
        $insert_data = $this->faqs_model
            ->insertWithBind([
                'title' => $params['title'],
                'content' => $params['content'],
                'language' => $params['language'],
                'order_number' => 0
            ]);

        if ($insert_data) {

            $this->storePositions('faq',$insert_data,$params['position']);


            return functions::JsonSuccess($insert_data, 'اطلاعات سوالات متداول با موفقیت ثبت گردید');
        }
        return functions::JsonError($insert_data, 'خطا در ثبت اطلاعات سوالات متداول', 200);

    }

    public function editFaq($params) {
        $faq = $this->faqs_model->get()->where('id', $params['faq_id'])->find();

        if ($faq) {

            $this->resetPositions('faq',$params['faq_id'],$params['position']);


            $update_data = $this->faqs_model->get()
                ->updateWithBind([
                    'title' => $params['title'],
                    'content' => $params['content'],
                    'order_number' => $params['order_number'],
                    'language' => $params['language']
                ], [
                    'id' => $params['faq_id']
                ]);




                return self::returnJson(true, 'پرسش و پاسخ شما با موفقیت در سیستم بروزرسانی شد');


        }
        return self::returnJson(false, 'موردی یافت نشد',null, 500);
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

    public function getFaqs() {
        $faqs = $this->faqs_model->get()->all();
        return $this->faqIndexes($faqs);
    }

    public function faqIndexes($faqs) {
        $result = [];
        foreach ($faqs as $key => $faq) {

            $result[$key] = $faq;
            $result[$key]['positions'] = $this->getFaqPosition($faq['id']);

        }

        return $result;
    }

    public function getFaqPosition($faq_id) {
        return $this->getPositions('faq',$faq_id);
    }

    public function getFaq($id) {

        $faq = $this->faqs_model->get()->where('id', $id)->find();
        return $this->faqIndexes([$faq])[0];
    }


    public function removeFaq($params) {
        $result = $this->faqs_model->delete([
            'id' => $params['id']
        ]);
        if ($result) {
            return functions::JsonSuccess($result, 'سوالات متداول مورد نظر حذف شد');
        }
        return functions::JsonError($result, 'خطا در حذف سوالات متداول', 200);
    }


    public function getByPosition($data_search) {


        $ids=$this->getItemsByPosition('faq',$data_search);

        $faq_table = $this->faqs_model->getTable();

        if (!isset($data_search['limit']) || empty($data_search['limit'])) {
            $data_search['limit'] = 10;
        }
        if (!isset($data_main_page['order']) || empty($data_main_page['order'])) {
            $data_main_page['order'] = 'ASC';
        }

        $faqs=$this->faqs_model->get()
            ->whereIn($faq_table . '.id' , $ids)
            ->whereIn($faq_table . '.language' , SOFTWARE_LANG)
            ->orderBy('order_number' , $data_main_page['order'])
            ->limit(0,$data_search['limit'])
            ->all();

        return  $this->faqIndexes($faqs);
    }

    public function listAllPositions($serviceGroup = null) {

        if (!$serviceGroup) {
            return false;
        }
        if (isset($serviceGroup['service']) && $serviceGroup['service'] != '') {
            $serviceGroup = $serviceGroup['service'];
        }
        $allServiceGroup = $this->getServices();
        if (!in_array($serviceGroup, array_keys($allServiceGroup))) {
            return false;
        }
        $method = 'ListPosition' . $serviceGroup;

        return $this->$method();

    }

    public function getServices($countFaq = false) {

        $services = $this->getAccessServiceClient();
        $list = [];

        $list['internalFlight'] = [
            'Title' => 'بلیط داخلی',
            'id' => '',
            'MainService' => 'internalFlight',
            'order_number' => '50',
        ];
        $list['internationalFlight'] = [
            'Title' => 'بلیط خارجی',
            'id' => '',
            'MainService' => 'internationalFlight',
            'order_number' => '50',
        ];

        foreach ($services as $service) {
            if (in_array($service['MainService'], array('Entertainment', 'Europcar'))) {
                continue;
            }


            $list[$service['MainService']] = $service;
        }
        $list['contactUs'] = [
            'Title' => 'تماس با ما',
            'id' => '',
            'MainService' => 'contactUs',
            'order_number' => '50',
        ];
        $list['Public'] = [
            'Title' => 'عمومی',
            'id' => '',
            'MainService' => 'Public',
            'order_number' => '50',
        ];
        $list['Flight'] = [
            'Title' => 'پرواز (صفحه اختصاصی)',
            'id' => '',
            'MainService' => 'Public',
            'order_number' => '50',
        ];

        if ($countFaq == True) {
                foreach($list as $k => $v) {
                    $array_item[] = $v['MainService'];
                }
            $positions_model = $this->getModel('positionsModel');
            $positions_table = $positions_model->getTable();
                foreach($array_item as $k => $v){
                    $faq_count = $positions_model
                        ->get([
                            'count(' . $positions_table . '.id) as count',
                        ], true)
                        ->where('module', faq)
                        ->where('service', $v)->all(false);

                    $list[$v]['countFaq'] = $faq_count[0]['count'];
                }

        }
        return $list;
    }


    public function getPassedFaqIds(array $positions, $data_search) {
        $faq_ids = [];

        foreach ($positions as $position) {
            $faq_positions = json_decode($position['positions'], true);

            foreach ($faq_positions as $faq_position) {
                $first_position = $faq_position;
                $second_position = null;

                if (strpos($faq_position, ':') !== false) {
                    $exploded=explode(':', $faq_position);
                    $first_position=$exploded[0];
                    $second_position=$exploded[1];
                }

                $is_valid_position = false;

                if (array_key_exists('origin', $data_search) && $data_search['origin'] !== '') {
                    $is_valid_position = $this->isValidPosition($data_search['origin'], $first_position, $second_position, $data_search['secondary']);
                }
                if (array_key_exists('destination', $data_search) && $data_search['destination'] !== '' && !$is_valid_position) {
                    $is_valid_position = $this->isValidPosition($data_search['destination'], $first_position, $second_position, $data_search['secondary']);
                }


                if ($is_valid_position && !in_array($position['faq_id'], $faq_ids)) {
                    $faq_ids[] = (int) $position['faq_id'];
                }

            }
        }
        return $faq_ids;
    }

    private function isValidPosition($search_position, $first_position, $second_position, $secondary_position)
    {
        if (empty($second_position)) {
            return $search_position === $first_position || $first_position === 'all';
        }

        if ($second_position === 'all') {
            return $first_position === 'all' || $search_position === $first_position;
        }

        return ($search_position === $first_position || $first_position === 'all')
            && ($secondary_position === $second_position || $secondary_position === 'all');
    }


    public function allFaqMainByPosition($data_search) {

        $array_item=array();
        foreach($data_search['service'] as $k => $v){
            $array_item[]=$v['MainService'];
        }
        $faq_model = $this->faqs_model;
        $faq_table = $faq_model->getTable();
        $positions_model = $this->getModel('positionsModel');
        $positions_table = $positions_model->getTable();
        $arr = array();
        foreach ($array_item as $key => $value) {
            $arr['category']= $value;
            $faqs = $faq_model->get([
                $faq_table.'.*',
                $faq_table . '.id AS fId',
                $positions_table.'.*',
                $positions_table . '.id AS pId',
            ] ,true)
                ->join($positions_table, 'item_id', 'id')
                ->where($faq_table . '.language' , SOFTWARE_LANG)
                ->where($positions_table . '.service' , $value)
                ->where($positions_table . '.module' , faq);
                $arr[$value] = $faqs->all();

        }
        return  $arr;
    }

    public function changeOrderFaqs($params){
        if (isset($params['data'])) {
            foreach ($params['data'] as $k => $v) {
                $model = $this->getModel('faqsModel');
                $dataUpdate = [
                    'order_number' => $v
                ];
                $model->updateWithBind($dataUpdate, ['id' => $k]);
            }
            return self::returnJson(true, 'درخواست شما با موفقیت انجام شد');
        }else {
            return self::returnJson(true, 'هیچ موردی انتخاب نشده یا تغییری اعمال نشده است');
        }
    }
}