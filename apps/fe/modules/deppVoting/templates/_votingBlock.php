<div>
  <div id="voting-message">
    <?php if ($must_login): ?>
      <ul id="voting-items">
        <li><?php echo link_to(image_tag('btn-voted-yes.png', array('alt' => 'effettua il login per votare')),
                               '@sf_guard_signin') ?></li>
        <li><?php echo link_to(image_tag('btn-voted-no.png', array('alt' => 'effettua il login per votare'),
                               '@sf_guard_signin')) ?></li>
      </ul>
      <br/>
      <?php echo link_to('effettua il login per votare', '@sf_guard_signin') ?>
    <?php else: ?>
      <?php if ($object->hasBeenVotedByUser($user_id)): ?>
        <ul id="voting-items">
          <li><?php echo image_tag(($object->getUserVoting($user_id) == 1?"btn-has-voted-yes.png":"btn-non-voted-yes.png"), 
                                   array('alt' => 'Sono favorevole!')) ?></li>
          <li><?php echo image_tag(
                                   ($object->getUserVoting($user_id) == -1?"btn-has-voted-no.png":"btn-non-voted-no.png"),
                                   array('alt' => 'Sono contrario!')) ?></li>
        </ul>
        <?php echo link_to('Ritira il tuo voto', sprintf('deppVoting/unvoteNoAjax?token=%s', $token), array('post' => true)) ?>
      <?php else: ?>
        <ul id="voting-items">
          <li><?php echo link_to(image_tag("btn-vote-yes.png", array('alt' => 'Sono favorevole!')),
                                 sprintf('deppVoting/voteNoAjax?token=%s&voting=%d', $token, 1),
                                 array('post' => true)
                                ) ?></li>
          <li><?php echo link_to(image_tag("btn-vote-no.png", array('alt' => 'Sono contrario!')),
                                 sprintf('deppVoting/voteNoAjax?token=%s&voting=%d', $token, -1),
                                 array('post' => true)
                                ) ?></li>
        </ul>
      <?php endif ?>

    <?php endif ?>
  </div>
  <div id="voting-results">

    <div id="total-votings" style="margin: 10px 0pt;">
      <?php include_component('deppVoting', 'votingDetails', array('object'  => $object)) ?>   
    </div>

  <div id="closing"></div></div>
</div>

