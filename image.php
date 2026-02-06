<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta charset="utf-8">
<?php

ini_set('max_execution_time', 500);
ini_set('memory_limit', '1024M');

function getNameImage($str)
{
    $i=strrpos($str, ".");
    if(!$i){
        return "";
    }
    $l=strlen($str)-$i;
    $name=substr($str, 0, $i);
    return $name;
}

function getExtensionImage($str)
{
    $i=strrpos($str, ".");
    if(!$i){
        return "";
    }
    $l=strlen($str)-$i;
    $ext=substr($str, $i+1, $l);
    return strtolower($ext);
}

function resizeImage($BasePath, $filePath, $fileName,$ImagesSize)
{

    //    echo $filePath.'--'.$fileName;
    $fileName=stripslashes($fileName);
    $extension=strtolower(getExtensionImage($fileName));
    $name=getNameImage($fileName);

    if(($extension!="jpg") && ($extension!="jpeg") && ($extension!="png") && ($extension!="gif")){
        return ' Unknown Image extension ';
    }else{
        list($width, $height)=getimagesize($filePath.$fileName);
        $newName_xSize=$name."x$ImagesSize.".$extension;
        if($extension=="jpg" || $extension=="jpeg"){
            $src=imagecreatefromjpeg($filePath.$fileName);
        }else if($extension=="png"){
            $src=imagecreatefrompng($filePath.$fileName);
        }else{
            $src=imagecreatefromgif($filePath.$fileName);
        }

        $newHeight=($height/$width)*$ImagesSize;
        $tmp=imagecreatetruecolor($ImagesSize, $newHeight);

        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $ImagesSize, $newHeight, $width, $height);
        $fileName_xSize=$BasePath.'resolutions/'.$newName_xSize;
        imagejpeg($tmp, $fileName_xSize, 70); // file name also indicates the folder where to save it to
        imagedestroy($src);
        imagedestroy($tmp);
    }
}

function listIt($path)
{
    if($handle=opendir($path)){
        $counter=0;
        $ImagesSize=array("150","600","300");
        while(($fileName=readdir($handle))){
            if($fileName!=='.' && $fileName!=='..'){

                if(is_file($path.$fileName)){
                    list($width, $height)=getimagesize($path.$fileName);
                    if($width >= '250'){
                        foreach($ImagesSize as $NewSize){
                            if(!file_exists("./pic/resolutions/".getNameImage($fileName)."x$NewSize.".getExtensionImage($fileName))){
                                resizeImage("./pic/", $path, $fileName,$NewSize);
                                echo '<a href="http://s360online.iran-tech.com/gds/pic/resolutions/'.getNameImage($fileName)."x$NewSize.".getExtensionImage($fileName).'">'.$path.$fileName.'x'.$NewSize.'</a></br>';

                            }
                        }
                    }
                }

                /*else{
                    echo 'Folder'.$path.$fileName.'</br>';
                    listIt("./pic/reservationTour/".$fileName.'/');
                }*/


            	/*if($counter==20){
                    break;
                }*/
                $counter++;
            }

        }
    }
    echo '</br>'.$counter;
}

echo "<div style='padding-left: 10px'>";
listIt("./pic/");
echo "</div>";