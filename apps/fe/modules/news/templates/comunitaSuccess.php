<?php use_helper('PagerNavigation', 'DeppNews') ?>

<div class="row">
	<div class="ninecol">
		
		<div class="monitored_acts monitoring">
			<div class="section-box"><h3 class="section-box-no-rss">Le ultime 100 attivit&agrave; della comunit&agrave;</h3>
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
	<div class="threecol last">
		
		<div class="section-box">
	        <h6>Collegamenti</h6>
	        <div class="float-container">
	          <ul>
	            <li><?php echo link_to('La pagina della comunit&agrave;', '/community') ?></li>
	          </ul>
	        </div>
	      </div>
		
	</div>
</div>

<?php slot('breadcrumbs') ?>
    <?php echo link_to("home", "@homepage") ?> /
    <?php echo link_to("comunit&agrave;", "/community") ?> /
    le ultime 100 attivit&agrave; della comunit&agrave;
<?php end_slot() ?>

