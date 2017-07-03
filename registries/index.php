<?php 

include_once '../libs.php';
$registries = read_ndjson_file("../registries.ndjson");
emit_jskos_if_requested($registries);

$BASE = '../../..';
$MENU = 'publications';
$SOURCES = 'https://github.com/gbv/bartoc-dumps';
$LICENSE = '<img src="../cc-zero.svg">';

include '../header.php';

$registryTime = date ("Y-m-d H:i", filemtime("../registries.ndjson"));
$prefLang   = @$_GET['lang'] or "en";

?>
<h2><a href="../../">Publications</a></h2>
<h3><a href="../">BARTOC database dumps and reports</a></h3>
<h4>Terminology Registries</h4>
<p>
  Terminology registries, such as <a href="http://bartoc.org/">BARTOC.org</a> collect and/or
  describe terminologies. In JSKOS registries are modeled as
  <a href="https://gbv.github.io/jskos/jskos.html#registry">Registry</a>.

   <?=count($registries)?> terminologies have been extracted from BARTOC.org
   until <?=$registryTime?> and converted to JSKOS format.
</p>

<table class="table sortable">
  <thead>
    <tr>
      <th></th>
      <th>id</th>
      <th>notation</th>
      <th>name</th>
      <th>type</th>
      <th>date</th>
      <th>API</th>
      <th>Wikidata</th>
    </tr>
  </thead>
  <tbody>

<?php

$types = [];

foreach ($registries as $jskos) {
    $id = preg_replace('/[^0-9]/','', $jskos->uri);
    echo "<tr>";
    echo "<td><a href='?uri=http://bartoc.org/en/node/$id'>*</a></td>";
    echo "<td><a href='http://bartoc.org/en/node/$id'>$id</a></td>";
    echo "<td>" . (isset($jskos->notation) ? $jskos->notation[0] : ""). "</td>";
    echo "<td>";
    $label = isset($jskos->prefLabel->{$prefLang}) ? $jskos->prefLabel->{$prefLang} : null;
    $url = $jskos->url;
    if ($label) {
        if ($url) {
            echo "<a href='$url'>".htmlspecialchars($label)."</a>";
        } else {
            echo htmlspecialchars($label);
        }
    } else {
        $label = isset($jskos->prefLabel->und) ? $jskos->prefLabel->und : null;
        $lang = "und";
        if (!$label) {
            $lang = array_keys(get_object_vars($jskos->prefLabel))[0];
            $label = $jskos->prefLabel->{$lang};
        }
        if ($label) {
            if ($url) {
                echo "<i><a href='$url'>".htmlspecialchars($label)."</a></i>";
            } else {
                echo "<i>".htmlspecialchars($label)."</i>";
            }
            if ($lang == "und") {
                echo "<sup class='text-warning'> $lang</sup>";
            } else if ($lang != $prefLang) {
                echo "<sup> $lang</sup>";
            }
        }
    }
    
    $api = count($jskos->subjectOf) ? $jskos->subjectOf[0]->uri : '';
    if (in_array("http://purl.org/dc/dcmitype/Collection", $jskos->type)) {
        $t = $api ? 'service' : 'repository';
    } else {
        $t = 'registry';
    }
    $types[$t]++;
    echo "<td>$t</td>";

    $date = $jskos->startDate . '-' . $jskos->endDate;
    echo "<td>$date</td>";

    echo "<td>";
    if ($api) echo "<a href='$api'>API</a>";
    echo "</td>";

    echo "<td>";
    $wikidata = preg_grep('/^http:\/\/www.wikidata.org\/entity/',$jskos->identifier);
    if ($wikidata) {
        echo "<a href='".$wikidata[0]."'>";
        echo preg_replace('/^.+(Q[0-9]+)/','\1',$wikidata[0]);
        echo "</a>";
    }
    echo "</td>";
    echo "</tr>\n";
}
?>

  </tbody>
</table>

<p>
Summary (see also <a href="https://doi.org/10.5281/zenodo.166717">https://doi.org/10.5281/zenodo.166717</a>):

<ul>
<li><?=$types['registry']?> simple terminology registries</li>
<li><?=$types['repository']?> full terminology repositories</li>
<li><?=$types['service']?> terminology services</li>
</ul>
</p>
<p>
</p>

<?php include '../footer.php'; ?>
