<?php


class createExcelFile
{

    public function create(array $dataRows, array $firstRowColumnsHeading = [] , array $rowWidth = [], $sheetName = 'Sheet1')
    {

        require LIBRARY_DIR . 'PHPExcel-1.8/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->setTitle($sheetName);
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
       // $objPHPExcel->getActiveSheet();
        $objPHPExcel->getActiveSheet()->setRightToLeft(true);
        $numberColumn = 0;

        if (isset($firstRowColumnsHeading) && !empty($firstRowColumnsHeading)){
            foreach ($firstRowColumnsHeading as $item => $value) {
                $columnLetter = PHPExcel_Cell::stringFromColumnIndex($item);
                $objPHPExcel->getActiveSheet()->setCellValue($columnLetter . '1', $value);
            }
            $numberColumn++;
        }


        foreach ($dataRows as $numberRow => $dataRow){
            $i = 0;
            $numberColumn++;
            foreach ($dataRow as $item => $value) {
                $columnLetter = PHPExcel_Cell::stringFromColumnIndex($i);
                $objPHPExcel->getActiveSheet()->setCellValue($columnLetter . $numberColumn, $value);
                $i++;
            }
        }
        if (isset($rowWidth) && !empty($rowWidth)){
                $i = 0;
            foreach ($rowWidth as $width){
                $columnLetter = PHPExcel_Cell::stringFromColumnIndex($i);
                $objPHPExcel->getActiveSheet()->getColumnDimension( $columnLetter )->setWidth($width);
                    $i++;
                }
            }

        // Apply styling only if there are column headings
        if (isset($firstRowColumnsHeading) && !empty($firstRowColumnsHeading)) {
            $lastColumnLetter = PHPExcel_Cell::stringFromColumnIndex(count($firstRowColumnsHeading) - 1);
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:'.$lastColumnLetter.'1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('becdf8');
            for ($counter = 3 ; $counter <= count($dataRows) ; $counter+=2) {
            $objPHPExcel->getActiveSheet()
                    ->getStyle('A'.$counter.':'.$lastColumnLetter.$counter)
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                    ->setARGB('e4e7ea');
            }
        }


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $fileName = date("Ymd") . '_' . rand(10, 1000000) . '.xlsx';
        $rootAddressFile = PIC_ROOT . 'excelFile/' . $fileName;
        $objWriter->save($rootAddressFile);

        $result['message'] = 'success';
        $result['fileName'] = $fileName;

        return $result;

    }

}
