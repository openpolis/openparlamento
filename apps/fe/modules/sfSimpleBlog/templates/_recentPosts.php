<?php use_helper('sfSimpleBlog', 'Date') ?>
<?php echo image_tag('gli_ultimi_post_del_blog.png', array('alt'=>'GLI ULTIMI POST DEL BLOG')) ?>
<hr />
<ul id="blog-posts">
  <?php $cnt = 0; ?>
  <?php foreach($post_pager->getResults() as $post): ?>
    <?php $cnt += 1; ?>
    <li>
       pubblicato il <strong><?php echo format_date($post->getPublishedAt('U')) ?></strong> da <br/>
       <strong><?php echo  $post->getAuthor() ?></strong>
       <p class="<?php echo ($cnt%2?'even':'odd')?>">
         <span class="arrow-up"></span>
         <?php echo link_to_post($post) ?>
       </p>
       <!-- e' importante tenere tutto su una sola linea, senza spazi tra i tag -->
       <strong><?php echo format_number_choice('[0] nessun|[1,+Inf] %1%', array('%1%' => $post->getNbComments()), $post->getNbComments()); ?></strong><?php echo image_tag('ico_comment.png', array('alt'=>'&gt;', 'align'=>'baseline')) ?><?php echo link_to_post($post, format_number_choice('[0,1] commento|(1,+Inf] commenti', array(), $post->getNbComments()), $postfix = '#comments'); ?>

    </li>
  <?php endforeach; ?>
</ul>
