<?php $comment = $sf_comment ?>
<?php use_helper('Date') ?>
<div<?php if(!$comment->getIsPublic()): ?> class="moderated"<?php endif; ?>>
  <?php echo $comment->getText() ?>
  <br />
  <i><?php echo __('Posted on %2%, by %1% (%11%%12%)', array(
    '%1%'  => $comment->getAuthorName(),
    '%11%' => mail_to($comment->getAuthorEmail()),
    '%12%' => $comment->getAuthorWebsite() ? ', '.link_to($comment->getAuthorWebsite()) : '',
    '%2%'  => format_date($comment->getCreatedAt('U'))
    )) ?>
  </i>
</div>
