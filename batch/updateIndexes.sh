#!/bin/sh

php symfony solr-delete-propel-model fe OppPolitico
php symfony solr-update-propel-model fe OppPolitico 1000

php symfony solr-delete-propel-model fe OppVotazione
php symfony solr-update-propel-model fe OppVotazione 200

php symfony solr-delete-propel-model fe OppDocumento
php symfony solr-update-propel-model fe OppDocumento 200

php symfony solr-delete-propel-model fe OppAtto
php symfony solr-update-propel-model fe OppAtto 500

php symfony solr-delete-propel-model fe OppEmendamento
php symfony solr-update-propel-model fe OppEmendamento 1000

php symfony solr-delete-propel-model fe OppResoconto
php symfony solr-update-propel-model fe OppResoconto 500

php symfony solr-delete-propel-model fe Tag
php symfony solr-update-propel-model fe Tag 1000

