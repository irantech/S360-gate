<?php

class transactionsModel extends ModelBase
{
    protected $table = 'transactions';

    protected $clientAliases = [
        327 => [327, 333],
        333 => [327, 333]
    ];

    public function updateTransaction($data, $condition) {

        if (!array_key_exists('clientID', $data)) {
            $data['clientID'] = CLIENT_ID;
        }

//        $this->updateWithBind($data,$condition);

        $clientID = $data['clientID'];
        $clientIDs = $this->clientAliases[$clientID] ?? [$clientID];
        $base_condition = $condition;

        foreach ($clientIDs as $cid) {
            $data['clientID'] = $cid;

            $condition = $base_condition . " AND clientID ={$cid} ";
          
            $this->updateWithBind($data, $condition);
        }

    }

    public function insertTransaction($data) {


        if (!array_key_exists('clientID', $data)) {
            $data['clientID'] = CLIENT_ID;
        }

        if (is_null($data['PriceDate'])) {
            $data['year'] = 'p_null_year';
        } else {
            $date = new DateTime($data['PriceDate']);
            $data['year'] = $date->format('Y');
        }

        $clientID = $data['clientID'];
        $clientIDs = $this->clientAliases[$clientID] ?? [$clientID];
      
        foreach ($clientIDs as $cid) {
            $data['clientID'] = $cid;
            $this->insertWithBind($data);
        }
    }

    public function deleteTransaction($condition) {
//        if (!isset($condition['clientID'])) {
//            $condition['clientID'] = CLIENT_ID;
//        }
//
//        $clientID = $condition['clientID'];
//        $clientIDs = $this->clientAliases[$clientID] ?? [$clientID];
//
//        $base_condition = $condition;
//        foreach ($clientIDs as $cid) {
//
//            $condition = $base_condition . " AND clientID ={$cid} ";
//
//            $this->delete($condition);
//        }
        $this->delete($condition);
    }
}
