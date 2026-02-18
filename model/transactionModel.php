<?php


class transactionModel extends Model
{
    protected $table = 'transaction_tb';

    public function totalIncrease()
    {
        $sql= "SELECT sum(Price) AS totalCharge FROM transaction_tb WHERE Status='1' AND PaymentStatus = 'success'";
        return parent::load($sql);

    }

    public function totalDecrease()
    {
        $time         = time() - ( 600 );
        $sql= "SELECT SUM(Price) AS totalBuy FROM transaction_tb WHERE Status='2' AND"
            . " ((PaymentStatus = 'success') OR (PaymentStatus = 'pending' AND CreationDateInt > '{$time}'))";
        return parent::load($sql);

    }
}