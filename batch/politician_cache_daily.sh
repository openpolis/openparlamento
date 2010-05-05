#!/bin/sh
./symfony opp-build-cache-politici --ramo=parlamento
./symfony opp-build-cache-gruppi
./symfony opp-build-cache-rami
./symfony opp-rebuild-deltas

