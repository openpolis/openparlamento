#!/bin/sh


mkdir -p data/nltk/interrogazioni/test


APP=interrogazioni
FILES_PATH=data/nltk/$APP
YEAR=2011
N_ATTI=2000

rm $FILES_PATH/test/testi.zip
 
echo test
echo "-$YEAR"
count=0
for id_atto in $(mysql -uroot op_openparlamento -e"select id from opp_atto where tipo_atto_id in (3, 4, 5, 6) and data_pres >='$YEAR-01-01' order by data_pres limit $N_ATTI;" | sed "1d");
 do
   count=$(expr $count + 1)
   echo "--$count/$N_ATTI ($id_atto)"
   # ./symfony nltk-genera-categorie --prefix=trained $id_atto >> $FILES_PATH/categorie.csv
  ./symfony nltk-genera-files --path=$FILES_PATH/test/testi $id_atto > /dev/null 2>&1
 done

