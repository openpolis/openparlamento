select opp_politico.cognome, opp_politico.nome, opp_gruppo.nome, opp_carica.circoscrizione, opp_votazione_has_carica.voto 
FROM opp_votazione_has_carica 
INNER JOIN opp_carica_has_gruppo ON opp_carica_has_gruppo.carica_id=opp_votazione_has_carica.carica_id 
INNER JOIN opp_gruppo ON opp_gruppo.id=opp_carica_has_gruppo.gruppo_id 
INNER JOIN opp_carica ON opp_carica.id=opp_votazione_has_carica.carica_id 
INNER JOIN opp_politico ON opp_politico.id=opp_carica.politico_id 
WHERE opp_votazione_has_carica.votazione_id='18725' AND opp_carica_has_gruppo.data_inizio<='2008-06-05' 
AND (opp_carica_has_gruppo.data_fine>='2008-06-05' OR opp_carica_has_gruppo.data_fine IS NULL) 
ORDER BY opp_politico.cognome ASC;