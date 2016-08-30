This directory contains reports and statistics of BARTOC records.

* **no-...**: BARTOC records without selected field
* **labels.tsv**: statistic on labels for each record
* **languages.tsv**: BARTOC records and its languages 

Further processing can be done with awk and other command line tools, for example:

Number of records without URL:

    wc -l reports/no-url

Records with prefLabel of undefined language:

    awk '$3==1' reports/labels.tsv

Histogram of languages:

    awk '{print $2}' reports/languages.tsv | sort | uniq -c | sort -nk1

The reports can be updated with script `../report`.
