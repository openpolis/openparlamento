create table prio (chi_id integer);

insert into prio (chi_id) 
  select chi_id from opp_act_history_cache where priorita=2;

update opp_act_history_cache set priorita=2
  where chi_id in (select chi_id from prio);
  
drop table prio;



create table prio (chi_id integer);

insert into prio (chi_id) 
  select chi_id from opp_act_history_cache where priorita=3;

update opp_act_history_cache set priorita=3
  where chi_id in (select chi_id from prio);
  
drop table prio;