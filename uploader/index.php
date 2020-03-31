<?php
if (isset($_FILES['file'])) {

    // Checks if a config file exists, if yes the config file will be used instead of the defaults
    if (file_exists('config.php')) {
        include 'config.php';
    } else {
        $settings = array(
            // The folder where the file will end; do not forget the trailing slash!
            'upload_dir' => dirname(__FILE__) . DIRECTORY_SEPARATOR,

            // The folder where the symlink will end; do not forget the trailing slash!
            // You can create a symlink if the file needs to be in another folder to be shown on the web server
            'symlink_dir' => '',

            // URL for the server; do not forget the trailing slash!
            // If you leave this empty, the URL stays the same as the page is
            'page_url' => autoDetectBaseUrl(),

            // Characters for the random filename
            'random_name_alphabet' => 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789',

            // Mime type you want to accept
            'image_extension' => 'jpg',
        );
    }

    $imgname = $_FILES['file']['name'];
    $imgname_tmp = $_FILES['file']['tmp_name'];

    $extension = substr($imgname, strpos($imgname, ".") + 1);

    // Generating random file name
    $imgname = '';
    while (strlen($imgname) < 12) {
        $imgname .= $settings['random_name_alphabet'][mt_rand(0, strlen($settings['random_name_alphabet']) - 1)];
    }
    $imgname .= '.' . $extension;

    if ($extension == $settings['image_extension']) {
        if (move_uploaded_file($imgname_tmp, $settings['upload_dir'] . $imgname)) {
            if ($settings['symlink_dir'] !== '') {
                if (symlink($settings['upload_dir'] . $imgname, $settings['symlink_dir'] . $imgname)) {
                    echo $settings['page_url'] . $imgname;
                } else {
                    echo "Error, could not create symlink!";
                }
            } else {
                echo $settings['page_url'] . $imgname;
            }
        } else {
            echo "Error, cloud not move file!";
        }
    }
} else {
    echo "There is no interface configured, just use it via command line.";
}

// Detects base URL
function autoDetectBaseUrl()
{
    // Detect protocol
    $protocol = 'http';
    if (((isset($_SERVER['HTTPS'])) && (strtolower($_SERVER['HTTPS']) == 'on')) ||
        ((isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) && (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https'))) $protocol = 'https';

    // Detect port
    $port = getenv('SERVER_PORT');
    if ((($port == 80) && ($protocol == 'http')) || (($port == 443) && ($protocol == 'https'))) $port = '';

    // Detect server name
    $server_name = getenv('SERVER_NAME');
    if ($server_name === false) $server_name = 'localhost';

    // Construct base URL
    return sprintf('%s://%s%s%s', $protocol, $server_name, $port, dirname(getenv('SCRIPT_NAME'))) . DIRECTORY_SEPARATOR;
}

?>
