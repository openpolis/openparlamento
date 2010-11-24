#!/bin/sh

#generazione tags e tags per atto(csv)
./symfony stlab-genera-tags-csv
./symfony stlab-genera-atti-tags-csv


# generazione testi (zip)
for i in 0 10001 20001 30001 40001; 
do
  ./symfony stlab-genera-testi-atti --limit=10000 --offset=$i
done
