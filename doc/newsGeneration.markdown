Meccanismo di generazione delle notizie
=======================================

`
Oggetto         Home  ListDDL  SingleDDL  ListAct  SingleAct  ListPol  SinglePol  SingleTag  RefDate     Prior
Pres.DDL        si	  si       no         no       no         no       no         si         effDate     1
Pres.Atto       si    no       no         si       no         no       no         si         effDate     1
Votazione       grp	  grp      si         grp      si         no       live       grp        effDate     3
VotazioneFin    si    si       si         si       si         no       live       si         effDate     1
Pr-Firm         no    dateSuc  dateSuc    dateSuc  dateSuc    no       si         no         effDate     2
Co-Firm         no    dateSuc  dateSuc    dateSuc  dateSuc    no       si         no         effDate     2
Relatore        no    si       si         no       no         no       si         no         created_at	 2
CambioIterDDL   no    si       si         no       no         no       no         si         effDate     2
CambioIterAtto  no    no       no         si       si         no       no         si         effDate     2
CambioIterConcl si    si       si         si       si         no       no         si         effDate     1
NuovoDocumento  no    si       si         no       no         no       no         si         created_at  2
AssCommissione  no    si       si         si       si         no       no         si         created_at  2
Intervento      no    grp      si         grp      si         no       si         grp        effDate     3
Carica          si                                            si       si         no                     1
CambioGruppo    si                                            si       si         no                     1
`

 * **effDate**: la data effettiva in cui l'avvenimento è accaduto (campo *date* della *sf_news_cache*)
 * **grp**: la notizia è che *almeno un evento* si è verificato in quel giorno.
Per le **votazioni**, nella home, negli elenchi di atti, e nel singolo tag (gruppo) la notizia indica se ci sono state 
votazioni quel giorno. Per il singolo politico, è interessante il dato aggregato sulla partecipazione del politico 
all’insieme di votazioni che si sono svolte in un dato giorno (a quante è stato presente, assente, in missione).
Per gli **Interventi**, la notizia indica se ci sono stati interventi in quel giorno.
 * **live**: non c'è modo di cachare questo evento in ogni votazione tutti i politici votano, 
 dato che la notizia è mostrata solo nella foglia del politico, è calcolata *al momento*
 * **dateSuc**: la notizia è cachata se la *data di firma di un atto è successiva a quella di presentazione*,
 ossia, è una notizia il fatto che sia avvenuto dopo, non che sia avvenuta.
 

Note sui meccanismi di caching
------------------------------
Il tipo di atto deve essere nella *sf_news_cache*, perché bisogna sempre filtrare tra ddl e altri atti. 
Il nome del campo è *tipo_atto*.

Per velocizzare il filtro dei primi firmatari con data successiva a data di presentazione, 
si deve aggiungere un campo *data_pres_atto* alla news_cache.

Per la data delle votazioni, va fatto un *chain*, come per i monitorable_models 
(date_method => array(‘getOppVotazione’, ‘getOppSeduta’, ‘getData’)

Vanno aggiunti i campi created at a tutti i generatori di notizie. 
In questo modo, anche ri-generando la tabella *sf_news_cache*, la data di creazione di una notizia non va perduta. 
Va da se che il campo created at della tabella *sf_news_cache*, va riempito con il valore di created at 
del generatore (se non nullo).

Il meccanismo delle **priorità** identifica, a meno di eccezioni, le notizie da Home Page (p. 1), 
quelle da Elenco (p. 2) e quelle da foglia (p. 3). Le eccezioni sono:

 * raggruppamenti: per le votazioni e gli interventi, è considerata una notizia interessante quando almeno una votazione 
 o un intervento sono accaduti, non ogni votazione o intervento (che sarebbe un overflow di informazioni).
 * live: nelle foglie, le notizie live vanno aggiunte a quelle cached, (merge)

Note sull’estrazione delle notizie
----------------------------------
Nei box, sono estratte al massimo 5 o 10 notizie, l’ordinamento è per data, c’è un link che conduce all'elenco completo.

La pagina Tutte le notizie è differente, a seconda di dove si parte (home, liste, foglia ...). 

In ogni caso, le notizie sono raggruppate per giorno, con gli ultimi giorni in testa. Le notizie sono visibili
(i raggruppamenti sono aperti e non c'è bisogno di click per vederle).

Se un utente è loggato, allora le notizie che hanno data di creazione successiva alla sua data di ultimo login 
sono evidenziate (neretto).

La paginazione, in questo caso avviene per settimane.

Questo raggruppamento per giorno è adottato anche nel monitoraggio (da studiare).
