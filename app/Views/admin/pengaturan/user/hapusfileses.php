<?php

$nama_dir = "./writable/session/";

$files    = glob('./writable/session/*');
foreach ($files as $file) {
    $lastModifiedTime    = filemtime($file);
    $currentTime        = time();
    $timeDiff            = abs($currentTime - $lastModifiedTime) / (60 * 60); // in hours
    if (is_file($file) && $timeDiff > 10) // check if file is modified before 10 hours
        unlink($file);
}
