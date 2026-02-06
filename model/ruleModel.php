<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 10/3/2021
 * Time: 9:47 AM
 */

class ruleModel extends Model{
	protected $table = 'rules_tb';
	protected $join_table = 'rule_categories_tb';
	protected $query;
	
	/**
	 * ruleModel constructor.
	 */
	public function __construct() {
		parent::__construct();
		$this->query = '';
	}
	
	/**
	 * @param array $data_insert
	 *
	 * @return bool|string
	 *
	 */
	public function newRule( $data_insert = [] ) {

		return $this->insertWithBind($data_insert,$this->table);
	}
	
	public function updateRule( $id, $data_update = [] ) {
		$data_update['updated_at'] = date('Y-m-d H:i:s');
		
		return $this->updateWithBind($data_update,"{$this->pk}={$id}",$this->table);
	}
	
	public function getRule( $rule_id ,$with_trashed = false) {
		 $sql = "SELECT {$this->table}.*,{$this->join_table}.title AS category_title,{$this->join_table}.slug AS category_slug FROM `{$this->table}` LEFT JOIN {$this->join_table} ON {$this->table}.category_id = {$this->join_table}.id WHERE {$this->table}.{$this->pk} = {$rule_id}";
		if(!$with_trashed){
			$sql .= " AND {$this->table}.deleted_at IS NULL AND {$this->join_table}.deleted_at IS NULL";
		}
		return $this->load($sql);
	}
	
	public function deleteRule($role_id,$sof_delete = true) {
		if($sof_delete){
			return $this->updateWithBind(['deleted_at'=>date('Y-m-d H:i:s')],"{$this->pk}={$role_id}",$this->table);
		}
		return $this->delete("{$this->pk}={$role_id}");
	}
	
	
}