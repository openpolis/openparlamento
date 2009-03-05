<?php use_helper('I18N') ?>
  
<?php if($nb_comments = $content->getNbPublicComments()): ?>
 <a href="#comment"><?php echo format_number_choice('[1]Leggi anche il commento pubblicato|(1,+Inf]Leggi anche i %1% commenti', 
                                      array('%1%' => $nb_comments), $nb_comments) ?></a>
                                      &nbsp;|&nbsp;
                                      <a href="#leave">lascia il tuo commento</a>
                           
<?php endif; ?>