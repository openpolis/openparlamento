<ul id="content-tabs" class="float-container tools-container"> 
  <li class="current">
    <h2>
      Che posso fare con <em class="open">open</em><em class="parlamento">parlamento</em>?
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">

  <div id="main"> 
  <p style="font-size:14px;">vhjdevjvdjvjevjfvjfrvjfvjrfv fdygfdgf cvshf csdfd </p>
   <div class="W100_100">
   <h3 class="subsection">informati</h3>
   <h4>Decreti, disegni di legge e atti non legislativi</h4>
   <div class="float-right" style="width:30%;">
   <?php echo image_tag( '/images/screenshot/atti.png',array('width'=>'250px')) ?>
   </div>
   <div class="W100_100">
   <div class="float-left" style="width:65%;">
   
   Su <em class="open">open</em><em class="parlamento">parlamento</em> puoi  liberamente consultare tutti gli atti discussi e prodotti dalla Camera dei Deputati e dal Senato della Repubblica.<br>
   Attraverso l'utilizzo di opzioni di ricerca e di filtri viene agevolata la navigazione negli atti legislativi (disegni di legge, decreti legge, decreti legislativi ) e in quelli non legislativi (mozioni,interrogazioni, interpellanze, ordini del giorno, ... ).
   
  </div>
  <div class="float-right" style="width:65%;">
    Per ogni atto è disponibile il testo, lo stato di avanzamento dell'iter legislativo, informazioni sui firmatari, sui relatori e votazioni.
  </div>
   <div class="float-left" style="width:30%;">
   <?php echo image_tag( '/images/screenshot/iter.png',array('width'=>'250px')) ?>  
   </div>
   
   </div>
   <div class="W100_100">
   
    <h4>Parlamentari</h4>
    <p>
    Ogni parlamentare ( deputato o senatore ) ha una propria scheda riepilogativa della sua attivit&agrave;. <br />
    Oltre i dati sulla sua elezione sono disponibili tutte le informazioni sulle presenze (presenze, assenze, missioni) e sulla sua azione parlamentare (atti presentati,  firmati o co-firmati, tutti voti e gli interventi).
    </p>
    <p>
   <?php echo image_tag( '/images/screenshot/pol_presenze.png') ?>   
    </p>
    <p>
    Inoltre puoi consultare gli argomenti di cui il parlamentare si occupa maggiormente, i parlamentati con cui pi&ugrave; spesso firma gli atti, e il suo indice di attivit&agrave;.
    </p>
    <p>
    <?php echo image_tag( '/images/screenshot/votapiuspesso.png') ?>   
    </p>
    
  </div>
  
  <div class="W100_100">
   
   <h4>Votazioni</h4>
   <p>
   Sono a tua disposizione tutte le informazioni su ogni votazione elettronica d'aula avvenuta alla Camera dei Deputati o al Senato della Repubblica.<br />
   L'esito della votazione, la posizione dei gruppi parlamentati e il voto di ogni parlamentare.
   Inoltre puoi visualizzare i "parlamentari ribelli" che votano in modo difforme dalla posizione del gruppo parlamentare di appartenenza.
   </p>
   <p>
    <?php echo image_tag( '/images/screenshot/votazione.png') ?>   
     <?php echo image_tag( '/images/screenshot/presenti_votazioni.png') ?>   
   </p>
   
   </div>
   </div>
    <div class="W100_100"> 
    <h3 class="subsection">monitora</h3>
     <h4>Parlamentari</h4>
     <p>
     Attraverso lo strumento del monitoraggio, puoi seguire l'attività del singolo parlamentare nel tempo, e ricevere avvisi ogni qual volta compie un'azione ( presenta un atto, effettua una votazione, interviene, etc).
     </p>
     <p>
     <?php echo image_tag( '/images/screenshot/monitoraggio.png') ?> 
     </p>
    <h4>Atti</h4>
     <p>
     Attraverso lo strumento del monitoraggio, puoi seguire le vicende di un atto durante tutto il suo iter parlamentare e ricevere avvisi  ad ogni passaggio o evento di rilievo: nuove firme, voti, interventi, risposte alle interrogazioni, etc.
     </p>
     <h4>Argomenti</h4>
     <p>
     Tutti gli atti presenti su <em class="open">open</em><em class="parlamento">parlamento</em>  vengono elaborati e classificati dalla nostra redazione e quindi associati ad uno o più argomenti.
     In questo modo, seguendo un argomento si monitoreranno tutti gli atti (legislativi e non legislativi )  associati a quell'argomento .
     </p>
     <p>
     <?php echo image_tag( '/images/screenshot/arg_cerca.png') ?> 
     </p>
     
   </div>
   
    <div class="W100_100">
     <h3 class="subsection">intervieni </h3>
   </div>  
  
  
  
  
  
  
  </div>
</div>  

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  cosa posso fare con openparlamento?
<?php end_slot() ?> 