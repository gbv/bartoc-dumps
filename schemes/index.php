<?php 

include_once '../libs.php';

$schemes = read_ndjson_file("../schemes.ndjson");
emit_jskos_if_requested($schemes);

$BASE = '../../..';
$MENU = 'publications';
$SOURCES = 'https://github.com/gbv/bartoc-dumps';
$LICENSE = '<img src="../cc-zero.svg">';

$schemeTime = date ("Y-m-d H:i", filemtime("../schemes.ndjson"));
$prefLang   = @$_GET['lang'] or "en";
$licenses   = get_licenses("../licenses.json");
    
include '../header.php';

?>
<h2><a href="../../">Publications</a></h2>
<h3><a href="../">BARTOC database dumps and reports</a></h3>
<h4>Concept Schemes</h4>
<p>
  Terminologies, also known as <b>Knowledge Organization Systems (KOS)</b>, are modeled as
  <a href="https://gbv.github.io/jskos/jskos.html#concept-schemes">Concept Schemes</a> in (J)SKOS
  format. <?=count($schemes)?> terminologies have been extracted from 
  <a href="http://bartoc.org/">BARTOC.org</a> until <?=$schemeTime?> and converted to JSKOS format.
</p>

<table class="table">
  <thead>
    <tr>
      <th></th>
      <th>id</th>
      <th>notation</th>
      <th>name</th>
      <th>created</th>
      <th>creator (VIAF)</th>
      <th>license</th>
      <th>extent &amp; languages</th>
    </tr>
  </thead>
  <tbody>
<?php

foreach ($schemes as $jskos) {
    $id = preg_replace('/[^0-9]/','', $jskos->uri);
    echo "<tr>";
    echo "<td><a href='?uri=http://bartoc.org/en/node/$id'>*</a></td>";
    echo "<td><a href='http://bartoc.org/en/node/$id'>$id</a>";
    $wikidata = preg_grep('/^http:\/\/www.wikidata.org\/entity/',$jskos->identifier ?? []);
    if ($wikidata) {
        echo "<br><a href='".$wikidata[0]."'>";
        echo preg_replace('/^.+(Q[0-9]+)/','\1',$wikidata[0]);
        echo "</a>";
    }
    echo "</td>";
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

    echo "<td>". ($jskos->startDate ?? '') . "</td>";

    echo "<td>";
    echo implode(", ", array_map(function($c) {
        $id = explode('http://viaf.org/viaf/',$c->uri)[1];
        if ($id) return "<a href='http://viaf.org/viaf/$id'>$id</a>";
    }, $jskos->creator ?? []));
    echo "</td>";
    echo "<td>";
    if (count($jskos->license ?? [])) {
        $license = $jskos->license[0]->uri;
        $name = $license;
        if (isset($licenses[$license]) && !empty($licenses[$license]->uri)) {
            $name = $licenses[$license]->notation[0];
        }
        echo "<a href='$license'>$name</a>";
    }
    echo "</td>";
    
/*    } else {
        $api = count($jskos->API) ? $jskos->API[0]->url : '';
        $t = in_array("http://bartoc.org/en/taxonomy/term/51230", $jskos->type)
            ? 'repository' : ($api ? 'service' : 'register');
        echo "<td>$t</td>";
        echo "<td>";
        if ($api) echo "<a href='$api'>API</a>";
        echo "</td>";
        }
 */        

    echo "<td>";
    $languages = implode(' ', $jskos->languages ?? []);
    if ($languages) $languages = "<i>$languages</i>";
    echo implode('<br>', array_filter([
        htmlspecialchars($jskos->extent ?? ''),
        $languages,
    ]));
    echo "</td>";

    echo "</tr>\n";
}
?>

  </tbody>
</table>

<?php include '../footer.php'; ?>
