<?php 

include_once 'library.php';

$TITLE = 'BARTOC dumps';
$BASE = '../..';
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
  Please report error in BARTOC to the
  <a href="http://bartoc.org/en/node/1948">BARTOC editors</a> and errors in
  the JSKOS downloads
  <a href="https://github.com/gbv/bartoc-dumps/issues">at this issue tracker</a>!
</p>

<h3><a href="schemes/"><?=$schemeCount?> concept schemes</a></h3>
<p>Last update: <?=$schemeTime?></p>
<p>
<ul>
    <li>
        <span class="glyphicon glyphicon-arrow-right"></span>
        <a href="schemes.ndjson">download all (JSKOS / NDJSON)</a>
    </li>
    <?php
        if(file_exists("schemes.nt")) { 
            echo '<li><span class="glyphicon glyphicon-arrow-right"></span> ';
            echo "<a href='schemes.nt'>download all (RDF / NTriples)</a></li>";
        }
    ?>
    <li>
        <a href="reports/">data quality reports</a> of concept schemes in JSKOS
    </li>
</ul>

<h3><a href="registries/"><?=$registryCount?> terminology registries</a></h3>
<p>Last update: <?=$registryTime?></p>
<ul>
    <li>
        <span class="glyphicon glyphicon-arrow-right"></span>
        <a href="registries.ndjson">download all (JSKOS in NDJSON)</a>
    </li>
    <?php
        if(file_exists("registries.nt")) {
            echo '<li><span class="glyphicon glyphicon-arrow-right"></span> ';
            echo "<a href='registries.nt'>download all (RDF / NTriples)</a></li>";
        }
    ?>
</ul>
<p>
  See <a href="https://doi.org/10.5281/zenodo.166717">https://doi.org/10.5281/zenodo.166717</a>
  for a survey of terminology registries and services based on this data.
</p>

<?php include 'footer.php'; ?>
