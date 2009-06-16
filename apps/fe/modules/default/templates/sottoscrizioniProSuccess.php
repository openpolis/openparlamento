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
                  <p>Tutti i contenuti di <em class="open">open</em><em class="parlamento">parlamento</em> sono <strong>liberamente consultabili</strong> senza la necessit&agrave; di alcuna registrazione.</p>
                  <p>Se sei un utente registrato, <em class="open">open</em><em class="parlamento">parlamento</em> consegna nella tua e-mail e nelle pagine web a te dedicate le informazioni che ti interessano nei modi e nelle forme che preferisci.<br /> Servizi di informazione e monitoraggio sulle attivit&agrave; parlamentari per <strong>cittadini, professionisti</strong> e qualunque tipo di <strong>organizzazione</strong>.</p>
              </div>
            </div>
            
            <div class="W48_100 <?php echo (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc'))?'float-right':'" style="width: 48%; margin-left: auto; margin-right: auto;'?>">
                <div class="launch-evidence-box emerald-box round-5"> <img src="/images/op-adhoc.png" alt="Openparlamento - Ad hoc" />
                    <p>Rappresenti un'impresa, un ente, un organo di informazione, una categoria, un'istituzione?<br />
                        <br />
                        openparlamento pu&ograve; fornirti tutti i dati e le informazioni di cui hai bisogno in piena flessibilit&agrave;:</p>
                    <ul>
                        <li>
                            <h3 class="position-light-orange"><img src="/images/ico-asterisk.png" alt="*" /></h3>
                            configurazione del monitoraggio di argomenti, atti e parlamentari senza limiti e secondo richieste specifiche </li>
                        <li>
                            <h3 class="position-light-orange"><img src="/images/ico-asterisk.png" alt="*" /></h3>
                            servizi personalizzati di estrazione dati</li>
                        <li>
                            <h3 class="position-light-orange"><img src="/images/ico-asterisk.png" alt="*" /></h3>
                            integrazione con altri sistemi informativi (internet, intranet)</li>
                    </ul>
                    <p>Hai bisogno di altro? Contattaci, troveremo insieme le soluzioni.</p>
                </div>
                <h1 class="launch-evidence-btn round-5">
                  <?php echo link_to('Contattaci!', '@contatti') ?>
                </h1>
            </div>
            
            <?php if (!$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>              
              <div class="W48_100 float-left">
                  <div class="launch-evidence-box green-box round-5"> <img src="/images/op-premium.png" alt="Openparlamento Premium" /> <img src="/images/15-ott-promo.png" alt="gratis fino al 15 ottobre" class="promo-banner"/>
                      <p>In occasione del lancio di openparlamento<br />
                          <em class="round-3"> in prova gratuita fino al 15 ottobre 2009 avrai: </em>
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
                      </ul>
                  </div>
                  <h1 class="launch-evidence-btn round-5">
                    <?php echo link_to('Aderisci!', '@sottoscrizione_premium_demo') ?>
                  </h1>
              </div>
            <?php endif ?>
            <div class="clear-both"></div>
         <div class="W100_100">
                <table class="compare-table">
                    <tr>
                        <td colspan="2" rowspan="2">&nbsp;</td>
                        <td colspan="4" class="pad0"><h4 class="grey-box-contrast round-5-top">servizi disponibili</h4></td>
                        <td rowspan="2" class="pad0"><h4 class="grey-box-contrast round-5-top">modalit&agrave;<br />
                                di accesso</h4></td>
                    </tr>
                    <tr>
                        <td class="pad0"><h6 class="grey-box round-5-top">monitoraggio atti e parlamentari</h6></td>
                        <td class="pad0"><h6 class="grey-box round-5-top">monitoraggio argomenti</h6></td>
                        <td class="pad0"><h6 class="grey-box round-5-top">altri servizi personalizzati</h6></td>
                        <td class="pad0"><h6 class="grey-box round-5-top">account multipli</h6></td>
                    </tr>
                    <tr>
                        <td class="grey-box-contrast round-5-left" rowspan="3"><img src="/images/txt-tipologie-utente.png" width="18" height="134" alt="tipologie utente" /></td>
                        <td class="align-left bg-flatgreen-dark round-5-left"><img src="/images/ico-citizen.png" alt="CITIZEN" class="user-type" /></td>
                        <td class="bg-flatgreen-light">MAX 5</td>
                        <td class="bg-flatgreen-light">--</td>
                        <td class="bg-flatgreen-light">--</td>
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
                        <td class="bg-green-light">--</td>
                        <td class="bg-green-light">--</td>
                        <td class="bg-green-light round-5-right"><p>in promozione<br />
                                GRATUITA fino al<br />
                                15 Ottobre<br />
                                <?php if (!$sf_user->isAuthenticated()): ?>
                                  per utenti <?php echo link_to('registrati', '@sf_guard_signin') ?>
                                <?php endif ?>
                            </p>
                            
                            <?php if ($sf_user->hasCredential('subscriber') && !$sf_user->hasCredential('premium') && !$sf_user->hasCredential('adhoc')): ?>
                              <h5 class="launch-evidence-btn-mini round-5">
                                <?php echo link_to('aderisci!', '@sottoscrizione_premium_demo') ?>
                              </h5>
                            <?php endif ?>
                      </td>
                          
                    </tr>
                    <tr>
                        <td class="align-left bg-cyan-dark round-5-left"><img src="/images/ico-adhoc.png" alt="AD HOC" class="user-type" /></td>
                        <td class="bg-cyan-light round-5-bottom">SENZA LIMITI</td>
                        <td class="bg-cyan-light round-5-bottom">SENZA LIMITI</td>
                        <td class="bg-cyan-light round-5-bottom">SVILUPPATI AD HOC</td>
                        <td class="bg-cyan-light round-5-bottom">S&Iacute;</td>
                        <td  class="bg-cyan-light round-5-no-tl"><p>condizioni<br />
                                da concordare<br />
                                direttamente<br />
                            </p>
                            <h5 class="launch-evidence-btn-mini round-5">
                              <?php echo link_to('contattaci!', '@contatti') ?>
                            </h5>
                        </td>
                    </tr>
                </table>
            </div>   
       </div>

         
     </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Sottoscrizioni Pro
<?php end_slot() ?>

