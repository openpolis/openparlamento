<?php use_helper('Validation') ?>

<!-- flash messages and new comment form -->
<?php if($read_only): ?>
  <div class="related_details"><?php echo __('Comments are closed') ?>.</div>
<?php else: ?>

  <?php echo form_tag('deppCommenting/addComment', 'name=add_comment id=comment-form') ?>
    <h4><?php echo __('Leave a reply') ?></h4>

    <?php echo form_error('name') ?>
    <p>
      <?php echo input_tag('name', $sf_request->hasErrors()?$sf_params->get('name'):($sf_user->isAuthenticated()?(isset($author_name)?$author_name:''):''), 'id= class=text' . ($sf_user->isAuthenticated()?' readonly=true':'')) ?>
      <label for="name"><?php echo __('Your name (at least %1% letters)', array('%1%' => '4')) ?></label>
    </p>

    <?php echo form_error('mail') ?>
    <p>
      <?php echo input_tag('mail', $sf_request->hasErrors()?$sf_params->get('mail'):($sf_user->isAuthenticated()?(isset($author_email)?$author_email:''):''), 'id= class=text'. ($sf_user->isAuthenticated()?' readonly=true':'')) ?>
      <label for="mail">la tua mail (non verr&agrave; pubblicata)</label>
    </p>

    <?php if (!$sf_user->isAuthenticated() && $sf_user->getAttribute('automoderation', '', 'comment') === 'captcha'): ?>
      <?php echo form_error('captcha') ?>
      <p>
        <?php echo input_tag('captcha', $sf_request->hasErrors()?$sf_params->get('captcha'):'', 'id= class=text autocomplete=off'); ?>
        <label for="captcha">scrivi qui le cifre che leggi sotto</label>
      </p>    
      <p style="margin-left: 20px;"><img src="<?php echo url_for('@sf_captcha?rk='.rand()); ?>" alt="captcha" /></p>
    <?php endif ?>

    <?php echo form_error('text') ?>
    <p><label for="text">scrivi il tuo commento</label><br/>      
      <?php echo textarea_tag('text', $sf_request->hasErrors()?$sf_params->get('text'):'', 'id=comment_text size=60x10') ?>   
    </p>
    <p><?php echo image_tag('arrow_mid.png', array('alt'=>'&gt;', 'align'=>'absmiddle')) ?><?php echo submit_tag('INVIA', array('class'=>'btn-submit')) ?></p>
  </form>


  <?php if(sfConfig::get('app_comments_use_ajax', true)): ?>
    <script type="text/javascript" language="javascript">
    //<![CDATA[
    $('comment-form').onsubmit = function () { 
      new Ajax.Updater(
        'comments-block',
        $('comment-form').action, 
        { parameters: Form.serialize(this), evalScripts: true, encoding: 'UTF-8' }
      ); 
      return false; 
    };  
    //]]>
    </script>
  <?php endif; ?>

<?php endif; ?>





