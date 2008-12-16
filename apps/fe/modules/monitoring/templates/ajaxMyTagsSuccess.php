<li id="ok" style="display:none"><?php echo $remaining_tags ?></li>
<?php foreach ($my_tags as $my_tag): ?>
  <li id="my_tag_<?php echo $my_tag->getId()?>">
    <span class="remover" title="clicca qui per rimuovere questo tag dai tuoi tag">(X)</span>
    <span class="tag" title="clicca qui per visualizzare le notizie relative">
      <?php echo link_to($my_tag->getTripleValue(), '@news_tag?id='.$my_tag->getId()) ?>
    </span>
  </li>
<?php endforeach ?>
