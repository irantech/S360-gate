<?php

class cacheUserNameUsedModel extends ModelBase
{

    protected $table='cache_username_used_tb';

    public function CacheUserNameUsed($user_name) {
        $this->get()->where('user_name',$user_name)->orderBy('id','DESC')->limit(0,1)->find();
    }

    public function insertUserNameUsed($params) {
        $this->insertLocal($params);
    }
}