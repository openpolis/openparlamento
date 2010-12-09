<?php if ($must_login): ?>
  <?php echo link_to(image_tag('btn-voted-yes.png', array('alt' => 'effettua il login per votare', 'width' => '16', 'height' => '16')),
                               '@sf_guard_signin') ?>
  <?php echo link_to(image_tag('btn-voted-no.png', array('alt' => 'effettua il login per votare', 'width' => '16', 'height' => '16'),
                           '@sf_guard_signin')) ?>
<?php else: ?>
  <?php if ($object->hasBeenVotedByUser($user_id)): ?>
    <?php echo image_tag(($object->getUserVoting($user_id) == 1?"btn-has-voted-yes.png":"btn-non-voted-yes.png"), 
                               array('alt' => 'Sono favorevole!', 'width' => '16', 'height' => '16')) ?>
    <?php echo image_tag(
                               ($object->getUserVoting($user_id) == -1?"btn-has-voted-no.png":"btn-non-voted-no.png"),
                               array('alt' => 'Sono contrario!', 'width' => '16', 'height' => '16')) ?>
    <?php if ($can_unvote): ?>
      <br/>
      <?php echo link_to('ritira il voto', sprintf('deppVoting/unvote?token=%s', $token), array('class' => 'unvote')) ?>      
    <?php endif ?>
  <?php else: ?>
      <?php echo link_to(image_tag("btn-vote-yes.png", array('alt' => 'Sono favorevole!', 'width' => '16', 'height' => '16')),
                             sprintf('deppVoting/vote?token=%s&voting=%d', $token, 1), array('class' => 'voteup')
                            ) ?>
      <?php echo link_to(image_tag("btn-vote-no.png", array('alt' => 'Sono contrario!', 'width' => '16', 'height' => '16')),
                             sprintf('deppVoting/vote?token=%s&voting=%d', $token, -1), array('class' => 'votedn')
                            ) ?>
  <?php endif ?>

<?php endif ?>

