<?php

require_once ('./resource/resourceAbstract.php');

class countryResource extends resourceAbstract
{
    protected $fillables= array(
        'id',
        'name',
        'name_en',
        'abbreviation',
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