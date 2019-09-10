<?php
$settings = array(
    // The folder where the file will end; do not forget the trailing slash!
    'upload_dir' => '/home/user/images/',

    // The folder where the symlink will end; do not forget the trailing slash!
    // You can create a symlink if the file needs to be in another folder to be shown on the webserver
    'symlink_dir' => 'var/www/html/uploads/images/',

    // URL for the server; do not forget the trailing slash!
    // If you leave this empty, the URL stays the same as the page is
    'page_url' => 'https://subdomain.yoururl.com/',

    // Characters for the random filename
    'random_name_alphabet' => 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789',

    // Mime type you want to accept
    'screenshot_mime_type' => IMAGETYPE_JPEG,
 );
?>
