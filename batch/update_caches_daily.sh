#!/bin/sh
./symfony opp-build-cache-politici --ramo=parlamento
./symfony opp-build-cache-gruppi
./symfony opp-build-cache-rami
./symfony opp-rebuild-deltas

# non è più necessario rigenerare il nuovo indice, perché la build-cache-politici lo fa
# i record sono di tipo P e non più di tipo N
# ./symfony opp-calcola-nuovo-indice

./symfony opp-calcola-rilevanza-atti
./symfony opp-calcola-rilevanza-tag
