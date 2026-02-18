<?php
require_once SMARTY_DIR . 'Smarty.class.php';

//error_reporting(1);
//error_reporting(E_ALL | E_STRICT);
//@ini_set('display_errors', 1);
//@ini_set('display_errors', 'on');

class application extends Smarty
{

    private $xml, $lang = '';
    private $translate_array = [] ;
    public $adminLogin = 'no';
    public $path = '';

    public function __construct()
    {
        parent::__construct();
        $this->template_dir = FRONT_CURRENT_THEME;
        $this->compile_dir = COMPILE_DIR;
        $this->setPluginsDir(SMARTY_DIR . '/plugins');
        $this->addPluginsDir(SMARTY_DIR . '/smarty_plugins');
        $this->translate_array   = $this->getTranslate();


    }

    public function changeDirection($direction, $target, $type)
    {

        if ($type == 'admin') {

            $result = str_replace('assets', ROOT_ADDRESS_WITHOUT_LANG . '/view/' . ADMIN_DIR . '/assets', $target);

        } elseif ($type == 'panel') {

            $result = str_replace('assets', ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FOLDER_PANEL . '/assets', $target);
            $result = str_replace('project_files', ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FRONT_TEMPLATE_NAME . '/project_files', $result);

        } elseif ($type == 'app') {

            $result = str_replace('assets', ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FOLDER_APP . '/assets', $target);


        } elseif ($type == 'iframe') {

            $result = str_replace('assets', ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FOLDER_CLIENT . '/assets', $target);

        } else {

            $result = str_replace('assets', ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FOLDER_CLIENT . '/assets', $target);
            $result = str_replace('project_files', ROOT_ADDRESS_WITHOUT_LANG . '/view/' . FRONT_TEMPLATE_NAME . '/project_files', $result);
        }

        if ($direction == 'ltr') {
            $result = str_replace('-rtl', '', $result);
        }

        return $result;
    }

    public function parseTagsRecursive($input)
    {

//        $this->xml = simplexml_load_file(SITE_ROOT . "/langs/" . SOFTWARE_LANG . "_frontMaster.xml");
//
//        $this->xml->xpath("//Main");

        if (is_array($input)) {
            $input_obj = $this->translate_array[$input[1]];
           
            return preg_replace_callback('/##(.+?)##/', 'application::parseTagsRecursive', $input_obj);
        } else {
            return preg_replace_callback('/##(.+?)##/', 'application::parseTagsRecursive', $input);
        }
    }

    function pathFile($path)
    {
         $this->path = PIC_ROOT . $path;
        if (!file_exists($this->path)) {
            mkdir($this->path, 00755, true);
        }

    }

    function resizeImage($BasePath, $filePath, $fileName,$ImagesSize)
    {

        $fileName=stripslashes($fileName);
        $extension=strtolower(functions::getExtensionImage($fileName));
        $name=functions::getNameImage($fileName);

        if(($extension!="jpg") && ($extension!="jpeg") && ($extension!="png") && ($extension!="gif")){
            return ' Unknown Image extension ';
        }else{
            list($width, $height)=getimagesize($filePath);
            $newName_xSize=$name."x$ImagesSize.".$extension;
            if($extension=="jpg" || $extension=="jpeg"){
                $src=imagecreatefromjpeg($filePath);
            }else if($extension=="png"){
                $src=imagecreatefrompng($filePath);
            }else{
                $src=imagecreatefromgif($filePath);
            }

            $newHeight=($height/$width)*$ImagesSize;
            $tmp=imagecreatetruecolor($ImagesSize, $newHeight);

            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $ImagesSize, $newHeight, $width, $height);
            $fileName_xSize=$BasePath.'resolutions/'.$newName_xSize;
            imagejpeg($tmp, $fileName_xSize, 64); // file name also indicates the folder where to save it to
            imagedestroy($src);
            imagedestroy($tmp);
        }
    }
    function UploadFile($type, $input_name, $allowed_size = '')
    {


        $result = '';
        $ImagesSize = array("150","600","300");
	    $allowed_size = $allowed_size != '' ? $allowed_size : 1048576; // 1MB
        if ($type == 'pic')
            $allowed_extensions = array(
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
                'image/webp',
                'video/webm',
                'application/pdf',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/octet-stream',
            );
        else
            $allowed_extensions = array(
                'image/jpeg',
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'video/mp4',
                'application/octet-stream',
                'video/webm'
            );

        if (is_dir(SITE_ROOT)) {
            $micro = intval(microtime(true));
            $file_name = pathinfo($_FILES[$input_name]['name'], PATHINFO_FILENAME);
            $file_extension = '.' . pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION);

            $file_name = date("sB") . rand(10, 10000) . $_FILES[$input_name]['name'];

            if ($this->path != '') {
                $path = $this->path . $file_name;

            } else {
                $path = PIC_ROOT . $file_name;
            }

            $KBsize = round($allowed_size / 1024, 1);
            $MBsize = round($KBsize / 1024, 1);
            if ($MBsize < 1) {
                $normSize = $KBsize . " کیلوبایت ";
            } else {
                $normSize = $MBsize . " مگابایت ";
            }

            if (in_array($_FILES[$input_name]['type'], $allowed_extensions)) {

                if ($_FILES[$input_name]['size'] <= $allowed_size) {
                    if (move_uploaded_file($_FILES[$input_name]['tmp_name'], $path)) {

//                        $ImagesSize=array("150","600","300");
//                        foreach($ImagesSize as $NewSize){
//                            $this->resizeImage(PIC_ROOT, $path, $file_name,$NewSize);
//                        }
                        $result = "done" . ":" . $file_name;
                    }


                } else
                    $result = "فایل مورد نظر آپلود نشد (حجم فایل زیاد است) حجم فایل باید کمتر از " . $normSize . " باشد";
            } else {
                $result = "فایل مورد نظر آپلود نشد (فایل نامعتبر) شما تنها میتوانید فایل با پسوندهای زیر را انتخاب نمایید," . "<br />";
                foreach ($allowed_extensions as $key) {
                    if ($key != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                        $result .= substr($key, strpos($key, '/') + 1) . " - ";
                }
                $result = substr($result, 0, -3);
                $result = str_replace('msword', 'doc - docx', $result);
            }
        } else {
            $result = "فایل مورد نظر آپلود نشد (مسیر مورد نظر وجود ندارد) لطفا با سرویس دهنده تماس بگیرید";
        }


        return $result;
    }


    #region uploadFiles
    function uploadFiles($type, $inputName, $allowedSize = null)
    {
        $result = array();

        if ($allowedSize == '') {
            $allowedSize = 1048576; // 1MB
        }

        if ($type == 'pic') {
            $allowedExtensions = array(
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
                'video/webm'
            );
        } else {
            $allowedExtensions = array(
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'video/mp4',
                'video/webm'
            );
        }


        if (is_dir(SITE_ROOT)) {

            $total = count($_FILES[$inputName]['name']);
            // Loop through each file
            for ($i = 0; $i < $total; $i++) {

                $fileName = date("sB") . rand(10, 10000) . $_FILES[$inputName]['name'][$i];
                if (strlen($fileName) > 255){
                    $exp = explode(".", $_FILES[$inputName]['name']);
                    $fileName = date("ymd") . date("Hi") . rand(10, 10000) . '.' . $exp[1];
                }
                $fileName = str_replace(" ", "", $fileName);

                if ($this->path != '') {
                    $path = $this->path;
                } else {
                    $path = PIC_ROOT;
                }


                if (is_uploaded_file($_FILES[$inputName]['tmp_name'][$i])) {
                    if ($_FILES[$inputName]['size'][$i] < $allowedSize) {
                        if (in_array($_FILES[$inputName]['type'][$i], $allowedExtensions)) {

                            if (move_uploaded_file($_FILES[$inputName]['tmp_name'][$i], $path . $fileName)) {

                                $result[$i]['message'] = 'done';
                                $result[$i]['fileName'] = $fileName;
                            }

                        } else {
                            $result[$i]['message'] = 'فایل مورد نظر آپلود نشد (فایل نامعتبر)';
                        }
                    } else {
                        $KB = round($allowedSize / 1024, 1);
                        $MB = round($KB / 1024, 1);
                        if ($MB < 1) {
                            $normSize = $KB . ' کیلوبایت ';
                        } else {
                            $normSize = $MB . ' مگابایت ';
                        }
                        $result[$i]['message'] = 'فایل مورد نظر آپلود نشد (حجم فایل زیاد است) حجم فایل باید کمتر از ' . $normSize . ' باشد';
                    }
                } else {
                    $result[$i]['message'] = 'فایل مورد نظر آپلود نشد.';
                }
            }


        } else {
            $result[0]['message'] = 'فایل مورد نظر آپلود نشد (مسیر مورد نظر وجود ندارد) لطفا با سرویس دهنده تماس بگیرید';
        }

        return $result;
    }
    #endregion

    public function getTranslate() {
        /** @var translate $translate_controller */
        $translate_controller = Load::controller('translate');
        return json_decode($translate_controller->getAllTranslate(),true)['data'];
    }

}

?>
