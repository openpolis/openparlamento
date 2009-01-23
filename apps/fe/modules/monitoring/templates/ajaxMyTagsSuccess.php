<li id="ok" style="display:none"><?php echo $remaining_tags ?></li>
<ul id="my_tags" class="monitoring-list">

  <?php foreach ($my_tags as $my_tag_name => $popularity): ?>
    <li title="click per visualizzare le notizie relative">
      <?php 
        list($tag, $ns, $key, $value) = deppPropelActAsTaggableToolkit::extractTriple($my_tag_name);
        echo link_to(strtolower($value), '@news_tag?id=0', array('class' => 'folk'.($popularity+3))); 
      ?>
      <?php echo link_to('x', '#', array('class' => 'ico-stop_monitoring', 'title' => 'smetti di monitorare questo argomento')) ?>
    </li>
  <?php endforeach ?>

</ul>
