<?php

function init_media_library()
{
  sfContext::getInstance()->getResponse()->addJavascript('/sfMediaLibraryPlugin/js/main', 'last');

  return javascript_tag('sfMediaLibrary.init(\''.url_for('sfMediaLibrary/choice').'\')');
}

function object_input_asset_tag($object, $method, $options = array())
{
  $options = _parse_attributes($options);
  $name    = _convert_method_to_name($method, $options);
  $value   = _get_object_value($object, $method);

  return input_asset_tag($name, $value, $options);
}

function input_asset_tag($name, $value, $options = array())
{
  use_helper('Javascript', 'I18N');

  $type = 'all';
  if (isset($options['images_only']))
  {
    $type = 'image';
    unset($options['images_only']);
  }

  $form_name = 'this.previousSibling.previousSibling.form.name';
  if (isset($options['form_name']))
  {
    $form_name = '\''.$options['form_name'].'\'';
    unset($options['form_name']);
  }

  $html = '';

  if (is_file(sfConfig::get('sf_web_dir').$value))
  {
    $ext  = substr($value, strpos($value, '.') - strlen($value) + 1);
    if (in_array($ext, array('png', 'jpg', 'gif')))
    {
      $image_path = $value;
    }
    else
    {
      if (!is_file(sfConfig::get('sf_plugins_dir').'/sfMediaLibraryPlugin/web/images/'.$ext.'.png'))
      {
        $ext = 'unknown';
      }
      $image_path = '/sfMediaLibraryPlugin/images/'.$ext;
    }
    $html .= link_to_function(image_tag($image_path, array('alt' => 'File', 'height' => '64')), "window.open('$value')");
    $html .= '<br />';
  }

  $html .= input_tag($name, $value, $options);
  $html .= '&nbsp;'.image_tag('/sfMediaLibraryPlugin/images/folder_open', array('alt' => __('Insert Image'), 'style' => 'cursor: pointer; vertical-align: middle', 'onclick' => 'sfMediaLibrary.openWindow({ form_name: '.$form_name.', field_name: \''.$name.'\', type: \''.$type.'\', scrollbars: \'yes\' })'));
  $html .= init_media_library();

  return $html;
}
