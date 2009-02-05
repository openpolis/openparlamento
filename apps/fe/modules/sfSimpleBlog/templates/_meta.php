<?php if ($sf_user->hasCredential('moderatore')): ?>
  <h2>Gestione</h2>
  <ul class="blog-extra">
  <li><?php echo link_to('Post', 'sfSimpleBlogPostAdmin/index') ?></li>
  <li><?php echo link_to('Commenti', 'sfSimpleBlogCommentAdmin/index') ?></li>
  </ul>
<?php endif; ?>