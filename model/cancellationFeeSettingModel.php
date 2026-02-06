<?php


class cancellationFeeSettingModel extends ModelBase
{
    protected $table = 'cancellation_fee_settings_tb';
    protected $pk = 'id';

    public function getCancellationFeeSettingByAirlines()
    {
        $query = "SELECT A.name_fa, A.name_en, A.abbreviation ,CFS.*  FROM airline_tb AS A INNER JOIN cancellation_fee_settings_tb AS CFS ON A.abbreviation = CFS.AirlineIata " .
            "WHERE A.active = 'on' AND A.del = 'no'";
        return parent::select($query);
    }
}