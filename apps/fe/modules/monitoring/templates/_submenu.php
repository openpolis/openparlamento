<ul id="content-tabs" class="float-container tools-container">
  <?php foreach ($sub_menu_items as $key => $value): ?>
    <li class="<?php echo ($current == $key?'current':'') ?>">
      <h2>
        <?php echo link_to($value, 'monitoring/'.$key) ?>
      </h2>
  </li>    
  <?php endforeach ?>
</ul>