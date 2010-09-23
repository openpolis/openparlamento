#!/bin/sh

./symfony opp-build-cache-politici --ramo=parlamento;
./symfony opp-build-cache-gruppi;
./symfony opp-build-cache-rami;
for data in '2020-08-31 2010-07-31 2010-06-30 2010-05-31 2010-04-30' '2010-03-31' '2010-02-28' '2010-01-31' '2009-12-31' '2009-11-30' '2009-10-31' '2009-09-30' '2009-08-31' '2009-07-31' '2009-06-30' '2009-05-31' '2009-04-30' '2009-03-31' '2009-02-28' '2009-01-31' '2008-12-31' '2008-11-30' '2008-10-31' '2008-09-30' '2008-08-31' '2008-07-31' '2008-06-30' '2008-05-31' '2008-04-30'; 
do 
  ./symfony opp-build-cache-politici --ramo=parlamento --data=$data; 
  ./symfony opp-build-cache-gruppi --data=$data;
  ./symfony opp-build-cache-rami --data=$data;  
  ./symfony opp-calcola-rilevanza-atti --data=$data
  ./symfony opp-calcola-rilevanza-tag --data=$data
done

# riempimento informazioni delta
./symfony opp-rebuild-deltas
for data in '2020-08-31 2010-07-31 2010-06-30 2010-05-31 2010-04-30' '2010-03-31' '2010-02-28' '2010-01-31' '2009-12-31' '2009-11-30' '2009-10-31' '2009-09-30' '2009-08-31' '2009-07-31' '2009-06-30' '2009-05-31' '2009-04-30' '2009-03-31' '2009-02-28' '2009-01-31' '2008-12-31' '2008-11-30' '2008-10-31' '2008-09-30' '2008-08-31' '2008-07-31' '2008-06-30'; 
do 
  ./symfony opp-rebuild-deltas --data=$data
done
