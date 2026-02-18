<?php

class activityLogModel extends Model
{

    protected $table ;

    public function __construct() {
        parent::__construct();
        $this->table = 'activity_log_tb';
        $this->pk = 'id';
    }

}
