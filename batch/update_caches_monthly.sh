#!/bin/sh
export data=`php -r"echo date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-01'))));"`
./symfony opp-build-cache-politici --ramo=parlamento --data=$data
./symfony opp-build-cache-gruppi --data=$data
./symfony opp-build-cache-rami --data=$data
./symfony opp-rebuild-deltas --data=$data

# non è più necessario rigenerare il nuovo indice, perché la build-cache-politici lo fa
# i record sono di tipo P e non più di tipo N
#./symfony opp-calcola-nuovo-indice --data=$data

./symfony opp-calcola-rilevanza-atti --data=$data
./symfony opp-calcola-rilevanza-tag --data=$data
