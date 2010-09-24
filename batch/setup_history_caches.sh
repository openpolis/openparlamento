#!/bin/sh

# togli il commento per generare anche i dati correnti
# ./symfony opp-build-cache-politici --ramo=parlamento;
# ./symfony opp-build-cache-gruppi;
# ./symfony opp-build-cache-rami;
# ./symfony opp-build-cache-atti
# ./symfony opp-build-cache-tag

# dati storici
for data in '2010-08-31' '2010-07-31' '2010-06-30' '2010-05-31' '2010-04-30' '2010-03-31' '2010-02-28' '2010-01-31' '2009-12-31' '2009-11-30' '2009-10-31' '2009-09-30' '2009-08-31' '2009-07-31' '2009-06-30' '2009-05-31' '2009-04-30' '2009-03-31' '2009-02-28' '2009-01-31' '2008-12-31' '2008-11-30' '2008-10-31' '2008-09-30' '2008-08-31' '2008-07-31' '2008-06-30' '2008-05-31' '2008-04-30'; 
do 
  ./symfony opp-build-cache-politici --ramo=parlamento --data=$data; 
  ./symfony opp-build-cache-gruppi --data=$data;
  ./symfony opp-build-cache-rami --data=$data;  
  ./symfony opp-build-cache-atti --data=$data
  ./symfony opp-build-cache-tag --data=$data
done

# riempimento informazioni delta

# togli il commento per generare anche i dati correnti
# ./symfony opp-compute-delta-politici
# ./symfony opp-compute-delta-atti
# ./symfony opp-compute-delta-tag

# dati storici
for data in '2010-08-31' '2010-07-31' '2010-06-30' '2010-05-31' '2010-04-30' '2010-03-31' '2010-02-28' '2010-01-31' '2009-12-31' '2009-11-30' '2009-10-31' '2009-09-30' '2009-08-31' '2009-07-31' '2009-06-30' '2009-05-31' '2009-04-30' '2009-03-31' '2009-02-28' '2009-01-31' '2008-12-31' '2008-11-30' '2008-10-31' '2008-09-30' '2008-08-31' '2008-07-31' '2008-06-30'; 
do 
  ./symfony opp-compute-delta-politici --data=$data
  ./symfony opp-compute-delta-atti --data=$data
  ./symfony opp-compute-delta-tag --data=$data
done
