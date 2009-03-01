<?php use_helper('I18N', 'Date') ?>
<?php $sf_context->getResponse()->setTitle(sfConfig::get('app_sfSimpleBlog_title', 'How is life on earth?') . " > Argomento: " . $sf_params->get('tag')) ?>




<div class="tabbed float-container" id="content">
	<div id="main">
	  <div class="W25_100 float-right">
      <?php include_partial('sfSimpleBlog/sidebar') ?>
	  </div>

    <div class="W73_100 float-left">			
      <h2><?php echo __('Posts tagged "%1%"', array('%1%' => $sf_params->get('tag'))) ?></h2>

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

<?php slot('blog_breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  <?php echo link_to('blog', '@blog_index') ?> / 
  Argomento "<?php echo $sf_params->get('tag') ?>"
<?php end_slot() ?>
