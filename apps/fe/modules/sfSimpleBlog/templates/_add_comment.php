<?php use_helper('Validation') ?>
<a name="leave"></a>
<?php echo form_tag('sfSimpleBlog/addComment', 'name=add_comment id=blog-post-form') ?>
  <h4><?php echo __('Leave a reply') ?></h4>
  <hr />
  <?php echo input_hidden_tag('stripped_title', $post->getStrippedTitle()) ?>
  <?php echo input_hidden_tag('date', $post->getPublishedAt()) ?>

  <?php echo form_error('name') ?>
  <p>
    <?php echo input_tag('name', $sf_request->hasErrors()?$sf_params->get('name'):($sf_user->isAuthenticated()?$user:''), 'id= class=text' . ($sf_user->isAuthenticated()?' readonly=true':'')) ?>
    <label for="name">Il tuo nome (almeno 4 lettere)</label>
  </p>

  <?php echo form_error('mail') ?>
  <p>
    <?php echo input_tag('mail', $sf_request->hasErrors()?$sf_params->get('mail'):($sf_user->isAuthenticated()?$user->getEmail():''), 'id= class=text'. ($sf_user->isAuthenticated()?' readonly=true':'')) ?>
    <label for="mail">la tua mail (non verr&agrave; pubblicata)</label>
  </p>

  <?php if (!$sf_user->isAuthenticated() && sfConfig::get('app_sfSimpleBlog_comment_automoderation', 'first_post') === 'captcha'): ?>
    <?php echo form_error('captcha') ?>
    <p>
      <?php echo image_tag('star.png', array('alt'=>'*')) ?>
      <?php echo input_tag('captcha', $sf_request->hasErrors()?$sf_params->get('captcha'):'', 'id= class=text'); ?>
      <label for="mail">scrivi qui le cifre che leggi sotto</label>
    </p>    
    <p style="margin-left: 20px;"><img src="<?php echo url_for('@sf_captcha'); ?>" alt="captcha" /></p>
  <?php endif ?>
  
  
  <?php echo form_error('content') ?>
  <p><label for="content">scrivi qui sotto il tuo commento</label><br/>      
    <?php echo textarea_tag('content', $sf_request->hasErrors()?$sf_params->get('content'):'', 'id=sfSimpleBlog_comment_content size=60x10') ?>   
  </p>
  <p><?php echo image_tag('arrow_mid.png', array('alt'=>'&gt;', 'align'=>'absmiddle')) ?><?php echo submit_tag('INVIA', array('class'=>'btn-submit')) ?></p>
</form>

<?php if(sfConfig::get('app_sfSimpleBlog_use_ajax', true)): ?>
<script>
  document.getElementById('blog-post-form').onsubmit = function () { 
    new Ajax.Updater(
      'sfSimpleBlog_comment_list',
      document.getElementById('blog-post-form').action, 
      { parameters: Form.serialize(this), evalScripts: true, encoding: 'UTF-8' }
    ); 
    return false; 
  };  
</script>
<?php endif; ?>