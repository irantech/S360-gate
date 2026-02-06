<?php




function listFilesRecursivelyAndCopy($originPath, $destinationPath) {
    // Get the list of files and directories in the current directory
    $contents = scandir($originPath);

    // Exclude . and ..
    $contents = array_diff($contents, ['.', '..']);

    // Iterate through the contents
    foreach ($contents as $item) {
        $originItemPath = $originPath . '/' . $item;
        $destinationItemPath = $destinationPath . '/' . $item;

        $time_search = time() - (60*60*24*3) ;
        if(filemtime($originItemPath) > ($time_search)){
             if (is_dir($originItemPath)) {
                 // If the current item is a directory, create the directory in the destination path
                 if (!is_dir($destinationItemPath)) {
                     mkdir($destinationItemPath,0777,true);
                 }

                 // Call the function recursively with the new paths
                 listFilesRecursivelyAndCopy($originItemPath, $destinationItemPath);
             } else {


                 // Echo the file name
                 if(file_exists($originItemPath)){
                     echo date('Y-m-d H:i:s', filemtime($originItemPath)).'==>'.$originItemPath.'<br/>';
                     // If the current item is a file, copy it to the destination path
                     copy($originItemPath, $destinationItemPath);
                 }
                 echo basename($originItemPath) . " copied to " . $destinationItemPath . "<br>.......................<br/>";
             }
            }

    }


}

$originPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'controller';
$destinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/controller';
//$destinationPath = dirname(dirname(__FILE__)).'/gds_new/controller';


// Make sure the destination directory exists
if (!is_dir($destinationPath)) {
    mkdir($destinationPath,0777,true);
}

listFilesRecursivelyAndCopy($originPath, $destinationPath);
echo '<hr/>';
//-------------------------------------------------------------------------------------------------------

$pwaPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'pwa';
$pwaDestinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/pwa';
//$cronjobsDestinationPath = dirname(dirname(__FILE__)).'/gds_new/pwa';
if (!is_dir($pwaDestinationPath)) {
    mkdir($pwaDestinationPath,0777,true);
}


listFilesRecursivelyAndCopy($pwaPath, $pwaDestinationPath);
echo '<hr/>';

//-------------------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------------------

$cronjobsPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'cronjobs';
$cronjobsDestinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/cronjobs';
//$cronjobsDestinationPath = dirname(dirname(__FILE__)).'/gds_new/cronjobs';
if (!is_dir($cronjobsDestinationPath)) {
    mkdir($cronjobsDestinationPath,0777,true);
}


listFilesRecursivelyAndCopy($cronjobsPath, $cronjobsDestinationPath);
echo '<hr/>';

//-------------------------------------------------------------------------------------------------------


$langsPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'langs';
$langsDestinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/langs';
//$langsDestinationPath = dirname(dirname(__FILE__)).'/gds_new/langs';
if (!is_dir($langsDestinationPath)) {
    mkdir($langsDestinationPath,0777,true);
}


listFilesRecursivelyAndCopy($langsPath, $langsDestinationPath);
echo '<hr/>';
//-------------------------------------------------------------------------------------------------------

$libraryPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'library';
$libraryDestinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/library';
//$libraryDestinationPath = dirname(dirname(__FILE__)).'/gds_new/library';
if (!is_dir($libraryDestinationPath)) {
    mkdir($libraryDestinationPath,0777,true);
}


listFilesRecursivelyAndCopy($libraryPath, $libraryDestinationPath);
echo '<hr/>';

//-------------------------------------------------------------------------------------------------------

$modelPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'model';
$modelDestinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/model';
//$modelDestinationPath = dirname(dirname(__FILE__)).'/gds_new/model';
if (!is_dir($modelDestinationPath)) {
    mkdir($modelDestinationPath,0777,true);
}


listFilesRecursivelyAndCopy($modelPath, $modelDestinationPath);
echo '<hr/>';

//-------------------------------------------------------------------------------------------------------

$administratorPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'view/administrator';
$administratorDestinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/view/administrator';
//$administratorDestinationPath = dirname(dirname(__FILE__)).'/gds_new/view/administrator';
if (!is_dir($administratorDestinationPath)) {
    mkdir($administratorDestinationPath,0777,true);
}


listFilesRecursivelyAndCopy($administratorPath, $administratorDestinationPath);
echo '<hr/>';
//-------------------------------------------------------------------------------------------------------

$clientPath =  dirname(__FILE__) . DIRECTORY_SEPARATOR.'view/client';
$clientDestinationPath =  dirname(dirname(dirname(__FILE__))).'/domains/servertest.iran-tech.com/public_html/gds/view/client';
//$clientDestinationPath = dirname(dirname(__FILE__)).'/gds_new/view/client';
if (!is_dir($clientDestinationPath)) {
    mkdir($clientDestinationPath,0777,true);
}


listFilesRecursivelyAndCopy($clientPath, $clientDestinationPath);
echo '<hr/>';

