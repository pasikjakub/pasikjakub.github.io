<?php 
function moveAndInsertImage($file)
{
    $targetDirectory = '../assets/images/';
    $targetFile = $targetDirectory . basename($file['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // unikalna nazwa
    $filename = uniqid() . '.' . $imageFileType;


    if (move_uploaded_file($file['tmp_name'], $targetDirectory . $filename)) {
        return $filename;
    }

    return ''; //pusty string jesli error
}

?>