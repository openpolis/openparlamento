<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs',array('ramo'=>$ramo,'gruppi'=>false)) ?>

<div class="row">
	<div class="twelvecol">
		<a name="top"></a>
		<?php echo include_partial('secondLevelMenuParlamentari', 
	                             array('current' => 'confronta',
	                             'ramo' => $sf_params->get('ramo'))); ?>

	<div style="width:80%; border: 1px solid #4E8480; background-color: rgb(247, 247, 247); padding: 10px 5px 15px 5px; -moz-border-radius: 5px 5px 5px 5px;">
	<p style="padding-bottom:5px; font-size:18px">Scegli i <?php echo ($ramo=='1' ? 'deputati' : 'senatori') ?> da confrontare:</p> 
	    <?php if ($parlamentare1!=null) : ?>
	   <?php include_component('parlamentare', 'tendinaParlamentari',array('num_tendine' => '2','ramo' => $ramo, 'select1' =>$parlamentare1->getOppPolitico()->getId(),'select2' =>$parlamentare2->getOppPolitico()->getId() )) ?> 
	<?php else : ?>
	   <?php include_component('parlamentare', 'tendinaParlamentari',array('num_tendine' => '2','ramo' => $ramo, 'select1' =>'null','select2' =>'null' )) ?>    
	<?php endif ?>
	  </div>

	<?php if ($compara_ok==1) : ?>

		<?php if ($parlamentare1!=$parlamentare2) : ?>
		<?php include_partial('parlarmentariComparati', 
		                    array('parlamentare1' => $parlamentare1, 
		                          'parlamentare2' => $parlamentare2,
		                          'assenze1' => $assenze1,
		                          'assenze2' => $assenze2,
		                          'durata1' => $durata1,
		                          'durata2' => $durata2,
		                          'name' => 'search_tag')) ?>
		<br />

		<?php  include_component('parlamentare', 'votiComparati', 
		                      array('parlamentare1' => $parlamentare1, 
		                            'parlamentare2' => $parlamentare2,
		                            'compare' =>  $compare,
		                            'numero_voti' => $numero_voti))  ?>

		<?php include_component('parlamentare', 'keyvoteComparati', 
		                      array('parlamentare1' => $parlamentare1, 
		                            'parlamentare2' => $parlamentare2,
		                            ))  ?>

		<?php  /* include_component('parlamentare', 'allvoteComparati', 
		                       array('parlamentare1' => $parlamentare1, 
		                             'parlamentare2' => $parlamentare2,
		                             'compare' =>  $compare,
		                             'numero_voti' => $numero_voti,
		                             'compare_voti' => $compare_voti,
		                             'arr1' => $arr1,
		                             'arr2' => $arr2,
		                             'pager' => $pager)) */ ?>                           


		<?php else : ?>  

		<p style="background-color:yellow; width:50%; font-size:16px; padding:3px;"><strong>Non puoi confrontare un parlamentare con se stesso!</strong><br/>
		Seleziona due parlamentari diversi.</p>

		<?php endif; ?>                                  

	<?php endif; ?>
		
	</div>
</div>
     

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to("parlamentari", "@parlamentari") ?>/
  <?php if ($ramo==1) : ?>
  deputati a confronto
  <?php else : ?>
  senatori a confronto
  <?php endif ?> 
  <?php if ($compara_ok==1) : ?>
   <?php echo ': '.$parlamentare1->getOppPolitico()->getCognome().' vs '.$parlamentare2->getOppPolitico()->getCognome() ?>
  <?php endif ?> 
<?php end_slot() ?>       