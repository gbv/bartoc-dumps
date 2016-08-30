This repository contains JSKOS dumps and statistics of
[BARTOC](http://bartoc.org/).

The dumps are *not* based on the full downloads provided at
<http://bartoc.org/de/download/> but on a mapping of RDFa output to JSKOS.

* **scheme-ids** - list of BARTOC KOS IDs
* **schemes/\*.json** - BARTOC KOS records in JSKOS
* **registry-ids** - list of BARTOC terminology registry URIs
* **registries/\*.json** - BARTOC registry records in JSKOS

The `update` script looks for changes. The `download` script is used to collect
JKSO records from a JSKOS API, for instance:

    ./download http://localhost:8080/BARTOC.php scheme < scheme-ids
    ./download http://localhost:8080/BARTOC.php registry < registry-ids

Reports and statistics can be generated with `report` into directory `reports`.
