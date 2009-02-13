<?php use_helper('I18N', 'Date') ?>

<?php include_partial('tabs') ?>

<div id="content" class="tabbed float-container">
  <div id="main">
    <div class="W73_100 float-left">	
      <?php include_partial('wiki') ?>       
    
      <?php include_partial('filter',
                            array('groups' => $all_groups, 'constituencies' => $all_constituencies,
                                  'selected_group' => array_key_exists('group', $filters)?$filters['group']:0,                                
                                  'selected_const' => array_key_exists('const', $filters)?$filters['const']:0)) ?>


      <?php include_partial('sort') ?>   
	  
	  <a href="#decaduti">guarda le variazioni nella legislatura</a><br />
    </div>
	<div class="W100_100 float-left"> 
	  <?php include_partial('list', array('parlamentari' => $parlamentari, 'numero_parlamentari' => $numero_parlamentari)) ?>  
    </div>
	<div class="W100_100 float-left"> 
	<h5 class="subsection">variazioni nella legislatura:</h5>
	  
	  <a name="decaduti"></a>
	  <?php include_partial('list', array('parlamentari' => $parlamentari_decaduti, 'numero_parlamentari' => $numero_parlamentari)) ?>  
    </div>
    <div class="clear-both"></div>
  </div>
</div>
