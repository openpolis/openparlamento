<?php use_helper('Date', 'I18N', 'PagerNavigation') ?>

<?php include_partial('atto/atto_tabs', array('atto' => $atto, 'current' => 'emendamenti', 
                                             'nb_comments' => $atto->getNbPublicComments(),
                                             'nb_emendamenti' => $atto->countOppAttoHasEmendamentos())) ?>

<div class="row">
	<div class="twelvecol">
		
		<p style="font-size:16px;">
	        Elenco degli emendamenti relativi a 
	        <?php echo link_to('<em>'.$atto->getRamo().'.'.$atto->getNumfase().'</em> '.$atto->getTitolo(), '@singolo_atto?id='.$atto->getId()) ?>
	        </p>
	      <br/>

	      <?php include_partial('filter',
	                            array('active' => deppFiltersAndSortVariablesManager::arrayHasNonzeroValue(array_values($filters)),
	                                  'available_articles' => $available_articles,                            
	                                  'selected_article' => array_key_exists('article', $filters)?$filters['article']:0,
	                                  'available_sites' => $available_sites,
	                                  'selected_site' => array_key_exists('site', $filters)?$filters['site']:0,       
	                                  'available_presenters' => $available_presenters,                         
	                                  'selected_presenter' => array_key_exists('presenter', $filters)?$filters['presenter']:0,
	                                  'available_statuses' => $available_statuses,
	                                  'selected_status' => array_key_exists('status', $filters)?$filters['status']:0)) ?>

	      <?php echo include_partial('default/listNotice', 
	                                 array('filters' => $filters, 
	                                       'results' => $pager->getNbResults(),
	                                       'route' => '@emendamenti_atto?id='.$atto->getId())); ?>

	      <?php include_partial('list', array('pager' => $pager, 'atto' => $atto)) ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php include_partial('atto/breadcrumbsAtti', array('atto' => $atto)) ?> /
    <?php echo link_to(Text::denominazioneAttoShort($atto), '@singolo_atto?id=' . $atto->getId() ) ?> /
    Emendamenti
<?php end_slot() ?>
