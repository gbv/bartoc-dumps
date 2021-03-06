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
            <?=$LICENSE?>
          </div>
          <div class="col-md-2 text-right text-muted">
            <i class="fa fa-github"></i>
            <a href="<?=$SOURCES?>">sources</a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=$BASE?>/js/jquery.min.js"></script>
    <script src="<?=$BASE?>/js/bootstrap.min.js"></script>
    <script src="<?=$BASE?>/concordances/lib/tablesorter/jquery.tablesorter.min.js"></script>
    <script type="text/javascript">
      $(function(){ $(".table.sortable").tablesorter({'theme':'gbv'}); });
    </script>
  </body>
</html>
