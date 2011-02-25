<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head profile="http://www.w3.org/2005/10/profile">
    <?php if ($this->getContext()->getRequest()->getHost() == 'parlamento.openpolis.it'): ?>    
      <meta name="verify-v1" content="NkhveoVfinSZhsdVK8a+kN89DuYfXmo4BDwljNkry2M=" />
    <?php endif ?>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>

    <link rel="icon" type="image/gif" href="/ico_op_32x32.gif" />
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
    	 
  	  
      	<?php if ($this->getContext()->getModuleName()!='default' || $this->getContext()->getActionName()!='index') include_partial('global/breadcrumbs') ?>
      	 <?php if (!$sf_user->hasCredential('adhoc')): ?>  
      	  <p align="center" style="padding-top:5px;">
            <a href="http://associazione.openpolis.it/contribuisci/diventa-socio"><img id="imgAd" src="https://s3-eu-west-1.amazonaws.com/op-images/frame03.jpg" border=0 /></a>
          </p> 
          <?php endif; ?>
          
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

    <script type="text/javascript">
    jQuery.noConflict();
    (function($) {
      $().ready(function(){
        function rImage() {
            var i = $("#imgAd");
            i.animate({ opacity: 1 }, 5000, function() {
                i.attr('src', 'https://s3-eu-west-1.amazonaws.com/op-images/frame01.jpg');
            }).animate({ opacity: 1 }, 3000, function() {
                i.attr('src', 'https://s3-eu-west-1.amazonaws.com/op-images/frame02.jpg');
            }).animate({ opacity: 1 }, 5000, function() {
                i.attr('src', 'https://s3-eu-west-1.amazonaws.com/op-images/frame03.jpg');
                rImage();
            })
        };
        rImage();        
      })
    })(jQuery);

    //]]>
    </script>
 
  </body>
</html>
