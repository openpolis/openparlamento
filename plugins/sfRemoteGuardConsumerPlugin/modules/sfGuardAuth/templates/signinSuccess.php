<?php use_helper('Validation', 'I18N') ?>

<div id="sf_guard_auth_form">
<?php echo form_tag('@sf_guard_signin') ?>

  <fieldset>

    <div class="form-row" id="sf_guard_auth_username">
      <?php
      echo form_error('username'), 
      label_for('username', __('username:')),
      input_tag('username', $sf_data->get('sf_params')->get('username'));
      ?>
    </div>

    <div class="form-row" id="sf_guard_auth_password">
      <?php
      echo form_error('password'), 
        label_for('password', __('password:')),
        input_password_tag('password');
      ?>
    </div>
    <div class="form-row" id="sf_guard_auth_remember">
      <?php
      echo label_for('remember', __('Remember me?')),
      checkbox_tag('remember');
      ?>
    </div>
  </fieldset>

  <?php 
  echo submit_tag(__('sign in')), 
  link_to(__('Forgot your password?'), '@sf_guard_password', array('id' => 'sf_guard_auth_forgot_password')) 
  ?>
</form>
</div>
