<?php use_helper('Validation') ?>

<div id="content" class="float-container" style="margin-top: 5px">
  <div id="main" style="padding: 2.5em 1em">
    <h3>Adesione al servizio Premium</h3>
    
    <p>Grazie per aver aderito a openparlamento premium in promozione gratuita fino al 15 ottobre.</p>    
    <p style="margin-top:2em;">Stiamo sperimentando, per la prima volta in Italia, un servizio di <b>monitoraggio
      parlamentare distribuito</b> attraverso la rete. 
    </p>
    <p>
      Non sappiamo se la cosa potrà interessare, quanto, a chi e se potrà essere economicamente sostenibile. <br/>
      Per questo ti chiediamo solo qualche minuto per darci poche risposte che ci aiutano a saperne di più. <br/>
      Le informazioni saranno trattate secondo i principi indicati 
      nell'<?php echo link_to("informativa sulla trattamento dei dati", 'static/informativa') ?> e 
      non verranno per nessuna ragione fornite a terzi.
    </p>
    
    <?php echo form_tag('@sottoscrizione_premium_demo', 
                        array('name' => 'premium-form', 'id' => 'premium-form',
                              'class' => 'subscribe-form', 
                              'style' => 'margin: 1em; margin-right: 50%')) ?>

      <fieldset>

        <!-- età -->
        <div class="form-row" id="eta" style="padding:1em;">
          <?php echo  form_error('eta') ?>
          <h4>Quanti anni hai?</h4>
          <?php echo  select_tag('eta', 
                                 options_for_select(array(0 => '-- Scegli --', 
                                                          1 => 'meno di 18', 
                                                          2 => 'da 18 a 35',
                                                          3 => 'da 36 a 45',
                                                          4 => 'da 46 a 55',
                                                          5 => 'oltre 55')));
          ?>
        </div>

        <!-- attività -->
        <div class="form-row" id="attivita" style="padding:1em;">
          <?php echo form_error('attivita'), 
                     form_error('attivita_aut_desc'), form_error('attivita_dip_desc'), form_error('attivita_amm_desc'); ?>

          <h4>Qual &egrave; la tua attivit&agrave; principale?</h4>
          <ul class="main">
            <li>
              <?php echo radiobutton_tag('attivita[]', 1, false ), '&nbsp;', label_for('attivita_1_1', 'studentessa/e'); ?>
            </li>

            <br/>
            <li style="font-weight: bold">lavoratrice/tore autonomo</li>
            <li><?php echo radiobutton_tag('attivita[]', 2, false ), '&nbsp;',
                           label_for('attivita_2_2', 'avvocatessa/o (e simili)'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 3, false ), '&nbsp;',
                           label_for('attivita_3_3', 'commercialista (e simili)'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 4, false ), '&nbsp;',
                           label_for('attivita_4_4', 'giornalista (e simili)'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 5, false ), '&nbsp;',
                           label_for('attivita_5_5', 'consulente'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 6, false ), '&nbsp;',
                           label_for('attivita_6_6', 'commerciante'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 7, false ), '&nbsp;',
                           label_for('attivita_7_7', 'imprenditrice/tore'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 8, false ), '&nbsp;',
                           label_for('attivita_8_8', 'altro (descrivi, se vuoi)'), '<br/>',
                           input_tag('attivita_aut_desc', '', 'maxlength=250 size=65 disabled=true') ?></li>

            <br/>
            <li style="font-weight: bold">dipendente/funzionaria/o</li>
            <li><?php echo radiobutton_tag('attivita[]', 9, false ), '&nbsp;',
                           label_for('attivita_9_9', 'pubblico'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 10, false ), '&nbsp;',
                           label_for('attivita_10_10', 'privato'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 11, false ), '&nbsp;',
                           label_for('attivita_11_11', 'no-profit'); ?></li>
            <li><?php echo label_for('attivita_dip_desc', 'descrivi, se vuoi, il settore di attivit&agrave;, il nome dell\' ufficio'), '<br/>',
                           input_tag('attivita_dip_desc', '', 'maxlength=250 size=65 disabled=true') ?></li>


            <br/>
            <li style="font-weight: bold">politico/amministratrice/tore</li>
            <li><?php echo radiobutton_tag('attivita[]', 12, false ), '&nbsp;',
                           label_for('attivita_12_12', 'europeo'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 13, false ), '&nbsp;',
                           label_for('attivita_13_13', 'nazionale'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 14, false ), '&nbsp;',
                           label_for('attivita_14_14', 'regionale'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 15, false ), '&nbsp;',
                           label_for('attivita_15_15', 'provinciale'); ?></li>
            <li><?php echo radiobutton_tag('attivita[]', 16, false ), '&nbsp;',
                           label_for('attivita_16_16', 'comunale'); ?></li>
            <li><?php echo label_for('attivita_amm_desc', 'descrivi, se vuoi'), '<br/>',
                           input_tag('attivita_amm_desc', '', 'maxlength=250 size=65 disabled=true') ?></li>
                             
          </ul>
          
        </div>

        <!-- perché ti interessa? -->
        <div class="form-row" id="perche" style="padding:1em;">
          <?php echo form_error('perche'), form_error('perche_altro_desc'); ?>

          <h4>Perch&eacute; sei interessato a OpenParlamento?</h4>
          
          <ul  class="main">
            <li><?php echo radiobutton_tag('perche[]', 1, false ), '&nbsp;',
                           label_for('perche_1_1', 'lavoro'); ?></li>
            <li><?php echo radiobutton_tag('perche[]', 2, false ), '&nbsp;',
                           label_for('perche_2_2', 'interesse personale'); ?></li>
            <li><?php echo radiobutton_tag('perche[]', 3, false ), '&nbsp;',
                           label_for('perche_3_3', 'studio/ricerca'); ?></li>
            <li><?php echo radiobutton_tag('perche[]', 4, false ), '&nbsp;',
                           label_for('perche_4_4', 'altro (descrivi, se vuoi)'), '<br/>',
                           input_tag('perche_altro_desc', '', 'maxlength=250 size=65 disabled=true') ?></li>
          </ul>
        </div>
        
      </fieldset>
      <?php echo submit_image_tag("/images/btn-aderisco.png",array("alt"=>"Aderisco", 'style' => 'margin: 1em; margin-left: 13em')) ?>

    </form>
    
    <div>
      Voglio tornare
      <?php echo link_to('alla pagina che stavo visitando', $sf_user->getAttribute('page_before_buy', '@homepage')) ?>.
    </div>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Adesione servizio Premium
<?php end_slot() ?>

<!-- controlli jQuery il form -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $().ready(function(){

    $('form.subscribe-form input[type=radio]').click(
    	function(){
    	  $this = $(this);
    	  clicked = $this.get(0);

    	  if (clicked.name == 'attivita[]'){

          $('#attivita_aut_desc').get(0).disabled = true;
          $('#attivita_dip_desc').get(0).disabled = true;
          $('#attivita_amm_desc').get(0).disabled = true;
          $('#attivita_aut_desc').get(0).value = '';
          $('#attivita_dip_desc').get(0).value = '';
          $('#attivita_amm_desc').get(0).value = '';
          

    	    switch (parseInt(clicked.value)){
    	      case 8:
        	    $('#attivita_aut_desc').get(0).disabled = false;
        	    $('#attivita_aut_desc').focus();
      	      break;
    	      
    	      case 9:
    	      case 10:
    	      case 11:
        	    $('#attivita_dip_desc').get(0).disabled = false;
      	      break;
    	      
    	      case 12:
    	      case 13:
    	      case 14:
    	      case 15:
    	      case 16:
        	    $('#attivita_amm_desc').get(0).disabled = false;
      	      break;
    	    }
    	  }
    	  
    	  if (clicked.name == 'perche[]'){
    	    if (parseInt(clicked.value) == 4){
    	      $('#perche_altro_desc').get(0).disabled = false;        	  
      	    $('#perche_altro_desc').focus();    	      
    	    } else {
    	      $('#attivita_amm_desc').get(0).value = '';
    	      $('#perche_altro_desc').get(0).disabled = true;  	                  
    	    }
    	  }
    	}
    );
    

  })
})(jQuery);

//]]>
</script>
