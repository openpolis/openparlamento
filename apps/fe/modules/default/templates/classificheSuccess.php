<?php 
if ( sfRouting::getInstance()->getCurrentRouteName() == 'default_symfony' ) {
	slot('force_canonical');
	echo "\n<link rel=\"canonical\" href=\"". url_for('@classifiche_parlamento', true) ."\" />";
	end_slot();
}
?>
<div class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container">
      <li class="current">
        <h2>
          <?php echo "Le classifiche" ?>  
        </h2>
      </li>
    </ul>
</div>

<div class="row">
	<div class="twelvecol">
		
		<div style="padding:5px; width:73%;"> 
		   <p class="tools-container"><a class="ico-help" href="#">come sono calcolate le classifiche</a></p>
		  		<div style="display: none;" class="help-box float-container">
		  			<div class="inner float-container">

		  				<a class="ico-close" href="#">chiudi</a><h5>come sono calcolate le classifiche ?</h5>
		  				<p>I dati sulle <strong>presenze</strong> e <strong>assenze</strong> si riferiscono alle votazioni elettroniche che si svolgono nell'Assemblea di Camera e Senato dall'inizio della legislatura. I dati dunque si riferiscono solo al totale delle presenze e assenze nelle votazioni elettroniche in Aula. Con assenza si intendono i casi di non partecipazione al voto: sia quello in cui il parlamentare è fisicamente assente (e non in missione) sia quello in cui è presente ma non vota. Purtroppo attualmente i sistemi di documentazione dei resoconti di Camera e Senato non consentono di distinguere un caso dall'altro. I regolamenti non prevedono la registrazione del motivo dell'assenza al voto del parlamentare. Non si può distinguere, pertanto, l'assenza ingiustificata da quella, ad esempio, per ragioni di salute. <br />
		  				  Il nuovo indice di produttivit&agrave; prende in esame il numero, la tipologia, il consenso e l'iter degli atti presentati dai parlamentari in modo da poterli confrontare tra di loro. <strong>Per la descrizione dettagliata della metodologia di valutazione <a href="http://indice.openpolis.it/info.html">vai qui</a>.</strong><br />
		  				  Un parlamentare &egrave; considerato <strong>ribelle</strong> quando esprime un voto diverso da quello del gruppo parlamentare a cui appartiene. Si tratta di un indicatore puramente quantitativo del grado di ribellione alla "disciplina" del gruppo.

		  				</p>
		  			</div>
		  		</div>
		   </div>
		
	</div>
</div>

<div class="row">
	<div class="sixcol">
		
		<h1 class="bluebox">deputati</h1>
	    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'1','limit'=>'3')); ?>
	     <hr class="bluebox" />
	    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'2','limit'=>'3')); ?>
	     <hr class="bluebox" />
	    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'3','limit'=>'3')); ?>
	     <hr class="bluebox" />
	    <?php //echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'5','limit'=>'3')); ?>
	   <!--  <hr class="bluebox" /> -->
	    <?php echo include_component('default','classifiche', array('ramo'=>'1', 'classifica'=>'4','limit'=>'3')); ?>
		
	</div>
	<div class="sixcol last">
		
		<h1 class="redbox">senatori</h1>
		    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'1','limit'=>'3')); ?>
		    <hr class="redbox" />
		    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'2','limit'=>'3')); ?>
		    <hr class="redbox" />
		    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'3','limit'=>'3')); ?>
		    <hr class="redbox" />
		    <?php //echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'5','limit'=>'3')); ?>
		  <!--  <hr class="redbox" /> -->
		    <?php echo include_component('default','classifiche', array('ramo'=>'2', 'classifica'=>'4','limit'=>'3')); ?>
		
	</div>
</div>

  
  <?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
    le classifiche  
<?php end_slot() ?>
