#!/bin/sh

# calcolo indice per i politici di camera e senato
for i in 0 100 200 300 400 500 600; do ./symfony opp-calcola-indice --ramo=camera --offset=$i --limit=100; done;
for i in 0 100 200 300 400; do ./symfony opp-calcola-indice --ramo=senato --offset=$i --limit=100; done;
