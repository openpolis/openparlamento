<?php 
use_helper('Object');

/**
 * Override of the standard objects_for_select, that allows the usage of the 'include_zero_custom' option
 * to insert a custom field returning the 0 value on top of the options
 *
 * @return String
 * @author Guglielmo Celata
 **/
function adv_objects_for_select($options = array(), $value_method, $text_method = null, $selected = null, $html_options = array())
{
  $select_options = array();
  foreach ($options as $option)
  {
    // text method exists?
    if ($text_method && !is_callable(array($option, $text_method)))
    {
      $error = sprintf('Method "%s" doesn\'t exist for object of class "%s"', $text_method, _get_class_decorated($option));
      throw new sfViewException($error);
    }

    // value method exists?
    if (!is_callable(array($option, $value_method)))
    {
      $error = sprintf('Method "%s" doesn\'t exist for object of class "%s"', $value_method, _get_class_decorated($option));
      throw new sfViewException($error);
    }

    $value = $option->$value_method();
    $key = ($text_method != null) ? $option->$text_method() : $value;

    $select_options[$value] = $key;
  }

  return adv_options_for_select($select_options, $selected, $html_options);
}


/**
 * Override of the standard options_for_select, that allows the usage of the 'include_zero_custom' option
 * to insert a custom field returning the 0 value on top of the options
 *
 * @return String
 * @author Guglielmo Celata
 **/
function adv_options_for_select($options = array(), $selected = '', $html_options = array())
{
  $html_options = _parse_attributes($html_options);

  if (is_array($selected))
  {
    $selected = array_map('strval', array_values($selected));
  }

  $html = '';
  if ($value = _get_option($html_options, 'include_zero_custom'))
  {
    $html .= content_tag('option', $value, array('value' => '0'))."\n";
  }
  else if ($value = _get_option($html_options, 'include_custom'))
  {
    $html .= content_tag('option', $value, array('value' => ''))."\n";
  }
  else if (_get_option($html_options, 'include_blank'))
  {
    $html .= content_tag('option', '', array('value' => ''))."\n";
  }

  foreach ($options as $key => $value)
  {
    if (is_array($value))
    {
      $html .= content_tag('optgroup', options_for_select($value, $selected, $html_options), array('label' => $key))."\n";
    }
    else
    {
      $option_options = array('value' => $key);

      if (
          (is_array($selected) && in_array(strval($key), $selected, true))
          ||
          (strval($key) == strval($selected))
         )
      {
        $option_options['selected'] = 'selected';
      }

      $html .= content_tag('option', $value, $option_options)."\n";
    }
  }

  return $html;
}
