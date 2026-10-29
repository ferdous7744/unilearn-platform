<?php
function uploadFile($folder, $old_file,$file, $type)
{
    echo $old_file;
    $typeImages = ['jpg', 'jpeg', 'png', 'gif'];
    $typePdf = ['pdf'];
    
    $typeFiles = $type == 'pdf' ? $typePdf : $typeImages;

$base = realpath(__DIR__ . "/..") . '/';

$path_file = $type == 'pdf'
    ? $base . "uploads" . '/' . "pdfs" . '/'
    : $base . "uploads" . '/' . $folder . '/';

$url_file = $type == 'pdf'
    ? "uploads/pdfs/"
    : "uploads/" . $folder . "/";

    if (!is_dir($path_file)) {
        mkdir($path_file, 0777, true);
    }

    $name = time();
    $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    // if ($image["size"] > 500000) {
    //     return false;
    // }

    if (!in_array($fileType, $typeFiles)) {
        return false;
    }

    $target_file = $path_file . $name . "." . $fileType;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        unlink($old_file);
        return $url_file . $name . "." . $fileType;
    }

    return false;
}
function contentType()
{
    return [
        'TD',
        'TP',
        'Cours',
        'Exam'
    ];
}