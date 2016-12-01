<?php

use \ML\JsonLD\JsonLD;
use \ML\JsonLD\NQuads;

if (count($argv) > 1) {
    require('vendor/autoload.php');

    require('library.php');

    $context = json_decode(file_get_contents('jskos-context.jsonld'));
    $nquads = new NQuads();

	$ndjsonfile = $argv[1];
	$items = read_ndjson_file($ndjsonfile);

	foreach ($items as $item) {
		unset($item->{'@context'});

		$quads = JsonLD::toRdf($item, ['expandContext' => $context]);
		$serialized = $nquads->serialize($quads);
		print $serialized;
	}
}

?>
