#!/bin/sh
export data=`php -r"echo date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-01'))));"`
./symfony opp-build-cache-politici --ramo=parlamento --data=$data
./symfony opp-build-cache-gruppi --data=$data
./symfony opp-build-cache-rami --data=$data
./symfony opp-rebuild-deltas --data=$data
./symfony opp-calcola-nuovo-indice --data=$data
./symfony opp-calcola-rilevanza-atti --data=$data
