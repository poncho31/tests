<?php
$zip = new ZipArchive();
$filename = "./files/fichiersCSV.zip";
if ($zip->open($filename, ZipArchive::CREATE)===TRUE) {
    $dir = scandir('./files');
    foreach ($dir as $file) {
        if(!($file == "." || $file == "..")){
            $zip->addFile("./files/" . $file, $file);
            echo $file ."<br>";
        }
    }
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);

    $zip->close();
}