<ul class="menu">
  <?php foreach ($sub_menu_items as $key => $value): ?>
    <li>
    <?php if ($current == $key): ?>
      <?php echo $value ?>
    <?php else: ?>
      <?php echo link_to($value, 'monitoring/'.$key) ?></li>
    <?php endif; ?>
  </li>    
  <?php endforeach ?>
</ul>