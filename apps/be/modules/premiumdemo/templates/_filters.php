<?php use_helper('Object') ?>

<div class="sf_admin_filters">
<?php echo form_tag('premiumdemo/list', array('method' => 'get')) ?>

  <fieldset>
    <h2><?php echo __('filters') ?></h2>
    <div class="form-row">
    <label for="filters_eta"><?php echo __('Et&agrave;:') ?></label>
    <div class="content">
      <?php echo select_tag('filters[eta]', 
                            options_for_select(OppPremiumDemoPeer::getEtas(), 
                                               isset($filters['eta']) ? $filters['eta'] : null,
                                               array('include_custom' => '-- Seleziona --'))) ?>      
    </div>
    </div>

        <div class="form-row">
    <label for="filters_attivita"><?php echo __('Attivit&agrave;:') ?></label>
    <div class="content">
      <?php echo select_tag('filters[attivita]', 
                            options_for_select(OppPremiumDemoPeer::getAttivitas(), 
                                               isset($filters['attivita']) ? $filters['attivita'] : null,
                                               array('include_custom' => '-- Seleziona --'))) ?>      
    </div>
    </div>

        <div class="form-row">
    <label for="filters_perche"><?php echo __('Perch&egrave; lo usi?:') ?></label>
    <div class="content">
      <?php echo select_tag('filters[perche]', 
                            options_for_select(OppPremiumDemoPeer::getPerches(), 
                                               isset($filters['perche']) ? $filters['perche'] : null,
                                               array('include_custom' => '-- Seleziona --'))) ?>      
    </div>
    </div>

        <div class="form-row">
    <label for="filters_created_at"><?php echo __('Data adesione:') ?></label>
    <div class="content">
    <?php echo input_date_range_tag('filters[created_at]', isset($filters['created_at']) ? $filters['created_at'] : null, array (
  'rich' => true,
  'withtime' => true,
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
)) ?>
    </div>
    </div>

      </fieldset>

  <ul class="sf_admin_actions">
    <li><?php echo button_to(__('reset'), 'premiumdemo/list?filter=filter', 'class=sf_admin_action_reset_filter') ?></li>
    <li><?php echo submit_tag(__('filter'), 'name=filter class=sf_admin_action_filter') ?></li>
  </ul>

</form>
</div>
