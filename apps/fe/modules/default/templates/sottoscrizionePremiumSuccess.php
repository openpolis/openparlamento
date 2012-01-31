<?php use_helper('Validation') ?>

<div class="row">
	<div class="twelvecol">
		
		<h3>Diventa un sottoscrittore <strong>Premium</strong>, ora!</h3>

	    <p>Sottoscrivendo l'offerta Premium, potrai monitorare fino a <b>dieci token</b> e 
	    <b>tre argomenti</b> <i>gratuitamente</i> fino al 15 ottobre.
	    </p>

	    <p style="margin-top:2em;">Lasciaci qualche dato per poter profilare che tipo di utenti abbiamo e 
	      stabilire le offerte commerciali.</p>

	    <?php echo form_tag('@sottoscrizione_premium', 
	                        array('class' => 'subscribe-form', 
	                              'style' => 'background-color: #EAF3FA; margin: 1em; margin-right: 50%')) ?>

	      <fieldset>

	        <div class="form-row" id="tipo_attivita" style="padding:1em;">
	          <?php
	          echo form_error('tipo_attivita'),
	            label_for('tipo_attivita', 'Tipo di attivit&agrave; prevista'), '&nbsp;',
	            input_tag('tipo_attivita', $sf_data->get('sf_params')->get('tipo_attivita'));
	          ?>
	        </div>

	        <div class="form-row" id="" style="padding:2em;">
	          <?php echo checkbox_tag('contattami'); ?>
	          <?php echo label_for('contattami', 'Desidero essere contattato via mail alla scadenza del periodo di prova'); ?>
	        </div>

	      </fieldset>
	      <?php echo submit_tag("Sottoscrivo", array('style' => 'margin:1em;')) ?>

	    </form>

	    <div>
	      Voglio tornare
	      <?php echo link_to('alla pagina che stavo visitando', $sf_user->getAttribute('page_before_buy', '@homepage')) ?>.
	    </div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Sottoscrizione Premium
<?php end_slot() ?>

