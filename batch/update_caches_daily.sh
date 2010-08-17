#!/bin/sh
./symfony opp-build-cache-politici --ramo=parlamento
./symfony opp-build-cache-gruppi
./symfony opp-build-cache-rami
./symfony opp-rebuild-deltas
./symfony opp-calcola-nuovo-indice
./symfony opp-calcola-rilevanza-atti
./symfony opp-calcola-rilevanza-tag
