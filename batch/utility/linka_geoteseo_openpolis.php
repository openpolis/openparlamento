<?php
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'fe');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       true);
 
require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
sfContext::getInstance();



$testo="<?php


function id_del_tag ($teseo_appoggio)
{
$id_del_tag='-1';
    switch (strtolower($teseo_appoggio)) {
    // tag da non importare
    	case 'crisi politica' : 
	$id_del_tag='0'; 
	break; 
	case 'documento' : 
	$id_del_tag='0'; 
	break; 
	case 'sale chimico' : 
	$id_del_tag='0'; 
	break; 
	case 'centralizzazione delle informazioni' : 
	$id_del_tag='0'; 
	break; 
	case 'scuola europea' : 
	$id_del_tag='0'; 
	break; 
	case 'motivazione politica' : 
	$id_del_tag='0'; 
	break; 
	case 'incidente chimico' : 
	$id_del_tag='0'; 
	break; 
	
	case *diritto nazionale*:
	$id_del_tag='103';
	break;
	case *sanzione internazionale*:
	$id_del_tag='285';
	break;
	case *frode*:
	$id_del_tag='383';
	break;
	case *stato federato*:
	$id_del_tag='550';
	break;
	case *segreto professionale*:
	$id_del_tag='554';
	break;
	case *spesa per interessi sul debito pubblico*:
	$id_del_tag='577';
	break;
	case *tecnologia obsoleta*:
	$id_del_tag='653';
	break;
	case *consiglio d'amministrazione*:
	$id_del_tag='675';
	break;
	case *impianti e mezzi industriali*:
	$id_del_tag='708';
	break;
	case *vinificazione*:
	$id_del_tag='718';
	break;
	case *banche dati*:
	$id_del_tag='752';
	break;
	case *trasporto di merci pericolose*:
	$id_del_tag='774';
	break;
	case *sicurezza degli impianti nucleari*:
	$id_del_tag='845';
	break;
	case *insegnanti non di ruolo*:
	$id_del_tag='911';
	break;
	case *salario sociale*:
	$id_del_tag='1021';
	break;
	case *integratore alimentare*:
	$id_del_tag='1083';
	break;
	case *malattie rare*:
	$id_del_tag='1118';
	break;
	case *coltura foraggera*:
	$id_del_tag='1266';
	break;
	case *sigarette*:
	$id_del_tag='1273';
	break;
	case *tabacco*:
	$id_del_tag='1273';
	break;
	case *prodotti da fumo*:
	$id_del_tag='1273';
	break;
	case *politica dei visti*:
	$id_del_tag='1314';
	break;
	case *polizia ferroviaria*:
	$id_del_tag='1325';
	break;
	case *consiglio dei comuni e delle regioni d'europa*:
	$id_del_tag='1422';
	break;
	case *enti territoriali*:
	$id_del_tag='1422';
	break;
	case *mercato dei servizi*:
	$id_del_tag='1535';
	break;
	case *contratto di prestazione di servizi*:
	$id_del_tag='1535';
	break;
	case *rappresentante di commercio*:
	$id_del_tag='1535';
	break;
	case *protezione del consumatore*:
	$id_del_tag='1542';
	break;
	case *licenza d'esportazione*:
	$id_del_tag='1557';
	break;
	case *fabbriche e opifici*:
	$id_del_tag='1578';
	break;
	case *ammissione di stranieri*:
	$id_del_tag='1613';
	break;
	case *democrazia diretta*:
	$id_del_tag='1615';
	break;
	case *xenofobia*:
	$id_del_tag='1627';
	break;
	case *protezione dell'ambiente*:
	$id_del_tag='1629';
	break;
	case *prodotto animale*:
	$id_del_tag='1649';
	break;
	case *fiume brenta*:
	$id_del_tag='1662';
	break;
	case *operatore sociale*:
	$id_del_tag='1685';
	break;
	case *disabile*:
	$id_del_tag='1716';
	break;
	case *diversamente abili*:
	$id_del_tag='1716';
	break;
	case *alberghi*:
	$id_del_tag='1868';
	break;
	case *pensioni ostelli*:
	$id_del_tag='1868';
	break;
	case *regione mediterranea ce*:
	$id_del_tag='2250';
	break;
	case *bassa sassonia*:
	$id_del_tag='2275';
	break;
	case *baviera*:
	$id_del_tag='2275';
	break;
	case *incidente di trasporto*:
	$id_del_tag='4375';
	break;
	case *cittadino straniero*:
	$id_del_tag='4474';
	break;
	case *prodotto interno lordo*:
	$id_del_tag='4657';
	break;
	case *aiuti pubblici*:
	$id_del_tag='4690';
	break;
	case *metropolitana*:
	$id_del_tag='5568';
	break;
	case *linee metropolitane*:
	$id_del_tag='5568';
	break;
	case *lega italiana protezione uccelli ( lipu )*:
	$id_del_tag='5606';
	break;
	case *cittadino della comunita'*:
	$id_del_tag='5688';
	break;
	case *decremento demografico*:
	$id_del_tag='5870';
	break;
	case *consolato*:
	$id_del_tag='6812';
	break;
	case *ambasciata*:
	$id_del_tag='6812';
	break;
	case *insegnamento della guida*:
	$id_del_tag='7726';
	break;
	case *istituto nazionale di geofisica e vulcanologia ( ingv )*:
	$id_del_tag='7775';
	break;
	case *enciclopedia*:
	$id_del_tag='8184';
	break;
	case *identita' culturale*:
	$id_del_tag='8184';
	break;
	case *germania*:
	$id_del_tag='2275';
	break;
	case *ministero della pubblica istruzione*:
	$id_del_tag='8163';
	break;
	case *vaticano*:
	$id_del_tag='8182';
	break;
	case *cartolarizzazione*:
	$id_del_tag='8088';
	break;
	case *lega per l' ambiente ( legambiente )*:
	$id_del_tag='8131';
	break;
	case *ordine del giorno*:
	$id_del_tag='8183';
	break;
	case *lega araba*:
	$id_del_tag='8166';
	break;
	case *wwf sezione italiana del fondo mondiale per la natura*:
	$id_del_tag='8129';
	break;
	
	
	case 'ventotene' : 
	$id_del_tag='8074'; 
	break; 
	case 'permesso di soggiorno' : 
	$id_del_tag='1314'; 
	break; 
	case 'trento - prov' : 
	$id_del_tag='5725'; 
	break; 
	case 'centrale nucleare' : 
	$id_del_tag='845'; 
	break; 
	case *sostanza di origine animale*:
	$id_del_tag='0';
	break;
	case *div.abili*:
	$id_del_tag='0';
	break;
	case *supporto d'informazione*:
	$id_del_tag='0';
	break;
	case *attivita' ricreative*:
	$id_del_tag='0';
	break;
	case *prezzo d'offerta*:
	$id_del_tag='0';
	break;
	case *disegno e modello*:
	$id_del_tag='0';
	break;
	case *caricamento*:
	$id_del_tag='0';
	break;
	case *delitto contro la persona*:
	$id_del_tag='0';
	break;
	case *attrezzatura elettronica*:
	$id_del_tag='0';
	break;
	case *contratti e opere pubbliche*:
	$id_del_tag='0';
	break;
	case *servizio di assistenza al cliente*:
	$id_del_tag='0';
	break;
	case *catalogazione*:
	$id_del_tag='0';
	break;
	case *mandato*:
	$id_del_tag='0';
	break;
	case *pagamento anticipato*:
	$id_del_tag='0';
	break;
	case *pagamento*:
	$id_del_tag='0';
	break;
	case *dl 1997 0469*:
	$id_del_tag='0';
	break;
	case *dpr 2002 0115*:
	$id_del_tag='0';
	break;
	case *benefici combattentistici*:
	$id_del_tag='0';
	break;
	case *controllo della produzione*:
	$id_del_tag='0';
	break;
	case *controllo sanitario*:
	$id_del_tag='4567';
	break;
	case *malattie renali*:
	$id_del_tag='1118';
	break;
	case *malattia renale*:
	$id_del_tag='1118';
	break;
	case *malattia cronica*:
	$id_del_tag='1118';
	break;
	case *malattie croniche*:
	$id_del_tag='1118';
	break;
	case *principio di reciproco riconoscimento*:
	$id_del_tag='0';
	break;
	case *dl 2006 0219*:
	$id_del_tag='0';
	break;
	case *costo sociale*:
	$id_del_tag='0';
	break;
	case *candidato*:
	$id_del_tag='0';
	break;
	case *dichiarazione ambientale*:
	$id_del_tag='0';
	break;
	case *diversificazione della produzione*:
	$id_del_tag='0';
	break;
	case *sfruttamento delle risorse*:
	$id_del_tag='0';
	break;
	case *statistica occupazionale*:
	$id_del_tag='0';
	break;
	case *apparecchi di sollevamento*:
	$id_del_tag='0';
	break;
	case *restrizione di liberta'*:
	$id_del_tag='0';
	break;
	case *dpr 1985 0461*:
	$id_del_tag='0';
	break;
	case *durata della locazione*:
	$id_del_tag='0';
	break;
	case *consenso*:
	$id_del_tag='0';
	break;
	case *comunicazione dei dati*:
	$id_del_tag='0';
	break;
	case *scambio extracomunitario*:
	$id_del_tag='0';
	break;
	case *indennita' di alloggio*:
	$id_del_tag='0';
	break;
	case *sottotenenti e guardiamarina*:
	$id_del_tag='0';
	break;
	case *diffusione della cultura*:
	$id_del_tag='0';
	break;
	case *impianto portuale*:
	$id_del_tag='0';
	break;
	case *girasole*:
	$id_del_tag='0';
	break;
	case *progetto industriale*:
	$id_del_tag='0';
	break;
	case *saggio dei metalli*:
	$id_del_tag='0';
	break;
	case *sistema normalizzato di contabilita'*:
	$id_del_tag='0';
	break;
	case *attivita' finanziarie*:
	$id_del_tag='0';
	break;
	case *gestione finanziaria*:
	$id_del_tag='0';
	break;
	case *restrizione quantitativa*:
	$id_del_tag='0';
	break;
	case *dl 1993 0093*:
	$id_del_tag='0';
	break;
	case *attrezzatura sociale*:
	$id_del_tag='0';
	break;
	case *conservazione del posto di lavoro*:
	$id_del_tag='0';
	break;
	case *prodotto nuovo*:
	$id_del_tag='0';
	break;
	case *indipendenza economica*:
	$id_del_tag='0';
	break;
	case *fornitura di documenti*:
	$id_del_tag='0';
	break;
	case *quotazione in borsa*:
	$id_del_tag='0';
	break;
	case *ueb*:
	$id_del_tag='0';
	break;
	case *frecciarossa tav*:
	$id_del_tag='0';
	break;
	case *dl 2005 0151*:
	$id_del_tag='0';
	break;
	case *cittadina*:
	$id_del_tag='0';
	break;
	case *ipersfruttamento delle risorse*:
	$id_del_tag='0';
	break;
	case *territorio non autonomo*:
	$id_del_tag='0';
	break;
	case *dl 2004 0042*:
	$id_del_tag='0';
	break;
	case *commissione ad hoc*:
	$id_del_tag='0';
	break;
	case *controllo metrologico*:
	$id_del_tag='0';
	break;
	case *dl 1994 0509*:
	$id_del_tag='0';
	break;
	case *fabbisogno idrico*:
	$id_del_tag='0';
	break;
	case *dichiarazione pubblica*:
	$id_del_tag='0';
	break;
	case *materiale audiovisivo*:
	$id_del_tag='0';
	break;
	case *garante*:
	$id_del_tag='0';
	break;
	case *controversie agrarie*:
	$id_del_tag='0';
	break;
	case *assegni ed elargizioni speciali*:
	$id_del_tag='0';
	break;
	case *consegna*:
	$id_del_tag='0';
	break;
	case *dl 2003 0259*:
	$id_del_tag='0';
	break;
	case *riposo*:
	$id_del_tag='0';
	break;
	case *regolamento d'applicazione*:
	$id_del_tag='0';
	break;
	case *firme e sottoscrizioni*:
	$id_del_tag='0';
	break;
	case *raccolta dei dati*:
	$id_del_tag='0';
	break;
	case *norma di qualita'*:
	$id_del_tag='0';
	break;
	case *zona sensibile*:
	$id_del_tag='0';
	break;
	case *condizioni di lavoro*:
	$id_del_tag='0';
	break;
	case *primato del diritto*:
	$id_del_tag='0';
	break;
	case *dl 2000 0267*:
	$id_del_tag='0';
	break;
	case *esame*:
	$id_del_tag='0';
	break;
	case *ribasso dei prezzi*:
	$id_del_tag='0';
	break;
	case *coniglio*:
	$id_del_tag='0';
	break;
	case *norma internazionale*:
	$id_del_tag='0';
	break;
	case *dl 1992 0502*:
	$id_del_tag='0';
	break;
	case *tendenza a delinquere*:
	$id_del_tag='0';
	break;
	case *autorizzazione di vendita*:
	$id_del_tag='0';
	break;
	case *decreto legge 2006 0262*:
	$id_del_tag='0';
	break;
	case *aiuto di stato*:
	$id_del_tag='0';
	break;
	case *regione periferica*:
	$id_del_tag='0';
	break;
	case *riunione internazionale*:
	$id_del_tag='0';
	break;
	case *comando di personale*:
	$id_del_tag='0';
	break;
	case *dpr 1963 1409*:
	$id_del_tag='0';
	break;
	case *idraulica agraria*:
	$id_del_tag='0';
	break;
	case *vita politica*:
	$id_del_tag='0';
	break;
	case *responsabilita' ministeriale*:
	$id_del_tag='0';
	break;
	case *diagnostica medica*:
	$id_del_tag='0';
	break;
	case *veicolo su rotaie*:
	$id_del_tag='0';
	break;
	case *rendiconti*:
	$id_del_tag='0';
	break;
	case *caposquadra*:
	$id_del_tag='0';
	break;
	case *norma di lavoro*:
	$id_del_tag='0';
	break;
	case *vita sociale*:
	$id_del_tag='0';
	break;
	case *documento ufficiale*:
	$id_del_tag='0';
	break;
	case *importo compensativo monetario*:
	$id_del_tag='0';
	break;
	case *trasferimento tecnologico*:
	$id_del_tag='0';
	break;
	case *disponibilita' monetarie*:
	$id_del_tag='0';
	break;
	case *scoperta scientifica*:
	$id_del_tag='0';
	break;
	case *dispositivo di sicurezza*:
	$id_del_tag='0';
	break;
	case *tecnica spaziale*:
	$id_del_tag='0';
	break;
	case *edificio*:
	$id_del_tag='0';
	break;
	case *prestazione ai superstiti*:
	$id_del_tag='0';
	break;
	case *analisi delle cause*:
	$id_del_tag='0';
	break;
	case *politica del governo*:
	$id_del_tag='0';
	break;
	case *contratto di trasporto*:
	$id_del_tag='0';
	break;
	case *beni*:
	$id_del_tag='0';
	break;
	case *dati medici*:
	$id_del_tag='0';
	break;
	case *processo decisionale*:
	$id_del_tag='0';
	break;
	case *marescialli e capi di classe*:
	$id_del_tag='0';
	break;
	case *competenza amministrativa*:
	$id_del_tag='0';
	break;
	case *convenzione europea*:
	$id_del_tag='0';
	break;
	case *classificazione*:
	$id_del_tag='0';
	break;
	case *atlante*:
	$id_del_tag='0';
	break;
	case *dl 1992 0504*:
	$id_del_tag='0';
	break;
	case *corsi abilitanti*:
	$id_del_tag='0';
	break;
	case *istruzione in generale*:
	$id_del_tag='0';
	break;
	case *preparati galenici*:
	$id_del_tag='0';
	break;
	case *cooperazione tecnica*:
	$id_del_tag='0';
	break;
	case *annotazioni su atti*:
	$id_del_tag='0';
	break;
	case *assegnazione di sede*:
	$id_del_tag='0';
	break;
	case *riforma scolastica*:
	$id_del_tag='0';
	break;
	case *contingente di cattura*:
	$id_del_tag='0';
	break;
	case *capo di stato*:
	$id_del_tag='0';
	break;
	case *buoni servizio*:
	$id_del_tag='0';
	break;
	case *decreto legge 2005 0115*:
	$id_del_tag='0';
	break;
	case *protezione dei dati*:
	$id_del_tag='0';
	break;
	case *controllo fitosanitario*:
	$id_del_tag='0';
	break;
	case *situazione finanziaria*:
	$id_del_tag='0';
	break;
	case *decreto legge 1993 0331*:
	$id_del_tag='0';
	break;
	case *prova*:
	$id_del_tag='0';
	break;
	case *risorse alieutiche*:
	$id_del_tag='0';
	break;
	case *deposito e custodia*:
	$id_del_tag='0';
	break;
	case *trauma*:
	$id_del_tag='0';
	break;
	case *eguaglianza uomo-donna*:
	$id_del_tag='0';
	break;
	case *ravvicinamento delle legislazioni*:
	$id_del_tag='0';
	break;
	case *dl 2006 0163*:
	$id_del_tag='0';
	break;
	case *rimessione di procedimenti penali*:
	$id_del_tag='0';
	break;
	case *rapporto*:
	$id_del_tag='0';
	break;
	case *attivita' e operatori subacquei*:
	$id_del_tag='0';
	break;
	case *decreto legge 1993 0400*:
	$id_del_tag='0';
	break;
	case *dpr 1995 0472*:
	$id_del_tag='0';
	break;
	case *competenza*:
	$id_del_tag='0';
	break;
	case *tecnica delle telecomunicazioni*:
	$id_del_tag='0';
	break;
	case *conto*:
	$id_del_tag='0';
	break;
	case *potere di controllo*:
	$id_del_tag='0';
	break;
	case *dl 2007 0164*:
	$id_del_tag='0';
	break;
	case *erosione*:
	$id_del_tag='0';
	break;
	case *conservazione della pesca*:
	$id_del_tag='0';
	break;
	case *dpr 1976 0752*:
	$id_del_tag='0';
	break;
	case *habitat urbano*:
	$id_del_tag='0';
	break;
	case *densita' di popolazione*:
	$id_del_tag='0';
	break;
	case *differenza culturale*:
	$id_del_tag='0';
	break;
	case *manutenzione*:
	$id_del_tag='0';
	break;
	case *principio generale del diritto*:
	$id_del_tag='0';
	break;
	case *dl 1994 0626*:
	$id_del_tag='0';
	break;
	case *strutture e attrezzature scolastiche*:
	$id_del_tag='0';
	break;
	case *qualificazione professionale*:
	$id_del_tag='0';
	break;
	case *deliberazioni*:
	$id_del_tag='0';
	break;
	case *rapporti con l' amministrazione*:
	$id_del_tag='0';
	break;
	case *legislazione fitosanitaria*:
	$id_del_tag='0';
	break;
	case *gruppo etnico*:
	$id_del_tag='0';
	break;
	case *dibattito parlamentare*:
	$id_del_tag='0';
	break;
	case *tesoro*:
	$id_del_tag='0';
	break;
	case *prezzo base*:
	$id_del_tag='0';
	break;
	case *organizzazione del servizio sanitario*:
	$id_del_tag='0';
	break;
	case *potenziale di sviluppo*:
	$id_del_tag='0';
	break;
	case *situazione politica*:
	$id_del_tag='0';
	break;
	case *usl - unit?á sanitaria locale*:
	$id_del_tag='0';
	break;
	case *utilizzazione degli aiuti*:
	$id_del_tag='0';
	break;
	case *commissione interna*:
	$id_del_tag='0';
	break;
	case *note di variazione*:
	$id_del_tag='0';
	break;
	case *competenza mista*:
	$id_del_tag='0';
	break;
	case *aumenti periodici di stipendio*:
	$id_del_tag='0';
	break;
	case *classe dirigente*:
	$id_del_tag='0';
	break;
	case *leguminose*:
	$id_del_tag='0';
	break;
	case *decreto legge 2007 0248*:
	$id_del_tag='0';
	break;
	case *dl 2003 0216*:
	$id_del_tag='0';
	break;
	case *decreto legge 2008 0112*:
	$id_del_tag='0';
	break;
	case *missione d'inchiesta*:
	$id_del_tag='0';
	break;
	case *decreto legge 2007 0023*:
	$id_del_tag='0';
	break;
	case *decreto legge 1987 0370*:
	$id_del_tag='0';
	break;
	case *ripartizione dell'aiuto*:
	$id_del_tag='0';
	break;
	case *dl 2005 0030*:
	$id_del_tag='0';
	break;
	case *energia idraulica*:
	$id_del_tag='0';
	break;
	case *dl 2005 0206*:
	$id_del_tag='0';
	break;
	case *relazioni governative*:
	$id_del_tag='0';
	break;
	case *prezzo ridotto*:
	$id_del_tag='0';
	break;
	case *prezzo medio*:
	$id_del_tag='0';
	break;
	case *piantina*:
	$id_del_tag='0';
	break;
	case *riscaldamento*:
	$id_del_tag='0';
	break;
	case *servizio*:
	$id_del_tag='0';
	break;
	case *utilizzazione dello spazio*:
	$id_del_tag='0';
	break;
	case *contatori*:
	$id_del_tag='0';
	break;
	case *cooperazione rafforzata*:
	$id_del_tag='0';
	break;
	case *comunicato stampa*:
	$id_del_tag='0';
	break;
	case *trasmissione dei dati*:
	$id_del_tag='0';
	break;
	case *lavoratore della comunita'*:
	$id_del_tag='0';
	break;
	case *ispezione degli alimenti*:
	$id_del_tag='0';
	break;
	case *diffusione delle informazioni*:
	$id_del_tag='0';
	break;
	case *risultato della ricerca*:
	$id_del_tag='0';
	break;
	case *ceto alto*:
	$id_del_tag='0';
	break;
	case *norma ambientale*:
	$id_del_tag='0';
	break;
	case *dl 2005 0059*:
	$id_del_tag='0';
	break;
	case *orientamento agricolo*:
	$id_del_tag='0';
	break;
	case *controllo degli aiuti di stato*:
	$id_del_tag='0';
	break;
	case *prezzi di trasferimento*:
	$id_del_tag='0';
	break;
	case *decreto legge 2005 0007*:
	$id_del_tag='0';
	break;
	case *attivita' di urgenza*:
	$id_del_tag='0';
	break;
	case *ripartizione di somme*:
	$id_del_tag='0';
	break;
	case *regime economico*:
	$id_del_tag='0';
	break;
	case *moneta fiduciaria*:
	$id_del_tag='0';
	break;
	case *mezzi di ricorso*:
	$id_del_tag='0';
	break;
	case *regime di aiuto*:
	$id_del_tag='0';
	break;
	case *tecnica di gestione*:
	$id_del_tag='0';
	break;
	case *condizione di pensionamento*:
	$id_del_tag='0';
	break;
	case *responsabilita' dello stato*:
	$id_del_tag='0';
	break;
	case *programma operativo*:
	$id_del_tag='0';
	break;
	case *risanamento*:
	$id_del_tag='0';
	break;
	case *finanziamento complementare*:
	$id_del_tag='0';
	break;
	case *fiscalita'*:
	$id_del_tag='0';
	break;
	case *amministratori*:
	$id_del_tag='0';
	break;
	case *situazione familiare*:
	$id_del_tag='0';
	break;
	case *quadri intermedi*:
	$id_del_tag='0';
	break;
	case *enti privati*:
	$id_del_tag='0';
	break;
	case *gestione delle acque*:
	$id_del_tag='0';
	break;
	case *prezzo unitario*:
	$id_del_tag='0';
	break;
	case *fondo strutturale*:
	$id_del_tag='0';
	break;
	case *organizzazione e responsabilita' familiari*:
	$id_del_tag='0';
	break;
	case *settore economico*:
	$id_del_tag='0';
	break;
	case *cassa delle ammende*:
	$id_del_tag='0';
	break;
	case *fabbisogno energetico*:
	$id_del_tag='0';
	break;
	case *armonizzazione fiscale*:
	$id_del_tag='0';
	break;
	case *flottiglia peschereccia*:
	$id_del_tag='0';
	break;
	case *azione pubblica*:
	$id_del_tag='0';
	break;
	case *aiuto agli investimenti*:
	$id_del_tag='0';
	break;
	case *aiuto finanziario*:
	$id_del_tag='0';
	break;
	case *applicabilita' diretta*:
	$id_del_tag='0';
	break;
	case *situazione economica*:
	$id_del_tag='0';
	break;
	case *politica di aiuto*:
	$id_del_tag='0';
	break;
	case *osservatori*:
	$id_del_tag='0';
	break;
	case *distribuzione per eta'*:
	$id_del_tag='0';
	break;
	case *circolazione aerea*:
	$id_del_tag='0';
	break;
	case *aiuto sociale*:
	$id_del_tag='0';
	break;
	case *contabile*:
	$id_del_tag='0';
	break;
	case *collettore solare*:
	$id_del_tag='0';
	break;
	case *organizzazione della ricerca*:
	$id_del_tag='0';
	break;
	case *studio d'impatto*:
	$id_del_tag='0';
	break;
	case *ciclo economico*:
	$id_del_tag='0';
	break;
	case *decreto legge 2004 0097*:
	$id_del_tag='0';
	break;
	case *analisi economica*:
	$id_del_tag='0';
	break;
	case *rischi*:
	$id_del_tag='0';
	break;
	case *illuminazione*:
	$id_del_tag='0';
	break;
	case *esperimento sull'uomo*:
	$id_del_tag='0';
	break;
	case *valore economico*:
	$id_del_tag='0';
	break;
	case *dl 2003 0005*:
	$id_del_tag='0';
	break;
	case *poteri pubblici*:
	$id_del_tag='0';
	break;
	case *elettorato*:
	$id_del_tag='0';
	break;
	case *questione di fiducia*:
	$id_del_tag='0';
	break;
	case *ripartizione delle competenze*:
	$id_del_tag='0';
	break;
	case *competenza per materia*:
	$id_del_tag='0';
	break;
	case *uffici*:
	$id_del_tag='0';
	break;
	case *decreto legge 2005 0035*:
	$id_del_tag='0';
	break;
	case *dl 2001 0215*:
	$id_del_tag='0';
	break;
	case *immagazzinaggio di idrocarburi*:
	$id_del_tag='0';
	break;
	case *gruppo di produttori*:
	$id_del_tag='0';
	break;
	case *stazione energetica*:
	$id_del_tag='0';
	break;
	case *protezione del patrimonio*:
	$id_del_tag='0';
	break;
	case *competenza istituzionale ce*:
	$id_del_tag='0';
	break;
	case *controllo delle concentrazioni*:
	$id_del_tag='0';
	break;
	case *citologia*:
	$id_del_tag='0';
	break;
	case *categoria sociale svantaggiata*:
	$id_del_tag='0';
	break;
	case *filiale*:
	$id_del_tag='0';
	break;
	case *energia dolce*:
	$id_del_tag='0';
	break;
	case *rilancio economico*:
	$id_del_tag='0';
	break;
	case *progetto d'investimento*:
	$id_del_tag='0';
	break;
	case *dpr 2001 0461*:
	$id_del_tag='0';
	break;
	case *isolamento di un edificio*:
	$id_del_tag='0';
	break;
	case *contributo finanziario*:
	$id_del_tag='0';
	break;
	case *decreto legge 2007 0159*:
	$id_del_tag='0';
	break;
	case *attentati*:
	$id_del_tag='0';
	break;
	case *costo d'investimento*:
	$id_del_tag='0';
	break;
	case *schede e schedari*:
	$id_del_tag='0';
	break;
	case *dl 2004 0102*:
	$id_del_tag='0';
	break;
	case *ente per le nuove tecnologie*:
	$id_del_tag='0';
	break;
	case *documenti del veicolo*:
	$id_del_tag='0';
	break;
	case *carattere confidenziale*:
	$id_del_tag='0';
	break;
	case *cooperazione tra imprese*:
	$id_del_tag='0';
	break;
	case *servizio d'interesse generale*:
	$id_del_tag='0';
	break;
	case *prodotto originario*:
	$id_del_tag='0';
	break;
	case *centro nazionale del libro parlato*:
	$id_del_tag='0';
	break;
	case *condizioni di vita*:
	$id_del_tag='0';
	break;
	case *disputa commerciale*:
	$id_del_tag='0';
	break;
	case *commercio interno*:
	$id_del_tag='0';
	break;
	case *fanciullo*:
	$id_del_tag='0';
	break;
	case *organismo d'intervento*:
	$id_del_tag='0';
	break;
	case *attivita' economica*:
	$id_del_tag='0';
	break;
	case *congressi convegni e seminari*:
	$id_del_tag='0';
	break;
	case *utilizzazione dell'acqua*:
	$id_del_tag='0';
	break;
	case *protezione delle liberta'*:
	$id_del_tag='0';
	break;
	case *assistenti penitenziarie*:
	$id_del_tag='0';
	break;
	case *isolamento acustico*:
	$id_del_tag='0';
	break;
	case *stabilizzazione economica*:
	$id_del_tag='0';
	break;
	case *traduzione*:
	$id_del_tag='0';
	break;
	case *trattamento dell'acqua*:
	$id_del_tag='0';
	break;
	case *restrizione agli scambi*:
	$id_del_tag='0';
	break;
	case *rendimento energetico*:
	$id_del_tag='0';
	break;
	case *trasferimento di competenze*:
	$id_del_tag='0';
	break;
	case *selezione degli alunni*:
	$id_del_tag='0';
	break;
	case *settore terziario*:
	$id_del_tag='0';
	break;
	case *utilizzazione del terreno*:
	$id_del_tag='0';
	break;
	case *reddito dell'azienda agricola*:
	$id_del_tag='0';
	break;
	case *dl 2005 0122*:
	$id_del_tag='0';
	break;
	case *assegni pensionabili*:
	$id_del_tag='0';
	break;
	case *fabbisogno abitativo*:
	$id_del_tag='0';
	break;
	case *falsita'*:
	$id_del_tag='0';
	break;
	case *dpr 2004 0303*:
	$id_del_tag='0';
	break;
	case *aiuto economico*:
	$id_del_tag='0';
	break;
	case *cessazione dei pagamenti*:
	$id_del_tag='0';
	break;
	case *struttura dell'impresa*:
	$id_del_tag='0';
	break;
	case *idrogeologia*:
	$id_del_tag='0';
	break;
	case *provincia autonoma di bolzano*:
	$id_del_tag='4591';
	break;
	case *guidonia montecelio*:
	$id_del_tag='7715';
	break;
	case *isola di lipari*:
	$id_del_tag='6291';
	break;
	
	case *statistica agricola*:
	$id_del_tag='0';
	break;
	case *pianta resinosa*:
	$id_del_tag='0';
	break;
	case *costi*:
	$id_del_tag='0';
	break;
	case *solvibilita' finanziaria*:
	$id_del_tag='0';
	break;
	case *disavanzo di bilancio*:
	$id_del_tag='0';
	break;
	case *procedura speciale*:
	$id_del_tag='0';
	break;
	case *rapporti tra istituzioni e societa'*:
	$id_del_tag='0';
	break;
	case *contabilita'*:
	$id_del_tag='0';
	break;
	case *istituto di istruzione*:
	$id_del_tag='0';
	break;
	case *congiuntura economica*:
	$id_del_tag='0';
	break;
	case *decreto legge 2005 0203*:
	$id_del_tag='0';
	break;
	case *qualita' dell'insegnamento*:
	$id_del_tag='0';
	break;
	case *tutela dei soci*:
	$id_del_tag='0';
	break;
	case *programmi e piani*:
	$id_del_tag='0';
	break;
	case *uomo*:
	$id_del_tag='0';
	break;
	case *competenza del parlamento*:
	$id_del_tag='0';
	break;
	case *trasporto tramite condotto*:
	$id_del_tag='0';
	break;
	case *apparecchiatura sotto pressione*:
	$id_del_tag='0';
	break;
	case *produzione trasformazione commercializzazione*:
	$id_del_tag='0';
	break;
	case *spacci aziendali*:
	$id_del_tag='0';
	break;
	case *incremento produttivo*:
	$id_del_tag='0';
	break;
	case *quota di produzione*:
	$id_del_tag='0';
	break;
	case *calcolo dei costi*:
	$id_del_tag='0';
	break;
	case *campionamento*:
	$id_del_tag='0';
	break;
	case *erogazione di prestito*:
	$id_del_tag='0';
	break;
	case *attivita' dell'impresa*:
	$id_del_tag='0';
	break;
	case *forme non economiche di assistenza*:
	$id_del_tag='0';
	break;
	case *consorzi obbligatori*:
	$id_del_tag='0';
	break;
	case *ruolo sociale*:
	$id_del_tag='0';
	break;
	case *atto congressuale*:
	$id_del_tag='0';
	break;
	case *perdita finanziaria*:
	$id_del_tag='0';
	break;
	case *dl 2005 0286*:
	$id_del_tag='0';
	break;
	case *disabilitâ”œã¡*:
	$id_del_tag='0';
	break;
	case *proprieta' patrimoniale*:
	$id_del_tag='0';
	break;
	case *attrezzatura agricola*:
	$id_del_tag='0';
	break;
	case *gruppo di societa'*:
	$id_del_tag='0';
	break;
	case *interesse finanziario dei membri*:
	$id_del_tag='0';
	break;
	case *dl 1999 0230*:
	$id_del_tag='0';
	break;
	case *dimensioni dell'impresa*:
	$id_del_tag='0';
	break;
	case *confezionamento*:
	$id_del_tag='0';
	break;
	case *sorveglianza all'importazione*:
	$id_del_tag='0';
	break;
	case *norma europea*:
	$id_del_tag='0';
	break;
	case *decreto legge 1994 0293*:
	$id_del_tag='0';
	break;
	case *settore secondario*:
	$id_del_tag='0';
	break;
	case *norma di sicurezza*:
	$id_del_tag='0';
	break;
	case *manager*:
	$id_del_tag='0';
	break;
	case *decreto legge 1991 0152*:
	$id_del_tag='0';
	break;
	case *dl 1995 0194*:
	$id_del_tag='0';
	break;
	case *prezzi sorvegliati*:
	$id_del_tag='0';
	break;
	case *coesione economica e sociale*:
	$id_del_tag='0';
	break;
	case *servizi portuali*:
	$id_del_tag='0';
	break;
	case *esecuzione di progetto*:
	$id_del_tag='0';
	break;
	case *acquicoltura*:
	$id_del_tag='0';
	break;
	case *delega di potere*:
	$id_del_tag='0';
	break;
	case *dl 1997 0281*:
	$id_del_tag='0';
	break;
	case *mandato elettivo*:
	$id_del_tag='0';
	break;
	case *potere d'iniziativa*:
	$id_del_tag='0';
	break;
	case *problema sociale*:
	$id_del_tag='0';
	break;
	case *attivita' edilizie e cantieri*:
	$id_del_tag='0';
	break;
	case *protezione degli edifici*:
	$id_del_tag='0';
	break;
	case *decreto legge 1993 0122*:
	$id_del_tag='0';
	break;
	case *potere di decisione*:
	$id_del_tag='0';
	break;
	case *acquisizione di conoscenze*:
	$id_del_tag='0';
	break;
	case *aggiornamento*:
	$id_del_tag='0';
	break;
	case *reinserimento sociale*:
	$id_del_tag='0';
	break;
	case *strategia europea per l'occupazione*:
	$id_del_tag='0';
	break;
	case *studio del lavoro*:
	$id_del_tag='0';
	break;
	case *impianto idroelettrico*:
	$id_del_tag='0';
	break;
	case *derrata deperibile*:
	$id_del_tag='0';
	break;
	case *analisi dell'acqua*:
	$id_del_tag='0';
	break;
	case *gas di petrolio liquefatti*:
	$id_del_tag='0';
	break;
	case *dl 1997 0241*:
	$id_del_tag='0';
	break;
	case *dl 1997 0422*:
	$id_del_tag='0';
	break;
	case *strutture universitarie*:
	$id_del_tag='0';
	break;
	case *interesse*:
	$id_del_tag='0';
	break;
	case *termine di pagamento*:
	$id_del_tag='0';
	break;
	case *costo d'esercizio*:
	$id_del_tag='0';
	break;
	case *assistenza e incentivazione economica*:
	$id_del_tag='0';
	break;
	case *parassitologia*:
	$id_del_tag='0';
	break;
	case *impianto sanitario*:
	$id_del_tag='0';
	break;
	case *prenotazione*:
	$id_del_tag='0';
	break;
	case *carriera direttiva*:
	$id_del_tag='0';
	break;
	case *circoli militari*:
	$id_del_tag='0';
	break;
	case *risultato dell'esercizio*:
	$id_del_tag='0';
	break;
	case *giudizio*:
	$id_del_tag='0';
	break;
	case *norma sociale*:
	$id_del_tag='0';
	break;
	case *dl 2006 0152*:
	$id_del_tag='0';
	break;
	case *fondi di dotazione*:
	$id_del_tag='0';
	break;
	case *disattivazione di centrale*:
	$id_del_tag='0';
	break;
	case *opzione*:
	$id_del_tag='0';
	break;
	case *idonei in concorso*:
	$id_del_tag='0';
	break;
	case *dl 1996 0103*:
	$id_del_tag='0';
	break;
	case *rumore*:
	$id_del_tag='0';
	break;
	case *uomo politico*:
	$id_del_tag='0';
	break;
	case *conferenza dei presidenti*:
	$id_del_tag='0';
	break;
	case *penuria di manodopera*:
	$id_del_tag='0';
	break;
	case *tutela*:
	$id_del_tag='0';
	break;
	case *scambio d'informazioni*:
	$id_del_tag='0';
	break;
	case *complemento retributivo*:
	$id_del_tag='0';
	break;
	case *credito incrociato*:
	$id_del_tag='0';
	break;
	case *attivita' scientifiche*:
	$id_del_tag='0';
	break;
	case *contenitore*:
	$id_del_tag='0';
	break;
	case *tesi*:
	$id_del_tag='0';
	break;
	case *sede*:
	$id_del_tag='0';
	break;
	case *impegno delle spese*:
	$id_del_tag='0';
	break;
	case *democratizzazione*:
	$id_del_tag='0';
	break;
	case *guardie campestri*:
	$id_del_tag='0';
	break;
	case *sconto*:
	$id_del_tag='0';
	break;
	case *nocivita'*:
	$id_del_tag='0';
	break;
	case *trasporto per conto terzi*:
	$id_del_tag='0';
	break;
	case *contratto di forniture*:
	$id_del_tag='0';
	break;
	case *spese obbligatorie*:
	$id_del_tag='0';
	break;
	case *organo di controllo*:
	$id_del_tag='0';
	break;
	case *accesso al mercato*:
	$id_del_tag='0';
	break;
	case *carico di famiglia*:
	$id_del_tag='0';
	break;
	case *attivita' bancaria*:
	$id_del_tag='0';
	break;
	case *trattamento fitosanitario*:
	$id_del_tag='0';
	break;
	case *condizione economica*:
	$id_del_tag='0';
	break;
	case *sostegno del mercato*:
	$id_del_tag='0';
	break;
	case *equilibrio ecologico*:
	$id_del_tag='0';
	break;
	case *fallimento lehman brothers*:
	$id_del_tag='0';
	break;
	case *miglioramento dell'habitat*:
	$id_del_tag='0';
	break;
	case *norma di commercializzazione*:
	$id_del_tag='0';
	break;
	case *automazione del sistema bancario*:
	$id_del_tag='0';
	break;
	case *importazione comunitaria*:
	$id_del_tag='0';
	break;
	case *situazione sociale*:
	$id_del_tag='0';
	break;
	case *dolciumi*:
	$id_del_tag='0';
	break;
	case *bie*:
	$id_del_tag='0';
	break;
	case *quotazione di titoli*:
	$id_del_tag='0';
	break;
	case *fissazione dei prezzi*:
	$id_del_tag='0';
	break;
	case *campagna di sensibilizzazione*:
	$id_del_tag='0';
	break;
	case *giro d'affari*:
	$id_del_tag='0';
	break;
	case *iscrizione in bilancio*:
	$id_del_tag='0';
	break;
	case *semplificazione delle formalita'*:
	$id_del_tag='0';
	break;
	case *riduzione tariffaria*:
	$id_del_tag='0';
	break;
	case *impianto a mare*:
	$id_del_tag='0';
	break;
	case *protezione della madre e del bambino*:
	$id_del_tag='0';
	break;
	case *protezione delle acque*:
	$id_del_tag='0';
	break;
	case *dpr 1972 0626*:
	$id_del_tag='0';
	break;
	case *coltivazione mineraria*:
	$id_del_tag='0';
	break;
	case *documenti di bilancio*:
	$id_del_tag='0';
	break;
	case *agenzie*:
	$id_del_tag='0';
	break;
	case *conseguenza economica*:
	$id_del_tag='0';
	break;
	case *qualifica obsoleta*:
	$id_del_tag='0';
	break;
	case *provvigioni e interessenze*:
	$id_del_tag='0';
	break;
	case *collaborazione con l' autorita' giudiziaria*:
	$id_del_tag='0';
	break;
	case *intese con culti acattolici*:
	$id_del_tag='0';
	break;
	case *mezzi e risorse della pubblica amministrazione*:
	$id_del_tag='0';
	break;
	case *produzione vegetale e animale*:
	$id_del_tag='0';
	break;
	case *struttura sociale*:
	$id_del_tag='0';
	break;
	case *dpr 1973 0602*:
	$id_del_tag='0';
	break;
	case *esercizio finanziario*:
	$id_del_tag='0';
	break;
	case *agenzia all'estero*:
	$id_del_tag='0';
	break;
	case *analisi dei bilanci*:
	$id_del_tag='0';
	break;
	case *formazione alla gestione*:
	$id_del_tag='0';
	break;
	case *norma tecnica*:
	$id_del_tag='0';
	break;
	case *riduzione delle emissioni gassose*:
	$id_del_tag='0';
	break;
	case *dl 1999 0300*:
	$id_del_tag='0';
	break;
	case *sicurezza d'approvvigionamento*:
	$id_del_tag='0';
	break;
	case *dpr 1997 0431*:
	$id_del_tag='0';
	break;
	case *stato islamico*:
	$id_del_tag='0';
	break;
	case *comunicazioni giudiziarie*:
	$id_del_tag='0';
	break;
	case *finanziamento*:
	$id_del_tag='0';
	break;
	case *sergenti maggiori e brigadieri*:
	$id_del_tag='0';
	break;
	case *tutela e curatela*:
	$id_del_tag='0';
	break;
	case *dl 2005 0209*:
	$id_del_tag='0';
	break;
	case *offerta di impiego*:
	$id_del_tag='0';
	break;
	case *settore non commerciale*:
	$id_del_tag='0';
	break;
	case *amministrazione del personale*:
	$id_del_tag='0';
	break;
	case *intesa*:
	$id_del_tag='0';
	break;
	case *magistrato non professionale*:
	$id_del_tag='0';
	break;
	case *competenza degli stati membri*:
	$id_del_tag='0';
	break;
	case *situazione dell'agricoltura*:
	$id_del_tag='0';
	break;
	case *dpr 1994 0698*:
	$id_del_tag='0';
	break;
	case *ase*:
	$id_del_tag='0';
	break;
	case *decreto legge 2007 0008*:
	$id_del_tag='0';
	break;
	case *assistenza nella formazione*:
	$id_del_tag='0';
	break;
	case *dl 2005 0177*:
	$id_del_tag='0';
	break;
	case *dpr 1967 0223*:
	$id_del_tag='0';
	break;
	case *dl 2005 0227*:
	$id_del_tag='0';
	break;
	case *analisi delle informazioni*:
	$id_del_tag='0';
	break;
	case *dl 1996 0625*:
	$id_del_tag='0';
	break;
	case *struttura agraria*:
	$id_del_tag='0';
	break;
	case *dl 2008 0081*:
	$id_del_tag='0';
	break;
	case *ritmo di lavoro*:
	$id_del_tag='0';
	break;
	case *dl 2005 0139*:
	$id_del_tag='0';
	break;
	case *cultura dell'organizzazione*:
	$id_del_tag='0';
	break;
	case *modulo*:
	$id_del_tag='0';
	break;
	case *esame medico*:
	$id_del_tag='0';
	break;
	case *tecnologia dolce*:
	$id_del_tag='0';
	break;
	case *espulsione*:
	$id_del_tag='0';
	break;
	case *fondi perequativi*:
	$id_del_tag='0';
	break;
	case *sede sociale*:
	$id_del_tag='0';
	break;
	case *gestione del materiale*:
	$id_del_tag='0';
	break;
	case *volume degli scambi*:
	$id_del_tag='0';
	break;
	case *utilizzazione delle lingue*:
	$id_del_tag='0';
	break;
	case *dl 1992 0546*:
	$id_del_tag='0';
	break;
	case *struttura istituzionale*:
	$id_del_tag='0';
	break;
	case *programma di stabilita'*:
	$id_del_tag='0';
	break;
	case *conduzione*:
	$id_del_tag='0';
	break;
	case *dl 1993 0507*:
	$id_del_tag='0';
	break;
	case *dpr 1973 0600*:
	$id_del_tag='0';
	break;
	case *riduzione delle forze*:
	$id_del_tag='0';
	break;
	case *dpr 1958 0916*:
	$id_del_tag='0';
	break;
	case *dpr 1997 0332*:
	$id_del_tag='0';
	break;
	case *spese di bilancio*:
	$id_del_tag='0';
	break;
	case *misura nazionale di esecuzione*:
	$id_del_tag='0';
	break;
	case *garanzia*:
	$id_del_tag='0';
	break;
	case *formulazione legislativa*:
	$id_del_tag='0';
	break;
	case *durata del lavoro*:
	$id_del_tag='0';
	break;
	case *dl 2003 0128*:
	$id_del_tag='0';
	break;
	case *dl 1995 0195*:
	$id_del_tag='0';
	break;
	case *dpr 1998 0169*:
	$id_del_tag='0';
	break;
	case *indennita' e spese*:
	$id_del_tag='0';
	break;
	case *parafiscalita'*:
	$id_del_tag='0';
	break;
	case *immagine di marca*:
	$id_del_tag='0';
	break;
	case *doppia imposizione*:
	$id_del_tag='0';
	break;
	case *dragaggio*:
	$id_del_tag='0';
	break;
	case *dl 1997 0250*:
	$id_del_tag='0';
	break;
	case *sottoprodotto*:
	$id_del_tag='0';
	break;
	case *processo fisico*:
	$id_del_tag='0';
	break;
	case *autorizzazione d'intesa*:
	$id_del_tag='0';
	break;
	case *dl 2001 0165*:
	$id_del_tag='0';
	break;
	case *procedura di concertazione*:
	$id_del_tag='0';
	break;
	case *regime politico*:
	$id_del_tag='0';
	break;
	case *cofinanziamento*:
	$id_del_tag='0';
	break;
	case *discorso*:
	$id_del_tag='0';
	break;
	case *sostegno economico*:
	$id_del_tag='0';
	break;
	case *anno accademico*:
	$id_del_tag='0';
	break;
	case *parere ce*:
	$id_del_tag='0';
	break;
	case *gestione*:
	$id_del_tag='0';
	break;
	case *azione*:
	$id_del_tag='0';
	break;
	case *conversione del posto di lavoro*:
	$id_del_tag='0';
	break;
	case *dpr 1972 0633*:
	$id_del_tag='0';
	break;
	case *dpr 1986 0917*:
	$id_del_tag='0';
	break;
	case *costi diretti*:
	$id_del_tag='0';
	break;
	case *schede elettorali*:
	$id_del_tag='0';
	break;
	case *regione ammissibile*:
	$id_del_tag='0';
	break;
	case *tecnici laureati*:
	$id_del_tag='0';
	break;
	case *dpr 2003 0254*:
	$id_del_tag='0';
	break;
	case *approvvigionamento*:
	$id_del_tag='0';
	break;
	case *tensione mentale*:
	$id_del_tag='0';
	break;
	case *terapeutica*:
	$id_del_tag='0';
	break;
	case *classe sociale*:
	$id_del_tag='0';
	break;
	case *instaurazione della pace*:
	$id_del_tag='0';
	break;
	case *analisi qualitativa*:
	$id_del_tag='0';
	break;
	case *controllo parlamentare*:
	$id_del_tag='0';
	break;
	case *albi elenchi e registri*:
	$id_del_tag='0';
	break;
	case *manifestazione commerciale*:
	$id_del_tag='0';
	break;
	case *gruppo linguistico*:
	$id_del_tag='0';
	break;
	case *periodo di tirocinio*:
	$id_del_tag='0';
	break;
	case *assegnazione ad altro incarico*:
	$id_del_tag='0';
	break;
	case *regione prioritaria*:
	$id_del_tag='0';
	break;
	case *minore eta' civile*:
	$id_del_tag='0';
	break;
	case *organizzazione elettorale*:
	$id_del_tag='0';
	break;
	case *ossido*:
	$id_del_tag='0';
	break;
	case *documentazione*:
	$id_del_tag='0';
	break;
	case *benessere sociale*:
	$id_del_tag='0';
	break;
	case *grado*:
	$id_del_tag='0';
	break;
	case *indagine sui consumi*:
	$id_del_tag='0';
	break;
	case *tetti retributivi*:
	$id_del_tag='0';
	break;
	case *dl 1993 0374*:
	$id_del_tag='0';
	break;
	case *spesa*:
	$id_del_tag='0';
	break;
	case *risorse del mare*:
	$id_del_tag='0';
	break;
	case *vita umana*:
	$id_del_tag='0';
	break;
	case *esecutivo*:
	$id_del_tag='0';
	break;
	case *autonomia delle camere*:
	$id_del_tag='0';
	break;
	case *relazione*:
	$id_del_tag='0';
	break;
	case *gruppo dei paesi piu' industrializzati*:
	$id_del_tag='0';
	break;
	case *attivita' del medico*:
	$id_del_tag='0';
	break;
	case *progetto di ricerca*:
	$id_del_tag='0';
	break;
	case *domanda di impiego*:
	$id_del_tag='0';
	break;
	case *valutazione di progetto*:
	$id_del_tag='0';
	break;
	case *reddito complementare*:
	$id_del_tag='0';
	break;
	case *rendimento agricolo*:
	$id_del_tag='0';
	break;
	case *promozione culturale*:
	$id_del_tag='0';
	break;
	case *dl 2003 0196*:
	$id_del_tag='0';
	break;
	case *presidente*:
	$id_del_tag='0';
	break;
	case *dpr 1973 1092*:
	$id_del_tag='0';
	break;
	case *aiuto urgente*:
	$id_del_tag='0';
	break;
	case *dl 1994 0297*:
	$id_del_tag='0';
	break;
	case *impatto sociale*:
	$id_del_tag='0';
	break;
	case *caschi protettivi*:
	$id_del_tag='0';
	break;
	case *fondo comune*:
	$id_del_tag='0';
	break;
	case *interpretazione*:
	$id_del_tag='0';
	break;
	case *impianto frigorifero*:
	$id_del_tag='0';
	break;
	case *quota agricola*:
	$id_del_tag='0';
	break;
	case *liberta' di disporre di se stessi*:
	$id_del_tag='0';
	break;
	case *regione sfavorita*:
	$id_del_tag='0';
	break;
	case *sostegno monetario*:
	$id_del_tag='0';
	break;
	case *raccomandazione*:
	$id_del_tag='0';
	break;
	case *rimborso*:
	$id_del_tag='0';
	break;
	case *impianti di trasmissione*:
	$id_del_tag='0';
	break;
	case *corrente migratoria*:
	$id_del_tag='0';
	break;
	case *coalizione politica*:
	$id_del_tag='0';
	break;
	case *ripartizione delle imposte*:
	$id_del_tag='0';
	break;
	case *differenza di prezzo*:
	$id_del_tag='0';
	break;
	case *risorse di bilancio*:
	$id_del_tag='0';
	break;
	case *camera eletta con voto diretto*:
	$id_del_tag='0';
	break;
	case *sede disagiata*:
	$id_del_tag='0';
	break;
	case *settore primario*:
	$id_del_tag='0';
	break;
	case *autonomia*:
	$id_del_tag='0';
	break;
	case *beni e servizi*:
	$id_del_tag='0';
	break;
	case *costo degli impianti*:
	$id_del_tag='0';
	break;
	case *reddito basso*:
	$id_del_tag='0';
	break;
	case *produzione mondiale*:
	$id_del_tag='0';
	break;
	case *impiegato dei servizi pubblici*:
	$id_del_tag='0';
	break;
	case *impresa comune*:
	$id_del_tag='0';
	break;
	case *guida*:
	$id_del_tag='0';
	break;
	case *impatto pubblicitario*:
	$id_del_tag='0';
	break;
	case *aiuto alle vittime*:
	$id_del_tag='0';
	break;
	case *tenore di vita*:
	$id_del_tag='0';
	break;
	case *forno*:
	$id_del_tag='0';
	break;
	case *sistemi di gestione ambientale*:
	$id_del_tag='0';
	break;
	case *difesa strategica*:
	$id_del_tag='0';
	break;
	case *tiro a segno e a volo*:
	$id_del_tag='0';
	break;
	case *credito sportivo*:
	$id_del_tag='0';
	break;
	case *materiale lapideo*:
	$id_del_tag='0';
	break;
	case *dl 2003 0276*:
	$id_del_tag='0';
	break;
	case *promozione commerciale*:
	$id_del_tag='0';
	break;
	case *giovane lavoratore*:
	$id_del_tag='0';
	break;
	case *nuova pedagogia*:
	$id_del_tag='0';
	break;
	case *materiale per le telecomunicazioni*:
	$id_del_tag='0';
	break;
	case *risoluzione pe*:
	$id_del_tag='0';
	break;
	case *formalita' di dogana*:
	$id_del_tag='0';
	break;
	case *materiale didattico*:
	$id_del_tag='0';
	break;
	case *dl 2007 0231*:
	$id_del_tag='0';
	break;
	case *ritiro dal mercato*:
	$id_del_tag='0';
	break;
	case *istituzione dell'unione europea*:
	$id_del_tag='0';
	break;
	case *dpr 1975 0805*:
	$id_del_tag='0';
	break;
	case *criterio di ammissibilita'*:
	$id_del_tag='0';
	break;
	case *cartello*:
	$id_del_tag='0';
	break;
	case *sanita' animale*:
	$id_del_tag='0';
	break;
	case *credito legale*:
	$id_del_tag='0';
	break;
	case *seconda camera*:
	$id_del_tag='0';
	break;
	case *dpr 2000 0230*:
	$id_del_tag='0';
	break;
	case *articolo sportivo*:
	$id_del_tag='0';
	break;
	case *decreto legge 2006 0223*:
	$id_del_tag='0';
	break;
	case *dpr 1999 0554*:
	$id_del_tag='0';
	break;
	case *competenza istituzionale*:
	$id_del_tag='0';
	break;
	case *eliminazione dei rifiuti*:
	$id_del_tag='0';
	break;
	case *firma di accordo*:
	$id_del_tag='0';
	break;
	case *corso dei titoli*:
	$id_del_tag='0';
	break;
	case *livello sonoro*:
	$id_del_tag='0';
	break;
	case *dpr 1992 0495*:
	$id_del_tag='0';
	break;
	case *dpr 2000 0121*:
	$id_del_tag='0';
	break;
	case *formalita' amministrativa*:
	$id_del_tag='0';
	break;
	case *dpr 1996 0503*:
	$id_del_tag='0';
	break;
	case *certificazione comunitaria*:
	$id_del_tag='0';
	break;
	case *trasformazione tecnologica*:
	$id_del_tag='0';
	break;
	case *dl 2006 0042*:
	$id_del_tag='0';
	break;
	case *fornitore*:
	$id_del_tag='0';
	break;
	case *dl 2007 0030*:
	$id_del_tag='0';
	break;
	case *controllo alla frontiera*:
	$id_del_tag='0';
	break;
	case *programma d'azione*:
	$id_del_tag='0';
	break;
	case *controllo del traffico*:
	$id_del_tag='0';
	break;
	case *dl 1997 0460*:
	$id_del_tag='0';
	break;
	case *presidente del parlamento*:
	$id_del_tag='0';
	break;
	case *costruzione stradale*:
	$id_del_tag='0';
	break;
	case *aiuti alla riqualificazione*:
	$id_del_tag='0';
	break;
	case *quadro comunitario di sostegno*:
	$id_del_tag='0';
	break;
	case *dl 1998 0112*:
	$id_del_tag='0';
	break;
	case *difesa penale*:
	$id_del_tag='0';
	break;
	case *trattamento economico*:
	$id_del_tag='0';
	break;
	case *prestazione di servizi*:
	$id_del_tag='0';
	break;
	case *dl 1998 0495*:
	$id_del_tag='0';
	break;
	case *immobili per il trasporto*:
	$id_del_tag='0';
	break;
	case *dl 2000 0185*:
	$id_del_tag='0';
	break;
	case *dl 2001 0207*:
	$id_del_tag='0';
	break;
	case *dpr 1968 1639*:
	$id_del_tag='0';
	break;
	case *riduzione dei salari*:
	$id_del_tag='0';
	break;
	case *prevenzione dei rischi*:
	$id_del_tag='0';
	break;
	case *sentenza della corte ce*:
	$id_del_tag='0';
	break;
	case *dl 1998 0178*:
	$id_del_tag='0';
	break;
	case *dl 2001 0151*:
	$id_del_tag='0';
	break;
	case *dl 2006 0160*:
	$id_del_tag='0';
	break;
	case *organizzazione dei trasporti*:
	$id_del_tag='0';
	break;
	case *dl 1998 0286*:
	$id_del_tag='0';
	break;
	case *ricostruzione di carriera*:
	$id_del_tag='0';
	break;
	case *part time*:
	$id_del_tag='0';
	break;
	case *progetto di bilancio*:
	$id_del_tag='0';
	break;
	case *residenza secondaria*:
	$id_del_tag='0';
	break;
	case *autodeterminazione*:
	$id_del_tag='0';
	break;
	case *anno finanziario 2006*:
	$id_del_tag='0';
	break;
	case *anno finanziario 2005*:
	$id_del_tag='0';
	break;
	case *giacomelli spa*:
	$id_del_tag='0';
	break;
	case *svendite*:
	$id_del_tag='0';
	break;
	case *sp.el s.r.l.*:
	$id_del_tag='0';
	break;
	case *verifica dei conti*:
	$id_del_tag='0';
	break;
	case *prestazione familiare*:
	$id_del_tag='0';
	break;
	case *val agri*:
	$id_del_tag='0';
	break;
	case *ovest*:
	$id_del_tag='0';
	break;
	case *caldaro sulla strada del vino*:
	$id_del_tag='0';
	break;
	case *giudice unico*:
	$id_del_tag='0';
	break;
	case *criminologia*:
	$id_del_tag='0';
	break;
	case *sanatorie*:
	$id_del_tag='0';
	break;
	case *viabilita'*:
	$id_del_tag='0';
	break;
	case *viabilità*:
	$id_del_tag='0';
	break;
	case *idonei in concorso*:
	$id_del_tag='0';
	break;
	case *asta e vendita all'incanto*:
	$id_del_tag='0';
	break;
	case *irap irpef*:
	$id_del_tag='0';
	break;
	case *diritto d' autore classificazion*:
	$id_del_tag='0';
	break;
	case *diritto d'autore classificazion*:
	$id_del_tag='0';
	break;
	case *confini*:
	$id_del_tag='0';
	break;
	case *l 2006 0066*:
	$id_del_tag='0';
	break;
	case *assicurazione a favore della famiglia e dei superstiti*:
	$id_del_tag='0';
	break;
	case *art. 21 costituzione*:
	$id_del_tag='0';
	break;
	case *idratazione*:
	$id_del_tag='0';
	break;
	case *ruolo internazionale dell'unione europea*:
	$id_del_tag='0';
	break;
	case *identità  di genere*:
	$id_del_tag='0';
	break;
	case *identita'  di genere*:
	$id_del_tag='0';
	break;
	case *cane*:
	$id_del_tag='0';
	break;
	case *generi sessuali*:
	$id_del_tag='0';
	break;
	case *accumulatori*:
	$id_del_tag='0';
	break;
	case *motorizzazione*:
	$id_del_tag='0';
	break;
	case *invenzioni e opere dell' ingegno*:
	$id_del_tag='0';
	break;
	case *commissari liquidatori*:
	$id_del_tag='0';
	break;
	case *imposte sui giochi e concorsi*:
	$id_del_tag='0';
	break;
	case *ente nazionale assistenza magistrale ( enam )*:
	$id_del_tag='0';
	break;
	case *anno scolastico*:
	$id_del_tag='0';
	break;
	case *valle del ledro*:
	$id_del_tag='0';
	break;
	case *scienze motorie*:
	$id_del_tag='0';
	break;
	case *deposito e custodia*:
	$id_del_tag='0';
	break;
	case *federazione ginnastica d'italia (fgdi)*:
	$id_del_tag='0';
	break;
	case *facebook*:
	$id_del_tag='0';
	break;
	case *indennita' di missione*:
	$id_del_tag='0';
	break;
	case *rapporti con l' amministrazione*:
	$id_del_tag='0';
	break;
	case *rapporti con l'amministrazione*:
	$id_del_tag='0';
	break;
	case *assunzione*:
	$id_del_tag='0';
	break;
	case *poteri presidenziali in materia giudiziaria*:
	$id_del_tag='0';
	break;
	case *l 1958 0013*:
	$id_del_tag='0';
	break;
	case *nonni*:
	$id_del_tag='0';
	break;
	case *stato*:
	$id_del_tag='0';
	break;
	case *luigi de magistris (magistrato)*:
	$id_del_tag='0';
	break;
	case *contratto*:
	$id_del_tag='0';
	break;
	case *age*:
	$id_del_tag='0';
	break;
	case *centri di accoglieza*:
	$id_del_tag='0';
	break;
	case *fondi di riserva*:
	$id_del_tag='0';
	break;
	case *modo di produzione*:
	$id_del_tag='0';
	break;
	case *mira*:
	$id_del_tag='0';
	break;
	case *ripartizione di somme*:
	$id_del_tag='0';
	break;
	case *ordine mauriziano*:
	$id_del_tag='0';
	break;
	case *servizi all'estero*:
	$id_del_tag='0';
	break;
	case *licenze*:
	$id_del_tag='0';
	break;
	case *territorio delle provincie*:
	$id_del_tag='0';
	break;
	case *pagamento*:
	$id_del_tag='0';
	break;
	case *composto chimico*:
	$id_del_tag='0';
	break;
	case *consenso informato*:
	$id_del_tag='0';
	break;
	case *omissione di atti*:
	$id_del_tag='0';
	break;
	case *l 1996 0023*:
	$id_del_tag='0';
	break;
	case *accantonamenti*:
	$id_del_tag='0';
	break;
	case *deliberazione di bilancio*:
	$id_del_tag='0';
	break;
	case *banche dati*:
	$id_del_tag='0';
	break;
	case *comando di personale*:
	$id_del_tag='0';
	break;
	case *dispositivi di sicurezza*:
	$id_del_tag='0';
	break;
	case *competenze accessorie*:
	$id_del_tag='0';
	break;
	case *bollettini e notiziari ufficiali*:
	$id_del_tag='0';
	break;
	case *maggiori e capitani di corvetta*:
	$id_del_tag='0';
	break;
	case *l 2007 0222*:
	$id_del_tag='0';
	break;
	case *disciplina transitoria*:
	$id_del_tag='0';
	break;
	case *competenza*:
	$id_del_tag='0';
	break;
	case *assistenza e incentivazione economica*:
	$id_del_tag='0';
	break;
	case *tribunali internazionale*:
	$id_del_tag='0';
	break;
	case *albi elenchi e registri*:
	$id_del_tag='0';
	break;
	case *malattie rare*:
	$id_del_tag='0';
	break;
	case *trasmissione di atti*:
	$id_del_tag='0';
	break;
	case *privilegi*:
	$id_del_tag='0';
	break;
	case *protezione*:
	$id_del_tag='0';
	break;
	case *filippo fochi spa*:
	$id_del_tag='0';
	break;
	case *giuseppe verdi*:
	$id_del_tag='0';
	break;
	case *fragolina*:
	$id_del_tag='0';
	break;
	case *giustizi3*:
	$id_del_tag='0';
	break;
	case *indagini conoscitive prostituzione associazioni*:
	$id_del_tag='0';
	break;
	case *controlli contabili*:
	$id_del_tag='0';
	break;
	case *coltura oleaginosa*:
	$id_del_tag='0';
	break;
	case *idrogeno*:
	$id_del_tag='0';
	break;
	case *codice e codificazioni*:
	$id_del_tag='0';
	break;
	case *liquidazione coatta amministrativa*:
	$id_del_tag='0';
	break;
	case *ineleggibilita' beni culturali ed artistici*:
	$id_del_tag='0';
	break;
	case *beni personali*:
	$id_del_tag='0';
	break;
	case *godimento dei diritti*:
	$id_del_tag='0';
	break;
	case *repertorio*:
	$id_del_tag='0';
	break;
	case *residui attivi*:
	$id_del_tag='0';
	break;
	case *diritti di segreteria e di cancelleria*:
	$id_del_tag='0';
	break;
	case *ca*:
	$id_del_tag='0';
	break;
	case *organizzazione di ufficio*:
	$id_del_tag='0';
	break;
	case *pile*:
	$id_del_tag='0';
	break;
	case *statuto giuridico*:
	$id_del_tag='0';
	break;  
	
	// tag da associare a altri tag
	case *opera d'arte*:
	$id_del_tag='5';
	break;
	case *produzione artigianale*:
	$id_del_tag='8';
	break;
	case *artigiano*:
	$id_del_tag='9';
	break;
	case *caccia*:
	$id_del_tag='11';
	break;
	case *casa da gioco*:
	$id_del_tag='13';
	break;
	case *arti dello spettacolo*:
	$id_del_tag='15';
	break;
	case *cinema*:
	$id_del_tag='17';
	break;
	case *film e cortometraggi*:
	$id_del_tag='17';
	break;
	case *discoteca*:
	$id_del_tag='21';
	break;
	case *musica*:
	$id_del_tag='40';
	break;
	case *bande militari*:
	$id_del_tag='40';
	break;
	case *pittura*:
	$id_del_tag='5';
	break;
	case *base militare*:
	$id_del_tag='52';
	break;
	case *addestramento militare*:
	$id_del_tag='53';
	break;
	case *corpi armati dello stato*:
	$id_del_tag='53';
	break;
	case *esercito professionale*:
	$id_del_tag='57';
	break;
	case *carabinieri*:
	$id_del_tag='58';
	break;
	case *avanzamento di militari*:
	$id_del_tag='69';
	break;
	case *servizio nazionale di leva*:
	$id_del_tag='90';
	break;
	case *ordinanza*:
	$id_del_tag='0';
	break;
	case *regolamento*:
	$id_del_tag='0';
	break;
	case *decreto*:
	$id_del_tag='116';
	break;
	case *affissione*:
	$id_del_tag='136';
	break;
	case *associazione*:
	$id_del_tag='141';
	break;
	case *fondazione*:
	$id_del_tag='143';
	break;
	case *persona fisica*:
	$id_del_tag='0';
	break;
	case *domicilio*:
	$id_del_tag='154';
	break;
	case *accordo bilaterale*:
	$id_del_tag='0';
	break;
	case *contratto*:
	$id_del_tag='0';
	break;
	case *clausola contrattuale*:
	$id_del_tag='160';
	break;
	case *sfratto*:
	$id_del_tag='173';
	break;
	case *obbligazione*:
	$id_del_tag='0';
	break;
	case *danno*:
	$id_del_tag='182';
	break;
	case *trasferimento della proprieta'*:
	$id_del_tag='197';
	break;
	case *trasferimento di proprieta'*:
	$id_del_tag='197';
	break;
	case *limitazione della proprieta'*:
	$id_del_tag='197';
	break;
	case *acquisto della proprieta'*:
	$id_del_tag='197';
	break;
	case *diritto di famiglia*:
	$id_del_tag='206';
	break;
	case *adozione affidamento affiliazione*:
	$id_del_tag='211';
	break;
	case *autorita' parentale*:
	$id_del_tag='216';
	break;
	case *orfano*:
	$id_del_tag='218';
	break;
	case *parentela*:
	$id_del_tag='228';
	break;
	case *coniugato*:
	$id_del_tag='229';
	break;
	case *eredita'*:
	$id_del_tag='232';
	break;
	case *fatturazione*:
	$id_del_tag='242';
	break;
	case *denominazione di origine*:
	$id_del_tag='265';
	break;
	case *denominazione di origine controllata e garantita*:
	$id_del_tag='265';
	break;
	case *denominazione di origine controllata*:
	$id_del_tag='265';
	break;
	case *nolo*:
	$id_del_tag='272';
	break;
	case *rapporti stato-chiesa*:
	$id_del_tag='279';
	break;
	case *organizzazione internazionale*:
	$id_del_tag='304';
	break;
	case *assetto territoriale*:
	$id_del_tag='0';
	break;
	case *acque interne*:
	$id_del_tag='312';
	break;
	case *aiuto alimentare*:
	$id_del_tag='315';
	break;
	case *accordo internazionale*:
	$id_del_tag='321';
	break;
	case *ratifica di accordo*:
	$id_del_tag='323';
	break;
	case *aggravamento della pena*:
	$id_del_tag='326';
	break;
	case *sanzione amministrativa*:
	$id_del_tag='347';
	break;
	case *reato*:
	$id_del_tag='348';
	break;
	case *reato continuato*:
	$id_del_tag='348';
	break;
	case *circostanza aggravante*:
	$id_del_tag='0';
	break;
	case *gioco d'azzardo*:
	$id_del_tag='379';
	break;
	case *frode doganale*:
	$id_del_tag='383';
	break;
	case *cosa nostra*:
	$id_del_tag='4434';
	break;
	case *operazioni antimafia*:
	$id_del_tag='4434';
	break;
	case *azione dinanzi a giurisdizione civile*:
	$id_del_tag='414';
	break;
	case *esecuzione di sentenze civili*:
	$id_del_tag='421';
	break;
	case *esecutivita' di sentenze civili*:
	$id_del_tag='421';
	break;
	case *esecuzione della pena*:
	$id_del_tag='454';
	break;
	case *esecutivita' di sentenze penali*:
	$id_del_tag='454';
	break;
	case *esecuzione di sentenze penali*:
	$id_del_tag='454';
	break;
	case *inchiesta giudiziaria*:
	$id_del_tag='475';
	break;
	case *carcerazione*:
	$id_del_tag='486';
	break;
	case *regime penitenziario*:
	$id_del_tag='486';
	break;
	case *carcere di alessandria*:
	$id_del_tag='487';
	break;
	case *stabilimento penitenziario*:
	$id_del_tag='487';
	break;
	case *amministrazione penitenziaria*:
	$id_del_tag='487';
	break;
	case *detenuto*:
	$id_del_tag='497';
	break;
	case *lavoro del detenuto*:
	$id_del_tag='498';
	break;
	case *costituzione*:
	$id_del_tag='502';
	break;
	case *diritti politici*:
	$id_del_tag='507';
	break;
	case *cittadino*:
	$id_del_tag='510';
	break;
	case *diritto degli stranieri*:
	$id_del_tag='511';
	break;
	case *liberta' di religione*:
	$id_del_tag='514';
	break;
	case *minoranze etniche*:
	$id_del_tag='521';
	break;
	case *minoranze religiose*:
	$id_del_tag='521';
	break;
	case *trattamento sanitario*:
	$id_del_tag='528';
	break;
	case *elezione*:
	$id_del_tag='529';
	break;
	case *lista elettorale*:
	$id_del_tag='539';
	break;
	case *risultato elettorale*:
	$id_del_tag='540';
	break;
	case *seggio elettorale*:
	$id_del_tag='544';
	break;
	case *protezione della fauna*:
	$id_del_tag='555';
	break;
	case *finanze pubbliche*:
	$id_del_tag='559';
	break;
	case *finanze locali*:
	$id_del_tag='562';
	break;
	case *finanze regionali*:
	$id_del_tag='563';
	break;
	case *alleggerimento del debito*:
	$id_del_tag='577';
	break;
	case *entrata*:
	$id_del_tag='585';
	break;
	case *esenzione fiscale*:
	$id_del_tag='599';
	break;
	case *reddito delle famiglie*:
	$id_del_tag='601';
	break;
	case *detrazione fiscale*:
	$id_del_tag='603';
	break;
	case *imposta di bollo*:
	$id_del_tag='623';
	break;
	case *imposta di consumo*:
	$id_del_tag='632';
	break;
	case *spesa nazionale*:
	$id_del_tag='640';
	break;
	case *spesa per i contratti del pubblico impiego*:
	$id_del_tag='640';
	break;
	case *spese di difesa*:
	$id_del_tag='644';
	break;
	case *spese sanitarie*:
	$id_del_tag='646';
	break;
	case *investimento pubblico*:
	$id_del_tag='649';
	break;
	case *ricerca scientifica*:
	$id_del_tag='653';
	break;
	case *biblioteca*:
	$id_del_tag='661';
	break;
	case *biblioteca italiana per ciechi regina margherita di monza*:
	$id_del_tag='661';
	break;
	case *centro di documentazione*:
	$id_del_tag='663';
	break;
	case *centro comune di ricerca*:
	$id_del_tag='666';
	break;
	case *centro di ricerca*:
	$id_del_tag='666';
	break;
	case *manifestazione culturale*:
	$id_del_tag='669';
	break;
	case *rossini opera festival*:
	$id_del_tag='669';
	break;
	case *festival dei due mondi di spoleto*:
	$id_del_tag='669';
	break;
	case *museo*:
	$id_del_tag='670';
	break;
	case *giornale*:
	$id_del_tag='673';
	break;
	case *gestione d'impresa*:
	$id_del_tag='675';
	break;
	case *adozione del bilancio*:
	$id_del_tag='676';
	break;
	case *bilancio*:
	$id_del_tag='676';
	break;
	case *bilancio di societa'*:
	$id_del_tag='676';
	break;
	case *credito*:
	$id_del_tag='678';
	break;
	case *debito*:
	$id_del_tag='679';
	break;
	case *investimento privato*:
	$id_del_tag='0';
	break;
	case *commercializzazione*:
	$id_del_tag='692';
	break;
	case *materiale d'imballaggio*:
	$id_del_tag='0';
	break;
	case *imballaggio*:
	$id_del_tag='0';
	break;
	case *contenitori e imballaggi*:
	$id_del_tag='0';
	break;
	case *etichettatura*:
	$id_del_tag='0';
	break;
	case *macchina*:
	$id_del_tag='0';
	break;
	case *consulenza e perizia*:
	$id_del_tag='704';
	break;
	case *produzione industriale*:
	$id_del_tag='708';
	break;
	case *produzione e trasformazione industriale*:
	$id_del_tag='708';
	break;
	case *combustibile irraggiato*:
	$id_del_tag='710';
	break;
	case *combustibile di sostituzione*:
	$id_del_tag='710';
	break;
	case *combustibile fossile*:
	$id_del_tag='710';
	break;
	case *combustibile*:
	$id_del_tag='710';
	break;
	case *bevanda alcolica*:
	$id_del_tag='716';
	break;
	case *pane*:
	$id_del_tag='721';
	break;
	case *prodotti di gastronomia e cucina tipica*:
	$id_del_tag='723';
	break;
	case *additivo alimentare*:
	$id_del_tag='723';
	break;
	case *paste alimentari*:
	$id_del_tag='723';
	break;
	case *prodotto alimentare*:
	$id_del_tag='723';
	break;
	case *alcol*:
	$id_del_tag='0';
	break;
	case *prodotto petrolifero*:
	$id_del_tag='727';
	break;
	case *idrocarburo*:
	$id_del_tag='731';
	break;
	case *produzione di petrolio*:
	$id_del_tag='732';
	break;
	case *fibra tessile sintetica*:
	$id_del_tag='736';
	break;
	case *industria dell'abbigliamento*:
	$id_del_tag='742';
	break;
	case *apparecchio di registrazione*:
	$id_del_tag='0';
	break;
	case *applicazione dell'informatica*:
	$id_del_tag='752';
	break;
	case *strumento musicale*:
	$id_del_tag='755';
	break;
	case *adeguamento strutturale*:
	$id_del_tag='761';
	break;
	case *ricostruzione e consolidamento antisismici*:
	$id_del_tag='761';
	break;
	case *ricostruzioni e ristrutturazioni edilizie*:
	$id_del_tag='761';
	break;
	case *sostanza pericolosa*:
	$id_del_tag='774';
	break;
	case *sostanza radioattiva*:
	$id_del_tag='775';
	break;
	case *sostanza tossica*:
	$id_del_tag='776';
	break;
	case *sostanza cancerogena*:
	$id_del_tag='776';
	break;
	case *equipaggiamento e mezzi militari*:
	$id_del_tag='778';
	break;
	case *arma nucleare*:
	$id_del_tag='780';
	break;
	case *arma nucleare tattica*:
	$id_del_tag='780';
	break;
	case *industria carboniera*:
	$id_del_tag='781';
	break;
	case *gasdotto*:
	$id_del_tag='782';
	break;
	case *gas naturale*:
	$id_del_tag='784';
	break;
	case *miniere*:
	$id_del_tag='786';
	break;
	case *ingegnere*:
	$id_del_tag='788';
	break;
	case *autostrada*:
	$id_del_tag='792';
	break;
	case *area di parcheggio*:
	$id_del_tag='793';
	break;
	case *consorzio di bonifica del basso volturno*:
	$id_del_tag='799';
	break;
	case *rifiuti*:
	$id_del_tag='813';
	break;
	case *esportazione di rifiuti*:
	$id_del_tag='813';
	break;
	case *deposito dei rifiuti*:
	$id_del_tag='813';
	break;
	case *gestione dei rifiuti*:
	$id_del_tag='813';
	break;
	case *satellite*:
	$id_del_tag='820';
	break;
	case *automobile*:
	$id_del_tag='822';
	break;
	case *autoveicoli*:
	$id_del_tag='822';
	break;
	case *dispositivi di sicurezza*:
	$id_del_tag='822';
	break;
	case *dispositivi di equipaggiamento dei veicoli*:
	$id_del_tag='822';
	break;
	case *nave traghetto*:
	$id_del_tag='825';
	break;
	case *nave*:
	$id_del_tag='825';
	break;
	case *banda di frequenze*:
	$id_del_tag='833';
	break;
	case *microspie e intercettazioni ambientali*:
	$id_del_tag='840';
	break;
	case *motore*:
	$id_del_tag='848';
	break;
	case *collaudo*:
	$id_del_tag='850';
	break;
	case *educazione*:
	$id_del_tag='852';
	break;
	case *pratica professionale*:
	$id_del_tag='854';
	break;
	case *formazione sul posto di lavoro*:
	$id_del_tag='854';
	break;
	case *istituto per lo sviluppo della formazione professionale dei lavoratori ( isfol )*:
	$id_del_tag='854';
	break;
	case *formazione professionale continua*:
	$id_del_tag='854';
	break;
	case *addestramento professionale*:
	$id_del_tag='854';
	break;
	case *accesso all'istruzione*:
	$id_del_tag='860';
	break;
	case *diritto all'istruzione*:
	$id_del_tag='860';
	break;
	case *istruzione degli adulti*:
	$id_del_tag='865';
	break;
	case *accademia nazionale di danza*:
	$id_del_tag='871';
	break;
	case *accademie di belle arti*:
	$id_del_tag='871';
	break;
	case *accademia nazionale d' arte drammatica silvio d' amico*:
	$id_del_tag='871';
	break;
	case *facolta' universitarie*:
	$id_del_tag='892';
	break;
	case *iscrizione all' universita'*:
	$id_del_tag='892';
	break;
	case *istituzione di nuove universita'*:
	$id_del_tag='892';
	break;
	case *istruzione tecnica*:
	$id_del_tag='900';
	break;
	case *istruzione scientifica*:
	$id_del_tag='900';
	break;
	case *insegnante*:
	$id_del_tag='911';
	break;
	case *assegni di formazione didattica e scientifica*:
	$id_del_tag='0';
	break;
	case *diplomi di laurea*:
	$id_del_tag='919';
	break;
	case *diplomi universitari*:
	$id_del_tag='919';
	break;
	case *equipollenza dei diplomi*:
	$id_del_tag='920';
	break;
	case *accesso alla professione*:
	$id_del_tag='0';
	break;
	case *studente*:
	$id_del_tag='931';
	break;
	case *alunno*:
	$id_del_tag='931';
	break;
	case *studente straniero*:
	$id_del_tag='933';
	break;
	case *mensa scolastica*:
	$id_del_tag='938';
	break;
	case *infortunio sul lavoro*:
	$id_del_tag='940';
	break;
	case *lavoro pesante*:
	$id_del_tag='943';
	break;
	case *luogo di lavoro*:
	$id_del_tag='944';
	break;
	case *sicurezza del lavoro*:
	$id_del_tag='946';
	break;
	case *agenzie per il lavoro*:
	$id_del_tag='952';
	break;
	case *disoccupazione*:
	$id_del_tag='953';
	break;
	case *disoccupato*:
	$id_del_tag='953';
	break;
	case *organizzazione del tempo di lavoro*:
	$id_del_tag='956';
	break;
	case *mobilita' professionale*:
	$id_del_tag='960';
	break;
	case *mobilita' della manodopera*:
	$id_del_tag='960';
	break;
	case *lavoratore frontaliero*:
	$id_del_tag='961';
	break;
	case *lavoratore migrante*:
	$id_del_tag='962';
	break;
	case *lavoratore espatriato*:
	$id_del_tag='963';
	break;
	case *contratto di lavoro*:
	$id_del_tag='966';
	break;
	case *contratto collettivo*:
	$id_del_tag='968';
	break;
	case *contrattazione collettiva*:
	$id_del_tag='968';
	break;
	case *rappresentante sindacale*:
	$id_del_tag='978';
	break;
	case *assunzione diretta del personale*:
	$id_del_tag='979';
	break;
	case *assunzione*:
	$id_del_tag='979';
	break;
	case *assunzioni obbligatorie*:
	$id_del_tag='979';
	break;
	case *procedura disciplinare*:
	$id_del_tag='0';
	break;
	case *direzione aziendale*:
	$id_del_tag='988';
	break;
	case *direttori*:
	$id_del_tag='988';
	break;
	case *direttori di divisione e sezione*:
	$id_del_tag='988';
	break;
	case *direttore di impresa*:
	$id_del_tag='988';
	break;
	case *operaio*:
	$id_del_tag='990';
	break;
	case *datore di lavoro*:
	$id_del_tag='997';
	break;
	case *consigli di ordini professionali*:
	$id_del_tag='999';
	break;
	case *ordine professionale*:
	$id_del_tag='999';
	break;
	case *confederazione sindacale*:
	$id_del_tag='1002';
	break;
	case *sindacato*:
	$id_del_tag='1002';
	break;
	case *statuto professionale*:
	$id_del_tag='1005';
	break;
	case *esperienza professionale*:
	$id_del_tag='1005';
	break;
	case *carriera professionale*:
	$id_del_tag='1005';
	break;
	case *libera professione*:
	$id_del_tag='1006';
	break;
	case *manodopera agricola*:
	$id_del_tag='1011';
	break;
	case *lavoro stagionale*:
	$id_del_tag='1015';
	break;
	case *lavoratori a domicilio*:
	$id_del_tag='1017';
	break;
	case *basso salario*:
	$id_del_tag='1021';
	break;
	case *salariato*:
	$id_del_tag='1021';
	break;
	case *costi salariali*:
	$id_del_tag='1021';
	break;
	case *premio salariale*:
	$id_del_tag='1021';
	break;
	case *salario orario*:
	$id_del_tag='1021';
	break;
	case *determinazione del salario*:
	$id_del_tag='1021';
	break;
	case *apprendista*:
	$id_del_tag='1040';
	break;
	case *ferie retribuite*:
	$id_del_tag='1043';
	break;
	case *ore straordinarie*:
	$id_del_tag='1046';
	break;
	case *chirurgia*:
	$id_del_tag='1061';
	break;
	case *centro medico*:
	$id_del_tag='1061';
	break;
	case *attrezzature medico-chirurgiche*:
	$id_del_tag='1064';
	break;
	case *farmacista*:
	$id_del_tag='1070';
	break;
	case *medicinale*:
	$id_del_tag='1073';
	break;
	case *trasfusione di sangue*:
	$id_del_tag='1077';
	break;
	case *alimentazione umana*:
	$id_del_tag='1083';
	break;
	case *abitudine alimentare*:
	$id_del_tag='1083';
	break;
	case *prima infanzia*:
	$id_del_tag='1084';
	break;
	case *aborto terapeutico*:
	$id_del_tag='1092';
	break;
	case *malattia professionale*:
	$id_del_tag='1099';
	break;
	case *alcolismo*:
	$id_del_tag='1100';
	break;
	case *sostanza psicotropa*:
	$id_del_tag='1101';
	break;
	case *stupefacente*:
	$id_del_tag='1101';
	break;
	case *trapianto di organi*:
	$id_del_tag='1113';
	break;
	case *malattia*:
	$id_del_tag='1118';
	break;
	case *cancro*:
	$id_del_tag='1122';
	break;
	case *malattia infettiva*:
	$id_del_tag='1123';
	break;
	case *certificato sanitario*:
	$id_del_tag='0';
	break;
	case *chirurgo*:
	$id_del_tag='1137';
	break;
	case *medico*:
	$id_del_tag='1137';
	break;
	case *veterinario*:
	$id_del_tag='1144';
	break;
	case *prevenzione degli infortuni*:
	$id_del_tag='1153';
	break;
	case *dispositivo di guida*:
	$id_del_tag='1155';
	break;
	case *incendio*:
	$id_del_tag='1156';
	break;
	case *lotta contro gli incendi*:
	$id_del_tag='1156';
	break;
	case *sistema sanitario*:
	$id_del_tag='1161';
	break;
	case *servizio sanitario*:
	$id_del_tag='1161';
	break;
	case *assistenza ospedaliera*:
	$id_del_tag='1162';
	break;
	case *assistenza sanitaria integrativa*:
	$id_del_tag='1162';
	break;
	case *animale domestico*:
	$id_del_tag='1173';
	break;
	case *ministro*:
	$id_del_tag='1182';
	break;
	case *giudici della giurisdizione penale*:
	$id_del_tag='1209';
	break;
	case *giudice*:
	$id_del_tag='1209';
	break;
	case *avvocati e procuratori dello stato*:
	$id_del_tag='1218';
	break;
	case *avvocato*:
	$id_del_tag='1218';
	break;
	case *magistrato*:
	$id_del_tag='1221';
	break;
	case *notaio*:
	$id_del_tag='1224';
	break;
	case *procedura penale*:
	$id_del_tag='1233';
	break;
	case *procedura giudiziaria*:
	$id_del_tag='1233';
	break;
	case *commissione permanente*:
	$id_del_tag='1234';
	break;
	case *commissione parlamentare per l' indirizzo generale e la vigilanza dei servizi radiotelevisivi*:
	$id_del_tag='1234';
	break;
	case *commissione parlamentare di vigilanza rai*:
	$id_del_tag='1234';
	break;
	case *commissione parlamentare per le questioni regionali*:
	$id_del_tag='1234';
	break;
	case *commissione speciale*:
	$id_del_tag='1234';
	break;
	case *commissione parlamentare*:
	$id_del_tag='1234';
	break;
	case *commissioni bicamerali*:
	$id_del_tag='1234';
	break;
	case *commissione d'inchiesta*:
	$id_del_tag='1236';
	break;
	case *deputati*:
	$id_del_tag='1237';
	break;
	case *parlamentare*:
	$id_del_tag='1237';
	break;
	case *risoluzione*:
	$id_del_tag='1244';
	break;
	case *radiotrasmissioni*:
	$id_del_tag='1260';
	break;
	case *programma audiovisivo*:
	$id_del_tag='1261';
	break;
	case *produzione vegetale*:
	$id_del_tag='1265';
	break;
	case *frutticoltura*:
	$id_del_tag='1266';
	break;
	case *orticoltura*:
	$id_del_tag='1266';
	break;
	case *cerealicoltura*:
	$id_del_tag='1266';
	break;
	case *produzione agricola*:
	$id_del_tag='1266';
	break;
	case *coltura orticola*:
	$id_del_tag='1266';
	break;
	case *settore agricolo*:
	$id_del_tag='1266';
	break;
	case *produzione e trasformazione agricola*:
	$id_del_tag='1266';
	break;
	case *ortaggi*:
	$id_del_tag='1267';
	break;
	case *frutto*:
	$id_del_tag='1267';
	break;
	case *prodotto agricolo*:
	$id_del_tag='1267';
	break;
	case *ortaggio a semi*:
	$id_del_tag='1267';
	break;
	case *prodotti ortofrutticoli*:
	$id_del_tag='1267';
	break;
	case *cereali*:
	$id_del_tag='1267';
	break;
	case *fumo e prodotti da fumo*:
	$id_del_tag='1273';
	break;
	case *azienda agricola familiare*:
	$id_del_tag='1277';
	break;
	case *azienda agricola*:
	$id_del_tag='1277';
	break;
	case *foresta*:
	$id_del_tag='1281';
	break;
	case *area boscata*:
	$id_del_tag='1281';
	break;
	case *terreno boschivo*:
	$id_del_tag='1281';
	break;
	case *imboschimento*:
	$id_del_tag='1282';
	break;
	case *coltivatore*:
	$id_del_tag='1284';
	break;
	case *macellazione di animali*:
	$id_del_tag='1286';
	break;
	case *periodo di pesca*:
	$id_del_tag='1288';
	break;
	case *pesca costiera*:
	$id_del_tag='1288';
	break;
	case *gestione della pesca*:
	$id_del_tag='1288';
	break;
	case *pesca*:
	$id_del_tag='1288';
	break;
	case *pesca marittima*:
	$id_del_tag='1288';
	break;
	case *pescatore*:
	$id_del_tag='1291';
	break;
	case *prodotto della pesca*:
	$id_del_tag='1292';
	break;
	case *formaggio*:
	$id_del_tag='1294';
	break;
	case *formaggio fresco*:
	$id_del_tag='1294';
	break;
	case *latte crudo*:
	$id_del_tag='1294';
	break;
	case *prodotti lattiero caseari*:
	$id_del_tag='1294';
	break;
	case *ministero*:
	$id_del_tag='0';
	break;
	case *acque*:
	$id_del_tag='1302';
	break;
	case *ricorso in appello in materia penale*:
	$id_del_tag='1305';
	break;
	case *ricorso in cassazione in materia penale*:
	$id_del_tag='1305';
	break;
	case *ricorso in cassazione in materia civile*:
	$id_del_tag='1305';
	break;
	case *documento d'identita'*:
	$id_del_tag='1307';
	break;
	case *sovrintendenti di polizia*:
	$id_del_tag='1320';
	break;
	case *agenti di polizia*:
	$id_del_tag='1320';
	break;
	case *polizia*:
	$id_del_tag='1325';
	break;
	case *corpo delle guardie di pubblica sicurezza*:
	$id_del_tag='1325';
	break;
	case *forze di polizia*:
	$id_del_tag='1325';
	break;
	case *corpo di polizia penitenziaria*:
	$id_del_tag='1327';
	break;
	case *agenti di polizia penitenziaria*:
	$id_del_tag='1327';
	break;
	case *gara d'appalto*:
	$id_del_tag='1334';
	break;
	case *aggiudicazione d'appalto*:
	$id_del_tag='1334';
	break;
	case *presentazione dell'offerta d'appalto*:
	$id_del_tag='1334';
	break;
	case *appalto pubblico*:
	$id_del_tag='1334';
	break;
	case *grandi opere pubbliche*:
	$id_del_tag='1335';
	break;
	case *bene comunale*:
	$id_del_tag='1344';
	break;
	case *bene culturale*:
	$id_del_tag='1360';
	break;
	case *ente pubblico territoriale*:
	$id_del_tag='1362';
	break;
	case *ente regionale*:
	$id_del_tag='1362';
	break;
	case *ente pubblico*:
	$id_del_tag='1362';
	break;
	case *enti di sviluppo*:
	$id_del_tag='1362';
	break;
	case *procedura amministrativa*:
	$id_del_tag='1372';
	break;
	case *ricorso amministrativo*:
	$id_del_tag='1388';
	break;
	case *concessione di servizi*:
	$id_del_tag='1394';
	break;
	case *concessionario*:
	$id_del_tag='1396';
	break;
	case *denuncia rapporto e referto*:
	$id_del_tag='0';
	break;
	case *servizio pubblico*:
	$id_del_tag='1407';
	break;
	case *dipartimento*:
	$id_del_tag='1416';
	break;
	case *ente locale*:
	$id_del_tag='1422';
	break;
	case *comune*:
	$id_del_tag='1425';
	break;
	case *provincia*:
	$id_del_tag='1439';
	break;
	case *regione*:
	$id_del_tag='1450';
	break;
	case *accesso al pubblico impiego*:
	$id_del_tag='1461';
	break;
	case *funzionario*:
	$id_del_tag='0';
	break;
	case *dirigenti e primi dirigenti*:
	$id_del_tag='1485';
	break;
	case *dirigenti superiori*:
	$id_del_tag='1485';
	break;
	case *contratti dello stato e degli enti pubblici*:
	$id_del_tag='1492';
	break;
	case *eta' per l'accesso al pubblico impiego*:
	$id_del_tag='1492';
	break;
	case *incompatibilita' nel pubblico impiego*:
	$id_del_tag='1492';
	break;
	case *doveri nel pubblico impiego*:
	$id_del_tag='1492';
	break;
	case *trattamento previdenziale nel pubblico impiego*:
	$id_del_tag='1492';
	break;
	case *sanzioni disciplinari nel pubblico impiego*:
	$id_del_tag='1492';
	break;
	case *trattamento economico nel pubblico impiego*:
	$id_del_tag='1492';
	break;
	case *responsabilita' amministrativa*:
	$id_del_tag='1496';
	break;
	case *concorso amministrativo*:
	$id_del_tag='1499';
	break;
	case *commissioni di esame*:
	$id_del_tag='1513';
	break;
	case *confessioni religiose*:
	$id_del_tag='1517';
	break;
	case *cappellani*:
	$id_del_tag='1519';
	break;
	case *chiesa*:
	$id_del_tag='1519';
	break;
	case *musulmano*:
	$id_del_tag='1522';
	break;
	case *casa editrice*:
	$id_del_tag='1525';
	break;
	case *base di dati*:
	$id_del_tag='0';
	break;
	case *commercio al minuto*:
	$id_del_tag='1537';
	break;
	case *centro commerciale*:
	$id_del_tag='1539';
	break;
	case *intervento sul mercato*:
	$id_del_tag='0';
	break;
	case *interventi sul mercato*:
	$id_del_tag='0';
	break;
	case *acquisto*:
	$id_del_tag='0';
	break;
	case *esportazione*:
	$id_del_tag='1557';
	break;
	case *importazione*:
	$id_del_tag='1558';
	break;
	case *paese meno sviluppato*:
	$id_del_tag='1561';
	break;
	case *paese in via di sviluppo*:
	$id_del_tag='1561';
	break;
	case *piano di sviluppo*:
	$id_del_tag='1565';
	break;
	case *privatizzazione*:
	$id_del_tag='1566';
	break;
	case *prezzo*:
	$id_del_tag='1567';
	break;
	case *sorveglianza dei prezzi*:
	$id_del_tag='1568';
	break;
	case *ristrutturazione industriale*:
	$id_del_tag='1572';
	break;
	case *riconversione industriale*:
	$id_del_tag='1572';
	break;
	case *cooperativa*:
	$id_del_tag='1577';
	break;
	case *societa' cooperative*:
	$id_del_tag='1577';
	break;
	case *accordo tra imprese*:
	$id_del_tag='1578';
	break;
	case *impresa*:
	$id_del_tag='1578';
	break;
	case *acquisizione d'impresa*:
	$id_del_tag='1578';
	break;
	case *ammodernamento di impresa*:
	$id_del_tag='1578';
	break;
	case *camera di commercio*:
	$id_del_tag='1581';
	break;
	case *impresa privata*:
	$id_del_tag='1582';
	break;
	case *impresa pubblica*:
	$id_del_tag='1584';
	break;
	case *impresa estera*:
	$id_del_tag='1587';
	break;
	case *imprenditore*:
	$id_del_tag='1590';
	break;
	case *impresa artigiana*:
	$id_del_tag='1591';
	break;
	case *azienda commerciale*:
	$id_del_tag='1593';
	break;
	case *impresa commerciale*:
	$id_del_tag='1593';
	break;
	case *impresa industriale*:
	$id_del_tag='1594';
	break;
	case *grande impresa*:
	$id_del_tag='1595';
	break;
	case *elezioni locali*:
	$id_del_tag='1600';
	break;
	case *elezione regionale*:
	$id_del_tag='1603';
	break;
	case *migrazione di ritorno*:
	$id_del_tag='1604';
	break;
	case *migrazione*:
	$id_del_tag='1604';
	break;
	case *migrazione familiare*:
	$id_del_tag='1604';
	break;
	case *migrante*:
	$id_del_tag='1604';
	break;
	case *deportato*:
	$id_del_tag='0';
	break;
	case *parlamento nazionale*:
	$id_del_tag='1618';
	break;
	case *parlamento*:
	$id_del_tag='1618';
	break;
	case *partito politico*:
	$id_del_tag='1622';
	break;
	case *politica internazionale*:
	$id_del_tag='1624';
	break;
	case *ecosistema terrestre*:
	$id_del_tag='1629';
	break;
	case *ecosistema*:
	$id_del_tag='1629';
	break;
	case *lotta contro l'inquinamento*:
	$id_del_tag='1633';
	break;
	case *degradazione dell'ambiente*:
	$id_del_tag='1633';
	break;
	case *agente inquinante dell'atmosfera*:
	$id_del_tag='1635';
	break;
	case *disturbo elettromagnetico*:
	$id_del_tag='1636';
	break;
	case *inquinamento idrico*:
	$id_del_tag='1638';
	break;
	case *chimica nucleare*:
	$id_del_tag='1644';
	break;
	case *chimica secondaria*:
	$id_del_tag='1644';
	break;
	case *benessere degli animali*:
	$id_del_tag='1649';
	break;
	case *insetto*:
	$id_del_tag='1650';
	break;
	case *isola*:
	$id_del_tag='1655';
	break;
	case *ambiente marino*:
	$id_del_tag='1657';
	break;
	case *fondale marino*:
	$id_del_tag='1657';
	break;
	case *ecosistema marino*:
	$id_del_tag='1657';
	break;
	case *montagna*:
	$id_del_tag='1658';
	break;
	case *bacini imbriferi montani*:
	$id_del_tag='1660';
	break;
	case *lago*:
	$id_del_tag='1663';
	break;
	case *astronomia*:
	$id_del_tag='1667';
	break;
	case *donna*:
	$id_del_tag='1674';
	break;
	case *anziano*:
	$id_del_tag='1676';
	break;
	case *giovane*:
	$id_del_tag='1677';
	break;
	case *sondaggio*:
	$id_del_tag='1679';
	break;
	case *assegnazione di alloggio*:
	$id_del_tag='1684';
	break;
	case *forme economiche di assistenza*:
	$id_del_tag='1685';
	break;
	case *servizio sociale*:
	$id_del_tag='1686';
	break;
	case *indennizzo*:
	$id_del_tag='1692';
	break;
	case *pensionato*:
	$id_del_tag='1749';
	break;
	case *agenti di assicurazione*:
	$id_del_tag='1760';
	break;
	case *assicurazione a favore della famiglia e dei superstiti*:
	$id_del_tag='1760';
	break;
	case *compagnia d'assicurazioni*:
	$id_del_tag='1760';
	break;
	case *premio d'assicurazione*:
	$id_del_tag='1762';
	break;
	case *assicurazione danni*:
	$id_del_tag='1764';
	break;
	case *assicurazione privata*:
	$id_del_tag='1765';
	break;
	case *aumento dei prezzi*:
	$id_del_tag='1781';
	break;
	case *riserve valutarie*:
	$id_del_tag='1787';
	break;
	case *banca centrale*:
	$id_del_tag='1788';
	break;
	case *banca popolare*:
	$id_del_tag='1789';
	break;
	case *deposito bancario*:
	$id_del_tag='1792';
	break;
	case *bandiera*:
	$id_del_tag='0';
	break;
	case *archivio*:
	$id_del_tag='1805';
	break;
	case *camper*:
	$id_del_tag='1811';
	break;
	case *veicolo da campeggio*:
	$id_del_tag='1811';
	break;
	case *segnaletica*:
	$id_del_tag='1824';
	break;
	case *distributore automatico*:
	$id_del_tag='1825';
	break;
	case *pedaggio*:
	$id_del_tag='0';
	break;
	case *trasporto aereo*:
	$id_del_tag='1829';
	break;
	case *aeroporto*:
	$id_del_tag='1830';
	break;
	case *trasporto stradale*:
	$id_del_tag='1833';
	break;
	case *carrozze e carri ferroviari*:
	$id_del_tag='1843';
	break;
	case *trasporto marittimo*:
	$id_del_tag='1850';
	break;
	case *cabotaggio marittimo*:
	$id_del_tag='1850';
	break;
	case *comunita' europea*:
	$id_del_tag='1851';
	break;
	case *decisione ce*:
	$id_del_tag='1852';
	break;
	case *direttiva comunitaria*:
	$id_del_tag='1853';
	break;
	case *direttiva ce*:
	$id_del_tag='1853';
	break;
	case *trattato sull'unione europea*:
	$id_del_tag='1854';
	break;
	case *corte di giustizia ce*:
	$id_del_tag='1855';
	break;
	case *urbanistica*:
	$id_del_tag='1861';
	break;
	case *case albergo dormitori e ostelli*:
	$id_del_tag='1868';
	break;
	case *strutture di cura di tipo ospedaliero*:
	$id_del_tag='1877';
	break;
	case *cliniche e case di cura*:
	$id_del_tag='1877';
	break;
	case *cliniche e policlinici universitari*:
	$id_del_tag='1877';
	break;
	case *istituto ospedaliero*:
	$id_del_tag='1877';
	break;
	case *ospedale mauriziano di torino*:
	$id_del_tag='1877';
	break;
	case *monumento*:
	$id_del_tag='1882';
	break;
	case *edificio pubblico*:
	$id_del_tag='1883';
	break;
	case *progettazione di un prodotto*:
	$id_del_tag='0';
	break;
	case *cimitero*:
	$id_del_tag='1895';
	break;
	case *terreno industriale*:
	$id_del_tag='0';
	break;
	case *riserva naturale*:
	$id_del_tag='1899';
	break;
	case *parco nazionale*:
	$id_del_tag='1899';
	break;
	case *agglomerato urbano*:
	$id_del_tag='1906';
	break;
	case *agglomerato*:
	$id_del_tag='1906';
	break;
	case *suolo edificativo*:
	$id_del_tag='1907';
	break;
	case *regione agricola*:
	$id_del_tag='1908';
	break;
	case *regione industriale*:
	$id_del_tag='1909';
	break;
	case *giorno festivo*:
	$id_del_tag='1911';
	break;
	case *commemorazione*:
	$id_del_tag='1912';
	break;
	case *nutrizione*:
	$id_del_tag='1983';
	break;
	case *croce rossa*:
	$id_del_tag='2167';
	break;
	case *corpo militare della croce rossa italiana ( cri )*:
	$id_del_tag='2167';
	break;
	case *prima guerra mondiale*:
	$id_del_tag='2224';
	break;
	case *seconda guerra mondiale*:
	$id_del_tag='2225';
	break;
	case *mar mediterraneo*:
	$id_del_tag='2250';
	break;
	case *giochi olimpici*:
	$id_del_tag='2259';
	break;
	case *nato*:
	$id_del_tag='2260';
	break;
	case *onu*:
	$id_del_tag='2261';
	break;
	case *ORGANIZZAZIONE DELLE NAZIONI UNITE ( ONU )*:
	$id_del_tag='2261';
	break;
	case *risoluzione onu*:
	$id_del_tag='2261';
	break;
	case *assegno*:
	$id_del_tag='0';
	break;
	case *assegno*:
	$id_del_tag='0';
	break;
	case *libretto sanitario*:
	$id_del_tag='1161';
	break;
	case *manodopera*:
	$id_del_tag='990';
	break;
	case *congedo per malattia*:
	$id_del_tag='1009';
	break;
	case *impresa in difficolta'*:
	$id_del_tag='6515';
	break;
	case *corso d'acqua*:
	$id_del_tag='1662';
	break;
	case *prezzo dell'energia*:
	$id_del_tag='4536';
	break;
	case *istituti ed enti mutualistici e previdenziali*:
	$id_del_tag='1760';
	break;
	case *organizzazione sportiva*:
	$id_del_tag='23';
	break;
	case *malattia mentale*:
	$id_del_tag='1118';
	break;
	case *contratto di locazione*:
	$id_del_tag='4955';
	break;
	case *zona agricola svantaggiata*:
	$id_del_tag='1908';
	break;
	case *regione montana*:
	$id_del_tag='1423';
	break;
	case *organizzazione culturale*:
	$id_del_tag='664';
	break;
	case *lingua straniera*:
	$id_del_tag='1056';
	break;
	case *contributo sociale*:
	$id_del_tag='0';
	break;
	case *consumatore*:
	$id_del_tag='1542';
	break;
	case *gas raro*:
	$id_del_tag='785';
	break;
	case *posizione comune*:
	$id_del_tag='0';
	break;
	case *esplorazione petrolifera*:
	$id_del_tag='5760';
	break;
	case *trasporto collettivo*:
	$id_del_tag='1822';
	break;
	case *discarica abusiva*:
	$id_del_tag='814';
	break;
	case *disastro naturale*:
	$id_del_tag='4484';
	break;
	case *licenza di brevetto*:
	$id_del_tag='264';
	break;
	case *associazione professionale*:
	$id_del_tag='1002';
	break;
	case *biotecnologia*:
	$id_del_tag='2307';
	break;
	case *ministero delle infrastrutture*:
	$id_del_tag='2328';
	break;
	case *contraffazione*:
	$id_del_tag='2370';
	break;
	case *patto di stabilita'*:
	$id_del_tag='2375';
	break;
	case *ministero dell' ambiente e della tutela del territorio e del mare*:
	$id_del_tag='2406';
	break;
	case *mar adriatico*:
	$id_del_tag='2411';
	break;
	case *apparecchio televisivo*:
	$id_del_tag='4245';
	break;
	case *liberta' d'associazione*:
	$id_del_tag='4251';
	break;
	case *contabilita' pubblica*:
	$id_del_tag='4252';
	break;
	case *contabilita' generale*:
	$id_del_tag='4252';
	break;
	case *contabilita' nazionale*:
	$id_del_tag='4252';
	break;
	case *impresa di trasporto*:
	$id_del_tag='4255';
	break;
	case *regolamento ce*:
	$id_del_tag='4275';
	break;
	case *dogana*:
	$id_del_tag='4280';
	break;
	case *gioco*:
	$id_del_tag='0';
	break;
	case *finanze internazionali*:
	$id_del_tag='4287';
	break;
	case *competenza per territorio*:
	$id_del_tag='0';
	break;
	case *tirocinio*:
	$id_del_tag='0';
	break;
	case *aggressione fisica*:
	$id_del_tag='4319';
	break;
	case *abitazione individuale*:
	$id_del_tag='4354';
	break;
	case *questione della casa*:
	$id_del_tag='4354';
	break;
	case *immobili per abitazione*:
	$id_del_tag='4354';
	break;
	case *aliquote di imposte*:
	$id_del_tag='4357';
	break;
	case *addizionale di imposte*:
	$id_del_tag='4357';
	break;
	case *esazione delle imposte*:
	$id_del_tag='4357';
	break;
	case *acque di vegetazione e di scarico*:
	$id_del_tag='4379';
	break;
	case *accesso all'occupazione*:
	$id_del_tag='4387';
	break;
	case *mafia*:
	$id_del_tag='4434';
	break;
	case *emissione monetaria*:
	$id_del_tag='4440';
	break;
	case *convertibilita' monetaria*:
	$id_del_tag='4440';
	break;
	case *area monetaria*:
	$id_del_tag='4440';
	break;
	case *cambio di valuta*:
	$id_del_tag='4440';
	break;
	case *sistema monetario aureo*:
	$id_del_tag='4440';
	break;
	case *piccole e medie industrie*:
	$id_del_tag='4448';
	break;
	case *piccola industria*:
	$id_del_tag='4448';
	break;
	case *piccola impresa*:
	$id_del_tag='4448';
	break;
	case *islamismo*:
	$id_del_tag='4458';
	break;
	case *titoli professionali*:
	$id_del_tag='4465';
	break;
	case *riconoscimento delle qualifiche professionali*:
	$id_del_tag='4465';
	break;
	case *prodotto a base di carne*:
	$id_del_tag='4495';
	break;
	case *abbuono d'interesse*:
	$id_del_tag='4533';
	break;
	case *evasioni fiscali*:
	$id_del_tag='4542';
	break;
	case *evasioni contributive*:
	$id_del_tag='4542';
	break;
	case *circolazione stradale*:
	$id_del_tag='4556';
	break;
	case *strade*:
	$id_del_tag='4556';
	break;
	case *ispezioni sanitarie*:
	$id_del_tag='4567';
	break;
	case *diritti dell'uomo*:
	$id_del_tag='4585';
	break;
	case *impianti nucleari*:
	$id_del_tag='4599';
	break;
	case *qualita' dell'ambiente*:
	$id_del_tag='4630';
	break;
	case *tutela dei beni culturali e ambientali*:
	$id_del_tag='4630';
	break;
	case *protezione del paesaggio*:
	$id_del_tag='4630';
	break;
	case *tutela del paesaggio*:
	$id_del_tag='4630';
	break;
	case *assistenza allo sviluppo*:
	$id_del_tag='4653';
	break;
	case *sorveglianza dell'ambiente*:
	$id_del_tag='4666';
	break;
	case *impresa transnazionale*:
	$id_del_tag='4687';
	break;
	case *agevolazioni pubbliche*:
	$id_del_tag='4690';
	break;
	case *attivita' amministrativa*:
	$id_del_tag='4694';
	break;
	case *biblioteca nazionale centrale di firenze*:
	$id_del_tag='4698';
	break;
	case *biblioteca nazionale centrale di roma*:
	$id_del_tag='4698';
	break;
	case *fondi e finanziamenti comunitari*:
	$id_del_tag='4740';
	break;
	case *fondo ce*:
	$id_del_tag='4740';
	break;
	case *assistenza scolastica*:
	$id_del_tag='4756';
	break;
	case *orientamento scolastico e professionale*:
	$id_del_tag='4756';
	break;
	case *calendario scolastico*:
	$id_del_tag='4756';
	break;
	case *adattamento scolastico*:
	$id_del_tag='4756';
	break;
	case *frequenza scolastica*:
	$id_del_tag='4756';
	break;
	case *rendimento scolastico*:
	$id_del_tag='4756';
	break;
	case *organizzazione scolastica*:
	$id_del_tag='4756';
	break;
	case *amministrazione scolastica*:
	$id_del_tag='4756';
	break;
	case *uffici scolastici*:
	$id_del_tag='4756';
	break;
	case *programma scolastico*:
	$id_del_tag='4756';
	break;
	case *consigli scolastici*:
	$id_del_tag='4756';
	break;
	case *ambiente scolastico*:
	$id_del_tag='4756';
	break;
	case *programmi e corsi scolastici*:
	$id_del_tag='4756';
	break;
	case *manuale scolastico*:
	$id_del_tag='4756';
	break;
	case *struttura scolastica*:
	$id_del_tag='4756';
	break;
	case *corsi scolastici di recupero e sostegno*:
	$id_del_tag='4756';
	break;
	case *agenzia nazionale per lo sviluppo dell' autonomia scolastica*:
	$id_del_tag='4756';
	break;
	case *programmi scolastici*:
	$id_del_tag='4756';
	break;
	case *autonomia scolastica*:
	$id_del_tag='4756';
	break;
	case *risultato scolastico*:
	$id_del_tag='4756';
	break;
	case *diritti di prelazione*:
	$id_del_tag='4781';
	break;
	case *ricerca*:
	$id_del_tag='4791';
	break;
	case *abrogazione di norme*:
	$id_del_tag='4798';
	break;
	case *controllo sulla esecuzione del bilancio*:
	$id_del_tag='4808';
	break;
	case *discriminazione basata sulle tendenze sessuali*:
	$id_del_tag='4888';
	break;
	case *prodotto nazionale*:
	$id_del_tag='4897';
	break;
	case *elaborazione del diritto comunitario*:
	$id_del_tag='4932';
	break;
	case *applicazione del diritto comunitario*:
	$id_del_tag='4932';
	break;
	case *diritto dell' unione europea*:
	$id_del_tag='4932';
	break;
	case *industria delle comunicazioni*:
	$id_del_tag='4933';
	break;
	case *locazione*:
	$id_del_tag='4955';
	break;
	case *locazione di immobili*:
	$id_del_tag='4955';
	break;
	case *locazione e affitto*:
	$id_del_tag='4955';
	break;
	case *affittanza*:
	$id_del_tag='4955';
	break;
	case *agevolazioni affitto casa*:
	$id_del_tag='4955';
	break;
	case *retribuzione*:
	$id_del_tag='4961';
	break;
	case *retribuzione mensile*:
	$id_del_tag='4961';
	break;
	case *vaccino*:
	$id_del_tag='4984';
	break;
	case *costruzioni rurali*:
	$id_del_tag='5022';
	break;
	case *competenza dei giudici*:
	$id_del_tag='5101';
	break;
	case *industria edilizia*:
	$id_del_tag='5118';
	break;
	case *accordo economico*:
	$id_del_tag='0';
	break;
	case *handicappati*:
	$id_del_tag='5132';
	break;
	case *handicappato fisico*:
	$id_del_tag='5132';
	break;
	case *agevolazioni per handicappati*:
	$id_del_tag='5132';
	break;
	case *produzione d'energia*:
	$id_del_tag='5152';
	break;
	case *carta europea*:
	$id_del_tag='5185';
	break;
	case *liberta' della persona*:
	$id_del_tag='5186';
	break;
	case *patente*:
	$id_del_tag='5202';
	break;
	case *diritto penale militare di pace*:
	$id_del_tag='5208';
	break;
	case *computers*:
	$id_del_tag='5245';
	break;
	case *tutela dei consumatori e degli utenti*:
	$id_del_tag='5247';
	break;
	case *prodotto energetico*:
	$id_del_tag='5264';
	break;
	case *produzione cinematografica*:
	$id_del_tag='5288';
	break;
	case *autonomia amministrativa patrimoniale e contabile*:
	$id_del_tag='5304';
	break;
	case *proposta di legge*:
	$id_del_tag='5315';
	break;
	case *fattore produttivo*:
	$id_del_tag='0';
	break;
	case *prodotti ittici*:
	$id_del_tag='5336';
	break;
	case *pesce di mare*:
	$id_del_tag='5336';
	break;
	case *societa' senza fini di lucro*:
	$id_del_tag='5384';
	break;
	case *anzianita' figurativa*:
	$id_del_tag='5387';
	break;
	case *cumulo di pensioni*:
	$id_del_tag='5388';
	break;
	case *lavoratori autonomi*:
	$id_del_tag='5389';
	break;
	case *liberta' d'opinione*:
	$id_del_tag='5431';
	break;
	case *lotta contro la criminalita'*:
	$id_del_tag='5436';
	break;
	case *lotta contro la delinquenza*:
	$id_del_tag='5436';
	break;
	case *farmacologia e terapia*:
	$id_del_tag='5506';
	break;
	case *equipaggiamento del veicolo*:
	$id_del_tag='5532';
	break;
	case *liquidazione di imprese*:
	$id_del_tag='5595';
	break;
	case *volatili*:
	$id_del_tag='5606';
	break;
	case *opposizione*:
	$id_del_tag='5611';
	break;
	case *riforma della pac*:
	$id_del_tag='5632';
	break;
	case *tutela della fauna*:
	$id_del_tag='5676';
	break;
	case *riciclaggio finanziario*:
	$id_del_tag='5732';
	break;
	case *riciclaggio di capitali*:
	$id_del_tag='5732';
	break;
	case *additivi chimici*:
	$id_del_tag='5734';
	break;
	case *petrolio greggio*:
	$id_del_tag='5760';
	break;
	case *aiuti ai poveri*:
	$id_del_tag='5767';
	break;
	case *agglomerato rurale*:
	$id_del_tag='5773';
	break;
	case *accertamenti fiscali*:
	$id_del_tag='5779';
	break;
	case *ecclesiastici e ministri del culto*:
	$id_del_tag='5805';
	break;
	case *prodotto lattiero-caseario*:
	$id_del_tag='5813';
	break;
	case *abbigliamento e confezioni*:
	$id_del_tag='5917';
	break;
	case *capitali di rischio*:
	$id_del_tag='5929';
	break;
	case *ripresa economica*:
	$id_del_tag='5977';
	break;
	case *consumo interno*:
	$id_del_tag='5980';
	break;
	case *commercio con l' estero*:
	$id_del_tag='5985';
	break;
	case *selvaggina*:
	$id_del_tag='5986';
	break;
	case *politica d'intervento*:
	$id_del_tag='5995';
	break;
	case *reinserimento professionale*:
	$id_del_tag='6036';
	break;
	case *riconversione professionale*:
	$id_del_tag='6036';
	break;
	case *biglietti di viaggio*:
	$id_del_tag='6049';
	break;
	case *agevolazioni di viaggio*:
	$id_del_tag='6049';
	break;
	case *viaggiatore*:
	$id_del_tag='6049';
	break;
	case *produzione audiovisiva*:
	$id_del_tag='6063';
	break;
	case *materiale elettrico*:
	$id_del_tag='0';
	break;
	case *agenti di commercio*:
	$id_del_tag='6091';
	break;
	case *esami di abilitazione*:
	$id_del_tag='6106';
	break;
	case *abilitazione all'  insegnamento*:
	$id_del_tag='6106';
	break;
	case *diritto sociale*:
	$id_del_tag='0';
	break;
	case *tutela della riservatezza*:
	$id_del_tag='6146';
	break;
	case *centri di permanenza temporanea ( cpt )*:
	$id_del_tag='6171';
	break;
	case *part time femminile*:
	$id_del_tag='6191';
	break;
	case *manodopera femminile*:
	$id_del_tag='6191';
	break;
	case *corpo forestale dello stato*:
	$id_del_tag='6199';
	break;
	case *l'energia e l' ambiente ( enea )*:
	$id_del_tag='6225';
	break;
	case *ministero dell' economia e delle finanze*:
	$id_del_tag='6254';
	break;
	case *autorita' garante della concorrenza e del mercato*:
	$id_del_tag='6258';
	break;
	case *alimenti per il bestiame*:
	$id_del_tag='6401';
	break;
	case *operaio qualificato*:
	$id_del_tag='6510';
	break;
	case *congedo di paternita'*:
	$id_del_tag='6522';
	break;
	case *fondo unico per lo spettacolo*:
	$id_del_tag='6525';
	break;
	case *stato assistenziale*:
	$id_del_tag='6608';
	break;
	case *difesa e sicurezza internazionale*:
	$id_del_tag='6627';
	break;
	case *tecnologia alimentare*:
	$id_del_tag='6633';
	break;
	case *industria alimentare*:
	$id_del_tag='6633';
	break;
	case *produzione alimentare*:
	$id_del_tag='6633';
	break;
	case *agroindustria*:
	$id_del_tag='6633';
	break;
	case *prodotto industriale*:
	$id_del_tag='6657';
	break;
	case *prodotti industriali*:
	$id_del_tag='6657';
	break;
	case *industria dei colori*:
	$id_del_tag='6670';
	break;
	case *prodotti del legno*:
	$id_del_tag='708';
	break;
	case *procedure di approvazione della legge*:
	$id_del_tag='6734';
	break;
	case *popolazione attiva*:
	$id_del_tag='0';
	break;
	case *aggiustamento monetario*:
	$id_del_tag='6780';
	break;
	case *questioni monetarie e valutarie*:
	$id_del_tag='6780';
	break;
	case *aeroporto di punta raisi*:
	$id_del_tag='6836';
	break;
	case *trattato ce*:
	$id_del_tag='6879';
	break;
	case *diritto d' autore*:
	$id_del_tag='6894';
	break;
	case *industria cinematografica*:
	$id_del_tag='6899';
	break;
	case *accesso all'informazione*:
	$id_del_tag='6943';
	break;
	case *belle arti*:
	$id_del_tag='0';
	break;
	case *reati contro l' economia e il commercio*:
	$id_del_tag='6972';
	break;
	case *moneta europea o euro*:
	$id_del_tag='6987';
	break;
	case *assicurazione obbligatoria contro le malattie*:
	$id_del_tag='7010';
	break;
	case *assicurazione obbligatoria contro gli infortuni sul lavoro e le  malattie professionali*:
	$id_del_tag='7010';
	break;
	case *produzione di latte*:
	$id_del_tag='7065';
	break;
	case *cemento*:
	$id_del_tag='7098';
	break;
	case *autorita' per l' energia elettrica ed il gas*:
	$id_del_tag='7141';
	break;
	case *organismo comunitario*:
	$id_del_tag='7162';
	break;
	case *parrucchiere e cure estetiche*:
	$id_del_tag='7232';
	break;
	case *obiezione di coscienza del sanitario*:
	$id_del_tag='7250';
	break;
	case *esplosivo*:
	$id_del_tag='7262';
	break;
	case *sostegno agricolo*:
	$id_del_tag='7288';
	break;
	case *immigrati clandestini*:
	$id_del_tag='7304';
	break;
	case *migrazione illegale*:
	$id_del_tag='7304';
	break;
	case *organizzazione non governativa*:
	$id_del_tag='7313';
	break;
	case *organizzazioni non governative*:
	$id_del_tag='7313';
	break;
	case *impugnazione di pronunce penali*:
	$id_del_tag='0';
	break;
	case *impugnazione di pronunce civili*:
	$id_del_tag='0';
	break;
	case *ici*:
	$id_del_tag='7354';
	break;
	case *bse*:
	$id_del_tag='7375';
	break;
	case *licenziamento*:
	$id_del_tag='7380';
	break;
	case *sicurezza del posto di lavoro*:
	$id_del_tag='7386';
	break;
	case *rifondazione comunista*:
	$id_del_tag='7422';	
	break;
	
	// tag che hanno cambiato nome
	case *regolamento interno*:
	$id_del_tag='0';
	break;
	case *relazione culturale*:
	$id_del_tag='0';
	break;
	case *cattolicesimo*:
	$id_del_tag='6378';
	break;
	case *religione*:
	$id_del_tag='1517';
	break;
	case *repubblica sociale italiana ( rsi )*:
	$id_del_tag='0';
	break;
	case *rete ferroviaria italiana spa ( rfi )*:
	$id_del_tag='6253';
	break;
	case *rete di trasmissione*:
	$id_del_tag='5072';
	break;
	case *rete di trasporti*:
	$id_del_tag='6047';
	break;
	case *rete d'informazione*:
	$id_del_tag='5000';
	break;
	case *rete energetica*:
	$id_del_tag='5222';
	break;
	case *rete ferroviaria*:
	$id_del_tag='4374';
	break;
	case *rete informatica*:
	$id_del_tag='5376';
	break;
	case *rete stradale*:
	$id_del_tag='4556';
	break;
	case *ricevuta fiscale*:
	$id_del_tag='0';
	break;
	case *riforma gelmini*:
	$id_del_tag='2425';
	break;
	case *riforma amministrativa*:
	$id_del_tag='6676';
	break;
	case *riforma giudiziaria*:
	$id_del_tag='5588';
	break;
	case *riforma istituzionale*:
	$id_del_tag='5781';
	break;
	case *rifugiato politico*:
	$id_del_tag='5525';
	break;
	case *rimboschimento*:
	$id_del_tag='1282';
	break;
	case *rischio sanitario*:
	$id_del_tag='5261';
	break;
	case *risorsa economica*:
	$id_del_tag='0';
	break;
	case *salario*:
	$id_del_tag='1021';
	break;
	case *sanzione comunitaria*:
	$id_del_tag='7052';
	break;
	case *sanzione economica*:
	$id_del_tag='0';
	break;
	case *sanzione penale*:
	$id_del_tag='4598';
	break;
	case *casa savoia*:
	$id_del_tag='0';
	break;
	case *scambio commerciale*:
	$id_del_tag='0';
	break;
	case *scuola secondaria*:
	$id_del_tag='898';
	break;
	case *scuola secondaria superiore*:
	$id_del_tag='902';
	break;
	case *scuole di specializzazione per l'insegnamento secondario ( ssis )*:
	$id_del_tag='6370';
	break;
	case *segretario generale*:
	$id_del_tag='0';
	break;
	case *separazione legale*:
	$id_del_tag='6803';
	break;
	case *servizio segreto*:
	$id_del_tag='5001';
	break;
	case *servizio telefonico*:
	$id_del_tag='1262';
	break;
	case *servizio centrale degli ispettori tributari ( secit )*:
	$id_del_tag='6958';
	break;
	case *servizio per le informazioni e la sicurezza militare ( sismi )*:
	$id_del_tag='0';
	break;
	case *sistema statistico nazionale ( sistan )*:
	$id_del_tag='0';
	break;
	case *societa' a responsabilita' limitata*:
	$id_del_tag='260';
	break;
	case *societa' generale informatica ( sogei )*:
	$id_del_tag='6887';
	break;
	case *sogin*:
	$id_del_tag='6281';
	break;
	case *societa' italiana autori ed editori ( siae )*:
	$id_del_tag='2283';
	break;
	case *societa' per azioni*:
	$id_del_tag='262';
	break;
	case *sorveglianza marittima*:
	$id_del_tag='5179';
	break;
	case *sostegno di famiglia*:
	$id_del_tag='6192';
	break;
	case *specie protetta*:
	$id_del_tag='4503';
	break;
	case *usa*:
	$id_del_tag='7036';
	break;
	case *santa sede*:
	$id_del_tag='0';
	break;
	case *stato sociale*:
	$id_del_tag='6608';
	break;
	case *stazione ferroviaria*:
	$id_del_tag='5093';
	break;
	case *strage*:
	$id_del_tag='395';
	break;
	case *strumento finanziario*:
	$id_del_tag='6900';
	break;
	case *subappalto*:
	$id_del_tag='4468';
	break;
	case *suino*:
	$id_del_tag='5024';
	break;
	case *superstrada*:
	$id_del_tag='5769';
	break;
	case *svendita*:
	$id_del_tag='5421';
	break;
	case *tabacco*:
	$id_del_tag='1273';
	break;
	case *telecom italia mobile ( tim )*:
	$id_del_tag='6417';
	break;
	case *telecomunicazione*:
	$id_del_tag='5073';
	break;
	case *telecomunicazioni senza filo*:
	$id_del_tag='4803';
	break;
	case *telefono*:
	$id_del_tag='838';
	break;
	case *telefono mobile*:
	$id_del_tag='4797';
	break;
	case *terreno agricolo*:
	$id_del_tag='6121';
	break;
	case *terreno erboso*:
	$id_del_tag='0';
	break;
	case *questione del tibet*:
	$id_del_tag='6471';
	break;
	case *tirrenia di navigazione tirrenia*:
	$id_del_tag='7344';
	break;
	case *traffico urbano*:
	$id_del_tag='4735';
	break;
	case *trasfusioni*:
	$id_del_tag='1077';
	break;
	case *trasportatore*:
	$id_del_tag='5487';
	break;
	case *trasporto ad alta velocita'*:
	$id_del_tag='5320';
	break;
	case *trasporto ferroviario*:
	$id_del_tag='4376';
	break;
	case *trasporto internazionale*:
	$id_del_tag='6129';
	break;
	case *trasporto pubblico*:
	$id_del_tag='4377';
	break;
	case *trasporto regionale*:
	$id_del_tag='5799';
	break;
	case *trasporto scolastico*:
	$id_del_tag='7194';
	break;
	case *trasporto sotterraneo*:
	$id_del_tag='6422';
	break;
	case *trasporto terrestre*:
	$id_del_tag='6826';
	break;
	case *trattenute*:
	$id_del_tag='1025';
	break;
	case *treno alta velocita'  - tav*:
	$id_del_tag='7229';
	break;
	case *trivellazione*:
	$id_del_tag='0';
	break;
	case *truffa*:
	$id_del_tag='376';
	break;
	case *uccello*:
	$id_del_tag='5606';
	break;
	case *ufficiale giudiziario*:
	$id_del_tag='4403';
	break;
	case *ufficio notificazioni, esecuzioni e protesti ( unep )*:
	$id_del_tag='0';
	break;
	case *unione italiana delle camere di commercio, industria, agricoltura e artigianato ( unioncamere )*:
	$id_del_tag='6090';
	break;
	case *unione nazionale dei comuni, comunita' ed enti della montagna ( uncem )*:
	$id_del_tag='6103';
	break;
	case *unione nazionale per l' incremento delle razze equine ( unire )*:
	$id_del_tag='4278';
	break;
	case *vaccinazione*:
	$id_del_tag='4984';
	break;
	case *veicolo*:
	$id_del_tag='5532';
	break;
	case *veicolo a due ruote*:
	$id_del_tag='5648';
	break;
	case *veicolo a motore*:
	$id_del_tag='6686';
	break;
	case *veicolo industriale*:
	$id_del_tag='0';
	break;
	case *rirpistino viabilitá*:
	$id_del_tag='7314';
	break;
	case *viaggio*:
	$id_del_tag='0';
	break;
	case *vittima*:
	$id_del_tag='0';
	break;
	case *votazione*:
	$id_del_tag='5368';
	break;
	case *wind*:
	$id_del_tag='6306';
	break;
	case *zingaro*:
	$id_del_tag='4744';
	break;
	case *zona climatica*:
	$id_del_tag='0';
	break;
	case *regione di frontiera*:
	$id_del_tag='0';
	break;
	case *terreno demaniale*:
	$id_del_tag='5535';
	break;
	case *regione rurale*:
	$id_del_tag='5773';
	break;
	case *regione turistica*:
	$id_del_tag='0';
	break;
	case *zona franca*:
	$id_del_tag='5328';
	break;
	case *zona franca industriale*:
	$id_del_tag='6634';
	break;
	case *zona inquinata*:
	$id_del_tag='0';
	break;
	case *zona pedonale*:
	$id_del_tag='0';
	break;
	case *zona protetta*:
	$id_del_tag='0';
	break;
	case *zona sinistrata*:
	$id_del_tag='0';
	break;
	case *zona suburbana*:
	$id_del_tag='0';
	break;
	case *zona umida*:
	$id_del_tag='0';
	break;
	case *zona urbana*:
	$id_del_tag='0';
	break;
	case *isola di lampedusa*:
	$id_del_tag='7995';
	break;
	case *lampedusa*:
	$id_del_tag='7995';
	break;
	case *abruzzo*:
	$id_del_tag='7713';
	break;
	case *abruzzi*:
	$id_del_tag='7713';
	break;
	case *regione abruzzi*:
	$id_del_tag='7713';
	break;
	case *basilicata*:
	$id_del_tag='2113';
	break;
	case *calabria*:
	$id_del_tag='2118';
	break;
	case *campania*:
	$id_del_tag='2072';
	break;
	case *emilia romagna*:
	$id_del_tag='2001';
	break;
	case *emilia-romagna*:
	$id_del_tag='2001';
	break;
	case *friuli-venezia giulia*:
	$id_del_tag='1990';
	break;
	case *friuli venezia giulia*:
	$id_del_tag='1990';
	break;
	case *lazio*:
	$id_del_tag='2044';
	break;
	case *liguria*:
	$id_del_tag='1997';
	break;
	case *lombardia*:
	$id_del_tag='1934';
	break;
	case *marche*:
	$id_del_tag='2026';
	break;
	case *molise*:
	$id_del_tag='2071';
	break;
	case *piemonte*:
	$id_del_tag='1917';
	break;
	case *puglia*:
	$id_del_tag='2096';
	break;
	case *sardegna*:
	$id_del_tag='2149';
	break;
	case *sicilia*:
	$id_del_tag='2130';
	break;
	case *toscana*:
	$id_del_tag='2013';
	break;
	case *trentino-alto adige*:
	$id_del_tag='1961';
	break;
	case *trentino alto adige*:
	$id_del_tag='1961';
	break;
	case *umbria*:
	$id_del_tag='2023';
	break;
	case *valle d'aosta*:
	$id_del_tag='1932';
	break;
	case *veneto*:
	$id_del_tag='1967';
	break;
	case *consigli d'amministrazione*:
	$id_del_tag='258';
	break;
	case *violenza nelle carceri*:
	$id_del_tag='487';
	break;
	case *minoranze cristiane*:
	$id_del_tag='521';
	break;
	case *veicoli a due ruote*:
	$id_del_tag='817';
	break;
	case *traffico automobilistico*:
	$id_del_tag='822';
	break;
	case *autoveicoli*:
	$id_del_tag='822';
	break;
	case *veicoli*:
	$id_del_tag='822';
	break;
	case *immatricolazione dei veicoli*:
	$id_del_tag='822';
	break;
	case *patente di guida*:
	$id_del_tag='822';
	break;
	case *targhe dei veicoli*:
	$id_del_tag='822';
	break;
	case *veicoli a motore*:
	$id_del_tag='822';
	break;
	case *parco automobilistico*:
	$id_del_tag='822';
	break;
	case *rottamazione delle automobili*:
	$id_del_tag='822';
	break;
	case *diplomi*:
	$id_del_tag='919';
	break;
	case *droghe e sostanze allucinogene*:
	$id_del_tag='1101';
	break;
	case *giudici*:
	$id_del_tag='1221';
	break;
	case *corrispondenza*:
	$id_del_tag='1253';
	break;
	case *agricoltura sostenibile*:
	$id_del_tag='1274';
	break;
	case *questore*:
	$id_del_tag='1325';
	break;
	case *questori e questura*:
	$id_del_tag='1325';
	break;
	case *calamitã  naturali*:
	$id_del_tag='1347';
	break;
	case *protezione dei consumatori e degli utenti*:
	$id_del_tag='1542';
	break;
	case *tutela dei consumatori e degli utenti*:
	$id_del_tag='1542';
	break;
	case *consumatori*:
	$id_del_tag='1542';
	break;
	case *movimenti dei consumatori*:
	$id_del_tag='1543';
	break;
	case *esuli*:
	$id_del_tag='1611';
	break;
	case *parchi regionali e interregionali*:
	$id_del_tag='1639';
	break;
	case *zone faunistiche*:
	$id_del_tag='1639';
	break;
	case *infrastruttura dei trasporti*:
	$id_del_tag='1812';
	break;
	case *prezzi di trasporto*:
	$id_del_tag='1812';
	break;
	case *mezzi di trasporto*:
	$id_del_tag='1812';
	break;
	case *mercato del trasporto*:
	$id_del_tag='1812';
	break;
	case *trasporto viaggiatori*:
	$id_del_tag='1822';
	break;
	case *utente dei trasporti*:
	$id_del_tag='1822';
	break;
	case *aeroporto di catania fontanarossa*:
	$id_del_tag='1830';
	break;
	case *aeroporto di milano linate*:
	$id_del_tag='1830';
	break;
	case *canoni e diritti aeroportuali*:
	$id_del_tag='1830';
	break;
	case *aeroporto di milano malpensa*:
	$id_del_tag='1830';
	break;
	case *aeroporto di palermo punta raisi*:
	$id_del_tag='1830';
	break;
	case *aeroporto di roma fiumicino*:
	$id_del_tag='1830';
	break;
	case *autotrasporti*:
	$id_del_tag='1833';
	break;
	case *autisti*:
	$id_del_tag='1833';
	break;
	case *costruzioni ferroviarie*:
	$id_del_tag='1839';
	break;
	case *linee ferroviarie*:
	$id_del_tag='1839';
	break;
	case *rete ferroviaria italiana spa (rfi)*:
	$id_del_tag='1839';
	break;
	case *reti ferroviarie*:
	$id_del_tag='1839';
	break;
	case *cliniche e case di cura*:
	$id_del_tag='1877';
	break;
	case *provincia di bergamo*:
	$id_del_tag='1935';
	break;
	case *rai - radiotelevisione italiana spa*:
	$id_del_tag='2273';
	break;
	case *russia*:
	$id_del_tag='2278';
	break;
	case *prevenzione incidenti stradali*:
	$id_del_tag='2300';
	break;
	case *limiti di velocita'*:
	$id_del_tag='2300';
	break;
	case *segnaletica e impianti di segnalamento*:
	$id_del_tag='2300';
	break;
	case *incidenti stradali*:
	$id_del_tag='2300';
	break;
	case *incidenti aerei*:
	$id_del_tag='2371';
	break;
	case *provincia di napoli*:
	$id_del_tag='4307';
	break;
	case *provincia di nuoro*:
	$id_del_tag='4314';
	break;
	case *provincia di frosinone*:
	$id_del_tag='4328';
	break;
	case *provincia di torino*:
	$id_del_tag='4349';
	break;
	case *provincia di messina*:
	$id_del_tag='4384';
	break;
	case *provincia di treviso*:
	$id_del_tag='4404';
	break;
	case *provincia di udine*:
	$id_del_tag='4424';
	break;
	case *provincia di foggia*:
	$id_del_tag='4430';
	break;
	case *provincia di lecce*:
	$id_del_tag='4438';
	break;
	case *imprese medie e piccole*:
	$id_del_tag='4448';
	break;
	case *fondo di garanzia per le piccole e medie imprese*:
	$id_del_tag='4448';
	break;
	case *provincia di milano*:
	$id_del_tag='4462';
	break;
	case *provincia di bolzano*:
	$id_del_tag='4591';
	break;
	case *provincia di cosenza*:
	$id_del_tag='4510';
	break;
	case *provincia di roma*:
	$id_del_tag='4529';
	break;
	case *riduzione in schiavitu'*:
	$id_del_tag='4588';
	break;
	case *inquinamento atmosferico (industriale)*:
	$id_del_tag='4628';
	break;
	case *tutela del paesaggio*:
	$id_del_tag='4630';
	break;
	case *discriminazioni etniche*:
	$id_del_tag='4739';
	break;
	case *lotta contro la discriminazione*:
	$id_del_tag='4739';
	break;
	case *provincia di belluno*:
	$id_del_tag='4754';
	break;
	case *provincia di oristano*:
	$id_del_tag='4762';
	break;
	case *provincia di brescia*:
	$id_del_tag='4793';
	break;
	case *provincia di rovigo*:
	$id_del_tag='4818';
	break;
	case *provincia di benevento*:
	$id_del_tag='4825';
	break;
	case *provincia di ancona*:
	$id_del_tag='4847';
	break;
	case *provincia di massa-carrara*:
	$id_del_tag='4969';
	break;
	case *provincia di enna*:
	$id_del_tag='4990';
	break;
	case *reti di comunicazione e trasmissione*:
	$id_del_tag='5000';
	break;
	case *reti di trasmissione*:
	$id_del_tag='5000';
	break;
	case *reti informatiche*:
	$id_del_tag='5000';
	break;
	case *provincia di salerno*:
	$id_del_tag='5032';
	break;
	case *provincia di brindisi*:
	$id_del_tag='5051';
	break;
	case *provincia di varese*:
	$id_del_tag='5092';
	break;
	case *provincia di mantova*:
	$id_del_tag='5095';
	break;
	case *handicappati*:
	$id_del_tag='5132';
	break;
	case *integrazione dei disabili*:
	$id_del_tag='5132';
	break;
	case *provincia di sassari*:
	$id_del_tag='5138';
	break;
	case *incidenti navali*:
	$id_del_tag='5178';
	break;
	case *provincia di taranto*:
	$id_del_tag='5180';
	break;
	case *libera circolazione delle persone*:
	$id_del_tag='5237';
	break;
	case *provincia di potenza*:
	$id_del_tag='5268';
	break;
	case *provincia di cremona*:
	$id_del_tag='5298';
	break;
	case *provincia di gorizia*:
	$id_del_tag='5301';
	break;
	case *provincia di como*:
	$id_del_tag='5469';
	break;
	case *provincia di venezia*:
	$id_del_tag='5513';
	break;
	case *provincia di catanzaro*:
	$id_del_tag='5523';
	break;
	case *protezione delle minoranze*:
	$id_del_tag='5598';
	break;
	case *trasporto di merci*:
	$id_del_tag='5647';
	break;
	case *trasparenza*:
	$id_del_tag='5650';
	break;
	case *provincia di trento*: 
	$id_del_tag='5725';
	break;
	case *provincia di trento*:
	$id_del_tag='5725';
	break;
	case *provincia di livorno*:
	$id_del_tag='5750';
	break;
	case *provincia di ascoli piceno*:
	$id_del_tag='5788';
	break;
	case *provincia di reggio nell'emilia*:
	$id_del_tag='5866';
	break;
	case *provincia di rimini*:
	$id_del_tag='5931';
	break;
	case *giurisdizione giudiziaria*:
	$id_del_tag='5939';
	break;
	case *giurisdizione d'eccezione*:
	$id_del_tag='5939';
	break;
	case *giurisdizione di grado superiore*:
	$id_del_tag='5939';
	break;
	case *conflitti di giurisdizioni*:
	$id_del_tag='5939';
	break;
	case *commercio ed economia internazionale*:
	$id_del_tag='5985';
	break;
	case *provincia di pesaro e urbino*:
	$id_del_tag='6005';
	break;
	case *provincia di caltanissetta*:
	$id_del_tag='6057';
	break;
	case *dati personali*:
	$id_del_tag='6146';
	break;
	case *informazioni e notizie riservate*:
	$id_del_tag='6146';
	break;
	case *anas spa*:
	$id_del_tag='6188';
	break;
	case *cai - alitalia*:
	$id_del_tag='6216';
	break;
	case *linee aeree italiane*:
	$id_del_tag='6223';
	break;
	case *linee aeree italiane, alitalia*:
	$id_del_tag='6223';
	break;
	case *politica comune dei trasporti*:
	$id_del_tag='6512';
	break;
	case *congedi parentali familiari e formativi*:
	$id_del_tag='6522';
	break;
	case *provincia di sondrio*:
	$id_del_tag='6540';
	break;
	case *provincia di trieste*:
	$id_del_tag='6568';
	break;
	case *provincia di chieti*:
	$id_del_tag='6577';
	break;
	case *provincia di agrigento*:
	$id_del_tag='6591';
	break;
	case *provincia di grosseto*:
	$id_del_tag='6600';
	break;
	case *immigrati clandestini*:
	$id_del_tag='7304';
	break;
	case *societa' di navigazione tirrenia*:
	$id_del_tag='7344';
	break;
	case *eni*:
	$id_del_tag='7351';
	break;
	case *dichiarazioni anticipate di trattamento sanitario (dat)*:
	$id_del_tag='7403';
	break;
	case *dichiarazione anticipata di trattamento sanitario*:
	$id_del_tag='7403';
	break;
	case *reti stradali*:
	$id_del_tag='7744';
	break;
	case *ordine pubblico*:
	$id_del_tag='7791';
	break;
	case *sicurezza pubblica*:
	$id_del_tag='7791';
	break;
	case *istituto nazionale per l' assicurazione contro gli infortuni sul lavoro ( inail )*:
	$id_del_tag='7889';
	break;
	case *istituto nazionale della previdenza sociale ( inps )*:
	$id_del_tag='7890';
	break;
	case *istituto di previdenza per il settore marittimo ( ipsema )*:
	$id_del_tag='7892';
	break;
	case *istituto nazionale di statistica ( istat )*:
	$id_del_tag='7895';
	break;
	case *istituto poligrafico e zecca dello stato ( ipzs spa )*:
	$id_del_tag='7896';
	break;
	case *acerra*:
	$id_del_tag='2082';
	break;
	case *airola*:
	$id_del_tag='2075';
	break;
	case *albenga*:
	$id_del_tag='2000';
	break;
	case *ariano irpino*:
	$id_del_tag='2073';
	break;
	case *trasportatori*:
	$id_del_tag='5487';
	break;
	case *aversa*:
	$id_del_tag='2078';
	break;
	case *avezzano*:
	$id_del_tag='2069';
	break;
	case *calatafimi-segesta*:
	$id_del_tag='2147';
	break;
	case *calolziocorte*:
	$id_del_tag='4861';
	break;
	case *casale monferrato*:
	$id_del_tag='1918';
	break;
	case *cassano allo ionio*:
	$id_del_tag='2123';
	break;
	case *cassino*:
	$id_del_tag='2045';
	break;
	case *formez*:
	$id_del_tag='0';
	break;
	case *cnipa*:
	$id_del_tag='7809';
	break;
	case *chivasso*:
	$id_del_tag='1923';
	break;
	case *cina popolare*:
	$id_del_tag='6280';
	break;
	case *cina*:
	$id_del_tag='6280';
	break;
	case *consiglio superiore della magistratura*:
	$id_del_tag='1222';
	break;
	case *utenti e consumatori*:
	$id_del_tag='1542';
	break;
	case *protezione della riservatezza dei dati personali (privacy)*:
	$id_del_tag='6146';
	break;
	case *disabili*:
	$id_del_tag='5132';
	break;
	case *eboli*:
	$id_del_tag='2090';
	break;
	case *edilizia universitaria*:
	$id_del_tag='1872';
	break;
	case *federazione ginnastica d'italia (fgdi*:
	$id_del_tag='7473';
	break;
	case *ferrovie e trasporti ferroviari*:
	$id_del_tag='1839';
	break;
	case *gaeta*:
	$id_del_tag='2050';
	break;
	case *gatto*:
	$id_del_tag='0';
	break;
	case *gela*:
	$id_del_tag='2135';
	break;
	case *giffoni valle piana*:
	$id_del_tag='0';
	break;
	case *ivrea*:
	$id_del_tag='1925';
	break;
	case *metropolitane*:
	$id_del_tag='5568';
	break;
	case *loreto*:
	$id_del_tag='2029';
	break;
	case *maiori*:
	$id_del_tag='2092';
	break;
	case *minoranze linguistiche*:
	$id_del_tag='523';
	break;
	case *minoranze etniche e religiose*:
	$id_del_tag='521';
	break;
	case *minoranza sessuale*:
	$id_del_tag='4922';
	break;
	case *montecorvino rovella*:
	$id_del_tag='2094';
	break;
	case *montesarchio*:
	$id_del_tag='2077';
	break;
	case *cicli e motoveicoli*:
	$id_del_tag='817';
	break;
	case *noasca*:
	$id_del_tag='1926';
	break;
	case *nola*:
	$id_del_tag='2085';
	break;
	case *norcia*:
	$id_del_tag='2024';
	break;
	case *pinerolo*:
	$id_del_tag='1927';
	break;
	case *pompei*:
	$id_del_tag='2086';
	break;
	case *campo rom*:
	$id_del_tag='7707';
	break;
	case *portopalo di capo passero*:
	$id_del_tag='2145';
	break;
	case *medio campidano*:
	$id_del_tag='2389';
	break;
	case *reti d'informazione*:
	$id_del_tag='5000';
	break;
	case *sala consilina*:
	$id_del_tag='2095';
	break;
	case *san gimignano*:
	$id_del_tag='2021';
	break;
	case *san giovanni rotondo*:
	$id_del_tag='2105';
	break;
	case *santa maria capua vetere*:
	$id_del_tag='2080';
	break;
	case *saronno*:
	$id_del_tag='1959';
	break;
	case *incidenti nucleari*:
	$id_del_tag='5269';
	break;
	case *incidente ferroviari*:
	$id_del_tag='5689';
	break;
	case *incidenti ferroviari*:
	$id_del_tag='5689';
	break;
	case *sora*:
	$id_del_tag='2048';
	break;
	case *spilimbergo*:
	$id_del_tag='1996';
	break;
	case *sulmona*:
	$id_del_tag='2070';
	break;
	case *tivoli*:
	$id_del_tag='2061';
	break;
	case *trasporto di passeggeri*:
	$id_del_tag='1822';
	break;
	case *trattamento crudele e degradante*:
	$id_del_tag='4422';
	break;
	case *tresigallo*:
	$id_del_tag='2006';
	break;
	case *velletri*:
	$id_del_tag='5687';
	case *carema* :
	$id_del_tag='1922';
	break;
	case *frossasco* :
	$id_del_tag='1924';
	break;
	case *rivarolo canavese* :
	$id_del_tag='1928';
	break;
	case *verbano-cusio ossola* :
	$id_del_tag='1930';
	break;
	case *verbania-cusio ossola* :
	$id_del_tag='1930';
	break;
	case *stresa* :
	$id_del_tag='1931';
	break;
	case *barletta-andria-trani - prov.* :
	$id_del_tag='8368';
	break;
	case *fermo - prov.* :
	$id_del_tag='8369';
	break;
	case *san pellegrino terme* :
	$id_del_tag='1937';
	break;
	case *torre pallavicina* :
	$id_del_tag='1938';
	break;
	case *gardone riviera* :
	$id_del_tag='1940';
	break;
	case *campione d'italia* :
	$id_del_tag='1942';
	break;
	case *soncino* :
	$id_del_tag='1946';
	break;
	case *busnago* :
	$id_del_tag='1949';
	break;
	case *caponago* :
	$id_del_tag='1950';
	break;
	case *cornate d'adda* :
	$id_del_tag='1951';
	break;
	case *lentate sul seveso* :
	$id_del_tag='1952';
	break;
	case *teglio* :
	$id_del_tag='1956';
	break;
	case *busto arsizio* :
	$id_del_tag='1958';
	break;
	case *merano* :
	$id_del_tag='1965';
	break;
	case *colle santa lucia* :
	$id_del_tag='1969';
	break;
	case *cortina d'ampezzo* :
	$id_del_tag='1970';
	break;
	case *lamon* :
	$id_del_tag='1971';
	break;
	case *livinallongo del col di lana* :
	$id_del_tag='1972';
	break;
	case *sappada* :
	$id_del_tag='1973';
	break;
	case *sovramonte* :
	$id_del_tag='1974';
	break;
	case *adria* :
	$id_del_tag='1977';
	break;
	case *trecenta* :
	$id_del_tag='1978';
	break;
	case *chioggia* :
	$id_del_tag='1982';
	break;
	case *cinto caomaggiore* :
	$id_del_tag='1983';
	break;
	case *portogruaro* :
	$id_del_tag='1985';
	break;
	case *bassano del grappa* :
	$id_del_tag='1988';
	break;
	case *marano lagunare* :
	$id_del_tag='1993';
	break;
	case *portofino* :
	$id_del_tag='1999';
	break;
	case *grizzana morandi* :
	$id_del_tag='2003';
	break;
	case *marzabotto* :
	$id_del_tag='2004';
	break;
	case *monzuno* :
	$id_del_tag='2005';
	break;
	case *busseto* :
	$id_del_tag='2008';
	break;
	case *stazzema* :
	$id_del_tag='2016';
	break;
	case *todi* :
	$id_del_tag='2025';
	break;
	case *fermo* :
	$id_del_tag='2032';
	break;
	case *casteldelci* :
	$id_del_tag='2035';
	break;
	case *maiolo* :
	$id_del_tag='2036';
	break;
	case *montecopiolo* :
	$id_del_tag='2037';
	break;
	case *casale monferrato* : 
	$id_del_tag='1918'; 
	break;
	case *asti* : 
	$id_del_tag='1919'; 
	break;
	case *carema* : 
	$id_del_tag='1922'; 
	break;
	case *chivasso* : 
	$id_del_tag='1923'; 
	break;
	case *frossasco* : 
	$id_del_tag='1924'; 
	break;
	case *ivrea* : 
	$id_del_tag='1925'; 
	break;
	case *noasca* : 
	$id_del_tag='1926'; 
	break;
	case *pinerolo* : 
	$id_del_tag='1927'; 
	break;
	case *rivarolo canavese* : 
	$id_del_tag='1928'; 
	break;
	case *stresa* : 
	$id_del_tag='1931'; 
	break;
	case *san pellegrino terme* : 
	$id_del_tag='1937'; 
	break;
	case *torre pallavicina* : 
	$id_del_tag='1938'; 
	break;
	case *gardone riviera* : 
	$id_del_tag='1940'; 
	break;
	case *campione d'italia* : 
	$id_del_tag='1942'; 
	break;
	case *crema* : 
	$id_del_tag='1945'; 
	break;
	case *soncino* : 
	$id_del_tag='1946'; 
	break;
	case *busnago* : 
	$id_del_tag='1949'; 
	break;
	case *caponago* : 
	$id_del_tag='1950'; 
	break;
	case *cornate d'adda* : 
	$id_del_tag='1951'; 
	break;
	case *lentate sul seveso* : 
	$id_del_tag='1952'; 
	break;
	case *teglio* : 
	$id_del_tag='1956'; 
	break;
	case *busto arsizio* : 
	$id_del_tag='1958'; 
	break;
	case *saronno* : 
	$id_del_tag='1959'; 
	break;
	case *merano* : 
	$id_del_tag='1965'; 
	break;
	case *colle santa lucia* : 
	$id_del_tag='1969'; 
	break;
	case *cortina d'ampezzo* : 
	$id_del_tag='1970'; 
	break;
	case *lamon* : 
	$id_del_tag='1971'; 
	break;
	case *livinallongo del col di lana* : 
	$id_del_tag='1972'; 
	break;
	case *sappada* : 
	$id_del_tag='1973'; 
	break;
	case *sovramonte* : 
	$id_del_tag='1974'; 
	break;
	case *adria* : 
	$id_del_tag='1977'; 
	break;
	case *trecenta* : 
	$id_del_tag='1978'; 
	break;
	case *chioggia* : 
	$id_del_tag='1982'; 
	break;
	case *cinto caomaggiore* : 
	$id_del_tag='1983'; 
	break;
	case *portogruaro* : 
	$id_del_tag='1985'; 
	break;
	case *bassano del grappa* : 
	$id_del_tag='1988'; 
	break;
	case *marano lagunare* : 
	$id_del_tag='1993'; 
	break;
	case *spilimbergo* : 
	$id_del_tag='1996'; 
	break;
	case *portofino* : 
	$id_del_tag='1999'; 
	break;
	case *albenga* : 
	$id_del_tag='2000'; 
	break;
	case *grizzana morandi* : 
	$id_del_tag='2003'; 
	break;
	case *marzabotto* : 
	$id_del_tag='2004'; 
	break;
	case *monzuno* : 
	$id_del_tag='2005'; 
	break;
	case *tresigallo* : 
	$id_del_tag='2006'; 
	break;
	case *busseto* : 
	$id_del_tag='2008'; 
	break;
	case *stazzema* : 
	$id_del_tag='2016'; 
	break;
	case *carrara* : 
	$id_del_tag='2018'; 
	break;
	case *massa* : 
	$id_del_tag='2019'; 
	break;
	case *san gimignano* : 
	$id_del_tag='2021'; 
	break;
	case *norcia* : 
	$id_del_tag='2024'; 
	break;
	case *todi* : 
	$id_del_tag='2025'; 
	break;
	case *loreto* : 
	$id_del_tag='2029'; 
	break;
	case *fermo* : 
	$id_del_tag='2032'; 
	break;
	case *casteldelci* : 
	$id_del_tag='2035'; 
	break;
	case *maiolo* : 
	$id_del_tag='2036'; 
	break;
	case *montecopiolo* : 
	$id_del_tag='2037'; 
	break;
	case *novafeltria* : 
	$id_del_tag='2038'; 
	break;
	case *pennabilli* : 
	$id_del_tag='2039'; 
	break;
	case *san leo* : 
	$id_del_tag='2040'; 
	break;
	case *sant'agata feltria* : 
	$id_del_tag='2041'; 
	break;
	case *sassofeltrio* : 
	$id_del_tag='2042'; 
	break;
	case *talamello* : 
	$id_del_tag='2043'; 
	break;
	case *cassino* : 
	$id_del_tag='2045'; 
	break;
	case *fiuggi* : 
	$id_del_tag='2046'; 
	break;
	case *sora* : 
	$id_del_tag='2048'; 
	break;
	case *formia* : 
	$id_del_tag='2049'; 
	break;
	case *gaeta* : 
	$id_del_tag='2050'; 
	break;
	case *greccio* : 
	$id_del_tag='2052'; 
	break;
	case *anzio* : 
	$id_del_tag='2055'; 
	break;
	case *ariccia* : 
	$id_del_tag='2056'; 
	break;
	case *ciampino* : 
	$id_del_tag='2057'; 
	break;
	case *civitavecchia* : 
	$id_del_tag='2058'; 
	break;
	case *tivoli* : 
	$id_del_tag='2061'; 
	break;
	case *bagnoregio* : 
	$id_del_tag='2062'; 
	break;
	case *lanciano* : 
	$id_del_tag='2066'; 
	break;
	case *ortona* : 
	$id_del_tag='2067'; 
	break;
	case *vasto* : 
	$id_del_tag='2068'; 
	break;
	case *avezzano* : 
	$id_del_tag='2069'; 
	break;
	case *sulmona* : 
	$id_del_tag='2070'; 
	break;
	case *ariano irpino* : 
	$id_del_tag='2073'; 
	break;
	case *airola* : 
	$id_del_tag='2075'; 
	break;
	case *montesarchio* : 
	$id_del_tag='2077'; 
	break;
	case *aversa* : 
	$id_del_tag='2078'; 
	break;
	case *santa maria capua vetere* : 
	$id_del_tag='2080'; 
	break;
	case *acerra* : 
	$id_del_tag='2082'; 
	break;
	case *afragola* : 
	$id_del_tag='2083'; 
	break;
	case *nola* : 
	$id_del_tag='2085'; 
	break;
	case *pompei* : 
	$id_del_tag='2086'; 
	break;
	case *vico equense* : 
	$id_del_tag='2087'; 
	break;
	case *cava de' tirreni* : 
	$id_del_tag='2089'; 
	break;
	case *eboli* : 
	$id_del_tag='2090'; 
	break;
	case *giffoni valle piana* : 
	$id_del_tag='0'; 
	break;
	case *maiori* : 
	$id_del_tag='2092'; 
	break;
	case *mercato san severino* : 
	$id_del_tag='2093'; 
	break;
	case *montecorvino rovella* : 
	$id_del_tag='2094'; 
	break;
	case *sala consilina* : 
	$id_del_tag='2095'; 
	break;
	case *ostuni* : 
	$id_del_tag='2100'; 
	break;
	case *lucera* : 
	$id_del_tag='2103'; 
	break;
	case *manfredonia* : 
	$id_del_tag='2104'; 
	break;
	case *san giovanni rotondo* : 
	$id_del_tag='2105'; 
	break;
	case *castrignano del capo* : 
	$id_del_tag='2107'; 
	break;
	case *gallipoli* : 
	$id_del_tag='2108'; 
	break;
	case *santa cesarea terme* : 
	$id_del_tag='2110'; 
	break;
	case *scanzano jonico* : 
	$id_del_tag='2115'; 
	break;
	case *melfi* : 
	$id_del_tag='2117'; 
	break;
	case *lamezia terme* : 
	$id_del_tag='2121'; 
	break;
	case *cassano allo ionio* : 
	$id_del_tag='2123'; 
	break;
	case *ardore* : 
	$id_del_tag='2125'; 
	break;
	case *gioia tauro* : 
	$id_del_tag='2126'; 
	break;
	case *monasterace* : 
	$id_del_tag='2127'; 
	break;
	case *palmi* : 
	$id_del_tag='2128'; 
	break;
	case *lampedusa e linosa* : 
	$id_del_tag='2132'; 
	break;
	case *naro* : 
	$id_del_tag='2133'; 
	break;
	case *gela* : 
	$id_del_tag='2135'; 
	break;
	case *acireale* : 
	$id_del_tag='2136'; 
	break;
	case *caltagirone* : 
	$id_del_tag='2137'; 
	break;
	case *castel di iudica* : 
	$id_del_tag='2138'; 
	break;
	case *raddusa* : 
	$id_del_tag='2139'; 
	break;
	case *ramacca* : 
	$id_del_tag='2140'; 
	break;
	case *taormina* : 
	$id_del_tag='2144'; 
	break;
	case *portopalo di capo passero* : 
	$id_del_tag='2145'; 
	break;
	case *calatafimi-segesta* : 
	$id_del_tag='2147'; 
	break;
	case *arbus* : 
	$id_del_tag='2150'; 
	break;
	case *iglesias* : 
	$id_del_tag='2152'; 
	break;
	case *tempio pausania* : 
	$id_del_tag='2156'; 
	break;
	case *federazione russa* : 
	$id_del_tag='2278'; 
	break;
	case *stati uniti d' america* : 
	$id_del_tag='2286'; 
	break;
	case *stati uniti* : 
	$id_del_tag='2286'; 
	break;
	case *Regno unito* : 
	$id_del_tag='8261'; 
	break;
	case *stati uniti d'america* : 
	$id_del_tag='2286'; 
	break;
	case *cavallino treporti* : 
	$id_del_tag='2314'; 
	break;
	case *fossano* : 
	$id_del_tag='2403'; 
	break;
	case *ferrandina* : 
	$id_del_tag='2410'; 
	break;
	case *gravina in puglia* : 
	$id_del_tag='2417'; 
	break;
	case *rionero in vulture* : 
	$id_del_tag='2420'; 
	break;
	case *sant'agata de' goti* : 
	$id_del_tag='4248'; 
	break;
	case *pietraroja* : 
	$id_del_tag='4250'; 
	break;
	case *viareggio* : 
	$id_del_tag='4257'; 
	break;
	case *fiumicino* : 
	$id_del_tag='4258'; 
	break;
	case *follonica* : 
	$id_del_tag='4259'; 
	break;
	case *praia a mare* : 
	$id_del_tag='4260'; 
	break;
	case *roncello* : 
	$id_del_tag='4282'; 
	break;
	case *sant'agnello* : 
	$id_del_tag='4306'; 
	break;
	case *bussolengo* : 
	$id_del_tag='4321'; 
	break;
	case *somma vesuviana* : 
	$id_del_tag='4368'; 
	break;
	case *visco* : 
	$id_del_tag='4423'; 
	break;
	case *ruffano* : 
	$id_del_tag='4437'; 
	break;
	case *pisticci* : 
	$id_del_tag='4488'; 
	break;
	case *cerisano* : 
	$id_del_tag='4509'; 
	break;
	case *rotondella* : 
	$id_del_tag='4518'; 
	break;
	case *canna* : 
	$id_del_tag='4523'; 
	break;
	case *bracciano* : 
	$id_del_tag='4528'; 
	break;
	case *comiso* : 
	$id_del_tag='4571'; 
	break;
	case *aprilia* : 
	$id_del_tag='4668'; 
	break;
	case *finale ligure* : 
	$id_del_tag='4710'; 
	break;
	case *bressanone* : 
	$id_del_tag='4718'; 
	break;
	case *tresnuraghes* : 
	$id_del_tag='4761'; 
	break;
	case *ischia* : 
	$id_del_tag='4768'; 
	break;
	case *mondovi'* : 
	$id_del_tag='4777'; 
	break;
	case *ottana* : 
	$id_del_tag='4801'; 
	break;
	case *agrate conturbia* : 
	$id_del_tag='4805'; 
	break;
	case *ariano nel polesine* : 
	$id_del_tag='4817'; 
	break;
	case *bogogno* : 
	$id_del_tag='4843'; 
	break;
	case *senigallia* : 
	$id_del_tag='4846'; 
	break;
	case *calolziocorte* : 
	$id_del_tag='4861'; 
	break;
	case *rignano garganico* : 
	$id_del_tag='4908'; 
	break;
	case *locri* : 
	$id_del_tag='4928'; 
	break;
	case *sorrento* : 
	$id_del_tag='4931'; 
	break;
	case *ponte di legno* : 
	$id_del_tag='4957'; 
	break;
	case *amendolara* : 
	$id_del_tag='4958'; 
	break;
	case *pontremoli* : 
	$id_del_tag='4968'; 
	break;
	case *castellabate* : 
	$id_del_tag='5031'; 
	break;
	case *colle di val d'elsa* : 
	$id_del_tag='5033'; 
	break;
	case *castelfranco veneto* : 
	$id_del_tag='5039'; 
	break;
	case *oria* : 
	$id_del_tag='5050'; 
	break;
	case *fontana liri* : 
	$id_del_tag='5059'; 
	break;
	case *san ferdinando di puglia* : 
	$id_del_tag='5062'; 
	break;
	case *saluggia* : 
	$id_del_tag='5067'; 
	break;
	case *ostiglia* : 
	$id_del_tag='5094'; 
	break;
	case *revere* : 
	$id_del_tag='5096'; 
	break;
	case *frascati* : 
	$id_del_tag='5116'; 
	break;
	case *arcore* : 
	$id_del_tag='5119'; 
	break;
	case *olbia* : 
	$id_del_tag='5137'; 
	break;
	case *schio* : 
	$id_del_tag='5182'; 
	break;
	case *andora* : 
	$id_del_tag='5244'; 
	break;
	case *uboldo* : 
	$id_del_tag='5293'; 
	break;
	case *ventimiglia* : 
	$id_del_tag='5294'; 
	break;
	case *rivoli* : 
	$id_del_tag='5321'; 
	break;
	case *cornedo vicentino* : 
	$id_del_tag='5331'; 
	break;
	case *sarno* : 
	$id_del_tag='5355'; 
	break;
	case *sassano* : 
	$id_del_tag='5357'; 
	break;
	case *torchiara* : 
	$id_del_tag='5367'; 
	break;
	case *brunico* : 
	$id_del_tag='5373'; 
	break;
	case *tricase* : 
	$id_del_tag='5430'; 
	break;
	case *cervia* : 
	$id_del_tag='5438'; 
	break;
	case *fucecchio* : 
	$id_del_tag='5468'; 
	break;
	case *valenzano* : 
	$id_del_tag='5516'; 
	break;
	case *aviano* : 
	$id_del_tag='5526'; 
	break;
	case *ghedi* : 
	$id_del_tag='5538'; 
	break;
	case *mortara* : 
	$id_del_tag='5539'; 
	break;
	case *anagni* : 
	$id_del_tag='5553'; 
	break;
	case *bagnara calabra* : 
	$id_del_tag='5554'; 
	break;
	case *abano terme* : 
	$id_del_tag='5570'; 
	break;
	case *scandicci* : 
	$id_del_tag='5576'; 
	break;
	case *susegana* : 
	$id_del_tag='5577'; 
	break;
	case *ugento* : 
	$id_del_tag='5589'; 
	break;
	case *paola* : 
	$id_del_tag='5590'; 
	break;
	case *cernobbio* : 
	$id_del_tag='5629'; 
	break;
	case *verbania* : 
	$id_del_tag='5665'; 
	break;
	case *velletri* : 
	$id_del_tag='5687'; 
	break;
	case *gradisca d'isonzo* : 
	$id_del_tag='5720'; 
	break;
	case *corigliano calabro* : 
	$id_del_tag='5772'; 
	break;
	case *brolo* : 
	$id_del_tag='5790'; 
	break;
	case *serra d'aiello* : 
	$id_del_tag='5807'; 
	break;
	case *trecase* : 
	$id_del_tag='5833'; 
	break;
	case *spinazzola* : 
	$id_del_tag='5836'; 
	break;
	case *pantelleria* : 
	$id_del_tag='5860'; 
	break;
	case *isola di capo rizzuto* : 
	$id_del_tag='5864'; 
	break;
	case *guastalla* : 
	$id_del_tag='5865'; 
	break;
	case *la maddalena* : 
	$id_del_tag='5882'; 
	break;
	case *alzate brianza* : 
	$id_del_tag='5887'; 
	break;
	case *valva* : 
	$id_del_tag='5896'; 
	break;
	case *pagani* : 
	$id_del_tag='5897'; 
	break;
	case *martina franca* : 
	$id_del_tag='5899'; 
	break;
	case *torviscosa* : 
	$id_del_tag='5906'; 
	break;
	case *oppeano* : 
	$id_del_tag='5915'; 
	break;
	case *olgiate comasco* : 
	$id_del_tag='5918'; 
	break;
	case *solbiate* : 
	$id_del_tag='5919'; 
	break;
	case *policoro* : 
	$id_del_tag='5926'; 
	break;
	case *cattolica* : 
	$id_del_tag='5930'; 
	break;
	case *falconara marittima* : 
	$id_del_tag='5932'; 
	break;
	case *orte* : 
	$id_del_tag='5933'; 
	break;
	case *senise* : 
	$id_del_tag='5934'; 
	break;
	case *sassuolo* : 
	$id_del_tag='5988'; 
	break;
	case *cameri* : 
	$id_del_tag='6000'; 
	break;
	case *pesaro* : 
	$id_del_tag='6004'; 
	break;
	case *castel goffredo* : 
	$id_del_tag='6007'; 
	break;
	case *picerno* : 
	$id_del_tag='6016'; 
	break;
	case *campana* : 
	$id_del_tag='6017'; 
	break;
	case *fidenza* : 
	$id_del_tag='6025'; 
	break;
	case *foligno* : 
	$id_del_tag='6031'; 
	break;
	case *sannicandro garganico* : 
	$id_del_tag='6040'; 
	break;
	case *spoleto* : 
	$id_del_tag='6050'; 
	break;
	case *barga* : 
	$id_del_tag='6053'; 
	break;
	case *tropea* : 
	$id_del_tag='6077'; 
	break;
	case *mazara del vallo* : 
	$id_del_tag='6126'; 
	break;
	case *cina* : 
	$id_del_tag='6280'; 
	break;
	case *ginosa* : 
	$id_del_tag='6429'; 
	break;
	case *sabaudia* : 
	$id_del_tag='6430'; 
	break;
	case *robbiate* : 
	$id_del_tag='6458'; 
	break;
	case *rovereto* : 
	$id_del_tag='6501'; 
	break;
	case *avigliana* : 
	$id_del_tag='6502'; 
	break;
	case *cartoceto* : 
	$id_del_tag='6519'; 
	break;
	case *arcinazzo romano* : 
	$id_del_tag='6533'; 
	break;
	case *cesena* : 
	$id_del_tag='6569'; 
	break;
	case *barletta* : 
	$id_del_tag='6586'; 
	break;
	case *carbonia* : 
	$id_del_tag='6593'; 
	break;
	case *aosta* : 
	$id_del_tag='6602'; 
	break;
	case *chiari* : 
	$id_del_tag='6683'; 
	break;
	case *castel volturno* : 
	$id_del_tag='6690'; 
	break;
	case *podenzano* : 
	$id_del_tag='6694'; 
	break;
	case *sogliano al rubicone* : 
	$id_del_tag='6824'; 
	break;
	case *lagonegro* : 
	$id_del_tag='6829'; 
	break;
	case *sicignano degli alburni* : 
	$id_del_tag='6830'; 
	break;
	case *castiglione delle stiviere* : 
	$id_del_tag='7021'; 
	break;
	case *omegna* : 
	$id_del_tag='7025'; 
	break;
	case *cinisello balsamo* : 
	$id_del_tag='7028'; 
	break;
	case *casal di principe* : 
	$id_del_tag='7054'; 
	break;
	case *basiglio* : 
	$id_del_tag='7069'; 
	break;
	case *casei gerola* : 
	$id_del_tag='7079'; 
	break;
	case *positano* : 
	$id_del_tag='7082'; 
	break;
	case *praiano* : 
	$id_del_tag='7083'; 
	break;
	case *caivano* : 
	$id_del_tag='7097'; 
	break;
	case *san giorgio piacentino* : 
	$id_del_tag='7099'; 
	break;
	case *cimbergo* : 
	$id_del_tag='7104'; 
	break;
	case *caorso* : 
	$id_del_tag='7121'; 
	break;
	case *sasso marconi* : 
	$id_del_tag='7123'; 
	break;
	case *fossalta di portogruaro* : 
	$id_del_tag='7127'; 
	break;
	case *pero* : 
	$id_del_tag='7143'; 
	break;
	case *rho* : 
	$id_del_tag='7144'; 
	break;
	case *castel del monte* : 
	$id_del_tag='7159'; 
	break;
	case *amelia* : 
	$id_del_tag='7171'; 
	break;
	case *marciana* : 
	$id_del_tag='7172'; 
	break;
	case *vimercate* : 
	$id_del_tag='7189'; 
	break;
	case *nova siri* : 
	$id_del_tag='7191'; 
	break;
	case *cagnano varano* : 
	$id_del_tag='7234'; 
	break;
	case *castelnuovo garfagnana* : 
	$id_del_tag='7300'; 
	break;
	case *capo d'orlando* : 
	$id_del_tag='7326'; 
	break;
	case *calvello* : 
	$id_del_tag='7335'; 
	break;
	case *casale sul sile* : 
	$id_del_tag='7364'; 
	break;
	case *barcellona pozzo di gotto* : 
	$id_del_tag='7368'; 
	break;
	case *cigliano* : 
	$id_del_tag='7383'; 
	break;
	case *pomigliano d'arco* : 
	$id_del_tag='7394'; 
	break;
	case *mariano comense* : 
	$id_del_tag='7406'; 
	break;
	case *tolmezzo* : 
	$id_del_tag='7408'; 
	break;
	case *pozzuoli* : 
	$id_del_tag='7409'; 
	break;
	case *civitanova marche* : 
	$id_del_tag='7413'; 
	break;
	case *roccella ionica* : 
	$id_del_tag='7414'; 
	break;
	case *monticiano* : 
	$id_del_tag='7415'; 
	break;
	case *medesano* : 
	$id_del_tag='7418'; 
	break;
	case *romano d'ezzelino* : 
	$id_del_tag='7419'; 
	break;
	case *monopoli* : 
	$id_del_tag='7421'; 
	break;
	case *viadana* : 
	$id_del_tag='7431'; 
	break;
	case *livigno* : 
	$id_del_tag='7436'; 
	break;
	case *castelnuovo di val di cecina* : 
	$id_del_tag='7448'; 
	break;
	case *volterra* : 
	$id_del_tag='7449'; 
	break;
	case *vizzini* : 
	$id_del_tag='7454'; 
	break;
	case *maddaloni* : 
	$id_del_tag='7455'; 
	break;
	case *cesenatico* : 
	$id_del_tag='7489'; 
	break;
	case *colleferro* : 
	$id_del_tag='7681'; 
	break;
	case *segni* : 
	$id_del_tag='7682'; 
	break;
	case *gavignano* : 
	$id_del_tag='7683'; 
	break;
	case *paliano* : 
	$id_del_tag='7684'; 
	break;
	case *ferentino* : 
	$id_del_tag='7686'; 
	break;
	case *sgurgola* : 
	$id_del_tag='7687'; 
	break;
	case *morolo* : 
	$id_del_tag='7688'; 
	break;
	case *supino* : 
	$id_del_tag='7689'; 
	break;
	case *tursi* : 
	$id_del_tag='7694'; 
	break;
	case *vallerotonda* : 
	$id_del_tag='7706'; 
	break;
	case *montecatini terme* : 
	$id_del_tag='7708'; 
	break;
	case *castel tesino* : 
	$id_del_tag='7709'; 
	break;
	case *macomer* : 
	$id_del_tag='7711'; 
	break;
	case *siniscola* : 
	$id_del_tag='7712'; 
	break;
	case *guidonia* : 
	$id_del_tag='7715'; 
	break;
	case *peio* : 
	$id_del_tag='7753'; 
	break;
	case *cantu'* : 
	$id_del_tag='7755'; 
	break;
	case *vattaro* : 
	$id_del_tag='7760'; 
	break;
	case *centa san nicolò* : 
	$id_del_tag='7761'; 
	break;
	case *centa san nicolo'* : 
	$id_del_tag='7761'; 
	break;
	case *bedollo* : 
	$id_del_tag='7762'; 
	break;
	case *rottofreno* : 
	$id_del_tag='7763'; 
	break;
	case *mormanno* : 
	$id_del_tag='7766'; 
	break;
	case *papasidero* : 
	$id_del_tag='7767'; 
	break;
	case *licata* : 
	$id_del_tag='7773'; 
	break;
	case *campello sul clitunno* : 
	$id_del_tag='7777'; 
	break;
	case *bella* : 
	$id_del_tag='7778'; 
	break;
	case *filiano* : 
	$id_del_tag='7779'; 
	break;
	case *lauria* : 
	$id_del_tag='7780'; 
	break;
	case *maratea* : 
	$id_del_tag='7781'; 
	break;
	case *subiaco* : 
	$id_del_tag='7785'; 
	break;
	case *montecchio maggiore* : 
	$id_del_tag='7797'; 
	break;
	case *briga novarese* : 
	$id_del_tag='7800'; 
	break;
	case *vogogna* : 
	$id_del_tag='7802'; 
	break;
	case *arconate* : 
	$id_del_tag='7808'; 
	break;
	case *stagno* : 
	$id_del_tag='7818'; 
	break;
	case *corigliano d'otranto* : 
	$id_del_tag='7823'; 
	break;
	case *montagnana* : 
	$id_del_tag='7825'; 
	break;
	case *pontassieve* : 
	$id_del_tag='8065'; 
	break;
	
	case *collezioni*:
	$id_del_tag='0';
	break;
	case *restauri*:
	$id_del_tag='0';
	break;
	case *disegnatori e grafici*:
	$id_del_tag='0';
	break;
	case *organizzazione dello sport*:
	$id_del_tag='0';
	break;
	case *federazioni sportive*:
	$id_del_tag='0';
	break;
	case *doping*:
	$id_del_tag='0';
	break;
	case *ceramiche*:
	$id_del_tag='0';
	break;
	case *fotocopie e xerocopie*:
	$id_del_tag='0';
	break;
	case *edifici ed impianti militari*:
	$id_del_tag='0';
	break;
	case *poligoni di tiro*:
	$id_del_tag='0';
	break;
	case *genio militare*:
	$id_del_tag='0';
	break;
	case *personale imbarcato*:
	$id_del_tag='0';
	break;
	case *organizzazione territoriale militare*:
	$id_del_tag='0';
	break;
	case *sergenti e vice brigadieri*:
	$id_del_tag='0';
	break;
	case *ruolo naviganti*:
	$id_del_tag='0';
	break;
	case *partigiani*:
	$id_del_tag='0';
	break;
	case *medaglie e distintivi*:
	$id_del_tag='0';
	break;
	case *ruolo d' onore*:
	$id_del_tag='0';
	break;
	case *periti tecnici*:
	$id_del_tag='0';
	break;
	case *perizie*:
	$id_del_tag='0';
	break;
	case *codici e codificazioni*:
	$id_del_tag='0';
	break;
	case *consuetudine e usi*:
	$id_del_tag='0';
	break;
	case *riapertura di termini*:
	$id_del_tag='0';
	break;
	case *sospensione di termini*:
	$id_del_tag='0';
	break;
	case *interpretazione autentica*:
	$id_del_tag='0';
	break;
	case *ordinanze*:
	$id_del_tag='0';
	break;
	case *regolamenti*:
	$id_del_tag='0';
	break;
	case *leggi*:
	$id_del_tag='0';
	break;
	case *legge delega*:
	$id_del_tag='0';
	break;
	case *legge quadro*:
	$id_del_tag='0';
	break;
	case *leggi costituzionali*:
	$id_del_tag='0';
	break;
	case *leggi regionali*:
	$id_del_tag='0';
	break;
	case *statuti*:
	$id_del_tag='0';
	break;
	case *testi unici*:
	$id_del_tag='0';
	break;
	case *atti pubblici*:
	$id_del_tag='0';
	break;
	case *obblighi*:
	$id_del_tag='0';
	break;
	case *cartelli e manifesti*:
	$id_del_tag='0';
	break;
	case *trascrizione di atti*:
	$id_del_tag='0';
	break;
	case *contributi associativi*:
	$id_del_tag='0';
	break;
	case *persone fisiche*:
	$id_del_tag='0';
	break;
	case *dispersi*:
	$id_del_tag='0';
	break;
	case *accordi e convenzioni*:
	$id_del_tag='0';
	break;
	case *contratti*:
	$id_del_tag='0';
	break;
	case *annullabilita' e nullita'*:
	$id_del_tag='0';
	break;
	case *recesso*:
	$id_del_tag='0';
	break;
	case *rappresentanti*:
	$id_del_tag='0';
	break;
	case *inquilini*:
	$id_del_tag='0';
	break;
	case *transazione*:
	$id_del_tag='0';
	break;
	case *vendita*:
	$id_del_tag='0';
	break;
	case *vendita a rate*:
	$id_del_tag='0';
	break;
	case *obbligazioni*:
	$id_del_tag='0';
	break;
	case *dilazioni e rateizzazioni*:
	$id_del_tag='0';
	break;
	case *mora e morosita'*:
	$id_del_tag='0';
	break;
	case *restituzione di somme*:
	$id_del_tag='0';
	break;
	case *diritti reali*:
	$id_del_tag='0';
	break;
	case *diritto di superficie*:
	$id_del_tag='0';
	break;
	case *beni mobili*:
	$id_del_tag='0';
	break;
	case *crediti garantiti e crediti privilegiati*:
	$id_del_tag='0';
	break;
	case *crediti dello stato*:
	$id_del_tag='0';
	break;
	case *vincoli edilizi*:
	$id_del_tag='0';
	break;
	case *alienazione di beni*:
	$id_del_tag='0';
	break;
	case *celibi e nubili*:
	$id_del_tag='0';
	break;
	case *vedovi*:
	$id_del_tag='0';
	break;
	case *responsabilita ' professionale*:
	$id_del_tag='0';
	break;
	case *garanzia commerciale*:
	$id_del_tag='0';
	break;
	case *amministrazione straordinaria*:
	$id_del_tag='0';
	break;
	case *curatori fallimentari*:
	$id_del_tag='0';
	break;
	case *mediatori ed intermediari*:
	$id_del_tag='0';
	break;
	case *licenze commerciali*:
	$id_del_tag='0';
	break;
	case *periti commerciali*:
	$id_del_tag='0';
	break;
	case *diserzione e renitenza*:
	$id_del_tag='0';
	break;
	case *tribunali militari*:
	$id_del_tag='0';
	break;
	case *matrimonio religioso*:
	$id_del_tag='0';
	break;
	case *enti di culto e istituti ecclesiastici*:
	$id_del_tag='0';
	break;
	case *beni ecclesiastici*:
	$id_del_tag='0';
	break;
	case *stato della citta'  del vaticano*:
	$id_del_tag='0';
	break;
	case *campi di concentramento e di sterminio*:
	$id_del_tag='0';
	break;
	case *internati*:
	$id_del_tag='0';
	break;
	case *organizzazioni internazionali militari*:
	$id_del_tag='0';
	break;
	case *atmosfera e spazio extraterrestre*:
	$id_del_tag='0';
	break;
	case *territorio nazionale*:
	$id_del_tag='0';
	break;
	case *scambi culturali*:
	$id_del_tag='0';
	break;
	case *atti formati all' estero*:
	$id_del_tag='0';
	break;
	case *riabilitazione civile e militare*:
	$id_del_tag='0';
	break;
	case *interdizione da pubblici uffici*:
	$id_del_tag='0';
	break;
	case *pubblicazione della sentenza*:
	$id_del_tag='0';
	break;
	case *circostanze aggravanti*:
	$id_del_tag='0';
	break;
	case *recidiva*:
	$id_del_tag='0';
	break;
	case *circostanze attenuanti ed esimenti*:
	$id_del_tag='0';
	break;
	case *delitti*:
	$id_del_tag='0';
	break;
	case *reati contro il corpo e l' onore*:
	$id_del_tag='0';
	break;
	case *lesioni personali*:
	$id_del_tag='0';
	break;
	case *rapina*:
	$id_del_tag='0';
	break;
	case *reati contro la fede e la morale pubblica e l' economia*:
	$id_del_tag='0';
	break;
	case *bancarotta*:
	$id_del_tag='0';
	break;
	case *armi improprie*:
	$id_del_tag='0';
	break;
	case *reati a mezzo stampa*:
	$id_del_tag='0';
	break;
	case *interruzione o abbandono di pubblico servizio*:
	$id_del_tag='0';
	break;
	case *pubblici ufficiali*:
	$id_del_tag='0';
	break;
	case *reati tributari*:
	$id_del_tag='0';
	break;
	case *reati contro la personalita' dello stato*:
	$id_del_tag='0';
	break;
	case *reati politici*:
	$id_del_tag='0';
	break;
	case *reati valutari*:
	$id_del_tag='0';
	break;
	case *ingiunzioni*:
	$id_del_tag='0';
	break;
	case *assistenza giudiziaria*:
	$id_del_tag='0';
	break;
	case *atti giudiziari civili*:
	$id_del_tag='0';
	break;
	case *deposito di atti*:
	$id_del_tag='0';
	break;
	case *notificazione di atti*:
	$id_del_tag='0';
	break;
	case *udienze civili*:
	$id_del_tag='0';
	break;
	case *persone socialmente pericolose*:
	$id_del_tag='0';
	break;
	case *vittime di azioni criminose*:
	$id_del_tag='0';
	break;
	case *istituti di rieducazione per minorenni*:
	$id_del_tag='0';
	break;
	case *vigilatrici penitenziarie*:
	$id_del_tag='0';
	break;
	case *diritti e doveri della persona*:
	$id_del_tag='0';
	break;
	case *obbligo di fornire dati notizie e informazioni*:
	$id_del_tag='0';
	break;
	case *ripartizione di seggi*:
	$id_del_tag='0';
	break;
	case *componenti dei seggi elettorali*:
	$id_del_tag='0';
	break;
	case *servizi e uffici elettorali*:
	$id_del_tag='0';
	break;
	case *astrologi e astrologia*:
	$id_del_tag='0';
	break;
	case *maghi*:
	$id_del_tag='0';
	break;
	case *bilanci pubblici*:
	$id_del_tag='0';
	break;
	case *fondi di bilancio*:
	$id_del_tag='0';
	break;
	case *fondi di rotazione*:
	$id_del_tag='0';
	break;
	case *conti di tesoreria*:
	$id_del_tag='0';
	break;
	case *entrate non tributarie*:
	$id_del_tag='0';
	break;
	case *ispettori tributari*:
	$id_del_tag='0';
	break;
	case *ricevute fiscali*:
	$id_del_tag='0';
	break;
	case *reddito imponibile*:
	$id_del_tag='0';
	break;
	case *reddito di impresa*:
	$id_del_tag='0';
	break;
	case *ricevitorie*:
	$id_del_tag='0';
	break;
	case *appalti di imposte*:
	$id_del_tag='0';
	break;
	case *esattori delle imposte*:
	$id_del_tag='0';
	break;
	case *concessioni governative*:
	$id_del_tag='0';
	break;
	case *tasse di imbarco e sbarco*:
	$id_del_tag='0';
	break;
	case *imposte sugli spettacoli*:
	$id_del_tag='0';
	break;
	case *imposte patrimoniali*:
	$id_del_tag='0';
	break;
	case *tributaristi*:
	$id_del_tag='0';
	break;
	case *contributi pubblici*:
	$id_del_tag='0';
	break;
	case *contributi a fondo perduto*:
	$id_del_tag='0';
	break;
	case *acconti e anticipazioni*:
	$id_del_tag='0';
	break;
	case *attivita' culturali*:
	$id_del_tag='0';
	break;
	case *bibliotecari*:
	$id_del_tag='0';
	break;
	case *periodici*:
	$id_del_tag='0';
	break;
	case *plusvalenze e sopravvenienze*:
	$id_del_tag='0';
	break;
	case *ammortamento*:
	$id_del_tag='0';
	break;
	case *capitale sociale*:
	$id_del_tag='0';
	break;
	case *investimenti privati*:
	$id_del_tag='0';
	break;
	case *confezioni e imballaggi*:
	$id_del_tag='0';
	break;
	case *etichettatura di prodotti*:
	$id_del_tag='0';
	break;
	case *magazzini e depositi*:
	$id_del_tag='0';
	break;
	case *scorte*:
	$id_del_tag='0';
	break;
	case *macchine e macchinari*:
	$id_del_tag='0';
	break;
	case *normalizzazione e standardizzazione*:
	$id_del_tag='0';
	break;
	case *periti industriali*:
	$id_del_tag='0';
	break;
	case *insegne*:
	$id_del_tag='0';
	break;
	case *sponsorizzazioni*:
	$id_del_tag='0';
	break;
	case *cementi*:
	$id_del_tag='0';
	break;
	case *acque minerali*:
	$id_del_tag='0';
	break;
	case *distillazione*:
	$id_del_tag='0';
	break;
	case *gelati*:
	$id_del_tag='0';
	break;
	case *alcool e spiriti*:
	$id_del_tag='0';
	break;
	case *oli minerali*:
	$id_del_tag='0';
	break;
	case *mobili e suppellettili*:
	$id_del_tag='0';
	break;
	case *apparecchi ottici e fotografici*:
	$id_del_tag='0';
	break;
	case *apparecchi registratori*:
	$id_del_tag='0';
	break;
	case *demolizioni*:
	$id_del_tag='0';
	break;
	case *impiantistica civile*:
	$id_del_tag='0';
	break;
	case *impianti di refrigerazione e condizionamento*:
	$id_del_tag='0';
	break;
	case *impianti di riscaldamento*:
	$id_del_tag='0';
	break;
	case *periti edili*:
	$id_del_tag='0';
	break;
	case *costruzioni anti sismiche*:
	$id_del_tag='0';
	break;
	case *minerali*:
	$id_del_tag='0';
	break;
	case *gallerie*:
	$id_del_tag='0';
	break;
	case *irrigazione*:
	$id_del_tag='0';
	break;
	case *illuminazione pubblica*:
	$id_del_tag='0';
	break;
	case *piloti*:
	$id_del_tag='0';
	break;
	case *impianti antifurto*:
	$id_del_tag='0';
	break;
	case *ascensori e montacarichi*:
	$id_del_tag='0';
	break;
	case *serbatoi*:
	$id_del_tag='0';
	break;
	case *scuole internazionali*:
	$id_del_tag='0';
	break;
	case *assistenti universitari*:
	$id_del_tag='0';
	break;
	case *docenti ordinari e straordinari*:
	$id_del_tag='0';
	break;
	case *numero chiuso o programmato*:
	$id_del_tag='0';
	break;
	case *istruzione musicale*:
	$id_del_tag='0';
	break;
	case *medicina scolastica*:
	$id_del_tag='0';
	break;
	case *assegni di studio*:
	$id_del_tag='0';
	break;
	case *trasporto di alunni e studenti*:
	$id_del_tag='0';
	break;
	case *esami e scrutini*:
	$id_del_tag='0';
	break;
	case *abilitazione professionale*:
	$id_del_tag='0';
	break;
	case *corsi di studio*:
	$id_del_tag='0';
	break;
	case *biblioteche scolastiche*:
	$id_del_tag='0';
	break;
	case *trattenimento in servizio*:
	$id_del_tag='0';
	break;
	case *consulenti del lavoro*:
	$id_del_tag='0';
	break;
	case *lavoro interinale*:
	$id_del_tag='0';
	break;
	case *cogestione*:
	$id_del_tag='0';
	break;
	case *compartecipazione*:
	$id_del_tag='0';
	break;
	case *riassunzione e richiamo in servizio*:
	$id_del_tag='0';
	break;
	case *procedimenti disciplinari*:
	$id_del_tag='0';
	break;
	case *sanzioni disciplinari*:
	$id_del_tag='0';
	break;
	case *inquadramento di personale*:
	$id_del_tag='0';
	break;
	case *personale amministrativo*:
	$id_del_tag='0';
	break;
	case *personale tecnico*:
	$id_del_tag='0';
	break;
	case *equiparazione di qualifiche*:
	$id_del_tag='0';
	break;
	case *riconoscimento di servizi o periodi lavorativi*:
	$id_del_tag='0';
	break;
	case *accordi sindacali*:
	$id_del_tag='0';
	break;
	case *custodi guardiani e portieri*:
	$id_del_tag='0';
	break;
	case *lavoro a distanza o telelavoro*:
	$id_del_tag='0';
	break;
	case *onorari e tariffe professionali*:
	$id_del_tag='0';
	break;
	case *costo del lavoro*:
	$id_del_tag='0';
	break;
	case *minimi salariali*:
	$id_del_tag='0';
	break;
	case *indennita' di sede disagiata*:
	$id_del_tag='0';
	break;
	case *indennita' di volo e di aeronavigazione*:
	$id_del_tag='0';
	break;
	case *cumulo di indennita'*:
	$id_del_tag='0';
	break;
	case *rimborso spese*:
	$id_del_tag='0';
	break;
	case *indennita' integrativa speciale*:
	$id_del_tag='0';
	break;
	case *corsi di aggiornamento*:
	$id_del_tag='0';
	break;
	case *congedo per cure*:
	$id_del_tag='0';
	break;
	case *reintegrazione nel grado o nella qualifica*:
	$id_del_tag='0';
	break;
	case *statuto dei lavoratori*:
	$id_del_tag='0';
	break;
	case *letteratura*:
	$id_del_tag='0';
	break;
	case *toponomastica*:
	$id_del_tag='0';
	break;
	case *anatomia*:
	$id_del_tag='0';
	break;
	case *organi del corpo umano*:
	$id_del_tag='0';
	break;
	case *protesi*:
	$id_del_tag='0';
	break;
	case *guaritori*:
	$id_del_tag='0';
	break;
	case *cure termali, balneari e idropiniche*:
	$id_del_tag='0';
	break;
	case *riabilitazione sanitaria*:
	$id_del_tag='0';
	break;
	case *riproduzione*:
	$id_del_tag='0';
	break;
	case *analisi chimiche*:
	$id_del_tag='0';
	break;
	case *analisi cliniche*:
	$id_del_tag='0';
	break;
	case *hanseniani*:
	$id_del_tag='0';
	break;
	case *certificati e referti sanitari*:
	$id_del_tag='0';
	break;
	case *istruttoria medico legale*:
	$id_del_tag='0';
	break;
	case *prescrizioni mediche*:
	$id_del_tag='0';
	break;
	case *oculisti*:
	$id_del_tag='0';
	break;
	case *impianti e servizi antincendi*:
	$id_del_tag='0';
	break;
	case *guardia medica*:
	$id_del_tag='0';
	break;
	case *ordinamento della repubblica*:
	$id_del_tag='0';
	break;
	case *vice ministri e sottosegretari*:
	$id_del_tag='0';
	break;
	case *rinvio presidenziale*:
	$id_del_tag='0';
	break;
	case *assegno e dotazione del presidente della repubblica*:
	$id_del_tag='0';
	break;
	case *partecipazione popolare*:
	$id_del_tag='0';
	break;
	case *rappresentanti di categorie economiche e sociali*:
	$id_del_tag='0';
	break;
	case *consigli giudiziari*:
	$id_del_tag='0';
	break;
	case *patrocinio legale*:
	$id_del_tag='0';
	break;
	case *mandato parlamentare*:
	$id_del_tag='0';
	break;
	case *sessione di bilancio*:
	$id_del_tag='0';
	break;
	case *verifica dei poteri*:
	$id_del_tag='0';
	break;
	case *macchine agricole*:
	$id_del_tag='0';
	break;
	case *legno e legname*:
	$id_del_tag='0';
	break;
	case *periti agrari e dottori agronomi*:
	$id_del_tag='0';
	break;
	case *roditori e conigli*:
	$id_del_tag='0';
	break;
	case *ministeri*:
	$id_del_tag='0';
	break;
	case *guardia costiera*:
	$id_del_tag='0';
	break;
	case *polizia di frontiera*:
	$id_del_tag='0';
	break;
	case *investigatori privati*:
	$id_del_tag='0';
	break;
	case *requisizioni*:
	$id_del_tag='0';
	break;
	case *aste pubbliche*:
	$id_del_tag='0';
	break;
	case *cessione di beni*:
	$id_del_tag='0';
	break;
	case *occupazione di spazi ed aree pubbliche*:
	$id_del_tag='0';
	break;
	case *alloggi sfitti*:
	$id_del_tag='0';
	break;
	case *ordinamento della pubblica amministrazione*:
	$id_del_tag='0';
	break;
	case *delega di competenza*:
	$id_del_tag='0';
	break;
	case *trasferimento di competenza*:
	$id_del_tag='0';
	break;
	case *contrassegni*:
	$id_del_tag='0';
	break;
	case *dissenso*:
	$id_del_tag='0';
	break;
	case *processo verbale*:
	$id_del_tag='0';
	break;
	case *silenzio assenso*:
	$id_del_tag='0';
	break;
	case *silenzio rifiuto e rigetto*:
	$id_del_tag='0';
	break;
	case *vigilanza*:
	$id_del_tag='0';
	break;
	case *istituzione di enti*:
	$id_del_tag='0';
	break;
	case *ricorsi straordinari*:
	$id_del_tag='0';
	break;
	case *soppressione e scioglimento di organi*:
	$id_del_tag='0';
	break;
	case *autorizzazioni*:
	$id_del_tag='0';
	break;
	case *divieti*:
	$id_del_tag='0';
	break;
	case *ispezioni*:
	$id_del_tag='0';
	break;
	case *attestati e certificati*:
	$id_del_tag='0';
	break;
	case *cancellazione di atti*:
	$id_del_tag='0';
	break;
	case *denunce*:
	$id_del_tag='0';
	break;
	case *limiti e valori di riferimento*:
	$id_del_tag='0';
	break;
	case *organi direttivi di enti e amministrazioni*:
	$id_del_tag='0';
	break;
	case *commissioni consigli e comitati amministrativi*:
	$id_del_tag='0';
	break;
	case *commissioni e organi consultivi*:
	$id_del_tag='0';
	break;
	case *direzioni generali*:
	$id_del_tag='0';
	break;
	case *presidenti e vice presidenti*:
	$id_del_tag='0';
	break;
	case *regioni province e comuni*:
	$id_del_tag='0';
	break;
	case *istituzione di nuovi comuni*:
	$id_del_tag='0';
	break;
	case *circoscrizioni*:
	$id_del_tag='0';
	break;
	case *consiglieri regionali*:
	$id_del_tag='0';
	break;
	case *gerarchia*:
	$id_del_tag='0';
	break;
	case *trasferimento di personale*:
	$id_del_tag='0';
	break;
	case *alloggi di servizio*:
	$id_del_tag='0';
	break;
	case *gettoni e assegni di presenza*:
	$id_del_tag='0';
	break;
	case *indennita' di funzione*:
	$id_del_tag='0';
	break;
	case *indennita' di istituto*:
	$id_del_tag='0';
	break;
	case *funzionari*:
	$id_del_tag='0';
	break;
	case *personale fuori ruolo*:
	$id_del_tag='0';
	break;
	case *personale non di ruolo, precario e avventizio*:
	$id_del_tag='0';
	break;
	case *personale a contratto*:
	$id_del_tag='0';
	break;
	case *incarichi*:
	$id_del_tag='0';
	break;
	case *stato giuridico*:
	$id_del_tag='0';
	break;
	case *riserva di posti*:
	$id_del_tag='0';
	break;
	case *immissione in ruolo*:
	$id_del_tag='0';
	break;
	case *ruoli*:
	$id_del_tag='0';
	break;
	case *ruoli ad esaurimento*:
	$id_del_tag='0';
	break;
	case *ruoli e piante organiche*:
	$id_del_tag='0';
	break;
	case *ruoli speciali*:
	$id_del_tag='0';
	break;
	case *promozioni*:
	$id_del_tag='0';
	break;
	case *promozioni a titolo onorifico*:
	$id_del_tag='0';
	break;
	case *ebraismo*:
	$id_del_tag='0';
	break;
	case *editoria elettronica*:
	$id_del_tag='0';
	break;
	case *libri*:
	$id_del_tag='0';
	break;
	case *dattilografi e stenografi*:
	$id_del_tag='0';
	break;
	case *interpreti e traduttori*:
	$id_del_tag='0';
	break;
	case *basi di dati*:
	$id_del_tag='0';
	break;
	case *antiquariato*:
	$id_del_tag='0';
	break;
	case *mercato*:
	$id_del_tag='0';
	break;
	case *garanzia dello stato*:
	$id_del_tag='0';
	break;
	case *acquisti*:
	$id_del_tag='0';
	break;
	case *cessione di valuta*:
	$id_del_tag='0';
	break;
	case *accordi e patti di produzione e commercio*:
	$id_del_tag='0';
	break;
	case *associazione in partecipazione*:
	$id_del_tag='0';
	break;
	case *generi di monopolio*:
	$id_del_tag='0';
	break;
	case *imprese di pulizia*:
	$id_del_tag='0';
	break;
	case *assegnazione di terre*:
	$id_del_tag='0';
	break;
	case *colonie*:
	$id_del_tag='0';
	break;
	case *emigrati*:
	$id_del_tag='0';
	break;
	case *deportati*:
	$id_del_tag='0';
	break;
	case *dittatura*:
	$id_del_tag='0';
	break;
	case *fiducia al governo*:
	$id_del_tag='0';
	break;
	case *mozione di sfiducia*:
	$id_del_tag='0';
	break;
	case *inquinamento luminoso*:
	$id_del_tag='0';
	break;
	case *cartografia*:
	$id_del_tag='0';
	break;
	case *scienze biologiche e naturali*:
	$id_del_tag='0';
	break;
	case *biologi*:
	$id_del_tag='0';
	break;
	case *scienze della terra*:
	$id_del_tag='0';
	break;
	case *erosione marina e subsidenza*:
	$id_del_tag='0';
	break;
	case *zone sismiche*:
	$id_del_tag='0';
	break;
	case *fisici*:
	$id_del_tag='0';
	break;
	case *eta' delle persone*:
	$id_del_tag='0';
	break;
	case *sociologia*:
	$id_del_tag='0';
	break;
	case *indici statistici*:
	$id_del_tag='0';
	break;
	case *reddito minimo*:
	$id_del_tag='0';
	break;
	case *sussidi*:
	$id_del_tag='0';
	break;
	case *patronati*:
	$id_del_tag='0';
	break;
	case *accompagnatori*:
	$id_del_tag='0';
	break;
	case *ricongiunzione a fini assicurativi o previdenziali*:
	$id_del_tag='0';
	break;
	case *accertamenti contributivi*:
	$id_del_tag='0';
	break;
	case *contributi figurativi*:
	$id_del_tag='0';
	break;
	case *cambiali*:
	$id_del_tag='0';
	break;
	case *quote di partecipazione*:
	$id_del_tag='0';
	break;
	case *gestioni fiduciarie*:
	$id_del_tag='0';
	break;
	case *bandiere*:
	$id_del_tag='0';
	break;
	case *decorazioni civili*:
	$id_del_tag='0';
	break;
	case *ordini cavallereschi*:
	$id_del_tag='0';
	break;
	case *carte geografiche*:
	$id_del_tag='0';
	break;
	case *trasporti extra urbani*:
	$id_del_tag='0';
	break;
	case *documenti di circolazione*:
	$id_del_tag='0';
	break;
	case *trasporti speciali*:
	$id_del_tag='0';
	break;
	case *pedaggi*:
	$id_del_tag='0';
	break;
	case *ferrovieri*:
	$id_del_tag='0';
	break;
	case *capitanerie di porto e uffici marittimi*:
	$id_del_tag='0';
	break;
	case *marinai e marittimi*:
	$id_del_tag='0';
	break;
	case *peso netto*:
	$id_del_tag='0';
	break;
	case *orario*:
	$id_del_tag='0';
	break;
	case *pesi e misure*:
	$id_del_tag='0';
	break;
	case *strutture di tipo extra ospedaliero*:
	$id_del_tag='0';
	break;
	case *case di riposo*:
	$id_del_tag='0';
	break;
	case *piscine*:
	$id_del_tag='0';
	break;
	case *stabilimenti balneari e termali*:
	$id_del_tag='0';
	break;
	case *geometri*:
	$id_del_tag='0';
	break;
	case *progetti e progettazione*:
	$id_del_tag='0';
	break;
	case *zone e aree protette*:
	$id_del_tag='0';
	break;
	case *strumenti urbanistici*:
	$id_del_tag='0';
	break;
	case *piani di ricostruzione*:
	$id_del_tag='0';
	break;
	case *giffoni valle piana (sa)*:
	$id_del_tag='0';
	break;
	case *acna di cengio*:
	$id_del_tag='0';
	break;
	case *associazioni proloco*:
	$id_del_tag='0';
	break;
	case *savoia*:
	$id_del_tag='0';
	break;
	case *comitato esecutivo per i servizi di informazione e sicurezza ( cesis )*:
	$id_del_tag='0';
	break;
	case *comitato parlamentare per i servizi di informazione e sicurezza e per il segreto di stato*:
	$id_del_tag='0';
	break;
	case *consiglio di presidenza della giustizia tributaria*:
	$id_del_tag='0';
	break;
	case *corpo nazionale soccorso alpino e speleologico*:
	$id_del_tag='0';
	break;
	case *ente nazionale di previdenza ed assistenza dei farmacisti*:
	$id_del_tag='0';
	break;
	case *ente per la tutela del lupo italiano ( etli )*:
	$id_del_tag='0';
	break;
	case *guerra di spagna*:
	$id_del_tag='0';
	break;
	case *istituto per il credito sportivo*:
	$id_del_tag='0';
	break;
	case *istituto superiore di educazione fisica ( isef )*:
	$id_del_tag='0';
	break;
	case *lingua catalana*:
	$id_del_tag='0';
	break;
	case *lingua sarda*:
	$id_del_tag='0';
	break;
	case *magistrato alle acque*:
	$id_del_tag='0';
	break;
	case *parco della riserva marina di orosei*:
	$id_del_tag='0';
	break;
	case *repubblica sociale italiana (rsi)*:
	$id_del_tag='0';
	break;
	case *scuola mosaicisti del friuli*:
	$id_del_tag='0';
	break;
	case *servizio per le informazioni e la sicurezza militare (sismi)*:
	$id_del_tag='0';
	break;
	case *sistema satellitare di navigazione globale gnss-galileo*:
	$id_del_tag='0';
	break;
	case *sistema statistico nazionale (sistan)*:
	$id_del_tag='0';
	break;
	case *ufficio notificazioni, esecuzioni e protesti (unep)*:
	$id_del_tag='0';
	break;
	case *unione delle repubbliche socialiste sovietiche ( urss )*:
	$id_del_tag='0';
	break;
	case *unione italiana delle chiese cristiane avventiste*:
	$id_del_tag='0';
	break;
	case *unione nazionale mutilati per servizio ( unms )*:
	$id_del_tag='0';
	break;
	case *valutazione e classificazione*:
	$id_del_tag='0';
	break;
	case *trasmissioni in forma codificata*:
	$id_del_tag='0';
	break;
	case *agenzia per le erogazioni in agricoltura ( agea )*:
	$id_del_tag='0';
	break;
	case *anno finanziario 2007*:
	$id_del_tag='0';
	break;
	case *parco nazionale della pace di s. anna di stazzema ( lucca )*:
	$id_del_tag='0';
	break;
	case *italia lavoro spa*:
	$id_del_tag='0';
	break;
	case *consulta araldica*:
	$id_del_tag='0';
	break;
	case *garante del contribuente*:
	$id_del_tag='0';
	break;
	case *gruppo cirio*:
	$id_del_tag='0';
	break;
	case *gruppo parmalat spa*:
	$id_del_tag='0';
	break;
	case *istituto nazionale per la fauna selvatica ( infs )*:
	$id_del_tag='0';
	break;
	case *museo storico della liberazione*:
	$id_del_tag='0';
	break;
	case *organizzazione internazionale della vigna e del vino (oiv)*:
	$id_del_tag='0';
	break;
	case *struttura di difesa stay behind denominata gladio*:
	$id_del_tag='0';
	break;
	case *anno finanziario 2008*:
	$id_del_tag='0';
	break;
	case *giustizia sportiva*:
	$id_del_tag='0';
	break;
	case *lavanderie e tintorie*:
	$id_del_tag='0';
	break;
	case *voto elettronico*:
	$id_del_tag='0';
	break;
	case *scuola dell' infanzia*:
	$id_del_tag='0';
	break;
	case *librerie*:
	$id_del_tag='0';
	break;
	case *legge comunitaria*:
	$id_del_tag='0';
	break;
	case *impianti e reti per l' esercizio di servizi*:
	$id_del_tag='0';
	break;
	case *fermo di beni mobili*:
	$id_del_tag='0';
	break;
	case *fermo amministrativo*:
	$id_del_tag='0';
	break;
	case *scuola superiore della pubblica amministrazione*:
	$id_del_tag='0';
	break;
	case *monte bianco*:
	$id_del_tag='0';
	break;
	case *fondo di solidarieta' per le vittime delle richieste estorsive e dell' usura*:
	$id_del_tag='0';
	break;
	case *giunta storica nazionale*:
	$id_del_tag='0';
	break;
	case *indennita' e fondi incentivanti*:
	$id_del_tag='0';
	break;
	case *istituti di ricovero e cura a carattere scientifico ( irccs )*:
	$id_del_tag='0';
	break;
	case *libretto sanitario personale*:
	$id_del_tag='0';
	break;
	case *ragionieri*:
	$id_del_tag='0';
	break;
	case *indennita' speciali*:
	$id_del_tag='0';
	break;
	case *giochi*:
	$id_del_tag='0';
	break;
	case *assemblee di societa' e di enti*:
	$id_del_tag='0';
	break;
	case *nomina del personale*:
	$id_del_tag='0';
	break;
	case *competenza territoriale*:
	$id_del_tag='0';
	break;
	case *tirocinio di formazione*:
	$id_del_tag='0';
	break;
	case *vittime*:
	$id_del_tag='0';
	break;
	case *specialita' medica*:
	$id_del_tag='0';
	break;
	case *contributi sociali*:
	$id_del_tag='0';
	break;
	case *riserva contabile*:
	$id_del_tag='0';
	break;
	case *contratti di prestazione di servizi*:
	$id_del_tag='0';
	break;
	case *mozione di censura*:
	$id_del_tag='0';
	break;
	case *personale*:
	$id_del_tag='0';
	break;
	case *prefabbricati*:
	$id_del_tag='0';
	break;
	case *utile*:
	$id_del_tag='0';
	break;
	case *zone protette*:
	$id_del_tag='0';
	break;
	case *protocollo di accordo*:
	$id_del_tag='0';
	break;
	case *amministrazione controllata*:
	$id_del_tag='0';
	break;
	case *pianificazione nazionale*:
	$id_del_tag='0';
	break;
	case *diritto acquisito*:
	$id_del_tag='0';
	break;
	case *lavoro non remunerato*:
	$id_del_tag='0';
	break;
	case *personale di segreteria*:
	$id_del_tag='0';
	break;
	case *insediamento di centrale*:
	$id_del_tag='0';
	break;
	case *libera circolazione dei lavoratori*:
	$id_del_tag='0';
	break;
	case *transito*:
	$id_del_tag='0';
	break;
	case *stoccaggio*:
	$id_del_tag='0';
	break;
	case *manufatto*:
	$id_del_tag='0';
	break;
	case *estremismo*:
	$id_del_tag='0';
	break;
	case *traffico illecito*:
	$id_del_tag='0';
	break;
	case *zone pedonali*:
	$id_del_tag='0';
	break;
	case *relazioni culturali*:
	$id_del_tag='0';
	break;
	case *norme*:
	$id_del_tag='0';
	break;
	case *vendita diretta*:
	$id_del_tag='0';
	break;
	case *industria del freddo*:
	$id_del_tag='0';
	break;
	case *competitivita'*:
	$id_del_tag='0';
	break;
	case *investimenti*:
	$id_del_tag='0';
	break;
	case *custodia dei bambini*:
	$id_del_tag='0';
	break;
	case *zone sinistrate*:
	$id_del_tag='0';
	break;
	case *investimenti industriali*:
	$id_del_tag='0';
	break;
	case *politica spaziale*:
	$id_del_tag='0';
	break;
	case *beni di consumo*:
	$id_del_tag='0';
	break;
	case *trivellazioni*:
	$id_del_tag='0';
	break;
	case *prodotti congelati*:
	$id_del_tag='0';
	break;
	case *prodotti freschi*:
	$id_del_tag='0';
	break;
	case *assegni*:
	$id_del_tag='0';
	break;
	case *verifica ispettiva*:
	$id_del_tag='0';
	break;
	case *punto di vendita*:
	$id_del_tag='0';
	break;
	case *vita lavorativa*:
	$id_del_tag='0';
	break;
	case *viaggi*:
	$id_del_tag='0';
	break;
	case *personale di guida*:
	$id_del_tag='0';
	break;
	case *societa' in partecipazione*:
	$id_del_tag='0';
	break;
	case *personale di bordo*:
	$id_del_tag='0';
	break;
	case *acido*:
	$id_del_tag='0';
	break;
	case *governance*:
	$id_del_tag='0';
	break;
	case *prestazione sociale*:
	$id_del_tag='0';
	break;
	case *macchine per uffucio*:
	$id_del_tag='0';
	break;
	case *quorum*:
	$id_del_tag='0';
	break;
	case *diritti economici*:
	$id_del_tag='0';
	break;
	case *accordi economici e commerciali*:
	$id_del_tag='0';
	break;
	case *contratti assicurativi*:
	$id_del_tag='0';
	break;
	case *zone e aree turistiche*:
	$id_del_tag='0';
	break;
	case *organizzazioni culturali*:
	$id_del_tag='0';
	break;
	case *spese di funzionamento*:
	$id_del_tag='0';
	break;
	case *sito storico*:
	$id_del_tag='0';
	break;
	case *riconoscimento onorifico*:
	$id_del_tag='0';
	break;
	case *pagamenti internazionali*:
	$id_del_tag='0';
	break;
	case *ufficio del lavoro*:
	$id_del_tag='0';
	break;
	case *politica di sostegno*:
	$id_del_tag='0';
	break;
	case *produzione*:
	$id_del_tag='0';
	break;
	case *trasferimento di capitali*:
	$id_del_tag='0';
	break;
	case *segretari generali*:
	$id_del_tag='0';
	break;
	case *maggioranza assoluta*:
	$id_del_tag='0';
	break;
	case *materie prima*:
	$id_del_tag='0';
	break;
	case *proprieta' pubblica*:
	$id_del_tag='0';
	break;
	case *maggioranza qualificata*:
	$id_del_tag='0';
	break;
	case *ripartizione dei voti*:
	$id_del_tag='0';
	break;
	case *perizie giudiziarie*:
	$id_del_tag='0';
	break;
	case *sanita' del lavoro*:
	$id_del_tag='0';
	break;
	case *piombo*:
	$id_del_tag='0';
	break;
	case *maggioranza dei voti*:
	$id_del_tag='0';
	break;
	case *gestione delle risorse*:
	$id_del_tag='0';
	break;
	case *poliglottismo*:
	$id_del_tag='0';
	break;
	case *elicotteri*:
	$id_del_tag='0';
	break;
	case *ormoni*:
	$id_del_tag='0';
	break;
	case *sicurezza del prodotto*:
	$id_del_tag='0';
	break;
	case *adulti*:
	$id_del_tag='0';
	break;
	case *posizione dominante*:
	$id_del_tag='0';
	break;
	case *pubblicita' dei conti*:
	$id_del_tag='0';
	break;
	case *conflitti etnici*:
	$id_del_tag='0';
	break;
	case *mercato comunitario*:
	$id_del_tag='0';
	break;
	case *mercato interno*:
	$id_del_tag='0';
	break;
	case *beni strumentali*:
	$id_del_tag='0';
	break;
	case *alluminio*:
	$id_del_tag='0';
	break;
	case *climatizzazione*:
	$id_del_tag='0';
	break;
	case *crisi energetica*:
	$id_del_tag='0';
	break;
	case *infrastruttura economica*:
	$id_del_tag='0';
	break;
	case *capo dell'opposizione*:
	$id_del_tag='0';
	break;
	case *elezioni presidenziali*:
	$id_del_tag='0';
	break;
	case *interventi finanziari*:
	$id_del_tag='0';
	break;
	case *produzione animale*:
	$id_del_tag='0';
	break;
	case *titolo di trasporto*:
	$id_del_tag='0';
	break;
	case *ghiaccio*:
	$id_del_tag='0';
	break;
	case *invenzione*:
	$id_del_tag='0';
	break;
	case *protezionismo*:
	$id_del_tag='0';
	break;
	case *pneumatici*:
	$id_del_tag='0';
	break;
	case *paesi terzi*:
	$id_del_tag='0';
	break;
	case *zone urbane*:
	$id_del_tag='0';
	break;
	case *legislazione*:
	$id_del_tag='0';
	break;
	case *nazionalita'*:
	$id_del_tag='0';
	break;
	case *zone di frontiera*:
	$id_del_tag='0';
	break;
	case *vetro*:
	$id_del_tag='0';
	break;
	case *organizazione mondiale della propriet*:
	$id_del_tag='0';
	break;
	case *protocollo*:
	$id_del_tag='0';
	break;
	case *risoluzione di contratto*:
	$id_del_tag='0';
	break;
	case *autogestione*:
	$id_del_tag='0';
	break;
	case *prodotti semilavorati*:
	$id_del_tag='0';
	break;
	case *vendita all'asta*:
	$id_del_tag='0';
	break;
	case *regolamentazione delle intese*:
	$id_del_tag='0';
	break;
	case *scorte pubbliche*:
	$id_del_tag='0';
	break;
	case *reattore nucleare*:
	$id_del_tag='0';
	break;
	case *pietra*:
	$id_del_tag='0';
	break;
	case *cuoio*:
	$id_del_tag='0';
	break;
	case *zone umide*:
	$id_del_tag='0';
	break;
	case *mutilazione sessuale*:
	$id_del_tag='0';
	break;
	case *personale dei trasporti*:
	$id_del_tag='0';
	break;
	case *moralita' della vita economica*:
	$id_del_tag='0';
	break;
	case *professioni urbanistiche*:
	$id_del_tag='0';
	break;
	case *emissione di valori*:
	$id_del_tag='0';
	break;
	case *polvere*:
	$id_del_tag='0';
	break;
	case *pubblicazione*:
	$id_del_tag='0';
	break;
	case *regolamenti interni*:
	$id_del_tag='0';
	break;
	case *personale civile*:
	$id_del_tag='0';
	break;
	case *diritto assicurativo*:
	$id_del_tag='0';
	break;
	case *investimenti esteri*:
	$id_del_tag='0';
	break;
	case *prodotti in scatola*:
	$id_del_tag='0';
	break;
	case *agenzia europea per i medicinali*:
	$id_del_tag='0';
	break;
	case *metallo pesante*:
	$id_del_tag='0';
	break;
	case *professioni finanziarie*:
	$id_del_tag='0';
	break;
	case *reddito non salariale*:
	$id_del_tag='0';
	break;
	case *limitazione della commercializzazione*:
	$id_del_tag='0';
	break;
	case *risorse economiche*:
	$id_del_tag='0';
	break;
	case *politica commerciale comune*:
	$id_del_tag='0';
	break;
	case *manifesto*:
	$id_del_tag='0';
	break;
	case *regionalizzazione*:
	$id_del_tag='0';
	break;
	case *responsabilita' del produttore*:
	$id_del_tag='0';
	break;
	case *prodotti difettosi*:
	$id_del_tag='0';
	break;
	case *separazione dei poteri*:
	$id_del_tag='0';
	break;
	case *indagini conoscitive*:
	$id_del_tag='0';
	break;
	case *apparecchi elettrici*:
	$id_del_tag='0';
	break;
	case *istituto di studi e analisi economica ( isae )*:
	$id_del_tag='0';
	break;
	case *diritti sociali*:
	$id_del_tag='0';
	break;
	case *legislazione forestale*:
	$id_del_tag='0';
	break;
	case *opera nazionale pensionati d' italia (onpi)*:
	$id_del_tag='0';
	break;
	case *concessionaria servizi informativi pubblici s.p.a . ( consip )*:
	$id_del_tag='0';
	break;
	case *centri di ricerca in agrumicoltura (cra )*:
	$id_del_tag='0';
	break;
	case *ente nazionale della cinofilia italiana ( enci )*:
	$id_del_tag='0';
	break;
	case *tariffazione delle infrastrutture*:
	$id_del_tag='0';
	break;
	case *svalutazione del capitale*:
	$id_del_tag='0';
	break;
	case *veicoli industriali*:
	$id_del_tag='0';
	break;
	case *repressione*:
	$id_del_tag='0';
	break;
	case *industria calzaturiera*:
	$id_del_tag='0';
	break;
	case *ente italiano della montagna ( eim )*:
	$id_del_tag='0';
	break;
	case *cloro*:
	$id_del_tag='0';
	break;
	case *ottica*:
	$id_del_tag='0';
	break;
	case *personale di servizio*:
	$id_del_tag='0';
	break;
	case *insediamento industriale*:
	$id_del_tag='0';
	break;
	case *vita associativa*:
	$id_del_tag='0';
	break;
	case *macchine idrauliche*:
	$id_del_tag='0';
	break;
	case *zone inquinate*:
	$id_del_tag='0';
	break;
	case *industria aeronautica*:
	$id_del_tag='0';
	break;
	case *servizio volontario*:
	$id_del_tag='0';
	break;
	case *metodo di apprendimento*:
	$id_del_tag='0';
	break;
	case *politica della gioventu'*:
	$id_del_tag='0';
	break;
	case *ideologie politiche*:
	$id_del_tag='0';
	break;
	case *tariffa delle comunicazioni*:
	$id_del_tag='0';
	break;
	case *metrologia*:
	$id_del_tag='0';
	break;
	case *studio di mercato*:
	$id_del_tag='0';
	break;
	case *lavoro sociale*:
	$id_del_tag='0';
	break;
	case *sciopero della fame*:
	$id_del_tag='0';
	break;
	case *gas di combustione*:
	$id_del_tag='0';
	break;
	case *personale di terra*:
	$id_del_tag='0';
	break;
	case *ghisa*:
	$id_del_tag='0';
	break;
	case *terreni erbosi*:
	$id_del_tag='0';
	break;
	case *frontiera*:
	$id_del_tag='0';
	break;
	case *usi e costumi*:
	$id_del_tag='0';
	break;
	case *veto*:
	$id_del_tag='0';
	break;
	case *popolazione in eta' lavorativa*:
	$id_del_tag='0';
	break;
	case *politica dei redditi*:
	$id_del_tag='0';
	break;
	case *interesse collettivo*:
	$id_del_tag='0';
	break;
	case *omologazione*:
	$id_del_tag='0';
	break;
	case *investimenti di capitali*:
	$id_del_tag='0';
	break;
	case *scambi commerciali*:
	$id_del_tag='0';
	break;
	case *societa' di persone*:
	$id_del_tag='0';
	break;
	case *patrocinio*:
	$id_del_tag='0';
	break;
	case *produttivita' del lavoro*:
	$id_del_tag='0';
	break;
	case *marcatura*:
	$id_del_tag='0';
	break;
	case *integrazione economica*:
	$id_del_tag='0';
	break;
	case *offerta pubblica di acquisto*:
	$id_del_tag='0';
	break;
	case *professioni letterarie*:
	$id_del_tag='0';
	break;
	case *mobilita' sociale*:
	$id_del_tag='0';
	break;
	case *indebitamento*:
	$id_del_tag='0';
	break;
	case *industria conserviera*:
	$id_del_tag='0';
	break;
	case *istituzioni pubbliche di assistenza e beneficenza ( ipab )*:
	$id_del_tag='0';
	break;
	case *operatori sociali*:
	$id_del_tag='0';
	break;
	case *arti visive*:
	$id_del_tag='0';
	break;
	case *dichiarazione di voto*:
	$id_del_tag='0';
	break;
	case *mercato estero*:
	$id_del_tag='0';
	break;
	case *societa' autostrada pedemontana lombarda*:
	$id_del_tag='0';
	break;
	case *zone suburbane*:
	$id_del_tag='0';
	break;
	case *sanzioni economiche*:
	$id_del_tag='0';
	break;
	case *economia domestica*:
	$id_del_tag='0';
	break;
	case *automazione*:
	$id_del_tag='0';
	break;
	case *cisgiordania*:
	$id_del_tag='0';
	break;
	case *organizzazione internazionale del volo civile ( icao )*:
	$id_del_tag='0';
	break;
	case *responsabilita' parentale*:
	$id_del_tag='0';
	break;
	case *potere politico*:
	$id_del_tag='0';
	break;
	case *sintesi di testi*:
	$id_del_tag='0';
	break;
	case *stoccaggio degli alimenti*:
	$id_del_tag='0';
	break;
	case *societa' d'investimento*:
	$id_del_tag='0';
	break;
	case *etanolo*:
	$id_del_tag='0';
	break;
	case *proprieta' mobiliare*:
	$id_del_tag='0';
	break;
	case *europa*:
	$id_del_tag='0';
	break;
	case *giurisprudenza*:
	$id_del_tag='0';
	break;
	case *maggioranza politica*:
	$id_del_tag='0';
	break;
	case *pavimentazioni*:
	$id_del_tag='0';
	break;
	case *privazione di diritti*:
	$id_del_tag='0';
	break;
	case *obiettivo di produzione*:
	$id_del_tag='0';
	break;
	case *valutazione del personale*:
	$id_del_tag='0';
	break;
	case *codici di condotta*:
	$id_del_tag='0';
	break;
	case *pedemontana di formia*:
	$id_del_tag='0';
	break;
	case *pontina*:
	$id_del_tag='0';
	break;
	case *mercato fondiario*:
	$id_del_tag='0';
	break;
	case *tutela dei rsparmiatori*:
	$id_del_tag='0';
	break;
	case *pubblicita'  patrimoniale degli eletti*:
	$id_del_tag='0';
	break;
	case *bilancio di genere*:
	$id_del_tag='0';
	break;
	case *collegio del mondo unito dell'adriatico*:
	$id_del_tag='0';
	break;
	case *gaza*:
	$id_del_tag='0';
	break;
	case *commissione paritetica friuli venezia giulia*:
	$id_del_tag='0';
	break;
	case *adecco spa*:
	$id_del_tag='0';
	break;
	case *ex campi di concentramento*:
	$id_del_tag='0';
	break;
	case *cattiva amministrazone*:
	$id_del_tag='0';
	break;
	case *boicottaggio degli ebrei*:
	$id_del_tag='0';
	break;
	case *immunologia*:
	$id_del_tag='0';
	break;
	case *impugnazione di atti*:
	$id_del_tag='0';
	break;
	case *ministero dello sviluppo economico*:
	$id_del_tag='0';
	break;
	case *centri sociali*:
	$id_del_tag='0';
	break;
	case *ama - azienda municipalizzata ambiente (rm)*:
	$id_del_tag='0';
	break;
	case *qualit dei servizi*:
	$id_del_tag='0';
	break;
	case *porte e serramenti*:
	$id_del_tag='0';
	break;
	case *retribuzione amministratori societa'  partecipate*:
	$id_del_tag='0';
	break;
	case *eutelia s.p.a.*:
	$id_del_tag='0';
	break;
	case *ales spa*:
	$id_del_tag='0';
	break;
	case *ebrei*:
	$id_del_tag='0';
	break;
	case *villa reale di monza*:
	$id_del_tag='0';
	break;
	case *servizio militare femminile*:
	$id_del_tag='0';
	break;
	case *zone climatiche*:
	$id_del_tag='0';
	break;
	case *enzo baldoni*:
	$id_del_tag='0';
	break;
	case *sorgenia*:
	$id_del_tag='0';
	break;
	case *mercati*:
	$id_del_tag='0';
	break;
	case *assitenza sanitaria*:
	$id_del_tag='0';
	break;
	case *indennita'  di missione*:
	$id_del_tag='0';
	break;
	case *decreti ministeriali*:
	$id_del_tag='0';
	break;
	case *federazione medico sportiva italiana (fmsi)*:
	$id_del_tag='0';
	break;
	case *trasferimenti erariali*:
	$id_del_tag='0';
	break;
	case *centri di accoglienza*:
	$id_del_tag='0';
	break;
	case *sviluppo di carriera*:
	$id_del_tag='0';
	break;
	case *organizzazione idrografica internazionale (ihb)*:
	$id_del_tag='0';
	break;
	case *gatti*:
	$id_del_tag='0';
	break;
	case *referendum abrogativo articolifai click per espandere questa voce*:
	$id_del_tag='0';
	break;
	case *call center*:
	$id_del_tag='0';
	break;
	case *attivita' e operatori subacquei*:
	$id_del_tag='0';
	break;
	case *impregilo spa*:
	$id_del_tag='0';
	break;
	case *agenzia di coordinamento per le erogazioni in agricoltura (acea)*:
	$id_del_tag='0';
	break;
	case *centro di formazione e studi per il mezzogiorno (formez)*:
	$id_del_tag='0';
	break;
	case *comitati interministeriali*:
	$id_del_tag='0';
	break;
	case *abrogazione di norme*:
	$id_del_tag='0';
	break;
	case *agenzia italiana per l' attrazione degli investimenti e lo sviluppo d' impresa spa*:
	$id_del_tag='0';
	break;
	case *private e mutue assicuratrici*:
	$id_del_tag='0';
	break;
	case *ente per lo sviluppo dell' irrigazione e per la trasformazione fondiaria ed agraria in puglia e lucania*:
	$id_del_tag='0';
	break;
	case *ente italiano montagna (eim)*:
	$id_del_tag='0';
	break;
	case *fintecna - finanziaria per i settori industriale e dei servizi spa*:
	$id_del_tag='0';
	break;
	case *fondi speciali di bilancio*:
	$id_del_tag='0';
	break;
	case *fusione*:
	$id_del_tag='0';
	break;
	case *materie prime*:
	$id_del_tag='0';
	break;
	case *istituto nazionale di geofisica e vulcanologia*:
	$id_del_tag='0';
	break;
	case *ronde*:
	$id_del_tag='0';
	break;
	case *industria bellica*:
	$id_del_tag='0';
	break;
	case *qualita' del prodotto*:
	$id_del_tag='0';
	break;
	case *rete da pesca*:
	$id_del_tag='0';
	break;
	case *citta'  d'arte*:
	$id_del_tag='0';
	break;
	case *ente per le nuove tecnologie*:
	$id_del_tag='0';
	break;
	case *l'energia e l' ambiente ( enea )*:
	$id_del_tag='0';
	break;
	case *sogin spa*:
	$id_del_tag='0';
	break;
	case *provincia aquila*:
	$id_del_tag='4913';
	break;
	case *provincia l'aquila*: 
	$id_del_tag='4913';
	break;
	case *societa'  partecipate*:
	$id_del_tag='0';
	break;
	case *principio di addizionalita'*:
	$id_del_tag='0';
	break;
	case *scheda elettorale*:
	$id_del_tag='0';
	break;
	
	case *arte  moderna*:
	$id_del_tag='5';
	break;
	case *pittura e scultura*:
	$id_del_tag='5';
	break;
	case *fotografia*:
	$id_del_tag='5';
	break;
	case *professioni artistiche*:
	$id_del_tag='5';
	break;
	case *oreficeria*:
	$id_del_tag='8';
	break;
	case *pellami e pellicce*:
	$id_del_tag='9';
	break;
	case *imprese artigiane*:
	$id_del_tag='9';
	break;
	case *laboratori e officine*:
	$id_del_tag='9';
	break;
	case *parrucchieri e barbieri*:
	$id_del_tag='9';
	break;
	case *tatuaggi e piercing*:
	$id_del_tag='9';
	break;
	case *confederazione nazionale dell'artigianato (cna)*:
	$id_del_tag='9';
	break;
	case *regolamentazione della caccia*:
	$id_del_tag='11';
	break;
	case *giochi d' azzardo*:
	$id_del_tag='13';
	break;
	case *artisti dello spettacolo*:
	$id_del_tag='15';
	break;
	case *circhi equestri e spettacoli viaggianti*:
	$id_del_tag='15';
	break;
	case *lavoratori dello spettacolo*:
	$id_del_tag='15';
	break;
	case *fondo unico per lo spettacolo ( fus )*:
	$id_del_tag='15';
	break;
	case *sport professionale*:
	$id_del_tag='23';
	break;
	case *istruttori sportivi*:
	$id_del_tag='23';
	break;
	case *sport alpini e invernali*:
	$id_del_tag='23';
	break;
	case *sport equestri*:
	$id_del_tag='23';
	break;
	case *pugilato*:
	$id_del_tag='23';
	break;
	case *attrezzature sportive*:
	$id_del_tag='23';
	break;
	case *comitato italiano paralimpico ( cip )*:
	$id_del_tag='23';
	break;
	case *federazione ginnastica d'italia (fgdi)*:
	$id_del_tag='23';
	break;
	case *federazione italiana gioco calcio ( figc )*:
	$id_del_tag='25';
	break;
	case *manifestazioni sportive*:
	$id_del_tag='30';
	break;
	case *organizzazioni sportive*:
	$id_del_tag='30';
	break;
	case *bande musicali cori e orchestre*:
	$id_del_tag='40';
	break;
	case *musica popolare*:
	$id_del_tag='40';
	break;
	case *strumenti musicali*:
	$id_del_tag='40';
	break;
	case *musica leggera*:
	$id_del_tag='40';
	break;
	case *politica di difesa*:
	$id_del_tag='45';
	break;
	case *agenzia industrie difesa*:
	$id_del_tag='45';
	break;
	case *caserme*:
	$id_del_tag='52';
	break;
	case *personale civile delle forze armate*:
	$id_del_tag='53';
	break;
	case *sottufficiali*:
	$id_del_tag='53';
	break;
	case *ufficiali*:
	$id_del_tag='53';
	break;
	case *ufficiali di complemento*:
	$id_del_tag='53';
	break;
	case *ufficiali in ausiliaria*:
	$id_del_tag='53';
	break;
	case *accademie e scuole militari*:
	$id_del_tag='53';
	break;
	case *licenze e congedo militare*:
	$id_del_tag='53';
	break;
	case *divise ed insegne militari*:
	$id_del_tag='53';
	break;
	case *rappresentanza militare*:
	$id_del_tag='53';
	break;
	case *uffciali*:
	$id_del_tag='53';
	break;
	case *disciplina militare*:
	$id_del_tag='53';
	break;
	case *generali e ammiragli*:
	$id_del_tag='57';
	break;
	case *corpo degli alpini*:
	$id_del_tag='57';
	break;
	case *militari di truppa*:
	$id_del_tag='69';
	break;
	case *personale militarizzato*:
	$id_del_tag='69';
	break;
	case *reclutamento militare*:
	$id_del_tag='69';
	break;
	case *decorazioni militari*:
	$id_del_tag='69';
	break;
	case *ricompense al valore militare*:
	$id_del_tag='69';
	break;
	case *avanzamento di militari*:
	$id_del_tag='69';
	break;
	case *servizio militare di leva*:
	$id_del_tag='90';
	break;
	case *servizio permanente effettivo*:
	$id_del_tag='90';
	break;
	case *decreti legislativi delegati*:
	$id_del_tag='116';
	break;
	case *retroattivita' della legge*:
	$id_del_tag='0';
	break;
	case *revisione della legge*:
	$id_del_tag='0';
	break;
	case *capacita' di intendere e di volere*:
	$id_del_tag='130';
	break;
	case *capacita' di agire*:
	$id_del_tag='130';
	break;
	case *clausole contrattuali*:
	$id_del_tag='130';
	break;
	case *rescissione e risoluzione di contratti*:
	$id_del_tag='130';
	break;
	case *cauzioni e depositi cauzionali*:
	$id_del_tag='130';
	break;
	case *ipoteche*:
	$id_del_tag='130';
	break;
	case *responsabilita' civile*:
	$id_del_tag='130';
	break;
	case *colpa*:
	$id_del_tag='130';
	break;
	case *dolo*:
	$id_del_tag='130';
	break;
	case *azione civile*:
	$id_del_tag='130';
	break;
	case *sentenze civili*:
	$id_del_tag='130';
	break;
	case *arbitrato e conciliazione*:
	$id_del_tag='130';
	break;
	case *processo civile*:
	$id_del_tag='130';
	break;
	case *atti processuali civili*:
	$id_del_tag='130';
	break;
	case *termini nel processo civile*:
	$id_del_tag='130';
	break;
	case *liquidazione delle spese*:
	$id_del_tag='130';
	break;
	case *diritto di prelazione*:
	$id_del_tag='130';
	break;
	case *socio*:
	$id_del_tag='130';
	break;
	case *responsabilita' contrattuale*:
	$id_del_tag='130';
	break;
	case *codice civile*:
	$id_del_tag='130';
	break;
	case *liquidazione dei beni*:
	$id_del_tag='130';
	break;
	case *prescrizione della pena*:
	$id_del_tag='134';
	break;
	case *prescrizione del reato*:
	$id_del_tag='134';
	break;
	case *affissione pubblica*:
	$id_del_tag='136';
	break;
	case *associazioni sportive e polisportive*:
	$id_del_tag='141';
	break;
	case *centri e strutture di utilita' sociale*:
	$id_del_tag='141';
	break;
	case *associazioni culturali e ricreative*:
	$id_del_tag='141';
	break;
	case *associazioni professionali*:
	$id_del_tag='141';
	break;
	case *orfani*:
	$id_del_tag='151';
	break;
	case *abbandono di minore*:
	$id_del_tag='151';
	break;
	case *infanzia*:
	$id_del_tag='151';
	break;
	case *diritti del bambino*:
	$id_del_tag='151';
	break;
	case *protezione dell'infanzia*:
	$id_del_tag='151';
	break;
	case *stato civile*:
	$id_del_tag='153';
	break;
	case *domicilio residenza dimora*:
	$id_del_tag='153';
	break;
	case *nome e cognome*:
	$id_del_tag='153';
	break;
	case *residenza*:
	$id_del_tag='153';
	break;
	case *atti di disposizione*:
	$id_del_tag='206';
	break;
	case *ascendenti e discendenti*:
	$id_del_tag='206';
	break;
	case *concepiti*:
	$id_del_tag='206';
	break;
	case *riconoscimento di figli naturali*:
	$id_del_tag='206';
	break;
	case *potesta' dei genitori*:
	$id_del_tag='206';
	break;
	case *cessazione del matrimonio*:
	$id_del_tag='206';
	break;
	case *assegni alimentari*:
	$id_del_tag='206';
	break;
	case *conviventi*:
	$id_del_tag='206';
	break;
	case *comunione dei beni*:
	$id_del_tag='206';
	break;
	case *obbligo di assistenza e mantenimento*:
	$id_del_tag='206';
	break;
	case *coniugi*:
	$id_del_tag='206';
	break;
	case *successioni*:
	$id_del_tag='206';
	break;
	case *eredi ed eredita'*:
	$id_del_tag='206';
	break;
	case *testamenti e legati*:
	$id_del_tag='206';
	break;
	case *figli*:
	$id_del_tag='207';
	break;
	case *figli naturali*:
	$id_del_tag='207';
	break;
	case *genitori*:
	$id_del_tag='207';
	break;
	case *parentela e affinita'*:
	$id_del_tag='207';
	break;
	case *assegni familiari*:
	$id_del_tag='207';
	break;
	case *neonati*:
	$id_del_tag='207';
	break;
	case *incesto*:
	$id_del_tag='207';
	break;
	case *protezione della famiglia*:
	$id_del_tag='207';
	break;
	case *nucleo familiare*:
	$id_del_tag='207';
	break;
	case *politica familiare*:
	$id_del_tag='207';
	break;
	case *sostegno alla famiglia*:
	$id_del_tag='207';
	break;
	case *genitore non coniugato*:
	$id_del_tag='207';
	break;
	case *famiglie numerose*:
	$id_del_tag='207';
	break;
	case *matrimonio misto*:
	$id_del_tag='207';
	break;
	case *famiglie monoparentali*:
	$id_del_tag='207';
	break;
	case *affidamento di minori*:
	$id_del_tag='211';
	break;
	case *adozione internazionale*:
	$id_del_tag='211';
	break;
	case *separazione dei coniugi*:
	$id_del_tag='222';
	break;
	case *divorziati*:
	$id_del_tag='222';
	break;
	case *separazione legale tra coniugi*:
	$id_del_tag='222';
	break;
	case *accattonaggio dei minori*:
	$id_del_tag='235';
	break;
	case *danni*:
	$id_del_tag='238';
	break;
	case *risarcimento di danni alla persona*:
	$id_del_tag='238';
	break;
	case *risarcimento danni dei malati da trasfusioni e vaccinazioni*:
	$id_del_tag='238';
	break;
	case *cassa nazionale di previdenza dei dottori commercialisti*:
	$id_del_tag='253';
	break;
	case *proprieta' industriale*:
	$id_del_tag='264';
	break;
	case *marchi e segni distintivi dell' azienda*:
	$id_del_tag='264';
	break;
	case *marchi di qualita' garanzia e identificazione*:
	$id_del_tag='264';
	break;
	case *marchio depositato*:
	$id_del_tag='264';
	break;
	case *diritto dei brevetti*:
	$id_del_tag='264';
	break;
	case *navigazione interna e lacuale*:
	$id_del_tag='271';
	break;
	case *proroga di termini*:
	$id_del_tag='5208';
	break;
	case *procedimenti e giudizi di accusa*:
	$id_del_tag='5208';
	break;
	case *procedura per direttissima*:
	$id_del_tag='5208';
	break;
	case *carceri militari*:
	$id_del_tag='276';
	break;
	case *giustizia militar*:
	$id_del_tag='276';
	break;
	case *giurisdizione militare*:
	$id_del_tag='276';
	break;
	case *giustizia militare*:
	$id_del_tag='276';
	break;
	case *sentenze straniere*:
	$id_del_tag='285';
	break;
	case *crimini internazionali*:
	$id_del_tag='289';
	break;
	case *operazioni belliche*:
	$id_del_tag='296';
	break;
	case *caduti e vittime di guerra*:
	$id_del_tag='296';
	break;
	case *pace*:
	$id_del_tag='296';
	break;
	case *prigionieri di guerra*:
	$id_del_tag='296';
	break;
	case *stato di guerra*:
	$id_del_tag='296';
	break;
	case *zone di guerra e di operazioni militari*:
	$id_del_tag='296';
	break;
	case *guerra di liberazione*:
	$id_del_tag='296';
	break;
	case *guerra mondiale i*:
	$id_del_tag='296';
	break;
	case *guerra mondiale ii*:
	$id_del_tag='296';
	break;
	case *guerra civile*:
	$id_del_tag='296';
	break;
	case *guerra di gaza 2008-09*:
	$id_del_tag='296';
	break;
	case *accordi di cooperazione*:
	$id_del_tag='313';
	break;
	case *cooperazione commerciale*:
	$id_del_tag='313';
	break;
	case *politica di cooperazione*:
	$id_del_tag='313';
	break;
	case *corpi di spedizione*:
	$id_del_tag='317';
	break;
	case *interventi militari*:
	$id_del_tag='317';
	break;
	case *ratifica di accordi e trattati*:
	$id_del_tag='321';
	break;
	case *negoziato internazionale*:
	$id_del_tag='321';
	break;
	case *estinzione di diritti*:
	$id_del_tag='325';
	break;
	case *pene*:
	$id_del_tag='325';
	break;
	case *depenalizzazione di reati*:
	$id_del_tag='325';
	break;
	case *pene detentive*:
	$id_del_tag='325';
	break;
	case *ergastolo*:
	$id_del_tag='325';
	break;
	case *pene accessorie*:
	$id_del_tag='325';
	break;
	case *pene alternative*:
	$id_del_tag='325';
	break;
	case *pene pecuniarie*:
	$id_del_tag='325';
	break;
	case *reati*:
	$id_del_tag='325';
	break;
	case *responsabilita' penale*:
	$id_del_tag='325';
	break;
	case *associazione a delinquere*:
	$id_del_tag='325';
	break;
	case *falsa testimonianza*:
	$id_del_tag='325';
	break;
	case *spese giudiziarie*:
	$id_del_tag='325';
	break;
	case *astensione e ricusazione del giudice*:
	$id_del_tag='325';
	break;
	case *diritto processuale penale*:
	$id_del_tag='325';
	break;
	case *atti processuali penali*:
	$id_del_tag='325';
	break;
	case *atti giudiziari penali*:
	$id_del_tag='325';
	break;
	case *termini nel processo penale*:
	$id_del_tag='325';
	break;
	case *errore giudiziario e ingiusta detenzione*:
	$id_del_tag='325';
	break;
	case *ordinanze e decreti nel processo penale*:
	$id_del_tag='325';
	break;
	case *revisione del processo penale*:
	$id_del_tag='325';
	break;
	case *sentenze penali*:
	$id_del_tag='325';
	break;
	case *condanne penali*:
	$id_del_tag='325';
	break;
	case *giudice per le indagini preliminari*:
	$id_del_tag='325';
	break;
	case *giudici di sorveglianza*:
	$id_del_tag='325';
	break;
	case *azione penale*:
	$id_del_tag='325';
	break;
	case *arresto*:
	$id_del_tag='325';
	break;
	case *flagranza nel reato*:
	$id_del_tag='325';
	break;
	case *imputati e indiziati di reato*:
	$id_del_tag='325';
	break;
	case *processo penale*:
	$id_del_tag='325';
	break;
	case *udienze penali*:
	$id_del_tag='325';
	break;
	case *indagini giudiziarie*:
	$id_del_tag='325';
	break;
	case *giudizio abbreviato*:
	$id_del_tag='325';
	break;
	case *giudizio direttissimo*:
	$id_del_tag='325';
	break;
	case *patteggiamento*:
	$id_del_tag='325';
	break;
	case *prove nel processo penale*:
	$id_del_tag='325';
	break;
	case *interrogatori*:
	$id_del_tag='325';
	break;
	case *testimoni nel processo penale*:
	$id_del_tag='325';
	break;
	case *autorizzazioni a procedere*:
	$id_del_tag='325';
	break;
	case *indagini difensive*:
	$id_del_tag='325';
	break;
	case *impronte digitali*:
	$id_del_tag='325';
	break;
	case *codice penale*:
	$id_del_tag='325';
	break;
	case *sanzioni penali*:
	$id_del_tag='325';
	break;
	case *accusa*:
	$id_del_tag='325';
	break;
	case *giurisdizione minorile*:
	$id_del_tag='325';
	break;
	case *esecuzione della sentenza*:
	$id_del_tag='325';
	break;
	case *giurisdizione*:
	$id_del_tag='325';
	break;
	case *detenzione preventiva*:
	$id_del_tag='325';
	break;
	case *ammende*:
	$id_del_tag='325';
	break;
	case *testimonianza*:
	$id_del_tag='325';
	break;
	case *estinzione del reato*:
	$id_del_tag='325';
	break;
	case *estinzione della pena*:
	$id_del_tag='325';
	break;
	case *patente pene detentive*:
	$id_del_tag='325';
	break;
	case *reati sessuali*:
	$id_del_tag='361';
	break;
	case *abusi e molestie sessuali*:
	$id_del_tag='361';
	break;
	case *trattamenti crudeli e degradanti*:
	$id_del_tag='367';
	break;
	case *frodi fiscali*:
	$id_del_tag='383';
	break;
	case *reati di terrorismo e di eversione*:
	$id_del_tag='393';
	break;
	case *reati di terrorismo internazionale*:
	$id_del_tag='393';
	break;
	case *terroristi*:
	$id_del_tag='393';
	break;
	case *ordinamento penitenziario*:
	$id_del_tag='487';
	break;
	case *personale di custodia carceraria*:
	$id_del_tag='487';
	break;
	case *lavoro dei detenuti*:
	$id_del_tag='487';
	break;
	case *rieducazione del condannato*:
	$id_del_tag='487';
	break;
	case *visite ai detenuti*:
	$id_del_tag='487';
	break;
	case *polizia penitenziaria*:
	$id_del_tag='487';
	break;
	case *edilizia carceraria*:
	$id_del_tag='487';
	break;
	case *personale carcerario*:
	$id_del_tag='487';
	break;
	case *diritto penitenziario*:
	$id_del_tag='487';
	break;
	case *diritti dei detenuti*:
	$id_del_tag='487';
	break;
	case *educatori penitenziari*:
	$id_del_tag='487';
	break;
	case *corpo di polizia penitenziaria*:
	$id_del_tag='487';
	break;
	case *trasferimento di detenuti*:
	$id_del_tag='497';
	break;
	case *suicidio dei detenuti*:
	$id_del_tag='497';
	break;
	case *sanitã  dei detenuti*:
	$id_del_tag='497';
	break;
	case *costituzioni*:
	$id_del_tag='504';
	break;
	case *assemblea costituente*:
	$id_del_tag='504';
	break;
	case *riforme*:
	$id_del_tag='505';
	break;
	case *riforme istituzionali*:
	$id_del_tag='505';
	break;
	case *apolidi*:
	$id_del_tag='508';
	break;
	case *naturalizzazione*:
	$id_del_tag='508';
	break;
	case *cittadinanza*:
	$id_del_tag='510';
	break;
	case *doppia nazionalita'*:
	$id_del_tag='510';
	break;
	case *protezione delle comunicazioni*:
	$id_del_tag='512';
	break;
	case *sanita' pubblica*:
	$id_del_tag='516';
	break;
	case *politica sanitaria*:
	$id_del_tag='516';
	break;
	case *rischi sanitari*:
	$id_del_tag='516';
	break;
	case *tutela della salute*:
	$id_del_tag='516';
	break;
	case *pubblicita' di atti e documenti*:
	$id_del_tag='517';
	break;
	case *trasparenza amministrativa*:
	$id_del_tag='517';
	break;
	case *parita' di trattamento*:
	$id_del_tag='518';
	break;
	case *discriminazioni sessuali*:
	$id_del_tag='519';
	break;
	case *persecuzioni religiose*:
	$id_del_tag='521';
	break;
	case *nomadi*:
	$id_del_tag='523';
	break;
	case *zingari*:
	$id_del_tag='523';
	break;
	case *diritti delle minoranze*:
	$id_del_tag='523';
	break;
	case *nomadismo*:
	$id_del_tag='523';
	break;
	case *esuli istriani*:
	$id_del_tag='523';
	break;
	case *popolazione rom*:
	$id_del_tag='523';
	break;
	case *candidature elettorali*:
	$id_del_tag='532';
	break;
	case *campagne elettorali*:
	$id_del_tag='532';
	break;
	case *ineleggibilita'*:
	$id_del_tag='541';
	break;
	case *ineleggibilita' parlamentare*:
	$id_del_tag='541';
	break;
	case *incompatibilita' parlamentare*:
	$id_del_tag='541';
	break;
	case *incompatibilita'*:
	$id_del_tag='541';
	break;
	case *elezioni*:
	$id_del_tag='547';
	break;
	case *elettorato attivo*:
	$id_del_tag='547';
	break;
	case *spese elettorali*:
	$id_del_tag='547';
	break;
	case *voto all' estero*:
	$id_del_tag='547';
	break;
	case *voto per posta*:
	$id_del_tag='547';
	break;
	case *elettorato passivo*:
	$id_del_tag='547';
	break;
	case *liste elettorali*:
	$id_del_tag='547';
	break;
	case *risultati elettorali*:
	$id_del_tag='547';
	break;
	case *seggi e sezioni elettorali*:
	$id_del_tag='547';
	break;
	case *collegi e circoscrizioni elettorali*:
	$id_del_tag='547';
	break;
	case *elezioni dirette*:
	$id_del_tag='547';
	break;
	case *votazione di ballottaggio*:
	$id_del_tag='547';
	break;
	case *nullita' di una elezione*:
	$id_del_tag='547';
	break;
	case *votazioni*:
	$id_del_tag='547';
	break;
	case *eleggibilita'*:
	$id_del_tag='547';
	break;
	case *diritto elettorale*:
	$id_del_tag='547';
	break;
	case *federalismo*:
	$id_del_tag='550';
	break;
	case *autonomia amministrativa*:
	$id_del_tag='550';
	break;
	case *bilancio di assestamento*:
	$id_del_tag='561';
	break;
	case *rendiconto generale dello stato*:
	$id_del_tag='561';
	break;
	case *contabilita' di stato*:
	$id_del_tag='561';
	break;
	case *distribuzione delle risorse*:
	$id_del_tag='561';
	break;
	case *distribuzione delle ricchezze*:
	$id_del_tag='561';
	break;
	case *procedura di bilancio*:
	$id_del_tag='561';
	break;
	case *previsione di bilancio*:
	$id_del_tag='561';
	break;
	case *politica di bilancio*:
	$id_del_tag='561';
	break;
	case *copertura finanziaria*:
	$id_del_tag='561';
	break;
	case *patrimonio degli enti locali*:
	$id_del_tag='562';
	break;
	case *autonomia finanziaria*:
	$id_del_tag='562';
	break;
	case *bilanci comunali*:
	$id_del_tag='562';
	break;
	case *finanza locale*:
	$id_del_tag='562';
	break;
	case *pianificazione regionale*:
	$id_del_tag='563';
	break;
	case *bilanci regionali*:
	$id_del_tag='563';
	break;
	case *sviluppo regionale*:
	$id_del_tag='563';
	break;
	case *bilancio regionale*:
	$id_del_tag='563';
	break;
	case *finanza regionale*:
	$id_del_tag='563';
	break;
	case *patto di stabilita' interno*:
	$id_del_tag='565';
	break;
	case *pareggio del bilancio*:
	$id_del_tag='565';
	break;
	case *disavanzo*:
	$id_del_tag='565';
	break;
	case *documento di programmazione economico finanziaria*:
	$id_del_tag='567';
	break;
	case *giurisdizione contabile*:
	$id_del_tag='576';
	break;
	case *indice dei prezzi*:
	$id_del_tag='578';
	break;
	case *listino prezzi*:
	$id_del_tag='578';
	break;
	case *buoni del tesoro*:
	$id_del_tag='578';
	break;
	case *estrazioni e sorteggi*:
	$id_del_tag='580';
	break;
	case *operazioni a premio scommesse e lotterie*:
	$id_del_tag='580';
	break;
	case *organizzazione fiscale*:
	$id_del_tag='587';
	break;
	case *anagrafe tributaria*:
	$id_del_tag='587';
	break;
	case *drenaggio fiscale*:
	$id_del_tag='587';
	break;
	case *commissioni tributarie*:
	$id_del_tag='587';
	break;
	case *controversie tributarie*:
	$id_del_tag='587';
	break;
	case *polizia tributaria*:
	$id_del_tag='587';
	break;
	case *contribuenti*:
	$id_del_tag='587';
	break;
	case *giurisdizione tributaria*:
	$id_del_tag='587';
	break;
	case *controlli fiscali*:
	$id_del_tag='587';
	break;
	case *amministrazione fiscale*:
	$id_del_tag='587';
	break;
	case *servizio centrale degli ispettori tributari (secit)*:
	$id_del_tag='587';
	break;
	case *uffici tributari*:
	$id_del_tag='587';
	break;
	case *centri di assistenza fiscale classificazione provvisoria*:
	$id_del_tag='587';
	break;
	case *oneri deducibili*:
	$id_del_tag='597';
	break;
	case *limiti di reddito a fini fiscali*:
	$id_del_tag='597';
	break;
	case *pagamento di imposte*:
	$id_del_tag='597';
	break;
	case *limiti di reddito a fini assistenziali e previdenziali*:
	$id_del_tag='597';
	break;
	case *imposte locali*:
	$id_del_tag='611';
	break;
	case *ticket*:
	$id_del_tag='626';
	break;
	case *tasse automobilistiche o di circolazione*:
	$id_del_tag='626';
	break;
	case *tasse scolastiche e universitarie*:
	$id_del_tag='626';
	break;
	case *tassa sui veicoli*:
	$id_del_tag='626';
	break;
	case *tassazione dei prezzi*:
	$id_del_tag='626';
	break;
	case *tassa di compensazione*:
	$id_del_tag='626';
	break;
	case *contributi sanitari*:
	$id_del_tag='626';
	break;
	case *limiti di spesa*:
	$id_del_tag='640';
	break;
	case *lotta contro gli sprechi*:
	$id_del_tag='640';
	break;
	case *spesa in conto capitale*:
	$id_del_tag='640';
	break;
	case *spesa corrente*:
	$id_del_tag='640';
	break;
	case *bilancio della difesa*:
	$id_del_tag='644';
	break;
	case *innovazione*:
	$id_del_tag='652';
	break;
	case *scienze delle attivita' motorie*:
	$id_del_tag='653';
	break;
	case *finanziamenti per la ricerca*:
	$id_del_tag='653';
	break;
	case *ricerche spaziali*:
	$id_del_tag='653';
	break;
	case *sperimentazione scientifica*:
	$id_del_tag='653';
	break;
	case *studi e ricerche*:
	$id_del_tag='653';
	break;
	case *centri e istituti di ricerca e sperimentazione*:
	$id_del_tag='653';
	break;
	case *ricerca universitaria*:
	$id_del_tag='653';
	break;
	case *scienze pure*:
	$id_del_tag='653';
	break;
	case *chimica*:
	$id_del_tag='653';
	break;
	case *biologia*:
	$id_del_tag='653';
	break;
	case *astronomi e astronomia*:
	$id_del_tag='653';
	break;
	case *fisica*:
	$id_del_tag='653';
	break;
	case *professioni tecniche*:
	$id_del_tag='653';
	break;
	case *professioni scientifiche*:
	$id_del_tag='653';
	break;
	case *ricerca spaziale*:
	$id_del_tag='653';
	break;
	case *scienze spaziali*:
	$id_del_tag='653';
	break;
	case *politica della ricerca*:
	$id_del_tag='653';
	break;
	case *ricerca applicata*:
	$id_del_tag='653';
	break;
	case *cern (organizzazione europea per la ricerca nucleare)*:
	$id_del_tag='653';
	break;
	case *processo tecnologico*:
	$id_del_tag='653';
	break;
	case *scienze politiche*:
	$id_del_tag='653';
	break;
	case *geografia*:
	$id_del_tag='653';
	break;
	case *geologia*:
	$id_del_tag='653';
	break;
	case *tecnologia*:
	$id_del_tag='653';
	break;
	case *progresso scientifico*:
	$id_del_tag='653';
	break;
	case *personale della ricerca*:
	$id_del_tag='657';
	break;
	case *dottorato di ricerca*:
	$id_del_tag='657';
	break;
	case *ricercatori universitari*:
	$id_del_tag='657';
	break;
	case *personale di ricerca*:
	$id_del_tag='657';
	break;
	case *archivi*:
	$id_del_tag='661';
	break;
	case *biblioteche nazionali*:
	$id_del_tag='661';
	break;
	case *archivi di stato*:
	$id_del_tag='661';
	break;
	case *esposizioni e mostre*:
	$id_del_tag='669';
	break;
	case *festival dei due mondi di spoleto*:
	$id_del_tag='669';
	break;
	case *festival di san remo*:
	$id_del_tag='669';
	break;
	case *agenzie di stampa*:
	$id_del_tag='672';
	break;
	case *agenzie di stampa*:
	$id_del_tag='672';
	break;
	case *stampa*:
	$id_del_tag='673';
	break;
	case *quotidiano la repubblica*:
	$id_del_tag='673';
	break;
	case *quotidiano il tempo*:
	$id_del_tag='673';
	break;
	case *quotidiano il riformista*:
	$id_del_tag='673';
	break;
	case *professioni del settore delle comunicazioni*:
	$id_del_tag='674';
	break;
	case *professioni dell'informazione*:
	$id_del_tag='674';
	break;
	case *bilanci preventivi*:
	$id_del_tag='675';
	break;
	case *bilanci di enti e societa'*:
	$id_del_tag='675';
	break;
	case *scritture contabili*:
	$id_del_tag='675';
	break;
	case *revisione e certificazione di bilanci*:
	$id_del_tag='675';
	break;
	case *revisori dei conti*:
	$id_del_tag='675';
	break;
	case *utili di esercizio*:
	$id_del_tag='675';
	break;
	case *controlli di gestione*:
	$id_del_tag='675';
	break;
	case *economia aziendale*:
	$id_del_tag='675';
	break;
	case *controlli di bilancio*:
	$id_del_tag='675';
	break;
	case *costo di distribuzione*:
	$id_del_tag='675';
	break;
	case *costo di produzione*:
	$id_del_tag='675';
	break;
	case *costituzione di societa'*:
	$id_del_tag='675';
	break;
	case *creazione di imprese*:
	$id_del_tag='675';
	break;
	case *produttivita'*:
	$id_del_tag='675';
	break;
	case *sistema di contabilita'*:
	$id_del_tag='675';
	break;
	case *costo del capitale*:
	$id_del_tag='675';
	break;
	case *gestione contabile*:
	$id_del_tag='675';
	break;
	case *economia industriale*:
	$id_del_tag='675';
	break;
	case *concentrazione e conferimento di societa' ed enti*:
	$id_del_tag='675';
	break;
	case *cessione di crediti*:
	$id_del_tag='675';
	break;
	case *industria del giocattolo*:
	$id_del_tag='708';
	break;
	case *industria dei coloranti*:
	$id_del_tag='708';
	break;
	case *industria del legno*:
	$id_del_tag='708';
	break;
	case *industria di trasformazione*:
	$id_del_tag='708';
	break;
	case *industria di biciclette e motocicli*:
	$id_del_tag='708';
	break;
	case *industria degli orologi*:
	$id_del_tag='708';
	break;
	case *industria della gomma*:
	$id_del_tag='708';
	break;
	case *industrie*:
	$id_del_tag='708';
	break;
	case *industria della ceramica*:
	$id_del_tag='708';
	break;
	case *industria manufattiera*:
	$id_del_tag='708';
	break;
	case *industria tipografica*:
	$id_del_tag='708';
	break;
	case *riconversione e ristrutturazione industriale*:
	$id_del_tag='708';
	break;
	case *imprese industriali*:
	$id_del_tag='708';
	break;
	case *grandi imprese*:
	$id_del_tag='708';
	break;
	case *zone e aree industriali*:
	$id_del_tag='708';
	break;
	case *imprese multinazionali*:
	$id_del_tag='708';
	break;
	case *stabilimento*:
	$id_del_tag='708';
	break;
	case *edifici per uso industriale*:
	$id_del_tag='708';
	break;
	case *politica industriale*:
	$id_del_tag='708';
	break;
	case *sviluppo industriale*:
	$id_del_tag='708';
	break;
	case *stabilimenti centri e siti industriali*:
	$id_del_tag='708';
	break;
	case *pianificazione industriale*:
	$id_del_tag='708';
	break;
	case *politica industriale comunitaria*:
	$id_del_tag='708';
	break;
	case *edison*:
	$id_del_tag='708';
	break;
	case *benzina*:
	$id_del_tag='710';
	break;
	case *gasolio*:
	$id_del_tag='710';
	break;
	case *idrocarburi*:
	$id_del_tag='710';
	break;
	case *distributori di carburante*:
	$id_del_tag='710';
	break;
	case *carburanti*:
	$id_del_tag='710';
	break;
	case *oleodotto*:
	$id_del_tag='710';
	break;
	case *coke*:
	$id_del_tag='710';
	break;
	case *giacimenti di gas*:
	$id_del_tag='710';
	break;
	case *carburanti biologici*:
	$id_del_tag='710';
	break;
	case *gpl*:
	$id_del_tag='710';
	break;
	case *carburante*:
	$id_del_tag='710';
	break;
	case *gas*:
	$id_del_tag='785';
	break;
	case *industria delle bevande*:
	$id_del_tag='714';
	break;
	case *viticoltura*:
	$id_del_tag='718';
	break;
	case *vigna*:
	$id_del_tag='718';
	break;
	case *uva*:
	$id_del_tag='718';
	break;
	case *industria della panificazione*:
	$id_del_tag='721';
	break;
	case *carne*:
	$id_del_tag='723';
	break;
	case *carne suina*:
	$id_del_tag='723';
	break;
	case *consumi alimentari*:
	$id_del_tag='723';
	break;
	case *prodotti chimici*:
	$id_del_tag='724';
	break;
	case *additivi chimici*:
	$id_del_tag='724';
	break;
	case *prodotti tessili*:
	$id_del_tag='736';
	break;
	case *industria delle materie plastiche*:
	$id_del_tag='738';
	break;
	case *videogiochi*:
	$id_del_tag='748';
	break;
	case *cassette dischi e nastri*:
	$id_del_tag='748';
	break;
	case *industria audiovisiva*:
	$id_del_tag='748';
	break;
	case *multimedia*:
	$id_del_tag='748';
	break;
	case *software*:
	$id_del_tag='752';
	break;
	case *sistema informatico*:
	$id_del_tag='752';
	break;
	case *calcolatori elettronici (computer)*:
	$id_del_tag='752';
	break;
	case *stampante*:
	$id_del_tag='752';
	break;
	case *societa' generale informatica (sogei)*:
	$id_del_tag='752';
	break;
	case *centro nazionale per l'informatica nella pubblica amministrazione (cnipa)*:
	$id_del_tag='752';
	break;
	case *risorse rinnovabili*:
	$id_del_tag='772';
	break;
	case *sostanze radioattive*:
	$id_del_tag='774';
	break;
	case *sostanze tossiche e nocive*:
	$id_del_tag='774';
	break;
	case *industria degli armamenti*:
	$id_del_tag='779';
	break;
	case *armamenti e apparecchiature militari*:
	$id_del_tag='779';
	break;
	case *mine antiuomo*:
	$id_del_tag='779';
	break;
	case *armi da fuoco e munizioni*:
	$id_del_tag='779';
	break;
	case *armi personali*:
	$id_del_tag='779';
	break;
	case *esplosivi*:
	$id_del_tag='779';
	break;
	case *gas per uso domestico*:
	$id_del_tag='785';
	break;
	case *gas naturali*:
	$id_del_tag='785';
	break;
	case *distribuzione del gas*:
	$id_del_tag='785';
	break;
	case *industria del gas*:
	$id_del_tag='785';
	break;
	case *industria mineraria ed estrattiva*:
	$id_del_tag='786';
	break;
	case *tariffe autostrade*:
	$id_del_tag='792';
	break;
	case *consorzi di bonifica*:
	$id_del_tag='798';
	break;
	case *porti turistici*:
	$id_del_tag='802';
	break;
	case *enti portuali*:
	$id_del_tag='802';
	break;
	case *lavoratori portuali*:
	$id_del_tag='802';
	break;
	case *raccolta differenziata dei rifiuti*:
	$id_del_tag='813';
	break;
	case *smaltimento di rifiuti*:
	$id_del_tag='813';
	break;
	case *riciclaggio dei rifiuti*:
	$id_del_tag='813';
	break;
	case *incenerimento dei rifiuti*:
	$id_del_tag='813';
	break;
	case *rifiuti domestici*:
	$id_del_tag='813';
	break;
	case *nettezza urbana*:
	$id_del_tag='813';
	break;
	case *discariche abusive*:
	$id_del_tag='814';
	break;
	case *industria automobilistica*:
	$id_del_tag='822';
	break;
	case *imbarcazioni da diporto*:
	$id_del_tag='825';
	break;
	case *impianti elettrici*:
	$id_del_tag='826';
	break;
	case *energia*:
	$id_del_tag='826';
	break;
	case *centrali elettriche*:
	$id_del_tag='826';
	break;
	case *consumi d'energia*:
	$id_del_tag='826';
	break;
	case *industria dell'energia*:
	$id_del_tag='826';
	break;
	case *distribuzione d'energia*:
	$id_del_tag='826';
	break;
	case *industria elettrica*:
	$id_del_tag='826';
	break;
	case *industria energetica*:
	$id_del_tag='826';
	break;
	case *posta elettronica*:
	$id_del_tag='836';
	break;
	case *sito internet*:
	$id_del_tag='836';
	break;
	case *societa' dell'informazione*:
	$id_del_tag='836';
	break;
	case *apparecchi telefonici*:
	$id_del_tag='838';
	break;
	case *linee telefoniche*:
	$id_del_tag='838';
	break;
	case *servizi telefonici*:
	$id_del_tag='838';
	break;
	case *centralinisti*:
	$id_del_tag='838';
	break;
	case *tariffe telefoniche*:
	$id_del_tag='838';
	break;
	case *telefonia mobile*:
	$id_del_tag='838';
	break;
	case *combustibile nucleare*:
	$id_del_tag='845';
	break;
	case *scorie radioattive*:
	$id_del_tag='845';
	break;
	case *centrali e impianti nucleari*:
	$id_del_tag='845';
	break;
	case *politica nucleare*:
	$id_del_tag='845';
	break;
	case *sicurezza nucleare*:
	$id_del_tag='845';
	break;
	case *ricerca nucleare*:
	$id_del_tag='845';
	break;
	case *fusione nucleare*:
	$id_del_tag='845';
	break;
	case *istituto nazionale di fisica nucleare ( infn )*:
	$id_del_tag='845';
	break;
	case *tecnologia nucleare*:
	$id_del_tag='845';
	break;
	case *agenzia internazionale per l'energia atomica (aiea)*:
	$id_del_tag='845';
	break;
	case *industria nucleare*:
	$id_del_tag='845';
	break;
	case *istruzione per adulti*:
	$id_del_tag='852';
	break;
	case *livelli di istruzione*:
	$id_del_tag='852';
	break;
	case *istruzione scientifica e tecnica*:
	$id_del_tag='852';
	break;
	case *politica dell'istruzione*:
	$id_del_tag='852';
	break;
	case *livello di insegnamento*:
	$id_del_tag='852';
	break;
	case *alfabetizzazione*:
	$id_del_tag='852';
	break;
	case *istruzione permanente*:
	$id_del_tag='852';
	break;
	case *istruzione artistica*:
	$id_del_tag='852';
	break;
	case *istruzione artistica e musicale*:
	$id_del_tag='852';
	break;
	case *riqualificazione professionale*:
	$id_del_tag='854';
	break;
	case *istruzione privata*:
	$id_del_tag='857';
	break;
	case *scuole paritarie*:
	$id_del_tag='857';
	break;
	case *finanziamenti alle scuole private*:
	$id_del_tag='857';
	break;
	case *docenti a contratto*:
	$id_del_tag='873';
	break;
	case *docenti incaricati*:
	$id_del_tag='873';
	break;
	case *docenti stranieri*:
	$id_del_tag='873';
	break;
	case *personale dell' universita'*:
	$id_del_tag='873';
	break;
	case *scuole di specializzazione per l'insegnamento secondario (ssis)*:
	$id_del_tag='888';
	break;
	case *istruzione universitaria*:
	$id_del_tag='892';
	break;
	case *corsi di laurea*:
	$id_del_tag='892';
	break;
	case *consigli universitari*:
	$id_del_tag='892';
	break;
	case *universita' straniere*:
	$id_del_tag='892';
	break;
	case *universita' di messina*:
	$id_del_tag='892';
	break;
	case *universita' di cassino*:
	$id_del_tag='892';
	break;
	case *politecnico di torino*:
	$id_del_tag='892';
	break;
	case *universita' di siena*:
	$id_del_tag='892';
	break;
	case *consiglio universitario nazionale ( cun )*:
	$id_del_tag='892';
	break;
	case *universitã *:
	$id_del_tag='892';
	break;
	case *scuola media*:
	$id_del_tag='898';
	break;
	case *istruzione secondaria*:
	$id_del_tag='898';
	break;
	case *insegnamento superiore*:
	$id_del_tag='902';
	break;
	case *scuola secondaria superiore*:
	$id_del_tag='902';
	break;
	case *scuola dell' obbligo*:
	$id_del_tag='904';
	break;
	case *scuola all'estero*:
	$id_del_tag='904';
	break;
	case *scolarizzazione*:
	$id_del_tag='904';
	break;
	case *abbandono scolastico*:
	$id_del_tag='904';
	break;
	case *scuole di montagna*:
	$id_del_tag='904';
	break;
	case *personale della scuola*:
	$id_del_tag='911';
	break;
	case *supplenti*:
	$id_del_tag='911';
	break;
	case *formazione degli insegnanti*:
	$id_del_tag='911';
	break;
	case *abilitazione all' insegnamento*:
	$id_del_tag='911';
	break;
	case *insegnanti internet*:
	$id_del_tag='911';
	break;
	case *riconoscimento dei diplomi*:
	$id_del_tag='919';
	break;
	case *studenti stranieri*:
	$id_del_tag='931';
	break;
	case *luoghi e ambienti di lavoro*:
	$id_del_tag='939';
	break;
	case *mercato del lavoro*:
	$id_del_tag='939';
	break;
	case *lavoratori frontalieri*:
	$id_del_tag='939';
	break;
	case *organizzazione del lavoro*:
	$id_del_tag='939';
	break;
	case *assunzione al lavoro*:
	$id_del_tag='939';
	break;
	case *apprendistato*:
	$id_del_tag='939';
	break;
	case *aspettativa dal servizio*:
	$id_del_tag='939';
	break;
	case *ferie*:
	$id_del_tag='939';
	break;
	case *orario di lavoro*:
	$id_del_tag='939';
	break;
	case *igiene del lavoro*:
	$id_del_tag='939';
	break;
	case *organizzazione internazionale del lavoro (oil)*:
	$id_del_tag='939';
	break;
	case *lavoro a turni*:
	$id_del_tag='939';
	break;
	case *lavoratori*:
	$id_del_tag='939';
	break;
	case *lavoratori anziani*:
	$id_del_tag='939';
	break;
	case *anzianita' di servizio*:
	$id_del_tag='939';
	break;
	case *prevenzione degli infortuni e infortunistica*:
	$id_del_tag='946';
	break;
	case *collocamento e avviamento al lavoro*:
	$id_del_tag='952';
	break;
	case *liste di collocamento al lavoro*:
	$id_del_tag='952';
	break;
	case *agenzie per l'impiego*:
	$id_del_tag='952';
	break;
	case *disoccupazione giovanile*:
	$id_del_tag='953';
	break;
	case *lavoratori clandestini*:
	$id_del_tag='962';
	break;
	case *contratti di lavoro a tempo determinato*:
	$id_del_tag='966';
	break;
	case *contratti di lavoro a tempo indeterminato*:
	$id_del_tag='966';
	break;
	case *contratto di lavoro*:
	$id_del_tag='966';
	break;
	case *operaio specializzato*:
	$id_del_tag='990';
	break;
	case *permessi retribuiti*:
	$id_del_tag='1002';
	break;
	case *ordini professionali*:
	$id_del_tag='1000';
	break;
	case *rappresentanza dei sindacati*:
	$id_del_tag='1002';
	break;
	case *organi sindacali nell'azienda*:
	$id_del_tag='1002';
	break;
	case *rappresentanti sindacali*:
	$id_del_tag='1002';
	break;
	case *datori di lavoro*:
	$id_del_tag='1002';
	break;
	case *diritti sindacali*:
	$id_del_tag='1002';
	break;
	case *protezione dei lavoratori*:
	$id_del_tag='1002';
	break;
	case *sindacati nel pubblico impiego*:
	$id_del_tag='1002';
	break;
	case *associazioni di categoria*:
	$id_del_tag='1002';
	break;
	case *consiglio centrale della rappresentanza ( cocer )*:
	$id_del_tag='1002';
	break;
	case *consultazione dei lavoratori*:
	$id_del_tag='1002';
	break;
	case *rappresentanza del personale*:
	$id_del_tag='1002';
	break;
	case *relazioni industriali*:
	$id_del_tag='1002';
	break;
	case *rappresentanze sindacali unitarie*:
	$id_del_tag='1002';
	break;
	case *tutela dei lavoratori*:
	$id_del_tag='1002';
	break;
	case *rappresentativita' dei sindacati*:
	$id_del_tag='1002';
	break;
	case *lavoro a tempo pieno*:
	$id_del_tag='1009';
	break;
	case *impiegati*:
	$id_del_tag='1009';
	break;
	case *lavoratori stagionali*:
	$id_del_tag='1010';
	break;
	case *flessibilita' del lavoro*:
	$id_del_tag='1010';
	break;
	case *lavoratori interinali*:
	$id_del_tag='1010';
	break;
	case *casalinghe*:
	$id_del_tag='1013';
	break;
	case *scala mobile*:
	$id_del_tag='1021';
	break;
	case *indicizzazione della retribuzione*:
	$id_del_tag='1021';
	break;
	case *integrazione salariale*:
	$id_del_tag='1021';
	break;
	case *retribuzione del lavoro*:
	$id_del_tag='1021';
	break;
	case *politica salariale*:
	$id_del_tag='1021';
	break;
	case *parita' retributiva*:
	$id_del_tag='1021';
	break;
	case *retribuzione*:
	$id_del_tag='1021';
	break;
	case *fondo di garanzia per il trattamento di fine rapporto*:
	$id_del_tag='1037';
	break;
	case *congedi parentale*:
	$id_del_tag='1050';
	break;
	case *dialetti*:
	$id_del_tag='1056';
	break;
	case *lingue straniere*:
	$id_del_tag='1056';
	break;
	case *lingua ladina*:
	$id_del_tag='1056';
	break;
	case *lingua piemontese*:
	$id_del_tag='1056';
	break;
	case *lingua slava*:
	$id_del_tag='1056';
	break;
	case *lingua slovena*:
	$id_del_tag='1056';
	break;
	case *lingua tedesca*:
	$id_del_tag='1056';
	break;
	case *bilinguismo*:
	$id_del_tag='1056';
	break;
	case *lingue regionali*:
	$id_del_tag='1056';
	break;
	case *linguaggio*:
	$id_del_tag='1056';
	break;
	case *lingua ufficiale*:
	$id_del_tag='1056';
	break;
	case *lingua materna*:
	$id_del_tag='1056';
	break;
	case *lingua minoritaria*:
	$id_del_tag='1056';
	break;
	case *politica linguistica*:
	$id_del_tag='1056';
	break;
	case *medicina legale*:
	$id_del_tag='1061';
	break;
	case *dietetica*:
	$id_del_tag='1061';
	break;
	case *radiologia*:
	$id_del_tag='1061';
	break;
	case *medicina preventiva*:
	$id_del_tag='1061';
	break;
	case *farmacia*:
	$id_del_tag='1073';
	break;
	case *barbiturici e psicofarmaci*:
	$id_del_tag='1073';
	break;
	case *prodotti dietetici*:
	$id_del_tag='1073';
	break;
	case *assistenza farmaceutica*:
	$id_del_tag='1073';
	break;
	case *farmaci omeopatici*:
	$id_del_tag='1073';
	break;
	case *prodotti farmaceutici*:
	$id_del_tag='1073';
	break;
	case *antiparassitari*:
	$id_del_tag='1073';
	break;
	case *farmacologia*:
	$id_del_tag='1073';
	break;
	case *industria farmaceutica*:
	$id_del_tag='1073';
	break;
	case *prontuario terapeutico*:
	$id_del_tag='1073';
	break;
	case *agenzia italiana del farmaco*:
	$id_del_tag='1073';
	break;
	case *farmaci generici*:
	$id_del_tag='1073';
	break;
	case *farmacologia e terapia*:
	$id_del_tag='1073';
	break;
	case *medicinali*:
	$id_del_tag='1073';
	break;
	case *psicologi*:
	$id_del_tag='1079';
	break;
	case *integratori alimentari*:
	$id_del_tag='1083';
	break;
	case *assenza e morte presunta*:
	$id_del_tag='1085';
	break;
	case *cadaveri*:
	$id_del_tag='1085';
	break;
	case *funerali*:
	$id_del_tag='1085';
	break;
	case *parita' tra sessi*:
	$id_del_tag='1089';
	break;
	case *liberta' sessuale*:
	$id_del_tag='1089';
	break;
	case *educazione sessuale*:
	$id_del_tag='1089';
	break;
	case *omofobia*:
	$id_del_tag='1089';
	break;
	case *omosessuali*:
	$id_del_tag='1089';
	break;
	case *emoderivati*:
	$id_del_tag='1090';
	break;
	case *parto*:
	$id_del_tag='1093';
	break;
	case *produzione e spaccio di droga*:
	$id_del_tag='1101';
	break;
	case *traffico di stupefacenti*:
	$id_del_tag='1101';
	break;
	case *somministrazione controllata di droga*:
	$id_del_tag='1103';
	break;
	case *tabagismo*:
	$id_del_tag='1103';
	break;
	case *tossicomania*:
	$id_del_tag='1103';
	break;
	case *comunitã  terapeutiche*:
	$id_del_tag='1103';
	break;
	case *paraplegici e tetraplegici*:
	$id_del_tag='1107';
	break;
	case *malati mentali*:
	$id_del_tag='1107';
	break;
	case *interventi chirurgici*:
	$id_del_tag='1110';
	break;
	case *procreazione artificiale*:
	$id_del_tag='1111';
	break;
	case *rianimazione*:
	$id_del_tag='1112';
	break;
	case *servizi di emergenza*:
	$id_del_tag='1112';
	break;
	case *malattie ereditarie*:
	$id_del_tag='1118';
	break;
	case *malattie sociali*:
	$id_del_tag='1118';
	break;
	case *malformazioni congenite*:
	$id_del_tag='1118';
	break;
	case *malattie cardiovascolare*:
	$id_del_tag='1118';
	break;
	case *malattie mentali*:
	$id_del_tag='1118';
	break;
	case *diabete*:
	$id_del_tag='1118';
	break;
	case *prevenzione delle malattie*:
	$id_del_tag='1118';
	break;
	case *malattie del sistema nervoso*:
	$id_del_tag='1118';
	break;
	case *malattie delle vie respiratorie*:
	$id_del_tag='1118';
	break;
	case *allergie*:
	$id_del_tag='1118';
	break;
	case *malattie della nutrizione*:
	$id_del_tag='1118';
	break;
	case *tubercolosi*:
	$id_del_tag='1123';
	break;
	case *epidemie*:
	$id_del_tag='1123';
	break;
	case *vaccinazioni obbligatorie*:
	$id_del_tag='1128';
	break;
	case *vaccinazioni*:
	$id_del_tag='1128';
	break;
	case *danni da vaccini e trasfusioni*:
	$id_del_tag='1128';
	break;
	case *medici mutualistici e convenzionati*:
	$id_del_tag='1137';
	break;
	case *medici ospedalieri*:
	$id_del_tag='1137';
	break;
	case *medici specialisti*:
	$id_del_tag='1137';
	break;
	case *ortopedici*:
	$id_del_tag='1137';
	break;
	case *pediatria*:
	$id_del_tag='1137';
	break;
	case *psichiatria*:
	$id_del_tag='1143';
	break;
	case *veterinaria*:
	$id_del_tag='1144';
	break;
	case *corpo nazionale dei vigili del fuoco*:
	$id_del_tag='1158';
	break;
	case *legislazione sanitaria*:
	$id_del_tag='1161';
	break;
	case *assistenza psichiatrica*:
	$id_del_tag='1162';
	break;
	case *indennita' di assistenza e di accompagnamento*:
	$id_del_tag='1162';
	break;
	case *assistenza ambulatoriale e domiciliare*:
	$id_del_tag='1162';
	break;
	case *prestazioni sanitarie gratuite*:
	$id_del_tag='1162';
	break;
	case *direttori sanitari*:
	$id_del_tag='1170';
	break;
	case *organi delle aziende sanitarie locali*:
	$id_del_tag='1170';
	break;
	case *controlli veterinari*:
	$id_del_tag='1172';
	break;
	case *legislazione veterinaria*:
	$id_del_tag='1172';
	break;
	case *cani*:
	$id_del_tag='1173';
	break;
	case *canili*:
	$id_del_tag='1173';
	break;
	case *forme di stato e di governo*:
	$id_del_tag='1181';
	break;
	case *capo di governo*:
	$id_del_tag='1181';
	break;
	case *programmi di governo*:
	$id_del_tag='1181';
	break;
	case *programma di governo*:
	$id_del_tag='1181';
	break;
	case *giudizi di costituzionalita'*:
	$id_del_tag='1190';
	break;
	case *controlli di legittimita'*:
	$id_del_tag='1190';
	break;
	case *verifica di costituzionalita'*:
	$id_del_tag='1190';
	break;
	case *sentenze costituzionali*:
	$id_del_tag='1190';
	break;
	case *procuratori della repubblica e sostituti*:
	$id_del_tag='1191';
	break;
	case *magistrati*:
	$id_del_tag='1191';
	break;
	case *consiglio superiore della magistratura (csm)*:
	$id_del_tag='1191';
	break;
	case *procedimenti relativi a magistrati*:
	$id_del_tag='1191';
	break;
	case *scuola superiore della magistratura*:
	$id_del_tag='1191';
	break;
	case *referendum abrogativo*:
	$id_del_tag='1194';
	break;
	case *referendum consultivo*:
	$id_del_tag='1194';
	break;
	case *indennita' parlamentare*:
	$id_del_tag='1237';
	break;
	case *senatori a vita*:
	$id_del_tag='1237';
	break;
	case *iniziativa popolare*:
	$id_del_tag='1245';
	break;
	case *commissioni parlamentari d'inchiesta*:
	$id_del_tag='1246';
	break;
	case *sistema di informazione*:
	$id_del_tag='1257';
	break;
	case *disinformazione*:
	$id_del_tag='1257';
	break;
	case *pluralismo dell'informazione*:
	$id_del_tag='1257';
	break;
	case *dipartimento per l' informazione e l' editoria*:
	$id_del_tag='1257';
	break;
	case *mais*:
	$id_del_tag='1267';
	break;
	case *soia*:
	$id_del_tag='1267';
	break;
	case *mercato agricolo*:
	$id_del_tag='1267';
	break;
	case *regolamentazione della produzione agricola*:
	$id_del_tag='1267';
	break;
	case *industria del tabacco*:
	$id_del_tag='1273';
	break;
	case *cooperative agricole*:
	$id_del_tag='1277';
	break;
	case *mezzadria  e colonia*:
	$id_del_tag='1284';
	break;
	case *lavoratori agricoli*:
	$id_del_tag='1284';
	break;
	case *premi alla macellazione*:
	$id_del_tag='1286';
	break;
	case *acquacoltura*:
	$id_del_tag='1288';
	break;
	case *industria della pesca*:
	$id_del_tag='1288';
	break;
	case *controlli della pesca*:
	$id_del_tag='1288';
	break;
	case *diritto di pesca*:
	$id_del_tag='1288';
	break;
	case *piscicoltura*:
	$id_del_tag='1288';
	break;
	case *regolamentazione della pesca*:
	$id_del_tag='1288';
	break;
	case *pescherecci*:
	$id_del_tag='1288';
	break;
	case *pesca*:
	$id_del_tag='1288';
	break;
	case *latte in polvere*:
	$id_del_tag='1294';
	break;
	case *latte*:
	$id_del_tag='1294';
	break;
	case *organizzazione territoriale della pubblica amministrazione*:
	$id_del_tag='1298';
	break;
	case *controlli amministrativi*:
	$id_del_tag='1298';
	break;
	case *dipartimenti della pubblica amministrazione*:
	$id_del_tag='1298';
	break;
	case *pubblico ufficiale*:
	$id_del_tag='1298';
	break;
	case *amministrazioni centrali  dello stato*:
	$id_del_tag='1298';
	break;
	case *amministrazione centrale dello stato*:
	$id_del_tag='1298';
	break;
	case *amministrazione centrale*:
	$id_del_tag='1298';
	break;
	case *contratti dello stato e degli enti pubblici*:
	$id_del_tag='1298';
	break;
	case *approvvigionamento idrico*:
	$id_del_tag='1302';
	break;
	case *acquedotti*:
	$id_del_tag='1302';
	break;
	case *impianti idrici ed idraulici*:
	$id_del_tag='1302';
	break;
	case *acqua potabile*:
	$id_del_tag='1302';
	break;
	case *distribuzione idrica*:
	$id_del_tag='1302';
	break;
	case *reati contro l' amministrazione pubblica e la giustizia*:
	$id_del_tag='1303';
	break;
	case *reati ministeriali*:
	$id_del_tag='1303';
	break;
	case *ricorsi amministrativi*:
	$id_del_tag='1303';
	break;
	case *giurisdizione amministrativa*:
	$id_del_tag='1303';
	break;
	case *visto di ingresso*:
	$id_del_tag='1314';
	break;
	case *diritto di soggiorno*:
	$id_del_tag='1314';
	break;
	case *guardie giurate*:
	$id_del_tag='1319';
	break;
	case *personale di polizia*:
	$id_del_tag='1325';
	break;
	case *commissari e vice commissari di polizia*:
	$id_del_tag='1325';
	break;
	case *controlli di polizia*:
	$id_del_tag='1325';
	break;
	case *forze di polizia*:
	$id_del_tag='1325';
	break;
	case *polizia locale*:
	$id_del_tag='1326';
	break;
	case *subappalti*:
	$id_del_tag='1334';
	break;
	case *bandi pubblici*:
	$id_del_tag='1334';
	break;
	case *immobili demaniali*:
	$id_del_tag='1338';
	break;
	case *zone e aree demaniali*:
	$id_del_tag='1338';
	break;
	case *agenzia del demanio*:
	$id_del_tag='1338';
	break;
	case *licenza edilizia*:
	$id_del_tag='1350';
	break;
	case *immobili*:
	$id_del_tag='1355';
	break;
	case *reddito immobiliare*:
	$id_del_tag='1355';
	break;
	case *occupazione di immobili*:
	$id_del_tag='1355';
	break;
	case *proprieta' immobiliare*:
	$id_del_tag='1355';
	break;
	case *imprese immobiliari*:
	$id_del_tag='1355';
	break;
	case *contabilita' di enti ed amministrazioni pubbliche*:
	$id_del_tag='1362';
	break;
	case *soppressione di enti*:
	$id_del_tag='1362';
	break;
	case *sanzioni amministrative*:
	$id_del_tag='1372';
	break;
	case *giustizia amministrativa*:
	$id_del_tag='1372';
	break;
	case *responsabilita' amministrativa e contabile*:
	$id_del_tag='1372';
	break;
	case *istruttoria amministrativa*:
	$id_del_tag='1373';
	break;
	case *documentazione amministrativa*:
	$id_del_tag='1373';
	break;
	case *registrazione di atti*:
	$id_del_tag='1373';
	break;
	case *atti amministrativi*:
	$id_del_tag='1373';
	break;
	case *atti notori e dichiarazioni sostitutive*:
	$id_del_tag='1392';
	break;
	case *canone di concessione*:
	$id_del_tag='1394';
	break;
	case *concessionari*:
	$id_del_tag='1394';
	break;
	case *mezzi di soccorso*:
	$id_del_tag='1406';
	break;
	case *tariffe dei servizi pubblici*:
	$id_del_tag='1407';
	break;
	case *servizi pubblici di trasporto*:
	$id_del_tag='1407';
	break;
	case *contributi e corrispettivi di servizi pubblici*:
	$id_del_tag='1407';
	break;
	case *commissario straordinario*:
	$id_del_tag='1411';
	break;
	case *amministrazioni periferiche dello stato*:
	$id_del_tag='1422';
	break;
	case *segretari comunali*:
	$id_del_tag='1422';
	break;
	case *personale degli enti locali*:
	$id_del_tag='1422';
	break;
	case *segretari provinciali*:
	$id_del_tag='1422';
	break;
	case *amministrazioni locali*:
	$id_del_tag='1422';
	break;
	case *amministrazione locale*:
	$id_del_tag='1422';
	break;
	case *amministrazione periferica dello stato*:
	$id_del_tag='1422';
	break;
	case *unione nazionale dei comuni, comunita' ed enti della montagna (uncem)*:
	$id_del_tag='1423';
	break;
	case *associazioni di comuni*:
	$id_del_tag='1425';
	break;
	case *territorio dei comuni*:
	$id_del_tag='1425';
	break;
	case *organi e uffici comunali*:
	$id_del_tag='1425';
	break;
	case *organi e uffici provinciali*:
	$id_del_tag='1439';
	break;
	case *istituzione di nuove province*:
	$id_del_tag='1439';
	break;
	case *territorio delle province*:
	$id_del_tag='1439';
	break;
	case *unione delle province d' italia ( upi )*:
	$id_del_tag='1439';
	break;
	case *consiglieri provinciali*:
	$id_del_tag='1441';
	break;
	case *conferenza stato regioni*:
	$id_del_tag='1450';
	break;
	case *uffici regionali*:
	$id_del_tag='1450';
	break;
	case *personale delle regioni*:
	$id_del_tag='1450';
	break;
	case *istituzione di nuove regioni*:
	$id_del_tag='1450';
	break;
	case *territorio delle regioni*:
	$id_del_tag='1450';
	break;
	case *rapporti tra stato e regioni*:
	$id_del_tag='1450';
	break;
	case *politica regionale*:
	$id_del_tag='1450';
	break;
	case *agenzie regionali*:
	$id_del_tag='1450';
	break;
	case *amministrazioni regionali*:
	$id_del_tag='1450';
	break;
	case *diritto regionale*:
	$id_del_tag='1450';
	break;
	case *comitato delle regioni*:
	$id_del_tag='1450';
	break;
	case *organi e uffici regionali*:
	$id_del_tag='1450';
	break;
	case *personale dello stato*:
	$id_del_tag='1461';
	break;
	case *carriere nel pubblico impiego*:
	$id_del_tag='1461';
	break;
	case *dirigenza della pubblica amministrazione*:
	$id_del_tag='1461';
	break;
	case *contratti collettivi nel pubblico impiego*:
	$id_del_tag='1461';
	break;
	case *responsabilita' nel pubblico impiego*:
	$id_del_tag='1461';
	break;
	case *professioni amministrative*:
	$id_del_tag='1461';
	break;
	case *istituto nazionale di previdenza per i dipendenti dell'amministrazione pubblica ( inpdap )*:
	$id_del_tag='1461';
	break;
	case *valutazione del personale pubblico*:
	$id_del_tag='1461';
	break;
	case *assunzioni nella pubblica amministrazione*:
	$id_del_tag='1461';
	break;
	case *accesso al pubblico impiego*:
	$id_del_tag='1461';
	break;
	case *dirigenti generali*:
	$id_del_tag='1461';
	break;
	case *trattamento economico nel pubblico impiego*:
	$id_del_tag='1461';
	break;
	case *concorsi a cattedre*:
	$id_del_tag='1499';
	break;
	case *concorsi riservati*:
	$id_del_tag='1499';
	break;
	case *graduatoria*:
	$id_del_tag='1499';
	break;
	case *prove di concorso*:
	$id_del_tag='1499';
	break;
	case *commissioni di concorsi e esami*:
	$id_del_tag='1499';
	break;
	case *concorsi*:
	$id_del_tag='1499';
	break;
	case *nomine*:
	$id_del_tag='1507';
	break;
	case *tavola valdese*:
	$id_del_tag='1517';
	break;
	case *gruppi religiosi*:
	$id_del_tag='1517';
	break;
	case *integralismo religioso*:
	$id_del_tag='1517';
	break;
	case *istituzioni religiose*:
	$id_del_tag='1517';
	break;
	case *conflitti di religione*:
	$id_del_tag='1517';
	break;
	case *gruppo religioso*:
	$id_del_tag='1517';
	break;
	case *rapporti tra stato e chiesa*:
	$id_del_tag='1519';
	break;
	case *finanziamenti alla chiesa cattolica*:
	$id_del_tag='1519';
	break;
	case *conferenza episcopale italiana ( cei )*:
	$id_del_tag='1519';
	break;
	case *clero*:
	$id_del_tag='1519';
	break;
	case *religione cattolica*:
	$id_del_tag='1519';
	break;
	case *case editrici*:
	$id_del_tag='1524';
	break;
	case *commercializzazione dei prodotti*:
	$id_del_tag='1535';
	break;
	case *estetisti*:
	$id_del_tag='1535';
	break;
	case *erboristi*:
	$id_del_tag='1535';
	break;
	case *uffici e servizi tecnici*:
	$id_del_tag='1535';
	break;
	case *commercio al dettaglio*:
	$id_del_tag='1535';
	break;
	case *imprese commerciali*:
	$id_del_tag='1535';
	break;
	case *negozi e rivendite*:
	$id_del_tag='1535';
	break;
	case *grande magazzino*:
	$id_del_tag='1535';
	break;
	case *societa' di servizi*:
	$id_del_tag='1535';
	break;
	case *informazioni commerciali*:
	$id_del_tag='1535';
	break;
	case *rappresentanti di commercio*:
	$id_del_tag='1535';
	break;
	case *distribuzione commerciale*:
	$id_del_tag='1535';
	break;
	case *commercio ambulante*:
	$id_del_tag='1535';
	break;
	case *industria dei servizi*:
	$id_del_tag='1535';
	break;
	case *ente nazionale assistenza agenti e rappresentanti di commercio ( enasarco )*:
	$id_del_tag='1535';
	break;
	case *commercio all'ingrosso*:
	$id_del_tag='1535';
	break;
	case *politica commerciale*:
	$id_del_tag='1535';
	break;
	case *societa' commerciale*:
	$id_del_tag='1535';
	break;
	case *commercio elettronico*:
	$id_del_tag='1535';
	break;
	case *centri commerciali*:
	$id_del_tag='1541';
	break;
	case *associazioni di consumatori e di utenti*:
	$id_del_tag='1542';
	break;
	case *informazione del consumatore*:
	$id_del_tag='1542';
	break;
	case *diritti dei consumatori*:
	$id_del_tag='1542';
	break;
	case *concorrenza sleale*:
	$id_del_tag='1546';
	break;
	case *autorita' indipendenti di controllo e garanzia*:
	$id_del_tag='1546';
	break;
	case *legislazione antitrust*:
	$id_del_tag='1546';
	break;
	case *libera concorrenza*:
	$id_del_tag='1546';
	break;
	case *norme giuridiche sulla concorrenza*:
	$id_del_tag='1546';
	break;
	case *restrizione alla concorrenza*:
	$id_del_tag='1546';
	break;
	case *autorita garante della concorrenza e del mercato (antitrust)*:
	$id_del_tag='1546';
	break;
	case *politica della concorrenza*:
	$id_del_tag='1546';
	break;
	case *autorita' garante della concorrenza e del mercato*:
	$id_del_tag='1546';
	break;
	case *libera circolazione delle merci*:
	$id_del_tag='1552';
	break;
	case *libera prestazione di servizi*:
	$id_del_tag='1552';
	break;
	case *liberalizzazione del mercato*:
	$id_del_tag='1552';
	break;
	case *libera circolazione dei capitali*:
	$id_del_tag='1552';
	break;
	case *crediti all'esportazione*:
	$id_del_tag='1557';
	break;
	case *restrizione all'esportazione*:
	$id_del_tag='1557';
	break;
	case *restrizione all'importazione*:
	$id_del_tag='1558';
	break;
	case *politica delle importazioni*:
	$id_del_tag='1558';
	break;
	case *scienze economiche*:
	$id_del_tag='1562';
	break;
	case *consigli di amministrazione*:
	$id_del_tag='1578';
	break;
	case *societa' a responsabilita' limitata (srl)*:
	$id_del_tag='1578';
	break;
	case *societa' per azioni (spa)*:
	$id_del_tag='1578';
	break;
	case *partecipazioni in imprese*:
	$id_del_tag='1578';
	break;
	case *holding*:
	$id_del_tag='1578';
	break;
	case *imprese private*:
	$id_del_tag='1578';
	break;
	case *imprese straniere*:
	$id_del_tag='1578';
	break;
	case *imprenditori*:
	$id_del_tag='1578';
	break;
	case *societa' di capitali*:
	$id_del_tag='1578';
	break;
	case *localizzazione delle imprese*:
	$id_del_tag='1578';
	break;
	case *trasferimento d'impresa*:
	$id_del_tag='1578';
	break;
	case *politica di produzione*:
	$id_del_tag='1578';
	break;
	case *crescita dell'impresa*:
	$id_del_tag='1578';
	break;
	case *politica dell'impresa*:
	$id_del_tag='1578';
	break;
	case *imprese in difficoltã )*:
	$id_del_tag='1578';
	break;
	case *cessazione d'attivita'*:
	$id_del_tag='1578';
	break;
	case *delocalizzazione*:
	$id_del_tag='1578';
	break;
	case *esternalizzazione*:
	$id_del_tag='1578';
	break;
	case *societa' privata*:
	$id_del_tag='1578';
	break;
	case *societa' d'economia mista*:
	$id_del_tag='1578';
	break;
	case *imprese europee*:
	$id_del_tag='1578';
	break;
	case *fusione d'imprese*:
	$id_del_tag='1578';
	break;
	case *imprese fiduciarie*:
	$id_del_tag='1578';
	break;
	case *crisi e chiusura di imprese*:
	$id_del_tag='1578';
	break;
	case *internazionalizzazione delle imprese*:
	$id_del_tag='1578';
	break;
	case *liquidazione di imprese*:
	$id_del_tag='1578';
	break;
	case *imprese sociali*:
	$id_del_tag='1578';
	break;
	case *unione italiana delle camere di commercio, industria, agricoltura e artigianato (unioncamere)*:
	$id_del_tag='1581';
	break;
	case *partecipazioni pubbliche in imprese*:
	$id_del_tag='1584';
	break;
	case *scioglimento enti pubblici*:
	$id_del_tag='1585';
	break;
	case *politica migratoria comunitaria*:
	$id_del_tag='1604';
	break;
	case *politica migratoria*:
	$id_del_tag='1604';
	break;
	case *scuole italiane all' estero*:
	$id_del_tag='1610';
	break;
	case *lavoratori italiani all'estero*:
	$id_del_tag='1610';
	break;
	case *beni italiani all' estero*:
	$id_del_tag='1610';
	break;
	case *consiglio generale degli italiani all' estero ( cgie )*:
	$id_del_tag='1610';
	break;
	case *comitati italiani all' estero ( comites )*:
	$id_del_tag='1610';
	break;
	case *anagrafe dei cittadini italiani residenti all' estero ( aire )*:
	$id_del_tag='1610';
	break;
	case *consiglio generale degli italiani all' estero (cgie)*:
	$id_del_tag='1610';
	break;
	case *comitati italiani all' estero (comites)*:
	$id_del_tag='1610';
	break;
	case *rifugiati politici*:
	$id_del_tag='1611';
	break;
	case *estrema sinistra*:
	$id_del_tag='1622';
	break;
	case *gruppi politici*:
	$id_del_tag='1622';
	break;
	case *partito radicale*:
	$id_del_tag='1622';
	break;
	case *organizzazione dei partiti*:
	$id_del_tag='1622';
	break;
	case *partito della rifondazione comunista (prc)*:
	$id_del_tag='1622';
	break;
	case *estrema destra*:
	$id_del_tag='1622';
	break;
	case *finanziamento dei partiti*:
	$id_del_tag='1623';
	break;
	case *finanziamento pubblico*:
	$id_del_tag='1623';
	break;
	case *relazioni internazionali*:
	$id_del_tag='1624';
	break;
	case *stati esteri*:
	$id_del_tag='1624';
	break;
	case *relazioni multilaterali*:
	$id_del_tag='1624';
	break;
	case *responsabilita' internazionale*:
	$id_del_tag='1624';
	break;
	case *relazioni diplomatiche*:
	$id_del_tag='1624';
	break;
	case *perseguitati politici e razziali*:
	$id_del_tag='1627';
	break;
	case *discriminazioni razziali*:
	$id_del_tag='1627';
	break;
	case *ecologia*:
	$id_del_tag='1629';
	break;
	case *protezione dell'ambiente e del paesaggio*:
	$id_del_tag='1629';
	break;
	case *controlli ambientali*:
	$id_del_tag='1629';
	break;
	case *sistemazione del territorio*:
	$id_del_tag='1631';
	break;
	case *dissesto idrogeologico*:
	$id_del_tag='1631';
	break;
	case *decontaminazione dall' inquinamento*:
	$id_del_tag='1633';
	break;
	case *inquinamento industriale*:
	$id_del_tag='1633';
	break;
	case *tasso di inquinamento*:
	$id_del_tag='1633';
	break;
	case *prevenzione dell'inquinamento*:
	$id_del_tag='1633';
	break;
	case *inquinamento chimico*:
	$id_del_tag='1633';
	break;
	case *inquinamento da idrocarburi*:
	$id_del_tag='1633';
	break;
	case *inquinamento dei corsi d'acqua*:
	$id_del_tag='1638';
	break;
	case *embrione e feto*:
	$id_del_tag='1648';
	break;
	case *eugenetica*:
	$id_del_tag='1648';
	break;
	case *cellule staminali*:
	$id_del_tag='1648';
	break;
	case *dna*:
	$id_del_tag='1648';
	break;
	case *protezione degli animali*:
	$id_del_tag='1649';
	break;
	case *abbattimento di animali*:
	$id_del_tag='1649';
	break;
	case *spettacolo di animali*:
	$id_del_tag='1649';
	break;
	case *isola d'elba*:
	$id_del_tag='1656';
	break;
	case *isole eolie*:
	$id_del_tag='1656';
	break;
	case *isola di stromboli*:
	$id_del_tag='1656';
	break;
	case *acqua salata*:
	$id_del_tag='1657';
	break;
	case *regioni montane*:
	$id_del_tag='1658';
	break;
	case *monte amiata*:
	$id_del_tag='1658';
	break;
	case *corsi d'acqua*:
	$id_del_tag='1662';
	break;
	case *idrologia*:
	$id_del_tag='1662';
	break;
	case *fiume tagliamento*:
	$id_del_tag='1662';
	break;
	case *fiume trebbia*:
	$id_del_tag='1662';
	break;
	case *fiume sacco*:
	$id_del_tag='1662';
	break;
	case *fiume liri*:
	$id_del_tag='1662';
	break;
	case *lago di albano*:
	$id_del_tag='1663';
	break;
	case *sismologia*:
	$id_del_tag='1665';
	break;
	case *sisma*:
	$id_del_tag='1665';
	break;
	case *mortalita'*:
	$id_del_tag='1670';
	break;
	case *invecchiamento demografico*:
	$id_del_tag='1670';
	break;
	case *aumento della popolazione*:
	$id_del_tag='1670';
	break;
	case *natalita'*:
	$id_del_tag='1670';
	break;
	case *ru486*:
	$id_del_tag='1673';
	break;
	case *partecipazione delle donne*:
	$id_del_tag='1674';
	break;
	case *condizione della donna*:
	$id_del_tag='1674';
	break;
	case *diritti della donna*:
	$id_del_tag='1674';
	break;
	case *anzianita'*:
	$id_del_tag='1676';
	break;
	case *opinione pubblica*:
	$id_del_tag='1679';
	break;
	case *sicurezza sociale*:
	$id_del_tag='1685';
	break;
	case *assistenti sociali*:
	$id_del_tag='1685';
	break;
	case *assegni sociali*:
	$id_del_tag='1685';
	break;
	case *legislazione in materia di sicurezza sociale*:
	$id_del_tag='1685';
	break;
	case *stato sociale (welfare state)*:
	$id_del_tag='1685';
	break;
	case *assistente sociale*:
	$id_del_tag='1685';
	break;
	case *assistente sociale specialista*:
	$id_del_tag='1685';
	break;
	case *volontario internazionale*:
	$id_del_tag='1704';
	break;
	case *infortuni sul lavoro*:
	$id_del_tag='1707';
	break;
	case *caduti e feriti per servizio*:
	$id_del_tag='1707';
	break;
	case *invalidita' per servizio*:
	$id_del_tag='1707';
	break;
	case *associazione nazionale privi della vista*:
	$id_del_tag='1711';
	break;
	case *sorditã *:
	$id_del_tag='1713';
	break;
	case *assegni di invalidita'*:
	$id_del_tag='1716';
	break;
	case *indennizzi per invalidita'*:
	$id_del_tag='1716';
	break;
	case *inabili al lavoro o al servizio*:
	$id_del_tag='1716';
	break;
	case *invalidi*:
	$id_del_tag='1716';
	break;
	case *grandi invalidi*:
	$id_del_tag='1716';
	break;
	case *invalidita' permanente*:
	$id_del_tag='1716';
	break;
	case *pensione di invalidita'*:
	$id_del_tag='1716';
	break;
	case *diversamente abili*:
	$id_del_tag='1716';
	break;
	case *lavoratori disabili*:
	$id_del_tag='1716';
	break;
	case *assicurazione per invalidita'*:
	$id_del_tag='1716';
	break;
	case *casse e fondi di previdenza*:
	$id_del_tag='1760';
	break;
	case *cassa di previdenza per ingegneri ed architetti*:
	$id_del_tag='1760';
	break;
	case *cassa nazionale di previdenza dei ragionieri e periti commerciali*:
	$id_del_tag='1760';
	break;
	case *ente nazionale di previdenza e assistenza per i lavoratori dello spettacolo ( enpals )*:
	$id_del_tag='1760';
	break;
	case *ente nazionale di previdenza e assistenza medici ( enpam )*:
	$id_del_tag='1760';
	break;
	case *istituto di previdenza per il settore marittimo (ipsema)*:
	$id_del_tag='1760';
	break;
	case *indennizzi*:
	$id_del_tag='1760';
	break;
	case *ricostruzione della posizione assicurativa*:
	$id_del_tag='1760';
	break;
	case *contributi volontari*:
	$id_del_tag='1760';
	break;
	case *istituti  casse ed enti mutualistici e previdenziali*:
	$id_del_tag='1760';
	break;
	case *assicurazione obbligatoria della responsabilita' civile*:
	$id_del_tag='1760';
	break;
	case *assicurazione sociale*:
	$id_del_tag='1760';
	break;
	case *polizze assicurative*:
	$id_del_tag='1760';
	break;
	case *premi di assicurazione*:
	$id_del_tag='1760';
	break;
	case *rischi assicurati*:
	$id_del_tag='1760';
	break;
	case *assicurazioni contro i danni*:
	$id_del_tag='1760';
	break;
	case *assicurazioni private e mutue assicuratrici*:
	$id_del_tag='1760';
	break;
	case *istituto per la vigilanza sulle assicurazioni private e di interesse collettivo (isvap)*:
	$id_del_tag='1760';
	break;
	case *vigilanza sulle assicurazioni*:
	$id_del_tag='1760';
	break;
	case *associazione nazionale tra le imprese assicuratrici ( ania )*:
	$id_del_tag='1760';
	break;
	case *sinistro*:
	$id_del_tag='1760';
	break;
	case *assicurazione agricola*:
	$id_del_tag='1760';
	break;
	case *assicurazione obbligatoria*:
	$id_del_tag='1760';
	break;
	case *assicurazione infortuni sul lavoro e malattie professionali*:
	$id_del_tag='1760';
	break;
	case *istituto nazionale per l' assicurazione contro gli infortuni sul lavoro (inail)*:
	$id_del_tag='1760';
	break;
	case *assicurazione per la vecchiaia*:
	$id_del_tag='1765';
	break;
	case *fondi di investimento*:
	$id_del_tag='1773';
	break;
	case *societa' finanziarie*:
	$id_del_tag='1773';
	break;
	case *finanza internazionale*:
	$id_del_tag='1773';
	break;
	case *regolamentazione finanziaria*:
	$id_del_tag='1773';
	break;
	case *transazione finanziaria*:
	$id_del_tag='1773';
	break;
	case *borse valori*:
	$id_del_tag='1773';
	break;
	case *movimento di capitali*:
	$id_del_tag='1773';
	break;
	case *strumenti finanziari*:
	$id_del_tag='1773';
	break;
	case *euribor*:
	$id_del_tag='1773';
	break;
	case *finanza*:
	$id_del_tag='1773';
	break;
	case *rischi finanziari*:
	$id_del_tag='1773';
	break;
	case *finanza derivata*:
	$id_del_tag='1773';
	break;
	case *dividendi*:
	$id_del_tag='1775';
	break;
	case *azionisti*:
	$id_del_tag='1775';
	break;
	case *pretezione degli azionisti*:
	$id_del_tag='1775';
	break;
	case *risparmio casa*:
	$id_del_tag='1783';
	break;
	case *risparmio postale*:
	$id_del_tag='1783';
	break;
	case *governatore della banca d'italia*:
	$id_del_tag='1786';
	break;
	case *crediti*:
	$id_del_tag='1788';
	break;
	case *debiti*:
	$id_del_tag='1788';
	break;
	case *crediti agevolati*:
	$id_del_tag='1788';
	break;
	case *credito artigiano*:
	$id_del_tag='1788';
	break;
	case *credito commerciale*:
	$id_del_tag='1788';
	break;
	case *interessi passivi*:
	$id_del_tag='1788';
	break;
	case *carte di credito*:
	$id_del_tag='1788';
	break;
	case *banche popolari*:
	$id_del_tag='1788';
	break;
	case *sportelli bancari*:
	$id_del_tag='1788';
	break;
	case *conti correnti bancari*:
	$id_del_tag='1788';
	break;
	case *depositi bancari*:
	$id_del_tag='1788';
	break;
	case *fidi bancari*:
	$id_del_tag='1788';
	break;
	case *banche*:
	$id_del_tag='1788';
	break;
	case *istituti di credito*:
	$id_del_tag='1788';
	break;
	case *spese bancarie*:
	$id_del_tag='1788';
	break;
	case *banche cooperative*:
	$id_del_tag='1788';
	break;
	case *politica creditizia*:
	$id_del_tag='1788';
	break;
	case *sistema bancario*:
	$id_del_tag='1788';
	break;
	case *casse di risparmio*:
	$id_del_tag='1788';
	break;
	case *garanzia degli investimenti*:
	$id_del_tag='1788';
	break;
	case *deposito legale*:
	$id_del_tag='1788';
	break;
	case *credito industriale*:
	$id_del_tag='1788';
	break;
	case *garanzia di credito*:
	$id_del_tag='1788';
	break;
	case *banche d'investimenti*:
	$id_del_tag='1788';
	break;
	case *banche pubbliche*:
	$id_del_tag='1788';
	break;
	case *banche commerciali*:
	$id_del_tag='1788';
	break;
	case *tasso di sconto*:
	$id_del_tag='1788';
	break;
	case *pattichiari - consorzio banche*:
	$id_del_tag='1788';
	break;
	case *fideiussione bancaria*:
	$id_del_tag='1788';
	break;
	case *archeologia*:
	$id_del_tag='1799';
	break;
	case *associazione per lo sviluppo dell' industria nel mezzogiorno ( svimez )*:
	$id_del_tag='1803';
	break;
	case *storia moderna*:
	$id_del_tag='1804';
	break;
	case *storia dell'europa*:
	$id_del_tag='1804';
	break;
	case *industria turistica*:
	$id_del_tag='1807';
	break;
	case *attrezzature e insediamenti turistici*:
	$id_del_tag='1807';
	break;
	case *campeggi e villaggi turistici*:
	$id_del_tag='1807';
	break;
	case *roulottes camper e auto caravan*:
	$id_del_tag='1807';
	break;
	case *itinerari turistici*:
	$id_del_tag='1807';
	break;
	case *infrastruttura turistica*:
	$id_del_tag='1807';
	break;
	case *professioni del settore turistico*:
	$id_del_tag='1807';
	break;
	case *enit - agenzia nazionale del turismo*:
	$id_del_tag='1807';
	break;
	case *politica del turismo*:
	$id_del_tag='1807';
	break;
	case *agenzie turistiche*:
	$id_del_tag='1807';
	break;
	case *autocaravan*:
	$id_del_tag='1807';
	break;
	case *turismo all'aria aperta*:
	$id_del_tag='1807';
	break;
	case *imprese turistiche*:
	$id_del_tag='1807';
	break;
	case *trasporti via acqua*:
	$id_del_tag='1812';
	break;
	case *regolamentazione dei trasporti*:
	$id_del_tag='1812';
	break;
	case *linea di trasporto*:
	$id_del_tag='1812';
	break;
	case *trasporto d'energia*:
	$id_del_tag='1812';
	break;
	case *reti di trasporti*:
	$id_del_tag='1812';
	break;
	case *trasporto combinato*:
	$id_del_tag='1812';
	break;
	case *trasporti sotterranei*:
	$id_del_tag='1812';
	break;
	case *trasporti urbani*:
	$id_del_tag='1812';
	break;
	case *politica dei trasporti*:
	$id_del_tag='1812';
	break;
	case *trasporti terrestri*:
	$id_del_tag='1812';
	break;
	case *aviazione civile*:
	$id_del_tag='1829';
	break;
	case *compagnie aeree*:
	$id_del_tag='1829';
	break;
	case *linee aeree*:
	$id_del_tag='1829';
	break;
	case *aerei*:
	$id_del_tag='1829';
	break;
	case *autotreni e rimorchi*:
	$id_del_tag='1833';
	break;
	case *autobus*:
	$id_del_tag='1833';
	break;
	case *autotrasportatori*:
	$id_del_tag='1833';
	break;
	case *autisti*:
	$id_del_tag='1833';
	break;
	case *opere marittime e portuali*:
	$id_del_tag='1850';
	break;
	case *linee di navigazione*:
	$id_del_tag='1850';
	break;
	case *decisioni dell' unione europea*:
	$id_del_tag='1851';
	break;
	case *direttive dell'unione europea*:
	$id_del_tag='1851';
	break;
	case *regolamenti dell'unione europea*:
	$id_del_tag='1851';
	break;
	case *politica comunitaria*:
	$id_del_tag='1851';
	break;
	case *programmi comunitari*:
	$id_del_tag='1851';
	break;
	case *bilancio comunitario*:
	$id_del_tag='1851';
	break;
	case *funzionari europei*:
	$id_del_tag='1851';
	break;
	case *statistica comunitaria*:
	$id_del_tag='1851';
	break;
	case *concorsi unione europea*:
	$id_del_tag='1851';
	break;
	case *raccomandazioni dell'unione europea*:
	$id_del_tag='1851';
	break;
	case *politica comunitaria-politica nazionale*:
	$id_del_tag='1851';
	break;
	case *politica regionale comunitaria*:
	$id_del_tag='1851';
	break;
	case *produzione comunitaria*:
	$id_del_tag='1851';
	break;
	case *commisioni del parlamento europeo*:
	$id_del_tag='1851';
	break;
	case *gazzetta ufficiale ue*:
	$id_del_tag='1851';
	break;
	case *organismo e agenzia ue*:
	$id_del_tag='1851';
	break;
	case *trattato di amsterdam*:
	$id_del_tag='1854';
	break;
	case *carta dei diritti fondamentali dell'unione europea*:
	$id_del_tag='1854';
	break;
	case *convenzione europea dei diritti dell'uomo*:
	$id_del_tag='1854';
	break;
	case *trattato di nizza*:
	$id_del_tag='1854';
	break;
	case *trattato cee*:
	$id_del_tag='1854';
	break;
	case *trattato di lisbona*:
	$id_del_tag='1854';
	break;
	case *parlamentare europeo*:
	$id_del_tag='1856';
	break;
	case *cantieri edili*:
	$id_del_tag='1864';
	break;
	case *ricostruzione e consolidamento di abitati e di immobili*:
	$id_del_tag='1864';
	break;
	case *edilizia convenzionata*:
	$id_del_tag='1864';
	break;
	case *edilizia pubblica*:
	$id_del_tag='1864';
	break;
	case *edilizia agevolata*:
	$id_del_tag='1864';
	break;
	case *mutui edilizi*:
	$id_del_tag='1864';
	break;
	case *edilizia residenziale*:
	$id_del_tag='1864';
	break;
	case *edilizia scolastica*:
	$id_del_tag='1864';
	break;
	case *edilizia scolastica ed universitaria*:
	$id_del_tag='1864';
	break;
	case *lottizzazione*:
	$id_del_tag='1864';
	break;
	case *industria edile*:
	$id_del_tag='1864';
	break;
	case *norme per l'edilizia*:
	$id_del_tag='1864';
	break;
	case *finanziamenti alla ristrutturazione*:
	$id_del_tag='1864';
	break;
	case *politica edilizia*:
	$id_del_tag='1864';
	break;
	case *ricostruzioni e ristrutturazioni edilizie*:
	$id_del_tag='1864';
	break;
	case *ricoveri ospedalieri*:
	$id_del_tag='1877';
	break;
	case *ospedali psichiatrici*:
	$id_del_tag='1877';
	break;
	case *presidi sanitari*:
	$id_del_tag='1877';
	break;
	case *ospedali*:
	$id_del_tag='1877';
	break;
	case *cliniche e policlinici universitari*:
	$id_del_tag='1877';
	break;
	case *luoghi e locali pubblici e aperti al pubblico*:
	$id_del_tag='1884';
	break;
	case *ristorazione collettiva*:
	$id_del_tag='1884';
	break;
	case *industria della ristorazione*:
	$id_del_tag='1884';
	break;
	case *enti lirici*:
	$id_del_tag='1887';
	break;
	case *teatro dell'opera di roma*:
	$id_del_tag='1887';
	break;
	case *parco dello stelvio*:
	$id_del_tag='1899';
	break;
	case *parco del ticino*:
	$id_del_tag='1899';
	break;
	case *parco del pollino*:
	$id_del_tag='1899';
	break;
	case *centri storici e zone pedonali*:
	$id_del_tag='1906';
	break;
	case *festivita' e solennita' religiose*:
	$id_del_tag='1911';
	break;
	case *giorno della memoria*:
	$id_del_tag='1912';
	break;
	case *luoghi della memoria*:
	$id_del_tag='1912';
	break;
	case *l'energia e l'ambiente ( enea )*:
	$id_del_tag='2210';
	break;
	case *ente per le nuove tecnologie l'energia e l' ambiente ( enea )*:
	$id_del_tag='2210';
	break;
	case *regioni mediterranee unione europea*:
	$id_del_tag='2250';
	break;
	case *assemblea generale dell'onu*:
	$id_del_tag='2261';
	break;
	case *conferenza dell'onu*:
	$id_del_tag='2261';
	break;
	case *convenzione onu*:
	$id_del_tag='2261';
	break;
	case *carta delle nazioni unite*:
	$id_del_tag='2261';
	break;
	case *consiglio di sicurezza dell'onu*:
	$id_del_tag='2261';
	break;
	case *poste e telecomunicazioni*:
	$id_del_tag='2271';
	break;
	case *postelegrafonici*:
	$id_del_tag='2271';
	break;
	case *servizio postale*:
	$id_del_tag='2271';
	break;
	case *uffici postali e telegrafici*:
	$id_del_tag='2271';
	break;
	case *servizio radiotelevisivo*:
	$id_del_tag='2273';
	break;
	case *canone di abbonamento*:
	$id_del_tag='2273';
	break;
	case *societa' italiana autori ed editori ( siae )*:
	$id_del_tag='2283';
	break;
	case *fondo di garanzia per le vittime della strada*:
	$id_del_tag='2300';
	break;
	case *genetica*:
	$id_del_tag='2307';
	break;
	case *clonazione*:
	$id_del_tag='2307';
	break;
	case *ingegneria genetica*:
	$id_del_tag='2307';
	break;
	case *g8*:
	$id_del_tag='2322';
	break;
	case *societa' stretto di messina*:
	$id_del_tag='2346';
	break;
	case *darfur*:
	$id_del_tag='2348';
	break;
	case *inno*:
	$id_del_tag='2362';
	break;
	case *scuola elementare*:
	$id_del_tag='2368';
	break;
	case *istruzione primaria*:
	$id_del_tag='2368';
	break;
	case *recessione economica*:
	$id_del_tag='4242';
	break;
	case *stagnazione economica*:
	$id_del_tag='4242';
	break;
	case *diritto di sciopero*:
	$id_del_tag='4247';
	break;
	case *risoluzioni*:
	$id_del_tag='4264';
	break;
	case *interpellanza*:
	$id_del_tag='4264';
	break;
	case *risoluzione del parlamento*:
	$id_del_tag='4264';
	break;
	case *procedura parlamentare*:
	$id_del_tag='4264';
	break;
	case *seduta parlamentare*:
	$id_del_tag='4264';
	break;
	case *centri di permanenza temporanea (cpt)*:
	$id_del_tag='4279';
	break;
	case *dazi e diritti doganali*:
	$id_del_tag='4280';
	break;
	case *tariffe doganali*:
	$id_del_tag='4280';
	break;
	case *spedizionieri doganali*:
	$id_del_tag='4280';
	break;
	case *agenzia delle dogane*:
	$id_del_tag='4280';
	break;
	case *regolamentazione doganale*:
	$id_del_tag='4280';
	break;
	case *controlli doganali*:
	$id_del_tag='4280';
	break;
	case *expo 2015*:
	$id_del_tag='4288';
	break;
	case *piani di sviluppo*:
	$id_del_tag='4305';
	break;
	case *politica di sviluppo*:
	$id_del_tag='4305';
	break;
	case *crescita economica*:
	$id_del_tag='4305';
	break;
	case *violenza e minacce*:
	$id_del_tag='4319';
	break;
	case *maltrattamenti e sevizie*:
	$id_del_tag='4319';
	break;
	case *violenza psicologica e mobbing*:
	$id_del_tag='4319';
	break;
	case *commercio di organi*:
	$id_del_tag='4319';
	break;
	case *violenza contro le donne*:
	$id_del_tag='4319';
	break;
	case *violenza negli stadi*:
	$id_del_tag='4319';
	break;
	case *atti persecutori (stalking)*:
	$id_del_tag='4319';
	break;
	case *odontoiatri*:
	$id_del_tag='4331';
	break;
	case *odontotecnici*:
	$id_del_tag='4331';
	break;
	case *odontoiatria*:
	$id_del_tag='4331';
	break;
	case *rilascio di immobili*:
	$id_del_tag='4354';
	break;
	case *condominio*:
	$id_del_tag='4354';
	break;
	case *riscatto e cessione di alloggi*:
	$id_del_tag='4354';
	break;
	case *assegnazione di alloggi*:
	$id_del_tag='4354';
	break;
	case *diritto alla casa*:
	$id_del_tag='4354';
	break;
	case *politica della casa*:
	$id_del_tag='4354';
	break;
	case *abitazione*:
	$id_del_tag='4354';
	break;
	case *entrate tributarie*:
	$id_del_tag='4357';
	break;
	case *doppia imposizione sui redditi*:
	$id_del_tag='4357';
	break;
	case *agevolazioni fiscali*:
	$id_del_tag='4357';
	break;
	case *esenzioni da imposte tasse e contributi*:
	$id_del_tag='4357';
	break;
	case *deduzioni e detrazioni*:
	$id_del_tag='4357';
	break;
	case *detrazioni di imposte*:
	$id_del_tag='4357';
	break;
	case *riscossione di imposte*:
	$id_del_tag='4357';
	break;
	case *credito di imposte*:
	$id_del_tag='4357';
	break;
	case *rimborso di imposte*:
	$id_del_tag='4357';
	break;
	case *sostituti di imposta*:
	$id_del_tag='4357';
	break;
	case *ricorsi tributari*:
	$id_del_tag='4357';
	break;
	case *imposte di bollo*:
	$id_del_tag='4357';
	break;
	case *imposte di registro*:
	$id_del_tag='4357';
	break;
	case *ilor*:
	$id_del_tag='4357';
	break;
	case *imposte di consumo*:
	$id_del_tag='4357';
	break;
	case *imposta sul valore aggiunto (iva) *:
	$id_del_tag='4357';
	break;
	case *imposte di fabbricazione*:
	$id_del_tag='4357';
	break;
	case *imposta sul reddito delle persone fisiche (irpef)*:
	$id_del_tag='4357';
	break;
	case *imposta sul reddito delle persone giuridiche (irpeg)*:
	$id_del_tag='4357';
	break;
	case *trattenute sul reddito*:
	$id_del_tag='4357';
	break;
	case *agevolazioni contributive*:
	$id_del_tag='4357';
	break;
	case *imposta regionale sulle attivit*:
	$id_del_tag='4357';
	break;
	case *imposte sugli immobili*:
	$id_del_tag='4357';
	break;
	case *base imponibile*:
	$id_del_tag='4357';
	break;
	case *imposte sul reddito*:
	$id_del_tag='4357';
	break;
	case *politica fiscale*:
	$id_del_tag='4357';
	break;
	case *dichiarazione d'imposta*:
	$id_del_tag='4357';
	break;
	case *imposte dirette*:
	$id_del_tag='4357';
	break;
	case *imposte indirette*:
	$id_del_tag='4357';
	break;
	case *imposte sulle societa'*:
	$id_del_tag='4357';
	break;
	case *trattenuta alla fonte*:
	$id_del_tag='4357';
	break;
	case *imposte fondiarie*:
	$id_del_tag='4357';
	break;
	case *imposta sul reddito per le societ*:
	$id_del_tag='4357';
	break;
	case *imposte sui carburanti*:
	$id_del_tag='4357';
	break;
	case *imposte sui trasferimenti*:
	$id_del_tag='4357';
	break;
	case *tributi*:
	$id_del_tag='4357';
	break;
	case *ici - imposta comunale sugli immobili*:
	$id_del_tag='4357';
	break;
	case *ici*:
	$id_del_tag='4357';
	break;
	case *irpef*:
	$id_del_tag='4357';
	break;
	case *aliquote di imposte*:
	$id_del_tag='4357';
	break;
	case *irpeg*:
	$id_del_tag='4357';
	break;
	case *ritenute fiscali*:
	$id_del_tag='4357';
	break;
	case *ruolo d'imposte*:
	$id_del_tag='4357';
	break;
	case *imposta sul reddito*:
	$id_del_tag='4357';
	break;
	case *imposta sui carburanti*:
	$id_del_tag='4357';
	break;
	case *trasporti scolastici*:
	$id_del_tag='4377';
	break;
	case *controversie di lavoro*:
	$id_del_tag='4388';
	break;
	case *processo del lavoro*:
	$id_del_tag='4388';
	break;
	case *dimissioni*:
	$id_del_tag='4388';
	break;
	case *giurisdizione del lavoro*:
	$id_del_tag='4388';
	break;
	case *controversia di lavoro*:
	$id_del_tag='4388';
	break;
	case *codice del lavoro*:
	$id_del_tag='4388';
	break;
	case *dimissioni in bianco*:
	$id_del_tag='4388';
	break;
	case *riserve auree e valutarie*:
	$id_del_tag='4440';
	break;
	case *imprese individuali*:
	$id_del_tag='4448';
	break;
	case *imprese familiari*:
	$id_del_tag='4448';
	break;
	case *piccole e medie imprese*:
	$id_del_tag='4448';
	break;
	case *stranieri*:
	$id_del_tag='4474';
	break;
	case *extra comunitari*:
	$id_del_tag='4474';
	break;
	case *diritti degli stranieri*:
	$id_del_tag='4474';
	break;
	case *sorveglianza degli stranieri*:
	$id_del_tag='4474';
	break;
	case *ingresso degli stranieri*:
	$id_del_tag='4474';
	break;
	case *integrazione degli stranieri*:
	$id_del_tag='4474';
	break;
	case *integrazione culturale*:
	$id_del_tag='4481';
	break;
	case *mediatori interculturali*:
	$id_del_tag='4481';
	break;
	case *intemperie*:
	$id_del_tag='4483';
	break;
	case *vittime di calamita' e disastri*:
	$id_del_tag='4484';
	break;
	case *inondazione*:
	$id_del_tag='4484';
	break;
	case *emergenza piogge*:
	$id_del_tag='4484';
	break;
	case *zooprofilassi*:
	$id_del_tag='4497';
	break;
	case *piano energetico nazionale (pen)*:
	$id_del_tag='4536';
	break;
	case *normativa energetica*:
	$id_del_tag='4536';
	break;
	case *reti energetiche*:
	$id_del_tag='4536';
	break;
	case *tecnologia energetica*:
	$id_del_tag='4536';
	break;
	case *approvvigionamento d'energia*:
	$id_del_tag='4536';
	break;
	case *ricerca energetica*:
	$id_del_tag='4536';
	break;
	case *indipendenza energetica*:
	$id_del_tag='4536';
	break;
	case *risorse energetiche*:
	$id_del_tag='4536';
	break;
	case *diversificazione energetica*:
	$id_del_tag='4536';
	break;
	case *elusione fiscale*:
	$id_del_tag='4542';
	break;
	case *evasioni contributive*:
	$id_del_tag='4542';
	break;
	case *convenzione per la protezione delle alpi*:
	$id_del_tag='4563';
	break;
	case *accertamenti sanitari*:
	$id_del_tag='4567';
	break;
	case *diritto umanitario internazionale*:
	$id_del_tag='4585';
	break;
	case *diritti dell'uomo*:
	$id_del_tag='4585';
	break;
	case *servitu'*:
	$id_del_tag='4588';
	break;
	case *finanza pubblica*:
	$id_del_tag='4618';
	break;
	case *economia nazionale*:
	$id_del_tag='4618';
	break;
	case *economia sociale*:
	$id_del_tag='4618';
	break;
	case *politica forestale*:
	$id_del_tag='4641';
	break;
	case *politica comunitaria dell'ambiente*:
	$id_del_tag='4641';
	break;
	case *principio chi inquina paga*:
	$id_del_tag='4641';
	break;
	case *aiuti alimentari*:
	$id_del_tag='4653';
	break;
	case *produzione nazionale*:
	$id_del_tag='4657';
	break;
	case *apparecchi e impianti elettronici*:
	$id_del_tag='4674';
	break;
	case *industria elettronica*:
	$id_del_tag='4674';
	break;
	case *investimenti pubblici*:
	$id_del_tag='4690';
	break;
	case *piano di finanziamento*:
	$id_del_tag='4690';
	break;
	case *finanziamenti ai meno abbienti*:
	$id_del_tag='4690';
	break;
	case *sistema di finanziamento*:
	$id_del_tag='4690';
	break;
	case *politica d'investimento*:
	$id_del_tag='4690';
	break;
	case *politica di finanziamento*:
	$id_del_tag='4690';
	break;
	case *firma elettronica*:
	$id_del_tag='4702';
	break;
	case *agenzia per la diffusione delle tecnologie per l'innovazione*:
	$id_del_tag='4702';
	break;
	case *delegificazione*:
	$id_del_tag='4703';
	break;
	case *armonizzazione delle norme*:
	$id_del_tag='4703';
	break;
	case *deregolamentazione*:
	$id_del_tag='4703';
	break;
	case *spiagge e litorali*:
	$id_del_tag='4729';
	break;
	case *sorveglianza delle coste*:
	$id_del_tag='4729';
	break;
	case *regioni costiere*:
	$id_del_tag='4729';
	break;
	case *mass media privati*:
	$id_del_tag='4730';
	break;
	case *biogas*:
	$id_del_tag='4732';
	break;
	case *biomassa*:
	$id_del_tag='4732';
	break;
	case *bioenergia*:
	$id_del_tag='4732';
	break;
	case *antisemitismo*:
	$id_del_tag='4739';
	break;
	case *fondo europeo di sviluppo regionale ( fers )*:
	$id_del_tag='4740';
	break;
	case *finanziamento comunitario*:
	$id_del_tag='4740';
	break;
	case *equipollenza di titoli di studio*:
	$id_del_tag='4756';
	break;
	case *esami di stato*:
	$id_del_tag='4756';
	break;
	case *classi scolastiche*:
	$id_del_tag='4756';
	break;
	case *pubblico registro automobilistico (pra)*:
	$id_del_tag='4763';
	break;
	case *infrazione al codice della strada*:
	$id_del_tag='4763';
	break;
	case *regolamentazione della velocita'*:
	$id_del_tag='4763';
	break;
	case *certificati di circolazione*:
	$id_del_tag='4763';
	break;
	case *regolamentazione del traffico*:
	$id_del_tag='4763';
	break;
	case *ricerca industriale*:
	$id_del_tag='4791';
	break;
	case *acque superficiali*:
	$id_del_tag='4853';
	break;
	case *asilo politico*:
	$id_del_tag='4871';
	break;
	case *zootecnia e allevamento*:
	$id_del_tag='4900';
	break;
	case *zootecnia*:
	$id_del_tag='4900';
	break;
	case *violazione del diritto comunitario*:
	$id_del_tag='4932';
	break;
	case *misure contro la disoccupazione*:
	$id_del_tag='4936';
	break;
	case *creazione di posti di lavoro*:
	$id_del_tag='4936';
	break;
	case *politica comunitaria dell'occupazione*:
	$id_del_tag='4936';
	break;
	case *salvaguardia dei posti di lavoro*:
	$id_del_tag='4936';
	break;
	case *canone di locazione*:
	$id_del_tag='4955';
	break;
	case *canone agevolato*:
	$id_del_tag='4955';
	break;
	case *patti in deroga*:
	$id_del_tag='4955';
	break;
	case *contratti di locazione*:
	$id_del_tag='4955';
	break;
	case *equo canone*:
	$id_del_tag='4955';
	break;
	case *pianificazione economica*:
	$id_del_tag='4977';
	break;
	case *frequenze radiofoniche e televisive*:
	$id_del_tag='4989';
	break;
	case *stazioni e impianti radiotelevisivi*:
	$id_del_tag='4989';
	break;
	case *trasmissioni radiotelevisive*:
	$id_del_tag='4989';
	break;
	case *programmi radiotelevisivi*:
	$id_del_tag='4989';
	break;
	case *apparecchi televisivi*:
	$id_del_tag='4989';
	break;
	case *televisione via cavo*:
	$id_del_tag='4989';
	break;
	case *servizi di sicurezza*:
	$id_del_tag='5001';
	break;
	case *spionaggio*:
	$id_del_tag='5001';
	break;
	case *controspionaggio*:
	$id_del_tag='5001';
	break;
	case *cristiani*:
	$id_del_tag='5007';
	break;
	case *ispettori*:
	$id_del_tag='5037';
	break;
	case *ispettori generali*:
	$id_del_tag='5037';
	break;
	case *satelliti artificiali*:
	$id_del_tag='5073';
	break;
	case *telecomunicazioni senza filo (wireless)*:
	$id_del_tag='5073';
	break;
	case *industria delle telecomunicazioni*:
	$id_del_tag='5073';
	break;
	case *reti di informazione e comunicazione*:
	$id_del_tag='5073';
	break;
	case *prezzi*:
	$id_del_tag='5162';
	break;
	case *controllo dei prezzi*:
	$id_del_tag='5162';
	break;
	case *prezzi di mercato*:
	$id_del_tag='5162';
	break;
	case *regolamentazione dei prezzi*:
	$id_del_tag='5162';
	break;
	case *stabilita' dei prezzi*:
	$id_del_tag='5162';
	break;
	case *prezzi alla produzione*:
	$id_del_tag='5162';
	break;
	case *prezzo di vendita*:
	$id_del_tag='5162';
	break;
	case *costo della vita*:
	$id_del_tag='5162';
	break;
	case *prezzi dell'energia*:
	$id_del_tag='5162';
	break;
	case *prezzo massimo*:
	$id_del_tag='5162';
	break;
	case *politica dei prezzi*:
	$id_del_tag='5162';
	break;
	case *prezzi all'ingrosso*:
	$id_del_tag='5162';
	break;
	case *liberazione condizionale*:
	$id_del_tag='5186';
	break;
	case *procedimenti cautelari ed esecutivi*:
	$id_del_tag='5186';
	break;
	case *custodia cautelare*:
	$id_del_tag='5186';
	break;
	case *liberta' controllata e vigilata*:
	$id_del_tag='5186';
	break;
	case *semiliberta' del condannato*:
	$id_del_tag='5186';
	break;
	case *misure cautelari e liberta' personale dell' imputato*:
	$id_del_tag='5186';
	break;
	case *diritto e procedura penale militare*:
	$id_del_tag='5208';
	break;
	case *treno alta velocitã  (tav)*:
	$id_del_tag='5320';
	break;
	case *contratti bancari e finanziari*:
	$id_del_tag='5326';
	break;
	case *porti zone e punti franchi*:
	$id_del_tag='5328';
	break;
	case *zone franche industriali*:
	$id_del_tag='5328';
	break;
	case *sicurezza degli impianti nucleari*:
	$id_del_tag='845';
	break;
	case *mollusco*:
	$id_del_tag='5336';
	break;
	case *molluschicoltura*:
	$id_del_tag='5336';
	break;
	case *crostacei*:
	$id_del_tag='5336';
	break;
	case *molluschi*:
	$id_del_tag='5336';
	break;
	case *edilizia economica e popolare*:
	$id_del_tag='5341';
	break;
	case *istituti autonomi per le case popolari ( iacp )*:
	$id_del_tag='5341';
	break;
	case *gratuito patrocinio*:
	$id_del_tag='5351';
	break;
	case *riparazione giudiziaria*:
	$id_del_tag='5351';
	break;
	case *ex detenuti*:
	$id_del_tag='5351';
	break;
	case *ordinamento giudiziario*:
	$id_del_tag='5351';
	break;
	case *amministrazione giudiziaria*:
	$id_del_tag='5351';
	break;
	case *circoscrizioni giudiziarie*:
	$id_del_tag='5351';
	break;
	case *uffici giudiziari*:
	$id_del_tag='5351';
	break;
	case *istituzione di sedi e uffici giudiziari*:
	$id_del_tag='5351';
	break;
	case *sezioni di uffici giudiziari*:
	$id_del_tag='5351';
	break;
	case *personale dell' amministrazione della giustizia*:
	$id_del_tag='5351';
	break;
	case *ricorsi giurisdizionali*:
	$id_del_tag='5351';
	break;
	case *istituzione di sedi ed uffici pubblici*:
	$id_del_tag='5351';
	break;
	case *ministero della giustizia*:
	$id_del_tag='5351';
	break;
	case *ufficiali giudiziari*:
	$id_del_tag='5351';
	break;
	case *procedimento giudiziario*:
	$id_del_tag='5351';
	break;
	case *azione giudiziaria*:
	$id_del_tag='5351';
	break;
	case *competenza giurisdizionale*:
	$id_del_tag='5351';
	break;
	case *sistema giudiziario*:
	$id_del_tag='5351';
	break;
	case *riforme della giustizia*:
	$id_del_tag='5351';
	break;
	case *giusto processo*:
	$id_del_tag='5351';
	break;
	case *professioni giudiziarie*:
	$id_del_tag='5351';
	break;
	case *istruzione giudiziaria*:
	$id_del_tag='5351';
	break;
	case *spese processuali*:
	$id_del_tag='5351';
	break;
	case *cooperazione giudiziaria*:
	$id_del_tag='5351';
	break;
	case *casellario giudiziale*:
	$id_del_tag='5351';
	break;
	case *ritardi della giustizia*:
	$id_del_tag='5351';
	break;
	case *inquinamento prodotto dalle navi*:
	$id_del_tag='5370';
	break;
	case *confisca*:
	$id_del_tag='5382';
	break;
	case *sequestro giudiziario*:
	$id_del_tag='5382';
	break;
	case *beni confiscati alla mafia*:
	$id_del_tag='5382';
	break;
	case *ingegneri*:
	$id_del_tag='5389';
	break;
	case *professioni*:
	$id_del_tag='5389';
	break;
	case *liberi professionisti*:
	$id_del_tag='5389';
	break;
	case *professioni non regolamentate*:
	$id_del_tag='5389';
	break;
	case *prevenzione del crimine*:
	$id_del_tag='5436';
	break;
	case *factoring*:
	$id_del_tag='5561';
	break;
	case *fattura commerciale*:
	$id_del_tag='5561';
	break;
	case *concordato preventivo*:
	$id_del_tag='5561';
	break;
	case *societa' tra professionisti*:
	$id_del_tag='5561';
	break;
	case *societa' consortili*:
	$id_del_tag='5561';
	break;
	case *liquidazione di societa'*:
	$id_del_tag='5561';
	break;
	case *diritto delle societa'*:
	$id_del_tag='5561';
	break;
	case *registrazione di societa'*:
	$id_del_tag='5561';
	break;
	case *risorse idriche*:
	$id_del_tag='5569';
	break;
	case *salvaguardia delle risorse*:
	$id_del_tag='5569';
	break;
	case *risorse vegetali*:
	$id_del_tag='5569';
	break;
	case *sanzioni comunitarie*:
	$id_del_tag='5586';
	break;
	case *cristiano*:
	$id_del_tag='5007';
	break;
	case *assenze dal lavoro*:
	$id_del_tag='5614';
	break;
	case *consumi*:
	$id_del_tag='5626';
	break;
	case *autoconsumo*:
	$id_del_tag='5626';
	break;
	case *consumo*:
	$id_del_tag='5626';
	break;
	case *cittadinanza europea*:
	$id_del_tag='5688';
	break;
	case *cittadini europei residenti in italia*:
	$id_del_tag='5688';
	break;
	case *indennita' di maternita'*:
	$id_del_tag='5703';
	break;
	case *sofisticazioni alimentari*:
	$id_del_tag='5726';
	break;
	case *autorita' europea per la sicurezza alimentare*:
	$id_del_tag='5726';
	break;
	case *autorita' europea per la sicurezza alimentare - european food safety authority ( efsa )*:
	$id_del_tag='5726';
	break;
	case *amministrazione autonoma dei monopoli di stato*:
	$id_del_tag='5757';
	break;
	case *prodotti petroliferi*:
	$id_del_tag='5760';
	break;
	case *industria petrolifera*:
	$id_del_tag='5760';
	break;
	case *estrazione petrolifera*:
	$id_del_tag='5760';
	break;
	case *raffinazione del petrolio*:
	$id_del_tag='5760';
	break;
	case *trasporti locali*:
	$id_del_tag='5799';
	break;
	case *personale sanitario*:
	$id_del_tag='5813';
	break;
	case *personale paramedico*:
	$id_del_tag='5813';
	break;
	case *infermieri*:
	$id_del_tag='5813';
	break;
	case *ostetriche*:
	$id_del_tag='5813';
	break;
	case *tecnici sanitari*:
	$id_del_tag='5813';
	break;
	case *professione sanitaria*:
	$id_del_tag='5813';
	break;
	case *levatrici*:
	$id_del_tag='5813';
	break;
	case *professioni paramediche*:
	$id_del_tag='5813';
	break;
	case *concussione*:
	$id_del_tag='5829';
	break;
	case *banca mondiale*:
	$id_del_tag='5837';
	break;
	case *demografia*:
	$id_del_tag='5870';
	break;
	case *censimenti*:
	$id_del_tag='5870';
	break;
	case *statistica*:
	$id_del_tag='5870';
	break;
	case *rilevamenti statistici*:
	$id_del_tag='5870';
	break;
	case *statistica ufficiale*:
	$id_del_tag='5870';
	break;
	case *validita' ed efficacia delle leggi*:
	$id_del_tag='5895';
	break;
	case *applicazione della legge*:
	$id_del_tag='5895';
	break;
	case *speculazione industriale*:
	$id_del_tag='5929';
	break;
	case *istituto nazionale per il commercio estero ( ice )*:
	$id_del_tag='5985';
	break;
	case *conflitti tra poteri*:
	$id_del_tag='6009';
	break;
	case *abrogazione*:
	$id_del_tag='6009';
	break;
	case *diritto territoriale*:
	$id_del_tag='6009';
	break;
	case *interpretazione del diritto*:
	$id_del_tag='6009';
	break;
	case *diritto pubblico*:
	$id_del_tag='6009';
	break;
	case *fonti del diritto*:
	$id_del_tag='6009';
	break;
	case *bicameralismo*:
	$id_del_tag='6009';
	break;
	case *indigenti e nullatenenti*:
	$id_del_tag='6019';
	break;
	case *social card*:
	$id_del_tag='6019';
	break;
	case *consiglio nazionale dell' economia e del lavoro*:
	$id_del_tag='6092';
	break;
	case *commissione ce*:
	$id_del_tag='6099';
	break;
	case *acciaio*:
	$id_del_tag='6112';
	break;
	case *ferro*:
	$id_del_tag='6112';
	break;
	case *prodotti siderurgici*:
	$id_del_tag='6112';
	break;
	case *terre incolte e abbandonate*:
	$id_del_tag='6121';
	break;
	case *zone e aree rurali*:
	$id_del_tag='6121';
	break;
	case *trattamento dei dati*:
	$id_del_tag='6146';
	break;
	case *autorita' garante per la protezione dei dati personali*:
	$id_del_tag='6146';
	break;
	case *ente nazionale per l' aviazione civile ( enac )*:
	$id_del_tag='6157';
	break;
	case *corpo forestale dello stato*:
	$id_del_tag='6199';
	break;
	case *treni*:
	$id_del_tag='6269';
	break;
	case *industria ferroviaria*:
	$id_del_tag='6269';
	break;
	case *trenitalia*:
	$id_del_tag='6269';
	break;
	case *discriminazione religiosa*:
	$id_del_tag='6470';
	break;
	case *globalizzazione*:
	$id_del_tag='6472';
	break;
	case *moneta*:
	$id_del_tag='6474';
	break;
	case *svalutazione*:
	$id_del_tag='6474';
	break;
	case *moneta elettronica*:
	$id_del_tag='6474';
	break;
	case *sistema monetario bancario e intermediazione finanziaria*:
	$id_del_tag='6474';
	break;
	case *politica monetaria*:
	$id_del_tag='6474';
	break;
	case *accordo di bretton woods*:
	$id_del_tag='6474';
	break;
	case *lavoratori studenti*:
	$id_del_tag='6504';
	break;
	case *fondi di garanzia*:
	$id_del_tag='6515';
	break;
	case *pediatri*:
	$id_del_tag='6523';
	break;
	case *conflitto religioso*:
	$id_del_tag='6529';
	break;
	case *costituzione europea*:
	$id_del_tag='6535';
	break;
	case *identita' europea*:
	$id_del_tag='6535';
	break;
	case *integrazione europea*:
	$id_del_tag='6535';
	break;
	case *industria della carta e della pasta di legno*:
	$id_del_tag='6564';
	break;
	case *industria pasticcera*:
	$id_del_tag='6633';
	break;
	case *industria saccarifera*:
	$id_del_tag='6633';
	break;
	case *denominazione di origine di prodotti*:
	$id_del_tag='6671';
	break;
	case *industria del mobile*:
	$id_del_tag='708';
	break;
	case *ingegneria e tecnologia*:
	$id_del_tag='6695';
	break;
	case *parchi tecnologici*:
	$id_del_tag='6695';
	break;
	case *impianti idroelettrici e termoelettrici*:
	$id_del_tag='6697';
	break;
	case *tecnica legislativa*:
	$id_del_tag='6734';
	break;
	case *iniziativa legislativa*:
	$id_del_tag='6734';
	break;
	case *promulgazione*:
	$id_del_tag='6734';
	break;
	case *disegno di legge*:
	$id_del_tag='6734';
	break;
	case *approvazione della legge*:
	$id_del_tag='6734';
	break;
	case *promulgazione della legge*:
	$id_del_tag='6734';
	break;
	case *pubblicazione delle leggi*:
	$id_del_tag='6734';
	break;
	case *personale diplomatico e consolare*:
	$id_del_tag='6812';
	break;
	case *consoli*:
	$id_del_tag='6812';
	break;
	case *rappresentanze diplomatiche e consolari*:
	$id_del_tag='6812';
	break;
	case *rappresentanza diplomatica*:
	$id_del_tag='6812';
	break;
	case *consolati*:
	$id_del_tag='6812';
	break;
	case *professioni diplomatiche*:
	$id_del_tag='6812';
	break;
	case *comitati consolari*:
	$id_del_tag='6812';
	break;
	case *folklore*:
	$id_del_tag='6834';
	break;
	case *culture regionali*:
	$id_del_tag='6834';
	break;
	case *proprieta' letteraria e artistica*:
	$id_del_tag='6894';
	break;
	case *proprieta' intellettuale*:
	$id_del_tag='6894';
	break;
	case *ocse*:
	$id_del_tag='6903';
	break;
	case *riciclaggio di denaro*:
	$id_del_tag='6972';
	break;
	case *politica monetaria unica*:
	$id_del_tag='6987';
	break;
	case *imprese lattiere*:
	$id_del_tag='7065';
	break;
	case *agitazioni politiche*:
	$id_del_tag='7086';
	break;
	case *acque territoriali*:
	$id_del_tag='7134';
	break;
	case *calamita' naturali*:
	$id_del_tag='7245';
	break;
	case *espulsione di stranieri*:
	$id_del_tag='7304';
	break;
	case *rimpatrio*:
	$id_del_tag='7304';
	break;
	case *centri di identificazione ed espulsione ( cie )*:
	$id_del_tag='7304';
	break;
	case *centri di permanenza temporanea ( cpt )*:
	$id_del_tag='7304';
	break;
	case *centro identificazione ed espulsione (cie)*:
	$id_del_tag='7304';
	break;
	case *ubriachezza*:
	$id_del_tag='7306';
	break;
	case *pedagogia*:
	$id_del_tag='7366';
	break;
	case *materie di insegnamento*:
	$id_del_tag='7366';
	break;
	case *maestro unico*:
	$id_del_tag='7366';
	break;
	case *insegnamento*:
	$id_del_tag='7366';
	break;
	case *insegnamento delle lingue*:
	$id_del_tag='7366';
	break;
	case *interrogazione orale*:
	$id_del_tag='7366';
	break;
	case *istituto nazionale per la valutazione del sistema educativo di istruzione e di formazione ( invalsi )*:
	$id_del_tag='7366';
	break;
	case *metodo di valutazione*:
	$id_del_tag='7366';
	break;
	case *adesione all'unione europea*:
	$id_del_tag='7371';
	break;
	case *associazione all'unione europea*:
	$id_del_tag='7371';
	break;
	case *licenziamenti discriminatori*:
	$id_del_tag='7380';
	break;
	case *riduzione di personale*:
	$id_del_tag='7380';
	break;
	case *indennita' di licenziamento*:
	$id_del_tag='7380';
	break;
	case *soppressione di posti di lavoro*:
	$id_del_tag='7380';
	break;
	case *licenziamento collettivo*:
	$id_del_tag='7380';
	break;
	case *licenziamento abusivo*:
	$id_del_tag='7380';
	break;
	case *misure di prevenzione e sicurezza*:
	$id_del_tag='7476';
	break;
	case *consigli e assemblee  regionali*:
	$id_del_tag='7657';
	break;
	case *olive*:
	$id_del_tag='7660';
	break;
	case *olio vegetale*:
	$id_del_tag='7660';
	break;
	case *oleicoltura*:
	$id_del_tag='7660';
	break;
	case *prepensionamento*:
	$id_del_tag='7672';
	break;
	case *pensione dello stato*:
	$id_del_tag='7672';
	break;
	case *pensione sociale*:
	$id_del_tag='7672';
	break;
	case *controversie previdenziali*:
	$id_del_tag='7672';
	break;
	case *contributi previdenziali e assicurativi*:
	$id_del_tag='7672';
	break;
	case *retribuzione pensionabile*:
	$id_del_tag='7672';
	break;
	case *trattamento previdenziale*:
	$id_del_tag='7672';
	break;
	case *pensione*:
	$id_del_tag='7672';
	break;
	case *cumulo tra pensione e retribuzione*:
	$id_del_tag='7672';
	break;
	case *cumulo tra pensione e sussidi*:
	$id_del_tag='7672';
	break;
	case *eta' pensionabile*:
	$id_del_tag='7672';
	break;
	case *collocamento a riposo*:
	$id_del_tag='7672';
	break;
	case *minimi di pensione*:
	$id_del_tag='7672';
	break;
	case *indicizzazione delle pensioni*:
	$id_del_tag='7672';
	break;
	case *integrazione al minimo delle pensioni*:
	$id_del_tag='7672';
	break;
	case *perequazione delle pensioni*:
	$id_del_tag='7672';
	break;
	case *riliquidazione di pensioni o indennita'*:
	$id_del_tag='7672';
	break;
	case *pensione integrativa*:
	$id_del_tag='7672';
	break;
	case *pensione privilegiata*:
	$id_del_tag='7672';
	break;
	case *pensione di reversibilita'*:
	$id_del_tag='7672';
	break;
	case *pensione di anzianita'*:
	$id_del_tag='7672';
	break;
	case *pensione complementare*:
	$id_del_tag='7672';
	break;
	case *cumulo delle pensioni*:
	$id_del_tag='7672';
	break;
	case *trasferimento di diritti a pensione*:
	$id_del_tag='7672';
	break;
	case *dottori commercialisti*:
	$id_del_tag='7702';
	break;
	case *patente di guida europea*:
	$id_del_tag='7726';
	break;
	case *organizzazioni senza scopo di lucro*:
	$id_del_tag='7734';
	break;
	case *organizzazioni non lucrative di utilit*:
	$id_del_tag='7734';
	break;
	case *ponti e viadotti*:
	$id_del_tag='7744';
	break;
	case *tunnel*:
	$id_del_tag='7744';
	break;
	case *superstrade*:
	$id_del_tag='7744';
	break;
	case *circolazione stradale*:
	$id_del_tag='7744';
	break;
	case *carta dei diritti dell'uomo*:
	$id_del_tag='4585';
	break;
	case *direttori didattici*:
	$id_del_tag='7751';
	break;
	case *presidi e vice presidi*:
	$id_del_tag='7751';
	break;
	case *pubblica sicurezza*:
	$id_del_tag='7791';
	break;
	case *sicurezza e sorveglianza*:
	$id_del_tag='7791';
	break;
	case *sicurezza*:
	$id_del_tag='7791';
	break;
	case *inps*:
	$id_del_tag='7890';
	break;
	case *industria della moda e dell'abbigliamento*:
	$id_del_tag='7977';
	break;
	case *abbigliamento*:
	$id_del_tag='7977';
	break;
	case *industria astronautica*:
	$id_del_tag='7982';
	break;
	case *agenzia spaziale italiana ( asi )*:
	$id_del_tag='7982';
	break;
	case *tutela della riservatezza*:
	$id_del_tag='6146';
	break;
	
	case *acqua pubblica*:
	$id_del_tag='1302';
	break;
	case *adozione di minori*:
	$id_del_tag='211';
	break;
	case *agenzia per la rappresentanza negoziale delle pubbliche amministrazioni (aran)*:
	$id_del_tag='6217';
	break;
	case *alberghi, pensioni ostelli*:
	$id_del_tag='1868';
	break;
	case *albi professionali*:
	$id_del_tag='1000';
	break;
	case *alghe*:
	$id_del_tag='6059';
	break;
	case *ambasciate*:
	$id_del_tag='6812';
	break;
	case *documento elettronico*:
	$id_del_tag='5236';
	break;
	case *specie protette*:
	$id_del_tag='4503';
	break;
	case *fauna*:
	$id_del_tag='5676';
	break;
	case *appalti pubblici e gare di appalto*:
	$id_del_tag='1334';
	break;
	case *apparecchi medici*:
	$id_del_tag='1064';
	break;
	case *interventi in aree depresse*:
	$id_del_tag='1564';
	break;
	case *armi atomiche*:
	$id_del_tag='780';
	break;
	case *armi*:
	$id_del_tag='779';
	break;
	case *opere d'arte*:
	$id_del_tag='5';
	break;
	case *artigiani*:
	$id_del_tag='9';
	break;
	case *associazione bancaria italiana ( abi )*:
	$id_del_tag='6086';
	break;
	case *associazione italiana della croce rossa ( cri )*:
	$id_del_tag='2167';
	break;
	case *associazione nazionale dei comuni italiani ( anci )*:
	$id_del_tag='6101';
	break;
	case *audiovisivi*:
	$id_del_tag='748';
	break;
	case *automobile club d' italia ( aci )*:
	$id_del_tag='2171';
	break;
	case *azienda nazionale autonoma delle strade statali ( anas )*:
	$id_del_tag='6188';
	break;
	case *imprese pubbliche*:
	$id_del_tag='1584';
	break;
	case *azioni*:
	$id_del_tag='1775';
	break;
	case *bar e ristoranti*:
	$id_del_tag='1884';
	break;
	case *biblioteche*:
	$id_del_tag='661';
	break;
	case *mercato finanziario*:
	$id_del_tag='1773';
	break;
	case *brevetti e modelli di utilita'*:
	$id_del_tag='264';
	break;
	case *disastri naturali*:
	$id_del_tag='4484';
	break;
	case *propaganda elettorale*:
	$id_del_tag='532';
	break;
	case *carceri*:
	$id_del_tag='487';
	break;
	case *lavoratori e collaboratori domestici*:
	$id_del_tag='1013';
	break;
	case *case da gioco*:
	$id_del_tag='13';
	break;
	case *basi militari*:
	$id_del_tag='52';
	break;
	case *chiesa cattolica*:
	$id_del_tag='1519';
	break;
	case *clientele*:
	$id_del_tag='5272';
	break;
	case *comitato interministeriale per il credito e il risparmio (cicr)*:
	$id_del_tag='7070';
	break;
	case *comitato interministeriale per la programmazione economica ( cipe )*:
	$id_del_tag='6369';
	break;
	case *comitato olimpico nazionale italiano (coni)*:
	$id_del_tag='2188';
	break;
	case *commerciaslisti*:
	$id_del_tag='7702';
	break;
	case *commercio*:
	$id_del_tag='1535';
	break;
	case *commissione nazionale per le societa' e la borsa ( consob )*:
	$id_del_tag='2190';
	break;
	case *compagnia aerea italiana spa ( cai )*:
	$id_del_tag='6216';
	break;
	case *uffici per le relazioni con il pubblico*:
	$id_del_tag='139';
	break;
	case *servizi pubblici in concessione*:
	$id_del_tag='1409';
	break;
	case *concessioni*:
	$id_del_tag='1394';
	break;
	case *concorrenza*:
	$id_del_tag='1546';
	break;
	case *consigli e assemblee regionali*:
	$id_del_tag='7657';
	break;
	case *consiglio d' europa*:
	$id_del_tag='2195';
	break;
	case *consiglio nazionale delle ricerche (cnr)*:
	$id_del_tag='6363';
	break;
	case *consorzi di enti locali*:
	$id_del_tag='1424';
	break;
	case *consorzi*:
	$id_del_tag='1574';
	break;
	case *contraccezione*:
	$id_del_tag='1673';
	break;
	case *contraccezione*:
	$id_del_tag='1673';
	break;
	case *aiuti allo sviluppo*:
	$id_del_tag='4653';
	break;
	case *cooperazione economica*:
	$id_del_tag='1560';
	break;
	case *corpo forestale dello stato ( cfs )*:
	$id_del_tag='6199';
	break;
	case *corruzione*:
	$id_del_tag='5829';
	break;
	case *corte penale internazionale ( cpi )*:
	$id_del_tag='2336';
	break;
	case *corte di appello*:
	$id_del_tag='1210';
	break;
	case *litorale*:
	$id_del_tag='4729';
	break;
	case *culture popolari*:
	$id_del_tag='6834';
	break;
	case *cure termali, balneari e idropiniche*:
	$id_del_tag='0';
	break;
	case *decentramento*:
	$id_del_tag='550';
	break;
	case *demanio*:
	$id_del_tag='1338';
	break;
	case *dentisti*:
	$id_del_tag='4331';
	break;
	case *didattica*:
	$id_del_tag='7366';
	break;
	case *direzione investigativa antimafia ( dia )*:
	$id_del_tag='2206';
	break;
	case *direzione nazionale antimafia ( dna )*:
	$id_del_tag='2207';
	break;
	case *procedimento amministrativo*:
	$id_del_tag='1372';
	break;
	case *diritto d'asilo*:
	$id_del_tag='4871';
	break;
	case *regolamenti parlamentari*:
	$id_del_tag='4264';
	break;
	case *diritto e procedura penale militare*:
	$id_del_tag='5208';
	break;
	case *diritto costituzionale*:
	$id_del_tag='6009';
	break;
	case *invalidi civili*:
	$id_del_tag='1716';
	break;
	case *scarichi e discariche*:
	$id_del_tag='814';
	break;
	case *divorzio*:
	$id_del_tag='222';
	break;
	case *documento di programmazione economico finanziaria*:
	$id_del_tag='6096';
	break;
	case *economia pubblica*:
	$id_del_tag='4618';
	break;
	case *gas a effetto serra*:
	$id_del_tag='4412';
	break;
	case *elezioni regionali*:
	$id_del_tag='1603';
	break;
	case *ente nazionale assistenza al volo ( enav )*:
	$id_del_tag='6299';
	break;
	case *ente nazionale energia elettrica ( enel )*:
	$id_del_tag='6213';
	break;
	case *ente nazionale idrocarburi ( eni )*:
	$id_del_tag='7351';
	break;
	case *ente per le nuove tecnologie l'energia e l' ambiente ( enea )*:
	$id_del_tag='8016';
	break;
	case *ente per le nuove tecnologie l'energia e l' ambiente ( enea )*:
	$id_del_tag='2210';
	break;
	case *enti pubblici economici*:
	$id_del_tag='1585';
	break;
	case *esercito*:
	$id_del_tag='57';
	break;
	case *evasione fiscale*:
	$id_del_tag='4542';
	break;
	case *fecondazione artificiale*:
	$id_del_tag='1111';
	break;
	case *festivita' e solennita' civili*:
	$id_del_tag='1911';
	break;
	case *fiere*:
	$id_del_tag='4288';
	break;
	case *finanziamenti comunitari*:
	$id_del_tag='4740';
	break;
	case *finanziamenti ai partiti politici*:
	$id_del_tag='1623';
	break;
	case *testamento biologico*:
	$id_del_tag='7403';
	break;
	case *fiumi e torrenti*:
	$id_del_tag='1662';
	break;
	case *fondo monetario internazionale ( fmi )*:
	$id_del_tag='7398';
	break;
	case *decreti legge*:
	$id_del_tag='116';
	break;
	case *furto*:
	$id_del_tag='373';
	break;
	case *giornali e quotidiani*:
	$id_del_tag='673';
	break;
	case *diritto alla giustizia*:
	$id_del_tag='5351';
	break;
	case *tribunale per i minorenni*:
	$id_del_tag='235';
	break;
	case *supermercati e grandi magazzini*:
	$id_del_tag='1541';
	break;
	case *gravidanza e puerperio*:
	$id_del_tag='1093';
	break;
	case *gruppo degli otto paesi piu' industrializzati ( g8 )*:
	$id_del_tag='2322';
	break;
	case *guerra*:
	$id_del_tag='296';
	break;
	case *centri di identificazione ed espulsione ( cie )*:
	$id_del_tag='4279';
	break;
	case *imposte e tributi comunali*:
	$id_del_tag='611';
	break;
	case *imposte e tributi regionali*:
	$id_del_tag='7887';
	break;
	case *imprese agricole*:
	$id_del_tag='1277';
	break;
	case *incompatibilita' alle cariche elettive amministrative e di governo*:
	$id_del_tag='541';
	break;
	case *industria meccanica*:
	$id_del_tag='5108';
	break;
	case *personale infermieristico*:
	$id_del_tag='5813';
	break;
	case *lavoratori invalidi e vittime del lavoro*:
	$id_del_tag='1707';
	break;
	case *procedura ce d'infrazione*:
	$id_del_tag='5586';
	break;
	case *inquinamento marino*:
	$id_del_tag='5370';
	break;
	case *insegnanti*:
	$id_del_tag='911';
	break;
	case *integrazione sociale*:
	$id_del_tag='4481';
	break;
	case *intercettazioni telefoniche*:
	$id_del_tag='840';
	break;
	case *interpellanza*:
	$id_del_tag='5550';
	break;
	case *ispettorato del lavoro*:
	$id_del_tag='5037';
	break;
	case *istituti autonomi per le case popolari ( iacp )*:
	$id_del_tag='2230';
	break;
	case *istituti  casse ed enti mutualistici e previdenziali*:
	$id_del_tag='1760';
	break;
	case *lavoro autonomo*:
	$id_del_tag='5389';
	break;
	case *precarietã *:
	$id_del_tag='7469';
	break;
	case *lavoro atipico*:
	$id_del_tag='1010';
	break;
	case *sistemi elettorali*:
	$id_del_tag='547';
	break;
	case *libera circolazione nel mercato*:
	$id_del_tag='1552';
	break;
	case *riunioni in luogo pubblico*:
	$id_del_tag='1311';
	break;
	case *diritti e liberta' della persona*:
	$id_del_tag='5186';
	break;
	case *lingue*:
	$id_del_tag='1056';
	break;
	case *concorsi, operazioni a premio scommesse e lotterie*:
	$id_del_tag='580';
	break;
	case *mafia e camorra*:
	$id_del_tag='4434';
	break;
	case *malattie*:
	$id_del_tag='1118';
	break;
	case *vicino e medio oriente*:
	$id_del_tag='7453';
	break;
	case *mass media locali*:
	$id_del_tag='5943';
	break;
	case *militanti politici*:
	$id_del_tag='7086';
	break;
	case *ministero del lavoro della salute e delle politiche sociali*:
	$id_del_tag='7457';
	break;
	case *ministero dell' interno*:
	$id_del_tag='2253';
	break;
	case *minoranza nazionale*:
	$id_del_tag='4560';
	break;
	case *missioni internazionali di pace*:
	$id_del_tag='317';
	break;
	case *industria della moda*:
	$id_del_tag='7977';
	break;
	case *monopolio di stato*:
	$id_del_tag='5757';
	break;
	case *monopolio*:
	$id_del_tag='1553';
	break;
	case *movimento giovanile*:
	$id_del_tag='6386';
	break;
	case *mozione di sfiducia*:
	$id_del_tag='0';
	break;
	case *mutui e prestiti*:
	$id_del_tag='174';
	break;
	case *navigazione e nautica da diporto*:
	$id_del_tag='271';
	break;
	case *nazionalismo*:
	$id_del_tag='5309';
	break;
	case *ndrangheta*:
	$id_del_tag='7374';
	break;
	case *nomine in enti*:
	$id_del_tag='1507';
	break;
	case *organizzazione delle n.u. per l'educazione la scienza e la cultura (unesco)*:
	$id_del_tag='5471';
	break;
	case *onlus*:
	$id_del_tag='7734';
	break;
	case *tracciabilita'*:
	$id_del_tag='6671';
	break;
	case *ospedali, cliniche e case di cura*:
	$id_del_tag='1877';
	break;
	case *parlamento e governo*:
	$id_del_tag='1618';
	break;
	case *partiti politici*:
	$id_del_tag='1622';
	break;
	case *patente*:
	$id_del_tag='7726';
	break;
	case *patrimonio culturale*:
	$id_del_tag='4865';
	break;
	case *patto di stabilita' e di crescita (psc)*:
	$id_del_tag='7655';
	break;
	case *pesca e pescicoltura*:
	$id_del_tag='1288';
	break;
	case *pesce*:
	$id_del_tag='5336';
	break;
	case *materie plastiche*:
	$id_del_tag='738';
	break;
	case *politica estera e di sicurezza comune ( pesc )*:
	$id_del_tag='6751';
	break;
	case *politica occupazionale*:
	$id_del_tag='4936';
	break;
	case *politica sociale*:
	$id_del_tag='5709';
	break;
	case *polizia postale*:
	$id_del_tag='7757';
	break;
	case *stretto di messina spa*:
	$id_del_tag='2346';
	break;
	case *poverta'*:
	$id_del_tag='6019';
	break;
	case *presidente dicommissione parlamentare*:
	$id_del_tag='5548';
	break;
	case *presidente della giunta regionale*:
	$id_del_tag='1454';
	break;
	case *pensioni*:
	$id_del_tag='7672';
	break;
	case *prezzi al consumo*:
	$id_del_tag='5162';
	break;
	case *procura della repubblica*:
	$id_del_tag='7188';
	break;
	case *pronto soccorso*:
	$id_del_tag='1112';
	break;
	case *provincia l'aquila*:
	$id_del_tag='4913';
	break;
	case *psichiatri*:
	$id_del_tag='1143';
	break;
	case *psicoterapia*:
	$id_del_tag='1079';
	break;
	case *repubblica*:
	$id_del_tag='6838';
	break;
	case *rifiuti e materiale di scarto*:
	$id_del_tag='813';
	break;
	case *riforme amministrative*:
	$id_del_tag='6676';
	break;
	case *riforma gelmini (istruzione e universitã )*:
	$id_del_tag='2425';
	break;
	case *revisione della costituzione*:
	$id_del_tag='505';
	break;
	case *risarcimento di danni*:
	$id_del_tag='238';
	break;
	case *risorse naturali*:
	$id_del_tag='5569';
	break;
	case *risparmio*:
	$id_del_tag='1783';
	break;
	case *protezione della salute*:
	$id_del_tag='516';
	break;
	case *sangue e plasma umano*:
	$id_del_tag='1090';
	break;
	case *scuola materna*:
	$id_del_tag='896';
	break;
	case *scuola primaria*:
	$id_del_tag='2368';
	break;
	case *istruzione pubblica*:
	$id_del_tag='5167';
	break;
	case *scuola secondaria di primo grado*:
	$id_del_tag='898';
	break;
	case *scuola secondaria di secondo grado*:
	$id_del_tag='902';
	break;
	case *scuole private*:
	$id_del_tag='857';
	break;
	case *semplificazione legislativa*:
	$id_del_tag='4703';
	break;
	case *sequestro di beni*:
	$id_del_tag='5382';
	break;
	case *servizio militare volontario*:
	$id_del_tag='90';
	break;
	case *sesso delle persone e sessualita'*:
	$id_del_tag='1089';
	break;
	case *sicurezza marittima*:
	$id_del_tag='5178';
	break;
	case *sicurezza dei trasporti ferroviari*:
	$id_del_tag='5689';
	break;
	case *sindacati*:
	$id_del_tag='1002';
	break;
	case *sordomuti*:
	$id_del_tag='1713';
	break;
	case *capitali speculativi*:
	$id_del_tag='5929';
	break;
	case *bilancio per la ricerca*:
	$id_del_tag='4832';
	break;
	case *stragi*:
	$id_del_tag='395';
	break;
	case *tabacco, sigarette, prodotti da fumo*:
	$id_del_tag='1273';
	break;
	case *tasse di concessione*:
	$id_del_tag='626';
	break;
	case *teatri*:
	$id_del_tag='1887';
	break;
	case *nuove tecnologie*:
	$id_del_tag='4702';
	break;
	case *emittenti radiotelevisive private ed estere*:
	$id_del_tag='832';
	break;
	case *diplomi e titoli di studio*:
	$id_del_tag='919';
	break;
	case *tossicodipendenti*:
	$id_del_tag='1103';
	break;
	case *diritto di accesso*:
	$id_del_tag='517';
	break;
	case *trasporti regionali*:
	$id_del_tag='5799';
	break;
	case *trattamento di fine rapporto*:
	$id_del_tag='1037';
	break;
	case *trattato dell'unione europea*:
	$id_del_tag='1854';
	break;
	case *tribunali amministrativi regionali*:
	$id_del_tag='1213';
	break;
	case *truffe*:
	$id_del_tag='376';
	break;
	case *eguaglianza*:
	$id_del_tag='518';
	break;
	case *unione italiana delle camere di commercio, industria, agricoltura e artigianato (unioncamere)*:
	$id_del_tag='6090';
	break;
	case *unione nazionale dei comuni, comunita' ed enti della montagna (uncem)*:
	$id_del_tag='6103';
	break;
	case *unione politica europea*:
	$id_del_tag='6535';
	break;
	case *sieri e vaccini*:
	$id_del_tag='1128';
	break;
	case *impatto ambientale*:
	$id_del_tag='4413';
	break;
	case *violenza*:
	$id_del_tag='4319';
	break;
	case *vulcano etna*:
	$id_del_tag='7775';
	break;
	case *agliè*:
	$id_del_tag='8370';
	break;
	case *airasca*:
	$id_del_tag='8371';
	break;
	case *ala di stura*:
	$id_del_tag='8372';
	break;
	case *albiano d'ivrea*:
	$id_del_tag='8373';
	break;
	case *alice superiore*:
	$id_del_tag='8374';
	break;
	case *almese*:
	$id_del_tag='8375';
	break;
	case *alpette*:
	$id_del_tag='8376';
	break;
	case *alpignano*:
	$id_del_tag='8377';
	break;
	case *andezeno*:
	$id_del_tag='8378';
	break;
	case *andrate*:
	$id_del_tag='8379';
	break;
	case *angrogna*:
	$id_del_tag='8380';
	break;
	case *arignano*:
	$id_del_tag='8381';
	break;
	case *azeglio*:
	$id_del_tag='8382';
	break;
	case *bairo*:
	$id_del_tag='8383';
	break;
	case *balangero*:
	$id_del_tag='8384';
	break;
	case *baldissero canavese*:
	$id_del_tag='8385';
	break;
	case *baldissero torinese*:
	$id_del_tag='8386';
	break;
	case *balme*:
	$id_del_tag='8387';
	break;
	case *banchette*:
	$id_del_tag='8388';
	break;
	case *barbania*:
	$id_del_tag='8389';
	break;
	case *bardonecchia*:
	$id_del_tag='8390';
	break;
	case *barone canavese*:
	$id_del_tag='8391';
	break;
	case *beinasco*:
	$id_del_tag='8392';
	break;
	case *bibiana*:
	$id_del_tag='8393';
	break;
	case *bobbio pellice*:
	$id_del_tag='8394';
	break;
	case *bollengo*:
	$id_del_tag='8395';
	break;
	case *borgaro torinese*:
	$id_del_tag='8396';
	break;
	case *borgiallo*:
	$id_del_tag='8397';
	break;
	case *borgofranco d'ivrea*:
	$id_del_tag='8398';
	break;
	case *borgomasino*:
	$id_del_tag='8399';
	break;
	case *borgone susa*:
	$id_del_tag='8400';
	break;
	case *bosconero*:
	$id_del_tag='8401';
	break;
	case *brandizzo*:
	$id_del_tag='8402';
	break;
	case *bricherasio*:
	$id_del_tag='8403';
	break;
	case *brosso*:
	$id_del_tag='8404';
	break;
	case *brozolo*:
	$id_del_tag='8405';
	break;
	case *bruino*:
	$id_del_tag='8406';
	break;
	case *brusasco*:
	$id_del_tag='8407';
	break;
	case *bruzolo*:
	$id_del_tag='8408';
	break;
	case *buriasco*:
	$id_del_tag='8409';
	break;
	case *burolo*:
	$id_del_tag='8410';
	break;
	case *busano*:
	$id_del_tag='8411';
	break;
	case *bussoleno*:
	$id_del_tag='8412';
	break;
	case *buttigliera alta*:
	$id_del_tag='8413';
	break;
	case *cafasse*:
	$id_del_tag='8414';
	break;
	case *caluso*:
	$id_del_tag='8415';
	break;
	case *cambiano*:
	$id_del_tag='8416';
	break;
	case *campiglione-fenile*:
	$id_del_tag='8417';
	break;
	case *candia canavese*:
	$id_del_tag='8418';
	break;
	case *candiolo*:
	$id_del_tag='8419';
	break;
	case *canischio*:
	$id_del_tag='8420';
	break;
	case *cantalupa*:
	$id_del_tag='8421';
	break;
	case *cantoira*:
	$id_del_tag='8422';
	break;
	case *caprie*:
	$id_del_tag='8423';
	break;
	case *caravino*:
	$id_del_tag='8424';
	break;
	case *carignano*:
	$id_del_tag='8425';
	break;
	case *carmagnola*:
	$id_del_tag='8426';
	break;
	case *casalborgone*:
	$id_del_tag='8427';
	break;
	case *cascinette d'ivrea*:
	$id_del_tag='8428';
	break;
	case *caselette*:
	$id_del_tag='8429';
	break;
	case *caselle torinese*:
	$id_del_tag='8430';
	break;
	case *castagneto po*:
	$id_del_tag='8431';
	break;
	case *castagnole piemonte*:
	$id_del_tag='8432';
	break;
	case *castellamonte*:
	$id_del_tag='8433';
	break;
	case *castelnuovo nigra*:
	$id_del_tag='8434';
	break;
	case *castiglione torinese*:
	$id_del_tag='8435';
	break;
	case *cavagnolo*:
	$id_del_tag='8436';
	break;
	case *cavour*:
	$id_del_tag='8437';
	break;
	case *cercenasco*:
	$id_del_tag='8438';
	break;
	case *ceres*:
	$id_del_tag='8439';
	break;
	case *ceresole reale*:
	$id_del_tag='8440';
	break;
	case *cesana torinese*:
	$id_del_tag='8441';
	break;
	case *chialamberto*:
	$id_del_tag='8442';
	break;
	case *chianocco*:
	$id_del_tag='8443';
	break;
	case *chiaverano*:
	$id_del_tag='8444';
	break;
	case *chieri*:
	$id_del_tag='8445';
	break;
	case *chiesanuova*:
	$id_del_tag='8446';
	break;
	case *chiomonte*:
	$id_del_tag='8447';
	break;
	case *chiusa di san michele*:
	$id_del_tag='8448';
	break;
	case *ciconio*:
	$id_del_tag='8449';
	break;
	case *cintano*:
	$id_del_tag='8450';
	break;
	case *cinzano*:
	$id_del_tag='8451';
	break;
	case *ciriè*:
	$id_del_tag='8452';
	break;
	case *claviere*:
	$id_del_tag='8453';
	break;
	case *coassolo torinese*:
	$id_del_tag='8454';
	break;
	case *coazze*:
	$id_del_tag='8455';
	break;
	case *collegno*:
	$id_del_tag='8456';
	break;
	case *colleretto castelnuovo*:
	$id_del_tag='8457';
	break;
	case *colleretto giacosa*:
	$id_del_tag='8458';
	break;
	case *condove*:
	$id_del_tag='8459';
	break;
	case *corio*:
	$id_del_tag='8460';
	break;
	case *cossano canavese*:
	$id_del_tag='8461';
	break;
	case *cuceglio*:
	$id_del_tag='8462';
	break;
	case *cumiana*:
	$id_del_tag='8463';
	break;
	case *cuorgnè*:
	$id_del_tag='8464';
	break;
	case *druento*:
	$id_del_tag='8465';
	break;
	case *exilles*:
	$id_del_tag='8466';
	break;
	case *favria*:
	$id_del_tag='8467';
	break;
	case *feletto*:
	$id_del_tag='8468';
	break;
	case *fenestrelle*:
	$id_del_tag='8469';
	break;
	case *fiano*:
	$id_del_tag='8470';
	break;
	case *fiorano canavese*:
	$id_del_tag='8471';
	break;
	case *foglizzo*:
	$id_del_tag='8472';
	break;
	case *forno canavese*:
	$id_del_tag='8473';
	break;
	case *frassinetto*:
	$id_del_tag='8474';
	break;
	case *front*:
	$id_del_tag='8475';
	break;
	case *garzigliana*:
	$id_del_tag='8476';
	break;
	case *gassino torinese*:
	$id_del_tag='8477';
	break;
	case *germagnano*:
	$id_del_tag='8478';
	break;
	case *giaglione*:
	$id_del_tag='8479';
	break;
	case *giaveno*:
	$id_del_tag='8480';
	break;
	case *givoletto*:
	$id_del_tag='8481';
	break;
	case *gravere*:
	$id_del_tag='8482';
	break;
	case *groscavallo*:
	$id_del_tag='8483';
	break;
	case *grosso*:
	$id_del_tag='8484';
	break;
	case *grugliasco*:
	$id_del_tag='8485';
	break;
	case *ingria*:
	$id_del_tag='8486';
	break;
	case *inverso pinasca*:
	$id_del_tag='8487';
	break;
	case *isolabella*:
	$id_del_tag='8488';
	break;
	case *issiglio*:
	$id_del_tag='8489';
	break;
	case *la cassa*:
	$id_del_tag='8490';
	break;
	case *la loggia*:
	$id_del_tag='8491';
	break;
	case *lanzo torinese*:
	$id_del_tag='8492';
	break;
	case *lauriano*:
	$id_del_tag='8493';
	break;
	case *leinì*:
	$id_del_tag='8494';
	break;
	case *lemie*:
	$id_del_tag='8495';
	break;
	case *lessolo*:
	$id_del_tag='8496';
	break;
	case *levone*:
	$id_del_tag='8497';
	break;
	case *locana*:
	$id_del_tag='8498';
	break;
	case *lombardore*:
	$id_del_tag='8499';
	break;
	case *lombriasco*:
	$id_del_tag='8500';
	break;
	case *loranzè*:
	$id_del_tag='8501';
	break;
	case *lugnacco*:
	$id_del_tag='8502';
	break;
	case *luserna san giovanni*:
	$id_del_tag='8503';
	break;
	case *lusernetta*:
	$id_del_tag='8504';
	break;
	case *lusigliè*:
	$id_del_tag='8505';
	break;
	case *macello*:
	$id_del_tag='8506';
	break;
	case *maglione*:
	$id_del_tag='8507';
	break;
	case *marentino*:
	$id_del_tag='8508';
	break;
	case *massello*:
	$id_del_tag='8509';
	break;
	case *mathi*:
	$id_del_tag='8510';
	break;
	case *mattie*:
	$id_del_tag='8511';
	break;
	case *mazzè*:
	$id_del_tag='8512';
	break;
	case *meana di susa*:
	$id_del_tag='8513';
	break;
	case *mercenasco*:
	$id_del_tag='8514';
	break;
	case *meugliano*:
	$id_del_tag='8515';
	break;
	case *mezzenile*:
	$id_del_tag='8516';
	break;
	case *mombello di torino*:
	$id_del_tag='8517';
	break;
	case *mompantero*:
	$id_del_tag='8518';
	break;
	case *monastero di lanzo*:
	$id_del_tag='8519';
	break;
	case *moncalieri*:
	$id_del_tag='8520';
	break;
	case *moncenisio*:
	$id_del_tag='8521';
	break;
	case *montaldo torinese*:
	$id_del_tag='8522';
	break;
	case *montalenghe*:
	$id_del_tag='8523';
	break;
	case *montalto dora*:
	$id_del_tag='8524';
	break;
	case *montanaro*:
	$id_del_tag='8525';
	break;
	case *monteu da po*:
	$id_del_tag='8526';
	break;
	case *moriondo torinese*:
	$id_del_tag='8527';
	break;
	case *nichelino*:
	$id_del_tag='8528';
	break;
	case *nole*:
	$id_del_tag='8529';
	break;
	case *nomaglio*:
	$id_del_tag='8530';
	break;
	case *none*:
	$id_del_tag='8531';
	break;
	case *novalesa*:
	$id_del_tag='8532';
	break;
	case *oglianico*:
	$id_del_tag='8533';
	break;
	case *orbassano*:
	$id_del_tag='8534';
	break;
	case *orio canavese*:
	$id_del_tag='8535';
	break;
	case *osasco*:
	$id_del_tag='8536';
	break;
	case *osasio*:
	$id_del_tag='8537';
	break;
	case *oulx*:
	$id_del_tag='8538';
	break;
	case *ozegna*:
	$id_del_tag='8539';
	break;
	case *palazzo canavese*:
	$id_del_tag='8540';
	break;
	case *pancalieri*:
	$id_del_tag='8541';
	break;
	case *parella*:
	$id_del_tag='8542';
	break;
	case *pavarolo*:
	$id_del_tag='8543';
	break;
	case *pavone canavese*:
	$id_del_tag='8544';
	break;
	case *pecco*:
	$id_del_tag='8545';
	break;
	case *pecetto torinese*:
	$id_del_tag='8546';
	break;
	case *perosa argentina*:
	$id_del_tag='8547';
	break;
	case *perosa canavese*:
	$id_del_tag='8548';
	break;
	case *perrero*:
	$id_del_tag='8549';
	break;
	case *pertusio*:
	$id_del_tag='8550';
	break;
	case *pessinetto*:
	$id_del_tag='8551';
	break;
	case *pianezza*:
	$id_del_tag='8552';
	break;
	case *pinasca*:
	$id_del_tag='8553';
	break;
	case *pino torinese*:
	$id_del_tag='8554';
	break;
	case *piobesi torinese*:
	$id_del_tag='8555';
	break;
	case *piossasco*:
	$id_del_tag='8556';
	break;
	case *piscina*:
	$id_del_tag='8557';
	break;
	case *piverone*:
	$id_del_tag='8558';
	break;
	case *poirino*:
	$id_del_tag='8559';
	break;
	case *pomaretto*:
	$id_del_tag='8560';
	break;
	case *pont-canavese*:
	$id_del_tag='8561';
	break;
	case *porte*:
	$id_del_tag='8562';
	break;
	case *pragelato*:
	$id_del_tag='8563';
	break;
	case *prali*:
	$id_del_tag='8564';
	break;
	case *pralormo*:
	$id_del_tag='8565';
	break;
	case *pramollo*:
	$id_del_tag='8566';
	break;
	case *prarostino*:
	$id_del_tag='8567';
	break;
	case *prascorsano*:
	$id_del_tag='8568';
	break;
	case *pratiglione*:
	$id_del_tag='8569';
	break;
	case *quagliuzzo*:
	$id_del_tag='8570';
	break;
	case *quassolo*:
	$id_del_tag='8571';
	break;
	case *quincinetto*:
	$id_del_tag='8572';
	break;
	case *reano*:
	$id_del_tag='8573';
	break;
	case *ribordone*:
	$id_del_tag='8574';
	break;
	case *riva presso chieri*:
	$id_del_tag='8575';
	break;
	case *rivalba*:
	$id_del_tag='8576';
	break;
	case *rivalta di torino*:
	$id_del_tag='8577';
	break;
	case *rivarossa*:
	$id_del_tag='8578';
	break;
	case *robassomero*:
	$id_del_tag='8579';
	break;
	case *rocca canavese*:
	$id_del_tag='8580';
	break;
	case *roletto*:
	$id_del_tag='8581';
	break;
	case *romano canavese*:
	$id_del_tag='8582';
	break;
	case *ronco canavese*:
	$id_del_tag='8583';
	break;
	case *rondissone*:
	$id_del_tag='8584';
	break;
	case *rorà*:
	$id_del_tag='8585';
	break;
	case *rosta*:
	$id_del_tag='8586';
	break;
	case *roure*:
	$id_del_tag='8587';
	break;
	case *rubiana*:
	$id_del_tag='8588';
	break;
	case *rueglio*:
	$id_del_tag='8589';
	break;
	case *salassa*:
	$id_del_tag='8590';
	break;
	case *salbertrand*:
	$id_del_tag='8591';
	break;
	case *salerano canavese*:
	$id_del_tag='8592';
	break;
	case *salza di pinerolo*:
	$id_del_tag='8593';
	break;
	case *samone*:
	$id_del_tag='8594';
	break;
	case *san benigno canavese*:
	$id_del_tag='8595';
	break;
	case *san carlo canavese*:
	$id_del_tag='8596';
	break;
	case *san colombano belmonte*:
	$id_del_tag='8597';
	break;
	case *san didero*:
	$id_del_tag='8598';
	break;
	case *san francesco al campo*:
	$id_del_tag='8599';
	break;
	case *san germano chisone*:
	$id_del_tag='8600';
	break;
	case *san gillio*:
	$id_del_tag='8601';
	break;
	case *san giorgio canavese*:
	$id_del_tag='8602';
	break;
	case *san giorio di susa*:
	$id_del_tag='8603';
	break;
	case *san giusto canavese*:
	$id_del_tag='8604';
	break;
	case *san martino canavese*:
	$id_del_tag='8605';
	break;
	case *san maurizio canavese*:
	$id_del_tag='8606';
	break;
	case *san mauro torinese*:
	$id_del_tag='8607';
	break;
	case *san pietro val lemina*:
	$id_del_tag='8608';
	break;
	case *san ponso*:
	$id_del_tag='8609';
	break;
	case *san raffaele cimena*:
	$id_del_tag='8610';
	break;
	case *san sebastiano da po*:
	$id_del_tag='8611';
	break;
	case *san secondo di pinerolo*:
	$id_del_tag='8612';
	break;
	case *sangano*:
	$id_del_tag='8613';
	break;
	case *sant'ambrogio di torino*:
	$id_del_tag='8614';
	break;
	case *sant'antonino di susa*:
	$id_del_tag='8615';
	break;
	case *santena*:
	$id_del_tag='8616';
	break;
	case *sauze di cesana*:
	$id_del_tag='8617';
	break;
	case *sauze d'oulx*:
	$id_del_tag='8618';
	break;
	case *scalenghe*:
	$id_del_tag='8619';
	break;
	case *scarmagno*:
	$id_del_tag='8620';
	break;
	case *sciolze*:
	$id_del_tag='8621';
	break;
	case *sestriere*:
	$id_del_tag='8622';
	break;
	case *settimo rottaro*:
	$id_del_tag='8623';
	break;
	case *settimo torinese*:
	$id_del_tag='8624';
	break;
	case *settimo vittone*:
	$id_del_tag='8625';
	break;
	case *sparone*:
	$id_del_tag='8626';
	break;
	case *strambinello*:
	$id_del_tag='8627';
	break;
	case *strambino*:
	$id_del_tag='8628';
	break;
	case *susa*:
	$id_del_tag='8629';
	break;
	case *tavagnasco*:
	$id_del_tag='8630';
	break;
	case *torrazza piemonte*:
	$id_del_tag='8631';
	break;
	case *torre canavese*:
	$id_del_tag='8632';
	break;
	case *torre pellice*:
	$id_del_tag='8633';
	break;
	case *trana*:
	$id_del_tag='8634';
	break;
	case *trausella*:
	$id_del_tag='8635';
	break;
	case *traversella*:
	$id_del_tag='8636';
	break;
	case *traves*:
	$id_del_tag='8637';
	break;
	case *trofarello*:
	$id_del_tag='8638';
	break;
	case *usseaux*:
	$id_del_tag='8639';
	break;
	case *usseglio*:
	$id_del_tag='8640';
	break;
	case *vaie*:
	$id_del_tag='8641';
	break;
	case *val della torre*:
	$id_del_tag='8642';
	break;
	case *valgioie*:
	$id_del_tag='8643';
	break;
	case *vallo torinese*:
	$id_del_tag='8644';
	break;
	case *valperga*:
	$id_del_tag='8645';
	break;
	case *valprato soana*:
	$id_del_tag='8646';
	break;
	case *varisella*:
	$id_del_tag='8647';
	break;
	case *vauda canavese*:
	$id_del_tag='8648';
	break;
	case *venaria reale*:
	$id_del_tag='8649';
	break;
	case *venaus*:
	$id_del_tag='8650';
	break;
	case *verolengo*:
	$id_del_tag='8651';
	break;
	case *verrua savoia*:
	$id_del_tag='8652';
	break;
	case *vestignè*:
	$id_del_tag='8653';
	break;
	case *vialfrè*:
	$id_del_tag='8654';
	break;
	case *vico canavese*:
	$id_del_tag='8655';
	break;
	case *vidracco*:
	$id_del_tag='8656';
	break;
	case *vigone*:
	$id_del_tag='8657';
	break;
	case *villafranca piemonte*:
	$id_del_tag='8658';
	break;
	case *villanova canavese*:
	$id_del_tag='8659';
	break;
	case *villar dora*:
	$id_del_tag='8660';
	break;
	case *villar focchiardo*:
	$id_del_tag='8661';
	break;
	case *villar pellice*:
	$id_del_tag='8662';
	break;
	case *villar perosa*:
	$id_del_tag='8663';
	break;
	case *villarbasse*:
	$id_del_tag='8664';
	break;
	case *villareggia*:
	$id_del_tag='8665';
	break;
	case *villastellone*:
	$id_del_tag='8666';
	break;
	case *vinovo*:
	$id_del_tag='8667';
	break;
	case *virle piemonte*:
	$id_del_tag='8668';
	break;
	case *vische*:
	$id_del_tag='8669';
	break;
	case *vistrorio*:
	$id_del_tag='8670';
	break;
	case *viù*:
	$id_del_tag='8671';
	break;
	case *volpiano*:
	$id_del_tag='8672';
	break;
	case *volvera*:
	$id_del_tag='8673';
	break;
	case *alagna valsesia*:
	$id_del_tag='8674';
	break;
	case *albano vercellese*:
	$id_del_tag='8675';
	break;
	case *alice castello*:
	$id_del_tag='8676';
	break;
	case *arborio*:
	$id_del_tag='8677';
	break;
	case *asigliano vercellese*:
	$id_del_tag='8678';
	break;
	case *balmuccia*:
	$id_del_tag='8679';
	break;
	case *balocco*:
	$id_del_tag='8680';
	break;
	case *bianzè*:
	$id_del_tag='8681';
	break;
	case *boccioleto*:
	$id_del_tag='8682';
	break;
	case *borgo d'ale*:
	$id_del_tag='8683';
	break;
	case *borgo vercelli*:
	$id_del_tag='8684';
	break;
	case *borgosesia*:
	$id_del_tag='8685';
	break;
	case *breia*:
	$id_del_tag='8686';
	break;
	case *buronzo*:
	$id_del_tag='8687';
	break;
	case *campertogno*:
	$id_del_tag='8688';
	break;
	case *carcoforo*:
	$id_del_tag='8689';
	break;
	case *caresana*:
	$id_del_tag='8690';
	break;
	case *caresanablot*:
	$id_del_tag='8691';
	break;
	case *carisio*:
	$id_del_tag='8692';
	break;
	case *casanova elvo*:
	$id_del_tag='8693';
	break;
	case *cellio*:
	$id_del_tag='8694';
	break;
	case *cervatto*:
	$id_del_tag='8695';
	break;
	case *civiasco*:
	$id_del_tag='8696';
	break;
	case *collobiano*:
	$id_del_tag='8697';
	break;
	case *costanzana*:
	$id_del_tag='8698';
	break;
	case *cravagliana*:
	$id_del_tag='8699';
	break;
	case *crescentino*:
	$id_del_tag='8700';
	break;
	case *crova*:
	$id_del_tag='8701';
	break;
	case *desana*:
	$id_del_tag='8702';
	break;
	case *fobello*:
	$id_del_tag='8703';
	break;
	case *fontanetto po*:
	$id_del_tag='8704';
	break;
	case *formigliana*:
	$id_del_tag='8705';
	break;
	case *gattinara*:
	$id_del_tag='8706';
	break;
	case *ghislarengo*:
	$id_del_tag='8707';
	break;
	case *greggio*:
	$id_del_tag='8708';
	break;
	case *guardabosone*:
	$id_del_tag='8709';
	break;
	case *lamporo*:
	$id_del_tag='8710';
	break;
	case *lenta*:
	$id_del_tag='8711';
	break;
	case *lignana*:
	$id_del_tag='8712';
	break;
	case *livorno ferraris*:
	$id_del_tag='8713';
	break;
	case *lozzolo*:
	$id_del_tag='8714';
	break;
	case *mollia*:
	$id_del_tag='8715';
	break;
	case *moncrivello*:
	$id_del_tag='8716';
	break;
	case *motta de' conti*:
	$id_del_tag='8717';
	break;
	case *olcenengo*:
	$id_del_tag='8718';
	break;
	case *oldenico*:
	$id_del_tag='8719';
	break;
	case *palazzolo vercellese*:
	$id_del_tag='8720';
	break;
	case *pertengo*:
	$id_del_tag='8721';
	break;
	case *pezzana*:
	$id_del_tag='8722';
	break;
	case *pila*:
	$id_del_tag='8723';
	break;
	case *piode*:
	$id_del_tag='8724';
	break;
	case *postua*:
	$id_del_tag='8725';
	break;
	case *prarolo*:
	$id_del_tag='8726';
	break;
	case *quarona*:
	$id_del_tag='8727';
	break;
	case *quinto vercellese*:
	$id_del_tag='8728';
	break;
	case *rassa*:
	$id_del_tag='8729';
	break;
	case *rima san giuseppe*:
	$id_del_tag='8730';
	break;
	case *rimasco*:
	$id_del_tag='8731';
	break;
	case *rimella*:
	$id_del_tag='8732';
	break;
	case *riva valdobbia*:
	$id_del_tag='8733';
	break;
	case *rive*:
	$id_del_tag='8734';
	break;
	case *roasio*:
	$id_del_tag='8735';
	break;
	case *ronsecco*:
	$id_del_tag='8736';
	break;
	case *rovasenda*:
	$id_del_tag='8737';
	break;
	case *sabbia*:
	$id_del_tag='8738';
	break;
	case *salasco*:
	$id_del_tag='8739';
	break;
	case *sali vercellese*:
	$id_del_tag='8740';
	break;
	case *san germano vercellese*:
	$id_del_tag='8741';
	break;
	case *san giacomo vercellese*:
	$id_del_tag='8742';
	break;
	case *santhià*:
	$id_del_tag='8743';
	break;
	case *scopa*:
	$id_del_tag='8744';
	break;
	case *scopello*:
	$id_del_tag='8745';
	break;
	case *serravalle sesia*:
	$id_del_tag='8746';
	break;
	case *stroppiana*:
	$id_del_tag='8747';
	break;
	case *tricerro*:
	$id_del_tag='8748';
	break;
	case *trino*:
	$id_del_tag='8749';
	break;
	case *tronzano vercellese*:
	$id_del_tag='8750';
	break;
	case *valduggia*:
	$id_del_tag='8751';
	break;
	case *varallo*:
	$id_del_tag='8752';
	break;
	case *villarboit*:
	$id_del_tag='8753';
	break;
	case *villata*:
	$id_del_tag='8754';
	break;
	case *vocca*:
	$id_del_tag='8755';
	break;
	case *ameno*:
	$id_del_tag='8756';
	break;
	case *armeno*:
	$id_del_tag='8757';
	break;
	case *arona*:
	$id_del_tag='8758';
	break;
	case *barengo*:
	$id_del_tag='8759';
	break;
	case *bellinzago novarese*:
	$id_del_tag='8760';
	break;
	case *biandrate*:
	$id_del_tag='8761';
	break;
	case *boca*:
	$id_del_tag='8762';
	break;
	case *bolzano novarese*:
	$id_del_tag='8763';
	break;
	case *borgo ticino*:
	$id_del_tag='8764';
	break;
	case *borgolavezzaro*:
	$id_del_tag='8765';
	break;
	case *borgomanero*:
	$id_del_tag='8766';
	break;
	case *briona*:
	$id_del_tag='8767';
	break;
	case *caltignaga*:
	$id_del_tag='8768';
	break;
	case *carpignano sesia*:
	$id_del_tag='8769';
	break;
	case *casalbeltrame*:
	$id_del_tag='8770';
	break;
	case *casaleggio novara*:
	$id_del_tag='8771';
	break;
	case *casalino*:
	$id_del_tag='8772';
	break;
	case *casalvolone*:
	$id_del_tag='8773';
	break;
	case *castellazzo novarese*:
	$id_del_tag='8774';
	break;
	case *castelletto sopra ticino*:
	$id_del_tag='8775';
	break;
	case *cavaglietto*:
	$id_del_tag='8776';
	break;
	case *cavaglio d'agogna*:
	$id_del_tag='8777';
	break;
	case *cavallirio*:
	$id_del_tag='8778';
	break;
	case *cerano*:
	$id_del_tag='8779';
	break;
	case *colazza*:
	$id_del_tag='8780';
	break;
	case *comignago*:
	$id_del_tag='8781';
	break;
	case *cressa*:
	$id_del_tag='8782';
	break;
	case *cureggio*:
	$id_del_tag='8783';
	break;
	case *divignano*:
	$id_del_tag='8784';
	break;
	case *dormelletto*:
	$id_del_tag='8785';
	break;
	case *fara novarese*:
	$id_del_tag='8786';
	break;
	case *fontaneto d'agogna*:
	$id_del_tag='8787';
	break;
	case *galliate*:
	$id_del_tag='8788';
	break;
	case *garbagna novarese*:
	$id_del_tag='8789';
	break;
	case *gargallo*:
	$id_del_tag='8790';
	break;
	case *gattico*:
	$id_del_tag='8791';
	break;
	case *ghemme*:
	$id_del_tag='8792';
	break;
	case *granozzo con monticello*:
	$id_del_tag='8793';
	break;
	case *grignasco*:
	$id_del_tag='8794';
	break;
	case *invorio*:
	$id_del_tag='8795';
	break;
	case *landiona*:
	$id_del_tag='8796';
	break;
	case *lesa*:
	$id_del_tag='8797';
	break;
	case *maggiora*:
	$id_del_tag='8798';
	break;
	case *mandello vitta*:
	$id_del_tag='8799';
	break;
	case *marano ticino*:
	$id_del_tag='8800';
	break;
	case *massino visconti*:
	$id_del_tag='8801';
	break;
	case *meina*:
	$id_del_tag='8802';
	break;
	case *mezzomerico*:
	$id_del_tag='8803';
	break;
	case *miasino*:
	$id_del_tag='8804';
	break;
	case *momo*:
	$id_del_tag='8805';
	break;
	case *nebbiuno*:
	$id_del_tag='8806';
	break;
	case *nibbiola*:
	$id_del_tag='8807';
	break;
	case *oleggio*:
	$id_del_tag='8808';
	break;
	case *oleggio castello*:
	$id_del_tag='8809';
	break;
	case *orta san giulio*:
	$id_del_tag='8810';
	break;
	case *paruzzaro*:
	$id_del_tag='8811';
	break;
	case *pella*:
	$id_del_tag='8812';
	break;
	case *pettenasco*:
	$id_del_tag='8813';
	break;
	case *pisano*:
	$id_del_tag='8814';
	break;
	case *pogno*:
	$id_del_tag='8815';
	break;
	case *pombia*:
	$id_del_tag='8816';
	break;
	case *prato sesia*:
	$id_del_tag='8817';
	break;
	case *recetto*:
	$id_del_tag='8818';
	break;
	case *romagnano sesia*:
	$id_del_tag='8819';
	break;
	case *romentino*:
	$id_del_tag='8820';
	break;
	case *san maurizio d'opaglio*:
	$id_del_tag='8821';
	break;
	case *san nazzaro sesia*:
	$id_del_tag='8822';
	break;
	case *san pietro mosezzo*:
	$id_del_tag='8823';
	break;
	case *sillavengo*:
	$id_del_tag='8824';
	break;
	case *sizzano*:
	$id_del_tag='8825';
	break;
	case *soriso*:
	$id_del_tag='8826';
	break;
	case *sozzago*:
	$id_del_tag='8827';
	break;
	case *suno*:
	$id_del_tag='8828';
	break;
	case *terdobbiate*:
	$id_del_tag='8829';
	break;
	case *tornaco*:
	$id_del_tag='8830';
	break;
	case *trecate*:
	$id_del_tag='8831';
	break;
	case *vaprio d'agogna*:
	$id_del_tag='8832';
	break;
	case *varallo pombia*:
	$id_del_tag='8833';
	break;
	case *veruno*:
	$id_del_tag='8834';
	break;
	case *vespolate*:
	$id_del_tag='8835';
	break;
	case *vicolungo*:
	$id_del_tag='8836';
	break;
	case *vinzaglio*:
	$id_del_tag='8837';
	break;
	case *acceglio*:
	$id_del_tag='8838';
	break;
	case *aisone*:
	$id_del_tag='8839';
	break;
	case *alba*:
	$id_del_tag='8840';
	break;
	case *albaretto della torre*:
	$id_del_tag='8841';
	break;
	case *alto*:
	$id_del_tag='8842';
	break;
	case *argentera*:
	$id_del_tag='8843';
	break;
	case *arguello*:
	$id_del_tag='8844';
	break;
	case *bagnasco*:
	$id_del_tag='8845';
	break;
	case *bagnolo piemonte*:
	$id_del_tag='8846';
	break;
	case *baldissero d'alba*:
	$id_del_tag='8847';
	break;
	case *barbaresco*:
	$id_del_tag='8848';
	break;
	case *barge*:
	$id_del_tag='8849';
	break;
	case *barolo*:
	$id_del_tag='8850';
	break;
	case *bastia mondovì*:
	$id_del_tag='8851';
	break;
	case *battifollo*:
	$id_del_tag='8852';
	break;
	case *beinette*:
	$id_del_tag='8853';
	break;
	case *bellino*:
	$id_del_tag='8854';
	break;
	case *belvedere langhe*:
	$id_del_tag='8855';
	break;
	case *bene vagienna*:
	$id_del_tag='8856';
	break;
	case *benevello*:
	$id_del_tag='8857';
	break;
	case *bergolo*:
	$id_del_tag='8858';
	break;
	case *bernezzo*:
	$id_del_tag='8859';
	break;
	case *bonvicino*:
	$id_del_tag='8860';
	break;
	case *borgo san dalmazzo*:
	$id_del_tag='8861';
	break;
	case *borgomale*:
	$id_del_tag='8862';
	break;
	case *bosia*:
	$id_del_tag='8863';
	break;
	case *bossolasco*:
	$id_del_tag='8864';
	break;
	case *boves*:
	$id_del_tag='8865';
	break;
	case *bra*:
	$id_del_tag='8866';
	break;
	case *briaglia*:
	$id_del_tag='8867';
	break;
	case *briga alta*:
	$id_del_tag='8868';
	break;
	case *brondello*:
	$id_del_tag='8869';
	break;
	case *brossasco*:
	$id_del_tag='8870';
	break;
	case *busca*:
	$id_del_tag='8871';
	break;
	case *camerana*:
	$id_del_tag='8872';
	break;
	case *camo*:
	$id_del_tag='8873';
	break;
	case *canale*:
	$id_del_tag='8874';
	break;
	case *canosio*:
	$id_del_tag='8875';
	break;
	case *caprauna*:
	$id_del_tag='8876';
	break;
	case *caraglio*:
	$id_del_tag='8877';
	break;
	case *caramagna piemonte*:
	$id_del_tag='8878';
	break;
	case *cardè*:
	$id_del_tag='8879';
	break;
	case *carrù*:
	$id_del_tag='8880';
	break;
	case *cartignano*:
	$id_del_tag='8881';
	break;
	case *casalgrasso*:
	$id_del_tag='8882';
	break;
	case *castagnito*:
	$id_del_tag='8883';
	break;
	case *casteldelfino*:
	$id_del_tag='8884';
	break;
	case *castellar*:
	$id_del_tag='8885';
	break;
	case *castelletto stura*:
	$id_del_tag='8886';
	break;
	case *castelletto uzzone*:
	$id_del_tag='8887';
	break;
	case *castellinaldo*:
	$id_del_tag='8888';
	break;
	case *castellino tanaro*:
	$id_del_tag='8889';
	break;
	case *castelmagno*:
	$id_del_tag='8890';
	break;
	case *castelnuovo di ceva*:
	$id_del_tag='8891';
	break;
	case *castiglione falletto*:
	$id_del_tag='8892';
	break;
	case *castiglione tinella*:
	$id_del_tag='8893';
	break;
	case *castino*:
	$id_del_tag='8894';
	break;
	case *cavallerleone*:
	$id_del_tag='8895';
	break;
	case *cavallermaggiore*:
	$id_del_tag='8896';
	break;
	case *celle di macra*:
	$id_del_tag='8897';
	break;
	case *centallo*:
	$id_del_tag='8898';
	break;
	case *ceresole alba*:
	$id_del_tag='8899';
	break;
	case *cerretto langhe*:
	$id_del_tag='8900';
	break;
	case *cervasca*:
	$id_del_tag='8901';
	break;
	case *cervere*:
	$id_del_tag='8902';
	break;
	case *cherasco*:
	$id_del_tag='8903';
	break;
	case *chiusa di pesio*:
	$id_del_tag='8904';
	break;
	case *cigliè*:
	$id_del_tag='8905';
	break;
	case *cissone*:
	$id_del_tag='8906';
	break;
	case *clavesana*:
	$id_del_tag='8907';
	break;
	case *corneliano d'alba*:
	$id_del_tag='8908';
	break;
	case *cortemilia*:
	$id_del_tag='8909';
	break;
	case *cossano belbo*:
	$id_del_tag='8910';
	break;
	case *costigliole saluzzo*:
	$id_del_tag='8911';
	break;
	case *cravanzana*:
	$id_del_tag='8912';
	break;
	case *crissolo*:
	$id_del_tag='8913';
	break;
	case *demonte*:
	$id_del_tag='8914';
	break;
	case *diano d'alba*:
	$id_del_tag='8915';
	break;
	case *dogliani*:
	$id_del_tag='8916';
	break;
	case *dronero*:
	$id_del_tag='8917';
	break;
	case *elva*:
	$id_del_tag='8918';
	break;
	case *entracque*:
	$id_del_tag='8919';
	break;
	case *envie*:
	$id_del_tag='8920';
	break;
	case *farigliano*:
	$id_del_tag='8921';
	break;
	case *faule*:
	$id_del_tag='8922';
	break;
	case *feisoglio*:
	$id_del_tag='8923';
	break;
	case *frabosa soprana*:
	$id_del_tag='8924';
	break;
	case *frabosa sottana*:
	$id_del_tag='8925';
	break;
	case *frassino*:
	$id_del_tag='8926';
	break;
	case *gaiola*:
	$id_del_tag='8927';
	break;
	case *gambasca*:
	$id_del_tag='8928';
	break;
	case *garessio*:
	$id_del_tag='8929';
	break;
	case *genola*:
	$id_del_tag='8930';
	break;
	case *gorzegno*:
	$id_del_tag='8931';
	break;
	case *gottasecca*:
	$id_del_tag='8932';
	break;
	case *govone*:
	$id_del_tag='8933';
	break;
	case *grinzane cavour*:
	$id_del_tag='8934';
	break;
	case *guarene*:
	$id_del_tag='8935';
	break;
	case *igliano*:
	$id_del_tag='8936';
	break;
	case *isasca*:
	$id_del_tag='8937';
	break;
	case *la morra*:
	$id_del_tag='8938';
	break;
	case *lagnasco*:
	$id_del_tag='8939';
	break;
	case *lequio berria*:
	$id_del_tag='8940';
	break;
	case *lequio tanaro*:
	$id_del_tag='8941';
	break;
	case *lesegno*:
	$id_del_tag='8942';
	break;
	case *levice*:
	$id_del_tag='8943';
	break;
	case *limone piemonte*:
	$id_del_tag='8944';
	break;
	case *lisio*:
	$id_del_tag='8945';
	break;
	case *macra*:
	$id_del_tag='8946';
	break;
	case *magliano alfieri*:
	$id_del_tag='8947';
	break;
	case *magliano alpi*:
	$id_del_tag='8948';
	break;
	case *mango*:
	$id_del_tag='8949';
	break;
	case *manta*:
	$id_del_tag='8950';
	break;
	case *marene*:
	$id_del_tag='8951';
	break;
	case *margarita*:
	$id_del_tag='8952';
	break;
	case *marmora*:
	$id_del_tag='8953';
	break;
	case *marsaglia*:
	$id_del_tag='8954';
	break;
	case *martiniana po*:
	$id_del_tag='8955';
	break;
	case *melle*:
	$id_del_tag='8956';
	break;
	case *moiola*:
	$id_del_tag='8957';
	break;
	case *mombarcaro*:
	$id_del_tag='8958';
	break;
	case *mombasiglio*:
	$id_del_tag='8959';
	break;
	case *monastero di vasco*:
	$id_del_tag='8960';
	break;
	case *monasterolo casotto*:
	$id_del_tag='8961';
	break;
	case *monasterolo di savigliano*:
	$id_del_tag='8962';
	break;
	case *monchiero*:
	$id_del_tag='8963';
	break;
	case *monesiglio*:
	$id_del_tag='8964';
	break;
	case *monforte d'alba*:
	$id_del_tag='8965';
	break;
	case *montà*:
	$id_del_tag='8966';
	break;
	case *montaldo di mondovì*:
	$id_del_tag='8967';
	break;
	case *montaldo roero*:
	$id_del_tag='8968';
	break;
	case *montanera*:
	$id_del_tag='8969';
	break;
	case *montelupo albese*:
	$id_del_tag='8970';
	break;
	case *montemale di cuneo*:
	$id_del_tag='8971';
	break;
	case *monterosso grana*:
	$id_del_tag='8972';
	break;
	case *monteu roero*:
	$id_del_tag='8973';
	break;
	case *montezemolo*:
	$id_del_tag='8974';
	break;
	case *monticello d'alba*:
	$id_del_tag='8975';
	break;
	case *moretta*:
	$id_del_tag='8976';
	break;
	case *morozzo*:
	$id_del_tag='8977';
	break;
	case *murazzano*:
	$id_del_tag='8978';
	break;
	case *murello*:
	$id_del_tag='8979';
	break;
	case *narzole*:
	$id_del_tag='8980';
	break;
	case *neive*:
	$id_del_tag='8981';
	break;
	case *neviglie*:
	$id_del_tag='8982';
	break;
	case *niella belbo*:
	$id_del_tag='8983';
	break;
	case *niella tanaro*:
	$id_del_tag='8984';
	break;
	case *novello*:
	$id_del_tag='8985';
	break;
	case *nucetto*:
	$id_del_tag='8986';
	break;
	case *oncino*:
	$id_del_tag='8987';
	break;
	case *ormea*:
	$id_del_tag='8988';
	break;
	case *ostana*:
	$id_del_tag='8989';
	break;
	case *paesana*:
	$id_del_tag='8990';
	break;
	case *pagno*:
	$id_del_tag='8991';
	break;
	case *pamparato*:
	$id_del_tag='8992';
	break;
	case *paroldo*:
	$id_del_tag='8993';
	break;
	case *perletto*:
	$id_del_tag='8994';
	break;
	case *perlo*:
	$id_del_tag='8995';
	break;
	case *peveragno*:
	$id_del_tag='8996';
	break;
	case *pezzolo valle uzzone*:
	$id_del_tag='8997';
	break;
	case *pianfei*:
	$id_del_tag='8998';
	break;
	case *piasco*:
	$id_del_tag='8999';
	break;
	case *pietraporzio*:
	$id_del_tag='9000';
	break;
	case *piobesi d'alba*:
	$id_del_tag='9001';
	break;
	case *piozzo*:
	$id_del_tag='9002';
	break;
	case *pocapaglia*:
	$id_del_tag='9003';
	break;
	case *polonghera*:
	$id_del_tag='9004';
	break;
	case *pontechianale*:
	$id_del_tag='9005';
	break;
	case *pradleves*:
	$id_del_tag='9006';
	break;
	case *prazzo*:
	$id_del_tag='9007';
	break;
	case *priero*:
	$id_del_tag='9008';
	break;
	case *priocca*:
	$id_del_tag='9009';
	break;
	case *priola*:
	$id_del_tag='9010';
	break;
	case *prunetto*:
	$id_del_tag='9011';
	break;
	case *racconigi*:
	$id_del_tag='9012';
	break;
	case *revello*:
	$id_del_tag='9013';
	break;
	case *rifreddo*:
	$id_del_tag='9014';
	break;
	case *rittana*:
	$id_del_tag='9015';
	break;
	case *roaschia*:
	$id_del_tag='9016';
	break;
	case *roascio*:
	$id_del_tag='9017';
	break;
	case *robilante*:
	$id_del_tag='9018';
	break;
	case *roburent*:
	$id_del_tag='9019';
	break;
	case *rocca cigliè*:
	$id_del_tag='9020';
	break;
	case *rocca de' baldi*:
	$id_del_tag='9021';
	break;
	case *roccabruna*:
	$id_del_tag='9022';
	break;
	case *roccaforte mondovì*:
	$id_del_tag='9023';
	break;
	case *roccasparvera*:
	$id_del_tag='9024';
	break;
	case *roccavione*:
	$id_del_tag='9025';
	break;
	case *rocchetta belbo*:
	$id_del_tag='9026';
	break;
	case *roddi*:
	$id_del_tag='9027';
	break;
	case *roddino*:
	$id_del_tag='9028';
	break;
	case *rodello*:
	$id_del_tag='9029';
	break;
	case *rossana*:
	$id_del_tag='9030';
	break;
	case *ruffia*:
	$id_del_tag='9031';
	break;
	case *sale delle langhe*:
	$id_del_tag='9032';
	break;
	case *sale san giovanni*:
	$id_del_tag='9033';
	break;
	case *saliceto*:
	$id_del_tag='9034';
	break;
	case *salmour*:
	$id_del_tag='9035';
	break;
	case *sambuco*:
	$id_del_tag='9036';
	break;
	case *sampeyre*:
	$id_del_tag='9037';
	break;
	case *san benedetto belbo*:
	$id_del_tag='9038';
	break;
	case *san damiano macra*:
	$id_del_tag='9039';
	break;
	case *san michele mondovì*:
	$id_del_tag='9040';
	break;
	case *sanfrè*:
	$id_del_tag='9041';
	break;
	case *sanfront*:
	$id_del_tag='9042';
	break;
	case *santa vittoria d'alba*:
	$id_del_tag='9043';
	break;
	case *sant'albano stura*:
	$id_del_tag='9044';
	break;
	case *santo stefano belbo*:
	$id_del_tag='9045';
	break;
	case *santo stefano roero*:
	$id_del_tag='9046';
	break;
	case *savigliano*:
	$id_del_tag='9047';
	break;
	case *scagnello*:
	$id_del_tag='9048';
	break;
	case *scarnafigi*:
	$id_del_tag='9049';
	break;
	case *serralunga d'alba*:
	$id_del_tag='9050';
	break;
	case *serravalle langhe*:
	$id_del_tag='9051';
	break;
	case *sinio*:
	$id_del_tag='9052';
	break;
	case *somano*:
	$id_del_tag='9053';
	break;
	case *sommariva del bosco*:
	$id_del_tag='9054';
	break;
	case *sommariva perno*:
	$id_del_tag='9055';
	break;
	case *stroppo*:
	$id_del_tag='9056';
	break;
	case *tarantasca*:
	$id_del_tag='9057';
	break;
	case *torre bormida*:
	$id_del_tag='9058';
	break;
	case *torre mondovì*:
	$id_del_tag='9059';
	break;
	case *torre san giorgio*:
	$id_del_tag='9060';
	break;
	case *torresina*:
	$id_del_tag='9061';
	break;
	case *treiso*:
	$id_del_tag='9062';
	break;
	case *trezzo tinella*:
	$id_del_tag='9063';
	break;
	case *trinità*:
	$id_del_tag='9064';
	break;
	case *valdieri*:
	$id_del_tag='9065';
	break;
	case *valgrana*:
	$id_del_tag='9066';
	break;
	case *valloriate*:
	$id_del_tag='9067';
	break;
	case *valmala*:
	$id_del_tag='9068';
	break;
	case *venasca*:
	$id_del_tag='9069';
	break;
	case *verduno*:
	$id_del_tag='9070';
	break;
	case *vernante*:
	$id_del_tag='9071';
	break;
	case *verzuolo*:
	$id_del_tag='9072';
	break;
	case *vezza d'alba*:
	$id_del_tag='9073';
	break;
	case *vicoforte*:
	$id_del_tag='9074';
	break;
	case *vignolo*:
	$id_del_tag='9075';
	break;
	case *villafalletto*:
	$id_del_tag='9076';
	break;
	case *villanova mondovì*:
	$id_del_tag='9077';
	break;
	case *villanova solaro*:
	$id_del_tag='9078';
	break;
	case *villar san costanzo*:
	$id_del_tag='9079';
	break;
	case *vinadio*:
	$id_del_tag='9080';
	break;
	case *viola*:
	$id_del_tag='9081';
	break;
	case *vottignasco*:
	$id_del_tag='9082';
	break;
	case *agliano terme*:
	$id_del_tag='9083';
	break;
	case *albugnano*:
	$id_del_tag='9084';
	break;
	case *antignano*:
	$id_del_tag='9085';
	break;
	case *aramengo*:
	$id_del_tag='9086';
	break;
	case *azzano d'asti*:
	$id_del_tag='9087';
	break;
	case *baldichieri d'asti*:
	$id_del_tag='9088';
	break;
	case *belveglio*:
	$id_del_tag='9089';
	break;
	case *berzano di san pietro*:
	$id_del_tag='9090';
	break;
	case *bruno*:
	$id_del_tag='9091';
	break;
	case *bubbio*:
	$id_del_tag='9092';
	break;
	case *buttigliera d'asti*:
	$id_del_tag='9093';
	break;
	case *calamandrana*:
	$id_del_tag='9094';
	break;
	case *calliano*:
	$id_del_tag='9095';
	break;
	case *calosso*:
	$id_del_tag='9096';
	break;
	case *camerano casasco*:
	$id_del_tag='9097';
	break;
	case *canelli*:
	$id_del_tag='9098';
	break;
	case *cantarana*:
	$id_del_tag='9099';
	break;
	case *capriglio*:
	$id_del_tag='9100';
	break;
	case *casorzo*:
	$id_del_tag='9101';
	break;
	case *cassinasco*:
	$id_del_tag='9102';
	break;
	case *castagnole delle lanze*:
	$id_del_tag='9103';
	break;
	case *castagnole monferrato*:
	$id_del_tag='9104';
	break;
	case *castel boglione*:
	$id_del_tag='9105';
	break;
	case *castel rocchero*:
	$id_del_tag='9106';
	break;
	case *castell'alfero*:
	$id_del_tag='9107';
	break;
	case *castellero*:
	$id_del_tag='9108';
	break;
	case *castelletto molina*:
	$id_del_tag='9109';
	break;
	case *castello di annone*:
	$id_del_tag='9110';
	break;
	case *castelnuovo belbo*:
	$id_del_tag='9111';
	break;
	case *castelnuovo calcea*:
	$id_del_tag='9112';
	break;
	case *castelnuovo don bosco*:
	$id_del_tag='9113';
	break;
	case *cellarengo*:
	$id_del_tag='9114';
	break;
	case *celle enomondo*:
	$id_del_tag='9115';
	break;
	case *cerreto d'asti*:
	$id_del_tag='9116';
	break;
	case *cerro tanaro*:
	$id_del_tag='9117';
	break;
	case *cessole*:
	$id_del_tag='9118';
	break;
	case *chiusano d'asti*:
	$id_del_tag='9119';
	break;
	case *cinaglio*:
	$id_del_tag='9120';
	break;
	case *cisterna d'asti*:
	$id_del_tag='9121';
	break;
	case *coazzolo*:
	$id_del_tag='9122';
	break;
	case *cocconato*:
	$id_del_tag='9123';
	break;
	case *corsione*:
	$id_del_tag='9124';
	break;
	case *cortandone*:
	$id_del_tag='9125';
	break;
	case *cortanze*:
	$id_del_tag='9126';
	break;
	case *cortazzone*:
	$id_del_tag='9127';
	break;
	case *cortiglione*:
	$id_del_tag='9128';
	break;
	case *cossombrato*:
	$id_del_tag='9129';
	break;
	case *costigliole d'asti*:
	$id_del_tag='9130';
	break;
	case *cunico*:
	$id_del_tag='9131';
	break;
	case *dusino san michele*:
	$id_del_tag='9132';
	break;
	case *ferrere*:
	$id_del_tag='9133';
	break;
	case *fontanile*:
	$id_del_tag='9134';
	break;
	case *frinco*:
	$id_del_tag='9135';
	break;
	case *grana*:
	$id_del_tag='9136';
	break;
	case *grazzano badoglio*:
	$id_del_tag='9137';
	break;
	case *incisa scapaccino*:
	$id_del_tag='9138';
	break;
	case *isola d'asti*:
	$id_del_tag='9139';
	break;
	case *loazzolo*:
	$id_del_tag='9140';
	break;
	case *maranzana*:
	$id_del_tag='9141';
	break;
	case *maretto*:
	$id_del_tag='9142';
	break;
	case *moasca*:
	$id_del_tag='9143';
	break;
	case *mombaldone*:
	$id_del_tag='9144';
	break;
	case *mombaruzzo*:
	$id_del_tag='9145';
	break;
	case *mombercelli*:
	$id_del_tag='9146';
	break;
	case *monale*:
	$id_del_tag='9147';
	break;
	case *monastero bormida*:
	$id_del_tag='9148';
	break;
	case *moncalvo*:
	$id_del_tag='9149';
	break;
	case *moncucco torinese*:
	$id_del_tag='9150';
	break;
	case *mongardino*:
	$id_del_tag='9151';
	break;
	case *montabone*:
	$id_del_tag='9152';
	break;
	case *montafia*:
	$id_del_tag='9153';
	break;
	case *montaldo scarampi*:
	$id_del_tag='9154';
	break;
	case *montechiaro d'asti*:
	$id_del_tag='9155';
	break;
	case *montegrosso d'asti*:
	$id_del_tag='9156';
	break;
	case *montemagno*:
	$id_del_tag='9157';
	break;
	case *montiglio monferrato*:
	$id_del_tag='9158';
	break;
	case *moransengo*:
	$id_del_tag='9159';
	break;
	case *nizza monferrato*:
	$id_del_tag='9160';
	break;
	case *olmo gentile*:
	$id_del_tag='9161';
	break;
	case *passerano marmorito*:
	$id_del_tag='9162';
	break;
	case *penango*:
	$id_del_tag='9163';
	break;
	case *piea*:
	$id_del_tag='9164';
	break;
	case *pino d'asti*:
	$id_del_tag='9165';
	break;
	case *piovà massaia*:
	$id_del_tag='9166';
	break;
	case *portacomaro*:
	$id_del_tag='9167';
	break;
	case *quaranti*:
	$id_del_tag='9168';
	break;
	case *refrancore*:
	$id_del_tag='9169';
	break;
	case *revigliasco d'asti*:
	$id_del_tag='9170';
	break;
	case *roatto*:
	$id_del_tag='9171';
	break;
	case *robella*:
	$id_del_tag='9172';
	break;
	case *rocca d'arazzo*:
	$id_del_tag='9173';
	break;
	case *roccaverano*:
	$id_del_tag='9174';
	break;
	case *rocchetta palafea*:
	$id_del_tag='9175';
	break;
	case *rocchetta tanaro*:
	$id_del_tag='9176';
	break;
	case *san damiano d'asti*:
	$id_del_tag='9177';
	break;
	case *san giorgio scarampi*:
	$id_del_tag='9178';
	break;
	case *san martino alfieri*:
	$id_del_tag='9179';
	break;
	case *san marzano oliveto*:
	$id_del_tag='9180';
	break;
	case *san paolo solbrito*:
	$id_del_tag='9181';
	break;
	case *scurzolengo*:
	$id_del_tag='9182';
	break;
	case *serole*:
	$id_del_tag='9183';
	break;
	case *sessame*:
	$id_del_tag='9184';
	break;
	case *settime*:
	$id_del_tag='9185';
	break;
	case *soglio*:
	$id_del_tag='9186';
	break;
	case *tigliole*:
	$id_del_tag='9187';
	break;
	case *tonco*:
	$id_del_tag='9188';
	break;
	case *tonengo*:
	$id_del_tag='9189';
	break;
	case *vaglio serra*:
	$id_del_tag='9190';
	break;
	case *valfenera*:
	$id_del_tag='9191';
	break;
	case *vesime*:
	$id_del_tag='9192';
	break;
	case *viale*:
	$id_del_tag='9193';
	break;
	case *viarigi*:
	$id_del_tag='9194';
	break;
	case *vigliano d'asti*:
	$id_del_tag='9195';
	break;
	case *villa san secondo*:
	$id_del_tag='9196';
	break;
	case *villafranca d'asti*:
	$id_del_tag='9197';
	break;
	case *villanova d'asti*:
	$id_del_tag='9198';
	break;
	case *vinchio*:
	$id_del_tag='9199';
	break;
	case *acqui terme*:
	$id_del_tag='9200';
	break;
	case *albera ligure*:
	$id_del_tag='9201';
	break;
	case *alfiano natta*:
	$id_del_tag='9202';
	break;
	case *alice bel colle*:
	$id_del_tag='9203';
	break;
	case *alluvioni cambiò*:
	$id_del_tag='9204';
	break;
	case *altavilla monferrato*:
	$id_del_tag='9205';
	break;
	case *alzano scrivia*:
	$id_del_tag='9206';
	break;
	case *arquata scrivia*:
	$id_del_tag='9207';
	break;
	case *avolasca*:
	$id_del_tag='9208';
	break;
	case *balzola*:
	$id_del_tag='9209';
	break;
	case *basaluzzo*:
	$id_del_tag='9210';
	break;
	case *bassignana*:
	$id_del_tag='9211';
	break;
	case *bergamasco*:
	$id_del_tag='9212';
	break;
	case *berzano di tortona*:
	$id_del_tag='9213';
	break;
	case *bistagno*:
	$id_del_tag='9214';
	break;
	case *borghetto di borbera*:
	$id_del_tag='9215';
	break;
	case *borgo san martino*:
	$id_del_tag='9216';
	break;
	case *borgoratto alessandrino*:
	$id_del_tag='9217';
	break;
	case *bosco marengo*:
	$id_del_tag='9218';
	break;
	case *bosio*:
	$id_del_tag='9219';
	break;
	case *bozzole*:
	$id_del_tag='9220';
	break;
	case *brignano-frascata*:
	$id_del_tag='9221';
	break;
	case *cabella ligure*:
	$id_del_tag='9222';
	break;
	case *camagna monferrato*:
	$id_del_tag='9223';
	break;
	case *camino*:
	$id_del_tag='9224';
	break;
	case *cantalupo ligure*:
	$id_del_tag='9225';
	break;
	case *capriata d'orba*:
	$id_del_tag='9226';
	break;
	case *carbonara scrivia*:
	$id_del_tag='9227';
	break;
	case *carentino*:
	$id_del_tag='9228';
	break;
	case *carezzano*:
	$id_del_tag='9229';
	break;
	case *carpeneto*:
	$id_del_tag='9230';
	break;
	case *carrega ligure*:
	$id_del_tag='9231';
	break;
	case *carrosio*:
	$id_del_tag='9232';
	break;
	case *cartosio*:
	$id_del_tag='9233';
	break;
	case *casal cermelli*:
	$id_del_tag='9234';
	break;
	case *casaleggio boiro*:
	$id_del_tag='9235';
	break;
	case *casalnoceto*:
	$id_del_tag='9236';
	break;
	case *casasco*:
	$id_del_tag='9237';
	break;
	case *cassano spinola*:
	$id_del_tag='9238';
	break;
	case *cassine*:
	$id_del_tag='9239';
	break;
	case *cassinelle*:
	$id_del_tag='9240';
	break;
	case *castellania*:
	$id_del_tag='9241';
	break;
	case *castellar guidobono*:
	$id_del_tag='9242';
	break;
	case *castellazzo bormida*:
	$id_del_tag='9243';
	break;
	case *castelletto d'erro*:
	$id_del_tag='9244';
	break;
	case *castelletto d'orba*:
	$id_del_tag='9245';
	break;
	case *castelletto merli*:
	$id_del_tag='9246';
	break;
	case *castelletto monferrato*:
	$id_del_tag='9247';
	break;
	case *castelnuovo bormida*:
	$id_del_tag='9248';
	break;
	case *castelnuovo scrivia*:
	$id_del_tag='9249';
	break;
	case *castelspina*:
	$id_del_tag='9250';
	break;
	case *cavatore*:
	$id_del_tag='9251';
	break;
	case *cella monte*:
	$id_del_tag='9252';
	break;
	case *cereseto*:
	$id_del_tag='9253';
	break;
	case *cerreto grue*:
	$id_del_tag='9254';
	break;
	case *cerrina monferrato*:
	$id_del_tag='9255';
	break;
	case *coniolo*:
	$id_del_tag='9256';
	break;
	case *conzano*:
	$id_del_tag='9257';
	break;
	case *costa vescovato*:
	$id_del_tag='9258';
	break;
	case *cremolino*:
	$id_del_tag='9259';
	break;
	case *cuccaro monferrato*:
	$id_del_tag='9260';
	break;
	case *denice*:
	$id_del_tag='9261';
	break;
	case *dernice*:
	$id_del_tag='9262';
	break;
	case *fabbrica curone*:
	$id_del_tag='9263';
	break;
	case *felizzano*:
	$id_del_tag='9264';
	break;
	case *fraconalto*:
	$id_del_tag='9265';
	break;
	case *francavilla bisio*:
	$id_del_tag='9266';
	break;
	case *frascaro*:
	$id_del_tag='9267';
	break;
	case *frassinello monferrato*:
	$id_del_tag='9268';
	break;
	case *frassineto po*:
	$id_del_tag='9269';
	break;
	case *fresonara*:
	$id_del_tag='9270';
	break;
	case *frugarolo*:
	$id_del_tag='9271';
	break;
	case *fubine*:
	$id_del_tag='9272';
	break;
	case *gabiano*:
	$id_del_tag='9273';
	break;
	case *gamalero*:
	$id_del_tag='9274';
	break;
	case *garbagna*:
	$id_del_tag='9275';
	break;
	case *gavazzana*:
	$id_del_tag='9276';
	break;
	case *gavi*:
	$id_del_tag='9277';
	break;
	case *giarole*:
	$id_del_tag='9278';
	break;
	case *gremiasco*:
	$id_del_tag='9279';
	break;
	case *grognardo*:
	$id_del_tag='9280';
	break;
	case *grondona*:
	$id_del_tag='9281';
	break;
	case *guazzora*:
	$id_del_tag='9282';
	break;
	case *isola sant'antonio*:
	$id_del_tag='9283';
	break;
	case *lerma*:
	$id_del_tag='9284';
	break;
	case *lu*:
	$id_del_tag='9285';
	break;
	case *malvicino*:
	$id_del_tag='9286';
	break;
	case *masio*:
	$id_del_tag='9287';
	break;
	case *melazzo*:
	$id_del_tag='9288';
	break;
	case *merana*:
	$id_del_tag='9289';
	break;
	case *mirabello monferrato*:
	$id_del_tag='9290';
	break;
	case *molare*:
	$id_del_tag='9291';
	break;
	case *molino dei torti*:
	$id_del_tag='9292';
	break;
	case *mombello monferrato*:
	$id_del_tag='9293';
	break;
	case *momperone*:
	$id_del_tag='9294';
	break;
	case *moncestino*:
	$id_del_tag='9295';
	break;
	case *mongiardino ligure*:
	$id_del_tag='9296';
	break;
	case *monleale*:
	$id_del_tag='9297';
	break;
	case *montacuto*:
	$id_del_tag='9298';
	break;
	case *montaldeo*:
	$id_del_tag='9299';
	break;
	case *montaldo bormida*:
	$id_del_tag='9300';
	break;
	case *montecastello*:
	$id_del_tag='9301';
	break;
	case *montechiaro d'acqui*:
	$id_del_tag='9302';
	break;
	case *montegioco*:
	$id_del_tag='9303';
	break;
	case *montemarzino*:
	$id_del_tag='9304';
	break;
	case *morano sul po*:
	$id_del_tag='9305';
	break;
	case *morbello*:
	$id_del_tag='9306';
	break;
	case *mornese*:
	$id_del_tag='9307';
	break;
	case *morsasco*:
	$id_del_tag='9308';
	break;
	case *murisengo*:
	$id_del_tag='9309';
	break;
	case *occimiano*:
	$id_del_tag='9310';
	break;
	case *odalengo grande*:
	$id_del_tag='9311';
	break;
	case *odalengo piccolo*:
	$id_del_tag='9312';
	break;
	case *olivola*:
	$id_del_tag='9313';
	break;
	case *orsara bormida*:
	$id_del_tag='9314';
	break;
	case *ottiglio*:
	$id_del_tag='9315';
	break;
	case *oviglio*:
	$id_del_tag='9316';
	break;
	case *ozzano monferrato*:
	$id_del_tag='9317';
	break;
	case *paderna*:
	$id_del_tag='9318';
	break;
	case *pareto*:
	$id_del_tag='9319';
	break;
	case *parodi ligure*:
	$id_del_tag='9320';
	break;
	case *pasturana*:
	$id_del_tag='9321';
	break;
	case *pecetto di valenza*:
	$id_del_tag='9322';
	break;
	case *pietra marazzi*:
	$id_del_tag='9323';
	break;
	case *piovera*:
	$id_del_tag='9324';
	break;
	case *pomaro monferrato*:
	$id_del_tag='9325';
	break;
	case *pontecurone*:
	$id_del_tag='9326';
	break;
	case *pontestura*:
	$id_del_tag='9327';
	break;
	case *ponti*:
	$id_del_tag='9328';
	break;
	case *ponzano monferrato*:
	$id_del_tag='9329';
	break;
	case *ponzone*:
	$id_del_tag='9330';
	break;
	case *pozzol groppo*:
	$id_del_tag='9331';
	break;
	case *prasco*:
	$id_del_tag='9332';
	break;
	case *predosa*:
	$id_del_tag='9333';
	break;
	case *quargnento*:
	$id_del_tag='9334';
	break;
	case *quattordio*:
	$id_del_tag='9335';
	break;
	case *ricaldone*:
	$id_del_tag='9336';
	break;
	case *rivalta bormida*:
	$id_del_tag='9337';
	break;
	case *rivarone*:
	$id_del_tag='9338';
	break;
	case *rocca grimalda*:
	$id_del_tag='9339';
	break;
	case *roccaforte ligure*:
	$id_del_tag='9340';
	break;
	case *rocchetta ligure*:
	$id_del_tag='9341';
	break;
	case *rosignano monferrato*:
	$id_del_tag='9342';
	break;
	case *sala monferrato*:
	$id_del_tag='9343';
	break;
	case *sale*:
	$id_del_tag='9344';
	break;
	case *san cristoforo*:
	$id_del_tag='9345';
	break;
	case *san giorgio monferrato*:
	$id_del_tag='9346';
	break;
	case *san salvatore monferrato*:
	$id_del_tag='9347';
	break;
	case *san sebastiano curone*:
	$id_del_tag='9348';
	break;
	case *sant'agata fossili*:
	$id_del_tag='9349';
	break;
	case *sardigliano*:
	$id_del_tag='9350';
	break;
	case *sarezzano*:
	$id_del_tag='9351';
	break;
	case *serralunga di crea*:
	$id_del_tag='9352';
	break;
	case *sezzadio*:
	$id_del_tag='9353';
	break;
	case *silvano d'orba*:
	$id_del_tag='9354';
	break;
	case *solero*:
	$id_del_tag='9355';
	break;
	case *solonghello*:
	$id_del_tag='9356';
	break;
	case *spigno monferrato*:
	$id_del_tag='9357';
	break;
	case *spineto scrivia*:
	$id_del_tag='9358';
	break;
	case *stazzano*:
	$id_del_tag='9359';
	break;
	case *strevi*:
	$id_del_tag='9360';
	break;
	case *tagliolo monferrato*:
	$id_del_tag='9361';
	break;
	case *tassarolo*:
	$id_del_tag='9362';
	break;
	case *terruggia*:
	$id_del_tag='9363';
	break;
	case *terzo*:
	$id_del_tag='9364';
	break;
	case *ticineto*:
	$id_del_tag='9365';
	break;
	case *tortona*:
	$id_del_tag='9366';
	break;
	case *treville*:
	$id_del_tag='9367';
	break;
	case *trisobbio*:
	$id_del_tag='9368';
	break;
	case *valenza*:
	$id_del_tag='9369';
	break;
	case *valmacca*:
	$id_del_tag='9370';
	break;
	case *vignale monferrato*:
	$id_del_tag='9371';
	break;
	case *vignole borbera*:
	$id_del_tag='9372';
	break;
	case *viguzzolo*:
	$id_del_tag='9373';
	break;
	case *villadeati*:
	$id_del_tag='9374';
	break;
	case *villalvernia*:
	$id_del_tag='9375';
	break;
	case *villamiroglio*:
	$id_del_tag='9376';
	break;
	case *villanova monferrato*:
	$id_del_tag='9377';
	break;
	case *villaromagnano*:
	$id_del_tag='9378';
	break;
	case *visone*:
	$id_del_tag='9379';
	break;
	case *volpedo*:
	$id_del_tag='9380';
	break;
	case *volpeglino*:
	$id_del_tag='9381';
	break;
	case *voltaggio*:
	$id_del_tag='9382';
	break;
	case *allein*:
	$id_del_tag='9383';
	break;
	case *antey-saint-andrè*:
	$id_del_tag='9384';
	break;
	case *arnad*:
	$id_del_tag='9385';
	break;
	case *arvier*:
	$id_del_tag='9386';
	break;
	case *avise*:
	$id_del_tag='9387';
	break;
	case *ayas*:
	$id_del_tag='9388';
	break;
	case *aymavilles*:
	$id_del_tag='9389';
	break;
	case *bard*:
	$id_del_tag='9390';
	break;
	case *bionaz*:
	$id_del_tag='9391';
	break;
	case *brissogne*:
	$id_del_tag='9392';
	break;
	case *brusson*:
	$id_del_tag='9393';
	break;
	case *challand-saint-anselme*:
	$id_del_tag='9394';
	break;
	case *challand-saint-victor*:
	$id_del_tag='9395';
	break;
	case *chambave*:
	$id_del_tag='9396';
	break;
	case *chamois*:
	$id_del_tag='9397';
	break;
	case *champdepraz*:
	$id_del_tag='9398';
	break;
	case *champorcher*:
	$id_del_tag='9399';
	break;
	case *charvensod*:
	$id_del_tag='9400';
	break;
	case *chatillon*:
	$id_del_tag='9401';
	break;
	case *cogne*:
	$id_del_tag='9402';
	break;
	case *courmayeur*:
	$id_del_tag='9403';
	break;
	case *donnas*:
	$id_del_tag='9404';
	break;
	case *doues*:
	$id_del_tag='9405';
	break;
	case *emarèse*:
	$id_del_tag='9406';
	break;
	case *etroubles*:
	$id_del_tag='9407';
	break;
	case *fénis*:
	$id_del_tag='9408';
	break;
	case *fontainemore*:
	$id_del_tag='9409';
	break;
	case *gaby*:
	$id_del_tag='9410';
	break;
	case *gignod*:
	$id_del_tag='9411';
	break;
	case *gressan*:
	$id_del_tag='9412';
	break;
	case *gressoney-la-trinitè*:
	$id_del_tag='9413';
	break;
	case *gressoney-saint-jean*:
	$id_del_tag='9414';
	break;
	case *hone*:
	$id_del_tag='9415';
	break;
	case *introd*:
	$id_del_tag='9416';
	break;
	case *issime*:
	$id_del_tag='9417';
	break;
	case *issogne*:
	$id_del_tag='9418';
	break;
	case *jovencan*:
	$id_del_tag='9419';
	break;
	case *la magdeleine*:
	$id_del_tag='9420';
	break;
	case *la salle*:
	$id_del_tag='9421';
	break;
	case *la thuile*:
	$id_del_tag='9422';
	break;
	case *lillianes*:
	$id_del_tag='9423';
	break;
	case *montjovet*:
	$id_del_tag='9424';
	break;
	case *morgex*:
	$id_del_tag='9425';
	break;
	case *nus*:
	$id_del_tag='9426';
	break;
	case *ollomont*:
	$id_del_tag='9427';
	break;
	case *oyace*:
	$id_del_tag='9428';
	break;
	case *perloz*:
	$id_del_tag='9429';
	break;
	case *pollein*:
	$id_del_tag='9430';
	break;
	case *pontboset*:
	$id_del_tag='9431';
	break;
	case *pontey*:
	$id_del_tag='9432';
	break;
	case *pont-saint-martin*:
	$id_del_tag='9433';
	break;
	case *prè-saint-didier*:
	$id_del_tag='9434';
	break;
	case *quart*:
	$id_del_tag='9435';
	break;
	case *rhemes-notre-dame*:
	$id_del_tag='9436';
	break;
	case *rhemes-saint-georges*:
	$id_del_tag='9437';
	break;
	case *roisan*:
	$id_del_tag='9438';
	break;
	case *saint-christophe*:
	$id_del_tag='9439';
	break;
	case *saint-denis*:
	$id_del_tag='9440';
	break;
	case *saint-marcel*:
	$id_del_tag='9441';
	break;
	case *saint-nicolas*:
	$id_del_tag='9442';
	break;
	case *saint-oyen*:
	$id_del_tag='9443';
	break;
	case *saint-pierre*:
	$id_del_tag='9444';
	break;
	case *saint-rhémy-en-bosses*:
	$id_del_tag='9445';
	break;
	case *saint-vincent*:
	$id_del_tag='9446';
	break;
	case *sarre*:
	$id_del_tag='9447';
	break;
	case *torgnon*:
	$id_del_tag='9448';
	break;
	case *valgrisenche*:
	$id_del_tag='9449';
	break;
	case *valpelline*:
	$id_del_tag='9450';
	break;
	case *valsavarenche*:
	$id_del_tag='9451';
	break;
	case *valtournenche*:
	$id_del_tag='9452';
	break;
	case *verrayes*:
	$id_del_tag='9453';
	break;
	case *verrès*:
	$id_del_tag='9454';
	break;
	case *villeneuve*:
	$id_del_tag='9455';
	break;
	case *airole*:
	$id_del_tag='9456';
	break;
	case *apricale*:
	$id_del_tag='9457';
	break;
	case *aquila d'arroscia*:
	$id_del_tag='9458';
	break;
	case *armo*:
	$id_del_tag='9459';
	break;
	case *aurigo*:
	$id_del_tag='9460';
	break;
	case *badalucco*:
	$id_del_tag='9461';
	break;
	case *bajardo*:
	$id_del_tag='9462';
	break;
	case *bordighera*:
	$id_del_tag='9463';
	break;
	case *borghetto d'arroscia*:
	$id_del_tag='9464';
	break;
	case *borgomaro*:
	$id_del_tag='9465';
	break;
	case *camporosso*:
	$id_del_tag='9466';
	break;
	case *caravonica*:
	$id_del_tag='9467';
	break;
	case *carpasio*:
	$id_del_tag='9468';
	break;
	case *castel vittorio*:
	$id_del_tag='9469';
	break;
	case *castellaro*:
	$id_del_tag='9470';
	break;
	case *ceriana*:
	$id_del_tag='9471';
	break;
	case *cervo*:
	$id_del_tag='9472';
	break;
	case *cesio*:
	$id_del_tag='9473';
	break;
	case *chiusanico*:
	$id_del_tag='9474';
	break;
	case *chiusavecchia*:
	$id_del_tag='9475';
	break;
	case *cipressa*:
	$id_del_tag='9476';
	break;
	case *civezza*:
	$id_del_tag='9477';
	break;
	case *cosio d'arroscia*:
	$id_del_tag='9478';
	break;
	case *costarainera*:
	$id_del_tag='9479';
	break;
	case *diano arentino*:
	$id_del_tag='9480';
	break;
	case *diano castello*:
	$id_del_tag='9481';
	break;
	case *diano marina*:
	$id_del_tag='9482';
	break;
	case *diano san pietro*:
	$id_del_tag='9483';
	break;
	case *dolceacqua*:
	$id_del_tag='9484';
	break;
	case *dolcedo*:
	$id_del_tag='9485';
	break;
	case *isolabona*:
	$id_del_tag='9486';
	break;
	case *lucinasco*:
	$id_del_tag='9487';
	break;
	case *mendatica*:
	$id_del_tag='9488';
	break;
	case *molini di triora*:
	$id_del_tag='9489';
	break;
	case *montalto ligure*:
	$id_del_tag='9490';
	break;
	case *montegrosso pian latte*:
	$id_del_tag='9491';
	break;
	case *olivetta san michele*:
	$id_del_tag='9492';
	break;
	case *ospedaletti*:
	$id_del_tag='9493';
	break;
	case *perinaldo*:
	$id_del_tag='9494';
	break;
	case *pietrabruna*:
	$id_del_tag='9495';
	break;
	case *pieve di teco*:
	$id_del_tag='9496';
	break;
	case *pigna*:
	$id_del_tag='9497';
	break;
	case *pompeiana*:
	$id_del_tag='9498';
	break;
	case *pontedassio*:
	$id_del_tag='9499';
	break;
	case *pornassio*:
	$id_del_tag='9500';
	break;
	case *prelà*:
	$id_del_tag='9501';
	break;
	case *ranzo*:
	$id_del_tag='9502';
	break;
	case *rezzo*:
	$id_del_tag='9503';
	break;
	case *riva ligure*:
	$id_del_tag='9504';
	break;
	case *rocchetta nervina*:
	$id_del_tag='9505';
	break;
	case *san bartolomeo al mare*:
	$id_del_tag='9506';
	break;
	case *san biagio della cima*:
	$id_del_tag='9507';
	break;
	case *san lorenzo al mare*:
	$id_del_tag='9508';
	break;
	case *sanremo*:
	$id_del_tag='9509';
	break;
	case *santo stefano al mare*:
	$id_del_tag='9510';
	break;
	case *seborga*:
	$id_del_tag='9511';
	break;
	case *soldano*:
	$id_del_tag='9512';
	break;
	case *taggia*:
	$id_del_tag='9513';
	break;
	case *terzorio*:
	$id_del_tag='9514';
	break;
	case *triora*:
	$id_del_tag='9515';
	break;
	case *vallebona*:
	$id_del_tag='9516';
	break;
	case *vallecrosia*:
	$id_del_tag='9517';
	break;
	case *vasia*:
	$id_del_tag='9518';
	break;
	case *vessalico*:
	$id_del_tag='9519';
	break;
	case *villa faraldi*:
	$id_del_tag='9520';
	break;
	case *alassio*:
	$id_del_tag='9521';
	break;
	case *albisola superiore*:
	$id_del_tag='9522';
	break;
	case *albissola marina*:
	$id_del_tag='9523';
	break;
	case *altare*:
	$id_del_tag='9524';
	break;
	case *arnasco*:
	$id_del_tag='9525';
	break;
	case *balestrino*:
	$id_del_tag='9526';
	break;
	case *bardineto*:
	$id_del_tag='9527';
	break;
	case *bergeggi*:
	$id_del_tag='9528';
	break;
	case *boissano*:
	$id_del_tag='9529';
	break;
	case *borghetto santo spirito*:
	$id_del_tag='9530';
	break;
	case *borgio verezzi*:
	$id_del_tag='9531';
	break;
	case *bormida*:
	$id_del_tag='9532';
	break;
	case *cairo montenotte*:
	$id_del_tag='9533';
	break;
	case *calice ligure*:
	$id_del_tag='9534';
	break;
	case *calizzano*:
	$id_del_tag='9535';
	break;
	case *carcare*:
	$id_del_tag='9536';
	break;
	case *casanova lerrone*:
	$id_del_tag='9537';
	break;
	case *castelbianco*:
	$id_del_tag='9538';
	break;
	case *castelvecchio di rocca barbena*:
	$id_del_tag='9539';
	break;
	case *cengio*:
	$id_del_tag='9540';
	break;
	case *ceriale*:
	$id_del_tag='9541';
	break;
	case *cisano sul neva*:
	$id_del_tag='9542';
	break;
	case *cosseria*:
	$id_del_tag='9543';
	break;
	case *dego*:
	$id_del_tag='9544';
	break;
	case *erli*:
	$id_del_tag='9545';
	break;
	case *garlenda*:
	$id_del_tag='9546';
	break;
	case *giustenice*:
	$id_del_tag='9547';
	break;
	case *giusvalla*:
	$id_del_tag='9548';
	break;
	case *laigueglia*:
	$id_del_tag='9549';
	break;
	case *loano*:
	$id_del_tag='9550';
	break;
	case *magliolo*:
	$id_del_tag='9551';
	break;
	case *mallare*:
	$id_del_tag='9552';
	break;
	case *massimino*:
	$id_del_tag='9553';
	break;
	case *millesimo*:
	$id_del_tag='9554';
	break;
	case *mioglia*:
	$id_del_tag='9555';
	break;
	case *murialdo*:
	$id_del_tag='9556';
	break;
	case *nasino*:
	$id_del_tag='9557';
	break;
	case *noli*:
	$id_del_tag='9558';
	break;
	case *onzo*:
	$id_del_tag='9559';
	break;
	case *orco feglino*:
	$id_del_tag='9560';
	break;
	case *ortovero*:
	$id_del_tag='9561';
	break;
	case *osiglia*:
	$id_del_tag='9562';
	break;
	case *pallare*:
	$id_del_tag='9563';
	break;
	case *piana crixia*:
	$id_del_tag='9564';
	break;
	case *pietra ligure*:
	$id_del_tag='9565';
	break;
	case *plodio*:
	$id_del_tag='9566';
	break;
	case *pontinvrea*:
	$id_del_tag='9567';
	break;
	case *quiliano*:
	$id_del_tag='9568';
	break;
	case *rialto*:
	$id_del_tag='9569';
	break;
	case *roccavignale*:
	$id_del_tag='9570';
	break;
	case *sassello*:
	$id_del_tag='9571';
	break;
	case *spotorno*:
	$id_del_tag='9572';
	break;
	case *stella*:
	$id_del_tag='9573';
	break;
	case *stellanello*:
	$id_del_tag='9574';
	break;
	case *testico*:
	$id_del_tag='9575';
	break;
	case *toirano*:
	$id_del_tag='9576';
	break;
	case *tovo san giacomo*:
	$id_del_tag='9577';
	break;
	case *urbe*:
	$id_del_tag='9578';
	break;
	case *vado ligure*:
	$id_del_tag='9579';
	break;
	case *varazze*:
	$id_del_tag='9580';
	break;
	case *vendone*:
	$id_del_tag='9581';
	break;
	case *vezzi portio*:
	$id_del_tag='9582';
	break;
	case *villanova d'albenga*:
	$id_del_tag='9583';
	break;
	case *zuccarello*:
	$id_del_tag='9584';
	break;
	case *arenzano*:
	$id_del_tag='9585';
	break;
	case *avegno*:
	$id_del_tag='9586';
	break;
	case *bargagli*:
	$id_del_tag='9587';
	break;
	case *bogliasco*:
	$id_del_tag='9588';
	break;
	case *borzonasca*:
	$id_del_tag='9589';
	break;
	case *busalla*:
	$id_del_tag='9590';
	break;
	case *camogli*:
	$id_del_tag='9591';
	break;
	case *campo ligure*:
	$id_del_tag='9592';
	break;
	case *campomorone*:
	$id_del_tag='9593';
	break;
	case *carasco*:
	$id_del_tag='9594';
	break;
	case *casarza ligure*:
	$id_del_tag='9595';
	break;
	case *casella*:
	$id_del_tag='9596';
	break;
	case *castiglione chiavarese*:
	$id_del_tag='9597';
	break;
	case *ceranesi*:
	$id_del_tag='9598';
	break;
	case *chiavari*:
	$id_del_tag='9599';
	break;
	case *cicagna*:
	$id_del_tag='9600';
	break;
	case *cogoleto*:
	$id_del_tag='9601';
	break;
	case *cogorno*:
	$id_del_tag='9602';
	break;
	case *coreglia ligure*:
	$id_del_tag='9603';
	break;
	case *crocefieschi*:
	$id_del_tag='9604';
	break;
	case *davagna*:
	$id_del_tag='9605';
	break;
	case *fascia*:
	$id_del_tag='9606';
	break;
	case *favale di malvaro*:
	$id_del_tag='9607';
	break;
	case *fontanigorda*:
	$id_del_tag='9608';
	break;
	case *gorreto*:
	$id_del_tag='9609';
	break;
	case *isola del cantone*:
	$id_del_tag='9610';
	break;
	case *leivi*:
	$id_del_tag='9611';
	break;
	case *lorsica*:
	$id_del_tag='9612';
	break;
	case *lumarzo*:
	$id_del_tag='9613';
	break;
	case *masone*:
	$id_del_tag='9614';
	break;
	case *mele*:
	$id_del_tag='9615';
	break;
	case *mezzanego*:
	$id_del_tag='9616';
	break;
	case *mignanego*:
	$id_del_tag='9617';
	break;
	case *moconesi*:
	$id_del_tag='9618';
	break;
	case *moneglia*:
	$id_del_tag='9619';
	break;
	case *montebruno*:
	$id_del_tag='9620';
	break;
	case *montoggio*:
	$id_del_tag='9621';
	break;
	case *ne*:
	$id_del_tag='9622';
	break;
	case *neirone*:
	$id_del_tag='9623';
	break;
	case *orero*:
	$id_del_tag='9624';
	break;
	case *pieve ligure*:
	$id_del_tag='9625';
	break;
	case *propata*:
	$id_del_tag='9626';
	break;
	case *rapallo*:
	$id_del_tag='9627';
	break;
	case *recco*:
	$id_del_tag='9628';
	break;
	case *rezzoaglio*:
	$id_del_tag='9629';
	break;
	case *ronco scrivia*:
	$id_del_tag='9630';
	break;
	case *rondanina*:
	$id_del_tag='9631';
	break;
	case *rossiglione*:
	$id_del_tag='9632';
	break;
	case *rovegno*:
	$id_del_tag='9633';
	break;
	case *san colombano certenoli*:
	$id_del_tag='9634';
	break;
	case *santa margherita ligure*:
	$id_del_tag='9635';
	break;
	case *santo stefano d'aveto*:
	$id_del_tag='9636';
	break;
	case *sant'olcese*:
	$id_del_tag='9637';
	break;
	case *savignone*:
	$id_del_tag='9638';
	break;
	case *serra riccò*:
	$id_del_tag='9639';
	break;
	case *sestri levante*:
	$id_del_tag='9640';
	break;
	case *sori*:
	$id_del_tag='9641';
	break;
	case *tiglieto*:
	$id_del_tag='9642';
	break;
	case *torriglia*:
	$id_del_tag='9643';
	break;
	case *tribogna*:
	$id_del_tag='9644';
	break;
	case *uscio*:
	$id_del_tag='9645';
	break;
	case *valbrevenna*:
	$id_del_tag='9646';
	break;
	case *vobbia*:
	$id_del_tag='9647';
	break;
	case *zoagli*:
	$id_del_tag='9648';
	break;
	case *ameglia*:
	$id_del_tag='9649';
	break;
	case *arcola*:
	$id_del_tag='9650';
	break;
	case *beverino*:
	$id_del_tag='9651';
	break;
	case *bolano*:
	$id_del_tag='9652';
	break;
	case *bonassola*:
	$id_del_tag='9653';
	break;
	case *borghetto di vara*:
	$id_del_tag='9654';
	break;
	case *brugnato*:
	$id_del_tag='9655';
	break;
	case *calice al cornoviglio*:
	$id_del_tag='9656';
	break;
	case *carro*:
	$id_del_tag='9657';
	break;
	case *carrodano*:
	$id_del_tag='9658';
	break;
	case *castelnuovo magra*:
	$id_del_tag='9659';
	break;
	case *deiva marina*:
	$id_del_tag='9660';
	break;
	case *follo*:
	$id_del_tag='9661';
	break;
	case *framura*:
	$id_del_tag='9662';
	break;
	case *lerici*:
	$id_del_tag='9663';
	break;
	case *levanto*:
	$id_del_tag='9664';
	break;
	case *maissana*:
	$id_del_tag='9665';
	break;
	case *monterosso al mare*:
	$id_del_tag='9666';
	break;
	case *ortonovo*:
	$id_del_tag='9667';
	break;
	case *pignone*:
	$id_del_tag='9668';
	break;
	case *portovenere*:
	$id_del_tag='9669';
	break;
	case *riccò del golfo di spezia*:
	$id_del_tag='9670';
	break;
	case *riomaggiore*:
	$id_del_tag='9671';
	break;
	case *rocchetta di vara*:
	$id_del_tag='9672';
	break;
	case *santo stefano di magra*:
	$id_del_tag='9673';
	break;
	case *sesta godano*:
	$id_del_tag='9674';
	break;
	case *varese ligure*:
	$id_del_tag='9675';
	break;
	case *vernazza*:
	$id_del_tag='9676';
	break;
	case *vezzano ligure*:
	$id_del_tag='9677';
	break;
	case *zignago*:
	$id_del_tag='9678';
	break;
	case *agra*:
	$id_del_tag='9679';
	break;
	case *albizzate*:
	$id_del_tag='9680';
	break;
	case *angera*:
	$id_del_tag='9681';
	break;
	case *arcisate*:
	$id_del_tag='9682';
	break;
	case *arsago seprio*:
	$id_del_tag='9683';
	break;
	case *azzate*:
	$id_del_tag='9684';
	break;
	case *azzio*:
	$id_del_tag='9685';
	break;
	case *barasso*:
	$id_del_tag='9686';
	break;
	case *bardello*:
	$id_del_tag='9687';
	break;
	case *bedero valcuvia*:
	$id_del_tag='9688';
	break;
	case *besano*:
	$id_del_tag='9689';
	break;
	case *besnate*:
	$id_del_tag='9690';
	break;
	case *besozzo*:
	$id_del_tag='9691';
	break;
	case *biandronno*:
	$id_del_tag='9692';
	break;
	case *bisuschio*:
	$id_del_tag='9693';
	break;
	case *bodio lomnago*:
	$id_del_tag='9694';
	break;
	case *brebbia*:
	$id_del_tag='9695';
	break;
	case *bregano*:
	$id_del_tag='9696';
	break;
	case *brenta*:
	$id_del_tag='9697';
	break;
	case *brezzo di bedero*:
	$id_del_tag='9698';
	break;
	case *brinzio*:
	$id_del_tag='9699';
	break;
	case *brissago-valtravaglia*:
	$id_del_tag='9700';
	break;
	case *brunello*:
	$id_del_tag='9701';
	break;
	case *brusimpiano*:
	$id_del_tag='9702';
	break;
	case *buguggiate*:
	$id_del_tag='9703';
	break;
	case *cadegliano-viconago*:
	$id_del_tag='9704';
	break;
	case *cadrezzate*:
	$id_del_tag='9705';
	break;
	case *cairate*:
	$id_del_tag='9706';
	break;
	case *cantello*:
	$id_del_tag='9707';
	break;
	case *caravate*:
	$id_del_tag='9708';
	break;
	case *cardano al campo*:
	$id_del_tag='9709';
	break;
	case *carnago*:
	$id_del_tag='9710';
	break;
	case *caronno pertusella*:
	$id_del_tag='9711';
	break;
	case *caronno varesino*:
	$id_del_tag='9712';
	break;
	case *casale litta*:
	$id_del_tag='9713';
	break;
	case *casalzuigno*:
	$id_del_tag='9714';
	break;
	case *casciago*:
	$id_del_tag='9715';
	break;
	case *casorate sempione*:
	$id_del_tag='9716';
	break;
	case *cassano magnago*:
	$id_del_tag='9717';
	break;
	case *cassano valcuvia*:
	$id_del_tag='9718';
	break;
	case *castellanza*:
	$id_del_tag='9719';
	break;
	case *castello cabiaglio*:
	$id_del_tag='9720';
	break;
	case *castelseprio*:
	$id_del_tag='9721';
	break;
	case *castelveccana*:
	$id_del_tag='9722';
	break;
	case *castiglione olona*:
	$id_del_tag='9723';
	break;
	case *castronno*:
	$id_del_tag='9724';
	break;
	case *cavaria con premezzo*:
	$id_del_tag='9725';
	break;
	case *cazzago brabbia*:
	$id_del_tag='9726';
	break;
	case *cislago*:
	$id_del_tag='9727';
	break;
	case *cittiglio*:
	$id_del_tag='9728';
	break;
	case *clivio*:
	$id_del_tag='9729';
	break;
	case *cocquio-trevisago*:
	$id_del_tag='9730';
	break;
	case *comabbio*:
	$id_del_tag='9731';
	break;
	case *comerio*:
	$id_del_tag='9732';
	break;
	case *cremenaga*:
	$id_del_tag='9733';
	break;
	case *crosio della valle*:
	$id_del_tag='9734';
	break;
	case *cuasso al monte*:
	$id_del_tag='9735';
	break;
	case *cugliate-fabiasco*:
	$id_del_tag='9736';
	break;
	case *cunardo*:
	$id_del_tag='9737';
	break;
	case *curiglia con monteviasco*:
	$id_del_tag='9738';
	break;
	case *cuveglio*:
	$id_del_tag='9739';
	break;
	case *cuvio*:
	$id_del_tag='9740';
	break;
	case *daverio*:
	$id_del_tag='9741';
	break;
	case *dumenza*:
	$id_del_tag='9742';
	break;
	case *duno*:
	$id_del_tag='9743';
	break;
	case *fagnano olona*:
	$id_del_tag='9744';
	break;
	case *ferno*:
	$id_del_tag='9745';
	break;
	case *ferrera di varese*:
	$id_del_tag='9746';
	break;
	case *gallarate*:
	$id_del_tag='9747';
	break;
	case *galliate lombardo*:
	$id_del_tag='9748';
	break;
	case *gavirate*:
	$id_del_tag='9749';
	break;
	case *gazzada schianno*:
	$id_del_tag='9750';
	break;
	case *gemonio*:
	$id_del_tag='9751';
	break;
	case *gerenzano*:
	$id_del_tag='9752';
	break;
	case *germignaga*:
	$id_del_tag='9753';
	break;
	case *golasecca*:
	$id_del_tag='9754';
	break;
	case *gorla maggiore*:
	$id_del_tag='9755';
	break;
	case *gorla minore*:
	$id_del_tag='9756';
	break;
	case *gornate-olona*:
	$id_del_tag='9757';
	break;
	case *grantola*:
	$id_del_tag='9758';
	break;
	case *inarzo*:
	$id_del_tag='9759';
	break;
	case *induno olona*:
	$id_del_tag='9760';
	break;
	case *ispra*:
	$id_del_tag='9761';
	break;
	case *jerago con orago*:
	$id_del_tag='9762';
	break;
	case *lavena ponte tresa*:
	$id_del_tag='9763';
	break;
	case *laveno-mombello*:
	$id_del_tag='9764';
	break;
	case *leggiuno*:
	$id_del_tag='9765';
	break;
	case *lonate ceppino*:
	$id_del_tag='9766';
	break;
	case *lonate pozzolo*:
	$id_del_tag='9767';
	break;
	case *lozza*:
	$id_del_tag='9768';
	break;
	case *luino*:
	$id_del_tag='9769';
	break;
	case *luvinate*:
	$id_del_tag='9770';
	break;
	case *maccagno*:
	$id_del_tag='9771';
	break;
	case *malgesso*:
	$id_del_tag='9772';
	break;
	case *malnate*:
	$id_del_tag='9773';
	break;
	case *marchirolo*:
	$id_del_tag='9774';
	break;
	case *marnate*:
	$id_del_tag='9775';
	break;
	case *marzio*:
	$id_del_tag='9776';
	break;
	case *masciago primo*:
	$id_del_tag='9777';
	break;
	case *mercallo*:
	$id_del_tag='9778';
	break;
	case *mesenzana*:
	$id_del_tag='9779';
	break;
	case *montegrino valtravaglia*:
	$id_del_tag='9780';
	break;
	case *monvalle*:
	$id_del_tag='9781';
	break;
	case *morazzone*:
	$id_del_tag='9782';
	break;
	case *mornago*:
	$id_del_tag='9783';
	break;
	case *oggiona con santo stefano*:
	$id_del_tag='9784';
	break;
	case *olgiate olona*:
	$id_del_tag='9785';
	break;
	case *origgio*:
	$id_del_tag='9786';
	break;
	case *orino*:
	$id_del_tag='9787';
	break;
	case *osmate*:
	$id_del_tag='9788';
	break;
	case *pino sulla sponda del lago maggiore*:
	$id_del_tag='9789';
	break;
	case *porto ceresio*:
	$id_del_tag='9790';
	break;
	case *porto valtravaglia*:
	$id_del_tag='9791';
	break;
	case *rancio valcuvia*:
	$id_del_tag='9792';
	break;
	case *ranco*:
	$id_del_tag='9793';
	break;
	case *saltrio*:
	$id_del_tag='9794';
	break;
	case *samarate*:
	$id_del_tag='9795';
	break;
	case *sangiano*:
	$id_del_tag='9796';
	break;
	case *sesto calende*:
	$id_del_tag='9797';
	break;
	case *solbiate arno*:
	$id_del_tag='9798';
	break;
	case *solbiate olona*:
	$id_del_tag='9799';
	break;
	case *somma lombardo*:
	$id_del_tag='9800';
	break;
	case *sumirago*:
	$id_del_tag='9801';
	break;
	case *taino*:
	$id_del_tag='9802';
	break;
	case *ternate*:
	$id_del_tag='9803';
	break;
	case *tradate*:
	$id_del_tag='9804';
	break;
	case *travedona-monate*:
	$id_del_tag='9805';
	break;
	case *tronzano lago maggiore*:
	$id_del_tag='9806';
	break;
	case *valganna*:
	$id_del_tag='9807';
	break;
	case *varano borghi*:
	$id_del_tag='9808';
	break;
	case *vedano olona*:
	$id_del_tag='9809';
	break;
	case *veddasca*:
	$id_del_tag='9810';
	break;
	case *venegono inferiore*:
	$id_del_tag='9811';
	break;
	case *venegono superiore*:
	$id_del_tag='9812';
	break;
	case *vergiate*:
	$id_del_tag='9813';
	break;
	case *viggiù*:
	$id_del_tag='9814';
	break;
	case *vizzola ticino*:
	$id_del_tag='9815';
	break;
	case *albavilla*:
	$id_del_tag='9816';
	break;
	case *albese con cassano*:
	$id_del_tag='9817';
	break;
	case *albiolo*:
	$id_del_tag='9818';
	break;
	case *alserio*:
	$id_del_tag='9819';
	break;
	case *anzano del parco*:
	$id_del_tag='9820';
	break;
	case *appiano gentile*:
	$id_del_tag='9821';
	break;
	case *argegno*:
	$id_del_tag='9822';
	break;
	case *arosio*:
	$id_del_tag='9823';
	break;
	case *asso*:
	$id_del_tag='9824';
	break;
	case *barni*:
	$id_del_tag='9825';
	break;
	case *bellagio*:
	$id_del_tag='9826';
	break;
	case *bene lario*:
	$id_del_tag='9827';
	break;
	case *beregazzo con figliaro*:
	$id_del_tag='9828';
	break;
	case *binago*:
	$id_del_tag='9829';
	break;
	case *bizzarone*:
	$id_del_tag='9830';
	break;
	case *blessagno*:
	$id_del_tag='9831';
	break;
	case *blevio*:
	$id_del_tag='9832';
	break;
	case *bregnano*:
	$id_del_tag='9833';
	break;
	case *brenna*:
	$id_del_tag='9834';
	break;
	case *brienno*:
	$id_del_tag='9835';
	break;
	case *brunate*:
	$id_del_tag='9836';
	break;
	case *bulgarograsso*:
	$id_del_tag='9837';
	break;
	case *cabiate*:
	$id_del_tag='9838';
	break;
	case *cadorago*:
	$id_del_tag='9839';
	break;
	case *caglio*:
	$id_del_tag='9840';
	break;
	case *cagno*:
	$id_del_tag='9841';
	break;
	case *canzo*:
	$id_del_tag='9842';
	break;
	case *capiago intimiano*:
	$id_del_tag='9843';
	break;
	case *carate urio*:
	$id_del_tag='9844';
	break;
	case *carbonate*:
	$id_del_tag='9845';
	break;
	case *carimate*:
	$id_del_tag='9846';
	break;
	case *carlazzo*:
	$id_del_tag='9847';
	break;
	case *carugo*:
	$id_del_tag='9848';
	break;
	case *casasco d'intelvi*:
	$id_del_tag='9849';
	break;
	case *caslino d'erba*:
	$id_del_tag='9850';
	break;
	case *casnate con bernate*:
	$id_del_tag='9851';
	break;
	case *cassina rizzardi*:
	$id_del_tag='9852';
	break;
	case *castelmarte*:
	$id_del_tag='9853';
	break;
	case *castelnuovo bozzente*:
	$id_del_tag='9854';
	break;
	case *castiglione d'intelvi*:
	$id_del_tag='9855';
	break;
	case *cavallasca*:
	$id_del_tag='9856';
	break;
	case *cavargna*:
	$id_del_tag='9857';
	break;
	case *cerano d'intelvi*:
	$id_del_tag='9858';
	break;
	case *cermenate*:
	$id_del_tag='9859';
	break;
	case *cirimido*:
	$id_del_tag='9860';
	break;
	case *civenna*:
	$id_del_tag='9861';
	break;
	case *claino con osteno*:
	$id_del_tag='9862';
	break;
	case *colonno*:
	$id_del_tag='9863';
	break;
	case *consiglio di rumo*:
	$id_del_tag='9864';
	break;
	case *corrido*:
	$id_del_tag='9865';
	break;
	case *cremia*:
	$id_del_tag='9866';
	break;
	case *cucciago*:
	$id_del_tag='9867';
	break;
	case *cusino*:
	$id_del_tag='9868';
	break;
	case *dizzasco*:
	$id_del_tag='9869';
	break;
	case *domaso*:
	$id_del_tag='9870';
	break;
	case *dongo*:
	$id_del_tag='9871';
	break;
	case *dosso del liro*:
	$id_del_tag='9872';
	break;
	case *drezzo*:
	$id_del_tag='9873';
	break;
	case *erba*:
	$id_del_tag='9874';
	break;
	case *eupilio*:
	$id_del_tag='9875';
	break;
	case *faggeto lario*:
	$id_del_tag='9876';
	break;
	case *faloppio*:
	$id_del_tag='9877';
	break;
	case *fenegrò*:
	$id_del_tag='9878';
	break;
	case *figino serenza*:
	$id_del_tag='9879';
	break;
	case *fino mornasco*:
	$id_del_tag='9880';
	break;
	case *garzeno*:
	$id_del_tag='9881';
	break;
	case *gera lario*:
	$id_del_tag='9882';
	break;
	case *germasino*:
	$id_del_tag='9883';
	break;
	case *gironico*:
	$id_del_tag='9884';
	break;
	case *grandate*:
	$id_del_tag='9885';
	break;
	case *grandola ed uniti*:
	$id_del_tag='9886';
	break;
	case *gravedona*:
	$id_del_tag='9887';
	break;
	case *griante*:
	$id_del_tag='9888';
	break;
	case *guanzate*:
	$id_del_tag='9889';
	break;
	case *inverigo*:
	$id_del_tag='9890';
	break;
	case *laglio*:
	$id_del_tag='9891';
	break;
	case *laino*:
	$id_del_tag='9892';
	break;
	case *lambrugo*:
	$id_del_tag='9893';
	break;
	case *lanzo d'intelvi*:
	$id_del_tag='9894';
	break;
	case *lasnigo*:
	$id_del_tag='9895';
	break;
	case *lenno*:
	$id_del_tag='9896';
	break;
	case *lezzeno*:
	$id_del_tag='9897';
	break;
	case *limido comasco*:
	$id_del_tag='9898';
	break;
	case *lipomo*:
	$id_del_tag='9899';
	break;
	case *livo*:
	$id_del_tag='9900';
	break;
	case *locate varesino*:
	$id_del_tag='9901';
	break;
	case *lomazzo*:
	$id_del_tag='9902';
	break;
	case *longone al segrino*:
	$id_del_tag='9903';
	break;
	case *luisago*:
	$id_del_tag='9904';
	break;
	case *lurago d'erba*:
	$id_del_tag='9905';
	break;
	case *lurago marinone*:
	$id_del_tag='9906';
	break;
	case *lurate caccivio*:
	$id_del_tag='9907';
	break;
	case *magreglio*:
	$id_del_tag='9908';
	break;
	case *maslianico*:
	$id_del_tag='9909';
	break;
	case *menaggio*:
	$id_del_tag='9910';
	break;
	case *merone*:
	$id_del_tag='9911';
	break;
	case *mezzegra*:
	$id_del_tag='9912';
	break;
	case *moltrasio*:
	$id_del_tag='9913';
	break;
	case *monguzzo*:
	$id_del_tag='9914';
	break;
	case *montano lucino*:
	$id_del_tag='9915';
	break;
	case *montemezzo*:
	$id_del_tag='9916';
	break;
	case *montorfano*:
	$id_del_tag='9917';
	break;
	case *mozzate*:
	$id_del_tag='9918';
	break;
	case *musso*:
	$id_del_tag='9919';
	break;
	case *nesso*:
	$id_del_tag='9920';
	break;
	case *novedrate*:
	$id_del_tag='9921';
	break;
	case *oltrona di san mamette*:
	$id_del_tag='9922';
	break;
	case *orsenigo*:
	$id_del_tag='9923';
	break;
	case *ossuccio*:
	$id_del_tag='9924';
	break;
	case *parè*:
	$id_del_tag='9925';
	break;
	case *peglio*:
	$id_del_tag='9926';
	break;
	case *pellio intelvi*:
	$id_del_tag='9927';
	break;
	case *pianello del lario*:
	$id_del_tag='9928';
	break;
	case *pigra*:
	$id_del_tag='9929';
	break;
	case *plesio*:
	$id_del_tag='9930';
	break;
	case *pognana lario*:
	$id_del_tag='9931';
	break;
	case *ponna*:
	$id_del_tag='9932';
	break;
	case *ponte lambro*:
	$id_del_tag='9933';
	break;
	case *porlezza*:
	$id_del_tag='9934';
	break;
	case *proserpio*:
	$id_del_tag='9935';
	break;
	case *pusiano*:
	$id_del_tag='9936';
	break;
	case *ramponio verna*:
	$id_del_tag='9937';
	break;
	case *rezzago*:
	$id_del_tag='9938';
	break;
	case *rodero*:
	$id_del_tag='9939';
	break;
	case *ronago*:
	$id_del_tag='9940';
	break;
	case *rovellasca*:
	$id_del_tag='9941';
	break;
	case *rovello porro*:
	$id_del_tag='9942';
	break;
	case *sala comacina*:
	$id_del_tag='9943';
	break;
	case *san bartolomeo val cavargna*:
	$id_del_tag='9944';
	break;
	case *san fermo della battaglia*:
	$id_del_tag='9945';
	break;
	case *san nazzaro val cavargna*:
	$id_del_tag='9946';
	break;
	case *san siro*:
	$id_del_tag='9947';
	break;
	case *schignano*:
	$id_del_tag='9948';
	break;
	case *senna comasco*:
	$id_del_tag='9949';
	break;
	case *sorico*:
	$id_del_tag='9950';
	break;
	case *sormano*:
	$id_del_tag='9951';
	break;
	case *stazzona*:
	$id_del_tag='9952';
	break;
	case *tavernerio*:
	$id_del_tag='9953';
	break;
	case *torno*:
	$id_del_tag='9954';
	break;
	case *tremezzo*:
	$id_del_tag='9955';
	break;
	case *trezzone*:
	$id_del_tag='9956';
	break;
	case *turate*:
	$id_del_tag='9957';
	break;
	case *uggiate-trevano*:
	$id_del_tag='9958';
	break;
	case *val rezzo*:
	$id_del_tag='9959';
	break;
	case *valbrona*:
	$id_del_tag='9960';
	break;
	case *valmorea*:
	$id_del_tag='9961';
	break;
	case *valsolda*:
	$id_del_tag='9962';
	break;
	case *veleso*:
	$id_del_tag='9963';
	break;
	case *veniano*:
	$id_del_tag='9964';
	break;
	case *vercana*:
	$id_del_tag='9965';
	break;
	case *vertemate con minoprio*:
	$id_del_tag='9966';
	break;
	case *villa guardia*:
	$id_del_tag='9967';
	break;
	case *zelbio*:
	$id_del_tag='9968';
	break;
	case *albaredo per san marco*:
	$id_del_tag='9969';
	break;
	case *albosaggia*:
	$id_del_tag='9970';
	break;
	case *andalo valtellino*:
	$id_del_tag='9971';
	break;
	case *aprica*:
	$id_del_tag='9972';
	break;
	case *ardenno*:
	$id_del_tag='9973';
	break;
	case *bema*:
	$id_del_tag='9974';
	break;
	case *berbenno di valtellina*:
	$id_del_tag='9975';
	break;
	case *bianzone*:
	$id_del_tag='9976';
	break;
	case *bormio*:
	$id_del_tag='9977';
	break;
	case *buglio in monte*:
	$id_del_tag='9978';
	break;
	case *caiolo*:
	$id_del_tag='9979';
	break;
	case *campodolcino*:
	$id_del_tag='9980';
	break;
	case *caspoggio*:
	$id_del_tag='9981';
	break;
	case *castello dell'acqua*:
	$id_del_tag='9982';
	break;
	case *castione andevenno*:
	$id_del_tag='9983';
	break;
	case *cedrasco*:
	$id_del_tag='9984';
	break;
	case *cercino*:
	$id_del_tag='9985';
	break;
	case *chiavenna*:
	$id_del_tag='9986';
	break;
	case *chiesa in valmalenco*:
	$id_del_tag='9987';
	break;
	case *chiuro*:
	$id_del_tag='9988';
	break;
	case *cino*:
	$id_del_tag='9989';
	break;
	case *civo*:
	$id_del_tag='9990';
	break;
	case *colorina*:
	$id_del_tag='9991';
	break;
	case *cosio valtellino*:
	$id_del_tag='9992';
	break;
	case *dazio*:
	$id_del_tag='9993';
	break;
	case *delebio*:
	$id_del_tag='9994';
	break;
	case *dubino*:
	$id_del_tag='9995';
	break;
	case *faedo valtellino*:
	$id_del_tag='9996';
	break;
	case *forcola*:
	$id_del_tag='9997';
	break;
	case *fusine*:
	$id_del_tag='9998';
	break;
	case *gerola alta*:
	$id_del_tag='9999';
	break;
	case *gordona*:
	$id_del_tag='10000';
	break;
	case *grosio*:
	$id_del_tag='10001';
	break;
	case *grosotto*:
	$id_del_tag='10002';
	break;
	case *lanzada*:
	$id_del_tag='10003';
	break;
	case *lovero*:
	$id_del_tag='10004';
	break;
	case *madesimo*:
	$id_del_tag='10005';
	break;
	case *mantello*:
	$id_del_tag='10006';
	break;
	case *mazzo di valtellina*:
	$id_del_tag='10007';
	break;
	case *mello*:
	$id_del_tag='10008';
	break;
	case *menarola*:
	$id_del_tag='10009';
	break;
	case *mese*:
	$id_del_tag='10010';
	break;
	case *montagna in valtellina*:
	$id_del_tag='10011';
	break;
	case *morbegno*:
	$id_del_tag='10012';
	break;
	case *novate mezzola*:
	$id_del_tag='10013';
	break;
	case *pedesina*:
	$id_del_tag='10014';
	break;
	case *piantedo*:
	$id_del_tag='10015';
	break;
	case *piateda*:
	$id_del_tag='10016';
	break;
	case *piuro*:
	$id_del_tag='10017';
	break;
	case *poggiridenti*:
	$id_del_tag='10018';
	break;
	case *ponte in valtellina*:
	$id_del_tag='10019';
	break;
	case *postalesio*:
	$id_del_tag='10020';
	break;
	case *prata camportaccio*:
	$id_del_tag='10021';
	break;
	case *rasura*:
	$id_del_tag='10022';
	break;
	case *rogolo*:
	$id_del_tag='10023';
	break;
	case *samolaco*:
	$id_del_tag='10024';
	break;
	case *san giacomo filippo*:
	$id_del_tag='10025';
	break;
	case *sernio*:
	$id_del_tag='10026';
	break;
	case *sondalo*:
	$id_del_tag='10027';
	break;
	case *spriana*:
	$id_del_tag='10028';
	break;
	case *talamona*:
	$id_del_tag='10029';
	break;
	case *tartano*:
	$id_del_tag='10030';
	break;
	case *tirano*:
	$id_del_tag='10031';
	break;
	case *torre di santa maria*:
	$id_del_tag='10032';
	break;
	case *tovo di sant'agata*:
	$id_del_tag='10033';
	break;
	case *traona*:
	$id_del_tag='10034';
	break;
	case *tresivio*:
	$id_del_tag='10035';
	break;
	case *val masino*:
	$id_del_tag='10036';
	break;
	case *valdidentro*:
	$id_del_tag='10037';
	break;
	case *valdisotto*:
	$id_del_tag='10038';
	break;
	case *valfurva*:
	$id_del_tag='10039';
	break;
	case *verceia*:
	$id_del_tag='10040';
	break;
	case *vervio*:
	$id_del_tag='10041';
	break;
	case *villa di chiavenna*:
	$id_del_tag='10042';
	break;
	case *villa di tirano*:
	$id_del_tag='10043';
	break;
	case *abbiategrasso*:
	$id_del_tag='10044';
	break;
	case *agrate brianza*:
	$id_del_tag='10045';
	break;
	case *aicurzio*:
	$id_del_tag='10046';
	break;
	case *albairate*:
	$id_del_tag='10047';
	break;
	case *albiate*:
	$id_del_tag='10048';
	break;
	case *arese*:
	$id_del_tag='10049';
	break;
	case *arluno*:
	$id_del_tag='10050';
	break;
	case *assago*:
	$id_del_tag='10051';
	break;
	case *baranzate*:
	$id_del_tag='10052';
	break;
	case *bareggio*:
	$id_del_tag='10053';
	break;
	case *barlassina*:
	$id_del_tag='10054';
	break;
	case *basiano*:
	$id_del_tag='10055';
	break;
	case *bellinzago lombardo*:
	$id_del_tag='10056';
	break;
	case *bellusco*:
	$id_del_tag='10057';
	break;
	case *bernareggio*:
	$id_del_tag='10058';
	break;
	case *bernate ticino*:
	$id_del_tag='10059';
	break;
	case *besana in brianza*:
	$id_del_tag='10060';
	break;
	case *besate*:
	$id_del_tag='10061';
	break;
	case *biassono*:
	$id_del_tag='10062';
	break;
	case *binasco*:
	$id_del_tag='10063';
	break;
	case *boffalora sopra ticino*:
	$id_del_tag='10064';
	break;
	case *bollate*:
	$id_del_tag='10065';
	break;
	case *bovisio-masciago*:
	$id_del_tag='10066';
	break;
	case *bresso*:
	$id_del_tag='10067';
	break;
	case *briosco*:
	$id_del_tag='10068';
	break;
	case *brugherio*:
	$id_del_tag='10069';
	break;
	case *bubbiano*:
	$id_del_tag='10070';
	break;
	case *buccinasco*:
	$id_del_tag='10071';
	break;
	case *burago di molgora*:
	$id_del_tag='10072';
	break;
	case *buscate*:
	$id_del_tag='10073';
	break;
	case *bussero*:
	$id_del_tag='10074';
	break;
	case *busto garolfo*:
	$id_del_tag='10075';
	break;
	case *calvignasco*:
	$id_del_tag='10076';
	break;
	case *cambiago*:
	$id_del_tag='10077';
	break;
	case *camparada*:
	$id_del_tag='10078';
	break;
	case *canegrate*:
	$id_del_tag='10079';
	break;
	case *carate brianza*:
	$id_del_tag='10080';
	break;
	case *carnate*:
	$id_del_tag='10081';
	break;
	case *carpiano*:
	$id_del_tag='10082';
	break;
	case *carugate*:
	$id_del_tag='10083';
	break;
	case *casarile*:
	$id_del_tag='10084';
	break;
	case *casorezzo*:
	$id_del_tag='10085';
	break;
	case *cassano d'adda*:
	$id_del_tag='10086';
	break;
	case *cassina de' pecchi*:
	$id_del_tag='10087';
	break;
	case *cassinetta di lugagnano*:
	$id_del_tag='10088';
	break;
	case *castano primo*:
	$id_del_tag='10089';
	break;
	case *cavenago di brianza*:
	$id_del_tag='10090';
	break;
	case *ceriano laghetto*:
	$id_del_tag='10091';
	break;
	case *cernusco sul naviglio*:
	$id_del_tag='10092';
	break;
	case *cerro al lambro*:
	$id_del_tag='10093';
	break;
	case *cerro maggiore*:
	$id_del_tag='10094';
	break;
	case *cesano boscone*:
	$id_del_tag='10095';
	break;
	case *cesano maderno*:
	$id_del_tag='10096';
	break;
	case *cesate*:
	$id_del_tag='10097';
	break;
	case *cisliano*:
	$id_del_tag='10098';
	break;
	case *cogliate*:
	$id_del_tag='10099';
	break;
	case *cologno monzese*:
	$id_del_tag='10100';
	break;
	case *colturano*:
	$id_del_tag='10101';
	break;
	case *concorezzo*:
	$id_del_tag='10102';
	break;
	case *corbetta*:
	$id_del_tag='10103';
	break;
	case *cormano*:
	$id_del_tag='10104';
	break;
	case *cornaredo*:
	$id_del_tag='10105';
	break;
	case *correzzana*:
	$id_del_tag='10106';
	break;
	case *corsico*:
	$id_del_tag='10107';
	break;
	case *cuggiono*:
	$id_del_tag='10108';
	break;
	case *cusago*:
	$id_del_tag='10109';
	break;
	case *cusano milanino*:
	$id_del_tag='10110';
	break;
	case *dairago*:
	$id_del_tag='10111';
	break;
	case *desio*:
	$id_del_tag='10112';
	break;
	case *dresano*:
	$id_del_tag='10113';
	break;
	case *gaggiano*:
	$id_del_tag='10114';
	break;
	case *garbagnate milanese*:
	$id_del_tag='10115';
	break;
	case *giussano*:
	$id_del_tag='10116';
	break;
	case *gorgonzola*:
	$id_del_tag='10117';
	break;
	case *grezzago*:
	$id_del_tag='10118';
	break;
	case *gudo visconti*:
	$id_del_tag='10119';
	break;
	case *inveruno*:
	$id_del_tag='10120';
	break;
	case *inzago*:
	$id_del_tag='10121';
	break;
	case *lacchiarella*:
	$id_del_tag='10122';
	break;
	case *lainate*:
	$id_del_tag='10123';
	break;
	case *lazzate*:
	$id_del_tag='10124';
	break;
	case *lesmo*:
	$id_del_tag='10125';
	break;
	case *limbiate*:
	$id_del_tag='10126';
	break;
	case *liscate*:
	$id_del_tag='10127';
	break;
	case *lissone*:
	$id_del_tag='10128';
	break;
	case *locate di triulzi*:
	$id_del_tag='10129';
	break;
	case *macherio*:
	$id_del_tag='10130';
	break;
	case *magenta*:
	$id_del_tag='10131';
	break;
	case *magnago*:
	$id_del_tag='10132';
	break;
	case *marcallo con casone*:
	$id_del_tag='10133';
	break;
	case *masate*:
	$id_del_tag='10134';
	break;
	case *meda*:
	$id_del_tag='10135';
	break;
	case *mediglia*:
	$id_del_tag='10136';
	break;
	case *melegnano*:
	$id_del_tag='10137';
	break;
	case *melzo*:
	$id_del_tag='10138';
	break;
	case *mesero*:
	$id_del_tag='10139';
	break;
	case *mezzago*:
	$id_del_tag='10140';
	break;
	case *misinto*:
	$id_del_tag='10141';
	break;
	case *morimondo*:
	$id_del_tag='10142';
	break;
	case *motta visconti*:
	$id_del_tag='10143';
	break;
	case *muggiò*:
	$id_del_tag='10144';
	break;
	case *nerviano*:
	$id_del_tag='10145';
	break;
	case *nosate*:
	$id_del_tag='10146';
	break;
	case *nova milanese*:
	$id_del_tag='10147';
	break;
	case *novate milanese*:
	$id_del_tag='10148';
	break;
	case *noviglio*:
	$id_del_tag='10149';
	break;
	case *ornago*:
	$id_del_tag='10150';
	break;
	case *ossona*:
	$id_del_tag='10151';
	break;
	case *ozzero*:
	$id_del_tag='10152';
	break;
	case *paderno dugnano*:
	$id_del_tag='10153';
	break;
	case *pantigliate*:
	$id_del_tag='10154';
	break;
	case *parabiago*:
	$id_del_tag='10155';
	break;
	case *paullo*:
	$id_del_tag='10156';
	break;
	case *peschiera borromeo*:
	$id_del_tag='10157';
	break;
	case *pessano con bornago*:
	$id_del_tag='10158';
	break;
	case *pieve emanuele*:
	$id_del_tag='10159';
	break;
	case *pioltello*:
	$id_del_tag='10160';
	break;
	case *pogliano milanese*:
	$id_del_tag='10161';
	break;
	case *pozzo d'adda*:
	$id_del_tag='10162';
	break;
	case *pozzuolo martesana*:
	$id_del_tag='10163';
	break;
	case *pregnana milanese*:
	$id_del_tag='10164';
	break;
	case *renate*:
	$id_del_tag='10165';
	break;
	case *rescaldina*:
	$id_del_tag='10166';
	break;
	case *robecchetto con induno*:
	$id_del_tag='10167';
	break;
	case *robecco sul naviglio*:
	$id_del_tag='10168';
	break;
	case *rodano*:
	$id_del_tag='10169';
	break;
	case *ronco briantino*:
	$id_del_tag='10170';
	break;
	case *rosate*:
	$id_del_tag='10171';
	break;
	case *rozzano*:
	$id_del_tag='10172';
	break;
	case *san colombano al lambro*:
	$id_del_tag='10173';
	break;
	case *san giorgio su legnano*:
	$id_del_tag='10174';
	break;
	case *san giuliano milanese*:
	$id_del_tag='10175';
	break;
	case *san vittore olona*:
	$id_del_tag='10176';
	break;
	case *san zenone al lambro*:
	$id_del_tag='10177';
	break;
	case *santo stefano ticino*:
	$id_del_tag='10178';
	break;
	case *sedriano*:
	$id_del_tag='10179';
	break;
	case *segrate*:
	$id_del_tag='10180';
	break;
	case *senago*:
	$id_del_tag='10181';
	break;
	case *seregno*:
	$id_del_tag='10182';
	break;
	case *sesto san giovanni*:
	$id_del_tag='10183';
	break;
	case *settala*:
	$id_del_tag='10184';
	break;
	case *settimo milanese*:
	$id_del_tag='10185';
	break;
	case *seveso*:
	$id_del_tag='10186';
	break;
	case *sovico*:
	$id_del_tag='10187';
	break;
	case *sulbiate*:
	$id_del_tag='10188';
	break;
	case *trezzano rosa*:
	$id_del_tag='10189';
	break;
	case *trezzano sul naviglio*:
	$id_del_tag='10190';
	break;
	case *trezzo sull'adda*:
	$id_del_tag='10191';
	break;
	case *tribiano*:
	$id_del_tag='10192';
	break;
	case *triuggio*:
	$id_del_tag='10193';
	break;
	case *truccazzano*:
	$id_del_tag='10194';
	break;
	case *turbigo*:
	$id_del_tag='10195';
	break;
	case *usmate velate*:
	$id_del_tag='10196';
	break;
	case *vanzaghello*:
	$id_del_tag='10197';
	break;
	case *vanzago*:
	$id_del_tag='10198';
	break;
	case *vaprio d'adda*:
	$id_del_tag='10199';
	break;
	case *varedo*:
	$id_del_tag='10200';
	break;
	case *vedano al lambro*:
	$id_del_tag='10201';
	break;
	case *veduggio con colzano*:
	$id_del_tag='10202';
	break;
	case *verano brianza*:
	$id_del_tag='10203';
	break;
	case *vermezzo*:
	$id_del_tag='10204';
	break;
	case *vernate*:
	$id_del_tag='10205';
	break;
	case *vignate*:
	$id_del_tag='10206';
	break;
	case *villa cortese*:
	$id_del_tag='10207';
	break;
	case *villasanta*:
	$id_del_tag='10208';
	break;
	case *vimodrone*:
	$id_del_tag='10209';
	break;
	case *vittuone*:
	$id_del_tag='10210';
	break;
	case *vizzolo predabissi*:
	$id_del_tag='10211';
	break;
	case *zelo surrigone*:
	$id_del_tag='10212';
	break;
	case *zibido san giacomo*:
	$id_del_tag='10213';
	break;
	case *adrara san martino*:
	$id_del_tag='10214';
	break;
	case *adrara san rocco*:
	$id_del_tag='10215';
	break;
	case *albano sant'alessandro*:
	$id_del_tag='10216';
	break;
	case *albino*:
	$id_del_tag='10217';
	break;
	case *algua*:
	$id_del_tag='10218';
	break;
	case *almè*:
	$id_del_tag='10219';
	break;
	case *almenno san bartolomeo*:
	$id_del_tag='10220';
	break;
	case *almenno san salvatore*:
	$id_del_tag='10221';
	break;
	case *alzano lombardo*:
	$id_del_tag='10222';
	break;
	case *ambivere*:
	$id_del_tag='10223';
	break;
	case *antegnate*:
	$id_del_tag='10224';
	break;
	case *arcene*:
	$id_del_tag='10225';
	break;
	case *ardesio*:
	$id_del_tag='10226';
	break;
	case *arzago d'adda*:
	$id_del_tag='10227';
	break;
	case *averara*:
	$id_del_tag='10228';
	break;
	case *aviatico*:
	$id_del_tag='10229';
	break;
	case *azzano san paolo*:
	$id_del_tag='10230';
	break;
	case *azzone*:
	$id_del_tag='10231';
	break;
	case *bagnatica*:
	$id_del_tag='10232';
	break;
	case *barbata*:
	$id_del_tag='10233';
	break;
	case *bariano*:
	$id_del_tag='10234';
	break;
	case *barzana*:
	$id_del_tag='10235';
	break;
	case *bedulita*:
	$id_del_tag='10236';
	break;
	case *berbenno*:
	$id_del_tag='10237';
	break;
	case *berzo san fermo*:
	$id_del_tag='10238';
	break;
	case *bianzano*:
	$id_del_tag='10239';
	break;
	case *blello*:
	$id_del_tag='10240';
	break;
	case *bolgare*:
	$id_del_tag='10241';
	break;
	case *boltiere*:
	$id_del_tag='10242';
	break;
	case *bonate sopra*:
	$id_del_tag='10243';
	break;
	case *bonate sotto*:
	$id_del_tag='10244';
	break;
	case *borgo di terzo*:
	$id_del_tag='10245';
	break;
	case *bossico*:
	$id_del_tag='10246';
	break;
	case *bottanuco*:
	$id_del_tag='10247';
	break;
	case *bracca*:
	$id_del_tag='10248';
	break;
	case *branzi*:
	$id_del_tag='10249';
	break;
	case *brembate*:
	$id_del_tag='10250';
	break;
	case *brembate di sopra*:
	$id_del_tag='10251';
	break;
	case *brembilla*:
	$id_del_tag='10252';
	break;
	case *brignano gera d'adda*:
	$id_del_tag='10253';
	break;
	case *brumano*:
	$id_del_tag='10254';
	break;
	case *brusaporto*:
	$id_del_tag='10255';
	break;
	case *calcinate*:
	$id_del_tag='10256';
	break;
	case *calcio*:
	$id_del_tag='10257';
	break;
	case *calusco d'adda*:
	$id_del_tag='10258';
	break;
	case *calvenzano*:
	$id_del_tag='10259';
	break;
	case *camerata cornello*:
	$id_del_tag='10260';
	break;
	case *canonica d'adda*:
	$id_del_tag='10261';
	break;
	case *capizzone*:
	$id_del_tag='10262';
	break;
	case *capriate san gervasio*:
	$id_del_tag='10263';
	break;
	case *caprino bergamasco*:
	$id_del_tag='10264';
	break;
	case *caravaggio*:
	$id_del_tag='10265';
	break;
	case *carobbio degli angeli*:
	$id_del_tag='10266';
	break;
	case *carona*:
	$id_del_tag='10267';
	break;
	case *carvico*:
	$id_del_tag='10268';
	break;
	case *casazza*:
	$id_del_tag='10269';
	break;
	case *casirate d'adda*:
	$id_del_tag='10270';
	break;
	case *casnigo*:
	$id_del_tag='10271';
	break;
	case *cassiglio*:
	$id_del_tag='10272';
	break;
	case *castel rozzone*:
	$id_del_tag='10273';
	break;
	case *castelli calepio*:
	$id_del_tag='10274';
	break;
	case *castione della presolana*:
	$id_del_tag='10275';
	break;
	case *castro*:
	$id_del_tag='10276';
	break;
	case *cavernago*:
	$id_del_tag='10277';
	break;
	case *cazzano sant'andrea*:
	$id_del_tag='10278';
	break;
	case *cenate sopra*:
	$id_del_tag='10279';
	break;
	case *cenate sotto*:
	$id_del_tag='10280';
	break;
	case *cene*:
	$id_del_tag='10281';
	break;
	case *cerete*:
	$id_del_tag='10282';
	break;
	case *chignolo d'isola*:
	$id_del_tag='10283';
	break;
	case *chiuduno*:
	$id_del_tag='10284';
	break;
	case *cisano bergamasco*:
	$id_del_tag='10285';
	break;
	case *ciserano*:
	$id_del_tag='10286';
	break;
	case *cividate al piano*:
	$id_del_tag='10287';
	break;
	case *clusone*:
	$id_del_tag='10288';
	break;
	case *colere*:
	$id_del_tag='10289';
	break;
	case *cologno al serio*:
	$id_del_tag='10290';
	break;
	case *colzate*:
	$id_del_tag='10291';
	break;
	case *comun nuovo*:
	$id_del_tag='10292';
	break;
	case *corna imagna*:
	$id_del_tag='10293';
	break;
	case *cornalba*:
	$id_del_tag='10294';
	break;
	case *cortenuova*:
	$id_del_tag='10295';
	break;
	case *costa di mezzate*:
	$id_del_tag='10296';
	break;
	case *costa serina*:
	$id_del_tag='10297';
	break;
	case *costa valle imagna*:
	$id_del_tag='10298';
	break;
	case *costa volpino*:
	$id_del_tag='10299';
	break;
	case *covo*:
	$id_del_tag='10300';
	break;
	case *credaro*:
	$id_del_tag='10301';
	break;
	case *curno*:
	$id_del_tag='10302';
	break;
	case *cusio*:
	$id_del_tag='10303';
	break;
	case *dalmine*:
	$id_del_tag='10304';
	break;
	case *dossena*:
	$id_del_tag='10305';
	break;
	case *endine gaiano*:
	$id_del_tag='10306';
	break;
	case *entratico*:
	$id_del_tag='10307';
	break;
	case *fara gera d'adda*:
	$id_del_tag='10308';
	break;
	case *fara olivana con sola*:
	$id_del_tag='10309';
	break;
	case *filago*:
	$id_del_tag='10310';
	break;
	case *fino del monte*:
	$id_del_tag='10311';
	break;
	case *fiorano al serio*:
	$id_del_tag='10312';
	break;
	case *fontanella*:
	$id_del_tag='10313';
	break;
	case *fonteno*:
	$id_del_tag='10314';
	break;
	case *foppolo*:
	$id_del_tag='10315';
	break;
	case *foresto sparso*:
	$id_del_tag='10316';
	break;
	case *fornovo san giovanni*:
	$id_del_tag='10317';
	break;
	case *fuipiano valle imagna*:
	$id_del_tag='10318';
	break;
	case *gandellino*:
	$id_del_tag='10319';
	break;
	case *gandino*:
	$id_del_tag='10320';
	break;
	case *gandosso*:
	$id_del_tag='10321';
	break;
	case *gaverina terme*:
	$id_del_tag='10322';
	break;
	case *gazzaniga*:
	$id_del_tag='10323';
	break;
	case *gerosa*:
	$id_del_tag='10324';
	break;
	case *ghisalba*:
	$id_del_tag='10325';
	break;
	case *gorlago*:
	$id_del_tag='10326';
	break;
	case *gorle*:
	$id_del_tag='10327';
	break;
	case *gorno*:
	$id_del_tag='10328';
	break;
	case *grassobbio*:
	$id_del_tag='10329';
	break;
	case *gromo*:
	$id_del_tag='10330';
	break;
	case *grone*:
	$id_del_tag='10331';
	break;
	case *grumello del monte*:
	$id_del_tag='10332';
	break;
	case *isola di fondra*:
	$id_del_tag='10333';
	break;
	case *isso*:
	$id_del_tag='10334';
	break;
	case *lallio*:
	$id_del_tag='10335';
	break;
	case *leffe*:
	$id_del_tag='10336';
	break;
	case *lenna*:
	$id_del_tag='10337';
	break;
	case *levate*:
	$id_del_tag='10338';
	break;
	case *locatello*:
	$id_del_tag='10339';
	break;
	case *lovere*:
	$id_del_tag='10340';
	break;
	case *lurano*:
	$id_del_tag='10341';
	break;
	case *luzzana*:
	$id_del_tag='10342';
	break;
	case *madone*:
	$id_del_tag='10343';
	break;
	case *mapello*:
	$id_del_tag='10344';
	break;
	case *martinengo*:
	$id_del_tag='10345';
	break;
	case *medolago*:
	$id_del_tag='10346';
	break;
	case *mezzoldo*:
	$id_del_tag='10347';
	break;
	case *misano di gera d'adda*:
	$id_del_tag='10348';
	break;
	case *moio de' calvi*:
	$id_del_tag='10349';
	break;
	case *monasterolo del castello*:
	$id_del_tag='10350';
	break;
	case *montello*:
	$id_del_tag='10351';
	break;
	case *morengo*:
	$id_del_tag='10352';
	break;
	case *mornico al serio*:
	$id_del_tag='10353';
	break;
	case *mozzanica*:
	$id_del_tag='10354';
	break;
	case *mozzo*:
	$id_del_tag='10355';
	break;
	case *olmo al brembo*:
	$id_del_tag='10356';
	break;
	case *oltre il colle*:
	$id_del_tag='10357';
	break;
	case *oltressenda alta*:
	$id_del_tag='10358';
	break;
	case *oneta*:
	$id_del_tag='10359';
	break;
	case *onore*:
	$id_del_tag='10360';
	break;
	case *orio al serio*:
	$id_del_tag='10361';
	break;
	case *ornica*:
	$id_del_tag='10362';
	break;
	case *osio sopra*:
	$id_del_tag='10363';
	break;
	case *osio sotto*:
	$id_del_tag='10364';
	break;
	case *pagazzano*:
	$id_del_tag='10365';
	break;
	case *paladina*:
	$id_del_tag='10366';
	break;
	case *palazzago*:
	$id_del_tag='10367';
	break;
	case *palosco*:
	$id_del_tag='10368';
	break;
	case *parre*:
	$id_del_tag='10369';
	break;
	case *parzanica*:
	$id_del_tag='10370';
	break;
	case *pedrengo*:
	$id_del_tag='10371';
	break;
	case *peia*:
	$id_del_tag='10372';
	break;
	case *pianico*:
	$id_del_tag='10373';
	break;
	case *piario*:
	$id_del_tag='10374';
	break;
	case *piazza brembana*:
	$id_del_tag='10375';
	break;
	case *piazzatorre*:
	$id_del_tag='10376';
	break;
	case *piazzolo*:
	$id_del_tag='10377';
	break;
	case *pognano*:
	$id_del_tag='10378';
	break;
	case *ponte nossa*:
	$id_del_tag='10379';
	break;
	case *ponte san pietro*:
	$id_del_tag='10380';
	break;
	case *ponteranica*:
	$id_del_tag='10381';
	break;
	case *pontida*:
	$id_del_tag='10382';
	break;
	case *pontirolo nuovo*:
	$id_del_tag='10383';
	break;
	case *pradalunga*:
	$id_del_tag='10384';
	break;
	case *predore*:
	$id_del_tag='10385';
	break;
	case *premolo*:
	$id_del_tag='10386';
	break;
	case *presezzo*:
	$id_del_tag='10387';
	break;
	case *pumenengo*:
	$id_del_tag='10388';
	break;
	case *ranica*:
	$id_del_tag='10389';
	break;
	case *ranzanico*:
	$id_del_tag='10390';
	break;
	case *riva di solto*:
	$id_del_tag='10391';
	break;
	case *rogno*:
	$id_del_tag='10392';
	break;
	case *romano di lombardia*:
	$id_del_tag='10393';
	break;
	case *roncobello*:
	$id_del_tag='10394';
	break;
	case *roncola*:
	$id_del_tag='10395';
	break;
	case *rota d'imagna*:
	$id_del_tag='10396';
	break;
	case *rovetta*:
	$id_del_tag='10397';
	break;
	case *san giovanni bianco*:
	$id_del_tag='10398';
	break;
	case *san paolo d'argon*:
	$id_del_tag='10399';
	break;
	case *santa brigida*:
	$id_del_tag='10400';
	break;
	case *sant'omobono terme*:
	$id_del_tag='10401';
	break;
	case *sarnico*:
	$id_del_tag='10402';
	break;
	case *scanzorosciate*:
	$id_del_tag='10403';
	break;
	case *schilpario*:
	$id_del_tag='10404';
	break;
	case *sedrina*:
	$id_del_tag='10405';
	break;
	case *selvino*:
	$id_del_tag='10406';
	break;
	case *seriate*:
	$id_del_tag='10407';
	break;
	case *serina*:
	$id_del_tag='10408';
	break;
	case *solto collina*:
	$id_del_tag='10409';
	break;
	case *solza*:
	$id_del_tag='10410';
	break;
	case *songavazzo*:
	$id_del_tag='10411';
	break;
	case *sorisole*:
	$id_del_tag='10412';
	break;
	case *sotto il monte giovanni xxiii*:
	$id_del_tag='10413';
	break;
	case *sovere*:
	$id_del_tag='10414';
	break;
	case *spinone al lago*:
	$id_del_tag='10415';
	break;
	case *spirano*:
	$id_del_tag='10416';
	break;
	case *stezzano*:
	$id_del_tag='10417';
	break;
	case *strozza*:
	$id_del_tag='10418';
	break;
	case *suisio*:
	$id_del_tag='10419';
	break;
	case *taleggio*:
	$id_del_tag='10420';
	break;
	case *tavernola bergamasca*:
	$id_del_tag='10421';
	break;
	case *telgate*:
	$id_del_tag='10422';
	break;
	case *terno d'isola*:
	$id_del_tag='10423';
	break;
	case *torre boldone*:
	$id_del_tag='10424';
	break;
	case *torre de' roveri*:
	$id_del_tag='10425';
	break;
	case *trescore balneario*:
	$id_del_tag='10426';
	break;
	case *treviglio*:
	$id_del_tag='10427';
	break;
	case *treviolo*:
	$id_del_tag='10428';
	break;
	case *ubiale clanezzo*:
	$id_del_tag='10429';
	break;
	case *urgnano*:
	$id_del_tag='10430';
	break;
	case *valbondione*:
	$id_del_tag='10431';
	break;
	case *valbrembo*:
	$id_del_tag='10432';
	break;
	case *valgoglio*:
	$id_del_tag='10433';
	break;
	case *valleve*:
	$id_del_tag='10434';
	break;
	case *valnegra*:
	$id_del_tag='10435';
	break;
	case *valsecca*:
	$id_del_tag='10436';
	break;
	case *valtorta*:
	$id_del_tag='10437';
	break;
	case *vedeseta*:
	$id_del_tag='10438';
	break;
	case *verdellino*:
	$id_del_tag='10439';
	break;
	case *verdello*:
	$id_del_tag='10440';
	break;
	case *vertova*:
	$id_del_tag='10441';
	break;
	case *viadanica*:
	$id_del_tag='10442';
	break;
	case *vigano san martino*:
	$id_del_tag='10443';
	break;
	case *vigolo*:
	$id_del_tag='10444';
	break;
	case *villa d'adda*:
	$id_del_tag='10445';
	break;
	case *villa d'almè*:
	$id_del_tag='10446';
	break;
	case *villa di serio*:
	$id_del_tag='10447';
	break;
	case *villa d'ogna*:
	$id_del_tag='10448';
	break;
	case *villongo*:
	$id_del_tag='10449';
	break;
	case *vilminore di scalve*:
	$id_del_tag='10450';
	break;
	case *zandobbio*:
	$id_del_tag='10451';
	break;
	case *zanica*:
	$id_del_tag='10452';
	break;
	case *zogno*:
	$id_del_tag='10453';
	break;
	case *acquafredda*:
	$id_del_tag='10454';
	break;
	case *adro*:
	$id_del_tag='10455';
	break;
	case *agnosine*:
	$id_del_tag='10456';
	break;
	case *alfianello*:
	$id_del_tag='10457';
	break;
	case *anfo*:
	$id_del_tag='10458';
	break;
	case *angolo terme*:
	$id_del_tag='10459';
	break;
	case *artogne*:
	$id_del_tag='10460';
	break;
	case *azzano mella*:
	$id_del_tag='10461';
	break;
	case *bagnolo mella*:
	$id_del_tag='10462';
	break;
	case *bagolino*:
	$id_del_tag='10463';
	break;
	case *barbariga*:
	$id_del_tag='10464';
	break;
	case *barghe*:
	$id_del_tag='10465';
	break;
	case *bassano bresciano*:
	$id_del_tag='10466';
	break;
	case *bedizzole*:
	$id_del_tag='10467';
	break;
	case *berlingo*:
	$id_del_tag='10468';
	break;
	case *berzo demo*:
	$id_del_tag='10469';
	break;
	case *berzo inferiore*:
	$id_del_tag='10470';
	break;
	case *bienno*:
	$id_del_tag='10471';
	break;
	case *bione*:
	$id_del_tag='10472';
	break;
	case *borgo san giacomo*:
	$id_del_tag='10473';
	break;
	case *borgosatollo*:
	$id_del_tag='10474';
	break;
	case *borno*:
	$id_del_tag='10475';
	break;
	case *botticino*:
	$id_del_tag='10476';
	break;
	case *bovegno*:
	$id_del_tag='10477';
	break;
	case *bovezzo*:
	$id_del_tag='10478';
	break;
	case *brandico*:
	$id_del_tag='10479';
	break;
	case *braone*:
	$id_del_tag='10480';
	break;
	case *breno*:
	$id_del_tag='10481';
	break;
	case *brione*:
	$id_del_tag='10482';
	break;
	case *caino*:
	$id_del_tag='10483';
	break;
	case *calcinato*:
	$id_del_tag='10484';
	break;
	case *calvagese della riviera*:
	$id_del_tag='10485';
	break;
	case *calvisano*:
	$id_del_tag='10486';
	break;
	case *capo di ponte*:
	$id_del_tag='10487';
	break;
	case *capovalle*:
	$id_del_tag='10488';
	break;
	case *capriano del colle*:
	$id_del_tag='10489';
	break;
	case *capriolo*:
	$id_del_tag='10490';
	break;
	case *carpenedolo*:
	$id_del_tag='10491';
	break;
	case *castegnato*:
	$id_del_tag='10492';
	break;
	case *castel mella*:
	$id_del_tag='10493';
	break;
	case *castelcovati*:
	$id_del_tag='10494';
	break;
	case *castenedolo*:
	$id_del_tag='10495';
	break;
	case *casto*:
	$id_del_tag='10496';
	break;
	case *castrezzato*:
	$id_del_tag='10497';
	break;
	case *cazzago san martino*:
	$id_del_tag='10498';
	break;
	case *cedegolo*:
	$id_del_tag='10499';
	break;
	case *cellatica*:
	$id_del_tag='10500';
	break;
	case *cerveno*:
	$id_del_tag='10501';
	break;
	case *ceto*:
	$id_del_tag='10502';
	break;
	case *cevo*:
	$id_del_tag='10503';
	break;
	case *cigole*:
	$id_del_tag='10504';
	break;
	case *cividate camuno*:
	$id_del_tag='10505';
	break;
	case *coccaglio*:
	$id_del_tag='10506';
	break;
	case *collebeato*:
	$id_del_tag='10507';
	break;
	case *collio*:
	$id_del_tag='10508';
	break;
	case *cologne*:
	$id_del_tag='10509';
	break;
	case *comezzano-cizzago*:
	$id_del_tag='10510';
	break;
	case *concesio*:
	$id_del_tag='10511';
	break;
	case *corte franca*:
	$id_del_tag='10512';
	break;
	case *corteno golgi*:
	$id_del_tag='10513';
	break;
	case *corzano*:
	$id_del_tag='10514';
	break;
	case *darfo boario terme*:
	$id_del_tag='10515';
	break;
	case *dello*:
	$id_del_tag='10516';
	break;
	case *desenzano del garda*:
	$id_del_tag='10517';
	break;
	case *edolo*:
	$id_del_tag='10518';
	break;
	case *erbusco*:
	$id_del_tag='10519';
	break;
	case *esine*:
	$id_del_tag='10520';
	break;
	case *fiesse*:
	$id_del_tag='10521';
	break;
	case *flero*:
	$id_del_tag='10522';
	break;
	case *gambara*:
	$id_del_tag='10523';
	break;
	case *gardone val trompia*:
	$id_del_tag='10524';
	break;
	case *gargnano*:
	$id_del_tag='10525';
	break;
	case *gavardo*:
	$id_del_tag='10526';
	break;
	case *gianico*:
	$id_del_tag='10527';
	break;
	case *gottolengo*:
	$id_del_tag='10528';
	break;
	case *gussago*:
	$id_del_tag='10529';
	break;
	case *idro*:
	$id_del_tag='10530';
	break;
	case *incudine*:
	$id_del_tag='10531';
	break;
	case *irma*:
	$id_del_tag='10532';
	break;
	case *iseo*:
	$id_del_tag='10533';
	break;
	case *isorella*:
	$id_del_tag='10534';
	break;
	case *lavenone*:
	$id_del_tag='10535';
	break;
	case *leno*:
	$id_del_tag='10536';
	break;
	case *limone sul garda*:
	$id_del_tag='10537';
	break;
	case *lodrino*:
	$id_del_tag='10538';
	break;
	case *lograto*:
	$id_del_tag='10539';
	break;
	case *lonato del garda*:
	$id_del_tag='10540';
	break;
	case *longhena*:
	$id_del_tag='10541';
	break;
	case *losine*:
	$id_del_tag='10542';
	break;
	case *lozio*:
	$id_del_tag='10543';
	break;
	case *lumezzane*:
	$id_del_tag='10544';
	break;
	case *maclodio*:
	$id_del_tag='10545';
	break;
	case *magasa*:
	$id_del_tag='10546';
	break;
	case *mairano*:
	$id_del_tag='10547';
	break;
	case *malegno*:
	$id_del_tag='10548';
	break;
	case *malonno*:
	$id_del_tag='10549';
	break;
	case *manerba del garda*:
	$id_del_tag='10550';
	break;
	case *manerbio*:
	$id_del_tag='10551';
	break;
	case *marcheno*:
	$id_del_tag='10552';
	break;
	case *marmentino*:
	$id_del_tag='10553';
	break;
	case *marone*:
	$id_del_tag='10554';
	break;
	case *mazzano*:
	$id_del_tag='10555';
	break;
	case *milzano*:
	$id_del_tag='10556';
	break;
	case *moniga del garda*:
	$id_del_tag='10557';
	break;
	case *monno*:
	$id_del_tag='10558';
	break;
	case *monte isola*:
	$id_del_tag='10559';
	break;
	case *monticelli brusati*:
	$id_del_tag='10560';
	break;
	case *montichiari*:
	$id_del_tag='10561';
	break;
	case *montirone*:
	$id_del_tag='10562';
	break;
	case *mura*:
	$id_del_tag='10563';
	break;
	case *muscoline*:
	$id_del_tag='10564';
	break;
	case *nave*:
	$id_del_tag='10565';
	break;
	case *niardo*:
	$id_del_tag='10566';
	break;
	case *nuvolento*:
	$id_del_tag='10567';
	break;
	case *nuvolera*:
	$id_del_tag='10568';
	break;
	case *odolo*:
	$id_del_tag='10569';
	break;
	case *offlaga*:
	$id_del_tag='10570';
	break;
	case *ome*:
	$id_del_tag='10571';
	break;
	case *ono san pietro*:
	$id_del_tag='10572';
	break;
	case *orzinuovi*:
	$id_del_tag='10573';
	break;
	case *orzivecchi*:
	$id_del_tag='10574';
	break;
	case *ospitaletto*:
	$id_del_tag='10575';
	break;
	case *ossimo*:
	$id_del_tag='10576';
	break;
	case *padenghe sul garda*:
	$id_del_tag='10577';
	break;
	case *paderno franciacorta*:
	$id_del_tag='10578';
	break;
	case *paisco loveno*:
	$id_del_tag='10579';
	break;
	case *paitone*:
	$id_del_tag='10580';
	break;
	case *palazzolo sull'oglio*:
	$id_del_tag='10581';
	break;
	case *paratico*:
	$id_del_tag='10582';
	break;
	case *paspardo*:
	$id_del_tag='10583';
	break;
	case *passirano*:
	$id_del_tag='10584';
	break;
	case *pavone del mella*:
	$id_del_tag='10585';
	break;
	case *pertica alta*:
	$id_del_tag='10586';
	break;
	case *pertica bassa*:
	$id_del_tag='10587';
	break;
	case *pezzaze*:
	$id_del_tag='10588';
	break;
	case *pian camuno*:
	$id_del_tag='10589';
	break;
	case *piancogno*:
	$id_del_tag='10590';
	break;
	case *pisogne*:
	$id_del_tag='10591';
	break;
	case *polaveno*:
	$id_del_tag='10592';
	break;
	case *polpenazze del garda*:
	$id_del_tag='10593';
	break;
	case *pompiano*:
	$id_del_tag='10594';
	break;
	case *poncarale*:
	$id_del_tag='10595';
	break;
	case *pontevico*:
	$id_del_tag='10596';
	break;
	case *pontoglio*:
	$id_del_tag='10597';
	break;
	case *pozzolengo*:
	$id_del_tag='10598';
	break;
	case *pralboino*:
	$id_del_tag='10599';
	break;
	case *preseglie*:
	$id_del_tag='10600';
	break;
	case *prestine*:
	$id_del_tag='10601';
	break;
	case *prevalle*:
	$id_del_tag='10602';
	break;
	case *provaglio d'iseo*:
	$id_del_tag='10603';
	break;
	case *provaglio val sabbia*:
	$id_del_tag='10604';
	break;
	case *puegnago sul garda*:
	$id_del_tag='10605';
	break;
	case *quinzano d'oglio*:
	$id_del_tag='10606';
	break;
	case *remedello*:
	$id_del_tag='10607';
	break;
	case *rezzato*:
	$id_del_tag='10608';
	break;
	case *roccafranca*:
	$id_del_tag='10609';
	break;
	case *rodengo-saiano*:
	$id_del_tag='10610';
	break;
	case *roè volciano*:
	$id_del_tag='10611';
	break;
	case *roncadelle*:
	$id_del_tag='10612';
	break;
	case *rovato*:
	$id_del_tag='10613';
	break;
	case *rudiano*:
	$id_del_tag='10614';
	break;
	case *sabbio chiese*:
	$id_del_tag='10615';
	break;
	case *sale marasino*:
	$id_del_tag='10616';
	break;
	case *salò*:
	$id_del_tag='10617';
	break;
	case *san felice del benaco*:
	$id_del_tag='10618';
	break;
	case *san gervasio bresciano*:
	$id_del_tag='10619';
	break;
	case *san paolo*:
	$id_del_tag='10620';
	break;
	case *san zeno naviglio*:
	$id_del_tag='10621';
	break;
	case *sarezzo*:
	$id_del_tag='10622';
	break;
	case *saviore dell'adamello*:
	$id_del_tag='10623';
	break;
	case *sellero*:
	$id_del_tag='10624';
	break;
	case *seniga*:
	$id_del_tag='10625';
	break;
	case *serle*:
	$id_del_tag='10626';
	break;
	case *sirmione*:
	$id_del_tag='10627';
	break;
	case *soiano del lago*:
	$id_del_tag='10628';
	break;
	case *sonico*:
	$id_del_tag='10629';
	break;
	case *sulzano*:
	$id_del_tag='10630';
	break;
	case *tavernole sul mella*:
	$id_del_tag='10631';
	break;
	case *temù*:
	$id_del_tag='10632';
	break;
	case *tignale*:
	$id_del_tag='10633';
	break;
	case *torbole casaglia*:
	$id_del_tag='10634';
	break;
	case *toscolano-maderno*:
	$id_del_tag='10635';
	break;
	case *travagliato*:
	$id_del_tag='10636';
	break;
	case *tremosine*:
	$id_del_tag='10637';
	break;
	case *trenzano*:
	$id_del_tag='10638';
	break;
	case *treviso bresciano*:
	$id_del_tag='10639';
	break;
	case *urago d'oglio*:
	$id_del_tag='10640';
	break;
	case *vallio terme*:
	$id_del_tag='10641';
	break;
	case *valvestino*:
	$id_del_tag='10642';
	break;
	case *verolanuova*:
	$id_del_tag='10643';
	break;
	case *verolavecchia*:
	$id_del_tag='10644';
	break;
	case *vestone*:
	$id_del_tag='10645';
	break;
	case *vezza d'oglio*:
	$id_del_tag='10646';
	break;
	case *villa carcina*:
	$id_del_tag='10647';
	break;
	case *villachiara*:
	$id_del_tag='10648';
	break;
	case *villanuova sul clisi*:
	$id_del_tag='10649';
	break;
	case *vione*:
	$id_del_tag='10650';
	break;
	case *visano*:
	$id_del_tag='10651';
	break;
	case *vobarno*:
	$id_del_tag='10652';
	break;
	case *zone*:
	$id_del_tag='10653';
	break;
	case *alagna*:
	$id_del_tag='10654';
	break;
	case *albaredo arnaboldi*:
	$id_del_tag='10655';
	break;
	case *albonese*:
	$id_del_tag='10656';
	break;
	case *albuzzano*:
	$id_del_tag='10657';
	break;
	case *arena po*:
	$id_del_tag='10658';
	break;
	case *badia pavese*:
	$id_del_tag='10659';
	break;
	case *bagnaria*:
	$id_del_tag='10660';
	break;
	case *barbianello*:
	$id_del_tag='10661';
	break;
	case *bascapè*:
	$id_del_tag='10662';
	break;
	case *bastida de' dossi*:
	$id_del_tag='10663';
	break;
	case *bastida pancarana*:
	$id_del_tag='10664';
	break;
	case *battuda*:
	$id_del_tag='10665';
	break;
	case *belgioioso*:
	$id_del_tag='10666';
	break;
	case *bereguardo*:
	$id_del_tag='10667';
	break;
	case *borgarello*:
	$id_del_tag='10668';
	break;
	case *borgo priolo*:
	$id_del_tag='10669';
	break;
	case *borgo san siro*:
	$id_del_tag='10670';
	break;
	case *borgoratto mormorolo*:
	$id_del_tag='10671';
	break;
	case *bornasco*:
	$id_del_tag='10672';
	break;
	case *bosnasco*:
	$id_del_tag='10673';
	break;
	case *brallo di pregola*:
	$id_del_tag='10674';
	break;
	case *breme*:
	$id_del_tag='10675';
	break;
	case *bressana bottarone*:
	$id_del_tag='10676';
	break;
	case *broni*:
	$id_del_tag='10677';
	break;
	case *calvignano*:
	$id_del_tag='10678';
	break;
	case *campospinoso*:
	$id_del_tag='10679';
	break;
	case *candia lomellina*:
	$id_del_tag='10680';
	break;
	case *canevino*:
	$id_del_tag='10681';
	break;
	case *canneto pavese*:
	$id_del_tag='10682';
	break;
	case *carbonara al ticino*:
	$id_del_tag='10683';
	break;
	case *casanova lonati*:
	$id_del_tag='10684';
	break;
	case *casatisma*:
	$id_del_tag='10685';
	break;
	case *casorate primo*:
	$id_del_tag='10686';
	break;
	case *cassolnovo*:
	$id_del_tag='10687';
	break;
	case *castana*:
	$id_del_tag='10688';
	break;
	case *casteggio*:
	$id_del_tag='10689';
	break;
	case *castelletto di branduzzo*:
	$id_del_tag='10690';
	break;
	case *castello d'agogna*:
	$id_del_tag='10691';
	break;
	case *castelnovetto*:
	$id_del_tag='10692';
	break;
	case *cava manara*:
	$id_del_tag='10693';
	break;
	case *cecima*:
	$id_del_tag='10694';
	break;
	case *ceranova*:
	$id_del_tag='10695';
	break;
	case *ceretto lomellina*:
	$id_del_tag='10696';
	break;
	case *cergnago*:
	$id_del_tag='10697';
	break;
	case *certosa di pavia*:
	$id_del_tag='10698';
	break;
	case *cervesina*:
	$id_del_tag='10699';
	break;
	case *chignolo po*:
	$id_del_tag='10700';
	break;
	case *cigognola*:
	$id_del_tag='10701';
	break;
	case *cilavegna*:
	$id_del_tag='10702';
	break;
	case *codevilla*:
	$id_del_tag='10703';
	break;
	case *confienza*:
	$id_del_tag='10704';
	break;
	case *copiano*:
	$id_del_tag='10705';
	break;
	case *corana*:
	$id_del_tag='10706';
	break;
	case *cornale*:
	$id_del_tag='10707';
	break;
	case *corteolona*:
	$id_del_tag='10708';
	break;
	case *corvino san quirico*:
	$id_del_tag='10709';
	break;
	case *costa de' nobili*:
	$id_del_tag='10710';
	break;
	case *cozzo*:
	$id_del_tag='10711';
	break;
	case *cura carpignano*:
	$id_del_tag='10712';
	break;
	case *dorno*:
	$id_del_tag='10713';
	break;
	case *ferrera erbognone*:
	$id_del_tag='10714';
	break;
	case *filighera*:
	$id_del_tag='10715';
	break;
	case *fortunago*:
	$id_del_tag='10716';
	break;
	case *frascarolo*:
	$id_del_tag='10717';
	break;
	case *galliavola*:
	$id_del_tag='10718';
	break;
	case *gambarana*:
	$id_del_tag='10719';
	break;
	case *gambolò*:
	$id_del_tag='10720';
	break;
	case *garlasco*:
	$id_del_tag='10721';
	break;
	case *genzone*:
	$id_del_tag='10722';
	break;
	case *gerenzago*:
	$id_del_tag='10723';
	break;
	case *giussago*:
	$id_del_tag='10724';
	break;
	case *godiasco*:
	$id_del_tag='10725';
	break;
	case *golferenzo*:
	$id_del_tag='10726';
	break;
	case *gravellona lomellina*:
	$id_del_tag='10727';
	break;
	case *gropello cairoli*:
	$id_del_tag='10728';
	break;
	case *inverno e monteleone*:
	$id_del_tag='10729';
	break;
	case *landriano*:
	$id_del_tag='10730';
	break;
	case *langosco*:
	$id_del_tag='10731';
	break;
	case *lardirago*:
	$id_del_tag='10732';
	break;
	case *linarolo*:
	$id_del_tag='10733';
	break;
	case *lirio*:
	$id_del_tag='10734';
	break;
	case *lomello*:
	$id_del_tag='10735';
	break;
	case *lungavilla*:
	$id_del_tag='10736';
	break;
	case *magherno*:
	$id_del_tag='10737';
	break;
	case *marcignago*:
	$id_del_tag='10738';
	break;
	case *marzano*:
	$id_del_tag='10739';
	break;
	case *mede*:
	$id_del_tag='10740';
	break;
	case *menconico*:
	$id_del_tag='10741';
	break;
	case *mezzana bigli*:
	$id_del_tag='10742';
	break;
	case *mezzana rabattone*:
	$id_del_tag='10743';
	break;
	case *mezzanino*:
	$id_del_tag='10744';
	break;
	case *miradolo terme*:
	$id_del_tag='10745';
	break;
	case *montalto pavese*:
	$id_del_tag='10746';
	break;
	case *montebello della battaglia*:
	$id_del_tag='10747';
	break;
	case *montecalvo versiggia*:
	$id_del_tag='10748';
	break;
	case *montescano*:
	$id_del_tag='10749';
	break;
	case *montesegale*:
	$id_del_tag='10750';
	break;
	case *monticelli pavese*:
	$id_del_tag='10751';
	break;
	case *montù beccaria*:
	$id_del_tag='10752';
	break;
	case *mornico losana*:
	$id_del_tag='10753';
	break;
	case *nicorvo*:
	$id_del_tag='10754';
	break;
	case *olevano di lomellina*:
	$id_del_tag='10755';
	break;
	case *oliva gessi*:
	$id_del_tag='10756';
	break;
	case *ottobiano*:
	$id_del_tag='10757';
	break;
	case *palestro*:
	$id_del_tag='10758';
	break;
	case *pancarana*:
	$id_del_tag='10759';
	break;
	case *parona*:
	$id_del_tag='10760';
	break;
	case *pietra de' giorgi*:
	$id_del_tag='10761';
	break;
	case *pieve albignola*:
	$id_del_tag='10762';
	break;
	case *pieve del cairo*:
	$id_del_tag='10763';
	break;
	case *pieve porto morone*:
	$id_del_tag='10764';
	break;
	case *pinarolo po*:
	$id_del_tag='10765';
	break;
	case *pizzale*:
	$id_del_tag='10766';
	break;
	case *ponte nizza*:
	$id_del_tag='10767';
	break;
	case *portalbera*:
	$id_del_tag='10768';
	break;
	case *rea*:
	$id_del_tag='10769';
	break;
	case *redavalle*:
	$id_del_tag='10770';
	break;
	case *retorbido*:
	$id_del_tag='10771';
	break;
	case *rivanazzano*:
	$id_del_tag='10772';
	break;
	case *robbio*:
	$id_del_tag='10773';
	break;
	case *robecco pavese*:
	$id_del_tag='10774';
	break;
	case *rocca de' giorgi*:
	$id_del_tag='10775';
	break;
	case *rocca susella*:
	$id_del_tag='10776';
	break;
	case *rognano*:
	$id_del_tag='10777';
	break;
	case *romagnese*:
	$id_del_tag='10778';
	break;
	case *roncaro*:
	$id_del_tag='10779';
	break;
	case *rosasco*:
	$id_del_tag='10780';
	break;
	case *rovescala*:
	$id_del_tag='10781';
	break;
	case *ruino*:
	$id_del_tag='10782';
	break;
	case *san cipriano po*:
	$id_del_tag='10783';
	break;
	case *san damiano al colle*:
	$id_del_tag='10784';
	break;
	case *san genesio ed uniti*:
	$id_del_tag='10785';
	break;
	case *san giorgio di lomellina*:
	$id_del_tag='10786';
	break;
	case *san martino siccomario*:
	$id_del_tag='10787';
	break;
	case *san zenone al po*:
	$id_del_tag='10788';
	break;
	case *sannazzaro de' burgondi*:
	$id_del_tag='10789';
	break;
	case *santa cristina e bissone*:
	$id_del_tag='10790';
	break;
	case *santa giuletta*:
	$id_del_tag='10791';
	break;
	case *santa margherita di staffora*:
	$id_del_tag='10792';
	break;
	case *santa maria della versa*:
	$id_del_tag='10793';
	break;
	case *sant'alessio con vialone*:
	$id_del_tag='10794';
	break;
	case *sant'angelo lomellina*:
	$id_del_tag='10795';
	break;
	case *sartirana lomellina*:
	$id_del_tag='10796';
	break;
	case *scaldasole*:
	$id_del_tag='10797';
	break;
	case *semiana*:
	$id_del_tag='10798';
	break;
	case *silvano pietra*:
	$id_del_tag='10799';
	break;
	case *siziano*:
	$id_del_tag='10800';
	break;
	case *sommo*:
	$id_del_tag='10801';
	break;
	case *spessa*:
	$id_del_tag='10802';
	break;
	case *stradella*:
	$id_del_tag='10803';
	break;
	case *suardi*:
	$id_del_tag='10804';
	break;
	case *torrazza coste*:
	$id_del_tag='10805';
	break;
	case *torre beretti e castellaro*:
	$id_del_tag='10806';
	break;
	case *torre d'arese*:
	$id_del_tag='10807';
	break;
	case *torre de' negri*:
	$id_del_tag='10808';
	break;
	case *torre d'isola*:
	$id_del_tag='10809';
	break;
	case *torrevecchia pia*:
	$id_del_tag='10810';
	break;
	case *torricella verzate*:
	$id_del_tag='10811';
	break;
	case *travacò siccomario*:
	$id_del_tag='10812';
	break;
	case *trivolzio*:
	$id_del_tag='10813';
	break;
	case *tromello*:
	$id_del_tag='10814';
	break;
	case *trovo*:
	$id_del_tag='10815';
	break;
	case *val di nizza*:
	$id_del_tag='10816';
	break;
	case *valeggio*:
	$id_del_tag='10817';
	break;
	case *valle lomellina*:
	$id_del_tag='10818';
	break;
	case *valle salimbene*:
	$id_del_tag='10819';
	break;
	case *valverde*:
	$id_del_tag='10820';
	break;
	case *varzi*:
	$id_del_tag='10821';
	break;
	case *velezzo lomellina*:
	$id_del_tag='10822';
	break;
	case *vellezzo bellini*:
	$id_del_tag='10823';
	break;
	case *verretto*:
	$id_del_tag='10824';
	break;
	case *verrua po*:
	$id_del_tag='10825';
	break;
	case *vidigulfo*:
	$id_del_tag='10826';
	break;
	case *vigevano*:
	$id_del_tag='10827';
	break;
	case *villa biscossi*:
	$id_del_tag='10828';
	break;
	case *villanova d'ardenghi*:
	$id_del_tag='10829';
	break;
	case *villanterio*:
	$id_del_tag='10830';
	break;
	case *vistarino*:
	$id_del_tag='10831';
	break;
	case *voghera*:
	$id_del_tag='10832';
	break;
	case *volpara*:
	$id_del_tag='10833';
	break;
	case *zavattarello*:
	$id_del_tag='10834';
	break;
	case *zeccone*:
	$id_del_tag='10835';
	break;
	case *zeme*:
	$id_del_tag='10836';
	break;
	case *zenevredo*:
	$id_del_tag='10837';
	break;
	case *zerbo*:
	$id_del_tag='10838';
	break;
	case *zerbolò*:
	$id_del_tag='10839';
	break;
	case *zinasco*:
	$id_del_tag='10840';
	break;
	case *acquanegra cremonese*:
	$id_del_tag='10841';
	break;
	case *agnadello*:
	$id_del_tag='10842';
	break;
	case *annicco*:
	$id_del_tag='10843';
	break;
	case *azzanello*:
	$id_del_tag='10844';
	break;
	case *bagnolo cremasco*:
	$id_del_tag='10845';
	break;
	case *bonemerse*:
	$id_del_tag='10846';
	break;
	case *bordolano*:
	$id_del_tag='10847';
	break;
	case *ca' d'andrea*:
	$id_del_tag='10848';
	break;
	case *calvatone*:
	$id_del_tag='10849';
	break;
	case *camisano*:
	$id_del_tag='10850';
	break;
	case *campagnola cremasca*:
	$id_del_tag='10851';
	break;
	case *capergnanica*:
	$id_del_tag='10852';
	break;
	case *cappella cantone*:
	$id_del_tag='10853';
	break;
	case *cappella de' picenardi*:
	$id_del_tag='10854';
	break;
	case *capralba*:
	$id_del_tag='10855';
	break;
	case *casalbuttano ed uniti*:
	$id_del_tag='10856';
	break;
	case *casale cremasco-vidolasco*:
	$id_del_tag='10857';
	break;
	case *casaletto ceredano*:
	$id_del_tag='10858';
	break;
	case *casaletto di sopra*:
	$id_del_tag='10859';
	break;
	case *casaletto vaprio*:
	$id_del_tag='10860';
	break;
	case *casalmaggiore*:
	$id_del_tag='10861';
	break;
	case *casalmorano*:
	$id_del_tag='10862';
	break;
	case *castel gabbiano*:
	$id_del_tag='10863';
	break;
	case *casteldidone*:
	$id_del_tag='10864';
	break;
	case *castelleone*:
	$id_del_tag='10865';
	break;
	case *castelverde*:
	$id_del_tag='10866';
	break;
	case *castelvisconti*:
	$id_del_tag='10867';
	break;
	case *cella dati*:
	$id_del_tag='10868';
	break;
	case *chieve*:
	$id_del_tag='10869';
	break;
	case *cicognolo*:
	$id_del_tag='10870';
	break;
	case *cingia de' botti*:
	$id_del_tag='10871';
	break;
	case *corte de' cortesi con cignone*:
	$id_del_tag='10872';
	break;
	case *corte de' frati*:
	$id_del_tag='10873';
	break;
	case *credera rubbiano*:
	$id_del_tag='10874';
	break;
	case *cremosano*:
	$id_del_tag='10875';
	break;
	case *crotta d'adda*:
	$id_del_tag='10876';
	break;
	case *cumignano sul naviglio*:
	$id_del_tag='10877';
	break;
	case *derovere*:
	$id_del_tag='10878';
	break;
	case *dovera*:
	$id_del_tag='10879';
	break;
	case *drizzona*:
	$id_del_tag='10880';
	break;
	case *fiesco*:
	$id_del_tag='10881';
	break;
	case *formigara*:
	$id_del_tag='10882';
	break;
	case *gabbioneta-binanuova*:
	$id_del_tag='10883';
	break;
	case *gadesco-pieve delmona*:
	$id_del_tag='10884';
	break;
	case *genivolta*:
	$id_del_tag='10885';
	break;
	case *gerre de' caprioli*:
	$id_del_tag='10886';
	break;
	case *gombito*:
	$id_del_tag='10887';
	break;
	case *grontardo*:
	$id_del_tag='10888';
	break;
	case *grumello cremonese ed uniti*:
	$id_del_tag='10889';
	break;
	case *gussola*:
	$id_del_tag='10890';
	break;
	case *isola dovarese*:
	$id_del_tag='10891';
	break;
	case *izano*:
	$id_del_tag='10892';
	break;
	case *madignano*:
	$id_del_tag='10893';
	break;
	case *malagnino*:
	$id_del_tag='10894';
	break;
	case *martignana di po*:
	$id_del_tag='10895';
	break;
	case *monte cremasco*:
	$id_del_tag='10896';
	break;
	case *montodine*:
	$id_del_tag='10897';
	break;
	case *moscazzano*:
	$id_del_tag='10898';
	break;
	case *motta baluffi*:
	$id_del_tag='10899';
	break;
	case *offanengo*:
	$id_del_tag='10900';
	break;
	case *olmeneta*:
	$id_del_tag='10901';
	break;
	case *ostiano*:
	$id_del_tag='10902';
	break;
	case *paderno ponchielli*:
	$id_del_tag='10903';
	break;
	case *palazzo pignano*:
	$id_del_tag='10904';
	break;
	case *pandino*:
	$id_del_tag='10905';
	break;
	case *persico dosimo*:
	$id_del_tag='10906';
	break;
	case *pescarolo ed uniti*:
	$id_del_tag='10907';
	break;
	case *pessina cremonese*:
	$id_del_tag='10908';
	break;
	case *piadena*:
	$id_del_tag='10909';
	break;
	case *pianengo*:
	$id_del_tag='10910';
	break;
	case *pieranica*:
	$id_del_tag='10911';
	break;
	case *pieve d'olmi*:
	$id_del_tag='10912';
	break;
	case *pieve san giacomo*:
	$id_del_tag='10913';
	break;
	case *pizzighettone*:
	$id_del_tag='10914';
	break;
	case *pozzaglio ed uniti*:
	$id_del_tag='10915';
	break;
	case *quintano*:
	$id_del_tag='10916';
	break;
	case *ricengo*:
	$id_del_tag='10917';
	break;
	case *ripalta arpina*:
	$id_del_tag='10918';
	break;
	case *ripalta cremasca*:
	$id_del_tag='10919';
	break;
	case *ripalta guerina*:
	$id_del_tag='10920';
	break;
	case *rivarolo del re ed uniti*:
	$id_del_tag='10921';
	break;
	case *rivolta d'adda*:
	$id_del_tag='10922';
	break;
	case *robecco d'oglio*:
	$id_del_tag='10923';
	break;
	case *romanengo*:
	$id_del_tag='10924';
	break;
	case *salvirola*:
	$id_del_tag='10925';
	break;
	case *san bassano*:
	$id_del_tag='10926';
	break;
	case *san daniele po*:
	$id_del_tag='10927';
	break;
	case *san giovanni in croce*:
	$id_del_tag='10928';
	break;
	case *san martino del lago*:
	$id_del_tag='10929';
	break;
	case *scandolara ravara*:
	$id_del_tag='10930';
	break;
	case *scandolara ripa d'oglio*:
	$id_del_tag='10931';
	break;
	case *sergnano*:
	$id_del_tag='10932';
	break;
	case *sesto ed uniti*:
	$id_del_tag='10933';
	break;
	case *solarolo rainerio*:
	$id_del_tag='10934';
	break;
	case *soresina*:
	$id_del_tag='10935';
	break;
	case *sospiro*:
	$id_del_tag='10936';
	break;
	case *spinadesco*:
	$id_del_tag='10937';
	break;
	case *spineda*:
	$id_del_tag='10938';
	break;
	case *spino d'adda*:
	$id_del_tag='10939';
	break;
	case *ticengo*:
	$id_del_tag='10940';
	break;
	case *torlino vimercati*:
	$id_del_tag='10941';
	break;
	case *tornata*:
	$id_del_tag='10942';
	break;
	case *torre de' picenardi*:
	$id_del_tag='10943';
	break;
	case *torricella del pizzo*:
	$id_del_tag='10944';
	break;
	case *trescore cremasco*:
	$id_del_tag='10945';
	break;
	case *trigolo*:
	$id_del_tag='10946';
	break;
	case *vaiano cremasco*:
	$id_del_tag='10947';
	break;
	case *vailate*:
	$id_del_tag='10948';
	break;
	case *vescovato*:
	$id_del_tag='10949';
	break;
	case *volongo*:
	$id_del_tag='10950';
	break;
	case *voltido*:
	$id_del_tag='10951';
	break;
	case *acquanegra sul chiese*:
	$id_del_tag='10952';
	break;
	case *asola*:
	$id_del_tag='10953';
	break;
	case *bagnolo san vito*:
	$id_del_tag='10954';
	break;
	case *bigarello*:
	$id_del_tag='10955';
	break;
	case *borgoforte*:
	$id_del_tag='10956';
	break;
	case *borgofranco sul po*:
	$id_del_tag='10957';
	break;
	case *bozzolo*:
	$id_del_tag='10958';
	break;
	case *canneto sull'oglio*:
	$id_del_tag='10959';
	break;
	case *carbonara di po*:
	$id_del_tag='10960';
	break;
	case *casalmoro*:
	$id_del_tag='10961';
	break;
	case *casaloldo*:
	$id_del_tag='10962';
	break;
	case *casalromano*:
	$id_del_tag='10963';
	break;
	case *castel d'ario*:
	$id_del_tag='10964';
	break;
	case *castelbelforte*:
	$id_del_tag='10965';
	break;
	case *castellucchio*:
	$id_del_tag='10966';
	break;
	case *cavriana*:
	$id_del_tag='10967';
	break;
	case *ceresara*:
	$id_del_tag='10968';
	break;
	case *commessaggio*:
	$id_del_tag='10969';
	break;
	case *curtatone*:
	$id_del_tag='10970';
	break;
	case *dosolo*:
	$id_del_tag='10971';
	break;
	case *felonica*:
	$id_del_tag='10972';
	break;
	case *gazoldo degli ippoliti*:
	$id_del_tag='10973';
	break;
	case *gazzuolo*:
	$id_del_tag='10974';
	break;
	case *goito*:
	$id_del_tag='10975';
	break;
	case *gonzaga*:
	$id_del_tag='10976';
	break;
	case *guidizzolo*:
	$id_del_tag='10977';
	break;
	case *magnacavallo*:
	$id_del_tag='10978';
	break;
	case *marcaria*:
	$id_del_tag='10979';
	break;
	case *mariana mantovana*:
	$id_del_tag='10980';
	break;
	case *marmirolo*:
	$id_del_tag='10981';
	break;
	case *medole*:
	$id_del_tag='10982';
	break;
	case *moglia*:
	$id_del_tag='10983';
	break;
	case *monzambano*:
	$id_del_tag='10984';
	break;
	case *motteggiana*:
	$id_del_tag='10985';
	break;
	case *pegognaga*:
	$id_del_tag='10986';
	break;
	case *pieve di coriano*:
	$id_del_tag='10987';
	break;
	case *piubega*:
	$id_del_tag='10988';
	break;
	case *poggio rusco*:
	$id_del_tag='10989';
	break;
	case *pomponesco*:
	$id_del_tag='10990';
	break;
	case *ponti sul mincio*:
	$id_del_tag='10991';
	break;
	case *porto mantovano*:
	$id_del_tag='10992';
	break;
	case *quingentole*:
	$id_del_tag='10993';
	break;
	case *quistello*:
	$id_del_tag='10994';
	break;
	case *redondesco*:
	$id_del_tag='10995';
	break;
	case *rivarolo mantovano*:
	$id_del_tag='10996';
	break;
	case *rodigo*:
	$id_del_tag='10997';
	break;
	case *roncoferraro*:
	$id_del_tag='10998';
	break;
	case *roverbella*:
	$id_del_tag='10999';
	break;
	case *sabbioneta*:
	$id_del_tag='11000';
	break;
	case *san benedetto po*:
	$id_del_tag='11001';
	break;
	case *san giacomo delle segnate*:
	$id_del_tag='11002';
	break;
	case *san giorgio di mantova*:
	$id_del_tag='11003';
	break;
	case *san giovanni del dosso*:
	$id_del_tag='11004';
	break;
	case *san martino dall'argine*:
	$id_del_tag='11005';
	break;
	case *schivenoglia*:
	$id_del_tag='11006';
	break;
	case *serravalle a po*:
	$id_del_tag='11007';
	break;
	case *solferino*:
	$id_del_tag='11008';
	break;
	case *sustinente*:
	$id_del_tag='11009';
	break;
	case *villa poma*:
	$id_del_tag='11010';
	break;
	case *villimpenta*:
	$id_del_tag='11011';
	break;
	case *virgilio*:
	$id_del_tag='11012';
	break;
	case *volta mantovana*:
	$id_del_tag='11013';
	break;
	case *aldino - aldein*:
	$id_del_tag='11014';
	break;
	case *andriano - andrian*:
	$id_del_tag='11015';
	break;
	case *anterivo - altrei*:
	$id_del_tag='11016';
	break;
	case *appiano sulla strada del vino - eppan an der weinstrasse*:
	$id_del_tag='11017';
	break;
	case *avelengo - hafling*:
	$id_del_tag='11018';
	break;
	case *badia - abtei*:
	$id_del_tag='11019';
	break;
	case *barbiano - barbian*:
	$id_del_tag='11020';
	break;
	case *braies - prags*:
	$id_del_tag='11021';
	break;
	case *brennero - brenner*:
	$id_del_tag='11022';
	break;
	case *bronzolo - branzoll*:
	$id_del_tag='11023';
	break;
	case *caines - kuens*:
	$id_del_tag='11024';
	break;
	case *caldaro sulla strada del vino - kaltern an der weinstrasse*:
	$id_del_tag='11025';
	break;
	case *campo di trens - freienfeld*:
	$id_del_tag='11026';
	break;
	case *campo tures - sand in taufers*:
	$id_del_tag='11027';
	break;
	case *castelbello-ciardes - kastelbell-tschars*:
	$id_del_tag='11028';
	break;
	case *castelrotto - kastelruth*:
	$id_del_tag='11029';
	break;
	case *cermes - tscherms*:
	$id_del_tag='11030';
	break;
	case *chienes - kiens*:
	$id_del_tag='11031';
	break;
	case *chiusa - klausen*:
	$id_del_tag='11032';
	break;
	case *cornedo all'isarco - karneid*:
	$id_del_tag='11033';
	break;
	case *cortaccia sulla strada del vino - kurtatsch an der weinstrasse*:
	$id_del_tag='11034';
	break;
	case *cortina sulla strada del vino - kurtinig an der weinstrasse*:
	$id_del_tag='11035';
	break;
	case *corvara in badia - corvara*:
	$id_del_tag='11036';
	break;
	case *curon venosta - graun im vinschgau*:
	$id_del_tag='11037';
	break;
	case *dobbiaco - toblach*:
	$id_del_tag='11038';
	break;
	case *egna - neumarkt*:
	$id_del_tag='11039';
	break;
	case *falzes - pfalzen*:
	$id_del_tag='11040';
	break;
	case *fiè allo sciliar - voels am schlern*:
	$id_del_tag='11041';
	break;
	case *fortezza - franzensfeste*:
	$id_del_tag='11042';
	break;
	case *funes - villnoess*:
	$id_del_tag='11043';
	break;
	case *gais - gais*:
	$id_del_tag='11044';
	break;
	case *gargazzone - gargazon*:
	$id_del_tag='11045';
	break;
	case *glorenza - glurns*:
	$id_del_tag='11046';
	break;
	case *la valle - wengen*:
	$id_del_tag='11047';
	break;
	case *laces - latsch*:
	$id_del_tag='11048';
	break;
	case *lagundo - algund*:
	$id_del_tag='11049';
	break;
	case *laion - lajen*:
	$id_del_tag='11050';
	break;
	case *laives - leifers*:
	$id_del_tag='11051';
	break;
	case *lana - lana*:
	$id_del_tag='11052';
	break;
	case *lasa - laas*:
	$id_del_tag='11053';
	break;
	case *lauregno - laurein*:
	$id_del_tag='11054';
	break;
	case *luson - luesen*:
	$id_del_tag='11055';
	break;
	case *magrè sulla strada del vino - margreid an der weinstrasse*:
	$id_del_tag='11056';
	break;
	case *malles venosta - mals*:
	$id_del_tag='11057';
	break;
	case *marebbe - enneberg*:
	$id_del_tag='11058';
	break;
	case *marlengo - marling*:
	$id_del_tag='11059';
	break;
	case *martello - martell*:
	$id_del_tag='11060';
	break;
	case *meltina - moelten*:
	$id_del_tag='11061';
	break;
	case *monguelfo-tesido- welsberg-taisten*:
	$id_del_tag='11062';
	break;
	case *montagna - montan*:
	$id_del_tag='11063';
	break;
	case *moso in passiria - moos in passeier*:
	$id_del_tag='11064';
	break;
	case *nalles - nals*:
	$id_del_tag='11065';
	break;
	case *naturno - naturns*:
	$id_del_tag='11066';
	break;
	case *naz-sciaves - natz-schabs*:
	$id_del_tag='11067';
	break;
	case *nova levante - welschnofen*:
	$id_del_tag='11068';
	break;
	case *nova ponente - deutschnofen*:
	$id_del_tag='11069';
	break;
	case *ora - auer*:
	$id_del_tag='11070';
	break;
	case *ortisei - st. ulrich*:
	$id_del_tag='11071';
	break;
	case *parcines - partschins*:
	$id_del_tag='11072';
	break;
	case *perca - percha*:
	$id_del_tag='11073';
	break;
	case *plaus - plaus*:
	$id_del_tag='11074';
	break;
	case *ponte gardena - waidbruck*:
	$id_del_tag='11075';
	break;
	case *postal - burgstall*:
	$id_del_tag='11076';
	break;
	case *prato allo stelvio - prad am stilfser joch*:
	$id_del_tag='11077';
	break;
	case *predoi - prettau*:
	$id_del_tag='11078';
	break;
	case *proves - proveis*:
	$id_del_tag='11079';
	break;
	case *racines - ratschings*:
	$id_del_tag='11080';
	break;
	case *rasun anterselva - rasen-antholz*:
	$id_del_tag='11081';
	break;
	case *renon - ritten*:
	$id_del_tag='11082';
	break;
	case *rifiano - riffian*:
	$id_del_tag='11083';
	break;
	case *rio di pusteria - muehlbach*:
	$id_del_tag='11084';
	break;
	case *rodengo - rodeneck*:
	$id_del_tag='11085';
	break;
	case *salorno - salurn*:
	$id_del_tag='11086';
	break;
	case *san candido - innichen*:
	$id_del_tag='11087';
	break;
	case *san genesio atesino - jenesien*:
	$id_del_tag='11088';
	break;
	case *san leonardo in passiria - st. leonhard in passeier*:
	$id_del_tag='11089';
	break;
	case *san lorenzo di sebato - st. lorenzen*:
	$id_del_tag='11090';
	break;
	case *san martino in badia - st. martin in thurn*:
	$id_del_tag='11091';
	break;
	case *san martino in passiria - st. martin in passeier*:
	$id_del_tag='11092';
	break;
	case *san pancrazio - st. pankraz*:
	$id_del_tag='11093';
	break;
	case *santa cristina valgardena - st. christina in groeden*:
	$id_del_tag='11094';
	break;
	case *sarentino - sarntal*:
	$id_del_tag='11095';
	break;
	case *scena - schenna*:
	$id_del_tag='11096';
	break;
	case *selva dei molini - muehlwald*:
	$id_del_tag='11097';
	break;
	case *selva di val gardena - wolkenstein in groeden*:
	$id_del_tag='11098';
	break;
	case *senales - schnals*:
	$id_del_tag='11099';
	break;
	case *senale-san felice - unsere liebe frau im walde-st. felix*:
	$id_del_tag='11100';
	break;
	case *sesto - sexten*:
	$id_del_tag='11101';
	break;
	case *silandro - schlanders*:
	$id_del_tag='11102';
	break;
	case *sluderno - schluderns*:
	$id_del_tag='11103';
	break;
	case *stelvio - stilfs*:
	$id_del_tag='11104';
	break;
	case *terento - terenten*:
	$id_del_tag='11105';
	break;
	case *terlano - terlan*:
	$id_del_tag='11106';
	break;
	case *termeno sulla strada del vino - tramin an der weinstrasse*:
	$id_del_tag='11107';
	break;
	case *tesimo - tisens*:
	$id_del_tag='11108';
	break;
	case *tires - tiers*:
	$id_del_tag='11109';
	break;
	case *tirolo - tirol*:
	$id_del_tag='11110';
	break;
	case *trodena - truden*:
	$id_del_tag='11111';
	break;
	case *tubre - taufers im muenstertal*:
	$id_del_tag='11112';
	break;
	case *ultimo - ulten*:
	$id_del_tag='11113';
	break;
	case *vadena - pfatten*:
	$id_del_tag='11114';
	break;
	case *val di vizze - pfitsch*:
	$id_del_tag='11115';
	break;
	case *valdaora - olang*:
	$id_del_tag='11116';
	break;
	case *valle aurina - ahrntal*:
	$id_del_tag='11117';
	break;
	case *valle di casies - gsies*:
	$id_del_tag='11118';
	break;
	case *vandoies - vintl*:
	$id_del_tag='11119';
	break;
	case *varna - vahrn*:
	$id_del_tag='11120';
	break;
	case *velturno - feldthurns*:
	$id_del_tag='11121';
	break;
	case *verano - voeran*:
	$id_del_tag='11122';
	break;
	case *villabassa - niederdorf*:
	$id_del_tag='11123';
	break;
	case *villandro - villanders*:
	$id_del_tag='11124';
	break;
	case *vipiteno - sterzing*:
	$id_del_tag='11125';
	break;
	case *ala*:
	$id_del_tag='11126';
	break;
	case *albiano*:
	$id_del_tag='11127';
	break;
	case *aldeno*:
	$id_del_tag='11128';
	break;
	case *amblar*:
	$id_del_tag='11129';
	break;
	case *andalo*:
	$id_del_tag='11130';
	break;
	case *arco*:
	$id_del_tag='11131';
	break;
	case *avio*:
	$id_del_tag='11132';
	break;
	case *baselga di pinè*:
	$id_del_tag='11133';
	break;
	case *bersone*:
	$id_del_tag='11134';
	break;
	case *besenello*:
	$id_del_tag='11135';
	break;
	case *bezzecca*:
	$id_del_tag='11136';
	break;
	case *bieno*:
	$id_del_tag='11137';
	break;
	case *bleggio inferiore*:
	$id_del_tag='11138';
	break;
	case *bleggio superiore*:
	$id_del_tag='11139';
	break;
	case *bocenago*:
	$id_del_tag='11140';
	break;
	case *bolbeno*:
	$id_del_tag='11141';
	break;
	case *bondo*:
	$id_del_tag='11142';
	break;
	case *bondone*:
	$id_del_tag='11143';
	break;
	case *borgo valsugana*:
	$id_del_tag='11144';
	break;
	case *bosentino*:
	$id_del_tag='11145';
	break;
	case *breguzzo*:
	$id_del_tag='11146';
	break;
	case *brentonico*:
	$id_del_tag='11147';
	break;
	case *bresimo*:
	$id_del_tag='11148';
	break;
	case *brez*:
	$id_del_tag='11149';
	break;
	case *caderzone*:
	$id_del_tag='11150';
	break;
	case *cagnò*:
	$id_del_tag='11151';
	break;
	case *calavino*:
	$id_del_tag='11152';
	break;
	case *calceranica al lago*:
	$id_del_tag='11153';
	break;
	case *caldes*:
	$id_del_tag='11154';
	break;
	case *caldonazzo*:
	$id_del_tag='11155';
	break;
	case *campitello di fassa*:
	$id_del_tag='11156';
	break;
	case *campodenno*:
	$id_del_tag='11157';
	break;
	case *canal san bovo*:
	$id_del_tag='11158';
	break;
	case *canazei*:
	$id_del_tag='11159';
	break;
	case *capriana*:
	$id_del_tag='11160';
	break;
	case *carano*:
	$id_del_tag='11161';
	break;
	case *carisolo*:
	$id_del_tag='11162';
	break;
	case *carzano*:
	$id_del_tag='11163';
	break;
	case *castel condino*:
	$id_del_tag='11164';
	break;
	case *castelfondo*:
	$id_del_tag='11165';
	break;
	case *castello-molina di fiemme*:
	$id_del_tag='11166';
	break;
	case *castelnuovo*:
	$id_del_tag='11167';
	break;
	case *cavalese*:
	$id_del_tag='11168';
	break;
	case *cavareno*:
	$id_del_tag='11169';
	break;
	case *cavedago*:
	$id_del_tag='11170';
	break;
	case *cavedine*:
	$id_del_tag='11171';
	break;
	case *cavizzana*:
	$id_del_tag='11172';
	break;
	case *cembra*:
	$id_del_tag='11173';
	break;
	case *cimego*:
	$id_del_tag='11174';
	break;
	case *cimone*:
	$id_del_tag='11175';
	break;
	case *cinte tesino*:
	$id_del_tag='11176';
	break;
	case *cis*:
	$id_del_tag='11177';
	break;
	case *civezzano*:
	$id_del_tag='11178';
	break;
	case *cles*:
	$id_del_tag='11179';
	break;
	case *cloz*:
	$id_del_tag='11180';
	break;
	case *commezzadura*:
	$id_del_tag='11181';
	break;
	case *concei*:
	$id_del_tag='11182';
	break;
	case *condino*:
	$id_del_tag='11183';
	break;
	case *coredo*:
	$id_del_tag='11184';
	break;
	case *croviana*:
	$id_del_tag='11185';
	break;
	case *cunevo*:
	$id_del_tag='11186';
	break;
	case *daiano*:
	$id_del_tag='11187';
	break;
	case *dambel*:
	$id_del_tag='11188';
	break;
	case *daone*:
	$id_del_tag='11189';
	break;
	case *darè*:
	$id_del_tag='11190';
	break;
	case *denno*:
	$id_del_tag='11191';
	break;
	case *dimaro*:
	$id_del_tag='11192';
	break;
	case *don*:
	$id_del_tag='11193';
	break;
	case *dorsino*:
	$id_del_tag='11194';
	break;
	case *drena*:
	$id_del_tag='11195';
	break;
	case *dro*:
	$id_del_tag='11196';
	break;
	case *faedo*:
	$id_del_tag='11197';
	break;
	case *fai della paganella*:
	$id_del_tag='11198';
	break;
	case *faver*:
	$id_del_tag='11199';
	break;
	case *fiavè*:
	$id_del_tag='11200';
	break;
	case *fiera di primiero*:
	$id_del_tag='11201';
	break;
	case *fierozzo*:
	$id_del_tag='11202';
	break;
	case *flavon*:
	$id_del_tag='11203';
	break;
	case *folgaria*:
	$id_del_tag='11204';
	break;
	case *fondo*:
	$id_del_tag='11205';
	break;
	case *fornace*:
	$id_del_tag='11206';
	break;
	case *frassilongo*:
	$id_del_tag='11207';
	break;
	case *garniga terme*:
	$id_del_tag='11208';
	break;
	case *giovo*:
	$id_del_tag='11209';
	break;
	case *giustino*:
	$id_del_tag='11210';
	break;
	case *grauno*:
	$id_del_tag='11211';
	break;
	case *grigno*:
	$id_del_tag='11212';
	break;
	case *grumes*:
	$id_del_tag='11213';
	break;
	case *imer*:
	$id_del_tag='11214';
	break;
	case *isera*:
	$id_del_tag='11215';
	break;
	case *ivano-fracena*:
	$id_del_tag='11216';
	break;
	case *lardaro*:
	$id_del_tag='11217';
	break;
	case *lasino*:
	$id_del_tag='11218';
	break;
	case *lavarone*:
	$id_del_tag='11219';
	break;
	case *lavis*:
	$id_del_tag='11220';
	break;
	case *levico terme*:
	$id_del_tag='11221';
	break;
	case *lisignago*:
	$id_del_tag='11222';
	break;
	case *lomaso*:
	$id_del_tag='11223';
	break;
	case *lona-lases*:
	$id_del_tag='11224';
	break;
	case *luserna*:
	$id_del_tag='11225';
	break;
	case *malè*:
	$id_del_tag='11226';
	break;
	case *malosco*:
	$id_del_tag='11227';
	break;
	case *massimeno*:
	$id_del_tag='11228';
	break;
	case *mazzin*:
	$id_del_tag='11229';
	break;
	case *mezzana*:
	$id_del_tag='11230';
	break;
	case *mezzano*:
	$id_del_tag='11231';
	break;
	case *mezzocorona*:
	$id_del_tag='11232';
	break;
	case *mezzolombardo*:
	$id_del_tag='11233';
	break;
	case *moena*:
	$id_del_tag='11234';
	break;
	case *molina di ledro*:
	$id_del_tag='11235';
	break;
	case *monclassico*:
	$id_del_tag='11236';
	break;
	case *montagne*:
	$id_del_tag='11237';
	break;
	case *mori*:
	$id_del_tag='11238';
	break;
	case *nago-torbole*:
	$id_del_tag='11239';
	break;
	case *nanno*:
	$id_del_tag='11240';
	break;
	case *nave san rocco*:
	$id_del_tag='11241';
	break;
	case *nogaredo*:
	$id_del_tag='11242';
	break;
	case *nomi*:
	$id_del_tag='11243';
	break;
	case *novaledo*:
	$id_del_tag='11244';
	break;
	case *ospedaletto*:
	$id_del_tag='11245';
	break;
	case *ossana*:
	$id_del_tag='11246';
	break;
	case *padergnone*:
	$id_del_tag='11247';
	break;
	case *palù del fersina*:
	$id_del_tag='11248';
	break;
	case *panchià*:
	$id_del_tag='11249';
	break;
	case *pellizzano*:
	$id_del_tag='11250';
	break;
	case *pelugo*:
	$id_del_tag='11251';
	break;
	case *pergine valsugana*:
	$id_del_tag='11252';
	break;
	case *pieve di bono*:
	$id_del_tag='11253';
	break;
	case *pieve di ledro*:
	$id_del_tag='11254';
	break;
	case *pieve tesino*:
	$id_del_tag='11255';
	break;
	case *pinzolo*:
	$id_del_tag='11256';
	break;
	case *pomarolo*:
	$id_del_tag='11257';
	break;
	case *pozza di fassa*:
	$id_del_tag='11258';
	break;
	case *praso*:
	$id_del_tag='11259';
	break;
	case *predazzo*:
	$id_del_tag='11260';
	break;
	case *preore*:
	$id_del_tag='11261';
	break;
	case *prezzo*:
	$id_del_tag='11262';
	break;
	case *rabbi*:
	$id_del_tag='11263';
	break;
	case *ragoli*:
	$id_del_tag='11264';
	break;
	case *revò*:
	$id_del_tag='11265';
	break;
	case *riva del garda*:
	$id_del_tag='11266';
	break;
	case *romallo*:
	$id_del_tag='11267';
	break;
	case *romeno*:
	$id_del_tag='11268';
	break;
	case *roncegno terme*:
	$id_del_tag='11269';
	break;
	case *ronchi valsugana*:
	$id_del_tag='11270';
	break;
	case *roncone*:
	$id_del_tag='11271';
	break;
	case *ronzo-chienis*:
	$id_del_tag='11272';
	break;
	case *ronzone*:
	$id_del_tag='11273';
	break;
	case *roverè della luna*:
	$id_del_tag='11274';
	break;
	case *ruffrè-mendola*:
	$id_del_tag='11275';
	break;
	case *rumo*:
	$id_del_tag='11276';
	break;
	case *sagron mis*:
	$id_del_tag='11277';
	break;
	case *san lorenzo in banale*:
	$id_del_tag='11278';
	break;
	case *san michele all'adige*:
	$id_del_tag='11279';
	break;
	case *sant'orsola terme*:
	$id_del_tag='11280';
	break;
	case *sanzeno*:
	$id_del_tag='11281';
	break;
	case *sarnonico*:
	$id_del_tag='11282';
	break;
	case *scurelle*:
	$id_del_tag='11283';
	break;
	case *segonzano*:
	$id_del_tag='11284';
	break;
	case *sfruz*:
	$id_del_tag='11285';
	break;
	case *siror*:
	$id_del_tag='11286';
	break;
	case *smarano*:
	$id_del_tag='11287';
	break;
	case *soraga*:
	$id_del_tag='11288';
	break;
	case *sover*:
	$id_del_tag='11289';
	break;
	case *spera*:
	$id_del_tag='11290';
	break;
	case *spiazzo*:
	$id_del_tag='11291';
	break;
	case *spormaggiore*:
	$id_del_tag='11292';
	break;
	case *sporminore*:
	$id_del_tag='11293';
	break;
	case *stenico*:
	$id_del_tag='11294';
	break;
	case *storo*:
	$id_del_tag='11295';
	break;
	case *strembo*:
	$id_del_tag='11296';
	break;
	case *strigno*:
	$id_del_tag='11297';
	break;
	case *taio*:
	$id_del_tag='11298';
	break;
	case *tassullo*:
	$id_del_tag='11299';
	break;
	case *telve*:
	$id_del_tag='11300';
	break;
	case *telve di sopra*:
	$id_del_tag='11301';
	break;
	case *tenna*:
	$id_del_tag='11302';
	break;
	case *tenno*:
	$id_del_tag='11303';
	break;
	case *terlago*:
	$id_del_tag='11304';
	break;
	case *terragnolo*:
	$id_del_tag='11305';
	break;
	case *terres*:
	$id_del_tag='11306';
	break;
	case *terzolas*:
	$id_del_tag='11307';
	break;
	case *tesero*:
	$id_del_tag='11308';
	break;
	case *tiarno di sopra*:
	$id_del_tag='11309';
	break;
	case *tiarno di sotto*:
	$id_del_tag='11310';
	break;
	case *tione di trento*:
	$id_del_tag='11311';
	break;
	case *ton*:
	$id_del_tag='11312';
	break;
	case *tonadico*:
	$id_del_tag='11313';
	break;
	case *torcegno*:
	$id_del_tag='11314';
	break;
	case *trambileno*:
	$id_del_tag='11315';
	break;
	case *transacqua*:
	$id_del_tag='11316';
	break;
	case *tres*:
	$id_del_tag='11317';
	break;
	case *tuenno*:
	$id_del_tag='11318';
	break;
	case *valda*:
	$id_del_tag='11319';
	break;
	case *valfloriana*:
	$id_del_tag='11320';
	break;
	case *varena*:
	$id_del_tag='11321';
	break;
	case *vermiglio*:
	$id_del_tag='11322';
	break;
	case *vervò*:
	$id_del_tag='11323';
	break;
	case *vezzano*:
	$id_del_tag='11324';
	break;
	case *vignola-falesina*:
	$id_del_tag='11325';
	break;
	case *vigo di fassa*:
	$id_del_tag='11326';
	break;
	case *vigo rendena*:
	$id_del_tag='11327';
	break;
	case *vigolo vattaro*:
	$id_del_tag='11328';
	break;
	case *villa agnedo*:
	$id_del_tag='11329';
	break;
	case *villa lagarina*:
	$id_del_tag='11330';
	break;
	case *villa rendena*:
	$id_del_tag='11331';
	break;
	case *volano*:
	$id_del_tag='11332';
	break;
	case *zambana*:
	$id_del_tag='11333';
	break;
	case *ziano di fiemme*:
	$id_del_tag='11334';
	break;
	case *zuclo*:
	$id_del_tag='11335';
	break;
	case *affi*:
	$id_del_tag='11336';
	break;
	case *albaredo d'adige*:
	$id_del_tag='11337';
	break;
	case *angiari*:
	$id_del_tag='11338';
	break;
	case *arcole*:
	$id_del_tag='11339';
	break;
	case *badia calavena*:
	$id_del_tag='11340';
	break;
	case *bardolino*:
	$id_del_tag='11341';
	break;
	case *bevilacqua*:
	$id_del_tag='11342';
	break;
	case *bonavigo*:
	$id_del_tag='11343';
	break;
	case *boschi sant'anna*:
	$id_del_tag='11344';
	break;
	case *bosco chiesanuova*:
	$id_del_tag='11345';
	break;
	case *bovolone*:
	$id_del_tag='11346';
	break;
	case *brentino belluno*:
	$id_del_tag='11347';
	break;
	case *brenzone*:
	$id_del_tag='11348';
	break;
	case *buttapietra*:
	$id_del_tag='11349';
	break;
	case *caldiero*:
	$id_del_tag='11350';
	break;
	case *caprino veronese*:
	$id_del_tag='11351';
	break;
	case *casaleone*:
	$id_del_tag='11352';
	break;
	case *castagnaro*:
	$id_del_tag='11353';
	break;
	case *castel d'azzano*:
	$id_del_tag='11354';
	break;
	case *castelnuovo del garda*:
	$id_del_tag='11355';
	break;
	case *cavaion veronese*:
	$id_del_tag='11356';
	break;
	case *cazzano di tramigna*:
	$id_del_tag='11357';
	break;
	case *cerea*:
	$id_del_tag='11358';
	break;
	case *cerro veronese*:
	$id_del_tag='11359';
	break;
	case *cologna veneta*:
	$id_del_tag='11360';
	break;
	case *colognola ai colli*:
	$id_del_tag='11361';
	break;
	case *concamarise*:
	$id_del_tag='11362';
	break;
	case *costermano*:
	$id_del_tag='11363';
	break;
	case *dolcè*:
	$id_del_tag='11364';
	break;
	case *erbè*:
	$id_del_tag='11365';
	break;
	case *erbezzo*:
	$id_del_tag='11366';
	break;
	case *ferrara di monte baldo*:
	$id_del_tag='11367';
	break;
	case *fumane*:
	$id_del_tag='11368';
	break;
	case *garda*:
	$id_del_tag='11369';
	break;
	case *gazzo veronese*:
	$id_del_tag='11370';
	break;
	case *grezzana*:
	$id_del_tag='11371';
	break;
	case *illasi*:
	$id_del_tag='11372';
	break;
	case *isola della scala*:
	$id_del_tag='11373';
	break;
	case *isola rizza*:
	$id_del_tag='11374';
	break;
	case *lavagno*:
	$id_del_tag='11375';
	break;
	case *lazise*:
	$id_del_tag='11376';
	break;
	case *legnago*:
	$id_del_tag='11377';
	break;
	case *malcesine*:
	$id_del_tag='11378';
	break;
	case *marano di valpolicella*:
	$id_del_tag='11379';
	break;
	case *mezzane di sotto*:
	$id_del_tag='11380';
	break;
	case *minerbe*:
	$id_del_tag='11381';
	break;
	case *montecchia di crosara*:
	$id_del_tag='11382';
	break;
	case *monteforte d'alpone*:
	$id_del_tag='11383';
	break;
	case *mozzecane*:
	$id_del_tag='11384';
	break;
	case *negrar*:
	$id_del_tag='11385';
	break;
	case *nogara*:
	$id_del_tag='11386';
	break;
	case *nogarole rocca*:
	$id_del_tag='11387';
	break;
	case *palù*:
	$id_del_tag='11388';
	break;
	case *pastrengo*:
	$id_del_tag='11389';
	break;
	case *pescantina*:
	$id_del_tag='11390';
	break;
	case *peschiera del garda*:
	$id_del_tag='11391';
	break;
	case *povegliano veronese*:
	$id_del_tag='11392';
	break;
	case *pressana*:
	$id_del_tag='11393';
	break;
	case *rivoli veronese*:
	$id_del_tag='11394';
	break;
	case *roncà*:
	$id_del_tag='11395';
	break;
	case *ronco all'adige*:
	$id_del_tag='11396';
	break;
	case *roverè veronese*:
	$id_del_tag='11397';
	break;
	case *roveredo di guà*:
	$id_del_tag='11398';
	break;
	case *salizzole*:
	$id_del_tag='11399';
	break;
	case *san bonifacio*:
	$id_del_tag='11400';
	break;
	case *san giovanni ilarione*:
	$id_del_tag='11401';
	break;
	case *san giovanni lupatoto*:
	$id_del_tag='11402';
	break;
	case *san martino buon albergo*:
	$id_del_tag='11403';
	break;
	case *san mauro di saline*:
	$id_del_tag='11404';
	break;
	case *san pietro di morubio*:
	$id_del_tag='11405';
	break;
	case *san pietro in cariano*:
	$id_del_tag='11406';
	break;
	case *san zeno di montagna*:
	$id_del_tag='11407';
	break;
	case *sant'ambrogio di valpolicella*:
	$id_del_tag='11408';
	break;
	case *sant'anna d'alfaedo*:
	$id_del_tag='11409';
	break;
	case *selva di progno*:
	$id_del_tag='11410';
	break;
	case *soave*:
	$id_del_tag='11411';
	break;
	case *sommacampagna*:
	$id_del_tag='11412';
	break;
	case *sona*:
	$id_del_tag='11413';
	break;
	case *sorgà*:
	$id_del_tag='11414';
	break;
	case *terrazzo*:
	$id_del_tag='11415';
	break;
	case *torri del benaco*:
	$id_del_tag='11416';
	break;
	case *tregnago*:
	$id_del_tag='11417';
	break;
	case *trevenzuolo*:
	$id_del_tag='11418';
	break;
	case *valeggio sul mincio*:
	$id_del_tag='11419';
	break;
	case *velo veronese*:
	$id_del_tag='11420';
	break;
	case *veronella*:
	$id_del_tag='11421';
	break;
	case *vestenanova*:
	$id_del_tag='11422';
	break;
	case *vigasio*:
	$id_del_tag='11423';
	break;
	case *villa bartolomea*:
	$id_del_tag='11424';
	break;
	case *villafranca di verona*:
	$id_del_tag='11425';
	break;
	case *zevio*:
	$id_del_tag='11426';
	break;
	case *zimella*:
	$id_del_tag='11427';
	break;
	case *agugliaro*:
	$id_del_tag='11428';
	break;
	case *albettone*:
	$id_del_tag='11429';
	break;
	case *alonte*:
	$id_del_tag='11430';
	break;
	case *altavilla vicentina*:
	$id_del_tag='11431';
	break;
	case *altissimo*:
	$id_del_tag='11432';
	break;
	case *arcugnano*:
	$id_del_tag='11433';
	break;
	case *arsiero*:
	$id_del_tag='11434';
	break;
	case *arzignano*:
	$id_del_tag='11435';
	break;
	case *asiago*:
	$id_del_tag='11436';
	break;
	case *asigliano veneto*:
	$id_del_tag='11437';
	break;
	case *barbarano vicentino*:
	$id_del_tag='11438';
	break;
	case *bolzano vicentino*:
	$id_del_tag='11439';
	break;
	case *breganze*:
	$id_del_tag='11440';
	break;
	case *brendola*:
	$id_del_tag='11441';
	break;
	case *bressanvido*:
	$id_del_tag='11442';
	break;
	case *brogliano*:
	$id_del_tag='11443';
	break;
	case *caldogno*:
	$id_del_tag='11444';
	break;
	case *caltrano*:
	$id_del_tag='11445';
	break;
	case *calvene*:
	$id_del_tag='11446';
	break;
	case *camisano vicentino*:
	$id_del_tag='11447';
	break;
	case *campiglia dei berici*:
	$id_del_tag='11448';
	break;
	case *campolongo sul brenta*:
	$id_del_tag='11449';
	break;
	case *carrè*:
	$id_del_tag='11450';
	break;
	case *cartigliano*:
	$id_del_tag='11451';
	break;
	case *cassola*:
	$id_del_tag='11452';
	break;
	case *castegnero*:
	$id_del_tag='11453';
	break;
	case *castelgomberto*:
	$id_del_tag='11454';
	break;
	case *chiampo*:
	$id_del_tag='11455';
	break;
	case *chiuppano*:
	$id_del_tag='11456';
	break;
	case *cismon del grappa*:
	$id_del_tag='11457';
	break;
	case *cogollo del cengio*:
	$id_del_tag='11458';
	break;
	case *conco*:
	$id_del_tag='11459';
	break;
	case *costabissara*:
	$id_del_tag='11460';
	break;
	case *creazzo*:
	$id_del_tag='11461';
	break;
	case *crespadoro*:
	$id_del_tag='11462';
	break;
	case *dueville*:
	$id_del_tag='11463';
	break;
	case *enego*:
	$id_del_tag='11464';
	break;
	case *fara vicentino*:
	$id_del_tag='11465';
	break;
	case *foza*:
	$id_del_tag='11466';
	break;
	case *gallio*:
	$id_del_tag='11467';
	break;
	case *gambellara*:
	$id_del_tag='11468';
	break;
	case *gambugliano*:
	$id_del_tag='11469';
	break;
	case *grancona*:
	$id_del_tag='11470';
	break;
	case *grisignano di zocco*:
	$id_del_tag='11471';
	break;
	case *grumolo delle abbadesse*:
	$id_del_tag='11472';
	break;
	case *isola vicentina*:
	$id_del_tag='11473';
	break;
	case *laghi*:
	$id_del_tag='11474';
	break;
	case *lastebasse*:
	$id_del_tag='11475';
	break;
	case *longare*:
	$id_del_tag='11476';
	break;
	case *lonigo*:
	$id_del_tag='11477';
	break;
	case *lugo di vicenza*:
	$id_del_tag='11478';
	break;
	case *lusiana*:
	$id_del_tag='11479';
	break;
	case *malo*:
	$id_del_tag='11480';
	break;
	case *marano vicentino*:
	$id_del_tag='11481';
	break;
	case *marostica*:
	$id_del_tag='11482';
	break;
	case *mason vicentino*:
	$id_del_tag='11483';
	break;
	case *molvena*:
	$id_del_tag='11484';
	break;
	case *monte di malo*:
	$id_del_tag='11485';
	break;
	case *montebello vicentino*:
	$id_del_tag='11486';
	break;
	case *montecchio precalcino*:
	$id_del_tag='11487';
	break;
	case *montegalda*:
	$id_del_tag='11488';
	break;
	case *montegaldella*:
	$id_del_tag='11489';
	break;
	case *monteviale*:
	$id_del_tag='11490';
	break;
	case *monticello conte otto*:
	$id_del_tag='11491';
	break;
	case *montorso vicentino*:
	$id_del_tag='11492';
	break;
	case *mossano*:
	$id_del_tag='11493';
	break;
	case *mussolente*:
	$id_del_tag='11494';
	break;
	case *nanto*:
	$id_del_tag='11495';
	break;
	case *nogarole vicentino*:
	$id_del_tag='11496';
	break;
	case *nove*:
	$id_del_tag='11497';
	break;
	case *noventa vicentina*:
	$id_del_tag='11498';
	break;
	case *orgiano*:
	$id_del_tag='11499';
	break;
	case *pedemonte*:
	$id_del_tag='11500';
	break;
	case *pianezze*:
	$id_del_tag='11501';
	break;
	case *piovene rocchette*:
	$id_del_tag='11502';
	break;
	case *pojana maggiore*:
	$id_del_tag='11503';
	break;
	case *posina*:
	$id_del_tag='11504';
	break;
	case *pove del grappa*:
	$id_del_tag='11505';
	break;
	case *pozzoleone*:
	$id_del_tag='11506';
	break;
	case *quinto vicentino*:
	$id_del_tag='11507';
	break;
	case *recoaro terme*:
	$id_del_tag='11508';
	break;
	case *roana*:
	$id_del_tag='11509';
	break;
	case *rosà*:
	$id_del_tag='11510';
	break;
	case *rossano veneto*:
	$id_del_tag='11511';
	break;
	case *rotzo*:
	$id_del_tag='11512';
	break;
	case *salcedo*:
	$id_del_tag='11513';
	break;
	case *san germano dei berici*:
	$id_del_tag='11514';
	break;
	case *san nazario*:
	$id_del_tag='11515';
	break;
	case *san pietro mussolino*:
	$id_del_tag='11516';
	break;
	case *san vito di leguzzano*:
	$id_del_tag='11517';
	break;
	case *sandrigo*:
	$id_del_tag='11518';
	break;
	case *santorso*:
	$id_del_tag='11519';
	break;
	case *sarcedo*:
	$id_del_tag='11520';
	break;
	case *sarego*:
	$id_del_tag='11521';
	break;
	case *schiavon*:
	$id_del_tag='11522';
	break;
	case *solagna*:
	$id_del_tag='11523';
	break;
	case *sossano*:
	$id_del_tag='11524';
	break;
	case *sovizzo*:
	$id_del_tag='11525';
	break;
	case *tezze sul brenta*:
	$id_del_tag='11526';
	break;
	case *thiene*:
	$id_del_tag='11527';
	break;
	case *tonezza del cimone*:
	$id_del_tag='11528';
	break;
	case *torrebelvicino*:
	$id_del_tag='11529';
	break;
	case *torri di quartesolo*:
	$id_del_tag='11530';
	break;
	case *trissino*:
	$id_del_tag='11531';
	break;
	case *valdagno*:
	$id_del_tag='11532';
	break;
	case *valdastico*:
	$id_del_tag='11533';
	break;
	case *valli del pasubio*:
	$id_del_tag='11534';
	break;
	case *valstagna*:
	$id_del_tag='11535';
	break;
	case *velo d'astico*:
	$id_del_tag='11536';
	break;
	case *villaga*:
	$id_del_tag='11537';
	break;
	case *villaverla*:
	$id_del_tag='11538';
	break;
	case *zanè*:
	$id_del_tag='11539';
	break;
	case *zermeghedo*:
	$id_del_tag='11540';
	break;
	case *zovencedo*:
	$id_del_tag='11541';
	break;
	case *zugliano*:
	$id_del_tag='11542';
	break;
	case *agordo*:
	$id_del_tag='11543';
	break;
	case *alano di piave*:
	$id_del_tag='11544';
	break;
	case *alleghe*:
	$id_del_tag='11545';
	break;
	case *arsiè*:
	$id_del_tag='11546';
	break;
	case *auronzo di cadore*:
	$id_del_tag='11547';
	break;
	case *borca di cadore*:
	$id_del_tag='11548';
	break;
	case *calalzo di cadore*:
	$id_del_tag='11549';
	break;
	case *canale d'agordo*:
	$id_del_tag='11550';
	break;
	case *castellavazzo*:
	$id_del_tag='11551';
	break;
	case *cencenighe agordino*:
	$id_del_tag='11552';
	break;
	case *cesiomaggiore*:
	$id_del_tag='11553';
	break;
	case *chies d'alpago*:
	$id_del_tag='11554';
	break;
	case *cibiana di cadore*:
	$id_del_tag='11555';
	break;
	case *comelico superiore*:
	$id_del_tag='11556';
	break;
	case *danta di cadore*:
	$id_del_tag='11557';
	break;
	case *domegge di cadore*:
	$id_del_tag='11558';
	break;
	case *falcade*:
	$id_del_tag='11559';
	break;
	case *farra d'alpago*:
	$id_del_tag='11560';
	break;
	case *fonzaso*:
	$id_del_tag='11561';
	break;
	case *forno di zoldo*:
	$id_del_tag='11562';
	break;
	case *gosaldo*:
	$id_del_tag='11563';
	break;
	case *la valle agordina*:
	$id_del_tag='11564';
	break;
	case *lentiai*:
	$id_del_tag='11565';
	break;
	case *limana*:
	$id_del_tag='11566';
	break;
	case *longarone*:
	$id_del_tag='11567';
	break;
	case *lorenzago di cadore*:
	$id_del_tag='11568';
	break;
	case *lozzo di cadore*:
	$id_del_tag='11569';
	break;
	case *mel*:
	$id_del_tag='11570';
	break;
	case *ospitale di cadore*:
	$id_del_tag='11571';
	break;
	case *pedavena*:
	$id_del_tag='11572';
	break;
	case *perarolo di cadore*:
	$id_del_tag='11573';
	break;
	case *pieve d'alpago*:
	$id_del_tag='11574';
	break;
	case *pieve di cadore*:
	$id_del_tag='11575';
	break;
	case *ponte nelle alpi*:
	$id_del_tag='11576';
	break;
	case *puos d'alpago*:
	$id_del_tag='11577';
	break;
	case *quero*:
	$id_del_tag='11578';
	break;
	case *rivamonte agordino*:
	$id_del_tag='11579';
	break;
	case *rocca pietore*:
	$id_del_tag='11580';
	break;
	case *san gregorio nelle alpi*:
	$id_del_tag='11581';
	break;
	case *san nicolò di comelico*:
	$id_del_tag='11582';
	break;
	case *san pietro di cadore*:
	$id_del_tag='11583';
	break;
	case *san tomaso agordino*:
	$id_del_tag='11584';
	break;
	case *san vito di cadore*:
	$id_del_tag='11585';
	break;
	case *santa giustina*:
	$id_del_tag='11586';
	break;
	case *santo stefano di cadore*:
	$id_del_tag='11587';
	break;
	case *sedico*:
	$id_del_tag='11588';
	break;
	case *selva di cadore*:
	$id_del_tag='11589';
	break;
	case *seren del grappa*:
	$id_del_tag='11590';
	break;
	case *sospirolo*:
	$id_del_tag='11591';
	break;
	case *soverzene*:
	$id_del_tag='11592';
	break;
	case *taibon agordino*:
	$id_del_tag='11593';
	break;
	case *tambre*:
	$id_del_tag='11594';
	break;
	case *trichiana*:
	$id_del_tag='11595';
	break;
	case *vallada agordina*:
	$id_del_tag='11596';
	break;
	case *valle di cadore*:
	$id_del_tag='11597';
	break;
	case *vas*:
	$id_del_tag='11598';
	break;
	case *vigo di cadore*:
	$id_del_tag='11599';
	break;
	case *vodo cadore*:
	$id_del_tag='11600';
	break;
	case *voltago agordino*:
	$id_del_tag='11601';
	break;
	case *zoldo alto*:
	$id_del_tag='11602';
	break;
	case *zoppè di cadore*:
	$id_del_tag='11603';
	break;
	case *altivole*:
	$id_del_tag='11604';
	break;
	case *arcade*:
	$id_del_tag='11605';
	break;
	case *asolo*:
	$id_del_tag='11606';
	break;
	case *borso del grappa*:
	$id_del_tag='11607';
	break;
	case *breda di piave*:
	$id_del_tag='11608';
	break;
	case *caerano di san marco*:
	$id_del_tag='11609';
	break;
	case *cappella maggiore*:
	$id_del_tag='11610';
	break;
	case *carbonera*:
	$id_del_tag='11611';
	break;
	case *casier*:
	$id_del_tag='11612';
	break;
	case *castelcucco*:
	$id_del_tag='11613';
	break;
	case *castello di godego*:
	$id_del_tag='11614';
	break;
	case *cavaso del tomba*:
	$id_del_tag='11615';
	break;
	case *cessalto*:
	$id_del_tag='11616';
	break;
	case *chiarano*:
	$id_del_tag='11617';
	break;
	case *cimadolmo*:
	$id_del_tag='11618';
	break;
	case *cison di valmarino*:
	$id_del_tag='11619';
	break;
	case *codognè*:
	$id_del_tag='11620';
	break;
	case *colle umberto*:
	$id_del_tag='11621';
	break;
	case *conegliano*:
	$id_del_tag='11622';
	break;
	case *cordignano*:
	$id_del_tag='11623';
	break;
	case *cornuda*:
	$id_del_tag='11624';
	break;
	case *crespano del grappa*:
	$id_del_tag='11625';
	break;
	case *farra di soligo*:
	$id_del_tag='11626';
	break;
	case *follina*:
	$id_del_tag='11627';
	break;
	case *fontanelle*:
	$id_del_tag='11628';
	break;
	case *fonte*:
	$id_del_tag='11629';
	break;
	case *fregona*:
	$id_del_tag='11630';
	break;
	case *gaiarine*:
	$id_del_tag='11631';
	break;
	case *giavera del montello*:
	$id_del_tag='11632';
	break;
	case *godega di sant'urbano*:
	$id_del_tag='11633';
	break;
	case *gorgo al monticano*:
	$id_del_tag='11634';
	break;
	case *istrana*:
	$id_del_tag='11635';
	break;
	case *loria*:
	$id_del_tag='11636';
	break;
	case *mansuè*:
	$id_del_tag='11637';
	break;
	case *mareno di piave*:
	$id_del_tag='11638';
	break;
	case *maser*:
	$id_del_tag='11639';
	break;
	case *maserada sul piave*:
	$id_del_tag='11640';
	break;
	case *meduna di livenza*:
	$id_del_tag='11641';
	break;
	case *miane*:
	$id_del_tag='11642';
	break;
	case *mogliano veneto*:
	$id_del_tag='11643';
	break;
	case *monastier di treviso*:
	$id_del_tag='11644';
	break;
	case *monfumo*:
	$id_del_tag='11645';
	break;
	case *montebelluna*:
	$id_del_tag='11646';
	break;
	case *morgano*:
	$id_del_tag='11647';
	break;
	case *moriago della battaglia*:
	$id_del_tag='11648';
	break;
	case *motta di livenza*:
	$id_del_tag='11649';
	break;
	case *nervesa della battaglia*:
	$id_del_tag='11650';
	break;
	case *ormelle*:
	$id_del_tag='11651';
	break;
	case *orsago*:
	$id_del_tag='11652';
	break;
	case *paderno del grappa*:
	$id_del_tag='11653';
	break;
	case *paese*:
	$id_del_tag='11654';
	break;
	case *pederobba*:
	$id_del_tag='11655';
	break;
	case *pieve di soligo*:
	$id_del_tag='11656';
	break;
	case *ponte di piave*:
	$id_del_tag='11657';
	break;
	case *ponzano veneto*:
	$id_del_tag='11658';
	break;
	case *portobuffolè*:
	$id_del_tag='11659';
	break;
	case *possagno*:
	$id_del_tag='11660';
	break;
	case *povegliano*:
	$id_del_tag='11661';
	break;
	case *preganziol*:
	$id_del_tag='11662';
	break;
	case *quinto di treviso*:
	$id_del_tag='11663';
	break;
	case *refrontolo*:
	$id_del_tag='11664';
	break;
	case *resana*:
	$id_del_tag='11665';
	break;
	case *revine lago*:
	$id_del_tag='11666';
	break;
	case *riese pio x*:
	$id_del_tag='11667';
	break;
	case *roncade*:
	$id_del_tag='11668';
	break;
	case *salgareda*:
	$id_del_tag='11669';
	break;
	case *san biagio di callalta*:
	$id_del_tag='11670';
	break;
	case *san pietro di feletto*:
	$id_del_tag='11671';
	break;
	case *san polo di piave*:
	$id_del_tag='11672';
	break;
	case *san vendemiano*:
	$id_del_tag='11673';
	break;
	case *san zenone degli ezzelini*:
	$id_del_tag='11674';
	break;
	case *santa lucia di piave*:
	$id_del_tag='11675';
	break;
	case *sarmede*:
	$id_del_tag='11676';
	break;
	case *segusino*:
	$id_del_tag='11677';
	break;
	case *sernaglia della battaglia*:
	$id_del_tag='11678';
	break;
	case *silea*:
	$id_del_tag='11679';
	break;
	case *spresiano*:
	$id_del_tag='11680';
	break;
	case *tarzo*:
	$id_del_tag='11681';
	break;
	case *trevignano*:
	$id_del_tag='11682';
	break;
	case *valdobbiadene*:
	$id_del_tag='11683';
	break;
	case *vazzola*:
	$id_del_tag='11684';
	break;
	case *vedelago*:
	$id_del_tag='11685';
	break;
	case *vidor*:
	$id_del_tag='11686';
	break;
	case *villorba*:
	$id_del_tag='11687';
	break;
	case *vittorio veneto*:
	$id_del_tag='11688';
	break;
	case *volpago del montello*:
	$id_del_tag='11689';
	break;
	case *zenson di piave*:
	$id_del_tag='11690';
	break;
	case *zero branco*:
	$id_del_tag='11691';
	break;
	case *annone veneto*:
	$id_del_tag='11692';
	break;
	case *campagna lupia*:
	$id_del_tag='11693';
	break;
	case *campolongo maggiore*:
	$id_del_tag='11694';
	break;
	case *camponogara*:
	$id_del_tag='11695';
	break;
	case *caorle*:
	$id_del_tag='11696';
	break;
	case *cavarzere*:
	$id_del_tag='11697';
	break;
	case *ceggia*:
	$id_del_tag='11698';
	break;
	case *cona*:
	$id_del_tag='11699';
	break;
	case *concordia sagittaria*:
	$id_del_tag='11700';
	break;
	case *dolo*:
	$id_del_tag='11701';
	break;
	case *eraclea*:
	$id_del_tag='11702';
	break;
	case *fiesso d'artico*:
	$id_del_tag='11703';
	break;
	case *fossalta di piave*:
	$id_del_tag='11704';
	break;
	case *fossò*:
	$id_del_tag='11705';
	break;
	case *gruaro*:
	$id_del_tag='11706';
	break;
	case *jesolo*:
	$id_del_tag='11707';
	break;
	case *marcon*:
	$id_del_tag='11708';
	break;
	case *martellago*:
	$id_del_tag='11709';
	break;
	case *meolo*:
	$id_del_tag='11710';
	break;
	case *mira*:
	$id_del_tag='11711';
	break;
	case *mirano*:
	$id_del_tag='11712';
	break;
	case *musile di piave*:
	$id_del_tag='11713';
	break;
	case *noale*:
	$id_del_tag='11714';
	break;
	case *noventa di piave*:
	$id_del_tag='11715';
	break;
	case *pianiga*:
	$id_del_tag='11716';
	break;
	case *pramaggiore*:
	$id_del_tag='11717';
	break;
	case *quarto d'altino*:
	$id_del_tag='11718';
	break;
	case *salzano*:
	$id_del_tag='11719';
	break;
	case *san donà di piave*:
	$id_del_tag='11720';
	break;
	case *san michele al tagliamento*:
	$id_del_tag='11721';
	break;
	case *santa maria di sala*:
	$id_del_tag='11722';
	break;
	case *santo stino di livenza*:
	$id_del_tag='11723';
	break;
	case *scorzè*:
	$id_del_tag='11724';
	break;
	case *spinea*:
	$id_del_tag='11725';
	break;
	case *stra*:
	$id_del_tag='11726';
	break;
	case *teglio veneto*:
	$id_del_tag='11727';
	break;
	case *torre di mosto*:
	$id_del_tag='11728';
	break;
	case *vigonovo*:
	$id_del_tag='11729';
	break;
	case *agna*:
	$id_del_tag='11730';
	break;
	case *anguillara veneta*:
	$id_del_tag='11731';
	break;
	case *arquà petrarca*:
	$id_del_tag='11732';
	break;
	case *arre*:
	$id_del_tag='11733';
	break;
	case *arzergrande*:
	$id_del_tag='11734';
	break;
	case *bagnoli di sopra*:
	$id_del_tag='11735';
	break;
	case *baone*:
	$id_del_tag='11736';
	break;
	case *barbona*:
	$id_del_tag='11737';
	break;
	case *battaglia terme*:
	$id_del_tag='11738';
	break;
	case *boara pisani*:
	$id_del_tag='11739';
	break;
	case *borgoricco*:
	$id_del_tag='11740';
	break;
	case *bovolenta*:
	$id_del_tag='11741';
	break;
	case *brugine*:
	$id_del_tag='11742';
	break;
	case *cadoneghe*:
	$id_del_tag='11743';
	break;
	case *campo san martino*:
	$id_del_tag='11744';
	break;
	case *campodarsego*:
	$id_del_tag='11745';
	break;
	case *campodoro*:
	$id_del_tag='11746';
	break;
	case *camposampiero*:
	$id_del_tag='11747';
	break;
	case *candiana*:
	$id_del_tag='11748';
	break;
	case *carceri*:
	$id_del_tag='11749';
	break;
	case *carmignano di brenta*:
	$id_del_tag='11750';
	break;
	case *cartura*:
	$id_del_tag='11751';
	break;
	case *casale di scodosia*:
	$id_del_tag='11752';
	break;
	case *casalserugo*:
	$id_del_tag='11753';
	break;
	case *castelbaldo*:
	$id_del_tag='11754';
	break;
	case *cervarese santa croce*:
	$id_del_tag='11755';
	break;
	case *cinto euganeo*:
	$id_del_tag='11756';
	break;
	case *cittadella*:
	$id_del_tag='11757';
	break;
	case *codevigo*:
	$id_del_tag='11758';
	break;
	case *conselve*:
	$id_del_tag='11759';
	break;
	case *correzzola*:
	$id_del_tag='11760';
	break;
	case *curtarolo*:
	$id_del_tag='11761';
	break;
	case *due carrare*:
	$id_del_tag='11762';
	break;
	case *este*:
	$id_del_tag='11763';
	break;
	case *fontaniva*:
	$id_del_tag='11764';
	break;
	case *galliera veneta*:
	$id_del_tag='11765';
	break;
	case *galzignano terme*:
	$id_del_tag='11766';
	break;
	case *gazzo*:
	$id_del_tag='11767';
	break;
	case *grantorto*:
	$id_del_tag='11768';
	break;
	case *granze*:
	$id_del_tag='11769';
	break;
	case *legnaro*:
	$id_del_tag='11770';
	break;
	case *limena*:
	$id_del_tag='11771';
	break;
	case *loreggia*:
	$id_del_tag='11772';
	break;
	case *lozzo atestino*:
	$id_del_tag='11773';
	break;
	case *maserà di padova*:
	$id_del_tag='11774';
	break;
	case *masi*:
	$id_del_tag='11775';
	break;
	case *massanzago*:
	$id_del_tag='11776';
	break;
	case *megliadino san fidenzio*:
	$id_del_tag='11777';
	break;
	case *megliadino san vitale*:
	$id_del_tag='11778';
	break;
	case *merlara*:
	$id_del_tag='11779';
	break;
	case *mestrino*:
	$id_del_tag='11780';
	break;
	case *monselice*:
	$id_del_tag='11781';
	break;
	case *montegrotto terme*:
	$id_del_tag='11782';
	break;
	case *noventa padovana*:
	$id_del_tag='11783';
	break;
	case *ospedaletto euganeo*:
	$id_del_tag='11784';
	break;
	case *pernumia*:
	$id_del_tag='11785';
	break;
	case *piacenza d'adige*:
	$id_del_tag='11786';
	break;
	case *piazzola sul brenta*:
	$id_del_tag='11787';
	break;
	case *piombino dese*:
	$id_del_tag='11788';
	break;
	case *piove di sacco*:
	$id_del_tag='11789';
	break;
	case *polverara*:
	$id_del_tag='11790';
	break;
	case *ponso*:
	$id_del_tag='11791';
	break;
	case *ponte san nicolò*:
	$id_del_tag='11792';
	break;
	case *pontelongo*:
	$id_del_tag='11793';
	break;
	case *pozzonovo*:
	$id_del_tag='11794';
	break;
	case *rovolon*:
	$id_del_tag='11795';
	break;
	case *rubano*:
	$id_del_tag='11796';
	break;
	case *saccolongo*:
	$id_del_tag='11797';
	break;
	case *saletto*:
	$id_del_tag='11798';
	break;
	case *san giorgio delle pertiche*:
	$id_del_tag='11799';
	break;
	case *san giorgio in bosco*:
	$id_del_tag='11800';
	break;
	case *san martino di lupari*:
	$id_del_tag='11801';
	break;
	case *san pietro in gu*:
	$id_del_tag='11802';
	break;
	case *san pietro viminario*:
	$id_del_tag='11803';
	break;
	case *santa giustina in colle*:
	$id_del_tag='11804';
	break;
	case *santa margherita d'adige*:
	$id_del_tag='11805';
	break;
	case *sant'angelo di piove di sacco*:
	$id_del_tag='11806';
	break;
	case *sant'elena*:
	$id_del_tag='11807';
	break;
	case *sant'urbano*:
	$id_del_tag='11808';
	break;
	case *saonara*:
	$id_del_tag='11809';
	break;
	case *selvazzano dentro*:
	$id_del_tag='11810';
	break;
	case *solesino*:
	$id_del_tag='11811';
	break;
	case *stanghella*:
	$id_del_tag='11812';
	break;
	case *terrassa padovana*:
	$id_del_tag='11813';
	break;
	case *tombolo*:
	$id_del_tag='11814';
	break;
	case *torreglia*:
	$id_del_tag='11815';
	break;
	case *trebaseleghe*:
	$id_del_tag='11816';
	break;
	case *tribano*:
	$id_del_tag='11817';
	break;
	case *urbana*:
	$id_del_tag='11818';
	break;
	case *veggiano*:
	$id_del_tag='11819';
	break;
	case *vescovana*:
	$id_del_tag='11820';
	break;
	case *vighizzolo d'este*:
	$id_del_tag='11821';
	break;
	case *vigodarzere*:
	$id_del_tag='11822';
	break;
	case *vigonza*:
	$id_del_tag='11823';
	break;
	case *villa del conte*:
	$id_del_tag='11824';
	break;
	case *villa estense*:
	$id_del_tag='11825';
	break;
	case *villafranca padovana*:
	$id_del_tag='11826';
	break;
	case *villanova di camposampiero*:
	$id_del_tag='11827';
	break;
	case *vo'*:
	$id_del_tag='11828';
	break;
	case *arquà polesine*:
	$id_del_tag='11829';
	break;
	case *badia polesine*:
	$id_del_tag='11830';
	break;
	case *bagnolo di po*:
	$id_del_tag='11831';
	break;
	case *bergantino*:
	$id_del_tag='11832';
	break;
	case *bosaro*:
	$id_del_tag='11833';
	break;
	case *calto*:
	$id_del_tag='11834';
	break;
	case *canaro*:
	$id_del_tag='11835';
	break;
	case *canda*:
	$id_del_tag='11836';
	break;
	case *castelguglielmo*:
	$id_del_tag='11837';
	break;
	case *castelmassa*:
	$id_del_tag='11838';
	break;
	case *castelnovo bariano*:
	$id_del_tag='11839';
	break;
	case *ceneselli*:
	$id_del_tag='11840';
	break;
	case *ceregnano*:
	$id_del_tag='11841';
	break;
	case *corbola*:
	$id_del_tag='11842';
	break;
	case *costa di rovigo*:
	$id_del_tag='11843';
	break;
	case *crespino*:
	$id_del_tag='11844';
	break;
	case *ficarolo*:
	$id_del_tag='11845';
	break;
	case *fiesso umbertiano*:
	$id_del_tag='11846';
	break;
	case *frassinelle polesine*:
	$id_del_tag='11847';
	break;
	case *fratta polesine*:
	$id_del_tag='11848';
	break;
	case *gaiba*:
	$id_del_tag='11849';
	break;
	case *gavello*:
	$id_del_tag='11850';
	break;
	case *giacciano con baruchella*:
	$id_del_tag='11851';
	break;
	case *guarda veneta*:
	$id_del_tag='11852';
	break;
	case *lendinara*:
	$id_del_tag='11853';
	break;
	case *loreo*:
	$id_del_tag='11854';
	break;
	case *lusia*:
	$id_del_tag='11855';
	break;
	case *melara*:
	$id_del_tag='11856';
	break;
	case *occhiobello*:
	$id_del_tag='11857';
	break;
	case *papozze*:
	$id_del_tag='11858';
	break;
	case *pettorazza grimani*:
	$id_del_tag='11859';
	break;
	case *pincara*:
	$id_del_tag='11860';
	break;
	case *polesella*:
	$id_del_tag='11861';
	break;
	case *pontecchio polesine*:
	$id_del_tag='11862';
	break;
	case *porto tolle*:
	$id_del_tag='11863';
	break;
	case *porto viro*:
	$id_del_tag='11864';
	break;
	case *rosolina*:
	$id_del_tag='11865';
	break;
	case *salara*:
	$id_del_tag='11866';
	break;
	case *san bellino*:
	$id_del_tag='11867';
	break;
	case *san martino di venezze*:
	$id_del_tag='11868';
	break;
	case *stienta*:
	$id_del_tag='11869';
	break;
	case *taglio di po*:
	$id_del_tag='11870';
	break;
	case *villadose*:
	$id_del_tag='11871';
	break;
	case *villamarzana*:
	$id_del_tag='11872';
	break;
	case *villanova del ghebbo*:
	$id_del_tag='11873';
	break;
	case *villanova marchesana*:
	$id_del_tag='11874';
	break;
	case *aiello del friuli*:
	$id_del_tag='11875';
	break;
	case *amaro*:
	$id_del_tag='11876';
	break;
	case *ampezzo*:
	$id_del_tag='11877';
	break;
	case *aquileia*:
	$id_del_tag='11878';
	break;
	case *arta terme*:
	$id_del_tag='11879';
	break;
	case *artegna*:
	$id_del_tag='11880';
	break;
	case *attimis*:
	$id_del_tag='11881';
	break;
	case *bagnaria arsa*:
	$id_del_tag='11882';
	break;
	case *basiliano*:
	$id_del_tag='11883';
	break;
	case *bertiolo*:
	$id_del_tag='11884';
	break;
	case *bicinicco*:
	$id_del_tag='11885';
	break;
	case *bordano*:
	$id_del_tag='11886';
	break;
	case *buja*:
	$id_del_tag='11887';
	break;
	case *buttrio*:
	$id_del_tag='11888';
	break;
	case *camino al tagliamento*:
	$id_del_tag='11889';
	break;
	case *campoformido*:
	$id_del_tag='11890';
	break;
	case *campolongo al torre*:
	$id_del_tag='11891';
	break;
	case *carlino*:
	$id_del_tag='11892';
	break;
	case *cassacco*:
	$id_del_tag='11893';
	break;
	case *castions di strada*:
	$id_del_tag='11894';
	break;
	case *cavazzo carnico*:
	$id_del_tag='11895';
	break;
	case *cercivento*:
	$id_del_tag='11896';
	break;
	case *cervignano del friuli*:
	$id_del_tag='11897';
	break;
	case *chiopris-viscone*:
	$id_del_tag='11898';
	break;
	case *chiusaforte*:
	$id_del_tag='11899';
	break;
	case *cividale del friuli*:
	$id_del_tag='11900';
	break;
	case *codroipo*:
	$id_del_tag='11901';
	break;
	case *colloredo di monte albano*:
	$id_del_tag='11902';
	break;
	case *comeglians*:
	$id_del_tag='11903';
	break;
	case *corno di rosazzo*:
	$id_del_tag='11904';
	break;
	case *coseano*:
	$id_del_tag='11905';
	break;
	case *dignano*:
	$id_del_tag='11906';
	break;
	case *dogna*:
	$id_del_tag='11907';
	break;
	case *drenchia*:
	$id_del_tag='11908';
	break;
	case *enemonzo*:
	$id_del_tag='11909';
	break;
	case *faedis*:
	$id_del_tag='11910';
	break;
	case *fagagna*:
	$id_del_tag='11911';
	break;
	case *fiumicello*:
	$id_del_tag='11912';
	break;
	case *flaibano*:
	$id_del_tag='11913';
	break;
	case *forgaria nel friuli*:
	$id_del_tag='11914';
	break;
	case *forni avoltri*:
	$id_del_tag='11915';
	break;
	case *forni di sopra*:
	$id_del_tag='11916';
	break;
	case *forni di sotto*:
	$id_del_tag='11917';
	break;
	case *gemona del friuli*:
	$id_del_tag='11918';
	break;
	case *gonars*:
	$id_del_tag='11919';
	break;
	case *grimacco*:
	$id_del_tag='11920';
	break;
	case *latisana*:
	$id_del_tag='11921';
	break;
	case *lauco*:
	$id_del_tag='11922';
	break;
	case *lestizza*:
	$id_del_tag='11923';
	break;
	case *lignano sabbiadoro*:
	$id_del_tag='11924';
	break;
	case *ligosullo*:
	$id_del_tag='11925';
	break;
	case *lusevera*:
	$id_del_tag='11926';
	break;
	case *magnano in riviera*:
	$id_del_tag='11927';
	break;
	case *majano*:
	$id_del_tag='11928';
	break;
	case *malborghetto valbruna*:
	$id_del_tag='11929';
	break;
	case *manzano*:
	$id_del_tag='11930';
	break;
	case *mereto di tomba*:
	$id_del_tag='11931';
	break;
	case *moggio udinese*:
	$id_del_tag='11932';
	break;
	case *moimacco*:
	$id_del_tag='11933';
	break;
	case *montenars*:
	$id_del_tag='11934';
	break;
	case *mortegliano*:
	$id_del_tag='11935';
	break;
	case *moruzzo*:
	$id_del_tag='11936';
	break;
	case *muzzana del turgnano*:
	$id_del_tag='11937';
	break;
	case *nimis*:
	$id_del_tag='11938';
	break;
	case *osoppo*:
	$id_del_tag='11939';
	break;
	case *ovaro*:
	$id_del_tag='11940';
	break;
	case *pagnacco*:
	$id_del_tag='11941';
	break;
	case *palazzolo dello stella*:
	$id_del_tag='11942';
	break;
	case *palmanova*:
	$id_del_tag='11943';
	break;
	case *paluzza*:
	$id_del_tag='11944';
	break;
	case *pasian di prato*:
	$id_del_tag='11945';
	break;
	case *paularo*:
	$id_del_tag='11946';
	break;
	case *pavia di udine*:
	$id_del_tag='11947';
	break;
	case *pocenia*:
	$id_del_tag='11948';
	break;
	case *pontebba*:
	$id_del_tag='11949';
	break;
	case *porpetto*:
	$id_del_tag='11950';
	break;
	case *povoletto*:
	$id_del_tag='11951';
	break;
	case *pozzuolo del friuli*:
	$id_del_tag='11952';
	break;
	case *pradamano*:
	$id_del_tag='11953';
	break;
	case *prato carnico*:
	$id_del_tag='11954';
	break;
	case *premariacco*:
	$id_del_tag='11955';
	break;
	case *preone*:
	$id_del_tag='11956';
	break;
	case *prepotto*:
	$id_del_tag='11957';
	break;
	case *pulfero*:
	$id_del_tag='11958';
	break;
	case *ragogna*:
	$id_del_tag='11959';
	break;
	case *ravascletto*:
	$id_del_tag='11960';
	break;
	case *raveo*:
	$id_del_tag='11961';
	break;
	case *reana del rojale*:
	$id_del_tag='11962';
	break;
	case *remanzacco*:
	$id_del_tag='11963';
	break;
	case *resia*:
	$id_del_tag='11964';
	break;
	case *resiutta*:
	$id_del_tag='11965';
	break;
	case *rigolato*:
	$id_del_tag='11966';
	break;
	case *rive d'arcano*:
	$id_del_tag='11967';
	break;
	case *rivignano*:
	$id_del_tag='11968';
	break;
	case *ronchis*:
	$id_del_tag='11969';
	break;
	case *ruda*:
	$id_del_tag='11970';
	break;
	case *san daniele del friuli*:
	$id_del_tag='11971';
	break;
	case *san giorgio di nogaro*:
	$id_del_tag='11972';
	break;
	case *san giovanni al natisone*:
	$id_del_tag='11973';
	break;
	case *san leonardo*:
	$id_del_tag='11974';
	break;
	case *san pietro al natisone*:
	$id_del_tag='11975';
	break;
	case *san vito al torre*:
	$id_del_tag='11976';
	break;
	case *san vito di fagagna*:
	$id_del_tag='11977';
	break;
	case *santa maria la longa*:
	$id_del_tag='11978';
	break;
	case *sauris*:
	$id_del_tag='11979';
	break;
	case *savogna*:
	$id_del_tag='11980';
	break;
	case *sedegliano*:
	$id_del_tag='11981';
	break;
	case *socchieve*:
	$id_del_tag='11982';
	break;
	case *stregna*:
	$id_del_tag='11983';
	break;
	case *sutrio*:
	$id_del_tag='11984';
	break;
	case *taipana*:
	$id_del_tag='11985';
	break;
	case *talmassons*:
	$id_del_tag='11986';
	break;
	case *tapogliano*:
	$id_del_tag='11987';
	break;
	case *tarcento*:
	$id_del_tag='11988';
	break;
	case *tarvisio*:
	$id_del_tag='11989';
	break;
	case *tavagnacco*:
	$id_del_tag='11990';
	break;
	case *teor*:
	$id_del_tag='11991';
	break;
	case *terzo d'aquileia*:
	$id_del_tag='11992';
	break;
	case *torreano*:
	$id_del_tag='11993';
	break;
	case *trasaghis*:
	$id_del_tag='11994';
	break;
	case *treppo carnico*:
	$id_del_tag='11995';
	break;
	case *treppo grande*:
	$id_del_tag='11996';
	break;
	case *tricesimo*:
	$id_del_tag='11997';
	break;
	case *trivignano udinese*:
	$id_del_tag='11998';
	break;
	case *varmo*:
	$id_del_tag='11999';
	break;
	case *venzone*:
	$id_del_tag='12000';
	break;
	case *verzegnis*:
	$id_del_tag='12001';
	break;
	case *villa santina*:
	$id_del_tag='12002';
	break;
	case *villa vicentina*:
	$id_del_tag='12003';
	break;
	case *zuglio*:
	$id_del_tag='12004';
	break;
	case *capriva del friuli*:
	$id_del_tag='12005';
	break;
	case *cormons*:
	$id_del_tag='12006';
	break;
	case *doberdò del lago*:
	$id_del_tag='12007';
	break;
	case *dolegna del collio*:
	$id_del_tag='12008';
	break;
	case *farra d'isonzo*:
	$id_del_tag='12009';
	break;
	case *fogliano redipuglia*:
	$id_del_tag='12010';
	break;
	case *grado*:
	$id_del_tag='12011';
	break;
	case *mariano del friuli*:
	$id_del_tag='12012';
	break;
	case *medea*:
	$id_del_tag='12013';
	break;
	case *monfalcone*:
	$id_del_tag='12014';
	break;
	case *moraro*:
	$id_del_tag='12015';
	break;
	case *mossa*:
	$id_del_tag='12016';
	break;
	case *romans d'isonzo*:
	$id_del_tag='12017';
	break;
	case *ronchi dei legionari*:
	$id_del_tag='12018';
	break;
	case *sagrado*:
	$id_del_tag='12019';
	break;
	case *san canzian d'isonzo*:
	$id_del_tag='12020';
	break;
	case *san floriano del collio*:
	$id_del_tag='12021';
	break;
	case *san lorenzo isontino*:
	$id_del_tag='12022';
	break;
	case *san pier d'isonzo*:
	$id_del_tag='12023';
	break;
	case *savogna d'isonzo*:
	$id_del_tag='12024';
	break;
	case *staranzano*:
	$id_del_tag='12025';
	break;
	case *turriaco*:
	$id_del_tag='12026';
	break;
	case *villesse*:
	$id_del_tag='12027';
	break;
	case *duino-aurisina*:
	$id_del_tag='12028';
	break;
	case *monrupino*:
	$id_del_tag='12029';
	break;
	case *muggia*:
	$id_del_tag='12030';
	break;
	case *san dorligo della valle - dolina*:
	$id_del_tag='12031';
	break;
	case *sgonico*:
	$id_del_tag='12032';
	break;
	case *agazzano*:
	$id_del_tag='12033';
	break;
	case *alseno*:
	$id_del_tag='12034';
	break;
	case *besenzone*:
	$id_del_tag='12035';
	break;
	case *bettola*:
	$id_del_tag='12036';
	break;
	case *bobbio*:
	$id_del_tag='12037';
	break;
	case *borgonovo val tidone*:
	$id_del_tag='12038';
	break;
	case *cadeo*:
	$id_del_tag='12039';
	break;
	case *calendasco*:
	$id_del_tag='12040';
	break;
	case *caminata*:
	$id_del_tag='12041';
	break;
	case *carpaneto piacentino*:
	$id_del_tag='12042';
	break;
	case *castel san giovanni*:
	$id_del_tag='12043';
	break;
	case *castell'arquato*:
	$id_del_tag='12044';
	break;
	case *castelvetro piacentino*:
	$id_del_tag='12045';
	break;
	case *cerignale*:
	$id_del_tag='12046';
	break;
	case *coli*:
	$id_del_tag='12047';
	break;
	case *corte brugnatella*:
	$id_del_tag='12048';
	break;
	case *cortemaggiore*:
	$id_del_tag='12049';
	break;
	case *farini*:
	$id_del_tag='12050';
	break;
	case *ferriere*:
	$id_del_tag='12051';
	break;
	case *fiorenzuola d'arda*:
	$id_del_tag='12052';
	break;
	case *gazzola*:
	$id_del_tag='12053';
	break;
	case *gossolengo*:
	$id_del_tag='12054';
	break;
	case *gropparello*:
	$id_del_tag='12055';
	break;
	case *lugagnano val d'arda*:
	$id_del_tag='12056';
	break;
	case *monticelli d'ongina*:
	$id_del_tag='12057';
	break;
	case *morfasso*:
	$id_del_tag='12058';
	break;
	case *nibbiano*:
	$id_del_tag='12059';
	break;
	case *ottone*:
	$id_del_tag='12060';
	break;
	case *pecorara*:
	$id_del_tag='12061';
	break;
	case *pianello val tidone*:
	$id_del_tag='12062';
	break;
	case *piozzano*:
	$id_del_tag='12063';
	break;
	case *ponte dell'olio*:
	$id_del_tag='12064';
	break;
	case *pontenure*:
	$id_del_tag='12065';
	break;
	case *rivergaro*:
	$id_del_tag='12066';
	break;
	case *san pietro in cerro*:
	$id_del_tag='12067';
	break;
	case *sarmato*:
	$id_del_tag='12068';
	break;
	case *travo*:
	$id_del_tag='12069';
	break;
	case *vernasca*:
	$id_del_tag='12070';
	break;
	case *villanova sull'arda*:
	$id_del_tag='12071';
	break;
	case *zerba*:
	$id_del_tag='12072';
	break;
	case *ziano piacentino*:
	$id_del_tag='12073';
	break;
	case *albareto*:
	$id_del_tag='12074';
	break;
	case *bardi*:
	$id_del_tag='12075';
	break;
	case *bedonia*:
	$id_del_tag='12076';
	break;
	case *berceto*:
	$id_del_tag='12077';
	break;
	case *bore*:
	$id_del_tag='12078';
	break;
	case *borgo val di taro*:
	$id_del_tag='12079';
	break;
	case *calestano*:
	$id_del_tag='12080';
	break;
	case *collecchio*:
	$id_del_tag='12081';
	break;
	case *colorno*:
	$id_del_tag='12082';
	break;
	case *compiano*:
	$id_del_tag='12083';
	break;
	case *corniglio*:
	$id_del_tag='12084';
	break;
	case *felino*:
	$id_del_tag='12085';
	break;
	case *fontanellato*:
	$id_del_tag='12086';
	break;
	case *fontevivo*:
	$id_del_tag='12087';
	break;
	case *fornovo di taro*:
	$id_del_tag='12088';
	break;
	case *langhirano*:
	$id_del_tag='12089';
	break;
	case *lesignano de' bagni*:
	$id_del_tag='12090';
	break;
	case *mezzani*:
	$id_del_tag='12091';
	break;
	case *monchio delle corti*:
	$id_del_tag='12092';
	break;
	case *montechiarugolo*:
	$id_del_tag='12093';
	break;
	case *neviano degli arduini*:
	$id_del_tag='12094';
	break;
	case *noceto*:
	$id_del_tag='12095';
	break;
	case *palanzano*:
	$id_del_tag='12096';
	break;
	case *pellegrino parmense*:
	$id_del_tag='12097';
	break;
	case *polesine parmense*:
	$id_del_tag='12098';
	break;
	case *roccabianca*:
	$id_del_tag='12099';
	break;
	case *sala baganza*:
	$id_del_tag='12100';
	break;
	case *salsomaggiore terme*:
	$id_del_tag='12101';
	break;
	case *san secondo parmense*:
	$id_del_tag='12102';
	break;
	case *sissa*:
	$id_del_tag='12103';
	break;
	case *solignano*:
	$id_del_tag='12104';
	break;
	case *soragna*:
	$id_del_tag='12105';
	break;
	case *sorbolo*:
	$id_del_tag='12106';
	break;
	case *terenzo*:
	$id_del_tag='12107';
	break;
	case *tizzano val parma*:
	$id_del_tag='12108';
	break;
	case *tornolo*:
	$id_del_tag='12109';
	break;
	case *torrile*:
	$id_del_tag='12110';
	break;
	case *traversetolo*:
	$id_del_tag='12111';
	break;
	case *trecasali*:
	$id_del_tag='12112';
	break;
	case *valmozzola*:
	$id_del_tag='12113';
	break;
	case *varano de' melegari*:
	$id_del_tag='12114';
	break;
	case *varsi*:
	$id_del_tag='12115';
	break;
	case *zibello*:
	$id_del_tag='12116';
	break;
	case *albinea*:
	$id_del_tag='12117';
	break;
	case *bagnolo in piano*:
	$id_del_tag='12118';
	break;
	case *baiso*:
	$id_del_tag='12119';
	break;
	case *bibbiano*:
	$id_del_tag='12120';
	break;
	case *boretto*:
	$id_del_tag='12121';
	break;
	case *brescello*:
	$id_del_tag='12122';
	break;
	case *busana*:
	$id_del_tag='12123';
	break;
	case *cadelbosco di sopra*:
	$id_del_tag='12124';
	break;
	case *campagnola emilia*:
	$id_del_tag='12125';
	break;
	case *campegine*:
	$id_del_tag='12126';
	break;
	case *canossa*:
	$id_del_tag='12127';
	break;
	case *carpineti*:
	$id_del_tag='12128';
	break;
	case *casalgrande*:
	$id_del_tag='12129';
	break;
	case *casina*:
	$id_del_tag='12130';
	break;
	case *castellarano*:
	$id_del_tag='12131';
	break;
	case *castelnovo di sotto*:
	$id_del_tag='12132';
	break;
	case *cavriago*:
	$id_del_tag='12133';
	break;
	case *collagna*:
	$id_del_tag='12134';
	break;
	case *correggio*:
	$id_del_tag='12135';
	break;
	case *fabbrico*:
	$id_del_tag='12136';
	break;
	case *gattatico*:
	$id_del_tag='12137';
	break;
	case *gualtieri*:
	$id_del_tag='12138';
	break;
	case *ligonchio*:
	$id_del_tag='12139';
	break;
	case *luzzara*:
	$id_del_tag='12140';
	break;
	case *montecchio emilia*:
	$id_del_tag='12141';
	break;
	case *novellara*:
	$id_del_tag='12142';
	break;
	case *poviglio*:
	$id_del_tag='12143';
	break;
	case *quattro castella*:
	$id_del_tag='12144';
	break;
	case *ramiseto*:
	$id_del_tag='12145';
	break;
	case *reggiolo*:
	$id_del_tag='12146';
	break;
	case *rio saliceto*:
	$id_del_tag='12147';
	break;
	case *rolo*:
	$id_del_tag='12148';
	break;
	case *san martino in rio*:
	$id_del_tag='12149';
	break;
	case *san polo d'enza*:
	$id_del_tag='12150';
	break;
	case *sant'ilario d'enza*:
	$id_del_tag='12151';
	break;
	case *scandiano*:
	$id_del_tag='12152';
	break;
	case *toano*:
	$id_del_tag='12153';
	break;
	case *vetto*:
	$id_del_tag='12154';
	break;
	case *vezzano sul crostolo*:
	$id_del_tag='12155';
	break;
	case *viano*:
	$id_del_tag='12156';
	break;
	case *villa minozzo*:
	$id_del_tag='12157';
	break;
	case *bastiglia*:
	$id_del_tag='12158';
	break;
	case *bomporto*:
	$id_del_tag='12159';
	break;
	case *camposanto*:
	$id_del_tag='12160';
	break;
	case *castelfranco emilia*:
	$id_del_tag='12161';
	break;
	case *castelnuovo rangone*:
	$id_del_tag='12162';
	break;
	case *castelvetro di modena*:
	$id_del_tag='12163';
	break;
	case *cavezzo*:
	$id_del_tag='12164';
	break;
	case *concordia sulla secchia*:
	$id_del_tag='12165';
	break;
	case *fanano*:
	$id_del_tag='12166';
	break;
	case *fiorano modenese*:
	$id_del_tag='12167';
	break;
	case *fiumalbo*:
	$id_del_tag='12168';
	break;
	case *formigine*:
	$id_del_tag='12169';
	break;
	case *frassinoro*:
	$id_del_tag='12170';
	break;
	case *guiglia*:
	$id_del_tag='12171';
	break;
	case *lama mocogno*:
	$id_del_tag='12172';
	break;
	case *maranello*:
	$id_del_tag='12173';
	break;
	case *marano sul panaro*:
	$id_del_tag='12174';
	break;
	case *montecreto*:
	$id_del_tag='12175';
	break;
	case *montefiorino*:
	$id_del_tag='12176';
	break;
	case *montese*:
	$id_del_tag='12177';
	break;
	case *nonantola*:
	$id_del_tag='12178';
	break;
	case *novi di modena*:
	$id_del_tag='12179';
	break;
	case *palagano*:
	$id_del_tag='12180';
	break;
	case *pavullo nel frignano*:
	$id_del_tag='12181';
	break;
	case *pievepelago*:
	$id_del_tag='12182';
	break;
	case *polinago*:
	$id_del_tag='12183';
	break;
	case *prignano sulla secchia*:
	$id_del_tag='12184';
	break;
	case *ravarino*:
	$id_del_tag='12185';
	break;
	case *riolunato*:
	$id_del_tag='12186';
	break;
	case *san cesario sul panaro*:
	$id_del_tag='12187';
	break;
	case *san possidonio*:
	$id_del_tag='12188';
	break;
	case *san prospero*:
	$id_del_tag='12189';
	break;
	case *savignano sul panaro*:
	$id_del_tag='12190';
	break;
	case *serramazzoni*:
	$id_del_tag='12191';
	break;
	case *sestola*:
	$id_del_tag='12192';
	break;
	case *spilamberto*:
	$id_del_tag='12193';
	break;
	case *vignola*:
	$id_del_tag='12194';
	break;
	case *zocca*:
	$id_del_tag='12195';
	break;
	case *anzola dell'emilia*:
	$id_del_tag='12196';
	break;
	case *argelato*:
	$id_del_tag='12197';
	break;
	case *baricella*:
	$id_del_tag='12198';
	break;
	case *bazzano*:
	$id_del_tag='12199';
	break;
	case *bentivoglio*:
	$id_del_tag='12200';
	break;
	case *borgo tossignano*:
	$id_del_tag='12201';
	break;
	case *budrio*:
	$id_del_tag='12202';
	break;
	case *calderara di reno*:
	$id_del_tag='12203';
	break;
	case *camugnano*:
	$id_del_tag='12204';
	break;
	case *casalecchio di reno*:
	$id_del_tag='12205';
	break;
	case *casalfiumanese*:
	$id_del_tag='12206';
	break;
	case *castel d'aiano*:
	$id_del_tag='12207';
	break;
	case *castel del rio*:
	$id_del_tag='12208';
	break;
	case *castel di casio*:
	$id_del_tag='12209';
	break;
	case *castel guelfo di bologna*:
	$id_del_tag='12210';
	break;
	case *castel maggiore*:
	$id_del_tag='12211';
	break;
	case *castel san pietro terme*:
	$id_del_tag='12212';
	break;
	case *castello d'argile*:
	$id_del_tag='12213';
	break;
	case *castello di serravalle*:
	$id_del_tag='12214';
	break;
	case *castenaso*:
	$id_del_tag='12215';
	break;
	case *castiglione dei pepoli*:
	$id_del_tag='12216';
	break;
	case *crespellano*:
	$id_del_tag='12217';
	break;
	case *dozza*:
	$id_del_tag='12218';
	break;
	case *fontanelice*:
	$id_del_tag='12219';
	break;
	case *gaggio montano*:
	$id_del_tag='12220';
	break;
	case *galliera*:
	$id_del_tag='12221';
	break;
	case *granaglione*:
	$id_del_tag='12222';
	break;
	case *granarolo dell'emilia*:
	$id_del_tag='12223';
	break;
	case *imola*:
	$id_del_tag='12224';
	break;
	case *lizzano in belvedere*:
	$id_del_tag='12225';
	break;
	case *loiano*:
	$id_del_tag='12226';
	break;
	case *malalbergo*:
	$id_del_tag='12227';
	break;
	case *medicina*:
	$id_del_tag='12228';
	break;
	case *minerbio*:
	$id_del_tag='12229';
	break;
	case *molinella*:
	$id_del_tag='12230';
	break;
	case *monghidoro*:
	$id_del_tag='12231';
	break;
	case *monte san pietro*:
	$id_del_tag='12232';
	break;
	case *monterenzio*:
	$id_del_tag='12233';
	break;
	case *monteveglio*:
	$id_del_tag='12234';
	break;
	case *mordano*:
	$id_del_tag='12235';
	break;
	case *ozzano dell'emilia*:
	$id_del_tag='12236';
	break;
	case *pianoro*:
	$id_del_tag='12237';
	break;
	case *pieve di cento*:
	$id_del_tag='12238';
	break;
	case *porretta terme*:
	$id_del_tag='12239';
	break;
	case *sala bolognese*:
	$id_del_tag='12240';
	break;
	case *san benedetto val di sambro*:
	$id_del_tag='12241';
	break;
	case *san giorgio di piano*:
	$id_del_tag='12242';
	break;
	case *san giovanni in persiceto*:
	$id_del_tag='12243';
	break;
	case *san lazzaro di savena*:
	$id_del_tag='12244';
	break;
	case *san pietro in casale*:
	$id_del_tag='12245';
	break;
	case *sant'agata bolognese*:
	$id_del_tag='12246';
	break;
	case *savigno*:
	$id_del_tag='12247';
	break;
	case *vergato*:
	$id_del_tag='12248';
	break;
	case *zola predosa*:
	$id_del_tag='12249';
	break;
	case *argenta*:
	$id_del_tag='12250';
	break;
	case *berra*:
	$id_del_tag='12251';
	break;
	case *bondeno*:
	$id_del_tag='12252';
	break;
	case *cento*:
	$id_del_tag='12253';
	break;
	case *codigoro*:
	$id_del_tag='12254';
	break;
	case *comacchio*:
	$id_del_tag='12255';
	break;
	case *copparo*:
	$id_del_tag='12256';
	break;
	case *formignana*:
	$id_del_tag='12257';
	break;
	case *goro*:
	$id_del_tag='12258';
	break;
	case *jolanda di savoia*:
	$id_del_tag='12259';
	break;
	case *lagosanto*:
	$id_del_tag='12260';
	break;
	case *masi torello*:
	$id_del_tag='12261';
	break;
	case *massa fiscaglia*:
	$id_del_tag='12262';
	break;
	case *migliarino*:
	$id_del_tag='12263';
	break;
	case *migliaro*:
	$id_del_tag='12264';
	break;
	case *mirabello*:
	$id_del_tag='12265';
	break;
	case *ostellato*:
	$id_del_tag='12266';
	break;
	case *poggio renatico*:
	$id_del_tag='12267';
	break;
	case *portomaggiore*:
	$id_del_tag='12268';
	break;
	case *ro*:
	$id_del_tag='12269';
	break;
	case *sant'agostino*:
	$id_del_tag='12270';
	break;
	case *vigarano mainarda*:
	$id_del_tag='12271';
	break;
	case *voghiera*:
	$id_del_tag='12272';
	break;
	case *alfonsine*:
	$id_del_tag='12273';
	break;
	case *bagnacavallo*:
	$id_del_tag='12274';
	break;
	case *bagnara di romagna*:
	$id_del_tag='12275';
	break;
	case *brisighella*:
	$id_del_tag='12276';
	break;
	case *casola valsenio*:
	$id_del_tag='12277';
	break;
	case *castel bolognese*:
	$id_del_tag='12278';
	break;
	case *conselice*:
	$id_del_tag='12279';
	break;
	case *cotignola*:
	$id_del_tag='12280';
	break;
	case *faenza*:
	$id_del_tag='12281';
	break;
	case *fusignano*:
	$id_del_tag='12282';
	break;
	case *lugo*:
	$id_del_tag='12283';
	break;
	case *massa lombarda*:
	$id_del_tag='12284';
	break;
	case *riolo terme*:
	$id_del_tag='12285';
	break;
	case *russi*:
	$id_del_tag='12286';
	break;
	case *sant'agata sul santerno*:
	$id_del_tag='12287';
	break;
	case *solarolo*:
	$id_del_tag='12288';
	break;
	case *bagno di romagna*:
	$id_del_tag='12289';
	break;
	case *bertinoro*:
	$id_del_tag='12290';
	break;
	case *borghi*:
	$id_del_tag='12291';
	break;
	case *castrocaro terme e terra del sole*:
	$id_del_tag='12292';
	break;
	case *civitella di romagna*:
	$id_del_tag='12293';
	break;
	case *dovadola*:
	$id_del_tag='12294';
	break;
	case *forlimpopoli*:
	$id_del_tag='12295';
	break;
	case *galeata*:
	$id_del_tag='12296';
	break;
	case *gambettola*:
	$id_del_tag='12297';
	break;
	case *gatteo*:
	$id_del_tag='12298';
	break;
	case *meldola*:
	$id_del_tag='12299';
	break;
	case *mercato saraceno*:
	$id_del_tag='12300';
	break;
	case *modigliana*:
	$id_del_tag='12301';
	break;
	case *montiano*:
	$id_del_tag='12302';
	break;
	case *portico e san benedetto*:
	$id_del_tag='12303';
	break;
	case *predappio*:
	$id_del_tag='12304';
	break;
	case *premilcuore*:
	$id_del_tag='12305';
	break;
	case *rocca san casciano*:
	$id_del_tag='12306';
	break;
	case *roncofreddo*:
	$id_del_tag='12307';
	break;
	case *san mauro pascoli*:
	$id_del_tag='12308';
	break;
	case *santa sofia*:
	$id_del_tag='12309';
	break;
	case *sarsina*:
	$id_del_tag='12310';
	break;
	case *savignano sul rubicone*:
	$id_del_tag='12311';
	break;
	case *tredozio*:
	$id_del_tag='12312';
	break;
	case *verghereto*:
	$id_del_tag='12313';
	break;
	case *acqualagna*:
	$id_del_tag='12314';
	break;
	case *apecchio*:
	$id_del_tag='12315';
	break;
	case *auditore*:
	$id_del_tag='12316';
	break;
	case *barchi*:
	$id_del_tag='12317';
	break;
	case *belforte all'isauro*:
	$id_del_tag='12318';
	break;
	case *borgo pace*:
	$id_del_tag='12319';
	break;
	case *cagli*:
	$id_del_tag='12320';
	break;
	case *cantiano*:
	$id_del_tag='12321';
	break;
	case *carpegna*:
	$id_del_tag='12322';
	break;
	case *colbordolo*:
	$id_del_tag='12323';
	break;
	case *fano*:
	$id_del_tag='12324';
	break;
	case *fermignano*:
	$id_del_tag='12325';
	break;
	case *fossombrone*:
	$id_del_tag='12326';
	break;
	case *fratte rosa*:
	$id_del_tag='12327';
	break;
	case *frontino*:
	$id_del_tag='12328';
	break;
	case *frontone*:
	$id_del_tag='12329';
	break;
	case *gabicce mare*:
	$id_del_tag='12330';
	break;
	case *gradara*:
	$id_del_tag='12331';
	break;
	case *isola del piano*:
	$id_del_tag='12332';
	break;
	case *lunano*:
	$id_del_tag='12333';
	break;
	case *macerata feltria*:
	$id_del_tag='12334';
	break;
	case *mercatello sul metauro*:
	$id_del_tag='12335';
	break;
	case *mercatino conca*:
	$id_del_tag='12336';
	break;
	case *mombaroccio*:
	$id_del_tag='12337';
	break;
	case *mondavio*:
	$id_del_tag='12338';
	break;
	case *mondolfo*:
	$id_del_tag='12339';
	break;
	case *monte cerignone*:
	$id_del_tag='12340';
	break;
	case *monte grimano terme*:
	$id_del_tag='12341';
	break;
	case *monte porzio*:
	$id_del_tag='12342';
	break;
	case *montecalvo in foglia*:
	$id_del_tag='12343';
	break;
	case *monteciccardo*:
	$id_del_tag='12344';
	break;
	case *montefelcino*:
	$id_del_tag='12345';
	break;
	case *montelabbate*:
	$id_del_tag='12346';
	break;
	case *montemaggiore al metauro*:
	$id_del_tag='12347';
	break;
	case *orciano di pesaro*:
	$id_del_tag='12348';
	break;
	case *pergola*:
	$id_del_tag='12349';
	break;
	case *petriano*:
	$id_del_tag='12350';
	break;
	case *piagge*:
	$id_del_tag='12351';
	break;
	case *piandimeleto*:
	$id_del_tag='12352';
	break;
	case *pietrarubbia*:
	$id_del_tag='12353';
	break;
	case *piobbico*:
	$id_del_tag='12354';
	break;
	case *saltara*:
	$id_del_tag='12355';
	break;
	case *san costanzo*:
	$id_del_tag='12356';
	break;
	case *san giorgio di pesaro*:
	$id_del_tag='12357';
	break;
	case *san lorenzo in campo*:
	$id_del_tag='12358';
	break;
	case *sant'angelo in lizzola*:
	$id_del_tag='12359';
	break;
	case *sant'angelo in vado*:
	$id_del_tag='12360';
	break;
	case *sant'ippolito*:
	$id_del_tag='12361';
	break;
	case *sassocorvaro*:
	$id_del_tag='12362';
	break;
	case *serra sant'abbondio*:
	$id_del_tag='12363';
	break;
	case *serrungarina*:
	$id_del_tag='12364';
	break;
	case *tavoleto*:
	$id_del_tag='12365';
	break;
	case *tavullia*:
	$id_del_tag='12366';
	break;
	case *urbania*:
	$id_del_tag='12367';
	break;
	case *urbino*:
	$id_del_tag='12368';
	break;
	case *agugliano*:
	$id_del_tag='12369';
	break;
	case *arcevia*:
	$id_del_tag='12370';
	break;
	case *barbara*:
	$id_del_tag='12371';
	break;
	case *belvedere ostrense*:
	$id_del_tag='12372';
	break;
	case *camerano*:
	$id_del_tag='12373';
	break;
	case *camerata picena*:
	$id_del_tag='12374';
	break;
	case *castel colonna*:
	$id_del_tag='12375';
	break;
	case *castelbellino*:
	$id_del_tag='12376';
	break;
	case *castelfidardo*:
	$id_del_tag='12377';
	break;
	case *castelleone di suasa*:
	$id_del_tag='12378';
	break;
	case *castelplanio*:
	$id_del_tag='12379';
	break;
	case *cerreto d'esi*:
	$id_del_tag='12380';
	break;
	case *chiaravalle*:
	$id_del_tag='12381';
	break;
	case *corinaldo*:
	$id_del_tag='12382';
	break;
	case *cupramontana*:
	$id_del_tag='12383';
	break;
	case *fabriano*:
	$id_del_tag='12384';
	break;
	case *filottrano*:
	$id_del_tag='12385';
	break;
	case *genga*:
	$id_del_tag='12386';
	break;
	case *jesi*:
	$id_del_tag='12387';
	break;
	case *maiolati spontini*:
	$id_del_tag='12388';
	break;
	case *mergo*:
	$id_del_tag='12389';
	break;
	case *monsano*:
	$id_del_tag='12390';
	break;
	case *monte roberto*:
	$id_del_tag='12391';
	break;
	case *monte san vito*:
	$id_del_tag='12392';
	break;
	case *montecarotto*:
	$id_del_tag='12393';
	break;
	case *montemarciano*:
	$id_del_tag='12394';
	break;
	case *monterado*:
	$id_del_tag='12395';
	break;
	case *morro d'alba*:
	$id_del_tag='12396';
	break;
	case *numana*:
	$id_del_tag='12397';
	break;
	case *offagna*:
	$id_del_tag='12398';
	break;
	case *osimo*:
	$id_del_tag='12399';
	break;
	case *ostra*:
	$id_del_tag='12400';
	break;
	case *ostra vetere*:
	$id_del_tag='12401';
	break;
	case *poggio san marcello*:
	$id_del_tag='12402';
	break;
	case *polverigi*:
	$id_del_tag='12403';
	break;
	case *ripe*:
	$id_del_tag='12404';
	break;
	case *rosora*:
	$id_del_tag='12405';
	break;
	case *san marcello*:
	$id_del_tag='12406';
	break;
	case *san paolo di jesi*:
	$id_del_tag='12407';
	break;
	case *santa maria nuova*:
	$id_del_tag='12408';
	break;
	case *sassoferrato*:
	$id_del_tag='12409';
	break;
	case *serra de' conti*:
	$id_del_tag='12410';
	break;
	case *serra san quirico*:
	$id_del_tag='12411';
	break;
	case *sirolo*:
	$id_del_tag='12412';
	break;
	case *staffolo*:
	$id_del_tag='12413';
	break;
	case *acquacanina*:
	$id_del_tag='12414';
	break;
	case *apiro*:
	$id_del_tag='12415';
	break;
	case *appignano*:
	$id_del_tag='12416';
	break;
	case *belforte del chienti*:
	$id_del_tag='12417';
	break;
	case *bolognola*:
	$id_del_tag='12418';
	break;
	case *caldarola*:
	$id_del_tag='12419';
	break;
	case *camerino*:
	$id_del_tag='12420';
	break;
	case *camporotondo di fiastrone*:
	$id_del_tag='12421';
	break;
	case *castelraimondo*:
	$id_del_tag='12422';
	break;
	case *castelsantangelo sul nera*:
	$id_del_tag='12423';
	break;
	case *cessapalombo*:
	$id_del_tag='12424';
	break;
	case *cingoli*:
	$id_del_tag='12425';
	break;
	case *colmurano*:
	$id_del_tag='12426';
	break;
	case *corridonia*:
	$id_del_tag='12427';
	break;
	case *esanatoglia*:
	$id_del_tag='12428';
	break;
	case *fiastra*:
	$id_del_tag='12429';
	break;
	case *fiordimonte*:
	$id_del_tag='12430';
	break;
	case *fiuminata*:
	$id_del_tag='12431';
	break;
	case *gagliole*:
	$id_del_tag='12432';
	break;
	case *gualdo*:
	$id_del_tag='12433';
	break;
	case *loro piceno*:
	$id_del_tag='12434';
	break;
	case *matelica*:
	$id_del_tag='12435';
	break;
	case *mogliano*:
	$id_del_tag='12436';
	break;
	case *monte cavallo*:
	$id_del_tag='12437';
	break;
	case *monte san giusto*:
	$id_del_tag='12438';
	break;
	case *monte san martino*:
	$id_del_tag='12439';
	break;
	case *montecassiano*:
	$id_del_tag='12440';
	break;
	case *montecosaro*:
	$id_del_tag='12441';
	break;
	case *montefano*:
	$id_del_tag='12442';
	break;
	case *montelupone*:
	$id_del_tag='12443';
	break;
	case *morrovalle*:
	$id_del_tag='12444';
	break;
	case *muccia*:
	$id_del_tag='12445';
	break;
	case *penna san giovanni*:
	$id_del_tag='12446';
	break;
	case *petriolo*:
	$id_del_tag='12447';
	break;
	case *pieve torina*:
	$id_del_tag='12448';
	break;
	case *pievebovigliana*:
	$id_del_tag='12449';
	break;
	case *pioraco*:
	$id_del_tag='12450';
	break;
	case *poggio san vicino*:
	$id_del_tag='12451';
	break;
	case *pollenza*:
	$id_del_tag='12452';
	break;
	case *porto recanati*:
	$id_del_tag='12453';
	break;
	case *potenza picena*:
	$id_del_tag='12454';
	break;
	case *recanati*:
	$id_del_tag='12455';
	break;
	case *ripe san ginesio*:
	$id_del_tag='12456';
	break;
	case *san ginesio*:
	$id_del_tag='12457';
	break;
	case *san severino marche*:
	$id_del_tag='12458';
	break;
	case *sant'angelo in pontano*:
	$id_del_tag='12459';
	break;
	case *sarnano*:
	$id_del_tag='12460';
	break;
	case *sefro*:
	$id_del_tag='12461';
	break;
	case *serrapetrona*:
	$id_del_tag='12462';
	break;
	case *serravalle di chienti*:
	$id_del_tag='12463';
	break;
	case *tolentino*:
	$id_del_tag='12464';
	break;
	case *treia*:
	$id_del_tag='12465';
	break;
	case *urbisaglia*:
	$id_del_tag='12466';
	break;
	case *ussita*:
	$id_del_tag='12467';
	break;
	case *visso*:
	$id_del_tag='12468';
	break;
	case *acquasanta terme*:
	$id_del_tag='12469';
	break;
	case *acquaviva picena*:
	$id_del_tag='12470';
	break;
	case *altidona*:
	$id_del_tag='12471';
	break;
	case *amandola*:
	$id_del_tag='12472';
	break;
	case *appignano del tronto*:
	$id_del_tag='12473';
	break;
	case *arquata del tronto*:
	$id_del_tag='12474';
	break;
	case *belmonte piceno*:
	$id_del_tag='12475';
	break;
	case *campofilone*:
	$id_del_tag='12476';
	break;
	case *carassai*:
	$id_del_tag='12477';
	break;
	case *castel di lama*:
	$id_del_tag='12478';
	break;
	case *castignano*:
	$id_del_tag='12479';
	break;
	case *castorano*:
	$id_del_tag='12480';
	break;
	case *colli del tronto*:
	$id_del_tag='12481';
	break;
	case *comunanza*:
	$id_del_tag='12482';
	break;
	case *cossignano*:
	$id_del_tag='12483';
	break;
	case *cupra marittima*:
	$id_del_tag='12484';
	break;
	case *falerone*:
	$id_del_tag='12485';
	break;
	case *folignano*:
	$id_del_tag='12486';
	break;
	case *force*:
	$id_del_tag='12487';
	break;
	case *francavilla d'ete*:
	$id_del_tag='12488';
	break;
	case *grottammare*:
	$id_del_tag='12489';
	break;
	case *grottazzolina*:
	$id_del_tag='12490';
	break;
	case *lapedona*:
	$id_del_tag='12491';
	break;
	case *magliano di tenna*:
	$id_del_tag='12492';
	break;
	case *maltignano*:
	$id_del_tag='12493';
	break;
	case *massa fermana*:
	$id_del_tag='12494';
	break;
	case *massignano*:
	$id_del_tag='12495';
	break;
	case *monsampietro morico*:
	$id_del_tag='12496';
	break;
	case *monsampolo del tronto*:
	$id_del_tag='12497';
	break;
	case *montalto delle marche*:
	$id_del_tag='12498';
	break;
	case *montappone*:
	$id_del_tag='12499';
	break;
	case *monte giberto*:
	$id_del_tag='12500';
	break;
	case *monte rinaldo*:
	$id_del_tag='12501';
	break;
	case *monte san pietrangeli*:
	$id_del_tag='12502';
	break;
	case *monte urano*:
	$id_del_tag='12503';
	break;
	case *monte vidon combatte*:
	$id_del_tag='12504';
	break;
	case *monte vidon corrado*:
	$id_del_tag='12505';
	break;
	case *montedinove*:
	$id_del_tag='12506';
	break;
	case *montefalcone appennino*:
	$id_del_tag='12507';
	break;
	case *montefiore dell'aso*:
	$id_del_tag='12508';
	break;
	case *montefortino*:
	$id_del_tag='12509';
	break;
	case *montegallo*:
	$id_del_tag='12510';
	break;
	case *montegiorgio*:
	$id_del_tag='12511';
	break;
	case *montegranaro*:
	$id_del_tag='12512';
	break;
	case *monteleone di fermo*:
	$id_del_tag='12513';
	break;
	case *montelparo*:
	$id_del_tag='12514';
	break;
	case *montemonaco*:
	$id_del_tag='12515';
	break;
	case *monteprandone*:
	$id_del_tag='12516';
	break;
	case *monterubbiano*:
	$id_del_tag='12517';
	break;
	case *montottone*:
	$id_del_tag='12518';
	break;
	case *moresco*:
	$id_del_tag='12519';
	break;
	case *offida*:
	$id_del_tag='12520';
	break;
	case *ortezzano*:
	$id_del_tag='12521';
	break;
	case *palmiano*:
	$id_del_tag='12522';
	break;
	case *pedaso*:
	$id_del_tag='12523';
	break;
	case *petritoli*:
	$id_del_tag='12524';
	break;
	case *ponzano di fermo*:
	$id_del_tag='12525';
	break;
	case *porto san giorgio*:
	$id_del_tag='12526';
	break;
	case *porto sant'elpidio*:
	$id_del_tag='12527';
	break;
	case *rapagnano*:
	$id_del_tag='12528';
	break;
	case *ripatransone*:
	$id_del_tag='12529';
	break;
	case *roccafluvione*:
	$id_del_tag='12530';
	break;
	case *rotella*:
	$id_del_tag='12531';
	break;
	case *san benedetto del tronto*:
	$id_del_tag='12532';
	break;
	case *santa vittoria in matenano*:
	$id_del_tag='12533';
	break;
	case *sant'elpidio a mare*:
	$id_del_tag='12534';
	break;
	case *servigliano*:
	$id_del_tag='12535';
	break;
	case *smerillo*:
	$id_del_tag='12536';
	break;
	case *spinetoli*:
	$id_del_tag='12537';
	break;
	case *torre san patrizio*:
	$id_del_tag='12538';
	break;
	case *venarotta*:
	$id_del_tag='12539';
	break;
	case *aulla*:
	$id_del_tag='12540';
	break;
	case *bagnone*:
	$id_del_tag='12541';
	break;
	case *casola in lunigiana*:
	$id_del_tag='12542';
	break;
	case *comano*:
	$id_del_tag='12543';
	break;
	case *filattiera*:
	$id_del_tag='12544';
	break;
	case *fivizzano*:
	$id_del_tag='12545';
	break;
	case *fosdinovo*:
	$id_del_tag='12546';
	break;
	case *licciana nardi*:
	$id_del_tag='12547';
	break;
	case *montignoso*:
	$id_del_tag='12548';
	break;
	case *mulazzo*:
	$id_del_tag='12549';
	break;
	case *podenzana*:
	$id_del_tag='12550';
	break;
	case *tresana*:
	$id_del_tag='12551';
	break;
	case *villafranca in lunigiana*:
	$id_del_tag='12552';
	break;
	case *zeri*:
	$id_del_tag='12553';
	break;
	case *altopascio*:
	$id_del_tag='12554';
	break;
	case *bagni di lucca*:
	$id_del_tag='12555';
	break;
	case *borgo a mozzano*:
	$id_del_tag='12556';
	break;
	case *camaiore*:
	$id_del_tag='12557';
	break;
	case *camporgiano*:
	$id_del_tag='12558';
	break;
	case *capannori*:
	$id_del_tag='12559';
	break;
	case *careggine*:
	$id_del_tag='12560';
	break;
	case *castiglione di garfagnana*:
	$id_del_tag='12561';
	break;
	case *coreglia antelminelli*:
	$id_del_tag='12562';
	break;
	case *fabbriche di vallico*:
	$id_del_tag='12563';
	break;
	case *forte dei marmi*:
	$id_del_tag='12564';
	break;
	case *fosciandora*:
	$id_del_tag='12565';
	break;
	case *gallicano*:
	$id_del_tag='12566';
	break;
	case *giuncugnano*:
	$id_del_tag='12567';
	break;
	case *massarosa*:
	$id_del_tag='12568';
	break;
	case *minucciano*:
	$id_del_tag='12569';
	break;
	case *molazzana*:
	$id_del_tag='12570';
	break;
	case *montecarlo*:
	$id_del_tag='12571';
	break;
	case *pescaglia*:
	$id_del_tag='12572';
	break;
	case *piazza al serchio*:
	$id_del_tag='12573';
	break;
	case *pieve fosciana*:
	$id_del_tag='12574';
	break;
	case *porcari*:
	$id_del_tag='12575';
	break;
	case *san romano in garfagnana*:
	$id_del_tag='12576';
	break;
	case *seravezza*:
	$id_del_tag='12577';
	break;
	case *sillano*:
	$id_del_tag='12578';
	break;
	case *vagli sotto*:
	$id_del_tag='12579';
	break;
	case *vergemoli*:
	$id_del_tag='12580';
	break;
	case *villa basilica*:
	$id_del_tag='12581';
	break;
	case *villa collemandina*:
	$id_del_tag='12582';
	break;
	case *abetone*:
	$id_del_tag='12583';
	break;
	case *agliana*:
	$id_del_tag='12584';
	break;
	case *buggiano*:
	$id_del_tag='12585';
	break;
	case *chiesina uzzanese*:
	$id_del_tag='12586';
	break;
	case *cutigliano*:
	$id_del_tag='12587';
	break;
	case *lamporecchio*:
	$id_del_tag='12588';
	break;
	case *larciano*:
	$id_del_tag='12589';
	break;
	case *marliana*:
	$id_del_tag='12590';
	break;
	case *massa e cozzile*:
	$id_del_tag='12591';
	break;
	case *monsummano terme*:
	$id_del_tag='12592';
	break;
	case *montale*:
	$id_del_tag='12593';
	break;
	case *pescia*:
	$id_del_tag='12594';
	break;
	case *pieve a nievole*:
	$id_del_tag='12595';
	break;
	case *piteglio*:
	$id_del_tag='12596';
	break;
	case *ponte buggianese*:
	$id_del_tag='12597';
	break;
	case *quarrata*:
	$id_del_tag='12598';
	break;
	case *sambuca pistoiese*:
	$id_del_tag='12599';
	break;
	case *san marcello pistoiese*:
	$id_del_tag='12600';
	break;
	case *serravalle pistoiese*:
	$id_del_tag='12601';
	break;
	case *uzzano*:
	$id_del_tag='12602';
	break;
	case *bagno a ripoli*:
	$id_del_tag='12603';
	break;
	case *barberino di mugello*:
	$id_del_tag='12604';
	break;
	case *barberino val d'elsa*:
	$id_del_tag='12605';
	break;
	case *borgo san lorenzo*:
	$id_del_tag='12606';
	break;
	case *calenzano*:
	$id_del_tag='12607';
	break;
	case *campi bisenzio*:
	$id_del_tag='12608';
	break;
	case *capraia e limite*:
	$id_del_tag='12609';
	break;
	case *castelfiorentino*:
	$id_del_tag='12610';
	break;
	case *cerreto guidi*:
	$id_del_tag='12611';
	break;
	case *certaldo*:
	$id_del_tag='12612';
	break;
	case *dicomano*:
	$id_del_tag='12613';
	break;
	case *empoli*:
	$id_del_tag='12614';
	break;
	case *fiesole*:
	$id_del_tag='12615';
	break;
	case *figline valdarno*:
	$id_del_tag='12616';
	break;
	case *firenzuola*:
	$id_del_tag='12617';
	break;
	case *gambassi terme*:
	$id_del_tag='12618';
	break;
	case *greve in chianti*:
	$id_del_tag='12619';
	break;
	case *impruneta*:
	$id_del_tag='12620';
	break;
	case *incisa in val d'arno*:
	$id_del_tag='12621';
	break;
	case *lastra a signa*:
	$id_del_tag='12622';
	break;
	case *londa*:
	$id_del_tag='12623';
	break;
	case *marradi*:
	$id_del_tag='12624';
	break;
	case *montaione*:
	$id_del_tag='12625';
	break;
	case *montelupo fiorentino*:
	$id_del_tag='12626';
	break;
	case *montespertoli*:
	$id_del_tag='12627';
	break;
	case *palazzuolo sul senio*:
	$id_del_tag='12628';
	break;
	case *pelago*:
	$id_del_tag='12629';
	break;
	case *reggello*:
	$id_del_tag='12630';
	break;
	case *rignano sull'arno*:
	$id_del_tag='12631';
	break;
	case *rufina*:
	$id_del_tag='12632';
	break;
	case *san casciano in val di pesa*:
	$id_del_tag='12633';
	break;
	case *san godenzo*:
	$id_del_tag='12634';
	break;
	case *san piero a sieve*:
	$id_del_tag='12635';
	break;
	case *scarperia*:
	$id_del_tag='12636';
	break;
	case *sesto fiorentino*:
	$id_del_tag='12637';
	break;
	case *signa*:
	$id_del_tag='12638';
	break;
	case *tavarnelle val di pesa*:
	$id_del_tag='12639';
	break;
	case *vaglia*:
	$id_del_tag='12640';
	break;
	case *vicchio*:
	$id_del_tag='12641';
	break;
	case *vinci*:
	$id_del_tag='12642';
	break;
	case *bibbona*:
	$id_del_tag='12643';
	break;
	case *campiglia marittima*:
	$id_del_tag='12644';
	break;
	case *campo nell'elba*:
	$id_del_tag='12645';
	break;
	case *capoliveri*:
	$id_del_tag='12646';
	break;
	case *capraia isola*:
	$id_del_tag='12647';
	break;
	case *castagneto carducci*:
	$id_del_tag='12648';
	break;
	case *cecina*:
	$id_del_tag='12649';
	break;
	case *collesalvetti*:
	$id_del_tag='12650';
	break;
	case *marciana marina*:
	$id_del_tag='12651';
	break;
	case *piombino*:
	$id_del_tag='12652';
	break;
	case *porto azzurro*:
	$id_del_tag='12653';
	break;
	case *portoferraio*:
	$id_del_tag='12654';
	break;
	case *rio marina*:
	$id_del_tag='12655';
	break;
	case *rio nell'elba*:
	$id_del_tag='12656';
	break;
	case *rosignano marittimo*:
	$id_del_tag='12657';
	break;
	case *san vincenzo*:
	$id_del_tag='12658';
	break;
	case *sassetta*:
	$id_del_tag='12659';
	break;
	case *suvereto*:
	$id_del_tag='12660';
	break;
	case *bientina*:
	$id_del_tag='12661';
	break;
	case *buti*:
	$id_del_tag='12662';
	break;
	case *calci*:
	$id_del_tag='12663';
	break;
	case *calcinaia*:
	$id_del_tag='12664';
	break;
	case *capannoli*:
	$id_del_tag='12665';
	break;
	case *casale marittimo*:
	$id_del_tag='12666';
	break;
	case *casciana terme*:
	$id_del_tag='12667';
	break;
	case *cascina*:
	$id_del_tag='12668';
	break;
	case *castelfranco di sotto*:
	$id_del_tag='12669';
	break;
	case *castellina marittima*:
	$id_del_tag='12670';
	break;
	case *chianni*:
	$id_del_tag='12671';
	break;
	case *crespina*:
	$id_del_tag='12672';
	break;
	case *fauglia*:
	$id_del_tag='12673';
	break;
	case *guardistallo*:
	$id_del_tag='12674';
	break;
	case *lajatico*:
	$id_del_tag='12675';
	break;
	case *lari*:
	$id_del_tag='12676';
	break;
	case *lorenzana*:
	$id_del_tag='12677';
	break;
	case *montecatini val di cecina*:
	$id_del_tag='12678';
	break;
	case *montescudaio*:
	$id_del_tag='12679';
	break;
	case *monteverdi marittimo*:
	$id_del_tag='12680';
	break;
	case *montopoli in val d'arno*:
	$id_del_tag='12681';
	break;
	case *orciano pisano*:
	$id_del_tag='12682';
	break;
	case *palaia*:
	$id_del_tag='12683';
	break;
	case *peccioli*:
	$id_del_tag='12684';
	break;
	case *pomarance*:
	$id_del_tag='12685';
	break;
	case *ponsacco*:
	$id_del_tag='12686';
	break;
	case *pontedera*:
	$id_del_tag='12687';
	break;
	case *riparbella*:
	$id_del_tag='12688';
	break;
	case *san giuliano terme*:
	$id_del_tag='12689';
	break;
	case *san miniato*:
	$id_del_tag='12690';
	break;
	case *santa croce sull'arno*:
	$id_del_tag='12691';
	break;
	case *santa luce*:
	$id_del_tag='12692';
	break;
	case *santa maria a monte*:
	$id_del_tag='12693';
	break;
	case *terricciola*:
	$id_del_tag='12694';
	break;
	case *vecchiano*:
	$id_del_tag='12695';
	break;
	case *vicopisano*:
	$id_del_tag='12696';
	break;
	case *anghiari*:
	$id_del_tag='12697';
	break;
	case *badia tedalda*:
	$id_del_tag='12698';
	break;
	case *bibbiena*:
	$id_del_tag='12699';
	break;
	case *bucine*:
	$id_del_tag='12700';
	break;
	case *capolona*:
	$id_del_tag='12701';
	break;
	case *caprese michelangelo*:
	$id_del_tag='12702';
	break;
	case *castel focognano*:
	$id_del_tag='12703';
	break;
	case *castel san niccolò*:
	$id_del_tag='12704';
	break;
	case *castelfranco di sopra*:
	$id_del_tag='12705';
	break;
	case *castiglion fibocchi*:
	$id_del_tag='12706';
	break;
	case *castiglion fiorentino*:
	$id_del_tag='12707';
	break;
	case *cavriglia*:
	$id_del_tag='12708';
	break;
	case *chitignano*:
	$id_del_tag='12709';
	break;
	case *chiusi della verna*:
	$id_del_tag='12710';
	break;
	case *civitella in val di chiana*:
	$id_del_tag='12711';
	break;
	case *cortona*:
	$id_del_tag='12712';
	break;
	case *foiano della chiana*:
	$id_del_tag='12713';
	break;
	case *laterina*:
	$id_del_tag='12714';
	break;
	case *loro ciuffenna*:
	$id_del_tag='12715';
	break;
	case *lucignano*:
	$id_del_tag='12716';
	break;
	case *marciano della chiana*:
	$id_del_tag='12717';
	break;
	case *monte san savino*:
	$id_del_tag='12718';
	break;
	case *montemignaio*:
	$id_del_tag='12719';
	break;
	case *monterchi*:
	$id_del_tag='12720';
	break;
	case *ortignano raggiolo*:
	$id_del_tag='12721';
	break;
	case *pergine valdarno*:
	$id_del_tag='12722';
	break;
	case *pian di sco*:
	$id_del_tag='12723';
	break;
	case *pieve santo stefano*:
	$id_del_tag='12724';
	break;
	case *poppi*:
	$id_del_tag='12725';
	break;
	case *pratovecchio*:
	$id_del_tag='12726';
	break;
	case *sestino*:
	$id_del_tag='12727';
	break;
	case *subbiano*:
	$id_del_tag='12728';
	break;
	case *talla*:
	$id_del_tag='12729';
	break;
	case *terranuova bracciolini*:
	$id_del_tag='12730';
	break;
	case *abbadia san salvatore*:
	$id_del_tag='12731';
	break;
	case *asciano*:
	$id_del_tag='12732';
	break;
	case *buonconvento*:
	$id_del_tag='12733';
	break;
	case *casole d'elsa*:
	$id_del_tag='12734';
	break;
	case *castellina in chianti*:
	$id_del_tag='12735';
	break;
	case *castelnuovo berardenga*:
	$id_del_tag='12736';
	break;
	case *castiglione d'orcia*:
	$id_del_tag='12737';
	break;
	case *cetona*:
	$id_del_tag='12738';
	break;
	case *chianciano terme*:
	$id_del_tag='12739';
	break;
	case *chiusdino*:
	$id_del_tag='12740';
	break;
	case *gaiole in chianti*:
	$id_del_tag='12741';
	break;
	case *montalcino*:
	$id_del_tag='12742';
	break;
	case *montepulciano*:
	$id_del_tag='12743';
	break;
	case *monteriggioni*:
	$id_del_tag='12744';
	break;
	case *monteroni d'arbia*:
	$id_del_tag='12745';
	break;
	case *murlo*:
	$id_del_tag='12746';
	break;
	case *piancastagnaio*:
	$id_del_tag='12747';
	break;
	case *pienza*:
	$id_del_tag='12748';
	break;
	case *radda in chianti*:
	$id_del_tag='12749';
	break;
	case *radicofani*:
	$id_del_tag='12750';
	break;
	case *radicondoli*:
	$id_del_tag='12751';
	break;
	case *rapolano terme*:
	$id_del_tag='12752';
	break;
	case *san casciano dei bagni*:
	$id_del_tag='12753';
	break;
	case *san giovanni d'asso*:
	$id_del_tag='12754';
	break;
	case *san quirico d'orcia*:
	$id_del_tag='12755';
	break;
	case *sarteano*:
	$id_del_tag='12756';
	break;
	case *sinalunga*:
	$id_del_tag='12757';
	break;
	case *sovicille*:
	$id_del_tag='12758';
	break;
	case *torrita di siena*:
	$id_del_tag='12759';
	break;
	case *trequanda*:
	$id_del_tag='12760';
	break;
	case *arcidosso*:
	$id_del_tag='12761';
	break;
	case *campagnatico*:
	$id_del_tag='12762';
	break;
	case *capalbio*:
	$id_del_tag='12763';
	break;
	case *castel del piano*:
	$id_del_tag='12764';
	break;
	case *castell'azzara*:
	$id_del_tag='12765';
	break;
	case *castiglione della pescaia*:
	$id_del_tag='12766';
	break;
	case *cinigiano*:
	$id_del_tag='12767';
	break;
	case *civitella paganico*:
	$id_del_tag='12768';
	break;
	case *gavorrano*:
	$id_del_tag='12769';
	break;
	case *isola del giglio*:
	$id_del_tag='12770';
	break;
	case *magliano in toscana*:
	$id_del_tag='12771';
	break;
	case *manciano*:
	$id_del_tag='12772';
	break;
	case *massa marittima*:
	$id_del_tag='12773';
	break;
	case *monte argentario*:
	$id_del_tag='12774';
	break;
	case *monterotondo marittimo*:
	$id_del_tag='12775';
	break;
	case *montieri*:
	$id_del_tag='12776';
	break;
	case *orbetello*:
	$id_del_tag='12777';
	break;
	case *pitigliano*:
	$id_del_tag='12778';
	break;
	case *roccalbegna*:
	$id_del_tag='12779';
	break;
	case *roccastrada*:
	$id_del_tag='12780';
	break;
	case *santa fiora*:
	$id_del_tag='12781';
	break;
	case *scansano*:
	$id_del_tag='12782';
	break;
	case *seggiano*:
	$id_del_tag='12783';
	break;
	case *semproniano*:
	$id_del_tag='12784';
	break;
	case *sorano*:
	$id_del_tag='12785';
	break;
	case *assisi*:
	$id_del_tag='12786';
	break;
	case *bastia umbra*:
	$id_del_tag='12787';
	break;
	case *bettona*:
	$id_del_tag='12788';
	break;
	case *bevagna*:
	$id_del_tag='12789';
	break;
	case *cannara*:
	$id_del_tag='12790';
	break;
	case *cascia*:
	$id_del_tag='12791';
	break;
	case *castel ritaldi*:
	$id_del_tag='12792';
	break;
	case *castiglione del lago*:
	$id_del_tag='12793';
	break;
	case *cerreto di spoleto*:
	$id_del_tag='12794';
	break;
	case *citerna*:
	$id_del_tag='12795';
	break;
	case *città della pieve*:
	$id_del_tag='12796';
	break;
	case *città di castello*:
	$id_del_tag='12797';
	break;
	case *collazzone*:
	$id_del_tag='12798';
	break;
	case *corciano*:
	$id_del_tag='12799';
	break;
	case *costacciaro*:
	$id_del_tag='12800';
	break;
	case *deruta*:
	$id_del_tag='12801';
	break;
	case *fossato di vico*:
	$id_del_tag='12802';
	break;
	case *fratta todina*:
	$id_del_tag='12803';
	break;
	case *giano dell'umbria*:
	$id_del_tag='12804';
	break;
	case *gualdo cattaneo*:
	$id_del_tag='12805';
	break;
	case *gualdo tadino*:
	$id_del_tag='12806';
	break;
	case *gubbio*:
	$id_del_tag='12807';
	break;
	case *lisciano niccone*:
	$id_del_tag='12808';
	break;
	case *magione*:
	$id_del_tag='12809';
	break;
	case *marsciano*:
	$id_del_tag='12810';
	break;
	case *massa martana*:
	$id_del_tag='12811';
	break;
	case *monte castello di vibio*:
	$id_del_tag='12812';
	break;
	case *monte santa maria tiberina*:
	$id_del_tag='12813';
	break;
	case *montefalco*:
	$id_del_tag='12814';
	break;
	case *monteleone di spoleto*:
	$id_del_tag='12815';
	break;
	case *montone*:
	$id_del_tag='12816';
	break;
	case *nocera umbra*:
	$id_del_tag='12817';
	break;
	case *paciano*:
	$id_del_tag='12818';
	break;
	case *panicale*:
	$id_del_tag='12819';
	break;
	case *passignano sul trasimeno*:
	$id_del_tag='12820';
	break;
	case *piegaro*:
	$id_del_tag='12821';
	break;
	case *pietralunga*:
	$id_del_tag='12822';
	break;
	case *poggiodomo*:
	$id_del_tag='12823';
	break;
	case *preci*:
	$id_del_tag='12824';
	break;
	case *san giustino*:
	$id_del_tag='12825';
	break;
	case *sant'anatolia di narco*:
	$id_del_tag='12826';
	break;
	case *scheggia e pascelupo*:
	$id_del_tag='12827';
	break;
	case *scheggino*:
	$id_del_tag='12828';
	break;
	case *sellano*:
	$id_del_tag='12829';
	break;
	case *sigillo*:
	$id_del_tag='12830';
	break;
	case *spello*:
	$id_del_tag='12831';
	break;
	case *torgiano*:
	$id_del_tag='12832';
	break;
	case *trevi*:
	$id_del_tag='12833';
	break;
	case *tuoro sul trasimeno*:
	$id_del_tag='12834';
	break;
	case *umbertide*:
	$id_del_tag='12835';
	break;
	case *valfabbrica*:
	$id_del_tag='12836';
	break;
	case *vallo di nera*:
	$id_del_tag='12837';
	break;
	case *valtopina*:
	$id_del_tag='12838';
	break;
	case *acquasparta*:
	$id_del_tag='12839';
	break;
	case *allerona*:
	$id_del_tag='12840';
	break;
	case *alviano*:
	$id_del_tag='12841';
	break;
	case *arrone*:
	$id_del_tag='12842';
	break;
	case *attigliano*:
	$id_del_tag='12843';
	break;
	case *avigliano umbro*:
	$id_del_tag='12844';
	break;
	case *baschi*:
	$id_del_tag='12845';
	break;
	case *calvi dell'umbria*:
	$id_del_tag='12846';
	break;
	case *castel giorgio*:
	$id_del_tag='12847';
	break;
	case *castel viscardo*:
	$id_del_tag='12848';
	break;
	case *fabro*:
	$id_del_tag='12849';
	break;
	case *ferentillo*:
	$id_del_tag='12850';
	break;
	case *ficulle*:
	$id_del_tag='12851';
	break;
	case *giove*:
	$id_del_tag='12852';
	break;
	case *guardea*:
	$id_del_tag='12853';
	break;
	case *lugnano in teverina*:
	$id_del_tag='12854';
	break;
	case *montecastrilli*:
	$id_del_tag='12855';
	break;
	case *montecchio*:
	$id_del_tag='12856';
	break;
	case *montefranco*:
	$id_del_tag='12857';
	break;
	case *montegabbione*:
	$id_del_tag='12858';
	break;
	case *monteleone d'orvieto*:
	$id_del_tag='12859';
	break;
	case *narni*:
	$id_del_tag='12860';
	break;
	case *orvieto*:
	$id_del_tag='12861';
	break;
	case *otricoli*:
	$id_del_tag='12862';
	break;
	case *parrano*:
	$id_del_tag='12863';
	break;
	case *penna in teverina*:
	$id_del_tag='12864';
	break;
	case *polino*:
	$id_del_tag='12865';
	break;
	case *porano*:
	$id_del_tag='12866';
	break;
	case *san gemini*:
	$id_del_tag='12867';
	break;
	case *san venanzo*:
	$id_del_tag='12868';
	break;
	case *stroncone*:
	$id_del_tag='12869';
	break;
	case *acquapendente*:
	$id_del_tag='12870';
	break;
	case *arlena di castro*:
	$id_del_tag='12871';
	break;
	case *barbarano romano*:
	$id_del_tag='12872';
	break;
	case *bassano in teverina*:
	$id_del_tag='12873';
	break;
	case *bassano romano*:
	$id_del_tag='12874';
	break;
	case *blera*:
	$id_del_tag='12875';
	break;
	case *bolsena*:
	$id_del_tag='12876';
	break;
	case *bomarzo*:
	$id_del_tag='12877';
	break;
	case *calcata*:
	$id_del_tag='12878';
	break;
	case *canepina*:
	$id_del_tag='12879';
	break;
	case *canino*:
	$id_del_tag='12880';
	break;
	case *capodimonte*:
	$id_del_tag='12881';
	break;
	case *capranica*:
	$id_del_tag='12882';
	break;
	case *caprarola*:
	$id_del_tag='12883';
	break;
	case *carbognano*:
	$id_del_tag='12884';
	break;
	case *castel sant'elia*:
	$id_del_tag='12885';
	break;
	case *castiglione in teverina*:
	$id_del_tag='12886';
	break;
	case *celleno*:
	$id_del_tag='12887';
	break;
	case *cellere*:
	$id_del_tag='12888';
	break;
	case *civita castellana*:
	$id_del_tag='12889';
	break;
	case *civitella d'agliano*:
	$id_del_tag='12890';
	break;
	case *corchiano*:
	$id_del_tag='12891';
	break;
	case *fabrica di roma*:
	$id_del_tag='12892';
	break;
	case *faleria*:
	$id_del_tag='12893';
	break;
	case *farnese*:
	$id_del_tag='12894';
	break;
	case *gallese*:
	$id_del_tag='12895';
	break;
	case *gradoli*:
	$id_del_tag='12896';
	break;
	case *graffignano*:
	$id_del_tag='12897';
	break;
	case *grotte di castro*:
	$id_del_tag='12898';
	break;
	case *ischia di castro*:
	$id_del_tag='12899';
	break;
	case *latera*:
	$id_del_tag='12900';
	break;
	case *lubriano*:
	$id_del_tag='12901';
	break;
	case *marta*:
	$id_del_tag='12902';
	break;
	case *montalto di castro*:
	$id_del_tag='12903';
	break;
	case *monte romano*:
	$id_del_tag='12904';
	break;
	case *montefiascone*:
	$id_del_tag='12905';
	break;
	case *monterosi*:
	$id_del_tag='12906';
	break;
	case *nepi*:
	$id_del_tag='12907';
	break;
	case *onano*:
	$id_del_tag='12908';
	break;
	case *oriolo romano*:
	$id_del_tag='12909';
	break;
	case *piansano*:
	$id_del_tag='12910';
	break;
	case *proceno*:
	$id_del_tag='12911';
	break;
	case *ronciglione*:
	$id_del_tag='12912';
	break;
	case *san lorenzo nuovo*:
	$id_del_tag='12913';
	break;
	case *soriano nel cimino*:
	$id_del_tag='12914';
	break;
	case *sutri*:
	$id_del_tag='12915';
	break;
	case *tarquinia*:
	$id_del_tag='12916';
	break;
	case *tessennano*:
	$id_del_tag='12917';
	break;
	case *tuscania*:
	$id_del_tag='12918';
	break;
	case *valentano*:
	$id_del_tag='12919';
	break;
	case *vallerano*:
	$id_del_tag='12920';
	break;
	case *vasanello*:
	$id_del_tag='12921';
	break;
	case *vejano*:
	$id_del_tag='12922';
	break;
	case *vetralla*:
	$id_del_tag='12923';
	break;
	case *vignanello*:
	$id_del_tag='12924';
	break;
	case *villa san giovanni in tuscia*:
	$id_del_tag='12925';
	break;
	case *vitorchiano*:
	$id_del_tag='12926';
	break;
	case *accumoli*:
	$id_del_tag='12927';
	break;
	case *amatrice*:
	$id_del_tag='12928';
	break;
	case *antrodoco*:
	$id_del_tag='12929';
	break;
	case *ascrea*:
	$id_del_tag='12930';
	break;
	case *belmonte in sabina*:
	$id_del_tag='12931';
	break;
	case *borbona*:
	$id_del_tag='12932';
	break;
	case *borgo velino*:
	$id_del_tag='12933';
	break;
	case *borgorose*:
	$id_del_tag='12934';
	break;
	case *cantalice*:
	$id_del_tag='12935';
	break;
	case *cantalupo in sabina*:
	$id_del_tag='12936';
	break;
	case *casaprota*:
	$id_del_tag='12937';
	break;
	case *casperia*:
	$id_del_tag='12938';
	break;
	case *castel di tora*:
	$id_del_tag='12939';
	break;
	case *castel sant'angelo*:
	$id_del_tag='12940';
	break;
	case *castelnuovo di farfa*:
	$id_del_tag='12941';
	break;
	case *cittaducale*:
	$id_del_tag='12942';
	break;
	case *cittareale*:
	$id_del_tag='12943';
	break;
	case *collalto sabino*:
	$id_del_tag='12944';
	break;
	case *colle di tora*:
	$id_del_tag='12945';
	break;
	case *collegiove*:
	$id_del_tag='12946';
	break;
	case *collevecchio*:
	$id_del_tag='12947';
	break;
	case *colli sul velino*:
	$id_del_tag='12948';
	break;
	case *concerviano*:
	$id_del_tag='12949';
	break;
	case *configni*:
	$id_del_tag='12950';
	break;
	case *contigliano*:
	$id_del_tag='12951';
	break;
	case *cottanello*:
	$id_del_tag='12952';
	break;
	case *fara in sabina*:
	$id_del_tag='12953';
	break;
	case *fiamignano*:
	$id_del_tag='12954';
	break;
	case *forano*:
	$id_del_tag='12955';
	break;
	case *frasso sabino*:
	$id_del_tag='12956';
	break;
	case *labro*:
	$id_del_tag='12957';
	break;
	case *leonessa*:
	$id_del_tag='12958';
	break;
	case *longone sabino*:
	$id_del_tag='12959';
	break;
	case *magliano sabina*:
	$id_del_tag='12960';
	break;
	case *marcetelli*:
	$id_del_tag='12961';
	break;
	case *micigliano*:
	$id_del_tag='12962';
	break;
	case *mompeo*:
	$id_del_tag='12963';
	break;
	case *montasola*:
	$id_del_tag='12964';
	break;
	case *monte san giovanni in sabina*:
	$id_del_tag='12965';
	break;
	case *montebuono*:
	$id_del_tag='12966';
	break;
	case *monteleone sabino*:
	$id_del_tag='12967';
	break;
	case *montenero sabino*:
	$id_del_tag='12968';
	break;
	case *montopoli di sabina*:
	$id_del_tag='12969';
	break;
	case *morro reatino*:
	$id_del_tag='12970';
	break;
	case *nespolo*:
	$id_del_tag='12971';
	break;
	case *orvinio*:
	$id_del_tag='12972';
	break;
	case *paganico sabino*:
	$id_del_tag='12973';
	break;
	case *pescorocchiano*:
	$id_del_tag='12974';
	break;
	case *petrella salto*:
	$id_del_tag='12975';
	break;
	case *poggio bustone*:
	$id_del_tag='12976';
	break;
	case *poggio catino*:
	$id_del_tag='12977';
	break;
	case *poggio mirteto*:
	$id_del_tag='12978';
	break;
	case *poggio moiano*:
	$id_del_tag='12979';
	break;
	case *poggio nativo*:
	$id_del_tag='12980';
	break;
	case *poggio san lorenzo*:
	$id_del_tag='12981';
	break;
	case *posta*:
	$id_del_tag='12982';
	break;
	case *pozzaglia sabina*:
	$id_del_tag='12983';
	break;
	case *rivodutri*:
	$id_del_tag='12984';
	break;
	case *rocca sinibalda*:
	$id_del_tag='12985';
	break;
	case *roccantica*:
	$id_del_tag='12986';
	break;
	case *salisano*:
	$id_del_tag='12987';
	break;
	case *scandriglia*:
	$id_del_tag='12988';
	break;
	case *selci*:
	$id_del_tag='12989';
	break;
	case *stimigliano*:
	$id_del_tag='12990';
	break;
	case *tarano*:
	$id_del_tag='12991';
	break;
	case *toffia*:
	$id_del_tag='12992';
	break;
	case *torri in sabina*:
	$id_del_tag='12993';
	break;
	case *torricella in sabina*:
	$id_del_tag='12994';
	break;
	case *turania*:
	$id_del_tag='12995';
	break;
	case *vacone*:
	$id_del_tag='12996';
	break;
	case *varco sabino*:
	$id_del_tag='12997';
	break;
	case *affile*:
	$id_del_tag='12998';
	break;
	case *agosta*:
	$id_del_tag='12999';
	break;
	case *albano laziale*:
	$id_del_tag='13000';
	break;
	case *allumiere*:
	$id_del_tag='13001';
	break;
	case *anguillara sabazia*:
	$id_del_tag='13002';
	break;
	case *anticoli corrado*:
	$id_del_tag='13003';
	break;
	case *ardea*:
	$id_del_tag='13004';
	break;
	case *arsoli*:
	$id_del_tag='13005';
	break;
	case *artena*:
	$id_del_tag='13006';
	break;
	case *bellegra*:
	$id_del_tag='13007';
	break;
	case *camerata nuova*:
	$id_del_tag='13008';
	break;
	case *campagnano di roma*:
	$id_del_tag='13009';
	break;
	case *canale monterano*:
	$id_del_tag='13010';
	break;
	case *canterano*:
	$id_del_tag='13011';
	break;
	case *capena*:
	$id_del_tag='13012';
	break;
	case *capranica prenestina*:
	$id_del_tag='13013';
	break;
	case *carpineto romano*:
	$id_del_tag='13014';
	break;
	case *casape*:
	$id_del_tag='13015';
	break;
	case *castel gandolfo*:
	$id_del_tag='13016';
	break;
	case *castel madama*:
	$id_del_tag='13017';
	break;
	case *castel san pietro romano*:
	$id_del_tag='13018';
	break;
	case *castelnuovo di porto*:
	$id_del_tag='13019';
	break;
	case *cave*:
	$id_del_tag='13020';
	break;
	case *cerreto laziale*:
	$id_del_tag='13021';
	break;
	case *cervara di roma*:
	$id_del_tag='13022';
	break;
	case *cerveteri*:
	$id_del_tag='13023';
	break;
	case *ciciliano*:
	$id_del_tag='13024';
	break;
	case *cineto romano*:
	$id_del_tag='13025';
	break;
	case *civitella san paolo*:
	$id_del_tag='13026';
	break;
	case *colonna*:
	$id_del_tag='13027';
	break;
	case *fiano romano*:
	$id_del_tag='13028';
	break;
	case *filacciano*:
	$id_del_tag='13029';
	break;
	case *fonte nuova*:
	$id_del_tag='13030';
	break;
	case *formello*:
	$id_del_tag='13031';
	break;
	case *gallicano nel lazio*:
	$id_del_tag='13032';
	break;
	case *genazzano*:
	$id_del_tag='13033';
	break;
	case *genzano di roma*:
	$id_del_tag='13034';
	break;
	case *gerano*:
	$id_del_tag='13035';
	break;
	case *gorga*:
	$id_del_tag='13036';
	break;
	case *grottaferrata*:
	$id_del_tag='13037';
	break;
	case *jenne*:
	$id_del_tag='13038';
	break;
	case *ladispoli*:
	$id_del_tag='13039';
	break;
	case *lanuvio*:
	$id_del_tag='13040';
	break;
	case *lariano*:
	$id_del_tag='13041';
	break;
	case *licenza*:
	$id_del_tag='13042';
	break;
	case *magliano romano*:
	$id_del_tag='13043';
	break;
	case *mandela*:
	$id_del_tag='13044';
	break;
	case *manziana*:
	$id_del_tag='13045';
	break;
	case *marano equo*:
	$id_del_tag='13046';
	break;
	case *marcellina*:
	$id_del_tag='13047';
	break;
	case *marino*:
	$id_del_tag='13048';
	break;
	case *mazzano romano*:
	$id_del_tag='13049';
	break;
	case *mentana*:
	$id_del_tag='13050';
	break;
	case *monte compatri*:
	$id_del_tag='13051';
	break;
	case *monte porzio catone*:
	$id_del_tag='13052';
	break;
	case *monteflavio*:
	$id_del_tag='13053';
	break;
	case *montelanico*:
	$id_del_tag='13054';
	break;
	case *montelibretti*:
	$id_del_tag='13055';
	break;
	case *monterotondo*:
	$id_del_tag='13056';
	break;
	case *montorio romano*:
	$id_del_tag='13057';
	break;
	case *moricone*:
	$id_del_tag='13058';
	break;
	case *morlupo*:
	$id_del_tag='13059';
	break;
	case *nazzano*:
	$id_del_tag='13060';
	break;
	case *nemi*:
	$id_del_tag='13061';
	break;
	case *nerola*:
	$id_del_tag='13062';
	break;
	case *nettuno*:
	$id_del_tag='13063';
	break;
	case *olevano romano*:
	$id_del_tag='13064';
	break;
	case *palestrina*:
	$id_del_tag='13065';
	break;
	case *palombara sabina*:
	$id_del_tag='13066';
	break;
	case *percile*:
	$id_del_tag='13067';
	break;
	case *pisoniano*:
	$id_del_tag='13068';
	break;
	case *poli*:
	$id_del_tag='13069';
	break;
	case *ponzano romano*:
	$id_del_tag='13070';
	break;
	case *riano*:
	$id_del_tag='13071';
	break;
	case *rignano flaminio*:
	$id_del_tag='13072';
	break;
	case *riofreddo*:
	$id_del_tag='13073';
	break;
	case *rocca canterano*:
	$id_del_tag='13074';
	break;
	case *rocca di cave*:
	$id_del_tag='13075';
	break;
	case *rocca di papa*:
	$id_del_tag='13076';
	break;
	case *rocca priora*:
	$id_del_tag='13077';
	break;
	case *rocca santo stefano*:
	$id_del_tag='13078';
	break;
	case *roccagiovine*:
	$id_del_tag='13079';
	break;
	case *roiate*:
	$id_del_tag='13080';
	break;
	case *roviano*:
	$id_del_tag='13081';
	break;
	case *sacrofano*:
	$id_del_tag='13082';
	break;
	case *sambuci*:
	$id_del_tag='13083';
	break;
	case *san cesareo*:
	$id_del_tag='13084';
	break;
	case *san gregorio da sassola*:
	$id_del_tag='13085';
	break;
	case *san polo dei cavalieri*:
	$id_del_tag='13086';
	break;
	case *san vito romano*:
	$id_del_tag='13087';
	break;
	case *santa marinella*:
	$id_del_tag='13088';
	break;
	case *sant'angelo romano*:
	$id_del_tag='13089';
	break;
	case *sant'oreste*:
	$id_del_tag='13090';
	break;
	case *saracinesco*:
	$id_del_tag='13091';
	break;
	case *tolfa*:
	$id_del_tag='13092';
	break;
	case *torrita tiberina*:
	$id_del_tag='13093';
	break;
	case *trevignano romano*:
	$id_del_tag='13094';
	break;
	case *vallepietra*:
	$id_del_tag='13095';
	break;
	case *vallinfreda*:
	$id_del_tag='13096';
	break;
	case *valmontone*:
	$id_del_tag='13097';
	break;
	case *vicovaro*:
	$id_del_tag='13098';
	break;
	case *vivaro romano*:
	$id_del_tag='13099';
	break;
	case *zagarolo*:
	$id_del_tag='13100';
	break;
	case *bassiano*:
	$id_del_tag='13101';
	break;
	case *campodimele*:
	$id_del_tag='13102';
	break;
	case *castelforte*:
	$id_del_tag='13103';
	break;
	case *cori*:
	$id_del_tag='13104';
	break;
	case *fondi*:
	$id_del_tag='13105';
	break;
	case *itri*:
	$id_del_tag='13106';
	break;
	case *lenola*:
	$id_del_tag='13107';
	break;
	case *maenza*:
	$id_del_tag='13108';
	break;
	case *minturno*:
	$id_del_tag='13109';
	break;
	case *monte san biagio*:
	$id_del_tag='13110';
	break;
	case *norma*:
	$id_del_tag='13111';
	break;
	case *pontinia*:
	$id_del_tag='13112';
	break;
	case *ponza*:
	$id_del_tag='13113';
	break;
	case *priverno*:
	$id_del_tag='13114';
	break;
	case *prossedi*:
	$id_del_tag='13115';
	break;
	case *rocca massima*:
	$id_del_tag='13116';
	break;
	case *roccagorga*:
	$id_del_tag='13117';
	break;
	case *roccasecca dei volsci*:
	$id_del_tag='13118';
	break;
	case *san felice circeo*:
	$id_del_tag='13119';
	break;
	case *santi cosma e damiano*:
	$id_del_tag='13120';
	break;
	case *sermoneta*:
	$id_del_tag='13121';
	break;
	case *sezze*:
	$id_del_tag='13122';
	break;
	case *sonnino*:
	$id_del_tag='13123';
	break;
	case *sperlonga*:
	$id_del_tag='13124';
	break;
	case *spigno saturnia*:
	$id_del_tag='13125';
	break;
	case *terracina*:
	$id_del_tag='13126';
	break;
	case *acquafondata*:
	$id_del_tag='13127';
	break;
	case *acuto*:
	$id_del_tag='13128';
	break;
	case *alatri*:
	$id_del_tag='13129';
	break;
	case *alvito*:
	$id_del_tag='13130';
	break;
	case *amaseno*:
	$id_del_tag='13131';
	break;
	case *aquino*:
	$id_del_tag='13132';
	break;
	case *arce*:
	$id_del_tag='13133';
	break;
	case *arnara*:
	$id_del_tag='13134';
	break;
	case *arpino*:
	$id_del_tag='13135';
	break;
	case *atina*:
	$id_del_tag='13136';
	break;
	case *ausonia*:
	$id_del_tag='13137';
	break;
	case *belmonte castello*:
	$id_del_tag='13138';
	break;
	case *boville ernica*:
	$id_del_tag='13139';
	break;
	case *broccostella*:
	$id_del_tag='13140';
	break;
	case *campoli appennino*:
	$id_del_tag='13141';
	break;
	case *casalattico*:
	$id_del_tag='13142';
	break;
	case *casalvieri*:
	$id_del_tag='13143';
	break;
	case *castelliri*:
	$id_del_tag='13144';
	break;
	case *castelnuovo parano*:
	$id_del_tag='13145';
	break;
	case *castro dei volsci*:
	$id_del_tag='13146';
	break;
	case *castrocielo*:
	$id_del_tag='13147';
	break;
	case *ceccano*:
	$id_del_tag='13148';
	break;
	case *ceprano*:
	$id_del_tag='13149';
	break;
	case *cervaro*:
	$id_del_tag='13150';
	break;
	case *colfelice*:
	$id_del_tag='13151';
	break;
	case *colle san magno*:
	$id_del_tag='13152';
	break;
	case *collepardo*:
	$id_del_tag='13153';
	break;
	case *coreno ausonio*:
	$id_del_tag='13154';
	break;
	case *esperia*:
	$id_del_tag='13155';
	break;
	case *falvaterra*:
	$id_del_tag='13156';
	break;
	case *filettino*:
	$id_del_tag='13157';
	break;
	case *fumone*:
	$id_del_tag='13158';
	break;
	case *gallinaro*:
	$id_del_tag='13159';
	break;
	case *giuliano di roma*:
	$id_del_tag='13160';
	break;
	case *guarcino*:
	$id_del_tag='13161';
	break;
	case *isola del liri*:
	$id_del_tag='13162';
	break;
	case *monte san giovanni campano*:
	$id_del_tag='13163';
	break;
	case *pastena*:
	$id_del_tag='13164';
	break;
	case *patrica*:
	$id_del_tag='13165';
	break;
	case *pescosolido*:
	$id_del_tag='13166';
	break;
	case *picinisco*:
	$id_del_tag='13167';
	break;
	case *pico*:
	$id_del_tag='13168';
	break;
	case *piedimonte san germano*:
	$id_del_tag='13169';
	break;
	case *piglio*:
	$id_del_tag='13170';
	break;
	case *pignataro interamna*:
	$id_del_tag='13171';
	break;
	case *pofi*:
	$id_del_tag='13172';
	break;
	case *pontecorvo*:
	$id_del_tag='13173';
	break;
	case *posta fibreno*:
	$id_del_tag='13174';
	break;
	case *ripi*:
	$id_del_tag='13175';
	break;
	case *rocca d'arce*:
	$id_del_tag='13176';
	break;
	case *roccasecca*:
	$id_del_tag='13177';
	break;
	case *san biagio saracinisco*:
	$id_del_tag='13178';
	break;
	case *san donato val di comino*:
	$id_del_tag='13179';
	break;
	case *san giorgio a liri*:
	$id_del_tag='13180';
	break;
	case *san giovanni incarico*:
	$id_del_tag='13181';
	break;
	case *san vittore del lazio*:
	$id_del_tag='13182';
	break;
	case *sant'ambrogio sul garigliano*:
	$id_del_tag='13183';
	break;
	case *sant'andrea del garigliano*:
	$id_del_tag='13184';
	break;
	case *sant'apollinare*:
	$id_del_tag='13185';
	break;
	case *sant'elia fiumerapido*:
	$id_del_tag='13186';
	break;
	case *santopadre*:
	$id_del_tag='13187';
	break;
	case *serrone*:
	$id_del_tag='13188';
	break;
	case *settefrati*:
	$id_del_tag='13189';
	break;
	case *strangolagalli*:
	$id_del_tag='13190';
	break;
	case *terelle*:
	$id_del_tag='13191';
	break;
	case *torre cajetani*:
	$id_del_tag='13192';
	break;
	case *torrice*:
	$id_del_tag='13193';
	break;
	case *trevi nel lazio*:
	$id_del_tag='13194';
	break;
	case *trivigliano*:
	$id_del_tag='13195';
	break;
	case *vallecorsa*:
	$id_del_tag='13196';
	break;
	case *vallemaio*:
	$id_del_tag='13197';
	break;
	case *veroli*:
	$id_del_tag='13198';
	break;
	case *vicalvi*:
	$id_del_tag='13199';
	break;
	case *vico nel lazio*:
	$id_del_tag='13200';
	break;
	case *villa latina*:
	$id_del_tag='13201';
	break;
	case *villa santa lucia*:
	$id_del_tag='13202';
	break;
	case *villa santo stefano*:
	$id_del_tag='13203';
	break;
	case *viticuso*:
	$id_del_tag='13204';
	break;
	case *ailano*:
	$id_del_tag='13205';
	break;
	case *alife*:
	$id_del_tag='13206';
	break;
	case *alvignano*:
	$id_del_tag='13207';
	break;
	case *arienzo*:
	$id_del_tag='13208';
	break;
	case *baia e latina*:
	$id_del_tag='13209';
	break;
	case *bellona*:
	$id_del_tag='13210';
	break;
	case *caianello*:
	$id_del_tag='13211';
	break;
	case *caiazzo*:
	$id_del_tag='13212';
	break;
	case *calvi risorta*:
	$id_del_tag='13213';
	break;
	case *camigliano*:
	$id_del_tag='13214';
	break;
	case *cancello ed arnone*:
	$id_del_tag='13215';
	break;
	case *capodrise*:
	$id_del_tag='13216';
	break;
	case *capriati a volturno*:
	$id_del_tag='13217';
	break;
	case *capua*:
	$id_del_tag='13218';
	break;
	case *carinaro*:
	$id_del_tag='13219';
	break;
	case *carinola*:
	$id_del_tag='13220';
	break;
	case *casagiove*:
	$id_del_tag='13221';
	break;
	case *casaluce*:
	$id_del_tag='13222';
	break;
	case *casapesenna*:
	$id_del_tag='13223';
	break;
	case *casapulla*:
	$id_del_tag='13224';
	break;
	case *castel campagnano*:
	$id_del_tag='13225';
	break;
	case *castel di sasso*:
	$id_del_tag='13226';
	break;
	case *castel morrone*:
	$id_del_tag='13227';
	break;
	case *castello del matese*:
	$id_del_tag='13228';
	break;
	case *cellole*:
	$id_del_tag='13229';
	break;
	case *cervino*:
	$id_del_tag='13230';
	break;
	case *cesa*:
	$id_del_tag='13231';
	break;
	case *ciorlano*:
	$id_del_tag='13232';
	break;
	case *conca della campania*:
	$id_del_tag='13233';
	break;
	case *curti*:
	$id_del_tag='13234';
	break;
	case *dragoni*:
	$id_del_tag='13235';
	break;
	case *falciano del massico*:
	$id_del_tag='13236';
	break;
	case *fontegreca*:
	$id_del_tag='13237';
	break;
	case *formicola*:
	$id_del_tag='13238';
	break;
	case *francolise*:
	$id_del_tag='13239';
	break;
	case *frignano*:
	$id_del_tag='13240';
	break;
	case *gallo matese*:
	$id_del_tag='13241';
	break;
	case *galluccio*:
	$id_del_tag='13242';
	break;
	case *giano vetusto*:
	$id_del_tag='13243';
	break;
	case *gioia sannitica*:
	$id_del_tag='13244';
	break;
	case *grazzanise*:
	$id_del_tag='13245';
	break;
	case *gricignano di aversa*:
	$id_del_tag='13246';
	break;
	case *letino*:
	$id_del_tag='13247';
	break;
	case *liberi*:
	$id_del_tag='13248';
	break;
	case *lusciano*:
	$id_del_tag='13249';
	break;
	case *macerata campania*:
	$id_del_tag='13250';
	break;
	case *marcianise*:
	$id_del_tag='13251';
	break;
	case *marzano appio*:
	$id_del_tag='13252';
	break;
	case *mignano monte lungo*:
	$id_del_tag='13253';
	break;
	case *mondragone*:
	$id_del_tag='13254';
	break;
	case *orta di atella*:
	$id_del_tag='13255';
	break;
	case *parete*:
	$id_del_tag='13256';
	break;
	case *pastorano*:
	$id_del_tag='13257';
	break;
	case *piana di monte verna*:
	$id_del_tag='13258';
	break;
	case *piedimonte matese*:
	$id_del_tag='13259';
	break;
	case *pietramelara*:
	$id_del_tag='13260';
	break;
	case *pietravairano*:
	$id_del_tag='13261';
	break;
	case *pignataro maggiore*:
	$id_del_tag='13262';
	break;
	case *pontelatone*:
	$id_del_tag='13263';
	break;
	case *portico di caserta*:
	$id_del_tag='13264';
	break;
	case *prata sannita*:
	$id_del_tag='13265';
	break;
	case *pratella*:
	$id_del_tag='13266';
	break;
	case *presenzano*:
	$id_del_tag='13267';
	break;
	case *raviscanina*:
	$id_del_tag='13268';
	break;
	case *recale*:
	$id_del_tag='13269';
	break;
	case *riardo*:
	$id_del_tag='13270';
	break;
	case *rocca d'evandro*:
	$id_del_tag='13271';
	break;
	case *roccamonfina*:
	$id_del_tag='13272';
	break;
	case *roccaromana*:
	$id_del_tag='13273';
	break;
	case *rocchetta e croce*:
	$id_del_tag='13274';
	break;
	case *ruviano*:
	$id_del_tag='13275';
	break;
	case *san cipriano d'aversa*:
	$id_del_tag='13276';
	break;
	case *san felice a cancello*:
	$id_del_tag='13277';
	break;
	case *san gregorio matese*:
	$id_del_tag='13278';
	break;
	case *san marcellino*:
	$id_del_tag='13279';
	break;
	case *san marco evangelista*:
	$id_del_tag='13280';
	break;
	case *san nicola la strada*:
	$id_del_tag='13281';
	break;
	case *san pietro infine*:
	$id_del_tag='13282';
	break;
	case *san potito sannitico*:
	$id_del_tag='13283';
	break;
	case *san prisco*:
	$id_del_tag='13284';
	break;
	case *san tammaro*:
	$id_del_tag='13285';
	break;
	case *santa maria a vico*:
	$id_del_tag='13286';
	break;
	case *santa maria la fossa*:
	$id_del_tag='13287';
	break;
	case *sant'angelo d'alife*:
	$id_del_tag='13288';
	break;
	case *sant'arpino*:
	$id_del_tag='13289';
	break;
	case *sessa aurunca*:
	$id_del_tag='13290';
	break;
	case *sparanise*:
	$id_del_tag='13291';
	break;
	case *succivo*:
	$id_del_tag='13292';
	break;
	case *teano*:
	$id_del_tag='13293';
	break;
	case *teverola*:
	$id_del_tag='13294';
	break;
	case *tora e piccilli*:
	$id_del_tag='13295';
	break;
	case *trentola-ducenta*:
	$id_del_tag='13296';
	break;
	case *vairano patenora*:
	$id_del_tag='13297';
	break;
	case *valle agricola*:
	$id_del_tag='13298';
	break;
	case *valle di maddaloni*:
	$id_del_tag='13299';
	break;
	case *villa di briano*:
	$id_del_tag='13300';
	break;
	case *villa literno*:
	$id_del_tag='13301';
	break;
	case *vitulazio*:
	$id_del_tag='13302';
	break;
	case *amorosi*:
	$id_del_tag='13303';
	break;
	case *apice*:
	$id_del_tag='13304';
	break;
	case *apollosa*:
	$id_del_tag='13305';
	break;
	case *arpaia*:
	$id_del_tag='13306';
	break;
	case *arpaise*:
	$id_del_tag='13307';
	break;
	case *baselice*:
	$id_del_tag='13308';
	break;
	case *bonea*:
	$id_del_tag='13309';
	break;
	case *bucciano*:
	$id_del_tag='13310';
	break;
	case *buonalbergo*:
	$id_del_tag='13311';
	break;
	case *calvi*:
	$id_del_tag='13312';
	break;
	case *campolattaro*:
	$id_del_tag='13313';
	break;
	case *campoli del monte taburno*:
	$id_del_tag='13314';
	break;
	case *casalduni*:
	$id_del_tag='13315';
	break;
	case *castelfranco in miscano*:
	$id_del_tag='13316';
	break;
	case *castelpagano*:
	$id_del_tag='13317';
	break;
	case *castelpoto*:
	$id_del_tag='13318';
	break;
	case *castelvenere*:
	$id_del_tag='13319';
	break;
	case *castelvetere in val fortore*:
	$id_del_tag='13320';
	break;
	case *cautano*:
	$id_del_tag='13321';
	break;
	case *ceppaloni*:
	$id_del_tag='13322';
	break;
	case *cerreto sannita*:
	$id_del_tag='13323';
	break;
	case *circello*:
	$id_del_tag='13324';
	break;
	case *colle sannita*:
	$id_del_tag='13325';
	break;
	case *cusano mutri*:
	$id_del_tag='13326';
	break;
	case *dugenta*:
	$id_del_tag='13327';
	break;
	case *durazzano*:
	$id_del_tag='13328';
	break;
	case *faicchio*:
	$id_del_tag='13329';
	break;
	case *foglianise*:
	$id_del_tag='13330';
	break;
	case *foiano di val fortore*:
	$id_del_tag='13331';
	break;
	case *forchia*:
	$id_del_tag='13332';
	break;
	case *fragneto l'abate*:
	$id_del_tag='13333';
	break;
	case *fragneto monforte*:
	$id_del_tag='13334';
	break;
	case *frasso telesino*:
	$id_del_tag='13335';
	break;
	case *ginestra degli schiavoni*:
	$id_del_tag='13336';
	break;
	case *guardia sanframondi*:
	$id_del_tag='13337';
	break;
	case *limatola*:
	$id_del_tag='13338';
	break;
	case *melizzano*:
	$id_del_tag='13339';
	break;
	case *moiano*:
	$id_del_tag='13340';
	break;
	case *molinara*:
	$id_del_tag='13341';
	break;
	case *montefalcone di val fortore*:
	$id_del_tag='13342';
	break;
	case *morcone*:
	$id_del_tag='13343';
	break;
	case *paduli*:
	$id_del_tag='13344';
	break;
	case *pago veiano*:
	$id_del_tag='13345';
	break;
	case *pannarano*:
	$id_del_tag='13346';
	break;
	case *paolisi*:
	$id_del_tag='13347';
	break;
	case *paupisi*:
	$id_del_tag='13348';
	break;
	case *pesco sannita*:
	$id_del_tag='13349';
	break;
	case *pietrelcina*:
	$id_del_tag='13350';
	break;
	case *ponte*:
	$id_del_tag='13351';
	break;
	case *pontelandolfo*:
	$id_del_tag='13352';
	break;
	case *puglianello*:
	$id_del_tag='13353';
	break;
	case *reino*:
	$id_del_tag='13354';
	break;
	case *san bartolomeo in galdo*:
	$id_del_tag='13355';
	break;
	case *san giorgio del sannio*:
	$id_del_tag='13356';
	break;
	case *san giorgio la molara*:
	$id_del_tag='13357';
	break;
	case *san leucio del sannio*:
	$id_del_tag='13358';
	break;
	case *san lorenzello*:
	$id_del_tag='13359';
	break;
	case *san lorenzo maggiore*:
	$id_del_tag='13360';
	break;
	case *san lupo*:
	$id_del_tag='13361';
	break;
	case *san marco dei cavoti*:
	$id_del_tag='13362';
	break;
	case *san martino sannita*:
	$id_del_tag='13363';
	break;
	case *san nazzaro*:
	$id_del_tag='13364';
	break;
	case *san nicola manfredi*:
	$id_del_tag='13365';
	break;
	case *san salvatore telesino*:
	$id_del_tag='13366';
	break;
	case *santa croce del sannio*:
	$id_del_tag='13367';
	break;
	case *sant'angelo a cupolo*:
	$id_del_tag='13368';
	break;
	case *sant'arcangelo trimonte*:
	$id_del_tag='13369';
	break;
	case *sassinoro*:
	$id_del_tag='13370';
	break;
	case *solopaca*:
	$id_del_tag='13371';
	break;
	case *telese terme*:
	$id_del_tag='13372';
	break;
	case *tocco caudio*:
	$id_del_tag='13373';
	break;
	case *torrecuso*:
	$id_del_tag='13374';
	break;
	case *vitulano*:
	$id_del_tag='13375';
	break;
	case *agerola*:
	$id_del_tag='13376';
	break;
	case *arzano*:
	$id_del_tag='13377';
	break;
	case *bacoli*:
	$id_del_tag='13378';
	break;
	case *barano d'ischia*:
	$id_del_tag='13379';
	break;
	case *boscoreale*:
	$id_del_tag='13380';
	break;
	case *boscotrecase*:
	$id_del_tag='13381';
	break;
	case *brusciano*:
	$id_del_tag='13382';
	break;
	case *calvizzano*:
	$id_del_tag='13383';
	break;
	case *camposano*:
	$id_del_tag='13384';
	break;
	case *carbonara di nola*:
	$id_del_tag='13385';
	break;
	case *cardito*:
	$id_del_tag='13386';
	break;
	case *casalnuovo di napoli*:
	$id_del_tag='13387';
	break;
	case *casamarciano*:
	$id_del_tag='13388';
	break;
	case *casamicciola terme*:
	$id_del_tag='13389';
	break;
	case *casandrino*:
	$id_del_tag='13390';
	break;
	case *casavatore*:
	$id_del_tag='13391';
	break;
	case *casola di napoli*:
	$id_del_tag='13392';
	break;
	case *casoria*:
	$id_del_tag='13393';
	break;
	case *castellammare di stabia*:
	$id_del_tag='13394';
	break;
	case *castello di cisterna*:
	$id_del_tag='13395';
	break;
	case *cercola*:
	$id_del_tag='13396';
	break;
	case *cicciano*:
	$id_del_tag='13397';
	break;
	case *cimitile*:
	$id_del_tag='13398';
	break;
	case *comiziano*:
	$id_del_tag='13399';
	break;
	case *crispano*:
	$id_del_tag='13400';
	break;
	case *ercolano*:
	$id_del_tag='13401';
	break;
	case *forio*:
	$id_del_tag='13402';
	break;
	case *frattamaggiore*:
	$id_del_tag='13403';
	break;
	case *frattaminore*:
	$id_del_tag='13404';
	break;
	case *giugliano in campania*:
	$id_del_tag='13405';
	break;
	case *gragnano*:
	$id_del_tag='13406';
	break;
	case *grumo nevano*:
	$id_del_tag='13407';
	break;
	case *lacco ameno*:
	$id_del_tag='13408';
	break;
	case *lettere*:
	$id_del_tag='13409';
	break;
	case *liveri*:
	$id_del_tag='13410';
	break;
	case *marano di napoli*:
	$id_del_tag='13411';
	break;
	case *mariglianella*:
	$id_del_tag='13412';
	break;
	case *marigliano*:
	$id_del_tag='13413';
	break;
	case *massa di somma*:
	$id_del_tag='13414';
	break;
	case *massa lubrense*:
	$id_del_tag='13415';
	break;
	case *melito di napoli*:
	$id_del_tag='13416';
	break;
	case *meta*:
	$id_del_tag='13417';
	break;
	case *monte di procida*:
	$id_del_tag='13418';
	break;
	case *mugnano di napoli*:
	$id_del_tag='13419';
	break;
	case *ottaviano*:
	$id_del_tag='13420';
	break;
	case *palma campania*:
	$id_del_tag='13421';
	break;
	case *piano di sorrento*:
	$id_del_tag='13422';
	break;
	case *pimonte*:
	$id_del_tag='13423';
	break;
	case *poggiomarino*:
	$id_del_tag='13424';
	break;
	case *pollena trocchia*:
	$id_del_tag='13425';
	break;
	case *portici*:
	$id_del_tag='13426';
	break;
	case *procida*:
	$id_del_tag='13427';
	break;
	case *qualiano*:
	$id_del_tag='13428';
	break;
	case *quarto*:
	$id_del_tag='13429';
	break;
	case *roccarainola*:
	$id_del_tag='13430';
	break;
	case *san gennaro vesuviano*:
	$id_del_tag='13431';
	break;
	case *san giorgio a cremano*:
	$id_del_tag='13432';
	break;
	case *san giuseppe vesuviano*:
	$id_del_tag='13433';
	break;
	case *san paolo bel sito*:
	$id_del_tag='13434';
	break;
	case *san sebastiano al vesuvio*:
	$id_del_tag='13435';
	break;
	case *san vitaliano*:
	$id_del_tag='13436';
	break;
	case *santa maria la carità*:
	$id_del_tag='13437';
	break;
	case *sant'anastasia*:
	$id_del_tag='13438';
	break;
	case *sant'antimo*:
	$id_del_tag='13439';
	break;
	case *sant'antonio abate*:
	$id_del_tag='13440';
	break;
	case *saviano*:
	$id_del_tag='13441';
	break;
	case *scisciano*:
	$id_del_tag='13442';
	break;
	case *serrara fontana*:
	$id_del_tag='13443';
	break;
	case *striano*:
	$id_del_tag='13444';
	break;
	case *terzigno*:
	$id_del_tag='13445';
	break;
	case *torre annunziata*:
	$id_del_tag='13446';
	break;
	case *torre del greco*:
	$id_del_tag='13447';
	break;
	case *tufino*:
	$id_del_tag='13448';
	break;
	case *villaricca*:
	$id_del_tag='13449';
	break;
	case *visciano*:
	$id_del_tag='13450';
	break;
	case *volla*:
	$id_del_tag='13451';
	break;
	case *aiello del sabato*:
	$id_del_tag='13452';
	break;
	case *altavilla irpina*:
	$id_del_tag='13453';
	break;
	case *andretta*:
	$id_del_tag='13454';
	break;
	case *aquilonia*:
	$id_del_tag='13455';
	break;
	case *avella*:
	$id_del_tag='13456';
	break;
	case *bagnoli irpino*:
	$id_del_tag='13457';
	break;
	case *baiano*:
	$id_del_tag='13458';
	break;
	case *bisaccia*:
	$id_del_tag='13459';
	break;
	case *bonito*:
	$id_del_tag='13460';
	break;
	case *cairano*:
	$id_del_tag='13461';
	break;
	case *calabritto*:
	$id_del_tag='13462';
	break;
	case *calitri*:
	$id_del_tag='13463';
	break;
	case *candida*:
	$id_del_tag='13464';
	break;
	case *caposele*:
	$id_del_tag='13465';
	break;
	case *capriglia irpina*:
	$id_del_tag='13466';
	break;
	case *carife*:
	$id_del_tag='13467';
	break;
	case *casalbore*:
	$id_del_tag='13468';
	break;
	case *cassano irpino*:
	$id_del_tag='13469';
	break;
	case *castel baronia*:
	$id_del_tag='13470';
	break;
	case *castelfranci*:
	$id_del_tag='13471';
	break;
	case *castelvetere sul calore*:
	$id_del_tag='13472';
	break;
	case *cervinara*:
	$id_del_tag='13473';
	break;
	case *cesinali*:
	$id_del_tag='13474';
	break;
	case *chianche*:
	$id_del_tag='13475';
	break;
	case *chiusano di san domenico*:
	$id_del_tag='13476';
	break;
	case *contrada*:
	$id_del_tag='13477';
	break;
	case *conza della campania*:
	$id_del_tag='13478';
	break;
	case *domicella*:
	$id_del_tag='13479';
	break;
	case *flumeri*:
	$id_del_tag='13480';
	break;
	case *fontanarosa*:
	$id_del_tag='13481';
	break;
	case *forino*:
	$id_del_tag='13482';
	break;
	case *frigento*:
	$id_del_tag='13483';
	break;
	case *gesualdo*:
	$id_del_tag='13484';
	break;
	case *greci*:
	$id_del_tag='13485';
	break;
	case *grottaminarda*:
	$id_del_tag='13486';
	break;
	case *grottolella*:
	$id_del_tag='13487';
	break;
	case *guardia lombardi*:
	$id_del_tag='13488';
	break;
	case *lacedonia*:
	$id_del_tag='13489';
	break;
	case *lapio*:
	$id_del_tag='13490';
	break;
	case *lauro*:
	$id_del_tag='13491';
	break;
	case *lioni*:
	$id_del_tag='13492';
	break;
	case *luogosano*:
	$id_del_tag='13493';
	break;
	case *manocalzati*:
	$id_del_tag='13494';
	break;
	case *marzano di nola*:
	$id_del_tag='13495';
	break;
	case *melito irpino*:
	$id_del_tag='13496';
	break;
	case *mercogliano*:
	$id_del_tag='13497';
	break;
	case *mirabella eclano*:
	$id_del_tag='13498';
	break;
	case *montaguto*:
	$id_del_tag='13499';
	break;
	case *montecalvo irpino*:
	$id_del_tag='13500';
	break;
	case *montefalcione*:
	$id_del_tag='13501';
	break;
	case *monteforte irpino*:
	$id_del_tag='13502';
	break;
	case *montefredane*:
	$id_del_tag='13503';
	break;
	case *montefusco*:
	$id_del_tag='13504';
	break;
	case *montella*:
	$id_del_tag='13505';
	break;
	case *montemarano*:
	$id_del_tag='13506';
	break;
	case *montemiletto*:
	$id_del_tag='13507';
	break;
	case *monteverde*:
	$id_del_tag='13508';
	break;
	case *montoro inferiore*:
	$id_del_tag='13509';
	break;
	case *montoro superiore*:
	$id_del_tag='13510';
	break;
	case *morra de sanctis*:
	$id_del_tag='13511';
	break;
	case *moschiano*:
	$id_del_tag='13512';
	break;
	case *mugnano del cardinale*:
	$id_del_tag='13513';
	break;
	case *nusco*:
	$id_del_tag='13514';
	break;
	case *ospedaletto d'alpinolo*:
	$id_del_tag='13515';
	break;
	case *pago del vallo di lauro*:
	$id_del_tag='13516';
	break;
	case *parolise*:
	$id_del_tag='13517';
	break;
	case *paternopoli*:
	$id_del_tag='13518';
	break;
	case *petruro irpino*:
	$id_del_tag='13519';
	break;
	case *pietradefusi*:
	$id_del_tag='13520';
	break;
	case *pietrastornina*:
	$id_del_tag='13521';
	break;
	case *prata di principato ultra*:
	$id_del_tag='13522';
	break;
	case *quadrelle*:
	$id_del_tag='13523';
	break;
	case *quindici*:
	$id_del_tag='13524';
	break;
	case *rocca san felice*:
	$id_del_tag='13525';
	break;
	case *roccabascerana*:
	$id_del_tag='13526';
	break;
	case *rotondi*:
	$id_del_tag='13527';
	break;
	case *salza irpina*:
	$id_del_tag='13528';
	break;
	case *san mango sul calore*:
	$id_del_tag='13529';
	break;
	case *san martino valle caudina*:
	$id_del_tag='13530';
	break;
	case *san michele di serino*:
	$id_del_tag='13531';
	break;
	case *san nicola baronia*:
	$id_del_tag='13532';
	break;
	case *san potito ultra*:
	$id_del_tag='13533';
	break;
	case *san sossio baronia*:
	$id_del_tag='13534';
	break;
	case *santa lucia di serino*:
	$id_del_tag='13535';
	break;
	case *santa paolina*:
	$id_del_tag='13536';
	break;
	case *sant'andrea di conza*:
	$id_del_tag='13537';
	break;
	case *sant'angelo a scala*:
	$id_del_tag='13538';
	break;
	case *sant'angelo all'esca*:
	$id_del_tag='13539';
	break;
	case *sant'angelo dei lombardi*:
	$id_del_tag='13540';
	break;
	case *santo stefano del sole*:
	$id_del_tag='13541';
	break;
	case *savignano irpino*:
	$id_del_tag='13542';
	break;
	case *scampitella*:
	$id_del_tag='13543';
	break;
	case *senerchia*:
	$id_del_tag='13544';
	break;
	case *serino*:
	$id_del_tag='13545';
	break;
	case *sirignano*:
	$id_del_tag='13546';
	break;
	case *solofra*:
	$id_del_tag='13547';
	break;
	case *sorbo serpico*:
	$id_del_tag='13548';
	break;
	case *sperone*:
	$id_del_tag='13549';
	break;
	case *sturno*:
	$id_del_tag='13550';
	break;
	case *summonte*:
	$id_del_tag='13551';
	break;
	case *taurano*:
	$id_del_tag='13552';
	break;
	case *taurasi*:
	$id_del_tag='13553';
	break;
	case *teora*:
	$id_del_tag='13554';
	break;
	case *torella dei lombardi*:
	$id_del_tag='13555';
	break;
	case *torre le nocelle*:
	$id_del_tag='13556';
	break;
	case *torrioni*:
	$id_del_tag='13557';
	break;
	case *trevico*:
	$id_del_tag='13558';
	break;
	case *tufo*:
	$id_del_tag='13559';
	break;
	case *vallata*:
	$id_del_tag='13560';
	break;
	case *vallesaccarda*:
	$id_del_tag='13561';
	break;
	case *venticano*:
	$id_del_tag='13562';
	break;
	case *villamaina*:
	$id_del_tag='13563';
	break;
	case *villanova del battista*:
	$id_del_tag='13564';
	break;
	case *volturara irpina*:
	$id_del_tag='13565';
	break;
	case *zungoli*:
	$id_del_tag='13566';
	break;
	case *acerno*:
	$id_del_tag='13567';
	break;
	case *agropoli*:
	$id_del_tag='13568';
	break;
	case *albanella*:
	$id_del_tag='13569';
	break;
	case *alfano*:
	$id_del_tag='13570';
	break;
	case *altavilla silentina*:
	$id_del_tag='13571';
	break;
	case *amalfi*:
	$id_del_tag='13572';
	break;
	case *angri*:
	$id_del_tag='13573';
	break;
	case *ascea*:
	$id_del_tag='13574';
	break;
	case *atena lucana*:
	$id_del_tag='13575';
	break;
	case *atrani*:
	$id_del_tag='13576';
	break;
	case *auletta*:
	$id_del_tag='13577';
	break;
	case *baronissi*:
	$id_del_tag='13578';
	break;
	case *bellizzi*:
	$id_del_tag='13579';
	break;
	case *bracigliano*:
	$id_del_tag='13580';
	break;
	case *buccino*:
	$id_del_tag='13581';
	break;
	case *buonabitacolo*:
	$id_del_tag='13582';
	break;
	case *caggiano*:
	$id_del_tag='13583';
	break;
	case *calvanico*:
	$id_del_tag='13584';
	break;
	case *camerota*:
	$id_del_tag='13585';
	break;
	case *campagna*:
	$id_del_tag='13586';
	break;
	case *campora*:
	$id_del_tag='13587';
	break;
	case *cannalonga*:
	$id_del_tag='13588';
	break;
	case *capaccio*:
	$id_del_tag='13589';
	break;
	case *casal velino*:
	$id_del_tag='13590';
	break;
	case *casalbuono*:
	$id_del_tag='13591';
	break;
	case *casaletto spartano*:
	$id_del_tag='13592';
	break;
	case *caselle in pittari*:
	$id_del_tag='13593';
	break;
	case *castel san giorgio*:
	$id_del_tag='13594';
	break;
	case *castel san lorenzo*:
	$id_del_tag='13595';
	break;
	case *castelnuovo cilento*:
	$id_del_tag='13596';
	break;
	case *castelnuovo di conza*:
	$id_del_tag='13597';
	break;
	case *castiglione del genovesi*:
	$id_del_tag='13598';
	break;
	case *celle di bulgheria*:
	$id_del_tag='13599';
	break;
	case *centola*:
	$id_del_tag='13600';
	break;
	case *ceraso*:
	$id_del_tag='13601';
	break;
	case *cetara*:
	$id_del_tag='13602';
	break;
	case *cicerale*:
	$id_del_tag='13603';
	break;
	case *colliano*:
	$id_del_tag='13604';
	break;
	case *conca dei marini*:
	$id_del_tag='13605';
	break;
	case *contursi terme*:
	$id_del_tag='13606';
	break;
	case *corbara*:
	$id_del_tag='13607';
	break;
	case *cuccaro vetere*:
	$id_del_tag='13608';
	break;
	case *fisciano*:
	$id_del_tag='13609';
	break;
	case *furore*:
	$id_del_tag='13610';
	break;
	case *futani*:
	$id_del_tag='13611';
	break;
	case *giffoni sei casali*:
	$id_del_tag='13612';
	break;
	case *giffoni valle piana*:
	$id_del_tag='13613';
	break;
	case *gioi*:
	$id_del_tag='13614';
	break;
	case *giungano*:
	$id_del_tag='13615';
	break;
	case *ispani*:
	$id_del_tag='13616';
	break;
	case *laureana cilento*:
	$id_del_tag='13617';
	break;
	case *laurito*:
	$id_del_tag='13618';
	break;
	case *laviano*:
	$id_del_tag='13619';
	break;
	case *lustra*:
	$id_del_tag='13620';
	break;
	case *magliano vetere*:
	$id_del_tag='13621';
	break;
	case *minori*:
	$id_del_tag='13622';
	break;
	case *moio della civitella*:
	$id_del_tag='13623';
	break;
	case *montano antilia*:
	$id_del_tag='13624';
	break;
	case *monte san giacomo*:
	$id_del_tag='13625';
	break;
	case *montecorice*:
	$id_del_tag='13626';
	break;
	case *montecorvino pugliano*:
	$id_del_tag='13627';
	break;
	case *monteforte cilento*:
	$id_del_tag='13628';
	break;
	case *montesano sulla marcellana*:
	$id_del_tag='13629';
	break;
	case *morigerati*:
	$id_del_tag='13630';
	break;
	case *nocera inferiore*:
	$id_del_tag='13631';
	break;
	case *novi velia*:
	$id_del_tag='13632';
	break;
	case *ogliastro cilento*:
	$id_del_tag='13633';
	break;
	case *olevano sul tusciano*:
	$id_del_tag='13634';
	break;
	case *oliveto citra*:
	$id_del_tag='13635';
	break;
	case *omignano*:
	$id_del_tag='13636';
	break;
	case *orria*:
	$id_del_tag='13637';
	break;
	case *padula*:
	$id_del_tag='13638';
	break;
	case *palomonte*:
	$id_del_tag='13639';
	break;
	case *pellezzano*:
	$id_del_tag='13640';
	break;
	case *perdifumo*:
	$id_del_tag='13641';
	break;
	case *perito*:
	$id_del_tag='13642';
	break;
	case *pertosa*:
	$id_del_tag='13643';
	break;
	case *petina*:
	$id_del_tag='13644';
	break;
	case *pisciotta*:
	$id_del_tag='13645';
	break;
	case *polla*:
	$id_del_tag='13646';
	break;
	case *pollica*:
	$id_del_tag='13647';
	break;
	case *pontecagnano faiano*:
	$id_del_tag='13648';
	break;
	case *postiglione*:
	$id_del_tag='13649';
	break;
	case *prignano cilento*:
	$id_del_tag='13650';
	break;
	case *ravello*:
	$id_del_tag='13651';
	break;
	case *ricigliano*:
	$id_del_tag='13652';
	break;
	case *roccagloriosa*:
	$id_del_tag='13653';
	break;
	case *roccapiemonte*:
	$id_del_tag='13654';
	break;
	case *rofrano*:
	$id_del_tag='13655';
	break;
	case *romagnano al monte*:
	$id_del_tag='13656';
	break;
	case *rutino*:
	$id_del_tag='13657';
	break;
	case *salento*:
	$id_del_tag='13658';
	break;
	case *salvitelle*:
	$id_del_tag='13659';
	break;
	case *san cipriano picentino*:
	$id_del_tag='13660';
	break;
	case *san giovanni a piro*:
	$id_del_tag='13661';
	break;
	case *san gregorio magno*:
	$id_del_tag='13662';
	break;
	case *san mango piemonte*:
	$id_del_tag='13663';
	break;
	case *san marzano sul sarno*:
	$id_del_tag='13664';
	break;
	case *san mauro cilento*:
	$id_del_tag='13665';
	break;
	case *san mauro la bruca*:
	$id_del_tag='13666';
	break;
	case *san pietro al tanagro*:
	$id_del_tag='13667';
	break;
	case *san rufo*:
	$id_del_tag='13668';
	break;
	case *san valentino torio*:
	$id_del_tag='13669';
	break;
	case *santa marina*:
	$id_del_tag='13670';
	break;
	case *sant'angelo a fasanella*:
	$id_del_tag='13671';
	break;
	case *sant'arsenio*:
	$id_del_tag='13672';
	break;
	case *sant'egidio del monte albino*:
	$id_del_tag='13673';
	break;
	case *santomenna*:
	$id_del_tag='13674';
	break;
	case *sanza*:
	$id_del_tag='13675';
	break;
	case *sapri*:
	$id_del_tag='13676';
	break;
	case *scafati*:
	$id_del_tag='13677';
	break;
	case *scala*:
	$id_del_tag='13678';
	break;
	case *serramezzana*:
	$id_del_tag='13679';
	break;
	case *serre*:
	$id_del_tag='13680';
	break;
	case *sessa cilento*:
	$id_del_tag='13681';
	break;
	case *siano*:
	$id_del_tag='13682';
	break;
	case *stella cilento*:
	$id_del_tag='13683';
	break;
	case *teggiano*:
	$id_del_tag='13684';
	break;
	case *torraca*:
	$id_del_tag='13685';
	break;
	case *torre orsaia*:
	$id_del_tag='13686';
	break;
	case *tortorella*:
	$id_del_tag='13687';
	break;
	case *tramonti*:
	$id_del_tag='13688';
	break;
	case *trentinara*:
	$id_del_tag='13689';
	break;
	case *vallo della lucania*:
	$id_del_tag='13690';
	break;
	case *vibonati*:
	$id_del_tag='13691';
	break;
	case *vietri sul mare*:
	$id_del_tag='13692';
	break;
	case *acciano*:
	$id_del_tag='13693';
	break;
	case *aielli*:
	$id_del_tag='13694';
	break;
	case *alfedena*:
	$id_del_tag='13695';
	break;
	case *anversa degli abruzzi*:
	$id_del_tag='13696';
	break;
	case *ateleta*:
	$id_del_tag='13697';
	break;
	case *balsorano*:
	$id_del_tag='13698';
	break;
	case *barete*:
	$id_del_tag='13699';
	break;
	case *barisciano*:
	$id_del_tag='13700';
	break;
	case *barrea*:
	$id_del_tag='13701';
	break;
	case *bisegna*:
	$id_del_tag='13702';
	break;
	case *bugnara*:
	$id_del_tag='13703';
	break;
	case *cagnano amiterno*:
	$id_del_tag='13704';
	break;
	case *calascio*:
	$id_del_tag='13705';
	break;
	case *campo di giove*:
	$id_del_tag='13706';
	break;
	case *campotosto*:
	$id_del_tag='13707';
	break;
	case *canistro*:
	$id_del_tag='13708';
	break;
	case *cansano*:
	$id_del_tag='13709';
	break;
	case *capestrano*:
	$id_del_tag='13710';
	break;
	case *capistrello*:
	$id_del_tag='13711';
	break;
	case *capitignano*:
	$id_del_tag='13712';
	break;
	case *caporciano*:
	$id_del_tag='13713';
	break;
	case *cappadocia*:
	$id_del_tag='13714';
	break;
	case *carapelle calvisio*:
	$id_del_tag='13715';
	break;
	case *carsoli*:
	$id_del_tag='13716';
	break;
	case *castel di ieri*:
	$id_del_tag='13717';
	break;
	case *castel di sangro*:
	$id_del_tag='13718';
	break;
	case *castellafiume*:
	$id_del_tag='13719';
	break;
	case *castelvecchio calvisio*:
	$id_del_tag='13720';
	break;
	case *castelvecchio subequo*:
	$id_del_tag='13721';
	break;
	case *celano*:
	$id_del_tag='13722';
	break;
	case *cerchio*:
	$id_del_tag='13723';
	break;
	case *civita d'antino*:
	$id_del_tag='13724';
	break;
	case *civitella alfedena*:
	$id_del_tag='13725';
	break;
	case *civitella roveto*:
	$id_del_tag='13726';
	break;
	case *cocullo*:
	$id_del_tag='13727';
	break;
	case *collarmele*:
	$id_del_tag='13728';
	break;
	case *collelongo*:
	$id_del_tag='13729';
	break;
	case *collepietro*:
	$id_del_tag='13730';
	break;
	case *corfinio*:
	$id_del_tag='13731';
	break;
	case *fagnano alto*:
	$id_del_tag='13732';
	break;
	case *fontecchio*:
	$id_del_tag='13733';
	break;
	case *fossa*:
	$id_del_tag='13734';
	break;
	case *gagliano aterno*:
	$id_del_tag='13735';
	break;
	case *gioia dei marsi*:
	$id_del_tag='13736';
	break;
	case *goriano sicoli*:
	$id_del_tag='13737';
	break;
	case *introdacqua*:
	$id_del_tag='13738';
	break;
	case *lecce nei marsi*:
	$id_del_tag='13739';
	break;
	case *luco dei marsi*:
	$id_del_tag='13740';
	break;
	case *lucoli*:
	$id_del_tag='13741';
	break;
	case *magliano de' marsi*:
	$id_del_tag='13742';
	break;
	case *massa d'albe*:
	$id_del_tag='13743';
	break;
	case *molina aterno*:
	$id_del_tag='13744';
	break;
	case *montereale*:
	$id_del_tag='13745';
	break;
	case *morino*:
	$id_del_tag='13746';
	break;
	case *navelli*:
	$id_del_tag='13747';
	break;
	case *ocre*:
	$id_del_tag='13748';
	break;
	case *ofena*:
	$id_del_tag='13749';
	break;
	case *opi*:
	$id_del_tag='13750';
	break;
	case *oricola*:
	$id_del_tag='13751';
	break;
	case *ortona dei marsi*:
	$id_del_tag='13752';
	break;
	case *ortucchio*:
	$id_del_tag='13753';
	break;
	case *ovindoli*:
	$id_del_tag='13754';
	break;
	case *pacentro*:
	$id_del_tag='13755';
	break;
	case *pereto*:
	$id_del_tag='13756';
	break;
	case *pescasseroli*:
	$id_del_tag='13757';
	break;
	case *pescina*:
	$id_del_tag='13758';
	break;
	case *pescocostanzo*:
	$id_del_tag='13759';
	break;
	case *pettorano sul gizio*:
	$id_del_tag='13760';
	break;
	case *pizzoli*:
	$id_del_tag='13761';
	break;
	case *poggio picenze*:
	$id_del_tag='13762';
	break;
	case *prata d'ansidonia*:
	$id_del_tag='13763';
	break;
	case *pratola peligna*:
	$id_del_tag='13764';
	break;
	case *prezza*:
	$id_del_tag='13765';
	break;
	case *raiano*:
	$id_del_tag='13766';
	break;
	case *rivisondoli*:
	$id_del_tag='13767';
	break;
	case *rocca di botte*:
	$id_del_tag='13768';
	break;
	case *rocca di cambio*:
	$id_del_tag='13769';
	break;
	case *rocca di mezzo*:
	$id_del_tag='13770';
	break;
	case *rocca pia*:
	$id_del_tag='13771';
	break;
	case *roccacasale*:
	$id_del_tag='13772';
	break;
	case *roccaraso*:
	$id_del_tag='13773';
	break;
	case *san benedetto dei marsi*:
	$id_del_tag='13774';
	break;
	case *san benedetto in perillis*:
	$id_del_tag='13775';
	break;
	case *san demetrio ne' vestini*:
	$id_del_tag='13776';
	break;
	case *san pio delle camere*:
	$id_del_tag='13777';
	break;
	case *san vincenzo valle roveto*:
	$id_del_tag='13778';
	break;
	case *sante marie*:
	$id_del_tag='13779';
	break;
	case *sant'eusanio forconese*:
	$id_del_tag='13780';
	break;
	case *santo stefano di sessanio*:
	$id_del_tag='13781';
	break;
	case *scanno*:
	$id_del_tag='13782';
	break;
	case *scontrone*:
	$id_del_tag='13783';
	break;
	case *scoppito*:
	$id_del_tag='13784';
	break;
	case *scurcola marsicana*:
	$id_del_tag='13785';
	break;
	case *secinaro*:
	$id_del_tag='13786';
	break;
	case *tagliacozzo*:
	$id_del_tag='13787';
	break;
	case *tione degli abruzzi*:
	$id_del_tag='13788';
	break;
	case *tornimparte*:
	$id_del_tag='13789';
	break;
	case *trasacco*:
	$id_del_tag='13790';
	break;
	case *villa santa lucia degli abruzzi*:
	$id_del_tag='13791';
	break;
	case *villa sant'angelo*:
	$id_del_tag='13792';
	break;
	case *villalago*:
	$id_del_tag='13793';
	break;
	case *villavallelonga*:
	$id_del_tag='13794';
	break;
	case *villetta barrea*:
	$id_del_tag='13795';
	break;
	case *vittorito*:
	$id_del_tag='13796';
	break;
	case *alba adriatica*:
	$id_del_tag='13797';
	break;
	case *ancarano*:
	$id_del_tag='13798';
	break;
	case *arsita*:
	$id_del_tag='13799';
	break;
	case *atri*:
	$id_del_tag='13800';
	break;
	case *basciano*:
	$id_del_tag='13801';
	break;
	case *bellante*:
	$id_del_tag='13802';
	break;
	case *bisenti*:
	$id_del_tag='13803';
	break;
	case *campli*:
	$id_del_tag='13804';
	break;
	case *canzano*:
	$id_del_tag='13805';
	break;
	case *castel castagna*:
	$id_del_tag='13806';
	break;
	case *castellalto*:
	$id_del_tag='13807';
	break;
	case *castelli*:
	$id_del_tag='13808';
	break;
	case *castiglione messer raimondo*:
	$id_del_tag='13809';
	break;
	case *castilenti*:
	$id_del_tag='13810';
	break;
	case *cellino attanasio*:
	$id_del_tag='13811';
	break;
	case *cermignano*:
	$id_del_tag='13812';
	break;
	case *civitella del tronto*:
	$id_del_tag='13813';
	break;
	case *colledara*:
	$id_del_tag='13814';
	break;
	case *colonnella*:
	$id_del_tag='13815';
	break;
	case *controguerra*:
	$id_del_tag='13816';
	break;
	case *corropoli*:
	$id_del_tag='13817';
	break;
	case *cortino*:
	$id_del_tag='13818';
	break;
	case *crognaleto*:
	$id_del_tag='13819';
	break;
	case *fano adriano*:
	$id_del_tag='13820';
	break;
	case *giulianova*:
	$id_del_tag='13821';
	break;
	case *isola del gran sasso d'italia*:
	$id_del_tag='13822';
	break;
	case *martinsicuro*:
	$id_del_tag='13823';
	break;
	case *montefino*:
	$id_del_tag='13824';
	break;
	case *montorio al vomano*:
	$id_del_tag='13825';
	break;
	case *morro d'oro*:
	$id_del_tag='13826';
	break;
	case *mosciano sant'angelo*:
	$id_del_tag='13827';
	break;
	case *nereto*:
	$id_del_tag='13828';
	break;
	case *notaresco*:
	$id_del_tag='13829';
	break;
	case *penna sant'andrea*:
	$id_del_tag='13830';
	break;
	case *pietracamela*:
	$id_del_tag='13831';
	break;
	case *pineto*:
	$id_del_tag='13832';
	break;
	case *rocca santa maria*:
	$id_del_tag='13833';
	break;
	case *sant'egidio alla vibrata*:
	$id_del_tag='13834';
	break;
	case *sant'omero*:
	$id_del_tag='13835';
	break;
	case *silvi*:
	$id_del_tag='13836';
	break;
	case *torano nuovo*:
	$id_del_tag='13837';
	break;
	case *torricella sicura*:
	$id_del_tag='13838';
	break;
	case *tortoreto*:
	$id_del_tag='13839';
	break;
	case *tossicia*:
	$id_del_tag='13840';
	break;
	case *valle castellana*:
	$id_del_tag='13841';
	break;
	case *abbateggio*:
	$id_del_tag='13842';
	break;
	case *alanno*:
	$id_del_tag='13843';
	break;
	case *bolognano*:
	$id_del_tag='13844';
	break;
	case *brittoli*:
	$id_del_tag='13845';
	break;
	case *bussi sul tirino*:
	$id_del_tag='13846';
	break;
	case *cappelle sul tavo*:
	$id_del_tag='13847';
	break;
	case *caramanico terme*:
	$id_del_tag='13848';
	break;
	case *carpineto della nora*:
	$id_del_tag='13849';
	break;
	case *castiglione a casauria*:
	$id_del_tag='13850';
	break;
	case *catignano*:
	$id_del_tag='13851';
	break;
	case *cepagatti*:
	$id_del_tag='13852';
	break;
	case *città sant'angelo*:
	$id_del_tag='13853';
	break;
	case *civitaquana*:
	$id_del_tag='13854';
	break;
	case *civitella casanova*:
	$id_del_tag='13855';
	break;
	case *collecorvino*:
	$id_del_tag='13856';
	break;
	case *corvara*:
	$id_del_tag='13857';
	break;
	case *cugnoli*:
	$id_del_tag='13858';
	break;
	case *elice*:
	$id_del_tag='13859';
	break;
	case *farindola*:
	$id_del_tag='13860';
	break;
	case *lettomanoppello*:
	$id_del_tag='13861';
	break;
	case *loreto aprutino*:
	$id_del_tag='13862';
	break;
	case *manoppello*:
	$id_del_tag='13863';
	break;
	case *montebello di bertona*:
	$id_del_tag='13864';
	break;
	case *montesilvano*:
	$id_del_tag='13865';
	break;
	case *moscufo*:
	$id_del_tag='13866';
	break;
	case *nocciano*:
	$id_del_tag='13867';
	break;
	case *penne*:
	$id_del_tag='13868';
	break;
	case *pescosansonesco*:
	$id_del_tag='13869';
	break;
	case *pianella*:
	$id_del_tag='13870';
	break;
	case *picciano*:
	$id_del_tag='13871';
	break;
	case *pietranico*:
	$id_del_tag='13872';
	break;
	case *popoli*:
	$id_del_tag='13873';
	break;
	case *roccamorice*:
	$id_del_tag='13874';
	break;
	case *rosciano*:
	$id_del_tag='13875';
	break;
	case *salle*:
	$id_del_tag='13876';
	break;
	case *san valentino in abruzzo citeriore*:
	$id_del_tag='13877';
	break;
	case *sant'eufemia a maiella*:
	$id_del_tag='13878';
	break;
	case *scafa*:
	$id_del_tag='13879';
	break;
	case *serramonacesca*:
	$id_del_tag='13880';
	break;
	case *spoltore*:
	$id_del_tag='13881';
	break;
	case *tocco da casauria*:
	$id_del_tag='13882';
	break;
	case *torre de' passeri*:
	$id_del_tag='13883';
	break;
	case *turrivalignani*:
	$id_del_tag='13884';
	break;
	case *vicoli*:
	$id_del_tag='13885';
	break;
	case *villa celiera*:
	$id_del_tag='13886';
	break;
	case *altino*:
	$id_del_tag='13887';
	break;
	case *archi*:
	$id_del_tag='13888';
	break;
	case *ari*:
	$id_del_tag='13889';
	break;
	case *arielli*:
	$id_del_tag='13890';
	break;
	case *atessa*:
	$id_del_tag='13891';
	break;
	case *bomba*:
	$id_del_tag='13892';
	break;
	case *borrello*:
	$id_del_tag='13893';
	break;
	case *bucchianico*:
	$id_del_tag='13894';
	break;
	case *canosa sannita*:
	$id_del_tag='13895';
	break;
	case *carpineto sinello*:
	$id_del_tag='13896';
	break;
	case *carunchio*:
	$id_del_tag='13897';
	break;
	case *casacanditella*:
	$id_del_tag='13898';
	break;
	case *casalanguida*:
	$id_del_tag='13899';
	break;
	case *casalbordino*:
	$id_del_tag='13900';
	break;
	case *casalincontrada*:
	$id_del_tag='13901';
	break;
	case *casoli*:
	$id_del_tag='13902';
	break;
	case *castel frentano*:
	$id_del_tag='13903';
	break;
	case *castelguidone*:
	$id_del_tag='13904';
	break;
	case *castiglione messer marino*:
	$id_del_tag='13905';
	break;
	case *celenza sul trigno*:
	$id_del_tag='13906';
	break;
	case *civitaluparella*:
	$id_del_tag='13907';
	break;
	case *civitella messer raimondo*:
	$id_del_tag='13908';
	break;
	case *colledimacine*:
	$id_del_tag='13909';
	break;
	case *colledimezzo*:
	$id_del_tag='13910';
	break;
	case *crecchio*:
	$id_del_tag='13911';
	break;
	case *cupello*:
	$id_del_tag='13912';
	break;
	case *dogliola*:
	$id_del_tag='13913';
	break;
	case *fallo*:
	$id_del_tag='13914';
	break;
	case *fara filiorum petri*:
	$id_del_tag='13915';
	break;
	case *fara san martino*:
	$id_del_tag='13916';
	break;
	case *filetto*:
	$id_del_tag='13917';
	break;
	case *fossacesia*:
	$id_del_tag='13918';
	break;
	case *fraine*:
	$id_del_tag='13919';
	break;
	case *francavilla al mare*:
	$id_del_tag='13920';
	break;
	case *fresagrandinaria*:
	$id_del_tag='13921';
	break;
	case *frisa*:
	$id_del_tag='13922';
	break;
	case *furci*:
	$id_del_tag='13923';
	break;
	case *gamberale*:
	$id_del_tag='13924';
	break;
	case *gessopalena*:
	$id_del_tag='13925';
	break;
	case *gissi*:
	$id_del_tag='13926';
	break;
	case *giuliano teatino*:
	$id_del_tag='13927';
	break;
	case *guardiagrele*:
	$id_del_tag='13928';
	break;
	case *guilmi*:
	$id_del_tag='13929';
	break;
	case *lama dei peligni*:
	$id_del_tag='13930';
	break;
	case *lentella*:
	$id_del_tag='13931';
	break;
	case *lettopalena*:
	$id_del_tag='13932';
	break;
	case *liscia*:
	$id_del_tag='13933';
	break;
	case *miglianico*:
	$id_del_tag='13934';
	break;
	case *montazzoli*:
	$id_del_tag='13935';
	break;
	case *montebello sul sangro*:
	$id_del_tag='13936';
	break;
	case *monteferrante*:
	$id_del_tag='13937';
	break;
	case *montelapiano*:
	$id_del_tag='13938';
	break;
	case *montenerodomo*:
	$id_del_tag='13939';
	break;
	case *monteodorisio*:
	$id_del_tag='13940';
	break;
	case *mozzagrogna*:
	$id_del_tag='13941';
	break;
	case *orsogna*:
	$id_del_tag='13942';
	break;
	case *paglieta*:
	$id_del_tag='13943';
	break;
	case *palena*:
	$id_del_tag='13944';
	break;
	case *palmoli*:
	$id_del_tag='13945';
	break;
	case *palombaro*:
	$id_del_tag='13946';
	break;
	case *pennadomo*:
	$id_del_tag='13947';
	break;
	case *pennapiedimonte*:
	$id_del_tag='13948';
	break;
	case *perano*:
	$id_del_tag='13949';
	break;
	case *pietraferrazzana*:
	$id_del_tag='13950';
	break;
	case *pizzoferrato*:
	$id_del_tag='13951';
	break;
	case *poggiofiorito*:
	$id_del_tag='13952';
	break;
	case *pollutri*:
	$id_del_tag='13953';
	break;
	case *pretoro*:
	$id_del_tag='13954';
	break;
	case *quadri*:
	$id_del_tag='13955';
	break;
	case *rapino*:
	$id_del_tag='13956';
	break;
	case *ripa teatina*:
	$id_del_tag='13957';
	break;
	case *rocca san giovanni*:
	$id_del_tag='13958';
	break;
	case *roccamontepiano*:
	$id_del_tag='13959';
	break;
	case *roccascalegna*:
	$id_del_tag='13960';
	break;
	case *roccaspinalveti*:
	$id_del_tag='13961';
	break;
	case *roio del sangro*:
	$id_del_tag='13962';
	break;
	case *rosello*:
	$id_del_tag='13963';
	break;
	case *san buono*:
	$id_del_tag='13964';
	break;
	case *san giovanni lipioni*:
	$id_del_tag='13965';
	break;
	case *san giovanni teatino*:
	$id_del_tag='13966';
	break;
	case *san martino sulla marrucina*:
	$id_del_tag='13967';
	break;
	case *san salvo*:
	$id_del_tag='13968';
	break;
	case *san vito chietino*:
	$id_del_tag='13969';
	break;
	case *santa maria imbaro*:
	$id_del_tag='13970';
	break;
	case *sant'eusanio del sangro*:
	$id_del_tag='13971';
	break;
	case *scerni*:
	$id_del_tag='13972';
	break;
	case *schiavi di abruzzo*:
	$id_del_tag='13973';
	break;
	case *taranta peligna*:
	$id_del_tag='13974';
	break;
	case *torino di sangro*:
	$id_del_tag='13975';
	break;
	case *tornareccio*:
	$id_del_tag='13976';
	break;
	case *torrebruna*:
	$id_del_tag='13977';
	break;
	case *torrevecchia teatina*:
	$id_del_tag='13978';
	break;
	case *torricella peligna*:
	$id_del_tag='13979';
	break;
	case *treglio*:
	$id_del_tag='13980';
	break;
	case *tufillo*:
	$id_del_tag='13981';
	break;
	case *vacri*:
	$id_del_tag='13982';
	break;
	case *villa santa maria*:
	$id_del_tag='13983';
	break;
	case *villalfonsina*:
	$id_del_tag='13984';
	break;
	case *villamagna*:
	$id_del_tag='13985';
	break;
	case *acquaviva collecroce*:
	$id_del_tag='13986';
	break;
	case *baranello*:
	$id_del_tag='13987';
	break;
	case *bojano*:
	$id_del_tag='13988';
	break;
	case *bonefro*:
	$id_del_tag='13989';
	break;
	case *busso*:
	$id_del_tag='13990';
	break;
	case *campochiaro*:
	$id_del_tag='13991';
	break;
	case *campodipietra*:
	$id_del_tag='13992';
	break;
	case *campolieto*:
	$id_del_tag='13993';
	break;
	case *campomarino*:
	$id_del_tag='13994';
	break;
	case *casacalenda*:
	$id_del_tag='13995';
	break;
	case *casalciprano*:
	$id_del_tag='13996';
	break;
	case *castelbottaccio*:
	$id_del_tag='13997';
	break;
	case *castellino del biferno*:
	$id_del_tag='13998';
	break;
	case *castelmauro*:
	$id_del_tag='13999';
	break;
	case *castropignano*:
	$id_del_tag='14000';
	break;
	case *cercemaggiore*:
	$id_del_tag='14001';
	break;
	case *cercepiccola*:
	$id_del_tag='14002';
	break;
	case *civitacampomarano*:
	$id_del_tag='14003';
	break;
	case *colle d'anchise*:
	$id_del_tag='14004';
	break;
	case *colletorto*:
	$id_del_tag='14005';
	break;
	case *duronia*:
	$id_del_tag='14006';
	break;
	case *ferrazzano*:
	$id_del_tag='14007';
	break;
	case *fossalto*:
	$id_del_tag='14008';
	break;
	case *gambatesa*:
	$id_del_tag='14009';
	break;
	case *gildone*:
	$id_del_tag='14010';
	break;
	case *guardialfiera*:
	$id_del_tag='14011';
	break;
	case *guardiaregia*:
	$id_del_tag='14012';
	break;
	case *guglionesi*:
	$id_del_tag='14013';
	break;
	case *jelsi*:
	$id_del_tag='14014';
	break;
	case *larino*:
	$id_del_tag='14015';
	break;
	case *limosano*:
	$id_del_tag='14016';
	break;
	case *lucito*:
	$id_del_tag='14017';
	break;
	case *lupara*:
	$id_del_tag='14018';
	break;
	case *macchia valfortore*:
	$id_del_tag='14019';
	break;
	case *mafalda*:
	$id_del_tag='14020';
	break;
	case *matrice*:
	$id_del_tag='14021';
	break;
	case *mirabello sannitico*:
	$id_del_tag='14022';
	break;
	case *molise*:
	$id_del_tag='14023';
	break;
	case *monacilioni*:
	$id_del_tag='14024';
	break;
	case *montagano*:
	$id_del_tag='14025';
	break;
	case *montecilfone*:
	$id_del_tag='14026';
	break;
	case *montefalcone nel sannio*:
	$id_del_tag='14027';
	break;
	case *montelongo*:
	$id_del_tag='14028';
	break;
	case *montemitro*:
	$id_del_tag='14029';
	break;
	case *montenero di bisaccia*:
	$id_del_tag='14030';
	break;
	case *montorio nei frentani*:
	$id_del_tag='14031';
	break;
	case *morrone del sannio*:
	$id_del_tag='14032';
	break;
	case *oratino*:
	$id_del_tag='14033';
	break;
	case *palata*:
	$id_del_tag='14034';
	break;
	case *petacciato*:
	$id_del_tag='14035';
	break;
	case *petrella tifernina*:
	$id_del_tag='14036';
	break;
	case *pietracatella*:
	$id_del_tag='14037';
	break;
	case *pietracupa*:
	$id_del_tag='14038';
	break;
	case *portocannone*:
	$id_del_tag='14039';
	break;
	case *provvidenti*:
	$id_del_tag='14040';
	break;
	case *riccia*:
	$id_del_tag='14041';
	break;
	case *ripabottoni*:
	$id_del_tag='14042';
	break;
	case *ripalimosani*:
	$id_del_tag='14043';
	break;
	case *roccavivara*:
	$id_del_tag='14044';
	break;
	case *rotello*:
	$id_del_tag='14045';
	break;
	case *salcito*:
	$id_del_tag='14046';
	break;
	case *san biase*:
	$id_del_tag='14047';
	break;
	case *san felice del molise*:
	$id_del_tag='14048';
	break;
	case *san giacomo degli schiavoni*:
	$id_del_tag='14049';
	break;
	case *san giovanni in galdo*:
	$id_del_tag='14050';
	break;
	case *san giuliano del sannio*:
	$id_del_tag='14051';
	break;
	case *san martino in pensilis*:
	$id_del_tag='14052';
	break;
	case *san massimo*:
	$id_del_tag='14053';
	break;
	case *san polo matese*:
	$id_del_tag='14054';
	break;
	case *santa croce di magliano*:
	$id_del_tag='14055';
	break;
	case *sant'angelo limosano*:
	$id_del_tag='14056';
	break;
	case *sant'elia a pianisi*:
	$id_del_tag='14057';
	break;
	case *sepino*:
	$id_del_tag='14058';
	break;
	case *spinete*:
	$id_del_tag='14059';
	break;
	case *tavenna*:
	$id_del_tag='14060';
	break;
	case *torella del sannio*:
	$id_del_tag='14061';
	break;
	case *toro*:
	$id_del_tag='14062';
	break;
	case *trivento*:
	$id_del_tag='14063';
	break;
	case *tufara*:
	$id_del_tag='14064';
	break;
	case *ururi*:
	$id_del_tag='14065';
	break;
	case *vinchiaturo*:
	$id_del_tag='14066';
	break;
	case *accadia*:
	$id_del_tag='14067';
	break;
	case *alberona*:
	$id_del_tag='14068';
	break;
	case *anzano di puglia*:
	$id_del_tag='14069';
	break;
	case *apricena*:
	$id_del_tag='14070';
	break;
	case *ascoli satriano*:
	$id_del_tag='14071';
	break;
	case *biccari*:
	$id_del_tag='14072';
	break;
	case *bovino*:
	$id_del_tag='14073';
	break;
	case *candela*:
	$id_del_tag='14074';
	break;
	case *carapelle*:
	$id_del_tag='14075';
	break;
	case *carlantino*:
	$id_del_tag='14076';
	break;
	case *carpino*:
	$id_del_tag='14077';
	break;
	case *casalnuovo monterotaro*:
	$id_del_tag='14078';
	break;
	case *casalvecchio di puglia*:
	$id_del_tag='14079';
	break;
	case *castelluccio dei sauri*:
	$id_del_tag='14080';
	break;
	case *castelluccio valmaggiore*:
	$id_del_tag='14081';
	break;
	case *castelnuovo della daunia*:
	$id_del_tag='14082';
	break;
	case *celenza valfortore*:
	$id_del_tag='14083';
	break;
	case *celle di san vito*:
	$id_del_tag='14084';
	break;
	case *cerignola*:
	$id_del_tag='14085';
	break;
	case *chieuti*:
	$id_del_tag='14086';
	break;
	case *deliceto*:
	$id_del_tag='14087';
	break;
	case *faeto*:
	$id_del_tag='14088';
	break;
	case *ischitella*:
	$id_del_tag='14089';
	break;
	case *isole tremiti*:
	$id_del_tag='14090';
	break;
	case *margherita di savoia*:
	$id_del_tag='14091';
	break;
	case *mattinata*:
	$id_del_tag='14092';
	break;
	case *monte sant'angelo*:
	$id_del_tag='14093';
	break;
	case *monteleone di puglia*:
	$id_del_tag='14094';
	break;
	case *motta montecorvino*:
	$id_del_tag='14095';
	break;
	case *ordona*:
	$id_del_tag='14096';
	break;
	case *orsara di puglia*:
	$id_del_tag='14097';
	break;
	case *orta nova*:
	$id_del_tag='14098';
	break;
	case *panni*:
	$id_del_tag='14099';
	break;
	case *peschici*:
	$id_del_tag='14100';
	break;
	case *pietramontecorvino*:
	$id_del_tag='14101';
	break;
	case *poggio imperiale*:
	$id_del_tag='14102';
	break;
	case *rocchetta sant'antonio*:
	$id_del_tag='14103';
	break;
	case *rodi garganico*:
	$id_del_tag='14104';
	break;
	case *roseto valfortore*:
	$id_del_tag='14105';
	break;
	case *san marco la catola*:
	$id_del_tag='14106';
	break;
	case *san paolo di civitate*:
	$id_del_tag='14107';
	break;
	case *san severo*:
	$id_del_tag='14108';
	break;
	case *sant'agata di puglia*:
	$id_del_tag='14109';
	break;
	case *serracapriola*:
	$id_del_tag='14110';
	break;
	case *stornara*:
	$id_del_tag='14111';
	break;
	case *stornarella*:
	$id_del_tag='14112';
	break;
	case *torremaggiore*:
	$id_del_tag='14113';
	break;
	case *trinitapoli*:
	$id_del_tag='14114';
	break;
	case *troia*:
	$id_del_tag='14115';
	break;
	case *vico del gargano*:
	$id_del_tag='14116';
	break;
	case *vieste*:
	$id_del_tag='14117';
	break;
	case *volturara appula*:
	$id_del_tag='14118';
	break;
	case *volturino*:
	$id_del_tag='14119';
	break;
	case *zapponeta*:
	$id_del_tag='14120';
	break;
	case *acquaviva delle fonti*:
	$id_del_tag='14121';
	break;
	case *adelfia*:
	$id_del_tag='14122';
	break;
	case *alberobello*:
	$id_del_tag='14123';
	break;
	case *altamura*:
	$id_del_tag='14124';
	break;
	case *andria*:
	$id_del_tag='14125';
	break;
	case *binetto*:
	$id_del_tag='14126';
	break;
	case *bitetto*:
	$id_del_tag='14127';
	break;
	case *bitonto*:
	$id_del_tag='14128';
	break;
	case *bitritto*:
	$id_del_tag='14129';
	break;
	case *canosa di puglia*:
	$id_del_tag='14130';
	break;
	case *capurso*:
	$id_del_tag='14131';
	break;
	case *casamassima*:
	$id_del_tag='14132';
	break;
	case *cassano delle murge*:
	$id_del_tag='14133';
	break;
	case *castellana grotte*:
	$id_del_tag='14134';
	break;
	case *cellamare*:
	$id_del_tag='14135';
	break;
	case *conversano*:
	$id_del_tag='14136';
	break;
	case *corato*:
	$id_del_tag='14137';
	break;
	case *gioia del colle*:
	$id_del_tag='14138';
	break;
	case *giovinazzo*:
	$id_del_tag='14139';
	break;
	case *grumo appula*:
	$id_del_tag='14140';
	break;
	case *locorotondo*:
	$id_del_tag='14141';
	break;
	case *minervino murge*:
	$id_del_tag='14142';
	break;
	case *modugno*:
	$id_del_tag='14143';
	break;
	case *mola di bari*:
	$id_del_tag='14144';
	break;
	case *molfetta*:
	$id_del_tag='14145';
	break;
	case *noci*:
	$id_del_tag='14146';
	break;
	case *noicattaro*:
	$id_del_tag='14147';
	break;
	case *palo del colle*:
	$id_del_tag='14148';
	break;
	case *poggiorsini*:
	$id_del_tag='14149';
	break;
	case *polignano a mare*:
	$id_del_tag='14150';
	break;
	case *putignano*:
	$id_del_tag='14151';
	break;
	case *rutigliano*:
	$id_del_tag='14152';
	break;
	case *sammichele di bari*:
	$id_del_tag='14153';
	break;
	case *sannicandro di bari*:
	$id_del_tag='14154';
	break;
	case *santeramo in colle*:
	$id_del_tag='14155';
	break;
	case *terlizzi*:
	$id_del_tag='14156';
	break;
	case *toritto*:
	$id_del_tag='14157';
	break;
	case *triggiano*:
	$id_del_tag='14158';
	break;
	case *turi*:
	$id_del_tag='14159';
	break;
	case *avetrana*:
	$id_del_tag='14160';
	break;
	case *carosino*:
	$id_del_tag='14161';
	break;
	case *crispiano*:
	$id_del_tag='14162';
	break;
	case *faggiano*:
	$id_del_tag='14163';
	break;
	case *fragagnano*:
	$id_del_tag='14164';
	break;
	case *grottaglie*:
	$id_del_tag='14165';
	break;
	case *laterza*:
	$id_del_tag='14166';
	break;
	case *leporano*:
	$id_del_tag='14167';
	break;
	case *lizzano*:
	$id_del_tag='14168';
	break;
	case *manduria*:
	$id_del_tag='14169';
	break;
	case *maruggio*:
	$id_del_tag='14170';
	break;
	case *monteiasi*:
	$id_del_tag='14171';
	break;
	case *montemesola*:
	$id_del_tag='14172';
	break;
	case *monteparano*:
	$id_del_tag='14173';
	break;
	case *pulsano*:
	$id_del_tag='14174';
	break;
	case *roccaforzata*:
	$id_del_tag='14175';
	break;
	case *san giorgio ionico*:
	$id_del_tag='14176';
	break;
	case *san marzano di san giuseppe*:
	$id_del_tag='14177';
	break;
	case *sava*:
	$id_del_tag='14178';
	break;
	case *statte*:
	$id_del_tag='14179';
	break;
	case *torricella*:
	$id_del_tag='14180';
	break;
	case *carovigno*:
	$id_del_tag='14181';
	break;
	case *ceglie messapica*:
	$id_del_tag='14182';
	break;
	case *cellino san marco*:
	$id_del_tag='14183';
	break;
	case *cisternino*:
	$id_del_tag='14184';
	break;
	case *erchie*:
	$id_del_tag='14185';
	break;
	case *francavilla fontana*:
	$id_del_tag='14186';
	break;
	case *latiano*:
	$id_del_tag='14187';
	break;
	case *mesagne*:
	$id_del_tag='14188';
	break;
	case *san donaci*:
	$id_del_tag='14189';
	break;
	case *san michele salentino*:
	$id_del_tag='14190';
	break;
	case *san pancrazio salentino*:
	$id_del_tag='14191';
	break;
	case *san pietro vernotico*:
	$id_del_tag='14192';
	break;
	case *san vito dei normanni*:
	$id_del_tag='14193';
	break;
	case *torchiarolo*:
	$id_del_tag='14194';
	break;
	case *torre santa susanna*:
	$id_del_tag='14195';
	break;
	case *villa castelli*:
	$id_del_tag='14196';
	break;
	case *acquarica del capo*:
	$id_del_tag='14197';
	break;
	case *alessano*:
	$id_del_tag='14198';
	break;
	case *alezio*:
	$id_del_tag='14199';
	break;
	case *alliste*:
	$id_del_tag='14200';
	break;
	case *andrano*:
	$id_del_tag='14201';
	break;
	case *aradeo*:
	$id_del_tag='14202';
	break;
	case *arnesano*:
	$id_del_tag='14203';
	break;
	case *bagnolo del salento*:
	$id_del_tag='14204';
	break;
	case *botrugno*:
	$id_del_tag='14205';
	break;
	case *calimera*:
	$id_del_tag='14206';
	break;
	case *campi salentina*:
	$id_del_tag='14207';
	break;
	case *cannole*:
	$id_del_tag='14208';
	break;
	case *caprarica di lecce*:
	$id_del_tag='14209';
	break;
	case *carmiano*:
	$id_del_tag='14210';
	break;
	case *carpignano salentino*:
	$id_del_tag='14211';
	break;
	case *casarano*:
	$id_del_tag='14212';
	break;
	case *castri di lecce*:
	$id_del_tag='14213';
	break;
	case *castrignano de' greci*:
	$id_del_tag='14214';
	break;
	case *cavallino*:
	$id_del_tag='14215';
	break;
	case *collepasso*:
	$id_del_tag='14216';
	break;
	case *copertino*:
	$id_del_tag='14217';
	break;
	case *corsano*:
	$id_del_tag='14218';
	break;
	case *cursi*:
	$id_del_tag='14219';
	break;
	case *cutrofiano*:
	$id_del_tag='14220';
	break;
	case *diso*:
	$id_del_tag='14221';
	break;
	case *gagliano del capo*:
	$id_del_tag='14222';
	break;
	case *galatina*:
	$id_del_tag='14223';
	break;
	case *galatone*:
	$id_del_tag='14224';
	break;
	case *giuggianello*:
	$id_del_tag='14225';
	break;
	case *giurdignano*:
	$id_del_tag='14226';
	break;
	case *guagnano*:
	$id_del_tag='14227';
	break;
	case *lequile*:
	$id_del_tag='14228';
	break;
	case *leverano*:
	$id_del_tag='14229';
	break;
	case *lizzanello*:
	$id_del_tag='14230';
	break;
	case *maglie*:
	$id_del_tag='14231';
	break;
	case *martano*:
	$id_del_tag='14232';
	break;
	case *martignano*:
	$id_del_tag='14233';
	break;
	case *matino*:
	$id_del_tag='14234';
	break;
	case *melendugno*:
	$id_del_tag='14235';
	break;
	case *melissano*:
	$id_del_tag='14236';
	break;
	case *melpignano*:
	$id_del_tag='14237';
	break;
	case *miggiano*:
	$id_del_tag='14238';
	break;
	case *minervino di lecce*:
	$id_del_tag='14239';
	break;
	case *monteroni di lecce*:
	$id_del_tag='14240';
	break;
	case *montesano salentino*:
	$id_del_tag='14241';
	break;
	case *morciano di leuca*:
	$id_del_tag='14242';
	break;
	case *muro leccese*:
	$id_del_tag='14243';
	break;
	case *neviano*:
	$id_del_tag='14244';
	break;
	case *nociglia*:
	$id_del_tag='14245';
	break;
	case *novoli*:
	$id_del_tag='14246';
	break;
	case *ortelle*:
	$id_del_tag='14247';
	break;
	case *otranto*:
	$id_del_tag='14248';
	break;
	case *palmariggi*:
	$id_del_tag='14249';
	break;
	case *parabita*:
	$id_del_tag='14250';
	break;
	case *patù*:
	$id_del_tag='14251';
	break;
	case *poggiardo*:
	$id_del_tag='14252';
	break;
	case *porto cesareo*:
	$id_del_tag='14253';
	break;
	case *presicce*:
	$id_del_tag='14254';
	break;
	case *racale*:
	$id_del_tag='14255';
	break;
	case *salice salentino*:
	$id_del_tag='14256';
	break;
	case *salve*:
	$id_del_tag='14257';
	break;
	case *san cassiano*:
	$id_del_tag='14258';
	break;
	case *san cesario di lecce*:
	$id_del_tag='14259';
	break;
	case *san donato di lecce*:
	$id_del_tag='14260';
	break;
	case *san pietro in lama*:
	$id_del_tag='14261';
	break;
	case *sanarica*:
	$id_del_tag='14262';
	break;
	case *sannicola*:
	$id_del_tag='14263';
	break;
	case *scorrano*:
	$id_del_tag='14264';
	break;
	case *seclì*:
	$id_del_tag='14265';
	break;
	case *sogliano cavour*:
	$id_del_tag='14266';
	break;
	case *soleto*:
	$id_del_tag='14267';
	break;
	case *specchia*:
	$id_del_tag='14268';
	break;
	case *spongano*:
	$id_del_tag='14269';
	break;
	case *squinzano*:
	$id_del_tag='14270';
	break;
	case *sternatia*:
	$id_del_tag='14271';
	break;
	case *supersano*:
	$id_del_tag='14272';
	break;
	case *surano*:
	$id_del_tag='14273';
	break;
	case *surbo*:
	$id_del_tag='14274';
	break;
	case *taurisano*:
	$id_del_tag='14275';
	break;
	case *taviano*:
	$id_del_tag='14276';
	break;
	case *tiggiano*:
	$id_del_tag='14277';
	break;
	case *trepuzzi*:
	$id_del_tag='14278';
	break;
	case *tuglie*:
	$id_del_tag='14279';
	break;
	case *uggiano la chiesa*:
	$id_del_tag='14280';
	break;
	case *veglie*:
	$id_del_tag='14281';
	break;
	case *vernole*:
	$id_del_tag='14282';
	break;
	case *zollino*:
	$id_del_tag='14283';
	break;
	case *abriola*:
	$id_del_tag='14284';
	break;
	case *acerenza*:
	$id_del_tag='14285';
	break;
	case *albano di lucania*:
	$id_del_tag='14286';
	break;
	case *anzi*:
	$id_del_tag='14287';
	break;
	case *armento*:
	$id_del_tag='14288';
	break;
	case *atella*:
	$id_del_tag='14289';
	break;
	case *avigliano*:
	$id_del_tag='14290';
	break;
	case *balvano*:
	$id_del_tag='14291';
	break;
	case *banzi*:
	$id_del_tag='14292';
	break;
	case *baragiano*:
	$id_del_tag='14293';
	break;
	case *barile*:
	$id_del_tag='14294';
	break;
	case *brienza*:
	$id_del_tag='14295';
	break;
	case *brindisi montagna*:
	$id_del_tag='14296';
	break;
	case *calvera*:
	$id_del_tag='14297';
	break;
	case *campomaggiore*:
	$id_del_tag='14298';
	break;
	case *cancellara*:
	$id_del_tag='14299';
	break;
	case *carbone*:
	$id_del_tag='14300';
	break;
	case *castelgrande*:
	$id_del_tag='14301';
	break;
	case *castelluccio inferiore*:
	$id_del_tag='14302';
	break;
	case *castelluccio superiore*:
	$id_del_tag='14303';
	break;
	case *castelmezzano*:
	$id_del_tag='14304';
	break;
	case *castelsaraceno*:
	$id_del_tag='14305';
	break;
	case *castronuovo di sant'andrea*:
	$id_del_tag='14306';
	break;
	case *cersosimo*:
	$id_del_tag='14307';
	break;
	case *chiaromonte*:
	$id_del_tag='14308';
	break;
	case *corleto perticara*:
	$id_del_tag='14309';
	break;
	case *episcopia*:
	$id_del_tag='14310';
	break;
	case *fardella*:
	$id_del_tag='14311';
	break;
	case *forenza*:
	$id_del_tag='14312';
	break;
	case *francavilla in sinni*:
	$id_del_tag='14313';
	break;
	case *gallicchio*:
	$id_del_tag='14314';
	break;
	case *genzano di lucania*:
	$id_del_tag='14315';
	break;
	case *ginestra*:
	$id_del_tag='14316';
	break;
	case *grumento nova*:
	$id_del_tag='14317';
	break;
	case *guardia perticara*:
	$id_del_tag='14318';
	break;
	case *latronico*:
	$id_del_tag='14319';
	break;
	case *laurenzana*:
	$id_del_tag='14320';
	break;
	case *lavello*:
	$id_del_tag='14321';
	break;
	case *marsico nuovo*:
	$id_del_tag='14322';
	break;
	case *marsicovetere*:
	$id_del_tag='14323';
	break;
	case *maschito*:
	$id_del_tag='14324';
	break;
	case *missanello*:
	$id_del_tag='14325';
	break;
	case *moliterno*:
	$id_del_tag='14326';
	break;
	case *montemilone*:
	$id_del_tag='14327';
	break;
	case *montemurro*:
	$id_del_tag='14328';
	break;
	case *muro lucano*:
	$id_del_tag='14329';
	break;
	case *nemoli*:
	$id_del_tag='14330';
	break;
	case *noepoli*:
	$id_del_tag='14331';
	break;
	case *oppido lucano*:
	$id_del_tag='14332';
	break;
	case *palazzo san gervasio*:
	$id_del_tag='14333';
	break;
	case *paterno*:
	$id_del_tag='14334';
	break;
	case *pescopagano*:
	$id_del_tag='14335';
	break;
	case *pietragalla*:
	$id_del_tag='14336';
	break;
	case *pietrapertosa*:
	$id_del_tag='14337';
	break;
	case *pignola*:
	$id_del_tag='14338';
	break;
	case *rapolla*:
	$id_del_tag='14339';
	break;
	case *rapone*:
	$id_del_tag='14340';
	break;
	case *ripacandida*:
	$id_del_tag='14341';
	break;
	case *rivello*:
	$id_del_tag='14342';
	break;
	case *roccanova*:
	$id_del_tag='14343';
	break;
	case *rotonda*:
	$id_del_tag='14344';
	break;
	case *ruoti*:
	$id_del_tag='14345';
	break;
	case *ruvo del monte*:
	$id_del_tag='14346';
	break;
	case *san chirico nuovo*:
	$id_del_tag='14347';
	break;
	case *san chirico raparo*:
	$id_del_tag='14348';
	break;
	case *san costantino albanese*:
	$id_del_tag='14349';
	break;
	case *san fele*:
	$id_del_tag='14350';
	break;
	case *san martino d'agri*:
	$id_del_tag='14351';
	break;
	case *san paolo albanese*:
	$id_del_tag='14352';
	break;
	case *san severino lucano*:
	$id_del_tag='14353';
	break;
	case *sant'angelo le fratte*:
	$id_del_tag='14354';
	break;
	case *sant'arcangelo*:
	$id_del_tag='14355';
	break;
	case *sarconi*:
	$id_del_tag='14356';
	break;
	case *sasso di castalda*:
	$id_del_tag='14357';
	break;
	case *satriano di lucania*:
	$id_del_tag='14358';
	break;
	case *savoia di lucania*:
	$id_del_tag='14359';
	break;
	case *spinoso*:
	$id_del_tag='14360';
	break;
	case *teana*:
	$id_del_tag='14361';
	break;
	case *terranova di pollino*:
	$id_del_tag='14362';
	break;
	case *tito*:
	$id_del_tag='14363';
	break;
	case *tolve*:
	$id_del_tag='14364';
	break;
	case *tramutola*:
	$id_del_tag='14365';
	break;
	case *trecchina*:
	$id_del_tag='14366';
	break;
	case *trivigno*:
	$id_del_tag='14367';
	break;
	case *vaglio basilicata*:
	$id_del_tag='14368';
	break;
	case *venosa*:
	$id_del_tag='14369';
	break;
	case *vietri di potenza*:
	$id_del_tag='14370';
	break;
	case *viggianello*:
	$id_del_tag='14371';
	break;
	case *viggiano*:
	$id_del_tag='14372';
	break;
	case *accettura*:
	$id_del_tag='14373';
	break;
	case *aliano*:
	$id_del_tag='14374';
	break;
	case *bernalda*:
	$id_del_tag='14375';
	break;
	case *calciano*:
	$id_del_tag='14376';
	break;
	case *cirigliano*:
	$id_del_tag='14377';
	break;
	case *colobraro*:
	$id_del_tag='14378';
	break;
	case *craco*:
	$id_del_tag='14379';
	break;
	case *garaguso*:
	$id_del_tag='14380';
	break;
	case *gorgoglione*:
	$id_del_tag='14381';
	break;
	case *grassano*:
	$id_del_tag='14382';
	break;
	case *grottole*:
	$id_del_tag='14383';
	break;
	case *irsina*:
	$id_del_tag='14384';
	break;
	case *miglionico*:
	$id_del_tag='14385';
	break;
	case *montalbano jonico*:
	$id_del_tag='14386';
	break;
	case *montescaglioso*:
	$id_del_tag='14387';
	break;
	case *oliveto lucano*:
	$id_del_tag='14388';
	break;
	case *pomarico*:
	$id_del_tag='14389';
	break;
	case *salandra*:
	$id_del_tag='14390';
	break;
	case *san giorgio lucano*:
	$id_del_tag='14391';
	break;
	case *san mauro forte*:
	$id_del_tag='14392';
	break;
	case *stigliano*:
	$id_del_tag='14393';
	break;
	case *tricarico*:
	$id_del_tag='14394';
	break;
	case *valsinni*:
	$id_del_tag='14395';
	break;
	case *acquaformosa*:
	$id_del_tag='14396';
	break;
	case *acquappesa*:
	$id_del_tag='14397';
	break;
	case *acri*:
	$id_del_tag='14398';
	break;
	case *aiello calabro*:
	$id_del_tag='14399';
	break;
	case *aieta*:
	$id_del_tag='14400';
	break;
	case *albidona*:
	$id_del_tag='14401';
	break;
	case *alessandria del carretto*:
	$id_del_tag='14402';
	break;
	case *altilia*:
	$id_del_tag='14403';
	break;
	case *altomonte*:
	$id_del_tag='14404';
	break;
	case *amantea*:
	$id_del_tag='14405';
	break;
	case *aprigliano*:
	$id_del_tag='14406';
	break;
	case *belmonte calabro*:
	$id_del_tag='14407';
	break;
	case *belsito*:
	$id_del_tag='14408';
	break;
	case *belvedere marittimo*:
	$id_del_tag='14409';
	break;
	case *bianchi*:
	$id_del_tag='14410';
	break;
	case *bisignano*:
	$id_del_tag='14411';
	break;
	case *bocchigliero*:
	$id_del_tag='14412';
	break;
	case *bonifati*:
	$id_del_tag='14413';
	break;
	case *buonvicino*:
	$id_del_tag='14414';
	break;
	case *calopezzati*:
	$id_del_tag='14415';
	break;
	case *caloveto*:
	$id_del_tag='14416';
	break;
	case *cariati*:
	$id_del_tag='14417';
	break;
	case *carolei*:
	$id_del_tag='14418';
	break;
	case *carpanzano*:
	$id_del_tag='14419';
	break;
	case *casole bruzio*:
	$id_del_tag='14420';
	break;
	case *castiglione cosentino*:
	$id_del_tag='14421';
	break;
	case *castrolibero*:
	$id_del_tag='14422';
	break;
	case *castroregio*:
	$id_del_tag='14423';
	break;
	case *castrovillari*:
	$id_del_tag='14424';
	break;
	case *celico*:
	$id_del_tag='14425';
	break;
	case *cellara*:
	$id_del_tag='14426';
	break;
	case *cerchiara di calabria*:
	$id_del_tag='14427';
	break;
	case *cervicati*:
	$id_del_tag='14428';
	break;
	case *cerzeto*:
	$id_del_tag='14429';
	break;
	case *cetraro*:
	$id_del_tag='14430';
	break;
	case *civita*:
	$id_del_tag='14431';
	break;
	case *cleto*:
	$id_del_tag='14432';
	break;
	case *colosimi*:
	$id_del_tag='14433';
	break;
	case *cropalati*:
	$id_del_tag='14434';
	break;
	case *crosia*:
	$id_del_tag='14435';
	break;
	case *diamante*:
	$id_del_tag='14436';
	break;
	case *dipignano*:
	$id_del_tag='14437';
	break;
	case *domanico*:
	$id_del_tag='14438';
	break;
	case *fagnano castello*:
	$id_del_tag='14439';
	break;
	case *falconara albanese*:
	$id_del_tag='14440';
	break;
	case *figline vegliaturo*:
	$id_del_tag='14441';
	break;
	case *firmo*:
	$id_del_tag='14442';
	break;
	case *fiumefreddo bruzio*:
	$id_del_tag='14443';
	break;
	case *francavilla marittima*:
	$id_del_tag='14444';
	break;
	case *frascineto*:
	$id_del_tag='14445';
	break;
	case *fuscaldo*:
	$id_del_tag='14446';
	break;
	case *grimaldi*:
	$id_del_tag='14447';
	break;
	case *grisolia*:
	$id_del_tag='14448';
	break;
	case *guardia piemontese*:
	$id_del_tag='14449';
	break;
	case *lago*:
	$id_del_tag='14450';
	break;
	case *laino castello*:
	$id_del_tag='14451';
	break;
	case *lappano*:
	$id_del_tag='14452';
	break;
	case *lattarico*:
	$id_del_tag='14453';
	break;
	case *longobardi*:
	$id_del_tag='14454';
	break;
	case *longobucco*:
	$id_del_tag='14455';
	break;
	case *lungro*:
	$id_del_tag='14456';
	break;
	case *luzzi*:
	$id_del_tag='14457';
	break;
	case *maierà*:
	$id_del_tag='14458';
	break;
	case *malito*:
	$id_del_tag='14459';
	break;
	case *malvito*:
	$id_del_tag='14460';
	break;
	case *mandatoriccio*:
	$id_del_tag='14461';
	break;
	case *mangone*:
	$id_del_tag='14462';
	break;
	case *marano marchesato*:
	$id_del_tag='14463';
	break;
	case *marano principato*:
	$id_del_tag='14464';
	break;
	case *marzi*:
	$id_del_tag='14465';
	break;
	case *mendicino*:
	$id_del_tag='14466';
	break;
	case *mongrassano*:
	$id_del_tag='14467';
	break;
	case *montalto uffugo*:
	$id_del_tag='14468';
	break;
	case *montegiordano*:
	$id_del_tag='14469';
	break;
	case *morano calabro*:
	$id_del_tag='14470';
	break;
	case *mottafollone*:
	$id_del_tag='14471';
	break;
	case *nocara*:
	$id_del_tag='14472';
	break;
	case *oriolo*:
	$id_del_tag='14473';
	break;
	case *orsomarso*:
	$id_del_tag='14474';
	break;
	case *paludi*:
	$id_del_tag='14475';
	break;
	case *panettieri*:
	$id_del_tag='14476';
	break;
	case *parenti*:
	$id_del_tag='14477';
	break;
	case *paterno calabro*:
	$id_del_tag='14478';
	break;
	case *pedace*:
	$id_del_tag='14479';
	break;
	case *pedivigliano*:
	$id_del_tag='14480';
	break;
	case *piane crati*:
	$id_del_tag='14481';
	break;
	case *pietrafitta*:
	$id_del_tag='14482';
	break;
	case *pietrapaola*:
	$id_del_tag='14483';
	break;
	case *plataci*:
	$id_del_tag='14484';
	break;
	case *rende*:
	$id_del_tag='14485';
	break;
	case *rocca imperiale*:
	$id_del_tag='14486';
	break;
	case *roggiano gravina*:
	$id_del_tag='14487';
	break;
	case *rogliano*:
	$id_del_tag='14488';
	break;
	case *rose*:
	$id_del_tag='14489';
	break;
	case *roseto capo spulico*:
	$id_del_tag='14490';
	break;
	case *rota greca*:
	$id_del_tag='14491';
	break;
	case *rovito*:
	$id_del_tag='14492';
	break;
	case *san basile*:
	$id_del_tag='14493';
	break;
	case *san benedetto ullano*:
	$id_del_tag='14494';
	break;
	case *san cosmo albanese*:
	$id_del_tag='14495';
	break;
	case *san demetrio corone*:
	$id_del_tag='14496';
	break;
	case *san donato di ninea*:
	$id_del_tag='14497';
	break;
	case *san fili*:
	$id_del_tag='14498';
	break;
	case *san giorgio albanese*:
	$id_del_tag='14499';
	break;
	case *san giovanni in fiore*:
	$id_del_tag='14500';
	break;
	case *san lorenzo bellizzi*:
	$id_del_tag='14501';
	break;
	case *san lorenzo del vallo*:
	$id_del_tag='14502';
	break;
	case *san lucido*:
	$id_del_tag='14503';
	break;
	case *san marco argentano*:
	$id_del_tag='14504';
	break;
	case *san martino di finita*:
	$id_del_tag='14505';
	break;
	case *san nicola arcella*:
	$id_del_tag='14506';
	break;
	case *san pietro in amantea*:
	$id_del_tag='14507';
	break;
	case *san pietro in guarano*:
	$id_del_tag='14508';
	break;
	case *san sosti*:
	$id_del_tag='14509';
	break;
	case *san vincenzo la costa*:
	$id_del_tag='14510';
	break;
	case *sangineto*:
	$id_del_tag='14511';
	break;
	case *santa caterina albanese*:
	$id_del_tag='14512';
	break;
	case *santa domenica talao*:
	$id_del_tag='14513';
	break;
	case *santa maria del cedro*:
	$id_del_tag='14514';
	break;
	case *santa sofia d'epiro*:
	$id_del_tag='14515';
	break;
	case *sant'agata di esaro*:
	$id_del_tag='14516';
	break;
	case *santo stefano di rogliano*:
	$id_del_tag='14517';
	break;
	case *saracena*:
	$id_del_tag='14518';
	break;
	case *scala coeli*:
	$id_del_tag='14519';
	break;
	case *scalea*:
	$id_del_tag='14520';
	break;
	case *scigliano*:
	$id_del_tag='14521';
	break;
	case *serra pedace*:
	$id_del_tag='14522';
	break;
	case *spezzano albanese*:
	$id_del_tag='14523';
	break;
	case *spezzano della sila*:
	$id_del_tag='14524';
	break;
	case *spezzano piccolo*:
	$id_del_tag='14525';
	break;
	case *tarsia*:
	$id_del_tag='14526';
	break;
	case *terranova da sibari*:
	$id_del_tag='14527';
	break;
	case *terravecchia*:
	$id_del_tag='14528';
	break;
	case *torano castello*:
	$id_del_tag='14529';
	break;
	case *tortora*:
	$id_del_tag='14530';
	break;
	case *trebisacce*:
	$id_del_tag='14531';
	break;
	case *trenta*:
	$id_del_tag='14532';
	break;
	case *vaccarizzo albanese*:
	$id_del_tag='14533';
	break;
	case *verbicaro*:
	$id_del_tag='14534';
	break;
	case *villapiana*:
	$id_del_tag='14535';
	break;
	case *zumpano*:
	$id_del_tag='14536';
	break;
	case *albi*:
	$id_del_tag='14537';
	break;
	case *amaroni*:
	$id_del_tag='14538';
	break;
	case *amato*:
	$id_del_tag='14539';
	break;
	case *andali*:
	$id_del_tag='14540';
	break;
	case *argusto*:
	$id_del_tag='14541';
	break;
	case *badolato*:
	$id_del_tag='14542';
	break;
	case *belcastro*:
	$id_del_tag='14543';
	break;
	case *borgia*:
	$id_del_tag='14544';
	break;
	case *botricello*:
	$id_del_tag='14545';
	break;
	case *caraffa di catanzaro*:
	$id_del_tag='14546';
	break;
	case *cardinale*:
	$id_del_tag='14547';
	break;
	case *carlopoli*:
	$id_del_tag='14548';
	break;
	case *cenadi*:
	$id_del_tag='14549';
	break;
	case *centrache*:
	$id_del_tag='14550';
	break;
	case *cerva*:
	$id_del_tag='14551';
	break;
	case *chiaravalle centrale*:
	$id_del_tag='14552';
	break;
	case *cicala*:
	$id_del_tag='14553';
	break;
	case *conflenti*:
	$id_del_tag='14554';
	break;
	case *cortale*:
	$id_del_tag='14555';
	break;
	case *cropani*:
	$id_del_tag='14556';
	break;
	case *curinga*:
	$id_del_tag='14557';
	break;
	case *davoli*:
	$id_del_tag='14558';
	break;
	case *decollatura*:
	$id_del_tag='14559';
	break;
	case *falerna*:
	$id_del_tag='14560';
	break;
	case *feroleto antico*:
	$id_del_tag='14561';
	break;
	case *fossato serralta*:
	$id_del_tag='14562';
	break;
	case *gagliato*:
	$id_del_tag='14563';
	break;
	case *gasperina*:
	$id_del_tag='14564';
	break;
	case *gimigliano*:
	$id_del_tag='14565';
	break;
	case *girifalco*:
	$id_del_tag='14566';
	break;
	case *gizzeria*:
	$id_del_tag='14567';
	break;
	case *guardavalle*:
	$id_del_tag='14568';
	break;
	case *isca sullo ionio*:
	$id_del_tag='14569';
	break;
	case *jacurso*:
	$id_del_tag='14570';
	break;
	case *magisano*:
	$id_del_tag='14571';
	break;
	case *maida*:
	$id_del_tag='14572';
	break;
	case *marcedusa*:
	$id_del_tag='14573';
	break;
	case *marcellinara*:
	$id_del_tag='14574';
	break;
	case *martirano*:
	$id_del_tag='14575';
	break;
	case *martirano lombardo*:
	$id_del_tag='14576';
	break;
	case *miglierina*:
	$id_del_tag='14577';
	break;
	case *montauro*:
	$id_del_tag='14578';
	break;
	case *montepaone*:
	$id_del_tag='14579';
	break;
	case *motta santa lucia*:
	$id_del_tag='14580';
	break;
	case *nocera terinese*:
	$id_del_tag='14581';
	break;
	case *olivadi*:
	$id_del_tag='14582';
	break;
	case *palermiti*:
	$id_del_tag='14583';
	break;
	case *pentone*:
	$id_del_tag='14584';
	break;
	case *petrizzi*:
	$id_del_tag='14585';
	break;
	case *petronà*:
	$id_del_tag='14586';
	break;
	case *pianopoli*:
	$id_del_tag='14587';
	break;
	case *platania*:
	$id_del_tag='14588';
	break;
	case *san floro*:
	$id_del_tag='14589';
	break;
	case *san mango d'aquino*:
	$id_del_tag='14590';
	break;
	case *san pietro a maida*:
	$id_del_tag='14591';
	break;
	case *san pietro apostolo*:
	$id_del_tag='14592';
	break;
	case *san sostene*:
	$id_del_tag='14593';
	break;
	case *san vito sullo ionio*:
	$id_del_tag='14594';
	break;
	case *santa caterina dello ionio*:
	$id_del_tag='14595';
	break;
	case *sant'andrea apostolo dello ionio*:
	$id_del_tag='14596';
	break;
	case *satriano*:
	$id_del_tag='14597';
	break;
	case *sellia*:
	$id_del_tag='14598';
	break;
	case *sellia marina*:
	$id_del_tag='14599';
	break;
	case *serrastretta*:
	$id_del_tag='14600';
	break;
	case *sersale*:
	$id_del_tag='14601';
	break;
	case *settingiano*:
	$id_del_tag='14602';
	break;
	case *simeri crichi*:
	$id_del_tag='14603';
	break;
	case *sorbo san basile*:
	$id_del_tag='14604';
	break;
	case *soverato*:
	$id_del_tag='14605';
	break;
	case *soveria mannelli*:
	$id_del_tag='14606';
	break;
	case *soveria simeri*:
	$id_del_tag='14607';
	break;
	case *squillace*:
	$id_del_tag='14608';
	break;
	case *stalettì*:
	$id_del_tag='14609';
	break;
	case *taverna*:
	$id_del_tag='14610';
	break;
	case *tiriolo*:
	$id_del_tag='14611';
	break;
	case *torre di ruggiero*:
	$id_del_tag='14612';
	break;
	case *vallefiorita*:
	$id_del_tag='14613';
	break;
	case *zagarise*:
	$id_del_tag='14614';
	break;
	case *africo*:
	$id_del_tag='14615';
	break;
	case *agnana calabra*:
	$id_del_tag='14616';
	break;
	case *anoia*:
	$id_del_tag='14617';
	break;
	case *antonimina*:
	$id_del_tag='14618';
	break;
	case *bagaladi*:
	$id_del_tag='14619';
	break;
	case *benestare*:
	$id_del_tag='14620';
	break;
	case *bianco*:
	$id_del_tag='14621';
	break;
	case *bivongi*:
	$id_del_tag='14622';
	break;
	case *bova*:
	$id_del_tag='14623';
	break;
	case *bova marina*:
	$id_del_tag='14624';
	break;
	case *bovalino*:
	$id_del_tag='14625';
	break;
	case *brancaleone*:
	$id_del_tag='14626';
	break;
	case *bruzzano zeffirio*:
	$id_del_tag='14627';
	break;
	case *calanna*:
	$id_del_tag='14628';
	break;
	case *camini*:
	$id_del_tag='14629';
	break;
	case *campo calabro*:
	$id_del_tag='14630';
	break;
	case *candidoni*:
	$id_del_tag='14631';
	break;
	case *canolo*:
	$id_del_tag='14632';
	break;
	case *caraffa del bianco*:
	$id_del_tag='14633';
	break;
	case *cardeto*:
	$id_del_tag='14634';
	break;
	case *careri*:
	$id_del_tag='14635';
	break;
	case *casignana*:
	$id_del_tag='14636';
	break;
	case *caulonia*:
	$id_del_tag='14637';
	break;
	case *ciminà*:
	$id_del_tag='14638';
	break;
	case *cinquefrondi*:
	$id_del_tag='14639';
	break;
	case *cittanova*:
	$id_del_tag='14640';
	break;
	case *condofuri*:
	$id_del_tag='14641';
	break;
	case *cosoleto*:
	$id_del_tag='14642';
	break;
	case *delianuova*:
	$id_del_tag='14643';
	break;
	case *feroleto della chiesa*:
	$id_del_tag='14644';
	break;
	case *ferruzzano*:
	$id_del_tag='14645';
	break;
	case *fiumara*:
	$id_del_tag='14646';
	break;
	case *galatro*:
	$id_del_tag='14647';
	break;
	case *gerace*:
	$id_del_tag='14648';
	break;
	case *giffone*:
	$id_del_tag='14649';
	break;
	case *gioiosa ionica*:
	$id_del_tag='14650';
	break;
	case *grotteria*:
	$id_del_tag='14651';
	break;
	case *laganadi*:
	$id_del_tag='14652';
	break;
	case *laureana di borrello*:
	$id_del_tag='14653';
	break;
	case *mammola*:
	$id_del_tag='14654';
	break;
	case *marina di gioiosa ionica*:
	$id_del_tag='14655';
	break;
	case *maropati*:
	$id_del_tag='14656';
	break;
	case *martone*:
	$id_del_tag='14657';
	break;
	case *melicuccà*:
	$id_del_tag='14658';
	break;
	case *melicucco*:
	$id_del_tag='14659';
	break;
	case *melito di porto salvo*:
	$id_del_tag='14660';
	break;
	case *molochio*:
	$id_del_tag='14661';
	break;
	case *montebello ionico*:
	$id_del_tag='14662';
	break;
	case *motta san giovanni*:
	$id_del_tag='14663';
	break;
	case *oppido mamertina*:
	$id_del_tag='14664';
	break;
	case *palizzi*:
	$id_del_tag='14665';
	break;
	case *pazzano*:
	$id_del_tag='14666';
	break;
	case *placanica*:
	$id_del_tag='14667';
	break;
	case *platì*:
	$id_del_tag='14668';
	break;
	case *polistena*:
	$id_del_tag='14669';
	break;
	case *portigliola*:
	$id_del_tag='14670';
	break;
	case *rizziconi*:
	$id_del_tag='14671';
	break;
	case *roccaforte del greco*:
	$id_del_tag='14672';
	break;
	case *roghudi*:
	$id_del_tag='14673';
	break;
	case *rosarno*:
	$id_del_tag='14674';
	break;
	case *samo*:
	$id_del_tag='14675';
	break;
	case *san ferdinando*:
	$id_del_tag='14676';
	break;
	case *san giorgio morgeto*:
	$id_del_tag='14677';
	break;
	case *san giovanni di gerace*:
	$id_del_tag='14678';
	break;
	case *san lorenzo*:
	$id_del_tag='14679';
	break;
	case *san luca*:
	$id_del_tag='14680';
	break;
	case *san pietro di caridà*:
	$id_del_tag='14681';
	break;
	case *san procopio*:
	$id_del_tag='14682';
	break;
	case *san roberto*:
	$id_del_tag='14683';
	break;
	case *santa cristina d'aspromonte*:
	$id_del_tag='14684';
	break;
	case *sant'agata del bianco*:
	$id_del_tag='14685';
	break;
	case *sant'alessio in aspromonte*:
	$id_del_tag='14686';
	break;
	case *sant'eufemia d'aspromonte*:
	$id_del_tag='14687';
	break;
	case *sant'ilario dello ionio*:
	$id_del_tag='14688';
	break;
	case *santo stefano in aspromonte*:
	$id_del_tag='14689';
	break;
	case *scido*:
	$id_del_tag='14690';
	break;
	case *scilla*:
	$id_del_tag='14691';
	break;
	case *seminara*:
	$id_del_tag='14692';
	break;
	case *serrata*:
	$id_del_tag='14693';
	break;
	case *siderno*:
	$id_del_tag='14694';
	break;
	case *sinopoli*:
	$id_del_tag='14695';
	break;
	case *staiti*:
	$id_del_tag='14696';
	break;
	case *stignano*:
	$id_del_tag='14697';
	break;
	case *stilo*:
	$id_del_tag='14698';
	break;
	case *taurianova*:
	$id_del_tag='14699';
	break;
	case *terranova sappo minulio*:
	$id_del_tag='14700';
	break;
	case *varapodio*:
	$id_del_tag='14701';
	break;
	case *villa san giovanni*:
	$id_del_tag='14702';
	break;
	case *buseto palizzolo*:
	$id_del_tag='14703';
	break;
	case *campobello di mazara*:
	$id_del_tag='14704';
	break;
	case *castellammare del golfo*:
	$id_del_tag='14705';
	break;
	case *castelvetrano*:
	$id_del_tag='14706';
	break;
	case *custonaci*:
	$id_del_tag='14707';
	break;
	case *erice*:
	$id_del_tag='14708';
	break;
	case *favignana*:
	$id_del_tag='14709';
	break;
	case *gibellina*:
	$id_del_tag='14710';
	break;
	case *marsala*:
	$id_del_tag='14711';
	break;
	case *paceco*:
	$id_del_tag='14712';
	break;
	case *partanna*:
	$id_del_tag='14713';
	break;
	case *petrosino*:
	$id_del_tag='14714';
	break;
	case *poggioreale*:
	$id_del_tag='14715';
	break;
	case *salaparuta*:
	$id_del_tag='14716';
	break;
	case *salemi*:
	$id_del_tag='14717';
	break;
	case *san vito lo capo*:
	$id_del_tag='14718';
	break;
	case *santa ninfa*:
	$id_del_tag='14719';
	break;
	case *valderice*:
	$id_del_tag='14720';
	break;
	case *vita*:
	$id_del_tag='14721';
	break;
	case *alia*:
	$id_del_tag='14722';
	break;
	case *alimena*:
	$id_del_tag='14723';
	break;
	case *aliminusa*:
	$id_del_tag='14724';
	break;
	case *altavilla milicia*:
	$id_del_tag='14725';
	break;
	case *altofonte*:
	$id_del_tag='14726';
	break;
	case *bagheria*:
	$id_del_tag='14727';
	break;
	case *balestrate*:
	$id_del_tag='14728';
	break;
	case *baucina*:
	$id_del_tag='14729';
	break;
	case *belmonte mezzagno*:
	$id_del_tag='14730';
	break;
	case *bisacquino*:
	$id_del_tag='14731';
	break;
	case *blufi*:
	$id_del_tag='14732';
	break;
	case *bolognetta*:
	$id_del_tag='14733';
	break;
	case *bompietro*:
	$id_del_tag='14734';
	break;
	case *borgetto*:
	$id_del_tag='14735';
	break;
	case *caccamo*:
	$id_del_tag='14736';
	break;
	case *caltavuturo*:
	$id_del_tag='14737';
	break;
	case *campofelice di fitalia*:
	$id_del_tag='14738';
	break;
	case *campofelice di roccella*:
	$id_del_tag='14739';
	break;
	case *campofiorito*:
	$id_del_tag='14740';
	break;
	case *camporeale*:
	$id_del_tag='14741';
	break;
	case *capaci*:
	$id_del_tag='14742';
	break;
	case *carini*:
	$id_del_tag='14743';
	break;
	case *castelbuono*:
	$id_del_tag='14744';
	break;
	case *casteldaccia*:
	$id_del_tag='14745';
	break;
	case *castellana sicula*:
	$id_del_tag='14746';
	break;
	case *castronovo di sicilia*:
	$id_del_tag='14747';
	break;
	case *cefalà diana*:
	$id_del_tag='14748';
	break;
	case *cefalù*:
	$id_del_tag='14749';
	break;
	case *cerda*:
	$id_del_tag='14750';
	break;
	case *chiusa sclafani*:
	$id_del_tag='14751';
	break;
	case *ciminna*:
	$id_del_tag='14752';
	break;
	case *cinisi*:
	$id_del_tag='14753';
	break;
	case *collesano*:
	$id_del_tag='14754';
	break;
	case *contessa entellina*:
	$id_del_tag='14755';
	break;
	case *corleone*:
	$id_del_tag='14756';
	break;
	case *ficarazzi*:
	$id_del_tag='14757';
	break;
	case *gangi*:
	$id_del_tag='14758';
	break;
	case *geraci siculo*:
	$id_del_tag='14759';
	break;
	case *giardinello*:
	$id_del_tag='14760';
	break;
	case *giuliana*:
	$id_del_tag='14761';
	break;
	case *godrano*:
	$id_del_tag='14762';
	break;
	case *gratteri*:
	$id_del_tag='14763';
	break;
	case *isnello*:
	$id_del_tag='14764';
	break;
	case *isola delle femmine*:
	$id_del_tag='14765';
	break;
	case *lascari*:
	$id_del_tag='14766';
	break;
	case *lercara friddi*:
	$id_del_tag='14767';
	break;
	case *marineo*:
	$id_del_tag='14768';
	break;
	case *mezzojuso*:
	$id_del_tag='14769';
	break;
	case *misilmeri*:
	$id_del_tag='14770';
	break;
	case *monreale*:
	$id_del_tag='14771';
	break;
	case *montelepre*:
	$id_del_tag='14772';
	break;
	case *montemaggiore belsito*:
	$id_del_tag='14773';
	break;
	case *palazzo adriano*:
	$id_del_tag='14774';
	break;
	case *partinico*:
	$id_del_tag='14775';
	break;
	case *petralia soprana*:
	$id_del_tag='14776';
	break;
	case *petralia sottana*:
	$id_del_tag='14777';
	break;
	case *piana degli albanesi*:
	$id_del_tag='14778';
	break;
	case *polizzi generosa*:
	$id_del_tag='14779';
	break;
	case *pollina*:
	$id_del_tag='14780';
	break;
	case *prizzi*:
	$id_del_tag='14781';
	break;
	case *roccamena*:
	$id_del_tag='14782';
	break;
	case *roccapalumba*:
	$id_del_tag='14783';
	break;
	case *san cipirello*:
	$id_del_tag='14784';
	break;
	case *san giuseppe jato*:
	$id_del_tag='14785';
	break;
	case *san mauro castelverde*:
	$id_del_tag='14786';
	break;
	case *santa cristina gela*:
	$id_del_tag='14787';
	break;
	case *santa flavia*:
	$id_del_tag='14788';
	break;
	case *sciara*:
	$id_del_tag='14789';
	break;
	case *scillato*:
	$id_del_tag='14790';
	break;
	case *sclafani bagni*:
	$id_del_tag='14791';
	break;
	case *terrasini*:
	$id_del_tag='14792';
	break;
	case *torretta*:
	$id_del_tag='14793';
	break;
	case *trabia*:
	$id_del_tag='14794';
	break;
	case *trappeto*:
	$id_del_tag='14795';
	break;
	case *ustica*:
	$id_del_tag='14796';
	break;
	case *valledolmo*:
	$id_del_tag='14797';
	break;
	case *ventimiglia di sicilia*:
	$id_del_tag='14798';
	break;
	case *vicari*:
	$id_del_tag='14799';
	break;
	case *villabate*:
	$id_del_tag='14800';
	break;
	case *villafrati*:
	$id_del_tag='14801';
	break;
	case *acquedolci*:
	$id_del_tag='14802';
	break;
	case *alcara li fusi*:
	$id_del_tag='14803';
	break;
	case *alì*:
	$id_del_tag='14804';
	break;
	case *alì terme*:
	$id_del_tag='14805';
	break;
	case *antillo*:
	$id_del_tag='14806';
	break;
	case *basicò*:
	$id_del_tag='14807';
	break;
	case *capizzi*:
	$id_del_tag='14808';
	break;
	case *capri leone*:
	$id_del_tag='14809';
	break;
	case *caronia*:
	$id_del_tag='14810';
	break;
	case *casalvecchio siculo*:
	$id_del_tag='14811';
	break;
	case *castel di lucio*:
	$id_del_tag='14812';
	break;
	case *castell'umberto*:
	$id_del_tag='14813';
	break;
	case *castelmola*:
	$id_del_tag='14814';
	break;
	case *castroreale*:
	$id_del_tag='14815';
	break;
	case *cesarò*:
	$id_del_tag='14816';
	break;
	case *condrò*:
	$id_del_tag='14817';
	break;
	case *falcone*:
	$id_del_tag='14818';
	break;
	case *ficarra*:
	$id_del_tag='14819';
	break;
	case *fiumedinisi*:
	$id_del_tag='14820';
	break;
	case *floresta*:
	$id_del_tag='14821';
	break;
	case *fondachelli-fantina*:
	$id_del_tag='14822';
	break;
	case *forza d'agrò*:
	$id_del_tag='14823';
	break;
	case *francavilla di sicilia*:
	$id_del_tag='14824';
	break;
	case *frazzanò*:
	$id_del_tag='14825';
	break;
	case *furci siculo*:
	$id_del_tag='14826';
	break;
	case *furnari*:
	$id_del_tag='14827';
	break;
	case *gaggi*:
	$id_del_tag='14828';
	break;
	case *galati mamertino*:
	$id_del_tag='14829';
	break;
	case *gallodoro*:
	$id_del_tag='14830';
	break;
	case *giardini-naxos*:
	$id_del_tag='14831';
	break;
	case *graniti*:
	$id_del_tag='14832';
	break;
	case *gualtieri sicaminò*:
	$id_del_tag='14833';
	break;
	case *itala*:
	$id_del_tag='14834';
	break;
	case *leni*:
	$id_del_tag='14835';
	break;
	case *letojanni*:
	$id_del_tag='14836';
	break;
	case *librizzi*:
	$id_del_tag='14837';
	break;
	case *limina*:
	$id_del_tag='14838';
	break;
	case *longi*:
	$id_del_tag='14839';
	break;
	case *malfa*:
	$id_del_tag='14840';
	break;
	case *malvagna*:
	$id_del_tag='14841';
	break;
	case *mandanici*:
	$id_del_tag='14842';
	break;
	case *mazzarrà sant'andrea*:
	$id_del_tag='14843';
	break;
	case *merì*:
	$id_del_tag='14844';
	break;
	case *milazzo*:
	$id_del_tag='14845';
	break;
	case *militello rosmarino*:
	$id_del_tag='14846';
	break;
	case *mirto*:
	$id_del_tag='14847';
	break;
	case *moio alcantara*:
	$id_del_tag='14848';
	break;
	case *monforte san giorgio*:
	$id_del_tag='14849';
	break;
	case *mongiuffi melia*:
	$id_del_tag='14850';
	break;
	case *montagnareale*:
	$id_del_tag='14851';
	break;
	case *montalbano elicona*:
	$id_del_tag='14852';
	break;
	case *motta camastra*:
	$id_del_tag='14853';
	break;
	case *motta d'affermo*:
	$id_del_tag='14854';
	break;
	case *naso*:
	$id_del_tag='14855';
	break;
	case *nizza di sicilia*:
	$id_del_tag='14856';
	break;
	case *novara di sicilia*:
	$id_del_tag='14857';
	break;
	case *oliveri*:
	$id_del_tag='14858';
	break;
	case *pace del mela*:
	$id_del_tag='14859';
	break;
	case *pagliara*:
	$id_del_tag='14860';
	break;
	case *patti*:
	$id_del_tag='14861';
	break;
	case *pettineo*:
	$id_del_tag='14862';
	break;
	case *piraino*:
	$id_del_tag='14863';
	break;
	case *raccuja*:
	$id_del_tag='14864';
	break;
	case *reitano*:
	$id_del_tag='14865';
	break;
	case *roccafiorita*:
	$id_del_tag='14866';
	break;
	case *roccalumera*:
	$id_del_tag='14867';
	break;
	case *roccavaldina*:
	$id_del_tag='14868';
	break;
	case *roccella valdemone*:
	$id_del_tag='14869';
	break;
	case *rodì milici*:
	$id_del_tag='14870';
	break;
	case *rometta*:
	$id_del_tag='14871';
	break;
	case *san filippo del mela*:
	$id_del_tag='14872';
	break;
	case *san fratello*:
	$id_del_tag='14873';
	break;
	case *san marco d'alunzio*:
	$id_del_tag='14874';
	break;
	case *san pier niceto*:
	$id_del_tag='14875';
	break;
	case *san piero patti*:
	$id_del_tag='14876';
	break;
	case *san salvatore di fitalia*:
	$id_del_tag='14877';
	break;
	case *san teodoro*:
	$id_del_tag='14878';
	break;
	case *santa domenica vittoria*:
	$id_del_tag='14879';
	break;
	case *santa lucia del mela*:
	$id_del_tag='14880';
	break;
	case *santa marina salina*:
	$id_del_tag='14881';
	break;
	case *santa teresa di riva*:
	$id_del_tag='14882';
	break;
	case *sant'agata di militello*:
	$id_del_tag='14883';
	break;
	case *sant'alessio siculo*:
	$id_del_tag='14884';
	break;
	case *santo stefano di camastra*:
	$id_del_tag='14885';
	break;
	case *saponara*:
	$id_del_tag='14886';
	break;
	case *savoca*:
	$id_del_tag='14887';
	break;
	case *scaletta zanclea*:
	$id_del_tag='14888';
	break;
	case *sinagra*:
	$id_del_tag='14889';
	break;
	case *spadafora*:
	$id_del_tag='14890';
	break;
	case *terme vigliatore*:
	$id_del_tag='14891';
	break;
	case *torregrotta*:
	$id_del_tag='14892';
	break;
	case *torrenova*:
	$id_del_tag='14893';
	break;
	case *tortorici*:
	$id_del_tag='14894';
	break;
	case *tripi*:
	$id_del_tag='14895';
	break;
	case *tusa*:
	$id_del_tag='14896';
	break;
	case *ucria*:
	$id_del_tag='14897';
	break;
	case *valdina*:
	$id_del_tag='14898';
	break;
	case *venetico*:
	$id_del_tag='14899';
	break;
	case *villafranca tirrena*:
	$id_del_tag='14900';
	break;
	case *alessandria della rocca*:
	$id_del_tag='14901';
	break;
	case *aragona*:
	$id_del_tag='14902';
	break;
	case *bivona*:
	$id_del_tag='14903';
	break;
	case *burgio*:
	$id_del_tag='14904';
	break;
	case *calamonaci*:
	$id_del_tag='14905';
	break;
	case *caltabellotta*:
	$id_del_tag='14906';
	break;
	case *camastra*:
	$id_del_tag='14907';
	break;
	case *cammarata*:
	$id_del_tag='14908';
	break;
	case *campobello di licata*:
	$id_del_tag='14909';
	break;
	case *canicattì*:
	$id_del_tag='14910';
	break;
	case *casteltermini*:
	$id_del_tag='14911';
	break;
	case *castrofilippo*:
	$id_del_tag='14912';
	break;
	case *cattolica eraclea*:
	$id_del_tag='14913';
	break;
	case *cianciana*:
	$id_del_tag='14914';
	break;
	case *comitini*:
	$id_del_tag='14915';
	break;
	case *favara*:
	$id_del_tag='14916';
	break;
	case *grotte*:
	$id_del_tag='14917';
	break;
	case *joppolo giancaxio*:
	$id_del_tag='14918';
	break;
	case *lucca sicula*:
	$id_del_tag='14919';
	break;
	case *menfi*:
	$id_del_tag='14920';
	break;
	case *montallegro*:
	$id_del_tag='14921';
	break;
	case *montevago*:
	$id_del_tag='14922';
	break;
	case *palma di montechiaro*:
	$id_del_tag='14923';
	break;
	case *porto empedocle*:
	$id_del_tag='14924';
	break;
	case *racalmuto*:
	$id_del_tag='14925';
	break;
	case *raffadali*:
	$id_del_tag='14926';
	break;
	case *ravanusa*:
	$id_del_tag='14927';
	break;
	case *realmonte*:
	$id_del_tag='14928';
	break;
	case *ribera*:
	$id_del_tag='14929';
	break;
	case *sambuca di sicilia*:
	$id_del_tag='14930';
	break;
	case *san biagio platani*:
	$id_del_tag='14931';
	break;
	case *san giovanni gemini*:
	$id_del_tag='14932';
	break;
	case *santa elisabetta*:
	$id_del_tag='14933';
	break;
	case *santa margherita di belice*:
	$id_del_tag='14934';
	break;
	case *sant'angelo muxaro*:
	$id_del_tag='14935';
	break;
	case *santo stefano quisquina*:
	$id_del_tag='14936';
	break;
	case *sciacca*:
	$id_del_tag='14937';
	break;
	case *siculiana*:
	$id_del_tag='14938';
	break;
	case *villafranca sicula*:
	$id_del_tag='14939';
	break;
	case *acquaviva platani*:
	$id_del_tag='14940';
	break;
	case *bompensiere*:
	$id_del_tag='14941';
	break;
	case *butera*:
	$id_del_tag='14942';
	break;
	case *campofranco*:
	$id_del_tag='14943';
	break;
	case *delia*:
	$id_del_tag='14944';
	break;
	case *marianopoli*:
	$id_del_tag='14945';
	break;
	case *mazzarino*:
	$id_del_tag='14946';
	break;
	case *milena*:
	$id_del_tag='14947';
	break;
	case *montedoro*:
	$id_del_tag='14948';
	break;
	case *mussomeli*:
	$id_del_tag='14949';
	break;
	case *resuttano*:
	$id_del_tag='14950';
	break;
	case *riesi*:
	$id_del_tag='14951';
	break;
	case *san cataldo*:
	$id_del_tag='14952';
	break;
	case *santa caterina villarmosa*:
	$id_del_tag='14953';
	break;
	case *serradifalco*:
	$id_del_tag='14954';
	break;
	case *sommatino*:
	$id_del_tag='14955';
	break;
	case *sutera*:
	$id_del_tag='14956';
	break;
	case *vallelunga pratameno*:
	$id_del_tag='14957';
	break;
	case *villalba*:
	$id_del_tag='14958';
	break;
	case *agira*:
	$id_del_tag='14959';
	break;
	case *aidone*:
	$id_del_tag='14960';
	break;
	case *assoro*:
	$id_del_tag='14961';
	break;
	case *barrafranca*:
	$id_del_tag='14962';
	break;
	case *calascibetta*:
	$id_del_tag='14963';
	break;
	case *catenanuova*:
	$id_del_tag='14964';
	break;
	case *centuripe*:
	$id_del_tag='14965';
	break;
	case *cerami*:
	$id_del_tag='14966';
	break;
	case *enna*:
	$id_del_tag='14967';
	break;
	case *gagliano castelferrato*:
	$id_del_tag='14968';
	break;
	case *nicosia*:
	$id_del_tag='14969';
	break;
	case *nissoria*:
	$id_del_tag='14970';
	break;
	case *piazza armerina*:
	$id_del_tag='14971';
	break;
	case *pietraperzia*:
	$id_del_tag='14972';
	break;
	case *regalbuto*:
	$id_del_tag='14973';
	break;
	case *sperlinga*:
	$id_del_tag='14974';
	break;
	case *valguarnera caropepe*:
	$id_del_tag='14975';
	break;
	case *villarosa*:
	$id_del_tag='14976';
	break;
	case *aci bonaccorsi*:
	$id_del_tag='14977';
	break;
	case *aci castello*:
	$id_del_tag='14978';
	break;
	case *aci catena*:
	$id_del_tag='14979';
	break;
	case *aci sant'antonio*:
	$id_del_tag='14980';
	break;
	case *adrano*:
	$id_del_tag='14981';
	break;
	case *belpasso*:
	$id_del_tag='14982';
	break;
	case *biancavilla*:
	$id_del_tag='14983';
	break;
	case *bronte*:
	$id_del_tag='14984';
	break;
	case *calatabiano*:
	$id_del_tag='14985';
	break;
	case *camporotondo etneo*:
	$id_del_tag='14986';
	break;
	case *castiglione di sicilia*:
	$id_del_tag='14987';
	break;
	case *fiumefreddo di sicilia*:
	$id_del_tag='14988';
	break;
	case *giarre*:
	$id_del_tag='14989';
	break;
	case *grammichele*:
	$id_del_tag='14990';
	break;
	case *gravina di catania*:
	$id_del_tag='14991';
	break;
	case *licodia eubea*:
	$id_del_tag='14992';
	break;
	case *linguaglossa*:
	$id_del_tag='14993';
	break;
	case *maletto*:
	$id_del_tag='14994';
	break;
	case *maniace*:
	$id_del_tag='14995';
	break;
	case *mascali*:
	$id_del_tag='14996';
	break;
	case *mascalucia*:
	$id_del_tag='14997';
	break;
	case *mazzarrone*:
	$id_del_tag='14998';
	break;
	case *militello in val di catania*:
	$id_del_tag='14999';
	break;
	case *milo*:
	$id_del_tag='15000';
	break;
	case *mineo*:
	$id_del_tag='15001';
	break;
	case *mirabella imbaccari*:
	$id_del_tag='15002';
	break;
	case *misterbianco*:
	$id_del_tag='15003';
	break;
	case *motta sant'anastasia*:
	$id_del_tag='15004';
	break;
	case *nicolosi*:
	$id_del_tag='15005';
	break;
	case *palagonia*:
	$id_del_tag='15006';
	break;
	case *paternò*:
	$id_del_tag='15007';
	break;
	case *pedara*:
	$id_del_tag='15008';
	break;
	case *piedimonte etneo*:
	$id_del_tag='15009';
	break;
	case *ragalna*:
	$id_del_tag='15010';
	break;
	case *randazzo*:
	$id_del_tag='15011';
	break;
	case *riposto*:
	$id_del_tag='15012';
	break;
	case *san cono*:
	$id_del_tag='15013';
	break;
	case *san giovanni la punta*:
	$id_del_tag='15014';
	break;
	case *san gregorio di catania*:
	$id_del_tag='15015';
	break;
	case *san michele di ganzaria*:
	$id_del_tag='15016';
	break;
	case *san pietro clarenza*:
	$id_del_tag='15017';
	break;
	case *santa maria di licodia*:
	$id_del_tag='15018';
	break;
	case *santa venerina*:
	$id_del_tag='15019';
	break;
	case *sant'agata li battiati*:
	$id_del_tag='15020';
	break;
	case *sant'alfio*:
	$id_del_tag='15021';
	break;
	case *trecastagni*:
	$id_del_tag='15022';
	break;
	case *tremestieri etneo*:
	$id_del_tag='15023';
	break;
	case *viagrande*:
	$id_del_tag='15024';
	break;
	case *zafferana etnea*:
	$id_del_tag='15025';
	break;
	case *acate*:
	$id_del_tag='15026';
	break;
	case *chiaramonte gulfi*:
	$id_del_tag='15027';
	break;
	case *giarratana*:
	$id_del_tag='15028';
	break;
	case *ispica*:
	$id_del_tag='15029';
	break;
	case *monterosso almo*:
	$id_del_tag='15030';
	break;
	case *pozzallo*:
	$id_del_tag='15031';
	break;
	case *santa croce camerina*:
	$id_del_tag='15032';
	break;
	case *scicli*:
	$id_del_tag='15033';
	break;
	case *augusta*:
	$id_del_tag='15034';
	break;
	case *avola*:
	$id_del_tag='15035';
	break;
	case *buccheri*:
	$id_del_tag='15036';
	break;
	case *buscemi*:
	$id_del_tag='15037';
	break;
	case *canicattini bagni*:
	$id_del_tag='15038';
	break;
	case *carlentini*:
	$id_del_tag='15039';
	break;
	case *cassaro*:
	$id_del_tag='15040';
	break;
	case *ferla*:
	$id_del_tag='15041';
	break;
	case *floridia*:
	$id_del_tag='15042';
	break;
	case *francofonte*:
	$id_del_tag='15043';
	break;
	case *lentini*:
	$id_del_tag='15044';
	break;
	case *melilli*:
	$id_del_tag='15045';
	break;
	case *noto*:
	$id_del_tag='15046';
	break;
	case *pachino*:
	$id_del_tag='15047';
	break;
	case *palazzolo acreide*:
	$id_del_tag='15048';
	break;
	case *rosolini*:
	$id_del_tag='15049';
	break;
	case *solarino*:
	$id_del_tag='15050';
	break;
	case *sortino*:
	$id_del_tag='15051';
	break;
	case *anela*:
	$id_del_tag='15052';
	break;
	case *ardara*:
	$id_del_tag='15053';
	break;
	case *banari*:
	$id_del_tag='15054';
	break;
	case *benetutti*:
	$id_del_tag='15055';
	break;
	case *bessude*:
	$id_del_tag='15056';
	break;
	case *bonnanaro*:
	$id_del_tag='15057';
	break;
	case *bono*:
	$id_del_tag='15058';
	break;
	case *bonorva*:
	$id_del_tag='15059';
	break;
	case *borutta*:
	$id_del_tag='15060';
	break;
	case *bottidda*:
	$id_del_tag='15061';
	break;
	case *bultei*:
	$id_del_tag='15062';
	break;
	case *bulzi*:
	$id_del_tag='15063';
	break;
	case *burgos*:
	$id_del_tag='15064';
	break;
	case *cargeghe*:
	$id_del_tag='15065';
	break;
	case *castelsardo*:
	$id_del_tag='15066';
	break;
	case *cheremule*:
	$id_del_tag='15067';
	break;
	case *chiaramonti*:
	$id_del_tag='15068';
	break;
	case *codrongianos*:
	$id_del_tag='15069';
	break;
	case *cossoine*:
	$id_del_tag='15070';
	break;
	case *erula*:
	$id_del_tag='15071';
	break;
	case *esporlatu*:
	$id_del_tag='15072';
	break;
	case *florinas*:
	$id_del_tag='15073';
	break;
	case *giave*:
	$id_del_tag='15074';
	break;
	case *illorai*:
	$id_del_tag='15075';
	break;
	case *ittireddu*:
	$id_del_tag='15076';
	break;
	case *ittiri*:
	$id_del_tag='15077';
	break;
	case *laerru*:
	$id_del_tag='15078';
	break;
	case *mara*:
	$id_del_tag='15079';
	break;
	case *martis*:
	$id_del_tag='15080';
	break;
	case *monteleone rocca doria*:
	$id_del_tag='15081';
	break;
	case *mores*:
	$id_del_tag='15082';
	break;
	case *muros*:
	$id_del_tag='15083';
	break;
	case *nughedu san nicolò*:
	$id_del_tag='15084';
	break;
	case *nule*:
	$id_del_tag='15085';
	break;
	case *nulvi*:
	$id_del_tag='15086';
	break;
	case *olmedo*:
	$id_del_tag='15087';
	break;
	case *osilo*:
	$id_del_tag='15088';
	break;
	case *ossi*:
	$id_del_tag='15089';
	break;
	case *ozieri*:
	$id_del_tag='15090';
	break;
	case *padria*:
	$id_del_tag='15091';
	break;
	case *pattada*:
	$id_del_tag='15092';
	break;
	case *perfugas*:
	$id_del_tag='15093';
	break;
	case *ploaghe*:
	$id_del_tag='15094';
	break;
	case *pozzomaggiore*:
	$id_del_tag='15095';
	break;
	case *putifigari*:
	$id_del_tag='15096';
	break;
	case *romana*:
	$id_del_tag='15097';
	break;
	case *santa maria coghinas*:
	$id_del_tag='15098';
	break;
	case *sedini*:
	$id_del_tag='15099';
	break;
	case *semestene*:
	$id_del_tag='15100';
	break;
	case *sennori*:
	$id_del_tag='15101';
	break;
	case *siligo*:
	$id_del_tag='15102';
	break;
	case *sorso*:
	$id_del_tag='15103';
	break;
	case *stintino*:
	$id_del_tag='15104';
	break;
	case *tergu*:
	$id_del_tag='15105';
	break;
	case *thiesi*:
	$id_del_tag='15106';
	break;
	case *tissi*:
	$id_del_tag='15107';
	break;
	case *torralba*:
	$id_del_tag='15108';
	break;
	case *tula*:
	$id_del_tag='15109';
	break;
	case *uri*:
	$id_del_tag='15110';
	break;
	case *usini*:
	$id_del_tag='15111';
	break;
	case *valledoria*:
	$id_del_tag='15112';
	break;
	case *viddalba*:
	$id_del_tag='15113';
	break;
	case *villanova monteleone*:
	$id_del_tag='15114';
	break;
	case *aritzo*:
	$id_del_tag='15115';
	break;
	case *atzara*:
	$id_del_tag='15116';
	break;
	case *austis*:
	$id_del_tag='15117';
	break;
	case *belvì*:
	$id_del_tag='15118';
	break;
	case *birori*:
	$id_del_tag='15119';
	break;
	case *bitti*:
	$id_del_tag='15120';
	break;
	case *bolotana*:
	$id_del_tag='15121';
	break;
	case *borore*:
	$id_del_tag='15122';
	break;
	case *bortigali*:
	$id_del_tag='15123';
	break;
	case *desulo*:
	$id_del_tag='15124';
	break;
	case *dorgali*:
	$id_del_tag='15125';
	break;
	case *dualchi*:
	$id_del_tag='15126';
	break;
	case *fonni*:
	$id_del_tag='15127';
	break;
	case *gadoni*:
	$id_del_tag='15128';
	break;
	case *galtellì*:
	$id_del_tag='15129';
	break;
	case *gavoi*:
	$id_del_tag='15130';
	break;
	case *irgoli*:
	$id_del_tag='15131';
	break;
	case *lei*:
	$id_del_tag='15132';
	break;
	case *loculi*:
	$id_del_tag='15133';
	break;
	case *lodè*:
	$id_del_tag='15134';
	break;
	case *lodine*:
	$id_del_tag='15135';
	break;
	case *lula*:
	$id_del_tag='15136';
	break;
	case *mamoiada*:
	$id_del_tag='15137';
	break;
	case *meana sardo*:
	$id_del_tag='15138';
	break;
	case *noragugume*:
	$id_del_tag='15139';
	break;
	case *oliena*:
	$id_del_tag='15140';
	break;
	case *ollolai*:
	$id_del_tag='15141';
	break;
	case *olzai*:
	$id_del_tag='15142';
	break;
	case *onanì*:
	$id_del_tag='15143';
	break;
	case *onifai*:
	$id_del_tag='15144';
	break;
	case *oniferi*:
	$id_del_tag='15145';
	break;
	case *orani*:
	$id_del_tag='15146';
	break;
	case *orgosolo*:
	$id_del_tag='15147';
	break;
	case *orosei*:
	$id_del_tag='15148';
	break;
	case *orotelli*:
	$id_del_tag='15149';
	break;
	case *ortueri*:
	$id_del_tag='15150';
	break;
	case *orune*:
	$id_del_tag='15151';
	break;
	case *osidda*:
	$id_del_tag='15152';
	break;
	case *ovodda*:
	$id_del_tag='15153';
	break;
	case *posada*:
	$id_del_tag='15154';
	break;
	case *sarule*:
	$id_del_tag='15155';
	break;
	case *silanus*:
	$id_del_tag='15156';
	break;
	case *sindia*:
	$id_del_tag='15157';
	break;
	case *sorgono*:
	$id_del_tag='15158';
	break;
	case *teti*:
	$id_del_tag='15159';
	break;
	case *tiana*:
	$id_del_tag='15160';
	break;
	case *tonara*:
	$id_del_tag='15161';
	break;
	case *torpè*:
	$id_del_tag='15162';
	break;
	case *armungia*:
	$id_del_tag='15163';
	break;
	case *assemini*:
	$id_del_tag='15164';
	break;
	case *ballao*:
	$id_del_tag='15165';
	break;
	case *barrali*:
	$id_del_tag='15166';
	break;
	case *burcei*:
	$id_del_tag='15167';
	break;
	case *capoterra*:
	$id_del_tag='15168';
	break;
	case *castiadas*:
	$id_del_tag='15169';
	break;
	case *decimomannu*:
	$id_del_tag='15170';
	break;
	case *decimoputzu*:
	$id_del_tag='15171';
	break;
	case *dolianova*:
	$id_del_tag='15172';
	break;
	case *domus de maria*:
	$id_del_tag='15173';
	break;
	case *donori*:
	$id_del_tag='15174';
	break;
	case *elmas*:
	$id_del_tag='15175';
	break;
	case *escalaplano*:
	$id_del_tag='15176';
	break;
	case *escolca*:
	$id_del_tag='15177';
	break;
	case *esterzili*:
	$id_del_tag='15178';
	break;
	case *gergei*:
	$id_del_tag='15179';
	break;
	case *gesico*:
	$id_del_tag='15180';
	break;
	case *goni*:
	$id_del_tag='15181';
	break;
	case *guamaggiore*:
	$id_del_tag='15182';
	break;
	case *guasila*:
	$id_del_tag='15183';
	break;
	case *isili*:
	$id_del_tag='15184';
	break;
	case *mandas*:
	$id_del_tag='15185';
	break;
	case *maracalagonis*:
	$id_del_tag='15186';
	break;
	case *monastir*:
	$id_del_tag='15187';
	break;
	case *monserrato*:
	$id_del_tag='15188';
	break;
	case *muravera*:
	$id_del_tag='15189';
	break;
	case *nuragus*:
	$id_del_tag='15190';
	break;
	case *nurallao*:
	$id_del_tag='15191';
	break;
	case *nuraminis*:
	$id_del_tag='15192';
	break;
	case *nurri*:
	$id_del_tag='15193';
	break;
	case *orroli*:
	$id_del_tag='15194';
	break;
	case *ortacesus*:
	$id_del_tag='15195';
	break;
	case *pimentel*:
	$id_del_tag='15196';
	break;
	case *quartu sant'elena*:
	$id_del_tag='15197';
	break;
	case *quartucciu*:
	$id_del_tag='15198';
	break;
	case *sadali*:
	$id_del_tag='15199';
	break;
	case *samatzai*:
	$id_del_tag='15200';
	break;
	case *san basilio*:
	$id_del_tag='15201';
	break;
	case *san nicolò gerrei*:
	$id_del_tag='15202';
	break;
	case *san sperate*:
	$id_del_tag='15203';
	break;
	case *san vito*:
	$id_del_tag='15204';
	break;
	case *sant'andrea frius*:
	$id_del_tag='15205';
	break;
	case *sarroch*:
	$id_del_tag='15206';
	break;
	case *selargius*:
	$id_del_tag='15207';
	break;
	case *selegas*:
	$id_del_tag='15208';
	break;
	case *senorbì*:
	$id_del_tag='15209';
	break;
	case *serdiana*:
	$id_del_tag='15210';
	break;
	case *serri*:
	$id_del_tag='15211';
	break;
	case *sestu*:
	$id_del_tag='15212';
	break;
	case *settimo san pietro*:
	$id_del_tag='15213';
	break;
	case *seulo*:
	$id_del_tag='15214';
	break;
	case *siliqua*:
	$id_del_tag='15215';
	break;
	case *silius*:
	$id_del_tag='15216';
	break;
	case *sinnai*:
	$id_del_tag='15217';
	break;
	case *siurgus donigala*:
	$id_del_tag='15218';
	break;
	case *soleminis*:
	$id_del_tag='15219';
	break;
	case *suelli*:
	$id_del_tag='15220';
	break;
	case *teulada*:
	$id_del_tag='15221';
	break;
	case *ussana*:
	$id_del_tag='15222';
	break;
	case *uta*:
	$id_del_tag='15223';
	break;
	case *vallermosa*:
	$id_del_tag='15224';
	break;
	case *villa san pietro*:
	$id_del_tag='15225';
	break;
	case *villanova tulo*:
	$id_del_tag='15226';
	break;
	case *villaputzu*:
	$id_del_tag='15227';
	break;
	case *villasalto*:
	$id_del_tag='15228';
	break;
	case *villasimius*:
	$id_del_tag='15229';
	break;
	case *villasor*:
	$id_del_tag='15230';
	break;
	case *villaspeciosa*:
	$id_del_tag='15231';
	break;
	case *andreis*:
	$id_del_tag='15232';
	break;
	case *arba*:
	$id_del_tag='15233';
	break;
	case *arzene*:
	$id_del_tag='15234';
	break;
	case *azzano decimo*:
	$id_del_tag='15235';
	break;
	case *barcis*:
	$id_del_tag='15236';
	break;
	case *brugnera*:
	$id_del_tag='15237';
	break;
	case *budoia*:
	$id_del_tag='15238';
	break;
	case *caneva*:
	$id_del_tag='15239';
	break;
	case *casarsa della delizia*:
	$id_del_tag='15240';
	break;
	case *castelnovo del friuli*:
	$id_del_tag='15241';
	break;
	case *cavasso nuovo*:
	$id_del_tag='15242';
	break;
	case *chions*:
	$id_del_tag='15243';
	break;
	case *cimolais*:
	$id_del_tag='15244';
	break;
	case *clauzetto*:
	$id_del_tag='15245';
	break;
	case *cordenons*:
	$id_del_tag='15246';
	break;
	case *cordovado*:
	$id_del_tag='15247';
	break;
	case *fanna*:
	$id_del_tag='15248';
	break;
	case *fiume veneto*:
	$id_del_tag='15249';
	break;
	case *fontanafredda*:
	$id_del_tag='15250';
	break;
	case *frisanco*:
	$id_del_tag='15251';
	break;
	case *maniago*:
	$id_del_tag='15252';
	break;
	case *meduno*:
	$id_del_tag='15253';
	break;
	case *montereale valcellina*:
	$id_del_tag='15254';
	break;
	case *morsano al tagliamento*:
	$id_del_tag='15255';
	break;
	case *pasiano di pordenone*:
	$id_del_tag='15256';
	break;
	case *pinzano al tagliamento*:
	$id_del_tag='15257';
	break;
	case *polcenigo*:
	$id_del_tag='15258';
	break;
	case *porcia*:
	$id_del_tag='15259';
	break;
	case *prata di pordenone*:
	$id_del_tag='15260';
	break;
	case *pravisdomini*:
	$id_del_tag='15261';
	break;
	case *roveredo in piano*:
	$id_del_tag='15262';
	break;
	case *sacile*:
	$id_del_tag='15263';
	break;
	case *san giorgio della richinvelda*:
	$id_del_tag='15264';
	break;
	case *san martino al tagliamento*:
	$id_del_tag='15265';
	break;
	case *san quirino*:
	$id_del_tag='15266';
	break;
	case *san vito al tagliamento*:
	$id_del_tag='15267';
	break;
	case *sequals*:
	$id_del_tag='15268';
	break;
	case *sesto al reghena*:
	$id_del_tag='15269';
	break;
	case *tramonti di sopra*:
	$id_del_tag='15270';
	break;
	case *travesio*:
	$id_del_tag='15271';
	break;
	case *vajont*:
	$id_del_tag='15272';
	break;
	case *valvasone*:
	$id_del_tag='15273';
	break;
	case *vito d'asio*:
	$id_del_tag='15274';
	break;
	case *vivaro*:
	$id_del_tag='15275';
	break;
	case *zoppola*:
	$id_del_tag='15276';
	break;
	case *acquaviva d'isernia*:
	$id_del_tag='15277';
	break;
	case *agnone*:
	$id_del_tag='15278';
	break;
	case *bagnoli del trigno*:
	$id_del_tag='15279';
	break;
	case *belmonte del sannio*:
	$id_del_tag='15280';
	break;
	case *cantalupo nel sannio*:
	$id_del_tag='15281';
	break;
	case *capracotta*:
	$id_del_tag='15282';
	break;
	case *carovilli*:
	$id_del_tag='15283';
	break;
	case *carpinone*:
	$id_del_tag='15284';
	break;
	case *castel del giudice*:
	$id_del_tag='15285';
	break;
	case *castel san vincenzo*:
	$id_del_tag='15286';
	break;
	case *castelpetroso*:
	$id_del_tag='15287';
	break;
	case *castelpizzuto*:
	$id_del_tag='15288';
	break;
	case *castelverrino*:
	$id_del_tag='15289';
	break;
	case *cerro al volturno*:
	$id_del_tag='15290';
	break;
	case *chiauci*:
	$id_del_tag='15291';
	break;
	case *civitanova del sannio*:
	$id_del_tag='15292';
	break;
	case *colli a volturno*:
	$id_del_tag='15293';
	break;
	case *conca casale*:
	$id_del_tag='15294';
	break;
	case *filignano*:
	$id_del_tag='15295';
	break;
	case *forlì del sannio*:
	$id_del_tag='15296';
	break;
	case *fornelli*:
	$id_del_tag='15297';
	break;
	case *frosolone*:
	$id_del_tag='15298';
	break;
	case *longano*:
	$id_del_tag='15299';
	break;
	case *macchia d'isernia*:
	$id_del_tag='15300';
	break;
	case *macchiagodena*:
	$id_del_tag='15301';
	break;
	case *miranda*:
	$id_del_tag='15302';
	break;
	case *montaquila*:
	$id_del_tag='15303';
	break;
	case *montenero val cocchiara*:
	$id_del_tag='15304';
	break;
	case *monteroduni*:
	$id_del_tag='15305';
	break;
	case *pesche*:
	$id_del_tag='15306';
	break;
	case *pescolanciano*:
	$id_del_tag='15307';
	break;
	case *pescopennataro*:
	$id_del_tag='15308';
	break;
	case *pettoranello del molise*:
	$id_del_tag='15309';
	break;
	case *pietrabbondante*:
	$id_del_tag='15310';
	break;
	case *pizzone*:
	$id_del_tag='15311';
	break;
	case *poggio sannita*:
	$id_del_tag='15312';
	break;
	case *rionero sannitico*:
	$id_del_tag='15313';
	break;
	case *roccamandolfi*:
	$id_del_tag='15314';
	break;
	case *roccasicura*:
	$id_del_tag='15315';
	break;
	case *rocchetta a volturno*:
	$id_del_tag='15316';
	break;
	case *san pietro avellana*:
	$id_del_tag='15317';
	break;
	case *santa maria del molise*:
	$id_del_tag='15318';
	break;
	case *sant'agapito*:
	$id_del_tag='15319';
	break;
	case *sant'angelo del pesco*:
	$id_del_tag='15320';
	break;
	case *sant'elena sannita*:
	$id_del_tag='15321';
	break;
	case *scapoli*:
	$id_del_tag='15322';
	break;
	case *sessano del molise*:
	$id_del_tag='15323';
	break;
	case *sesto campano*:
	$id_del_tag='15324';
	break;
	case *vastogirardi*:
	$id_del_tag='15325';
	break;
	case *venafro*:
	$id_del_tag='15326';
	break;
	case *abbasanta*:
	$id_del_tag='15327';
	break;
	case *aidomaggiore*:
	$id_del_tag='15328';
	break;
	case *albagiara*:
	$id_del_tag='15329';
	break;
	case *ales*:
	$id_del_tag='15330';
	break;
	case *allai*:
	$id_del_tag='15331';
	break;
	case *arborea*:
	$id_del_tag='15332';
	break;
	case *ardauli*:
	$id_del_tag='15333';
	break;
	case *assolo*:
	$id_del_tag='15334';
	break;
	case *asuni*:
	$id_del_tag='15335';
	break;
	case *baradili*:
	$id_del_tag='15336';
	break;
	case *baratili san pietro*:
	$id_del_tag='15337';
	break;
	case *baressa*:
	$id_del_tag='15338';
	break;
	case *bauladu*:
	$id_del_tag='15339';
	break;
	case *bidonì*:
	$id_del_tag='15340';
	break;
	case *bonarcado*:
	$id_del_tag='15341';
	break;
	case *boroneddu*:
	$id_del_tag='15342';
	break;
	case *bosa*:
	$id_del_tag='15343';
	break;
	case *busachi*:
	$id_del_tag='15344';
	break;
	case *cabras*:
	$id_del_tag='15345';
	break;
	case *cuglieri*:
	$id_del_tag='15346';
	break;
	case *curcuris*:
	$id_del_tag='15347';
	break;
	case *flussio*:
	$id_del_tag='15348';
	break;
	case *fordongianus*:
	$id_del_tag='15349';
	break;
	case *genoni*:
	$id_del_tag='15350';
	break;
	case *ghilarza*:
	$id_del_tag='15351';
	break;
	case *gonnoscodina*:
	$id_del_tag='15352';
	break;
	case *gonnosnò*:
	$id_del_tag='15353';
	break;
	case *gonnostramatza*:
	$id_del_tag='15354';
	break;
	case *laconi*:
	$id_del_tag='15355';
	break;
	case *magomadas*:
	$id_del_tag='15356';
	break;
	case *marrubiu*:
	$id_del_tag='15357';
	break;
	case *masullas*:
	$id_del_tag='15358';
	break;
	case *milis*:
	$id_del_tag='15359';
	break;
	case *modolo*:
	$id_del_tag='15360';
	break;
	case *mogorella*:
	$id_del_tag='15361';
	break;
	case *mogoro*:
	$id_del_tag='15362';
	break;
	case *montresta*:
	$id_del_tag='15363';
	break;
	case *morgongiori*:
	$id_del_tag='15364';
	break;
	case *narbolia*:
	$id_del_tag='15365';
	break;
	case *neoneli*:
	$id_del_tag='15366';
	break;
	case *norbello*:
	$id_del_tag='15367';
	break;
	case *nughedu santa vittoria*:
	$id_del_tag='15368';
	break;
	case *nurachi*:
	$id_del_tag='15369';
	break;
	case *nureci*:
	$id_del_tag='15370';
	break;
	case *ollastra*:
	$id_del_tag='15371';
	break;
	case *palmas arborea*:
	$id_del_tag='15372';
	break;
	case *pau*:
	$id_del_tag='15373';
	break;
	case *paulilatino*:
	$id_del_tag='15374';
	break;
	case *pompu*:
	$id_del_tag='15375';
	break;
	case *riola sardo*:
	$id_del_tag='15376';
	break;
	case *ruinas*:
	$id_del_tag='15377';
	break;
	case *sagama*:
	$id_del_tag='15378';
	break;
	case *samugheo*:
	$id_del_tag='15379';
	break;
	case *san nicolò d'arcidano*:
	$id_del_tag='15380';
	break;
	case *san vero milis*:
	$id_del_tag='15381';
	break;
	case *santa giusta*:
	$id_del_tag='15382';
	break;
	case *santu lussurgiu*:
	$id_del_tag='15383';
	break;
	case *scano di montiferro*:
	$id_del_tag='15384';
	break;
	case *sedilo*:
	$id_del_tag='15385';
	break;
	case *seneghe*:
	$id_del_tag='15386';
	break;
	case *senis*:
	$id_del_tag='15387';
	break;
	case *sennariolo*:
	$id_del_tag='15388';
	break;
	case *siamaggiore*:
	$id_del_tag='15389';
	break;
	case *siamanna*:
	$id_del_tag='15390';
	break;
	case *siapiccia*:
	$id_del_tag='15391';
	break;
	case *simala*:
	$id_del_tag='15392';
	break;
	case *simaxis*:
	$id_del_tag='15393';
	break;
	case *sini*:
	$id_del_tag='15394';
	break;
	case *siris*:
	$id_del_tag='15395';
	break;
	case *soddì*:
	$id_del_tag='15396';
	break;
	case *solarussa*:
	$id_del_tag='15397';
	break;
	case *sorradile*:
	$id_del_tag='15398';
	break;
	case *suni*:
	$id_del_tag='15399';
	break;
	case *tadasuni*:
	$id_del_tag='15400';
	break;
	case *terralba*:
	$id_del_tag='15401';
	break;
	case *tinnura*:
	$id_del_tag='15402';
	break;
	case *tramatza*:
	$id_del_tag='15403';
	break;
	case *ulà tirso*:
	$id_del_tag='15404';
	break;
	case *uras*:
	$id_del_tag='15405';
	break;
	case *usellus*:
	$id_del_tag='15406';
	break;
	case *villa sant'antonio*:
	$id_del_tag='15407';
	break;
	case *villa verde*:
	$id_del_tag='15408';
	break;
	case *villanova truschedu*:
	$id_del_tag='15409';
	break;
	case *villaurbana*:
	$id_del_tag='15410';
	break;
	case *zeddiani*:
	$id_del_tag='15411';
	break;
	case *zerfaliu*:
	$id_del_tag='15412';
	break;
	case *ailoche*:
	$id_del_tag='15413';
	break;
	case *andorno micca*:
	$id_del_tag='15414';
	break;
	case *benna*:
	$id_del_tag='15415';
	break;
	case *bioglio*:
	$id_del_tag='15416';
	break;
	case *borriana*:
	$id_del_tag='15417';
	break;
	case *brusnengo*:
	$id_del_tag='15418';
	break;
	case *callabiana*:
	$id_del_tag='15419';
	break;
	case *camandona*:
	$id_del_tag='15420';
	break;
	case *camburzano*:
	$id_del_tag='15421';
	break;
	case *campiglia cervo*:
	$id_del_tag='15422';
	break;
	case *candelo*:
	$id_del_tag='15423';
	break;
	case *caprile*:
	$id_del_tag='15424';
	break;
	case *casapinta*:
	$id_del_tag='15425';
	break;
	case *castelletto cervo*:
	$id_del_tag='15426';
	break;
	case *cavaglià*:
	$id_del_tag='15427';
	break;
	case *cerreto castello*:
	$id_del_tag='15428';
	break;
	case *cerrione*:
	$id_del_tag='15429';
	break;
	case *coggiola*:
	$id_del_tag='15430';
	break;
	case *cossato*:
	$id_del_tag='15431';
	break;
	case *crevacuore*:
	$id_del_tag='15432';
	break;
	case *crosa*:
	$id_del_tag='15433';
	break;
	case *curino*:
	$id_del_tag='15434';
	break;
	case *donato*:
	$id_del_tag='15435';
	break;
	case *dorzano*:
	$id_del_tag='15436';
	break;
	case *gaglianico*:
	$id_del_tag='15437';
	break;
	case *gifflenga*:
	$id_del_tag='15438';
	break;
	case *graglia*:
	$id_del_tag='15439';
	break;
	case *lessona*:
	$id_del_tag='15440';
	break;
	case *magnano*:
	$id_del_tag='15441';
	break;
	case *massazza*:
	$id_del_tag='15442';
	break;
	case *masserano*:
	$id_del_tag='15443';
	break;
	case *mezzana mortigliengo*:
	$id_del_tag='15444';
	break;
	case *miagliano*:
	$id_del_tag='15445';
	break;
	case *mongrando*:
	$id_del_tag='15446';
	break;
	case *mosso*:
	$id_del_tag='15447';
	break;
	case *mottalciata*:
	$id_del_tag='15448';
	break;
	case *muzzano*:
	$id_del_tag='15449';
	break;
	case *netro*:
	$id_del_tag='15450';
	break;
	case *occhieppo inferiore*:
	$id_del_tag='15451';
	break;
	case *occhieppo superiore*:
	$id_del_tag='15452';
	break;
	case *pettinengo*:
	$id_del_tag='15453';
	break;
	case *piatto*:
	$id_del_tag='15454';
	break;
	case *piedicavallo*:
	$id_del_tag='15455';
	break;
	case *pollone*:
	$id_del_tag='15456';
	break;
	case *ponderano*:
	$id_del_tag='15457';
	break;
	case *portula*:
	$id_del_tag='15458';
	break;
	case *pralungo*:
	$id_del_tag='15459';
	break;
	case *pray*:
	$id_del_tag='15460';
	break;
	case *quaregna*:
	$id_del_tag='15461';
	break;
	case *quittengo*:
	$id_del_tag='15462';
	break;
	case *ronco biellese*:
	$id_del_tag='15463';
	break;
	case *roppolo*:
	$id_del_tag='15464';
	break;
	case *rosazza*:
	$id_del_tag='15465';
	break;
	case *sagliano micca*:
	$id_del_tag='15466';
	break;
	case *sala biellese*:
	$id_del_tag='15467';
	break;
	case *salussola*:
	$id_del_tag='15468';
	break;
	case *san paolo cervo*:
	$id_del_tag='15469';
	break;
	case *sandigliano*:
	$id_del_tag='15470';
	break;
	case *selve marcone*:
	$id_del_tag='15471';
	break;
	case *soprana*:
	$id_del_tag='15472';
	break;
	case *sordevolo*:
	$id_del_tag='15473';
	break;
	case *sostegno*:
	$id_del_tag='15474';
	break;
	case *strona*:
	$id_del_tag='15475';
	break;
	case *tavigliano*:
	$id_del_tag='15476';
	break;
	case *ternengo*:
	$id_del_tag='15477';
	break;
	case *tollegno*:
	$id_del_tag='15478';
	break;
	case *torrazzo*:
	$id_del_tag='15479';
	break;
	case *trivero*:
	$id_del_tag='15480';
	break;
	case *valdengo*:
	$id_del_tag='15481';
	break;
	case *vallanzengo*:
	$id_del_tag='15482';
	break;
	case *valle mosso*:
	$id_del_tag='15483';
	break;
	case *valle san nicolao*:
	$id_del_tag='15484';
	break;
	case *veglio*:
	$id_del_tag='15485';
	break;
	case *verrone*:
	$id_del_tag='15486';
	break;
	case *vigliano biellese*:
	$id_del_tag='15487';
	break;
	case *villa del bosco*:
	$id_del_tag='15488';
	break;
	case *villanova biellese*:
	$id_del_tag='15489';
	break;
	case *viverone*:
	$id_del_tag='15490';
	break;
	case *zimone*:
	$id_del_tag='15491';
	break;
	case *zubiena*:
	$id_del_tag='15492';
	break;
	case *zumaglia*:
	$id_del_tag='15493';
	break;
	case *abbadia lariana*:
	$id_del_tag='15494';
	break;
	case *airuno*:
	$id_del_tag='15495';
	break;
	case *annone di brianza*:
	$id_del_tag='15496';
	break;
	case *ballabio*:
	$id_del_tag='15497';
	break;
	case *barzago*:
	$id_del_tag='15498';
	break;
	case *barzanò*:
	$id_del_tag='15499';
	break;
	case *barzio*:
	$id_del_tag='15500';
	break;
	case *bellano*:
	$id_del_tag='15501';
	break;
	case *bosisio parini*:
	$id_del_tag='15502';
	break;
	case *brivio*:
	$id_del_tag='15503';
	break;
	case *bulciago*:
	$id_del_tag='15504';
	break;
	case *calco*:
	$id_del_tag='15505';
	break;
	case *carenno*:
	$id_del_tag='15506';
	break;
	case *casargo*:
	$id_del_tag='15507';
	break;
	case *casatenovo*:
	$id_del_tag='15508';
	break;
	case *cassina valsassina*:
	$id_del_tag='15509';
	break;
	case *castello di brianza*:
	$id_del_tag='15510';
	break;
	case *cernusco lombardone*:
	$id_del_tag='15511';
	break;
	case *cesana brianza*:
	$id_del_tag='15512';
	break;
	case *civate*:
	$id_del_tag='15513';
	break;
	case *colico*:
	$id_del_tag='15514';
	break;
	case *colle brianza*:
	$id_del_tag='15515';
	break;
	case *cortenova*:
	$id_del_tag='15516';
	break;
	case *costa masnaga*:
	$id_del_tag='15517';
	break;
	case *crandola valsassina*:
	$id_del_tag='15518';
	break;
	case *cremella*:
	$id_del_tag='15519';
	break;
	case *cremeno*:
	$id_del_tag='15520';
	break;
	case *dervio*:
	$id_del_tag='15521';
	break;
	case *dolzago*:
	$id_del_tag='15522';
	break;
	case *dorio*:
	$id_del_tag='15523';
	break;
	case *ello*:
	$id_del_tag='15524';
	break;
	case *erve*:
	$id_del_tag='15525';
	break;
	case *esino lario*:
	$id_del_tag='15526';
	break;
	case *galbiate*:
	$id_del_tag='15527';
	break;
	case *garbagnate monastero*:
	$id_del_tag='15528';
	break;
	case *garlate*:
	$id_del_tag='15529';
	break;
	case *imbersago*:
	$id_del_tag='15530';
	break;
	case *introbio*:
	$id_del_tag='15531';
	break;
	case *introzzo*:
	$id_del_tag='15532';
	break;
	case *lierna*:
	$id_del_tag='15533';
	break;
	case *lomagna*:
	$id_del_tag='15534';
	break;
	case *malgrate*:
	$id_del_tag='15535';
	break;
	case *mandello del lario*:
	$id_del_tag='15536';
	break;
	case *margno*:
	$id_del_tag='15537';
	break;
	case *merate*:
	$id_del_tag='15538';
	break;
	case *missaglia*:
	$id_del_tag='15539';
	break;
	case *moggio*:
	$id_del_tag='15540';
	break;
	case *molteno*:
	$id_del_tag='15541';
	break;
	case *monte marenzo*:
	$id_del_tag='15542';
	break;
	case *montevecchia*:
	$id_del_tag='15543';
	break;
	case *monticello brianza*:
	$id_del_tag='15544';
	break;
	case *morterone*:
	$id_del_tag='15545';
	break;
	case *oggiono*:
	$id_del_tag='15546';
	break;
	case *olgiate molgora*:
	$id_del_tag='15547';
	break;
	case *olginate*:
	$id_del_tag='15548';
	break;
	case *oliveto lario*:
	$id_del_tag='15549';
	break;
	case *osnago*:
	$id_del_tag='15550';
	break;
	case *paderno d'adda*:
	$id_del_tag='15551';
	break;
	case *pagnona*:
	$id_del_tag='15552';
	break;
	case *parlasco*:
	$id_del_tag='15553';
	break;
	case *pasturo*:
	$id_del_tag='15554';
	break;
	case *perego*:
	$id_del_tag='15555';
	break;
	case *perledo*:
	$id_del_tag='15556';
	break;
	case *pescate*:
	$id_del_tag='15557';
	break;
	case *premana*:
	$id_del_tag='15558';
	break;
	case *primaluna*:
	$id_del_tag='15559';
	break;
	case *rogeno*:
	$id_del_tag='15560';
	break;
	case *rovagnate*:
	$id_del_tag='15561';
	break;
	case *santa maria hoè*:
	$id_del_tag='15562';
	break;
	case *sirone*:
	$id_del_tag='15563';
	break;
	case *sirtori*:
	$id_del_tag='15564';
	break;
	case *sueglio*:
	$id_del_tag='15565';
	break;
	case *suello*:
	$id_del_tag='15566';
	break;
	case *taceno*:
	$id_del_tag='15567';
	break;
	case *torre de' busi*:
	$id_del_tag='15568';
	break;
	case *tremenico*:
	$id_del_tag='15569';
	break;
	case *valgreghentino*:
	$id_del_tag='15570';
	break;
	case *valmadrera*:
	$id_del_tag='15571';
	break;
	case *varenna*:
	$id_del_tag='15572';
	break;
	case *vendrogno*:
	$id_del_tag='15573';
	break;
	case *vercurago*:
	$id_del_tag='15574';
	break;
	case *verderio inferiore*:
	$id_del_tag='15575';
	break;
	case *verderio superiore*:
	$id_del_tag='15576';
	break;
	case *vestreno*:
	$id_del_tag='15577';
	break;
	case *viganò*:
	$id_del_tag='15578';
	break;
	case *abbadia cerreto*:
	$id_del_tag='15579';
	break;
	case *boffalora d'adda*:
	$id_del_tag='15580';
	break;
	case *borghetto lodigiano*:
	$id_del_tag='15581';
	break;
	case *borgo san giovanni*:
	$id_del_tag='15582';
	break;
	case *brembio*:
	$id_del_tag='15583';
	break;
	case *camairago*:
	$id_del_tag='15584';
	break;
	case *casaletto lodigiano*:
	$id_del_tag='15585';
	break;
	case *casalmaiocco*:
	$id_del_tag='15586';
	break;
	case *caselle landi*:
	$id_del_tag='15587';
	break;
	case *caselle lurani*:
	$id_del_tag='15588';
	break;
	case *castelnuovo bocca d'adda*:
	$id_del_tag='15589';
	break;
	case *castiglione d'adda*:
	$id_del_tag='15590';
	break;
	case *castiraga vidardo*:
	$id_del_tag='15591';
	break;
	case *cavacurta*:
	$id_del_tag='15592';
	break;
	case *cavenago d'adda*:
	$id_del_tag='15593';
	break;
	case *cervignano d'adda*:
	$id_del_tag='15594';
	break;
	case *codogno*:
	$id_del_tag='15595';
	break;
	case *comazzo*:
	$id_del_tag='15596';
	break;
	case *cornegliano laudense*:
	$id_del_tag='15597';
	break;
	case *corno giovine*:
	$id_del_tag='15598';
	break;
	case *cornovecchio*:
	$id_del_tag='15599';
	break;
	case *corte palasio*:
	$id_del_tag='15600';
	break;
	case *crespiatica*:
	$id_del_tag='15601';
	break;
	case *fombio*:
	$id_del_tag='15602';
	break;
	case *galgagnano*:
	$id_del_tag='15603';
	break;
	case *graffignana*:
	$id_del_tag='15604';
	break;
	case *guardamiglio*:
	$id_del_tag='15605';
	break;
	case *livraga*:
	$id_del_tag='15606';
	break;
	case *lodi vecchio*:
	$id_del_tag='15607';
	break;
	case *maccastorna*:
	$id_del_tag='15608';
	break;
	case *mairago*:
	$id_del_tag='15609';
	break;
	case *maleo*:
	$id_del_tag='15610';
	break;
	case *marudo*:
	$id_del_tag='15611';
	break;
	case *massalengo*:
	$id_del_tag='15612';
	break;
	case *meleti*:
	$id_del_tag='15613';
	break;
	case *merlino*:
	$id_del_tag='15614';
	break;
	case *montanaso lombardo*:
	$id_del_tag='15615';
	break;
	case *mulazzano*:
	$id_del_tag='15616';
	break;
	case *orio litta*:
	$id_del_tag='15617';
	break;
	case *ospedaletto lodigiano*:
	$id_del_tag='15618';
	break;
	case *ossago lodigiano*:
	$id_del_tag='15619';
	break;
	case *pieve fissiraga*:
	$id_del_tag='15620';
	break;
	case *salerano sul lambro*:
	$id_del_tag='15621';
	break;
	case *san fiorano*:
	$id_del_tag='15622';
	break;
	case *san martino in strada*:
	$id_del_tag='15623';
	break;
	case *san rocco al porto*:
	$id_del_tag='15624';
	break;
	case *sant'angelo lodigiano*:
	$id_del_tag='15625';
	break;
	case *santo stefano lodigiano*:
	$id_del_tag='15626';
	break;
	case *secugnago*:
	$id_del_tag='15627';
	break;
	case *senna lodigiana*:
	$id_del_tag='15628';
	break;
	case *somaglia*:
	$id_del_tag='15629';
	break;
	case *sordio*:
	$id_del_tag='15630';
	break;
	case *tavazzano con villavesco*:
	$id_del_tag='15631';
	break;
	case *terranova dei passerini*:
	$id_del_tag='15632';
	break;
	case *valera fratta*:
	$id_del_tag='15633';
	break;
	case *villanova del sillaro*:
	$id_del_tag='15634';
	break;
	case *zelo buon persico*:
	$id_del_tag='15635';
	break;
	case *bellaria-igea marina*:
	$id_del_tag='15636';
	break;
	case *coriano*:
	$id_del_tag='15637';
	break;
	case *gemmano*:
	$id_del_tag='15638';
	break;
	case *misano adriatico*:
	$id_del_tag='15639';
	break;
	case *mondaino*:
	$id_del_tag='15640';
	break;
	case *monte colombo*:
	$id_del_tag='15641';
	break;
	case *montefiore conca*:
	$id_del_tag='15642';
	break;
	case *montegridolfo*:
	$id_del_tag='15643';
	break;
	case *montescudo*:
	$id_del_tag='15644';
	break;
	case *morciano di romagna*:
	$id_del_tag='15645';
	break;
	case *poggio berni*:
	$id_del_tag='15646';
	break;
	case *riccione*:
	$id_del_tag='15647';
	break;
	case *saludecio*:
	$id_del_tag='15648';
	break;
	case *san clemente*:
	$id_del_tag='15649';
	break;
	case *san giovanni in marignano*:
	$id_del_tag='15650';
	break;
	case *santarcangelo di romagna*:
	$id_del_tag='15651';
	break;
	case *torriana*:
	$id_del_tag='15652';
	break;
	case *verucchio*:
	$id_del_tag='15653';
	break;
	case *cantagallo*:
	$id_del_tag='15654';
	break;
	case *carmignano*:
	$id_del_tag='15655';
	break;
	case *montemurlo*:
	$id_del_tag='15656';
	break;
	case *poggio a caiano*:
	$id_del_tag='15657';
	break;
	case *vaiano*:
	$id_del_tag='15658';
	break;
	case *vernio*:
	$id_del_tag='15659';
	break;
	case *belvedere di spinello*:
	$id_del_tag='15660';
	break;
	case *caccuri*:
	$id_del_tag='15661';
	break;
	case *carfizzi*:
	$id_del_tag='15662';
	break;
	case *casabona*:
	$id_del_tag='15663';
	break;
	case *castelsilano*:
	$id_del_tag='15664';
	break;
	case *cerenzia*:
	$id_del_tag='15665';
	break;
	case *cirò*:
	$id_del_tag='15666';
	break;
	case *cirò marina*:
	$id_del_tag='15667';
	break;
	case *cotronei*:
	$id_del_tag='15668';
	break;
	case *crucoli*:
	$id_del_tag='15669';
	break;
	case *melissa*:
	$id_del_tag='15670';
	break;
	case *mesoraca*:
	$id_del_tag='15671';
	break;
	case *pallagorio*:
	$id_del_tag='15672';
	break;
	case *petilia policastro*:
	$id_del_tag='15673';
	break;
	case *rocca di neto*:
	$id_del_tag='15674';
	break;
	case *roccabernarda*:
	$id_del_tag='15675';
	break;
	case *san mauro marchesato*:
	$id_del_tag='15676';
	break;
	case *san nicola dell'alto*:
	$id_del_tag='15677';
	break;
	case *santa severina*:
	$id_del_tag='15678';
	break;
	case *savelli*:
	$id_del_tag='15679';
	break;
	case *scandale*:
	$id_del_tag='15680';
	break;
	case *strongoli*:
	$id_del_tag='15681';
	break;
	case *umbriatico*:
	$id_del_tag='15682';
	break;
	case *verzino*:
	$id_del_tag='15683';
	break;
	case *acquaro*:
	$id_del_tag='15684';
	break;
	case *arena*:
	$id_del_tag='15685';
	break;
	case *briatico*:
	$id_del_tag='15686';
	break;
	case *brognaturo*:
	$id_del_tag='15687';
	break;
	case *capistrano*:
	$id_del_tag='15688';
	break;
	case *cessaniti*:
	$id_del_tag='15689';
	break;
	case *dasà*:
	$id_del_tag='15690';
	break;
	case *dinami*:
	$id_del_tag='15691';
	break;
	case *drapia*:
	$id_del_tag='15692';
	break;
	case *fabrizia*:
	$id_del_tag='15693';
	break;
	case *filadelfia*:
	$id_del_tag='15694';
	break;
	case *filandari*:
	$id_del_tag='15695';
	break;
	case *filogaso*:
	$id_del_tag='15696';
	break;
	case *francavilla angitola*:
	$id_del_tag='15697';
	break;
	case *francica*:
	$id_del_tag='15698';
	break;
	case *gerocarne*:
	$id_del_tag='15699';
	break;
	case *jonadi*:
	$id_del_tag='15700';
	break;
	case *joppolo*:
	$id_del_tag='15701';
	break;
	case *limbadi*:
	$id_del_tag='15702';
	break;
	case *maierato*:
	$id_del_tag='15703';
	break;
	case *mileto*:
	$id_del_tag='15704';
	break;
	case *mongiana*:
	$id_del_tag='15705';
	break;
	case *monterosso calabro*:
	$id_del_tag='15706';
	break;
	case *nardodipace*:
	$id_del_tag='15707';
	break;
	case *nicotera*:
	$id_del_tag='15708';
	break;
	case *parghelia*:
	$id_del_tag='15709';
	break;
	case *pizzo*:
	$id_del_tag='15710';
	break;
	case *pizzoni*:
	$id_del_tag='15711';
	break;
	case *polia*:
	$id_del_tag='15712';
	break;
	case *ricadi*:
	$id_del_tag='15713';
	break;
	case *rombiolo*:
	$id_del_tag='15714';
	break;
	case *san calogero*:
	$id_del_tag='15715';
	break;
	case *san costantino calabro*:
	$id_del_tag='15716';
	break;
	case *san gregorio d'ippona*:
	$id_del_tag='15717';
	break;
	case *san nicola da crissa*:
	$id_del_tag='15718';
	break;
	case *sant'onofrio*:
	$id_del_tag='15719';
	break;
	case *serra san bruno*:
	$id_del_tag='15720';
	break;
	case *simbario*:
	$id_del_tag='15721';
	break;
	case *sorianello*:
	$id_del_tag='15722';
	break;
	case *soriano calabro*:
	$id_del_tag='15723';
	break;
	case *spadola*:
	$id_del_tag='15724';
	break;
	case *spilinga*:
	$id_del_tag='15725';
	break;
	case *stefanaconi*:
	$id_del_tag='15726';
	break;
	case *vallelonga*:
	$id_del_tag='15727';
	break;
	case *vazzano*:
	$id_del_tag='15728';
	break;
	case *zaccanopoli*:
	$id_del_tag='15729';
	break;
	case *zambrone*:
	$id_del_tag='15730';
	break;
	case *zungri*:
	$id_del_tag='15731';
	break;
	case *antrona schieranco*:
	$id_del_tag='15732';
	break;
	case *anzola d'ossola*:
	$id_del_tag='15733';
	break;
	case *arizzano*:
	$id_del_tag='15734';
	break;
	case *arola*:
	$id_del_tag='15735';
	break;
	case *aurano*:
	$id_del_tag='15736';
	break;
	case *baceno*:
	$id_del_tag='15737';
	break;
	case *bannio anzino*:
	$id_del_tag='15738';
	break;
	case *baveno*:
	$id_del_tag='15739';
	break;
	case *bee*:
	$id_del_tag='15740';
	break;
	case *belgirate*:
	$id_del_tag='15741';
	break;
	case *beura-cardezza*:
	$id_del_tag='15742';
	break;
	case *bognanco*:
	$id_del_tag='15743';
	break;
	case *brovello-carpugnino*:
	$id_del_tag='15744';
	break;
	case *calasca-castiglione*:
	$id_del_tag='15745';
	break;
	case *cambiasca*:
	$id_del_tag='15746';
	break;
	case *cannero riviera*:
	$id_del_tag='15747';
	break;
	case *cannobio*:
	$id_del_tag='15748';
	break;
	case *caprezzo*:
	$id_del_tag='15749';
	break;
	case *casale corte cerro*:
	$id_del_tag='15750';
	break;
	case *cavaglio-spoccia*:
	$id_del_tag='15751';
	break;
	case *ceppo morelli*:
	$id_del_tag='15752';
	break;
	case *cesara*:
	$id_del_tag='15753';
	break;
	case *cossogno*:
	$id_del_tag='15754';
	break;
	case *craveggia*:
	$id_del_tag='15755';
	break;
	case *crevoladossola*:
	$id_del_tag='15756';
	break;
	case *crodo*:
	$id_del_tag='15757';
	break;
	case *cursolo-orasso*:
	$id_del_tag='15758';
	break;
	case *domodossola*:
	$id_del_tag='15759';
	break;
	case *druogno*:
	$id_del_tag='15760';
	break;
	case *falmenta*:
	$id_del_tag='15761';
	break;
	case *formazza*:
	$id_del_tag='15762';
	break;
	case *germagno*:
	$id_del_tag='15763';
	break;
	case *ghiffa*:
	$id_del_tag='15764';
	break;
	case *gignese*:
	$id_del_tag='15765';
	break;
	case *gravellona toce*:
	$id_del_tag='15766';
	break;
	case *gurro*:
	$id_del_tag='15767';
	break;
	case *intragna*:
	$id_del_tag='15768';
	break;
	case *loreglia*:
	$id_del_tag='15769';
	break;
	case *macugnaga*:
	$id_del_tag='15770';
	break;
	case *madonna del sasso*:
	$id_del_tag='15771';
	break;
	case *malesco*:
	$id_del_tag='15772';
	break;
	case *masera*:
	$id_del_tag='15773';
	break;
	case *massiola*:
	$id_del_tag='15774';
	break;
	case *mergozzo*:
	$id_del_tag='15775';
	break;
	case *miazzina*:
	$id_del_tag='15776';
	break;
	case *montecrestese*:
	$id_del_tag='15777';
	break;
	case *montescheno*:
	$id_del_tag='15778';
	break;
	case *nonio*:
	$id_del_tag='15779';
	break;
	case *oggebbio*:
	$id_del_tag='15780';
	break;
	case *ornavasso*:
	$id_del_tag='15781';
	break;
	case *pallanzeno*:
	$id_del_tag='15782';
	break;
	case *piedimulera*:
	$id_del_tag='15783';
	break;
	case *pieve vergonte*:
	$id_del_tag='15784';
	break;
	case *premeno*:
	$id_del_tag='15785';
	break;
	case *premia*:
	$id_del_tag='15786';
	break;
	case *premosello-chiovenda*:
	$id_del_tag='15787';
	break;
	case *quarna sopra*:
	$id_del_tag='15788';
	break;
	case *quarna sotto*:
	$id_del_tag='15789';
	break;
	case *re*:
	$id_del_tag='15790';
	break;
	case *san bernardino verbano*:
	$id_del_tag='15791';
	break;
	case *santa maria maggiore*:
	$id_del_tag='15792';
	break;
	case *seppiana*:
	$id_del_tag='15793';
	break;
	case *toceno*:
	$id_del_tag='15794';
	break;
	case *trarego viggiona*:
	$id_del_tag='15795';
	break;
	case *trasquera*:
	$id_del_tag='15796';
	break;
	case *trontano*:
	$id_del_tag='15797';
	break;
	case *valstrona*:
	$id_del_tag='15798';
	break;
	case *vanzone con san carlo*:
	$id_del_tag='15799';
	break;
	case *varzo*:
	$id_del_tag='15800';
	break;
	case *viganella*:
	$id_del_tag='15801';
	break;
	case *vignone*:
	$id_del_tag='15802';
	break;
	case *villadossola*:
	$id_del_tag='15803';
	break;
	case *villette*:
	$id_del_tag='15804';
	break;
	case *aggius*:
	$id_del_tag='15805';
	break;
	case *aglientu*:
	$id_del_tag='15806';
	break;
	case *alà dei sardi*:
	$id_del_tag='15807';
	break;
	case *arzachena*:
	$id_del_tag='15808';
	break;
	case *badesi*:
	$id_del_tag='15809';
	break;
	case *berchidda*:
	$id_del_tag='15810';
	break;
	case *bortigiadas*:
	$id_del_tag='15811';
	break;
	case *buddusò*:
	$id_del_tag='15812';
	break;
	case *budoni*:
	$id_del_tag='15813';
	break;
	case *calangianus*:
	$id_del_tag='15814';
	break;
	case *golfo aranci*:
	$id_del_tag='15815';
	break;
	case *loiri porto san paolo*:
	$id_del_tag='15816';
	break;
	case *luogosanto*:
	$id_del_tag='15817';
	break;
	case *luras*:
	$id_del_tag='15818';
	break;
	case *monti*:
	$id_del_tag='15819';
	break;
	case *oschiri*:
	$id_del_tag='15820';
	break;
	case *padru*:
	$id_del_tag='15821';
	break;
	case *palau*:
	$id_del_tag='15822';
	break;
	case *santa teresa gallura*:
	$id_del_tag='15823';
	break;
	case *sant'antonio di gallura*:
	$id_del_tag='15824';
	break;
	case *telti*:
	$id_del_tag='15825';
	break;
	case *trinità d'agultu e vignola*:
	$id_del_tag='15826';
	break;
	case *arzana*:
	$id_del_tag='15827';
	break;
	case *bari sardo*:
	$id_del_tag='15828';
	break;
	case *baunei*:
	$id_del_tag='15829';
	break;
	case *cardedu*:
	$id_del_tag='15830';
	break;
	case *elini*:
	$id_del_tag='15831';
	break;
	case *gairo*:
	$id_del_tag='15832';
	break;
	case *girasole*:
	$id_del_tag='15833';
	break;
	case *ilbono*:
	$id_del_tag='15834';
	break;
	case *jerzu*:
	$id_del_tag='15835';
	break;
	case *lanusei*:
	$id_del_tag='15836';
	break;
	case *loceri*:
	$id_del_tag='15837';
	break;
	case *lotzorai*:
	$id_del_tag='15838';
	break;
	case *osini*:
	$id_del_tag='15839';
	break;
	case *perdasdefogu*:
	$id_del_tag='15840';
	break;
	case *seui*:
	$id_del_tag='15841';
	break;
	case *talana*:
	$id_del_tag='15842';
	break;
	case *tertenia*:
	$id_del_tag='15843';
	break;
	case *tortolì*:
	$id_del_tag='15844';
	break;
	case *triei*:
	$id_del_tag='15845';
	break;
	case *ulassai*:
	$id_del_tag='15846';
	break;
	case *urzulei*:
	$id_del_tag='15847';
	break;
	case *ussassai*:
	$id_del_tag='15848';
	break;
	case *villagrande strisaili*:
	$id_del_tag='15849';
	break;
	case *barumini*:
	$id_del_tag='15850';
	break;
	case *collinas*:
	$id_del_tag='15851';
	break;
	case *furtei*:
	$id_del_tag='15852';
	break;
	case *genuri*:
	$id_del_tag='15853';
	break;
	case *gesturi*:
	$id_del_tag='15854';
	break;
	case *gonnosfanadiga*:
	$id_del_tag='15855';
	break;
	case *guspini*:
	$id_del_tag='15856';
	break;
	case *las plassas*:
	$id_del_tag='15857';
	break;
	case *lunamatrona*:
	$id_del_tag='15858';
	break;
	case *pabillonis*:
	$id_del_tag='15859';
	break;
	case *pauli arbarei*:
	$id_del_tag='15860';
	break;
	case *samassi*:
	$id_del_tag='15861';
	break;
	case *san gavino monreale*:
	$id_del_tag='15862';
	break;
	case *sanluri*:
	$id_del_tag='15863';
	break;
	case *sardara*:
	$id_del_tag='15864';
	break;
	case *segariu*:
	$id_del_tag='15865';
	break;
	case *serramanna*:
	$id_del_tag='15866';
	break;
	case *serrenti*:
	$id_del_tag='15867';
	break;
	case *setzu*:
	$id_del_tag='15868';
	break;
	case *siddi*:
	$id_del_tag='15869';
	break;
	case *tuili*:
	$id_del_tag='15870';
	break;
	case *turri*:
	$id_del_tag='15871';
	break;
	case *ussaramanna*:
	$id_del_tag='15872';
	break;
	case *villacidro*:
	$id_del_tag='15873';
	break;
	case *villamar*:
	$id_del_tag='15874';
	break;
	case *villanovaforru*:
	$id_del_tag='15875';
	break;
	case *villanovafranca*:
	$id_del_tag='15876';
	break;
	case *buggerru*:
	$id_del_tag='15877';
	break;
	case *calasetta*:
	$id_del_tag='15878';
	break;
	case *carloforte*:
	$id_del_tag='15879';
	break;
	case *domusnovas*:
	$id_del_tag='15880';
	break;
	case *fluminimaggiore*:
	$id_del_tag='15881';
	break;
	case *giba*:
	$id_del_tag='15882';
	break;
	case *gonnesa*:
	$id_del_tag='15883';
	break;
	case *masainas*:
	$id_del_tag='15884';
	break;
	case *musei*:
	$id_del_tag='15885';
	break;
	case *narcao*:
	$id_del_tag='15886';
	break;
	case *nuxis*:
	$id_del_tag='15887';
	break;
	case *perdaxius*:
	$id_del_tag='15888';
	break;
	case *piscinas*:
	$id_del_tag='15889';
	break;
	case *san giovanni suergiu*:
	$id_del_tag='15890';
	break;
	case *santadi*:
	$id_del_tag='15891';
	break;
	case *sant'anna arresi*:
	$id_del_tag='15892';
	break;
	case *sant'antioco*:
	$id_del_tag='15893';
	break;
	case *tratalias*:
	$id_del_tag='15894';
	break;
	case *villamassargia*:
	$id_del_tag='15895';
	break;
	case *villaperuccio*:
	$id_del_tag='15896';
	break;
	case *samone*:
	$id_del_tag='15897';
	break;
	case *calliano*:
	$id_del_tag='15898';
	break;
	case *castro*:
	$id_del_tag='15899';
	break;
	case *brione*:
	$id_del_tag='15900';
	break;
	case *livo*:
	$id_del_tag='15901';
	break;
	case *peglio*:
	$id_del_tag='15902';
	break;
	case *valverde*:
	$id_del_tag='15903';
	break;
	case *san teodoro*:
	$id_del_tag='15904';
	break;
	case *ministero dell' istruzione, dell' universita' e della ricerca*:
	$id_del_tag='8163';
	break;
	
	default:
	$id_del_tag='-1';
	
	
      }

      return $id_del_tag;	  
} 

function normalize_tag($teseo_appoggio) {
      $teseo_appoggio=strtolower($teseo_appoggio);
      if (substr_count($teseo_appoggio,'- prov')>0) {
      	$nome_del_tag=explode('- prov',$teseo_appoggio);
      	$nome_del_tag=*provincia di *.trim($nome_del_tag[0]);
      	return $nome_del_tag;
      }	
      else return $teseo_appoggio;
}
      
?>";

$arr1=array(41,
44,
87,
154,
160,
182,
216,
218,
228,
229,
232,
242,
253,
258,
260,
262,
273,
279,
312,
315,
323,
326,
347,
348,
367,
379,
414,
421,
454,
475,
486,
498,
502,
508,
511,
519,
529,
539,
540,
544,
555,
559,
585,
599,
603,
623,
632,
649,
666,
672,
676,
678,
679,
692,
711,
727,
731,
732,
742,
755,
761,
775,
776,
778,
781,
784,
788,
799,
820,
833,
865,
900,
920,
933,
940,
944,
961,
963,
978,
979,
997,
999,
1005,
1006,
1011,
1015,
1025,
1040,
1043,
1084,
1153,
1172,
1221,
1222,
1236,
1244,
1245,
1253,
1260,
1261,
1262,
1303,
1305,
1320,
1327,
1344,
1347,
1388,
1396,
1406,
1416,
1485,
1492,
1496,
1513,
1525,
1537,
1539,
1543,
1565,
1567,
1568,
1582,
1587,
1590,
1591,
1593,
1644,
1648,
1667,
1670,
1684,
1692,
1736,
1762,
1764,
1765,
1787,
1789,
1792,
1805,
1811,
1843,
1852,
1853,
1872,
1909,
2224,
2225,
2230,
2375,
4245,
4252,
4275,
4279,
4287,
4403,
4422,
4440,
4468,
4495,
4598,
4599,
4628,
4630,
4666,
4694,
4698,
4739,
4744,
4781,
4797,
4798,
4803,
4808,
4853,
4888,
4897,
4933,
4961,
4984,
5000,
5101,
5118,
5132,
5152,
5179,
5185,
5222,
5245,
5261,
5269,
5304,
5315,
5332,
5368,
5384,
5387,
5388,
5487,
5506,
5525,
5535,
5550,
5588,
5595,
5597,
5598,
5650,
5732,
5734,
5767,
5773,
5779,
5781,
5805,
5917,
5939,
5977,
5980,
5995,
6036,
6047,
6063,
6090,
6096,
6103,
6106,
6171,
6192,
6225,
6258,
6370,
6378,
6422,
6512,
6522,
6523,
6525,
6529,
6608,
6670,
6678,
6695,
6780,
6803,
6826,
6879,
6887,
6900,
6958,
7010,
7162,
7194,
7229,
7232,
7262,
7354,
7386,
7422,
7473,
7476,
7707,
7746,
7809,
7889,
8016);

$arr2=array(40,
5,
116,
153,
130,
238,
207,
151,
207,
206,
206,
5561,
7726,
1581,
1578,
1578,
5320,
1519,
7245,
4657,
321,
325,
1372,
325,
4319,
15,
130,
130,
325,
325,
487,
497,
504,
512,
4474,
1089,
547,
547,
547,
547,
1649,
4618,
4357,
4357,
4357,
4357,
4357,
4690,
653,
674,
675,
1788,
1799,
1535,
785,
5799,
710,
5760,
7977,
40,
1864,
774,
779,
779,
792,
785,
5389,
802,
5073,
5001,
852,
854,
4763,
939,
1707,
939,
939,
1611,
1002,
939,
1009,
1002,
5389,
5389,
1284,
1013,
4357,
939,
939,
151,
952,
1158,
1191,
1191,
1257,
4264,
6734,
2271,
4989,
4989,
845,
1373,
5351,
1325,
487,
562,
7304,
1314,
1394,
1112,
1298,
1461,
1461,
1372,
1499,
1535,
1535,
1542,
1542,
4319,
5186,
5162,
1578,
1578,
1578,
11,
1535,
653,
2307,
653,
5870,
4357,
1760,
1760,
1760,
1760,
1760,
4448,
1788,
1788,
661,
1807,
6269,
1851,
1851,
1864,
710,
296,
296,
5351,
565,
4989,
561,
1851,
7306,
1773,
5351,
383,
6474,
1338,
724,
325,
845,
1633,
1631,
1629,
1373,
661,
1627,
523,
130,
838,
6009,
5162,
675,
1662,
521,
4674,
5073,
1021,
1137,
5073,
5351,
1864,
1716,
836,
4729,
1854,
4536,
752,
517,
5336,
561,
6812,
845,
547,
7734,
1679,
7672,
1833,
1073,
1622,
1338,
4264,
5370,
5561,
5037,
523,
517,
6987,
724,
4690,
6121,
587,
505,
1519,
7982,
325,
4305,
5626,
4690,
857,
1812,
752,
1584,
576,
1425,
911,
4280,
207,
2250,
1546,
892,
1519,
1812,
1812,
1056,
1137,
15,
1517,
1685,
708,
708,
653,
6474,
235,
1812,
1854,
772,
1773,
587,
1760,
1851,
4388,
5326,
9,
779,
4357,
4936,
1623,
23,
7890,
523,
4585,
752,
1760,
2210);

echo count($arr1)." ".count($arr2);

for ($x=0;$x<count($arr1);$x++) {

$testo=str_replace($arr1[$x],$arr2[$x],$testo);

}

echo $testo;

?> 
