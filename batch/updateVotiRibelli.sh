#!/bin/sh

# aggiorna il campo ribelle in opp_votazione, per le votazioni della 16. legislatura del 2009

n=`mysql -uroot openparlamento -e"select count(v.id) from opp_votazione v, opp_seduta s where v.seduta_id=s.id and s.legislatura=16 and v.ribelli>0 and s.ramo='C' and s.data >= '2009-01-01';"`;
n=`echo $n | awk '{print $2}'`

i=0
for id in `mysql -uroot openparlamento -e "select v.id from opp_votazione v, opp_seduta s where v.seduta_id=s.id and s.legislatura=16 and v.ribelli>0 and s.ramo='C' and s.data >= '2009-01-01' order by s.data;"`; 
  do 
    if [[ $id != 'id' ]]; then
      let i++; 
      echo "$id ($i/$n)"; 
      php batch/updateVotiRibelliVotazione.php $id
    fi;
  done
  


n=`mysql -uroot openparlamento -e"select count(v.id) as c from opp_votazione v, opp_seduta s where v.seduta_id=s.id and s.legislatura=16 and v.ribelli>0 and s.ramo='S' and s.data >= '2009-01-01';"`;
n=`echo $n | awk '{print $2}'`

i=0
for id in `mysql -uroot openparlamento -e "select v.id from opp_votazione v, opp_seduta s where v.seduta_id=s.id and s.legislatura=16 and v.ribelli>0 and s.ramo='S' and s.data >= '2009-01-01' order by s.data;"`; 
  do 
    if [[ $id != 'id' ]]; then 
      let i++; 
      echo "$id ($i/$n)"; 
      php batch/updateVotiRibelliVotazione.php $id
    fi;
  done