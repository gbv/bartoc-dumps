<?php

// make sure the script is run from command line
if (php_sapi_name() != "cli") exit;

include 'libs.php';

if (!preg_match('/^([a-z]+)\.ndjson$/', $argv[1] ?? '', $match)) {
    exit(1);
}
$dir = $match[1];

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$ndjson = fopen("$dir.ndjson","w");
if (!$ndjson) {
    die("Failed to open $dir.ndjson!\n");
}

$service = new \BARTOC\JSKOS\Service();

$count=0;

// read BARTOC IDs from STDIN
while ($line = fgets(STDIN)) {
    $id = rtrim($line);
    if (!preg_match('/^[0-9]+$/', $id)) continue;
    $uri = "http://bartoc.org/en/node/$id";
    $file = "$dir/$id.json";

    // get BARTOC record via RDFa in JSKOS
    $jskos = $service->queryURI($uri);
    if ($jskos) {
        file_put_contents($file, $jskos->json());
        fputs($ndjson, "$jskos\n");
        echo "$uri - $file\n";
        $count++;
    } else {
        echo "$uri - not found or failed\n";
    }
}

echo "got $count $dir\n";

