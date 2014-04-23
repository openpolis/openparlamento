#!/bin/bash

# togli il commento per generare anche i dati correnti
# ./symfony opp-build-cache-politici --ramo=parlamento;
# ./symfony opp-build-pos-cache-politici --ramo=camera;
# ./symfony opp-build-pos-cache-politici --ramo=senato;
# ./symfony opp-build-cache-gruppi;
# ./symfony opp-build-cache-rami;
# ./symfony opp-build-cache-atti

declare -a KEY_DATES=(\
 '2013-03-31' '2013-04-30' '2013-05-31' '2013-06-30' '2013-07-31' '2013-08-31' '2013-09-30' '2013-10-31' '2013-11-30' '2013-12-31' \
 '2014-01-31' '2014-02-28' '2014-03-31'\
)

# dati storici
for data in ${KEY_DATES[@]}
do 
  ./symfony opp-build-cache-politici --ramo=camera --data=$data;
  ./symfony opp-build-pos-cache-politici --ramo=camera --data=$data; 
  ./symfony opp-build-cache-politici --ramo=senato --data=$data;
  ./symfony opp-build-pos-cache-politici --ramo=senato --data=$data;
  ./symfony opp-build-cache-gruppi --data=$data;
  ./symfony opp-build-cache-rami --data=$data;  
  ./symfony opp-build-cache-atti --data=$data
done

# riempimento informazioni delta

# togli il commento per generare anche i dati correnti
# ./symfony opp-compute-delta-politici
# ./symfony opp-compute-delta-atti

# dati storici
for data in ${KEY_DATES[@]}
do 
  ./symfony opp-compute-delta-politici --data=$data
  ./symfony opp-compute-delta-atti --data=$data
done
