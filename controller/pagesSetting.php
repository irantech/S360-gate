<?php

/**
 * Class pagesSetting
 * @property partner $partner
 */

class pagesSetting
{
    public function getPages()
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        $query = "SELECT * FROM  pages_setting_tb ";
        return $ModelBase->select($query);
    }
    public function newPage($params)
    {
        Load::autoload('ModelBase');
        $ModelBase = new ModelBase();
        $ModelBase->setTable('pages_setting_tb');

        $data['name']=$params['name'];
        $data['files']=@$params['files'];


        return $ModelBase->insertLocal($data);
    }
}