<?php use_helper('PagerNavigation', 'DeppNews') ?>

<h2>Tutte le notizie di tipo Home</h2>

Ci sono <?php echo $pager->getNbResults() ?> notizie.<br />
Notizie dalla <?php echo $pager->getFirstIndice() ?> alla  <?php echo $pager->getLastIndice() ?>.<br/>


<?php echo pager_navigation($pager, 'news/homeAll', true, 7) ?>


<ul>
<?php foreach ($pager->getResults() as $news): ?>
  <li><?php echo news($news); ?></li>
<?php endforeach ?>
</ul>
