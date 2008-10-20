<?php use_helper('I18N') ?>
  
<?php if($nb_comments = $content->getNbPublicComments()): ?>
  <h3><?php echo format_number_choice('[1]Un commento fino ad ora|(1,+Inf]%1% commenti fino ad ora', 
                                      array('%1%' => $nb_comments), $nb_comments) ?></h3>
<?php endif; ?>

<ul id="comments-li">
  <?php foreach($content->getPublicComments() as $comm): ?>
    <?php include_partial('deppCommenting/comment', array('comment' => $comm)) ?>
  <?php endforeach; ?>
</ul>

