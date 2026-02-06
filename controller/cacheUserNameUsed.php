<?php

class cacheUserNameUsed extends clientAuth
{
    public function __construct() {
        parent::__construct();
    }


    public function getCacheUserNameUsed($user_name) {
        return $this->getModel('cacheUserNameUsedModel')->CacheUserNameUsed($user_name);
    }

    public function insertCacheUserNameUsed($user_name) {
        $data_used['user_name'] = $user_name ;
        $data_used['creation_date_int'] = time() ;
        return $this->getModel('cacheUserNameUsedModel')->insertUserNameUsed($data_used);
    }
}