<li id="ok" style="display:none"></li>
<?php foreach ($my_tags as $my_tag): ?>
  <li id="my_tag_<?php echo $my_tag->getId()?>">
    <span class="remover" title="clicca qui per rimuovere questo tag dai tuoi tag">(X)</span>
    <span class="tag" title="clicca qui per visualizzare le notizie relative"><?php echo $my_tag->getTripleValue() ?></span>
  </li>
<?php endforeach ?>
