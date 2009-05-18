<?php switch ($titolo_wiki) {
    case "cosa sono i disegni di legge":
        $link_wikipedia="http://it.wikipedia.org/wiki/Progetto_di_legge";
        $glossario="Il disegno (o progetto o proposta) di legge (DDL) &egrave; un testo suddiviso in articoli che viene presentato alla Camera o al Senato per essere esaminato, discusso e votato e infine per diventare legge. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono i decreti legge":
        $link_wikipedia="http://it.wikipedia.org/wiki/Decreto_legge";
        $glossario="Il decreto legge (abbreviato D.L.) &egrave; un provvedimento provvisorio che ha lo stesso valore di una legge e viene assunto dal Governo in casi straordinari di necessit&agrave; ed urgenza. Scade dopo 60 giorni se non viene convertito in legge dal Parlamento. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono i decreti legislativi":
        $link_wikipedia="http://it.wikipedia.org/wiki/Decreto_legislativo";
        $glossario="Il decreto legislativo (abbreviato con Dlgs.) o decreto delegato (DLG.) &egrave; un atto che ha lo stesso valore di una legge che viene emanato dal Governo per regolare una determinata questione sulla base delle condizioni e dei limiti stabiliti dal Parlamento con un'apposita legge delega. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono le mozioni":
        $link_wikipedia="http://it.wikipedia.org/wiki/Mozione_parlamentare";
        $glossario="E' uno strumento attraverso cui la Camera o il Senato rivolgono direttive e indicazioni al Governo su come affrontare una determinata questione. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono le interpellanze":
        $link_wikipedia="http://it.wikipedia.org/wiki/Interpellanza_parlamentare";
        $glossario="L'interpellanza &egrave; una domanda scritta che uno o pi&ugrave; parlamentari rivolgono al Governo per avere spiegazioni sull'azione politica del Governo (misure adottate o da adottare) su una determinata questione. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono le interrogazioni a risposta orale":
        $link_wikipedia="http://it.wikipedia.org/wiki/Interrogazione_parlamentare";
        $glossario="L'interrogazione a risposta orale &egrave; una domanda - con richiesta che la risposta venga fornita oralmente - che uno o pi&ugrave; parlamentari rivolgono al Governo per sapere se un dato fatto sia vero, se il Governo abbia informazioni in merito e se intenda adottare dei provvedimenti. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break; 
    case "cosa sono le interrogazioni a risposta scritta":
        $link_wikipedia="http://it.wikipedia.org/wiki/Interrogazione_parlamentare";
        $glossario="L'interrogazione a risposta scritta &egrave; una domanda - con richiesta che la risposta venga fornita per iscritto - che uno o pi&ugrave; parlamentari rivolgono al Governo per sapere se un dato fatto sia vero, se il Governo abbia informazioni in merito e se intenda adottare dei provvedimenti. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono le interrogazioni in commissione":
        $link_wikipedia="http://it.wikipedia.org/wiki/Interrogazione_parlamentare";
        $glossario="L'interrogazione a risposta in commissione &egrave; una domanda - con richiesta che la risposta venga fornita in una determinata Commissione - che uno o pi&ugrave; parlamentari rivolgono al Governo per sapere se un dato fatto sia vero, se il Governo abbia informazioni in merito e se intenda adottare dei provvedimenti. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break; 
    case "cosa sono le risoluzioni in assemblea":
        $link_wikipedia="http://it.wikipedia.org/wiki/Risoluzione_(Parlamento)";
        $glossario="E' un atto attraverso cui al termine di un dibattito in Aula (Assemblea) di Camera o Senato vengono discusse e votate le direttive politiche per il Governo sulle questioni che sono state discusse. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono le risoluzioni in commissione":
        $link_wikipedia="http://it.wikipedia.org/wiki/Risoluzione_(Parlamento)";
        $glossario="E' un atto attraverso cui al termine di un dibattito in una Commissione parlamentare vengono discusse e votate le direttive politiche per il Governo sulle questioni che sono state discusse. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break; 
    case "cosa sono le risoluzioni conclusive":
        $link_wikipedia="http://it.wikipedia.org/wiki/Risoluzione_(Parlamento)";
        $glossario=" (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;     
    case "cosa sono gli ordini del giorno in assemblea":
        $link_wikipedia="";
        $glossario="E' un atto attraverso cui durante l'approvazione di un testo di legge (o mozione, o risoluzione) vengono date istruzioni al Governo sul modo di interpretare il testo o di dargli applicazione. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;   
    case "cosa sono gli ordini del giorno in commissione":
        $link_wikipedia="";
        $glossario="E' un atto attraverso cui durante l'approvazione di un testo di legge (o mozione, o risoluzione) vengono date istruzioni al Governo sul modo di interpretare il testo o di dargli applicazione. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break; 
    case "cosa sono i comunicati del governo":
        $link_wikipedia="";
        $glossario="Sono i comunicati stampa che il governo rilascia per comunicare la propria attivit&agrave; in occasione, per esempio, di un consiglio dei ministri. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    case "cosa sono le audizioni":
        $link_wikipedia="http://it.wikipedia.org/wiki/Audizione_parlamentare";
        $glossario="L'Auduzione &egrave; la modalit&agrave; attraverso la quale una Commissione parlamentare pu&ograve; ottenere informazioni su materie di propria competenza convocando e ascoltando membri del Governo, esperti esterni, rappresentanti di categoaria, etc. (approfondisci su: <a href='".$link_wikipedia."'>Wikipedia</a>)";
         break;
    default:
        $link_wikipedia="";
        $glossario="";
         break;                                                                                                                            
}
?>

<p class="tools-container"><?php echo link_to($titolo_wiki, '#', array( 'class'=>'ico-help')) ?></p>
<div class="help-box float-container" style="display: none;">
  <div class="inner float-container">
    <div class="go-wikipedia">
      <?php echo link_to('approfondisci su<br />'.image_tag('ico-wikipedia.png', array('alt' => 'wikipedia').'<strong>Wikipedia</strong>'), $link_wikipedia) ?>
    </div>
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close')) ?>
    <h5><?php echo $titolo_wiki ?> ?</h5>
    <p><?php echo $glossario ?></p>
  </div>
</div>