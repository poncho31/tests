<?php
$folder = (isset($_POST['folder']))?$_POST['folder']: false;
$mimetype = (isset($_POST['mimetype']))?$_POST['mimetype']: null;
$getMusic = (isset($_POST['getMusic']))?$_POST['getMusic']: false;

    if ($folder) {
        getFile($folder, $mimetype);
        // echo json_encode(["hola"]);
    }
    elseif (isset($_POST['getMusic'])) {
        getMusic($getMusic, true);
    }

    function getFile($folder, $mimetype, $json = true){

        $deeping = substr_count($folder, "\\");
        if (!isset($echo)) {
            $echo = "";
        }
        $dirName = pathinfo($folder, PATHINFO_BASENAME);
        $echo .= "<p style='margin-left: ".($deeping * 10)."px; color: darkred;'>".($deeping-1).". " . $dirName. "<p>";
        $fileInfoMimeType = finfo_open(FILEINFO_MIME_TYPE);
        foreach (scandir($folder) as $item) {
            $fileName = pathinfo($item, PATHINFO_BASENAME);
            $path = $folder ."\\". $fileName;

            if ($item != "." && $item != "..") {
                if (is_dir($path)) {
                    if ($item != "Tablatures") {
                        $total_items  = count( glob($path . "\\*", GLOB_ONLYDIR) );
                        // echo "Folder : " . $path . " [ ".$total_items." ]"."<br>";
                       
                        getFile($path, $mimetype, false);
                    }
                }
                elseif(true){
                    $meta = ["duration"=>false, "audio"=>false, "type"=>false];
                    $fileType = finfo_file($fileInfoMimeType, $path);
                    $mimetype = ($mimetype == null)? "audio": $mimetype;
                    if(strstr($fileType, $mimetype)){
                       
                        if ($meta['duration']) {
                            $durationCapture = "ffmpeg -i " . escapeshellarg($path) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//";
                            $duration = exec($durationCapture);
                        }
                        else{$duration="none";}
                        if ($meta['audio']) {
                            getMusic($path, false);
                        }
                        else{
                            $audio = "<div class='getMusic' id='$path' ><button >$fileName</button></div>";
                        }
                        $echo .= "<p style='margin-left: ".($deeping * 10)."px'>" .
                        $audio
                        .
                        " [ Type : ".$fileType."; Duration : ".
                         $duration
                         ." ]" 
                         ."<p>";
                        // echo pathinfo($item, PATHINFO_EXTENSION) . "<br>";
                    }
                }
            }
        }
        if ($json) {
            echo json_encode($echo);
        }
        
    }
    function getMusic($path, $jsonResponse){
        $fileName = basename($path);
        if (!file_exists("./temp/".$fileName)) {
            copy($path, "./temp/".$fileName);
        }
        $audio = 
            substr($fileName, 0, 50).
            "
            <audio controls>
                <source src='./temp/$fileName' type='audio/ogg'>
                <source src='./temp/$fileName' type='audio/mpeg'>
                <source src='./temp/$fileName' type='audio/wav'>
                Your browser does not support the audio element.
            </audio>";
        if ($jsonResponse) {
            echo json_encode($audio);
        }
    }