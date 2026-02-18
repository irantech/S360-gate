<?php
/* require LIBRARY_DIR . 'Load.php';
require CONFIG_DIR . 'config.php'; */

class importFromExcel {

    public function __construct() {
    }

    public function getFile($file) {

        $output = array();

        Load::autoload('PHPExcel');

        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj = $excelReader->load($file);
        $worksheet = $excelObj->getSheet(0);
        $lastRow = $worksheet->getHighestRow();
        $lastCol = $worksheet->getHighestDataColumn();

        $i = $j = 0;
        for ($row = 1; $row <= $lastRow; $row++) {

            foreach (range('A', $lastCol) as $col) {

                $output[$i][$j] = $worksheet->getCell($col.$row)->getValue();

                $j++;

            }

            $i++;
        }

        return $output;
    }

}

?>