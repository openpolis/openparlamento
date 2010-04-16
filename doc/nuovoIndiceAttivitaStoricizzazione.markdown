Nuovo indice di attività e storicizzazione dei dati
===================================================

Nuovo indice di attività
------------------------

Il task `opp-calcola-indice` viene lanciato ogni giorno e accetta come opzioni:

  - `--ramo`: il ramo per cui fare il calcolo (camera, senato) - opzionale, se non passato sono presi tutti e due
  - `--settimana`: la settimana in cui calcolare l'indice (`data_inizio` + 7 giorni), opzionale, se non passato vale da inizio legislatura a oggi

L'algoritmo è il seguente:

  - sono definiti (come costanti in `OppLegislaturaHasGruppoPeer`) i gruppi di maggioranza e opposizione, per legislatura
  - sono estratti tutti i parlamentari (del ramo o dell'intero parlamento)
  - per ciascun parlamentare
    - si calcola se appartiene alla maggioranza o all'opposizione
    - si estraggono tutti gli atti di cui è primo firmatario in quel periodo
    - per ciascun tipo di atto
      - in base al tipo di atto, vengono assegnati i punti di presentazione (che dipendono se è maggioranza o opposizione)
      - si calcola il numero di firme dello stesso gruppo, di altri gruppi (stesso schieramento), di altri gruppi (schieramenti opposti), in quel periodo
      - in base al numero di firme, sono assegnati punteggi che variano se deputato è di maggioranza o opposizione
      - si calcola il tipo di avanzamentom in quel periodo, per l'atto in questione; questo si fa mappando gli id di `opp_iter` nei valori della tabella dell'indice
      - vengono assegnati i punteggi, che variano se maggioranza o opposizione
    - si calcola il numero di sedute in cui il parlamentare è intervenuto, nel periodo; da `opp_intervento`; con distinct su `sede_id` e data
    - l'indice è la somma complessiva e viene memorizzata 
      - nel campo indice in `opp_carica`, se non è stato passato il periodo
      - nel campo indice in `opp_politician_history_cache`, se è stato passato il periodo
  - vengono calcolate le posizioni (per ramo) e aggiornati i valori del campo posizione
 

Storicizzazione
---------------
Per fornire alcuni dati storicizzati su presenze, assenze, indice di attività, votazioni, ribellioni, di interesse per l'Espresso (e altri), occorre aggiungere delle tabelle che funzionino da cache e dei task per il calcolo di questi dati nel tempo.

Struttura tabella di cache per dati politico
--------------------------------------------
    opp_politician_history_cache:
      legislatura: integer
      anno:        integer
      settimana:   integer
      data:        date (la data di inizio della settimana, nel formato Y-m-d)
      assenze:     integer
      presenze:    integer
      missioni:    integer
      indice:      float
      ribellioni:  integer
      votazioni:   integer
      chi_tipo:    varchar(1) Tutti | Gruppo | Politico
      chi_id:      integer
      ramo:        varchar(1) Tutti | Camera | Senato
      numero:      integer
    
Le tabelle hanno tre sezioni:

- periodo (legislatura, anno, mese, settimana)
- contenuto (assenze, presenze, missioni, indice, ribellioni, votazioni)
- contesto (`chi_tipo`, `chi_id`, ramo, numero)

Per popolare la tabelle, ogni settimana viene lanciato un cronjob, che preleva i dati da `opp_carica` e `opp_carica_has_gruppo`, dove i dati sono già immagazzinati e li riporta nella cache. Vedere sezione **Aggiornamento tabella di cache dati politico**.

All'inizio, la tabella va popolata con la ricostruzione dei dati, che può essere ottenuta passando dei parametri temporali ai task del gruppo ComputationTasks (plugin deppOppTasks). Vedere sezione **Setup tabella di cache dati politico**.

Dato che i dati immagazzinati sono totali (presenze fino ad ora, va fatta la differenza con il dato precedente, per avere il delta incrementale, che serve per i grafici).

Ogni record di `opp_history_politician_cache` contiene i valori per una settimana.

I record raggruppati, per gruppo, per ramo, sono ottenuti da somme di valori già scritti, senza ulteriori estrazioni.
Esiste un record con le somme generali (tutto il parlamento), ma non sono presenti valori riassuntivi per i gruppi, se non per ciascun ramo. (Ad. Es. gruppo PD alla Camera e Gruppo PD al Senato, ma NON gruppo PD in Parlamento).

Per gli argomenti, il ragionamento è analogo, ma prevede alcune modifiche. Vedere sezione **Tabella di cache dati argomenti**.

Setup tabella di cache dati politico
------------------------------------
Le tabelle di cache all'inizio devono contenere i dati storicizzati. Per fare questo è necessario:

- per ogni settimana della legislatura
  - costruire i record dei politici vuoti di contenuti
  - costruire i record aggregati (gruppi, ramo, totale) vuoti di contenuti
  - lanciare i task di ricostruzione dei contenuti per la settimana
    - `opp-calcola-indice --settimana=YYYYMMDD`
    - `opp-calcola-presenze --settimana=YYYYMMDD`
    - `opp-calcola-ribellioni --settimana=YYYYMMDD`
      
Aggiornamento tabella di cache dati politico
--------------------------------------------
Ogni settimana viene lanciato il task `opp-aggiorna-cache-politici` che preleva i contenuti dalle tabelle `opp_carica` e `opp_carica_has_gruppo` e li immagazzina in `opp_politician_history_tag`.



Tabella di cache dati argomenti
-------------------------------
Esiste una tabella di cache per gli storici degli argomenti: `opp_tag_history_cache`, che contiene gli stessi campi per il periodo e campi diversi per le sezioni di contenuto e contesto.

    opp_tag_history_cache:
      legislatura: 16  (tutta la legislatura n. 16)
      anno:        integer 2010 (tutto l'anno 2010)
      mese:        integer 4 (tutto aprile 2010)
      settimana:   integer 15 (la quindicesima settimana dell'anno)
      indice:      float
      tag_tipo:    varchar(1) Tutti | Tag
      tag_id:      integer
      numero:      integer

Qui, la rilevanza del tag deve essere inserita quotidianamente in una tabella `opp_tag_relevancy`, che contiene anche la posizione relativa di tutti i tag. La tabella è esterna alla tabella Tag, per non toccare il plugin ed è aggiornata attraverso un task quotidiano: `opp-calcola-rilevanza-tag`, che accetta il parametro **periodo**.

Questa la struttura della tabella `opp_tag_relevancy`

    opp_tag_relevancy:
      tag_id:      integer
      indice:      float
      posizione:   integer
      
I valori dell'indice in questa tabella sono sempre aggiornati alla data corrente e riguardano tutta la legislatura (come `opp_carica` per i politici). Possono essere usati per mostrare i tag in ordine di rilevanza nelle pagine di openparlamento.

Anche nel caso degli argomenti, c'è bisogno di una fase di setup e di un aggiornamento settimanale.

L'algoritmo che calcola la rilevanza dei task è da definire, ma è simile al calcolo dell'indice di attività.
Il task da lanciare quotidianamente è `opp-calcola-rilevanza-tag`, che calcola la rilevanza, ad oggi.

Per il setup, il task viene lanciato con l'argomento `--periodo` e l'algoritmo è identico a quello descritto in **Setup tabella di cache dati politico**.

L'aggiornamento avviene attraverso `opp-aggiorna-cache-tag`, che preleva i contenuti da `opp_tag_relevancy`, aggiungendo record alla `opp_tag_history_cache`.

