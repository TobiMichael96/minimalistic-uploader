<?php
include 'settings.php';

$objects = array();

$files = array();
$counter = 0;

foreach (glob($upload_folder . '*.*') as $file) {
    if (in_array(substr($file, strpos($file, ".") + 1), $extensions)) {
         $files[$counter] = array("name" => basename($file), "time" => filemtime($file), "path" => $file);
         ++$counter;
    }
}

usort($files, function ($a, $b) {
    return $b['time'] <=> $a['time'];
});


foreach ($files as $key => $value) {
    $time = $value["time"];
    $name = $value["name"];
    $path = $value["path"];
}



?>