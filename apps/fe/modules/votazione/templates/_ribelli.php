<?php $ribelli_gruppi=array() ?>
<?php $valore="" ?>
<?php $label="" ?>

<h5 class="subsection"><?php echo (count($ribelli)==1  ? 'chi &egrave; il parlamentare ribelle' : 'chi sono i '.count($ribelli).' parlamentari ribelli') ?></h5>

<p class="tools-container"><?php echo link_to("quando un parlamentare &egrave; ribelle", '#', array( 'class'=>'ico-help')) ?></p>
<div class="help-box float-container" style="display: none;">
  <div class="inner float-container">
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close')) ?>
    <h5>quando un parlamentare &egrave; ribelle ?</h5>
    <p>Un parlamentare &egrave; considerato ribelle quando esprime un voto diverso da quello del gruppo parlamentare a cui appartiene. Si tratta di un indicatore puramente quantitativo del grado di ribellione alla "disciplina" del gruppo.</p>
  </div>
</div>
<br />

<table class="disegni-decreti column-table">
  <thead>
    <tr>
  	<th scope="col">parlamentare</th>
	<th scope="col">voto del parlamentare</th>
	<th scope="col">voto del gruppo</th>
    </tr>
  </thead>  
  
  <tbody>
  <?php $tr_class = 'even' ?>
  <?php foreach ($ribelli as $cognome => $ribelle): ?>  
   <tr class="<?php echo $tr_class; ?>">
   <?php $tr_class = ($tr_class == 'even' ? 'odd' : 'even' )  ?>
  	  <th scope="row">
  	   <p class="politician-id">
            <?php echo image_tag(OppPoliticoPeer::getThumbUrl($ribelle['id']), 
                                 'icona parlamentare') ?>	
            <?php echo link_to($cognome, '@parlamentare?id='.$ribelle['id']) ?><?php echo ' ('.$ribelle['gruppo'].')'  ?>
           </p>
          </th>
	  <td><?php echo $ribelle['voto'] ?></td>
	  <td>
	  <?php foreach ($voto_gruppi as $voto_gruppo): ?>
	    <?php echo (($voto_gruppo->getOppGruppo()->getNome()==$ribelle['gruppo']) ? $voto_gruppo->getVoto() : '') ?>
	  <?php endforeach; ?> 
	  </td> 	    
    </tr> 
  <?php endforeach; ?>  
  </tbody>  
</table>