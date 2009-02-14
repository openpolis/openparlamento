<h5 class="subsection"><?php echo (count($ribelli)==1 ? 'chi &egrave; il parlamentare ribelle' : 'chi sono i '.count($ribelli).' parlamentari ribelli') ?></h5>

<p class="tools-container"><?php echo link_to("quando un parlamentare &egrave; ribelle", '#', array( 'class'=>'ico-help')) ?></p>
<div class="help-box float-container" style="display: none;">
  <div class="inner float-container">
    <div class="go-wikipedia">
      <?php echo link_to('approfondisci su<br />'.image_tag('ico-wikipedia.png', array('alt' => 'wikipedia').'<strong>Wikipedia</strong>'), '#') ?>
    </div>
    <?php echo link_to('chiudi', '#', array( 'class'=>'ico-close')) ?>
    <h5>quando un parlamentare &egrave; ribelle ?</h5>
    <p>In pan philologos questiones interlingua. Sitos pardona flexione pro de, sitos africa e uno, maximo parolas instituto non un. Libera technic appellate ha pro, il americas technologia web, qui sine vices su. Tu sed inviar quales, tu sia internet registrate, e como medical national per. (fonte: <a href="#">Wikipedia</a>)</p>
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
  
  <?php foreach ($ribelli as $cognome => $ribelle): ?>  
  <tbody>
    <tr>
  	  <th scope="row">
  	   <p class="politician-id">
            <?php echo image_tag('no-avatar40.png') ?>	
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
  </tbody>  
  <?php endforeach; ?>  
</table>