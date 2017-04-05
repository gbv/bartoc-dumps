<?php

$dir = $argv[1] ?? '';
if (!is_dir($dir)) {
    die("please provide an existing target directory!\n");
}

require __DIR__.'/vendor/autoload.php';

$service = new \BARTOC\JSKOS\Service();


# read BARTOC IDs from STDIN
while ($line = fgets(STDIN)) {
    $id = rtrim($line);
    $uri = "http://bartoc.org/en/node/$id";
    $file = "$dir/$id.json";

    $jskos = $service->queryURI($uri);
    if ($jskos) {
        file_put_contents($file, $jskos->json());
        echo "$uri - $file\n";
    } else {
        echo "$uri - not found or failed\n";
    }
}

