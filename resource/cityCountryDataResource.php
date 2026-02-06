<?php

require_once ('./resource/resourceAbstract.php');

class cityCountryDataResource extends resourceAbstract
{
    protected $fillables= array(
        'city_title',
        'city_value',
        'country_title',
        'country_value',
    );

    /**
     *
     * @param $inner_data
     * @return array
     */
    public function collection($inner_data) {
        return $this->resourceMaker($inner_data,$this->fillables);
    }
}