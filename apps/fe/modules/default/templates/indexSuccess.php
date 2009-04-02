<?php echo use_helper('DeppNews'); ?>

<div class="float-container" id="content">
   <div id="main">
   home page di openparlamento
        <div class="section-box W52_100 float-right">
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