<?php use_helper('I18N', 'Date') ?>
<?php $sf_context->getResponse()->setTitle('blog - '.sfConfig::get('app_main_title')) ?>

<ul id="content-tabs" class="float-container tools-container">
  <li class="current">
    <h2>
      Blog  
    </h2>
  </li>
</ul>

<div class="row">
	<div class="ninecol">
		
		<ul id="blog-posts-full">
	        pagina <?php echo $post_pager->getPage() ?> di <?php echo $post_pager->getLastPage() ?>
	        <?php foreach($post_pager->getResults() as $cnt => $post): ?>
	           <?php include_partial('sfSimpleBlog/postInline', 
	                                 array('post' => $post, 'in_list' => true, 
	                                       'class_even_odd' => ($cnt%2?'even':'odd'), 'sf_cache_key' => $post->getId())) ?>
	        <?php endforeach; ?>
	      </ul>

	      <?php if($post_pager->haveToPaginate()): ?>
	        <?php if($post_pager->getPage() > 1): ?>
	          <?php echo link_to(__('< earlier posts'), 'sfSimpleBlog/index?page='.$post_pager->getPreviousPage()) ?>
		<?php endif ?>
	        &nbsp;&nbsp;&nbsp;
	        <?php if($post_pager->getPage() < $post_pager->getLastPage()): ?>
	          <?php echo link_to(__('older posts >'), 'sfSimpleBlog/index?page='.$post_pager->getNextPage()) ?>
	        <?php endif; ?>
	      <?php endif; ?>
		
	</div>
	<div class="threecol last">
		
		<?php include_partial('sfSimpleBlog/sidebar') ?>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  blog
<?php end_slot() ?>


