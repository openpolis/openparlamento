<?php if (count($tags)>0) : ?>
  <em>argomenti omnibus:</em>
<?php else: ?>
  <em>nessun argomento omnibus:</em>
<?php endif ?> 
<?php foreach ($tags as $tag): ?>
  <div id="<?php echo $tag?>" class="omnibus">
    <span class="remover" title="clicca qui per rimuovere questo tag">(X)</span>        
    <span class="tag"><?php echo link_to(strtolower($tag), '@argomento?triple_value='.$tag)?></span>
  </div> &nbsp;
<?php endforeach ?>
