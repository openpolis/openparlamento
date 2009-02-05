<h2><?php echo __('Blogroll') ?></h2>
<ul>
  <?php foreach(sfConfig::get('app_sfSimpleBlog_blogroll', array(
    array('title' => 'how is life on earth?', 'url' => 'http://www.howislifeonearth.com'),
    array('title' => 'google', 'url' => 'http://www.google.com')
  )) as $blog): ?>
  <li><?php echo link_to($blog['title'], $blog['url']) ?></li>
  <?php endforeach; ?>
</ul>