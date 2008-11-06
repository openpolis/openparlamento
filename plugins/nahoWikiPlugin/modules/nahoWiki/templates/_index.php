<ul>
<?php foreach ($tree as $name => $elements): ?>
  <li>
  <?php
    if (is_array($elements)) {
      $fullpath = ($base ? $base . ':' : '') . substr($name, 0, -1);
      $class = 'wiki-link-category wiki-link-category-' . (count($elements) ? 'open' : 'closed');
      echo link_to($name, 'nahoWiki/browse?path=' . urlencode($fullpath) . '&' . $uriParams, 'class=' . $class);
      include_partial('index', array('tree' => $elements, 'base' => $fullpath, 'uriParams' => $uriParams));
    } else {
      echo link_to_wiki($name, $elements, 'class=wiki-link-page');
    }
  ?>
  </li>
<?php endforeach ?>
</ul>
