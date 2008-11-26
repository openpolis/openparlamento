<?php use_helper('PagerNavigation', 'DeppNews') ?>

<h2>Tutte le notizie di tipo Home</h2>

Dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>

di <?php echo $pager->getNbResults() ?><br/>


<?php echo pager_navigation($pager, 'news/homeAll', true, 7) ?>


<ul>
<?php foreach ($pager->getResults() as $news): ?>
  <li><?php echo news($news); ?></li>
<?php endforeach ?>
</ul>

<?php echo pager_navigation($pager, 'news/homeAll', true, 7) ?>
