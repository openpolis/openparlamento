 <?php use_helper('Date', 'Javascript') ?> 
 
 <div id="proposte_indicator" style="display:none"> 
  <div class="indicator"></div>
</div>
 
  <ul class="section-tab-switch float-container tools-container">
  <?php if ($type == 'deputati'): ?>
    <li class="current">deputati</li> 
    <li><?php echo link_to_remote('senatori', 
                                array( 'update' => 'monitor_community', 
                                       'url' => "/community/boxparlamentari?type=senatori",
                                       '404'     => "alert('Not found...? Wrong URL...?')",
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>
  <?php else: ?>
    <li><?php echo link_to_remote('deputati', 
                                array( 'update' => 'monitor_community', 
                                       'url' => "/community/boxparlamentari?type=deputati",
                                       '404'     => "alert('Not found...? Wrong URL...?')", 
                                       'loading'  => "Element.show('proposte_indicator')",
                                       'complete' => "Element.hide('proposte_indicator')"
                                       )); ?></li>
     <li class="current">senatori</li>
  <?php endif ?>
</ul>	

<table class="disegni-decreti column-table v-align-middle">
<tbody>	
<?php 
    $tr_class = 'even';
    $i=0;
    use_helper('Slugger');
?>
<?php while($parlamentari->next()): ?>
   <?php $i++ ?>			  
   <tr class="<?php echo $tr_class; ?>">
   <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
   <th scope="row">
   <h3 class="position-orange" style="color:#FFFFFF; height:30px; margin-right:6px; margin-top:15px; text-align:center; width:30px; float:left; padding:0px"><?php echo $i ?></h3>
   <p class="politician-id">
   <?php echo image_tag(OppPoliticoPeer::getThumbUrl($parlamentari->getInt(2)), 
                        array('width' => '40','height' => '53' )) ?>	
    <?php 
    $fullName = $parlamentari->getString(3).' '.$parlamentari->getString(4);
    
    echo link_to(, '@parlamentare?id='.$parlamentari->getInt(2).'&slug='. slugify($fullName )) ?>
    <?php $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($parlamentari->getInt(1)) ?>  	
    <?php foreach($gruppi as $nome => $gruppo): ?>
	<?php if(!$gruppo['data_fine']): ?>
	   <?php print" (". $nome.")" ?>
	<?php endif; ?> 
    <?php endforeach; ?> 
    </p>
    </th>

        <td>
             <span class="small">&egrave; monitorato da</span><br/><?php echo $parlamentari->getInt(5) ?><span class="small"> utenti</span>     
        </td> 
     
    </tr>
    
   
<?php endwhile; ?>    
 <tr>
 <td>&nbsp;</td>
    
        <td>
            <?php echo link_to('vai alla classifica','/') ?>
     
    </tr>
</tbody>
</table>    