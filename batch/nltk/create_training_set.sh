#!/bin/sh


mkdir -p data/nltk/interrogazioni/training


APP=interrogazioni
FILES_PATH=data/nltk/$APP
YEAR=2011
N_ATTI=2000

rm  $FILES_PATH/training/categorie.csv
rm $FILES_PATH/training/testi.zip
touch $FILES_PATH/training/categorie.csv
 
for y in $(expr $YEAR - 3) $(expr $YEAR - 2) $(expr $YEAR - 1) 
 do
  echo "-$y"
  ny=$(expr $y + 1)
  count=0
  for id_atto in $(mysql -uroot op_openparlamento -e"select id from opp_atto where tipo_atto_id in (3, 4, 5, 6) and data_pres >='$y-01-01' and data_pres < '$ny-01-01' order by data_pres limit $N_ATTI;" | sed "1d");
    do  
    count=$(expr $count + 1)
    echo "--$count/$N_ATTI ($id_atto)"
    ./symfony nltk-genera-categorie --prefix=trained_set $id_atto >> $FILES_PATH/training/categorie.csv
    ./symfony nltk-genera-files --path=$FILES_PATH/training/testi $id_atto > /dev/null 2>&1
    done
 done

