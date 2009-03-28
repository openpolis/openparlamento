<?php echo use_helper('DeppNews'); ?>

<div class="float-container" id="content">
	<div id="main">

	  <div class="W100_100 float-left">
	
	    <h5 class="grey-888">
	      queste le ultime attivit&agrave; della comunit&agrave;:
	    </h5>


    	<div class="more-results float-container">			
    		<ul>
          <?php foreach ($latest_activities as $activity): ?>
            <?php $news_text = community_news_text($activity); ?>
            <?php if ($news_text != ''): ?>
              <li>
                <?php echo $activity->getCreatedAt("d/m/Y H:i"); ?>
                <?php echo $news_text ?>
              </li>              
            <?php endif ?>
          <?php endforeach; ?>
    		</ul>
    	</div>

    </div>

  </div>
</div>

<?php slot('breadcrumbs') ?>
  <?php echo link_to("home", "@homepage") ?> /
  le attivit&agrave; della comunit&agrave;
<?php end_slot() ?>