<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabsDelta', array('data' => $data, 'mesi' => $mesi, 'ramo' => $ramo, 'dato' => $dato)) ?>

<div class="row">
	<div class="twelvecol">
		
		<?php
	    switch ($dato) {
	      case 'presenze':
	      case 'assenze':
	      case 'missioni':
	        $message =  "Il dato &egrave; da considerare rispetto al <b>numero totale di votazioni effettuate nel periodo</b>.";
	        break;
	      case 'ribellioni':
	        $message =  "Il dato &egrave; da considerare rispetto al <b>numero di votazioni cui il parlamentare ha preso parte</b>.";
	        break;
	      case 'indice':
	        $message =  "Il dato &egrave; da considerare rispetto al <b>numero totale di giorni del periodo</b>.";
	        break;

	      default:
	        $numeratore = 1;
	        break;
	    }
	    ?>

	    <p style="margin-bottom: 1em">
	     <?php echo $message ?>
	    </p>
		
	</div>
</div>


<div class="row">
	<div class="ninecol">
		
		<table class="disegni-decreti column-table lazyload">
	        <thead>
	          <tr>
	            <th scope="col">parlamentare</th>
	            <th scope="col" class="evident"><?php echo $dato ?> nell'intervallo</th>			
	            <th scope="col">trend (ultimo mese)</th>			
	          </tr>
	        </thead>

	        <tbody>

	          <?php $tr_class = 'even' ?>				  
	          <?php while ($parlamentari_rs->next()): $p = $parlamentari_rs->getRow() ?>
	            <tr class="<?php echo $tr_class; ?>">
	              <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
	              <th scope="row">
	                <p class="politician-id">
	                  <?php echo link_to(sprintf("%s %s (%s)", $p['nome'], $p['cognome'], $p['gruppo_acronimo']), '@parlamentare?id='.$p['politico_id']) ?>
	                </p>
	              </th>
	              <td>
	                <?php
	                switch ($dato) {
	                  case 'presenze':
	                  case 'assenze':
	                  case 'missioni':
	                    $numeratore = $p['n_votazioni'];
	                    break;
	                  case 'ribellioni':
	                    $numeratore = $p['n_presenze'];
	                    break;
	                  case 'indice':
	                    $datetime1 = date('U', strtotime($data_1));
	                    $datetime2 = date('U', strtotime($data_2));
	                    $numeratore = floor(($datetime1-$datetime2)/(60*60*24));
	                    break;

	                  default:
	                    $numeratore = 1;
	                    break;
	                }
	                ?>
	                <?php echo $p['delta'] ?>/<?php echo $numeratore ?>
	              </td>
	              <td><?php echo $p['trend'] ?></td>
	            </tr>
	          <?php endwhile; ?>

	        </tbody>    
	      </table>
		
	</div>
	<div class="threecol last">
		
		 Ramo: <strong><?php echo $ramo == 'C'?'camera':'senato' ?></strong>
		    (<?php echo link_to('cambia', 
		                        sprintf("@parlamentari_tabella_delta?data=$data&mesi=$mesi&ramo=%s&dato=presenze", $ramo=='C'?'S':'C')) ?>) <br/>

		    Data: <span id="datepicker"><?php echo date('d/m/Y', strtotime($data)) ?></span>
		    <span id="pickadate">(<a href="javascript:return false;">cambia</a>)</span>
		    <span id="resetpickadate" style="display:none">(<a href="#">annulla</a>)</span><br/>

		    Periodo in mesi: <?php echo select_tag('mesi', options_for_select(range(0,12), $mesi)) ?> <br/>

		    Intervallo date: 
		    dal <?php echo date('d/m/Y', strtotime($data_2)) ?> 
		    al <?php echo date('d/m/Y', strtotime($data_1)) ?><br/>
		
	</div>
</div>

<script>
 $(document).ready(function() {
   $("#mesi").change(function(){
     re = /\/(\d+?)\/([C|S])\//;
     s = window.location.href;
     matches = re.exec(s);
     new_val = this.options[this.selectedIndex].value;
     new_s = s.replace(re, "/"+new_val+"/"+matches[2]+"/");
     window.location.href = new_s;
     return false;
   });
   $("#pickadate a").click(function(){
     $("#pickadate").hide();
     $("#resetpickadate").show();
     $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
        firstDay: 1,
        duration: 'normal',
        defaultDate: '<?php echo date('Y-m-d', strtotime($data)) ?>',
        monthNamesShort: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'],
        minDate: '2008-04-29',
        nextText: 'Successivo',
        prevText: 'Precedente',
        onSelect: function(dateText, inst) {
          re = /\w\w\w\w-\w\w-\w\w/;
          s = window.location.href;
          new_s = s.replace(re, dateText)
          window.location.href = new_s;
          return false;
        }
     });
   });
   $("#resetpickadate a").click(function(){
     window.location.reload();
   });
 });
</script>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo $dato ?> mensili <?php echo $ramo == 'C'?'alla camera':'al senato' ?>,
  dal <?php echo date('d/m/Y', strtotime($data_2)) ?>
  al <?php echo date('d/m/Y', strtotime($data_1)) ?> 
<?php end_slot() ?>

