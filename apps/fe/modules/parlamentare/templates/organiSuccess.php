<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs',array('ramo' => $sf_params->get('ramo'),'gruppi'=> false, 'organi' => true)) ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    
    <?php echo include_partial('secondLevelMenuOrgani', 
                               array('current' => 'overview',
                               'ramo' => $sf_params->get('ramo'))); ?>
                               
    <div class="W100_100 float-left">
      <h3 class="subsection">Presidenza, Commissioni e Giunte: quanto contano i gruppi parlamentari</h3>
      <p style="padding:5px">
      L'insieme degli incarichi dei gruppi parlamentari nella Presidenza, in tutte le commissioni permanenti e bicamerali e nelle giunte.<br/>
      La cartina dell'Italia mostra, a seconda dei colori, il numero di componenti della Presidenza, commissioni e giunte suddivisi per circoscrizione elettorale. 
      </p>
    </div>
     
     
     <div class="W73_100 float-left" style="width:40%">
       <table class="disegni-decreti column-table lazyload">
         <thead>
           <tr>
             <th scope="col">Gruppo:</th>
             <th scope="col">Presidenti:</th> 	
             <th scope="col">Vicepresidenti:</th>
             <th scope="col">Questori:</th>
             <th scope="col">Segretari:</th>
             <th scope="col">Membri:</th>
             <th scope="col">Totale:</th>
           </tr>
         </thead>

         <tbody>
     <?php $tr_class = 'even'; ?>
     <?php foreach ($gruppi_all as $k => $gruppo) : ?>
       <tr class="<?php echo ($tr_class == 'even' ? 'odd' : 'even' ); ?>">
       <?php if (OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($k,date('Y-m-d'))==1) : ?>
         <?php $color_gruppo="#022468"; ?>
       <?php else : ?>
         <?php $color_gruppo="#766d04"; ?>
        <?php endif; ?>  
       <th scope='row'><span style='background-color:<?php echo $color_gruppo ?>; color:white; margin:5px;'>&nbsp;</span><?php echo OppGruppoPeer::retrieveByPk($k)->getAcronimo(); ?></th>
       <td>
         <?php if (array_key_exists($k,$gruppi_p)) : ?>
           <span style="font-weight:bold; background-color:yellow; padding:3px;"><?php echo $gruppi_p[$k]; ?></span>
         <?php else : ?>  
           <?php echo "0"; ?>
         <?php endif; ?>
       </td>
       <td>
         <?php if (array_key_exists($k,$gruppi_vp)) : ?>
           <?php echo $gruppi_vp[$k]; ?>
         <?php else :?>  
           <?php echo "0"; ?>
         <?php endif; ?>
       </td>
     
         <td>
           <?php if (array_key_exists($k,$gruppi_q)) : ?>
             <?php echo $gruppi_q[$k]; ?>
           <?php else :?>  
             <?php echo "0"; ?>
           <?php endif; ?>
         </td>
        

       <td>
         <?php if (array_key_exists($k,$gruppi_s)) : ?>
           <?php echo $gruppi_s[$k]; ?>
         <?php else :?>  
           <?php echo "0"; ?>
         <?php endif; ?>
       </td>
      
       <td>
         <?php if (array_key_exists($k,$gruppi_c)) : ?>
           <?php echo $gruppi_c[$k]; ?>
         <?php else :?>  
           <?php echo "0"; ?>
         <?php endif; ?>
       </td>
       
       <td class="evident">
           <strong><?php echo $gruppo ?></strong>
       </td>
      </tr>

     <?php endforeach; ?>  
     
     </tbody>
     </table>
     <br/>
     <div><span style="background-color:#022468; color:white; padding: 3px; margin-right:10px; font-size:10px;">maggioranza</span><span style="background-color:#766d04; color:white; padding: 3px; margin-right:10px; font-size:10px">opposizione</span></div>
     <br/>

     </div>
     <div class="W73_100 float-right" style="width:56%;">
     <?php  
       $perc_magg=array();
       $perc_min=array();
       $num_totale=0;
       foreach ($gruppi_all as $k => $gruppo)
       {
         if (OppGruppoIsMaggioranzaPeer::isGruppoMaggioranza($k,date('Y-m-d'))==1)
           $perc_magg[$k]=$gruppo;
         else
           $perc_min[$k]=$gruppo;

         $num_totale=$num_totale+$gruppo;  
       }
       $perc_grafico="50,";
       $label_grafico="|";
       $color_grafico="FFFFFF|";
       foreach($perc_magg as $k => $perc)
       {

         $perc_grafico=$perc_grafico.(number_format($perc*100/$num_totale/2,2)).",";
         $label_grafico=$label_grafico.OppGruppoPeer::retrieveByPk($k)->getAcronimo()." [".$perc."]|";
       }
       foreach($perc_min as $k => $perc)
       {

         $perc_grafico=$perc_grafico.(number_format($perc*100/$num_totale/2,2)).",";
         $label_grafico=$label_grafico.OppGruppoPeer::retrieveByPk($k)->getAcronimo()." [".$perc."]|"; 
       }
       for ($x=0;$x<count($perc_magg);$x++)
       {
         switch ($x) {
             case 0:
                 $color_grafico=$color_grafico."022468|";
                 break;
             case 1:
                 $color_grafico=$color_grafico."063cab|";
                 break;
             case 2:
                 $color_grafico=$color_grafico."0b50dc|";
                 break;
             case 3:
                 $color_grafico=$color_grafico."105dfb|";
                 break;    
             case 4:
                 $color_grafico=$color_grafico."3c7af9|";
                 break;
             case 5:
                 $color_grafico=$color_grafico."6f9df9|";
                 break;    
         }

       }

       for ($x=0;$x<count($perc_min);$x++)
       {
         switch ($x) {
             case 0:
                 $color_grafico=$color_grafico."766d04|";
                 break;
             case 1:
                 $color_grafico=$color_grafico."ac9f09|";
                 break;
             case 2:
                 $color_grafico=$color_grafico."e1cf0a|";
                 break;
             case 3:
                 $color_grafico=$color_grafico."f9e50b|";
                 break;    
             case 4:
                 $color_grafico=$color_grafico."f8e72b|";
                 break;
             case 5:
                 $color_grafico=$color_grafico."f9ee70|";
                 break;    
         }

       }


       $chld="";
        $color="";
        $z=0;
       arsort($membri_regione);
       foreach ($membri_regione as $k => $m)
       {
         $chld=$chld."IT-".$k."|";

           if ($m>=100)
              $color=$color."ff0000|";
            elseif ($m<100 && $m>=80)  
              $color=$color."ff3200|";
            elseif ($m<80 && $m>=60)  
                $color=$color."ff4a00|";
            elseif ($m<60 && $m>=50)  
                $color=$color."ff6100|"; 
             elseif ($m<50 && $m>=40)   
                $color=$color."ff7d00|"; 
            elseif ($m<40 && $m>=30)  
               $color=$color."ff9600|";     
           elseif ($m<30 && $m>=20)    
                $color=$color."ffba00|";
           elseif ($m<20 && $m>=10)   
                $color=$color."ffb500|";     
           elseif ($m<10)  
                $color=$color."a0a0a0|";               

         $z++;
       }

       $color="FFFFFF|".$color;

     ?>  
     <img src="http://chart.apis.google.com/chart?cht=p&chd=t:<?php echo rtrim($perc_grafico,',') ?>&chs=380x240&chl=<?php echo rtrim($label_grafico, '|') ?>&chco=<?php echo rtrim($color_grafico,'|') ?>">

     <img src="http://chart.apis.google.com/chart?cht=map&chs=200x300&chld=<?php echo trim($chld,"|") ?>&chco=<?php echo trim($color,"|") ?>">
     </div>
                               
    <?php if ($comm) : ?>                           
      <?php echo include_component('parlamentare','commissioniPermanenti',array('sede_id' => $comm->getId(),'leg' => 16)) ?>
    <?php endif;?>  
                         
  </div>
</div> 

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php if ($ramo=='camera') :?>
    <?php echo "organi della camera" ?>
  <?php else :?>  
    <?php echo "organi del senato" ?>
  <?php endif; ?>  
<?php end_slot() ?>

<!-- slider jQuery per i componenti -->
<script type="text/javascript">
//<![CDATA[

jQuery.noConflict();
(function($) {
  $().ready(function(){

    $('li a.show-hide-dettaglio').click(
    	function(){
    	  $this = $(this);
    	  
    		var parent_li = $this.parents('li');
        var url = $this.attr('href');
        if (!$this.data('details_loaded'))
        {
          parent_li.append("<div style=\"margin-left: 1.5em;\"></div>");
          parent_li.children("div").load(url);
          $this.text('nascondi');
          $this.data('details_loaded', true);
        } else {
          parent_li.children("div").remove();
          $this.data('details_loaded', false);
          $this.text('mostra');
        }
        return false;
    	}
    );

  	// Setup the ajax indicator
  	$("body").append('<div id="ajaxBusy"><p><img src="/images/loading.gif"></p></div>');

  	$('#ajaxBusy').css({
  		display:"none",
  		padding:"0px",
  		position:"absolute",
  		right:"0px",
  		top:"0px",
  		left:"0px",
  		bottom:"0px",
  		margin:"auto",
  		width:"40px",
  		height:"40px"
  	});

  	// Ajax activity indicator bound 
  	// to ajax start/stop document events
  	$(document).ajaxStart(function(){ 
  		$('#ajaxBusy').show(); 
  	}).ajaxStop(function(){ 
  		$('#ajaxBusy').hide();
  	});
    

  })
})(jQuery);

//]]>
</script>                              