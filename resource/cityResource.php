<?php

require_once ('./resource/resourceAbstract.php');

class cityResource extends resourceAbstract
{
    protected $fillables= array(
        'tour_id',
        'id',
        'name',
        'name_en',
        'id_country',
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