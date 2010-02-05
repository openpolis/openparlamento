#!/bin/sh
php symfony solr-update-propel-model fe OppPolitico 1000
php symfony solr-update-propel-model fe OppVotazione 200
php symfony solr-update-propel-model fe OppDocumento 200
php symfony solr-update-propel-model fe OppAtto 500
php symfony solr-update-propel-model fe OppEmendamento 1000
php symfony solr-update-propel-model fe OppResoconto 500
php symfony solr-update-propel-model fe Tag 1000