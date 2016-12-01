This repository contains scripts to create JSKOS dumps and statistics of
[BARTOC](http://bartoc.org/) to be published at
<https://coli-conc.gbv.de/publications/bartoc/>.

The dumps are *not* based on the full downloads provided at
<http://bartoc.org/de/download/> but on a mapping of RDFa output to JSKOS.

* **scheme-ids** - list of BARTOC KOS IDs
* **schemes/\*.json** - BARTOC KOS records in JSKOS
* **registry-ids** - list of BARTOC terminology registry URIs
* **registries/\*.json** - BARTOC registry records in JSKOS

The `update` script looks for changes. The `download` script is used to collect
JSKOS records from a JSKOS API, for instance:

    ./download http://localhost:8080/BARTOC.php schemes < scheme-ids
    ./download http://localhost:8080/BARTOC.php registries < registry-ids

See <https://github.com/gbv/jskos-php-examples> for an implementation of a JSKOS
API wrapping BARTOC RDFa Linked Open Data.

Reports and statistics can be generated with `report` into directory `reports`.

The `combine` script combines scheme and registry files into two dumps
(`schemes.ndjson` and `registries.ndjson`).

The scripts require at least Catmandu 0.9206 (libcatmandu-perl).

To regularly run update, create a shell script such as the following to be run
via cronjob: 

    cd $location
    ./update
    ./download $url schemes < scheme-ids
    ./download $url registries < registry-ids
    ./combine
    ./report

To ensure proper Mime types for JSON and NDJSON files it makes sense to
configure your Webserver, for instance like this:

    AddDefaultCharset utf-8
    AddType 'application/json; charset=UTF-8' .json
    AddType 'application/x-ndjson; charset=UTF-8' .ndjson

