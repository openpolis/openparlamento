<h3>Filtro per gruppi</h3>
<div id="group_filter" class="multifilter" style="margin-bottom: 1em; margin-top: 10px">
  <form action="" method="post" accept-charset="utf-8">
    <?php foreach ($items as $item): ?>
      <?php $gruppo_id = $item->getOppGruppo()->getId() ?>
      <input name="group_filter[<?php echo $gruppo_id ?>]" 
             value="<?php echo $gruppo_id ?>" 
             id="group_filter_<?php echo $gruppo_id ?>" 
             type="checkbox" 
             <?php if(array_key_exists($gruppo_id, $group_filter)):?>checked="true"<?php endif ?>/>
      <label for="group_filter_<?php echo $gruppo_id ?>">
        <?php echo $item->getOppGruppo()->getAcronimo() ?>&nbsp;
      </label>        
    <?php endforeach ?>

    <input type="image" style="" alt="applica" id="filter-apply" src="/images/btn-applica.png" name="filter-apply">
  </form>    
</div>
