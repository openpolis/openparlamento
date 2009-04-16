<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>

<link rel="shortcut icon" href="/favicon.ico" />

</head>
<body>
  <div id="wrapper">
    <div id="header">
      <div id="tools" class="float-container">
        <?php include_partial('global/tools') ?>	  
	    </div>
  	  <div id="navigation">	
       <?php include_partial('global/navigation') ?> 
  	  </div>
  	  
    	<?php if ($this->getContext()->getModuleName()!='default') include_partial('global/breadcrumbs') ?> 
    </div>

	  <?php echo $sf_data->getRaw('sf_content') ?>
	
	  <?php include_partial('global/footer') ?>
  </div>
  <!--
  <script type="text/javascript">jQuery.noConflict();</script>
  -->
</body>
</html>
