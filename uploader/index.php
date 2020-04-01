<?php
if (isset($_FILES['file'])) {
    include 'settings.php';

    $imgname = $_FILES['file']['name'];
    $imgname_tmp = $_FILES['file']['tmp_name'];

    $extension_file = substr($imgname, strpos($imgname, ".") + 1);

    // Generating random file name
    $imgname = '';
    while (strlen($imgname) < 12) {
        $imgname .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    $imgname .= '.' . $extension_file;

    if ($extension_file == $extension) {
        if (move_uploaded_file($imgname_tmp, $upload_folder . $imgname)) {
            if ($sym_folder_set == True) {
                if (symlink($upload_folder . $imgname, $sym_folder . $imgname)) {
                    echo $base_url . $imgname;
                } else {
                    exit("Error, could not create symlink!");
                }
            } else {
                echo $base_url . $imgname;
            }
        } else {
            exit("Error, cloud not move file!");
        }
    } else {
        exit("File not supported.");
    }
} else {
    echo "There is no interface configured, just use it via command line.";
}

