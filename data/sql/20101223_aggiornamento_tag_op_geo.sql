update sf_tag set triple_namespace = 'op_geo'  where triple_key > 0 and triple_namespace = 'geoteseo';
update sf_tag set triple_namespace = 'op_geo'  where triple_key > 0 and triple_namespace = 'op';
update sf_tag set triple_key = 'tag'  where triple_namespace = 'geoteseo';
  