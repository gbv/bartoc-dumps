<?php // Utility functions

function read_ndjson_file($file) {
    $ndjson = rtrim(file_get_contents($file));
    $items = array_map('json_decode', explode("\n", $ndjson));
    $uris = array_map(function ($x) { return $x->uri; }, $items);
    $items = array_combine($uris, $items);
    uasort($items, function ($a, $b) {
        $a = (int) preg_replace('/[^0-9]/','', $a->uri);
        $b = (int) preg_replace('/[^0-9]/','', $b->uri);
        return $a < $b ? -1 : 1;
    });
    return $items;
}

# TODO: use service instead (client-side?)
function get_licenses($file) {
    $json = json_decode(file_get_contents);
    $licenses = [];
    foreach ($json->concepts as $concept) {
        $licenses[$concept->uri] = $concept;
    }
    return $licenses;
}

function emit_jskos_if_requested($items) {
    if (!isset($_GET['uri'])) return;

    $uri = $_GET['uri'];
    $item = isset($items[$uri]) ? $items[$uri] : [];
    ksort($item);
    header('Content-type: application/json');
    echo json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

?>
