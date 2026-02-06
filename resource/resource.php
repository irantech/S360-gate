<?php

class resource
{
    public function resourceMaker($inner_data, $fillables,$isTest=false) {
        $res= array();
        $result= array();

        foreach ($inner_data as $each_data) {

            foreach ($fillables as $fallible_key => $fillable) {

                if(is_numeric($fallible_key)){
                    $fallible_key=$fillable;
                }

                // Handle custom transformations

                if (method_exists($this, $fallible_key)) {
                    $res[$fallible_key] = $this->$fallible_key($each_data[$fillable]);
                } else {
                    $res[$fallible_key] = $each_data[$fillable];
                }
            }
            $result[] = $res;
        }

        return $result;
    }
}
