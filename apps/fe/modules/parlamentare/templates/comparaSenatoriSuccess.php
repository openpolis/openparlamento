<?php use_helper('I18N', 'Date') ?>

<ul id="content-tabs" class="float-container tools-container">
   <li class="<?php echo($ramo==1 ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Deputati a confronto', '/parlamentare/comparaDeputati') ?></h2>   
  </li><li class="<?php echo($ramo==2 ? 'current' : '' ) ?>">
    <h2><?php echo link_to('Senatori a confronto', '/parlamentare/comparaSenatori') ?></h2>   
  </li>
</ul>

<div id="content" class="tabbed float-container">
<a name="top"></a>
  <div id="main">
<?php include_component('parlamentare', 'tendinaParlamentari',array('num_tendine' => '2','ramo' => 'camera')) ?> 
<?php //echo link_to('Confronta altri due parlamentari','/votazioni/comparaParlamentari') ?>  

<?php if ($compara_ok==1) : ?>
<?php include_partial('parlarmentariComparati', 
                      array('parlamentare1' => $parlamentare1, 
                            'parlamentare2' => $parlamentare2,
                            'assenze1' => $assenze1,
                            'assenze2' => $assenze2,
                            'name' => 'search_tag')) ?>
<br />

<?php include_component('parlamentare', 'votiComparati', 
                        array('parlamentare1' => $parlamentare1, 
                              'parlamentare2' => $parlamentare2,
                              'compare' =>  $compare,
                              'numero_voti' => $numero_voti,
                              'compare_voti' => $compare_voti,
                              'arr1' => $arr1,
                              'arr2' => $arr2,
                              'pager' => $pager))?>
                              
<?php else : ?>   
<?php //include_component('parlamentare', 'tendinaParlamentari') ?>                           
<?php endif; ?>                              
                              
</div>                 
</div>      

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to("parlamentari", "@parlamentari") ?>/
  parlamentari a confronto
  <?php if ($compara_ok==1) : ?>
   <?php echo ': '.$parlamentare1->getOppPolitico()->getCognome().' vs '.$parlamentare2->getOppPolitico()->getCognome() ?>
  <?php endif ?> 
<?php end_slot() ?>       