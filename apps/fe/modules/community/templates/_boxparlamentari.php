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

<table class="disegni-decreti column-table">
<tbody>	
<?php $tr_class = 'even' ?>				  
<?php while($parlamentari->next()): ?>
   <tr class="<?php echo $tr_class; ?>">
   <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
   <th scope="row">
   <p class="politician-id">
   <?php echo image_tag(OppPoliticoPeer::getThumbUrl($parlamentari->getInt(2)), 
                        array('width' => '40','height' => '53' )) ?>	
    <?php echo link_to($parlamentari->getString(3).' '.$parlamentari->getString(4), '@parlamentare?id='.$parlamentari->getInt(2)) ?>
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