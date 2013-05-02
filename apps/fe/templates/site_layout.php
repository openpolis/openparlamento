<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="it"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="it"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="it"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="it"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <?php if ($this->getContext()->getRequest()->getHost() == 'parlamento.openpolis.it'): ?>    
      <meta name="verify-v1" content="NkhveoVfinSZhsdVK8a+kN89DuYfXmo4BDwljNkry2M=" />
    <?php endif ?>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
	
	<?php
	// CANONICAL for _old-s 
	$router = sfRouting::getInstance();
	$currentRouteName = $router->getCurrentRouteName();
	if ( preg_match("/^(.+)_old$/", $currentRouteName, $uriParts ) )
	{
		if ( has_slot('canonical_link') )
		{
			include_slot('canonical_link');
		}
		else
		{
			$newRouteURI = $uriParts[1];
			if ( $router->hasRouteName($newRouteURI) )
			{
				$currentParams = $this->getContext()->getRequest()->extractParameters(array('sort','page','type', 'id', 'slug'));
				echo '<link rel="canonical" href="'.rtrim($this->getContext()->getController()->genUrl('',true),'/'). $router->generate($newRouteURI, $currentParams)   .'" />';
			}
		}
	} 
	if ( has_slot('force_canonical') )
		include_slot('force_canonical');
	?>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- HTML5 ✰ Boilerplate resetter -->
    <link rel="stylesheet" href="/css/reset.css" />

    <!-- 1140px Grid styles for IE -->
    <!--[if lte IE 9]><link rel="stylesheet" href="/css/ie.css" type="text/css" media="screen" /><![endif]-->

    <!-- The 1140px Grid - http://cssgrid.net/ -->
    <link rel="stylesheet" href="/css/1140.css" type="text/css" media="screen" />

    <!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
    <script type="text/javascript" src="/js/css3-mediaqueries.js"></script>

    <!--modernizr-2.0.6.js - http://www.modernizr.com -  is an open-source JavaScript library that helps you build the next generation of HTML5 and CSS3-powered websites. -->
    <script type="text/javascript" src="/js/modernizr-2.0.6.js"></script>

    <link rel="shortcut icon" href="/favicon.ico" />
    
    <!-- social metatag -->
    <?php include_partial('global/social_metas') ?>
    

</head>
<body>

<?php include_partial('global/banner') ?>

<section class="wrapper">
    
    <!-- Main Header -->
    <header class="container">  

        <div class="row">            
            <h1 class="ninecol">
                <a href="/"><img src="/img/logo-openparlamento.png" alt="Titolo" id="logo" /></a>
                <a href="http://openpolis.it"><img src="/img/openpolis-tool.png" alt="OpenPolis" id="op-logo" /></a>
            </h1>           
			<div class="threecol last" id="tools-container">
				<?php include_partial('global/tools') ?>	
			</div>      
        </div>
    </header>
    <!-- /Main Header -->
    
    <!-- Main Navigation -->
    <section id="navigation" class="container">        
        <div class="row">   
            <nav class="ninecol">
                <?php include_partial('global/site_navigation') ?> 
            </nav>

            <section id="search-box" class="threecol last">
                <!-- motore di ricerca generico, contenuto in sfLucene/_controls.php -->
				<?php include_partial('sfSolr/controls', 
				                      array('query' => $this->getContext()->getRequest()->getParameter('query', '')));?>				
            </section>            
        </div>
    </section>
    <!-- /Main Navigation -->

	<?php if ($this->getContext()->getModuleName()!='default' || $this->getContext()->getActionName()!='index') : ?>
		<?php //include_partial('global/breadcrumbs')  ?>
	<?php else : ?>
    <!--  Payoff Container  -->
    <section id="payoff" class="container">   
        <div class="row">
            <div class="twocol">
                <img src="/img/payoff/informati.png" />
                <h1 id="informati">Informati</h1>
                <p>Aggiornamento quotidiano sui lavori del parlamento, da fonti ufficiali (Camera, Senato, Ministero dell’Interno).</p>
            </div>
            <div class="twocol">
                <img src="/img/payoff/monitora.png" />
                <h1 id="monitora">Monitora</h1>
                <p>Scegli quello che ti interessa e ricevi tutti gli aggiornamenti via email.</p>
            </div>
            <div class="twocol">
                <img src="/img/payoff/intervieni.png" />
                <h1 id="intervieni">Intervieni</h1>
                <p>Commenta, proponi e vota gli atti che ti interessano, nella comunità Openpolis.</p>
            </div>
            <div class="sixcol last textright">
                <h1><img src="/img/payoff/slogan_openparlamento.png" alt="Cosa fanno i tuoi parlamentari?" /></h1>
                
                <?php echo use_helper('AdvancedOptionsForSelect') ?>

                <form action="<?php echo url_for('@parlamentari', true); ?>">
                  <fieldset>
                      <select name="type_of" id="selezione-tipo">
                          <option value="camera">Camera</option>
                          <option value="senato">Senato</option>
                      </select>
                      <select name="type_of" id="selezione-circoscrizione">
                          <option value="">Circoscrizione</option>
                      <?php foreach ( $camera_constituencies as $const ) : ?>
                            <option value="<?php echo $const; ?>" class="camera"><?php echo $const; ?></option>
                      <?php endforeach; ?> 
                      <?php foreach ( $senato_constituencies as $const ) : ?>
                            <option value="<?php echo $const; ?>" class="senato"><?php echo $const; ?></option>
                        <?php endforeach; ?> 
                      </select>
                  </fieldset>
                </form>
            </div>
        </div>
    </section>
    <!--  /Payoff Container  -->
    <script type="text/javascript">
        jQuery().ready(function(){

              jQuery("#selezione-circoscrizione").chained("#selezione-tipo").change(function() {
                  var circoscrizione = jQuery(this).val();
                  if ( circoscrizione == '' )
                    return;
                  var base_url = jQuery(this).parents('form').attr('action');
                  var tipo = jQuery('#selezione-tipo').val();
                  if ( tipo == 'senato' )
                    base_url = base_url.replace('/camera/', '/senato/');

                  window.location.replace( base_url + '?filter_const=' + circoscrizione );
              });
          });
    </script>
	<?php endif; ?>
    
    <!--  Main Content -->
    <section id="main" class="container">  
		
		<?php echo $sf_data->getRaw('sf_content') ?>
			
    </section>
    <!--  /Main Content -->


	<?php include_partial('global/site_footer') ?>

	<?php if ($this->getContext()->getRequest()->getHost() == 'parlamento17.openpolis.it'): ?>    
      <?php include_partial('global/googleAnalytics') ?>	  
  <?php endif ?>


    <script type="text/javascript">
      jQuery().ready(function(){
          
        function rImage() {
            var i = jQuery("#imgAd");
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
      });

    </script>

</section></body>
</html>