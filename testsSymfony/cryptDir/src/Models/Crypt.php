<?php

namespace App\Models;

use ZipArchive;


class Crypt{
    public function zip($name){
            $zip = new ZipArchive();
            $ret = $zip->open('../data/data.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
            if ($ret !== TRUE) {
                printf('Failed with code %d', $ret);
            } else {
                $zip->addFile("../data/cryptDir/test.php", 'files/test.php');
                $zip->setEncryptionName("files/test.php", ZipArchive::EM_AES_256, "test");
                $zip->close();
            }
    }
}