<?php
function createVariableName($words) {
    $words = preg_replace('/[^A-Za-z0-9]/', '', ucwords($words));
    if(strlen($words) > 30) {
        $words = substr($words, 0, 30) .'_';
    }

    return strtolower(substr($words, 0, 1)) . substr($words, 1);
}

function writeJSONFile($fileName, $fileContents) {
    $fileContents = iconv('UTF-8', 'ISO-8859-1', $fileContents);

    $file = fopen($fileName, 'w');
    if($file) {
        fwrite($file, $fileContents);
        fclose($file);
    }
}


if(!isset($argv[1]) || !isset($argv[2])) {
    throw new Exception('Please pass in two arguments: the input .tmx file and the output .json file.');
}

$inputTMXFile = $argv[1];
$outputJSONFile = $argv[2];

$doc = new DOMDocument('1.0', 'ISO-8859-1');
$handle = fopen($inputTMXFile, 'r');
if(!$doc->loadXML(fread($handle, filesize($inputTMXFile)))) {
    throw new Exception('Error reading master.tmx file.');
}

$json = array();

$tus = $doc->getElementsByTagName('tu');
foreach($tus as $tu) {
    $obj = new stdClass();
    if($tu->hasAttribute('tuid')) {
        $obj->variable = createVariableName($tu->getAttribute('tuid'));
        $obj->en = $tu->getAttribute('tuid');

        $currentTuv = $tu->firstChild;
        if($tu->firstChild != null && $tu->firstChild->firstChild != null) {
            if($tu->firstChild->hasAttribute('xml:lang')) {
                $lang = $tu->firstChild->getAttribute('xml:lang');
                $obj->$lang = $tu->firstChild->firstChild->textContent; 
            }
        }
    }

    $json[] = str_replace('":"', '": "', str_replace('"}', "\"\n}", str_replace('{"', "{\n\t\"", str_replace('",', "\",\n\t", json_encode($obj, JSON_UNESCAPED_UNICODE)))));
}

writeJSONFile($outputJSONFile, "[". join(",", $json) ."]");
