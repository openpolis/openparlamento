<div id="content" class="float-container" style="margin-top: 5px">
  <div id="main" style="padding: 50px 0">
    <h2>Vuoi monitorare di pi&ugrave;?</h2>
    
    <?php if (!$sf_user->hasCredential('premium')): ?>
      <div id="left-box" style="margin: 0">
        <h3>Diventa un sottoscrittore <strong>Premium</strong>, ora!</h3>

        <p>Sottoscrivendo l'offerta Premium, potrai monitorare fino a <br/>
          <b>quindici token</b> e 
          <b>cinque argomenti</b> <i>gratuitamente</i> fino al 15 ottobre.
        </p>

        <div class="bottone" style="margin-top: 20px">
          <?php echo link_to('Voglio iscrivermi', '@sottoscrizione_premium_demo') ?>
        </div>

      </div>      
    <?php endif ?>

    
    <div id="right-box">
      <h3>Richiedi un account Ad Hoc!</h3>
    
      <p>Per un monitoraggio senza limiti, integrazione dati e altre funzionalità avanzate, <br/>
        contattaci a <?php echo link_to('questo indirizzo di posta elettronica', 'mailto:contratti@openpolis.it', true) ?>.
      </p>
    </div>

    <div style="clear:both; margin-top: 2em; text-align: center">
      Voglio tornare 
      <?php echo link_to('alla pagina che stavo visitando', $sf_user->getAttribute('page_before_buy', '@homepage')) ?>.
    </div>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Sottoscrizioni Pro
<?php end_slot() ?>

