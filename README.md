# BARTOC dumps

This repository contains scripts to create JSKOS/RDF dumps and statistics of
[BARTOC](http://bartoc.org/) to be published at
<https://coli-conc.gbv.de/publications/bartoc/>.

## Background

The dumps are *not* based on the full downloads provided at
<http://bartoc.org/de/download/> but on a mapping of RDFa output to JSKOS.

* **schemes.ids** - list of BARTOC KOS IDs
* **schemes/\*.json** - BARTOC KOS records in JSKOS
* **schemes.ndjson** - dito
* **registries.ids** - list of BARTOC terminology registry IDs
* **registries/\*.json** - BARTOC registry records in JSKOS
* **registries.ndjson** - dito

Script `download.php` collects JSKOS records by wrapping the RDFa output from
BARTOC and `jsonld2nt.php` converts JSKOS to RDF/NTriples. See `Makefile` for
details. 

See <https://github.com/gbv/jskos-php-examples> for an implementation of a JSKOS
API wrapping BARTOC RDFa Linked Open Data.

Reports and statistics can be generated with `report` into directory `reports`.

## Installation

First install requirements:

    composer install --no-dev

To regularly run update, create a shell script such as the following to be run
via cronjob: 

    cd $location
    make -B ids
    make
    make report

To ensure proper Mime types for JSON and NDJSON files it makes sense to
configure your Webserver, for instance like this:

    AddDefaultCharset utf-8
    AddType 'application/json; charset=UTF-8' .json
    AddType 'application/x-ndjson; charset=UTF-8' .ndjson

