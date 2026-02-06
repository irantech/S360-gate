<?php


die('ddd');
function createArchive($create_client = false)
{
    require_once('controller/zipArchiver.php');
    $zip_archiver = new zipArchiver();

    $date = date('Y-m-d___H-i');
    $archive_name='mc'.'-archive-' . $date . '.zip';



    
    $dirPath = array(
        dirname(__FILE__) . DIRECTORY_SEPARATOR.'controller',
        dirname(__FILE__) . DIRECTORY_SEPARATOR.'config',
        dirname(__FILE__) . DIRECTORY_SEPARATOR.'library',
        dirname(__FILE__) . DIRECTORY_SEPARATOR.'model',
        dirname(__FILE__) . DIRECTORY_SEPARATOR.'resource',
    );

    if ($create_client) {
        $archive_name='v'.'-archive-' . $date . '.zip';
        $dirPath = array(
            dirname(__FILE__) .DIRECTORY_SEPARATOR. 'view'.DIRECTORY_SEPARATOR.'client',
//            dirname(__FILE__) .DIRECTORY_SEPARATOR. 'view'.DIRECTORY_SEPARATOR.'client'.DIRECTORY_SEPARATOR.'Vue',
//            dirname(__FILE__) .DIRECTORY_SEPARATOR. 'view'.DIRECTORY_SEPARATOR.'administrator',
        );
    }

    
    $zipPath = dirname(__FILE__) .DIRECTORY_SEPARATOR.$archive_name;

//    echo print_r($zipPath);
//    echo '<hr/>';
//    echo print_r($dirPath);
//    die();
    $zip = $zip_archiver->zipDir($dirPath, $zipPath);

    if ($zip) {
        echo 'ZIP archive created successfully.';
//        header('Location:https://safar360.com/gds/'.$archive_name);
    } else {
        echo 'Failed to create ZIP.';
    }
}

if (isset($_GET['client'])) {
    createArchive(true);
}elseif(isset($_GET['client1'])){
    createArchive();
}
echo 'just called';