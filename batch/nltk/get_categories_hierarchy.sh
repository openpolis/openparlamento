#!/bin/sh

for tt_id in $(mysql -uroot op_openparlamento -e"select tt.id from opp_teseott tt;" | sed '1d')
do 
  echo $(mysql -uroot op_openparlamento -e"select concat('top_tag,', $tt_id, ',', denominazione) from opp_teseott where id=$tt_id" | sed "1d") 
  for t_id in $(mysql -uroot op_openparlamento -e"select t.id from sf_tag t, opp_tag_has_tt thtt where thtt.tag_id=t.id and thtt.teseott_id=$tt_id;" | sed "1d");
  do
#  echo "  $t_id";
  echo $(mysql -uroot op_openparlamento -e"select concat($tt_id, ',', t.id, ',', t.triple_value, ',', t.triple_namespace) from sf_tag t where t.id = $t_id ;" | sed "1d"); 
  done;
done; 

