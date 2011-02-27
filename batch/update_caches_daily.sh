#!/bin/sh
./symfony opp-build-cache-politici --ramo=parlamento
./symfony opp-build-pos-cache-politici --ramo=camera
./symfony opp-build-pos-cache-politici --ramo=senato 
./symfony opp-upgrade-opp-carica-from-cache --ramo=camera
./symfony opp-upgrade-opp-carica-from-cache --ramo=senato

./symfony opp-build-cache-gruppi
./symfony opp-build-cache-rami

./symfony opp-calcola-rilevanza-atti
./symfony opp-calcola-rilevanza-tag

#./symfony opp-rebuild-deltas
