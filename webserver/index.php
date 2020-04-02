<?php
include 'settings.php';

$files = array();
$counter = 0;

if ($sym_folder_set == True) {
    $folder = $sym_folder;
} else {
    $folder = $upload_folder;
}

if (isset($_GET['delete'])) {
    if (strpos($_GET['delete'], $folder) !== false) {
        unlink($_GET['delete']);
        header('Location: ' . $base_url);
    } else {
        exit("Error, file not found!");
    }
} else {
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
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="refresh" content="30" >
    <title>TM - Screenshots</title>
    <link rel="icon" type="image/icon" href="favicon.ico"/>
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
