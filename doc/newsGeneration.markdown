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
 
### Raggruppamenti
Per le votazioni e gli interventi, la notizia è se ce ne sia stato almeno uno. 
 * Votazioni: 
   * è una notizia con priorità 1 se si è votato, in un certo giorno, in una sede (camera o senato)
     questa notizia con priorità 1 non deve apparire nella foglia (è un'eccezione?)
   * è una notizia con priorità 2 se si è votato, in un certo giorno, in una sede, su atti di un certo tipo
   * è una notizia legata a un atto, con priorità 3, ogni votazione, in quel giorno, su quell'atto (non importa di quanti politici) 
   * è una notizia legata a un politico, con priorità 3, se il politico, in quel giorno, ha votato (non importa quanti atti)
 * Interventi:
   * è una notizia con priorità 1 se c'è stato un intervento, in un certo giorno, in una sede
   * è una notizia con priorità 2 se c'è stato un intervento, in un certo giorno, in una sede, su atti di un certo tipo 
   * è notizia legata a un atto, con priorità 3, se ci sono stati, in quel giorno, interventi su quell'atto
   * è notizia legata a un politico, con priorità 3, se è intervenuto almeno una volta in quel giorno

Nelle pagine degli elenchi ddl o altri atti, vanno incluse le notizie con priorità <= 2, ma, per le votazioni, 
solo quelle con priorità 2. Quindi:
`
 (GeneratorModel != 'OppVotazioneHasAtto' AND Priority <= 2) OR 
 (GeneratorModel == 'OppVotazioneHasAtto' AND Priority == 2)
`
   
Per cachare questo tipo di notizie, è inutile inserire tutti i record generati da OppAttoHasVotazione o OppIntervento.
Basta inserire un solo record, che marca la notizia e che deve essere controllata in seguito. E' un pò più lunga e onerosa
la generazione della notizia, ma il numero di record in sf_news_cache è ridotto al minimo.

Si può modificare la generateNews(), aggiungendo un override in OppVotazioneHasAtto e OppIntervento, 
così come è stato fatto per le votazioni finali e gli iter conclusivi. (nel metodo save, perché la generateNews non si 
può overridare).

In questo modo il plugin non viene toccato dalle eccezioni, che era il criterio per cui è stato implementato
l'override del metodo save.

Quindi parto da OppVotazioneHasAtto.

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
