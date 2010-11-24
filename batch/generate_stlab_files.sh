#!/bin/sh

#generazione tags e tags per atto(csv)
./symfony stlab-genera-tags-csv
./symfony stlab-genera-atti-tags-csv


# generazione testi (zip)
./symfony stlab-genera-testi-atti --limit=10000
./symfony stlab-genera-testi-atti --limit=10000 --offset=10001
./symfony stlab-genera-testi-atti --limit=10000 --offset=20001
./symfony stlab-genera-testi-atti --limit=10000 --offset=30001
