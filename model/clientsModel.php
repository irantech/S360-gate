<?php


class clientsModel extends ModelBase
{
    protected $table = 'clients_tb';


    public function getPartnerWhiteLabel() {

        return $this->get()->where('parent_id',CLIENT_ID)->all();
    }

}