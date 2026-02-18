<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 10/3/2021
 * Time: 5:51 PM
 */

class rulesCategory {
	protected function toJson( $data ) {
		return json_encode( $data, 256 | 64 );
	}
	
	protected function toArray( $data ) {
		if ( is_array( $data ) ) {
			return $data;
		}
		
		return json_decode( $data, true );
	}
	
	protected function withSuccess( $data = null, $statusCode = 200 ) {
		http_response_code( $statusCode );
		$return = [ 'success' => true, 'code' => $statusCode, 'message' => 'دسته بندی جدید ثبت شد', 'data' => $data ];
		
		return $this->toJson( $return );
	}
	
	protected function widError( $message = 'Bad Request', $statusCode = 400, $data = null ) {
		http_response_code( $statusCode );
		$return = [ 'success' => false, 'code' => $statusCode, 'message' => $message, 'data' => $data ];
		
		return $this->toJson( $return );
	}
	
	public function getAllCategories() {
		/** @var ruleCategoryModel $ruleCategoryModel */
		$ruleCategoryModel = Load::getModel( 'ruleCategoryModel' );
		$categories        = $ruleCategoryModel->get()->all();
	/*
		foreach ( $categories as $key => $category ) {
			$categories[ $key ]['rules'] = $ruleCategoryModel->rules( $category['id'] );
		}*/
		
		//		echo json_encode($categories,256|64);
		return $categories;
	}
	
	public function addCategory( $data = [] ) {
//        var_dump($data);
//        die;
		$title = $data['title'];
		$icon = $data['edited_icon_category'];
		$slug  = str_replace(' ','_',$data['slug']);
		/** @var ruleCategoryModel $ruleCategoryModel */
		$ruleCategoryModel = Load::getModel( 'ruleCategoryModel' );


        $check_slug = $ruleCategoryModel->get()->where('slug' , $slug)->where('language' , $data['lang'])->find();

        if (!$check_slug) {
            error_reporting(1);
            error_reporting(E_ALL | E_STRICT);
            @ini_set('display_errors', 1);
            @ini_set('display_errors', 'on');

            $insert = $ruleCategoryModel->add( [ 'title' => $title, 'slug' => $slug,'icon' => $icon, 'language' => $data['lang'] ] );

            if ( $insert ) {
                return $this->withSuccess();
            }
        } else {
            return $this->widError( 'this slug has bee used', 400, 'slug_used' );
        }
		
		return $this->widError( 'fails on insert', 400, $insert );
	}
	public function deleteCategory( $id ) {

        $ruleCategoryModel = Load::getModel( 'ruleCategoryModel' );
        $check_delete = $ruleCategoryModel->deleteCategory($id['Param']);
        $select_status = 1;
        if ($check_delete) {
            return functions::JsonSuccess($check_delete, [
                'message' => 'category_deleted',
                'data' => $select_status
            ], 200);
        }
        return functions::JsonError($check_delete, [
            'message' => 'category_delete_error',
            'data' => $select_status
        ], 200);

    }
	
}