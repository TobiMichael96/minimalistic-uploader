<?php
if (file_exists('uploader/config.php')) {
    include 'uploader/config.php';
    if ($settings['symlink_dir'] !== '') {
        $folder = $settings['symlink_dir'];
    } else {
        $folder = $settings['upload_dir'];
    }
    $extension = $settings['image_extension'];
    $base_url = $settings['page_url'];
} else {
    $folder = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    $extension = 'jpg';
    $base_url = autoDetectBaseUrl();
}


if (isset($_GET['delete'])) {
    unlink($_GET['delete']);
    header('Location: ' . $base_url);
} else {
    $files = array();
    $counter = 0;

    foreach (glob($folder . '*.*') as $file) {
        if (substr($file, strpos($file, ".") + 1) == $extension) {
            $files[$counter] = array("name" => basename($file), "time" => filemtime($file), "path" => $file);
            ++$counter;
        }
    }

    usort($files, function ($a, $b) {
        return $b['time'] <=> $a['time'];
    });
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

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>TM - Screenshots</title>
    <link rel="icon" type="image/png" href="https://www.tobiasmichael.de/images/my-fav.png"/>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="custom_font.css">
</head>
<body class="text-center">
<div class="body-content">
    <div class="p-3 h-100 d-flex justify-content-center">
        <table class="table" id="table">
            <thead class="thead-dark">
            <tr class="d-flex">
                <th scope="col" class="col-5">Link</th>
                <th scope="col" class="col-5">Created on</th>
                <th scope="col" class="col-2">Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($files as $key => $value) {
                $time = $value["time"];
                $name = $value["name"];
                $path = $value["path"];

                echo '<tr class="d-flex">';
                echo '<td class="col-5"><a target="_blank" rel="noopener noreferrer" href="' . $base_url . $name . '"><h5>' . substr($name, 0, strpos($name, ".")) . '</h5></a></td>';
                echo '<td class="col-5">' . date("d F Y", $time) . ' at ' . date("H:i:s", $time) . '</td>';
                echo '<td class="col-2"><a href="' . $base_url . 'index.php?delete=' . $path . '" class="btn btn-danger btn-sm">Delete</a></td>';
                echo '</tr>';

            }
            ?>

            </tbody>
        </table>
    </div>
</div>

</body>
</html>
