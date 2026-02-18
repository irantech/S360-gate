<?php

/**
 * Class visaCategory
 *
 * @property visaCategory $visaCategory
 */
class visaCategory extends clientAuth
{
    private $visaCategoryTb , $visaCategoryModel;

    public function __construct() {
        parent::__construct();
        $this->visaCategoryTb = 'visa_category_tb';
        $this->visaCategoryModel = $this->getModel('visaCategoryModel');;
    }

    public function getVisaCategoryList() {
        $visaCategoryModel = $this->getModel('visaCategoryModel')->get() ;
        return  $visaCategoryModel->all();
    }

    public function getVisaCategoryById($id) {
        $visaCategoryModel = $this->getModel('visaCategoryModel')->get() ;
        return  $visaCategoryModel->where('id' , $id)->find();
    }
}