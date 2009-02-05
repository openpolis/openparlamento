<?php use_helper('I18N') ?>
<?php if(sfConfig::get('app_sfSimpleBlog_use_ajax', true)): ?>
  <?php use_javascript(sfConfig::get('sf_prototype_web_dir') . '/js/prototype.js') ?>
<?php endif; ?>
<?php $sf_context->getResponse()->setTitle(sfConfig::get('app_sfSimpleBlog_title', 'How is life on earth?').' > '.$post->getTitle()) ?>


<div class="tabbed float-container" id="content">
	<div id="main">
	  <div class="W25_100 float-right">
      <?php include_partial('sfSimpleBlog/sidebar') ?>
	  </div>

    <div class="W73_100 float-left">			
      <!-- post intero -->
      <a name="top"></a>
      <?php include_partial('sfSimpleBlog/post', array('post' => $post, 'in_list' => false)) ?>

      <!-- commenti -->
      <br/>
      <br/>
      <hr class="blog-comments-separator"/>
      <a name="comments"></a>
      <div id="sfSimpleBlog_comment_list">
        <a href="#top" class="go-top">torna su</a>
        <?php if($nb_comments = count($comments)): ?>
          <h3><strong><?php echo format_number_choice('[1]One comment so far|(1,+Inf]%1% comments so far', array('%1%' => $nb_comments), $nb_comments) ?></strong></h3>
        <?php endif; ?>
        <?php include_partial('sfSimpleBlog/comment_list', array('post' => $post, 'comments' => $comments, 'user' => $user)) ?>
      </div>

    </div>

    <div class="clear-both"/>			
    </div>		
  </div>
</div>

<?php slot('blog_breadcrumbs') ?>
  <?php echo link_to("Home", "@homepage") ?> /
  <?php echo link_to('Blog', '@blog_index') ?> / 
  <?php echo $post->getTitle() ?>
<?php end_slot() ?>
