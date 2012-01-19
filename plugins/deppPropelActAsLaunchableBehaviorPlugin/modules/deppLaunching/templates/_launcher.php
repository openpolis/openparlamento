<?php echo use_helper('deppLaunching') ?>

<?php 
if ( empty($options) )
{
	$options = array();
}
	
echo depp_launching_block($object, $namespace, $options) ?>

