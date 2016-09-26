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
    </li>
    <li>
        <a href="registry/">terminology registries in JSKOS</a>
        (<?php echo count($registries).', last updated '.date ("Y-m-d H:i", $registryTime); ?>)
    </li>
    <li><a href="reports/">data quality reports of concept schemes in JSKOS</li>
</ul>
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
            <a href="https://github.com/gbv/coli-conc.gbv.de/blob/master/publications/index.html">source</a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
