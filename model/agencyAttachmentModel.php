<?php

class agencyAttachmentModel extends Model {
	protected $table = 'agency_attachments_tb';
	protected $pk = 'id';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function newAttachment( $agency_id = null, $client_id = null, $file_path = '' ) {
		$client_id = isset( $client_id ) ? $client_id : CLIENT_ID;
		if ( ! $agency_id || ! $client_id || ! $file_path ) {
			return false;
		}
		
		$data_insert = [
			'client_id' => $client_id,
			'agency_id' => $agency_id,
			'file_path' => $file_path
		];
		
		return $this->insertWithBind( $data_insert );
	}
	
	public function updateAttachment( $id, $agency_id = null, $client_id = null, $file_path = '' ) {
		$client_id = isset( $client_id ) ? $client_id : CLIENT_ID;
		
		if ( ! $agency_id || ! $client_id || ! $file_path ) {
			return false;
		}
		$data_update = [
			'client_id' => $client_id,
			'agency_id' => $agency_id,
			'file_path' => $file_path
		];
		
		return $this->updateWithBind( $data_update, [ 'id' => $id ] );
	}
	
	public function deleteAttachment( $attachment_id ) {
		return $this->softDelete(['id'=>$attachment_id]);
	}
	
	public function getAgencyAttachments( $agency_id = null, $client_id = null, $with_trashes = false ) {
		$attachments = $this->get();
		if ( $agency_id ) {
			$attachments->where( 'agency_id', $agency_id );
		}
		if ( $client_id ) {
			$attachments->where( 'client_id', $client_id );
		}
		
		return $attachments->all( ! $with_trashes );
	}
	
}