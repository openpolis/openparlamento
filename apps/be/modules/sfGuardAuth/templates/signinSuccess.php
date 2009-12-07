<?php use_helper('Validation', 'I18N') ?>


<div id="content" class="float-container">
  
  <div id="sf_guard_auth_form" style="padding: 100px 0">

    <h1 style="text-align: center">Area riservata Openparlamento</h1>
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
        <div class="form-row" id="sf_guard_auth_remember"  style="margin-left: 10em">
          <?php 
            echo link_to('Hai dimenticato la password?', 
                         'http://' . sfConfig::get('sf_remote_guard_host', 'op_accesso.openpolis.it') .
                         '/userProfile/passwordRequest', 
                         array('id' => 'sf_guard_auth_forgot_password')) 
          ?>
        </div>
      </fieldset>

      <?php echo submit_tag("Entra") ?>
      <?php echo checkbox_tag('remember'); ?>
      <?php echo label_for('remember', 'ricordati di me su questo sito'); ?>
    </form>
  </div>
  
</div>
