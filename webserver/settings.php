<?php
$sym_folder_set = False;

# Get page url from environment variables, if not present try to detect
if (getenv('PAGE_URL') !== False) {
    $base_url = getenv('PAGE_URL');
    if (substr($base_url, -1) !== '/') {
        $base_url = $base_url . DIRECTORY_SEPARATOR;
    }
} else {
    $base_url = autoDetectBaseUrl();
}

# Get page url from environment variables, if not present set to jpg
if (getenv('FILE_EXTENSION') !== False) {
    $extensions_env = getenv('FILE_EXTENSION');
    $extensions = explode(',', $extensions_env);
} else {
    $extensions = array('jpg');
}

# Get the upload folder from environment variables, if not present set current folder
$upload_folder = '/var/www/html/images/';

# Get available characters from environment variables
if (getenv('CHARACTERS') !== False) {
    $characters = getenv('CHARACTERS');
} else {
    $characters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789';
}

# Get name length from environment variables
if (getenv('NAME_LENGTH') !== False) {
    $name_length = getenv('NAME_LENGTH');
} else {
    $name_length = 12;
}

# Get page title from environment variables, if not present set to Uploader
if (getenv('PAGE_TITLE') !== False) {
    $page_title = getenv('PAGE_TITLE');
} else {
    $page_title = 'Uploader';
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
