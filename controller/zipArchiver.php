<?php

class zipArchiver
{

    /**
     * Zip a folder (including itself).
     *
     * Usage:
     * Folder path that should be zipped.
     *
     * @param $sourcePath string|array
     * Relative path of directory to be zipped.
     *
     * @param $outZipPath string
     * Path of output zip file.
     *
     */
    public static function zipDir($sourcePath, $outZipPath)
    {

        $z = new ZipArchive();
        $z->open($outZipPath, ZipArchive::CREATE);


        if (is_array($sourcePath)) {
            foreach ($sourcePath as $source) {
                $pathInfo = pathinfo($source);
                $parentPath = $pathInfo['dirname'];
                $dirName = $pathInfo['basename'];

                $z->addEmptyDir($dirName);


                if ($sourcePath == $dirName) {
                    self::dirToZip($source, $z, 0);
                } else {
                    self::dirToZip($source, $z, strlen("$parentPath/"));
                }
            }
        } else {
            $pathInfo = pathinfo($sourcePath);
            $parentPath = $pathInfo['dirname'];
            $dirName = $pathInfo['basename'];

            $z->addEmptyDir($dirName);
            if ($sourcePath == $dirName) {
                self::dirToZip($sourcePath, $z, 0);
            } else {
                self::dirToZip($sourcePath, $z, strlen("$parentPath/"));
            }
        }

        $z->close();

        return true;
    }

    /**
     * Add files and sub-directories in a folder to zip file.
     *
     * @param $folder string
     * Folder path that should be zipped.
     *
     * @param $zipFile ZipArchive
     * Zip file where files end up.
     *
     * @param $exclusiveLength int
     * Number of text to be excluded from the file path.
     *
     */
    private static function dirToZip($folder, &$zipFile, $exclusiveLength)
    {
        $handle = opendir($folder);
        while (FALSE !== $f = readdir($handle)) {
            // Check for local/parent path or zipping file itself and skip
            if ($f != '.' && $f != '..' && $f != basename(__FILE__)) {
                $filePath = "$folder/$f";
                // Remove prefix from file path before add to zip
                $localPath = substr($filePath, $exclusiveLength);
                if (is_file($filePath)) {
                    $zipFile->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    // Add sub-directory
                    $zipFile->addEmptyDir($localPath);
                    self::dirToZip($filePath, $zipFile, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }

}