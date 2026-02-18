<?php
/**
 * Created by PhpStorm.
 * User: AbbasPC
 * Date: 10/28/2018
 * Time: 10:46 AM
 */

class currencyHistoryEquivalent
{

    #region __construct
    public function __construct()
    {

    }
    #endregion

    #region ListHistoryCurrencyEquivalent
    public function ListHistoryCurrencyEquivalent($Code)
    {
        $Model = Load::library('Model');
        $ModelBase = Load::library('ModelBase');

        $SqlCurrency = "SELECT * FROM currency_tb WHERE IsEnable='Enable' ";
        $currency = $ModelBase->select($SqlCurrency);

        if (empty($currency)) {
            $currency = array();
        }

        foreach ($currency as $equivalent) {
            $SqlCurrencyEquivalent = "SELECT * FROM currency_equivalent_history_tb WHERE CurrencyCode='{$equivalent['CurrencyCode']}'";
            $resultCurrencyEquivalentHistory = $Model->select($SqlCurrencyEquivalent);

            foreach ($resultCurrencyEquivalentHistory as $history) {
                if (!empty($resultCurrencyEquivalentHistory) && ($history['CurrencyCode'] == $Code)) {
                    $history['CurrencyTitle'] = $equivalent['CurrencyTitle'];
                    $EquivalentHistory[] = $history;
                }
            }
        }


        return $EquivalentHistory;

    }

    #endregion

}