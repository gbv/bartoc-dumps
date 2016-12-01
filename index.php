<?php 

include_once 'library.php';

$BASE = '../..';
$MENU = 'publications';
$SOURCES = 'https://github.com/gbv/bartoc-dumps';
$LICENSE = '<img src="cc-zero.svg">';

include 'header.php';

$schemeCount = count(read_ndjson_file("schemes.ndjson"));
$schemeTime  = date ("Y-m-d H:i", filemtime("schemes.ndjson"));

$registryCount = count(read_ndjson_file("registries.ndjson"));
$registryTime  = date ("Y-m-d H:i", filemtime("registries.ndjson"));

?>

<h2>Publications</h2>
<h3>BARTOC database dumps and reports</h3>
<p>
  RDFa data of <a href="http://bartoc.org/">BARTOC.org</a> terminology registry
  is daily converted to <a href="https://gbv.github.io/jskos/">JSKOS format</a>
  and provided here for download. The data can be used as public domain 
  (<a href="https://creativecommons.org/publicdomain/zero/1.0/">CC Zero</a>).
</p>
<p>
<ul>
    <li>
        <a href="schemes/"><?=$schemeCount?> concept schemes</a>
        (<?=$schemeTime?>)
        <br>
        <span class="glyphicon glyphicon-arrow-right"></span>
        <a href="schemes.ndjson">download all (NDJSON)</a>
    </li>
    <li>
    <a href="registries/"><?=$registryCount?> terminology registries</a>
        (<?=$registryTime?>)
        <br>
        <span class="glyphicon glyphicon-arrow-right"></span>
        <a href="registries.ndjson">download all (NDJSON)</a>
    </li>
    <li>
        <a href="reports/">data quality reports</a> of concept schemes in JSKOS
    </li>
</ul>
<p>
  Please report error in BARTOC to the
  <a href="http://bartoc.org/en/node/1948">BARTOC editors</a> and errors in
  the JSKOS downloads
  <a href="https://github.com/gbv/bartoc-dumps/issues">at this issue tracker</a>!
</p>
<?php include 'footer.php'; ?>
