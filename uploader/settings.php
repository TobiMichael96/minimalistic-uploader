<?php
$sym_folder_set = False;

# Get page url from environment variables, if not present try to detect
if (getenv('PAGE_URL') !== False) {
    $base_url = getenv('PAGE_URL');
} else {
    $base_url = autoDetectBaseUrl();
}

# Get page url from environment variables, if not present set to jpg
if (getenv('FILE_EXTENSION') !== False) {
    $extension = getenv('FILE_EXTENSION');
} else {
    $extension = 'jpg';
}

# Get the upload folder from environment variables, if not present set current folder
if (getenv('UPLOAD_DIR') !== False) {
    $upload_folder = getenv('UPLOAD_DIR');
    if (getenv('SYMLINK_DIR') !== False) {
        $sym_folder_set = True;
        $sym_folder = getenv('SYMLINK_DIR');
    } else {
        exit("Error, SYMLINK_DIR not set!");
    }
} else {
    $upload_folder = '/var/www/html/';
}

# Get available characters from environment variables
if (getenv('CHARACTERS') !== False) {
    $characters = getenv('CHARACTERS');
} else {
    $characters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789';
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
    if ($server_name === False or $server_name == '_') $server_name = 'localhost';

    // Construct base URL
    return sprintf('%s://%s:%s%s', $protocol, $server_name, $port, DIRECTORY_SEPARATOR);
}
