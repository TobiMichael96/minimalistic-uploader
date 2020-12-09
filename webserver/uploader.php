<?php
if (isset($_FILES['file'])) {
    include 'settings.php';

    $imgname = $_FILES['file']['name'];
    $imgname_tmp = $_FILES['file']['tmp_name'];
    // jpeg file extensions
    $jpeg_array = array('jpg','jpeg');
    // get file extensions
    $extension_file = substr($imgname, strpos($imgname, ".") + 1);

    // Generating random file name
    $imgname = '';
    while (strlen($imgname) < $name_length) {
        $imgname .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    $imgname .= '.' . $extension_file;

    // Check if uploaded file matches the allowed files
    if (in_array($extension_file, $extensions)) {
        if (move_uploaded_file($imgname_tmp, $upload_folder . $imgname)) {
            $filename = $upload_folder . $imgname;
            $filename = stripcslashes($filename);
            // check if picture is jpeg and optimize it
            if (in_array($extension_file, $jpeg_array) && !empty($compress_img)) {
                exec('jpegoptim --size ' . $compress_img . ' ' . $filename);
            }
            // resize pictures
            if (!empty($resize_img)) {
                exec('convert -resize ' . $resize_img . ' ' . $filename . ' ' . $filename);
            }
            echo $base_url . 'images/' . $imgname;
        } else {
            exit("Error, cloud not move file!");
        }
    } else {
        exit("File not supported.");
    }
} else {
    echo "There is no interface configured, just use it via command line.";
}

