<?php

require __DIR__.'/vendor/autoload.php';

$dir = $argv[1] ?? '';
if (!is_dir($dir)) {
    die("please provide an existing target directory!\n");
}

$ndjson = fopen("$dir.ndjson","w");
if (!$ndjson) {
    die("Failed to open $dir.ndjson!\n");
}

$service = new \BARTOC\JSKOS\Service();

$count=0;

# read BARTOC IDs from STDIN
while ($line = fgets(STDIN)) {
    $id = rtrim($line);
    $uri = "http://bartoc.org/en/node/$id";
    $file = "$dir/$id.json";

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

