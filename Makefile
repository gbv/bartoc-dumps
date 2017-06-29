.SUFFIXES: .ids .ndjson .nt
.PHONY: ids report

# combined RDF dump
bartoc.nt: schemes.nt registries.nt
	cat $^ > $@

# JSKOS to RDF/NTriples
.ndjson.nt:
	php jsonld2nt.php $< > $@

# fetch lists of IDs
ids: schemes.ids registries.ids

# fetch list of BARTOC registries
registries.ids:
	curl --silent https://bartoc.org/en/terminology-registries 2>&1 \
     | grep -oP '<article id="node-\d+"' | sed 's/[^0-9]//g' \
	 | sort -n | uniq > $@

# fetch BARTOC recent changes and extract KOS IDs
schemes.ids:
	curl --silent https://bartoc.org/en/tracker 2>&1 \
     | grep -oP '/en/node/\d+' | sed 's/[^0-9]//g' \
	 | sort -n | uniq > new-schemes.ids && \
	cat schemes.ids new-schemes.ids | sort -n | uniq > all-schemes.ids && \
	mv all-schemes.ids schemes.ids

# download voa RDFa based on lists of IDs
download: schemes.ndjson registries.ndjson
.ids.ndjson:
	php download.php $@ < $<

	

report:
	./report
