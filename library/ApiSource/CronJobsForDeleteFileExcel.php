<?php
require '../../config/bootstrap.php';
$folder_path = PIC_ROOT . 'excelFile';
$files = glob($folder_path.'/*.xlsx');
echo '<pre>';
var_dump($files);
echo '</pre>';
foreach ($files as $file) {
    if (file_exists($file)) {
        unlink($file);
    } else {
        echo 'File not found ==>> '  . $file . '<hr>';
    }
}

