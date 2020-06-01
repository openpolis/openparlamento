#!/bin/sh

./symfony opp-build-cache-politici --ramo=camera
./symfony opp-build-pos-cache-politici --ramo=camera
./symfony opp-upgrade-opp-carica-from-cache --ramo=camera

./symfony opp-build-cache-politici --ramo=senato
./symfony opp-build-pos-cache-politici --ramo=senato 
./symfony opp-upgrade-opp-carica-from-cache --ramo=senato

./symfony opp-build-cache-gruppi
./symfony opp-build-cache-rami


#./symfony opp-build-cache-atti
#./symfony opp-build-cache-tags

#./symfony opp-compute-delta-politici
#./symfony opp-compute-delta-atti
# ./symfony opp-compute-delta-tags
