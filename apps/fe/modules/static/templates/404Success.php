<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Pagina non trovata
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">

  <div id="main"> 
   
    <div class="W73_100 float-left">
      <p>
        La pagina richiesta non &egrave; stata trovata. <br/>
        Potresti aver digitato un indirizzo errato, oppure aver fatto click su un link esterno non corretto.
      </p>
      <p>&nbsp;</p>
      <p>Se vuoi segnalarci un <b>malfunzionamento</b>, <?php echo link_to('contattaci', '@contatti') ?> </p>
      <p>&nbsp;</p>
      <p>Torna alla, <?php echo link_to('Home page', '@homepage') ?> </p>
      <p>&nbsp;</p>
      
    </div>
  </div>

</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  pagina non trovata
<?php end_slot() ?>