<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabsDelta', array('data' => $data, 'ramo' => $ramo, 'dato' => $dato)) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
	  <div class="W25_100 float-right"> 
	    Ramo: <strong><?php echo $ramo == 'C'?'camera':'senato' ?></strong>
	    (<?php echo link_to('cambia', 
	                        sprintf("@parlamentari_tabella_delta?data=$data&ramo=%s&dato=presenze", $ramo=='C'?'S':'C')) ?>) <br/>
	    Data: <span id="datepicker"><?php echo date('d/m/Y', strtotime($data)) ?></span>
	    <span id="pickadate">(<a href="javascript:return false;">cambia</a>)</span>
	    <span id="resetpickadate" style="display:none">(<a href="#">annulla</a>)</span><br/>
	    Intervallo date: 
	    dal <?php echo date('d/m/Y', strtotime($data_2)) ?> al 
	    al <?php echo date('d/m/Y', strtotime($data_1)) ?><br/>	    
    </div>
    
	  <div class="W73_100 float-left"> 
      <table class="disegni-decreti column-table lazyload">
        <thead>
          <tr>
            <th scope="col">parlamentare</th>
            <th scope="col" class="evident"><?php echo $dato ?> nell'intervallo</th>			
          </tr>
        </thead>

        <tbody>

          <?php $tr_class = 'even' ?>				  
          <?php while ($parlamentari_rs->next()): $p = $parlamentari_rs->getRow() ?>
            <tr class="<?php echo $tr_class; ?>">
              <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
              <th scope="row">
                <p class="politician-id">
                  <?php echo link_to($p['nome'] .' ' . $p['cognome'], '@parlamentare?id='.$p['politico_id']) ?>
                </p>
              </th>
              <td><?php echo $p['delta'] ?></td>
            </tr>
          <?php endwhile; ?>
          
        </tbody>    
      </table>
    </div>
       
    <div class="clear-both"></div>
  </div>
</div>

<script>
 $(document).ready(function() {
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

