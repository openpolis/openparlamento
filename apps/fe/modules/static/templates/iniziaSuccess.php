<ul id="content-tabs" class="float-container tools-container"> 
  <li class="current">
    <h2>
      Che posso fare con <em class="open">open</em><em class="parlamento">parlamento</em>?
    </h2>
  </li>
</ul>

<div class="row">
	<div class="fourcol">
		
		<div style="padding:7px;">
		  <h1><em class="parlamento">informati</em></h1>
		    <br />
		  Su openparlamento puoi liberamente consultare <em class="open" style="font-size:16px;"><strong><?php echo link_to('tutti gli atti','@attiDisegni') ?></strong></em> discussi e prodotti dalla Camera e dal Senato.<br />
		  Attraverso l'utilizzo di opzioni di ricerca e di filtri viene agevolata la navigazione degli atti legislativi (disegni di legge, decreti legge, decreti legislativi ) e di quelli non legislativi (mozioni,interrogazioni, interpellanze, ordini del giorno ... ).<br />
		  <br />
		  <?php echo image_tag('/images/screenshot/ddl1.png') ?>
		  <br /><br />
		  Per ogni atto &egrave; disponibile il testo, lo stato di avanzamento dell'iter legislativo, informazioni sui firmatari, sui relatori e votazioni.<br />
		  <br />
		  <?php echo image_tag('/images/screenshot/iter.png') ?>
		  <br /><br />
		  <em class="open" style="font-size:16px;"><strong><?php echo link_to('Tutti i parlamentari','/parlamentari/camera/nome/asc') ?></strong></em> hanno una propria scheda riepilogativa delle attivit&agrave; svolte.<br />
		  Oltre ai dati relativi alla elezione, sono disponibili tutte le informazioni su presenze, assenze, missioni, atti presentati, voti e interventi.<br />
		  Inoltre sono disponibili gli argomenti di cui il parlamentare si occupa, il suo indice di attivit&agrave; ed i parlamentari pi&ugrave; vicini, che votano e firmano gli stessi atti.<br />
		   <br />
		  <?php echo image_tag('/images/screenshot/politico.png') ?>
		  <br /><br />
		  Sono a tua disposizione tutte le informazioni su <em class="open" style="font-size:16px;"><strong><?php echo link_to('ogni votazione','/votazioni/data/desc') ?></strong></em> avvenuta alla Camera e al Senato.<br />
		  L'esito della votazione, la posizione dei gruppi e il voto di ogni parlamentare.<br />
		  Inoltre puoi controllare i "parlamentari ribelli", quelli votano in modo difforme dalla posizione del gruppo di appartenenza.<br />
		  <br />

		  </div>
		
	</div>
	<div class="fourcol">
		
		<div style="padding:7px;">
		  <h1><em class="parlamento">monitora</em></h1>
		 <br />
		  Attraverso lo strumento del monitoraggio, puoi seguire costantemente <em class="open" style="font-size:16px;"><strong>l'attivit&agrave; del singolo parlamentare</strong></em>, ricevere avvisi ogni qual volta compie un'azione (presenta un atto, effettua una votazione, interviene, etc).<br />
		  <br />
		  <?php echo image_tag('/images/screenshot/monitoraggio.png') ?>
		  <br /><br />
		  Puoi inoltre seguire le vicende di <em class="open" style="font-size:16px;"><strong>qualsiasi atto</strong></em> durante tutto il suo iter parlamentare e ricevere avvisi ad ogni passaggio o evento di rilievo: nuove firme, votazioni, interventi, passaggi di iter, etc.<br />
		  Tutti gli atti presenti su openparlamento vengono elaborati e classificati dalla nostra redazione ed associati ad uno o pi&ugrave; argomenti.
		  In questo modo, seguendo un <em class="open" style="font-size:16px;"><strong><?php echo link_to('argomento','@argomenti') ?></strong></em> si monitoreranno tutti gli atti ad esso associati.<br />
		  <br /><br />
		  Ogni giorno riceverai aggiornamenti personalizzati su tutto quello che ti interessa nelle <em class="open" style="font-size:16px;"><strong>tue pagine personali</strong></em> di openparlamento e nella <em class="open" style="font-size:16px;"><strong>tua e-mail</strong></em>.<br />
		   <br />
		  <?php echo image_tag('/images/screenshot/mie_notizie.png') ?>
		  <br /><br />
		  </div>
		
	</div>
	<div class="fourcol last">
		
		<div style="padding:7px;">
		  <h1><em class="parlamento">intervieni</em></h1>
		  <br />
		  Puoi <em class="open" style="font-size:16px;"><strong>votare</strong></em> qualsiasi atto presentato e discusso alla Camera e al Senato.<br />
		  Con un semplice click puoi dichiararti "favorevole" o "contrario" rispetto ad un atto.<br />
		   <br />
		  <?php echo image_tag('/images/screenshot/vota.png') ?>
		  <br /><br />
		  Contribuisci a <em class="open" style="font-size:16px;"><strong>descrivere ogni atto o votazione</strong></em> in modo da favorirne la conoscenza da parte di tutti.
		  Viene utilizzato un sistema wiki che permette di scrivere testi e di modificare quelli scritti da altri utenti.<br />
		  <br />
		  <?php echo image_tag('/images/screenshot/wiki.png') ?>
		  <br /><br />
		  Puoi <em class="open" style="font-size:16px;"><strong>commentare ogni atto</strong></em> presente su openparlamento.
		  Utilizza questo strumento per condividere con gli altri utenti i tuoi giudizi, le tue valutazione e le tue riflessioni sugli atti che reputi importanti e interessanti o anche che hanno solo attirato la tua attenzione.
		  <br />
		  Aggiungi direttamente <em class="open" style="font-size:16px;"><strong>le tue note sui testi degli atti</strong></em> presentati alla Camera e al Senato.
		  Infatti, con strumenti semplici ed intuitivi, puoi visionare il contenuto di un documento e selezionarne una parte a cui abbinare un testo scritto da te, che pu&ograve; essere un commento o anche una sorta di emendamento del testo ufficiale.<br />
		   <br />
		  <?php echo image_tag('/images/screenshot/emend-help.png') ?>
		  <br />


		  </div>
		
	</div>
</div> 

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  cosa posso fare con openparlamento?
<?php end_slot() ?> 