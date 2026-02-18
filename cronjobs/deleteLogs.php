<?php

function deleteLargeFiles($directory, $maxSizeInBytes = 5242880) {
    $todayStart = strtotime('-5 days', strtotime('today'));
    if (!is_dir($directory)) {
        echo "Directory not found: $directory\n";
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $fileInfo) {

        if ($fileInfo->isFile()) {
            $filePath = $fileInfo->getRealPath();
            $fileSize = $fileInfo->getSize();
            $fileModTime = $fileInfo->getMTime();

            if ($fileModTime >= $todayStart && $fileSize < 5242880) {
                echo "Skipped (added/modified today): $filePath\n";
                continue;
            }


            if ($fileSize > $maxSizeInBytes) {

                if (unlink($filePath)) {
                    echo "Deleted: $filePath (Size: " . round($fileSize / 1048576, 2) . " MB)\n";
                } else {
                    echo "Failed to delete: $filePath\n";
                }
            }
        }
    }
}

$logsDirectory = dirname(__DIR__) . '/logs';
deleteLargeFiles($logsDirectory);

echo "Finished cleaning up large files.\n";
