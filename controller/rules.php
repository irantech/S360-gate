<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 10/3/2021
 * Time: 11:42 AM
 */
//if ($_SERVER['REMOTE_ADDR'] == '84.241.4.20') {
//    error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');
//}



class rules extends baseController {

    public function __construct(){

    	
    }

    public function getAllCategories($lang = 'fa') {
		/** @var ruleCategoryModel $ruleCategoryModel */
		$ruleCategoryModel = Load::getModel('ruleCategoryModel');
        $categories = $ruleCategoryModel->get()->where('language',$lang)->all();

		foreach ( $categories as $key => $category ) {
			$categories[$key]['rules'] = $ruleCategoryModel->rules($category['id']);
		}
//		echo json_encode($categories,256|64);
		return $categories;
	}
    public function getCategory($id) {
		/** @var ruleCategoryModel $ruleCategoryModel */
		$ruleCategoryModel = Load::getModel('ruleCategoryModel');
        return $ruleCategoryModel->get()->where('id',$id)->find();
	}

    public function addRule($data)
    {

        /** @var ruleModel $ruleModel */
        $ruleModel = Load::getModel('ruleModel');
        $resultAddRule = $ruleModel->newRule($data);
        if($resultAddRule)
        {
            return functions::withSuccess('',200,'افزودن قانون جدید با موفقیت انجام شد');
        }
        return functions::withError('',400,'خطا در افزودن قانون جدید');
	}
    public function editRule($data)
    {

        $id = $data['id'];
        unset($data['id']);

        /** @var ruleModel $ruleModel */
        $ruleModel = Load::getModel('ruleModel');
        $resultAddRule = $ruleModel->updateRule($id,$data);
        if($resultAddRule)
        {
            return functions::withSuccess('',200,'ویرایش قانون جدید با موفقیت انجام شد');
        }
        return functions::withError('',400,'خطا در ویرایش قانون جدید');
    }
    public function editRuleCategory($data)
    {

        $id = $data['category_id'];
//        unset($data['category_id']);
        $slug  = str_replace(' ','_',$data['slug']);

        /** @var ruleCategoryModel $ruleCategoryModel */
        $ruleCategoryModel = Load::getModel( 'ruleCategoryModel' );

        $check_slug = $ruleCategoryModel->get()->where('slug' , $slug)->where('id', $id, '!=')->find();

        if (!$check_slug) {
        /** @var ruleModel $ruleModel */
        $rule_category=$ruleCategoryModel->updateWithBind([
            'title'=>$data['title'],
            'slug'=>$slug,
            'icon'=>$data['icon'],
            'updated_at'=>date('Y-m-d H:i:s', time()),
        ], "id='{$id}'" );


//        $resultAddRule = $ruleModel->updateRule($id,$data);
        if($rule_category)
        {
            return functions::withSuccess('',200,'ویرایش دسته بندی با موفقیت انجام شد');
        }
        return functions::withError('',200,'خطا در ویرایش دسته بندی');
        } else {
//            return $this->widError( 'this slug has bee used', 400, 'slug_used' );
            return functions::withError('',200,'فیلد عنوان انگلیسی تکراری است!');
        }
    }

    public function getRule($id)
    {
        /** @var ruleModel $ruleModel */
        $ruleModel = Load::getModel('ruleModel');
        return $ruleModel->getRule($id);
	}
    public function deleteRule($id)
    {
        /** @var ruleModel $ruleModel */
        $ruleModel = Load::getModel('ruleModel');
        $check_delete =  $ruleModel->deleteRule($id['Param']);
        $select_status = 1;
        if ($check_delete) {
            return functions::JsonSuccess($check_delete, [
                'message' => 'category_deleted',
                'data' => $select_status
            ], 200);
        }
        return functions::JsonError($check_delete, [
            'message' => 'rule_delete_error',
            'data' => $select_status
        ], 200);
	}
}