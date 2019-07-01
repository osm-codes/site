# site
Website of de domain <tt>OSM.codes</tt> and its services.

The website is the "interface module" of the system. The complete system depends on databases and web services:

* git repository of stable OpenStreetMap, stable Wikidata and other stable sources. "Stable" meaning "filtered and preserved" datasets.

* PostgreSQL dababase and data models joining all stable sources. All public data exposed by PostgREST, the generic web service

* specialized micro-services: ...

* dynamic and static web pages, as help for non-techinical users and final users (human consumers).

This repository contains only the source code of:
* [src_etc/script.nginx](src_etc/script.nginx): the web services, microservices and web pages controller.
* src_www: web pages, instuctions and complementar redirections.

All other pieces of the <tt>OSM.codes</tt> service have a hi-level description at [osm-codes/spec](https://github.com/osm-codes/spec) repository.
