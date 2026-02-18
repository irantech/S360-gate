<?php
/**
 * Created by PhpStorm.
 * User: Developer10
 * Date: 10/3/2021
 * Time: 9:48 AM
 */

class ruleCategoryModel extends Model {
	protected $table = 'rule_categories_tb';
	protected $query;
	protected $protected_fields = ['deleted_at'];
	public function __construct() {
		parent::__construct();
		$this->query = '';
	}
	
	public function all($without_trashed = true) {
		
		if($without_trashed){
			$query = $this->withoutTrashed();
			return $query->select($this->query);
		}
		return $this->select($this->query);
	}
	
	public function add( $data = []) {
		return $this->insertWithBind($data,$this->table);
	}
	
	public function withoutTrashed() {
		$this->where('deleted_at',NULL,' IS ');
		return $this;
	}
	
	public function find($without_trashed = true) {
		if($without_trashed){
			$query = $this->withoutTrashed();
			return $query->load($this->query);
		}
		return parent::load($this->query);
	}
	
	public function getQuery() {
		return $this->query;
	}
	
	public function get( $fields = []) {
		$fields = is_array($fields) ? implode(', ',$fields) : $fields;
		$fields = empty($fields) ? '*' : $fields;
		$this->query = "SELECT {$fields} FROM {$this->table} ";
		return $this;
	}
	
	public function where( $field = '',$value = '',$operation = '=' ) {
		if(is_array($field)){
			foreach ( $field as $key => $val ) {
				$this->where( $key,$val,$operation);
			}
		}
		$value = is_string($value) ? "'{$value}'" : $value;
		$value = is_null($value) ? "NULL" : $value;
		
		$condition = " {$field} {$operation} {$value} ";
		
		if(strpos($this->query,'WHERE') !== false){
			$this->query .= " AND {$condition} ";
			return $this;
		}
		$this->query .= " WHERE {$condition} ";
		return $this;
	}
	
	public function orWhere( $field = '', $value = '', $operation = '=' ) {
		if(is_array($field)){
			foreach ( $field as $key => $val ) {
				$this->where( $key,$val,$operation);
			}
		}
		$value = is_string($value) ? "'{$value}'" : $value;
		$value = is_null($value) ? "NULL" : $value;
		
		$condition = "{$field} {$operation} {$value}";
		
		if(strpos($this->query,'OR WHERE') !== false){
			$this->query .= " AND {$condition} ";
			return $this;
		}
		$this->query .= " OR WHERE {$condition} ";
		return $this;
	}
	
	public function with( $related ) {
		
		return $this->$related();
	}
	
	public function rules($category_id) {
		/** @var ruleModel $model */
		$model = Load::getModel('ruleModel');
		$rules = $model->get()->where('category_id',$category_id);
		return $rules->all();
	}
    public function deleteCategory($role_id,$sof_delete = true) {
        if($sof_delete){
            return $this->updateWithBind(['deleted_at'=>date('Y-m-d H:i:s')],"{$this->pk}={$role_id}",$this->table);
        }
        return $this->delete("{$this->pk}={$role_id}");
    }
	
}