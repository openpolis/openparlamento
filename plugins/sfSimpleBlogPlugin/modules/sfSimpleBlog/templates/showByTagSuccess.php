<?php use_helper('I18N', 'Date') ?>
<?php $sf_context->getResponse()->setTitle(sfConfig::get('app_sfSimpleBlog_title', 'How is life on earth?')) ?>

<?php if(sfConfig::get('app_sfSimpleBlog_use_feeds', true)): ?>
  <?php slot('auto_discovery_link_tag') ?>
    <?php echo auto_discovery_link_tag('rss', 'sfSimpleBlog/postsForTagFeed?tag='.$sf_params->get('tag'), array('title' => __('Posts tagged "%1%" from %2%', array('%1%' => $sf_params->get('tag'), '%2%' => sfConfig::get('app_sfSimpleBlog_title', 'How is life on earth?'))))) ?>
  <?php end_slot() ?>
<?php endif; ?>

<h3><?php echo __('Posts tagged "%1%"', array('%1%' => $sf_params->get('tag'))) ?></h3>
<span class="sfSimpleBlog">
<?php foreach($post_pager->getResults() as $post): ?>
  <?php include_partial('sfSimpleBlog/post' . (sfConfig::get('app_sfSimpleBlog_use_post_extract', true) ? '_short' : ''), array('post' => $post, 'in_list' => true)) ?>
<?php endforeach; ?>
</span>

<?php if($post_pager->haveToPaginate()): ?>
  <?php if($post_pager->getPage() != 1): ?>
    <?php echo link_to(__('< earlier posts'), 'sfSimpleBlog/showByTag?tag='.$sf_params->get('tag').'page='.$post_pager->getPreviousPage()) ?>
  <?php elseif($post_pager->getPage() != $post_pager->getLastPage()): ?>
    <?php echo link_to(__('older posts >'), 'sfSimpleBlog/showByTag?tag='.$sf_params->get('tag').'page='.$post_pager->getNextPage()) ?>
  <?php endif; ?>
<?php endif; ?>

<?php include_partial('sfSimpleBlog/sidebar') ?>