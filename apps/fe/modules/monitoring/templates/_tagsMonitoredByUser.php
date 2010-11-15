<div style="width:48%;">  
  <?php if ($opp_user->getNMonitoredTags()>0): ?>
  	<h5 class="subsection">gli argomenti che stai monitorando 
  	  <?php if (!$sf_user->hasCredential('adhoc')): ?>    	   
      	(ancora <span id="my_remaining_tags"><?php echo $remaining_tags ?></span> a disposizione)
  	  <?php endif ?>
  	</h5>
  <?php else: ?>
    Non stai monitorando nessun argomento
  <?php endif ?>

  <div class="more-results float-container">
    <ul id="my_tags" class="monitoring-list">
      <li id="ok" style="display:none"><?php echo $remaining_tags ?></li>
      <?php foreach ($my_tags as $my_tag_name => $popularity): ?>
        <li title="click per visualizzare le notizie relative"> 
          <?php 
            list($tag, $ns, $key, $value) = deppPropelActAsTaggableToolkit::extractTriple($my_tag_name);
            $tag_id=TagPeer::retrieveByTagname($my_tag_name);
            echo link_to(strtolower($value), '@news_tag?id='.$tag_id->getId(), array('class' => 'folk'.($popularity+3))); 
          ?>
          <?php echo link_to('x', '@removeTagFromMyMonitoredTags?name='.$tag, array('class' => 'ico-stop_monitoring', 'title' => 'smetti di monitorare questo argomento')) ?>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
</div>
