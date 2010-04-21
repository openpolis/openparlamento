#!/bin/sh

# calcolo indice complessivo per i politici di governo, camera e senato
./symfony opp-calcola-indice --ramo=governo

for (( i = 0 ; i < 630 ; i += 50 )) 
do 
  ./symfony opp-calcola-indice --ramo=camera --offset=$i --limit=50
done

for (( i = 0; i < 350 ; i += 30 ))
do
  ./symfony opp-calcola-indice --ramo=senato --offset=$i --limit=30
done

