<?php


class entertainmentCategoryModel extends Model
{
    protected $table = 'entertainment_category_tb';
    protected $pk = 'id';

    public function getCategoryParent()
    {
        $sql = "SELECT  * FROM {$this->table} WHERE parent_id='0' ";
        return parent::select($sql);
    }

}