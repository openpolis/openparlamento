<?php use_helper('Validation') ?>
<h3><?php echo __('Leave a reply') ?></h3>
<?php echo form_tag('sfSimpleBlog/addComment', 'name=add_comment class=add_comment id=sfSimpleBlog_add_comment_form') ?>
  <?php echo input_hidden_tag('stripped_title', $post->getStrippedTitle()) ?>
  <?php echo input_hidden_tag('date', $post->getPublishedAt()) ?>
  <div class="form_control">
    <?php echo form_error('name') ?>
    <?php echo input_tag('name', '', 'id= class=text') ?>
    <label for="name"><?php echo __('Name (required)') ?></label>
  </div>
  <div class="form_control">
    <?php echo form_error('mail') ?>
    <?php echo input_tag('mail', '', 'id= class=text') ?>
    <label for="mail"><?php echo __('Mail (required) (will not be published)') ?></label>
  </div>
  <div class="form_control">
    <?php echo form_error('website') ?>
    <?php echo input_tag('website', '', 'id= class=text') ?>
    <label for="url"><?php echo __('Website') ?></label>
  </div>
  <div class="form_control">
    <?php echo form_error('content') ?>
    <?php echo textarea_tag('content', '', 'id=') ?>
    <label for="content"></label>
  </div>
  <div class="form_control">
    <?php echo submit_tag(__('Submit comment')) ?>
  </div>
</form>

<?php if(sfConfig::get('app_sfSimpleBlog_use_ajax', true)): ?>
<script>
  document.getElementById('sfSimpleBlog_add_comment_form').onsubmit = function () { 
    new Ajax.Updater(
      'sfSimpleBlog_comment_list',
      document.getElementById('sfSimpleBlog_add_comment_form').action, 
      { parameters: Form.serialize(this), evalScripts: true, encoding: 'UTF-8' }
    ); 
    return false; 
  };  
</script>
<?php endif; ?>