<?php 
/** 
 * @package sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 */
?>

<?php use_helper('sfSolr', 'I18N', 'PagerNavigation') ?>

<ul class="float-container tools-container" id="content-tabs">
  <li class="current"><h2>Risultati della ricerca per <em><?php echo $query ?></em></h2></li>
</ul>


<div class="tabbed float-container" id="content">
  <div id="main">
    <div class="W100_100 float-left">
          <p style="margin: 10px 0; text-align: right; padding: 5px">Risultati <?php echo $start ?> - <?php echo $start + $rows - 1 ?> su 
         <?php echo $num ?> per <strong><?php echo $query ?></strong> (<?php echo $qTime ?>ms)</p> 
    <table class="search-results-table">
    <?php $num_item=0 ?>
      
        <?php foreach ($pager->getResults() as $result): ?>
          <?php $num_item=$num_item+1 ?>
          <tr>
         
            <?php if ($result->getInternalPartial()=='parlamentare/searchResult') : ?>
              <td><div class="ico-type"><?php echo image_tag('/images/ico-type-politico.png',array('width' => '44','height' => '42' )) ?></div></td> 
            <?php elseif ($result->getInternalPartial()=='atto/searchResultDoc') : ?>
              <td><div class="ico-type"><?php echo image_tag('/images/ico-type-document.png',array('width' => '44','height' => '42' )) ?></div></td> 
            <?php elseif ($result->getInternalPartial()=='atto/searchResult') : ?>
            <?php if (OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==1 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==12 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==15 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==16 || OppTipoAttoPeer::retrieveByPK($result->tipo_atto_id)->getId()==17) : ?>
              <td><div class="ico-type"><?php echo image_tag('/images/ico-type-proposta.png',array('width' => '44','height' => '42' )) ?></div></td>
            <?php else : ?>
              <td><div class="ico-type"><?php echo image_tag('/images/ico-type-attonoleg.png',array('width' => '44','height' => '42' )) ?></div></td>
            <?php endif ?>    
            <?php elseif ($result->getInternalPartial()=='votazione/searchResult') : ?>
              <td><div class="ico-type"><?php echo image_tag('/images/ico-type-votazione.png',array('width' => '44','height' => '42' )) ?></div></td>
            <?php elseif ($result->getInternalPartial()=='argomento/searchResult') : ?>
              <td><div class="ico-type"><?php echo image_tag('/images/ico-type-etichetta.png',array('width' => '44','height' => '42' )) ?></div></td>
            <?php endif; ?>
          
            <td class="<?php echo (fmod($num_item,2)!=0) ? 'odd' : 'even' ?>">                      

            <?php include_search_result($result, $query, array('num_item'=>$num_item)) ?>
          
          </tr>
        <?php endforeach ?>
      </table>
      <?php echo pager_navigation($pager, "@sf_solr_search_results?query=$query") ?>


    </div>
  </div>
</div>

<?php slot('search') ?>
  <?php include_search_controls($query) ?>
<?php end_slot() ?>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Ricerca per <i><?php echo $query ?></i>
<?php end_slot() ?>



