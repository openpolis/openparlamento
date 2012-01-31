<?php use_helper('sfSolr', 'I18N', 'PagerNavigation') ?>

<?php include_partial('votazione/tabs') ?>

<div class="row">
	<div class="ninecol">
		
		<?php echo include_partial('sfSolr/addAlert', array('query' => $query)); ?>

	      <p style="margin: 10px 0; text-align: right; padding: 5px">Risultati <?php echo $start ?> - <?php echo $start + $rows - 1 ?> su 
	         <?php echo $num ?> per <strong><?php echo $query ?></strong> <?php echo $title ?> (<?php echo $qTime ?>ms)</p>

	    <table class="search-results-table">
	    <?php $num_item=0 ?>

	        <?php foreach ($pager->getResults() as $result): ?>
	          <?php $num_item=$num_item+1 ?>
	          <tr>
	          <?php if ($result->getInternalPartial()=='parlamentare/searchResult') : ?>
	               <td><div class="ico-type"><?php echo image_tag('/images/no-avatar40.png',array('width' => '44','height' => '42' )) ?></div></td> 
	               <?php elseif ($result->getInternalPartial()=='atto/searchResultDoc') : ?>
	                   <td><div class="ico-type"><?php echo image_tag('/images/ico-type-document.png',array('width' => '44','height' => '42' )) ?></div></td> 
	                   <?php elseif ($result->getInternalPartial()=='atto/searchResult') : ?>
	                        <?php if (OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==1 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==12 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==15 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==16 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==17) : ?>
	                            <td><div class="ico-type"><?php echo image_tag('/images/ico-type-proposta.png',array('width' => '44','height' => '42' )) ?></div></td>
	                        <?php else : ?>
	                            <td><div class="ico-type"><?php echo image_tag('/images/ico-type-descrizione.png',array('width' => '44','height' => '42' )) ?></div></td>
	                        <?php endif ?>    
	                        <?php elseif ($result->getInternalPartial()=='votazione/searchResult') : ?>
	                            <td><div class="ico-type"><?php echo image_tag('/images/ico-type-votazione.png',array('width' => '44','height' => '42' )) ?></div></td>
	                            <?php elseif ($result->getInternalPartial()=='argomento/searchResult') : ?>
	                                 <td><div class="ico-type"><?php echo image_tag('/images/ico-type-etichetta.png',array('width' => '44','height' => '42' )) ?></div></td>
	           <?php endif; ?>
	           <td class="<?php echo (fmod($num_item,2)!=0) ? 'odd' : 'even' ?>">                      

	          <?php include_search_result($result, $query,array('num_item'=>$num_item)) ?>

	          </tr>
	        <?php endforeach ?>
	      </table>

	            <?php echo pager_navigation($pager, "@votazioniSearch?query=$query") ?>


	          </div>
	        </div>
	      </div>
		
	</div>
	<div class="threecol last">
		
		<?php 
	        echo include_partial('sfSolr/votazioni_controls', 
	                            array('query' => $query,
	                                  'title' => $title));
	      ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  <?php echo link_to('Votazioni', '@votazioni') ?> / 
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>
