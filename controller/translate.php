<?php


class translate extends baseController {

    
    public function __construct() {
//        error_reporting(1);
//        error_reporting(E_ALL | E_STRICT);
//        @ini_set('display_errors', 1);
//        @ini_set('display_errors', 'on');
    }



    /**
     * @return false|string
     */
    public function getAllTranslate() {

        $result_translates = $this->getModel('translateModel')->get(['`id`','`selector`','`lang_fa`','`lang_ar`','`lang_en`','`lang_ru`'],true)->all();

        $all_translate = array();
        foreach ($result_translates as $item) {
            $all_translate [$item['selector']] = $item['lang_'.SOFTWARE_LANG] ;
        }

        return functions::withSuccess($all_translate,200,'fetch data successfully');

    }


}