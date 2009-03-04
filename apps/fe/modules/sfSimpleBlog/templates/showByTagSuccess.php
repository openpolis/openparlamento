<?php use_helper('I18N', 'Date') ?>
<?php $sf_context->getResponse()->setTitle('tag: '.$sf_params->get('tag').' - blog - '.sfConfig::get('app_main_title')) ?>


<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      <?php echo link_to('Blog', '@blog_index') ?>
    </h2>
  </li>
</ul>



<div class="tabbed float-container" id="content">
	<div id="main">
	  <div class="W25_100 float-right">
      <?php include_partial('sfSimpleBlog/sidebar') ?>
	  </div>

    <div class="W73_100 float-left">
     <h4 style="padding: 0px 0px 15px 3px;"><?php echo __('In questa pagina trovi la lista di tutti i post per il tag "%1%"', array('%1%' => $sf_params->get('tag'))) ?></h4>	
     <hr class="blog-comments-separator"/>		

      <ul id="blog-posts-full">
        <?php $cnt = 0;?>
        <?php foreach($post_pager->getResults() as $post): ?>
           <?php include_partial('sfSimpleBlog/postInline', 
                                 array('post' => $post,  
                                       'class_even_odd' => ($cnt%2?'even':'odd'), 
                                       'sf_cache_key' => $post->getId())) ?>
           <?php $cnt++; ?>
        <?php endforeach; ?>
      </ul>

      <?php if($post_pager->haveToPaginate()): ?>
        <?php if($post_pager->getPage() != 1): ?>
          <?php echo link_to(__('< earlier posts'), 'sfSimpleBlog/showByTag?tag='.$sf_params->get('tag').'&page='.$post_pager->getPreviousPage()) ?>
        <?php elseif($post_pager->getPage() != $post_pager->getLastPage()): ?>
          <?php echo link_to(__('older posts >'), 'sfSimpleBlog/showByTag?tag='.$sf_params->get('tag').'&page='.$post_pager->getNextPage()) ?>
        <?php endif; ?>
      <?php endif; ?>

    </div>

    <div class="clear-both"/>			
    </div>		
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('blog', '@blog_index') ?> / 
  tag: "<?php echo $sf_params->get('tag') ?>"
<?php end_slot() ?>
