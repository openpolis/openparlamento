<?php echo use_helper('DeppNews'); ?>

<ul class="float-container tools-container" id="content-tabs">
	<li class="current"><h2>Comunit&agrave;</h2></li>
</ul>

<div class="tabbed float-container" id="content">
	<div id="main">
	     <div class="section-box W52_100">
		<a class="section-box-rss" href="#"><img alt="rss" src="images/ico-rss.png"/></a>
		<h3>le ultime attivit&agrave; della comunit&agrave;</h3>
		<ul>
		  <?php foreach ($latest_activities as $activity): ?>
		    <?php $news_text = community_news_text($activity); ?>
		      <?php if ($news_text != ''): ?>
		         <li class="float-container">
			     <div class="date"> <?php echo $activity->getCreatedAt("d/m/Y H:i"); ?></div>							
			     <?php echo $news_text ?>
			  </li>         
                       <?php endif ?>
                      <?php endforeach; ?>
		  </ul>
	       </div>

          </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  le attivit&agrave; della comunit&agrave;
<?php end_slot() ?>