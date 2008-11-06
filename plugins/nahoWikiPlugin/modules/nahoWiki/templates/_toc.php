<?php if (!isset($i)) $i = 1 ?>

<ul class="wiki-toc-level<?php echo $i ?>">
  <?php foreach ($toc as $title): ?>
    <li class="wiki-toc-level<?php echo $i ?>">
      <?php if (@$title['title']): ?>
        <?php if (@$title['id']): ?><a href="#<?php echo $title['id'] ?>"><?php endif ?><span><?php echo htmlspecialchars($title['title']) ?></span><?php if (@$title['id']): ?></a><?php endif ?>
      <?php endif ?>
      <?php if (count($title['subtitles'])) include_partial('toc', array('toc' => $title['subtitles'], 'i' => $i+1)) ?>
    </li>
  <?php endforeach ?>
</ul>
