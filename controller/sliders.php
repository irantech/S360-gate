<?php


class sliders extends clientAuth {

    public function __construct() {
        parent::__construct();
    }


    public function listSliders($data_main_page = []) {
        $slider_list = $this->getModel('slidersModel')->get();
        if ($data_main_page['type_data']) {
            $slider_list->where('is_active', 1)->limit(1, $data_main_page['count_sliders']);
        }
        return $slider_list->all();
    }

    public function addSlider($data_sliders) {

        $data_upload['path_upload'] = 'slider_pic/' . CLIENT_ID.'/';
        $data_upload['file_name'] = 'image_slider';
        $result_upload = functions::uploadPic($data_upload);

        unset($data_sliders['image_slider']);
        $data_sliders['pic'] = $result_upload;
        $data_sliders['is_active'] = true;
        $data_sliders['creation_date_int'] = time();

        $result_insert_slider = $this->getModel('slidersModel')->insertWithBind($data_sliders);
        if ($result_insert_slider) {
            return functions::withSuccess('', 200, 'افزودن گالری بنر جدید با موفقیت انجام شد');
        }
        return functions::withError('', 400, 'خطا در ثبت گالری بنر جدبد');
    }


    public function editSlider($data_edit_slider) {

        $check_exist_slider = $this->findSliderById($data_edit_slider['id']);
        if ($check_exist_slider) {
            $data_edit_slider['pic'] = $check_exist_slider['pic'];
            if ($data_edit_slider['image_slider'] != $check_exist_slider['pic']) {
                $data_upload['path_upload'] =  'slider_pic/' . CLIENT_ID.'/' ;
                $data_upload['path_old_pic'] = PIC_ROOT . 'slider_pic/' . CLIENT_ID . '/' . $check_exist_slider['pic'];
                $data_upload['file_name'] = 'image_slider';
                $result_upload = functions::uploadPic($data_upload);
                $data_edit_slider['pic'] = $result_upload;
            }


            $condition_update ="id='{$check_exist_slider['id']}'";
            $result_update_slider = $this->getModel('slidersModel')->updateWithBind($data_edit_slider,$condition_update);
            if ($result_update_slider) {
                return functions::withSuccess('', 200, 'ویرایش گالری بنر  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش گالری بنر ');
        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }

    public function findSliderById($id) {
        return $this->getModel('slidersModel')->get()->where('id', $id)->find();
    }

    public function deleteSlider($data_update) {

        $check_exist_slider = $this->findSliderById($data_update['id']);
        if ($check_exist_slider) {
            $path = PIC_ROOT . 'slider_pic/' . CLIENT_ID . '/' . $check_exist_slider['pic'];
            $result_update_slider = $this->getModel('slidersModel')->delete("id='{$data_update['id']}'");
            if ($result_update_slider) {
                unlink($path);
                return functions::withSuccess('', 200, 'حذف گالری بنر جدید با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ثبت گالری بنر جدبد');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');
    }


    public function updateStatusSlider($data_update) {

        $check_exist_slider = $this->findSliderById($data_update['id']);
        if ($check_exist_slider) {
            $data_update_status['is_active'] = ($check_exist_slider['is_active'] == 1) ? 0 : 1;
            $condition_update_status ="id='{$check_exist_slider['id']}'";
            $result_update_slider = $this->getModel('slidersModel')->updateWithBind($data_update_status,$condition_update_status);

            if ($result_update_slider) {
                return functions::withSuccess('', 200, 'ویرایش وضعیت گالری بنر  با موفقیت انجام شد');
            }
            return functions::withError('', 400, 'خطا در ویرایش وضعیت گالری بنر ');

        }
        return functions::withError('', 404, 'درخواست شما معتبر نمی باشد');

    }


}