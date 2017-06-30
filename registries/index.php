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

<table class="table">
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

    $api = count($jskos->API) ? $jskos->API[0]->url : '';
    $t = in_array("http://bartoc.org/en/taxonomy/term/51230", $jskos->type)
        ? 'repository' : ($api ? 'service' : 'register');
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

<?php include '../footer.php'; ?>
