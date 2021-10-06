<?php use_helper('Validation', 'I18N') ?>

<div class="row" id="tabs-container">
    <ul id="content-tabs" class="float-container tools-container">
      <li class="current">
        <h2>
          Entra in <em class="open">open</em><em class="parlamento">parlamento</em>
        </h2>
      </li>
    </ul>
</div>

<div class="row">
	<div class="twelvecol last">
		
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
		          
		        </fieldset>
		        <?php //echo submit_tag("Entra") ?>
		        <?php echo submit_image_tag("/images/btn-entra.png",array("alt"=>"Entra")) ?>
		        <?php echo checkbox_tag('remember'); ?>
		        <?php echo label_for('remember', 'ricordati di me su questo sito'); ?>

		      </form>
		    </div>

		    <div class="registrati">



		      </div>
		
	</div>
</div>


<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Entra
<?php end_slot() ?>

