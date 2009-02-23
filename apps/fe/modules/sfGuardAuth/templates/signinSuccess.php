<?php use_helper('Validation', 'I18N') ?>


<div id="content" class="float-container" style="margin-top: 5px">
  <div id="main" style="padding: 50px 0">
    <div id="sf_guard_auth_form" style="margin: 0">
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
          <div class="form-row" id="sf_guard_auth_remember" style="margin-left: 10em">
            <?php 
              echo link_to('Hai dimenticato la password?', 
                           'http://' . sfConfig::get('app_remote_guard_host') . '/userProfile/passwordRequest', 
                           array('id' => 'sf_guard_auth_forgot_password')) 
            ?>
          </div>
        </fieldset>
        <?php echo submit_tag("Entra") ?>
        <?php echo checkbox_tag('remember'); ?>
        <?php echo label_for('remember', 'ricordati di me su questo sito'); ?>

      </form>
    </div>
    
    <div class="registrati">
        <h2>Non hai una password? Registrati!</h2>
        <br/>
        <strong>Tutti possono registrarsi</strong>, serve meno di un minuto.<br/>

        <br/>
        <div class="bottone"><a href="">registrati!</a></div>
      </div>
    
  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to('Home', '@homepage') ?> /
  Login
<?php end_slot() ?>

