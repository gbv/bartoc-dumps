<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>coli-conc: BARTOC dumps</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/bootstrap-vzg.css">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
			<span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">coli-conc</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="../../">About</a></li>
            <li><a href="../../terminologies/">Terminologies</a></li>
            <li><a href="../../concordances/">Concordances</a></li>
            <li><a href="../../cocoda/">Cocoda prototype</a></li>
            <li class="active"><a href="../">Publications</a></li>
			<li><a href="../../contact/">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <h2>Publications</h2>
<h3>BARTOC database dumps and reports <small><img src="cc-zero.svg"></small></h3>
<p>
  This page contains database dumps of 
  <a href="http://bartoc.org/">BARTOC.org</a> converted to
  <a href="https://gbv.github.io/jskos/">JSKOS format</a>.
  All data is made available under 
  <a href="https://creativecommons.org/publicdomain/zero/1.0/">CC Zero</a>.
</p>
<?php

$schemes = glob('scheme/*.json');
$registries = glob('registry/*.json');

$schemeTime = min(array_map('filemtime', $schemes));
$registryTime = min(array_map('filemtime', $registries));

?>
<ul>
    <li>
        <a href="scheme/">concept schemes in JSKOS</a>
        (<?php echo count($schemes).', last updated '.date ("Y-m-d H:i", $schemeTime); ?>)
        <br>
        <span class="glyphicon glyphicon-arrow-right"></span>
        <a href="schemes.ndjson">download all (NDJSON)</a>
    </li>
    <li>
        <a href="registry/">terminology registries in JSKOS</a>
        (<?php echo count($registries).', last updated '.date ("Y-m-d H:i", $registryTime); ?>)
        <br>
        <span class="glyphicon glyphicon-arrow-right"></span>
        <a href="registries.ndjson">download all (NDJSON)</a>
    </li>
    <li>
        <a href="reports/">data quality reports</a> of concept schemes in JSKOS
        <?php if (!@$_GET['report']) echo '<sup><a href="?report=table">show table</a></sup>'; ?>
    </li>
</ul>
    <p>
      Please report error in BARTOC to the 
      <a href="http://bartoc.org/en/node/1948">BARTOC editors</a> and errors in
      the database dumps 
      <a href="https://github.com/gbv/bartoc-dumps/issues">at this issue tracker</a>!
    </p>

<?php if (@$_GET['report']) { ?>

    <h4>Concept schemes report <small><a href="./">hide</a></small></h4>
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>notation</th>
          <th>name</th>
          <th>created</th>
          <th>license</th>
          <th>Wikidata</th>
        </tr>
      </thead>
      <tbody>
<?php

$licenses = [
  'http://creativecommons.org/publicdomain/zero/1.0/' => 'CC0',
  'http://creativecommons.org/licenses/by/3.0/' => 'CC BY',
  'http://creativecommons.org/licenses/by-sa/3.0/' => 'CC BY-SA',
  'http://creativecommons.org/licenses/by-nd/3.0/' => 'CC BY-ND',
  'http://creativecommons.org/licenses/by-nc/3.0/' => 'CC BY-NC',
  'http://creativecommons.org/licenses/by-nc-sa/3.0/' => 'CC BY-NC-SA',
  'http://creativecommons.org/licenses/by-nc-nd/3.0/' => 'CC BY-ND',
  'http://www.opendatacommons.org/licenses/odbl/' => 'ODbL',
  'http://www.opendatacommons.org/licenses/by/1.0/' => 'ODC-By',
  'http://www.opendatacommons.org/licenses/pddl/' => 'PDDL',
];
$ids = array_map(
    function ($s) { return preg_replace('/[^0-9]/','', $s); }, 
    $schemes
);
sort($ids, SORT_NUMERIC);
foreach ($ids as $id) {
    echo "<tr>";
    echo "<td><a href='http://bartoc.org/en/node/$id'>$id</a></td>";
    $json = json_decode(file_get_contents("scheme/$id.json"));
    echo "<td>" . $json->notation[0] . "</td>";
    echo "<td>";
    $label = $json->prefLabel->en;
    if ($label) {
        echo htmlspecialchars($label);
    } else {
        $label = $json->prefLabel->und;
        $lang = "und";
        if (!$label) {
            $lang = array_keys(get_object_vars($json->prefLabel))[0];
            $label = $json->prefLabel->{$lang};
        } 
        if ($label) {
            echo "<i>".htmlspecialchars($label)."</i>";
            if ($lang == "und") {
                echo "<sup class='text-warning'> $lang</sup>";
            } else if ($lang != 'en') {
                echo "<sup> $lang</sup>";
            }
        }
    }
    echo "<td>" . $json->created . "</td>";
    echo "<td>";
    if ($json->license && count($json->license)) {
        $license = $json->license[0]->uri;
        echo "<a href='$license'>".$licenses[$license]."</a>";
    }
    echo "</td>";
    echo "<td>";
    $wikidata = preg_grep('/^http:\/\/www.wikidata.org\/entity/',$json->identifier);
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
<?php } // if report ?>

</div>

    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-10 text-muted">
  	        coli-conc is a project of the head office of GBV –
            <a href="https://www.gbv.de/">Verbundzentrale des GBV (VZG)</a>
            – funded by German Research Foundation (DFG)
          </div>
          <div class="col-md-2 text-right text-muted">
             <i class="fa fa-twitter"></i>
             <a href="https://twitter.com/coli_conc" title="follow @coli_conc at twitter">
                @coli_conc
             </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-10 text-muted">
          </div>
          <div class="col-md-2 text-right text-muted">
            <i class="fa fa-github"></i>
            <a href="https://github.com/gbv/bartoc-dumps">sources</a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
