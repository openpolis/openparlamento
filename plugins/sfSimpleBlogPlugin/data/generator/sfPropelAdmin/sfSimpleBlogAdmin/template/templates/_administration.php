<h2>[?php echo __('Administration') ?]</h2>
<ul>
  <li>[?php echo link_to(__('Posts'), 'sfSimpleBlogPostAdmin/index') ?]</li>
  <li>[?php echo link_to(__('Comments'), 'sfSimpleBlogCommentAdmin/index') ?]</li>
  [?php if(sfConfig::get('app_sfSimpleBlog_use_media_library', false)): ?]
  <li>[?php echo link_to(__('Media Library'), 'sfMediaLibrary/index') ?]</li>
  [?php endif; ?]
  <li>[?php echo link_to(__('View blog'), 'sfSimpleBlog/index') ?]</li>
</ul>