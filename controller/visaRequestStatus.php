<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 2/16/2022
 * Time: 9:37 AM
 */

class visaRequestStatus {

	/**
	 * @return bool|mixed|visaRequestStatusModel
	 */
	protected function getModel() {
		return Load::getModel( 'visaRequestStatusModel' );
	}

	public function getAll( $without_trashed = true ) {
		$model = $this->getModel();
		$model->get();
		if ( $without_trashed ) {
			$model = $model->withoutTrashed();
		}

		return $model->all();
	}

	public function getSingle( $id ) {
		$model = $this->getModel();
		$model->get()->where( 'id', $id );

		return $model->find();
	}

	public function addNew( $data = array() ) {

		$insert_data = array(
			'title'       => $data['title'],
			'description' => $data['description'] ? $data['description'] : '',
			'notification_content' => $data['notification_content'] ? $data['notification_content'] : '',
			'created_at'  => date( 'Y-m-d H:i:s', time() ),
			'updated_at'  => date( 'Y-m-d H:i:s', time() ),
			'deleted_at'  => null,
		);

		$insert = $this->getModel()->insertWithBind( $insert_data );
		if ( $insert ) {
			return functions::withSuccess( $insert, 201, 'وضعیت ویزای جدید با موفقیت اضافه شد' );
		}

		return functions::withError( $insert, 400, 'خطا در درج وضعیت ویزای جدید' );
	}

	public function update( $data = array() ) {
		if ( ! isset( $data['id'] ) ) {
			return functions::withError( $data, 404, 'چیزی که به دنبال آن هستید یافت نشد' );
		}

		$id = $data['id'];

		$model = $this->getModel();
		$get   = $this->getSingle( $id );
		if ( ! $get ) {
			return functions::withError( $get, 404, 'چیزی که به دنبال آن هستید یافت نشد' );
		}
		$title = $data['title'] ? $data['title'] : $get['title'];

		$update_data = array(
			'notification_content' => $data['notification_content'] ? $data['notification_content'] : $get['notification_content'],
			'description' => $data['description'] ? $data['description'] : $get['description'],
			'updated_at'  => date( 'Y-m-d H:i:s', time() ),
			'deleted_at'  => null,
		);
		if($title != $get['title']){
			if($model->get()->where('title',$title)->find()){
				return functions::withError( null, 400, 'خطا! این عنوان قبلا استفاده شده است' );
			}
			$update_data['title'] = $title;
		}
		$update = $model->updateWithBind( $update_data, array( 'id' => $id ) );
		if ( $update ) {
			return functions::withSuccess( $update, 201, 'وضعیت ویزای با موفقیت ویرایش شد' );
		}

		return functions::withError( $update, 400, 'خطا در ویرایش وضعیت ویزا' );
	}

	public function delete( $data = array() ) {
		if ( ! $data['id'] ) {
			return functions::withError( $data, 404, 'چیزی که به دنبال آن هستید یافت نشد' );
		}
		$id    = $data['id'];
		$force = isset( $data['force'] ) ? $data['force'] : false;
		$model = $this->getModel();
		$get   = $this->getSingle( $id );
		if ( ! $get ) {
			return functions::withError( $get, 404, 'چیزی که به دنبال آن هستید یافت نشد' );
		}
		if ( $force ) {
			$delete = $model->delete( "id=$id" );
		}

		$delete = $model->softDelete( [ 'id' => $id ] );

		if ( $delete ) {
			return functions::withSuccess( $delete, '200', 'وضعیت با موفقیت حذف شد' );
		}

		return functions::withError( $get, 500, 'خطا در حذف وضعیت' );

	}

}