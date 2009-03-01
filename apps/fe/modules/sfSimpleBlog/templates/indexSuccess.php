<?php use_helper('I18N', 'Date') ?>
<?php $sf_context->getResponse()->setTitle(sfConfig::get('app_sfSimpleBlog_title', 'How is life on earth?')) ?>


<div class="tabbed float-container" id="content">
	<div id="main">
	  <div class="W25_100 float-right">
      <?php include_partial('sfSimpleBlog/sidebar') ?>
	  </div>

    <div class="W73_100 float-left">			
      <ul id="blog-posts-full">
        pagina <?php echo $post_pager->getPage() ?> di <?php echo $post_pager->getLastPage() ?>
        <?php foreach($post_pager->getResults() as $cnt => $post): ?>
           <?php include_partial('sfSimpleBlog/postInline', 
                                 array('post' => $post, 'in_list' => true, 
                                       'class_even_odd' => ($cnt%2?'even':'odd'), 'sf_cache_key' => $post->getId())) ?>
        <?php endforeach; ?>
      </ul>


      <?php if($post_pager->haveToPaginate()): ?>
        <?php if($post_pager->getPage() != 1): ?>
          <?php echo link_to(__('< earlier posts'), 'sfSimpleBlog/index?page='.$post_pager->getPreviousPage()) ?>
        <?php elseif($post_pager->getPage() != $post_pager->getLastPage()): ?>
          <?php echo link_to(__('older posts >'), 'sfSimpleBlog/index?page='.$post_pager->getNextPage()) ?>
        <?php endif; ?>
      <?php endif; ?>


    </div>

    <div class="clear-both"/>			
    </div>		
  </div>
</div>

<?php slot('blog_breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  Blog
<?php end_slot() ?>


