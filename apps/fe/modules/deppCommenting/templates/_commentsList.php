<?php use_helper('I18N') ?>
  
<?php if(isset($show_nb_comments) && $show_nb_comments == true && $nb_comments = $content->getNbPublicComments()): ?>
  <h5 class="description"><?php echo format_number_choice('[1]Un commento finora|(1,+Inf]%1% commenti finora', 
                                      array('%1%' => $nb_comments), $nb_comments) ?>
                                      </h5>
 <p style="text-align: right; margin-right: 6%;"><a href="#leave">lascia il tuo commento</a> | <a class="go-top" href="#top">torna su</a></p>
 <hr class="blog-comments-separator"/>                                     
                           
<?php endif; ?>

<ul id="blog-post-comments">
  <?php foreach($content->getPublicComments() as $comm): ?>
    <?php include_partial('deppCommenting/comment', array('comment' => $comm)) ?>
  <?php endforeach; ?>
</ul>

