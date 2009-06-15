<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://www.w3.org/2005/10/profile">

<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>

<link rel="icon" type="image/gif" href="/ico_op_32x32.gif" />
</head>

<body>
  <div id="wrapper-800">
    <div id="header">
      <div id="tools" class="float-container">
        <?php include_partial('global/toolsDoc') ?>	  
	    </div>
  	  <div id="navigation">	
       <?php include_partial('global/navigation') ?> 
  	  </div>
    	<?php include_partial('global/breadcrumbs') ?> 
    </div>

	  <?php echo $sf_data->getRaw('sf_content') ?>
	
	  <?php include_partial('global/footer') ?>
  </div>
  <!--
  <script type="text/javascript">jQuery.noConflict();</script>
  -->
  <?php if ($this->getContext()->getRequest()->getHost() == 'parlamento.openpolis.it'): ?>    
    <?php include_partial('global/googleAnalytics') ?>	  
  <?php endif ?>
</body>
</html>
