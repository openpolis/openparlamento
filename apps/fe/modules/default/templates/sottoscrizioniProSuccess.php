<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      i servizi di <em class="open">open</em><em class="parlamento">parlamento</em> 
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container"> 

  <div id="main">
            <div class="W100_100">
              
              <?php if ($sf_flash->has('subscription_limit_reached')): ?>
                <div class="flash-messages">
                  <?php echo $sf_flash->get('subscription_limit_reached') ?>
                </div>
              <?php endif; ?> 
              
              <div class="intro-box">
                  <h2>Qual &egrave; il <em class="open">tuo</em><em class="parlamento">parlamento</em>?</h2>
                  <p style="font-size:20px";>Tutti i contenuti di <em class="open">open</em><em class="parlamento">parlamento</em> sono <strong>liberamente consultabili</strong> senza la necessit&agrave; di alcuna registrazione.</p>
                  <p>Se sei un utente registrato, <em class="open">open</em><em class="parlamento">parlamento</em> consegna nella tua e-mail e nelle pagine web a te dedicate le informazioni che ti interessano nei modi e nelle forme che preferisci.<br /> Servizi di informazione e monitoraggio sulle attivit&agrave; parlamentari per <strong>cittadini, professionisti</strong> e qualunque tipo di <strong>organizzazione</strong>.</p>
              </div>
            </div>
            
         <div class="W100_100">
                <table class="compare-table">
                    <tr>
                        <td colspan="2" rowspan="2">&nbsp;</td>
                        <td colspan="2" class="pad0"><h4 class="grey-box-contrast round-5-top">servizi no-profit disponibili</h4></td>
                        <td rowspan="2" class="pad0"><h4 class="grey-box-contrast round-5-top">modalit&agrave;<br />
                                di accesso</h4></td>
                    </tr>
                    <tr>
                        <td class="pad0"><h6 class="grey-box round-5-top">monitoraggio atti e parlamentari</h6></td>
                        <td class="pad0"><h6 class="grey-box round-5-top">monitoraggio argomenti</h6></td>
                        
                    </tr>
                    <tr>
                        <td class="grey-box-contrast round-5-left" rowspan="3"><img src="/images/txt-tipologie-utente.png" width="18" height="134" alt="tipologie utente" /></td>
                        <td class="align-left bg-flatgreen-dark round-5-left"><img src="/images/ico-citizen.png" alt="CITIZEN" class="user-type" /></td>
                        <td class="bg-flatgreen-light">MAX 5</td>
                        <td class="bg-flatgreen-light">--</td>
                        
                        <td class="bg-flatgreen-light round-5-right"><p><br />
                                <br />
                                GRATUITA</p>
                                <?php if (!$sf_user->hasCredential('subscriber')): ?>
                                  <h5 class="launch-evidence-btn-mini round-5">
                                    <?php echo link_to('registrati!', '@sf_guard_signin') ?>
                                  </h5>
                                <?php endif ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-left bg-green-dark round-5-left"><img src="/images/ico-premium.png" alt="PREMIUM" class="user-type" /></td>
                        <td class="bg-green-light">MAX 10</td>
                        <td class="bg-green-light">MAX 3</td>
                        
                        <td class="bg-green-light round-5-right"><p>riservata ai soci<br />
                                dell'associazione<br />
                                openpolis<br />
                            </p>
                            
                            <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>
                              <h5 class="launch-evidence-btn-mini round-5">
                                <?php echo link_to('Diventa socio <br />di openpolis!', 'http://associazione.openpolis.it/contribuisci/diventa-socio') ?>
                              </h5>
                            <?php endif ?>
                      </td>
                          
                    </tr>
                </table>
            </div>   
            
            
            <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>              
              <div class="W100_100 float-left" style="width:90%;">
                  <div class="launch-evidence-box green-box round-5" style="height:320px;"> <img src="/images/op-premium.png" alt="Openparlamento Premium" />
                      <p>
                          <em class="round-3">gli iscritti all'associazione openpolis hanno:</em>
                     </p>
                      <ul>
                          <li>
                              <h3 class="position-light-orange">a</h3> 
                              fino a 3 argomenti da monitorare</li>
                          <li>
                              <h3 class="position-light-orange">b</h3>
                              fino a 10 parlamentari o atti da monitorare</li>
                          <li>
                              <h3 class="position-light-orange">c</h3>
                              tutte le notizie aggiornate sul monitoraggio nelle tue pagine personali e direttamente nella tua e-mail</li>
                          <li>
                              <h3 class="position-light-orange">d</h3>
                              la consapevolezza di promuovere la trasparenza e la partecipazione!</li>    
                      </ul>
                  </div>
                  <h1 class="launch-evidence-btn round-5">
                    <?php echo link_to('Diventa socio di openpolis!', 'http://associazione.openpolis.it/contribuisci/diventa-socio') ?>
                  </h1>
              </div>
              
              <div class="W100_100 float-left" style="width:90%; padding:30px">
              <p style="font-size:18px";>Rappresenti un'impresa, un ente, un organo di informazione, una categoria, un'istituzione?<br />
                  openparlamento pu&ograve; fornirti tutti i dati, le analisi e le informazioni di cui hai bisogno in piena flessibilit&agrave;.<br />
                  Per maggiori informazioni contatta <a href="http://www.depp.it">depp srl</a>, societ&agrave; incaricata della commercializzazione dei servizi.</p>
              </div>
            <?php endif ?>
 
       </div>

       <div class="clear-both"> </div>
       <br/><br/>
         
     </div>

</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Sottoscrizioni Pro
<?php end_slot() ?>

