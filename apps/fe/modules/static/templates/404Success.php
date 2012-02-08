<div class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container">
      <li class="current">
        <h2>
          Pagina non trovata
        </h2>
      </li>
    </ul>
</div>

<div class="row">
	<div class="twelvecol">
		<h3 style="color: #f00; padding: 1em 0;">OOPS! La pagina richiesta non &egrave; stata trovata.</h3>
		<p>Potresti aver digitato un indirizzo errato, oppure aver fatto click su un link esterno non corretto.</p>

	    	<p>Puoi aiutarci, <a href="/contatti" style="color: orange">contattandoci</a> per comunicare cosa stavi facendo quando si &egrave; verificato l'errore.</p>

	    	<p>Altrimenti, puoi <a href="#" style="color: orange" onclick="javascript:back(); return false;">tornare alla pagina che stavi visitando</a> prima di questo errore.</p>

	    	<p>Infine, puoi sempre tornare alla <a href="/" style="color: orange">home page</a> di <em class="open">open</em><em class="parlamento">parlamento</em>.</p>
		
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  pagina non trovata
<?php end_slot() ?>