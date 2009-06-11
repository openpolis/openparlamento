<?php use_helper('Validation', 'I18N') ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Entra in <em class="open">open</em><em class="parlamento">parlamento</em>
    </h2>
  </li>
</ul>

<div id="content" class="tabbed float-container">
  <div id="main">
  <div class="intro-box">
  <p>Per usare le funzioni avanzate (monitoraggio, descrizione e voto di un atto, etc.) &egrave; necessario prima accedere al sito.<br />
  <strong>Se sei gi&agrave; un <em class="open">utente di openpolis</em>, puoi usare gli stessi paremetri di accesso (e-mail e password)</strong><br/><br/></p>
  </div>
 
    <div id="sf_guard_auth_form">
      <?php echo form_tag('@sf_guard_signin') ?>

        <fieldset>
	  <div class="form-row-short">
            <?php echo form_error('username') ?>
	  </div>
          <div class="form-row" id="sf_guard_auth_username">
            <?php
            echo label_for('username', __('e-mail:')),
            input_tag('username', $sf_data->get('sf_params')->get('username'));
            ?>
          </div>

	  <div class="form-row-short">
            <?php echo form_error('password') ?> 
	  </div>
          <div class="form-row" id="sf_guard_auth_password">
            <?php
            echo label_for('password', __('password:')),
              input_password_tag('password');
            ?>
          </div>
          <div class="form-row" id="sf_guard_auth_remember" style="margin-left: 10em">
            <?php 
              echo link_to('Hai dimenticato la password?', 
                           'http://' . sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it') . 
                           (SF_ENVIRONMENT!='prod'?'/be_'.SF_ENVIRONMENT.'.php':'').
                           '/userProfile/passwordRequest', 
                           array('id' => 'sf_guard_auth_forgot_password')) 
            ?>
          </div>
        </fieldset>
        <?php //echo submit_tag("Entra") ?>
        <?php echo submit_image_tag("/images/btn-entra.png",array("alt"=>"Entra")) ?>
        <?php echo checkbox_tag('remember'); ?>
        <?php echo label_for('remember', 'ricordati di me su questo sito'); ?>

      </form>
    </div>
    
    <div class="registrati">
    
    <?php echo link_to('<h2>Non hai una password? Registrati!</h2><br/><strong>Tutti possono registrarsi</strong>, serve meno di un minuto.<br/>', 
                            "http://".sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it').
                            (SF_ENVIRONMENT!='prod'?'/be_'.SF_ENVIRONMENT.'.php':'').
                            "/aggiungi_utente" , 
                           array('class' => 'sign-on')) ?>	
        
      
      </div>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Entra
<?php end_slot() ?>

